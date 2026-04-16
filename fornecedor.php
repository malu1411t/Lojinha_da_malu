<?php
// ========================================================
// cadastrar_fornecedor.php - Formulário cadastro fornecedor
// Exibe mensagens + envia dados para salvar_fornecedor.php

// Linha 1: session_start() - Necessário para usar mensagens (sucesso/erro)
session_start();

// Linha 3-4: Recupera mensagens da sessão (flash message)
$erro = $_SESSION['erro'] ?? '';
$sucesso = $_SESSION['sucesso'] ?? '';

// Linha 6: Remove mensagens da sessão após exibir (evita repetir)
unset($_SESSION['erro'], $_SESSION['sucesso']);
?>

<!DOCTYPE html>
<html>
<head>
<title>Cadastrar Fornecedor</title>

<style>
/* Estilo geral da página */
body{font-family:Arial;background:#f4f6f9;margin:0;}

/* Barra superior */
.topo{
    background:linear-gradient(90deg,#c8a2ff,#b58cff);
    color:#fff;
    padding:20px;
    text-align:center;
    font-size:26px;
    font-weight:bold;
}

/* Container central */
.container{
    width:400px;
    margin:50px auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
    text-align:center;
}

/* Inputs */
input{
    width:100%;
    padding:10px;
    margin-top:10px;
    border-radius:6px;
    border:1px solid #ccc;
}

/* Botão principal */
button{
    width:100%;
    padding:12px;
    margin-top:15px;
    background:#c8a2ff;
    color:#fff;
    border:none;
    border-radius:6px;
    font-weight:bold;
}

/* Hover botão */
button:hover{background:#b58cff;}

/* Botão voltar */
.botao{
    display:block;
    margin-top:10px;
    padding:10px;
    background:#ddd;
    text-decoration:none;
    border-radius:6px;
    color:black;
}

/* Mensagem erro */
.msg-erro{
    background:#f8d7da;
    color:#721c24;
    padding:10px;
    border-radius:6px;
    margin-bottom:10px;
}

/* Mensagem sucesso */
.msg-sucesso{
    background:#d4edda;
    color:#155724;
    padding:10px;
    border-radius:6px;
    margin-bottom:10px;
}
</style>

</head>
<body>

<!-- Linha: topo da página -->
<div class="topo">Cadastrar Fornecedor</div>

<div class="container">

<h2>Novo Fornecedor</h2>

<!-- Linha: Exibe erro (com proteção XSS) -->
<?php if($erro): ?>
<div class="msg-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<!-- Linha: Exibe sucesso (com proteção XSS) -->
<?php if($sucesso): ?>
<div class="msg-sucesso"><?= htmlspecialchars($sucesso) ?></div>
<?php endif; ?>

<!-- ===================================================== -->
<!-- FORMULÁRIO - envia dados para salvar_fornecedor.php -->
<!-- ===================================================== -->
<form action="/lojinha_da_malu/salvar_fornecedor.php" method="POST">

<!-- Nome do fornecedor -->
<input type="text" name="nome" placeholder="Nome" required>

<!-- CNPJ -->
<input type="text" name="cnpj" placeholder="CNPJ" required maxlength="18">

<!-- Produto fornecido -->
<input type="text" name="produto" placeholder="Produto" required>

<!-- Quantidade (não permite negativo) -->
<input type="number" name="quantidade" placeholder="Quantidade" min="0" required>

<!-- Preço (aceita decimal) -->
<input type="number" step="0.01" name="preco" placeholder="Preço" min="0" required>

<!-- Botão submit -->
<button type="submit">Cadastrar</button>

</form>

<!-- Botão voltar -->
<a class="botao" href="painel.php">⬅ Voltar</a>

</div>

</body>
</html>