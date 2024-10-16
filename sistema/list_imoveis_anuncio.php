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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	  
?>
<p>
<?php
    $idi = $_GET['idi'];
    $finalidade = $_GET['finalidade'];

	if ($screen == "") {
   		$screen = 1;
	}

	$from = ($screen - 1) * 30;
     
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
	$query1 = "select * from muraski where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by ref limit $from, 30";
	}
	else
	{
	
	if($finalidade<>''){
		$query1 = "select * from muraski where $campo like '%$chave%' $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by ref limit $from, 30";
	}else{
		$query1 = "select * from muraski where $campo like '%$chave%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by ref limit $from, 30";	  
	}

	}//list
	//echo $query1;
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<div align="center">
  <center>
                  <table width="600" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
  <form method="get" action="list_imoveis_anuncio.php">
  <input type="hidden" value="<?=$idi ?>" name="idi" id="idi">
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td colspan=4 class="style1"><b>Palavra Chave:</b> <input type="text" class="campo" name="chave" size="15"> <select name="campo" class="campo">
      <option value="ref">Referência</option>
      <option value="titulo">Título</option>
      <option value="descricao">Descrição</option>
      <option value="end">Endereço do Imóvel</option>
      </select> <select name="finalidade" class="campo">
          <option value="">Selecione uma op&ccedil;&atilde;o</option>
          <?php
        $bfinalidade = mysql_query("select f_cod, f_nome FROM finalidade ORDER BY f_cod ASC");
 		while($linha = mysql_fetch_array($bfinalidade)){
			if($linha[f_cod]==$_POST['finalidade']){
			   if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>'); 
			   }else{
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'</option>'); 
			   }
			}else{
			  if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>');
			  }else{
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'</option>');
			  } 
			}
        }
 	    ?>
 	    <option value="%">Todos</option>
      </select>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
      <input type="submit" value="Pesquisar Imóvel" name="B1" class=campo3></td>
    </tr>
  </form>
  <tr><td bgcolor="#cccccc" colspan=5 class="style1">
<p align="center"><b>
Relação de Imóveis</b>
</td></tr>
                  <!--tr><td colspan="4" bgcolor="#<?php// print("$cor6"); ?>">
                  <p align="right"><b>
                  <i><?php// print("$tipo1"); ?></i></b></td></tr-->
                  <tr bgcolor="#<?php print("$cor6"); ?>"><td class=style1>
                  <b>Ref.</b></td><td class=style1>
                  <b>Endereço</b></td><td class=style1>
                  <b>Finalidade</b></td><td class=style1>
                  <b></b></td></tr>
<?php
	if($numrows1 > 0){
?>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{

	$valor = number_format($not[valor], 2, ',', '.');
	
	if (($i % 2) == 1){ $fundo="f2f2f2"; }else{ $fundo="EDEEEE"; }
	$i++;
	
	$ano1 = substr ($not[data_fim], 0, 4);
	$mes1 = substr($not[data_fim], 5, 2 );
	$dia1 = substr ($not[data_fim], 8, 2 );
	$titulo = str_replace("\"","","$not[titulo]");
	
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
  $fin = "Locação_Anual_Rebri";
}elseif($not[finalidade]=='9'){
  $fin = "Locação_Anual_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='10'){
  $fin = "Locação_Anual_Parceria";
}elseif($not[finalidade]=='11'){
  $fin = "Locação_Anual_Terceiros";
}elseif($not[finalidade]=='12'){
  $fin = "Locação_Anual_Off";
}elseif($not[finalidade]=='13'){
  $fin = "Locação_Anual_Locado";
}elseif($not[finalidade]=='14'){
  $fin = "Locação_Anual_Todos";
}elseif($not[finalidade]=='15'){
  $fin = "Locação_Temporada_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='16'){
  $fin = "Locação_Temporada_Off";
}elseif($not[finalidade]=='17'){
  $fin = "Locação_Temporada_Todos";
}
?>
<tr bgcolor="<?php print("$fundo"); ?>">
	<td class=style1>
<?php print("$not[ref]"); ?></td><td class=style1>
<?php print $not[tipo_logradouro]; ?> <?php print $not[end]; ?> , <?php print $not[numero]; ?></td><td class=style1>
<?php print($fin); ?></td><td class=style1>
<input type="button" onClick="window.opener.document.form1.nome_imovel_<?php echo($idi); ?>.value='<?php print("Ref.: $not[ref] - ".strip_tags($titulo).""); ?>'; window.opener.document.form1.co_imovel_<?php echo($idi); ?>.value='<?php print("$not[cod]"); ?>'; window.opener.focus(); window.close();" class="campo3" value="Selecionar"></td>
<!--a href="#" onClick="window.opener.document.form1.nome_imovel_<?php echo($idi); ?>.value='<?php print("Ref.: $not[ref] - ".strip_tags($titulo).""); ?>'; window.opener.document.form1.co_imovel_<?php echo($idi); ?>.value='<?php print("$not[cod]"); ?>'; window.opener.focus(); window.close();" class="style1">Selecionar</a></td-->
</tr>
<?php
	}
	}
	
	if($list == ""){
		$query2 = "select count(cod) as contador 
		from muraski where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}else{
	  	if($finalidade<>''){
			$query2 = "select count(cod) as contador 
			from muraski where $campo like '%$chave%' $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		}else{
		  	$query2 = "select count(cod) as contador 
			from muraski where $campo like '%$chave%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		}
	}
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{		
		$paginas = $pages = ceil($not2[contador] / 30);
    	$pagina = $screen;
    	$url = "list_imoveis_anuncio.php?list=".$list."&tipo1=".$tipo1."&campo=".$campo."&chave=".$chave."&query_finalidade=".$query_finalidade."&finalidade=".$finalidade."&idi=".$idi."&screen=";
?>
                  <tr>
				  	<td colspan="4" bgcolor="#<?php print("$cor6"); ?>" align=center class="style1">Foram encontrados <?php print("$not2[contador]"); ?> imóveis</td>
				  </tr>
                  <tr bgcolor="#<?php print("$cor1"); ?>">
				  	<td colspan="4" align="center" class="style1">
				  		<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="list_imoveis_anuncio.php?list=<?=$list ?>&tipo1=<?=$tipo1 ?>&campo=<?=$campo ?>&chave=<?=$chave ?>&query_finalidade=<?=$query_finalidade ?>&finalidade=<?=$finalidade ?>&idi=<?=$idi ?>&screen=1" class="style7"><? if ($screen > 1) { ?>|Primeira|<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="list_imoveis_anuncio.php?list=<?=$list ?>&tipo1=<?=$tipo1 ?>&campo=<?=$campo ?>&chave=<?=$chave ?>&query_finalidade=<?=$query_finalidade ?>&finalidade=<?=$finalidade ?>&idi=<?=$idi ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>|Anterior|<? } ?></a></td>
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
            								print "<a href=\"$url2\" class='style1'>|<b>$j</b>|</a>";
 	   									}else{
     	      								print "<a href=\"$url2\" class='style1'>|$j|</a>";
  	   									}
   									}
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="list_imoveis_anuncio.php?list=<?=$list ?>&tipo1=<?=$tipo1 ?>&campo=<?=$campo ?>&chave=<?=$chave ?>&query_finalidade=<?=$query_finalidade ?>&finalidade=<?=$finalidade ?>&idi=<?=$idi ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>|Próxima|<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="list_imoveis_anuncio.php?list=<?=$list ?>&tipo1=<?=$tipo1 ?>&campo=<?=$campo ?>&chave=<?=$chave ?>&query_finalidade=<?=$query_finalidade ?>&finalidade=<?=$finalidade ?>&idi=<?=$idi ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>|Última|<?}?></a></td>
               				</tr>
   						</table>
				  	</td>
			   	</tr>
	</table>
	</center>
	</div>
<?php
	}
}
	
//mysql_free_result($result1);
//mysql_free_result($result2);
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