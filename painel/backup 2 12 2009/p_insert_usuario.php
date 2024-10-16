<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("regra.php");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
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
<script language="javascript">
function valida()
{
if (form1.u_email.value == "")
  {
    alert("Por favor, digite o e-mail");
    form1.u_email.focus();
    return (false);
  }

  if (form1.u_email.value != '') {
    var emailok = 0;
    var checkStr = form1.u_email.value;
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
		   form1.u_email.focus();
         return (false);
    }
  }
  if (form1.u_senha.value == "")
  {
    alert("Por favor, digite a Senha do usuário");
    form1.u_senha.focus();
    return (false);
  }
  /*
  if (form1.u_tipo1.value == "")
  {
    alert("Por favor, selecione o Tipo do usuário");
    form1.u_tipo1.focus();
    return (false);
  }
  */
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
 <p align="center" class=style2><b>Inserir Usuário p/ Painel de Controle</b><br>
 <a href="p_usuarios.php"><font color="#0000ff" size="2" face="Arial">
 Clique para visualizar a relação de Usuários</a></p>
 <div align="center">
  <center>
  <form method="post" action="p_usuarios.php" name="form1" onsubmit="return valida();">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="20%" class=style2><b>Nome:</b></td>
      <td width="80%" class=style2> <input type="text" class="campo" name="u_nome" size="40"></td>
    </tr>
    <tr>
      <td width="20%" class=style2><b>E-mail:</b></td>
      <td width="80%" class=style2> <input type="text" class="campo" name="u_email" size="40"></td>
    </tr>
    <tr>
      <td width="20%" class=style2><b>Senha:</b></td>
      <td width="80%" class=style2> <input type="password" class="campo" name="u_senha" size="6" maxlength="6" onKeyUp="return autoTab(this, 6, event);">OBS.: 6 dígitos</td>
    </tr>
    <tr>
      <td width="20%" class=style2><b>Tipo:</b></td>
      <td width="80%" class=style2> <select name="u_tipo1" class="campo">
      <option value="">Selecione uma opção
      <option value="admin">Administrador Geral
      <option value="func">Funcionário
      </select></td>
    </tr>
    <tr>
      <td width="20%">
      <input type="submit" value="Inserir Usuário" name="B1" class=campo></td>
      <td width="80%"></td>
    </tr>
  </table>
  </form>
<?php
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>