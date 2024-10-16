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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script language="javascript">
function valida()
{
	if (document.formulario.b_nome.value == "")
  	{
    	alert("Por favor, digite o Nome");
    	document.formulario.b_nome.focus();
    	return false;
  	}
  	
  	if (document.formulario.b_link.value == "")
  	{
    	alert("Por favor, digite o Link");
    	document.formulario.b_link.focus();
    	return false;
  	}
  	
  	if (document.formulario.b_img.value == "")
  	{
    	alert("Por favor, seleciona a Imagem");
    	document.formulario.b_img.focus();
    	return false;
  	}
  	
	return true;
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
<table>
	<tr>
		<td>
 <p align="center"><b>Inserir Banners</b><br>
 <a href="p_banners.php" class=linkm>
 Clique para visualizar a relação de Banners</a></p>
 <div align="center">
  <center>
  <form method="post" action="p_banners.php" name="formulario" onsubmit="return valida();">
  <table border="0" cellspacing="2" width="100%">
    <tr>
      <td width="20%" class=style2>*Nome:</td>
      <td width="80%" class=style2> <input type="text" name="b_nome" size="40" class="campo" value="<?php print("$b_nome"); ?>"> <?php print("$falt_nome"); ?></td>
    </tr>
    <tr>
      <td width="20%" class=style2>*Link:</td>
      <td width="80%" class=style2><input type="text" name="b_link" size="40" value="<?php print("$b_link"); ?>" class="campo"> <?php print("$falt_link"); ?></td>
    </tr>
    <tr>
      <td width="20%" class=style2 valign="top">*Imagem:</td>
      <td width="80%" class=style2> <input type="text" name="b_img" size="20" class="campo" readonly>
      	<input type="button" value="Selecionar" class="campo" onclick="window.open('p_img_banner.php', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.</td>
    </tr>
    <tr>
      <td colspan="2" width="20%" class=style2><i>Largura e Altura é obrigatório preencher quando a imagem for um arquivo Flash(.swf)</i></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Largura:</td>
      <td width="80%" class=style2> <input type="text" name="b_width" size="3" value="<?php print("$b_width"); ?>" class="campo"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Altura:</td>
      <td width="80%" class=style2> <input type="text" name="b_height" size="3" value="<?php print("$b_height"); ?>" class="campo"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Setor:</td>
      <td width="80%" class=style2> <select size="1" name="b_setor" class="campo">
    <option selected>Direita</option>
    <option>Parceiros</option>
        </select></td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">
      <input class=campo type="submit" value="Cadastrar Banner" name="B1"></td>
    </tr>
      </form>
     </table></td>
      <td width="30%" valign="top"><table border="0" cellspacing="1" width="100%" bgcolor="#<?php print("$cor3"); ?>">
  		<tr bgcolor="#<?php print("$cor3"); ?>">
  			<td align="center"><b>Últimos Cadastros</b></td>
  		</tr>
  		<tr bgcolor="#<?php print("$cor1"); ?>"><td class=style2>
<?php
	$query4 = "select b_nome, b_cod from rebri_banners order by b_cod desc limit 5";
	$result4 = mysql_query($query4);
	//echo $query4;
	while($not4 = mysql_fetch_array($result4))
	{
	//$categoria = $not4[b_categoria];
	$b_nome = $not4[b_nome];
	$b_cod = $not4[b_cod];
?> 
           <br><a href="p_banners.php?b_cod=<?php print("$b_cod"); ?>&edit=editar&lista=1" class="style2" align="center"><b><?php print("$b_nome"); ?></b></a>
<?php
	}
?>
  			<br><br><a href="p_banners.php" class=linkm><b>Clique aqui</b></a> para visualizar a relação de banners.</td>
  </tr>
  	</table>
  </td> 
</tr>
  	</table>
<?php
include("carimbo.php");
mysql_close($con);
?>
  </td></tr></table>
</body>
</html>