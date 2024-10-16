<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");

include("l_funcoes.php");
verificaAcesso();
verificaArea("USER_GERAL");
?>
<html>
<head>
<?
include("style.php");
?>
</head>
<?php
//	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and ($u_tipo == "admin")){
?>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
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
<script language="javascript">
function valida()
{
  if (form1.u_nome1.value == "")
  {
    alert("Por favor, digite o Nome do usuário");
    form1.u_nome1.focus();
    return (false);
  }
if (form1.u_email1.value == "")
  {
    alert("Por favor, digite o e-mail");
    form1.u_email1.focus();
    return (false);
  }

  if (form1.u_email1.value != '') {
    var emailok = 0;
    var checkStr = form1.u_email1.value;
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
		   form1.u_email1.focus();
         return (false);
    }
  }
  if (form1.u_senha1.value == "")
  {
    alert("Por favor, digite a Senha do usuário");
    form1.u_senha1.focus();
    return (false);
  }
  /*if (form1.u_tipo1.value == "")
  {
    alert("Por favor, selecione o Tipo do usuário");
    form1.u_tipo1.focus();
    return (false);
  }
  */
  if (form1.u_status1.value == "")
  {
    alert("Por favor, selecione o Status");
    form1.u_status1.focus();
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
<div align="center">
  <center>
  <form method="post" action="p_usuarios.php" name="form1" onSubmit="return valida();" enctype="multipart/form-data">
	<table width="75%" align="center" border="0" cellpadding="1" cellspacing="1">
   	  <tr height="50">
  	  	<td colspan="2"><p align="center" class="style1"><b>Inserir Usuário</b><br><a href="p_usuarios.php" class="style1">Clique para visualizar a relação de Usuários</a></p></td>
  	  </tr>
      <tr class="fundoTabela">
        <td width="20%" class="style1"><b>Nome do usuário:</b></td>
        <td width="80%" class="style1"><input type="text" class="campo" name="u_nome1" size="40"></td>
      </tr>
      <tr class="fundoTabela">
        <td width="20%" class="style1"><b>E-mail do usuário:</b></td>
        <td width="80%" class="style1"><input type="text" class="campo" name="u_email1" size="40"></td>
      </tr>
      <tr class="fundoTabela">
        <td width="20%" class="style1"><b>Senha do usuário:</b></td>
        <td width="80%" class="style1"><input type="password" class="campo" name="u_senha1" size="6" maxlength="6" onKeyUp="return autoTab(this, 6, event);">
          OBS.: 6 dígitos</td>
      </tr>
      <!--tr  class="fundoTabela">
        <td width="20%" class="style1"><b>Tipo de usuário:</b></td>
        <td width="80%" class="style1"><select name="u_tipo1" class="campo">
          <option value="">Selecione uma opção</option>
          <option value="admin">Administrador Geral</option>
          <option value="func">Corretor</option>
          <option value="cliente">Cliente</option>
          </select></td>
      </tr-->
	   <tr class="fundoTabela">
        <td width="20%" class="style1"><b>Status:</b></td>
        <td width="80%" class="style1"><select name="u_status1" class="campo">
          <option value="">Selecione</option>
          <option value="Ativo">Ativo</option>
          <option value="Inativo">Inativo</option>
          </select></td>
      </tr>
      <!--tr class="fundoTabela">
        <td class="style1"><b>Foto 3x4:</b></td>
        <td class="style1"><input type="file" name="foto" id="foto" onChange="preview(this)"></td>
      </tr-->
       <? if (verificaFuncao("USER_AREA")) { // verifica se pode acessar as areas ?>
<script language="javascript">
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
        <td class="style1" colspan="2">
			<table width="100%" border="0" cellpadding="1" cellspacing="1">
				<tr class="fundoTabela">
				  <td class="style1" align="center" colspan="2"><br><strong>Áreas com acesso permitido:</strong></td>
				</tr>
					<tr class="fundoTabela">
				  <td class="style1" align="center" colspan="2">&nbsp;</td>
			  </tr>
				<tr class="fundoTabela">
				  <td class="style1" align="center" colspan="2">
				    <input type="checkbox" name="selall" onClick="CheckAll()"><span id="checar">Marcar todos</span></td>
			  </tr>
				<tr class="fundoTabela">
				  <td class="style1" align="center" colspan="2">&nbsp;</td>
			  </tr>
				<tr class="fundoTabela">
				<?
					$busca2 = mysql_query("SELECT area_id, area_nome, area_parametro, area_descricao FROM area ORDER BY area_nome ASC");
					if(mysql_num_rows($busca2) > 0){
						$cont = 0;
						while($linha2 = mysql_fetch_array($busca2)){
								$temp_check = "";
							if($linha2['area_parametro'] == "GERAL_ESTATISTICAS" || $linha2['area_parametro'] == "GERAL_BANNER"){
								if($_SESSION['im_site_padrao'] == "S"){
?>
								<td width="50%" class="style1"><input type="checkbox" name="areas[]" value="<?=$linha2['area_id']?>" <?=$temp_check?>><span title="<?=$linha2['area_descricao']?>"><?=$linha2['area_nome']?></span></td>
<?
								}
                            }elseif($linha2['area_parametro'] == "GERAL_MAILLING"){
                               if($_SERVER['SERVER_NAME'] <> "www.redebrasileiradeimoveis.com.br" AND $_SERVER['SERVER_NAME'] <> "redebrasileiradeimoveis.com.br"){
?>
                                <td width="50%" class="style1"><input type="checkbox" name="areas[]" value="<?=$linha2['area_id']?>" <?=$temp_check?>><span title="<?=$linha2['area_descricao']?>"><?=$linha2['area_nome']?></span></td>
<?

                               }
							 }else{

				?>
						  <td width="50%" class="style1"><input type="checkbox" name="areas[]" value="<?=$linha2['area_id']?>" <?=$temp_check?>><span title="<?=$linha2['area_descricao']?>"><?=$linha2['area_nome']?></span></td>
				<?
							}
						$cont ++;
						if ($cont == 2) {
							$cont = 0;
							echo "</tr><tr class=\"fundoTabela\">";
						}
						}
					}
				?>
				</tr>
			</table>
		</td>
      </tr>
      <? } ?>
      <tr>
        <td colspan="2" width="100%">
           <input type="submit" value="Inserir Usuário" name="B1" class="campo3">
        </td>
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
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("voltar.php"); ?>
    </td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td align="center" class="style1">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
</body>
</html>