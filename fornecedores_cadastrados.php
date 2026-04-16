<?php
session_start(); // Inicia a sessão do PHP para manter dados do usuário logado (se houver)
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// 🔍 Captura o valor da pesquisa (se existir)
// Se existir "pesquisa" na URL, ele pega o valor, senão deixa vazio
$pesquisa = $_GET['pesquisa'] ?? '';

// 🔍 Query com filtro (nome ou CNPJ)
// Monta a consulta SQL buscando na tabela fornecedor
// Ele procura no campo nome OU cnpj o valor digitado na pesquisa
$sql = "SELECT * FROM fornecedor 
        WHERE nome LIKE '%$pesquisa%' 
        OR cnpj LIKE '%$pesquisa%' 
        ORDER BY id DESC";

// Executa a query no banco de dados usando a conexão
$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8"> <!-- Define o padrão de caracteres para aceitar acentos -->
<title>Fornecedores</title> <!-- Título da página na aba do navegador -->

<style>
body{font-family:Arial;background:#f4f6f9;margin:0;} 
/* Define a fonte da página, cor de fundo e remove margem padrão */

.topo{
background:linear-gradient(90deg,#c8a2ff,#b58cff); /* Gradiente roxo no topo */
color:#fff; /* Texto branco */
padding:20px; /* Espaçamento interno */
text-align:center; /* Centraliza o texto */
font-size:26px; /* Tamanho da fonte */
font-weight:bold; /* Deixa o texto em negrito */
}

.container{
width:900px; /* Largura fixa do conteúdo */
margin:40px auto; /* Centraliza horizontalmente e dá espaço em cima */
background:#fff; /* Fundo branco */
padding:30px; /* Espaçamento interno */
border-radius:12px; /* Bordas arredondadas */
box-shadow:0 5px 15px rgba(0,0,0,.15); /* Sombra suave */
}

/* 🔍 pesquisa */
.pesquisa{
text-align:center; /* Centraliza o formulário */
margin-bottom:15px; /* Espaço abaixo */
}

.pesquisa input{
padding:10px; /* Espaçamento interno do campo */
width:250px; /* Largura do input */
border-radius:6px; /* Bordas arredondadas */
border:1px solid #ccc; /* Borda cinza */
}

.pesquisa button{
padding:10px; /* Espaçamento interno do botão */
background:#c8a2ff; /* Cor roxa */
color:#fff; /* Texto branco */
border:none; /* Remove borda padrão */
border-radius:6px; /* Bordas arredondadas */
cursor:pointer; /* Cursor de clique */
}

table{
width:100%; /* Tabela ocupa toda a largura */
border-collapse:collapse; /* Remove espaços entre bordas */
margin-top:20px; /* Espaço acima da tabela */
}

th{
background:#c8a2ff; /* Fundo roxo no cabeçalho */
color:#fff; /* Texto branco */
padding:12px; /* Espaçamento interno */
}

td{
padding:10px; /* Espaçamento interno das células */
border-bottom:1px solid #ddd; /* Linha separadora */
}

tr:hover{
background:#f3ebff; /* Efeito ao passar o mouse na linha */
}

/* 🔽 botões inferiores */
.acoes{
text-align:center; /* Centraliza os botões */
margin-top:20px; /* Espaço acima */
}

.botao{
display:inline-block; /* Permite aplicar padding e ficar lado a lado */
padding:10px 15px; /* Espaçamento interno */
background:#c8a2ff; /* Cor roxa */
color:#fff; /* Texto branco */
text-decoration:none; /* Remove sublinhado */
border-radius:6px; /* Bordas arredondadas */
margin:5px; /* Espaço entre botões */
}

.botao:hover{
background:#b58cff; /* Muda cor ao passar o mouse */
}
</style>

</head>
<body>

<div class="topo">Fornecedores Cadastrados</div> 
<!-- Título principal da página -->

<div class="container"> 
<!-- Caixa principal que envolve o conteúdo -->

<!-- 🔍 FORM DE PESQUISA -->
<form class="pesquisa" method="GET">
<!-- Formulário que envia os dados pela URL (GET) -->

<input type="text" name="pesquisa" placeholder="Buscar fornecedor..." value="<?= htmlspecialchars($pesquisa) ?>">
<!-- Campo de pesquisa onde o usuário digita
     value mantém o texto digitado após a busca -->

<button type="submit">Buscar</button>
<!-- Botão que envia o formulário -->

</form>

<table>

<tr>
<th>ID</th>
<th>Nome</th>
<th>CNPJ</th>
<th>Produto</th>
<th>Quantidade</th>
<th>Preço</th>
</tr>

<?php while($f = mysqli_fetch_assoc($resultado)): ?>
<!-- Loop que percorre cada fornecedor vindo do banco -->

<tr>
<td><?= $f['id'] ?></td> <!-- Mostra o ID -->
<td><?= htmlspecialchars($f['nome']) ?></td> <!-- Nome do fornecedor -->
<td><?= htmlspecialchars($f['cnpj']) ?></td> <!-- CNPJ -->
<td><?= htmlspecialchars($f['produto']) ?></td> <!-- Produto -->
<td><?= $f['produto_quantidade'] ?></td> <!-- Quantidade -->
<td>R$ <?= number_format($f['preco'],2,',','.') ?></td> <!-- Preço formatado em reais -->
</tr>

<?php endwhile; ?>
<!-- Final do loop -->

</table>

<!-- 🔽 BOTÕES EMBAIXO -->
<div class="acoes">

<a class="botao" href="fornecedor.php">➕ Novo Fornecedor</a>
<!-- Link para cadastrar novo fornecedor -->

<a class="botao" href="admin.php">⬅ Painel Administrativo</a>
<!-- Link para voltar ao painel -->

</div>

</div>

</body>
</html>