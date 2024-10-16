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
	
	$query1 = "select * from locacao where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_imovel";
	$result1 = mysql_query($query1);

	while($not1 = mysql_fetch_array($result1))
	{

	$l_total = $not1[l_total];
	$l_comissao = $not1[l_comissao];
	$l_limpeza = $not1[l_limpeza];
	$l_desp = $not1[l_desp];
	$l_saldo = $l_total - ($l_comissao + $l_desp);

	$query4= "update locacao set l_saldo='$l_saldo' where l_cod='$not1[l_cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	
	}
?>
SALDOS ATUALIZADOS COM SUCESSO!!!
<?php
mysql_close($con);
?>