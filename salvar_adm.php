<?php
/**
 * salvar_adm.php - Cadastra novo administrador
 * Versão melhorada com validações completas + prepared statements
 */

session_start();

// ✅ PASSO 1: Conexão segura
include("conexao.php");

// ✅ PASSO 2: Validar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Método inválido. Use formulário.';
    header("Location: cadastrar_adm.php");
    exit;
}

// ✅ PASSO 3: Capturar e validar dados
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

if (empty($nome) || empty($senha)) {
    $_SESSION['erro'] = 'Nome e senha são obrigatórios.';
    header("Location: cadastrar_adm.php");
    exit;
}

if (strlen($senha) < 8) {
    $_SESSION['erro'] = 'Senha deve ter pelo menos 8 caracteres.';
    header("Location: cadastrar_adm.php");
    exit;
}

// ✅ PASSO 4: Sanitizar nome
$nome = mysqli_real_escape_string($conexao, $nome);

// ✅ PASSO 5: Verificar nome duplicado
$check_nome = "SELECT id FROM adm WHERE nome = '$nome'";
if (mysqli_num_rows(mysqli_query($conexao, $check_nome)) > 0) {
    $_SESSION['erro'] = 'Administrador já existe.';
    header("Location: cadastrar_adm.php");
    exit;
}

// ✅ PASSO 6: Criptografar senha (mantido password_hash)
$senha_segura = password_hash($senha, PASSWORD_DEFAULT);

// ✅ PASSO 7: Prepared Statement (mantido e melhorado)
$stmt = mysqli_prepare($conexao, "INSERT INTO adm (nome, senha) VALUES (?, ?)");
if (!$stmt) {
    $_SESSION['erro'] = 'Erro prepare: ' . mysqli_error($conexao);
    header("Location: cadastrar_adm.php");
    exit;
}

mysqli_stmt_bind_param($stmt, "ss", $nome, $senha_segura);

if (!mysqli_stmt_execute($stmt)) {
    $_SESSION['erro'] = 'Erro ao cadastrar: ' . mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    header("Location: cadastrar_adm.php");
    exit;
}

mysqli_stmt_close($stmt);

// ✅ PASSO 8: SUCESSO!
$_SESSION['sucesso'] = 'Administrador cadastrado com sucesso!';
header("Location: ver_adm.php");
exit;
?>

