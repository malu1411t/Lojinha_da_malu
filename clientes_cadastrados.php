<?php
session_start();
include("conexao.php");

// =========================
// 🔒 VERIFICAÇÃO DE LOGIN
// =========================
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

// =========================
// 🔒 VERIFICAÇÃO DE PERMISSÃO
// =========================
$tipo = strtolower(trim($_SESSION['tipo'] ?? ''));
$tipo = preg_replace('/\s+/', '', $tipo);

if ($tipo !== 'adm') {
    $_SESSION['erro'] = "Acesso negado: apenas administradores podem ver esta página.";
    header("Location: cliente.php");
    exit;
}

// =========================
// PESQUISA
// =========================
$pesquisa = $_GET['pesquisa'] ?? '';
$pesquisa_safe = mysqli_real_escape_string($conexao, $pesquisa);

// =========================
// QUERY
// =========================
$sql = "
SELECT cliente.id, cliente.nome, cliente.cpf,
       endereco.rua, endereco.numero, endereco.complemento, endereco.cidade
FROM cliente
INNER JOIN endereco 
    ON cliente.endereco_id = endereco.id
";

if (!empty($pesquisa_safe)) {
    $sql .= " WHERE cliente.nome LIKE '%$pesquisa_safe%' 
              OR cliente.cpf LIKE '%$pesquisa_safe%'";
}

$sql .= " ORDER BY cliente.id DESC";

$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Erro SQL: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Clientes</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
margin:0;
}

.topo{
background:linear-gradient(90deg,#c8a2ff,#b58cff);
color:#fff;
padding:20px;
text-align:center;
font-size:26px;
font-weight:bold;
}

.container{
width:900px;
margin:40px auto;
background:#fff;
padding:30px;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,.15);
}

.pesquisa{
text-align:center;
margin-bottom:15px;
}

.pesquisa input{
padding:10px;
width:250px;
border-radius:6px;
border:1px solid #ccc;
}

.pesquisa button{
padding:10px;
background:#c8a2ff;
color:#fff;
border:none;
border-radius:6px;
cursor:pointer;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th{
background:#c8a2ff;
color:#fff;
padding:12px;
}

td{
padding:10px;
border-bottom:1px solid #ddd;
}

tr:hover{
background:#f3ebff;
}

.acoes{
text-align:center;
margin-top:20px;
}

.botao{
display:inline-block;
padding:10px 15px;
background:#c8a2ff;
color:#fff;
text-decoration:none;
border-radius:6px;
margin:5px;
}

.botao:hover{
background:#b58cff;
}

</style>

</head>
<body>

<div class="topo">Clientes Cadastrados</div>

<div class="container">

<!-- 🔍 PESQUISA -->
<form class="pesquisa" method="GET">

<input type="text" name="pesquisa"
placeholder="Buscar cliente..."
value="<?= htmlspecialchars($pesquisa) ?>">

<button type="submit">Buscar</button>

</form>

<table>

<tr>
<th>ID</th>
<th>Nome</th>
<th>CPF</th>
<th>Rua</th>
<th>Número</th>
<th>Complemento</th>
<th>Cidade</th>
</tr>

<?php while($c = mysqli_fetch_assoc($resultado)): ?>

<tr>
<td><?= $c['id'] ?></td>
<td><?= htmlspecialchars($c['nome']) ?></td>
<td><?= htmlspecialchars($c['cpf']) ?></td>
<td><?= htmlspecialchars($c['rua']) ?></td>
<td><?= htmlspecialchars($c['numero']) ?></td>
<td><?= htmlspecialchars($c['complemento']) ?></td>
<td><?= htmlspecialchars($c['cidade']) ?></td>
</tr>

<?php endwhile; ?>

</table>

<div class="acoes">

<a class="botao" href="cliente.php">➕ Novo Cliente</a>
<a class="botao" href="admin.php">⬅ Painel Administrativo</a>

</div>

</div>

</body>
</html>