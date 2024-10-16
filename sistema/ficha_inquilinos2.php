<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("no_cache.inc.php");
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("REL_CLIENTES");
verificaArea("CLIENT_GERAL");

if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}

if($_GET['codloc']){
 $codloc = $_GET['codloc'];
}else{
 $codloc = $_POST['codloc'];
}

if($_GET['l_cod']){
 $l_cod = $_GET['l_cod'];
}else{
 $l_cod = $_POST['l_cod'];
}

		$buscam = mysql_query("SELECT cliente, contador, ref, tipo_logradouro, end, numero, condominio, apto FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    	while($linha = mysql_fetch_array($buscam))
       	{
	  		$con_ref_inquilino = $linha['ref']." -  ".$linha['condominio']." - ".$linha['tipo_logradoruo']." ".$linha['end'].", ".$linha['numero'];
	  		$ap_inquilino = $linha['apto'];   
			$contador = $linha['contador'];   
	  		$cliente1 = explode("--", $linha['cliente']);
	  		$cliente2 = str_replace("-","",$cliente1);
		}

?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script type="text/javascript" src="funcoes/bibliotecaAjax.js"></script>
<script type="text/javascript" src="funcoes/formulario.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function confirmaExclusao(id,cod,codloc,l_cod)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='ficha_inquilinos2.php?id_excluir=' + id + '&cod=' + cod + '&codloc=' + codloc + '&l_cod=' + l_cod;
}


function setStrMonth(month){
	switch(month){
		case '01' :
			return 'Jan';
		case '02' :
			return 'Feb';
		case '03' :
			return 'Mar';
		case '04' :
			return 'Apr';
		case '05' :
			return 'May';
		case '06' :
			return 'Jun';
		case '07' :
			return 'Jul';
		case '08' :
			return 'Aug';
		case '09' :
			return 'Sep';
		case '10' :
			return 'Oct';
		case '11' :
			return 'Nov';
		case '12' :
			return 'Dec';
		default:
			break;
	}
	
	return false;
}


function VerificaCampo()
{

//declara as variaveis
	var datai,dataf,_datai,_dataf,msdatai,msdataf;

//pega valores do campo
	datai = document.getElementById('entrada_inquilino').value;
	dataf = document.getElementById('saida_inquilino').value;

//retira a barra
	_datai = datai.split("/");
	_dataf = dataf.split("/");

//transforma a data e milisegundos
	msdatai = Date.parse(setStrMonth(_datai[1])+' '+_datai[0]+', '+_datai[2]);
	msdataf = Date.parse(setStrMonth(_dataf[1])+' '+_dataf[0]+', '+_dataf[2]);

//verifica se data inicial é maior que a final
	if(msdatai > msdataf){
		alert("Entrada maior que a Saída!");
		return false;
	}


var msg = '';

	   if(document.form1.con_ref_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Condomínio do Edifício/referência.\n";
	   }
	   if(document.form1.ap_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Ap.\n";
	   }
<? 	for($i = 1; $i <= $contador; $i++){ ?>	   
	   if(document.form1.prop_inquilino_<?=$i ?>.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Proprietário.\n";
	   }
<? } ?>
	   if(document.form1.resp_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Responsável.\n";
	   }
	   if(document.form1.fone_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Telefone.\n";
	   }
	   if(document.form1.rg_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo RG.\n";
	   }
	   if(document.form1.cpf_inquilino.value.length==0)
	   {
		       msg += "Por favor, preencha o campo CPF.\n";
       }
       else if(!isCPF(RemoveMascaraCPF(document.form1.cpf_inquilino.value)))
       {
               msg += "O CPF digitado é inválido.\n";       
	   }
	   if(document.form1.data_nasc_inquilino.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data Nasc.\n";
       }
	   if(document.form1.cidade_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Cidade.\n";
	   }
	   if(document.form1.estado_inquilino.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Estado.\n";
	   }
	   if(document.form1.entrada_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Entrada.\n";
	   }
	   if(document.form1.saida_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Saída.\n";
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

//declara as variaveis
	var datai,dataf,_datai,_dataf,msdatai,msdataf;

//pega valores do campo
	datai = document.getElementById('entrada_inquilino').value;
	dataf = document.getElementById('saida_inquilino').value;

//retira a barra
	_datai = datai.split("/");
	_dataf = dataf.split("/");

//transforma a data e milisegundos
	msdatai = Date.parse(setStrMonth(_datai[1])+' '+_datai[0]+', '+_datai[2]);
	msdataf = Date.parse(setStrMonth(_dataf[1])+' '+_dataf[0]+', '+_dataf[2]);

//verifica se data inicial é maior que a final
	if(msdatai > msdataf){
		alert("Entrada maior que a Saída!");
		return false;
	}


var msg = '';

	   if(document.form1.con_ref_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Condomínio do Edifício/referência.\n";
	   }
	   if(document.form1.ap_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Ap.\n";
	   }
<? 	for($i = 1; $i <= $contador; $i++){ ?>	   
	   if(document.form1.prop_inquilino_<?=$i ?>.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Proprietário.\n";
	   }
<? } ?>
	   if(document.form1.resp_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Responsável.\n";
	   }
	   if(document.form1.fone_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Telefone.\n";
	   }
	   if(document.form1.rg_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo RG.\n";
	   }
	   if(document.form1.cpf_inquilino.value.length==0)
	   {
		       msg += "Por favor, preencha o campo CPF.\n";
       }
       else if(!isCPF(RemoveMascaraCPF(document.form1.cpf_inquilino.value)))
       {
               msg += "O CPF digitado é inválido.\n";       
	   }
	   if(document.form1.data_nasc_inquilino.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data Nasc.\n";
       }
	   if(document.form1.cidade_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Cidade.\n";
	   }
	   if(document.form1.estado_inquilino.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Estado.\n";
	   }
	   if(document.form1.entrada_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Entrada.\n";
	   }
	   if(document.form1.saida_inquilino.value.length==0)
	   {
	          msg += "Por favor, preencha o campo Saída.\n";
	   }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.atualiza.value='1';
			document.form1.submit();
	   }

}

</script>
</head>

<body>
<?php   

if($_GET['id']==''){
	$id = $_POST['id'];
}elseif($_POST['id']==''){
  	$id = $_GET['id'];
}

$remover = $_GET['remover'];

if($remover=='V'){
  	
  	$apagar_veiculos = "DELETE FROM veiculos_inquilino WHERE id_veiculo='".$_GET['id_veiculo']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";   		
	mysql_query($apagar_veiculos, $con);
	
	echo('<script language="javascript">alert("Veículo excluído com sucesso!");document.location.href="ficha_inquilinos2.php?id='.$id.'&cod='.$cod.'&codloc='.$codloc.'&l_cod='.$l_cod.'";</script>');	
  
}elseif($remover=='A'){
  
  	$apagar_acompanhantes = "DELETE FROM acompanhantes_inquilino WHERE id_acompanhante='".$_GET['id_acompanhante']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";   		
	mysql_query($apagar_acompanhantes, $con);
	
	echo('<script language="javascript">alert("Acompanhante excluído com sucesso!");document.location.href="ficha_inquilinos2.php?id='.$id.'&cod='.$cod.'&codloc='.$codloc.'&l_cod='.$l_cod.'";</script>');	
  
}

       	
       	$buscal = mysql_query("SELECT l_data_ent, l_data_sai FROM locacao WHERE l_cod='".$l_cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
       	while($linha = mysql_fetch_array($buscal)){   
		  	$entrada_inquilino = formataDataDoBd($linha['l_data_ent']);
       		$saida_inquilino = formataDataDoBd($linha['l_data_sai']);
       	}

		$buscap = mysql_query("SELECT c_nome, c_tel, c_cidade, c_estado, c_rg, c_cpf, c_nasc FROM clientes WHERE c_cod='".$codloc."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    	while($linha = mysql_fetch_array($buscap)){
       		$resp_inquilino = $linha['c_nome'];
       		$fone_inquilino = $linha['c_tel'];
       		$rg_inquilino = $linha['c_rg'];
       		$cpf_inquilino = $linha['c_cpf'];
       		$cidade_inquilino = $linha['c_cidade'];
       		$estado_inquilino = $linha['c_estado'];
       		$data_nasc_inquilino = formataDataDoBd($linha['c_nasc']);
            //$idade_inquilino = calc_idade($data_nasc);
       }

if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		
		$con_ref_inquilino = $_POST['con_ref_inquilino'];
   		$ap_inquilino = $_POST['ap_inquilino'];
   		$prop_inquilino = $_POST['prop_inquilino'];
   		$resp_inquilino = $_POST['resp_inquilino'];
   		$fone_inquilino = $_POST['fone_inquilino'];
   		$rg_inquilino = $_POST['rg_inquilino'];
   		$cpf_inquilino = formataCPFParaBd($_POST['cpf_inquilino']);
        $data_nasc_inquilino = formataDataParaBd($_POST['data_nasc_inquilino']);
        $cidade_inquilino = $_POST['cidade_inquilino'];
        $estado_inquilino = $_POST['estado_inquilino'];
   		$entrada_inquilino = formataDataParaBd($_POST['entrada_inquilino']);
   		$saida_inquilino = formataDataParaBd($_POST['saida_inquilino']);
   		$data_inquilino = date("Y-m-d");
   		
   		$SQL = "SELECT * FROM ficha_inquilinos WHERE con_ref_inquilino='".$con_ref_inquilino."' AND ap_inquilino='".$ap_inquilino."' AND prop_inquilino='".$prop_inquilino."' AND resp_inquilino='".$resp_inquilino."' AND entrada_inquilino='".$entrada_inquilino."' AND saida_inquilino='".$saida_inquilino."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe um Condomínio de Edifício/referência com esse Ap., Proprietário, Responsável e Entrada e Saída registrado";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"ficha_inquilinos2.php?cod=".$cod."&codloc=".$codloc."&l_cod=".$l_cod."\";</script>"; 
		}
		else
		{
			$w = $_POST['contp'];
			for($c = 1; $c < $w; $c++)
			{     
	 		   $proprietarios = "prop_inquilino_".$c;	
	 		   if($c == 1){
				$prop_inquilino .= $_POST[$proprietarios];  
			   }else{
			    $prop_inquilino .= " e ".$_POST[$proprietarios];
			   }
     		}
     		
			$inserir = "INSERT INTO ficha_inquilinos (cod_imobiliaria, con_ref_inquilino, ap_inquilino, prop_inquilino, resp_inquilino, fone_inquilino, rg_inquilino, cpf_inquilino, data_nasc_inquilino, cidade_inquilino, estado_inquilino, entrada_inquilino, saida_inquilino, data_inquilino) VALUES ('".$_SESSION['cod_imobiliaria']."','".$con_ref_inquilino."','".$ap_inquilino."','".$prop_inquilino."','".$resp_inquilino."','".$fone_inquilino."','".$rg_inquilino."','".$cpf_inquilino."','".$data_nasc_inquilino."','".$cidade_inquilino."','".$estado_inquilino."','".$entrada_inquilino."','".$saida_inquilino."','".$data_inquilino."')";   		
			mysql_query($inserir, $con);
			$inserir = mysql_insert_id();
   			
			$x = $_POST['cont2'];
			for($v = 1; $v <= $x; $v++)
			{     
	 			$veiculosi = "veiculo_inquilino_".$v;
     			$veiculoi = $_POST[$veiculosi];    	     	
				$coresi = "cor_inquilino_".$v;
     			$cori = $_POST[$coresi];
     			$placasi = "placa_inquilino_".$v;
     			$placai = $_POST[$placasi];
     			$cidadesi = "cidade_veiculo_inquilino_".$v;
     			$cidadei = $_POST[$cidadesi];
				 
				mysql_query("INSERT INTO veiculos_inquilino (cod_imobiliaria, id_inquilino, veiculo_inquilino, cor_inquilino, placa_inquilino, cidade_veiculo_inquilino) VALUES ('".$_SESSION['cod_imobiliaria']."','".$inserir."','".$veiculoi."','".$cori."','".$placai."','".$cidadei."')");   		      	
     		}   
			
			$i = $_POST['cont'];
			for($j = 1; $j <= $i; $j++)
			{     
	 			$nacompanhantes = "nome_acompanhante_".$j;
     			$nomeacompanhante = $_POST[$nacompanhantes];    	     	
				$iacompanhantes = "idade_acompanhante_".$j;
     			$idadeacompanhante = $_POST[$iacompanhantes];
				 
				mysql_query("INSERT INTO acompanhantes_inquilino (cod_imobiliaria, id_inquilino, nome_acompanhante, idade_acompanhante) VALUES ('".$_SESSION['cod_imobiliaria']."','".$inserir."','".$nomeacompanhante."','".$idadeacompanhante."')");   		      	
     		}   		
				echo('<script language="javascript">alert("Cadastro efetuado com sucesso!");document.location.href="ficha_inquilinos2.php?cod='.$cod.'&codloc='.$codloc.'&l_cod='.$l_cod.'";</script>');	
   		}
}

if($_POST['atualiza']=='1')
{
   		
		$con_ref_inquilino = $_POST['con_ref_inquilino'];
   		$ap_inquilino = $_POST['ap_inquilino'];
   		$prop_inquilino = $_POST['prop_inquilino'];
   		$resp_inquilino = $_POST['resp_inquilino'];
   		$fone_inquilino = $_POST['fone_inquilino'];
   		$rg_inquilino = $_POST['rg_inquilino'];
   		$cpf_inquilino = formataCPFParaBd($_POST['cpf_inquilino']);
        $data_nasc_inquilino = formataDataParaBd($_POST['data_nasc_inquilino']);
        $cidade_inquilino = $_POST['cidade_inquilino'];
        $estado_inquilino = $_POST['estado_inquilino'];
   		$entrada_inquilino = formataDataParaBd($_POST['entrada_inquilino']);
   		$saida_inquilino = formataDataParaBd($_POST['saida_inquilino']);
   		$data_inquilino = date("Y-m-d");
   		
   		$w = $_POST['contp'];
		for($c = 1; $c < $w; $c++)
		{     
	 	   $proprietarios = "prop_inquilino_".$c;	
	 	   	if($c == 1){
				$prop_inquilino .= $_POST[$proprietarios];  
		   	}else{
				$prop_inquilino .= " e ".$_POST[$proprietarios];
			}
     	}
   		
   		$atualizar = "UPDATE ficha_inquilinos SET con_ref_inquilino='".$con_ref_inquilino."', ap_inquilino='".$ap_inquilino."', prop_inquilino='".$prop_inquilino."', resp_inquilino='".$resp_inquilino."', fone_inquilino='".$fone_inquilino."', rg_inquilino='".$rg_inquilino."', cpf_inquilino='".$cpf_inquilino."', data_nasc_inquilino='".$data_nasc_inquilino."', cidade_inquilino='".$cidade_inquilino."', estado_inquilino='".$estado_inquilino."', entrada_inquilino='".$entrada_inquilino."', saida_inquilino='".$saida_inquilino."', data_inquilino='".$data_inquilino."' WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";   		
		mysql_query($atualizar, $con);
		
		$apagar_veiculos = "DELETE FROM veiculos_inquilino WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";   		
		mysql_query($apagar_veiculos, $con);
		
		$apagar_acompanhantes = "DELETE FROM acompanhantes_inquilino WHERE id_inquilino='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";   		
		mysql_query($apagar_acompanhantes, $con);
   			
			$x = $_POST['conta_veiculo'];
			for($v = 1; $v <= $x; $v++)
			{     
	 			$veiculosi = "veiculo_inquilino_".$v;
     			$veiculoi = $_POST[$veiculosi];    	     	
				$coresi = "cor_inquilino_".$v;
     			$cori = $_POST[$coresi];
     			$placasi = "placa_inquilino_".$v;
     			$placai = $_POST[$placasi];
     			$cidadesi = "cidade_veiculo_inquilino_".$v;
     			$cidadei = $_POST[$cidadesi];
				 
				mysql_query("INSERT INTO veiculos_inquilino (cod_imobiliaria, id_inquilino, veiculo_inquilino, cor_inquilino, placa_inquilino, cidade_veiculo_inquilino) VALUES ('".$_SESSION['cod_imobiliaria']."','".$id."','".$veiculoi."','".$cori."','".$placai."','".$cidadei."')");   		      	
     		}
			
			$i = $_POST['conta_acompanhante'];
			for($j = 1; $j <= $i; $j++)
			{     
	 			$nacompanhantes = "nome_acompanhante_".$j;
     			$nomeacompanhante = $_POST[$nacompanhantes];    	     	
				$iacompanhantes = "idade_acompanhante_".$j;
     			$idadeacompanhante = $_POST[$iacompanhantes];
				 
				mysql_query("INSERT INTO acompanhantes_inquilino (cod_imobiliaria, id_inquilino, nome_acompanhante, idade_acompanhante) VALUES ('".$_SESSION['cod_imobiliaria']."','".$id."','".$nomeacompanhante."','".$idadeacompanhante."')");   		      	
     		}   		
				echo('<script language="javascript">alert("Cadastro atualizado com sucesso!");document.location.href="ficha_inquilinos2.php?cod='.$cod.'&codloc='.$codloc.'&l_cod='.$l_cod.'";</script>');	
}

		if($id){
			$alteracao = mysql_query("SELECT * FROM ficha_inquilinos f WHERE f.id_inquilino='".$id."' AND f.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    		while($linha = mysql_fetch_array($alteracao)){
       			$id_inquilino = $linha['id_inquilino'];
       			$con_ref_inquilino = $linha['con_ref_inquilino'];
       			$ap_inquilino = $linha['ap_inquilino'];
       			$prop_inquilino = $linha['prop_inquilino'];
       			$resp_inquilino = $linha['resp_inquilino'];
       			$fone_inquilino = $linha['fone_inquilino'];
       			$rg_inquilino = $linha['rg_inquilino'];
       			$cpf_inquilino = $linha['cpf_inquilino'];
       			$data_nasc_inquilino = formataDataDoBd($linha['data_nasc_inquilino']);
       			$cidade_inquilino = $linha['cidade_inquilino'];
       			$estado_inquilino = $linha['estado_inquilino'];     			
       			$entrada_inquilino = formataDataDoBd($linha['entrada_inquilino']);
       			$saida_inquilino = formataDataDoBd($linha['saida_inquilino']);
    			
    		}
		}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
        $apagar_veiculos = "DELETE FROM veiculos_inquilino WHERE id_inquilino='".$id_exluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";   		
		mysql_query($apagar_veiculos, $con);
		
		$apagar_acompanhantes = "DELETE FROM acompanhantes_inquilino WHERE id_inquilino='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";   		
		mysql_query($apagar_acompanhantes, $con);
        
   		$exclusao = "DELETE FROM ficha_inquilinos WHERE id_inquilino='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";   		
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Cadastro excluído com sucesso!");document.location.href="ficha_inquilinos2.php?cod='.$cod.'&codloc='.$codloc.'&l_cod='.$l_cod.'";</script>');	
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="ficha_inquilinos2.php?cod='.$cod.'&codloc='.$codloc.'&l_cod='.$l_cod.'";</script>');	
   		}
}
	  
?>
<form id="form1" name="form1" method="post" action="ficha_inquilinos2.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="codloc" id="codloc" value="<?=$codloc ?>">
<input type="hidden" name="l_cod" id="l_cod" value="<?=$l_cod ?>">
<input type="hidden" name="id" id="id" value="<?=$id ?>">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="3" class="style1"><div align="center"><b>Ficha de registro de inquilinos </b></div></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Condom&iacute;nio do Edif&iacute;cio/refer&ecirc;ncia:</b></td>
      <td width="80%" colspan="2" class="style1"><input type="text" name="con_ref_inquilino" size="60" class="campo" value="<?php print($con_ref_inquilino); ?>" readonly></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Ap.:</b></td>
      <td colspan="2" class="style1"><input type="text" name="ap_inquilino" id="ap_inquilino" size="5" class="campo" value="<? if($_POST['ap_inquilino']){ print $_POST['ap_inquilino']; }else{ print $ap_inquilino; } ?>"></td>
    </tr>
<? 
	for($x = 1; $x <= $contador; $x++){ 
	  
	  $queryC = "select * from clientes where c_cod='".$cliente2[$x-1]."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	  $resultC = mysql_query($queryC);
	  while($notC = mysql_fetch_array($resultC))
	  {
	  		$proprietario = $notC[c_nome];
	  }
  	  echo('
	   	<tr class="fundoTabela">
      		<td class="style1"><b>Propriet&aacute;rio:</b></td>
      		<td colspan="2" class="style1">
      ');    
?>      
	   <input type="text" name="prop_inquilino_<?=$x ?>" size="40" class="campo" value="<?=$proprietario ?>" readonly>
<?			    
	  echo('
    	</td></tr>
	 ');
		   	
    }  
?>   
	<input type="hidden" name="contp" id="contp" value="<?=$x ?>">	
    <tr class="fundoTabela">
      <td class="style1"><b>Respons&aacute;vel:</b></td>
      <td colspan="4" class="style1"><input type="text" name="resp_inquilino" size="40" class="campo" value="<?=$resp_inquilino; ?>" readonly>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Telefone:</b></td>
      <td colspan="2" class="style1"><input name="fone_inquilino" id="fone_inquilino" type="text" class="campo" size="13" maxlength="13" value="<? if($_POST['fone_inquilino']){ print $_POST['fone_inquilino']; }else{ print $fone_inquilino; } ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>RG:</b></td>
      <td colspan="2" class="style1"><input name="rg_inquilino" id="rg_inquilino" type="text" class="campo" size="10" value="<? if($_POST['rg_inquilino']){ print $_POST['rg_inquilino']; }else{ print $rg_inquilino; } ?>" onKeyPress="return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>CPF:</b></td>
      <td colspan="2" class="style1"><input name="cpf_inquilino" id="cpf_inquilino" type="text" class="campo" size="14" maxlength="14" value="<? if($_POST['cpf_inquilino']){ print $_POST['cpf_inquilino']; }else{ print $cpf_inquilino; } ?>" onKeyPress="return (Mascara(this,event,'###.###.###-##'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Data Nasc.:</b></td>
      <td colspan="2" class="style1"><input name="data_nasc_inquilino" id="data_nasc_inquilino" type="text" class="campo" size="12" maxlength="10" value="<? if($_POST['data_nasc_inquilino']){ print $_POST['data_nasc_inquilino']; }else{ print $data_nasc_inquilino; } ?>" onKeyPress="return (Mascara(this,event,'##/##/####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Cidade:</b></td>
      <td colspan="2" class="style1"><input type="text" name="cidade_inquilino" id="cidade_inquilino" size="40" class="campo" value="<? if($_POST['cidade_inquilino']){ print $_POST['cidade_inquilino']; }else{ print $cidade_inquilino; } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Estado:</b></td>
      <td colspan="2" class="style1"><select name="estado_inquilino" id="estado_inquilino" class="campo">
        <option value="0">Selecione</option>
        <option value="AC" <? if($_POST['estado_inquilino']=='AC'){ print "SELECTED"; }elseif($estado_inquilino=='AC'){ print "SELECTED"; } ?>>AC</option>
        <option value="AL" <? if($_POST['estado_inquilino']=='AL'){ print "SELECTED"; }elseif($estado_inquilino=='AL'){ print "SELECTED"; } ?>>AL</option>
        <option value="AM" <? if($_POST['estado_inquilino']=='AM'){ print "SELECTED"; }elseif($estado_inquilino=='AM'){ print "SELECTED"; } ?>>AM</option>
        <option value="AP" <? if($_POST['estado_inquilino']=='AP'){ print "SELECTED"; }elseif($estado_inquilino=='AP'){ print "SELECTED"; } ?>>AP</option>
        <option value="BA" <? if($_POST['estado_inquilino']=='BA'){ print "SELECTED"; }elseif($estado_inquilino=='BA'){ print "SELECTED"; } ?>>BA</option>
        <option value="CE" <? if($_POST['estado_inquilino']=='CE'){ print "SELECTED"; }elseif($estado_inquilino=='CE'){ print "SELECTED"; } ?>>CE</option>
        <option value="DF" <? if($_POST['estado_inquilino']=='DF'){ print "SELECTED"; }elseif($estado_inquilino=='DF'){ print "SELECTED"; } ?>>DF</option>
        <option value="ES" <? if($_POST['estado_inquilino']=='ES'){ print "SELECTED"; }elseif($estado_inquilino=='ES'){ print "SELECTED"; } ?>>ES</option>
        <option value="GO" <? if($_POST['estado_inquilino']=='GO'){ print "SELECTED"; }elseif($estado_inquilino=='GO'){ print "SELECTED"; } ?>>GO</option>
        <option value="MA" <? if($_POST['estado_inquilino']=='MA'){ print "SELECTED"; }elseif($estado_inquilino=='MA'){ print "SELECTED"; } ?>>MA</option>
        <option value="MG" <? if($_POST['estado_inquilino']=='MG'){ print "SELECTED"; }elseif($estado_inquilino=='MG'){ print "SELECTED"; } ?>>MG</option>
        <option value="MS" <? if($_POST['estado_inquilino']=='MS'){ print "SELECTED"; }elseif($estado_inquilino=='MS'){ print "SELECTED"; } ?>>MS</option>
        <option value="MT" <? if($_POST['estado_inquilino']=='MT'){ print "SELECTED"; }elseif($estado_inquilino=='MT'){ print "SELECTED"; } ?>>MT</option>
        <option value="PA" <? if($_POST['estado_inquilino']=='PA'){ print "SELECTED"; }elseif($estado_inquilino=='PA'){ print "SELECTED"; } ?>>PA</option>
        <option value="PB" <? if($_POST['estado_inquilino']=='PB'){ print "SELECTED"; }elseif($estado_inquilino=='PB'){ print "SELECTED"; } ?>>PB</option>
        <option value="PE" <? if($_POST['estado_inquilino']=='PE'){ print "SELECTED"; }elseif($estado_inquilino=='PE'){ print "SELECTED"; } ?>>PE</option>
        <option value="PI" <? if($_POST['estado_inquilino']=='PI'){ print "SELECTED"; }elseif($estado_inquilino=='PI'){ print "SELECTED"; } ?>>PI</option>
        <option value="PR" <? if($_POST['estado_inquilino']=='PR'){ print "SELECTED"; }elseif($estado_inquilino=='PR'){ print "SELECTED"; } ?>>PR</option>
        <option value="RJ" <? if($_POST['estado_inquilino']=='RJ'){ print "SELECTED"; }elseif($estado_inquilino=='RJ'){ print "SELECTED"; } ?>>RJ</option>
        <option value="RN" <? if($_POST['estado_inquilino']=='RN'){ print "SELECTED"; }elseif($estado_inquilino=='RN'){ print "SELECTED"; } ?>>RN</option>
        <option value="RO" <? if($_POST['estado_inquilino']=='RO'){ print "SELECTED"; }elseif($estado_inquilino=='RO'){ print "SELECTED"; } ?>>RO</option>
        <option value="RR" <? if($_POST['estado_inquilino']=='RR'){ print "SELECTED"; }elseif($estado_inquilino=='RR'){ print "SELECTED"; } ?>>RR</option>
        <option value="RS" <? if($_POST['estado_inquilino']=='RS'){ print "SELECTED"; }elseif($estado_inquilino=='RS'){ print "SELECTED"; } ?>>RS</option>
        <option value="SC" <? if($_POST['estado_inquilino']=='SC'){ print "SELECTED"; }elseif($estado_inquilino=='SC'){ print "SELECTED"; } ?>>SC</option>
        <option value="SE" <? if($_POST['estado_inquilino']=='SE'){ print "SELECTED"; }elseif($estado_inquilino=='SE'){ print "SELECTED"; } ?>>SE</option>
        <option value="SP" <? if($_POST['estado_inquilino']=='SP'){ print "SELECTED"; }elseif($estado_inquilino=='SP'){ print "SELECTED"; } ?>>SP</option>
        <option value="TO" <? if($_POST['estado_inquilino']=='TO'){ print "SELECTED"; }elseif($estado_inquilino=='TO'){ print "SELECTED"; } ?>>TO</option>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Entrada:</b></td>
      <td colspan="2" class="style1"><input type="text" name="entrada_inquilino" id="entrada_inquilino" size="12" maxlength="10" class="campo" value="<? if($_POST['entrada_inquilino']){ print $_POST['entrada_inquilino'];  }else{ print $entrada_inquilino; } ?>" onKeyPress="return txtBoxFormat(document.form1, 'entrada_inquilino', '##/##/####', event);" onChange="ValidaData(this.value)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Sa&iacute;da:</b></td>
      <td colspan="2" class="style1"><input type="text" name="saida_inquilino" id="saida_inquilino" size="12" maxlength="10" class="campo" value="<? if($_POST['saida_inquilino']){ print $_POST['saida_inquilino']; }else{ print $saida_inquilino; } ?>" onKeyPress="return txtBoxFormat(document.form1, 'saida_inquilino', '##/##/####', event);" onChange="ValidaData(this.value)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1" colspan="3"><b>Veículo(s): N° de campos: </b><select name="cont2" id="cont2" class="campo" onChange="form1.action='ficha_inquilinos2.php';form1.submit();">
		  <option value="">Selecione</option>
          <option value="1" <? if($cont2=='1'){ print "SELECTED"; } ?>>+1</option>
          <option value="2" <? if($cont2=='2'){ print "SELECTED"; } ?>>+2</option>
          <option value="3" <? if($cont2=='3'){ print "SELECTED"; } ?>>+3</option>
          <option value="4" <? if($cont2=='4'){ print "SELECTED"; } ?>>+4</option>
          <option value="5" <? if($cont2=='5'){ print "SELECTED"; } ?>>+5</option>
          </select></td>
    </tr>
    <tr class="fundoTabela">
      <td colspan="3" class="style1" align="center"> 
	  <? 
		if($id){	
				$queryV = "SELECT * FROM veiculos_inquilino WHERE id_inquilino='".$id_inquilino."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$resultV = mysql_query($queryV);
				$ve = 1;
				while($notV = mysql_fetch_array($resultV))
				{
	   				$veiculo_inquilinob = $notV['veiculo_inquilino'];
	   				$cor_inquilinob = $notV['cor_inquilino'];
	   				$placa_inquilinob = $notV['placa_inquilino'];
	   				$cidade_veiculo_inquilinob = $notV['cidade_veiculo_inquilino'];	
				
				
			   		echo("
			   			Veículo: <input type=\"text\" name=\"veiculo_inquilino_$ve\" id=\"veiculo_inquilino_$ve\" size=\"25\" class=\"campo\" value=\"".$veiculo_inquilinob."\"> 
           				Cor: <input type=\"text\" name=\"cor_inquilino_$ve\" id=\"cor_inquilino_$ve\" size=\"10\" class=\"campo\" value=\"".$cor_inquilinob."\">
           				Placa: <input type=\"text\" name=\"placa_inquilino_$ve\" id=\"placa_inquilino_$ve\" size=\"8\" maxlegth=\"8\" class=\"campo\" value=\"".$placa_inquilinob."\">
           				Cidade: <input type=\"text\" name=\"cidade_veiculo_inquilino_$ve\" id=\"cidade_veiculo_inquilino_$ve\" size=\"25\" class=\"campo\" value=\"".$cidade_veiculo_inquilinob."\"> <a href=\"ficha_inquilinos2.php?id=".$id."&id_veiculo=".$notV['id_veiculo']."&cod=".$cod."&codloc=".$codloc."&l_cod=".$l_cod."&remover=V\" class=\"style1\"> Remover</a><br>
					");
				$ve++;
			 	}	
	  		}  
	  
	  
	  	if($_POST['cont2']){
	  	  	if($ve == ''){
				$ve = 1;
			}
	  	  
		     for($j = $ve; $j < ($_POST['cont2']+$ve); $j++){
		       
				$veiculos = "veiculo_inquilino_".$j;
	    		$veiculo_inquilino = $_POST[$veiculos];
	    		$cores = "cor_inquilino_".$j;
	    		$cor_inquilino = $_POST[$cores];
	    		$placas = "placa_inquilino_".$j;
	    		$placa_inquilino = $_POST[$placas];
	    		$cidades = "cidade_veiculo_inquilino_".$j;
	    		$cidade_veiculo_inquilino = $_POST[$cidades];

			   echo("
			   		Veículo: <input type=\"text\" name=\"veiculo_inquilino_$j\" id=\"veiculo_inquilino_$j\" size=\"25\" class=\"campo\" value=\"".$veiculo_inquilino."\">
           			Cor: <input type=\"text\" name=\"cor_inquilino_$j\" id=\"cor_inquilino_$j\" size=\"10\" class=\"campo\" value=\"".$cor_inquilino."\">
           			Placa: <input type=\"text\" name=\"placa_inquilino_$j\" id=\"placa_inquilino_$j\" size=\"8\" maxlength=\"8\" class=\"campo\" value=\"".$placa_inquilino."\">
           			Cidade: <input type=\"text\" name=\"cidade_veiculo_inquilino_$j\" id=\"cidade_veiculo_inquilino_$j\" size=\"25\" class=\"campo\" value=\"".$cidade_veiculo_inquilino."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
			   ");
			 }  
	   }
?>
		<input type="hidden" name="conta_veiculo" id="conta_veiculo" value="<? if($j == 0){ print ($ve-1); }else{ print ($j-1); } ?>">
      </td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1" colspan="3"><b>Acompanhante(s): N° de campos: </b><select name="cont" id="cont" class="campo" onChange="form1.action='ficha_inquilinos2.php?cod=<?=$cod ?>&codloc=<?=$codloc ?>&l_cod=<?=$l_cod ?>';form1.submit();">
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
    </tr>
    <tr class="fundoTabela">
      <td colspan="3" class="style1" align="center"> 
<? 
	  		if($id){	
				$queryA = "SELECT * FROM acompanhantes_inquilino WHERE id_inquilino='".$id_inquilino."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$resultA = mysql_query($queryA);
				$a = 1;
				while($notA = mysql_fetch_array($resultA))
				{
	   				$nome_acompanhanteb = $notA['nome_acompanhante'];
	   				$idade_acompanhanteb = $notA['idade_acompanhante'];
				
			   		echo("
			   			Nome: <input type=\"text\" name=\"nome_acompanhante_$a\" id=\"nome_acompanhante_$a\" size=\"40\" class=\"campo\" value=\"".$nome_acompanhanteb."\">
           				Idade: <input type=\"text\" name=\"idade_acompanhante_$a\" id=\"idade_acompanhante_$a\" size=\"3\" maxlength=\"3\" class=\"campo\" value=\"".$idade_acompanhanteb."\"> <a href=\"ficha_inquilinos2.php?id=".$id."&id_acompanhante=".$notA['id_acompanhante']."&cod=".$cod."&codloc=".$codloc."&l_cod=".$l_cod."&remover=A\" class=\"style1\"> Remover</a><br>
					");
				$a++;
			 	}	
			}
		  
			if($_POST['cont']){
			  	if($a == ''){
			   		$a = 1;
				}	
			  
		     for($i = $a; $i < ($_POST['cont']+$a); $i++){
		       
				$nomes = "nome_acompanhante_".$i;
	    		$nome_acompanhante = $_POST[$nomes];
	    		$idades = "idade_acompanhante_".$i;
	    		$idade_acompanhante = $_POST[$idades];

			   echo("
			   		Nome: <input type=\"text\" name=\"nome_acompanhante_$i\" id=\"nome_acompanhante_$i\" size=\"40\" class=\"campo\" value=\"".$nome_acompanhante."\">
           			Idade: <input type=\"text\" name=\"idade_acompanhante_$i\" id=\"idade_acompanhante_$i\" size=\"3\" maxlength=\"3\" class=\"campo\" value=\"".$idade_acompanhante."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
			   ");
			 }  
		   }
?>
		<input type="hidden" name="conta_acompanhante" id="conta_acompanhante" value="<? if($i == 0){ print ($a-1); }else{ print ($i-1); } ?>">
      </td>
    </tr>
    <tr>
      <td colspan="3" class="style1"> 
<?
	if(empty($id)){
?>      
       	<input type="hidden" name="cadastra" id="cadastra" value="0">
       	<input type="button" name="incluir" id="incluir" class="campo3" value="Incluir" Onclick="VerificaCampo();">
       	<input type="button" name="limpar" id="limpar" class="campo3" value="Limpar" Onclick="window.location.href='ficha_inquilinos2.php?cod=<?=$cod; ?>&codloc=<?=$codloc; ?>&l_cod=<?=$l_cod; ?>'">
<?
	}else{
?>       
		<input type="hidden" name="atualiza" id="atualiza" value="0">
       	<input type="button" name="atualizar" id="atualizar" class="campo3" value="Atualizar" Onclick="VerificaCampo2();">
       	<input type="button" name="cancelar" id="cancelar" class="campo3" value="Cancelar" Onclick="window.location.href='ficha_inquilinos2.php?cod=<?=$cod; ?>&codloc=<?=$codloc; ?>&l_cod=<?=$l_cod ?>'">
<?
	}	
?>	             	
		</td>
    </tr>
	<tr height="15px">
    	<td>&nbsp;</td>
    </tr>	
    <tr>
      <td colspan="3"><table width="100%" border="0" cellpadding="1" cellspacing="1">
          <tr class="fundoTabelaTitulo">
            <td width="35%" class="style1"><b>Condom&iacute;nio</b></td>
            <td width="10%" class="style1"><b>Ap.</b></td>
            <td width="25%" class="style1"><b>Respons&aacute;vel</b></td>
            <td width="10%" class="style1"><div align="center"><b>Alteração</b></div></td>
            <td width="10%" class="style1"><div align="center"><b>Exclusão</b></div></td>
            <td width="10%" class="style1"><div align="center"><b>Impress&atilde;o</b></div></td>
          </tr>
          <?
          	$i = 0;
            $busca2 = mysql_query("SELECT id_inquilino, con_ref_inquilino, ap_inquilino, resp_inquilino FROM ficha_inquilinos WHERE con_ref_inquilino='".$con_ref_inquilino."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY data_inquilino ASC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){
				if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
				$i++;

      				echo("
	        			<tr class=\"$fundo\">
            				<td class=\"style1\">".$linha2['con_ref_inquilino']."</td>
            				<td class=\"style1\">".$linha2['ap_inquilino']."</td>
            				<td class=\"style1\">".$linha2['resp_inquilino']."</td>
            				<td class=\"style1\"><div align=\"center\"><a href=\"ficha_inquilinos2.php?id=".$linha2['id_inquilino']."&cod=".$cod."&codloc=".$codloc."&l_cod=".$l_cod."\" class=\"style1\">Alterar</a></div></td>
            				<td class=\"style1\"><div align=\"center\"><a href=\"javascript:confirmaExclusao(".$linha2['id_inquilino'].",".$cod.",".$codloc.",".$l_cod.")\" class=\"style1\">Excluir</a></div></td>
							<td class=\"style1\"><div align=\"center\"><a href=\"#\" onClick=\"NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='impressao_ficha_inquilinos.php?id=".$linha2['id_inquilino']."&popup=S';form1.submit();\" class=\"style1\">Visualizar</a></div></td>
            			</tr>
	   				");
    			}
  			}
  			else
    		{
	       		echo('
	        		<tr class="fundoTabela">
            			<td colspan="6" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            		</tr>
	   			');
			}
       ?>
      </table></td>
    </tr>
	</table>
<?
mysql_close($con);	
?>
</form>
</body>
</html>