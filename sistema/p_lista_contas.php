<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("CONTA_GERAL");
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
<p>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin"))){
*/
	$url = $REQUEST_URI;
	//echo $url;
	$url = explode("?", $url);
	$url2 = explode("dia2", $url[1]);
	//$url = str_replace("&","-","$url");
	//$url = str_replace("?","|","$url");

	if(!$from){
		$from = intval($screen * 10);
	}

	if($acao == "Confirmar"){
	$query4= "update contas set co_status='ok', co_data_status=current_date where co_cod='$co_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";	
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	
		
	}	

if($lista == "")
	{
?>
<div align="center">
  <center>
<table bgcolor="#EDEEEE" border="0" cellspacing="1">
	<tr>
		<td bgcolor="#EDEEEE" colspan=7 class=style1 align="center"><a href="p_pesq_contas.php" class="style1">Fazer nova pesquisa</a> - <a href="p_insert_contas.php" class="style1">Cadastrar uma nova conta</a></td>
	</tr>
<tr><td bgcolor="#EDEEEE" colspan=7 class=style1 align="left"><b>Relatório de Contas</b><br>
<? if($_GET['status']<>'C'){ ?>
Período: <?php print("$dia2"); ?>/<?php print("$mes2"); ?>/<?php print("$ano2"); ?> à <?php print("$dia3"); ?>/<?php print("$mes3"); ?>/<?php print("$ano3"); ?><br>
Pesquisa por: <?php print("$tipo_pesq"); ?><br>
<? } ?>
<b>
<?php
	if($co_imovel != ""){
		echo "Imóvel: " . $nome_imovel . "<br>";
	}
	if($co_cliente != ""){
		echo "Cliente: " . $nome_cliente . "<br>";
	}
	if($co_status != "%%"){
		echo "Status: " . $co_status . "<br>";
	}
	if($_GET['status']<>'C'){ 
		if($co_usuario != "%%"){
			echo "Usuário: " . $co_usuario . "<br>";
		}
	}
?></b>
</td></tr>
<?php
	if($tipo_pesq != "locacao"){
		if($co_imovel == ""){
			$co_imovel = "%%";
		}
		if($co_cliente == ""){
			$co_cliente = "%%";
		}
		if($co_usuario == ""){
			$co_usuario = "%%";
		}
		if(($dia2 == "") or ($mes2 == "") or ($ano2 == "") or ($dia3 == "") or ($mes3 == "") or ($ano3 == "")){
	$query1 = "select *,(select SUM(co_valor) from contas where co_cliente like '$co_cliente' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	and co_imovel like '$co_imovel' and co_usuario like '$co_usuario' and co_status like '$co_status') AS saldo
	from contas where co_cliente like '$co_cliente' and co_imovel like '$co_imovel' 
	and co_usuario like '$co_usuario' and 
	co_status like '$co_status' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by co_data";
		}
		else
		{
	$query1 = "select *,(select SUM(co_valor) from contas where co_data<'$ano2-$mes2-$dia2' and 
	co_cliente like '$co_cliente' and co_imovel like '$co_imovel' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_usuario like '$co_usuario' and 
	co_status like '$co_status') AS saldo
	from contas where co_data>='$ano2-$mes2-$dia2' AND 
	co_data<='$ano3-$mes3-$dia3' and co_cliente like '$co_cliente' and co_imovel like '$co_imovel' 
	and co_usuario like '$co_usuario' and 
	co_status like '$co_status' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by co_data";
		}
	
	}
	else
	{
	$query1 = "select *,(select SUM(co_valor) from contas where co_locacao='$co_locacao' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."') AS saldo 
	from contas where co_locacao='$co_locacao' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by co_data";
	}
	
	//echo $query1;
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<tr><td bgcolor="#<?php print("$cor1"); ?>" colspan=7>
<p align="center" class="style1">
Para alterar ou excluir uma conta, clique nos botões do lado direito.</b>
</td></tr>
<tr>
<td width=80 bgcolor="#EDEEEE" class=style1><b>
<p align="center">Data</td>
<td width=200 bgcolor="#EDEEEE" class=style1><b>
<p align="center">Cliente</td>
<td width=200 bgcolor="#EDEEEE" class=style1><b>
<p align="center">Imóvel</td>
<td width=50 bgcolor="#EDEEEE" class=style1><b>
<p align="center">Tipo</td>
<td width=50 bgcolor="#EDEEEE" class=style1><b>
<p align="center">Valor</td>
<td width=50 bgcolor="#EDEEEE" class=style1><b>
<p align="center">Locação</td>
<td width=100 bgcolor="#EDEEEE" class=style1><b>
<p align="center">Status</td>
</tr><tr>
<td colspan=7 bgcolor="#CCCCCC" class=style1><b>
  <div align="center">Descrição</div></td>
</tr>
<?php
	$i = 1;
	$saldo_total = 0;
	$saldo = 0;

	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="EDEEEE"; }else{ $fundo="f2f2f2"; }
	$i++;
	$fundo2 = "96b5c9";

				$anoc = substr ($not1[co_data], 0, 4);
		        $mesc = substr($not1[co_data], 5, 2 );
		        $diac = substr ($not1[co_data], 8, 2 );
		        $anoc1 = substr ($not1[co_data_status], 0, 4);
		        $mesc1 = substr($not1[co_data_status], 5, 2 );
		        $diac1 = substr ($not1[co_data_status], 8, 2 );
		   			
	$data = mktime(0,0,0, $mesc, $diac, $anoc);
	$data1 = mktime(0,0,0, $mesc1, $diac1, $anoc1);
	
	$diarias = round(($data - $data1)/(24*60*60));
	$diarias = $diarias + 1;
	
	$total_dias = $total_dias + $diarias;
	
		   			
		        $data = "$diac/$mesc/$anoc";
		        $data_status = "$diac1/$mesc1/$anoc1";
		        
	if($not1[co_cat] == "Pagar"){
		//$not1[co_valor] = "-" . $not1[co_valor];
		$not1[co_valor] = $not1[co_valor];
		if($not1[co_status] == "ok"){
		$total_deb = $not1[co_valor] + $total_deb;
		}
		else
		{
		$total_debp = $not1[co_valor] + $total_debp;
		}
	}
	else
	{
		if($not1[co_status] == "ok"){
		$total_cred = $not1[co_valor] + $total_cred;
		}
		else
		{
		$total_credp = $not1[co_valor] + $total_credp;
		}
	}
	$valor_tela = number_format($not1[co_valor], 2, ',', '.');
	
	$total = $total_cred + $total_deb;
	$totalp = $total_credp + $total_debp;
	$saldo_total = $totalp + $total;

	if($i <= 2){
		$saldo = $not1[saldo] + $not1[co_valor];
	}
	else
	{
		$saldo = $saldo + $not1[co_valor];
	}
	$saldo_tela = number_format($saldo, 2, ',', '.');
	$saldo_ant_tela = number_format($not1[saldo], 2, ',', '.');
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="dia2" value="<?php print("$dia2"); ?>">
<input type="hidden" name="mes2" value="<?php print("$mes2"); ?>">
<input type="hidden" name="ano2" value="<?php print("$ano2"); ?>">
<input type="hidden" name="dia3" value="<?php print("$dia3"); ?>">
<input type="hidden" name="mes3" value="<?php print("$mes3"); ?>">
<input type="hidden" name="ano3" value="<?php print("$ano3"); ?>">
<input type="hidden" name="campo" value="<?php print("$campo"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not1[co_cod]"); ?>">
<input type="hidden" name="co_limpeza" value="<?php print("$not1[co_limpeza]"); ?>">
<input type="hidden" name="co_tv" value="<?php print("$not1[co_tv]"); ?>">
<input type="hidden" name="cod" value="<?php print("$not1[co_imovel]"); ?>">
<input type="hidden" name="co_comissao" value="<?php print("$not1[co_comissao]"); ?>">
<input type="hidden" name="alterar" value="1">
<?php
	if($i == 2){
?>
<tr>
	<td colspan=7 align=right bgcolor="#<?php print("$fundo"); ?>" class=<?php if($not1[saldo] > 0){ echo "style7"; }else{ echo "style6"; } ?>><b>Saldo Anterior: R$ <?php print("$saldo_ant_tela"); ?></b></td>
</tr>
<?php
	}
?>
<tr>
<td bgcolor="#<?php print("$fundo"); ?>" class="<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>" align="left"><b><?php print("$data"); ?></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>">
<?php 
	$query3 = "select c_nome from clientes where c_cod='$not1[co_cliente]' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	while($not3 = mysql_fetch_array($result3))
	{
?>
<a target="_blank" href="p_clientes.php?lista=1&c_cod=<?php print("$not1[co_cliente]"); ?>" class="<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>">
<?php print("$not3[c_nome]"); ?></a>
<?php
	}
?></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>">
<?php

	$query4 = "select m.cod, m.ref, t.t_nome from muraski m inner join rebri_tipo t on (m.tipo=t.t_cod) where m.cod='$not1[co_imovel]' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
?>
<span class="<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>">Ref.:<?php print("$not4[ref]"); ?></span> - <?php print("$not4[t_nome]"); ?>  
<?php
	}
	
	//$co_total = $not1[co_total] + $not1[co_limpeza];
	//$saldo_total = $not1[co_saldo] + $saldo_total;
	//$total_total = $not1[co_total] + $total_total;
	//$limpeza_total = $not1[co_limpeza] + $limpeza_total;
	//$tv_total = $not1[co_tv] + $tv_total;
	//$co_desp_total = $not1[co_desp] + $co_desp_total;
	//$comissao_total = $not1[co_comissao] + $comissao_total;
	//$total_tela = number_format($total, 2, ',', '.');
	//$comissao = number_format($not1[co_comissao], 2, ',', '.');
	//$saldo = number_format($not1[co_saldo], 2, ',', '.');
	//$limpeza = number_format($not1[co_limpeza], 2, ',', '.');
	//$tv = number_format($not1[co_tv], 2, ',', '.');
	//$saldo_atual = 0;

	/*
	$query4 = "select d_saldo from depositos where d_loc='$not1[co_cod]' order by d_data desc, d_cod desc limit 1";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{
		$saldo_atual = $not4[d_saldo];
	}
	}
	else
	{
		$saldo_atual = $not1[l_saldo];
	}
	
	$saldo_clientes = $saldo_atual + $saldo_clientes;
	*/
?>
</td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"> 
<?php print("$not1[co_tipo]"); ?></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="right" class="<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>">
R$ <?php print("$valor_tela"); ?></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="center" class="<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>">
<?php
	if($not1[co_locacao] != ""){
?>
<a target="_blank" href="p_edit_locacao.php?l_cod=<?php print("$not1[co_locacao]"); ?>&edit=editar" class="<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php print("$not1[co_locacao]"); ?></a>
<?php
	}
?></td>
<td bgcolor="#<?php print("$fundo"); ?>">
<p align="left" class=<?php if($not1[co_status] == "ok"){ echo "style6"; }else{ echo "style1"; } ?>> 
<b><?php print("$data_status - $not1[co_status]"); ?></b></td>
</tr><tr>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class=style1 colspan=7>
Descrição: <?php print("$not1[co_desc]"); ?></td>
</tr>
<tr>
	<td colspan=3 bgcolor="#<?php print("$fundo"); ?>" align=left class=style1><a href="#" onClick="if (confirm('Deseja Realmente confirmar esta conta?')) { window.location='<? print("$PHP_SELF"); ?>?acao=Confirmar&co_cod=<?php print("$not1[co_cod]"); ?>&dia2<?php print("$url2[1]"); ?>&co_cliente=<?php print("$co_cliente"); ?>&nome_cliente=<?php print("$nome_cliente"); ?>&co_status=<?php print("$co_status"); ?>&status=<?php print("$status"); ?>'; }" class="<?php if($not1[co_cat] == "Pagar"){ echo "style1"; }else{ echo "style1"; } ?>">Confirmar</a></td>
	<td colspan=4 bgcolor="#<?php print("$fundo"); ?>" align="right" class=style1>
Saldo atual: <span class=<?php if($saldo > 0){ echo "style16"; }else{ echo "style13"; } ?>>R$ <?php print("$saldo_tela"); ?></span></td>
</tr>
<tr>
	<td colspan=7 bgcolor="#<?php print("$fundo2"); ?>" height=1></td>
</tr>
</form>
<?php
	}
	$total_tela = number_format($total, 2, ',', '.');
	$totalp_tela = number_format($totalp, 2, ',', '.');
	$saldo_total_tela = number_format($saldo_total, 2, ',', '.');
	$total_cred_tela = number_format($total_cred, 2, ',', '.');
	$total_deb_tela = number_format($total_deb, 2, ',', '.');
	$total_credp_tela = number_format($total_credp, 2, ',', '.');
	$total_debp_tela = number_format($total_debp, 2, ',', '.');
?>
<? if (verificaFuncao("USER_CONTA")) { // verifica se pode acessar as areas ?>
<tr>
<td bgcolor="#<?php print("$cor6"); ?>" colspan=3 align="left" class=style1>Total de Créditos Recebidos:
</td>
<td bgcolor="#<?php print("$cor6"); ?>" colspan=4 align="right" class=style1>R$ <?php print("$total_cred_tela"); ?></td>
</tr>
<tr>
<td bgcolor="#<?php print("$cor6"); ?>" colspan=3 align="left" class=style6>Total de Créditos Pendentes:
</td>
<td bgcolor="#<?php print("$cor6"); ?>" colspan=4 align="right" class=style6>R$ <?php print("$total_credp_tela"); ?></td>
</tr>
<tr>
<td bgcolor="#<?php print("$cor6"); ?>" colspan=3 align="left" class=style1>Total de Débitos Quitados:
</td>
<td bgcolor="#<?php print("$cor6"); ?>" colspan=4 align="right" class=style1>R$ <?php print("$total_deb_tela"); ?></td>
</tr>
<tr>
<td bgcolor="#<?php print("$cor6"); ?>" colspan=3 align="left" class=style7>Total de Débitos Pendentes:
</td>
<td bgcolor="#<?php print("$cor6"); ?>" colspan=4 align="right" class=style7>R$ <?php print("$total_debp_tela"); ?></td>
</tr>
<tr>
<td bgcolor="#<?php print("$cor7"); ?>" colspan=3><p align="left" class=style1><b>Saldo Total Quitado:
</td>
<td bgcolor="#<?php print("$cor7"); ?>" colspan=4 align="right" class=style1><b>R$ <?php print("$total_tela"); ?></td>
</tr>
<tr>
<td bgcolor="#<?php print("$cor7"); ?>" colspan=3><p align="left" class=style1><b>Saldo Total Pendente:
</td>
<td bgcolor="#<?php print("$cor7"); ?>" colspan=4 align="right" class=style1><b>R$ <?php print("$totalp_tela"); ?></td>
</tr>
<tr>
<td bgcolor="#<?php print("$cor7"); ?>" colspan=3><p align="left" class=style1><b>Saldo Total:
</td>
<td bgcolor="#<?php print("$cor7"); ?>" colspan=4 align="right" class=style1><b>R$ <?php print("$saldo_total_tela"); ?></td>
</tr>
<?php
	}
?>
<?php
	}
	if($campo == "cliente"){
	$query2 = "select count(co_imovel) as contador from contas where co_data_status>='$ano2-$mes2-$dia2' AND 
	co_data_status<='$ano3-$mes3-$dia3' and co_cliente='$co_cliente' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}else{
	$query2 = "select count(co_imovel) as contador from contas where co_data>='$ano2-$mes2-$dia2' AND 
	co_data<='$ano3-$mes3-$dia3' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
				 <? if($_GET['status']<>'C'){ ?>	
                  <tr>
				  	<td colspan=7 bgcolor="#<?php print("$cor1"); ?>" class=style1 align="center">Foram encontrados <?php print("$not2[contador]"); ?> períodos</td>
				  </tr>
                  <tr>
				  	<td colspan=7 bgcolor="#<?php print("$cor1"); ?>" class=style1 align="center">Total de <?php print("$total_dias"); ?> diárias</td>
  			      </tr>
  			      <? } ?>
<?php
	}
	}
?>
</table>
</td></tr></table>
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
</body>

</html>