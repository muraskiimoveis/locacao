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
verificaArea("RELAT_ANUNCIOS");
?>
<html>
<head>
<?

//VERIFICA SE DATA FOI DIGITADA OU FOI MANTIDA CONFORME BUSCA
if(empty( $_POST['data_inicial']) && empty($_POST['data_final'])){

	$_datai = ("01/" . date( "m/Y" ));
	$_dataf = date("d/m/Y");

	$_POST['data_inicial'] = $_datai;
	$_POST['data_final'] = $_dataf;

}


?>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
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

function VerificaCampo(){

//declara as variaveis
	var datai,dataf,_datai,_dataf,msdatai,msdataf;

//pega valores do campo
	datai = document.getElementById('data_inicial').value;
	dataf = document.getElementById('data_final').value;

//retira a barra
	_datai = datai.split("/");
	_dataf = dataf.split("/");

//transforma a data e milisegundos
	msdatai = Date.parse(setStrMonth(_datai[1])+' '+_datai[0]+', '+_datai[2]);
	msdataf = Date.parse(setStrMonth(_dataf[1])+' '+_dataf[0]+', '+_dataf[2]);

//verifica se data inicial é maior que a final
	if(msdatai > msdataf){
		alert("Data inicial maior que a Data final!");
		return false;
	}
	
var msgErro = '';

	   if(document.form1.data_inicial.value.length==0)
       {
            msgErro += "Por favor, preencha o campo Data Inicial.\n"; 
       }
       if(document.form1.data_final.value.length==0)
       {
            msgErro += "Por favor, preencha o campo Data Final.\n"; 
       }
       if(msgErro != '')
	   {
	        alert(msgErro);
	        return false;
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
<br>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){

*/	  
if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}
 
	$busca = mysql_query("SELECT cod, ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $co_imovel = $linha['cod'];
       $nome_imovel = "Ref.:".$linha['ref']." - ".$linha['titulo'];
	} 
?>
<form id="form1" name="form1" method="post" action="p_rel_anuncios.php">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1"><div align="center"><b>Relat&oacute;rio de An&uacute;ncios </b><br><br>
          <b><a href="cadastro_anuncios.php?rel=R&cod=<?php echo($co_imovel); ?>&data_inicial=<?php echo($_POST['data_inicial']); ?>&data_final=<? echo($_POST['data_final']); ?>" class=style1>Inserir an&uacute;ncios </a></b><br />
        Preencha o per&iacute;odo que voc&ecirc; deseja visualizar o relat&oacute;rio e clique em pesquisar.</div></td>
    </tr>
  <tr>
    <td colspan="2" class="style1"><b>Per&iacute;odo:</b>
          <input type="text" name="data_inicial" id="data_inicial" size="12" class="campo" maxlenght="10" value="<?= $_POST['data_inicial'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_inicial', '##/##/####', event);" onChange="ValidaData(this.value)">
          <b>&agrave;</b>
          <input type="text" name="data_final" id="data_final" size="12" class="campo" maxlenght="10" value="<?= $_POST['data_final'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_final', '##/##/####', event);" onChange="ValidaData(this.value)">
  </td>
    </tr>
    <tr>
      <td width="30%" class="style1"><b>Imóvel:</b>
        <input type="text" name="co_imovel" size="5" class="campo2" value="<?php print($co_imovel); ?>" readonly>
        <input type="text" name="nome_imovel" size="80" class="campo" value='<?php print($nome_imovel); ?>' readonly>
        <input type="button" id="selecionar" name="selecionar" value="Selecionar" class="campo" onClick="window.open('list_imoveis.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
      </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="hidden" name="buscar" id="buscar" value="0">
        <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo" onClick="VerificaCampo();">
      </div></td>
    </tr>
    <? 
        //REALIZA BUSCA APÓS PRESSIONAR O BOTAO "PESQUISAR"
    	if($_POST['buscar']){
    	   $buscar = $_POST['buscar'];
    	}elseif($_GET['buscar']){
		   $buscar = $_GET['buscar'];
		}
		
		
		if($buscar=='1'){ 
    	  
    	  if($_POST['data_inicial']){
    	   $data1 = formataDataParaBd($_POST['data_inicial']);
    	  }elseif($_GET['data_inicial']){
		   $data1 = formataDataParaBd($_GET['data_inicial']);
		  } 
		  
		  if($_POST['data_final']){
    	   $data2 = formataDataParaBd($_POST['data_final']);
    	  }elseif($_GET['data_final']){
		   $data2 = formataDataParaBd($_GET['data_final']);
		  } 
		  
		  if($_POST['co_imovel']){
    	   $co_imovel = $_POST['co_imovel'];
    	  }elseif($_GET['co_imovel']){
		   $co_imovel = $_GET['co_imovel'];
		  } 
    	  
    	  $data2 = formataDataParaBd($_POST['data_final']);
    	  if($_POST['co_imovel']){
    	   $co_imovel = $_POST['co_imovel'];
    	  }elseif($_GET['co_imovel']){
		   $co_imovel = $_GET['co_imovel'];
		  } 
    	  
    	  
    	  if($co_imovel!=''){
		  	$buscai = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$co_imovel."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    	  	while($linha = mysql_fetch_array($buscai)){
       			$nomeimovel = "Ref.: ".$linha['ref']." - ".$linha['titulo'];
		  	}
		  }
    	  	  
	?>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><b>Per&iacute;odo:</b> <?= $_POST['data_inicial']; ?> &agrave; <?= $_POST['data_final']; ?>
      <br>
      <b>Im&oacute;vel:</b> <? if($co_imovel!=''){ echo($nomeimovel); }else{ echo "Todos"; } ?></td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?
          //REALIZA BUSCA SE O IMOVÉL FOI SELECIONADO
		  if($co_imovel<>''){	
					
			echo('
				<tr>
       				<td width="21%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Data</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="11%" class="style1"><b>Ve&iacute;culo</b></td>
                </tr>
			');
				    //REALIZA A BUSCA DE ANÚNCIOS ATRAVÉS DE UM PERÍODO E REALIZA A SOMA TOTAL DOS ANÚNCIOS
					$buscaa = mysql_query("SELECT a.cod_imovel, DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.valor_anuncio, a.veiculo_anuncio, m.ref, m.titulo, i.im_cod, i.nome_pasta, i.im_nome FROM anuncios a INNER JOIN muraski m ON (a.cod_imovel=m.cod) INNER JOIN rebri_imobiliarias i ON (a.cod_imobiliaria=i.im_cod) WHERE a.cod_imovel='".$co_imovel."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio, m.titulo ASC");
					if(mysql_num_rows($buscaa) > 0){
						$total = 0;
						while($linha = mysql_fetch_array($buscaa)){
							echo ("
								<tr>
          							<td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".$linha['titulo']."</a></td>
          							<td class=\"style1\">".$linha['data_anuncio']."</td>
          							<td class=\"style1\">".number_format($linha['valor_anuncio'],2,',','.')."</td>
          							<td class=\"style1\">".$linha['veiculo_anuncio']."</td>
        						</tr>
							");
						$total++;
						}
		
						echo("
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".$total." anúncio(s)</td>
    						</tr>
						");
					}else{
	       				echo('
	        			<tr>
            				<td colspan="6" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            			</tr>
	   					');
					}
		}
		//REALIZA BUSCA SE O IMÓVEL NÃO FOI SELECIONADO
		if($co_imovel==''){
		  
		  echo('
				<tr>
       				<td width="21%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Data</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="11%" class="style1"><b>Ve&iacute;culo</b></td>
                </tr>
			');
				    //REALIZA A BUSCA DE ANÚNCIOS ATRAVÉS DE UM PERÍODO E REALIZA A SOMA TOTAL DOS ANÚNCIOS
					$buscaa = mysql_query("SELECT a.cod_imovel, DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.valor_anuncio, a.veiculo_anuncio, m.ref, m.titulo, i.im_cod, i.nome_pasta, i.im_nome FROM anuncios a INNER JOIN muraski m ON (a.cod_imovel=m.cod) INNER JOIN rebri_imobiliarias i ON (a.cod_imobiliaria=i.im_cod) WHERE a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio, m.titulo ASC");
					if(mysql_num_rows($buscaa) > 0){
						$total = 0;
						while($linha = mysql_fetch_array($buscaa)){
							echo ("
								<tr>
          							<td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".$linha['titulo']."</a></td>
          							<td class=\"style1\">".$linha['data_anuncio']."</td>
          							<td class=\"style1\">".number_format($linha['valor_anuncio'],2,',','.')."</td>
          							<td class=\"style1\">".$linha['veiculo_anuncio']."</td>
        						</tr>
							");
						$total++;
						}
		
						echo("
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".$total." anúncio(s)</td>
    						</tr>
						");
					}else{
	       				echo('
	        			<tr>
            				<td colspan="6" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            			</tr>
	   					');
					}
		}
		?>
  </table>
<?
}
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
