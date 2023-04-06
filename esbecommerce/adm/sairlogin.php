<?php 

session_start();

unset($_SESSION ['usuario_id'], $_SESSION ['usuario_nome'], $_SESSION ['usuario_email'], $_SESSION ['usuario_chave']);

$_SESSION['msg'] = "<div class= 'alert alert-success' role='alert'>Deslogado com Sucesso! </div>";
header("Location: index.php");

die("Erro: Pagina Não Encontrada!<br>");

?>