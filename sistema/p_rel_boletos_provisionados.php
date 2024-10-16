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
<script language="javascript">
function formConta(){

	if(confirm("Deseja Realmente confirmar esta conta?")){

   	   document.form1.action = 'p_rel_boletos_conciliados.php';
   	   document.form1.acao.value = 1;
   	   document.form1.target= '';
   	   document.form1.submit();
	}
}

function formData(){

	if(confirm("Deseja alterar a data novamente?")){

   	   document.form1.action = 'p_rel_boletos_conciliados.php';
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
    document.form1.dia3.value = document.form1.dia2.value;
    //alert("Por favor, digite o Dia de Saída");
    //document.form1.dia3.focus();
    //return (false);
  }
  if (document.form1.mes3.value == "")
  {
    document.form1.mes3.value = document.form1.mes2.value;
    //alert("Por favor, digite o Mês de Saída");
    //document.form1.mes3.focus();
    //return (false);
  }
  if (document.form1.ano3.value == "")
  {
    document.form1.ano3.value = document.form1.ano2.value;
    //alert("Por favor, digite o Ano de Saída");
    //document.form1.ano3.focus();
    //return (false);
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
</script>
<?php
	$url = $REQUEST_URI;
	$url = explode("?", $url);
      $dia_de_hoje = date("d-m-Y");
      $dia2 = substr($dia_de_hoje,0,2);
      $mes2 = substr($dia_de_hoje,3,2);
      $ano2 = substr($dia_de_hoje,6,4);
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
	<tr>
      <td height="50" colspan=10 class="style1" width="100%"><p align="center" style="padding-bottom: 10px;"><br><b>Relação de Boletos Provisionados </b><br>
 Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar</p></td>
    </tr>
	<tr  class="fundoTabela">
		<td width="20%" class=style1><b>Período:</b> </td>
		<td width="80%" colspan=9 class=style1><input type="text" name="dia2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia2"); ?> " readonly>/
      		<input type="text" name="mes2" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes2"); ?>"readonly>/
      		<input type="text" name="ano2" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano2"); ?>"readonly> <b>à</b>
      		<input type="text" name="dia3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia3"); ?>">/
      		<input type="text" name="mes3" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes3"); ?>">/
      		<input type="text" name="ano3" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano3"); ?>"><br>Ex.: 10/10/1910 à 20/10/1910</td>
  </tr>
<tr>
  <td colspan=10>
     <input type="hidden" id="acaop" name="acaop" value="0">
    <input type="button" value="Pesquisar" name="B1" class="campo3" onClick="form1.action='p_rel_boletos_provisionados.php';form1.target='';form1.acaop.value='1';form1.submit();return valida();">
  </td>
</tr>
<?php   if($_POST['acaop']=='1')
             {
        if(empty($dia3)){$dia3 = $dia2;}
        if(empty($mes3)){$mes3 = $mes2;}
        if(empty($ano3)){$ano3 = $ano2;}
        ?>
<tr height="50">
	<td bgcolor="#<?php print("$cor1"); ?>" colspan=10 class=style1 align="center"><b>Boletos Provisionados no período: </b><?php print("$dia2/$mes2/$ano2"); ?> à <?php print("$dia3/$mes3/$ano3"); ?></td>
</tr>
<tr height="50">
    <td colspan=10 class=style1><p align="center"><b>Banco: </b> Caixa Economica Federal</p></td>
</tr>


<?php   } ?>
<?php

	$co_cat = "Receber";
	$cobranca_status = "pendente";
	//$concilia = "S";
        if(empty($dia3)){$dia3 = $dia2;}
        if(empty($mes3)){$mes3 = $mes2;}
        if(empty($ano3)){$ano3 = $ano2;}

//	$query0 = "select m.cod, m.titulo, m.ref, c.c_cod, c.c_nome, c.c_tel, c.c_cel, c.c_email, c.c_tel2, c.c_cel2, c.c_email_com, c.c_banco, c.c_conta, co.co_cod, co.co_valor, co.co_data, co.co_status, co.co_imovel, co.co_cliente, co.co_usuario, co.co_locacao, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status from clientes c, muraski m, contas co where co.co_imovel=m.cod and c.c_cod=co.co_cliente and (co.co_data>='$ano2-$mes2-$dia2' AND co.co_data<='$ano3-$mes3-$dia3') and c.c_banco like '$c_banco1' and co.co_tipo!='Despesas' and co.co_status like '$co_status' and co_cat='$co_cat' and (finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR finalidade='17') and co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.c_banco, co.co_data, m.ref";

	$query0  = "select m.cod, m.titulo, m.ref, c.c_cod, c.c_nome, c.c_tel, c.c_cel, c.c_email,";
	$query0 .= " c.c_tel2, c.c_cel2, c.c_email_com, c.c_banco, c.c_conta, co.co_cod, co.co_valor, co.co_forma,";
	$query0 .= " co.co_data, co.co_status, co.co_imovel, co.co_cliente, co.co_usuario, co.co_conciliado, co.co_boleto,";
	$query0 .= " co.co_locacao, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status ";
	$query0 .= "from clientes c, muraski m, contas co where co.co_imovel=m.cod and ";
	$query0 .= "c.c_cod=co.co_cliente and (co.co_data_status>='$ano2-$mes2-$dia2' AND ";
	//$query0 .= "co.co_data<='$ano3-$mes3-$dia3') and co_forma='Boleto' and co_conciliado = '$concilia' and ";
      $query0 .= "co.co_data_status<='$ano3-$mes3-$dia3') and co_forma='Boleto' and ";
	$query0 .= "co.co_tipo!='Despesas' and co_status ='$cobranca_status' and  co.co_conciliado = 'S' and ";
	$query0 .= "co_cat='$co_cat' and (finalidade='9' OR finalidade='10' OR finalidade='11' OR ";
	$query0 .= "finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR ";
	$query0 .= "finalidade='16' OR finalidade='17') and co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$query0 .= " order by co.co_data, m.ref";

	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);

	$i = 0;
	$k= 0;
	while($not0 = mysql_fetch_array($result0))
	{



                    if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
                    $k++;

                    $recebido = "não";

                    if($cobranca_status == "pendente")
                    {

                        $query1  = "select c_banco, count(c_banco) as qtd_banco from clientes, muraski, contas ";
                        $query1 .= " where co_imovel=cod and c_cod=co_cliente and (co_data_status>='$ano2-$mes2-$dia2' AND ";
                        $query1 .= " co_data_status<='$ano3-$mes3-$dia3') and co.co_conciliado = 'S' and c_banco like '$not0[c_banco]' and ";
                        $query1 .= " (finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR ";
                        $query1 .= " finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR ";
                        $query1 .= " finalidade='17') and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ";
                        $query1 .= " group by c_banco order by c_banco";

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
		      $codinquilino = $not0['co_cliente'];
		      //$codinquilino = $not_loca['l_cliente'];
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
	           if(strlen($nomeprop) > 69)
                        {
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
	           if(strlen($c_conta) > 69)
                        {
	               $c_conta = $c_conta . "...";
	           }
                        $co_valor = $not0['co_valor'];
	           $co_valor = str_replace("-","","$co_valor");
	           $ano = substr ($not0['co_data'], 0, 4);
	           $mes = substr($not0['co_data'], 5, 2 );
	           $dia = substr ($not0['co_data'], 8, 2 );
	           $data = "$dia/$mes/$ano";
                 $ano_s = substr ($not0['co_data_status'], 0, 4);
                 $mes_s = substr($not0['co_data_status'], 5, 2 );
                 $dia_s = substr ($not0['co_data_status'], 8, 2 );
                 $data_s = "$dia_s/$mes_s/$ano_s";
	           $valor_tela = number_format($co_valor, 2, ',', '.');
	           $valor_tela = str_replace("-","","$valor_tela");

	           $num_boleto = $not0['co_boleto'];
	           $qry_boleto  = "select * from boleto where nrdoc = '".$num_boleto."'";
	           $res_boleto = mysql_query($qry_boleto) or die(mysql_error());
	           $row_boleto =  mysql_fetch_array($res_boleto);
	           $bol_demo1 = $row_boleto['demo1'];
                        $bol_demo2 = $row_boleto['demo2'];
	           $bol_sacado = $row_boleto['sacado'];
                        if($banco <> $c_banco)
                        {
	               $banco = $c_banco;
	               $total_geral = $total_geral + $total;
                        }
                        if($i > 0)
                        {
                            $total_tela = number_format($total, 2, ',', '.');
                            $total_tela = str_replace("-","","$total_tela");
                            $total = 0;
                        }
?>
<?php
                        $i++;
                        $total = $co_valor + $total;
?>
<tr>
	<td colspan=10>
	<table width="100%" cellpadding="0" cellspacing="2" border="0" style="text-align:left;">
<tr>
	<td colspan=3 align="left" >Usuario : <b><?php echo $nome_usuario ?> </b></td>
</tr>
<tr class="<?php print("$fundo"); ?>">
<td height="20px" width="10%" align="left" class="style1"> Ref.: <a href="p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar" class="style1"><b><?php print("$ref"); ?></b></a></td>
<td height="20px" width="35%" align="left"> Prop.: <a class="style1"><b><?php print("$nomeprop"); ?></b></a></td>
<td height="20px" width="15%" align="left" class="style1"><b><?php print("Boleto "."$num_boleto");?></b></td>
<td height="20px" width="8%" align="left" class="style1"><a class="style1"><b><?php print("$data_s"); ?></b></a></td>
<td height="20px" width="8%" align="left" class="style1"><a class="style1"><b><?php print("$data"); ?></b></a></td>
<td height="20px" width="15%" align="left" class="style1">Valor: <b><span class="style1">R$&nbsp;&nbsp;<?php print("$valor_tela"); ?></b></td>
<td bgcolor="<?php if($not0[co_conciliado] == "S"){ print("#0E680E"); }else {print("#FF0000"); }?>" height="20px" width="10%"  align="middle" style="font-family: Verdana,Arial, Helvetica, sans-serif; font-size: 10px;color: #FFFFFF"><?php if($not0[co_conciliado] == "S"){ ?><b>Provisionado</b><?php } else { ?><b>Em Aberto</b><?php } ?></td>
</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="text-align:left;">

<tr class="<?php print("$fundo"); ?>">
<td height="20px"  width="50%" align="left" class="style1"><b><?php print("$bol_demo1"); ?></b></td>
<td height="20px"  width="50%" align="left" class="style1"><b><?php print("$bol_demo2"); ?></b></td>
</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="text-align:left;">

<tr class="<?php print("$fundo"); ?>">
<td height="20px"  width="40%" align="left" class="style1">Inquilino :<b> <?php echo $nomeinquilino ?> </b></td>
<td height="20px"  width="30%" align="left" class="style1">Fones : <b><?php echo $fone." - ".$fone2 ?> </b></td>
<td height="20px"  width="30%" align="left" class="style1">Emails : <b><?php echo $email." - ".$email2 ?> </b></td>
<tr>
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
<!--
<input name="i" id="i" type="hidden" class="campo" value="<?= $i ?>">
<tr>
	<td colspan=8 class=style1><b>Total a depositar: </b>R$ <?php print("$total_tela"); ?></td>
</tr>
-->
<?php
	$total = 0;
	$i = 0;
	}
	$total_geral_tela = number_format($total_geral, 2, ',', '.');
	$total_geral_tela = str_replace("-","","$total_geral_tela");
?>
</table>
</td></tr></table>
<?php
mysql_close($con);
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
