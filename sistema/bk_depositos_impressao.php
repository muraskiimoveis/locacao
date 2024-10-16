<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_DEPOSITOS");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
 <script type="text/javascript" src="funcoes/js.js"></script>
	<style media="print">
		.noprint { display: none }
	</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg"><div align="left">
<?
    $logo_imob = $_SESSION['logo_imob'];
    $caminho_logo = "../logos/";
	if (file_exists($caminho_logo.$logo_imob))
	{
?>	
	<img src="<?php print($caminho_logo.$logo_imob); ?>" border="0"></div></td>
<?
	}
?>
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
<table bgcolor="#<?php print("$cor1"); ?>" border="0" cellspacing="1" width=770>
<form method="post" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
<?php
  
 if($c_banco1=='%%'){
    $bancos = "Todos";
 }else{
    $bancos = $c_banco1;
 } 
 
 if($cobranca_status=='ok'){   
   $cobranca = "Já Depositado";
 }elseif($cobranca_status=='pendente'){
   $cobranca = "Pendente";
 }elseif($cobranca_status=='pend_rec'){
   $cobranca = "Pendente Recebido";
 }elseif($cobranca_status=='pend_nao'){
   $cobranca = "Pendente Não Recebido";
 }elseif($cobranca_status=='%%'){
   $cobranca = "Todos";
 }

?>
  <tr>
    <td bgcolor="#<?php print("$cor1"); ?>" colspan=7 class=style1 align="left"><b>Rela&ccedil;&atilde;o de dep&oacute;sitos do per&iacute;odo: </b><?php print("$dia2/$mes2/$ano2"); ?> &agrave; <?php print("$dia3/$mes3/$ano3"); ?></td>
  </tr>
   <tr>
      <td colspan="3" class=style1><b>Banco:</b> <? echo($bancos); ?></td>
        <td colspan="5" class=style1><b>Status:</b> <? echo($cobranca); ?> <? echo($co_cat); ?></td>
    </tr>
  <tr>
    <td colspan=7 height=20></td>
  </tr>
<?php 

	$queryi2= "update contas set co_impressao='0' where co_impressao='1' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
	$resulti2 = mysql_query($queryi2) or die("Não foi possível atualizar suas informações. $queryi2");
 
    $i2 = $_POST['i'];
	$c2 = 0;

	for($j2 = 1; $j2 <= $i2; $j2++)
	{	     
		$codigosi = "co_cod_".$j2;
     	$totali = $_POST[$codigosi];
		$botoesi = "impressao_".$j2;
		$bimpressao = $_POST[$botoesi];

  	 if($bimpressao=='1'){
    	$c++;
    	$queryi= "update contas set co_impressao='1' where co_cod='$totali' and  cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
		$resulti = mysql_query($queryi) or die("Não foi possível atualizar suas informações. $queryi");			
     } 
  	}
 
 
 
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
	$result4 = mysql_query($query4) or die("N&atilde;o foi poss&iacute;vel atualizar suas informa&ccedil;&otilde;es. $query4");	}
	*/
	
	// Pegar dados do im&oacute;vel, conta e propriet&aacute;rio
	//if($co_cat == "Pagar"){
	$query0 = "select m.cod, m.titulo, m.ref, c.c_cod, c.c_nome, c.c_banco, c.c_conta, co.co_cod, co.co_valor, co.co_data, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_tipo_user, u.u_nome, u.u_cod from clientes c, muraski m, (contas co) left join usuarios u on (co.co_cliente=u.u_cod) where co.co_imovel=m.cod and c.c_cod=co.co_cliente and (co.co_data>='$ano2-$mes2-$dia2' AND co.co_data<='$ano3-$mes3-$dia3') and c.c_banco like '$c_banco1' and co.co_tipo!='Despesas' and co.co_status like '$co_status' and co_cat='$co_cat' and (finalidade='1' OR finalidade='2' OR finalidade='3' OR finalidade='4' OR finalidade='5' OR finalidade='6' OR finalidade='7' OR finalidade='8' OR finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR finalidade='17') and co_impressao='1' and co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by c.c_banco, co.co_data, m.ref";	
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
	
	while($not0 = mysql_fetch_array($result0))
	{
	
	  
	$recebido = "n&atilde;o";
	
	if($co_cat == "Pagar"){
		//$co_cod2 = $not0[co_cod] - 1;
	$query2 = "select co_status	from clientes, muraski, (contas) left join usuarios on (co_cliente=u_cod) where 
	co_imovel=cod and c_cod=co_cliente and co_cod<'$not0[co_cod]' AND 
	co_imovel='$not0[cod]' and co_tipo!='Despesas' 
	and co_cat='Receber' and co_impressao='1' and contas.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'
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
	(($cobranca_status == "pend_nao") and ($recebido == "n&atilde;o")) or 
	($cobranca_status == "pendente") or 
	($cobranca_status == "ok") or ($cobranca_status == "%%")){  
	  

	$query1 = "select c_banco, count(c_banco) as qtd_banco from clientes, muraski, (contas) left join usuarios on (co_cliente=u_cod) where 
	co_imovel=cod and c_cod=co_cliente and (co_data>='$ano2-$mes2-$dia2' AND 
	co_data<='$ano3-$mes3-$dia3') and c_banco like '$not0[c_banco]' and (finalidade='1' OR finalidade='2' OR finalidade='3' OR finalidade='4' OR finalidade='5' OR finalidade='6' OR finalidade='7' OR finalidade='8' OR finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR finalidade='17') and co_impressao='1' and contas.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
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
				$titulo = $not0['titulo'];
				$tipo_user = $not0['co_tipo_user'];
				if($not0['co_tipo_user']=='A'){
				  	$cliente = $not0['u_nome'];
				}elseif($not0['co_tipo_user']=='V'){
					$cliente = $not0['u_nome'];
				}else{
				    $cliente = $not0['c_nome'];
				}
				$cliente = substr ($cliente, 0, 70);
				if(strlen($cliente) > 69){
					$cliente = $cliente . "...";
				}
				if($not0['co_tipo_user']=='A'){
				  	$c_cod = $not0['u_cod'];
				}elseif($not0['co_tipo_user']=='V'){
				  	$c_cod = $not0['u_cod'];
				}else{
				  	$c_cod = $not0['c_cod'];	
				} 
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
		        $data_status = $not0['data_status'];
		        
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
    <td colspan=7 class=style1><b>Total a depositar: </b>R$ <?php print("$total_tela"); ?></td>
  </tr>
  <tr>
    <td colspan=7 height=30></td>
  </tr>
  <?php
	$total = 0;
	}
?>
  <tr>
    <td colspan=7 height=10></td>
  </tr>
  <tr>
    <td colspan=7 class=style1><b>Banco: </b><?php print($c_banco); ?></td>
  </tr>
  <tr>
    <td colspan=7 height=10></td>
  </tr>
  <?php


 	}
		$i++;
?>
  <?php
		$total = $co_valor + $total;
?>
  <tr>
    <td width="33" align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><a href="p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar" target="_blank" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$data"); ?></b></a></td>
    <td width="93" align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Ref.: <a href="p_edit_imoveis.php?cod=<?php print("$cod"); ?>&edit=editar" target="_blank" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$ref"); ?></b></a></td>
    <td width="163" align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><?php if($tipo_user=='A'){ echo("Angariador"); }elseif($tipo_user=='V'){ echo("Vendedor"); }elseif($tipo_user=='I'){ echo("Indicador"); }else{ echo("Prop."); } ?>: <?php if($tipo_user=='A' || $tipo_user=='V'){ ?><a href="p_usuarios.php?edit_cod=<?php print("$c_cod"); ?>&lista=1" target="_blank" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><?php }else{ ?><a href="p_clientes.php?c_cod=<?php print("$c_cod"); ?>&lista=1" target="_blank" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><?php } ?><b><?php print("$cliente"); ?></b></a></td>
    <td width="89" align="right" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Valor: <b><span class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">R$</a></b></td>
    <td width="45" align="right" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><b><?php print("$valor_tela"); ?></b></td>
    <td width="102" align="right" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><span class="style1">
      <?php if($not0[co_status] == "ok"){ ?>
      <span class="style17"><?php print("$data_status"); ?></span>
      <input type="hidden" name="co_cod_<?=$i ?>" id="co_cod_<?=$i ?>" value="<?= $co_cod ?>">
      <?php }else{ ?>
      <?php print("$data_status"); ?>
      <input type="hidden" name="co_cod_<?=$i ?>" id="co_cod_<?=$i ?>" value="<?= $co_cod ?>">
      <?php } ?>
    </span></td>
    <td width="200" align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><?php

	if($not0[co_status] == "ok"){
?>
        <b>OK</b>
        <!--input type="submit" name="alterar_data_<?=$i ?>" id="alterar_data_<?=$i ?>" value="Alterar Data" class="campo3" onClick="formData()"-->
        <?php
	}
	else
	{
?>
        <!--a href="#" onClick="if (confirm('Deseja Realmente confirmar esta conta?')) { window.location='<? print("$PHP_SELF"); ?>?acao=Confirmar&co_cod=<?php print("$co_cod"); ?>&c_banco1=<?php print("$c_banco1"); ?>&co_status=<?php print("$co_status"); ?>&dia2=<?php print("$dia2"); ?>&mes2=<?php print("$mes2"); ?>&ano2=<?php print("$ano2"); ?>&dia3=<?php print("$dia3"); ?>&mes3=<?php print("$mes3"); ?>&ano3=<?php print("$ano3"); ?>'; }" class="style17">Ok</a-->
        <!--input type="submit" name="ok_<?=$i ?>" id="ok_<?=$i ?>" value="OK" class="campo3" onClick="formConta()"-->
        <?php
	}
?></td>
  </tr>
  <tr>
    <td colspan=6 align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>">Conta: <b><?php print("$c_conta"); ?></b></td>
    <td colspan=2 align="left" bgcolor="#<?php print("$cor1"); ?>" class="<?php if($not0[co_status] == "ok"){ echo "style17"; }else{ echo "style1"; } ?>"><?php if($co_cat == "Pagar"){ print("$recebido"); } ?>
        </b></td>
  </tr>
  <tr>
    <td colspan=7 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
  </tr>
  <tr>
    <td colspan=7 height=10></td>
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
  <tr>
    <td colspan=7 class=style1><b>Total a depositar: </b>R$ <?php print("$total_tela"); ?></td>
  </tr>
  <div class=noprint>	
	<tr>
	  <td colspan="7"><div align="center"><span class="style1">
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	  </span></div></td>
    </tr>
</div>
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
</td>
</tr>
</table>
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