<?php
// ========================================================
// Este arquivo deleta um usuário da tabela 'login' usando o ID via GET
// Ele é chamado pelo botão "Excluir" da página cadastrar_login.php

// Inicia a sessão (necessário para usar $_SESSION e controle de login)
session_start();

// Inclui o arquivo de conexão com o banco de dados
include("conexao.php");

// 🔒 PROTEÇÃO: Apenas administradores podem excluir usuários
// Verifica se está logado e se o tipo é 'adm'
if(!isset($_SESSION['logado']) || $_SESSION['tipo'] != 'adm'){
    header("Location: login.php"); // Redireciona se não tiver permissão
    exit; // Interrompe o código por segurança
}

// Pega o ID vindo da URL (GET)
// ?? evita erro caso o índice não exista
$id = $_GET['id'] ?? '';

// Validação: verifica se o ID está vazio
if(empty($id)){
    $_SESSION['erro'] = "ID inválido!"; // Mensagem de erro
    header("Location: cadastrar_login.php"); // Volta para a lista
    exit; // Interrompe execução
}

// PREPARED STATEMENT (mais seguro contra SQL Injection)
// O ? é um placeholder que será substituído pelo valor real depois
$stmt = mysqli_prepare($conexao, "DELETE FROM login WHERE id = ?");

// Liga o parâmetro ao placeholder
// "i" significa que o valor é do tipo inteiro (integer)
mysqli_stmt_bind_param($stmt, "i", $id);

// Executa o comando DELETE
if(mysqli_stmt_execute($stmt)){
    $_SESSION['sucesso'] = "Usuário excluído com sucesso!"; // Sucesso
} else {
    $_SESSION['erro'] = "Erro ao excluir!"; // Falha
}

// Fecha o prepared statement (libera memória)
mysqli_stmt_close($stmt);

// Redireciona de volta para a lista (boa prática PRG - Post/Redirect/Get)
header("Location: cadastrar_login.php");
exit; // Garante que nada mais será executado
?>