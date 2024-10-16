<?
set_time_limit(0);
session_start();
?>

<html>
<head>
<title>Gerar XML</title>
</head>
<body>

<?
include("conect.php");
include("funcoes/funcoes.php");

$max_img = 100;

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

if (($enviar == 1) || ($f <> "") || ($r <> "")) {
$g_pasta = "../xml_completo/";

$limpa = $g_pasta;

   if ($enviar == 1) {

      if($abre = @opendir($limpa)) {
         while (false !== ($arquivo = readdir($abre))) {
            @unlink("$limpa/$arquivo");
         }
         @closedir($abre);
      }

	   $f = 0;

   }

?>

<div style='border:solid 1px #CCC; margin:50px;padding:10px'>
   <h1 style='text-align:center'>Copiando...</h1>
   <p align="center">

<?

//$site = "http://201.15.46.77/intranet/";
$site = "http://192.168.0.1/web/rebri/";
//XML de notícias.
if (is_numeric($_GET['f'])) {
   $f = $_GET['f'];
} else {
   $f = "0";
}

$nome_pasta = "murask";
$cod_imob = '3';

function padrao ($conteudo) {
   $conteudo = str_replace("&", "&amp;", $conteudo);
   $conteudo = str_replace("<", "&lt;", $conteudo);
   $conteudo = str_replace(">", "&gt;", $conteudo);
   $conteudo = str_replace("'", "&apos;", $conteudo);
   $conteudo = str_replace("\"", "&quot;", $conteudo);

   return $conteudo;
}

$conteudo = "";
$c_sql = "SELECT ref FROM muraski WHERE cod_imobiliaria = '".$cod_imob."' and
   ref <> 'x' and disponibilizar = '1' and (finalidade = '2' or finalidade = '9'
   or finalidade = '15') GROUP by ref";

$crs = mysql_query($c_sql) or die ("Erro 127 - " . mysql_error());
//$cn = mysql_fetch_assoc($crs);
$quantos = mysql_num_rows($crs);

if ($r == "") {

   $sql = "SELECT cod, cod_imobiliaria, finalidade, tipo, ref, valor, end, numero, local,
   uf, bairro, titulo, descricao, permuta, permuta_txt, metragem, n_quartos, suites,
   disponibilizar, dist_mar, dist_tipo, disp_rede, comissao_parceria, destaque, coordenadas
   FROM muraski WHERE
   cod_imobiliaria = '".$cod_imob."' and ref <> 'x' and disponibilizar = '1'
   and (finalidade = '2' or finalidade = '9' or finalidade = '15')
   GROUP by ref LIMIT $f, 1";

} else {

   $sql = "SELECT cod, cod_imobiliaria, finalidade, tipo, ref, valor, end, numero, local,
   uf, bairro, titulo, descricao, permuta, permuta_txt, metragem, n_quartos, suites,
   disponibilizar, dist_mar, dist_tipo, disp_rede, comissao_parceria, destaque, coordenadas
   FROM muraski WHERE
   cod_imobiliaria = '".$cod_imob."' and ref = '".$r."' GROUP by ref LIMIT 1";

}


$rs = mysql_query($sql) or die ("Erro 26 - ".mysql_error());
$final = "";
if (mysql_num_rows($rs) == 0) {
   $final = 1;
}
$k = 0;
$porcent = -1;
while ($not = mysql_fetch_assoc($rs)) {

   $k++;
   if ($f <> "") {
      $porcentagem = floor($f * 100 / $quantos);
   } else {
      $porcentagem = floor($k * 100 / $quantos);
   }
   if ($k == 1) {
//	   $porcent = $porcentagem;
      print $porcentagem . "% Concluído <BR>\n";
   }

   echo $not[ref]." - ";
   $conteudo = "";
   $g_arq = $not['ref'].".xml";
   $caminho = $g_pasta.$g_arq;

   $arq_xml = fopen($g_pasta.$g_arq, "wb");
//   echo $g_arq."<BR>";

/*   $conteudo .= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r"; */
/*   $conteudo .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r"; */
   $conteudo .= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r";

   $conteudo .= "<muraski>\n\r";
   $conteudo .= "<imobiliaria>\r";
   $conteudo .= "<registros>".$quantos."</registros>\r";
   $conteudo .= "<im_nome>Muraski</im_nome>\r";
   $conteudo .= "<im_pasta>".$nome_pasta."</im_pasta>\r";

   $conteudo .= "<pasta_loca>".$nome_pasta."/locacao/</pasta_loca>\r";
   $conteudo .= "<pasta_locap>".$nome_pasta."/locacao_peq/</pasta_locap>\r";
   $conteudo .= "<pasta_venda>".$nome_pasta."/venda/</pasta_venda>\r";
   $conteudo .= "<pasta_vendap>".$nome_pasta."/venda_peq/</pasta_vendap>\r";
   $conteudo .= "</imobiliaria>\r";

   $conteudo .= "<imovel>\r";
   $conteudo .= "<cod>".padrao($not[cod])."</cod>\r";
   $conteudo .= "<cod_imobiliaria>".padrao($not[cod_imobiliaria])."</cod_imobiliaria>\r";
   $conteudo .= "<finalidade>".padrao($not[finalidade])."</finalidade>\r";
   $conteudo .= "<tipo>".padrao($not[tipo])."</tipo>\r";
   $conteudo .= "<ref>".padrao($not[ref])."</ref>\r";
   $conteudo .= "<valor>".padrao($not[valor])."</valor>\r";
   $conteudo .= "<end>".padrao($not[end])."</end>\r";
   $conteudo .= "<numero>".padrao($not[numero])."</numero>\r";
   $conteudo .= "<local>".padrao($not[local])."</local>\r";
   $conteudo .= "<uf>".padrao($not[uf])."</uf>\r";
   $conteudo .= "<bairro>".padrao($not[bairro])."</bairro>\r";
   $conteudo .= "<titulo>".padrao($not[titulo])."</titulo>\r";
   $conteudo .= "<descricao>".padrao($not[descricao])."</descricao>\r";
   $conteudo .= "<permuta>".padrao($not[permuta])."</permuta>\r";
   $conteudo .= "<permuta_txt>".padrao($not[permuta_txt])."</permuta_txt>\r";
   $conteudo .= "<metragem>".padrao($not[metragem])."</metragem>\r";
   $conteudo .= "<n_quartos>".padrao($not[n_quartos])."</n_quartos>\r";
   $conteudo .= "<suites>".padrao($not[suites])."</suites>\r";
   $conteudo .= "<dist_mar>".padrao($not[dist_mar])."</dist_mar>\r";
   $conteudo .= "<dist_tipo>".padrao($not[dist_tipo])."</dist_tipo>\r";
   $conteudo .= "<disponibilizar>".padrao($not[disponibilizar])."</disponibilizar>\r";
   $conteudo .= "<disp_rede>".padrao($not[disp_rede])."</disp_rede>\r";
   $conteudo .= "<comissao_parceria>".padrao($not[comissao_parceria])."</comissao_parceria>\r";
   $conteudo .= "<destaque>".padrao($not[destaque])."</destaque>\r";
   $conteudo .= "<coordenadas>".padrao($not[coordenadas])."</coordenadas>\r";

   fwrite($arq_xml, $conteudo);


/* AS PASTAS ORIGINAIS COM OS ARQUIVOS DAS IMAGENS DA MURASKI */
   $venda = "../imobiliarias/".$nome_pasta."/venda/";
   $vendap = "../imobiliarias/".$nome_pasta."/venda_peq/";
   $loca = "../imobiliarias/".$nome_pasta."/locacao/";
   $locap = "../imobiliarias/".$nome_pasta."/locacao_peq/";
/**/

/* AS PASTAS DE TESTE COM OS ARQUIVOS DAS IMAGENS DA MURASKI

   $venda = "../imobiliarias/".$nome_pasta."/venda_original/";
   $vendap = "../imobiliarias/".$nome_pasta."/venda_peq_original/";
   $loca = "../imobiliarias/".$nome_pasta."/locacao_original/";
   $locap = "../imobiliarias/".$nome_pasta."/locacao_peq_original/";
/**/

   if ($not[finalidade] <= 7) {
      $pasta = $venda;
      $pastap = $vendap;
   } else {
	   $pasta = $loca;
      $pastap = $locap;
   }
   $abre = opendir($pasta);

   $i = 'n';
   $j = 1;
   $imgs = 0;
   while ($imagem = readdir($abre)) {
       if ((strpos("--".$imagem, "-".$not[ref]."_")) && ($imgs < $max_img)) {
         echo $imagem."<BR>";
         $imgs++;
         $imgp = str_replace(".jpg","_peq.jpg",$imagem);
         $conteudo = "";
         $conteudo .= "<imagem>\r";
         $conteudo .= "<img_nome>".padrao($imagem)."</img_nome>\r";

         ###INICIO GERAR IMAGEM NO PADRÃO
      	//Tamanho máximo da imagem
         $larg_max = 379;

		   $thumb_local = "images/temp/";
		   $thumb_salvo = "temp.jpg";
		   $thumb_salvo_p = "tempp.jpg";
//		   $thumb_salvo = "temp_".$j++.".jpg";

         $original = $pasta.$imagem;
			$destino = $thumb_local.$thumb_salvo;
			$destinop = $thumb_local.$thumb_salvo_p;

         //Apaga imagem anterior, se tiver.
         if (file_exists($destino)) {
            unlink($destino);
         }

			//FOTO NORMAL
   		//Pega tamanho da imagem
			$ImageSize = GetImageSize ($original);
			$Img_w = $ImageSize[0];
			$Img_h = $ImageSize[1];

         //Verifica o tamanho.
         //Se o tamanho for maior que o tamanho máximo: diminui
         //Senão: deixa o tamanho original.
         if ($Img_w > $larg_max) {
            $largura = $larg_max;
         } else {
			   $largura = $Img_w;
         }

         //Chama a função que gera a imagem.
			criar_thumbnail($original,$destino,$largura,'','JPEG');
         ###  FIM GERAR IMAGEM NO PADRÃO

         $conteudo .= "<img_arquivo>\r";

         $source_file = $destino;
         $p_file = $pastap.$imgp;

         $handle = fopen($source_file,'rb');
         $file_content = fread($handle,filesize($source_file));
			fclose($handle);
			$encoded = chunk_split(base64_encode($file_content));

         $conteudo .= $encoded;
         $conteudo .= "</img_arquivo>\r";

         $conteudo .= "</imagem>\r";

         fwrite($arq_xml, $conteudo);



       }
   }

   $conteudo = "";

   $conteudo .= "</imovel>\r";
   $conteudo .= "</muraski>";

   echo "<BR><BR>".$conteudo."<BR><BR><BR>";

   fwrite($arq_xml, $conteudo);
   fclose($arq_xml);

   echo "OK - <a href='".$caminho."' target='_blank'>Caminho do arquivo</a> <BR>";
//   echo "<BR><BR>".$conteudo."<BR><BR>";

}
?>
   </p>
   <p align="center">
   <?=($f + $k)?> Imóveis Copiados <BR /><BR />
<?
$next = $PHP_SELF . "?f=" . ($f+$k);
?>
   <a href="<?=$next?>">Continuar...</a>
   </p>

<?
   if (($final <> 1) && ($r == "")) {
      echo "<script>window.location.href='".$next."';</script>";
   }
?>


</div>

<?
} else {
?>

<div style='border:solid 1px #CCC; margin:50px;padding:10px'>
   <h1 style='text-align:center'>Importação de dados para o banco de dados</h1>

   <center>
   <form action="<?=$_SERVER[PHP_SELF]?>" method="POST" name="form1">
      <input type="hidden" name="enviar" value="1" />
      <input type="submit" name="B1" value="Iniciar" />
   </form>
   </center>
</div>

<?
}
?>

</body>
</html>