<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("USER_GERAL");
include("style.php");

function data_mostra ($j_nascimento) {
   $tmp_dt = explode("-",$j_nascimento);
   $dt_nasc = $tmp_dt[2]."/".$tmp_dt[1]."/".$tmp_dt[0];
	return $dt_nasc;
}

if ($_SERVER['REMOTE_ADDR'] == "201.22.15.53") {
   $imob = "83";
} elseif ($_SERVER['REMOTE_ADDR'] == "192.168.0.5") {
   $imob = "3";
} else {
   $imob = $_SESSION['cod_imobiliaria'];
}

?>
<html>
<head>
</head>
<?php
//	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and ($u_tipo == "admin")){
?>
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

<?
/*
################################################################################
# PARTE INICIAL DO ARQUIVO NÃO ALTERAR DAQUI PARA CIMA
# ***** EXCETO O PADRÃO DE ACESSO...  "GERAL..." *****
################################################################################
/**/
?>

<table border="0" cellspacing="1" align="center" width=100%>
   <tr>
      <td align=center valign=top align="center">
<?php
if ($lista == "") {
?>

         <table border="0" cellspacing="1" width="75%">
           <tr height="50">
               <td colspan=3 align="center" class="style1"><p align="center"><b>Acessos totais aos imóveis no Site da <?=$_SESSION['nome_imobiliaria']?></b></p></td>
            </tr>
            <tr class="fundoTabela">
               <td class="style1" align="center" colspan="3">
               <form name="pesq" method="post" action="<?=$PHP_SELF?>">
               Pesquisa por mes/ano:
                  <select name="mes" onchange="submit();" class="campo">
                     <option value="" <? if ($_POST[mes] == "") { print "SELECTED='SELECTED'"; } ?>>Todos</option>
<?
   if ($screen == "") {
      $screen = 1;
   }
   $from = ($screen - 1) * 30;

   if ($_POST[mes] <> "" || $_GET[mes] <> "") {
      $t_mes = $mes;
      $t2_mes = substr($t_mes, 0, 4) . "-" . substr($t_mes, 4,2) . "-";
      $pesq_mes = "and s_data like '$t2_mes%'";
   }

   $sqlp = "select s_data FROM stats WHERE s_imobiliaria = '$imob' GROUP BY s_data ORDER BY s_data DESC";
   $rsp = mysql_query($sqlp);
   $pesq_data = "";
   while ($np = mysql_fetch_assoc($rsp)) {
      $t_data = str_replace("-","",$np[s_data]);
      $p_data = substr($t_data, 0, 6);
      $p_mostra_data = substr($t_data, 4, 2) . "/" . substr($t_data, 0, 4);
      if ($pesq_data <> $p_data) {
		   $pesq_data = $p_data;
         if ($t_mes == $p_data) {
?>
         <option value="<?=$p_data?>" selected='selected'><?=$p_mostra_data?></option>
<?
         } else {
?>
         <option value="<?=$p_data?>"><?=$p_mostra_data?></option>
<?
         }
?>
<?
      }

   }
?>
                  </select>
                  <input type="submit" name="B1" value="Pesquisar" class="campo3" />
                  </form></td>
            </tr>

            <tr class="fundoTabelaTitulo">
               <td width=34% class="style1" align="center"><b>Data</b></td>
               <td width=33% class="style1" align="center"><b>Acessos</b></td>
               <td width=33% class="style1" align="center"><b>Imóveis Visitados</b></td>
            </tr>

<?
   $sql = "select s_data FROM stats WHERE s_imobiliaria = '$imob' $pesq_mes GROUP BY s_data ORDER BY s_data DESC LIMIT $from, 30";


   $rs = mysql_query($sql) or die ("Erro 58 - ".mysql_error());
   $i = 0;
   while ($not = mysql_fetch_assoc($rs)) {
      if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	  $i++;
      $s_data = $not[s_data];
      $m_data = data_mostra($s_data);
      $e_data = base64_encode($s_data);

      $sqla = "SELECT SUM(s_qtd) as acessos FROM stats WHERE s_data = '$s_data' AND s_imobiliaria = '$imob' ";
      $rsa = mysql_query($sqla) or die ("Erro 65 - " . mysql_error());
      $nota = mysql_fetch_assoc($rsa);
      $acessos = $nota[acessos];

      $sqli = "SELECT count(s_imovel) as imoveis FROM stats WHERE s_data = '$s_data' AND s_imobiliaria = '$imob' ";
      $rsi = mysql_query($sqli) or die ("Erro 69 - " . mysql_error());
      $noti = mysql_fetch_assoc($rsi);
      $imoveis = $noti[imoveis];
?>
            <tr class="<?php echo $fundo; ?>">
               <td class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&dt=<?=$e_data?>" class="style1"><?=$m_data?></a></td>
               <td class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&dt=<?=$e_data?>" class="style1"> <?=$acessos?></a></td>
               <td class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&dt=<?=$e_data?>" class="style1"><?=$imoveis?></a></td>
            </tr>
<?
   }
?>

<? /*===========================================================================
VERSAO ATUAL
===========================================================================*/ ?>
<?

    $query3 = "select s_data FROM stats WHERE s_imobiliaria = '$imob' GROUP BY s_data";
    $result3 = mysql_query($query3) or die ("Erro 102 - ".mysql_error());
    $contador = mysql_num_rows($result3);

    $paginas = $pages = ceil($contador / 30);
    $pagina = $screen;
    $url = $PHP_SELF."?campo=".$campo."&chave=".$chave."&pesq=".$pesq."&mes=".$mes."&screen=";
?>
      <tr class="fundoTabelaTitulo">
		 <td colspan="4" class="style1" align="center"><b>Foram encontrados <?=$contador?> cadastros</b></td>
		</tr>
      <tr>
		 <td colspan="4" class="style1" align="center">
		  <table width="100%" cellpadding="0" cellspacing="0">
         <tr>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&mes=<?=$mes?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&mes=<?=$mes?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
          <td class="style1" align="center">
<?
            $i = 0;
   			$completa = "";
   			if ($paginas > 9) {
               if ($pagina < 5) {
                  $inicio = 1;
                  $final = 9;
               } elseif ($pagina > $paginas - 5) {
                  $inicio = $paginas - 9;
                  $final = $paginas;
               } else {
                  $inicio = $pagina - 4;
                  $final = $pagina + 4;
               }
            } else {
               $inicio = 1;
               $final = $paginas;
            }
            for ($j = $inicio; $j < ($final+1); $j++) {

      		   if(($paginas > 9) && (strlen($j)==1)){
                  $j = "0".$j;
               }
               $url2 = $url . $j;

               if ($j == $pagina) {
                  print "<a href=\"$url2\" class='style1'>| <b>$j</b> |</a>";
               } else {
                  print "<a href=\"$url2\" class='style1'>| $j |</a>";
               }
            }
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&mes=<?=$mes?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas && $paginas > 1) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&mes=<?=$mes?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas && $paginas > 1) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>
<? /* ==========================================================================
 FIM VERSÃO ATUAL
========================================================================== */ ?>

<?
} else {

    $registros_pag = 25;
    if ($screen == "") { $screen = 1; }
    $from = ($screen - 1) * $registros_pag;

    $m_data = data_mostra(base64_decode ($dt));

?>
         <table border="0" cellspacing="1" width="75%">
            <tr height="50">
               <td class="style1" align="center" colspan=3><b>Informação de visitas ao site, dia <?=$m_data?></b></td>
            </tr>
            <tr class="fundoTabelaTitulo">
			   <td width=25% class="style1" align="center"><b>Referência</b></td>
               <td width=50% class="style1" align="center"><b>Endereço</b></td>
               <td width=25% class="style1" align="center"><b>Visitas</b></td>
            </tr>

<?
   $sql = "SELECT s_tipo, finalidade, s_qtd, ref, titulo, tipo_logradouro, end, numero, bairro FROM stats
      LEFT JOIN muraski ON cod = s_imovel
      WHERE s_data = '" . base64_decode($dt) . "' AND s_imobiliaria = '$imob' LIMIT $from, $registros_pag";
   $rs = mysql_query($sql) or die ("Erro 115 - ".mysql_error());
   $i = 0;
   while ($not = mysql_fetch_assoc($rs)) {
      if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	  $i++;
      $mostra_titulo = strip_tags($not[titulo]);
      $endereco = $not[tipo_logradouro] . " " . $not[end] . ", " . $not[numero];
?>
            <tr class="<?php echo $fundo; ?>">
               <td class="style1" align="left"><?=$not[ref]?></td>
			   <td class="style1" align="left"><?=$endereco?></td>
               <td class="style1" align="center"><?=$not[s_qtd]?></td>
            </tr>
<?
   }
    $sql2 = "SELECT count(ref) as contador FROM stats
      LEFT JOIN muraski ON cod = s_imovel
      WHERE s_data = '" . base64_decode($dt) . "' AND s_imobiliaria = '$imob'";
    $rs2 = mysql_query($sql2) or die ("Erro 227 - " . mysql_error());
    $n2 = mysql_fetch_assoc($rs2);
    $contador = $n2[contador];
    $paginas = $pages = ceil($contador / $registros_pag);
    $pagina = $screen;
    $url = $PHP_SELF."?lista=1&dt=".$dt."&screen=";
?>
      <tr class="fundoTabelaTitulo">
		 <td colspan="4" class="style1" align="center"><b>Foram encontrados <?=$contador?> cadastros</b></td>
		</tr>
      <tr>
		 <td colspan="4" class="style1" align="center">
		  <table width="100%" cellpadding="0" cellspacing="0">
         <tr>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&dt=<?=$dt?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&dt=<?=$dt?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
          <td class="style1" align="center">
<?
            $i = 0;
   			$completa = "";
   			if ($paginas > 9) {
               if ($pagina < 5) {
                  $inicio = 1;
                  $final = 9;
               } elseif ($pagina > $paginas - 5) {
                  $inicio = $paginas - 9;
                  $final = $paginas;
               } else {
                  $inicio = $pagina - 4;
                  $final = $pagina + 4;
               }
            } else {
               $inicio = 1;
               $final = $paginas;
            }
            for ($j = $inicio; $j < ($final+1); $j++) {

      		   if(($paginas > 9) && (strlen($j)==1)){
                  $j = "0".$j;
               }
               $url2 = $url . $j;

               if ($j == $pagina) {
                  print "<a href=\"$url2\" class='style1'>| <b>$j</b> |</a>";
               } else {
                  print "<a href=\"$url2\" class='style1'>| $j |</a>";
               }
            }
?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&dt=<?=$dt?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas && $paginas > 1) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&dt=<?=$dt?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas && $paginas > 1) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>
                 </td>
             </tr>
            <tr><td colspan=3 height=30></td></tr>
         </table>

<?
}
?>
      </td>
   </tr>
</table>

<?
################################################################################
# FIM CÓDIGO REVISADO
################################################################################
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