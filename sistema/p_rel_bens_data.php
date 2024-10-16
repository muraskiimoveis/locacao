<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<html>
<head>
<?php
include("style.php");
include("conect.php");
include("l_funcoes.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
    <? include("topo.php"); ?>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
    <?php
    include("menu.php");
    ?>
    </td>
  </tr>
</table>
<?php
if($lista == ""){
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
function seleciona_opcao_neutra(){
  if(document.getElementById('opcao_neutra').checked){
	document.getElementById('opcao_com').checked = false;
	document.getElementById('opcao_sem').checked = false;
    document.getElementById('opcao_sem').value = '0';
    document.getElementById('opcao_com').value = '0';
    document.getElementById('opcao_neutra').value = '1';
  }
}
function seleciona_opcao_com(){
  if(document.getElementById('opcao_com').checked){
    document.getElementById('opcao_sem').checked = false
    document.getElementById('opcao_neutra').checked = false;
    document.getElementById('opcao_sem').value = '0';
    document.getElementById('opcao_com').value = '1';
    document.getElementById('opcao_neutra').value = '0';
  }
}
function seleciona_opcao_sem(){
  if(document.getElementById('opcao_sem').checked){
    document.getElementById('opcao_neutra').checked = false;
    document.getElementById('opcao_com').checked = false;
    document.getElementById('opcao_sem').value = '1';
    document.getElementById('opcao_com').value = '0';
    document.getElementById('opcao_neutra').value = '0';
  }
}
</script>
<div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <input type=hidden name=cod value=<?php print("$cod"); ?>>
  <table width="75%" border="0" cellpadding="1" cellspacing="1">

    <tr height="50">
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Imóveis com Relação de Bens no Período</b><br>
      Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar.</p></td>
    </tr>

    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Período:</b></td>
      <td width="70%" class="style1">
      <input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value=<?php print("$dia"); ?>>/<input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value=<?php print("$mes"); ?>>/<input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"> 
      <b>&agrave;</b>
      <input type="text" name="dia1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia1"); ?>">/<input type="text" name="mes1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes1"); ?>">/<input type="text" name="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano1"); ?>">
      <br>
      Ex.: 10/10/1910 &agrave; 20/10/1910</td>
    </tr>

    <tr class="fundoTabela">
       <td class="style1"><b>&nbsp;</b></td>
       <td class="style1"><input name="data_nula" type="checkbox" id="data_nula" value="1" <? if($data_nula=='1'){ print "CHECKED"; } ?>>
         Marque para pesquisar datas em branco!</td>
    </tr>

    <tr class="fundoTabela">
      <td class=style1><b>Situação da Locação : </b></td>
      <td class="style1">
        <input name="opcao_neutra" id="opcao_neutra" type="radio" value="0" OnClick="seleciona_opcao_neutra()">
        Neutralizar essas Opções
        <input name="opcao_sem" id="opcao_sem" type="radio" value="0" OnClick="seleciona_opcao_sem()">
        SEM Op&ccedil;&atilde;o assinada
        <input name="opcao_com" id="opcao_com" type="radio" value="1" <? echo "CHECKED"; ?> OnClick="seleciona_opcao_com()">
        COM Op&ccedil;&atilde;o assinada
      </td>
    </tr>

    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Finalidade:</b></td>
      <td width="70%" class="style1">
      <select name="finalidade" class=campo>
      		<?php
        //$bfinalidade = mysql_query("select f_cod, f_nome FROM finalidade WHERE f_cod!='1' AND f_cod!='8' ORDER BY f_cod ASC");
       $bfinalidade = mysql_query("select f_cod, f_nome FROM finalidade WHERE f_cod='15' OR f_cod='16' OR f_cod='17' ORDER BY f_cod ASC");
 		while($linha = mysql_fetch_array($bfinalidade)){
			if($linha[f_cod]==$_POST['finalidade']){
			   if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>'); 
			   }else{
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'</option>'); 
			   }
			}else{
			  if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>');
			  }else{
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'</option>');
			  } 
			}
        }
 	    ?>
      </select>
      </td>
    </tr>

    <tr>
      <td width="100%" colspan=2>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="1" name="lista">
      <input type="submit" value="Pesquisar" name="B1" class=campo3></td>
    </tr>

  </table>
  </form>
<?php
}
else
{
		
	if ($screen == "") {
   		$screen = 1;
	}

	$from = ($screen - 1) * 30;

/*
	if($finalidade=='7'){
	  $query_finalidade = " AND (finalidade='1' OR finalidade='2' OR finalidade='3' OR finalidade='4' OR finalidade='5' OR finalidade='6' OR finalidade='7')";
	}elseif($finalidade=='14' || $finalidade=='17'){
	  $query_finalidade = " AND (finalidade='8' OR finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR finalidade='17')";
	}elseif($finalidade<>'%'){
	  $query_finalidade = "AND finalidade='".$finalidade."'";
	}else{
	  $query_finalidade = "AND finalidade like '%'";
	}  
*/

	if($finalidade=='15'){
	  $query_finalidade = " finalidade='15'";
    }elseif($finalidade=='16'){
      $query_finalidade = " finalidade='16'";
    }elseif($finalidade=='17'){
	  $query_finalidade = " (finalidade='15' OR finalidade='16' OR finalidade='17')";
    }

    if($lista == "1"){

?>
<?
    if($finalidade=='1'){
      $fin = "Venda_Rebri";
    }elseif($finalidade=='2'){
      $fin = "Venda_".$_SESSION['nome_imobiliaria'];
    }elseif($finalidade=='3'){
      $fin = "Venda_Parceria";
    }elseif($finalidade=='4'){
      $fin = "Venda_Terceiros";
    }elseif($finalidade=='5'){
      $fin = "Venda_Off";
    }elseif($finalidade=='6'){
      $fin = "Venda_Vendido";
    }elseif($finalidade=='7'){
      $fin = "Venda_Todos";
    }elseif($finalidade=='8'){
      $fin = "Locação_Anual_Rebri";
    }elseif($finalidade=='9'){
      $fin = "Locação_Anual_".$_SESSION['nome_imobiliaria'];
    }elseif($finalidade=='10'){
      $fin = "Locação_Anual_Parceria";
    }elseif($finalidade=='11'){
      $fin = "Locação_Anual_Terceiros";
    }elseif($finalidade=='12'){
      $fin = "Locação_Anual_Off";
    }elseif($finalidade=='13'){
      $fin = "Locação_Anual_Locado";
    }elseif($finalidade=='14'){
      $fin = "Locação_Anual_Todos";
    }elseif($finalidade=='15'){
      $fin = "Locação_Temporada_".$_SESSION['nome_imobiliaria'];
    }elseif($finalidade=='16'){
      $fin = "Locação_Temporada_Off";
    }elseif($finalidade=='17'){
      $fin = "Locação_Temporada_Todos";
    }
?>
<div align="center">
  <center>
<table width="75%" border="0" cellpadding="1" cellspacing="1">
<tr height="50"><td colspan=3 class="style1">
<p align="center"><b>Imóveis com Relação de Bens no Período</b> - Finalidade: <b><?php print($fin); ?></b></p>
</td></tr>
<?php

    if(isset($_POST['opcao_neutra'])){
      $opcao_neutra = $_POST['opcao_neutra'];
    }elseif(isset($_POST['opcao_sem'])){
      $opcao_sem = $_POST['opcao_sem'];
    }elseif(isset($_POST['opcao_com'])){
      $opcao_com = $_POST['opcao_com'];
    }elseif(isset($_GET['opcao_neutra'])){
      $opcao_neutra = $_GET['opcao_neutra'];
    }elseif(isset($_GET['opcao_sem'])){
      $opcao_sem = $_GET['opcao_sem'];
    }elseif(isset($_GET['opcao_com'])){
      $opcao_com = $_GET['opcao_com'];
    }

    if($opcao_neutra == '1'){
      $sql_opcao = '';
    }elseif($opcao_sem == '1'){
      $sql_opcao = " AND opcao_simnao = '0'";
    }elseif($opcao_com == '1'){
      $sql_opcao = " AND opcao_simnao = '1'";
    }

    if (isset($_GET['data_nula'])) {
      $ano = $_GET['ano'];
      $mes = $_GET['mes'];
      $dia = $_GET['dia'];
      $ano1 = $_GET['ano1'];
      $mes1 = $_GET['mes1'];
      $dia1 = $_GET['dia1'];
      $data_nula = $_GET['data_nula'];
      $url_get = "?lista=1&dia=".$_GET['dia']."&mes=".$_GET['mes']."&ano=".$_GET['ano']."&dia1=".$_GET['dia1']."&mes1=".$_GET['mes1']."&ano1=".$_GET['ano1']."&query_finalidade=".$_GET['query_finalidade']."&finalidade=".$_GET['finalidade']."&screen=&data_nula=".$_GET['data_nula'];
    }else{
      $url_post = "?lista=1&dia=".$_POST['dia']."&mes=".$_POST['mes']."&ano=".$_POST['ano']."&dia1=".$_POST['dia1']."&mes1=".$_POST['mes1']."&ano1=".$_POST['ano1']."&query_finalidade=".$_POST['query_finalidade']."&finalidade=".$_POST['finalidade']."&screen=&data_nula=".$_POST['data_nula'];
      $data_nula = $_POST['data_nula'];
    }
    
    if($data_nula =='1'){
      $query1 = "select * from muraski where ref!='x' $sql_opcao and (data_bens = ('0000-00-00') or data_bens is null) and $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by data_bens limit $from, 30";
    } else { $query1 = "select * from muraski where ref!='x' $sql_opcao and data_bens >= ('$ano-$mes-$dia') AND data_bens <= ('$ano1-$mes1-$dia1') and ref!='x' and  $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by data_bens limit $from, 30";}

    //echo " Mostra ==> ".$query1."<BR>";
    //echo "Mostra URL GET ==> ".$url_get."<BR>";
    //echo "Mostra URL POST ==> ".$url_post."<BR>";
    //die();

	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
?>
<tr class="fundoTabelaTitulo">
<td width=50 class="style1"><b>Data</td>
<td width=450 class="style1"><b>Imóvel</td>
</tr>
<?php
	$i = 0;

	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{

	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	$fundo2 = "CCCCCC";

	$ano2 = substr ($not1[data_bens], 0, 4);
	$mes2 = substr($not1[data_bens], 5, 2 );
	$dia2 = substr ($not1[data_bens], 8, 2 );
	$data_bens = "$dia2/$mes2/$ano2";

?>
<tr class="<?php print("$fundo"); ?>">
<td class="fundoTabelaTitulo style1"><p align="left">
<?php print("$data_bens"); ?></a></td>
<td>
<?php

	$query3 = "SELECT ref, titulo, cod FROM muraski WHERE cod='$not1[cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{

?>
<p align="left">

<a href="p_edit_imoveis.php?edit=editar&cod=<?php print("$not3[cod]"); ?>" class="style1">
<?php print("<b>Ref.: $not3[ref]</b>"); ?> - <?php print strip_tags($not3[titulo]); ?></a></p>
<?php
	}
?>
</td>
</tr>
<?php
	}
?>
<?php
	}
    if($data_nula =='1'){
      $query2 = "select count(cod) as contador from muraski where ref!='x' $sql_opcao and (data_bens = ('0000-00-00') or data_bens is null) and $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
    } else { $query2 = "select count(cod) as contador from muraski where ref!='x' $sql_opcao and data_bens >= ('$ano-$mes-$dia') and ref!='x' and data_bens <= ('$ano1-$mes1-$dia1') AND $query_finalidade and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";}
	$result2 = mysql_query($query2);
	
	//$numrows2 = mysql_num_rows($result2);
    //echo "Mostra Query2 ==> ".$query2."<BR>";
    //echo "Mostra Qtdade de linha ==> ".$numrows2."<BR>";

    $url_opcao = '&opcao_neutra='.$opcao_neutra.'&opcao_sem='.$opcao_sem.'&opcao_com='.$opcao_com;

    while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$paginas = $pages = ceil($not2[contador] / 30);
    $pagina = $screen;

    

    $url = "p_rel_bens_data.php?lista=1&dia=".$dia."&mes=".$mes."&ano=".$ano."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&query_finalidade=".$query_finalidade."&data_nula=".$data_nula."&finalidade=".$finalidade.$url_opcao."&screen=";
?>
                  <tr>
				  	<td colspan="3" class="fundoTabelaTitulo style1" align="center"><b>Foram encontrados <?php print("$not2[contador]"); ?> imóveis</b></td>
				  </tr>
                  <tr>
				  	<td colspan="3" class="style1" align="center">
						<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_bens_data.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&query_finalidade=<?=$query_finalidade ?>&data_nula=<?=$data_nula?>&finalidade=<?=$finalidade.$url_opcao?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_bens_data.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&query_finalidade=<?=$query_finalidade ?>&data_nula=<?=$data_nula?>&finalidade=<?=$finalidade.$url_opcao?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
                  				<td class="style1" align="center">
								<?
   									$i = 0;
   									$completa = "";
   									if ($paginas > 9){
      									if ($pagina < 5){
   	   										$inicio = 1;
         									$final = 9;
      									}elseif($pagina > $paginas - 5){
   	   										$inicio = $paginas - 9;
         									$final = $paginas;
      									}else{
   	   										$inicio = $pagina - 4;
         									$final = $pagina + 4;
      									}
   									}else{
	   										$inicio = 1;
      										$final = $paginas;
   									}

   									for ($j = $inicio; $j < ($final+1); $j++){
      									if(($paginas > 9) && (strlen($j)==1)){
		   									$j = "0".$j;
      									}

      									$url2 = $url . $j;


                                        if($j == $pagina){
                                            print "<a href=\"$url2\" class='style1'>| <b>$j</b> |</a>";
 	   									}else{
     	      								print "<a href=\"$url2\" class='style1'>| $j |</a>";
  	   									}


   									}
                                  //echo "Mostra Query1 ==> ".$query1."<BR>";
                                  //echo "Mostra Query2 ==> ".$query2."<BR>";

								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_bens_data.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&query_finalidade=<?=$query_finalidade ?>&data_nula=<?=$data_nula ?>&finalidade=<?=$finalidade.$url_opcao?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_bens_data.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&query_finalidade=<?=$query_finalidade ?>&data_nula=<?=$data_nula ?>&finalidade=<?=$finalidade.$url_opcao?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>

<?php
	}
?>

<?	
	}
?>

</td>
</tr>
</table>
<?php
}
mysql_close($con);
if(session_is_registered("valid_user")){
?>
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
<?
}
?>
</body>
</html>
