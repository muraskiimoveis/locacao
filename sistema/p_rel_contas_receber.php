<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
ob_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
if($_GET['pdf']<>'1'){
include("style.php");
}
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_DEPOSITOS");

if($_GET['pdf']=='1'){

$data_inicial = $_GET['data_inicial'];
$data_final = $_GET['data_final'];
$nome_cliente = $_GET['nome_cliente'];
$cliente = $_GET['cliente'];
$buscar = $_GET['buscar'];
$tipo = $_GET['tipo'];
$busuario = $_GET['busuario'];
$bstatus = $_GET['bstatus'];

$html4 .='<page><table border="0" cellspacing="1" width="800">
  			<tr>
    			<td colspan="6" style="text-align:left;">';

					$logo_imob = $_SESSION['logo_imob'];
    				$caminho_logo = "../logos/";
					if (file_exists($caminho_logo.$logo_imob))
					{
						$html4 .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
					}

	$html4 .='</td>
  			</tr>
            <tr>
			  <td colspan="6">&nbsp;</td>
			</tr>
    <tr>
      <td colspan="6" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;"><b>Relat&oacute;rio Contas a Receber</b></td>
    </tr>';
    
        //REALIZA BUSCA APÓS PRESSIONAR O BOTAO "PESQUISAR"
    	if($buscar=='1'){ 
    	  
    	  $data1 = formataDataParaBd($data_inicial);
    	  $data2 = formataDataParaBd($data_final);
    	  
    	if(!empty($nome_cliente)){
	    	$nome_cliente = $nome_cliente; 
		}else{
			$nome_cliente = "Todos";
		} 
		
		if($tipo<>'Todos'){
		     $query_tipo = " AND co.co_tipo='".$tipo."'";
		}
		
		if($busuario<>'Todos'){
		     $query_usuario = " AND co.co_usuario='".$busuario."'";
		}

        if($bstatus<>'Todos'){
		     $query_status = " AND co.co_status='".$bstatus."'";
		}
		
	  	if($busuario<>'Todos'){       
	       $users = mysql_query("SELECT u_nome, u_email FROM usuarios WHERE u_cod='".$busuario."'");
 		   while($linha = mysql_fetch_array($users)){
	          $dados = $linha['u_nome']." - ".$linha['u_email'];
	       }
	       $usuarios = $dados;
	  	}else{
	    	$usuarios = "Todos";
	  	}
	
$html4 .='<tr>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Per&iacute;odo: </b> '.$data_inicial.' &agrave; '.$data_final.' <b><br>
      </b><b>Propriet&aacute;rio ou Locat&aacute;rio: </b>'.$nome_cliente.'<br><b>Usuário: </b>'.$usuarios.'</td>
    </tr>';
         
  	      if(!empty($cliente)){
				$html4 .='<tr>
          		  <td width="200" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Imóvel</b></td>
          		  <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Data</b></td>
          		  <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Tipo</b></td>
                  <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
                  <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Status</b></td>
                  <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;">&nbsp;</td>
        		</tr>
				';
				
				$busca = mysql_query("SELECT DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_conta, m.ref, m.tipo_logradouro, m.end, m.numero, co.co_valor, co.co_status, co.co_tipo FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE m.ref!='x' AND co.co_cliente='".$cliente."' $query_tipo $query_usuario $query_status AND co.co_cat='Receber' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY co_data ASC");
				while($linha = mysql_fetch_array($busca)){
           				
					$html4 .='<tr>
          				<td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['ref'].' - '.$linha['tipo_logradouro'].' '.$linha['end'].', '.$linha['numero'].'</td>
                        <td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['data_conta'].'</td>
                        <td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['co_tipo'].'</td>
                        <td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha['co_valor'],2,',','.').'</td>
				   ';

				    if($linha['co_status']=='pendente'){
					  $statusc = "pendente";
					  $cor = "font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #ff0000;";
                      $total_pendente += $linha['co_valor'];
					}elseif($linha['co_status']=='ok'){
					  $statusc = "ok";
					  $cor = "font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000ff;";
                      $total_ok += $linha['co_valor'];
					}
          		   $html4 .='
          					<td width="50" style="'.$cor.'">'.$statusc.'</td>
                            <td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">&nbsp;</td>
        				</tr>
					';
               $total_geral = $total_pendente + $total_ok;
            }

			$html4 .='<tr>
      					<td colspan="6" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #ff0000;"><b>Total Pagar: </b>'.number_format($total_pendente,2,',','.').'</td>
    				</tr>
    				<tr>
      					<td colspan="6" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000ff;"><b>Total Pago: </b>'.number_format($total_ok,2,',','.').'</td>
    				</tr>
    				<tr>
      					<td colspan="6" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    				</tr>
			';
         }else{
            
            $html4 .='<tr>
          			<td width="200" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Imóvel</b></td>
                    <td width="200" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Proprietário/Locatário</b></td>
          			<td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Data</b></td>
          			<td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Tipo</b></td>
                    <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Valor</b></td>
                    <td width="50" style="background:#EEEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;padding: 4px;"><b>Status</b></td>
        		</tr>
				';
				
				$busca = mysql_query("SELECT DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_conta, m.ref, m.tipo_logradouro, m.end, m.numero, co.co_valor, co.co_status, co.co_tipo, c.c_nome FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE m.ref!='x' AND co.co_cat='Receber' AND co.co_data BETWEEN '$data1' AND '$data2' $query_tipo $query_usuario $query_status AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY co_data ASC");
				while($linha = mysql_fetch_array($busca)){
           				
					$html4 .='<tr>
          					<td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['ref'].' - '.$linha['tipo_logradouro'].' '.$linha['end'].', '.$linha['numero'].'</td>
                        	<td width="200" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['c_nome'].'</td>
                        	<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['data_conta'].'</td>
                        	<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.$linha['co_tipo'].'</td>
                        	<td width="50" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">'.number_format($linha['co_valor'],2,',','.').'</td>
				   ';

				    if($linha['co_status']=='pendente'){
					  $statusc = "pendente";
					  $cor = "font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #ff0000;";
                      $total_pendente += $linha['co_valor'];
					}elseif($linha['co_status']=='ok'){
					  $statusc = "ok";
					  $cor = "font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000ff;";
                      $total_ok += $linha['co_valor'];
					}
          		   $html4 .='
          					<td width="50" style="'.$cor.'">'.$statusc.'</td>
        				</tr>
					';
               $total_geral = $total_pendente + $total_ok;
            }

			$html4 .='<tr>
      					<td colspan="6" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #ff0000;"><b>Total Pagar: </b>'.number_format($total_pendente,2,',','.').'</td>
    				</tr>
    				<tr>
      					<td colspan="6" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #0000ff;"><b>Total Pago: </b>'.number_format($total_ok,2,',','.').'</td>
    				</tr>
    				<tr>
      					<td colspan="6" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;"><b>Total: </b>'.number_format($total_geral,2,',','.').'</td>
    				</tr>
			';
         }
$html4 .='<tr>
            <td colspan="6" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />www.redebrasileiradeimoveis.com.br</td>
          </tr>
</table></page>';
}

echo $html4;


    $content = ob_get_clean();
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	$pdf = new HTML2PDF('P','A4','fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();
	
}

?>
<? if($_GET['pdf']<>'1'){ ?>
<html>
<head>
<?

//VERICA SE DATA FOI DIGITADA OU FOI MANTIDA CONFORME BUSCA
/*
if(empty( $_POST['data_inicial']) && empty($_POST['data_final'])){

	$_datai = ("01/" . date( "m/Y" ));
	$_dataf = date("d/m/Y");

	$_POST['data_inicial'] = $_datai;
	$_POST['data_final'] = $_dataf;

}
*/

?>
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
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
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
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Relat&oacute;rio Contas a Receber </b><br>
 Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Período:</b></td>
      <td width="80%" class="style1">
      <input type="text" name="data_inicial" id="data_inicial" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_inicial'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_inicial', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)">
          <b>&agrave;</b>
          <input type="text" name="data_final" id="data_final" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_final'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_final', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Propriet&aacute;rio/Locat&aacute;rio:</b></td>
      <td width="80%" class="style1"><input type="text" name="cliente" size="5" class="campo2" value="<?php print($cliente); ?>" readonly>
        <input type="text" name="nome_cliente" size="60" class="campo" value='<?php print($nome_cliente); ?>' readonly>
        <input type="button" id="selecionar2" name="selecionar2" value="Selecionar" class="campo3" onClick="NewWindow('p_list_prop_loc.php', 'janela', 750, 500, 'yes');"></td>
    </tr>
	<tr class="fundoTabela">
      <td width="20%" class="style1"><b>Tipo:</b></td>
      <td width="80%" class="style1"><select name="tipo" id="tipo" class="campo">
        <option value="Todos">Todos</option>
         <?
            $b_tipo = mysql_query("SELECT co_tipo FROM contas WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY co_tipo ORDER BY co_tipo ASC");
 			while($linha = mysql_fetch_array($b_tipo)){
			  	echo('<option value="'.$linha['co_tipo'].'">'.$linha['co_tipo'].'</option>');
 			}
		 ?> 		
      </select></td>
    </tr>
	<tr class="fundoTabela">
      <td width="20%" class="style1"><b>Usuário:</b></td>
      <td width="80%" class="style1"><select name="busuario" class="campo">
	    <option value="Todos">Todos</option>
		 <?
            $b_usuario = mysql_query("SELECT u_cod, u_nome, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_status='Ativo' ORDER BY u_nome ASC");
 			while($linha = mysql_fetch_array($b_usuario)){
					echo('<option value="'.$linha['u_cod'].'">'.$linha['u_nome'].' - '.$linha['u_email'].'</option>');
 			}
		?>
        </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Status:</b></td>
      <td width="80%" class="style1"><select name="bstatus" class="campo">
	    <option value="Todos">Todos</option>
        <option value="pendente">Pendente</option>
        <option value="ok">OK</option>
        </select></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td width="100%" colspan="2">
       <input type="hidden" name="buscar" id="buscar" value="0">
        <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="VerificaCampo();"></td>
    </tr>
  </table>
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <? 
        //REALIZA BUSCA APÓS PRESSIONAR O BOTAO "PESQUISAR"
    	if($_POST['buscar']=='1'){ 
    	  
    	  $data1 = formataDataParaBd($_POST['data_inicial']);
    	  $data2 = formataDataParaBd($_POST['data_final']);
    	  
    	  if($_POST['tipo']<>'Todos'){
		     $query_tipo = " AND co.co_tipo='".$_POST['tipo']."'";
		  }
		  
		  if($_POST['busuario']<>'Todos'){
		     $query_usuario = " AND co.co_usuario='".$_POST['busuario']."'";
		  }

          if($_POST['bstatus']<>'Todos'){
		     $query_status = " AND co.co_status='".$_POST['bstatus']."'";
		  }
	?>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr height="50">
      <td colspan="2" class="style1"><p align="center"><b>Per&iacute;odo:</b> <?= $_POST['data_inicial']; ?> &agrave; <?= $_POST['data_final']; ?></p></td>
    </tr>
    <tr>
    <td colspan="2" class="style1"><b>Propriet&aacute;rio ou Locat&aacute;rio:</b> <? if(!empty($_POST['nome_cliente'])){ echo $_POST['nome_cliente']; }else{  echo "Todos"; } ?><br>
<?
	  if($_POST['busuario']<>'Todos'){       
	       $users = mysql_query("SELECT u_nome, u_email FROM usuarios WHERE u_cod='".$_POST['busuario']."'");
 		   while($linha = mysql_fetch_array($users)){
	          $dados = $linha['u_nome']." - ".$linha['u_email'];
	       }
	       $usuarios = $dados;
	  }else{
	    	$usuarios = "Todos";
	  }
?> 
	  <b> Usuário:</b> <? echo $usuarios; ?></td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
         <?
  	      if(!empty($_POST['cliente'])){
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="40%" class="style1"><b>Imóvel</b></td>
          			<td width="15%" class="style1"><b>Data</b></td>
          			<td width="15%" class="style1"><b>Tipo</b></td>
                  <td width="15%" class="style1"><b>Valor</b></td>
                  <td width="15%" class="style1"><b>Status</b></td>
        		</tr>
				');
				$k = 0;
				$busca = mysql_query("SELECT DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_conta, m.ref, m.tipo_logradouro, m.end, m.numero, co.co_valor, co.co_status, co.co_tipo FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE m.ref!='x' AND co.co_cliente='".$cliente."' $query_tipo $query_usuario $query_status AND co.co_cat='Receber' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY co_data ASC");
				while($linha = mysql_fetch_array($busca)){
           			if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					$k++;
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$linha['ref']." - ".$linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero']."</td>
                        <td class=\"style1\">".$linha['data_conta']."</td>
                        <td class=\"style1\">".$linha['co_tipo']."</td>
                        <td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
				   ");

				    if($linha['co_status']=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
                 $total_pendente += $linha['co_valor'];
					}elseif($linha['co_status']=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
                 $total_ok += $linha['co_valor'];
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
					");
               $total_geral = $total_pendente + $total_ok;
            }

			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Total Pagar: </b>".number_format($total_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Total Pago: </b>".number_format($total_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    				</tr>
			");
         }else{
            
            echo('
				<tr class="fundoTabelaTitulo">
          			<td width="40%" class="style1"><b>Imóvel</b></td>
                  <td width="20%" class="style1"><b>Proprietário/Locatário</b></td>
          			<td width="10%" class="style1"><b>Data</b></td>
          			<td width="10%" class="style1"><b>Tipo</b></td>
                  <td width="10%" class="style1"><b>Valor</b></td>
                  <td width="10%" class="style1"><b>Status</b></td>
        		</tr>
				');
				$k = 0;
				$busca = mysql_query("SELECT DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_conta, m.ref, m.tipo_logradouro, m.end, m.numero, co.co_valor, co.co_status, co.co_tipo, c.c_nome FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE m.ref!='x' AND co.co_cat='Receber' AND co.co_data BETWEEN '$data1' AND '$data2' $query_tipo $query_usuario $query_status AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY co_data ASC");
				while($linha = mysql_fetch_array($busca)){
           			if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					$k++;
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$linha['ref']." - ".$linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero']."</td>
                        <td class=\"style1\">".$linha['c_nome']."</td>
                        <td class=\"style1\">".$linha['data_conta']."</td>
                        <td class=\"style1\">".$linha['co_tipo']."</td>
                        <td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
				   ");

				    if($linha['co_status']=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
                 $total_pendente += $linha['co_valor'];
					}elseif($linha['co_status']=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
                 $total_ok += $linha['co_valor'];
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
					");
               $total_geral = $total_pendente + $total_ok;
            }

			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Total Pagar: </b>".number_format($total_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Total Pago: </b>".number_format($total_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    				</tr>
			");
         
         }
			
        ?>
</form>        
        <tr>
           <td aling="center" colspan="6"><form name="form3" id="form3" method="post" action="">
             <div align="center">
               <input type="submit" value="Exportar para PDF" name="exportar" id="exportar" class="campo3" onClick="form3.action='p_rel_contas_receber.php?pdf=1&data_inicial=<?=$data_inicial ?>&data_final=<?=$data_final ?>&cliente=<?=$cliente ?>&nome_cliente=<?=$nome_cliente ?>&buscar=<?=$buscar ?>&tipo=<?=$tipo ?>&busuario=<?=$busuario ?>&bstatus=<?=$bstatus ?>';">
             </div>
           </form></td>
        <tr>
  </table>

<?
}
mysql_close($con);
?>
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
<? } ?>