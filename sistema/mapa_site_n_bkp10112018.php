<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<?
#$end = utf8_encode($_GET['end']);
#$end = utf8_decode($_GET['end']);

/**
Para continuar, testar o arquivo teste_mapa.xml, puxando os dados do xml conforme
exemplo que est� no favoritos.
http://geochalkboard.wordpress.com/2009/03/30/reading-xml-files-with-the-google-maps-api/
Tentar utilizar o �cone que tras na vari�vel IMG
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
// Todas as vari�veis utilizadas no sistema

// Refer�ncia para a inst�ncia de GMap2
var mapaobj;

// Refer�ncia para a inst�ncia de GClientGeocoder
var geocoder;

// Array para mapear n�veis de Zoom com a precis�o do resultado
// Sinta-se livre para realizar o mapeamento achar mais conveniente.
// Note que quanto maior o n�mero, maior o n�vel de zoom.
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

// Fun��o chamada ao carregar a p�gina HTML
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
    // Centraliza o mapa na coordenada (34, 0) com n�vel de zoom 3
     var center = new GLatLng(<?=$tcoord[0]?>, <?=$tcoord[1]?>);
     mapaobj.setCenter(center, 17);
     mapaobj.setCenter(center);
     marcador = new GMarker(center, markerOptions);
     mapaobj.addOverlay(marcador);
  //   marcador.openInfoWindowHtml("<?=$end_final?>");


    // Cria o objeto que resolver� as consultas de endere�o
}

   function addpoint(point)
   {
    mapaobj.clearOverlays();
    document.localizacao.coordenadas.value = point;
    center = point;
    mapaobj.setCenter(center);
    marcador = new GMarker(center);
    mapaobj.addOverlay(marcador);
    marcador.openInfoWindowHtml("Para reposicionar o im�vel,<br /> clique no novo ponto");
   }

// Fun��o para centralizar o mapa no ponto solicitado
// Par�metros: x � latitude; y � longitude; info � Um texto que ser�
// exibido em um quadro informativo que aponta para o endere�o;
// acc � a precis�o do endere�o para utilizar o zoom adequado
function centralizaMapa(x, y, info, acc) {

    // Cria um ponto GLatLng
    var p = new GLatLng(x,y);

    // Obt�m o n�vel de zoom conforme a precis�o do endere�o
    var zoom = nivelZoom[acc];

    // Define o novo centro do mapa e o seu novo n�vel de zoom
    mapaobj.setCenter(p,zoom);

    // Cria um novo marcador que sera exibido no ponto p solicitado
    marcador = new GMarker(p);

    // Adiciona o marcador ao mapa
    mapaobj.addOverlay(marcador);

    // Exibe uma caixa de informa��o com o texto informado
    // Note que esse m�todo aceita qualquer string com uma
    // formata��o html arbitr�ria
//    marcador.openInfoWindowHtml("<b> " + info + "</b>");
    marcador.openInfoWindowHtml("Para reposicionar o im�vel,<br /> clique no novo ponto");

    document.localizacao.coordenadas.value = "(" + x + ", " + y + ")";

    document.pesquisa.consulta.value = info;

    document.getElementById('locais').innerHTML = "";

  }

</script>

</head>

<!-- Chama a fun��o inicializa ao carregar a p�gina html -->
<body onLoad="inicializa()">

<!-- Div onde o mapa ser� renderizado -->


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

  <!--Cr�ditos :) -->
</body>
</html>