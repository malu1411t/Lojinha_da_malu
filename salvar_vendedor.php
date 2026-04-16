<?php
// Inicia sessão para mensagens
session_start();

// Inclui conexão com o banco
include("conexao.php");

// Recebe os dados do formulário
$nome = trim($_POST['nome'] ?? '');
$vendas = $_POST['vendas'] ?? 0;

// Valida se o nome foi preenchido
if(empty($nome)){
    $_SESSION['erro'] = "Digite o nome!";
    header("Location: vendedor.php");
    exit;
}

// Valida se vendas é número válido
if(!is_numeric($vendas) || $vendas < 0){
    $vendas = 0;
}

// Prepara a query (mais seguro)
$stmt = $conexao->prepare("INSERT INTO vendedor (nome, quantidade_vendas) VALUES (?, ?)");

// Liga os parâmetros (string + inteiro)
$stmt->bind_param("si", $nome, $vendas);

// Executa o insert
if($stmt->execute()){
    $_SESSION['sucesso'] = "Cadastrado com sucesso!";
    header("Location: vendedores_cadastrados.php");
}else{
    $_SESSION['erro'] = "Erro ao cadastrar!";
    header("Location: vendedor.php");
}

// Fecha conexão
$stmt->close();
exit;
?>