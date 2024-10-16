<?php
if($_POST['pdf']=='1'){
$data_hora10 = date("d_m_Y_H_i_s");
$arquivo10 = "proposta_compra_imovel_".$data_hora10.".doc";

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
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("DOCS");

if($_POST['pdf']=='1'){
  
  if($imp == "7"){
 
if($_POST['codim']){
$codim = $_POST['codim'];
}else{
$codim = $_GET['codim'];
}
if($_POST['cidadeim']){
$cidadeim = $_POST['cidadeim'];
}else{
$cidadeim = $_GET['cidadeim'];  
}
if($_POST['ufim']){
$ufim = $_POST['ufim'];
}else{
$ufim = $_GET['ufim'];
}
	
if($codim<>$_SESSION['cod_imobiliaria']){
     
    $cod_im = $codim;
    
    $buf = mysql_query("SELECT e_uf FROM rebri_estados WHERE e_cod='".$ufim."'");
	while($linha = mysql_fetch_array($buf)){
	    $estado_im = $linha['e_uf'];
	}
	
	$bcidade = mysql_query("SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$cidadeim."'");
	while($linha = mysql_fetch_array($bcidade)){
	    $cidade_im = $linha['ci_nome'];
	}
	    
}else{
  
    $cod_im = $_SESSION['cod_imobiliaria'];
    $estado_im = $_SESSION['estadoi'];
    $cidade_im = $_SESSION['cidadei'];  
}
		
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$cod_im."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci where m.cod = '$cod' and c.c_cod='$compr' and m.cod_imobiliaria='".$cod_im."' and m.cidade_mat=ci.ci_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-profissao-", "<b>$not2[c_prof]</b>", $d_txt);
	$d_txt = str_replace("-rg-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-bairro-", "<b>$not2[c_bairro]</b>", $d_txt);
	$d_txt = str_replace("-cidade-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-cep-", "<b>$not2[c_cep]</b>", $d_txt);
	$d_txt = str_replace("-tel-", "<b>$not2[c_tel]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-local-", "<b>$not2[local]</b>", $d_txt);
	$d_txt = str_replace("-matricula-", "<b>$not2[matricula]</b>", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$not2[ci_nome]</b>", $d_txt);
	
	
$nome_cliente3 = '';

for ($i3 = 0; $i3 < $not2[contador]; $i3++) {

	$query4 = "select * from clientes where c_cod='" . $cliente2[$i3] . "' and cod_imobiliaria='" . $cod_im . "'";

	$result4 = mysql_query($query4);
	$res_clientes = array();
	
	while ($not4 = mysql_fetch_array($result4)) {
	    array_push($res_clientes, $not4[c_nome]);
	}
	
	$res_clientes = implode(" e ", $res_clientes);
	$nome_cliente3 .= empty($nome_cliente3) ? $res_clientes : " e " . $res_clientes;

}

	$d_txt = str_replace("-nome_prop-", "<b>$nome_cliente3</b>", $d_txt);

	
	$ano = date("Y");
	$mes = date("m");
	$dia = date("d");

	$query40 = "SELECT texto_sinal FROM sinal_venda WHERE id_sinal='$id' and cod_imovel='".$cod."' AND cod_imobiliaria='".$cod_im."'";
	$result40 = mysql_query($query40);
	while($not40 = mysql_fetch_array($result40))
	{
	   $proposta = $not40['texto_proposta'];
	}

	$d_txt = str_replace("-proposta-", "<b>$proposta</b>", $d_txt);
	$d_txt = str_replace("-data_hoje-", "<b>$dia/$mes/$ano</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$cod_im."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_resp]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_creci_resp]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
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

$html10 .='<table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  			<tr bgcolor="#EDEEEE">
			  <td colspan="2" class="style1" align="center"><b>'.$not3[d_nome].'</b></td>
			</tr>';

	$txt = str_replace("\n","<br>","$txt");

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="justify">'.$d_txt.'</td>
		</tr>';
		
$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="left"><b> '.$cidade_im.' - '.$estado_im.', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
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
	}//Termina imp = 7
  
echo $html10;
 
}

if($_POST['pdf']<>'1'){

?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<style media="print">
		.noprint { display: none }
	</style>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	  

//include("topo.php");
//include("menu.php");
?>
<p>
<?php

//Termina imp = 4
	if($imp == "7"){
 
	//echo $comprador;
	//echo $cod;


if($_POST['codim']){
$codim = $_POST['codim'];
}else{
$codim = $_GET['codim'];
}
if($_POST['cidadeim']){
$cidadeim = $_POST['cidadeim'];
}else{
$cidadeim = $_GET['cidadeim'];  
}
if($_POST['ufim']){
$ufim = $_POST['ufim'];
}else{
$ufim = $_GET['ufim'];
}
	
if($codim<>$_SESSION['cod_imobiliaria']){
     
    $cod_im = $codim;
    
    $buf = mysql_query("SELECT e_uf FROM rebri_estados WHERE e_cod='".$ufim."'");
	while($linha = mysql_fetch_array($buf)){
	    $estado_im = $linha['e_uf'];
	}
	
	$bcidade = mysql_query("SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$cidadeim."'");
	while($linha = mysql_fetch_array($bcidade)){
	    $cidade_im = $linha['ci_nome'];
	}
	    
}else{
  
    $cod_im = $_SESSION['cod_imobiliaria'];
    $estado_im = $_SESSION['estadoi'];
    $cidade_im = $_SESSION['cidadei'];  
}
		
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$cod_im."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci where m.cod = '$cod' and c.c_cod='$compr' and m.cod_imobiliaria='".$cod_im."' and m.cidade_mat=ci.ci_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-profissao-", "<b>$not2[c_prof]</b>", $d_txt);
	$d_txt = str_replace("-rg-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-bairro-", "<b>$not2[c_bairro]</b>", $d_txt);
	$d_txt = str_replace("-cidade-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-cep-", "<b>$not2[c_cep]</b>", $d_txt);
	$d_txt = str_replace("-tel-", "<b>$not2[c_tel]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-local-", "<b>$not2[local]</b>", $d_txt);
	$d_txt = str_replace("-matricula-", "<b>$not2[matricula]</b>", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$not2[ci_nome]</b>", $d_txt);
	
	
$nome_cliente3 = '';

for ($i3 = 0; $i3 < $not2[contador]; $i3++) {

	$query4 = "select * from clientes where c_cod='" . $cliente2[$i3] . "' and cod_imobiliaria='" . $cod_im . "'";

	$result4 = mysql_query($query4);
	$res_clientes = array();
	
	while ($not4 = mysql_fetch_array($result4)) {
	    array_push($res_clientes, $not4[c_nome]);
	}
	
	$res_clientes = implode(" e ", $res_clientes);
	$nome_cliente3 .= empty($nome_cliente3) ? $res_clientes : " e " . $res_clientes;

}

	$d_txt = str_replace("-nome_prop-", "<b>$nome_cliente3</b>", $d_txt);

	
	$ano = date("Y");
	$mes = date("m");
	$dia = date("d");

	$query40 = "SELECT texto_sinal FROM sinal_venda WHERE id_sinal='$id' and cod_imovel='".$cod."' AND cod_imobiliaria='".$cod_im."'";
	$result40 = mysql_query($query40);
	while($not40 = mysql_fetch_array($result40))
	{
	   $proposta = $not40['texto_proposta'];
	}

	$d_txt = str_replace("-proposta-", "<b>$proposta</b>", $d_txt);
	$d_txt = str_replace("-data_hoje-", "<b>$dia/$mes/$ano</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$cod_im."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_resp]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_creci_resp]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
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
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){

?>
<form method="post" action="<?php print("$url"); ?>">
<input type="hidden" name="d_nome" id="d_nome" value="<?php print($not3[d_nome]); ?>">
<input type="hidden" name="cod" id="cod" value="<?php print($cod); ?>">
<input type="hidden" name="compr" id="compr" value="<?php print($compr); ?>">
<input type="hidden" name="codim" id="codim" value="<?php print($codim); ?>">
<input type="hidden" name="cidadeim" id="cidadeim" value="<?php print($cidadeim); ?>">
<input type="hidden" name="ufim" id="ufim" value="<?php print($ufim); ?>">
<input type="hidden" name="impressao" id="impressao" value="1">
<input type="hidden" name="comprador" id="impressao" value="1">
<input type="hidden" name="imp" id="imp" value="7">
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
<p align="left"><b><?php echo($cidade_im); ?>-<?php echo($estado_im); ?>, <?php print("$dia2/$mes2/$ano2"); ?></p></td></tr>
  <tr bgcolor="#EDEEEE">
    <td colspan=2 class="style1"><p>&nbsp;</p><p>&nbsp;</p><p align=left>
    <b>PROPONENTE COMPRADOR(A): _________________________</b></p><p></td>
    </tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p>&nbsp;</p><p>&nbsp;</p><p align=left>
    <b>PROPRIETÁRIO(A): _________________________</b></p><p></td>
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
<?php
	}
	}
	}
	}//Termina imp = 7
//mysql_free_result($result2);
//mysql_free_result($result3);
mysql_close($con);
?>
<?php
/*
	}
	else
	{
*/	  
?>
<?php
//include("login2.php");
?>
<?php
//	}
?>
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
		<input id=idPrint type="button" value="Fechar" class="campo3" onClick="javascript:window.close()">
	  </span></div></td>
    </tr>
</div>
</body>
</html>
<? } ?>