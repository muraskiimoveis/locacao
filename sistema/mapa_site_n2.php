<?
$tcoord = explode(", ",$coordenadas);
//Pesquisa por distancia (verificar porque tá dando 800 milhas do ponto inicial.
#(37 por -25.430101)
#(-122 por -49.2663838)
#SELECT mp_cod, ( 3959 * acos( cos( radians(-25.430101) ) * cos( radians( mp_latitude ) ) * cos( radians( mp_longitude ) - radians(-49.2663838) ) + sin( radians(-25.430101) ) * sin( radians( mp_latitude ) ) ) ) AS distance FROM mapa HAVING distance < 25 ORDER BY distance LIMIT 0 , 20; SELECT mp_cod, ( 3959 * acos( cos( radians(-25.430101) ) * cos( radians( mp_latitude ) ) * cos( radians( mp_longitude ) - radians(-49.2663838) ) + sin( radians(-25.430101) ) * sin( radians( mp_latitude ) ) ) ) AS distance FROM mapa HAVING distance < 1 ORDER BY mp_cod;
#(-25.379547787853294, -49.285094261867926)

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Geração de Mapas</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAGF5PMGLCg44s7rGV02KSLhT7OuU2kuzJdn0XAl8Jzm25cIogHxQqOkiq7af9dRmp0ntksIuetvFzuA" type="text/javascript"></script>
    <script src="google/labeledmarker.js"></script>
    <script type="text/javascript">
    //<![CDATA[

<?
$personalizado = "";
if ($ori == "muraski") {
    $personalizado .= "customIcons[\"ImMuraski\"] = iconeImMuraski;\n";
    $marcadores .= "\"ImMuraski\" : []";
?>
    var iconeImMuraski = new GIcon();
    iconeImMuraski.image = "http://187.52.200.66:8160/intranet/sistema/images/icone_muraski.png";
    iconeImMuraski.shadow = "http://187.52.200.66:8160/intranet/sistema/images/sombra_muraski.png";
    iconeImMuraski.iconSize = new GSize(42, 33);
    iconeImMuraski.shadowSize = new GSize(42, 33);
    iconeImMuraski.iconAnchor = new GPoint(16, 16);
    iconeImMuraski.infoWindowAnchor = new GPoint(5, 1);
<?
} else {
    $personalizado .= "customIcons[\"ImRebri\"] = iconeImRebri;\n";
    $marcadores .= "\"ImRebri\" : []";
?>
    var iconeImRebri = new GIcon();
    iconeImRebri.image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/logo_rebri.png";
    iconeImRebri.shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/sombra_rebri.png";
    iconeImRebri.iconSize = new GSize(50, 45);
    iconeImRebri.shadowSize = new GSize(50, 45);
    iconeImRebri.iconAnchor = new GPoint(16, 16);
    iconeImRebri.infoWindowAnchor = new GPoint(30, 1);
<?
}
?>

<?
include "conect.php";

$sql = "SELECT mp_tipo, mt_tipo, mt_imagem, mt_tam_imagem, mt_tam_sombra, mt_tam_ancora, mt_tam_ancora2, ( 3959 * acos( cos( radians($tcoord[0]) ) * cos( radians( mp_latitude ) ) * cos( radians( mp_longitude ) - radians($tcoord[1]) )
   + sin( radians($tcoord[0]) ) * sin( radians( mp_latitude ) ) ) ) AS distance FROM mapa LEFT JOIN mapa_tipo ON mp_tipo = mt_cod HAVING distance < 1 ORDER BY mt_tipo";
$rs = mysql_query($sql) or die ("Erro 11 - " . mysql_error());
$mostra = "";

while ($not = mysql_fetch_assoc($rs)) {

   if ($not[mp_tipo] <> $mostra) {
      $mostra = $not[mp_tipo];
      $personalizado .= "customIcons[\"".$not[mp_tipo]."\"] = icone" . $not[mp_tipo] . ";\n
      ";
      $marcadores .= "\n, \"".$not[mp_tipo]."\" : []";
      $checks .= "document.getElementById(\"".$not[mp_tipo]."\").checked = true;
      ";
      $itens .= "<input type=\"checkbox\" id=\"".$not[mp_tipo]."\" onclick=\"mostraGrupo('".$not[mp_tipo]."')\" CHECKED />".$not[mt_tipo]."<br/>
      ";

      print "     var icone" . $not[mp_tipo] . " = new GIcon();
       icone" . $not[mp_tipo] . ".image = '".$not[mt_imagem]."';
       icone" . $not[mp_tipo] . ".shadow = '';
       icone" . $not[mp_tipo] . ".iconSize = new GSize(25, 32);
       icone" . $not[mp_tipo] . ".shadowSize = new GSize(25, 32);
       icone" . $not[mp_tipo] . ".iconAnchor = new GPoint(16, 16);
       icone" . $not[mp_tipo] . ".infoWindowAnchor = new GPoint(5, 1);

       ";
   }
}
?>

    var customIcons = [];
    <?=$personalizado?>

    var markerGroups = { <?=$marcadores?> };

    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.setCenter(new GLatLng(<?=$tcoord[0]?>, <?=$tcoord[1]?>), 16);
        <?=$checks?>

        GDownloadUrl("google.xml", function(data) {
          var xml = GXml.parse(data);
          var markers = xml.documentElement.getElementsByTagName("marker");
          for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("name");
            var address = markers[i].getAttribute("address");
            var type = markers[i].getAttribute("type");
            var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
                                    parseFloat(markers[i].getAttribute("lng")));
            var marker = createMarker(point, name, 0, address, type);
            map.addOverlay(marker);
          }
        });
      }
    }

    function createMarker(point, name, label, address, type) {
      var marker = new LabeledMarker(point, {icon: customIcons[type], labelText: label, labelOffset: new GSize(-6, -10)});
      markerGroups[type].push(marker);
      var html = "<b>" + name + "</b> <br/>" + address;
      GEvent.addListener(marker, 'click', function() {
        marker.openInfoWindowHtml(html);
      });
      return marker;
    }
    function mostraGrupo(type) {
      for (var i = 0; i < markerGroups[type].length; i++) {
        var marker = markerGroups[type][i];
        if (marker.isHidden()) {
          marker.show();
        } else {
          marker.hide();
        }
      }
    }

    //]]>
  </script>
</head>

  <body style="font-family:Arial, sans serif" onload="load()" onunload="GUnload()">
   <div id="map" style="float:left; width: 700px; height: 600px; border: 1px solid black"></div>
   <div id="sidebar" style="float:left; width: 160px; height: 600px; border: 1px solid black">
      <?=$itens?>
   </div>
  </body>
</html>
