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
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function placeFocus() {
if (document.forms.length > 0) {
var field = document.forms[0];
for (i = 0; i < field.length; i++) {
if ((field.elements[i].type == "text") || (field.elements[i].type == "textarea") || (field.elements[i].type.toString().charAt(0) == "s")) {
document.forms[0].elements[i].focus();
break;
         }
      }
   }
}
//  End -->

</script>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0 OnLoad="placeFocus()">
<?php
	//$senha = md5("teste");
	//$senha = base64_encode("teste");
//echo $senha;
?>
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
 <div align="center">
  <center>
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td align=center colspan=2><br><br>
<font size="4" face="Verdana" color="#<?php print("$cor2"); ?>"><b>Painel de Controle</b></font></td>
		</tr>
<?php
	if($msg != ""){
?>
		<tr><td colspan=2 height=30 bgcolor="#<?php print("$cor1"); ?>" align=center class=style7><?php print("$msg"); ?></td></tr>
<?php
	}
?>
<?php
	if((session_is_registered("usu_email")) and (session_is_registered("usu_tipo"))){
	//if($valid_user <> ""){
?>
<tr><td align=center colspan=2>
<b>Bem vindo ao Painel de Controle para o Site da Rede Brasileira de Imóveis!</b><br><br></td>
</tr>
<?php/*<tr>
	     <td valign="Top" align="center"><table border="0" cellspacing="1" width="400" bgcolor="#<?php print("$cor3"); ?>">
  		<tr bgcolor="#<?php print("$cor3"); ?>">
  			<td align="center"><b>Últimos Cadastros</b></td>
  		</tr>
  		<tr bgcolor="#<?php print("$cor1"); ?>">
  			<td class=style2>
<?php
	$query4 = "select i_cod, i_ref, i_tipo from rebri_imoveis order by i_cod desc limit 5";
	$result4 = mysql_query($query4);
	//echo $query4;
	while($not4 = mysql_fetch_array($result4))
	{
	$tipo = $not4[i_tipo];
	$ref = $not4[i_ref];
	$foto = $not4[i_ref] . "_1_peq.jpg";
	$cod = $not4[i_cod];
?>
<?php
	if (file_exists("/home/httpd/htdocs/brucinbr/bolao/img_dest/$foto"))
	{
?>
  			<table border="0" cellspacing="2" width="100%">
  				<tr>
  					<td><a href="p_imoveis.php?i_cod=<?php print("$cod"); ?>&edit=editar&lista=1" style=linkm><img src="/bolao/img_dest/<?php print("$foto"); ?>" width="80" align="middle"> <b><?php print("$tipo"); ?> - <?php print("$ref"); ?></b></a></td>
  				</tr>
  			</table>
<?php
}else{
?>
        <table border="0" cellspacing="2" width="100%">
  				<tr>
  					<td align="center"><a href="p_imoveis.php?i_cod=<?php print("$cod"); ?>&edit=editar&lista=1" style=linkm><b><?php print("$tipo"); ?> - <?php print("$ref"); ?></b></a></td>
  				</tr>
  			</table>
<?php	
}
}
?>
			<br><a href="p_imoveis.php" class=linkm><b>Clique aqui</b></a> para visualizar a relação de imóveis.
  	</td>
  </tr>
</table></td>
</tr>
*/?>
<?php
	}
	else
	{
?>
<tr><td>
<script language="javascript">
function valida()
{
if (form1.email.value == "")
  {
    alert("Por favor, digite o e-mail");
    form1.email.focus();
    return (false);
  }

  if (form1.email.value != '') {
    var emailok = 0;
    var checkStr = form1.email.value;
    var priaroba = checkStr.indexOf('@');
    var ultponto = checkStr.lastIndexOf('.');

    if (checkStr.indexOf('@') > 0 ) {
       if (checkStr.lastIndexOf('@') == checkStr.indexOf('@')) {
          if (checkStr.lastIndexOf('.') > 0 ) {

             if ( checkStr.lastIndexOf('.')  !=  checkStr.length - 1) {
	 					if ( ultponto > priaroba ) {
                  	 var emailok = 1;
 	 					}
             }
          }
       }
    }

    if (emailok != 1) {
    		alert('E-mail Inválido.');
		   form1.email.focus();
         return (false);
    }
  }
  if (form1.senha.value == "")
  {
    alert("Por favor, digite a Senha");
    form1.senha.focus();
    return (false);
  }
	return(true);
}
<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode; 
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}
//  End -->
</script>
<p><br><br>
  <div align="center">
    <center>
  <table border="0" cellspacing="1" width="400" bgcolor="#<?php print("$cor1"); ?>">
  <tr><td colspan=2 bgcolor="#<?php print("$cor1"); ?>" align=center class=style2>Digite seu e-mail e sua senha para acessar o<br>Painel de Controle.</td></tr>
  <form method="post" action="login.php" name="form1" onsubmit="return valida();">
    <tr>
      <td width="100" bgcolor="#<?php print("$cor6"); ?>" class=style2><b>E-mail:</b></td>
      <td width="300" bgcolor="#<?php print("$cor6"); ?>" class=style2><input type="text" name="email" size="50" class="campo"></td>
    </tr>
    <tr>
      <td width="100" bgcolor="#<?php print("$cor6"); ?>" class=style2><b>Senha:</b></td>
      <td width="300" bgcolor="#<?php print("$cor6"); ?>" class=style2><input type="password" name="senha" size="6" class="campo" maxlenght="6" onKeyUp="return autoTab(this, 6, event);">(6 dígitos)</td>
    </tr>
    <tr>
      <td width="100" bgcolor="#<?php print("$cor1"); ?>" align="center">
    <input type="submit" value="Entrar" name="bot" class=campo></td>
          <td width="300" bgcolor="#<?php print("$cor1"); ?>"></td>
    </tr>
  </table>
  </form>
  </center>
</div>
<?php
	}
?>
      </td>
    </tr>
  </table>
</td></tr></table>
</body>
</html>