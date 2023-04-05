<?php 
session_start();
ob_start();

include_once '../token.php';


$id_referencia = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id_referencia)) {
include_once './funcao.php';

//Verificar o Status do Pagamento, Salvar no Banco de Dados e recuperar o authorizationId antes do cancelamento da compra
$dados_resultado = statusPagamento($id_referencia);

//var_dump($dados_resultado);

 //iniciar Curl
 $pd = curl_init();

 // URL de requisição picpay
curl_setopt($pd, CURLOPT_URL, "https://appws.picpay.com/ecommerce/public/payments/$id_referencia/cancellations");

//Parametro de resposta da transferencia 
curl_setopt($pd, CURLOPT_RETURNTRANSFER, true);

//Enviar o parametro referente ao SSL
curl_setopt($pd, CURLOPT_SSL_VERIFYPEER, false);

//Informa que requisisão ser através do metodo POST
curl_setopt($pd, CURLOPT_POST, true);

if (isset($dados_resultado->authorizationId)) {

    //Enviar dados para cancelamento 
    $dados_autorizacao = ['authorizationId' => $dados_resultado->authorizationId];

    // Enviar dados da compra
    curl_setopt($pd, CURLOPT_POSTFIELDS, json_encode($dados_autorizacao));

}

// Enviar headers
$headers = [];
$headers [] = 'Content-Type: application/json';
$headers [] = 'x-picpay-token:'. PICPAYTOKEN;
curl_setopt($pd, CURLOPT_HTTPHEADER, $headers);

//Realizar Requisição
$resultado = curl_exec($pd);

//Fechar conexão do curl
curl_close($pd);

//Verificar o Status do Pagamento e Salvar no Banco de Dados
statusPagamento($id_referencia);

$_SESSION ['msg'] = "<div class='alert alert-success' role='alert'>
Pagamento Cancelado Com Sucesso!
</div>";

header("Location: lista-pagamentos.php ");

} else {
    //Mensagem de Erro
    $_SESSION ['msg'] = "<div class='alert alert-danger' role='alert'>
    Erro: Selecione um Pagamento!
   </div>";
   //Redirecionar usuario
      header("Location: lista-pagamentos.php ");
}

?>