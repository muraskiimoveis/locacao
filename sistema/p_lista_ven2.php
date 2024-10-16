<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<html>
<head>
<?php
include("style.php");
include("conect.php");
include("l_funcoes.php");
?>
</head>
<body>
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
<form name="form1" id="form1" method="POST" action="">
<p>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
	if(!$screen){
	$screen = 1;
	}

	if(!$from){
	$from = intval(($screen - 1) * 10);
	}


	//$ano = substr ($chave, 6, 4);
	//$mes = substr($chave, 3, 2 );
	//$dia = substr ($chave, 0, 2 );
	if($ref == "" or $ref == "%"){
	$ref = "%";
	}

	if($n_quartos == "" or $n_quartos == "%"){
	$n_quartos = "%";
	}

	if($valor == "" or $valor == "%"){
	$valor = "%";
	}

	if($dist_mar == "" or $dist_mar == "%"){
	$dist_mar = "%";
	}

	if($end == "" or $end == "%"){
	$end = "%";
	}
	
	if($comp2 == "like"){
		$valor = $valor . "%";
	}
	
	if($valor_oferta == "Sim"){
	$oferta = "and valor_oferta>0";
	}
	
	//Bairros
	$funcoes = explode(", ", $not1[bairro]);
	$funcoes_cnt   = count($funcoes);
 
 		for ($i = 0; $i < $funcoes_cnt; $i++) 
 		{
			if($i < 1){
				$query_bairro = "where b_id='" . $funcoes[$i] . "'";
			}
			else
			{
				$query_bairro .= " or b_id='" . $funcoes[$i] . "'";   				
			}
		}
	
	if(!$ordem){
	$ordem = "tipo";
	}
	
	if($ordem == "ultimos_cadastros"){
		$ordem1 = "cod desc";
	}elseif($ordem == "valor_decrescente"){
		$ordem1 = "valor desc";
	}elseif($ordem == "valor_crescente"){
		$ordem1 = "valor";
	}elseif($ordem == "quartos"){
		$ordem1 = "n_quartos";
	}
	else
	{
		$ordem1 = $ordem;
	}
	
	$ordenar = $ordem1 . ", ref";


?>
    
    <input type="hidden" name="tipo1" id="tipo1" value="<? if($GET['tipo1']){ echo $_GET['tipo1']; }else{ echo $tipo; } ?>">
    <input type="hidden" name="ref" id="ref" value="<? if($GET['ref']){ echo $_GET['ref']; }else{ echo $ref; } ?>">
    <input type="hidden" name="comp1" id="comp1" value="<? if($GET['comp1']){ echo $_GET['comp1']; }else{ echo $comp1; } ?>">
    <input type="hidden" name="n_quartos" id="n_quartos" value="<? if($GET['n_quartos']){ echo $_GET['n_quartos']; }else{ echo $n_quartos; } ?>">
    <input type="hidden" name="comp2" id="comp2" value="<? if($GET['comp2']){ echo $_GET['comp2']; }else{ echo $comp2; } ?>">
    <input type="hidden" name="valor" id="valor" value="<? if($GET['valor']){ echo $_GET['valor']; }else{ echo $valor; } ?>">
    <input type="hidden" name="comp4" id="comp4" value="<? if($GET['comp4']){ echo $_GET['comp4']; }else{ echo $comp4; } ?>">
    <input type="hidden" name="dist_mar" id="dist_mar" value="<? if($GET['dist_mar']){ echo $_GET['dist_mar']; }else{ echo $dist_mar; } ?>">
    <input type="hidden" name="end" id="end" value="<? if($GET['end']){ echo $_GET['end']; }else{ echo $end; } ?>">
    <input type="hidden" name="finalidade" id="finalidade" value="<? if($GET['finalidade']){ echo $_GET['finalidade']; }else{ echo $finalidade; } ?>">
    <input type="hidden" name="permuta" id="permuta" value="<? if($GET['permuta']){ echo $_GET['permuta']; }else{ echo $permuta; } ?>">
    <input type="hidden" name="permuta_txt" id="permuta_txt" value="<? if($GET['permuta_txt']){ echo $_GET['permuta_txt']; }else{ echo $permuta_txt; } ?>">
    <input type="hidden" name="oferta" id="oferta" value="<? if($GET['oferta']){ echo $_GET['oferta']; }else{ echo $oferta; } ?>">
    <input type="hidden" name="ordenar" id="ordenar" value="<? if($GET['ordenar']){ echo $_GET['ordenar']; }else{ echo $ordenar; } ?>">
    <input type="hidden" name="screen" id="screen" value="<? if($GET['screen']){ echo $_GET['screen']; }else{ echo $screen; } ?>">
    
<?
	#$query1 = "select * from muraski where tipo like '$tipo1' and ref like '$ref' 
	#and n_quartos $comp1 '$n_quartos' and valor $comp2 '$valor' and
	#acomod $comp3 '$acomod' and dist_mar $comp4 '$dist_mar' and end like '%$end%' 
	#and finalidade='Locação' and data_inicio<=current_date and 
	#data_fim>=current_date order by $ordenar limit $from, 10";

	$query1 = "SELECT * FROM muraski WHERE tipo LIKE '$tipo1' AND ref LIKE '$ref' 
	AND n_quartos $comp1 '$n_quartos' AND valor $comp2 '$valor' AND 
	dist_mar $comp4 '$dist_mar' AND end LIKE '%$end%' 
	AND finalidade like '$finalidade' AND ref!='x' AND permuta LIKE '%$permuta%' 
	AND permuta_txt LIKE '%$permuta_txt%' $oferta AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'
	ORDER BY $ordenar LIMIT $from, 10";
	//echo $query1;
	// AND (current_date BETWEEN data_inicio AND data_fim)
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<p>
	<div align="center">
	<table border="0" cellpadding="1" cellspacing="1" width="750">
		<tr>
			<td colspan=2 class=style2>Ordenado por: <?php print("$ordem"); ?></td>
		</tr>
<?

	$hoje = date("Y-m-d");
	
	if($_GET['acao'])
	{

	  $msgErro = "";
   		
		$cod = $_GET['cod'];
   		$dthj = $_GET['dthj'];
   		$tipo1 = $_GET['tipo1'];
   	   	$ref = $_GET['ref'];
   	   	$comp1 = $_GET['comp1'];
   	   	$n_quartos = $_GET['n_quartos'];
   	   	$comp2 = $_GET['comp2'];
   	   	$valor = $_GET['valor'];
   	   	$comp4 = $_GET['comp4'];
   	   	$dist_mar = $_GET['dist_mar'];
   	   	$end = $_GET['end'];
   	   	$finalidade = $_GET['finalidade'];
	    $permuta = $_GET['permuta'];
		$permuta_txt = $_GET['permuta_txt'];
		$oferta = $_GET['oferta'];
		$ordenar = $_GET['ordenar'];
		$screen = $_GET['screen'];
  
   		$SQL = "SELECT cod_imovel, data FROM avaliados WHERE cod_imovel='".$cod."' AND data='".$dthj."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Esse imóvel já foi adicionado a lista hoje!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"p_lista_ven.php?tipo1=".$tipo1."&ref=".$ref."&comp1=".$comp1."&n_quartos=".$n_quartos."&comp2=".$comp2."&valor=".$valor."&comp4=".$comp4."&dist_mar=".$dist_mar."&end=".$end."&finalidade=".$finalidade."&permuta=".$permuta."&permuta_txt=".$permuta_txt."&oferta=".$oferta."&ordenar=".$ordenar."&screen=".$screen."\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO avaliados (cod_imobiliaria, cod_imovel, data, user) VALUES ('".$_SESSION['cod_imobiliaria']."', '".$cod."','".$hoje."','".$u_cod."')";   		
   			if(mysql_query($inserir))
			{
				echo('<script language="javascript">alert("Imóvel adicionado a lista!");document.location.href="p_lista_ven.php?tipo1='.$tipo1.'&ref='.$ref.'&comp1='.$comp1.'&n_quartos='.$n_quartos.'&comp2='.$comp2.'&valor='.$valor.'&comp4='.$comp4.'&dist_mar='.$dist_mar.'&end='.$end.'&finalidade='.$finalidade.'&permuta='.$permuta.'&permuta_txt='.$permuta_txt.'&oferta='.$oferta.'&ordenar='.$ordenar.'&screen='.$screen.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao adicionar!");document.location.href="p_lista_ven.php?tipo1='.$tipo1.'&ref='.$ref.'&comp1='.$comp1.'&n_quartos='.$n_quartos.'&comp2='.$comp2.'&valor='.$valor.'&comp4='.$comp4.'&dist_mar='.$dist_mar.'&end='.$end.'&finalidade='.$finalidade.'&permuta='.$permuta.'&permuta_txt='.$permuta_txt.'&oferta='.$oferta.'&ordenar='.$ordenar.'&screen='.$screen.'";</script>');
   			}
   		}  
	  
	}


	## se encontrou imoveis
	if($numrows1 > 0){

		$i = 1;


		## loop de imoveis cadastrados para locacao
		$y = 1;
		while($not1 = mysql_fetch_array($result1))
        {
        
		if($finalidade=='Vendido'){
		  
		  $cod = $not1[cod];
          $valorm = $not1[valor];
		  		
		 	$buscaV = mysql_query("SELECT v_imovel, v_total FROM vendas WHERE v_imovel='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");  
			while($linha2 = mysql_fetch_array($buscaV)){
		      $cod_imovel = $linha2['v_imovel'];
     	      $valorv = $linha2['v_total'];
		 	}  
		 	//FAZ VERIFICACAO QUAL VALOR UTLIZAR SE TABELA VENDA OU DA MURASKI	
			if($cod==$cod_imovel){
		  		$valor2 = number_format($valorv, 2, ',', '.');
			}elseif($cod<>$cod_imovel){
		  		$valor2 = number_format($valorm, 2, ',', '.');
			}
        }else{
            $valor2 = number_format($not1[valor], 2, ',', '.');		  
		}

		$from = $from + 1;

					$valor_oferta = number_format($not1[valor_oferta], 2, ',', '.');
					$metragem = str_replace(".",",",$not1[metragem]);

					//$descricao = str_replace("\n","<br>","$not1[descricao]");
					$img_1 = $not1[img_1];
	
					if (($i % 2) == 1){ $fundo="$cor7"; }else{ $fundo=$cor6; }
					$i++;
?>
<tr bgcolor="#<?php print("$cor5"); ?>">
				<td colspan="2" height=1></td>
				</tr>
					<tr bgcolor="#<?php print("$cor1"); ?>">
					<td colspan="2"><p align="left">
					<a href="detalhes.php?cod=<?=$not1[cod]?>&mes=<?=$nextmes?>&ano=<?=$nextano?>" class=style2>
					<?php print("$not1[tipo]"); ?> -- <b>Ref.: <?php print("$not1[ref]"); ?> - <i>
					<?php print("$not1[titulo]"); ?></i></b></font></a></td></tr>
					<tr bgcolor="#<?php print("$cor5"); ?>">
				<td colspan="2" height=1></td>
				</tr>
						<tr bgcolor="#<?php print("$cor1"); ?>"><td width=375 valign=top>
<?
					## se tem foto, mostra!
					if (file_exists($caminhob.$img_1))
					{
						//echo $img_1;
?>
						<p align="center">
						<img border="0" src="<?php print($caminho_html.$not1[img_1]); ?>">
<?
					}
?>
						</td>
					<td width=375 valign=top>
					<table width=375 border="0" cellpadding="1" cellspacing="1"><tr><td valign=top>
					<table width=100% border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td class=style2>
							Metragem:<b> <?php print("$metragem"); ?> m<sup>2</sup></b></td>
					</tr>
					<? if($not1['averbacao'] != '0.00'){ 
					$averbacao = str_replace(".",",","$not1[averbacao]");
					?>
					<tr>
					  <td class=style2>&Aacute;rea averbada: <b><?= $averbacao ?> m²</b> </td>
					  </tr>
					 <? } ?>
					 
					 <? if($not1['area_terreno'] != ''){ 
					 $area_terreno = str_replace(".",",","$not1[area_terreno]");
					 ?>
					<tr>
					  <td class=style2>&Aacute;rea do terreno: <b><?= $area_terreno ?> m²</b></td>
					  </tr>
					<? } ?>
					<tr>
						<td class=style2 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
					</tr>
<?
					## se tem quartos, mostra!
					if($not1[n_quartos] > 0){
?>
					<tr>
						<td class=style2>Total de quartos:<b> <?php print("$not1[n_quartos]"); ?></b></td>
					</tr>
					<tr>
						<td class=style2 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
					</tr>
<?
					}
?>

<?
					## se tem suites, mostra!
					if($not1[suites] > 0){
?>
					<tr>
						<td class=style2>Sendo Suítes: <b><?php print("$not1[suites]"); ?></b></td>
					</tr>
					<tr>
						<td class=style2 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
					</tr>
<?
					}
?>

<?
					## se tem valor, mostra!
					if($not1[valor] > 0){
?>
					<tr>
						<td class=style2>Valor: <b>R$ <?php print("$valor2"); ?></b></td>
					</tr>
					<tr>
						<td class=style2 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
					</tr>
<?
					}
?>
<?
					## se tem valor_oferta, mostra!
					if($not1[valor_oferta] > 0){
?>
					<tr>
						<td class=style2><span class=style7><b>OFERTA: R$ <?php print("$valor_oferta"); ?></b> - BOM NEGÓCIO!</span></td>
					</tr>
					<tr>
						<td class=style2 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
					</tr>
<?
					}
?>
<?
					## se tem end, mostra!
					if($not1[end] > 0){
?>
					<tr>
						<td class=style2>Endereço: <b><?php print("$not1[end]"); ?></b></td>
					</tr>
					<tr>
						<td class=style2 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
					</tr>
<?
					}
?>

<?
					## se tem dist_mar, mostra!
					if($not1[dist_mar] > 0){
?>
					<tr>
						<td class=style2>Distância do mar: <b><?php print("$not1[dist_mar] $not1[dist_tipo]"); ?></b></td>
					</tr>
					<tr>
						<td class=style2 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
					</tr>
<?
					}
?>
					<tr bgcolor="#<?php print("$cor6"); ?>">
						<td class=style2>
					<a href="carrinho.php?cod=<?php print("$not1[cod]"); ?>&qtd=1">
					<b>Separar Chaves</b></a>					</td></tr>
<?php
	$url = $REQUEST_URI;
	//echo $url;
	$url = str_replace("&","-","$url");
	
	
?>					
					<tr bgcolor="#<?php print("$cor6"); ?>"><td class=style2>
					<a href="add_prod.php?qtd=1&cod=<?php print("$not1[cod]"); ?>&controle=V&url=<?php print("$url"); ?>">
					<b>Adicionar à lista</b></a>
					</td></tr>
					<tr bgcolor="#<?php print("$cor6"); ?>">
					  <td class=style2><a href="venda.php?cod=<?php print("$not1[cod]"); ?>"><b>Vender Im&oacute;vel</b></a></td>
					  </tr>
					<tr bgcolor="#<?php print("$cor6"); ?>">
					  <td class=style2><a href="p_lista_ven.php?acao=<?php print("$y"); ?>&cod=<?php print("$not1[cod]"); ?>&dthj=<?php print("$hoje"); ?>&tipo1=<? echo($tipo1); ?>&ref=<? echo($ref); ?>&comp1=<? echo($comp1); ?>&n_quartos=<? echo($n_quartos); ?>&comp2=<? echo($comp2); ?>&valor=<? echo($valor); ?>&comp4=<? echo($comp4); ?>&dist_mar=<? echo($dist_mar); ?>&end=<? echo($end); ?>&finalidade=<? echo($finalidade); ?>&permuta=<? echo($permuta); ?>&permuta_txt=<? echo($permuta_txt); ?>&oferta=<? echo($oferta); ?>&ordenar=<? echo($ordenar); ?>&screen=<? echo($screen); ?>"><b>Adicionar &agrave; lista de avalia&ccedil;&atilde;o </b></a></td>
					  </tr>
					<tr bgcolor="#<?php print("$cor6"); ?>">
						<td colspan="2" align="left" class=style2>
					<a href="detalhes.php?cod=<?php print("$not1[cod]"); ?>" class=style2>
					<b>Mais detalhes da Ref.: <?php print("$not1[ref]"); ?></b></a>					</td></tr></table>
					</td>
					</tr></table></td></tr>
<?php
        $y++;
				#} ## fim numrows4 == 0 
		} ## fim while imoveis cadastrados para locacao
	} ## fim seleciona imoveis disponiveis para locacao


	#
	##
	## conta imoveis encontrados
	$query2 = "select count(cod) as contador 
	from muraski where tipo LIKE '$tipo1' AND ref LIKE '$ref' 
	AND n_quartos $comp1 '$n_quartos' AND valor $comp2 '$valor' AND 
	dist_mar $comp4 '$dist_mar' AND end LIKE '%$end%' 
	AND finalidade like '$finalidade' AND ref!='x' AND permuta LIKE '%$permuta%' 
	AND permuta_txt LIKE '%$permuta_txt%' $oferta AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	// AND (current_date BETWEEN data_inicio AND data_fim)

	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
		$pages = ceil($not2[contador] / 10);
?>
                  <tr><td colspan="2" bgcolor="#<?php print("$cor6"); ?>" class=style2>
                  <p align="center">
                  <i>Foram encontrados <?php print("$not2[contador]"); ?> imóveis</i></td></tr>
                  	<tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class=style6>
                  	<p align="center">|
<?php

	for ($i = 1; $i <= $pages; $i++) {

  	$url2 = $PHP_SELF . "?screen=" . $i . "&tipo1=" . $tipo1 . "&ref=" . $ref . "&comp1=" . $comp1 . "&comp2=" . $comp2 . "&comp4=" . $comp4 . "&n_quartos=" . $n_quartos . "&valor=" . $valor . "&dist_mar=" . $dist_mar . "&finalidade=" . $finalidade . "&permuta=" . $permuta . "&permuta_txt=" . $permuta_txt . "&end=" . $end . "&ordem=" . $ordem . "&valor_oferta=" . $valor_oferta;

  	if($i == $screen){
  	echo "   <a href=\"$url2\" class=style7><b>$i</b></a> |   ";
	}
  	else
  	{
  	echo "   <a href=\"$url2\" class=style6>$i</a> |   ";	
  	}
	}

?>
</td></tr>
                  <tr><td align=center class=style6>
<?php
	if ($from > 10) {
			$url1 = $PHP_SELF . "?screen=" . ($screen - 1) . "&tipo1=" . $tipo1 . "&ref=" . $ref . "&comp1=" . $comp1 . "&comp2=" . $comp2 . "&comp4=" . $comp4 . "&n_quartos=" . $n_quartos . "&valor=" . $valor . "&dist_mar=" . $dist_mar . "&finalidade=" . $finalidade . "&permuta=" . $permuta . "&permuta_txt=" . $permuta_txt . "&end=" . $end . "&ordem=" . $ordem . "&valor_oferta=" . $valor_oferta;
?>
                  <a href="<?php print("$url1"); ?>" class=style6>
                  << Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class=style6>
                  << Página anterior <<</a>
<?php
	}
?>
</td><td align=center class=style7>
<?php
	if ($from >= $not2[contador]) {
?>
		  Última página da pesquisa
<?php
	}
	else
	{
			$url3 = $PHP_SELF . "?screen=" . ($screen + 1) . "&tipo1=" . $tipo1 . "&ref=" . $ref . "&comp1=" . $comp1 . "&comp2=" . $comp2 . "&comp4=" . $comp4 . "&n_quartos=" . $n_quartos . "&valor=" . $valor . "&dist_mar=" . $dist_mar . "&finalidade=" . $finalidade . "&permuta=" . $permuta . "&permuta_txt=" . $permuta_txt . "&end=" . $end . "&ordem=" . $ordem . "&valor_oferta=" . $valor_oferta;
?>
                  <a href="<?php print("$url3"); ?>" class=style6>
                  >> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
		</table>
		</center>
		</div>
<?
	}## fim while conta imoveis
	/*
	mysql_free_result($result1);
	mysql_free_result($result2);
	*/
	mysql_close($con);

## se não tem sessao
//} else {
?>
<?php
//include("login2.php");
?>
<?php
//}
?>
</form>
</body>
</html>