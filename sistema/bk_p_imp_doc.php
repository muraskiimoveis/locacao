<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
include("funcoes/funcoes.php");
verificaAcesso();
verificaArea("DOCS");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
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

	if($imp == "2"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query2 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and cliente=c_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-rg-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-tel-", "<b>$not2[c_tel]</b>", $d_txt);
	$d_txt = str_replace("-cid_imov-", "<b>$not2[local]</b>", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);

	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );

	$d_txt = str_replace("-data_inicio-", "<b>$dia/$mes/$ano</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$dia1/$mes1/$ano1</b>", $d_txt);
	
	$diaria1 = number_format($not2[diaria1], 2, ',', '.');
	$diaria2 = number_format($not2[diaria2], 2, ',', '.');
	$comissao = number_format($not2[comissao], 2, ',', '.');
	
	$d_txt = str_replace("-diaria1-", "<b>$diaria1</b>", $d_txt);
	$d_txt = str_replace("-diaria2-", "<b>$diaria2</b>", $d_txt);
	$d_txt = str_replace("-comissao-", "<b>$not2[comissao]</b>", $d_txt);
	$d_txt = str_replace("-conta-", "<b>$not2[c_conta]</b>", $d_txt);
	
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
  <table border="0" cellspacing="1" width="100%" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	if($impressao == ""){
?>
<form method="post" action="<?php print("$PHP_SELF"); ?>">
<input type=hidden name=d_nome value=<?php print("$not3[d_nome]"); ?>>
<input type=hidden name=cod value=<?php print("$cod"); ?>>
<input type=hidden name=impressao value=1>
<input type=hidden name=imp value=2>
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
	}//Termina imp = 2
	elseif($imp == "5"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	$d_txt = str_replace("-prof_prop-", "<b>$not2[c_prof]</b>", $d_txt);
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
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	if($impressao == ""){
?>
<form method="post" action="<?php print("$PHP_SELF"); ?>">
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
<?php
	}
	}
	}
	}//Termina imp = 5
	elseif($imp == "4"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query2 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and cliente=c_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	
	$ano = date(Y);
	$mes = date(m);
	$dia = date(d);

	$d_txt = str_replace("-data_hoje-", "<b>$dia/$mes/$ano</b>", $d_txt);
	
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
	if($impressao == ""){
?>
<form method="post" action="<?php print("$PHP_SELF"); ?>">
<input type=hidden name=d_nome value=<?php print("$not3[d_nome]"); ?>>
<input type=hidden name=cod value=<?php print("$cod"); ?>>
<input type=hidden name=impressao value=1>
<input type=hidden name=imp value=4>
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
  </table>
<?php
	}
	}
	}
	}//Termina imp = 4
	elseif($imp == "7"){
		if($comprador == ""){
			//echo $comprador;
			//echo $cod;
?>
<p></p>
    <form method="get" action="<?php print("$PHP_SELF"); ?>">
    <input type=hidden name=imp value=7>
    <input type=hidden name=cod value=<?php print("$cod"); ?>>
    <input type=hidden name=comprador value=1>
    <b>Fazer proposta de compra:</b><br><br>
    <select name=compr class=campo>
    <option selected>Selecione um comprador
<?php
	$query1 = "select c_cod, c_nome, c_tipo from clientes where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	order by c_tipo, c_nome, c_cod";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	while($not1 = mysql_fetch_array($result1))
	{
	 $c_nome = substr ($not1[c_nome], 0, 30);
?>
	<option value=<?php print("$not1[c_cod]"); ?> title="<?php print($not1['c_nome'].' - '.$not1['c_tipo']); ?>"><?php print($c_nome.'... - '.$not1['c_tipo']); ?></option>
<?php
	}
?>
	</select><br><br>
	<textarea rows="5" class="campo" name="proposta" cols="36">Escreva aqui a proposta</textarea><br><br>
	<input type=submit name=B1 value=Proposta class=campo3></form>
<?php
	}
	//echo $comprador;
	//echo $cod;
		
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci where m.cod = '$cod' and c.c_cod='$compr' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cidade_mat=ci.ci_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
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
	
	$query4 = "select * from clientes where c_cod='$not2[cliente]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	
	while($not4 = mysql_fetch_array($result4))
	{
	$d_txt = str_replace("-nome_prop-", "<b>$not4[c_nome]</b>", $d_txt);
	}
	
	$ano = date(Y);
	$mes = date(m);
	$dia = date(d);

	$d_txt = str_replace("-proposta-", "<b>$proposta</b>", $d_txt);
	$d_txt = str_replace("-data_hoje-", "<b>$dia/$mes/$ano</b>", $d_txt);
	
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
	if($impressao == ""){
?>
<form method="post" action="<?php print("$PHP_SELF"); ?>">
<input type=hidden name=d_nome value=<?php print("$not3[d_nome]"); ?>>
<input type=hidden name=cod value=<?php print("$cod"); ?>>
<input type=hidden name=compr value=<?php print("$compr"); ?>>
<input type=hidden name=impressao value=1>
<input type=hidden name=comprador value=1>
<input type=hidden name=imp value=7>
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
	elseif($imp == "9"){ //Contrato de Locação
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query2 = "select * from muraski, clientes, rebri_tipo where muraski.cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente=clientes.c_cod and muraski.tipo=rebri_tipo.t_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
		
	$d_txt = str_replace("-nome_prop-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem_prop-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil_prop-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-naci_prop-", "<b>$not2[c_nacionalidade]</b>", $d_txt);
	$d_txt = str_replace("-prof_prop-", "<b>$not2[c_profissao]</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-tel_prop-", "<b>$not2[c_tel]</b>", $d_txt);
	$d_txt = str_replace("-cel_prop-", "<b>$not2[c_cel]</b>", $d_txt);
	$d_txt = str_replace("-email_prop-", "<b>$not2[c_email]</b>", $d_txt);
	$d_txt = str_replace("-cep_prop-", "<b>$not2[c_cep]</b>", $d_txt);
	$d_txt = str_replace("-cid_imov-", "$not2[local]", $d_txt);
	$d_txt = str_replace("-end_imov-", "$not2[end]", $d_txt);
	$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "$not2[titulo]", $d_txt);
	$d_txt = str_replace("-acomod-", "$not2[acomod]", $d_txt);
	

	$diaria2 = number_format($not2[diaria2], 2, ',', '.');
	
	$query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod 
	and l_cod='$l_cod'";
	//echo $query4;
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);

	while($not4 = mysql_fetch_array($result4))
	{
	$total = $not4[l_total] + $not4[l_limpeza];
	$total_extenso = extenso($total);
	//$total = $not4[l_total];
	$total_final = number_format($total, 2, ',', '.');
	$total_final_extenso = extenso($total_final);
	$total = number_format($not4[l_total], 2, ',', '.');
	$limpeza = number_format($not4[l_limpeza], 2, ',', '.');
	$tv = number_format($not4[l_tv], 2, ',', '.');
	
	$total_manu_extenso = extenso($tv);
	
	$ano = substr ($not4[l_data_ent], 0, 4);
	$mes = substr($not4[l_data_ent], 5, 2 );
	$dia = substr ($not4[l_data_ent], 8, 2 );
	$ano1 = substr ($not4[l_data_sai], 0, 4);
	$mes1 = substr($not4[l_data_sai], 5, 2 );
	$dia1 = substr ($not4[l_data_sai], 8, 2 );
	
	$data_ent = "$dia/$mes/$ano";
	$data_sai = "$dia1/$mes1/$ano1";

	$data = mktime(0,0,0, $mes, $dia, $ano);
	$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);
	
	$total_dias = round((($data1 - $data)/(24*60*60)));
	$total_dias = $total_dias + 1;
	
	$d_txt = str_replace("-total_dias-", "<b>$total_dias</b>", $d_txt);
	$d_txt = str_replace("-data_ent-", "<b>$data_ent</b>", $d_txt);
	$d_txt = str_replace("-data_sai-", "<b>$data_sai</b>", $d_txt);
	$d_txt = str_replace("-total_final-", "<b>$total_final</b>", $d_txt);
	$d_txt = str_replace("-total_final_extenso-", "<b>$total_final_extenso</b>", $d_txt);
	$d_txt = str_replace("-total_manu-", "<b>$total_manu</b>", $d_txt);
	$d_txt = str_replace("-total_manu_extenso-", "<b>$total_manu_extenso</b>", $d_txt);
	$d_txt = str_replace("-total-", "<b>$total</b>", $d_txt);
	$d_txt = str_replace("-total_extenso-", "<b>$total_extenso</b>", $d_txt);
	$d_txt = str_replace("-limpeza-", "<b>$limpeza</b>", $d_txt);
	$d_txt = str_replace("-limpeza-", "", $d_txt);
	$d_txt = str_replace("-tv-", "<b>$tv</b>", $d_txt);
	$d_txt = str_replace("-l_pagto-", "<b>$not4[l_pagto]</b>", $d_txt);
	$d_txt = str_replace("-nome_loc-", "<b>$not4[c_nome]</b>", $d_txt);
	$d_txt = str_replace("-origem_loc-", "<b>$not4[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil_loc-", "<b>$not4[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-rg_loc-", "<b>$not4[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf_loc-", "<b>$not4[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end_loc-", "<b>$not4[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cep_loc-", "<b>$not4[c_cep]</b>", $d_txt);
	$d_txt = str_replace("-cidade_loc-", "<b>$not4[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-tel_loc-", "<b>$not4[c_tel], $not4[c_cel]</b>", $d_txt);
	//$d_txt = str_replace("-usuario-", "$not4[l_usuario]", $d_txt);
	
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
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);  
	$d_txt = str_replace("-bairro_im-", "<b>$linha[im_bairro]</b>", $d_txt);  
	}
	}

$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
	<style media="print">
		.noprint { display: none }
	</style>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	if($impressao == ""){
?>
<form method="post" action="<?php print("$PHP_SELF"); ?>">
<input type=hidden name=d_nome value=<?php print("$not3[d_nome]"); ?>>
<input type=hidden name=cod value=<?php print("$cod"); ?>>
<input type=hidden name=l_cod value=<?php print("$l_cod"); ?>>
<input type=hidden name=impressao value=1>
<input type=hidden name=imp value=9>
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
    <b>LOCATÁRIO: _________________________</b></p><p></td>
    <td width="50%" class="style1"><p>&nbsp;</p><p>&nbsp;</p><p align=left>
    <b>LOCADOR: _________________________</b></p><p></td>
    </tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p>&nbsp;</p><p>&nbsp;</p><p align=left>
    <b>TESTEMUNHA: _________________________</b></p><p></td>
    <td width="50%" class="style1"><p>&nbsp;</p><p>&nbsp;</p><p align=left>
    <b>TESTEMUNHA: _________________________</b></p><p></td>
    </tr>
	  <tr bgcolor="#EDEEEE">
    <td colspan="2" class="style1">Usuário (uso interno): <?php print("$not4[l_usuario]"); ?></td>
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
	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4
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
</body>
</html>