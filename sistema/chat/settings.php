<?php
/*
Script para configura��o do chat
Criado em 05/07/2008
Por H�di Carlos Minin - hediminin@hotmail.com
*/

$enableLog = true; //habilita log
$logDir = 'log/'; //diretorio do log
$maxUsers = 30; //m�ximo de usu�rios permitido

$time = time();  //tempo atual
$lifeTimeUser = $time + 120;  //tempo de vida do usu�rio
$lifeTimeMessage = $time + 90;  //tempo de vida da mensagem
?>