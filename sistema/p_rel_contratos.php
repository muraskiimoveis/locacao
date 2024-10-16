<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<html>

<head>
<?php
include("style.php");
include("conect.php");
include("l_funcoes.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
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
  if (document.form1.dia.value == "")
  {
    alert("Por favor, digite o Dia desejado");
    document.form1.dia.focus();
    return (false);
  }
  if (document.form1.mes.value == "")
  {
    alert("Por favor, digite o Mês desejado");
    document.form1.mes.focus();
    return (false);
  }
  if (document.form1.ano.value == "")
  {
    alert("Por favor, digite o Ano desejado");
    document.form1.ano.focus();
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
	//$ano = date(Y);
	//$ano1 = date(Y);
?>
<div align="center">
  <center>
  <form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <input type=hidden name=cod value=<?php print("$cod"); ?>>
  <table width="75%" border="0" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Relatório de Opções</b><br>
 Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar.</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Período:</b></td>
      <td width="70%" class="style1">
      <input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value=<?php print("$dia"); ?>>/<input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value=<?php print("$mes"); ?>>/<input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"> 
      <b>&agrave;</b>
      <input type="text" name="dia1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia1"); ?>">/<input type="text" name="mes1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes1"); ?>">/<input type="text" name="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano1"); ?>">
      <br>
      Ex.: 
    10/10/1910 &agrave; 20/10/1910</td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Situação:</b></td>
      <td width="70%" class="style1"><select name="status" class=campo>
      				<option value="Vigente">Vigente</option>
      				<option value="Encerrado">Encerrado</option>
      			</select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Finalidade:</b></td>
      <td width="70%" class="style1"><select name="finalidade" class=campo>
      		<?php
        $bfinalidade = mysql_query("select f_cod, f_nome FROM finalidade WHERE f_cod!='1' AND f_cod!='8' ORDER BY f_cod ASC");
 		while($linha = mysql_fetch_array($bfinalidade)){
			if($linha[f_cod]==$_POST['finalidade']){
			   if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>'); 
			   }else{
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'</option>'); 
			   }
			}else{
			  if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>');
			  }else{
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'</option>');
			  } 
			}
        }
 	    ?>
      			</select></td>
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
	
	if($finalidade=='7'){
	  $query_finalidade = " AND (finalidade='1' OR finalidade='2' OR finalidade='3' OR finalidade='4' OR finalidade='5' OR finalidade='6' OR finalidade='7')";
	}elseif($finalidade=='14' || $finalidade=='17'){
	  $query_finalidade = " AND (finalidade='8' OR finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR finalidade='17')";
	}elseif($finalidade<>'%'){
	  $query_finalidade = "AND finalidade='".$finalidade."'";
	}else{
	  $query_finalidade = "AND finalidade like '%'";
	}  

if($lista == "1")
	{
?>
<?
if($finalidade=='1'){
  $fin = "Venda_Rebri";
}elseif($finalidade=='2'){
  $fin = "Venda_".$_SESSION['nome_imobiliaria'];
}elseif($finalidade=='3'){
  $fin = "Venda_Parceria";
}elseif($finalidade=='4'){
  $fin = "Venda_Terceiros";
}elseif($finalidade=='5'){
  $fin = "Venda_Off";
}elseif($finalidade=='6'){
  $fin = "Venda_Vendido";
}elseif($finalidade=='7'){
  $fin = "Venda_Todos";
}elseif($finalidade=='8'){
  $fin = "Locação_Anual_Rebri";
}elseif($finalidade=='9'){
  $fin = "Locação_Anual_".$_SESSION['nome_imobiliaria'];
}elseif($finalidade=='10'){
  $fin = "Locação_Anual_Parceria";
}elseif($finalidade=='11'){
  $fin = "Locação_Anual_Terceiros";
}elseif($finalidade=='12'){
  $fin = "Locação_Anual_Off";
}elseif($finalidade=='13'){
  $fin = "Locação_Anual_Locado";
}elseif($finalidade=='14'){
  $fin = "Locação_Anual_Todos";
}elseif($finalidade=='15'){
  $fin = "Locação_Temporada_".$_SESSION['nome_imobiliaria'];
}elseif($finalidade=='16'){
  $fin = "Locação_Temporada_Off";
}elseif($finalidade=='17'){
  $fin = "Locação_Temporada_Todos";
}
?>
<div align="center">
  <center>
<table width="75%" border="0" cellpadding="1" cellspacing="1">
<tr height="50"><td colspan=3 class="style1">
<p align="center"><b>Relatório de Contratos</b> - Status: <b><?php print("$status"); ?></b> - Finalidade: <b><?php print($fin); ?></b></p>
</td></tr>
<?php
	if($status == "Vigente"){
	    /*
		$query1 = "select * from muraski 
		where ('$ano-$mes-$dia' BETWEEN data_inicio AND date_add(data_fim, interval 30 day)) and finalidade='$finalidade' 
		order by data_fim limit $from, 30";
		*/
		$query1 = "select * from muraski 
		where  data_inicio >= ('$ano-$mes-$dia') AND data_fim >= ('$ano1-$mes1-$dia1') $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
		order by data_fim limit $from, 30";
	}
	elseif($status == "Encerrado"){
		/*
		$query1 = "select * from muraski 
		where ('$ano-$mes-$dia' not BETWEEN data_inicio AND date_add(data_fim, interval 30 day)) and finalidade='$finalidade' 
		order by data_fim limit $from, 30";
		*/
		$query1 = "select * from muraski 
		where data_inicio >= ('$ano-$mes-$dia') AND data_fim <= ('$ano1-$mes1-$dia1') $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
		order by data_fim limit $from, 30";
	}
	//echo $query1;
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<tr class="fundoTabelaTitulo">
<td width=50 class="style1"><b>Início</td>
<td width=450 class="style1"><b>Imóvel</td>
<td width=50 class="style1"><b>Término</td>
</tr>
<?php
	$i = 0;

	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{

	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "CCCCCC";

			      $ano2 = substr ($not1[data_inicio], 0, 4);
		        $mes2 = substr($not1[data_inicio], 5, 2 );
		        $dia2 = substr ($not1[data_inicio], 8, 2 );
		        $ano3 = substr ($not1[data_fim], 0, 4);
		        $mes3 = substr($not1[data_fim], 5, 2 );
		        $dia3 = substr ($not1[data_fim], 8, 2 );
		        $data_ent = "$dia2/$mes2/$ano2";
		        $data_sai = "$dia3/$mes3/$ano3";
?>
<tr class="<?php print("$fundo"); ?>">
<td class="fundoTabelaTitulo style1"><p align="left">

<?php print("$data_ent"); ?></a></td>
<td>
<?php
	//$query3 = "SELECT ref, left(titulo, 60) FROM muraski WHERE cod='$not1[l_imovel]'";
	/*
	$query20 = "SELECT cliente, contador FROM muraski, clientes WHERE cod='$not1[cod]' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	*/
		
	$query3 = "SELECT ref, titulo, cod FROM muraski WHERE cod='$not1[cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	 
?>
<p align="left">

<a href="p_edit_imoveis.php?edit=editar&cod=<?php print("$not3[cod]"); ?>" class="style1">
<?php print("<b>Ref.: $not3[ref]</b>"); ?> - <?php print strip_tags($not3[titulo]); ?></a></p>
<?php
	}
?>
</td>
<td class="fundoTabelaTitulo style1"><p align="left">

<?php print("$data_sai"); ?></a></td>
</tr>
<?php
	}
?>
<?php
	}
	
	if($status == "Vigente"){
		/*
		$query2 = "select count(cod) as contador from muraski where 
		('$ano-$mes-$dia' BETWEEN data_inicio AND date_add(data_fim, interval 30 day)) and finalidade='$finalidade'";
		*/
		$query2 = "select count(cod) as contador from muraski where 
		data_inicio >= ('$ano-$mes-$dia') AND data_fim >= ('$ano1-$mes1-$dia1') $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}
	elseif($status == "Encerrado"){
		/*
		$query2 = "select count(cod) as contador from muraski where 
		('$ano-$mes-$dia' not BETWEEN data_inicio AND date_add(data_fim, interval 30 day)) and finalidade='$finalidade'";
		*/
		$query2 = "select count(cod) as contador from muraski where 
		data_inicio >= ('$ano-$mes-$dia') AND data_fim <= ('$ano1-$mes1-$dia1') $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$paginas = $pages = ceil($not2[contador] / 30);
    $pagina = $screen;
    $url = "p_rel_contratos.php?lista=1&dia=".$dia."&mes=".$mes."&ano=".$ano."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&status=".$status."&query_finalidade=".$query_finalidade."&finalidade=".$finalidade."&screen=";
?>
                  <tr>
				  	<td colspan="3" class="fundoTabelaTitulo style1" align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> imóveis</b></td>
				  </tr>
                  <tr>
				  	<td colspan="3" class="style1" align="center">
						<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_contratos.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&status=<?=$status ?>&query_finalidade=<?=$query_finalidade ?>&finalidade=<?=$finalidade ?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_contratos.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&status=<?=$status ?>&query_finalidade=<?=$query_finalidade ?>&finalidade=<?=$finalidade ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
                  				<td width="10%" class="style1" align="center"><a href="p_rel_contratos.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&status=<?=$status ?>&query_finalidade=<?=$query_finalidade ?>&finalidade=<?=$finalidade ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_contratos.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&status=<?=$status ?>&query_finalidade=<?=$query_finalidade ?>&finalidade=<?=$finalidade ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
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