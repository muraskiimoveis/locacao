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
<script type="text/javascript">
<!-- Begin
/* This script and many more are available free online at
The JavaScript Source!! http://javascript.internet.com
Created by: Abraham Joffe :: http://www.abrahamjoffe.com.au/ */

/***** CUSTOMIZE THESE VARIABLES *****/

  // width to resize large images to
var maxWidth=100;
  // height to resize large images to
var maxHeight=100;
  // valid file types
var fileTypes=["bmp","gif","png","jpg","jpeg"];
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
    alert("THAT IS NOT A VALID IMAGE\nPlease load an image with an extention of one of the following:\n\n"+fileTypes.join(", "));
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
// End -->
</script>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<table width=100% height=100%>
<tr><td valign=top>
<br>
<?php
include("conect.php");
?>
<?php
if($B1 == "Apagar Imagem")
	{
	
	if ($foto != ""){
	
	//$foto_peq = str_replace(".jpg","_peq.jpg","$foto");
	
	if (file_exists($caminho_banner . $foto))
	{
	unlink($caminho_banner . $foto);
	
?>
<p align="center" class=style7>
Você apagou o arquivo: <i><?php print("$foto"); ?></i>.</p>
<?php
	}
	else
	{
?>
<p align="center" class=style7>
O arquivo <i><?php print("$foto"); ?></i> não existe.</p>
<?php
	}
	}
	else
	{
?>
<p align="center" class=style7>
Faltou preencher o nome do arquivo.</p>
<?php
	}
	}
?>
<div align="center">
  <center>
                  <table>
                  <tr><td colspan="2" bgcolor="<?php print("$cor10"); ?>" class=style2>
                  <p align="center">
                  Escolha imagem que deseja apagar.</td></tr>
<tr><td class=style2>
	<table width=500>
<?php
$strDiretorio = $caminho_banner; // pasta das imagens

$strDiretorioAbrir = opendir($strDiretorio);

//echo "<div align=\"center\"><font color=\"#990000\" face=\"tahoma\" size=\"2\"><strong>Listando Imagens JPG e GIF de um diretorio<br><br>Diretório Escolhido: </strong>".$strDiretorio."</font></div><br><br>";

	$i = 0;

while ($strArquivos = readdir($strDiretorioAbrir)) {

 if ($strArquivos != "." && $strArquivos != "..") {
 	
 	$arquivos[] = $strArquivos;
 	sort($arquivos);
 	
 	 $i++;
	}
	}
	
	if($i > 0){
foreach ($arquivos as $listar) {
	 	//$foto_peq = str_replace(".jpg","_peq.jpg","$listar");
	
	$extensao = explode(".", $listar);
?>
<tr>
<?php
	if(($extensao[1] == "jpg") or ($extensao[1] == "gif") or ($extensao[1] == "png"))
	{
?>
	<td align=center><img border=0 src="<?php print($caminho_banner.$listar); ?>"></td>
<?php
	}
	elseif($extensao[1] == "swf")
	{
?>
	<td align=center>Arquivo flash</td>
<?php
	}
?>
	<td><?php print("$listar"); ?></td>
	<td><a href="#" onclick="window.opener.document.formulario.b_img.value='<?php print("$listar"); ?>'; window.opener.focus(); window.close();">Selecionar</a> - <a href="#" onclick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$listar"); ?>\'?')) { window.location='<? print("$PHP_SELF"); ?>?B1=Apagar Imagem&foto=<?php print("$listar"); ?>'; }">Apagar</a></td>
</tr>
<?php
  //$arrDados = explode(".", $strArquivos); // separa os arquivos

  //if ($arrDados[1] == "gif" || $arrDados[1] == "jpg") {
   //echo "<strong>Nome da Imagem:</strong> " . $strArquivos . "<br>"; // Escrevendo o nome do arquivo
   //echo "<br><img src=\"".$strDiretorio."/".$strArquivos."\"><br><br>"; // Mostra a imagem
  //}
  
  //echo $i;
  
}
}
?>
</table>
</td></tr>
<tr>
<td colspan=2>
<br>
<p align="center"><b>Enviar Imagens</b>
<br><br>
<p align=left>
- As imagens dos produtos devem ser salvas sem repetir o nome dos arquivos.<br>
- O tamanho do arquivo deve ter, no máximo, 300 pixels no lado maior.<br>
- O tamanho em Kb da imagem não deve exceder 20Kb.<br><br>

<font color="#ff0000">Obs.: Favor prestar atenção nos nomes e tamanhos dos arquivos. Caso contrário o funcionamento do site poderá ser afetado.</font><br><br>
<?php 
/* how many upload slots? */ 
define("UPLOAD_SLOTS", 10); 

/* where to move the uploaded file(s) to? */ 
define("INCOMING", "$caminho_banner"); 

if($REQUEST_METHOD!="POST") 
{
?>
Última imagem selecionada:<br>
<img alt="Graphic will preview here" id="previewField" src="spacer.gif">
<?php
    /* generate form */ 
    echo "<form enctype=\"multipart/form-data\" method=post action=p_img_banner2.php>\n";
    echo "<input type=hidden name=referencia value=banner.php>";
    for($i=1; $i<=UPLOAD_SLOTS; $i++) 
    { 
        echo "<input type=file name=infile$i class=campo id=picField onchange=preview(this) size=50><br>\n"; 
    } 
    echo "<input type=submit value=Enviar class=campo></form><br>\n"; 
} 
?> 
</td>
</tr>
	</table>
	</center>
	</div>
<?php
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>