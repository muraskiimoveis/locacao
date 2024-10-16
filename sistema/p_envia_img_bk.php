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
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<html>

<head>
<META Http-Equiv="Cache-Control" Content="no-cache">
<META Http-Equiv="Pragma" Content="no-cache">
<META Http-Equiv="Expires" Content="0">

<?php
include("style.php");
?>
<script language="javascript">
function VerificaCampo()
{

var msg = '';

	   if(document.form1.ref.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Referência.\n";
       }
       else
  	   {
    		var er = new RegExp("^[0-9a-z]+$");
    		if(er.test(document.form1.ref.value) == false)
			{
  	    		msg += "Não pode haver espaço nem caractere especial no campo Referência.\n" ;
    		}
  	   }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
			document.form1.submit();
	   }

}

function VerificaCampo2()
{

var msg = '';

	   if(document.form2.chave.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Referência.\n";
       }
       if(document.form2.finalidade2.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Finalidade.\n";
	   }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
			document.form2.submit();
	   }

}

function formOrdem(id){

	if(confirm("Deseja realmente renomear as fotos?")){

   	   document.form3.action='p_envia_img.php?chave=' + id;
	   document.form3.acao.value='1';
   	   document.form3.submit();
	}
}

</script>
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
<form action="p_envia_img.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
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
  
if($_POST['acao']=='1')
{

   		$i = $_POST['cont'];
   		$chave = $_GET['chave'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$ordens = "ordem_".$j;
     		$ordem = $_POST[$ordens];
     		$ordensa = "ordem_antiga_".$j;
     		$ordema = $_POST[$ordensa];
     		$pequenas = "foto_antiga_pequena_".$j;
     		$pequena = $_POST[$pequenas];
     		$grandes = "foto_antiga_grande_".$j;
     		$grande = $_POST[$grandes];
     		$pgrandes = "pasta_grande_".$j;
     		$pgrande = $_POST[$pgrandes];
     		$ppequenas = "pasta_pequena_".$j;
     		$ppequena = $_POST[$ppequenas];

	    	if($ordem)
	    	{
    			$c++;
    			$parte1 = explode(".", $grande);
				$parte2 = $parte1[0];
    			$parte3 = explode("_", $parte2);
    			$nova_foto_grande[$j] = $parte3[0]."_".$ordem.".".$parte1[1]."temp";
    			$nova_foto_grande_atualizada[$j] = $parte3[0]."_".$ordem.".".$parte1[1];
    			
    			$parte10 = explode(".", $pequena);
				$parte20 = $parte10[0];
    			$parte30 = explode("_", $parte20);
    			$nova_foto_pequena[$j] = $parte30[0]."_".$ordem."_peq.".$parte10[1]."temp";
    			$nova_foto_pequena_atualizada[$j] = $parte30[0]."_".$ordem."_peq.".$parte10[1];
    			
    			
				if($ordema<>$ordem){	
					rename($ppequena."/".$pequena, $ppequena."/".$nova_foto_pequena[$j]);
    				rename($pgrande."/".$grande, $pgrande."/".$nova_foto_grande[$j]);
    			}elseif($ordema==$ordem){	    			    			
				  	rename($ppequena."/".$pequena, $ppequena."/".$pequena."temp");
    				rename($pgrande."/".$grande, $pgrande."/".$grande."temp");
				}
  			
    		} 	
		} 
		
		
		    $i2 = $_POST['cont'];
  			$c2 = 0;
		
			for($j2 = 0; $j2 <= $i2; $j2++)
			{	     
     			$pgrandes2 = "pasta_grande_".$j2;
     			$pgrande2 = $_POST[$pgrandes2];
     			$ppequenas2 = "pasta_pequena_".$j2;
     			$ppequena2 = $_POST[$ppequenas2];
     	
    			$c2++;

		     	//$foto_pequena_nova = str_replace("temp", "", $nova_foto_pequena);
		     	//$foto_grande_nova = str_replace("temp", "", $nova_foto_grande);
    			
					@rename($ppequena2."/".$nova_foto_pequena[$j2], $ppequena2."/".$nova_foto_pequena_atualizada[$j2]);
    				@rename($pgrande2."/".$nova_foto_grande[$j2], $pgrande2."/".$nova_foto_grande_atualizada[$j2]);	
			} 	
       			

		echo('<script language="javascript">alert("Ordens atualizadas com sucesso!");document.location.href="p_envia_img.php?chave='.$chave.'";</script>');
}
?>
</td>
	</tr>	
<?	if($REQUEST_METHOD!="POST") { ?>
	<tr>
	  <td colspan="2" class="style1" align="center"><span class="style7">Favor selecionar a finalidade antes de inserir a imagem se for &quot;Vendas&quot; selecionar a finalidade &quot;Venda&quot;, se for &quot;Loca&ccedil;&atilde;o Mensal&quot; ou &quot;Loca&ccedil;&atilde;o Di&aacute;ria&quot; selecionar a finalidade &quot;Loca&ccedil;&atilde;o&quot;.<br><br>Se quiser para imóveis de "Vendas para vistoria" escolha a finalidade "Vistoria Vendas", se for para imóveis de "Locação Diária ou Mensal para vistoria" escolha a finalidade "Vistoria Locação".</span></td>
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
			<option value="Venda_Vistoria">Vistoria Venda</option>
			<option value="Locacao_Vistoria">Vistoria Locação</option>
        </select></td>
	</tr>
	<tr>
	  <td colspan="2" class="style1" align="left">
		<b>Observações:</b><br>
		- O tamanho maximo das fotos grandes é de 400x300pixels. Imagens maiores serão redimensionadas.<br>
		- Para enviar as imagens informe a referência do imóvel para qual deseja inserir as imagens e em seguida selecione as imagens desejadas. (Ex: Referência 3030)<br>
		- A ordem das fotos exibidas é a mesma ordem que as fotos foram enviadas no momento da inserção.<br> 
		<span class="style7"><b>- Tamanho m&aacute;ximo das fotos para upload &eacute; de 1MB maior que isso dar&aacute; problemas de redirecionamento nas fotos pequenas </b></span></td>
	</tr>
	<tr>
	  <td colspan="2" class="style1" align="center">Refer&ecirc;ncia:      
      <input type="text" name="ref" id="ref" size="10" maxlength="10" class="campo" value="<?=$ref; ?>"></td>
    </tr>
    <tr>
	  <td>&nbsp;</td>
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
	  <td align="right" colspan="2"><input type="button" value="Enviar Arquivo" class="campo3" Onclick="VerificaCampo();"></td>
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
			$ref = $_POST['ref'];
			
			$tmp_cod = $_SESSION['cod_imobiliaria'];
			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod."'");
			$row = mysql_fetch_array($result);
			$pasta = $row['nome_pasta'];
			
			if ($finalidade == "Venda") {
				/* where to move the uploaded file(s) to? */ 
				define("INCOMING", "../imobiliarias/".$pasta."/venda/");
				define("INCOMING2", "../imobiliarias/".$pasta."/venda_peq/");
			} elseif ($finalidade == "Locacao") {
				define("INCOMING", "../imobiliarias/".$pasta."/locacao/");
				define("INCOMING2", "../imobiliarias/".$pasta."/locacao_peq/");
			} elseif ($finalidade == "Venda_Vistoria") {
				define("INCOMING", "../imobiliarias/".$pasta."/venda_vistoria/");
				define("INCOMING2", "../imobiliarias/".$pasta."/venda_vistoria_peq/");
			} elseif ($finalidade == "Locacao_Vistoria") {
			  	define("INCOMING", "../imobiliarias/".$pasta."/locacao_vistoria/");
				define("INCOMING2", "../imobiliarias/".$pasta."/locacao_vistoria_peq/");
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
					$fotos = explode(".",$foto);
					$extensao = $fotos[1];
					$referencia = $ref;
					
					
					$tmp_cod2 = $_SESSION['cod_imobiliaria'];
					$result33 = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod2."'");
					$row33 = mysql_fetch_array($result33);
						$tmp_pasta33 = $row33['nome_pasta'];
						$pasta1 = "../imobiliarias/".$tmp_pasta33."/venda/";
						$pastap1 = "../imobiliarias/".$tmp_pasta33;
						$pasta20 = "../imobiliarias/".$tmp_pasta33."/locacao/";
						$pastap20 = "../imobiliarias/".$tmp_pasta33;
						$pasta30 = "../imobiliarias/".$tmp_pasta33."/locacao_vistoria/";
						$pastap30 = "../imobiliarias/".$tmp_pasta33;
						$pasta40 = "../imobiliarias/".$tmp_pasta33."/venda_vistoria/";
						$pastap40 = "../imobiliarias/".$tmp_pasta33;
					

					$strDiretorio1 = $pasta1; // pasta das imagens
					$strDiretorio20 = $pasta20; // pasta das imagens
					$strDiretorio30 = $pasta30; // pasta das imagens
					$strDiretorio40 = $pasta40; // pasta das imagens
					$strDiretorioAbrir1 = opendir($strDiretorio1);
					$strDiretorioAbrir20 = opendir($strDiretorio20);
					$strDiretorioAbrir30 = opendir($strDiretorio30);
					$strDiretorioAbrir40 = opendir($strDiretorio40);


					$i2 = 1;
					$m2 = 1;
					$arquivos1 = array();


					$referencia = trim($referencia);
					$finalidade = trim($finalidade);
					$tm1 = strlen($referencia);

					if($finalidade=='Venda'){
					while(false !== ($strArquivos1 = readdir($strDiretorioAbrir1))) {
			 			if($strArquivos1 != "." && $strArquivos1 != "..")
			 			{	
			 	  			$arq1[$i2] = substr($strArquivos1,0,$tm1);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos1);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "venda";
			 	 			$i2++;
			 			}
					}
					}elseif($finalidade=='Locacao'){
					while(false !== ($strArquivos1 = readdir($strDiretorioAbrir20))) {
			 			if($strArquivos1 != "." && $strArquivos1 != "..")
			 			{		
			 	  			$arq1[$i2] = substr($strArquivos1,0,$tm1);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos1);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "locacao";
			 	 			$i2++;
			 			}
					}
					}elseif($finalidade=='Locacao_Vistoria'){
					while(false !== ($strArquivos1 = readdir($strDiretorioAbrir30))) {
			 			if($strArquivos1 != "." && $strArquivos1 != "..")
			 			{		
			 	  			$arq1[$i2] = substr($strArquivos1,0,$tm1);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos1);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "locacao_vistoria";
			 	 			$i2++;
			 			}
					}
					}elseif($finalidade=='Venda_Vistoria'){
					while(false !== ($strArquivos1 = readdir($strDiretorioAbrir40))) {
			 			if($strArquivos1 != "." && $strArquivos1 != "..")
			 			{		
			 	  			$arq1[$i2] = substr($strArquivos1,0,$tm1);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos1);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "venda_vistoria";
			 	 			$i2++;
			 			}
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
					
					
					$monta_foto = $ref."_".$m2.".".$extensao;
								
					
					if($m2 <= $quantidade){
					copy(${"infile".$i}, INCOMING.$monta_foto);
					
					
					$nome_foto = $monta_foto;
					$rest = substr($nome_foto, -4);
					$nome_foto2 = str_replace(".jpg","_peq.jpg","$nome_foto");
					 
					//Pega tamanho da imagem
					$ImageSize = GetImageSize (INCOMING.$monta_foto);
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
					
						criar_thumbnail(INCOMING.$monta_foto,$dest,$largura,'','JPEG');		
					
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
					
						criar_thumbnail(INCOMING.$monta_foto,INCOMING.$monta_foto,$largura,'','JPEG');
					
						echo "<center><span class=\"style1\">O arquivo <b>". $monta_foto." </b>foi enviado com sucesso.</span></center><br><br>"; 
					
					}else{
										  
						echo "<center><span class=\"style7\">O arquivo <b>". $monta_foto." </b>não pode ser enviado pois já atingiu o limite máximo ($quantidade) de fotos por imóvel.</span></center><br><br>";   
					}
					
				}
			}
			echo '<center><br><br><a href="p_envia_img.php" class=style1><< Voltar <<</a></center>';
?>	  </td>
	</tr>
<?
		} /* else */ 
?>
</table>
</form><br>
<br>

				<form method="post" action="p_envia_img.php" name="form2">
				<table border="0" align="center" valign="top" cellspacing="3" width="500">
				<tr>
				<td colspan="2" bgcolor="#<?php print("$cor3"); ?>">Pesquisar Imagem:</b></td>
				</tr>
				<tr bgcolor="#ffffff">
				<td width="30%">Referência:</td>
				<td width="70%">
				<input type="text" size="30" name="chave" class=campo></td>
				</tr>
				<tr bgcolor="#ffffff">
				  <td>Finalidade:</td>
				  <td><span class="style1">
				    <select name="finalidade2" class=campo>
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
		              <option value="">Selecione</option>
                      <option value="Venda">Venda</option>
                      <option value="Locacao">Loca&ccedil;&atilde;o</option>
                      <option value="Venda_Vistoria">Vistoria Venda</option>
                      <option value="Locacao_Vistoria">Vistoria Loca&ccedil;&atilde;o</option>
                    </select>
				  </span></td>
				  </tr>
				<tr bgcolor="#ffffff">
				<td colspan="2" bgcolor="#<?php print("$cor3"); ?>" align="right">
				<input type="button" value="Pesquisar Imagem" name="button1" class=campo3 Onclick="VerificaCampo2();"></td>
				</tr>
				</table>
				</form>

<form method="post" action="" name="form3">
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
$pasta3 = "../imobiliarias/".$tmp_pasta."/venda_vistoria/";
$pastap3 = "../imobiliarias/".$tmp_pasta;
$pasta4 = "../imobiliarias/".$tmp_pasta."/locacao_vistoria/";
$pastap4 = "../imobiliarias/".$tmp_pasta;

$strDiretorio = $pasta; // pasta das imagens
$strDiretorio2 = $pasta2; // pasta das imagens
$strDiretorio3 = $pasta3; // pasta das imagens
$strDiretorio4 = $pasta4; // pasta das imagens
$strDiretorioAbrir = opendir($strDiretorio);
$strDiretorioAbrir2 = opendir($strDiretorio2);
$strDiretorioAbrir3 = opendir($strDiretorio3);
$strDiretorioAbrir4 = opendir($strDiretorio4);


//echo "<div align=\"center\"><font color=\"#990000\" face=\"tahoma\" size=\"2\"><strong>Listando Imagens JPG e GIF de um diretorio<br><br>Diretório Escolhido: </strong>".$strDiretorio."</font></div><br><br>";

	$i = 0;
	$m = 0;
	$arquivos = array();

if($chave && $finalidade2)
{
		$chave = trim($chave);
		$tm = strlen($chave);

		if($finalidade2=='Venda'){
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
		}elseif($finalidade2=='Locacao'){
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
		}elseif($finalidade2=='Venda_Vistoria'){
		while(false !== ($strArquivos = readdir($strDiretorioAbrir3))) {
			 if($strArquivos != "." && $strArquivos != "..")
			 {	
			 	  $arq[$i] = substr($strArquivos,0,$tm);
			 	  $str[$i] = str_replace($chave,'@',$strArquivos);
			 	  $arq2[$i] = $strArquivos;
				  $arqF[$i] = "venda_vistoria";
			 	  $i++;
			 }
		}
		}elseif($finalidade2=='Locacao_Vistoria'){
		while(false !== ($strArquivos = readdir($strDiretorioAbrir4))) {
			 if($strArquivos != "." && $strArquivos != "..")
			 {	
			 	  $arq[$i] = substr($strArquivos,0,$tm);
			 	  $str[$i] = str_replace($chave,'@',$strArquivos);
			 	  $arq2[$i] = $strArquivos;
				  $arqF[$i] = "locacao_vistoria";
			 	  $i++;
			 }
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
			<td colspan="4" class=style1>Resultado da Pesquisa por "<b><? echo $chave; ?></b>" e finalidade "<b><? echo $finalidade2; ?></b>".</td>
		</tr>
		<? if($_POST['editar']=='1'){ ?>
			<tr>
			  <td colspan="4" class=style7>Atenção: Na hora de mudar a ordem das fotos favor NÃO DEIXAR ORDENS REPETIDAS pois senão pode causar problemas nas fotos com ordens iguais.</td>
			</tr>
		
		<? } ?>
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
		while($strArquivos = readdir($strDiretorioAbrir3)) {
			if($strArquivos != "." && $strArquivos != "..") {
				$arquivos[$i] = $strArquivos;
				$fold_arquivos[$i] = "venda_vistoria";
				$i++;
			}
		}
		while($strArquivos = readdir($strDiretorioAbrir4)) {
			if($strArquivos != "." && $strArquivos != "..") {
				$arquivos[$i] = $strArquivos;
				$fold_arquivos[$i] = "locacao_vistoria";
				$i++;
			}
		}
}
	@array_multisort($arquivos, $fold_arquivos);
	
	if($chave <> ''){		
	  $quant_pag = 50;
	  $x = 0;
	}else{
	  $quant_pag = 10;
	}
 		
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
	$parte2 = $extensao[0];
    $ordem_foto = explode("_", $parte2);
	
?>
<tr>
<?php
	if(($extensao[1] == "jpg") or ($extensao[1] == "gif") or ($extensao[1] == "png"))
	{
	  
	 $data = date("dmY");
	 $hora = date("His"); 
?>
	<td align=center class="style1">
	<img border=0 src="<?php print("$pastap/$fold_arquivos[$j]_peq/$foto_peq?data=$data&hora=$hora"); ?>">	
	</td>
<?php
	}
?>
<? if($_POST['editar']=='1'){ ?>
	<td class="style1">
		<input type="hidden" name="pasta_grande_<?=$j ?>" id="pasta_grande_<?=$j ?>" value="<?=$pastap."/".$fold_arquivos[$j] ?>">
		<input type="hidden" name="pasta_pequena_<?=$j ?>" id="pasta_pequena_<?=$j ?>" value="<?=$pastap."/".$fold_arquivos[$j]."_peq" ?>">
	    <input type="hidden" name="foto_antiga_grande_<?=$j ?>" id="foto_antiga_grande_<?=$j ?>" value="<?=$arquivos[$j] ?>">
	    <input type="hidden" name="foto_antiga_pequena_<?=$j ?>" id="foto_antiga_pequena_<?=$j ?>" value="<?=$foto_peq ?>">
	    <input type="hidden" name="foto_antiga_pequena_<?=$j ?>" id="foto_antiga_pequena_<?=$j ?>" value="<?=$foto_peq ?>">
	    <input type="hidden" name="ordem_antiga_<?=$j ?>" id="ordem_antiga_<?=$j ?>" value="<?=$ordem_foto[1] ?>">
	<?php print($ordem_foto[0]); ?>_<input type="text" name="ordem_<?=$j ?>" id="ordem_<?=$j ?>" class="campo" size="2" maxlength="2" value="<?php print($ordem_foto[1]); ?>">.<?php print($extensao[1]); ?></td>
<? }else{ ?>
	<td class="style1"><?php print($arquivos[$j]); ?></td>
<? } ?>
	<td><a href="#" onClick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$arquivos[$j]"); ?>\'?')) { window.location='p_envia_img.php?B1=Apagar Imagem&foto=<?php print("$arquivos[$j]"); ?>&tmp_fold=<?=$fold_arquivos[$j]?>'; }" class="style1">Apagar</a></td>
</tr>
<?php
  
}
$x++;
}
}
?>
	    <input type="hidden" name="cont" id="cont" value="<?=$x ?>">
<?
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
                  <? if($chave != "" && $finalidade2 != ""){ ?>
				  <tr>
                  	<td colspan="3" bgcolor="<?php print("$cor1"); ?>" class=style1 align=right>
                  	<? if($_POST['editar']=='1'){  ?>
                  	  <input type="hidden" name="acao" id="acao" value="0">	
					  <input type="button" value="Atualizar ordem" name="atualizar" id="atualizar" class=campo3 onClick="formOrdem('<?=$chave ?>')">
					<? 
					}else{ 
					   if (verificaFuncao("GERAL_EDIT_IMAGEM")) {
					?>
					  <input type="hidden" name="editar" id="editar" value="0">	
					  <input type="submit" value="Editar ordem da(s) imagem(ns)" name="bt_editar" id="bt_editar" class=campo3 onClick="form3.action='p_envia_img.php?chave=<?=$chave ?>&finalidade2=<?=$finalidade2 ?>&pesq=<?=$pesq ?>&ordem=<?=$ordem ?>&screen=<?=$screen ?>';form3.editar.value='1'">
					<?
					  }
					} 
					?>
					  </td>
                  </tr>
                  <? } ?>
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
/*
	for ($k = 1; $k <= $pages; $k++) {
  	$url2 = $PHP_SELF . "?screen=" . $k . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem . "&finalidade2=" . $finalidade2;
  	if($k == $screen){
  	echo " <a href=\"$url2\" class=style7><b>$k</b></a> ";
	}
  	else
  	{
  	echo " <a href=\"$url2\" class=style1>$k</a> ";	
  	}
	}
*/	

	for ($k = 0; $k < $pages; $k++) {	  
  	$url2 = $PHP_SELF . "?screen=" . $k . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem . "&finalidade2=" . $finalidade2;
  	//echo "   | <a href=\"$url2\" class=linkp>$j</a> |   ";
  		if(((($screen - 9) < $k) and (($screen + 9) > $k)) or ($k == 0) or ($k == ($pages -1))){
  			if($k == $screen){
  				echo "   | <a href=\"$url2\" class=style7><b>$k</b></a> |   ";
			}elseif($k == 0){
  				echo "   | <a href=\"$url2\" class=style1><b>Primeira</b></a> |   ";
			}elseif($k == ($pages - 1)){
  				echo "   | <a href=\"$url2\" class=style1><b>Última</b></a> |   ";
			}else{
  				echo "   | <a href=\"$url2\" class=style1>$k</a> |   ";	
  			}
  		}
	}
	
?>
                  </td>
                  </tr>
                  <tr bgcolor="<?php print("$cor3"); ?>">
                  	<td colspan="2" align=left class=style1><b>
<?php
	if ($from > $quant_pag) {
	$url1 = $PHP_SELF . "?screen=" . ($screen - 1) . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem;
?>
                  <a href="<?php print("$url1"); ?>" class="style1"><< Página anterior <<</a>
<?php
	}
?>
	</td><td align=right class=style1>
                  <b>
<?php
   if($chave == ''){
	if ($from >= $i) {
?>
		  Última página de fotos
<?php
	}
	else
	{
		$url3 = $PHP_SELF . "?screen=" . ($screen + 1) . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem;
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
	}
	}else{

	if ($from >= $m) {
?>
		  Última página de fotos
<?php
	}
	else
	{
		$url3 = $PHP_SELF . "?screen=" . ($screen + 1) . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem;
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
	}
	}
?>
                  </td>
                  </tr>
</table>
</form>
</body>

</html>