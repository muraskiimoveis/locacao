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
<p>
<?php
if($_GET['id_excluir_def'])
	{
	$id_excluir_def = $_GET['id_excluir_def'];
	$referencia = $_GET['referencia'];

	$query4 = "select * from muraski where cod='$id_excluir_def' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	
	if($numrows4 > 0){
		while($not4 = mysql_fetch_array($result4))
	{

	for ($i = 0; $i < 41; $i++) {
		$foto = $not4[ref] . "_" . ($i). ".jpg";
			if (file_exists($caminhob.$foto))
			{
				unlink($caminhob.$foto);
			}
	}

}
}


	$data = date("Y-m-d");
	$hora = date("H:i:s");
	
	//Insere o usuário que esta fazendo a atualização do imovel
	$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$id_excluir_def."','".$B1."','".$data."','".$hora."')");
	
	//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
	$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$id_excluir_def."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	$cont = mysql_num_rows($busca_reg);
	if($cont > 10){
		mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1");
	}
	
?>
<p align="center" class="style1">
Você apagou definitivamente o imóvel Ref.: <?php print("$referencia"); ?>.</font></p>
<?php
   	$query = "delete from muraski where cod = '$id_excluir_def' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");

	}


if($_GET['id_excluir'])
	{
	$id_excluir = $_GET['id_excluir'];
	$referencia = $_GET['referencia'];

	$query4 = "select * from muraski where cod='$id_excluir' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	
	if($numrows4 > 0){
		while($not4 = mysql_fetch_array($result4))
		{
			for ($i = 0; $i < 41; $i++) {
				$foto = $not4[ref] . "_" . ($i). ".jpg";
				if (file_exists($caminhob.$foto))
				{
					unlink($caminhob.$foto);
				}
			}

		}
	}
	
	$data = date("Y-m-d");
	$hora = date("H:i:s");
	
	//Insere o usuário que esta fazendo a atualização do imovel
	$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$id_excluir."','".$B1."','".$data."','".$hora."')");
	
	//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
	$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	$cont = mysql_num_rows($busca_reg);
	if($cont > 10){
		mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1");
	}
	
?>
<p align="center" class="style1">
Você apagou o imóvel Ref.: <?php print("$referencia"); ?>.</font></p>
<?php
    $query = "update muraski set ref='x' where cod = '$id_excluir' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
	}
if($B1 == "Atualizar Imóvel")
	{
	
	$titulo = AddSlashes($titulo);
	$desc = AddSlashes($descricao);
	$permuta_txt = AddSlashes($permuta_txt);
	$ftxt_1 = AddSlashes($ftxt_1);
	$ftxt_2 = AddSlashes($ftxt_2);
	$ftxt_3 = AddSlashes($ftxt_3);
	$ftxt_4 = AddSlashes($ftxt_4);
	$ftxt_5 = AddSlashes($ftxt_5);
	$ftxt_6 = AddSlashes($ftxt_6);
	$ftxt_7 = AddSlashes($ftxt_7);
	$ftxt_8 = AddSlashes($ftxt_8);
	$ftxt_9 = AddSlashes($ftxt_9);
	$ftxt_10 = AddSlashes($ftxt_10);
	$ftxt_11 = AddSlashes($ftxt_11);
	$ftxt_12 = AddSlashes($ftxt_12);
	$ftxt_13 = AddSlashes($ftxt_13);
	$ftxt_14 = AddSlashes($ftxt_14);
	$ftxt_15 = AddSlashes($ftxt_15);
	$ftxt_16 = AddSlashes($ftxt_16);
	$ftxt_17 = AddSlashes($ftxt_17);
	$ftxt_18 = AddSlashes($ftxt_18);
	$ftxt_19 = AddSlashes($ftxt_19);
	$ftxt_20 = AddSlashes($ftxt_20);
	$data_inicio = "$anoe-$mese-$diae";
	$data_fim = "$anoe1-$mese1-$diae1";
	
	$area_averbada = $_POST['area_averbada'];
	$area_terreno = $_POST['area_terreno'];
	$matricula_luz = $_POST['matricula_luz'];
	$situacao_luz = $_POST['situacao_luz'];
	$matricula_agua = $_POST['matricula_agua'];
	$situacao_agua = $_POST['situacao_agua'];
	$observacoes = $_POST['observacoes'];
	$indicador = $_POST['co_cliente2'];
	$comissao_indicador = $_POST['comissao_indicador'];
	$comissao_vendedor = $_POST['comissao_vendedor'];
	$diarista = $_POST['co_diarista'];
	$comissao_diarista = $_POST['comissao_diarista'];
	$piscineiro = $_POST['co_piscineiro'];
	$comissao_piscineiro = $_POST['comissao_piscineiro'];
	$eletricista = $_POST['co_eletricista'];
	$comissao_eletricista = $_POST['comissao_eletricista'];
	$encanador = $_POST['co_encanador'];
	$comissao_encanador = $_POST['comissao_encanador'];
	$jardineiro = $_POST['co_jardineiro'];
	$comissao_jardineiro = $_POST['comissao_jardineiro'];
	$contrato = $_POST['contrato'];
	$finalidade = $_POST['finalidade'];
	$uf = $_POST['im_estado'];
	
	if($_POST['comissao_parceria']=='diferenciado'){
	  $comissao_parceria = $comissao_diferenciado;
	}else{
	  $comissao_parceria = $comissao_parceria;  
	}
	
	
	$numero = count($_POST['bairro']);
			
		   for ($i = 0; $i <= ($numero - 1); $i++) 
		   {
			   $j = $i + 1;
			   if($j == $numero){
				$bairro1 .= "-".$bairro[$i]."-";
			   }else{
				$bairro1 .= "-".$bairro[$i] . "-";
			   }			 
		   }
		   
	$numero2 = count($_POST['caracteristica']);
			
		   for ($i2 = 0; $i2 <= ($numero2 - 1); $i2++) 
		   {
			   $j2 = $i2 + 1;
			   if($j2 == $numero2){
				$caracteristica1 .= "-".$caracteristica[$i2]."-";
			   }else{
				$caracteristica1 .= "-".$caracteristica[$i2] . "-";
			   }			 
		   }
	
	$data = date("Y-m-d");
	$hora = date("H:i:s");
	
	//Insere o usuário que esta fazendo a atualização do imovel
	$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."', '".$u_cod."','".$cod."','".$B1."','".$data."','".$hora."')");
	
	//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
	$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	$cont = mysql_num_rows($busca_reg);
	if($cont > 10){
		mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1");
	}
	          
    if($opcao=='2'){
	  $dist_mara = $dist_mar1;
	  $dist_tipoa = '';
	}elseif($opcao=='1'){
	  $dist_mara = $dist_mar;
	  $dist_tipoa = $dist_tipo;
	}
    
    if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
	
	$query = "update muraski set ref='$ref', 
	tipo='$tipo1', metragem='$metragem', area_terreno = '".$area_terreno."', matricula_luz = '".$matricula_luz."'
	, situacao_luz = '".$situacao_luz."', matricula_agua = '".$matricula_agua."', situacao_agua = '".$situacao_agua."', 
	n_quartos='$n_quartos', valor='$valor', especificacao='$especificacao', 
	suites='$suites', caracteristica = '".$caracteristica1."', piscina='$piscina', titulo='$titulo', descricao='$desc'
	, uf='$uf', local='$local', permuta='$permuta', finalidade='$finalidade'
	, permuta_txt='$permuta_txt', ftxt_1='$ftxt_1', ftxt_2='$ftxt_2' 
	, ftxt_3='$ftxt_3' , ftxt_4='$ftxt_4' , ftxt_5='$ftxt_5' 
	, ftxt_6='$ftxt_6' , ftxt_7='$ftxt_7' , ftxt_8='$ftxt_8' 
	, ftxt_9='$ftxt_9' , ftxt_10='$ftxt_10', ftxt_11='$ftxt_11'
	, ftxt_12='$ftxt_12', ftxt_13='$ftxt_13', ftxt_14='$ftxt_14'
	, ftxt_15='$ftxt_15', ftxt_16='$ftxt_16', ftxt_17='$ftxt_17'
	, ftxt_18='$ftxt_18', ftxt_19='$ftxt_19', ftxt_20='$ftxt_20'
	, cliente='$cliente', matricula='$matricula', cidade_mat='$cidade_mat', bairro = '".$bairro1."'
	, end='$ende', averbacao='$averbacao', acomod='$acomod'
	, dist_mar='$dist_mara', dist_tipo='$dist_tipoa', limpeza='$limpeza'
	, diaria1='$diaria1', diaria2='$diaria2', data_inicio='$data_inicio'
	, data_fim='$data_fim', comissao='$comissao', dias='$dias', contrato='$contrato'
	, carnaval='$carnaval', anonovo='$anonovo', coordenadas = '".$coordenadas."', posx='$posx', posy='$posy', tv='$tv'
	, angariador='$angariador', zelador='$zelador', tipo_anga='$tipo_anga', indicador='$co_cliente2', comissao_indicador='$comissao_indicador', comissao_vendedor='$comissao_vendedor', diarista='$co_diarista', comissao_diarista='$comissao_diarista', piscineiro='$co_piscineiro', comissao_piscineiro='$comissao_piscineiro', eletricista='$co_eletricista', comissao_eletricista='$comissao_eletricista', encanador='$co_encanador', comissao_encanador='$comissao_encanador', jardineiro='$co_jardineiro', comissao_jardineiro='$comissao_jardineiro', chaves='$chaves', controle_chave='$controle_chave'
	, tipo_div='$tipo_div', valor_oferta='$valor_oferta', relacao_bens='$relacao_bens', observacoes = '".$observacoes."', disponibilizar = '".$disponibilizar."', disp_rede = '".$disp_rede."', destaque = '".$destaque."', comissao_parceria = '".$comissao_parceria."'  
	where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
	
	}else{
	
	$query = "update muraski set ref='$ref', 
	tipo='$tipo1', metragem='$metragem', area_terreno = '".$area_terreno."', matricula_luz = '".$matricula_luz."'
	, situacao_luz = '".$situacao_luz."', matricula_agua = '".$matricula_agua."', situacao_agua = '".$situacao_agua."', 
	n_quartos='$n_quartos', valor='$valor', especificacao='$especificacao', 
	suites='$suites', caracteristica = '".$caracteristica1."', piscina='$piscina', titulo='$titulo', descricao='$desc'
	, uf='$uf', local='$local', permuta='$permuta', finalidade='$finalidade'
	, permuta_txt='$permuta_txt', ftxt_1='$ftxt_1', ftxt_2='$ftxt_2' 
	, ftxt_3='$ftxt_3' , ftxt_4='$ftxt_4' , ftxt_5='$ftxt_5' 
	, ftxt_6='$ftxt_6' , ftxt_7='$ftxt_7' , ftxt_8='$ftxt_8' 
	, ftxt_9='$ftxt_9' , ftxt_10='$ftxt_10', ftxt_11='$ftxt_11'
	, ftxt_12='$ftxt_12', ftxt_13='$ftxt_13', ftxt_14='$ftxt_14'
	, ftxt_15='$ftxt_15', ftxt_16='$ftxt_16', ftxt_17='$ftxt_17'
	, ftxt_18='$ftxt_18', ftxt_19='$ftxt_19', ftxt_20='$ftxt_20'
	, cliente='$cliente', matricula='$matricula', cidade_mat='$cidade_mat', bairro = '".$bairro1."'
	, end='$ende', averbacao='$averbacao'
	, dist_mar='$dist_mara', dist_tipo='$dist_tipoa'
	, data_inicio='$data_inicio'
	, data_fim='$data_fim', comissao='$comissao', dias='$dias', contrato='$contrato'
	, coordenadas = '".$coordenadas."', posx='$posx', posy='$posy'
	, angariador='$angariador', zelador='$zelador', tipo_anga='$tipo_anga', indicador='$co_cliente2', comissao_indicador='$comissao_indicador', comissao_vendedor='$comissao_vendedor', chaves='$chaves', controle_chave='$controle_chave'
	, tipo_div='$tipo_div', valor_oferta='$valor_oferta', relacao_bens='$relacao_bens', observacoes = '".$observacoes."', disponibilizar = '".$disponibilizar."', disp_rede = '".$disp_rede."', destaque = '".$destaque."', comissao_parceria = '".$comissao_parceria."'  
	where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
	
	}

?>
<p align="center" class="style1">
Você atualizou o imóvel Ref.: <?php print("$ref"); ?>.</font></p>
<?php
	}
	$query1 = "select distinct m.tipo, m.finalidade, t.t_nome 
	from muraski m INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) where m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by t.t_nome";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<div align="center">
  <center>
                  <table width="500" cellpadding="1" cellspacing="1">
                  <tr><td colspan="3" class="style1">
                  <p align="center"><a href="p_pesq_imoveis.php" class="style1">
                  <b>Pesquisar Imóveis</b></a></td></tr>
                  <tr><td colspan="3" class="style1">
                  <p align="center">
                  Estes são os imóveis cadastrados até o momento</td></tr>
                  <tr bgcolor="#CCCCCC"><td>
                  <b class="style1">Tipo</b></td><td>
                  <b class="style1">Finalidade</b></td><td>
                  <b class="style7">Quantidade</b></td></tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{

	if (($i % 2) == 1){ $fundo="EDEEEE"; }else{ $fundo="f2f2f2"; }
	$i++;

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
  $fin = "Locação_Mensal_Rebri";
}elseif($not[finalidade]=='9'){
  $fin = "Locação_Mensal_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='10'){
  $fin = "Locação_Mensal_Parceria";
}elseif($not[finalidade]=='11'){
  $fin = "Locação_Mensal_Terceiros";
}elseif($not[finalidade]=='12'){
  $fin = "Locação_Mensal_Off";
}elseif($not[finalidade]=='13'){
  $fin = "Locação_Mensal_Locado";
}elseif($not[finalidade]=='14'){
  $fin = "Locação_Mensal_Todos";
}elseif($not[finalidade]=='15'){
  $fin = "Locação_Diária_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='16'){
  $fin = "Locação_Diária_Off";
}elseif($not[finalidade]=='17'){
  $fin = "Locação_Diária_Todos";
}

?>
<tr bgcolor="<?php print("$fundo"); ?>"><td class="style1">
<a href="p_lista_edit.php?tipo1=<?php print("$not[tipo]"); ?>&finalidade=<?php print($not[finalidade]); ?>" class="style1">
<?php print("$not[t_nome]"); ?></a></td><td class="style1">
<?php print($fin); ?></td><td class="style7">
<?php
	$query2 = "select count(tipo) as q_tipo 
	from muraski where tipo='$not[tipo]' and finalidade='$not[finalidade]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by tipo";
	$result2 = mysql_query($query2);
	
	while($not2 = mysql_fetch_array($result2))
	{
	print("$not2[q_tipo]");
	}
?>
</td></tr>
<?php
	}

	$query3 = "select count(cod) as q_cod 
	from muraski where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	
	while($not3 = mysql_fetch_array($result3))
	{
?>
                  <tr><td colspan="3" bgcolor="#CCCCCC" class="style1">
                  <p align="center">
                  Total de <b><?php print("$not3[q_cod]"); ?></b> imóveis.</td></tr>
	</table>
  </center>
	</div>
<?php
	}
	}
/*
mysql_free_result($result1);
mysql_free_result($result2);
mysql_free_result($result3);
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