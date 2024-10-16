<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<html>
<head>
<?php
include("style.php");
?>
<script language="Javascript1.2"><!-- // load htmlarea
_editor_url = "/painel/htmlarea/";                     // URL to htmlarea files
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
 document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
 document.write(' language="Javascript1.2"></scr' + 'ipt>');  
} else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }
// --></script>
</head>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/
?>
<body topmargin=0 leftmargin=0 rightmargin=0>
<table width=100% height=100%>
<tr><td bgcolor="<?php print("$barra_lat"); ?>" valign=top width=150>
<?php
include("menu_painel.php");
?></td>
<td width=620 valign=top>
<br>
<?php
include("conect.php");
?>
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
$sec = 1;

$ok = 0;
	
	if(!$_SESSION['inicio']){
		$inicio = 0;
	}
	else
	{
		$inicio = $_SESSION['inicio'];
	}

$fim = $inicio + $msg_num;

$sql = "select * from clientes2 where c_mailing='sim' order by c_nome limit $inicio,$msg_num";
//$sql = "select * from clientes2 where c_email='pauloens@bruc.com.br' order by c_nome limit $inicio,$msg_num";
//echo $sql;
$query = mysql_query($sql);
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
$id = $result[c_cod];
$para = $result[c_email];
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

$headers = "From: $nome_de <$email_de>\n" . "Return-path: $email_de\n" . "Mime-Version: 1.0\nContent-Type: text/html; charset=\"iso-8859-1\"\n";
//$headers .= "Bcc: $result[c_email]\r\n";

mail("$para","$assunto","$body","$headers");

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
<?php print("$not[c_nome]"); ?></td><td><font color="#000000" size="2" face="Arial">
<?php print("$not[c_email]"); ?></td></tr>
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
 <p align="center"><b>Enviar Mailing</b><br>
 <a href="p_cllientes.php" class=linkm>
 Clique para visualizar a relação de Clientes cadastrados</a></p>
 <div align="center">
  <center>
  <form method="post" name="form1" onsubmit="return valida();" action="<?php print("$PHP_SELF"); ?>">
  <input type=hidden name=enviado value=1>
  <table border="0" cellspacing="2" width="100%">
    <tr>
      <td width="30%"><b>Nome do remetente:</b></td>
      <td width="70%"> <input type="text" name="nome_de" size="40" value="PAM - Paraná Banco Asset Management" class=campo></td>
    </tr>
    <tr>
      <td width="30%"><b>E-mail do remetente:</b></td>
      <td width="70%"> <input type="text" name="email_de" size="40" value="pam@paranafundos.com.br" class=campo></td>
    </tr>
<?php
	if($n_cod != ""){
		
	$query2 = "select * from noticias where n_cod = '$n_cod'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
		$txt = $not2[n_txt];
		$assunto = $not2[n_nome];
	}
	
	}
	
	if($txt == ""){
		$txt = "";
	}
	$dia = date(d);
	$mes = date(m);
	$ano = date(Y);
?>
    <tr>
      <td width="30%"><b>Assunto da Mensagem:</b></td>
      <td width="70%"> <input type="text" name="assunto" size="40" class=campo value="Cotas Fundos PAM <?php print("$dia/$mes/$ano"); ?>"></td>
    </tr>
    <tr>
      <td align="left" colspan=2><b>Texto da Mensagem ou Código HTML:</b></td>
      </tr><tr>
      <td colspan=2> <textarea rows="15" name="texto" cols="70" class=campo>	<table width=600 height=250 border=0 cellpadding=0 cellspacing=1 bgcolor=5F656A>
  <tr> 
    <td height=79 valign=top><a href=http://www.paranafundos.com.br/index.php target=_blank><img src=http://paranafundos.com.br/images/topo_email.jpg width=600 border=0></a></td>
  </tr>
  <tr>
    <td valign=top bgcolor=#C6CACE><table width=100% height=100% border=0 cellpadding=15 cellspacing=0>
        <tr> 
          <td><table width=100% height=100% border=0 cellpadding=0 cellspacing=1 bgcolor=5F656A>
              <tr> 
                <td bgcolor=#F8F9FA><table width=100% border=0 cellspacing=10 cellpadding=0>
                    <tr> 
                      <td align=center> <p><font size=1 face=Verdana><strong><a href=http://www.paranafundos.com.br/cotas.php target=_blank><font size=1 face=Verdana color=#000000>Clique 
                          aqui e veja as cotas atualizadas dos Fundos PAM</a></strong></font></p>
                        </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width=600 height=45 border=0 cellpadding=0 cellspacing=0>
  <tr>
    <td align=center valign=middle><font size=1 face=Verdana><strong>PAM 
      Paran&aacute; Banco Asset Management</strong><br>
      Rua Visconde de Nacar, 1441 - Curitiba - Parana - Brasil<br>
      Tel.: (41) 3351-9966 - E-mail: <a href=mailto:pam@paranafundos.com.br><font size=1 face=Verdana color=#000000>pam@paranafundos.com.br</a></font></td>
  </tr>
</table></textarea></td>
    </tr>
<script language="javascript1.2">
		var config = new Object();    // create new config object
		
		config.width = "480px";
		config.height = "300px";
		config.bodyStyle = 'background-color: white; font-family: "Verdana"; font-size: 7.8pt;';
		config.debug = 0;
		
		// NOTE:  You can remove any of these blocks and use the default config!
		
		
		config.toolbar = [
		
			['fontname'],
			['fontsize'],
			['bold','italic','underline'],
			['separator','justifyleft','justifycenter','justifyright','justifyfull'],
			['linebreak'],
			['strikethrough','subscript','superscript','separator'],
			['OrderedList','UnOrderedList','Outdent','Indent','separator'],
			['forecolor','backcolor','separator'],
			['HorizontalRule','Createlink','InsertImage','InsertTable','separator','htmlmode','about']
		];
		
		config.fontnames = {
			"Verdana":         "Verdana"
		};
		config.fontsizes = {
			"1 (8 pt)":  "1",
			"2 (10 pt)": "2",
			"3 (12 pt)": "3",
			"4 (14 pt)": "4",
			"5 (18 pt)": "5",
			"6 (24 pt)": "6",
			"7 (36 pt)": "7"
		  };
		
		editor_generate('texto',config);
		</script>
		</script>
    <tr>
      <td width="20%"><b>Código HTML:</b></td>
      <td width="80%"><select name=html class=campo>
      <option value="Sim">Sim</option>
      <option value="Nao">Nao</option>
       </select></td>
    </tr>
    <tr>
      <td width="30%" valign="top">
      <input type="submit" value="Enviar Mailing" name="B1" class=campo></td>
      <td width="70%" class="style7">ATENÇÃO! Após clicar para enviar o mailing será necessário esperar o processo terminar para que todos os clientes recebam o e-mail.</td>
    </tr>
  </table>
  </form>
<?php
	}//fim do if enviado
?>
<?php
mysql_close($con);
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
<?php
//include("carimbo.php");
?>
</td></tr></table>
</body>
</html>