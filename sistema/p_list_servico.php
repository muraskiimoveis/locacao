<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
//verificaArea("IMOV_GERAL");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<?php
	if(!$from){
		$from = intval($screen * 30);
	}

//	$query1 = '';
    if($lista == ""){
	  $query1 = "select * from tipo_servico WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by nome_servico limit $from, 30";
	}
//	echo "Mostra ==> ".$query1;
//    die();
    $result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table border="0" cellpadding="1" cellspacing="1" width="95%">
	<form method="get" action="p_list_servico.php">
	  <input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
    <tr>
		<td height="50" colspan=5 class="style1" align="center"><b>Relação de Serviços</b></td>
	</tr>
	<tr class="fundoTabela" align="center"">
      <td colspan=5 class=style1><b>Palavra Chave:</b>
      <input type="text" class="campo" name="nome_servico" size="40">
      <select size="1" name="campo" class="campo">
       <option value="nome_servico">Nome</option>
       <option value="situacao">Tipo</option>
      </select> <input type="submit" value="Pesquisar" name="B1" class=campo3></td>
    </tr>
    <tr align="center">
	      <td colspan=5 class=style1><br><br><div align="left"><span class="style7">Se o Servi&ccedil;o n&atilde;o est&aacute; cadastrado </span></div></td>
    </tr>
  </form>
<tr class="fundoTabelaTitulo">
<td width="35%" class="style1"><b>Nome</td>
<td align="center" width="20%" class="style1"><b>Tipo</b></td>
<td align="center" width="15%" class="style1"></td>
<td align="center" width="15%" class="style1"></td>
<td align="center" width="15%" class="style1"></td>
</tr>
<?php
	$i = 0;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
?>
<tr class="<?php echo $fundo; ?>">
<td class="style1"><p align="left">
<?php print("$not[nome_servico]"); ?></td>
<td class="style1">
<p align="center">
<?php print("$not[situacao]"); ?></td>
<td class="style1"></td>
<td class="style1">
<p align="center">
<input type="button" onClick="window.opener.document.form1.nome_servico.value='<?php print("$not[nome_servico]"); ?>'; window.opener.document.form1.de_tipo.value='<?php print("$not[id_servico]"); ?>'; window.opener.document.form1.situacao.value='<?php print("$not[situacao]"); ?>'; window.opener.focus(); window.close();" class="campo3" value="Selecionar"></td>
<?php
	}
	
	if($list == ""){
    	$query2 = "select count(id_servico) as contador from tipo_servico WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
  <tr class="fundoTabelaTitulo">
  	<td colspan="5" class="style1">
		<p align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> servi&ccedil;os</b></p>
	</td>
  </tr>
  <tr>
  	<td colspan=5 class="style1"><p align="center" class="style1">
<?php
	if ($from > 30) {
?>
                  <a href="javascript:history.back()" class="style1"><< Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class="style1">
                  << Página anterior <<</a>
<?php
	}
?>
<br>
<?php
	for ($i = 0; $i < $pages; $i++) {
  	$url2 = "$PHP_SELF?screen=" . $i . "&list=" . $list . "&c_nome=" . $c_nome . "&campo=" . $campo . "&dia=" . $dia . "&mes=" . $mes . "&ano=" . $ano . "&dia1=" . $dia1 . "&mes1=" . $mes1 . "&ano1=" . $ano1 . "&data_tipo=" . $data_tipo;
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
<br>
<?php
	if ($from >= $not2[contador]) {
?>
		  Última página da pesquisa
<?php
	}
	else
	{
	$url3 = "$PHP_SELF?screen=" . ($screen + 1) . "&list=" . $list . "&c_nome=" . $c_nome . "&campo=" . $campo . "&dia=" . $dia . "&mes=" . $mes . "&ano=" . $ano . "&dia1=" . $dia1 . "&mes1=" . $mes1 . "&ano1=" . $ano1 . "&data_tipo=" . $data_tipo;
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
?>
</table>
<?php
mysql_close($con);
?>
</body>
</html>
