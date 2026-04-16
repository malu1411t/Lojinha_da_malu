<?php
session_start(); 
// Inicia a sessão para que o PHP consiga acessar a sessão atual do usuário

session_destroy(); 
// Destroi toda a sessão existente
// Isso faz o usuário "deslogar", apagando os dados armazenados (ex: login)

header("Location: login.php"); 
// Redireciona o usuário automaticamente para a página de login

exit;
// Encerra a execução do script imediatamente
// Evita que qualquer outro código seja executado após o redirecionamento
?>