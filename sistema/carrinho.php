<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_VEND");
verificaArea("GERAL_LOCA");
?>
<html>

<head>
<?php
include("style.php");
?>
</head>
<body>
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
<div align="center">
<table border="0" cellpadding="1" cellspacing="1" width="75%">
	<tr height="50">
		<td colspan=3 class="style1"><p align="center"><b>Imóveis Selecionados para visita</b></p></td>
	</tr>
    <tr>
		<td>
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<?php
	if($alterar == "1"){
	
	if(session_is_registered("valid_user")){
	
	if($tudo == 1){
	$query8= "delete from carrinho where ca_usu='$valid_user' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result8 = mysql_query($query8) or die("Não foi possível apagar suas informações.(Sessão existente)");
	}
	
	if(($qtd < 1) or ($qtd == "")){
	$query8= "delete from carrinho where ca_imovel='$cod' and ca_usu='$valid_user' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result8 = mysql_query($query8) or die("Não foi possível apagar suas informações.(Sessão existente)");
	}

?>
<?php
	}//Termina if session_is_registered
	}//Termina o carrinho se não selecionou produtos
	else
	{
	
	if(session_is_registered("valid_user")){
	
	$hoje = date("Y-m-d");
	//print("$hoje");

	$query7 = "select * from locacao where l_data_ent<='$hoje' and l_data_sai>='$hoje'
	 and l_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result7 = mysql_query($query7);
	$numrows7 = mysql_num_rows($result7);
	if($numrows7 == 0){
?>
<?php
	//Procura se o produto já foi inserido no carrinho
	$query6 = "select ca_imovel, ca_usu from carrinho where	ca_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
	if($numrows6 > 0){
	while($not6 = mysql_fetch_array($result6))
	{
?>
<tr class="fundoTabela"><td style="padding-top: 10px;padding-bottom: 10px;" colspan=3 align=center class="style7" >
O imóvel já foi selecionado pelo usuário <i><?php print("$not6[ca_usu]"); ?></i>
</td></tr>
<?php
	}//Termina while 6
	}//Termina numrows 6
	else
	{
	if($qtd > 0){
	//Insere os produtos na tabela temporária
	$query2= "insert into carrinho (ca_usu, cod_imobiliaria, ca_imovel, ca_data) 
	values('$valid_user', '".$_SESSION['cod_imobiliaria']."', '$cod', current_timestamp)";
	$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações.(Sessão existente)");
	}
	}

	}//Termina numrows7
	else
	{
?>
<tr class="fundoTabela"><td style="padding-top: 10px;padding-bottom: 10px;" colspan=3 align=center class="style7">
O imóvel está locado!
</td></tr>
<?php
	}	
//mysql_free_result($result6);
//mysql_free_result($result7);

	}//Termina aqui se a seção existe

	}
?>
<?php
	
	$query1 = "select cod, ca_imovel, ref, titulo, ca_usu, u_email, tipo_logradouro, end, numero, local, bairro 
	from carrinho, muraski, usuarios where ca_usu='$valid_user' and 
	u_email='$valid_user' and cod=ca_imovel and carrinho.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by ref";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<tr class="fundoTabelaTitulo">
<td class="style1"><b>Ref</b></td>
<td colspan=2 class="style1"><b>Endereço</b></td>
</tr>
<?php
	$i = 1;
	$total = 0;

	while($not1 = mysql_fetch_array($result1))
	{

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$total++;
	
	//$titulo = substr ($not1[titulo], 0, 50);
	$titulo = strip_tags($not1[titulo]);
	
	$bairro10 = explode("--", $not1['bairro']);
	$bairro20 = str_replace("-","",$bairro10);
		
	foreach ($bairro20 as $k => $bairro) {
		$bairro20[$k] = "'" . $bairro . "'";
	}
		
	$b_bairro2 = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro20) . ") ORDER BY b_nome ASC");
	while($linha2=mysql_fetch_array($b_bairro2)){
		$bairros .= $linha2['b_nome']." "; 
	}
	
	$query10 = "SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$not1['local']."'";
	$result10 = mysql_query($query10);
	while($not10 = mysql_fetch_array($result10))
	{
	    $cidade = $not10['ci_nome'];
	}  
	
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="cod" value="<?php print("$not1[cod]"); ?>">
<input type="hidden" name="qtd" value="0">
<input type="hidden" name="alterar" value="1">
<tr class="<?php print("$fundo"); ?>"><td>
<a href="detalhes.php?cod=<?php print("$not1[cod]"); ?>" class="style1"><?php print("$not1[ref]"); ?></a>
</td><td>
<a href="detalhes.php?cod=<?php print("$not1[cod]"); ?>" class="style1"><?php print("$not1[tipo_logradouro]"); ?> <?php print("$not1[end]"); ?>, <?php print("$not1[numero]"); ?><br><?php print($cidade); ?> <?php print($bairros); ?></a>
</td>
<td><input type="submit" value="Apagar" class="campo3" name="bot"></td></tr></form>
<?php
	$cidade= '';
	$bairros = '';
	}
?>
<tr class="fundoTabelaTitulo">
<td></td><td align=right colspan=2 class="style1"><b>Total de Imóveis: <?php print("$total"); ?></b></td></tr>
</table>
</center></div>
<?php
//mysql_free_result($result1);
	}//Termina o carrinho se existe a seção e não selecionou produtos
	else
	{
?>
<tr class="fundoTabela">
<td colspan="3" align=center class="style1"><b>Seu carrinho de chaves ainda está vazio!</td>
</tr>
<tr class="fundoTabela">
<td colspan="3" align=center class="style1"><a href="p_pesq_ven.php" class="style1">Vendas</a> - <a href="p_pesq_loc.php" class="style1">Locações</a></td>
</tr>
<?php
	}
?>
</td></tr>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<tr><td align=center>
<input type="hidden" name="tudo" value="1">
<input type="hidden" name="alterar" value="1">
<input type="submit" value="Limpar Tudo" class="campo3" name="bot">
</td></tr></form></table>
<?php
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