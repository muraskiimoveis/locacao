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
	$valor_recibo = $linha['valor_recibo']; 
	$valor_extenso = extenso($linha['valor_recibo'], true);
	$mes = date("m");
    $mes_extenso = NomeMes($mes);
}

?>

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19%" class="style1">N&deg;: <?=$idr ?></td>
        <td width="45%" class="style1" align="center"><b>RECIBO</b></td>
        <td width="34%" class="style1">Valor: <?=number_format($valor_recibo,2,',','.') ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style1">Recebi (emos) de: <?=$nome_cliente ?></td>
  </tr>
  <tr>
    <td class="style1">Endere&ccedil;o: <?=$end_cliente ?></td>
  </tr>
  <tr>
    <td class="style1">A import&acirc;ncia de: <?=$valor_extenso ?></td>
  </tr>
  <tr>
    <td class="style1">Referente: Aluguel </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style1">Para maior clareza firmamos o presente. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style1" align="center"><?=$cidadei ?>, <?=date("d")?> de <?=$mes_extenso ?> de <?=date("Y")?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="51%" class="style1">Emitente: <?=$nome_imobiliaria ?></td>
    <td width="49%" class="style1">CNPJ: <?=$cnpj_imobiliaria ?></td>
  </tr>
  <tr>
    <td sclass="style1">Endere&ccedil;o: <?=$im_endereco ?></td>
  </tr>
  <tr>
    <td class="style1">Assinatura: __________________________________________________________________________________________________</td>
  </tr>
</table>


