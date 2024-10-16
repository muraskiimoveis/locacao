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
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(l_cod,dia2,mes2,ano2,dia3,mes3,ano3,campo,pusuarios,list,lista)
{
       if(confirm("Tem certeza que deseja excluir?"))
          document.location.href='p_lista_relloc.php?id_excluir=' + l_cod + '&dia2=' + dia2 + '&mes2=' + mes2 + '&ano2=' + ano2 + '&dia3=' + dia3 + '&mes3=' + mes3 + '&ano3=' + ano3 + '&campo=' + campo + '&pusuarios=' + pusuarios + '&list=' + list + '&lista=' + lista + '&B1=Pesquisar';
}
    
</script>
</head>
<body>

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
	(($u_tipo == "admin"))){
*/
	if(!$from){
		$from = intval($screen * 10);
	}

var_dump($_GET);
//die();


if($_GET['id_excluir']){
  
    $l_cod = $_GET['id_excluir'];

	$query_bol1 = "select co_boleto from contas where co_locacao='$l_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$res_bol1 = mysql_query($query_bol1) or die("Não foi possível acessar suas informações. $query_bol1");
	$numrows_bol1 = mysql_num_rows($res_bol1);
	if($numrows_bol1 > 0){
		while($not_bol1 = mysql_fetch_array($res_bol1))
		{
			$query_bol2 = "update boleto set loc_deletada = 'S' where nrdoc ='".$not_bol1[co_boleto]."'";
			$res_bol2 = mysql_query($query_bol2) or die("Não foi possível Atualizar suas informações. $query_bol2");
			$query_bol3 = "update remessa set loc_deletada = 'S' where nrdoc ='".$not_bol1[co_boleto]."'";
			$res_bol3 = mysql_query($query_bol3) or die("Não foi possível Atualizar suas informações. $query_bol3");
		}
	}
	$query4= "delete from locacao where l_cod='$l_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível apagar suas informações. $query4");
	
	$query5= "delete from contas where co_locacao='$l_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result5 = mysql_query($query5) or die("Não foi possível apagar suas informações. $query5");

}

	/*
	if($alterar == 1){
	if($bot == "Apagar"){
	$query4= "delete from locacao where l_cod='$l_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível apagar suas informações. $query4");
	
	$query5= "delete from contas where co_locacao='$l_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	$query4= "update locacao set l_historico='$l_historico', l_desp='$l_desp', l_saldo='$l_saldo' where l_cod='$l_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	
	$query5= "select * from contas where co_locacao='$l_cod' and co_tipo='Despesas' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result5 = mysql_query($query5) or die("Não foi possível pesquisar suas informações. $query5");
	$numrows5 = mysql_num_rows($result5);
	if($numrows5 > 0){
	while($not5 = mysql_fetch_array($result5))
	{
	
	
	$query6= "update contas set co_desc='$l_historico', co_valor='$l_desp' where co_cod='$not5[co_cod]' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result6 = mysql_query($query6) or die("Não foi possível atualizar suas informações. $query6");
	
	
	}//termina while
	}
	else
	{
	
	$query7= "insert into contas (cod_imobiliaria ,co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario) 
	values('".$_SESSION['cod_imobiliaria']."','$l_cliente', 'Receber', '$cod', '$l_historico', 'Despesas', current_date, 'pendente', '$l_desp'
	, '$l_cod', '$valid_user')";
	$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações. $query7");
	
	}//Termina numrows5
	
	}
	*/
	//}	

if($lista == "")
	{
?>
<div align="center">
  <center>
<form name="form1" id="form1" method="post" action="">
<table border="0" cellspacing="1" width="75%">
<tr height="50"><td colspan=8 class=style1>
<p align="center"><b>Relatório de Locação</b><br />Para excluir uma reserva diária, clique no botão do lado direito</p>
</td></tr>
<tr>
  <td colspan=8 class=style1>
<?
	  if($pusuarios<>''){
	       $b_usuarios = "l_usuario='$pusuarios' and ";
	       
	       $users = mysql_query("SELECT * FROM usuarios WHERE u_cod='$pusuarios'");
 		   while($linha = mysql_fetch_array($users)){
	          $dados = $linha['u_nome']." - ".$linha['u_email'];
	       }
	       $usuarios = $dados;
	  }else{
	    	$usuarios = "Todos";
	  }
?>
    <b>Usu&aacute;rio:</b> <? echo($usuarios) ?></td>
</tr>
<?php
  $ano2 = $_GET['ano2'];
  $mes2 = $_GET['mes2']; 
  $dia2 = $_GET['dia2'];
  $ano3 = $_GET['ano3'];
  $mes3 = $_GET['mes3']; 
  $dia3 = $_GET['dia3'];
	if($campo == "locado"){
	$query1 = "select * from locacao where $b_usuarios l_data_sai>='$ano2-$mes2-$dia2' AND 
	l_data_sai<='$ano3-$mes3-$dia3' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato='' order by l_data_ent";
	}else{
	$query1 = "select * from locacao where $b_usuarios l_data>='$ano2-$mes2-$dia2' AND 
	l_data<='$ano3-$mes3-$dia3' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato='' order by l_data";
	}
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);

	//var_dump($query1); die();
?>
<tr class="fundoTabelaTitulo">
<td width="10%" class=style1><b>
<p align="center">Data</td>
<td width="10%" class=style1><b>
<p align="center">Entrada</td>
<td width="31%" class=style1><b>
<p align="center">Imóvel / Locatário</td>
<td width="10%" class=style6><b>
<p align="center">Crédito</td>
<td width="10%" class=style7><b>
<p align="center">Comissão</td>
<td width="10%" class=style1><b>
<p align="center">Taxa Administrativa</td>
<td width="10%" class=style1><b>
<p align="center">TV</td>
<td width="9%" class="styel"></td>
</tr>
<tr class="fundoTabela">
<td class=style1><b>
<p align="center">Reserva</td>
<td class=style1><b>
<p align="center">Saída</td>
<td width=300 class=style1><b>
<p align="center">Histórico de Despesas</td>
<td class=style7><b>
<p align="center">Despesas</td>
<td class=style6><b>
<p align="center">Saldo</td>
<td class=style1><b>
<p align="center">Contrato</td>
<td class=style1><b>
<p align="center">Depósitos</td>
<td class="style1"></td>
</tr>
<?php
	$i = 0;
	$saldo_total = 0;

	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "$cor6";

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
<input type="hidden" name="campo" value="<?php print("$campo"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$not1[l_cod]"); ?>">
<input type="hidden" name="l_limpeza" value="<?php print("$not1[l_limpeza]"); ?>">
<input type="hidden" name="l_tv" value="<?php print("$not1[l_tv]"); ?>">
<input type="hidden" name="cod" value="<?php print("$not1[l_imovel]"); ?>">
<input type="hidden" name="l_cliente" value="<?php print("$not1[l_cliente]"); ?>">
<input type="hidden" name="l_comissao" value="<?php print("$not1[l_comissao]"); ?>">
<input type="hidden" name="alterar" value="1">
<tr class="<?php echo $fundo; ?>">
<td class="style1"><p align="left">
<?php
	/*
	if(verificaFuncao("RELAT_LOC_REL")){
?>
<a href="p_edit_locacao.php?l_cod=<?php print("$not1[l_cod]"); ?>&edit=editar" class=style1>
<?php
	}
	*/
?>
<?php print("$data_res"); ?>
<?php
/*
	if(verificaFuncao("RELAT_LOC_REL")){
?>
</a>
<?php
	}
	*/
?></td>
<td><p align="left" class=style1>
<?php print("$data_ent"); ?></td>
<td class="style1">
<p align="left" class=style1>
<?php

	$query4 = "select m.cod, m.ref, t.t_nome from muraski m inner join rebri_tipo t on (m.tipo=t.t_cod) where m.cod='$not1[l_imovel]' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
	$cod_imovel = $not4[cod];
?>
<a href="detalhes.php?cod=<?php print("$not4[cod]"); ?>&codi=<?=$_SESSION['cod_imobiliaria']; ?>&nomei=<?=$_SESSION['nome_imobiliaria'] ?>&pastai=<?=$_SESSION['nome_pasta'] ?>&mostra=S" class="style1">Ref.:<?php print("$not4[ref]"); ?></a> - <?php print("$not4[t_nome]"); ?> -
<?php
	}
	
	$query3 = "select c_nome from clientes where c_cod='$not1[l_cliente]' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	while($not3 = mysql_fetch_array($result3))
	{
?>
<?php print("$not3[c_nome]"); ?>
<?php
	}
	//$l_total = $not1[l_total] + $not1[l_limpeza];
	$saldo_total = $not1[l_saldo] + $saldo_total;
	$total_total = $not1[l_total] + $total_total;
	$limpeza_total = $not1[l_limpeza] + $limpeza_total;
	$tv_total = $not1[l_tv] + $tv_total;
	$l_desp_total = $not1[l_desp] + $l_desp_total;
	$comissao_total = $not1[l_comissao] + $comissao_total;
	$total = number_format($not1[l_total], 2, ',', '.');
	$comissao = number_format($not1[l_comissao], 2, ',', '.');
	$saldo = number_format($not1[l_saldo], 2, ',', '.');
	$limpeza = number_format($not1[l_limpeza], 2, ',', '.');
	$tv = number_format($not1[l_tv], 2, ',', '.');
	$l_desp = number_format($not1[l_desp], 2, ',', '.');
	$saldo_atual = 0;

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
<input type="button" value="Apagar" class="campo3" name="bot" onClick="javascript:confirmaExclusao(<?=$not1['l_cod'] ?>,'<?=$dia2 ?>','<?=$mes2 ?>','<?=$ano2 ?>','<?=$dia3 ?>','<?=$mes3 ?>','<?=$ano3 ?>','<?=$campo ?>','<?=$pusuarios ?>', '<?=$list ?>','<?=$lista ?>')">
<?php
	}
?></td>
</tr>
<tr class="<?php echo $fundo; ?>">
<td ><p align="left" class=style1>
</td>
<td ><p align="left" class=style1>
<?php print("$data_sai"); ?></td>
<td >
<p align="center" class=style1><a href="javascript:;" onClick="NewWindow('p_loc_despesas.php?l_cod=<?php print("$not1[l_cod]"); ?>', 'janela', 750, 500, 'yes')" class="style1"><b>Cadastrar Despesas</b></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="NewWindow('p_despesas_nova.php?l_cod=<?php print("$not1[l_cod]"); ?>&cod=<?php print("$cod_imovel"); ?>', 'janela1', 950, 600, 'yes')" class="style1"><b>Cadastrar Serviços</b></a></p>
</td>
<td >
<p align="left" class=style7>R$
<?
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
	
?>
</td>
<td>
<p align="left" class=style6>R$ 
<?php print("$saldo"); ?></td>
<td>
<p align="left" class=style1>
<a href="javascript:;" onClick="NewWindow('p_imp_doc.php?imp=9&cod=<?php print("$not1[l_imovel]"); ?>&l_cod=<?php print("$not1[l_cod]"); ?>', 'janela', 750, 500, 'yes')" class="style1">
Imprimir</a></td>
<td>
<p align="left" class=style1>
<a href="#" onclick="NewWindow('p_extrato_depositos.php?locacao=<?php print("$not1[l_cod]"); ?>&cod_imovel=<?=$not1[l_imovel] ?>&tipo_pesq=locacao', 'janela', 750, 500, 'yes');" class="style1">Depósitos</a>
<!-- <a href="#" onclick="NewWindow('p_boleto_dep.php?locacao=<?php //print("$not1[l_cod]"); ?>&cod_imovel=<?=$not1[l_imovel] ?>&tipo_pesq=locacao', 'janela', 750, 280, 'yes');" class="style1">Boleto</a> -->
</td>
<td class="style1">
<p align="left">
<?php
if(verificaFuncao("USER_LIBERAR_ACESSO")){
?>
<!--input type="submit" value="Atualizar" class="campo3" name="bot"-->
<?php
	}
?></td>
</tr>
</form>
<?php
	}
	$total_total = number_format($total_total, 2, ',', '.');
	$saldo_total = number_format($saldo_total, 2, ',', '.');
	$limpeza_total = number_format($limpeza_total, 2, ',', '.');
	$tv_total = number_format($tv_total, 2, ',', '.');
	$l_desp_total = number_format($total_geral, 2, ',', '.');
	$comissao_total = number_format($comissao_total, 2, ',', '.');
	$saldo_clientes = number_format($saldo_clientes, 2, ',', '.');
	$receber_clientes = number_format($receber_clientes, 2, ',', '.');
?>
<?php
if(verificaFuncao("USER_LIBERAR_ACESSO")){
?>
<tr class="fundoTabela">
<td colspan=3><p align="left" class=style1><b>Crédito Total:
</td>
<td colspan=5>
<p align="left" class=style1><b>R$ 
<?php print("$total_total"); ?>
</td></tr>
<tr class="fundoTabela">
<td colspan=3><p align="left" class=style1>Total TV:
</td>
<td colspan=5>
<p align="left" class=style1>R$ 
<?php print("$tv_total"); ?>
</td></tr>
<tr class="fundoTabela">
<td colspan=3><p align="left" class=style1>Total Tx Administrativa:
</td>
<td colspan=5>
<p align="left" class=style1>R$ 
<?php print("$limpeza_total"); ?>
</td></tr>
<tr class="fundoTabela">
<td colspan=3><p align="left" class=style1>Total Despesas:
</td>
<td colspan=5>
<p align="left" class=style1>R$ 
<?php print("$l_desp_total"); ?>
</td></tr>
<tr class="fundoTabela">
<td colspan=3><p align="left" class=style1><b>Total Comissões:
</td>
<td colspan=5>
<p align="left" class=style1><b>R$ 
<?php print("$comissao_total"); ?>
</td></tr>
<tr class="fundoTabela">
<td colspan=3><p align="left" class=style1>Saldo Total:
</td>
<td colspan=5>
<p align="left" class=style1>R$ 
<?php print("$saldo_total"); ?>
</td></tr>
<tr class="fundoTabela">
<td colspan=3><p align="left" class=style6>Saldo total que falta receber:
</td>
<td bgcolor="#<?php print("$cor7"); ?>" colspan=5>
<p align="left" class=style6>R$ 
<?php print("$receber_clientes"); ?>
</td></tr>
<tr class="fundoTabela">
<td colspan=3><p align="left" class=style7>Saldo total que falta depositar:
</td>
<td colspan=5>
<p align="left" class=style7>R$ 
<?php print("$saldo_clientes"); ?>
</td></tr>
<?php
	}
?>
<?php
	}
	if($campo == "locado"){
	$query2 = "select count(l_imovel) as contador from locacao where $b_usuarios l_data_sai>='$ano2-$mes2-$dia2' AND 
	l_data_sai<='$ano3-$mes3-$dia3' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato='' ";
	}else{
	$query2 = "select count(l_imovel) as contador from locacao where $b_usuarios l_data>='$ano2-$mes2-$dia2' AND 
	l_data<='$ano3-$mes3-$dia3' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato='' ";
	}
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
                  <tr class="fundoTabelaTitulo"><td colspan=8 class=style1>
                  <p align="center">
                  <b>Foram encontrados <?php print("$not2[contador]"); ?> períodos</b></td></tr>
                  <tr class="fundoTabelaTitulo"><td colspan=8 class=style1>
                  <p align="center">
                  <b>Total de <?php print("$total_dias"); ?> diárias</b></td></tr>
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
mysql_free_result($result4);
*/
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
