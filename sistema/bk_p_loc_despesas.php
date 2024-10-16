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
</head>
<script type="text/javascript" src="funcoes/js.js"></script>
<body topmargin=0 leftmargin=0 rightmargin=0 onUnload="window.opener.location.reload()">
<br>
<?php

	if($B1 == "Inserir Despesa"){
		
		$cod_cliente = $cliente;
		
	$query7= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status) 
	values('".$_SESSION['cod_imobiliaria']."','$cliente', 'Receber', '$cod', '$co_desc', 'Despesas', '".formataDataParaBd($data_despesa)."', 'pendente', '$co_valor'
	, '$l_cod', '$valid_user', 'Dinheiro', '".formataDataParaBd($data_despesa)."', '$valid_user')";
	$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações. $query7");
	$codigo_desp = mysql_insert_id();
	
	$query88= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status) 
	values('".$_SESSION['cod_imobiliaria']."', '$prestador', 'Pagar', '$cod', '$co_desc', 'Despesas', '".formataDataParaBd($data_despesa)."', 'pendente', '$co_valorp'
	, '$l_cod', '$valid_user', 'Dinheiro', '".formataDataParaBd($data_despesa)."', '$valid_user')";
	$result88 = mysql_query($query88) or die("Não foi possível atualizar suas informações. $query88");
	
	}
	
	if($B1 == "Excluir"){
		
		$cod_cliente = $cliente;
		
	}
?>
<?php
	// Pegar dados do imóvel, locação e proprietário
	$query0 = "select * from clientes, locacao, muraski where cod=l_imovel and c_cod=cliente and 
	l_cod='$l_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	while($not0 = mysql_fetch_array($result0))
	{
						$cod = $not0[cod];
						$ref = $not0[ref];
						$titulo = $not0[titulo];
						$cliente = $not0[c_nome];
						$c_cod = $not0[c_cod];
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
	$query1 = "select * from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_locacao='$l_cod' and c.co_tipo='Despesas' and c.co_cod!='$co_cod2' and c.co_cat='Pagar' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
	//echo $query11;
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table width=100% border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
<tr>
	<td colspan="6" class="style1">Despesas do imóvel Ref.: <?php print("$ref"); ?> - <?php print("$titulo"); ?></td>
</tr>
<tr>
<td width=148 bgcolor="#<?php print("$cor1"); ?>" align="left" class=style1><b>Prestador</td>
<td width=145 bgcolor="#<?php print("$cor1"); ?>" align="left" class=style1><b>Descri&ccedil;&atilde;o</td>
<td width="181" bgcolor="#<?php print("$cor1"); ?>" class=style1><b>Valor Pr.</td>
<td width="97" bgcolor="#<?php print("$cor1"); ?>" class=style1><b>Data</td>
<td width="97" bgcolor="#<?php print("$cor1"); ?>" class=style1><b></td>
</tr>
<?php
	$i = 1;
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
		
	if (($i % 2) == 1){ $fundo="$cor1"; }else{ $fundo="$cor1"; }
	$i++;
	
	$query10 = "select * from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_locacao='$l_cod' and c.co_tipo='Despesas' and c.co_cod!='$co_cod2' and c.co_cat='Receber' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
	$result10 = mysql_query($query10);
	while($not10 = mysql_fetch_array($result10)){
		$total_desp = $not10[co_valor] + $total_desp;
	}
	
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$l_cod"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="cliente" value="<?php print("$c_cod"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not1[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not1[co_valor]"); ?>">
<tr>
<td align="left" bgcolor="<?php print("$fundo"); ?>" class=style1><?php print("$not1[c_nome]"); ?></td>
<td align="left" bgcolor="<?php print("$fundo"); ?>" class=style1><?php print("$not1[co_desc]"); ?></td>
<td align="left" bgcolor="<?php print("$fundo"); ?>" class=style1>
R$ <?php print("$not1[co_valor]"); ?></td>
<td align="left" bgcolor="<?php print("$fundo"); ?>" class=style1><?php print(formataDataDoBd($not1[co_data])); ?></td>
<td width="470" align="left" bgcolor="<?php print("$fundo"); ?>" class=style1>
<input type="submit" class="campo3" name="B1" value="Excluir"></td>
</tr>
</form>
<?php
	}
	 	
	//echo "Total Desp: " . $total_desp . "<br>";
	$l_saldo = $l_total - ($l_comissao + $total_desp);
	//echo "Saldo Loc: " . $l_saldo . "<br>";

	if($B1 == "Excluir"){
		
	$query = "delete from contas where co_cod = '$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");
	//echo $query . "<br>";
	
	$query11 = "select * from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_locacao='$l_cod' and c.co_tipo='Despesas' and c.co_cod!='$co_cod2' and c.co_cat='Receber' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
	//echo $query11;
	$result11 = mysql_query($query11);
	while($not11 = mysql_fetch_array($result11)){
	  $co_codr = $not11[co_cod];
	}
		
			$query12 = "delete from contas where co_cod = '$co_codr' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			//echo $query12;
			$result12 = mysql_query($query12) or die("Não foi possível apagar suas informações. $query12");
	     
			
		$total_desp2 = $total_desp - $co_valor;
		//echo "Total Desp2: " . $total_desp2 . "<br>";
		$l_saldo2 = $l_total - ($l_comissao + $total_desp2);
		//echo "Saldo Loc2: " . $l_saldo2 . "<br>";
		
	$query4= "update locacao set l_desp='$total_desp2', l_saldo='$l_saldo2' where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	//echo $query4 . "<br>";
			
	/*
	$query7= "insert into contas (co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status) 
	values('$c_cod', 'Pagar', '$cod', '$co_desc', 'Locação', current_date, 'pendente', '$co_valor'
	, '$l_cod', '$valid_user', 'Depósito', current_date, '$valid_user')";
	$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações. $query7");
	*/
	
	}
	
	if($B1 == "Inserir Despesa"){
		
	$query4= "update locacao set l_desp='$total_desp', l_saldo='$l_saldo' where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	
	
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
		}
	}
	
	if($saldo < 0)
	{
		$saldo3 = str_replace("-","","$saldo");
		
	$query7= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status) 
	values('".$_SESSION['cod_imobiliaria']."','$cod_cliente', 'Receber', '$cod', '$co_desc', 'Despesas', '".formataDataParaBd($data_despesa)."', 'pendente', '$saldo3'
	, '$l_cod', '$valid_user', 'Depósito', '".formataDataParaBd($data_despesa)."', '$valid_user')";
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
<tr>
	<td colspan=6 height=1 bgcolor="<?php print("$cor6"); ?>"></td>
</tr>
<tr>
	<td class=style1 colspan=6><b>Cadastrar nova despesa</td>
</tr>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$l_cod"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="cliente" value="<?php print("$c_cod"); ?>">
<tr>
	<td colspan=6><table cellpadding="1" cellspacing="1">
<tr>
  <td width="120" class=style1>Prestador</td>
  <td width="182" class="style1"><select name="prestador" id="prestador" class="campo">
    <option value="">Selecione</option>
    <?
            $prestadores = mysql_query("SELECT c_cod, c_nome, c_prestador FROM clientes WHERE c_tipo='prestador' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY c_nome ASC");
 			while($linha = mysql_fetch_array($prestadores)){			   
					echo('<option value="'.$linha[c_cod].'">'.$linha[c_nome].' - '.$linha[c_prestador].'</option>');
 			}
    ?>
  </select></td>
</tr>
<tr>
	<td class=style1>Descrição:</td>
	<td class="style1"><input type="text" class="campo" name="co_desc" size="20"></td>
</tr>
<tr>
	<td class=style1>Valor Cobrado:</td>
	<td class=style1>R$ <input type="text" class="campo" name="co_valor" size="10"></td>
</tr>
<tr>
  <td class=style1>Valor do Prestador:</td>
  <td class=style1>R$
    <input type="text" class="campo" name="co_valorp" size="10"></td>
  </tr>
<tr>
  <td class=style1>Data</td>
  <td class=style1><input type="text" class="campo" name="data_despesa" size="12" maxlength="10" onKeyPress="return (Mascara(this,event,'##/##/####'));return validarCampoNumerico(event);"></td>
</tr>
<tr>
	<td colspan=3><input type="submit" class="campo3" name="B1" value="Inserir Despesa"></td>
</tr></table></td>
</tr>
</form>
<tr>
<td colspan=11 align=center class=style1><b>| <a href="javascript:close()" class=style1>Fechar</a> |</td>
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