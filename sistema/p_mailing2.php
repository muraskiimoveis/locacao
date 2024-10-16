<?php
ini_set('max_execution_time','90');
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("MENSAGENS_GERAL");
?>
<html>
<head>
<?php
include("style.php");
?>
<?php
	if($enviado == ""){
?>
<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript">
      window.onload = function()
      {
        var oFCKeditor = new FCKeditor( 'texto' ) ;
        oFCKeditor.Height = "400"
        oFCKeditor.BasePath = "FCKeditor/" ;
        oFCKeditor.ReplaceTextarea() ;
      }
    </script>
<?php
	}
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? //include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
//include("menu.php");
?></td>
  </tr>
</table>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/
?>
<p>
<?php
	if($enviado == "1"){
?>
<?php
if(($email_de == ""))
	{
?>
<font color="#ff0000" size="2" face="Verdana">
<b>Você esqueceu de preencher algum campo obrigatório!</b><br>
<a href="javascript:history.back()"><< Clique aqui para voltar <<</a><br><br>
<?php
	}
	else
	{
	session_register("enviado");
		
## CONFIGURAÇÃO DOS E-MAILS (ASSUNTO, CORPO DE MENSAGEM, REMETENTE, E-MAIL DO REMETENTE)
//$assunto = "Envio de e-mail em Massa, temporizado";
//$mensagem = "Prezados\r\n";
//$mensagem .= "Este e-mail é um teste, simulando o envio de blocos de mensagens em períodos de tempo\r\n";
//$remetente = "CPV";
//$email_remet = "cpvendas@cpvendas.com.br";

//$campos= id, usuario, status;

## Número de Mensagens enviadas por Blocos,
$msg_num = 10;

## Tempo, em segundos, entre os Blocos de E-mail
$sec = 3;

$ok = 0;
	
	if(!$_SESSION['inicio']){
		$inicio = 0;
	}
	else
	{
		$inicio = $_SESSION['inicio'];
	}

$fim = $inicio + $msg_num;

/*
$sql = "select c_cod, c_email, c_nome from clientes 
where c_email!='' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_email like '%@%' and c_email not LIKE '% %' and c_email not LIKE '%,%' 
limit $inicio,$msg_num";
*/

$sql = "select usuarios_id, usuarios_email, usuarios_nome from teste_usuarios 
where usuarios_email!='' and usuarios_email like '%@%' and usuarios_email not LIKE '% %' and usuarios_email not LIKE '%,%' limit $inicio,$msg_num";
//$sql = "select c_email, c_nome from clientes 
//where c_email='paulo@bruc.com.br' and c_email like '%@%' and c_email not LIKE '% %' and c_email not LIKE '%,%' 
//limit $inicio,$msg_num";
//$sql = "select * from clientes2 where c_email='pauloens@bruc.com.br' order by c_nome limit $inicio,$msg_num";
$query = mysql_query($sql) or die ("erro 114:". mysql_error());
$registros = mysql_num_rows($query);

if($registros==0)   {

        //mysql_query("update usuario set status = 0");
        printf("<font face='verdana'><b>As mensagens foram enviadas com sucesso.</b></font>");
        $ok = 1;
        session_unregister("inicio");
        session_unregister("enviado");
        session_unregister("t_prod");
        session_unregister("assunto");
        session_unregister("texto");
        session_unregister("email_de");
        session_unregister("nome_de");
        //echo $total_msg;
        session_unregister("total_msg");
    }
    else
    {
    		echo "<p align=center class=style7><font size=4><b>ATENÇÃO! Aguarde a mensagem de que as mensagens foram enviadas</b></font></p><br>";
    }

while($result = mysql_fetch_array($query))
{
$id = $result[usuarios_id];
$para = $result[usuarios_email];
$nome_para = $result[usuarios_nome];
//$para = "arturffp@jmalucelli.com.br";
//$status = $result[2];
$total_msg++;

$texto = stripslashes($texto);
$body = "<html><body bgcolor=#FFFFFF leftmargin=0 topmargin=0 marginwidth=0 marginheight=0>$texto</body></html>";
session_register("c_cod");
session_register("assunto");
session_register("texto");
session_register("email_de");
session_register("nome_de");
session_register("total_msg");

//$headers = "From: $nome_de <$email_de>\n" . "Return-path: muraski@muraski.com\n" . "Mime-Version: 1.0\nContent-Type: text/html; charset=\"iso-8859-1\"\n";
//$headers .= "Bcc: $result[c_email]\r\n";

//mail("$para","$assunto","$body","$headers");


    $address = "$nome_para <$para>";
	$de = "From: $nome_de <$email_de>\n" . "Return-path: muraski@muraski.com\n" . "Mime-Version: 1.0\nContent-Type: text/html; charset=\"iso-8859-1\"\n";
	$subject = "$assunto";
	$body = "<html><body><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
      <tr>
      	<td><font color=#000000 size=2 face=Verdana, Arial, Helvetica, sans-serif>$texto</font></td>
      </tr>
    </table></body></html>";
	
	mail($address, $subject, $body, $de);


/* Configuração da classe.smtp.php */ 
//$host = "smtp.muraski.com"; /*host do servidor SMTP */ 
//$smtp = new Smtp($host);
//$smtp->user = "sistema@muraski.com"; /*usuario do servidor SMTP */ 
//$smtp->pass = "15sist56"; /* senha dousuario do servidor SMTP*/ 
//$smtp->debug =true; /* ativar a autenticação SMTP*/

/* envia uma mensagem */ 
//$from= $nome_de . "<" . $email_de . ">"; /* seu e-mail */ 
//$from = "From: $nome_de <$email_de>\n" . "Return-path: $email_de\n" . "Mime-Version: 1.0\nContent-Type: text/html; charset=\"iso-8859-1\"\n";
//$to = $nome_para . " <" . $para . ">"; /* o e-mail cadastrado*/ 
//$subject = $assunto; /* assunto da mensagem */ 
//$msg = $texto;
//$msg .= "Para confirmar clique no link abaixo"; 
//$smtp->Send($to, $from, $subject, $msg);/* faz o envio da mensagem */


//mysql_query("update usuario set status = 1 where id = $id");
printf("<font face='verdana'>[$total_msg] mensagem para <b>$para</b> <font color='#ff0000'>enviada com sucesso!</font></font><br>");
}

//mysql_free_result($query);

if(!$ok){
//echo $texto;
$inicio = $inicio + $msg_num;
//$inicio++;
session_register("inicio");
echo("<meta http-equiv=\"refresh\" content=\"" . $sec . "\">");
}
?>
<table>
<?php
	/*
	//$query1 = "select * from clientes where c_email='paulo@bruc.com.br' order by c_nome";
	$query1 = "select * from clientes order by c_nome";
	$result1 = mysql_query($query1);
	while($not = mysql_fetch_array($result1))
	{
	
	$assunto = stripslashes($assunto);
	$texto = stripslashes($texto);
	if($html == "Nao"){
	$texto = str_replace("\n","<br>","$texto");
	}
	
	$address = "$not[c_nome] <$not[c_email]>";
	//$address = "Lista Pares <adm-informativo@lista.pares.com.br>";
	//$address = "Paulo <paulo@bruc.com.br>";
	$de = "From: $nome_de <$email_de>\n" . "Return-path: $email_de\n" . "Mime-Version: 1.0\nContent-Type: text/html; charset=\"iso-8859-1\"\n";
	//$de = "From: pares@pares.com.br";
	$subject = "$assunto";
	$body = "<html><body bgcolor=#FFFFFF leftmargin=0 topmargin=0 marginwidth=0 marginheight=0>$texto</body></html>";
	
	mail("$address", "$subject", "$body", "$de");
?>
<tr><td><font color="#000000" size="2" face="Arial">
<?php print("$not[usuarios_nome]"); ?></td><td><font color="#000000" size="2" face="Arial">
<?php print("$not[usuarios_email]"); ?></td></tr>
<?php
	}
	*/
?>
</table>
<?php
	}
?>
<?php
	}
	else
	{
?>
<script>
function valida()
{
  if (form1.assunto.value == "")
  {
    alert("Por favor, digite o Assunto da Mensagem");
    form1.assunto.focus();
    return (false);
  }
	return(true);
}
</script>
 <p align="center"><b>Enviar Mailing</b><br></p>
 <div align="center">
  <center>
  <form method="post" name="form1" onSubmit="return valida();" action="<?php print("$PHP_SELF"); ?>">
  <input type=hidden name=enviado value=1>
  <table border="0" cellspacing="2" width="100%">
    <tr>
      <td width="30%"><b>Nome do remetente:</b></td>
      <td width="70%"> <input type="text" name="nome_de" size="40" value="Muraski Imóveis" class=campo></td>
    </tr>
    <tr>
      <td width="30%"><b>E-mail do remetente:</b></td>
      <td width="70%"> <input type="text" name="email_de" size="40" value="sistema@muraski.com" class=campo></td>
    </tr>
    <tr>
      <td width="30%"><b>Assunto:</b></td>
      <td width="70%"> <input type="text" name="assunto" size="40" class=campo value=""></td>
    </tr>
    <tr>
      <td align="left" colspan=2><b>Texto:</b></td>
    </tr><tr>
      <td colspan=2> <textarea rows="15" name="texto" cols="70" class=campo></textarea></td>
    </tr>
    <tr>
      <td width="30%" valign="top">
      <input type="submit" value="Enviar Mailing" name="B1" class=campo3></td>
      <td width="70%" class="style7">ATENÇÃO! Após clicar para enviar o mailing será necessário esperar o processo terminar para que todos os clientes recebam o e-mail.</td>
    </tr>
  </table>
  </form>
<?php
	}//fim do if enviado
?>
<?php
/*
	}
	else
	{
*/		
?>
<?php
//include("login2.php");
?>
<?php
//	}
?>
</body>
</html>