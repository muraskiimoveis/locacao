<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

if($_GET['cod_imob'] != ""){
 $cod_imob = $_GET['cod_imob'];
}else{
 $cod_imob = $_POST['cod_imob'];
}

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
  if (document.form1.u_nome1.value == "")
  {
    alert("Por favor, digite o Nome do usuário");
    document.form1.u_nome1.focus();
    return (false);
  }
if (document.form1.u_email.value == "")
  {
    alert("Por favor, digite o e-mail");
    document.form1.u_email.focus();
    return (false);
  }

  if (document.form1.u_email.value != '') {
    var emailok = 0;
    var checkStr = document.form1.u_email.value;
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
		 document.form1.u_email.focus();
         return (false);
    }
  }
  if (document.form1.u_senha.value == "")
  {
    alert("Por favor, digite a Senha do usuário");
    document.form1.u_senha.focus();
    return (false);
  }
  /*
  if (form1.u_tipo.value == "")
  {
    alert("Por favor, selecione o Tipo do usuário");
    form1.u_tipo.focus();
    return (false);
  }
  */
  if (document.form1.u_status1.value == "")
  {
    alert("Por favor, selecione o Status");
    document.form1.u_status1.focus();
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
 <p align="center" class="style1"><b>Inserir Usu&aacute;rio</b><br>
   <a href="p_usuariosi.php?cod_imob=<?php print("$cod_imob"); ?>" class="style1"> Clique para visualizar a rela&ccedil;&atilde;o de Usu&aacute;rios</a></p>
 <div align="center">
 <center>
 <form method="post" action="p_usuariosi.php" name="form1" onSubmit="return valida();" enctype="multipart/form-data">
   <input type="hidden" name="cod_imob" value="<?php print("$cod_imob"); ?>">
   <table width="100%" border="0" cellpadding="1" cellspacing="1">
     <tr>
       <td width="25%" class="style1"><b>Nome do usu&aacute;rio:</b></td>
       <td width="75%" class="style1"><input type="text" class="campo" name="u_nome1" size="40"></td>
     </tr>
     <tr>
       <td width="25%" class="style1"><b>E-mail do usu&aacute;rio:</b></td>
       <td width="75%" class="style1"><input type="text" class="campo" name="u_email1" size="40"></td>
     </tr>
     <tr>
       <td width="25%" class="style1"><b>Senha do usu&aacute;rio:</b></td>
       <td width="75%" class="style1"><input type="password" class="campo" name="u_senha1" size="6" maxlength="6" onKeyUp="return autoTab(this, 6, event);">
         OBS.: 6 d&iacute;gitos</td>
     </tr>
     <!--tr>
       <td width="25%" class="style1"><b>Tipo de usu&aacute;rio:</b></td>
       <td width="75%" class="style1"><select name="u_tipo1" class="campo">
           <option value="">Selecione uma op&ccedil;&atilde;o
             <option value="admin">Administrador Geral
               <option value="func">Funcion&aacute;rio
                <option value="cliente">Cliente
            </select></td>
     </tr-->
	  <tr>
        <td width="25%" class="style1"><b>Status:</b></td>
        <td width="75%" class="style1"><select name="u_status1" class="campo">
          <option value="">Selecione</option>
          <option value="Ativo">Ativo</option>
          <option value="Inativo">Inativo</option>
          </select></td>
      </tr>
	  <!--tr>
       <td class="style1"><b>Foto 3x4:</b></td>
       <td class="style1"><input type="file" name="foto" id="foto" onChange="preview(this)"></td>
     </tr-->
     <script language=javascript>
<!--
cont = 0;
function CheckAll() { 
   for (var i=0;i<document.form1.elements.length;i++) {
     var x = document.form1.elements[i];
     if (x.name == 'areas[]') { 
x.checked = document.form1.selall.checked;
} 
}
if (cont == 0){	 
var elem = document.getElementById("checar");
elem.innerHTML = "Desmarcar todos";
cont = 1;
} else {
var elem = document.getElementById("checar");
elem.innerHTML = "Marcar todos";
cont = 0;
}

} 
//-->
 </script>
     <tr>
       <td class="style1" colspan="2"><table width="500" border="0" cellpadding="0" cellspacing="0">
           <tr>
             <td class="style1" align="center" colspan="2"><br>
                 <strong>&Aacute;reas com acesso permitido:</strong></td>
           </tr>
           <tr>
             <td class="style1" align="center" colspan="2">&nbsp;</td>
           </tr>
           <tr>
             <td class="style1" align="center" colspan="2"><input type="checkbox" name="selall" onClick="CheckAll()">
                 <span id="checar">Marcar todos</span></td>
           </tr>
           <tr>
             <td class="style1" align="center" colspan="2">&nbsp;</td>
           </tr>
           <tr>
             <?
					$busca2 = mysql_query("SELECT area_id, area_nome, area_parametro, area_descricao FROM area ORDER BY area_nome ASC");
					if(mysql_num_rows($busca2) > 0){
						$cont = 0;
						while($linha2 = mysql_fetch_array($busca2)){
								$temp_check = "";
				?>
             <td width="50%" class="style1"><input type="checkbox" name="areas[]" value="<?=$linha2['area_id']?>" <?=$temp_check?>><span title="<?=$linha2['area_descricao']?>">
                 <?=$linha2['area_nome']?></span></td>
             <?
						$cont ++;
						if ($cont == 2) {
							$cont = 0;
							echo "</tr><tr>";
						}
						}
					}
				?>
           </tr>
       </table></td>
     </tr>
     <tr>
       <td width="25%">&nbsp;</td>
       <td width="75%"><input type="submit" value="Inserir Usu&aacute;rio" name="B1" class="campo"></td>
     </tr>
   </table>
 </form>
 <?php
/*	}
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
<p align="center" class=style2>&nbsp;</p>
 </td></tr></table>
</body>
</html>