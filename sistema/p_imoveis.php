<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");

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
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
echo $msg;
?>
<p>
<?php


	$query1 = "select distinct m.tipo, m.finalidade, t.t_nome
	from muraski m INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) where m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by t.t_nome";
	$result1 = mysql_query($query1) or die ("Erro 359 - ".mysql_query());
	$numrows1 = mysql_num_rows($result1);
	if ($numrows1 > 0) {
?>
<div align="center">
  <center>
    <table width="75%" cellpadding="1" cellspacing="1">
		<tr height="50">
    		<td colspan="6">
      			<p align="center" class="style48"><a href="p_pesq_imoveis.php" class="style1">
                  <b>Pesquisar Imóveis</b></a><br/>Estes são os imóveis cadastrados até o momento</p>
    		</td>
		</tr>
        <tr class="fundoTabelaTitulo">
        	<td><b class="style1">Tipo</b></td>
        	<td><b class="style1">Finalidade</b></td>
        	<td><b class="style7">Quantidade</b></td>
        </tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;

if($not[finalidade]=='1'){
  $fin = "Venda_Rebri";
}elseif($not[finalidade]=='2'){
  $fin = "Venda_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='3'){
  $fin = "Venda_Parceria";
}elseif($not[finalidade]=='4'){
  $fin = "Venda_Terceiros";
}elseif($not[finalidade]=='5'){
  $fin = "Venda_Off";
}elseif($not[finalidade]=='6'){
  $fin = "Venda_Vendido";
}elseif($not[finalidade]=='7'){
  $fin = "Venda_Todos";
}elseif($not[finalidade]=='8'){
  $fin = "Locação_Anual_Rebri";
}elseif($not[finalidade]=='9'){
  $fin = "Locação_Anual_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='10'){
  $fin = "Locação_Anual_Parceria";
}elseif($not[finalidade]=='11'){
  $fin = "Locação_Anual_Terceiros";
}elseif($not[finalidade]=='12'){
  $fin = "Locação_Anual_Off";
}elseif($not[finalidade]=='13'){
  $fin = "Locação_Anual_Locado";
}elseif($not[finalidade]=='14'){
  $fin = "Locação_Anual_Todos";
}elseif($not[finalidade]=='15'){
  $fin = "Locação_Temporada_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='16'){
  $fin = "Locação_Temporada_Off";
}elseif($not[finalidade]=='17'){
  $fin = "Locação_Temporada_Todos";
}

?>
<tr class="<?php print("$fundo"); ?>"><td class="style1">
<a href="p_lista_edit.php?tipo1=<?php print("$not[tipo]"); ?>&finalidade=<?php print($not[finalidade]); ?>&angariador=%" class="style1">
<?php print("$not[t_nome]"); ?></a></td><td class="style1">
<?php print($fin); ?></td><td class="style7">
<?php
	$query2 = "select count(tipo) as q_tipo 
	from muraski where tipo='$not[tipo]' and finalidade='$not[finalidade]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by tipo";
	$result2 = mysql_query($query2) or die ("Erro 429 - ".mysql_error());
	
	while($not2 = mysql_fetch_array($result2))
	{
	print("$not2[q_tipo]");
	}
?>
</td></tr>
<?php
	}

	$query3 = "select count(cod) as q_cod 
	from muraski where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3) or die ("Erro 442 - ".mysql_error());

	while($not3 = mysql_fetch_array($result3))
	{
?>
                  <tr><td colspan="3" class="fundoTabelaTitulo style1">
                  <p align="center">
                  Total de <b><?php print("$not3[q_cod]"); ?></b> imóveis.</td></tr>
	</table>
  </center>
	</div>
<?php
	}
	}
/*
mysql_free_result($result1);
mysql_free_result($result2);
mysql_free_result($result3);
*/
mysql_close($con);
?>
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
    <input type="button" name="voltar" id="voltar" class="campo3" value="Voltar" OnClick="javascript:history.go(-2);"><br>
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