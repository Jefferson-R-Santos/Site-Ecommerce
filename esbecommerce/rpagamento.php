<?php

$picpaytoken = "";

//Dados da compra
$dados = [
    "referenceId" => $referenceId,
    "callbackUrl"=> $callbackUrl,
    "returnUrl"=> $returnUrl . $referenceId,
    "value"=> $valor,
    "expiresAt"=> $expiresAt,
    "buyer"=> [ 
      "firstName"=> $nome,
      "lastName"=> $sobrenome,
      "document"=> $documentos,
      "email"=> $email,
      "phone"=> $celular
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
$headers [] = 'x-picpay-token:'. $picpaytoken;
curl_setopt($pd, CURLOPT_HTTPHEADER, $headers);

//Realizar Requisição
$resultado = curl_exec($pd);

//Ler o Conteudo da resposta
$dados_resultado = json_decode($resultado);

//Imprimir o conteudo da resposta


?>