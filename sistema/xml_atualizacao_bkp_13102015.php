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
include("p_fotos.php");

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

//$site = "http://201.15.46.77/intranet/";
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
//$d = mktime(15,30,00,05,04,2009);

$nome_pasta = $_GET[nome_pasta];
if ($nome_pasta == "") {
   $nome_pasta = "murask";
}
$cod_imobiliaria = $_GET[cod_imobiliaria];
if ($cod_imobiliaria == "") {
   $cod_imobiliaria = "3";
}

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
   #Conta quantas referências são.
   $c_sql = "SELECT a_ref FROM atualizacoes WHERE ((a_data = '" . date("Y-m-d",$d) . "' AND a_hora >= '" . date("H:i:s",$d) . "') or (a_data > '" . date("Y-m-d",$d) . "')) AND a_ref <> '' and cod_imobiliaria = '$cod_imobiliaria' GROUP BY a_ref";
   $crs = mysql_query($c_sql) or die ("Erro 111 - " . mysql_error());
   $quantos = mysql_num_rows($crs);

   #Seleciona a referência específica.
   $sql0 = "SELECT a_ref FROM atualizacoes WHERE ((a_data = '".date("Y-m-d",$d)."' AND a_hora >= '".date("H:i:s",$d)."') or (a_data > '".date("Y-m-d",$d)."')) AND a_ref <> '' and cod_imobiliaria = '$cod_imobiliaria' GROUP BY a_ref ORDER BY a_ref ASC LIMIT ".$f.",1";
   $rs0 = mysql_query($sql0) or die ("Erro 115 - " . mysql_error());
   $not0 = mysql_fetch_assoc($rs0);

   #Recebe a ultima atualização feita no arquivo (adicionada para diferenciar arquivos apagados)
   $sql1 = "SELECT a_ref, a_acao, a_id FROM atualizacoes WHERE a_ref = '".$not0[a_ref]."'  and cod_imobiliaria = '$cod_imobiliaria' ORDER BY a_id DESC LIMIT 1";
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
      a_acao = 'Inserir Imóvel')  and cod_imobiliaria = '$cod_imobiliaria' ORDER BY a_id DESC LIMIT 1";
   $rs2 = mysql_query($sql2) or die ("Erro 134 - " . mysql_error());
   if (mysql_num_rows($rs2) > 0) {
      $imagens = 1;
   } else {
      $imagens = "";
   }

   if ($_GET[refc] == "") {
      if ($apagar == "") {
         $sql = "SELECT * FROM muraski WHERE cod_imobiliaria = '".$cod_imobiliaria."' and ref = '".$not1['a_ref']."' LIMIT 1";
      } else {
         $sql = "SELECT * FROM muraski WHERE cod_imobiliaria = '".$cod_imobiliaria."' and cod = '".$not1['a_id']."' LIMIT 1";
      }
   }

   $rs = mysql_query($sql) or die ("Erro 26 - ".mysql_error());

   print "<imobiliaria>\r";
   print "<registros>".$quantos."</registros>";
   print "<im_nome>Muraski</im_nome>";
   print "<im_pasta>".$nome_pasta."</im_pasta>";
   print "</imobiliaria>\n\r";

#   echo "<total>".mysql_num_rows($rs)."</total>";

   while ($not = mysql_fetch_assoc($rs)) {

#      echo "<tst>";
#      print_r ($not);
#      echo "</tst>";
#      echo "</muraski>";

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

      $conteudo .= "<cod>".padrao($not['cod'])."</cod>\r";
      $conteudo .= "<cod_imobiliaria>".padrao($not['cod_imobiliaria'])."</cod_imobiliaria>\r";
      if ($apagar == 1) {
         $conteudo .= "<ref>".padrao($not1[a_ref])."</ref>\r";
      } else {
         $conteudo .= "<ref>".padrao($not[ref])."</ref>\r";
      }
      $conteudo .= "<tipo>".padrao($not['tipo'])."</tipo>\r";
      $conteudo .= "<tipo_secundario>".padrao($not['tipo_secundario'])."</tipo_secundario>\r";
      $conteudo .= "<metragem>".padrao($not['metragem'])."</metragem>\r";
      $conteudo .= "<area_averbada>".padrao($not['area_averbada'])."</area_averbada>\r";
      $conteudo .= "<area_terreno>".padrao($not['area_terreno'])."</area_terreno>\r";
      $conteudo .= "<matricula_luz>".padrao($not['matricula_luz'])."</matricula_luz>\r";
      $conteudo .= "<situacao_luz>".padrao($not['situacao_luz'])."</situacao_luz>\r";
      $conteudo .= "<matricula_agua>".padrao($not['matricula_agua'])."</matricula_agua>\r";
      $conteudo .= "<situacao_agua>".padrao($not['situacao_agua'])."</situacao_agua>\r";
      $conteudo .= "<n_quartos>".padrao($not['n_quartos'])."</n_quartos>\r";
      $conteudo .= "<valor>".padrao($not['valor'])."</valor>\r";
      $conteudo .= "<especificacao>".padrao($not['especificacao'])."</especificacao>\r";
      $conteudo .= "<suites>".padrao($not['suites'])."</suites>\r";
      $conteudo .= "<caracteristica>".padrao($not['caracteristica'])."</caracteristica>\r";
      $conteudo .= "<piscina>".padrao($not['piscina'])."</piscina>\r";
      $conteudo .= "<titulo>".padrao($not['titulo'])."</titulo>\r";
      $conteudo .= "<descricao>".padrao($not['descricao'])."</descricao>\r";
      $conteudo .= "<img_peq>".padrao($not['img_peq'])."</img_peq>\r";
      $conteudo .= "<img_1>".padrao($not['img_1'])."</img_1>\r";
      $conteudo .= "<img_2>".padrao($not['img_2'])."</img_2>\r";
      $conteudo .= "<img_3>".padrao($not['img_3'])."</img_3>\r";
      $conteudo .= "<img_4>".padrao($not['img_4'])."</img_4>\r";
      $conteudo .= "<img_5>".padrao($not['img_5'])."</img_5>\r";
      $conteudo .= "<img_6>".padrao($not['img_6'])."</img_6>\r";
      $conteudo .= "<img_7>".padrao($not['img_7'])."</img_7>\r";
      $conteudo .= "<img_8>".padrao($not['img_8'])."</img_8>\r";
      $conteudo .= "<img_9>".padrao($not['img_9'])."</img_9>\r";
      $conteudo .= "<img_10>".padrao($not['img_10'])."</img_10>\r";
      $conteudo .= "<uf>".padrao($not['uf'])."</uf>\r";
      $conteudo .= "<local>".padrao($not['local'])."</local>\r";
      $conteudo .= "<permuta>".padrao($not['permuta'])."</permuta>\r";
      $conteudo .= "<finalidade>".padrao($not['finalidade'])."</finalidade>\r";
      $conteudo .= "<permuta_txt>".padrao($not['permuta_txt'])."</permuta_txt>\r";
      $conteudo .= "<ftxt_1>".padrao($not['ftxt_1'])."</ftxt_1>\r";
      $conteudo .= "<ftxt_2>".padrao($not['ftxt_2'])."</ftxt_2>\r";
      $conteudo .= "<ftxt_3>".padrao($not['ftxt_3'])."</ftxt_3>\r";
      $conteudo .= "<ftxt_4>".padrao($not['ftxt_4'])."</ftxt_4>\r";
      $conteudo .= "<ftxt_5>".padrao($not['ftxt_5'])."</ftxt_5>\r";
      $conteudo .= "<ftxt_6>".padrao($not['ftxt_6'])."</ftxt_6>\r";
      $conteudo .= "<ftxt_7>".padrao($not['ftxt_7'])."</ftxt_7>\r";
      $conteudo .= "<ftxt_8>".padrao($not['ftxt_8'])."</ftxt_8>\r";
      $conteudo .= "<ftxt_9>".padrao($not['ftxt_9'])."</ftxt_9>\r";
      $conteudo .= "<ftxt_10>".padrao($not['ftxt_10'])."</ftxt_10>\r";
      $conteudo .= "<ftxt_11>".padrao($not['ftxt_11'])."</ftxt_11>\r";
      $conteudo .= "<ftxt_12>".padrao($not['ftxt_12'])."</ftxt_12>\r";
      $conteudo .= "<ftxt_13>".padrao($not['ftxt_13'])."</ftxt_13>\r";
      $conteudo .= "<ftxt_14>".padrao($not['ftxt_14'])."</ftxt_14>\r";
      $conteudo .= "<ftxt_15>".padrao($not['ftxt_15'])."</ftxt_15>\r";
      $conteudo .= "<ftxt_16>".padrao($not['ftxt_16'])."</ftxt_16>\r";
      $conteudo .= "<ftxt_17>".padrao($not['ftxt_17'])."</ftxt_17>\r";
      $conteudo .= "<ftxt_18>".padrao($not['ftxt_18'])."</ftxt_18>\r";
      $conteudo .= "<ftxt_19>".padrao($not['ftxt_19'])."</ftxt_19>\r";
      $conteudo .= "<ftxt_20>".padrao($not['ftxt_20'])."</ftxt_20>\r";
      $conteudo .= "<cliente>".padrao($not['cliente'])."</cliente>\r";
      $conteudo .= "<percentual_prop>".padrao($not['percentual_prop'])."</percentual_prop>\r";
      $conteudo .= "<matricula>".padrao($not['matricula'])."</matricula>\r";
      $conteudo .= "<cidade_mat>".padrao($not['cidade_mat'])."</cidade_mat>\r";
      $conteudo .= "<bairro>".padrao($not['bairro'])."</bairro>\r";
      $conteudo .= "<tipo_logradouro>".padrao($not['tipo_logradouro'])."</tipo_logradouro>\r";
      $conteudo .= "<end>".padrao($not['end'])."</end>\r";
      $conteudo .= "<numero>".padrao($not['numero'])."</numero>\r";
      $conteudo .= "<cep>".padrao($not['cep'])."</cep>\r";
      $conteudo .= "<averbacao>".padrao($not['averbacao'])."</averbacao>\r";
      $conteudo .= "<acomod>".padrao($not['acomod'])."</acomod>\r";
      $conteudo .= "<dist_mar>".padrao($not['dist_mar'])."</dist_mar>\r";
      $conteudo .= "<dist_tipo>".padrao($not['dist_tipo'])."</dist_tipo>\r";
      $conteudo .= "<limpeza>".padrao($not['limpeza'])."</limpeza>\r";
      $conteudo .= "<diaria1>".padrao($not['diaria1'])."</diaria1>\r";
      $conteudo .= "<diaria2>".padrao($not['diaria2'])."</diaria2>\r";
      $conteudo .= "<data_inicio>".padrao($not['data_inicio'])."</data_inicio>\r";
      $conteudo .= "<data_fim>".padrao($not['data_fim'])."</data_fim>\r";
      $conteudo .= "<comissao>".padrao($not['comissao'])."</comissao>\r";
      $conteudo .= "<dias>".padrao($not['dias'])."</dias>\r";
      $conteudo .= "<contrato>".padrao($not['contrato'])."</contrato>\r";
      $conteudo .= "<carnaval>".padrao($not['carnaval'])."</carnaval>\r";
      $conteudo .= "<anonovo>".padrao($not['anonovo'])."</anonovo>\r";
      $conteudo .= "<coordenadas>".padrao($not['coordenadas'])."</coordenadas>\r";
      $conteudo .= "<posx>".padrao($not['posx'])."</posx>\r";
      $conteudo .= "<posy>".padrao($not['posy'])."</posy>\r";
      $conteudo .= "<tv>".padrao($not['tv'])."</tv>\r";
      $conteudo .= "<angariador>".padrao($not['angariador'])."</angariador>\r";
      $conteudo .= "<zelador>".padrao($not['zelador'])."</zelador>\r";
      $conteudo .= "<tipo_anga>".padrao($not['tipo_anga'])."</tipo_anga>\r";
      $conteudo .= "<indicador>".padrao($not['indicador'])."</indicador>\r";
      $conteudo .= "<comissao_indicador>".padrao($not['comissao_indicador'])."</comissao_indicador>\r";
      $conteudo .= "<comissao_vendedor>".padrao($not['comissao_vendedor'])."</comissao_vendedor>\r";
      $conteudo .= "<diarista>".padrao($not['diarista'])."</diarista>\r";
      $conteudo .= "<comissao_diarista>".padrao($not['comissao_diarista'])."</comissao_diarista>\r";
      $conteudo .= "<piscineiro>".padrao($not['piscineiro'])."</piscineiro>\r";
      $conteudo .= "<comissao_piscineiro>".padrao($not['comissao_piscineiro'])."</comissao_piscineiro>\r";
      $conteudo .= "<eletricista>".padrao($not['eletricista'])."</eletricista>\r";
      $conteudo .= "<comissao_eletricista>".padrao($not['comissao_eletricista'])."</comissao_eletricista>\r";
      $conteudo .= "<encanador>".padrao($not['encanador'])."</encanador>\r";
      $conteudo .= "<comissao_encanador>".padrao($not['comissao_encanador'])."</comissao_encanador>\r";
      $conteudo .= "<jardineiro>".padrao($not['jardineiro'])."</jardineiro>\r";
      $conteudo .= "<comissao_jardineiro>".padrao($not['comissao_jardineiro'])."</comissao_jardineiro>\r";
      $conteudo .= "<chaves>".padrao($not['chaves'])."</chaves>\r";
      $conteudo .= "<controle_chave>".padrao($not['controle_chave'])."</controle_chave>\r";
      $conteudo .= "<tipo_div>".padrao($not['tipo_div'])."</tipo_div>\r";
      $conteudo .= "<valor_oferta>".padrao($not['valor_oferta'])."</valor_oferta>\r";
      $conteudo .= "<relacao_bens>".padrao($not['relacao_bens'])."</relacao_bens>\r";
      $conteudo .= "<observacoes>".padrao($not['observacoes'])."</observacoes>\r";
      $conteudo .= "<disponibilizar>".padrao($not['disponibilizar'])."</disponibilizar>\r";
      $conteudo .= "<disp_rede>".padrao($not['disp_rede'])."</disp_rede>\r";
      $conteudo .= "<destaque>".padrao($not['destaque'])."</destaque>\r";
      $conteudo .= "<destaque_padrao>".padrao($not['destaque_padrao'])."</destaque_padrao>\r";
      $conteudo .= "<lancamento>".padrao($not['lancamento'])."</lancamento>\r";
      $conteudo .= "<comissao_parceria>".padrao($not['comissao_parceria'])."</comissao_parceria>\r";
      $conteudo .= "<contador>".padrao($not['contador'])."</contador>\r";
      $conteudo .= "<status>".padrao($not['status'])."</status>\r";
      $conteudo .= "<construtora>".padrao($not['construtora'])."</construtora>\r";
      $conteudo .= "<idade_imovel>".padrao($not['idade_imovel'])."</idade_imovel>\r";
      $conteudo .= "<condominio>".padrao($not['condominio'])."</condominio>\r";
      $conteudo .= "<apto>".padrao($not['apto'])."</apto>\r";
      $conteudo .= "<end_igual>".padrao($not['end_igual'])."</end_igual>\r";
      $conteudo .= "<end_aproximado>".padrao($not['end_aproximado'])."</end_aproximado>\r";
      $conteudo .= "<tipo_logradouro_mapa>".padrao($not['tipo_logradouro_mapa'])."</tipo_logradouro_mapa>\r";
      $conteudo .= "<end_mapa>".padrao($not['end_mapa'])."</end_mapa>\r";
      $conteudo .= "<numero_mapa>".padrao($not['numero_mapa'])."</numero_mapa>\r";
      $conteudo .= "<cep_mapa>".padrao($not['cep_mapa'])."</cep_mapa>\r";
      $conteudo .= "<video>".padrao($not['video'])."</video>\r";
      $conteudo .= "<origem_video>".padrao($not['origem_video'])."</origem_video>\r";
      $conteudo .= "<endereco_contrato>".padrao($not['endereco_contrato'])."</endereco_contrato>\r";
      $conteudo .= "<exibir_endereco>".padrao($not['exibir_endereco'])."</exibir_endereco>\r";
      $conteudo .= "<observacoes2>".padrao($not['observacoes2'])."</observacoes2>\r";
      $conteudo .= "<observacoes3>".padrao($not['observacoes3'])."</observacoes3>\r";
      $conteudo .= "<ncoordenadas>".padrao($not['ncoordenadas'])."</ncoordenadas>\r";
      $conteudo .= "<calendario>".padrao($not['calendario'])."</calendario>\r";
      $conteudo .= "<m_visualizado>".padrao($not['m_visualizado'])."</m_visualizado>\r";
      $conteudo .= "<m_add_lista>".padrao($not['m_add_lista'])."</m_add_lista>\r";

#teste. =: imprime o valor da variável até aqui e zera ela.

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
      echo $conteudo;
      $conteudo = "";

	//while ($imagem = readdir($abre)) {
	while (false !== ($imagem = readdir($abre))){
		
		// Verifica se a foto vai pro site ou não //
		$thumb_local = "images/";
		$thumb_salvo = "temp.jpg";
		$destino = $thumb_local.$thumb_salvo;
	
		if (strpos("--".$imagem, "-".$not[ref]."_") && $j < $max_img ) {

			//if (strpos("--".$imagem, "-".$not[ref]."_") && $j < $max_img ) {

			//echo "<caminho>".$pasta.$imagem . " - " . $not[ref] . "</caminho>\r";

			$nseq = str_replace(".","",str_replace("_","",(substr(padrao($imagem),strpos(padrao($imagem),"_"),3))));
		
			$vai_pro_site = VerificaFotoNoSite($not[ref],$nseq,$not[cod]);
			if(!$vai_pro_site){
				//Apaga imagem anterior, se tiver.
				//echo "<caminho>".$not[ref]." ==  ".$not[cod]." == ".$nseq."</caminho>\r";
				
				if (file_exists($destino)) {
					unlink($destino);
				}
			}else{
			
				$j++;
				$imgp = str_replace(".jpg","_peq.jpg",$imagem);
				$conteudo .= "<imagem>\r";
				$conteudo .= "<img_nome>".padrao($imagem)."</img_nome>\r";

				/* =============================
				INICIO GERAR IMAGEM NO PADRÃO
				============================= */
				//Tamanho máximo da imagem
				$larg_max = 400;
				$alt_max = 300;

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

				//calcula a razão dos tamanhos, em comparação aos máximos.
				$r_largura = $Img_w / $larg_max;
				$r_altura = $Img_h / $alt_max;

				//Verifica se a imagem estoura o limite em altura ou largura
				if ($r_largura > 1 || $r_altura > 1) {
					if ($r_altura > $r_largura) {
						$d_altura = $Img_h / $alt_max;
						$largura = ceil($Img_w / $d_altura);
					} else {
						$largura = $larg_max;
					}
				} else {
				   $largura = $Img_w;
				}

				//Chama a função que gera a imagem.
				criar_thumbnail($original,$destino,$largura,'','JPEG');
				/* =============================
				FIM GERAR IMAGEM NO PADRÃO
				============================= */

				#echo $conteudo;
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

				echo $conteudo;
				$conteudo = "";
				
			}
		}
	}
	  
   }
   $conteudo .= "</imovel>\n\r";
}

print $conteudo;
print "</muraski>\r";

?>
