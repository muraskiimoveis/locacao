<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
ob_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
if($_GET['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("IMOV_LISTA");

if($_GET['pdf']=='1'){
  
if($_GET['codi']){
 $codi = $_GET['codi'];
}else{
 $codi = $_POST['codi'];
}

if($_GET['int_cod']){
 $int_cod = $_GET['int_cod'];
}else{
 $int_cod = $_POST['int_cod'];
}

if($_GET['ordem']){
 $ordem = $_GET['ordem'];
}else{
 $ordem = $_POST['ordem'];
}

if($_GET['atendente']){
 $atendente = $_GET['atendente'];
}else{
 $atendente = $_POST['atendente'];
}

if($codi == $_SESSION['cod_imobiliaria']){
  $codi = $_SESSION['cod_imobiliaria'];
  $pastai = $_SESSION['nome_pasta'];
}elseif($codi == ''){
  $codi = $_SESSION['cod_imobiliaria'];
  $pastai = $_SESSION['nome_pasta'];
}else{
  $codi = $codi;
  $pastai = $pastai;
}

$sqlInformacoesImobiliaria = "select imb.im_cod, imb.im_tel, imb.im_fax, imb.im_end, imb.im_bairro, imb.im_cep, imb.im_email, imb.im_site, cid.ci_nome, est.e_uf from rebri_imobiliarias imb, rebri_cidades cid, rebri_estados est where imb.im_estado = est.e_cod and imb.im_cidade = cid.ci_cod and im_cod = '$_SESSION[cod_imobiliaria]'";
$buscaInformacoesImobiliaria = mysql_query($sqlInformacoesImobiliaria);
$colunaInformacoesImobiliaria = mysql_fetch_array($buscaInformacoesImobiliaria);
	
$html6 .='<page><table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="text-align:left;">';
	$html6 .='<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>';
		
	$logo_imob = $_SESSION['logo_imob'];
    $caminho_logo = "../logos/";
	if (file_exists($caminho_logo.$logo_imob))
	{
		$html6 .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
	}
	
	$query10 = "SELECT i_nome FROM interessados WHERE i_cod='".$int_cod."'";
	$result10 = mysql_query($query10);
	while($not10 = mysql_fetch_array($result10))
	{
	    $nome_atendimento = $not10['i_nome'];
	}  
	$html6 .='</td><td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 7px;color: #000000;padding-left:30px;">';
	$html6 .= $colunaInformacoesImobiliaria['im_end'].'<br>';
	$html6 .= ucwords(strtolower($colunaInformacoesImobiliaria['im_bairro'])).' - ';
	$html6 .= ucwords(strtolower($colunaInformacoesImobiliaria['ci_nome'])).'/';
	$html6 .= strtoupper($colunaInformacoesImobiliaria['e_uf']).'<br>';
	$html6 .= 'CEP: '.$colunaInformacoesImobiliaria['im_cep'].'<br>';
	$html6 .= $colunaInformacoesImobiliaria['im_email'].'<br>';
	$html6 .= $colunaInformacoesImobiliaria['im_site'].'<br>';
	$html6 .= 'Fone: '.$colunaInformacoesImobiliaria['im_tel'].'<br>';
	$html6 .= 'Fax: '.$colunaInformacoesImobiliaria['im_fax'];
	$html6 .='</td></tr></table>';
	$html6 .='</td>
  </tr><tr>
  	<td>&nbsp;</td>
  </tr>
  <tr><td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:left;" valign="bottom"><b>Atendente: </b>'.$atendente.'<br>Atendimento em andamento para: <b>'.$nome_atendimento.'</b></td></tr>';

$query1 = "SELECT m.cod, m.ref, m.titulo, it.sid, m.valor, m.carnaval, m.anonovo, m.metragem, m.descricao, m.tipo,
	m.n_quartos, m.finalidade, m.suites, m.dist_tipo, m.dist_mar, m.bairro, m.end, m.numero, i.nome_pasta, i.im_cod, i.im_nome, i.im_img, t.t_nome, ci.ci_nome, e.e_uf 
	FROM muraski m INNER JOIN imoveis_temp it ON (it.cod=m.cod) INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) INNER JOIN rebri_estados e ON (m.uf=e.e_cod) WHERE it.interessado='$int_cod'";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);

	$i = 1;

	while($not1 = mysql_fetch_array($result1))
	{
		
	$valor2 = number_format($not1[valor], 2, ',', '.');
	$carnaval = number_format($not1[carnaval], 2, ',', '.');
	$anonovo = number_format($not1[anonovo], 2, ',', '.');
	$metragem = str_replace(".",",","$not1[metragem]");
	$descricao = str_replace("\n","<br>","$not1[descricao]");
	$pastai = $not1['nome_pasta'];
	$im_img = $not1['im_img'];
	$finalidade = $not1['finalidade'];
	
	if (($i % 2) == 1){ $fundo="CCCCCC"; }else{ $fundo="ffffff"; }
	$i++; 

  $html6 .= '<tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12%" style="text-align:center;">';
        
        		if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
					$pasta_finalidade = "locacao_peq";
				}
				else
				{
					$pasta_finalidade = "venda_peq";
				}
			$pasta = "../imobiliarias/".$pastai."/".$pasta_finalidade."/";
			
			$nome_foto1 = $not1[ref] . "_1_peq" . ".jpg";
	
			if (file_exists($pasta.$nome_foto1))
			{
				$html6 .='<img src="'.$pasta.$nome_foto1.'" border="0" width="100">';
			}
			else
			{

				$html6 .='<img border="0" src="images/sem_foto.gif" width="100">';

			}
			
			$html6 .='</td>
        <td width="500" rowspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Ref.: '.$not1[ref].' - '.$not1[t_nome].' - '.strip_tags($not1[titulo]).'</td>
          </tr>
          <tr>
            <td><table width="800" cellpadding="0" cellspacing="0">';
            if($not1[metragem] > 0){
            
                $html6 .='<tr bgcolor="#ffffff">
                <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Metragem:<b> '.$metragem.' m<sup>2</sup></b></td>
              </tr>';
            }
			  
			if($not1[n_quartos] > 0){
                
              $html6 .='<tr bgcolor="#ffffff">
                <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"> Total quartos:<b> '.$not1[n_quartos].'</b> </td>
              </tr>';
            }
            
			if($not1[suites] > 0){

			$html6 .='
				<tr bgcolor="#ffffff">
					<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Sendo Suítes: <b>'.$not1[suites].'</b></td>
				</tr>';
			}
		  if($not1[valor] > 0){
              $html6 .='<tr bgcolor="#ffffff">
                <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';
                
		
                    if($not1[finalidade]=='1' || $not1[finalidade]=='2' || $not1[finalidade]=='3' || $not1[finalidade]=='4' || $not1[finalidade]=='5' || $not1[finalidade]=='6' || $not1[finalidade]=='7' || $not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){
						$html6 .='Valor:';
				    }
					else
					{
				        $html6 .='Di&aacute;ria:';
				    }
				$html6 .='<b>R$ '.$valor2.'</b><br>';
					if($not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14' || $not1[finalidade]=='15' || $not1[finalidade]=='16' || $not1[finalidade]=='17'){

						if($not1[carnaval] > 0){

							$html6 .='Carnaval: R$ '.$carnaval.'<br>';
						}

						if($not1[anonovo] > 0){

							$html6 .='Ano Novo: R$ '.$anonovo.'<br>';
						}
					}
				$html6 .='</td>
              </tr>
              <tr>
				<td colspan="2" align="left" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">';

				if($not1[finalidade]=='1' || $not1[finalidade]=='2' || $not1[finalidade]=='3' || $not1[finalidade]=='4' || $not1[finalidade]=='5' || $not1[finalidade]=='6' || $not1[finalidade]=='7' || $not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){
		  			$mostra = " O valor ";
				}else{
		  			$mostra = "A diária ";
				}

				$html6 .= '* '.$mostra.'pode ser alterado sem aviso pr&eacute;vio.
				</td>
			  </tr>';
              }
              if($not1[dist_mar] > 0){
              
			  $html6 .='<tr bgcolor="#ffffff">
                <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Dist&acirc;ncia do mar: <b> '.$not1[dist_mar].'  '.$not1[dist_tipo].'</b></td>
              </tr>';   
              }
			  
			  $html6 .='<tr bgcolor="#ffffff">
                <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Endereco: <b> '.$not1[end].' , '.$not1[numero].'</b></td>
              </tr>'; 
			  
			  $html6 .='<tr bgcolor="#ffffff">
                <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Bairro(s): <b>';
			  
		$bairro10 = explode("--", $not1['bairro']);
		$bairro20 = str_replace("-","",$bairro10);
		
		foreach ($bairro20 as $k => $bairro) {
			$bairro20[$k] = "'" . $bairro . "'";
		}
		
		$b_bairro2 = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro20) . ") ORDER BY b_nome ASC");
		while($linha2=mysql_fetch_array($b_bairro2)){
			$html6 .= $linha2['b_nome']." "; 
		}

			if($not1[im_cod] <> $_SESSION['cod_imobiliaria']){ 
  				$parceria = "<br>Parceria";  
			} 
              
			  $html6 .='</b></td></tr><tr bgcolor="#ffffff">
                <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Localiza&ccedil;&atilde;o: <b> '.$not1[ci_nome].' - '.$not1[e_uf].'</b>'.$parceria.'</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;" width="200">'.strip_tags($descricao,"<br>").'</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td style="text-align:center;">';
			
			$fotos = explode(".",$im_img);
			$extensao = $fotos[1];
			$nome_foto = $fotos[0]."_peq";
	
			$caminho_logos = "../logos_peq/";
   
  			if (file_exists($caminho_logos.$nome_foto.".jpg")){
	    		$foto_peq_logo = $nome_foto.".jpg";
			}elseif (file_exists($caminho_logos.$nome_foto.".png")){
  				$foto_peq_logo = $nome_foto.".png";
  			}elseif (file_exists($caminho_logos.$nome_foto.".gif")){
  	  			$foto_peq_logo = $nome_foto.".gif";
  			}
    
			/*
			if (file_exists($caminho_logos.$foto_peq_logo) and $foto_peq_logo!="")
			{	      
				$html6 .='<img src="'.$caminho_logos.$foto_peq_logo.'" border="0" />';
			}
			*/
			
		$html6 .='</td>
      </tr>
    </table></td>
  </tr>';
}
$total = $i - 1;
  $html6 .= '<tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Total de '.$total.' im&oacute;veis selecionados</b></td>
        </tr>
    </table></td>
  </tr>
  <tr>
	  <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />
         www.redebrasileiradeimoveis.com.br
	  </td>
    </tr>
</table></page>';


echo $html6;


	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	$pdf = new HTML2PDF('P','A4','fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();

	
}

  $datafo = date("dmY");
  $horafo = date("His"); 
  
?>
<? if($_GET['pdf']<>'1'){ ?>
<html>
<head>
<META Http-Equiv="Cache-Control" Content="no-cache">
<META Http-Equiv="Pragma" Content="no-cache">
<META Http-Equiv="Expires" Content="0">
</head>
<body>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes/js.js"></script>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
if($_GET['codi']){
 $codi = $_GET['codi'];
}else{
 $codi = $_POST['codi'];
}

if($_GET['codu']){
 $codu = $_GET['codu'];
}else{
 $codu = $_POST['codu'];
}

if($_GET['controle1']){
 $controle1 = $_GET['controle1'];
}else{
 $controle1 = $_POST['controle1'];
}

if($codi == $_SESSION['cod_imobiliaria']){
  $codi = $_SESSION['cod_imobiliaria'];
  $pastai = $_SESSION['nome_pasta'];
}elseif($codi == ''){
  $codi = $_SESSION['cod_imobiliaria'];
  $pastai = $_SESSION['nome_pasta'];
}else{
  $codi = $codi;
  $pastai = $pastai;
}

    if($_SESSION['u_cod'] == $codu){
	
	$int_cod = $_GET['int_cod'];
	$controle1 = $_GET['controle1'];
	
	session_register("int_cod");
	session_register("controle1");
	session_register("session_id()");

	
	$query6 = "SELECT sid FROM imoveis_temp WHERE interessado='$int_cod' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
		if($numrows6 > 0){
			while($not6 = mysql_fetch_array($result6))
			{
				$sid = $not6['sid'];
				if($sid == ""){
					$sid = session_id();
				}else{
					$sid = $sid;
					session_register("sid");	
				}
			}
		}
		$msg = '<span class="style7"><div align="center">Sessão criada para adicionar mais imóveis para essa lista!</div></span><br>';
	}
	/*else{
	  unset($_SESSION['int_cod']);
	  unset($_SESSION['controle1']);
	  unset($_SESSION['sid']);
	}
	*/
	if($_GET['int_cod'] != ""){
	$int_cod = $_GET['int_cod'];
	}
	

		$query110 = "SELECT i_corretor FROM interessados WHERE i_cod='".$int_cod."'";
		$result110 = mysql_query($query110);
		while($not110 = mysql_fetch_array($result110))
		{
	   		$codu = $not110['i_corretor'];
		}
		
		if($_SESSION['u_cod'] == $codu){
			$query111 = "SELECT i_controle FROM interessados WHERE i_cod='".$int_cod."'";
			$result111 = mysql_query($query111);
			while($not111 = mysql_fetch_array($result111))
			{
	   			$controle1 = $not111['i_controle'];
			}
		}
	
?>
<form method="post" name="form1" id="form1" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="codu" id="codu" value="<?=$codu ?>">
<input type="hidden" name="controle1" id="controle1" value="<?=$controle1 ?>">
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

<table border="0" cellpadding="1" cellspacing="1" width="100%">
	<tr>
		<td height="50" colspan="8" class="style1">
			<p align="center"><b>Lista de Imóveis</b></p>
		</td>
	</tr>
  <tr>
    <td>
<div align="center">
<table border="0" cellpadding="1" cellspacing="1" width="75%" bgcolor="#<?php print("$cor14"); ?>">
<script LANGUAGE="JavaScript">
tela=null;
function inicial() {
janela1=null;
}
function fetchurl() {
opener.location = url;
}
function f1() {
janela1=window.open("carrinho_imoveis2.php?int_cod=<?php print("$int_cod"); ?>&ordem=<?php print("$ordem"); ?>","1",'toolbar=yes,location=0,directories=0,status=0,menubar=0,scrollbars=YES,resizable=0,width=690,height=400');
}
</script>
<td align=center class="style1"><b><a href="#" onClick="form1.action='carrinho_imoveis.php?pdf=1&int_cod=<?php echo($int_cod); ?>&ordem=<?php print($ordem); ?>&atendente=<?php echo("$_SESSION[u_nome]"); ?>';form1.submit();" class="style1">
Exportar para PDF</a>
| <a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='carrinho_imoveis_impressao.php?int_cod=<?php echo($int_cod); ?>&ordem=<?php print($ordem); ?>';form1.submit();" class="style1">
Imprimir Lista</a>
<? 
	$query11 = "SELECT i_libera FROM interessados WHERE i_cod='".$int_cod."'";
	$result11 = mysql_query($query11);
	while($not11 = mysql_fetch_array($result11))
	{
      	if($not11['i_libera']=='s'){ 
	   
?>
 | 
<a href="carrinho_imoveis.php?esvaziar=1&int_cod=<?=$int_cod ?>&controle1=<?=$controle1 ?>&codu=<?=$codu ?>" class="style1">
Esvaziar Lista</a>  
<? 
		}
	} 
?>
<?php
		if($pesq == ""){
			if($cod == ""){
  	$url_lista = "screen=" . $screen . "&tipo=" . $tipo . "&finalidade=" . $finalidade . "&codu=" . $codu . "&controle1=" . $controle1 . "&int_cod=" . $int_cod;
  	$arquivo = "list_vendas.php?";
  		}
  		else
  		{
  	$url_lista = "cod=" . $cod . "&screen=" . $screen . "&tipo=" . $tipo . "&finalidade=" . $finalidade . "&codu=" . $codu . "&controle1=" . $controle1 . "&int_cod=" . $int_cod;
  	$arquivo = "detalhes.php?";
  		}
		}
		else
		{
			if($cod == ""){
  	$url_lista = "screen=" . $screen . "&tipo=" . $tipo . "&ref=" . $ref . "&comp1=" . $comp1 . "&comp2=" . $comp2 . "&comp4=" . $comp4 . "&n_quartos=" . $n_quartos . "&valor=" . $valor . "&dist_mar=" . $dist_mar . "&finalidade=" . $finalidade . "&pesq=1&codu=" . $codu . "&controle1=" . $controle1 . "&int_cod=" . $int_cod;
  	$arquivo = "list_vendas.php?";
  		}
  		else
  		{
  	$url_lista = "cod=" . $cod . "&screen=" . $screen . "&tipo=" . $tipo . "&ref=" . $ref . "&comp1=" . $comp1 . "&comp2=" . $comp2 . "&comp4=" . $comp4 . "&n_quartos=" . $n_quartos . "&valor=" . $valor . "&dist_mar=" . $dist_mar . "&finalidade=" . $finalidade . "&pesq=1&codu=" . $codu . "&controle1=" . $controle1 . "&int_cod=" . $int_cod;
  	$arquivo = "detalhes.php?";
  		}
		}
		
?>
<?php
	if($finalidade != ""){
?>
<a href="<?php print("$arquivo"); ?><?php print("$url_lista"); ?>" class="style1">
Continuar Pesquisando</a> |
<?php
	}
?>
</td></tr></table>
      </td></tr>
<tr><td colspan="2" align=center>
  <table border="0" cellpadding="0" cellspacing="0" width="75%" align=center>
    <tr>
      <td width="100%">
<table BORDER="0" align="center" CELLPADDING="0" CELLSPACING="1" width=100%>
<?php
	//if((session_is_registered("valid_user")) and (session_is_registered("cdxcombr"))){
?>
<?php
	if((!IsSet($prod_cod)) and (!IsSet($qtd))){
		
		//echo "teste 1";
	
	if(session_is_registered("session_id()")){

	if($sid == ""){
	$sid = session_id();
	}
	else
	{
		$sid = $sid;
	session_register("sid");	
	}
	
		//echo "teste 2";
	
	if($alterar == "1"){
	if(($c_qtd < 1) or ($c_qtd == "")){
	$query8= "delete from imoveis_temp where cod='$cod2' and interessado='$int_cod' and cod_imobiliaria='".$codi."'";
	$result8 = mysql_query($query8) or die("Não foi possível atualizar suas informações.(Sessão existente)");
	//echo $query8;
	}
	}
	
	if($esvaziar == "1"){
	$query8= "delete from imoveis_temp where interessado='$int_cod' and cod_imobiliaria='".$codi."'";
	$result8 = mysql_query($query8) or die("Não foi possível apagar os imóveis.(Sessão existente)");
	//echo $query8;
	}
?>
<?php
	}//Termina if session_is_registered
	}//Termina o carrinho se não selecionou produtos
	else
	{
		//echo "teste 3";
	
	if(session_is_registered("session_id()")){

	if($sid == ""){
	$sid = session_id();
	}
	else
	{
		$sid = $sid;
	session_register("sid");	
	}
	
	//Procura se o produto já foi inserido no carrinho
	$query6 = "select cod, sid from imoveis_temp where cod='$cod' and interessado='$int_cod'";
	//echo $query6;
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
	if($numrows6 > 0){
	while($not6 = mysql_fetch_array($result6))
	{
	
	//Atualiza produto no carrinho
	//$qtd2 = $not6[p_qtd] + $qtd;
	//$saldo3 = $estoque - $qtd2;
	
	//if($saldo3 >= 0){
	//$query7= "update pedidos_temp set p_qtd='$qtd2' where sid='$sid' and p_cod='$p_cod'";
	//$result7 = mysql_query($query7) or die("Não foi possível atualizar suas informações.(Sessão existente)");
	//}
	}//Termina while 6
	}//Termina numrows 6
	else
	{
	if($qtd > 0){
	//Insere os produtos na tabela temporária
	$query2= "insert into imoveis_temp (sid, cod, cod_imobiliaria, p_data, interessado) 
	values('$sid', '$cod', '".$codi."', current_date, '$int_cod')";
	$result2 = mysql_query($query2) or die("Não foi possível atualizar suas informações.(Sessão existente)");
	}
	}
	
	}//Termina aqui se a seção existe
	else
	{
	
	//Insere os produtos na tabela temporária
	if($qtd > 0){
	
	session_register("session_id()");

	if($sid == ""){
	$sid = session_id();
	}
	else
	{
		$sid = $sid;
	session_register("sid");	
	}
	
	$query5= "insert into imoveis_temp (sid, cod, cod_imobiliaria, p_data, interessado) 
	values('$sid', '$cod', '".$codi."', current_date, '$int_cod')";
	$result5 = mysql_query($query5) or die("Não foi possível atualizar suas informações.(Com Sessão nova)");
	}
	}
	}
	//}//Termina While
	//}//Termina numrows
?>
<?php
	if(!$ordem){
	$ordem = ref;
	}
?>
<?php
	
    /*
	$query1 = "select distinct muraski.cod, ref, titulo, 
	sid, valor, carnaval, anonovo, metragem, descricao, tipo, n_quartos, finalidade, suites, dist_tipo, dist_mar 
	from imoveis_temp, muraski where imoveis_temp.cod=muraski.cod and interessado='$int_cod' 
	order by $ordem";
	*/
	
	
	$query1 = "SELECT m.cod, m.ref, m.titulo, it.sid, m.valor, m.carnaval, m.anonovo, m.metragem, m.descricao, m.tipo,
	m.n_quartos, m.finalidade, m.suites, m.dist_tipo, m.dist_mar, m.chaves, m.bairro, m.end, m.numero, i.nome_pasta, i.im_cod, i.im_nome, i.im_img, t.t_nome, ci.ci_nome, e.e_uf 
	FROM muraski m INNER JOIN imoveis_temp it ON (it.cod=m.cod) INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) INNER JOIN rebri_estados e ON (m.uf=e.e_cod) WHERE it.interessado='$int_cod' ORDER BY $ordem";

	
	//echo $sid;
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
	  
	  
	$query10 = "SELECT i_nome FROM interessados WHERE i_cod='".$int_cod."'";
	$result10 = mysql_query($query10);
	while($not10 = mysql_fetch_array($result10))
	{
	    $nome_atendimento = $not10['i_nome'];
	}  
?>
<tr>
<td colspan=2 class="style1"><?=$msg; ?>
<div align="center">Atendimento em andamento para: <b><?=$nome_atendimento ?></b></div><br>
Estes são os imóveis que você selecionou:
</td>
</tr>
<tr>
<td colspan=2 align=right class="style1">
Ordenar por: 
<a href="<?php print("$PHP_SELF"); ?>?<?php print("$url_lista"); ?>&ordem=tipo" class="<?php if($ordem == "tipo"){ echo "style7"; }else{ echo "style1"; } ?>">Tipo</a> | 
<a href="<?php print("$PHP_SELF"); ?>?<?php print("$url_lista"); ?>&ordem=ref" class="<?php if($ordem == "ref"){ echo "style7"; }else{ echo "style1"; } ?>">Ref.</a> | 
<a href="<?php print("$PHP_SELF"); ?>?<?php print("$url_lista"); ?>&ordem=metragem" class="<?php if($ordem == "metragem"){ echo "style7"; }else{ echo "style1"; } ?>">Metragem</a> | 
<a href="<?php print("$PHP_SELF"); ?>?<?php print("$url_lista"); ?>&ordem=valor" class="<?php if($ordem == "valor"){ echo "style7"; }else{ echo "style1"; } ?>">Valor</a></td>
</tr>
<?php
	$i = 1;
	//$total = 0;
	//$peso_total = 0;

	while($not1 = mysql_fetch_array($result1))
	{
		
	$valor2 = number_format($not1[valor], 2, ',', '.');
	$carnaval = number_format($not1[carnaval], 2, ',', '.');
	$anonovo = number_format($not1[anonovo], 2, ',', '.');
	$metragem = str_replace(".",",","$not1[metragem]");
	$descricao = str_replace("\n","<br>","$not1[descricao]");
	$pastai = $not1['nome_pasta'];
	$im_img = $not1['im_img'];
	$finalidade = $not1['finalidade'];
	
		//if($not1[r_ed] == "0"){
		//$r_preco = number_format($r_preco, 2, ',', '.');
		//$p_preco2 = $not1[p_qtd] * $not1[p_preco_promo];
		//}
		//else
		//{
		//$p_preco = number_format($not1[p_preco], 2, ',', '.');
		//$p_preco2 = $not1[p_qtd] * $not1[p_preco];		
		//}
	//$quant = number_format($not1[p_qtd], 2, ',', '.');
	//$peso1 = $not1[p_qtd] * $not1[p_peso];
	//$p_preco3 = number_format($p_preco2, 2, ',', '.');
	//$total = $total;
	//session_register("total");
	//$total_desc = $total * 0.97;
	//$peso_total = $peso1 + $peso_total;

	if (($i % 2) == 1){ $fundo="CCCCCC"; }else{ $fundo="ffffff"; }
	$i++;
?>
<input type="hidden" name="cod" value="<?php print("$not1[cod]"); ?>">
<input type="hidden" name="sid" value="<?php print("$sid"); ?>">
<input type="hidden" name="alterar" value="1">
<input type="hidden" name="c_qtd" value="0">
<tr><td align=center width=160 valign=top>
<table border="0" cellspacing="0" width="158" cellpadding="0" height=142>
<tr><td align=center height=10>
<tr><td align=center>
<a href="detalhes.php?<?php print("$url_lista"); ?>&cod=<?php print("$not1[cod]"); ?>&codi=<?php print("$not1[im_cod]"); ?>&nomei=<?php print("$not1[im_nome]"); ?>&pastai=<?php print("$not1[nome_pasta]"); ?>" class="style1">
<?php
            /*
			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$codi."'");
			$row = mysql_fetch_array($result);
			$tmp_pasta = $row['nome_pasta'];
			*/
			/*
			$pasta_fin = strtolower(substr($not1[finalidade], 0, 4));
				if($pasta_fin == "loca"){
			*/
				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
					$pasta_finalidade = "locacao_peq";
				}
				else
				{
					$pasta_finalidade = "venda_peq";
				}
			$pasta = "../imobiliarias/".$pastai."/".$pasta_finalidade."/";
			
			$nome_foto1 = $not1[ref] . "_1_peq" . ".jpg";
	
	if (file_exists($pasta.$nome_foto1))
	{
?>
<img border="0" src="<?php print($pasta.$nome_foto1."?datafo=$datafo&horafo=$horafo"); ?>">
<?php
	}
	else
	{
?>
<img border="0" src="images/sem_foto.gif">
<?
	}
?>
</a></td></tr>
<?php
    //$caminho_logos = "../logos_peq/";
    
    $fotos = explode(".",$im_img);
	$extensao = $fotos[1];
	$nome_foto = $fotos[0]."_peq";
	
	$caminho_logos = "../logos_peq/";
   
  	if (file_exists($caminho_logos.$nome_foto.".jpg")){
	    $foto_peq_logo = $nome_foto.".jpg";
	}elseif (file_exists($caminho_logos.$nome_foto.".png")){
  		$foto_peq_logo = $nome_foto.".png";
  	}elseif (file_exists($caminho_logos.$nome_foto.".gif")){
  	  $foto_peq_logo = $nome_foto.".gif";
  	}
    
	
	//if (file_exists($caminho_logos.$foto_peq_logo) and $foto_peq_logo!="")
	//{
?>
              <!--tr>
                <td align="center" valign="top"><img src="<?php print($caminho_logos.$foto_peq_logo); ?>" border="0" /></td>
              </tr-->
<?php
	//}
	  if($not1[im_cod] == $_SESSION['cod_imobiliaria']){
?>
			 <tr>
                <td align="center" valign="top"><a href="p_edit_imoveis.php?cod=<?php print("$not1[cod]"); ?>"><img src="images/icones/atualizar_imovel.jpg" width="34" height="34" border="0" title="Atualizar imóvel" /></a>
				<? if($not1[chaves] <> ''){ ?>
					<a href="javascript:;" onClick="MM_openBrWindow('ata_chaves.php?cod=<?php print("$not1[cod]"); ?>&codi=<?php echo($codi); ?>','','scrollbars=yes,resizable=no,width=700,height=400')" class=style1><img src="images/icones/local_chaves.jpg" width="34" height="34" border="0" title="Local das chaves" /></a>
					<? }else{ ?>
					<img src="images/icones/local_chaves_apagada.jpg" width="34" height="34" border="0" title="Local das chaves" /></a>					
					<? } ?>
				</td>
              </tr>
<?
		}
?>
<tr><td align=left height=10>
</td></tr>
</table>
</td>
<td align=center>
<table border="0" cellpadding="1" cellspacing="1" width=95% class="bordaTabelaDestaque">
<tr class="fundoTabela"><td colspan=2>
<table border="0" cellpadding="0" cellspacing="1" width=100%>
<tr class="fundoTabela"><td colspan=2 class="style1">
<a href="detalhes.php?<?php print("$url_lista"); ?>&cod=<?php print("$not1[cod]"); ?>&codi=<?php print("$not1[im_cod]"); ?>&nomei=<?php print("$not1[im_nome]"); ?>&pastai=<?php print("$not1[nome_pasta]"); ?>" class="style1">
Ref.: <?php print("$not1[ref]"); ?> - <?php print("$not1[t_nome]"); ?> - <?php print strip_tags($not1[titulo]); ?></a>
</td></tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" width=100%>
<tr><td>
<table border="0" cellpadding="0" cellspacing="1" width=100%>
<?php
	if($not1[metragem] > 0){
?>
<tr class="fundoTabela"><td colspan=2 class="style1">
Metragem:<b> <?php print("$metragem"); ?> m<sup>2</sup></b>
</td></tr>
<?php
	}
	if($not1[n_quartos] > 0){
?>
<tr class="fundoTabela"><td colspan=2 class="style1">
Total quartos:<b> <?php print("$not1[n_quartos]"); ?></b>
</td></tr>
<?php
	}
?>
<?php
	if($not1[suites] > 0){
?>
<tr class="fundoTabela"><td colspan=2 class="style1">
Sendo Suítes: <b><?php print("$not1[suites]"); ?></b>
</td></tr>
<?php
	}
?>
<?php
	if($not1[valor] > 0){
?>
<tr class="fundoTabela"><td colspan=2 class="style1">
<?php
	//if($not1[finalidade] == "Locação"){
	if($not1[finalidade]=='1' || $not1[finalidade]=='2' || $not1[finalidade]=='3' || $not1[finalidade]=='4' || $not1[finalidade]=='5' || $not1[finalidade]=='6' || $not1[finalidade]=='7' || $not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){
?>
Valor:
<?php
	}
	else
	{
?>
Diária:
<?php
	}
?> <b>R$ <?php print("$valor2"); ?></b><br>
<?php
	//if($not1[finalidade] == "Locação"){
    if($not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14' || $not1[finalidade]=='15' || $not1[finalidade]=='16' || $not1[finalidade]=='17'){
?>
<?php
	if($not1[carnaval] > 0){
?>
Carnaval: R$ <?php print("$carnaval"); ?><br>
<?php
	}
?>
<?php
	if($not1[anonovo] > 0){
?>
Ano Novo: R$ <?php print("$anonovo"); ?><br>
<?php
	}
?>
<?php
	}
?>
</td></tr>
<tr>
	<td colspan="2" align="left" class="style1">
<?
		if($not1[finalidade]=='1' || $not1[finalidade]=='2' || $not1[finalidade]=='3' || $not1[finalidade]=='4' || $not1[finalidade]=='5' || $not1[finalidade]=='6' || $not1[finalidade]=='7' || $not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){
		  	$mostra = " O valor ";
		}else{
		  	$mostra = "A diária ";
		}
?>
		*<?=$mostra ?>pode ser alterado sem aviso pr&eacute;vio.
	</td>
</tr>
<?php
	}
?>
<?php
	if($not1[dist_mar] > 0){
?>
<tr class="fundoTabela"><td colspan=2 class="style1">
Distância do mar: <b><?php print("$not1[dist_mar] $not1[dist_tipo]"); ?></b>
</td></tr>
<?php
	}
?>
<tr class="fundoTabela"><td colspan=2 class="style1">
Endereço: <b>
<?php
print( $not1['end']." , ".$not1['numero']);
?>
<tr class="fundoTabela"><td colspan=2 class="style1">
Bairro(s): <b>
<?
$bairro10 = explode("--", $not1['bairro']);
$bairro20 = str_replace("-","",$bairro10);
		
foreach ($bairro20 as $k => $bairro) {
	$bairro20[$k] = "'" . $bairro . "'";
}
		
	$b_bairro2 = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro20) . ") ORDER BY b_nome ASC");
	while($linha2=mysql_fetch_array($b_bairro2)){
		echo $linha2['b_nome']." "; 
	}


?></b>
</td></tr>
<tr class="fundoTabela"><td colspan=2 class="style1">
Localização: <b><?php print("$not1[ci_nome]"); ?> - <?php print("$not1[e_uf]"); ?></b><br><? if($not1[im_cod] <> $_SESSION['cod_imobiliaria']){ echo "Parceria";  } ?>
</td></tr>
</td></tr>
</table></td>
<? 
	$query12 = "SELECT i_libera FROM interessados WHERE i_cod='".$int_cod."'";
	$result12 = mysql_query($query12);
	while($not12 = mysql_fetch_array($result12))
	{
      	if($not12['i_libera']=='s'){ 
	   
?>
<td align=right>
<a href="carrinho_imoveis.php?<?php print("$url_lista"); ?>&alterar=1&cod2=<?php print("$not1[cod]"); ?>&ordem=<?php print("$ordem"); ?>&int_cod=<?php print("$int_cod"); ?>" class="style7">
Retirar da lista</a>
</td>
<?
 		}
	}
?>
</td></table>
<table width="100%">
<tr class="fundoTabela"><td colspan=2 class="style1">
<p align=justify>
<?php print strip_tags($descricao,"<br>"); ?>
</td></tr></table>
</td></tr></table>
</td>
</tr></form>
<?php
	}
	//$total = number_format($total, 2, ',', '.');
	//$total_desc = number_format($total_desc, 2, ',', '.');
?>
<tr>
<td colspan=2 class="style1">
<b>Total de <?php $total = $i - 1; print("$total"); ?> imóveis selecionados</b></td>
</tr>
<?php
mysql_free_result($result1);
	}//Termina o carrinho se existe a seção e não selecionou produtos
	else
	{
?>
<tr bgcolor="#<?php print("$cor14"); ?>"><?=$msg; ?>
<td colspan="4" align=center class="style1"><b>Sua lista de imóveis ainda está vazia!</td>
</tr>
<tr class="fundoTabela">
<td colspan="4" align=center class="style1"><a href="index.php" class="style1">Clique aqui para continuar navegando.</a></td>
</tr>
<?php
	}
?>
      </td>
    </tr>
  </table>

</td></tr>
<tr><td colspan="2" align=center>
<hr noshade color="<?php print("$cor14"); ?>" align="center" width="50%" size="1">
</td></tr>
<!--tr><td colspan=2 align=center>
<a href="javascript:history.back()" class="style1">
                  << Voltar <<</a>
</td></tr-->
</table>
<?
	//}## fim while conta imoveis
	//mysql_free_result($result1);
	//mysql_free_result($result2);
	mysql_close($con);

## se não tem sessao
/*
} else {
	print "Área protegida!";
}
*/
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
<? } ?>