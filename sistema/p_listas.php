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
?>
  </td>
 </tr>
</table>
<?
/*======================================================*/
/* PARTE INICIAL DO ARQUIVO NÃO ALTERAR DAQUI PARA CIMA */
/* ***** EXCETO O PADRÃO DE ACESSO...  "GERAL..." ***** */
/*======================================================*/

if (($cli == "") && ($l_cod == "")) {
?>

<table cellpadding="0" cellspacing="0" width="100%">
 <tr height="50">
 	<td align="center" class="style1"><b>Relação de listas</b></td>
 </tr> 
 <tr>
  <td align="center" class="style1">
   <p>O registro solicitado não foi encontrado.</p>
   <p><a href="javascript:history.back();" class="style1"><b>Clique aqui para retornar à pesquisa</b></a></p>
  </td>
 </tr>
</table>

<?
} else {
   if ($cli <> "") {
    $sql = "SELECT sid as l_sid, p_data, count(sid) as quantos FROM imoveis_temp WHERE interessado = '$cli' AND cod_imobiliaria = '$imob' GROUP BY sid";
    $rs = mysql_query($sql) or die ("Erro 55 - ".mysql_error());
    $conta = mysql_num_rows($rs);
    if ($conta == 0) {
?>

<table cellpadding="0" cellspacing="0" width="100%">
 <tr height="50">
 	<td align="center" class="style1"><b>Relação de listas</b></td>
 </tr> 
 <tr>
  <td align="center" class="style1">
   <p>Não foram encontradas listas com os critérios informados.</p>
   <p><a href="javascript:history.back();" class="style1"><b>Clique aqui para retornar à pesquisa</b></a></p>
  </td>
 </tr>
</table>

<?
    } else {
?>
<table border="0" cellspacing="1" width="75%" align="center">
	<tr height="50">
		<td colspan="5" align="center" class="style1"><b>Relação de listas</b><br /><span class="style4">Para visualizar, clique na lista correspondente.</span></td>
	</tr>
	<tr class="fundoTabelaTitulo">
		<td align="center" class="style1" width="50%"><b>Data</b></td>
		<td align="center" class="style1" width="50%"><b>Imóveis Marcados</b></td>
	</tr>
<?
		 $i = 0;
         while ($not = mysql_fetch_assoc($rs)) {
         	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		  	$i++;
            $p_data = $not[p_data];
            $data = substr($p_data,8,2)."/".substr($p_data,5,2)."/".substr($p_data,0,4);
            $l_sid = $not[l_sid];
?>
   <tr class="<?php echo $fundo; ?>">
      <td align="center"><a href="<?=$PHP_SELF?>?lista=1&l_cod=<?=$l_sid?>" class=style1><?=$data?></a></td>
      <td align="center"><a href="<?=$PHP_SELF?>?lista=1&l_cod=<?=$l_sid?>" class=style1><?=$not[quantos]?> Imóveis</a></td>
   </tr>

<?
         }
?>
</table>

<?
      }
   }

   if ($lista == 1 && $l_cod != "") {
?>

<table border="0" cellspacing="1" width="75%" align="center">
	<tr height="50">
		<td colspan="3" align="center" class="style1"><b>Visualização de Lista</b></td>
	</tr>
	<tr class="fundoTabelaTitulo">
		<td align="left" class="style1" width="12%"><b>Data</b></td>
		<td align="center" class="style1" width="12%"><b>Referência</b></td>
		<td align="left" class="style1" width="52%"><b>Endereço</b></td>
	</tr>
<?
    $registros_pag = 25;
    if ($screen == "") { $screen = 1; }
    $from = ($screen - 1) * $registros_pag;

      $sql = "SELECT p_data, muraski.ref as ref, tipo, finalidade, f_nome, t_nome, titulo
         , muraski.tipo_logradouro, muraski.end, muraski.numero, muraski.bairro
         FROM imoveis_temp
         LEFT JOIN muraski ON muraski.cod = imoveis_temp.cod
         LEFT JOIN finalidade ON f_cod = muraski.finalidade
         LEFT JOIN rebri_tipo ON t_cod = muraski.tipo
         WHERE sid = '$l_cod' AND imoveis_temp.cod_imobiliaria = '$imob' AND ref <> '' LIMIT $from, $registros_pag";

      $rs = mysql_query($sql) or die ("Erro 142 - " . mysql_error());
	  $i = 0;
      while ($not = mysql_fetch_assoc($rs)) {
      	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		$i++; 	
      	
         $mostra_titulo = strip_tags($not[titulo]);
         $endereco = $not[tipo_logradouro] . " " . $not[end] . ", " . $not[numero];
?>
   <tr class="<?php echo $fundo; ?>">
		<td align="left" class="style1" ><?=data_mostra($not[p_data])?></td>
		<td align="center" class="style1" ><?=$not[ref]?></td>
		<td align="left" class="style1" ><?=$endereco?></td>
   </tr>

<?
         }
?>

<?
      $sql2 = "SELECT count(*) as contador
         FROM imoveis_temp
         LEFT JOIN muraski ON muraski.cod = imoveis_temp.cod
         LEFT JOIN finalidade ON f_cod = muraski.finalidade
         LEFT JOIN rebri_tipo ON t_cod = muraski.tipo
         WHERE sid = '$l_cod' AND imoveis_temp.cod_imobiliaria = '$imob' AND ref <> ''";

    $rs2 = mysql_query($sql2) or die ("Erro 227 - " . mysql_error());
    $n2 = mysql_fetch_assoc($rs2);
    $contador = $n2[contador];
    $paginas = $pages = ceil($contador / $registros_pag);
    $pagina = $screen;
    $url = $PHP_SELF."?lista=1&data=".$data."&l_cod=".$l_cod."&screen=";
?>
      <tr class="fundoTabelaTitulo">
		 <td colspan="3" class="style1" align="center"><b>Foram encontrados <?=$contador?> cadastros</b></td>
		</tr>
      <tr>
		 <td colspan="3" class="style1" align="center">
		  <table width="100%" cellpadding="0" cellspacing="0">
         <tr>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$data?>&l_cod=<?=$l_cod?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$data?>&l_cod=<?=$l_cod?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
            <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$data?>&l_cod=<?=$l_cod?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas && $paginas > 1) { ?>| Próxima |<?}?></a></td>
            <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?lista=1&data=<?=$data?>&l_cod=<?=$l_cod?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas && $paginas > 1) { ?>| Última |<?}?></a></td>
           </tr>
          </table>
         </td>
        </tr>
        <tr><td colspan=3 height=30></td></tr>
</table>

<?
   }
}

/*======================================================
 PARTE FINAL DO ARQUIVO, NÃO ALTERAR DAQUI PARA BAIXO
====================================================/**/
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