<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include("style.php");
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("IMOV_LISTA");

     $datafo = date("dmY");
	 $horafo = date("His");
?>
<html>

<head>
<META Http-Equiv="Cache-Control" Content="no-cache">
<META Http-Equiv="Pragma" Content="no-cache">
<META Http-Equiv="Expires" Content="0">
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="funcoes/js.js"></script>
	<style media="print">
		.noprint { display: none; }
	</style>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
if($_GET['codi']){
 $codi = $_GET['codi'];
}else{
 $codi = $_POST['codi'];
}

if($codi == $_SESSION['cod_imobiliaria']){
  $codi = $_SESSION['cod_imobiliaria'];
  $pastai = $_SESSION['nome_pasta'];
}elseif($codi == ''){
  $codi = $_SESSION['cod_imobiliaria'];
  $pastai = $_SESSION['nome_pasta'];
}else{
  $codi = $codi;
  $pastai = $pastai;
}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" width="250px"><div align="left">
<?
    $logo_imob = $_SESSION['logo_imob'];
    $caminho_logo = "../logos/";
	if (file_exists($caminho_logo.$logo_imob))
	{
?>
	<img src="<?php print($caminho_logo.$logo_imob); ?>" border="0"></div></td>
<?
	}
	
	$query10 = "SELECT i_nome FROM interessados WHERE i_cod='".$int_cod."'";
	$result10 = mysql_query($query10);
	while($not10 = mysql_fetch_array($result10))
	{
	    $nome_atendimento = $not10['i_nome'];
	}
	
	$sqlInformacoesImobiliaria = "select imb.im_cod, imb.im_tel, imb.im_fax, imb.im_end, imb.im_bairro, imb.im_cep, imb.im_email, imb.im_site, cid.ci_nome, est.e_uf from rebri_imobiliarias imb, rebri_cidades cid, rebri_estados est where imb.im_estado = est.e_cod and imb.im_cidade = cid.ci_cod and im_cod = '$_SESSION[cod_imobiliaria]'";
	$buscaInformacoesImobiliaria = mysql_query($sqlInformacoesImobiliaria);
	$colunaInformacoesImobiliaria = mysql_fetch_array($buscaInformacoesImobiliaria);
?>
   
   
   <td align="left" style="padding-left: 15px;">
<?php
	echo $colunaInformacoesImobiliaria['im_end'].'<br>';
	echo ucwords(strtolower($colunaInformacoesImobiliaria['im_bairro'])).' - ';
	echo ucwords(strtolower($colunaInformacoesImobiliaria['ci_nome'])).'/';
	echo strtoupper($colunaInformacoesImobiliaria['e_uf']).'<br>';
	echo 'CEP: '.$colunaInformacoesImobiliaria['im_cep'].'<br>';
	echo $colunaInformacoesImobiliaria['im_email'].'<br>';
	echo $colunaInformacoesImobiliaria['im_site'].'<br>';
	echo 'Fone: '.$colunaInformacoesImobiliaria['im_tel'].'<br>';
	echo 'Fax: '.$colunaInformacoesImobiliaria['im_fax'];
?>
   </td>
  </tr>
</table>
<table border="0" cellpadding="1" cellspacing="1" width="95%">
  <tr>
    <td colspan="2" valign="bottom" align="left"><br><br><b>Atendente: </b><?=$_SESSION[u_nome]?><br>Atendimento em andamento para: <b><?=$nome_atendimento ?></b><div align="center"></td>
      </tr>
<tr><td colspan="2" align=center>
  <table border="0" cellpadding="0" cellspacing="0" width="95%" align=center>
    <tr>
      <td width="100%">
<table BORDER="0" align="center" CELLPADDING="0" CELLSPACING="1" width=100%>

<?php


	$query1 = "SELECT m.cod, m.ref, m.titulo, it.sid, m.valor, m.carnaval, m.anonovo, m.metragem, m.descricao, m.tipo,
	m.n_quartos, m.finalidade, m.suites, m.dist_tipo, m.dist_mar, m.bairro, m.end, m.numero, i.nome_pasta, i.im_cod, i.im_nome, i.im_img, t.t_nome, ci.ci_nome, e.e_uf 
	FROM muraski m INNER JOIN imoveis_temp it ON (it.cod=m.cod) INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) INNER JOIN rebri_estados e ON (m.uf=e.e_cod) WHERE it.interessado='$int_cod'";
	//echo $sid;
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<tr>
</tr>
<?php
	$i = 1;
	//$total = 0;
	//$peso_total = 0;

	while($not1 = mysql_fetch_array($result1))
	{
		
	$valor2 = number_format($not1[valor], 2, ',', '.');
	$carnaval = number_format($not1[carnaval], 2, ',', '.');
	$anonovo = number_format($not1[anonovo], 2, ',', '.');
	$metragem = str_replace(".",",","$not1[metragem]");
	$descricao = str_replace("\n","<br>","$not1[descricao]");
	$pastai = $not1['nome_pasta'];
	$im_img = $not1['im_img'];
	$finalidade = $not1['finalidade'];
	
		//if($not1[r_ed] == "0"){
		//$r_preco = number_format($r_preco, 2, ',', '.');
		//$p_preco2 = $not1[p_qtd] * $not1[p_preco_promo];
		//}
		//else
		//{
		//$p_preco = number_format($not1[p_preco], 2, ',', '.');
		//$p_preco2 = $not1[p_qtd] * $not1[p_preco];		
		//}
	//$quant = number_format($not1[p_qtd], 2, ',', '.');
	//$peso1 = $not1[p_qtd] * $not1[p_peso];
	//$p_preco3 = number_format($p_preco2, 2, ',', '.');
	//$total = $total;
	//session_register("total");
	//$total_desc = $total * 0.97;
	//$peso_total = $peso1 + $peso_total;

	if (($i % 2) == 1){ $fundo="CCCCCC"; }else{ $fundo="ffffff"; }
	$i++;
?>
<form method="post" id="form1" name="form1" action="carrinho_imoveis_impressao.php">
<input type="hidden" name="cod" value="<?php print("$not1[cod]"); ?>">
<input type="hidden" name="sid" value="<?php print("$sid"); ?>">
<input type="hidden" name="alterar" value="1">
<input type="hidden" name="c_qtd" value="0">

<? if ($i > 2) { ?>
<tr><td height=30></td></tr>
<? } ?>

<tr><td align=center width=160 valign=top>
<table border="0" cellspacing="0" width="158" cellpadding="0" height=142>
<tr><td align=center height=10>
<tr><td align=center>
<?php
            /*
			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$codi."'");
			$row = mysql_fetch_array($result);
			$tmp_pasta = $row['nome_pasta'];
			*/
			/*
			$pasta_fin = strtolower(substr($not1[finalidade], 0, 4));
				if($pasta_fin == "loca"){
			*/
				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
					$pasta_finalidade = "locacao_peq";
				}
				else
				{
					$pasta_finalidade = "venda_peq";
				}
			$pasta = "../imobiliarias/".$pastai."/".$pasta_finalidade."/";
			
			$nome_foto1 = $not1[ref] . "_1_peq" . ".jpg";
	
	if (file_exists($pasta.$nome_foto1))
	{
?>
		<img border="0" src="<?php print($pasta.$nome_foto1."?datafo=$datafo&horafo=$horafo"); ?>">
<?php
	}
	else
	{
?>
		<img border="0" src="images/sem_foto.gif">		   
<?		
	}
?>
</td></tr>
<?php
    //$caminho_logos = "../logos_peq/";
    
    $fotos = explode(".",$im_img);
	$extensao = $fotos[1];
	$nome_foto = $fotos[0]."_peq";
	
	$caminho_logos = "../logos_peq/"; 
   
  	if (file_exists($caminho_logos.$nome_foto.".jpg")){
	    $foto_peq_logo = $nome_foto.".jpg";
	}elseif (file_exists($caminho_logos.$nome_foto.".png")){
  		$foto_peq_logo = $nome_foto.".png";
  	}elseif (file_exists($caminho_logos.$nome_foto.".gif")){
  	  $foto_peq_logo = $nome_foto.".gif";
  	}
    
    
	//if (file_exists($caminho_logos.$foto_peq_logo) and $foto_peq_logo!="")
	//{
?>
              <!--tr>
                <td align="center" valign="top"><img src="<?php print($caminho_logos.$foto_peq_logo); ?>" border="0" /></td>
              </tr-->
<?php
	//}
?>
<tr><td align=left height=10></td></tr>
</table>
</td>
<td align=center>
<table border="0" cellpadding="1" cellspacing="1" width=95% bgcolor=#ffffff>
<tr bgcolor="#ffffff"><td colspan=2>
<table border="0" cellpadding="0" cellspacing="1" width=100%>
<tr bgcolor="#ffffff"><td colspan=2 class="stylec">
<strong>
Ref.: <?php print("$not1[ref]"); ?> - <?php print("$not1[t_nome]"); ?> - <?php print strip_tags($not1[titulo]); ?>
</strong>
</td></tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" width=100%>
<tr><td>
<table border="0" cellpadding="0" cellspacing="1" width=100%>
<?php
	if($not1[metragem] > 0){
?>
<tr bgcolor="#ffffff"><td colspan=2 class="stylec">
Metragem:<b> <?php print("$metragem"); ?> m<sup>2</sup></b>
</td></tr>
<?php
	}
	if($not1[n_quartos] > 0){
?>
<tr bgcolor="#ffffff"><td colspan=2 class="stylec">
Total quartos:<b> <?php print("$not1[n_quartos]"); ?></b>
</td></tr>
<?php
	}
?>
<?php
	if($not1[suites] > 0){
?>
<tr bgcolor="#ffffff"><td colspan=2 class="stylec">
Sendo Suítes: <b><?php print("$not1[suites]"); ?></b>
</td></tr>
<?php
	}
?>
<?php
	if($not1[valor] > 0){
?>
<tr bgcolor="#ffffff"><td colspan=2 class="stylec">
<?php
	//if($not1[finalidade] == "Locação"){
	if($not1[finalidade]=='1' || $not1[finalidade]=='2' || $not1[finalidade]=='3' || $not1[finalidade]=='4' || $not1[finalidade]=='5' || $not1[finalidade]=='6' || $not1[finalidade]=='7' || $not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){
?>
Valor:
<?php
	}
	else
	{
?>
Diária:
<?php
	}
?> <b>R$ <?php print("$valor2"); ?></b><br>
<?php
	//if($not1[finalidade] == "Locação"){
    if($not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14' || $not1[finalidade]=='15' || $not1[finalidade]=='16' || $not1[finalidade]=='17'){
?>
<?php
	if($not1[carnaval] > 0){
?>
Carnaval: R$ <?php print("$carnaval"); ?><br>
<?php
	}
?>
<?php
	if($not1[anonovo] > 0){
?>
Ano Novo: R$ <?php print("$anonovo"); ?><br>
<?php
	}
?>
<?php
	}
?>
</td></tr>
<tr>
	<td colspan="2" align="left" class="stylec">
<?
		if($not1[finalidade]=='1' || $not1[finalidade]=='2' || $not1[finalidade]=='3' || $not1[finalidade]=='4' || $not1[finalidade]=='5' || $not1[finalidade]=='6' || $not1[finalidade]=='7' || $not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){
		  	$mostra = " O valor ";
		}else{
		  	$mostra = "A diária ";
		}
?>
		*<?=$mostra ?>pode ser alterado sem aviso pr&eacute;vio.
	</td>
</tr>
<?php
	}
?>
<?php
	if($not1[dist_mar] > 0){
?>
<tr bgcolor="#ffffff"><td colspan=2 class="stylec">
Distância do mar: <b><?php print("$not1[dist_mar] $not1[dist_tipo]"); ?></b>
</td></tr>
<?php
	}
?>
<tr bgcolor="#ffffff"><td colspan=2 class="stylec">
Endereço: <b>
<?php
print( $not1['end']." , ".$not1['numero']);
?>
<tr bgcolor="#ffffff"><td colspan=2 class="stylec">
Bairro(s): <b>
<?
$bairro10 = explode("--", $not1['bairro']);
$bairro20 = str_replace("-","",$bairro10);
		
foreach ($bairro20 as $k => $bairro) {
	$bairro20[$k] = "'" . $bairro . "'";
}
		
	$b_bairro2 = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro20) . ") ORDER BY b_nome ASC");
	while($linha2=mysql_fetch_array($b_bairro2)){
		echo $linha2['b_nome']." "; 
	}


?></b>
</td></tr>
<tr bgcolor="#FFFFFF"><td colspan=2 class="stylec">
Localização: <b><?php print("$not1[ci_nome]"); ?> - <?php print("$not1[e_uf]"); ?></b><br><? if($not1[im_cod] <> $_SESSION['cod_imobiliaria']){ echo "Parceria";  } ?>
</td></tr>
</table></td>
</td></table>
<table>
<tr bgcolor="#ffffff"><td colspan=2 class="stylec">
<p align=justify>
<?php print strip_tags($descricao,"<br>"); ?>
</td></tr></table>
</td></tr></table>
</td>
</tr></form>
<?php
	}
	//$total = number_format($total, 2, ',', '.');
	//$total_desc = number_format($total_desc, 2, ',', '.');
?>
<tr>
<td colspan=2 class="stylec noprint">
<b>Total de <?php $total = $i - 1; print("$total"); ?> imóveis selecionados</td>
</tr>
<?php
mysql_free_result($result1);
	}//Termina o carrinho se existe a seção e não selecionou produtos
	else
	{
?>
<tr bgcolor="#<?php print("$cor14"); ?>">
<td colspan="4" align=center class="stylec"><b>Sua lista de imóveis ainda está vazia!</td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="4" align=center class="stylec"><a href="index.php" class="stylec noprint">Clique aqui para continuar navegando.</a></td>
</tr>
<?php
	}
?>
      </td>
    </tr>
  </table>

</td></tr>
  <div class=noprint>
	<tr>
	  <td colspan="7"><div align="center"><span class="stylec">
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	  </span></div></td>
    </tr>
</div>
	<tr>
	  <td colspan="7" height=20></td>
    </tr>
	<tr>
	  <td colspan="7"><div align="center"><span class="stylec">Rede Brasileira de Imóveis<BR />
         <a href="http://www.redebrasileiradeimoveis.com.br" class="style1">www.redebrasileiradeimoveis.com.br</a>
	  </span></div></td>
    </tr>
</table>
<?
	//}## fim while conta imoveis
	//mysql_free_result($result1);
	//mysql_free_result($result2);
	mysql_close($con);

## se não tem sessao
/*
} else {
	print "Área protegida!";
}
*/
?>
</body>

</html>