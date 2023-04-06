<?php

if (!defined('ACESSO')) {
    header("Location: index.php");
    die("Erro: Pagina Não Encontrada");
}

if ((!isset($_SESSION ['usuario_id'])) OR (!isset($_SESSION ['usuario_email'])) OR (!isset($_SESSION ['usuario_chave']))) {
unset($_SESSION ['usuario_id'], $_SESSION ['usuario_nome'], $_SESSION ['usuario_email'], $_SESSION ['usuario_chave']);

$_SESSION['msg'] = "<div class= 'alert alert-danger' role='alert'>Erro: Necessario Realizar Login para acessar! </div>";
header("Location: index.php");
die("Erro: Pagina Não Encontrada!<br>");
}

?>