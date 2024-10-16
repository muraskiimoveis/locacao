<?/** Mplopes  2.0 - Gerenciador de Arquivos
	* Autor: Frank Sipoli
	* E-mail: frank@mplopes.com.br
	* Guaratuba, agosto de 2006
	*/
	session_start(); //session_destroy(); exit;
	$adm->dirPasta 	= ".";
	$adm->msg	= "";

	//--- Coletando o nome deste arquivo
	$adm->arq		= explode("/",str_replace("\\","/",__FILE__));	
	$adm->arq		= $adm->arq[count($adm->arq)-1];

    //echo md5("ssjournal"); exit; //usuario
    $adm->usuario = "cb2f3dcf1d719567506cdf418db81e29";
    //echo md5("publico"); exit; //senha
    $adm->senha   = "83951dcbdb9d96d2e43b8f20c3663943";

	//--- Descomente a linha a abaixo e gere um novo login criptografado
	//echo md5("meuportal"); exit; //usuario
	//echo md5("publico"); exit; //senha
//	$adm->usuario	= "08f529f30a820f6a13b4f3b8373d999d";
//	$adm->senha	= "83951dcbdb9d96d2e43b8f20c3663943";

	//--- listar arquivos e pastas
	function abrirPastaAtual(){

		// #### filtro de pastas  ####
        //$f_pastas   = array("./frank","./arquivos","./zipados","./comuns","./textos");
        //$f_pastas   = array("/frank","/arquivos","/zipados","/comuns","/textos");
        $f_pastas   = array("/");
		// #### filtro de arquivos ####
        //$f_arquivos = array("swf","fla","doc","zip","pdf","html","avi","mpeg","mpg","jpg","pps","ppt","rar","tar","exe");
		$f_arquivos = array("pdf");
		global $adm;
		$adm->lista = "";
		if(file_exists($adm->dirPasta)){
			if($dh = @opendir($adm->dirPasta)){
				while (false !== ($arquivo = @readdir($dh))) {
					if("$adm->dirPasta/$arquivo" != "./$adm->arq" && "$adm->dirPasta/$arquivo" != "./_fclose.gif" && "$adm->dirPasta/$arquivo" != "./_fopen.gif" && $arquivo != "." && $arquivo != ".." && "$adm->dirPasta/$arquivo" != "./_zip.lib.php")
				    $file[] = $arquivo;
				}
				
				//--- Ordenando vetor de files
				$file = ordenarVetor($file);
							
				for($i=0;$i<count($file);$i++){
					$arquivo = $file[$i];
					if(is_dir("$adm->dirPasta/$arquivo")){

					  // ###### aqui começa o filtro  #####
                      for ($p=0; $p < count($f_pastas); $p++)
					   {
                         //if ("$adm->dirPasta/$arquivo"==$f_pastas[$p])
						   $adm->lista["pasta"] .= "<input type='checkbox' name='v_pasta[]' value='$arquivo'><a href='?dir=$adm->dirPasta/$arquivo'><img src='_fclose.gif' border=0> $arquivo</a><br>";
					   }
                      // ##### aqui termina o filtro #####

					}else{
						$tam = @filesize("$adm->dirPasta/$arquivo");
						
						if($tam >= (1024*1024*1024)){
							$tam = sprintf("%1.1f",($tam/(1024*1024*1024)))." GB - Ult.Acesso: ".date ("d m Y H:i:s.", fileatime("$adm->dirPasta/$arquivo"));
						}elseif($tam >= (1024*1024)){
							$tam = sprintf("%1.1f",($tam/(1024*1024)))." MB - Últ.Acesso: ".date ("d m Y H:i:s.", fileatime("$adm->dirPasta/$arquivo"));
						}elseif($tam >= 1024){
							$tam = sprintf("%1.1f",($tam/1024))." KB - Últ.Acesso: ".date ("d m Y H:i:s.", fileatime("$adm->dirPasta/$arquivo"));
						}else{
							$tam = "$tam bytes - Últ.Acesso: ".date ("d m Y H:i:s.", fileatime("$adm->dirPasta/$arquivo"));
						}
                          
                        // #### aqui começa o filtro ####
						$atual = explode(".",$arquivo);
                        for ($q=0; $q < count($f_arquivos); $q++)
					     {
                           if ("$atual[1]"==$f_arquivos[$q])
						     $adm->lista["file"] .= "<input type='checkbox' name='v_file[]' value='$arquivo'><a href='$adm->dirPasta/$arquivo' target='_blank'>$arquivo <i>[$tam]</i></a> <br>";
						 }
						// #### aqui termina o filtro ####
					}	
				}
			}else{
				$adm->msg = "Erro: Não foi possível abrir o diretório \"$adm->dirPasta\"";
			}
						
		}else{
			$adm->msg = "Erro: Diretorio \"$adm->dirPasta\" não existe";
		}				
	}
	
	//--- ordenar vetot
	function ordenarVetor($v){
        for ($i=0;$i<(sizeof($v)-1);$i++)
            for ($j=($i+1);$j<sizeof($v);$j++){
              if ($v[$i]>$v[$j]){
                $aux = $v[$i];
                $v[$i]=$v[$j];
                $v[$j]=$aux;
              }

            }
            return $v;
     }
	
	//--- copiar pasta recursivamente
	function copiarPasta($pastaOrigem, $pastaDestino){
		if(($pastaOrigem != $pastaDestino) && $pastaOrigem == substr($pastaDestino,0,strlen($pastaOrigem))){
			 global $adm;
			 $adm->msg = "Erro: Não foi possível colar. Pasta de destino e origem são iguais ou detino é subpasta da origem! ";
			 return false;
		}
		if(!file_exists($pastaDestino)){
			mkdir($pastaDestino);	
		}
		if(file_exists($pastaOrigem)){
			$dh = opendir($pastaOrigem);		
			while (false !== ($arquivo = readdir($dh))){
				if($arquivo != "." && $arquivo != ".."){
					if(is_dir("$pastaOrigem/$arquivo"))
						copiarPasta("$pastaOrigem/$arquivo","$pastaDestino/$arquivo");
					else
						copy("$pastaOrigem/$arquivo","$pastaDestino/$arquivo");
				}
			}
		}
	}
	
	//--- Limpar pasta
	function limparPasta($dir){		
		$dh = opendir($dir);
		while (false !== ($file = readdir($dh))) {
			if ($file !="." && $file !=".."){
				if (is_dir($dir."/".$file)){
					limparPasta($dir."/".$file);
					rmdir($dir."/".$file);					
				}else{
					if ($dir."/".$file != "./$adm->arq"){
						unlink($dir."/".$file);						
					}
				}
			}
		}
		return true;
	}
	
	//--- Zipar pasta	
	function compactarPasta($dir,$dirZip){		
		global $zip;
		$dh = opendir($dir);
		
		while (false !== ($file = readdir($dh))) {
			if ($file !="." && $file !=".."){
				if (is_dir($dir."/".$file)){
					compactarPasta($dir."/".$file,$dirZip."/".$file);														
				}elseif ($dir."/".$file != "./$adm->arq"){						
						if($fileOpen = fopen($dir."/".$file, "r")){
							$fileRead = fread($fileOpen, filesize($dir."/".$file)+1); //string contendo o arquivo a ser compactado
							fclose($fileOpen);
						}
						
						//--- Add File for Zip
						$zip->addFile($fileRead,$dirZip."/".$file); //adiciona um arquivo ao zip

				}
			}
		}
	}
	
	if(isset($_GET["logout"])){
		unset($_SESSION["LOGIN"]);
		header("location:?");
		exit;
	}
	
	if(isset($_REQUEST["dir"])){
		$_SESSION["DIR"] = $_REQUEST["dir"];
	}
	if(isset($_SESSION["DIR"])){
		$adm->dirPasta = $_SESSION["DIR"];
		if($adm->dirPasta[0] == "/" || substr_count($adm->dirPasta,".."))
			$adm->dirPasta = ".";
	}	
	
	//--- tratando post	
	if(isset($_POST["acao"])){
		$_SESSION["POST"] = $_POST;
		if($_POST["acao"] != "enviarFile"){			
			header("location:?");exit;
		}
	}
	if(isset($_SESSION["POST"])){
		$dados = $_SESSION["POST"];
		unset($_SESSION["POST"]);		
		//------------------------------ TRATAMENTO DAS AÇÕES ---------------------------- //
		switch($dados["acao"]){
			//--- nova pasta
			case "novaPasta" :
				$novaPasta = trim($dados["temp"]);
				if (!empty($novaPasta) && !file_exists("$adm->dirPasta/$novaPasta")){
					if (@mkdir("$adm->dirPasta/$novaPasta")) 
						$adm->msg = "Pasta \"$novaPasta\" criada com sucesso!";
					else
						$adm->msg = "Erro: Problemas ao tentar criar a pasta \"$novaPasta\"!";;	
			    }else
			    	$adm->msg = "Erro: Nome de pasta inválido!";
				  break;
				  
			case "excluirPasta" :
					for($i=0;is_array($dados["v_pasta"]) && $i<count($dados["v_pasta"]);$i++){
						if (limparPasta($adm->dirPasta."/".$dados["v_pasta"][$i]) && (@rmdir($adm->dirPasta."/".$dados["v_pasta"][$i]))) 
							$adm->msg .= "pasta \"".$dados["v_pasta"][$i]."\" excluída. ";
						else
							$adm->msg .= "Erro: \"".$dados["v_pasta"][$i]."\" NÃO EXCLUÍDA. ";
					}					
				  break;
				  
			case "renomearPasta" :
					$renome = "".trim($dados["temp"]);
					if (count($dados["v_pasta"]) == 1 && strlen($renome)>0){
						if(@rename("$adm->dirPasta/".$dados["v_pasta"][0],"$adm->dirPasta/".$renome) )
							$adm->msg = "A pasta \"".$dados["v_pasta"][0]."\" foi renomeada para \"$renome\"";
						else
							$adm->msg = "Erro: Problemas ao tentar renomear a pasta \"".$dados["v_pasta"][0]."\"";
					}else
						$adm->msg = "Erro: Selecione somente um item para renomear";
				  break;
				  
			case "copiarPasta" :
					if (count($dados["v_pasta"]) > o)
						$adm->msg = "Dados armazenados na área de transferência!";
					for($i=0;is_array($dados["v_pasta"]) && $i<count($dados["v_pasta"]);$i++){					
						$_SESSION["COPIA"]["NOME"][$i] = $dados["v_pasta"][$i];
						$_SESSION["COPIA"]["DIR"] = $adm->dirPasta;					
					}
				  break;
			
			case "colarPasta" :
					if(isset($_SESSION["COPIA"])){
						for($i=0;$i<count($_SESSION["COPIA"]["NOME"]);$i++){
							$orig = $_SESSION["COPIA"]["DIR"]."/".$_SESSION["COPIA"]["NOME"][$i];
							$dest = $adm->dirPasta."/".$_SESSION["COPIA"]["NOME"][$i];							
							$adm->msg .= "Cópia realizada! $orig -> $adm->dirPasta. ";					
							copiarPasta($orig,$dest);
						}
						unset($_SESSION["COPIA"]);
					}else{
						$adm->msg = "Erro: Não há conteúdo na área de transferência.";
					}
				  break;
				  
			case "compactarPasta" :
					if(is_array($dados["v_pasta"]) && count($dados["v_pasta"])>0){
						
						include "_zip.lib.php";
						
						for($i=0; $i<count($dados["v_pasta"]);$i++){
													
							$adm->pastaZip = $adm->dirPasta."/".$dados["v_pasta"][$i];
							$adm->nomeZip  = $adm->dirPasta."/".$dados["v_pasta"][$i].".zip";
							$zip= new zipfile;	
							
							compactarPasta($adm->pastaZip,$dados["v_pasta"][$i]);
							
							$adm->msg .= "pasta \"".$dados["v_pasta"][$i]."\" compactada. ";
							
							$strzip = $zip->file();
								
							$abre = fopen($adm->nomeZip, "w");
							$salva = fwrite($abre, $strzip);
							fclose($abre);
						}
					}					
				  break;
			
			//--- ----------- FILES ---------------------------------------------------------------
			case "renomearFile" :
					$renome = "".trim($dados["temp"]);
					if (count($dados["v_file"]) == 1 && strlen($renome)>0){
						if(@rename("$adm->dirPasta/".$dados["v_file"][0],"$adm->dirPasta/".$renome) )
							$adm->msg = "O Arquivo \"".$dados["v_file"][0]."\" foi renomeado para \"$renome\"";
						else
							$adm->msg = "Erro: Problemas ao tentar renomear o arquivo \"".$dados["v_file"][0]."\"";
					}else
						$adm->msg = "Erro: Selecione somente um item para renomear";
				  break;
			
			case "copiarFile" :
					if (count($dados["v_file"]) > 0)
						$adm->msg = "Dados armazenados na área de transferência!";
					for($i=0;is_array($dados["v_file"]) && $i<count($dados["v_file"]);$i++){					
						$_SESSION["FILE"]["NOME"][$i] = $dados["v_file"][$i];
						$_SESSION["FILE"]["DIR"] = $adm->dirPasta;					
					}
				  break;
			
			case "colarFile" :
					if(isset($_SESSION["FILE"])){
						for($i=0;$i<count($_SESSION["FILE"]["NOME"]);$i++){
							$orig = $_SESSION["FILE"]["DIR"]."/".$_SESSION["FILE"]["NOME"][$i];
							$dest = $adm->dirPasta."/".$_SESSION["FILE"]["NOME"][$i];												
							if(copy($orig,$dest))
								$adm->msg .= "Cópia realizada! $orig -> $adm->dirPasta. ";
						}
						unset($_SESSION["FILE"]);
					}else{
						$adm->msg = "Erro: Não há conteúdo na área de transferência.";
					}
				  break;
			
			case "excluirFile" :
					for($i=0;is_array($dados["v_file"]) && $i<count($dados["v_file"]);$i++){
						if (@unlink($adm->dirPasta."/".$dados["v_file"][$i]) ) 
							$adm->msg .= "arquivo \"".$dados["v_file"][$i]."\" excluído. ";
						else
							$adm->msg .= "Erro: \"".$dados["v_file"][$i]."\" NÃO EXCLUÍDO. ";
					}					
				  break;
			
			case "enviarFile" :		 
					if(isset($_FILES["uploadFile"])){						
						$arqTmp = $_FILES["uploadFile"]["tmp_name"];
				        $arqName = $_FILES["uploadFile"]["name"];
				        			        
				        if(copy($arqTmp,$adm->dirPasta."/".$arqName)){
				            unlink($arqTmp);
				            $adm->msg = "Arquivo \"$arqName\" carregado com sucesso!";
				        }else{
				        	$adm->msg = "Erro: não foi possível carregar o arquivo!";
				        }
					}
				  break;
				  
			case "descompactarFile" :
					for($i=0;is_array($dados["v_file"]) && $i<count($dados["v_file"]);$i++){
						if (substr(strtolower($adm->dirPasta."/".$dados["v_file"][$i]),-3)=="zip" && exec("unzip $adm->dirPasta/".$dados["v_file"][$i]." -d $adm->dirPasta/")) 
							$adm->msg .= "arquivo \"".$dados["v_file"][$i]."\" Descompactado. ";
						else
							$adm->msg .= "Erro: \"".$dados["v_file"][$i]."\" NÃO DESCOMPACTADO. ";
					}					
				  break;
			
			case "novoFile" :
					$adm->file = "";
				  break;
			
			case "abrirFile" :
					if(count($dados["v_file"])==1){
						$adm->nomeFile = $dados["v_file"][0];
						$adm->file = implode(file($adm->dirPasta."/".$dados["v_file"][0]));
						$adm->file = htmlspecialchars($adm->file);
						$adm->msg = "Arquivo carregado!";
					}else{
						$adm->msg = "Erro: Você deve selecionar um arquivo";
					}
				  break;
			
			case "salvarFile" :
					$adm->nomeFile = $dados["nomeFile"];
					$adm->file = stripslashes($dados["texto_file"]);
					if($file = @fopen($adm->dirPasta."/".$adm->nomeFile,"w")){
						if(@fwrite($file,$adm->file)){
							$adm->msg = "Arquivo salvo!";
						}else{
							$adm->msg = "Erro: Não foi possível sarlvar o Arquivo!";
						}
						fclose($file);	
						
					}else{
						$adm->msg = "Erro: Não foi possível abrir o arquivo para salvar!";
					}
					$adm->file = htmlspecialchars($adm->file);
				  break;					
			case "up" :
					$adm->dirPasta = dirname($adm->dirPasta);
				  break;
			case "login" :
					if($adm->usuario == md5($dados["usuario"]) && $adm->senha == md5($dados["senha"]))
						$_SESSION["LOGIN"] = true;					
				  break;
		}
	}
	
	if(!isset($adm->file))
		abrirPastaAtual();
	//$adm->file = "";
?>
<html>
<head>
<title>Muraski - Gerenciador de Arquivos</title>
<style>
	*{
		font-family:Arial, Helvetica, sans-serif;
		font-size:11px;
		color:#111111;
	}
	body{
		background:#F0EEE4;
	}
	a{
		text-decoration:none;
	}
	a:hover{
		text-decoration:underline;
		color:#0000FF;
	}
	.cabecalho{
		height:30px;		
		background-color:#d8d8d8;
		font-size:18px;
		font-weight:bold;
	}
	.cabecalho2{
		height:30px;		
		background-color:#d8d8d8;		
	}
	.navegacao{
		height:40;
		;background-color:#b7b7ff;
		background-color:#FF0000;		
	}
	.mensagem{  
		height:30;		
		;background-color:#8080c0;
		background-color:#FFFFFF;		
	}
	.mensagem i{		
		color:#ffffff;
	}
	.rodape{
		height:20px;
		font-size:9px;
		color:#ffffff;
		;background-color:#8080c0;
		background-color:#FF0000;
	}
	.label{
		font-size:10px;
	}
	.campo{
		border:1px #111111 solid;
	}	
	.titulo{
		font-size:18px;
		font-weigth:bold;
	}	
	textarea{		
		background:#ffffff;		
		color:#000000;
		font-size:13px;
	}
	.campo2, .campo2 *{
		height:15px;
		font-size:9px;
		text-align:center;
		border:1px #111111 solid;
	}
</style
</head>
<script language="javaScript">
	function novaPasta(){		
		var resp = prompt("Digite o nome da pasta sem espaços em branco","nova_pasta");		
		if(resp != null && resp != ""){
			document.f.acao.value="novaPasta";
			document.f.temp.value=resp;			
			document.f.submit();
		}else{
			document.f.temp.value="";
		}
	}
	
	function excluirItem(acao){					
		if(confirm("Atenção! Você não poderá dezfazer essa operação.\nDeseja realmente excluir todos os itens selecionados?")){	
			document.f.acao.value = acao;	
			document.f.submit();
		}
	}
	
	function renomearItem(acao){					
		var resp = prompt("Renomear arquivo selecionado","");	
		if(resp != null && resp != ""){
			document.f.acao.value = acao;
			document.f.temp.value=resp;	
			document.f.submit();
		}
	}
	
	function addAcao(acao){
		document.f.acao.value = acao;			
		document.f.submit();
	}
</script>
<body style="margin:0px; padding:0px;">

<?//if(!isset($_SESSION["LOGIN"])){?>
<!--
	<table height=100% align="center" border=0>
	<form name="f" method="post">
	<input type="hidden" name="acao" value="login">	
	<tr>
		<td align=center valign=center>
			<b><u style="font-size:15px;">Autenticacao</u></b><br><br>
			Usuario:<br>
		  	<input type="text" name="usuario"><br>

		  	Senha:<br> 	
		  	<input type="password" name="senha"><br><br>
		  	<input type="submit" value="Login">		  	
		  </td>
	</tr>	
	</form>
</table>
-->
<?//}else{?>

	<table width="100%" height="100%" align="center" border=0 cellpadding=0 cellspacing=0>
		<form name="f" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="acao" value="">
		<input type="hidden" name="temp" value="">		
		<tr>
			<td class="cabecalho" width="350">&nbsp;Muraski - Gerenciador de Arquivos</td>
			<td class="cabecalho2">
				<a href="?dir=.">Início</font></a> |
				<a href="?">Atualizar</a> |
                <a href="javascript:history.back()">Voltar</a> |                
                <a href="javascript:history.forward()">Avancar</a> |
                <a href="#" onClick="document.f.acao.value='up';document.f.submit();">Acima</a> |
                <a href="../index.php">Sair</a>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="navegacao">
                <img src="_fopen.gif" border="0">
                <input class="campo" name="dir" value="<?echo$adm->dirPasta;?>" size="70">
                <input type="button" class="campo" onClick="addAcao('ir')" value="ir">
             </td>
      	</tr>
      	<tr>
			<td colspan="2" class="mensagem">&nbsp;<b>Mensagem:</b> <i><?echo $adm->msg;?></i></td>
      	</tr>
		<tr>
			<td colspan="2">
			<?if(isset($adm->lista)){?>
				<table width="100%" height="100%" border=0 cellspacing=0>
					<tr>						
						<td bgcolor="#c0c0c0" height="23">
							<input class="campo" type="button" onClick="novaPasta();" value="Novo">							
							<input class="campo" type="button" onClick="renomearItem('renomearPasta');" value="Renomear">
							<input class="campo" type="button" onClick="addAcao('copiarPasta');" value="Copiar">							
							<input class="campo" type="button" onClick="addAcao('colarPasta');" value="Colar">
							<input class="campo" type="button" onClick="excluirItem('excluirPasta');" value="Excluir">
<!--							<input class="campo" type="button" onClick="addAcao('compactarPasta');" value="Compactar [zip]"> -->
						</td>						
					</tr>
					<tr>
						<td valign="top"><?echo $adm->lista["pasta"]?>&nbsp;</td>
					</tr>
					<tr>
						<td bgcolor="#c0c0c0" height="23">
							<input class="campo" type="button" onClick="addAcao('novoFile');" value="Novo">													
							<input class="campo" type="button" onClick="renomearItem('renomearFile');" value="Renomear">
							<input class="campo" type="button" onClick="addAcao('abrirFile')" value="Abrir">							
							<input class="campo" type="button" onClick="addAcao('copiarFile');" value="Copiar">							
							<input class="campo" type="button" onClick="addAcao('colarFile');" value="Colar">						
							<input class="campo" type="button" onClick="excluirItem('excluirFile');" value="Excluir">
<!--							<input class="campo" type="button" onClick="addAcao('descompactarFile');" value="Descompactar [zip]"> -->
							upload 
							<input class="campo" type="file" name="uploadFile">														
							<input class="campo" type="button" onClick="addAcao('enviarFile');" value="Enviar">
						</td>
					</tr>
					<tr>
						<td valign="top"><?echo $adm->lista["file"]?>&nbsp;</td>
					</tr>
				</table>
			<?}elseif(isset($adm->file)){?>
				<table width="100%" height="100%" border=0 cellspacing=0>
					<tr>
						<td height="23" bgcolor="#c0c0c0" align="center">
							<?if($adm->nomeFile != ""){?>
								<input class="campo" type="hidden" name="nomeFile" value="<?echo$adm->nomeFile;?>">
								<div class='titulo'><?echo$adm->nomeFile;?></div>								
							<?}else{?>
								Nome do arquivo: <input class="campo" type="text" name="nomeFile" value="documento.php">								
							<?}?>				
						</td>
					</tr>
					<tr>
						<td align="center" valign="top">
							<textarea class="campo" name="texto_file" rows="18" cols="100"><?echo $adm->file;?></textarea>
							<br>
							<input class="campo" type="button" onClick="addAcao('salvarFile');" value="Salvar">
							<input class="campo" type="reset" value="Resetar">
							<input class="campo" type="button" onClick="addAcao('sair');" value="Sair">
						</td>
					</tr>					
				</table>
			<?}?>
			&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" class="rodape" align=center><a class="rodape" href="mailto:franksipoli@ssjournal.com">GNU 2005 - <?echo date("Y");?> - SOFTWARE LIVRE - Contribuicao: Frank Sipoli</a></td>
		</tr>
	</form>
	</table>
<?//}?>
</body>
</html>
