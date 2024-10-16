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
</head>
<script type="text/javascript" src="funcoes/js.js"></script>
<body topmargin=0 leftmargin=0 rightmargin=0>
<br>
<?php

    if($B1 == "Excluir"){
		
	$query = "delete from contas where co_cod = '$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");
		
	}

	if($B1 == "Inserir Despesa"){
		
	$cod_cliente = $cliente;
		
	$query7= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_usuario, co_forma, co_data_status, co_usuario_status) 
	values('".$_SESSION['cod_imobiliaria']."','$cliente', 'Receber', '$cod', '$co_desc', 'Despesas Imóvel', '".formataDataParaBd($data_despesa)."', 'pendente', '$co_valor'
	, '$valid_user', 'Dinheiro', '".formataDataParaBd($data_despesa)."', '$valid_user')";
	$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações. $query7");
	$codigo_desp = mysql_insert_id();
	
	$query88= "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
	, co_usuario, co_forma, co_data_status, co_usuario_status) 
	values('".$_SESSION['cod_imobiliaria']."', '$prestador', 'Pagar', '$cod', '$co_desc', 'Despesas Imóvel', '".formataDataParaBd($data_despesa)."', 'pendente', '$co_valorp'
	, '$valid_user', 'Dinheiro', '".formataDataParaBd($data_despesa)."', '$valid_user')";
	$result88 = mysql_query($query88) or die("Não foi possível atualizar suas informações. $query88");
	
	}
	
	$query0 = "select * from clientes c, muraski m where m.cod='$cod' and c.c_cod=m.cliente and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	while($not0 = mysql_fetch_array($result0))
	{
						$cod = $not0[cod];
						$ref = $not0[ref];
						$titulo = $not0[titulo];
						$cliente = $not0[c_nome];
						$c_cod = $not0[c_cod];
    }
	
	$query1 = "select * from contas c INNER JOIN clientes cl ON (c.co_cliente=cl.c_cod) where c.co_imovel='$cod' and c.co_tipo='Despesas Imóvel' and c.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.co_data";
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table width=100% border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
<tr>
	<td colspan="6" class="style1">Despesas do imóvel Ref.: <?php print("$ref"); ?> - <?php print("$titulo"); ?></td>
</tr>
<tr>
<td width=325 bgcolor="#<?php print("$cor1"); ?>" align="left" class=style1><b>Prop. / Prest.</td>
<td width=168 bgcolor="#<?php print("$cor1"); ?>" align="left" class=style1><b>Descri&ccedil;&atilde;o</td>
<td width="142" bgcolor="#<?php print("$cor1"); ?>" class=style1><b>Valor</td>
<td width="94" bgcolor="#<?php print("$cor1"); ?>" class=style1><b>Data</td>
<td width="312" bgcolor="#<?php print("$cor1"); ?>" class=style1><b></td>
</tr>
<?php
	$i = 1;
	while($not1 = mysql_fetch_array($result1))
	{
	$from = $from + 1;
		
	if (($i % 2) == 1){ $fundo="$cor1"; }else{ $fundo="$cor1"; }
	$i++;
	
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="cliente" value="<?php print("$c_cod"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not1[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not1[co_valor]"); ?>">
<tr>
<td align="left" bgcolor="<?php print("$fundo"); ?>" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>><?php print("$not1[c_nome]"); ?></td>
<td align="left" bgcolor="<?php print("$fundo"); ?>" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>><?php print("$not1[co_desc]"); ?></td>
<td align="left" bgcolor="<?php print("$fundo"); ?>" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>>
R$ <?php print("$not1[co_valor]"); ?></td>
<td align="left" bgcolor="<?php print("$fundo"); ?>"class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>><?php print(formataDataDoBd($not1[co_data])); ?></td>
<td width="312" align="left" bgcolor="<?php print("$fundo"); ?>" class=<?php if($not1[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>>
<input type="submit" class="campo3" name="B1" value="Excluir"></td>
</tr>
</form>
<?php
	}
?>
<tr>
	<td colspan=6 height=1 bgcolor="<?php print("$cor6"); ?>"></td>
</tr>
<tr>
	<td class=style1 colspan=6><b>Cadastrar nova despesa</td>
</tr>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
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