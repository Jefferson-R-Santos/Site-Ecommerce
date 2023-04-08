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

        <style>
      /* estilo para a div */
      .modal {
        position: fixed;
        top: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background-color: #f2f2f2;
        z-index: 1;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
      }
      
      /* estilo para o botão de fechar o modal */
      .close {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 35px;
        margin-left: 50px;
      }
      
      /* estilo para o conteúdo do modal */
      .modal-content {
        padding: 20px;
      }
      
      /* estilo para a div escura que cobre a página quando o modal é aberto */
      .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
        z-index: 1;
        display: none;
      }
      
      /* estilo para a div que contém a página principal */
      .main {
        margin-right: 300px; /* largura da div do modal */
      }
      
      /* estilo para o botão que abre o modal */
      .open-modal {
        background-color: #4CAF50; /* cor de fundo do botão */
        color: white; /* cor do texto do botão */
        padding: 16px 20px; /* espaçamento interno do botão */
        border: none; /* borda do botão */
        cursor: pointer; /* cursor ao passar o mouse sobre o botão */
        font-size: 16px; /* tamanho do texto do botão */
        position: fixed;
        top: 50%;
        right: 0;
        transform: translate(0, -50%);
        z-index: 1;
      }
      
      /* estilo para o conteúdo da página principal */
      .content {
        padding: 20px;
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
            </div>
        </div>
        <div class = "row">
        <div class ="col-md-12 mt-5">
        

        <div class="main">
      <button class="open-modal">Descrição:</button>
      <div class="content">
        <!-- Conteúdo da página principal aqui -->
      </div>
    </div>

    <!-- div que contém o modal -->
    <div class="modal">
      <span class="close">&times;</span>
      <div class="modal-content">
      <?php echo $descrição ; ?> <!-- Conteúdo do modal aqui -->
      </div>
    </div>
    
    <!-- div que cobre a página quando o modal é aberto -->
    <div class="modal-backdrop"></div>


        </div>
        </div>
        </div>
        </div>

        <script>
      
      // código JavaScript para abrir e fechar o modal
const openModalButton = document.querySelector('.open-modal');
const modal = document.querySelector('.modal');
const modalBackdrop = document.querySelector('.modal-backdrop');
const closeButton = document.querySelector('.close');

// função para abrir o modal
function openModal() {
  modal.style.right = "0";
  modalBackdrop.style.display = "block";
}

// função para fechar o modal
function closeModal() {
  modal.style.right = "-300px"; // largura da div do modal
  modalBackdrop.style.display = "none";
}

// evento de clique no botão que abre o modal
openModalButton.addEventListener('click', openModal);

// evento de clique no botão que fecha o modal
closeButton.addEventListener('click', closeModal);

// evento de clique na div escura que cobre a página quando o modal é aberto
modalBackdrop.addEventListener('click', closeModal);

      
      </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    </body>
</html>
