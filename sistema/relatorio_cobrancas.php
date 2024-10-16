<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_LOCA");


//VERIFICA SE DATA FOI DIGITADA OU FOI MANTIDA CONFORME BUSCA
/*
if(empty( $_POST['data_inicial']) && empty($_POST['data_final'])){

	$_datai = ("01/" . date( "m/Y" ));
	$_dataf = date("d/m/Y");

	$_POST['data_inicial'] = $_datai;
	$_POST['data_final'] = $_dataf;

}
*/

?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function setStrMonth(month){
	switch(month){
		case '01' :
			return 'Jan';
		case '02' :
			return 'Feb';
		case '03' :
			return 'Mar';
		case '04' :
			return 'Apr';
		case '05' :
			return 'May';
		case '06' :
			return 'Jun';
		case '07' :
			return 'Jul';
		case '08' :
			return 'Aug';
		case '09' :
			return 'Sep';
		case '10' :
			return 'Oct';
		case '11' :
			return 'Nov';
		case '12' :
			return 'Dec';
		default:
			break;
	}
	
	return false;
}

function VerificaCampo(){

//declara as variaveis
	var datai,dataf,_datai,_dataf,msdatai,msdataf;

//pega valores do campo
	datai = document.getElementById('data_inicial').value;
	dataf = document.getElementById('data_final').value;

//retira a barra
	_datai = datai.split("/");
	_dataf = dataf.split("/");

//transforma a data e milisegundos
	msdatai = Date.parse(setStrMonth(_datai[1])+' '+_datai[0]+', '+_datai[2]);
	msdataf = Date.parse(setStrMonth(_dataf[1])+' '+_dataf[0]+', '+_dataf[2]);

//verifica se data inicial é maior que a final
	if(msdatai > msdataf){
		alert("Data inicial maior que a Data final!");
		return false;
	}
	
var msgErro = '';

	   if(document.form1.data_inicial.value.length==0)
       {
            msgErro += "Por favor, preencha o campo Data Inicial.\n"; 
       }
       if(document.form1.data_final.value.length==0)
       {
            msgErro += "Por favor, preencha o campo Data Final.\n"; 
       }
       if(msgErro != '')
	   {
	        alert(msgErro);
	        return false;
	   }
	   else
	   {
	        document.form1.buscar.value='1';
            document.form1.submit();
	   }

}

<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode; 
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}
//  End -->
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="">
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td class="style1"><div align="center"><b>Relat&oacute;rio de Cobran&ccedil;as </b><br>
      Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar</font></div></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Per&iacute;odo:</b><input type="hidden" name="buscar" id="buscar" value="0">
        <input type="text" name="data_inicial" id="data_inicial" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_inicial'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_inicial', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)">
        <b>&agrave;</b>
        <input type="text" name="data_final" id="data_final" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_final'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_final', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)">
        <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="VerificaCampo();"></td>
    </tr>  
    <tr>
      <td><table width="100%" border="0" cellpadding="1" cellspacing="1">
		<tr class="fundoTabelaTitulo">
         <td width="5%" class="style1"><b>Parcelas</b></td>
         <td width="35%" class="style1"><b>Im&oacute;vel</b></td>
		   <td width="20%" class="style1"><b>Valor do Contrato </b></td>
         <td width="20%" class="style1"><b>Valor dos Servi&ccedil;os </b></td>
         <td width="20%" class="style1"><b>Boleto</b></td>
      </tr>
        <?
        if($_POST['buscar']=='1'){ 
          
         $data1 = formataDataParaBd($_POST['data_inicial']);
         $data2 = formataDataParaBd($_POST['data_final']);
        
        $k= 0;
        
        $busca2 = mysql_query("SELECT m.cod, m.ref, m.tipo_logradouro, m.end, m.numero, l.l_total, co.co_valor, co.co_data, l.l_cod FROM muraski m INNER JOIN locacao l ON (l.l_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=l.l_cod) WHERE co.co_data >= '".$data1."' AND co.co_data <= '".$data2."' AND l.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND m.finalidade='9' AND l.l_n_contrato!='' GROUP BY co_data");         
		while($linha2 = mysql_fetch_array($busca2)){            
		
		    	$data_pesquisa = explode("-",$linha2['co_data']);
				$dia_data = $data_pesquisa[2];
				$mes_data = $data_pesquisa[1];
				$ano_data = $data_pesquisa[0];
         
		$busca3 = mysql_query("SELECT s.valor_servico, s.data_servico FROM locacao l LEFT JOIN servicos s ON (s.locacao=l.l_cod) WHERE s.cod_imovel='".$linha2['cod']."' AND s.situacao!='Atrasado'");			
         while($linha3 = mysql_fetch_array($busca3)){
			  				
				$data_servico = explode("-",$linha3['data_servico']);
				$dia_servico = $data_servico[2];
				$mes_servico = $data_servico[1];
				$ano_servico = $data_servico[0];
                
				
            if($mes_servico==$mes_data && $ano_servico==$ano_data){
				  $valor_servico += $linha3['valor_servico'];
				}else{
				  $valor_servico += '';
				}
				$valor_total = $linha2['l_total'] + $valor_servico;  	
            	
			}
			
			if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
			$k++;
								  
      				echo("
	        		<tr class=\"$fundo\">
                     	<td class=\"style1\">".$mes_data."/".$ano_data."</td>
            			<td class=\"style1\"><a href=\"javascript:;\" onClick=\"NewWindow('cadastro_servicos.php?cod=".$linha2['cod']."&l_cod=".$linha2['l_cod']."', 'janela', 750, 500, 'yes');\" class=\"style1\">".$linha2['ref']." - ".$linha2['tipo_logradouro']." ".$linha2['end'].", ".$linha2['numero']."</td>
						<td class=\"style1\">".number_format($linha2['l_total'], 2, ',', '.')."</td>
						<td class=\"style1\">".number_format($valor_servico, 2, ',', '.')."</td>
                     	<td class=\"style1\"><a href=\"javascript:;\" onClick=\"NewWindow('boleto.php?valor_total=".($linha2['l_total']+$valor_servico)."', 'janela', 750, 500, 'yes');\" class=\"style1\">Gerar Boleto</a></td>
            		</tr>
	   				");
			
	   		$valor_servico = '';	
			}
       }
       ?>
      </table></td>
    </tr>
	</table>
<?
mysql_close($con);

?>
</form>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("voltar.php"); ?>
    </td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td align="center" class="style1">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
</body>
</html>
