<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
ob_start();
if($_GET['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("REL_CLIENTES");
verificaArea("CLIENT_GERAL");

$popup = $_GET['popup'];

//troca para minúscula
	function trocaini2($wStr,$w1,$w2) {
        $wde = 0;
        $para=0;
    	while($para<1){
        	$wpos = strpos($wStr, $w1, $wde);
        	if ($wpos > 0)
			{
            	$wStr = str_replace($w1, $w2, $wStr);
            	$wde = $wpos+1;
        	}
			else
			{
            	$para=2;
        	}
    	} //while
    		$trocou = $wStr;
    		return $trocou;
	}//function trocaini	

	//Deixa tudo maiuscula
	function alta($umtexto) {
   		$troca = strtoupper($umtexto);
   		$troca = trocaini2($troca, "ã", "Ã");
   		$troca = trocaini2($troca, "á", "Á");
   		$troca = trocaini2($troca, "à", "À");
   		$troca = trocaini2($troca, "â", "Â");
   		$troca = trocaini2($troca, "ç", "Ç");
   		$troca = trocaini2($troca, "ó", "Ó");
   		$troca = trocaini2($troca, "ò", "Ò");
   		$troca = trocaini2($troca, "õ", "Õ");
   		$troca = trocaini2($troca, "ô", "Ô");
   		$troca = trocaini2($troca, "é", "É");
   		$troca = trocaini2($troca, "ê", "Ê");
   		$troca = trocaini2($troca, "è", "È");
   		$troca = trocaini2($troca, "í", "Í");
   		$troca = trocaini2($troca, "ì", "Ì");
   		$troca = trocaini2($troca, "î", "Î");
   		$troca = trocaini2($troca, "ú", "Ú");
   		$troca = trocaini2($troca, "û", "Û");
   		$troca = trocaini2($troca, "ù", "Ù");
   		$alta = $troca;
   	return $alta;
	}	

if($_GET['pdf']<>'1'){ 
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
	<style media="print">
		.noprint { display: none }
	</style>
</head>

<body>
<? 

} 

$id = $_GET['id'];

	  
	$busca = mysql_query("SELECT * FROM ficha_inquilinos WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $con_ref_inquilino = $linha['con_ref_inquilino'];
       $ap_inquilino = $linha['ap_inquilino'];
	   $prop_inquilino = $linha['prop_inquilino'];
 	   $resp_inquilino = $linha['resp_inquilino'];
	   $fone_inquilino = $linha['fone_inquilino'];
	   $rg_inquilino = $linha['rg_inquilino'];
	   $cpf_inquilino = formataCPFDoBd($linha['cpf_inquilino']);
	   $data_nasc_inquilino = formataDataDoBd($linha['data_nasc_inquilino']);
	   $cidade_inquilino = $linha['cidade_inquilino'];
	   $estado_inquilino = $linha['estado_inquilino'];
	   $entrada_inquilino = formataDataDoBd($linha['entrada_inquilino']);
	   $saida_inquilino = formataDataDoBd($linha['saida_inquilino']);
	   $data_exp = explode("-", $linha['data_inquilino']);
	   $nova_data = $data_exp[2] . "/" . $data_exp[1] . "/" . $data_exp[0];
	   $dia = $data_exp[2];
	   $mes = NomeMes($data_exp[1]);
	   $ano = $data_exp[0];

	} 

if($_GET['pdf']=='1'){

$id = $_GET['id'];

	  
	$busca = mysql_query("SELECT * FROM ficha_inquilinos WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $con_ref_inquilino = $linha['con_ref_inquilino'];
       $ap_inquilino = $linha['ap_inquilino'];
	   $prop_inquilino = $linha['prop_inquilino'];
 	   $resp_inquilino = $linha['resp_inquilino'];
	   $fone_inquilino = $linha['fone_inquilino'];
	   $rg_inquilino = $linha['rg_inquilino'];
	   $cpf_inquilino = formataCPFDoBd($linha['cpf_inquilino']);
	   $data_nasc_inquilino = formataDataDoBd($linha['data_nasc_inquilino']);
	   $cidade_inquilino = $linha['cidade_inquilino'];
	   $estado_inquilino = $linha['estado_inquilino'];
	   $entrada_inquilino = formataDataDoBd($linha['entrada_inquilino']);
	   $saida_inquilino = formataDataDoBd($linha['saida_inquilino']);
	   $data_exp = explode("-", $linha['data_inquilino']);
	   $nova_data = $data_exp[2] . "/" . $data_exp[1] . "/" . $data_exp[0];
	   $dia = $data_exp[2];
	   $mes = NomeMes($data_exp[1]);
	   $ano = $data_exp[0];

	} 

  
$html .='<page><table width="538" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
    	<td style="text-align:left;">';

			$logo_imob = $_SESSION['logo_imob'];
			$caminho_logo = "../logos/";
			if (file_exists($caminho_logo.$logo_imob))
			{
				$html .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
			}

	$html .='
		</td>
  	</tr>
    <tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
      <td width="534" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>Ficha de registro de inquilinos </b></td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Condom&iacute;nio do  Edif&iacute;cio/refer&ecirc;ncia: <b>'.alta($con_ref_inquilino).'</b></td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Ap.: <b>'.alta($ap_inquilino).'</b> Propriet&aacute;rio(s): <b>'.strtoupper($prop_inquilino).'</b></td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Respons&aacute;vel: <b>'.alta($resp_inquilino).'</b> Tel.: <b>'.alta($fone_inquilino).'</b></td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">RG: <b>'.alta($rg_inquilino).'</b> CPF: <b>'.alta($cpf_inquilino).'</b> Data Nasc.: <b>'.alta($data_nasc_inquilino).'</b></td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Cidade/Estado:  <b>'.alta($cidade_inquilino).'</b> / <b>'.alta($estado_inquilino).'</b></td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Entrada: <b>'.alta($entrada_inquilino).'</b> Sa&iacute;da: <b>'.alta($saida_inquilino).'</b></td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Ve&iacute;culos</td>
    </tr>';
    
	$busca3 = mysql_query("SELECT * FROM veiculos_inquilino WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    $j = 1;
	while($linha3 = mysql_fetch_array($busca3)){
    	$html .='
    		<tr>
      			<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>'.$j.'°</b> Ve&iacute;culo: <b>'.alta($linha3['veiculo_inquilino']).'</b> Cor: <b>'.alta($linha3['cor_inquilino']).'</b> Placa: <b>'.alta($linha3['placa_inquilino']).'</b> Cidade: <b>'.alta($linha3['cidade_veiculo_inquilino']).'</b></td>
    		</tr>
    	';
    $j++;
    }
    
    $html .='<tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    </tr>
	<tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Acompanhantes</td>
    </tr>';
    
	$busca2 = mysql_query("SELECT * FROM acompanhantes_inquilino WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    $i = 1;
	while($linha2 = mysql_fetch_array($busca2)){
    	$html .='
    		<tr>
      			<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>'.$i.'°</b> Nome: <b>'.alta($linha2['nome_acompanhante']).'</b> Idade: <b>'.alta($linha2['idade_acompanhante']).'</b></td>
    		</tr>
    	';
    $i++;
    }

$html .='<tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:justify">Declaro ter recebido o preenchimento desta  ficha, uma c&oacute;pia do regulamento do Condom&iacute;nio do Edif&iacute;cio  <b>'.alta($con_ref_inquilino).'</b> 
        como também ter sido recomendado quanto à ordem interna e do uso correto das vagas de estacionamento, estando de total acordo e obrigando - me a cumprí - lo.</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:right;">'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].'  '.alta($dia).' de '.alta($mes).' de '.alta($ano).'</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">____________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ____________________________</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Respons&aacute;vel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrador</td>
    </tr>
    <tr>
		<td>&nbsp;</td>
	</tr>
    <tr>
    	<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />www.redebrasileiradeimoveis.com.br</td>
    </tr>
	</table></page>';

echo $html;

	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	$pdf = new HTML2PDF('P','A4','fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();
  
}
  
?>
<? if($_GET['pdf']<>'1'){ ?>
<form id="form1" name="form1" method="post" action="ficha_inquilinos.php">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
    	<td style="style">
<?
			$logo_imob = $_SESSION['logo_imob'];
			$caminho_logo = "../logos/";
			if (file_exists($caminho_logo.$logo_imob))
			{
?>			  
				<img src="<?=$caminho_logo.$logo_imob ?>" border="0">
<?				
			}
?>
		</td>
  	</tr>
  	<tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Ficha de registro de inquilinos </b></div></td>
    </tr>
    <tr>
      <td colspan="2" class="style">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style"><p>Condom&iacute;nio do  Edif&iacute;cio/refer&ecirc;ncia: <b><?=alta($con_ref_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style"><p>Ap.: <b><?=alta($ap_inquilino); ?></b> Propriet&aacute;rio(s): <b><?=alta($prop_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style"><p>Respons&aacute;vel: <b><?=alta($resp_inquilino); ?></b> Tel.: <b><?=alta($fone_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style"><p>RG: <b><?=alta($rg_inquilino); ?></b> CPF: <b><?=alta($cpf_inquilino); ?></b> Data Nasc.: <b><?=alta($data_nasc_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style"><p>Cidade/Estado:  <b><?=alta($cidade_inquilino); ?></b> / <b><?=alta($estado_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style"><p>Entrada: <b><?=alta($entrada_inquilino); ?></b> Sa&iacute;da: <b><?=alta($saida_inquilino) ?></b></p></td>
    </tr>
<?
	$busca3 = mysql_query("SELECT * FROM veiculos_inquilino WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    if(mysql_num_rows($busca3) > 0)
    {?>
	<tr>
      <td colspan="2" class="style">&nbsp;</td>
    </tr>
	<tr>
      <td colspan="2" class="style"><p><b>Veículos</b></p></td>
    </tr>    	
<?php }
    $j = 1;
	while($linha3 = mysql_fetch_array($busca3)){
    	echo("
    		<tr>
      			<td colspan=\"2\" class=\"style\"><p><b>".$j."°</b> Ve&iacute;culo: <b>".alta($linha3['veiculo_inquilino'])."</b> Cor: <b>".alta($linha3['cor_inquilino'])."</b> Placa: <b>".alta($linha3['placa_inquilino'])."</b> Cidade: <b>".alta($linha3['cidade_veiculo_inquilino'])."</b></p></td>
    		</tr>
    	");
    $j++;
    }

	$busca2 = mysql_query("SELECT * FROM acompanhantes_inquilino WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    if(mysql_num_rows($busca2) > 0)
    { ?>
	<tr>
      <td colspan="2" class="style">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style"><p><b>Acompanhantes</b></p></td>
    </tr>
<?php }
    $i = 1;
	while($linha2 = mysql_fetch_array($busca2)){
    	echo("
    		<tr>
      			<td colspan=\"2\" class=\"style\"><p><b>".$i."°</b> Nome: <b>".alta($linha2['nome_acompanhante'])."</b> Idade: <b>".alta($linha2['idade_acompanhante'])."</b></p></td>
    		</tr>
    	");
    $i++;
    }
?>
    <tr>
      <td colspan="2" class="style">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style"><div align="justify">Declaro ter recebido o preenchimento desta  ficha, uma c&oacute;pia do regulamento do Condom&iacute;nio do Edif&iacute;cio  
        <b><?=alta($con_ref_inquilino); ?></b> 
        como tamb&eacute;m ter sido recomendado quanto &agrave; ordem  interna e do uso correto das vagas de estacionamento, estando de total acordo e  obrigando &ndash; me a cumpri &ndash; lo.</div></td>
    </tr>
    <tr>
      <td colspan="2" class="style">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style"><div align="right"><?=$_SESSION['cidadei']; ?> - <?=$_SESSION['estadoi']; ?> <?=alta($dia); ?> de <?=alta($mes); ?> de <?=alta($ano); ?></div></td>
    </tr>
    <tr>
      <td colspan="2" class="style">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style"><p>____________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ____________________________</p></td>
    </tr>
    <tr>
      <td colspan="2" class="style"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Respons&aacute;vel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrador</p></td>
    </tr>
    <tr>
		<td>&nbsp;</td>
	</tr>
    <tr>
    	<td colspan="2" class="style" align="center">Rede Brasileira de Imóveis<BR />www.redebrasileiradeimoveis.com.br</td>
    </tr>
<div class=noprint>	
	<tr>
	  <td><div align="center"><span class="style">
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()"><br><br>
<?
			if($popup=='S'){
?>	    
				<input id=idPrint type="button" value="Voltar" class="campo3 noprint" onClick="javascript:history.back();"><br><br>
<?
			}else{
?>
			    <input id=idPrint type="button" value="Fechar Janela" class="campo3 noprint" onClick="window.close();"><br><br>
<?
			}
?>
</form>	    
	    <form name="form3" id="form3" method="post" class="noprint" action="impressao_ficha_inquilinos.php"><input type="submit" value="Exportar para PDF" name="exportar" id="exportar" class="campo3 noprint" onClick="form3.action='impressao_ficha_inquilinos.php?pdf=1&id=<?=$id ?>';"></form>
	  </span></div></td>
    </tr>
</div>
	</table>
<?
mysql_close($con);
/*
	}else{
		include("login2.php");
	}
*/	
?>
</body>
</html>
<? } ?>