<?php
/**
 * editar_cliente.php - Formulário edição cliente + validação ID
 * Página responsável por carregar os dados do cliente para edição
 */

// Inicia a sessão para controle de login e mensagens
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

// ✅ PASSO 2: Validar ID vindo pela URL (GET)

// Verifica se o método é GET e se existe o ID
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    $_SESSION['erro'] = 'ID inválido.';
    // Guarda mensagem de erro

    header("Location: clientes_cadastrados.php");
    // Redireciona para lista de clientes

    exit;
}

// Remove espaços do ID recebido
$id = trim($_GET['id']);

// Protege contra SQL Injection
$id = mysqli_real_escape_string($conexao, $id);

// Verifica se o ID é numérico e maior que 0
if (!is_numeric($id) || $id <= 0) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: clientes_cadastrados.php");
    exit;
}

// ✅ PASSO 3: Buscar cliente com JOIN (cliente + endereço)

// SELECT com JOIN para trazer dados de duas tabelas
$sql = "SELECT cliente.*, endereco.rua, endereco.numero, endereco.complemento, endereco.cidade
        FROM cliente
        JOIN endereco ON cliente.endereco_id = endereco.id
        WHERE cliente.id = $id";

// Executa a consulta
$resultado = mysqli_query($conexao, $sql);

// Verifica se deu erro ou não encontrou cliente
if (!$resultado || mysqli_num_rows($resultado) === 0) {
    $_SESSION['erro'] = 'Cliente não encontrado.';
    header("Location: clientes_cadastrados.php");
    exit;
}

// Pega os dados do cliente em forma de array
$dados = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html>
<head>

<title>Editar Cliente</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

/* Cabeçalho */
.topo{
    background:#c8a2ff;
    color:white;
    padding:18px;
    text-align:center;
    font-size:24px;
    font-weight:bold;
}

/* Container principal */
.container{
    width:500px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0px 5px 15px rgba(0,0,0,0.15);
}

/* Campos */
input{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid #ccc;
}

/* Botão */
.botao{
    width:100%;
    padding:12px;
    background:#c8a2ff;
    color:white;
    border:none;
    border-radius:6px;
    font-weight:bold;
    cursor:pointer;
}

/* Hover do botão */
.botao:hover{
    background:#b58cff;
}

/* Estilo de erro (só aparece se houver erro) */
<?php if (isset($_SESSION['erro'])) { ?>
.erro-msg {
    color: red;
    background: #ffe6e6;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}
<?php unset($_SESSION['erro']); } ?>
</style>

</head>

<body>

<div class="topo">
Editar Cliente: <?= htmlspecialchars($dados['nome']) ?>
</div>
<!-- Mostra o nome do cliente no topo com proteção contra XSS -->

<div class="container">

<?php if (isset($_SESSION['erro'])) { ?>
<!-- Exibe mensagem de erro, se existir -->
<div class="erro-msg">
<?= htmlspecialchars($_SESSION['erro']) ?>
</div>
<?php unset($_SESSION['erro']); } ?>
<!-- Remove o erro da sessão após mostrar -->

<form action="atualizar_cliente.php" method="POST">
<!-- Formulário envia os dados para atualizar_cliente.php -->

<input type="hidden" name="id" value="<?= htmlspecialchars($dados['id']) ?>">
<!-- Campo oculto com o ID do cliente -->

<label>Nome *</label>
<input type="text" name="nome" value="<?= htmlspecialchars($dados['nome']) ?>" required>
<!-- Campo nome preenchido com valor atual -->

<label>CPF *</label>
<input type="text" name="cpf" value="<?= htmlspecialchars($dados['cpf']) ?>" required maxlength="14">
<!-- Campo CPF com limite de 14 caracteres -->

<label>Rua *</label>
<input type="text" name="rua" value="<?= htmlspecialchars($dados['rua']) ?>" required>

<label>Número</label>
<input type="text" name="numero" value="<?= htmlspecialchars($dados['numero']) ?>">

<label>Complemento</label>
<input type="text" name="complemento" value="<?= htmlspecialchars($dados['complemento']) ?>">

<label>Cidade *</label>
<input type="text" name="cidade" value="<?= htmlspecialchars($dados['cidade']) ?>" required>

<button class="botao" type="submit">
Salvar alterações
</button>
<!-- Botão para enviar o formulário -->

</form>

<a href="clientes_cadastrados.php" style="display:block;text-align:center;margin-top:20px;color:#c8a2ff;">
← Voltar
</a>
<!-- Link para voltar -->

</div>
</body>
</html>