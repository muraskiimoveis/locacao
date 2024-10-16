<script type="text/javascript">
function letra() {

var valor_inicial = "16px";


document.getElementById("corpo").style.fontSize = valor_inicial;
}


function tamanhofonte(op) {

var incremento = 2;  

var local_alterado = document.getElementById("corpo").style.fontSize;

local_alterado = parseInt(local_alterado.replace(/px/,""));

if (op == "mais") {
local_alterado += incremento;
} else {
local_alterado -= incremento;
}

document.getElementById("corpo").style.fontSize = local_alterado + 'px';

}
</script>
<table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1">
  <tr align="center">
    <td><a  href="javascript: zoom(mais)" onFocus="javascript: zoom(mais)" accesskey="A" title="Aumenta 10%"><img src="images/icone_aumentar_letra.jpg" width="30" height="25" border="0" title="Aumentar letra" /></a>&nbsp;<a  href="javascript: index=9;zoom(mais)" onFocus="javascript: index=9;zoom(mais)" accesskey="N" title="Tamanho Normal">Letra normal</a>&nbsp;<a class="atalho" href="javascript: zoom(menos)" onFocus="javascript: zoom(menos)" accesskey="D" title="Diminui 10%"><img src="images/icone_diminuir_letra.jpg" width="30" height="25" border="0" title="Diminuir letra" /></a>&nbsp;</td>
<input type="hidden" value="100%" id="percent" size="5" name="schriftgroesse" alt="Porcentagem do aumento do texto">
  </tr>
</table>
