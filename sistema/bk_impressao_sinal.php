<?php
session_start();
include("conect.php");
include("l_funcoes.php");
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
	
	$query4 = "select * from clientes where c_cod='$not2[cliente]' and cod_imobiliaria='".$cod_im."'";
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
	if($impressao == ""){

?>
<form method="post" action="<?php print("$PHP_SELF"); ?>">
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
<? } ?>		
		<input id=idPrint type="button" value="Fechar" class="campo3" onClick="javascript:window.close()">
	  </span></div></td>
    </tr>
</div>
</body>
</html>