<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("BANCO_GERAL");
//include("regra.php");
		
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<br>
<?php

if(($B1 == "Apagar Banco") and ($c_banco != ""))
	{
	
	$query = "select * from clientes where c_banco = '$c_banco' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	
	if($numrows > 0){
?>
Este banco não pode ser apagado, existem clientes vinculados a ele!<br>
<?php
  }
  else
  {
	$query = "delete from bancos where b_cod = '$b_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
Você apagou o banco.
<?php
  }
	}
if($lista == "")
	{
		
	if ($screen == "") {
   		$screen = 1;
	}

	$from = ($screen - 1) * 30;
	//Início da pesquisa

	$query1 = "select * from bancos where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by b_nome limit $from,30";
	//echo $query1;
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor3"); ?>" border="0" cellspacing="1" width=100%>
<tr><td bgcolor="#<?php print("$cor1"); ?>" align="center" class=style1 colspan=2>
Para excluir um banco, clique sobre o nome correspondente a seguir.</td></tr>
<tr>
<td width=200 bgcolor="#<?php print("$cor1"); ?>" align="center" class="style1"><b>Nome
</td>
<td bgcolor="#<?php print("$cor1"); ?>"></td>
</tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
		
	if (($i % 2) == 1){ $fundo="$cor6"; }else{ $fundo="$cor1"; }
	$i++;
?>
<tr>
<td bgcolor="<?php print("$fundo"); ?>" align="left" class=style1>
<?php print("$not[b_nome]"); ?></td>
<td bgcolor="<?php print("$fundo"); ?>" align="left">
<a href="p_exc_bancos.php?b_cod=<?php print("$not[b_cod]"); ?>&c_banco=<?php print("$not[b_nome]"); ?>&B1=Apagar Banco" class=style1>
Apagar Tipo</a></td>
</tr>
<?php
	}

	$query3 = "select count(b_cod) as contador from bancos where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	
	while($not3 = mysql_fetch_array($result3))
	{

		$paginas = $pages = ceil($not3[contador] / 30);
    	$pagina = $screen;
    	$url = "p_exc_bancos.php?&screen=";
	
	
?>
                  <tr>
				  	<td bgcolor="#<?php print("$cor3"); ?>" colspan=2 class="style1" align="center">Foram encontrados <?php print("$not3[contador]"); ?> banco(s)</td>
				  </tr>
                  <tr>
				  	<td bgcolor="#<?php print("$cor1"); ?>" colspan=2 class="style1" align="center" class="style1">
				  		<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_exc_bancos.php?screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_exc_bancos.php?screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
                  				<td width="10%" class="style1" align="center"><a href="p_int.php?screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_int.php?screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>
                  </td></tr>
<?php
	}
?>
<tr>
<td colspan=8 align=center class="style1"><input type="button" name="fechar" id="fechar" class="campo3" value="Fechar Janela" Onclick="window.close();"></td>
</tr>
</table>
<p>
<?php
	}
?>
<?php
mysql_close($con);
?>
<?php
//include("carimbo.php");
?>
</body>
</html>