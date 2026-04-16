<!DOCTYPE html>
<!-- Declara que o documento é HTML5 -->

<html>
<head>

<title>Lojinha da Malu</title>
<!-- Define o título que aparece na aba do navegador -->

<style>
/* CSS da página (estilização) */

body{
    font-family:Arial;
    /* Define a fonte padrão */

    background:#f4f6f9;
    /* Cor de fundo cinza claro */

    margin:0;
    /* Remove margens padrão do navegador */
}

.topo{
    background:#c8a2ff;
    /* Cor roxa do topo */

    color:#fff;
    /* Texto branco */

    padding:18px;
    /* Espaçamento interno */

    text-align:center;
    /* Centraliza o texto */

    font-size:24px;
    /* Tamanho da fonte */

    font-weight:bold;
    /* Texto em negrito */
}

.container{
    width:420px;
    /* Largura da caixa principal */

    margin:40px auto;
    /* Centraliza horizontalmente e dá espaço em cima */

    background:#fff;
    /* Fundo branco */

    padding:35px;
    /* Espaçamento interno */

    border-radius:12px;
    /* Bordas arredondadas */

    box-shadow:0 5px 15px rgba(0,0,0,.15);
    /* Sombra suave */

    text-align:center;
    /* Centraliza conteúdo */
}

h2{
    margin-bottom:20px;
    /* Espaço abaixo do título */

    color:#555;
    /* Cor cinza */
}

.campo{
    text-align:left;
    /* Alinha os campos à esquerda */

    margin-top:12px;
    /* Espaço entre campos */
}

label{
    font-size:14px;
    /* Tamanho do texto do label */

    color:#555;
    /* Cor cinza */
}

input{
    width:100%;
    /* Campo ocupa toda largura */

    padding:10px;
    /* Espaçamento interno */

    margin-top:5px;
    /* Espaço acima do input */

    border-radius:6px;
    /* Bordas arredondadas */

    border:1px solid #ccc;
    /* Borda cinza clara */

    font-size:14px;
    /* Tamanho da fonte */
}

.botao{
    margin-top:20px;
    /* Espaço acima do botão */

    width:100%;
    /* Botão ocupa toda largura */

    padding:12px;
    /* Espaçamento interno */

    background:#c8a2ff;
    /* Cor roxa */

    color:#fff;
    /* Texto branco */

    border:none;
    /* Remove borda padrão */

    border-radius:6px;
    /* Bordas arredondadas */

    font-size:16px;
    /* Tamanho da fonte */

    cursor:pointer;
    /* Cursor de clique */

    font-weight:bold;
    /* Texto em negrito */
}

.botao:hover{
    background:#b58cff;
    /* Muda a cor ao passar o mouse */
}

.menu{
    display:block;
    /* Faz o link virar bloco */

    margin-top:18px;
    /* Espaço acima */

    text-decoration:none;
    /* Remove sublinhado */

    color:#7a4fd3;
    /* Cor roxa do texto */

    font-weight:bold;
    /* Negrito */
}

.menu:hover{
    text-decoration:underline;
    /* Sublinhar ao passar o mouse */
}
</style>
</head>

<body>

<div class="topo">Lojinha da Malu</div>
<!-- Barra superior da página -->

<div class="container">
<!-- Caixa principal do formulário -->

<h2>Cadastro de Cliente</h2>
<!-- Título da seção -->

<form action="salvar_cliente.php" method="POST">
<!-- Formulário que envia os dados via POST para salvar no PHP -->

<div class="campo">
<label>Nome</label>
<!-- Texto do campo -->

<input type="text" name="nome" placeholder="Digite o nome do cliente" required>
<!-- Campo de nome obrigatório -->
</div>

<div class="campo">
<label>CPF</label>
<!-- Campo CPF -->

<input type="text" name="cpf" placeholder="Digite o CPF" required>
<!-- Campo CPF obrigatório -->
</div>

<div class="campo">
<label>Rua</label>

<input type="text" name="rua" placeholder="Digite a rua" required>
</div>

<div class="campo">
<label>Número</label>

<input type="text" name="numero" placeholder="Digite o número" required>
</div>

<div class="campo">
<label>Complemento</label>

<input type="text" name="complemento" placeholder="Ex: casa, ap 2">
<!-- Campo opcional -->
</div>

<div class="campo">
<label>Cidade</label>

<input type="text" name="cidade" placeholder="Digite a cidade" required>
</div>

<button class="botao" type="submit">Cadastrar Cliente</button>
<!-- Botão que envia o formulário -->

</form>

<a class="botao" href="home.php">⬅ Voltar ao menu</a>
<!-- Link para voltar ao menu principal -->

</div>

</body>
</html>