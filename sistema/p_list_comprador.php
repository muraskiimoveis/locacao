<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("IMOV_GERAL");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	  
?>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<?php
	if(!$from){
		$from = intval($screen * 30);
	}
?>
<?php
	
if($lista == "")
	{

	if($list == ""){
	$query1 = "select * from clientes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c_nome limit $from, 30";
	}else{
		if($data_tipo != ""){
	$query1 = "select * from clientes where 
	($data_tipo BETWEEN '$ano-$mes-$dia' AND '$ano1-$mes1-$dia1') 
	order by c_nome limit $from, 30";
		}
		else
		{
	$query1 = "select * from clientes where $campo like '%$c_nome%' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c_nome 
	limit $from, 30";
		}
	}
	//echo $query1;
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table border="0" cellpadding="1" cellspacing="1" width="95%">
	<form method="get" action="p_list_clientes.php">
		<input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
      <tr height="50">
		<td colspan=5 class="style1" align="center"><b>Relação de Compradores</b></td>
	</tr>
	    <tr bgcolor="#<?php print("$cor1"); ?>" align=center>
      <td colspan=5 class=style1><b>Palavra Chave:</b> <input type="text" class="campo" name="c_nome" size="40"> <select name="campo" class="campo">
      <option value="c_nome">Nome do cliente</option>
      <option value="c_tipo">Tipo de cliente</option>
      <option value="c_cpf">CPF</option>
      <option value="c_rg">RG</option>
      <option value="c_end">Endereço do cliente</option>
      <option value="c_cidade">Cidade</option>
      <option value="c_email">E-mail</option>
      <option value="c_tel">Telefone</option>
      <option value="c_civil">Estado Civil</option>
      <option value="c_obs">Texto da Obs</option>
      <!--option value="c_ref">Referência do Imóvel</option-->
      </select> <input type="submit" value="Pesquisar Cliente" name="B1" class=campo3><br /><br /></td>
    </tr>
     <tr align=center>
	      <td colspan=5 class=style1><div align="left"><span class="style7">Se o comprador n&atilde;o est&aacute; cadastrado <a href="p_insert_clientes.php?novo=S&url=<?=$REQUEST_URI ?>" class="style7">clique aqui</a></span></div></td>
    </tr>
  </form>
<tr class="fundoTabelaTitulo">
<td width=300 class="style1"><b>Nome</b></td>
<td width=100 class="style1"><b>CPF</b></td>
<td width=100 class="style1"><b>Telefone</b></td>
<td width=100 class="style1"><b>Tipo</b></td>
<td width=100 class="style1"><b>Tipo</b></td>
</tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
?>
<tr class="<?php echo $fundo; ?>">
<td class="style1"><p align="left">
<?php print("$not[c_nome]"); ?></td>
<td class="style1">
<p align="center">
<?php print("$not[c_cpf]"); ?></td>
<td class="style1">
<p align="center">
<?php print("$not[c_tel]"); ?></td>
<td class="style1">
<p align="center">
<?php print("$not[c_tipo]"); ?></td>
<td class="style1">
<p align="center">
<input type="button" onClick="window.opener.document.formulario.nome_cliente.value='<?php print("$not[c_nome]"); ?>'; window.opener.document.formulario.co_cliente.value='<?php print("$not[c_cod]"); ?>'; window.opener.focus(); window.close();" class="campo3" value="Selecionar"></td>
<!--a href="#" onClick="window.opener.document.formulario.nome_cliente.value='<?php print("$not[c_nome]"); ?>'; window.opener.document.formulario.co_cliente.value='<?php print("$not[c_cod]"); ?>'; window.opener.focus(); window.close();" class="style1">Selecionar</a></td-->
<?php
	}
	
	if($list == ""){
	$query2 = "select count(c_cod) as contador from clientes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}else{
		if($data_tipo != ""){
	$query2 = "select count(c_cod) as contador from clientes where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND
	($data_tipo BETWEEN '$ano-$mes-$dia' AND '$ano1-$mes1-$dia1')";
		}
		else
		{
	$query2 = "select count(c_cod) as contador from clientes where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND $campo like '%$c_nome%'";
		}
	}
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
  <tr class="fundoTabelaTitulo"><td colspan=5 class=style1>
                  <p align="center">
                  <b>Foram encontrados <?php print("$not2[contador]"); ?> clientes</b></td></tr>
                  <tr><td colspan=5 bgcolor="#<?php print("$cor1"); ?>" class=style1>
                  <p align="center" class="style1">
<?php
	if ($from > 30) {
	//$url1 = "vendas2.php?screen=" . ($screen - 1) . "&tipo=" . $tipo . "&finalidade=" . $finalidade;
?>
                  <a href="javascript:history.back()" class="style1"><< Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class="style1">
                  << Página anterior <<</a>
<?php
	}
?>
<br>
<?php
/*
	for ($i = 0; $i < $pages; $i++) {
  	$url2 = "$PHP_SELF?screen=" . $i . "&list=" . $list . "&c_nome=" . $c_nome . "&campo=" . $campo . "&dia=" . $dia . "&mes=" . $mes . "&ano=" . $ano . "&dia1=" . $dia1 . "&mes1=" . $mes1 . "&ano1=" . $ano1 . "&data_tipo=" . $data_tipo;
  	if($i == $screen){
  	echo " <a href=\"$url2\" class=style1><b>$i</b></a> ";
		}
  	else
  	{
  	echo " <a href=\"$url2\" class=style1>$i</a> ";
  	}
  	
	}
*/	
	
	for ($i = 0; $i < $pages; $i++) {	  
  	$url2 = "$PHP_SELF?screen=" . $i . "&list=" . $list . "&c_nome=" . $c_nome . "&campo=" . $campo . "&dia=" . $dia . "&mes=" . $mes . "&ano=" . $ano . "&dia1=" . $dia1 . "&mes1=" . $mes1 . "&ano1=" . $ano1 . "&data_tipo=" . $data_tipo;
  	//echo "   | <a href=\"$url2\" class=linkp>$j</a> |   ";
  		if(((($screen - 9) < $i) and (($screen + 9) > $i)) or ($i == 0) or ($i == ($pages -1))){
  			if($i == $screen){
  				echo "   | <a href=\"$url2\" class=style7><b>$i</b></a> |   ";
			}elseif($i == 0){
  				echo "   | <a href=\"$url2\" class=style1><b>Primeira</b></a> |   ";
			}elseif($i == ($pages - 1)){
  				echo "   | <a href=\"$url2\" class=style1><b>Última</b></a> |   ";
			}else{
  				echo "   | <a href=\"$url2\" class=style1>$i</a> |   ";	
  			}
  		}
	}
?>
<br>
<?php
	if ($from >= $not2[contador]) {
?>
		  Última página da pesquisa
<?php
	}
	else
	{
	$url3 = "$PHP_SELF?screen=" . ($screen + 1) . "&list=" . $list . "&c_nome=" . $c_nome . "&campo=" . $campo . "&dia=" . $dia . "&mes=" . $mes . "&ano=" . $ano . "&dia1=" . $dia1 . "&mes1=" . $mes1 . "&ano1=" . $ano1 . "&data_tipo=" . $data_tipo;
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
?>
</table>
<?php
/*
mysql_free_result($result1);
mysql_free_result($result2);
*/
	}
?>
<?php
/*
	}
	else
	{
*/	  
?>
<?php
//include("login2.php");
?>
<?php
//	}
mysql_close($con);
?>
</body>
</html>