<?php
ob_start();

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
  header("Location: index.php");
  die("Erro: Pagina não encontrada <br>");
}
include_once 'conexao';
include_once './token.php';



  //Pesquisar as informações do produto no Banco de Dados

  $query_products = "SELECT id, nome, preço, imagem FROM disponiveis WHERE id =:id LIMIT 1";
  $result_disponiveis = $conn->prepare($query_products);
  $result_disponiveis->bindParam(':id', $id, PDO::PARAM_INT);
  $result_disponiveis->execute();
  if($result_disponiveis->rowCount() == 0) {
    header("Location: index.php");
  die("Erro: Pagina não encontrada <br>");
  }
  $row_disponiveis = $result_disponiveis->fetch(PDO::FETCH_ASSOC);
  extract($row_disponiveis);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="imagens/icon/favicon.ico" >
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <title>Vizualizar Produto Disponivel</title>
    </head>
    <body>
<?php include_once 'menu.php'; ?>

    <?php
  
        //Receber os Dados do Formulario abaixo
        $cliented = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Acessar If quando o usuario clica no botão
        if (isset( $cliented['BtnPicPay'])) {
            var_dump($cliented);
            $empty_input = false;
            $cliented= array_map('trim', $cliented);
            if (in_array("", $cliented)) {
                //Só é Necessario cso queira tirar o comando required do input
            $empty_input = true;
            $msg = "<div class= 'alert alert-danger' role='alert'>Erro: Necessario preencher todos os campos!</div>";
            } 
            elseif (!filter_var($cliented['email'], FILTER_VALIDATE_EMAIL)) {
                $empty_input = true;
                $msg = "<div class= 'alert alert-danger' role='alert'>Erro: Necessario E-mail Valido!</div>";
            }
        //Acessa o if quando não a erro em nenhum campo do formulario
            if (!$empty_input) {
          //Data para Salvar no Banco de Dados e enviar para o PicPay
          $cliented ['cadastro'] = date('Y-m-d H:i:s');
          $cliented ['vencimento'] = date('Y-m-d H:i:s', strtotime($cliented ['cadastro'].'+3days'));
          $vencimento = date(DATE_ATOM, strtotime($cliented['vencimento']));

            // Salvar dados da compra no Banco de Dados 
          $query_cliente = "INSERT INTO clientes (pnome, snome, cpf, cell, email, expires_at, produtod_id, cadastro) 
           VALUES (:pnome, :snome, :cpf, :cell, :email, :expires_at, :produtod_id, :cadastro)";
           $add_cliente = $conn->prepare($query_cliente);
           $add_cliente->bindParam(":pnome", $cliented['pnome'], PDO::PARAM_STR);
           $add_cliente->bindParam(":snome", $cliented['snome']);
           $add_cliente->bindParam(":cpf", $cliented['cpf']);
           $add_cliente->bindParam(":cell", $cliented['cell']);
           $add_cliente->bindParam(":email", $cliented['email']);
           $add_cliente->bindParam(":expires_at", $cliented['vencimento']);
           $add_cliente->bindParam(":produtod_id", $id);
           $add_cliente->bindParam(":cadastro", $cliented['cadastro']);

           $add_cliente->execute();

           if ($add_cliente->rowCount()) {
           $ultimoid = $conn -> lastInsertId(); 
           $cell_br = str_replace("(", " ", $cliented['cell']);
           $cell_br = str_replace(")", " ", $cell_br);
           $dados = [
            "referenceId" => $ultimoid,
            "callbackUrl"=> CALLBACKURL,
            "returnUrl"=> RETURNURL . $ultimoid,
            "value"=> (double) $preço,
            "expiresAt"=> $vencimento,
            "buyer"=> [ 
              "firstName"=> $cliented['pnome'],
              "lastName"=> $cliented['snome'],
              "document"=> $cliented['cpf'],
              "email"=> $cliented['email'],
              "phone"=> "+55 $cell_br"
             ]
        ]; 
        //iniciar Curl
$pd = curl_init();

// URL de requisição picpay
curl_setopt($pd, CURLOPT_URL, 'https://appws.picpay.com/ecommerce/public/payments');

//Parametro de resposta da transferencia 
curl_setopt($pd, CURLOPT_RETURNTRANSFER, true);

//Enviar o parametro referente ao SSL
curl_setopt($pd, CURLOPT_SSL_VERIFYPEER, false);

// Enviar dados da compra
curl_setopt($pd, CURLOPT_POSTFIELDS, json_encode($dados));

// Enviar headers
$headers = [];
$headers [] = 'Content_Type: application/json';
$headers [] = 'x-picpay-token:'. PICPAYTOKEN;
curl_setopt($pd, CURLOPT_HTTPHEADER, $headers);

//Realizar Requisição
$resultado = curl_exec($pd);

//Fechar conexão do curl
curl_close($pd);

//Ler o Conteudo da resposta
$dados_resultado = json_decode($resultado);

//Imprimir o conteudo da resposta
var_dump($dados_resultado);

if (isset($dados_resultado->code) AND $dados_resultado->code !=200) {
  $msg = "<div class= 'alert alert-danger' role='alert'>Erro: Tente Novamente!</div>";
} else {
  //Editar compra com informações que o picpay retornou
 $query_up_picpay = "UPDATE clientes SET payment_url = '".$dados_resultado->paymentUrl."', qrcode = '".$dados_resultado->qrcode->base64."', modificação = NOW() WHERE id = $ultimoid LIMIT 1";
 $up_picpay = $conn->prepare($query_up_picpay);
 $up_picpay->execute();
  ?>
<!-- Janela Modal com QrCode -->
<div class="modal fade" id="picpay" tabindex="-1" aria-labelledby="picpayLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content text-center">
      <div class="modal-header bg-success text-white">
        <h1 class="modal-title fs-5" id="picpayLabel">QrCode para Pagamento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h1 class="modal-title fs-5" id="picpayLabel">Pague com PicPay escaneando o codigo abaixo</h1>
      <?php 
      
      echo "<img src='".$dados_resultado->qrcode->base64."'><br><br>";

      ?>
      <p class = "lead">Se tiver problemas em escanear o QrCode, tente esse link abaixo</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php
}





          } else {
            $msg = "<div class= 'alert alert-danger' role='alert'>Erro: Necessario E-mail Valido!</div>";
           }
           
           }
        
        }
        
        ?>
    <div class = "container">
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="imagens/logo/Shopping free vector icons designed by Roundicons.png" alt="" width="72" height="72">
                <h2>Formulário de Pagamento</h2>
                <p class="lead">Preencha o formulario abaixo com suas informações para realizar a sua compra.</p>

    </div>
    <div class = "row mb-5">
        <div class = "col-md-8">
<h3> <?php echo $nome ; ?> </h3>
        </div>
        <div class = "col-md-4">
         <div class= "mb-1"> <?php echo number_format($preço, 2, ",", "."); ?> </div>
        </div>
    </div>

    <hr>

    <div class = "row mb-5">
<div class = "col-md-12"> 
    <h4 class = "mb-3"> Informações Pessoais</h4>
      
    <?php 
    if (!empty($msg)) {
        echo $msg;
        $msg = "";
    }
    ?>

      <form method="POST" action="formulario-compra.php?id= <?php echo $id ; ?>">
        <div class ="form-row">
       <div class = "form-group col-md-6">
       
       <label for="pnome">Primeiro Nome</label>
       <input type="text" name= "pnome" id= "pnome" class= "form-control" placeholder="Primeiro Nome" autofocus required>

       </div>
       <div class = "col-md-6">

       <label for="snome">Sobrenome</label>
       <input type="text" name= "snome" id= "snome" class= "form-control" placeholder="Sobrenome" required>  
    
    </div>
        </div>

        <div class ="form-row">
       <div class = "form-group col-md-6">
       
       <label for="cpf">CPF</label>
       <input type="text" name= "cpf" id= "cpf" class= "form-control" placeholder="Somente os numeros do CPF" maxlength="14" oninput="maskCPF(this)" required>

       </div>
       <div class = "col-md-6">

       <label for="cell">Telefone</label>
       <input type="text" name= "cell" id= "cell" class= "form-control" placeholder="Numero de telefone/celular com DDD" maxlength="14" oninput="maskCell(this)" required>  
    
    </div>
        </div>
        <div>

        <label for="email">Email</label>
        <input type="email" name= "email" id= "email" class= "form-control" placeholder="Insira seu melhor email" required>  

        </div>
        

        <button type= "submit" name="BtnPicPay" class="btn btn-outline-success" value="Enviar">Enviar</button>
        

      </form>
      </div>
    </div>
</div>
        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="js/costum.js"></script>

<?php 

if (isset($dados_resultado->paymentUrl)) {
  ?> 
<script>

$(document).ready(function(){
  $('#picpay').modal('show');
});

</script>
<?php 
}

?>

    </body>
</html>
