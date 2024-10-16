<!DOCTYPE HTML>
<!-- <html lang="pt-br"> -->
<html>
<head>
<!-- <meta charset="iso-8859-1"> -->
<meta http-equiv="Content-Language" content="pt-br, en, fr, it">
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
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBLtW8gKveGtfB3Dnn915JK3VVUdI5DtiM&libraries=places">
</script>

<script type="text/javascript">

      var map;
      var geocoder;
      var localicon;
      var marker;

      function load() 
      {
          
          <? if($ori=='rebri'){ ?>
              localicon = "<? echo URL_ROOT?>sistema/images/logo_rebri.png";
          <? } elseif ($ori=='muraski') { ?>
              localicon = "http://<? echo $ORIGEM; ?>/intranet/sistema/images/icone_muraski.png";
          <? } elseif ($ori=='comercio') { ?>
              localicon = "<? echo URL_ROOT?>sistema/images/icone_branco.png";
          <? } ?>

          map = new google.maps.Map(
              document.getElementById('map'),{
                <?if($coord == "inicio"){?>
                  center: new google.maps.LatLng(-16.558981881684787,-49.39453125),
              <?}else{ ?>
                  center: new google.maps.LatLng(<?=$tcoord[0]?>, <?=$tcoord[1]?>),
              <?}?>
          
              zoom: 18,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          });

          marker = new google.maps.Marker({
              <?if($coord == "inicio"){?>
                  position: new google.maps.LatLng(-16.558981881684787,-49.39453125),
              <?}else{ ?>
                  position: new google.maps.LatLng(<?=$tcoord[0]?>, <?=$tcoord[1]?>),
              <?}?>
              title: "Localizar Imovel",
              map: map,
              icon: localicon
          });

      } // Fim da load()


      //google.maps.event.addDomListener(window, 'load', load);

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
          <?if($coord == "inicio"){?>
                  center: new google.maps.LatLng(-16.558981881684787,-49.39453125),
              <?}else{ ?>
                  center: new google.maps.LatLng(<?=$tcoord[0]?>, <?=$tcoord[1]?>),
              <?}?>          
              zoom: 18,
        });
        const card = document.getElementById("pac-card");
        const input = document.getElementById("pac-input");
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
        const autocomplete = new google.maps.places.Autocomplete(input);
        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo("bounds", map);
        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(["address_components", "geometry", "icon", "name"]);
        const infowindow = new google.maps.InfoWindow();
        const infowindowContent = document.getElementById("infowindow-content");
        infowindow.setContent(infowindowContent);
        const marker = new google.maps.Marker({
          map,
          anchorPoint: new google.maps.Point(0, -29),
        });
        autocomplete.addListener("place_changed", () => {
          infowindow.close();
          marker.setVisible(false);
          const place = autocomplete.getPlace();

          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("Nenhum detalhe encontrado para : '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17); // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);
          let address = "";

          if (place.address_components) {
            address = [
              (place.address_components[0] &&
                place.address_components[0].short_name) ||
                "",
              (place.address_components[1] &&
                place.address_components[1].short_name) ||
                "",
              (place.address_components[2] &&
                place.address_components[2].short_name) ||
                "",
            ].join(" ");
          }
          infowindowContent.children["place-icon"].src = place.icon;
          infowindowContent.children["place-name"].textContent = place.name;
          infowindowContent.children["place-address"].textContent = address;
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          const radioButton = document.getElementById(id);
          radioButton.addEventListener("click", () => {
            autocomplete.setTypes(types);
          });
        }
        setupClickListener("changetype-all", []);
        setupClickListener("changetype-address", ["Endereco"]);
        setupClickListener("changetype-establishment", ["Estabelecimentos"]);
        setupClickListener("changetype-geocode", ["Geocode"]);
        document
          .getElementById("use-strict-bounds")
          .addEventListener("click", function () {
            console.log("Checkbox clicked! New state=" + this.checked);
            autocomplete.setOptions({ strictBounds: this.checked });
          });
      }

    </script>
</head>
<body onload="load()">
  <p class="style1" align="Center"><strong>Localizar Im�vel</strong>
  <br />Para pesquisar, digite o endere�o ou CEP</p>
    <!-- Creates a simple input box where you can enter an address
         and a Search button that submits the form. //-->
  <table width="95%" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
    <!-- Div para a listagem dos endere�os -->
    <tr><td bgcolor="#F0F0F0"><div id="locais" class=style1></div></td></tr>
    <tr>
      <td bgcolor="#F0F0F0">
        <table width="100%" cellpadding="0" cellspacing="5">
    <!-- Formul�rio para o envio de consultas. Note que a fun��o -->
    <!-- realizaConsulta � invocada no evento onSubmit da tag <form> -->
          <form action="#" onsubmit="showLocation(); return false;" name="pesquisa">
            <tr>
              <td width="100" class="style1" valign="top"><strong>Endere�o / CEP:</strong></td><td class="style1"><input type="text" id="q" name="q" value="Endere�o / Cep" class="campo" size="40" />
                &nbsp;
                <input type="submit" name="find" value="Buscar" class="campo3" /><br /> (CEP deve ser informado no formato "80222-333") </td></tr>
          </form>
        </table>
      </td>
    </tr>
    <tr>
      <td bgcolor="#F0F0F0" height="30">
        <form action="" name=localizacao>
          <table width="100%" cellpadding="0" cellspacing="5">
            <tr>
                <td valign="top" class="style1" width="100"><strong>Coordenadas:</strong> </td><td class="style1" ><input type="text" name="coordenadas" size = "50" readonly="readonly" value="<?=$vcoord?>" class="campo" />
                  <input type="Button" name="B1" value="Gravar" class="campo3" onclick="window.opener.document.form1.ncoordenadas.value=document.localizacao.coordenadas.value;window.opener.focus(); window.close();"/>
                  <br />(assim que a posi��o estiver correta, utilize o bot�o gravar para retornar ao formul�rio)
              </td>
            </tr>
            <? /** onclick="javascript: window.opener.form1.ende_mapa.value = document.localizacao.ncoordenadas.value; window.close();" /**/ ?>
          </table>
        </form>
      </td>
    </tr>
    <tr>
      <td aligh="center" bgcolor="#F0F0F0">
        <table border="0" cellspacing="1" cellpadding="0" bgcolor="#828282" align="center">
          <tr>
            <td>
              <table border="0" cellspacing="5" cellpadding="0" bgcolor="#CCCCCC">
                <tr>
                  <td>
                    <div id="map" style="width: 600px; height: 500px"></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
