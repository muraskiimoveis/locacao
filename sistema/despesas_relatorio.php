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
verificaArea("GERAL_DESPESA");	
?>
<html>
<head>
<?php
include("style.php");
?>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="funcoes/js.js"></script>
<body topmargin=0 leftmargin=0 rightmargin=0>
<?php

	if($B1 == "Inserir Despesa"){
		
	$cod_cliente = $cliente;
	$cliente1 = explode("--", $cliente);
	$cliente2 = str_replace("-","",$cliente1);
	
	for($j = 1; $j <= $contador; $j++){
	  
	    if($contador == 1){
		  $valor = $co_valor;
		}else{
		  $valor = ($co_valor / $contador);
		}
		$clientes = $cliente2[$j-1];
		
		
		$query7= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
		, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status, co_despesa) 
		values('".$_SESSION['cod_imobiliaria']."','$clientes', 'Receber', '$cod', '$co_desc', 'Despesas', '".formataDataParaBd($data_despesa)."', 'pendente', '$valor'
		, '$l_cod', '$u_cod', 'Dinheiro', '".formataDataParaBd($data_despesa)."', '$u_cod', '$co_despesa')";
		$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações. $query7");
		//$codigo_desp = mysql_insert_id();
		
	}
	
	$query88= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status, co_despesa) 
	values('".$_SESSION['cod_imobiliaria']."', '$prestador', 'Pagar', '$cod', '$co_desc', 'Despesas', '".formataDataParaBd($data_despesa)."', 'pendente', '$co_valorp'
	, '$l_cod', '$u_cod', 'Dinheiro', '".formataDataParaBd($data_despesa)."', '$u_cod', '$co_despesa')";
	$result88 = mysql_query($query88) or die("Não foi possível atualizar suas informações. $query88");
	
	
	}
	
	if($B1 == "Excluir"){
		
		$cod_cliente = $cliente;
		
	}
?>
<?php
	// Pegar dados do imóvel, locação e proprietário
	$query20 = "select contador, cliente from locacao, muraski where cod=l_imovel and  
	l_cod='$l_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	
	$cod_cliente4 = " (";
	for($i3 = 1; $i3 <= $contador; $i3++){
	    if($i3==1){  
			$cod_cliente4 .= "co_cliente='".$cliente2[$i3-1]."'";
		}else{
		  	$cod_cliente4 .= " or co_cliente='".$cliente2[$i3-1]."'";
		}
	} 
	$cod_cliente4 .= ")"; 
	
	$query0 = "select * from clientes, locacao, muraski where cod=l_imovel and muraski.cliente='".$cod_cliente."' and $cod_cliente2 and 
	l_cod='$l_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	while($not0 = mysql_fetch_array($result0))
	{
						$cod = $not0[cod];
						$ref = $not0[ref];
						$titulo = strip_tags($not0[titulo]);
						$cliente = $not0[c_nome];
						$c_cod .= "-".$not0[c_cod]."-";
						$l_total = $not0[l_total];
						$l_comissao = $not0[l_comissao];
						$l_cod = $not0[l_cod];
	}
?>
<?php
	if($B1 == "Excluir"){
		$co_cod2 = $co_cod;
	}

	//$query1 = "select * from contas where co_locacao='$l_cod' and co_tipo='Despesas' and co_cod!='$co_cod2' and co_cat='Receber' order by co_data";
	$query1 = "select * from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_locacao='$l_cod' and c.co_tipo='Despesas' and c.co_cod!='$co_cod2' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
	//echo $query11;
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table width=95% border="0" cellpadding="1" cellspacing="1">
<tr height="50">
	<td colspan="6" class="style1" align="center"><b>Despesas do imóvel</b></td>
</tr>
<tr class="fundoTabela">
	<td colspan="6" class="style1"><b>Ref.:</b> <?php print("$ref"); ?> - <?php print("$titulo"); ?></td>
</tr>
<tr>
	<td colspan="6" height="25px">&nbsp;</td>
</tr>
<tr class="fundoTabelaTitulo">
<td width="40%" align="left" class=style1><b>Prest. / Prop.</b></td>
<td width="20%" align="left" class=style1><b>Descri&ccedil;&atilde;o</b></td>
<td width="12%" class=style1><b>Valor Pre.</b></td>
<td width="10%" class=style1><b>Cobrado</b></td>
<td width="9%" class=style1><b>Data</b></td>
<td width="9%" class=style1>&nbsp;</td>
</tr>
<?php
	$i = 0;
	if($B1 == "Excluir"){
	$total_desp = $co_valor;
	}
	else
	{
		$total_desp = 0;
	}
	
	
	while($not1 = mysql_fetch_array($result1))
	{
	$from = $from + 1;
		
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	if($not1[co_cat]=='Receber'){
	  $total_desp = $not1[co_valor] + $total_desp;
	}
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$l_cod"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="contador" value="<?php print($contador); ?>">
<input type="hidden" name="cliente" value="<?php print("$c_cod"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not1[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not1[co_valor]"); ?>"> 
<input type="hidden" name="co_tipo" value="<?php print("$not1[co_cat]"); ?>"> 
<tr class="<?php print("$fundo"); ?>">
<td align="left" class="style1"><?php print("$not1[c_nome]"); ?></td>
<td align="left" class="style1"><?php print("$not1[co_desc]"); ?></td>
<td align="left" class="style7"><? if($not1[co_cat]=='Pagar'){ ?>R$ <?php print("$not1[co_valor]"); ?><? } ?></td>
<td align="left" class="style6"><? if($not1[co_cat]=='Receber'){ ?>R$ <?php print("$not1[co_valor]"); ?><? } ?></td>
<td align="left" class="style1"><?php print(formataDataDoBd($not1[co_data])); ?></td>
<td align="left" class="style1"><input type="submit" class="campo3" name="B1" value="Excluir"></td>
</tr>
</form>
<?php
	}
	 	
	//echo "Total Desp: " . $total_desp . "<br>";
	$l_saldo = $l_total - ($l_comissao + $total_desp);
	//echo "Saldo Loc: " . $l_saldo . "<br>";	

	if($B1 == "Excluir"){
	
			if($co_tipo=='Receber'){  		
	  			
				$total_desp2 = $total_desp - $co_valor;
				$l_saldo2 = $l_total - ($l_comissao + $total_desp2);
		
				$query4= "update locacao set l_desp='$total_desp2', l_saldo='$l_saldo2' where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
						
				$query = "delete from contas where co_cod = '$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");

				$cliente20 = str_replace("-","",$cod_cliente);		
	
				$query7= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
				, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status) 
				values('".$_SESSION['cod_imobiliaria']."','$cliente20', 'Pagar', '$cod', '$co_desc', 'Locação', current_date, 'pendente', '$co_valor'
				, '$l_cod', '$u_cod', 'Depósito', current_date, '$u_cod')";
				$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações. $query7");
		}else{
		  		$query = "delete from contas where co_cod = '$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");
		}
	}
	
	if($B1 == "Inserir Despesa"){
	  
	$query10 = "select SUM(c.co_valor) as valor_desp from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_locacao='$l_cod' and c.co_tipo='Despesas' and c.co_cod!='$co_cod2' and c.co_cat='Receber' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
	$result10 = mysql_query($query10);
	while($not10 = mysql_fetch_array($result10)){
		$total_desp = $not10['valor_desp'];
	}  
		
	$query4= "update locacao set l_desp='$total_desp', l_saldo='$l_saldo' where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	//echo $query4."<br>";
	
	$query3 = "select * from contas where co_locacao='$l_cod' and co_cat='Pagar' and co_status='pendente' and co_fixar='no' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'
	order by co_data";
	//echo $query3 . "<br>";
	$result3 = mysql_query($query3);
	
	$j = 1;
		
	while($not3 = mysql_fetch_array($result3))
	{
		//echo "Valor: " . $not3[co_valor] . "<br>";
		//echo "Saldo fora do if: " . $saldo2 . "<br>";
		if($saldo == "")
		{
			$saldo = $not3[co_valor] - $co_valor;
			//echo "Saldo: " . $saldo . "<br>";
		}
		else
		{
			if($saldo > 0)
			{
			$saldo = $not3[co_valor] - $saldo2;
			}
			else
			{
			$saldo = $not3[co_valor] + $saldo2;
			}
			//echo "Saldo Registrado: " . $saldo . "<br>";
		}
		
		if($saldo >= 0){
			$saldo2 = $saldo;
			session_register("saldo2");
				
			//echo $parcela[$j] . " | " . $saldo[$j] . "<br>";
			
			$query2 = "update contas set co_valor='$saldo', co_data_status=current_date	where co_cod='$not3[co_cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações. $query2");
			//echo $query2 . "<br>";
			
			$query4 = "update contas set co_status='ok', co_data_status=current_date where co_cod='$codigo_desp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");
			
			break;
			
		}
		elseif($saldo < 0)
		{
			$saldo2 = $saldo;
			session_register("saldo2");
			
			$query2 = "update contas set co_valor='0', co_status='ok', co_data_status=current_date 
			where co_cod='$not3[co_cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações. $query2");
			//echo $query2 . "<br>";
			
			$query4 = "update contas set co_status='ok', co_data_status=current_date where co_cod='$codigo_desp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");
			//echo $query4;
		}
	}
	
	if($saldo < 0)
	{
		$saldo3 = str_replace("-","","$saldo");
		
	$query7= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status) 
	values('".$_SESSION['cod_imobiliaria']."','$cod_cliente', 'Receber', '$cod', '$co_desc', 'Despesas', '".formataDataParaBd($data_despesa)."', 'pendente', '$saldo3'
	, '$l_cod', '$u_cod', 'Depósito', '".formataDataParaBd($data_despesa)."', '$u_cod')";
	$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações. $query7");
		
	}
	
	session_unregister("saldo2");
	
	/*
	$ultimo = $j - 1;
	
	if($saldo[$ultimo] > 0){
		//echo $saldo[($j-1)] . "<br>";
	
	$query7= "insert into contas (co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario, co_forma, co_data_status) 
	values('$c_cod', 'Receber', '$cod', '$co_desc', 'Despesas', current_date, 'pendente', '$saldo[$ultimo]'
	, '$l_cod', '$valid_user', 'Depósito', current_date)";
	$result7 = mysql_query($query7) or die("Não foi possível inserir suas informações. $query7");	
	
	}
	*/
	
	}//termina if inserir despesa
	
	/*
	if($B1 == "Excluir"){
		
	$query5 = "select * from locacao where l_cod='$l_cod'";
	//echo $query5;
	$result5 = mysql_query($query5);
	
	while($not5 = mysql_fetch_array($result5))
	{
		$total_desp = $not5[l_desp] - $co_valor;
		
	
	$query4= "update locacao set l_desp='$total_desp2', l_saldo='$l_saldo' where l_cod='$l_cod'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");
	
	}
	
	}//termina if excluir despesa
	*/
?>
<tr class="fundoTabela">
  <td class="style1" colspan=6><b>Legenda:</b></td>
</tr>
<tr class="fundoTabela">
  <td class="style6" colspan=6>Azul - Despesas do propriet&aacute;rio</td>
</tr>
<tr class="fundoTabela">
  <td class="style7" colspan=6>Vermelho - Despesas do prestador</td>
</tr>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$l_cod"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="cliente" value="<?php print("$c_cod"); ?>">
<input type="hidden" name="contador" value="<?php print($contador); ?>">
<tr>
  <td colspan="6">
<table border="0" cellpadding="0" cellspacing="1" width="100%">
<tr height="50">
	<td class=style1 colspan=6 align="center"><b>Cadastrar nova despesa</b></td>
</tr>
<tr class="fundotabela">
  <td width="20%" class=style1>Prestador</td>
  <td width="80%" class="style1"><select name="prestador" id="prestador" class="campo">
    <option value="">Selecione</option>
    <?
            $prestadores = mysql_query("SELECT c_cod, c_nome, c_prestador FROM clientes WHERE c_tipo='prestador' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY c_nome ASC");
 			while($linha = mysql_fetch_array($prestadores)){			   
					echo('<option value="'.$linha[c_cod].'">'.$linha[c_nome].' - '.$linha[c_prestador].'</option>');
 			}
    ?>
  </select></td>
</tr>
<tr class="fundotabela">
	<td class=style1>Descrição:</td>
	<td class="style1"><input type="text" class="campo" name="co_desc" size="20"></td>
</tr>
<tr class="fundoTabela">
	<td class=style1>Despesa para:</td>
	<td class="style1"><select name="co_despesa" id="co_despesa" class="campo">
    	<option value="Proprietário">Proprietário</option>
    	<option value="Imobiliária">Imobiliária</option>
  </select></td>
</tr>
<tr class="fundotabela">
	<td class=style1>Valor Cobrado:</td>
	<td class=style1>R$ <input type="text" class="campo" name="co_valor" size="10"></td>
</tr>
<tr class="fundotabela">
  <td class=style1>Valor do Prestador:</td>
  <td class=style1>R$
    <input type="text" class="campo" name="co_valorp" size="10"></td>
  </tr>
<tr class="fundotabela">
  <td class=style1>Data</td>
  <td class=style1><input type="text" class="campo" name="data_despesa" size="12" maxlength="10" value="<?=$data_despesa ?>" onKeyPress="return (Mascara(this,event,'##/##/####'));return validarCampoNumerico(event);"></td>
</tr>
<tr>
	<td colspan=3><input type="submit" class="campo3" name="B1" value="Inserir Despesa"></td>
</tr></table></td>
</tr>
</form>
<tr>
<td colspan=11 align=center class=style1><input type="button" name="fechar" id="fechar" class="campo3" value="Fechar Janela" Onclick="window.close();"></td>
</tr>
</table>
<p>
<?php
mysql_close($con);
?>
<?php
//include("carimbo.php");
?>
</body>
</html>