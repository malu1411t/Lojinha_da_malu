<?php
// ========================================================
// admin.php - DASHBOARD PRINCIPAL ADMINISTRADOR
// Essa página mostra o painel do admin com acesso às funções do sistema

session_start(); 
// Inicia a sessão do PHP
// A sessão serve para guardar informações do usuário logado (como login e tipo de usuário)
// Sem isso, não conseguimos saber quem está usando o sistema

// Verifica se o usuário NÃO está logado OU não é administrador
if (!isset($_SESSION['logado']) || $_SESSION['tipo'] != 'adm') {
    // isset verifica se a variável existe
    // $_SESSION['logado'] indica se o usuário fez login
    // $_SESSION['tipo'] guarda o tipo do usuário (ex: adm, vendedor, etc)
    
    header("Location: login.php"); 
    // Se não for admin, ele é redirecionado para a tela de login
    
    exit(); 
    // Encerra o código imediatamente por segurança
    // Isso evita que o restante da página seja carregado indevidamente
}

include("conexao.php"); 
// Inclui o arquivo de conexão com o banco de dados
// Mesmo que não esteja usando agora, já deixa preparado caso precise buscar dados
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- Define acentuação correta (evita erro com caracteres especiais tipo ç e acentos) -->

    <title>Painel Admin</title>

    <style>
    body{
        font-family:Arial;
        background:#f4f6f9;
        margin:0;
    }

    .topo{
        background:linear-gradient(90deg,#c8a2ff,#b58cff);
        color:#fff;
        padding:20px;
        text-align:center;
        font-size:26px;
        font-weight:bold;
    }

    .container{
        width:900px;
        margin:40px auto;
        background:#fff;
        padding:35px;
        border-radius:12px;
        box-shadow:0 5px 15px rgba(0,0,0,.15);
        text-align:center;
    }

    h2{
        color:#555;
        margin-bottom:20px;
    }

    .botao{
        display:block;
        width:100%;
        padding:12px;
        margin-top:10px;
        background:#c8a2ff;
        color:#fff;
        text-decoration:none;
        border-radius:6px;
        font-weight:bold;
    }

    .botao:hover{
        background:#b58cff;
    }
    </style>
</head>

<body>

<div class="topo">
    Painel Administrativo
</div>
<!-- Cabeçalho principal do sistema -->

<div class="container">

    <h2>Controle do Sistema</h2>
    <!-- Título da área administrativa -->

    <!-- Links para acessar os módulos do sistema -->
    <a class="botao" href="clientes_cadastrados.php">👥 Ver Clientes</a>
    <!-- Direciona para a página que lista os clientes cadastrados -->

    <a class="botao" href="fornecedores_cadastrados.php">💼 Ver Fornecedores</a>
    <!-- Direciona para a página de fornecedores -->

    <a class="botao" href="vendedores_cadastrados.php">🧑‍💼 Ver Vendedores</a>
    <!-- Direciona para a página de vendedores -->

    <a class="botao" href="estoque_cadastrado.php">📦 Ver Estoque</a>
    <!-- Direciona para o controle de estoque -->

    <a class="botao" href="cadastrar_login.php">
        🔐 Cadastrar Login (ADM / Vendedor)
    </a>
    <!-- Página usada para cadastrar novos usuários no sistema -->

    <br>

    <a class="botao" href="painel.php">⬅ Voltar</a>
    <!-- Volta para o painel principal do sistema -->

</div>

</body>
</html>