<?php 
// Inicia a sessão do PHP
// Isso permite usar variáveis como login, erro, mensagens entre páginas
session_start(); 
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<!-- Define o padrão de caracteres para suportar acentos (ç, ã, etc) -->

<title>Lojinha da Malu</title>
<!-- Título que aparece na aba do navegador -->

<style>
/* ========================= */
/* ESTILIZAÇÃO DA PÁGINA LOGIN */
/* ========================= */

body{
    font-family:Arial;
    /* Define a fonte padrão */

    margin:0;
    /* Remove margens do navegador */

    background:linear-gradient(135deg,#f3ecff,#e9ddff);
    /* Fundo em degradê roxo claro */
}

/* topo - cabeçalho */
.topo{
    background:linear-gradient(90deg,#d8c4ff,#cbb2ff);
    /* Gradiente roxo no topo */

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

/* container principal */
.container{
    width:380px;
    /* Largura da caixa */

    margin:80px auto;
    /* Centraliza horizontalmente e dá espaço no topo */

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

/* título */
h2{
    margin-bottom:5px;
    /* Espaço abaixo do título */

    color:#555;
    /* Cor cinza */
}

/* subtítulo */
.bemvindo{
    font-size:14px;
    /* Tamanho menor */

    color:#888;
    /* Cor cinza claro */

    margin-bottom:20px;
    /* Espaço abaixo */
}

/* campos do formulário */
.campo{
    text-align:left;
    /* Alinha texto à esquerda */

    margin-top:15px;
    /* Espaço entre campos */

    position:relative;
    /* Necessário para posicionar botão de mostrar senha */
}

label{
    font-size:14px;
    /* Tamanho do texto */

    color:#666;
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

/* quando o input é clicado */
input:focus{
    border-color:#cbb2ff;
    /* Muda cor da borda */

    outline:none;
    /* Remove borda padrão do navegador */

    box-shadow:0 0 5px rgba(203,178,255,0.5);
    /* Efeito de brilho */
}

/* botão mostrar senha */
.mostrar{
    position:absolute;
    /* Posicionamento dentro do campo */

    right:10px;
    /* Encosta à direita */

    top:38px;
    /* Alinhamento vertical */

    cursor:pointer;
    /* Mãozinha ao passar mouse */

    font-size:13px;
    /* Tamanho do texto */

    color:#888;
    /* Cor cinza */
}

.mostrar:hover{
    color:#555;
    /* Escurece ao passar o mouse */
}

/* botão login */
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
    /* Mãozinha */

    font-weight:bold;
    /* Negrito */

    transition:0.2s;
    /* Animação suave */
}

.botao:hover{
    background:linear-gradient(90deg,#cbb2ff,#bfa2ff);
    /* Muda gradiente ao passar mouse */
}

/* botão voltar */
.voltar{
    display:block;
    /* Faz virar bloco */

    margin-top:10px;
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

/* mensagem de erro */
.msg{
    margin-top:15px;
    /* Espaço acima */

    padding:10px;
    /* Espaçamento interno */

    border-radius:6px;
    /* Bordas arredondadas */

    font-size:14px;
    /* Tamanho do texto */
}

/* estilo de erro */
.erro{
    background:#f8d7da;
    /* Fundo vermelho claro */

    color:#721c24;
    /* Texto vermelho escuro */
}
</style>

<script>
// Função JavaScript para mostrar ou esconder senha
function toggleSenha(){

    var senha = document.getElementById("senha"); 
    // Pega o campo de senha pelo ID

    if(senha.type === "password"){
        senha.type = "text"; 
        // Mostra a senha

    }else{
        senha.type = "password"; 
        // Oculta a senha novamente
    }
}
</script>

</head>

<body>

<div class="topo">Lojinha da Malu</div>
<!-- Cabeçalho da página -->

<div class="container">

<h2>Entrar</h2>
<!-- Título do login -->

<div class="bemvindo">
✨ Bem-vindo de volta! Faça login para continuar
<!-- Mensagem de boas-vindas -->
</div>

<!-- Verifica se existe mensagem de erro na sessão -->
<?php if(isset($_SESSION['erro'])): ?>
<div class="msg erro">

<?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
<!-- Mostra erro e depois apaga da sessão -->

</div>
<?php endif; ?>

<!-- Formulário de login -->
<form action="verificar_login.php" method="POST">

<div class="campo">
<label>Usuário</label>

<input type="text" name="usuario" required>
<!-- Campo de usuário obrigatório -->
</div>

<div class="campo">
<label>Senha</label>

<input type="password" name="senha" id="senha" required>
<!-- Campo de senha obrigatório -->

<span class="mostrar" onclick="toggleSenha()">👁 Mostrar</span>
<!-- Botão que chama função JS para mostrar senha -->
</div>

<button type="submit" class="botao">Entrar</button>
<!-- Botão de login -->
</form>

<a href="home.php" class="voltar">⬅ Voltar ao início</a>
<!-- Link para voltar à página inicial -->

</div>

</body>
</html>