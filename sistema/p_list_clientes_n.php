<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("CLIENT_GERAL");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
?>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<?php
$resultados_pagina = 30;
if ($screen == 0) { $screen = 1; }
if (!$from) {$from = intval(($screen - 1) * $resultados_pagina);}

#Variáveis recebidas
#$t_cod = tipo (cód do tipo)
#$p_cod = prestador (cod do prestador)
#$c_campo = nome do campo onde irá aparecer o código do cliente
#$n_campo = nome do campo onde irá aparecer o nome.
#$f_nome = nome do form onde deve retornar

if($lista == "") {
   #monta a query e procura pelo tipo novo e antigo.
   $pesq_prestador = "";
   if ($t_cod == 1) {
	   $pesq_tipo = " AND (c_tipo = 'comprador' OR c_tipo2 LIKE '%-$t_cod-%') ";
      $texto_mostra = "Compradores";
   } elseif ($t_cod == 2) {
	   $pesq_tipo = " AND (c_tipo = 'indicador' OR c_tipo2 LIKE '%-$t_cod-%') ";
      $texto_mostra = "Indicadores";
   } elseif ($t_cod == 3) {
	   $pesq_tipo = " AND (c_tipo = 'proprietario' OR c_tipo2 LIKE '%-$t_cod-%') ";
      $texto_mostra = "Proprietários";
   } elseif ($t_cod == 4) {
	   $pesq_tipo = " AND (c_tipo = 'locatario' OR c_tipo2 LIKE '%-$t_cod-%') ";
      $texto_mostra = "Locatários";
   } elseif ($t_cod == 5) {
	   $pesq_tipo = " AND (c_tipo = 'prestador' OR c_tipo2 LIKE '%-$t_cod-%') ";
      if ($p_cod == 1) {
		   $pesq_prestador = " AND (c_prestador = 'eletricista' OR c_prestador2 like '%-$p_cod-%') ";
         $texto_mostra = "Eletricistas";
      } elseif ($p_cod == 2) {
		   $pesq_prestador = " AND (c_prestador = 'encanador' OR c_prestador2 like '%-$p_cod-%') ";
         $texto_mostra = "Encanadores";
      } elseif ($p_cod == 3) {
		   $pesq_prestador = " AND (c_prestador = 'diarista' OR c_prestador2 like '%-$p_cod-%') ";
         $texto_mostra = "Diaristas";
      } elseif ($p_cod == 4) {
		   $pesq_prestador = " AND (c_prestador = 'jardineiro' OR c_prestador2 like '%-$p_cod-%') ";
         $texto_mostra = "Jardineiros";
      } elseif ($p_cod == 5) {
		   $pesq_prestador = " AND (c_prestador = 'piscineiro' OR c_prestador2 like '%-$p_cod-%') ";
         $texto_mostra = "Piscineiros";
      } else {
		   $pesq_prestador = "";
      }
   } elseif ($t_cod == 6) {
	   $pesq_tipo == " AND (c_tipo = 'testemunha' OR c_tipo2 LIKE '%-$t_cod-%') ";
      $texto_mostra = "Testemunhas";
   } elseif ($t_cod == 7) {
	   $pesq_tipo == " AND (c_tipo = 'fiador' OR c_tipo2 LIKE '%-$t_cod-%') ";
      $texto_mostra = "Fiadores";
   }


   if ($t2_cod <> "") {
      if ($t2_cod == 1) {
   	   $pesq_tipo2 = " (c_tipo = 'comprador' OR c_tipo2 LIKE '%-$t2_cod-%') ";
         $texto_mostra2 = " / Compradores";
      } elseif ($t2_cod == 2) {
   	   $pesq_tipo2 = " (c_tipo = 'indicador' OR c_tipo2 LIKE '%-$t2_cod-%') ";
         $texto_mostra2 = " / Indicadores";
      } elseif ($t2_cod == 3) {
   	   $pesq_tipo2 = " (c_tipo = 'proprietario' OR c_tipo2 LIKE '%-$t2_cod-%') ";
         $texto_mostra2 = " / Proprietários";
      } elseif ($t2_cod == 4) {
   	   $pesq_tipo2 = " (c_tipo = 'locatario' OR c_tipo2 LIKE '%-$t2_cod-%') ";
         $texto_mostra2 = " / Locatários";
      } elseif ($t2_cod == 5) {
   	   $pesq_tipo2 = " (c_tipo = 'prestador' OR c_tipo2 LIKE '%-$t2_cod-%') ";
         if ($p2_cod == 1) {
   		   $pesq_prestador2 = " (c_prestador = 'eletricista' OR c_prestador2 like '%-$p2_cod-%') ";
            $texto_mostra2 = "/ Eletricistas";
         } elseif ($p2_cod == 2) {
   		   $pesq_prestador2 = " (c_prestador = 'encanador' OR c_prestador2 like '%-$p2_cod-%') ";
            $texto_mostra2 = " / Encanadores";
         } elseif ($p2_cod == 3) {
   		   $pesq_prestador2 = " (c_prestador = 'diarista' OR c_prestador2 like '%-$p2_cod-%') ";
            $texto_mostra2 = " / Diaristas";
         } elseif ($p2_cod == 4) {
   		   $pesq_prestador2 = " (c_prestador = 'jardineiro' OR c_prestador2 like '%-$p2_cod-%') ";
            $texto_mostra2 = " / Jardineiros";
         } elseif ($p2_cod == 5) {
   		   $pesq_prestador2 = " (c_prestador = 'piscineiro' OR c_prestador2 like '%-$p2_cod-%') ";
            $texto_mostra2 = " / Piscineiros";
         } else {
   		   $pesq_prestador = "";
         }
         $pesq_prestador = "AND ($pesq_prestador2 OR (1=1 $pesq_prestador)";

      } elseif ($t2_cod == 6) {
   	   $pesq_tipo2 == " (c_tipo = 'testemunha' OR c_tipo2 LIKE '%-$t2_cod-%') ";
         $texto_mostra2 = "Testemunhas";
      } elseif ($t2_cod == 7) {
   	   $pesq_tipo2 == " (c_tipo = 'fiador' OR c_tipo2 LIKE '%-$t2_cod-%') ";
         $texto_mostra2 = " / Fiadores";
      }
      $pesq_tipo = "AND ($pesq_tipo2 OR (1=1 $pesq_tipo))";
   }



   if ($campo == "") {
      $query1 = "SELECT c_nome, c_cpf, c_tel, c_tipo2, c_prestador2, c_tipo, c_prestador, c_cod
         FROM clientes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $pesq_tipo $pesq_prestador
         LIMIT $from, $resultados_pagina";
   } else {
      $query1 = "SELECT c_nome, c_cpf, c_tel, c_tipo2, c_prestador2, c_tipo, c_prestador, c_cod
         FROM clientes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $pesq_tipo $pesq_prestador
         AND $campo like '%$chave%' LIMIT $from, $resultados_pagina";
   }
	$result1 = mysql_query($query1) or die ("Erro 92 - " . mysql_query() );
?>
<div align="center">
  <center>
<table border="0" cellpadding="1" cellspacing="1" width="95%">
   <tr height="50">
    	<td colspan=5 class="style1" align="center"><b>Relação de <?=$texto_mostra?> <?=$texto_mostra2?> </b></td>
  	</tr>
	<form method="POST" action="<?=$PHP_SELF?>">
 	   <tr class="fundoTabela" align="center" height="25px" >
      <td colspan=5 class=style1><b>Palavra Chave:</b>
      <input type="hidden" name="f_nome" value="<?=$f_nome?>" />
      <input type="hidden" name="t_cod" value="<?=$t_cod?>" />
      <input type="hidden" name="p_cod" value="<?=$p_cod?>" />
      <input type="hidden" name="c_campo" value="<?=$c_campo?>" />
      <input type="hidden" name="n_campo" value="<?=$n_campo?>" />
      <input type="text" class="campo" name="chave" size="40"> <select name="campo" class="campo">
      <option value="c_nome">Nome do cliente</option>
      <option value="c_cpf">CPF</option>
      <option value="c_rg">RG</option>
      <option value="c_end">Endereço do cliente</option>
      <option value="c_cidade">Cidade</option>
      <option value="c_email">E-mail</option>
      <option value="c_tel">Telefone</option>
      <option value="c_civil">Estado Civil</option>
      <option value="c_obs">Texto da Obs</option>
      <!--option value="c_ref">Referência do Imóvel</option-->
      </select> <input type="submit" value="Pesquisar Cliente" name="B1" class=campo3></td>
    </tr>
    <tr height="25px">
    	<td>&nbsp;</td>
    </tr>
     <tr height="20px" align="center" class="fundoTabela">
	      <td colspan=5 class=style1><div align="left"><span class="style7">Se o cliente n&atilde;o est&aacute; cadastrado <a href="p_insert_clientes.php?novo=S&url=<?=$REQUEST_URI ?>" class="style7"><b>clique aqui</b></a></span></div></td>
    </tr>
  </form>
<tr class="fundoTabelatitulo" height="20px">
<td width="40%" class="style1"><b>Nome</b></td>
<td width="15%" class="style1"><b>CPF</b></td>
<td width="15%" class="style1"><b>Telefone</b></td>
<td width="15%" class="style1"><b>Tipo</b></td>
<td width="15%" class="style1"></td>
</tr>
<?php
	$i = 0;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
?>
<tr class="<?=$fundo?>" height="20px">
<td class="style1"><p align="left">
<?php print("$not[c_nome]"); ?></td>
<td class="style1">
<p align="center">
<?php print("$not[c_cpf]"); ?></td>
<td class="style1">
<p align="center">
<?php print("$not[c_tel]"); ?></td>
<td class="style1" nowrap="nowrap">
<p align="center">
<?
if ($not[c_tipo2] == "") {
   print $not[c_tipo];
} else {
   $t_tipo = explode("--", $not[c_tipo2]);
   $t_tipo = str_replace("-","",$t_tipo);
   if (count($t_tipo) == 0) {
      print $not[c_tipo];
   } else {
      $caminho_imgs = "images/";
      foreach ($t_tipo as $tipos) {
         if ($tipos == 5) {
            $t_prestador = explode("--", $not[c_prestador2]);
            $t_prestador = str_replace("-","",$t_prestador);
            if (count($t_prestador) > 0) {
		         foreach ($t_prestador as $prestadores) {
                  $sql = "SELECT tp_tipo, tp_icone FROM tipos_prestadores WHERE tp_cod = '$prestadores'";
                  $rs = mysql_query($sql) or die ("Erro 173");
                  $n = mysql_fetch_assoc($rs);
                  if ($n[tp_icone] <> "") {
?>
               <img src="<?=$caminho_imgs.$n[tp_icone]?>" title="<?=$n[tp_tipo]?>" border=0 />
<?
                  }
		         }
            }

         } else {
            $sql = "SELECT tc_tipo, tc_icone FROM tipos_clientes WHERE tc_cod = '$tipos'";
            $rs = mysql_query($sql) or die ("Erro 173");
            $n = mysql_fetch_assoc($rs);
            if ($n[tc_icone] <> "") {
?>
               <img src="<?=$caminho_imgs.$n[tc_icone]?>" title="<?=$n[tc_tipo]?>" border=0 />
<?
            }
         }
      }
   }
}
?>
</td>
<td class="style1">
<p align="center">
<input type="button" onClick="<? if ($n_campo <> "") { ?>window.opener.document.<?=$f_nome?>.<?=$n_campo?>.value='<?=$not[c_nome]?>'; <? } if ($c_campo <> "") { ?> window.opener.document.<?=$f_nome?>.<?=$c_campo?>.value='<?=$not[c_cod]?>';<? } ?> window.opener.focus(); window.close();" class="campo3" value="Selecionar">
</p>
</td>
<!--a href="#" onClick="window.opener.document.formulario.nome_cliente.value='<?php print("$not[c_nome]"); ?>'; window.opener.document.formulario.co_cliente.value='<?php print("$not[c_cod]"); ?>'; window.opener.focus(); window.close();" class="style1">Selecionar</a></td-->
<?php
	}

   if ($campo == "") {
      $query2 = "SELECT distinct c_nome, c_cpf, c_tel, c_tipo2, c_prestador2, c_tipo, c_prestador, c_cod
         FROM clientes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $pesq_tipo $pesq_prestador";
   } else {
      $query2 = "SELECT distinct c_nome, c_cpf, c_tel, c_tipo2, c_prestador2, c_tipo, c_prestador, c_cod
         FROM clientes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $pesq_tipo $pesq_prestador
         AND $campo like '%$chave%'";
   }
	$result2 = mysql_query($query2) or die ("Erro 167");
   $contador = mysql_num_rows($result2);
	$pages = ceil($contador / $resultados_pagina);
?>
  <tr class="fundoTabelatitulo" height="20px"><td colspan=5 class="style1">
                  <p align="center"><b>
                  Foram encontrados <?=$contador?> <?=$texto_mostra?></b></p></td></tr>
                  <tr><td colspan=5 class="style1">
                  <p align="center" class="style1">
<?php
  	$url1 = "$PHP_SELF?screen=" . ($i-1) . "&f_nome=" . $f_nome . "&t_cod=" . $t_cod . "&p_cod=" . $p_cod . "&c_campo=" . $c_campo . "&n_campo=" . $n_campo . "&chave=" . $chave . "&campo=" . $campo;

	if ($screen > 1) {
	//$url1 = "vendas2.php?screen=" . ($screen - 1) . "&tipo=" . $tipo . "&finalidade=" . $finalidade;
?>
                  <a href="<?=$url1?>" class="style1"><< Página anterior <<</a>
<?php
	}
?>
<br>
<?php
	for ($i = 1; $i <= $pages; $i++) {
  	$url2 = "$PHP_SELF?screen=" . $i . "&f_nome=" . $f_nome . "&t_cod=" . $t_cod . "&p_cod=" . $p_cod . "&c_campo=" . $c_campo . "&n_campo=" . $n_campo . "&chave=" . $chave . "&campo=" . $campo;
  		if(((($screen - 9) < $i) and (($screen + 9) > $i)) or ($i == 0) or ($i == ($pages -1))){
  			if($i == $screen){
  				print "   | <a href=\"$url2\" class=style7><b>$i</b></a> |   ";
			}elseif($i == 0){
  				print "   | <a href=\"$url2\" class=style1><b>Primeira</b></a> |   ";
			}else{
  				print "   | <a href=\"$url2\" class=style1>$i</a> |   ";
  			}
  		}
	}
?>
<br>
<?php
	if ($screen >= $contador || ceil($contador / $resultados_pagina) <= 1) {
?>
<?php
	}
	else
	{
  	$url3 = "$PHP_SELF?screen=" . ($screen+1) . "&f_nome=" . $f_nome . "&t_cod=" . $t_cod . "&p_cod=" . $p_cod . "&c_campo=" . $c_campo . "&n_campo=" . $n_campo . "&chave=" . $chave . "&campo=" . $campo;
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
</table>
<?php
/*
mysql_free_result($result1);
mysql_free_result($result2);
*/
	}
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
mysql_close($con);
?>
</body>
</html>