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

$caminho_fundo = "../imobiliarias/".$pasta."/institucional/fundo/";
$caminho_topo = "../imobiliarias/".$pasta."/institucional/logo/";

?>
<?php
//include("funcoes.php");

//Tamanho máximo da imagem media
/*
$largm_max = 239;
$altm_max = 98;
*/

//Tamanho máximo da imagem pequena
/*
$largp_max = 90;
$altp_max = 145;
*/
?>
<script language="javascript">
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
var fileTypes=["jpg","jpeg","png"];
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
    alert("Apenas arquivos JPG e PNG são aceitos\nPor favor selecione uma nova imagem com uma das extensões abaixo:\n\n"+fileTypes.join(", "));
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
	
		if($statusa=='g'){
	
			if (file_exists($caminho_logo . $foto))
			{
					unlink($caminho_logo . $foto);
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

		}elseif($statusa=='f'){

		  	if (file_exists($caminho_fundo . $foto)) {
			  		unlink($caminho_fundo . $foto);
?>
<p align="center" class=style7>
Você apagou o arquivo: <i><?php print("$foto"); ?></i>.</p>
<?php
			} else {
?>
<p align="center" class=style7>
O arquivo <i><?php print("$foto"); ?></i> não existe.</p>
<?php
			}

		}elseif($statusa=='t'){

		  	if (file_exists($caminho_topo . $foto)) {
			  		unlink($caminho_topo . $foto);
?>
<p align="center" class=style7>
Você apagou o arquivo: <i><?php print("$foto"); ?></i>.</p>
<?php
			} else {
?>
<p align="center" class=style7>
O arquivo <i><?php print("$foto"); ?></i> não existe.</p>
<?php
			}

		}elseif($statusa=='p'){

		  	if (file_exists($caminho_logop . $foto))
			{
			  		unlink($caminho_logop . $foto);
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

		}elseif($statusa=='l'){
		  
		  	if (file_exists($caminho_logom . $foto))
			{	
			  		unlink($caminho_logom . $foto);	
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
$status = $_GET['status'];

if($status=='p'){
$strDiretorio = $caminho_logop; // pasta das imagens
}elseif($status=='g'){
$strDiretorio = $caminho_logo; // pasta das imagens
}elseif($status=='t'){
$strDiretorio = $caminho_topo; // pasta das imagens
}elseif($status=='f'){
$strDiretorio = $caminho_fundo; // pasta das imagens
}elseif($status=='l'){
$strDiretorio = $caminho_logom; // pasta das imagens
}

$strDiretorioAbrir = opendir($strDiretorio);

//echo "<div align=\"center\"><font color=\"#990000\" face=\"tahoma\" size=\"2\"><strong>Listando Imagens JPG e GIF de um diretorio<br><br>Diretório Escolhido: </strong>".$strDiretorio."</font></div><br><br>";

	$i = 0;

if($status=='p'){
	while ($strArquivos = readdir($strDiretorioAbrir)) {

 		if ($strArquivos != "." && $strArquivos != "..") {

 		$arquivos[] = $strArquivos;
 		sort($arquivos);

 	 	$i++;
		}
	}
}elseif($status=='g'){
	while ($strArquivos = readdir($strDiretorioAbrir)) {

 		if ($strArquivos != "." && $strArquivos != "..") {

 		$arquivos[] = $strArquivos;
 		sort($arquivos);

 	 	$i++;
		}
	}
}elseif($status=='t'){
	while ($strArquivos = readdir($strDiretorioAbrir)) {

 		if ($strArquivos != "." && $strArquivos != "..") {

    		$arquivos[] = $strArquivos;
    		sort($arquivos);
    	 	$i++;

		}
	}
}elseif($status=='f'){
	while ($strArquivos = readdir($strDiretorioAbrir)) {

 		if ($strArquivos != "." && $strArquivos != "..") {

    		$arquivos[] = $strArquivos;
    		sort($arquivos);
    	 	$i++;

		}
	}
}elseif($status=='l'){
	while ($strArquivos = readdir($strDiretorioAbrir)) {

 		if ($strArquivos != "." && $strArquivos != "..") {

 		$arquivos[] = $strArquivos;
 		sort($arquivos);

 	 	$i++;
		}
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
		if($status=='p'){
?>
			<td align=center><img border=0 src="<?php print($caminho_logop.$listar); ?>"></td>
<?
		}elseif($status=='g'){
?>
			<td align=center><img border=0 src="<?php print($caminho_logo.$listar); ?>"></td>
<?
		}elseif($status=='t'){
?>
			<td align=center><img border=0 src="<?php print($caminho_topo.$listar); ?>"></td>
<?
		}elseif($status=='f'){
?>
			<td align=center><img border=0 src="<?php print($caminho_fundo.$listar); ?>"></td>
<?
		}elseif($status=='l'){
?>
			<td align=center><img border=0 src="<?php print($caminho_logom.$listar); ?>"></td>
<?
		}
	}
	/*elseif($extensao[1] == "swf")
	{
?>
	<td align=center>Arquivo flash</td>
<?php
	}*/
?>
	<td><?php print("$listar"); ?></td>
<?
if($status=='p'){
?>
	<td><a href="#" onClick="window.opener.document.formulario.im_img_peq.value='<?php print("$listar"); ?>'; window.opener.focus(); window.close();">Selecionar</a> - <a href="#" onClick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$listar"); ?>\'?')) { window.location='<? print("$PHP_SELF"); ?>?B1=Apagar Imagem&foto=<?php print("$listar"); ?>&statusa=<?=$status ?>'; }">Apagar</a></td>
</tr>
<?
}elseif($status=='g'){
?>
	<td><a href="#" onClick="window.opener.document.formulario.im_img.value='<?php print("$listar"); ?>'; window.opener.focus(); window.close();">Selecionar</a> - <a href="#" onClick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$listar"); ?>\'?')) { window.location='<? print("$PHP_SELF"); ?>?B1=Apagar Imagem&foto=<?php print("$listar"); ?>&statusa=<?=$status ?>'; }">Apagar</a></td>
</tr>
<?php
}elseif($status=='t'){
?>
	<td><a href="#" onClick="window.opener.document.formulario.im_img_topo_site.value='<?php print("$listar"); ?>'; window.opener.focus(); window.close();">Selecionar</a> - <a href="#" onClick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$listar"); ?>\'?')) { window.location='<? print("$PHP_SELF"); ?>?B1=Apagar Imagem&foto=<?php print("$listar"); ?>&statusa=<?=$status ?>'; }">Apagar</a></td>
</tr>
<?php
}elseif($status=='f'){
?>
	<td><a href="#" onClick="window.opener.document.formulario.im_img_fundo_topo.value='<?php print("$listar"); ?>'; window.opener.focus(); window.close();">Selecionar</a> - <a href="#" onClick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$listar"); ?>\'?')) { window.location='<? print("$PHP_SELF"); ?>?B1=Apagar Imagem&foto=<?php print("$listar"); ?>&statusa=<?=$status ?>'; }">Apagar</a></td>
</tr>
<?php
}elseif($status=='l'){
?>
	<td><a href="#" onClick="window.opener.document.formulario.im_img_med.value='<?php print("$listar"); ?>'; window.opener.focus(); window.close();">Selecionar</a> - <a href="#" onClick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$listar"); ?>\'?')) { window.location='<? print("$PHP_SELF"); ?>?B1=Apagar Imagem&foto=<?php print("$listar"); ?>&statusa=<?=$status ?>'; }">Apagar</a></td>
</tr>
<?php
}
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
<p align="center"><b>Enviar Logomarcas</b>
<br><br>
<p align=left>
<?php

/* how many upload slots? */
define("UPLOAD_SLOTS", 10);

/* where to move the uploaded file(s) to? */
define("INCOMING", "../logos/");

if($REQUEST_METHOD!="POST")
{
?>
Última imagem selecionada:<br>
<img alt="Graphic will preview here" id="previewField" src="spacer.gif">
<?
if($status=='p'){
?>
<span class="style7"><b>ATENÇÃO:</b> A logo deve estar com o mesmo nome da logo "grande" "NO MOMENTO DE ENVIAR" a(s) logo(s) para que não ocorra problema na exibição da logo pequena.</span>
<?
}elseif($status=='l'){
?>
<span class="style7"><b>ATENÇÃO:</b> A logo deve estar com o mesmo nome da logo "grande" "NO MOMENTO DE ENVIAR" a(s) logo(s) para que não ocorra problema na exibição da logo na lista de imobiliárias no site.</span>
<?
}
?>
<?php
    /* generate form */
    echo "<form enctype=\"multipart/form-data\" method=post>\n";
    for($i=1; $i<=UPLOAD_SLOTS; $i++)
    {
        echo "<input type=file name=infile$i class=campo id=picField onchange=preview(this)><br>\n";
    }
    echo "<input type=submit value=Enviar Arquivo class=campo></form>\n";
}
else
{
     function retira_acentos( $name ) {
			  $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
								 , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"," ","'","´","`","/","\\","~","^","¨" );
			  $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
								 , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C","_","_","_","_","_","_","_","_","_" );
			  return str_replace( $array1, $array2, $name );
			}


	    if($status=='p'){


			//Função alterada nos cálculos de altura e largura
			function criar_thumbnail($origem='',$destino='',$largura='',$pre='tn_',$formato='') {

				switch($formato)
				{
					case 'JPEG':
						$tn_formato = 'jpg';
						break;
					case 'PNG':
						$tn_formato = 'png';
						break;
					case 'GIF':
						$tn_formato = 'gif';
						break;
				}

				$ext = split("[/\\.]",strtolower($origem));
				$n = count($ext)-1;
				$ext = $ext[$n];

				$arr = split("[/\\]",$origem);
				$n = count($arr)-1;
				$arra = explode('.',$arr[$n]);
				$n2 = count($arra)-1;
				$tn_name = str_replace('.'.$arra[$n2],'',$arr[$n]);
				//$destino = $destino.$pre.$tn_name.'.'.$tn_formato;
				$destino = $destino;

				if ($ext == 'jpg' || $ext == 'jpeg'){
					$im = imagecreatefromjpeg($origem);
				}elseif($ext == 'png'){
					$im = imagecreatefrompng($origem);
					imagealphablending($im, true); // setting alpha blending on
					imagesavealpha($im, true); // save alphablending setting (important)
				}elseif($ext == 'gif'){
					$im = imagecreatefromgif($origem);
				}

				$w = imagesx($im);
				$h = imagesy($im);
				$nw = $largura;
				$nh = ($h * $largura)/$w;
				if(function_exists('imagecopyresampled'))
				{
					if(function_exists('imageCreateTrueColor'))
					{
					  if($ext=='gif'){
					    $ni    = imagecreate($nw,$nh);
					  }elseif($ext=='png'){
					    $ni    = imagecreate($nw,$nh);
					  }else{
						$ni = imageCreateTrueColor($nw,$nh);
					  }
					}else{
						$ni    = imagecreate($nw,$nh);
					}
					if(!@imagecopyresampled($ni,$im,0,0,0,0,$nw,$nh,$w,$h))
					{
						imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
					}
				}else{
				  if($ext=='gif'){
				    $cor = imagecolorclosestalpha($ni, 0, 0, 0, 0);
					imagecolortransparent ($ni,$cor);
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
				  }elseif($ext=='png'){
				    $cor = imagecolorclosestalpha($ni, 0, 0, 0, 0);
					imagecolortransparent ($ni,$cor);
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
				  }else{
					$ni    = imagecreate($nw,$nh);
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
				  }
				}
				if($tn_formato=='jpg' || $tn_formato=='jpeg'){
					imagejpeg($ni,$destino,90);
				}elseif($tn_formato=='png'){
					imagepng($ni,$destino);
				}elseif($tn_formato=='gif'){
					imagegif($ni,$destino);
				}
			}

			/* where to move the uploaded file(s) to? */
			define("INCOMING2", "../logos_peq/");


			//Tamanho máximo da imagem pequena
			$largp_max = 65;
			$altp_max = 40;

			/* handle uploads */
			$noinput = true;
			for($i=1; $noinput && ($i<=UPLOAD_SLOTS); $i++) {
				if(${"infile".$i}!="none") $noinput=false;
			}
			if($noinput) {
				echo "error uploading. create 150MB coredump instead?";
				exit();
			}


			  for($i=1; $i<= UPLOAD_SLOTS; $i++) {
				if(${"infile".$i}) {

					$file = strtolower(${"infile".$i."_name"});
					move_uploaded_file(${"infile".$i}, INCOMING.${"file"});

					$nome_foto = ${file};
					$rest = substr($nome_foto, -3);
					if($rest=='jpg' || $rest=='jpeg'){
						$nome_foto2 = str_replace(".jpg","_peq.jpg","$nome_foto");
					}elseif($rest=='png'){
					 	$nome_foto2 = str_replace(".png","_peq.png","$nome_foto");
					}elseif($rest=='gif'){
					 	$nome_foto2 = str_replace(".gif","_peq.gif","$nome_foto");
					}

					//Pega tamanho da imagem
					$ImageSize = GetImageSize (INCOMING.${file});
					$Img_w = $ImageSize[0];
					$Img_h = $ImageSize[1];

					//FOTO PEQUENA
					$dest = INCOMING2 . $nome_foto2;

					if($Img_w > $Img_h){
					  if($Img_w < $largp_max){
						$largura = $Img_w;
					  }else{
						if(($Img_w/$Img_h) > round($largp_max/$altp_max, 2)){
						  $largura = $largp_max;
						}else{
						  $novoh = $altp_max;
						  $largura = round(($Img_w * $novoh)/$Img_h);
						}
					  }
					}

					if($Img_w < $Img_h){
					  if($Img_h < $altp_max){
						$largura = $Img_w;
					  }else{
						$novoh = $altp_max;
						$largura = round(($Img_w * $novoh)/$Img_h);
					  }
					}
					if($Img_w == $Img_h){
					  if($Img_w < $altp_max){
						$largura = $Img_w;
					  }else{
						$largura = $altp_max;
					  }
					}

					if($rest=='jpg' || $rest=='jpeg'){
						criar_thumbnail(INCOMING.${file},$dest,$largura,'','JPEG');
					}elseif($rest=='png'){
					  	criar_thumbnail(INCOMING.${file},$dest,$largura,'','PNG');
					}elseif($rest=='gif'){
					    criar_thumbnail(INCOMING.${file},$dest,$largura,'','GIF');
					}

					echo "<center>O arquivo <b>". ${"infile".$i."_name"}." </b>foi enviado com sucesso.</center><br><br>";
				}
			}

		}elseif($status=='l'){


			//Função alterada nos cálculos de altura e largura
			function criar_thumbnail($origem='',$destino='',$largura='',$pre='tn_',$formato='') {

				switch($formato)
				{
					case 'JPEG':
						$tn_formato = 'jpg';
						break;
					case 'PNG':
						$tn_formato = 'png';
						break;
					case 'GIF':
						$tn_formato = 'gif';
						break;
				}

				$ext = split("[/\\.]",strtolower($origem));
				$n = count($ext)-1;
				$ext = $ext[$n];

				$arr = split("[/\\]",$origem);
				$n = count($arr)-1;
				$arra = explode('.',$arr[$n]);
				$n2 = count($arra)-1;
				$tn_name = str_replace('.'.$arra[$n2],'',$arr[$n]);
				//$destino = $destino.$pre.$tn_name.'.'.$tn_formato;
				$destino = $destino;

				if ($ext == 'jpg' || $ext == 'jpeg'){
					$im = imagecreatefromjpeg($origem);
				}elseif($ext == 'png'){
					$im = imagecreatefrompng($origem);
					imagealphablending($im, true); // setting alpha blending on
					imagesavealpha($im, true); // save alphablending setting (important)
				}elseif($ext == 'gif'){
					$im = imagecreatefromgif($origem);
				}

				$w = imagesx($im);
				$h = imagesy($im);
				$nw = $largura;
				$nh = ($h * $largura)/$w;
				if(function_exists('imagecopyresampled'))
				{
					if(function_exists('imageCreateTrueColor'))
					{
					  if($ext=='gif'){
					    $ni    = imagecreate($nw,$nh);
					  }elseif($ext=='png'){
					    $ni    = imagecreate($nw,$nh);
					  }else{
						$ni = imageCreateTrueColor($nw,$nh);
					  }
					}else{
						$ni    = imagecreate($nw,$nh);
					}
					if(!@imagecopyresampled($ni,$im,0,0,0,0,$nw,$nh,$w,$h))
					{
						imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
					}
				}else{
				  if($ext=='gif'){
				    $cor = imagecolorclosestalpha($ni, 0, 0, 0, 0);
					imagecolortransparent ($ni,$cor);
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
				  }elseif($ext=='png'){
				    $cor = imagecolorclosestalpha($ni, 0, 0, 0, 0);
					imagecolortransparent ($ni,$cor);
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
				  }else{
					$ni    = imagecreate($nw,$nh);
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
				  }
				}
				if($tn_formato=='jpg' || $tn_formato=='jpeg'){
					imagejpeg($ni,$destino,90);
				}elseif($tn_formato=='png'){
					imagepng($ni,$destino);
				}elseif($tn_formato=='gif'){
					imagegif($ni,$destino);
				}
			}

			/* where to move the uploaded file(s) to? */
			define("INCOMING3", "../logos_med/");


			//Tamanho máximo da imagem media
			$largp_max = 160;
			$altp_max = 98;

			/* handle uploads */
			$noinput = true;
			for($i=1; $noinput && ($i<=UPLOAD_SLOTS); $i++) {
				if(${"infile".$i}!="none") $noinput=false;
			}
			if($noinput) {
				echo "error uploading. create 150MB coredump instead?";
				exit();
			}


			  for($i=1; $i<= UPLOAD_SLOTS; $i++) {
				if(${"infile".$i}) {

					$file = strtolower(${"infile".$i."_name"});
					move_uploaded_file(${"infile".$i}, INCOMING.${"file"});

					$nome_foto = ${file};
					$rest = substr($nome_foto, -3);
					if($rest=='jpg' || $rest=='jpeg'){
						$nome_foto2 = str_replace(".jpg","_med.jpg","$nome_foto");
					}elseif($rest=='png'){
					 	$nome_foto2 = str_replace(".png","_med.png","$nome_foto");
					}elseif($rest=='gif'){
					 	$nome_foto2 = str_replace(".gif","_med.gif","$nome_foto");
					}

					//Pega tamanho da imagem
					$ImageSize = GetImageSize (INCOMING.${file});
					$Img_w = $ImageSize[0];
					$Img_h = $ImageSize[1];

					//FOTO PEQUENA
					$dest = INCOMING3 . $nome_foto2;

					if($Img_w > $Img_h){
					  if($Img_w < $largp_max){
						$largura = $Img_w;
					  }else{
						if(($Img_w/$Img_h) > round($largp_max/$altp_max, 2)){
						  $largura = $largp_max;
						}else{
						  $novoh = $altp_max;
						  $largura = round(($Img_w * $novoh)/$Img_h);
						}
					  }
					}

					if($Img_w < $Img_h){
					  if($Img_h < $altp_max){
						$largura = $Img_w;
					  }else{
						$novoh = $altp_max;
						$largura = round(($Img_w * $novoh)/$Img_h);
					  }
					}
					if($Img_w == $Img_h){
					  if($Img_w < $altp_max){
						$largura = $Img_w;
					  }else{
						$largura = $altp_max;
					  }
					}

					if($rest=='jpg' || $rest=='jpeg'){
						criar_thumbnail(INCOMING.${file},$dest,$largura,'','JPEG');
					}elseif($rest=='png'){
					  	criar_thumbnail(INCOMING.${file},$dest,$largura,'','PNG');
					}elseif($rest=='gif'){
					    criar_thumbnail(INCOMING.${file},$dest,$largura,'','GIF');
					}

					echo "<center>O arquivo <b>". ${"infile".$i."_name"}." </b>foi enviado com sucesso.</center><br><br>";
				}
			}

		} elseif($status=='t') {
         for($i=1; $i<=UPLOAD_SLOTS; $i++) {
            if ($_FILES["infile".$i]["error"] == 0 && strstr($_FILES["infile".$i]["name"], ".png")) {
					move_uploaded_file($_FILES["infile".$i]["tmp_name"], $caminho_topo . $_FILES["infile".$i]["name"]);

               //Pega tamanho da imagem
         		$ImageSize = GetImageSize ($caminho_topo . $_FILES["infile".$i]["name"]);
         		$Img_w = $ImageSize[0];
         		$Img_h = $ImageSize[1];

               $max_w = 218;
               $max_h = 113;

               if ($Img_w != $max_w || $Img_h != $max_h) {
                  unlink($caminho_topo . $_FILES["infile".$i][name]);
   					echo "<center>O arquivo <b>" . $caminho_topo . $_FILES["infile".$i]["name"] . " </b> é diferente do tamanho padrão (218x113).</center><br><br>";
               } else {
   					echo "<center>O arquivo <b>" . $caminho_topo . $_FILES["infile".$i]["name"] . " </b>foi enviado com sucesso.</center><br><br>";
               }
            } elseif ($_FILES["infile".$i]["error"] == 0 && $_FILES["infile".$i]["type"] <> "image/png") {
   					echo "<center>Apenas são aceitos arquivos no formato PNG</center><br><br>";
            }


         }
		} elseif($status=='f') {
         for($i=1; $i<=UPLOAD_SLOTS; $i++) {
            if ($_FILES["infile".$i]["error"] == 0) {
					move_uploaded_file($_FILES["infile".$i]["tmp_name"], $caminho_fundo . $_FILES["infile".$i]["name"]);

               //Pega tamanho da imagem
         		$ImageSize = GetImageSize ($caminho_fundo . $_FILES["infile".$i]["name"]);
         		$Img_w = $ImageSize[0];
         		$Img_h = $ImageSize[1];

               $max_w = 218;
               $max_h = 116;

               if ($Img_h != $max_h) {
                  unlink($caminho_fundo . $_FILES["infile".$i][name]);
   					echo "<center>O arquivo <b>" . $caminho_fundo . $_FILES["infile".$i]["name"] . " </b> possui altura diferente da altura padrão (116 de altura).</center><br><br>";
               } else {
   					echo "<center>O arquivo <b>" . $caminho_fundo . $_FILES["infile".$i]["name"] . " </b>foi enviado com sucesso.</center><br><br>";
               }


            }
         }
		} elseif($status=='g') {

			//Função alterada nos cálculos de altura e largura
			function criar_thumbnail($origem='',$destino='',$largura='',$pre='tn_',$formato='') {

				switch($formato)
				{
					case 'JPEG':
						$tn_formato = 'jpg';
						break;
					case 'PNG':
						$tn_formato = 'png';
						break;
					case 'GIF':
						$tn_formato = 'gif';
						break;
				}

				$ext = split("[/\\.]",strtolower($origem));
				$n = count($ext)-1;
				$ext = $ext[$n];

				$arr = split("[/\\]",$origem);
				$n = count($arr)-1;
				$arra = explode('.',$arr[$n]);
				$n2 = count($arra)-1;
				$tn_name = str_replace('.'.$arra[$n2],'',$arr[$n]);
				//$destino = $destino.$pre.$tn_name.'.'.$tn_formato;
				$destino = $destino;

				if ($ext == 'jpg' || $ext == 'jpeg'){
					$im = imagecreatefromjpeg($origem);
				}elseif($ext == 'png'){
					$im = imagecreatefrompng($origem);
					imagealphablending($im, true); // setting alpha blending on
					imagesavealpha($im, true); // save alphablending setting (important)
				}elseif($ext == 'gif'){
					$im = imagecreatefromgif($origem);
				}

				$w = imagesx($im);
				$h = imagesy($im);
				$nw = $largura;
				$nh = ($h * $largura)/$w;
				if(function_exists('imagecopyresampled'))
				{
					if(function_exists('imageCreateTrueColor'))
					{
					  if($ext=='gif'){
					    $ni    = imagecreate($nw,$nh);
					  }elseif($ext=='png'){
					    $ni    = imagecreate($nw,$nh);
					  }else{
						$ni = imageCreateTrueColor($nw,$nh);
					  }
					}else{
						$ni    = imagecreate($nw,$nh);
					}
					if(!@imagecopyresampled($ni,$im,0,0,0,0,$nw,$nh,$w,$h))
					{
						imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
					}
				}else{
				  if($ext=='gif'){
				    $cor = imagecolorclosestalpha($ni, 0, 0, 0, 0);
					imagecolortransparent ($ni,$cor);
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
				  }elseif($ext=='png'){
				    $cor = imagecolorclosestalpha($ni, 0, 0, 0, 0);
					imagecolortransparent ($ni,$cor);
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
				  }else{
					$ni    = imagecreate($nw,$nh);
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
				  }
				}
				if($tn_formato=='jpg' || $tn_formato=='jpeg'){
					imagejpeg($ni,$destino,90);
				}elseif($tn_formato=='png'){
					imagepng($ni,$destino);
				}elseif($tn_formato=='gif'){
					imagegif($ni,$destino);
				}
			}

			/* where to move the uploaded file(s) to? */
			define("INCOMING", "../logos/");

			//Tamanho máximo da imagem grande
			$larg_max = 239;
			$alt_max = 146;


			/* handle uploads */
			$noinput = true;
			for($i=1; $noinput && ($i<=UPLOAD_SLOTS); $i++) {
				if(${"infile".$i}!="none") $noinput=false;
			}
			if($noinput) {
				echo "error uploading. create 150MB coredump instead?";
				exit();
			}

			for($i=1; $i<= UPLOAD_SLOTS; $i++) {
				if(${"infile".$i}) {

					$file = strtolower(${"infile".$i."_name"});
					move_uploaded_file(${"infile".$i}, INCOMING.${"file"});

					$nome_foto = ${file};
					$rest = substr($nome_foto, -3);
					if($rest=='jpg' || $rest=='jpeg'){
						$nome_foto2 = str_replace(".jpg","_peq.jpg","$nome_foto");
					}elseif($rest=='png'){
					 	$nome_foto2 = str_replace(".png","_peq.png","$nome_foto");
					}elseif($rest=='gif'){
					 	$nome_foto2 = str_replace(".gif","_peq.gif","$nome_foto");
					}

					//Pega tamanho da imagem
					$ImageSize = GetImageSize (INCOMING.${file});
					$Img_w = $ImageSize[0];
					$Img_h = $ImageSize[1];

					//FOTO GRANDE
					if($Img_w > $Img_h){
					  if($Img_w < $larg_max){
						$largura = $Img_w;
					  }else{
						if(($Img_w/$Img_h) > round($larg_max/$alt_max, 2)){
						  $largura = $larg_max;
						}else{
						  $novoh1 = $alt_max;
						  $largura = round(($Img_w * $novoh1)/$Img_h);
						}
					  }
					}
					if($Img_w < $Img_h){
					  if($Img_h < $alt_max){
						$largura = $Img_w;
					  }else{
						$novoh1 = $alt_max;
						$largura = round(($Img_w * $novoh1)/$Img_h);
					  }
					}
					if($Img_w == $Img_h){
					  if($Img_w < $alt_max){
						$largura = $Img_w;
					  }else{
						$largura = $alt_max;
					  }
					}
					//echo $largura;
					if($rest=='jpg' || $rest=='jpeg'){
						criar_thumbnail(INCOMING.${file},INCOMING.${file},$largura,'','JPEG');
					}elseif($rest=='png'){
					  	criar_thumbnail(INCOMING.${file},INCOMING.${file},$largura,'','PNG');
					}elseif($rest=='gif'){
					    criar_thumbnail(INCOMING.${file},INCOMING.${file},$largura,'','GIF');
					}
					echo "<center>O arquivo <b>". ${"infile".$i."_name"}." </b>foi enviado com sucesso.</center><br><br>";
				}
			}
		}
} /* else */
    echo '<br><br><a href="javascript:history.back()" class=linkm><< Voltar <<</a>';
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