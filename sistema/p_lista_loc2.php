<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("calendario2.php");
include("l_funcoes.php");
?>
<html>
<head>
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
<p>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/

	if(!$from){
		$from = intval($screen * 10);
	}

	session_register("dia");
	session_register("mes");
	session_register("ano");
	session_register("dia1");
	session_register("mes1");
	session_register("ano1");

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

	if($acomod == "" or $acomod == "%"){
	$acomod = "%";
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
	$dia_2 = $dia + 2;
	$dia1_2 = $dia1 - 2;

	#$query1 = "select * from muraski where tipo like '$tipo1' and ref like '$ref' 
	#and n_quartos $comp1 '$n_quartos' and valor $comp2 '$valor' and
	#acomod $comp3 '$acomod' and dist_mar $comp4 '$dist_mar' and end like '%$end%' 
	#and finalidade='Locação' and data_inicio<=current_date and 
	#data_fim>=current_date order by tipo, ref limit $from, 10";

	$query1 = "SELECT * FROM muraski WHERE tipo LIKE '$tipo1' AND ref LIKE '$ref' 
	AND n_quartos $comp1 '$n_quartos' AND valor $comp2 '$valor' AND
	acomod $comp3 '$acomod' AND dist_mar $comp4 '$dist_mar' AND end LIKE '%$end%' 
	AND finalidade='Locação' AND ('$ano-$mes-$dia' BETWEEN data_inicio AND data_fim OR
	'$ano1-$mes1-$dia1' BETWEEN data_inicio AND data_fim) AND ref!='x' AND relacao_bens LIKE '%$relacao_bens%' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	ORDER BY tipo, ref LIMIT $from, 10";
	#print $query1;
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	
	$data = mktime(0,0,0, $mes, $dia, $ano);
	$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);
	
	$total_dias = round(($data1 - $data)/(24*60*60));
	$total_dias = $total_dias + 1;
?>
<p>
	<div align="center">
	<table border="0" cellpadding="1" cellspacing="1" width="750">
	<tr><td colspan=2 align=center><font size="2" face="Arial" color="#000000"><b>
	Pesquisa de <font size="2" face="Arial" color="#ff0000"><?php print("$dia/$mes/$ano"); ?></font> à <font size="2" face="Arial" color="#ff0000"><?php print("$dia1/$mes1/$ano1"); ?></font>. Total de <font size="2" face="Arial" color="#ff0000"><?php print("$total_dias"); ?> diárias</font>.
	</td></tr>
<?
	$txtdia1 = $dia;
	$txtmes1 = $mes;
	$txtano1 = $ano;

	$txtdia2 = $dia1;
        $txtmes2 = $mes1;
	$txtano2 = $ano1;

	$txtdata1 = mktime(0,0,0, $txtmes1, $txtdia1, $txtano1);
	$txtdata2 = mktime(0,0,0, $txtmes2, $txtdia2, $txtano2);
			
	if (!$nextmes){
		$nextmes = $txtmes1;
		$nextano = $txtano1;
	}

	$mdif = 1;
	if ($txtdata1 != $txtdata2) {
		$mdif = floor(($txtdata2 - $txtdata1)/(24*60*60));
		$mdif = ($mdif/30);
		list ($inteiro,$resto) = split("[.,]",$mdif);
		if ($resto > 0) {
			$inteiro++;
			$mdif = $inteiro;
		}
		$mdif++;
	}

	## se encontrou imoveis
	if($numrows1 > 0){

		$i = 1;


		## loop de imoveis cadastrados para locacao
		while($not1 = mysql_fetch_array($result1))
		{

			$pano = substr ($not1['data_inicio'], 0, 4);
		        $pmes = substr($not1['data_inicio'], 5, 2 );
		        $pdia = substr ($not1['data_inicio'], 8, 2 );
		        $pano1 = substr ($not1['data_fim'], 0, 4);
		        $pmes1 = substr($not1['data_fim'], 5, 2 );
		        $pdia1 = substr ($not1['data_fim'], 8, 2 );
		        $pdata_inicio = "$pdia/$pmes/$pano";
		        $pdata_fim = "$pdia1/$pmes1/$pano1";

			$from = $from + 1;

			## se preencheu o periodo para pesquisa
			if ($dia != "" and $mes != "" and $ano != "" and $dia1 != "" and $mes1 != "" and $ano1 != "") {
				//$query4 = "select * from locacao where l_imovel='$not1[cod]' 
				//and l_data_ent<='$ano-$mes-$dia' and l_data_sai>='$ano1-$mes1-$dia1'";
	
				### seleciona o imovel que possui datas locadas no periodo
				### informado na pesquisa
				$query4 = "SELECT * FROM locacao WHERE l_imovel='$not1[cod]'
				AND ('$ano-$mes-$dia' BETWEEN l_data_ent AND l_data_sai or  
				'$ano1-$mes1-$dia1' BETWEEN l_data_ent AND l_data_sai) AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'"; 
				#print $query4;

				$result4 = mysql_query($query4);
				$numrows4 = mysql_num_rows($result4);
				## se não encontrou
				if($numrows4 == 0){

					$valor2 = number_format($not1[valor], 2, ',', '.');
					$carnaval = number_format($not1[carnaval], 2, ',', '.');
					$anonovo = number_format($not1[anonovo], 2, ',', '.');
					$metragem = str_replace(".",",","$not1[metragem]");
					//$descricao = str_replace("\n","<br>","$not1[descricao]");
					$img_1 = $not1[img_1];
	
					if (($i % 2) == 1){ $fundo="DCE0E4"; }else{ $fundo="EDEEEE"; }
					$i++;
?>
					<tr bgcolor="#DCE0E4">
					<td colspan="2"><p align="left">
					<a href="detalhes.php?cod=<?=$not1[cod]?>&mes=<?=$nextmes?>&ano=<?=$nextano?>">
					<font size="2" face="Arial" color="#000000">
					<?php print("$not1[tipo]"); ?> -- <b>Ref.: <?php print("$not1[ref]"); ?> - <i>
					<?php print strip_tags($not1[titulo]); ?></i></b></font></a></td></tr>
						<tr bgcolor="#EDEEEE"><td width=375 valign=top>
<?
					## se tem foto, mostra!
					if (file_exists($caminhob.$img_1))
					{
?>
						<p align="center">
						<img border="0" src="<?php print($caminho_html.$not1[img_1]); ?>">
<?
					}
?>
						</td>
					<td width=375 valign=top>
					<table width=375><tr><td valign=top width=235>
					<table width=235>
					<tr><td>
					<font size="2" face="Arial" color="#000000">
					Metragem:<b> <?php print("$metragem"); ?> m<sup>2</sup></b><br>
					<font size="2" face="Arial" color="#000000">
<?
					## se tem quartos, mostra!
					if($not1[n_quartos] > 0){
?>
						N° de quartos:<b> <?php print("$not1[n_quartos]"); ?></b><br>
<?
					}
?>
					<font size="2" face="Arial" color="#000000">
<?
					## se tem suites, mostra!
					if($not1[suites] > 0){
?>
						 Suítes: <b><?php print("$not1[suites]"); ?></b><br>
<?
					}
?>
					<font size="2" face="Arial" color="#000000">
<?
					## se tem valor, mostra!
					if($not1[valor] > 0){
?>
						Diária: <b>R$ <?php print("$valor2"); ?></b><br>
<?
					}
?>
<?php
	if($not1[carnaval] > 0){
?>
<i>Carnaval: <b>R$ <?php print("$carnaval"); ?></b><br></i>
<?php
	}
?>
<?php
	if($not1[anonovo] > 0){
?>
<i>Ano Novo: <b>R$ <?php print("$anonovo"); ?></b><br></i>
<?php
	}
?>

					<font size="2" face="Arial" color="#000000">
<?
					## se tem acomod, mostra!
					if($not1[acomod] > 0){
?>
						Acomodações: <b><?php print("$not1[acomod]"); ?></b> pessoas<br>
<?
					}
?>
					<font size="2" face="Arial" color="#000000">
<?
					## se tem end, mostra!
					if($not1[end] > 0){
?>
						Endereço: <b><?php print("$not1[end]"); ?></b><br>
<?
					}
?>
					<font size="2" face="Arial" color="#000000">
<?
					## se tem dist_mar, mostra!
					if($not1[dist_mar] > 0){
?>
						Distância do mar: <b><?php print("$not1[dist_mar] $not1[dist_tipo]"); ?></b>
<?
					}
?>
					</td></tr><tr bgcolor="#DCE0E4"><td>
					<font size="2" face="Arial" color="#000000">
					<a href="carrinho.php?cod=<?php print("$not1[cod]"); ?>&qtd=1">
					<b>Separar Chaves</b></a>
					</td></tr>
<?php
	$url = $REQUEST_URI;
	//echo $url;
	$url = str_replace("&","-","$url");
?>					
					<tr bgcolor="#DCE0E4"><td>
					<font size="2" face="Arial" color="#000000">
					<a href="add_prod.php?qtd=1&cod=<?php print("$not1[cod]"); ?>&controle=L&url=<?php print("$url"); ?>">
					<b>Adicionar à lista</b></a>
					</td></tr><tr bgcolor="#DCE0E4"><td>
					<font size="2" face="Arial" color="#000000">
					<a href="reserva.php?cod=<?php print("$not1[cod]"); ?>
					&l_data_ent=<?php print("$txtdia1/$txtmes1/$txtano1"); ?>
					&l_data_sai=<?php print("$txtdia2/$txtmes2/$txtano2"); ?>">
					<b>Reservar Imóvel</b></a>
					</td></tr></table>
					</td>
					<td width=140>
					<table width=140>
					<tr><td>
<?
					### inicialização de variaveis
					$mes01 = array();
					$mes02 = array();
					$mes03 = array();
					$mes04 = array();
					$mes05 = array();
					$mes06 = array();
					$mes07 = array();
					$mes08 = array();
					$mes09 = array();
					$mes10 = array();
					$mes11 = array();
					$mes12 = array();
					$datapermitida = array();
					$todasdatas = array();

					### monta array com periodo permitido para locacao
					#print "data permitida = $pdata_inicio, $pdata_fim<br>";
					array_push ($datapermitida, $pdata_inicio, $pdata_fim);

					## seleciona o imovel ordenando pela data de inicio da locacao
					$query3 = "select * from locacao where l_imovel='$not1[cod]' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_data_ent ";

					$result3 = mysql_query($query3);
					$numrows3 = mysql_num_rows($result3);
					if($numrows3 > 0){
?>
<?
						while($not3 = mysql_fetch_array($result3))
						{
	
							$ano2 = substr ($not3['l_data_ent'], 0, 4);
							$mes2 = substr($not3['l_data_ent'], 5, 2 );
							$dia2 = substr ($not3['l_data_ent'], 8, 2 );
							$ano3 = substr ($not3['l_data_sai'], 0, 4);
							$mes3 = substr($not3['l_data_sai'], 5, 2 );
							$dia3 = substr ($not3['l_data_sai'], 8, 2 );

							$data_ent = "$dia2/$mes2/$ano2";
							$data_sai = "$dia3/$mes3/$ano3";
							$data2 = mktime(0,0,0, $mes2, $dia2, $ano2);
							$data3 = mktime(0,0,0, $mes3, $dia3, $ano3);
							//$total_dias = floor(($data3 - $data2)/(24*60*60));
							array_push (${"todasdatas"},$data_ent,$data_sai);

//							<font size="2" face="Arial" color="#ff0000">
//							 print("$data_ent");  à  print("$data_sai"); : 
//							 print("$total_dias");  dias<br>

						} ## fim while de datas da locacao do imovel
	mysql_free_result($result3);
	mysql_free_result($result4);
					} ## fim de if existe datas da locacao do imovel
				
					### verifica a diferenca entre os meses
					### pesquisados e define quantos calendarios
					### serão exibidos
					for ($df = 1; $df <= $mdif; $df++) {
						if (strlen($nextmes) == 1) {
							$nextmes = "0$nextmes";
						}
						### monta o calendario
						calendario(${"todasdatas"},"$nextmes/$nextano",$datapermitida,0);
						print "<br>";
						$nextmes++;
						if ($nextmes > 12) {
							$nextmes = 1;
							$nextano++;
						}
					}
					$nextmes=$txtmes1;
					$nextano=$txtano1;
?>
					</td></tr></table></td></tr></table></td></tr>
					<tr><td colspan="2" align="center"><font size="2" face="Arial" color="#000000">
					<a href="detalhes.php?cod=<?php print("$not1[cod]"); ?>">
					Clique aqui para ver mais detalhes da Ref.: <?php print("$not1[ref]"); ?></a>
					</td></tr>
<?php
				} ## fim numrows4 == 0 
			} ## fim de preencheu periodo de pesquisa
		} ## fim while imoveis cadastrados para locacao
	} ## fim seleciona imoveis disponiveis para locacao
	mysql_free_result($result1);

	#
	##
	## conta imoveis encontrados
	//$query2 = "SELECT * FROM muraski WHERE tipo LIKE '$tipo1' AND ref LIKE '$ref' 
	//AND n_quartos $comp1 '$n_quartos' AND valor $comp2 '$valor' AND
	//acomod $comp3 '$acomod' AND dist_mar $comp4 '$dist_mar' AND end LIKE '%$end%' 
	//AND finalidade='Locação' AND ('$ano-$mes-$dia' BETWEEN data_inicio AND data_fim OR
	//'$ano1-$mes1-$dia1' BETWEEN data_inicio AND data_fim) AND ref!='x'";
	$query2 = "select count(cod) as contador 
	from muraski where tipo LIKE '$tipo1' AND ref LIKE '$ref' 
	AND n_quartos $comp1 '$n_quartos' AND valor $comp2 '$valor' AND
	acomod $comp3 '$acomod' AND dist_mar $comp4 '$dist_mar' AND end LIKE '%$end%' 
	AND finalidade='Locação' AND ('$ano-$mes-$dia' BETWEEN data_inicio AND data_fim OR
	'$ano1-$mes1-$dia1' BETWEEN data_inicio AND data_fim) AND ref!='x' AND relacao_bens LIKE '%$relacao_bens%' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

	$result2 = mysql_query($query2);
	//$numrows2 = mysql_num_rows($result2);
	//$contador = 0;
	
	while($not2 = mysql_fetch_array($result2))
	{
	$contador = $not2[contador];
	//			$query5 = "select * from locacao where l_imovel='$not2[cod]' 
	//			and l_data_ent<='$ano-$mes-$dia' and l_data_sai>='$ano1-$mes1-$dia1'";
	//			$result5 = mysql_query($query5);
	//			$numrows5 = mysql_num_rows($result5);
	//			if($numrows5 == 0){
	//				$contador = $contador + 1;
	//			}
				
	//$contador = $numrows2 - $numrows5;
	}
?>
                  <tr><td colspan="2" bgcolor="#000080">
                  <font face="Arial" size="2" color="#ffffff">
                  <p align="center">
                  <i>Foram encontrados <?php print("$contador"); ?> imóveis</i></td></tr>
<?php
		if($from >= $contador){
?>
                  	<tr bgcolor="#ffffff"><td>
                  	<font face="Arial" size="2" color="#ff0000">
                  	<p align="center">
                  	<a href="javascript:history.back()">
                  	<< Página anterior <<</a></td><td>
                  	<font face="Arial" size="2" color="#ff0000">
                  	<p align="center">
                  	Última página da pesquisa</td></tr>
<?php
		} else	{
?>
                  	<tr bgcolor="#ffffff"><td>
                  	<font face="Arial" size="2" color="#ff0000">
                  	<p align="center">
                  	<a href="javascript:history.back()">
                  	<< Página anterior <<</a></td><td>
                  	<font face="Arial" size="2" color="#ff0000">
                  	<p align="center">
                  	<a href="p_lista_loc.php?from=<?php print("$from"); ?>&tipo1=<?php print("$tipo1"); ?>&ref=<?php print("$ref"); ?>&comp1=<?php print("$comp1"); ?>&comp2=<?php print("$comp2"); ?>&comp3=<?php print("$comp3"); ?>&comp4=<?php print("$comp4"); ?>&n_quartos=<?php print("$n_quartos"); ?>&valor=<?php print("$valor"); ?>&acomod=<?php print("$acomod"); ?>&dist_mar=<?php print("$dist_mar"); ?>&end=<?php print("$end"); ?>&finalidade=Locação&ano=<?php print("$ano"); ?>&mes=<?php print("$mes"); ?>&dia=<?php print("$dia"); ?>&ano1=<?php print("$ano1"); ?>&mes1=<?php print("$mes1"); ?>&dia1=<?php print("$dia1"); ?>&end=<?php print("$end"); ?>">
			>> Próxima página >></a></td></tr>
<?php
		}
?>
		</table>
		</center>
		</div>
<?
	//}## fim while conta imoveis

	mysql_free_result($result2);

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
</body>
</html>