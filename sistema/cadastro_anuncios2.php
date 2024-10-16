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
verificaArea("GERAL_ANUNC");
include("style.php");

if($_GET['rel']){
 $rel = $_GET['rel'];
}else{
 $rel = $_POST['rel'];
}

if($_GET['data_inicial']){
 $data_inicial = $_GET['data_inicial'];
}else{
 $data_inicial = $_POST['data_inicial'];
}

if($_GET['data_final']){
 $data_final = $_GET['data_final'];
}else{
 $data_final = $_POST['data_final'];
}

if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}

if($_GET['exportar']){
 $exportar = $_GET['exportar'];
}else{
 $exportar = $_POST['exportar'];
}

if($_GET['tipoe']){
 $tipoe = $_GET['tipoe'];
}else{
 $tipoe = $_POST['tipoe'];
}

if($_GET['data']){
 $data = $_GET['data'];
}else{
 $data = $_POST['data'];
}

if($_GET['veiculos']){
 $veiculos = $_GET['veiculos'];
}else{
 $veiculos = $_POST['veiculos'];
}

  $datafo = date("dmY");
  $horafo = date("His"); 

if($rel<>'S'){ 
?>
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
<? } ?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="css/estilos_sistema.css" />
<script type="text/javascript" src="funcoes/js.js"></script>
<script type="text/javascript" src="funcoes/bibliotecaAjax.js"></script>
<script type="text/javascript" src="funcoes/formulario_imovel.js"></script>
<script language="javascript">
function confirmaExclusao(id,cod,rel,data_inicial,data_final)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='cadastro_anuncios2.php?id_excluir=' + id + '&cod=' + cod + '&rel=' + rel + '&data_inicial=' + data_inicial + '&data_final=' + data_final;
}

function confirmaExclusaoImovel(id,ida,codi,rel,data_inicial,data_final,exportar,tipoe,data,veiculos)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='cadastro_anuncios2.php?id_excluir_codigo=' + id + '&id_excluir_anuncio=' + ida + '&id_excluir_imovel=' + codi + '&rel=' + rel + '&data_inicial=' + data_inicial + '&data_final=' + data_final + '&exportar=' + exportar + '&tipoe=' + tipoe + '&data=' + data + '&veiculos=' + veiculos;
}


function VerificaCampo()
{

var msg = '';

       if(document.form1.data.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data.\n";
       }
       if (document.form1.veiculos.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Veículo.\n";
	   }
	   else if(document.form1.veiculos.value=='Outros')
	   {
	    	if(document.form1.qual.value.length==0)
	   		{
		       msg += "Por favor, preencha o campo Qual?\n";
       		}
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

       if(document.form1.data.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data.\n";
       }
       if (document.form1.veiculos.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Veículo.\n";
	   }
	   else if(document.form1.veiculos.value=='Outros')
	   {
	    	if(document.form1.qual.value.length==0)
	   		{
		       msg += "Por favor, preencha o campo Qual?\n";
       		}
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

function VerificaDados(id_anuncio,exportar)
{

	if(document.form1.qtd_fotos.value=="")
	{
	  	alert( "Por favor, preencha o campo Quantidade de fotos por imóvel." );
		document.form1.qtd_fotos.focus();
		document.form1.qtd_fotos.style.backgroundColor = '<?=$cor_erro ?>';
		return false;	
    }
    else
	{
	 	document.form1.qtd_fotos.style.backgroundColor = '<?=$cor1 ?>'; 
	}
    
     document.form1.action='gerar_xml_anuncio.php?id_anuncio=' + id_anuncio + '&exportar=' + exportar + '&buscar=1';
	 return true;
}
</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<?php

/* 
if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		
   		$data = formataDataParaBd($_POST['data']);
   		if($_POST['veiculo']=='Outros'){
   		   	$veiculo = $_POST['veiculo']." - ".$_POST['qual'];
   		}else{
			$veiculo = $_POST['veiculo'];
		}
   		
   		$SQL = "SELECT id_anuncio FROM anuncios WHERE data_anuncio='".$data."' and veiculo_anuncio='".$veiculo."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe um anúncio cadastrado com esses dados!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"cadastro_anuncios2.php?cod=".$cod."&rel=".$rel."&data_inicial=".$data_inicial."&data_final=".$data_final."\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO anuncios (cod_imobiliaria, data_anuncio, veiculo_anuncio) VALUES ('".$_SESSION['cod_imobiliaria']."','".$data."', '".$veiculo."')";   		
   			if(mysql_query($inserir))
			{
				echo('<script language="javascript">alert("Cadastro efetuado com sucesso!");document.location.href="cadastro_anuncios2.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="cadastro_anuncios2.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   			}
   		}
}
*/

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT id_anuncio, data_anuncio, veiculo_anuncio FROM anuncios WHERE id_anuncio='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_anuncio = $linha['id_anuncio'];
       $data = formataDataDoBd($linha['data_anuncio']);
  	   list($veiculos, $qual) = explode(" - ", $linha['veiculo_anuncio']);
    }
}

/*
if($_POST['altera']=='1')
{
   			$id_anuncio = $_POST['id_anuncio'];
   			$co_imovel = $_POST['co_imovel'];
   			$data = formataDataParaBd($_POST['data']);
			$valor_anuncio = str_replace(".", "", $_POST['valor_anuncio']);
   			if($_POST['veiculo']=='Outros'){
   		   		$veiculo = $_POST['veiculo']." - ".$_POST['qual'];
   			}else{
				$veiculo = $_POST['veiculo'];
			}
			
			$i2 = $_POST['conta'];
			$c = 0;

			for($j = 0; $j <= $i2; $j++)
			{	     
				$idimoveis = "id_anuncio_imovel_".$j;
				$idim = $_POST[$idimoveis];
				$codigoims = "co_imovel_".$j;
     			$totali = $_POST[$codigoims];
     			$codigoia = "id_anuncio_temp_".$j;
     			$totala = $_POST[$codigoia];

  	 			if($totali){
    				$c++;
    				$queryi= "UPDATE imoveis_anuncio SET cod_imovel='".$totali."' WHERE id_anuncio_imovel='".$idim."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$resulti = mysql_query($queryi) or die("Não foi possível atualizar suas informações. $queryi");
					
					$queryi5 = "UPDATE anuncios_temp SET cod='".$totali."' WHERE id_anuncio_temp='".$totala."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$resulti5 = mysql_query($queryi5) or die("Não foi possível atualizar suas informações. $queryi5");	
					
					$query6 = "select m.ref from muraski m  
					where m.cod='".$totali."' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$result6 = mysql_query($query6);
					$numrows6 = mysql_num_rows($result6);
					if($numrows6 > 0){
						while($not6 = mysql_fetch_array($result6))
						{
							$refi = $not6['ref'];
						}
					}
					
					
					$dataa = date("Y-m-d");
					$horaa = date("H:i:s");
					$B1 = "Atualizou Anúncio";

					//Insere o usuário que esta fazendo a atualização do imovel
					$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_anuncio, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$totali."','".$refi."','".$id_anuncio."','".$B1."','".$dataa."','".$horaa."')") or die ("Erro 133 - ".mysql_error());					
     			} 
     							
  			}
			 
			$atualizacao = "UPDATE anuncios SET data_anuncio='".$data."', veiculo_anuncio='".$veiculo."' WHERE id_anuncio='".$id_anuncio."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Cadastro alterado com sucesso!");document.location.href="cadastro_anuncios2.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="cadastro_anuncios2.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   			}
}
*/

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
        $queryi2 = "DELETE FROM anuncios_temp WHERE anuncio='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$resulti2 = mysql_query($queryi2) or die("Não foi possível atualizar suas informações. $queryi2");			
		
		$queryi3 = "DELETE FROM imoveis_anuncio WHERE id_anuncio='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$resulti3 = mysql_query($queryi3) or die("Não foi possível atualizar suas informações. $queryi3");			
        
   		$exclusao = "DELETE FROM anuncios WHERE id_anuncio='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Cadastro excluído com sucesso!");document.location.href="cadastro_anuncios2.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="cadastro_anuncios2.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   		}
}

if($_GET['id_excluir_codigo'])
{ 
        $id_excluir_codigo = $_GET['id_excluir_codigo'];
        $id_excluir_anuncio = $_GET['id_excluir_anuncio'];
        $id_excluir_imovel = $_GET['id_excluir_imovel'];
        
		$query6 = "select m.cod, m.ref from imoveis_anuncio a 
		left join muraski m on m.cod=a.cod_imovel 
		where a.id_anuncio_imovel='".$id_excluir_codigo."' and a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result6 = mysql_query($query6);
		$numrows6 = mysql_num_rows($result6);
		if($numrows6 > 0){
			while($not6 = mysql_fetch_array($result6))
			{
				$codigoi = $not6[0];
				$refi = $not6[1];
			}
		}
        	    
	    $queryi4 = "DELETE FROM anuncios_temp WHERE anuncio='".$id_excluir_anuncio."' AND cod='".$id_excluir_imovel."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$resulti4 = mysql_query($queryi4) or die("Não foi possível atualizar suas informações. $queryi4");			
	            
   		$exclusao = "DELETE FROM imoveis_anuncio WHERE id_anuncio_imovel='".$id_excluir_codigo."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Imóvel removido com sucesso!");document.location.href="cadastro_anuncios2.php?cod='.$cod.'&id_anuncio='.$id_excluir_anuncio.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'&exportar='.$exportar.'&tipoe='.$tipoe.'&data='.$data.'&veiculos='.$veiculos.'";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="cadastro_anuncios2.php?cod='.$cod.'&id_anuncio='.$id_excluir_anuncio.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'&exportar='.$exportar.'&tipoe='.$tipoe.'&data='.$data.'&veiculos='.$veiculos.'";</script>');
   		}

	$data = date("Y-m-d");
	$hora = date("H:i:s");
	$B1 = "Excluiu Anúncio";

	//Insere o usuário que esta fazendo a atualização do imovel
	$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_anuncio, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$codigoi."','".$refi."','".$id_excluir_anuncio."','".$B1."','".$data."','".$hora."')") or die ("Erro 133 - ".mysql_error());
}


/*
if($_GET['adicionar'] == "S"){
	
	$a_cod = $_GET['id'];
	
	session_register("a_cod");
	
	$query6 = "SELECT sid FROM anuncios_temp WHERE anuncio='$a_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
		if($numrows6 > 0){
			while($not6 = mysql_fetch_array($result6))
			{
				$sid = $not6['sid'];
				session_register("sid");
			}
		}
		echo('<script language="javascript">alert("Sessão criada para adicionar imóveis para essa exportação!");document.location.href="cadastro_anuncios2.php?cod='.$cod.'&id_anuncio='.$id_excluir_anuncio.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
}
*/
	  
?>
<form id="form1" name="form1" method="post" action="cadastro_anuncios2.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="data_inicial" id="data_inicial" value="<?=$data_inicial ?>">
<input type="hidden" name="data_final" id="data_final" value="<?=$data_final ?>">
<input type="hidden" name="rel" id="rel" value="<?=$rel ?>">
<input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo($id_anuncio); ?>">
<input type="hidden" name="tipoe" id="tipoe" value="<? echo($tipoe); ?>">
<input type="hidden" name="exportar" id="exportar" value="<? echo($exportar); ?>">
<input name="cont" id="cont" type="hidden" class="campo" value="0">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Exportações</b><br />
      </div></td>
    </tr>
<? 
	if(!empty($id_anuncio)){  
?>
	
	 <tr>
      <td colspan="2" class="style1" align="left" width="20%"><b>Data:</b> <?=$data; ?> <b>(Obs: Data da última inclusão de imóvel a esse veículo de exportação)</b></td>
    </tr>
    <tr>
      <td colspan="2" class="style1" align="left"><b>Ve&iacute;culo:</b>
<?
	//$query6 = "select * from rebri_tipo_anuncios WHERE (ta_nome LIKE 'Imóveis Curitiba' OR ta_nome LIKE 'Chave Fácil' OR ta_nome LIKE 'Minha Primeira Casa') order by ta_nome";
    $query6 = "select * from rebri_tipo_anuncios WHERE (ta_nome LIKE 'Imóveis Curitiba' OR ta_nome LIKE 'Chave Fácil') order by ta_nome";
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
	if($numrows6 > 0){
		while($not6 = mysql_fetch_array($result6))
		{
         	if($veiculos==$not6['ta_cod']){ 
         	   $tipoe = $not6['ta_nome'];	
			   echo $not6['ta_nome'];
			} 
		}
	}
?>
	<input type="hidden" name="data" id="data" value="<? echo($data); ?>">
	<input type="hidden" name="veiculos" id="veiculos" value="<? echo($veiculos); ?>">
	<tr>
		<td class="style1" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="1">
<?
	$alteracao2 = mysql_query("SELECT m.cod, m.ref, m.titulo, m.valor, m.carnaval, m.anonovo, m.metragem, m.descricao, m.tipo,
	m.n_quartos, m.finalidade, m.suites, m.dist_tipo, m.dist_mar, m.chaves, m.bairro, t.t_nome, ci.ci_nome, e.e_uf, i.nome_pasta, i.im_cod,
	ia.id_anuncio_imovel, ia.id_anuncio, ia.cod_imovel
	FROM imoveis_anuncio ia 
	INNER JOIN muraski m ON (ia.cod_imovel=m.cod) 
	INNER JOIN anuncios a ON (ia.id_anuncio=a.id_anuncio) 
	INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) 
	INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) 
	INNER JOIN rebri_estados e ON (m.uf=e.e_cod)
	INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod)
	INNER JOIN anuncios_temp at ON (at.cod=m.cod)
	WHERE ia.id_anuncio='".$id_anuncio."' GROUP BY at.cod ORDER BY m.finalidade");
	$conta = mysql_num_rows($alteracao2);
	$i = 0;
	$controle = '';
	while($linha2 = mysql_fetch_array($alteracao2)){
	  
	  	$valor = number_format($linha2['valor'], 2, ',', '.');
		$carnaval = number_format($linha2['carnaval'], 2, ',', '.');
		$anonovo = number_format($linha2['anonovo'], 2, ',', '.');
		$metragem = str_replace(".",",",$linha2['metragem']);
		$descricao = str_replace("\n","<br>",$linha2['descricao']);
		$pastai = $linha2['nome_pasta'];
		$finalidade = $linha2['finalidade'];
	  
	  	if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14'){
			$finalidades = "Locação Mensal";
		}elseif($finalidade=='1' || $finalidade=='2' || $finalidade=='3' || $finalidade=='4' || $finalidade=='5' || $finalidade=='6' || $finalidade=='7'){
			$finalidades = "Venda";
		}elseif($finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
		  	$finalidades = "Locação Temporada";
		}
			  
  		if ($controle <> $finalidades) {   
	  		$controle = $finalidades;     
	  	
?>		
  			<tr>
        		<td class="style7" colspan="2" align="left"><b><?=$finalidades ?></b></td>
      		</tr>
      		<tr>
        		<td class="style1" colspan="2" align="center">&nbsp;</td>
      		</tr>
<?
		}
?>      		
			<tr>
    			<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      				<tr>
        				<td align="center">
        			
<?
				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
					$pasta_finalidade = "locacao_peq";
				}
				else
				{
					$pasta_finalidade = "venda_peq";
				}
				
				$pasta = "../imobiliarias/".$pastai."/".$pasta_finalidade."/";
			
				$nome_foto1 = $linha2['ref'] . "_1_peq" . ".jpg";
				
				if (file_exists($pasta.$nome_foto1)){
?>
              				<img border="0" src="<?php print($pasta.$nome_foto1."?datafo=$datafo&horafo=$horafo"); ?>">
<?
				}else{
?>
              				<img border="0" src="images/sem_foto.gif">
<?							  
				}
?>		
						</td>
      				</tr>
    			</table></td>
    			<input type="hidden" name="id_anuncio_imovel_<?=$i ?>" value="<?=$linha2['id_anuncio_imovel'] ?>">
				<input type="hidden" name="id_anuncio_temp_<?=$i ?>" value="<?=$linha2['id_anuncio_temp'] ?>">
    			<td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bordaTabelaDestaque">
      				<tr class="fundoTabela">
        				<td class="style1" align="left">Ref.: <?php print $linha2['ref']; ?> - <?php print $linha2['t_nome']; ?> - <?php print strip_tags($linha2['titulo']); ?></td>
      				</tr>  
<?
					if($linha2['metragem'] > 0){
?>      				
					<tr class="fundoTabela">
        				<td class="style1" align="left">Metragem: <b><?php print $metragem; ?> m<sup>2</sup></b></td>
      				</tr>  
<?
					}
					if($linha2['n_quartos'] > 0){
?>      				
	  				<tr class="fundoTabela">
        				<td class="style1" align="left">Total Quartos: <b> <?php print $linha2['n_quartos']; ?></b></td>
      				</tr> 	  
<?
					}
					if($linha2['suites'] > 0){
?>      				
	  				<tr class="fundoTabela">
        				<td class="style1" align="left">Sendo Suítes: <b><?php print $linha2['suites']; ?></b></td>
      				</tr>
<?
					}
					if($linha2['valor'] > 0){
?>      				
	  				<tr class="fundoTabela">
        				<td class="style1" align="left">
<?
					if($linha2['finalidade']=='8' || $linha2['finalidade']=='9' || $linha2['finalidade']=='10' || $linha2['finalidade']=='11' || $linha2['finalidade']=='12' || $linha2['finalidade']=='13' || $linha2['finalidade']=='14' || $linha2['finalidade']=='15' || $linha2['finalidade']=='16' || $linha2['finalidade']=='17'){
        				echo "Diária: ";
					}else{
					  	echo "Valor: ";
					}
?>						
						<b>R$ <?php print $valor; ?></b><br>
						
<?
						if($linha2['carnaval'] > 0){
?>
						Carnaval: R$ <?php print $carnaval; ?><br>
<?						    
						}
						if($linha2['anonovo'] > 0){
?>						
						Ano Novo: R$ <?php print $anonovo; ?>	
<?
						}
?>										
						</td>
      				</tr>
<?
					}
					if($linha2['dist_mar'] > 0){
?>      				
	  	  			<tr class="fundoTabela">
        				<td class="style1" align="left">Distância do mar: <b><?php print $linha2['dist_mar']." ".$linha2['dist_tipo']; ?></b></td>
      				</tr>
<?
					}
?>      				
	  				<tr class="fundoTabela">
        				<td class="style1" align="left"><b>Bairro(s):</b> 
<?
						$bairro10 = explode("--", $linha2['bairro']);
						$bairro20 = str_replace("-","",$bairro10);
		
						foreach ($bairro20 as $k => $bairro) {
							$bairro20[$k] = "'" . $bairro . "'";
						}
		
						$b_bairro = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro20) . ") ORDER BY b_nome ASC");
						while($linha3 = mysql_fetch_array($b_bairro)){
							echo $linha3['b_nome']." "; 
						}


?>						
						</td>
      				</tr>
      				<tr class="fundoTabela">
        				<td class="style1" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        					<tr>
        						<td width="75%" class="style1" align="left">Localização: <b><?php print $linha2['ci_nome']; ?> - <?php print $linha2['e_uf']; ?></b><br><? if($linha2['im_cod'] <> $_SESSION['cod_imobiliaria']){ echo "Parceria";  } ?></td>
        						<td width="25%" class="style1" align="left">
<?        				
    						echo('<a href="javascript:confirmaExclusaoImovel('.$linha2['id_anuncio_imovel'].','.$linha2['id_anuncio'].','.$linha2['cod_imovel'].', \''.$rel.'\',\''.$data_inicial.'\',\''.$data_final.'\',\''.$exportar.'\',\''.$tipoe.'\',\''.$data.'\',\''.$veiculos.'\')" class="style7">Remover</a><br>');		
?>									
								</td>
        					</tr>
        				</table></td>
      				</tr>
      				<tr class="fundoTabela">
  						<td>&nbsp;</td>
					<tr>
      				<tr class="fundoTabela">
        				<td class="style1"><p align=justify><?php print strip_tags($descricao,"<br>"); ?></p></td>
      				</tr>
    			</table></td>
  			</tr>
  			<tr>
  				<td>&nbsp;</td>
			<tr>
<?
	$i++;
	}
	
?>  
			<tr>
				<td colspan="2" bgcolor="#<?php print("$cor3"); ?>" class="style1" align="center"><?php if($conta > 1){  echo "Foram encontrados "; }else{ echo "Foi encontrado "; } print $conta; if($conta > 1){ echo " imóveis"; }else{ echo " imóvel"; } ?></td>		
			</tr>	
		<input type="hidden" name="conta" id="conta" class="campo" value="<?=$i; ?>">		
		</table></td>
	<tr>
    <tr>
      <td colspan="2">
<? 

		if($tipoe=='Imóveis Curitiba'){
		  	$exportar = "I";
			/*
			echo("         
		  		<input type=\"button\" name=\"exportar\" id=\"exportar\" class=\"campo3\" value=\"Exportar Imóveis Curitiba\" Onclick=\"window.location.href='cadastro_anuncios2.php?exportar=I&id=".$id_anuncio."cod=".$cod."&rel=".$rel."&data_inicial=".$data_inicial."&data_final=".$data_final."'\">
		  	");
			 */  
		}elseif($tipoe=='Minha Primeira Casa'){
			$exportar = "M";
			/*
			echo("         
		  		<input type=\"button\" name=\"exportar\" id=\"exportar\" class=\"campo3\" value=\"Exportar Minha Primeira Casa\" Onclick=\"window.location.href='cadastro_anuncios2.php?exportar=M&id=".$id_anuncio."cod=".$cod."&rel=".$rel."&data_inicial=".$data_inicial."&data_final=".$data_final."'\"><br><br>
		  	");
		  	*/
		}elseif($tipoe=='Chave Fácil'){
			$exportar = "C";
			/*
			echo("         
		  		<input type=\"button\" name=\"exportar\" id=\"exportar\" class=\"campo3\" value=\"Exportar Chave Fácil\" Onclick=\"window.location.href='cadastro_anuncios2.php?exportar=C&id=".$id_anuncio."cod=".$cod."&rel=".$rel."&data_inicial=".$data_inicial."&data_final=".$data_final."'\"><br><br>
		  	");
		  	*/
		}
	  	
?>
		</td>
    </tr>
<?
	} 
	
	if($exportar=='I'){
	  echo ' 
	  		<tr>
          		<td class="style1" colspan="2" align="left"><table width="100%" border="0" align="left" cellpadding="1" cellspacing="1">
				  	<tr>	
				  		<td colspan="2" class="style1" align="center"><b>Exportação para Imóveis Curitiba<br><span class="style7">Antes de enviar estes arquivos entre em contato com o Imóveis Curitiba e avise que seus dados serão enviados com os arquivos gerados no sistema da REBRI</span></b></td>
					</tr>  
					<tr class="fundoTabela">
      					<td colspan="2" class="style1" valign="top">Campos que serão exportados no arquivo TXT:<br><br>
      					- Código do Imóvel<br>
      					- Tipo do Imóvel (Ex: Apartamento)<br>
      					- Referência<br>
      					- Finalidade<br>
      					- Valor<br>
      					- Área Construída<br>
      					- Localização<br>
      					- Bairro<br>
      					- Endereço Completo (Tipo Logradouro + Endereco + Número)<br>
      					- Complemento<br>
      					- CEP<br>
      					- Bairro<br>
      					- N° de Garagem<br>
      					- Condomínio Fechado (S/N)<br>
      					- Cobertura (S/N)<br>
      					- Mobilado (S/N)<br>
      					- Observações 02<br><br>
      					Campos que serão exportados no arquivo XML:<br><br>
      					- Fotos do Imóvel
						</td>
    				</tr> 
					<tr class="fundoTabela">	
				  		<td width="30%" class="style1" align="left"><b>Quantidade de fotos por imovél:</b></td>
          				<td width="70%" class="style1"><input type="text" name="qtd_fotos" id="qtd_fotos" size="2" maxlength="2" class="campo" onKeyPress="return validarCampoNumerico(event);"></td>
					</tr>          		
					<tr class="fundoTabela">
          				<td width="30%" class="style1" align="left"><b>Tipo de Exportação:</b></td>
          				<td width="70%" class="style1"><input type="radio" name="tipo_exportacao" class="campo" id="tipo_exportacao" value="1" checked>Exportar imóveis desta lista<input type="radio" name="tipo_exportacao" class="campo" id="tipo_exportacao" value="2">Exportar apenas atualizações desta lista</td>
					</tr>          		
					<tr class="fundoTabela">
						<td width="30%" class="style1">&nbsp;</td>
          				<td width="70%" class="style1"><input type="submit" value="Gerar TXT" name="gerar_txt" id="gerar_txt" class="campo3" onClick="form1.action=\'gerar_txt_anuncio.php?id_anuncio='.$id_anuncio.'&exportar='.$exportar.'&buscar=1\';"> <input type="submit" value="Gerar XML" name="gerar_xml" id="gerar_xml" class="campo3" Onclick="return VerificaDados('.$id_anuncio.',\''.$exportar.'\');"></td>
        			</tr>
        			<tr>
  						<td>&nbsp;</td>
					<tr>
        		</td></table>
        	</tr>
	  ';
     /*
	}elseif($exportar=='M'){
	  echo ' 
	  		<tr>
          		<td class="style1" colspan="2" align="left"><table width="100%" border="0" align="left" cellpadding="1" cellspacing="1">
				  	<tr>	
				  		<td colspan="2" class="style1" align="center"><b>Exportação para Minha Primeira Casa<br><span class="style7">Antes de enviar estes arquivos entre em contato com o Minha Primeira Casa e avise que seus dados serão enviados com os arquivos gerados no sistema da REBRI</span></b></td>
					</tr>   
					<tr class="fundoTabela">
      					<td colspan="2" class="style1" valign="top">Campos que serão exportados no arquivo TXT:<br><br>
      					- Código do Imóvel<br>
      					- Tipo do Imóvel (Ex: Apartamento)<br>
      					- Referência<br>
      					- Finalidade<br>
      					- Valor<br>
      					- Área Construída<br>
      					- Estado<br>
      					- Localização<br>
      					- Bairro<br>
      					- Endereço Completo (Tipo Logradouro + Endereco + Número)<br>
      					- Complemento<br>
      					- CEP<br>
      					- Bairro<br>
      					- N° de Garagem<br>
      					- Condomínio Fechado (S/N)<br>
      					- Cobertura (S/N)<br>
      					- Mobilado (S/N)<br>
      					- Descrição
      					- Observações 02<br><br>
      					Campos que serão exportados no arquivo XML:<br><br>
      					- Fotos do Imóvel
						</td>
    				</tr> 
					<tr class="fundoTabela">	
				  		<td width="30%" class="style1" align="left"><b>Quantidade de fotos por imovél:</b></td>
          				<td width="70%" class="style1"><input type="text" name="qtd_fotos" id="qtd_fotos" size="2" maxlength="2" class="campo" onKeyPress="return validarCampoNumerico(event);"></td>
					</tr>          		
					<tr class="fundoTabela">
          				<td width="30%" class="style1" align="left"><b>Tipo de Exportação:</b></td>
          				<td width="70%" class="style1"><input type="radio" name="tipo_exportacao" class="campo" id="tipo_exportacao" value="1" checked>Exportar imóveis desta lista<input type="radio" name="tipo_exportacao" class="campo" id="tipo_exportacao" value="2">Exportar apenas atualizações desta lista<input type="radio" name="tipo_exportacao" class="campo" id="tipo_exportacao" value="3">Exportar todos os imóveis desta imobiliária</td>
					</tr>          		
					<tr class="fundoTabela">
						<td width="30%" class="style1">&nbsp;</td>
          				<td width="70%" class="style1"><input type="submit" value="Gerar TXT" name="gerar_txt" id="gerar_txt" class="campo3" onClick="form1.action=\'gerar_txt_anuncio.php?id_anuncio='.$id_anuncio.'&exportar='.$exportar.'&buscar=1\';"> <input type="submit" value="Gerar XML" name="gerar_xml" id="gerar_xml" class="campo3" Onclick="return VerificaDados('.$id_anuncio.',\''.$exportar.'\');"></td>
        			</tr>
        			<tr>
  						<td>&nbsp;</td>
					<tr>
        		</td></table>
        	</tr>
	  ';
     */
	}elseif($exportar=='C'){
	  echo ' 
	  		<tr>
          		<td class="style1" colspan="2" align="left"><table width="100%" border="0" align="left" cellpadding="1" cellspacing="1">
				  	<tr>	
				  		<td colspan="2" class="style1" align="center"><b>Exportação para Chave Fácil<br><span class="style7">Antes de enviar estes arquivos entre em contato com o Chave Fácil e avise que seus dados serão enviados com os arquivos gerados no sistema da REBRI</span></b></td>
					</tr>   
    				<tr class="fundoTabela">
      					<td colspan="2" class="style1" valign="top">Para exportar todos os imóveis para o portal www.chavefacil.com.br siga os passos abaixo:<br><br>
      					- Será necessário ter instalado no seu computador o software <b>Imoview</b> fornecido pelo Secovi/PR e pela Info Center<br>
      					- Ao clicar no botão abaixo o sistema gerará um arquivo que deverá ser importado para o portal através do sistema <b>Imoview</b><br>
      					- Dúvidas sobre o sistema de importação podem ser tiradas com o suporte técnico do chavefacil.com.br</td>
    				</tr>        		
    				<tr class="fundoTabela">
      					<td colspan="2" class="style1" valign="top">Campos que serão exportados no arquivo TXT:<br><br>
      					- Código do Imóvel<br>
      					- Tipo do Imóvel (Ex: Apartamento)<br>
      					- Referência<br>
      					- Finalidade<br>
      					- Valor<br>
      					- Valor Carnaval<br>
      					- Valor Ano Novo<br>
      					- Distância do Mar<br>
      					- Área Construída<br>
      					- Localização<br>
      					- Bairro<br>
      					- Endereço Completo (Tipo Logradouro + Endereco + Número)<br>
      					- Complemento<br>
      					- CEP<br>
      					- Bairro<br>
      					- N° de Garagem<br>
      					- Condomínio Fechado (S/N)<br>
      					- Cobertura (S/N)<br>
      					- Mobilado (S/N)<br>
      					- Observações 02
						</td>
    				</tr> 
					<tr class="fundoTabela">
          				<td width="30%" class="style1" align="left"><b>Tipo de Exportação:</b></td>
          				<td width="70%" class="style1"><input type="radio" name="tipo_exportacao" class="campo" id="tipo_exportacao" value="1" checked>Exportar imóveis desta lista<input type="radio" name="tipo_exportacao" class="campo" id="tipo_exportacao" value="2">Exportar todos imóveis desta imobiliária</td>
					</tr>          		
					<tr class="fundoTabela">
						<td width="30%" class="style1">&nbsp;</td>
          				<td width="70%" class="style1"><input type="submit" value="Gerar TXT" name="gerar_txt" id="gerar_txt" class="campo3" onClick="form1.action=\'gerar_imoveis_txt.php?id_anuncio='.$id_anuncio.'\';"></td>
        			</tr>
        			<tr>
  						<td>&nbsp;</td>
					<tr>
        		</td></table>
        	</tr>
	  ';	
	}
?>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr class="fundoTabelaTitulo">
          <td width="15%" class="style1"><b>Data</b></td>
          <td width="20%" class="style1"><b>Veículo</b></td>
          <!--td width="20%" class="style1"><div align="center"><b>Inclusão</b></div></td-->
          <td width="15%" class="style1"><div align="center"><b>Visualiza&ccedil;&atilde;o</b></div></td>
          <td width="15%" class="style1"><div align="center"><b>Exclus&atilde;o</b></div></td>
          <!--td width="15%" class="style1"><div align="center"><b>Mailling</b></td-->
        </tr>
        <?
        	$k = 0;
		    $busca2 = mysql_query("SELECT id_anuncio, data_anuncio, veiculo_anuncio, ta_nome FROM anuncios 
		    left join rebri_tipo_anuncios on ta_cod=veiculo_anuncio 
		    WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY data_anuncio ASC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){
					if ($k++ % 2 == 0) { $fundo = 'fundoTabelaCor1'; } else { $fundo = 'fundoTabelaCor2'; }
					echo "<tr class=\"$fundo\">";
      				echo('
            				<td class="style1">'.formataDataDoBd($linha2['data_anuncio']).'</td>
            				<td class="style1">'.$linha2['ta_nome'].'</td>
     				        <!--td class="style1"><div align="center"><a href="cadastro_anuncios2.php?id='.$linha2['id_anuncio'].'&cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'&adicionar=S" class="style1">[ + ] Adicionar Imóveis</a></div></td-->
            				<td class="style1"><div align="center"><a href="cadastro_anuncios2.php?id='.$linha2['id_anuncio'].'&cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'" class="style1">Visualizar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['id_anuncio'].', \''.$cod.'\', \''.$rel.'\', \''.$data_inicial.'\', \''.$data_final.'\')" class="style1">Excluir</a></div></td>
            				<!--td class="style1"><div align="center"><a href="p_mailing.php?anuncio='.$linha2['id_anuncio'].'&rel='.$rel.'" class="style1">Enviar</a></div></td-->
            			</tr>
	   				');
    			}
  			}
  			else
    		{
	       		echo('
	        		<tr>
            			<td colspan="6" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            		</tr>
	   			');
			}	
       ?>
      </table></td>
    </tr>
    <tr height="50">
      <td colspan="2"><div align="center">
<? 
	if($rel=='S'){
?>
	 <input type="button" name="fechar" id="fechar" class="campo3" value="Fechar Janela" Onclick="window.close();">
<?
	}
?>
      </div></td>
    </tr>
	</table>
<?
mysql_close($con);
?>
</form>
<? if($rel<>'S'){ ?>
<?  if(session_is_registered("valid_user")){ ?>
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
<? } ?>
</body>
</html>