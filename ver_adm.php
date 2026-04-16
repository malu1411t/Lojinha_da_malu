<?php
/**
 * ver_adm.php - Listagem ADMs segura 📋
 * Grupo LISTAGEM ADMIN - Session + XSS + mensagens
 */

session_start();

// ✅ PASSO 1: Verificação sessão
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

// ✅ PASSO 2: Conexão + query segura
include("conexao.php");

$sql = "SELECT * FROM adm ORDER BY id DESC";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    $_SESSION['erro'] = 'Erro ao carregar lista de ADMs.';
    header("Location: admin.php");
    exit;
}

// ✅ PASSO 3: Mensagens flash
$sucesso = $_SESSION['sucesso'] ?? '';
$erro = $_SESSION['erro'] ?? '';
unset($_SESSION['sucesso'], $_SESSION['erro']);
?>

<!DOCTYPE html>
<html>
<head>
<title>👑 Administradores Cadastrados</title>
<style>
body{font-family:Arial;background:#f4f6f9;margin:0;}
.topo{background: linear-gradient(90deg,#c8a2ff,#b58cff);color:white;padding:20px;text-align:center;font-size:26px;font-weight:bold;}
.container{width:900px;margin:40px auto;background:white;padding:35px;border-radius:12px;box-shadow:0px 5px 15px rgba(0,0,0,0.15);}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th{background:#c8a2ff;color:white;padding:15px;text-align:left;font-weight:bold;}
td{padding:12px;border-bottom:1px solid #eee;}
tr:hover{background:#f8f9ff;}
.botao{padding:12px 18px;background:#c8a2ff;color:white;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;margin:5px;}
.botao:hover{background:#b58cff;}
.editar{color:#3b5bdb;text-decoration:none;font-weight:bold;padding:4px 8px;border-radius:4px;}
.editar:hover{background:#e3f2fd;}
.excluir{color:#d11a2a;text-decoration:none;font-weight:bold;padding:4px 8px;border-radius:4px;}
.excluir:hover{background:#ffe6e6;}
.msg-sucesso{color:#155724;background:#d4edda;border:1px solid #c3e6cb;padding:12px;border-radius:6px;margin-bottom:20px;}
.msg-erro{color:#721c24;background:#f8d7da;border:1px solid #f5c6cb;padding:12px;border-radius:6px;margin-bottom:20px;}
.sem-dados{text-align:center;padding:40px;color:#666;font-size:18px;}
</style>
</head>
<body>
<div class="topo">👑 Administradores Cadastrados</div>
<div class="container">
<?php if ($sucesso): ?>
<div class="msg-sucesso"><?= htmlspecialchars($sucesso) ?></div>
<?php endif; ?>
<?php if ($erro): ?>
<div class="msg-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>
<h2>Gerenciar Administradores (<?= mysqli_num_rows($resultado) ?>)</h2>
<?php if (mysqli_num_rows($resultado) === 0): ?>
<div class="sem-dados">Nenhum administrador cadastrado. <a href="cadastrar_adm.php" class="botao">Criar primeiro 👑</a></div>
<?php else: ?>
<table>
<tr>
<th>ID</th>
<th>Usuário</th>
<th>Data Cadastro</th>
<th>Ações</th>
</tr>
<?php while($adm = mysqli_fetch_assoc($resultado)): ?>
<tr>
<td><strong>#<?= $adm['id'] ?></strong></td>
<td><?= htmlspecialchars($adm['nome']) ?></td>
<td><?= date('d/m/Y H:i', strtotime($adm['data_cadastro'])) ?></td>
<td>
<a class="editar" href="editar_adm.php?id=<?= $adm['id'] ?>">✏️ Editar</a> |
<a class="excluir" href="excluir_adm.php?id=<?= $adm['id'] ?>" onclick="return confirm('⚠️ EXCLUIR <?= htmlspecialchars($adm['nome']) ?>?\nEsta ação é irreversível!');">🗑️ Excluir</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<?php endif; ?>
<div style="margin-top:30px;">
<a class="botao" href="cadastrar_adm.php">➕ Cadastrar Novo ADM</a>
<a class="botao" href="admin.php">⬅ Voltar ao Painel Principal</a>
</div>
</div>
</body>
</html>
