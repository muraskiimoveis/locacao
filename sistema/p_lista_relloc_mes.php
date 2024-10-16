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
          document.location.href='p_lista_relloc_mes.php?id_excluir=' + l_cod + '&dia2=' + dia2 + '&mes2=' + mes2 + '&ano2=' + ano2 + '&dia3=' + dia3 + '&mes3=' + mes3 + '&ano3=' + ano3 + '&campo=' + campo + '&pusuarios=' + pusuarios + '&list=' + list + '&lista=' + lista + '&B1=Pesquisar';
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
	if(!$from){
		$from = intval($screen * 10);
	}
	

if($_GET['id_excluir']){
  
    $l_cod = $_GET['id_excluir'];
	
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
	}
	*/

if($lista == "")
	{
?>
<div align="center">
  <center>
<form name="form1" id="form1" method="post" action="">
<table width="75%" border="0" cellspacing="1">
<tr height="50"><td colspan=9 class=style1>
<p align="center"><b>Relatório de Locação</b><br />Para excluir uma reserva mensal, clique no botão do lado direito.</p>
</td></tr>
<tr>
  <td colspan=9 class=style1>
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
	if($campo == "locado"){
	$query1 = "select * from locacao where $b_usuarios l_data_sai>='$ano2-$mes2-$dia2' AND 
	l_data_sai<='$ano3-$mes3-$dia3' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato!='' order by l_data";
	}else{
	$query1 = "select * from locacao where $b_usuarios l_data>='$ano2-$mes2-$dia2' AND 
	l_data<='$ano3-$mes3-$dia3' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato!='' order by l_data";
	}
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<tr>
<tr class="fundoTabelaTitulo" height="25px">
<td width="8%" class="style1">
<p align="center"><b>Data Reserva</b></td>
<td width="8%" class="style1">
<p align="center"><b>Entrada</b></td>
<td width="8%" class="style1">
<p align="center"><b>Saída</b></td>
<td class="style1" width="30%">
<p align="center"><b>Imóvel / Locatário</b></td>
<td width="8%" class="style1">
<p align="center"><b>Valor</b></td>
<td width="6%" class="style1">
<p align="center"><b>Depósitos</b></td>
<td width="19%" class="style1">
<p align="center"><b>Demostrativo<br />Cadastro Serviços</b></td>
<td width="6%" class="style1">
<p align="center"><b>Contrato</b></td>
<td width="6%" class="style1">
<p align="center"></td>
</tr>
<?php
	$i =0;
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
<input type="hidden" name="cod" value="<?php print("$not1[l_imovel]"); ?>">
<input type="hidden" name="l_cliente" value="<?php print("$not1[l_cliente]"); ?>">
<input type="hidden" name="alterar" value="1">
<tr>
<td class="fundoTabelaTitulo style1" align="center">
<?php print("$data_res"); ?></td>
<td class="<?php print("$fundo"); ?> style1">
<?php print("$data_ent"); ?></td>
<td class="<?php print("$fundo"); ?> style1">
<?php print("$data_sai"); ?></td>
<td class="<?php print("$fundo"); ?> style1">
<?php

	$query4 = "select m.cod, m.ref, t.t_nome from muraski m inner join rebri_tipo t on (m.tipo=t.t_cod) where m.cod='$not1[l_imovel]' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
      $cod = $not4['cod'];
?>
<a href="detalhes.php?cod=<?php print("$not4[cod]"); ?>&codi=<?=$_SESSION['cod_imobiliaria']; ?>&nomei=<?=$_SESSION['nome_imobiliaria'] ?>&pastai=<?=$_SESSION['nome_pasta'] ?>" class="style1">Ref.:<?php print("$not4[ref]"); ?></a> - <?php print("$not4[t_nome]"); ?> - 
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
	$total_total = $not1[l_total] + $total_total;
	$total = number_format($not1[l_total], 2, ',', '.');

?>
</td>
<td class="<?php print("$fundo"); ?> style1">
<input type="hidden" name="l_total" value="<?php print("$total"); ?>">R$ <?php print("$total"); ?></td>
<td class="<?php print("$fundo"); ?> style1">
<a href="#" onclick="NewWindow('p_extrato_depositos_mes.php?locacao=<?php print("$not1[l_cod]"); ?>&cod_imovel=<?=$not1[l_imovel] ?>&tipo_pesq=locacao', 'janela', 750, 500, 'yes');" class="style1">Depósitos</a></td>
<td class="<?php print("$fundo"); ?> style1">
<a href="javascript:;" onClick="NewWindow('demonstrativos.php?l_cod=<?php print("$not1[l_cod]"); ?>', 'janela', 750, 500, 'yes')" class="style1"><b>Demonstrativo</b></a><br /><a href="javascript:;" onClick="NewWindow('cadastro_servicos.php?cod=<?php print("$cod"); ?>&l_cod=<?php print("$not1[l_cod]"); ?>', 'janela', 750, 500, 'yes');" class="style1"><b>Cadastro de Serviços</b></a></td>
<td class="<?php print("$fundo"); ?> style1" align="center">
<?
	if($not1[l_tipo_contrato]=='Comercial'){
       	$escolha = "11";
  	}else{
    	$escolha = "10";
	}
?>
<a href="#" onclick="NewWindow('p_imp_doc.php?imp=<?php print("$escolha"); ?>&cod=<?php print("$not1[l_imovel]"); ?>&l_cod=<?php print("$not1[l_cod]"); ?>', 'janela', 750, 500, 'yes');" class="style1">Imprimir</a></td>
<td class="<?php print("$fundo"); ?> style1" align="center">
<?php
if(verificaFuncao("USER_LIBERAR_ACESSO")){
?>
<!--a href="#" onClick="if (confirm('Deseja Realmente excluir a locação?')) { window.location='p_rel_loc.php?bot=Apagar&dia2=<?php print("$dia2"); ?>&mes2=<?php print("$mes2"); ?>&ano2=<?php print("$ano2"); ?>&dia3=<?php print("$dia3"); ?>&mes3=<?php print("$mes3"); ?>&ano3=<?php print("$ano3"); ?>&alterar=1&lista=1&l_cod=<?php print("$not1[l_cod]"); ?>&cod=<?php print("$not1[l_imovel]"); ?>'; }" class="style1">Apagar</a-->
<input type="button" value="Apagar" class="campo3" name="bot" onClick="javascript:confirmaExclusao(<?=$not1['l_cod'] ?>,'<?=$dia2 ?>','<?=$mes2 ?>','<?=$ano2 ?>','<?=$dia3 ?>','<?=$mes3 ?>','<?=$ano3 ?>','<?=$campo ?>','<?=$pusuarios ?>', '<?=$list ?>','<?=$lista ?>')">
<?php
	}
?>
</td>
</tr>
</form>
<?php
	}
	$total_geral = $total_total + $valor_total;
	$total_total = number_format($total_total, 2, ',', '.');
	$total_servico = number_format($valor_total, 2, ',', '.');
	$geral = number_format($total_geral, 2, ',', '.');
?>
<?php
if(verificaFuncao("RELAT_LOC_REL")){
?>
<tr>
<td colspan=3  align="left" class="fundoTabela style1">Valor:</td>
<td colspan=6 align="left" class="fundoTabela style1">R$ <?php print("$total_total"); ?></td>
</tr>
<tr>
<td colspan=3 align="left" class="fundoTabela style1"><b>Saldo Total:</b></td>
<td colspan=6 align="left" class="fundoTabela style1"><b>R$ <?php print("$geral"); ?></b></td>
</tr>
<?php
	}
?>
<?php
	}
	if($campo == "locado"){
	$query2 = "select count(l_imovel) as contador from locacao where $b_usuarios l_data_sai>='$ano2-$mes2-$dia2' AND 
	l_data_sai<='$ano3-$mes3-$dia3' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato!='' ";
	}else{
	$query2 = "select count(l_imovel) as contador from locacao where $b_usuarios l_data>='$ano2-$mes2-$dia2' AND 
	l_data<='$ano3-$mes3-$dia3' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_n_contrato!='' ";
	}
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
                  <tr class="fundoTabelaTitulo">
                  	<td colspan=9 class="style1"><p align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> períodos</b></td>
                  </tr>
<?php
	}
	}
?>
</table>
</td></tr></table>
</form>
<?php
mysql_close($con);
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