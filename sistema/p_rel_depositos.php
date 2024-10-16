<?php
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_DEPOSITOS");
?>
<html>

<head>
<script>
<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode; 
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {d
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
include("style.php");
?>
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
include("funcoes/funcoes.php");
?>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin"))){
*/		
?>
<script language="javascript">
function formConta(){

	if(confirm("Deseja Realmente confirmar esta conta?")){

   	   document.form1.action = 'p_rel_depositos.php';
   	   document.form1.acao.value = 1;
   	   document.form1.target= '';
   	   document.form1.submit();
	}
}

function formData(){

	if(confirm("Deseja alterar a data novamente?")){

   	   document.form1.action = 'p_rel_depositos.php';
	   document.form1.acaod.value = 1;
	   document.form1.target= '';
	   document.form1.submit();
	}
}
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
	document.form1.dia.focus();
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
	$url = $REQUEST_URI;
	//echo $url;
	$url = explode("?", $url);
	//$url2 = explode("dia2", $url[1]);
	//$url = str_replace("&","-","$url");
	//$url = str_replace("?","|","$url");
?>
<div align="center">
  <center>
<table border="0" cellspacing="1" width="75%">
<?php

if($_POST['acao']=='1')
{

   		$i = $_POST['i'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$datas = "data_status_".$j;
     		$data_atual = formataDataParaBd($_POST[$datas]);
     		$codigos = "co_cod_".$j;
     		$total = $_POST[$codigos];
     		$botoes = "ok_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_status='ok', co_data_status='$data_atual', co_usuario_status='$u_cod' where co_cod='$total' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");			
    		} 	
		} 

}

if($_POST['acaod']=='1')
{

   		$i = $_POST['i'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$codigos = "co_cod_".$j;
     		$total = $_POST[$codigos];
     		$botoes = "alterar_data_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_status='pendente', co_usuario_status='$u_cod' where co_cod='$total' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");			
    		} 	
		} 

}
?>

<form method="post" action="" name="form1" id="form1">
<input type="hidden" name="acao" id="acao" value="0">
<input type="hidden" name="acaod" id="acaod" value="0">
<?php
/*
	if(($dia3 == "") or ($mes3 == "") or ($ano3 == "")){
	$dia3 = date(d);
	$mes3 = date(m);
	$ano3 = date(Y);
	}
	if(($dia2 == "") or ($mes2 == "") or ($ano2 == "")){
	$dia2 = date(d);
	$mes2 = date(m);
	$ano2 = date(Y);
	}
*/
?>
	<tr>
      <td height="50" colspan=10 class="style1" width="100%"><p align="center" style="padding-bottom: 10px;"><br><b>Relação de depósitos </b><br>
 Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar</p></td>
    </tr>
	<tr  class="fundoTabela">
		<td width="20%" class=style1><b>Período:</b> </td>
		<td width="80%" colspan=9 class=style1><input type="text" name="dia2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia2"); ?>">/
      		<input type="text" name="mes2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes2"); ?>">/
      		<input type="text" name="ano2" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano2"); ?>"> <b>à</b> 
      		<input type="text" name="dia3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia3"); ?>">/
      		<input type="text" name="mes3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes3"); ?>">/
      		<input type="text" name="ano3" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano3"); ?>"><br>Ex.: 10/10/1910 à 20/10/1910</td>
  </tr>
    <tr  class="fundoTabela">
      <td width="20%" class=style1><b>Banco:</b></td>
      <td width="80%" colspan=9 class=style1><select size="1" name="c_banco1" class="campo">
        <option selected value="%%" <? if($c_banco1=='%%'){ print "SELECTED"; } ?>>Todos</option>
<?php
            $bbancos = mysql_query("SELECT * FROM bancos WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY b_nome ASC");
 			while($linha = mysql_fetch_array($bbancos)){
				if($linha[b_nome]==$c_banco1){
					echo('<option value="'.$linha[b_nome].'" SELECTED>'.$linha[b_nome].'</option>');
				}else{ 			   
					echo('<option value="'.$linha[b_nome].'">'.$linha[b_nome].'</option>');
				}
 			}
?>
  </select></td>
    </tr>
    <tr  class="fundoTabela"r>
    	<td width="20%" class=style1><b>Status:</b></td>
        <td width="80%" colspan=9 class=style1>
        	<select size="1" name="cobranca_status" class="campo">
        		<option selected value="%%">Todos</option>
    			<option value="ok" <? if($cobranca_status=='ok'){ print "SELECTED";  } ?>>Já depositado</option>
    			<option value="pendente" <? if($cobranca_status=='pendente'){ print "SELECTED";  } ?>>Pendente</option>
-     			<option value="pend_rec" <? if($cobranca_status=='pendente_rec'){ print "SELECTED";  } ?>>Pendente recebido</option>
<!--   			<option value="pend_rec" <? //if($cobranca_status=='pend_rec'){ print "SELECTED";  } ?>>Pendente recebido</option> -->
    			<option value="pend_nao" <? if($cobranca_status=='pend_nao'){ print "SELECTED";  } ?>>Pendente não recebido</option>
  			</select>
  			<select size="1" name="co_cat" class="campo">
        		<option selected value="Pagar" <? if($co_cat=='Pagar'){ print "SELECTED";  } ?>>Pagar</option>
    			<option value="Receber" <? if($co_cat=='Receber'){ print "SELECTED";  } ?>>Receber</option>
  			</select>
  		</td>
    </tr>
<tr>
  <td colspan=10>
     <input type="hidden" id="acaop" name="acaop" value="0">
    <input type="button" value="Pesquisar" name="B1" class="campo3" onClick="form1.action='p_rel_depositos.php';form1.target='';form1.acaop.value='1';form1.submit();return valida();">
  </td>
</tr>
<? if($_POST['acaop']=='1'){ ?>    
<tr height="50">
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=10 class=style1 align="center"><b>Relação de depósitos do período: </b><?php print("$dia2/$mes2/$ano2"); ?> à <?php print("$dia3/$mes3/$ano3"); ?></td>
</tr>
<? } ?>
<?php
	if(($cobranca_status == "pend_rec") or ($cobranca_status == "pend_nao")){
		$co_status = "pendente";
	}
	else
	{
		$co_status = $cobranca_status;
	}
		
	
	if(!$from){
		$from = intval($screen * 10);
	}	
	
	/*
	if($acao == "Confirmar"){
	$data_status = formataDataParaBd($data_status);
	echo '**'.$data_status;
	$query4= "update contas set co_status='ok', co_data_status='$data_status', co_usuario_status='$valid_user' where co_cod='$co_cod'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	}
	*/
	
	// Pegar dados do imóvel, conta e proprietário
	//if($co_cat == "Pagar"){
	$query0 = "select m.cod, m.titulo, m.ref, c.c_cod, c.c_nome, c.c_tel, c.c_cel, c.c_email, c.c_tel2, c.c_cel2, c.c_email_com, c.c_banco, c.c_conta, co.co_cod, co.co_valor, co.co_data, co.co_status, co.co_imovel, co.co_cliente, co.co_usuario, co.co_locacao, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status from clientes c, muraski m, contas co where co.co_imovel=m.cod and c.c_cod=co.co_cliente and (co.co_data>='$ano2-$mes2-$dia2' AND co.co_data<='$ano3-$mes3-$dia3') and c.c_banco like '$c_banco1' and co.co_tipo!='Despesas' and co.co_status like '$co_status' and co_cat='$co_cat' and (finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR finalidade='17') and co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.c_banco, co.co_data, m.ref";
	/*}elseif($co_cat == "Pagar"){
	$query0 = "select cod, titulo, ref, c_cod, c_nome, c_banco, c_conta, co_cod, co_valor, co_data, co_status 
	from clientes, muraski, contas where 
	co_imovel=cod and c_cod=co_cliente and (co_data>='$ano2-$mes2-$dia2' AND 
	co_data<='$ano3-$mes3-$dia3') and c_banco like '$c_banco1' and co_tipo!='Despesas' 
	and co_status like '$co_status' and co_cat='$co_cat' 
	order by c_banco, co_data, ref";
	}*/
	//echo $query0;
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	
	$i = 0;
	$k= 0;
	while($not0 = mysql_fetch_array($result0))
	{
	
	if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$k++;
	
	$recebido = "não";

    //echo "-R$-".$not0[co_valor]."--".$not0[co_status];
	
	if($co_cat == "Pagar"){
		//$co_cod2 = $not0[co_cod] - 1;
	$query2 = "select co_status	from clientes, muraski, contas where 
	co_imovel=cod and c_cod=co_cliente and co_cod<'$not0[co_cod]' AND 
	co_imovel='$not0[cod]' and co_tipo!='Despesas' 
	and co_cat='Receber' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	order by co_cod desc limit 1";
	//echo $query2;
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0)
	{
	while($not2 = mysql_fetch_array($result2))
	{
		if($not2[co_status] == "ok"){
		$recebido = "<b>rec.</b>";
		}
		//echo $recebido;
	}
	}
	}
	
	if((($cobranca_status == "pend_rec") and ($recebido == "<b>rec.</b>")) or 
	(($cobranca_status == "pend_nao") and ($recebido == "não")) or 
	($cobranca_status == "pendente") or 
	($cobranca_status == "ok") or ($cobranca_status == "%%")){  
	  

	$query1 = "select c_banco, count(c_banco) as qtd_banco from clientes, muraski, contas where 
	co_imovel=cod and c_cod=co_cliente and (co_data>='$ano2-$mes2-$dia2' AND 
	co_data<='$ano3-$mes3-$dia3') and c_banco like '$not0[c_banco]' and (finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR finalidade='17') and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	group by c_banco order by c_banco";
		
	$result1 = mysql_query($query1);
	while($not1 = mysql_fetch_array($result1))
	{
		$qtd_banco = $not1[1];
		//echo $qtd_banco;
	}
		
				$cod = $not0['cod'];
				$co_cod = $not0['co_cod'];
				$ref = $not0['ref'];
				$titulo = strip_tags($not0['titulo']);


             	//REALIZA BUSCA DO PERIODO DA LOCACAO
                $codloca = $not0['co_locacao'];
            	$qry_loca = "select  * from locacao where l_cod='$codloca' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
             	$res_loca = mysql_query($qry_loca);
             	while($not_loca = mysql_fetch_array($res_loca))
            	{
					$ano_loca_ent = substr ($not_loca['l_data_ent'], 0, 4);
					$mes_loca_ent = substr($not_loca['l_data_ent'], 5, 2 );
					$dia_loca_ent = substr ($not_loca['l_data_ent'], 8, 2 );
					$data_loca_ent = "$dia_loca_ent/$mes_loca_ent/$ano_loca_ent";
					$ano_loca_sai= substr ($not_loca['l_data_sai'], 0, 4);
					$mes_loca_sai = substr($not_loca['l_data_sai'], 5, 2 );
					$dia_loca_sai = substr ($not_loca['l_data_sai'], 8, 2 );
					$data_loca_sai = "$dia_loca_sai/$mes_loca_sai/$ano_loca_sai";


					//REALIZA BUSCA DO NOME DO INQUILINO
					//$codinquilino = $not0['co_cliente'];
					$codinquilino = $not_loca['l_cliente'];
					$qry_inquilino = "select c_nome, c_tel, c_cel, c_email, c_tel2, c_cel2, c_email_com from clientes where c_cod='$codinquilino' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$res_inquilino = mysql_query($qry_inquilino);
					while($not_inquilino = mysql_fetch_array($res_inquilino))
					{
					   $nomeinquilino = $not_inquilino['c_nome'];
					   $fone = $not_inquilino['c_tel'];
					   $cel = $not_inquilino['c_cel'];
					   $email = $not_inquilino['c_email'];
					   $fone2 = $not_inquilino['c_tel2'];
					   $cel2 = $not_inquilino['c_cel2'];
					   $email2 = $not_inquilino['c_email_com'];
					}

				}
 
				
              	//REALIZA BUSCA DO NOME DO PROPRIETARIO
                $codimovel = $not0['co_imovel'];
            	$qry_imovel = "select cliente from muraski where cod='$codimovel' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
             	$res_imovel = mysql_query($qry_imovel);
             	while($not_imovel = mysql_fetch_array($res_imovel))
            	{
            	   $codprop1 = explode("--", $not_imovel['cliente']);
	               $codprop2 = str_replace("-","",$codprop1[0]);
                }
            	$qry_prop = "select c_nome, c_tel, c_cel, c_email, c_tel2, c_cel2, c_email_com from clientes where c_cod='$codprop2' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
             	$res_prop = mysql_query($qry_prop);
             	while($not_prop = mysql_fetch_array($res_prop))
            	{
                    $nomeprop = $not_prop['c_nome'];
                }
				$nomeprop = substr ($nomeprop, 0, 70);
				if(strlen($nomeprop) > 69){
					$nomeprop = $nomeprop . "...";
				}

				
 
 
				// Aki procurar nome do usuario
				//
				$cod_usuario = $not0['co_usuario'];
				$qry_usuario  = "select u_nome from usuarios where u_cod = ".$cod_usuario;
				$res_usuario = mysql_query($qry_usuario) or die(mysql_error());
				$row_usuario =  mysql_fetch_array($res_usuario);
				$nome_usuario = $row_usuario['u_nome'];
				//
				$c_cod = $not0['c_cod'];
				$c_banco = $not0['c_banco'];
				$c_conta = $not0['c_conta'];
				$c_conta = substr ($c_conta, 0, 70);
				if(strlen($c_conta) > 69){
					$c_conta = $c_conta . "...";
				}
				$co_valor = $not0['co_valor'];
				$co_valor = str_replace("-","","$co_valor");
				$ano = substr ($not0['co_data'], 0, 4);
		        $mes = substr($not0['co_data'], 5, 2 );
		        $dia = substr ($not0['co_data'], 8, 2 );
		        $data = "$dia/$mes/$ano";
		        $valor_tela = number_format($co_valor, 2, ',', '.');
		        $valor_tela = str_replace("-","","$valor_tela");

                if(($cobranca_status == "pend_rec") and ($co_cat=='Pagar')){
   		          $data_dodia = formataDataParaBd(date('d/m/Y'));
				  $ano_dodia = substr ($data_dodia, 0, 4);
		          $mes_dodia = substr($data_dodia, 5, 2 );
		          $dia_dodia = substr ($data_dodia, 8, 2 );
		          $data_status = "$dia_dodia/$mes_dodia/$ano_dodia";
				}else{$data_status = $not0['data_status'];}
				
	//}
?>
<?php
	if($banco <> $c_banco){
		$banco = $c_banco;
		$total_geral = $total_geral + $total;
?>
<?php
	if($i > 0){
	$total_tela = number_format($total, 2, ',', '.');
	$total_tela = str_replace("-","","$total_tela");
?>
<tr>
	<td colspan=10 class=style1><b>Total a depositar: </b>R$ <?php print("$total_tela"); ?></td>
</tr>
<?php
	$total = 0;
	}
?>
<tr height="50">
	<td colspan=10 class=style1><p align="center"><b>Banco: </b><?php print("$c_banco"); ?></p></td>
</tr>
<?php


 	}
		$i++;
		
?>
<?php
		$total = $co_valor + $total;
?>
<tr>
	<td colspan="10">
		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="text-align:left;">
<?php
if(($cobranca_status == "pend_nao") and ($co_cat=='Receber')){
?>
        <tr>
		<td colspan=3 align="left" >Usuario : <b><?php echo $nome_usuario ?> </b></td>
		</tr>
<?
}
?>
		<tr class="<?php print("$fundo"); ?>">
<td height="20px" width="5%" align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><input type="checkbox" name="impressao_<?=$i ?>" id="impressao_<?=$i ?>" value="1"></td>
<td height="20px" width="15%" align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><a href="p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$data"); ?></b></a></td>
<td height="20px" width="15%" align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Ref.: <a href="p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$ref"); ?></b></a></td>
<td height="20px" align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Prop.: <a href="p_clientes.php?c_cod=<?php print("$c_cod"); ?>&lista=1" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$nomeprop"); ?></b></a></td>
<td height="20px" width="15%" align="right" style="text-align:left;" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Valor: <b><span class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">R$&nbsp;&nbsp;<?php print("$valor_tela"); ?></b></td>
<td height="20px" width="10%" align="right" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><span class="style1">
<?php if($not0[co_status] == "ok"){ ?>
<span class="style17"><?php print("$data_status"); ?></span>
<input type="hidden" name="co_cod_<?=$i ?>" id="co_cod_<?=$i ?>" value="<?= $co_cod ?>">
<?php }else{ ?>
<input type="text" name="data_status_<?=$i ?>" id="data_status_<?=$i ?>" size="12" maxlenght="10" class="campo"  value="<?php print("$data_status"); ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_status_<?=$i ?>', '##/##/####', event);">
<input type="hidden" name="co_cod_<?=$i ?>" id="co_cod_<?=$i ?>" value="<?= $co_cod ?>">
<?php } ?>
</span></td>
<td height="20px" width="5%" align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">
<?php

	if($not0[co_status] == "ok"){
?>
<b>OK</b>
<input type="submit" name="alterar_data_<?=$i ?>" id="alterar_data_<?=$i ?>" value="Alterar Data" class="campo3" onClick="formData()">
<?php
	}
	else
	{
?>
<!--a href="#" onClick="if (confirm('Deseja Realmente confirmar esta conta?')) { window.location='<? print("$PHP_SELF"); ?>?acao=Confirmar&co_cod=<?php print("$co_cod"); ?>&c_banco1=<?php print("$c_banco1"); ?>&co_status=<?php print("$co_status"); ?>&dia2=<?php print("$dia2"); ?>&mes2=<?php print("$mes2"); ?>&ano2=<?php print("$ano2"); ?>&dia3=<?php print("$dia3"); ?>&mes3=<?php print("$mes3"); ?>&ano3=<?php print("$ano3"); ?>'; }" class="style17">Ok</a-->
<input type="submit" name="ok_<?=$i ?>" id="ok_<?=$i ?>" value="OK" class="campo3" onClick="formConta()">
<?php
	}
?></td>
</tr>
<tr class="<?php print("$fundo"); ?>">
<td height="20px" colspan=3 align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Conta: <b><?php print("$c_conta"); ?></b></td>
<td height="20px" colspan=5 align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Recebido: <?php if($co_cat == "Pagar"){ print("$recebido"); } ?>  </b></td>
</tr>

<?php
if(($cobranca_status == "pend_rec") and ($co_cat=='Pagar')){
?>
<!-- Aki informações da LOCACAO -->
<tr class="<?php print("$fundo"); ?>">
<td height="20px" colspan=3 align="left" align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Inquilino :<b> <?php echo $nomeinquilino ?> </b></td>
<td height="20px" colspan=3 align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Periodo Locacao : <b><?php echo $data_loca_ent ."  até  ".$data_loca_sai  ?> </b></td>
<tr>
<?php
}
?>
<!-- Aki outras informações -->
<?php
if(($cobranca_status == "pend_nao") and ($co_cat=='Receber')){
?>
<tr class="<?php print("$fundo"); ?>">
<td height="20px" colspan=3 align="left" align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Inquilino :<b> <?php echo $nomeinquilino ?> </b></td>
<td height="20px" colspan=3 align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Fones : <b><?php echo $fone." - ".$fone2 ?> </b></td>
<td height="20px" width="25%" align="left" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Emails : <b><?php echo $email." - ".$email2 ?> </b></td>
</tr>
<?php
}
?>
</table>
	</td>
</tr>
<?php
    }
	}//while0
?>
<?php
	if($i > 0){
	$total_geral = $total_geral + $total;  
	$total_tela = number_format($total, 2, ',', '.');
	$total_tela = str_replace("-","","$total_tela");
?>
<input name="i" id="i" type="hidden" class="campo" value="<?= $i ?>">
<tr>
	<td colspan=8 class=style1><b>Total a depositar: </b>R$ <?php print("$total_tela"); ?></td>
</tr>
<tr>
	<td colspan=8 height=30>
	  <input type="button" value="Visualizar" name="visualizar" id="visualizar" class="campo3" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='depositos_impressao.php';form1.submit();">
	  </td>
</tr>
<?php
	$total = 0;
	$i = 0;
	}
	$total_geral_tela = number_format($total_geral, 2, ',', '.');
	$total_geral_tela = str_replace("-","","$total_geral_tela");
?>
<!--tr>
	<td colspan=8 class=style1 bgcolor="#<?php print("$cor6"); ?>"><b>Total geral a depositar: R$ <?php print("$total_geral_tela"); ?></b></td>
</tr-->
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
</form>
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
