<?php
// Inicia a sessão para verificar login e usar mensagens
session_start();

// Inclui a conexão com o banco de dados
include("conexao.php");

// =========================
// 🔒 PROTEÇÃO DE LOGIN
// =========================

// Verifica se o usuário NÃO está logado
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    // Redireciona para login
    exit;
}

// =========================
// 📥 PEGAR ID
// =========================

// Pega o ID vindo pela URL (GET)
// Se não existir, define como vazio
$id = $_GET['id'] ?? '';

// Verifica se o ID está vazio
if(empty($id)){
    header("Location: vendedores_cadastrados.php");
    // Volta para lista
    exit;
}

// =========================
// 🔎 BUSCAR VENDEDOR
// =========================

// Consulta para buscar o vendedor pelo ID
$sql = "SELECT * FROM vendedor WHERE id = $id";

// Executa a consulta
$resultado = mysqli_query($conexao, $sql);

// Pega os dados do vendedor
$vendedor = mysqli_fetch_assoc($resultado);

// Se não encontrar o vendedor
if(!$vendedor){
    $_SESSION['erro'] = "Vendedor não encontrado!";
    header("Location: vendedores_cadastrados.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Editar Vendedor</title>

<style>

/* Estilo geral */
body{
    font-family:Arial;
    background:#f4f6f9;
    padding:20px;
}

/* Container central */
.container{
    max-width:500px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

/* Campos e botão */
input,button{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:6px;
    border:1px solid #ccc;
}

/* Botão */
button{
    background:#c8a2ff;
    color:#fff;
    border:none;
    font-weight:bold;
}

/* Hover botão */
button:hover{
    background:#b58cff;
}

/* Botão voltar */
.botao{
    display:block;
    text-align:center;
    padding:10px;
    background:#6c757d;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    margin-top:10px;
}

</style>

</head>

<body>

<div class="container">

<h2>✏️ Editar Vendedor</h2>
<!-- Título da página -->

<form action="atualizar_vendedor.php" method="POST">
<!-- Envia os dados para o arquivo que atualiza no banco -->

<input type="hidden" name="id" value="<?= $vendedor['id'] ?>">
<!-- Campo oculto com ID do vendedor -->

<input type="text" name="nome" value="<?= htmlspecialchars($vendedor['nome']) ?>" required>
<!-- Campo nome preenchido com valor atual (protegido contra XSS) -->

<input type="number" name="vendas" value="<?= $vendedor['vendas'] ?>" required>
<!-- Campo quantidade de vendas -->

<button type="submit">
💾 Salvar Alterações
</button>
<!-- Botão para enviar -->

</form>

<a class="botao" href="vendedores_cadastrados.php">
⬅ Voltar
</a>
<!-- Link para voltar -->

</div>

</body>
</html>