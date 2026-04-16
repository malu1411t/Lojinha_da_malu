<?php 
// Inicia a sessão do PHP
// Serve para usar mensagens futuras (erro/sucesso, login etc)
session_start(); 
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!-- Define codificação para suportar acentos -->

<title>Cadastrar Vendedor</title>
<!-- Título da página -->

<style>
/* =============================== */
/* ESTILO DA PÁGINA               */
/* =============================== */

body{
    font-family:Arial;
    /* Fonte padrão */

    margin:0;
    /* Remove margem padrão */

    background:linear-gradient(135deg,#f3ecff,#e9ddff);
    /* Fundo roxo claro */
}

.topo{
    background:linear-gradient(90deg,#c8a2ff,#b58cff);
    /* Gradiente roxo */

    color:#fff;
    /* Texto branco */

    padding:18px;
    /* Espaçamento interno */

    text-align:center;
    /* Centraliza texto */

    font-size:24px;
    /* Tamanho da fonte */

    font-weight:bold;
    /* Negrito */
}

.container{
    width:400px;
    /* Largura do card */

    margin:60px auto;
    /* Centraliza na tela */

    background:#fff;
    /* Fundo branco */

    padding:35px;
    /* Espaçamento interno */

    border-radius:14px;
    /* Bordas arredondadas */

    box-shadow:0 8px 25px rgba(0,0,0,0.1);
    /* Sombra leve */

    text-align:center;
    /* Centraliza conteúdo */
}

h2{
    margin-bottom:20px;
    /* Espaço abaixo */

    color:#6a0dad;
    /* Cor roxa */
}

/* CAMPOS DO FORMULÁRIO */
.campo{
    text-align:left;
    /* Alinha texto à esquerda */

    margin-top:15px;
    /* Espaço entre campos */
}

label{
    font-size:14px;
    /* Tamanho do texto */

    color:#555;
    /* Cor cinza */

    font-weight:bold;
    /* Negrito */
}

input{
    width:100%;
    /* Campo ocupa toda largura */

    padding:12px;
    /* Espaçamento interno */

    margin-top:6px;
    /* Espaço acima */

    border-radius:8px;
    /* Bordas arredondadas */

    border:1px solid #ddd;
    /* Borda cinza clara */

    font-size:14px;
    /* Tamanho da fonte */

    transition:0.2s;
    /* Animação suave */
}

/* efeito ao clicar no input */
input:focus{
    border-color:#cbb2ff;
    /* Muda cor da borda */

    outline:none;
    /* Remove borda padrão */

    box-shadow:0 0 6px rgba(203,178,255,0.5);
    /* Efeito de brilho */
}

/* BOTÃO PRINCIPAL */
.botao{
    margin-top:20px;
    /* Espaço acima */

    width:100%;
    /* Ocupa toda largura */

    padding:12px;
    /* Espaçamento interno */

    background:linear-gradient(90deg,#d8c4ff,#cbb2ff);
    /* Gradiente roxo */

    color:white;
    /* Texto branco */

    border:none;
    /* Remove borda */

    border-radius:8px;
    /* Bordas arredondadas */

    font-size:16px;
    /* Tamanho da fonte */

    cursor:pointer;
    /* Cursor de clique */

    font-weight:bold;
    /* Negrito */

    transition:0.2s;
    /* Animação suave */
}

.botao:hover{
    background:linear-gradient(90deg,#cbb2ff,#bfa2ff);
    /* Muda gradiente ao passar mouse */
}

/* BOTÃO VOLTAR */
.voltar{
    display:block;
    /* Vira bloco */

    margin-top:12px;
    /* Espaço acima */

    padding:10px;
    /* Espaçamento interno */

    background:#eee;
    /* Fundo cinza claro */

    color:#333;
    /* Texto escuro */

    text-decoration:none;
    /* Remove sublinhado */

    border-radius:8px;
    /* Bordas arredondadas */

    font-size:14px;
    /* Tamanho da fonte */
}

.voltar:hover{
    background:#ddd;
    /* Escurece ao passar mouse */
}
</style>
</head>

<body>

<!-- TOPO DA PÁGINA -->
<div class="topo">💜 Lojinha da Malu</div>

<!-- CONTAINER PRINCIPAL -->
<div class="container">

<h2>👤 Cadastrar Vendedor</h2>
<!-- Título da seção -->

<!-- FORMULÁRIO DE CADASTRO -->
<form action="salvar_vendedor.php" method="POST">

<div class="campo">
<label>Nome do Vendedor</label>

<input type="text" name="nome" required>
<!-- Campo obrigatório para nome -->
</div>

<div class="campo">
<label>Total de Vendas</label>

<input type="number" name="vendas" min="0" required>
<!-- Campo numérico para vendas -->
</div>

<button class="botao">Cadastrar</button>
<!-- Botão que envia o formulário -->
</form>

<!-- BOTÃO VOLTAR -->
<a href="painel.php" class="voltar">⬅ Voltar</a>

</div>

</body>
</html>