<?php 

$id_referencia = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id_referencia)) {
    var_dump($id_referencia);
} else {
    echo "Erro: Necessario enviar o Id de referencia <br>";
}

?>