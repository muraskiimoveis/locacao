<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">

<style>
body {
margin: 15px;
}

  a.style1:link a.style1:visited a.style1:hover a.style1:active  {
     color: #666666;
     text-align: justify;
     text-decoration: none;
     font-weight: normal;
  }


</style>

<?

require_once 'conect.php';

if(substr(1,3) == '192'){$ORIGEM = $_SERVER['HTTP_HOST'];}else{$ORIGEM = $_SERVER['HTTP_HOST'];}

if ($coord <> "") {
   $tcoord = explode(", ",$coord);
   $vcoord = "(".$coord.")";
}
?>

    <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAGF5PMGLCg44s7rGV02KSLhT7OuU2kuzJdn0XAl8Jzm25cIogHxQqOkiq7af9dRmp0ntksIuetvFzuA"
      type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[

    var map;
    var geocoder;

    function load() {
      map = new GMap2(document.getElementById("map"));
      map.addControl(new GSmallMapControl());
      map.addControl(new GMapTypeControl());

<? if ($coord == "inicio") { ?>
     map.setCenter(new GLatLng(-16.558981881684787, -49.39453125), 4);
<? } else { ?>
     icon = new GIcon(G_DEFAULT_ICON);
   	<? if($ori=='rebri'){ ?>
  	  		icon.image = "<? echo URL_ROOT?>sistema/images/logo_rebri.png";
			icon.shadow = "<? echo URL_ROOT?>sistema/images/sombra_rebri.png";
			icon.iconSize = new GSize(50, 45);
  			icon.shadowSize = new GSize(50, 45);
   	<? } elseif ($ori=='muraski') { ?>
  	  		icon.image = "http://<? echo $ORIGEM; ?>/intranet/sistema/images/icone_muraski.png";
			icon.shadow = "http://<? echo $ORIGEM; ?>/intranet/sistema/images/sombra_muraski.png";
			icon.iconSize = new GSize(42, 33);
  			icon.shadowSize = new GSize(42, 33);
   	<? } elseif ($ori=='comercio') { ?>
  	  		icon.image = "<? echo URL_ROOT?>sistema/images/icone_branco.png";
 	  		icon.shadow = "<? echo URL_ROOT?>sistema/images/icone_sombra.png";
			icon.iconSize = new GSize(25, 32);
  			icon.shadowSize = new GSize(25, 32);
   	<? } ?>
     icon.infoWindowAnchor = new GPoint(30, 1);
  	  markerOptions = { icon:icon };

     var center = new GLatLng(<?=$tcoord[0]?>, <?=$tcoord[1]?>);
//     map.setCenter(center, 17);
     map.setCenter(center, 16);

     marcador = new GMarker(center, markerOptions);
     map.addOverlay(marcador);
//     marcador.openInfoWindowHtml("Para reposicionar o imóvel, clique <br />no novo ponto ou pesquise por <br /> outro endereço.");

<? } ?>
      geocoder = new GClientGeocoder();
//      findLocation("80010-010");

     GEvent.addListener(map, 'click', function(overlay, point)	// Add a click listener
     {
      if (overlay)
      {
      } else if (point)
      {
         addPoint( point ) ;
      }
     });

    }

    // addAddressToMap() is called when the geocoder returns an
    // answer.  It adds a marker to the map with an open info window
    // showing the nicely formatted version of the address and the country code.
    function addAddressToMap(response) {
      map.clearOverlays();
      if (!response || response.Status.code != 200) {
        alert("Sorry, we were unable to geocode that address");
      } else {
        place = response.Placemark[0];
        point = new GLatLng(place.Point.coordinates[1],
                            place.Point.coordinates[0]);
        addPoint1(point);

      }
    }

    function addPoint(point) {
     tam = 16;
     icon = new GIcon(G_DEFAULT_ICON);
   	<? if($ori=='rebri'){ ?>
  	  		icon.image = "<? echo URL_ROOT?>sistema/images/logo_rebri.png";
			icon.shadow = "<? echo URL_ROOT?>sistema/images/sombra_rebri.png";
			icon.iconSize = new GSize(50, 45);
  			icon.shadowSize = new GSize(50, 45);
   	<? } elseif ($ori=='muraski') { ?>
  	  		icon.image = "http://<? echo $ORIGEM; ?>/intranet/sistema/images/icone_muraski.png";
			icon.shadow = "http://<? echo $ORIGEM; ?>/intranet/sistema/images/sombra_muraski.png";
			icon.iconSize = new GSize(42, 33);
  			icon.shadowSize = new GSize(42, 33);
   	<? } elseif ($ori=='comercio') { ?>
  	  		icon.image = "<? echo URL_ROOT?>sistema/images/icone_branco.png";
 	  		icon.shadow = "<? echo URL_ROOT?>sistema/images/icone_sombra.png";
			icon.iconSize = new GSize(25, 32);
  			icon.shadowSize = new GSize(25, 32);
   	<? } ?>
     icon.infoWindowAnchor = new GPoint(30, 1);
  	  markerOptions = { icon:icon };


        map.clearOverlays();
        document.localizacao.coordenadas.value = point;
        map.setCenter(point, tam);
//        map.setCenter(point);
        marker = new GMarker(point, markerOptions);
        map.addOverlay(marker);
//        marker.openInfoWindowHtml("Para reposicionar o imóvel,<br /> clique no novo ponto");
    }

    function addPoint1(point) {
      var campo_pesquisa = document.forms[0].q.value;
      if (campo_pesquisa.substring(5,6) == "-") {
         tam = 13;
      } else {
		   tam = 16;
      }

     icon = new GIcon(G_DEFAULT_ICON);
   	<? if($ori=='rebri'){ ?>
  	  		icon.image = "<? echo URL_ROOT?>sistema/images/logo_rebri.png";
			icon.shadow = "<? echo URL_ROOT?>sistema/images/sombra_rebri.png";
			icon.iconSize = new GSize(50, 45);
  			icon.shadowSize = new GSize(50, 45);
   	<? } elseif ($ori=='muraski') { ?>
  	  		icon.image = "http://<? echo $ORIGEM; ?>/intranet/sistema/images/icone_muraski.png";
			icon.shadow = "http://<? echo $ORIGEM; ?>/intranet/sistema/images/sombra_muraski.png";
			icon.iconSize = new GSize(42, 33);
  			icon.shadowSize = new GSize(42, 33);
   	<? } elseif ($ori=='comercio') { ?>
  	  		icon.image = "<? echo URL_ROOT?>sistema/images/icone_branco.png";
 	  		icon.shadow = "<? echo URL_ROOT?>sistema/images/icone_sombra.png";
			icon.iconSize = new GSize(25, 32);
  			icon.shadowSize = new GSize(25, 32);
   	<? } ?>
     icon.infoWindowAnchor = new GPoint(30, 1);
  	  markerOptions = { icon:icon };


        map.clearOverlays();
        document.localizacao.coordenadas.value = point;
        map.setCenter(point, tam);
//        map.setCenter(point);
        marker = new GMarker(point, markerOptions);
        map.addOverlay(marker);
//        marker.openInfoWindowHtml("Para reposicionar o imóvel,<br /> clique no novo ponto");
    }


    // showLocation() is called when you click on the Search button
    // in the form.  It geocodes the address entered into the form
    // and adds a marker to the map at that location.
    function showLocation() {
      var address = document.forms[0].q.value;
      geocoder.getLocations(address, addAddressToMap);
    }

   // findLocation() is used to enter the sample addresses into the form.
    function findLocation(address) {
      document.forms[0].q.value = address;
      showLocation();
    }
    //]]>
    </script>
  </head>

  <body onload="load()">

    <p class="style1" align="Center"><strong>Localizar Imóvel</strong>
    <br />Para pesquisar, digite o endereço ou CEP</p>
    <!-- Creates a simple input box where you can enter an address
         and a Search button that submits the form. //-->

<table width="95%" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
 <!-- Div para a listagem dos endereços -->
 <tr><td bgcolor="#F0F0F0"><div id="locais" class=style1></div></td></tr>
 <tr><td bgcolor="#F0F0F0">
   <table width="100%" cellpadding="0" cellspacing="5">
  <!-- Formulário para o envio de consultas. Note que a função -->
  <!-- realizaConsulta é invocada no evento onSubmit da tag <form> -->
    <form action="#" onsubmit="showLocation(); return false;" name="pesquisa">
     <tr><td width="100" class="style1" valign="top"><strong>Endereço / CEP:</strong></td><td class="style1"><input type="text" id="q" name="q" value="Endereço / Cep" class="campo" size="40" />
     &nbsp;
      <input type="submit" name="find" value="Buscar" class="campo3" /><br /> (CEP deve ser informado no formato "80222-333") </td></tr>
     </form>
   </table>
  </td></tr>
 <tr><td bgcolor="#F0F0F0" height="30">
  <form action="" name=localizacao>
   <table width="100%" cellpadding="0" cellspacing="5">
   <Tr><td valign="top" class="style1" width="100"><strong>Coordenadas:</strong> </td><td class="style1" ><input type="text" name="coordenadas" size = "50" readonly="readonly" value="<?=$vcoord?>" class="campo" />
      <input type="Button" name="B1" value="Gravar" class="campo3" onclick="window.opener.document.form1.ncoordenadas.value=document.localizacao.coordenadas.value;window.opener.focus(); window.close();"/>
      <br />(assim que a posição estiver correta, utilize o botão gravar para retornar ao formulário)
      </td></Tr>
      <? /** onclick="javascript: window.opener.form1.ende_mapa.value = document.localizacao.ncoordenadas.value; window.close();" /**/ ?>
   </table>
   </form>
 </td></tr>
 <tr><td aligh="center" bgcolor="#F0F0F0">
<table border="0" cellspacing="1" cellpadding="0" bgcolor="#828282" align="center">
  <tr>
    <td><table border="0" cellspacing="5" cellpadding="0" bgcolor="#CCCCCC">
      <tr>
        <td>
          <div id="map" style="width: 600px; height: 500px"></div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
 </td></tr>

</table>
   </body>
</html>
