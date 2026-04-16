<?php
session_start();
// Inicia a sessão para usar mensagens de sucesso e erro

include("conexao.php");
// Inclui conexão com o banco de dados

// ===============================
// MENSAGENS DA SESSÃO
// ===============================

// Pega mensagem de sucesso se existir
$sucesso = $_SESSION['sucesso'] ?? '';

// Pega mensagem de erro se existir
$erro = $_SESSION['erro'] ?? '';

// Remove as mensagens da sessão após exibir (flash message)
unset($_SESSION['sucesso'], $_SESSION['erro']);

// ===============================
// BUSCA VENDEDORES
// ===============================

// Consulta todos os vendedores para preencher o select
$vendedores = mysqli_query($conexao, "SELECT * FROM vendedor");
?>

<!DOCTYPE html>
<html>
<head>
<title>Lojinha da Malu</title>
<!-- Título da página -->

<style>
/* =============================== */
/* ESTILO DA TELA DE VENDA        */
/* =============================== */

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
    width:420px;
    /* Largura do formulário */

    margin:60px auto;
    /* Centraliza na tela */

    background:#fff;
    /* Fundo branco */

    padding:35px;
    /* Espaçamento interno */

    border-radius:15px;
    /* Bordas arredondadas */

    box-shadow:0 8px 20px rgba(0,0,0,.15);
    /* Sombra suave */
}

h2{
    text-align:center;
    /* Centraliza título */

    color:#555;
    /* Cor cinza */

    margin-bottom:20px;
    /* Espaço abaixo */
}

/* CAMPOS */
.campo{
    text-align:left;
    /* Alinha à esquerda */

    margin-top:12px;
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

input, select{
    width:100%;
    /* Ocupa toda largura */

    padding:10px;
    /* Espaçamento interno */

    margin-top:5px;
    /* Espaço acima */

    border-radius:8px;
    /* Bordas arredondadas */

    border:1px solid #ccc;
    /* Borda cinza */
}

/* BOTÃO */
.botao{
    margin-top:15px;
    /* Espaço acima */

    width:100%;
    /* Largura total */

    padding:12px;
    /* Espaçamento interno */

    background:#c8a2ff;
    /* Cor roxa */

    color:#fff;
    /* Texto branco */

    border:none;
    /* Remove borda */

    border-radius:8px;
    /* Bordas arredondadas */

    font-weight:bold;
    /* Negrito */

    cursor:pointer;
    /* Mãozinha */
}

.botao:hover{
    background:#b58cff;
    /* Muda cor ao passar mouse */
}

/* BOTÃO VOLTAR */
.voltar{
    background:#ddd;
    /* Fundo cinza */

    color:#000;
    /* Texto preto */

    text-align:center;
    /* Centraliza texto */

    display:block;
    /* Vira bloco */

    margin-top:10px;
    /* Espaço acima */

    text-decoration:none;
    /* Remove sublinhado */

    padding:10px;
    /* Espaçamento interno */

    border-radius:8px;
    /* Bordas arredondadas */
}

.voltar:hover{
    background:#ccc;
    /* Escurece ao passar mouse */
}

/* MENSAGEM DE SUCESSO */
.msg-sucesso{
    background:#d4edda;
    /* Fundo verde claro */

    color:#155724;
    /* Texto verde escuro */

    padding:10px;
    /* Espaçamento interno */

    border-radius:6px;
    /* Bordas arredondadas */

    margin-bottom:10px;
    /* Espaço abaixo */
}

/* MENSAGEM DE ERRO */
.msg-erro{
    background:#f8d7da;
    /* Fundo vermelho claro */

    color:#721c24;
    /* Texto vermelho escuro */

    padding:10px;
    /* Espaçamento interno */

    border-radius:6px;
    /* Bordas arredondadas */

    margin-bottom:10px;
    /* Espaço abaixo */
}
</style>
</head>

<body>

<div class="topo">💰 Registrar Venda</div>
<!-- Cabeçalho da página -->

<div class="container">

<!-- MENSAGEM DE SUCESSO -->
<?php if($sucesso): ?>
<div class="msg-sucesso"><?= $sucesso ?></div>
<!-- Mostra mensagem de sucesso -->
<?php endif; ?>

<!-- MENSAGEM DE ERRO -->
<?php if($erro): ?>
<div class="msg-erro"><?= $erro ?></div>
<!-- Mostra mensagem de erro -->
<?php endif; ?>

<h2>Nova Venda</h2>
<!-- Título do formulário -->

<form action="salvar_venda.php" method="POST">
<!-- Envia dados para salvar_venda.php -->

<div class="campo">
<label>Produto</label>
<input type="text" name="produto" required>
<!-- Campo produto obrigatório -->
</div>

<div class="campo">
<label>Quantidade</label>
<input type="number" name="quantidade" required>
<!-- Campo quantidade -->
</div>

<div class="campo">
<label>Preço</label>
<input type="number" step="0.01" name="preco" required>
<!-- Campo preço com decimal -->
</div>

<div class="campo">
<label>Vendedor</label>
<select name="vendedor_id" required>
<!-- Select para escolher vendedor -->

<option value="">Selecione</option>

<?php while($v = mysqli_fetch_assoc($vendedores)): ?>
<!-- Loop que lista todos os vendedores -->

<option value="<?= $v['id'] ?>">
<?= htmlspecialchars($v['nome']) ?>
<!-- Mostra nome do vendedor -->
</option>

<?php endwhile; ?>

</select>
</div>

<button type="submit" class="botao">Registrar Venda</button>
<!-- Botão de envio -->

</form>

<a href="painel.php" class="voltar">⬅ Voltar</a>
<!-- Botão voltar -->

</div>

</body>
</html>