<?php
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
?>
<html>
<head>
<?php
include("style.php");

?>
<script type="text/javascript" src="funcoes/js.js"></script>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<link href="css/estilo.css" rel="stylesheet" type="text/css">
</head>
<script language="javascript">
function google(coord) {
   if (coord != 'inicio') {
      NewWindow('http://www.redebrasileiradeimoveis.com.br/gera_mapa.php?ori=rebri&coord='+coord, 'janela', 750, 500, 'yes');
   } else {
      NewWindow('http://www.redebrasileiradeimoveis.com.br/gera_mapa.php?ori=rebri&coord=inicio', 'janela', 750, 500, 'yes');
   }
}

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
  } else {
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

function seleciona_opcao_sem(){
    if(document.getElementById('opcao_com').checked){
      document.getElementById('opcao_sem').checked = true;
      document.getElementById('opcao_sem').value = '1';
      document.getElementById('opcao_com').checked = false;
	  document.getElementById('opcao_com').value = '0';
	  <?php $opcao_simnao_new = '0'; ?>
	}else if(document.getElementById('opcao_sem').checked){
      document.getElementById('opcao_com').checked = false;
	  document.getElementById('opcao_com').value = '0';
      <?php $opcao_simnao_new = '0'; ?>
    }
    //alert(<?php echo $opcao_simnao_new; ?>);
}

function seleciona_opcao_com(){
    if(document.getElementById('opcao_sem').checked){
      document.getElementById('opcao_com').checked = true;
      document.getElementById('opcao_com').value = '1';
      document.getElementById('opcao_sem').checked = false;
	  document.getElementById('opcao_sem').value = '0';
	  <?php $opcao_simnao_new = '1'; ?>
	}else if(document.getElementById('opcao_com').checked){
      document.getElementById('opcao_sem').checked = false;
	  document.getElementById('opcao_sem').value = '0';
	  <?php $opcao_simnao_new = '1'; ?>
    }
    //alert(<?php echo $opcao_simnao_new; ?>);
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


function confirmaExclusao()
{
       if(confirm("Tem certeza que deseja excluir?")){
       	document.form1.apaga_imovel_definitivamente.value='1';
		document.form1.submit();
	   }else{
	    return false;  
	   } 
          
}

function confirmaExclusao2()
{
       if(confirm("Tem certeza que deseja excluir?")){
        document.form1.apaga_imovel.value='1';
		document.form1.submit();
	   }else{
	    return false;  
	   } 
}

function confirmaAtivar(cod)
{
       if(confirm("Tem certeza que deseja ativar esse imóvel para venda?"))
          document.location.href='p_edit_imoveis.php?codigo=' + cod;
}


function valida()
{
  if (document.form1.dia.value == "")
  {
    alert("Por favor, digite o Dia desejado");
    document.form1.dia.focus();
    return (false);
  }
  if (document.form1.mes.value == "")
  {
    alert("Por favor, digite o Mês desejado");
    document.form1.mes.focus();
    return (false);
  }
  if (document.form1.ano.value == "")
  {
    alert("Por favor, digite o Ano desejado");
    document.form1.ano.focus();
    return (false);
  }

	return(true);
}


</script>

<?
if ($_GET['codigo']) {

    $cod = $_GET['codigo'];

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


if ($_POST['apaga_imovel_definitivamente']=='1') {

    if((Trim($_SESSION['u_email']) != 'claudir@muraski.com') and ($_SESSION['u_cod'] != '21')){
     //$url_devolta = 'document.location.href="'.$_SERVER['REQUEST_URI'].'"';
     echo ('<script language="javascript">alert("E-mail e/ou Senha do Usuário com status NÃO PODE EXCLUIR IMOVEL DEFINITIVAMENTE");document.location.href="'.$_SERVER['REQUEST_URI'].';"</script>');
     //include("p_imoveis.php");
     exit;
    }

  	$B1 = "Apagar Imóvel Definitivamente";

	$query4 = "select * from muraski where cod='".$_POST['cod']."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die ("Erro 149 - ".mysql_error());
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
   
   	$sqlv = "SELECT * FROM vendas WHERE v_imovel='".$_POST['cod']."' AND cod_imobiliaria = '".$_SESSION['cod_imobiliaria']."'";
   	$resultv = mysql_query($sqlv) or die ("Erro 166 - " . mysql_error());
   	$contador_venda = mysql_num_rows($resultv);

   	$sqll = "SELECT * FROM locacao WHERE l_imovel='".$_POST['cod']."' AND cod_imobiliaria = '".$_SESSION['cod_imobiliaria']."'";
   	$resultl = mysql_query($sqll) or die ("Erro 170 - " . mysql_error());
   	$contador_locacao = mysql_num_rows($resultl);
   
   	$sqlc = "SELECT * FROM contas WHERE co_imovel='".$_POST['cod']."' AND cod_imobiliaria = '".$_SESSION['cod_imobiliaria']."'";
   	$resultc = mysql_query($sqlc) or die ("Erro 174 - " . mysql_error());
   	$contador_contas = mysql_num_rows($resultc);
   
   	$confirm_exc = "s";   
   
   	$msg2 = "";
   
	if($contador_venda > 0){
		$msg2 .= "- Esse imóvel não pode ser excluído pois está vinculado a uma venda<BR>\n";
      $confirm_exc = "n";
   	}
   
	if($contador_locacao > 0){
		$msg2 .= "- Esse imóvel não pode ser excluído pois está vinculado a uma locação<BR>\n";
      $confirm_exc = "n";
   	}
   	
   	if($contador_contas > 0){
		$msg2 .= "- Esse imóvel não pode ser excluído pois está vinculado a uma conta<BR>\n";
      $confirm_exc = "n";
   	}

   	if ($confirm_exc == "n") {
 
 		$msg = "<div align=\"center\" class=\"style7\"><b>Exclusão não realizada</b><br>".$msg2."</div>";
  
	} else {

   $data = date("Y-m-d");
   $hora = date("H:i:s");

	//Insere o usuário que esta fazendo a atualização do imovel
   $insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$_POST['cod']."','".$_POST['ref']."','".$B1."','".$data."','".$hora."')") or die ("Erro 87 - ".mysql_error());

    /*
	//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
   $busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$id_excluir_def."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 90 - ".mysql_error());
   $cont = mysql_num_rows($busca_reg);
   if($cont > 10) {
      mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 93 - ".mysql_error());
   }
   */

	$msg = "<div align=\"center\" class=\"style7\">Você apagou definitivamente o imóvel Ref.: ".$_POST['ref']."</div>";


   	$query = "delete from muraski where cod = '".$_POST['cod']."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");

   include("p_imoveis.php");
   exit;
   
   }
}


if ($_POST['apaga_imovel']=='1') {

	$B1 = "Apagar Imóvel";

	$query4 = "select * from muraski where cod='".$_POST['cod']."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die ("Erro 235 - ".mysql_error());
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
	$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$_POST['cod']."','".$_POST['ref']."','".$B1."','".$data."','".$hora."')") or die ("Erro 133 - ".mysql_error());
	/*
	//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
	$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 136 - ".mysql_error());
	$cont = mysql_num_rows($busca_reg);
	if($cont > 10){
		mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 139 - ".mysql_error());
	}
	*/

	$msg = "<div align=\"center\" class=\"style7\">Você apagou o imóvel Ref.: ".$_POST['ref']."</div>";

   $query = "update muraski set ref='x' where cod = '".$_POST['cod']."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   $result = mysql_query($query) or die("Não foi possível apagar suas informações.");

   include("p_imoveis.php");
   exit;
   
}

if ($_POST['altera']=="1") {

    $B1 = "Atualizar Imóvel";
	//$titulo = strip_tags($titulo);
	$titulo = AddSlashes($titulo);
	//$descricao = strip_tags($descricao);
	$desc = AddSlashes($descricao);
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
	$observacoes = AddSlashes($_POST['observacoes']);
	$endereco_contrato = AddSlashes($endereco_contrato);

	$cartorio_oficio = $_POST['cartorio_oficio'];
	$lote = $_POST['lote'];
	$quadra  = $_POST['quadra'];
	$planta  = $_POST['planta'];

	$chaves = AddSlashes($chaves);
	$relacao_bens = AddSlashes($relacao_bens);
	$data_bens = "$anob-$mesb-$diab";

	$observacoes2 = AddSlashes($observacoes2);
	$observacoes3 = AddSlashes($observacoes3);
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
	$ncoordenadas = $_POST['ncoordenadas'];
	$calendario = $_POST['calendario'];

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

	if($permuta=='Não'){
		$permuta_txt = '';
	}
	
	if($exibir_endereco<>'1'){
		$exibir_endereco = 0;
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

	$numero4 = count($_POST['dias_plocacao']);

		   for ($i4 = 0; $i4 <= ($numero4 - 1); $i4++)
		   {
			   $j4 = $i4 + 1;
			   if($j4 == $numero4){
				$dias_plocacao1 .= "-".$dias_plocacao[$i4]."-";
			   }else{
				$dias_plocacao1 .= "-".$dias_plocacao[$i4] . "-";
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
	
	if($disp_rede=='0'){
	  $comissao_parceria = '';
	}
			
		
		if($totalperc > 100){

	 		$msg =  "<div align=\"center\" class=\"style7\">A soma total dos percentuais dos proprietários é maior que 100!</div>";
		}
		elseif($totalperc < 100)
		{
		   $msg =  "<div align=\"center\" class=\"style7\">A soma total dos percentuais dos proprietários não pode ser inferior a 100!</div>";	
		}
		else
		{
		  
	//Insere o usuário que esta fazendo a atualização do imovel
	$insere = mysql_query ("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."', '".$u_cod."','".$cod."','".$ref."','".$B1."','".$data."','".$hora."')") or die ("Erro 464 - ".mysql_error());

	//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
	$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 271 - ".mysql_error());
	$cont = mysql_num_rows($busca_reg);
	if($cont > 10){
		mysql_query ("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 274 - ".mysql_query());
	}

    if(isset($_POST['opcao_sem'])){
      $opcao_simnao_new = '0'; //$_POST['opcao_sem'];
      //echo "<script> javascript:alert(OPCAO SEM =".$opcao_simnao_new."); </script><BR><BR><BR>";
    }elseif(isset($_POST['opcao_com'])){
      $opcao_simnao_new = '1'; //$_POST['opcao_com'];
      //echo "<script> javascript:alert(OPCAO COM =".$opcao_simnao_new."); </script><BR><BR><BR>";
    }



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
	, cliente='$cliente', percentual_prop='$percentual', matricula='$matricula', cidade_mat='$cidade_mat', cartorio_oficio = '$cartorio_oficio', lote = '$lote', quadra = '$quadra', planta = '$planta', bairro = '".$bairro1."'
	, tipo_logradouro='$tipo_logradouro', end='$ende', numero='$numero_end', cep='$cep', averbacao='$averbacao', acomod='$acomod'
	, dist_mar='$dist_mara', dist_tipo='$dist_tipoa', limpeza='$limpeza'
	, diaria1='$diaria1', diaria2='$diaria2', data_inicio='$data_inicio'
	, data_fim='$data_fim', comissao='$comissao', dias='$dias', dias_plocacao='".$dias_plocacao1."', contrato='$contrato', opcao_simnao='$opcao_simnao_new'
	, carnaval='$carnaval', anonovo='$anonovo', coordenadas = '".$coordenadas."', posx='$posx', posy='$posy', tv='$tv'
	, angariador='$angariador', zelador='$zelador', tipo_anga='$tipo_anga', indicador='$co_cliente2'
   , comissao_indicador='$comissao_indicador', comissao_vendedor='$comissao_vendedor', diarista='$co_diarista'
   , comissao_diarista='$comissao_diarista', piscineiro='$co_piscineiro', comissao_piscineiro='$comissao_piscineiro'
   , eletricista='$co_eletricista', comissao_eletricista='$comissao_eletricista', encanador='$co_encanador'
   , comissao_encanador='$comissao_encanador', jardineiro='$co_jardineiro', comissao_jardineiro='$comissao_jardineiro'
   , chaves='$chaves', controle_chave='$controle_chave', tipo_div='$tipo_div', valor_oferta='$valor_oferta'
   , relacao_bens='$relacao_bens', data_bens='$data_bens', observacoes = '".$observacoes."', disponibilizar = '".$disponibilizar."'
   , disp_rede = '".$disp_rede."', destaque = '".$destaque."', destaque_padrao = '".$destaque_padrao."'
   , lancamento='".$lancamento."', comissao_parceria = '".$comissao_parceria."'
   , contador = '".$conta_p."', construtora = '$construtora', idade_imovel = '$idade_imovel', condominio = '$condominio', apto = '$apto' 
   , end_igual = '$end_igual', end_aproximado='$end_aproximado', tipo_logradouro_mapa = '$tipo_logradouro_mapa', end_mapa = '$ende_mapa'
   , numero_mapa = '$numero_end_mapa', cep_mapa = '$cep_mapa', video='$video', origem_video='$origem_video', endereco_contrato='$endereco_contrato'
   , exibir_endereco='$exibir_endereco', observacoes2='$observacoes2', observacoes3='$observacoes3', ncoordenadas='$ncoordenadas', calendario='$calendario'
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
	, cliente='$cliente', percentual_prop='$percentual', matricula='$matricula', cidade_mat='$cidade_mat', cartorio_oficio = '$cartorio_oficio', lote = '$lote', quadra = '$quadra', planta = '$planta', bairro = '".$bairro1."'
	, tipo_logradouro='$tipo_logradouro', end='$ende', numero='$numero_end', cep='$cep', averbacao='$averbacao'
	, dist_mar='$dist_mara', dist_tipo='$dist_tipoa'
	, data_inicio='$data_inicio'
	, data_fim='$data_fim', comissao='$comissao', dias='$dias', dias_plocacao='".$dias_plocacao1."', contrato='$contrato', opcao_simnao='$opcao_simnao_new'
	, coordenadas = '".$coordenadas."', posx='$posx', posy='$posy'
	, angariador='$angariador', zelador='$zelador', tipo_anga='$tipo_anga', indicador='$co_cliente2'
    , comissao_indicador='$comissao_indicador', comissao_vendedor='$comissao_vendedor', chaves='$chaves'
    , controle_chave='$controle_chave', tipo_div='$tipo_div', valor_oferta='$valor_oferta', relacao_bens='$relacao_bens'
    , data_bens='$data_bens'
    , observacoes = '".$observacoes."', disponibilizar = '".$disponibilizar."', disp_rede = '".$disp_rede."'
    , destaque = '".$destaque."', destaque_padrao = '".$destaque_padrao."', lancamento='".$lancamento."'
    , comissao_parceria = '".$comissao_parceria."', contador='".$conta_p."'
    , construtora = '$construtora', idade_imovel = '$idade_imovel', condominio = '$condominio', apto = '$apto'
    , end_igual = '$end_igual', end_aproximado='$end_aproximado', tipo_logradouro_mapa = '$tipo_logradouro_mapa', end_mapa = '$ende_mapa'
    , numero_mapa = '$numero_end_mapa', cep_mapa = '$cep_mapa', video='$video', origem_video='$origem_video', endereco_contrato='$endereco_contrato'
    , exibir_endereco='$exibir_endereco', observacoes2='$observacoes2', observacoes3='$observacoes3', ncoordenadas='$ncoordenadas', calendario='$calendario'
	where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");

	}

    //echo "Mostra QUERY ==> ".$query."<BR><BR><BR>";

    //echo "Mostra OPCAO DEPOIS ==> ".$opcao_simnao_new;
    //die();


	$msg = "<div align=\"center\" class=\"style7\">Você atualizou o imóvel Ref.: ".$ref."</div>";
	include("p_imoveis.php");
	exit;

	}
}
?>


</script>
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
<form  name="form1" id="form1" method="post" action="p_edit_imoveis.php?cod=<?=$cod ?>&edit=editar&m=1">
<input type="hidden" name="acao" id="acao" value="0">
<?php
	$query2 = "select * from muraski where cod = '".$_GET['cod']."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$angariador = $not2[angariador];
	$cod_indicador = $not2[indicador];
	$cod_diarista = $not2[diarista];
	$cod_eletricista = $not2[eletricista];
	$cod_encanador = $not2[encanador];
	$cod_jardineiro = $not2[jardineiro];
	$cod_piscineiro = $not2[piscineiro];
	$contrato = $not2[contrato];
  	$construtora = $not2[construtora];
  	$idade_imovel = $not2[idade_imovel];
  	$condominio = $not2[condominio];
  	$apto = $not2[apto];
  	$disponibilizar = $not2[disponibilizar];
	$disp_rede = $not2[disp_rede];
	$destaque = $not2[destaque];
	$destaque_padrao = $not2[destaque_padrao];
	$lancamento = $not2[lancamento];
	$coordenadas = $not2[coordenadas];
	$finalidade = $not2[finalidade];
	$cliente1 = explode("--", $not2[cliente]);
	$cliente2 = str_replace("-","",$cliente1);
	$percentual1 = explode("--", $not2[percentual_prop]);
	$percentual2 = str_replace("-","",$percentual1);
	$contador2 = $not2[contador];
	$ncoordenadas = $not2[ncoordenadas];
	$calendario = $not2[calendario];

	$tipo1 = $not2[tipo];
	if($_POST['bcom']!='1'){
		if($not2['comissao_parceria']!=''){
			if($not2['comissao_parceria']!='30' && $not2['comissao_parceria']!='40' && $not2['comissao_parceria']!='50'){
	  			$comissao_parceria = "diferenciado";
	  			$comissao_diferenciado = $not2['comissao_parceria'];
			}else{
	  			$comissao_parceria = $not2['comissao_parceria'];
			}
		}
	}

   if($not2[dist_mar]=='' && $not2[dist_tipo]=='') {
	  $opcao = '';
	} elseif($not2[dist_tipo]<>'') {
	  $dist_mar = $not2[dist_mar];
	  $dist_tipo = $not2[dist_tipo];
	  $opcao = 1;
	} else {
	  $dist_mar1 = $not2[dist_mar];
	  $opcao = 2;
	}


	//REALIZA BUSCA DO NOME DO INDICADOR
	$queryI = "select * from clientes where c_cod='$cod_indicador' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultI = mysql_query($queryI);
	while($notI = mysql_fetch_array($resultI))
	{
	   $indicador = $notI[c_nome];
	}

	//REALIZA BUSCA DO NOME DA DIARISTA
	$queryD = "select * from clientes where c_cod='$cod_diarista' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultD = mysql_query($queryD);
	while($notD = mysql_fetch_array($resultD))
	{
	   $diarista = $notD[c_nome];
	}

	//REALIZA BUSCA DO NOME DO ELETRICISTA
	$queryE = "select * from clientes where c_cod='$cod_eletricista' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultE = mysql_query($queryE);
	while($notE = mysql_fetch_array($resultE))
	{
	   $eletricista = $notE[c_nome];
	}
	
	//REALIZA BUSCA DO NOME DO ENCANADOR
	$queryEN = "select * from clientes where c_cod='$cod_encanador' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultEN = mysql_query($queryEN);
	while($notEN = mysql_fetch_array($resultEN))
	{
	   $encanador = $notEN[c_nome];
	}
	
	//REALIZA BUSCA DO NOME DO JARDINEIRO
	$queryJ = "select * from clientes where c_cod='$cod_jardineiro' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultJ = mysql_query($queryJ);
	while($notJ = mysql_fetch_array($resultJ))
	{
	   $jardineiro = $notJ[c_nome];
	}

	//REALIZA BUSCA DO NOME DO PISCINEIRO
	$queryP = "select * from clientes where c_cod='$cod_piscineiro' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultP = mysql_query($queryP);
	while($notP = mysql_fetch_array($resultP))
	{
	   $piscineiro = $notP[c_nome];
	}

    $query20 = "SELECT c.ci_nome FROM rebri_cidades c INNER JOIN muraski m ON (c.ci_cod=m.local) WHERE m.cod='".$not2['cod']."'";
	$result20 = mysql_query($query20);
	while($not20 = mysql_fetch_array($result20)){
		$nlocal = $not20['ci_nome'];
	}

	$query30 = "SELECT c.ci_nome FROM rebri_cidades c INNER JOIN muraski m ON (c.ci_cod=m.cidade_mat) WHERE m.cod='".$not2['cod']."'";
	$result30 = mysql_query($query30);
	while($not30 = mysql_fetch_array($result30)){
		$ncidade_mat = $not30['ci_nome'];
	}
?>
<script language="javascript">
function VerificaCampo(cod){

var msgErro = '';

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
				document.form1.ref.focus();
				document.form1.ref.style.backgroundColor = '<?=$cor_erro ?>';
				return false;
			}
			else
			{
				document.form1.ref.style.backgroundColor = '<?=$cor1 ?>';  
			}
			
	   	}
	   	<? if($not2['cliente']=='' || $not2['cliente']=='--'){ ?>
	   	if (document.form1.cont.selectedIndex == 0)
  		{
				alert("Por favor, selecione o n° de proprietários");
    			document.form1.cont.focus();
    			document.form1.cont.style.backgroundColor = '<?=$cor_erro ?>';
    			return false;
  		}
  		<? } ?>
		<? for($i = 1; $i <= $_POST['cont']; $i++){ ?>
  			if (document.form1.cliente4_<?=$i ?>.value == "")
  			{
    			alert("Por favor, selecione o Proprietário <?=$i ?>");
    			document.form1.nome_cliente4_<?=$i ?>.focus();
    			document.form1.nome_cliente4_<?=$i ?>.style.backgroundColor = '<?=$cor_erro ?>';
    			return false;
  			}
  			else
  			{
			 	document.form1.nome_cliente4_<?=$i ?>.style.backgroundColor = '<?=$cor1 ?>';   
			}
			if (document.form1.percentual4_<?=$i ?>.value == "")
  			{
    			alert("Por favor, preencha o campo Percentual <?=$i ?>");
    			document.form1.percentual4_<?=$i ?>.focus();
    			document.form1.percentual4_<?=$i ?>.style.backgroundColor = '<?=$cor_erro ?>';
    			return false;
  			}
  			else
  			{
			 	document.form1.percentual4_<?=$i ?>.style.backgroundColor = '<?=$cor1 ?>';   
			}
  		<? } ?>	  		
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
	   	if(document.form1.diae.value.length==0)
  	   	{
  	    	alert( "Por favor, preencha o campo Dia Inicial de Contrato de." );
			document.form1.diae.focus();
			document.form1.diae.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.diae.style.backgroundColor = '<?=$cor1 ?>';
		}
  	   	if(document.form1.mese.value.length==0)
       	{
    		alert( "Por favor, preencha o campo Mês Inicial de Contrato de." );
			document.form1.mese.focus();
			document.form1.mese.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.mese.style.backgroundColor = '<?=$cor1 ?>';
		}
       	if(document.form1.anoe.value.length==0)
       	{
         	alert( "Por favor, preencha o campo Ano Inicial de Contrato de." );
			document.form1.anoe.focus();
			document.form1.anoe.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.anoe.style.backgroundColor = '<?=$cor1 ?>';
		}
       	if(document.form1.diae1.value.length==0)
       	{
         	alert( "Por favor, preencha o campo Dia Final de Contrato de." );
			document.form1.diae1.focus();
			document.form1.diae1.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.diae1.style.backgroundColor = '<?=$cor1 ?>';
		}
       	if(document.form1.mese1.value.length==0)
       	{
         	alert( "Por favor, preencha o campo Mês Final de Contrato de." );
			document.form1.mese1.focus();
			document.form1.mese1.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.mese1.style.backgroundColor = '<?=$cor1 ?>';
		}
       	if(document.form1.anoe1.value.length==0)
       	{
    		alert( "Por favor, preencha o campo Ano Final de Contrato de." );
			document.form1.anoe1.focus();
			document.form1.anoe1.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.anoe1.style.backgroundColor = '<?=$cor1 ?>';
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
  		if(document.form1.n_quartos.value.length==0  && document.form1.tipo1.value != 6)
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
				document.form1.comossao_parceria.style.backgroundColor = '<?=$cor_erro ?>';
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
		document.form1.altera.value='1';
		document.form1.submit();
    	return true;


	   	if(document.form1.diab.value.length==0)
  	   	{
  	    	alert( "Por favor, preencha o campo Dia Relação de Bens." );
			document.form1.diab.focus();
			document.form1.diab.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.diab.style.backgroundColor = '<?=$cor1 ?>';
		}
  	   	if(document.form1.mesb.value.length==0)
       	{
    		alert( "Por favor, preencha o campo Mês Relação de Bens." );
			document.form1.mesb.focus();
			document.form1.mesb.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.mesb.style.backgroundColor = '<?=$cor1 ?>';
		}
       	if(document.form1.anob.value.length==0)
       	{
         	alert( "Por favor, preencha o campo Ano Relação de Bens." );
			document.form1.anob.focus();
			document.form1.anob.style.backgroundColor = '<?=$cor_erro ?>';
			return false;
		}
		else
		{
		  document.form1.anob.style.backgroundColor = '<?=$cor1 ?>';
		}

}
</script>
<div align="center">
  <center>
  <table width="75%" border="0" cellpadding="1" cellspacing="1">
  <tr height="50"><td colspan=2 class="style1" align="center"><b>Editar ou Apagar Imóvel</b> <?=$msg ?></td></tr>
    <tr class="fundoTabela">
      <td class=style1><b>Finalidade:</b></td>
      <td class="style1"><select name="finalidade" id="finalidade" class="campo" onChange="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar&m=1';form1.submit();">
         <option value="">Selecione uma op&ccedil;&atilde;o</option>
          <?php

        if($_POST['finalidade'] && $_GET['m'] == '1' && $finalidade<>'6'){
        	$bfinalidade = mysql_query("SELECT f_cod, f_nome FROM finalidade WHERE f_cod!='1' AND f_cod!='8' AND f_cod!='7' AND f_cod!='14' AND f_cod!='17' ORDER BY f_cod ASC");
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
 		}else{
 		  if($finalidade=='6'){
		    $bfinalidade = mysql_query("SELECT f_cod, f_nome FROM finalidade WHERE f_cod='6' ORDER BY f_cod ASC");
 			while($linha = mysql_fetch_array($bfinalidade)){
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'</option>');
 			}
 		  }else{
		  	$bfinalidade = mysql_query("SELECT f_cod, f_nome FROM finalidade WHERE f_cod!='1' AND f_cod!='8' AND f_cod!='7' AND f_cod!='14' AND f_cod!='17' ORDER BY f_cod ASC");
 			while($linha = mysql_fetch_array($bfinalidade)){
				if($linha[f_cod]==$finalidade){
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
		  }
		}
 	?>
      </select> <? if($finalidade=='6'){ echo("<input type=\"button\" value=\"Ativar para Venda\" class=\"campo3\" name=\"B1\" onClick=\"javascript:confirmaAtivar(".$not2[cod].")\">");  } ?></td>
    </tr>
	<tr class="fundoTabela">
      <td width="35%" class=style1><b>Tipo de im&oacute;vel:</b></td>
      <td width="65%" class=style1> <select name="tipo1" id="tipo1" class="campo" onChange="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar&m=1';form1.submit();">
          <option value="">Selecione</option>
      <?
      if($_POST['tipo1']){
        	$btipo = mysql_query("SELECT t_cod, t_nome FROM rebri_tipo ORDER BY t_nome ASC");
 			while($linha = mysql_fetch_array($btipo)){
				if ($linha[t_cod]==$_POST['tipo1']) {
 		     		echo('<option value="'.$linha[t_cod].'" SELECTED>'.$linha['t_nome'].'</option>');
		   	} else {
		     		echo('<option value="'.$linha[t_cod].'">'.$linha['t_nome'].'</option>');
		   	}
			}
      }else{
		  	$btipo = mysql_query("SELECT t_cod, t_nome FROM rebri_tipo ORDER BY t_nome ASC");
 			while($linha = mysql_fetch_array($btipo)){
				if($linha[t_cod]==$not2[tipo]){
 		     		echo('<option value="'.$linha[t_cod].'" SELECTED>'.$linha['t_nome'].'</option>');
		   	} else {
		     		echo('<option value="'.$linha[t_cod].'">'.$linha['t_nome'].'</option>');
		   	}
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
		}else{
		  $tipo_secundario = $not2['tipo_secundario'];
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

		if($_POST['tipo1']){
			$busca_tipo_secundario = mysql_query("SELECT * FROM rebri_tipo WHERE t_cod!='".$_POST['tipo1']."' ORDER BY t_nome");
			while($linha = mysql_fetch_array($busca_tipo_secundario)){
		?>
			<div class="DivBairros"><input type="checkbox" name="tipo_secundario[]" id="tipo_secundario" value="<?php echo($linha['t_cod']); ?>" <?php verifica_check3("".$linha['t_cod']."", $tipo_secundario) ?>><?= ucwords(strtolower($linha['t_nome'])); ?></div>

		<?
			}
		}else{
		  	$busca_tipo_secundario = mysql_query("SELECT * FROM rebri_tipo WHERE t_cod!='".$not2['tipo']."' ORDER BY t_nome");
			while($linha = mysql_fetch_array($busca_tipo_secundario)){
		?>
			<div class="DivBairros"><input type="checkbox" name="tipo_secundario[]" id="tipo_secundario" value="<?php echo($linha['t_cod']); ?>" <?php verifica_check3("".$linha['t_cod']."", $tipo_secundario) ?>><?= ucwords(strtolower($linha['t_nome'])); ?></div>

		<?
			}
		}
		?>
	  </fieldset></td>
    </tr>
	<tr class="fundoTabela">
      <td width="35%" class=style1><b>Referência:</b></td>
      <td width="65%" class=style1> <input type="text" class="campo" name="ref" id="ref" size="10" maxlength="10" value="<?php print("$not2[ref]"); ?>" onKeyUp="return autoTab(this, 10, event);"> <a href="javascript:;" onClick="NewWindow('p_ref.php?menu=N', 'janela', 750, 500, 'yes')" class="style1"><b>Ver referências: usadas e disponíveis</b></a></td>
   </tr>
	<!--tr class="fundoTabela">
      <td width="35%" class=style1><b>Proprietário:</b></td>
      <td width="65%" class=style1> <input type="text" name="cliente" size="5" class="campo2" value="<?php print($cliente); ?>" readonly>
           <input type="text" name="nome_cliente" size="60" class="campo" value='<?php print($nome_cliente); ?>' readonly>
           <input type="button" id="selecionar2" name="selecionar2" value="Selecionar" class="campo3" onClick="NewWindow('p_list_proprietario2.php', 'janela', 750, 500, 'yes');">
	  </td>
    </tr-->   
    <tr class="fundoTabela">
      <td width="35%" class=style1><b>Proprietário: N° de campos: </b><select name="cont" id="cont" class="campo" onChange="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar&m=1';form1.submit();">
		  <option value="">Selecione</option>
          <option value="1" <? if($_POST['cont']=='1'){ print "SELECTED"; } ?>>+1</option>
          <option value="2" <? if($_POST['cont']=='2'){ print "SELECTED"; } ?>>+2</option>
          <option value="3" <? if($_POST['cont']=='3'){ print "SELECTED"; } ?>>+3</option>
          <option value="4" <? if($_POST['cont']=='4'){ print "SELECTED"; } ?>>+4</option>
          <option value="5" <? if($_POST['cont']=='5'){ print "SELECTED"; } ?>>+5</option>
          <option value="6" <? if($_POST['cont']=='6'){ print "SELECTED"; } ?>>+6</option>
          <option value="7" <? if($_POST['cont']=='7'){ print "SELECTED"; } ?>>+7</option>
          <option value="8" <? if($_POST['cont']=='8'){ print "SELECTED"; } ?>>+8</option>
          <option value="9" <? if($_POST['cont']=='9'){ print "SELECTED"; } ?>>+9</option>
          <option value="10" <? if($_POST['cont']=='10'){ print "SELECTED"; } ?>>+10</option>
          </select><br><span class="style7">Obs: Para substituir um proprietário que já existe por outro basta clicar no botão "Selecionar" e selecionar outro proprietário</span></td>
      <td width="65%" class=style1>
<?
            if($_GET['contador']){
			  $contador = $_GET['contador'] - 1; 
			}else{
			  $contador = $not2['contador'];
			}


		     for($i3 = 1; $i3 <= $contador; $i3++){
			   echo("
			   		<input type=\"text\" name=\"cliente_$i3\" id=\"cliente_$i3\" size=\"5\" class=\"campo2\" value=\"".$cliente2[$i3-1]."\" readonly>
               ");
			   //BUSCA O NOME DO CLIENTE
				$queryC = "select * from clientes where c_cod='".$cliente2[$i3-1]."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$resultC = mysql_query($queryC);
				while($notC = mysql_fetch_array($resultC))
				{
	   				$nome_cliente3 = $notC[c_nome];
				}
				
				if($_POST['percentual_'.$i3.'']){
				  $percent = $_POST['percentual_'.$i3.''];
				}else{
				  $percent = $percentual2[$i3-1];
				}
			   echo("
           			<input type=\"text\" name=\"nome_cliente_$i3\" id=\"nome_cliente_$i3\" size=\"30\" class=\"campo\" value='$nome_cliente3' readonly>
           			<input type=\"button\" id=\"selecionar2\" name=\"selecionar2\" value=\"Selecionar\" class=\"campo3\" onClick=\"NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=3&c_campo=cliente_$i&n_campo=nome_cliente_$i', 'janela', 750, 500, 'yes');\">
           			<b>Percentual:</b>
					<input type=\"text\" name=\"percentual_$i3\" id=\"percentual_$i3\" size=\"2\" class=\"campo\" value=\"".$percent."\">%
				");
			   if($contador=='1'){
			       echo("<br>");
			   }
			   if($contador<>'1'){
			   		echo("
						<a href=\"p_edit_imoveis.php?cod=".$cod."&edit=editar&contador=".$contador."&cont=".$cont."\" class=\"style1\" title=\"Para remover o proprietário deve clicar em Remover e depois no botão Atualizar Imóvel\"> Remover</a><br>
			   		");
			   }
			   echo "<b>Dados do Prop.: </b><a href=\"p_clientes.php?lista=1&c_cod=".$cliente2[$i3-1]."\" class=\"style1\" >Clique aquipara visualizar os dados do cliente</a><br>";
			 }

		   if($_POST['cont']){
		     for($i = 1; $i <= $_POST['cont']; $i++){

		        $cod_clientes = "cliente4_".$i;
	    		$cliente4 = $_POST[$cod_clientes];
	    		$clientes = "nome_cliente4_".$i;
	    		$nome_cliente4 = $_POST[$clientes];
				$percentuais = "percentual4_".$i;
	    		$percentual4 = $_POST[$percentuais];


			   echo("
			   		<input type=\"text\" name=\"cliente4_$i\" id=\"cliente4_$i\" size=\"5\" class=\"campo2\" value=\"".$cliente4."\" readonly>
           			<input type=\"text\" name=\"nome_cliente4_$i\" id=\"nome_cliente4_$i\" size=\"30\" class=\"campo\" value='$nome_cliente4' readonly>
           			<input type=\"button\" id=\"selecionar2\" name=\"selecionar2\" value=\"Selecionar\" class=\"campo3\" onClick=\"NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=3&c_campo=cliente4_$i&n_campo=nome_cliente4_$i', 'janela', 750, 500, 'yes');\">
           			<b>Percentual:</b>
					<input type=\"text\" name=\"percentual4_$i\" id=\"percentual4_$i\" size=\"2\" class=\"campo\" value=\"".$percentual4."\">%<br>
			   ");
			 }
		   }
?>         
            <input type="hidden" name="contador" id="contador" size="5" class="campo2" value="<?=$contador ?>"></td>
    </tr>
	<tr class="fundoTabela">
      <td width="35%" class=style1><b>Construtora:</b></td>
      <td width="65%" class=style1>
         <input type="text" class="campo" size="40" name="construtora" id="construtora" value="<?php if($_POST['construtora']){ print($_POST['construtora']); }else{ print($not2[construtora]); } ?>"></td>
   </tr>
	<tr class="fundoTabela">
      <td width="35%" class=style1><b>Imóvel construído em:</b></td>
      <td width="65%" class=style1>
         <input type="text" class="campo" size="4" maxlength="4" name="idade_imovel" id="idade_imovel" value="<?php if($_POST['idade_imovel']){ print($_POST['idade_imovel']); }else{ print($not2[idade_imovel]); } ?>"> Ex: 2009</td>
   </tr>
	<tr class="fundoTabela">
      <td width="35%" class=style1><b>Condomínio:</b></td>
      <td width="65%" class=style1>
         <input type="text" class="campo" size="40" name="condominio" id="condominio" value="<? if($_POST['condominio']){ print($_POST['condominio']); }else{ print($not2[condominio]); } ?>"></td>
   </tr>
    <!--tr class="fundoTabela">
      <td class=style1><b>Comiss&atilde;o Proprietário:</b></td>
      <td class=style1><input type="text" name="comissao_prop" id="comissao_prop" size="2" class="campo" value="<? if($_POST['comissao_prop']){ echo($_POST['comissao_prop']); }else{ echo($not2[comissao_prop]); } ?>">
        Exemplo:
        6 ou 15</td>
    </tr-->
<?php
if($_POST['acao']=='1'){
  	$anoe = $_POST['anoe'];
	$mese = $_POST['mese'];
	$diae = $_POST['diae'];
}else{
	$anoe = substr ($not2[data_inicio], 0, 4);
	$mese = substr($not2[data_inicio], 5, 2 );
	$diae = substr ($not2[data_inicio], 8, 2 );
}
?>
    <tr class="fundoTabela">
      <td class=style1><b>Dias &uacute;teis:</b></td>
      <td class=style1>
        <!--input type="text" name="dias" value="<?php //func_data($data_entrada, $data_saida);  ?>" size="3" class="campo" readonly-->
        <!--input type="text" name="dias" value="<?php //somar_dias_uteis($datai, $diasu);  ?>" size="12" class="campo" readonly-->
        <? // }else{ ?>
        <input type="text" name="dias" id="dias" value="<?php if($_POST['dias']){ print($_POST['dias']); }else{ print($not2[dias]); } ?>" size="3" class="campo">
        <? // } ?>
        Obs.: Apenas para im&oacute;veis &agrave; venda.</td>
    </tr>
    <tr class="fundoTabela">
      <td width="35%" class=style1><b>Contrato de:</b></td>
      <td width="65%" class=style1> 
      <input type="text" name="diae" id="diae" value="<?php if($_POST['diae']){ print($_POST['diae']); }else{ print($diae); } ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mese" id="mese" value="<?php if($_POST['mese']){ print($_POST['mese']); }else{ print($mese); } ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="anoe" id="anoe" value="<?php if($_POST['anoe']){ print($_POST['anoe']); }else{ print($anoe); } ?>" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);">
	   <input type="button" value="Calcular data final" name="calcular" id="calcular" class="campo3" onClick="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar&m=1';form1.acao.value='1';form1.submit();">
      <b>à</b> 
<?php
if($_POST['acao']=='1'){
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

$datai = $_POST['diae']."/".$_POST['mese']."/".$_POST['anoe'];
$diasu = $_POST['dias'];

$data_final = somar_dias_uteis($datai, $diasu);
list($diae1, $mese1, $anoe1) = explode('/', $data_final);
    
}else{
  	$anoe10 = substr ($not2[data_fim], 0, 4);
	$mese10 = substr($not2[data_fim], 5, 2 );
	$diae10 = substr ($not2[data_fim], 8, 2 );
} 
?>  
	  
	  <input type="text" name="diae1" id="diae1" value="<?php if($diae1){ print($diae1); }else{ print($diae10); } ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mese1" id="mese1" value="<?php if($mese1){ print($mese1); }else{ print($mese10); } ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="anoe1" id="anoe1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php if($anoe1){ print($anoe1); }else{ print($anoe10); } ?>"> Ex.: 
    10/10/1910</td>
    </tr>
    <!--tr class="fundoTabela">
      <td class=style1><b>Contrato:</b></td>
      <td class=style1><select size="1" name="contrato" id="contrato" class="campo">
        <option value="">Selecione um contrato</option>
        <?php
        /*
        if($_POST['contrato']){
        	$documentos = mysql_query("select d_cod, d_nome FROM doc WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linha = mysql_fetch_array($documentos)){
 		  	$d_nome = substr ($linha[d_nome], 0, 30);
				if($linha[d_cod]==$_POST['contrato']){
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'" SELECTED>'.$d_nome.'...</option>');
				}else{ 			   
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'">'.$d_nome.'...</option>');
				}
         	}
 	  }else{  
        	$documentos = mysql_query("select d_cod, d_nome FROM doc WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY d_nome ASC");
 			while($linha = mysql_fetch_array($documentos)){
 		  	$d_nome = substr ($linha[d_nome], 0, 30);
				if($linha[d_cod]==$contrato){
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'" SELECTED>'.$d_nome.'...</option>');
				}else{ 			   
					echo('<option value="'.$linha[d_cod].'" title="'.$linha[d_nome].'">'.$d_nome.'...</option>');
				}
			}
	  }
      */
 	?>
      </select></td>
    </tr-->
<?php

	if(($not2[finalidade] == "9") or 
	($not2[finalidade] == "10") or 
	($not2[finalidade] == "11") or 
	($not2[finalidade] == "13") or 
	($not2[finalidade] == "12") or 
	($not2[finalidade] == "14") or 
	($not2[finalidade] == "15") or 
	($not2[finalidade] == "16") or 
	($not2[finalidade] == "17")){
?>
<?php
	//if($cadastrado == 1){
	//$imovel = substr ($not2[ref], 0, 4);
	$imovel = "ref" . $not2[ref];
?>
    <tr class="fundoTabela">
      <td class=style1><b>Situação da Locação : </b></td>
      <td class="style1">
        <input name="opcao_sem" id="opcao_sem" type="radio" value="0" <? if($not2[opcao_simnao]=='0'){ echo "CHECKED"; } ?> OnClick="seleciona_opcao_sem()">
        SEM Op&ccedil;&atilde;o assinada
        <input name="opcao_com" id="opcao_com" type="radio" value="1" <? if($not2[opcao_simnao]=='1'){ echo "CHECKED"; } ?> OnClick="seleciona_opcao_com()">
        COM Op&ccedil;&atilde;o assinada
      </td>
    </tr>

<!-- AKI COMEÇA -->

    <tr class="fundoTabela">
      <td class=style1><b>Pacotes de Locação : </b></td>
      <td class="style1">
	  <?

	    if($_POST['dias_plocacao']){
		  $dias_plocacao = implode('-', $_POST['dias_plocacao']);
		}else{
		  $dias_plocacao = $not2['dias_plocacao'];
		}

		function verifica_dias_locado($campo_select3, $select3){
			$funcoes3 = explode("-", $select3);
			$funcoes_cnt3   = count($funcoes3);

			for ($i3 = 0; $i3 < $funcoes_cnt3; $i3++)
 			{
				if($campo_select3 == $funcoes3[$i3]){
					echo "checked";
   				}
 			}
  		}

	  ?>
           <input type="checkbox" name="dias_plocacao[]" id="dias_plocacao"  value="7" <?php verifica_dias_locado('7', $dias_plocacao);?>> [07 Sete Dias]&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="dias_plocacao[]" id="dias_plocacao" value="10" <?php verifica_dias_locado('10', $dias_plocacao);?>> [10 Dez Dias]&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="dias_plocacao[]" id="dias_plocacao" value="15" <?php verifica_dias_locado('15', $dias_plocacao);?>> [15 Quinze Dias]&nbsp;&nbsp;&nbsp;&nbsp;

	  </td>
    </tr>


<script language="JavaScript">
function <?php print("$imovel"); ?>()
{
	NewWindow('p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=2', 'janela', 750, 500, 'yes');
}
</script>
	<tr class="fundoTabelaDestaque">
		<td colspan=2 class="style1" height="25px">
    		<p align="left"><b><a href="javascript:<?php print("$imovel"); ?>();" class=style1>Imprimir Contrato</a></b></p>
    	</td>
   	</tr>
<?php
	//}
	
	if(($not2[finalidade] == "9") or ($not2[finalidade] == "10") or ($not2[finalidade] == "11") or ($not2[finalidade] == "13") or ($not2[finalidade] == "12") or ($not2[finalidade] == "14")){
?>
	<tr class="fundoTabelaDestaque">
   		<td colspan=2 class="style1" height="25px">
   			<p align="left"><b><a href="p_rel_loc_mes.php?cod=<?php print("$not2[cod]"); ?>" class=style1>Visualizar Relatório de Locações</a></b></p>
   		</td>
  	</tr>
<? }elseif(($not2[finalidade] == "15") or ($not2[finalidade] == "16") or ($not2[finalidade] == "17")){ ?>
	<tr class="fundoTabelaDestaque">
  		<td colspan=2 class="style1" height="25px">
    		<p align="left"><b><a href="p_rel_loc.php?cod=<?php print("$not2[cod]"); ?>" class=style1>Visualizar Relatório de Locações</a></b></p>
    	</td>
  	</tr>	
<? } ?>
  	<tr class="fundoTabelaDestaque">
  		<td colspan=2 class="style1" height="25px">
    		<p align="left"><b><a href="javascript:;" onClick="NewWindow('p_extrato_locacao.php?cod_imovel=<?php print("$not2[cod]"); ?>', 'janela', 750, 500, 'yes')" class="style1"><b>Extrato de Locações</b></a></b></p>
    	</td>
  	</tr>
<?php
	}
	else
	{
?>
<?php
	//if($cadastrado == 1){
	//$imovel = substr ($not2[ref], 0, 4);
	$imovel1 = "ref1" . $not2[ref];
	$imovel3 = "ref3" . $not2[ref];
?>
<script language="JavaScript"> 
function <?php print("$imovel1"); ?>()
{
	NewWindow('p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&imp=5', 'janela', 750, 500, 'yes');
}
</script>
<script language="JavaScript"> 
function <?php print("$imovel3"); ?>()
{
	NewWindow('p_imp_doc.php?cod=<?php print("$not2[cod]"); ?>&c_cod=<?=$not2[cliente] ?>&gera_contrato=S&imp=4', 'janela', 750, 500, 'yes')
}
</script>
	<tr class="fundoTabelaDestaque">
    	<td colspan=2 class="style1" height="25px">
    		<p align="left"><b><a href="javascript:<?php print("$imovel1"); ?>();" class=style1>Imprimir Contrato</a></b></p>
    	</td>
    </tr>
    <tr class="fundoTabelaDestaque">
    	<td colspan=2 class="style1" height="25px">
    		<p align="left"><b><a href="javascript:<?php print("$imovel3"); ?>();" class=style1>Imprimir Renovação</a></b></p>
    	</td>
    </tr>
<?php
	//}
	$imovel2 = "ref2" . $not2[ref];
?>
<script language="JavaScript"> 
function <?php print("$imovel2"); ?>()
{
	NewWindow('fazer_sinal.php?cod=<?php print($not2[cod]); ?>&codi=<?php print($_SESSION['cod_imobiliaria']); ?>', 'janela', 750, 500, 'yes');
}
</script>
	<tr class="fundoTabelaDestaque">
		<td colspan=2 class="style1" height="25px">
    		<p align="left"><b><a href="p_rel_int.php?cod=<?php print("$not2[cod]"); ?>" class=style1>Visualizar Relatório de Interessados</a></b></p>
    	</td>
    </tr>
	<tr class="fundoTabelaDestaque">
		<td colspan=2 class="style1" height="25px">
    		<p align="left"><b><a href="javascript:<?php print("$imovel2"); ?>();" class=style1>Fazer proposta de Compra</a></b></p>
    	</td>
    </tr>
<?php
	}
?>
<script language="JavaScript"> 
function <?php print("imovel_bens"); ?>()
{
	NewWindow('p_imp_bens.php?cod=<?php print("$not2[cod]"); ?>&codi=<?=$_SESSION['cod_imobiliaria']?>', 'janela', 750, 500, 'yes');
}
</script>
    <tr class="fundoTabelaDestaque">
    	<td colspan=2 class="style1" height="25px">
    		<p align="left"><b><a href="javascript:<?php print("imovel_bens"); ?>();" class=style1>Imprimir Relação de bens</a></b></p>
    	</td>
    </tr>
    <tr class="fundoTabelaDestaque">
    	<td colspan=2 class="style1" height="25px">
      		<p align="left"><b><a href="javascript:;" onClick="NewWindow('solicitacao_servicos.php?cod=<?php echo("$not2[cod]"); ?>', 'janela', 750, 500, 'yes')" class="style1">Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b></p>
      	</td>
    </tr>
    <!--tr class="fundoTabelaDestaque">
    	<td colspan=2 class="style1" height="25px">
      		<p align="left"><b><a href="javascript:;" onClick="NewWindow('cadastro_anuncios2.php?cod=<?php echo("$not2[cod]"); ?>&rel=S', 'janela', 750, 500, 'yes')" class="style1">Editar Exportações</a></b></p>
      	</td>
    </tr-->
    <tr class="fundoTabelaDestaque">
    	<td colspan=2 class="style1" height="25px">
      		<p align="left"><b><a href="p_rel_anuncios.php?cod=<?php print("$not2[cod]"); ?>" class=style1>Visualizar Relat&oacute;rio de Exportações </a></b></p>
      	</td>
    </tr>
<?
    if(($not2[finalidade] == "15") or ($not2[finalidade] == "16") or ($not2[finalidade] == "17")){
      
// descomentar esse item para mandar para o ar      
?>
    <tr class="fundoTabelaDestaque">
		<td colspan=2 class="style1" height="25px">
			<p align="left"><b><a href="javascript:;" onClick="NewWindow('despesas.php?cod=<?php echo("$not2[cod]"); ?>', 'janela', 750, 500, 'yes')" class="style1">Despesas do Imóvel</a></b></p>
		</td>
    </tr>
<? } ?>
	<!--tr class="fundoTabela">
      <td colspan=2 class="style1"><b><a href="#" onClick="NewWindow('', 'uprelatorio', 750, 500, 'yes');form1.target='uprelatorio';form1.action='cadastro_servicos.php?cod=<?php echo("$not2[cod]"); ?>';form1.submit();" class=style1>Serviços de Cobrança</a></b></td>
    </tr-->
    <tr class="fundoTabela">
		<td class=style1>
			<p align="left"><b><? if($_POST['finalidade']){ if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ echo("Di&aacute;ria"); }else{ echo("Valor"); } }else{  if($not2[finalidade]=='15' || $not2[finalidade]=='16' || $not2[finalidade]=='17'){ echo("Di&aacute;ria"); }else{ echo("Valor"); } } ?>:</b></p>
		</td>
      	<td class=style1><input type="text" class="campo" name="valor" id="valor" size="10" value="<?php print(number_format($not2[valor], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Valor Oferta:</b></td>
      <td class=style1><input type="text" name="valor_oferta" id="valor_oferta" size="10" class="campo" value="<?php print(number_format($not2[valor_oferta], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
		<br>
        <b> Obs.: Ao preencher este valor o im&oacute;vel aparecer&aacute; em destaque</b></td>
    </tr>
<? 
	if($_POST['finalidade']){   
		if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ 
?>
    <tr class="fundoTabela">
    <td class=style1><b>Valor Carnaval:</b></td>
      <td class=style1><input type="text" name="carnaval" size="10" class="campo" value="<?php print(number_format($not2[carnaval], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Valor Ano Novo:</b></td>
      <td class=style1><input type="text" name="anonovo" size="10" class="campo" value="<?php print(number_format($not2[anonovo], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Di&aacute;ria m&iacute;nima/Di&aacute;ria m&aacute;xima:</b></td>
      <td class=style1><input type="text" name="diaria1" id="diaria1" size="10" class="campo" value="<?php print(number_format($not2[diaria1], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
        /
          <input type="text" name="diaria2" id="diaria2" size="10" class="campo" value="<?php print(number_format($not2[diaria2], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
<? 		
		} 
    }else{
		if($not2[finalidade]=='15' || $not2[finalidade]=='16' || $not2[finalidade]=='17'){ 
?>		
		<tr class="fundoTabela">
    <td class=style1><b>Valor Carnaval:</b></td>
      <td class=style1><input type="text" name="carnaval" size="10" class="campo" value="<?php print(number_format($not2[carnaval], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Valor Ano Novo:</b></td>
      <td class=style1><input type="text" name="anonovo" size="10" class="campo" value="<?php print(number_format($not2[anonovo], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Di&aacute;ria m&iacute;nima/Di&aacute;ria m&aacute;xima:</b></td>
      <td class=style1><input type="text" name="diaria1" id="diaria1" size="10" class="campo" value="<?php print(number_format($not2[diaria1], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
        /
          <input type="text" name="diaria2" id="diaria2" size="10" class="campo" value="<?php print(number_format($not2[diaria2], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
<?		
		}
	}

?>
    <tr class="fundoTabela">
      <td class=style1><b>Comiss&atilde;o Imobili&aacute;ria:</b></td>
      <td class=style1><input type="text" name="comissao" id="comissao" size="2" class="campo" value="<?php print("$not2[comissao]"); ?>"> %
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
					<option value="Alameda" <? if($not2['tipo_logradouro']=='Alameda'){ echo "SELECTED"; } ?>>Alameda</option>
					<option value="Área" <? if($not2['tipo_logradouro']=='Área'){ echo "SELECTED"; } ?>>Área</option>
					<option value="Avenida" <? if($not2['tipo_logradouro']=='Avenida'){ echo "SELECTED"; } ?>>Avenida</option>														
					<option value="Campo" <? if($not2['tipo_logradouro']=='Campo'){ echo "SELECTED"; } ?>>Campo</option>
					<option value="Chácara" <? if($not2['tipo_logradouro']=='Chácara'){ echo "SELECTED"; } ?>>Chácara</option>
					<option value="Colônia" <? if($not2['tipo_logradouro']=='Colônia'){ echo "SELECTED"; } ?>>Colônia</option>
					<option value="Condomínio" <? if($not2['tipo_logradouro']=='Condomínio'){ echo "SELECTED"; } ?>>Condomínio</option>
					<option value="Conjunto" <? if($not2['tipo_logradouro']=='Conjunto'){ echo "SELECTED"; } ?>>Conjunto</option>
					<option value="Distrito" <? if($not2['tipo_logradouro']=='Distrito'){ echo "SELECTED"; } ?>>Distrito</option>
					<option value="Esplanada" <? if($not2['tipo_logradouro']=='Esplanada'){ echo "SELECTED"; } ?>>Esplanada</option>
					<option value="Estação" <? if($not2['tipo_logradouro']=='Estação'){ echo "SELECTED"; } ?>>Estação</option>
					<option value="Estrada" <? if($not2['tipo_logradouro']=='Estrada'){ echo "SELECTED"; } ?>>Estrada</option>
					<option value="Favela" <? if($not2['tipo_logradouro']=='Favela'){ echo "SELECTED"; } ?>>Favela</option>
					<option value="Fazenda" <? if($not2['tipo_logradouro']=='Fazenda'){ echo "SELECTED"; } ?>>Fazenda</option>
    				<option value="Feira" <? if($not2['tipo_logradouro']=='Feira'){ echo "SELECTED"; } ?>>Feira</option>
					<option value="Jardim" <? if($not2['tipo_logradouro']=='Jardim'){ echo "SELECTED"; } ?>>Jardim</option>
					<option value="Ladeira" <? if($not2['tipo_logradouro']=='Ladeira'){ echo "SELECTED"; } ?>>Ladeira</option>
	    			<option value="Lago" <? if($not2['tipo_logradouro']=='Lago'){ echo "SELECTED"; } ?>>Lago</option>
					<option value="Lagoa" <? if($not2['tipo_logradouro']=='Lagoa'){ echo "SELECTED"; } ?>>Lagoa</option>
					<option value="Largo" <? if($not2['tipo_logradouro']=='Largo'){ echo "SELECTED"; } ?>>Largo</option>
					<option value="Loteamento" <? if($not2['tipo_logradouro']=='Loteamento'){ echo "SELECTED"; } ?>>Loteamento</option>
					<option value="Morro" <? if($not2['tipo_logradouro']=='Morro'){ echo "SELECTED"; } ?>>Morro</option>
					<option value="Núcleo" <? if($not2['tipo_logradouro']=='Núcleo'){ echo "SELECTED"; } ?>>Núcleo</option>
					<option value="Parque" <? if($not2['tipo_logradouro']=='Parque'){ echo "SELECTED"; } ?>>Parque</option>
					<option value="Passarela" <? if($not2['tipo_logradouro']=='Passarela'){ echo "SELECTED"; } ?>>Passarela</option>
    				<option value="Pátio" <? if($not2['tipo_logradouro']=='Pátio'){ echo "SELECTED"; } ?>>Pátio</option>
					<option value="Praça" <? if($not2['tipo_logradouro']=='Praça'){ echo "SELECTED"; } ?>>Praça</option>
					<option value="Quadra" <? if($not2['tipo_logradouro']=='Quadra'){ echo "SELECTED"; } ?>>Quadra</option>
					<option value="Recanto" <? if($not2['tipo_logradouro']=='Recanto'){ echo "SELECTED"; } ?>>Recanto</option>
					<option value="Residencial" <? if($not2['tipo_logradouro']=='Residencial'){ echo "SELECTED"; } ?>>Residencial</option>
					<option value="Rodovia" <? if($not2['tipo_logradouro']=='Rodovia'){ echo "SELECTED"; } ?>>Rodovia</option>
					<option value="Rua" <? if($not2['tipo_logradouro']=='Rua'){ echo "SELECTED"; } ?>>Rua</option>
    				<option value="Setor" <? if($not2['tipo_logradouro']=='Setor'){ echo "SELECTED"; } ?>>Setor</option>
					<option value="Sítio" <? if($not2['tipo_logradouro']=='Sítio'){ echo "SELECTED"; } ?>>Sítio</option>
					<option value="Travessa" <? if($not2['tipo_logradouro']=='Travessa'){ echo "SELECTED"; } ?>>Travessa</option>
					<option value="Trecho" <? if($not2['tipo_logradouro']=='Trecho'){ echo "SELECTED"; } ?>>Trecho</option>
					<option value="Trevo" <? if($not2['tipo_logradouro']=='Trevo'){ echo "SELECTED"; } ?>>Trevo</option>
					<option value="Vale" <? if($not2['tipo_logradouro']=='Vale'){ echo "SELECTED"; } ?>>Vale</option>
					<option value="Vereda" <? if($not2['tipo_logradouro']=='Vereda'){ echo "SELECTED"; } ?>>Vereda</option>
    				<option value="Via" <? if($not2['tipo_logradouro']=='Via'){ echo "SELECTED"; } ?>>Via</option>
					<option value="Viaduto" <? if($not2['tipo_logradouro']=='Viaduto'){ echo "SELECTED"; } ?>>Viaduto</option>
					<option value="Viela" <? if($not2['tipo_logradouro']=='Viela'){ echo "SELECTED"; } ?>>Viela</option>
					<option value="Vila" <? if($not2['tipo_logradouro']=='Vila'){ echo "SELECTED"; } ?>>Vila</option>
      			</select>
      			<input type="text" name="ende" id="ende" size="50" class="campo" value="<?php print("$not2[end]"); ?>"> <b>N&uacute;mero:</b> <input type="text" name="numero_end" id="numero_end" size="5" class="campo" value="<?php print("$not2[numero]"); ?>">
      		</td>
      	<tr>
      	<tr>
      		<td class="style1" height="25px">
      			<b>Complemento:</b> <input type="text" class="campo" size="30" name="apto" id="apto" value="<? if($_POST['apto']){ print($_POST['apto']); }else{ print($not2[apto]); } ?>">
      		</td>
      	<tr>
      	<tr>
      		<td class="style1" height="25px">
      			<b>CEP:</b> <input name="cep" type="text" class="campo" id="cep" value="<?php print("$not2[cep]"); ?>" size="8" maxlength="8">&nbsp;&nbsp;Exemplo: 80000000
      		</td>
      	<tr>
<?
/**
?>
      	<tr>
      		<td style="text-align: justify; padding-right: 5px">
      			<span class="style7">Para que o mapa funcione corretamente sem precisar preencher as coordenadas do Google Maps no campo "Coordenadas" é preciso o tipo de logradouro + endereço completo, o campo n&uacute;mero e o CEP preenchidos. (Exemplo: Avenida 29 de Abril 601 CEP: 80000000)</span>
      		</td>
      	<tr>
<? /**/ ?>
      </table>
     </td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Mapa do Google:</b></td>
      <td class=style1><input type="text" name="ncoordenadas" id="ncoordenadas" size="50" class="campo" value="<?=$ncoordenadas?>" >
<? if ($ncoordenadas == "") { ?>
         <input type="button" value="Localizar Endereço" name="B1" class="campo3" Onclick="google('inicio');"> </td>
<? } else {
      $tcoord = str_replace("(", "", $ncoordenadas);
      $tcoord = str_replace(")", "", $tcoord);
?>
         <input type="button" value="Localizar Endereço" name="B1" class="campo3" Onclick="google('<?=urlencode($tcoord)?>');"> </td>
<? } ?>
    </tr>
    <input name="end_igual" type="hidden" id="end_igual" value="<?=$end_igual?>" />
<? if($_SESSION['cod_imobiliaria']<>'3'){ ?>	
    <textarea rows="3" name="coordenadas" id="coordenadas" cols="40" class="campo" style="display: none; " ><?=$coordenadas; ?></textarea>
<? }else{ ?>
    <tr class="fundoTabela">
      <td class=style1><b>Coordenadas:</b><br>
      * Entre no site <a href="http://maps.google.com.br" target="_blank">Google Maps</a> e digite o endere&ccedil;o completo, cidade, estado (Ex: rua teste, 10, curitiba, pr) e depois clicar em &quot;Link&quot; e copiar e colar o codigo HTML nesse campo.Veja <a href="images/exemplo.jpg" target="_blank">aqui</a> o exemplo<br><br>
	  * Mapa da InfoCenter somente colocar as coordenadas do imóvel separados por / (barra). Ex: 4146/1872</td>
      <td class=style1><textarea rows="3" name="coordenadas" id="coordenadas" cols="40" class="campo"><?=$coordenadas; ?></textarea></td>
    </tr>
<? } ?>	

<? /**
    <tr class="fundoTabela">
      <td class=style1><b>Endere&ccedil;os Id&ecirc;nticos?</b></td>
      <td class="style1"><input name="end_igual" type="checkbox" id="end_igual" value="1" <? if($not2[end_igual]=='1'){ print "CHECKED"; } ?> OnClick="TravaCampo();">
        Sim </td>
    </tr>

<? /**/ ?>
    <tr class="fundoTabela">
      <td class=style1><b>Exibir endereço no site?</b></td>
      <td class="style1"><input name="exibir_endereco" type="checkbox" id="exibir_endereco" value="1" <? if($not2[exibir_endereco]=='1'){ print "CHECKED"; } ?>>
        Não exibir<br><span class="style7">Obs: Se este campo estiver marcado o ícone no mapa do Google e o endereço do imóvel não aparecerá no site.</span></td>
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
       <td class="style1"><select name="tipo_logradouro_mapa" id="tipo_logradouro_mapa" class="campo" <? if($not2[end_igual]=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
           <option value="">Selecione</option>
           <option value="Alameda" <? if($not2['tipo_logradouro_mapa']=='Alameda'){ echo "SELECTED"; } ?>>Alameda</option>
           <option value="&Aacute;rea" <? if($not2['tipo_logradouro_mapa']=='&Aacute;rea'){ echo "SELECTED"; } ?>>&Aacute;rea</option>
           <option value="Avenida" <? if($not2['tipo_logradouro_mapa']=='Avenida'){ echo "SELECTED"; } ?>>Avenida</option>
           <option value="Campo" <? if($not2['tipo_logradouro_mapa']=='Campo'){ echo "SELECTED"; } ?>>Campo</option>
           <option value="Ch&aacute;cara" <? if($not2['tipo_logradouro_mapa']=='Ch&aacute;cara'){ echo "SELECTED"; } ?>>Ch&aacute;cara</option>
           <option value="Col&ocirc;nia" <? if($not2['tipo_logradouro_mapa']=='Col&ocirc;nia'){ echo "SELECTED"; } ?>>Col&ocirc;nia</option>
           <option value="Condom&iacute;nio" <? if($not2['tipo_logradouro_mapa']=='Condom&iacute;nio'){ echo "SELECTED"; } ?>>Condom&iacute;nio</option>
           <option value="Conjunto" <? if($not2['tipo_logradouro_mapa']=='Conjunto'){ echo "SELECTED"; } ?>>Conjunto</option>
           <option value="Distrito" <? if($not2['tipo_logradouro_mapa']=='Distrito'){ echo "SELECTED"; } ?>>Distrito</option>
           <option value="Esplanada" <? if($not2['tipo_logradouro']=='Esplanada'){ echo "SELECTED"; } ?>>Esplanada</option>
           <option value="Esta&ccedil;&atilde;o" <? if($not2['tipo_logradouro_mapa']=='Esta&ccedil;&atilde;o'){ echo "SELECTED"; } ?>>Esta&ccedil;&atilde;o</option>
           <option value="Estrada" <? if($not2['tipo_logradouro_mapa']=='Estrada'){ echo "SELECTED"; } ?>>Estrada</option>
           <option value="Favela" <? if($not2['tipo_logradouro_mapa']=='Favela'){ echo "SELECTED"; } ?>>Favela</option>
           <option value="Fazenda" <? if($not2['tipo_logradouro_mapa']=='Fazenda'){ echo "SELECTED"; } ?>>Fazenda</option>
           <option value="Feira" <? if($not2['tipo_logradouro_mapa']=='Feira'){ echo "SELECTED"; } ?>>Feira</option>
           <option value="Jardim" <? if($not2['tipo_logradouro_mapa']=='Jardim'){ echo "SELECTED"; } ?>>Jardim</option>
           <option value="Ladeira" <? if($not2['tipo_logradouro_mapa']=='Ladeira'){ echo "SELECTED"; } ?>>Ladeira</option>
           <option value="Lago" <? if($not2['tipo_logradouro_mapa']=='Lago'){ echo "SELECTED"; } ?>>Lago</option>
           <option value="Lagoa" <? if($not2['tipo_logradouro_mapa']=='Lagoa'){ echo "SELECTED"; } ?>>Lagoa</option>
           <option value="Largo" <? if($not2['tipo_logradouro_mapa']=='Largo'){ echo "SELECTED"; } ?>>Largo</option>
           <option value="Loteamento" <? if($not2['tipo_logradouro_mapa']=='Loteamento'){ echo "SELECTED"; } ?>>Loteamento</option>
           <option value="Morro" <? if($not2['tipo_logradouro_mapa']=='Morro'){ echo "SELECTED"; } ?>>Morro</option>
           <option value="N&uacute;cleo" <? if($not2['tipo_logradouro_mapa']=='N&uacute;cleo'){ echo "SELECTED"; } ?>>N&uacute;cleo</option>
           <option value="Parque" <? if($not2['tipo_logradouro_mapa']=='Parque'){ echo "SELECTED"; } ?>>Parque</option>
           <option value="Passarela" <? if($not2['tipo_logradouro_mapa']=='Passarela'){ echo "SELECTED"; } ?>>Passarela</option>
           <option value="P&aacute;tio" <? if($not2['tipo_logradouro_mapa']=='P&aacute;tio'){ echo "SELECTED"; } ?>>P&aacute;tio</option>
           <option value="Pra&ccedil;a" <? if($not2['tipo_logradouro_mapa']=='Pra&ccedil;a'){ echo "SELECTED"; } ?>>Pra&ccedil;a</option>
           <option value="Quadra" <? if($not2['tipo_logradouro_mapa']=='Quadra'){ echo "SELECTED"; } ?>>Quadra</option>
           <option value="Recanto" <? if($not2['tipo_logradouro_mapa']=='Recanto'){ echo "SELECTED"; } ?>>Recanto</option>
           <option value="Residencial" <? if($not2['tipo_logradouro_mapa']=='Residencial'){ echo "SELECTED"; } ?>>Residencial</option>
           <option value="Rodovia" <? if($not2['tipo_logradouro_mapa']=='Rodovia'){ echo "SELECTED"; } ?>>Rodovia</option>
           <option value="Rua" <? if($not2['tipo_logradouro_mapa']=='Rua'){ echo "SELECTED"; } ?>>Rua</option>
           <option value="Setor" <? if($not2['tipo_logradouro_mapa']=='Setor'){ echo "SELECTED"; } ?>>Setor</option>
           <option value="S&iacute;tio" <? if($not2['tipo_logradouro_mapa']=='S&iacute;tio'){ echo "SELECTED"; } ?>>S&iacute;tio</option>
           <option value="Travessa" <? if($not2['tipo_logradouro_mapa']=='Travessa'){ echo "SELECTED"; } ?>>Travessa</option>
           <option value="Trecho" <? if($not2['tipo_logradouro_mapa']=='Trecho'){ echo "SELECTED"; } ?>>Trecho</option>
           <option value="Trevo" <? if($not2['tipo_logradouro_mapa']=='Trevo'){ echo "SELECTED"; } ?>>Trevo</option>
           <option value="Vale" <? if($not2['tipo_logradouro_mapa']=='Vale'){ echo "SELECTED"; } ?>>Vale</option>
           <option value="Vereda" <? if($not2['tipo_logradouro_mapa']=='Vereda'){ echo "SELECTED"; } ?>>Vereda</option>
           <option value="Via" <? if($not2['tipo_logradouro_mapa']=='Via'){ echo "SELECTED"; } ?>>Via</option>
           <option value="Viaduto" <? if($not2['tipo_logradouro_mapa']=='Viaduto'){ echo "SELECTED"; } ?>>Viaduto</option>
           <option value="Viela" <? if($not2['tipo_logradouro_mapa']=='Viela'){ echo "SELECTED"; } ?>>Viela</option>
           <option value="Vila" <? if($not2['tipo_logradouro_mapa']=='Vila'){ echo "SELECTED"; } ?>>Vila</option>
         </select>
           <input type="text" name="ende_mapa" id="ende_mapa" size="50" class="campo" value="<?php print("$not2[end_mapa]"); ?>" <? if($not2[end_igual]=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
           <b>N&uacute;mero:</b>
           <input type="text" name="numero_end_mapa" id="numero_end_mapa" size="5" class="campo" value="<?php print("$not2[numero_mapa]"); ?>" <? if($not2[end_igual]=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>><br>
           <b>CEP no Mapa:</b> <input type="text" name="cep_mapa" id="cep_mapa" size="8" maxlength="8" class="campo" value="<?php print("$not2[cep_mapa]"); ?>" <? if($not2[end_igual]=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
Exemplo: 80000000 <br>
           <span class="style7">Caso o Google não exiba corretamente a localização no mapa preencha o endereço com a localização correta do mapa. (Exemplo: Avenida 29 de Abril 601 CEP: 80000000)</span></td>
     </tr>

<?
/**/
?>

     <!--tr class="fundoTabela">
       <td class=style1><b>N&uacute;mero:</b></td>
       <td class=style1><input type="text" name="numero_end" id="numero_end" size="5" class="campo" value="<?php print("$not2[numero]"); ?>"></td>
     </tr-->

      <input name="end_aproximado" type="hidden" id="end_aproximado" value="<?=$end_aproximado?>" />

<?
/**
?>
        <tr class="fundoTabela">
      <td class=style1><b>Endere&ccedil;o Aproximado?</b></td>
      <td class="style1"><input name="end_aproximado" type="checkbox" id="end_aproximado" value="1" <? if($not2[end_aproximado]=='1'){ print "CHECKED"; } ?>>
        Sim<br><span class="style7">Obs: Se este campo estiver marcado o ícone no mapa do Google não aparecerá.</span></td>
    </tr>
<?
/**/
?>
    <tr class="fundoTabela">
      <td class="style1"><b>Estado:</b></td>
      <td class="style1"><input type="hidden" name="acaoci" id="acaoci" value="0">
	  <select name="im_estado" id="im_estado" class="campo" onChange="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar&m=1';form1.acaoci.value='1';form1.submit();">
          <option value="">Selecione o Estado</option>
          <?
        if($_POST['im_estado']){
        	$bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$_POST['im_estado']){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>');
				}else{
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
 	
 			}
 		}else{ 		
 		$bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$not2['uf']){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
 			}
		}

 ?>
      </select></td>
    </tr>
    
    <?
    if($_POST['finalidade']){
        $contratos = mysql_query("SELECT contrato_venda, contrato_locacao FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
 		while($linha = mysql_fetch_array($contratos)){
            if($_POST['finalidade']=='2' || $_POST['finalidade']=='3' || $_POST['finalidade']=='4' || $_POST['finalidade']=='5' || $_POST['finalidade']=='6' || $_POST['finalidade']=='7'){
			    $contrato = $linha['contrato_venda'];
			}elseif($_POST['finalidade']=='9' || $_POST['finalidade']=='10' || $_POST['finalidade']=='11' || $_POST['finalidade']=='12' || $_POST['finalidade']=='13' || $_POST['finalidade']=='14' || $_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){
			    $contrato = $linha['contrato_locacao'];
			}
         }
    }else{
	     $contrato = $not2['contrato'];
	}
	  ?>
      
      <input type="hidden" name="contrato" id="contrato" value="<?=$contrato ?>"> 
	<tr class="fundoTabela">
      <td width="35%" class="style1"><b>Localização:</b></td>
      <td width="65%" class="style1"><input type="hidden" name="acaoba" id="acaoba" value="0">
	  <select name="local" id="local" class="campo" onChange="form1.action='p_edit_imoveis.php?cod=<?php echo($cod); ?>&edit=editar&m=1';form1.acaoba.value='1';form1.acaoci.value='1';form1.submit();">
		<option value="">Selecione a Cidade</option>
       <?
 		if($_POST['acaoci']=='1'){
	        $bcidades2 = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_POST['im_estado']."' ORDER BY ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidades2)){
				if($linha[ci_cod]==$_POST['local']){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
 			}
		}else{ 
			$bcidades2 = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$not2['uf']."' ORDER BY ci_nome ASC");
			while($linha = mysql_fetch_array($bcidades2)){
				if($linha[ci_cod]==$not2['local']){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
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
		}else{
		  $bairro = $not2['bairro'];
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

		if($_POST['local']){
			$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_POST['local']."' ORDER BY b_nome");
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
			<div class="DivBairros"><input type="checkbox" name="bairro[]" id="bairro" value="<?php echo($linha['b_cod']); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>><?= ucwords(strtolower($linha['b_nome'])); ?></div>

		<?
			}
		}elseif($_POST['acaoba']<>'1' && $_POST['acaoci']<>'1'){ 
		  	$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$not2['local']."' ORDER BY b_nome");
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
			<div class="DivBairros"><input type="checkbox" name="bairro[]" id="bairro" value="<?php echo($linha['b_cod']); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>><?= ucwords(strtolower($linha['b_nome'])); ?></div>

		<?
			}
		}
		?>
	  </fieldset></td>
    </tr>
   <tr class="fundoTabela">
      <td width="35%" class=style1><b>Título:</b> </td>
      <td width="65%" class=style1> <textarea rows="2" class="campo" name="titulo" id="titulo" cols="36"><?php
      $not2[titulo] = stripslashes($not2[titulo]);
      print("$not2[titulo]");
      ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="35%" class=style1><b>Descrição:</b></td>
      <td width="65%" class=style1> <textarea rows="5" class="campo" name="descricao" id="descricao" cols="36"><?php
      $not2[descricao] = stripslashes($not2[descricao]);
      print("$not2[descricao]");
      ?></textarea></td>
    </tr>
<? 
	if($_POST['finalidade']){   
		if($_POST['finalidade']=='1' || $_POST['finalidade']=='2' || $_POST['finalidade']=='3' || $_POST['finalidade']=='4' || $_POST['finalidade']=='5' || $_POST['finalidade']=='6' || $_POST['finalidade']=='7'){
?>    
    <tr class="fundoTabela">
      <td class=style1><b>Permuta:</b></td>
      <td class=style1><select class="campo" name="permuta" id="permuta">
          <option <? if($not2[permuta]=='Sim'){ print "SELECTED";  } ?>>Sim</option>
          <option <? if($not2[permuta]=='Não'){ print "SELECTED";  } ?>>N&atilde;o</option>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>*Texto da Permuta:</b><br>
        *Preencha esse campo apenas se voc&ecirc; escolheu a op&ccedil;&atilde;o "Sim" no campo Permuta.</td>
      <td class=style1><textarea rows="3" class="campo" name="permuta_txt" id="permuta_txt" cols="36"><?php $not2[permuta_txt] = stripslashes($not2[permuta_txt]); print("$not2[permuta_txt]"); ?></textarea></td>
    </tr>
<?
		}
	}else{
	  	if($not2[finalidade]=='1' || $not2[finalidade]=='2' || $not2[finalidade]=='3' || $not2[finalidade]=='4' || $not2[finalidade]=='5' || $not2[finalidade]=='6' || $not2[finalidade]=='7'){
?>    
    <tr class="fundoTabela">
      <td class=style1><b>Permuta:</b></td>
      <td class=style1><select class="campo" name="permuta" id="permuta">
          <option <? if($not2[permuta]=='Sim'){ print "SELECTED";  } ?>>Sim</option>
          <option <? if($not2[permuta]=='Não'){ print "SELECTED";  } ?>>N&atilde;o</option>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>*Texto da Permuta:</b><br>
        *Preencha esse campo apenas se voc&ecirc; escolheu a op&ccedil;&atilde;o "Sim" no campo Permuta.</td>
      <td class=style1><textarea rows="3" class="campo" name="permuta_txt" id="permuta_txt" cols="36"><?php $not2[permuta_txt] = stripslashes($not2[permuta_txt]); print("$not2[permuta_txt]"); ?></textarea></td>
    </tr>
<?
		}
	}
?>
    <tr class="fundoTabela">
      <td width="35%" class=style1><b>&Aacute;rea constru&iacute;da:</b></td>
      <td width="65%" class=style1> <input type="text" class="campo" name="metragem" id="metragem" size="10" value="<?php print("$not2[metragem]"); ?>"> Exemplo:
        100.00 ou 100</td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>&Aacute;rea averbada:</b></td>
      <td class=style1><input type="text" name="averbacao" id="averbacao" size="10" class="campo" value="<?php print("$not2[averbacao]"); ?>">
        Exemplo:
        100.00 ou 100</td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>&Aacute;rea do terreno: </b></td>
      <td class=style1><input name="area_terreno" type="text" id="area_terreno" size="20" class="campo" value="<?= $not2['area_terreno'] ?>"> Exemplo: 100.00 ou 100</td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>N&deg; de
        quartos:</b></td>
      <td class=style1><input type="text" class="campo" name="n_quartos" id="n_quartos" size="5" value="<?php print("$not2[n_quartos]"); ?>">
        Exemplo:
        1</td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Sendo su&iacute;te:</b></td>
      <td class=style1><input type="text" class="campo" name="suites" id="suites" size="5" value="<?php print("$not2[suites]"); ?>">
        Exemplo:
        1</td>
    </tr>
<? 
	if($_POST['finalidade']){   
		if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ 
?>
    <tr class="fundoTabela">
      <td class=style1><b>Acomoda&ccedil;&otilde;es:</b></td>
      <td class=style1><input type="text" name="acomod" id="acomod" size="2" class="campo" value="<?php print("$not2[acomod]"); ?>">
        Exemplo:
        1 ou 10</td>
    </tr>
<? 		
		}
    }else{
		if($not2[finalidade]=='15' || $not2[finalidade]=='16' || $not2[finalidade]=='17'){ 
?>	
	 <tr class="fundoTabela">
      <td class=style1><b>Acomoda&ccedil;&otilde;es:</b></td>
      <td class=style1><input type="text" name="acomod" id="acomod" size="2" class="campo" value="<?php print("$not2[acomod]"); ?>">
        Exemplo:
        1 ou 10</td>
    </tr>
<? 
		}
	}

	if($_POST['local']){
		$blitoranea = mysql_query("SELECT ci_litoranea FROM rebri_cidades WHERE ci_cod='".$_POST['local']."' AND ci_litoranea='1'");
 		while($linha = mysql_fetch_array($blitoranea)){
	     	$litoranea = $linha['ci_litoranea'];
		} 
	}else{
	  	$blitoranea = mysql_query("SELECT ci_litoranea FROM rebri_cidades WHERE ci_cod='".$not2['local']."' AND ci_litoranea='1'");
 		while($linha = mysql_fetch_array($blitoranea)){
	     	$litoranea = $linha['ci_litoranea'];
		} 
	}  
	if($litoranea=='1'){
?>
    <tr class="fundoTabela">
      <td class=style1><b>Dist&acirc;ncia do mar:</b></td>
      <td class="style1"><input name="opcao" id="opcao1" type="radio" value="1" <? if($opcao=='1'){ echo "CHECKED"; } ?> OnClick="LimpaCampo();">
        Op&ccedil;&atilde;o 1 -
        <input type="text" name="dist_mar" id="dist_mar" size="4" class="campo" value="<?php print("$dist_mar"); ?>" <? if($opcao=='2'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
        <select name="dist_tipo" id="dist_tipo" class="campo" <? if($opcao=='2'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
          <option value="metros" <? if($dist_tipo=='metros'){ echo "SELECTED"; } ?>>metros</option>
          <option value="quadras" <? if($dist_tipo=='quadras'){ echo "SELECTED"; } ?>>quadras</option>
        </select>
        <b>ou</b>
        <input name="opcao" id="opcao2" type="radio" value="2" <? if($opcao=='2'){ echo "CHECKED"; } ?> OnClick="LimpaCampo();">
        Op&ccedil;&atilde;o 2 -
        <select size="1" name="dist_mar1" id="dist_mar1" class="campo" <? if($opcao=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>
          <option value="frente para a baía" <? if($dist_mar1=='frente para a baía'){ echo "SELECTED"; } ?>>frente para a ba&iacute;a</option>
          <option value="frente para o mar" <? if($dist_mar1=='frente para o mar'){ echo "SELECTED"; } ?>>frente para o mar</option>
        </select>      </td>
    </tr>
<? } ?>
    <input type="hidden" name="cidade_litoranea" id="cidade_litoranea" value="<?=$litoranea ?>">
   <tr class="fundoTabela">
      <td colspan="2" class=style1><fieldset>
        <legend><b>Caracter&iacute;sticas</b></legend>
        <?
	    
	    if($_POST['caracteristica']){
		  $caracteristica = implode('-', $_POST['caracteristica']);
		}else{
		  $caracteristica = $not2['caracteristica'];
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
     <td class="style1"><input type="text" name="matricula" id="matricula" size="30" class="campo" value="<?php print("$not2[matricula]"); ?>">     </td>
   </tr>
       <tr class="fundoTabela">
      <td width="35%" class="style1"><b>Cidade Mat.:</b></td>
      <td width="65%" class="style1"><select name="cidade_mat" id="cidade_mat" class="campo">
      	<option value="">Selecione a Cidade</option>
       <?
 		if($_POST['acaoci']=='1'){
	        $bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$_POST['im_estado']."' ORDER BY ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidades)){
				if($linha[ci_cod]==$_POST['cidade_mat']){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
 			}
		}else{ 
			$bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$not2['uf']."' ORDER BY ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidades)){
				if($linha[ci_cod]==$not2['cidade_mat']){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
 			}
		}
	   ?>
	     </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Cartório/Oficio:</b></td>
      <td class="style1"><input type="text" name="cartorio_oficio" id="cartorio_oficio" size="50" class="campo" value="<?php if($_POST['cartorio_oficio']){ print($_POST['cartorio_oficio']); }else{ print($not2[cartorio_oficio]); } ?>"></td>
    </tr>
    
    <tr class="fundoTabela">
      <td class=style1><b>Lote:</b></td>
      <td class="style1"><input type="text" name="lote" id="lote" size="10" class="campo" value="<?php if($_POST['lote']){ print($_POST['lote']); }else{ print($not2[lote]); } ?>"></td>
    </tr>
    
    <tr class="fundoTabela">
      <td class=style1><b>Quadra:</b></td>
      <td class="style1"><input type="text" name="quadra" id="quadra" size="10" class="campo" value="<?php if($_POST['quadra']){ print($_POST['quadra']); }else{ print($not2[quadra]); } ?>"></td>
    </tr>

    <tr class="fundoTabela">
      <td class=style1><b>Planta:</b></td>
      <td class="style1"><input type="text" name="planta" id="planta" size="50" class="campo" value="<?php if($_POST['planta']){ print($_POST['planta']); }else{ print($not2[planta]); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Complemento de Contrato:</b></td>
      <td class=style1><textarea rows="5" class="campo" name="endereco_contrato" id="endereco_contrato" cols="36"><?php if($_POST['endereco_contrato']){ print($_POST['endereco_contrato']); }else{ print($not2[endereco_contrato]); } ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Matr&iacute;cula &aacute;gua: </b></td>
      <td class=style1><input name="matricula_agua" type="text" id="matricula_agua" size="20" class="campo" value="<?= $not2['matricula_agua'] ?>">
        <input name="situacao_agua" id="situacao_agua1" type="radio" value="0"  <? if($not2['situacao_luz'] == 0) { echo "checked"; } ?>>
Ligada
<input name="situacao_agua" id="situacao_agua2" type="radio" value="1" <? if($not2['situacao_luz'] == 1) { echo "checked"; } ?>>
Desligada </td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Matr&iacute;cula da luz: </b></td>
      <td class=style1><input name="matricula_luz" type="text" id="matricula_luz" class="campo" value="<?= $not2['matricula_luz'] ?>">
        <input name="situacao_luz" id="situacao_luz1" type="radio" value="0" <? if($not2['situacao_luz'] == 0) { echo "checked"; } ?>>
Ligada
<input name="situacao_luz" id="situacao_luz2" type="radio" value="1" <? if($not2['situacao_luz'] == 1) { echo "checked"; } ?>>
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
?>
    <tr class="fundoTabela">
      <td valign=top class=style1><b>Controle Chaves:</b></td>
      <td class="style1"><input type="text" name="controle_chave" id="controle_chave" size="5" class="campo" value="<? if($not2['controle_chave']==0){ echo $controle_chave; }else{ echo $not2['controle_chave'];  }  ?>"> <a href="javascript:;" onClick="MM_openBrWindow('p_controle_usado.php?menu=N','','scrollbars=yes,resizable=no,width=800,height=600')" class="style1"><b>Ver controles: usados e disponíveis</b></a></td>
    </tr>
    <tr class="fundoTabela">
      <td valign=top class=style1><b>Local Chaves:</b></td>
      <td class="style1"><textarea rows="3" name="chaves" id="chaves" cols="36" class="campo"><?php print("$not2[chaves]"); ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Zelador:</b></td>
      <td class=style1><input type="text" name="zelador" id="zelador" size="40" class="campo" value="<?php print("$not2[zelador]"); ?>"></td>
    </tr>
<? 
	if($_POST['finalidade']){   
		if($_POST['finalidade']=='15' || $_POST['finalidade']=='16' || $_POST['finalidade']=='17'){ 
?>
    <tr class="fundoTabela">
      <td width="35%" class=style1><b>Taxa Administrativa:</b></td>
      <td width="65%" class=style1><input type="text" name="limpeza" id="limpeza" size="10" class="campo" value="<?php print(number_format($not2[limpeza], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Taxa TV:</b></td>
      <td class=style1><input type="text" name="tv" id="tv" size="10" class="campo" value="<?php print(number_format($not2[tv], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Diarista:</b></td>
      <td class=style1><input type="text" name="co_diarista" id="co_diarista" size="4" class="campo2" value="<?php print("$cod_diarista"); ?>" readonly>
          <input type="text" name="nome_diarista" id="nome_diarista" size="30" class="campo" value="<?php print("$diarista"); ?>" readonly>
          <input type="button" id="selecionar4" name="selecionar4" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=3&c_campo=co_diarista&n_campo=nome_diarista', 'janela', 750, 500, 'yes');">


          <b>Valor:</b>
          <input type="text" name="comissao_diarista" id="comissao_diarista" size="10" class="campo" value="<?php print(number_format($not2[comissao_diarista], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_diarista], 2, ',', '.')); ?>&prestador=<? echo($cod_diarista); ?>&tipo_prestador=diarista';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--> </td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Piscineiro:</b></td>
      <td class=style1><input type="text" name="co_piscineiro" id="co_piscineiro" size="4" class="campo2" value="<?php print("$cod_piscineiro"); ?>" readonly>
          <input type="text" name="nome_piscineiro" id="nome_piscineiro" size="30" class="campo" value="<?php print("$piscineiro"); ?>" readonly>
          <input type="button" id="selecionar5" name="selecionar5" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=5&c_campo=co_piscineiro&n_campo=nome_piscineiro', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_piscineiro" id="comissao_piscineiro" size="10" class="campo" value="<?php print(number_format($not2[comissao_piscineiro], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_piscineiro], 2, ',', '.')); ?>&prestador=<? echo($cod_piscineiro); ?>&tipo_prestador=piscineiro';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Jardineiro:</b></td>
      <td class=style1><input type="text" name="co_jardineiro" id="co_jardineiro" size="4" class="campo2" value="<?php print("$cod_jardineiro"); ?>" readonly>
          <input type="text" name="nome_jardineiro" id="nome_jardineiro" size="30" class="campo" value="<?php print("$jardineiro"); ?>" readonly>
          <input type="button" id="selecionar6" name="selecionar6" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=4&c_campo=co_jardineiro&n_campo=nome_jardineiro', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_jardineiro" id="comissao_jardineiro" size="10" class="campo" value="<?php print(number_format($not2[comissao_jardineiro], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_jardineiro], 2, ',', '.')); ?>&prestador=<? echo($cod_jardineiro); ?>&tipo_prestador=jardineiro';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Eletricista:</b></td>
      <td class=style1><input type="text" name="co_eletricista" id="co_eletricista" size="4" class="campo2" value="<?php print("$cod_eletricista"); ?>" readonly>
          <input type="text" name="nome_eletricista" id="nome_eletricista" size="30" class="campo" value="<?php print("$eletricista"); ?>" readonly>
          <input type="button" id="selecionar7" name="selecionar7" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=1&c_campo=co_eletricista&n_campo=nome_eletricista', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_eletricista" id="comissao_eletricista" size="10" class="campo" value="<?php print(number_format($not2[comissao_eletricista], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_eletricista], 2, ',', '.')); ?>&prestador=<? echo($cod_eletricista); ?>&tipo_prestador=eletricista';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Encanador:</b></td>
      <td class=style1><input type="text" name="co_encanador" id="co_encanador" size="4" class="campo2" value="<?php print("$cod_encanador"); ?>" readonly>
          <input type="text" name="nome_encanador" id="nome_encanador" size="30" class="campo" value="<?php print("$encanador"); ?>" readonly>
          <input type="button" id="selecionar8" name="selecionar8" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=2&c_campo=co_encanador&n_campo=nome_encanador', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_encanador" id="comissao_encanador" size="10" class="campo" value="<?php print(number_format($not2[comissao_encanador], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_encanador], 2, ',', '.')); ?>&prestador=<? echo($cod_encanador); ?>&tipo_prestador=encanador';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
<? 		
		} 
    }else{
		if($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
?>
		    <tr class="fundoTabela">
      <td width="35%" class=style1><b>Taxa Administrativa:</b></td>
      <td width="65%" class=style1><input type="text" name="limpeza" id="limpeza" size="10" class="campo" value="<?php print(number_format($not2[limpeza], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Taxa TV:</b></td>
      <td class=style1><input type="text" name="tv" id="tv" size="10" class="campo" value="<?php print(number_format($not2[tv], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Diarista:</b></td>
      <td class=style1><input type="text" name="co_diarista" id="co_diarista" size="4" class="campo2" value="<?php print("$cod_diarista"); ?>" readonly>
          <input type="text" name="nome_diarista" id="nome_diarista" size="30" class="campo" value="<?php print("$diarista"); ?>" readonly>
          <input type="button" id="selecionar4" name="selecionar4" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=3&c_campo=co_diarista&n_campo=nome_diarista', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_diarista" id="comissao_diarista" size="10" class="campo" value="<?php print(number_format($not2[comissao_diarista], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_diarista], 2, ',', '.')); ?>&prestador=<? echo($cod_diarista); ?>&tipo_prestador=diarista';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--> </td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Piscineiro:</b></td>
      <td class=style1><input type="text" name="co_piscineiro" id="co_piscineiro" size="4" class="campo2" value="<?php print("$cod_piscineiro"); ?>" readonly>
          <input type="text" name="nome_piscineiro" id="nome_piscineiro" size="30" class="campo" value="<?php print("$piscineiro"); ?>" readonly>
          <input type="button" id="selecionar5" name="selecionar5" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=5&c_campo=co_piscineiro&n_campo=nome_piscineiro', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_piscineiro" id="comissao_piscineiro" size="10" class="campo" value="<?php print(number_format($not2[comissao_piscineiro], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_piscineiro], 2, ',', '.')); ?>&prestador=<? echo($cod_piscineiro); ?>&tipo_prestador=piscineiro';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Jardineiro:</b></td>
      <td class=style1><input type="text" name="co_jardineiro" id="co_jardineiro" size="4" class="campo2" value="<?php print("$cod_jardineiro"); ?>" readonly>
          <input type="text" name="nome_jardineiro" id="nome_jardineiro" size="30" class="campo" value="<?php print("$jardineiro"); ?>" readonly>
          <input type="button" id="selecionar6" name="selecionar6" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=4&c_campo=co_jardineiro&n_campo=nome_jardineiro', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_jardineiro" id="comissao_jardineiro" size="10" class="campo" value="<?php print(number_format($not2[comissao_jardineiro], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_jardineiro], 2, ',', '.')); ?>&prestador=<? echo($cod_jardineiro); ?>&tipo_prestador=jardineiro';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Eletricista:</b></td>
      <td class=style1><input type="text" name="co_eletricista" id="co_eletricista" size="4" class="campo2" value="<?php print("$cod_eletricista"); ?>" readonly>
          <input type="text" name="nome_eletricista" id="nome_eletricista" size="30" class="campo" value="<?php print("$eletricista"); ?>" readonly>
          <input type="button" id="selecionar7" name="selecionar7" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=1&c_campo=co_eletricista&n_campo=nome_eletricista', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_eletricista" id="comissao_eletricista" size="10" class="campo" value="<?php print(number_format($not2[comissao_eletricista], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_eletricista], 2, ',', '.')); ?>&prestador=<? echo($cod_eletricista); ?>&tipo_prestador=eletricista';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Encanador:</b></td>
      <td class=style1><input type="text" name="co_encanador" id="co_encanador" size="4" class="campo2" value="<?php print("$cod_encanador"); ?>" readonly>
          <input type="text" name="nome_encanador" id="nome_encanador" size="30" class="campo" value="<?php print("$encanador"); ?>" readonly>
          <input type="button" id="selecionar8" name="selecionar8" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=5&p_cod=2&c_campo=co_encanador&n_campo=nome_encanador', 'janela', 750, 500, 'yes');">
          <b>Valor:</b>
          <input type="text" name="comissao_encanador" id="comissao_encanador" size="10" class="campo" value="<?php print(number_format($not2[comissao_encanador], 2, ',', '.')); ?>" onKeydown="Formata(this,20,event,2)">
          <!--b><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='solicitacao_servicos.php?cod=<?php echo($not2[cod]); ?>&valor_servico=<? echo(number_format($not2[comissao_encanador], 2, ',', '.')); ?>&prestador=<? echo($cod_encanador); ?>&tipo_prestador=encanador';form1.submit();" class=style1>Solicita&ccedil;&atilde;o de Servi&ccedil;os </a></b--></td>
    </tr>
<? 
		}
	}
?>
    <tr class="fundoTabela">
      <td class=style1><b>Angariador:</b></td>
      <td class=style1><select name="angariador" id="angariador" class="campo">
      <option value="0">Selecione</option>
          <?
            if($_POST['angariador']){
				$angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$_POST['angariador']){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}else{ 			   
						echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
					}
 				}
 			}else{
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
					//}else{ 			   
						//echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
					}
 				}
			  }	
			}
 		/*}else{
 		    if($_POST['angariador']){ 
		    	$angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$_POST['angariador']){
						echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
					}
 				}
 			}else{
			    $angariadores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 				while($linha = mysql_fetch_array($angariadores)){
					if($linha[u_cod]==$angariador){
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
          <input type="text" name="tipo_anga" id="tipo_anga" size="2" class="campo" value="<? if($_POST['tipo_anga']){ echo($_POST['tipo_anga']); }elseif($not2[tipo_anga]){ echo($not2[tipo_anga]); }else{ echo($comissao_angariador); } ?>"> %
          <? }else{ ?>
          <input type="hidden" name="tipo_anga" id="tipo_anga" size="2" class="campo" value="<? echo($comissao_angariador); ?>">
          <? } ?>      </td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Indicador:</b></td>
      <td class=style1><input type="text" name="co_cliente2" id="co_cliente2" size="4" class="campo2" value="<?php print("$cod_indicador"); ?>" readonly>
          <input type="text" name="nome_cliente2" id="nome_cliente2" size="40" class="campo" value="<?php print("$indicador"); ?>" readonly>
          <input type="button" id="selecionar3" name="selecionar3" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=form1&t_cod=2&c_campo=co_cliente2&n_campo=nome_cliente2', 'janela', 750, 500, 'yes');">
		  <? if (verificaFuncao("GERAL_COMISSAO")) { // verifica se pode acessar as areas ?>
               <b>Comiss&atilde;o:</b>
			   <input type="text" name="comissao_indicador" id="comissao_indicador" size="2" class="campo" value="<? if($_POST['comissao_indicador']){ echo($_POST['comissao_indicador']); }elseif($not2[comissao_indicador]){ echo($not2[comissao_indicador]); }else{ echo($comissao_indicador); } ?>"> %
          <? }else{ ?>
               <input type="hidden" name="comissao_indicador" id="comissao_indicador" size="2" class="campo" value="<? echo($comissao_indicador); ?>"> 
          <? } ?>      </td>
    </tr>
    <? if (verificaFuncao("GERAL_COMISSAO")) { // verifica se pode acessar as areas ?> 
    <tr class="fundoTabela">
      <td class=style1><b>Comiss&atilde;o Vendedor:</b></td>
      <td class=style1><input type="text" name="comissao_vendedor" id="comissao_vendedor" size="2" class="campo" value="<? if($_POST['comissao_vendedor']){ echo($_POST['comissao_vendedor']); }elseif($not2[comissao_vendedor]){ echo($not2[comissao_vendedor]); }else{ echo($comissao_vendedor); } ?>"> %
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
	 
	 /*
	 $queryv1 = mysql_query("SELECT disponibilizar FROM muraski WHERE cod='".$cod."' and data_fim < now() and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
     $numrowsv1 = mysql_num_rows($queryv1);
     if($numrowsv1 > 0){
       while($row3 = mysql_fetch_array($queryv1)){
         if($row3['disponibilizar']=='1'){
         	$mensagem = "<span class=\"style7\"><br><b>Contrato está vencido!</b><br>Para que esse imóvel volte a aparecer no site é preciso alterar a data final do contrato para uma data maior ou igual a data atual!</span>";
         }
       }  
     }
     */
	 

if($disponibilizar_im<>'0' || $disponibilizar_padrao<>'N'){
?>    
	<tr class="fundoTabela">
      <td class=style1><b>Disponibilizar no site:</b></td>
      <td class="style1"><input name="disponibilizar" id="disponibilizar2" type="radio" value="0"  <? if($disponibilizar=='0'){ print "checked"; } ?>>
        N&atilde;o
		<input name="disponibilizar" type="radio" id="disponibilizar1" value="1" <? if($disponibilizar=='1'){ print "checked"; } ?>>
        Sim</td>
    </tr>
<?
}
?>
    <tr class="fundoTabela">
      <td class=style1><b>Disponibilizar p/ parceria na rede:</b></td>
      <td class="style1"><input name="disp_rede" type="radio" id="disp_rede1" value="0" <? if($disp_rede=='0'){ print "checked"; } ?> OnClick="TravaCampo2();">
        N&atilde;o
		<input name="disp_rede" id="disp_rede2" type="radio" value="1"  <? if($disp_rede=='1'){ print "checked"; } ?> OnClick="TravaCampo2();">
        Sim</td>
    </tr>
	<tr class="fundoTabela">
      <td class=style1><b>Comiss&atilde;o oferecida p/ parceria:</b></td>
      <td class="style1"><table cellpadding="0" cellspacing="0" border="0">
      <tr><td><input type="hidden" name="bcom" value="0">
	  <select name="comissao_parceria" id="comissao_parceria" class="campo" onchange="mostraCampos();" <? if($disp_rede=='0'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>>     
          <option value="0">Selecione</option>
          <option value="30" <? if($comissao_parceria=='30'){ echo "SELECTED"; } ?>>30%</option>
		  <option value="40" <? if($comissao_parceria=='40'){ echo "SELECTED"; } ?>>40%</option>
		  <option value="50" <? if($comissao_parceria=='50'){ echo "SELECTED"; } ?>>50%</option>
		  <option value="diferenciado" <? if($comissao_parceria=='diferenciado'){ echo "SELECTED"; } ?>>Diferenciado</option>
        </select></td>
	<? //if($comissao_parceria=='diferenciado'){ ?>
		<td><input type="text" name="comissao_diferenciado" id="comissao_diferenciado" size="2" class="campo" value="<?=$comissao_diferenciado; ?>" <? if($comissao_parceria=='diferenciado'){ ?> style="display:block;" <? }else{ ?> style="display:none;" <? } ?> <? if($disp_rede=='0'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>></td></tr></table></td>
	<? //} ?>
    </tr>
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

    //if($totald >= $quantidade && $not2['destaque']=='0'){
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
    <? if($_SESSION['im_site_padrao']=='S'){ ?>
	 <tr class="fundoTabela">
      <td class=style1><b>Destaque no site padrão:</b><br />
        <span class="style7">Obs: Se o imóvel não possuir foto e estiver como destaque, ele não será exibido no site padr&atilde;o.</span></td>
      <td class="style1"><input name="destaque_padrao" id="destaque_pd1" type="radio" value="0"  <? if($destaque_padrao=='0'){ print "CHECKED"; } ?> checked> N&atilde;o
        <input name="destaque_padrao" type="radio" id="destaque_pd2" value="1" <? if($destaque_padrao=='1'){ print "CHECKED"; } ?>> Sim</td>
    </tr>
	 <tr class="fundoTabela">
      <td class=style1><b>Lançamento:</b><br /></td>
      <td class="style1"><input name="lancamento" id="lancamento1" type="radio" value="0"  <? if($lancamento<>'1'){ print "CHECKED"; } ?> checked> N&atilde;o
        <input name="lancamento" type="radio" id="lancamento2" value="1" <? if ($lancamento=='1') { print "CHECKED"; } ?>> Sim</td>
    </tr>
    <? }
    if($finalidade == 15 ||$finalidade == 16 || $finalidade == 17 || $_POST['finalidade'] == 15 || $_POST['finalidade'] == 16 || $_POST['finalidade'] == 17)
	{
	?>
	<tr class="fundoTabela">
      <td class=style1><b>Exibir calendário no site da rebri e no site padrão:</b></td>
      <td class="style1"><input name="calendario" type="radio" id="calendario1" value="0" <? if($calendario <> 1){ echo 'checked="checked"'; } ?>>
        N&atilde;o
		<input name="calendario" id="calendario2" type="radio" value="1" <? if($calendario == 1){ echo 'checked="checked"'; } ?>>
        Sim</td>
	</tr>
<?php
   }
?>
    <tr class="fundoTabela">
      <td class=style1><b>Observações 01 (Visíveis através do ícone de observações do sistema):</b></td>
      <td class=style1><textarea rows="5" class="campo" name="observacoes" id="observacoes" cols="36"><?php $not2[observacoes] = stripslashes($not2[observacoes]); print("$not2[observacoes]"); ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Observações 02 (Complemento do titulo do imóvel visível no portal, site e sistema):</b></td>
      <td class=style1><textarea rows="5" class="campo" name="observacoes2" id="observacoes2" cols="36"><?php $not2[observacoes2] = stripslashes($not2[observacoes2]); print("$not2[observacoes2]"); ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Observações 03 (Complemento de informações adicionais sobre o imóvel sempre visível, apenas no sistema):</b></td>
      <td class=style1><textarea rows="5" class="campo" name="observacoes3" id="observacoes3" cols="36"><?php $not2[observacoes3] = stripslashes($not2[observacoes3]); print("$not2[observacoes3]"); ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Rela&ccedil;&atilde;o de bens:</b></td>
      <td class=style1><textarea rows="5" class="campo" name="relacao_bens" id="relacao_bens" cols="36"><?php $not2[relacao_bens] = stripslashes($not2[relacao_bens]); print("$not2[relacao_bens]"); ?></textarea></td>
    </tr>
<!--
   Colocar data da relação de bens AQUI
    <tr class="fundoTabela">
      <td class=style1><b>Data da Relação de bens:</b></td>
      <td class=style1>
        <input onclick="displayCalendar(document.getElementById('f_dtbens'),'dd/mm/yyyy',this);"
         size="12" maxlength="12" name="f_dtbens" id="f_dtbens" type="text" class="campo" /></td>
    </tr>

-->
<?php
if($_POST['acao']=='1'){
  	$anob = $_POST['anob'];
	$mesb = $_POST['mesb'];
	$diab = $_POST['diab'];
}else{
	$anob = substr ($not2[data_bens], 0, 4);
	$mesb = substr($not2[data_bens], 5, 2 );
	$diab = substr ($not2[data_bens], 8, 2 );
}
?>
    <tr class="fundoTabela">
      <td width="35%" class=style1><b>Data da Relação de bens:</b></td>
      <td width="65%" class=style1>
      <input type="text" name="diab" id="diab" value="<?php if($_POST['diab']){ print($_POST['diab']); }else{ print($diab); } ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mesb" id="mesb" value="<?php if($_POST['mesb']){ print($_POST['mesb']); }else{ print($mesb); } ?>" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="anob" id="anob" value="<?php if($_POST['anob']){ print($_POST['anob']); }else{ print($anob); } ?>" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);">
      <br> Ex.: 10/10/1910</td>

    <!--tr class="fundoTabela">
      <td width="23%" class=style1><b>Especificação:</b></td>
      <td width="77%" class=style1><select class="campo" name="especificacao">
    <option selected><?php //print("$not2[especificacao]"); ?></option>
    <option>Lançamento</option>
    <option>Novo</option>
    <option>Semi-Novo</option>
    <option>Usado</option>
        </select></td>
    </tr-->
    <tr class="fundoTabela">
      <td class=style1><b>Código Vídeo:</b><br>
      * Veja as explica&ccedil;&otilde;es clicando <a href="explicacoes_videos.htm" target="_blank">aqui</a>. </td>
      <td class=style1><input class="campo" type="text" name="video" id="video" size="15" value="<?=$not2[video]; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>Origem do Vídeo:</b></td>
      <td class=style1><select name="origem_video" id="origem_video" class="campo">
      	<option value="">Selecione</option>
		<option value="Globo" <? if($not2[origem_video] == "Globo"){ print "SELECTED"; } ?>>Globo</option>
      	<option value="Youtube" <? if($not2[origem_video] == "Youtube"){ print "SELECTED"; } ?>>Youtube</option>
      	<option value="Blip" <? if($not2[origem_video] == "Blip"){ print "SELECTED"; } ?>>Blip</option>
	 </select></td>
    </tr>
    <!--tr class="fundoTabela">
      <td width="23%" class=style1><b>Posição X:</b></td>
      <td width="77%" class=style1><input type="text" name="posx" value="<?php //print("$not2[posx]"); ?>" class="campo" size=10></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Posição Y:</b></td>
      <td width="77%" class=style1><input type="text" name="posy" value="<?php //print("$not2[posy]"); ?>" class="campo" size=10></td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="23%" class=style1><b>Piscina:</b></td>
      <td width="77%" class=style1><select class="campo" name="piscina">
    <option selected><?php// print("$not2[piscina]"); ?></option>
    <option>Não</option>
    <option>Sim</option>
        </select></td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="23%" class=style1><b>Localização:</b></td>
      <td width="77%" class="style1"><input type="text" name="local" class="campo" size="30" value="<?php //print("$not2[local]"); ?>"></td>
    </tr--> 
    <!--tr class="fundoTabela">
      <td width="23%" class=style1><b>Cidade Mat.:</b></td>
      <td width="77%" class="style1"><select size="1" name="cidade_mat" class="campo">
      <option selected><?php //print("$not2[cidade_mat]"); ?></option>
    <option>Guaratuba</option>
    <option>São José dos Pinhais</option>
        </select></td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="23%" class=style1><b>Tipo Divulgação:</b></td>
      <td width="77%" class=style1><input type="text" name="tipo_div" size="40" class="campo" value="<?php //print("$not2[tipo_div]"); ?>"></td>
    </tr-->
    <!--tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 1:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_1" size="30" value="<?php
      //$not2[ftxt_1] = stripslashes($not2[ftxt_1]); print("$not2[ftxt_1]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 2:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_2" size="30" value="<?php
      //$not2[ftxt_2] = stripslashes($not2[ftxt_2]); print("$not2[ftxt_2]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 3:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_3" size="30" value="<?php
      //$not2[ftxt_3] = stripslashes($not2[ftxt_3]); print("$not2[ftxt_3]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 4:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_4" size="30" value="<?php
      //$not2[ftxt_4] = stripslashes($not2[ftxt_4]); print("$not2[ftxt_4]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 5:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_5" size="30" value="<?php
      //$not2[ftxt_5] = stripslashes($not2[ftxt_5]); print("$not2[ftxt_5]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 6:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_6" size="30" value="<?php
      //$not2[ftxt_6] = stripslashes($not2[ftxt_6]); print("$not2[ftxt_6]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 7:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_7" size="30" value="<?php
      //$not2[ftxt_7] = stripslashes($not2[ftxt_7]); print("$not2[ftxt_7]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 8:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_8" size="30" value="<?php
      //$not2[ftxt_8] = stripslashes($not2[ftxt_8]); print("$not2[ftxt_8]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 9:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_9" size="30" value="<?php
      //$not2[ftxt_9] = stripslashes($not2[ftxt_9]); print("$not2[ftxt_9]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 10:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_10" size="30" value="<?php
      //$not2[ftxt_10] = stripslashes($not2[ftxt_10]); print("$not2[ftxt_10]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 11:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_11" size="30" value="<?php
      //$not2[ftxt_11] = stripslashes($not2[ftxt_11]); print("$not2[ftxt_11]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 12:</b></td>
      <td width="77%" class=style12><input type="text" class="campo" name="ftxt_12" size="30" value="<?php
      //$not2[ftxt_12] = stripslashes($not2[ftxt_12]); print("$not2[ftxt_12]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 13:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_13" size="30" value="<?php
      //$not2[ftxt_13] = stripslashes($not2[ftxt_13]); print("$not2[ftxt_13]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 14:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_14" size="30" value="<?php
      //$not2[ftxt_14] = stripslashes($not2[ftxt_14]); print("$not2[ftxt_14]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 15:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_15" size="30" value="<?php
      //$not2[ftxt_15] = stripslashes($not2[ftxt_15]); print("$not2[ftxt_15]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 16:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_16" size="30" value="<?php
      //$not2[ftxt_16] = stripslashes($not2[ftxt_16]); print("$not2[ftxt_16]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 17:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_17" size="30" value="<?php
      //$not2[ftxt_17] = stripslashes($not2[ftxt_17]); print("$not2[ftxt_17]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 18:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_18" size="30" value="<?php
      //$not2[ftxt_18] = stripslashes($not2[ftxt_18]); print("$not2[ftxt_18]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 19:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_19" size="30" value="<?php
      //$not2[ftxt_19] = stripslashes($not2[ftxt_19]); print("$not2[ftxt_19]");
      ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="23%" class=style1><b>Texto da foto 20:</b></td>
      <td width="77%" class=style1><input type="text" class="campo" name="ftxt_20" size="30" value="<?php
      //$not2[ftxt_20] = stripslashes($not2[ftxt_20]); print("$not2[ftxt_20]");
      ?>"></td>
    </tr-->
    <tr class="fundoTabela">
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td colspan="4" class="style1"><b>&Uacute;ltimas três atualiza&ccedil;&otilde;es</b></td>
        </tr>
        <tr class="fundoTabelaTitulo">
          <td width="15%" class="style1"><b>Data</b></td>
          <td width="17%" class="style1"><b>Hora</b></td>
		  <td width="32%" class="style1"><b>Ação</b></td>
          <td width="36%" class="style1"><b>Usuário</b></td>
        </tr>
		<?
		$i = 0;
		$busca_usuarios = mysql_query("SELECT t1.a_cod_user, t1.a_imovel, t1.a_acao, t1.a_data, t1.a_hora, t3.u_nome FROM atualizacoes t1, usuarios t3 WHERE t1.a_cod_user = t3.u_cod and t1.a_imovel = '".$cod."' and t1.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id DESC LIMIT 0,3");
		while($linha = mysql_fetch_array($busca_usuarios))
		{
			if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
			$i++;


		$d = explode("-",$linha['a_data']);
		$data = $d[2]."/".$d[1]."/".$d[0];

		echo " <tr class=\"$fundo\"><td width=\"15%\" class=\"style1\">".$data."</td>
	        <td width=\"17%\" class=\"style1\">".$linha['a_hora']."</td>
 			  <td width=\"32%\" class=\"style1\">".$linha['a_acao']."</td>
           <td width=\"36%\" class=\"style1\">".$linha['u_nome']."</td></tr>	";
		}
?>

      </table></td>
    </tr>
    <tr class="fundoTabela">
      <td colspan="2">
      <input type="hidden" value="1" name="editar">
      <input type="hidden" name="cod" value="<?php print("$not2[cod]"); ?>">
      <input type="hidden" name="u_cod" value="<?=$u_cod ?>">
      <input type="hidden" name="altera" id="altera" value="0">
      <input type="hidden" name="apaga_imovel" id="apaga_imovel" value="0">
      <input type="hidden" name="apaga_imovel_definitivamente" id="apaga_imovel_definitivamente" value="0">
      <input type="button" value="Atualizar Imóvel" class="campo3" name="B1" Onclick="VerificaCampo(<? echo($not2[cod]); ?>)">
      <input type="button" value="Apagar Imóvel" class=campo3 name="B1" onClick="javascript:confirmaExclusao2();">
      <input type="button" value="Apagar Definitivamente" name="B1" class=campo3 onClick="javascript:confirmaExclusao();"></td>
    </tr>
</table>
</form>
  <br>
<?php
	}
/*
mysql_free_result($result0);
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
