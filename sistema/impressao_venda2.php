<?
if($_POST['pdf']=='1'){
$data_hora10 = date("d_m_Y_H_i_s");
$arquivo10 = "venda_imoveis_".$data_hora10.".doc";

header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: application/msword; name=$arquivo10");
header ( "Content-Disposition: attachment; filename=$arquivo10"); 
header ( "Content-Description: MID Gera Doc" );
}


ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
if($_POST['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_VEND");


if($_POST['pdf']=='1'){

$imp = $_GET['imp'];
$cod = $_GET['cod'];
$l_cod = $_GET['l_cod'];
$impressao2 = $_POST['impressao2'];

 
  if($imp == "5"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	  
	$query20 = "select * from muraski m, clientes c, rebri_cidades ci, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cidade_mat=ci.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	}
	
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=c.c_cod and m.cidade_mat=ci.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente10 = explode("--", $not2[cliente]);
	  $cliente20 = str_replace("-","",$cliente10);  
	
	$d_txt = str_replace("-mat-", "<b>$not2[matricula]</b>", $not3[d_txt]);
	$d_txt = str_replace("-ref-", "$not2[ref]", $d_txt);
	$d_txt = str_replace("-dias_uteis-", "$not2[dias]", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>".strip_tags($not2[descricao])."</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "<b>".strip_tags($not2[titulo])."</b>", $d_txt);
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

	$qstr = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
    $qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $proprietarios = array();
    $origens = array();
    $es_civis = array();
    $rg_ie = array();
    $cpf_cnpj = array();
    $enderecos = array();
    $cidades = array();
    $ufs = array();
    $telefones = array();
    $representantes = array();
    $representantes2 = array();
    foreach ($res as $row) {
        array_push($proprietarios, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origens, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($es_civis, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_ie, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_cnpj, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        array_push($enderecos, $row['c_end']);
        array_push($cidades, $row['c_cidade']);
        array_push($ufs, $row['c_estado']);
        array_push($telefones, $row['c_tel']);
        if (!empty($row['c_repre'])) {
            array_push($representantes, 'Representante 1:<b> ' . $row['c_repre'] . '</b>');
        }
        if (!empty($row['c_repre2'])) {
            array_push($representantes2, 'Representante 2:<b> ' . $row['c_repre2'] . '</b>');
        }
    }
    $proprietarios = implode(' e ', $proprietarios);
    $origens = implode(' e ', $origens);
    $es_civis = implode(' e ', $es_civis);
    $rg_ie = implode(' e ', $rg_ie);
    $cpf_cnpj = implode(' e ', $cpf_cnpj);
    $enderecos = implode(' e ', $enderecos);
    $cidades = implode(' e ', $cidades);
    $ufs = implode(' e ', $ufs);
    $telefones = implode(' e ', $telefones);
    $representantes = implode(' e ', $representantes);
    $representantes2 = implode(' e ', $representantes2);
   
    $d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $d_txt);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-tel_prop-", "<b>$telefones</b>", $d_txt);
   	$d_txt = str_replace("-repre_prop-", "$representantes $representantes2", $d_txt);	
   	
	
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

$dia2 = date("d");
$mes2 = date("m");
$ano2 = date("Y");

$html10 .='<table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  			<tr bgcolor="#EDEEEE">
			  <td colspan="2" class="style1" align="center"><b>'.$not3[d_nome].'</b></td>
			</tr>';

$d_txt = str_replace("\n","<br>","$d_txt");

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="justify">'.$d_txt.'</td>
		</tr>';
	

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="left"><b> '.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>PROPRIETÁRIO: _________________________</b></td>
    		<td width="50%" class="style1"><b>CORRETOR(A): _________________________</b></td>
    	</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    	</tr>
  </table>';

	}
	}
	}
	}//Termina imp = 5
  
echo $html10;

}

if($_POST['pdf']<>'1'){ 

    $imp = $_GET['imp'];
    $cod = $_GET['cod'];
    $l_cod = $_GET['l_cod'];

	$query3 = "select * from doc where d_cod = '5' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	  
	
	$query20 = "select * from muraski m, clientes c, rebri_cidades ci, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cidade_mat=ci.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	} 
	  
	  
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=c.c_cod and m.cidade_mat=ci.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	$cliente10 = explode("--", $not2[cliente]);
	$cliente20 = str_replace("-","",$cliente10);
	
	$d_txt = str_replace("-mat-", "<b>$not2[matricula]</b>", $not3[d_txt]);
	$d_txt = str_replace("-ref-", "$not2[ref]", $d_txt);
	$d_txt = str_replace("-dias_uteis-", "$not2[dias]", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>".strip_tags($not2[descricao])."</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "<b>".strip_tags($not2[titulo])."</b>", $d_txt);
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
	   
    foreach ($cliente20 as $k => $cliente) {
        $cliente20[$k] = "'" . $cliente . "'";
    }

    $qstr = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
    $qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $proprietarios = array();
    $origens = array();
    $es_civis = array();
    $rg_ie = array();
    $cpf_cnpj = array();
    $enderecos = array();
    $cidades = array();
    $ufs = array();
    $telefones = array();
    $representantes = array();
    $representantes2 = array();
    foreach ($res as $row) {
        array_push($proprietarios, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origens, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($es_civis, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_ie, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_cnpj, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        array_push($enderecos, $row['c_end']);
        array_push($cidades, $row['c_cidade']);
        array_push($ufs, $row['c_estado']);
        array_push($telefones, $row['c_tel']);
        if (!empty($row['c_repre'])) {
            array_push($representantes, 'Representante 1:<b> ' . $row['c_repre'] . '</b>');
        }
         if (!empty($row['c_repre2'])) {
            array_push($representantes2, 'Representante 2:<b> ' . $row['c_repre2'] . '</b>');
        }
    }
    $proprietarios = implode(' e ', $proprietarios);
    $origens = implode(' e ', $origens);
    $es_civis = implode(' e ', $es_civis);
    $rg_ie = implode(' e ', $rg_ie);
    $cpf_cnpj = implode(' e ', $cpf_cnpj);
    $enderecos = implode(' e ', $enderecos);
    $cidades = implode(' e ', $cidades);
    $ufs = implode(' e ', $ufs);
    $telefones = implode(' e ', $telefones);
    $representantes = implode(' e ', $representantes);
    $representantes2 = implode(' e ', $representantes2);
    
    $d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $d_txt);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-tel_prop-", "<b>$telefones</b>", $d_txt);
   	$d_txt = str_replace("-repre_prop-", "$representantes $representantes2", $d_txt);
 
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

	 $url = $REQUEST_URI;
 	 //$url = str_replace("-","&","$url");
 	 //$url = str_replace("?","|","$url");	


	if($impressao == ""){
	
?>
<form method="post" action="<?php print("$url"); ?>">
<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="impressao" value="1">
<input type="hidden" name="imp" value="5">
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
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
		<input type="submit" value="Exportar para DOC" name="exportar" id="exportar" class="campo3 noprint">
		</form>
<? } ?>
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()">
	  </span></div></td>
    </tr>
</div>
<?php
	}
	}
	}
?>
</body>
<? } ?>