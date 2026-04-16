<?php 
// Inicia a sessão para usar mensagens (sucesso/erro)
session_start();
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<!-- Define a codificação para suportar acentos -->

<title>Lojinha da Malu</title>

<style>
/* Estilo geral da página */
body{
    font-family: Arial;
    margin:0;
    background:#e5e7eb;
}

/* CONTAINER CENTRAL */
.container{
    width:420px;
    margin:60px auto;
    background:#f3f4f6;
    padding:30px;
    border-radius:16px;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}

/* TÍTULO */
h2{
    text-align:center;
    color:#444;
    margin-bottom:20px;
}

/* CAMPOS DO FORMULÁRIO */
.campo{
    margin-top:15px;
}

label{
    font-weight:bold;
    color:#555;
}

/* Inputs */
input{
    width:100%;
    padding:12px;
    margin-top:6px;
    border-radius:8px;
    border:1px solid #ccc;
    background:#fff;
}

/* BOTÃO PRINCIPAL */
.botao{
    margin-top:20px;
    width:100%;
    padding:12px;
    background:linear-gradient(90deg,#b794f4,#a78bfa);
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    font-weight:bold;
}

/* Efeito ao passar o mouse */
.botao:hover{
    opacity:0.9;
}

/* BOTÃO VOLTAR */
.voltar{
    margin-top:10px;
    background:#ddd;
    color:#333;
    text-decoration:none;
    display:block;
    text-align:center;
}

/* MENSAGENS DE SUCESSO */
.msg-sucesso{
    background:#c6e3cf;
    color:#1b5e20;
    padding:12px;
    border-radius:10px;
    margin-bottom:15px;
    text-align:center;
}

/* MENSAGENS DE ERRO */
.msg-erro{
    background:#f8d7da;
    color:#721c24;
    padding:12px;
    border-radius:10px;
    margin-bottom:15px;
    text-align:center;
}
</style>

</head>

<body>

<div class="container">

<h2>Cadastrar Cliente</h2>

<!-- Mensagem de sucesso -->
<?php if(isset($_SESSION['sucesso'])): ?>
<div class="msg-sucesso">
<?= htmlspecialchars($_SESSION['sucesso']); unset($_SESSION['sucesso']); ?>
</div>
<!-- Exibe mensagem de sucesso e depois remove da sessão -->
<?php endif; ?>

<!-- Mensagem de erro -->
<?php if(isset($_SESSION['erro'])): ?>
<div class="msg-erro">
<?= htmlspecialchars($_SESSION['erro']); unset($_SESSION['erro']); ?>
</div>
<!-- Exibe mensagem de erro e depois remove da sessão -->
<?php endif; ?>

<!-- Formulário -->
<form action="/lojinha_da_malu/salvar_cliente.php" method="POST">
<!-- Envia os dados para o arquivo que salva no banco -->

<div class="campo">
<label>Nome</label>
<input type="text" name="nome" required>
<!-- Campo obrigatório para nome -->
</div>

<div class="campo">
<label>CPF</label>
<input type="text" name="cpf" required>
<!-- Campo obrigatório para CPF -->
</div>

<div class="campo">
<label>Rua</label>
<input type="text" name="rua" required>
<!-- Campo obrigatório -->
</div>

<div class="campo">
<label>Número</label>
<input type="text" name="numero" required>
<!-- Campo obrigatório -->
</div>

<div class="campo">
<label>Complemento</label>
<input type="text" name="complemento">
<!-- Campo opcional -->
</div>

<div class="campo">
<label>Cidade</label>
<input type="text" name="cidade" required>
<!-- Campo obrigatório -->
</div>

<button type="submit" class="botao">
Cadastrar Cliente
</button>
<!-- Botão para enviar o formulário -->

</form>

<a href="/lojinha_da_malu/painel.php" class="botao voltar">
⬅ Voltar
</a>
<!-- Botão para voltar ao painel -->

</div>

</body>
</html>