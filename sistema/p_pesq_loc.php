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
verificaArea("GERAL_LOCA");
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
<script language="javascript">
function LimpaCampo(){

  if(document.getElementById('comp4').value=='frente para o mar' || document.getElementById('comp4').value=='frente para a baía')
  {
	document.form1.dist_mar.disabled = true;
    document.form1.dist_mar.style.background = '#D6D6D6';
  }
  else 
  {	
    document.form1.dist_mar.disabled = false;
    document.form1.dist_mar.style.background = '#FFFFFF'; 
  }
}

function valida()
{

  if(document.form1.calendario.checked==0){
   
  if (document.form1.dia.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.form1.dia.focus();
    return (false);
  }
  if (document.form1.mes.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.form1.mes.focus();
    return (false);
  }
  if (document.form1.ano.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.form1.ano.focus();
    return (false);
  }
  if (document.form1.dia1.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.form1.dia1.focus();
    return (false);
  }
  if (document.form1.mes1.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.form1.mes1.focus();
    return (false);
  }
  if (document.form1.ano1.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.form1.ano1.focus();
    return (false);
  }
  
  var data1 = document.form1.ano.value + document.form1.mes.value + document.form1.dia.value;
  var data2 = document.form1.ano1.value + document.form1.mes1.value + document.form1.dia1.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	document.form1.dia.focus();
	return(false);
  }
} 
	return(true);
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



function seleciona_opcao_neutra(){
  if(document.getElementById('opcao_neutra').checked){
	document.getElementById('opcao_com').checked = false;
	document.getElementById('opcao_sem').checked = false;
    document.getElementById('opcao_sem').value = '0';
    document.getElementById('opcao_com').value = '0';
    document.getElementById('opcao_neutra').value = '1';
  }
}
function seleciona_opcao_com(){
  if(document.getElementById('opcao_com').checked){
    document.getElementById('opcao_sem').checked = false
    document.getElementById('opcao_neutra').checked = false;
    document.getElementById('opcao_sem').value = '0';
    document.getElementById('opcao_com').value = '1';
    document.getElementById('opcao_neutra').value = '0';
  }
}
function seleciona_opcao_sem(){
  if(document.getElementById('opcao_sem').checked){
    document.getElementById('opcao_neutra').checked = false;
    document.getElementById('opcao_com').checked = false;
    document.getElementById('opcao_sem').value = '1';
    document.getElementById('opcao_com').value = '0';
    document.getElementById('opcao_neutra').value = '0';
  }
}
function seleciona_opcao_7dias(){
  if(document.getElementById('opcao_7dias').checked){
    document.getElementById('opcao_7dias').checked = true;
    document.getElementById('opcao_7dias').value = '1';
  }else{
    document.getElementById('opcao_7dias').checked = false;
    document.getElementById('opcao_7dias').value = '0';
  }
}

</script>
<script type="text/javascript" src="funcoes/js.js"></script>
<?php
	if(!(session_is_registered("ano")))
	{
	//$ano = date(Y);
	/*
	if(date(m) > 8){
	$ano1 = $ano + 1;
	}
	else
	{
	$ano1 = $ano;
	}
	*/
	}
	
?>
<div align="center">
  <center>
  <form method="get" action="p_lista_loc.php" name="form1" onSubmit="return valida();seleciona_opcao_7dias();">
  <table border="0" cellspacing="1" width="75%">
    <tr height="50">
      <td width="100%" colspan=2 align="center" class=style1><b>Imóveis p/ Locação <!--Diária-->Temporada</b><br>
 Preencha os campos do seu interesse e clique em pesquisar.</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Período:</b></td>
      <td width="70%" class=style1> 
      <input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['dia']){ print($_GET['dia']); }else{ print("$dia"); } ?>">/<input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['mes']){ print($_GET['mes']); }else{ print("$mes"); } ?>">/<input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php if($_GET['ano']){ print($_GET['ano']); }else{ print("$ano"); } ?>"> <b>à</b> <input type="text" name="dia1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['dia1']){ print($_GET['dia1']); }else{ print("$dia1"); } ?>">/<input type="text" name="mes1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($_GET['mes1']){ print($_GET['mes1']); }else{ print("$mes1"); } ?>">/<input type="text" name="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php if($_GET['ano1']){ print($_GET['ano1']); }else{ print("$ano1"); } ?>"><br>Ex.: 
    10/10/1910 à 20/10/1910</td>
    </tr>
<?php
	unset($_SESSION['dia']);
	unset($_SESSION['mes']);
	unset($_SESSION['ano']);
	unset($_SESSION['dia1']);
	unset($_SESSION['mes1']);
	unset($_SESSION['ano1']);
?>
     <tr class="fundoTabela">
       <td class="style1"><b>Busca Per&iacute;odo:</b></td>
       <td class="style1"><input name="calendario" type="checkbox" id="calendario" value="1" <? if($calendario=='1'){ print "CHECKED"; } ?>> 
         Neutralizar calend&aacute;rio	   </td>
     </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Finalidade:</b></td>
      <td width="70%" class=style1> <select name="finalidade" class="campo" onChange="form1.action='p_pesq_loc.php';form1.acaob.value='1';form1.acaoci.value='1';form1.submit();">
      	 <?php
      $sqlfinalidade = "select f_cod, f_nome FROM finalidade WHERE f_nome LIKE 'Locação_Temporada%' ORDER BY f_cod ASC";
		$bfinalidade = mysql_query($sqlfinalidade);
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
 	?> 
      	
      	
<?php
//include("finalidade.php");
?>
    <!--option value="Vend%" <?// if($finalidade=='Vend%'){ echo "SELECTED"; }?>>Venda_Todos</option>
    <option value="Locação%" <?// if($finalidade=='Locação%'){ echo "SELECTED"; }?>>Locação_Todos</option-->
      </select></td>
    </tr> 
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Tipo de imóvel:</b></td>
      <td width="70%" class=style1> <select name="tipo1" class="campo">
    <option selected value="%" <? if($tipo1=='%'){ echo "SELECTED"; }?>>Todos</option>
    <?
    		$btipo = mysql_query("SELECT t_cod, t_nome FROM rebri_tipo ORDER BY t_nome ASC");
 			while($linha = mysql_fetch_array($btipo)){
				if($linha[t_cod]==$tipo1){
 		     		echo('<option value="'.$linha[t_cod].'" SELECTED>'.$linha['t_nome'].'</option>'); 
		   		}else{
		     		echo('<option value="'.$linha[t_cod].'">'.$linha['t_nome'].'</option>'); 
		   		}
			}
		?>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>&Aacute;rea Averbada:</b></td>
      <td class=style1><input name="b_averbada" type="checkbox" id="b_averbada" value="1" <? if($b_averbada=='1'){ print "CHECKED"; } ?>>
        Im&oacute;veis com &aacute;rea averbada </td>
    </tr>

    <tr class="fundoTabela">
      <td class=style1><b>Situação da Locação : </b></td>
      <td class="style1">
        <input name="opcao_neutra" id="opcao_neutra" type="radio" value="0" OnClick="seleciona_opcao_neutra()">
        Neutralizar essas Opções
        <input name="opcao_sem" id="opcao_sem" type="radio" value="0" OnClick="seleciona_opcao_sem()">
        SEM Op&ccedil;&atilde;o assinada
        <input name="opcao_com" id="opcao_com" type="radio" value="1" <? echo "CHECKED"; ?> OnClick="seleciona_opcao_com()">
        COM Op&ccedil;&atilde;o assinada
      </td>
    </tr>

    <tr class="fundoTabela">
      <td class=style1><b>Pacotes de Locação : </b></td>
      <td class="style1">
        <input name="opcao_7dias" id="opcao_7dias" type="checkbox" value="1" <? if($opcao_7dias=='1'){ print "CHECKED"; }?> OnClick="seleciona_opcao_7dias()">
         Se marcado seleciona somente imovéis no Pacote de 07 Dias de Locação
      </td>
    </tr>

    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Referência:</b></td>
      <td width="70%" class=style1> <input type="text" name="ref" size="10" class="campo" value="<?=$ref; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>N° de
        quartos:</b></td>
      <td width="70%" class=style1><select name="comp1" class="campo">
    <option selected value="like" <? if($comp1=='like'){ echo "SELECTED"; }?>>Igual a</option>
    <option value=">" <? if($comp1=='>'){ echo "SELECTED"; }?>>Maior que</option>
    <option value="<" <? if($comp1=='<'){ echo "SELECTED"; }?>>Menor que</option>
      </select> <input type="text" name="n_quartos" size="5" class="campo" value="<?=$n_quartos; ?>"> Exemplo:
        1</td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Diária:</b></td>
      <td width="70%" class=style1><select name="comp2" class="campo">
    <option selected value="like" <? if($comp2=='like'){ echo "SELECTED"; }?>>Igual a</option>
    <option value=">" <? if($comp2=='>'){ echo "SELECTED"; }?>>Maior que</option>
    <option value="<" <? if($comp2=='<'){ echo "SELECTED"; }?>>Menor que</option>
      </select> <input type="text" name="valor" size="10" class="campo" value="<?=$valor; ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Endereço:</b></td>
      <td width="70%" class="style1"><select name="tipo_logradouro" id="tipo_logradouro" class="campo">
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
      <input type="text" name="end" size="40" class="campo" value="<?=$end; ?>"> 
      N&deg;: 
      <input type="text" name="numero_end" id="numero_end" size="5" class="campo" value="<?=$numero_end; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class=style1><b>CEP:</b></td>
      <td class=style1><input name="cep" type="text" class="campo" id="cep" value="<?=$cep; ?>" size="8" maxlength="8">
Exemplo: 80000000 </td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class=style1><b>Acomodações:</b></td>
      <td width="80%" class=style1><select name="comp3" class="campo">
    <option selected value="like" <? if($comp3=='like'){ echo "SELECTED"; }?>>Igual a</option>
    <option value=">" <? if($comp3=='>'){ echo "SELECTED"; }?>>Maior que</option>
    <option value="<" <? if($comp3=='<'){ echo "SELECTED"; }?>>Menor que</option>
      </select> <input type="text" name="acomod" size="2" class="campo" value="<?=$acomod; ?>"> Exemplo:
        1 ou 10</td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Ordenar por:</b></td>
      <td width="70%" class=style1> <select name="ordem" class="campo">
    <option selected value="tipo" <? if($ordem=='tipo'){ echo "SELECTED"; }?>>Tipo</option>
    <option value="ref" <? if($ordem=='ref'){ echo "SELECTED"; }?>>Ref</option>
    <option value="ultimos_cadastros" <? if($ordem=='ultimos_cadastros'){ echo "SELECTED"; }?>>Últimos Cadastros</option>
    <option value="valor_crescente" <? if($ordem=='valor_crescente'){ echo "SELECTED"; }?>>Valor Crescente</option>
    <option value="valor_decrescente" <? if($ordem=='valor_decrescente'){ echo "SELECTED"; }?>>Valor Decrescente</option>
    <option value="metragem" <? if($ordem=='metragem'){ echo "SELECTED"; }?>>Metragem</option>
    <option value="quartos" <? if($ordem=='quartos'){ echo "SELECTED"; }?>>Quartos</option>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Relação de bens:</b></td>
      <td width="70%" class="style1"><input type="text" name="relacao_bens" size="40" class="campo" value="<?=$relacao_bens; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Estado:</b></td>
      <td class="style1"><input type="hidden" name="acaoci" id="acaoci" value="0">
	  <select name="im_estado" class="campo" onChange="form1.action='p_pesq_loc.php';form1.acaoci.value='1';form1.submit();">
        <option value="0">Selecione o Estado</option>
          <?
          	if($_GET['im_estado']){
		    	$estado = $_GET['im_estado'];
		    }else{
			  	$estado = $_SESSION['cod_estadoi'];
			}
          
        if($_SESSION['cod_estadoi'] && empty($_GET['im_estado'])){ 
          
			$bestados = mysql_query("SELECT e.e_cod, e.e_uf FROM rebri_estados e INNER JOIN muraski m ON (m.uf=e.e_cod) WHERE m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND m.finalidade='15' AND m.ref!='x' GROUP BY e.e_uf ORDER BY e.e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$estado){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
 			}
 		}else{
 		  
 		  	if($_GET['finalidade']=='17'){
			    $query_finalidades = " (m.finalidade='15' OR m.finalidade='16' OR m.finalidade='17') AND ";
			}else{
			  	$query_finalidades = " m.finalidade='".$_GET['finalidade']."' AND ";
			}
 		  
	        $bestados = mysql_query("SELECT e.e_cod, e.e_uf FROM rebri_estados e INNER JOIN muraski m ON (m.uf=e.e_cod) WHERE m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND $query_finalidades m.ref!='x' GROUP BY e.e_uf ORDER BY e.e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$estado){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
 			}
		}	
        ?>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Localiza&ccedil;&atilde;o:</b></td>
      <td class="style1"><input type="hidden" name="acaob" id="acaob" value="0">
	  <select name="local" class="campo" onChange="form1.action='p_pesq_loc.php';form1.acaob.value='1';form1.acaoci.value='1';form1.submit();">
        <option value="0">Selecione a Cidade</option>
       <?
       		if($_GET['im_estado']){
		    	$estado = $_GET['im_estado'];
		    }else{
			  	$estado = $_SESSION['cod_estadoi'];
			}
       
 		if($_GET['acaoci']=='1'){
 		  
 		  	if($_GET['finalidade']=='17'){
			    $query_finalidades = " (m.finalidade='15' OR m.finalidade='16' OR m.finalidade='17') AND ";
			}else{
			  	$query_finalidades = " m.finalidade='".$_GET['finalidade']."' AND ";
			}
 		  
	        $bcidades = mysql_query("SELECT c.ci_cod, c.ci_nome, m.disponibilizar, m.local FROM rebri_cidades c INNER JOIN muraski m ON (m.local=c.ci_cod) WHERE m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND c.ci_estado='".$estado."' AND $query_finalidades m.ref!='x' GROUP BY c.ci_nome ORDER BY c.ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidades)){
				if($linha[ci_cod]==$local){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
			   	}elseif($linha[ci_cod]==$_SESSION['cod_cidadei'] && empty($_GET['local'])){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
			   	}elseif($linha[ci_cod]==$linha['local'] && $linha['disponibilizar']=='1' && empty($_GET['local'])){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
 			}
		}
		elseif($_SESSION['cod_cidadei'] && empty($_GET['local'])){ 
		  
			$bcidades = mysql_query("SELECT c.ci_cod, c.ci_nome FROM rebri_cidades c INNER JOIN muraski m ON (m.local=c.ci_cod) WHERE m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND c.ci_estado='".$estado."' AND m.finalidade='15' AND m.ref!='x' GROUP BY c.ci_nome ORDER BY c.ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidades)){
				if($linha[ci_cod]==$_SESSION['cod_cidadei']){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
 			}
		}
	   ?>
      </select></td>
    </tr>
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
      <td width="20%" class=style1><b>Distância do mar:</b></td>
      <td width="80%" class=style1><select name="comp4" id="comp4" class="campo" OnClick="LimpaCampo();">
     <option value="">Selecione</option>  
    <option value="=" <? if($comp4=='='){ echo "SELECTED"; }?>>Igual a</option>
    <option value=">" <? if($comp4=='>'){ echo "SELECTED"; }?>>Maior que</option>
    <option value="<" <? if($comp4=='<'){ echo "SELECTED"; }?>>Menor que</option>
    <option value="frente para o mar" <? if($comp4=='frente para o mar'){ echo "SELECTED"; }?>>frente para o mar</option>
    <option value="frente para a baía" <? if($comp4=='frente para a baía'){ echo "SELECTED"; }?>>frente para a baía</option>
      </select> <input type="text" name="dist_mar" size="4" class="campo" value="<?=$dist_mar; ?>"> quadras ou metros</td>
    </tr>
<? } ?>
     <tr class="fundoTabela">
      <td class=style1><b>Bairros:</b></td>
      <td class="style1"><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
           <?
          
         if($_GET['bairro']){
		  $bairro = implode('-', $_GET['bairro']);
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
        
        if($_GET['acaob']=='1'){
			$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_GET['local']."' ORDER BY b_nome");
			$col = 1;
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
          <td class="style1"><?
	  		if ($col > 3) {
				print "</td></tr><tr><td class=\"style1\">";
				$col = 1;
			}elseif ($col != 1) {
				print "</td><td  class=\"style1\">";
			}
?>
              <input type="checkbox" name="bairro[]" id="bairro" value="<?php echo("-".$linha['b_cod']."-"); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>> <?= $linha['b_nome']; ?>
              <?
			$col++;
			}
		}elseif($_SESSION['cod_cidadei'] && empty($_GET['local']) && empty($_GET['im_estado'])){ 
		  	$busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_SESSION['cod_cidadei']."' ORDER BY b_nome");
			$col = 1;
			while($linha = mysql_fetch_array($busca_bairros)){
		?>
          <td class="style1"><?
	  		if ($col > 3) {
				print "</td></tr><tr><td class=\"style1\">";
				$col = 1;
			}elseif ($col != 1) {
				print "</td><td  class=\"style1\">";
			}
?>
              <input type="checkbox" name="bairro[]" id="bairro" value="<?php echo("-".$linha['b_cod']."-"); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>> <?= $linha['b_nome']; ?>
              <?
			$col++;
			}
		}
		?>			</td>
		</tr>
		<tr>
			<td class="style1"><input name="b_bairr" type="checkbox" id="b_bairr1" value="1" <? if($b_bairr=='1'){ print "CHECKED"; } ?>> Todos</td>
        </tr>
      </table></td>
     </tr>
     <tr class="fundoTabela">
       <td class=style1><b>Caracter&iacute;sticas:</b></td>
       <td class="style1"><table width="100%" border="0" cellspacing="1" cellpadding="1">
         <tr>
          <?
          
        if($_GET['caracteristica']){
		  $caracteristica = implode('-', $_GET['caracteristica']);
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
		$col2 = 1;
		while($linha = mysql_fetch_array($busca_caracteristicas)){
		?>
          <td class="style1"><?
	  	if ($col2 > 3) {
			print "</td></tr><tr><td class=\"style1\">";
			$col2 = 1;
		} elseif ($col2 != 1) {
			print "</td><td  class=\"style1\">";
		}
?>
              <input type="checkbox" name="caracteristica[]" id="caracteristica" value="<?php echo("-".$linha['c_cod']."-"); ?>" <?php verifica_check2("".$linha['c_cod']."", $caracteristica) ?>><?= $linha['c_nome']; ?>
              <?
		$col2++;
		}
		?>		 	</td>
		</tr>
		<tr>
			<td class="style1"><input name="b_caract" type="checkbox" id="b_caract1" value="1" <? if($b_caract=='1'){ print "CHECKED"; } ?>> Todas</td>
        </tr>
       </table></td>
     </tr>
     <!--tr class="fundoTabela">
      <td class="style1"><b>Busca Característica:</b></td>
      <td class="style1"><input name="b_caract" type="checkbox" id="b_caract1" value="1" <? if($b_caract=='1'){ print "CHECKED"; } ?>>
        Todas as características selecionadas
        <!--input name="b_caract" id="b_caract2" type="radio" value="2"  <? if($b_caract=='2'){ print "CHECKED"; } ?>>
        Todas--></td>
    </tr-->
    <tr>
      <td width="100%" colspan=2>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
      <input type="submit" value="Pesquisar" name="B1" class=campo3></td>
    </tr>
  </table>
  </form>
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
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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
