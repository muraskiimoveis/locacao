<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_DEPOSITOS");
?>
<html>

<head>
<?php
include("style.php");
?>
<script language="javascript">
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
<p>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin"))){
*/	  
	  
	$url = $REQUEST_URI;
	//echo $url;
	$url = explode("?", $url);
	//$url2 = explode("dia2", $url[1]);
	//$url = str_replace("&","-","$url");
	//$url = str_replace("?","|","$url");
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor1"); ?>" border="0" cellspacing="1">
<?php
	if(!$from){
		$from = intval($screen * 10);
	}

	if($acao == "Confirmar"){
		//if($co_cat == "Pagar"){
			//$valor = "-" . $valor;
		//}
		
			//$sobra = $co_valor - $valor;
			//echo $sobra;
		
		if($co_valor == $valor){
			
	$query4= "update contas set co_status='ok', co_data_status=current_date
	, co_usuario_status='$u_cod' where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	
		}
		else
		{
			
	if($co_cat == "Pagar"){
	  
	$query20 = "select contador, cliente from muraski where cod='$cod_imovel' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	$cod_cliente2 = " (";
	for($i3 = 1; $i3 <= $contador; $i3++){
	    if($i3==1){  
			$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
		}else{
		  	$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
		}
	} 
	$cod_cliente2 .= ")"; 
	  
	$query4 = "select * from clientes, locacao, muraski 
	where cod=l_imovel and $cod_cliente2 and 
	l_cod='$locacao' and c_cod='$cliente' and muraski.cliente like '".$cod_cliente."' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_cod limit 1";
	
	}elseif($co_cat == "Receber"){
	
	$query4 = "select * from clientes, locacao, muraski 
	where cod=l_imovel and 
	l_cod='$locacao' and c_cod='$cliente' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_cod limit 1";
	}
	//echo $query4 . "<br>";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{
		if($co_cat == "Pagar"){
		$total_loc = $not4[l_total] - ($not4[l_comissao] + $not4[l_desp]);
		}elseif($co_cat == "Receber"){
		$total_loc = $not4[l_total];	
		}
		//echo "Total locação: " . $total_loc . "<br>";
	}
		
		$query6 = "select sum(co_valor) as total_ok from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='ok' 
		and co_cat='$co_cat'";
		//echo $query6 . "<br>";
		$result6 = mysql_query($query6);
		while($not6 = mysql_fetch_array($result6))
		{
			$total_ok = $not6[total_ok];

		$total_falta = $total_loc - $total_ok;

			//echo "Total falta: " . $total_falta . "<br>";
		}
		
		$query7 = "select count(co_cod) as contas_pend from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='pendente' 
		and co_cat='$co_cat' and co_fixar='no' and co_cod!='$co_cod'";
		//echo $query7 . "<br>";
		$result7 = mysql_query($query7);
		while($not7 = mysql_fetch_array($result7))
		{
			$contas_pend = $not7[contas_pend];
			//echo "Contas pend.: " . $contas_pend . "<br>";
			
	$total_temp = 0;
	$j = 0;
	$query5 = "select *,(select sum(co_valor) as total_ok from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='ok' 
		and co_cat='$co_cat') as total_ok
		, (select count(co_cod) from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='pendente' 
		and co_cat='$co_cat' and co_cod!='$co_cod') as contas_pend 
		from contas 
		where co_locacao='$locacao' and co_cat='$co_cat' and co_status='pendente' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cod!='$co_cod' 
		group by co_cod 
		order by co_data";
		//echo $query5 . "<br>";
		$result5 = mysql_query($query5);
		while($not5 = mysql_fetch_array($result5))
		{
		//echo $not5[co_fixar];
		if($not5[co_fixar] == "ok"){
			//$valor_fixo[$j] .= 1;
			$parc_dif = $not5[co_valor];
			$total_temp = $total_temp + $parc_dif;
			$j = $j - 1;
		}
		else
		{
			$j++;
			//echo "j: " . $j . "<br>";
		}
	}
	//echo "Valor: " . $valor . "<br>";
	//echo "Total temp: " . $total_temp . "<br>";
	$total_falta2 = $total_falta - ($valor + $total_temp); 
	//echo "Total falta2: " . $total_falta2 . "<br>";
	
	$valor_parc = $total_falta2 / $contas_pend;
	//echo "Parcela: " . $valor_parc . "<br>";

		}
		
			if(($total_falta != "") and ($valor < $total_falta) and ($total_falta > 0) and (($total_falta2 > 0))){
			
			if($contas_pend >= 1){
			$query2 = "update contas set co_valor='$valor', co_data_status=current_date, co_status='ok' 
			where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			//echo $query2 . "2<br>";
			$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações. $query2");
			$k = 2;
			}
			
			}
						
		$query5 = "select *,(select sum(co_valor) as total_ok from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='ok' 
		and co_cat='$co_cat') as total_ok
		, (select count(co_cod) from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='pendente' 
		and co_cat='$co_cat') as contas_pend 
		from contas 
		where co_locacao='$locacao' and co_cat='$co_cat' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='pendente' 
		group by co_cod 
		order by co_data";
		//echo $query5 . "<br>";
		$result5 = mysql_query($query5);
		while($not5 = mysql_fetch_array($result5))
		{
			
			if($k == 2){
						
			$query2 = "update contas set co_valor='$valor_parc', co_data_status=current_date, co_status='pendente' 
			where co_cod='$not5[co_cod]' and co_fixar='no' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações. $query2");
						
			}
			
		}
		
	}
	else
	{
			if($saldo > 0){
				$cat = "Receber";
			}
			else
			{
				$cat = "Pagar";
			}
		//Cadastra nova conta com o que falta
		$query2 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
			, co_locacao, co_usuario, co_forma, co_data_status) 
			values('".$_SESSION['cod_imobiliaria']."', '$cliente', '$cat', '$cod_imovel', '$co_desc', 'Locação', current_date
			, 'pendente', '$saldo', '$locacao', '$u_cod', '$co_forma', current_date)";
		//echo $query2 . "<br>";
		$result2 = mysql_query($query2) or die("Não foi possível inserir suas informações. $query2");
	}
						
		}
	}elseif($acao == "X"){
	
	$query4= "update contas set co_status='pendente', co_data_status=current_date
	, co_usuario_status='$u_cod' where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	
		
	}
	if($alterar_data=="Alterar Data"){
    	$queryd= "update contas set co_data='".$ano.'-'.$mes.'-'.$dia."' where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        
		$resultd = mysql_query($queryd) or die("Não foi possível atualizar suas informações. $queryd");	
	}

	// Pegar dados do imóvel, locação e proprietário
	if($locacao != ""){
	  
	$query20 = "select * from clientes, locacao, muraski where cod=l_imovel and  
	l_cod='$locacao' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	  $total_vigencia = $not2[l_vigencia];
	}
	
	$cod_cliente2 = " (";
	for($i3 = 1; $i3 <= $contador; $i3++){
	    if($i3==1){  
			$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
		}else{
		  	$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
		}
	} 
	$cod_cliente2 .= ")";  
	  
	$query0 = "select * from clientes, locacao, muraski where cod=l_imovel and muraski.cliente like '".$cod_cliente."' and $cod_cliente2 and 
	l_cod='$locacao' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	
	
	}elseif($cod_imovel != ""){
	
	$query20 = "select * from clientes, locacao, muraski where cod=l_imovel and  
	l_imovel='$cod_imovel' and l_data>'2006-10-01' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	$cod_cliente2 = " (";
	for($i3 = 1; $i3 <= $contador; $i3++){
	    if($i3==1){  
			$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
		}else{
		  	$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
		}
	} 
	$cod_cliente2 .= ")"; 
	
	
	$query0 = "select * from clientes, locacao, muraski where cod=l_imovel and muraski.cliente like '".$cod_cliente."' and $cod_cliente2 and 
	l_imovel='$cod_imovel' and l_data>'2006-10-01' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

	}
	
	
	//echo $query0;
	
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	while($not0 = mysql_fetch_array($result0))
	{
						$cod = $not0[cod];
						$cod_imovel = $not0[cod];
						$ref = $not0[ref];
						$titulo = strip_tags($not0[titulo]);
						$cliente = $not0[c_nome];
						$c_cod = $not0[c_cod];

						$cod_cliente3 = " (";
						for($i3 = 1; $i3 <= $contador; $i3++){
	    					if($i3==1){  
								$cod_cliente3 .= "co_cliente='".$cliente2[$i3-1]."'";
							}else{
		  						$cod_cliente3 .= " or co_cliente='".$cliente2[$i3-1]."'";
							}
						} 
						$cod_cliente3 .= ")"; 						
						
						$co_locacao = $not0[l_cod];
						$ano = substr ($not0[l_data_ent], 0, 4);
		        $mes = substr($not0[l_data_ent], 5, 2 );
		        $dia = substr ($not0[l_data_ent], 8, 2 );
		        $ano1 = substr ($not0[l_data_sai], 0, 4);
		        $mes1 = substr($not0[l_data_sai], 5, 2 );
		        $dia1 = substr ($not0[l_data_sai], 8, 2 );
		        $data_ent = "$dia/$mes/$ano";
		        $data_sai = "$dia1/$mes1/$ano1";
		        $l_total = $not0[l_total];
		        $total_tela = number_format($l_total, 2, ',', '.');
		        

	}
	
	// Pegar dados do inquilino
	$query1 = "select c_cod, c_nome from clientes, locacao where c_cod=l_cliente and 
	l_cod='$co_locacao' and clientes.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	while($not1 = mysql_fetch_array($result1))
	{
						$locatario = $not1[c_nome];
						$c_cod2 = $not1[c_cod];
	}
?>
<?php
	if($prop <> $cliente){
	$prop = $cliente;
?>
<tr>
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=7 class=style1 align="left"><b>Extrato de Depósitos</b></td>
</tr>
<tr>
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1>Ref.: <b><?php print("$ref"); ?></b></td>
			<td class=style1>Imóvel: <b><?php print("$titulo"); ?></b></td>
			<td class=style1>Prop(s).:
<?
				
				for($i3 = 1; $i3 <= $contador; $i3++){
						
						$query40 = "select * from clientes where c_cod='" . $cliente2[$i3-1] . "' and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
						$result40 = mysql_query($query40);
						while ($not40 = mysql_fetch_array($result40)) {
                            echo("<a href=\"p_lista_contas.php?co_cliente=".$not40['c_cod']."&nome_cliente=".$not40['c_nome']."&co_status=pendente&status=C\" target=\"_blank\" class=\"style1\"><b>".$not40['c_nome']."</b></a><br>"); 
						}
				}

?>			
			 </td>
		</tr>
	</table></td>
</tr>
<tr>
	<td colspan=7 height=20 align="center"><a href="javascript:;" onClick="MM_openBrWindow('recibo_imobiliaria.php?locacao=<?php print($co_locacao); ?>','','scrollbars=yes,resizable=no,width=800,height=600')" class="style1">Recibo Imobiliária</a></td>
</tr>
<?php
	}
?>
<?php
	$query20 = "select * from clientes, locacao, muraski 
	where cod=l_imovel and  
	l_cod<'$locacao' and c_cod='$c_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_cod desc limit 1";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	$cod_cliente2 = " (";
	for($i3 = 1; $i3 <= $contador; $i3++){
	    if($i3==1){  
			$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
		}else{
		  	$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
		}
	} 
	$cod_cliente2 .= ")"; 

	$query6 = "select * from clientes, locacao, muraski 
	where cod=l_imovel and muraski.cliente like '".$cod_cliente."' and $cod_cliente2 and 
	l_cod<'$locacao' and c_cod='$c_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_cod desc limit 1";
	//echo $query6 . "<br>";
	$result6 = mysql_query($query6);
	while($not6 = mysql_fetch_array($result6))
	{
		$locacao_ant = $not6[l_cod];
		
		$query7 = "select SUM(co_valor) as saldo from contas where co_imovel='$not6[cod]' and co_cat='Receber' 
		and co_status='pendente' AND co_locacao='$not6[l_cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_tipo='Locação'";
		//echo $query7 . "<br>";
		$result7 = mysql_query($query7);
		while($not7 = mysql_fetch_array($result7))
		{
			
		$total_credp7 = $not7[saldo];

		$total_credp_tela7 = number_format($total_credp7, 2, ',', '.');
		
		//echo $total_credp_tela7;
		
		}
		
		$query7 = "select SUM(co_valor) as saldo from contas where co_imovel='$not6[cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber' 
		and co_status='pendente' AND co_locacao='$not6[l_cod]' and co_tipo='Despesas'";
		//echo $query7 . "<br>";
		$result7 = mysql_query($query7);
		while($not7 = mysql_fetch_array($result7))
		{
			
		$total_cred_desp = $not7[saldo];

		$total_cred_desp_tela = number_format($total_cred_desp, 2, ',', '.');
		
		//echo $total_credp_tela7;
		
		}
		
		$query7 = "select SUM(co_valor) as saldo from contas where co_imovel='$not6[cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar' 
		and co_status='pendente' AND co_locacao='$not6[l_cod]'";
		//echo $query7 . "<br>";
		$result7 = mysql_query($query7);
		while($not7 = mysql_fetch_array($result7))
		{
			
		$total_debp7 = $not7[saldo];

		$total_debp_tela7 = number_format($total_debp7, 2, ',', '.');
		
		//echo $total_debp_tela7;
		
		}
		
		$query70 = "select SUM(co_valor) as saldo from contas where co_imovel='$not6[cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber' AND co_tipo='Despesas Imóvel' and co_status='pendente'";
		//echo $query70 . "<br>";
		$result70 = mysql_query($query70);
		while($not70 = mysql_fetch_array($result70))
		{
			
		$total_debp70 = $not70[saldo];

		$total_debp_tela70 = number_format($total_debp70, 2, ',', '.');
		
		//echo $total_debp_tela70;
		
		}
		
	}
?>
<tr>
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1><b><?php print("$data_ent"); ?></b> à <b><?php print("$data_sai"); ?></b> - <b><?php print("$total_vigencia"); ?> meses</b></td>
			<td class=style1><b>Locatário:</b> <a href="p_clientes.php?lista=1&c_cod=<?php echo($c_cod2); ?>" class="style1"><?php print("$locatario"); ?></a></td>
			<td class=style1><b>Valor Mensal:</b> R$ <?php print("$total_tela"); ?></td>
		</tr>
	</table></td>
</tr>
<tr>
	<td colspan=7 height=20></td>
</tr>
<tr>
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=7 class=style1 align="center"><b>Depósitos à receber do Locatário:</b></td>
</tr>
<?php
	if($total_credp7 != 0){
		$total_credp_tela7 = str_replace("-","","$total_credp_tela7");
?>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>"><table width=100%>
		<tr>
			<td class=style7 align=center><b>Existe saldo anterior pendente: R$ <?php print("$total_credp_tela7"); ?></b> - <a href="p_extrato_depositos.php?locacao=<?php print("$locacao_ant"); ?>&tipo_pesq=Locação" target="_blank" class="style1">Visualizar</a></td>
		</tr>
	</table></td>
</tr>
<?php
	}
?>

<?php
	//Mostrar os depósitos a receber do locatário
	$query2 = "select *,(select SUM(co_valor) from contas where co_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber' 
	and co_status='pendente') AS saldo 
	from contas where co_locacao='$co_locacao' and co_cliente='$c_cod2' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by co_cat desc, co_cliente, co_data";
	
	//echo $query2;
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
?>
<?php
	$i = 1;
	$saldo_total = 0;
	$saldo = 0;

	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="$cor1"; }else{ $fundo="$cor1"; }
	$i++;
	$fundo2 = "96b5c9";

						$ano = substr ($not2[co_data], 0, 4);
		        $mes = substr($not2[co_data], 5, 2 );
		        $dia = substr ($not2[co_data], 8, 2 );
		        $ano1 = substr ($not2[co_data_status], 0, 4);
		        $mes1 = substr($not2[co_data_status], 5, 2 );
		        $dia1 = substr ($not2[co_data_status], 8, 2 );
		   			
	$data = mktime(0,0,0, $mes, $dia, $ano);
	$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);
	
	$diarias = round(($data1 - $data)/(24*60*60));
	$diarias = $diarias + 1;
	
	$total_dias = $diarias + $total_dias;
		   			
		        $data = "$dia/$mes/$ano";
		        $data_status = "$dia1/$mes1/$ano1";
		        
	if($not2[co_cat] == "Pagar"){
		//$not2[co_valor] = "-" . $not2[co_valor];
		$not2[co_valor] = $not2[co_valor];
		if($not2[co_status] == "ok"){
		$total_deb = $not2[co_valor] + $total_deb;
		}
		else
		{
		$total_debp = $not2[co_valor] + $total_debp;
		}
	}
	else
	{
		if($not2[co_status] == "ok"){
		$total_cred = $not2[co_valor] + $total_cred;
		}
		else
		{
		$total_credp = $not2[co_valor] + $total_credp;
		}
	}
	$valor_tela = number_format($not2[co_valor], 2, ',', '.');
	
	$total = $total_cred + $total_deb;
	$totalp = $total_credp + $total_debp;
	$saldo_total = $totalp + $total;

	if($i <= 2){
		$saldo = $not2[saldo] + $not2[co_valor];
	}
	else
	{
		$saldo = $saldo + $not2[co_valor];
	}
	$saldo_tela = number_format($saldo, 2, ',', '.');
	$saldo_ant_tela = number_format($not2[saldo], 2, ',', '.');
?>
<?php
	if($i == 0){
?>
<tr>
	<td colspan=7 align=right bgcolor="#<?php print("$fundo"); ?>" class=<?php if($not2[saldo] > 0){ echo "style7"; }else{ echo "style6"; } ?>><b>Saldo Anterior: R$ <?php print("$saldo_ant_tela"); ?></b></td>
</tr>
<?php
	}
?>
<form method="post" name="forml" id="forml" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="locacao" value="<?php print("$co_locacao"); ?>">
<input type="hidden" name="cod_imovel" value="<?php print("$cod_imovel"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not2[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not2[co_valor]"); ?>">
<input type="hidden" name="cliente" value="<?php print("$not2[co_cliente]"); ?>">
<input type="hidden" name="co_forma" value="<?php print("$not2[co_forma]"); ?>">
<input type="hidden" name="co_tipo" value="<?php print("$not2[co_tipo]"); ?>">
<input type="hidden" name="co_data" value="<?php print("$not2[co_data]"); ?>">
<input type="hidden" name="co_cat" value="<?php print("$not2[co_cat]"); ?>">
<tr>
<td bgcolor="#<?php print("$fundo"); ?>" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>" align="left"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_forma]"); ?></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>R$ <input type="text" name="valor" value="<?php print("$not2[co_valor]"); ?>" size="10" class="campo" <?php if($not2[co_status] == "ok"){ echo "readonly"; } ?>></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><IFRAME name=fixa_valor marginWidth=0 marginHeight=0 src="p_fixa_valor_depositos.php?co_cod=<?php print("$not2[co_cod]"); ?>" frameBorder=0 width=70 scrolling=no height=20 topmargin="0" leftmargin="0"></iframe></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>para</td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><input type="text" name="dia" id="dia" size="2" maxlenght="2" class="campo" value="<?php print("$dia"); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes" id="mes" size="2" maxlenght="2" class="campo" value="<?php print("$mes"); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano" id="ano" size="4" maxlenght="4" class="campo" value="<?php print("$ano"); ?>" onKeyUp="return autoTab(this, 4, event);">
<input type="submit" name="alterar_data" id="alterar_data" value="Alterar Data" class="campo3"></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_tipo]"); ?></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="right" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>
<?php
	if($not2[co_status] == "ok"){
?>
<?php print("$data_status - $not2[co_status]"); ?> <input type="submit" value="X" class=campo3 name="acao">
<?php
	}
	else
	{
?>
<input type="submit" value="Confirmar" class=campo3 name="acao">
<?php
	}
?>
	</td>
</tr>
</form>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
</tr>
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
<input type="hidden" name="c_loc" id="c_loc" value="<?=$c_loc; ?>">
<tr>
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1 width=50%>Valor Recebido: <span class=style6>R$ <?php print("$total_cred_tela"); ?></span></td>
			<td class=style1 width=50%>Valor à Receber: <span class=style7>R$ <?php print("$total_credp_tela"); ?></span></td>
</tr></table></td>
</tr>
<?php
	}
?>
<tr>
	<td height=30 colspan=7></td>
</tr>
<tr>
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=7 class=style1 align="center"><b>Despesas à receber do Proprietário:</b></td>
</tr>
<?php
	if($total_debp70 != 0){
		
?>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>"><table width=100%>
		<tr>
			<td class=style7 align=center><b>Existe saldo anterior pendente das despesas do imóvel: R$ <?php print("$total_debp_tela70"); ?></b> - <a href="extrato_despesas_imovel.php?codim=<?php print("$cod_imovel"); ?>&buscad=1" target="_blank" class="style1">Visualizar</a></td>
		</tr>
	</table></td>
</tr>
<?php
	}
?>
<?php
	if($total_cred_desp != 0){
		$total_cred_desp_tela = str_replace("-","","$total_cred_desp_tela");
?>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>"><table width=100%>
		<tr>
			<td class=style7 align=center><b>Existe saldo anterior pendente: R$ <?php print("$total_cred_desp_tela"); ?></b> - <a href="p_extrato_depositos.php?locacao=<?php print("$locacao_ant"); ?>&tipo_pesq=Locação" target="_blank" class="style1">Visualizar</a></td>
		</tr>
	</table></td>
</tr>
<?php
	}
?>
<?php
	//Mostrar os depósitos a receber do proprietário
	$query2 = "select *, (select SUM(co_valor) from contas where co_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar' 
	and co_status='pendente' and co_tipo='Despesas' and co_locacao='$co_locacao') AS saldo	
	from contas 
	where co_locacao='$co_locacao' and $cod_cliente3 and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar' and co_tipo='Despesas' 
	order by co_cat desc, co_cliente, co_data";
	
	//echo $query2;
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
?>
<?php
	$i = 1;
	$saldo_total = 0;
	$saldo = 0;
	$total_cred = 0;
	$total_deb = 0;
	$total_credp = 0;
	$total_debp = 0;

	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="$cor1"; }else{ $fundo="$cor1"; }
	$i++;
	$fundo2 = "96b5c9";

				  $ano = substr ($not2[co_data], 0, 4);
		        $mes = substr($not2[co_data], 5, 2 );
		        $dia = substr ($not2[co_data], 8, 2 );
		        $ano1 = substr ($not2[co_data_status], 0, 4);
		        $mes1 = substr($not2[co_data_status], 5, 2 );
		        $dia1 = substr ($not2[co_data_status], 8, 2 );
		   			
	$data = mktime(0,0,0, $mes, $dia, $ano);
	$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);
	
	$diarias = round(($data1 - $data)/(24*60*60));
	$diarias = $diarias + 1;
	
	$total_dias = $diarias + $total_dias;
		   			
		        $data = "$dia/$mes/$ano";
		        $data_status = "$dia1/$mes1/$ano1";
		        
	if($not2[co_cat] == "Pagar"){
		//$not2[co_valor] = "-" . $not2[co_valor];
		$not2[co_valor] = $not2[co_valor];
		if($not2[co_status] == "ok"){
		$total_deb = $not2[co_valor] + $total_deb;
		}
		else
		{
		$total_debp = $not2[co_valor] + $total_debp;      
		}  
	}
	else
	{
		if($not2[co_status] == "ok"){
		$total_cred = $not2[co_valor] + $total_cred;
		}
		else
		{
		$total_credp = $not2[co_valor] + $total_credp;
		}
      
	}
	//$valor_tela = number_format($not2[co_valor], 2, ',', '.');
	$valor_tela = str_replace("-","","$not2[co_valor]");
	
	$total = $total_cred + $total_deb;
	$totalp = $total_credp + $total_debp;
	$saldo_total = $totalp + $total;

	if($i <= 2){
		$saldo = $not2[saldo] + $not2[co_valor];
	}
	else
	{
		$saldo = $saldo + $not2[co_valor];
	}
	$saldo_tela = number_format($saldo, 2, ',', '.');
	$saldo_ant_tela = number_format($not2[saldo], 2, ',', '.');
?>
<?php
	if($i == 0){
?>
<tr>
	<td colspan=7 align=right bgcolor="#<?php print("$fundo"); ?>" class=<?php if($not2[saldo] > 0){ echo "style6"; }else{ echo "style1"; } ?>><b>Saldo Anterior: R$ <?php print("$saldo_ant_tela"); ?></b></td>
</tr>
<?php
	}
?>
<form method="post" id="formd" name="formd" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="locacao" value="<?php print("$not2[co_locacao]"); ?>">
<input type="hidden" name="cliente" value="<?php print("$not2[co_cliente]"); ?>">
<input type="hidden" name="cod_imovel" value="<?php print("$not2[co_imovel]"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not2[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not2[co_valor]"); ?>">
<input type="hidden" name="co_forma" value="<?php print("$not2[co_forma]"); ?>">
<input type="hidden" name="co_tipo" value="<?php print("$not2[co_tipo]"); ?>">
<input type="hidden" name="co_data" value="<?php print("$not2[co_data]"); ?>">
<input type="hidden" name="co_cat" value="<?php print("$not2[co_cat]"); ?>">
<tr>
<td bgcolor="#<?php print("$fundo"); ?>" class="<?php if($not2[co_cat] == "Pagar"){ echo "style6"; }else{ echo "style1"; } ?>" align="left"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_forma]"); ?></td>
<?php
	//$valor_tela = $not2[co_valor];
?>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>R$ <input type="text" name="valor" value="<?php print("$valor_tela"); ?>" size="10" class="campo" <?php if($not2[co_status] == "ok"){ echo "readonly"; } ?>></td>
<td width=70 bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style1"; } ?>"></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>para</td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$data"); ?> </td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_tipo]"); ?></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="right" class="<?php if($not2[co_cat] == "Pagar"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>
<?php
	if($not2[co_status] == "ok"){
?>
<?php print("$data_status - $not2[co_status]"); ?> <input type="submit" value="X" class=campo3 name="acao">
<?php
	}
	else
	{
?>
<input type="submit" value="Confirmar" class=campo3 name="acao">
<?php
	}
?>
	</td>
</tr>
</form>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
</tr>
<?php
	}
	$total_tela = number_format($total, 2, ',', '.');
	$totalp_tela = number_format($totalp, 2, ',', '.');
	$saldo_total_tela = number_format($saldo_total, 2, ',', '.');
	$total_cred_tela = number_format($total_cred, 2, ',', '.');
	$total_deb_tela = number_format($total_deb, 2, ',', '.');
	$total_credp_tela = number_format($total_credp, 2, ',', '.');
	$total_debp_tela = number_format($total_debp, 2, ',', '.');
	$total_deb_tela = str_replace("-","","$total_deb_tela");
	$total_debp_tela = str_replace("-","","$total_debp_tela");
?>
<tr>
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1 width=50%>Valor Recebido: <span class=style6>R$ <?php print("$total_deb_tela"); ?></span></td>
			<td class=style1 width=50%>Valor à Receber: <span class=style7>R$ <?php print("$total_debp_tela"); ?></span></td>
</tr></table>
</td>
</tr>
<?php	
	}
?>
<tr>
	<td colspan=7 height=30></td>
</tr>
<tr>
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=7 class=style1 align="center"><b>Depósitos à fazer ao Proprietário:</b></td>
</tr>
<?php
	if($total_debp7 != 0){
		$total_debp_tela7 = str_replace("-","","$total_debp_tela7");
?>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>"><table width=100%>
		<tr>
			<td class=style7 align=center><b>Existe saldo anterior pendente: R$ <?php print("$total_debp_tela7"); ?></b> - <a href="p_extrato_depositos.php?locacao=<?php print("$locacao_ant"); ?>&tipo_pesq=Locação" target="_blank" class="style1">Visualizar</a></td>
		</tr>
	</table></td>
</tr>
<?php
	}
?>
<?php
	//Mostrar os depósitos a fazer pro proprietário
	$query2 = "select *,(select SUM(co_valor) from contas where co_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar' and co_tipo='Locação' 
	and co_status='pendente') AS saldo 
	from contas where co_locacao='$co_locacao' and $cod_cliente3 and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar' and co_tipo='Locação' order by co_cat desc, co_cliente, co_data";
	
	//echo $query2;
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
?>
<?php
	$i = 1;
	$saldo_total = 0;
	$saldo = 0;
	$total_cred = 0;
	$total_deb = 0;
	$total_credp = 0;
	$total_debp = 0;

	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="$cor1"; }else{ $fundo="$cor1"; }
	$i++;
	$fundo2 = "96b5c9";

						$ano = substr ($not2[co_data], 0, 4);
		        $mes = substr($not2[co_data], 5, 2 );
		        $dia = substr ($not2[co_data], 8, 2 );
		        $ano1 = substr ($not2[co_data_status], 0, 4);
		        $mes1 = substr($not2[co_data_status], 5, 2 );
		        $dia1 = substr ($not2[co_data_status], 8, 2 );
		   			
	$data = mktime(0,0,0, $mes, $dia, $ano);
	$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);
	
	$diarias = round(($data1 - $data)/(24*60*60));
	$diarias = $diarias + 1;
	
	$total_dias = $diarias + $total_dias;
		   			
		        $data = "$dia/$mes/$ano";
		        $data_status = "$dia1/$mes1/$ano1";
		        
	if($not2[co_cat] == "Pagar"){
		//$not2[co_valor] = "-" . $not2[co_valor];
		$not2[co_valor] = $not2[co_valor];
		if($not2[co_status] == "ok"){
		$total_deb = $not2[co_valor] + $total_deb;
		}
		else
		{
		$total_debp = $not2[co_valor] + $total_debp;
		}
	}
	else
	{
		if($not2[co_status] == "ok"){
		$total_cred = $not2[co_valor] + $total_cred;
		}
		else
		{
		$total_credp = $not2[co_valor] + $total_credp;
		}
	}
	//$valor_tela = number_format($not2[co_valor], 2, ',', '.');
	$valor_tela = str_replace("-","","$not2[co_valor]");
	
	$total = $total_cred + $total_deb;
	$totalp = $total_credp + $total_debp;
	$saldo_total = $totalp + $total;

	if($i <= 2){
		$saldo = $not2[saldo] + $not2[co_valor];
	}
	else
	{
		$saldo = $saldo + $not2[co_valor];
	}
	$saldo_tela = number_format($saldo, 2, ',', '.');
	$saldo_ant_tela = number_format($not2[saldo], 2, ',', '.');
?>
<?php
	if($i == 0){
?>
<tr>
	<td colspan=7 align=right bgcolor="#<?php print("$fundo"); ?>" class=<?php if($not2[saldo] > 0){ echo "style7"; }else{ echo "style2"; } ?>><b>Saldo Anterior: R$ <?php print("$saldo_ant_tela"); ?></b></td>
</tr>
<?php
	}
?>
<form method="post" name="formp" id="formp" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="locacao" value="<?php print("$not2[co_locacao]"); ?>">
<input type="hidden" name="cliente" value="<?php print("$not2[co_cliente]"); ?>">
<input type="hidden" name="cod_imovel" value="<?php print("$not2[co_imovel]"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not2[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not2[co_valor]"); ?>">
<input type="hidden" name="co_forma" value="<?php print("$not2[co_forma]"); ?>">
<input type="hidden" name="co_tipo" value="<?php print("$not2[co_tipo]"); ?>">
<input type="hidden" name="co_data" value="<?php print("$not2[co_data]"); ?>">
<input type="hidden" name="co_cat" value="<?php print("$not2[co_cat]"); ?>">
<tr>
<td bgcolor="#<?php print("$fundo"); ?>" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>" align="left"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_forma]"); ?></td>
<?php
	//$valor_tela = $not2[co_valor];
?>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>R$ <input type="text" name="valor" value="<?php print("$valor_tela"); ?>" size="10" class="campo" <?php if($not2[co_status] == "ok"){ echo "readonly"; } ?>></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><IFRAME name=fixa_valor marginWidth=0 marginHeight=0 src="p_fixa_valor_depositos.php?co_cod=<?php print("$not2[co_cod]"); ?>" frameBorder=0 width=70 scrolling=no height=20 topmargin="0" leftmargin="0" class="style1"></iframe></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>para</td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><input type="text" name="dia" id="dia" size="2" maxlenght="2" class="campo" value="<?php print("$dia"); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes" id="mes" size="2" maxlenght="2" class="campo" value="<?php print("$mes"); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano" id="ano" size="4" maxlenght="4" class="campo" value="<?php print("$ano"); ?>" onKeyUp="return autoTab(this, 4, event);">
<input type="submit" name="alterar_data" id="alterar_data" value="Alterar Data" class="campo3"></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_tipo]"); ?></td>
<td bgcolor="#<?php print("$fundo"); ?>" align="right" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>
<?php
	if($not2[co_status] == "ok"){
?>
<?php print("$data_status - $not2[co_status]"); ?> <input type="submit" value="X" class=campo3 name="acao">
<?php
	}
	else
	{
?>
<input type="submit" value="Confirmar" class=campo3 name="acao">
<?php
	}
?>
	</td>
</tr>
</form>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
</tr>
<?php
	}
	$total_tela = number_format($total, 2, ',', '.');
	$totalp_tela = number_format($totalp, 2, ',', '.');
	$saldo_total_tela = number_format($saldo_total, 2, ',', '.');
	$total_cred_tela = number_format($total_cred, 2, ',', '.');
	$total_deb_tela = number_format($total_deb, 2, ',', '.');
	$total_credp_tela = number_format($total_credp, 2, ',', '.');
	$total_debp_tela = number_format($total_debp, 2, ',', '.');
	$total_deb_tela = str_replace("-","","$total_deb_tela");
	$total_debp_tela = str_replace("-","","$total_debp_tela");
?>
<tr>
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1 width=50%>Valor Pago: <span class=style6>R$ <?php print("$total_deb_tela"); ?></span></td>
			<td class=style1 width=50%>Valor à Pagar: <span class=style7>R$ <?php print("$total_debp_tela"); ?></span></td>
</tr></table>
</td>
</tr>
<tr>
	<td colspan=7 height=50></td>
</tr>
<?php
	}
?>
<?php
	//}//while0
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
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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