<?php

/**
 * excluir_adm.php - Exclui administrador com proteção EXTRA
 * Essa página remove um administrador do sistema com várias validações de segurança
 */

// Inicia a sessão para verificar login e usar mensagens
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    // Redireciona para login se não estiver autenticado
    exit;
}

// PASSO 1: Conexão com banco de dados
include("conexao.php");

// PASSO 2: Verifica se o método é GET e se o ID foi enviado
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    $_SESSION['erro'] = 'ID ou método inválido.';
    header("Location: ver_adm.php");
    exit;
}

// Pega o ID vindo da URL
$id = trim($_GET['id']);

// PASSO 3: Sanitiza e valida o ID
$id = mysqli_real_escape_string($conexao, $id);
// Protege contra SQL Injection

if (!is_numeric($id) || $id <= 0) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: ver_adm.php");
    exit;
}

// PASSO 4: PROTEÇÃO CRÍTICA
// Impede que o admin exclua a própria conta logada
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
    $_SESSION['erro'] = 'Não é possível excluir sua própria conta ativa!';
    header("Location: ver_adm.php");
    exit;
}

// PASSO 5: Verifica se o administrador existe no banco
$check = "SELECT nome FROM adm WHERE id = $id";

// Executa a consulta
$result = mysqli_query($conexao, $check);

// Se não encontrou o admin
if (mysqli_num_rows($result) === 0) {
    $_SESSION['erro'] = 'Admin não encontrado.';
    header("Location: ver_adm.php");
    exit;
}

// Pega o nome do admin (para mostrar na mensagem depois)
$admin_nome = mysqli_fetch_assoc($result)['nome'];

// PASSO 6: Executa o DELETE
$sql = "DELETE FROM adm WHERE id = $id";

// Se der erro na exclusão
if (!mysqli_query($conexao, $sql)) {
    $_SESSION['erro'] = 'Erro exclusão admin: ' . mysqli_error($conexao);
    header("Location: ver_adm.php");
    exit;
}

// PASSO 7: Sucesso
$_SESSION['sucesso'] = "Admin '$admin_nome' foi excluído permanentemente.";

// Redireciona de volta para lista
header("Location: ver_adm.php");
exit;
?>