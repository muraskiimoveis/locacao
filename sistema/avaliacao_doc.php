<?php
$data_hora = date("d_m_Y_H_i_s");
$arquivo = "avaliacao_".$data_hora.".doc";

header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: application/msword; name=$arquivo");
header ( "Content-Disposition: attachment; filename=$arquivo"); 
header ( "Content-Description: MID Gera Doc" );
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg"><div align="left">
<?
    $logo_imob = $_SESSION['logo_imob'];
    $caminho_logo = "../logos/";
	if (file_exists($caminho_logo.$logo_imob))
	{
?>	
	<!--img src="<?php print($caminho_logo.$logo_imob); ?>" border="0"--></div></td>
<?
	}
?>
  </tr>
</table>
<?php

$codi_imo = $_GET['codi_imo'];
$co_imovel = $_GET['co_imovel'];
$totalme = $_GET['totalme'];
$totalmeP = $_GET['totalmeP'];
$pastai = $_GET['pastai'];
$refs = $_GET['refs'];
$titulos = $_GET['titulos'];
$descricaos = $_GET['descricaos'];
$metragems = $_GET['metragems'];

?>
<br>
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td class="style1"><div align="center"><b>Amostragem para Avalia&ccedil;&atilde;o </b>
      </div></td>
    </tr>
	  <tr>
	    <td>&nbsp;</td>
    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellpadding="1" cellspacing="1">
          <tr>
            <td colspan="2" class="TdSubTitulo"><b>Im&oacute;vel</b></td>
            <td width="13%" class="TdSubTitulo"><b>Metragem</b></td>
            <td width="15%" class="TdSubTitulo"><b>Valor</b></td>
            <td width="11%" class="TdSubTitulo"><b>M&eacute;dia</b></td>
          </tr>
          <?
            $buscaC = mysql_query("SELECT COUNT(a.id_avaliacao) as total FROM avaliados a WHERE a.user='".$u_cod."'");
		    while($linhaC = mysql_fetch_array($buscaC)){
				       $total  += $linhaC['total'];
		 
		    }  
           
          	$buscaIM = mysql_query("SELECT im_cod, nome_pasta FROM rebri_imobiliarias ORDER BY im_nome ASC");
			while($linhaIM = mysql_fetch_array($buscaIM)){
		    
          
       		      //REALIZA BUSCA DO DADOS DO IMOVEL E VALOR
       		      $buscaA = mysql_query("SELECT m.cod, m.ref, m.titulo, m.metragem, m.finalidade, m.valor, a.id_avaliacao, a.total_diarias FROM muraski m INNER JOIN avaliados a ON (m.cod=a.cod_imovel) WHERE a.user='".$u_cod."' AND m.cod_imobiliaria='".$linhaIM['im_cod']."' ORDER BY m.titulo ASC");
				  while($linha = mysql_fetch_array($buscaA)){
				     $imagem = $linha['img_1'];
				     $id_avaliacao = $linha['id_avaliacao'];
				     $ref = $linha['ref'];
				     $titulo = strip_tags($linha['titulo']);
				     $metragens = explode(".00", $linha['metragem']);
					 $metragem = $metragens[0];
				     $cod = $linha['cod'];
				     $valoresm = explode(".00", $linha['valor']);
					 $valorm = $valoresm[0];
					 $finalidade = $linha['finalidade'];
					 $diarias = $linha['total_diarias'];
					 			    
				    if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
					 	//REALIZA A BUSCA DO VALOR NA TABELA LOCACAO 
				     	$buscaL = mysql_query("SELECT l_limpeza FROM locacao WHERE l_imovel='".$cod."' AND cod_imobiliaria='".$linhaIM['im_cod']."'");  
				     	while($linha3 = mysql_fetch_array($buscaL)){
				       		$valoresl = explode(".00", $linha3['l_limpeza']);
					   		$valorlim = $valoresl[0];
					   		
					   		$valorl = $valorm * $diarias + $valorlim;
				     	}
				     }else{
					 	//REALIZA A BUSCA DO VALOR NA TABELA VENDA 
				     	$buscaV = mysql_query("SELECT v_imovel, v_total FROM vendas WHERE v_imovel='".$cod."' AND cod_imobiliaria='".$linhaIM['im_cod']."'");  
				     	while($linha2 = mysql_fetch_array($buscaV)){
				       		$cod_imovel = $linha2['v_imovel'];
				       		$valoresv = explode(".00", $linha2['v_total']);
					   		$valorv = $valoresv[0];	
				     	}  
					 }
					 
					   
					    //FAZ VERIFICACAO QUAL VALOR UTLIZAR SE TABELA VENDA OU DA MURASKI	
						if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
							$valor = $valorl;
				        }else{
						  	if($cod==$cod_imovel){
				            	$valor = $valorv;
				        	}elseif($cod<>$cod_imovel){
				            	$valor = $valorm;   
				        	}
						}
				    
				        
				        //VERIFICA SE EXISTE A IMAGEM
 						    if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
						$pasta = "../imobiliarias/".$linhaIM['nome_pasta']."/".$pasta_finalidade."/";
						
						$nome_foto1 = $linha[ref] . "_1_peq" . ".jpg";
						
					    
					    //CALCULA A MEDIA
					    $media = ($valor / $metragem);
					    $totalmed = $totalmed + $media;

				      echo('      
				        <tr>
				         <td width="7%" class="style1">
					  ');
						 
						if (file_exists($pasta.$nome_foto1))
						{
							//echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."\" width=\"100\">");				
					    }
						 
					echo('</td>
				         <td width="36%" class="style1">'.$ref.' - '.$titulo.'</td>
				         <td class="style1">'.number_format($metragem, 2, '.', '.').' m&sup2;</td>
				         <td class="style1">R$ '.number_format($valor, 2, ',', '.').'</td>
				         <td class="style1">R$ '.number_format($media, 2, ',', '.').'</td>         		         
		               </tr>
		              ');
		           //REALIZA SOMA TOTAL DA METRAGEM, DO VALOR E CALCULA MEDIA TOTAL
		           $totalm = $totalm + $metragem;
				   $totalv = $totalv + $valor;
				   $totalme = $totalmed / $total;
				   
		          }
		        }
		        
       		    ?>
          <tr>
            <td colspan="2" class="style1"><div align="center"><b>Total:</b> </div></td>
            <td class="style1">&nbsp;</td>
            <td class="style1">&nbsp;</td>
            <td class="style1">R$ <?=number_format($totalme, 2, ',', '.'); ?></td>
          </tr>
        </table></td>
    </tr>
	  <tr>
	    <td>&nbsp;</td>
    </tr>
	  <tr>
      <td class="style1"><div align="center"><b>IM&Oacute;VEIS PONDERADOS</b></div></td>
    </tr>
	<tr>
      <td><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td colspan="2" class="TdSubTitulo"><b>Im&oacute;vel</b></td>
          <td width="19%" class="TdSubTitulo"><b>Metragem</b></td>
          <td width="17%" class="TdSubTitulo"><b>Valor</b></td>
          <td width="15%" class="TdSubTitulo"><b>M&eacute;dia</b></td>
        </tr>
        <?
		          $cont = 0;
		    
				  //PEGA A MEDIA DA BUSCA ANTERIOR E ACRESCENTA 20% A MAIS E 20% A MENOS
				  $porcMenos = ($totalme * 0.8);   
				  $porcMais = ($totalme * 1.2);   
				  
				  
				  $buscaIM = mysql_query("SELECT im_cod, nome_pasta FROM rebri_imobiliarias ORDER BY im_nome ASC");
				  while($linhaIM = mysql_fetch_array($buscaIM)){

					 
				  //REALIZA BUSCA DO DADOS DO IMOVEL E VALOR	  	               
       		      $buscaP = mysql_query("SELECT m.cod, m.ref, m.titulo, m.metragem, m.finalidade, m.valor, a.total_diarias FROM muraski m INNER JOIN avaliados a ON (m.cod=a.cod_imovel) WHERE a.user='".$u_cod."' AND m.cod_imobiliaria='".$linhaIM['im_cod']."' ORDER BY m.titulo ASC");
				  $totalmP = 0;
				  $totalvP = 0;
				  $totalmeP = 0;
				  while($linha = mysql_fetch_array($buscaP)){
				     $imagemP = $linha['img_1'];
				     $refP = $linha['ref'];
				     $tituloP = strip_tags($linha['titulo']);
				     $metragensP = explode(".00", $linha['metragem']);
					 $metragemP = $metragensP[0];
				     $codP = $linha['cod'];
				     $valoresmP = explode(".00", $linha['valor']);
					 $valormP = $valoresmP[0];
					 $finalidade = $linha['finalidade'];
					 $diariasP = $linha['total_diarias'];
					 				    
				     if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
					 	//REALIZA A BUSCA DO VALOR NA TABELA LOCACAO 
				     	$buscaLP = mysql_query("SELECT l_limpeza FROM locacao WHERE l_imovel='".$codP."' AND cod_imobiliaria='".$linhaIM['im_cod']."'");  
				     	while($linha3 = mysql_fetch_array($buscaLP)){
				       		$valoreslP = explode(".00", $linha3['l_limpeza']);
					   		$valorlimP = $valoreslP[0];
					   		
					   		$valorlP = $valormP * $diariasP + $valorlimP;
				     	}
				     }else{
					 	//REALIZA A BUSCA DO VALOR NA TABELA VENDA 
					 	$buscaVP = mysql_query("SELECT v_imovel, v_total FROM vendas WHERE v_imovel='".$codP."' AND cod_imobiliaria='".$linhaIM['im_cod']."'");  
					 	while($linha2 = mysql_fetch_array($buscaVP)){
				       		$cod_imovelP = $linha2['v_imovel'];
				       		$valoresvP = explode(".00", $linha2['v_total']);
					   		$valorvP = $valoresvP[0];
				     	}   
					 }
					 
					    //FAZ VERIFICACAO QUAL VALOR UTLIZAR SE TABELA VENDA OU LOCACAO OU DA MURASKI	
						if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
							$valorP = $valorlP;
				        }else{
						  	//FAZ VERIFICACAO QUAL VALOR UTLIZAR SE TABELA VENDA OU DA MURASKI	
							if($codP==$cod_imovelP){
				            	$valorP = $valorvP;
				        	}elseif($codP<>$cod_imovelP){
				            	$valorP = $valormP;   
				        	}
						}
				     
				      	//VERIFICA SE EXISTE A IMAGEM
							if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
								$pasta_finalidade = "locacao_peq";
							}
							else
							{
								$pasta_finalidade = "venda_peq";
							}
						$pasta = "../imobiliarias/".$linhaIM['nome_pasta']."/".$pasta_finalidade."/";
						
						$nome_foto1 = $linha[ref] . "_1_peq" . ".jpg";
						
					    
					    //CALCULA A MEDIA
					    $mediaP = ($valorP / $metragemP);
					     $totalmdP = $totalmdP + $mediaP;
					    
					    
					    //VERIFICA SE MEDIA EST&Aacute; ENTRE A MARGEM E EXIBE O ESTILO CONFORME SENTEN&Ccedil;A
					if($mediaP >= $porcMenos && $mediaP <= $porcMais){	
					  $contadorM = $contadorM + $mediaP;
					  if($cont==0){
							   $cont = 1; 
							}else{
							   $cont++;  
							}			   
				      echo('      
				        <tr>
				         <td width="7%"><span class="style1">
					  ');	 
						 
						if (file_exists($pasta.$nome_foto1))
						{
							//echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."\" width=\"100\">");				
					    } 
						 
					   echo('</span></td>
				         <td width="36%"><span class="style1">'.$refP.' - '.$tituloP.'</span></td>
				         <td><span class="style1">'.number_format($metragemP, 2, '.', '.').' m²</span></td>
				         <td><span class="style1">R$ '.number_format($valorP, 2, ',', '.').'</span></td>
				         <td><span class="style1">R$ '.number_format($mediaP, 2, ',', '.').'</span></td>
		               </tr>
		              ');
		            }
		           //REALIZA SOMA TOTAL DA METRAGEM, DO VALOR E CALCULA MEDIA TOTAL
		           if($mediaP >= $porcMenos && $mediaP <= $porcMais){
				   		$totalmP = $totalmP + $metragemP;
				   		$totalvP = $totalvP + $valorP;
				   		
				   		
				   }
				 }
		        }
		        if($cont<>'0'){
		        	$totalmeP = $contadorM / $cont;	
		        }
       		    ?>
        <tr>
          <td colspan="2" class="style1"><div align="center"><b>Total:</b></div></td>
          <td class="style1">&nbsp;</td>
          <td class="style1">&nbsp;</td>
          <td class="style1">R$ <?=number_format($totalmeP, 2, ',', '.'); ?></td>
        </tr>
      </table></td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
    </tr>
	</table>
	<table width="100%" border="0" cellpadding="1" cellspacing="1">
	
<?
if($menu<>'avaliacao'){
if($co_imovel<>''){

		$buscaIA = mysql_query("SELECT ref, titulo, metragem, descricao, finalidade FROM muraski WHERE cod='".$co_imovel."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
   	  	while($linha3 = mysql_fetch_array($buscaIA)){
   	  	  $finalidade = $linha3['finalidade'];  
  		
		//VERIFICA SE EXISTE A IMAGEM
			if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
   				$pasta_finalidade = "locacao_peq";
   			}
   			else
   			{
   				$pasta_finalidade = "venda_peq";
   			}
   		$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
   		
   		$nome_foto1 = $linha3['ref'] . "_1_peq" . ".jpg";
   			  
		  $resultado = $totalmeP * $linha3['metragem'];
		  	  
		  	echo("
		  	   <tr>
	  				<td colspan=\"2\" class=\"style1\"><div align=\"center\"><strong>IM&Oacute;VEL EM AVALIA&Ccedil;&Atilde;O </strong></div></td>
    			</tr>
			   <tr>
	  				<td width=\"135\" class=\"style1\">
			");	  
					  
			if (file_exists($pasta.$nome_foto1))
			{
				//echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."\" width=\"100\">");				
    		}
					  
			echo("		  
					  <br>Ref: ".$linha3['ref']."</td>
      				<td width=\"608\" class=\"style1\">".strip_tags($linha3['titulo'])."<br><br>".strip_tags($linha3['descricao'])."</td>
			   </tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\">&nbsp;</td>
    			</tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\"><b>CONCLUS&Atilde;O: O valor m&eacute;dio estimado para este im&oacute;vel &eacute; de: </b><span class=\"style7\"><b>R$ ".number_format($resultado, 2, ',', '.')."<b></span></td>
    			</tr>
			");
			
   	 	} 	 	

}elseif($codi_imo<>''){
  		
		$buscaIA = mysql_query("SELECT m.ref, m.titulo, m.metragem, m.descricao, m.finalidade FROM muraski m WHERE m.cod='".$codi_imo."'");
		while($linha4 = mysql_fetch_array($buscaIA)){
   	  	$finalidade = $linha4['finalidade'];
  		
		//VERIFICA SE EXISTE A IMAGEM
            if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 		
   				$pasta_finalidade = "locacao_peq";
   			}
   			else
   			{
   				$pasta_finalidade = "venda_peq";
   			}
   		$pasta = "../imobiliarias/".$pastai."/".$pasta_finalidade."/";
   		
   		$nome_foto1 = $linha4['ref'] . "_1_peq" . ".jpg";
   				  
		  $resultado = $totalmeP * $linha4['metragem'];
		  	  
		  	echo("
		 		<tr>
	  				<td colspan=\"2\" class=\"style1\"><div align=\"center\"><strong>IM&Oacute;VEL EM AVALIA&Ccedil;&Atilde;O </strong></div></td>
    			</tr>
			   <tr>
	  				<td width=\"135\" class=\"style1\">
			");		  
					  
			if (file_exists($pasta.$nome_foto1))
			{
				//echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."\" width=\"100\">");				
    		}
					  
			echo("		  
					  <br>Ref: ".$linha4['ref']."</td>
      				<td width=\"608\" class=\"style1\">".strip_tags($linha4['titulo'])."<br><br>".strip_tags($linha4['descricao'])."</td>
			   </tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\">&nbsp;</td>
    			</tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\"><b>CONCLUS&Atilde;O: O valor m&eacute;dio estimado para este im&oacute;vel &eacute; de: </b><span class=\"style7\"><b>R$ ".number_format($resultado, 2, ',', '.')."<b></span></td>
    			</tr>
			");
			
   	 	}
}else{
			  
			$resultado = $totalmeP * $metragems;  
   
		  	echo('
		  	   <tr>
	  				<td colspan="2" class="style1"><div align="center"><strong>IM&Oacute;VEL EM AVALIA&Ccedil;&Atilde;O </strong></div></td>
    			</tr>
			   <tr>
	  				<td width="135" class="style1">Ref: '.$refs.'</td>
      				<td width="608" class="style1">'.$titulos.'<br><br>'.$descricaos.'<br>Metragem: '.$metragems.' m²</td>
			   </tr>
			   <tr>
	  				<td colspan="2" class="style1">&nbsp;</td>
    			</tr>
			   <tr>
	  				<td colspan="2" class="style1"><b>CONCLUS&Atilde;O: O valor m&eacute;dio estimado para este im&oacute;vel &eacute; de: </b><span class="style7"><b>R$ '.number_format($resultado, 2, ',', '.').'<b></span></td>
    			</tr>
			');	 
			  
}
}
?>
	</table>
