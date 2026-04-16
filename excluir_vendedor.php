<?php

/**
 * excluir_vendedor.php - Exclui vendedor com validações
 * Esse arquivo remove um vendedor do sistema com segurança
 */

// Inicia a sessão para controle de login e mensagens
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    // Redireciona para login se não estiver autenticado
    exit;
}

// PASSO 1: Conexão com o banco de dados
include("conexao.php");

// PASSO 2: Verifica se o método é GET e se o ID foi enviado
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    $_SESSION['erro'] = 'ID ou método inválido.';
    header("Location: vendedores_cadastrados.php");
    exit;
}

// Pega o ID vindo da URL
$id = trim($_GET['id']);

// PASSO 3: Sanitiza e valida o ID
$id = mysqli_real_escape_string($conexao, $id);
// Protege contra SQL Injection

if (!is_numeric($id) || $id <= 0) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: vendedores_cadastrados.php");
    exit;
}

// PASSO 4: Verifica se o vendedor existe no banco
$check = "SELECT nome FROM vendedor WHERE id = $id";

// Executa a consulta
$result = mysqli_query($conexao, $check);

// Se não encontrar o vendedor
if (mysqli_num_rows($result) === 0) {
    $_SESSION['erro'] = 'Vendedor não encontrado.';
    header("Location: vendedores_cadastrados.php");
    exit;
}

// Pega o nome do vendedor (para mostrar na mensagem depois)
$vendedor_nome = mysqli_fetch_assoc($result)['nome'];

// PASSO 5: Executa o DELETE
$sql = "DELETE FROM vendedor WHERE id = $id";

// Verifica se deu erro ao excluir
if (!mysqli_query($conexao, $sql)) {
    $_SESSION['erro'] = 'Erro exclusão: ' . mysqli_error($conexao);
    header("Location: vendedores_cadastrados.php");
    exit;
}

// PASSO 6: Mensagem de sucesso
$_SESSION['sucesso'] = "Vendedor '$vendedor_nome' excluído com sucesso.";

// Redireciona de volta para a lista
header("Location: vendedores_cadastrados.php");
exit;
?>