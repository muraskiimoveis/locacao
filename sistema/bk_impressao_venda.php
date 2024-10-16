<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_VEND");

    $imp = $_GET['imp'];
    $cod = $_GET['cod'];
    $l_cod = $_GET['l_cod'];

	$query3 = "select * from doc where d_cod = '5' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cliente=c.c_cod and m.cidade_mat=ci.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	$d_txt = str_replace("-mat-", "<b>$not2[matricula]</b>", $not3[d_txt]);
	$d_txt = str_replace("-ref-", "$not2[ref]", $d_txt);
	$d_txt = str_replace("-dias_uteis-", "$not2[dias]", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "<b>$not2[titulo]</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-uf_imovel-", "<b>$not2[e_nome]</b>", $d_txt);
	
	$valor = number_format($not2[valor], 2, ',', '.');
	
	$d_txt = str_replace("-valor-", "<b>$valor</b>", $d_txt);
	
	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );

	$d_txt = str_replace("-data_inicio-", "<b>$dia/$mes/$ano</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$dia1/$mes1/$ano1</b>", $d_txt);
	
	$comissao = number_format($not2[comissao], 2, ',', '.');
	
	$d_txt = str_replace("-com_venda-", "<b>$not2[comissao]</b>", $d_txt);

	$d_txt = str_replace("-nome_prop-", "<b>$not2[c_nome]</b>", $d_txt);
	$d_txt = str_replace("-origem_prop-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil_prop-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-data_nasc-", "<b>$not2[c_nasc]</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-tel_prop-", "<b>$not2[c_tel]</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
	$d_txt = str_replace("-bairro_im-", "<b>$linha[im_bairro]</b>", $d_txt);  
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);  
	}
    }
	
	

$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
	<style media="print">
		.noprint { display: none }
	</style>
<body onUnload="window.opener.location.reload()">
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	if($impressao == ""){
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type=hidden name=d_nome value=<?php print("$not3[d_nome]"); ?>>
<input type=hidden name=cod value=<?php print("$cod"); ?>>
<input type=hidden name=impressao value=1>
<input type=hidden name=imp value=5>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea></td></tr>
  <tr bgcolor="#ffffff"><td colspan=2>
<input type="submit" value="Finalizar Texto" class=campo3 name="B1"></td></tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="justify"><br><?php print("$txt"); ?></p><p></td></tr>
<?php
	}
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?></p></td></tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p>&nbsp;</p><p>&nbsp;</p><p align=left>
    <b>PROPRIETÁRIO: _________________________</b></p><p></td>
    <td width="50%" class="style1"><p>&nbsp;</p><p>&nbsp;</p><p align=left>
    <b>CORRETOR(A): _________________________</b></p><p></td>
    </tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p>&nbsp;</p><p>&nbsp;</p><p align=left>
    <b>TESTEMUNHA: _________________________</b></p><p></td>
    <td width="50%" class="style1"><p>&nbsp;</p><p>&nbsp;</p><p align=left>
    <b>TESTEMUNHA: _________________________</b></p><p></td>
    </tr>
  </table>
    <div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style1">
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
<? } ?>
	    <input id=idPrint type="button" value="Fechar" class="campo3" onClick="javascript:window.close()">
	  </span></div></td>
    </tr>
</div>
<?php
	}
	}
	}
?>
</body>