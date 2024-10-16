<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include("style.php");
include("conect.php");
include("l_funcoes.php");
include("funcoes/funcoes.php");

verificaAcesso();
verificaArea("GERAL_VEND");

$datafo = date("dmY");
$horafo = date("His");

if($_POST['b_bairr']){
	$b_bairr = $_POST['b_bairr'];
}elseif($_GET['b_bairr']){
  	$b_bairr = $_GET['b_bairr'];
}

if($_POST['bairro']){
	$btemp = $_POST['bairro'];
}elseif($_GET['bairro']){
  	$btemp = $_GET['bairro'];
}

if($_POST['b_caract']){
	$b_caract = $_POST['b_caract'];
}elseif($_GET['b_caract']){
  	$b_caract = $_GET['b_caract'];
}

if($_POST['caracteristica']){
	$ctemp = $_POST['caracteristica'];
}elseif($_GET['caracteristica']){
  	$ctemp = $_GET['caracteristica'];
}

if(isset($_POST['opcao_neutra'])){
  $opcao_neutra = $_POST['opcao_neutra'];
}elseif(isset($_POST['opcao_sem'])){
  $opcao_sem = $_POST['opcao_sem'];
}elseif(isset($_POST['opcao_com'])){
  $opcao_com = $_POST['opcao_com'];
}elseif(isset($_GET['opcao_neutra'])){
  $opcao_neutra = $_GET['opcao_neutra'];
}elseif(isset($_GET['opcao_sem'])){
  $opcao_sem = $_GET['opcao_sem'];
}elseif(isset($_GET['opcao_com'])){
  $opcao_com = $_GET['opcao_com'];
}

if($opcao_neutra == '1'){
  $sql_opcao = '';
}elseif($opcao_sem == '1'){
  $sql_opcao = " AND opcao_simnao = '0'";
}elseif($opcao_com == '1'){
  $sql_opcao = " AND opcao_simnao = '1'";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META Http-Equiv="Cache-Control" Content="no-cache">
<META Http-Equiv="Pragma" Content="no-cache">
<META Http-Equiv="Expires" Content="0">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript" src="funcoes/js.js"></script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg"><?php
include("topo.php");
?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");

$finalidade = isset($_GET['finalidade']) ? $_GET['finalidade'] : '';

?></td>
  </tr>
</table>
<form name="form1" id="form1" method="POST" action="">
<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" colspan="2" align="center" valign="top">
    <?php 
	if($_GET['adicionado'] == 1 && $_GET['troca']<>'S')
    {
    	echo('<br><div align="center"><span class="style7">Imóvel adicionado a lista!</span></div><br>');
    }
	?>
    </td>
  </tr>
  <tr>
    <td height="31" align="left" valign="top" background="images/fundo_degrade_titulos.jpg"><table border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td width="7"><img src="images/icone_titulo.gif" width="7" height="9" /><td class="style47"> IM&Oacute;VEIS PARA
<?

if (in_array($finalidade, range(1, 7))) {
    echo "VENDAS";
} else if (in_array($finalidade, range(8, 14))) {
    echo "LOCAÇÕES MENSAIS";
}

?>
        </td>
        </tr>
    </table></td>
    <td align="right" valign="top" background="images/fundo_degrade_titulos.jpg"><img src="images/titulo_rebri_degrade2.jpg" /></td>
  </tr>
<?php

	if ($screen == "") {
   		$screen = 1;
	}

	$from = ($screen - 1) * 10;

	$tipo1 = $_GET['tipo1'];
	$ref = $_GET['ref'];
	$comp1 = $_GET['comp1'];
	$n_quartos = $_GET['n_quartos'];
	$comp2 = $_GET['comp2'];
	$valor = $_GET['valor'];
	$comp4 = $_GET['comp4'];
	$dist_mar1 = stripslashes($_GET['dist_mar1']);
	$tipo_logradouro = $_GET['tipo_logradouro'];
	$end = $_GET['end'];
	$numero_end = $_GET['numero_end'];
	$cep = $_GET['cep'];
	//$bairro = $_GET['bairro'];
	//$caracteristica = $_GET['caracteristica'];
	$im_estado = stripslashes($_GET['im_estado']);
	$local = stripslashes($_GET['local']);
	//$b_caract = $_GET['b_caract'];
	//$b_bairr = $_GET['b_bairr'];
	$b_averbada = stripslashes($_GET['b_averbada']);
	if($finalidade=='7'){
	  $query_finalidade = " AND (m.finalidade='2' OR m.finalidade='3' OR m.finalidade='4' OR m.finalidade='5' OR m.finalidade='6' OR m.finalidade='7')";
	}elseif($finalidade=='14'){
	  $query_finalidade = " AND (m.finalidade='9' OR m.finalidade='10' OR m.finalidade='11' OR m.finalidade='12' OR m.finalidade='13' OR m.finalidade='14')";
	}elseif($finalidade=='17'){
	  $query_finalidade = " AND (m.finalidade='15' OR m.finalidade='16' OR m.finalidade='17')";
	}elseif($finalidade<>'1' || $finalidade<>'8'){
	  $query_finalidade = "AND m.finalidade='".$finalidade."'";
	}
	$relacao_bens = $_GET['relacao_bens'];
	$permuta = $_GET['permuta'];
	$permuta_txt = $_GET['permuta_txt'];
	$oferta = $_GET['oferta'];
	$ordenar = $_GET['ordenar'];
	$condominio = $_GET['condominio'];
	
	//$ano = substr ($chave, 6, 4);
	//$mes = substr($chave, 3, 2 );
	//$dia = substr ($chave, 0, 2 );
	if($ref == "" || $ref == "%"){
	$ref = "%";
	}

	if($n_quartos == "" || $n_quartos == "%"){
	$n_quartos = "%";
	}

	if($valor == "" || $valor == "%"){
		$valor = "%";
	}else{
	  if($_GET['screen']==''){
	    $valor = str_replace(".", "", $valor);  
		$valor = str_replace(",", ".", $valor); 
	  }
	}
	
		if($comp4=='<'){
	  	  	$dist_mar1 .= " AND m.dist_mar < ".$dist_mar."";
		  	$dist_mar1 .= " OR m.dist_mar='frente para o mar' ";
		  	$dist_mar1 .= " OR m.dist_mar='frente para a baía' ";
	  	}elseif($comp4=='>'){
	  	 	$dist_mar1 = "AND m.dist_mar > ".$dist_mar."";
	  	}elseif($comp4=='='){
	  	  	$dist_mar1 = "AND m.dist_mar = ".$dist_mar."";
	  	}elseif($comp4=='frente para o mar'){
	  	  	$dist_mar1 = "AND m.dist_mar = 'frente para o mar'";
	  	}elseif($comp4=='frente para a baía'){
	  	  	$dist_mar1 = "AND m.dist_mar = 'frente para a baía'";
  		}elseif($dist_mar=="" || $dist_mar=="%"){
		    $dist_mar1 = "AND m.dist_mar like '%'";
		}

	if($tipo_logradouro == "" || $tipo_logradouro == "%"){
		$tipo_logradouro = "%";
	}

	if($end == "" || $end == "%"){
		$end = "%";
	}
	
	if($numero_end == "" || $numero_end == "%"){
		$numero_end = "%";
	}
	
	if($cep == "" || $cep == "%"){
		$cep = "%";
	}
	
	if($comp2 == "like"){
		$valor = $valor . "%";
	}

	if($valor_oferta == "Sim"){
	$oferta = "and m.valor_oferta>0";
	}
	
	if($b_averbada=='1'){
	  $query_averbada = "and m.averbacao > 0";
	}
		
		
	 # Checa se o bairro foi selecionado
   $bairro = "";
   $b_get = "";
   if (($btemp <> "") && ($b_bairr <> "1")) {
      $f = 0;
      foreach ($btemp as $b) {
         if ($f == 0) {
      	   $bairro .= "AND (m.bairro LIKE '%".$b."%' ";
           $b_get .= "&bairro[]=$b";
         } else {
      	   $bairro .= " OR m.bairro LIKE '%".$b."%'";
           $b_get .= "&bairro[]=$b";
         }
         $f++;
      }
      $bairro .= ") ";
   }


    # Checa se a caracteristica foi selecionada
   $caracteristica = "";
   $c_get = "";
   if (($ctemp <> "") && ($b_caract <> "1")) {
      $t = 0;
      foreach ($ctemp as $c) {
         if ($t == 0) {
      	   $caracteristica .= "AND (m.caracteristica LIKE '%".$c."%' ";
           $c_get .= "&caracteristica[]=$c";
         } else {
      	   $caracteristica .= " OR m.caracteristica LIKE '%".$c."%'";
           $c_get .= "&caracteristica[]=$c";
         }
         $t++;
      }
      $caracteristica .= ") ";
   }	
		
	if(!empty($condominio))
	{
		$condominio = strtolower($condominio);
		$sqlCondominio = "and lower(m.condominio) like '%".$condominio."%'";
	}
		
	/*	
	if($bairro!=''){
	$query_bairro = "AND (";
	
	//Bairros
	for ($k=0; $k<sizeof($bairro); $k++) {
				if ($k==0) {
					$query_bairro .= "m.bairro LIKE '%".$bairro[$k]."%'";
				} else {
				  	if($b_bairr=='1'){
						$query_bairro .= " AND m.bairro LIKE '%".$bairro[$k]."%'";
					}else{
						$query_bairro .= " OR m.bairro LIKE '%".$bairro[$k]."%'";
					}
				}
			}	
	$query_bairro .= ")";
	}
		
	if($caracteristica!=''){
	$query_caracteristica = "AND (";
		
			
	//Características
	for ($k2=0; $k2<sizeof($caracteristica); $k2++) {
				if ($k2==0) {
					$query_caracteristica .= "m.caracteristica LIKE '%".$caracteristica[$k2]."%'";
				} else {
					if($b_caract=='1'){
						$query_caracteristica .= " AND m.caracteristica LIKE '%".$caracteristica[$k2]."%'";  
					}else{
						$query_caracteristica .= " OR m.caracteristica LIKE '%".$caracteristica[$k2]."%'";
					}
				}
			}
	
	$query_caracteristica .= ")";
	}
	*/
	
	if($im_estado!='0'){
	   $query_estado = " AND m.uf='".$im_estado."'";
	}

	if($local!='' && $local!='all' && $local!=0){
	   $query_cidade = " AND m.local='".$local."'";
	}else{
       $query_cidade = " AND m.local LIKE '%'";
	}
	

	if(!$ordem){
	$ordem = "tipo";
	}

	if($ordem == "ultimos_cadastros"){
		$ordem1 = "m.cod desc";
	}elseif($ordem == "valor_decrescente"){
		$ordem1 = "m.valor desc";
	}elseif($ordem == "valor_crescente"){
		$ordem1 = "m.valor";
	}elseif($ordem == "quartos"){
		$ordem1 = "m.n_quartos";
	}
	else
	{
		$ordem1 = $ordem;
	}

	$ordenar = $ordem1 . ", m.ref";


?>
    
    <input type="hidden" name="tipo1" id="tipo1" value="<? if($_GET['tipo1']){ echo $_GET['tipo1']; }else{ echo $tipo; } ?>">
    <input type="hidden" name="ref" id="ref" value="<? if($_GET['ref']){ echo $_GET['ref']; }else{ echo $ref; } ?>">
    <input type="hidden" name="comp1" id="comp1" value="<? if($_GET['comp1']){ echo $_GET['comp1']; }else{ echo $comp1; } ?>">
    <input type="hidden" name="n_quartos" id="n_quartos" value="<? if($_GET['n_quartos']){ echo $_GET['n_quartos']; }else{ echo $n_quartos; } ?>">
    <input type="hidden" name="comp2" id="comp2" value="<? if($_GET['comp2']){ echo $_GET['comp2']; }else{ echo $comp2; } ?>">
    <input type="hidden" name="valor" id="valor" value="<? if($_GET['valor']){ echo $_GET['valor']; }else{ echo $valor; } ?>">
    <input type="hidden" name="comp4" id="comp4" value="<? if($_GET['comp4']){ echo $_GET['comp4']; }else{ echo $comp4; } ?>">
    <input type="hidden" name="dist_mar1" id="dist_mar1" value="<? if($_GET['dist_mar1']){ echo $_GET['dist_mar1']; }else{ echo stripslashes($dist_mar1); } ?>">
    <input type="hidden" name="tipo_logradouro" id="tipo_logradouro" value="<? if($GET['tipo_logradouro']){ echo $_GET['tipo_logradouro']; }else{ echo $tipo_logradouro; } ?>">
    <input type="hidden" name="end" id="end" value="<? if($_GET['end']){ echo $_GET['end']; }else{ echo $end; } ?>">
    <input type="hidden" name="numero_end" id="numero_end" value="<? if($GET['numero_end']){ echo $_GET['numero_end']; }else{ echo $numero_end; } ?>">
    <input type="hidden" name="cep" id="cep" value="<? if($_GET['cep']){ echo $_GET['cep']; }else{ echo $cep; } ?>">
    <!--input type="hidden" name="query_bairro" id="query_bairro" value="<? if($_GET['query_bairro']){ echo $_GET['query_bairro']; }else{ echo $query_bairro; } ?>">
    <input type="hidden" name="query_caracteristica" id="query_caracteristica" value="<? if($GET['query_caracteristica']){ echo $_GET['query_caracteristica']; }else{ echo $query_caracteristica; } ?>"-->
    <input type="hidden" name="query_estado" id="query_estado" value="<? if($_GET['query_estado']){ echo $_GET['query_estado']; }else{ echo stripslashes($query_estado); } ?>">
    <input type="hidden" name="query_cidade" id="query_cidade" value="<? if($_GET['query_cidade']){ echo $_GET['query_cidade']; }else{ echo stripslashes($query_cidade); } ?>">
    <input type="hidden" name="query_finalidade" id="query_finalidade" value="<? if($_GET['query_finalidade']){ echo $_GET['query_finalidade']; }else{ echo stripslashes($query_finalidade); } ?>">
    <input type="hidden" name="finalidade" id="finalidade" value="<? if($_GET['finalidade']){ echo $_GET['finalidade']; }else{ echo $finalidade; } ?>">
    <input type="hidden" name="permuta" id="permuta" value="<? if($_GET['permuta']){ echo $_GET['permuta']; }else{ echo $permuta; } ?>">
    <input type="hidden" name="permuta_txt" id="permuta_txt" value="<? if($_GET['permuta_txt']){ echo $_GET['permuta_txt']; }else{ echo $permuta_txt; } ?>">
    <input type="hidden" name="oferta" id="oferta" value="<? if($_GET['oferta']){ echo $_GET['oferta']; }else{ echo $oferta; } ?>">
    <input type="hidden" name="ordenar" id="ordenar" value="<? if($_GET['ordenar']){ echo $_GET['ordenar']; }else{ echo $ordenar; } ?>">
    <input type="hidden" name="screen" id="screen" value="<? if($_GET['screen']){ echo $_GET['screen']; }else{ echo $screen; } ?>">
    <input type="hidden" name="im_estado" id="im_estado" value="<? if($_GET['im_estado']){ echo $_GET['im_estado']; }else{ echo $im_estado; } ?>">
    <input type="hidden" name="local" id="local" value="<? if($_GET['local']){ echo $_GET['local']; }else{ echo $local; } ?>">
    <input type="hidden" name="relacao_bens" id="relacao_bens" value="<? if($_GET['relacao_bens']){ echo $_GET['relacao_bens']; }else{ echo $relacao_bens; } ?>">
    <input type="hidden" name="query_averbada" id="query_averbada" value="<? if($_GET['query_averbada']){ echo $_GET['query_averbada']; }else{ echo stripslashes($query_averbada); } ?>">
    <input type="hidden" name="b_get" id="b_get" value="<? if($_GET['b_get']){ echo $_GET['b_get']; }else{ echo $b_get; } ?>">
    <input type="hidden" name="c_get" id="c_get" value="<? if($_GET['c_get']){ echo $_GET['c_get']; }else{ echo $c_get; } ?>">
    <input type="hidden" name="condominio" id="condominio" value="<? if($_GET['condominio']){ echo $_GET['condominio']; }else{ echo $condominio; } ?>">


<?
	#$query1 = "select * from muraski where tipo like '$tipo1' and ref like '$ref' 
	#and n_quartos $comp1 '$n_quartos' and valor $comp2 '$valor' and
	#acomod $comp3 '$acomod' and dist_mar $comp4 '$dist_mar' and end like '%$end%' 
	#and finalidade='Locação' and data_inicio<=current_date and
	#data_fim>=current_date order by $ordenar limit $from, 10";
    
    if($finalidade=='1' || $finalidade=='8'){
		
		if($finalidade=='1'){
	  		$query_finalidade2 = " AND (m.finalidade='2')";
		}elseif($finalidade=='8'){
	  		$query_finalidade2 = " AND (m.finalidade='9')";
		}	  
		
		$query1 = "SELECT * FROM muraski m LEFT JOIN rebri_tipo t ON (m.tipo=t.t_cod) LEFT JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) WHERE i.im_desativar='0' AND (m.tipo LIKE '$tipo1' OR m.tipo_secundario LIKE '%-".$tipo1."-%') AND m.ref LIKE '$ref' 
		AND m.n_quartos $comp1 '$n_quartos' AND m.valor $comp2 '$valor' 
		$dist_mar1 AND m.tipo_logradouro like '%$tipo_logradouro%' AND m.end LIKE '%$end%' AND m.numero LIKE '%$numero_end%' AND m.cep LIKE '%$cep%' $bairro $caracteristica $query_estado $query_cidade $query_finalidade2 $query_averbada $sql_opcao
		AND m.disp_rede='1' AND m.ref!='x' AND m.relacao_bens LIKE '%$relacao_bens%' AND m.permuta LIKE '%$permuta%' 
		AND m.permuta_txt LIKE '%$permuta_txt%' $oferta $sqlCondominio
		ORDER BY $ordenar LIMIT $from, 10";
	}else{
	    $query1 = "SELECT * FROM muraski m LEFT JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE (m.tipo LIKE '$tipo1' OR m.tipo_secundario LIKE '%-".$tipo1."-%') AND m.ref LIKE '$ref' 
		AND m.n_quartos $comp1 '$n_quartos' AND m.valor $comp2 '$valor' 
		$dist_mar1 AND m.tipo_logradouro like '%$tipo_logradouro%' AND m.end LIKE '%$end%' AND m.numero LIKE '%$numero_end%' AND m.cep LIKE '%$cep%' $bairro $caracteristica $query_estado $query_cidade
		$query_finalidade $query_averbada $sql_opcao AND m.ref!='x' AND m.relacao_bens LIKE '%$relacao_bens%' AND m.permuta LIKE '%$permuta%' $sqlCondominio
		AND m.permuta_txt LIKE '%$permuta_txt%' $oferta AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
		ORDER BY $ordenar LIMIT $from, 10";
	}
    
			
	//echo $query1;
	// AND (current_date BETWEEN data_inicio AND data_fim)
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
  <tr>
    <td height="30" colspan="2" align="center" valign="top" class="style48">
	Ordenado por: <?php print("$ordem"); ?>
	</td>
  </tr>
<?

	$hoje = date("Y-m-d");
	
	if($_GET['acao'])
	{

	  $msgErro = "";
   		
		$cod = $_GET['cod'];
		$codi = $_GET['codi'];
   		$dthj = $_GET['dthj'];
   		$tipo1 = $_GET['tipo1'];
   	   	$ref = $_GET['ref'];
   	   	$comp1 = $_GET['comp1'];
   	   	$n_quartos = $_GET['n_quartos'];
   	   	$comp2 = $_GET['comp2'];
   	   	$valor = $_GET['valor'];
   	   	$comp4 = $_GET['comp4'];
   	   	$dist_mar1 = stripslashes($_GET['dist_mar1']);
   	   	$tipo_logradouro = $_GET['tipo_logradouro'];
   	   	$end = $_GET['end'];
   	   	$numero_end = $_GET['numero_end'];
   	   	$cep = $_GET['cep'];
   	   	$b_get = $_GET['b_get'];
   	   	$c_get = $_GET['c_get'];
   	   	//$query_bairro = $_GET['query_bairro'];
   	   	//$query_caracteristica = $_GET['query_caracteristica'];
   	   	$query_averbada = stripslashes($_GET['query_averbada']);
   		$query_estado = stripslashes($_GET['query_estado']);
		$query_cidade = stripslashes($_GET['query_cidade']);
   	   	$query_finalidade = stripslashes($_GET['query_finalidade']);
   	   	$query_finalidade2 = stripslashes($_GET['query_finalidade2']);
   	   	$finalidade = stripslashes($_GET['finalidade']);
	    $permuta = $_GET['permuta'];
	    $im_estado = $_GET['im_estado'];
	    $local = $_GET['local'];
		$permuta_txt = $_GET['permuta_txt'];
		$oferta = $_GET['oferta'];
		$ordenar = $_GET['ordenar'];
		$screen = $_GET['screen'];
		$relacao_bens = $_GET['relacao_bens'];
  
   		$SQL = "SELECT cod_imovel, data FROM avaliados WHERE user='".$_SESSION['u_cod']."' AND cod_imovel='".$cod."' AND data='".$dthj."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		//echo $SQL;
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Esse imóvel já foi adicionado a lista hoje!";
		}
		
		if($msgErro != "")
		{
	 		echo "<div align=\"center\"><span class=\"style7\">".$msgErro."</span></div>"; 
		}
		else
		{
			$inserir = "INSERT INTO avaliados (cod_imobiliaria, cod_imovel, data, user) VALUES ('".$_SESSION['cod_imobiliaria']."','".$cod."','".$hoje."','".$u_cod."')";   		
   			if(mysql_query($inserir))
			{
				echo('<div align="center"><span class="style7">Imóvel adicionado a lista!</span></div>');
   			}
   			else
   			{
      			echo('<div align="center"><span class="style7">Erro ao adicionar!</span></div>');
   			}
   		}  
	  
	}


	## se encontrou imoveis
	if($numrows1 > 0){

		$i = 1;



		## loop de imoveis cadastrados para locacao
		$y = 1;
		while($not1 = mysql_fetch_array($result1))
        {
          
        $buscaIM = mysql_query("SELECT im_cod, im_nome, nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$not1['cod_imobiliaria']."'");  
		while($linhaIM = mysql_fetch_array($buscaIM)){
		    $codi = $linhaIM['im_cod'];
			$nomei = $linhaIM['im_nome'];
			$pastai = $linhaIM['nome_pasta'];
		}

		if($codi=='3'){
				if (mb_detect_encoding($not1[titulo], "ASCII, UTF-8, ISO-8859-1") == "UTF-8") {
      				$not1[titulo] = utf8_decode($not1[titulo]);
   				}

   				if (mb_detect_encoding($not1[tipo_logradouro], "ASCII, UTF-8, ISO-8859-1") == "UTF-8") {
      				$not1[tipo_logradouro] = utf8_decode($not1[tipo_logradouro]);
   				}

   				if (mb_detect_encoding($not1[end], "ASCII, UTF-8, ISO-8859-1") == "UTF-8") {
      				$not1[end] = utf8_decode($not1[end]);
   				}

   	   	}else{

		   		$not1[titulo] = $not1[titulo];
            	$not1[tipo_logradouro] = $not1['tipo_logradouro'];
		  		$not1[end] = $not1['end'];
		}
		
			$not1[titulo] = str_replace("\\","",$not1[titulo]);
			$not1[titulo] = strip_tags($not1[titulo]);
			$not1[observacoes2] = str_replace("\\","",$not1[observacoes2]);
			$not1[observacoes2] = strip_tags($not1[observacoes2]);
			$not1[observacoes3] = str_replace("\\","",$not1[observacoes3]);
			$not1[observacoes3] = strip_tags($not1[observacoes3]);
		
        
		if($finalidade=='6'){
		  
		  $cod = $not1[cod];
          $valorm = $not1[valor];
		  		
		 	$buscaV = mysql_query("SELECT v_imovel, v_total FROM vendas WHERE v_imovel='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");  
			while($linha2 = mysql_fetch_array($buscaV)){
		      $cod_imovel = $linha2['v_imovel'];
     	      $valorv = $linha2['v_total'];
		 	}  
		 	//FAZ VERIFICACAO QUAL VALOR UTLIZAR SE TABELA VENDA OU DA MURASKI	
			if($cod==$cod_imovel){
		  		$valor2 = number_format($valorv, 2, ',', '.');
			}elseif($cod<>$cod_imovel){
		  		$valor2 = number_format($valorm, 2, ',', '.');
			}
        }else{
            $valor2 = number_format($not1[valor], 2, ',', '.');		  
		}


					$valor_oferta = number_format($not1[valor_oferta], 2, ',', '.');
					$metragem = str_replace(".",",",$not1[metragem]);

					//$descricao = str_replace("\n","<br>","$not1[descricao]");
					$img_1 = $not1[img_1];
	
					if (($i % 2) == 1){ $fundo="$cor7"; }else{ $fundo=$cor6; }
					$i++;

?>
  <tr>
    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="31" valign="top" background="images/fundo_degrade_titulos.jpg"><table border="0" cellpadding="0" cellspacing="4">
          <tr>
            <td class="style47"><!--a href="detalhes.php?cod=<?=$not1[cod]?>&mes=<?=$nextmes?>&ano=<?=$nextano?>" class="style48"-->
		<?php print("$not1[t_nome]"); ?> -- <b>Ref.: <?php print("$not1[ref]"); ?> - <?php print $not1[titulo]; ?></b><!--/a-->
<? if($not1[observacoes2] <> '') { ?>
   <br><span class="style7"><?=$not1[observacoes2]?></span>
<? } ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="10" cellpadding="0">
          <tr>
            <td width="51%" valign="top"><table width="442" height="330" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="1">
				<tr>
                    <td align="center" valign="top">
<?
            /*
			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
			$row = mysql_fetch_array($result);
			$tmp_pasta = $row['nome_pasta'];
			*/
			/*$pasta_fin = strtolower(substr($finalidade, 0, 4));
			if($pasta_fin == "loca"){
			*/
			if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
				$pasta_finalidade = "locacao";
			}
			else
			{
				$pasta_finalidade = "venda";
			}
			$pasta = "../imobiliarias/".$pastai."/".$pasta_finalidade."/";
			
			$nome_foto = $not1[ref] . "_1" . ".jpg";
			
			$controla_tamanho = "";
     		$tam_img = @GetImageSize($pasta.$nome_foto);
     		$rel_larg = $tam_img[0] / 400;
     		$rel_alt = $tam_img[1] / 300;

     		if ($rel_alt > 1 || $rel_larg > 1) {
         		if ($rel_alt > $rel_larg) {
	         		$controla_tamanho = " height='300' ";
         		} else {
	         		$controla_tamanho = " width='400' ";
         		}

     		}
			

					## se tem foto, mostra!
					if (file_exists($pasta.$nome_foto))
					{

						if($_SERVER['SERVER_NAME'] == "www.redebrasileiradeimoveis.com.br" OR $_SERVER['SERVER_NAME'] == "redebrasileiradeimoveis.com.br") { 
?>
						<img border="0" src="<?php print($pasta.$nome_foto."?datafo=$datafo&horafo=$horafo"); ?>" title="<? echo "Ref: ".$not1['ref'] ?>" />					
						
<?
						}else{
?>
						<img border="0" src="<?php print($pasta.$nome_foto."?datafo=$datafo&horafo=$horafo"); ?>" <?=$controla_tamanho?> title="<? echo "Ref: ".$not1['ref'] ?>" />					
<?											  
						}
					}
					else
					{
?>
						<img border="0" src="images/sem_foto_gr.jpg" title="Sem Foto" />		
<?					  
					}
?>	
					</td>
                 </tr>
                </table></td>
              </tr>
            </table></td>
            <td width="49%" align="left" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td colspan="2" class="style48"><span class="style14"><b>Imobili&aacute;ria: <?=$nomei ?></b></span></td>
              </tr>
              <? if($not1['metragem'] > 0){ ?>
              <tr>
                <td class="style48" align="left" width="30%">Metragem:</td>
                <td align="left" class="style48"><strong><?php print("$metragem"); ?> m<sup>2</sup></strong></td>
                </tr>
               <? } ?>
 <? if($not1['averbacao'] > 0){ 
				   $averbacao = str_replace(".",",","$not1[averbacao]");
			  ?>
			  <tr>
                <td class="style48" align="left" width="30%">&Aacute;rea averbada:</td>
                <td class="style48" align="left" width="70%"><strong><?= $averbacao ?> m<sup>2</sup></strong></td>
              </tr>
			 <? } ?> 
			 <? if($not1['area_terreno'] > 0){ 
			  	 $area_terreno = str_replace(".",",","$not1[area_terreno]");
			 ?>
			  <tr>
                <td class="style48" align="left" width="30%">&Aacute;rea do terreno:</td>
                <td class="style48" align="left" width="70%"><strong><?= $area_terreno ?> m<sup>2</sup></strong></td>
              </tr>
			<? } ?>
<?
			  ## se tem quartos, mostra!
			  if($not1[n_quartos] > 0){
?>
			  <tr>
                <td class="style48" align="left">Total quartos:</td>
                <td align="left" class="style48"><strong><?php print("$not1[n_quartos]"); ?></strong></td>
                </tr>
<?
			  }
?>			  
<?
			  ## se tem suites, mostra!
			  if($not1[suites] > 0){
?>
		      <tr>
                <td class="style48" align="left">Sendo Su&iacute;tes:</td>
                <td align="left" class="style48"><strong><?php print("$not1[suites]"); ?></strong></td>
                </tr>
<?
	    	  }
?>
<?
			## se tem valor, mostra!
			if($not1[valor] > 0){
?>
			  <tr>
                <td class="style48" align="left">Valor:</td>
                <td class="style48" align="left"><strong>R$ <?php print("$valor2"); ?></strong></td>
              </tr>
<?
			}
?>
<?
			## se tem valor_oferta, mostra!
			if($not1[valor_oferta] > 0){
?>
			  <tr>
                <td class="style48" align="left">OFERTA:</td>
                <td class="style48" align="left"><strong>R$ <?php print("$valor_oferta"); ?></strong> - BOM NEGÓCIO!</td>
              </tr>
<?
			}
?>
              <tr>
                <td colspan="2" class="style48" align="left">*O valor pode ser alterado sem aviso pr&eacute;vio.</td>
              </tr>
<?
			  ## se tem end, mostra!
			  if($not1[end] <> ''){
			    if($not1[exibir_endereco]<>'1'){
?>
			  <tr>
                <td class="style48" align="left">Endere&ccedil;o:</td>
                <td align="left" class="style48"><b><?php print("$not1[tipo_logradouro]"); ?> <?php print("$not1[end]"); ?> <?php print(",".$not1[numero].""); ?></b></td>
             </tr>
<?
			  	}elseif($not1[exibir_endereco]=='1' && $codi == $_SESSION['cod_imobiliaria']){
?>
			  <tr>
                <td class="style48" align="left">Endere&ccedil;o:</td>
                <td align="left" class="style48"><b><?php print("$not1[tipo_logradouro]"); ?> <?php print("$not1[end]"); ?> <?php print(",".$not1[numero].""); ?></b></td>
             </tr>

<?			  	  			    
				}
			}
?>
<?
/**
			  ## se tem end, mostra!
			  if($not1[cep] <> ''){
?>
			  <tr>
                <td class="style48" align="left">CEP:</td>
                <td align="left" class="style48"><b><?php print(formataCEPDoBd($not1[cep])); ?></b></td>
                </tr>
<?
			  }
/**/

			  ## se tem end, mostra!
			  if($not1[bairro] <> ''){
?>
			  <tr>
                <td class="style48" align="left" valign="top">Bairro:</td>
                <td align="left" class="style48"><b>
<?
   $tbairro = explode("--", $not1[bairro]);
   $tbairro = str_replace("-","",$tbairro);
   if (count($tbairro) > 0) {
      $l = 0;
      foreach ($tbairro as $bairr) {
			$sqlb = "SELECT b_nome FROM rebri_bairros WHERE b_cod = '$bairr'";
         $rsb = mysql_query($sqlb) or die ("Erro 751");
         $notb = mysql_fetch_assoc($rsb);
         if ($l == 0) {
            echo $notb['b_nome'];
         } else {
            echo ",\n " . $notb['b_nome'];
         }
         $l++;
      }
   }
?>
                </b></td></tr>
<?
			  }



			  $blitoranea = mysql_query("SELECT ci_litoranea FROM rebri_cidades WHERE ci_cod='".$local."' AND ci_litoranea='1'");
 			  while($linha = mysql_fetch_array($blitoranea)){
	     	    $litoranea = $linha['ci_litoranea'];
		      } 
			  
			if($litoranea=='1'){	
			  ## se tem dist_mar, mostra!
			  if($not1[dist_mar] > 0 || $not1[dist_mar]=='frente para o mar' || $not1[dist_mar]=='frente para a baía'){
?>
			  <tr>
                <td class="style48" align="left">Dist&acirc;ncia mar:</td>
                <td align="left" class="style48"><b><?php print("$not1[dist_mar] $not1[dist_tipo]"); ?></b></td>
                </tr>
<?
			  }
		   }
?>
              
              <!--tr>
                <td class="style48" align="left">Especifica&ccedil;&atilde;o:</td>
                <td align="left" class="style48"><strong><?php print("$not1[especificacao]"); ?></strong></td>
                </tr-->
<?
if($not1[finalidade]=='1'){
  $fin = "Venda_Rebri";
}elseif($not1[finalidade]=='2'){
  $fin = "Venda_".$nomei;
}elseif($not1[finalidade]=='3'){
  $fin = "Venda_Parceria";
}elseif($not1[finalidade]=='4'){
  $fin = "Venda_Terceiros";
}elseif($not1[finalidade]=='5'){
  $fin = "Venda_Off";
}elseif($not1[finalidade]=='6'){
  $fin = "Venda_Vendido";
}elseif($not1[finalidade]=='7'){
  $fin = "Venda_Todos";
}elseif($not1[finalidade]=='8'){
  $fin = "Locação_Anual_Rebri";
}elseif($not1[finalidade]=='9'){
  $fin = "Locação_Anual_".$nomei;
}elseif($not1[finalidade]=='10'){
  $fin = "Locação_Anual_Parceria";
}elseif($not1[finalidade]=='11'){
  $fin = "Locação_Anual_Terceiros";
}elseif($not1[finalidade]=='12'){
  $fin = "Locação_Anual_Off";
}elseif($not1[finalidade]=='13'){
  $fin = "Locação_Anual_Locado";
}elseif($not1[finalidade]=='14'){
  $fin = "Locação_Anual_Todos";
}elseif($not1[finalidade]=='15'){
  $fin = "Locação_Temporada_".$nomei;
}elseif($not1[finalidade]=='16'){
  $fin = "Locação_Temporada_Off";
}elseif($not1[finalidade]=='17'){
  $fin = "Locação_Temporada_Todos";
}

?>
<?php
	$url = $REQUEST_URI;
	//echo $url;
	$url = urlencode($url);
?>
              <tr>
                <td class="style48" align="left">Finalidade:</td>
                <td align="left" class="style48"><strong><?php print($fin); ?></strong></td>
              </tr>
<? if($not1[observacoes3] <> ''){ ?>                 
              <tr>
                <td class="style7" align="left">Observa&ccedil;&otilde;es:</td>
                <td align="left" class="style7"><? echo $not1[observacoes3]; ?></td>
              </tr>
<? } ?>             
<? //if($not1[observacoes] <> '' && $codi == $_SESSION['cod_imobiliaria']){ ?>              
              <!--tr>
                <td class="style7" align="left">Observa&ccedil;&otilde;es:</td>
                <td align="left" class="style7"><? echo $not1[observacoes]; ?></td>
              </tr-->
<? //} ?>
<?
// Verificar se foi inserido...
if(!$sid){
	$sid = session_id();
}

if($codi == $_SESSION['cod_imobiliaria']){
  
	$query_a = "select cod, sid from anuncios_temp where sid='".$sid."' and cod='".$not1[cod]."' and
		anuncio='".$a_cod."' and cod_imobiliaria='".$codi."'";
	$result_a = mysql_query($query_a) or die ("Erro 658 - ".mysql_error());
	$conta_a = mysql_num_rows($result_a);
	if ($conta_a == 0) {
	  	if($_SESSION['veiculo']<>''){
	  	  	$SQL = "SELECT id_anuncio FROM anuncios WHERE veiculo_anuncio='".$_SESSION['veiculo']."' AND cod_imobiliaria='".$codi."'";
			$busca = mysql_query($SQL);
    		$num_rows = mysql_num_rows($busca);
    		if($num_rows == 0)
			{
		  		$b_veiculo = mysql_query("SELECT ta_nome FROM rebri_tipo_anuncios WHERE ta_cod='".$_SESSION['veiculo']."'");
				while($linha3 = mysql_fetch_array($b_veiculo)){	  	  
					$nome_veiculo = $linha3['ta_nome'];
				}
?>
				<tr>
                <td colspan="2" align="left" class="style48"><a href="cadastro_anuncios.php?qtd=1&rel=R&cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>&url=<?php print("$url"); ?>&criar=S&nome_veiculo=<?=$nome_veiculo ?>" class="style48"><b>Criar exportação <?=$nome_veiculo; ?></b></a></td>
              </tr>
<?					
			}else{
	  	  		$b_veiculo = mysql_query("SELECT ta_nome FROM rebri_tipo_anuncios WHERE ta_cod='".$_SESSION['veiculo']."'");
				while($linha3 = mysql_fetch_array($b_veiculo)){	  	  
					$nome_veiculo = $linha3['ta_nome'];
				}
?>
              <tr>
                <td colspan="2" align="left" class="style48"><a href="cadastro_anuncios.php?qtd=1&rel=R&cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>&url=<?php print("$url"); ?>" class="style48"><b>Adicionar a exportação <?=$nome_veiculo; ?></b></a></td>
              </tr>
<?
			}
?>              
              <tr>
                <td colspan="2" align="left" class="style48"><a href="cadastro_anuncios.php?qtd=1&rel=R&cod=<?php print("$not1[cod]"); ?>&troca=S&codi=<?=$codi; ?>&url=<?php print("$url"); ?>&nome_veiculo=<?=$nome_veiculo ?>" class="style48"><b>Trocar veículo</b></a></td>
              </tr>
<?
		}else{
?>
			  <tr>
                <td colspan="2" align="left" class="style48"><a href="cadastro_anuncios.php?qtd=1&rel=R&cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>&url=<?php print("$url"); ?>&novo=1" class="style48"><b>Nova Exportação</b></a></td>
              </tr>
<?		
		}
	}else{
	  	$SQL = "SELECT id_anuncio FROM anuncios WHERE veiculo_anuncio='".$_SESSION['veiculo']."' AND cod_imobiliaria='".$codi."'";
		$busca = mysql_query($SQL);
    	$num_rows = mysql_num_rows($busca);
    	if($num_rows == 0)
		{
		  	$b_veiculo = mysql_query("SELECT ta_nome FROM rebri_tipo_anuncios WHERE ta_cod='".$_SESSION['veiculo']."'");
			while($linha3 = mysql_fetch_array($b_veiculo)){	  	  
				$nome_veiculo = $linha3['ta_nome'];
			}
?>		  
	  		  <tr>
                <td colspan="2" align="left" class="style48"><a href="cadastro_anuncios.php?qtd=1&rel=R&cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>&url=<?php print("$url"); ?>&criar=S&nome_veiculo=<?=$nome_veiculo ?>" class="style48"><b>Criar exportação <?=$nome_veiculo; ?></b></a></td>
              </tr>
<?              
 		}else{
  			$b_veiculo = mysql_query("SELECT ta_nome FROM rebri_tipo_anuncios WHERE ta_cod='".$_SESSION['veiculo']."'");
			while($linha3 = mysql_fetch_array($b_veiculo)){	  	  
				$nome_veiculo = $linha3['ta_nome'];
			}
	  
?>
			<tr>
                <td colspan="2" align="left" class="style7">Esse imóvel já foi adicionado a exportação <?=$nome_veiculo ?></td>
            </tr>
<?
		}
?>            
            <tr>
                <td colspan="2" align="left" class="style48"><a href="cadastro_anuncios.php?qtd=1&rel=R&cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>&url=<?php print("$url"); ?>&troca=S&nome_veiculo=<?=$nome_veiculo ?>" class="style48"><b>Trocar veículo</b></a></td>
              </tr>
<?
	}
}
?>
              <!--tr>
                <td colspan="2" align="left" class="style48"><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='ata_chaves.php?cod=<?php echo("$not1[cod]"); ?>&codi=<?=$codi; ?>';form1.submit();" class=style48><b>Ata de Chaves</b></a></td>
              </tr-->
              <tr>
                <td height="5" colspan="2" align="left"></td>
              </tr>
              <tr>
                <td height="1" colspan="2" align="left" bgcolor="e4e4e4"></td>
              </tr>
              <tr>
                <td colspan="2" align="left"><table width="100%" border="0" cellspacing="5" cellpadding="0">
<? if($codi == $_SESSION['cod_imobiliaria']){ ?>
  <? if ($not1[cliente] <> "") { ?> 
                  <tr>
<?
if (verificaFuncao("GERAL_SINAL")) { // verifica se pode acessar as areas 
  $busca3 = mysql_query("SELECT * FROM sinal_venda WHERE cod_imovel='".$not1[cod]."' AND cod_imobiliaria='".$codi."' AND status_sinal!='cancelado' AND s_status='A' ORDER BY data_sinal DESC LIMIT 0,1");
  if(mysql_num_rows($busca3) > 0){
?>
                    <td align="center"><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='fazer_sinal.php?cod=<?php echo("$not1[cod]"); ?>&codi=<?php echo("$codi"); ?>';form1.submit();" class=style1><img src="images/icones/imovel_com_sinal.jpg" width="34" height="34" border="0" title="Imóvel com sinal de negócio" /></a></td>
<? }else{ ?>  
                    <td align="center"><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='fazer_sinal.php?cod=<?php echo("$not1[cod]"); ?>&codi=<?php echo("$codi"); ?>';form1.submit();" class=style1><img src="images/icones/fazer_sinal_negocio.jpg" width="34" height="34" border="0" title="Fazer sinal de negócio" /></a></td>                    
<? } ?>
<?
}
}else{
?>
	<tr>
       <td align="center"><img src="images/icones/fazer_sinal_negocio_apagada.jpg" width="34" height="34" border="0" title="É necessário ter proprietário para realizar um sinal de negócio" /></td>
       
<?  		
}
}else{
?>
                  <tr>
<?
if (verificaFuncao("GERAL_SINAL")) { // verifica se pode acessar as areas 
  $busca3 = mysql_query("SELECT * FROM sinal_venda WHERE cod_imovel='".$not1[cod]."' AND cod_imobiliaria='".$codi."' AND status_sinal!='cancelado' AND s_status='A' ORDER BY data_sinal DESC LIMIT 0,1");
  if(mysql_num_rows($busca3) > 0){
?>
                    <td align="center"><img src="images/icones/imovel_com_sinal.jpg" width="34" height="34" border="0" title="Imóvel com sinal de negócio" /></td>
<? }else{ ?>
					<td align="center"><img src="images/icones/fazer_sinal_negocio_apagada.jpg" width="34" height="34" border="0" title="Imóvel sem sinal de negócio" /></td>
<?
   }
}
}
if($codi == $_SESSION['cod_imobiliaria']){ 
if (verificaFuncao("GERAL_PROP")) { // verifica se pode acessar as areas 
  $busca2 = mysql_query("SELECT * FROM propostas WHERE cod_imovel='".$not1[cod]."' AND cod_imobiliaria='".$codi."' AND aceitacao='0' AND p_status='A' ORDER BY data_proposta DESC LIMIT 0,1");
  //$busca2 = mysql_query("SELECT * FROM propostas WHERE cod_imovel='".$not1[cod]."' AND cod_imobiliaria='".$codi."' AND data_proposta >= DATE_SUB(current_date, INTERVAL 15 DAY) AND aceitacao='0' AND p_status='A' ORDER BY data_proposta DESC LIMIT 0,1");
  if(mysql_num_rows($busca2) > 0){
?>
                    <td align="center"><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='fazer_proposta.php?cod=<?php echo("$not1[cod]"); ?>&codi=<?php echo("$codi"); ?>';form1.submit();" class=style1><img src="images/icones/imovel_com_proposta.jpg" width="34" height="34" border="0" title="Imóvel com proposta" /></a></td>
<? }else{ ?>  
                    <td align="center"><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='fazer_proposta.php?cod=<?php echo("$not1[cod]"); ?>&codi=<?php echo("$codi"); ?>';form1.submit();" class=style1><img src="images/icones/fazer_proposta.jpg" width="34" height="34" border="0" title="Fazer proposta" /></a></td>							
<? }
}
}else{
if (verificaFuncao("GERAL_PROP")) { // verifica se pode acessar as areas 
  $busca2 = mysql_query("SELECT * FROM propostas WHERE cod_imovel='".$not1[cod]."' AND cod_imobiliaria='".$codi."' AND aceitacao='0' AND p_status='A' ORDER BY data_proposta DESC LIMIT 0,1");
  //echo $busca2 = mysql_query("SELECT * FROM propostas WHERE cod_imovel='".$not1[cod]."' AND cod_imobiliaria='".$codi."' AND data_proposta >= DATE_SUB(current_date, INTERVAL 15 DAY) AND aceitacao='0' AND p_status='A' ORDER BY data_proposta DESC LIMIT 0,1");
  if(mysql_num_rows($busca2) > 0){
?>
                    <td align="center"><img src="images/icones/imovel_com_proposta.jpg" width="34" height="34" border="0" title="Imóvel com proposta" /></td>
<? }else{ ?>
					<td align="center"><img src="images/icones/fazer_proposta_apagada.jpg" width="34" height="34" border="0" title="Imóvel sem proposta" /></td>							
<?    
  }
}  
}
?>
<? if($codi == $_SESSION['cod_imobiliaria']){ ?>
                    <? if($not1[indicador] > 0){ ?>
					<td align="center"><a href="javascript:;" onClick="NewWindow('indicador.php?cod=<?php print("$not1[cod]"); ?>', 'janela', 750, 500, 'yes')" class=style1><img src="images/icones/imovel_com_indicacao.jpg" width="34" height="34" border="0" title="Imóvel com indicação" /></a></td>
					<? }else{ ?>
					<td align="center"><img src="images/icones/imovel_com_indicacao_apagada.jpg" width="34" height="34" border="0" title="Imóvel sem indicação" /></td>
					<? } ?>
                   </tr>
<? } ?>
				   <tr>
						<td align="center"><a href="p_lista_ven.php?acao=<?php print("$y"); ?><?php echo($b_get); ?><?php echo($c_get); ?>&cod=<?php print("$not1[cod]"); ?>&codi=<?php print($codi); ?>&dthj=<?php print("$hoje"); ?>&tipo1=<? echo($tipo1); ?>&ref=<? echo($ref); ?>&comp1=<? echo($comp1); ?>&comp2=<? echo($comp2); ?>&comp4=<? echo($comp4); ?>&n_quartos=<? echo($n_quartos); ?>&valor=<? echo($valor); ?>&comp4=<? echo($comp4); ?>&dist_mar1=<? echo(stripslashes($dist_mar1)); ?>&query_finalidade=<? echo(stripslashes($query_finalidade)); ?>&finalidade=<? echo($finalidade); ?>&query_bairro=<? echo($query_bairro); ?>&query_catacteristica=<? echo($query_caracteristica); ?>&query_caracteristica2=<? echo($query_caracteristica2); ?>&query_estado=<? echo(stripslashes($query_estado)); ?>&query_cidade=<? echo(stripslashes($query_cidade)); ?>&permuta=<? echo($permuta); ?>&permuta_txt=<? echo($permuta_txt); ?>&tipo_logradouro=<? echo($tipo_logradouro); ?>&end=<? echo($end); ?>&numero_end=<? echo($numero_end); ?>&cep=<? echo($cep); ?>&ordem=<? echo($ordem); ?>&valor_oferta=<? echo($valor_oferta); ?>&relacao_bens=<? echo($relacao_bens); ?>&screen=<? echo($screen); ?>&im_estado=<? echo($im_estado); ?>&local=<? echo($local); ?>&b_averbada=<? echo($b_averbada); ?>&query_averbada=<? echo(stripslashes($query_averbada)); ?>" class="style1"><img src="images/icones/adicionar_lista_avaliacao.jpg" width="34" height="34" border="0" title="Adicionar amostragem para avaliação" /></a></td>
					<td align="center"><a href="p_rel_avaliacao.php?codi_imo=<?php print("$not1[cod]"); ?>&codi=<?php echo("$codi"); ?>&pastai=<?php echo("$pastai"); ?>" class="style1"><img src="images/icones/visualizar_amostra_avaliacao.jpg" width="34" height="34" border="0" title="Avaliar este imóvel" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="1" colspan="2" align="left" bgcolor="e4e4e4"></td>
              </tr>
<?php
	$url = $REQUEST_URI;
	//echo $url;
	$url = urlencode($url);
?>

              <tr>
                <td colspan="2" align="left"><table width="100%" border="0" cellspacing="3" cellpadding="3">
                  <tr>
<? if($codi == $_SESSION['cod_imobiliaria']){ ?>
                    <td align="center"><a href="carrinho.php?cod=<?php print("$not1[cod]"); ?>&qtd=1"><img src="images/icones/carrinho_chaves.jpg" width="34" height="34" border="0" title="Separar chaves" /></a></td>
                    <? if($not1[chaves] <> ''){ ?>
					<td align="center"><a href="javascript:;" onClick="NewWindow('ata_chaves.php?cod=<?php print("$not1[cod]"); ?>&codi=<?php echo($codi); ?>', 'janela', 750, 500, 'yes')" class=style1><img src="images/icones/local_chaves.jpg" width="34" height="34" border="0" title="Local das chaves" /></a></td>
					<? }else{ ?>
					<td align="center"><img src="images/icones/local_chaves_apagada.jpg" width="34" height="34" border="0" title="Local das chaves" /></a></td>
					<? } ?>

<?    if ($not1[cliente] <> "") {
         if (($_SESSION['u_cod'] <> Trim($not1[angariador])) and (verificaFuncao("USER_ACESSA_PROPRIETARIO"))) {
?>
                   <td align="center"><img src="images/icones/proprietario_apagada.jpg" width="34" height="34" border="0" title="Não há Proprietário" /></td>
<?       } else { ?>
                   <td align="center"><a href="p_clientes.php?c_cod=<?php print("$not1[cliente]"); ?>&lista=1&contr=P"><img src="images/icones/proprietario.jpg" width="34" height="34" border="0" title="Proprietário" /></a></td>
<?       } ?>
<?    } else { ?>
                    <td align="center"><img src="images/icones/proprietario_apagada.jpg" width="34" height="34" border="0" title="Não há Proprietário" /></td>
<?    } ?>


<? } ?>
                    <td align="center"><a href="p_rel_int.php?cod=<?php print("$not1[cod]"); ?>"><img src="images/icones/clientes.jpg" width="34" height="34" border="0" title="Interessados" /></a></td>
                     <? if($not1[relacao_bens] <> ''){ ?>
					<td align="center"><a href="javascript:;" onClick="NewWindow('p_imp_bens.php?cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>', 'janela', 750, 500, 'yes')" class=style1><img src="images/icones/relacao_pertences.jpg" width="34" height="34" border="0" title="Relação de bens" /></a></td>
                    <? }else{ ?>
					<td align="center"><img src="images/icones/relacao_pertences_apagada.jpg" width="34" height="34" border="0" title="Relação de bens" /></td>
					<? } ?>

<?
// Verificar se foi inserido...
if(!$sid){
	$sid = session_id();
}

	$query_vi = "select cod, sid from imoveis_temp where sid='".$sid."' and cod='".$not1[cod]."' and
		interessado='".$int_cod."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result_vi = mysql_query($query_vi) or die ("Erro 771 - ".mysql_error());
	$conta_vi = mysql_num_rows($result_vi);
	if ($conta_vi == 0) {
?>
					<td align="center"><a href="add_prod.php?qtd=1&cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>&controle=V&url=<?php print("$url"); ?>"><img src="images/icones/adicionar_a_lista.jpg" width="34" height="34" border="0" title="Adicionar à lista" /></a></td>
<?
	} else {
?>
					<td align="center"><img src="images/icones/adicionar_a_lista_apagada.jpg" width="34" height="34" border="0" title="Imóvel já adicionado à lista" /></td>
<?
	}
?>
                    </tr>
					<tr>
                    <td align="center"><a href="detalhes.php?cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>&nomei=<?=$nomei ?>&pastai=<?=$pastai ?>"><img src="images/icones/mais_detalhes.jpg" width="34" height="34" border="0" title="Mais detalhes" /></a></td>
<? if($codi == $_SESSION['cod_imobiliaria']){
         if (($_SESSION['u_cod'] <> Trim($not1[angariador])) and (verificaFuncao("USER_ACESSA_PROPRIETARIO"))) {
?>
					<td align="center"><img src="images/icones/atualizar_imovel_apagado.jpg" width="34" height="34" border="0" title="Atualizar imóvel" /></a></td>
<?       } else { ?>
					<td align="center"><a href="p_edit_imoveis.php?cod=<?php print("$not1[cod]"); ?>"><img src="images/icones/atualizar_imovel.jpg" width="34" height="34" border="0" title="" /></a></td>
<?       } ?>

<?} else { ?>
					<td align="center"><img src="images/icones/atualizar_imovel_apagado.jpg" width="34" height="34" border="0" title="Atualizar imóvel" /></a></td>
<? } ?>
					<!--td align="center"><a href="p_imoveis.php"><img src="images/icones/lista_imoveis.jpg" width="34" height="34" border="0" title="Lista de Imóveis" /></a></td-->
                    <? if($not1[observacoes] <> '' && $codi == $_SESSION['cod_imobiliaria']){ ?>
					<td align="center"><a href="javascript:;" onClick="NewWindow('observacoes.php?cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>', 'janela', 750, 500, 'yes')" class=style1><img src="images/icones/atencao_observacao.jpg" width="34" height="34" border="0" title="Observações" /></a></td>
					<? }else{ ?>
		            <td align="center"><img src="images/icones/atencao_observacao_apagada.jpg" width="34" height="34" border="0" title="Observações" /></td><b></b>
					<? } ?>
					<? if($not1[angariador] <> ''){ ?>
					<td align="center"><a href="javascript:;" onClick="NewWindow('angariador.php?cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>', 'janela', 750, 500, 'yes')" class=style1><img src="images/icones/angariador.jpg" width="34" height="34" border="0" title="Angariador" /></a></td>
					<? }else{ ?>
					<td align="center"><img src="images/icones/angariador_apagada.jpg" width="34" height="34" border="0" title="Sem Angariador" /></a></td>
					<? } ?>
					<? if($not1[comissao_parceria] <> 0){ ?>
					<td align="center"><a href="javascript:;" onClick="NewWindow('comissoes_parceria.php?cod=<?php print("$not1[cod]"); ?>&codi=<?=$codi; ?>', 'janela', 750, 500, 'yes')" class=style1><img src="images/icones/comissao.jpg" width="34" height="34" border="0" title="Comissões da Parceria" /></a></td>
					<? }else{ ?>
		            <td align="center"><img src="images/icones/comissao_apagada.jpg" width="34" height="34" border="0" title="Comissões da Parceria" /></td><b></b>
					<? } ?>
						<td align="center"><a href="carrinho_imoveis.php?codi=<?=$codi;?>"><img src="images/icones/visualizar_a_lista.jpg" width="34" height="34" border="0" title="Visualizar Lista de Imóveis" /></a></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
<table border="0">
<tr><td valign="top">
              <span class="style48">&nbsp;</span>
</td></tr>
</table>
<?php
		$y++;
				#} ## fim numrows4 == 0
		} ## fim while imoveis cadastrados para locacao
	} ## fim seleciona imoveis disponiveis para locacao


	#
	##
	## conta imoveis encontrados

    if ($finalidade=='1' || $finalidade=='8') {

      if ($finalidade=='1') {
         $query_finalidade2 = " AND (m.finalidade='2')";
      } elseif($finalidade=='8') {
         $query_finalidade2 = " AND (m.finalidade='9')";
      }

		$query2 = "select count(m.cod) as contador
		from muraski m LEFT JOIN rebri_tipo t ON (m.tipo=t.t_cod) LEFT JOIN rebri_imobiliarias i ON (m.cod_imobiliaria=i.im_cod) WHERE i.im_desativar='0' AND (m.tipo LIKE '$tipo1' OR m.tipo_secundario LIKE '%-".$tipo1."-%') AND m.ref LIKE '$ref'
		AND m.n_quartos $comp1 '$n_quartos' AND m.valor $comp2 '$valor'
		$dist_mar1 AND m.tipo_logradouro like '%$tipo_logradouro%' AND m.end LIKE '%$end%' AND m.numero LIKE '%$numero_end%' AND m.cep LIKE '%$cep%' $bairro $caracteristica $query_estado $query_cidade
		$query_finalidade2 $query_averbada $sql_opcao AND m.disp_rede='1' AND m.ref!='x' AND m.relacao_bens LIKE '%$relacao_bens%' AND m.permuta LIKE '%$permuta%'
		AND m.permuta_txt LIKE '%$permuta_txt%' $oferta";
		// AND (current_date BETWEEN data_inicio AND data_fim)
	} else {
	    $query2 = "select count(m.cod) as contador
		from muraski m LEFT JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE (m.tipo LIKE '$tipo1' OR m.tipo_secundario LIKE '%-".$tipo1."-%') AND m.ref LIKE '$ref'
		AND m.n_quartos $comp1 '$n_quartos' AND m.valor $comp2 '$valor'
		$dist_mar1 AND m.tipo_logradouro like '%$tipo_logradouro%' AND m.end LIKE '%$end%' AND m.numero LIKE '%$numero_end%' AND m.cep LIKE '%$cep%' $bairro $caracteristica $query_estado $query_cidade
		$query_finalidade $query_averbada $sql_opcao AND m.ref!='x' AND m.relacao_bens LIKE '%$relacao_bens%' AND m.permuta LIKE '%$permuta%'
		AND m.permuta_txt LIKE '%$permuta_txt%' $oferta AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		// AND (current_date BETWEEN data_inicio AND data_fim)
	}
    
	//echo $query2;
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
		$paginas = $pages = ceil($not2[contador] / 10);
   		$pagina = $screen;
   		$url10 = "p_lista_ven.php?tipo1=".$tipo1."&ref=".$ref."&comp1=".$comp1."&comp2=".$comp2."&comp4=".$comp4."&n_quartos=".$n_quartos."&valor=".$valor."&dist_mar1=".stripslashes($dist_mar1)."&query_finalidade=".stripslashes($query_finalidade)."&finalidade=".$finalidade."&query_bairro=".$query_bairro."&query_caracteristica=".$query_caracteristica."&query_caracteristica2=".$query_caracteristica2."&query_estado=".stripslashes($query_estado)."&query_cidade=".stripslashes($query_cidade)."&permuta=".$permuta."&permuta_txt=".$permuta_txt."&tipo_logradouro=".$tipo_logradouro."&end=".$end."&numero_end=".$numero_end."&cep=".$cep."&ordem=".$ordem."&valor_oferta=".$valor_oferta."&relacao_bens=".$relacao_bens."&im_estado=".$im_estado."&local=".$local."&b_averbada=".$b_averbada."&b_sql_opcao=".$sql_opcao."&query_averbada=".stripslashes($query_averbada).$b_get.$c_get."&screen=";
?>
        </table>
        <table width="100%">
              <tr>
			  	<td colspan="2" bgcolor="#<?php print("$cor6"); ?>" class="style48" align="center">Foram encontrados <?php print("$not2[contador]"); ?> imóveis</td>
			  </tr>
               <tr bgcolor="#<?php print("$cor1"); ?>"><td colspan="2" class="style48" align="center">
               			<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_lista_ven.php?<?=$b_get ?><?=$c_get ?>&tipo1=<?=$tipo1 ?>&ref=<?=$ref ?>&comp1=<?=$comp1 ?>&comp2=<?=$comp2 ?>&comp4=<?=$comp4 ?>&n_quartos=<?=$n_quartos ?>&valor=<?=$valor ?>&dist_mar1=<?=stripslashes($dist_mar1) ?>&query_finalidade=<?=stripslashes($query_finalidade) ?>&finalidade=<?=$finalidade ?>&query_bairro=<?=$query_bairro ?>&query_caracteristica=<?=$query_caracteristica ?>&query_caracteristica2=<?=$query_caracteristica2 ?>&query_estado=<?=stripslashes($query_estado) ?>&query_cidade=<?=stripslashes($query_cidade) ?>&permuta=<?=$permuta ?>&permuta_txt=<?=$permuta_txt ?>&tipo_logradouro=<?=$tipo_logradouro ?>&end=<?=$end ?>&numero_end=<?=$numero_end ?>&cep=<?=$cep ?>&ordem=<?=$ordem ?>&valor_oferta=<?=$valor_oferta ?>&relacao_bens=<?=$relacao_bens ?>&im_estado=<?=$im_estado ?>&local=<?=$local ?>&b_averbada=<?=$b_averbada ?>&b_sql_opcao=<?$b_sql_opcao?>&query_averbada=<?=stripslashes($query_averbada)?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_lista_ven.php?<?=$b_get ?><?=$c_get ?>&tipo1=<?=$tipo1 ?>&ref=<?=$ref ?>&comp1=<?=$comp1 ?>&comp2=<?=$comp2 ?>&comp4=<?=$comp4 ?>&n_quartos=<?=$n_quartos ?>&valor=<?=$valor ?>&dist_mar1=<?=stripslashes($dist_mar1) ?>&query_finalidade=<?=stripslashes($query_finalidade) ?>&finalidade=<?=$finalidade ?>&query_bairro=<?=$query_bairro ?>&query_caracteristica=<?=$query_caracteristica ?>&query_caracteristica2=<?=$query_caracteristica2 ?>&query_estado=<?=stripslashes($query_estado) ?>&query_cidade=<?=stripslashes($query_cidade) ?>&permuta=<?=$permuta ?>&permuta_txt=<?=$permuta_txt ?>&tipo_logradouro=<?=$tipo_logradouro ?>&end=<?=$end ?>&numero_end=<?=$numero_end ?>&cep=<?=$cep ?>&ordem=<?=$ordem ?>&valor_oferta=<?=$valor_oferta ?>&relacao_bens=<?=$relacao_bens ?>&im_estado=<?=$im_estado ?>&local=<?=$local ?>&b_averbada=<?=$b_averbada ?>&b_sql_opcao=<?$b_sql_opcao?>&query_averbada=<?=stripslashes($query_averbada)?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
                  				<td class="style1" align="center">
								<?
   									$i = 0;
   									$completa = "";
   									if ($paginas > 9){
      									if ($pagina < 5){
   	   										$inicio = 1;
         									$final = 9;
      									}elseif($pagina > $paginas - 5){
   	   										$inicio = $paginas - 9;
         									$final = $paginas;
      									}else{
   	   										$inicio = $pagina - 4;
         									$final = $pagina + 4;
      									}
   									}else{
	   										$inicio = 1;
      										$final = $paginas;
   									}

   									for ($j = $inicio; $j < ($final+1); $j++){
      									if(($paginas > 9) && (strlen($j)==1)){
		   									$j = "0".$j;
      									}

      									$url2 = $url10 . $j;

      									if($j == $pagina){
            								print "<a href=\"$url2\" class='style1'>| <b>$j</b> |</a>";
 	   									}else{
     	      								print "<a href=\"$url2\" class='style1'>| $j |</a>";
  	   									}
   									}
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="p_lista_ven.php?<?=$b_get ?><?=$c_get ?>&tipo1=<?=$tipo1 ?>&ref=<?=$ref ?>&comp1=<?=$comp1 ?>&comp2=<?=$comp2 ?>&comp4=<?=$comp4 ?>&n_quartos=<?=$n_quartos ?>&valor=<?=$valor ?>&dist_mar1=<?=stripslashes($dist_mar1) ?>&query_finalidade=<?=stripslashes($query_finalidade) ?>&finalidade=<?=$finalidade ?>&query_bairro=<?=$query_bairro ?>&query_caracteristica=<?=$query_caracteristica ?>&query_caracteristica2=<?=$query_caracteristica2 ?>&query_estado=<?=stripslashes($query_estado) ?>&query_cidade=<?=stripslashes($query_cidade) ?>&permuta=<?=$permuta ?>&permuta_txt=<?=$permuta_txt ?>&tipo_logradouro=<?=$tipo_logradouro ?>&end=<?=$end ?>&numero_end=<?=$numero_end ?>&cep=<?=$cep ?>&ordem=<?=$ordem ?>&valor_oferta=<?=$valor_oferta ?>&relacao_bens=<?=$relacao_bens ?>&im_estado=<?=$im_estado ?>&local=<?=$local ?>&b_averbada=<?=$b_averbada ?>&b_sql_opcao=<?$b_sql_opcao?>&query_averbada=<?=stripslashes($query_averbada)?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_lista_ven.php?<?=$b_get ?><?=$c_get ?>&tipo1=<?=$tipo1 ?>&ref=<?=$ref ?>&comp1=<?=$comp1 ?>&comp2=<?=$comp2 ?>&comp4=<?=$comp4 ?>&n_quartos=<?=$n_quartos ?>&valor=<?=$valor ?>&dist_mar1=<?=stripslashes($dist_mar1) ?>&query_finalidade=<?=stripslashes($query_finalidade) ?>&finalidade=<?=$finalidade ?>&query_bairro=<?=$query_bairro ?>&query_caracteristica=<?=$query_caracteristica ?>&query_caracteristica2=<?=$query_caracteristica2 ?>&query_estado=<?=stripslashes($query_estado) ?>&query_cidade=<?=stripslashes($query_cidade) ?>&permuta=<?=$permuta ?>&permuta_txt=<?=$permuta_txt ?>&tipo_logradouro=<?=$tipo_logradouro ?>&end=<?=$end ?>&numero_end=<?=$numero_end ?>&cep=<?=$cep ?>&ordem=<?=$ordem ?>&valor_oferta=<?=$valor_oferta ?>&relacao_bens=<?=$relacao_bens ?>&im_estado=<?=$im_estado ?>&local=<?=$local ?>&b_averbada=<?=$b_averbada ?>&b_sql_opcao=<?$b_sql_opcao?>&query_averbada=<?=stripslashes($query_averbada)?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>
<?
	}## fim while conta imoveis
	/*
	mysql_free_result($result1);
	mysql_free_result($result2);
	*/
	mysql_close($con);

## se não tem sessao
//} else {
?>
<?php
//include("login2.php");
?>
<?php
//}
?>
</td>
      </tr>
    </table></td>
  </tr>
</table>
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
    <td align="center" class="style48">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
</body>
</html>
