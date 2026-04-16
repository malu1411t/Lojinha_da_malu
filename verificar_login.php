<?php
// ========================================================
// verificar_login.php - Processador login sistema
// Responsável por autenticar usuário no sistema
// ========================================================

session_start();
// Inicia a sessão para armazenar dados do login (ex: usuário logado)

include("conexao.php");
// Inclui conexão com o banco de dados

// ===============================
// VERIFICAÇÃO DE MÉTODO
// ===============================

// Garante que só pode acessar via POST (segurança)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    // Se tentar acessar direto pela URL, redireciona

    exit;
    // Encerra execução
}

// ===============================
// RECEBIMENTO DOS DADOS
// ===============================

// Captura usuário e remove espaços extras
$usuario = trim($_POST['usuario'] ?? '');

// Captura senha (não usa trim por causa do hash)
$senha = $_POST['senha'] ?? '';

// ===============================
// VALIDAÇÃO DE CAMPOS
// ===============================

// Verifica se algum campo está vazio
if (empty($usuario) || empty($senha)) {
    $_SESSION['erro'] = "Preencha todos os campos!";
    // Armazena mensagem de erro na sessão

    header("Location: login.php");
    // Volta para tela de login

    exit;
}

// ===============================
// CONSULTA AO BANCO (SEGURA)
// ===============================

// Prepara SQL para evitar SQL Injection
$stmt = mysqli_prepare($conexao, "SELECT * FROM login WHERE usuario = ?");

// Liga o parâmetro usuário na query
mysqli_stmt_bind_param($stmt, "s", $usuario);

// Executa consulta
mysqli_stmt_execute($stmt);

// Pega resultado da consulta
$resultado = mysqli_stmt_get_result($stmt);

// Converte resultado em array associativo
$usuario_db = mysqli_fetch_assoc($resultado);

// Fecha statement
mysqli_stmt_close($stmt);

// ===============================
// VERIFICA SE USUÁRIO EXISTE
// ===============================

// Se não encontrou usuário no banco
if (!$usuario_db) {
    $_SESSION['erro'] = "Usuário ou senha inválidos!";
    header("Location: login.php");
    exit;
}

// ===============================
// VERIFICA SENHA (HASH)
// ===============================

// Compara senha digitada com hash do banco
if (!password_verify($senha, $usuario_db['senha'])) {
    $_SESSION['erro'] = "Usuário ou senha inválidos!";
    header("Location: login.php");
    exit;
}

// ===============================
// LOGIN REALIZADO COM SUCESSO
// ===============================

// Marca usuário como logado
$_SESSION['logado'] = true;

// Guarda nome do usuário logado
$_SESSION['usuario'] = $usuario_db['usuario'];

// Guarda tipo (admin ou vendedor)
$_SESSION['tipo'] = $usuario_db['tipo'];

// ===============================
// REDIRECIONAMENTO FINAL
// ===============================

header("Location: painel.php");
// Envia usuário para painel principal

exit;
// Encerra execução
?>