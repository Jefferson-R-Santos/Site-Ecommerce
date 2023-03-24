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


                while ($row_product = $result_products->fetch(PDO::FETCH_ASSOC)) {
                    extract($row_product);
                    /* echo "<img src='./images/$id/$image'><br>";
                      echo "ID: $id<br>";
                      echo "Nome: $name<br>";
                      echo "Preço: R$ " . number_format($price, 2, ",", ".") . "<br>";
                      echo "<hr>"; */  }


?>
</body>
</html>