<?php 

if (!defined('ACESSO')) {
    header("Location: index.php");
    die("Erro: Pagina Não Encontrada");
}

define('PICPAYTOKEN', "seu token");
define('XSELLERTOKEN', " seu x-seller-token");
define('CALLBACKURL', "http://www.sualoja.com.br/callback");
define('RETURNURL', "http://www.sualoja.com.br/cliente/pedido/");

?>