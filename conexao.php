<?php
// ========================================================
 // conexao.php - Conexão MySQLi central projeto
// Classe mysqli OOP + error check

// Linha 3: Config DB servidor XAMPP localhost
$host = "localhost"; // Host DB
$user = "root"; // User padrão XAMPP
$pass = ""; // Sem senha XAMPP local
$db = "lojinha_da_malu"; // Database nome projeto

// Linha 7: new mysqli() - Conexão OOP (procedural mysqli_connect também ok)
$conexao = new mysqli($host, $user, $pass, $db);

// Linha 10: ✅ Verifica erro conexão (connect_error property)
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error); // Para execução + erro
}

// Conexão OK! $conexao global todos arquivos via include
// charset UTF8 automático mysqli, bom BR accents
?>

