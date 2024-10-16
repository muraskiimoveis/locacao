<?php include("conect.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mapa</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAGF5PMGLCg44s7rGV02KSLhT7OuU2kuzJdn0XAl8Jzm25cIogHxQqOkiq7af9dRmp0ntksIuetvFzuA" type="text/javascript"></script>
    <?php

    require_once("class_browser.php");

    $endereco = explode("|", $_GET['end']);
    $browser = new Browser;

    $bairro15 = explode("--", $endereco[3]);
    $bairro25 = str_replace("-", "", $bairro15);

	$buscab = mysql_query("SELECT
                                c.tipo_comercio,
                                c.nome_comercio,
                                c.logradouro_comercio,
                                c.endereco_comercio,
                                c.numero_comercio,
                                ci.ci_nome,
                                e.e_uf,
                                t.tc_nome
                           FROM comercios c
                           INNER JOIN rebri_cidades ci ON (c.cidade_comercio=ci.ci_cod)
                           INNER JOIN rebri_estados e ON (c.estado_comercio=e.e_cod)
                           INNER JOIN rebri_tipo_comercio t ON (c.tipo_comercio=t.tc_cod)
                           WHERE c.bairro_comercio in (" . implode(',', $bairro25) . ")");

    $info = array();
    $cordenadas = array();
    while ($linha = mysql_fetch_array($buscab)) {
        $nome_comercio = $linha['nome_comercio'];
        $tipo_comercio = $linha['tc_nome'];
		$endereco_completo = $linha['logradouro_comercio'] . " "   .
                             $linha['endereco_comercio']   . ", "  .
                             $linha['numero_comercio']     . " - " .
                             $linha['ci_nome']             . ", "  .
                             $linha['e_uf'];
        array_push(&$info, array('nome_comercio'     => $nome_comercio,
                                 'tipo_comercio'     => $tipo_comercio,
                                 'endereco_completo' => $endereco_completo));

        $end = str_replace(" ", "+", $endereco_completo);
        $page =	$browser->get_url(
            array(
                "url" => "http://maps.google.com/maps/geo?q=$end&output=csv&key=ABQIAAAAGF5PMGLCg44s7rGV02KSLhT7OuU2kuzJdn0XAl8Jzm25cIogHxQqOkiq7af9dRmp0ntksIuetvFzuA"
			)
        );

        $retorno = $page["content"];
        $montagem = explode(",", $retorno);
        array_push(&$cordenadas, array('latitude'  => $montagem[2],
                                       'longitude' => $montagem[3]));
    }

    ?>
    <script type="text/javascript">

	var map = null;
    var geocoder = null;    
    var ma = new Array();
    var nome = new Array();

    function initialize() {
        if (GBrowserIsCompatible()) {
            map = new GMap2(document.getElementById("map_canvas"));
            map.setCenter(new GLatLng(-14.604847155053898, -53.26171875), 13);
            map.addControl(new GSmallMapControl());
            map.addControl(new GMapTypeControl());
            geocoder = new GClientGeocoder();
        }

        showAddress('<?php echo utf8_encode($endereco[0]); ?>');

        <?php

        $_jsInfo = array();
        foreach ($info as $inf) {
            array_push(&$_jsInfo, ("{nome:'" . $inf['nome_comercio'] .
                                   "',tipo:'" . $inf['tipo_comercio'] .
                                   "',endereco:'" . $inf['endereco_completo'] . "'}"));
        }

        $_jsCord = array();
        foreach ($cordenadas as $cordenada) {
            array_push(&$_jsCord, ('{lat:' . $cordenada['latitute'] . ', lon:' . $cordenada['longitude'] . '}'));
        }

        $_jsStr = "var info = [" . implode(',', $_jsInfo) . "];\n";
        $_jsStr.= "var cordenadas = [" . implode(',', $_jsCord) . "];\n";

        echo $_jsStr;

        ?>

        var mapObj = null;
        var nome = '';

        for (var i in cordenadas) {
            mapObj = new GMarker(new GLatLng(cordenadas[i].lat, cordenadas[i].lon));
            map.addOverlay(mapObj);
            nome = '<b>' + info[i].nome + '</b><br>Categoria: ' + info[i].tipo;
            GEvent.addListener(mapObj, "click", function () { mapObj.openInfoWindowHtml(nome); });
        }

    }
	
	var blueIcon = new GIcon(G_DEFAULT_ICON);
    
   	<?php if ($_GET['ori'] == 'rebri') { ?>
        blueIcon.image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/logo_rebri.png";
        blueIcon.shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/sombra_rebri.png";
        blueIcon.iconSize = new GSize(50, 45);
        blueIcon.shadowSize = new GSize(50, 45);
	<?php } else { ?>
        blueIcon.image = "http://201.15.46.77:8160/intranet/sistema/images/icone_muraski.png";
        blueIcon.shadow = "http://201.15.46.77:8160/intranet/sistema/images/sombra_muraski.png";
        blueIcon.iconSize = new GSize(42, 33);
        blueIcon.shadowSize = new GSize(42, 33);
	<?php } ?>

    markerOptions = {icon:blueIcon};
	
    function showAddress(address) {
        if (geocoder) {
            geocoder.getLatLng(
                address,
                function(point) {
                    if (!point) {
                        // noop...
                    } else {
                        map.setCenter(point, 17);
                        var marker = new GMarker(point, markerOptions);
                        map.addOverlay(marker);
                        marker.openInfoWindowHtml('<b><?php echo $endereco[2]; ?></b> ref.: <?php echo $endereco[1]; ?><br>' + address);
                        GEvent.addListener(marker, "click", function () { marker.openInfoWindowHtml('<b><?php echo $endereco[2]; ?></b> ref.: <?php echo $endereco[1]; ?><br>' + address); });
                    }
                }
            );
        }
    }

    </script>
    <style type="text/css">
        .gmnoprint {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

        div#map_canvas {
            width: 400px;
            height: 300px;
            margin: 0;
            padding: 0;
        }
    </style>
    </head>

    <body onload="initialize()" onunload="GUnload()">
        <div id="map_canvas"></div>
    </body>
</html>