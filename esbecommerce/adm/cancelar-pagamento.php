<?php 
session_start();
ob_start();

include_once '../token.php';

$id_referencia = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id_referencia)) {
include_once './funcao.php';
$dados_resultado = statusPagamento($id_referencia);

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

    echo "Compra paga <br>";

} else {
    echo "Compra não paga <br>";
}

} else {
    //Mensagem de Erro
    $_SESSION ['msg'] = "<div class='alert alert-danger' role='alert'>
    Erro: Selecione um Pagamento!
   </div>";
   //Redirecionar usuario
      header("Location: lista-pagamentos.php ");
}

?>