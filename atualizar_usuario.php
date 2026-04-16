<?php
// ========================================================
// atualizar_usuario.php - UPDATE usuário tabela 'login' via POST form editar_usuario.php
// Processa alterações usuario/tipo mantendo senha original (segurança)

session_start(); // Linha 5: Inicia sessão para proteção/verificação

include("conexao.php"); // Linha 6: Carrega conexão mysqli $conexao

// Linha 8-11: 🔒 PROTEÇÃO ADM - Apenas admins atualizam
if(!isset($_SESSION['logado']) || $_SESSION['tipo'] != 'adm'){
    header("Location: login.php"); // Non-admin redirect
    exit; // Para imediato
}

// Linha 14-16: Recebe POST form - id/usuario/tipo
$id = $_POST['id']; // ID hidden UPDATE WHERE
$usuario = $_POST['usuario']; // Novo nome usuário
$tipo = $_POST['tipo']; // Novo tipo adm/vendedor

// Linha 19-22: PREPARED UPDATE - SEGURANÇA SQL injection
// "ssi" = string, string, integer bind types
$stmt = mysqli_prepare($conexao, "UPDATE login SET usuario=?, tipo=? WHERE id=?");
mysqli_stmt_bind_param($stmt, "ssi", $usuario, $tipo, $id); // Bind params seguros
mysqli_stmt_execute($stmt); // Executa UPDATE

// Linha 24: Flash sucesso - mensagem sessão
$_SESSION['sucesso'] = "Atualizado com sucesso!";

// Linha 26-27: PRG redirect - Post/Redirect/Get evita resubmit F5
header("Location: cadastrar_login.php"); // Volta lista
exit; // Fim execução
?>

