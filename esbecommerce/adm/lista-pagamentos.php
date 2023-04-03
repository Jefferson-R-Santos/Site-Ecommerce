<?php 
include_once '../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="../imagens/icon/favicon.ico" >
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

<title>Status de Pagamentos</title>

</head>

<body>

<?php 

include_once './menu.php';

?>

<div class = "container">

<h2 class="display-4 mt-3 mb-3">Status de Pagamentos</h2>

<?php 

$query_pagamentos = "SELECT id, pnome, snome, email, produtod_id, status_pagamento_id FROM clientes ORDER BY id DESC";
$resultado_pagamentos = $conn->prepare($query_pagamentos);
$resultado_pagamentos->execute();
while ($row_pagamento = $resultado_pagamentos->fetch(PDO::FETCH_ASSOC)) {

    var_dump($row_pagamento);
    extract($row_pagamento);
    echo "Nome: $pnome <br> Produto: $produtod_id";

}

?>

</div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</html>