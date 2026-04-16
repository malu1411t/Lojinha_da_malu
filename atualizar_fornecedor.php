<?php
/**
 * atualizar_fornecedor.php - Atualiza dados do fornecedor
 * Arquivo responsável por atualizar as informações de um fornecedor no banco
 */

// Inicia a sessão para controle de login
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    // Se não estiver logado, redireciona para o login
    exit;
    // Encerra o código por segurança
}

// ✅ PASSO 1: Conexão com o banco
include("conexao.php");
// Importa o arquivo que conecta ao banco de dados

// ✅ PASSO 2: Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Método inválido.';
    // Mensagem de erro caso não venha do formulário

    header("Location: fornecedores_cadastrados.php");
    // Volta para a página de fornecedores

    exit;
}

// Pegando os dados enviados pelo formulário
// trim() remove espaços extras

$id = isset($_POST['id']) ? trim($_POST['id']) : '';
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cnpj = isset($_POST['cnpj']) ? trim($_POST['cnpj']) : '';
$produto = isset($_POST['produto']) ? trim($_POST['produto']) : '';
$quantidade = isset($_POST['quantidade']) ? trim($_POST['quantidade']) : '';
$preco = isset($_POST['preco']) ? trim($_POST['preco']) : '';

// Validação: verifica se todos os campos obrigatórios foram preenchidos
if (empty($id) || empty($nome) || empty($cnpj) || empty($produto) || empty($quantidade) || empty($preco)) {
    $_SESSION['erro'] = 'Todos campos obrigatórios.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// ✅ PASSO 3: Sanitização dos dados (segurança)
// Evita ataques como SQL Injection (inserção de código malicioso no banco)

$id = mysqli_real_escape_string($conexao, $id);
$nome = mysqli_real_escape_string($conexao, $nome);
$cnpj = mysqli_real_escape_string($conexao, $cnpj);
$produto = mysqli_real_escape_string($conexao, $produto);
$quantidade = mysqli_real_escape_string($conexao, $quantidade);
$preco = mysqli_real_escape_string($conexao, $preco);

// ✅ PASSO 4: Verificar se o ID é válido e existe no banco

// Confere se o ID é numérico
if (!is_numeric($id)) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// Consulta para verificar se o fornecedor existe
$check_id = "SELECT id FROM fornecedor WHERE id = $id";

// Executa a consulta e verifica se encontrou resultado
if (mysqli_num_rows(mysqli_query($conexao, $check_id)) === 0) {
    $_SESSION['erro'] = 'Fornecedor não encontrado.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// ✅ PASSO 5: Validar CNPJ

// Verifica se o CNPJ tem exatamente 14 números (sem letras ou símbolos)
if (!preg_match('/^\d{14}$/', $cnpj)) {
    $_SESSION['erro'] = 'CNPJ 14 dígitos.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// Verifica se já existe outro fornecedor com o mesmo CNPJ
// (exceto o próprio fornecedor que está sendo editado)
$check_cnpj = "SELECT id FROM fornecedor WHERE cnpj = '$cnpj' AND id != $id";

if (mysqli_num_rows(mysqli_query($conexao, $check_cnpj)) > 0) {
    $_SESSION['erro'] = 'CNPJ duplicado.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// ✅ PASSO 6: Validar valores numéricos

// Quantidade deve ser maior que 0
if (!is_numeric($quantidade) || $quantidade <= 0) {
    $_SESSION['erro'] = 'Quantidade inválida.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// Preço também deve ser maior que 0
if (!is_numeric($preco) || $preco <= 0) {
    $_SESSION['erro'] = 'Preço inválido.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// ✅ PASSO 7: Atualizar dados no banco
$sql = "UPDATE fornecedor SET 
        nome = '$nome',
        cnpj = '$cnpj',
        produto = '$produto',
        produto_quantidade = '$quantidade',
        preco = '$preco'
        WHERE id = $id";
// Atualiza os dados do fornecedor no banco

// Executa o update e verifica erro
if (!mysqli_query($conexao, $sql)) {
    $_SESSION['erro'] = 'Erro update: ' . mysqli_error($conexao);
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// ✅ PASSO 8: Sucesso
$_SESSION['sucesso'] = 'Fornecedor atualizado!';
// Mensagem de sucesso

header("Location: fornecedores_cadastrados.php");
// Redireciona para a lista de fornecedores

exit;
// Finaliza o código
?>