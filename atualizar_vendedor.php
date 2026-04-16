<?php
// Inicia a sessão para usar mensagens (sucesso/erro)
session_start();

// Inclui a conexão com o banco de dados
include("conexao.php");

// Pegando os dados enviados pelo formulário (POST)
$id = $_POST['id'];
$nome = $_POST['nome'];
$vendas = $_POST['vendas'];
// Aqui os dados vêm diretamente do formulário

// Monta o comando SQL para atualizar o vendedor
$sql = "UPDATE vendedor 
        SET nome='$nome', vendas='$vendas' 
        WHERE id=$id";
// Atualiza o nome e quantidade de vendas do vendedor com base no ID

// Executa o comando no banco
if(mysqli_query($conexao, $sql)){
    $_SESSION['sucesso'] = "Vendedor atualizado com sucesso!";
    // Se deu certo, salva mensagem de sucesso
} else {
    $_SESSION['erro'] = "Erro ao atualizar!";
    // Se deu erro, salva mensagem de erro
}

// Redireciona para a tela de vendedores
header("Location: vendedores_cadastrados.php");

// Encerra o código
exit;
?>