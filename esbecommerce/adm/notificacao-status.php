<?php 

include_once '../token.php';
include_once '../conexao.php';

//Receber Cabeçalho 
$resultado_cabecalho = getallheaders();

var_dump($resultado_cabecalho);

//Validar Cabeçalho 

if ((isset($resultado_cabecalho['x-seller-token'])) AND !empty($resultado_cabecalho['x-seller-token'])) {
    if ($resultado_cabecalho['x-seller-token'] == XSELLERTOKEN) {
        echo "Token Recebido é Válido <br>";
    } else {
        echo "Erro: Token Recebido é Inválido <br>";
    }
} else {
    echo "Erro: Token Não Recebido <br>";
}

?>