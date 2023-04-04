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

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <symbol id="check-circle-fill" viewBox="0 0 3 3">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
      </symbol>
      <symbol id="info-fill" viewBox="0 0 3 3">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
      </symbol>
      <symbol id="exclamation-triangle-fill" viewBox="0 0 3 3">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
      </symbol>
    </svg>

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
    echo "<td class= 'text-center'><a href = 'statuspagamento.php?id=$id' class= 'btn btn-outline-success'>Status<a/></td>";
    echo "</tr>";
}

?>
</table>
</div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</html>