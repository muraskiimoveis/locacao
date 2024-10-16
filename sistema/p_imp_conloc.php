<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("DOCS");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("tipo")) and 
	($tipo == "admin")){
*/	  

//include("topo.php");
//include("menu.php");
?>
<p>
<?php

	if($imp == "2"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	}
	
	$query2 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=clientes.c_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-rg-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-tel-", "<b>$not2[c_tel]</b>", $d_txt);
	$d_txt = str_replace("-cid_imov-", "<b>$not2[local]</b>", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);

	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );

	$d_txt = str_replace("-data_inicio-", "<b>$dia/$mes/$ano</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$dia1/$mes1/$ano1</b>", $d_txt);
	
	$diaria1 = number_format($not2[diaria1], 2, ',', '.');
	$diaria2 = number_format($not2[diaria2], 2, ',', '.');
	
	$d_txt = str_replace("-diaria1-", "<b>$diaria1</b>", $d_txt);
	$d_txt = str_replace("-diaria2-", "<b>$diaria2</b>", $d_txt);
	$d_txt = str_replace("-conta-", "<b>$not2[c_conta]</b>", $d_txt);

$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="750" bgcolor="#DCE0E4">
  <tr bgcolor="#DCE0E4"><td colspan=2>
<p align="center"><font color="#000080" size="2" face="Arial"><b><?php print("$not3[d_nome]"); ?></b></font></p></td></tr>
<?php
	if($impressao == ""){
?>
<form method="post" action="<?php print("$PHP_SELF"); ?>">
<input type=hidden name=d_nome value=<?php print("$not3[d_nome]"); ?>>
<input type=hidden name=cod value=<?php print("$cod"); ?>>
<input type=hidden name=impressao value=1>
<input type=hidden name=imp value=2>
  <tr bgcolor="#ffffff"><td colspan=2>
<p align="left"><font color="#000080" size="2" face="Arial"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea></font></td></tr>
  <tr bgcolor="#ffffff"><td colspan=2>
<input type="submit" value="Finalizar Texto" class=campo3 name="B1"></td></tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br><br>","$txt");
?>
  <tr bgcolor="#ffffff"><td colspan=2>
<p align="left"><font color="#000080" size="2" face="Arial"><br><?php print("$txt"); ?></font></p><p></td></tr>
<?php
	}
?>
  <tr bgcolor="#ffffff"><td colspan=2>
<p align="left"><font color="#000080" size="2" face="Arial"><b>Guaratuba-PR, <?php print("$dia2/$mes2/$ano2"); ?></font></p></td></tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%"><font color="#000080" size="2" face="Arial"><br><p align=left>
    <b>PROPRIETÁRIO: _________________________</b></p></font><p></td>
    <td width="50%"><font color="#000080" size="2" face="Arial"><br><p align=left>
    <b>CORRETOR(A): _________________________</b></p></font><p></td>
    </tr>
  </table>
<?php
	}
	}
	}
	}
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