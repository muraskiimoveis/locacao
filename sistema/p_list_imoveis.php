<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("IMOV_GERAL");
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

	if(!$screen){
	$screen = 1;
	}

	if(!$from){
	$from = intval(($screen - 1) * 30);
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
  <form method="get" action="p_list_imoveis.php" name="form1" id="form1">
  <tr>
		<td bgcolor="#<?=$cor3 ?>" colspan=5 class="style1" align="center"><b>Relação de Imóveis</b></td>
	</tr>
    <tr bgcolor="#<?php print("$cor1"); ?>">
      <td colspan=4  class="style1"><? if($_GET['campo']=='end'){ echo("Endereço:"); }else{ echo("Palavra Chave:"); } ?> <? if($_GET['campo']=='end'){ ?>
	  	<select name="tipo_logradouro" id="tipo_logradouro" class="campo">
        <option value="">Selecione</option>
        <option value="Alameda" <? if($tipo_logradouro=='Alameda'){ echo "SELECTED"; } ?>>Alameda</option>
        <option value="Área" <? if($tipo_logradouro=='Área'){ echo "SELECTED"; } ?>>Área</option>
        <option value="Avenida" <? if($tipo_logradouro=='Avenida'){ echo "SELECTED"; } ?>>Avenida</option>
        <option value="Campo" <? if($tipo_logradouro=='Campo'){ echo "SELECTED"; } ?>>Campo</option>
        <option value="Chácara" <? if($tipo_logradouro=='Chácara'){ echo "SELECTED"; } ?>>Chácara</option>
        <option value="Colônia" <? if($tipo_logradouro=='Colônia'){ echo "SELECTED"; } ?>>Colônia</option>
        <option value="Condomínio" <? if($tipo_logradouro=='Condomínio'){ echo "SELECTED"; } ?>>Condomínio</option>
        <option value="Conjunto" <? if($tipo_logradouro=='Conjunto'){ echo "SELECTED"; } ?>>Conjunto</option>
        <option value="Distrito" <? if($tipo_logradouro=='Distrito'){ echo "SELECTED"; } ?>>Distrito</option>
        <option value="Esplanada" <? if($tipo_logradouro=='Esplanada'){ echo "SELECTED"; } ?>>Esplanada</option>
        <option value="Estação" <? if($tipo_logradouro=='Estação'){ echo "SELECTED"; } ?>>Estação</option>
        <option value="Estrada" <? if($tipo_logradouro=='Estrada'){ echo "SELECTED"; } ?>>Estrada</option>
        <option value="Favela" <? if($tipo_logradouro=='Favela'){ echo "SELECTED"; } ?>>Favela</option>
        <option value="Fazenda" <? if($tipo_logradouro=='Fazenda'){ echo "SELECTED"; } ?>>Fazenda</option>
        <option value="Feira" <? if($tipo_logradouro=='Feira'){ echo "SELECTED"; } ?>>Feira</option>
        <option value="Jardim" <? if($tipo_logradouro=='Jardim'){ echo "SELECTED"; } ?>>Jardim</option>
        <option value="Ladeira" <? if($tipo_logradouro=='Ladeira'){ echo "SELECTED"; } ?>>Ladeira</option>
        <option value="Lago" <? if($tipo_logradouro=='Lago'){ echo "SELECTED"; } ?>>Lago</option>
        <option value="Lagoa" <? if($tipo_logradouro=='Lagoa'){ echo "SELECTED"; } ?>>Lagoa</option>
        <option value="Largo" <? if($tipo_logradouro=='Largo'){ echo "SELECTED"; } ?>>Largo</option>
        <option value="Loteamento" <? if($tipo_logradouro=='Loteamento'){ echo "SELECTED"; } ?>>Loteamento</option>
        <option value="Morro" <? if($tipo_logradouro=='Morro'){ echo "SELECTED"; } ?>>Morro</option>
        <option value="Núcleo" <? if($tipo_logradouro=='Núcleo'){ echo "SELECTED"; } ?>>Núcleo</option>
        <option value="Parque" <? if($tipo_logradouro=='Parque'){ echo "SELECTED"; } ?>>Parque</option>
        <option value="Passarela" <? if($tipo_logradouro=='Passarela'){ echo "SELECTED"; } ?>>Passarela</option>
        <option value="Pátio" <? if($tipo_logradouro=='Pátio'){ echo "SELECTED"; } ?>>Pátio</option>
        <option value="Praça" <? if($tipo_logradouro=='Praça'){ echo "SELECTED"; } ?>>Praça</option>
        <option value="Quadra" <? if($tipo_logradouro=='Quadra'){ echo "SELECTED"; } ?>>Quadra</option>
        <option value="Recanto" <? if($tipo_logradouro=='Recanto'){ echo "SELECTED"; } ?>>Recanto</option>
        <option value="Residencial" <? if($tipo_logradouro=='Residencial'){ echo "SELECTED"; } ?>>Residencial</option>
        <option value="Rodovia" <? if($tipo_logradouro=='Rodovia'){ echo "SELECTED"; } ?>>Rodovia</option>
        <option value="Rua" <? if($tipo_logradouro=='Rua'){ echo "SELECTED"; } ?>>Rua</option>
        <option value="Setor" <? if($tipo_logradouro=='Setor'){ echo "SELECTED"; } ?>>Setor</option>
        <option value="Sítio" <? if($tipo_logradouro=='Sítio'){ echo "SELECTED"; } ?>>Sítio</option>
        <option value="Travessa" <? if($tipo_logradouro=='Travessa'){ echo "SELECTED"; } ?>>Travessa</option>
        <option value="Trecho" <? if($tipo_logradouro=='Trecho'){ echo "SELECTED"; } ?>>Trecho</option>
        <option value="Trevo" <? if($tipo_logradouro=='Trevo'){ echo "SELECTED"; } ?>>Trevo</option>
        <option value="Vale" <? if($tipo_logradouro=='Vale'){ echo "SELECTED"; } ?>>Vale</option>
        <option value="Vereda" <? if($tipo_logradouro=='Vereda'){ echo "SELECTED"; } ?>>Vereda</option>
        <option value="Via" <? if($tipo_logradouro=='Via'){ echo "SELECTED"; } ?>>Via</option>
        <option value="Viaduto" <? if($tipo_logradouro=='Viaduto'){ echo "SELECTED"; } ?>>Viaduto</option>
        <option value="Viela" <? if($tipo_logradouro=='Viela'){ echo "SELECTED"; } ?>>Viela</option>
        <option value="Vila" <? if($tipo_logradouro=='Vila'){ echo "SELECTED"; } ?>>Vila</option>
      </select> <input type="text" class="campo" name="chave" size="15"> N&deg;: 
      <input type="text" name="numero_end" id="numero_end" size="5" class="campo" value="<?=$numero_end; ?>">
	  <? }else{ ?>
		<input type="text" class="campo" name="chave" size="15">    
      <? } ?>
	  <select name="campo" class="campo" onChange="form1.action='p_list_imoveis.php';form1.submit();">
      <option value="ref" <? if($campo=='ref'){ echo "SELECTED"; } ?>>Referência</option>
      <option value="titulo" <? if($campo=='titulo'){ echo "SELECTED"; } ?>>Título</option>
      <option value="descricao" <? if($campo=='descricao'){ echo "SELECTED"; } ?>>Descrição</option>
      <option value="end" <? if($campo=='end'){ echo "SELECTED"; } ?>>Endereço do Imóvel</option>
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
      <?php
         if(isset($_GET['form_servico'])){
      ?>
        <input type="hidden" value="1" name="form_servico">
      <?php
         $nome_formulario = 'form1';
         }else{
         $nome_formulario = 'formulario';}
      ?>
      <input type="submit" value="Pesquisar Imóvel" name="B1" class=campo3></td>
    </tr>
  </form>
                  <!--tr><td colspan="4" bgcolor="#<?php// print("$cor6"); ?>">
                  <p align="right"><b>
                  <?php// print("$tipo1"); ?></b></td></tr-->
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
	$from = $from + 1;

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
if(isset($_GET['form_servico'])){$nome_formulario = 'form1';}else{$nome_formulario = 'formulario';}
//echo "Mostra ==> ".$nome_formulario;
//die();
?>
<tr bgcolor="<?php print("$fundo"); ?>">
	<td class=style1>
<a href="p_edit_imoveis.php?cod=<?php print("$not[cod]"); ?>&edit=editar" class="style1"><?php print("$not[ref]"); ?></a></td><td class=style1>
<?php print $not[tipo_logradouro]; ?> <?php print $not[end]; ?> , <?php print $not[numero]; ?></td><td class=style1>
<?php print($fin); ?></td><td class=style1>
<input type="button" onClick="window.opener.document.<?php print("$nome_formulario");?>.nome_imovel.value='<?php print("Ref.: $not[ref] - ".$not[tipo_logradouro]." ".$not[end].", ".$not[numero].""); ?>'; window.opener.document.<?php print("$nome_formulario");?>.co_imovel.value='<?php print("$not[cod]"); ?>'; window.opener.focus(); window.close();" class="campo3" value="Selecionar"></td>
<!--a href="#" onClick="window.opener.document.formulario.nome_imovel.value='<?php print("Ref.: $not[ref] - ".strip_tags($titulo).""); ?>'; window.opener.document.formulario.co_imovel.value='<?php print("$not[cod]"); ?>'; window.opener.focus(); window.close();" class="style1">Selecionar</a></td-->
</tr>
<?php
	}
	}
	
	if($list == ""){
	$query2 = "select count(cod) as contador 
	from muraski where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}else{
		if($finalidade <> ''){
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
	$pages = ceil($not2[contador] / 30);
?>
                  <tr><td colspan="4" bgcolor="#<?php print("$cor3"); ?>" align=center class="style1">               
                  Foram encontrados <?php print("$not2[contador]"); ?> Serviços</td></tr>
                  <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan="4" align="center" class=style1>
<?php
/*
	for ($i = 1; $i <= $pages; $i++) {

  	$url2 = $PHP_SELF . "?screen=" . $i . "&tipo1=" . $tipo1 . "&campo=" . $campo . "&chave=" . $chave . "&finalidade=" . $finalidade . "&list=" . $list;

  	if($i == $screen){
  	echo "   | <a href=\"$url2\" class=style1><b>$i</b></a> |   ";
	}
  	else
  	{
  	echo "   | <a href=\"$url2\" class=style1>$i</a> |   ";	
  	}
	}
*/
	
	for ($i = 0; $i < $pages; $i++) {	  
  	$url2 = $PHP_SELF . "?screen=" . $i . "&tipo1=" . $tipo1 . "&campo=" . $campo . "&chave=" . $chave . "&finalidade=" . $finalidade . "&list=" . $list;
  	//echo "   | <a href=\"$url2\" class=linkp>$j</a> |   ";
  		if(((($screen - 9) < $i) and (($screen + 9) > $i)) or ($i == 0) or ($i == ($pages -1))){
  			if($i == $screen){
  				echo "   | <a href=\"$url2\" class=style7><b>$i</b></a> |   ";
			}elseif($i == 0){
  				echo "   | <a href=\"$url2\" class=style1><b>Primeira</b></a> |   ";
			}elseif($i == ($pages - 1)){
  				echo "   | <a href=\"$url2\" class=style1><b>Última</b></a> |   ";
			}else{
  				echo "   | <a href=\"$url2\" class=style1>$i</a> |   ";	
  			}
  		}
	}

?>
</td></tr>
<?php
	if($from >= $not2[contador]){
?>
                  <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan="2" class=style1>
                  
                  <a href="javascript:history.back()" class="style1">
                  << Página anterior </a></td><td colspan="2" class=style1>
                  
                  Última página da pesquisa</td></tr>
<?php
	}
	else
	{
?>
                  <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan="2" class=style1>
                  
                  <a href="javascript:history.back()" class="style1">
                  << Página anterior </a></td><td colspan="2" class=style1>
                  
                  <a href="<?php print("$PHP_SELF"); ?>?screen=<?php $screen = $screen+1; print("$screen"); ?>&campo=<?php print("$campo"); ?>&tipo1=<?php print("$tipo1"); ?>&chave=<?php print("$chave"); ?>&query_finalidade=<?php print("$query_finalidade"); ?>&list=<?php print("$list"); ?>" class="style1">
                  Próxima página >></a></td></tr>
<?php
	}
?>
	</table>
	</center>
	</div>
<?php
	}
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
</body>
</html>
