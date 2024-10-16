<?
set_time_limit(0);
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


			$pasta1 = "../imobiliarias/murask/venda";
			define("INCOMING", "../imobiliarias/murask/venda/");
			define("INCOMING2", "../imobiliarias/murask/venda_peq/");

			$strDiretorio1 = $pasta1; // pasta das imagens
			$strDiretorioAbrir = opendir($strDiretorio1);

			$i = 0;
			$m = 0;
			$arquivos = array();

			while(false !== ($strArquivos = readdir($strDiretorioAbrir))) {
	 			if($strArquivos != "." && $strArquivos != "..")
	 			{	
		  			$arq[$i] = substr($strArquivos,0,$tm);
	 	  			$arq2[$i] = $strArquivos;
		  			$arqF[$i] = "venda";
	 	  			$i++;
	 			}
			}
			//echo "Total: ". count($arq2)." fotos<br>";
			//$de = $_GET[de];
			
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
				
			$foto_grande = $arq2[$i];
			//echo $foto_grande;
    
    		//Tamanho máximo da imagem grande
			$larg_max = 400;
			$alt_max = 300;
			
			//Tamanho máximo da imagem pequena
			$largp_max = 133;
			$altp_max = 100;
			
			$nome_foto = $foto_grande;
			$rest = substr($nome_foto, -4);
			$nome_foto2 = str_replace(".jpg","_peq.jpg","$nome_foto");
					 
			//Pega tamanho da imagem
			$ImageSize = GetImageSize (INCOMING.$foto_grande);
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

            if(!file_exists($dest)){
                criar_thumbnail(INCOMING.$foto_grande,$dest,$largura,'','JPEG');
            }
            if($i%1==0 && $i > 0){
		        echo "Status: $i fotos convertidas<br>";
            }

		}
        echo "$i Fotos convertidas com sucesso!";
?>