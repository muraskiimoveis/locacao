<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_LOCA");
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/		

	if(!$from){
		$from = intval($screen * 30);
	}

if($lista == "")
	{
?>
<div align="center">
  <center>
<table width="75%" border="0" cellspacing="1">
<?php
	$query3 = "SELECT * FROM clientes WHERE c_cod='$c_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);

	while($not3 = mysql_fetch_array($result3))
	{
?>
<tr height="50">
<td colspan="5" class="style1">
<p align="center"><b>Relatório de Locações do Cliente: <?php print("$not3[c_nome]"); ?></p>
</td></tr>
<?php
	}

	$query1 = "select * from locacao where l_cliente='$c_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_data_ent 
	limit $from, 30";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<tr class="fundoTabelaTitulo">
	<td width="10%" class="style1">
		<p align="center"><b>Entrada</b></p>
	</td>
	<td width="10%" class="style1">
		<p align="center"><b>Saída</b></p>
	</td>
	<td width="54%" class="style1">
		<p align="center"><b>Imóvel</b></p>
	</td>
	<td width="13%" class="style6">
		<p align="center"><b>Crédito</b></p>
	</td>
	<td width="13%" class="style7">
		<p align="center"><b>Despesas</b></p>
	</td>
</tr>
<?php
	$i = 0;

	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "96b5c9";

			$ano = substr ($not1[l_data_ent], 0, 4);
		        $mes = substr($not1[l_data_ent], 5, 2 );
		        $dia = substr ($not1[l_data_ent], 8, 2 );
		        $ano1 = substr ($not1[l_data_sai], 0, 4);
		        $mes1 = substr($not1[l_data_sai], 5, 2 );
		        $dia1 = substr ($not1[l_data_sai], 8, 2 );
		        $data_ent = "$dia/$mes/$ano";
		        $data_sai = "$dia1/$mes1/$ano1";
?>
<tr class="<?php echo $fundo; ?>">
<td class="style1"><p align="left">
<?php print("$data_ent"); ?></td>
<td class="style1"><p align="left">
<?php print("$data_sai"); ?></td>
<td class="style1">
<?php
	$query3 = "select ref, titulo from muraski where cod='$not1[l_imovel]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	while($not3 = mysql_fetch_array($result3))
	{
?>
<p align="left">
Ref.: <?php print("$not3[ref]"); ?> - <?php print strip_tags($not3[titulo]); ?>
<?php
	}
	//$l_total = $not1[l_total] + $not1[l_limpeza];
	$total_total = $not1[l_total] + $total_total;
	$l_desp_total = $not1[l_desp] + $l_desp_total;

	$total = number_format($not1[l_total], 2, ',', '.');
	$despesa = number_format($not1[l_desp], 2, ',', '.');
?>
</td>
<td class="style6">
<p align="left">R$ 
<?php print("$total"); ?></td>
<td class="style7">
<p align="left">R$ 
<?php print("$despesa"); ?></td>
</tr>
</form>
<?php
	}
	$total_total = number_format($total_total, 2, ',', '.');
	$l_desp_total = number_format($l_desp_total, 2, ',', '.');
?>
<tr class="fundoTabela">
<td colspan=2 class="style1"><p align="left">
<b>Crédito Total:
</td>
<td colspan=4 class="style1">
<p align="left">
<b>R$ 
<?php print("$total_total"); ?>
</td></tr>
<tr class="fundoTabela">
<td colspan=2 class="style1"><p align="left">
Total Despesas:
</td>
<td colspan=4 class="style1">
<p align="left">R$ 
<?php print("$l_desp_total"); ?>
</td></tr>
<?php
	}
	
	$query2 = "select count(l_imovel) as contador from locacao where l_cliente='$c_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
                  <tr><td colspan="6" class="style1">
                  <p align="center">
                  Foram encontrados <?php print("$not2[contador]"); ?> períodos</td></tr>
                  <tr><td colspan="6">
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

	for ($i = 0; $i < $pages; $i++) {
  	$url2 = "$php_self?screen=" . $i . "&c_cod=" . $c_cod;
  	echo "   | <a href=\"$url2\" class=\"style1\">$i</a> |   ";
	}

	if ($from >= $not2[contador]) {
?>
		  Última página da pesquisa
<?php
	}
	else
	{
	$url3 = "$php_self?screen=" . ($screen + 1) . "&c_cod=" . $c_cod;
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
	}
?>
</table>
</td></tr></table>
<?php
/*
mysql_free_result($result1);
mysql_free_result($result2);
mysql_free_result($result3);
*/
mysql_close($con);
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
?>
</body>
</html>