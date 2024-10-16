<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
ob_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
if($_GET['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("AMOSTRAGEM");

if($_GET['pdf']=='1'){
  
$html .= '<page><table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;">';

    $logo_imob = $_SESSION['logo_imob'];
    $caminho_logo = "../logos/";
	if (file_exists($caminho_logo.$logo_imob))
	{

	$html .= '<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100"></td>';

	}

$html .='   
  </tr>
</table>
';

$codi_imo = $_GET['codi_imo'];
$co_imovel = $_GET['co_imovel'];
$totalme = $_GET['totalme'];
$totalmeP = $_GET['totalmeP'];
$pastai = $_GET['pastai'];
$refs = $_GET['refs'];
$titulos = $_GET['titulos'];
$descricaos = $_GET['descricaos'];
$metragems = $_GET['metragems'];

$html .='

  <table width="800" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="4" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>Amostragem para Avalia&ccedil;&atilde;o </b></td>
    </tr>
	  <tr>
	    <td colspan="4">&nbsp;</td>
    </tr>
	<tr>
            <td style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Im&oacute;vel</b></td>
            <td width="13%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Metragem</b></td>
            <td width="15%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
            <td width="11%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>M&eacute;dia</b></td>
          </tr>';
          
            $buscaC = mysql_query("SELECT COUNT(a.id_avaliacao) as total FROM avaliados a WHERE a.user='".$u_cod."'");
		    while($linhaC = mysql_fetch_array($buscaC)){
				       $total  += $linhaC['total'];
		 
		    }  
           
          	$buscaIM = mysql_query("SELECT im_cod, nome_pasta FROM rebri_imobiliarias ORDER BY im_nome ASC");
			while($linhaIM = mysql_fetch_array($buscaIM)){
		    
          
       		      //REALIZA BUSCA DO DADOS DO IMOVEL E VALOR
       		      $buscaA = mysql_query("SELECT m.cod, m.ref, m.tipo_logradouro, m.end, m.numero, m.metragem, m.finalidade, m.valor, a.id_avaliacao, a.total_diarias FROM muraski m INNER JOIN avaliados a ON (m.cod=a.cod_imovel) WHERE a.user='".$u_cod."' AND m.cod_imobiliaria='".$linhaIM['im_cod']."' ORDER BY m.ref ASC");
				  while($linha = mysql_fetch_array($buscaA)){
				     $imagem = $linha['img_1'];
				     $id_avaliacao = $linha['id_avaliacao'];
				     $ref = $linha['ref'];
				     $endereco = $linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero'];
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

				      $html .= '     
				        <tr>
				         <td width="500" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">
					  ';
						 
						if (file_exists($pasta.$nome_foto1))
						{
							$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    }
					    else
						{
							$html .='<img src="images/sem_foto.gif" border="0" width="100" />';
						}
						 
					   $html .= '<br>'.$ref.' - '.$endereco.'</td>
				         <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">'.number_format($metragem, 2, '.', '.').' m&sup2;</td>
				         <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">R$ '.number_format($valor, 2, ',', '.').'</td>
				         <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">R$ '.number_format($media, 2, ',', '.').'</td>         		         
		               </tr>
		              ';
		           //REALIZA SOMA TOTAL DA METRAGEM, DO VALOR E CALCULA MEDIA TOTAL
		           $totalm = $totalm + $metragem;
				   $totalv = $totalv + $valor;
				   $totalme = $totalmed / $total;
				   
		          }
		        }
		        
       		    
          $html .=' <tr>
            <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>Total:</b></td>
            <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
            <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
            <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">R$'.number_format($totalme, 2, ',', '.').'</td>
          </tr>
	  <tr>
	    <td colspan="4">&nbsp;</td>
    </tr>
	  <tr>
      <td colspan="4" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>IM&Oacute;VEIS PONDERADOS</b></td>
    </tr>
	<tr>
          <td style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Im&oacute;vel</b></td>
          <td width="19%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Metragem</b></td>
          <td width="17%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
          <td width="15%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>M&eacute;dia</b></td>
        </tr>';
        
		          $cont = 0;
		    
				  //PEGA A MEDIA DA BUSCA ANTERIOR E ACRESCENTA 20% A MAIS E 20% A MENOS
				  $porcMenos = ($totalme * 0.8);   
				  $porcMais = ($totalme * 1.2);   
				  
				  //echo "porc mais ".$porcMais."<br>";
				  //echo "proc menos ".$porcMenos."<br>";
				  
				  
				  $buscaIM = mysql_query("SELECT im_cod, nome_pasta FROM rebri_imobiliarias ORDER BY im_nome ASC");
				  while($linhaIM = mysql_fetch_array($buscaIM)){

					 
				  //REALIZA BUSCA DO DADOS DO IMOVEL E VALOR	  	               
       		      $buscaP = mysql_query("SELECT m.cod, m.ref, m.tipo_logradouro, m.end, m.numero, m.metragem, m.finalidade, m.valor, a.total_diarias FROM muraski m INNER JOIN avaliados a ON (m.cod=a.cod_imovel) WHERE a.user='".$u_cod."' AND m.cod_imobiliaria='".$linhaIM['im_cod']."' ORDER BY m.ref ASC");
				  $totalmP = 0;
				  $totalvP = 0;
				  $totalmeP = 0;
				  while($linha = mysql_fetch_array($buscaP)){
				     $imagemP = $linha['img_1'];
				     $refP = $linha['ref'];
				     $enderecoP = $linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero'];
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
					    if(!empty($valorP) && !empty($metragemP))
					    {
					    	$mediaP = ($valorP / $metragemP);
					    }
					     $totalmdP = $totalmdP + $mediaP;
					    
					    //echo "media ".$mediaP."<br>";
					    
					    //VERIFICA SE MEDIA EST&Aacute; ENTRE A MARGEM E EXIBE O ESTILO CONFORME SENTEN&Ccedil;A
					if($mediaP >= $porcMenos && $mediaP <= $porcMais){	
					  $contadorM = $contadorM + $mediaP;
					  if($cont==0){
							   $cont = 1; 
							}else{
							   $cont++;  
							}			   
				      $html .='      
				        <tr>
				         <td width="500" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">
					  ';	 
						 
						if (file_exists($pasta.$nome_foto1))
						{
							$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
					    } 
					    else
						{
							$html .='<img src="images/sem_foto.gif" border="0" width="100" />';
						}
						 
					   $html .= '<br>'.$refP.' - '.$enderecoP.'</td>
				         <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($metragemP, 2, '.', '.').' m²</td>
				         <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">R$ '.number_format($valorP, 2, ',', '.').'</td>
				         <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">R$ '.number_format($mediaP, 2, ',', '.').'</td>
		               </tr>
		              ';
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
       		    
        $html .= '<tr>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>Total:</b></td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
          <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">R$ '.number_format($totalmeP, 2, ',', '.').'</td>
        </tr>
	<tr>
	  <td colspan="4">&nbsp;</td>
    </tr>
	</table>';
	

if($co_imovel<>''){

       $html .= '<table width="800" border="0" cellpadding="1" cellspacing="1" align="center">';
    
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
		  	  
		  	$html .= '
		  	   <tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>IM&Oacute;VEL EM AVALIA&Ccedil;&Atilde;O </b></td>
    			</tr>
			   <tr>
	  				<td width="135" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">
			';	  
					  
			if (file_exists($pasta.$nome_foto1))
			{
				$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
    		}
			else
			{
				$html .='<img src="images/sem_foto.gif" border="0" width="100" />';
			}
					  
			$html .= '	  
					  <br>Ref: '.$linha3['ref'].'</td>
      				<td width="608" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.strip_tags($linha3['titulo']).'<br><br>'.strip_tags($linha3['descricao']).'<br>Metragem: '.$linha3['metragem'].' m²</td>
			   </tr>
			    <tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    			</tr>
    			<tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    			</tr>
			   <tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>CONCLUS&Atilde;O: O valor m&eacute;dio estimado para este im&oacute;vel &eacute; de: </b><b>R$ '.number_format($resultado, 2, ',', '.').'</b></td>
    			</tr>
			';
			
   	 	} 	 	

         $html .='<tr>
	  				<td colspan="2">&nbsp;</td>
    			</tr>
			    <tr>
            		<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />www.redebrasileiradeimoveis.com.br</td>
          		</tr>
		 </table></page>';
         
}elseif($codi_imo<>''){
   
       $html .= '<table width="800" border="0" cellpadding="1" cellspacing="1" align="center">';
  		
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
		  	  
		  	$html .= '
		 		<tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>IM&Oacute;VEL EM AVALIA&Ccedil;&Atilde;O </b></td>
    			</tr>
			   <tr>
	  				<td width="135" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">
			';		  
					  
			if (file_exists($pasta.$nome_foto1))
			{
				$html .= '<img src="'.$pasta.$nome_foto1.'" border="0" width="100" />';				
    		}
			else
			{
				$html .='<img src="images/sem_foto.gif" border="0" width="100" />';
			}
					  
			$html .= '		  
					  <br>Ref: '.$linha4['ref'].'</td>
      				<td width="600" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.strip_tags($linha4['titulo']).'<br><br>'.strip_tags($linha4['descricao']).'<br>Metragem: '.$linha4['metragem'].' m²</td>
			   </tr>
			   <tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    			</tr>
    			<tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    			</tr>
			   <tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>CONCLUS&Atilde;O: O valor m&eacute;dio estimado para este im&oacute;vel &eacute; de: </b><b>R$ '.number_format($resultado, 2, ',', '.').'</b></td>
    			</tr>
			';
			
   	 	}
         
         $html .='<tr>
	  				<td colspan="2">&nbsp;</td>
    			</tr>
			    <tr>
            		<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />www.redebrasileiradeimoveis.com.br</td>
          		</tr>
		 </table></page>';
}else{
  			 $html .= '<table width="800" border="0" cellpadding="1" cellspacing="1" align="center">';
			  
			$resultado = $totalmeP * $metragems;  
   
		  	$html .='
		  	   <tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>IM&Oacute;VEL EM AVALIA&Ccedil;&Atilde;O </b></td>
    			</tr>
			   <tr>
	  				<td width="135" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Ref: '.$refs.'</td>
      				<td width="608" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$titulos.'<br><br>'.$descricaos.'<br>Metragem: '.$metragems.' m²</td>
			   </tr>
			    <tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    			</tr>
    			<tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    			</tr>
			   <tr>
	  				<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>CONCLUS&Atilde;O: O valor m&eacute;dio estimado para este im&oacute;vel &eacute; de: </b><b>R$ '.number_format($resultado, 2, ',', '.').'</b></td>
    			</tr>
			';	 
			
			 $html .='<tr>
	  				<td colspan="2">&nbsp;</td>
    			</tr>
			    <tr>
            		<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />www.redebrasileiradeimoveis.com.br</td>
          		</tr>
			 </table></page>';	  
  
}

echo $html;


	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	$pdf = new HTML2PDF('P','A4','fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();
  
}

if($_GET['pdf']<>'1'){

  $datafo = date("dmY");
  $horafo = date("His");

?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(id)
{
       if(confirm("Tem certeza que deseja retirar da lista?"))
          document.location.href='p_rel_avaliacao.php?id_excluir=' + id;
}

function confirmaLimpeza()
{
       if(confirm("Tem certeza que deseja esvaziar a lista?"))
          document.location.href='p_rel_avaliacao.php?esvaziar=1';
}

function CalcMetragem(){
   var metragem = document.getElementById('metragem').value;
   var totalp = document.getElementById('totalp').value;

   var resultado = (metragem * totalp);
   document.getElementById('resultadom').value = formatCurrency(resultado);

}

function VerificaCampo(){

var msgErro = '';

	   if(document.form1.co_imovel.value.length==0)
       {
            msgErro += "Por favor, selecione o campo Imóvel.\n"; 
       }
       if(msgErro != '')
	   {
	        alert(msgErro);
	        return false;
	   }
	   else
	   {
	        document.form1.buscar.value='1';
            document.form1.submit();
	   }

}

function VerificaCampo2(){

var msgErro = '';

	   if(document.form1.refs.value.length==0)
       {
            msgErro += "Por favor, preencha o campo Referência.\n"; 
       }
       else
  	   {
    		var er = new RegExp("^[0-9a-z]+$");
    		if(er.test(document.form1.refs.value) == false)
			{
  	    		alert("Não pode haver espaço nem caractere especial no campo Referência");
    			document.form1.refs.focus();
    			return false;		    
    		}
  	   }
       if(document.form1.titulos.value.length==0)
       {
            msgErro += "Por favor, preencha o campo Título.\n"; 
       }
	   if(document.form1.metragems.value.length==0)
       {
            msgErro += "Por favor, preencha o campo Metragem.\n"; 
       }
       if(msgErro != '')
	   {
	        alert(msgErro);
	        return false;
	   }
	   else
	   {
	        document.form1.buscar.value='1';
            document.form1.submit();
	   }

}

</script>
</head>

<body>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
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

<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/

if($_GET['codi_imo']){
$codi_imo = $_GET['codi_imo'];
}elseif($_POST['codi_imo']){
$codi_imo = $_POST['codi_imo'];
}

if($_GET['codi']){
$codi = $_GET['codi'];
$pastai = $_GET['pastai'];
}
	  
if(!empty($_GET['id_excluir']))
{   
      
	$exclusao = "DELETE FROM avaliados WHERE id_avaliacao='".$id_excluir."'";
   	if(mysql_query($exclusao))
   	{
   		echo('<script language="javascript">alert("Item retirado da lista!");document.location.href="p_rel_avaliacao.php";</script>');
   	}
}

if(!empty($_GET['esvaziar']))
{       
    
	$limpeza = "DELETE FROM avaliados WHERE user='".$u_cod."'";
	if(mysql_query($limpeza))
   	{
   		echo('<script language="javascript">alert("Lista esvaziada!");document.location.href="p_rel_avaliacao.php";</script>');
   	}
}

?>
<form id="form1" name="form1" method="post" action="p_rel_avaliacao.php">
<input type="hidden" name="codi_imo" id="codi_imo" value="<?=$codi_imo; ?>">
<input type="hidden" name="codi" id="codi" value="<?=$codi; ?>">
<input type="hidden" name="pastai" id="pastai" value="<?=$pastai; ?>">
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td height="50" colspan="2" class="style1"><div align="center"><b>Amostragem para Avalia&ccedil;&atilde;o </b><br /><? if($codi_imo==''){ ?><span class="style7"><b>Selecione um imóvel para avaliar ou preencha um novo para avaliar</b></span><? } ?>
      </div></td>
    </tr>
<? if($codi_imo==''){ ?>
    <tr class="fundoTabela">
      <td align="center" colspan="2" class="style1"><b>Imóvel:</b>
          <input type="text" name="co_imovel" size="5" class="campo2" value="<?php print($co_imovel); ?>" readonly>
          <input type="text" name="nome_imovel" size="80" class="campo" value='<?php print($nome_imovel); ?>' readonly>
          <input type="button" id="selecionar" name="selecionar" value="Selecionar" class="campo3" onClick="window.open('list_imoveis.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><span class="style1">
        <input type="hidden" name="buscar" id="buscar" value="0">
        <input type="button" value="Avaliar" name="avaliar" id="avaliar" class="campo3" onClick="VerificaCampo();"><br><br>ou
      </span></div></td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="50" colspan="4"><div align="center" class="style1"><b>Novo Im&oacute;vel para essa avalia&ccedil;&atilde;o</b><br><span class="style7">Depois de preencher os campos clique no botão "Avaliar" localizado abaixo para avaliar o imóvel descrito abaixo</span></div></td>
  </tr>
  <tr class="fundoTabela">
    <td class="style1">Refer&ecirc;ncia:</td>
    <td class="style1">T&iacute;tulo:</td>
    <td class="style1" valign="top">Descri&ccedil;&atilde;o:</td>
    <td class="style1">Metragem:</td>
  </tr>
  <tr class="fundoTabela">
    <td valign="top"><span class="style1">
      <input type="text" name="refs" id="refs" size="10" maxlength="10" class="campo" value="<?=$refs; ?>" onKeyUp="return autoTab(this, 10, event);" />
    </span></td>
    <td valign="top"><span class="style1"><input type="text" name="titulos" id="titulos" size="40" class="campo" value="<?=$titulos; ?>">
    </span></td>
    <td valign="top"><span class="style1"><textarea rows="1" name="descricaos" id="descricaos" cols="36" class="campo"><?=$descricaos; ?></textarea>
    </span></td>
    <td valign="top"><span class="style1">
      <input type="text" name="metragems" id="metragems" size="10" class="campo" value="<?=$metragems; ?>" /> <br>Ex: 100.00 ou 100
    </span></td>
  </tr>
  <tr>
    <td colspan="4" align="center">
	<input type="button" value="Avaliar" name="avaliar" id="avaliar" class="campo3" onClick="VerificaCampo2();"><br><br></td>
  </tr>
</table>	  
	  <!--a href="javascript:;" onClick="MM_openBrWindow('p_insert_imoveis_avaliacao.php','','scrollbars=yes,resizable=no,width=800,height=600')" class="style1">Inserir novo imóvel para essa avaliação</a--></td>
    </tr>
<? } ?>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
				<tr height="25" class="fundoTabelaTitulo">
          			<td colspan="2" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="13%" class="style1"><b>Metragem</b></td>
          			<td width="15%" class="style1"><b>Valor</b></td>
          			<td width="11%" class="style1"><b>M&eacute;dia</b></td>
       			    <td width="15%" class="style1"><b>Ação</b></td>
				</tr>
       		    <?
       		    if($_POST['buscar']=='1'){
				   //REALIZA BUSCA DO DADOS DO IMOVEL E VALOR
				  $buscaC = mysql_query("SELECT COUNT(a.id_avaliacao) as total FROM avaliados a WHERE a.user='".$u_cod."'");
				  while($linhaC = mysql_fetch_array($buscaC)){
				       $total  += $linhaC['total'];
		 
				  }  
				  
				  $k= 1;
				  
				  $buscaIM = mysql_query("SELECT im_cod, nome_pasta FROM rebri_imobiliarias ORDER BY im_nome ASC");
				  while($linhaIM = mysql_fetch_array($buscaIM)){ 
				   
       		      $buscaA = mysql_query("SELECT m.cod, m.ref, m.tipo_logradouro, m.end, m.numero, m.metragem, m.finalidade, m.valor, a.id_avaliacao, a.total_diarias FROM muraski m INNER JOIN avaliados a ON (m.cod=a.cod_imovel) WHERE a.user='".$u_cod."' AND m.cod_imobiliaria='".$linhaIM['im_cod']."' ORDER BY m.ref ASC");
				  while($linha = mysql_fetch_array($buscaA)){
				     $id_avaliacao = $linha['id_avaliacao'];
				     $ref = $linha['ref'];
				     $endereco = $linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero'];
				     $metragens = explode(".00", $linha['metragem']);
					 $metragem = $metragens[0];
				     $cod = $linha['cod'];
				     $valoresm = explode(".00", $linha['valor']);
					 $valorm = $valoresm[0];
					 $finalidade = $linha['finalidade'];
					 $diarias = $linha['total_diarias'];
					 
					 if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					 $k++;			        
				        
				        if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
					 	//REALIZA A BUSCA DO VALOR NA TABELA LOCACAO 
				     	$buscaL = mysql_query("SELECT l_limpeza FROM locacao WHERE l_imovel='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");  
				     	while($linha3 = mysql_fetch_array($buscaL)){
				       		$valoresl = explode(".00", $linha3['l_limpeza']);
					   		$valorlim = $valoresl[0];
					   		
					   		$valorl = $valorm * $diarias + $valorlim;
				     	}
				     }else{
					 	//REALIZA A BUSCA DO VALOR NA TABELA VENDA 
				     	$buscaV = mysql_query("SELECT v_imovel, v_total FROM vendas WHERE v_imovel='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");  
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
						/*	        
            			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$codi."'");
						$row = mysql_fetch_array($result);
						$tmp_pasta = $row['nome_pasta'];
						*/
						/*
						$pasta_fin = strtolower(substr($finalidade, 0, 4));
						if($pasta_fin == "loca"){
						*/
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
					    if(!empty($valor) && !empty($metragem))
					    {
					    	$media = ($valor / $metragem);
					    }
					    $totalmed = $totalmed + $media;

				      echo("      
				        <tr class=\"$fundo\">
				         <td width=\"7%\" class=\"style1\">
					  ");	 
						 
						if (file_exists($pasta.$nome_foto1))
						{
							echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
    					}
    					else
						{
							echo '<img src="images/sem_foto.gif" border="0" width="100" />';
						}
    					
						 
					 echo('
						 </td>
				         <td width="36%" class="style1">'.$ref.' - '.$endereco.'</td>
				         <td class="style1">'.number_format($metragem, 2, '.', '.').' m²</td>
				         <td class="style1">R$ '.number_format($valor, 2, ',', '.').'</td>
				         <td class="style1">R$ '.number_format($media, 2, ',', '.').'</td>
         		         <td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$id_avaliacao.')" class="style1">[Retirar da lista]</a></div></td>
		               </tr>
		              ');
		           //REALIZA SOMA TOTAL DA METRAGEM, DO VALOR E CALCULA MEDIA TOTAL
		           $totalm = $totalm + $metragem;
				   $totalv = $totalv + $valor;
				   $totalme = $totalmed / $total;
		          }
		        }
				 ?>
				 <tr class="fundoTabelaTitulo">
				  <td colspan="2" class="style1"><div align="center"><b>Total:</b> </div></td>
				  <td class="style1"><?//=number_format($totalm, 2, '.', '.'); ?> <!--m²--></td>
				  <td class="style1"><!--R$--> <?//=number_format($totalv, 2, ',', '.'); ?></td>
				  <td class="style1">R$ <?=number_format($totalme, 2, ',', '.'); ?></td>
				  <td class="style1"><a href="javascript:confirmaLimpeza()" class="style7">[Esvaziar Lista]</a></td>
			   </tr>
			   <?  
				}else{
       		      //REALIZA BUSCA DO DADOS DO IMOVEL E VALOR
       		      $buscaC = mysql_query("SELECT COUNT(a.id_avaliacao) as total FROM avaliados a WHERE a.user='".$u_cod."'");
				  while($linhaC = mysql_fetch_array($buscaC)){
				       $total  += $linhaC['total'];
		 
				  }  
				  
				  $k= 1;
				  
				  $buscaIM = mysql_query("SELECT im_cod, nome_pasta FROM rebri_imobiliarias ORDER BY im_nome ASC");
				  while($linhaIM = mysql_fetch_array($buscaIM)){
				  
				  $buscaA = mysql_query("SELECT m.cod, m.ref, m.tipo_logradouro, m.end, m.numero, m.metragem, m.finalidade, m.valor, a.id_avaliacao, a.total_diarias FROM muraski m INNER JOIN avaliados a ON (m.cod=a.cod_imovel) WHERE a.user='".$u_cod."' AND m.cod_imobiliaria='".$linhaIM['im_cod']."' ORDER BY m.ref ASC");
				  while($linha = mysql_fetch_array($buscaA)){
				     $id_avaliacao = $linha['id_avaliacao'];
				     $ref = $linha['ref'];
				     $endereco = $linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero'];
				     $metragens = explode(".00", $linha['metragem']);
					 $metragem = $metragens[0];
				     $cod = $linha['cod'];
				     $valoresm = explode(".00", $linha['valor']);
					 $valorm = $valoresm[0];
					 $finalidade = $linha['finalidade'];
					 $diarias = $linha['total_diarias'];
					 
					 if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					 $k++;
					 		 
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
						/*	        
            			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$codi."'");
						$row = mysql_fetch_array($result);
						$tmp_pasta = $row['nome_pasta'];
						*/
						/*
						$pasta_fin = strtolower(substr($finalidade, 0, 4));
						if($pasta_fin == "loca"){
						*/
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
					    if(!empty($valor) && !empty($metragem))
					    {
					    	$media = ($valor / $metragem);
					    }
					    $totalmed = $totalmed + $media;

				      echo("      
				        <tr class=\"$fundo\">
				         <td width=\"7%\" class=\"style1\">
					  ");
						 
						if (file_exists($pasta.$nome_foto1))
						{
							echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
    					}
    					else
						{
							echo '<img src="images/sem_foto.gif" border="0" width="100" />';
						}
						 
						 
						 echo('</td>
				         <td width="36%" class="style1">'.$ref.' - '.$endereco.'</td>
				         <td class="style1">'.number_format($metragem, 2, '.', '.').' m²</td>
				         <td class="style1">R$ '.number_format($valor, 2, ',', '.').'</td>
				         <td class="style1">R$ '.number_format($media, 2, ',', '.').'</td>
         		         <td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$id_avaliacao.')" class="style1">[Retirar da lista]</a></div></td>
		               </tr>
		              ');
		           //REALIZA SOMA TOTAL DA METRAGEM, DO VALOR E CALCULA MEDIA TOTAL
		           $totalm = $totalm + $metragem;
				   $totalv = $totalv + $valor;
				   $totalme = $totalmed / $total;
				   }
		        }
		        ?>
		         <tr class="fundoTabelaTitulo">
				  <td colspan="2" class="style1"><div align="center"><b>Total:</b> </div></td>
				  <td class="style1"><?//=number_format($totalm, 2, '.', '.'); ?> <!--"m²--></td>
				  <td class="style1"><!--R$--> <?//=number_format($totalv, 2, ',', '.'); ?></td>
				  <td class="style1">R$ <?=number_format($totalme, 2, ',', '.'); ?></td>
				  <td class="style1"><a href="javascript:confirmaLimpeza()" class="style7">[Esvaziar Lista]</a></td>
			   </tr>
			   <?
			     
			    }
       		    ?>
       </table></td>
	</tr>
	  <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>IM&Oacute;VEIS PONDERADOS</b></div></td>
    </tr>
	<tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr class="fundoTabelaTitulo" height="25">
          <td colspan="2" class="style1"><b>Im&oacute;vel</b></td>
          <td width="19%" class="style1"><b>Metragem</b></td>
          <td width="17%" class="style1"><b>Valor</b></td>
          <td width="15%" class="style1"><b>M&eacute;dia</b></td>
        </tr>
        <?
        	if($_POST['buscar']=='1'){
			  	  $cont = 0;  
					
				  //PEGA A MEDIA DA BUSCA ANTERIOR E ACRESCENTA 20% A MAIS E 20% A MENOS
				  $porcMenos = ($totalme * 0.8);   
				  $porcMais = ($totalme * 1.2);   
				  
				  //echo "porc mais ".$porcMais."<br>";
				  //echo "porc menos ".$porcMenos."<br>";
				  
				  $k= 1;
				  
				   $buscaIM = mysql_query("SELECT i.im_cod, i.nome_pasta FROM rebri_imobiliarias i ORDER BY i.im_nome ASC");
				   while($linhaIM = mysql_fetch_array($buscaIM)){	
					 
				  //REALIZA BUSCA DO DADOS DO IMOVEL E VALOR	  	               
       		      $buscaP = mysql_query("SELECT m.cod, m.ref, m.tipo_logradouro, m.end, m.numero, m.metragem, m.valor, m.finalidade, a.total_diarias FROM muraski m INNER JOIN avaliados a ON (m.cod=a.cod_imovel) WHERE a.user='".$u_cod."' AND m.cod_imobiliaria='".$linhaIM['im_cod']."' ORDER BY m.ref ASC");
				  $totalmP = 0;
				  $totalvP = 0;
				  $totalmeP = 0;
				  while($linha = mysql_fetch_array($buscaP)){
				     $refP = $linha['ref'];
				     $enderecoP = $linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero'];
				     $metragensP = explode(".00", $linha['metragem']);
					 $metragemP = $metragensP[0];
				     $codP = $linha['cod'];
				     $valoresmP = explode(".00", $linha['valor']);
					 $valormP = $valoresmP[0];
					 $finalidade = $linha['finalidade'];
					 $diariasP = $linha['total_diarias'];
					 
					 	if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
						$k++;
				        
				        if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
					 	//REALIZA A BUSCA DO VALOR NA TABELA LOCACAO 
				     	$buscaLP = mysql_query("SELECT l_limpeza FROM locacao WHERE l_imovel='".$codP."' AND cod_imobiliaria='".$linhaIm['im_cod']."'");  
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
            			/*				      
            			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$codi."'");
						$row = mysql_fetch_array($result);
						$tmp_pasta = $row['nome_pasta'];
						*/
						/*
						$pasta_fin = strtolower(substr($finalidade, 0, 4));
						if($pasta_fin == "loca"){
						*/
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
					    if(!empty($valorP) && !empty($metragemP))
					    {
					    	$mediaP = ($valorP / $metragemP);
					    }
					     $totalmdP = $totalmdP + $mediaP;
					    
					    //echo "media ".$mediaP."<br>";
					    
					    //VERIFICA SE MEDIA ESTÁ ENTRE A MARGEM E EXIBE O ESTILO CONFORME SENTEN&Ccedil;A
						if($mediaP >= $porcMenos && $mediaP <= $porcMais){
						  $cor = "style1";
						  $contadorM = $contadorM + $mediaP;
						  if($cont==0){
							   $cont = 1; 
							}else{
							   $cont++;  
							}
						}else{
						  $cor = "style17";
						}
					   
				      echo("      
				        <tr class=\"$fundo\">
				         <td width=\"7%\"><span class=\"'.$cor.'\">
					  ");
						 
						 if (file_exists($pasta.$nome_foto1))
						{
							echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
    					}
    					else
						{
							echo '<img src="images/sem_foto.gif" border="0" width="100" />';
						}
						 
						 
						 echo('</span></td>
				         <td width="36%"><span class="'.$cor.'">'.$refP.' - '.$enderecoP.'</span></td>
				         <td><span class="'.$cor.'">'.number_format($metragemP, 2, '.', '.').' m²</span></td>
				         <td><span class="'.$cor.'">R$ '.number_format($valorP, 2, ',', '.').'</span></td>
				         <td><span class="'.$cor.'">R$ '.number_format($mediaP, 2, ',', '.').'</span></td>
		               </tr>
		              ');
		           //REALIZA SOMA TOTAL DA METRAGEM, DO VALOR E CALCULA MEDIA TOTAL
		           if($mediaP >= $porcMenos && $mediaP <= $porcMais){
				   		$totalmP = $totalmP + $metragemP;
				   		$totalvP = $totalvP + $valorP;
				   		$totalmeP = $contadorM / $cont;	
				   }
		          }	
		       }
			}else{
			      $cont = 0;
			 
				  //PEGA A MEDIA DA BUSCA ANTERIOR E ACRESCENTA 20% A MAIS E 20% A MENOS
				  $porcMenos = ($totalme * 0.8);   
				  $porcMais = ($totalme * 1.2);   
				  
				  //echo "porc mais ".$porcMais."<br>";
				  //echo "porc menos ".$porcMenos."<br>";
				  
				  $k= 1;
				  
				  $buscaIM = mysql_query("SELECT i.im_cod, i.nome_pasta FROM rebri_imobiliarias i ORDER BY i.im_nome ASC");
				  while($linhaIM = mysql_fetch_array($buscaIM)){			  
			    
					 
				   //REALIZA BUSCA DO DADOS DO IMOVEL E VALOR	  	               
       		      $buscaP = mysql_query("SELECT m.cod, m.ref, m.tipo_logradouro, m.end, m.numero, m.metragem, m.valor, m.finalidade, a.total_diarias FROM muraski m INNER JOIN avaliados a ON (m.cod=a.cod_imovel) WHERE a.user='".$u_cod."' AND m.cod_imobiliaria='".$linhaIM['im_cod']."' ORDER BY m.ref ASC");
				  $totalmP = 0;
				  $totalvP = 0;
				  $totalmeP = 0;
				  while($linha = mysql_fetch_array($buscaP)){
				     $refP = $linha['ref'];
				     $enderecoP = $linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero'];
				     $metragensP = explode(".00", $linha['metragem']);
					 $metragemP = $metragensP[0];
				     $codP = $linha['cod'];
				     $valoresmP = explode(".00", $linha['valor']);
					 $valormP = $valoresmP[0];
					 $finalidade = $linha['finalidade'];
					 $diariasP = $linha['total_diarias'];
					 
					 if (($k % 2) == 1){ $fundo='fundoTabelaCor1';}else{ $fundo='fundoTabelaCor2'; }
					 $k++;
				     
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
            			/*				      
            			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$codi."'");
						$row = mysql_fetch_array($result);
						$tmp_pasta = $row['nome_pasta'];
						*/
						/*
						$pasta_fin = strtolower(substr($finalidade, 0, 4));
						if($pasta_fin == "loca"){
						*/
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
					    if(!empty($valorP) && !empty($metragemP))
					    {
					    	$mediaP = ($valorP / $metragemP);
					    }
					    $totalmdP = $totalmdP + $mediaP;
					    
					    //echo "media ".$mediaP."<br>";
					    //echo "porcmenos ".$porcMenos."<br>";
					    //echo "porcmais ".$porcMais."<br>";
					    
						
						//VERIFICA SE MEDIA ESTÁ ENTRE A MARGEM E EXIBE O ESTILO CONFORME SENTEN&Ccedil;A
						if($mediaP >= $porcMenos && $mediaP <= $porcMais){
						  $cor = "style1";
						  $contadorM = $contadorM + $mediaP;
						  if($cont==0){
							   $cont = 1; 
							}else{
							   $cont++;  
							}
						}else{
						  $cor = "style17";
						}
					   
				      echo("      
				        <tr class=\"$fundo\">
				         <td width=\"7%\"><span class=\"'.$cor.'\">
					  ");
						  
						if (file_exists($pasta.$nome_foto1))
						{
							echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
    					}
    					else
						{
							echo '<img src="images/sem_foto.gif" border="0" width="100" />';
						}
						 
					 echo('</span></td>
				         <td width="36%"><span class="'.$cor.'">'.$refP.' - '.$enderecoP.'</span></td>
				         <td><span class="'.$cor.'">'.number_format($metragemP, 2, '.', '.').' m²</span></td>
				         <td><span class="'.$cor.'">R$ '.number_format($valorP, 2, ',', '.').'</span></td>
				         <td><span class="'.$cor.'">R$ '.number_format($mediaP, 2, ',', '.').'</span></td>
		               </tr>
		              ');
		              
		           //REALIZA SOMA TOTAL DA METRAGEM, DO VALOR E CALCULA MEDIA TOTAL
				   if($mediaP >= $porcMenos && $mediaP <= $porcMais){
				   		$totalmP = $totalmP + $metragemP;
				   		$totalvP = $totalvP + $valorP;
				   		
				   		
				   }
				}
		      }	
			}     if($cont<>'0'){
                  	$totalmeP = $contadorM / $cont;	
                  }
       		    ?>
        <tr class="fundoTabelaTitulo">
          <td colspan="2" class="style1"><div align="center"><b>Total:</b></div></td>
          <td class="style1"><?//=number_format($totalmP, 2, '.', '.'); ?> <!--m²--></td>
          <td class="style1"><!--R$--> <?//=number_format($totalvP, 2, ',', '.'); ?></td>
          <td class="style1">R$ <?=number_format($totalmeP, 2, ',', '.'); ?></td>
        </tr>
      </table></td>
	</tr>
   </form>
	<tr>
	  <td colspan="2">&nbsp;</td>
    </tr>
<?
if($menu<>'avaliacao'){
if($co_imovel<>''){
         
   
		$buscaIA = mysql_query("SELECT ref, titulo, metragem, descricao, finalidade FROM muraski WHERE cod='".$co_imovel."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
		while($linha3 = mysql_fetch_array($buscaIA)){
   	  	$finalidade = $linha3['finalidade'];
  		
		  	//VERIFICA SE EXISTE A IMAGEM
            /*
			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$codi."'");
			$row = mysql_fetch_array($result);
			$tmp_pasta = $row['nome_pasta'];
			*/
			/*
			$pasta_fin = strtolower(substr($finalidade, 0, 4));
			if($pasta_fin == "loca"){
			*/
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
	  				<td colspan=\"2\" class=\"style1\"><div align=\"center\"><b>IM&Oacute;VEL EM AVALIA&Ccedil;&Atilde;O </b></div></td>
    			</tr>
			   <tr>
	  				<td width=\"135\" class=\"style1\">
			");		  
					  
			if (file_exists($pasta.$nome_foto1))
			{
				echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
    		}
    		else
			{
				echo '<img src="images/sem_foto.gif" border="0" width="100" />';
			}
					  
			echo("		  
					  <br>Ref: ".$linha3['ref']."</td>
      				<td width=\"608\" class=\"style1\">".strip_tags($linha3['titulo'])."<br><br>".strip_tags($linha3['descricao'])."<br>Metragem: ".$linha3['metragem']." m²</td>
			   </tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\">&nbsp;</td>
    			</tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\"><b>CONCLUS&Atilde;O: O valor m&eacute;dio estimado para este im&oacute;vel &eacute; de: </b><span class=\"style7\"><b>R$ ".number_format($resultado, 2, ',', '.')."</b></span></td>
    			</tr>
    			<tr>
	  				<td colspan=\"2\"><div align=\"center\"><span class=\"style1\">
	    				<form name=\"form2\" id=\"form2\" method=\"post\" action=\"avaliacao_impressao.php\"><input type=\"button\" value=\"Visualizar\" name=\"visualizar\" id=\"visualizar\" class=\"campo3\" onClick=\"MM_openBrWindow('avaliacao_impressao.php?co_imovel=".$co_imovel."&totalme=".$totalme."&totalmeP=".$totalmeP."','','scrollbars=yes,resizable=no,width=800,height=600')\" class=\"style1\"></form>
                  <form name=\"form3\" id=\"form3\" method=\"post\" action=\"p_rel_avaliacao.php\"><input type=\"submit\" value=\"Exportar para PDF\" name=\"exportar\" id=\"exportar\" class=\"campo3\" onClick=\"form3.action='p_rel_avaliacao.php?pdf=1&co_imovel=".$co_imovel."&totalme=".$totalme."&totalmeP=".$totalmeP."';\"></form>
	  				</span></div></td>
    			</tr>
			");
   	 	}

}elseif($codi_imo<>''){
  		    	
		$buscaIA = mysql_query("SELECT m.ref, m.titulo, m.metragem, m.descricao, m.finalidade FROM muraski m WHERE m.cod='".$codi_imo."'");
		while($linha = mysql_fetch_array($buscaIA)){
   	  	$finalidade = $linha['finalidade'];
  		
		  	//VERIFICA SE EXISTE A IMAGEM
		    /*
            $result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$codi."'");
			$row = mysql_fetch_array($result);
			$tmp_pasta = $row['nome_pasta'];
			*/
			/*
			$pasta_fin = strtolower(substr($finalidade, 0, 4));
			if($pasta_fin == "loca"){
			*/
			if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
				$pasta_finalidade = "locacao_peq";
			}
			else
			{
				$pasta_finalidade = "venda_peq";
			}
			$pasta = "../imobiliarias/".$pastai."/".$pasta_finalidade."/";
			
			$nome_foto1 = $linha['ref'] . "_1_peq" . ".jpg";
	
		  
		  $resultado = $totalmeP * $linha['metragem'];
		  	  
		  	echo("
		 		<tr>
	  				<td colspan=\"2\" class=\"style1\"><div align=\"center\"><b>IM&Oacute;VEL EM AVALIA&Ccedil;&Atilde;O </b></div></td>
    			</tr>
			   <tr>
	  				<td width=\"135\" class=\"style1\">
			");	  
					  
			if (file_exists($pasta.$nome_foto1))
			{
				echo("<img border=\"0\" src=\"".$pasta.$nome_foto1."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
    		}	
    		else
			{
				echo '<img src="images/sem_foto.gif" border="0" width="100" />';
			}
					  
			echo("		  
					  <br>Ref: ".$linha['ref']."</td>
      				<td width=\"608\" class=\"style1\">".strip_tags($linha['titulo'])."<br><br>".strip_tags($linha['descricao'])."<br>Metragem: ".$linha['metragem']." m²</td>
			   </tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\">&nbsp;</td>
    			</tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\"><b>CONCLUS&Atilde;O: O valor m&eacute;dio estimado para este im&oacute;vel &eacute; de: </b><span class=\"style7\"><b>R$ ".number_format($resultado, 2, ',', '.')."</b></span></td>
    			</tr>
    			<tr>
	  				<td colspan=\"2\"><div align=\"center\"><span class=\"style1\">
	    				<form name=\"form2\" id=\"form2\" method=\"post\" action=\"avaliacao_impressao.php\"><input type=\"button\" value=\"Visualizar\" name=\"visualizar\" id=\"visualizar\" class=\"campo3\" onClick=\"MM_openBrWindow('avaliacao_impressao.php?codi_imo=".$codi_imo."&pastai=".$pastai."&totalme=".$totalme."&totalmeP=".$totalmeP."','','scrollbars=yes,resizable=no,width=800,height=600')\" class=\"style1\"></form>
                  		<form name=\"form3\" id=\"form3\" method=\"post\" action=\"p_rel_avaliacao.php\"><input type=\"submit\" value=\"Exportar para PDF\" name=\"exportar\" id=\"exportar\" class=\"campo3\" onClick=\"form3.action='p_rel_avaliacao.php?pdf=1&codi_imo=".$codi_imo."&pastai=".$pastai."&totalme=".$totalme."&totalmeP=".$totalmeP."';\"></form>
	  				</span></div></td>
    			</tr>
			");		
   	 	
		}
}else{
  			$resultado = $totalmeP * $metragems;  
   
		  	echo("
		  	   <tr>
	  				<td colspan=\"2\" class=\"style1\"><div align=\"center\"><b>IM&Oacute;VEL EM AVALIA&Ccedil;&Atilde;O </b></div></td>
    			</tr>
			   <tr>
	  				<td width=\"135\" class=\"style1\">Ref: ".$refs."</td>
      				<td width=\"608\" class=\"style1\">".$titulos."<br><br>".$descricaos."<br>Metragem: ".$metragems." m²</td>
			   </tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\">&nbsp;</td>
    			</tr>
			   <tr>
	  				<td colspan=\"2\" class=\"style1\"><b>CONCLUS&Atilde;O: O valor m&eacute;dio estimado para este im&oacute;vel &eacute; de: </b><span class=\"style7\"><b>R$ ".number_format($resultado, 2, ',', '.')."</b></span></td>
    			</tr>
    			<tr>
	  				<td colspan=\"2\"><div align=\"center\"><span class=\"style1\">
	    				<form name=\"form2\" id=\"form2\" method=\"post\" action=\"avaliacao_impressao.php\"><input type=\"button\" value=\"Visualizar\" name=\"visualizar\" id=\"visualizar\" class=\"campo3\" onClick=\"MM_openBrWindow('avaliacao_impressao.php?co_imovel=".$co_imovel."&totalme=".$totalme."&totalmeP=".$totalmeP."&refs=".$refs."&titulos=".$titulos."&descricaos=".$descricaos."&metragems=".$metragems."','','scrollbars=yes,resizable=no,width=800,height=600')\" class=\"style1\"></form>
                  		<form name=\"form3\" id=\"form3\" method=\"post\" action=\"p_rel_avaliacao.php\"><input type=\"submit\" value=\"Exportar para PDF\" name=\"exportar\" id=\"exportar\" class=\"campo3\" onClick=\"form3.action='p_rel_avaliacao.php?pdf=1&co_imovel=".$co_imovel."&totalme=".$totalme."&totalmeP=".$totalmeP."&refs=".$refs."&titulos=".$titulos."&descricaos=".$descricaos."&metragems=".$metragems."';\"></form>
	  				</span></div></td>
    			</tr>
			");
   	 	  
  
}
}
?>	
	<!--tr>
	  <td colspan="2" class="style1">Preencha o campo "metragem" e no momento que sair do campo ser&aacute; exibido o resultado</td>
    </tr>
	<tr>
	  <td colspan="2" class="style1"><b>Metragem: </b><span class="style2">
	    <input type="text" name="metragem" id="metragem" size="10" class="campo" onBlur="CalcMetragem();">
	  </span><b>X </b><?//=number_format($totalmeP, 2, ',', '.'); ?>
	  <input type="hidden" name="totalp" id="totalp" class="campo" value="<?//=$totalmeP?>">
	  = R$ <input type="text" name="resultadom" id="resultadom" class="campo" size="15" value="<?//=$resultadom?>" ReadOnly></td>
    </tr-->
	</table>
<?
mysql_close($con);
/*
	}else{
		include("login2.php");
	}
*/	
?>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("voltar.php"); ?>
    </td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td align="center" class="style1">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
</body>
</html>
<? } ?>