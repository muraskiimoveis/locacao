<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_VEND");
include("style.php");

  $datafo = date("dmY");
  $horafo = date("His");

?>
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

	   /*
	   if (document.form1.comissoes.selectedIndex == 0)
	   {
	        msgErro += "Por favor, selecione o campo Comissões de.\n";
	   }
	   */
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

/*
function formContaA(){

	if(confirm("Deseja realmente confirmar pagamento Angariador?")){

   	   document.form1.action='p_rel_vendas.php';
	   document.form1.acaoA.value='1';
	   document.form1.acaoB.value='1';
	   document.form1.buscar.value='1';
   	   document.form1.target= '';
   	   document.form1.submit();
	}
}

function formContaV(){

	if(confirm("Deseja realmente confirmar pagamento Vendedor?")){

   	   document.form1.action='p_rel_vendas.php';
	   document.form1.acaoV.value='1';
	   document.form1.acaoB.value='1';
	   document.form1.buscar.value='1';
   	   document.form1.target= '';
   	   document.form1.submit();
	}
}

function formContaI(){

	if(confirm("Deseja realmente confirmar pagamento Indicador?")){

   	   document.form1.action='p_rel_vendas.php';
	   document.form1.acaoI.value='1';
	   document.form1.acaoB.value='1';
	   document.form1.buscar.value='1';
   	   document.form1.target= '';
   	   document.form1.submit();
	}
}
*/

function formContaB(){

	if(confirm("Deseja realmente liberar pagamento para o Angariador ou Indicador ou Vendedor desse imóvel?")){

   	   document.form1.action='p_rel_vendas.php';
	   document.form1.acaoB.value='1';
	   document.form1.buscar.value='1';
   	   document.form1.target= '';
   	   document.form1.submit();
	}
}

function confirma(caminho) {
	var answer = confirm("Deseja realmente confirmar pagamento?")
	if (answer){
		document.form1.co_cod.value = caminho;
    	document.form1.action='p_rel_vendas.php'; 
	    document.form1.buscar.value='1';
 	    document.form1.acaoB.value='1';
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
<?php

if($_POST['co_cod']<>''){
  
  $query4= "update contas set co_status='ok' where co_cod='".$_POST['co_cod']."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
  $result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");		
  
}

/*
if($_POST['acaoA']=='1')
{

   		$i = $_POST['cont'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$codigos = "co_angariador_".$j;
     		$total = $_POST[$codigos];
     		$botoes = "oka_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_status='ok' where co_cod='$total' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");		
    		} 	
		} 

}

if($_POST['acaoV']=='1')
{

   		$i = $_POST['cont'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$codigos = "co_vendedor_".$j;
     		$total = $_POST[$codigos];
     		$botoes = "okv_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_status='ok' where co_cod='$total' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");			
    		} 	
		} 

}

if($_POST['acaoI']=='1')
{

   		$i = $_POST['cont'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$codigos = "co_indicador_".$j;
     		$total = $_POST[$codigos];
     		$botoes = "oki_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_status='ok' where co_cod='$total' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");			
    		} 	
		} 

}
*/

if($_POST['acaoB']=='1')
{

   		$i = $_POST['cont'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$codigos = "co_locacao_".$j;
     		$total = $_POST[$codigos];
			$botoes = "okb_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query4= "update contas set co_verificacao='1' where co_locacao='$total' and (co_tipo_user='A' OR co_tipo_user='V' OR co_tipo_user='I') and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
				$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	
    		} 	
		} 

}
	
?>
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="acaoA" id="acaoA" value="0">
<input type="hidden" name="acaoV" id="acaoV" value="0">
<input type="hidden" name="co_cod" id="co_cod" value="">
<input type="hidden" name="acaoI" id="acaoI" value="0">
<input type="hidden" name="acaoB" id="acaoB" value="0">
<table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Relat&oacute;rio de Vendas</b><br>
 Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Período:</b></td>
      <td width="70%" class="style1">
      <input type="text" name="data_inicial" id="data_inicial" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_inicial'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_inicial', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)">
          <b>&agrave;</b>
          <input type="text" name="data_final" id="data_final" size="10" class="campo" maxlenght="10" value="<?= $_POST['data_final'] ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_final', '##/##/####', event);" onKeyUp="return autoTab(this, 10, event);" onChange="ValidaData(this.value)"></td>
    </tr>
	<?
	if (verificaFuncao("USER_RELAT_VEND")) { // verifica se pode acessar as areas   
	?>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Usu&aacute;rio:</b></td>
      <td width="70%" class="style1"><select name="usuario" id="usuario" class="campo">
            <option value="Todos">Todos</option>
            <?
            $users = mysql_query("SELECT u_cod, u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_status='Ativo' ORDER BY u_nome ASC");
 			while($linha = mysql_fetch_array($users)){
 			  if($linha['u_cod']==$usuario){
			    echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_nome].'</option>'); 
			  }else{
			    echo('<option value="'.$linha[u_cod].'">'.$linha[u_nome].'</option>'); 
			  }	
 			}
          ?>
          </select>
      </td>
    </tr>
    <? } ?>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><!--b>Comiss&otilde;es de:</b>
          <select name="comissoes" id="comissoes" class="campo" onChange="form1.submit();">
            <option value="">Selecione</option>
			<option value="Todos" <? if($_POST['comissoes']=='Todos') echo "SELECTED"; ?>>Todos</option>
            <option value="A" <? if($_POST['comissoes']=='A') echo "SELECTED"; ?>>Angariador</option>
            <option value="I" <? if($_POST['comissoes']=='I') echo "SELECTED"; ?>>Indicador</option>
            <option value="V" <? if($_POST['comissoes']=='V') echo "SELECTED"; ?>>Vendedor</option>
          </select>&nbsp;--><b>Corretor:</b></td>
      <td width="70%" class="style1"><select name="corretor" id="corretor" class="campo">
          <option value="Todos" <? if($_POST['corretor']=='Todos') echo "SELECTED"; ?>>Todos</option>
          <?
         //if($_POST['comissoes']=='I'){
            $corretores = mysql_query("SELECT c_cod, c_nome FROM clientes WHERE c_tipo='indicador' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY c_nome ASC");
 			while($linha = mysql_fetch_array($corretores)){
				if($linha[c_cod]==$corretor){
					echo('<option value="'.$linha[c_cod].'" SELECTED>'.$linha[c_nome].'</option>');
				}else{ 			   
					echo('<option value="'.$linha[c_cod].'">'.$linha[c_nome].'</option>');
				}
			$diferenca = "0";
 			}
 		//}elseif($_POST['comissoes']=='A' || $_POST['comissoes']=='V'){
			$corretores2 = mysql_query("SELECT u_cod, u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_nome ASC");
 			while($linha2 = mysql_fetch_array($corretores2)){
				if($linha2[u_cod]==$corretor){
					echo('<option value="'.$linha2[u_cod].'" SELECTED>'.$linha2[u_nome].'</option>');
				}else{ 			   
					echo('<option value="'.$linha2[u_cod].'">'.$linha2[u_nome].'</option>');
				}
			$diferenca = "1";
 			}
		   
		//}
       ?>
        </select></td>
    </tr>
	<tr class="fundoTabela">
      <td width="30%" class="style1"><b>Tipo de Im&oacute;vel:</b></td>
      <td width="70%" class="style1"><select name="tipo_imovel" id="tipo_imovel" class="campo">
            <option value="Todos" <? if($_POST['tipo_imovel']=='Todos') echo "SELECTED"; ?>>Todos</option>
            <?
    		$btipo = mysql_query("SELECT t_cod, t_nome FROM rebri_tipo ORDER BY t_nome ASC");
 			while($linha = mysql_fetch_array($btipo)){
				if($linha[t_cod]==$_POST['tipo_imovel']){
 		     		echo('<option value="'.$linha[t_cod].'" SELECTED>'.$linha['t_nome'].'</option>'); 
		   		}else{
		     		echo('<option value="'.$linha[t_cod].'">'.$linha['t_nome'].'</option>'); 
		   		}
			}
		?>
       </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Status:</b></td>
      <td width="70%" class="style1"><select name="bstatus" class="campo">
	    <option value="Todos">Todos</option>
        <option value="pendente">Pendente</option>
        <option value="ok">OK</option>
        </select></td>
    </tr>
    <tr>
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
    	  
    	  if($_POST['bstatus']<>'Todos'){
		     $query_status = " AND co.co_status='".$_POST['bstatus']."'";
		  }
	?>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><b>Per&iacute;odo:</b> <?= $_POST['data_inicial']; ?> &agrave; <?= $_POST['data_final']; ?> <!--b><br>
        Comiss&otilde;es de:</b> 
        <?
        /*
         if($_POST['comissoes']=='A'){
           echo "Angariador";
         }elseif($_POST['comissoes']=='I'){
		   echo "Indicador";
		 }elseif($_POST['comissoes']=='V'){
		   echo "Vendedor";
		 }else{
		   echo "Todos";
		 }
		 */
		?>
	  <br-->
      <br><b>Corretor:</b> 
      <?
           
	  if($_POST['corretor']<>'Todos'){
	    if($diferenca=='1'){
	  		$nomes2 = mysql_query("SELECT u_nome FROM usuarios WHERE u_cod='".$_POST['corretor']."'");
			while($linha2 = mysql_fetch_array($nomes2)){
       			echo $linha2['u_nome'];
	  		}
	  	}elseif($diferenca=='0'){
		 	$nomes = mysql_query("SELECT c_nome FROM clientes WHERE c_cod='".$_POST['corretor']."'");
			while($linha = mysql_fetch_array($nomes)){
       			echo $linha['c_nome'];
	  		}   
		}
	  }else{
	    echo "Todos";
	  }
	  ?>
        <br>
      <b>Tipo de Im&oacute;vel:</b> 
      <?
	  if($_POST['tipo_imovel']<>'Todos'){
	  	$usuarios = mysql_query("SELECT t_nome FROM rebri_tipo WHERE t_cod='".$_POST['tipo_imovel']."'");
		while($linha = mysql_fetch_array($usuarios)){
       		echo $linha['t_nome'];
	  	}
	  }else{
	    echo "Todos";
	  }
	  ?>
      <br>
      <b>Usu&aacute;rio:</b> 
      <?
      //REALIZA BUSCA DO USUÁRIO LOGADO OU SELECIONADO
	  if($_POST['usuario']){
        if($_POST['usuario']<>'Todos'){
	    	$usuarios = mysql_query("SELECT u_nome FROM usuarios WHERE u_cod='".$_POST['usuario']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
			while($linha = mysql_fetch_array($usuarios)){
           		echo $linha['u_nome'];
		 	}
	  	}else{
		    echo "Todos";
		}
	  }else{
	    echo $u_nome;
	  }
	  ?>      </td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?
           	//REALIZA BUSCA POR TODOS OS TIPOS DE COMISSOES E TODOS OS TIPOS DE IMOVEIS E USUÁRIO LOGADO
        	if($_POST['corretor']=='Todos' && $_POST['tipo_imovel']=='Todos' && empty($_POST['usuario'])){
        	          	  				
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
				
				$k= 0;
				
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
				while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;
           		  		
          		    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO ANGARIADOR
						$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha3 = mysql_fetch_array($busca3)){
           				  	$valor_angariador2 = $linha3['valor_angariador'];
           				  	if($linha3['co_status']=='pendente'){
						       $total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
							}else{
							  $total_angariador_ok = $total_angariador_ok + $valor_angariador2;
							}
							$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO VENDEDOR
						$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha4 = mysql_fetch_array($busca4)){
           				  	$valor_vendedor2 = $linha4['valor_vendedor'];
           				  	if($linha4['co_status']=='pendente'){
						       $total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
							}else{
							  $total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
							}
							$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           				}
           				
           				
           				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
           				
           				$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  <br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   
				   		//BUSCA AS PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           				  	if($j > 0){
           				  	  echo "<br>";
           				  	}
							$nome_angariador = $linha30['nome_angariador'];
           				  	$valor_angariador = $linha30['valor_angariador'];
           				  	$cod_angariador = $linha30['co_cod'];
           				  	$status_angariador = $linha30['co_status'];
           				  	$data_angariador = formataDataDoBd($linha30['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           				  	
           				  	if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}	
				   		$j++;
           				}
           				
				   			   			
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   		
          		   		//BUSCA AS PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
           				  	  echo "<br>";
           				  	}
							$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           				  	
           				  	if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}
          		   	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   
          		   		//BUSCA AS PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
           				  	  echo "<br>";
           				  	}
							$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           				  	
							if($linha['co_verificacao']=='1'){
				   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}	
          		   
				    if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_angariador=='ok' &&  $status_vendedor=='ok' &&  $status_indicador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>	
					");

				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;		
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				    $comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
					
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
		
			
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
				    echo("
						<tr>
      						<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    					</tr>
					");
				}
			
			//REALIZA BUSCA POR TODOS OS TIPOS DE COMISSOES E O TIPO DE IMÓVEL SELECIONADO E USUÁRIO LOGADO
			}elseif($_POST['corretor']=='Todos' && $_POST['tipo_imovel']<>'Todos' && empty($_POST['usuario'])){
				
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
				
				$k= 0;
				
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND m.tipo='".$_POST['tipo_imovel']."' AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
				while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
                        $v_cod = $linha['v_cod'];
                        $v_total = $linha['v_total'];
                        
                        if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;
                        
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO ANGARIADOR
						$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha3 = mysql_fetch_array($busca3)){
           				  	$valor_angariador2 = $linha3['valor_angariador'];
           				  	if($linha3['co_status']=='pendente'){
						       $total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
							}else{
							  $total_angariador_ok = $total_angariador_ok + $valor_angariador2;
							}
							$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO VENDEDOR
						$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha4 = mysql_fetch_array($busca4)){
           				  	$valor_vendedor2 = $linha4['valor_vendedor'];
           				  	if($linha4['co_status']=='pendente'){
						       $total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
							}else{
							  $total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
							}
							$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           				}
           				
           			if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  <br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
							<td class=\"style1\">&nbsp;</td> 
          					<td class=\"style1\" valign=\"top\">
				   ");
				   		
						//BUSCA AS PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           				  	if($j > 0){
							  echo "<br>";
							}
							$nome_angariador = $linha30['nome_angariador'];
           				  	$valor_angariador = $linha30['valor_angariador'];
           				  	$cod_angariador = $linha30['co_cod'];
           				  	$status_angariador = $linha30['co_status'];
           				  	$data_angariador = formataDataDoBd($linha30['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           				  	
							if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}	
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   
          		   		//BUSCA AS PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
							  echo "<br>";
							}
							$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           				  	
           				  	if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   
          		   		//BUSCA AS PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
							  echo "<br>";	   
							}
							$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           				  	
           				  	if($linha['co_verificacao']=='1'){
          		   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}
          		   
				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_angariador=='ok' &&  $status_vendedor=='ok' &&  $status_indicador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>	
					");
					
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				    $comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
			
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
			
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
					echo("
						<tr>
      						<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    					</tr>
					");
				}
			
			//REALIZA BUSCA TIPO DE COMISSOES SELECIONADO E O TIPO DE IMÓVEL SELECIONADO E USUÁRIO LOGADO
			}elseif($_POST['corretor']<>'Todos' && $_POST['tipo_imovel']<>'Todos' && empty($_POST['usuario'])){
			
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
				
				$k= 0;
				
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND m.tipo='".$_POST['tipo_imovel']."' AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
				while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
                        $v_cod = $linha['v_cod'];
                        $v_total = $linha['v_total'];
                        
                        if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;
                        
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND c.c_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO ANGARIADOR
						$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND u.u_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha3 = mysql_fetch_array($busca3)){
           				  	$valor_angariador2 = $linha3['valor_angariador'];
           				  	if($linha3['co_status']=='pendente'){
						       $total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
							}else{
							  $total_angariador_ok = $total_angariador_ok + $valor_angariador2;
							}
							$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO VENDEDOR
						$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND u.u_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha4 = mysql_fetch_array($busca4)){
           				  	$valor_vendedor2 = $linha4['valor_vendedor'];
           				  	if($linha4['co_status']=='pendente'){
						       $total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
							}else{
							  $total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
							}
							$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           				}
           				
           			if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  <br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
							<td class=\"style1\">&nbsp;</td> 
          					<td class=\"style1\" valign=\"top\">
				   ");
				   		
						//BUSCA AS PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND u.u_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           				  	if($j > 0){
							  echo "<br>";
							}
							$nome_angariador = $linha30['nome_angariador'];
           				  	$valor_angariador = $linha30['valor_angariador'];
           				  	$cod_angariador = $linha30['co_cod'];
           				  	$status_angariador = $linha30['co_status'];
           				  	$data_angariador = formataDataDoBd($linha30['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           				  	
							if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}	
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   
          		   		//BUSCA AS PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND u.u_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
							  echo "<br>";
							}
							$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           				  	
           				  	if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   
          		   		//BUSCA AS PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND c.c_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
							  echo "<br>";	   
							}
							$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           				  	
           				  	if($linha['co_verificacao']=='1'){
          		   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}
          		   
				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_angariador=='ok' &&  $status_vendedor=='ok' &&  $status_indicador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>	
					");
					
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				    $comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
			
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
			
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
					echo("
						<tr>
      						<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    					</tr>
					");
				}
				
			//REALIZA BUSCA TIPO DE COMISSOES SELECIONADO E TODOS OS TIPOS DE IMOVÉIS E USUÁRIO LOGADO
			}elseif($_POST['comissoes']<>'Todos' && $_POST['tipo_imovel']=='Todos' && empty($_POST['usuario'])){

				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
				
				$k= 0;
				
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
				while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;	
           		  		
          		    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND c.c_cod='".$_POST['corretor']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO ANGARIADOR
						$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND u.u_cod='".$_POST['corretor']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha3 = mysql_fetch_array($busca3)){
           				  	$valor_angariador2 = $linha3['valor_angariador'];
           				  	if($linha3['co_status']=='pendente'){
						       $total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
							}else{
							  $total_angariador_ok = $total_angariador_ok + $valor_angariador2;
							}
							$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO VENDEDOR
						$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND u.u_cod='".$_POST['corretor']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha4 = mysql_fetch_array($busca4)){
           				  	$valor_vendedor2 = $linha4['valor_vendedor'];
           				  	if($linha4['co_status']=='pendente'){
						       $total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
							}else{
							  $total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
							}
							$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           				}
           				
           				
           				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
           				
           				$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  <br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   
				   		//BUSCA AS PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND u.u_cod='".$_POST['corretor']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           				  	if($j > 0){
           				  	  echo "<br>";
           				  	}
							$nome_angariador = $linha30['nome_angariador'];
           				  	$valor_angariador = $linha30['valor_angariador'];
           				  	$cod_angariador = $linha30['co_cod'];
           				  	$status_angariador = $linha30['co_status'];
           				  	$data_angariador = formataDataDoBd($linha30['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           				  	
           				  	if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}	
				   		$j++;
           				}
           				
				   			   			
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   		
          		   		//BUSCA AS PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND u.u_cod='".$_POST['corretor']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
           				  	  echo "<br>";
           				  	}
							$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           				  	
           				  	if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}
          		   	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   
          		   		//BUSCA AS PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND c.c_cod='".$_POST['corretor']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
           				  	  echo "<br>";
           				  	}
							$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           				  	
							if($linha['co_verificacao']=='1'){
				   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
				   		$j++;
           				}	
          		   
				    if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_angariador=='ok' &&  $status_vendedor=='ok' &&  $status_indicador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>	
					");

				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;		
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				    $comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
					
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
		
			
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
				    echo("
						<tr>
      						<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    					</tr>
					");
				}
							
			//REALIZA BUSCA POR TODOS OS TIPOS DE COMISSOES E TODOS OS TIPOS DE IMOVEIS E USUÁRIO SELECIONADO
			}elseif($_POST['corretor']=='Todos' && $_POST['tipo_imovel']=='Todos' && $_POST['usuario']<>'Todos'){
				
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
				
				$k= 0;
				
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND u.u_cod='".$_POST['usuario']."' AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
				while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;
           		  		
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND u.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO ANGARIADOR
						$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u2.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha3 = mysql_fetch_array($busca3)){
           				  	$valor_angariador2 = $linha3['valor_angariador'];
           				  	if($linha3['co_status']=='pendente'){
						       $total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
							}else{
							  $total_angariador_ok = $total_angariador_ok + $valor_angariador2;
							}
							$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO VENDEDOR
						$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u2.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
 						while($linha4 = mysql_fetch_array($busca4)){
           				  	$valor_vendedor2 = $linha4['valor_vendedor'];
           				  	if($linha4['co_status']=='pendente'){
						       $total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
							}else{
							  $total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
							}
							$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           				}
           				
           			if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
								<br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   
				   		//BUSCA AS PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u2.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_angariador = $linha30['nome_angariador'];
           				  	$valor_angariador = $linha30['valor_angariador'];
           				  	$cod_angariador = $linha30['co_cod'];
           				  	$status_angariador = $linha30['co_status'];
           				  	$data_angariador = formataDataDoBd($linha30['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}
           				$j++;
						}
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   			
          		   		//BUSCA AS PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u2.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
           				$j++;
						}	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   		
						//BUSCA AS PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND u.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
          		   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
           				$j++;
						}
          			
          		   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_angariador=='ok' &&  $status_vendedor=='ok' &&  $status_indicador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>	
					");
				
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				   	$comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
				
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
				  	echo("
				  	<tr>
      					<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    				</tr>
					");
				}
			
			//REALIZA BUSCA POR TODOS OS TIPOS DE COMISSOES E O TIPO DE IMÓVEL SELECIONADO E USUÁRIO SELECIONADO
			}elseif($_POST['corretor']=='Todos' && $_POST['tipo_imovel']<>'Todos' && $_POST['usuario']<>'Todos'){
				
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
				
				$k= 0;
				
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND u.u_cod='".$_POST['usuario']."' AND m.tipo='".$_POST['tipo_imovel']."' AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
				while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;
           		  		
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND u.u_cod='".$_POST['usuario']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO ANGARIADOR
						$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u2.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha3 = mysql_fetch_array($busca3)){
           				  	$valor_angariador2 = $linha3['valor_angariador'];
           				  	if($linha3['co_status']=='pendente'){
						       $total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
							}else{
							  $total_angariador_ok = $total_angariador_ok + $valor_angariador2;
							}
							$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO VENDEDOR
						$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u2.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha4 = mysql_fetch_array($busca4)){
           				  	$valor_vendedor2 = $linha4['valor_vendedor'];
           				  	if($linha4['co_status']=='pendente'){
						       $total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
							}else{
							  $total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
							}
							$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           				}
           				
           				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  	<br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   
				   		//BUSCA AS PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u2.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_angariador = $linha30['nome_angariador'];
           				  	$valor_angariador = $linha30['valor_angariador'];
           				  	$cod_angariador = $linha30['co_cod'];
           				  	$status_angariador = $linha30['co_status'];
           				  	$data_angariador = formataDataDoBd($linha30['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}
           				$j++;
						}
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   			
          		   		//BUSCA AS PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u2.u_cod='".$_POST['usuario']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
           				$j++;
						}	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   		
						//BUSCA AS PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND u.u_cod='".$_POST['usuario']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
          		   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
           				$j++;
						}
							
          		   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_angariador=='ok' &&  $status_vendedor=='ok' &&  $status_indicador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>	
					");
				
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				   	$comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
				
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
			  		echo("
					  <tr>
      					<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    				</tr>
    			   ");
				}
			
			//REALIZA BUSCA TIPO DE COMISSOES SELECIONADO E O TIPO DE IMÓVEL SELECIONADO E USUÁRIO SELECIONADO
			}elseif($_POST['corretor']<>'Todos' && $_POST['tipo_imovel']<>'Todos' && $_POST['usuario']<>'Todos'){
				
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
				
				$k= 0;
				
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND u.u_cod='".$_POST['usuario']."' AND m.tipo='".$_POST['tipo_imovel']."' AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
				while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;
           		  		           		  		
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND u.u_cod='".$_POST['usuario']."' AND c.c_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO ANGARIADOR
						$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u2.u_cod='".$_POST['usuario']."' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha3 = mysql_fetch_array($busca3)){
           				  	$valor_angariador2 = $linha3['valor_angariador'];
           				  	if($linha3['co_status']=='pendente'){
						       $total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
							}else{
							  $total_angariador_ok = $total_angariador_ok + $valor_angariador2;
							}
							$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO VENDEDOR
						$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u2.u_cod='".$_POST['usuario']."' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha4 = mysql_fetch_array($busca4)){
           				  	$valor_vendedor2 = $linha4['valor_vendedor'];
           				  	if($linha4['co_status']=='pendente'){
						       $total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
							}else{
							  $total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
							}
							$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           				}
           				
           				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  	<br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   
				   		//BUSCA AS PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u2.u_cod='".$_POST['usuario']."' AND u.u_cod='".$_POSt['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_angariador = $linha30['nome_angariador'];
           				  	$valor_angariador = $linha30['valor_angariador'];
           				  	$cod_angariador = $linha30['co_cod'];
           				  	$status_angariador = $linha30['co_status'];
           				  	$data_angariador = formataDataDoBd($linha30['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}
           				$j++;
						}
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   			
          		   		//BUSCA AS PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u2.u_cod='".$_POST['usuario']."' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
           				$j++;
						}	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   		
						//BUSCA AS PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND u.u_cod='".$_POST['usuario']."' AND c.c_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
          		   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
           				$j++;
						}
							
          		   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_angariador=='ok' &&  $status_vendedor=='ok' &&  $status_indicador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>
					");
				
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				   	$comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
				
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
			  		echo("
					  <tr>
      					<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    				</tr>
    			   ");
				}
				
			//REALIZA BUSCA TIPO DE COMISSOES SELECIONADO E TODOS OS TIPOS DE IMOVÉIS E USUÁRIO LOGADO
			}elseif($_POST['corretor']<>'Todos' && $_POST['tipo_imovel']=='Todos' && $_POST['usuario']<>'Todos'){
			  		
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
				
				$k= 0;
				
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND u.u_cod='".$_POST['usuario']."' AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
				while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;
           		  		
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND u.u_cod='".$_POST['usuario']."' AND c.c_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO ANGARIADOR
						$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u2.u_cod='".$_POST['usuario']."' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha3 = mysql_fetch_array($busca3)){
           				  	$valor_angariador2 = $linha3['valor_angariador'];
           				  	if($linha3['co_status']=='pendente'){
						       $total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
							}else{
							  $total_angariador_ok = $total_angariador_ok + $valor_angariador2;
							}
							$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           				}
				    	//REALIZA BUSCA DOS DADOS DO VENDEDOR
						$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u2.u_cod='".$_POST['usuario']."' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
 						while($linha4 = mysql_fetch_array($busca4)){
           				  	$valor_vendedor2 = $linha4['valor_vendedor'];
           				  	if($linha4['co_status']=='pendente'){
						       $total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
							}else{
							  $total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
							}
							$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           				}
           				
           			if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
								<br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   
				   		//BUSCA AS PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u2.u_cod='".$_POST['usuario']."' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_angariador = $linha30['nome_angariador'];
           				  	$valor_angariador = $linha30['valor_angariador'];
           				  	$cod_angariador = $linha30['co_cod'];
           				  	$status_angariador = $linha30['co_status'];
           				  	$data_angariador = formataDataDoBd($linha30['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}
           				$j++;
						}
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   			
          		   		//BUSCA AS PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN usuarios u2 ON (co.co_usuario=u2.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u2.u_cod='".$_POST['usuario']."' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
           				$j++;
						}	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   		
						//BUSCA AS PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN usuarios u ON (co.co_usuario=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND u.u_cod='".$_POST['usuario']."' AND c.c_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
								echo "<br>";
							}
           				  	$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  	
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           					
							if($linha['co_verificacao']=='1'){
          		   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
           				$j++;
						}
          			
          		   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_angariador=='ok' &&  $status_vendedor=='ok' &&  $status_indicador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>
					");
				
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				   	$comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
				
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
				
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
				  	echo("
				  	<tr>
      					<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    				</tr>
					");
				}
			
			//REALIZA BUSCA POR TODOS OS TIPOS DE COMISSOES E TODOS OS TIPOS DE IMOVEIS E TODOS OS USUÁRIOS
			}elseif($_POST['corretor']=='Todos' && $_POST['tipo_imovel']=='Todos' && $_POST['usuario']=='Todos'){
			    	
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
			  
			  	$k= 0;
			  
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
					while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;
           		  		
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
           				
           				//REALIZA BUSCA DOS USUÁRIOS	
						$user = mysql_query("SELECT u.u_cod FROM usuarios u INNER JOIN contas co ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY u.u_cod");
						while($linhaUser = mysql_fetch_array($user)){
						    $usuario_anga = $linhaUser['u_cod'];
           				
				    		//REALIZA BUSCA DOS DADOS DO ANGARIADOR
							$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u.u_cod='".$linhaUser['u_cod']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							while($linha3 = mysql_fetch_array($busca3)){
           				  		$valor_angariador2 = $linha3['valor_angariador'];
           				  		if($linha3['co_status']=='pendente'){
						       		$total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
								}else{
							  		$total_angariador_ok = $total_angariador_ok + $valor_angariador2;
								}
								$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           					}
           				}
						
						//REALIZA BUSCA DOS USUÁRIOS	
						$user2 = mysql_query("SELECT u.u_cod FROM usuarios u INNER JOIN contas co ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY u.u_cod");
						while($linhaUser2 = mysql_fetch_array($user2)){     
						     $usuario_vend = $linhaUser2['u_cod'];
           			
				    		//REALIZA BUSCA DOS DADOS DO VENDEDOR
							$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u.u_cod='".$linhaUser2['u_cod']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");							
							while($linha4 = mysql_fetch_array($busca4)){
           				  		$valor_vendedor2 = $linha4['valor_vendedor'];
           				  		if($linha4['co_status']=='pendente'){
						       		$total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
								}else{
							  		$total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
								}
								$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           					}
           				}
           				
           			if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  	<br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   		//BUSCA PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u.u_cod='".$usuario_anga."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           					if($j > 0){
           					   echo "<br>"; 
           					}
							$nome_angariador = $linha30['nome_angariador'];
           					$valor_angariador = $linha30['valor_angariador'];
           					$cod_angariador = $linha30['co_cod'];
           					$status_angariador = $linha30['co_status'];
           					$data_angariador = formataDataDoBd($linha30['co_data']);
           				  		
           					echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           					
				   			if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}
				   		$j++;
				   		}	
				   echo("				    
							</td><td class=\"style1\" valign=\"top\">
          		   ");
          		   
          		   		//BUSCA PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u.u_cod='".$usuario_vend."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");							
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
           						echo "<br>"; 
           					}
							$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  		
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           					
           					if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
           				  		
           				$j++;
						}
          		   	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   		//BUSCA PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");							
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
           						echo "<br>"; 
           					}
							$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  		
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           					
           					if($linha['co_verificacao']=='1'){
          		   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
           				  		
           				$j++;
						}
          		   	
          		   if($status_indicador=='pendente' || $status_vendededor=='pendente' || $status_angariador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_indicador=='ok' || $status_vendededor=='ok' || $status_angariador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>
					");
				
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				   	$comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
				
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
			
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");	
				}else{
				    echo("
				    <tr>
      					<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    				</tr>
					");
				}		
			
			//REALIZA BUSCA POR TODOS OS TIPOS DE COMISSOES E O TIPO DE IMÓVEL SELECIONADO E TODOS OS USUÁRIOS
			}elseif($_POST['corretor']=='Todos' && $_POST['tipo_imovel']<>'Todos' && $_POST['usuario']=='Todos'){

				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');

				$k= 0;
			
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND m.tipo='".$_POST['tipo_imovel']."' AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
					while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;	
           		  		
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, c.c_nome AS nome_indicador, co.co_status, co.co_cod FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS USUÁRIOS	
						$user = mysql_query("SELECT u.u_cod FROM usuarios u INNER JOIN contas co ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY u.u_cod");
						while($linhaUser = mysql_fetch_array($user)){
						  	$usuario_anga = $linhaUser['u_cod'];
           				
				    		//REALIZA BUSCA DOS DADOS DO ANGARIADOR
							$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u.u_cod='".$linhaUser['u_cod']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							while($linha3 = mysql_fetch_array($busca3)){
           				  		$valor_angariador2 = $linha3['valor_angariador'];
           				  		if($linha3['co_status']=='pendente'){
						       		$total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
								}else{
							  		$total_angariador_ok = $total_angariador_ok + $valor_angariador2;
								}
								$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           					}
           				}
						
						//REALIZA BUSCA DOS USUÁRIOS	
						$user2 = mysql_query("SELECT u.u_cod FROM usuarios u INNER JOIN contas co ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY u.u_cod");
						while($linhaUser2 = mysql_fetch_array($user2)){
						    $usuario_vend = $linhaUser2['u_cod'];
           			
				    		//REALIZA BUSCA DOS DADOS DO VENDEDOR
							$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u.u_cod='".$linhaUser2['u_cod']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							while($linha4 = mysql_fetch_array($busca4)){
           				  		$valor_vendedor2 = $linha4['valor_vendedor'];
           				  		if($linha4['co_status']=='pendente'){
						       		$total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
								}else{
							  		$total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
								}
								$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           					}
           				}
           				
           				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  	<br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   			//BUSCA AS PARCELAS DO ANGARIADOR
							$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u.u_cod='".$usuario_anga."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							$j = 0;
							while($linha30 = mysql_fetch_array($busca30)){
           				  		if($j > 0){
									echo "<br>";
								}
								$nome_angariador = $linha30['nome_angariador'];
           				  		$valor_angariador = $linha30['valor_angariador'];
           				  		$cod_angariador = $linha30['co_cod'];
           				  		$status_angariador = $linha30['co_status'];
           				  		$data_angariador = formataDataDoBd($linha30['co_data']);
           				  		
           				  		echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           						echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           						
								if($linha['co_verificacao']=='1'){
				   					if($status_angariador=='pendente'){
				     					echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   					}
				   				}
							$j++;  			
           					}
				   	
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   			//BUSCA AS PARCELAS DO VENDEDOR
							$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u.u_cod='".$usuario_vend."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							$j = 0;
							while($linha40 = mysql_fetch_array($busca40)){
           				  		if($j > 0){
									echo "<br>";
								}
								$nome_vendedor = $linha40['nome_vendedor'];
           				  		$valor_vendedor = $linha40['valor_vendedor'];
           				  		$cod_vendedor = $linha40['co_cod'];
           				  		$status_vendedor = $linha40['co_status'];
           				  		$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  		
           				  		echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           						echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           						
								if($linha['co_verificacao']=='1'){
          		   					if($status_vendedor=='pendente'){
				     					echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   					}
				   				} 
							$j++;  			
           					}
          		   	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   			//BUSCA AS PARCELAS DO INDICADOR
							$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							$j = 0;
							while($linha50 = mysql_fetch_array($busca50)){
           				  		if($j > 0){
									echo "<br>";
								}
								$nome_indicador = $linha50['nome_indicador'];
           				  		$valor_indicador = $linha50['valor_indicador'];
           				  		$cod_indicador = $linha50['co_cod'];
           				  		$status_indicador = $linha50['co_status'];
           				  		$data_indicador = formataDataDoBd($linha50['co_data']);
           				  		
           				  		echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           						echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           						
								if($linha['co_verificacao']=='1'){
          		   					if($status_indicador=='pendente'){
				     					echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   					}
				   				} 
							$j++;  			
           					}	
          			
          		   if($status_indicador=='pendente' || $status_vendededor=='pendente' || $status_angariador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_indicador=='ok' || $status_vendededor=='ok' || $status_angariador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
					
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>
					");
				
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				   	$comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
				
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
            
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
				  echo("
				  	<tr>
      					<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    				</tr>
				  ");
				}
			
			//REALIZA BUSCA TIPO DE COMISSOES SELECIONADO E O TIPO DE IMÓVEL SELECIONADO E TODOS OS USUÁRIOS
			}elseif($_POST['corretor']<>'Todos' && $_POST['tipo_imovel']<>'Todos' && $_POST['usuario']=='Todos'){
			  
			  	echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');

				$k= 0;
			
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND m.tipo='".$_POST['tipo_imovel']."' AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
					while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;			        
				                   		  		
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, c.c_nome AS nome_indicador, co.co_status, co.co_cod FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND c.c_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
				    	//REALIZA BUSCA DOS USUÁRIOS	
						/*
						$user = mysql_query("SELECT u.u_cod FROM usuarios u INNER JOIN contas co ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY u.u_cod");
						while($linhaUser = mysql_fetch_array($user)){
						  	$usuario_anga = $linhaUser['u_cod'];
						*/
           				
				    		//REALIZA BUSCA DOS DADOS DO ANGARIADOR
							$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							while($linha3 = mysql_fetch_array($busca3)){
           				  		$valor_angariador2 = $linha3['valor_angariador'];
           				  		if($linha3['co_status']=='pendente'){
						       		$total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
								}else{
							  		$total_angariador_ok = $total_angariador_ok + $valor_angariador2;
								}
								$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           					}
           				//}
						
						//REALIZA BUSCA DOS USUÁRIOS	
						/*
						$user2 = mysql_query("SELECT u.u_cod FROM usuarios u INNER JOIN contas co ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY u.u_cod");
						while($linhaUser2 = mysql_fetch_array($user2)){
						    $usuario_vend = $linhaUser2['u_cod'];
						*/
           			
				    		//REALIZA BUSCA DOS DADOS DO VENDEDOR
							$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							while($linha4 = mysql_fetch_array($busca4)){
           				  		$valor_vendedor2 = $linha4['valor_vendedor'];
           				  		if($linha4['co_status']=='pendente'){
						       		$total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
								}else{
							  		$total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
								}
								$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           					}
           				//}
           				
           				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  	<br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   			//BUSCA AS PARCELAS DO ANGARIADOR
							$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							$j = 0;
							while($linha30 = mysql_fetch_array($busca30)){
           				  		if($j > 0){
									echo "<br>";
								}
								$nome_angariador = $linha30['nome_angariador'];
           				  		$valor_angariador = $linha30['valor_angariador'];
           				  		$cod_angariador = $linha30['co_cod'];
           				  		$status_angariador = $linha30['co_status'];
           				  		$data_angariador = formataDataDoBd($linha30['co_data']);
           				  		
           				  		echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           						echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           						
								if($linha['co_verificacao']=='1'){
				   					if($status_angariador=='pendente'){
				     					echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   					}
				   				}
							$j++;  			
           					}
				   	
				   echo("				    
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   			//BUSCA AS PARCELAS DO VENDEDOR
							$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							$j = 0;
							while($linha40 = mysql_fetch_array($busca40)){
           				  		if($j > 0){
									echo "<br>";
								}
								$nome_vendedor = $linha40['nome_vendedor'];
           				  		$valor_vendedor = $linha40['valor_vendedor'];
           				  		$cod_vendedor = $linha40['co_cod'];
           				  		$status_vendedor = $linha40['co_status'];
           				  		$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  		
           				  		echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           						echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           						
								if($linha['co_verificacao']=='1'){
          		   					if($status_vendedor=='pendente'){
				     					echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   					}
				   				} 
							$j++;  			
           					}
          		   	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   			//BUSCA AS PARCELAS DO INDICADOR
							$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND c.c_cod='".$_POST['corretor']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							$j = 0;
							while($linha50 = mysql_fetch_array($busca50)){
           				  		if($j > 0){
									echo "<br>";
								}
								$nome_indicador = $linha50['nome_indicador'];
           				  		$valor_indicador = $linha50['valor_indicador'];
           				  		$cod_indicador = $linha50['co_cod'];
           				  		$status_indicador = $linha50['co_status'];
           				  		$data_indicador = formataDataDoBd($linha50['co_data']);
           				  		
           				  		echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           						echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           						
								if($linha['co_verificacao']=='1'){
          		   					if($status_indicador=='pendente'){
				     					echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   					}
				   				} 
							$j++;  			
           					}	
          			
          		  	if($status_indicador=='pendente' || $status_vendededor=='pendente' || $status_angariador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_indicador=='ok' || $status_vendededor=='ok' || $status_angariador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
					
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>	
					");
				
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				   	$comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
				
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
            
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");
				}else{
				  echo("
				  	<tr>
      					<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    				</tr>
				  ");
				}
			  					
			//REALIZA BUSCA TIPO DE COMISSOES SELECIONADO E TODOS OS TIPOS DE IMOVÉIS E TODOS OS USUÁRIOS
			}elseif($_POST['corretor']<>'Todos' && $_POST['tipo_imovel']=='Todos' && $_POST['usuario']=='Todos'){	
			  
				echo('
				<tr class="fundoTabelaTitulo">
          			<td width="11%" class="style1"><b>Data Venda</b></td>
          			<td width="18%" class="style1"><b>Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Tipo Im&oacute;vel</b></td>
          			<td width="12%" class="style1"><b>Valor Bruto</b></td>
          			<td width="17%" class="style1"><b>Angariador</b></td>
          			<td width="15%" class="style1"><b>Vendedor</b></td>
          			<td width="15%" class="style1"><b>Indicador</b></td>
          			<td width="8%" class="style1"><b>Status</b></td>
        		</tr>
				');
			  
			  	$k= 0;
			  	
				$busca = mysql_query("SELECT v.v_total, v.v_cod, DATE_FORMAT(v.v_data, '%d/%m/%Y') AS data_venda, m.ref, t.t_nome, m.titulo, m.finalidade, co.co_status, v.v_imovel, v.v_comissao, co.co_locacao, co.co_verificacao FROM vendas v INNER JOIN muraski m ON (v.v_imovel=m.cod) INNER JOIN contas co ON (co.co_locacao=v.v_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) WHERE m.ref!='x' AND co.co_tipo='Venda' AND (co.co_tipo_user='A' OR co.co_tipo_user='V' OR co.co_tipo_user='I') AND v.v_data BETWEEN '$data1' AND '$data2' AND v.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status GROUP BY v.v_cod");
				$i = 0;
				if(mysql_num_rows($busca) > 0){
					while($linha = mysql_fetch_array($busca)){
           		  		$data_venda = $linha['data_venda'];
           		  		$tipo = $linha['t_nome'];
           		  		$ref = $linha['ref'];
           		  		$titulo = strip_tags($linha['titulo']);
           		  		$status = $linha['co_status'];
           		  		$finalidade = $linha['finalidade'];
           		  		$comissao = $linha['v_comissao'];
           		  		$v_cod = $linha['v_cod'];
           		  		$v_total = $linha['v_total'];
           		  		
           		  		if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					    $k++;
           		  		
				    	//REALIZA BUSCA DOS DADOS DO INDICADOR
						$busca2 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND c.c_cod='".$_POST['corretor']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						while($linha2 = mysql_fetch_array($busca2)){
           				  	$valor_indicador2 = $linha2['valor_indicador'];
           					if($linha2['co_status']=='pendente'){
						       $total_indicador_pendente = $total_indicador_pendente + $valor_indicador2;
							}else{
							  $total_indicador_ok = $total_indicador_ok + $valor_indicador2;
							}
							$total_indicador_geral = $total_indicador_geral + $valor_indicador2;
           				}
           				
           				//REALIZA BUSCA DOS USUÁRIOS	
						/*
						$user = mysql_query("SELECT u.u_cod FROM usuarios u INNER JOIN contas co ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY u.u_cod");
						while($linhaUser = mysql_fetch_array($user)){
						    $usuario_anga = $linhaUser['u_cod'];
						*/    
           				
				    		//REALIZA BUSCA DOS DADOS DO ANGARIADOR
							$busca3 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
							while($linha3 = mysql_fetch_array($busca3)){
           				  		$valor_angariador2 = $linha3['valor_angariador'];
           				  		if($linha3['co_status']=='pendente'){
						       		$total_angariador_pendente = $total_angariador_pendente + $valor_angariador2;
								}else{
							  		$total_angariador_ok = $total_angariador_ok + $valor_angariador2;
								}
								$total_angariador_geral = $total_angariador_geral + $valor_angariador2;
           					}
           				//}
						
						//REALIZA BUSCA DOS USUÁRIOS	
						/*
						$user2 = mysql_query("SELECT u.u_cod FROM usuarios u INNER JOIN contas co ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY u.u_cod");
						while($linhaUser2 = mysql_fetch_array($user2)){     
						     $usuario_vend = $linhaUser2['u_cod'];
						*/     
           			
				    		//REALIZA BUSCA DOS DADOS DO VENDEDOR
							$busca4 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");							
							while($linha4 = mysql_fetch_array($busca4)){
           				  		$valor_vendedor2 = $linha4['valor_vendedor'];
           				  		if($linha4['co_status']=='pendente'){
						       		$total_vendedor_pendente = $total_vendedor_pendente + $valor_vendedor2;
								}else{
							  		$total_vendedor_ok = $total_vendedor_ok + $valor_vendedor2;
								}
								$total_vendedor_geral = $total_vendedor_geral + $valor_vendedor2;
           					}
           				//}
           				
           			if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){ 
							$pasta_finalidade = "locacao";
						}
						else
						{
							$pasta_finalidade = "venda";
						}
						$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
						$imagem = $linha['ref'] . "_1" . ".jpg";
						
						$comissao_imobiliaria = $comissao - $total_indicador_geral - $total_angariador_geral - $total_vendedor_geral;
           				
					echo ("
						<tr class=\"$fundo\">
          					<td class=\"style1\">".$data_venda."</td>
          					<td class=\"style1\">
					");
					
						//VERIFICA SE EXISTE A IMAGEM
				     	if (file_exists($pasta.$imagem)){
							echo("<img border=\"0\" src=\"".$pasta.$imagem."?datafo=".$datafo."&horafo=".$horafo."\" width=\"100\">");				
					    }
					
					
					echo("
							<input type=\"hidden\" name=\"co_locacao_".$i."\" id=\"co_locacao_".$i."\" value=\"".$linha['co_locacao']."\">
							  	<br><b>Ref:</b> ".$ref."<br><b>Valor do Imóvel:</b> ".number_format($v_total,2,',','.')."</td>
          					<td class=\"style1\">".$tipo."</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\" valign=\"top\">
				   ");
				   		//BUSCA PARCELAS DO ANGARIADOR
						$busca30 = mysql_query("SELECT co.co_valor AS valor_angariador, co.co_status, u.u_nome AS nome_angariador, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='A' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");
						$j = 0;
						while($linha30 = mysql_fetch_array($busca30)){
           					if($j > 0){
           					   echo "<br>"; 
           					}
							$nome_angariador = $linha30['nome_angariador'];
           					$valor_angariador = $linha30['valor_angariador'];
           					$cod_angariador = $linha30['co_cod'];
           					$status_angariador = $linha30['co_status'];
           					$data_angariador = formataDataDoBd($linha30['co_data']);
           				  		
           					echo "<input type=\"hidden\" name=\"co_angariador_".$j."\" id=\"co_angariador_".$j."\" value=\"".$cod_angariador."\">";	
           					echo $nome_angariador."<br>".$data_angariador."<br>".number_format($valor_angariador,2,',','.')."<br>";
           					
				   			if($linha['co_verificacao']=='1'){
				   				if($status_angariador=='pendente'){
				     				echo("<input type=\"button\" name=\"oka_".$j."\" id=\"oka_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_angariador."')\"><br>");  
				   				}
				   			}
				   		$j++;
				   		}	
				   echo("				    
							</td><td class=\"style1\" valign=\"top\">
          		   ");
          		   
          		   		//BUSCA PARCELAS DO VENDEDOR
						$busca40 = mysql_query("SELECT co.co_valor AS valor_vendedor, co.co_status, u.u_nome AS nome_vendedor, co.co_cod, co.co_data FROM contas co INNER JOIN usuarios u ON (co.co_cliente=u.u_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='V' AND u.u_cod='".$_POST['corretor']."' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");							
						$j = 0;
						while($linha40 = mysql_fetch_array($busca40)){
           				  	if($j > 0){
           						echo "<br>"; 
           					}
							$nome_vendedor = $linha40['nome_vendedor'];
           				  	$valor_vendedor = $linha40['valor_vendedor'];
           				  	$cod_vendedor = $linha40['co_cod'];
           				  	$status_vendedor = $linha40['co_status'];
           				  	$data_vendedor = formataDataDoBd($linha40['co_data']);
           				  		
           				  	echo "<input type=\"hidden\" name=\"co_vendedor_".$j."\" id=\"co_vendedor_".$j."\" value=\"".$cod_vendedor."\">";	
           					echo $nome_vendedor."<br>".$data_vendedor."<br>".number_format($valor_vendedor,2,',','.')."<br>";
           					
           					if($linha['co_verificacao']=='1'){
          		   				if($status_vendedor=='pendente'){
				     				echo("<input type=\"button\" name=\"okv_".$j."\" id=\"okv_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_vendedor."')\"><br>");  
				   				}
				   			}
           				  		
           				$j++;
						}
          		   	
          		   echo("
							</td>
          					<td class=\"style1\" valign=\"top\">
          		   ");
          		   		//BUSCA PARCELAS DO INDICADOR
						$busca50 = mysql_query("SELECT co.co_valor AS valor_indicador, co.co_status, c.c_nome AS nome_indicador, co.co_cod, co.co_data FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) INNER JOIN vendas v ON (co.co_locacao=v.v_cod) WHERE v.v_cod='".$v_cod."' AND c.c_cod='".$_POST['corretor']."' AND co.co_imovel='".$linha['v_imovel']."' AND co.co_tipo='Venda' AND co.co_tipo_user='I' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $query_status");							
						$j = 0;
						while($linha50 = mysql_fetch_array($busca50)){
           				  	if($j > 0){
           						echo "<br>"; 
           					}
							$nome_indicador = $linha50['nome_indicador'];
           				  	$valor_indicador = $linha50['valor_indicador'];
           				  	$cod_indicador = $linha50['co_cod'];
           				  	$status_indicador = $linha50['co_status'];
           				  	$data_indicador = formataDataDoBd($linha50['co_data']);
           				  		
           				  	echo "<input type=\"hidden\" name=\"co_indicador_".$j."\" id=\"co_indicador_".$j."\" value=\"".$cod_indicador."\">";	
           					echo $nome_indicador."<br>".$data_indicador."<br>".number_format($valor_indicador,2,',','.')."<br>";
           					
           					if($linha['co_verificacao']=='1'){
          		   				if($status_indicador=='pendente'){
				     				echo("<input type=\"button\" name=\"oki_".$j."\" id=\"oki_".$j."\" value=\"OK\" class=\"campo3\" onClick=\"confirma('".$cod_indicador."')\"><br>");  
				   				}
				   			}
           				  		
           				$j++;
						}
          		   	
          		   if($status_indicador=='pendente' || $status_vendededor=='pendente' || $status_angariador=='pendente'){
					  $statusc = "pendente";
					  $cor = "style7";
					}elseif($status_indicador=='ok' || $status_vendededor=='ok' || $status_angariador=='ok'){
					  $statusc = "ok";
					  $cor = "style6";
					}
          		   echo("
							</td>
          					<td class=\"".$cor."\">".$statusc."</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_angariador_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_vendedor_pendente,2,',','.')."</td>
          					<td class=\"style7\"><b>Total Pagar:</b><br>".number_format($total_indicador_pendente,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_angariador_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_vendedor_ok,2,',','.')."</td>
          					<td class=\"style6\"><b>Total Pago:</b><br>".number_format($total_indicador_ok,2,',','.')."</td>
          					<td class=\"style1\">&nbsp;</td>
        				</tr>
        				<tr class=\"$fundo\">
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\">&nbsp;</td>
          					<td class=\"style1\"><b>Total Bruto:</b><br>".number_format($comissao,2,',','.')."<br>
          				");
          				 if($linha['co_verificacao']<>'1'){
          				   if($status_angariador=='pendente' || $status_vendedor=='pendente' || $status_indicador=='pendente'){
							  echo("<input type=\"submit\" name=\"okb_".$i."\" id=\"okb_".$i."\" value=\"OK\" class=\"campo3\" onClick=\"formContaB()\">");
						   }	  
						 }	  
						echo("	  
							  </td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_angariador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_vendedor_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Total Geral:</b><br>".number_format($total_indicador_geral,2,',','.')."</td>
          					<td class=\"style1\"><b>Saldo:</b><br>".number_format($comissao_imobiliaria,2,',','.')."</td>
        				</tr>
					");
				
				//FAZ SOMATÓRIAS DAS COMISSÕES EM GERAL
				$total_comissoes_pendentes += $total_angariador_pendente + $total_vendedor_pendente + $total_indicador_pendente;	
				$total_comissoes_ok += $total_angariador_ok + $total_vendedor_ok + $total_indicador_ok;
				$total_comissoes_geral += $total_angariador_geral + $total_vendedor_geral + $total_indicador_geral;
				//$comissao_imobiliaria_total += $comissao_imobiliaria;
				if($linha['co_verificacao']<>'1'){
					$comissao_bruta_pendente = $comissao_bruta_pendente + $comissao;
				}else{
				   	$comissao_bruta_ok = $comissao_bruta_ok + $comissao;
				}
				$comissao_imobiliaria_total = $comissao_bruta_ok - $total_comissoes_ok;
				
				$total_angariador_pendente = '';
				$total_vendedor_pendente = '';
				$total_indicador_pendente = '';
				$total_angariador_ok = '';
				$total_vendedor_ok = '';
				$total_indicador_ok = '';
				$total_angariador_geral = '';
				$total_vendedor_geral = '';
				$total_indicador_geral = '';
				$nome_angariador = '';
           		$valor_angariador = '';
           		$cod_angariador = '';
           		$status_angariador = '';
				$nome_vendedor = '';
           		$valor_vendedor = '';
           		$cod_vendedor = '';
           		$status_vendedor = '';
           		$nome_indicador = '';
           		$valor_indicador = '';
           		$cod_indicador = '';
           		$status_indicador = '';
           		$total_imovel = $total_imovel + $linha['v_total'];
				$i++;
				}
			
			echo("
				      </table></td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Valor Total dos Imóveis: </b>".number_format($total_imovel,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Comissões T. Corretores: </b>".number_format($total_comissoes_geral,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a pagar: </b>".number_format($total_comissoes_pendentes,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões pagas: </b>".number_format($total_comissoes_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style7\"><b>Comissões a receber: </b>".number_format($comissao_bruta_pendente,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style6\"><b>Comissões recebidas: </b>".number_format($comissao_bruta_ok,2,',','.')."</td>
    				</tr>
    				<tr>
      					<td colspan=\"2\" class=\"style1\"><b>Saldo dísp. Imobiliária: </b>".number_format($comissao_imobiliaria_total,2,',','.')."</td>
    				</tr>
			");	
				}else{
				    echo("
				    <tr>
      					<td colspan=\"8\" class=\"style1\" align=\"center\">Nenhum registro encontrado!</td>
    				</tr>
					");
				}	
			}
		
			
        ?>
        <input name="cont" id="cont" type="hidden" class="campo" value="<?=$i ?>">
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