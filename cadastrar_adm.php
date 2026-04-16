<?php
/**
 * cadastrar_adm.php - Formulário cadastro novo ADM
 * Página responsável por exibir o formulário para criar um novo administrador
 */

// Inicia a sessão para controle de login
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    // Se não estiver logado, redireciona para o login
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Cadastrar Novo Administrador 👑</title>

<style>
/* Estilo geral da página */
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

/* Cabeçalho superior */
.topo{
    background: linear-gradient(90deg, #c8a2ff, #b58cff);
    color:white;
    padding:20px;
    text-align:center;
    font-size:26px;
    font-weight:bold;
}

/* Caixa principal do formulário */
.container{
    width:400px;
    margin:60px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0px 5px 15px rgba(0,0,0,0.15);
    text-align:center;
}

/* Campos de entrada */
input{
    width:100%;
    padding:10px;
    margin-top:10px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid #ccc;
    box-sizing:border-box;
}

/* Botões */
.botao{
    padding:10px;
    background:#c8a2ff;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:bold;
    width:100%;
    text-decoration:none;
    display:block;
    margin-top:10px;
}

/* Efeito ao passar o mouse */
.botao:hover{
    background:#b58cff;
}

/* Caixa de aviso */
.aviso{
    font-size:13px;
    color:#666;
    margin-bottom:20px;
    padding:10px;
    background:#f0f8ff;
    border-radius:6px;
    border-left:4px solid #c8a2ff;
}

/* Texto de dica da senha */
.senha-info{
    font-size:12px;
    color:#888;
    text-align:left;
    margin-top:-10px;
}

/* Mensagem de erro */
.erro-msg {
    color: red;
    background: #ffe6e6;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}
</style>
</head>

<body>

<div class="topo">👑 Painel Administrativo - Novo ADM</div>
<!-- Cabeçalho da página -->

<div class="container">

<?php if (isset($_SESSION['erro'])) { ?>
<!-- Verifica se existe mensagem de erro na sessão -->

<div class="erro-msg">
    <?= htmlspecialchars($_SESSION['erro']) ?>
</div>
<!-- Mostra o erro na tela com segurança (htmlspecialchars evita código malicioso) -->

<?php unset($_SESSION['erro']); } ?>
<!-- Remove a mensagem da sessão após exibir -->

<h2>Criar novo Administrador</h2>

<div class="aviso">
⚠️ Acesso total ao sistema - use com cuidado
</div>
<!-- Aviso importante sobre o nível de acesso -->

<form action="salvar_adm.php" method="POST" autocomplete="off">
<!-- Formulário que envia os dados para salvar_adm.php -->

<label style="font-weight:bold;display:block;margin-bottom:5px;">
Usuário ADM *
</label>

<input 
    type="text" 
    name="nome" 
    placeholder="Nome do usuário" 
    required 
    maxlength="50" 
    pattern="[a-zA-Z0-9_]+" 
    title="Apenas letras, números e _">
<!-- Campo de nome com validação:
     required = obrigatório
     maxlength = limite de caracteres
     pattern = aceita apenas letras, números e underline -->

<label style="font-weight:bold;display:block;margin-bottom:5px;">
Senha * (mínimo 8 caracteres)
</label>

<input 
    type="password" 
    name="senha" 
    id="senha" 
    placeholder="Senha forte recomendada" 
    required 
    minlength="8">
<!-- Campo de senha com mínimo de 8 caracteres -->

<div class="senha-info">
Dica: Use maiúscula + número + especial para máxima segurança
</div>

<button class="botao" type="submit">
👑 Cadastrar Administrador
</button>
<!-- Botão de envio do formulário -->

</form>

<a class="botao" href="admin.php">
⬅ Voltar ao Painel
</a>
<!-- Botão para voltar -->

</div>

<script>
// Seleciona o campo de senha
const senhaInput = document.getElementById('senha');

// Adiciona um evento que escuta o usuário digitando
senhaInput.addEventListener('input', function() {

    // Se a senha tiver 8 ou mais caracteres
    if (this.value.length >= 8) {
        this.style.borderColor = '#28a745';
        // Verde = senha válida
    } else {
        this.style.borderColor = '#dc3545';
        // Vermelho = senha fraca
    }
});
</script>

</body>
</html>