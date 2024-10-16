<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_LOCA");

?>
<html>

<head>
<?php
include("style.php");

?>
<script language="javascript">
function confirmaExclusao(l_cod,cod,dia2,mes2,ano2,dia3,mes3,ano3,list,lista)
{
       if(confirm("Tem certeza que deseja excluir?"))
          document.location.href='p_rel_loc.php?id_excluir=' + l_cod + '&cod=' + cod + '&dia2=' + dia2 + '&mes2=' + mes2 + '&ano2=' + ano2 + '&dia3=' + dia3 + '&mes3=' + mes3 + '&ano3=' + ano3 + '&list=' + list + '&lista=' + lista + '&B1=Pesquisar';
}
    
</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
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
?>
<?php
	if($lista == ""){
?>
<script language="javascript">
function valida()
{
  if (document.form1.dia2.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.form1.dia2.focus();
    return (false);
  }
  if (document.form1.mes2.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.form1.mes2.focus();
    return (false);
  }
  if (document.form1.ano2.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.form1.ano2.focus();
    return (false);
  }
  if (document.form1.dia3.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.form1.dia3.focus();
    return (false);
  }
  if (document.form1.mes3.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.form1.mes3.focus();
    return (false);
  }
  if (document.form1.ano3.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.form1.ano3.focus();
    return (false);
  }
  
  var data1 = document.form1.ano2.value + document.form1.mes2.value + document.form1.dia2.value;
  var data2 = document.form1.ano3.value + document.form1.mes3.value + document.form1.dia3.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	form1.dia2.focus();
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
	$ano = date(Y);
?>
<div align="center">
  <center>
  <form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <input type=hidden name=cod value=<?php print("$cod"); ?>>
  <table width="75%" border="0" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td width="100%" colspan="2" class="style1"><p align="center"><b>Relatório de Imóvel</b><br>
 Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar.</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Período:</b></td>
      <td width="70%" class=style1>
      <input type="text" name="dia2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano2" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value=""> <b>à</b> <input type="text" name="dia3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano3" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value=""><br>Ex.: 
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
	
	if($_GET['id_excluir']){
  
    $l_cod = $_GET['id_excluir'];
	
	$query4= "delete from locacao where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível apagar suas informações.");
	
	$query5= "delete from contas where co_locacao='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result5 = mysql_query($query5) or die("Não foi possível apagar suas informações. $query5");
	
	}
	
	
	/*
	if($alterar == 1){
	if($bot == "Apagar"){
	$query4= "delete from locacao where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível apagar suas informações.");
	
	$query5= "delete from contas where co_locacao='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result5 = mysql_query($query5) or die("Não foi possível apagar suas informações. $query5");
	}
	*/
	/*
	else
	{
	$l_total = str_replace(".", "", $l_total);
	$l_total = str_replace(",", ".", $l_total);
	//$l_comissao = str_replace(".", "", $l_comissao);
	//$l_comissao = str_replace(",", ".", $l_comissao);
	$l_desp = str_replace(".", "", $l_desp);
	$l_desp = str_replace(",", ".", $l_desp);
	$l_saldo = $l_total - ($l_comissao + $l_desp);
	//$l_saldo = str_replace(".", "", $l_saldo);
	//$l_saldo = str_replace(",", ".", $l_saldo);
	$query4= "update locacao set l_historico='$l_historico', l_desp='$l_desp', l_saldo='$l_saldo' where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	
	$query5= "select * from contas where co_locacao='$l_cod' and co_tipo='Despesas' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result5 = mysql_query($query5) or die("Não foi possível pesquisar suas informações. $query5");
	$numrows5 = mysql_num_rows($result5);
	if($numrows5 > 0){
	while($not5 = mysql_fetch_array($result5))
	{
		
	$query6= "update contas set co_desc='$l_historico', co_valor='$l_desp' where co_cod='$not5[co_cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result6 = mysql_query($query6) or die("Não foi possível atualizar suas informações. $query6");
	
	}//termina while
	}
	else
	{
	
	$query7= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario) 
	values('".$_SESSION['cod_imobiliaria']."', '$l_cliente', 'Receber', '$cod', '$l_historico', 'Despesas', current_date, 'pendente', '$l_desp'
	, '$l_cod', '$valid_user')";
	$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações. $query7");
	
	}//Termina numrows5
	}
	*/	
//mysql_free_result($result4);
	//}

if($lista == "1")
	{
?>
<div align="center">
  <center>
<form method="post" action="" name="form2">
<table border="0" cellspacing="1" width="90%">
<?php
	$query3 = "SELECT * FROM muraski WHERE cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);

	while($not3 = mysql_fetch_array($result3))
	{
?>
<tr height="50">
	<td colspan=8 class=style1>
<p align="center"><b>Relatório de Locação do imóvel <a href=p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar class="style1">Ref.: <?php print("$not3[ref]"); ?></a></b><br />Para excluir uma reserva, clique nos botões do lado direito.</p>
	</td>
</tr>
<!--tr>
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=8 class=style2 align=center>
<a href=p_extrato_depositos.php?cod_imovel=<?php print("$cod"); ?> class="style1">Clique para visualizar todos os relatórios de depósitos</a></td>
	</tr-->
<?php
	}

	$query1 = "select * from locacao where l_imovel='$cod' and 
	(l_data_ent BETWEEN '$ano2-$mes2-$dia2' AND '$ano3-$mes3-$dia3' OR
	l_data_sai BETWEEN '$ano2-$mes2-$dia2' AND '$ano3-$mes3-$dia3') and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato=''
	 order by l_data_ent 
	limit $from, 30";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<tr class="fundoTabelaTitulo">
<td width=60 class=style1><b>Entrada</td>
<td width=240 class=style1><b>Locatário</td>
<td width=70 class=style6><b>Crédito</td>
<td width=70 class=style7><b>Comissão</td>
<td width=60 class=style1><b>Limpeza</td>
<td width=60 class=style1><b>TV</td>
<td width=50></td>
</tr>
<tr class="fundoTabelaTitulo">
<td width=60 class=style1><b>Saída</td>
<td width=240 class=style1><b>Histórico de Despesas</td>
<td width=70 class=style7><b>Despesas</td>
<td width=70 class=style6><b>Saldo</td>
<td width=60 class=style1><b>Contrato</td>
<td width=60 class=style1><b>Depósitos</td>
<td width=50 class="style1"></td>
</tr>
<?php
	$i = 0;

	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "$cor7";
	
		        $ano = substr ($not1[l_data_ent], 0, 4);
		        $mes = substr($not1[l_data_ent], 5, 2 );
		        $dia = substr ($not1[l_data_ent], 8, 2 );
		        $ano1 = substr ($not1[l_data_sai], 0, 4);
		        $mes1 = substr($not1[l_data_sai], 5, 2 );
		        $dia1 = substr ($not1[l_data_sai], 8, 2 );
		   			
	$data = mktime(0,0,0, $mes, $dia, $ano);
	$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);
	
	$diarias = round(($data1 - $data)/(24*60*60));
	$diarias = $diarias + 1;
	
	$total_dias = $diarias + $total_dias;
		   			
		   		$ano4 = substr ($not1[l_data], 0, 4);
		        $mes4 = substr($not1[l_data], 5, 2 );
		        $dia4 = substr ($not1[l_data], 8, 2 );
		        $data_ent = "$dia/$mes/$ano";
		        $data_sai = "$dia1/$mes1/$ano1";
		        $data_res = "$dia4/$mes4/$ano4";

?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="dia2" value="<?php print("$dia2"); ?>">
<input type="hidden" name="mes2" value="<?php print("$mes2"); ?>">
<input type="hidden" name="ano2" value="<?php print("$ano2"); ?>">
<input type="hidden" name="dia3" value="<?php print("$dia3"); ?>">
<input type="hidden" name="mes3" value="<?php print("$mes3"); ?>">
<input type="hidden" name="ano3" value="<?php print("$ano3"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$not1[l_cod]"); ?>">
<input type="hidden" name="cod" value="<?php print("$not1[l_imovel]"); ?>">
<input type="hidden" name="l_comissao" value="<?php print("$not1[l_comissao]"); ?>">
<input type="hidden" name="l_limpeza" value="<?php print("$not1[l_limpeza]"); ?>">
<input type="hidden" name="l_tv" value="<?php print("$not1[l_tv]"); ?>">
<input type="hidden" name="l_desp" value="<?php print("$not1[l_desp]"); ?>">
<input type="hidden" name="l_cliente" value="<?php print("$not1[l_cliente]"); ?>">
<input type="hidden" name="alterar" value="1">
<input type="hidden" name="lista" value="1">
<tr class="<? echo $fundo;?>">
<td><p align="left" class=style1>
<?php print("$data_ent"); ?></a></td>
<td>
<?php
	$query3 = "select c_nome from clientes where c_cod='$not1[l_cliente]' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	while($not3 = mysql_fetch_array($result3))
	{
?>
<p align="left" class=style1>
<?php print("$not3[c_nome]"); ?>
<?php
	}
	//$l_total = $not1[l_total] + $not1[l_limpeza];
	$saldo_total = $not1['l_saldo'] + $saldo_total;
	$total_total = $not1['l_total'] + $total_total;
	$limpeza_total = $not1['l_limpeza'] + $limpeza_total;
	$tv_total = $not1['l_tv'] + $tv_total;
	$outros_total = $not1['l_outros'] + $outros_total;
	$l_desp_total = $not1['l_desp'] + $l_desp_total;
	$comissao_total = $not1['l_comissao'] + $comissao_total;
	$total = number_format($not1['l_total'], 2, ',', '.');
	$comissao = number_format($not1['l_comissao'], 2, ',', '.');
	$saldo = number_format($not1['l_saldo'], 2, ',', '.');
	$outros = number_format($not1['l_outros'], 2, ',', '.');
	$limpeza = number_format($not1['l_limpeza'], 2, ',', '.');
	$l_desp = number_format($not1['l_desp'], 2, ',', '.');
	$tv = number_format($not1['l_tv'], 2, ',', '.');
	$saldo_atual = 0;

	/*
	$query4 = "select d_saldo from depositos where d_loc='$not1[l_cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by d_data desc, d_cod desc limit 1";
	//echo "- " . $query4 . " - ";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{
		$saldo_atual = $not4['d_saldo'];
	}
	}
	else
	{
		$saldo_atual = $not1['l_saldo'];
	}
	
	$saldo_clientes = $saldo_atual + $saldo_clientes;
	*/
	$query4 = "select sum(co_valor) as pagar from contas where co_locacao='$not1[l_cod]' and co_status='pendente' and co_cat='Pagar' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{
		$saldo_pagar = $not4[pagar];
	}
	}
	
	$saldo_clientes = $saldo_pagar + $saldo_clientes;
	//echo "  <i>" . $saldo_atual . " <> " . $saldo_clientes . "<i>";
	
	$query4 = "select sum(co_valor) as receber from contas where co_locacao='$not1[l_cod]' and co_status='pendente' and co_cat='Receber' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{
		$saldo_receber = $not4[receber];
	}
	}
	
	$receber_clientes = $saldo_receber + $receber_clientes;
?>
</td>
<td>
<input type="hidden" name="l_total" value="<?php print("$total"); ?>">
<p align="left" class=style6>R$ 
<?php print("$total"); ?></td>
<td>
<p align="left" class=style7>R$ 
<?php print("$comissao"); ?></td>
<td>
<p align="left" class=style1>R$ 
<?php print("$limpeza"); ?></td>
<td>
<p align="left" class=style1>R$ 
<?php print("$tv"); ?></td>
<td>
<p align="left" class=style1>
<?php
if(verificaFuncao("USER_LIBERAR_ACESSO")){
?>
<!--a href="#" onClick="if (confirm('Deseja Realmente excluir a locação?')) { window.location='p_rel_loc.php?bot=Apagar&dia2=<?php print("$dia2"); ?>&mes2=<?php print("$mes2"); ?>&ano2=<?php print("$ano2"); ?>&dia3=<?php print("$dia3"); ?>&mes3=<?php print("$mes3"); ?>&ano3=<?php print("$ano3"); ?>&alterar=1&lista=1&l_cod=<?php print("$not1[l_cod]"); ?>&cod=<?php print("$not1[l_imovel]"); ?>'; }" class="style1">Apagar</a-->
<input type="button" value="Apagar" class="campo3" name="bot" onClick="javascript:confirmaExclusao(<?=$not1['l_cod'] ?>,<?=$cod ?>,'<?=$dia2 ?>','<?=$mes2 ?>','<?=$ano2 ?>','<?=$dia3 ?>','<?=$mes3 ?>','<?=$ano3 ?>', '<?=$list ?>','<?=$lista ?>')">
<?php
	}
?>
</td>
</tr>
<tr class="<?php echo $fundo;?>">
<td><p align="left" class=style1>
<?php print("$data_sai"); ?></a></td>
<td>
<p align="left" class=style1>
<a href="javascript:;" onClick="NewWindow('p_loc_despesas.php?l_cod=<?php print("$not1[l_cod]"); ?>', 'janela', 750, 500, 'yes')" class=style1><b>Cadastrar Despesas</b></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="NewWindow('p_despesas_nova.php?l_cod=<?php print("$not1[l_cod]"); ?>&cod=<?php print("$cod"); ?>', 'janela1', 950, 600, 'yes')" class="style1"><b>Cadastrar Serviços</b></a></p></td>
<td>
<p align="left" class=style7>
R$ 
<?php 

	$query10 = "select c.co_valor from contas c where c.co_locacao='".$not1[l_cod]."' and c.co_tipo='Despesas' and c.co_cat='Receber' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
	$result10 = mysql_query($query10);
	$total_despesa = '';
	while($not10 = mysql_fetch_array($result10)){
	  	$despesa = $not10['co_valor'];
		$total_despesa = $total_despesa + $not10['co_valor'];
		$total_geral = $total_geral + $not10['co_valor'];
    }	

	if($despesa<>'0.00'){
			echo number_format($total_despesa, 2, ',', '.');
		}else{
			echo "0,00";
		} 
?></td>
<td>
<p align="left" class=style6>R$
<?php print("$saldo"); ?></td>
<td>
<p align="left" class=style1>
<a href="#" onclick = "NewWindow('p_imp_doc.php?imp=9&cod=<?php print("$not1[l_imovel]"); ?>&l_cod=<?php print("$not1[l_cod]"); ?>', 'janela', 750, 500, 'yes')" class="style1">
Imprimir</a></td>
<td>
<p align="left" class=style1>
<a href="#" onclick = "NewWindow('p_extrato_depositos.php?locacao=<?php print("$not1[l_cod]"); ?>&cod_imovel=<?=$not1[l_imovel] ?>&tipo_pesq=locacao', 'janela', 750, 500, 'yes')" class="style1">
Depósitos</a></td>
<td>
<p align="left" class=style1></td>
</tr>
</form>
<?php
	}
	$total_total = number_format($total_total, 2, ',', '.');
	$saldo_total = number_format($saldo_total, 2, ',', '.');
	$limpeza_total = number_format($limpeza_total, 2, ',', '.');
	$tv_total = number_format($tv_total, 2, ',', '.');
	$outros_total = number_format($outros_total, 2, ',', '.');
	$l_desp_total = number_format($l_desp_total, 2, ',', '.');
	$comissao_total = number_format($comissao_total, 2, ',', '.');
	$saldo_clientes = number_format($saldo_clientes, 2, ',', '.');
	$receber_clientes = number_format($receber_clientes, 2, ',', '.');
?>
<?php
if(verificaFuncao("USER_LIBERAR_ACESSO")){
?>
<tr>
<td class="fundoTabela" colspan=2><p align="left" class=style1><b>Crédito Total:
</td>
<td class="fundoTabela" colspan=6>
<p align="left" class=style1><b>R$ 
<?php print("$total_total"); ?>
</td></tr>
<tr>
<td class="fundoTabela" colspan=2><p align="left" class=style1>Total TV:
</td>
<td class="fundoTabela" colspan=6>
<p align="left" class=style1>R$ 
<?php print("$tv_total"); ?>
</td></tr>
<tr>
<td class="fundoTabela" colspan=2><p align="left" class=style1>Total Limpeza:
</td>
<td class="fundoTabela" colspan=6>
<p align="left" class=style1>R$ 
<?php print("$limpeza_total"); ?>
</td></tr>
<!--tr>
<td class="fundoTabela" colspan=2><p align="left" class=style1>Total Outros:
</td>
<td class="fundoTabela" colspan=6>
<p align="left" class=style1>R$ 
<?php print("$outros_total"); ?>
</td></tr-->
<tr>
<td class="fundoTabela" colspan=2><p align="left" class=style1>Total Despesas:
</td>
<td class="fundoTabela" colspan=6>
<p align="left" class=style1>R$ 
<?php print("$l_desp_total"); ?>
</td></tr>
<tr>
<td class="fundoTabela" colspan=2><p align="left" class=style1><b>Total Comissões:
</td>
<td class="fundoTabela" colspan=6>
<p align="left" class=style1><b>R$ 
<?php print("$comissao_total"); ?>
</td></tr>
<tr>
<td class="fundoTabela" colspan=2><p align="left" class=style1>Saldo Total:
</td>
<td class="fundoTabela" colspan=6>
<p align="left" class=style1>R$ 
<?php print("$saldo_total"); ?>
</td></tr>
<tr>
<td class="fundoTabela" colspan=2><p align="left" class=style6>Saldo total que falta receber:
</td>
<td class="fundoTabela" colspan=6>
<p align="left" class=style6>R$ 
<?php print("$receber_clientes"); ?>
</td></tr>
<tr>
<td class="fundoTabela" colspan=2><p align="left" class=style7>Saldo total que falta depositar:
</td>
<td class="fundoTabela" colspan=6>
<p align="left" class=style7>R$ 
<?php print("$saldo_clientes"); ?>
</td></tr>
<?php
	}
?>
<?php
	}
	
	$query2 = "select count(l_imovel) as contador from locacao where l_imovel='$cod' and l_n_contrato='' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and 
	(l_data_ent BETWEEN '$ano2-$mes2-$dia2' AND '$ano3-$mes3-$dia3' OR
	l_data_sai BETWEEN '$ano2-$mes2-$dia2' AND '$ano3-$mes3-$dia3')";
	//echo $query2;
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2['contador'] / 30);
?>
                  <tr>
                    <td colspan=8 class="fundoTabelaTitulo style1" align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> períodos</b></td>
                  </tr>
                  <tr>
                    <td colspan=8 class="fundoTabelaTitulo style1" align="center"><b>Total de <?php print("$total_dias"); ?> diárias</b></td>
                  </tr>
                  <tr>
				  	<td colspan="8" align="center" class="style1">
				  		<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_loc.php?lista=1&cod=<?=$cod ?>&dia2=<?=$dia2 ?>&mes2=<?=$mes2 ?>&ano2=<?=$ano2 ?>&dia3=<?=$dia3 ?>&mes3=<?=$mes3 ?>&ano3=<?=$ano3 ?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_loc.php?lista=1&cod=<?=$cod ?>&dia2=<?=$dia2 ?>&mes2=<?=$mes2 ?>&ano2=<?=$ano2 ?>&dia3=<?=$dia3 ?>&mes3=<?=$mes3 ?>&ano3=<?=$ano3 ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
                  				<td width="10%" class="style1" align="center"><a href="p_rel_loc.php?lista=1&cod=<?=$cod ?>&dia2=<?=$dia2 ?>&mes2=<?=$mes2 ?>&ano2=<?=$ano2 ?>&dia3=<?=$dia3 ?>&mes3=<?=$mes3 ?>&ano3=<?=$ano3 ?>screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_loc.php?lista=1&cod=<?=$cod ?>&dia2=<?=$dia2 ?>&mes2=<?=$mes2 ?>&ano2=<?=$ano2 ?>&dia3=<?=$dia3 ?>&mes3=<?=$mes3 ?>&ano3=<?=$ano3 ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>
                  	</td>
				</tr>
<?php
	}
	}
?>
</table>
</td></tr></table>
</form>
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
