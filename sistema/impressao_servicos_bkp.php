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
verificaArea("GERAL_LOCA");
?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
	<style media="print">
		.noprint { display: none }
	</style>
<link href="style.css" rel="stylesheet" type="text/css" />
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
       $nimovel = $linha['ref']." - ".$linha['titulo'];
	} 


?>
<form id="formulario" name="formulario" method="post" action="cadastro_servicos.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="l_cod" id="l_cod" value="<?=$l_cod ?>">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td class="style1"><div align="center"><b>Recibo de Servi&ccedil;os</b><br />
      </div></td>
    </tr>
    <tr>
      <td class="style1">&nbsp;</td>
    </tr>
    <tr>
      <td class="style1"><b>Im&oacute;vel:</b> <?=$nimovel?></td>
    </tr> 
    <tr>
      <td><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td width="31%" class="TdSubTitulo"><b>Nome</b></td>
          <td width="17%" class="TdSubTitulo"><b>Data</b></td>
          <td width="13%" class="TdSubTitulo"><b>Valor</b></td>
          <td width="12%" class="TdSubTitulo"><b>Situa&ccedil;&atilde;o</b></td>
          </tr>
        <?
		    $busca2 = mysql_query("SELECT id_servico, nome_servico, data_servico, valor_servico, situacao FROM servicos WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND cod_imovel='".$cod."' AND impressao='1' ORDER BY data_servico ASC");
	 			while($linha2 = mysql_fetch_array($busca2)){

      				echo('
	        			<tr>
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
<div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style1">
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()"> 
		<input id=idPrint type="button" name="fechar"  class="campo3 noprint" value="Fechar Janela" Onclick="window.close();">	
		<input id=idPrint type="button" name="voltar"  class="campo3 noprint" value="Voltar" Onclick="formulario.action='cadastro_servicos.php?cod=<?=$cod; ?>&l_cod=<?=$l_cod; ?>';formulario.submit();"></form>		
		<form name="form3" id="form3" method="post" class="noprint" action=""><input type="submit" value="Exportar para PDF" name="exportar" id="exportar" class="campo3 noprint" onClick="form3.action='impressao_servicos_pdf.php?cod=<?=$cod ?>&l_cod=<?=$l_cod ?>';"></form>
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