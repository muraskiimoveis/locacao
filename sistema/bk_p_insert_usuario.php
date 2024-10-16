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
include("conect.php");
?>
</head>
<?php
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	($u_tipo == "admin")){
?>
<body>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<script>
function valida()
{
  if (form1.u_nome1.value == "")
  {
    alert("Por favor, digite o Nome do usuário");
    form1.u_nome1.focus();
    return (false);
  }
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
  if (form1.u_tipo.value == "")
  {
    alert("Por favor, selecione o Tipo do usuário");
    form1.u_tipo.focus();
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

//Funcao para validar o formato da foto

  // width to resize large images to
var maxWidth=100;
  // height to resize large images to
var maxHeight=100;
  // valid file types
var fileTypes=["jpg","jpeg"];
  // the id of the preview image tag
var outImage="previewField";
  // what to display when the image is not valid
var defaultPic="spacer.gif";

/***** DO NOT EDIT BELOW *****/

function preview(what){
  var source=what.value;
  var ext=source.substring(source.lastIndexOf(".")+1,source.length).toLowerCase();
  for (var i=0; i<fileTypes.length; i++) if (fileTypes[i]==ext) break;
  globalPic=new Image();
  if (i<fileTypes.length) globalPic.src=source;
  else {
    globalPic.src=defaultPic;
    alert("Apenas arquivos JPG são aceitos\nPor favor selecione uma nova imagem com uma das extensões abaixo:\n\n"+fileTypes.join(", "));
  }
  setTimeout("applyChanges()",200);
}
var globalPic;
function applyChanges(){
  var field=document.getElementById(outImage);
  var x=parseInt(globalPic.width);
  var y=parseInt(globalPic.height);
  if (x>maxWidth) {
    y*=maxWidth/x;
    x=maxWidth;
  }
  if (y>maxHeight) {
    x*=maxHeight/y;
    y=maxHeight;
  }
  field.style.display=(x<1 || y<1)?"none":"";
  field.src=globalPic.src;
  field.width=x;
  field.height=y;
}

//  End -->
</script>
 <p align="center" class="style1"><b>Inserir Usuário p/ Intranet</b><br>
 <a href="p_usuarios.php" class="style1">
 Clique para visualizar a relação de Usuários</a></p>
 <div align="center">
  <center>
  <form method="post" action="p_usuarios.php" name="form1" onSubmit="return valida();">
  <table width="100%" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td width="15%" class="style1"><b>Nome do usuário:</b></td>
      <td width="85%" class="style1"><input type="text" class="campo" name="u_nome1" size="40"></td>
    </tr>
    <tr>
      <td width="15%" class="style1"><b>E-mail do usuário:</b></td>
      <td width="85%" class="style1"><input type="text" class="campo" name="u_email" size="40"></td>
    </tr>
    <tr>
      <td width="15%" class="style1"><b>Senha do usuário:</b></td>
      <td width="85%" class="style1"><input type="text" class="campo" name="u_senha" size="6" maxlength="6" onKeyUp="return autoTab(this, 6, event);"> 
        OBS.: 6 dígitos</td>
    </tr>
    <tr>
      <td width="15%" class="style1"><b>Tipo de usuário:</b></td>
      <td width="85%" class="style1"><select name="u_tipo" class="campo">
      <option value="">Selecione uma opção
      <option value="admin">Administrador Geral
      <option value="func">Funcionário
      <option value="cliente">Cliente</select></td>
    </tr>
    <tr>
      <td class="style1"><b>Foto 3x4:</b></td>
      <td class="style1"><input type="file" name="foto" id="foto" onChange="preview(this)"></td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td>
      <td width="85%"><input type="submit" value="Inserir Usuário" name="B1" class="campo"></td>
    </tr>
  </table>
  </form>
<?php
	}
	else
	{
?>
<?php
include("login2.php");
?>
<?php
	}
?>
</body>
</html>