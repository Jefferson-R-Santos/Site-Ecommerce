<?php 

include_once '../conexao.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="../imagens/icon/favicon.ico" >
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" href="css/login.css">

<title> E-commerce Login</title>

</head>

<body>
    
<?php 
//Criptografar Senha
//$senha_criptografada = password_hash("abdefg", PASSWORD_DEFAULT);
//echo $senha_criptografada;

//Receber dados do formulario
$dadoslogin= filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Variavel para receber mensagem de Erro ou Sucesso.
$msg = "";

//Acessar o IF quando o usuario clica no botão
if (isset($dadoslogin['btnlogin'])) {
    $empty_input = false;
            $dadoslogin= array_map('trim', $dadoslogin);
            if (in_array("", $dadoslogin)) {
                //Só é Necessario cso queira tirar o comando required do input
            $empty_input = true;
            $msg = "<div class= 'alert alert-danger' role='alert'>Erro: Necessario preencher todos os campos!</div>";
            } 
            elseif (!filter_var($dadoslogin['email'], FILTER_VALIDATE_EMAIL)) {
                $empty_input = true;
                $msg = "<div class= 'alert alert-danger' role='alert'>Erro: Necessario E-mail Valido!</div>";
            } 
//Acessa o if quando não a erro em nenhum campo do formulario
if (!$empty_input) {
 
//Pesquisar usuario no Banco de dados
$query_usuario = "SELECT id, nome, senha FROM  usuarios WHERE email=:email LIMIT 1";
$result_usuario = $conn->prepare($query_usuario);
$result_usuario->bindParam(':email', $dadoslogin['email']);
$result_usuario->execute();

if ($result_usuario->rowCount() != 0) {
  //$msg = "<div class= 'alert alert-success' role='alert'> E-mail Encontrado!</div>";

  $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

  //Verificar Senha
  if (password_verify($dadoslogin['senha'] , $row_usuario['senha'])) {
    $msg = "<div class= 'alert alert-success' role='alert'> Senha Encontrada!</div>";  
  }else {
    $msg = "<div class= 'alert alert-danger' role='alert'>Erro: Usuario ou Senha Invalido!</div>";  
  }

}else {
  $msg = "<div class= 'alert alert-danger' role='alert'>Erro: Usuario ou Senha Invalido!</div>";  
}
}
}

?>

<main class="form-signin w-100 m-auto">
  <form method="POST" action="" class="form-signin">
  <div class="text-center mb-4">
    <img class=" text-lg-center mb-4" src="../imagens/logo/Shopping free vector icons designed by Roundicons.png" alt="" width="72" height="72">
    </div>
    <h1 class="h3 mb-3 fw-normal text-center">Admnistrador.</h1>

    <?php 
    
    if (!empty($msg)) {

     echo $msg;
     $msg = "";

    }
    
    ?>

    <div class="form-floating">
    <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" value="<?php  if (isset($dadoslogin['email'])) { echo $dadoslogin['email']; } ?>" required autofocus>
      
    </div>
    <div class="form-floating">
    <input type="password" class="form-control" name="senha" id="senha" placeholder="Insira sua Senha" value="<?php  if (isset($dadoslogin['senha'])) { echo $dadoslogin['senha']; } ?>" required >
      
    </div>

    <button class="w-100 btn btn-lg btn-success" type="submit" name="btnlogin" value="btnlogin" >Entrar</button>

  </form>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>