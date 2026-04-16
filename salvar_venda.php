<?php
// ========================================================
// salvar_venda.php - Registra venda e atualiza total do vendedor
// Este arquivo registra uma venda e atualiza o total de vendas do vendedor
// ========================================================

// Inicia a sessão para permitir mensagens de sucesso/erro
session_start();

// Inclui a conexão com o banco de dados
include("conexao.php");

// Verifica se a requisição veio via POST (segurança)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: vendas.php");
    // Se alguém tentar acessar direto pela URL, redireciona

    exit;
    // Encerra execução
}

// =========================
// 📥 RECEBENDO DADOS DO FORMULÁRIO
// =========================

// trim remove espaços extras antes/depois dos valores
$produto = trim($_POST['produto'] ?? '');
$quantidade = trim($_POST['quantidade'] ?? '');
$preco = trim($_POST['preco'] ?? '');
$vendedor_id = trim($_POST['vendedor_id'] ?? '');

// =========================
// ✅ VALIDAÇÕES
// =========================

// Verifica se algum campo está vazio
if (empty($produto) || empty($quantidade) || empty($preco) || empty($vendedor_id)) {
    $_SESSION['erro'] = "Preencha todos os campos!";
    header("Location: vendas.php");
    exit;
}

// Verifica se os valores são números válidos
if (!is_numeric($quantidade) || !is_numeric($preco) || !is_numeric($vendedor_id)) {
    $_SESSION['erro'] = "Dados inválidos!";
    header("Location: vendas.php");
    exit;
}

// Converte os valores para tipos corretos
$quantidade = (int)$quantidade; // inteiro
$preco = (float)$preco; // decimal
$vendedor_id = (int)$vendedor_id; // inteiro

// =========================
// 💾 PASSO 1: INSERIR VENDA
// =========================

// Prepara a query (proteção contra SQL Injection)
$stmt = $conexao->prepare("
    INSERT INTO vendas (produto, quantidade, preco, vendedor_id)
    VALUES (?, ?, ?, ?)
");

// Define os tipos:
// s = string
// i = integer
// d = double (float)
// i = integer
$stmt->bind_param("sidi", $produto, $quantidade, $preco, $vendedor_id);

// Executa o INSERT
if (!$stmt->execute()) {
    $_SESSION['erro'] = "Erro ao registrar venda!";
    header("Location: vendas.php");
    exit;
}

// Fecha o statement
$stmt->close();

// =========================
// 🔄 PASSO 2: ATUALIZAR VENDEDOR
// =========================

// Atualiza o total de vendas somando todas as vendas do vendedor
$sql_update = "
    UPDATE vendedor v
    SET quantidade_vendas = (
        SELECT IFNULL(SUM(quantidade),0)
        FROM vendas
        WHERE vendedor_id = v.id
    )
    WHERE v.id = ?
";

// Prepara o UPDATE
$stmt2 = $conexao->prepare($sql_update);

// Liga o ID do vendedor na query
$stmt2->bind_param("i", $vendedor_id);

// Executa atualização
$stmt2->execute();

// Fecha statement
$stmt2->close();

// =========================
// ✅ FINALIZAÇÃO
// =========================

// Define mensagem de sucesso
$_SESSION['sucesso'] = "Venda registrada com sucesso! 💰";

// Redireciona de volta para tela de vendas
header("Location: vendas.php");
exit;
?>