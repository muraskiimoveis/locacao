<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("regra.php");
include("funcoes/funcoes.php");
?>
<html>
<head>
<?php
include("style.php");
?>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<table width=100% height=100%>
<tr><td bgcolor="<?php print("$barra_lat"); ?>" valign=top width=150>
<?php
include("menu_painel.php");
?></td>
<td width=620 valign=top>
<br>
<?php
include("conect.php");
?>
<?php
    function trocaini($wStr,$w1,$w2) { 
        $wde = 0; 
        $para=0; 
    while($para<1) { 
        $wpos = strpos($wStr, $w1, $wde); 
        if ($wpos > 0) { 
            $wStr = str_replace($w1, $w2, $wStr); 
            $wde = $wpos+1; 
        } else { 
            $para=2; 
        } 
    } 
    $trocou = $wStr; 
    return $trocou; 
    }
     
    function altaebaixa($umtexto) { 
        $troca = strtolower($umtexto); 
        $troca = ucwords($troca); 
        $troca = trocaini($troca, " E ", " e "); 
        $troca = trocaini($troca, " De ", " de "); 
        $troca = trocaini($troca, " Da ", " da "); 
        $troca = trocaini($troca, " Do ", " do "); 
        $troca = trocaini($troca, " Das ", " das "); 
        $troca = trocaini($troca, " Dos ", " dos "); 
        $troca = trocaini($troca, "Ã", "ã");
        $troca = trocaini($troca, "Á", "á");
        $troca = trocaini($troca, "À", "à");
        $troca = trocaini($troca, "Â", "â");
        $troca = trocaini($troca, "Ç", "ç");
        $troca = trocaini($troca, "Ó", "ó");
        $troca = trocaini($troca, "Õ", "õ");
        $troca = trocaini($troca, "É", "é");
        $troca = trocaini($troca, "Ê", "ê");
        $troca = trocaini($troca, "Í", "í");
         
        $altabaixa = $troca; 
        return $altabaixa; 
     
    }
    
//Cadastra a Banner    
if($B1 == "Cadastrar Banner"){
	
	if($_POST['b_link']<>''){
  	    if(substr($_POST['b_link'],0, 7) <> 'http://'){
  	    	$b_link = 'http://'.$_POST['b_link'];
  	    }else{
		   	$b_link = $_POST['b_link'];
	    }
     }
		
	$query = "insert into rebri_banners (b_nome, b_chave, b_ordem, b_img, b_link, b_data, b_data2, b_setor, b_width, b_height) 
	values('$b_nome', '$b_chave', '$b_ordem', '$b_img', '$b_link', current_date, current_date, '$b_setor', '$b_width'
	, '$b_height')";
	//echo $query;
	$result = mysql_query($query,$con) or die("Não foi possível inserir suas informações.($query)");
?>
      <p align="center"><b>Você cadastrou o Banner <?php print("$b_nome - $b_link"); ?>.
<?php
	}
//Apaga Banner
if($B1 == "Apagar Banner")
	{
	
	if (file_exists($caminho_banner.$b_img))
	{
		unlink($caminho_banner.$b_img);
	}
	
?>
<p align="center">
Você apagou o Banner <i><?php print("$b_nome - $b_link"); ?></i>.</p>
<?php
	$query = "delete from rebri_banners where b_cod = '$b_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível apagar suas informações. $query");
	
	}
//Atualizar Banner
if($B1 == "Atualizar Banner")
	{
	  
	if($_POST['b_link']<>''){
  	    if(substr($_POST['b_link'],0, 7) <> 'http://'){
  	    	$b_link = 'http://'.$_POST['b_link'];
  	    }else{
		   	$b_link = $_POST['b_link'];
	    }
     }

	$query = "update rebri_banners set b_nome='$b_nome', b_chave='$b_chave', b_ordem='$b_ordem'
	, b_img='$b_img', b_link='$b_link', b_data2=current_date, b_setor='$b_setor', b_width='$b_width'
	, b_height='$b_height' where b_cod='$b_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível atualizar suas informações. $query");
?>
<p align="center">
Você atualizou o Banner <i><?php print("$b_nome - $b_link"); ?></i>.</p>
<?php
	}

if($lista == "")
	{
?>	
<?php

	if(!$screen){
	$screen = 1;
	}

	if(!$from){
	$from = intval(($screen - 1) * 30);
	}

	$query1 = "select * from rebri_banners 
	order by b_nome 
	limit $from, 30";
	$result1 = mysql_query($query1,$con) or die ("erro 152");
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<div align="center">
  <center>
                  <table width="600" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
                  <tr><td>
                  <b>Nome</b></td><td>
                  <b>Imagem</b></td><td>
                  <b>Exibições</b></td><td>
                  <b>Cliques</b></td><td>
                  <b>Data</b></td></tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="DCE0E4"; }else{ $fundo="EDEEEE"; }
	$i++;
?>
<tr bgcolor="<?php print("$fundo"); ?>"><td width="16%" class=style2>
<a href="p_banners.php?b_cod=<?php print("$not[b_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[b_nome]"); ?></a></td><td width="16%" class=style2>
<a href="p_banners.php?b_cod=<?php print("$not[b_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[b_img]"); ?></a></td><td width="16%" class=style2>
<a href="p_banners.php?b_cod=<?php print("$not[b_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[b_views]"); ?></a></td><td width="18%" class=style2>
<a href="p_banners.php?b_cod=<?php print("$not[b_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[b_clicks]"); ?></a></td><td width="18%" class=style2>
<a href="p_banners.php?b_cod=<?php print("$not[b_cod]"); ?>&edit=editar&lista=1" class=style2><?php print(formataDataDoBd($not[b_data])); ?></a></td>
</tr>
<?php
	}
	
	$query2 = "select count(b_cod) as contador 
	from rebri_banners";
	$result2 = mysql_query($query2,$con) or die ("erro 187");
	while($not2 = mysql_fetch_array($result2))
	{
	$pages = ceil($not2[contador] / 30);
?>
                  <tr><td colspan="6" bgcolor="#<?php print("$cor5"); ?>">
                  
                  <p align="center">
                  <i>Foram encontrados <?php print("$not2[contador]"); ?> banners</i></td></tr>
                  <tr><td colspan=6 align=center class=style2>
<?php
	if ($from > 30) {
	$url1 = $PHP_SELF . "?screen=" . ($screen - 1);
?>
                  <a href="javascript:history.back()" class=style2>
                  << Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class=style2>
                  << Página anterior <<</a>
<?php
	}

	for ($i = 1; $i <= $pages; $i++) {
		if($pesq == ""){
  	$url2 = $PHP_SELF . "?screen=" . $i;
		}
		else
		{
  	$url2 = $PHP_SELF . "?screen=" . $i;
		}
  	if($i == $screen){
  	echo "   | <a href=\"$url2\"><b><font color=#ff0000>$i</b></a> |   ";
	}
  	else
  	{
  	echo "   | <a href=\"$url2\" class=style2>$i</a> |   ";	
  	}
	}

	if ($from >= $not2[contador]) {
?>
		  
		  Última página da pesquisa
<?php
	}
	else
	{
		if($pesq == ""){
  	$url3 = $PHP_SELF . "?screen=" . ($screen + 1);
		}
		else
		{
  	$url3 = $PHP_SELF . "?screen=" . ($screen + 1);
		}
?>
                  <a href="<?php print("$url3"); ?>" class=style2>
                  >> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
	}
?>
	</table>
<?php
	}
	else
	{
?>
<?php
	if($edit == "editar"){
	$query2 = "select * from rebri_banners where b_cod = '$b_cod'";
	$result2 = mysql_query($query2,$con) or die ("erro 265");
	while($not2 = mysql_fetch_array($result2))
	{
	$ano1 = substr ($not2[b_data], 0, 4);
	$mes1 = substr($not2[b_data], 5, 2 );
	$dia1 = substr ($not2[b_data], 8, 2 );
	
	$ano2 = substr ($not2[b_data2], 0, 4);
	$mes2 = substr($not2[b_data2], 5, 2 );
	$dia2 = substr ($not2[b_data2], 8, 2 );

if(!IsSet($editar))
	{
?>
<script language="javascript">
function valida()
{
	if (document.formulario.b_nome.value == "")
  	{
    	alert("Por favor, digite o Nome");
    	document.formulario.b_nome.focus();
    	return false;
  	}
  	
  	if (document.formulario.b_link.value == "")
  	{
    	alert("Por favor, digite o Link");
    	document.formulario.b_link.focus();
    	return false;
  	}
  	
  	if (document.formulario.b_img.value == "")
  	{
    	alert("Por favor, seleciona a Imagem");
    	document.formulario.b_img.focus();
    	return false;
  	}
  	
	return true;
}
</script>
 <div align="center">
  <center>
  <form method="post" action="p_banners.php" name="formulario">
  <input type="hidden" value="1" name="editar">
  <input type="hidden" value="<?php print("$not2[b_cod]"); ?>" name="b_cod">
  
  <table border="0" cellspacing="1" width="100%">
  	<tr>
  	  <td width="70%"><table border="0" cellspacing="2" width="100%">
    <tr>
      <td width="20%" class=style2>*Nome:</td>
      <td width="80%" class=style2> <input type="text" name="b_nome" size="40" class="campo" value="<?php print("$not2[b_nome]"); ?>"> <?php print("$falt_nome"); ?></td>
    </tr>
    <tr>
      <td width="20%" class=style2>*Link:</td>
      <td width="80%" class=style2><input type="text" name="b_link" size="40" value="<?php print("$not2[b_link]"); ?>" class="campo"> <?php print("$falt_link"); ?></td>
    </tr>
    <tr>
      <td width="20%" class=style2>*Imagem:</td>
      <td width="80%" class=style2> <input type="text" name="b_img" size="20" class="campo" value="<?php print("$not2[b_img]"); ?>" readonly>
      	<input type="button" value="Selecionar" class="campo" onclick="window.open('p_img_banner.php', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.</td>
    </tr>
<?php
	if (file_exists($caminho_banner . $not2[b_img]))
	{
	$ImageSize = GetImageSize ($caminho_banner . $not2[b_img]);
	$Img_w = $ImageSize[0];
	$Img_h = $ImageSize[1];
	if($Img_w > 145){
		$largura = "145";
	}
	else
	{
		$largura = $Img_w;
	}
	$extensao = explode(".", $not2[b_img]);
	
	if(($extensao[1] == "jpg") or ($extensao[1] == "gif") or ($extensao[1] == "png"))
	{
?>

    <tr>
      <td width="20%" class=style2>Imagem atual:</td>
      <td width="80%" class=style2> <img src="<?php print($caminho_banner.$not2[b_img]); ?>" width="<?php print("$largura"); ?>"></td>
    </tr>
<?php
	}
	else
	{
?>
<tr>
	<td width="20%" class=style2>Imagem atual:</td>
	<td align=center>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="<?php print("$not2[b_width]"); ?>" height="<?php print("$not2[b_height]"); ?>" id="anuncie" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="<?php print($caminho_banner.$not2[b_img]); ?>?alink1=ad_click.php%3Fb_cod=<?php print("$not2[b_cod]"); ?>" />
<param name="menu" value="false" /><param name="quality" value="high" />
<param name="scale" value="noborder" />
<param name="wmode" value="transparent" />
<param name="bgcolor" value="#ffffff" />
<embed src="/anuncios/anuncie.swf" menu="false" quality="high" scale="noborder" wmode="transparent" bgcolor="#ffffff" width="120" height="60" name="anuncie" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object></td>
</tr>
<?php
	}
	}
?>
    <tr>
      <td colspan="2" width="20%" class=style2><i>Largura e Altura é obrigatório preencher quando a imagem for um arquivo Flash(.swf)</i></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Largura:</td>
      <td width="80%" class=style2> <input type="text" name="b_width" size="3" value="<?php print("$not2[b_width]"); ?>" class="campo"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Altura:</td>
      <td width="80%" class=style2> <input type="text" name="b_height" size="3" value="<?php print("$not2[b_height]"); ?>" class="campo"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Setor:</td>
      <td width="80%" class=style2> <select size="1" name="b_setor" class="campo">
    <option value="<?php print("$not2[b_setor]"); ?>"><?php print("$not2[b_setor]"); ?></option>
    <option>Direita</option>
    <option>Parceiros</option>
        </select></td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
	  <tr>
      <td>
      <input class=campo type="submit" value="Atualizar Banner" name="B1" onclick="return valida();"></td>
      <td>
      <input class=campo type="submit" value="Apagar Banner" name="B1"></td>
    </tr>
    <tr>
      <td colspan="2">
      <p align="center"><a href="javascript:history.back()" class=style2><< Voltar <<</a></p></td>
    </tr>
  </table>
  </td>
  <td width="30%" valign="top"><table border="0" cellspacing="1" width="100%" bgcolor="#<?php print("$cor3"); ?>">
  		<tr bgcolor="#<?php print("$cor3"); ?>">
  			<td align="center"><b>Informações</b><br>
  				<table border="0" cellspacing="1" width="100%" bgcolor="#<?php print("$cor1"); ?>"
  	<tr bgcolor="#<?php print("$cor1"); ?>">
      <td class=style2>Exibições:</td>
      <td class=style2> <?php print("$not2[b_views]"); ?></td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td class=style2>Cliques:</td>
      <td class=style2> <?php print("$not2[b_clicks]"); ?></td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td class=style2>Data Cad.:</td>
      <td class=style2> <?php print("$dia1/$mes1/$ano1"); ?></td>
    </tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td class=style2>Última Atual.:</td>
      <td class=style2> <?php print("$dia2/$mes2/$ano2"); ?></td>
    </tr>
  	</table></td>
  		</tr>
  	</table>
  </td>
</tr>
</table>

  </form>
<?php
	}
	}
	}
mysql_close($con);
?>
<?php
	}
?>
<?php
include("carimbo.php");
//mysql_close($con);
?>
</td></tr></table>
</body>
</html>