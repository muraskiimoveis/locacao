<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
if($_GET['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("REL_CLIENTES");
verificaArea("CLIENT_GERAL");
?>
<? if($_GET['pdf']<>'1'){ ?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
	<style media="print">
		.noprint { display: none }
	</style>
</head>

<body>
<? } ?>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	  

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
	   $idade_inquilino = $linha['idade_inquilino'];
	   $cidade_inquilino = $linha['cidade_inquilino'];
	   $estado_inquilino = $linha['estado_inquilino'];
	   $entrada_inquilino = formataDataDoBd($linha['entrada_inquilino']);
	   $saida_inquilino = formataDataDoBd($linha['saida_inquilino']);
	   $veiculo_inquilino = $linha['veiculo_inquilino'];
	   $cor_inquilino = $linha['cor_inquilino'];
	   $placa_inquilino = $linha['placa_inquilino'];
	   $cidade_veiculo_inquilino = $linha['cidade_veiculo_inquilino'];
	   $data_exp = explode("-", $linha['data_inquilino']);
	   $nova_data = $data_exp[2] . "/" . $data_exp[1] . "/" . $data_exp[0];
	   $dia = $data_exp[2];
	   $mes = NomeMes($data_exp[1]);
	   $ano = $data_exp[0];

	} 

if($_GET['pdf']=='1'){

$data_hora = date("d_m_Y_H_i_s");
$arquivo = "ficha_inquilino_".$data_hora.".doc";

header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: application/msword; name=$arquivo");
header ( "Content-Disposition: attachment; filename=$arquivo"); 

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
	   $idade_inquilino = $linha['idade_inquilino'];
	   $cidade_inquilino = $linha['cidade_inquilino'];
	   $estado_inquilino = $linha['estado_inquilino'];
	   $entrada_inquilino = formataDataDoBd($linha['entrada_inquilino']);
	   $saida_inquilino = formataDataDoBd($linha['saida_inquilino']);
	   $veiculo_inquilino = $linha['veiculo_inquilino'];
	   $cor_inquilino = $linha['cor_inquilino'];
	   $placa_inquilino = $linha['placa_inquilino'];
	   $cidade_veiculo_inquilino = $linha['cidade_veiculo_inquilino'];
	   $data_exp = explode("-", $linha['data_inquilino']);
	   $nova_data = $data_exp[2] . "/" . $data_exp[1] . "/" . $data_exp[0];
	   $dia = $data_exp[2];
	   $mes = NomeMes($data_exp[1]);
	   $ano = $data_exp[0];

	} 

/*  
$html .='<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css"> 
';
*/  
  
$html .='<table width="538" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="534" colspan="2" class="style1"><div align="center"><b>Ficha de registro de inquilinos </b></div></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1">Condom&iacute;nio do  Edif&iacute;cio/refer&ecirc;ncia: <b>'.strtoupper($con_ref_inquilino).'</b></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">Ap.: <b>'.strtoupper($ap_inquilino).'</b> Propriet&aacute;rio: <b>'.strtoupper($prop_inquilino).'</b></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">Respons&aacute;vel: <b>'.strtoupper($resp_inquilino).'</b> Tel.: <b>'.strtoupper($fone_inquilino).'</b></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">RG: <b>'.strtoupper($rg_inquilino).'</b> CPF: <b>'.strtoupper($cpf_inquilino).'</b> Idade: <b>'.strtoupper($idade_inquilino).'</b></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">Cidade/Estado:  <b>'.strtoupper($cidade_inquilino).'</b> / <b>'.strtoupper($estado_inquilino).'</b></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">Entrada: <b>'.strtoupper($entrada_inquilino).'</b> Sa&iacute;da: '.strtoupper($saida_inquilino).' Ve&iacute;culo: <b>'.strtoupper($veiculo_inquilino).'</b></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">Cor: <b>'.strtoupper($cor_inquilino).'</b> Placa: <b>'.strtoupper($placa_inquilino).'</b> Cidade: <b>'.strtoupper($cidade_veiculo_inquilino).'</b></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1">Acompanhantes</td>
    </tr>';
    
	$busca2 = mysql_query("SELECT * FROM acompanhantes_inquilino WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    $i = 1;
	while($linha2 = mysql_fetch_array($busca2)){
    	$html .='
    		<tr>
      			<td colspan="2" class="style1"><b>'.$i.'°</b> Nome: <b>'.$linha2['nome_acompanhante'].'</b> Idade: <b>'.$linha2['idade_acompanhante'].'</b></td>
    		</tr>
    	';
    $i++;
    }

$html .='<tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><div align="justify">Declaro ter recebido o preenchimento desta  ficha, uma c&oacute;pia do regulamento do Condom&iacute;nio do Edif&iacute;cio  
        <br><b>'.strtoupper($con_ref_inquilino).'</b> 
        como também ter sido recomendado quanto à ordem interna e do uso correto das vagas de estacionamento, estando de total acordo e obrigando - me a cumprí - lo.</div></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><div align="right">'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].'  '.strtoupper($dia).' de '.strtoupper($mes).' de '.strtoupper($ano).'</div></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1">____________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ____________________________</td>
    </tr>
    <tr>
      <td colspan="2" class="style1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Respons&aacute;vel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrador</td>
    </tr>
	</table>';

echo $html;

/*  
$data_hora = date("d_m_Y_H_i_s");
$arquivo = "ficha_inquilino_".$data_hora.".pdf";

require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();
$dompdf->stream($arquivo);  
*/  
  
}
  
?>
<? if($_GET['pdf']<>'1'){ ?>
<form id="form1" name="form1" method="post" action="ficha_inquilinos.php">
  <table width="538" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="534" colspan="2" class="style1"><div align="center"><b>Ficha de registro de inquilinos </b></div></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>Condom&iacute;nio do  Edif&iacute;cio/refer&ecirc;ncia: <b><?=strtoupper($con_ref_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>Ap.: <b><?=strtoupper($ap_inquilino); ?></b> Propriet&aacute;rio: <b><?=strtoupper($prop_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>Respons&aacute;vel: <b><?=strtoupper($resp_inquilino); ?></b> Tel.: <b><?=strtoupper($fone_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>RG: <b><?=strtoupper($rg_inquilino); ?></b> CPF: <b><?=strtoupper($cpf_inquilino); ?></b> Idade: <b><?=strtoupper($idade_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>Cidade/Estado:  <b><?=strtoupper($cidade_inquilino); ?></b> / <b><?=strtoupper($estado_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>Entrada: <b><?=strtoupper($entrada_inquilino); ?></b> Sa&iacute;da: <?=strtoupper($saida_inquilino) ?> Ve&iacute;culo: <b><?=strtoupper($veiculo_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>Cor: <b><?=strtoupper($cor_inquilino); ?></b> Placa: <b><?=strtoupper($placa_inquilino); ?></b> Cidade: <b><?=strtoupper($cidade_veiculo_inquilino); ?></b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>Acompanhantes</p></td>
    </tr>
<?
	$busca2 = mysql_query("SELECT * FROM acompanhantes_inquilino WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    $i = 1;
	while($linha2 = mysql_fetch_array($busca2)){
    	echo("
    		<tr>
      			<td colspan=\"2\" class=\"style1\"><p><b>".$i."°</b> Nome: <b>".$linha2['nome_acompanhante']."</b> Idade: <b>".$linha2['idade_acompanhante']."</b></p></td>
    		</tr>
    	");
    $i++;
    }
?>
    <tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><div align="justify">Declaro ter recebido o preenchimento desta  ficha, uma c&oacute;pia do regulamento do Condom&iacute;nio do Edif&iacute;cio  
        <b><?=strtoupper($con_ref_inquilino); ?></b> 
        como tamb&eacute;m ter sido recomendado quanto &agrave; ordem  interna e do uso correto das vagas de estacionamento, estando de total acordo e  obrigando &ndash; me a cumpri &ndash; lo.</div></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><div align="right"><?=$_SESSION['cidadei']; ?> - <?=$_SESSION['estadoi']; ?> <?=strtoupper($dia); ?> de <?=strtoupper($mes); ?> de <?=strtoupper($ano); ?></div></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>____________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ____________________________</p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Respons&aacute;vel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrador</p></td>
    </tr>
    
    
<div class=noprint>	
	<tr>
	  <td><div align="center"><span class="style1">
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()"> 
</form>	    
	    <form name="form3" id="form3" class="noprint" method="post" action="impressao_ficha_inquilinos.php"><input type="submit" value="Exportar para DOC" name="exportar" id="exportar" class="campo3 noprint" onClick="form3.action='impressao_ficha_inquilinos.php?pdf=1&id=<?=$id ?>';"></form>
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