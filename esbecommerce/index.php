<?php

include_once ('conexao');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<title>Esborço de site Ecommerce</title>

</head>
<body>
    <div class="container">
<h1 class = "display-1 mt-5 mb-5">Kami House</h1> <br>

<?php 


$query_disponiveis = "SELECT id, nome, descrição, preço, imagem FROM disponiveis ORDER BY id ASC";
$resultado_disponiveis = $conn -> prepare($query_disponiveis);
$resultado_disponiveis-> execute();
?>
<div class="row row-cols-1 row-cols-md-3">
<?php
while($row_disponiveis = $resultado_disponiveis-> fetch(PDO::FETCH_ASSOC)){

    extract($row_disponiveis);
/*echo "<img src= './imagens/$imagem'><br>";
echo "ID: $id <br>";
echo "Nome: $nome <br>";
echo "Preço: R$". number_format($preço, 2, ",", "."). "<br>";
echo "<hr>";*/
} ?> <div class="col mb-4 text-center">
<div class="card">
    <img src='<?php echo "./imagens/$imagem"; ?>' class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title"><?php echo $name; ?></h5>
        <a href="view-products.php?id=<?php echo $id; ?>" class="btn btn-primary">Detalhes</a>
    </div>
</div>
</div>
<?php


?>

</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>
</html>