<?php
// ========================================================
// editar_usuario.php - Tela de edição de usuário
// Essa página recebe o ID pela URL e busca os dados no banco

session_start();
// Inicia a sessão para poder verificar se o usuário está logado

include("conexao.php");
// Inclui o arquivo de conexão com o banco de dados

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['logado']) || $_SESSION['tipo'] != 'adm') {
    header("Location: login.php");
    // Redireciona para o login caso não tenha permissão
    exit();
}

// Pega o ID enviado pela URL (ex: editar_usuario.php?id=1)
$id = $_GET['id'] ?? '';

// Verifica se o ID está vazio
if (empty($id)) {
    header("Location: cadastrar_login.php");
    // Se não tiver ID, volta para a listagem
    exit();
}

// Prepara a consulta SQL para buscar o usuário pelo ID
$stmt = mysqli_prepare($conexao, "SELECT * FROM login WHERE id = ?");

// Verifica se houve erro na preparação da query
if (!$stmt) {
    die("Erro na query: " . mysqli_error($conexao));
}

// Associa o parâmetro (id) à query
mysqli_stmt_bind_param($stmt, "i", $id);

// Executa a consulta
mysqli_stmt_execute($stmt);

// Obtém o resultado da consulta
$resultado = mysqli_stmt_get_result($stmt);

// Pega os dados do usuário como array associativo
$u = mysqli_fetch_assoc($resultado);

// Verifica se o usuário foi encontrado
if (!$u) {
    header("Location: cadastrar_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!-- Define acentuação correta -->

<title>Editar Usuário</title>

<style>
body{font-family:Arial;background:#f4f6f9;margin:0;}
.topo{background:linear-gradient(90deg,#c8a2ff,#b58cff);color:#fff;padding:20px;text-align:center;font-size:26px;font-weight:bold;}
.container{width:400px;margin:60px auto;background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,.15);text-align:center;}
h2{color:#6a0dad;margin-bottom:20px;}
input, select{width:100%;padding:10px;margin-top:10px;border-radius:6px;border:1px solid #ccc;}
button{width:100%;padding:12px;margin-top:15px;background:#c8a2ff;color:#fff;border:none;border-radius:6px;font-weight:bold;}
button:hover{background:#b58cff;}
.botao{display:block;margin-top:10px;padding:10px;background:#ddd;text-decoration:none;border-radius:6px;color:black;}
</style>
</head>

<body>

<div class="topo">Editar Usuário</div>

<div class="container">

<h2>Alterar Dados</h2>

<!-- Formulário que envia os dados para atualizar_usuario.php -->
<form action="atualizar_usuario.php" method="POST">

<!-- Campo oculto para enviar o ID do usuário -->
<input type="hidden" name="id" value="<?= htmlspecialchars($u['id']) ?>">

<!-- Campo de usuário já preenchido -->
<input type="text" name="usuario" 
value="<?= htmlspecialchars($u['usuario']) ?>" required>

<!-- Seleção do tipo de usuário -->
<select name="tipo" required>

<option value="adm" <?= ($u['tipo'] == 'adm') ? 'selected' : '' ?>>
Administrador
</option>

<option value="vendedor" <?= ($u['tipo'] == 'vendedor') ? 'selected' : '' ?>>
Vendedor
</option>

</select>

<!-- Botão para salvar -->
<button type="submit">Salvar Alterações</button>

</form>

<!-- Botão de voltar -->
<a class="botao" href="cadastrar_login.php">⬅ Voltar</a>

</div>

</body>
</html>