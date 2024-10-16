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
verificaArea("IMOV_GERAL");	
?>
<html>
<head>
<?php
include("style.php");
?>
<link type="text/css" rel="stylesheet" href="css/estilos_sistema.css" />
</head>
<script language="javascript">
function valida()
{

  if (document.form1.prestador.value == "")
  {
    alert("Por Favor, selecione o campo Prestador");
    document.form1.prestador.focus();
    return false;
  }

  if (document.form1.co_desc.value == "")
  {
    alert("Por Favor, preencha o campo Descrição");
    document.form1.co_desc.focus();
    return false;
  }

  if (document.form1.co_valor.value == "")
  {
    alert("Por Favor, preencha o campo Valor Cobrado");
    document.form1.co_valor.focus();
    return false;
  }
  if (document.form1.co_valorp.value == "")
  {
    alert("Por Favor, preencha o campo Valor do Prestador");
    document.form1.co_valorp.focus();
    return false;
  }
  if (document.form1.data_despesa.value == "")
  {
    alert("Por Favor, preencha o campo Data");
    document.form1.data_despesa.focus();
    return false;
  }

	return true;
}
</script>
<script type="text/javascript" src="funcoes/js.js"></script>
<body topmargin=0 leftmargin=0 rightmargin=0>

<?php
	// Pegar dados do imóvel, locação e proprietário
	$query20 = "select contador, cliente from muraski where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	
	$query0 = "select * from clientes c, muraski m where m.cod='$cod' and m.cliente='".$cod_cliente."' and $cod_cliente2 and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	while($not0 = mysql_fetch_array($result0))
	{
						$cod = $not0[cod];
						$ref = $not0[ref];
						$titulo = strip_tags($not0[titulo]);
						$cliente = $not0[c_nome];
						$c_cod .= "-".$not0[c_cod]."-";
    }
?>
<div align="center">
  <center>
<table width="95%" border="0" cellpadding="1" cellspacing="1">
<tr height="50">
	<td colspan="6" class="style1"><p align="center"><b>Despesas do Imóvel</b></p></td>
</tr>
<tr class="fundoTabela">
	<td colspan="6" class="style1"><b>Ref.:</b> <?php print("$ref"); ?> - <?php print("$titulo"); ?></td>
</tr>
<tr height="25px">
	<td>&nbsp;</td>
</tr>
<tr class="fundoTabela">
  <td height="25px" colspan="6" align="left" class="style1""><div align="center"><b><a href="despesas.php?cod=<?=$cod ?>&contas=pendente&link=s" class="style1">Pendentes</a> | <a href="despesas.php?cod=<?=$cod ?>&contas=ok&link=s" class="style1">Pagas</a></b> | <a href="despesas.php?cod=<?=$cod ?>&contas=%&link=s" class="style1"><b>Todas</b></a>
  </div></td>
  </tr>
<?

	if($l_cod<>''){
    	$query01 = "select * from clientes, locacao, muraski where cod=l_imovel and muraski.cliente='".$cod_cliente."' and $cod_cliente2 and l_cod='$l_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result01 = mysql_query($query01);
		while($not01 = mysql_fetch_array($result01))
		{
				$l_total = $not01[l_total];
				$l_comissao = $not01[l_comissao];
		}
	}


	if($B1 == "Excluir"){
	
			if($co_tipo=='Receber'){  
	  			
	  			if($l_cod==0){
					$query = "delete from contas where co_cod = '$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");			
				}else{
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
				}
		}else{  
		  	$query = "delete from contas where co_cod = '$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");
		}
	}

	if($B1 == "Inserir Despesa"){
	  
	$contagem = mysql_query("SELECT co_locacao, co_status FROM contas WHERE co_imovel='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co_tipo='Locação' ORDER BY co_locacao DESC LIMIT 1");
 	while($linha = mysql_fetch_array($contagem)){
 	      $locacao = $linha['co_locacao'];
		  if($linha['co_status']=='pendente'){
		      $pendente = count($linha['co_status']);
		  }elseif($linha['co_status']=='ok'){
		      $ok = count($linha['co_status']);	
		  }
	}
	
	if($pendente > 0 && $ok == 0){
	  $l_cod = $locacao;
      $status_conta = "ok";
	}elseif($pendente == 0 && $ok > 0){
	  $l_cod = 0;
      $status_conta = "pendente";
	}
	
	$co_valorp = str_replace(".", "", $_GET['co_valorp']);  
	$co_valorp = str_replace(",", ".", $co_valorp); 	
	
	$co_valor = str_replace(".", "", $_GET['co_valor']);  
	$co_valor = str_replace(",", ".", $co_valor); 	

	$cliente1 = explode("--", $cod_cliente);
	$cliente2 = str_replace("-","",$cliente1);	
	
	for($j = 1; $j <= $contador; $j++){
	  
	    if($contador == 1){
		  $valor = $co_valor;
		}else{
		  $valor = ($co_valor / $contador);
		}
		$clientes = $cliente2[$j-1];
		
	$query7= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status)
	values('".$_SESSION['cod_imobiliaria']."','$clientes', 'Receber', '$cod', '$co_desc', 'Despesas', '".formataDataParaBd($data_despesa)."', '".$status_conta."', '$valor'
	, '$l_cod', '$u_cod', 'Dinheiro', '".formataDataParaBd($data_despesa)."', '$u_cod')";
	$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações. $query7");
	//$codigo_desp = mysql_insert_id();
	}

	$query88= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status) 
	values('".$_SESSION['cod_imobiliaria']."', '$prestador', 'Pagar', '$cod', '$co_desc', 'Despesas', '".formataDataParaBd($data_despesa)."', 'pendente', '$co_valorp'
	, '$l_cod', '$u_cod', 'Dinheiro', '".formataDataParaBd($data_despesa)."', '$u_cod')";
	$result88 = mysql_query($query88) or die("Não foi possível atualizar suas informações. $query88");

	}
	
	if($link=='s'){
	 	$query1 = "select * from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_imovel='$cod' and c.co_tipo='Despesas' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c.co_status like '$contas' order by c.co_data"; 
	}else{
		$query1 = "select * from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_imovel='$cod' and c.co_tipo='Despesas' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data"; 
	}
		$result1 = mysql_query($query1);
?>
<tr class="fundoTabelaTitulo">
<td width="40%" align="left" class=style1><b>Prop. / Prest.</td>
<td width="20%" align="left" class=style1><b>Descri&ccedil;&atilde;o</td>
<td width="12%" class=style1><b>Valor</td>
<td width="10%" class=style1><b>Data</td>
<td width="9%" class=style1><b>Status</td>
<td width="9%" class="style1"><b></td>
</tr>
<?php
	$i = 0;
	while($not1 = mysql_fetch_array($result1))
	{
	$from = $from + 1;
		
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	if($not1[co_cat]=='Receber'){
		$total_desp = $not1[co_valor] + $total_desp;         
	}
	
?>
<form method="get" nmae="form2" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="cliente" value="<?php print("$c_cod"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not1[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not1[co_valor]"); ?>">
<input type="hidden" name="contador" value="<?php print($contador); ?>">
<input type="hidden" name="co_tipo" value="<?php print("$not1[co_cat]"); ?>"> 
<input type="hidden" name="l_cod" value="<?php print("$not1[co_locacao]"); ?>"> 
<? if($not1[co_cat]=='Receber'){ ?>
<input type="hidden" name="total_desp" value="<?php print("$total_desp"); ?>"> 
<? } ?>
<tr class="<?php print("$fundo"); ?>">
<td align="left" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>><?php print("$not1[c_nome]"); ?></td>
<td align="left" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>><?php print("$not1[co_desc]"); ?></td>
<td align="left" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>>R$ <?php print(number_format($not1[co_valor], 2, ',', '.')); ?></td>
<td align="left" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>><?php print(formataDataDoBd($not1[co_data])); ?></td>
<td align="left" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>><?php print($not1[co_status]); ?></td>
<td align="left" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>><input type="submit" class="campo3" name="B1" value="Excluir"></td>
</tr>
</form>
<?php
	}
	if($B1 == "Inserir Despesa"){
	  
		$query01 = "select * from clientes, locacao, muraski where cod=l_imovel and muraski.cliente='".$cod_cliente."' and $cod_cliente2 and l_cod='$l_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result01 = mysql_query($query01);
		while($not01 = mysql_fetch_array($result01))
		{
				$l_total = $not01[l_total];
				$l_comissao = $not01[l_comissao];
		}  	
	
	  
	$query10 = "select SUM(c.co_valor) as valor_desp from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_locacao='$l_cod' and c.co_tipo='Despesas' and c.co_cod!='$co_cod2' and c.co_cat='Receber' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
	$result10 = mysql_query($query10);
	while($not10 = mysql_fetch_array($result10)){
		$total_desp = $not10['valor_desp'];
	} 
	
	$l_saldo = $l_total - ($l_comissao + $total_desp);
		
	$query4= "update locacao set l_desp='$total_desp', l_saldo='$l_saldo' where l_cod='$l_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	//echo $query4;
	
	$query3 = "select * from contas where co_locacao='$l_cod' and co_cat='Pagar' and co_status='pendente' and co_fixar='no' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'
	order by co_data";
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
<tr height="50">
	<td class=style1 colspan=6><p align="center"><b>Cadastrar nova despesa</b></p></td>
</tr>
<form method="get" name="form1" action="<?php print("$PHP_SELF"); ?>" onSubmit="return valida();">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="cliente" value="<?php print("$c_cod"); ?>">
<input type="hidden" name="contador" value="<?php print($contador); ?>">
<tr>
	<td colspan=6>
<table width="100%" cellpadding="1" cellspacing="1">
<tr class="fundoTabela">
  <td width="20%" class=style1>Prestador</td>
  <td width="80%" class="style1"><select name="prestador" id="prestador" class="campo">
    <option value="">Selecione</option>
<?
   $prest_sql = "SELECT c_cod, c_nome, c_prestador, c_prestador2 FROM clientes WHERE (c_tipo='prestador' or c_tipo2 LIKE '%-5-%') AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY c_nome ASC";
   $prestadores = mysql_query($prest_sql) or die ("Erro 365");
   while ($linha = mysql_fetch_array($prestadores)) {
      if ($linha[c_prestador2] == "") {
         echo('<option value="'.$linha[c_cod].'">'.$linha[c_nome].' - '.$linha[c_prestador].'</option>');
      } else {
         $t_prestador = explode("--", $linha[c_prestador2]);
         $t_prestador = str_replace("-","",$t_prestador);
         if (count($t_prestador) > 0) {
            foreach ($t_prestador as $prest) {
               $sql = "SELECT tp_tipo FROM tipos_prestadores WHERE tp_cod = '$prest'";
               $rs = mysql_query($sql) or die ("Erro 173");
               $n = mysql_fetch_assoc($rs);
               if ($n[tp_tipo] <> "") {
?>
                  <option value='<?=$linha[c_cod]?>'><?=$linha[c_nome]?> - <?=$n[tp_tipo]?></option>
<?
               }
            }
         }
      }
   }
?>
<?
/**
?>
    <option value="">Selecione</option>
    <?
            $prestadores = mysql_query("SELECT c_cod, c_nome, c_prestador FROM clientes WHERE c_tipo='prestador' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY c_nome ASC");
 			while($linha = mysql_fetch_array($prestadores)){
					echo('<option value="'.$linha[c_cod].'">'.$linha[c_nome].' - '.$linha[c_prestador].'</option>');
 			}
/**/
?>
  </select></td>
</tr>
<tr class="fundoTabela">
	<td class=style1>Descrição:</td>
	<td class="style1"><input type="text" class="campo" name="co_desc" size="20"></td>
</tr>
<tr class="fundoTabela">
	<td class=style1>Valor Cobrado:</td>
	<td class=style1>R$ <input type="text" class="campo" name="co_valor" size="10" onKeydown="Formata(this,20,event,2)"></td>
</tr>
<tr class="fundoTabela">
  <td class=style1>Valor do Prestador:</td>
  <td class=style1>R$
    <input type="text" class="campo" name="co_valorp" size="10" onKeydown="Formata(this,20,event,2)"></td>
  </tr>
<tr class="fundoTabela">
  <td class=style1>Data</td>
  <td class=style1><input type="text" class="campo" name="data_despesa" size="12" maxlength="10" onKeyPress="return (Mascara(this,event,'##/##/####'));return validarCampoNumerico(event);"></td>
</tr>
<tr>
	<td colspan=><input type="submit" class="campo3" name="B1" value="Inserir Despesa"></td>
</tr>
</table>
</td>
</tr>
</form>
<tr height="50">
<td colspan=11 align=center class=style1><input type="button" onclick="window.close();" value="Fechar Janela" class="campo3" id="fechar" name="fechar"/></td>
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