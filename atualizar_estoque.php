<?php
/**
 * atualizar_estoque.php - Atualiza item estoque (qtd + preços)
 * Arquivo responsável por atualizar quantidade e preços no banco
 */

// Inicia a sessão para controlar login
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    // Se não estiver logado, manda para o login
    exit;
    // Encerra o código por segurança
}

// ✅ PASSO 1: Conexão com o banco
include("conexao.php");
// Importa o arquivo de conexão com o banco de dados

// ✅ PASSO 2: Verificar se o formulário foi enviado corretamente (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Método inválido.';
    // Guarda mensagem de erro

    header("Location: estoque_cadastrado.php");
    // Volta para a página de estoque

    exit;
}

// Pegando os dados enviados pelo formulário
// trim() remove espaços desnecessários

$id = isset($_POST['id']) ? trim($_POST['id']) : '';
$qtd = isset($_POST['quantidade']) ? trim($_POST['quantidade']) : '';
$pf = isset($_POST['preco_fornecedor']) ? trim($_POST['preco_fornecedor']) : '';
$pv = isset($_POST['preco_venda']) ? trim($_POST['preco_venda']) : '';

// Validação: verifica se algum campo obrigatório está vazio
if (empty($id) || empty($qtd) || empty($pf) || empty($pv)) {
    $_SESSION['erro'] = 'Todos campos obrigatórios.';
    header("Location: estoque_cadastrado.php");
    exit;
}

// ✅ PASSO 3: Sanitização (segurança)
// Isso evita ataques como SQL Injection
// Limpa os dados antes de enviar para o banco

$id = mysqli_real_escape_string($conexao, $id);
$qtd = mysqli_real_escape_string($conexao, $qtd);
$pf = mysqli_real_escape_string($conexao, $pf);
$pv = mysqli_real_escape_string($conexao, $pv);

// ✅ PASSO 4: Validar ID e verificar se existe no banco

// Verifica se o ID é um número válido
if (!is_numeric($id)) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: estoque_cadastrado.php");
    exit;
}

// Consulta para ver se o item existe no banco
$check_id = "SELECT id FROM estoque WHERE id = $id";

// Executa a consulta e verifica se encontrou algum registro
if (mysqli_num_rows(mysqli_query($conexao, $check_id)) === 0) {
    $_SESSION['erro'] = 'Item estoque não encontrado.';
    header("Location: estoque_cadastrado.php");
    exit;
}

// ✅ PASSO 5: Validar valores numéricos

// Quantidade não pode ser negativa
if (!is_numeric($qtd) || $qtd < 0) {
    $_SESSION['erro'] = 'Quantidade inválida.';
    header("Location: estoque_cadastrado.php");
    exit;
}

// Preço do fornecedor deve ser maior que 0
if (!is_numeric($pf) || $pf <= 0) {
    $_SESSION['erro'] = 'Preço fornecedor inválido.';
    header("Location: estoque_cadastrado.php");
    exit;
}

// Preço de venda deve ser maior que 0
if (!is_numeric($pv) || $pv <= 0) {
    $_SESSION['erro'] = 'Preço venda inválido.';
    header("Location: estoque_cadastrado.php");
    exit;
}

// ✅ PASSO 6: Atualizar dados no banco
$sql = "UPDATE estoque SET 
        quantidade_calcas = '$qtd',
        preco_fornecedor = '$pf',
        preco_venda = '$pv'
        WHERE id = $id";
// Atualiza quantidade e preços do produto no banco

// Executa o update e verifica erro
if (!mysqli_query($conexao, $sql)) {
    $_SESSION['erro'] = 'Erro update estoque: ' . mysqli_error($conexao);
    header("Location: estoque_cadastrado.php");
    exit;
}

// ✅ PASSO 7: Sucesso
$_SESSION['sucesso'] = 'Estoque atualizado!';
// Mensagem de sucesso

header("Location: estoque_cadastrado.php");
// Redireciona de volta para a tela de estoque

exit;
// Finaliza o código
?>