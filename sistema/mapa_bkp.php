<?
include("conect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1"--> 
<link href="style.css" rel="stylesheet" type="text/css" />
<title>Mapa</title>
<? //if($_SERVER['SERVER_NAME'] == "www.redebrasileiradeimoveis.com.br" OR $_SERVER['SERVER_NAME'] == "redebrasileiradeimoveis.com.br"){ ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAGF5PMGLCg44s7rGV02KSLhT7OuU2kuzJdn0XAl8Jzm25cIogHxQqOkiq7af9dRmp0ntksIuetvFzuA" type="text/javascript"></script>
<? //}else{ ?>
<!--script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAGF5PMGLCg44s7rGV02KSLhRF2hlI6bPw_gvu-ScEwKGELnNcjBS7fcqTDDsuj6N3JMR-cpd_gA_6_w" type="text/javascript"></script-->
<? //} ?>

<?

if($_GET['end']){
  $end = $_GET['end'];
}else{
  $end = $_POST['end'];
}

if($_GET['ori']){
  $ori = $_GET['ori'];
}else{
  $ori = $_POST['ori'];
}

if($_GET['zoom']){
  $zoom = $_GET['zoom'];
}else{
  $zoom = $_POST['zoom'];
}

$endereco = explode("|", $end);

require_once("class_browser.php");

$browser = new Browser;

$bairro15 = explode("--", $endereco[3]);
$bairro25 = str_replace("-","",$bairro15);

if($endereco[3]<>''){
	$buscab = mysql_query("SELECT c.tipo_comercio, c.nome_comercio, c.logradouro_comercio, c.endereco_comercio, c.numero_comercio, ci.ci_nome, e.e_uf, t.tc_nome FROM comercios c INNER JOIN rebri_cidades ci ON (c.cidade_comercio=ci.ci_cod) INNER JOIN rebri_estados e ON (c.estado_comercio=e.e_cod) INNER JOIN rebri_tipo_comercio t ON (c.tipo_comercio=t.tc_cod) WHERE c.tipo_comercio LIKE '".$id."' AND c.bairro_comercio in (" . implode(',',$bairro25) . ")");
	$cont = 0;
	while($linha = mysql_fetch_array($buscab)){
        $nome_comercio[] = mb_convert_encoding($linha['nome_comercio'],"UTF-8");
        $tipo_comercio[] = mb_convert_encoding($linha['tc_nome'],"UTF-8");
        $tipoc[] = $linha['tipo_comercio'];
		$endereco_completo = $linha['logradouro_comercio']." ".$linha['endereco_comercio'].", ".$linha['numero_comercio']." - ".$linha['ci_nome'].", ".$linha['e_uf'];
    

		$ende = "$endereco_completo";


//if($_SERVER['SERVER_NAME'] == "www.redebrasileiradeimoveis.com.br" OR $_SERVER['SERVER_NAME'] == "redebrasileiradeimoveis.com.br"){
		$page =	$browser->get_url(array(
				"url"=>"http://maps.google.com/maps/geo?q=".str_replace(" ", "+", $ende)."&output=csv&key=ABQIAAAAGF5PMGLCg44s7rGV02KSLhT7OuU2kuzJdn0XAl8Jzm25cIogHxQqOkiq7af9dRmp0ntksIuetvFzuA"
			)
		);
		
/*
}else{
  		$page =	$browser->get_url(array(
				"url"=>"http://maps.google.com/maps/geo?q=".str_replace(" ", "+", $end)."&output=csv&key=ABQIAAAAGF5PMGLCg44s7rGV02KSLhRF2hlI6bPw_gvu-ScEwKGELnNcjBS7fcqTDDsuj6N3JMR-cpd_gA_6_w"
			)
		);
}
*/

	$retorno = $page["content"];
	
	$montagem = explode(",", $retorno);
	$latitude[] = $montagem[2];
	$longitude[] = $montagem[3];
	$cont++;
	}
}	
?>
<script language="javascript">

	var map = null;
    var geocoder = null;    
    
    function initialize() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(-14.604847155053898, -53.26171875), 13);
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
        geocoder = new GClientGeocoder();  
      }
          
	showAddress("<?php echo mb_convert_encoding($endereco[0],'UTF-8'); ?>");	  
	
		
    var ma = new Array();
    var nome = new Array();
    var redIcon = new Array();
    var markerOptions2 = new Array();
    var tooltip;
	
<?php for($i=0; $i < $cont; $i++){ ?>
		<? if($tipoc[$i]=='1'){ ?>
		    redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_academias.png";
			redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='2'){ ?> 
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_aeroportos.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='3'){ ?> 
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_alimentos.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='4'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_bancos.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='5'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_bares.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='6'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_lotericas.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='7'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_cinemas.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='8'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_clubes.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='9'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_conveniencias.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='10'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_correios.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='11'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_escolas.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='12'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_esportes.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='13'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_farmacias.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='14'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_hospitais.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='15'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_hoteis.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='16'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_igrejas.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='17'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_industrias.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='18'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_lanchonetes.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='19'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_medicos.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='20'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_transportes.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='21'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_padarias.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='22'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_parques.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='23'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_policias.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='24'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_restaurantes.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='25'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_shoppings.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='26'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sorvetes.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='27'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_supermercados.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? }elseif($tipoc[$i]=='28'){ ?>
			redIcon[<?php echo $i; ?>] = new GIcon(G_DEFAULT_ICON);
		  	redIcon[<?php echo $i; ?>].image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_veterinarios.png";
		  	redIcon[<?php echo $i; ?>].shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_sombra.png";
			redIcon[<?php echo $i; ?>].iconSize = new GSize(25, 32);
  			redIcon[<?php echo $i; ?>].shadowSize = new GSize(25, 32);	
			markerOptions2[<?php echo $i; ?>] = { icon:redIcon[<?php echo $i; ?>] };
		<? } ?>
	ma[<?php echo $i; ?>] = new GMarker(new GLatLng("<?=$latitude[$i]?>","<?=$longitude[$i]?>"), markerOptions2[<?php echo $i; ?>]);
    map.addOverlay(ma[<?php echo $i; ?>]);
    nome[<?php echo $i; ?>] = "<b><?php echo $nome_comercio[$i]; ?></b><br>Categoria: <?php echo $tipo_comercio[$i]; ?>";
    GEvent.addListener(ma[<?php echo $i; ?>], "mouseover", function () {ma[<?php echo $i; ?>].openInfoWindowHtml(nome[<?php echo $i; ?>]);});
<?php } ?>

	} 
	
	var blueIcon = new GIcon(G_DEFAULT_ICON);
   	<? if($ori=='rebri'){ ?>
   	  	<? if($endereco[5]=='1'){ ?>
   	  		blueIcon.image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_rebri_gr.png";
			blueIcon.shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/sombra_rebri_gr.png";
   	  	<? }else{ ?>
   	  		blueIcon.image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/logo_rebri.png";
			blueIcon.shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/sombra_rebri.png";
   	  	<? } ?>
	<? }else{ ?>
		<? if($endereco[5]=='1'){ ?>
   	  		blueIcon.image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_muraski_gr.png";
			blueIcon.shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/sombra_muraski_gr.png";
   	  	<? }else{ ?>
   	  		blueIcon.image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/icone_muraski.png";
			blueIcon.shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/sombra_muraski.png";
   	  	<? } ?>
	<? } ?>
	<? if($ori=='rebri'){ ?>
		<? if($endereco[5]=='1'){ ?>
			blueIcon.iconSize = new GSize(70, 53);
  			blueIcon.shadowSize = new GSize(70, 53);  	
		<? }else{ ?>
			blueIcon.iconSize = new GSize(50, 45);
  			blueIcon.shadowSize = new GSize(50, 45);  	
		<? } ?>
  	<? }else{ ?>
  		<? if($endereco[5]=='1'){ ?>
			blueIcon.iconSize = new GSize(60, 47);
  			blueIcon.shadowSize = new GSize(60, 47);
		<? }else{ ?>
			blueIcon.iconSize = new GSize(42, 33);
  			blueIcon.shadowSize = new GSize(42, 33);
		<? } ?>
  	<? } ?>

	markerOptions = { icon:blueIcon };
	
    function showAddress(address) {
      if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
              
            } else {
              map.setCenter(point, 16);
              var marker = new GMarker(point, markerOptions);
              map.addOverlay(marker);
              marker.openInfoWindowHtml("<b><?=mb_convert_encoding($endereco[2],'UTF-8') ?></b> ref.: <?=$endereco[1] ?><br><?=mb_convert_encoding($endereco[4],'UTF-8') ?>");
              GEvent.addListener(marker, "click", function () {marker.openInfoWindowHtml("<b><?=mb_convert_encoding($endereco[2],'UTF-8') ?></b> ref.: <?=$endereco[1] ?><br><?=mb_convert_encoding($endereco[4],'UTF-8') ?>");});
            }
          }
        );
      }
    }	
    

</script>
<style type="text/css">
	.gmnoprint{
		font-family:Arial, Helvetica, sans-serif;
		font-size:13px;
	}
</style>
</head>

<body onload="initialize()" onunload="GUnload()">
<input type="hidden" name="end" id="end" value="<?=$end ?>">
<input type="hidden" name="ori" id="ori" value="<?=$ori ?>">
<input type="hidden" name="zoom" id="zoom" value="<?=$zoom ?>">
<table border="0" cellspacing="1" cellpadding="0" bgcolor="#828282">
  <tr>
    <td><table border="0" cellspacing="5" cellpadding="0" bgcolor="#CCCCCC">
      <tr>
        <td><div id="map_canvas" style="width:750px; height:540px; margin:0; padding:0; vertical-align:top"></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<?
if($endereco[3]<>''){
    if(!$con){
    include("connect.php");
  } 
$buscas = mysql_query("SELECT tc.tc_cod, tc.tc_nome FROM rebri_tipo_comercio tc INNER JOIN comercios c ON (c.tipo_comercio=tc.tc_cod) WHERE c.bairro_comercio in (" . implode(',',$bairro25) . ") GROUP BY c.tipo_comercio ORDER BY tc_nome ASC");
if(mysql_num_rows($buscas) > 0){
?>
<table width="762" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td height="10"></td>
      </tr>
	  <tr>
        <td class="style1" aling="left"><b><? echo mb_convert_encoding("SERVI&Ccedil;OS PR&Oacute;XIMOS:","UTF-8"); ?></b></td>
      </tr>
	  <tr>
        <td class="style1"><table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#E0E0E0">
           <tr>
             <td bgcolor="#EDEEEE"><table width="100%" border="0" cellspacing="7" cellpadding="0">
		       <tr>
		         <td align="left" class="style1">
		<?
			$col = 1;
			while($linhas = mysql_fetch_array($buscas)){
			  	if ($col > 9) {
					print "</td></tr><tr><td class=\"style1\">";
					$col = 1;
				}	
		?>
			   | <a href="mapa.php?id=<?php echo($linhas['tc_cod']); ?>&end=<?php echo(urlencode($end)); ?>&ori=<?php echo("$ori"); ?>&zoom=1" class="style1"><b><? echo mb_convert_encoding($linhas['tc_nome'],"UTF-8"); ?></b></a>
		<?
			$col++;
			}
		?>
			| <a href="mapa.php?id=<?php echo("%"); ?>&end=<?php echo(urlencode($end)); ?>&ori=<?php echo("$ori"); ?>&zoom=1" class="style1"><b>Todos</b></a> | 
		        </td>	
	           </tr></table> 
		    </td>
		 </tr>
		</table></td>
      </tr>
</table>
<?
}
}
?>
</body>
</html>