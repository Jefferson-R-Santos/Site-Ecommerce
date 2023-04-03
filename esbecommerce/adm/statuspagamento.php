<?php 

include_once '../token.php';

include_once '../conexao.php';

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
curl_setopt($pd, CURLOPT_SSL_VERIFYPEER, false);

// Enviar headers
$headers = [];
$headers [] = 'Content-Type: application/json';
$headers [] = 'x-picpay-token:'. PICPAYTOKEN;
curl_setopt($pd, CURLOPT_HTTPHEADER, $headers);

//Realizar Requisição
$resultado = curl_exec($pd);

//Fechar conexão do curl
curl_close($pd);

//Ler o Conteudo da resposta
$dados_resultado = json_decode($resultado);

//Imprimir o conteudo da resposta
//var_dump($dados_resultado);

$query_status_pagamento = "SELECT id sts_id FROM status_pagamento WHERE status = '" . $dados_resultado->status . "' LIMIT 1";
$resultado_status = $conn->prepare($query_status_pagamento);
$resultado_status->execute();



if ($resultado_status->rowCount() != 0) {
  $row_status_pagamento = $resultado_status->fetch(PDO::FETCH_ASSOC); 
  extract($row_status_pagamento);
  //var_dump($status_id);

//Editar a compra informando o status da compra no PicPay para o Banco de Dados
$query_up_pagamento =  "UPDATE clientes SET status_pagamento_id = $sts_id , modificação = NOW() WHERE id = $id_referencia LIMIT 1 ";
$up_status_picpay = $conn->prepare($query_up_pagamento);
$up_status_picpay->execute();

}else {
  echo "Erro: Status não encontrado  <br>";
}




}
 else {
    echo "Erro: Necessario enviar o Id de referencia <br>";
 }



?>