<?php
session_start();
include("conect.php");
Header("Cache-control: private, no-cache");
Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); //Data passada
Header("Pragma: no-cache");

include("regra.php");
?>
<html>
<head>
<?
include("style.php");
?>
<script>
function apagar(foto){
	var pergunta = confirm("tem certeza que deseja apagar a foto " + foto + "?" );
	if (pergunta){
		window.location = "p_img_editor.php?apagar="+foto+"&pasta=<?=$pasta?>&tamanho=<?=$tamanho?>";
	}
}
</script>

<script type="text/javascript" src="tiny_mce/tiny_mce_popup.js"></script>
<script type="text/javascript" src="tiny_mce/filebrowser_functions.js"></script>
</head>
<?
//Função alterada nos cálculos de altura e largura
function criar_thumbnail($origem='',$destino='',$largura='',$pre='tn_',$formato='JPEG') {
   print "<div style='display: none;'>";
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
   print "</div>";
}

#Verifica se existe o diretório institucional, se n existir, cria.;
$caminho = "../imobiliarias/$pasta/institucional";
$diretorio_p = $caminho."/peq";
$diretorio_m = $caminho."/med";
$diretorio_g = $caminho."/gra";

if ($tamanho == "") {
   $tamanho = "p";
}

if ($tamanho == "m") {
   $diretorio = $diretorio_m;
} elseif ($tamanho == "g") {
   $diretorio = $diretorio_g;
} else {
   $diretorio = $diretorio_p;
}

if ($apagar <> "") {
   $tapagar = $apagar;
   $tapagar = str_replace("_peq","",$tapagar);
   $tapagar = str_replace("_med","",$tapagar);

   $apagar_g = $tapagar;
   $apagar_m = str_replace(".jpg", "_med.jpg",$tapagar);
   $apagar_p = str_replace(".jpg", "_peq.jpg",$tapagar);

   if (file_exists($diretorio_g."/".$apagar_g)) { unlink($diretorio_g."/".$apagar_g); }
   if (file_exists($diretorio_m."/".$apagar_m)) { unlink($diretorio_m."/".$apagar_m); }
   if (file_exists($diretorio_p."/".$apagar_p)) { unlink($diretorio_p."/".$apagar_p); }

   $msg = "Imagem<strong> $tapagar </strong>excluída com sucesso<BR>";

}

if (!file_exists($caminho)) {
   mkdir($diretorio, 0777);
   chmod($diretorio, 0777);

   mkdir($diretorio_p, 0777);
   chmod($diretorio_p, 0777);

   mkdir($diretorio_m, 0777);
   chmod($diretorio_m, 0777);

   mkdir($diretorio_g, 0777);
   chmod($diretorio_g, 0777);

} else {
#   chmod($caminho, 0777);

   if (!file_exists($diretorio_p)) {
      mkdir($diretorio_p, 0777);
      chmod($diretorio_p, 0777);
   } else {
#      chmod($diretorio_p, 0777);
   }

   if (!file_exists($diretorio_m)) {
      mkdir($diretorio_m, 0777);
      chmod($diretorio_m, 0777);
   } else {
#      chmod($diretorio_m, 0777);
   }

   if (!file_exists($diretorio_g)) {
      mkdir($diretorio_g, 0777);
      chmod($diretorio_g, 0777);
   } else {
#      chmod($diretorio_g, 0777);
   }
}
?>
<script>
   function mostra_cadastro () {
	   if (document.getElementById("inserir").style.display=="block") {
   	   document.getElementById("inserir").style.display="none";
      } else {
   	   document.getElementById("inserir").style.display="block";
      }
   }
</script>
<body topmargin="0" leftmargin="0" rightmargin="0">
 <table border="0" cellspacing="5" cellpadding="0" width="100%">
  <tr>
   <td valign="top"><table border="0" cellpadding="0" cellspacing="1" bgcolor="#<?php print("$cor5"); ?>" width="100%">
    <tr>
     <td bgcolor="#<?php print("$cor1"); ?>" align="left" valign="top"><table width="100%" cellpadding="0" cellspacing="0">
		<tr>
       <td>

<?
        if ($enviar == "1") {
         ###########################################################ED
         #numerar imagens disponíveis
         $abre = opendir($diretorio_g);
         $m = 0;
         while (($tnome = readdir($abre)) !== false) {
            $t2_nome = explode(".", $tnome);
            $t2_conta = count($t2_nome);
            $t_ext = ".".$t2_nome[($t2_conta-1)];
            $conta = str_replace($t_ext, "", $tnome);
            $conta = str_replace($pasta."_","",$conta);
            $all[] = $conta;
         }
         rsort($all);
         $posicao = $all[0]+1;
         if (strlen($posicao) == 1) {
		      $posicao = "00".$posicao;
         }
         if (strlen($posicao) == 2) {
		      $posicao = "0".$posicao;
         }

         define("UPLOAD_SLOTS", 10);
         for($i=1; $i<=UPLOAD_SLOTS; $i++) {

            if ($_FILES["infile".$i]["error"] == 0 && (strstr($_FILES["infile".$i]["name"], ".jpg") || strstr($_FILES["infile".$i]["name"], ".jpeg"))) {
               $imagem_grande = $diretorio_g . "/" . $pasta."_".$posicao.".jpg";
               $imagem_media = $diretorio_m . "/" . $pasta."_".$posicao."_med.jpg";
               $imagem_pequena = $diretorio_p . "/" . $pasta."_".$posicao."_peq.jpg";
					move_uploaded_file($_FILES["infile".$i]["tmp_name"], $imagem_grande);
               #verifica tamanho.
					$ImageSize = GetImageSize ($imagem_grande);
					$Img_w = $ImageSize[0];
					$Img_h = $ImageSize[1];

               #gera thumb med
     				$larg_max_m = 316;
   				$alt_max_m = 231;

               #proporções de tamanho.
               $razao_larg_med = $Img_w / $larg_max_m;
               $razao_alt_med = $Img_h / $alt_max_m;

               if ($razao_larg_med > 1 || $razao_alt_med > 1) {
                  if ($razao_larg_med < $razao_alt_med) {
						  $largura_m = round(($Img_w * $alt_max_m)/$Img_h);
                  } else {
                     $largura_m = $larg_max_m;
                  }
               } else {
		            $largura_m = $Img_w;
               }
               criar_thumbnail($imagem_grande,$imagem_media,$largura_m,'','JPEG');

               #gera thumb peq
     				$larg_max_p = 110;
   				$alt_max_p = 83;

               #proporções de tamanho.
               $razao_larg_peq = $Img_w / $larg_max_p;
               $razao_alt_peq = $Img_h / $alt_max_p;

               if ($razao_larg_peq > 1 || $razao_alt_peq > 1) {
                  if ($razao_larg_peq < $razao_alt_peq) {
						  $largura_p = round(($Img_w * $alt_max_p)/$Img_h);
                  } else {
                     $largura_p = $larg_max_p;
                  }
               } else {
		            $largura_m = $Img_w;
               }
               criar_thumbnail($imagem_grande,$imagem_pequena,$largura_p,'','JPEG');
 					print "<center>O arquivo <b> " . $_FILES["infile".$i]["name"] . " </b>foi enviado com sucesso.</center><br>";
               $posicao++;
               if (strlen($posicao) == 1) {
      		      $posicao = "00".$posicao;
               }
               if (strlen($posicao) == 2) {
      		      $posicao = "0".$posicao;
               }
            } elseif ($_FILES["infile".$i]["error"] == 0 && (!strstr($_FILES["infile".$i]["name"], ".jpg") && !strstr($_FILES["infile".$i]["name"], ".jpeg"))) {
 					print "<center>O arquivo <b> " . $_FILES["infile".$i]["name"] . " </b>não é um arquivo JPG.</center><br>";
            }
         }
        }
?>
        <div id="botao_cadastro"><center><?=$msg?><a href="javascript: mostra_cadastro();">Cadastrar Imagens</a></center></div>
        <div id="inserir" style="display: none;">
         <table cellpadding="0" cellspacing="10" align="center">
          <tr><td>
             <form action="<?=$PHP_SELF?>" name="form1" id="form1" enctype="multipart/form-data" method="post">
              <input type="hidden" name="pasta" value="<?=$pasta?>">
              <input type="hidden" name="enviar" value="1">
              <table cellpadding="0" cellspacing="3">
               <tr><td valign="top" width="70">Imagem:</td><td><input class="campo" name="infile1" type="file"><br></td></tr>
               <tr><td></td><td><input class="campo" name="infile2" type="file"><br></td></tr>
               <tr><td></td><td><input class="campo" name="infile3" type="file"><br></td></tr>
               <tr><td></td><td><input class="campo" name="infile4" type="file"><br></td></tr>
               <tr><td></td><td><input class="campo" name="infile5" type="file"><br></td></tr>
               <tr><td></td><td><input class="campo" name="infile6" type="file"><br></td></tr>
               <tr><td></td><td><input class="campo" name="infile7" type="file"><br></td></tr>
               <tr><td></td><td><input class="campo" name="infile8" type="file"><br></td></tr>
               <tr><td></td><td><input class="campo" name="infile9" type="file"><br></td></tr>
               <tr><td></td><td><input class="campo" name="infile10" type="file"><br></td></tr>
               <tr><td></td><td><input type="submit" value="Enviar" name="B1" class="campo" /></td></tr>
              </table>
            </form>
          </td></tr>
          <tr><td height=5></td></tr>
         </table>
        </div>
        <div id="visualizacao">
         <table cellpadding="0" cellspacing="5" align="center">
          <tr>
          <td width="100" align="center"><a href="<?=$PHP_SELF?>?pasta=<?=$pasta?>&tamanho=p">
            <? if ($tamanho=="p") { print "<strong>Pequenas</strong>"; } else { print "Pequenas"; } ?> </a></td>
          <td>|</td>
          <td width="100" align="center"><a href="<?=$PHP_SELF?>?pasta=<?=$pasta?>&tamanho=m">
            <? if ($tamanho=="m") { print "<strong>Médias</strong>"; } else { print "Médias"; } ?> </a></td>
          <td>|</td>
          <td width="100" align="center"><a href="<?=$PHP_SELF?>?pasta=<?=$pasta?>&tamanho=g">
            <? if ($tamanho=="g") { print "<strong>Grandes</strong>"; } else { print "Grandes"; } ?> </a></td>
          </tr>
         </table>
        </div>
        <div id="imagens">
         <table cellpadding="0" cellspacing="10" align="center">
          <tr>
<?
// Abre um diretorio conhecido, e faz a leitura de seu conteudo
if (is_dir($diretorio)) {
    if ($dh = opendir($diretorio)) {
        $i = 0;
        while (($foto = readdir($dh)) !== false) {
           if (filetype($diretorio ."/". $foto) == "file") {
              if ($i % 4 == 0 && $i > 0) {
   			     print "</tr><tr>\n";
              }
              print "<td width='110' align='center'><a href=\"javascript:FileBrowserDialogue.insert('imagem','".$diretorio."/','".$foto."',' Institucional');\"><img src='".$diretorio."/".$foto."' height='83' border='0' /></a><br />
            <a href=\"javascript:apagar('".$foto."');\">Apagar</a></td>\n";
              $i++;
           }
        }
        closedir($dh);
    }
}
?>
          </tr>
         </table>
        </div>
       </td>
		</tr>
     </table></td>
    </tr>
   </table></td>
  </tr>
 </table>
</body>
</html>