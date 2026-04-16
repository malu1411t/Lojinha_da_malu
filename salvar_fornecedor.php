<?php
session_start();
// Inicia a sessão para permitir mensagens de erro/sucesso entre páginas

include("conexao.php");
// Inclui a conexão com o banco de dados

// Captura os dados enviados pelo formulário (POST)
// Se não existir, coloca string vazia
$nome = $_POST['nome'] ?? '';
$cnpj = $_POST['cnpj'] ?? '';
$produto = $_POST['produto'] ?? '';
$quantidade = $_POST['quantidade'] ?? '';
$preco = $_POST['preco'] ?? '';

// Verifica se algum campo está vazio
if(empty($nome) || empty($cnpj) || empty($produto) || empty($quantidade) || empty($preco)){
    $_SESSION['erro'] = "Preencha todos os campos!";
    // Define mensagem de erro na sessão

    header("Location: fornecedor.php");
    // Redireciona de volta para o formulário

    exit;
    // Encerra o script
}

// Prepara a query SQL com prepared statement (segurança contra SQL Injection)
$stmt = mysqli_prepare($conexao, 
"INSERT INTO fornecedor (nome, cnpj, produto, produto_quantidade, preco) VALUES (?, ?, ?, ?, ?)");

// Faz o "bind" dos parâmetros:
// s = string, s = string, s = string, i = inteiro, i = inteiro
mysqli_stmt_bind_param($stmt, "sssii", $nome, $cnpj, $produto, $quantidade, $preco);

// Executa o INSERT no banco de dados
if(mysqli_stmt_execute($stmt)){
    $_SESSION['sucesso'] = "Fornecedor cadastrado com sucesso!";
    // Se deu certo, salva mensagem de sucesso
} else {
    $_SESSION['erro'] = "Erro ao cadastrar!";
    // Se deu erro, salva mensagem de erro
}

// Redireciona de volta para a página de cadastro
header("Location: fornecedor.php");
exit;
// Encerra o script
?>