<?php 
session_start(); 
// Inicia a sessão do PHP
// Isso permite acessar variáveis como mensagens de erro entre páginas
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!-- Define codificação UTF-8 para suportar acentos -->

<title>Lojinha da Malu</title>
<!-- Título que aparece na aba do navegador -->

<style>
/* ============================ */
/* ESTILIZAÇÃO DA TELA DE LOGIN */
/* ============================ */

body{
    font-family: Arial;
    /* Define fonte padrão */

    margin:0;
    /* Remove margem padrão do navegador */

    background:#f5f3ff;
    /* Fundo roxo bem claro */
}

/* TOPO */
.topo{
    background:#c4b5fd;
    /* Cor roxa clara no topo */

    color:#4c1d95;
    /* Cor do texto roxo escuro */

    padding:20px;
    /* Espaçamento interno */

    text-align:center;
    /* Centraliza texto */

    font-size:24px;
    /* Tamanho da fonte */

    font-weight:bold;
    /* Texto em negrito */
}

/* CONTAINER */
.container{
    width:350px;
    /* Largura da caixa */

    margin:60px auto;
    /* Centraliza na tela */

    background:white;
    /* Fundo branco */

    padding:30px;
    /* Espaçamento interno */

    border-radius:14px;
    /* Bordas arredondadas */

    box-shadow:0 6px 15px rgba(0,0,0,0.1);
    /* Sombra leve */

    text-align:center;
    /* Centraliza conteúdo */
}

/* TITULO */
h2{
    color:#6b21a8;
    /* Cor roxa do título */
}

/* TEXTO DE BOAS-VINDAS */
.bemvindo{
    color:#666;
    /* Cor cinza */

    margin-bottom:20px;
    /* Espaço abaixo */
}

/* CAMPOS DO FORMULÁRIO */
.campo{
    text-align:left;
    /* Alinha texto à esquerda */

    margin-top:12px;
    /* Espaço entre campos */
}

label{
    font-weight:bold;
    /* Negrito */

    color:#555;
    /* Cor cinza escuro */
}

input{
    width:100%;
    /* Campo ocupa toda largura */

    padding:10px;
    /* Espaçamento interno */

    margin-top:5px;
    /* Espaço acima */

    border-radius:8px;
    /* Bordas arredondadas */

    border:1px solid #ccc;
    /* Borda cinza clara */
}

/* BOTÃO */
.botao{
    margin-top:15px;
    /* Espaço acima */

    width:100%;
    /* Ocupa toda largura */

    padding:12px;
    /* Espaçamento interno */

    background:#a78bfa;
    /* Cor roxa clara */

    color:white;
    /* Texto branco */

    border:none;
    /* Remove borda */

    border-radius:8px;
    /* Bordas arredondadas */

    font-weight:bold;
    /* Negrito */

    cursor:pointer;
    /* Cursor de clique */
}

.botao:hover{
    background:#8b5cf6;
    /* Muda cor ao passar mouse */
}

/* BOTÃO VOLTAR */
.voltar{
    display:block;
    /* Vira bloco */

    margin-top:10px;
    /* Espaço acima */

    padding:10px;
    /* Espaçamento interno */

    background:#eee;
    /* Fundo cinza claro */

    color:#333;
    /* Texto cinza escuro */

    text-decoration:none;
    /* Remove sublinhado */

    border-radius:8px;
    /* Bordas arredondadas */
}

/* MENSAGEM DE ERRO */
.msg{
    background:#f8d7da;
    /* Fundo vermelho claro */

    color:#721c24;
    /* Texto vermelho escuro */

    padding:10px;
    /* Espaçamento interno */

    border-radius:8px;
    /* Bordas arredondadas */

    margin-bottom:10px;
    /* Espaço abaixo */
}
</style>

</head>

<body>

<div class="topo">💜 Lojinha da Malu</div>
<!-- Cabeçalho da página -->

<div class="container">

<h2>Login</h2>
<!-- Título da tela -->

<div class="bemvindo">
Bem-vindo à Lojinha da Malu ✨
<!-- Mensagem de boas-vindas -->
</div>

<!-- Verifica se existe erro na sessão -->
<?php if(isset($_SESSION['erro'])): ?>
<div class="msg">

<?= htmlspecialchars($_SESSION['erro']); unset($_SESSION['erro']); ?>
<!-- Mostra a mensagem de erro e depois remove ela da sessão -->

</div>
<?php endif; ?>

<!-- Formulário de login -->
<form action="/lojinha_da_malu/verificar_login.php" method="POST">

<div class="campo">
<label>Usuário</label>

<input type="text" name="usuario" required>
<!-- Campo de usuário obrigatório -->
</div>

<div class="campo">
<label>Senha</label>

<input type="password" name="senha" required>
<!-- Campo de senha obrigatório -->
</div>

<button type="submit" class="botao">Entrar</button>
<!-- Botão de login -->

</form>

<a href="/lojinha_da_malu/home.php" class="voltar">Voltar</a>
<!-- Link para voltar à página inicial -->

</div>

</body>
</html>