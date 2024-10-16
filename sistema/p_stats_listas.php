<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");

include("l_funcoes.php");
verificaAcesso();
verificaArea("USER_GERAL");

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
/*======================================================*/
/* PARTE INICIAL DO ARQUIVO NÃO ALTERAR DAQUI PARA CIMA */
/* ***** EXCETO O PADRÃO DE ACESSO...  "GERAL..." ***** */
/*======================================================*/
?>

         <table border="0" cellspacing="1" width="75%" align="center">
<?php
   if ($lista == "") {
?>
            <tr>
               <td align="center" valign="top">
                  <table border="0" cellspacing="1" width="100%">
            <tr height="50">
               <td colspan=2 align="center"><b class="style1">Acessos totais aos imóveis no Site padrão da Imobiliária</b><br /><span class="style7">Clique no dia para visualizar a lista.</span>
               </td>
            </tr>
            <tr class="fundoTabelaTitulo">
               <td width="50%" class="style1" align="center"><b>Data</b></td>
               <td width="50%" class="style1" align="center"><b>Listas</b></td>
            </tr>
<?
   if ($screen == "") {
	   $screen = 1;
   }
   $from = ($screen - 1) * 30;

#      $sql = "SELECT DISTINCT l_data FROM listas ORDER BY l_data DESC LIMIT $from,30";
      $sql = "SELECT DISTINCT p_data FROM imoveis_temp WHERE cod_imobiliaria = '$imob' ORDER BY p_data DESC LIMIT $from,30";
      $rs = mysql_query($sql) or die ("Erro 52 - " . mysql_error());
      $i=0;
      while ($not = mysql_fetch_assoc($rs)) {
         $sql1 = "SELECT count(sid) as total FROM (SELECT distinct sid FROM imoveis_temp WHERE cod_imobiliaria = '$imob' AND p_data = '".$not[p_data]."') as du";
         $rs1 = mysql_query($sql1) or die ("Erro 65 - " . mysql_error());
         $not1 = mysql_fetch_assoc($rs1);
         $e_data = base64_encode($not[p_data]);
         if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		 $i++;
?>
                     <tr class="<?php echo $fundo; ?>">
                        <td align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$e_data?>" class="style1"><?=data_mostra($not[p_data])?></a></td>
                        <td align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$e_data?>" class="style1"><?=$not1[total]?></a></td>
                     </tr>

<?
      }
?>
                     <tr>
                        <td align="center" colspan="2">
                        <table width=100% border="0" cellspacing="0" cellpadding="0">

<? /*===========================================================================
                               VERSAO ATUAL
===========================================================================*/ ?>
<?

    $query3 = "SELECT DISTINCT p_data FROM imoveis_temp WHERE cod_imobiliaria = '$imob' ORDER BY p_data DESC";
    $result3 = mysql_query($query3) or die ("Erro 102 - ".mysql_error());
    $contador = mysql_num_rows($result3);

    $paginas = $pages = ceil($contador / 30);
    $pagina = $screen;
    $url = $PHP_SELF."?campo=".$campo."&chave=".$chave."&pesq=".$pesq."&screen=";
?>
      <tr class="fundoTabelaTitulo">
		 <td colspan="4" class="style1" align="center"><b>Foram encontrados <?=$contador?> cadastros</b></td>
		</tr>
      <tr>
		 <td colspan="4" class="style1" align="center">
		  <table width="100%" cellpadding="0" cellspacing="0">
         <tr>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas && $paginas > 1) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas && $paginas > 1) { ?>| Última |<?}?></a></td>
               				</tr>
<? /* ==========================================================================
 FIM VERSÃO ATUAL
========================================================================== */ ?>
   						</table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
<?
   }

   if ($lista == 1) {
?>
<tr>
 <td align="center" valign="top">
  <table border="0" cellspacing="1" width="100%">
   <tr height="50">
    <td colspan=4 align="center" class="style1"><b>Acessos totais aos imóveis no Site da <?=$_SESSION[nome_imobiliaria]?></b><br /><span class="style7">Clique no dia para visualizar a lista.</span></td>
   </tr>
   <tr class="fundoTabelaTitulo">
    <td width=25% class="style1" align="center"><b>Data</b></td>
    <td width=25% class="style1" align="center"><b>Código da Lista</b></td>
    <td width=35% class="style1" align="center"><b>Cliente</b></td>
    <td width=15% class="style1" align="center"><b>Imóveis</b></td>
   </tr>

<?
      $dt = base64_decode($data);

    $registros_pag = 25;
    if ($screen == "") { $screen = 1; }
    $from = ($screen - 1) * $registros_pag;

      $sql = "SELECT count(sid) as tst, cl_nome, sid as p_sid, p_data FROM imoveis_temp
         LEFT JOIN m_clientes ON cl_cod = interessado
         where p_data = '$dt' and cod_imobiliaria = '$imob' GROUP BY sid LIMIT $from, $registros_pag";
      $rs = mysql_query($sql) or die ("Erro 174 - " .  mysql_error());
      $i = 0;
      while ($not = mysql_fetch_assoc($rs)) {
         if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		 $i++;
         $p_sid = $not[p_sid];
         if ($not[cl_nome] == "") {
		      $cs_nome = "-";
         } else {
		      $cs_nome = $not[cl_nome];
         }
?>
   <tr class="<?php echo $fundo; ?>">
    <td align="center"><a href="p_listas.php?lista=1&l_cod=<?=$not[p_sid]?>&data=<?=$data?>" class="style1"><?=data_mostra($not[p_data])?></a></td>
    <td align="center"><a href="p_listas.php?lista=1&l_cod=<?=$not[p_sid]?>&data=<?=$data?>" class="style1"><?=$p_sid?></a></td>
    <td align="center"><a href="p_listas.php?lista=1&l_cod=<?=$not[p_sid]?>&data=<?=$data?>" class="style1"><?=$cs_nome?></a></td>
    <td align="center"><a href="p_listas.php?lista=1&l_cod=<?=$not[p_sid]?>&data=<?=$data?>" class="style1"><?=$not[tst]?></a></td>
   </tr>
<?
      }
?>
  
 </td>
</tr>
          
<?
   $sql2 = "SELECT count(sid) as tst, cl_nome, sid as p_sid, p_data FROM imoveis_temp
         LEFT JOIN m_clientes ON cl_cod = interessado
         where p_data = '$dt' and cod_imobiliaria = '$imob' GROUP BY sid";
    $rs2 = mysql_query($sql2) or die ("Erro 227 - " . mysql_error());
    $contador = mysql_num_rows($rs2);
    $paginas = $pages = ceil($contador / $registros_pag);
    $pagina = $screen;
    $url = $PHP_SELF."?lista=1&data=".$data."&screen=";
?>
      <tr class="fundoTabelaTitulo">
		 <td colspan="4" class="style1" align="center"><b>Foram encontrados <?=$contador?> cadastros</b></td>
		</tr>
      <tr>
		 <td colspan="4" class="style1" align="center"></table>
		  <table width="100%" cellpadding="0" cellspacing="0">
         <tr>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$data?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$data?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$data?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas && $paginas > 1) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$data?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas && $paginas > 1) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>
                 </td>
             </tr>
            <tr><td colspan=3 height=30></td></tr>


<?
   #############################################################################

   }

?>


         </table>

<?
/*======================================================*/
/* PARTE FINAL DO ARQUIVO, NÃO ALTERAR DAQUI PARA BAIXO */
/*======================================================*/
?>
<?  if(session_is_registered("valid_user")){ ?>
</table>
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