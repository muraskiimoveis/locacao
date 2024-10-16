<?php
/* ARQUIVO OK. IMPORTA COPIANDO TODAS AS IMAGENS PRO DIRETÓRIO DEFINIDO. */
set_time_limit(0);
session_start();
/*Estancio o arquivo xml na variável $xml que será um objeto contendo o arquivo */

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

if (is_numeric($_GET[f])) {
   $f = $_GET[f];
} else {
   $f = 0;
}

$t = $f + 100;

include "conect.php";

$enviar = $_POST['enviar'];

echo "Inicio da execução: ".date("d/m/Y - H:i:s")."<BR><BR>";

if ($enviar == 1) {

   unset($_SESSION[inicio_backup]);
   $_SESSION[inicio_backup] = date("Y-m-d H:i:s");

   mysql_query("DELETE FROM muraski2 WHERE cod_imobiliaria = '3'") or die ("Erro 13 - ".mysql_error());


/*
   ## INICIO LIMPEZA DOS DIRETORIOS PARA GRAVAR O ARQUIVO NOVO!
   $loca = "../imobiliarias/murask2/locacao";
   if($abre = @opendir($loca)) {
      while (false !== ($arquivo = readdir($abre))) {
         @unlink("$loca/$arquivo");
      }
      @closedir($loca);
   }

   $locap = "../imobiliarias/murask2/locacao_peq";
   if($abre = @opendir($locap)) {
      while (false !== ($arquivo = readdir($abre))) {
         @unlink("$locap/$arquivo");
      }
      @closedir($locap);
   }

   $venda = "../imobiliarias/murask2/venda";
   if($abre = @opendir($venda)) {
      while (false !== ($arquivo = readdir($abre))) {
         @unlink("$venda/$arquivo");
      }
      @closedir($loca);
   }

   $vendap = "../imobiliarias/murask2/venda_peq";
   if($abre = @opendir($vendap)) {
      while (false !== ($arquivo = readdir($abre))) {
         @unlink("$vendap/$arquivo");
      }
      @closedir($locap);
   }
   ### FINAL DA LIMPEZA DOS DIRETORIOS PARA GRAVAR O ARQUIVO NOVO.
*/
   $f = "0";
}

if ($enviar == "" && $f == "") {

?>
<div style='border:solid 1px #CCC; margin:50px;padding:10px'>
   <h1 style='text-align:center'>Importação de dados para o banco de dados</h1>
   <p style='text-align:center'>
      <b>Aviso</b><BR />
      Este é um processo que limpa e atualiza todo o banco de dados.<BR />
      Em caso de falha, a atualização deve ser refeita a partir do começo.<BR />
      A inobservância dessa regra causará falhas no site e no sistema da Rede Brasileira de Imobiliárias.
   </p>

   <center>
   <form action="<?=$_SERVER[PHP_SELF]?>" method="POST" name="form1">
      <input type="hidden" name="enviar" value="1" />
      <input type="submit" name="B1" value="Iniciar" />
   </form>
   </center>
</div>
<?

} else {

   //Abre diretório.
   $diretorio = "../xml_completo/";
   $full_xml = opendir($diretorio);
   $k = 0;
   while ($arquivo = readdir($full_xml)) {
      $k++;
      if ($k > $f and $k <= $t) {
      if (strpos($arquivo, ".xml")) {
         $total[] = $arquivo;

//         echo $arquivo."<BR>";
         $xml = simplexml_load_file($diretorio.$arquivo);

         $i = 0;
         $imobiliaria = $xml -> imobiliaria;
         $im_nome = $imobiliaria -> im_nome;
         $im_pasta = $imobiliaria -> im_pasta;

         $registros = $imobiliaria -> registros;

         foreach ($xml -> imovel as $imovel) {
            $i++;
            $cod = utf8_decode($imovel -> cod);
            $cod_imobiliaria = utf8_decode($imovel -> cod_imobiliaria);
            $finalidade = utf8_decode($imovel -> finalidade);
            $tipo = utf8_decode($imovel -> tipo);
            $ref = utf8_decode($imovel -> ref);
            $valor = utf8_decode($imovel -> valor);
            $end = utf8_decode($imovel -> end);
            $numero = utf8_decode($imovel -> numero);
            $local = utf8_decode($imovel -> local);
            $uf = utf8_decode($imovel -> uf);
            $bairro = utf8_decode($imovel -> bairro);
            $titulo = utf8_decode($imovel -> titulo);
            $descricao = addslashes(utf8_decode($imovel -> descricao));
            $permuta = utf8_decode($imovel -> permuta);
            $permuta_txt = utf8_decode($imovel -> permuta_txt);
            $metragem = utf8_decode($imovel -> metragem);
            $n_quartos = utf8_decode($imovel -> n_quartos);
            $suites = utf8_decode($imovel -> suites);
            $disponibilizar = utf8_decode($imovel -> disponibilizar);
            $dist_mar = utf8_decode($imovel -> dist_mar);
            $dist_tipo = utf8_decode($imovel -> quadras);
            $disp_rede = utf8_decode($imovel -> disp_rede);
            $comissao_parceria = utf8_decode($imovel -> comissao_parceria);
            $destaque = utf8_decode($imovel -> destaque);
            $coordenadas = utf8_decode($imovel -> coordenadas);
            $imagens = $imovel -> imagem;

            $sql = "INSERT INTO muraski2 (cod_imobiliaria, finalidade, tipo, ref, valor, end, numero,
               local, uf, bairro, titulo, descricao, permuta, permuta_txt, metragem, n_quartos,
               suites, dist_mar, dist_tipo, disp_rede, comissao_parceria, destaque, coordenadas,
               disponibilizar)
               VALUES ('$cod_imobiliaria', '$finalidade', '$tipo', '$ref', '$valor', '$end',
               '$numero', '$local', '$uf', '$bairro', '$titulo', '$descricao', '$permuta',
               '$permuta_txt', '$metragem', '$n_quartos', '$suites', '$dist_mar', '$dist_tipo',
               '$disp_rede', '$comissao_parceria', '$destaque', '$coordenadas', '$disponibilizar')";

            echo count($total)." - Arquivo: ".$arquivo."<BR><textarea rows=10 cols=80>".$sql."</textarea><BR><BR>";

            mysql_query($sql) or die ("Erro 177 - " . mysql_error());

         }

         $conta = count($total);

         // Grava um registro de atualização completa no sistema.
         $sql_ok = "INSERT INTO atualiza_imoveis (a_imobiliaria, a_inicio, a_final, a_registros, a_total) VALUES
            ('$cod_imobiliaria', '".$_SESSION[inicio_backup]."', '".date("Y-m-d H:s:i")."', '$conta', '$conta')";

         print "</div>";

         }
      }
   }

   echo "<BR>".$conta." Arquivos<BR><a href='ler_xml.php?f=".($i+$f)."'>Continuar</a>";
   echo "Final da execução: ".date("d/m/Y - H:i:s")."<BR><BR>";

//         echo "<script>window.location.href='ler_xml.php?f=".($i+$f)."';</script>";

}

?>