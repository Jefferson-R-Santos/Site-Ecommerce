<?php

define('ACESSO', true);

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

include_once './conexao.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="imagens/icon/favicon.ico" >
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <title>Vizualizar Produto Disponivel</title>
    </head>
    <body>

    <?php include_once 'menu.php'; ?>

        <?php
        $query_products = "SELECT id, nome, descrição , preço, imagem FROM disponiveis WHERE id =:id LIMIT 1";
        $result_disponiveis = $conn->prepare($query_products);
        $result_disponiveis->bindParam(':id', $id, PDO::PARAM_INT);
        $result_disponiveis->execute();
        $row_disponiveis = $result_disponiveis->fetch(PDO::FETCH_ASSOC);
        extract($row_disponiveis);
        $preçoSD = ($preço * 0.50) + $preço ; 
        ?>
        <div class="container">
            <h1 class= "display-4 mt-5 mb-5"> <?php echo $nome; ?> </h1>
        <div class= "row">

            <div class = "col-md-6">
             <img src='<?php echo "imagens/disponiveis/$id/$imagem" ?>' class= "card-img-top">
            </div>
            <div class = "col-md-6">
            <p>De R$ <?php echo number_format($preçoSD, 2, ",", ".");?></p>
            <p>Por R$ <?php echo number_format($preço, 2, ",", ".");?> </p>
            <p><a href ="formulario-compra.php?id=<?php echo $id ; ?>" class = "btn btn-outline-success">Comprar</a></p>
            </div>
        </div>
        <div class = "row">
        <div class ="col-md-12 mt-5">
             <?php echo $descrição ; ?>
        </div>
        </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    </body>
</html>
