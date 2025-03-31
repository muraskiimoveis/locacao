<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("IMOV_PESQ");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
?>
<?php
	if ($screen == "") {
   		$screen = 1;
	}

	$from = ($screen - 1) * 30;
	
	$finalidade = $_GET['finalidade'];
	$angariador = $_GET['angariador'];
	$tipo_anga = $_GET['tipo_anga'];
	$tipo1 = $_GET['tipo1'];
	if($tipo1<>'%'){
	   $query_tipo = " and tipo='$tipo1'";
	}
	
    if($finalidade=='7'){
	  $query_finalidade = " AND (finalidade='1' OR finalidade='2' OR finalidade='3' OR finalidade='4' OR finalidade='5' OR finalidade='6' OR finalidade='7')";
	}elseif($finalidade=='14' || $finalidade=='17'){
	  $query_finalidade = " AND (finalidade='8' OR finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR finalidade='17')";
	}elseif($finalidade<>'%'){
	  $query_finalidade = "AND finalidade='".$finalidade."'";
	}else{
	  $query_finalidade = "AND finalidade like '%'";
	}   
    
if($lista == "")
	{

	if($list == ""){
	$query1 = "select * from muraski where tipo='$tipo1' $query_finalidade AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	order by ref limit $from, 30";
	}else{
	if($campo == "data_fim"){
	$ano = substr ($chave, 6, 4);
	$mes = substr($chave, 3, 2 );
	$dia = substr ($chave, 0, 2 );
	$chave = "$ano-$mes-$dia";
	//print("$chave");
	
	$query1 = "select * from muraski where data_fim >= '$ano-$mes-$dia' and 
	data_fim < date_add('$ano-$mes-$dia', interval 30 day) $query_finalidade and angariador like '$angariador' and 
	tipo_anga like '$tipo_anga' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by data_fim, ref limit $from, 30";
	
	}
	else
	{
	  if($campo=='m.end'){
	   $busca = "m.tipo_logradouro like '%$tipo_logradouro%' AND m.end like '%$end%' AND m.numero LIKE '%$numero_end%'";
	}else{
	   $busca = "$campo like '%$chave%'";
	}


	$query1 = "select * from muraski where $busca $query_finalidade $query_tipo and angariador like '$angariador' and
	tipo_anga like '$tipo_anga' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by ref limit $from, 30";
	}//data_fim
	}//list
	echo $query1;
    //die();
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	echo "<br>";
	//print_r(mysql_fetch_array($result1));
	print_r($numrows1);
	//die();
	    $btipo = mysql_query("SELECT t_nome FROM rebri_tipo WHERE t_cod='".$tipo1."'");
		while($linha = mysql_fetch_array($btipo)){
       		$tipo = $linha['t_nome'];
	  	}
?>
<div align="center">
  <center>
                  <table width="75%" cellpadding="1" cellspacing="1">
                  <tr><td height="50" colspan="8" class="style1">
                  <p align="center"><b><?php if(empty($tipo)){ echo 'Todos';}else {print("$tipo");}?></b></td></tr>
                  <tr class="fundoTabelaTitulo">
                   <td class=style1><b>Ref.</b></td>
                   <td class=style1><b>Metragem</b></td>
                   <td class=style1><b>Valor</b></td>
                   <td class=style1><b>Finalidade</b></td>
                   <td class=style1><b>Data T�rmino</b></td>
<?
if ($_SESSION[im_site_padrao] == "S" || $_SESSION[cod_imobiliaria] == "3") {
?>
                   <td class=style1><b>Lan�amento</b></td>
<?
}
?>
                   <td class=style1><b>Destaque Rebri</b></td>
<?
if ($_SESSION[im_site_padrao] == "S" || $_SESSION[cod_imobiliaria] == "3") {
?>
                   <td class=style1><b>Destaque Site Padr�o</b></td>
<?
}
?>
                  </tr>
<?php
	if($numrows1 > 0){
?>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{

	$valor = number_format($not[valor], 2, ',', '.');

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	
	$ano1 = substr ($not[data_fim], 0, 4);
	$mes1 = substr($not[data_fim], 5, 2 );
	$dia1 = substr ($not[data_fim], 8, 2 );
?>
<?
if($not[finalidade]=='1'){
  $fin = "Venda_Rebri";
}elseif($not[finalidade]=='2'){
  $fin = "Venda_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='3'){
  $fin = "Venda_Parceria";
}elseif($not[finalidade]=='4'){
  $fin = "Venda_Terceiros";
}elseif($not[finalidade]=='5'){
  $fin = "Venda_Off";
}elseif($not[finalidade]=='6'){
  $fin = "Venda_Vendido";
}elseif($not[finalidade]=='7'){
  $fin = "Venda_Todos";
}elseif($not[finalidade]=='8'){
  $fin = "Loca��o_Anual_Rebri";
}elseif($not[finalidade]=='9'){
  $fin = "Loca��o_Anual_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='10'){
  $fin = "Loca��o_Anual_Parceria";
}elseif($not[finalidade]=='11'){
  $fin = "Loca��o_Anual_Terceiros";
}elseif($not[finalidade]=='12'){
  $fin = "Loca��o_Anual_Off";
}elseif($not[finalidade]=='13'){
  $fin = "Loca��o_Anual_Locado";
}elseif($not[finalidade]=='14'){
  $fin = "Loca��o_Anual_Todos";
}elseif($not[finalidade]=='15'){
  $fin = "Loca��o_Temporada_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='16'){
  $fin = "Loca��o_Temporada_Off";
}elseif($not[finalidade]=='17'){
  $fin = "Loca��o_Temporada_Todos";
}
?>
<tr class="<?php print("$fundo"); ?>"><td class="<?php if($not[valor_oferta] > 0){ echo "style7"; }else{ echo "style1"; } ?>">
<a class="<?php if($not[valor_oferta] > 0){ echo "style7"; }else{ echo "style1"; } ?>" href="p_edit_imoveis.php?cod=<?php print("$not[cod]"); ?>&edit=editar"><?php print("$not[ref]"); ?></a></td><td class="<?php if($not[valor_oferta] > 0){ echo "style7"; }else{ echo "style1"; } ?>">
<?php print("$not[metragem]"); ?></td><td class="<?php if($not[valor_oferta] > 0){ echo "style7"; }else{ echo "style1"; } ?>">
<?php print("$valor"); ?></td><td class="<?php if($not[valor_oferta] > 0){ echo "style7"; }else{ echo "style1"; } ?>">
<?php print($fin); ?></td><td class="<?php if($not[valor_oferta] > 0){ echo "style7"; }else{ echo "style1"; } ?>">
<?php print("$dia1/$mes1/$ano1"); ?></td>
<? if ($_SESSION[im_site_padrao] == "S" || $_SESSION[cod_imobiliaria] == "3") { ?>
<td class="<?php if($not[valor_oferta] > 0){ echo "style7"; }else{ echo "style1"; } ?>" align=center><? if ($not[lancamento] == "1") { print "<strong>Sim</strong>"; } else { print "N�o"; }?> </td>
<? } ?>
<td class="<?php if($not[valor_oferta] > 0){ echo "style7"; }else{ echo "style1"; } ?>" align=center><? if ($not[destaque] == "1") { print "<strong>Sim</strong>"; } else { print "N�o"; }?> </td>
<? if ($_SESSION[im_site_padrao] == "S" || $_SESSION[cod_imobiliaria] == "3") { ?>
<td class="<?php if($not[valor_oferta] > 0){ echo "style7"; }else{ echo "style1"; } ?>" align=center><? if ($not[destaque_padrao] == "1") { print "<strong>Sim</strong>"; } else { print "N�o"; }?> </td>
<? } ?>

</tr>
<?php
	}
	}
?>
<tr><td colspan="8" class="fundoTabela style1">
*Im�veis em vermelho est�o cadastrados com valor em oferta</td></tr>
<?php
	if($list == ""){
	$query2 = "select count(cod) as contador 
	from muraski where tipo='$tipo1' $query_finalidade AND angariador like '$angariador' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}else{

	 if($campo=='m.end'){
	   $busca = "m.tipo_logradouro like '%$tipo_logradouro%' AND m.end like '%$end%' AND m.numero LIKE '%$numero_end%'";
	}else{
	   $busca = "$campo like '%$chave%'";
	}  
	  
	$query2 = "select count(cod) as contador 
	from muraski where $busca $query_finalidade $query_tipo  AND angariador like '$angariador' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$paginas = $pages = ceil($not2[contador] / 30);
    $pagina = $screen;
    $url = "p_lista_edit.php?tipo1=".$tipo1."&campo=".$campo."&chave=".$chave."&query_finalidade=".$query_finalidade."&query_tipo=".$query_tipo."&finalidade=".$finalidade."&angariador=".$angariador."&tipo_anga=".$tipo_anga."&tipo_logradouro=".$tipo_logradouro."&end=".$end."&numero_end=".$numero_end."&busca=".$busca."&list=".$list."&screen=";
?>
                  <tr>
				  	<td colspan="8" class="fundoTabelaTitulo style1" align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> im�veis</b></td>
				  </tr>
                  <tr>
				  	<td colspan="8" align="center" class="style1">
				  		<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_lista_edit.php?tipo1=<?=$tipo1 ?>&campo=<?=$campo?>&chave=<?=$chave ?>&query_finalidade=<?=$query_finalidade ?>&query_tipo=<?=$query_tipo ?>&finalidade=<?=$finalidade ?>&angariador=<?=$angariador ?>&tipo_anga=<?=$tipo_anga ?>&tipo_logradouro=<?=$tipo_logradouro ?>&end=<?=$end ?>&numero_end=<?=$numero_end ?>&busca=<?=$busca ?>&list=<?=$list ?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_lista_edit.php?tipo1=<?=$tipo1 ?>&campo=<?=$campo?>&chave=<?=$chave ?>&query_finalidade=<?=$query_finalidade ?>&query_tipo=<?=$query_tipo ?>&finalidade=<?=$finalidade ?>&angariador=<?=$angariador ?>&tipo_anga=<?=$tipo_anga ?>&tipo_logradouro=<?=$tipo_logradouro ?>&end=<?=$end ?>&numero_end=<?=$numero_end ?>&busca=<?=$busca ?>&list=<?=$list ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
                  				<td class="style1" align="center">
								<?
   									$i = 0;
   									$completa = "";
   									if ($paginas > 9){
      									if ($pagina < 5){
   	   										$inicio = 1;
         									$final = 9;
      									}elseif($pagina > $paginas - 5){
   	   										$inicio = $paginas - 9;
         									$final = $paginas;
      									}else{
   	   										$inicio = $pagina - 4;
         									$final = $pagina + 4;
      									}
   									}else{
	   										$inicio = 1;
      										$final = $paginas;
   									}

   									for ($j = $inicio; $j < ($final+1); $j++){
      									if(($paginas > 9) && (strlen($j)==1)){
		   									$j = "0".$j;
      									}

      									$url2 = $url . $j;

      									if($j == $pagina){
            								print "<a href=\"$url2\" class='style1'>| <b>$j</b> |</a>";
 	   									}else{
     	      								print "<a href=\"$url2\" class='style1'>| $j |</a>";
  	   									}
   									}
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="p_lista_edit.php?tipo1=<?=$tipo1 ?>&campo=<?=$campo?>&chave=<?=$chave ?>&query_finalidade=<?=$query_finalidade ?>&query_tipo=<?=$query_tipo ?>&finalidade=<?=$finalidade ?>&angariador=<?=$angariador ?>&tipo_anga=<?=$tipo_anga ?>&tipo_logradouro=<?=$tipo_logradouro ?>&end=<?=$end ?>&numero_end=<?=$numero_end ?>&busca=<?=$busca ?>&list=<?=$list ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Pr�xima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_lista_edit.php?tipo1=<?=$tipo1 ?>&campo=<?=$campo?>&chave=<?=$chave ?>&query_finalidade=<?=$query_finalidade ?>&query_tipo=<?=$query_tipo ?>&finalidade=<?=$finalidade ?>&angariador=<?=$angariador ?>&tipo_anga=<?=$tipo_anga ?>&tipo_logradouro=<?=$tipo_logradouro ?>&end=<?=$end ?>&numero_end=<?=$numero_end ?>&busca=<?=$busca ?>&list=<?=$list ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| �ltima |<?}?></a></td>
               				</tr>
   						</table>

<?php
	}
?>

<?	
	}
/*
mysql_free_result($result1);
mysql_free_result($result2);
*/
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
<?  if(session_is_registered("valid_user")){ ?>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("voltar.php"); ?>
    </td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td align="center" class="style1">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
</body>
</html>