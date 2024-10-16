<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
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
  
$data_hora = date("d_m_Y_H_i_s");
$arquivo = "lista_imoveis_".$data_hora.".doc";

header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: application/msword; name=$arquivo");
header ( "Content-Disposition: attachment; filename=$arquivo");   
  
  
//$html6 .='<link href="style.css" rel="stylesheet" type="text/css" />';

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

	
$html6 .='<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>';
	
	$logo_imob = $_SESSION['logo_imob'];
    $caminho_logo = "../logos/";
	if (file_exists($caminho_logo.$logo_imob))
	{
		//$html6 .='<img src="'.$caminho_logo.$logo_imob.'" border="0">';
	}
	
	$html6 .='</td>
  </tr>';

$query1 = "SELECT m.cod, m.ref, m.titulo, it.sid, m.valor, m.carnaval, m.anonovo, m.metragem, m.descricao, m.tipo,
	m.n_quartos, m.finalidade, m.suites, m.dist_tipo, m.dist_mar, i.nome_pasta, i.im_cod, i.im_nome, i.im_img, t.t_nome, ci.ci_nome, e.e_uf 
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
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12%"><div align="center">';
        
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
				//$html6 .='<img src="'.$pasta.$nome_foto1.'" width="100" border="0">';
			}
			else
			{

				//$html6 .='<img border="0" src="images/sem_foto.gif" width="100">';

			}
			
			$html6 .='</div></td>
        <td width="88%" rowspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="style1">Ref.: '.$not1[ref].' - '.$not1[t_nome].' - '.$not1[titulo].'</td>
          </tr>
          <tr>
            <td><table width="100%" cellpadding="0" cellspacing="0">
                <tr bgcolor="#ffffff">
                <td colspan="2" class="style1">Metragem:<b> '.$metragem.' m<sup>2</sup></b></td>
              </tr>';
              
			if($not1[n_quartos] > 0){
                
              $html6 .='<tr bgcolor="#ffffff">
                <td colspan="2" class="style1"> Total quartos:<b> '.$not1[n_quartos].'</b> </td>
              </tr>';
            }
            
			if($not1[suites] > 0){

			$html6 .='
				<tr bgcolor="#ffffff">
					<td colspan=2 class="style1">Sendo Suítes: <b>'.$not1[suites].'</b></td>
				</tr>';
			}
              $html6 .='<tr bgcolor="#ffffff">
                <td colspan="2" class="style1">';
                
			  if($not1[valor] > 0){
					if($not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14' || $not1[finalidade]=='15' || $not1[finalidade]=='16' || $not1[finalidade]=='17'){
						$html6 .='Di&aacute;ria:';
				    }
					else
					{    
				        $html6 .='Valor:';
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
              </tr>';
              }
              if($not1[dist_mar] > 0){
              
			  $html6 .='<tr bgcolor="#ffffff">
                <td colspan="2" class="style1">Dist&acirc;ncia do mar: <b> '.$not1[dist_mar].'  '.$not1[dist_tipo].'</b></td>
              </tr>';   
              }
              
			  $html6 .='<tr bgcolor="#ffffff">
                <td colspan="2" class="style1">Localiza&ccedil;&atilde;o: <strong> '.$not1[ci_nome].' - '.$not1[e_uf].'</strong></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td class="style1">'.$descricao.'</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div align="center">';
			
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
    
			if (file_exists($caminho_logos.$foto_peq_logo) and $foto_peq_logo!="")
			{	      
				//$html6 .='<img src="'.$caminho_logos.$foto_peq_logo.'" border="0" />';
			}
			
		$html6 .='</div></td>
      </tr>
    </table></td>
  </tr>';
}
$total = $i - 1;
  $html6 .= '<tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%" class="style1"><b>Total de '.$total.' im&oacute;veis selecionados</td>
        </tr>
    </table></td>
  </tr>
</table>';


echo $html6;

/*
$data_hora6 = date("d_m_Y_H_i_s");
$arquivo6 = "lista_imoveis_".$data_hora6.".pdf";

require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html6);
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();
$dompdf->stream($arquivo6);
*/

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
?>
<form method="post" name="form1" id="form1" action="<?php print("$PHP_SELF"); ?>">
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
<p>
<table border="0" cellpadding="1" cellspacing="1" width="770">
  <tr>
    <td>
<div align="center">
<table border="0" cellpadding="1" cellspacing="1" width="700" bgcolor="#<?php print("$cor14"); ?>">
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
<td align=center class="style1"><b><a href="#" onClick="form1.action='carrinho_imoveis.php?pdf=1&int_cod=<?php echo($int_cod); ?>&ordem=<?php print($ordem); ?>';form1.submit();" class="style1">
Exportar para DOC</a>
| <a href="#" onClick="NewWindow('','uprelatorio','800','600','yes');form1.target='uprelatorio';form1.action='carrinho_imoveis_impressao.php?int_cod=<?php echo($int_cod); ?>&ordem=<?php print($ordem); ?>';form1.submit();" class="style1">
Imprimir Lista</a> | 
<a href="carrinho_imoveis.php?esvaziar=1" class="style1">
Esvaziar Lista</a>  
<?php
		if($pesq == ""){
			if($cod == ""){
  	$url_lista = "screen=" . $screen . "&tipo=" . $tipo . "&finalidade=" . $finalidade;
  	$arquivo = "list_vendas.php?";
  		}
  		else
  		{
  	$url_lista = "cod=" . $cod . "&screen=" . $screen . "&tipo=" . $tipo . "&finalidade=" . $finalidade;
  	$arquivo = "detalhes.php?";
  		}
		}
		else
		{
			if($cod == ""){
  	$url_lista = "screen=" . $screen . "&tipo=" . $tipo . "&ref=" . $ref . "&comp1=" . $comp1 . "&comp2=" . $comp2 . "&comp4=" . $comp4 . "&n_quartos=" . $n_quartos . "&valor=" . $valor . "&dist_mar=" . $dist_mar . "&finalidade=" . $finalidade . "&pesq=1";
  	$arquivo = "list_vendas.php?";
  		}
  		else
  		{
  	$url_lista = "cod=" . $cod . "&screen=" . $screen . "&tipo=" . $tipo . "&ref=" . $ref . "&comp1=" . $comp1 . "&comp2=" . $comp2 . "&comp4=" . $comp4 . "&n_quartos=" . $n_quartos . "&valor=" . $valor . "&dist_mar=" . $dist_mar . "&finalidade=" . $finalidade . "&pesq=1";
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
  <table border="0" cellpadding="0" cellspacing="0" width="95%" align=center>
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
	if($_GET['int_cod'] != ""){
	$int_cod = $_GET['int_cod'];}
	
    /*
	$query1 = "select distinct muraski.cod, ref, titulo, 
	sid, valor, carnaval, anonovo, metragem, descricao, tipo, n_quartos, finalidade, suites, dist_tipo, dist_mar 
	from imoveis_temp, muraski where imoveis_temp.cod=muraski.cod and interessado='$int_cod' 
	order by $ordem";
	*/
	
	
	$query1 = "SELECT m.cod, m.ref, m.titulo, it.sid, m.valor, m.carnaval, m.anonovo, m.metragem, m.descricao, m.tipo,
	m.n_quartos, m.finalidade, m.suites, m.dist_tipo, m.dist_mar, i.nome_pasta, i.im_cod, i.im_nome, i.im_img, t.t_nome, ci.ci_nome, e.e_uf 
	FROM muraski m INNER JOIN imoveis_temp it ON (it.cod=m.cod) INNER JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) INNER JOIN rebri_estados e ON (m.uf=e.e_cod) WHERE it.interessado='$int_cod' ORDER BY $ordem";

	
	//echo $sid;
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<tr>
<td colspan=2 class="style1">
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
<img border="0" src="<?php print($pasta.$nome_foto1."?datafo=$datafo&horafo=$horafo"); ?>" width=100>
<?php
	}
	else
	{
?>
<img border="0" src="images/sem_foto.gif" width=100>
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
    
	if (file_exists($caminho_logos.$foto_peq_logo) and $foto_peq_logo!="")
	{
?>
              <tr>
                <td align="center" valign="top"><img src="<?php print($caminho_logos.$foto_peq_logo); ?>" border="0" /></td>
              </tr>
<?php
	}
?>

<tr><td align=left height=10>
</td></tr>
</table>
</td>
<td align=center>
<table border="0" cellpadding="1" cellspacing="1" width=95% bgcolor=CDCDCD>
<tr bgcolor="#EDEEEE"><td colspan=2>
<table border="0" cellpadding="0" cellspacing="1" width=100%>
<tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<a href="detalhes.php?<?php print("$url_lista"); ?>&cod=<?php print("$not1[cod]"); ?>&codi=<?php print("$not1[im_cod]"); ?>&nomei=<?php print("$not1[im_nome]"); ?>&pastai=<?php print("$not1[nome_pasta]"); ?>" class="style1">
Ref.: <?php print("$not1[ref]"); ?> - <?php print("$not1[t_nome]"); ?> - <?php print("$not1[titulo]"); ?></a>
</td></tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" width=100%>
<tr><td>
<table border="0" cellpadding="0" cellspacing="1" width=100%>
<tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
Metragem:<b> <?php print("$metragem"); ?> m<sup>2</sup></b>
</td></tr>
<?php
	if($not1[n_quartos] > 0){
?>
<tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
Total quartos:<b> <?php print("$not1[n_quartos]"); ?></b>
</td></tr>
<?php
	}
?>
<?php
	if($not1[suites] > 0){
?>
<tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
Sendo Suítes: <b><?php print("$not1[suites]"); ?></b>
</td></tr>
<?php
	}
?>
<?php
	if($not1[valor] > 0){
?>
<tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<?php
	//if($not1[finalidade] == "Locação"){
	if($not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14' || $not1[finalidade]=='15' || $not1[finalidade]=='16' || $not1[finalidade]=='17'){
?>
Diária:
<?php
	}
	else
	{
?>
Valor:
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
<?php
	}
?>
<?php
	if($not1[dist_mar] > 0){
?>
<tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
Distância do mar: <b><?php print("$not1[dist_mar] $not1[dist_tipo]"); ?></b>
</td></tr>
<?php
	}
?>
<tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
Localização: <b><?php print("$not1[ci_nome]"); ?> - <?php print("$not1[e_uf]"); ?></b>
</td></tr>
</td></tr>
</table></td>
<td align=right>
<a href="carrinho_imoveis.php?<?php print("$url_lista"); ?>&alterar=1&cod2=<?php print("$not1[cod]"); ?>&ordem=<?php print("$ordem"); ?>&int_cod=<?php print("$int_cod"); ?>" class="style7">
Retirar da lista</a>
</td>
</td></table>
<table>
<tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align=justify>
<?php print("$descricao"); ?>
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
<b>Total de <?php $total = $i - 1; print("$total"); ?> imóveis selecionados</td>
</tr>
<?php
mysql_free_result($result1);
	}//Termina o carrinho se existe a seção e não selecionou produtos
	else
	{
?>
<tr bgcolor="#<?php print("$cor14"); ?>">
<td colspan="4" align=center class="style1"><b>Sua lista de imóveis ainda está vazia!</td>
</tr>
<tr bgcolor="#EDEEEE">
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
<tr><td colspan=2 align=center>
<a href="javascript:history.back()" class="style1">
                  << Voltar <<</a>
</td></tr>
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
</body>
</html>
<? } ?>