<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("regra.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("style.php"); ?>
<?php include("vnect.php"); ?>
<?php
include("funcoes.php");

//Tamanho máximo da imagem grande
$larg_max = 640;
$alt_max = 640;

//Tamanho máximo da imagem media
$largm_max = 350;
$altm_max = 350;

//Tamanho máximo da imagem pequena
$largp_max = 138;
$altp_max = 103;
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

<body leftmargin="0" topmargin="0">
<table border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td width="168" valign="top"><?php include("menu.php"); ?></td>
    <td valign="top"><table border="0" cellpadding="0" cellspacing="1" bgcolor="#<?php print("$cor5"); ?>" width="100%">
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" align="center" valign="top"><br>
        <table border="0" cellpadding="0" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>" width="95%">
        <tr>
        	<td><p align="center"><b>Enviar Imagens</b>
<br><br>
<p align=left>
- As imagens dos imóveis devem ser salvas com o nome no seguinte formato: "ref"_1.jpg, "ref"_2.jpg, etc.<br>
Por exemplo:<br>
Para o imóvel Ref.: 110-a as imagens serão 110-a_1.jpg, 110-a_2.jpg e assim sucessivamente conforme a quantidade de fotos o imóvel tiver.<br>
- O tamanho do arquivo deve ter 640 pixels no lado maior.<br>
- O ideal é que o tamanho em Kb da imagem não ultrapasse os 20Kb.<br><br>

<span class="style7">Obs.: Favor prestar atenção nos nomes e tamanhos dos arquivos. Caso contrário o funcionamento do site poderá ser afetado.</span><br><br>
<?php
 
/* how many upload slots? */ 
define("UPLOAD_SLOTS", 10); 

/* where to move the uploaded file(s) to? */ 
define("INCOMING", $caminhob); 

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
    echo "<input type=submit value=Enviar Arquivo class=campo></form>\n"; 
} 
else
{ 
    /* handle uploads */ 
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
	$dest = "$caminhop" . $nome_foto2;
		
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
	$dest = "$caminhom" . $nome_foto;
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
	
//COLOCAR MARCA DÁGUA NA FOTO MEDIA
  // obter a origem da foto 
  $b = imagecreatefromjpeg($caminhom . $nome_foto) or die ("Não foi possível criar a imagem a partir do JPEG");
 	
 	// largura da imagem de origem 
  	$bx = imagesx($b); 
	// altura da imagem de origem 
 	$by = imagesy($b); 

 	$lm = $b;
 	
 	//Arquivo de Marca dágua
 	$arq_marca = $caminho . "painel/logo_eliteimoveis.png";
 	
 	//Tamanho do arquivo de marca dágua
 	$marca_size = GetImageSize ($arq_marca);
	$marca_w = $marca_size[0];
	$marca_h = $marca_size[1];
 	
 // este recurso faz com que a marca d'agua não seja adicionada às miniaturas (thumbnails)
 //if ($bx > 200)
 //{
 
 // adicionar marca d'água 
 // possíveis posicoes
 // bottomright = em baixo no lado direito
 // bottomleft = em baixo no lado esquerdo
 // topright = em cima do lado direito
 // topleft = em cima do lado esquerdo
 $pos = "bottomright";
 
 //posicionamento da marca d'água 
 	if ($pos == "topleft") 
 	{ 
    $src_x = 0;
    $src_y = 0; 
 	} 
 	elseif ($pos == "topright") 
	{ 
		$src_x = $bx - ($marca_w + 5);
	  $src_y = 0; 
	}
	elseif ($pos == "bottomleft") 
	{ 
	  $src_x = 0; 
		$src_y = $by - ($marca_h + 5); 
	} 
	elseif ($pos == "bottomright") 
	{
		$src_x = $bx - ($marca_w + 5);
		$src_y = $by - ($marca_h + 5);
	}
			// aqui que juntamos a marca d'agua com a foto
			ImageAlphaBlending($lm, true) or die ("não foi possível mesclar a marca d'água"); 
			// habilitar para o GD 2+ 
      // nome do arquivo que servirá como marca d'água (formato png)
			$logoImage = ImageCreateFromPNG($arq_marca); 
			$logoW = ImageSX($logoImage); 
			$logoH = ImageSY($logoImage); 
			ImageCopy($lm,$logoImage,$src_x,$src_y,0,0,$logoW,$logoH);
	
	//}//if do maior que 200
	
		   // qual a qualidade do jpeg - neste caso 80
		   Imagejpeg($lm,$caminhom . $nome_foto,80);
		   imageDestroy($lm);
		
//TERMINA FOTO MEDIA

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
	//rename(INCOMING.${file}.${file}, INCOMING.${file});
	
//COLOCAR MARCA DÁGUA NA FOTO GRANDE
  // obter a origem da foto 
  $b = imagecreatefromjpeg($caminhob . $nome_foto) or die ("Não foi possível criar a imagem a partir do JPEG");
 	
 	// largura da imagem de origem 
  	$bx = imagesx($b); 
	// altura da imagem de origem 
 	$by = imagesy($b); 

 	$lm = $b;
 	
 	//Arquivo de Marca dágua
 	$arq_marca = $caminho . "painel/logo_eliteimoveis.png";
 	
 	//Tamanho do arquivo de marca dágua
 	$marca_size = GetImageSize ($arq_marca);
	$marca_w = $marca_size[0];
	$marca_h = $marca_size[1];
 	
 // este recurso faz com que a marca d'agua não seja adicionada às miniaturas (thumbnails)
 //if ($bx > 200)
 //{
 
 // adicionar marca d'água 
 // possíveis posicoes
 // bottomright = em baixo no lado direito
 // bottomleft = em baixo no lado esquerdo
 // topright = em cima do lado direito
 // topleft = em cima do lado esquerdo
 $pos = "bottomright";
 
 //posicionamento da marca d'água 
 	if ($pos == "topleft") 
 	{ 
    $src_x = 0;
    $src_y = 0; 
 	} 
 	elseif ($pos == "topright") 
	{ 
		$src_x = $bx - ($marca_w + 5);
	  $src_y = 0; 
	}
	elseif ($pos == "bottomleft") 
	{ 
	  $src_x = 0; 
		$src_y = $by - ($marca_h + 5); 
	} 
	elseif ($pos == "bottomright") 
	{
		$src_x = $bx - ($marca_w + 5);
		$src_y = $by - ($marca_h + 5);
	}
			// aqui que juntamos a marca d'agua com a foto
			ImageAlphaBlending($lm, true) or die ("não foi possível mesclar a marca d'água"); 
			// habilitar para o GD 2+ 
      // nome do arquivo que servirá como marca d'água (formato png)
			$logoImage = ImageCreateFromPNG($arq_marca); 
			$logoW = ImageSX($logoImage); 
			$logoH = ImageSY($logoImage); 
			ImageCopy($lm,$logoImage,$src_x,$src_y,0,0,$logoW,$logoH);
	
	//}//if do maior que 200
	
		   // qual a qualidade do jpeg - neste caso 80
		   Imagejpeg($lm,$caminhob . $nome_foto,80);
		   imageDestroy($lm);

//TERMINA FOTO GRANDE
      
        }
    }

} /* else */ 
    echo '<br><br><a href="javascript:history.back()" class=linkm><< Voltar <<</a>';
?>
</td>
      </tr>
    </table></td>
      </tr>
    </table>
<?php include("bruc.php"); ?>
	</td>
  </tr>
</table>
</body>
</html>
