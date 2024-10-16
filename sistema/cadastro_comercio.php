<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_COMERCIO");
include("style.php");
?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(id,cod)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='cadastro_comercio.php?id_excluir=' + id
}



function VerificaCampo()
{

var msg = '';

	   if(document.form1.tipos.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Tipo do Comércio.\n";
       }
       if(document.form1.estados.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Estado.\n";
       }
       if(document.form1.cidades.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Cidade.\n";
       }
       if(document.form1.bairros.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Bairro.\n";
       }
       if(document.form1.nome_comercio.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome Comércio.\n";
       }
       if(document.form1.logradouro.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Tipo do Logradouro.\n";
       }
       if(document.form1.endereco_comercio.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Endereço Completo.\n";
       }
       if(document.form1.numero_comercio.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Número.\n";
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.cadastra.value='1';
			document.form1.submit();
	   }

}

function VerificaCampo2()
{

var msg = '';

	   if(document.form1.tipos.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Tipo do Comércio.\n";
       }
       if(document.form1.estados.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Estado.\n";
       }
       if(document.form1.cidades.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Cidade.\n";
       }
       if(document.form1.bairros.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Bairro.\n";
       }
       if(document.form1.nome_comercio.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome Comércio.\n";
       }
       if(document.form1.logradouro.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Tipo do Logradouro.\n";
       }
       if(document.form1.endereco_comercio.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Endereço Completo.\n";
       }
       if(document.form1.numero_comercio.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Número.\n";
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.altera.value='1';
			document.form1.submit();
	   }

}

function VerificaCampoBusca()
{

var msg = '';

       if(document.form1.estados2.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Estado.\n";
       }
       if(document.form1.cidades2.selectedIndex == 0)
	   {
		       msg += "Por favor, selecione o campo Cidade.\n";
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.buscar.value='1';
			document.form1.submit();
	   }

}

</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
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

if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		
   		$tipos = $_POST['tipos'];
   		$estados = $_POST['estados'];
   		$cidades = $_POST['cidades'];
   		$bairros = $_POST['bairros'];
   		$nome_comercio = $_POST['nome_comercio'];
   		$logradouro = $_POST['logradouro'];
   		$endereco_comercio = $_POST['endereco_comercio'];
   		$numero_comercio = $_POST['numero_comercio'];
   		
   		$SQL = "SELECT id_comercio FROM comercios WHERE tipo_comercio='".$tipos."' AND estado_comercio='".$estados."' AND cidade_comercio='".$cidades."' AND bairro_comercio='".$bairros."' AND logradouro_comercio='".$logradouro."' AND endereco_comercio='".$endereco_comercio."' AND numero_comercio='".$numero_comercio."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe esse comércio cadastrado para esse estado, cidade, bairro e endereço!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"cadastro_feriados.php\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO comercios (cod_imobiliaria, tipo_comercio, estado_comercio, cidade_comercio, bairro_comercio, nome_comercio, logradouro_comercio, endereco_comercio, numero_comercio) VALUES ('".$_SESSION['cod_imobiliaria']."','".$tipos."','".$estados."','".$cidades."','".$bairros."','".$nome_comercio."','".$logradouro."','".$endereco_comercio."','".$numero_comercio."')";   		
			if(mysql_query($inserir))
			{
				echo('<script language="javascript">alert("Comércio cadastrado com sucesso!");document.location.href="cadastro_comercio.php";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="cadastro_comercio.php";</script>');
   			}
   		}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT id_comercio, tipo_comercio, estado_comercio, cidade_comercio, bairro_comercio, nome_comercio, logradouro_comercio, endereco_comercio, numero_comercio FROM comercios WHERE id_comercio='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_comercio = $linha['id_comercio'];
       $tipos = $linha['tipo_comercio'];
       $estados = $linha['estado_comercio'];
       $cidades = $linha['cidade_comercio'];
       $bairros = $linha['bairro_comercio'];
       $nome_comercio = $linha['nome_comercio'];
       $logradouro = $linha['logradouro_comercio'];
       $endereco_comercio = $linha['endereco_comercio'];
       $numero_comercio = $linha['numero_comercio'];
    }
}

if($_POST['altera']=='1')
{
   			$tipos = $_POST['tipos'];
   			$estados = $_POST['estados'];
   			$cidades = $_POST['cidades'];
   			$bairros = $_POST['bairros'];
   			$nome_comercio = $_POST['nome_comercio'];
   			$logradouro = $_POST['logradouro'];
   			$endereco_comercio = $_POST['endereco_comercio'];
   			$numero_comercio = $_POST['numero_comercio'];
     
			$atualizacao = "UPDATE comercios SET tipo_comercio='".$tipos."', estado_comercio='".$estados."', cidade_comercio='".$cidades."', bairro_comercio='".$bairros."', nome_comercio='".$nome_comercio."', logradouro_comercio='".$logradouro."', endereco_comercio='".$endereco_comercio."', numero_comercio='".$numero_comercio."' WHERE id_comercio='".$id_comercio."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Comércio alterado com sucesso!");document.location.href="cadastro_comercio.php";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="cadastro_comercio.php";</script>');
   			}
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
   		$exclusao = "DELETE FROM comercios WHERE id_comercio='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Comércio excluído com sucesso!");document.location.href="cadastro_comercio.php";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="cadastro_comercio.php";</script>');
   		}
}
	  
?>
<form id="form1" name="form1" method="post" action="cadastro_comercio.php">
<input type="hidden" name="id_comercio" id="id_comercio" value="<? echo($id_comercio); ?>">
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Cadastro Com&eacute;rcio </b></div></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Tipo Com&eacute;rcio:</b></td>
      <td width="80%" class="style1"><select name="tipos" id="tipos" class="campo">
        <option value="">Selecione o tipo comércio</option>
<?
	        $btipos = mysql_query("SELECT tc_cod, tc_nome FROM rebri_tipo_comercio ORDER BY tc_nome ASC");
 			while($linha = mysql_fetch_array($btipos)){
				if($linha['tc_cod']==$tipos){
			   		echo('<option value="'.$linha['tc_cod'].'" SELECTED>'.$linha['tc_nome'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha['tc_cod'].'">'.$linha['tc_nome'].'</option>');
				}
			}
?>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Estado:</b></td>
      <td width="80%" class="style1"><select name="estados" id="estados" class="campo" onChange="form1.submit();">
        <option value="">Selecione o estado</option>
<?
	        $bestado = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestado)){
				if($linha['e_cod']==$estados){
			   		echo('<option value="'.$linha['e_cod'].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha['e_cod'].'">'.$linha['e_uf'].'</option>');
				}
			}
?>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Cidade:</b></td>
      <td width="80%" class="style1"><select name="cidades" id="cidades" class="campo" onChange="form1.submit();">
        <? if($_POST['estados']){ ?>   
			<option value="0">Selecione a cidade</option>
		<? }else{ ?>
			<option value="0">Selecione o estado</option>
		<? } ?>
<?
	        $bcidade = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado='".$estados."' ORDER BY ci_nome ASC");
 			while($linha = mysql_fetch_array($bcidade)){
				if($linha['ci_cod']==$cidades){
			   		echo('<option value="'.$linha['ci_cod'].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha['ci_cod'].'">'.$linha['ci_nome'].'</option>');
				}
			}
?>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Bairro:</b></td>
      <td width="80%" class="style1"><select name="bairros" id="bairros" class="campo" onChange="form1.submit();">
        <? if($_POST['cidades']){ ?>   
			<option value="0">Selecione o bairro</option>
		<? }else{ ?>
			<option value="0">Selecione a cidade</option>
		<? } ?>
<?
	        $bbairro = mysql_query("SELECT b_cod, b_nome FROM rebri_bairros WHERE b_cidade='".$cidades."' ORDER BY b_nome ASC");
 			while($linha = mysql_fetch_array($bbairro)){
				if($linha['b_cod']==$bairros){
			   		echo('<option value="'.$linha['b_cod'].'" SELECTED>'.$linha['b_nome'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha['b_cod'].'">'.$linha['b_nome'].'</option>');
				}
			}
?>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Nome Com&eacute;rcio:</b></td>
      <td width="80%" class="style1"><input type="text" name="nome_comercio" id="nome_comercio" size="30" class="campo" value="<?=$nome_comercio; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Endere&ccedil;o:</b></td>
      <td width="80%" class="style1"><select name="logradouro" id="logradouro" class="campo">
        <option value="">Selecione</option>
        <option value="Alameda" <? if($logradouro=='Alameda'){ print "SELECTED"; } ?>>Alameda</option>
        <option value="Área" <? if($logradouro=='Área'){ print "SELECTED"; } ?>>Área</option>
        <option value="Avenida" <? if($logradouro=='Avenida'){ print "SELECTED"; } ?>>Avenida</option>
       	<option value="Campo" <? if($logradouro=='Campo'){ print "SELECTED"; } ?>>Campo</option>
        <option value="Chácara" <? if($logradouro=='Chácara'){ print "SELECTED"; } ?>>Chácara</option>
        <option value="Colônia" <? if($logradouro=='Colônia'){ print "SELECTED"; } ?>>Colônia</option>
        <option value="Condomínio" <? if($logradouro=='Condomínio'){ print "SELECTED"; } ?>>Condomínio</option>
        <option value="Conjunto" <? if($logradouro=='Conjunto'){ print "SELECTED"; } ?>>Conjunto</option>
        <option value="Distrito" <? if($logradouro=='Distrito'){ print "SELECTED"; } ?>>Distrito</option>
        <option value="Esplanada" <? if($logradouro=='Esplanada'){ print "SELECTED"; } ?>>Esplanada</option>
        <option value="Estação" <? if($logradouro=='Estação'){ print "SELECTED"; } ?>>Estação</option>
        <option value="Estrada" <? if($logradouro=='Estrada'){ print "SELECTED"; } ?>>Estrada</option>
        <option value="Favela" <? if($logradouro=='Favela'){ print "SELECTED"; } ?>>Favela</option>
        <option value="Fazenda" <? if($logradouro=='Fazenda'){ print "SELECTED"; } ?>>Fazenda</option>
        <option value="Feira" <? if($logradouro=='Feira'){ print "SELECTED"; } ?>>Feira</option>
        <option value="Jardim" <? if($logradouro=='Jardim'){ print "SELECTED"; } ?>>Jardim</option>
        <option value="Ladeira" <? if($logradouro=='Ladeira'){ print "SELECTED"; } ?>>Ladeira</option>
        <option value="Lago" <? if($logradouro=='Lago'){ print "SELECTED"; } ?>>Lago</option>
        <option value="Lagoa" <? if($logradouro=='Lagoa'){ print "SELECTED"; } ?>>Lagoa</option>
        <option value="Largo" <? if($logradouro=='Largo'){ print "SELECTED"; } ?>>Largo</option>
        <option value="Loteamento" <? if($logradouro=='Loteamento'){ print "SELECTED"; } ?>>Loteamento</option>
        <option value="Morro" <? if($logradouro=='Morro'){ print "SELECTED"; } ?>>Morro</option>
        <option value="Núcleo" <? if($logradouro=='Núcleo'){ print "SELECTED"; } ?>>Núcleo</option>
        <option value="Parque" <? if($logradouro=='Parque'){ print "SELECTED"; } ?>>Parque</option>
        <option value="Passarela" <? if($logradouro=='Passarela'){ print "SELECTED"; } ?>>Passarela</option>
        <option value="Pátio" <? if($logradouro=='Pátio'){ print "SELECTED"; } ?>>Pátio</option>
        <option value="Praça" <? if($logradouro=='Praça'){ print "SELECTED"; } ?>>Praça</option>
        <option value="Quadra" <? if($logradouro=='Quadra'){ print "SELECTED"; } ?>>Quadra</option>
        <option value="Recanto" <? if($logradouro=='Recanto'){ print "SELECTED"; } ?>>Recanto</option>
        <option value="Residencial" <? if($logradouro=='Residencial'){ print "SELECTED"; } ?>>Residencial</option>
        <option value="Rodovia" <? if($logradouro=='Rodovia'){ print "SELECTED"; } ?>>Rodovia</option>
        <option value="Rua" <? if($logradouro=='Rua'){ print "SELECTED"; } ?>>Rua</option>
        <option value="Setor" <? if($logradouro=='Setor'){ print "SELECTED"; } ?>>Setor</option>
        <option value="Sítio" <? if($logradouro=='Sítio'){ print "SELECTED"; } ?>>Sítio</option>
        <option value="Travessa" <? if($logradouro=='Travessa'){ print "SELECTED"; } ?>>Travessa</option>
        <option value="Trecho" <? if($logradouro=='Trecho'){ print "SELECTED"; } ?>>Trecho</option>
        <option value="Trevo" <? if($logradouro=='Trevo'){ print "SELECTED"; } ?>>Trevo</option>
        <option value="Vale" <? if($logradouro=='Vale'){ print "SELECTED"; } ?>>Vale</option>
        <option value="Vereda" <? if($logradouro=='Vereda'){ print "SELECTED"; } ?>>Vereda</option>
        <option value="Via" <? if($logradouro=='Via'){ print "SELECTED"; } ?>>Via</option>
        <option value="Viaduto" <? if($logradouro=='Viaduto'){ print "SELECTED"; } ?>>Viaduto</option>
        <option value="Viela" <? if($logradouro=='Viela'){ print "SELECTED"; } ?>>Viela</option>
        <option value="Vila" <? if($logradouro=='Vila'){ print "SELECTED"; } ?>>Vila</option>
      </select>
      <input type="text" name="endereco_comercio" id="endereco_comercio" size="40" class="campo" value="<?=$endereco_comercio; ?>"> 
      N&deg;: 
      <input type="text" name="numero_comercio" id="numero_comercio" size="5" class="campo" value="<?=$numero_comercio; ?>"></td>
    </tr>	
    <tr>
      <td colspan="2"><? 
	  	if(empty($id_comercio))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='cadastro_comercio.php'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='cadastro_comercio.php'\">
		  ");		
        } 
	  ?>	  </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr class="fundoTabelaTitulo">
      <td colspan="2"><p align="center" class="style1"><b>Dados da pesquisa</b></p></td>
    </tr>
    <tr class="fundoTabela">
      <td colspan="2" class="style1"><div align="center">Selecione como deseja filtrar sua pesquisa - <b>Estado:</b>
          <select name="estados2" id="estados2" class="campo" onChange="form1.cidades2.value='%';form1.submit();">
          <option value="%" <? if($estados2=='%'){ print "SELECTED";  } ?>>Todos</option>
<?
	        $bestado2 = mysql_query("SELECT e.e_cod, e.e_uf FROM rebri_estados e INNER JOIN comercios c ON (c.estado_comercio=e.e_cod) GROUP BY e.e_uf ORDER BY e.e_uf ASC");
 			while($linha = mysql_fetch_array($bestado2)){
				if($linha['e_cod']==$estados2){
			   		echo('<option value="'.$linha['e_cod'].'" SELECTED>'.$linha['e_uf'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha['e_cod'].'">'.$linha['e_uf'].'</option>');
				}
			}
?>
          </select>
          <b>Cidade:</b>          
          <select name="cidades2" id="cidades2" class="campo" onChange="form1.submit();">
          <option value="%" <? if($cidades2=='%'){ print "SELECTED";  } ?>>Todos</option>
<?

		if($_POST['estados2']){
	        $bcidade2 = mysql_query("SELECT ci.ci_cod, ci.ci_nome FROM rebri_cidades ci INNER JOIN comercios c ON (c.cidade_comercio=ci.ci_cod) WHERE ci.ci_estado LIKE '".$estados2."' GROUP BY ci.ci_nome ORDER BY ci.ci_nome ASC");
			 while($linha = mysql_fetch_array($bcidade2)){
				if($linha['ci_cod']==$cidades2){
			   		echo('<option value="'.$linha['ci_cod'].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha['ci_cod'].'">'.$linha['ci_nome'].'</option>');
				}
			}
		}
?>
          </select>
          <!--input type="hidden" name="buscar" id="buscar" value="0">
          <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="VerificaCampoBusca();"-->
          <br>
      </div></td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr class="fundoTabelaTitulo">
          <td width="11%" class="style1"><b>Tipo</b></td>
          <td width="14%" class="style1"><b>Nome</b></td>
          <td width="6%" class="style1"><b>UF</b></td>
          <td width="17%" class="style1"><b>Cidade</b></td>
          <td width="29%" class="style1"><b>Endere&ccedil;o</b></td>
          <td width="10%" class="style1"><p align="center"><b>Altera&ccedil;&atilde;o</b></p></td>
          <td width="13%" class="style1"><p align="center"><b>Exclus&atilde;o</b></p></td>
        </tr>
        <?
          if($_POST['estados2'] || $_POST['cidades2']){
            
            $busca2 = mysql_query("SELECT c.cod_imobiliaria, c.id_comercio, c.nome_comercio, c.logradouro_comercio, c.endereco_comercio, c.numero_comercio, t.tc_nome, ci.ci_nome, e.e_uf FROM comercios c INNER JOIN rebri_tipo_comercio t ON (t.tc_cod=c.tipo_comercio) INNER JOIN rebri_estados e ON (e.e_cod=c.estado_comercio) INNER JOIN rebri_cidades ci ON (ci.ci_cod=c.cidade_comercio) WHERE c.estado_comercio LIKE '".$_POST['estados2']."' AND c.cidade_comercio LIKE '".$_POST['cidades2']."' ORDER BY c.tipo_comercio ASC");
			if(mysql_num_rows($busca2) > 0){
			  	$i = 0;
	 			while($linha2 = mysql_fetch_array($busca2)){
	 			  
	 			  	if($linha2['cod_imobiliaria']==$_SESSION['cod_imobiliaria']){
						$alteracao = "<a href=\"cadastro_comercio.php?id=".$linha2['id_comercio']."\" class=\"style1\">Alterar</a>";
						$exclusao = "<a href=\"javascript:confirmaExclusao(".$linha2['id_comercio'].")\" class=\"style1\">Excluir</a>";
					}else{
					  	$alteracao = "Alterar";
					  	$exclusao = "Excluir";
					}
					
					if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		  		  	$i++;
	 			  
      				echo('
	        			<tr class="'.$fundo.'">
            				<td class="style1">'.$linha2['tc_nome'].'</td>
            				<td class="style1">'.$linha2['nome_comercio'].'</td>
            				<td class="style1">'.$linha2['e_uf'].'</td>
            				<td class="style1">'.$linha2['ci_nome'].'</td>
            				<td class="style1">'.$linha2['logradouro_comercio'].' '.$linha2['endereco_comercio'].', '.$linha2['numero_comercio'].'</td>
            				<td class="style1"><p align="center">'.$alteracao.'</p></td>
            				<td class="style1"><p align="center">'.$exclusao.'</p></td>
            			</tr>
	   				');
    			}
  			}
  			else
    		{
	       		echo('
	        		<tr>
            			<td colspan="7" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            		</tr>
	   			');
			}
			
		}else{
		  
		  	$busca2 = mysql_query("SELECT c.cod_imobiliaria, c.id_comercio, c.nome_comercio, c.logradouro_comercio, c.endereco_comercio, c.numero_comercio, t.tc_nome, ci.ci_nome, e.e_uf FROM comercios c INNER JOIN rebri_tipo_comercio t ON (t.tc_cod=c.tipo_comercio) INNER JOIN rebri_estados e ON (e.e_cod=c.estado_comercio) INNER JOIN rebri_cidades ci ON (ci.ci_cod=c.cidade_comercio) ORDER BY c.tipo_comercio ASC");
     		if(mysql_num_rows($busca2) > 0){
     		  	$i = 0;
	 			while($linha2 = mysql_fetch_array($busca2)){
	 			  
	 			  	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		  		  	$i++;
	 			  
	 			  	if($linha2['cod_imobiliaria']==$_SESSION['cod_imobiliaria']){
						$alteracao = "<a href=\"cadastro_comercio.php?id=".$linha2['id_comercio']."\" class=\"style1\">Alterar</a>";
						$exclusao = "<a href=\"javascript:confirmaExclusao(".$linha2['id_comercio'].")\" class=\"style1\">Excluir</a>";
					}else{
					  	$alteracao = "Alterar";
					  	$exclusao = "Excluir";
					}
	 			  
      				echo('
	        			<tr class="'.$fundo.'">
            				<td class="style1">'.$linha2['tc_nome'].'</td>
            				<td class="style1">'.$linha2['nome_comercio'].'</td>
            				<td class="style1">'.$linha2['e_uf'].'</td>
            				<td class="style1">'.$linha2['ci_nome'].'</td>
            				<td class="style1">'.$linha2['logradouro_comercio'].' '.$linha2['endereco_comercio'].', '.$linha2['numero_comercio'].'</td>
            				<td class="style1"><p align="center">'.$alteracao.'</p></td>
            				<td class="style1"><p align="center">'.$exclusao.'</p></td>
            			</tr>
	   				');
    			}
  			}
  			else
    		{
	       		echo('
	        		<tr>
            			<td colspan="7" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            		</tr>
	   			');
			}
			
		}
       ?>
      </table></td>
    </tr>
  </table>
<?
mysql_close($con);
?>
</form>
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