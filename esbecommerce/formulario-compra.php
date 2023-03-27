<?php
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
include_once 'conexao';
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
    <?php
        $query_products = "SELECT id, nome, preço, imagem FROM disponiveis WHERE id =:id LIMIT 1";
        $result_disponiveis = $conn->prepare($query_products);
        $result_disponiveis->bindParam(':id', $id, PDO::PARAM_INT);
        $result_disponiveis->execute();
        $row_disponiveis = $result_disponiveis->fetch(PDO::FETCH_ASSOC);
        extract($row_disponiveis);
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
      
      <form>
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
       <input type="text" name= "cpf" id= "cpf" class= "form-control" placeholder="Somente os numeros do CPF" required>

       </div>
       <div class = "col-md-6">

       <label for="cell">Telefone</label>
       <input type="text" name= "cell" id= "cell" class= "form-control" placeholder="Numero de telefone/celular com DDD" required>  
    
    </div>
        </div>
        <div>

        <label for="email">Email</label>
        <input type="email" name= "email" id= "email" class= "form-control" placeholder="Insira seu melhor email" required>  

        </div>

        <button type= "submit" class="btn btn-outline-success">Enviar</button>

      </form>
      </div>
    </div>
</div>
        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    </body>
</html>
