<?php 

include_once '../token.php';

$id_referencia = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id_referencia)) {
    var_dump($id_referencia);

    //iniciar Curl
$pd = curl_init();

// URL de requisição picpay
curl_setopt($pd, CURLOPT_URL, "https://appws.picpay.com/ecommerce/public/payments/$id_referencia/status");

//Parametro de resposta da transferencia 
curl_setopt($pd, CURLOPT_RETURNTRANSFER, true);

//Enviar o parametro referente ao SSL
curl_setopt($pd, CURLOPT_SSL_VERIFYPEER, true);

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

if ($dados_resultado->status == "created") {
    $status_id = 2;   
}

//Editar a compra informando o status da compra no PicPay para o Banco de Dados
$query_up_picpay = "UPDATE clientes SET status_pagamento_id = $status_id, modificação = NOW() WHERE id = $id_referencia LIMIT 1";

$conn->prepare($query_up_picpay );

} else {
    echo "Erro: Necessario enviar o Id de referencia <br>";
}



?>