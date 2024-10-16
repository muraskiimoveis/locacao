<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_DEPOSITOS");
?>
<html>

<head>
<?php
include("style.php");
?>
<script language="javascript">
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
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes/js.js"></script>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and
	(($u_tipo == "admin"))){
*/

echo $cod;

	$url = $REQUEST_URI;
	//echo $url;
	$url = explode("?", $url);
	//$url2 = explode("dia2", $url[1]);
	//$url = str_replace("&","-","$url");
	//$url = str_replace("?","|","$url");
?>
<div align="center">
  <center>
<table cellpadding="0" border="0" cellspacing="1" width="95%">
<?php
	if(!$from){
		$from = intval($screen * 10);
	}

	if($acao == "Confirmar"){
		//if($co_cat == "Pagar"){
			//$valor = "-" . $valor;
		//}

			//$sobra = $co_valor - $valor;
			//echo $sobra;

		if($co_valor == $valor){

			$query1= "update contas set co_status='ok', co_data_status=current_date
			, co_usuario_status='$u_cod' where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result1 = mysql_query($query1) or die("N�o foi poss�vel atualizar suas informa��es. $query1");
		}
		else
		{

			if($co_cat == "Pagar"){

				$query2 = "select contador, cliente from muraski where cod='$cod_imovel' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result2 = mysql_query($query2);
				$numrows2 = mysql_num_rows($result2);
				while($not2 = mysql_fetch_array($result2))
				{
	  				$contador = $not2[contador];
	  				$cod_cliente = $not2[cliente];
	  				$cliente1 = explode("--", $not2[cliente]);
	  				$cliente2 = str_replace("-","",$cliente1);
				}

				$cod_cliente2 = " (";
				for($i1 = 1; $i1 <= $contador; $i1++){
	    			if($i1==1){
						$cod_cliente2 .= "c_cod='".$cliente2[$i1-1]."'";
					}else{
		  				$cod_cliente2 .= " or c_cod='".$cliente2[$i1-1]."'";
					}
				}
				$cod_cliente2 .= ")";

				$query3 = "select * from clientes, locacao, muraski
				where cod=l_imovel and $cod_cliente2 and
				l_cod='$locacao' and c_cod='$cliente' and muraski.cliente like '".$cod_cliente."' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_cod limit 1";

			}elseif($co_cat == "Receber"){

				$query3 = "select * from clientes, locacao, muraski
				where cod=l_imovel and
				l_cod='$locacao' and c_cod='$cliente' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_cod limit 1";
			}

			$result3 = mysql_query($query3);
			$numrows3 = mysql_num_rows($result3);
			if($numrows3 > 0){
				while($not4 = mysql_fetch_array($result3))
				{
					if($co_cat == "Pagar"){
						$total_loc = $not4[l_total] - ($not4[l_comissao] + $not4[l_desp]);
					}elseif($co_cat == "Receber"){
						$total_loc = $not4[l_total] + $not4[l_limpeza];
					}
					//echo "Total loca��o: " . $total_loc . "<br>";
				}

				$query4 = "select sum(co_valor) as total_ok from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='ok'
				and co_cat='$co_cat'";
				$result4 = mysql_query($query4);
				while($not6 = mysql_fetch_array($result4))
				{
					$total_ok = $not6[total_ok];

					$total_falta = $total_loc - $total_ok;

					//echo "Total falta: " . $total_falta . "<br>";
				}

				$query5 = "select count(co_cod) as contas_pend from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='pendente'
				and co_cat='$co_cat' and co_fixar='no' and co_cod!='$co_cod'";
				$result5 = mysql_query($query5);
				while($not7 = mysql_fetch_array($result5))
				{
					$contas_pend = $not7[contas_pend];
					//echo "Contas pend.: " . $contas_pend . "<br>";

					$total_temp = 0;
					$j = 0;

					$query6 = "select *,(select sum(co_valor) as total_ok from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='ok'
					and co_cat='$co_cat') as total_ok
					, (select count(co_cod) from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='pendente'
					and co_cat='$co_cat' and co_cod!='$co_cod') as contas_pend
					from contas
					where co_locacao='$locacao' and co_cat='$co_cat' and co_status='pendente' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cod!='$co_cod'
					group by co_cod
					order by co_data";
					$result6 = mysql_query($query6);
					while($not5 = mysql_fetch_array($result6))
					{
						//echo $not5[co_fixar];
						if($not5[co_fixar] == "ok"){
							//$valor_fixo[$j] .= 1;
							$parc_dif = $not5[co_valor];
							$total_temp = $total_temp + $parc_dif;
							$j = $j - 1;
						}
						else
						{
							$j++;
							//echo "j: " . $j . "<br>";
						}
					}

					//echo "Total Falta ".$total_falta."<br>";

					//echo "Valor: " . $valor . "<br>";
					//echo "Total temp: " . $total_temp . "<br>";
					$total_falta2 = $total_falta - $valor;
					//echo "Total falta2: " . $total_falta2 . "<br>";
					//echo "Contas pend: ".$contas_pend."<br>";

					$valor_parc = $total_falta2 / $contas_pend;
					//echo "Parcela: " . $valor_parc . "<br>";

				}

				if(($total_falta != "") and ($valor < $total_falta) and ($total_falta > 0) and (($total_falta2 > 0))){

					if($contas_pend >= 1){
						$query7 = "update contas set co_valor='$valor', co_data_status=current_date, co_status='ok'
						where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$result7 = mysql_query($query7) or die("N�o foi poss�vel atualizar suas informa��es. $query7");
						$k = 2;
					}
				}

				$query8 = "select *,(select sum(co_valor) as total_ok from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='ok'
				and co_cat='$co_cat') as total_ok
				, (select count(co_cod) from contas where co_locacao='$locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='pendente'
				and co_cat='$co_cat') as contas_pend
				from contas
				where co_locacao='$locacao' and co_cat='$co_cat' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_status='pendente'
				group by co_cod
				order by co_data";
				$result8 = mysql_query($query8);
				while($not5 = mysql_fetch_array($result8))
				{

					if($k == 2){

						$query9 = "update contas set co_valor='$valor_parc', co_data_status=current_date, co_status='pendente'
						where co_cod='$not5[co_cod]' and co_fixar='no' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
						$result9 = mysql_query($query9) or die("N�o foi poss�vel atualizar suas informa��es. $query9");
					}

				}

			}
			else
			{
				if($saldo > 0){
					$cat = "Receber";
				}
				else
				{
					$cat = "Pagar";
				}
				//Cadastra nova conta com o que falta
				$query10 = "insert into contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor
				, co_locacao, co_usuario, co_forma, co_data_status)
				values('".$_SESSION['cod_imobiliaria']."', '$cliente', '$cat', '$cod_imovel', '$co_desc', 'Loca��o', current_date
				, 'pendente', '$saldo', '$locacao', '$u_cod', '$co_forma', current_date)";
				$result10 = mysql_query($query10) or die("N�o foi poss�vel inserir suas informa��es. $query10");
			}
		}

	}elseif($acao == "X"){

			$query11= "update contas set co_status='pendente', co_data_status=current_date
			, co_usuario_status='$u_cod' where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$result11 = mysql_query($query11) or die("N�o foi poss�vel atualizar suas informa��es. $query11");
	}
	if($alterar_data=="Alterar Data"){

		$queryd= "update contas set co_data='".$ano.'-'.$mes.'-'.$dia."' where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$resultd = mysql_query($queryd) or die("N�o foi poss�vel atualizar suas informa��es. $queryd");
	}
	// Begin ==> Imprime o Boleto
	if($imprimir_boleto=="Re-Imprimir"){
		//$url_reimprime = array();
		// Host do Boleto
		if ((substr($_SERVER['REMOTE_ADDR'],0,11)!='192.168.10.')){
			$hostserver = 'http://200.195.158.202:8160/intranet/sistema/boleto/boleto_cef_sigcb.php?';
		}else{$hostserver = 'http://192.168.10.145/intranet/sistema/boleto/boleto_cef_sigcb.php?';}

		$busca_boleto = "SELECT url_boleto FROM boleto WHERE nrdoc = '$co_boleto' order by nrdoc ASC";
		//echo "Busca Boleto ==> ".$busca_boleto."<br>";
		//die();
		$exec_busca_boleto = mysql_query($busca_boleto) or die("N�o foi poss�vel pesquisar Contas.");
		$res_boleto = mysql_num_rows($exec_busca_boleto);
		while($not_bol = mysql_fetch_array($exec_busca_boleto))
		{
			if($res_boleto > 0){
				$url_reimprime = $hostserver;
				$url_reimprime .= $not_bol[url_boleto];
				//require($url_reimprime);
				//echo "Busca Boleto ==> ".$url_reimprime." == ".$not_bol[url_boleto];
				//die();

				?>
					<script>javascript:window.open('<?php echo $url_reimprime;?>');</script>
				<?
			}

		}
	}
	// EndBegin ==> Fim imprime o Boleto
	//
	// Begin ==> Cria e Imprime Novo Boleto e coloca o anterior aguardando baixa da CEF.
	if($novo_boleto=="Novo Boleto"){
		$campo_bol = array();
		$campo_rem = array();
		$bol_status = 'ENV_CEF';

		// Host do Boleto
		if ((substr($_SERVER['REMOTE_ADDR'],0,11)!='192.168.10.')){
			$hostserver = 'http://200.195.158.202:8160/intranet/sistema/boleto/boleto_cef_sigcb.php?';
		}else{$hostserver = 'http://192.168.10.145/intranet/sistema/boleto/boleto_cef_sigcb.php?';}
		// Cria arquivo Remessa
		$url_impremessa = "boleto/remessa_sigcb_240_cef.php";

		//Inicio Boleto
		$busca_boleto = "SELECT url_boleto FROM boleto WHERE nrdoc = '$co_boleto' AND loc_deletada = 'N' ORDER BY nrdoc ASC";
		$exec_busca_boleto = mysql_query($busca_boleto) or die("N�o foi poss�vel pesquisar Contas.");
		$res_boleto = mysql_num_rows($exec_busca_boleto);
		while($not_bol = mysql_fetch_array($exec_busca_boleto))
		{
			$campos_boleto = explode("&",$not_bol[url_boleto]);
			$url_impbol = array();
			for($c1 = 0; $c1 <= count($campos_boleto); $c1++){
				$campo_bol[$c1][0] = substr($campos_boleto[$c1],0,strpos($campos_boleto[$c1],"="));
				$campo_bol[$c1][1] = substr($campos_boleto[$c1],(strpos($campos_boleto[$c1],"=")+1),strlen($campos_boleto[$c1]));
				if($campo_bol[$c1][0] == 'sacado'){
					$sacado = $campo_bol[$c1][1];
					$url_impbol[0] = $campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'nrdoc'){
					$nrdoc_ant = $campo_bol[$c1][1];
					$nrdoc = intval($campo_bol[$c1][1]+1);
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$nrdoc;
				}elseif($campo_bol[$c1][0] == 'dt_vcto'){
					$data_venc = $ano.'-'.$mes.'-'.$dia;
					$dt_venc = $dia.'/'.$mes.'/'.$ano;
					$dt_baixa = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$dt_venc;
				}elseif($campo_bol[$c1][0] == 'end1'){
					$end1 = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'end2'){
					$end2 = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'demo1'){
					$demo1 = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'demo2'){
					$demo2 = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'demo3'){
					$demo3 = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'inst1'){
					$inst1 = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'inst2'){
					$inst2 = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'inst3'){
					$inst3 = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'inst4'){
					$inst4 = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'd_prazo'){
					$d_prazo = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'taxa'){
					$taxa = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'valor'){
					$valor = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'razao'){
					$razao = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'razao_cnpj'){
					$razao_cnpj = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'razao_end'){
					$razao_end = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}elseif($campo_bol[$c1][0] == 'razao_local'){
					$razao_local = $campo_bol[$c1][1];
					$url_impbol[0] .= "&".$campo_bol[$c1][0]."=".$campo_bol[$c1][1];
				}
				//echo "Campo Boleto ".$c1." ==> ".$campo_bol[$c1][0]." = ".$campo_bol[$c1][1]."<BR>";
			}
			//echo "Url_Boleto ==> ".$url_impbol[0]."<BR>";
			//
			$query_contas= "update contas set co_data='".$data_venc."', co_boleto = '".$nrdoc."', co_status = 'pendente' where co_boleto='".$nrdoc_ant."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			$resul_contas = mysql_query($query_contas) or die("N�o foi poss�vel atualizar suas informa��es. $query_contas");
			//
			$query_bol= "update boleto set dt_baixa='".$dt_baixa."', bol_baixado = 'S' where nrdoc='".$nrdoc_ant."'";
			$resul_bol = mysql_query($query_bol) or die("N�o foi poss�vel atualizar suas informa��es. $query_bol");
			//
            $insere_novo_boleto = "insert into boleto ";
            $insere_novo_boleto .= "(sacado,nrdoc,dt_vcto,valor,d_prazo,taxa,";
            $insere_novo_boleto .= "end1,end2,demo1,demo2,demo3,inst1,inst2,";
            $insere_novo_boleto .= "inst3,inst4,razao,razao_cnpj,razao_end,razao_local, url_boleto,status) ";
			$insere_novo_boleto .= "values ('".$sacado."','".$nrdoc."','".date("Y-m-d", mktime(0, 0, 0, $mes, $dia, $ano))."',".number_format($valor,2,".","").",'".$d_prazo."','".$taxa."',";
			$insere_novo_boleto .= "'".$end1."','".$end2."','".$demo1."','".$demo2."','".$demo3."','".$inst1."','".$inst2."','".$inst3."','".$inst3."',";
			$insere_novo_boleto .= "'".$razao."','".$razao_cnpj."','".$razao_end."','".$razao_local."','".$url_impbol[0]."','".$bol_status."')";
            $rs_insere_boleto = mysql_query($insere_novo_boleto) or die("N�o foi poss�vel atualizar suas informa��es. $insere_novo_boleto $url_impbol[0]");
			//
			// Fim do Boleto

  			$url_imprimebol = $hostserver.$url_impbol[0];

		}
		//
		//echo ".<BR>";
		//echo "x=x=x=x=x=x=x=x=x=x=x SEPARA =x=x=x=x=x=x=x=x=x=x=x"."<BR>";
		//echo ".<BR>";
		//
		$busca_remessa = "SELECT url_remessa FROM remessa WHERE nrdoc = '$co_boleto' AND loc_deletada = 'N' ORDER BY nrdoc ASC";
		$exec_busca_remessa = mysql_query($busca_remessa) or die("N�o foi poss�vel pesquisar Contas.");
		$res_remessa = mysql_num_rows($exec_busca_remessa);
		while($not_rem = mysql_fetch_array($exec_busca_remessa))
		{
			$campos_remessa = explode("&",$not_rem[url_remessa]);
			$url_imprem = array();
			for($r1 = 0; $r1 <= count($campos_remessa); $r1++){
				$campo_rem[$r1][0] = substr($campos_remessa[$r1],0,strpos($campos_remessa[$r1],"="));
				$campo_rem[$r1][1] = substr($campos_remessa[$r1],(strpos($campos_remessa[$r1],"=")+1),strlen($campos_remessa[$r1]));

				if($campo_rem[$r1][0] == 'sacado'){
					$sacado = $campo_rem[$r1][1];
					$url_imprem[0] = $campo_rem[$r1][0]."=".$campo_rem[$r1][1];
				}elseif($campo_rem[$r1][0] == 'nrdoc'){
					$nrdocr_ant = $campo_rem[$r1][1];
					$nrdocr = intval($campo_rem[$r1][1]+1);
					$url_imprem[0] .= "&".$campo_rem[$r1][0]."=".$nrdocr;
				}elseif($campo_rem[$r1][0] == 'data_venc'){
					$data_venc = $ano.'-'.$mes.'-'.$dia;
					$dt_venc = $dia.'/'.$mes.'/'.$ano;
					$dt_baixa = $campo_rem[$r1][1];
					$url_imprem[0] .= "&".$campo_rem[$r1][0]."=".$data_venc;
				}elseif($campo_rem[$r1][0] == 'cpf'){
					$cpf = $campo_rem[$r1][1];
					$url_imprem[0] .= "&".$campo_rem[$r1][0]."=".$campo_rem[$r1][1];
				}elseif($campo_rem[$r1][0] == 'end'){
					$end = $campo_rem[$r1][1];
					$url_imprem[0] .= "&".$campo_rem[$r1][0]."=".$campo_rem[$r1][1];
				}elseif($campo_rem[$r1][0] == 'bairro'){
					$bairro = $campo_rem[$r1][1];
					$url_imprem[0] .= "&".$campo_rem[$r1][0]."=".$campo_rem[$r1][1];
				}elseif($campo_rem[$r1][0] == 'cidade'){
					$cidade = $campo_rem[$r1][1];
					$url_imprem[0] .= "&".$campo_rem[$r1][0]."=".$campo_rem[$r1][1];
				}elseif($campo_rem[$r1][0] == 'uf'){
					$uf = $campo_rem[$r1][1];
					$url_imprem[0] .= "&".$campo_rem[$r1][0]."=".$campo_rem[$r1][1];
				}elseif($campo_rem[$r1][0] == 'cep'){
					$cep = $campo_rem[$r1][1];
					$url_imprem[0] .= "&".$campo_rem[$r1][0]."=".$campo_rem[$r1][1];
				}elseif($campo_rem[$r1][0] == 'valor_boleto'){
					$valor_boleto = $campo_rem[$r1][1];
					$url_imprem[0] .= "&".$campo_rem[$r1][0]."=".$campo_rem[$r1][1];
				}

				//echo "Campo Remessa ".$r1." ==> ".$campo_rem[$r1][0]." = ".$campo_rem[$r1][1]."<BR>";
			}
			//echo "Url_Remessa ==> ".$url_imprem[0]."<BR>";

            // Guardando na Session
            $_SESSION['sacado_r'] = $sacado;
            $_SESSION["cpf_r"] = $cpf;
            $_SESSION["end_r"] = $end;
            $_SESSION["bairro_r"] = $bairro;
            $_SESSION["cidade_r"] = $cidade;
            $_SESSION["uf_r"] = $uf;
            $_SESSION["cep_r"] = $cep;
            $_SESSION["nrdoc_r"] = $nrdocr;
            $_SESSION["valor_boleto_r"] = $valor_boleto;
            $_SESSION["data_venc_r"] = $data_venc;
            // Fim Guarda
			//
			$query_rem= "update remessa set dt_baixa='".$dt_baixa."', rem_baixada = 'S' where nrdoc='".$nrdoc_ant."'";
			$resul_rem = mysql_query($query_rem) or die("N�o foi poss�vel atualizar suas informa��es. $query_rem");
			//
            $url_arqremessa = $url_imprem[0];
            $insere_remessa  = "insert into remessa ";
            $insere_remessa .= "(sacado,nrdoc,dt_vcto,valor,";
            $insere_remessa .= "cpf,end,bairro,cidade,uf,cep,url_remessa,status) ";
			$insere_remessa .= "values ('".$nome."','".$nrdoc."','".date("Y-m-d", mktime(0, 0, 0, $mes, $dia, $ano))."',".number_format($valor_boleto,2,".","").",";
			$insere_remessa .= "'".$c_cpf."','".$c_end."','".$c_bairro."','".$c_cidade."','".$c_estado."','".$c_cep."','".$url_arqremessa."','".$bol_status."')";
            $rs_insere_remessa = mysql_query($insere_remessa) or die("N�o foi poss�vel atualizar suas informa��es. $insere_remessa $url_remessa[$lin]");
            //
            require_once($url_impremessa);
            //


		}

?>
			<script>javascript:window.open('<?php echo $url_imprimebol;?>',"_blank");</script>
<?
		//echo "Busca Boleto ==> ".$busca_boleto."<br>";
		//die();
	}
	// EndBegin ==> Fim imprime o Boleto

	//
	//
	// Pegar dados do im�vel, loca��o e propriet�rio
	if($locacao != ""){

		$query12 = "select contador, cliente from locacao, muraski where cod=l_imovel and
		l_cod='$locacao' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result12 = mysql_query($query12);
		$numrows12 = mysql_num_rows($result12);
		while($not2 = mysql_fetch_array($result12))
		{
	  		$contador = $not2[contador];
	  		$cod_cliente = $not2[cliente];
	  		$cliente1 = explode("--", $not2[cliente]);
	  		$cliente2 = str_replace("-","",$cliente1);
		}

		$cod_cliente2 = " (";
		for($i2 = 1; $i2 <= $contador; $i2++){
	    	if($i2==1){
				$cod_cliente2 .= "c_cod='".$cliente2[$i2-1]."'";
			}else{
		  		$cod_cliente2 .= " or c_cod='".$cliente2[$i2-1]."'";
			}
		}
		$cod_cliente2 .= ")";

		$query13 = "select * from clientes, locacao, muraski where cod=l_imovel and muraski.cliente like '".$cod_cliente."' and $cod_cliente2 and
		l_cod='$locacao' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";


	}elseif($cod_imovel != ""){

		$query14 = "select contador, cliente from locacao, muraski where cod=l_imovel and
		l_imovel='$cod_imovel' and l_data>'2006-10-01' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result14 = mysql_query($query14);
		$numrows14 = mysql_num_rows($result14);
		while($not2 = mysql_fetch_array($result14))
		{
	  		$contador = $not2[contador];
	  		$cod_cliente = $not2[cliente];
	  		$cliente1 = explode("--", $not2[cliente]);
	  		$cliente2 = str_replace("-","",$cliente1);
		}

		$cod_cliente2 = " (";
		for($i3 = 1; $i3 <= $contador; $i3++){
	    	if($i3==1){
				$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
			}else{
		  		$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
			}
		}
		$cod_cliente2 .= ")";


		$query13 = "select * from clientes, locacao, muraski where cod=l_imovel and muraski.cliente like '".$cod_cliente."' and $cod_cliente2 and
		l_imovel='$cod_imovel' and l_data>'2006-10-01' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

	}

		$result13 = mysql_query($query13);
		$numrows13 = mysql_num_rows($result13);
		while($not0 = mysql_fetch_array($result13))
		{
				$cod = $not0[cod];
				$cod_imovel = $not0[cod];
				$ref = $not0[ref];
				$titulo = strip_tags($not0[titulo]);
				$cliente = $not0[c_nome];
				$c_cod = $not0[c_cod];

				$cod_cliente3 = " (";
				for($i4 = 1; $i4 <= $contador; $i4++){
	    			if($i4==1){
						$cod_cliente3 .= "co_cliente='".$cliente2[$i4-1]."'";
					}else{
		  				$cod_cliente3 .= " or co_cliente='".$cliente2[$i4-1]."'";
					}
				}
				$cod_cliente3 .= ")";

				$co_locacao = $not0[l_cod];
				$ano = substr ($not0[l_data_ent], 0, 4);
		        $mes = substr($not0[l_data_ent], 5, 2 );
		        $dia = substr ($not0[l_data_ent], 8, 2 );
		        $ano1 = substr ($not0[l_data_sai], 0, 4);
		        $mes1 = substr($not0[l_data_sai], 5, 2 );
		        $dia1 = substr ($not0[l_data_sai], 8, 2 );
		        $data_ent = "$dia/$mes/$ano";
		        $data_sai = "$dia1/$mes1/$ano1";
		        $l_total = $not0[l_total];
		        $total_tela = number_format($l_total, 2, ',', '.');
		}

		// Pegar dados do inquilino
		$query15 = "select c_cod, c_nome from clientes, locacao where c_cod=l_cliente and
		l_cod='$co_locacao' and clientes.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result15 = mysql_query($query15);
		$numrows15 = mysql_num_rows($result15);
		while($not1 = mysql_fetch_array($result15))
		{
			$locatario = $not1[c_nome];
			$c_cod2 = $not1[c_cod];
		}
?>
<?php
		if($prop <> $cliente){
			$prop = $cliente;
?>
<tr height="50">
	<td colspan=7 class=style1 align="center"><b>Extrato de Dep�sitos</b></td>
</tr>
<tr>
	<td colspan=7><table width=100%>
		<tr class="fundoTabela">
			<td width="10%" class=style1><b>Ref.:</b> <?php print("$ref"); ?></td>
			<td class=style1><b>Im�vel:</b> <?php print("$titulo"); ?></td>
		</tr>
		<tr class="fundoTabela">
			<td class=style1><b>Prop(s).:</b></td>
			<td class=style1>
<?

				for($i5 = 1; $i5 <= $contador; $i5++){

						$query16 = "select * from clientes where c_cod='" . $cliente2[$i5-1] . "' and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
						$result16 = mysql_query($query16);
						while ($not40 = mysql_fetch_array($result16)) {
                            echo($not40['c_nome']."<br>");
						}
				}

?>
			 </td>
		</tr>
	</table></td>
</tr>
<tr>
	<td colspan=7 height=20></td>
</tr>
<?php
		}
?>
<?php

		$query17 = "select contador, cliente from clientes, locacao, muraski
		where cod=l_imovel and
		l_cod<'$locacao' and c_cod='$c_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_cod desc limit 1";
		$result17 = mysql_query($query17);
		$numrows17 = mysql_num_rows($result17);
		while($not2 = mysql_fetch_array($result17))
		{
	  		$contador = $not2[contador];
	  		$cod_cliente = $not2[cliente];
	  		$cliente1 = explode("--", $not2[cliente]);
	  		$cliente2 = str_replace("-","",$cliente1);
		}

		$cod_cliente2 = " (";
		for($i6 = 1; $i6 <= $contador; $i6++){
	    	if($i6==1){
				$cod_cliente2 .= "c_cod='".$cliente2[$i6-1]."'";
			}else{
		  		$cod_cliente2 .= " or c_cod='".$cliente2[$i6-1]."'";
			}
		}
		$cod_cliente2 .= ")";

		$query18 = "select * from clientes, locacao, muraski
		where cod=l_imovel and muraski.cliente like '".$cod_cliente."' and $cod_cliente2 and
		l_cod<'$locacao' and c_cod='$c_cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_cod desc limit 1";
		$result18 = mysql_query($query18);
		while($not6 = mysql_fetch_array($result18))
		{
			$locacao_ant = $not6[l_cod];

			$query19 = "select SUM(co_valor) as saldo from contas where co_imovel='$not6[cod]' and co_cat='Receber'
			and co_status='pendente' AND co_locacao='$not6[l_cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_tipo='Loca��o'";
			$result19 = mysql_query($query19);
			while($not7 = mysql_fetch_array($result19))
			{

				$total_credp7 = $not7[saldo];

				$total_credp_tela7 = number_format($total_credp7, 2, ',', '.');

				//echo $total_credp_tela7;
			}

			$query20 = "select SUM(co_valor) as saldo from contas where co_imovel='$not6[cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber'
			and co_status='pendente' AND co_locacao='$not6[l_cod]' and co_tipo='Despesas'";
			$result20 = mysql_query($query20);
			while($not7 = mysql_fetch_array($result20))
			{

				$total_cred_desp = $not7[saldo];

				$total_cred_desp_tela = number_format($total_cred_desp, 2, ',', '.');

				//echo $total_credp_tela7;
			}

			$query21 = "select SUM(co_valor) as saldo from contas where co_imovel='$not6[cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar'
			and co_status='pendente' AND co_locacao='$not6[l_cod]'";
			$result21 = mysql_query($query21);
			while($not7 = mysql_fetch_array($result21))
			{

				$total_debp7 = $not7[saldo];

				$total_debp_tela7 = number_format($total_debp7, 2, ',', '.');

				//echo $total_debp_tela7;
			}

			$query22 = "select SUM(co_valor) as saldo from contas where co_imovel='$not6[cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber' AND co_tipo='Despesas Im�vel' and co_status='pendente'";
			$result22 = mysql_query($query22);
			while($not70 = mysql_fetch_array($result22))
			{

				$total_debp70 = $not70[saldo];

				$total_debp_tela70 = number_format($total_debp70, 2, ',', '.');

				//echo $total_debp_tela70;
			}

		}
?>
<tr class="fundoTabela">
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1><b><?php print("$data_ent"); ?></b> � <b><?php print("$data_sai"); ?></b></td>
			<td class=style1><b>Locat�rio:</b> <a href="p_clientes.php?lista=1&c_cod=<?php echo($c_cod2); ?>" class="style1" target="_blank"><?php print("$locatario"); ?></a></td>
			<td class=style1><b>Valor Total:</b> R$ <?php print("$total_tela"); ?></td>
		</tr>
	</table></td>
</tr>
<tr height="50">
	<td colspan=7 class=style1 align="center"><b>Valores � receber do Locat�rio:</b></td>
</tr>
<?php
	if($total_credp7 != 0){
		$total_credp_tela7 = str_replace("-","","$total_credp_tela7");
?>
<tr class="fundoTabela">
	<td colspan=7><table width=100%>
		<tr>
			<td class=style7 align=center><b>Existe saldo anterior pendente: R$ <?php print("$total_credp_tela7"); ?></b> - <a href="#" onclick="NewWindow('p_extrato_depositos.php?locacao=<?php print("$locacao_ant"); ?>&tipo_pesq=Loca��o', 'janela2', 750, 500, 'yes')" class="style1">Visualizar</a></td>
		</tr>
	</table></td>
</tr>
<?php
	}
?>

<?php
	//Mostrar os dep�sitos a receber do locat�rio
	$query23 = "select *,(select SUM(co_valor) from contas where co_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber'
	and co_status='pendente') AS saldo
	from contas where co_locacao='$co_locacao' and co_cliente='$c_cod2' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by co_cat desc, co_cliente, co_data";
	$result23 = mysql_query($query23);
	$numrows23 = mysql_num_rows($result23);
?>
<?php
	$i = 0;
	$saldo_total = 0;
	$saldo = 0;

	if($numrows23 > 0){
		while($not2 = mysql_fetch_array($result23))
		{
			$from = $from + 1;

			if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
			$i++;
			$fundo2 = "96b5c9";

				$ano = substr ($not2[co_data], 0, 4);
		        $mes = substr($not2[co_data], 5, 2 );
		        $dia = substr ($not2[co_data], 8, 2 );
		        $ano1 = substr ($not2[co_data_status], 0, 4);
		        $mes1 = substr($not2[co_data_status], 5, 2 );
		        $dia1 = substr ($not2[co_data_status], 8, 2 );

				$data = mktime(0,0,0, $mes, $dia, $ano);
				$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);

				$diarias = round(($data1 - $data)/(24*60*60));
				$diarias = $diarias + 1;

				$total_dias = $diarias + $total_dias;

		        $data = "$dia/$mes/$ano";
		        $data_status = "$dia1/$mes1/$ano1";

			if($not2[co_cat] == "Pagar"){
				//$not2[co_valor] = "-" . $not2[co_valor];
				$not2[co_valor] = $not2[co_valor];

				if($not2[co_status] == "ok")
				{
					$total_deb = $not2[co_valor] + $total_deb;
				}
				else
				{
					$total_debp = $not2[co_valor] + $total_debp;
				}
			}
			else
			{

				if($not2[co_status] == "ok")
				{
					$total_cred = $not2[co_valor] + $total_cred;
				}
				else
				{
					$total_credp = $not2[co_valor] + $total_credp;
				}
			}
			$valor_tela = number_format($not2[co_valor], 2, ',', '.');
			$total = $total_cred + $total_deb;
			$totalp = $total_credp + $total_debp;
			$saldo_total = $totalp + $total;

			if($i <= 2)
			{
				$saldo = $not2[saldo] + $not2[co_valor];
			}
			else
			{
				$saldo = $saldo + $not2[co_valor];
			}

			$saldo_tela = number_format($saldo, 2, ',', '.');
			$saldo_ant_tela = number_format($not2[saldo], 2, ',', '.');
?>
<?php
			if($i == 0){
?>
<tr class="<?php print("$fundo"); ?>">
	<td colspan=7 align=right class=<?php if($not2[saldo] > 0){ echo "style7"; }else{ echo "style6"; } ?>><b>Saldo Anterior: R$ <?php print("$saldo_ant_tela"); ?></b></td>
</tr>
<?php
			}
?>
<form method="post" name="forml" id="forml" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="locacao" value="<?php print("$co_locacao"); ?>">
<input type="hidden" name="cod_imovel" value="<?php print("$cod_imovel"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not2[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not2[co_valor]"); ?>">
<input type="hidden" name="cliente" value="<?php print("$not2[co_cliente]"); ?>">
<input type="hidden" name="co_forma" value="<?php print("$not2[co_forma]"); ?>">
<input type="hidden" name="co_tipo" value="<?php print("$not2[co_tipo]"); ?>">
<input type="hidden" name="co_data" value="<?php print("$not2[co_data]"); ?>">
<input type="hidden" name="co_cat" value="<?php print("$not2[co_cat]"); ?>">
<input type="hidden" name="co_boleto" value="<?php print("$not2[co_boleto]"); ?>">
<tr class="<?php print("$fundo"); ?>">
<td class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>" align="left"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_forma]"); ?></td>
<td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>R$ <input type="text" name="valor" value="<?php print("$not2[co_valor]"); ?>" size="10" class="campo" <?php if(($not2[co_status] == "ok") or ($not2[co_forma] == "Boleto")) { echo "readonly"; } ?>></td>
<?php
if($not2[co_forma] == "Boleto"){
?>
  <td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><IFRAME name=fixa_valor marginWidth=0 marginHeight=0 src="#" frameBorder=0 width=70 scrolling=no height=20 topmargin="0" leftmargin="0"></iframe></td>
<?php
}else{
?>
  <td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><IFRAME name=fixa_valor marginWidth=0 marginHeight=0 src="p_fixa_valor_depositos.php?co_cod=<?php print("$not2[co_cod]");?>" frameBorder=0 width=70 scrolling=no height=20 topmargin="0" leftmargin="0"></iframe></td>
<?php
}
?>
<td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>para</td>
<td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><input type="text" name="dia" id="dia" size="2" maxlenght="2" class="campo" value="<?php print("$dia"); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes" id="mes" size="2" maxlenght="2" class="campo" value="<?php print("$mes"); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano" id="ano" size="4" maxlenght="4" class="campo" value="<?php print("$ano"); ?>" onKeyUp="return autoTab(this, 4, event);">
<?php
if(($not2[co_forma] == "Boleto") and ($not2[co_status] == "pendente") and ($not2[co_conciliado] == "N")){
?>
<!-- ///  Re-Imprime o mesmo Boleto enviado a CEF, sem alterar nada na Cobranca-->
	<input type="submit" name="imprimir_boleto" id="imprimir_boleto" value="Re-Imprimir" class="campo3">
<!-- ///  Imprime Novo Boleto, e enviar Nova Cobranca-->
	<input type="submit" name="novo_boleto" id="novo_boleto" value="Novo Boleto" class="campo3"></td>
<?php
}elseif(($not2[co_forma] == "Boleto") and ($not2[co_status] == "pendente") and ($not2[co_conciliado] == "S")){
?>
	<label class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"> > <?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("CONCILIADO"); ?> </label>
<?php
}elseif(($not2[co_status] == "ok") and ($not2[co_forma] != "Boleto")){
?>
	<input type="submit" name="alterar_data" id="alterar_data" value="Alterar Data" class="campo3"></td>
<?php
}
?>
<td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_tipo]"); ?></td>
<td align="right" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style6"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>
<?php
			if(($not2[co_status] == "ok") or ($not2[co_forma] == "Boleto")){
?>
<?php print("$data_status - $not2[co_status]"); ?> <input type=<?php if($not2[co_forma] == "Boleto"){ echo "hidden"; }else{echo "submit";}?> value="X" class=campo3 name="acao">
<?php
			}
			else
			{
?>
<input type="submit" value="Confirmar" class=campo3 name="acao">
<?php
			}
?>
	</td>
</tr>
</form>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
</tr>
<?php
		}
		$total_tela = number_format($total, 2, ',', '.');
		$totalp_tela = number_format($totalp, 2, ',', '.');
		$saldo_total_tela = number_format($saldo_total, 2, ',', '.');
		$total_cred_tela = number_format($total_cred, 2, ',', '.');
		$total_deb_tela = number_format($total_deb, 2, ',', '.');
		$total_credp_tela = number_format($total_credp, 2, ',', '.');
		$total_debp_tela = number_format($total_debp, 2, ',', '.');
?>
<input type="hidden" name="c_loc" id="c_loc" value="<?=$c_loc; ?>">
<tr>
	<td colspan=7><table width=100%>
		<tr class="fundoTabela">
			<td class=style1 width=50%><b>Valor Recebido:</b> <span class=style6>R$ <?php print("$total_cred_tela"); ?></span></td>
			<td class=style1 width=50%><b>Valor � Receber:</b> <span class=style7>R$ <?php print("$total_credp_tela"); ?></span></td>
</tr></table></td>
</tr>
<?php
	}
	if($total_debp70 != 0){
?>
<tr class="fundoTabela" height="50">
	<td colspan=7 class=style1 align="center"><b>Despesas � receber do Propriet�rio:</b></td>
</tr>
<tr class="fundoTabela">
	<td colspan=7><table width=100%>
		<tr>
			<td class=style7 align=center><b>Existe saldo anterior pendente das despesas do im�vel: R$ <?php print("$total_debp_tela70"); ?></b> - <a href="extrato_despesas_imovel.php?codim=<?php print("$cod_imovel"); ?>&buscad=1" target="_blank" class="style1">Visualizar</a></td>
		</tr>
	</table></td>
</tr>
<?php
	}
?>
<?php
	if($total_cred_desp != 0){
		$total_cred_desp_tela = str_replace("-","","$total_cred_desp_tela");
?>
<tr class="fundoTabela">
	<td colspan=7><table width=100%>
		<tr>
			<td class=style7 align=center><b>Existe saldo anterior pendente: R$ <?php print("$total_cred_desp_tela"); ?></b> - <a href="#" onclick="NewWindow('p_extrato_depositos.php?locacao=<?php print("$locacao_ant"); ?>&tipo_pesq=Loca��o', 'janela3', 750, 500, 'yes');" class="style1">Visualizar</a></td>
		</tr>
	</table></td>
</tr>
<?php
	}
?>
<?php
	//Mostrar os dep�sitos a receber do propriet�rio
	$query24 = "select *, (select SUM(co_valor) from contas where co_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber'
	and co_status='pendente' and co_tipo='Despesas' and co_locacao='$co_locacao') AS saldo
	from contas
	where co_locacao='$co_locacao' and $cod_cliente3 and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Receber'
	order by co_cat desc, co_cliente, co_data";
	$result24 = mysql_query($query24);
	$numrows24 = mysql_num_rows($result24);
?>
<?php
	$i = 0;
	$saldo_total = 0;
	$saldo = 0;
	$total_cred = 0;
	$total_deb = 0;
	$total_credp = 0;
	$total_debp = 0;

	if($numrows24 > 0){
		while($not2 = mysql_fetch_array($result24))
		{
			$from = $from + 1;

			if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
			$i++;
			$fundo2 = "96b5c9";

			$ano = substr ($not2[co_data], 0, 4);
	        $mes = substr($not2[co_data], 5, 2 );
	        $dia = substr ($not2[co_data], 8, 2 );
	        $ano1 = substr ($not2[co_data_status], 0, 4);
	        $mes1 = substr($not2[co_data_status], 5, 2 );
	        $dia1 = substr ($not2[co_data_status], 8, 2 );
	        $boleto = $not2[co_boleto];

			$data = mktime(0,0,0, $mes, $dia, $ano);
			$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);

			$diarias = round(($data1 - $data)/(24*60*60));
			$diarias = $diarias + 1;

			$total_dias = $diarias + $total_dias;

		    $data = "$dia/$mes/$ano";
		    $data_status = "$dia1/$mes1/$ano1";

			if($not2[co_cat] == "Pagar"){
				//$not2[co_valor] = "-" . $not2[co_valor];
				$not2[co_valor] = $not2[co_valor];

				if($not2[co_status] == "ok")
				{
					$total_deb = $not2[co_valor] + $total_deb;
				}
				else
				{
					$total_debp = $not2[co_valor] + $total_debp;
				}
			}
			else
			{
				if($not2[co_status] == "ok")
				{
					$total_cred = $not2[co_valor] + $total_cred;
				}
				else
				{
					$total_credp = $not2[co_valor] + $total_credp;
				}
			}
			//$valor_tela = number_format($not2[co_valor], 2, ',', '.');
			$valor_tela = str_replace("-","","$not2[co_valor]");

			$total = $total_cred + $total_deb;
			$totalp = $total_credp + $total_debp;
			$saldo_total = $totalp + $total;

			if($i <= 2){
				$saldo = $not2[saldo] + $not2[co_valor];
			}
			else
			{
				$saldo = $saldo + $not2[co_valor];
			}
			$saldo_tela = number_format($saldo, 2, ',', '.');
			$saldo_ant_tela = number_format($not2[saldo], 2, ',', '.');
?>
<?php
			if($i == 0){
?>
<tr class="<?php echo $fundo; ?>">
	<td colspan=7 align=right class=<?php if($not2[saldo] > 0){ echo "style6"; }else{ echo "style1"; } ?>><b>Saldo Anterior: R$ <?php print("$saldo_ant_tela"); ?></b></td>
</tr>
<?php
			}
?>
<form method="post" id="formd" name="formd" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="locacao" value="<?php print("$not2[co_locacao]"); ?>">
<input type="hidden" name="cliente" value="<?php print("$not2[co_cliente]"); ?>">
<input type="hidden" name="cod_imovel" value="<?php print("$not2[co_imovel]"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not2[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not2[co_valor]"); ?>">
<input type="hidden" name="co_forma" value="<?php print("$not2[co_forma]"); ?>">
<input type="hidden" name="co_tipo" value="<?php print("$not2[co_tipo]"); ?>">
<input type="hidden" name="co_data" value="<?php print("$not2[co_data]"); ?>">
<input type="hidden" name="co_cat" value="<?php print("$not2[co_cat]"); ?>">
<tr class="<?php echo $fundo; ?>">
<td class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>" align="left"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_forma]"); ?></td>
<?php
	//$valor_tela = $not2[co_valor];
?>
<td align="left" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>R$ <input type="text" name="valor" value="<?php print("$valor_tela"); ?>" size="10" class="campo" <?php if($not2[co_status] == "ok"){ echo "readonly"; } ?>></td>
<td width=70 align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style1"; } ?>"></td>
<td align="left" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>para</td>
<td align="left" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$data"); ?> </td>
<td align="left" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_tipo]"); ?></td>
<td align="right" class="<?php if($not2[co_cat] == "Receber"){ echo "style6"; }else{ echo "style1"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>
<?php
			if($not2[co_status] == "ok"){
?>
<?php print("$data_status - $not2[co_status]"); ?> <input type="submit" value="X" class=campo3 name="acao">
<?php
			}
			else
			{
?>
<input type="submit" value="Confirmar" class=campo3 name="acao">
<?php
			}
?>
	</td>
</tr>
</form>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
</tr>
<?php
		}
		$total_tela = number_format($total, 2, ',', '.');
		$totalp_tela = number_format($totalp, 2, ',', '.');
		$saldo_total_tela = number_format($saldo_total, 2, ',', '.');
		$total_cred_tela = number_format($total_cred, 2, ',', '.');
		$total_deb_tela = number_format($total_deb, 2, ',', '.');
		$total_credp_tela = number_format($total_credp, 2, ',', '.');
		$total_debp_tela = number_format($total_debp, 2, ',', '.');
		$total_deb_tela = str_replace("-","","$total_deb_tela");
		$total_debp_tela = str_replace("-","","$total_debp_tela");
?>
<tr class="fundoTabela">
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1 width=50%><b>Valor Recebido:</b> <span class=style6>R$ <?php print("$total_cred_tela"); ?></span></td>
			<td class=style1 width=50%><b>Valor � Receber:</b> <span class=style7>R$ <?php print("$total_credp_tela"); ?></span></td>
</tr></table>
</td>
</tr>
<?php
	}
?>
<tr height="50">
	<td colspan=7 class=style1 align="center"><b>Dep�sitos � fazer ao Propriet�rio:</b></td>
</tr>
<?php
	if($total_debp7 != 0){
		$total_debp_tela7 = str_replace("-","","$total_debp_tela7");
?>
<tr class="fundoTabela">
	<td colspan=7><table width=100%>
		<tr>
			<td class=style7 align=center><b>Existe saldo anterior pendente: R$ <?php print("$total_debp_tela7"); ?></b> - <a href="#" onclick="NewWindow('p_extrato_depositos.php?locacao=<?php print("$locacao_ant"); ?>&tipo_pesq=Loca��o', 'janela4', 750, 500, 'yes')" class="style1">Visualizar</a></td>
		</tr>
	</table></td>
</tr>
<?php
	}
?>
<?php
	//Mostrar os dep�sitos a fazer pro propriet�rio
	$query25 = "select *,(select SUM(co_valor) from contas where co_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar'
	and co_status='pendente') AS saldo
	from contas where co_locacao='$co_locacao' and $cod_cliente3 and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and co_cat='Pagar' order by co_cat desc, co_cliente, co_data";
	$result25 = mysql_query($query25);
	$numrows25 = mysql_num_rows($result25);
?>
<?php
	$i = 0;
	$saldo_total = 0;
	$saldo = 0;
	$total_cred = 0;
	$total_deb = 0;
	$total_credp = 0;
	$total_debp = 0;

	if($numrows25 > 0){
		while($not2 = mysql_fetch_array($result25))
		{
			$from = $from + 1;

			if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
			$i++;
			$fundo2 = "96b5c9";

			$ano = substr ($not2[co_data], 0, 4);
		    $mes = substr($not2[co_data], 5, 2 );
		    $dia = substr ($not2[co_data], 8, 2 );
		    $ano1 = substr ($not2[co_data_status], 0, 4);
		    $mes1 = substr($not2[co_data_status], 5, 2 );
		    $dia1 = substr ($not2[co_data_status], 8, 2 );

			$data = mktime(0,0,0, $mes, $dia, $ano);
			$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);

			$diarias = round(($data1 - $data)/(24*60*60));
			$diarias = $diarias + 1;

			$total_dias = $diarias + $total_dias;

		    $data = "$dia/$mes/$ano";
		    $data_status = "$dia1/$mes1/$ano1";

			if($not2[co_cat] == "Pagar"){
				//$not2[co_valor] = "-" . $not2[co_valor];
				$not2[co_valor] = $not2[co_valor];

				if($not2[co_status] == "ok"){
					$total_deb = $not2[co_valor] + $total_deb;
				}
				else
				{
					$total_debp = $not2[co_valor] + $total_debp;
				}
			}
			else
			{
				if($not2[co_status] == "ok"){
					$total_cred = $not2[co_valor] + $total_cred;
				}
				else
				{
					$total_credp = $not2[co_valor] + $total_credp;
				}
			}

			//$valor_tela = number_format($not2[co_valor], 2, ',', '.');
			$valor_tela = str_replace("-","","$not2[co_valor]");

			$total = $total_cred + $total_deb;
			$totalp = $total_credp + $total_debp;
			$saldo_total = $totalp + $total;

			if($i <= 2){
				$saldo = $not2[saldo] + $not2[co_valor];
			}
			else
			{
				$saldo = $saldo + $not2[co_valor];
			}
			$saldo_tela = number_format($saldo, 2, ',', '.');
			$saldo_ant_tela = number_format($not2[saldo], 2, ',', '.');
?>
<?php
			if($i == 0){
?>
<tr class="<?php print("$fundo"); ?>">
	<td colspan=7 align=right class=<?php if($not2[saldo] > 0){ echo "style7"; }else{ echo "style2"; } ?>><b>Saldo Anterior: R$ <?php print("$saldo_ant_tela"); ?></b></td>
</tr>
<?php
			}
?>
<form method="post" name="formp" id="formp" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="locacao" value="<?php print("$not2[co_locacao]"); ?>">
<input type="hidden" name="cliente" value="<?php print("$not2[co_cliente]"); ?>">
<input type="hidden" name="cod_imovel" value="<?php print("$not2[co_imovel]"); ?>">
<input type="hidden" name="co_cod" value="<?php print("$not2[co_cod]"); ?>">
<input type="hidden" name="co_valor" value="<?php print("$not2[co_valor]"); ?>">
<input type="hidden" name="co_forma" value="<?php print("$not2[co_forma]"); ?>">
<input type="hidden" name="co_tipo" value="<?php print("$not2[co_tipo]"); ?>">
<input type="hidden" name="co_data" value="<?php print("$not2[co_data]"); ?>">
<input type="hidden" name="co_cat" value="<?php print("$not2[co_cat]"); ?>">
<tr class="<?php print("$fundo"); ?>">
<td class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>" align="left"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_forma]"); ?></td>
<?php
	//$valor_tela = $not2[co_valor];
?>
<td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>R$ <input type="text" name="valor" value="<?php print("$valor_tela"); ?>" size="10" class="campo" <?php if($not2[co_status] == "ok"){ echo "readonly"; } ?>></td>
<td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><IFRAME name=fixa_valor marginWidth=0 marginHeight=0 src="p_fixa_valor_depositos.php?co_cod=<?php print("$not2[co_cod]"); ?>" frameBorder=0 width=70 scrolling=no height=20 topmargin="0" leftmargin="0" class="style1"></iframe></td>
<td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>para</td>
<td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><input type="text" name="dia" id="dia" size="2" maxlenght="2" class="campo" value="<?php print("$dia"); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes" id="mes" size="2" maxlenght="2" class="campo" value="<?php print("$mes"); ?>" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano" id="ano" size="4" maxlenght="4" class="campo" value="<?php print("$ano"); ?>" onKeyUp="return autoTab(this, 4, event);">
<input type="submit" name="alterar_data" id="alterar_data" value="Alterar Data" class="campo3"></td>
<td align="left" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?><?php print("$not2[co_tipo]"); ?></td>
<td align="right" class="<?php if($not2[co_cat] == "Pagar"){ echo "style7"; }else{ echo "style2"; } ?>"><?php if($not2[co_status] == "pendente"){ echo "<b>"; } ?>
<?php
			if($not2[co_status] == "ok"){
?>
<?php print("$data_status - $not2[co_status]"); ?> <input type="submit" value="X" class=campo3 name="acao">
<?php
			}
			else
			{
?>
<input type="submit" value="Confirmar" class=campo3 name="acao">
<?php
			}
?>
	</td>
</tr>
</form>
<tr>
	<td colspan=7 bgcolor="#<?php print("$cor6"); ?>" height=1></td>
</tr>
<?php
		}
		$total_tela = number_format($total, 2, ',', '.');
		$totalp_tela = number_format($totalp, 2, ',', '.');
		$saldo_total_tela = number_format($saldo_total, 2, ',', '.');
		$total_cred_tela = number_format($total_cred, 2, ',', '.');
		$total_deb_tela = number_format($total_deb, 2, ',', '.');
		$total_credp_tela = number_format($total_credp, 2, ',', '.');
		$total_debp_tela = number_format($total_debp, 2, ',', '.');
		$total_deb_tela = str_replace("-","","$total_deb_tela");
		$total_debp_tela = str_replace("-","","$total_debp_tela");
?>
<tr class="fundoTabela">
	<td colspan=7><table width=100%>
		<tr>
			<td class=style1 width=50%><b>Valor Pago:</b> <span class=style6>R$ <?php print("$total_deb_tela"); ?></span></td>
			<td class=style1 width=50%><b>Valor � Pagar:</b> <span class=style7>R$ <?php print("$total_debp_tela"); ?></span></td>
</tr></table>
</td>
</tr>
<tr>
	<td colspan=7 height=50></td>
</tr>
<?php
	}
?>
<?php
	//}//while0
?>
</table>
</td></tr></table>
<?php
/*
mysql_free_result($result1);
mysql_free_result($result2);
mysql_free_result($result3);
mysql_free_result($result4);
*/
mysql_close($con);
?>
<?php
/*
	}
	else
	{
*/
?>
<?php
//include("login2.php");
?>
<?php
//	}
?>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<input type="button" name="fechar" id="fechar" class="campo3 noprint" value="Fechar" OnClick="javascript:window.close();">
<br>
<? } ?>
</body>
</html>
