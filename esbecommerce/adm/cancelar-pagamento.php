<?php 
session_start();
ob_start();

include_once '../token.php';

$id_referencia = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id_referencia)) {
include_once './funcao.php';
$dados_resultado = statusPagamento($id_referencia);

var_dump($dados_resultado);

} else {
    //Mensagem de Erro
    $_SESSION ['msg'] = "<div class='alert alert-danger' role='alert'>
    Erro: Selecione um Pagamento!
   </div>";
   //Redirecionar usuario
      header("Location: lista-pagamentos.php ");
}

?>