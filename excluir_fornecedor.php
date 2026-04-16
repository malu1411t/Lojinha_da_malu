<?php

/**
 * excluir_fornecedor.php - Exclui fornecedor com verificações
 * Esse código remove um fornecedor do sistema com validações de segurança
 */

// Inicia a sessão para controle de login e mensagens
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    // Redireciona para login caso não esteja autenticado
    exit;
}

// PASSO 1: Conectar ao banco de dados
include("conexao.php");

// PASSO 2: Verificar se o método é GET e se o ID foi enviado
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    $_SESSION['erro'] = 'ID ou método inválido.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// Pega o ID vindo da URL
$id = trim($_GET['id']);

// PASSO 3: Sanitizar e validar o ID
$id = mysqli_real_escape_string($conexao, $id);
// Protege contra SQL Injection

if (!is_numeric($id) || $id <= 0) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// PASSO 4: Verificar se o fornecedor existe no banco
$check = "SELECT nome FROM fornecedor WHERE id = $id";

// Executa a consulta
$result = mysqli_query($conexao, $check);

// Se não encontrar o fornecedor
if (mysqli_num_rows($result) === 0) {
    $_SESSION['erro'] = 'Fornecedor não encontrado.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// Pega o nome do fornecedor (para usar na mensagem depois)
$fornecedor_nome = mysqli_fetch_assoc($result)['nome'];

// PASSO 5: Executa o DELETE
$sql = "DELETE FROM fornecedor WHERE id = $id";

// Verifica se deu erro ao excluir
if (!mysqli_query($conexao, $sql)) {
    $_SESSION['erro'] = 'Erro exclusão: ' . mysqli_error($conexao);
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// PASSO 6: Mensagem de sucesso
$_SESSION['sucesso'] = "Fornecedor '$fornecedor_nome' excluído permanentemente.";

// Redireciona de volta para a lista
header("Location: fornecedores_cadastrados.php");
exit;
?>