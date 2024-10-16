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
verificaArea("GERAL_LOCA");

if($_GET['pdf']=='1'){
  
 $cod = $_GET['cod'];
 $l_cod = $_GET['l_cod'];

	$busca = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $nimovel = $linha['ref']." - ".strip_tags($linha['titulo']);
	} 


$html5 .='<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>Recibo de Servi&ccedil;os</b><br /></td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Im&oacute;vel:&nbsp; </b> '.$nimovel.'</td>
    </tr> 
    <tr>
      <td><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td width="31%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Nome</b></td>
          <td width="17%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Data</b></td>
          <td width="13%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
          <td width="12%" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Situa&ccedil;&atilde;o</b></td>
          </tr>';
        
		    $busca2 = mysql_query("SELECT id_servico, nome_servico, data_servico, valor_servico, situacao FROM servicos WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND cod_imovel='".$cod."' AND impressao='1' ORDER BY data_servico ASC");
	 			while($linha2 = mysql_fetch_array($busca2)){

      				$html5 .='
	        			<tr>
            				<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['nome_servico'].'</td>
							<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.formataDataDoBd($linha2['data_servico']).'</td>
            				<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha2['valor_servico'], 2, ',', '.').'</td>
							<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha2['situacao'].'</td>
            			</tr>
	   				';
    			}
       
$html5 .='</table></td>
    </tr>
	</table>';


echo $html5;

	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	$pdf = new HTML2PDF('L','A4','fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();

}

 if($_GET['pdf']<>'1'){ 
   
?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
	<style media="print">
		.noprint { display: none }
	</style>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php


if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}

if($_GET['l_cod']){
 $l_cod = $_GET['l_cod'];
}else{
 $l_cod = $_POST['l_cod'];
}
	
	$queryi2= "update servicos set impressao='0' where impressao='1' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND cod_imovel='".$cod."'";        	
	$resulti2 = mysql_query($queryi2) or die("Não foi possível atualizar suas informações. $queryi2");
 
    $i2 = $_POST['i'];
	$c2 = 0;

	for($j2 = 0; $j2 <= $i2; $j2++)
	{	     
		$codigosi = "cod_servico_".$j2;
     	$totali = $_POST[$codigosi];
		$botoesi = "impressao_".$j2;
		$bimpressao = $_POST[$botoesi];

  	 if($bimpressao=='1'){
    	$c++;
    	$queryi= "update servicos set impressao='1' where id_servico='$totali' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
		$resulti = mysql_query($queryi) or die("Não foi possível atualizar suas informações. $queryi");			
     } 
  	}
 


	$busca = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $nimovel = $linha['ref']." - ".strip_tags($linha['titulo']);
	} 


?>
<form id="formulario" name="formulario" method="post" action="cadastro_servicos.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="l_cod" id="l_cod" value="<?=$l_cod ?>">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td class="style1"><p align="center"><b>Recibo de Servi&ccedil;os</b></p></td>
    </tr>
    <tr>
      <td class="style1">&nbsp;</td>
    </tr>
    <tr class="fundoTabela" height="25px">
      <td class="style1"><b>Im&oacute;vel:</b> <?=$nimovel?></td>
    </tr>
    <tr>
      <td class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr class="fundoTabelaTitulo" height="25px">
          <td width="31%" class="style1"><b>Nome</b></td>
          <td width="17%" class="style1"><b>Data</b></td>
          <td width="13%" class="style1"><b>Valor</b></td>
          <td width="12%" class="style1"><b>Situa&ccedil;&atilde;o</b></td>
          </tr>
        <?
        	$j = 0;
		    $busca2 = mysql_query("SELECT id_servico, nome_servico, data_servico, valor_servico, situacao FROM servicos WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND cod_imovel='".$cod."' AND impressao='1' ORDER BY data_servico ASC");
	 			while($linha2 = mysql_fetch_array($busca2)){
					if (($j % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					$j++;
					
					echo "<tr class=\"$fundo\" height=\"25px\">";
      				echo('
            				<td class="style1">'.$linha2['nome_servico'].'</td>
							<td class="style1">'.formataDataDoBd($linha2['data_servico']).'</td>
            				<td class="style1">'.number_format($linha2['valor_servico'], 2, ',', '.').'</td>
							<td class="style1">'.$linha2['situacao'].'</td>
            			</tr>
	   				');
    			}
       ?>
      </table></td>
    </tr>
     <tr>
      <td class="style1">&nbsp;</td>
    </tr>
<div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style1">
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()"> 
		<input id=idPrint type="button" name="fechar"  class="campo3 noprint" value="Fechar Janela" Onclick="window.close();">	
		<input id=idPrint type="button" name="voltar"  class="campo3 noprint" value="Voltar" Onclick="formulario.action='cadastro_servicos.php?cod=<?=$cod; ?>&l_cod=<?=$l_cod; ?>';formulario.submit();"></form><br /><br />		
		<form name="form3" id="form3" class="noprint" method="post" action=""><input type="submit" value="Exportar para PDF" name="exportar" id="exportar" class="campo3 noprint" onClick="form3.action='impressao_servicos.php?pdf=1&cod=<?=$cod ?>&l_cod=<?=$l_cod ?>';"></form>
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