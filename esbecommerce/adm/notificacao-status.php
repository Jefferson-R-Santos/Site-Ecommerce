<?php 

include_once '../token.php';
include_once '../conexao.php';

$resultado_cabecalho = getallheaders();

var_dump($resultado_cabecalho);
var_dump($resultado_cabecalho['x-seller-token']);
?>