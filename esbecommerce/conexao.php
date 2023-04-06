<?php

if (!defined('ACESSO')) {
    header("Location: index.php");
    die("Erro: Pagina Não Encontrada");
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "produtos";
$port = 3306;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);
    //echo "Conexão com banco de dados realizado com sucesso!<br>";
} catch (Exception $ex) {
    //echo "Erro: Conexão com banco de dados não realizada com sucesso.<br>";
    die("Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador: <br>");
}


?>