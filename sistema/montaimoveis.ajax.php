<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("no_cache.inc.php");
include("style.php");
include("conect.php");
include("l_funcoes.php");

$qtd = $_GET['qtd'];

for($cont = 0; $cont < $qtd; $cont++){
        $html .= '<table width="100%" border="0" cellspacing="1" cellpadding="1">';
  		$html .= '<tr>'; 
    	$html .= '<td class="style1"><b>Imóvel:</b>';
    	$html .= ' <input type="text" name="co_imovel_'.$cont.'" size="5" class="campo2" readonly>';
        $html .= ' <input type="text" name="nome_imovel_'.$cont.'" size="60" class="campo" readonly></td>';
        $html .= '<input type="button" id="selecionar" name="selecionar_'.$i.'" value="Selecionar" class="campo" onClick="window.open(\'list_imoveis_anuncio.php?idi='.$i.'\', \'janela\', \'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no\');">';
  		$html .= '</tr>';
		$html .= '</table>';       
}
        $html .= '<input name="cont" id="cont" type="hidden" class="campo" value="'.$cont.'">';
		echo $html;
        
?>