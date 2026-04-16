<?php
session_start();
include("conexao.php");

// 🔒 Proteção
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}

// Pegar ID pela URL
$id = $_GET['id'] ?? '';

// Validar ID
if(empty($id) || !is_numeric($id)){
    $_SESSION['erro'] = "ID inválido!";
    header("Location: estoque_cadastrado.php");
    exit;
}

// Executar exclusão
$sql = "DELETE FROM estoque WHERE id = $id";

if(mysqli_query($conexao, $sql)){
    $_SESSION['sucesso'] = "Produto removido do estoque com sucesso! 🗑️";
} else {
    $_SESSION['erro'] = "Erro ao excluir: " . mysqli_error($conexao);
}

// Voltar para a listagem
header("Location: estoque_cadastrado.php");
exit;
?>