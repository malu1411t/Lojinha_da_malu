<?php
// ========================================================
// salvar_vendedor_login.php - INSERT novo vendedor tabela 'vendedor'
// Recebe POST de vendedor.php, valida, insere DB, flash mensagens

session_start(); // Linha 1: Sessão para flash erro/sucesso

include("conexao.php"); // Linha 2: Conexão mysqli $conexao

// Linha 5-6: Recebe dados form POST + trim sanitize
$nome = trim($_POST['nome'] ?? '');
$vendas = trim($_POST['vendas'] ?? 0); // Default 0 vendas inicial

// Linha 9: Validação nome vazio
if($nome == ''){
    $_SESSION['erro'] = "Digite o nome!"; // Flash erro
    header("Location: vendedor.php"); // Volta form
    exit;
}

// Linha 13: Validação vendas numérico, senão 0 seguro
if(!is_numeric($vendas)){
    $vendas = 0; // Converte inválido → 0
}

// Linha 16-17: SQL INSERT direto - ATENÇÃO: usar mysqli_escape_string outros ou prepared!
$sql = "INSERT INTO vendedor (nome, vendas) VALUES ('$nome', '$vendas')"; // Nota: vulnerável SQLi - melhorar future

if(!mysqli_query($conexao, $sql)){ // Linha 18: Executa query
    $_SESSION['erro'] = "Erro: " . mysqli_error($conexao); // Erro DB detalhado
    header("Location: vendedor.php");
    exit;
}

// Linha 22: Sucesso flash + redirect lista
$_SESSION['sucesso'] = "Vendedor cadastrado com sucesso!";
header("Location: vendedores_cadastrados.php"); // PRG pattern
exit; // Fim clean
?>

