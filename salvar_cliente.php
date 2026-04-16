<?php
session_start(); // Inicia sessão para mensagens

include("conexao.php"); // Conecta ao banco lojinha_da_malu

// =========================
// Recebe dados do formulário
// =========================
$nome = trim($_POST['nome'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$rua = trim($_POST['rua'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$complemento = trim($_POST['complemento'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');

// =========================
// Validação básica
// =========================
if(empty($nome) || empty($cpf) || empty($rua) || empty($numero) || empty($cidade)){
    $_SESSION['erro'] = "Preencha todos os campos!";
    header("Location: cliente.php"); // Retorna para o formulário
    exit;
}

// =========================
// Salva endereço
// =========================
$stmt_end = $conexao->prepare("
    INSERT INTO endereco (rua, numero, complemento, cidade)
    VALUES (?, ?, ?, ?)
");
$stmt_end->bind_param("ssss", $rua, $numero, $complemento, $cidade);

if(!$stmt_end->execute()){
    $_SESSION['erro'] = "Erro ao salvar endereço!";
    header("Location: cliente.php");
    exit;
}

$id_endereco = $conexao->insert_id;
$stmt_end->close();

// =========================
// Salva cliente
// =========================
$stmt_cli = $conexao->prepare("
    INSERT INTO cliente (nome, cpf, endereco_id)
    VALUES (?, ?, ?)
");
$stmt_cli->bind_param("ssi", $nome, $cpf, $id_endereco);

if(!$stmt_cli->execute()){
    $_SESSION['erro'] = "Erro ao salvar cliente!";
    header("Location: cliente.php");
    exit;
}

$stmt_cli->close();

// =========================
// Sucesso
// =========================
$_SESSION['sucesso'] = "Cliente cadastrado com sucesso! 🎉";

// Redireciona para o mesmo formulário
header("Location: cliente.php");
exit;
?>