<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_ANUNC");

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

if($rel=='R'){ 
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
<br>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(id,cod,rel,data_inicial,data_final)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='cadastro_anuncios.php?id_excluir=' + id + '&cod=' + cod + '&rel=' + rel + '&data_inicial=' + data_inicial + '&data_final=' + data_final;
}



function VerificaCampo()
{

var msg = '';

	   if(document.form1.co_imovel.value.length==0)
	   {
		       msg += "Por favor, selecione o campo Imóvel.\n";
       }
       if(document.form1.data.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data.\n";
       }
       if(document.form1.valor_anuncio.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Valor.\n";
       }
       if (document.form1.veiculo.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Veículo.\n";
	   }
	   else if(document.form1.veiculo.value=='Outros')
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

	   if(document.form1.co_imovel.value.length==0)
	   {
		       msg += "Por favor, selecione o campo Imóvel.\n";
       }
       if(document.form1.data.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data.\n";
       }
       if(document.form1.valor_anuncio.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Valor.\n";
       }
       if (document.form1.veiculo.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Veículo.\n";
	   }
	   else if(document.form1.veiculo.value=='Outros')
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
</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
 
	if($cod<>''){
		$busca = mysql_query("SELECT cod, ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    	while($linha = mysql_fetch_array($busca)){
       		$co_imovel = $linha['cod'];
       		$nome_imovel = "Ref.:".$linha['ref']." - ".$linha['titulo'];
		} 
	}else{
	    $busca = mysql_query("SELECT m.cod, m.ref, m.titulo FROM muraski m INNER JOIN anuncios a ON (a.cod_imovel=m.cod) WHERE a.id_anuncio='".$_GET['id']."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    	while($linha = mysql_fetch_array($busca)){
       		$co_imovel = $linha['cod'];
       		$nome_imovel = "Ref.:".$linha['ref']." - ".$linha['titulo'];
		} 
	}


if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		
   		$co_imovel = $_POST['co_imovel'];
		$data = formataDataParaBd($_POST['data']);
   		$valor_anuncio = str_replace(".", "", $_POST['valor_anuncio']);
   		if($_POST['veiculo']=='Outros'){
   		   	$veiculo = $_POST['veiculo']." - ".$_POST['qual'];
   		}else{
			$veiculo = $_POST['veiculo'];
		}
   		
   		$SQL = "SELECT data_anuncio FROM anuncios WHERE cod_imovel='".$co_imovel."' AND data_anuncio='".$data."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe esse imóvel com essa data cadastrada!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"cadastro_anuncios.php?cod=".$cod."&rel=".$rel."&data_inicial=".$data_inicial."&data_final=".$data_final."\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO anuncios (cod_imobiliaria, cod_imovel, data_anuncio, valor_anuncio, veiculo_anuncio) VALUES ('".$_SESSION['cod_imobiliaria']."','".$co_imovel."','".$data."', '".$valor_anuncio."', '".$veiculo."')";   		
   			if(mysql_query($inserir))
			{
				echo('<script language="javascript">alert("Cadastro efetuado com sucesso!");document.location.href="cadastro_anuncios.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="cadastro_anuncios.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   			}
   		}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT id_anuncio, data_anuncio, valor_anuncio, veiculo_anuncio FROM anuncios WHERE id_anuncio='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_anuncio = $linha['id_anuncio'];
       $data = formataDataDoBd($linha['data_anuncio']);
       $valor_anuncio = number_format($linha['valor_anuncio'], 2, ',', '.');
  	   list($veiculo, $qual) = explode(" - ", $linha['veiculo_anuncio']);
    }
}

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
     
			$atualizacao = "UPDATE anuncios SET data_anuncio='".$data."', valor_anuncio='".$valor_anuncio."', veiculo_anuncio='".$veiculo."' WHERE id_anuncio='".$id_anuncio."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Cadastro alterado com sucesso!");document.location.href="cadastro_anuncios.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="cadastro_anuncios.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   			}
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
   		$exclusao = "DELETE FROM anuncios WHERE id_anuncio='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Cadastro excluído com sucesso!");document.location.href="cadastro_anuncios.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="cadastro_anuncios.php?cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'";</script>');
   		}
}
	  
?>
<form id="form1" name="form1" method="post" action="cadastro_anuncios.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="data_inicial" id="data_inicial" value="<?=$data_inicial ?>">
<input type="hidden" name="data_final" id="data_final" value="<?=$data_final ?>">
<input type="hidden" name="rel" id="rel" value="<?=$rel ?>">
<input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo($id_anuncio); ?>">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1"><div align="center"><b>Inserir An&uacute;ncios</b><br />
      </div></td>
    </tr>
    <tr>
      <td width="141" class="style1"><b>Im&oacute;vel:</b></td>
        <td width="602" class="style1">
			<input type="text" name="co_imovel" size="5" class="campo2" value="<?php print($co_imovel); ?>" readonly>
        	<input type="text" name="nome_imovel" size="80" class="campo" value='<?php print($nome_imovel); ?>' readonly>
<? if($cod==''){ ?>        	
        	<input type="button" id="selecionar" name="selecionar" value="Selecionar" class="campo" onClick="window.open('list_imoveis.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">		</td>
<? } ?>
    </tr>
    <tr>
      <td class="style1"><b>Data:</b></td>
      <td class="style1">
        <input type="text" name="data" id="data" size="12" maxlength="10" class="campo" value="<?=$data; ?>" onKeyPress="return txtBoxFormat(document.form1, 'data', '##/##/####', event);" onChange="ValidaData(this.value)">      </td>
    </tr>
    <tr>
      <td class="style1"><b>Valor:</b></td>
      <td class="style1">
        <input type="text" name="valor_anuncio" id="valor_anuncio" size="15" class="campo" value="<?=$valor_anuncio; ?>" onKeydown="Formata(this,20,event,2)">      </td>
    </tr>
    <tr>
      <td class="style1"><b>Ve&iacute;culo:</b></td>
      <td class="style1">
        <select name="veiculo" id="veiculo" class="campo" onChange="form1.submit();">
          <option selected value="">Selecione um ve&iacute;culo</option>
          <option value="Internet" <? if($veiculo=='Internet'){ echo "SELECTED"; } ?>>Internet</option>
		  <option value="Jornal" <? if($veiculo=='Jornal'){ echo "SELECTED"; } ?>>Jornal</option>
		  <option value="Outdoor" <? if($veiculo=='Outdoor'){ echo "SELECTED"; } ?>>Outdoor</option>
          <option value="Panfleto" <? if($veiculo=='Panfleto'){ echo "SELECTED"; } ?>>Panfleto</option>
          <option value="Rádio" <? if($veiculo=='Rádio'){ echo "SELECTED"; } ?>>Rádio</option>
          <option value="TV" <? if($veiculo=='TV'){ echo "SELECTED"; } ?>>TV</option>
          <option value="Revista" <? if($veiculo=='Revista'){ echo "SELECTED"; } ?>>Revista</option>
          <option value="Outros" <? if($veiculo=='Outros'){ echo "SELECTED"; } ?>>Outros</option>
        </select>
        <?
		 if($veiculo=='Outros'){ ?>
        <b>Qual?</b>
        <input type="text" name="qual" id="qual" size="30" class="campo" value="<?=$qual; ?>">
        <? } ?>      </td>
    </tr>	
    <tr>
      <td>&nbsp;</td>
      <td><? 
	  	if(empty($id_anuncio))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo\" value=\"Limpar\" Onclick=\"window.location.href='cadastro_anuncios.php?cod=".$cod."&rel=".$rel."&data_inicial=".$data_inicial."&data_final=".$data_final."'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo\" value=\"Cancelar\" Onclick=\"window.location.href='cadastro_anuncios.php?cod=".$cod."&rel=".$rel."&data_inicial=".$data_inicial."&data_final=".$data_final."'\">
		  ");		
        } 
	  ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td width="13%" class="TdSubTitulo"><b>Data</b></td>
          <td width="13%" class="TdSubTitulo"><b>Valor</b></td>
          <td width="14%" class="TdSubTitulo"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
          <td width="14%" class="TdSubTitulo"><div align="center"><b>Exclus&atilde;o</b></div></td>
        </tr>
        <?
        if($cod<>''){
            $busca2 = mysql_query("SELECT id_anuncio, data_anuncio, valor_anuncio FROM anuncios WHERE cod_imovel='".$co_imovel."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY data_anuncio ASC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){

      				echo('
	        			<tr>
            				<td class="style1">'.formataDataDoBd($linha2['data_anuncio']).'</td>
            				<td class="style1">'.number_format($linha2['valor_anuncio'], 2, ',', '.').'</td>
            				<td class="style1"><div align="center"><a href="cadastro_anuncios.php?id='.$linha2['id_anuncio'].'&cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['id_anuncio'].', '.$cod.', \''.$rel.'\', \''.$data_inicial.'\', \''.$data_final.'\')" class="style1">Excluir</a></div></td>
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
		}else{
		    $busca2 = mysql_query("SELECT id_anuncio, data_anuncio, valor_anuncio FROM anuncios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY data_anuncio ASC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){

      				echo('
	        			<tr>
            				<td class="style1">'.formataDataDoBd($linha2['data_anuncio']).'</td>
            				<td class="style1">'.number_format($linha2['valor_anuncio'], 2, ',', '.').'</td>
            				<td class="style1"><div align="center"><a href="cadastro_anuncios.php?id='.$linha2['id_anuncio'].'&cod='.$cod.'&rel='.$rel.'&data_inicial='.$data_inicial.'&data_final='.$data_final.'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['id_anuncio'].', \''.$cod.'\', \''.$rel.'\', \''.$data_inicial.'\', \''.$data_final.'\')" class="style1">Excluir</a></div></td>
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
		}
       ?>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
<? if($rel=='R'){ ?>
     <input type="button" name="voltar" id="voltar" class="campo" value="Voltar" OnClick="form1.action='p_rel_anuncios.php?co_imovel=<?=$cod; ?>&data_inicial=<?=$data_inicial; ?>&data_final=<?=$data_final; ?>&buscar=1';form1.submit();">
<? }else{ ?>
     <input type="button" name="fechar" id="fechar" class="campo" value="Fechar Janela" Onclick="window.close();">
<? } ?>    
      </div></td>
    </tr>
	</table>
<?
mysql_close($con);
/*
	}else{
		include("login2.php");
	}
*/
?>
</form>
</body>
</html>