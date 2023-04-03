<?php
include_once './conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="imagens/icon/favicon.ico" >
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <title>Site Ecommerce</title>
    </head>
    <body>
    <?php include_once 'menu.php'; ?>
        <div class="container">
            <h2 class="display-4 mt-5 mb-5">Produtos Disponiveis</h2>
            <?php
            $query_products = "SELECT id, nome, preço, imagem FROM disponiveis ORDER BY id ASC";
            $result_disponiveis = $conn->prepare($query_products);
            $result_disponiveis->execute();
            ?>
            <div class="row row-cols-1 row-cols-md-3">
                <?php
                while ($row_disponiveis = $result_disponiveis->fetch(PDO::FETCH_ASSOC)) {
                    extract($row_disponiveis);
                    /* echo "<img src='./images/$id/$image'><br>";
                      echo "ID: $id<br>";
                      echo "Nome: $name<br>";
                      echo "Preço: R$ " . number_format($price, 2, ",", ".") . "<br>";
                      echo "<hr>"; */
                    ?>
                    <div class="col mb-4 text-center">
                        <div class="card">
                            <img src='<?php echo "imagens/disponiveis/$id/$imagem"; ?>' class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $nome; ?></h5>
                                <p class="card-text">R$ <?php echo number_format($preço, 2, ",", "."); ?></p>
                                <a href="view-produto.php?id=<?php echo $id; ?>" class="btn btn-primary">Detalhes</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    </body>
</html>
