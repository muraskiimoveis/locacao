<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("ENV_IMAGEM");
?>
<html>

<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<?
		/* how many upload slots? */ 
		define("UPLOAD_SLOTS", 10); 

?>
<form action="p_envia_img.php" name="form1" enctype="multipart/form-data" method="post">
<table width="400" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td colspan="2" height="30"><p align="center" class="style1"><b>Enviar Imagens</b></p></td>
	</tr>
	<tr>
	  <td colspan="2" height="30" align="center" class="style1">
<?php
if($B1 == "Apagar Imagem") {
	if ($foto != ""){
		$tmp_cod = $_SESSION['cod_imobiliaria'];
		$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod."'");
		$row = mysql_fetch_array($result);
		$tmp_pasta = $row['nome_pasta'];
		$pasta = "../imobiliarias/".$tmp_pasta."/".$tmp_fold."/";
		$pastap = "../imobiliarias/".$tmp_pasta."/".$tmp_fold."_peq/";
		
		$foto_peq = str_replace(".jpg","_peq.jpg","$foto");
		if (file_exists($pasta . $foto)) {
			unlink($pasta . $foto);
		}
		if (file_exists($pastap . $foto_peq)) {
			unlink($pastap . $foto_peq);
		}
		
		?>
		<p align="center" class=style7>
		<b>Você apagou o arquivo: <i><?php print("$foto"); ?></i>.</b></p>
		<?php
	} else {
		?>
		<p align="center" class=style7>
		<b>O arquivo <i><?php print("$foto"); ?></i> não existe.</b></p>
		<?php
	}
}
?>	  </td>
	</tr>	
<?	if($REQUEST_METHOD!="POST") { ?>
	<tr>
	  <td colspan="2" class="style1" align="center"><span class="style7">Favor selecionar a finalidade antes de inserir a imagem se for &quot;Vendas&quot; selecionar a finalidade &quot;Venda&quot;, se for &quot;Loca&ccedil;&atilde;o Mensal&quot; ou &quot;Loca&ccedil;&atilde;o Di&aacute;ria&quot; selecionar a finalidade &quot;Loca&ccedil;&atilde;o&quot;</span></td>
    </tr>
	<tr>
	  <td colspan="2" class="style1" align="center">Selecione a finalidade do imóvel:&nbsp;&nbsp;&nbsp;<select name="finalidade" class=campo>
		 <?
            /*$tmp_query = mysql_query("SELECT * FROM muraski WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
 			while($linha = mysql_fetch_array($tmp_query)){
				if($linha['cod']==$u_cod){
					echo('<option value="'.$linha['u_cod'].'" SELECTED>'.$linha['ref'].'</option>');
				}else{ 			   
					echo('<option value="'.$linha['cod'].'">'.$linha['ref'].'</option>');
				}
 			}*/
		?>
			
			<option value="Venda">Venda</option>
			<option value="Locacao">Locação</option>
        </select></td>
	</tr>
	<tr>
	  <td colspan="2" class="style1" align="left">
		<b>Observações:</b><br>
		- O tamanho maximo das fotos grandes é de 400x300pixels. Imagens maiores serão redimensionadas.<br>
		- Utilize a referencia do imóvel no nome do arquivo da imagem, seguido de "_" e do numero da foto.<br><br>
		Ex.: Para um imóvel com a referencia "test77", o nome da primeira foto será: teste77_1.jpg<br>&nbsp;	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
		<?php 
			/* generate form */ 
			for($i=1; $i<=UPLOAD_SLOTS; $i++) { 
				echo "<input type=file class=campo name=infile$i><br>\n"; 
			} 
		?>	  </td>
	</tr>
	<tr>
	  <td align="right" colspan="2"><input type="submit" value="Enviar Arquivo" class="campo3"></td>
	</tr>
<? 		} else {
?>
	<tr>
	  <td>
<?
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
			
			$finalidade = $_POST['finalidade'];
			
			$tmp_cod = $_SESSION['cod_imobiliaria'];
			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod."'");
			$row = mysql_fetch_array($result);
			$pasta = $row['nome_pasta'];
			
			if ($finalidade == "Venda") {
				/* where to move the uploaded file(s) to? */ 
				define("INCOMING", "../imobiliarias/".$pasta."/venda/");
				define("INCOMING2", "../imobiliarias/".$pasta."/venda_peq/");
			} else {
				define("INCOMING", "../imobiliarias/".$pasta."/locacao/");
				define("INCOMING2", "../imobiliarias/".$pasta."/locacao_peq/");
			}

			//Tamanho máximo da imagem grande
			$larg_max = 400;
			$alt_max = 300;
			
			//Tamanho máximo da imagem pequena
			$largp_max = 133;
			$altp_max = 100;
			
			/* handle uploads */ 
			$noinput = true; 
			for($i=1; $noinput && ($i<=UPLOAD_SLOTS); $i++) { 
				if(${"infile".$i}!="none") $noinput=false; 
			} 
			if($noinput) { 
				echo "error uploading. create 150MB coredump instead?"; 
				exit(); 
			} 
			
			$result2 = mysql_query("SELECT d_qtd FROM rebri_destaques WHERE d_tipo='Fotos'");
			$row2 = mysql_fetch_array($result2);
			$quantidade = $row2['d_qtd'];
		
			for($i=1; $i<= UPLOAD_SLOTS; $i++) { 
				if(${"infile".$i}) { 
		
					$file = strtolower(${"infile".$i."_name"});
					
					
					$foto = ${file};
					$fotos = explode("_",$foto);
					$referencia = $fotos[0];
					
					$tmp_cod2 = $_SESSION['cod_imobiliaria'];
					$result33 = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod2."'");
					$row33 = mysql_fetch_array($result33);
						$tmp_pasta33 = $row33['nome_pasta'];
						$pasta1 = "../imobiliarias/".$tmp_pasta33."/venda/";
						$pastap1 = "../imobiliarias/".$tmp_pasta33;
						$pasta20 = "../imobiliarias/".$tmp_pasta33."/locacao/";
						$pastap20 = "../imobiliarias/".$tmp_pasta33;
					

					$strDiretorio1 = $pasta1; // pasta das imagens
					$strDiretorio20 = $pasta20; // pasta das imagens
					$strDiretorioAbrir1 = opendir($strDiretorio1);
					$strDiretorioAbrir20 = opendir($strDiretorio20);


					$i2 = 1;
					$m2 = 1;
					$arquivos1 = array();


					$referencia = trim($referencia);
					$tm1 = strlen($referencia);

					while(false !== ($strArquivos1 = readdir($strDiretorioAbrir1))) {
			 			if($strArquivos1 != "." && $strArquivos1 != "..")
			 			{	
			 	  			$arq1[$i2] = substr($strArquivos1,0,$tm1);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "venda";
			 	 			$i2++;
			 			}
					}
					while(false !== ($strArquivos1 = readdir($strDiretorioAbrir20))) {
			 			if($strArquivos1 != "." && $strArquivos1 != "..")
			 			{		
			 	  			$arq1[$i2] = substr($strArquivos1,0,$tm);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos1);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "locacao";
			 	 			$i2++;
			 			}
					}

					for($i2 = 1 ; $i2 <= count($arq20) ; $i2++)
					{
						if(!empty($arq20[$i2]))
						{
							if((strpos($str1[$i2],'@') == true) OR (strtolower($arq1[$i2]) == strtolower($referencia)))
							{
						 	 	$arquivos1[$i2] = $arq20[$i2];
							 	$fold_arquivos1[$i2] = $arqF1[$i2];
						 	 	$m2++;
						 	 
							}
						}
					}
					
					
					if($m2 <= $quantidade){
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
					
						echo "<center><span class=\"style1\">O arquivo <b>". ${"infile".$i."_name"}." </b>foi enviado com sucesso.</span></center><br><br>"; 
					
					}else{
										  
						echo "<center><span class=\"style7\">O arquivo <b>". ${"infile".$i."_name"}." </b>não pode ser enviado pois já atingiu o limite máximo ($quantidade) de fotos por imóvel.</span></center><br><br>";   
					}
				}
			}
			echo '<center><br><br><a href="javascript:history.back()" class=style1><< Voltar <<</a></center>';
?>	  </td>
	</tr>
<?
		} /* else */ 
?>
</table>
</form><br>
<br>

				<form method="post" action="p_envia_img.php" name="form1">
				<table border="0" align="center" valign="top" cellspacing="3" width="500">
				<tr>
				<td colspan="2" bgcolor="#<?php print("$cor3"); ?>">Pesquisar Imagem:</b></td>
				</tr>
				<tr bgcolor="#ffffff">
				<td width="30%">Palavra chave:</td>
				<td width="70%">
				<input type="text" size="30" name="chave" class=campo></td>
				</tr>
				<tr bgcolor="#ffffff">
				<td colspan="2" bgcolor="#<?php print("$cor3"); ?>" align="right">
				<input type="submit" value="Pesquisar Imagem" name="button1" class=campo3></td>
				</tr>
				</table>
				</form>


<table width=500 align="center">
<?php
$tmp_cod = $_SESSION['cod_imobiliaria'];
$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod."'");
$row = mysql_fetch_array($result);
$tmp_pasta = $row['nome_pasta'];
$pasta = "../imobiliarias/".$tmp_pasta."/venda/";
$pastap = "../imobiliarias/".$tmp_pasta;
$pasta2 = "../imobiliarias/".$tmp_pasta."/locacao/";
$pastap2 = "../imobiliarias/".$tmp_pasta;

$strDiretorio = $pasta; // pasta das imagens
$strDiretorio2 = $pasta2; // pasta das imagens
$strDiretorioAbrir = opendir($strDiretorio);
$strDiretorioAbrir2 = opendir($strDiretorio2);


//echo "<div align=\"center\"><font color=\"#990000\" face=\"tahoma\" size=\"2\"><strong>Listando Imagens JPG e GIF de um diretorio<br><br>Diretório Escolhido: </strong>".$strDiretorio."</font></div><br><br>";

	$i = 0;
	$m = 0;
	$arquivos = array();

if($chave)
{
		$chave = trim($chave);
		$tm = strlen($chave);

		while(false !== ($strArquivos = readdir($strDiretorioAbrir))) {
			 if($strArquivos != "." && $strArquivos != "..")
			 {	
			 	  $arq[$i] = substr($strArquivos,0,$tm);
			 	  $str[$i] = str_replace($chave,'@',$strArquivos);
			 	  $arq2[$i] = $strArquivos;
				  $arqF[$i] = "venda";
			 	  $i++;
			 }
		}
		while(false !== ($strArquivos = readdir($strDiretorioAbrir2))) {
			 if($strArquivos != "." && $strArquivos != "..")
			 {	
			 	  $arq[$i] = substr($strArquivos,0,$tm);
			 	  $str[$i] = str_replace($chave,'@',$strArquivos);
			 	  $arq2[$i] = $strArquivos;
				  $arqF[$i] = "locacao";
			 	  $i++;
			 }
		}
		

		for($i = 0 ; $i <= count($arq2) ; $i++)
		{
				if(!empty($arq2[$i]))
				{
						if((strpos($str[$i],'@') == true) OR (strtolower($arq[$i]) == strtolower($chave)))
						{
						 	 $arquivos[$i] = $arq2[$i];
							 $fold_arquivos[$i] = $arqF[$i];
						 	 $m++;
						}
				}
		}
?>
		<tr>
			<td colspan="4" class=style1>Resultado da Pesquisa por "<b><? echo $chave; ?></b>".</td>
		</tr>
<?			
} else {
		while($strArquivos = readdir($strDiretorioAbrir)) {
			if($strArquivos != "." && $strArquivos != "..") {
				$arquivos[$i] = $strArquivos;
				$fold_arquivos[$i] = "venda";
				$i++;
			}
		}
		while($strArquivos = readdir($strDiretorioAbrir2)) {
			if($strArquivos != "." && $strArquivos != "..") {
				$arquivos[$i] = $strArquivos;
				$fold_arquivos[$i] = "locacao";
				$i++;
			}
		}
}
	@array_multisort($arquivos, $fold_arquivos);
			
	$quant_pag = 6;
 		
	if(!$screen){
	$screen = 1;
	}

	if(!$from){
		$from = intval(($screen - 1) * $quant_pag);
	}
	
	//if($from == 0){
	//	$from = 1;
	//}
		
	$from15 = $from + $quant_pag;
 		
	for ($j = $from; $from < $from15; $j++) {
		$from = $from + 1;
	
	if (in_array($arquivos[$j], $arquivos)) {
		
	if($i > 0){

 	$foto_peq = str_replace(".jpg","_peq.jpg","$arquivos[$j]");
	$extensao = explode(".", $arquivos[$j]);
?>
<tr>
<?php
	if(($extensao[1] == "jpg") or ($extensao[1] == "gif") or ($extensao[1] == "png"))
	{
?>
	<td align=center><img border=0 src="<?php print("$pastap/$fold_arquivos[$j]_peq/$foto_peq"); ?>"></td>
<?php
	}
?>
	<td><?php print("$arquivos[$j]"); ?></td>
	<td><a href="#" onClick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$strArquivos"); ?>\'?')) { window.location='p_envia_img.php?B1=Apagar Imagem&foto=<?php print("$arquivos[$j]"); ?>&tmp_fold=<?=$fold_arquivos[$j]?>'; }">Apagar</a></td>
</tr>
<?php
  
}
}
}
	if($chave != ""){
	$total_img = $m;
	$pages = ceil($m / $quant_pag);
	}
	else
	{
	$total_img = $i;
	$pages = ceil($i / $quant_pag);
	}
?>
                  <tr>
                  	<td colspan="3" bgcolor="<?php print("$cor3"); ?>" class=style1 align=left>
                  	<b>Foram encontradas <?php print("$total_img"); ?> fotos</i></b></td>
                  </tr>
                  <tr>
                  	<td colspan="3" height=1 bgcolor="#<?php print("$cor3"); ?>"></td></tr>
                  <tr>
                  	<td colspan="3" bgcolor="<?php print("$cor3"); ?>" class=style1 align=left>
                  	<b>Páginas: 
<?php
	for ($k = 1; $k <= $pages; $k++) {
  	$url2 = $PHP_SELF . "?screen=" . $k . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem;
  	if($k == $screen){
  	echo " <a href=\"$url2\"><b><font color=#ff0000>$k</b></font></a> ";
	}
  	else
  	{
  	echo " <a href=\"$url2\"><font color=#$cor_fonte>$k</a> ";	
  	}
	}
?>
                  </td>
                  </tr>
                  <tr bgcolor="<?php print("$cor3"); ?>">
                  	<td colspan="2" align=left class=style1><b>
<?php
	if ($from > $quant_pag) {
	$url1 = $PHP_SELF . "?pag=list_prod&screen=" . ($screen - 1) . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem;
?>
                  <a href="<?php print("$url1"); ?>" class=style1><< Página anterior <<</a>
<?php
	}
?>
	</td><td align=right class=style1>
                  <b>
<?php
	if ($from >= $i) {
?>
		  Última página de fotos
<?php
	}
	else
	{
		$url3 = $PHP_SELF . "?pag=list_prod&screen=" . ($screen + 1) . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem;
?>
                  <a href="<?php print("$url3"); ?>" class=style1>>> Próxima Página >></a>
<?php
	}
?>
                  </td>
                  </tr>
</table>
</body>

</html>