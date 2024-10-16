<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_SAIDAS");
?>
<html>

<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes/js.js"></script>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
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

	if($lista == ""){
?>
<script language="javascript">
function valida()
{
  if (document.form1.dia_saida.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.form1.dia_saida.focus();
    return (false);
  }
  if (document.form1.mes_saida.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.form1.mes_saida.focus();
    return (false);
  }
  if (document.form1.ano_saida.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.form1.ano_saida.focus();
    return (false);
  }
  if (document.form1.dia_saida1.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.form1.dia_saida1.focus();
    return (false);
  }
  if (document.form1.mes_saida1.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.form1.mes_saida1.focus();
    return (false);
  }
  if (document.form1.ano_saida1.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.form1.ano_saida1.focus();
    return (false);
  }
  
  var data1 = form1.ano_saida.value + form1.mes_saida.value + form1.dia_saida.value;
  var data2 = form1.ano_saida1.value + form1.mes_saida1.value + form1.dia_saida1.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	document.form1.dia_saida.focus();
	return(false);
  }
  
	return(true);
}
<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode; 
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}
//  End -->
</script>
<?php
	/*
    if($ano_saida == ""){
		$ano_saida = date(Y);
	}
	if($ano_saida1 == ""){
		$ano_saida1 = date(Y);
	}
	*/
?>
<div align="center">
  <center>
  <form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <input type=hidden name=cod value=<?php print("$cod"); ?>>
  <table width="75%" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td height="50" width="100%" colspan=2 class="style1"><p align="center"><b>Relatório de Saídas - Locação <!--Diária-->Temporada</b><br>
       Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar.</font></p></td>
    </tr>
    <tr  class="fundoTabela">
      <td width="20%" class="style1"><b>Período:</b></td>
      <td width="80%" class="style1">
      <input type="text" name="dia_saida" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_saida" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano_saida" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_saida"); ?>"> <b>à</b> <input type="text" name="dia_saida1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_saida1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano_saida1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_saida1"); ?>"><br>Ex.: 
    10/10/1910 à 20/10/1910</td>
    </tr>
    <tr>
      <td width="100%" colspan=2>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="1" name="lista">
      <input type="submit" value="Pesquisar" name="B1" class=campo3></td>
    </tr>
  </table>
  </form>
<?php
	}
	else
	{
		
	if ($screen == "") {
   		$screen = 1;
	}

	$from = ($screen - 1) * 30;

if($lista == "1")
	{
?>
<div align="center">
  <center>
<table width="75%" border="0" cellpadding="1" cellspacing="1">
<tr height="50"><td colspan=3 class="style1">
<p align="center"><b>Relatório de Saídas - Locação temporada</p>
</td></tr>
<?php
	$query1 = "select * from locacao where 
	(l_data_sai BETWEEN '$ano_saida-$mes_saida-$dia_saida' AND '$ano_saida1-$mes_saida1-$dia_saida1') and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND l_n_contrato='' order by l_data_sai
	limit $from, 30";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<tr class="fundoTabelaTitulo">
<td width="71" class="style1"><b>Entrada</b></td>
<td width="495" class="style1"><b>Imóvel</b></td>
<td width="95" class="style1"><b>Saída</b></td>
<!--td width="95" class="style1"><b>Despesas</b></td-->
</tr>
<?php
	$i = 0;

	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "cccccc";

			$ano2 = substr ($not1[l_data_ent], 0, 4);
		        $mes2 = substr($not1[l_data_ent], 5, 2 );
		        $dia2 = substr ($not1[l_data_ent], 8, 2 );
		        $ano3 = substr ($not1[l_data_sai], 0, 4);
		        $mes3 = substr($not1[l_data_sai], 5, 2 );
		        $dia3 = substr ($not1[l_data_sai], 8, 2 );
		        $data_ent = "$dia2/$mes2/$ano2";
		        $data_sai = "$dia3/$mes3/$ano3";
		 $locatario = $not1[l_cliente];
?>
<tr class="<?php print("$fundo"); ?>">
<td bgcolor="#<?php print("$fundo2"); ?>" class="style1" align="left">
<?php print("$data_ent"); ?></a></td>
<td class="style1" align="left">
<?php
	//$query3 = "SELECT ref, left(titulo, 60) FROM muraski WHERE cod='$not1[l_imovel]'";
	$query20 = "SELECT cliente, contador FROM muraski, clientes WHERE cod='$not1[l_imovel]' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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

    if($cliente1<>''){
	$query3 = "SELECT ref, end, numero, c_nome, c_cod FROM muraski, clientes WHERE cod='$not1[l_imovel]' and c_cod in (" . implode(',',$cliente2) . ") and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
    $cont = 0;
    $proprietarios = '';
    $referencia = '';
    $nome_prop = '';
    $var = '';
    while($not3 = mysql_fetch_array($result3))
	{
        $codigopro = $not3[c_cod];
        $nome_prop = $not3[c_nome];
        $referencia = $not3[ref];


        if($cont>0){
			$var = " e ";
		}
        $proprietarios .= $var.$nome_prop;

// Pegar dados do inquilino
	$query10 = "select c_cod, c_nome from clientes, locacao where c_cod=l_cliente and l_n_contrato='' and
	l_cod='$not1[l_cod]' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result10 = mysql_query($query10);
	$numrows10 = mysql_num_rows($result10);
	while($not10 = mysql_fetch_array($result10))
	{
		$inquilino = $not10[c_nome];
		$codinquilino = $not10[c_cod];
        //echo "Inquilinos ==> ".$not10[c_nome]." - ".$not10[c_cod];
	}
	//echo "Proprietario ==>".$proprietario."<BR>";
	if($codinquilino == $codigopro){
?>
<?php print("<b>Ref.:</b> $referencia - <b> RESERVA DO PROPRIETÁRIO ==> </b> $proprietarios"); ?>
<?php
	}
	else
	{
?>
<?php print("<b>Ref.:</b> $referencia- <b>Locatário:</b> $inquilino"); ?>
<?php
	}
?>
<?php

    $codinquilino = '';
    $proprietario = '';

    $cont++;
    }// Fim do While
    } // Fim do IF
?>
</td>
<td bgcolor="#<?php print("$fundo2"); ?>" class="style1" align="left">
<?php print("$data_sai"); ?> + 1 dia</td>
<!--td class="style1" align="left">
<a href="javascript:;" onClick="NewWindow('despesas_relatorio.php?l_cod=<?php print($not1['l_cod']); ?>&data_despesa=<?=$data_sai ?>', 'janela', 750, 500, 'yes')" class="style1"><b>Cadastrar Despesas</b></a></td-->
</tr>
<?php
	}  // Fim do While Maior
?>
<?php
	}   // Fim do IF Maior
	
	$query2 = "select count(l_imovel) as contador from locacao where 
	(l_data_sai BETWEEN '$ano_saida-$mes_saida-$dia_saida' AND '$ano_saida1-$mes_saida1-$dia_saida1') and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato=''";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$paginas = $pages = ceil($not2[contador] / 30);
    $pagina = $screen;
    $url = "p_rel_saidas.php?lista=1&dia_saida=".$dia_saida."&mes_saida=".$mes_saida."&ano_saida=".$ano_saida."&dia_saida1=".$dia_saida1."&mes_saida1=".$mes_saida1."&ano_saida1=".$ano_saida1."&screen=";
?>
                  <tr>
				  	<td colspan="3" class="fundoTabelaTitulo style1" align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> períodos</b></td>
				  </tr>
                  <tr>
				  	<td colspan="3" align="center" class="style1">
						<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_saidas.php?lista=1&dia_saida=<?=$dia_saida ?>&mes_saida=<?=$mes_saida ?>&ano_saida=<?=$ano_saida ?>&dia_saida1=<?=$dia_saida1 ?>&mes_saida1=<?=$mes_saida1 ?>&ano_saida1=<?=$ano_saida1 ?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_saidas.php?lista=1&dia_saida=<?=$dia_saida ?>&mes_saida=<?=$mes_saida ?>&ano_saida=<?=$ano_saida ?>&dia_saida1=<?=$dia_saida1 ?>&mes_saida1=<?=$mes_saida1 ?>&ano_saida1=<?=$ano_saida1 ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
                  				<td class="style1" align="center">
								<?
   									$i = 0;
   									$completa = "";
   									if ($paginas > 9){
      									if ($pagina < 5){
   	   										$inicio = 1;
         									$final = 9;
      									}elseif($pagina > $paginas - 5){
   	   										$inicio = $paginas - 9;
         									$final = $paginas;
      									}else{
   	   										$inicio = $pagina - 4;
         									$final = $pagina + 4;
      									}
   									}else{
	   										$inicio = 1;
      										$final = $paginas;
   									}

   									for ($j = $inicio; $j < ($final+1); $j++){
      									if(($paginas > 9) && (strlen($j)==1)){
		   									$j = "0".$j;
      									}

      									$url2 = $url . $j;

      									if($j == $pagina){
            								print "<a href=\"$url2\" class='style1'>| <b>$j</b> |</a>";
 	   									}else{
     	      								print "<a href=\"$url2\" class='style1'>| $j |</a>";
  	   									}
   									}
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_saidas.php?lista=1&dia_saida=<?=$dia_saida ?>&mes_saida=<?=$mes_saida ?>&ano_saida=<?=$ano_saida ?>&dia_saida1=<?=$dia_saida1 ?>&mes_saida1=<?=$mes_saida1 ?>&ano_saida1=<?=$ano_saida1 ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_saidas.php?lista=1&dia_saida=<?=$dia_saida ?>&mes_saida=<?=$mes_saida ?>&ano_saida=<?=$ano_saida ?>&dia_saida1=<?=$dia_saida1 ?>&mes_saida1=<?=$mes_saida1 ?>&ano_saida1=<?=$ano_saida1 ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>

<?php
	}
?>

<?
	}
?>
</td>
</tr>
</table>
<?php
/*
mysql_free_result($result1);
mysql_free_result($result2);
mysql_free_result($result3);
*/
	}

mysql_close($con);
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
