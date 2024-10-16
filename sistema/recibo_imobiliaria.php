<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
include("style.php");
verificaAcesso();
verificaArea("GERAL_LOCA");

$locacao = $_GET['locacao'];

$busca = mysql_query("SELECT * FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_locacao='".$locacao."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND co.co_cat='Receber' AND co.co_tipo='Locação'");
while($linha = mysql_fetch_array($busca)){
    $c_cod = $linha['c_cod'];
	$valor = $linha['co_valor']; 
}

$inserir = "INSERT INTO recibo_imobiliaria (cod_imobiliaria, cod_cliente, valor_recibo, data_recibo) VALUES ('".$_SESSION['cod_imobiliaria']."', '".$c_cod."', '".$valor."', current_date)";
$result2 = mysql_query($inserir) or die("Não foi possível inserir suas informações. $inserir");
$numero_recibo = mysql_insert_id();

$buscar = mysql_query("SELECT * FROM recibo_imobiliaria r INNER JOIN clientes c ON (r.cod_cliente=c.c_cod) WHERE r.id_recibo='".$numero_recibo."' AND r.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
while($linha = mysql_fetch_array($buscar)){
    $idr = $linha['id_recibo'];
	$nome_cliente = $linha['c_nome']; 
	$end_cliente = $linha['c_end']; 
	$valor_recibo = number_format($linha['valor_recibo'],2,',','.');
	$valor_extenso = extenso($linha['valor_recibo'], true);
	$mes = date("m");
    $mes_extenso = NomeMes($mes);
    $referente = "Aluguel";
    $dia = date("d");
    $ano = date("Y");
}

?>
<script type="text/javascript" src="funcoes/js.js"></script>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
	<style media="print">
		.noprint { display: none }
	</style>
<?
if($impressao == ""){
?>
<form id="formulario" name="formulario" method="post" action="recibo_imobiliaria.php">
<input type="hidden" name="impressao" value="1">
<input type="hidden" name="idr" value="<?=$idr ?>">
<div align="center" style="margin-top: 20px;">
<table width="95%" border="0" cellspacing="1" cellpadding="1">
  <tr class="fundoTabela">
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10%" class="style1"><b>N&deg;:</b> <?=$idr ?></td>
        <td width="45%" class="style1" align="center"><b>RECIBO</b></td>
        <td width="45%" class="style1"><b>Valor:</b> R$ <input type="text" name="valor_recibo" id="valor_recibo" size="10" class="campo" value="<?=$valor_recibo ?>" onKeydown="Formata(this,20,event,2)" onChange="formulario.impressao.value='';formulario.submit();"></td>
      </tr>
    </table></td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3" class="style1"><b>Recebi (emos) de:</b> <input type="text" name="nome_cliente" id="nome_cliente" size="40" class="campo" value="<?=$nome_cliente ?>"></td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3" class="style1"><b>Endere&ccedil;o:</b> <input type="text" name="end_cliente" id="end_cliente" size="40" class="campo" value="<?=$end_cliente ?>"></td>
  </tr>
<? 
	if($_POST['valor_recibo']){
	  $valor_extenso = str_replace(".", "", $_POST['valor_recibo']);  
	  $valor_extenso = str_replace(",", ".", $valor_extenso); 	
	  $valor_extenso = extenso($valor_extenso, true);
	}
?>  
  <tr class="fundoTabela">
    <td colspan="3" class="style1"><b>A import&acirc;ncia de:</b> <input type="text" name="valor_extenso" id="valor_extenso" size="40" class="campo" value="<?=$valor_extenso ?>"></td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3" class="style1"><b>Referente:</b> <input type="text" name="referente" id="referente" size="30" class="campo" value="<?=$referente ?>"></td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3" class="style1">Para maior clareza firmamos o presente. </td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3" align="left" class="style1"><input type="text" name="cidadei" id="cidadei" size="30" class="campo" value="<?=$cidadei ?>">, <input type="text" name="dia" id="dia" size="2" maxlength="2" class="campo" value="<?=$dia?>"> de <input type="text" name="mes_extenso" id="mes_extenso" size="20" class="campo" value="<?=$mes_extenso ?>"> de <input type="text" name="ano" id="ano" size="4" maxlength="4" class="campo" value="<?=$ano?>"></td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr class="fundoTabela">
	<td colspan="3">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
      		<tr>
      			<td width="55%" colspan="2" class="style1"><b>Emitente:</b> <input type="text" name="nome_imobiliaria" id="nome_imobiliaria" size="40" class="campo" value="<?=$nome_imobiliaria ?>"></td>
    			<td width="45%" class="style1"><b>CNPJ:</b> <input type="text" name="cnpj_imobiliaria" id="cnpj_imobiliaria" size="23" maxlength="19" class="campo" value="<?=$cnpj_imobiliaria ?>" onkeypress="return (Mascara(this,event,'###.###.###/####-##'));return validarCampoNumerico(event);"></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr class="fundoTabela">
    <td colspan="3" class="style1"><b>Endere&ccedil;o:</b> <input type="text" name="im_endereco" id="im_endereco" size="40" class="campo" value="<?=$im_endereco ?>"></td>
  </tr>
  <tr>
    <td colspan="3" class="style1" align="left"><input type="submit" value="Finalizar Texto" class="campo3" name="B1"></td>
  </tr>
</table>
</div>
<? }else{ ?>
<div align="center" style="margin-top: 20px;">
<table width="95%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10%" class="style1c"><b>N&deg;:</b> <?=$idr ?></td>
        <td width="45%" class="style1c" align="center"><b>RECIBO</b></td>
        <td width="45%" class="style1c"><b>Valor:</b> R$ <?=$valor_recibo ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style1c"><b>Recebi (emos) de:</b> <?=$nome_cliente ?></td>
  </tr>
  <tr>
    <td class="style1c"><b>Endere&ccedil;o:</b> <?=$end_cliente ?></td>
  </tr>
  <tr>
    <td class="style1c"><b>A import&acirc;ncia de:</b> <?=$valor_extenso ?></td>
  </tr>
  <tr>
    <td class="style1c"><b>Referente:</b> <?=$referente ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style1c">Para maior clareza firmamos o presente. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="style1c"><?=$cidadei ?>, <?=$dia?> de <?=$mes_extenso ?> de <?=$ano?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>
  		<table width="100%" border="0" cellspacing="0" cellpadding="0">
    		<tr>
      			<td width="55%" class="style1c"><b>Emitente:</b> <?=$nome_imobiliaria ?></td>
    			<td width="45%" colspan="2" class="style1c"><b>CNPJ:</b> <?=$cnpj_imobiliaria ?></td>
       		</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td class="style1c"><b>Endere&ccedil;o:</b> <?=$im_endereco ?></td>
  </tr>
  <tr>
    <td class="style1c">Assinatura: __________________________________________________________________________________________________</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<div class=noprint>	
  <tr>
    <td class="style1c" align="center"><input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()"></td>
  </tr>
</div>
</table>
</div>
<? } ?>