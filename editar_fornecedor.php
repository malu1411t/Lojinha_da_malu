<?php
/**
 * editar_fornecedor.php - Formulário edição fornecedor
 * Página responsável por carregar os dados do fornecedor para edição
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

// Verifica se o método é GET e se o ID foi enviado
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    $_SESSION['erro'] = 'ID inválido.';
    // Guarda mensagem de erro

    header("Location: fornecedores_cadastrados.php");
    // Redireciona para lista de fornecedores

    exit;
}

// Remove espaços do ID
$id = trim($_GET['id']);

// Protege contra SQL Injection
$id = mysqli_real_escape_string($conexao, $id);

// Verifica se o ID é numérico e válido
if (!is_numeric($id) || $id <= 0) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// ✅ PASSO 3: Buscar dados do fornecedor

$sql = "SELECT * FROM fornecedor WHERE id = $id";
// Consulta para buscar o fornecedor pelo ID

$resultado = mysqli_query($conexao, $sql);
// Executa a consulta

// Verifica se deu erro ou não encontrou fornecedor
if (!$resultado || mysqli_num_rows($resultado) === 0) {
    $_SESSION['erro'] = 'Fornecedor não encontrado.';
    header("Location: fornecedores_cadastrados.php");
    exit;
}

// Pega os dados do fornecedor em forma de array
$dados = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html>
<head>

<title>Editar Fornecedor: <?= htmlspecialchars($dados['nome']) ?></title>
<!-- Mostra o nome do fornecedor no título (protegido contra XSS) -->

<style>

/* Estilo geral */
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

/* Efeito hover */
.botao:hover{
    background:#b58cff;
}

/* Mensagem de erro */
.erro-msg {
    color: red;
    background: #ffe6e6;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

</style>

</head>

<body>

<div class="topo">
Editar Fornecedor
</div>
<!-- Cabeçalho da página -->

<div class="container">

<?php if (isset($_SESSION['erro'])) { ?>
<!-- Verifica se existe erro -->
<div class="erro-msg">
<?= htmlspecialchars($_SESSION['erro']) ?>
</div>
<?php unset($_SESSION['erro']); } ?>
<!-- Mostra o erro e limpa da sessão -->

<form action="atualizar_fornecedor.php" method="POST">
<!-- Formulário envia dados para atualização -->

<input type="hidden" name="id" value="<?= htmlspecialchars($dados['id']) ?>">
<!-- Campo oculto com o ID -->

<label>Nome *</label>
<input type="text" name="nome" value="<?= htmlspecialchars($dados['nome']) ?>" required>
<!-- Campo nome preenchido com valor atual -->

<label>CNPJ *</label>
<input type="text" name="cnpj" value="<?= htmlspecialchars($dados['cnpj']) ?>" required maxlength="18" placeholder="00.000.000/0000-00">
<!-- Campo CNPJ com formato padrão -->

<label>Produto *</label>
<input type="text" name="produto" value="<?= htmlspecialchars($dados['produto']) ?>" required>
<!-- Produto fornecido -->

<label>Quantidade *</label>
<input type="number" name="quantidade" value="<?= $dados['produto_quantidade'] ?>" min="0" required>
<!-- Quantidade (não pode ser negativa) -->

<label>Preço (R$)*</label>
<input type="number" step="0.01" name="preco" value="<?= $dados['preco'] ?>" min="0" required>
<!-- Preço com casas decimais -->

<button class="botao" type="submit">
Salvar alterações
</button>
<!-- Botão de envio -->

</form>

<a href="fornecedores_cadastrados.php" style="display:block;text-align:center;margin-top:20px;color:#c8a2ff;">
← Voltar lista
</a>
<!-- Link para voltar -->

</div>
</body>
</html>