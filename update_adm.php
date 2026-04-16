<?php
/**
 * update_adm.php - Atualiza administrador (nome opcional senha)
 * Padronizado UPDATES com verificação + validação especial senha
 */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

// ✅ PASSO 1: Conexão
include("conexao.php");

// ✅ PASSO 2: Validar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Método inválido.';
    header("Location: ver_adm.php");
    exit;
}

$id = isset($_POST['id']) ? trim($_POST['id']) : '';
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

// Nome sempre obrigatório
if (empty($id) || empty($nome)) {
    $_SESSION['erro'] = 'ID e nome obrigatórios.';
    header("Location: ver_adm.php");
    exit;
}

// ✅ PASSO 3: Sanitizar
$id = mysqli_real_escape_string($conexao, $id);
$nome = mysqli_real_escape_string($conexao, $nome);

// ✅ PASSO 4: Validar ID + existência
if (!is_numeric($id)) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: ver_adm.php");
    exit;
}

$check_id = "SELECT id FROM adm WHERE id = $id";
if (mysqli_num_rows(mysqli_query($conexao, $check_id)) === 0) {
    $_SESSION['erro'] = 'Admin não encontrado.';
    header("Location: ver_adm.php");
    exit;
}

// ✅ PASSO 5: Validar senha se fornecida
if (!empty($senha)) {
    if (strlen($senha) < 8) {
        $_SESSION['erro'] = 'Nova senha mínima 8 caracteres.';
        header("Location: ver_adm.php");
        exit;
    }
    $senha_segura = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "UPDATE adm SET nome='$nome', senha='$senha_segura' WHERE id=$id";
} else {
    $sql = "UPDATE adm SET nome='$nome' WHERE id=$id";
}

// ✅ PASSO 6: UPDATE
if (!mysqli_query($conexao, $sql)) {
    $_SESSION['erro'] = 'Erro update admin: ' . mysqli_error($conexao);
    header("Location: ver_adm.php");
    exit;
}

// ✅ PASSO 7: SUCESSO!
$_SESSION['sucesso'] = 'Administrador atualizado! ' . (empty($senha) ? '(Senha mantida)' : '(Senha alterada)');
header("Location: ver_adm.php");
exit;
?>

