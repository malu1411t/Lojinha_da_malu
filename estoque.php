<?php 

// Inicia a sessão (necessário para usar mensagens, login ou controle de acesso)
session_start(); 

// Inclui o arquivo de conexão com o banco de dados
include("conexao.php"); 
// OBS: aqui não está sendo usado diretamente, mas pode ser útil se precisar validar algo futuramente

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<!-- Define a codificação para aceitar acentos (ç, ã, é, etc) corretamente -->

<title>Lojinha da Malu</title>
<!-- Título da página que aparece na aba do navegador -->

<style>

/* Estilo geral da página */
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

/* Cabeçalho superior */
.topo{
    background:linear-gradient(90deg,#c8a2ff,#b58cff);
    color:#fff;
    padding:18px;
    text-align:center;
    font-size:24px;
    font-weight:bold;
}

/* Caixa principal centralizada */
.container{
    width:420px;
    margin:50px auto;
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

/* Agrupamento dos campos */
.campo{
    text-align:left;
    margin-top:12px;
}

/* Labels (nomes dos campos) */
label{
    font-size:14px;
    color:#555;
    font-weight:bold;
}

/* Inputs (caixas de texto) */
input{
    width:100%;
    padding:10px;
    margin-top:5px;
    border-radius:6px;
    border:1px solid #ccc;
    font-size:14px;
}

/* Botão principal */
.botao{
    margin-top:15px;
    width:100%;
    padding:12px;
    background:#c8a2ff;
    color:#fff;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
    font-weight:bold;
    text-decoration:none;
    display:block;
}

/* Efeito ao passar o mouse */
.botao:hover{
    background:#b58cff;
}

/* Botão de voltar (cor diferente) */
.voltar{
    background:#ddd;
    color:#000;
}

/* Hover do botão voltar */
.voltar:hover{
    background:#ccc;
}

</style>
</head>

<body>

<!-- Cabeçalho da página -->
<div class="topo">Lojinha da Malu</div>

<div class="container">

<h2>Cadastrar Produto</h2>
<!-- Título do formulário -->

<!-- Formulário que envia os dados para salvar_estoque.php usando método POST -->
<form action="salvar_estoque.php" method="POST">

<div class="campo">
<label>Produto</label>
<input type="text" name="produto" required>
<!-- Campo para digitar o nome do produto (obrigatório) -->
</div>

<div class="campo">
<label>Quantidade</label>
<input type="number" name="quantidade" min="0" required>
<!-- Campo numérico: impede letras e não permite valores negativos -->
</div>

<div class="campo">
<label>Preço Fornecedor</label>
<input type="number" name="preco_fornecedor" step="0.01" required>
<!-- step="0.01" permite números decimais (ex: 10.50) -->
</div>

<div class="campo">
<label>Preço Venda</label>
<input type="number" name="preco_venda" step="0.01" required>
<!-- Mesmo padrão do preço fornecedor para manter consistência -->
</div>

<!-- Botão que envia o formulário -->
<button class="botao" type="submit">Cadastrar Produto</button>

</form>

<!-- Botão para voltar ao painel principal -->
<a href="painel.php" class="botao voltar">⬅ Voltar</a>

</div>

</body>
</html>