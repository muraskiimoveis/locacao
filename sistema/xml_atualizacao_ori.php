<?
/*
ini_set('max_execution_time','90');
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
*/
set_time_limit(0);
session_start();

require "conect.php";

//include("funcoes/funcoes.php");

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

$site = "http://201.15.46.77/intranet/";
//$site = "http://192.168.0.1/web/rebri/";
//XML de notícias.
if (is_numeric($_GET['f'])) {
   $f = $_GET['f'];
} else {
   $f = "0";
}

if (is_numeric($_GET['d'])) {
   $d = $_GET['d'];
} else {
   $d = mktime(15,30,00,05,04,2009);
//   $d = "946692001";
}

$nome_pasta = $_GET[nome_pasta];
$cod_imobiliaria = $_GET[cod_imobiliaria];

function padrao ($conteudo) {
   $conteudo = str_replace("&", "&amp;", $conteudo);
   $conteudo = str_replace("<", "&lt;", $conteudo);
   $conteudo = str_replace(">", "&gt;", $conteudo);
   $conteudo = str_replace("'", "&apos;", $conteudo);
   $conteudo = str_replace("\"", "&quot;", $conteudo);

   return $conteudo;
}

header("Content-Type: application/xml; charset=ISO-8859-1");

/*
Comentarios:
$f = From - Recebe o número do ítem a ser pesquisado no LIMIT
$d = data = Recebe a data em UNIX FORMAT
*/

   print "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n";
   print "<muraski>\n\r";

$conteudo = "";
//Conta quantas referências são.
$c_sql = "SELECT a_ref FROM atualizacoes WHERE ((a_data = '" . date("Y-m-d",$d) . "' AND a_hora >= '" . date("H:i:s",$d) . "') or (a_data > '" . date("Y-m-d",$d) . "')) AND a_ref <> '' GROUP BY a_ref";

$crs = mysql_query($c_sql) or die ("Erro 111 - " . mysql_error());
$quantos = mysql_num_rows($crs);

//Seleciona a referência específica.
$sql0 = "SELECT a_ref FROM atualizacoes WHERE ((a_data = '".date("Y-m-d",$d)."' AND a_hora >= '".date("H:i:s",$d)."') or (a_data > '".date("Y-m-d",$d)."')) AND a_ref <> '' GROUP BY a_ref ORDER BY a_ref ASC LIMIT ".$f.",1";
$rs0 = mysql_query($sql0) or die ("Erro 115 - " . mysql_error());
$not0 = mysql_fetch_assoc($rs0);

//Recebe a ultima atualização feita no arquivo (adicionada para diferenciar arquivos apagados)
$sql1 = "SELECT a_ref, a_acao, a_id FROM atualizacoes WHERE a_ref = '".$not0[a_ref]."' ORDER BY a_id DESC LIMIT 1";
$rs1 = mysql_query($sql1) or die ("Erro 119 - " . mysql_error());
$not1 = mysql_fetch_assoc($rs1);


   if (substr($not1[a_acao],0,13) == "Apagar Imóvel") {
      $apagar = 1;
   } else {
      $apagar = "";
   }

//Verifica a necessidade de importar as imagens para o arquivo. (apenas se imagens foram adicionadas, removidas ou alteradas ou se imóvel foi cadastrado)
$sql2 = "SELECT a_ref FROM atualizacoes WHERE a_ref = '".$not0[a_ref]."'
   AND ((a_data = '".date("Y-m-d",$d)."' AND a_hora >= '".date("H:i:s",$d)."')
   or (a_data > '".date("Y-m-d",$d)."')) AND (a_acao like '%Imagem%' or
   a_acao = 'Inserir Imóvel')  ORDER BY a_id DESC LIMIT 1";
$rs2 = mysql_query($sql2) or die ("Erro 134 - " . mysql_error());

   if (mysql_num_rows($rs2) > 0) {
      $imagens = 1;
   } else {
      $imagens = "";
   }


if ($apagar == "") {
   $sql = "SELECT cod, cod_imobiliaria, finalidade, tipo, ref, valor, end, numero, local,
      uf, bairro, titulo, descricao, permuta, permuta_txt, metragem, n_quartos, suites,
      dist_mar, dist_tipo, disp_rede, comissao_parceria, destaque, coordenadas,
      caracteristica, disponibilizar, tipo_logradouro, data_inicio, data_fim
      FROM muraski WHERE
      cod_imobiliaria = '".$cod_imobiliaria."' and ref = '".$not1['a_ref']."' LIMIT 1";
} else {
   $sql = "SELECT cod, cod_imobiliaria, finalidade, tipo, ref, valor, end, numero, local,
      uf, bairro, titulo, descricao, permuta, permuta_txt, metragem, n_quartos, suites,
      dist_mar, dist_tipo, disp_rede, comissao_parceria, destaque, coordenadas,
      caracteristica, disponibilizar, tipo_logradouro, data_inicio, data_fim
      FROM muraski WHERE
      cod_imobiliaria = '".$cod_imobiliaria."' and cod = '".$not1['a_id']."' LIMIT 1";
}

$rs = mysql_query($sql) or die ("Erro 26 - ".mysql_error());

print "<imobiliaria>\r";
print "<dados>".padrao($_SERVER[REQUEST_URI])."</dados>";
print "<registros>".$quantos."</registros>";
print "<im_nome>Muraski</im_nome>";
print "<im_pasta>".$nome_pasta."</im_pasta>";

print "<pasta_loca>".$nome_pasta."/locacao/</pasta_loca>";
print "<pasta_locap>".$nome_pasta."/locacao_peq/</pasta_locap>";
print "<pasta_venda>".$nome_pasta."/venda/</pasta_venda>";
print "<pasta_vendap>".$nome_pasta."/venda_peq/</pasta_vendap>";
print "</imobiliaria>\n\r";


while ($not = mysql_fetch_assoc($rs)) {
   $conteudo .= "<imovel>\r";
   # Verifica se o imóvel foi removido do site ou se o período de cadastro dele
   # expirou.

   /**
   # Verifica e caso a data do contrato esteja fora, automaticamente tira o
   #imovel da lista de visualizacao.
   if ($not[disponibilizar] <> "1" || $not[data_fim] < date("Y-m-d")) {
      $not[disponibilizar] = 0;
   }
   /**/

   if ($apagar == 1 || $remover == 1) {
      $conteudo .= "<apagar>SIM</apagar>\r";
   } else {
      $conteudo .= "<apagar/>\r";
   }

   if ($imagens == 1) {
      $conteudo .= "<m_imagens>SIM</m_imagens>\r";
   } else {
      $conteudo .= "<m_imagens/>\r";
   }

   $conteudo .= "<cod>".padrao($not[cod])."</cod>\r";
   $conteudo .= "<cod_imobiliaria>".padrao($not[cod_imobiliaria])."</cod_imobiliaria>\r";
   $conteudo .= "<finalidade>".padrao($not[finalidade])."</finalidade>\r";
   $conteudo .= "<tipo>".padrao($not[tipo])."</tipo>\r";

   if ($apagar == 1) {
      $conteudo .= "<ref>".padrao($not1[a_ref])."</ref>\r";
   } else {
      $conteudo .= "<ref>".padrao($not[ref])."</ref>\r";
   }
   $conteudo .= "<valor>".padrao($not[valor])."</valor>\r";
   $conteudo .= "<tipo_logradouro>".padrao($not[tipo_logradouro])."</tipo_logradouro>\r";
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
   $conteudo .= "<caracteristica>".padrao($not[caracteristica])."</caracteristica>\r";
   $conteudo .= "<data_inicio>".padrao($not[data_inicio])."</data_inicio>\r";
   $conteudo .= "<data_fim>".padrao($not[data_fim])."</data_fim>\r";


   if ($imagens == 1) {
      $venda = "../imobiliarias/".$nome_pasta."/venda/";
      $vendap = "../imobiliarias/".$nome_pasta."/venda_peq/";
      $loca = "../imobiliarias/".$nome_pasta."/locacao/";
      $locap = "../imobiliarias/".$nome_pasta."/locacao_peq/";
      if ($not[finalidade] <= 7) {
         $pasta = $venda;
         $pastap = $vendap;
      } else {
   	   $pasta = $loca;
         $pastap = $locap;
      }
      $abre = opendir($pasta);

      $i = 'n';
      $j = 0;
      while ($imagem = readdir($abre)) {
          if (strpos("--".$imagem, "-".$not[ref]."_") && $j < $max_img) {
//             echo "<caminho>".$pasta.$imagem . " - " . $not[ref] . "</caminho>\r";

            $j++;
            $imgp = str_replace(".jpg","_peq.jpg",$imagem);
            $conteudo .= "<imagem>\r";
            $conteudo .= "<img_nome>".padrao($imagem)."</img_nome>\r";

            /* =============================
            INICIO GERAR IMAGEM NO PADRÃO
            ============================= */
         	//Tamanho máximo da imagem
            $larg_max = 379;

   		   $thumb_local = "images/";
   		   $thumb_salvo = "temp.jpg";

            $original = $pasta.$imagem;
   			$destino = $thumb_local.$thumb_salvo;

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
            /* =============================
              FIM GERAR IMAGEM NO PADRÃO
            ============================= */

            $conteudo .= "<img_arquivo>";

            $source_file = $destino;
            $p_file = $pastap.$imgp;

            $handle = fopen($source_file,'rb');
            $file_content = fread($handle,filesize($source_file));
   			fclose($handle);
   			$encoded = chunk_split(base64_encode($file_content));

            $conteudo .= $encoded;
            $conteudo .= "</img_arquivo>\r";

            $conteudo .= "</imagem>\r";

          }
      }
   }
   $conteudo .= "</imovel>\n\r";
}

print $conteudo;
print "</muraski>\r";

?>
