<?
if ($pasta_imobiliaria == "") {
   $pasta_imobiliaria = "murask";
}

################################################################################
# Script que confere as imagens, e verifica se tem a pequena.

/*
function criar_thumbnail($origem='',$destino='',$largura='',$pre='tn_',$formato='JPEG') {
   switch($formato) {
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

	if ($ext == 'jpg' || $ext == 'jpeg') {
   	$im = imagecreatefromjpeg($origem);
	} elseif ($ext == 'png') {
		$im = imagecreatefrompng($origem);
	} elseif ($ext == 'gif') {
		return false;
	}
	$w = imagesx($im);
	$h = imagesy($im);
	$nw = $largura;
	$nh = ($h * $largura)/$w;
   if (function_exists('imagecopyresampled'))	{
      if(function_exists('imageCreateTrueColor')) {
         $ni = imageCreateTrueColor($nw,$nh);
      } else {
			$ni    = imagecreate($nw,$nh);
      }
		if (!@imagecopyresampled($ni,$im,0,0,0,0,$nw,$nh,$w,$h)) {
         imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
      }
   } else {
      $ni = imagecreate($nw,$nh);
      imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
   }
   if ($tn_formato=='jpg') {
      imagejpeg($ni,$destino,90);
   } elseif($tn_formato=='png') {
      imagepng($ni,$destino);
   }
}
*/
#função feita para verificar e sincronizar as imagens da rebri
function ver_imgs($grande, $pequena) {
   $original = opendir($grande);
   $i = 'n';
   $j = 0;

   $total = 0;
   $erros = 0;
   $acertos = 0;
   $corrigidos = 0;
   while ($imagemg = readdir($original)) {
      $total++;
      if ($imagemg <> "." && $imagemg <> "..") {
         $imgori = $grande . $imagemg;
         $imagemp = str_replace(".jpg", "_peq.jpg", $imagemg);
         $imgpeq = $pequena . $imagemp;
         if (!file_exists($pequena.$imagemp) && is_file($imgori)) {
#            chmod($imgori,777);

     			$ImageSize = GetImageSize ($imgori);
     			$Img_w = $ImageSize[0];
     			$Img_h = $ImageSize[1];

            $largp_max = 150;
            $altp_max = 112;

       		if($Img_w > $Img_h){
     			   if ($Img_w < $largp_max) {
     	   		   $largura = $Img_w;
     				} else {
     					if(($Img_w/$Img_h) > round($largp_max/$altp_max, 2)){
     					  $largura = $largp_max;
     					}else{
     			   	  $novoh = $altp_max;
     					  $largura = round(($Img_w * $novoh)/$Img_h);
     					}
     				}
    			}
         	if ($Img_w < $Img_h) {
         		if ($Img_h < $altp_max) {
         			$largura = $Img_w;
     				} else {
     					$novoh = $altp_max;
     					$largura = round(($Img_w * $novoh)/$Img_h);
     				}
     		   }
     			if ($Img_w == $Img_h) {
     			   if($Img_w < $altp_max) {
     			      $largura = $Img_w;
     				} else {
   					$largura = $altp_max;
     				}
     			}

   			criar_thumbnail($imgori,$imgpeq,$largura,'','JPEG');
     			$ImageSize = GetImageSize ($imgpeq);
     			$Img_w2 = $ImageSize[0];
     			$Img_h2 = $ImageSize[1];

            if ($Img_h2 > $altp_max) {
               while ($Img_h2 > $altp_max) {
                  criar_thumbnail($imgori,$imgpeq,($Img_w2-1),'','JPEG');
           			$ImageSize = GetImageSize ($imgpeq);
           			$Img_w2 = $ImageSize[0];
           			$Img_h2 = $ImageSize[1];
               }
            }



            if (!file_exists($pequena.$imagemp)) {
               $erros++;
   #            echo "Origem: $imgori / Destino: $imgpeq <BR>";
            } else {
   		      $corrigidos++;
            }

         } else {
            $acertos++;
   //         echo $pasta_p.$imagemp."<BR>";
         }
      }
   }
   return $corrigidos;
   #echo "Imagens que deram erro: $erros / $total <BR>";
   #echo "Imagens corrigidas: $corrigidos / $total <BR>";
   #echo "Imagens ok: $acertos / $total <BR>";
}

#uso da função ver_imgs
$pasta_g = "../imobiliarias/".$pasta_imobiliaria."/venda/";
$pasta_p = "../imobiliarias/".$pasta_imobiliaria."/venda_peq/";
ver_imgs($pasta_g, $pasta_p);

$pasta_g2 = "../imobiliarias/".$pasta_imobiliaria."/locacao/";
$pasta_p2 = "../imobiliarias/".$pasta_imobiliaria."/locacao_peq/";
ver_imgs($pasta_g2, $pasta_p2);

?>