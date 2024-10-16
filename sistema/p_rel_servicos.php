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
<script type="text/javascript" src="funcoes/js.js"></script>
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
	if($lista == ""){
?>
<script language="javascript">
function valida()
{
  var diarista = true;
  var imovel = true;

  if (document.form1.dia.value == "")
  {
    alert("Por favor, digite o Dia desejado");
    document.form1.dia.focus();
    return (false);
  }
  if (document.form1.mes.value == "")
  {
    alert("Por favor, digite o Mês desejado");
    document.form1.mes.focus();
    return (false);
  }
  if (document.form1.ano.value == "")
  {
    alert("Por favor, digite o Ano desejado");
    document.form1.ano.focus();
    return (false);
  }
  
  if (document.form1.nome_diarista.value == "")
  {
    diarista = false;
    document.form1.nome_diarista.focus();
  }

  if (document.form1.nome_imovel.value == "")
  {
    imovel = false;
    document.form1.nome_imovel.focus();
  }

  if(!diarista && !imovel)
  {
    alert("Por favor, pesquise o Nome desejado!");
    return (false);
  }

  return(true);

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
<?php
	//$ano = date(Y);
	//$ano1 = date(Y);
?>
<div align="center">
  <center>
  <form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <input type=hidden name=cod value=<?php print("$cod"); ?>>
  <table width="75%" border="0" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Relatório de Serviçocs</b><br>
 Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar.</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Período de execução do Serviço:</b></td>
      <td width="70%" class="style1">
      <input type="text" name="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value=<?php print("$dia"); ?>>/<input type="text" name="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value=<?php print("$mes"); ?>>/<input type="text" name="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"> 
      <b>&agrave;</b>
      <input type="text" name="dia1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$dia1"); ?>">/<input type="text" name="mes1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php print("$mes1"); ?>">/<input type="text" name="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano1"); ?>">
      <br>
      Ex.: 
    10/10/1910 &agrave; 20/10/1910</td>
    </tr>

    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Situação:</b></td>
      <td width="70%" class="style1"><select name="status" class=campo>
      				<option value="PAGA">Paga</option>
      				<option value="A PAGAR">A Pagar</option>
      			</select></td>
    </tr>

    <tr class="fundoTabela">
    <input type="hidden" name="co_diarista" id="co_diarista" value="">
    <td class="fundoTabela"></td>
    <td class="style1"><p align="left">
    <input type="button" id="sele_diarista" name="sele_diarista" value="Diarista" class="campo3" onClick="NewWindow('p_list_diarista.php?f_nome=form1&t_cod=3&c_campo=cliente&n_campo=nome_diarista', 'janela', 750, 500, 'yes');">
    <input type="text" name="nome_diarista" id="nome_diarista" size="80" class="campo" value='' readonly>
    </td>
    <td class="fundoTabela"></td>
    </tr>

    <tr class="fundoTabela">
    <input type="hidden" name="co_imovel" id="co_imovel" value="">
    <td class="fundoTabela"></td>
    <td class="style1"><p align="left">
    <input type="button" id="sele_imovel" name="sele_imovel" value="Imovel" class="campo3" onClick="NewWindow('p_list_imoveis.php?f_nome=form1&t_cod=3&c_campo=ref&n_campo=titulo&form_servico=1', 'janela', 750, 500, 'yes');">
    <input type="text" name="nome_imovel" id="nome_imovel" size="80" class="campo" value='' readonly>
    </td>
    <td class="fundoTabela"></td>
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

if($lista == "1")
	{
?>
<div align="center">
  <center>
<table width="75%" border="0" cellpadding="1" cellspacing="1">
<tr height="50">
<td colspan=3 class="style1">
<p align="center"><b>Relatório de Serviços</b> - Status: <b><?php print("$status"); ?></b></p>
</td></tr>
<br>
<tr height="50">
<td colspan=3 class="style1">
<?php
    if($co_imovel > 0)
    {
	$query3 = "SELECT ref, titulo, cod FROM muraski WHERE cod='$co_imovel' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
    }elseif($co_diarista > 0)
    {
	$query3 = "SELECT c_nome FROM cliente WHERE c_cod='$co_diarista' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
    }

	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
    if($co_imovel > 0)
    {
?>
    <p align="left">
    Imovel -
    <a href="p_edit_imoveis.php?edit=editar&cod=<?php print("$not3[cod]"); ?>" class="style1">
    <?php print("<b>Ref.: $not3[ref]</b>"); ?> - <?php print strip_tags($not3[titulo]); ?></a></p>
<?php
    }elseif($co_diarista > 0){
?>
    <p align="left"> Diarista : <?php print("$not3[c_nome]"); ?></p>
<?php
    }
    }
?>
</td>
</tr>
<?php

    if($co_imovel > 0)
    {
    $texto = "Diarista / Serviço";
    $query2 = "select * from despesas where de_imovel='$co_imovel' and de_status='$status' and (de_data >= ('$ano-$mes-$dia') AND de_data <= ('$ano1-$mes1-$dia1')) and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
    }elseif($co_diarista > 0)
    {
    $texto = "Imovel / Serviço";
    $query2 = "select * from despesas where de_diarista='$co_diarista' and de_status='$status' and (de_data >= ('$ano-$mes-$dia') AND de_data <= ('$ano1-$mes1-$dia1')) and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
    }

	//echo $query2;
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
?>
<tr class="fundoTabelaTitulo">
<td width=50 align="center" class="style1"><b>Execução</td>
<td width=450 class="style1"><b><?php print("$texto");?></td>
<td width=50 align="center" class="style1"><b>Pagamento</td>
<td width=50 align="right" class="style1"><b>Valor R$</td>
</tr>
<?php
	$i = 0;

	if($numrows2 > 0)
    {
	while($not2 = mysql_fetch_array($result2))
	{
    	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
    	$i++;
    	$fundo2 = "CCCCCC";

        $ano2 = substr ($not2[de_data], 0, 4);
        $mes2 = substr($not2[de_data], 5, 2 );
        $dia2 = substr ($not2[de_data], 8, 2 );
        $data_exe = "$dia2/$mes2/$ano2";
        $ano3 = substr ($not2[de_dtrecibo], 0, 4);
        $mes3 = substr($not2[de_dtrecibo], 5, 2 );
        $dia3 = substr ($not2[de_dtrecibo], 8, 2 );
        $data_pgt = "$dia3/$mes3/$ano3";
        
        $despesas = $despesas + $not2[de_valor];

        $qry_loc = "select l_data_ent, l_data_sai from locacao where l_cod='$not2[de_imovel]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
        $res_loc = mysql_query($qry_loc);
        $num_loc = mysql_num_rows($res_loc);
        if($num_loc > 0){
         while($not_loc = mysql_fetch_array($res_loc))
         {
        	$ano10 = substr ($not_loc[l_data_ent], 0, 4);
        	$mes10 = substr($not_loc[l_data_ent], 5, 2 );
        	$dia10 = substr ($not_loc[l_data_ent], 8, 2 );
        	$ano11 = substr ($not_loc[l_data_sai], 0, 4);
        	$mes11 = substr($not_loc[l_data_sai], 5, 2 );
        	$dia11 = substr ($not_loc[l_data_sai], 8, 2 );

         }
        }

        $locacao = "Loca&ccedil;&atilde;o do dia <b>".$dia10."/".$mes10."/".$ano10."</b> at&eacute; o dia <b>".$dia11."/".$mes11."/".$ano11." </b>";

        if($co_imovel > 0)
        {
    	$qry_desc = "SELECT c_nome FROM clientes WHERE c_cod='$not2[de_diarista]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
        }elseif($co_diarista > 0)
        {
    	$qry_desc = "SELECT ref, titulo, cod FROM muraski WHERE cod='$not2[de_imovel]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
        }

    	$res_desc = mysql_query($qry_desc);
    	while($not_desc = mysql_fetch_array($res_desc))
    	{
            if($co_imovel > 0)
            {
            $descricao = "<b>[Diarista]</b> - ".$not_desc[c_nome];
            }elseif($co_diarista > 0)
            {
            $descricao = "<a href=\"p_edit_imoveis.php?edit=editar&cod=".$not_desc[cod]." class=\"style1\"><b>Ref.: ".$not_desc[ref]."</b> - ".strip_tags($not_desc[titulo])."</a></p>";
            }
    	}
        //$descricao = $locacao.$descricao;

?>

<tr class="<?php print("$fundo"); ?>">
<td class="fundoTabelaTitulo style1"><p align="center">
<?php print("$data_exe"); ?></p></td>
<td class="fundoTabelaTitulo style1"><p align="left">
<?php print("$locacao")."&nbsp;&nbsp;&nbsp;-&nbsp;<b>[Servico]</b> : ".$not2[de_desc]; ?></p></td>
<td class="fundoTabelaTitulo style1"><p align="center">
<?php print("$data_pgt"); ?></p></td>
<td class="fundoTabelaTitulo style1"><p align="right">
<?php print(number_format($not2[de_valor],2,',','.')); ?></p></td>
</tr>
<tr class="<?php print("$fundo"); ?>">
<td class="fundoTabelaTitulo style1"><p align="left"> </p></td>
<td class="fundoTabelaTitulo style1"><p align="left">
<?php print("$descricao")?></p></td>
<td class="fundoTabelaTitulo style1"><p align="left"></p></td>
<td class="fundoTabelaTitulo style1"><p align="left"></p></td>
</tr>


<?php
	}  // Fim do Laço Serviços
?>
<?php
	}  // Fim dos Serviços
    $desp_total = number_format($despesas, 2, ',', '.');
?>
<tr class="fundoTabela">
<td width="15%" class="style1"><p align="center"><b>&nbsp;</b></p></td>
<td width="55%" class="style1"><p align="left"><font size="3"><b>Total de Serviços ..........:</b></font></p></td>
<td width="15%" class="style1"><p align="center"><b>&nbsp;</b></p></td>
<td width="15%" class="style1"><p align="right"><font size="3"> <b> R$ <?php print("$desp_total"); ?></b></font></p></td>
</tr>
<?php
    if($co_imovel > 0)
    {
    $qry_tot = "select count(de_cod) as contador from despesas where de_imovel='$co_imovel' and de_status='$status' and (de_data >= ('$ano-$mes-$dia') AND de_data <= ('$ano1-$mes1-$dia1')) and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$res_tot = mysql_query($qry_tot);
	$num_tot = mysql_num_rows($res_tot);
    }elseif($co_diarista > 0)
    {
    $qry_tot = "select count(de_cod) as contador from despesas where de_diarista='$co_diarista' and de_status='$status' and (de_data >= ('$ano-$mes-$dia') AND de_data <= ('$ano1-$mes1-$dia1')) and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$res_tot = mysql_query($qry_tot);
	$num_tot = mysql_num_rows($res_tot);
    }

	$res_tot = mysql_query($qry_tot);
	while($not_tot = mysql_fetch_array($res_tot))
	{
?>
<?php
	$paginas = $pages = ceil($not_tot[contador] / 30);
    $pagina = $screen;
    $url = "p_rel_servicos.php?lista=1&dia=".$dia."&mes=".$mes."&ano=".$ano."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&status=".$status."&screen=";
?>
                  <tr>
				  	<td colspan="4" class="fundoTabelaTitulo style1" align="center"><b>Foram encontrados <?php print("$not_tot[contador]"); ?> imóveis</b></td>
				  </tr>
                  <tr>
				  	<td colspan="3" class="style1" align="center">
						<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_servicos.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&status=<?=$status ?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_servicos.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&status=<?=$status ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_servicos.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&status=<?=$status ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_rel_servicos.php?lista=1&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&status=<?=$status ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
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
