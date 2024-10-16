<?php
ini_set('max_execution_time','120');
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
include("funcoes/funcoes.php");
verificaAcesso();
verificaArea("IMOV_GERAL");

if (strstr($_SERVER[SERVER_ADDR], "redebrasileiradeimoveis")) {
   $ori = "rebri";
} else {

   if(substr(1,3) == '192'){
       $ORIGEM = $_SERVER['HTTP_HOST'];	  
   }else{
   	  $ORIGEM = $_SERVER['HTTP_HOST'];
   }

   $ORIGEM = 'http://'.$ORIGEM.'/intranet/sistema/gera_mapa.php?coord=inicio&ori=muraski';

   $ori = "muraski";
}


?>
<html>
<head>
<?php
include("style.php");
?>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
/*
function google() {
   NewWindow('http://www.redebrasileiradeimoveis.com.br/gera_mapa.php?coord=inicio&ori=rebri', 'janela', 750, 500, 'yes');
}
*/
function google() {
   NewWindow('<? echo $ORIGEM ?>', 'janela', 750, 500, 'yes');
}

function VerificaCampo() {

   if(document.form1.finalidade.selectedIndex == 0)
	{
	   alert( "Por favor, selecione o campo Finalidade." );
		document.form1.finalidade.focus();
		document.form1.finalidade.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
	   document.form1.finalidade.style.backgroundColor = '<?=$cor1 ?>';
	}
	if(document.form1.tipo1.selectedIndex == 0)
	{
		alert( "Por favor, selecione o campo Tipo do imóvel." );
		document.form1.tipo1.focus();
		document.form1.tipo1.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
	  document.form1.tipo1.style.backgroundColor = '<?=$cor1 ?>';
	}
	if(document.form1.ref.value.length==0)
	{
		alert( "Por favor, preencha o campo Referência." );
		document.form1.ref.focus();
		document.form1.ref.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
   else
	{
	  	var er = new RegExp("^[0-9a-z_]+$");
   	if(er.test(document.form1.ref.value) == false)
	   {
		  	alert( "Não pode haver espaço nem caractere especial no campo Referência." );
			document.form1.ref.style.backgroundColor = '<?=$cor_erro ?>';
			document.form1.ref.focus();
			return false;
		}
		else
		{
			document.form1.ref.style.backgroundColor = '<?=$cor1 ?>';
		}
   }
	if (document.form1.cont.selectedIndex == 0)
  	{
	   alert("Por favor, selecione o n° de proprietários");
    	document.form1.cont.focus();
    	document.form1.cont.style.backgroundColor = '<?=$cor_erro ?>';
    	return false;
  	}
	else
	{
  		<? for($i = 1; $i <= $_POST['cont']; $i++){ ?>
  		if (document.form1.cliente_<?=$i ?>.value == "")
  		{
   		alert("Por favor, selecione o Proprietário <?=$i ?>");
   		document.form1.nome_cliente_<?=$i ?>.focus();
   		document.form1.nome_cliente_<?=$i ?>.style.backgroundColor = '<?=$cor_erro ?>';
   		return false;
  		}
  		else
  		{
		 	document.form1.nome_cliente_<?=$i ?>.style.backgroundColor = '<?=$cor1 ?>';
		}
		if (document.form1.percentual_<?=$i ?>.value == "")
  		{
   		alert("Por favor, preencha o campo Percentual <?=$i ?>");
   		document.form1.percentual_<?=$i ?>.focus();
   		document.form1.percentual_<?=$i ?>.style.backgroundColor = '<?=$cor_erro ?>';
   		return false;
  		}
  		else
  		{
		 	document.form1.percentual_<?=$i ?>.style.backgroundColor = '<?=$cor1 ?>';
		}
  		<? } ?>
	}
	if(document.form1.finalidade.value=="1" || document.form1.finalidade.value=="2" || document.form1.finalidade.value=="3" || document.form1.finalidade.value=="4" || document.form1.finalidade.value=="5" || document.form1.finalidade.value=="6" || document.form1.finalidade.value=="7")
	{
		if(document.form1.dias.value.length==0)
	   {
			alert( "Por favor, preencha o campo Dias úteis." );
			document.form1.dias.focus();
			document.form1.dias.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
	  		document.form1.dias.style.backgroundColor = '<?=$cor1 ?>';
		}
  	}
  	if(document.form1.dia.value.length==0)
  	{
    	alert( "Por favor, preencha o campo Dia Inicial de Contrato de." );
		document.form1.dia.focus();
		document.form1.dia.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
		document.form1.dia.style.backgroundColor = '<?=$cor1 ?>';
	}
  	if(document.form1.mes.value.length==0)
  	{
		alert( "Por favor, preencha o campo Mês Inicial de Contrato de." );
		document.form1.mes.focus();
		document.form1.mes.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
		document.form1.mes.style.backgroundColor = '<?=$cor1 ?>';
	}
 	if(document.form1.ano.value.length==0)
  	{
		alert( "Por favor, preencha o campo Ano Inicial de Contrato de." );
		document.form1.ano.focus();
		document.form1.ano.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
		document.form1.ano.style.backgroundColor = '<?=$cor1 ?>';
	}
  	if(document.form1.dia1.value.length==0)
  	{
    	alert( "Por favor, preencha o campo Dia Final de Contrato de." );
   	document.form1.dia1.focus();
		document.form1.dia1.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
		document.form1.dia1.style.backgroundColor = '<?=$cor1 ?>';
	}
  	if(document.form1.mes1.value.length==0)
  	{
		alert( "Por favor, preencha o campo Mês Final de Contrato de." );
		document.form1.mes1.focus();
		document.form1.mes1.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
		document.form1.mes1.style.backgroundColor = '<?=$cor1 ?>';
	}
  	if(document.form1.ano1.value.length==0)
  	{
		alert( "Por favor, preencha o campo Ano Final de Contrato de." );
		document.form1.ano1.focus();
		document.form1.ano1.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
		document.form1.ano1.style.backgroundColor = '<?=$cor1 ?>';
	}
  	if(document.form1.finalidade.value=="15" || document.form1.finalidade.value=="16" || document.form1.finalidade.value=="17")
  	{
		if(document.form1.valor.value.length==0)
		{
 			alert( "Por favor, preencha o campo Diária." );
			document.form1.valor.focus();
			document.form1.valor.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
			document.form1.valor.style.backgroundColor = '<?=$cor1 ?>';
		}
	}
	else
	{
		if(document.form1.valor.value.length==0)
		{
   	   alert( "Por favor, preencha o campo Valor." );
			document.form1.valor.focus();
			document.form1.valor.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
			document.form1.valor.style.backgroundColor = '<?=$cor1 ?>';
		}
   }
  	if(document.form1.comissao.value.length==0)
  	{
 		alert( "Por favor, preencha o campo Comissão Imobiliária." );
		document.form1.comissao.focus();
		document.form1.comissao.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
		document.form1.comissao.style.backgroundColor = '<?=$cor1 ?>';
	}
	if(document.form1.finalidade.value=="15" || document.form1.finalidade.value=="16" || document.form1.finalidade.value=="17")
   {
  	   if(document.form1.diaria1.value.length==0)
  		{
    		alert( "Por favor, preencha o campo Diária mínima." );
			document.form1.diaria1.focus();
			document.form1.diaria1.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
			document.form1.diaria1.style.backgroundColor = '<?=$cor1 ?>';
		}
  		if (document.form1.diaria2.value.length==0)
  		{
    		alert( "Por favor, preencha o campo Diária máxima." );
			document.form1.diaria2.focus();
			document.form1.diaria2.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
			document.form1.diaria2.style.backgroundColor = '<?=$cor1 ?>';
		}
  	}
  	if(document.form1.ende.value.length==0)
  	{
      alert( "Por favor, preencha o campo Endereço." );
		document.form1.ende.focus();
		document.form1.ende.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
		document.form1.ende.style.backgroundColor = '<?=$cor1 ?>';
	}
  	if(document.form1.im_estado.selectedIndex==0)
  	{
		alert( "Por favor, selecione o campo Estado." );
		document.form1.im_estado.focus();
		document.form1.im_estado.style.backgroundColor = '<?=$cor_erro ?>';
		return false;
	}
	else
	{
			document.form1.im_estado.style.backgroundColor = '<?=$cor1 ?>';
		}
  		if(document.form1.local.selectedIndex==0)
  		{
			alert( "Por favor, selecione o campo Localização." );
			document.form1.local.focus();
			document.form1.local.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
			document.form1.local.style.backgroundColor = '<?=$cor1 ?>';
		}
		if(document.form1.titulo.value.length==0)
  	   	{
  	    	alert( "Por favor, preencha o campo Título." );
			document.form1.titulo.focus();
			document.form1.titulo.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
			document.form1.titulo.style.backgroundColor = '<?=$cor1 ?>';
		}
		if(document.form1.descricao.value.length==0)
  	   	{
  	    	alert( "Por favor, preencha o campo Descrição." );
			document.form1.descricao.focus();
			document.form1.descricao.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		} 
		else
		{
			document.form1.descricao.style.backgroundColor = '<?=$cor1 ?>';
		}
  		
		if(document.form1.finalidade.value=="1" || document.form1.finalidade.value=="2" || document.form1.finalidade.value=="3" || document.form1.finalidade.value=="4" || document.form1.finalidade.value=="5" || document.form1.finalidade.value=="6" || document.form1.finalidade.value=="7")
	   	{
			if(document.form1.permuta.value=="Sim")
  			{
    			if(document.form1.permuta_txt.value.length==0)
  				{
    				alert( "Por favor, preencha o campo Texto da Permuta." );
					document.form1.permuta_txt.focus();
					document.form1.permuta_txt.style.backgroundColor = '<?=$cor_erro ?>';
					return false;
				} 
				else
				{
					document.form1.permuta_txt.style.backgroundColor = '<?=$cor1 ?>';
				}
  			}
        	else
  			{
            	document.form1.permuta_txt.style.backgroundColor = '<?=$cor1 ?>';
  			}
  		}
  		if(document.form1.n_quartos.value.length==0 && document.form1.tipo1.value != 6)
  		{
    		alert( "Por favor, preencha o campo N° de quartos." );
			document.form1.n_quartos.focus();
			document.form1.n_quartos.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
			document.form1.n_quartos.style.backgroundColor = '<?=$cor1 ?>';
		}
  		if(document.form1.finalidade.value=="15" || document.form1.finalidade.value=="16" || document.form1.finalidade.value=="17")
  		{
  			if(document.form1.acomod.value.length==0)
  			{
    			alert( "Por favor, preencha o campo Acomodações." );
				document.form1.acomod.focus();
				document.form1.acomod.style.backgroundColor = '<?=$cor_erro ?>';
				return false;
			}
			else
			{
				document.form1.acomod.style.backgroundColor = '<?=$cor1 ?>';
			}
  		}
  		if(document.form1.controle_chave.value.length==0 && document.form1.tipo1.value != 6)
  		{
    		alert( "Por favor, preencha o campo Controle Chaves." );
			document.form1.controle_chave.focus();
			document.form1.controle_chave.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.controle_chave.style.backgroundColor = '<?=$cor1 ?>';
		}
  		if(document.form1.chaves.value.length==0 && document.form1.tipo1.value != 6)
  		{
    		alert( "Por favor, preencha o campo Local Chaves." );
			document.form1.chaves.focus();
			document.form1.chaves.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
			document.form1.chaves.style.backgroundColor = '<?=$cor1 ?>';
		}
  		if(document.form1.angariador.selectedIndex==0)
  		{
			alert( "Por favor, selecione o campo Angariador." );
			document.form1.angariador.focus();
			document.form1.angariador.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		} 
		else
		{
			document.form1.angariador.style.backgroundColor = '<?=$cor1 ?>';
		}
  		if(document.form1.disp_rede.value=="1")
  		{
    		if(document.form1.comissao_parceria.value.length==0)
  			{
    			alert( "Por favor, preencha o campo Comissão oferecida p/ parceria." );
				document.form1.comissao_parceria.focus();
				document.form1.comissao_parceria.style.backgroundColor = '<?=$cor_erro ?>';
				return false;
			} 
			else
			{
				document.form1.comissao_parceria.style.backgroundColor = '<?=$cor1 ?>';
			}
  			if(document.form1.comissao_parceria.value=="diferenciado")
			{
	  			if(document.form1.comissao_diferenciado.value.length==0)
  				{
    				alert( "Por favor, preencha o campo Comissão." );
					document.form1.comissao_diferenciado.focus();
					document.form1.comissao_diferenciado.style.backgroundColor = '<?=$cor_erro ?>';
					return false;
				} 
				else
				{
					document.form1.comissao_diferenciado.style.backgroundColor = '<?=$cor1 ?>';
				}
			}
		}
		if(document.form1.video.value!="")
  		{
  			if(document.form1.origem_video.selectedIndex==0)
  			{
    			alert( "Por favor, selecion o campo Origem do Vídeo." );
				document.form1.origem_video.focus();
				document.form1.origem_video.style.backgroundColor = '<?=$cor_erro ?>';
				return false;
			}
			else
			{
			  	document.form1.origem_video.style.backgroundColor = '<?=$cor1 ?>';
			}
		}
	    document.form1.cadastra.value='1';
        document.form1.submit();
        return true;
}

function TravaCampo2(){

  if(document.getElementById('disp_rede1').checked){
    document.form1.comissao_parceria.disabled = true;
    document.form1.comissao_parceria.style.background = '#D6D6D6';
    document.form1.comissao_diferenciado.disabled = true;
    document.form1.comissao_diferenciado.style.background = '#D6D6D6';
  } else {
    document.form1.comissao_parceria.disabled = false;
    document.form1.comissao_parceria.style.background = '#FFFFFF';
    document.form1.comissao_diferenciado.disabled = false;
    document.form1.comissao_diferenciado.style.background = '#FFFFFF';
  }
}


function mostraCampos() {

	if(document.form1.comissao_parceria.value=='diferenciado')
	{
         document.form1.comissao_diferenciado.style.display = "block";
	}
	else
	{
         document.form1.comissao_diferenciado.style.display = "none";
	}
	
}

</script>
</head>
</head>
<body>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
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
if($_SESSION['u_cod'] == "")
{
	echo('<script language="javascript">alert("O campo angariador não veio carregado com seu usuário favor se deslogue e logue novamente no sistema para dar continuidade no cadastro de imóveis");</script>');
	die();
}
?>
<div align="center">
  <center>
  <table width="75%" border="0" cellpadding="1" cellspacing="1">
  <tr height="50"><td colspan=2 class=style1>
 <p align="center"><b>Inserir Imóveis</b><br>
 <a href="p_imoveis2.php" class="style1">
 Clique para visualizar a relação de imóveis</a></p></td></tr>
<?php

     if($_POST['end_igual']){
	    $end_igual = $_POST['end_igual'];
	 }else{
	   $end_igual = 1;
	}


if($_POST['cadastra']=='1')
{
	//$titulo = strip_tags($titulo);
	$titulo = AddSlashes($titulo);
	//$descricao = strip_tags($descricao);
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
	$data_inicio = "$ano-$mes-$dia";
	$data_fim = "$ano1-$mes1-$dia1";
   	$construtora = $_POST['construtora'];
   	$idade_imovel = $_POST['idade_imovel'];
   	$condominio = $_POST['condominio'];
   	$endereco_contrato = $_POST['endereco_contrato'];

	$cartorio_oficio = $_POST['cartorio_oficio'];
	$lote = $_POST['lote'];
	$quadra  = $_POST['quadra']; 
	$planta  = $_POST['planta'];

	$area_averbada = $_POST['area_averbada'];
	$area_terreno = $_POST['area_terreno'];
	$matricula_luz = $_POST['matricula_luz'];
	$situacao_luz = $_POST['situacao_luz'];
	$matricula_agua = $_POST['matricula_agua'];
	$situacao_agua = $_POST['situacao_agua'];
	$observacoes = AddSlashes($_POST['observacoes']);
	$endereco_contrato = AddSlashes($endereco_contrato);
	$chaves = AddSlashes($chaves);
	$relacao_bens = AddSlashes($relacao_bens);
	$observacoes2 = AddSlashes($observacoes2);
	$observacoes3 = AddSlashes($observacoes3);
	$uf = $_POST['im_estado'];

	$end_igual = $_POST['end_igual'];
	$end_aproximado = $_POST['end_aproximado'];
	$tipo_logradouro_mapa = $_POST['tipo_logradouro_mapa'];
	$ende_mapa = $_POST['ende_mapa'];
	$numero_end_mapa = $_POST['numero_end_mapa'];
	$cep_mapa = $_POST['cep_mapa'];
	$ncoordenadas = $_POST['ncoordenadas'];

	$valor = str_replace(".", "", $_POST['valor']);
	$valor = str_replace(",", ".", $valor);

	$valor_oferta = str_replace(".", "", $_POST['valor_oferta']);
	$valor_oferta = str_replace(",", ".", $valor_oferta);

	$carnaval = str_replace(".", "", $_POST['carnaval']);
	$carnaval = str_replace(",", ".", $carnaval);

	$anonovo = str_replace(".", "", $_POST['anonovo']);
	$anonovo = str_replace(",", ".", $anonovo);

	$diaria1 = str_replace(".", "", $_POST['diaria1']);
	$diaria1 = str_replace(",", ".", $diaria1);

	$diaria2 = str_replace(".", "", $_POST['diaria2']);
	$diaria2 = str_replace(",", ".", $diaria2);

	$limpeza = str_replace(".", "", $_POST['limpeza']);
	$limpeza = str_replace(",", ".", $limpeza);

	$tv = str_replace(".", "", $_POST['tv']);
	$tv = str_replace(",", ".", $tv);

	$comissao_diarista = str_replace(".", "", $_POST['comissao_diarista']);
	$comissao_diarista = str_replace(",", ".", $comissao_diarista);

	$comissao_piscineiro = str_replace(".", "", $_POST['comissao_piscineiro']);
	$comissao_piscineiro = str_replace(",", ".", $comissao_piscineiro);

	$comissao_jardineiro = str_replace(".", "", $_POST['comissao_jardineiro']);
	$comissao_jardineiro = str_replace(",", ".", $comissao_jardineiro);

	$comissao_eletrecista = str_replace(".", "", $_POST['comissao_eletrecista']);
	$comissao_eletrecista = str_replace(",", ".", $comissao_eletrecista);

	$comissao_encanador = str_replace(".", "", $_POST['comissao_encanador']);
	$comissao_encanador = str_replace(",", ".", $comissao_encanador);

	if($end_igual=='1'){
		$tipo_logradouro_mapa = '';
		$ende_mapa = '';
		$numero_end_mapa = '';
		$cep_mapa = '';
	}
	
	if($disp_rede=='0'){
	  $comissao_parceria = '';
	}
	
	if($permuta=='Não'){
		$permuta_txt = '';
	}
	
	
	if($exibir_endereco<>'1'){
		$exibir_endereco = 0;
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

		   for ($i3 = 0; $i3 <= ($numero3 - 1); $i3++)
		   {
			   $j3 = $i3 + 1;
			   if($j3 == $numero3){
				$tipo_secundario1 .= "-".$tipo_secundario[$i3]."-";
			   }else{
				$tipo_secundario1 .= "-".$tipo_secundario[$i3] . "-";
			   }
		   }


	$i2 = $_POST['cont'];
	$c2 = 0;

	for($j2 = 1; $j2 <= $i2; $j2++)
	{
		$clientes = "cliente_".$j2;
	    $cliente .= "-".$_POST[$clientes]."-";
		$percentuais = "percentual_".$j2;
	    $percentual .= "-".$_POST[$percentuais]."-";
	    $soma_percentual = $_POST[$percentuais];
	    if($_POST[$clientes]==''){
	      $cliente = ''; 
	      $cont = '';
	    }
      if($i2=='1' && $percentual_1=='' && $_POST[$clientes]<>''){
        $percentual = '-100-';
      }elseif($_POST[$clientes]==''){
	    $percentual = '';
	  }
	  $total_perc = $total_perc + $soma_percentual;
  	}
	 $totalperc = $total_perc;


	if ($opcao=='2') {
	  $dist_mara = $dist_mar1;
	  $dist_tipoa = '';
	} elseif($opcao=='1') {
	  $dist_mara = $dist_mar;
	  $dist_tipoa = $dist_tipo;
	} elseif($cidade_litoranea<>'1') {
	  $dist_mara = '';
	  $dist_tipoa = '';
	}

   if ($_POST['comissao_parceria']=='diferenciado') {
	  $comissao_parceria = $comissao_diferenciado;
	} else {
	  $comissao_parceria = $comissao_parceria;
	}

		$msgErro = '';

      $SQL = "SELECT ref FROM muraski WHERE ref='".$ref."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	   $busca = mysql_query($SQL);
      $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Essa referência já está cadastrada favor escolha outra.\\n";
		}

		$SQL2 = "SELECT controle_chave FROM muraski WHERE controle_chave='".$controle_chave."' AND ref!='x' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca2 = mysql_query($SQL2);
        $num_rows2 = mysql_num_rows($busca2);
    	if($num_rows2 > 0)
		{
			$msgErro .= "Esse controle de chave já está sendo utilizado favor escolha outro.\\n";
		}
		
		if($total_perc < 100){
		  	  $msgErro .= "A soma total dos percentuais dos proprietários não pode ser inferior a 100.\\n";
		}

		if($total_perc > 100){

			$msgErro .= "A soma total dos percentuais dos proprietários é maior que 100.\\n";
		}

		if($msgErro != "")
		{
	 		echo('<script language="javascript">alert("'.$msgErro .'");</script>');
		}
		else
		{

	if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){


	$query = "insert into muraski (cod_imobiliaria, ref, tipo, tipo_secundario, metragem, area_terreno, matricula_luz, situacao_luz, matricula_agua, situacao_agua,
	n_quartos, valor, especificacao, suites, caracteristica, piscina, titulo,
	descricao, uf, local, permuta, finalidade, permuta_txt,
	ftxt_1, ftxt_2, ftxt_3, ftxt_4, ftxt_5, ftxt_6, ftxt_7, ftxt_8,
	ftxt_9, ftxt_10, ftxt_11, ftxt_12, ftxt_13, ftxt_14, ftxt_15
	, ftxt_16, ftxt_17, ftxt_18, ftxt_19, ftxt_20, cliente, percentual_prop, matricula, cidade_mat, cartorio_oficio, lote, quadra, planta
	, bairro, tipo_logradouro, end, numero, cep, averbacao, acomod, dist_mar, dist_tipo, limpeza, diaria1, diaria2
	, data_inicio, data_fim, comissao, dias, contrato, carnaval, anonovo, coordenadas, posx, posy, tv
	, angariador, zelador, tipo_anga, indicador, comissao_indicador, comissao_vendedor, diarista, comissao_diarista, piscineiro, comissao_piscineiro, eletricista, comissao_eletricista, encanador
	, comissao_encanador, jardineiro, comissao_jardineiro, chaves, controle_chave, tipo_div, valor_oferta, relacao_bens, observacoes, disponibilizar, disp_rede, destaque, destaque_padrao, lancamento, comissao_parceria, contador
	, construtora, idade_imovel, condominio, apto, end_igual, end_aproximado, tipo_logradouro_mapa, end_mapa, numero_mapa, cep_mapa, video, origem_video, endereco_contrato, exibir_endereco, observacoes2, observacoes3, ncoordenadas, calendario )
	values('".$_SESSION['cod_imobiliaria']."', '$ref', '$tipo1', '".$tipo_secundario1."', '$metragem', '".$area_terreno."', '".$matricula_luz."'
	, '".$situacao_luz."', '".$matricula_agua."', '".$situacao_agua."', '$n_quartos'
	, '$valor', '$especificacao', '$suites', '".$caracteristica1."', '$piscina'
	, '$titulo', '$desc', '$uf', '$local', '$permuta', '$finalidade', '$permuta_txt'
	, '$ftxt_1', '$ftxt_2', '$ftxt_3', '$ftxt_4', '$ftxt_5', '$ftxt_6'
	, '$ftxt_7', '$ftxt_8', '$ftxt_9', '$ftxt_10', '$ftxt_11', '$ftxt_12'
	, '$ftxt_13', '$ftxt_14', '$ftxt_15', '$ftxt_16', '$ftxt_17'
	, '$ftxt_18', '$ftxt_19', '$ftxt_20', '".$cliente."', '".$percentual."', '$matricula', '$cidade_mat', '$cartorio_oficio', '$lote', '$quadra', '$planta'
	, '".$bairro1."', '$tipo_logradouro', '$ende', '$numero_end', '$cep', '$averbacao', '$acomod', '$dist_mara', '$dist_tipoa', '$limpeza', '$diaria1'
	, '$diaria2', '$data_inicio', '$data_fim', '$comissao', '$dias', '$contrato', '$carnaval', '$anonovo'
	, '$coordenadas', '$posx', '$posy', '$tv', '$angariador', '$zelador', '$tipo_anga', '$co_cliente2', '$comissao_indicador', '$comissao_vendedor', '$co_diarista', '$comissao_diarista'
	, '$co_piscineiro', '$comissao_piscineiro', '$co_eletricista', '$comissao_eletricista', '$co_encanador'
	, '$comissao_encanador', '$co_jardineiro', '$comissao_jardineiro', '$chaves', '$controle_chave', '$tipo_div'
	, '$valor_oferta', '$relacao_bens', '".$observacoes."', '".$disponibilizar."', '".$disp_rede."', '".$destaque."', '" . $destaque_padrao . "', '".$lancamento."' , '".$comissao_parceria."', '$cont', '$construtora', '$idade_imovel', '$condominio'
	, '$apto', '$end_igual', '$end_aproximado', '$tipo_logradouro_mapa', '$ende_mapa', '$numero_end_mapa', '$cep_mapa', '$video', '$origem_video', '$endereco_contrato','$exibir_endereco', '$observacoes2', '$observacoes3', '$ncoordenadas', '$calendario')";
	$result = mysql_query($query) or die("Não foi possível inserir suas informações. $query");
	$registro = mysql_insert_id();

   		$data = date("Y-m-d");
   		$hora = date("H:i:s");
   		$B1 = "Inserir Imóvel";

		//Insere o usuário que esta fazendo a inserção do imovel
   		$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$registro."','".$ref."','".$B1."','".$data."','".$hora."')") or die ("Erro 370 - ".mysql_error());

		//Deleta o registro mais antigo da tabela, só deixa as 10 ultimas atualizações
   		$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$registro."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 90 - ".mysql_error());
   		$cont = mysql_num_rows($busca_reg);
   		if($cont > 10) {
      		mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 93 - ".mysql_error());
   		}

	} else {

	$query = "insert into muraski (cod_imobiliaria, ref, tipo, tipo_secundario, metragem, area_terreno, matricula_luz, situacao_luz, matricula_agua, situacao_agua,
	n_quartos, valor, especificacao, suites, caracteristica, piscina, titulo,
	descricao, uf, local, permuta, finalidade, permuta_txt,
	ftxt_1, ftxt_2, ftxt_3, ftxt_4, ftxt_5, ftxt_6, ftxt_7, ftxt_8,
	ftxt_9, ftxt_10, ftxt_11, ftxt_12, ftxt_13, ftxt_14, ftxt_15
	, ftxt_16, ftxt_17, ftxt_18, ftxt_19, ftxt_20, cliente, percentual_prop, matricula, cidade_mat, cartorio_oficio, lote, quadra, planta
	, bairro, tipo_logradouro, end, numero, cep, averbacao, dist_mar, dist_tipo
	, data_inicio, data_fim, comissao, dias, contrato, coordenadas, posx, posy
	, angariador, zelador, tipo_anga, indicador, comissao_indicador, comissao_vendedor, chaves, controle_chave, tipo_div
   , valor_oferta, relacao_bens, observacoes, disponibilizar, disp_rede, destaque, destaque_padrao, lancamento, comissao_parceria, contador
   , construtora, idade_imovel, condominio, apto, end_igual, end_aproximado, tipo_logradouro_mapa, end_mapa, numero_mapa, cep_mapa, video, origem_video, endereco_contrato, exibir_endereco, observacoes2, observacoes3, ncoordenadas, calendario)
	values('".$_SESSION['cod_imobiliaria']."', '$ref', '$tipo1',  '".$tipo_secundario1."', '$metragem', '".$area_terreno."', '".$matricula_luz."'
	, '".$situacao_luz."', '".$matricula_agua."', '".$situacao_agua."', '$n_quartos'
	, '$valor', '$especificacao', '$suites', '".$caracteristica1."', '$piscina'
	, '$titulo', '$desc', '$uf', '$local', '$permuta', '$finalidade', '$permuta_txt'
	, '$ftxt_1', '$ftxt_2', '$ftxt_3', '$ftxt_4', '$ftxt_5', '$ftxt_6'
	, '$ftxt_7', '$ftxt_8', '$ftxt_9', '$ftxt_10', '$ftxt_11', '$ftxt_12'
	, '$ftxt_13', '$ftxt_14', '$ftxt_15', '$ftxt_16', '$ftxt_17'
	, '$ftxt_18', '$ftxt_19', '$ftxt_20', '".$cliente."', '".$percentual."', '$matricula', '$cidade_mat', '$cartorio_oficio', '$lote', '$quadra', '$planta'
	, '".$bairro1."', '$tipo_logradouro', '$ende', '$numero_end', '$cep', '$averbacao', '$dist_mara', '$dist_tipoa'
	, '$data_inicio', '$data_fim', '$comissao', '$dias', '$contrato'
	, '$coordenadas', '$posx', '$posy', '$angariador', '$zelador', '$tipo_anga', '$co_cliente2', '$comissao_indicador'
   , '$comissao_vendedor', '$chaves', '$controle_chave', '$tipo_div'
	, '$valor_oferta', '$relacao_bens', '".$observacoes."', '".$disponibilizar."', '".$disp_rede."', '" . $destaque . "', '" . $destaque_padrao . "', '".$lancamento."'
   , '".$comissao_parceria."', '$cont', '$construtora','$idade_imovel', '$condominio', '$apto', '$end_igual', '$end_aproximado', '$tipo_logradouro_mapa'
   , '$ende_mapa', '$numero_end_mapa', '$cep_mapa', '$video', '$origem_video', '$endereco_contrato','$exibir_endereco', '$observacoes2', '$observacoes3', '$ncoordenadas', '$calendario')";
	$result = mysql_query($query) or die("Não foi possível inserir suas informações. $query");
	$registro = mysql_insert_id();

   		$data = date("Y-m-d");
   		$hora = date("H:i:s");
   		$B1 = "Inserir Imóvel";

		//Insere o usuário que esta fazendo a inserção do imovel
   		$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref,  a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$registro."','".$ref."','".$B1."','".$data."','".$hora."')") or die ("Erro 370 - ".mysql_error());

		//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
   		$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$registro."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 90 - ".mysql_error());
   		$cont = mysql_num_rows($busca_reg);
   		if($cont > 10) {
      		mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 93 - ".mysql_error());
   		}
	}


	echo('<script language="javascript">alert("Você inseriu o imóvel Ref.: '.$ref.'!");document.location.href="p_insert_imoveis.php";</script>');


	/*
	foreach($_POST['predileto'] AS $key => $value){
		echo $value;
	}
	*/
?>
<!--tr bgcolor="#<?php print("$cor1"); ?>"><td colspan=2 class=style1>
<p align="center">
Você inseriu o imóvel <b>Ref.:</b> <?php print("$ref"); ?>.</p></td></tr-->
<?php
    }
	}
//mysql_free_result($result);
?>
 <div align="center">
  <center>
<?php
	if(!IsSet($inserir1))
	{
?>
<script language="javascript">
function TravaCampo(){

  if(document.getElementById('end_igual').checked){

	document.form1.tipo_logradouro_mapa.disabled = true;
    document.form1.ende_mapa.disabled = true;
    document.form1.numero_end_mapa.disabled = true;
    document.form1.cep_mapa.disabled = true;
    document.form1.tipo_logradouro_mapa.style.background = '#D6D6D6';
    document.form1.ende_mapa.style.background = '#D6D6D6';
    document.form1.numero_end_mapa.style.background = '#D6D6D6';
    document.form1.cep_mapa.style.background = '#D6D6D6';
  }
  else 
  {
    document.form1.tipo_logradouro_mapa.disabled = false;
    document.form1.ende_mapa.disabled = false;
    document.form1.numero_end_mapa.disabled = false;
    document.form1.cep_mapa.disabled = false;
    document.form1.tipo_logradouro_mapa.style.background = '#FFFFFF';
    document.form1.ende_mapa.style.background = '#FFFFFF';
    document.form1.numero_end_mapa.style.background = '#FFFFFF';
    document.form1.cep_mapa.style.background = '#FFFFFF';
  }
}

function LimpaCampo(){

  if(document.getElementById('opcao1').checked){

	document.form1.dist_mar.disabled = false;
    document.form1.dist_tipo.disabled = false;
    document.form1.dist_mar.style.background = '#FFFFFF';
    document.form1.dist_tipo.style.background = '#FFFFFF';
	document.form1.dist_mar1.disabled = true;
    document.form1.dist_mar1.style.background = '#D6D6D6';
  }
  else if(document.getElementById('opcao2').checked){

    document.form1.dist_mar.value='';
    document.form1.dist_tipo.selectedIndex='metros';
    document.form1.dist_mar.disabled = true;
    document.form1.dist_tipo.disabled = true;
    document.form1.dist_mar.style.background = '#D6D6D6';
    document.form1.dist_tipo.style.background = '#D6D6D6';
    document.form1.dist_mar1.disabled = false;
    document.form1.dist_mar1.style.background = '#FFFFFF';
  }
}

<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode;
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}
//  End -->
</script>
  <form method="post" name="form1" id="form1" action="<?php print("$PHP_SELF"); ?>">
    <tr class="fundoTabela">
      <td class=style1><b>Finalidade:</b></td>
      <td class="style1"><select name="finalidade" id="finalidade" class="campo" onChange="form1.submit();">
          <option value="">Selecione uma op&ccedil;&atilde;o</option>
          <?php
        $bfinalidade = mysql_query("SELECT f_cod, f_nome FROM finalidade WHERE f_cod!='1' AND f_cod!='8' AND f_cod!='6' AND f_cod!='7' AND f_cod!='14' AND f_cod!='17' ORDER BY f_cod ASC");
 		while($linha = mysql_fetch_array($bfinalidade)){
			if($linha['f_cod']==$_POST['finalidade']){
			   if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			     echo('<option value="'.$linha['f_cod'].'" SELECTED>'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>');
			   }else{
			     echo('<option value="'.$linha['f_cod'].'" SELECTED>'.$linha['f_nome'].'</option>');
			   }
			}else{
			  if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			    echo('<option value="'.$linha['f_cod'].'">'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>');
			  }else{
			    echo('<option value="'.$linha['f_cod'].'">'.$linha['f_nome'].'</option>');
			  } 
			}
 		}
 	?>
      </select></td>
    </tr>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>Tipo de imóvel:</b></td>
      <td width="70%" class=style1> <select name="tipo1" id="tipo1" class="campo" onChange="form1.submit();">
          <option value="">Selecione</option>
      <?
    		$btipo = mysql_query("SELECT t_cod, t_nome FROM rebri_tipo ORDER BY t_nome ASC");
 			while($linha = mysql_fetch_array($btipo)){
				if($linha['t_cod']==$tipo1){
 		     		echo('<option value="'.$linha['t_cod'].'" SELECTED>'.$linha['t_nome'].'</option>');
		   		}else{
		     		echo('<option value="'.$linha['t_cod'].'">'.$linha['t_nome'].'</option>');
		   		}
			}
		?>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td colspan="2" class=style1>
	  	 <fieldset><legend><b>Tipo Secundário:</b></legend>

		<?
		
		 if($_POST['tipo_secundario']){
		  $tipo_secundario = implode('-', $_POST['tipo_secundario']);
		 }
		 		
		function verifica_check3($campo_select3, $select3){
			
			$funcoes3 = explode("-", $select3);
			$funcoes_cnt3   = count($funcoes3);
 
			for ($i3 = 0; $i3 < $funcoes_cnt3; $i3++) 
 			{
				if($campo_select3 == $funcoes3[$i3]){
					echo "checked";
   				}
 			}
  		}

			$busca_tipos = mysql_query("SELECT * FROM rebri_tipo WHERE t_cod!='".$_POST['tipo1']."' ORDER BY t_nome");
			while($linha = mysql_fetch_array($busca_tipos)){
		?>
			<div class="DivBairros"><input type="checkbox" name="tipo_secundario[]" value="<?php echo($linha['t_cod']); ?>" <?php verifica_check3("".$linha['t_cod']."", $tipo_secundario) ?>> <?= ucwords(strtolower($linha['t_nome'])); ?></div>
		<?
			}	
		?>
	  </fieldset></td>
      </tr>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>Referência:</b></td>
      <td width="70%" class=style1> <input type="text" name="ref" id="ref" size="10" maxlength="10" class="campo" value="<?=$ref; ?>" onKeyUp="return autoTab(this, 10, event);"> <a href="javascript:;" onClick="NewWindow('p_ref.php?menu=N', 'janela', 750, 500, 'yes')" class="style1"><b>Ver referências: usadas e disponíveis</b></a></td>
    </tr>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>Proprietário: N° de campos: <select name="cont" id="cont" class="campo" onChange="form1.action='p_insert_imoveis.php';form1.submit();">
		  <option value="">Selecione</option>
          <option value="1" <? if($cont=='1'){ print "SELECTED"; } ?>>+1</option>
          <option value="2" <? if($cont=='2'){ print "SELECTED"; } ?>>+2</option>
          <option value="3" <? if($cont=='3'){ print "SELECTED"; } ?>>+3</option>
          <option value="4" <? if($cont=='4'){ print "SELECTED"; } ?>>+4</option>
          <option value="5" <? if($cont=='5'){ print "SELECTED"; } ?>>+5</option>
          <option value="6" <? if($cont=='6'){ print "SELECTED"; } ?>>+6</option>
          <option value="7" <? if($cont=='7'){ print "SELECTED"; } ?>>+7</option>
          <option value="8" <? if($cont=='8'){ print "SELECTED"; } ?>>+8</option>
          <option value="9" <? if($cont=='9'){ print "SELECTED"; } ?>>+9</option>
          <option value="10" <? if($cont=='10'){ print "SELECTED"; } ?>>+10</option>
          </select></td>
      <td width="70%" class=style1>
<?
           if($_POST['cont']){
		     for($i = 1; $i <= $_POST['cont']; $i++){

				$cod_clientes = "cliente_".$i;
	    		$cliente = $_POST[$cod_clientes];
	    		$clientes = "nome_cliente_".$i;
	    		$nome_cliente = $_POST[$clientes];
				$percentuais = "percentual_".$i;
	    		$percentual = $_POST[$percentuais];

			   echo("
			   		<input type=\"text\" name=\"cliente_$i\" id=\"cliente_$i\" size=\"5\" class=\"campo2\" value=\"".$cliente."\" readonly>
           			<input type=\"text\" name=\"nome_cliente_$i\" id=\"nome_cliente_$i\" size=\"40\" class=\"campo\" value=\"".$nome_cliente."\" readonly>
           			<input type=\"button\" id=\"selecionar2\" name=\"selecionar2\" value=\"Selecionar\" class=\"campo3\" onClick=\"NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=3&c_campo=cliente_$i&n_campo=nome_cliente_$i', 'janela', 750, 500, 'yes');\">
           			<b>Percentual:</b>
					<input type=\"text\" name=\"percentual_$i\" id=\"percentual_$i\" size=\"2\" class=\"campo\" value=\"".$percentual."\">%<br>
			   ");
			 }
		   }
?>		   </td>
    </tr>
      <tr class="fundoTabela">
         <td class=style1><strong>Construtora:</strong></td>
         <td class=style1><input type="text" name="construtora" id="construtora" size="40" class="campo" value="<?=$construtora?>"></td>
      </tr>
      <tr class="fundoTabela">
         <td class=style1><strong>Imóvel contruído em:</strong></td>
         <td class=style1><input type="text" name="idade_imovel" id="idade_imovel" size="4" maxlength="4" class="campo" value="<?=$idade_imovel?>"> Ex: 2009</td>
      </tr>
      <tr class="fundoTabela">
         <td class=style1><strong>Condomínio:</strong></td>
         <td class=style1><input type="text" name="condominio" id="condominio" size="40" class="campo" value="<?=$condominio?>"></td>
      </tr>
    <!--tr class="fundoTabela">
      <td class=style1><b>Comiss&atilde;o Proprietário:</b></td>
      <td class=style1><input type="text" name="comissao_prop" id="comissao_prop" size="2" class="campo" value="<? //if($_POST['comissao_prop']){ echo($_POST['comissao_prop']); }else{ echo($comissao_prop); } ?>">
        Exemplo:
        6 ou 15</td>
    </tr-->
    <tr class="fundoTabela">
      <td class=style1><b>Dias &uacute;teis:</b></td>
      <td width="70%" class=style1>
          <!--input type="text" name="dias" value="<?php //func_data($data_entrada, $data_saida);  ?>" size="3" class="campo" readonly-->
          <? // } ?>
          <input type="text" name="dias" id="dias" value="<?php if($_POST['dias']){ print($_POST['dias']); }else{ print($not2['dias']); } ?>" size="3" class="campo">
          <font size="1">Obs.: Apenas para im&oacute;veis &agrave; venda</td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Contrato de:</b></td>
      <td width="70%" class=style1><input type="hidden" id="acao" name="acao" value="0">
      <input type="text" name="dia" id="dia" size="2" class="campo" maxlenght="2" value="<?php if($_POST['dia']){ print($_POST['dia']); } ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes" id="mes" size="2" class="campo" maxlenght="2" value="<?php if($_POST['mes']){ print($_POST['mes']); } ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano" id="ano" size="4" class="campo" maxlenght="4" value="<?php if($_POST['ano']){ print($_POST['ano']); } ?>" onKeyUp="return autoTab(this, 4, event);">
	   <input type="button" value="Calcular data final" name="calcular" id="calcular" class="campo3" onClick="form1.action='p_insert_imoveis.php';form1.acao.value='1';form1.submit();">
<?php
if($_POST['acao']==1){
/*
include("calculo.php");

$datai = $_POST['dia']."/".$_POST['mes']."/".$_POST['ano'];
$dataf = $_POST['dia1']."/".$_POST['mes1']."/".$_POST['ano1'];

$dlist=explode('/',$datai); // Pegamos a data que veio do formul&aacute;rio e a explodimos, transformando num array
$tlist=explode(':',date('H:i:s',time())); // Pegamos a hora atual com date('H:i:s',time())) e a explodimos, transformando num array
$datahora=mktime($tlist[0],$tlist[1],$tlist[2],$dlist[1],$dlist[0],$dlist[2]); // Transformamos em formato Unix utilizando os dados de ambos os arrays
$data_entrada = $datahora;

$dlist2=explode('/',$dataf); // Pegamos a data que veio do formul&aacute;rio e a explodimos, transformando num array
$tlist2=explode(':',date('H:i:s',time())); // Pegamos a hora atual com date('H:i:s',time())) e a explodimos, transformando num array
$datahora2=mktime($tlist2[0],$tlist2[1],$tlist2[2],$dlist2[1],$dlist2[0],$dlist2[2]); // Transformamos em formato Unix utilizando os dados de ambos os arrays
$data_saida = $datahora2;
*/

include("calculo2.php");

$datai = $_POST['dia']."/".$_POST['mes']."/".$_POST['ano'];
$diasu = $_POST['dias'];

$data_final = somar_dias_uteis($datai, $diasu);
list($dia1, $mes1, $ano1) = explode('/', $data_final);

} 
?>	  
      <b> à</b> <input type="text" name="dia1" id="dia1" size="2" class="campo" maxlenght="2" value="<?php print($dia1); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes1" id="mes1" size="2" class="campo" maxlenght="2" value="<?php print($mes1); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano1" id="ano1" size="4" class="campo" maxlenght="4" value="<?php print($ano1); ?>" onKeyUp="return autoTab(this, 4, event);">
	  <font size="1">Ex.: 
    10/10/1910</td>
    </tr>
    
    <!--tr class="fundoTabela">
      <td class=style1><b>Contrato:</b></td>
      <td class=style1><select name="contrato" id="contrato" class="campo">
        <option value="">Selecione um contrato</option>
        <?php
        /*
        	$documentos = mysql_query("select d_cod, d_nome FROM doc WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linha = mysql_fetch_array($documentos)){
 		  	$d_nome = substr ($linha[d_nome], 0, 30);
				if($linha[d_cod]==$_POST['contrato']){
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'" SELECTED>'.$d_nome.'...</option>');
				}else{ 			   
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'">'.$d_nome.'...</option>');
				}
 			}
 		*/
 	?>
      </select></td>
    </tr-->
    <tr class="fundoTabela">
      <td class=style1><b><? if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ echo("Di&aacute;ria"); }else{ echo("Valor"); }?>:</b></td>
      <td class=style1><input type="text" name="valor" id="valor" size="10" class="campo" value="<?=$valor; ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Valor Oferta:</b></td>
      <td class=style1><input type="text" name="valor_oferta" id="valor_oferta" size="10" class="campo" value="<?=$valor_oferta; ?>" onKeydown="Formata(this,20,event,2)">
	  <br>
        <b>Obs.: Ao preencher este valor o im&oacute;vel aparecer&aacute; em destaque</b></td>
    </tr>
<? if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ ?>	
    <tr class="fundoTabela">
    <td class=style1><b>Valor Carnaval:</b></td>
      <td class=style1><input type="text" name="carnaval" size="10" class="campo" value="<?php print($carnaval); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Valor Ano Novo:</b></td>
      <td class=style1><input type="text" name="anonovo" size="10" class="campo" value="<?php print($anonovo); ?>" onKeydown="Formata(this,20,event,2)"> </td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Di&aacute;ria m&iacute;nima/Di&aacute;ria m&aacute;xima:</b></td>
      <td class=style1><input type="text" name="diaria1" id="diaria1" size="10" class="campo" value="<?=$diaria1; ?>" onKeydown="Formata(this,20,event,2)">
        /
          <input type="text" name="diaria2" id="diaria2" size="10" class="campo" value="<?=$diaria2; ?>" onKeydown="Formata(this,20,event,2)">
        </td>
    </tr>
<? } ?>
    <tr class="fundoTabela">
      <td class=style1><b>Comiss&atilde;o Imobili&aacute;ria:</b></td>
      <td class=style1><input type="text" name="comissao" id="comissao" size="2" class="campo" value="<?=$comissao; ?>"> %
        Exemplo:
        6 ou 15</td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Endere&ccedil;o:</b></td>
      <td class="style1">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td class="style1" height="25px">
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
      				</select>
        			<input type="text" name="ende" id="ende" size="50" class="campo" value="<?=$ende; ?>"> <b>N&uacute;mero:</b> <input type="text" name="numero_end" id="numero_end" size="2" class="campo" value="<?php print($numero_end); ?>">
				</td>
			</tr>
			<tr>
				<td class="style1" height="25px">
					<b>Complemento:</b> <input type="text" name="apto" id="apto" size="30" class="campo" value="<?=$apto?>">
				</td>
			</tr>
			<tr>
				<td class="style1" height="25px">
					<b>CEP:</b> <input name="cep" type="text" class="campo" id="cep" value="<?php print($cep); ?>" size="8" maxlength="8">&nbsp;&nbsp;Exemplo: 80000000
				</td>
			</tr>
<? /** ?>
			<tr>
				<td style="text-align: justify; padding-right: 5px">
					<span class="style7">Para que o mapa funcione corretamente sem precisar preencher as coordenadas do Google Maps no campo "Coordenadas" &eacute; preciso o tipo de logradouro + endere&ccedil;o completo, o campo n&uacute;mero e CEP preenchidos. (Exemplo: Avenida 29 de Abril 601 CEP: 80000000)</span>
				</td>
			</tr>
<? /**/ ?>
		</table>
	</td>
  </tr>
  <tr class="fundoTabela">
      <td class=style1><b>Mapa do Google:</b></td>
      <td class=style1><input type="text" name="ncoordenadas" id="ncoordenadas" size="50" class="campo" value="<?=$ncoordenadas?>" >
         <input type="button" value="Localizar Endereço" name="B1" class="campo3" Onclick="google();"> </td>
  </tr>
  <input name="end_igual" type="hidden" id="end_igual" value="<?=$end_igual?>" />
<? if($_SESSION['cod_imobiliaria']<>'3'){ ?>	
    <input type="hidden" name="coordenadas" id="coordenadas" value="<?=$coordenadas?>" >
<? }else{ ?>	
    <tr class="fundoTabela">
      <td class=style1><b>Coordenadas:</b><br>
        * Entre no site <a href="http://maps.google.com.br" target="_blank">Google Maps</a> e digite o endere&ccedil;o completo, cidade, estado (Ex: rua teste, 10, curitiba, pr) e depois clicar em &quot;Link&quot; e copiar e colar o codigo HTML nesse campo. Veja <a href="images/exemplo.jpg" target="_blank">aqui</a> o exemplo.<br><br>
		* Mapa da InfoCenter somente colocar as coordenadas do imóvel separados por / (barra). Ex: 4146/1872</td>
	  <td class=style1><textarea rows="3" name="coordenadas" id="coordenadas" cols="40" class="campo"><?=$coordenadas; ?></textarea></td>
    </tr>
<? } ?>  
<?
/**
    <tr class="fundoTabela">
      <td class=style1><b>Endere&ccedil;os Id&ecirc;nticos?</b></td>
      <td class="style1"><input name="end_igual" type="checkbox" id="end_igual" value="1" <? if($end_igual=='1'){ print "CHECKED"; } ?> OnClick="TravaCampo();">
        Sim</td>
    </tr>
/**/
?>

    <tr class="fundoTabela">
      <td class=style1><b>Exibir endereço no site?</b></td>
      <td class="style1"><input name="exibir_endereco" type="checkbox" id="exibir_endereco" value="1" <? if($exibir_endereco=='1'){ print "CHECKED"; } ?>>
        Não Exibir<br><span class="style7">Obs: Se este campo estiver marcado o ícone no mapa do Google e o endereço do imóvel não aparecerá no site.</span></td>
    </tr>


  <input type="hidden" name="tipo_logradouro_mapa" id="tipo_logradouro_mapa" value="<?=$tipo_logradouro_mapa?>" />
  <input type="hidden" name="ende_mapa" id="ende_mapa" class="campo" value="<?=$ende_mapa; ?>" />
  <input type="hidden" name="numero_end_mapa" id="numero_end_mapa" class="campo" value="<?php print("$numero_end_mapa"); ?>" />
  <input type="hidden" name="cep_mapa" id="cep_mapa" value="<?php print("$cep_mapa"); ?>" />

<?
/**
?>
    <tr class="fundoTabela">
      <td class=style1><b>Endere&ccedil;o no Mapa:</b></td>
      <td class="style1"><select name="tipo_logradouro_mapa" id="tipo_logradouro_mapa" class="campo" <? if($end_igual=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
          <option value="">Selecione</option>
          <option value="Alameda" <? if($tipo_logradouro_mapa=='Alameda'){ echo "SELECTED"; } ?>>Alameda</option>
          <option value="Área" <? if($tipo_logradouro_mapa=='Área'){ echo "SELECTED"; } ?>>Área</option>
          <option value="Avenida" <? if($tipo_logradouro_mapa=='Avenida'){ echo "SELECTED"; } ?>>Avenida</option>
          <option value="Campo" <? if($tipo_logradouro_mapa=='Campo'){ echo "SELECTED"; } ?>>Campo</option>
          <option value="Chácara" <? if($tipo_logradouro_mapa=='Chácara'){ echo "SELECTED"; } ?>>Chácara</option>
          <option value="Colônia" <? if($tipo_logradouro_mapa=='Colônia'){ echo "SELECTED"; } ?>>Colônia</option>
          <option value="Condomínio" <? if($tipo_logradouro_mapa=='Condomínio'){ echo "SELECTED"; } ?>>Condomínio</option>
          <option value="Conjunto" <? if($tipo_logradouro_mapa=='Conjunto'){ echo "SELECTED"; } ?>>Conjunto</option>
          <option value="Distrito" <? if($tipo_logradouro_mapa=='Distrito'){ echo "SELECTED"; } ?>>Distrito</option>
          <option value="Esplanada" <? if($tipo_logradouro_mapa=='Esplanada'){ echo "SELECTED"; } ?>>Esplanada</option>
          <option value="Estação" <? if($tipo_logradouro_mapa=='Estação'){ echo "SELECTED"; } ?>>Estação</option>
          <option value="Estrada" <? if($tipo_logradouro_mapa=='Estrada'){ echo "SELECTED"; } ?>>Estrada</option>
          <option value="Favela" <? if($tipo_logradouro_mapa=='Favela'){ echo "SELECTED"; } ?>>Favela</option>
          <option value="Fazenda" <? if($tipo_logradouro_mapa=='Fazenda'){ echo "SELECTED"; } ?>>Fazenda</option>
          <option value="Feira" <? if($tipo_logradouro_mapa=='Feira'){ echo "SELECTED"; } ?>>Feira</option>
          <option value="Jardim" <? if($tipo_logradouro_mapa=='Jardim'){ echo "SELECTED"; } ?>>Jardim</option>
          <option value="Ladeira" <? if($tipo_logradouro_mapa=='Ladeira'){ echo "SELECTED"; } ?>>Ladeira</option>
          <option value="Lago" <? if($tipo_logradouro_mapa=='Lago'){ echo "SELECTED"; } ?>>Lago</option>
          <option value="Lagoa" <? if($tipo_logradouro_mapa=='Lagoa'){ echo "SELECTED"; } ?>>Lagoa</option>
          <option value="Largo" <? if($tipo_logradouro_mapa=='Largo'){ echo "SELECTED"; } ?>>Largo</option>
          <option value="Loteamento" <? if($tipo_logradouro_mapa=='Loteamento'){ echo "SELECTED"; } ?>>Loteamento</option>
          <option value="Morro" <? if($tipo_logradouro=='Morro'){ echo "SELECTED"; } ?>>Morro</option>
          <option value="Núcleo" <? if($tipo_logradouro_mapa=='Núcleo'){ echo "SELECTED"; } ?>>Núcleo</option>
          <option value="Parque" <? if($tipo_logradouro_mapa=='Parque'){ echo "SELECTED"; } ?>>Parque</option>
          <option value="Passarela" <? if($tipo_logradouro_mapa=='Passarela'){ echo "SELECTED"; } ?>>Passarela</option>
          <option value="Pátio" <? if($tipo_logradouro_mapa=='Pátio'){ echo "SELECTED"; } ?>>Pátio</option>
          <option value="Praça" <? if($tipo_logradouro_mapa=='Praça'){ echo "SELECTED"; } ?>>Praça</option>
          <option value="Quadra" <? if($tipo_logradouro_mapa=='Quadra'){ echo "SELECTED"; } ?>>Quadra</option>
          <option value="Recanto" <? if($tipo_logradouro_mapa=='Recanto'){ echo "SELECTED"; } ?>>Recanto</option>
          <option value="Residencial" <? if($tipo_logradouro_mapa=='Residencial'){ echo "SELECTED"; } ?>>Residencial</option>
          <option value="Rodovia" <? if($tipo_logradouro_mapa=='Rodovia'){ echo "SELECTED"; } ?>>Rodovia</option>
          <option value="Rua" <? if($tipo_logradouro_mapa=='Rua'){ echo "SELECTED"; } ?>>Rua</option>
          <option value="Setor" <? if($tipo_logradouro_mapa=='Setor'){ echo "SELECTED"; } ?>>Setor</option>
          <option value="Sítio" <? if($tipo_logradouro_mapa=='Sítio'){ echo "SELECTED"; } ?>>Sítio</option>
          <option value="Travessa" <? if($tipo_logradouro_mapa=='Travessa'){ echo "SELECTED"; } ?>>Travessa</option>
          <option value="Trecho" <? if($tipo_logradouro_mapa=='Trecho'){ echo "SELECTED"; } ?>>Trecho</option>
          <option value="Trevo" <? if($tipo_logradouro_mapa=='Trevo'){ echo "SELECTED"; } ?>>Trevo</option>
          <option value="Vale" <? if($tipo_logradouro_mapa=='Vale'){ echo "SELECTED"; } ?>>Vale</option>
          <option value="Vereda" <? if($tipo_logradouro_mapa=='Vereda'){ echo "SELECTED"; } ?>>Vereda</option>
          <option value="Via" <? if($tipo_logradouro_mapa=='Via'){ echo "SELECTED"; } ?>>Via</option>
          <option value="Viaduto" <? if($tipo_logradouro_mapa=='Viaduto'){ echo "SELECTED"; } ?>>Viaduto</option>
          <option value="Viela" <? if($tipo_logradouro_mapa=='Viela'){ echo "SELECTED"; } ?>>Viela</option>
          <option value="Vila" <? if($tipo_logradouro_mapa=='Vila'){ echo "SELECTED"; } ?>>Vila</option>
        </select>
          <input type="text" name="ende_mapa" id="ende_mapa" size="50" class="campo" value="<?=$ende_mapa; ?>" <? if($end_igual=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
          <b>N&uacute;mero:</b>
          <input type="text" name="numero_end_mapa" id="numero_end_mapa" size="2" class="campo" value="<?php print("$numero_end_mapa"); ?>" <? if($end_igual=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
          <br>
          <b>CEP no Mapa:</b> <input type="text" name="cep_mapa" id="cep_mapa" size="8" maxlength="8" class="campo" value="<?php print("$cep_mapa"); ?>" <? if($end_igual=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
Exemplo: 80000000 <br><span class="style7">
          Caso o Google não exiba corretamente a localização no mapa preencha o endereço com a localização correta do mapa. (Exemplo: Avenida 29 de Abril 601 CEP: 80000000)</span></td>
    </tr>
<? /**/ ?>
   <!--tr class="fundoTabela">
      <td class=style1><b>N&uacute;mero:</b></td>
      <td class=style1><input type="text" name="numero_end" id="numero_end" size="2" class="campo" value="<?php print("$numero_end"); ?>"></td>
      </tr-->

      <input name="end_aproximado" type="hidden" id="end_aproximado" value="<?=$end_aproximado?>" />
<? /** ?>
    <tr class="fundoTabela">
      <td class=style1><b>Endere&ccedil;o Aproximado?</b></td>
      <td class="style1"><input name="end_aproximado" type="checkbox" id="end_aproximado" value="1" <? if($end_aproximado=='1'){ print "CHECKED"; } ?>>
        Sim<br><span class="style7">Obs: Se este campo estiver marcado o ícone no mapa do Google não aparecerá.</span></td>
    </tr>
<? /**/ ?>
    <tr class="fundoTabela">
      <td class="style1"><b>Estado:</b></td>
      <td><input type="hidden" name="acaoci" id="acaoci" value="0">
	  <select name="im_estado" id="im_estado" class="campo" onChange="form1.action='p_insert_imoveis.php';form1.acaoci.value='1';form1.submit();">
          <option value="">Selecione o Estado</option>
          <?
        if($_SESSION['cod_estadoi'] && empty($_POST['im_estado'])){
			$bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha['e_cod']==$_SESSION['cod_estadoi']){
			   		echo('<option value="'.$linha['e_cod'].'" SELECTED>'.$linha['e_uf'].'</option>');
				}else{
					echo('<option value="'.$linha['e_cod'].'">'.$linha['e_uf'].'</option>');
				}
 			}
 		}else{
	        $bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha['e_cod']==$_POST['im_estado']){
			   		echo('<option value="'.$linha['e_cod'].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{
					echo('<option value="'.$linha['e_cod'].'">'.$linha['e_uf'].'</option>');
				}
 			}
		}
        ?>
      </select></td>
    </tr>
	      <?
        $contratos = mysql_query("SELECT contrato_venda, contrato_locacao FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
 		while($linha = mysql_fetch_array($contratos)){
            if($_POST['finalidade']=='2' || $_POST['finalidade']=='3' || $_POST['finalidade']=='4' || $_POST['finalidade']=='5' || $_POST['finalidade']=='6' || $_POST['finalidade']=='7'){
			    $contrato = $linha['contrato_venda'];
			}elseif($_POST['finalidade']=='9' || $_POST['finalidade']=='10' || $_POST['finalidade']=='11' || $_POST['finalidade']=='12' || $_POST['finalidade']=='13' || $_POST['finalidade']=='14' || $_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){
			    $contrato = $linha['contrato_locacao'];
			}
         }
         
	  ?>
      
      <input type="hidden" name="contrato" id="contrato" value="<?=$contrato ?>">   
	 <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Localização:</b></td>
      <td width="70%"><input type="hidden" name="acaob" id="acaob" value="0">
	  <select name="local" id="local" class="campo" onChange="form1.action='p_insert_imoveis.php';form1.acaob.value='1';form1.acaoci.value='1';form1.submit();">
		<option value="">Selecione a Cidade</option>
		<?
 		if($_POST['acaoci']=='1' || $_POST['im_estado']<>''){
	        $bcidades2 = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_POST['im_estado']."' ORDER BY ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidades2)){
				if($linha['ci_cod']==$_POST['local']){
			   		echo('<option value="'.$linha['ci_cod'].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha['ci_cod'].'">'.$linha['ci_nome'].'</option>');
				}
 			}
		}elseif($_SESSION['cod_cidadei'] && empty($_POST['local'])){ 
			$bcidades2 = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_SESSION['cod_estadoi']."' ORDER BY ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidades2)){
				if($linha['ci_cod']==$_SESSION['cod_cidadei']){
			   		echo('<option value="'.$linha['ci_cod'].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha['ci_cod'].'">'.$linha['ci_nome'].'</option>');
				}
 			}
		}
	   ?>
	     </select></td>
    </tr>
    <tr class="fundoTabela">
      <td colspan="2" class=style1>
	  	 <fieldset><legend><b>Bairros</b></legend>

		<?
		
		 if($_POST['bairro']){
		  $bairro = implode('-', $_POST['bairro']);
		 }
		 		
		function verifica_check($campo_select, $select){
			
			$funcoes = explode("-", $select);
			$funcoes_cnt   = count($funcoes);
 
			for ($i = 0; $i < $funcoes_cnt; $i++)
 			{
				if($campo_select == $funcoes[$i]){
					echo "checked";
   				}
 			}
  		}
        
        if($_POST['acaob']=='1' || $_POST['im_estado']<>''){
			$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_POST['local']."' ORDER BY b_nome");
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
			<div class="DivBairros"><input type="checkbox" name="bairro[]" value="<?php echo($linha['b_cod']); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>> <?= ucwords(strtolower($linha['b_nome'])); ?></div>
		<?
			}
		}elseif($_SESSION['cod_cidadei'] && empty($_POST['local']) && empty($_POST['im_estado']) && empty($_POST['cidade_mat'])){ 
		  	$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_SESSION['cod_cidadei']."' ORDER BY b_nome");
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
			<div class="DivBairros"><input type="checkbox" name="bairro[]" id="bairro" value="<?php echo($linha['b_cod']); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>> <?= ucwords(strtolower($linha['b_nome'])); ?></div>
		<?
			}
		}		
		?>
	  </fieldset></td>
      </tr>
   <tr class="fundoTabela">
      <td width="30%" class=style1><b>Título:</b> </td>
      <td width="70%" class=style1><textarea rows="2" name="titulo" id="titulo" cols="36" class="campo"><?=$titulo?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Descrição:</b></td>
      <td width="70%" class=style1><textarea rows="5" name="descricao" id="descricao" cols="36" class="campo"><?=$descricao; ?></textarea></td>
    </tr>
<? if($_POST['finalidade']=='1' || $_POST['finalidade']=='2' || $_POST['finalidade']=='3' || $_POST['finalidade']=='4' || $_POST['finalidade']=='5' || $_POST['finalidade']=='6' || $_POST['finalidade']=='7'){  ?>    
    <tr class="fundoTabela">
      <td class=style1><b>Permuta:</b></td>
      <td class=style1><select name="permuta" id="permuta" class="campo">
          <option value="Sim" <? if($permuta=='Sim'){ print "SELECTED"; } ?>>Sim</option>
          <option value="Não" <? if($permuta=='Não'){ print "SELECTED"; } ?>>N&atilde;o</option>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>*Texto da Permuta:</b><br>
        *Preencha esse campo apenas se voc&ecirc; escolheu a op&ccedil;&atilde;o "Sim" no campo Permuta.</td>
      <td class=style1><textarea rows="3" name="permuta_txt" id="permuta_txt" cols="36" class="campo"><?=$permuta_txt; ?></textarea></td>
    </tr>
<? } ?>
    <tr class="fundoTabela">
      <td class=style1><b>&Aacute;rea constru&iacute;da:</b></td>
      <td class=style1><input type="text" name="metragem" id="metragem" size="10" class="campo" value="<?=$metragem; ?>">
        Exemplo:
        100.00 ou 100</td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>&Aacute;rea averbada:</b></td>
      <td class=style1><input type="text" name="averbacao" id="averbacao" size="10" class="campo" value="<?=$averbacao; ?>">
        Exemplo:
        100.00 ou 100</td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>&Aacute;rea do terreno: </b></td>
      <td class=style1><input name="area_terreno" type="text" id="area_terreno" size="20" class="campo" value="<?=$area_terreno; ?>">
        Exemplo: 100.00 ou 100</td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>N&deg; de
        quartos:</b></td>
      <td class=style1><input type="text" name="n_quartos" id="n_quartos" size="5" class="campo" value="<?=$n_quartos; ?>">
        Exemplo:
        1</td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Sendo su&iacute;te:</b></td>
      <td class=style1><input type="text" name="suites" id="suites" size="5" class="campo" value="<?=$suites; ?>">
        Exemplo:
        1</td>
    </tr>
<? if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ ?>
    <tr class="fundoTabela">
      <td class=style1><b>Acomoda&ccedil;&otilde;es:</b></td>
      <td class=style1><input type="text" name="acomod" id="acomod" size="2" class="campo" value="<?=$acomod; ?>">
        Exemplo:
        1 ou 10</td>
    </tr>
<? } ?>	
	    <input type="hidden" name="combo" id="combo" value="0">
<?
    if(empty($local)){
	  $local = $_SESSION['cod_cidadei'];
	}
 
	$blitoranea = mysql_query("SELECT ci_litoranea FROM rebri_cidades WHERE ci_cod='".$local."' AND ci_litoranea='1'");
 	while($linha = mysql_fetch_array($blitoranea)){
	     $litoranea = $linha['ci_litoranea'];
	}   
	if($litoranea=='1'){

?>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Distância do mar:</b></td>
      <td width="70%" class="style1">
        <input name="opcao" id="opcao1" type="radio" value="1" <? if($opcao=='1'){ print "CHECKED"; } ?> OnClick="LimpaCampo();">
        Op&ccedil;&atilde;o 1 - 
         <input type="text" name="dist_mar" id="dist_mar" size="4" class="campo" value="<?=$dist_mar; ?>"> 
        <select name="dist_tipo" id="dist_tipo" class="campo">
          <option value="metros" <? if($dist_tipo=='metros'){ print "SELECTED"; } ?>>metros</option>
          <option value="quadras" <? if($dist_tipo=='quadras'){ print "SELECTED"; } ?>>quadras</option>
          </select>
        <b>ou</b> 
        <input name="opcao" id="opcao2" type="radio" value="2"  <? if($opcao=='2'){ print "CHECKED"; } ?> OnClick="LimpaCampo();">
        Op&ccedil;&atilde;o 2 - 
		<select name="dist_mar1" id="dist_mar1" class="campo">
          <option value="frente para a baía" <? if($dist_tipo=='frente para a baía'){ print "SELECTED"; } ?>>frente para a baía</option>
		  <option value="frente para o mar" <? if($dist_tipo=='frente para o mar'){ print "SELECTED"; } ?>>frente para o mar</option>
      </select></td></tr>
<? } ?>
    <input type="hidden" name="cidade_litoranea" id="cidade_litoranea" value="<?=$litoranea ?>">
    <tr class="fundoTabela">
      <td colspan="2" class=style1><fieldset>
        <legend><b>Caracter&iacute;sticas</b></legend>
        <?
		
		 if($_POST['caracteristica']){
		  $caracteristica = implode('-', $_POST['caracteristica']);
		 }

		function verifica_check2($campo_select2, $select2){
			
			$funcoes2 = explode("-", $select2);
			$funcoes_cnt2   = count($funcoes2);
 
			for ($i2 = 0; $i2 < $funcoes_cnt2; $i2++) 
 			{
				if($campo_select2 == $funcoes2[$i2]){
					echo "checked";
   				}
 			}
  		}

		$busca_caracteristicas = mysql_query("SELECT * FROM rebri_caracteristicas ORDER BY c_nome");
		while($linha = mysql_fetch_array($busca_caracteristicas)){
		?>
        <div class="DivCaracteristicas">
          <input type="checkbox" name="caracteristica[]" id="caracteristica" value="<?php echo($linha['c_cod']); ?>" <?php verifica_check2("".$linha['c_cod']."", $caracteristica) ?>>
          <?= $linha['c_nome']; ?>
        </div>
        <?
		}
		?>
      </fieldset></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Matr&iacute;cula do im&oacute;vel:</b></td>
      <td class="style1"><input type="text" name="matricula" id="matricula" size="30" class="campo" value="<?=$matricula; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Cidade Mat.:</b></td>
      <td width="70%"><select name="cidade_mat" id="cidade_mat" class="campo">
        <option value="">Selecione a Cidade</option>
       <?
 		if($_POST['acaoci']=='1' || $_POST['im_estado']<>''){
	        $bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_POST['im_estado']."' ORDER BY ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidades)){
				if($linha['ci_cod']==$_POST['cidade_mat']){
			   		echo('<option value="'.$linha['ci_cod'].'" SELECTED>'.$linha['ci_nome'].'</option>');
				}else{
					echo('<option value="'.$linha['ci_cod'].'">'.$linha['ci_nome'].'</option>');
				}
 			}
		}
		elseif($_SESSION['cod_cidadei'] && empty($_POST['cidade_mat'])){ 
			$bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_SESSION['cod_estadoi']."' ORDER BY ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidades)){
				if($linha['ci_cod']==$_SESSION['cod_cidadei']){
			   		echo('<option value="'.$linha['ci_cod'].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha['ci_cod'].'">'.$linha['ci_nome'].'</option>');
				}
 			}
		}
	   ?>
	     </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Cartório/Oficio:</b></td>
      <td class="style1"><input type="text" name="cartorio_oficio" id="cartorio_oficio" size="50" class="campo" value="<?=$cartorio_oficio; ?>"></td>
    </tr>
    
    <tr class="fundoTabela">
      <td class=style1><b>Lote:</b></td>
      <td class="style1"><input type="text" name="lote" id="lote" size="10" class="campo" value="<?=$lote; ?>"></td>
    </tr>
    
    <tr class="fundoTabela">
      <td class=style1><b>Quadra:</b></td>
      <td class="style1"><input type="text" name="quadra" id="quadra" size="10" class="campo" value="<?=$quadra; ?>"></td>
    </tr>
    
    <tr class="fundoTabela">
      <td class=style1><b>Planta:</b></td>
      <td class="style1"><input type="text" name="planta" id="planta" size="50" class="campo" value="<?=$planta; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Complemento de Contrato:</b></td>
      <td class=style1><textarea name="endereco_contrato" id="endereco_contrato" cols="36" rows="5" class="campo"><?=$endereco_contrato; ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Matr&iacute;cula da &aacute;gua: </b></td>
      <td class=style1><input name="matricula_agua" type="text" id="matricula_agua" size="20" class="campo" value="<?=$matricula_agua; ?>">
        <input name="situacao_agua" id="situacao_agua1" type="radio" value="0" <? if($situacao_agua=='0'){ print "CHECKED"; } ?> checked>
Ligada
<input name="situacao_agua" id="situacao_agua2" type="radio" value="1" <? if($situacao_agua=='1'){ print "CHECKED"; } ?>>
Desligada </td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Matr&iacute;cula da luz: </b></td>
      <td class=style1><input name="matricula_luz" type="text" id="matricula_luz" class="campo" value="<?=$matricula_luz; ?>"> <input name="situacao_luz" id="situacao_luz1" type="radio" value="0" <? if($situacao_luz=='0'){ print "CHECKED"; } ?> checked>
Ligada
  <input name="situacao_luz" id="situacao_luz2" type="radio" value="1" <? if($situacao_luz=='1'){ print "CHECKED"; } ?>>
Desligada </td>
    </tr>
<?
/*	
	$busca_controle = mysql_query("SELECT controle_chave FROM muraski WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY controle_chave DESC LIMIT 0,1");
   	if(mysql_num_rows($busca_controle) > 0){
		while($linha = mysql_fetch_array($busca_controle)){
	        $controle_chave = $linha['controle_chave'] + 1;
		}
    }else{
	    $controle_chave = 1;
	}	
*/

    $bcontrole = mysql_query("SELECT controle_chave FROM muraski WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND ref!='x' AND ref!='' AND controle_chave!=0 ORDER BY controle_chave ASC") OR die("erro 1506 - ".mysql_error());
if(mysql_num_rows($bcontrole) > 0){
	while($linha = mysql_fetch_array($bcontrole)){
	  $contr[] = $linha['controle_chave'];
	}
	  
 	  $numeros = $contr;
	$i = 1;
	$ok = "n";
	$fim_pesquisa = max($numeros);
	if ($fim_pesquisa > 200000) {
		$fim_pesquisa = 200000;
	}
	while ($ok == "n") {
		if (!in_array($i,$numeros)) {
			$ok = "s";
			$controle_chave = $i;
		}
		if ($i == $fim_pesquisa) {
			$ok = "s";
			$controle_chave = $fim_pesquisa + 1;
		}
		$i++;
	}
}
	 	
?>
    <tr class="fundoTabela">
      <td valign=top class=style1><b>Controle Chaves:</b></td>
      <td class="style1"><input type="text" name="controle_chave" id="controle_chave" size="5" class="campo" value="<?=$controle_chave; ?>"> <a href="javascript:;" onClick="NewWindow('p_controle_usado.php?menu=N', 'janela', 750, 500, 'yes')" class="style1"><b>Ver controles: usados e disponíveis</b></a></td>
    </tr>
    <tr class="fundoTabela">
      <td valign=top class=style1><b>Local Chaves:</b></td>
      <td class="style1"><textarea rows="3" name="chaves" id="chaves" cols="36" class="campo"><?=$chaves; ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Zelador:</b></td>
      <td class=style1><input type="text" name="zelador" id="zelador" size="40" class="campo" value="<?=$zelador; ?>"></td>
    </tr>
<? if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ ?>
    <tr class="fundoTabela">
      <td class=style1><b>Taxa Administrativa:</b></td>
      <td class=style1><input type="text" name="limpeza" id="limpeza" size="10" class="campo" value="<?=$limpeza; ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Taxa TV:</b></td>
      <td class=style1><input type="text" name="tv" id="tv" size="10" class="campo" value="<?=$tv; ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Diarista:</b></td>
      <td class=style1><input type="text" name="co_diarista" id="co_diarista" size="4" class="campo2" value="<?=$co_diarista; ?>" readonly>
          <input type="text" name="nome_diarista" id="nome_diarista" size="40" value="<?=$nome_diarista; ?>" class="campo" readonly>
          <input type="button" id="selecionar2" name="selecionar2" value="Selecionar" class="campo3" onClick="NewWindow('p_list_diarista.php', 'janela', 750, 500, 'yes');">
          <strong>Valor:</strong>
          <input type="text" name="comissao_diarista" id="comissao_diarista" size="10" class="campo" value="<?=$comissao_diarista; ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Piscineiro:</b></td>
      <td class=style1><input type="text" name="co_piscineiro" id="co_piscineiro" size="4" class="campo2" valeue="<?=$co_piscineiro; ?>" readonly>
          <input type="text" name="nome_piscineiro" id="nome_piscineiro" size="40" value="<?=$nome_piscineiro; ?>" class="campo" readonly>
          <input type="button" id="selecionar3" name="selecionar3" value="Selecionar" class="campo3" onClick="NewWindow('p_list_piscineiro.php', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_piscineiro" id="comissao_piscineiro" size="10" class="campo" value="<?=$comissao_piscineiro; ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Jardineiro:</b></td>
      <td class=style1><input type="text" name="co_jardineiro" id="co_jardineiro" size="4" value="<?=$co_jardineiro; ?>" class="campo2" readonly>
          <input type="text" name="nome_jardineiro" id="nome_jardineiro" size="40" class="campo" value="<?=$nome_jardineiro; ?>" readonly>
          <input type="button" id="selecionar4" name="selecionar4" value="Selecionar" class="campo3" onClick="NewWindow('p_list_jardineiro.php', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_jardineiro" id="comissao_jardineiro" size="10" class="campo" value="<?=$comissao_jardineiro; ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Eletricista:</b></td>
      <td class=style1><input type="text" name="co_eletricista" id="co_eletricista" size="4" class="campo2" value="<?=$co_eletricista; ?>" readonly>
          <input type="text" name="nome_eletricista" id="nome_eletricista" size="40" class="campo" value="<?=$nome_eletricista; ?>" readonly>
          <input type="button" id="selecionar5" name="selecionar5" value="Selecionar" class="campo3" onClick="NewWindow('p_list_eletrecista.php', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_eletricista" id="comissao_eletricista" size="10" class="campo" value="<?=$comissao_eletricista; ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Encanador:</b></td>
      <td class=style1><input type="text" name="co_encanador" id="co_encanador" size="4" class="campo2" value="<?=$co_encanador; ?>" readonly>
          <input type="text" name="nome_encanador" id="nome_encanador" size="40" class="campo" value="<?=$nome_encanador; ?>" readonly>
          <input type="button" id="selecionar6" name="selecionar6" value="Selecionar" class="campo3" onClick="NewWindow('p_list_encanador.php', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_encanador" id="comissao_encanador" size="10" class="campo" value="<?=$comissao_encanador; ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
<? } ?>
    <tr class="fundoTabela">
      <td class=style1><b>Angariador:</b></td>
      <td class=style1><select name="angariador" id="angariador" class="campo">
      <option value="0">Selecione</option>
<?
 			  if (verificaFuncao("USER_LIBERAR_ACESSO")) { // verifica se pode acessar as areas
			   	$angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$angariador){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}else{
						echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
					}
 				}
 			  }else{
			    $angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$angariador){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
//					}else{
//						echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
					}
 				}
				echo('<option value="'.$_SESSION[u_cod].'" SELECTED>'.$_SESSION[valid_user].'</option>');
			  }
?>








          <?
		  //if (verificaFuncao("GERAL_COMISSAO")) { // verifica se pode acessar as areas
           /* if($_POST['acaob']=='1'){
				$angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha['u_cod']==$_POST['angariador']){
						echo('<option value="'.$linha['u_cod'].'" SELECTED>'.$linha['u_email'].'</option>');
					//}else{
						//echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
					}
 				}
 			}else{

            $angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE u_cod='".$_SESSION['u_cod']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
            while ($linha = mysql_fetch_array($angariadores)) {
               if($linha['u_cod']==$_SESSION['u_cod']){
                  echo('<option value="'.$linha['u_cod'].'" SELECTED>'.$linha['u_email'].'</option>');
                  //}else{
                  //echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
               }
            }
			//}
 		/*}else{
 		    if($_POST['acaob']=='1'){
		    	$angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$_POST['angariador']){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}
 				}
 			}else{
			    $angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$u_cod){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}
 				}
			}
		}*/
?>
        </select>
<?
$comissoesi = mysql_query("SELECT comissao_angariador, comissao_indicador, comissao_vendedor FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
while($linha = mysql_fetch_array($comissoesi)){
   $comissao_angariador = $linha['comissao_angariador'];
   $comissao_indicador = $linha['comissao_indicador'];
   $comissao_vendedor = $linha['comissao_vendedor'];
}
?>
          <? if (verificaFuncao("GERAL_COMISSAO")) { // verifica se pode acessar as areas ?>
          <b>Comiss&atilde;o:</b>
          <input type="text" name="tipo_anga" id="tipo_anga" size="2" class="campo" value="<? if($_POST['tipo_anga']){ echo($_POST['tipo_anga']); }else{ echo($comissao_angariador); } ?>"> %
          <? }else{ ?>
          <input type="hidden" name="tipo_anga" id="tipo_anga" size="2" class="campo" value="<? echo($comissao_angariador); ?>">
          <? } ?>      </td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Indicador:</b></td>
      <td class=style1><input type="text" name="co_cliente2" id="co_cliente2" size="4" value="<?=$co_cliente2; ?>" class="campo2" readonly>
          <input type="text" name="nome_cliente2" id="nome_cliente2" size="40" class="campo" value="<?=$nome_cliente2; ?>" readonly>
          <input type="button" id="selecionar1" name="selecionar1" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=2&c_campo=co_cliente2&n_campo=nome_cliente2', 'janela', 750, 500, 'yes');">
          <? if (verificaFuncao("GERAL_COMISSAO")) { // verifica se pode acessar as areas ?>
          <b>Comiss&atilde;o:</b>
		  <input type="text" name="comissao_indicador" id="comissao_indicador" size="2" class="campo" value="<? if($_POST['comissao_indicador']){ echo($_POST['comissao_indicador']); }else{ echo($comissao_indicador); } ?>"> %
          <? }else{ ?>
          <input type="hidden" name="comissao_indicador" id="comissao_indicador" size="2" class="campo" value="<? echo($comissao_indicador); ?>">
           <? } ?></td>
    </tr>
     <? if (verificaFuncao("GERAL_COMISSAO")) { // verifica se pode acessar as areas ?>
      <tr class="fundoTabela">
         <td class=style1><b>Comiss&atilde;o Vendedor:</b></td>
      	<td class=style1><input type="text" name="comissao_vendedor" id="comissao_vendedor" size="2" class="campo" value="<? if($_POST['comissao_vendedor']){ echo($_POST['comissao_vendedor']); }else{ echo($comissao_vendedor); } ?>"> %
        Exemplo:
        6 ou 15</td>
      </tr>
    <? }else{ ?>
      <input type="hidden" name="comissao_vendedor" id="comissao_vendedor" size="2" class="campo" value="<? echo($comissao_vendedor); ?>">    
    <? } ?>
<?
	 $result30 = mysql_query("SELECT im_disponibilizar, im_site_padrao FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
	 while($row30 = mysql_fetch_array($result30)){
	  	$disponibilizar_im = $row30['im_disponibilizar'];
	  	$disponibilizar_padrao = $row30['im_site_padrao'];
	 }

if($disponibilizar_im<>'0' || $disponibilizar_padrao<>'N'){
?>    
	<tr class="fundoTabela">
      <td class=style1><b>Disponibilizar no site:</b></td>
      <td class="style1"><input name="disponibilizar" type="radio" id="disponibilizar1" value="0" <? if($disponibilizar=='0'){ print "CHECKED"; } ?>>
        N&atilde;o
		<input name="disponibilizar" id="disponibilizar2" type="radio" value="1" checked  <? if($disponibilizar=='1'){ print "CHECKED"; } ?>>
        Sim</td>
    </tr>
<?
}
?>
    <tr class="fundoTabela">
      <td class=style1><b>Disponibilizar p/ parceria na rede:</b></td>
      <td class="style1"><input name="disp_rede" type="radio" id="disp_rede1" value="0" <? if($disp_rede=='0'){ print "CHECKED"; } ?> OnClick="TravaCampo2();">
        N&atilde;o
	  	<input name="disp_rede" id="disp_rede2" type="radio" value="1"  <? if($disp_rede=='1'){ print "CHECKED"; } ?> checked OnClick="TravaCampo2();">
        Sim
        </td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Comiss&atilde;o oferecida p/ parceria:</b></td>
      <td class="style1"><table cellpadding="0" cellspacing="0" border="0">
      <tr><td><select name="comissao_parceria" id="comissao_parceria" class="campo" onchange="mostraCampos();">
          <option value="">Selecione</option>
          <option value="30" <? if($comissao_parceria=='30'){ echo "SELECTED"; } ?>>30%</option>
		  <option value="40" <? if($comissao_parceria=='40'){ echo "SELECTED"; } ?>>40%</option>
		  <option value="50" <? if($comissao_parceria=='50'){ echo "SELECTED"; } ?>>50%</option>
		  <option value="diferenciado" <? if($comissao_parceria=='diferenciado'){ echo "SELECTED"; } ?>>Diferenciado</option>
        </select></td>
	<? //if($_POST['comissao_parceria']=='diferenciado'){ ?>
        <td><input type="text" name="comissao_diferenciado" id="comissao_diferenciado" size="2" class="campo" value="<?=$comissao_diferenciado; ?>" <? if($_POST['comissao_parceria']=='diferenciado'){ ?> style="display:block;" <? }else{ ?> style="display:none;" <? } ?>></td></tr></table></td>
	<? //} ?>
<?
			$result2 = mysql_query("SELECT d_qtd FROM rebri_destaques WHERE d_tipo='Destaques'");
			$row2 = mysql_fetch_array($result2);
			$quantidade = $row2['d_qtd'];
			
			$result3 = mysql_query("SELECT COUNT(cod) as contagemi FROM muraski WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (finalidade='2' OR finalidade='9' OR finalidade='15')");
			while($row3 = mysql_fetch_array($result3)){
	         	$totali = $row3['contagemi'];
	        }
	        
	        $result4 = mysql_query("SELECT COUNT(destaque) as contagemd FROM muraski WHERE destaque='1' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND (finalidade='2' OR finalidade='9' OR finalidade='15')");
			while($row4 = mysql_fetch_array($result4)){
	         	$totald = $row4['contagemd'];
	        }

            $conta = $totali / $quantidade;
            $resultado = ceil($conta);


      if($totald > $resultado || $disponibilizar_im=='0'){
?>
	<tr class="fundoTabela">
      <td class=style1><b>Destaque no site da Rebri:</b><br /><span class="style7">Obs: Se o imóvel não possuir foto e estiver como destaque, ele não será exibido no site da Rebri.</span></td>
      <td class="style1"><input name="destaque" id="destaque1" type="radio" value="0"  <? if($destaque=='0'){ print "CHECKED"; } ?> checked>
        N&atilde;o</td>
    </tr>
<?
	}else{
?>
	<tr class="fundoTabela">
      <td class=style1><b>Destaque no site da Rebri:</b><br /><span class="style7">Obs: Se o imóvel não possuir foto e estiver como destaque, ele não será exibido no site da Rebri.</span></td>
      <td class="style1"><input name="destaque" id="destaque1" type="radio" value="0"  <? if($destaque=='0'){ print "CHECKED"; } ?> checked>
        N&atilde;o
        <input name="destaque" type="radio" id="destaque2" value="1" <? if($destaque=='1'){ print "CHECKED"; } ?>>
        Sim</td>
    </tr>
<?
	}
?>
    </tr>
     <?	if($_SESSION['im_site_padrao']=='S'){ ?>
	 <tr class="fundoTabela">
      <td class=style1><b>Destaque no site padrão:</b><br />
      <span class="style7">Obs: Se o imóvel não possuir foto e estiver como destaque, ele não será exibido no site padr&atilde;o.</span></td>
      <td class="style1"><input name="destaque_padrao" id="destaque_pd1" type="radio" value="0"  <? if ($destaque_padrao<>'1'){ print "CHECKED"; } ?> checked> N&atilde;o
        <input name="destaque_padrao" type="radio" id="destaque_pd2" value="1" <? if($destaque_padrao=='1'){ print "CHECKED"; } ?>> Sim</td>
    </tr>
	 <tr class="fundoTabela">
      <td class=style1><b>Lançamento:</b><br /></td>
      <td class="style1"><input name="lancamento" id="lancamento1" type="radio" value="0"  <? if($lancamento<>'1'){ print "CHECKED"; } ?> checked> N&atilde;o
        <input name="lancamento" type="radio" id="lancamento2" value="1" <? if ($lancamento=='1') { print "CHECKED"; } ?>> Sim</td>
    </tr>
    <? } ?>
<?php
if($_POST['finalidade'] == 17 ||$_POST['finalidade'] == 15 || $_POST['finalidade'] == 16)
{
?>
	<tr class="fundoTabela">
      <td class=style1><b>Exibir calendário no site da rebri e no site padrão:</b></td>
      <td class="style1"><input name="calendario" type="radio" id="calendario1" value="0" <? if($calendario<>'1'){ print "CHECKED"; } ?>>
        N&atilde;o
		<input name="calendario" id="calendario2" type="radio" value="1" <? if($calendario=='1'){ print "CHECKED"; } ?>>
        Sim</td>
	</tr>
<?php
} else {
?>
   <input name="calendario" type="hidden" id="calendario1" value="0" />
<?
}
?>
    <tr class="fundoTabela">
      <td class=style1><b>Observações 01 (Visíveis através do ícone de observações do sistema):</b></td>
      <td class=style1><textarea name="observacoes" id="observacoes" cols="36" rows="5" class="campo"><?=$observacoes; ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Observações 02 (Complemento do titulo do imóvel visível no portal, site e sistema):</b></td>
      <td class=style1><textarea name="observacoes2" id="observacoes2" cols="36" rows="5" class="campo"><?=$observacoes2; ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Observações 03 (Complemento de informações adicionais sobre o imóvel sempre visível, apenas no sistema):</b></td>
      <td class=style1><textarea rows="5" class="campo" name="observacoes3" id="observacoes3" cols="36"><?=$observacoes3; ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Rela&ccedil;&atilde;o de Bens:</b></td>
      <td class=style1><textarea rows="5" name="relacao_bens" id="relacao_bens" cols="36" class="campo"><?=$relacao_bens; ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Código Vídeo:</b><br>
	  * Veja as explicações clicando <a href="explicacoes_videos.htm" target="_blank">aqui</a>. </td>
      <td class=style1><input class="campo" type="text" name="video" id="video" size="15" value="<?=$video; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Origem do Vídeo:</b></td>
      <td class=style1><select name="origem_video" id="origem_video" class="campo">
      	<option value="">Selecione</option>
   		<option value="Globo" <? if($origem_video == "Globo"){ print "SELECTED"; } ?>>Globo</option>
      	<option value="Youtube" <? if($origem_video == "Youtube"){ print "SELECTED"; } ?>>Youtube</option>
      	<option value="Blip" <? if($origem_video == "Blip"){ print "SELECTED"; } ?>>Blip</option>
	 </select></td>
    </tr>
    <!--tr class="fundoTabela">
      <td width="27%" class=style1><b>Especificação:</b></td>
      <td width="70%" class=style1><select size="1" name="especificacao" class="campo">
    <option value="Lançamento" <? //if($especificacao=='Lançamento'){ print "SELECTED"; } ?>>Lançamento</option>
    <option value="Novo" <? //if($especificacao=='Novo'){ print "SELECTED"; } ?>>Novo</option>
    <option value="Semi-Novo" <? //if($especificacao=='Semi-Novo'){ print "SELECTED"; } ?>>Semi-Novo</option>
    <option value="Usado" <? //if($especificacao=='Usado'){ print "SELECTED"; } ?>>Usado</option>
        </select></td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="30%" class=style1><b>Posição X:</b></td>
      <td width="70%" class=style1><input type="text" name="posx" value="<?//=$posx; ?>" class="campo" size=10></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Posição Y:</b></td>
      <td width="70%" class=style1><input type="text" name="posy" value="<?//=$posy; ?>" class="campo" size=10></td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="30%" class=style1><b>Piscina:</b></td>
      <td width="70%" class=style1><select size="1" name="piscina" class="campo">
    <option value="Não" <?// if($piscina=='Não'){ print "SELECTED"; } ?>>Não</option>
    <option value="Sim" <?// if($piscina=='Sim'){ print "SELECTED"; } ?>>Sim</option>
        </select></td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="30%" class=style1><b>Localização:</b></td>
      <td width="70%" class="style1"><input type="text" name="local" size="30" value="<? //if($_POST['local']){ print($_POST['local']); }else{ print "Guaratuba"; } ?>" class="campo">    </td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="30%" class=style1><b>Cidade Mat.:</b></td>
      <td width="70%" class="style1"><select name="cidade_mat" class="campo">
    <option vlaue="Guaratuba" <?// if($cidade_mat=='Guaratuba'){ print "SELECTED"; } ?>>Guaratuba</option>
    <option value="São José dos Pinhais" <?// if($cidade_mat='São José dos Pinhais'){ print "SELECTED"; } ?>>São José dos Pinhais</option>
        </select></td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="30%" class=style1><b>Tipo Divulgação:</b></td>
      <td width="70%" class=style1><input type="text" name="tipo_div" size="40" class="campo" value="<?//=$tipo_div; ?>"></td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 1:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_1" size="30" class="campo" value="<?//=$ftxt_1; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 2:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_2" size="30" class="campo" value="<?//=$ftxt_2; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 3:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_3" size="30" class="campo" value="<?//=$ftxt_3; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 4:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_4" size="30" class="campo" value="<?//=$ftxt_4; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 5:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_5" size="30" class="campo" value="<?//=$ftxt_5; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 6:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_6" size="30" class="campo" value="<?//=$ftxt_6; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 7:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_7" size="30" class="campo" value="<?//=$ftxt_7; ?>"></td>
    </tr>        
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 8:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_8" size="30" class="campo" value="<?//=$ftxt_8; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 9:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_9" size="30" class="campo" value="<?//=$ftxt_9; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 10:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_10" size="30" class="campo" value="<?//=$ftxt_10; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 11:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_11" size="30" class="campo" value="<?//=$ftxt_11; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 12:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_12" size="30" class="campo" value="<?//=$ftxt_12; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 13:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_13" size="30" class="campo" value="<?//=$ftxt_13; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 14:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_14" size="30" class="campo" value="<?//=$ftxt_14; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 15:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_15" size="30" class="campo" value="<?//=$ftxt_15; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 16:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_16" size="30" class="campo" value="<?//=$ftxt_16; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 17:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_17" size="30" class="campo" value="<?//=$ftxt_17; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 18:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_18" size="30" class="campo" value="<?//=$ftxt_18; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 19:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_19" size="30" class="campo" value="<?//=$ftxt_19; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome da foto 20:</b></td>
      <td width="70%" class=style1><input type="text" name="ftxt_20" size="30" class="campo" value="<?//=$ftxt_20; ?>"></td>
    </tr-->
    <tr>
      <td width="30%">
      <input type="hidden" value="1" name="inserir2">
      <input type="hidden" name="cadastra" id="cadastra" value="0">
      <input type="button" value="Inserir Imóvel" name="B1" class="campo3" Onclick="VerificaCampo()"></td>
      <td width="70%"></td>
    </tr>
  </form>
  </table>
</div></center>
<?php
	}
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
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="50%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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
