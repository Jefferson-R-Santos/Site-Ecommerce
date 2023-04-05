<?php 

include_once '../token.php';
include_once '../conexao.php';

$resultado_cabecalho = getallheaders();

var_dump($resultado_cabecalho);
var_dump($resultado_cabecalho['x-seller-token']);

if ((isset($resultado_cabecalho['x-seller-token'])) AND !empty($resultado_cabecalho['x-seller-token'])) {
    if ($resultado_cabecalho['x-seller-token'] == "95b8be0a-c56c-4961-906a-99694cd775f4") {
        echo "Token Recebido é Válido <br>";
    } else {
        echo "Erro: Token Recebido é Inválido <br>";
    }
} else {
    echo "Erro: Token Não Recebido <br>";
}

?>