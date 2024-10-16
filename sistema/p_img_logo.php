<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

//include("regra.php");
?>
<html>
<head>
<?php
include("style.php");
?>
<?php
include("funcoes.php");

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
// End -->
</script>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
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
	
//	if (file_exists($caminho_logo . $foto))
//	{
	
	$foto_peq = str_replace(".jpg","_peq.jpg",$foto);
		if (file_exists($caminho_logop . $foto_peq)) {
			unlink($caminho_logop . $foto_peq);
		}
		if (file_exists($caminho_logo . $foto)) {
			unlink($caminho_logo . $foto);
		}
		
	
		
?>
<p align="center" class=style7>
Você apagou o arquivo: <i><?php print("$foto"); ?></i>.</p>
<?php
//	}
//	else
//	{
?>
<!--p align="center" class=style7>
O arquivo <i><?php //print("$foto"); ?></i> não existe.</p-->
<?php
//	}
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
                  <tr><td colspan="2" bgcolor="<?php print("$cor6"); ?>" class=style1>
                  <p align="center">
                  Escolha a imagem que deseja selecionar ou apagar.</td></tr>
<tr><td class=style1>
	<table width=500>
<?php
$strDiretorio = $caminho_logo; // pasta das imagens

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
	<td align=center class="style1"><img border=0 src="<?php print($caminho_logo.$listar); ?>"></td>
<?php
	}
	/*elseif($extensao[1] == "swf")
	{
?>
	<td align=center>Arquivo flash</td>
<?php
	}*/
?>
	<td class="style1"><?php print("$listar"); ?></td>
	<td class="style1"><a href="#" onClick="window.opener.document.formulario.im_img.value='<?php print("$listar"); ?>'; window.opener.focus(); window.close();" class="style1">Selecionar</a> - <a href="#" onClick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$listar"); ?>\'?')) { window.location='<? print("$PHP_SELF"); ?>?B1=Apagar Imagem&foto=<?php print("$listar"); ?>'; }" class="style1">Apagar</a></td>
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
<p align="center" class="style1"><b>Enviar Logomarcas</b>
<br><br>
<p align=left class="style1">
<?php
 
/* how many upload slots? */ 
define("UPLOAD_SLOTS", 10); 

/* where to move the uploaded file(s) to? */ 
//define("INCOMING", $caminho_logo); 

if($REQUEST_METHOD!="POST") 
{
?>
Última imagem selecionada:<br>
<img alt="Graphic will preview here" id="previewField" src="spacer.gif">
<?php
    /* generate form */ 
    echo "<form enctype=\"multipart/form-data\" method=post>\n"; 
    for($i=1; $i<=UPLOAD_SLOTS; $i++) 
    { 
        echo "<input type=file name=infile$i class=campo id=picField onchange=preview(this)><br>\n"; 
    } 
    echo "<input type=submit value=Enviar Arquivo class=campo3></form>\n"; 
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
			
			//Função alterada nos cálculos de altura e largura
			function criar_thumbnail($origem='',$destino='',$largura='',$pre='tn_',$formato='JPEG') { 
			
				switch($formato) 
				{ 
					case 'JPEG': 
						$tn_formato = 'jpg'; 
						break; 
					case 'PNG': 
						$tn_formato = 'png'; 
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
				}elseif($ext == 'gif'){ 
					return false; 
				} 
				$w = imagesx($im); 
				$h = imagesy($im); 
				$nw = $largura;
				$nh = ($h * $largura)/$w;
				if(function_exists('imagecopyresampled')) 
				{ 
					if(function_exists('imageCreateTrueColor')) 
					{ 
						$ni = imageCreateTrueColor($nw,$nh); 
					}else{ 
						$ni    = imagecreate($nw,$nh); 
					} 
					if(!@imagecopyresampled($ni,$im,0,0,0,0,$nw,$nh,$w,$h)) 
					{ 
						imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h); 
					} 
				}else{ 
					$ni    = imagecreate($nw,$nh); 
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h); 
				} 
				if($tn_formato=='jpg'){ 
					imagejpeg($ni,$destino,90); 
				}elseif($tn_formato=='png'){ 
					imagepng($ni,$destino); 
				} 
			}
			
			/* where to move the uploaded file(s) to? */ 
			define("INCOMING", "../logos/");
			define("INCOMING2", "../logos_peq/");

			//Tamanho máximo da imagem grande
			$larg_max = 239;
			$alt_max = 98;
			
			//Tamanho máximo da imagem pequena
			$largp_max = 90;
			$altp_max = 145;
			
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
					copy(${"infile".$i}, INCOMING.${"file"});
					
					$nome_foto = ${file};
					$rest = substr($nome_foto, -4);
					$nome_foto2 = str_replace(".jpg","_peq.jpg","$nome_foto");
					 
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
					criar_thumbnail(INCOMING.${file},$dest,$largura,'','JPEG');
					
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
					criar_thumbnail(INCOMING.${file},INCOMING.${file},$largura,'','JPEG');
					 
					echo "<center>O arquivo <b>". ${"infile".$i."_name"}." </b>foi enviado com sucesso.</center><br><br>"; 
				}
			}
   
 
    /* handle uploads */ 
/*    
    $noinput = true; 
    for($i=1; $noinput && ($i<=UPLOAD_SLOTS); $i++) 
    { 
        if(${"infile".$i}!="none") $noinput=false; 
    } 
    if($noinput) 
    { 
        echo "error uploading. create 150MB coredump instead?"; 
        exit(); 
    } 


    for($i=1; $i<= UPLOAD_SLOTS; $i++) 
    { 
        if(${"infile".$i}){ 

	         //$file = strtolower(${"infile".$i."_name"});
	         $file = ${"infile".$i."_name"};
	         copy(${"infile".$i}, INCOMING.${file});
	         $arquivo_novo = retira_acentos(${file});
	         //rename(INCOMING.${file}, INCOMING.${arquivo_novo});
            echo "O arquivo <b><i>". $arquivo_novo." </i></b>foi enviado com sucesso.<br><br>";
            
		//$nome_foto = ${"infile".$i."_name"};
		$nome_foto = ${file};
		$rest = substr($nome_foto, -4);
		$nome_foto2 = str_replace(".jpg","_peq.jpg","$nome_foto");

	//Pega tamanho da imagem
	$ImageSize = GetImageSize (INCOMING.${file});
	$Img_w = $ImageSize[0];
	$Img_h = $ImageSize[1];
           
//FOTO PEQUENA
	$dest = "$caminho_logop" . $nome_foto2;
		
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
	criar_thumbnail(INCOMING.${file},$dest,$largura,'','JPEG');
	//rename($dest.$nome_foto, $dest);
	
// TERMINA FOTO PEQUENA

//FOTO MEDIA
	$dest = "$caminho_logo" . $nome_foto;
	if($Img_w > $Img_h){
	  if($Img_w < $largm_max){
	  	$largura = $Img_w;
	  }else{
	  	if(($Img_w/$Img_h) > round($largm_max/$altm_max, 2)){
		  $largura = $largm_max;
	  	}else{
	  	  $novoh1 = $altm_max;
      	  $largura = round(($Img_w * $novoh1)/$Img_h);
	  	}
	  }
	}
	if($Img_w < $Img_h){
	  if($Img_h < $altm_max){
	  	$largura = $Img_w;
	  }else{
	  	$novoh1 = $altm_max;
      	$largura = round(($Img_w * $novoh1)/$Img_h);
	  }
	}
	if($Img_w == $Img_h){
	  if($Img_w < $altm_max){
	  	$largura = $Img_w;
	  }else{
	  	$largura = $altm_max;
	  }
	}
	//echo $largura;
	criar_thumbnail(INCOMING.${file},$dest,$largura,'','JPEG');
	//rename(INCOMING.${file}.${file}, INCOMING.${file});
		
//TERMINA FOTO MEDIA
      
        }
    }
*/    

} /* else */ 
    echo '<br><br><a href="javascript:window.close()" class="style1">Fechar</a>';
?>
</td>
</tr>
	</table>
	</center>
	</div>
<?php
//include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>