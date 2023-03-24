<?php

include_once ('conexao');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Esborço de site Ecommerce</title>
</head>
<body>
<?php 

echo "<h1>Kami House</h1> <br>";
$query_disponiveis = "SELECT id, nome, descrição, preço FROM disponiveis ORDER BY id ASC";
$resultado_disponiveis = $conn -> prepare($query_disponiveis);
$resultado_disponiveis-> execute();

while ($linha_disponiveis = $resultado_disponiveis-> fetch(PDO::FETCH_ASSOC)) {

    echo "ID: ". $linha_disponiveis['id'].  "<br>";
    echo "NOME: ". $linha_disponiveis['nome'].  "<br>";
    echo "DESCRIÇÃO: ". $linha_disponiveis['descrição'].  "<br>";
    echo "PREÇO: ". $linha_disponiveis['preço'].  "<br>";
    echo "<hr>";

};

?>
</body>
</html>