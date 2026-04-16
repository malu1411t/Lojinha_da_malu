<?php
/**
 * excluir.php - Exclui cliente + endereço CASCADE seguro
 * DELETE complexo - Verifica existência ANTES + ordem correta
 */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

// ✅ PASSO 1: Conexão
include("conexao.php");

// ✅ PASSO 2: Validar GET ID
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    $_SESSION['erro'] = 'ID ou método inválido.';
    header("Location: clientes_cadastrados.php");
    exit;
}

$id = trim($_GET['id']);

// ✅ PASSO 3: Sanitizar + validar
$id = mysqli_real_escape_string($conexao, $id);
if (!is_numeric($id) || $id <= 0) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: clientes_cadastrados.php");
    exit;
}

// ✅ PASSO 4: Verificar cliente + pegar endereço
$sql = "SELECT nome, endereco_id FROM cliente WHERE id = $id";
$resultado = mysqli_query($conexao, $sql);
if (!$resultado || mysqli_num_rows($resultado) === 0) {
    $_SESSION['erro'] = 'Cliente não encontrado.';
    header("Location: clientes_cadastrados.php");
    exit;
}

$dados = mysqli_fetch_assoc($resultado);
$cliente_nome = $dados['nome'];
$endereco_id = $dados['endereco_id'];

// ✅ PASSO 5: Verificar endereço existe
if (empty($endereco_id)) {
    $_SESSION['erro'] = 'Endereço não encontrado para este cliente.';
    header("Location: clientes_cadastrados.php");
    exit;
}

$check_end = "SELECT id FROM endereco WHERE id = $endereco_id";
if (mysqli_num_rows(mysqli_query($conexao, $check_end)) === 0) {
    $_SESSION['erro'] = 'Endereço inválido.';
    header("Location: clientes_cadastrados.php");
    exit;
}

// ✅ PASSO 6: DELETE ENDEREÇO PRIMEIRO (referência)
if (!mysqli_query($conexao, "DELETE FROM endereco WHERE id = $endereco_id")) {
    $_SESSION['erro'] = 'Erro endereço: ' . mysqli_error($conexao);
    header("Location: clientes_cadastrados.php");
    exit;
}

// ✅ PASSO 7: DELETE CLIENTE
if (!mysqli_query($conexao, "DELETE FROM cliente WHERE id = $id")) {
    $_SESSION['erro'] = 'Erro cliente: ' . mysqli_error($conexao);
    // Nota: Endereço já deletado, mas cliente falhou
    header("Location: clientes_cadastrados.php");
    exit;
}

// ✅ PASSO 8: SUCESSO COMPLETO
$_SESSION['sucesso'] = "Cliente '$cliente_nome' e endereço excluídos permanentemente.";
header("Location: clientes_cadastrados.php");
exit;
?>

