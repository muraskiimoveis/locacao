<?php
/*
Script para configuração do chat
Criado em 05/07/2008
Por Hédi Carlos Minin - hediminin@hotmail.com
*/

$enableLog = true; //habilita log
$logDir = 'log/'; //diretorio do log
$maxUsers = 30; //máximo de usuários permitido

$time = time();  //tempo atual
$lifeTimeUser = $time + 120;  //tempo de vida do usuário
$lifeTimeMessage = $time + 90;  //tempo de vida da mensagem
?>