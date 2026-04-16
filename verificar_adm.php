<?php
// ========================================================
// verificar_adm.php - Proteção middleware ADM apenas
// Usado include() em páginas admin para bloquear não-adm
// Simples redirect se não logado ou não tipo 'adm'

// Linha 1: session_start() - Inicia/verifica sessão ativa
session_start();

// Linha 3-6: 🔒 VERIFICAÇÃO ADM ESTRICTA
// isset($_SESSION['logado']) verifica flag + tipo == 'adm'
// header Location força redirect 302, exit para segurança absoluta
if(!isset($_SESSION['logado']) || $_SESSION['tipo'] != 'adm'){
    header("Location: login.php"); // Non-admin → login
    exit; // Para execução imediata - NÃO CONTINUA
}

// Se passou = ADM autenticado, página continua normal
// Sem echo/output para use como include silencioso
?>

