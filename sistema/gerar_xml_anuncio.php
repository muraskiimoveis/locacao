<?
ini_set('max_execution_time','90');
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
set_time_limit(150);
session_start();
include("conect.php");
include("funcoes/funcoes.php");

$id_anuncio = $_GET['id_anuncio'];
$exportar = $_GET['exportar'];
$tipo_exportacao = $_POST['tipo_exportacao'];
$qtd_fotos = $_POST['qtd_fotos'];	

if($tipo_exportacao=='1'){
  	if($exportar=='I'){	  
		$data_hora = date("d_m_Y_H_i_s");
		$arquivo = "anuncios_imoveis_curitiba_".$data_hora.".xml";
	}elseif($exportar=='M'){
	  	$data_hora = date("d_m_Y_H_i_s");
		$arquivo = "anuncios_minha_primeira_casa_".$data_hora.".xml";
	}
}else{
  	if($exportar=='I'){	  
  		$data_hora = date("d_m_Y_H_i_s");
		$arquivo = "ultimos_anuncios_imoveis_curitiba_".$data_hora.".xml";
	}elseif($exportar=='M'){
	  	$data_hora = date("d_m_Y_H_i_s");
		$arquivo = "ultimos_anuncios_minha_primeira_casa_".$data_hora.".xml";
	}	
}


header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: text/xml; name=$arquivo");
header ( "Content-Disposition: attachment; filename=$arquivo"); 
header ( "Content-Description: MID Gera XML" );


//header("Content-Type: application/xml; charset=ISO-8859-1");

			
			if($exportar=='I'){	
				if($tipo_exportacao=='1'){
				  		  
				
						$conteudo = '<' . '?xml version="1.0" encoding="ISO-8859-1" ?' . '>';
						$conteudo .= '<Document>';
						
					$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND a.a_imovel!='' AND (a.a_acao!='Exportou TXT IMOVEIS CURITIBA' AND a.a_acao!='Excluiu Anúncio') GROUP BY a.a_imovel");
					while($linha2 = mysql_fetch_array($busca_codigos)){

						$buscaa = mysql_query("SELECT m.ref, m.cod, t.t_nome, i.nome_pasta, m.finalidade FROM muraski m INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) WHERE m.cod='".$linha2['a_imovel']."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){
						
					
					  		if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){ 
								$pasta_finalidade = "locacao";
							}
							else
							{
								$pasta_finalidade = "venda";
							}
							
							 	$j = 1;
								for($i = 1; $i < ($qtd_fotos+5); $i++){
								 	$source_file = "../imobiliarias/".$linha['nome_pasta']."/".$pasta_finalidade."/".$linha['ref']."_".$i.".jpg";

								 	if(file_exists($source_file) && ($j <= $qtd_fotos)){
								 	  	$fotos = $linha['ref']."_".$i.".jpg";
										$extensao = explode(".", $linha['ref']."_".$i.".jpg");
										$parte2 = $extensao[0];
    									$ordem_foto = explode("_", $parte2);
						  	  
		
    									$handle = fopen($source_file,'rb');
            							$file_content = fread($handle,filesize($source_file));
   										fclose($handle);
   										$encoded = chunk_split(base64_encode($file_content));

	  									$conteudo .= "<Registro>";
	  									$conteudo .= "<Codigo>".$linha['cod']."</Codigo>";
	  									$conteudo .= "<TipoImovel>".$linha['t_nome']."</TipoImovel>";
	  									$conteudo .= "<Sequencia>".$ordem_foto[1]."</Sequencia>";
	  									$conteudo .= "<Imagem>".$encoded."</Imagem>";
	  									$conteudo .= "</Registro>";
								 	  	$j++;
								 	}
								}
						}
					}
					
					$conteudo .= '</Document>';	
					echo $conteudo;	  	
				
				}else{
				  	
				  		$conteudo = '<' . '?xml version="1.0" encoding="ISO-8859-1" ?' . '>';
						$conteudo .= '<Document>';
					  
					$busca_atualizacao = mysql_query("SELECT a.a_data, a.a_hora FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.a_acao='Exportou TXT IMOVEIS CURITIBA' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.a_data DESC, a.a_hora DESC LIMIT 0,2");
					while($linha1 = mysql_fetch_array($busca_atualizacao)){  			  	
			  			$ultima_data = $linha1['a_data'];
			  			$ultima_hora = $linha1['a_hora'];
					}			  	
			  	
					$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a LEFT JOIN imoveis_anuncio ia ON (ia.cod_imovel=a.a_imovel) WHERE ia.id_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND ((a.a_data = '$ultima_data' AND a.a_hora >= '$ultima_hora') OR (a.a_data > '$ultima_data')) AND (a.a_acao!='Exportou TXT IMOVEIS CURITIBA' AND a.a_acao!='Excluiu Anúncio' AND a.a_acao!='Inserir Imagem' AND a.a_acao!='Apagar Imagem') GROUP BY a.a_imovel");		 	
					while($linha2 = mysql_fetch_array($busca_codigos)){ 		  	

						$buscaa = mysql_query("SELECT m.ref, m.cod, t.t_nome, i.nome_pasta, m.finalidade FROM muraski m INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) WHERE m.cod='".$linha2['a_imovel']."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){
						
					
					  		if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){ 
								$pasta_finalidade = "locacao";
							}
							else
							{
								$pasta_finalidade = "venda";
							}
							
							 	$j = 1;
								for($i = 1; $i < ($qtd_fotos+5); $i++){
								 	$source_file = "../imobiliarias/".$linha['nome_pasta']."/".$pasta_finalidade."/".$linha['ref']."_".$i.".jpg";
								
								 	if(file_exists($source_file) && ($j <= $qtd_fotos)){
								 	  	$fotos = $linha['ref']."_".$i.".jpg";
										$extensao = explode(".", $linha['ref']."_".$i.".jpg");
										$parte2 = $extensao[0];
    									$ordem_foto = explode("_", $parte2);
						  	  
		
    									$handle = fopen($source_file,'rb');
            							$file_content = fread($handle,filesize($source_file));
   										fclose($handle);
   										$encoded = chunk_split(base64_encode($file_content));

	  									$conteudo .= "<Registro>";
	  									$conteudo .= "<Codigo>".$linha['cod']."</Codigo>";
	  									$conteudo .= "<TipoImovel>".$linha['t_nome']."</TipoImovel>";
	  									$conteudo .= "<Sequencia>".$ordem_foto[1]."</Sequencia>";
	  									$conteudo .= "<Imagem>".$encoded."</Imagem>";
	  									$conteudo .= "</Registro>";
								 	  	$j++;
								 	}
								}
						}   
					
				}
				
				$conteudo .= '</Document>';	
				echo $conteudo;	    
				
			}	
		}elseif($exportar=='M'){	
		  
		  	if($tipo_exportacao=='1'){
				  		  
				
						$conteudo = '<' . '?xml version="1.0" encoding="ISO-8859-1" ?' . '>';
						$conteudo .= '<Document xmlns:dt="urn:schemas-microsoft-com:datatypes">';
						
					$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND a.a_imovel!='' AND (a.a_acao!='Exportou TXT MINHA CASA' AND a.a_acao!='Excluiu Anúncio') GROUP BY a.a_imovel");
					while($linha2 = mysql_fetch_array($busca_codigos)){

						$buscaa = mysql_query("SELECT m.ref, m.cod, t.t_nome, i.nome_pasta, m.finalidade FROM muraski m INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) WHERE m.cod='".$linha2['a_imovel']."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){
						
					
					  		if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){ 
								$pasta_finalidade = "locacao";
							}
							else
							{
								$pasta_finalidade = "venda";
							}
							
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								//$codigo_imovel = '"'.$linha['cod'].'.V"'; 
								$codigo_imovel = $linha['cod'].'.V'; 
							}else{
							  	//$codigo_imovel = '"'.$linha['cod'].'"'; 
							  	$codigo_imovel = $linha['cod']; 
							}
							
							 	$j = 1;
								for($i = 1; $i < ($qtd_fotos+5); $i++){
								 	$source_file = "../imobiliarias/".$linha['nome_pasta']."/".$pasta_finalidade."/".$linha['ref']."_".$i.".jpg";

								 	if(file_exists($source_file) && ($j <= $qtd_fotos)){
								 	  	$fotos = $linha['ref']."_".$i.".jpg";
										$extensao = explode(".", $linha['ref']."_".$i.".jpg");
										$parte2 = $extensao[0];
    									$ordem_foto = explode("_", $parte2);
						  	  
		
    									$handle = fopen($source_file,'rb');
            							$file_content = fread($handle,filesize($source_file));
   										fclose($handle);
   										$encoded = chunk_split(base64_encode($file_content));

	  									$conteudo .= "<Registro>";
	  									$conteudo .= "<Codigo dt:dt=\"string\">".$codigo_imovel."</Codigo>";
	  									$conteudo .= "<TipoImovel dt:dt=\"string\">".$linha['t_nome']."</TipoImovel>";
	  									$conteudo .= "<Sequencia dt:dt=\"string\">".$ordem_foto[1]."</Sequencia>";
	  									$conteudo .= "<Imagem dt:dt=\"bin.base64\">".$encoded."</Imagem>";
	  									$conteudo .= "</Registro>";
								 	  	$j++;
								 	}
								}
						}
					}
					
					$conteudo .= '</Document>';	
					echo $conteudo;	  	
				
				}elseif($tipo_exportacao=='2'){
				  	
				  		$conteudo = '<' . '?xml version="1.0" encoding="ISO-8859-1" ?' . '>';
						$conteudo .= '<Document xmlns:dt="urn:schemas-microsoft-com:datatypes">';
					  
					$busca_atualizacao = mysql_query("SELECT a.a_data, a.a_hora FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.a_acao='Exportou TXT MINHA CASA' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.a_data DESC, a.a_hora DESC LIMIT 0,2");
					while($linha1 = mysql_fetch_array($busca_atualizacao)){  			  	
			  			$ultima_data = $linha1['a_data'];
			  			$ultima_hora = $linha1['a_hora'];
					}			  	
			  	
					$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a LEFT JOIN imoveis_anuncio ia ON (ia.cod_imovel=a.a_imovel) WHERE ia.id_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND ((a.a_data = '$ultima_data' AND a.a_hora >= '$ultima_hora') OR (a.a_data > '$ultima_data')) AND (a.a_acao!='Exportou TXT MINHA CASA' AND a.a_acao!='Excluiu Anúncio' AND a.a_acao!='Inserir Imagem' AND a.a_acao!='Apagar Imagem') GROUP BY a.a_imovel");		 	
					while($linha2 = mysql_fetch_array($busca_codigos)){ 		  	

						$buscaa = mysql_query("SELECT m.ref, m.cod, t.t_nome, i.nome_pasta, m.finalidade FROM muraski m INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) WHERE m.cod='".$linha2['a_imovel']."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){
						
					
					  		if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){ 
								$pasta_finalidade = "locacao";
							}
							else
							{
								$pasta_finalidade = "venda";
							}
							
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								//$codigo_imovel = '"'.$linha['cod'].'.V"'; 
								$codigo_imovel = $linha['cod'].'.V';
							}else{
							  	//$codigo_imovel = '"'.$linha['cod'].'"';
							  	$codigo_imovel = $linha['cod']; 
							}
							
							 	$j = 1;
								for($i = 1; $i < ($qtd_fotos+5); $i++){
								 	$source_file = "../imobiliarias/".$linha['nome_pasta']."/".$pasta_finalidade."/".$linha['ref']."_".$i.".jpg";
								
								 	if(file_exists($source_file) && ($j <= $qtd_fotos)){
								 	  	$fotos = $linha['ref']."_".$i.".jpg";
										$extensao = explode(".", $linha['ref']."_".$i.".jpg");
										$parte2 = $extensao[0];
    									$ordem_foto = explode("_", $parte2);
						  	  
		
    									$handle = fopen($source_file,'rb');
            							$file_content = fread($handle,filesize($source_file));
   										fclose($handle);
   										$encoded = chunk_split(base64_encode($file_content));

	  									$conteudo .= "<Registro>";
	  									$conteudo .= "<Codigo dt:dt=\"string\">".$codigo_imovel."</Codigo>";
	  									$conteudo .= "<TipoImovel dt:dt=\"string\">".$linha['t_nome']."</TipoImovel>";
	  									$conteudo .= "<Sequencia dt:dt=\"string\">".$ordem_foto[1]."</Sequencia>";
	  									$conteudo .= "<Imagem dt:dt=\"bin.base64\">".$encoded."</Imagem>";
	  									$conteudo .= "</Registro>";
								 	  	$j++;
								 	}
								}
						}   
					
				}
				
				$conteudo .= '</Document>';	
				echo $conteudo;	    
		    
		}elseif($tipo_exportacao=='3'){
		
		$conteudo = '<' . '?xml version="1.0" encoding="ISO-8859-1" ?' . '>';
						$conteudo .= '<Document xmlns:dt="urn:schemas-microsoft-com:datatypes">';
						
					$busca_codigos = mysql_query("SELECT a.a_imovel, a.a_acao FROM atualizacoes a WHERE a.a_anuncio='".$id_anuncio."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND a.a_imovel!='' AND (a.a_acao!='Exportou TXT MINHA CASA' AND a.a_acao!='Excluiu Anúncio') GROUP BY a.a_imovel");
					//while($linha2 = mysql_fetch_array($busca_codigos)){

						$buscaa = mysql_query("SELECT m.ref, m.cod, t.t_nome, i.nome_pasta, m.finalidade FROM muraski m INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) WHERE m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linha = mysql_fetch_array($buscaa)){
						
					
					  		if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){ 
								$pasta_finalidade = "locacao";
							}
							else
							{
								$pasta_finalidade = "venda";
							}
							
							if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
								//$codigo_imovel = '"'.$linha['cod'].'.V"'; 
								$codigo_imovel = $linha['cod'].'.V'; 
							}else{
							  	//$codigo_imovel = '"'.$linha['cod'].'"'; 
							  	$codigo_imovel = $linha['cod']; 
							}
							
							 	$j = 1;
								for($i = 1; $i < ($qtd_fotos+5); $i++){
								 	$source_file = "../imobiliarias/".$linha['nome_pasta']."/".$pasta_finalidade."/".$linha['ref']."_".$i.".jpg";

								 	if(file_exists($source_file) && ($j <= $qtd_fotos)){
								 	  	$fotos = $linha['ref']."_".$i.".jpg";
										$extensao = explode(".", $linha['ref']."_".$i.".jpg");
										$parte2 = $extensao[0];
    									$ordem_foto = explode("_", $parte2);
						  	  
		
    									$handle = fopen($source_file,'rb');
            							$file_content = fread($handle,filesize($source_file));
   										fclose($handle);
   										$encoded = chunk_split(base64_encode($file_content));

	  									$conteudo .= "<Registro>";
	  									$conteudo .= "<Codigo dt:dt=\"string\">".$codigo_imovel."</Codigo>";
	  									$conteudo .= "<TipoImovel dt:dt=\"string\">".$linha['t_nome']."</TipoImovel>";
	  									$conteudo .= "<Sequencia dt:dt=\"string\">".$ordem_foto[1]."</Sequencia>";
	  									$conteudo .= "<Imagem dt:dt=\"bin.base64\">".$encoded."</Imagem>";
	  									$conteudo .= "</Registro>";
								 	  	$j++;
								 	}
								}
						}
					//}
					
					$conteudo .= '</Document>';	
					echo $conteudo;	  
		
		}
	}

?>