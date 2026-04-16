<?php
/**
 * salvar.php - Cadastro genérico cliente/endereço (legado de salvar_cliente.php)
 * Versão segura completa com validação + rollback
 */

session_start();

// ✅ PASSO 1: Conexão
include("conexao.php");

// ✅ PASSO 2: Validar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Método inválido.';
    header("Location: cliente.php");
    exit;
}

// ✅ PASSO 3: Dados
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$rua = isset($_POST['rua']) ? trim($_POST['rua']) : '';
$numero = isset($_POST['numero']) ? trim($_POST['numero']) : '';
$complemento = isset($_POST['complemento']) ? trim($_POST['complemento']) : '';
$cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : '';

// Validar
if (empty($nome) || empty($cpf) || empty($rua) || empty($numero) || empty($cidade)) {
    $_SESSION['erro'] = 'Campos obrigatórios faltando.';
    header("Location: cliente.php");
    exit;
}

// ✅ PASSO 4: Sanitizar tudo
$nome = mysqli_real_escape_string($conexao, $nome);
$cpf = mysqli_real_escape_string($conexao, $cpf);
$rua = mysqli_real_escape_string($conexao, $rua);
$numero = mysqli_real_escape_string($conexao, $numero);
$complemento = mysqli_real_escape_string($conexao, $complemento);
$cidade = mysqli_real_escape_string($conexao, $cidade);

// ✅ PASSO 5: CPF validação + duplicado
if (!preg_match('/^\d{11}$/', $cpf)) {
    $_SESSION['erro'] = 'CPF inválido.';
    header("Location: cliente.php");
    exit;
}
$check_cpf = "SELECT id FROM cliente WHERE cpf = '$cpf'";
if (mysqli_num_rows(mysqli_query($conexao, $check_cpf)) > 0) {
    $_SESSION['erro'] = 'CPF já cadastrado.';
    header("Location: cliente.php");
    exit;
}

// ✅ PASSO 6: INSERT endereço
$sql_endereco = "INSERT INTO endereco (rua, numero, complemento, cidade) 
                 VALUES ('$rua', '$numero', '$complemento', '$cidade')";

if (!mysqli_query($conexao, $sql_endereco)) {
    $_SESSION['erro'] = 'Erro endereço.';
    header("Location: cliente.php");
    exit;
}

$endereco_id = mysqli_insert_id($conexao);

// ✅ PASSO 7: INSERT cliente
$sql_cliente = "INSERT INTO cliente (nome, cpf, endereco_id) 
                VALUES ('$nome', '$cpf', $endereco_id)";

if (!mysqli_query($conexao, $sql_cliente)) {
    // Rollback endereço
    mysqli_query($conexao, "DELETE FROM endereco WHERE id = $endereco_id");
    $_SESSION['erro'] = 'Erro cliente - rollback executado.';
    header("Location: cliente.php");
    exit;
}

// ✅ PASSO 8: SUCESSO!
$_SESSION['sucesso'] = 'Cliente cadastrado!';
header("Location: clientes_cadastrados.php");
exit;
?>

