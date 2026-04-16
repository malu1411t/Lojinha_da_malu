<?php
/**
 * editar_estoque.php - Formulário edição estoque
 * Página responsável por carregar os dados do estoque para edição
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

    header("Location: estoque_cadastrado.php");
    // Redireciona para lista de estoque

    exit;
}

// Remove espaços do ID
$id = trim($_GET['id']);

// Protege contra SQL Injection
$id = mysqli_real_escape_string($conexao, $id);

// Verifica se o ID é numérico e maior que 0
if (!is_numeric($id) || $id <= 0) {
    $_SESSION['erro'] = 'ID inválido.';
    header("Location: estoque_cadastrado.php");
    exit;
}

// ✅ PASSO 3: Buscar dados do estoque

$sql = "SELECT * FROM estoque WHERE id = $id";
// Consulta para buscar o item do estoque

$resultado = mysqli_query($conexao, $sql);
// Executa a consulta

// Verifica se deu erro ou não encontrou o item
if (!$resultado || mysqli_num_rows($resultado) === 0) {
    $_SESSION['erro'] = 'Item de estoque não encontrado.';
    header("Location: estoque_cadastrado.php");
    exit;
}

// Pega os dados do estoque em forma de array
$dados = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html>
<head>

<title>Editar Estoque: <?= htmlspecialchars($dados['id']) ?></title>
<!-- Mostra o ID do item no título (protegido contra XSS) -->

<style>

/* Estilo geral da página */
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

/* Campos do formulário */
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

/* Efeito ao passar o mouse */
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
Editar Estoque
</div>
<!-- Cabeçalho da página -->

<div class="container">

<?php if (isset($_SESSION['erro'])) { ?>
<!-- Verifica se existe mensagem de erro -->
<div class="erro-msg">
<?= htmlspecialchars($_SESSION['erro']) ?>
</div>
<?php unset($_SESSION['erro']); } ?>
<!-- Mostra o erro e depois remove da sessão -->

<form action="atualizar_estoque.php" method="POST">
<!-- Formulário envia os dados para atualizar_estoque.php -->

<input type="hidden" name="id" value="<?= htmlspecialchars($dados['id']) ?>">
<!-- Campo oculto com o ID do item -->

<label>Quantidade *</label>
<input type="number" name="quantidade" value="<?= $dados['quantidade_calcas'] ?>" min="0" required>
<!-- Campo quantidade (não pode ser negativo) -->

<label>Preço Fornecedor (R$)*</label>
<input type="number" step="0.01" name="preco_fornecedor" value="<?= $dados['preco_fornecedor'] ?>" min="0" required>
<!-- Campo preço do fornecedor com casas decimais -->

<label>Preço Venda (R$)*</label>
<input type="number" step="0.01" name="preco_venda" value="<?= $dados['preco_venda'] ?>" min="0" required>
<!-- Campo preço de venda -->

<button class="botao" type="submit">
Salvar alterações
</button>
<!-- Botão para enviar o formulário -->

</form>

<a href="estoque_cadastrado.php" style="display:block;text-align:center;margin-top:20px;color:#c8a2ff;">
← Voltar lista
</a>
<!-- Link para voltar à lista -->

</div>

</body>
</html>