<?php
// ========================================================
// salvar_estoque.php - INSERT produto estoque tabela estoque
// Script responsável por salvar produtos no estoque
// ========================================================

session_start(); 
// Inicia a sessão para usar mensagens de erro/sucesso (flash messages)

include("conexao.php"); 
// Inclui a conexão com o banco de dados ($conexao)

// Linha 7: verifica se a requisição foi via POST
// Isso impede acesso direto pela URL (segurança básica)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Método inválido.';
    // Define mensagem de erro na sessão

    header("Location: estoque.php");
    // Redireciona de volta para o formulário

    exit;
    // Encerra o script
}

// 🔥 Captura os dados do formulário e remove espaços extras
$produto = trim($_POST['produto'] ?? '');
$quantidade = trim($_POST['quantidade'] ?? '');
$preco_fornecedor = trim($_POST['preco_fornecedor'] ?? '');
$preco_venda = trim($_POST['preco_venda'] ?? '');

// =============================
// VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
// =============================
if (empty($produto) || empty($quantidade) || empty($preco_fornecedor) || empty($preco_venda)) {
    $_SESSION['erro'] = 'Preencha todos os campos!';
    // Se algum campo estiver vazio, mostra erro

    header("Location: estoque.php");
    // Volta para o formulário

    exit;
}

// =============================
// VALIDAÇÃO DE NÚMEROS
// =============================

// Verifica se quantidade é número válido e maior que zero
if (!is_numeric($quantidade) || $quantidade <= 0) {
    $_SESSION['erro'] = 'Quantidade inválida (número >0)!';
    header("Location: estoque.php");
    exit;
}

// Verifica se preço fornecedor é válido
if (!is_numeric($preco_fornecedor) || $preco_fornecedor <= 0) {
    $_SESSION['erro'] = 'Preço fornecedor inválido (>0)!';
    header("Location: estoque.php");
    exit;
}

// Verifica se preço de venda é válido
if (!is_numeric($preco_venda) || $preco_venda <= 0) {
    $_SESSION['erro'] = 'Preço venda inválido (>0)!';
    header("Location: estoque.php");
    exit;
}

// =============================
// PREPARED STATEMENT (SEGURANÇA SQL)
// =============================

// Prepara a query SQL para evitar SQL Injection
$stmt = $conexao->prepare("
    INSERT INTO estoque (produto, quantidade_calcas, preco_fornecedor, preco_venda)
    VALUES (?, ?, ?, ?)
"); 
// ? = valores que serão inseridos depois com segurança

if(!$stmt){
    // Caso a preparação da query falhe

    $_SESSION['erro'] = 'Erro prepare: ' . $conexao->error;
    header("Location: estoque.php");
    exit;
}

// Bind dos parâmetros:
// s = string (produto)
// i = integer (quantidade)
// d = double (preço fornecedor)
// d = double (preço venda)
$stmt->bind_param("sidd", $produto, $quantidade, $preco_fornecedor, $preco_venda);

// =============================
// EXECUÇÃO DO INSERT
// =============================

if($stmt->execute()){
    // Se inseriu com sucesso

    $_SESSION['sucesso'] = 'Produto cadastrado com sucesso! 📦';
}else{
    // Se deu erro ao inserir

    $_SESSION['erro'] = 'Erro execute: ' . $stmt->error;
}

// Fecha o statement para liberar memória
$stmt->close();

// Redireciona para página de listagem de estoque
header("Location: estoque_cadastrado.php");
exit;
?>