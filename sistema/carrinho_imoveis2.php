<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("IMOV_LISTA");
?>
<html>

<head>
<?php
include("style.php");
?>
</head>
<SCRIPT LANGUAGE="JavaScript">

function printPage() {
if (window.print) {
agree = confirm('Gostaria de imprimir a lista de imóveis?\n\nClique OK para imprimir agora mesmo.');
if (agree) window.print(); 
   }
}

</script>

<body topmargin=0 leftmargin=0 rightmargin=0>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	  
?>
<img border="0" src="http://muraski.com/images/logo_lista.gif">
<table border="0" cellpadding="1" cellspacing="1" width="770">
  <tr>
    <td>
<div align="center">
<table border="0" cellpadding="1" cellspacing="1" width="700" bgcolor="#<?php print("$cor7"); ?>">
<base target="_self">
  <table border="0" cellpadding="0" cellspacing="0" width="95%" align=center>
    <tr>
      <td width="100%">
<table BORDER="0" align="center" CELLPADDING="0" CELLSPACING="1" width=100%>
<?php
	if(session_is_registered("session_id()")){

	if($sid == ""){
	$sid = session_id();
	}
	else
	{
		$sid = $sid;
	session_register("sid");	
	}

	}

	if(!$ordem){
	$ordem = ref;
	}

	$query1 = "select distinct muraski.cod, ref, titulo, 
	sid, valor, carnaval, anonovo, metragem, descricao, tipo, n_quartos, finalidade, suites, dist_tipo, dist_mar 
	from imoveis_temp, muraski where int_cod='$int_cod' and 
	imoveis_temp.cod=muraski.cod and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by $ordem";
	//echo $query1;
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<tr>
<td colspan=2 class="style2">
Estes são os imóveis que você selecionou:
</td>
</tr>
<tr>
<td colspan=2 align=right class="style2">
Ordenados por: <span class="style7"><?php print("$ordem"); ?></span>
</td>
</tr>
<?php
	$i = 1;
	//$total = 0;
	//$peso_total = 0;

	while($not1 = mysql_fetch_array($result1))
	//$total = number_format($total, 2, ',', '.');
	//$total_desc = number_format($total_desc, 2, ',', '.');
?>
<tr>
<td colspan=2 class="style2">
<b>Total de <?php $total = $i - 1; print("$total"); ?> imóveis selecionados</td>
</tr>
<?php
mysql_free_result($result1);
	}//Termina o carrinho se existe a seção e não selecionou produtos
	else
	{
?>
<tr bgcolor="#<?php print("$cor7"); ?>">
<td colspan="4" align=center class="style2"><b>Sua lista de imóveis ainda está vazia!</td>
</tr>
<tr bgcolor="#<?php print("$cor6"); ?>">
<td colspan="4" align=center class="style2"><a href="index1.php">Clique aqui para continuar navegando.</a></td>
</tr>
<?php
	}
?>
      </td>
    </tr>
  </table>
</td></tr>
<tr><td colspan="2" align=center>
<hr noshade color="<?php print("$cor6"); ?>" align="center" width="50%" size="1">
</td></tr>
<tr>
<td colspan=2 align=center>
<a href="javascript:close()" class="style6">Fechar janela</a></td>
</tr>
</table>
<?
	//}## fim while conta imoveis
	//mysql_free_result($result1);
	//mysql_free_result($result2);
	mysql_close($con);

## se não tem sessao
/*
} else {
	print "Área protegida!";
}
*/
?>
</body>

</html>