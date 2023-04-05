<?php 

include_once '../token.php';
include_once '../conexao.php';

//Receber Cabeçalho 
$resultado_cabecalho = getallheaders();

//var_dump($resultado_cabecalho);

//Validar Cabeçalho 

if ((isset($resultado_cabecalho['x-seller-token'])) AND !empty($resultado_cabecalho['x-seller-token'])) {
    if ($resultado_cabecalho['x-seller-token'] == XSELLERTOKEN) {

    //Obter Dados da Requisição
    $conteudo_req = json_decode( file_get_contents("php://input"));
    var_dump($conteudo_req);
    //iniciar Curl
$pd = curl_init();

// URL de requisição picpay
//https://appws.picpay.com/ecommerce/public/payments/{referenceId}/status 
curl_setopt($pd, CURLOPT_URL, "https://appws.picpay.com/ecommerce/public/payments/".$conteudo_req->referenceId."/status");

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

//Salvar no Arquivo "notificacao.txt" durante implementação
//file_put_contents('notificacao.txt', $resultado, FILE_APPEND);

$query_status_pagamento = "SELECT id sts_id FROM status_pagamento WHERE status = '" . $dados_resultado->status . "' LIMIT 1";
$resultado_status = $conn->prepare($query_status_pagamento);
$resultado_status->execute();

if ($resultado_status->rowCount() != 0) { 

    $row_status_pagamento = $resultado_status->fetch(PDO::FETCH_ASSOC); 
    extract($row_status_pagamento);
    //var_dump($status_id);

    //Cadastrar Status da Transação
  if ((isset($dados_resultado->authorizationId)) AND (!empty($dados_resultado->authorizationId) )) {
    $query_transacao = "INSERT INTO transacao_status (authorization_id, status_pagamentos_id, cliente_pagamento_id, created) VALUES ('".$dados_resultado->authorizationId."', $sts_id, ".$conteudo_req->referenceId.", NOW() ) ";
    $add_transacao = $conn->prepare($query_transacao);
    $add_transacao->execute();
  } else {
    $query_transacao = "INSERT INTO transacao_status (status_pagamentos_id, cliente_pagamento_id, created) VALUES ($sts_id, ".$conteudo_req->referenceId.", NOW() ) ";
    $add_transacao = $conn->prepare($query_transacao);
    $add_transacao->execute();
  }

//Editar a compra informando o status da compra no PicPay para o Banco de Dados
$query_up_pagamento =  "UPDATE clientes SET status_pagamento_id = $sts_id , modificação = NOW() WHERE id = ".$conteudo_req->referenceId." LIMIT 1 ";
$up_status_picpay = $conn->prepare($query_up_pagamento);
$up_status_picpay->execute();


}
  
    } else {
        echo "Erro: Token Recebido é Inválido <br>";
    }
} else {
    echo "Erro: Token Não Recebido <br>";
}

?>