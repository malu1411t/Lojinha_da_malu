<?php
session_start();
// Inicia a sessão para acessar dados do usuário (se necessário)

include("conexao.php");
// Inclui conexão com o banco de dados

// ===============================
// BUSCAR VENDAS + NOME VENDEDOR
// ===============================

// Consulta SQL que busca todas as vendas
// e também o nome do vendedor relacionado
$sql = "
SELECT vendas.*, vendedor.nome AS vendedor_nome
FROM vendas
LEFT JOIN vendedor ON vendas.vendedor_id = vendedor.id
ORDER BY vendas.id DESC
";

// Executa a query no banco de dados
$resultado = mysqli_query($conexao, $sql);

// Conta quantas vendas foram retornadas
$total = mysqli_num_rows($resultado);
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendas Cadastradas</title>
<!-- Título da página -->

<style>
/* ========================= */
/* ESTILO DA PÁGINA         */
/* ========================= */

body{
    font-family:Arial;
    /* Fonte padrão */

    background:#f4f6f9;
    /* Fundo cinza claro */

    margin:0;
    /* Remove margem padrão */
}

.topo{
    background:linear-gradient(90deg,#c8a2ff,#b58cff);
    /* Gradiente roxo */

    color:#fff;
    /* Texto branco */

    padding:20px;
    /* Espaçamento interno */

    text-align:center;
    /* Centraliza texto */

    font-size:26px;
    /* Tamanho da fonte */

    font-weight:bold;
    /* Negrito */
}

.container{
    width:900px;
    /* Largura da caixa */

    margin:40px auto;
    /* Centraliza na tela */

    background:#fff;
    /* Fundo branco */

    padding:35px;
    /* Espaçamento interno */

    border-radius:12px;
    /* Bordas arredondadas */

    box-shadow:0 5px 15px rgba(0,0,0,.15);
    /* Sombra leve */
}

h2{
    text-align:center;
    /* Centraliza título */

    color:#555;
    /* Cor cinza */
}

/* TABELA */
table{
    width:100%;
    /* Ocupa toda largura */

    border-collapse:collapse;
    /* Remove espaços entre bordas */

    margin-top:20px;
    /* Espaço acima */
}

th{
    background:#c8a2ff;
    /* Fundo roxo */

    color:#fff;
    /* Texto branco */

    padding:12px;
    /* Espaçamento interno */
}

td{
    padding:10px;
    /* Espaçamento interno */

    border-bottom:1px solid #ddd;
    /* Linha separando linhas */

    text-align:center;
    /* Centraliza texto */
}

tr:hover{
    background:#f3ebff;
    /* Efeito ao passar mouse */
}

/* BOTÃO */
.botao{
    display:inline-block;
    /* Permite usar padding e ficar em linha */

    margin-top:20px;
    /* Espaço acima */

    padding:12px 18px;
    /* Espaçamento interno */

    background:#c8a2ff;
    /* Cor roxa */

    color:#fff;
    /* Texto branco */

    text-decoration:none;
    /* Remove sublinhado */

    border-radius:8px;
    /* Bordas arredondadas */

    font-weight:bold;
    /* Negrito */
}

/* MENSAGEM SEM DADOS */
.sem-dados{
    text-align:center;
    /* Centraliza texto */

    padding:40px;
    /* Espaçamento interno */

    color:#666;
    /* Cor cinza */

    font-size:18px;
    /* Tamanho maior */
}
</style>

</head>

<body>

<div class="topo">📊 Vendas Cadastradas</div>
<!-- Cabeçalho da página -->

<div class="container">

<h2>Lista de Vendas</h2>
<!-- Título da seção -->

<?php if($total == 0): ?>
<!-- Verifica se não existem vendas -->

<div class="sem-dados">
❌ Nenhuma venda cadastrada ainda.
<!-- Mensagem quando não há registros -->
</div>

<?php else: ?>
<!-- Se existir vendas, mostra tabela -->

<table>
<tr>
<th>ID</th>
<th>Produto</th>
<th>Quantidade</th>
<th>Preço</th>
<th>Vendedor</th>
</tr>

<?php while($v = mysqli_fetch_assoc($resultado)): ?>
<!-- Loop que percorre todas as vendas -->

<tr>
<td><?= $v['id'] ?></td>
<!-- ID da venda -->

<td><?= htmlspecialchars($v['produto']) ?></td>
<!-- Nome do produto (seguro contra HTML injection) -->

<td><?= $v['quantidade'] ?></td>
<!-- Quantidade vendida -->

<td>R$ <?= number_format($v['preco'],2,',','.') ?></td>
<!-- Preço formatado em reais -->

<td><?= htmlspecialchars($v['vendedor_nome']) ?></td>
<!-- Nome do vendedor vindo do JOIN -->

</tr>

<?php endwhile; ?>
<!-- Fim do loop -->

</table>

<?php endif; ?>
<!-- Fim da condição -->

<a href="painel.php" class="botao">⬅ Voltar</a>
<!-- Botão para voltar ao painel -->

</div>

</body>
</html>