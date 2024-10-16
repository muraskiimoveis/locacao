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
//verificaArea("GERAL_LOCA");


if(isset($_GET['l_cod'])){
  $cod_locacao = $_GET['l_cod'];
  $cod_imovel = $_GET['cod'];
}else{
  $cod_locacao = $_POST['l_cod'];
  $cod_imovel = $_POST['cod'];
}

if(isset($_GET['codigo'])){
  $codigo = $_GET['codigo'];
  $cod_locacao = '';
  $cod_imovel = '';
}

$referente = '';
if(isset($codigo)){
  $buscar = mysql_query("select * from despesas where de_cod='$codigo' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
  while($linha = mysql_fetch_array($buscar)){

	$despesas = $linha[de_valor];
    $referente = $linha[de_desc];
   	$diarista = $linha[de_diarista];
    $co_imovel = $linha[de_imovel];
    $co_locacao = $linha[de_locacao];
    $nr_recibo = $linha[de_recibo];
  }
}else{
  $buscar = mysql_query("select * from despesas where de_imovel='$cod_imovel' and de_locacao='$cod_locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
  while($linha = mysql_fetch_array($buscar)){

	if($linha[de_status] == "A PAGAR"){
		$despesas = $despesas + $linha[de_valor];

        if($referente == ''){
    	   $referente = $linha[de_desc];
        }else{$referente = $referente."; ".$linha[de_desc];}

       	$diarista = $linha[de_diarista];
        $co_imovel = $linha[de_imovel];
        $co_locacao = $linha[de_locacao];

	}
  }
}

$qry_desp = "select ref, titulo from muraski where cod='$co_imovel' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
$res_desp = mysql_query($qry_desp);
$num_desp = mysql_num_rows($res_desp);
if($num_desp > 0){
 while($not_desp = mysql_fetch_array($res_desp))
 {
	 $referencia = $not_desp[ref];
	 $titulo = $not_desp[titulo];
 }
}

$qry_loc = "select l_data_ent, l_data_sai from locacao where l_cod='$co_locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
$res_loc = mysql_query($qry_loc);
$num_loc = mysql_num_rows($res_loc);
if($num_loc > 0){
 while($not_loc = mysql_fetch_array($res_loc))
 {
	$ano0 = substr ($not_loc[l_data_ent], 0, 4);
	$mes0 = substr($not_loc[l_data_ent], 5, 2 );
	$dia0 = substr ($not_loc[l_data_ent], 8, 2 );
	$ano1 = substr ($not_loc[l_data_sai], 0, 4);
	$mes1 = substr($not_loc[l_data_sai], 5, 2 );
	$dia1 = substr ($not_loc[l_data_sai], 8, 2 );

 }
}
    //REALIZA BUSCA DO NOME DA DIARISTA
    $nome_diarista = '';
	$queryD = "select * from clientes where c_cod='$diarista' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultD = mysql_query($queryD);
	while($notD = mysql_fetch_array($resultD))
	{
	   $nome_diarista = $notD[c_nome];
       $end_diarista = $notD[c_end];
       $cpf_diarista = $notD[c_cpf];
	}

	$valor_recibo = number_format($despesas,2,',','.');
	$valor_extenso = extenso($despesas, true);

	$mes = date("m");
    $mes_extenso = NomeMes($mes);
    $dia = date("d");
    $ano = date("Y");

    $nr_recibo = str_pad($nr_recibo, 9, "0", STR_PAD_LEFT);

?>
<script type="text/javascript" src="funcoes/js.js"></script>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
	<style media="print">
		.noprint { display: none }
	</style>

<div align="center" style="margin-top: 20px;">
<table width="95%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15%" class="style1c"><b>N&deg;:</b> <?=$nr_recibo ?></td>
        <td width="10%" class="style1c">&nbsp;</td>
        <td width="30%" class="style1c" align="center"><b>RECIBO</b></td>
        <td width="10%" class="style1c">&nbsp;</td>
        <td width="33%" class="style1c"><b>Valor:</b> R$ <?=$valor_recibo ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="style1c"><?php echo str_repeat("-=", 47);?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style1c"><b>Recebi (emos) de:</b> <?=$_SESSION['nome_imobiliaria'] ?></td>
  </tr>
  <tr>
    <td class="style1c"><b>Endere&ccedil;o:</b> <?=$_SESSION['im_endereco'] ?></td>
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
    <td class="style1c"><b>Serviços no Im&oacute;vel :</b> <?=$referencia." - ".$titulo ?></td>
  </tr>
  <tr>
    <td class="style1c"><b>Loca&ccedil;&atilde;o no per&iacute;odo de  <?=$dia0."/".$mes0."/".$ano0." at&eacute; ".$dia1."/".$mes1."/".$ano1 ?> </b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style1c">Para maior clareza firmo o presente. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="style1c"><?=$_SESSION['cidadei']."-PR"?>, <?=$dia?> de <?=$mes_extenso ?> de <?=$ano?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>
  		<table width="100%" border="0" cellspacing="0" cellpadding="0">
    		<tr>
      			<td width="55%" class="style1c"><b>Emitente:</b> <?=$nome_diarista ?></td>
       		</tr>
		</table>
	</td>
  </tr>
  <tr>
      <td class="style1c"><b>CPF:</b> <?=$cpf_diarista ?></td>
  </tr>
  <tr>
    <td class="style1c"><b>Endere&ccedil;o:</b> <?=$end_diarista ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style1c">Assinatura: <?php echo str_repeat("_", 35);?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style1c"><?php echo str_repeat(".", 153);?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40%" class="style1c"><b>PROTOCOLO DE ENTREGA AO RECIBO Nº </b></td>
        <td width="15%" class="style1c"><b><?=$nr_recibo ?></b></td>
        <td width="15%" class="style1c" align="center">&nbsp;</td>
        <td width="33%" class="style1c"><b>Valor:</b> R$ <?=$valor_recibo ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="style1c"><?php echo str_repeat("-=", 47);?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
       <td width="55%" class="style1c"><b>Serviços no Im&oacute;vel :</b> <?=substr($referencia." - ".$titulo,0,60) ?></td>
       <td width="45%" class="style1c"><b>Funcionário :</b> <?php echo str_repeat("_", 25);?></td>
      </tr>
    </table></td>
 </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" class="style1c"><b>Loca&ccedil;&atilde;o no per&iacute;odo de  <?=$dia0."/".$mes0."/".$ano0." at&eacute; ".$dia1."/".$mes1."/".$ano1 ?> </b></td>
        <td width="35%" class="style1c"><b>Data :</b> <?php echo str_repeat("_", 25);?></td>
     </tr>
    </table></td>
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

