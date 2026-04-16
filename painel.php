<?php
session_start();
// Inicia a sessão para acessar dados do usuário logado

if (!isset($_SESSION['logado'])) {
    // Verifica se o usuário NÃO está logado

    header("Location: /lojinha_da_malu/login.php");
    // Se não estiver logado, redireciona para a tela de login

    exit();
    // Encerra o script para evitar acesso indevido
}

$tipo = $_SESSION['tipo'];
// Armazena o tipo do usuário (ex: adm ou vendedor)
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!-- Define codificação para suportar acentos -->

<title>Painel</title>
<!-- Título da página -->

<style>
/* ======================= */
/* ESTILIZAÇÃO DO PAINEL */
/* ======================= */

body{
    font-family: Arial;
    /* Fonte padrão */

    margin:0;
    /* Remove margem padrão */

    background:#f5f3ff;
    /* Fundo roxo bem claro */
}

/* TOPO */
.topo{
    background:#c4b5fd;
    /* Cor roxa clara */

    color:#4c1d95;
    /* Texto roxo escuro */

    padding:18px;
    /* Espaçamento interno */

    text-align:center;
    /* Centraliza texto */

    font-size:22px;
    /* Tamanho da fonte */

    font-weight:bold;
    /* Negrito */
}

/* CONTAINER */
.container{
    width:500px;
    /* Largura do painel */

    margin:50px auto;
    /* Centraliza na tela */

    background:white;
    /* Fundo branco */

    padding:30px;
    /* Espaçamento interno */

    border-radius:14px;
    /* Bordas arredondadas */

    box-shadow:0 6px 15px rgba(0,0,0,0.1);
    /* Sombra leve */
}

/* TITULO */
h2{
    text-align:center;
    /* Centraliza título */

    color:#6b21a8;
    /* Cor roxa */
}

/* SEÇÃO */
.secao{
    margin-top:25px;
    /* Espaço entre blocos */
}

/* BOTÕES */
.botao{
    display:block;
    /* Faz botão ocupar linha inteira */

    padding:12px;
    /* Espaçamento interno */

    margin-top:10px;
    /* Espaço entre botões */

    background:#e9d5ff;
    /* Fundo roxo claro */

    color:#000;
    /* Texto preto */

    text-decoration:none;
    /* Remove sublinhado */

    border-radius:8px;
    /* Bordas arredondadas */

    text-align:center;
    /* Centraliza texto */

    font-weight:bold;
    /* Negrito */

    border:1px solid #ddd;
    /* Borda leve */

    transition:0.2s;
    /* Animação suave */
}

.botao:hover{
    background:#d8b4fe;
    /* Muda cor ao passar mouse */
}

/* ADMIN */
.admin .botao{
    background:#c4b5fd;
    /* Cor diferente para área admin */
}

.admin .botao:hover{
    background:#a78bfa;
    /* Hover do admin */
}

/* SAIR */
.sair{
    margin-top:25px;
    /* Espaço acima */
}

.sair .botao{
    background:#eee;
    /* Botão sair cinza */
}

.sair .botao:hover{
    background:#ddd;
    /* Hover do botão sair */
}
</style>

</head>

<body>

<div class="topo">💜 Lojinha da Malu</div>
<!-- Cabeçalho do sistema -->

<div class="container">

<h2>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
<!-- Mostra o nome do usuário logado de forma segura -->

<?php if ($tipo == 'adm'): ?>
<!-- Se o usuário for ADMIN, mostra área completa -->

<div class="secao">
<h3>Cadastros</h3>

<a class="botao" href="/lojinha_da_malu/cliente.php">Cadastrar Cliente</a>
<a class="botao" href="/lojinha_da_malu/fornecedor.php">Cadastrar Fornecedor</a>
<a class="botao" href="/lojinha_da_malu/vendedor.php">Cadastrar Vendedor</a>
<a class="botao" href="/lojinha_da_malu/estoque.php">Cadastrar Produto</a>

</div>

<div class="secao">
<h3>Vendas</h3>

<a class="botao" href="/lojinha_da_malu/vendas.php">Registrar Venda</a>
<a class="botao" href="/lojinha_da_malu/vendas_cadastradas.php">Ver Vendas</a>

</div>

<div class="secao admin">
<h3>Administração</h3>

<a class="botao" href="/lojinha_da_malu/admin.php">Painel Administrativo</a>

</div>

<?php elseif ($tipo == 'vendedor'): ?>
<!-- Se for VENDEDOR, mostra área limitada -->

<div class="secao">
<h3>Vendas</h3>

<a class="botao" href="/lojinha_da_malu/cliente.php">Cadastrar Cliente</a>
<a class="botao" href="/lojinha_da_malu/vendas.php">Registrar Venda</a>

</div>

<?php endif; ?>

<div class="sair">
<!-- Área de logout -->

<a class="botao" href="/lojinha_da_malu/logout.php">Sair</a>
<!-- Botão para sair do sistema -->

</div>

</div>

</body>
</html>