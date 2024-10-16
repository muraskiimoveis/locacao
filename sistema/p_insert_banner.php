<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_BANNER");
include("style.php");

function retira_acentos( $name )
{
  $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
                     , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"
                     ,"'","´","`","/","\\","~","^","¨"," ");
  $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C"
                     ,"","","","","_","_","_","_","");
  return urlencode(strtolower(str_replace( $array1, $array2, $name )));
}

$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
$row = mysql_fetch_array($result);
	$tmp_pasta = $row['nome_pasta'];
	$caminho_banner_site = "../imobiliarias/".$tmp_pasta."/banner_site/";


?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(b_cod)
{
       if(confirm("Tem certeza que deseja excluir?"))
          document.location.href='p_insert_banner.php?b_cod=' + b_cod + '&B1=Apagar Banner';
}

function VerificaCampo(){
	if(document.form1.b_nome.value=="")
	{
		alert( "Preencha o campo Nome!" );
		document.form1.b_nome.focus();
		document.form1.b_nome.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
	 	document.form1.b_nome.style.backgroundColor = '#FFFFFF';
	}
    
	if(document.form1.b_link.value != "")
  	{
		if(document.form1.b_target.selectedIndex == 0)
		{
			alert( "Selecione o campo Janela link!" );
			document.form1.b_target.focus();
			document.form1.b_target.style.backgroundColor = '#FF727B';
			return false;
		}
		else
		{
	 		document.form1.b_target.style.backgroundColor = '#FFFFFF';
		}
	}
	
	if(document.form1.b_tipo_arquivo.selectedIndex== 0)
	{
		alert( "Selecione o campo Tipo de Arquivo!" );
		document.form1.b_tipo_arquivo.focus();
		document.form1.b_tipo_arquivo.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
		document.form1.b_tipo_arquivo.style.backgroundColor = '#FFFFFF';
	}

	if(document.form1.b_img_n.value=="")
	{
		alert( "Selecione o campo Imagem!" );
		document.form1.b_img_n.focus();
		document.form1.b_img_n.style.backgroundColor = '#FF727B';
		return false;
	}
	else if(document.form1.b_img_n.value!="")
	{
										
		arquivo = (document.form1.b_img_n.value);
		tipo = arquivo.substring(arquivo.length-4,arquivo.length);
		tipo = tipo.toLowerCase();
						
		if (tipo != ".png" && tipo != ".jpg" && tipo != ".jpeg" && tipo != ".gif" && tipo != ".swf")
		{
		  	alert("Formato não permitido!");
	   		document.form1.b_img_n.focus();
	   		document.form1.b_img_n.style.backgroundColor = '#FF727B';
			return false;
		}
		else if (document.form1.b_tipo_arquivo.value=="Flash")
		{
			if (tipo != ".swf")
			{
				alert( "Selecione o campo Imagem como um arquivo do tipo Flash pois você selecionou o Tipo de Arquivo como Flash!" );
				document.form1.b_img_n.focus();
				document.form1.b_img_n.style.backgroundColor = '#FF727B';
				return false;
			}
			else
			{
	 			document.form1.b_img_n.style.backgroundColor = '#FFFFFF';
			}
			
			if(document.form1.b_width.value == "")
  			{
    			alert( "Preencha o campo Largura!" );
				document.form1.b_width.focus();
				document.form1.b_width.style.backgroundColor = '#FF727B';
				return false;
			}
			else
			{
				document.form1.b_width.style.backgroundColor = '#FFFFFF';
			}
	  			
			if (document.form1.b_height.value == "")
  			{
    			alert( "Preencha o campo Altura!" );
				document.form1.b_height.focus();
				document.form1.b_height.style.backgroundColor = '#FF727B';
				return false;
			}
			else
			{
				document.form1.b_height.style.backgroundColor = '#FFFFFF';
			}
		}
		else if (document.form1.b_tipo_arquivo.value=="JPG,PNG,GIF")
		{
			if (tipo != ".png" && tipo != ".jpg" && tipo != ".jpeg" && tipo != ".gif")
			{
				alert( "Selecione o campo Imagem como um arquivo do tipo JPG ou PNG ou GIF pois você selecionou o Tipo de Arquivo como JPG,PNG,GIF!" );
				document.form1.b_img_n.focus();
				document.form1.b_img_n.style.backgroundColor = '#FF727B';
				return false;
			}
			else
			{
				document.form1.b_img_n.style.backgroundColor = '#FFFFFF';
			}
		}
		else
		{
	  		document.form1.b_img_n.style.backgroundColor = '#FFFFFF';
		}
	}
	
	if(document.form1.b_setor.selectedIndex == 0)
	{
		alert( "Selecione o campo Setor!" );
		document.form1.b_setor.focus();
		document.form1.b_setor.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
		document.form1.b_setor.style.backgroundColor = '#FFFFFF';
	}
	
	if(document.form1.b_ordem.selectedIndex == 0)
	{
		alert( "Selecione o campo Ordem!" );
		document.form1.b_ordem.focus();
		document.form1.b_ordem.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
		document.form1.b_ordem.style.backgroundColor = '#FFFFFF';
	}
		
	if (document.form1.b_ativo.selectedIndex == 0)
	{
		alert( "Selecione se é Ativo ou Não!" );
		document.form1.b_ativo.focus();
		document.form1.b_ativo.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
	 	document.form1.b_ativo.style.backgroundColor = '#FFFFFF';
	}
    
document.form1.cadastra.value='1';
document.form1.submit();
return true;
}

function VerificaCampo2(){
	if(document.form1.b_nome.value=="")
	{
		alert( "Preencha o campo Nome!" );
		document.form1.b_nome.focus();
		document.form1.b_nome.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
	 	document.form1.b_nome.style.backgroundColor = '#FFFFFF';
	}
    
	if (document.form1.b_link.value != "")
  	{
		if (document.form1.b_target.selectedIndex == 0)
		{
			alert( "Selecione o campo Janela link!" );
			document.form1.b_target.focus();
			document.form1.b_target.style.backgroundColor = '#FF727B';
			return false;
		}
		else
		{
	 		document.form1.b_target.style.backgroundColor = '#FFFFFF';
		}
	}

	if(document.form1.b_img_n.value!="")
	{							
		arquivo = (document.form1.b_img_n.value);
		tipo = arquivo.substring(arquivo.length-4,arquivo.length);
		tipo = tipo.toLowerCase();
						
		if (tipo != ".png" && tipo != ".jpg" && tipo != ".jpeg" && tipo != ".gif" && tipo != ".swf")
		{
		  	alert("Formato não permitido!");
	   		document.form1.b_img_n.focus();
	   		document.form1.b_img_n.style.backgroundColor = '#FF727B';
			return false;
		}
		else if (document.form1.b_tipo_arquivo.value=="Flash")
		{
			if (tipo != ".swf")
			{
				alert( "Selecione o campo Imagem como um arquivo do tipo Flash pois você selecionou o Tipo de Arquivo como Flash!" );
				document.form1.b_img_n.focus();
				document.form1.b_img_n.style.backgroundColor = '#FF727B';
				return false;
			}
			else
			{
	 			document.form1.b_img_n.style.backgroundColor = '#FFFFFF';
			}
				  
			if (document.form1.b_width.value == "")
  	  		{
    			alert( "Preencha o campo Largura!" );
				document.form1.b_width.focus();
				document.form1.b_width.style.backgroundColor = '#FF727B';
				return false;
			}
			else
			{
	 			document.form1.b_width.style.backgroundColor = '#FFFFFF';
			}
	  			
			if (document.form1.b_height.value == "")
  	  		{
    			alert( "Preencha o campo Altura!" );
				document.form1.b_height.focus();
				document.form1.b_height.style.backgroundColor = '#FF727B';
				return false;
			}
			else
			{
	 			document.form1.b_height.style.backgroundColor = '#FFFFFF';
			}
		}
		else if (document.form1.b_tipo_arquivo.value=="JPG,PNG,GIF")
		{
			if (tipo != ".png" && tipo != ".jpg" && tipo != ".jpeg" && tipo != ".gif")
			{
				alert( "Selecione o campo Imagem como um arquivo do tipo JPG ou PNG ou GIF pois você selecionou o Tipo de Arquivo como JPG,PNG,GIF!" );
				document.form1.b_img_n.focus();
				document.form1.b_img_n.style.backgroundColor = '#FF727B';
				return false;
			}
			else
			{
	 			document.form1.b_img_n.style.backgroundColor = '#FFFFFF';
			}
		}
		else
		{
		  	document.form1.b_img_n.style.backgroundColor = '#FFFFFF';
		}
	}
	
	if (document.form1.b_setor.selectedIndex == 0)
	{
		alert( "Selecione o campo Setor!" );
		document.form1.b_setor.focus();
		document.form1.b_setor.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
		document.form1.b_setor.style.backgroundColor = '#FFFFFF';
	}
	
	if(document.form1.b_ordem.selectedIndex == 0)
	{
		alert( "Selecione o campo Ordem!" );
		document.form1.b_ordem.focus();
		document.form1.b_ordem.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
		document.form1.b_ordem.style.backgroundColor = '#FFFFFF';
	}
	
	if (document.form1.b_ativo.selectedIndex == 0)
	{
		alert( "Selecione se é Ativo ou Não!" );
		document.form1.b_ativo.focus();
		document.form1.b_ativo.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
	 	document.form1.b_ativo.style.backgroundColor = '#FFFFFF';
	}
    
document.form1.altera.value='1';
document.form1.submit();
return true;
}
</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<script src="AC_RunActiveContent.js" type="text/javascript"></script>
<script src="AC_ActiveX.js" type="text/javascript"></script>
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
	$b_nome = $_POST['b_nome'];
	$b_target = $_POST['b_target'];
	$b_setor = $_POST['b_setor'];
	$b_ativo = $_POST['b_ativo'];
	$b_tipo_arquivo = $_POST['b_tipo_arquivo'];
	$b_ordem = $_POST['b_ordem'];
	
	if($_POST['b_cod'] == ''){
		$b_cod = $_GET['b_cod'];
	}elseif($_GET['b_cod'] == ''){
		$b_cod = $_POST['b_cod'];
	}
	
	if($_POST['b_link']<>''){
  		if(substr($_POST['b_link'],0, 7) <> 'http://'){
  	    	$b_link = 'http://'.$_POST['b_link'];
  	    }else{
		   	$b_link = $_POST['b_link'];
	    }
    }

	if($_POST['b_width'] <> '' || $_POST['b_width'] <> 0){
	  $b_width = $_POST['b_width'];
	}else{
	  $b_width = '';
	}
	if($_POST['b_height'] <> '' || $_POST['b_height'] <> 0){
	  $b_height = $_POST['b_height'];
	}else{
	  $b_height = '';
	}

if($_POST['cadastra']=='1')
{
   		
	preg_match("/\.(png|jpg|jpeg|gif|swf){1}$/i", $_FILES['b_img_n']['name'], $ext);

	if ($ext[1] <> ''){
  
  		define("INCOMING", $caminho_banner_site);
	
  		$arquivo_novo = retira_acentos($_FILES['b_img_n']['name']);

  		move_uploaded_file($_FILES['b_img_n']['tmp_name'], INCOMING.${arquivo_novo});
	
  		$ImageSize = GetImageSize (INCOMING.${arquivo_novo});
  		$Img_w = $ImageSize[0];
  		$Img_h = $ImageSize[1];
  		
		  	if($_POST['b_width'] <> '' || $_POST['b_width'] <> 0){
	  			$Img_w = $_POST['b_width'];
			}else{
	  			$Img_w = $Img_w;
			}
  	
			if($_POST['b_height'] <> '' || $_POST['b_height'] <> 0){
	  			$Img_h = $_POST['b_height'];
			}else{
	  			$Img_h = $Img_h;
			}
		
		if(($Img_w == 200) and ($Img_h == 70) and ($b_setor <> "Tamanho 1"))
		{
		  @unlink($caminho_banner_site.$arquivo_novo);
		  echo '<script language="javascript">alert("O arquivo que você selecionou não se enquadra no tamanho do setor selecionado!");</script>';
		}
		elseif(($Img_w == 200) and ($Img_h == 140) and ($b_setor <> "Tamanho 2"))
		{
		  @unlink($caminho_banner_site.$arquivo_novo);
		  echo '<script language="javascript">alert("O arquivo que você selecionou não se enquadra no tamanho do setor selecionado!");</script>';
		}
		elseif(($Img_w == 200) and ($Img_h == 210) and ($b_setor <> "Tamanho 3"))
		{
		  @unlink($caminho_banner_site.$arquivo_novo);
		  echo '<script language="javascript">alert("O arquivo que você selecionou não se enquadra no tamanho do setor selecionado!");</script>';
		}
		elseif((($b_setor == "Tamanho 1") and ($Img_w <> 200) and ($Img_h <> 70)) or (($b_setor == "Tamanho 2") and ($Img_w <> 200) and ($Img_h <> 140)) or (($b_setor == "Tamanho 3") and ($Img_w <> 200) and ($Img_h <> 210)))
  		{
			@unlink($caminho_banner_site.$arquivo_novo);
			echo '<script language="javascript">alert("O arquivo que você tentou enviar não se enquadra no tamanho do setor selecionado!");</script>';
  		}
  		else
  		{

    		$query1 = "SELECT b_nome FROM banners_site WHERE (b_nome='".$b_nome."' or b_img='".$arquivo_novo."') AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
  			$result1 = mysql_query($query1);
  			$numrows1 = mysql_num_rows($result1);
  			if($numrows1 > 0){
     
     			echo '<script language="javascript">alert("Já existe um banner cadastrado com este nome!");</script>';
     
        	}else{
        	  
        	  	$query0  = "INSERT INTO banners_site (cod_imobiliaria, b_nome, b_link, b_target, b_img, b_setor, b_ativo, b_height, b_width, b_ordem, b_tipo_arquivo) values ('".$_SESSION['cod_imobiliaria']."','".$b_nome."', '".$b_link."', '".$b_target."', '".$arquivo_novo."', '".$b_setor."', '".$b_ativo."', '".$b_height."', '".$b_width."', '".$b_ordem."', '".$b_tipo_arquivo."')";
  				$result0 = mysql_query($query0) or die("Não foi possível inserir suas informações. $query0 <BR>".mysql_error());

		    	echo '<script language="javascript">alert("Banner cadastrado com sucesso!");document.location.href="p_insert_banner.php";</script>';
	    	}
  		}
  	}else{
		echo '<script language="javascript">alert("Formato não permitido!");</script>';
	}   
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT b_cod, b_nome, b_link, b_target, b_img, b_setor, b_ativo, b_height, b_width, b_ordem, b_tipo_arquivo FROM banners_site WHERE b_cod='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $b_cod = $linha['b_cod'];
       $b_nome = $linha['b_nome'];
       $b_link = $linha['b_link'];
       $b_target = $linha['b_target'];
       $b_img = $linha['b_img'];
       $b_setor = $linha['b_setor'];
       $b_ativo = $linha['b_ativo'];
       $b_height = $linha['b_height'];
       $b_width = $linha['b_width'];
       $b_ordem = $linha['b_ordem'];
       $b_tipo_arquivo = $linha['b_tipo_arquivo'];
       
       $imgfb = explode(".", $b_img);
	   $extfb = $imgfb[1];
	   $b_imgfb = $caminho_banner_site.$imgfb[0];
    }
}

if($_POST['altera']=='1')
{

  	if($_FILES['b_img_n']['name'] != "")        
  	{
  		preg_match("/\.(png|jpg|jpeg|gif|swf){1}$/i", $_FILES['b_img_n']['name'], $ext);

		if ($ext[1] <> ''){

			@unlink($caminho_banner_site.$_POST['b_img']);

  			define("INCOMING", $caminho_banner_site);

			$arquivo_novo = retira_acentos($_FILES['b_img_n']['name']);

			move_uploaded_file($_FILES['b_img_n']['tmp_name'], INCOMING.${arquivo_novo});

  			$ImageSize = GetImageSize (INCOMING.${arquivo_novo});
  			$Img_w = $ImageSize[0];
  			$Img_h = $ImageSize[1];
  			
  			if(($Img_w == 200) and ($Img_h == 70) and ($b_setor <> "Tamanho 1"))
			{
		  		@unlink($caminho_banner_site.$arquivo_novo);
		  		echo '<script language="javascript">alert("O arquivo que você selecionou não se enquadra no tamanho do setor selecionado!");</script>';
			}
			elseif(($Img_w == 200) and ($Img_h == 140) and ($b_setor <> "Tamanho 2"))
			{
		  		@unlink($caminho_banner_site.$arquivo_novo);
		  		echo '<script language="javascript">alert("O arquivo que você selecionou não se enquadra no tamanho do setor selecionado!");</script>';
			}
			elseif(($Img_w == 200) and ($Img_h == 210) and ($b_setor <> "Tamanho 3"))
			{
		  		@unlink($caminho_banner_site.$arquivo_novo);
		  		echo '<script language="javascript">alert("O arquivo que você selecionou não se enquadra no tamanho do setor selecionado!");</script>';
			}
			elseif((($b_setor == "Tamanho 1") and ($Img_w <> 200) and ($Img_h <> 70)) or (($b_setor == "Tamanho 2") and ($Img_w <> 200) and ($Img_h <> 140)) or (($b_setor == "Tamanho 3") and ($Img_w <> 200) and ($Img_h <> 210)))
  			{
	  			@unlink($caminho_banner_site.$arquivo_novo);
	  			echo '<script language="javascript">alert("O arquivo que você tentou enviar não se enquadra no tamanho do setor selecionado!");</script>';
  			}
  			else
  			{
  			
			$query1 = "SELECT b_nome FROM banners_site WHERE (b_nome='".$b_nome."' or b_img='".$arquivo_novo."') and (b_cod!='".$b_cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."')";
  			$result1 = mysql_query($query1);
  			$numrows1 = mysql_num_rows($result1);
  			if($numrows1 == 0){
  			
    			$query0 = "UPDATE banners_site SET b_nome='".$b_nome."', b_link='".$b_link."', b_target='".$b_target."', b_img='".$arquivo_novo."', b_height='".$b_height."', b_width='".$b_width."', b_setor='".$b_setor."', b_ordem='".$b_ordem."', b_ativo='".$b_ativo."', b_tipo_arquivo='".$b_tipo_arquivo."' WHERE b_cod='".$b_cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result0 = mysql_query($query0) or die("Não foi possível inserir suas informações. $query0");

				echo '<script language="javascript">alert("Banner alterado com sucesso!");document.location.href="p_insert_banner.php";</script>';
				
			}else{
			
				echo '<script language="javascript">alert("Já existe um banner cadastrado com este nome!");</script>';
				
			}
			}
		}else{
			echo '<script language="javascript">alert("Formato não permitido!");</script>';
		}
  }else{

        $arquivo_novo = $_POST['b_img'];
        
  			define("INCOMING", $caminho_banner_site);

  			$ImageSize = GetImageSize (INCOMING.${arquivo_novo});
  			$Img_w = $ImageSize[0];
  			$Img_h = $ImageSize[1];
        
  			if(($Img_w == 200) and ($Img_h == 70) and ($b_setor <> "Tamanho 1"))
			{

		  		echo '<script language="javascript">alert("O arquivo existente não se enquadra no tamanho do setor selecionado!");</script>';
			}
			elseif(($Img_w == 200) and ($Img_h == 140) and ($b_setor <> "Tamanho 2"))
			{

		  		echo '<script language="javascript">alert("O arquivo existente não se enquadra no tamanho do setor selecionado!");</script>';
			}
			elseif(($Img_w == 200) and ($Img_h == 210) and ($b_setor <> "Tamanho 3"))
			{

		  		echo '<script language="javascript">alert("O arquivo existente não se enquadra no tamanho do setor selecionado!");</script>';
			}
			elseif((($b_setor == "Tamanho 1") and ($Img_w <> 200) and ($Img_h <> 70)) or (($b_setor == "Tamanho 2") and ($Img_w <> 200) and ($Img_h <> 140)) or (($b_setor == "Tamanho 3") and ($Img_w <> 200) and ($Img_h <> 210)))
  			{

	  			echo '<script language="javascript">alert("O arquivo existente não se enquadra no tamanho do setor selecionado!");</script>';
  			}
  			else
  			{
  			
			$query1 = "SELECT b_nome FROM banners_site WHERE (b_nome='".$b_nome."' or b_img='".$arquivo_novo."') and (b_cod!='".$b_cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."')";
			//echo $query1;
  			$result1 = mysql_query($query1);
  			$numrows1 = mysql_num_rows($result1);
  			if($numrows1 == 0){

    	$query0 = "UPDATE banners_site set b_nome='".$b_nome."', b_link='".$b_link."', b_target='".$b_target."', b_img='".$arquivo_novo."', b_height='".$b_height."', b_width='".$b_width."', b_setor='".$b_setor."', b_ordem='".$b_ordem."', b_ativo='".$b_ativo."', b_tipo_arquivo='".$b_tipo_arquivo."' WHERE b_cod='".$b_cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result0 = mysql_query($query0) or die("Não foi possível inserir suas informações. $query0");
		
		echo '<script language="javascript">alert("Banner alterado com sucesso!");document.location.href="p_insert_banner.php";</script>';

			}else{
			
				echo '<script language="javascript">alert("Já existe um banner cadastrado com este nome!");</script>';
				
			}
		
			}

  }
}

if($B1 == "Apagar Banner")
{ 
        $b_cod = $_GET['b_cod'];
        
        $buscaim = mysql_query("SELECT b_img FROM banners_site WHERE b_cod='".$b_cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    	while($linha4 = mysql_fetch_array($buscaim)){
    	 	@unlink($caminho_banner_site.$linha4['b_img']); 
    	}
		
		$query0 = "DELETE FROM banners_site WHERE b_cod='".$b_cod."'";
		$result0 = mysql_query($query0) or die("Não foi possível inserir suas informações. $query0");
		
		echo '<script language="javascript">alert("Banner excluído com sucesso!");document.location.href="p_insert_banner.php";</script>';
        
}
	  
?>
<form method="post" enctype="multipart/form-data" action="p_insert_banner.php" name="form1">
<input type="hidden" name="b_cod" id="b_cod" value="<? echo($b_cod); ?>">
<input type="hidden" name="b_img" id="b_img" value="<? echo($b_img); ?>">                      
<table width="75%" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr height="50">
    <td class="style1" colspan="2" align="center"><b>Banner no Site</b></td>
  </tr>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1"><b>Nome:</b></td>
    <td width="80%" align="left" class="style1"><input type="text" name="b_nome" id="b_nome" value="<?php if(!empty($b_nome)){ echo($b_nome); } ?>" size="40" class="campo" /></td>
  </tr>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1"><b>Link:</b></td>
    <td width="80%" align="left" class="style1"><input type="text" name="b_link" id="b_link" value="<?php if(!empty($b_link)){ echo($b_link); } ?>" size="40" class="campo" />
      Ex.: http://www.imobiliaria.com.br/</td>
  </tr>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1"><b>Janela link:</b></td>
    <td width="80%" align="left" class="style1"><select name="b_target" class="campo" id="b_target">
      	<option value="">Selecione</option>
    	<option value="_blank" <? if($b_target=='_blank'){ print "SELECTED"; } ?>>Abrir numa nova janela</option>
        <option value="_self" <? if($b_target=='_self'){ print "SELECTED"; } ?>>Abrir na mesma janela</option>
    </select></td>
  </tr>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1"><b>Tipo de Arquivo:</b></td>
    <td width="80%" align="left" class="style1"><select name="b_tipo_arquivo" class="campo" id="b_tipo_arquivo" onchange="form1.submit();">  
      	<option value="">Selecione</option>
    	<option value="JPG,PNG,GIF" <? if($b_tipo_arquivo=='JPG,PNG,GIF'){ print "SELECTED"; } ?>>JPG,PNG,GIF</option>
        <option value="Flash" <? if($b_tipo_arquivo=='Flash'){ print "SELECTED"; } ?>>Flash</option>
    </select></td>
  </tr>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1" valign="top"><b>Imagem:</b></td>
    <td width="80%" align="left" class="style1"><input type="file" name="b_img_n" id="b_img_n" class="campo" size="40">
        <strong>Obs.:</strong> Clique em "Selecionar" e escolha a imagem desejada.
		<br>Formatos Permitidos: PNG, JPG, JPEG, GIF, SWF<br /></td>
  </tr>
<?
    if (file_exists($caminho_banner_site.$b_img) and $b_img!=''){
?>
              <tr class="fundoTabela">
                <td width="20%" align="left" class="style1" valign="top">Atual:</td>
                <td width="80%" align="left" class="style1">
<?
                if($extfb != "swf"){
                    
                    if($b_width=='0' && $b_height=='0'){
?>
                    <img src="<?php print($caminho_banner_site.$b_img); ?>" border="0"  />
<?
                    }else{
?>
                    <img src="<?php print($caminho_banner_site.$b_img); ?>" border="0" width="<?=$b_width ?>" height="<?=$b_height ?>" />
<?
                    }
                }else{
?>
                    <script language="JavaScript">
			            AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','<?=$b_width ?>','height','<?=$b_height ?>','src','<? echo $b_imgfb; ?>','quality','high','wmode','transparent','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','<? echo $b_imgfb; ?>' );
		            </script>
<?
                 }
?>
                </td>
              </tr>
<?
    }
?>
<?
	if($b_tipo_arquivo=='Flash'){
?>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1">Largura:</td>
    <td width="80%" align="left"><table border="0" cellspacing="0" cellpadding="0">
  </tr>    
      <tr class="fundoTabela">
        <td width="25%" align="left" class="style1"><input type="text" name="b_width" id="b_width" value="<?php if(!empty($b_width)){ echo($b_width); } ?>" size="3" class="campo" /></td>
        <td width="12%" align="left" class="style1">Altura:</td>
        <td width="48%" align="left" class="style1"><input type="text" name="b_height" id="b_height" value="<?php if(!empty($b_height)){ echo($b_height); }  ?>" size="3" class="campo" /></td>
      </tr>
    </table></td>
  </tr>
<?
	}
?>  
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1"><b>Setor:</b></td>
    <td width="80%" align="left" class="style1"><select name="b_setor" id="b_setor" class="campo">
      <option value="">Selecione</option>
      <option value="Tamanho 1" <? if($b_setor=='Tamanho 1'){ print "SELECTED"; } ?>>Tamanho 1 (200x70)</option>
      <option value="Tamanho 2" <? if($b_setor=='Tamanho 2'){ print "SELECTED"; } ?>>Tamanho 2 (200x140)</option>
      <option value="Tamanho 3" <? if($b_setor=='Tamanho 3'){ print "SELECTED"; } ?>>Tamanho 3 (200x210)</option>
    </select></td>
  </tr>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1"><b>Ordem:</b></td>
    <td width="80%" align="left" class="style1"><select name="b_ordem" class="campo" id="b_ordem">
      	<option value="">Selecione</option>
    	<option value="1" <? if($b_ordem=='1'){ print "SELECTED"; } ?>>1</option>
        <option value="2" <? if($b_ordem=='2'){ print "SELECTED"; } ?>>2</option>
        <option value="3" <? if($b_ordem=='3'){ print "SELECTED"; } ?>>3</option>
    </select></td>
  </tr>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1"><b>Ativo:</b></td>
    <td width="80%" align="left" class="style1"><select name="b_ativo" class="campo" id="b_ativo">
      	<option value="">Selecione</option>
    	<option value="Sim" <? if($b_ativo=='Sim'){ print "SELECTED"; } ?>>Sim</option>
        <option value="Não" <? if($b_ativo=='Não'){ print "SELECTED"; } ?>>N&atilde;o</option>
    </select></td>
  </tr>
  <tr>
    <td colspan="4" align="left">
	<? 
	  	if(empty($b_cod))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='p_insert_banner.php'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='p_insert_banner.php'\">
		  ");		
        } 
	  ?>
	</td>
  </tr>
<tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr class="fundoTabelaTitulo">
          <td width="33%" class="style1"><b>Nome</b></td>
          <td width="12%" class="style1"><b>Status</b></td>
          <td width="15%" class="style1"><b>Ordem</b></td>
          <td width="19%" class="style1"><p align="center"><b>Altera&ccedil;&atilde;o</b></p></td>
          <td width="21%" class="style1"><p align="center"><b>Exclus&atilde;o</b></p></td>
        </tr>
        <?
            $busca2 = mysql_query("SELECT b_cod, b_nome, b_ordem, b_ativo FROM banners_site WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY b_ordem ASC");
			 if(mysql_num_rows($busca2) > 0){
     		  	$i = 0;
	 			while($linha2 = mysql_fetch_array($busca2)){
	 			  
	 			  if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		  		  $i++;	 

      				echo('
	        			<tr class="'.$fundo.'">
            				<td class="style1">'.$linha2['b_nome'].'</td>
            				<td class="style1"><p align="center">'.$linha2['b_ativo'].'</p></td>
            				<td class="style1"><p align="center">'.$linha2['b_ordem'].'</p></td>
            				<td class="style1"><p align="center"><a href="p_insert_banner.php?id='.$linha2['b_cod'].'" class="style1">Alterar</a></p></td>
            				<td class="style1"><p align="center"><a href="javascript:confirmaExclusao('.$linha2['b_cod'].')" class="style1">Excluir</a></p></td>
            			</tr>
	   				');
    			}
  			}
  			else
    		{
	       		echo('
	        		<tr>
            			<td colspan="6" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            		</tr>
	   			');
			}
       ?>
      </table></td>
    </tr>
  </table>
<?
mysql_close($con);
?>
</form>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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