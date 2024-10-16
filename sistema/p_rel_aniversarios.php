<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_ANIVER");
?>
<html>

<head>
<?php
include("style.php");
?>
<link type="text/css" rel="stylesheet" href="css/estilos_sistema.css" />
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
?>
<?php
	if($lista == ""){
?>
<script language="javascript">
function valida()
{
  if (document.form1.mes.value == "")
  {
    alert("Por favor, digite o Mês desejado");
    document.form1.mes.focus();
    return (false);
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
	$dia = date(d);
	$mes = date(m);
	$ano = date(Y);
?>
<div align="center">
  <center>
  <form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <input type=hidden name=cod value=<?php print("$cod"); ?>>
  <table width="75%" border="0" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Relatório de Aniversariantes</b><br>
 Preencha o mês que você deseja visualizar os aniversariantes e clique em pesquisar.</font></p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Dia/Mês:</b></font></td>
      <td width="70%" class="style1">
      <input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="">/<input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value=<?php print("$mes"); ?>><br>Ex.: Digite o dia e mês que deseja pesquisar os aniversariantes.</font></td>
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
	  
	if(strlen($dia)==1){
	   $dia = "0".$dia;
	} 
	
	if(strlen($mes)==1){
	   $mes = "0".$mes;
	} 
?>
<div align="center">
  <center>
<table width="75%" border="0" cellpadding="1" cellspacing="1">
<tr height="50"><td colspan=2 class="style1">
<p align="center"><b>Relatório de Aniversariantes do dia/mês: <?php print("$dia/$mes"); ?></p>
</td></tr>
<?php
	//$query1 = "select cli.c_cod, cli.c_nome, cli.c_nasc, tcl.tc_tipo from clientes cli, relacao_cliente_tipo rct, tipos_clientes tcl where cli.c_cod = rct.c_cod and rct.tc_cod = tcl.tc_cod and month(cli.c_nasc) = '$mes' and dayofmonth(cli.c_nasc) like '%$dia%' and cli.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by cli.c_nome, cli.c_nasc limit $from, 30";

    if(substr($dia,0,1)=="0"){
	  $query1 = "SELECT c_cod, c_nome, c_nasc, c_tipo, c_tipo2, c_prestador, c_prestador2 FROM clientes WHERE month(c_nasc) = '$mes' AND dayofmonth(c_nasc) = '$dia' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c_nome, c_nasc limit $from, 30";
    }else{
	  $query1 = "SELECT c_cod, c_nome, c_nasc, c_tipo, c_tipo2, c_prestador, c_prestador2 FROM clientes WHERE month(c_nasc) = '$mes' AND dayofmonth(c_nasc) like '%$dia%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c_nome, c_nasc limit $from, 30";
    }

    echo "Mostra ==> ".$query1;
    //die();
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1)
?>
<tr class="fundoTabelaTitulo">
<td width="20%" class="style1"><p align="center"><b>Aniversário</b></td>
<td width="80%" class="style1"><p align="center"><b>Nome do Cliente</b></td>
</tr>
<?php
	$i = 0;

	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "CCCCCC";

			      $ano2 = substr ($not1[c_nasc], 0, 4);
		        $mes2 = substr($not1[c_nasc], 5, 2 );
		        $dia2 = substr ($not1[c_nasc], 8, 2 );
		        $data_ent = "$dia2/$mes2/$ano2";
?>
<tr class="<?php echo $fundo; ?>">
<td class="style1"><p align="left">
<?php print("$data_ent"); ?></a></td>
<td class="style1">
<?
if ($not1[c_tipo2] == "") {
?>
   <a href="p_clientes.php?lista=1&c_cod=<?=$not1[c_cod]?>" class="style1"><?=$not1[c_nome]?> - (<?=$not1[c_tipo]?>)</a>
<?
} else {
   $t_tipo = explode("--", $not1[c_tipo2]);
   $t_tipo = str_replace("-","",$t_tipo);
   if (count($t_tipo) == 0) {
?>
   <a href="p_clientes.php?lista=1&c_cod=<?=$not1[c_cod]?>" class="style1"><?=$not1[c_nome]?> - (<?=$not1[c_tipo]?>)</a>
<?
   } else {
?>
<table cellpadding="0" cellspacing="0" align=left>
<tr>
<td>
   <a href="p_clientes.php?lista=1&c_cod=<?=$not1[c_cod]?>" class="style1"><?=$not1[c_nome]?></a>
</td>
<td width=10></td>
<td>
<?

      $caminho_imgs = "images/";
      foreach ($t_tipo as $tipos) {
         if ($tipos == 5) {
            $t_prestador = explode("--", $not1[c_prestador2]);
            $t_prestador = str_replace("-","",$t_prestador);
            if (count($t_prestador) > 0) {
		         foreach ($t_prestador as $prestadores) {
                  $sql = "SELECT tp_tipo, tp_icone FROM tipos_prestadores WHERE tp_cod = '$prestadores'";
                  $rs = mysql_query($sql) or die ("Erro 173");
                  $n = mysql_fetch_assoc($rs);
                  if ($n[tp_icone] <> "") {
?>
               <img src="<?=$caminho_imgs.$n[tp_icone]?>" title="<?=$n[tp_tipo]?>" border=0 />
<?
                  }
		         }
            }

         } else {
            $sql = "SELECT tc_tipo, tc_icone FROM tipos_clientes WHERE tc_cod = '$tipos'";
            $rs = mysql_query($sql) or die ("Erro 173");
            $n = mysql_fetch_assoc($rs);
            if ($n[tc_icone] <> "") {
?>
               <img src="<?=$caminho_imgs.$n[tc_icone]?>" title="<?=$n[tc_tipo]?>" border=0 />
<?
            }
         }
      }
?>
</td>
</tr>
</table>
<?
   }
}
?>
</td>
</tr>
<?php
	}
?>
<?php
	}

	//$query2 = "select count(cli.c_cod) as contador from clientes cli, relacao_cliente_tipo rct, tipos_clientes tcl where cli.c_cod = rct.c_cod and rct.tc_cod = tcl.tc_cod and month(cli.c_nasc) = '$mes' and dayofmonth(cli.c_nasc) like '%$dia%' and cli.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	
	$query2 = "SELECT count(c_cod) as contador FROM clientes WHERE month(c_nasc) = '$mes' AND dayofmonth(c_nasc) like '%$dia%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				 	
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$paginas = $pages = ceil($not2[contador] / 30);
    $pagina = $screen;
    $url = "p_rel_aniversarios.php?lista=1&dia=".$dia."&mes=".$mes."&ano=".$ano."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&screen=";
?>
                  <tr class="fundoTabelaTitulo">
				  	<td colspan="3" class="style1" align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> aniversariantes</b></td>
				  </tr>
                  <tr>
				  	<td colspan="3" class="style1" align="center">
						<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_aniversarios.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_aniversarios.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
                  				<td width="10%" class="style1" align="center"><a href="p_rel_aniversarios.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_aniversarios.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
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
//mysql_free_result($result1);
//mysql_free_result($result2);
//mysql_free_result($result3);
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
