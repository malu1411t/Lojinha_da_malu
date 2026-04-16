<?php
/**
 * editar_adm.php - Formulário edição ADM
 * Página responsável por carregar os dados de um administrador para edição
 */

// Inicia a sessão para controle de login
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    // Se não estiver logado, redireciona
    exit;
}

// ✅ PASSO 1: Conexão com o banco
include("conexao.php");
// Importa o arquivo de conexão

// ✅ PASSO 2: Validar ID recebido pela URL (GET)

// Verifica se a requisição é GET e se existe o ID
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: ver_adm.php");
    exit;
}

// Recebe o ID e remove espaços
$id = trim($_GET['id']);

// Protege contra SQL Injection
$id = mysqli_real_escape_string($conexao, $id);

// Verifica se o ID é numérico e válido
if (!is_numeric($id) || $id <= 0) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: ver_adm.php");
    exit;
}

// ✅ PASSO 3: Verificar se o administrador existe

$sql = "SELECT * FROM adm WHERE id = $id";
// Busca o administrador pelo ID

$resultado = mysqli_query($conexao, $sql);
// Executa a consulta

// Se não encontrar o admin ou der erro
if (!$resultado || mysqli_num_rows($resultado) === 0) {
    $_SESSION['erro'] = 'Administrador não encontrado.';
    header("Location: ver_adm.php");
    exit;
}

// Pega os dados do administrador
$adm = mysqli_fetch_assoc($resultado);

// ⚠️ SEGURANÇA IMPORTANTE
// Impede que o usuário edite a própria conta por essa tela
if ($adm['id'] == $_SESSION['user_id'] ?? 0) {
    $_SESSION['erro'] = 'Não é possível editar sua própria conta aqui.';
    header("Location: ver_adm.php");
    exit;
}
?>