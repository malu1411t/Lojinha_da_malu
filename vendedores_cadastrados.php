<?php
// Inicia a sessão para usar mensagens e controle de acesso
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php"); // Redireciona se não estiver logado
    exit;
}

// Inclui conexão com o banco de dados
include("conexao.php");

// 🔍 Captura o valor digitado na pesquisa (se existir)
$pesquisa = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : '';

// Protege contra SQL Injection básico
$pesquisa_sql = $pesquisa ? mysqli_real_escape_string($conexao, "%$pesquisa%") : '';

// Monta a query com ou sem filtro
$sql = "SELECT * FROM vendedor" .
    ($pesquisa ? " WHERE nome LIKE '$pesquisa_sql' OR id LIKE '$pesquisa_sql'" : "") .
    " ORDER BY id DESC";

// Executa a consulta
$resultado = mysqli_query($conexao, $sql);

// Conta quantos vendedores foram encontrados
$total_vendedores = mysqli_num_rows($resultado);

// Mensagens de feedback
$sucesso = $_SESSION['sucesso'] ?? '';
$erro = $_SESSION['erro'] ?? '';

// Limpa mensagens da sessão após usar
unset($_SESSION['sucesso'], $_SESSION['erro']);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Vendedores</title>

<style>
/* Estilo da página */
body{font-family:Arial;background:#f4f6f9;margin:0;}

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
padding:35px;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,.15);
text-align:center;
}

/* tabela */
table{width:100%;border-collapse:collapse;margin-top:20px;}

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

/* botões */
.botao{
display:inline-block;
padding:10px 20px;
background:#c8a2ff;
color:#fff;
text-decoration:none;
border-radius:8px;
margin-top:20px;
}

.botao:hover{
background:#b58cff;
}
</style>
</head>

<body>

<div class="topo">
👥 Vendedores (<?= $total_vendedores ?>)
<!-- Mostra total de vendedores -->
</div>

<div class="container">

<!-- Mensagem de sucesso -->
<?php if ($sucesso): ?>
<div><?= htmlspecialchars($sucesso) ?></div>
<?php endif; ?>

<!-- Mensagem de erro -->
<?php if ($erro): ?>
<div><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<h2>Lista de Vendedores</h2>

<!-- 🔍 Formulário de pesquisa -->
<form method="GET">
<input type="text" name="pesquisa" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="Buscar vendedor">
<button type="submit">Buscar</button>
</form>

<table>

<tr>
<th>ID</th>
<th>Nome</th>
<th>Total Vendas</th>
<th>Ações</th>
</tr>

<!-- Loop que percorre todos os vendedores -->
<?php while($v = mysqli_fetch_assoc($resultado)): ?>
<tr>
<td><?= $v['id'] ?></td>

<td><?= htmlspecialchars($v['nome']) ?></td>
<!-- htmlspecialchars evita XSS -->

<td><?= $v['quantidade_vendas'] ?></td>
<!-- Aqui mostramos o valor correto do banco -->

<td>
<a href="editar_vendedor.php?id=<?= $v['id'] ?>">Editar</a>
<a href="excluir_vendedor.php?id=<?= $v['id'] ?>">Excluir</a>
</td>

</tr>
<?php endwhile; ?>

</table>

<!-- Botões abaixo da tabela -->
<a class="botao" href="vendedor.php">➕ Novo Vendedor</a>
<a class="botao" href="admin.php">⬅ Painel Administrativo</a>

</div>

</body>
</html>