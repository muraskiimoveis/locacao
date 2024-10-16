<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
ini_set('set_time_limit', 0); // Sem limite de tempo na execução do relatorio
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_ENTRADAS");

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
  if (document.form1.dia_entrada.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.form1.dia_entrada.focus();
    return (false);
  }
  if (document.form1.mes_entrada.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.form1.mes_entrada.focus();
    return (false);
  }
  if (document.form1.ano_entrada.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.form1.ano_entrada.focus();
    return (false);
  }
  if (document.form1.dia_entrada1.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.form1.dia_entrada1.focus();
    return (false);
  }
  if (document.form1.mes_entrada1.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.form1.mes_entrada1.focus();
    return (false);
  }
  if (document.form1.ano_entrada1.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.form1.ano_entrada1.focus();
    return (false);
  }
  
  var data1 = form1.ano_entrada.value + form1.mes_entrada.value + form1.dia_entrada.value;
  var data2 = form1.ano_entrada1.value + form1.mes_entrada1.value + form1.dia_entrada1.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	document.form1.dia_entrada.focus();
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
	if($ano_entrada == ""){
		$ano_entrada = date(Y);
	}
	if($ano_entrada1 == ""){
		$ano_entrada1 = date(Y);
	}
	*/
?>
<div align="center">
  <center>
  <form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <input type=hidden name=cod value=<?php print("$cod"); ?>>
  <table width="75%" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td height="50" width="100%" colspan=2 class="style1"><p align="center"><b>Relatório de Entradas - Locação <!--Diária-->Temporada</b><br>
      Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar.</font></p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Período:</b></td>
      <td width="80%" class="style1">
      <input type="text" name="dia_entrada" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_entrada" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano_entrada" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_entrada"); ?>"> <b>à</b> <input type="text" name="dia_entrada1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes_entrada1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano_entrada1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano_entrada1"); ?>"><br>Ex.: 
    10/10/1910 à 20/10/1910</td>
    </tr>
    <tr>
      <td width="100%" colspan=2>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="1" name="lista">
      <input type="submit" value="Pesquisar" name="B1" class=campo3>
      <input type="submit" value="Imprimir" name="B1" class=campo3></td>
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
<tr height="50"><td colspan=4 class="style1">
<p align="center"><b>Relatório de Matriculas COPEL e/ou SANEPAR - Locação temporada - Data - <?php echo "De ".$dia_entrada."/".$mes_entrada."/".$ano_entrada." até ".$dia_entrada1."/".$mes_entrada1."/".$ano_entrada1;?></p>
</td></tr>
<?php
	$query_conta = "select count(l_imovel) as contador from locacao where
	(l_data_ent BETWEEN '$ano_entrada-$mes_entrada-$dia_entrada' AND '$ano_entrada1-$mes_entrada1-$dia_entrada1') and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato=''";
    $res_conta = mysql_query($query_conta);
	while($not_conta = mysql_fetch_array($res_conta)){$TotaldeRegistros = $not_conta[contador]; $pag = ceil($not_conta[contador] / 20);}
    $pinicio = 0;
    //echo " Mostra qtdade de paginas ==> ".$pag." Total de Registros => ".$TotaldeRegistros."<br>";
    for ($nump = 0; $nump < ($pag); $nump++)
    {
    if($nump == '0'){$limite = 'limit '.$pinicio.', 20';}else{$limite = 'limit '.$pinicio.', 30';}
    $pinicio = $pinicio + 30;
    //
	$query1 = "select * from locacao where
	(l_data_ent BETWEEN '$ano_entrada-$mes_entrada-$dia_entrada' AND '$ano_entrada1-$mes_entrada1-$dia_entrada1') and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato='' order by l_data_ent ".$limite;
    //echo " Mostra ==> ".$query1." - ".$nump."<br>";
    $result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
    if($nump == '0'){
?>
<tr class="fundoTabelaTitulo">
<td width="71" class="style1"><b>Entrada</b></td>
<td width="495" class="style1"><b>Imóvel  - Proprietário</b></td>
<td width="95" class="style1"><b>Saída</b></td>
</tr>

<tr class="CCCCCC">
<!-- <td width="71" valign="top" align="left">
<td width="495" class="style1"><b>Matricula -  [COPEL] e/ou [SANEPAR] </b></td>
-->
</tr>
<?php
    }
	$i = 1;
	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "CCCCCC";

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
<tr class="<?php echo $fundo;?>">
<td bgcolor="#<?php print("$fundo2"); ?>" class="style1" valign="top" align="left">
<?php print("$data_ent"); ?></td>
<td class="style1" valign="top" align="left">
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
	
	
	$query3 = "SELECT ref, left(titulo, 60), cod, zelador, diarista, matricula_luz, matricula_agua, c_nome, c_cod FROM muraski, clientes WHERE cod='$not1[l_imovel]' and muraski.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=clientes.c_cod and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);

	while($not3 = mysql_fetch_array($result3))
	{
	    $referencia = $not3['cod'];
    	$proprietario = $not3['c_cod'];
        $zelador = $not3['zelador'];
        $copel = $not3['matricula_luz'];
        $sanepar = $not3['matricula_agua'];
        $cod_diarista = $not3['diarista'];

    	//REALIZA BUSCA DO NOME DA DIARISTA
	    $qryD = "select * from clientes where c_cod='$cod_diarista' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	    $resD = mysql_query($qryD);
	    while($notD = mysql_fetch_array($resD))
	    {
            $nomediarista = $notD['c_nome'];
            $fonediarista = $notD['c_tel'];
	    }


	// Pegar dados do inquilino
	$query10 = "select c_cod, c_nome from clientes, locacao where c_cod=l_cliente and l_n_contrato='' and
	l_cod='$not1[l_cod]' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result10 = mysql_query($query10);
	$numrows10 = mysql_num_rows($result10);
	while($not10 = mysql_fetch_array($result10))
	{
		$inquilino = $not10[c_nome];
		$codinquilino = $not10[c_cod];
	}
?>
<?php print("<b>Ref.:</b> $not3[ref] - <b> PROPRIETÁRIO - </b> $inquilino"); ?>

<?php
    $codinquilino = '';
    $proprietario = '';
    }
?>
</td>
<td bgcolor="#<?php print("$fundo2"); ?>" class="style1" valign="top" align="left">
<?php print("$data_sai"); ?></a></td>
</tr>
<tr class="<?php echo $fundo;?>">
<td width="71" class="style1"><b></b></td>
<td width="495" class="style1" valign="top" align="left"> <b> COPEL => [</b><?php print(" ".$copel);?><b>] - SANEPAR => [</b><?php print(" ".$sanepar);?><b>]</b></td>
</tr>
<?php
      $nomediarista = '';
      $fonediarista = '';

    } // Fim do While

?>
<?php


    }  // O Prmeiro IF acaba AKI.
?>
<!--
   <tr>
     <br>
     <br>
     <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
     <td witdh="670" height="1" colspan=4></td>
     <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
     <br>
     <br>
     <br>
   </tr>
-->
<?php
    mysql_free_result($result1);
    }  // O FOR
    
	$query2 = "select count(l_imovel) as contador from locacao where
	(l_data_ent BETWEEN '$ano_entrada-$mes_entrada-$dia_entrada' AND '$ano_entrada1-$mes_entrada1-$dia_entrada1') and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato=''";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$paginas = $pages = ceil($not2[contador] / 20);
    //$pagina = $screen;
    //$url = "p_rel_entradas.php?lista=1&dia_entrada=".$dia_entrada."&mes_entrada=".$mes_entrada."&ano_entrada=".$ano_entrada."&dia_entrada1=".$dia_entrada1."&mes_entrada1=".$mes_entrada1."&ano_entrada1=".$ano_entrada1."&screen=";
?>
                  <tr>
				  	<td colspan="4" class="fundoTabelaTitulo style1" align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> períodos</b></td>
				  </tr>

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
