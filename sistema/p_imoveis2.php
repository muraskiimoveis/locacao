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
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
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
if ($_GET['cod']) {

    $cod = $_GET['cod'];

	$query4= "update muraski set finalidade='2', status='1' where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");
	$query40 = "update vendas set v_status='I' where v_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result40 = mysql_query($query40) or die("Não foi possível atualizar suas informações. $query40");
	$query50 = "update sinal_venda set s_status='I' where cod_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result50 = mysql_query($query50) or die("Não foi possível atualizar suas informações. $query50");
	$query60 = "update propostas set p_status='I' where cod_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result60 = mysql_query($query60) or die("Não foi possível atualizar suas informações. $query60");
	print('<script language="javascript">alert("Imóvel ativado com sucesso!");document.location.href="p_edit_imoveis.php?cod='.$cod.'&edit=editar";</script>');

}


if ($_GET['id_excluir_def']) {
  
  	$B1 = "Apagar Imóvel Definitivamente";	
	$id_excluir_def = $_GET['id_excluir_def'];
	$referencia = $_GET['referencia'];

	$query4 = "select * from muraski where cod='$id_excluir_def' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die ("Erro 64 - ".mysql_error());
	$numrows4 = mysql_num_rows($result4);

   if($numrows4 > 0){
		while ($not4 = mysql_fetch_array($result4)) {

         for ($i = 0; $i < 41; $i++) {
            $foto = $not4[ref] . "_" . ($i). ".jpg";
            if (file_exists($caminhob.$foto)) {
               unlink($caminhob.$foto);
            }
         }

      }
   }

   $data = date("Y-m-d");
   $hora = date("H:i:s");

	//Insere o usuário que esta fazendo a atualização do imovel
   $insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$id_excluir_def."','".$referencia."','".$B1."','".$data."','".$hora."')") or die ("Erro 87 - ".mysql_error());

	//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
   $busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$id_excluir_def."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 90 - ".mysql_error());
   $cont = mysql_num_rows($busca_reg);
   if($cont > 10) {
      mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 93 - ".mysql_error());
   }
	
?>
<p align="center" class="style7">Você apagou definitivamente o imóvel Ref.: <?php print("$referencia"); ?>.</p>
<?php
   	$query = "delete from muraski where cod = '$id_excluir_def' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");

}


if ($_GET['id_excluir']) {

	$B1 = "Apagar Imóvel";	
	$id_excluir = $_GET['id_excluir'];
	$referencia = $_GET['referencia'];

	$query4 = "select * from muraski where cod='$id_excluir' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die ("Erro 112 - ".mysql_error());
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
	$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$id_excluir."','".$referencia."','".$B1."','".$data."','".$hora."')") or die ("Erro 133 - ".mysql_error());

	//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
	$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 136 - ".mysql_error());
	$cont = mysql_num_rows($busca_reg);
	if($cont > 10){
		mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 139 - ".mysql_error());
	}

?>
<p align="center" class="style7">Você apagou o imóvel Ref.: <?php print("$referencia"); ?>.</p>
<?php
   $query = "update muraski set ref='x' where cod = '$id_excluir' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   $result = mysql_query($query) or die("Não foi possível apagar suas informações.");
}

if ($_POST['altera']=="1") {

    $B1 = "Atualizar Imóvel";
	$titulo = AddSlashes(strip_tags($titulo));
	$desc = AddSlashes(strip_tags($descricao));
	$permuta_txt = AddSlashes($permuta_txt);
   $construtora = $_POST['construtora'];
   $idade_imovel = $_POST['idade_imovel'];
   $condominio = $_POST['condominio'];
   $apto = $_POST['apto'];
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
	$video = $_POST['video'];
	$origem_video = $_POST['origem_video'];
	
	$end_igual = $_POST['end_igual'];
	$end_aproximado = $_POST['end_aproximado'];
	$tipo_logradouro_mapa = $_POST['tipo_logradouro_mapa'];
	$ende_mapa = $_POST['ende_mapa'];
	$numero_end_mapa = $_POST['numero_end_mapa'];
	$cep_mapa = $_POST['cep_mapa'];
	
	if($end_igual=='1'){
		$tipo_logradouro_mapa = '';
		$ende_mapa = '';
		$numero_end_mapa = '';  
		$cep_mapa = '';
	}
	
	if($permuta=='Não'){
		$permuta_txt = '';
	}
	

   if ($_POST['comissao_parceria']=='diferenciado') {

      $comissao_parceria = $comissao_diferenciado;

   } else {

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
	
	$numero3 = count($_POST['tipo_secundario']);

		   for ($i4 = 0; $i4 <= ($numero3 - 1); $i4++)
		   {
			   $j4 = $i4 + 1;
			   if($j4 == $numero3){
				$tipo_secundario1 .= "-".$tipo_secundario[$i4]."-";
			   }else{
				$tipo_secundario1 .= "-".$tipo_secundario[$i4] . "-";
			   }
		   }

	$i3 = $_POST['contador'];

	for($j3 = 1; $j3 <= $i3; $j3++)
	{	     
		$clientes2 = "cliente_".$j3;
	   	$cliente .= "-".$_POST[$clientes2]."-";   	
	   	$percentuais2 = "percentual_".$j3;
	   	$percentual .= "-".$_POST[$percentuais2]."-";
	   	$soma_percentual1 = $_POST[$percentuais2];
         if($i3=='1' && $percentual_1==''){
            $percentual = '-100-';
         }
         $total_perc1 = $total_perc1 + $soma_percentual1;
  	}

	$i2 = $_POST['cont'];

	for($j2 = 1; $j2 <= $i2; $j2++)
	{	     
         $clientes = "cliente4_".$j2;
         $cliente .= "-".$_POST[$clientes]."-";
         $percentuais = "percentual4_".$j2;
         $percentual .= "-".$_POST[$percentuais]."-"; 
         $soma_percentual2 = $_POST[$percentuais];
         if($_POST[$clientes]==''){
	      $cliente = ''; 
	     }
		 if($i2=='1' && $percentual4_1=='' && $_POST[$clientes]<>''){
            $percentual = '-100-';   
         }elseif($_POST[$clientes]==''){
	    	$percentual = '';
	  	 }       
	  	 $total_perc2 = $total_perc2 + $soma_percentual2;
  	}
  	$totais_perc = $total_perc1 + $total_perc2;
	$totalperc = $totais_perc;
  	
  	if($cliente<>''){
	  $conta_p = $i2 + $i3;
	}else{
	  $conta_p = '';
	}
	
	$data = date("Y-m-d");
	$hora = date("H:i:s");
	
	//Insere o usuário que esta fazendo a atualização do imovel
	$insere = mysql_query ("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."', '".$u_cod."','".$cod."','".$ref."','".$B1."','".$data."','".$hora."')") or die ("Erro 268 - ".mysql_error());
	
	//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
	$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 271 - ".mysql_error());
	$cont = mysql_num_rows($busca_reg);
	if($cont > 10){
		mysql_query ("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 274 - ".mysql_query());
	}
	          
    if($opcao=='2'){
	  $dist_mara = $dist_mar1;
	  $dist_tipoa = '';
	}elseif($opcao=='1'){
	  $dist_mara = $dist_mar;
	  $dist_tipoa = $dist_tipo;
	}elseif($cidade_litoranea<>'1'){
	  $dist_mara = '';
	  $dist_tipoa = '';
	}
		$msgErro = '';
	
		if($totalperc > 100){
		  
			$msgErro .= "A soma total dos percentuais dos proprietários é maior que 100!";  
		}

		if($msgErro != "")
		{	 		
	 		echo('<script language="javascript">alert("'.$msgErro.'!");document.location.href="p_edit_imoveis.php?cod='.$cod.'&edit=editar";</script>');
		}
		else
		{


    if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){

	$query = "update muraski set ref='$ref',
	tipo='$tipo1', tipo_secundario='".$tipo_secundario1."', metragem='$metragem', area_terreno = '".$area_terreno."', matricula_luz = '".$matricula_luz."'
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
	, cliente='$cliente', percentual_prop='$percentual', matricula='$matricula', cidade_mat='$cidade_mat', bairro = '".$bairro1."'
	, tipo_logradouro='$tipo_logradouro', end='$ende', numero='$numero_end', cep='$cep', averbacao='$averbacao', acomod='$acomod'
	, dist_mar='$dist_mara', dist_tipo='$dist_tipoa', limpeza='$limpeza'
	, diaria1='$diaria1', diaria2='$diaria2', data_inicio='$data_inicio'
	, data_fim='$data_fim', comissao='$comissao', dias='$dias', contrato='$contrato'
	, carnaval='$carnaval', anonovo='$anonovo', coordenadas = '".$coordenadas."', posx='$posx', posy='$posy', tv='$tv'
	, angariador='$angariador', zelador='$zelador', tipo_anga='$tipo_anga', indicador='$co_cliente2'
   , comissao_indicador='$comissao_indicador', comissao_vendedor='$comissao_vendedor', diarista='$co_diarista'
   , comissao_diarista='$comissao_diarista', piscineiro='$co_piscineiro', comissao_piscineiro='$comissao_piscineiro'
   , eletricista='$co_eletricista', comissao_eletricista='$comissao_eletricista', encanador='$co_encanador'
   , comissao_encanador='$comissao_encanador', jardineiro='$co_jardineiro', comissao_jardineiro='$comissao_jardineiro'
   , chaves='$chaves', controle_chave='$controle_chave', tipo_div='$tipo_div', valor_oferta='$valor_oferta'
   , relacao_bens='$relacao_bens', observacoes = '".$observacoes."', disponibilizar = '".$disponibilizar."'
   , disp_rede = '".$disp_rede."', destaque = '".$destaque."', destaque_padrao = '".$destaque_padrao."'
   , lancamento='".$lancamento."', comissao_parceria = '".$comissao_parceria."'
   , contador = '".$conta_p."', construtora = '$construtora', idade_imovel = '$idade_imovel', condominio = '$condominio', apto = '$apto'
   , end_igual = '$end_igual', end_aproximado='$end_aproximado', tipo_logradouro_mapa = '$tipo_logradouro_mapa', end_mapa = '$ende_mapa', numero_mapa = '$numero_end_mapa', cep_mapa = '$cep_mapa', video='$video', origem_video='$origem_video'
	where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");



	} else {

	$query = "update muraski set ref='$ref',
	tipo='$tipo1', tipo_secundario='".$tipo_secundario1."', metragem='$metragem', area_terreno = '".$area_terreno."', matricula_luz = '".$matricula_luz."'
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
	, cliente='$cliente', percentual_prop='$percentual', matricula='$matricula', cidade_mat='$cidade_mat', bairro = '".$bairro1."'
	, tipo_logradouro='$tipo_logradouro', end='$ende', numero='$numero_end', cep='$cep', averbacao='$averbacao'
	, dist_mar='$dist_mara', dist_tipo='$dist_tipoa'
	, data_inicio='$data_inicio'
	, data_fim='$data_fim', comissao='$comissao', dias='$dias', contrato='$contrato'
	, coordenadas = '".$coordenadas."', posx='$posx', posy='$posy'
	, angariador='$angariador', zelador='$zelador', tipo_anga='$tipo_anga', indicador='$co_cliente2'
   , comissao_indicador='$comissao_indicador', comissao_vendedor='$comissao_vendedor', chaves='$chaves'
   , controle_chave='$controle_chave', tipo_div='$tipo_div', valor_oferta='$valor_oferta', relacao_bens='$relacao_bens'
   , observacoes = '".$observacoes."', disponibilizar = '".$disponibilizar."', disp_rede = '".$disp_rede."'
   , destaque = '".$destaque."', destaque_padrao = '".$destaque_padrao."', lancamento='".$lancamento."'
   , comissao_parceria = '".$comissao_parceria."', contador='".$conta_p."'
   , construtora = '$construtora', idade_imovel = '$idade_imovel', condominio = '$condominio', apto = '$apto'
   , end_igual = '$end_igual', end_aproximado='$end_aproximado', tipo_logradouro_mapa = '$tipo_logradouro_mapa', end_mapa = '$ende_mapa', numero_mapa = '$numero_end_mapa', cep_mapa = '$cep_mapa', video='$video', origem_video='$origem_video'
	where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");

	}

?>
<p align="center" class="style7">Você atualizou o imóvel Ref.: <?php print("$ref"); ?>.</p>
<?php
	}
}

	$query1 = "select distinct m.tipo, m.finalidade, t.t_nome
	from muraski m INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) where m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by t.t_nome";
	$result1 = mysql_query($query1) or die ("Erro 359 - ".mysql_query());
	$numrows1 = mysql_num_rows($result1);
	if ($numrows1 > 0) {
?>
<div align="center">
  <center>
  	<table width="75%" cellpadding="1" cellspacing="1">
		<tr height="50">
			<td colspan="3" class="style1"><p align="center"><a href="p_pesq_imoveis.php" class="style1"><b>Pesquisar Imóveis</b></a><br />Estes são os imóveis cadastrados até o momento</td>
		</tr>
        <tr class="fundoTabelaTitulo">
        	<td class="style1"><b>Tipo</b></td>
        	<td class="style1"><b>Finalidade</b></td>
        	<td class="style1"><b>Quantidade</b></td>
        </tr>
<?php
	$i = 0;

	while($not = mysql_fetch_array($result1))
	{

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
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
<tr class="<?php print("$fundo"); ?>">
	<td class="style1"><a href="p_lista_edit.php?tipo1=<?php print("$not[tipo]"); ?>&finalidade=<?php print($not[finalidade]); ?>&angariador=%" class="style1"><?php print("$not[t_nome]"); ?></a></td>
	<td class="style1"><?php print($fin); ?></td>
	<td class="style7">
<?php
	$query2 = "select count(tipo) as q_tipo 
	from muraski where tipo='$not[tipo]' and finalidade='$not[finalidade]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by tipo";
	$result2 = mysql_query($query2) or die ("Erro 429 - ".mysql_error());
	
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
	$result3 = mysql_query($query3) or die ("Erro 442 - ".mysql_error());

	while($not3 = mysql_fetch_array($result3))
	{
?>
    <tr class="fundoTabelaTitulo">
    	<td colspan="3" class="style1"><p align="center"><b>Total de <?php print("$not3[q_cod]"); ?> imóveis.</b></p></td>
    </tr>
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
<?  if(session_is_registered("valid_user")){ ?>
<br>
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
    <input type="button" name="voltar" id="voltar" class="campo3" value="Voltar" OnClick="javascript:history.go(-2);"><br>
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