<!DOCTYPE html>
<!-- Declara que o documento é HTML5 -->

<html>
<head>

<meta charset="UTF-8">
<!-- Define a codificação de caracteres UTF-8, permitindo acentos como ç, ã, etc -->

<title>Lojinha da Malu</title>
<!-- Define o título que aparece na aba do navegador -->

<style>
/* Estilização da página (CSS interno) */

body{
    font-family:Arial; 
    /* Define a fonte padrão da página */

    margin:0; 
    /* Remove as margens padrão do navegador */

    background:linear-gradient(135deg,#c8a2ff,#b58cff); 
    /* Cria um fundo em degradê roxo */

    height:100vh; 
    /* Faz o body ocupar 100% da altura da tela */

    display:flex; 
    /* Ativa o Flexbox para alinhamento */

    justify-content:center; 
    /* Centraliza horizontalmente */

    align-items:center; 
    /* Centraliza verticalmente */
}

.container{
    background:white; 
    /* Fundo branco da caixa principal */

    padding:50px; 
    /* Espaçamento interno */

    border-radius:15px; 
    /* Bordas arredondadas */

    text-align:center; 
    /* Centraliza o texto */

    width:350px; 
    /* Define largura fixa da caixa */

    box-shadow:0 10px 25px rgba(0,0,0,0.2); 
    /* Sombra suave para efeito de profundidade */
}

h1{
    color:#6a0dad; 
    /* Cor roxa escura do título */

    margin-bottom:10px; 
    /* Espaço abaixo do título */
}

p{
    color:#555; 
    /* Cor cinza do texto */
}

.botao{
    display:block; 
    /* Faz o link se comportar como bloco */

    margin-top:20px; 
    /* Espaço acima do botão */

    padding:12px; 
    /* Espaçamento interno */

    background:#8a2be2; 
    /* Cor roxa do botão */

    color:white; 
    /* Texto branco */

    text-decoration:none; 
    /* Remove sublinhado do link */

    border-radius:6px; 
    /* Bordas arredondadas */

    font-weight:bold; 
    /* Deixa o texto em negrito */
}

.botao:hover{
    background:#6a0dad; 
    /* Muda a cor quando o mouse passa em cima */
}
</style>

</head>

<body>

<div class="container">

<h1>💜 Lojinha da Malu</h1>
<!-- Título principal da página -->

<p>Sistema de gerenciamento</p>
<!-- Pequena descrição do sistema -->

<a class="botao" href="login.php">Entrar no Sistema</a>
<!-- Botão que leva o usuário para a página de login -->

</div>

</body>
</html>