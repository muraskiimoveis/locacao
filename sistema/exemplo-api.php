<!DOCTYPE html>
<html>
<head>
<!-- <meta charset="iso-8859-1"> -->
<!-- <meta http-equiv="Content-Language" content="pt-br, en, fr, it"> -->
<link rel="stylesheet" href="style.css" type="text/css">

<title>Muraski Imoveis</title>
<!--<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
<script
    src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBLtW8gKveGtfB3Dnn915JK3VVUdI5DtiM&callback=initMap&libraries=places&v=weekly"
    defer
></script>
<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
        * element that contains the map. */
    #map {
        height: 100%;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {

        height: 100%;
        /*margin: 0; */
        margin: 15px;
        padding: 0;
    }

    #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
    }

    #infowindow-content .title {
        font-weight: bold;
    }

    #infowindow-content {
        display: none;
    }

    #map #infowindow-content {
        display: inline;
    }

    .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
    }

    #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
    }

    .pac-controls {
        display: inline-block;
        padding: 5px 11px;
    }

    .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #pac-geocode {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
    }
    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 18px;
        font-weight: 400;
        padding: 6px 12px;
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
<script type="text/javascript">

    var geocoder;
    var localicon;

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    function initMap() 
    {

        <? if($ori=='rebri'){ ?>
                localicon = "<? echo URL_ROOT?>sistema/images/logo_rebri.png";
        <? } elseif ($ori=='muraski') { ?>
                localicon = "http://<? echo $ORIGEM; ?>/intranet/sistema/images/icone_muraski.png";
        <? } elseif ($ori=='comercio') { ?>
                localicon = "<? echo URL_ROOT?>sistema/images/icone_branco.png";
        <? } ?>

        const map = new google.maps.Map(document.getElementById("map"), {
            <?if($coord == "inicio"){?>
                center: { lat: -16.558981881684787, lng: -49.39453125 },
            <?}else{ ?>
                center: { lat: <?=$tcoord[0]?>, lng: <?=$tcoord[1]?> },
            <?}?>
            zoom: 17,
            //zoomControl:false,
            //streetViewControl:false,
            disableDefaultUI:true,
        });

        // const marker = new google.maps.Marker({
        //      <?//if($coord == "inicio"){?>
        //          position: new google.maps.LatLng(-16.558981881684787,-49.39453125),
        //      <?//}else{ ?>
        //          position: new google.maps.LatLng(<?//=$tcoord[0]?>, <?//=$tcoord[1]?>),
        //      <?//}?>
        //      title: "Local do Imovel",
        //      map: map,
        //      icon: localicon
        // });

        const card = document.getElementById("pac-card");
        const input = document.getElementById("pac-input");
        const geocode = document.getElementById("pac-geocode");
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
        //map.setOptions({streetViewControl: false});       
        const autocomplete = new google.maps.places.Autocomplete(input);
        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo("bounds", map);
        // Set the data fields to return when the user selects a place.
        autocomplete.setFields([
            "address_components",
            "geometry",
            "icon",
            "name",
        ]);
        const infowindow = new google.maps.InfoWindow();
        const infowindowContent = document.getElementById("infowindow-content");
        infowindow.setContent(infowindowContent);
        marker = new google.maps.Marker({
            <?if($coord == "inicio"){?>
                position: new google.maps.LatLng(-16.558981881684787,-49.39453125),
            <?}else{ ?>
                position: new google.maps.LatLng(<?=$tcoord[0]?>, <?=$tcoord[1]?>),
            <?}?>
            title: "Local do Imovel",
    //         map: map,
            icon: localicon,
            map,
            anchorPoint: new google.maps.Point(0, -29),
        });

            //document.getElementById("place-icon").src = marker.icon;
            //document.getElementById("place-name").textContent = marker.name;
            //document.getElementById("place-address").textContent = marker.address;
            //**infowindowContent.children["place-icon"].src = place.icon;
            //**infowindowContent.children["place-name"].textContent = place.name;
            //**infowindowContent.children["place-address"].textContent = address;
            //**infowindow.open(map, marker);

        //
        document.getElementById("pac-geocode").value = marker.position;  //place.geometry.location;
        //
        autocomplete.addListener("place_changed", () => {
            infowindow.close();
            marker.setVisible(false);
            const place = autocomplete.getPlace();

            if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert(
                "Não existe informações para esse lugar : '" + place.name + "'"
            );
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
            document.getElementById("pac-geocode").value = place.geometry.location;
            //geocode.value = place.geometry.location.LatLng;
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
        //setupClickListener("changetype-all", []);
        setupClickListener("changetype-address", ["address"]);
        //setupClickListener("changetype-establishment", ["establishment"]);
        //setupClickListener("changetype-geocode", ["geocode"]);
        document
            .getElementById("use-strict-bounds")
            .addEventListener("click", function () {
            console.log("Checkbox clicked! New state=" + this.checked);
            autocomplete.setOptions({ strictBounds: this.checked });
            });
    }
</script>
</head>
<body>


<!--
    <div id="map"></div>
    <div id="infowindow-content">
      <img src="" width="16" height="16" id="place-icon" />
      <span id="place-name" class="title"></span><br />
      <span id="place-address"></span>
    </div>

</body>
</html>

<body onload="load()">

-->
<p class="style1" align="Center"><strong>Localizar Imóvel</strong>
<br /><strong>Pesquisa Autocomplete. Digite o Endereço e Clique no Escolhido</strong></p>

<table width="100%" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
<!-- Div para a listagem dos endere�os -->
<tr><td bgcolor="#F0F0F0">
<!--
<div id="pac-container">
-->

<!--
</div>
-->
</td></tr>

<tr><td bgcolor="#F0F0F0" height="30">
<table width="100%" cellpadding="0" cellspacing="5">
<tr><td valign="top" class="style1" width="100"><strong>Endereço:</strong> </td>    
    <td class="style1"><input id="pac-input" type="text" placeholder="Digite o endereço" /></td>
</table>
</td></tr>

<tr><td bgcolor="#F0F0F0" height="30">
<form action="" name=localizacao>
<table width="100%" cellpadding="0" cellspacing="5">
<Tr><td valign="top" class="style1" width="100"><strong>Coordenadas:</strong> </td>
    <td class="style1" ><input id="pac-geocode" type="text" name="coordenadas" size = "50" readonly="readonly"/>
    <input type="Button" name="B1" value="Gravar" class="campo3" onclick="window.opener.document.form1.ncoordenadas.value=document.localizacao.coordenadas.value;window.opener.focus(); window.close();"/>
  <br />(Utilize o botão gravar para retornar ao formulário)
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
        <div id="infowindow-content">
            <img src="" width="16" height="16" id="place-icon" />
            <span id="place-name" class="title"></span><br />
            <span id="place-address"></span>
        </div>
    </td>
  </tr>
</table></td>
</tr>
</table>
</td></tr>

</table>
</body>
</html>