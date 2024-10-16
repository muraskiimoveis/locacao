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
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
	<style media="print">
		.noprint { display: none }
	</style>
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
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
  	<tr height="50">
    	<td colspan="2" class="style1"><div align="center"><b>Relat&oacute;rio de An&uacute;ncios </b><br></div></td>
  	</tr>
    <? 
        //REALIZA BUSCA APÓS PRESSIONAR O BOTAO "PESQUISAR"
    	if($_POST['buscar']){
    	   $buscar = $_POST['buscar'];
    	}elseif($_GET['buscar']){
		   $buscar = $_GET['buscar'];
		}
		
		
		if($buscar=='1'){ 
    	  
    	  if($_POST['data1']){
    	   $data1 = formataDataParaBd($_POST['data1']);
    	  }elseif($_GET['data1']){
		   $data1 = formataDataParaBd($_GET['data1']);
		  } 

		  
		  if($_POST['data2']){
    	   $data2 = formataDataParaBd($_POST['data2']);
    	  }elseif($_GET['data2']){
		   $data2 = formataDataParaBd($_GET['data2']);
		  } 
		  
		  if($_POST['co_imovel']){
    	   $co_imovel = $_POST['co_imovel'];
    	  }elseif($_GET['co_imovel']){
		   $co_imovel = $_GET['co_imovel'];
		  } 

    	  
		  if($_POST['co_imovel']){
    	   $co_imovel = $_POST['co_imovel'];
    	  }elseif($_GET['co_imovel']){
		   $co_imovel = $_GET['co_imovel'];
		  } 
		  
		  if($_POST['veiculo']){
    	   $veiculo = $_POST['veiculo'];
    	  }elseif($_GET['co_imovel']){
		   $veiculo = $_GET['veiculo'];
		  } 
    	  
    	  
    	  if($co_imovel!=''){
		  	$buscai = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$co_imovel."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    	  	while($linha = mysql_fetch_array($buscai)){
       			$nomeimovel = "Ref.: ".$linha['ref']." - ".strip_tags($linha['titulo']);
		  	}
		  }
    	  	  
	?>
    <tr class="fundoTabela">
      <td class="style1"><b>Per&iacute;odo:</b> <?= formataDataDoBd($data1); ?> &agrave; <?= formataDataDoBd($data2); ?>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Im&oacute;vel:</b> <? if($co_imovel!=''){ echo($nomeimovel); }else{ echo "Todos"; } ?></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Tipo:</b> <? if($veiculo!=''){ echo($veiculo); }else{ echo "Todos"; } ?></td>
    </tr>
    <tr height="20px">
    	<td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?
          //REALIZA BUSCA SE O IMOVÉL FOI SELECIONADO
		  if($co_imovel<>''){	
					
			echo('
				<tr class="fundoTabelaTitulo">
       				<td width="50%" height="20px" class="style1"><b>Data</b></td>
	                <td width="50%" height="20px" class="style1"><b>Ve&iacute;culo</b></td>
                </tr>
			');
				    //REALIZA A BUSCA DE ANÚNCIOS ATRAVÉS DE UM PERÍODO E REALIZA A SOMA TOTAL DOS ANÚNCIOS
			if($veiculo<>'Todos'){
					$i = 0;
					$buscaa = mysql_query("SELECT DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio, i.im_cod, i.nome_pasta, i.im_nome FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN rebri_imobiliarias i ON (a.cod_imobiliaria=i.im_cod) WHERE a.veiculo_anuncio='".$veiculo."' AND ia.cod_imovel='".$co_imovel."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					if(mysql_num_rows($buscaa) > 0){
						$total = 0;
						while($linha = mysql_fetch_array($buscaa)){
						if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
						$i++;
							echo ("
								<tr class=\"$fundo\">
          							<!--td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</a></td-->
          							<td class=\"style1\" height=\"20px\">".$linha['data_anuncio']."</td>
          							<td class=\"style1\" height=\"20px\">".$linha['veiculo_anuncio']."</td>
        						</tr>
							");
						$total++;
						}
		
						echo("
				      		</table></td>
    						</tr>
    						<tr class=\"fundoTabelaTitulo\">
      							<td align=\"center\" colspan=\"2\" class=\"style1\"  height=\"20px\"><b>Total: ".$total." anúncio(s)</b></td>
    						</tr>
						");
					}else{
	       				echo('
	        			<tr>
            				<td colspan="6" class="style1" height="20px"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            			</tr>
	   					');
					}
			}else{
			  		$i = 0;
			  		$buscaa = mysql_query("SELECT DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio, i.im_cod, i.nome_pasta, i.im_nome FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN rebri_imobiliarias i ON (a.cod_imobiliaria=i.im_cod) WHERE ia.cod_imovel='".$co_imovel."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					if(mysql_num_rows($buscaa) > 0){
						$total = 0;
						while($linha = mysql_fetch_array($buscaa)){
						if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
						$i++;	
							
							echo ("
								<tr class=\"$fundo\">
          							<!--td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</a></td-->
          							<td class=\"style1\" height=\"20px\">".$linha['data_anuncio']."</td>
          							<td class=\"style1\" height=\"20px\">".$linha['veiculo_anuncio']."</td>
        						</tr>
							");
						$total++;
						}
								
						echo("
				      		</table></td>
    						</tr>
    						<tr class=\"fundoTabelaTitulo\">
      							<td colspan=\"2\" class=\"style1\" height=\"20px\"><b>Total: ".$total." anúncio(s)</b></td>
    						</tr>
						");
					}else{
	       				echo('
	        			<tr>
            				<td colspan="6" class="style1" height="20px"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            			</tr>
	   					');
					}
			}
		}elseif($co_imovel==''){
		//REALIZA BUSCA SE O IMÓVEL NÃO FOI SELECIONADO
		
		  
		  echo('
				<tr class="fundoTabelatitulo">
       				<td colspan="2" class="style1" height="20px"><b>Im&oacute;vel</b></td>
       			</tr>
       			<tr class="fundoTabelaTitulo">
       				<td class="style1" height="20px"><b>Data</b></td>
	                <td class="style1" height="20px"><b>Ve&iacute;culo</b></td>
                </tr>
			');
				    //REALIZA A BUSCA DE ANÚNCIOS ATRAVÉS DE UM PERÍODO E REALIZA A SOMA TOTAL DOS ANÚNCIOS
			if($veiculo<>'Todos'){
				    $i = 0;			    
				    $buscaa = mysql_query("SELECT DISTINCT m.cod, m.ref, m.titulo, DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN muraski m ON (ia.cod_imovel=m.cod) WHERE a.veiculo_anuncio='".$veiculo."' AND a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					while($linha = mysql_fetch_array($buscaa)){
					if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					$i++;
							echo ("
					            <tr class=\"$fundo\">
       								<td class=\"style1\" height=\"20px\"><b>".$linha['ref']." - ".$linha['titulo']."</b></td>
       							</tr>
								<tr>
          							<!--td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</a></td-->
          							<td height=\"20px\" class=\"style1\">".$linha['data_anuncio']."</td>
          							<td height=\"20px\" class=\"style1\">".$linha['veiculo_anuncio']."</td>
        						</tr>
							");
					$total++;
					}
			}else{
					$i = 0;
			  		$buscaa = mysql_query("SELECT DISTINCT m.cod, m.ref, m.titulo, DATE_FORMAT(a.data_anuncio, '%d/%m/%Y') AS data_anuncio, a.veiculo_anuncio FROM anuncios a INNER JOIN imoveis_anuncio ia ON (ia.id_anuncio=a.id_anuncio) INNER JOIN muraski m ON (ia.cod_imovel=m.cod) WHERE a.data_anuncio BETWEEN '$data1' AND '$data2' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a.data_anuncio ASC");
					while($linha = mysql_fetch_array($buscaa)){
					if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					$i++;
							echo ("
					            <tr class=\"$fundo\">
       								<td height=\"20px\" colspan=\"2\" class=\"style1\"><b>".$linha['ref']." - ".strip_tags($linha['titulo'])."</b></td>
       							</tr>
								<tr class=\"$fundo\">
          							<!--td class=\"style1\"><a href=\"detalhes.php?cod=".$linha['cod_imovel']."&codi=".$linha['im_cod']."&pastai=".$linha['nome_pasta']."&nomei=".$linha['im_nome']."\" class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</a></td-->
          							<td height=\"20px\" class=\"style1\">".$linha['data_anuncio']."</td>
          							<td height=\"20px\" class=\"style1\">".$linha['veiculo_anuncio']."</td>
        						</tr>
							");
					$total++;
					}
			}
			
			echo("
				      		</table></td>
    						</tr>
    						<tr class=\"fundoTabelaTitulo\">
      							<td height=\"20px\" colspan=\"2\" class=\"style1\" align=\"center\"><b>Total: ".$total." anúncio(s)</b></td>
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
<div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style1">
	    <br><br><input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	  </span></div></td>
    </tr>
</div>
</form>
</body>
</html>
