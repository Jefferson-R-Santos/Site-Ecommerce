<?php 

session_start();

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

if (isset($_SESSION['msg'])) {

echo $_SESSION['msg'];
unset($_SESSION['msg']);
}

?>

<table class="table table-bordered table-dark table-hover table-striped">

<thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">NOME</th>
      <th scope="col">SOBRENOME</th>
      <th scope="col">EMAIL</th>
      <th scope="col">PRODUTO</th>
      <th scope="col">PRAZO</th>
      <th scope="col" class= "text-center">STATUS</th>
      <th scope="col" class= "text-center">AÇÕES</th>
    </tr>
  </thead>


<?php 

$query_pagamentos = "SELECT clientes.id, clientes.pnome, clientes.snome, clientes.email, clientes.expires_at, disp.nome AS nome_prod, sts.nome AS nome_sts, sts.cor
FROM clientes
LEFT JOIN disponiveis AS disp ON disp.id=clientes.produtod_id
INNER JOIN status_pagamento AS sts ON sts.id=clientes.status_pagamento_id
 ORDER BY clientes.id DESC";
$resultado_pagamentos = $conn->prepare($query_pagamentos);
$resultado_pagamentos->execute();
while ($row_pagamento = $resultado_pagamentos->fetch(PDO::FETCH_ASSOC)) {

    //var_dump($row_pagamento);
    extract($row_pagamento);

    echo "<tr>";
    echo "<th scope='row'>$id</th>";
    echo "<td>$pnome</td>";
    echo "<td>$snome</td>";
    echo "<td>$email</td>";
    echo "<td>$nome_prod</td>";
    echo "<td>$expires_at</td>";
    echo "<td class= 'text-center'><span class='badge badge-pill badge-$cor'>$nome_sts</span>
    </td>";
    echo "<td class= 'text-center'>";
    echo "<a href = 'statuspagamento.php?id=$id' class= 'btn btn-outline-success'>Status<a/>    ";
    echo "<a href = 'cancelar-pagamento.php?id=$id' class= 'btn btn-outline-danger'>Cancelar<a/>";
    echo "</td>";
    echo "</tr>";
}

?>
</table>
</div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</html>