<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
if($_GET['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_ANUNCIOS");

if($_GET['pdf']=='1'){
  
$data_hora = date("d_m_Y_H_i_s");
$arquivo = "anuncios_".$data_hora.".doc";

header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: application/msword; name=$arquivo");
header ( "Content-Disposition: attachment; filename=$arquivo");    
  
//$html8 .='<link href="style.css" rel="stylesheet" type="text/css" />';

if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}
 
	$busca = mysql_query("SELECT cod, ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $co_imovel = $linha['cod'];
       $nome_imovel = "Ref.:".$linha['ref']." - ".strip_tags($linha['titulo']);
	} 

  	$html8 .='<table width="750" border="0" align="center" cellpadding="1" cellspacing="1">';

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
    	  
    	  $data2 = formataDataParaBd($_GET['data_final']);
    	  
		  if($_POST['co_imovel']){
    	   $co_imovel = $_POST['co_imovel'];
    	  }elseif($_GET['co_imovel']){
		   $co_imovel = $_GET['co_imovel'];
		  } 
		  
		  if($_POST['veiculo']){
    	   $veiculo = $_POST['veiculo'];
    	  }elseif($_GET['veiculo']){
		   $veiculo = $_GET['veiculo'];
		  } 
    	  
    	  
    	  if($co_imovel!=''){
		  	$buscai = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$co_imovel."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    	  	while($linha = mysql_fetch_array($buscai)){
       			$nomeimovel = "Ref.: ".$linha['ref']." - ".strip_tags($linha['titulo']);
		  	}
		  }
		  
	if($co_imovel<>''){
	   $imovel = $nomeimovel;  
	}else{
	   $imovel = "Todos";  
	}
	
	if($veiculo<>''){
	   $meio_com = $veiculo;  
	}else{
	   $meio_com = "Todos";  
	}	  
    	  	  
    $html8 .='<tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><b>Per&iacute;odo:</b> '.$data_inicial.' &agrave; '.$data_final.'
      <br>
      <b>Im&oacute;vel: </b> '.$imovel.'<br><b>Tipo:</b> '.$meio_com.'</td>
    </tr>    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">';

          //REALIZA BUSCA SE O IMOVÉL FOI SELECIONADO
		  if($co_imovel<>''){	
					
			$html8 .='
				<tr>
       				<td width="10%" class="style1"><b>Data</b></td>
	                <td width="11%" class="style1"><b>Ve&iacute;culo</b></td>
                </tr>
			';
				    //REALIZA A BUSCA DE ANÚNCIOS ATRAVÉS DE UM PERÍODO E REALIZA A SOMA TOTAL DOS ANÚNCIOS
			if($veiculo<>'Todos'){
					$buscaa = mysql_query("SELECT DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio, i.im_cod, i.nome_pasta, i.im_nome FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN rebri_imobiliarias i ON (a.cod_imobiliaria=i.im_cod) WHERE a.veiculo_anuncio='".$veiculo."' AND ia.cod_imovel='".$co_imovel."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					if(mysql_num_rows($buscaa) > 0){
						$total = 0;
						while($linha = mysql_fetch_array($buscaa)){
							$html8 .='<tr>
          							<td class="style1">'.$linha['data_anuncio'].'</td>
          							<td class="style1">'.$linha['veiculo_anuncio'].'</td>
        						</tr>
							';
						$total++;
						}
						
		
						$html8 .='
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan="2" class="style1"><b>Total: </b>'.$total.' anúncio(s)</td>
    						</tr>
						';
					}else{
	       				$html8 .='
	        			<tr>
            				<td colspan="6" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            			</tr>
	   					';
					}
			}else{
			  		$buscaa = mysql_query("SELECT DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio, i.im_cod, i.nome_pasta, i.im_nome FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN rebri_imobiliarias i ON (a.cod_imobiliaria=i.im_cod) WHERE ia.cod_imovel='".$co_imovel."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					if(mysql_num_rows($buscaa) > 0){
						$total = 0;
						while($linha = mysql_fetch_array($buscaa)){
							$html8 .='
								<tr>
          							<td class="style1">'.$linha['data_anuncio'].'</td>
          							<td class="style1">'.$linha['veiculo_anuncio'].'</td>
        						</tr>
							';
						$total++;
						}
						
		
						$html8 .='
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan="2" class="style1"><b>Total: </b>'.$total.' anúncio(s)</td>
    						</tr>
						';
					}else{
	       				$html8 .='
	        			<tr>
            				<td colspan="6" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            			</tr>
	   					';
					}
			}
		}elseif($co_imovel==''){
		//REALIZA BUSCA SE O IMÓVEL NÃO FOI SELECIONADO
		
		  
		  $html8 .='
				<tr>
       				<td class="style1"><b>Im&oacute;vel</b></td>
       			</tr>
       			<tr>
       				<td class="style1"><b>Data</b></td>
	                <td class="style1"><b>Ve&iacute;culo</b></td>
                </tr>
                <tr>
       				<td class="style1" colspan="2"><hr></td>
       			</tr>
			';
				    //REALIZA A BUSCA DE ANÚNCIOS ATRAVÉS DE UM PERÍODO E REALIZA A SOMA TOTAL DOS ANÚNCIOS
			if($veiculo<>'Todos'){
				    $buscaa = mysql_query("SELECT DISTINCT m.cod, m.ref, m.titulo, DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN muraski m ON (ia.cod_imovel=m.cod) WHERE a.veiculo_anuncio='".$veiculo."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					while($linha = mysql_fetch_array($buscaa)){
							$html8 .='
					            <tr>
       								<td class="style1"><b>'.$linha['ref'].' - '.strip_tags($linha['titulo']).'</b></td>
       							</tr>
								<tr>
          							<td class="style1">'.$linha['data_anuncio'].'</td>
          							<td class="style1">'.$linha['veiculo_anuncio'].'</td>
        						</tr>
        						<tr>
       								<td class="style1" colspan="2"><hr></td>
       							</tr>
							';
					$total++;
					}
			}else{
			  		$buscaa = mysql_query("SELECT DISTINCT m.cod, m.ref, m.titulo, DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN muraski m ON (ia.cod_imovel=m.cod) WHERE a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					while($linha = mysql_fetch_array($buscaa)){
							$html8 .='
					            <tr>
       								<td class="style1"><b>'.$linha['ref'].' - '.strip_tags($linha['titulo']).'</b></td>
       							</tr>
								<tr>
          							<td class="style1">'.$linha['data_anuncio'].'</td>
          							<td class="style1">'.$linha['veiculo_anuncio'].'</td>
        						</tr>
        						<tr>
       								<td class="style1" colspan="2"><hr></td>
       							</tr>
							';
					$total++;
					}
			}
			
					$html8 .='</table></td>
    						</tr>
    						<tr>
      							<td colspan="2" class="style1"><b>Total: </b>'.$total.' anúncio(s)</td>
    						</tr>
						';
}

  		$html8 .='</table>';
	}

echo $html8;

/*
$data_hora8 = date("d_m_Y_H_i_s");
$arquivo8 = "anuncios_".$data_hora8.".pdf";

require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html8);
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();
$dompdf->stream($arquivo8);
*/
 
}

?>
<? if($_GET['pdf']<>'1'){ ?>
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
       if (document.form1.veiculo.selectedIndex == 0)
	   {
	        msgErro += "Por favor, selecione o campo Tipo.\n";
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
       $nome_imovel = "Ref.:".$linha['ref']." - ".strip_tags($linha['titulo']);
	} 
?>
<form id="form1" name="form1" method="post" action="p_rel_anuncios.php">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1"><div align="center"><b>Relat&oacute;rio de An&uacute;ncios </b><br><br>
          <b><a href="cadastro_anuncios2.php?rel=R&cod=<?php echo($co_imovel); ?>&data_inicial=<?php echo($_POST['data_inicial']); ?>&data_final=<? echo($_POST['data_final']); ?>" class=style1>Editar an&uacute;ncios </a></b><br />
        Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar</div></td>
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
        <input type="button" id="selecionar" name="selecionar" value="Selecionar" class="campo3" onClick="window.open('list_imoveis.php', 'janela', 'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
      </td>
    </tr>
	<tr>
      <td width="30%" class="style1"><b>Tipo:</b>
         <select name="veiculo" id="veiculo" class="campo">
        	<option value="">Selecione</option>
        	<option value="Todos" <? if($veiculo=='Todos'){ echo "SELECTED";  } ?>>Todos</option>
        <?php
        	$veiculos = mysql_query("SELECT veiculo_anuncio FROM anuncios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY veiculo_anuncio ORDER BY veiculo_anuncio ASC");
 			while($linha = mysql_fetch_array($veiculos)){
				if($linha[veiculo_anuncio]==$_POST['veiculo_anuncio']){
					echo('<option value="'.$linha['veiculo_anuncio'].'" SELECTED>'.$linha['veiculo_anuncio'].'</option>');
				}else{ 			   
					echo('<option value="'.$linha['veiculo_anuncio'].'">'.$linha['veiculo_anuncio'].'</option>');
				}
 			}
 	?>
 	  </select>
      </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="hidden" name="buscar" id="buscar" value="0">
        <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="VerificaCampo();">
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
		  
		  if($_POST['veiculo']){
    	   $veiculo = $_POST['veiculo'];
    	  }elseif($_GET['veiculo']){
		   $veiculo = $_GET['veiculo'];
		  } 
    	  
    	  
    	  if($co_imovel!=''){
		  	$buscai = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$co_imovel."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    	  	while($linha = mysql_fetch_array($buscai)){
       			$nomeimovel = "Ref.: ".$linha['ref']." - ".strip_tags($linha['titulo']);
		  	}
		  }
    	  	  
	?>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><b>Per&iacute;odo:</b> <?= $_POST['data_inicial']; ?> &agrave; <?= $_POST['data_final']; ?>
      <br>
      <b>Im&oacute;vel:</b> <? if($co_imovel!=''){ echo($nomeimovel); }else{ echo "Todos"; } ?><br><b>Tipo:</b> <? if($veiculo!=''){ echo($veiculo); }else{ echo "Todos"; } ?></td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?
          //REALIZA BUSCA SE O IMOVÉL FOI SELECIONADO
		  if($co_imovel<>''){	
					
			echo('
				<tr>
       				<td width="10%" class="style1"><b>Data</b></td>
	                <td width="11%" class="style1"><b>Ve&iacute;culo</b></td>
                </tr>
			');
				    //REALIZA A BUSCA DE ANÚNCIOS ATRAVÉS DE UM PERÍODO E REALIZA A SOMA TOTAL DOS ANÚNCIOS
			if($veiculo<>'Todos'){
					$buscaa = mysql_query("SELECT DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio, i.im_cod, i.nome_pasta, i.im_nome FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN rebri_imobiliarias i ON (a.cod_imobiliaria=i.im_cod) WHERE a.veiculo_anuncio='".$veiculo."' AND ia.cod_imovel='".$co_imovel."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					if(mysql_num_rows($buscaa) > 0){
						$total = 0;
						while($linha = mysql_fetch_array($buscaa)){
							echo ("
								<tr>
          							<!--td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</a></td-->
          							<td class=\"style1\">".$linha['data_anuncio']."</td>
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
			}else{
			  		$buscaa = mysql_query("SELECT DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio, i.im_cod, i.nome_pasta, i.im_nome FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN rebri_imobiliarias i ON (a.cod_imobiliaria=i.im_cod) WHERE ia.cod_imovel='".$co_imovel."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					if(mysql_num_rows($buscaa) > 0){
						$total = 0;
						while($linha = mysql_fetch_array($buscaa)){
							echo ("
								<tr>
          							<!--td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</a></td-->
          							<td class=\"style1\">".$linha['data_anuncio']."</td>
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
		}elseif($co_imovel==''){
		//REALIZA BUSCA SE O IMÓVEL NÃO FOI SELECIONADO
		
		  
		  echo('
				<tr>
       				<td class="style1"><b>Im&oacute;vel</b></td>
       			</tr>
       			<tr>
       				<td class="style1"><b>Data</b></td>
	                <td class="style1"><b>Ve&iacute;culo</b></td>
                </tr>
                <tr>
       				<td class=\"style1\" colspan=\"2\"><hr></td>
       			</tr>
			');
				    //REALIZA A BUSCA DE ANÚNCIOS ATRAVÉS DE UM PERÍODO E REALIZA A SOMA TOTAL DOS ANÚNCIOS
			if($veiculo<>'Todos'){
				    $buscaa = mysql_query("SELECT DISTINCT m.cod, m.ref, m.titulo, DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN muraski m ON (ia.cod_imovel=m.cod) WHERE a.veiculo_anuncio='".$veiculo."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					while($linha = mysql_fetch_array($buscaa)){
							echo ("
					            <tr>
       								<td class=\"style1\"><b>".$linha['ref']." - ".strip_tags($linha['titulo'])."</b></td>
       							</tr>
								<tr>
          							<!--td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</a></td-->
          							<td class=\"style1\">".$linha['data_anuncio']."</td>
          							<td class=\"style1\">".$linha['veiculo_anuncio']."</td>
        						</tr>
        						<tr>
       								<td class=\"style1\" colspan=\"2\"><hr></td>
       							</tr>
							");
					$total++;
					}
			}else{
			  		$buscaa = mysql_query("SELECT DISTINCT m.cod, m.ref, m.titulo, DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN muraski m ON (ia.cod_imovel=m.cod) WHERE a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					while($linha = mysql_fetch_array($buscaa)){
							echo ("
					            <tr>
       								<td class=\"style1\"><b>".$linha['ref']." - ".strip_tags($linha['titulo'])."</b></td>
       							</tr>
								<tr>
          							<!--td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</a></td-->
          							<td class=\"style1\">".$linha['data_anuncio']."</td>
          							<td class=\"style1\">".$linha['veiculo_anuncio']."</td>
        						</tr>
        						<tr>
       								<td class=\"style1\" colspan=\"2\"><hr></td>
       							</tr>
							");
					$total++;
					}
			}
			
			echo("
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".$total." anúncio(s)</td>
    						</tr>
						");
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
<? if($_POST['buscar']){ ?>
<form method="post" name="form2" id="form2" action="">
<table width="100%">
<tr>
	<td colspan="2" align="center"><span class="style1">
		<input type="button" value="Visualizar" name="visualizar" id="visualizar" class="campo3" onClick="NewWindow('','uprelatorio','800','600','yes');form2.target='uprelatorio';form2.action='anuncios_impressao.php?data1=<?=$data1 ?>&data2=<?=$data2 ?>&co_imovel=<?=$co_imovel ?>&veiculo=<?=$veiculo ?>&buscar=1';form2.submit();"></form>
		<form name="form3" id="form3" method="post" action="p_rel_anuncios.php"><input type="submit" value="Exportar para DOC" name="exportar" id="exportar" class="campo3" onClick="form3.action='p_rel_anuncios.php?pdf=1&data_inicial=<?=$data_inicial ?>&data_final=<?=$data_final ?>&data1=<?=$data1 ?>&data2=<?=$data2 ?>&co_imovel=<?=$co_imovel ?>&veiculo=<?=$veiculo ?>&buscar=1';"></form>
		<form name="form4" id="form4" method="post" action="gerar_txt_anuncio.php"><input type="submit" value="Gerar TXT" name="gerar_txt" id="gerar_txt" class="campo3" onClick="form4.action='gerar_txt_anuncio.php?data1=<?=$data1 ?>&data2=<?=$data2 ?>&co_imovel=<?=$co_imovel ?>&veiculo=<?=$veiculo ?>&buscar=1';"></form>
		<form name="form5" id="form5" method="post" action="gerar_xml_anuncio.php"><input type="submit" value="Gerar XML" name="gerar_xml" id="gerar_xml" class="campo3" onClick="form5.action='gerar_xml_anuncio.php?data1=<?=$data1 ?>&data2=<?=$data2 ?>&co_imovel=<?=$co_imovel ?>&veiculo=<?=$veiculo ?>&buscar=1';"></form>
	</span></td>
</tr>
</table>

<? } ?>
</body>
</html>
<? } ?>