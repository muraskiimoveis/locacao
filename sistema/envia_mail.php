<?php
//select c_email from clientes where c_email!='' and c_email like '%@%' and c_email not LIKE '% %' and c_email not LIKE '%,%'

include ("smtp.class.php");

/* Configuração da classe.smtp.php */ 
$host = "smtp.muraski.com"; /*host do servidor SMTP */ 
$smtp = new Smtp($host);
$smtp->user = "muraski@muraski.com"; /*usuario do servidor SMTP */ 
$smtp->pass = "mari12"; /* senha dousuario do servidor SMTP*/ 
$smtp->debug =true; /* ativar a autenticação SMTP*/

/* envia uma mensagem */ 
$from= "Muraski" . "<muraski@muraski.com>"; /* seu e-mail */ 
$to = "Bruc" . " <paulo@bruc.com.br>"; /* o e-mail cadastrado*/ 
$subject = "Teste de e-mail utilizando SMTP"; /* assunto da mensagem */ 
$msg = "<b>Você está recebendo esta mensagem de teste</b><br>";
$msg .= "Para confirmar clique no link abaixo"; 
$smtp->Send($to, $from, $subject, $msg);/* faz o envio da mensagem */

?>