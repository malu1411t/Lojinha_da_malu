<?php

/**
 * estoque_cadastrado.php - Listagem estoque
 * Página que mostra todos os produtos cadastrados no estoque
 */

// Inicia a sessão para controle de login e mensagens
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    // Redireciona se não estiver logado
    exit;
}

// Conexão com banco de dados
include("conexao.php");

// Consulta SQL para listar todos os produtos (do mais recente para o mais antigo)
$sql = "SELECT * FROM estoque ORDER BY id DESC";

// Executa a consulta
$resultado = mysqli_query($conexao, $sql);

// Verifica erro na consulta
if (!$resultado) {
    $_SESSION['erro'] = 'Erro ao carregar estoque.';
    header("Location: admin.php");
    exit;
}

// Recupera mensagens da sessão
$sucesso = $_SESSION['sucesso'] ?? '';
$erro = $_SESSION['erro'] ?? '';

// Limpa mensagens depois de usar
unset($_SESSION['sucesso'], $_SESSION['erro']);

// Conta quantos produtos existem
$total_produtos = mysqli_num_rows($resultado);
?>

<!DOCTYPE html>
<html>
<head>

<title>📦 Estoque Cadastrado - <?= $total_produtos ?> produtos</title>
<!-- Mostra total de produtos no título -->

<style>

/* Estilo geral */
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

/* Cabeçalho */
.topo{
    background:linear-gradient(90deg,#c8a2ff,#b58cff);
    color:#fff;
    padding:20px;
    text-align:center;
    font-size:26px;
    font-weight:bold;
}

/* Container */
.container{
    width:1000px;
    margin:40px auto;
    background:#fff;
    padding:35px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
    text-align:center;
}

/* Título */
h2{
    margin-bottom:20px;
    color:#555;
}

/* Tabela */
table{
    border-collapse:collapse;
    width:100%;
    margin-top:20px;
}

/* Cabeçalho tabela */
th{
    background:#c8a2ff;
    color:#fff;
    padding:15px;
    text-align:left;
    font-weight:bold;
}

/* Linhas tabela */
td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:left;
}

/* Efeito hover */
tr:hover{
    background:#f3ebff;
}

/* Cores do lucro */
.lucro-positivo{
    color:#28a745;
    font-weight:bold;
}

.lucro-negativo{
    color:#dc3545;
    font-weight:bold;
}

/* Botões */
.botao{
    display:inline-block;
    margin-top:20px;
    padding:12px 18px;
    background:#c8a2ff;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
    margin:5px;
}

/* Hover botão */
.botao:hover{
    background:#b58cff;
}

/* Botões editar/excluir */
.editar{
    color:#3b5bdb;
    font-weight:bold;
    text-decoration:none;
    padding:6px 12px;
    border-radius:4px;
    margin-right:5px;
}

.editar:hover{
    background:#e3f2fd;
}

.excluir{
    color:#d11a2a;
    font-weight:bold;
    text-decoration:none;
    padding:6px 12px;
    border-radius:4px;
}

.excluir:hover{
    background:#ffe6e6;
}

/* Mensagens */
.msg-sucesso{
    color:#155724;
    background:#d4edda;
    border:1px solid #c3e6cb;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
}

.msg-erro{
    color:#721c24;
    background:#f8d7da;
    border:1px solid #f5c6cb;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
}

/* Quando não tem dados */
.sem-dados{
    text-align:center;
    padding:60px;
    color:#666;
    font-size:20px;
}

/* Botão maior */
.sem-dados .botao{
    padding:15px 30px;
    font-size:18px;
}

/* Estatísticas */
.stats{
    display:flex;
    justify-content:space-around;
    margin:20px 0;
    background:#f8f9fa;
    padding:20px;
    border-radius:8px;
}

.stat-card{
    background:white;
    padding:20px;
    border-radius:8px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
    flex:1;
    margin:0 10px;
}

</style>

</head>

<body>

<div class="topo">
📦 Estoque Cadastrado (<?= $total_produtos ?> produtos)
</div>
<!-- Cabeçalho mostrando total -->

<div class="container">

<?php if ($sucesso) { ?>
<div class="msg-sucesso">
<?= htmlspecialchars($sucesso) ?>
</div>
<?php } ?>

<?php if ($erro) { ?>
<div class="msg-erro">
<?= htmlspecialchars($erro) ?>
</div>
<?php } ?>
<!-- Exibe mensagens -->

<h2>Lista de Produtos em Estoque</h2>

<?php if ($total_produtos === 0) { ?>
<!-- Caso não tenha produtos -->
<div class="sem-dados">
Nenhum produto em estoque ainda. 
<a href="estoque.php" class="botao">➕ Cadastrar primeiro produto</a>
</div>
<?php } else { ?>

<div class="stats">
<div class="stat-card">
<strong><?= $total_produtos ?></strong><br>
Produtos
</div>
</div>

<table>

<tr>
<th>ID</th>
<th>Quantidade</th>
<th>Preço Fornecedor</th>
<th>Preço Venda</th>
<th>Lucro Unitário</th>
<th>Ações</th>
</tr>

<?php while($linha = mysqli_fetch_assoc($resultado)):

// Calcula lucro (preço venda - preço fornecedor)
$lucro = $linha['preco_venda'] - $linha['preco_fornecedor'];

// Define classe de cor
$lucro_class = $lucro >= 0 ? 'lucro-positivo' : 'lucro-negativo';
?>

<tr>
<td><strong>#<?= $linha['id'] ?></strong></td>
<td><strong><?= $linha['quantidade_calcas'] ?></strong></td>

<td>
R$ <?= number_format($linha['preco_fornecedor'], 2, ',', '.') ?>
</td>
<!-- Formata número para padrão brasileiro -->

<td>
R$ <?= number_format($linha['preco_venda'], 2, ',', '.') ?>
</td>

<td class="<?= $lucro_class ?>">
R$ <?= number_format($lucro, 2, ',', '.') ?>
</td>
<!-- Mostra lucro com cor -->

<td>

<a class="editar" href="editar_estoque.php?id=<?= $linha['id'] ?>">
✏️ Editar
</a>

<a class="excluir" href="excluir_estoque.php?id=<?= $linha['id'] ?>" 
onclick="return confirm('⚠️ Excluir produto #<?= $linha['id'] ?>?\nQuantidade: <?= $linha['quantidade_calcas'] ?> unidades');">
🗑️ Excluir
</a>

</td>
</tr>

<?php endwhile; ?>

</table>

<?php } ?>

<div style="margin-top:30px;">
<a class="botao" href="estoque.php">➕ Novo Produto</a>
<a class="botao" href="admin.php">⬅ Painel Administrativo</a>
</div>

</div>

</body>
</html>