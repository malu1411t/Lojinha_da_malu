<?php
// ========================================================
// cadastrar_login.php - FORM + LISTA usuários (adm/vendedor)
// Página que permite cadastrar novos usuários e listar os existentes

session_start(); 
// Inicia a sessão para controlar login e mensagens

// 🔥 PROTEÇÃO ADM - Apenas administradores podem acessar
if(!isset($_SESSION['logado']) || $_SESSION['tipo'] != 'adm'){
    header("Location: login.php");
    // Se não for admin, redireciona para login
    exit;
}

include("conexao.php"); 
// Conexão com o banco de dados

// Recupera mensagens (erro ou sucesso) vindas de outra página
$erro = $_SESSION['erro'] ?? '';
$sucesso = $_SESSION['sucesso'] ?? '';
// ?? significa: se não existir, recebe vazio

// Limpa as mensagens depois de usar (flash message)
unset($_SESSION['erro'], $_SESSION['sucesso']);

// ✅ Busca todos os usuários cadastrados no banco
$resultado = mysqli_query($conexao, "SELECT * FROM login ORDER BY id DESC");
// ORDER BY id DESC = mostra os mais recentes primeiro
?>

<!DOCTYPE html>
<html>
<head>
<title>Cadastrar Login</title>

<style>
/* Estilo geral da página */
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

/* Cabeçalho */
.topo{
    background:linear-gradient(90deg,#c8a2ff,#b58cff);
    color:#fff;
    padding:20px;
    text-align:center;
    font-size:26px;
    font-weight:bold;
}

/* Caixa principal */
.container{
    width:500px;
    margin:60px auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
    text-align:center;
}

/* Inputs e select */
input, select{
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

/* Hover do botão */
button:hover{
    background:#b58cff;
}

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

/* Mensagens */
.msg-erro{
    background:#f8d7da;
    color:#721c24;
    padding:10px;
    border-radius:6px;
    margin-bottom:10px;
}

.msg-sucesso{
    background:#d4edda;
    color:#155724;
    padding:10px;
    border-radius:6px;
    margin-bottom:10px;
}

/* Tabela */
table{
    width:100%;
    margin-top:30px;
    border-collapse:collapse;
}

th{
    background:#c8a2ff;
    color:#fff;
    padding:10px;
}

td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

/* Efeito ao passar o mouse */
tr:hover{
    background:#f3ebff;
}

/* Links de ação */
.editar{
    color:#3b5bdb;
    text-decoration:none;
    margin-right:10px;
}

.excluir{
    color:#d11a2a;
    text-decoration:none;
}

/* Caso não tenha dados */
.sem-dados{
    margin-top:20px;
    color:#666;
}
</style>

</head>
<body>

<div class="topo">Cadastrar Login</div>
<!-- Cabeçalho da página -->

<div class="container">

<h2>Novo Usuário</h2>

<?php if($erro): ?>
<!-- Se existir erro, exibe mensagem -->
<div class="msg-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<?php if($sucesso): ?>
<!-- Se existir sucesso, exibe mensagem -->
<div class="msg-sucesso"><?= htmlspecialchars($sucesso) ?></div>
<?php endif; ?>

<form action="salvar_login.php" method="POST">
<!-- Formulário que envia os dados para salvar_login.php -->

<input type="text" name="usuario" placeholder="Usuário" required>
<!-- Campo de usuário obrigatório -->

<input type="password" name="senha" placeholder="Senha" required>
<!-- Campo de senha obrigatório -->

<select name="tipo" required>
<!-- Seleção do tipo de usuário -->
<option value="">Selecione o tipo</option>
<option value="adm">Administrador</option>
<option value="vendedor">Vendedor</option>
</select>

<button type="submit">Cadastrar</button>
<!-- Botão para enviar -->

</form>

<a class="botao" href="admin.php">⬅ Voltar</a>
<!-- Botão de voltar -->

<h2>Usuários Cadastrados</h2>

<?php if(mysqli_num_rows($resultado) == 0): ?>
<!-- Se não houver usuários -->
<div class="sem-dados">Nenhum usuário cadastrado.</div>

<?php else: ?>

<table>
<tr>
<th>ID</th><th>Usuário</th><th>Tipo</th><th>Ações</th>
</tr>

<?php while($u = mysqli_fetch_assoc($resultado)): ?>
<!-- Loop que percorre todos os usuários -->

<tr>
<td><?= $u['id'] ?></td>

<td><?= htmlspecialchars($u['usuario']) ?></td>
<!-- htmlspecialchars protege contra código malicioso -->

<td><?= htmlspecialchars($u['tipo']) ?></td>

<td>
<a class="editar" href="editar_usuario.php?id=<?= $u['id'] ?>">Editar</a>
<!-- Link para editar -->

<a class="excluir" href="excluir_usuario.php?id=<?= $u['id'] ?>" 
onclick="return confirm('Deseja excluir este usuário?');">
Excluir
</a>
<!-- Link para excluir com confirmação -->
</td>
</tr>

<?php endwhile; ?>
</table>

<?php endif; ?>

</div>

</body>
</html>