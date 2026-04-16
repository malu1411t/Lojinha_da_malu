<?php
echo password_hash("141108", PASSWORD_DEFAULT);
// password_hash() é uma função do PHP usada para CRIPTOGRAFAR (gerar hash) uma senha
// "141108" é a senha em texto puro (senha original)
// PASSWORD_DEFAULT diz ao PHP para usar o algoritmo mais seguro disponível no momento (atualmente bcrypt)
// echo serve para exibir o resultado na tela (o hash gerado)
?>