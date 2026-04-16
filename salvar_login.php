<?php
/**
 * salvar_login.php - Cadastra login genérico (admin/vendedor/etc)
 * Versão padronizada: validações + prepared statements + $_SESSION
 */

session_start();

// ✅ PASSO 1: Conexão
include("conexao.php");

// ✅ PASSO 2: Validar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Método inválido.';
    header("Location: cadastrar_login.php");
    exit;
}

// ✅ PASSO 3: Dados do formulário
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';

// Validar
if (empty($usuario) || empty($senha) || empty($tipo)) {
    $_SESSION['erro'] = 'Usuário, senha e tipo obrigatórios.';
    header("Location: cadastrar_login.php");
    exit;
}

if (strlen($senha) < 6) {
    $_SESSION['erro'] = 'Senha mínima 6 caracteres.';
    header("Location: cadastrar_login.php");
    exit;
}

// ✅ PASSO 4: Sanitizar (tipo extra segurança)
$usuario = mysqli_real_escape_string($conexao, $usuario);
$tipo = mysqli_real_escape_string($conexao, $tipo);

// ✅ PASSO 5: Check usuário duplicado (usando mysqli_query compatível)
$sql_verifica = "SELECT id FROM login WHERE usuario = '$usuario'";
$result_verifica = mysqli_query($conexao, $sql_verifica);
if (mysqli_num_rows($result_verifica) > 0) {
    $_SESSION['erro'] = 'Usuário já existe.';
    header("Location: cadastrar_login.php");
    exit;
}

// ✅ PASSO 6: Criptografar senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// ✅ PASSO 7: Prepared statement INSERT
$stmt = mysqli_prepare($conexao, "INSERT INTO login (usuario, senha, tipo) VALUES (?, ?, ?)");
if (!$stmt) {
    $_SESSION['erro'] = 'Erro prepare: ' . mysqli_error($conexao);
    header("Location: cadastrar_login.php");
    exit;
}

mysqli_stmt_bind_param($stmt, "sss", $usuario, $senha_hash, $tipo);

if (!mysqli_stmt_execute($stmt)) {
    $_SESSION['erro'] = 'Erro insert: ' . mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    header("Location: cadastrar_login.php");
    exit;
}

mysqli_stmt_close($stmt);

// ✅ PASSO 8: SUCESSO!
$_SESSION['sucesso'] = 'Login cadastrado com sucesso!';
header("Location: admin.php");
exit;
?>

