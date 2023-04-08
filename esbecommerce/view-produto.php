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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <title>Vizualizar Produto Disponivel</title>

        <style>

.accordion {
  max-width: 300px; /* Largura máxima do acordeão */
  margin: 0 auto 0 5px; /* Margens superior e inferior definidas como 0 para centralizar, e margem esquerda definida como 50px para mover para a direita */
}

.accordion-header {
  background-color: #f7f7f7; /* Cor de fundo do cabeçalho */
  padding: 10px; /* Espaçamento interno do cabeçalho */
  border: 1px solid #e5e5e5; /* Borda do cabeçalho */
  border-radius: 5px; /* Borda arredondada do cabeçalho */
  margin-bottom: 10px; /* Espaçamento entre os cabeçalhos */
  cursor: pointer; /* Cursor de ponteiro ao passar o mouse sobre o cabeçalho */
}

.accordion-button {
  color: #333; /* Cor do texto do botão */
}

.accordion-button:focus {
  outline: none; /* Remove o contorno ao clicar no botão */
}

.accordion-button:not(.collapsed) {
  background-color: #e5e5e5; /* Cor de fundo do botão quando expandido */
}

.accordion-body {
  padding: 10px; /* Espaçamento interno do corpo */
  border: 1px solid #e5e5e5; /* Borda do corpo */
  border-top: none; /* Remove a borda superior do primeiro corpo */
  border-radius: 0 0 5px 5px; /* Borda arredondada na parte inferior do corpo */
}

        </style>

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

            <div class="accordion" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><font style="vertical-align: inherit;">
            Clique para ver a descrição.
           </font></button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
          <div class="accordion-body">
            <strong><font style="vertical-align: inherit;">Descrição: </font></strong><font style="vertical-align: inherit;"> <?php echo $descrição ; ?> </font><font style="vertical-align: inherit;">
           </font></div>
        </div>
      </div>

            </div>
        </div>
        <div class = "row">
        <div class ="col-md-12 mt-5">
        
        <!-- Example Code -->
        
    


        </div>
        </div>
        </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    </body>
</html>
