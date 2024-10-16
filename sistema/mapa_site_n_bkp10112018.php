<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<?
#$end = utf8_encode($_GET['end']);
#$end = utf8_decode($_GET['end']);

/**
Para continuar, testar o arquivo teste_mapa.xml, puxando os dados do xml conforme
exemplo que está no favoritos.
http://geochalkboard.wordpress.com/2009/03/30/reading-xml-files-with-the-google-maps-api/
Tentar utilizar o ícone que tras na variável IMG
/**/



$end = $_GET['end'];
$ori = $_GET['ori'];
$zoom = $_GET['zoom'];
$coordenadas = $_GET['coordenadas'];
$ref = $_GET['ref'];
$bairros = $_GET['bairros'];
$tipo_imovel = $_GET['tipo_imovel'];

if (strlen($end) > 50) {
   $t_end = explode(" ",$end);
   $i = 0;
   foreach ($t_end as $n_end) {
      if ($i%12==0 && $i > 0) {
		   $atual_end .= "<br />";
      }
      $atual_end .= $n_end." ";
      $i++;
   }
   $end = $atual_end;
}

$end_final = "<strong>$tipo_imovel</strong> - Ref: $ref <BR> $end";
$tcoord = explode(", ", $coordenadas);
$mostra_icone = $_GET['mostra_icone'];

if(substr(1,3) == '192'){$SRV_ORIGEM = $_SERVER['HTTP_HOST'];}else{$SRV_ORIGEM = $_SERVER['HTTP_HOST'];}

if ($coord <> "") {
   $tcoord = explode(", ",$coord);
}
?>


<script src="http://maps.google.com/maps?file=api&amp;v=2.s&amp;key=ABQIAAAAGF5PMGLCg44s7rGV02KSLhT7OuU2kuzJdn0XAl8Jzm25cIogHxQqOkiq7af9dRmp0ntksIuetvFzuA" type="text/javascript"></script>
<script>
// Todas as variáveis utilizadas no sistema

// Referência para a instância de GMap2
var mapaobj;

// Referência para a instância de GClientGeocoder
var geocoder;

// Array para mapear níveis de Zoom com a precisão do resultado
// Sinta-se livre para realizar o mapeamento achar mais conveniente.
// Note que quanto maior o número, maior o nível de zoom.
var nivelZoom = [];
    nivelZoom[0] = 2;
    nivelZoom[1] = 8;
    nivelZoom[2] = 9;
    nivelZoom[3] = 10;
    nivelZoom[4] = 12;
    nivelZoom[5] = 13;
    nivelZoom[6] = 14;
    nivelZoom[7] = 15;
    nivelZoom[8] = 16;

// Função chamada ao carregar a página HTML
function inicializa() {
    // Cria o objeto principal referenciando a div 'mapa'
     mapaobj = new GMap2(document.getElementById("mapa"),{draggableCursor: 'crosshair', draggingCursor: 'pointer'}) ;
	  mapaobj.addControl(new GSmallMapControl());
//     mapaobj.addControl(new GLargeMapControl());
     mapaobj.addControl(new GMapTypeControl());
     mapaobj.addControl(new GScaleControl()) ;
//     mapaobj.addControl(new GOverviewMapControl()) ;
     geocoder = new GClientGeocoder();
     icon = new GIcon(G_DEFAULT_ICON);

   	<? if($ori=='rebri'){ ?>
  	  		icon.image = "http://www.redebrasileiradeimoveis.com.br/sistema/images/logo_rebri.png";
			icon.shadow = "http://www.redebrasileiradeimoveis.com.br/sistema/images/sombra_rebri.png";
			icon.iconSize = new GSize(50, 45);
  			icon.shadowSize = new GSize(50, 45);
   	<? }else{ ?>
  	  		icon.image = "http://<? echo $SRV_ORIGEM; ?>/intranet/sistema/images/icone_muraski.png";
			icon.shadow = "http://<? echo $SRV_ORIGEM; ?>/intranet/sistema/images/sombra_muraski.png";
			icon.iconSize = new GSize(42, 33);
  			icon.shadowSize = new GSize(42, 33);
   	<? } ?>
  	  markerOptions = { icon:icon };

//    mapaobj = new GMap2(document.getElementById("mapa"));
    // Centraliza o mapa na coordenada (34, 0) com nível de zoom 3
     var center = new GLatLng(<?=$tcoord[0]?>, <?=$tcoord[1]?>);
     mapaobj.setCenter(center, 17);
     mapaobj.setCenter(center);
     marcador = new GMarker(center, markerOptions);
     mapaobj.addOverlay(marcador);
  //   marcador.openInfoWindowHtml("<?=$end_final?>");


    // Cria o objeto que resolverá as consultas de endereço
}

   function addpoint(point)
   {
    mapaobj.clearOverlays();
    document.localizacao.coordenadas.value = point;
    center = point;
    mapaobj.setCenter(center);
    marcador = new GMarker(center);
    mapaobj.addOverlay(marcador);
    marcador.openInfoWindowHtml("Para reposicionar o imóvel,<br /> clique no novo ponto");
   }

// Função para centralizar o mapa no ponto solicitado
// Parâmetros: x à latitude; y à longitude; info à Um texto que será
// exibido em um quadro informativo que aponta para o endereço;
// acc à a precisão do endereço para utilizar o zoom adequado
function centralizaMapa(x, y, info, acc) {

    // Cria um ponto GLatLng
    var p = new GLatLng(x,y);

    // Obtém o nível de zoom conforme a precisão do endereço
    var zoom = nivelZoom[acc];

    // Define o novo centro do mapa e o seu novo nível de zoom
    mapaobj.setCenter(p,zoom);

    // Cria um novo marcador que sera exibido no ponto p solicitado
    marcador = new GMarker(p);

    // Adiciona o marcador ao mapa
    mapaobj.addOverlay(marcador);

    // Exibe uma caixa de informação com o texto informado
    // Note que esse método aceita qualquer string com uma
    // formatação html arbitrária
//    marcador.openInfoWindowHtml("<b> " + info + "</b>");
    marcador.openInfoWindowHtml("Para reposicionar o imóvel,<br /> clique no novo ponto");

    document.localizacao.coordenadas.value = "(" + x + ", " + y + ")";

    document.pesquisa.consulta.value = info;

    document.getElementById('locais').innerHTML = "";

  }

</script>

</head>

<!-- Chama a função inicializa ao carregar a página html -->
<body onLoad="inicializa()">

<!-- Div onde o mapa será renderizado -->


<table border="0" cellspacing="1" cellpadding="0" bgcolor="#828282">
  <tr>
    <td><table border="0" cellspacing="5" cellpadding="0" bgcolor="#CCCCCC">
      <tr>
        <td>
<? if ($mapa == "sistema") { ?>
  <div id="mapa" style="width:762px; height:665px; margin:0; padding:0; vertical-align:top"></div>
<?} else {?>
  <div id="mapa" style="width:600px; height:500px; margin:0; padding:0; vertical-align:top"></div>
<?}?>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

  <!--Créditos :) -->
</body>
</html>