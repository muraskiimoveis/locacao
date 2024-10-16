<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("REL_CLIENTES");
verificaArea("CLIENT_GERAL");
?>
<html>
<head>
<?php
include("style.php");

function retira_acentos( $name )
{
   $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
      , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"
      ,"'","´","`","/","\\","~","^","¨"," ");
   $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
      , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C"
      ,"","","","","_","_","_","_","");
  	return urlencode(strtolower(str_replace( $array1, $array2, $name )));
}

//Recebe todos os tipos de prestadores e tipos em arrays.
$p_sql = "SELECT * FROM tipos_prestadores";
$p_rs = mysql_query($p_sql) or die ("Erro 30");
while ($p_not = mysql_fetch_assoc($p_rs)) {
   $pcod = $p_not['tp_cod'];
   $todos_prestadores[$pcod] = array(cod=>$p_not[tp_cod],tipo=>$p_not[tp_tipo],icone=>$p_not[tp_icone]);
}
$c_sql = "SELECT * FROM tipos_clientes";
$c_rs = mysql_query($c_sql) or die ("Erro 36");
while ($c_not = mysql_fetch_assoc($c_rs)) {
   $tcod = $c_not[tc_cod];
   $todos_clientes[$tcod]['cod'] = $c_not[tc_cod];
   $todos_clientes[$tcod]['tipo'] = $c_not[tc_tipo];
   $todos_clientes[$tcod]['icone'] = $c_not[tc_icone];
}

?>
<script language="javascript">
function confirmaExclusao(id, cliente)
{
   if(confirm("Tem certeza que deseja excluir?"))
      document.location.href='p_clientes.php?id_excluir=' + id + '&cliente=' + cliente;
}
</script>
</head>
<body>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcoes/js.js"></script>
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
	if ($screen == "") {
   		$screen = 1;
	}

	$from = ($screen - 1) * 30;

?>
<?php
if($_GET['id_excluir']) {
?>
<table width="100%">
 <tr>
  <td align="center" class="style7">
<?
	$id_excluir = $_GET['id_excluir'];
	$cliente = $_GET['cliente'];

   $continuar = "s";
   $msg = "";
   $sql1 = "SELECT * FROM contas WHERE co_cliente = '$id_excluir' AND cod_imobiliaria = '".$_SESSION['cod_imobiliaria']."'";
   $rs1 = mysql_query($sql1) or die ("Erro 65");
   $conta1 = mysql_num_rows($rs1);
   if ($conta1 > 0) {
      $continuar = "n";
      $msg .= "O cliente não pode ser excluído porque há contas em aberto";
   }

   $sql2 = "SELECT * FROM muraski WHERE ref <> 'x' AND (cliente = '$id_excluir' OR angariador = '$id_excluir' OR indicador = '$id_excluir'
      OR diarista = '$id_excluir' OR piscineiro = '$id_excluir' OR eletricista = '$id_excluir' OR encanador = '$id_excluir'
      OR jardineiro = '$id_excluir')";
   $rs2 = mysql_query($sql2) or die ("Erro 67 - " . mysql_error());
   $conta2 = mysql_num_rows($rs2);
   if ($conta2 > 0) {
      $continuar = "n";
      if ($msg <> "") {
		   $msg .= "<BR>\n";
      }
      $msg .= "O cliente não pode ser excluído porque está registrado em imóveis";
   }

   if ($continuar == 's') {
      $query = "delete from clientes where c_cod = '$id_excluir' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
      $result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
<p align="center" class="style7">Você apagou o cliente <?php print("$cliente"); ?>.</p>
<?php
   } else {
      print $msg;
   }
?>
  </td>
 </tr>
</table>
<?
}
if($B1 == "Atualizar Cadastro") {
	$c_nome = AddSlashes($c_nome);
	$c_origem = AddSlashes($c_origem);
	$c_end = AddSlashes($c_end);
	$c_bairro = AddSlashes($c_bairro);
	$c_cidade = AddSlashes($c_cidade);

	if($c_estado1 == ""){
		$c_estado = $c_estado2;
	}
	else
	{
		$c_estado = $c_estado1;
	}

	if($c_estado_com1 == ""){
		$c_estado_com = $c_estado_com2;
	}
	else
	{
		$c_estado_com = $c_estado_com1;
	}

	$c_email = AddSlashes($c_email);
	$c_obs = AddSlashes($c_obs);
	$c_conta = AddSlashes($c_conta);
	$c_prof = AddSlashes($c_prof);
	$c_nasc = "$anon-$mesn-$dian";
	$c_desde = "$anod-$mesd-$diad";

	if(($c_banco == "") and ($novo_banco != "")){

	$query0 = "select b_nome from bancos where b_nome='$novo_banco' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 == 0){

	$query1 = "insert into bancos (cod_imobiliaria, b_nome) values('".$_SESSION['cod_imobiliaria']."','$novo_banco')";
	$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.(banco contas)");

	}

	$c_banco = $novo_banco;

	}

      $c_prestador2 = "";
      if (count($tipos_prestador) > 0) {
		   foreach ($tipos_prestador as $prestador) {
            $c_prestador2 .= "-".$prestador."-";
		   }
      }
      $c_tipo2 = "";
      if (count($tipos_cliente) > 0) {
		   foreach ($tipos_cliente as $cliente) {
            $c_tipo2 .= "-".$cliente."-";
		   }
      }

   $query = "update clientes set c_tipo_pessoa='$c_tipo_pessoa', c_nome='$c_nome', c_rg='$c_rg', c_cpf='$c_cpf'
      , c_civil='$c_civil', c_origem='$c_origem', c_end='$c_end', c_bairro='$c_bairro'
      , c_cep='$c_cep', c_cidade='$c_cidade', c_estado='$c_estado', c_origem_com='$c_origem_com', c_end_com='$c_end_com', c_bairro_com='$c_bairro_com'
      , c_cep_com='$c_cep_com', c_cidade_com='$c_cidade_com', c_estado_com='$c_estado_com', c_tel='$c_tel'
      , c_cel='$c_cel', c_fax='$c_fax', c_email='$c_email', c_nasc='$c_nasc'
      , c_obs='$c_obs', c_conta='$c_conta', c_prof='$c_prof', c_repre='$c_repre', c_repre2='$c_repre2'
      , c_desde='$c_desde', c_banco='$c_banco', c_conjuge='$c_conjuge', c_rg_conjuge='$c_rg_conjuge', c_cpf_conjuge='$c_cpf_conjuge'
      , c_tel2='$c_tel2', c_cel2='$c_cel2', c_tel_com='$c_tel_com', c_fax_com='$c_fax_com', c_email_com='$c_email_com'
      , c_prestador2='$c_prestador2', c_tipo2='$c_tipo2'
      where c_cod='$c_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

   $result = mysql_query($query) or die("Não foi possível atualizar suas informações.");

/**
	// Apaga o relacionamento do cliente com os tipos de prestadores
    @mysql_query("delete from relacao_cliente_prestador where c_cod = '$c_cod'");
    // Apaga o relacionamento do cliente com os tipos de clientes
    @mysql_query("delete from relacao_cliente_tipo where c_cod = '$c_cod'");
	// Realiza a inserção dos tipos na tabela de relacionamento
	if(isset($tipos_cliente) && is_array($tipos_cliente) && !empty($tipos_cliente))
	{
		for($contador = 0; $contador < count($tipos_cliente); $contador++)
		{
			@mysql_query("insert into relacao_cliente_tipo (c_cod, tc_cod) values ('$c_cod','$tipos_cliente[$contador]')");
		}
	}
	// Realiza a inserção dos prestadores na tabela de relacionamento
	if(isset($tipos_prestador) && is_array($tipos_prestador) && !empty($tipos_prestador))
	{
		for($contador = 0; $contador < count($tipos_prestador); $contador++)
		{
			@mysql_query("insert into relacao_cliente_prestador (c_cod, tp_cod) values ('$c_cod','$tipos_prestador[$contador]')");
		}
	}
/**/
?>
<div class="style7" align="center">Você atualizou o cliente <?php print("$c_nome"); ?>.</div>
<?php
	}

if ($lista == "") {

   if ($_GET[dia] <> "" && $_GET[mes] <> "" && $_GET[ano] <> "" && $_GET[dia1] <> "" && $_GET[mes1] <> "" && $_GET[ano1] <> "" && ($_GET[campo]=="c_nasc" || $_GET[campo]=="c_desde"))  {
      $data_tipo = $campo;
   }

	if ($list == "") {
   	$query1 = "SELECT cli.c_cod, cli.c_nome, cli.c_cpf, cli.c_tel, cli.c_obs, cli.c_tipo, cli.c_tipo2, cli.c_prestador, cli.c_prestador2 FROM clientes cli WHERE cli.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY cli.c_nome LIMIT $from, 30";
	} else {
		if($data_tipo != ""){
         $query1 = "SELECT * from clientes WHERE ($data_tipo BETWEEN '$ano-$mes-$dia' AND '$ano1-$mes1-$dia1') and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY c_nome LIMIT $from, 30";
		}
		else
		{
############################################
         $c_nome = strtolower($c_nome);
         if ($campo == 'c_tipo') {

            $tsql = "SELECT * FROM tipos_clientes WHERE tc_tipo LIKE '%".$c_nome."%'";
            $trs = mysql_query($tsql) or die ("Erro 264");
            $c=0;
            $lista_tipos = "";
            while ($tn = mysql_fetch_assoc($trs)) {
               if ($c==0) {
                  $lista_tipos .= "c_tipo2 LIKE '%-$tn[tc_cod]-%' ";
               } else {
                  $lista_tipos .= "OR c_tipo2 LIKE '%-$tn[tc_cod]-%' ";
               }
               $c++;
            }
            $pesq_tipos = "AND (c_tipo like '%".$c_nome."%' OR c_tipo like '%".retira_acentos($c_nome)."%' ) OR ($lista_tipos)";
				$query1 = "SELECT c_cod, c_nome, c_cpf, c_tel, c_obs, c_tipo, c_tipo2, c_prestador, c_prestador2 FROM clientes
               WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $pesq_tipos ORDER BY c_nome limit $from, 30";
         } else {
		  		$query1 = "SELECT c_cod, c_nome, c_cpf, c_tel, c_obs, c_tipo, c_tipo2, c_prestador, c_prestador2 FROM clientes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND ".$campo." LIKE '%".$c_nome."%' ORDER BY c_nome limit $from, 30";
         }
      }
   }
	//echo $query1;
	$result1 = mysql_query($query1) or die ("Erro 282 - " . mysql_error());
?>
<div align="center">
  <center>
<table width="75%" border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
<tr height="50"><td bgcolor="#<?php print("$cor1"); ?>" colspan=7>
<p align="center" class="style1"><b>
<a href="p_insert_clientes.php" class="style1">Novo Cadastro</a></b><br />
Para alterar ou excluir um cadastro, clique sobre o nome correspondente a seguir.</b>
</td></tr>
<tr>
<td width=230 class="fundoTabelaTitulo style1"><b>
<p align="center">Nome / Razão Social</td>
<td width=200 class="fundoTabelaTitulo style1"><b>
<p align="center">CPF / CNPJ</td>
<td width=200 class="fundoTabelaTitulo style1"><b>
<p align="center">Telefone</td>
<td width=100 class="fundoTabelaTitulo style1"><b>
<p align="center">Tipos</td>
</tr>
<?php
	$i = 1;

	while($not = mysql_fetch_assoc($result1))
	{

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
?>
<tr>
<td class="<?php print("$fundo"); ?>"><p align="left">
<a href="p_clientes.php?lista=1&c_cod=<?php print("$not[c_cod]"); ?>" class="style1">
<?php print("$not[c_nome]"); ?></a>
<?
if(!empty($not[c_obs])){ ?>
<a href="javascript:;" onClick="NewWindow('observacoes_clientes.php?cod=<?php print("$not[c_cod]"); ?>', 'janela', 750, 500, 'yes');" class=style1><span class="style6">*</span></a>
<? } ?>
</td>
<td class="<?php print("$fundo"); ?>">
<p align="center">
<a href="p_clientes.php?lista=1&c_cod=<?php print("$not[c_cod]"); ?>" class="style1">
<?php print("$not[c_cpf]"); ?></a></td>
<td class="<?php print("$fundo"); ?>">
<p align="center">
<a href="p_clientes.php?lista=1&c_cod=<?php print("$not[c_cod]"); ?>" class="style1">
<?php print("$not[c_tel]"); ?></a></td>
<td class="<?php print("$fundo"); ?>" nowrap='nowrap'>
<?
if ($not[c_tipo2] == "") {
   print "<span class=\"style1\">".$not[c_tipo]."</span>";
} else {
   $t_tipo = explode("--", $not[c_tipo2]);
   $t_tipo = str_replace("-","",$t_tipo);
   if (count($t_tipo) == 0) {
      print "<span class=\"style1\">".$not[c_tipo]."</span>";
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
<?php
	}

	if($list == ""){
   		$query2 = "SELECT count(cli.c_cod) AS contador FROM clientes cli WHERE cli.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	} else {
		if($data_tipo != ""){
         $query2 = "SELECT COUNT(c_cod) AS contador FROM clientes WHERE ($data_tipo BETWEEN '$ano-$mes-$dia' AND '$ano1-$mes1-$dia1') and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		}
		else
		{
			if($campo == 'c_tipo')
         {
				$query2 = "select count(c_cod) as contador from clientes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' $pesq_tipos";
         }
	  		else
	  		{
	  			$query2 = "select count(cli.c_cod) as contador from clientes cli
               where lower(cli.$campo) like '%$c_nome%' and cli.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	  		}
		}
	}

	$result2 = mysql_query($query2);
	while ($not2 = mysql_fetch_assoc($result2)) {
    $paginas = $pages = ceil($not2[contador] / 30);
    $pagina = $screen;
    $url = "p_clientes.php?list=".$list."&c_nome=".$c_nome."&campo=".$campo."&dia=".$dia."&mes=".$mes."&ano=".$ano."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&data_tipo=".$data_tipo."&screen=";
?>
                  <tr>
				  	<td colspan="4" bgcolor="#<?php print("$cor3"); ?>" class="style1" align="center">Foram encontrados <?php print("$not2[contador]"); ?> cadastros</td>
				  </tr>
                  <tr>
				  	<td colspan="4" bgcolor="#<?php print("$cor1"); ?>" class="style1" align="center">
						<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_clientes.php?list=<?=$list ?>&c_nome=<?=$c_nome ?>&campo=<?=$campo ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&data_tipo=<?=$data_tipo ?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_clientes.php?list=<?=$list ?>&c_nome=<?=$c_nome ?>&campo=<?=$campo ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&data_tipo=<?=$data_tipo ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
                  				<td width="10%" class="style1" align="center"><a href="p_clientes.php?list=<?=$list ?>&c_nome=<?=$c_nome ?>&campo=<?=$campo ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&data_tipo=<?=$data_tipo ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_clientes.php?list=<?=$list ?>&c_nome=<?=$c_nome ?>&campo=<?=$campo ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&data_tipo=<?=$data_tipo ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>

<?php
}
	}
	else
	{

   if ($contr=="P") {
?>
<table width="100%">
 <tr>
  <td align="center" class="style7">
   <table cellpadding="0" cellspacing="1" width="75%">
    <tr>
       <td align="center" colspan="4" height="50" class="style1" ><strong>Alteração de clientes</strong><br />
          Selecione o cliente que deseja alterar</td></tr>
<?
   $t_cod = explode("--", $c_cod);
   $t_cod = str_replace("-","",$t_cod);
   if (count($t_cod) > 1) {
   $i = 0;
   foreach ($t_cod as $cli) {
      if ($i==0) {
		   $p_cod = "AND (c_cod = '$cli' ";
      } else {
		   $p_cod .= " OR c_cod = '$cli' ";
      }
      $i++;
   }
   $p_cod .= ")";
	$query3 = "select * from clientes where 1=1 $p_cod and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   $rs3 = mysql_query($query3) or die ("Erro 1587");
?>

<tr>
<td width=230 class="fundoTabelaTitulo style1"><b>
<p align="center">Nome / Razão Social</p></td>
<td width=200 class="fundoTabelaTitulo style1"><b>
<p align="center">CPF / CNPJ</p></td>
<td width=200 class="fundoTabelaTitulo style1"><b>
<p align="center">Telefone</p></td>
<td width=100 class="fundoTabelaTitulo style1"><b>
<p align="center">Tipo</p></td>
</tr>

<?
   $i = 0;
   while ($not3 = mysql_fetch_assoc($rs3)) {
      if ($i % 2 == 0) { $cor = "fundoTabelaCor1"; } else {$cor = "fundoTabelaCor2"; }
?>
      <tr class="<?=$cor?>">
       <td align="left" class="style1"><a class="style1" href="p_clientes.php?lista=1&c_cod=<?=$not3[c_cod]?>"><?=$not3[c_nome]?></a></td>
       <td align="center" class="style1"><a class="style1" href="p_clientes.php?lista=1&c_cod=<?=$not3[c_cod]?>"><?=$not3[c_cpf]?></a></td>
       <td align="center" class="style1"><a class="style1" href="p_clientes.php?lista=1&c_cod=<?=$not3[c_cod]?>"><?=$not3[c_tel]?></a></td>
       <td align="center" class="style1"><a class="style1" href="p_clientes.php?lista=1&c_cod=<?=$not3[c_cod]?>"><?=$not3[c_tipo]?>
       <?
       if ($not3[c_tipo2] <> "") {
         $t_tipo = explode("--", $not3[c_tipo2]);
         $t_tipo = str_replace("-", "", $t_tipo);
         if (count($t_tipo) > 0) {
            foreach ($t_tipo as $tipo) {
               $tsql = "SELECT tc_tipo FROM tipos_clientes WHERE tc_cod = '$tipo'";
               $trs = mysql_query($tsql) or die ("Erro 1617");
               $tnot = mysql_fetch_assoc($trs);
               echo " " . $tnot[tc_tipo];
            }
         }
       }
       ?>
       </a></td></tr>
<?
      $i++;
   }
?>



   </table>
  </td>
 </tr>
</table>
<?
   } else {
      $c_cod = $t_cod[0];
   }

   }


	// Seleção de dados do cliente
	$query2 = "select * from clientes where c_cod = '$c_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2) or die ("Erro 350");



	while($not2 = mysql_fetch_assoc($result2))
	{
     $t_prestador = explode("--", $not2[c_prestador2]);
     $t_prestador = str_replace("-", "", $t_prestador);

     $t_tipo = explode("--", $not2[c_tipo2]);
     $t_tipo = str_replace("-", "", $t_tipo);

     if ($_POST[c_cod] <> "") {
	     $t_tipo = $tipos_cliente;
     }

	  if($not2[c_tipo_pessoa]=='F'){
	  	$t_pessoa = "Física";
	  }else{
	    $t_pessoa = "Jurídica";
	  }


if(!IsSet($editar) || $_GET['extra']=='muda')
	{
?>
<script language="javascript">
function TudoIgual(field) {
  var str = field.value, primeiro='';
  for(i = 0; i < str.length; i++)
    if (str.charAt(i)>='0' && str.charAt(i)<='9')
      if (primeiro=='') primeiro = str.charAt(i);
      else if (str.charAt(i) != primeiro) return 0;
  return 1;
}
function Trim(s)
{
 if (s.length == 0)
  return s;

 if (s.length == 1 && s.value == ' ')
  return '';

 var i=0;

 while ( i < s.length && s.substring(i,i+1) == ' ') i++;

 var f = s.length - 1;

 while ( f >= 0 && s.substr(f,f+1) == ' ') f--;

 s = s.substr(i,f+1);

 return s;
}

function Guardar_CPF_CGC(field) {

  document.form1.c_cpf.value = Trim(field.value);

}

function Verifica_CPF_CGC(field) {

  var cpf='', cgc='', digito='', digitoc='', temp='', k=0; i=0, j=0, soma=0, mt=0, dg='';

  field.value = Trim(field.value);

  // Limpa os espacos da variavel
  if (field.value == ' ' || field.value == '  ' || field.value == ''){
	return false;
  }
  else {
       cpf = field.value;
  }
  if (cpf.length == 19) {
     cpf = cpf.substring(1, cpf.length)
  }
  
  for (i = 0;i < cpf.length; i++) {
	k = i + 1;
	if (isNaN(cpf.substring(i,k))== false){
          temp = temp + cpf.substring(i,k);  	
	}
  }

 if (((cpf.length > 13) && (cpf.length < 19)) && (isNaN(cpf.substring(3,4))==false)){ 
  cgc = temp.substring(0,12);
  digito = temp.substring(12,14);
  mult = '543298765432';
  for (j = 1; j <= 2; j++) {
    soma = 0;
    for (i = 0; i <= 11; i++) {
      k = i + 1;
      soma += parseInt((cgc.substring(i,k)) * (mult.substring(i,k)));
    }
    if (j == 2){
	soma = soma + (2 * digitoc);
    }
    digitoc = ((soma * 10) % 11);
    if (digitoc == 10){
	digitoc = 0;
    }
    dg +=digitoc;
    mult = '654329876543';
  }
  if (dg != digito || TudoIgual(field)) {
    alert('O CPF/CNPJ informado não é válido!');
    field.value = '';
    field.focus();
    field.style.backgroundColor = '<?=$cor_erro ?>';
    return false;
  }
  else {
    field.value=temp.substring(0,2)+'.'+temp.substring(2,5)+'.'+temp.substring(5,8)+'/'+temp.substring(8,12)+'-'+temp.substring(12,14);
    field.style.backgroundColor = '<?=$cor1 ?>';
    return true;
  }
 }
 else {
  if (cpf.length < 11) {
	alert( 'CPF inválido.');
	field.value = '';
	field.focus();
	field.style.backgroundColor = '<?=$cor_erro ?>';
	return false;
  }
  else
  {
  	field.style.backgroundColor = '<?=$cor1 ?>'; 
  }
  if (cpf.length >= 11) {
      
      cpf = temp.substring(0,9);
	digito = temp.substring(9,11);
	for (j = 1; j <= 2; j++) {
	  soma = 0;
	  mt = 2;
	  for (i = 8 + j; i >= 1; i--) {
	    soma += parseInt(cpf.charAt(i-1),10) * mt;
	    mt++;
	  }
	  dg = 11 - (soma % 11);
	  if (dg > 9) {dg = 0};
	  cpf += dg;
	}

	if (digito != cpf.substring(9,11) || TudoIgual(field)) {
	  alert('O CPF/CNPJ informado não é válido!');
	  field.value = '';
	  field.focus();
	  return false;
	  }
	else {
	  field.value=cpf.substring(0,3)+'.'+cpf.substring(3,6)+'.'+cpf.substring(6,9)+'-'+cpf.substring(9,11);
	  return true;
	}
    }
  } // fim if (cpf.length < 15)

}

function valida()
{
  var msg = "Os seguintes campos obrigatórios não foram preenchidos:\n";
  var confirma = 1;
  /* Checa se foi selecionado ao menos um checkbox do tipo de cliente */

  var tipos_checados = document.getElementsByName("tipos_cliente[]");
  var checados = 0;
  for(var i = 0; i < tipos_checados.length; i++)
  {
  	if(tipos_checados[i].checked == false)
  	{
  		checados++;
  	}
  }

  if(checados == tipos_checados.length)
  {
  	 msg += "* Tipo do cliente\n";
//retirado a pedido do fabio da rebri - 26/11/2009 // document.form1.todas.focus();
  	 document.form1.todas.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
   	document.form1.todas.style.backgroundColor = '#EDEEEE';
  }
  /* Checa se foi selecionado ao menos um checkbox do tipo de prestador */
 	if(document.getElementById('tipos_cliente_4').checked == true)
  	{
  		// Checa se ao menos um prestador foi selecionado
  		var tipos_prestador_checados = document.getElementsByName("tipos_prestador[]");
  		var quantidade_checados = 0;
  		for(var j = 0; j < tipos_prestador_checados.length; j++)
  		{
  			if(tipos_prestador_checados[j].checked == false)
  			{
  				quantidade_checados++;
  			}
  		}
  		if(quantidade_checados == tipos_prestador_checados.length)
  		{
         msg += "* Tipo de Prestador\n";
         document.form1.todos_prestadores.style.backgroundColor = '<?=$cor_erro ?>';
         confirma = 0;
  		}
  		else
  		{
   			document.form1.todos_prestadores.style.backgroundColor = '#EDEEEE';
  		}
  	}




  if (document.form1.c_tipo_pessoa.value == "F"){
  	if (document.form1.c_nome.value == "")
	{
    	msg += "* Nome\n";
      if (confirma == 1) { document.form1.c_nome.focus(); }
    	document.form1.c_nome.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_nome.style.backgroundColor = '<?=$cor1 ?>';
  	}

   if (document.form1.dian.value == "")
   {
    msg += "* Dia do Nascimento\n";
    if (confirma == 1) { document.form1.dian.focus(); }
    document.form1.dian.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.dian.style.backgroundColor = '<?=$cor1 ?>';
   }
   if (document.form1.mesn.value == "")
   {
    msg += "* Mês do Nascimento\n";
    if (confirma == 1) { document.form1.mesn.focus(); }
    document.form1.mesn.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.mesn.style.backgroundColor = '<?=$cor1 ?>';
   }
   if (document.form1.anon.value == "")
   {
    msg += "* Ano do Nascimento\n";
    if (confirma == 1) { document.form1.anon.focus(); }
    document.form1.anon.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	document.form1.anon.style.backgroundColor = '<?=$cor1 ?>';
   }
  }else if (document.form1.c_tipo_pessoa.value == "J"){
	if (document.form1.c_nome.value == "")
	{
      msg += "* Razão Social\n";
      if (confirma == 1) { document.form1.c_nome.focus(); }
    	document.form1.c_nome.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_nome.style.backgroundColor = '<?=$cor1 ?>';
  	}
   if (document.form1.diad.value == "")
   {
    msg += "* Dia do Nascimento\n";
    if (confirma == 1) { document.form1.diad.focus(); }
    document.form1.diad.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.diad.style.backgroundColor = '<?=$cor1 ?>';
   }
   if (document.form1.mesd.value == "")
   {
    msg += "* Mês do Nascimento\n";
    if (confirma == 1) { document.form1.mesd.focus(); }
    document.form1.mesd.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.mesd.style.backgroundColor = '<?=$cor1 ?>';
   }
   if (document.form1.anod.value == "")
   {
    msg += "* Ano do Nascimento\n";
    if (confirma == 1) { document.form1.anod.focus(); }
    document.form1.anod.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
  	 document.form1.anod.style.backgroundColor = '<?=$cor1 ?>';
   }
  }
  if (document.form1.c_tipo_pessoa.value == "F"){
  	if (document.form1.c_origem.value == "")
  	{
    	msg += "* Nacionalidade\n";
      if (confirma == 1) { document.form1.c_origem.focus(); }
    	document.form1.c_origem.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_origem.style.backgroundColor = '<?=$cor1 ?>';
  	}

/**
  	if (document.form1.c_rg.value == "")
  	{
    	msg += "* RG\n";
      if (confirma == 1) { document.form1.c_rg.focus(); }
    	document.form1.c_rg.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_rg.style.backgroundColor = '<?=$cor1 ?>';
  	}
   if (document.form1.c_civil.selectedIndex == 0)
   {
    msg += "* Estado Civil\n";
    if (confirma == 1) { document.form1.c_civil.focus(); }
    document.form1.c_civil.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
   }
   else
   {
   	document.form1.c_civil.style.backgroundColor = '<?=$cor1 ?>';
   }
/**/

  } else if (document.form1.c_tipo_pessoa.value == "J") {
/**
    if (document.form1.c_rg.value == "")
    {
      msg += "* Inscrição Estadual\n";
      if (confirma == 1) { document.form1.c_rg.focus(); }
    	document.form1.c_rg.style.backgroundColor = '<?=$cor_erro ?>';
      confirma = 0;
  	}
  	else
  	{
   		document.form1.c_rg.style.backgroundColor = '<?=$cor1 ?>';
  	}
/**/
  }
/**
  if (document.form1.c_end.value == "")
  {
    msg += "* Endereço\n";
    if (confirma == 1) { document.form1.c_end.focus(); }
    document.form1.c_end.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_end.style.backgroundColor = '<?=$cor1 ?>';
  }
  if (document.form1.c_cep.value == "")
  {
    msg += "* CEP\n";
    if (confirma == 1) { document.form1.c_cep.focus(); }
    document.form1.c_cep.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_cep.style.backgroundColor = '<?=$cor1 ?>';
  }
/**/
  if (document.form1.c_cidade.value == "")
  {
    msg += "* Cidade\n";
    if (confirma == 1) { document.form1.c_cidade.focus(); }
    document.form1.c_cidade.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_cidade.style.backgroundColor = '<?=$cor1 ?>';
  }
  if (document.form1.c_estado1.value == "" && document.form1.c_estado2.value=="")
  {
    msg += "* Estado\n";
    if (confirma == 1) { document.form1.c_cidade.focus(); }
    document.form1.c_estado1.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_estado1.style.backgroundColor = '<?=$cor1 ?>';
  }
/**
  if (document.form1.c_tel.value == "")
  {
    msg += "* Telefone\n";
    if (confirma == 1) { document.form1.c_tel.focus(); }
    document.form1.c_tel.style.backgroundColor = '<?=$cor_erro ?>';
    confirma = 0;
  }
  else
  {
  	document.form1.c_tel.style.backgroundColor = '<?=$cor1 ?>';
  }
/**/

   if (confirma == 0) {
      alert (msg);
     	return false;
   } else {
	   return true;
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
function selecionar_todas(retorno, nome_checar)
{
	var elementos_input = document.getElementsByName(nome_checar);
	if(retorno==true)
	{
  		for(var i = 0; i < elementos_input.length; i++)
  		{
  			if(elementos_input[i].checked == false)
  			{
  				elementos_input[i].checked = true;
  			}
  		}
	}
	else
	{
		for(var i = 0; i < elementos_input.length; i++)
  		{
  			if(elementos_input[i].checked == true)
  			{
  				elementos_input[i].checked = false;
  			}
  		}
	}
}
</script>
<p align="center" class=style1><b>Editar ou Apagar Cadastros</b></p>
<?php
/**
if($_GET['contr']=='P'){
	$query3 = "select cod, ref, tipo, metragem, valor, finalidade from muraski where cliente like '%$c_cod%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by ref";
}else{
  	$query3 = "select cod, ref, tipo, metragem, valor, finalidade from muraski where cliente like '%-$c_cod-%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by ref";
}
/**/

	$query3 = "select cod, ref, tipo, metragem, valor, finalidade from muraski where cliente like '%-$c_cod-%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by ref";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	if($numrows3 > 0){
?>
<div align="center">
  <center>
                  <table width="75%" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
                  <tr><td colspan="7" class="fundoTabela style1">
                  <p align="right"><b>
                  Imóveis de <?php print("$not2[c_nome]"); ?></b></td></tr>
                  <tr class="fundoTabelaTitulo"><td class=style1>
                  <b>Ref.</b></td><td class=style1>
                  <b>Valor</b></td><td class=style1>
                  <b>Finalidade</b></td><td class=style1>
                  <b>Contrato</b></td>
                  <td class=style1>
                  <b>Renovação</b></td><td class=style1>
                  <b>Relatório</b></td>
                  <td class=style1>
                  <b>Extrato</b></td></tr>
<?php
	$i = 1;

	while($not3 = mysql_fetch_assoc($result3))
	{

	$valor = number_format($not3[valor], 2, ',', '.');

	if (($i % 2) == 1){ $fundo="fundoTabelaCor1"; }else{ $fundo="fundoTabelaCor2"; }
	$i++;

	$imovel = substr ($not3[ref], 0, 4);
	$imovel1 = "ref1" . $imovel;
	$imovel2 = "ref2" . $imovel;

if($not3[finalidade]=='1'){
  $fin = "Venda_Rebri";
}elseif($not3[finalidade]=='2'){
  $fin = "Venda_".$_SESSION['nome_imobiliaria'];
}elseif($not3[finalidade]=='3'){
  $fin = "Venda_Parceria";
}elseif($not3[finalidade]=='4'){
  $fin = "Venda_Terceiros";
}elseif($not3[finalidade]=='5'){
  $fin = "Venda_Off";
}elseif($not3[finalidade]=='6'){
  $fin = "Venda_Vendido";
}elseif($not3[finalidade]=='7'){
  $fin = "Venda_Todos";
}elseif($not3[finalidade]=='8'){
  $fin = "Locação_Anual_Rebri";
}elseif($not3[finalidade]=='9'){
  $fin = "Locação_Anual_".$_SESSION['nome_imobiliaria'];
}elseif($not3[finalidade]=='10'){
  $fin = "Locação_Anual_Parceria";
}elseif($not3[finalidade]=='11'){
  $fin = "Locação_Anual_Terceiros";
}elseif($not3[finalidade]=='12'){
  $fin = "Locação_Anual_Off";
}elseif($not3[finalidade]=='13'){
  $fin = "Locação_Anual_Locado";
}elseif($not3[finalidade]=='14'){
  $fin = "Locação_Anual_Todos";
}elseif($not3[finalidade]=='15'){
  $fin = "Locação_Temporada_".$_SESSION['nome_imobiliaria'];
}elseif($not3[finalidade]=='16'){
  $fin = "Locação_Temporada_Off";
}elseif($not3[finalidade]=='17'){
  $fin = "Locação_Temporada_Todos";
}
?>
<tr class="<?php print("$fundo"); ?>"><td class=style1>
<a href="p_edit_imoveis.php?cod=<?php print("$not3[cod]"); ?>&edit=editar" class="style1"><?php print("$not3[ref]"); ?></a></td><td class=style1>
<?php print("$valor"); ?></td><td class=style1>
<?php print($fin); ?></td>
<?php
	if($not3[finalidade]=='8' || $not3[finalidade]=='9' || $not3[finalidade]=='10' || $not3[finalidade]=='11' || $not3[finalidade]=='12' || $not3[finalidade]=='13' || $not3[finalidade]=='14' || $not3[finalidade]=='15' || $not3[finalidade]=='16' || $not3[finalidade]=='17'){
?>
<script language="JavaScript"> 
function <?php print("$imovel1"); ?>()
{
	NewWindow('p_imp_doc.php?cod=<?php print("$not3[cod]"); ?>&imp=2', 'janela', 750, 500, 'yes');
}
</script>
<td class=style1>
<a href="javascript:<?php print("$imovel1"); ?>();" class="style1">Imprimir Contrato</a></td>
<?php
	}
	else
	{
?>
<script language="JavaScript"> 
function <?php print("$imovel1"); ?>()
{
	NewWindow('p_imp_doc.php?cod=<?php print("$not3[cod]"); ?>&imp=5', 'janela', 750, 500, 'yes');
}
</script>
<td class=style1>
<a href="javascript:<?php print("$imovel1"); ?>();" class="style1">Imprimir Opção</a></td>
<?php
	}
?>
<?php
	if($not3[finalidade]=='8' || $not3[finalidade]=='9' || $not3[finalidade]=='10' || $not3[finalidade]=='11' || $not3[finalidade]=='12' || $not3[finalidade]=='13' || $not3[finalidade]=='14' || $not3[finalidade]=='15' || $not3[finalidade]=='16' || $not3[finalidade]=='17'){
?>
<td>
</td>
<?php
	}
	else
	{
?>
<script language="JavaScript"> 
function <?php print("$imovel2"); ?>()
{
	NewWindow('p_imp_doc.php?cod=<?php print("$not3[cod]"); ?>&c_cod=<?=$c_cod ?>&imp=4', 'janela', 750, 500, 'yes');
}
</script>
<td class=style1>
<a href="javascript:<?php print("$imovel2"); ?>();" class="style1">Imprimir Renovação</a></td>
<?php
	}
?>
<td class=style1>
<?php
    if($not3[finalidade]=='15' || $not3[finalidade]=='16' || $not3[finalidade]=='17'){  
?>
<a href="p_rel_loc.php?cod=<?php print("$not3[cod]"); ?>" class="style1">
<?php
	}
	elseif($not3[finalidade]=='8' || $not3[finalidade]=='9' || $not3[finalidade]=='10' || $not3[finalidade]=='11' || $not3[finalidade]=='12' || $not3[finalidade]=='13' || $not3[finalidade]=='14')
	{
?>	  
<a href="p_rel_loc_mes.php?cod=<?php print("$not3[cod]"); ?>" class="style1">	  
<?
	}
	else
	{
?>
<a href="p_rel_int.php?cod=<?php print("$not3[cod]"); ?>" class="style1">
<?php
	}
?>
Ver relatório</a></td>
<td class="style1">
<?php
    if($not3[finalidade]=='8' || $not3[finalidade]=='9' || $not3[finalidade]=='10' || $not3[finalidade]=='11' || $not3[finalidade]=='12' || $not3[finalidade]=='13' || $not3[finalidade]=='14' || $not3[finalidade]=='15' || $not3[finalidade]=='16' || $not3[finalidade]=='17'){  
?>
<a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='p_extrato_locacao.php?cod_imovel=<?php print("$not3[cod]"); ?>';form1.submit();" class="style1">
Ver extrato</a>
<?php
	}
?></td>
</tr>
<?php
	}
	
	
if($_GET['contr']=='P'){	

	$query4 = "select count(cod) as contador from muraski where cliente like '%-$c_cod-%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";

}else{

  	$query4 = "select count(cod) as contador from muraski where cliente like '%-$c_cod-%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
}
	$result4 = mysql_query($query4);
	$registros = mysql_num_rows($result4);
	while($not4 = mysql_fetch_assoc($result4))
	{
?>
                  <tr><td colspan="7" class="fundoTabelaTitulo style1">
                  <p align="center" class="style1">
                  <b>Foram encontrados <?php print($not4[contador]); ?> cadastro(s)</b></td></tr>
                  </table></div></center>
<?php
	}
	}
?>
 <div align="center">
  <center>
  <table border="0" cellspacing="1" width="75%">
  <form method="post" action="<?php print("$PHP_SELF"); ?>" name="form1" onSubmit="return valida();">
  <input type="hidden" value="<?php print("$not2[c_cod]"); ?>" name="c_cod">
<?php

   #Verifica se é proprietário ou locatário
	if($not2[c_tipo] == 'locatario' || strstr($not2[c_tipo2], "-4-"))
	{
?>
    <tr class="fundoTabelaDestaque">
      <td width="100%" colspan="2" class="style1" height="25px">
      <a href="p_rel_locatario.php?c_cod=<?php print("$not2[c_cod]"); ?>" class="style1">
      <b>Clique aqui</b></a> para visualizar os imóveis alugados por este cliente.</td>
    </tr>
<?php
	}
?>
<?php
	if($not2[c_tipo] == 'proprietario' || strstr($not2[c_tipo2], "-3-"))
	{
?>
    <tr class="fundoTabelaDestaque" height="25px">
      <td colspan="6" class="style1" align="left">
      <a href="p_insert_imoveis.php?c_nome=<?php print("$not2[c_nome]"); ?>&c_cod=<?php print("$not2[c_cod]"); ?>" class="style1">
      <b>Clique aqui</b></a> para cadastrar um novo imóvel deste proprietário.</td>
    </tr>
<?php
	}
?>

<?php
	//if($colunaDadosTipo[tc_cod] == 4){
	if($not2[c_tipo] == 'locatario' || strstr($not2[c_tipo2], "-4-")){
?>
    <tr class="fundoTabela" height="25px">
      <td class=style1><b>Ficha inquilinos:</b></td>
      <td class="fundoTabelaDestaque style1"><a href="ficha_inquilinos.php?c_cod=<?php print("$not2[c_cod]"); ?>&c_nome=<?php print("$not2[c_nome]"); ?>" class="style1"><b>Clique aqui</b></a> para cadastrar uma ficha de inquilino.</td>
    </tr>
<?
   }
?>
    <tr class="fundoTabela">
      <td class=style1><b>Tipo de Pessoa:</b></td>
      <td class=style1><select name="c_tipo_pessoa" class="campo" onChange="form1.action='p_clientes.php?lista=1&c_cod=<?php echo($not2[c_cod]); ?>&extra=muda';form1.submit();">
        <!--option value="<?php print($not2[c_tipo_pessoa]); ?>"><?php print($t_pessoa); ?></option-->
        <option value="F" <? if($_POST['c_tipo_pessoa']=='F'){ echo "SELECTED"; }elseif($not2[c_tipo_pessoa]=='F'){ echo "SELECTED"; } ?>>Física</option>
        <option value="J" <? if($_POST['c_tipo_pessoa']=='J'){ echo "SELECTED"; }elseif($not2[c_tipo_pessoa]=='J'){ echo "SELECTED"; } ?>>Jurídica</option>
      </select></td>
    </tr>
    <tr>
      <td width="30%" class="style1 fundoTabela"><b>Tipo:*</b></td>
      <td width="70%" class="style1 fundoTabela">
      <input name="todas" <?php if($todas == 'checkbox'){?> checked="ckecked"<?php } ?> type="checkbox" id="todas" value="checkbox" onClick="selecionar_todas(this.checked, 'tipos_cliente[]');form1.action='p_clientes.php?lista=1&c_cod=<?php echo($not2[c_cod]); ?>&extra=muda';form1.submit();"><label class="style1" for="todas" id="checar"><?php if($todas == 'checkbox'){?>Desmarcar todos <?php }else{ ?>Marcar todos<?php } ?></label>
      <table cellspacing="0" cellpadding="0" with="100%">
      <?php
      // Seleciona os tipos de clientes cadastrados no banco de dados e exibe um checkbox para cada tipo
      $sqlTipos = "select tc_cod, tc_tipo from tipos_clientes";
      $buscaTipos = mysql_query($sqlTipos);
      $cont = 0;
      $i = 0;
      while($colunaTipos = mysql_fetch_assoc($buscaTipos))
      {
      	if ($cont == 8)
	      {
			   $cont = 0;
			   print "<tr>";
		   }
		?>
			<td height="25px">
				<input type="checkbox"<?php
               if (count($t_tipo) > 0) {
               	if(in_array($colunaTipos['tc_cod'], $t_tipo) || strtolower($not2[c_tipo]) == strtolower(retira_acentos($colunaTipos['tc_tipo'])))
					 	{
					 		?> checked="checked"<?php
					 	}
               }
 ?> name="tipos_cliente[]" id="tipos_cliente_<?php echo $i; ?>" value="<?php echo $colunaTipos['tc_cod']; ?>"<?php if($colunaTipos['tc_cod'] == 5){?> onclick="form1.action='p_clientes.php?lista=1&c_cod=<?php echo($not2[c_cod]); ?>&extra=muda';form1.submit();"<?php } ?>>&nbsp;<label for="tipos_cliente_<?php echo $i; ?>" class="style1" style="margin-right:10px;"><?php echo $colunaTipos['tc_tipo']; ?></label>
			</td>
		<?php
      	if ($cont == 8)
		{
			$cont = 0;
			print "</tr><tr>";
		}
		$i++;
	  	$cont++;
	  	}
      ?>
        </table>
        </td>
    </tr>

<?php
// Mostra os prestadores somente para clientes do tipo prestador
if (count($t_tipo) > 0) {

if(in_array("5",$t_tipo,true))
{
?>
<tr>
    <td class="style1 fundoTabela"><b>Tipo de prestador:</b></td>
    <td class="style1 fundoTabela">
    <input name="todos_prestadores" <?php if($todos_prestadores == 'checkbox'){?> checked="ckecked"<?php } ?> type="checkbox" id="todos_prestadores" value="checkbox" onClick="selecionar_todas(this.checked, 'tipos_prestador[]');"><label class="style1" for="todos_prestadores" id="checar"><?php if($todos_prestadores == 'checkbox'){?>Deixar marcados somente os tipos pertencentes ao cliente<?php }else{ ?>Marcar todos<?php } ?> </label>
    <table cellspacing="0" cellpadding="0" with="100%">
<?php
	  // Seleciona os tipos de prestadores cadastrados no banco de dados e exibe um checkbox para cada tipo
      $sqlTiposPrestadores = "select tp_cod, tp_tipo from tipos_prestadores";
      $buscaTiposPrestadores = mysql_query($sqlTiposPrestadores);
      $contP = 0;
      $j = 0;
      while($colunaTiposPrestadores = mysql_fetch_assoc($buscaTiposPrestadores))
      {
      	if ($contP == 8)
	    {
			$contP = 0;
			print "<tr>";
		}
		?>
			<td height="25px">
				<input type="checkbox"<?php
               if (count($t_prestador) > 0) {
					 	if(in_array($colunaTiposPrestadores['tp_cod'], $t_prestador))
					 	{
					 		?> checked="checked"<?php
					 	}
               }
				 ?> name="tipos_prestador[]" id="tipos_prestador_<?php echo $j; ?>" value="<?php echo $colunaTiposPrestadores['tp_cod']; ?>">&nbsp;<label for="tipos_prestador_<?php echo $j; ?>" class="style1" style="margin-right:10px;"><?php echo $colunaTiposPrestadores['tp_tipo']; ?></label>
			</td>
		<?php
      	if ($contP == 8)
		{
			$contP = 0;
			print "</tr><tr>";
		}
		$j++;
	  	$contP++;
	  	}
      ?>
        </table>
        </td>
    </tr>
<? } ?>
<? } ?>


<?
if($_POST['c_tipo_pessoa']){
   if($_POST['c_tipo_pessoa']=='F'){ 
?>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_nome" class="campo" size="40" value="<?php print("$c_nome"); ?>"></td>
    </tr>
<? }elseif($_POST['c_tipo_pessoa']=='J'){ ?>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>Razão Social:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_nome" size="40" value="<?php print("$c_nome"); ?>" class="campo"></td>
    </tr>	
<? 
   } 
}else{
   
   if($not2['c_tipo_pessoa']=='F'){ 
?>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_nome" class="campo" size="40" value="<?php print("$not2[c_nome]"); ?>"></td>
    </tr>
<? }elseif($not2['c_tipo_pessoa']=='J'){ ?>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>Razão Social:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_nome" class="campo" size="40" value="<?php print("$not2[c_nome]"); ?>"></td>
    </tr>	
<?
   }
}   
if($_POST['c_tipo_pessoa']){
   if($_POST['c_tipo_pessoa']=='F'){ 
?>   
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>CPF:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" size="18" name="c_cpf" class="campo" value="<?php print("$c_cpf"); ?>" onBlur="javascript:Verifica_CPF_CGC(this);" maxlenght="18" onKeyUp="return autoTab(this, 18, event);"></td>
    </tr>
<? }elseif($_POST['c_tipo_pessoa']=='J'){ ?>
	    <tr class="fundoTabela">
      <td width="30%" class=style1><b>CNPJ:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" size="18" name="c_cpf" class="campo" value="<?php print("$c_cpf"); ?>" onBlur="javascript:Verifica_CPF_CGC(this);" maxlenght="18" onKeyUp="return autoTab(this, 18, event);"></td>
    </tr>
<? 
   } 
}else{
   if($not2['c_tipo_pessoa']=='F'){
?>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>CPF:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" maxlenght="18" class="campo" onKeyUp="return autoTab(this, 18, event);" onBlur="javascript:Verifica_CPF_CGC(this);" name="c_cpf" size="18" value="<?php print("$not2[c_cpf]"); ?>"></td>
    </tr>
<? }elseif($not2['c_tipo_pessoa']=='J'){ ?>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>CNPJ:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" maxlenght="18" class="campo" onKeyUp="return autoTab(this, 18, event);" onBlur="javascript:Verifica_CPF_CGC(this);" name="c_cpf" size="18" value="<?php print("$not2[c_cpf]"); ?>"></td>
    </tr>
<? 
   } 
}
if($_POST['c_tipo_pessoa']){
   if($_POST['c_tipo_pessoa']=='F'){ 
?>   
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>RG:</b> </td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_rg" size="20" class="campo" value="<?php print("$c_rg"); ?>"></td>
    </tr>
<? }elseif($_POST['c_tipo_pessoa']=='J'){ ?>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>Inscrição Estadual:</b> </td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_rg" size="20" class="campo" value="<?php print("$c_rg"); ?>"></td>
    </tr>
<? 
   }
}else{   
   if($not2['c_tipo_pessoa']=='F'){ 
?>
   <tr class="fundoTabela">
      <td width="30%" class=style1><b>RG:</b> </td>
      <td width="70%" colspan="5" class=style1> <input type="text" class="campo" name="c_rg" size="20" value="<?php print("$not2[c_rg]"); ?>"></td>
    </tr>
<? }elseif($not2['c_tipo_pessoa']=='J'){ ?>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>Inscrição Estadual:</b> </td>
      <td width="70%" colspan="5" class=style1> <input type="text" class="campo" name="c_rg" size="20" value="<?php print("$not2[c_rg]"); ?>"></td>
    </tr>
<?
   }
}   
	$anon = substr ($not2[c_nasc], 0, 4);
	$mesn = substr($not2[c_nasc], 5, 2 );
	$dian = substr ($not2[c_nasc], 8, 2 );
   
if($not2['c_tipo_pessoa']=='F' || $_POST['c_tipo_pessoa']=='F'){
?>
  <tr class="fundoTabela">
    <td width="30%"><b class=style1>Nascimento:</b></td>
    <td width="70%" colspan="5" class="style1">
      <input type="text" name="dian" size="2" maxlenght="2" class="campo" onKeyUp="return autoTab(this, 2, event);" value="<?php if($POST['dian']){ print($_POST['dian']); }else{ print("$dian"); } ?>">
      / <input type="text" class="campo" name="mesn" size="2" value="<?php if($POST['mesn']){ print($_POST['mesn']); }else{ print("$mesn"); } ?>" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">
      / <input type="text" name="anon" size="4" maxlenght="4" class="campo" onKeyUp="return autoTab(this, 4, event);" value="<?php if($POST['anon']){ print($_POST['anon']); }else{ print("$anon"); } ?>"> Ex.: 10/10/1950</td>
  </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Estado civil:</b></td>
      <td width="70%" colspan="5" class="style1"> <select name="c_civil" class="campo">
    		<option value="">Selecione</option>
    		<option value="Solteiro(a)" <? if($_POST['c_civil']=='Solteiro(a)'){ echo "SELECTED"; }elseif($not2[c_civil]=='Solteiro(a)'){ echo "SELECTED"; } ?>>Solteiro(a)</option>
    		<option value="Casado(a)" <? if($_POST['c_civil']=='Casado(a)'){ echo "SELECTED"; }elseif($not2[c_civil]=='Casado(a)'){ echo "SELECTED"; } ?>>Casado(a)</option>
    		<option value="Viúvo(a)" <? if($_POST['c_civil']=='Viúvo(a)'){ echo "SELECTED"; }elseif($not2[c_civil]=='Viúvo(a)'){ echo "SELECTED"; } ?>>Viúvo(a)</option>
    		<option value="Separado(a)" <? if($_POST['c_civil']=='Separado(a)'){ echo "SELECTED"; }elseif($not2[c_civil]=='Separado(a)'){ echo "SELECTED"; } ?>>Separado(a)</option>
    		<option value="Divorciado(a)" <? if($_POST['c_civil']=='Divorciado(a)'){ echo "SELECTED"; }elseif($not2[c_civil]=='Divorciado(a)'){ echo "SELECTED"; } ?>>Divorciado(a)</option>
    		<option value="União Estável" <? if($_POST['c_civil']=='União Estável'){ echo "SELECTED"; }elseif($not2[c_civil]=='União Estável'){ echo "SELECTED"; } ?>>União Estável</option>
        </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Nacionalidade:</b></td>
      <td width="70%" colspan="5" class="style1"> <input type="text" class="campo" name="c_origem" size="30" value="<?php if($_POST['c_origem']){ print("$c_origem"); }elseif($not2[c_origem]){ print("$not2[c_origem]"); } ?>"></td>
    </tr>
<? 
if($_POST['c_civil']){
   if($_POST['c_civil']=='Casado(a)'){ 
?>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome do Cônjuge:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_conjuge" size="40" value="<?php print("$c_conjuge"); ?>" class="campo"></td>
    </tr>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>RG do Cônjuge:</b> </td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_rg_conjuge" size="20" class="campo" value="<?php print("$c_rg_conjuge"); ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>CPF do Cônjuge:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" size="18" name="c_cpf_conjuge" class="campo" value="<?php print("$c_cpf_conjuge"); ?>" onBlur="javascript:Verifica_CPF_CGC(this);" maxlenght="18" onKeyUp="return autoTab(this, 18, event);"></td>
    </tr>
<?
	} 
}else{
  
   if($not2['c_civil']=='Casado(a)'){ 
?>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Nome do Cônjuge:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_conjuge" size="40" value="<?php print("$not2[c_conjuge]"); ?>" class="campo"></td>
    </tr>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>RG do Cônjuge:</b> </td>
      <td width="70%" colspan="5" class=style1> <input type="text" name="c_rg_conjuge" size="20" class="campo" value="<?php print("$not2[c_rg_conjuge]"); ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>CPF do Cônjuge:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" size="18" name="c_cpf_conjuge" class="campo" value="<?php print("$not2[c_cpf_conjuge]"); ?>" onBlur="javascript:Verifica_CPF_CGC(this);" maxlenght="18" onKeyUp="return autoTab(this, 18, event);"></td>
    </tr>
<?
	}   
  }
} 
?>    
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Endereço:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" class="campo" name="c_end" size="40" value="<?php if($_POST['c_end']){ print("$c_end"); }elseif($not2[c_end]){ print("$not2[c_end]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Bairro:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" class="campo" name="c_bairro" size="30" value="<?php if($_POST['c_bairro']){ print("$c_bairro"); }elseif($not2[c_bairro]){ print("$not2[c_bairro]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>CEP:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_cep" class="campo" size="8" maxlenght="8" onKeyUp="return autoTab(this, 8, event);" value="<?php if($_POST['c_cep']){ print("$c_cep"); }elseif($not2[c_cep]){ print("$not2[c_cep]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Cidade:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_cidade" class="campo" size="40" value="<?php if($_POST['c_cidade']){ print("$c_cidade"); }elseif($not2[c_cidade]){ print("$not2[c_cidade]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Estado:</b></td>
      <td width="70%" colspan="5" class=style1><select name="c_estado1" class="campo">
                      <option value="">Selecione</option>
                      <option value="AC" <? if($_POST['c_estado1']=='AC'){ echo "SELECTED"; }elseif($not2[c_estado]=='AC'){ echo "SELECTED"; } ?>>AC</option>
                      <option value="AL" <? if($_POST['c_estado1']=='AL'){ echo "SELECTED"; }elseif($not2[c_estado]=='AL'){ echo "SELECTED"; } ?>>AL</option>
                      <option value="AM" <? if($_POST['c_estado1']=='AM'){ echo "SELECTED"; }elseif($not2[c_estado]=='AM'){ echo "SELECTED"; } ?>>AM</option>
                      <option value="AP" <? if($_POST['c_estado1']=='AP'){ echo "SELECTED"; }elseif($not2[c_estado]=='AP'){ echo "SELECTED"; } ?>>AP</option>
                      <option value="BA" <? if($_POST['c_estado1']=='BA'){ echo "SELECTED"; }elseif($not2[c_estado]=='BA'){ echo "SELECTED"; } ?>>BA</option>
                      <option value="CE" <? if($_POST['c_estado1']=='CE'){ echo "SELECTED"; }elseif($not2[c_estado]=='CE'){ echo "SELECTED"; } ?>>CE</option>
                      <option value="ES" <? if($_POST['c_estado1']=='ES'){ echo "SELECTED"; }elseif($not2[c_estado]=='ES'){ echo "SELECTED"; } ?>>ES</option>
                      <option value="DF" <? if($_POST['c_estado1']=='DF'){ echo "SELECTED"; }elseif($not2[c_estado]=='DF'){ echo "SELECTED"; } ?>>DF</option>
                      <option value="GO" <? if($_POST['c_estado1']=='GO'){ echo "SELECTED"; }elseif($not2[c_estado]=='GO'){ echo "SELECTED"; } ?>>GO</option>
                      <option value="MA" <? if($_POST['c_estado1']=='MA'){ echo "SELECTED"; }elseif($not2[c_estado]=='MA'){ echo "SELECTED"; } ?>>MA</option>
                      <option value="MG" <? if($_POST['c_estado1']=='MG'){ echo "SELECTED"; }elseif($not2[c_estado]=='MG'){ echo "SELECTED"; } ?>>MG</option>
                      <option value="MS" <? if($_POST['c_estado1']=='MS'){ echo "SELECTED"; }elseif($not2[c_estado]=='MS'){ echo "SELECTED"; } ?>>MS</option>
                      <option value="MT" <? if($_POST['c_estado1']=='MT'){ echo "SELECTED"; }elseif($not2[c_estado]=='MT'){ echo "SELECTED"; } ?>>MT</option>
                      <option value="PA" <? if($_POST['c_estado1']=='PA'){ echo "SELECTED"; }elseif($not2[c_estado]=='PA'){ echo "SELECTED"; } ?>>PA</option>
                      <option value="PB" <? if($_POST['c_estado1']=='PB'){ echo "SELECTED"; }elseif($not2[c_estado]=='PB'){ echo "SELECTED"; } ?>>PB</option>
                      <option value="PE" <? if($_POST['c_estado1']=='PE'){ echo "SELECTED"; }elseif($not2[c_estado]=='PE'){ echo "SELECTED"; } ?>>PE</option>
                      <option value="PI" <? if($_POST['c_estado1']=='PI'){ echo "SELECTED"; }elseif($not2[c_estado]=='PI'){ echo "SELECTED"; } ?>>PI</option>
                      <option value="PR" <? if($_POST['c_estado1']=='PR'){ echo "SELECTED"; }elseif($not2[c_estado]=='PR'){ echo "SELECTED"; } ?>>PR</option>
                      <option value="RJ" <? if($_POST['c_estado1']=='RJ'){ echo "SELECTED"; }elseif($not2[c_estado]=='RJ'){ echo "SELECTED"; } ?>>RJ</option>
                      <option value="RN" <? if($_POST['c_estado1']=='RN'){ echo "SELECTED"; }elseif($not2[c_estado]=='RN'){ echo "SELECTED"; } ?>>RN</option>
                      <option value="RO" <? if($_POST['c_estado1']=='RO'){ echo "SELECTED"; }elseif($not2[c_estado]=='RO'){ echo "SELECTED"; } ?>>RO</option>
                      <option value="RR" <? if($_POST['c_estado1']=='RR'){ echo "SELECTED"; }elseif($not2[c_estado]=='RR'){ echo "SELECTED"; } ?>>RR</option>
                      <option value="RS" <? if($_POST['c_estado1']=='RS'){ echo "SELECTED"; }elseif($not2[c_estado]=='RS'){ echo "SELECTED"; } ?>>RS</option>
                      <option value="SC" <? if($_POST['c_estado1']=='SC'){ echo "SELECTED"; }elseif($not2[c_estado]=='SC'){ echo "SELECTED"; } ?>>SC</option>
                      <option value="SE" <? if($_POST['c_estado1']=='SE'){ echo "SELECTED"; }elseif($not2[c_estado]=='SE'){ echo "SELECTED"; } ?>>SE</option>
                      <option value="SP" <? if($_POST['c_estado1']=='SP'){ echo "SELECTED"; }elseif($not2[c_estado]=='SP'){ echo "SELECTED"; } ?>>SP</option>
                      <option value="TO" <? if($_POST['c_estado1']=='TO'){ echo "SELECTED"; }elseif($not2[c_estado]=='TO'){ echo "SELECTED"; } ?>>TO</option>
                      <option value="">Outro</option></select> Outro: <input type="text" name="c_estado2" size="2" class="campo">Obs.: Máximo duas letras</td>
    </tr>
     <tr class="fundoTabela">
      <td width="30%" class=style1><b>País Comercial:</b></td>
      <td width="70%" colspan="5" class=style1> <input type="text" class="campo" name="c_origem_com" size="30" value="<?php if($_POST['c_origem_com']){ print("$c_origem_com"); }elseif($not2[c_origem_com]){ print("$not2[c_origem_com]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Endereço Comercial:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" class="campo" name="c_end_com" size="40" value="<?php if($_POST['c_end_com']){ print("$c_end_com"); }elseif($not2[c_end_com]){ print("$not2[c_end_com]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Bairro Comercial:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" class="campo" name="c_bairro_com" size="30" value="<?php if($_POST['c_bairro_com']){ print("$c_bairro_com"); }elseif($not2[c_bairro_com]){ print("$not2[c_bairro_com]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>CEP Comercial:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_cep_com" class="campo" size="8" maxlenght="8" onKeyUp="return autoTab(this, 8, event);" value="<?php if($_POST['c_cep_com']){ print("$c_cep_com"); }elseif($not2[c_cep_com]){ print("$not2[c_cep_com]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Cidade Comercial:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_cidade_com" class="campo" size="40" value="<?php if($_POST['c_cidade_com']){ print("$c_cidade_com"); }elseif($not2[c_cidade_com]){ print("$not2[c_cidade_com]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Estado Comercial:</b></td>
      <td width="70%" colspan="5" class=style1><select name="c_estado_com1" class="campo">
                      <option value="">Selecione</option>
                      <option value="AC" <? if($_POST['c_estado_com1']=='AC'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='AC'){ echo "SELECTED"; } ?>>AC</option>
                      <option value="AL" <? if($_POST['c_estado_com1']=='AL'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='AL'){ echo "SELECTED"; } ?>>AL</option>
                      <option value="AM" <? if($_POST['c_estado_com1']=='AM'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='AM'){ echo "SELECTED"; } ?>>AM</option>
                      <option value="AP" <? if($_POST['c_estado_com1']=='AP'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='AP'){ echo "SELECTED"; } ?>>AP</option>
                      <option value="BA" <? if($_POST['c_estado_com1']=='BA'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='BA'){ echo "SELECTED"; } ?>>BA</option>
                      <option value="CE" <? if($_POST['c_estado_com1']=='CE'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='CE'){ echo "SELECTED"; } ?>>CE</option>
                      <option value="ES" <? if($_POST['c_estado_com1']=='ES'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='ES'){ echo "SELECTED"; } ?>>ES</option>
                      <option value="DF" <? if($_POST['c_estado_com1']=='DF'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='DF'){ echo "SELECTED"; } ?>>DF</option>
                      <option value="GO" <? if($_POST['c_estado_com1']=='GO'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='GO'){ echo "SELECTED"; } ?>>GO</option>
                      <option value="MA" <? if($_POST['c_estado_com1']=='MA'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='MA'){ echo "SELECTED"; } ?>>MA</option>
                      <option value="MG" <? if($_POST['c_estado_com1']=='MG'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='MG'){ echo "SELECTED"; } ?>>MG</option>
                      <option value="MS" <? if($_POST['c_estado_com1']=='MS'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='MS'){ echo "SELECTED"; } ?>>MS</option>
                      <option value="MT" <? if($_POST['c_estado_com1']=='MT'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='MT'){ echo "SELECTED"; } ?>>MT</option>
                      <option value="PA" <? if($_POST['c_estado_com1']=='PA'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='PA'){ echo "SELECTED"; } ?>>PA</option>
                      <option value="PB" <? if($_POST['c_estado_com1']=='PB'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='PB'){ echo "SELECTED"; } ?>>PB</option>
                      <option value="PE" <? if($_POST['c_estado_com1']=='PE'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='PE'){ echo "SELECTED"; } ?>>PE</option>
                      <option value="PI" <? if($_POST['c_estado_com1']=='PI'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='PI'){ echo "SELECTED"; } ?>>PI</option>
                      <option value="PR" <? if($_POST['c_estado_com1']=='PR'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='PR'){ echo "SELECTED"; } ?>>PR</option>
                      <option value="RJ" <? if($_POST['c_estado_com1']=='RJ'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='RJ'){ echo "SELECTED"; } ?>>RJ</option>
                      <option value="RN" <? if($_POST['c_estado_com1']=='RN'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='RN'){ echo "SELECTED"; } ?>>RN</option>
                      <option value="RO" <? if($_POST['c_estado_com1']=='RO'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='RO'){ echo "SELECTED"; } ?>>RO</option>
                      <option value="RR" <? if($_POST['c_estado_com1']=='RR'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='RR'){ echo "SELECTED"; } ?>>RR</option>
                      <option value="RS" <? if($_POST['c_estado_com1']=='RS'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='RS'){ echo "SELECTED"; } ?>>RS</option>
                      <option value="SC" <? if($_POST['c_estado_com1']=='SC'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='SC'){ echo "SELECTED"; } ?>>SC</option>
                      <option value="SE" <? if($_POST['c_estado_com1']=='SE'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='SE'){ echo "SELECTED"; } ?>>SE</option>
                      <option value="SP" <? if($_POST['c_estado_com1']=='SP'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='SP'){ echo "SELECTED"; } ?>>SP</option>
                      <option value="TO" <? if($_POST['c_estado_com1']=='TO'){ echo "SELECTED"; }elseif($not2[c_estado_com]=='TO'){ echo "SELECTED"; } ?>>TO</option>
                      <option value="">Outro</option></select> Outro: <input type="text" name="c_estado_com2" size="2" class="campo">Obs.: Máximo duas letras</td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Telefone:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_tel" class="campo" size="13" maxlength="13" value="<?php if($_POST['c_tel']){ print("$c_tel"); }elseif($not2[c_tel]){ print("$not2[c_tel]"); } ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Telefone 2:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_tel2" class="campo" size="13" maxlength="13" value="<?php if($_POST['c_tel2']){ print("$c_tel2"); }elseif($not2[c_tel2]){ print("$not2[c_tel2]"); } ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Telefone Comercial:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_tel_com" class="campo" size="13" maxlength="13" value="<?php if($_POST['c_tel_com']){ print("$c_tel_com"); }elseif($not2[c_tel_com]){ print("$not2[c_tel_com]"); } ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
<? if($not2['c_tipo_pessoa']=='F' || $_POST['c_tipo_pessoa']=='F'){ ?>    
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Celular:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_cel" class="campo" size="13" maxlength="13" value="<?php if($_POST['c_cel']){ print("$c_cel"); }elseif($not2[c_cel]){ print("$not2[c_cel]"); } ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Celular 2:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_cel2" class="campo" size="13" maxlength="13" value="<?php if($_POST['c_cel2']){ print("$c_cel2"); }elseif($not2[c_cel2]){ print("$not2[c_cel2]"); } ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
<? } ?>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Fax:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_fax" class="campo" size="13" maxlength="13" value="<?php if($_POST['c_fax']){ print("$c_fax"); }elseif($not2[c_fax]){ print("$not2[c_fax]"); } ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Fax Comercial:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_fax_com" class="campo" size="13" maxlength="13" value="<?php if($_POST['c_fax_com']){ print("$c_fax_com"); }elseif($not2[c_fax_com]){ print("$not2[c_fax_com]"); } ?>" onKeyPress="return (Mascara(this,event,'(##)####-####'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>E-mail:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_email" class="campo" size="40" value="<?php if($_POST['c_email']){ print("$c_email"); }elseif($not2[c_email]){ print("$not2[c_email]"); } ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>E-mail Comercial:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_email_com" class="campo" size="40" value="<?php if($_POST['c_email_com']){ print("$c_email_com"); }elseif($not2[c_email_com]){ print("$not2[c_email_com]"); } ?>"></td>
    </tr>
<?php
	$anod = substr ($not2[c_desde], 0, 4);
	$mesd = substr($not2[c_desde], 5, 2 );
	$diad = substr ($not2[c_desde], 8, 2 );
?>
  <tr class="fundoTabela">
    <td width="30%"><b class=style1>Cliente desde:</b></td>
    <td width="70%" colspan="5" class=style1>
    <input type="text" name="diad" size="2" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" class="campo" value="<?php if($POST['diad']){ print($_POST['diad']); }else{ print("$diad"); } ?>">/<input type="text" name="mesd" class="campo" size="2" maxlenght="2" onKeyUp="return autoTab(this, 2, event);" value="<?php if($POST['mesd']){ print($_POST['mesd']); }else{ print("$mesd"); } ?>">/<input type="text" name="anod" size="4" maxlenght="4" class="campo" onKeyUp="return autoTab(this, 4, event);" value="<?php if($POST['anod']){ print($_POST['anod']); }else{ print("$anod"); } ?>"> Ex.: 01/01/1987</td>
  </tr>
    <tr class="fundoTabela">
      <td width="30%" valign="top" class=style1><b>Observação:</b></td>
      <td width="70%" colspan="5" class=style1><textarea rows="10" name="c_obs" cols="50" class="campo"><?php if($POST['c_obs']){ print("$c_obs"); }else{ print("$not2[c_obs]"); } ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Banco:</b></td>
      <td width="70%" colspan="5" class=style1> <select name="c_banco" class="campo">
<?
	if($_POST['c_banco']){
		$bbanco = mysql_query("select b_nome from bancos where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by b_nome");
 		while($linha = mysql_fetch_assoc($bbanco)){
			if($linha[b_nome]==$_POST['c_banco']){
	   			echo('<option value="'.$linha[b_nome].'" SELECTED>'.$linha['b_nome'].'</option>'); 
			}else{
				echo('<option value="'.$linha[b_nome].'">'.$linha['b_nome'].'</option>');
			}
		}
	}else{
	  	$bbanco = mysql_query("select b_nome from bancos where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by b_nome");
 		while($linha = mysql_fetch_assoc($bbanco)){
			if($linha[b_nome]==$not2['c_banco']){
	   			echo('<option value="'.$linha[b_nome].'" SELECTED>'.$linha['b_nome'].'</option>'); 
			}else{
				echo('<option value="'.$linha[b_nome].'">'.$linha['b_nome'].'</option>');
			}
		}
	}
?>      	
  </select> <input type="text" name="novo_banco" size="20" class="campo"> <a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='p_exc_bancos.php';form1.submit();" class="style1"><b>Excluir Banco</b></a></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" valign="top" class=style1><b>Conta Corrente:</b></td>
      <td width="70%" colspan="5" class=style1><textarea rows="2" name="c_conta" cols="40" class="campo"><?php if($POST['c_conta']){ print("$c_conta"); }else{ print("$not2[c_conta]"); } ?></textarea></td>
    </tr>
<?    
if($_POST['c_tipo_pessoa']){
   if($_POST['c_tipo_pessoa']=='F'){ 
?>   
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Profissão:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_prof" size="30" value="<?php print("$c_prof"); ?>" class="campo"></td>
    </tr>
<? }elseif($_POST['c_tipo_pessoa']=='J'){ ?>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>Representante:</b></td>
      <td width="70%" colspan="5" class=style1><textarea rows="2" name="c_repre" cols="40" class="campo"><?php print("$c_repre"); ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Representante 2:</b></td>
      <td width="70%" colspan="5" class=style1><textarea rows="2" name="c_repre2" cols="40" class="campo"><?php print("$c_repre2"); ?></textarea></td>
    </tr>
<? 
   }
}else{   
   if($not2['c_tipo_pessoa']=='F'){ 
?>
   <tr class="fundoTabela">
      <td width="30%" class=style1><b>Profissão:</b></td>
      <td width="70%" colspan="5" class=style1><input type="text" name="c_prof" size="30" value="<?php print("$not2[c_prof]"); ?>" class="campo"></td>
    </tr>
<? }elseif($not2['c_tipo_pessoa']=='J'){ ?>
	<tr class="fundoTabela">
      <td width="30%" class=style1><b>Representante:</b></td>
      <td width="70%" colspan="5" class=style1><textarea rows="2" name="c_repre" cols="40" class="campo"><?php print("$not2[c_repre]"); ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class=style1><b>Representante 2:</b></td>
      <td width="70%" colspan="5" class=style1><textarea rows="2" name="c_repre2" cols="40" class="campo"><?php print("$not2[c_repre2]"); ?></textarea></td>
    </tr>
<?
   }
}
?>
    <tr>
      <td width="100%" colspan="7">
         <input type="hidden" value="1" name="editar">
         <input type="submit" value="Atualizar Cadastro" name="B1" class=campo3>
         <input type="button" value="Apagar Cadastro" name="B1" class=campo3 onClick="javascript:confirmaExclusao(<? echo($c_cod); ?>,'<?=$not2[c_nome] ?>')">
      </td>
    </tr>
    </form>
  </table>
  </center></div>
<?php
	}
	}
/*
mysql_free_result($result2);
mysql_free_result($result3);
mysql_free_result($result4);
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