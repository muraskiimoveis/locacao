<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
//verificaArea("GERAL_DESPESAS");
?>
<html>
<head>
<?php
include("style.php");
if(isset($_GET['l_cod'])){
  $cod_locacao = $_GET['l_cod'];
  $cod_imovel = $_GET['cod'];
}else{
  $cod_locacao = $_POST['l_cod'];
  $cod_imovel = $_POST['cod'];
}
$qry_desp = "select ref, titulo, comissao_diarista from muraski where cod='$cod_imovel' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
$res_desp = mysql_query($qry_desp);
$num_desp = mysql_num_rows($res_desp);
if($num_desp > 0){
 while($not_desp = mysql_fetch_array($res_desp))
 {
	 $referencia = $not_desp[ref];
	 $titulo = $not_desp[titulo];
	 $comissao_diarista = $not_desp[comissao_diarista];
 }
}else{
	 $referencia = '';
	 $titulo = '';
     $comissao_diarista = '';
}
?>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="funcoes/js.js"></script>
<body topmargin=0 leftmargin=0 rightmargin=0 onUnload="window.opener.location.reload()">
<?php
	if(!$from){
		$from = intval($screen * 30);
	}

	if($alterar == 1){
	if($bot == "Apagar"){
	if (verificaFuncao("USER_DESPESA")) { // verifica se pode acessar as areas 
	$query4= "delete from despesas where de_cod='$de_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível apagar suas informações.");
		}
	}
	elseif($bot == "Atualizar"){
	$query4= "update despesas set de_desc='$de_desc', de_valor='$de_valor'
	, de_data='$ano-$mes-$dia' where de_cod='$de_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	}
	elseif($bot == "Pagamento"){
        $dia = date("d");
        $nr_recibo = rand($dia,999999);
        $nr_recibo = str_pad($nr_recibo, 9, "0", STR_PAD_LEFT);
   	    $query4= "update despesas set de_status='PAGA', de_recibo ='$nr_recibo', de_dtrecibo='$ano-$mes-$dia'  where de_cod='$de_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
        $result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
    ?>
      <script language="javascript">NewWindow('recibo_despesa.php?codigo=<?php print("$de_cod"); ?>&recibo=<?php print("$nr_recibo"); ?>', 'recibo3', 750, 500, 'yes');</script>
    <?php
	}
	elseif($bot == "Inserir"){
      if ((isset($_GET['id_servico']) == true) and (isset($_GET['situacao']) == true)){
        $id_servico = $_GET['id_servico'];
        $situacao = $_GET['situacao'];
        $qry_srv = "select * from despesas where de_imovel='$cod_imovel' and de_locacao='$cod_locacao' and de_tipo='$id_servico' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
        $res_srv = mysql_query($qry_srv);
        $nrows_srv = mysql_num_rows($res_srv);
   	    if($nrows_srv > 0){
           if(($situacao == "1E") or ($situacao == "1S") or ($situacao == "1X")){
  	          echo('<script language="javascript">alert("Serviço já lançado para esta Locação/Imovel!");</script>');
              $libera_insere = '0';
           }else{$libera_insere = '1';}
     	}else{$libera_insere = '1';}
      }else{$libera_insere = '1';}
      if($libera_insere == '1'){
	    $query4= "insert into despesas (cod_imobiliaria, de_imovel, de_valor, de_data, de_desc, de_locacao, de_diarista, de_tipo)
	    values('".$_SESSION['cod_imobiliaria']."','$cod_imovel', '$de_valor', '$ano-$mes-$dia', '$nome_servico', '$cod_locacao', '$co_diarista', '$de_tipo')";
	    $result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações.");
	    $de_cod = mysql_insert_id();
      }
    }
	}

?>
<script>
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
<div align="center">
  <center>
<table width=95% border="0" cellpadding="1" cellspacing="1">
<?php
    $query2 = "select * from despesas where de_imovel='$cod_imovel' and de_locacao='$cod_locacao' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
?>
<tr height="50">
	<td colspan="6" class="style1" align="center"><b>Despesas com Serviços no imóvel</b></td>
</tr>
<tr class="fundoTabela">
	<td colspan="6" class="style1"><b>Ref.:</b> <?php print("$referencia"); ?> - <?php print("$titulo"); ?></td>
</tr>
<tr>
	<td colspan="6" height="25px">&nbsp;</td>
</tr>


<tr class="fundoTabelaTitulo">
<td width="15%" class="style1"><p align="center"><b>Data</b></p></td>
<td width="55%" class="style1"><p align="center"><b>Descrição</b></p></td>
<td width="15%" class="style1"><p align="center"><b>Valor</b></p></td>
<td width="15%" class="style1"><p align="center"><b>Status</b></p></td>
</tr>
<?php
	$i = 0;

	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	$from = $from + 1;

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "96b5c9";

	$ano = substr ($not2[de_data], 0, 4);
	$mes = substr($not2[de_data], 5, 2 );
	$dia = substr ($not2[de_data], 8, 2 );
	$diarista = $not2[de_diarista];

    //REALIZA BUSCA DO NOME DA DIARISTA
    $nome_diarista = '';
	$queryD = "select * from clientes where c_cod='$diarista' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$resultD = mysql_query($queryD);
	while($notD = mysql_fetch_array($resultD))
	{
	   $nome_diarista = $notD[c_nome];
	}

    $nome_formulario = "form".($not2[de_cod]+2);

?>
<form method="get" name="<?php print("$nome_formulario")?>" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod_imovel"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$cod_locacao"); ?>">
<input type="hidden" name="de_cod" value="<?php print("$not2[de_cod]"); ?>">
<input type="hidden" name="alterar" value="1">
<input type="hidden" name="lista" value="1">

<tr class="<?php print("$fundo"); ?>">
<td class="style1"><p align="left">
<input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia"); ?>"><font size="2">/</font><input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes"); ?>"><font size="2">/</font><input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"></td>
<?php
	if($not2[de_status] == "A PAGAR"){
?>
<td bgcolor="#<?php print("$fundo"); ?>" style="background: #FF0000;">
<?php
}else{
?>
<td bgcolor="#<?php print("$fundo"); ?>" style="background: #0000FF;">
<?php
}
?>
<input type="text" style="border:2px;" class="campo4" name="de_desc" size="80" value="<?php print("$not2[de_desc]"); ?>" readonly>
</td>
<?php
	if($not2[de_status] == "A PAGAR"){
		$despesas = $despesas + $not2[de_valor];
	}
?>
<td class="style1">
<p align="right">
<input type="text" style="text-align:right;" class="campo4" name="de_valor" size="10" value="<?php print("$not2[de_valor]"); ?>"></td>
<?php
	if($not2[de_status] == "A PAGAR"){
?>
<td class="style1">
<p align="center" class="style7" ><?php print("$not2[de_status]"); ?></td>
<?php
}else{
?>
<td class="style1">
<p align="center" class="style7" style="color: #0000FF;"><?php print("$not2[de_status]"); ?></td>
<?php
}
?>
</tr>
<tr class="<?php print("$fundo"); ?>">
<td class="fundoTabela"><p align="right"><font size="2"> Diarista :</font></p></td>
<td class="style1"><p align="left">
<input type="text" name="nome_diarista" id="nome_diarista" size="80" class="campo4" value='<?php print("$nome_diarista")?>' readonly>
<td class="fundoTabela"></td>
<td class="fundoTabela"></td>
</tr>
<tr class="<?php print("$fundo"); ?>">
<?php
    if (verificaFuncao("USER_DESPESA")) { // verifica se pode acessar as areas
   	if($not2[de_status] == "A PAGAR"){
?>
<td bgcolor="#<?php print("$fundo2"); ?>"><p align="right" class="style1"></td>
<td bgcolor="#<?php print("$fundo2"); ?>"><p align="left" class="style1">
<input type="submit" value="Apagar" class="campo3" name="bot">
<input type="submit" value="Pagamento" class="campo3" name="bot" onClick="if(confirm('Este processo é irreversível. Deseja pagar e emitir recibo??')){ document.forms['<?php print("$nome_formulario")?>'].onsubmit = function(){return true;}}else{document.forms['<?php print("$nome_formulario")?>'].onsubmit = function(){return false;}}">
</td>
<?php
    }else{
?>
<td bgcolor="#<?php print("$fundo2"); ?>"><p align="right" class="style1">
<input type="button" id="recibo1" name="recibo1" value="Recibo" class="campo3" onClick="NewWindow('recibo_despesa.php?codigo=<?php print("$not2[de_cod]");?>', 'recibo1', 750, 500, 'yes');">
</td>
<td bgcolor="#<?php print("$fundo2"); ?>"><p align="left" class="style1">
<input type="text" name="nr_recibo" id="nr_recibo" size="20" class="campo4" value='<?php print(str_pad($not2[de_recibo], 9, "0", STR_PAD_LEFT))?>' readonly>
</td>
<?php
    }
?>
<?php
	}
	else
	{
?>
Apenas o admistrador pode atualizar ou apagar Despesas!
<?php
	}
?></td>
<td bgcolor="#<?php print("$fundo2"); ?>"></td>
<td bgcolor="#<?php print("$fundo2"); ?>"></td>
</tr>
</form>
<?php
	}
	}
	$desp_total = number_format($despesas, 2, ',', '.');
	$dia = date(d);
	$mes = date(m);
	$ano = date(Y);
?>
<tr class="fundoTabela">
<td width="15%" class="style1"><p align="center"><b>&nbsp;</b></p></td>
<td width="55%" class="style1"><p align="left"><font size="3"><b>Despesas à pagar ..........:</b></font></p></td>
<td width="15%" class="style1"><p align="right"><font size="3"> <b> R$ <?php print("$desp_total"); ?></b></font></p></td>
<td width="15%" class="style1"><p align="center"><b>&nbsp;</b></p></td>
</tr>
<tr class="fundoTabelaTitulo">
<td colspan="4" bgcolor="#<?php print("$fundo"); ?>" style="background: #008000;"></td>
</tr>
<tr class="fundoTabelaTitulo">
<td width="15%" class="style1"><p align="center"><b>Data</b></p></td>
<td width="55%" class="style1"><p align="center"><b>Descrição</b></p></td>
<td width="15%" class="style1"><p align="center"><b>Valor</b></p></td>
<td width="15%" class="style1"><p align="center"><b>Status</b></p></td>
</tr>
<form method="get" name="form1"action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod_imovel"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$cod_locacao"); ?>">
<input type="hidden" name="alterar" value="1">
<input type="hidden" name="lista" value="1">

<tr class="<?php print("$fundo"); ?>">

<td class="fundoTabela"><p align="left">
<input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia"); ?>"><font size="2">/</font><input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes"); ?>"><font size="2">/</font><input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"></td>

<input type="hidden" name="id_servico" id="id_servico" value="">
<td class="style1"><p align="left">
<input type="button" id="sele_servico" name="sele_servico" value="Servico" class="campo3" onClick="NewWindow('p_list_servico.php?f_nome=form1&n_campo=nome_servico', 'servico', 750, 500, 'yes');">
<input type="text" name="nome_servico" id="nome_servico" size="80" class="campo" value='' onChange="document.getElementById('de_valor').reload(true);" onBlur="document.getElementById('de_valor').reload(true);">
<input type="hidden" name="de_tipo" value="<?php print("$id_servico"); ?>">
<input type="hidden" name="situacao" value="<?php print("$situacao"); ?>">
<input type="hidden" name="de_desc" value="<?php print("$nome_servico"); ?>">
</td>
<td class="fundoTabela">
<p align="right">
<input type="text" style="text-align:right;" class="campo" name="de_valor" id="de_valor" size="10" value="<?php print("$comissao_diarista"); ?>"></td>
<td class="fundoTabela">
<p align="left"></td>
</tr>
<tr class="<?php print("$fundo"); ?>">
<input type="hidden" name="co_diarista" id="co_diarista" value="">
<td class="fundoTabela"></td>
<td class="style1"><p align="left">
<input type="button" id="sele_diarista" name="sele_diarista" value="Diarista" class="campo3" onClick="NewWindow('p_list_diarista.php?f_nome=form1&t_cod=3&c_campo=cliente&n_campo=nome_diarista', 'janela', 750, 500, 'yes');">
<input type="text" name="nome_diarista" id="nome_diarista" size="80" class="campo" value='' readonly>

</td>
<td class="fundoTabela"></td>
</tr>
<tr>
<td bgcolor="#<?php print("$fundo2"); ?>">
<p align="left" class="style1">
<input type="submit" value="Inserir" class="campo3" name="bot"></td>
<input type="hidden" name="cod" value="<?php print("$cod_imovel"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$cod_locacao"); ?>">
<td bgcolor="#<?php print("$fundo2"); ?>"></td>
<td bgcolor="#<?php print("$fundo2"); ?>"></td>
<td bgcolor="#<?php print("$fundo2"); ?>"></td>
</tr>
</form>
</tr>
<tr class="fundoTabelaTitulo">
<td colspan="4" bgcolor="#<?php print("$fundo"); ?>" style="background: #008000;"></td>
</tr>
<?php
	
	$query2 = "select count(de_cod) as contador from despesas where de_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
                  <tr class="fundoTabelaTitulo">
                  	<td colspan="4" class="style1"><p align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> despesas</b></p></td>
                  </tr>
<?php
	}
?>
<?php
	
	$query2 = "select count(de_cod) as contador from despesas where de_imovel='$cod' 
	and de_status='A PAGAR' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
       $conta_desp = $not2[contador];
?>
                  <tr class="fundoTabelaTitulo">
                  	<td colspan="4" class="style7"><p align="center"><b>Ainda existem <?php print("$conta_desp"); ?> despesas à pagar.</b></p></td>
                  </tr>
<?php
	}
    if($conta_desp > 0)
    {
?>
<form method="get" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod_imovel"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$cod_locacao"); ?>">
<input type="hidden" name="lista" value="1">
<tr>
<td colspan="4" class="style7">
<p align="center" class="style1">
<input type="hidden" name="cod" value="<?php print("$cod_imovel"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$cod_locacao"); ?>">
</tr>
</form>
<?php
    }
?>
</td></tr></table>
<?php
mysql_close($con);
?>
</body>
</html>
