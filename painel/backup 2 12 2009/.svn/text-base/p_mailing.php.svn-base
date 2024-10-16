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
<?php
if($enviado == "")
	{
?>
<script type="text/javascript" src="/painel/FCKeditor/fckeditor.js"></script>
<script type="text/javascript">
      window.onload = function()
      {
        var oFCKeditor = new FCKeditor( 'texto' ) ;
        oFCKeditor.Height = "400"
        oFCKeditor.BasePath = "/painel/FCKeditor/" ;
        oFCKeditor.ReplaceTextarea() ;
      }
    </script>
<?php
	}
?>
</head>
<?php
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
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
?>
 <p align="center"><b>Mailing enviado para Lista Rebri</b><br><br>
 <?php print("$nome_para"); ?> - <?php print("$email_para"); ?>
<table>
<?php
	//$query1 = "select nome_u, email_u from clientes order by nome_u";
	//$result1 = mysql_query($query1);
	//while($not = mysql_fetch_array($result1))
	//{
	
	$assunto = stripslashes($assunto);
	$texto = stripslashes($texto);
	if($html == "Nao"){
	$texto = str_replace("\n","<br>","$texto");
	}
	
	$address = "$nome_para <$email_para>";
	//$address = "Lista Pares <adm-informativo@lista.pares.com.br>";
	//$address = "Paulo <paulo@bruc.com.br>";
	$de = "From: $nome_de <$email_de>\n" . "Return-path: $email_de\n" . "Mime-Version: 1.0\nContent-Type: text/html; charset=\"iso-8859-1\"\n";
	//$de = "From: pares@pares.com.br";
	$subject = "$assunto";
	$body = "<html><body topmargin=0 leftmargin=0 rightmargin=0><table width=600 align=center border=0 cellpadding=0 cellspacing=1 bgcolor=#034694>
  <tr> 
    <td valign=top bgcolor=#FFFFFF><table width=600 border=0 cellpadding=0 cellspacing=0>
  <tr>
    <td height=108 valign=top><a href=http://www.aquabetta.com.br><img border=0 src=http://aquabetta.com.br/images/topo_email2.jpg width=600 height=129></a></td>
  </tr>
  <tr height=1>
  	<td></td>
  </tr>
  <tr>
  	<td align=center><font color=#000000 size=2 face=Verdana>$texto</td>
  </tr>
  <tr height=10>
  	<td></td>
  </tr>
  <tr>
    <td align=center valign=top><font color=#000000 size=1 face=Verdana>Rua Doutor Faivre, 723 - 80060-140 - Centro - Curitiba 
      - PR - <a href=http://www.aquabetta.com.br/index.php?pag=textos&n_cod=16><font color=#000000 size=1 face=Verdana>Ver mapa</a><br>
      Fone: (41) 3264-9536 - Fax: (41) 3018-8408 &#8211; E-mail: <a href=mailto:info@aquabetta.com.br><font color=#000000 size=1 face=Verdana>info@aquabetta.com.br</a></td>
  </tr>
  <tr>
    <td align=center><font color=#C5C5C5 size=1 face=Verdana>Caso queira se retirar desta lista envie um e-mail para <a href=mailto:info@aquabetta.com.br><font color=#C5C5C5 size=1 face=Verdana>info@aquabetta.com.br</a> com a palavra REMOVER na linha Assunto.</td>
  </tr>
  </table></td></tr></table></body></html>";
	
	mail("$address", "$subject", "$body", "$de");
?>
<tr><td><font color="#000000" size="2" face="Arial">
<?php //print("$not[nome_u]"); ?></td><td><font color="#000000" size="2" face="Arial">
<?php //print("$not[email_u]"); ?></td></tr>
<?php
	//}
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
  if (form1.texto.value == "")
  {
    alert("Por favor, digite o Texto da Mensagem");
    form1.texto.focus();
    return (false);
  }
	return(true);
}
</script>
 <p align="center"><b>Enviar Mailing</b><br>
 <a href="p_imobiliarias.php" class=linkm>
 Clique para visualizar a relação de Clientes cadastrados</a></p>
 <div align="center">
  <center>
  <form method="post" name="form1" onsubmit="return valida();" action="<?php print("$PHP_SELF"); ?>">
  <input type=hidden name=enviado value=1>
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="30%"><b>Nome do remetente:</b></td>
      <td width="70%"> <input type="text" name="nome_de" size="40" value="Rebri - Rede Brasileira de Imóveis" class=campo></td>
    </tr>
    <tr>
      <td width="30%"><b>E-mail do remetente:</b></td>
      <td width="70%"> <input type="text" name="email_de" size="40" value="marketing@rebri.com.br" class=campo></td>
    </tr>
    <tr>
      <td width="30%"><b>Nome do destinatário:</b></td>
      <td width="70%"> <input type="text" name="nome_para" size="40" value="Clientes Rebri" class=campo></td>
    </tr>
    <tr>
      <td width="30%"><b>E-mail do destinatário:</b></td>
      <td width="70%"> <input type="text" name="email_para" size="40" value="adm-informativo@lista.rebri.com.br" class=campo></td>
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
		$txt = "<table border=0 cellpadding=2 cellspacing=2>
		<tr>
		<td colspan=4 align=center><a href=http://www.aquabetta.com.br/index.php?pag=list_prod&pesq=1&chave=ecco><img src=http://aquabetta.com.br/images/banner_jul_2007.jpg border=0></a></td>
		</tr>		
        <tr>
        	<td width=35 valign=top>
<img border=0 src=http://aquabetta.com.br/images/icone_novidades.gif>
        	</td>
        	<td width=260 valign=top><font color=#000000 size=2 face=Verdana, Arial, Helvetica, sans-serif>
<b>
<a href=http://aquabetta.com.br/index.php?pag=noticia&n_cod=27&n_tipo=Informativos>
<font color=#000000>Novidades</font></a><br>
</b><font size=2>Confira as últimas novidades que chegaram em nossa loja.</font></td>
        	<td width=35 valign=top>
<img border=0 src=http://aquabetta.com.br/images/icone_promocoes.gif>
        	</td>
        	<td width=260 valign=top><font color=#000000 size=2 face=Verdana, Arial, Helvetica, sans-serif>
<b>
<a href=http://aquabetta.com.br/index.php?pag=noticia&n_cod=28&n_tipo=Informativos>
<font color=#000000>Promoções</font></a><br>
</b><font size=2>Muitas ofertas e promoções para você.</font></td>
        </tr>
        <tr>
        	<td width=35 valign=top>
<img border=0 src=http://aquabetta.com.br/images/icone_classificados.gif>
        	</td>
        	<td width=260 valign=top><font color=#000000 size=2 face=Verdana, Arial, Helvetica, sans-serif>
<b>
<a href=http://aquabetta.com.br/index.php?pag=noticia&n_cod=26&n_tipo=Informativos>
<font color=#000000>Classificados</font></a><br>
</b><font size=2>Confira os classificados de produtos usados comercializados 
por nossos clientes.</font></td>
        	<td width=35 valign=top>
<img border=0 src=http://aquabetta.com.br/images/icone_peixesornamentais.gif>
        	</td>
        	<td width=260 valign=top><font color=#000000 size=2 face=Verdana, Arial, Helvetica, sans-serif>
<b>
<a href=http://aquabetta.com.br/index.php?pag=noticia&n_cod=25&n_tipo=Informativos>
<font color=#000000>Peixes Ornamentais</font></a><br>
</b><font size=2>Confira nossa última remessa de peixes de água doce e salgada.</font></td>
        </tr>
        <tr>
        	<td width=35 valign=top>
<img border=0 src=http://aquabetta.com.br/images/icone_plantas.gif>
        	</td>
        	<td width=260 valign=top><font color=#000000 size=2 face=Verdana, Arial, Helvetica, sans-serif>
<b>
<a href=http://aquabetta.com.br/index.php?pag=noticia&n_cod=31&n_tipo=Informativos>
<font color=#000000>Plantas Naturais</font></a><br>
</b><font size=2>Confira nossa última remessa de plantas hidrófilas.</font></td>
        	<td width=35 valign=top>
<img border=0 src=http://aquabetta.com.br/images/icone_carrinho2.gif>
        	</td>
        	<td width=260 valign=top><font color=#000000 size=2 face=Verdana, Arial, Helvetica, sans-serif>
<b>
<a href=http://aquabetta.com.br/index.php?pag=produtos>
<font color=#000000>Vendas On line</font></a><br>
</b><font size=2>Faça compras diretamente pelo nosso Site.</font></td>
        </tr>
		<tr>
        	<td colspan=4 valign=top align=center>
        	<img border=0 src=http://aquabetta.com.br/images/icone_motoboy.gif><br>
        	<font color=#000000 size=2 face=Verdana, Arial, Helvetica, sans-serif>
<b>
<a href=http://www.aquabetta.com.br/index.php?pag=textos&n_cod=42>
<font color=#000000>Serviço de Entrega</font></a><br>
</b><font size=2>Oferecemos serviço de entrega por MotoBoy para Curitiba e Região Metropolitana, de segunda à sexta das 9h às 17h. Entre em contato conosco ou pelo telefone (41) 3264-9536 para fazermos uma cotação. 
.</font></td>
        </tr>
      </table>";
	}
?>
    <tr>
      <td width="30%"><b>Assunto da Mensagem:</b></td>
      <td width="70%"> <input type="text" name="assunto" size="40" class=campo value="<?php print("$assunto"); ?>"></td>
    </tr>
    <tr>
      <td align="left" colspan=2><b>Texto da Mensagem ou Código HTML:</b></td>
      </tr><tr>
      <td colspan=2> <textarea rows="15" name="texto" cols="70" class=campo><?php print("$txt"); ?></textarea></td>
    </tr>
    <tr>
      <td width="20%"><b>Código HTML:</b></td>
      <td width="80%"><select name=html class=campo>
      <option value="Sim">Sim</option>
       </select></td>
    </tr>
    <tr>
      <td width="30%">
      <input type="submit" value="Enviar Mailing" name="B1" class=campo></td>
      <td width="70%"></td>
    </tr>
  </table>
  </form>
<?php
	}//fim do if enviado
?>
<?php
	}
	else
	{
?>
<font size="2" face="Arial" color="#ff0000">
<b>Você precisa fazer seu login para acessar essa página.<br>
<a href="/painel">Clique aqui para entrar com seu login e senha.</a>
<?php
	}
?>
<?php
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>