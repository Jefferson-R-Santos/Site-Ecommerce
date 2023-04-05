<?php 
session_start();
ob_start();

$id_referencia = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id_referencia)) {
echo "Id de referencia: $id_referencia <br>";
} else {
    //Mensagem de Erro
    $_SESSION ['msg'] = "<div class='alert alert-danger' role='alert'>
    Erro: Selecione um Pagamento!
   </div>";
   //Redirecionar usuario
      header("Location: lista-pagamentos.php ");
}

?>