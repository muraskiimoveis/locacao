<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribué sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 */
 	ob_start();

$nomeCliente = "Eduardo Sgode Farias";
$enderecoCliente = "Estrada da Roseira, 171 - Borda do Campo - São José dos Pinhais";
$documentoCliente = "040.000.111-99";
$nomeFundo = "J  Malucelli  &  Omar Camargo FIA";

	// Retorna o nome do mês
	function NomeMes($mes)
	{
		switch($mes)
		{
			case 1:
				$nome = "janeiro";
				break;
			case 2:
				$nome = "fevereiro";
				break;
			case 3:
				$nome = "março";
				break;
			case 4:
				$nome = "abril";
				break;
			case 5:
				$nome = "maio";
				break;
			case 6:
				$nome = "junho";
				break;
			case 7:
				$nome = "julho";
				break;
			case 8:
				$nome = "agosto";
				break;
			case 9:
				$nome = "setembro";
				break;
			case 10:
				$nome = "outubro";
				break;
			case 11:
				$nome = "novembro";
				break;
			case 12:
				$nome = "dezembro";
				break;
		}
		echo $nome;
	}

?>
<style type="text/css">
<!--
table {
	vertical-align: top;
	align: center;
	text-align: justify;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	color: #716F64;
	line-height:200%;
}
tr td {
	vertical-align: top;
	align: center;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	color: #000000;
	line-height:200%;
}

}
-->
</style>
<table width="100%">
<tr><td colspan="2"><img src="logoPam.JPG"/></td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
   <td colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <strong>Termo de Ades&atilde;o</strong><BR><BR> </td>
</tr>
<tr>
   <td colspan=2>
Eu, <strong><? echo $nomeCliente; ?></strong>; residente e domiciliado na 
<strong><? echo $enderecoCliente; ?></strong>,  inscrito  no  CPF/CNPJ  sob  o 
n&ordm; <strong><? echo $documentoCliente; ?></strong>,  na  qualidade  de  investidor  do  <strong><? echo $nomeFundo; ?></strong>, administrado pelo <strong>J.Malucelli DTVM Ltda</strong>, declaro para todos os fins de 
direito: 
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td style="width:25%">1.</td>
<td style="width:75%">
   Ter  recebido,  lido  e  compreendido  o  Regulamento  do  Fundo  e  respectivo 
  Prospecto,  ter  concordado  integralmente  com  seus  termos  e  condi&ccedil;&otilde;es, 
  declarando ainda que os mesmos est&atilde;o perfeitamente de acordo com o perfil de 
  risco pretendido; 
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>2.</td>
<td>Estar  ciente  de  que  a  exist&ecirc;ncia  de  rentabilidade/performance  do  Fundo  no 
  passado n&atilde;o constitui garantia de rentabilidade/performance futura; <BR />
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>3.</td>
<td>Estar ciente de que as condi&ccedil;&otilde;es de emiss&atilde;o e resgate de cotas do Fundo, que 
  constam  do  respectivo  Prospecto,  poder&atilde;o  ser  alteradas  pelo  Administrador, 
mediante aviso pr&eacute;vio por escrito;
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>4.</td>
<td>Que  autorizo o Administrador aceitar ordens  verbais para  subscri&ccedil;&atilde;o e  resgate 
  de cotas. 
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2">
Curitiba, <? echo date('d')?> de 
<? NomeMes(date('m')); ?> 
de <? echo date('Y')?>.  <BR /><BR />
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  _______________________________________ <BR />  
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  (Assinatura do Cliente) </td>
</tr>

</table>

  <?php

	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/html2pdf.class.php');
	$pdf = new HTML2PDF('P','A4','fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();

?>
