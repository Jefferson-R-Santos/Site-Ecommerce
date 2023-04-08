<?php 

if (!defined('ACESSO')) {
    header("Location: index.php");
    die("Erro: Pagina Não Encontrada");
}

define('PICPAYTOKEN', "coloque seu token");
define('XSELLERTOKEN', "coloque seu x-seller-token");
define('CALLBACKURL', "http://www.sualoja.com.br/callback");
define('RETURNURL', "http://www.sualoja.com.br/cliente/pedido/");

?>