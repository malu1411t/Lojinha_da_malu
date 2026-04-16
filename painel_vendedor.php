<?php
session_start();
// Inicia a sessão para acessar dados do usuário logado

// 🔥 PROTEÇÃO VENDEDOR
// Aqui é feita a proteção da página
// Se o usuário NÃO estiver logado ou NÃO for vendedor, ele é bloqueado
if(!isset($_SESSION['logado']) || $_SESSION['tipo'] != 'vendedor'){
    header("Location: login.php");
    // Redireciona para a página de login

    exit;
    // Encerra o código para impedir acesso à página
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Painel do Vendedor</title>
<!-- Título da aba do navegador -->

<style>
/* ===================== */
/* ESTILO DO PAINEL */
/* ===================== */

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
    /* Gradiente roxo no topo */

    color:#fff;
    /* Texto branco */

    padding:20px;
    /* Espaçamento interno */

    text-align:center;
    /* Centraliza texto */

    font-size:24px;
    /* Tamanho da fonte */

    font-weight:bold;
    /* Negrito */
}

.container{
    width:600px;
    /* Largura do painel */

    margin:40px auto;
    /* Centraliza na tela */

    background:#fff;
    /* Fundo branco */

    padding:30px;
    /* Espaçamento interno */

    border-radius:10px;
    /* Bordas arredondadas */

    text-align:center;
    /* Centraliza conteúdo */

    box-shadow:0 5px 15px rgba(0,0,0,.1);
    /* Sombra leve */
}

.botao{
    display:block;
    /* Faz botão ocupar linha inteira */

    width:100%;
    /* Largura total */

    padding:12px;
    /* Espaçamento interno */

    margin-top:10px;
    /* Espaço entre botões */

    background:#c8a2ff;
    /* Cor roxa */

    color:#fff;
    /* Texto branco */

    text-decoration:none;
    /* Remove sublinhado */

    border-radius:6px;
    /* Bordas arredondadas */

    font-weight:bold;
    /* Negrito */
}

.botao:hover{
    background:#b58cff;
    /* Muda cor ao passar mouse */
}
</style>

</head>

<body>

<div class="topo">
Painel do Vendedor
</div>
<!-- Cabeçalho da página -->

<div class="container">

<h2>Bem-vindo, <?= $_SESSION['usuario']; ?> 👋</h2>
<!-- Mostra o nome do usuário logado vindo da sessão -->

<a class="botao" href="cliente.php">Cadastrar Cliente</a>
<!-- Botão para cadastro de cliente -->

<a class="botao" href="vendas.php">Registrar Venda</a>
<!-- Botão para registrar venda -->

<br>

<a class="botao" href="logout.php">Sair</a>
<!-- Botão para logout (sair do sistema) -->

</div>

</body>
</html>