<?php
/**
 * atualiza_cliente.php - Atualiza dados do cliente e endereço associado
 * Arquivo responsável por atualizar informações no banco de dados
 */

// ✅ INÍCIO: Inicialização da sessão
session_start();
// Inicia a sessão para poder usar variáveis como $_SESSION
// Isso permite verificar se o usuário está logado

// Verifica se o usuário NÃO está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    // Se não estiver logado, manda para a tela de login
    exit;
    // Encerra o código por segurança
}

// ✅ PASSO 2: Conexão com o banco de dados
include("conexao.php");
// Importa o arquivo que faz a conexão com o banco

// Verifica se o formulário foi enviado pelo método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Método inválido. Use o formulário de edição.';
    // Guarda mensagem de erro na sessão

    header("Location: clientes_cadastrados.php");
    // Redireciona para a lista de clientes

    exit;
}

// Pegando os dados enviados pelo formulário
// trim() remove espaços extras antes e depois do texto

$id = isset($_POST['id']) ? trim($_POST['id']) : '';
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$rua = isset($_POST['rua']) ? trim($_POST['rua']) : '';
$numero = isset($_POST['numero']) ? trim($_POST['numero']) : '';
$complemento = isset($_POST['complemento']) ? trim($_POST['complemento']) : '';
$cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : '';

// Verifica se os campos obrigatórios estão vazios
if (empty($id) || empty($nome) || empty($cpf) || empty($rua) || empty($cidade)) {
    $_SESSION['erro'] = 'Todos os campos obrigatórios devem ser preenchidos.';

    header("Location: editar_cliente.php?id=" . urlencode($id));
    // Volta para a tela de edição mantendo o ID

    exit;
}

// ✅ Sanitização dos dados (segurança)
// Isso serve para evitar ataques no banco de dados (SQL Injection)
// Basicamente "limpa" os dados antes de usar no SQL

$id = mysqli_real_escape_string($conexao, $id);
$nome = mysqli_real_escape_string($conexao, $nome);
$cpf = mysqli_real_escape_string($conexao, $cpf);
$rua = mysqli_real_escape_string($conexao, $rua);
$numero = mysqli_real_escape_string($conexao, $numero);
$complemento = mysqli_real_escape_string($conexao, $complemento);
$cidade = mysqli_real_escape_string($conexao, $cidade);

// Verifica se o ID é um número válido
if (!is_numeric($id)) {
    $_SESSION['erro'] = 'ID do cliente inválido.';
    header("Location: clientes_cadastrados.php");
    exit;
}

// ✅ Verificar se o cliente existe no banco
$sql_check = "SELECT id, endereco_id FROM cliente WHERE id = $id LIMIT 1";
// Consulta que busca o cliente pelo ID

$resultado_check = mysqli_query($conexao, $sql_check);
// Executa a consulta

// Verifica se deu erro ou se não encontrou nenhum cliente
if (!$resultado_check || mysqli_num_rows($resultado_check) === 0) {
    $_SESSION['erro'] = 'Cliente não encontrado.';
    header("Location: clientes_cadastrados.php");
    exit;
}

// Pega os dados do cliente encontrado
$cliente_dados = mysqli_fetch_assoc($resultado_check);

// Guarda o ID do endereço relacionado ao cliente
$endereco_id = $cliente_dados['endereco_id'];

// Verifica se o cliente tem endereço cadastrado
if (empty($endereco_id)) {
    $_SESSION['erro'] = 'Endereço do cliente não encontrado.';
    header("Location: clientes_cadastrados.php");
    exit;
}

// ✅ Atualizar dados do cliente
$sql1 = "UPDATE cliente 
         SET nome='$nome', cpf='$cpf'
         WHERE id=$id";
// Atualiza o nome e CPF do cliente no banco

// Executa a atualização e verifica erro
if (!mysqli_query($conexao, $sql1)) {
    $_SESSION['erro'] = "Erro ao atualizar cliente: " . mysqli_error($conexao);
    header("Location: clientes_cadastrados.php");
    exit;
}

// ✅ Atualizar dados do endereço
$sql2 = "UPDATE endereco SET 
            rua='$rua',
            numero='$numero',
            complemento='$complemento',
            cidade='$cidade'
         WHERE id=$endereco_id";
// Atualiza os dados do endereço no banco

// Executa a atualização e verifica erro
if (!mysqli_query($conexao, $sql2)) {
    $_SESSION['erro'] = "Erro ao atualizar endereço: " . mysqli_error($conexao);
    header("Location: clientes_cadastrados.php");
    exit;
}

// ✅ Se tudo deu certo
$_SESSION['sucesso'] = 'Cliente e endereço atualizados com sucesso!';
// Mensagem de sucesso

header("Location: clientes_cadastrados.php");
// Redireciona de volta para a lista

exit;
// Finaliza o script
?>