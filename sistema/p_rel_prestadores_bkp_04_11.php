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
verificaArea("RELAT_PRESTADORES");
?>
<html>
<head>
<?

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
       if(document.form1.tipo_prestador.selectedIndex == 0)
	   {
	        msgErro += "Por favor, selecione o campo Tipo Prestador.\n";
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

function formConta(){

	if(confirm("Deseja realmente confirmar pagamento?")){

   	   document.form1.action='p_rel_prestadores.php';
	   document.form1.acao.value='1';
	   document.form1.buscar.value='1';
   	   document.form1.target= '';
   	   document.form1.submit();
	}
}

function formConta2(){

	if(confirm("Deseja realmente confirmar pagamento?")){

   	   document.form1.action='p_rel_prestadores.php';
	   document.form1.acao2.value='1';
	   document.form1.buscar.value='1';
   	   document.form1.target= '';
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
<link href="css/estilo_sistema.css" rel="stylesheet" type="text/css">
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/	

if($_POST['acao']=='1')
{

   		$i = $_POST['cont'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$datas = "data_status_".$j;
     		$data_atual = formataDataParaBd($_POST[$datas]);
     		$codigos = "co_cod_".$j;
     		$total = $_POST[$codigos];
     		$botoes = "ok_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_status='ok', co_data_status='$data_atual', co_usuario_status='$u_cod' where co_cod='$total' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");			
    		} 	
		} 

}

if($_POST['acao2']=='1')
{

   		$i2 = $_POST['cont2'];
  		$c2 = 0;

		for($j2 = 0; $j2 <= $i2; $j2++)
		{	     
		
     		$datas2 = "data_pagamento_".$j2;
     		$data_atual2 = formataDataParaBd($_POST[$datas2]);
     		$codigos2 = "id_servico_".$j2;
     		$total2 = $_POST[$codigos2];
     		$botoes2 = "ok_".$j2;
     		$botao2 = $_POST[$botoes2];

	    	if($botao2)
	    	{
    			$c2++;
    			$query42= "update solicitacao_servicos set status='ok', data_pagamento='$data_atual2' where id_servico='$total2' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result42 = mysql_query($query42) or die("Não foi possível atualizar suas informações. $query42");			
    		} 	
		} 

}
	
?>
<form method="post" action="" name="form1" id="form1">
<input type="hidden" name="acao" id="acao" value="0">
<input type="hidden" name="acao2" id="acao2" value="0">
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Relat&oacute;rio de Prestadores </b><br />
        Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar</div></td>
    </tr>
    <tr class="fundoTabela">
      
      <td wigth="20%"><span class="style1"><b>Per&iacute;odo:</b></span></td>
      <td wigth="80%">
          <input type="text" name="data_inicial" id="data_inicial" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_inicial'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_inicial', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)">
          <b>&agrave;</b>
          <input type="text" name="data_final" id="data_final" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_final'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_final', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)">
      </td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Tipo de Prestador:</b></td>
      <td width="80%" class="style1">
        <select name="tipo_prestador" id="tipo_prestador" class="campo" onChange="form1.submit();">
          <option value="">Selecione</option>
          <option value="Todos" <? if($tipo_prestador=='Todos'){ echo "SELECTED"; } ?>>Todos</option>
          <option value="eletricista" <? if($tipo_prestador=='eletricista'){ echo "SELECTED"; } ?>>Eletricista</option>
          <option value="encanador" <? if($tipo_prestador=='encanador'){ echo "SELECTED"; } ?>>Encanador</option>
          <option value="diarista" <? if($tipo_prestador=='diarista'){ echo "SELECTED"; } ?>>Diarista</option>
          <option value="jardineiro" <? if($tipo_prestador=='jardineiro'){ echo "SELECTED"; } ?>>Jardineiro</option>
          <option value="piscineiro" <? if($tipo_prestador=='piscineiro'){ echo "SELECTED"; } ?>>Piscineiro</option>
        </select> </td>
    </tr>
    <tr class="fundoTabela">
    	<td width="20%" class="style1"><b>Prestador:</b></td>
    	<td width="80%" class="style1">
        <select name="prestador" id="prestador" class="campo">
          <option value="">Selecione</option>
          <?
         if($tipo_prestador){
            $prestadores = mysql_query("SELECT c_cod, c_nome FROM clientes WHERE c_prestador='".$tipo_prestador."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY c_nome ASC");
 			while($linha = mysql_fetch_array($prestadores)){
				if($linha[c_cod]==$prestador){
					echo('<option value="'.$linha[c_cod].'" SELECTED>'.$linha[c_nome].'</option>');
				}else{ 			   
					echo('<option value="'.$linha[c_cod].'">'.$linha[c_nome].'</option>');
				}
 			}
 		}
       ?>
        </select>
      </td> 
    </tr>
    <tr class="fundoTabela">
        <td width="20%" class="style1"><b>Status:</b></td>    
    	<td width="80%" class="style1">
    		<select name="status" id="status" class="campo">
				<option value="">Selecione</option>
          		<option value="pendente" <? if($status=='pendente'){ echo "SELECTED"; } ?>>Pendente</option>
          		<option value="ok" <? if($status=='ok'){ echo "SELECTED"; } ?>>OK</option>
        	</select>	
    	</td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="hidden" name="buscar" id="buscar" value="0">
        <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="VerificaCampo();"><br /><br /> 
      </td>
    </tr>
    <? 
        //REALIZA BUSCA APÓS PRESSIONAR O BOTAO "PESQUISAR"
    	if($_POST['buscar']=='1'){ 
    	  
    	  $data1 = formataDataParaBd($_POST['data_inicial']);
    	  $data2 = formataDataParaBd($_POST['data_final']);
	?>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr height="50">
      <td colspan="2" class="style1"><p align="center"><b>Per&iacute;odo:</b> <?= $_POST['data_inicial']; ?> &agrave; <?= $_POST['data_final']; ?> <b></p></td>
    </tr>
    <tr>
      <td colspan="2" class="style1">
      <b>Tipo Prestador:</b> 
        <?
         if($_POST['tipo_prestador']=='diarista'){
           echo "Diarista";
         }elseif($_POST['tipo_prestador']=='eletricista'){
		   echo "Eletricista";
		 }elseif($_POST['tipo_prestador']=='encanador'){
		   echo "Encanador";
		 }elseif($_POST['tipo_prestador']=='jardineiro'){
		   echo "Jardineiro";
		 }elseif($_POST['tipo_prestador']=='piscineiro'){
		   echo "Piscineiro";  
		 }elseif($_POST['tipo_prestador']=='Todos'){
		   echo "Todos";
		 }
		?>
        <br>
      <b>Prestador:</b> 
      <?
        //REALIZA BUSCA DO TIPO PRESTADOR SELECIONADO OU TODOS
        if($_POST['tipo_prestador']<>"Todos"){
            //REALIZA BUSCA DO PRESTADOR SELECIONADO OU TODOS
	    	if($_POST['prestador']<>''){
				$bprestador = mysql_query("SELECT c_nome FROM clientes WHERE c_cod='".$_POST['prestador']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
				while($linha = mysql_fetch_array($bprestador)){
		   			echo $linha['c_nome'];
				}
			}else{
			  echo "Todos";
			}
		}else{
		  echo "Todos";
		}
	  ?>
	  <br>
      <b>Status:</b> 
      <?
        //REALIZA BUSCA DO TIPO PRESTADOR SELECIONADO OU TODOS
        if($_POST['status']<>''){
           echo $_POST['status'];
		}else{
		  echo "Todos";
		}
	  ?>
	  </td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?
		
		  //REALIZA BUSCA POR TODOS OS TIPOS DE PRESTADORES E TODOS OS PRESTADORES E TODOS OS STATUS
		  if($_POST['tipo_prestador']=='Todos' && $_POST['prestador']=='' && $_POST['status']==''){
					
			echo('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			');
					$k = 1;
					
					$buscap = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod)  WHERE co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i = 0;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							echo ("
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\">".$linha['c_prestador']."</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					");
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span> 
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		
						$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='OK' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\">".$linha2['c_prestador']."</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					");
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span> 
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                
						echo("
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
					
					
			//REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E TODOS OS PRESTADORES E TODOS OS STATUS
			}elseif($_POST['tipo_prestador']<>'Todos' && $_POST['prestador']=='' && $_POST['status']==''){
			  
			 echo('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$buscap = mysql_query("SELECT m.ref, m.titulo, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							echo ("
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\">".$linha['c_prestador']."</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					");
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span> 
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		
						$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE c.c_prestador='".$_POST['tipo_prestador']."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\">".$linha2['c_prestador']."</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					");
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span> 
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                
						echo("
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
			
			//REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E PRESTADOR SELECIONADO E TODOS OS STATUS
			}elseif($_POST['tipo_prestador']<>'Todos' && $_POST['prestador']<>'' && $_POST['status']==''){
			  
			  echo('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$buscap = mysql_query("SELECT m.ref, m.titulo, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							echo ("
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\">".$linha['c_prestador']."</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					");
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span>  
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		                
		                $buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
		                
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE c.c_prestador='".$_POST['tipo_prestador']."' AND s.cod_prestador='".$_POST['prestador']."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\">".$linha2['c_prestador']."</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					");
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span> 
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                
						echo("
				      		</table></td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
			  
		  //REALIZA BUSCA POR TODOS OS TIPOS DE PRESTADORES E TODOS OS PRESTADORES E O STATUS SELECIONADO
		  }elseif($_POST['tipo_prestador']=='Todos' && $_POST['prestador']=='' && $_POST['status']<>''){
					
			echo('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			');
				
					$buscap = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_data BETWEEN '$data1' AND '$data2' AND co.co_status='".$status."' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							
							echo ("
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\">".$linha['c_prestador']."</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					");
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span> 
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		
						$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='OK' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.data_servico BETWEEN '$data1' AND '$data2' AND s.status='".$status."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\">".$linha2['c_prestador']."</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					");
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span> 
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                				
		                
						echo("
				      		</table></td>
    						</tr>
    					");
    					if($status=='ok'){
    					echo("
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    					");
    					}else{
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    					  ");
    					}
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
					
			//REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E TODOS OS PRESTADORES E O STATUS SELECIONADO
			}elseif($_POST['tipo_prestador']<>'Todos' && $_POST['prestador']=='' && $_POST['status']<>''){
			  
			 echo('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>
			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$buscap = mysql_query("SELECT m.ref, m.titulo, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_status='".$status."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i = 0;
						$k = 1;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo="$cor14"; }else{ $fundo="$cor6"; }
							$k++;
							echo ("
								<tr bgcolor=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\">".$linha['c_prestador']."</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					");
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span>  
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		
						$buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE c.c_prestador='".$_POST['tipo_prestador']."' AND s.status='".$status."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\">".$linha2['c_prestador']."</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					");
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span> 
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;					
		                
						echo("
				      		</table></td>
    						</tr>
    					");
    					if($status=='ok'){
    					echo("
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    					");
    					}else{
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    					  ");
    					}
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
			
			//REALIZA BUSCA POR TIPO DE PRESTADOR SELECIONADO E PRESTADOR SELECIONADO E O STATUS SELECIONADO
			}elseif($_POST['tipo_prestador']<>'Todos' && $_POST['prestador']<>'' && $_POST['status']<>''){
			  
			  echo('
				<tr class="fundoTabelaTitulo">
       				<td width="20%" class="style1"><b>Im&oacute;vel</b></td>
       				<td width="10%" class="style1"><b>Tipo</b></td>
       				<td width="11%" class="style1"><b>Prestador</b></td>
	                <td width="13%" class="style1"><b>Data</b></td>
	                <td width="12%" class="style1"><b>Servi&ccedil;o</b></td>
	                <td width="8%" class="style1"><b>Valor</b></td>
	                <td width="26%" class="style1"><b>Status</b></td>
				</tr>

			  ');
				    //RELIZA A BUSCA DOS PRESTADORES CONFORME PERÍODO E PRESTADOR SELECIONADO E TAMBÉM REALIZA A SOMA TOTAL DO VALOR
					$buscap = mysql_query("SELECT m.ref, m.titulo, c.c_nome, DATE_FORMAT(co.co_data, '%d/%m/%Y') AS data_servico, co.co_valor, co.co_status, c.c_prestador, DATE_FORMAT(co.co_data_status, '%d/%m/%Y') AS data_status, co.co_cod, co.co_desc FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_cliente='".$_POST['prestador']."' AND co.co_status='".$status."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i = 0;
						$k = 0;
						while($linha = mysql_fetch_array($buscap)){
							if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
							$k++;
							echo ("
								<tr class=\"$fundo\">
          							<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          							<td class=\"style1\">".$linha['c_prestador']."</td>
          							<td class=\"style1\">".$linha['c_nome']."</td>
          							<td class=\"style1\">".$linha['data_servico']."</td>
          							<td class=\"style1\">".$linha['co_desc']."</td>
          							<td class=\"style1\">".number_format($linha['co_valor'],2,',','.')."</td>
          					");
							  if($linha['co_status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha['co_status']."</span> 
								   <input type=\"hidden\" name=\"co_cod_".$i."\" id=\"co_cod_".$i."\" value=\"".$linha['co_cod']."\">
								   <input type=\"text\" name=\"data_status_".$i."\" id=\"data_status_".$i."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_status_".$i."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i."\" id=\"ok_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formConta()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total = $total + $linha['co_valor'];
						$i++;
						}
		                
		                $buscapen = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='pendente' AND c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen = mysql_fetch_array($buscapen)){
						    $total_pendente = $total_pendente + $linhapen['co_valor'];
						}
						
						$buscaok = mysql_query("SELECT co.co_valor FROM contas co INNER JOIN muraski m ON (co.co_imovel=m.cod) INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_status='ok' AND c.c_prestador='".$_POST['tipo_prestador']."' AND co.co_cliente='".$_POST['prestador']."' AND co.co_data BETWEEN '$data1' AND '$data2' AND co.co_tipo like 'Despesas%' AND co.co_cat='Pagar' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok = mysql_fetch_array($buscaok)){
						    $total_ok = $total_ok + $linhaok['co_valor'];
						}
						
					//BUSCA DA SOLICITACAO DE SERVICOS
					$buscap2 = mysql_query("SELECT m.ref, m.titulo, c.c_nome, c.c_prestador, DATE_FORMAT(s.data_servico, '%d/%m/%Y') AS data_servico, s.valor_servico, s.status, DATE_FORMAT(s.data_pagamento, '%d/%m/%Y') AS data_status, s.id_servico, s.comentario FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE c.c_prestador='".$_POST['tipo_prestador']."' AND s.cod_prestador='".$_POST['prestador']."' AND s.status='".$status."' AND s.data_servico BETWEEN '$data1' AND '$data2' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						$i2 = 0;
						$k2 = 1;
						while($linha2 = mysql_fetch_array($buscap2)){
							if (($k2 % 2) == 1){ $fundo2="$cor6"; }else{ $fundo2="$cor14"; }
							$k2++;
							echo ("
								<tr bgcolor=\"$fundo2\">
          							<td class=\"style1\">".$linha2['ref']." - ".strip_tags($linha2['titulo'])."</td>
          							<td class=\"style1\">".$linha2['c_prestador']."</td>
          							<td class=\"style1\">".$linha2['c_nome']."</td>
          							<td class=\"style1\">".$linha2['data_servico']."</td>
          							<td class=\"style1\">".$linha2['comentario']."</td>
          							<td class=\"style1\">".number_format($linha2['valor_servico'],2,',','.')."</td>
          					");
							  if($linha2['status'] == "ok"){
							       echo "<td class=\"style6\">OK</td>";
          					  }else{
								   echo("<td class=\"style1\"><span class=\"style7\">".$linha2['status']."</span> 
								   <input type=\"hidden\" name=\"id_servico_".$i2."\" id=\"id_servico_".$i2."\" value=\"".$linha2['id_servico']."\">
								   <input type=\"text\" name=\"data_pagamento_".$i2."\" id=\"data_pagamento_".$i2."\" size=\"12\" maxlenght=\"10\" class=\"campo\" value=\"".$linha2['data_status']."\" onKeyPress=\"return txtBoxFormat(document.form1, 'data_pagamento_".$i2."', '##/##/####', event);\">
								   <input type=\"submit\" name=\"ok_".$i2."\" id=\"ok_".$i2."\" value=\"OK\" class=\"campo3\" onClick=\"formConta2()\"></td>");
							  }
							echo("
        						</tr>
							");
						$total2 = $total2 + $linha2['valor_servico'];
						$i2++;
						}
		
						$buscapen2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='pendente' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhapen2 = mysql_fetch_array($buscapen2)){
						    $total_pendente2 = $total_pendente2 + $linhapen2['valor_servico'];
						}
						
						$buscaok2 = mysql_query("SELECT s.valor_servico FROM solicitacao_servicos s INNER JOIN muraski m ON (s.cod_imovel=m.cod) INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.status='OK' AND s.data_servico BETWEEN '$data1' AND '$data2' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
						while($linhaok2 = mysql_fetch_array($buscaok2)){
						    $total_ok2 = $total_ok2 + $linhaok2['valor_servico'];
						}
						
						$totais_pendente = $total_pendente + $total_pendente2;
						$totais_ok = $total_ok + $total_ok2;
						$total_geral = $total + $total2;
		                		                
						echo("
				      		</table></td>
    						</tr>
    					");
    					if($status=='ok'){
    					echo("
    						<tr>
      							<td colspan=\"2\" class=\"style6\"><b>Total OK: </b>".number_format($totais_ok,2,',','.')."</td>
    						</tr>
    					");
    					}else{
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style7\"><b>Total Pendente: </b>".number_format($totais_pendente,2,',','.')."</td>
    						</tr>
    					  ");
    					}
    					  echo("
    						<tr>
      							<td colspan=\"2\" class=\"style1\"><b>Total: </b>".number_format($total_geral,2,',','.')."</td>
    						</tr>
						");
			  
			}	
		?>
		<input name="cont" id="cont" type="hidden" class="campo" value="<?=$i ?>">
		<input name="cont2" id="cont2" type="hidden" class="campo" value="<?=$i2 ?>">
  </table>
<?
}
mysql_close($con);
/*
	}else{
		include("login2.php");
	}
*/	
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