<?php

$picpaytoken = "";

$referenceId = rand(100000, 999999); 
$callbackUrl = "http://www.sualoja.com.br/callback";
$returnUrl = "http://www.sualoja.com.br/cliente/pedido/";
$valor = 0.50;
$expiresAt = "2023-04-01T16:00:00-03:00";
$nome = "João";
$sobrenome = "Da Silva";
$documentos = "123.456.789-10";
$email = "test@picpay.com";
$celular = "+55 27 12345-6789";

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
var_dump($dados);
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

//Fechar conexão do curl
curl_close($pd);

//Ler o Conteudo da resposta
$dados_resultado = json_decode($resultado);

//Imprimir o conteudo da resposta
var_dump($dados_resultado);

echo "<img src='".$dados_resultado->qrcode->base64."'><br><br>";
echo "Link para pagamento: ".$dados_resultado
?>