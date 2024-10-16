<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("REL_INTERESSADOS");

?>
<html>
<head>
<?php
include("style.php");
?>
<script language="javascript">
function confirmaExclusao(id,imo)
{
       if(confirm("Tem certeza que deseja excluir?"))
          document.location.href='p_int.php?id_excluir=' + id + '&imo=' + imo;
}
</script>
</head>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/	 

if($_POST['codi']){
   $codi = $_POST['codi'];
}elseif($_GET['codi']){
   $codi = $_GET['codi'];
}else{
   $codi = $_SESSION['cod_imobiliaria'];
}

?>
<body>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
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

if($B1 == "Inserir Atendimento")
	{
	
	$i_nome = AddSlashes($i_nome);
	$i_tel = AddSlashes($i_tel);
	$i_email = AddSlashes($i_email);
	$i_obs = AddSlashes($i_obs);
	if(($i_tipo == "comprar") or ($i_tipo =="vender")){
		$controle = "V";
	}elseif($i_tipo == "alugar"){
		$controle = "L";
	}
	     
	$query = "insert into interessados (cod_imobiliaria, i_nome, i_tel, i_email, i_obs, i_ref, i_tipo, i_data
	, i_status, i_data_status, i_corretor, i_libera, i_controle) 
	values('".$codi."','$i_nome', '$i_tel', '$i_email', '$i_obs', '$i_ref', '$i_tipo', current_timestamp
	, 'Novo', current_timestamp, '$i_corretor', 's', '$controle')";
	//echo $query;
	$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
	$int_cod = mysql_insert_id();
	
	//echo $int_cod;
	
	if(!$sid){
	$sid = session_id();
	}
	
	session_register("int_cod");
	//session_register("i_nome");
	$controle1 = $controle;
	session_register("controle1");
	
	if($controle == "V")
    {
	  $dataa = "a_data_venda=current_timestamp";
	}
	elseif($controle == "L")
	{
	  $dataa = "a_data_locacao=current_timestamp";
	}
	
	$query1 = "update atendimento set ".$dataa." where a_corretor='$i_corretor' and cod_imobiliaria='".$codi."'";
	$result1 = mysql_query($query1) or die("Não foi possível atualizar suas informações.");
	
	echo("<p class=\"style7\" align=\"center\">Você inseriu um atendimento!</p>");
?>
<?php
	}
?>

<?php
if($_GET['id_excluir'])
	{
	$id_excluir = $_GET['id_excluir'];
	$imo = $_GET['imo'];

	$query = "delete from interessados where i_cod = '$id_excluir' and cod_imobiliaria='".$imo."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
<p class="style7" align="center">Você apagou um atendimento.</p>
<?php
	}
if($B1 == "Atualizar Atendimento")
	{
	$i_nome = AddSlashes($i_nome);
	$i_tel = AddSlashes($i_tel);
	$i_email = AddSlashes($i_email);
	$i_obs = AddSlashes($i_obs);
	if($i_libera == ""){
		$i_libera = "n";
	}
	if(($i_tipo == "comprar") or ($i_tipo =="vender")){
		$controle = "V";
	}elseif($i_tipo == "alugar"){
		$controle = "L";
	}

	$query = "update interessados set i_nome='$i_nome', i_tel='$i_tel'
	, i_email='$i_email', i_tipo='$i_tipo', i_obs='$i_obs', i_status='$i_status'
	, i_data_status=current_timestamp, i_corretor='$i_corretor', i_libera='$i_libera', i_controle='$controle' 
	where i_cod='$i_cod' and cod_imobiliaria='".$codi."'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
<p class="style7" align="center">Você atualizou um atendimento.</p>
<?php
	}
	
if($lista == "")
	{

	if (verificaFuncao("VER_TODOS_ATENDIMENTOS")) {

		if($list == ""){
			$query1 = "select * from interessados left join usuarios on i_corretor=u_cod where interessados.cod_imobiliaria='".$codi."' order by i_data desc, i_nome limit $from, 30";
		}else{
			if($data_tipo != ""){
				$query1 = "select * from interessados left join usuarios on i_corretor=u_cod where 
				($data_tipo >= '$ano2-$mes2-$dia2 00:00:00' AND $data_tipo <= '$ano3-$mes3-$dia3 23:59:59') and $campo like '%$i_nome%' and interessados.cod_imobiliaria='".$codi."'
				order by i_data desc, i_nome limit $from, 30";
			}
			else
			{
				$query1 = "select * from interessados left join usuarios on i_corretor=u_cod where $campo like '%$i_nome%' and interessados.cod_imobiliaria='".$codi."' order by i_data desc, i_nome 
				limit $from, 30";
			}
		}
	}else{
		if($list == ""){
			$query1 = "select * from interessados left join usuarios on i_corretor=u_cod where interessados.cod_imobiliaria='".$codi."' AND interessados.i_corretor='".$_SESSION['u_cod']."' order by i_data desc, i_nome limit $from, 30";
		}else{
			if($data_tipo != ""){
				$query1 = "select * from interessados left join usuarios on i_corretor=u_cod where 
				($data_tipo >= '$ano2-$mes2-$dia2 00:00:00' AND $data_tipo <= '$ano3-$mes3-$dia3 23:59:59') and $campo like '%$i_nome%' and interessados.cod_imobiliaria='".$codi."' AND interessados.i_corretor='".$_SESSION['u_cod']."'
				order by i_data desc, i_nome limit $from, 30";
			}
			else
			{
				$query1 = "select * from interessados left join usuarios on i_corretor=u_cod where $campo like '%$i_nome%' and interessados.cod_imobiliaria='".$codi."' AND interessados.i_corretor='".$_SESSION['u_cod']."' order by i_data desc, i_nome 
				limit $from, 30";
			}
		}  
	}
	//echo $query1;
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table width="75%" border="0" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
<tr height="50"><td bgcolor="#<?php print("$cor1"); ?>" colspan=7>
<p align="center" class="style1"><b>
<a href="p_insert_int.php" class="style1">Cadastrar novo atendimento</a></b><br />
Para alterar ou excluir um atendimento, clique sobre o nome correspondente a seguir.</td>
</tr>
<tr>
<td width=300 class="fundoTabelaTitulo style1"><b>
<p align="center">Nome</td>
<td width=100 class="fundoTabelaTitulo style1"><b>
<p align="center">Telefone</td>
<td width=150 class="fundoTabelaTitulo style1"><b>
<p align="center">Data/Status</td>
<td width=100 class="fundoTabelaTitulo style1"><b>
<p align="center">Imóvel</td>
<td width=150 class="fundoTabelaTitulo style1"><b>
<p align="center">Corretor</td>
<td width=100 class="fundoTabelaTitulo style1"><b>
<p align="center">Liberado</td>
</tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	if($not[i_libera] == "n"){
		$i_libera = "Não";
	}elseif($not[i_libera] == "s"){
		$i_libera = "Sim";
	}
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
?>
<tr>
<td class="<?php print("$fundo"); ?>"><p align="left">
<a href="p_int.php?lista=1&i_cod=<?php print("$not[i_cod]"); ?>" class="style1">
<?php print("$not[i_nome]"); ?></a></td>
<td class="<?php print("$fundo"); ?>">
<p align="left">
<a href="p_int.php?lista=1&i_cod=<?php print("$not[i_cod]"); ?>" class="style1">
<?php print("$not[i_tel]"); ?></a></td>
<?php
	$ano = substr ($not[i_data_status], 0, 4);
	$mes = substr($not[i_data_status], 5, 2 );
	$dia = substr ($not[i_data_status], 8, 2 );
?>
<td class="<?php print("$fundo"); ?>">
<p align="left">
<a href="p_int.php?lista=1&i_cod=<?php print("$not[i_cod]"); ?>" class="style1">
<?php print("$dia/$mes/$ano - $not[i_status]"); ?></a></td>
<td class="<?php print("$fundo"); ?>" align="left">
<a href="carrinho_imoveis.php?codu=<?php echo($not[i_corretor]); ?>&int_cod=<?php print("$not[i_cod]"); ?>&ordem=tipo" class="style1">Ver imóveis</a></td>
<td class="<?php print("$fundo"); ?>" align="left">
<a href="p_int.php?lista=1&i_cod=<?php print("$not[i_cod]"); ?>" class="style1">
<?php print("$not[u_email]"); ?></a></td>
<td class="<?php print("$fundo"); ?>" align="left" class="style1">
<a href="p_int.php?lista=1&i_cod=<?php print("$not[i_cod]"); ?>" class="<?php if($not[i_libera] == "n"){ echo "style1"; }else{ echo "style7"; } ?>">
<?php print("$i_libera"); ?></a></td>
<?php
	}
	if (verificaFuncao("VER_TODOS_ATENDIMENTOS")) {
	  
		if($list == ""){
			$query2 = "select count(i_cod) as contador from interessados left join usuarios on i_corretor=u_cod where interessados.cod_imobiliaria='".$codi."'";
		}else{
			if($data_tipo != ""){
				$query2 = "select count(i_cod) as contador from interessados left join usuarios on i_corretor=u_cod where 
				($data_tipo >= '$ano2-$mes2-$dia2 00:00:00' AND $data_tipo <= '$ano3-$mes3-$dia3 23:59:59') and $campo like '%$i_nome%' and interessados.cod_imobiliaria='".$codi."'";
			}
			else
			{
				$query2 = "select count(i_cod) as contador from interessados left join usuarios on i_corretor=u_cod where $campo like '%$i_nome%' and interessados.cod_imobiliaria='".$codi."'";
			}
		}
	}else{
	  	if($list == ""){
			$query2 = "select count(i_cod) as contador from interessados left join usuarios on i_corretor=u_cod where interessados.cod_imobiliaria='".$codi."' AND interessados.i_corretor='".$_SESSION['u_cod']."'";
		}else{
			if($data_tipo != ""){
				$query2 = "select count(i_cod) as contador from interessados left join usuarios on i_corretor=u_cod where 
				($data_tipo >= '$ano2-$mes2-$dia2 00:00:00' AND $data_tipo <= '$ano3-$mes3-$dia3 23:59:59') and $campo like '%$i_nome%' and interessados.cod_imobiliaria='".$codi."' AND interessados.i_corretor='".$_SESSION['u_cod']."'";
			}
			else
			{
				$query2 = "select count(i_cod) as contador from interessados left join usuarios on i_corretor=u_cod where $campo like '%$i_nome%' and interessados.cod_imobiliaria='".$codi."' AND interessados.i_corretor='".$_SESSION['u_cod']."'";
			}
		}
	}
	//echo $query2;
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$paginas = $pages = ceil($not2[contador] / 30);
    $pagina = $screen;
    $url = "p_int.php?list=".$list."&i_nome=".$i_nome."&dia=".$dia."&mes=".$mes."&ano=".$ano."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&dia2=".$dia2."&mes2=".$mes2."&ano2=".$ano2."&dia3=".$dia3."&mes3=".$mes3."&ano3=".$ano3."&data_tipo=".$data_tipo."&campo=".$campo."&screen=";
?>
 			 		<tr>
					  <td colspan="7" bgcolor="#<?php print("$cor3"); ?>" class="style1" align="center">Foram encontrados <?php print("$not2[contador]"); ?> atendimentos</td>
					</tr>
                  	<tr>
					  <td colspan="7" bgcolor="#<?php print("$cor1"); ?>" class="style1" align="center">
					  	<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_int.php?list=<?=$list ?>&i_nome=<?=$i_nome ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&dia2=<?=$dia2 ?>&mes2=<?=$mes2 ?>&ano2=<?=$ano2 ?>&dia3=<?=$dia3 ?>&mes3=<?=$mes3 ?>&ano3=<?=$ano3 ?>&data_tipo=<?=$data_tipo ?>&campo=<?=$campo ?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_int.php?list=<?=$list ?>&i_nome=<?=$i_nome ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&dia2=<?=$dia2 ?>&mes2=<?=$mes2 ?>&ano2=<?=$ano2 ?>&dia3=<?=$dia3 ?>&mes3=<?=$mes3 ?>&ano3=<?=$ano3 ?>&data_tipo=<?=$data_tipo ?>&campo=<?=$campo ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
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
                  				<td width="10%" class="style1" align="center"><a href="p_int.php?list=<?=$list ?>&i_nome=<?=$i_nome ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&dia2=<?=$dia2 ?>&mes2=<?=$mes2 ?>&ano2=<?=$ano2 ?>&dia3=<?=$dia3 ?>&mes3=<?=$mes3 ?>&ano3=<?=$ano3 ?>&data_tipo=<?=$data_tipo ?>&campo=<?=$campo ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_int.php?list=<?=$list ?>&i_nome=<?=$i_nome ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano=<?=$ano ?>&dia1=<?=$dia1 ?>&mes1=<?=$mes1 ?>&ano1=<?=$ano1 ?>&dia2=<?=$dia2 ?>&mes2=<?=$mes2 ?>&ano2=<?=$ano2 ?>&dia3=<?=$dia3 ?>&mes3=<?=$mes3 ?>&ano3=<?=$ano3 ?>&data_tipo=<?=$data_tipo ?>&campo=<?=$campo ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>

<?php
	}
?>

<?php
	}
	else
	{
  	$query2 = "select * from interessados 
	where i_cod = '$i_cod' and cod_imobiliaria='".$codi."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{

if(!IsSet($editar))
	{
?>
<script language="javascript">
function valida()
{
  if (document.form1.i_nome.value == "")
  {
    alert("Por favor, digite o Nome");
    document.form1.i_nome.focus();
    return (false);
  }
  if (document.form1.i_tel.value == "")
  {
    alert("Por favor, digite o Telefone");
    document.form1.i_tel.focus();
    return (false);
  }
	return(true);
}
</script>
<p align="center" class="style1" style="padding-top:3px;padding-bottom:3px;"><b>Editar ou Apagar Atendimento</b></p>
 <div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <input type="hidden" value="<?php print("$not2[i_cod]"); ?>" name="i_cod">
  <input type="hidden" value="<?php print($codi); ?>" name="codi">
  <table border="0" cellpadding="1" cellspacing="1" width="75%">
<?php
	$ano = substr ($not2[i_data], 0, 4);
	$mes = substr($not2[i_data], 5, 2 );
	$dia = substr ($not2[i_data], 8, 2 );
?>
    <tr bgcolor="#<?php print("$cor6"); ?>">
      <td width="100%" colspan="2" class="style1">Cadastrado em: <b><?php print("$dia/$mes/$ano"); ?></b></td>
    </tr>
<?php
	$i_tipo = $not2[i_tipo];
?>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Tipo:</b></td>
      <td width="70%" class="style1"> <select name="i_tipo" class="campo">
    <option selected value="<?php print("$not2[i_tipo]"); ?>"><?php print("$i_tipo"); ?></option>
      <option value="comprar">Comprar</option>
    <option value="alugar">Alugar</option>
    <option value="vender">Vender</option>
        </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Nome:</b></td>
      <td width="70%" class="style1"> <input type="text" name="i_nome" size="40" class="campo" value="<?php print("$not2[i_nome]"); ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Telefone:</b></td>
      <td width="70%" class="style1"><input type="text" name="i_tel" size="20" class="campo" value="<?php print("$not2[i_tel]"); ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>E-mail:</b></td>
      <td width="70%" class="style1"><input type="text" name="i_email" size="40" class="campo" value="<?php print("$not2[i_email]"); ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" valign="top" class="style1"><b>Observação:</b></td>
      <td width="70%" class="style1"><textarea rows="3" name="i_obs" cols="40" class="campo"><?php print("$not2[i_obs]"); ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Status do Atendimento:</b></td>
      <td width="70%" class="style1"> <select name="i_status" class="campo">
    <option selected value="<?php print("$not2[i_status]"); ?>"><?php print("$not2[i_status]"); ?></option>
    <option value="Novo">Novo</option>
    <option value="Atendido">Atendido</option>
    <option value="Cancelado">Cancelado</option>
        </select></td>
    </tr>
<?php
	if($not2[i_libera] == "s"){
	
	$int_cod = $not2[i_cod];
	$i_nome = $not2[i_nome];
	$controle1 = $not2[i_controle];
	
	session_register("int_cod");
	//session_register("i_nome");
	session_register("controle1");
	
	$query6 = "select cod, sid from imoveis_temp where interessado='$int_cod' and cod_imobiliaria='".$codi."'";
	//echo $query6;
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
	if($numrows6 > 0){
	while($not6 = mysql_fetch_array($result6))
	{
		$sid = $not6[sid];
		session_register("sid");
	}
	}
	
	}
?>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Imóveis:</b></td>
      <td width="70%" class="style1"><a href="carrinho_imoveis.php?int_cod=<?php print("$not2[i_cod]"); ?>&ordem=tipo" class="style1">Clique aqui e veja a relação de imóveis deste atendimento</a></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Corretor:</b></td>
      <td width="70%" class="style1"> <select name="i_corretor" class=campo>
<?php
	$query0 = "select * from usuarios where cod_imobiliaria='".$codi."' order by u_email";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 > 0){
	while($not0 = mysql_fetch_array($result0))
	{
	//if($not2[i_corretor] == $not0[u_cod]){
?>
<!--option selected value="<?php print("$not2[i_corretor]"); ?>"><?php print("$not0[u_nome] - $not0[u_email]"); ?></option-->
<?php
	//}
	//if(($valid_user == $not0[u_email]) or ($valid_user == "muraski@muraski.com") or ($valid_user == "paulo@bruc.com.br")){
    if($not2[i_corretor] == $not0[u_cod]){
	
?>
<option value="<?php print("$not0[u_cod]"); ?>"><?php print("$not0[u_nome]"); ?> - <?php print("$not0[u_email]"); ?></option>
<?php
	}
?>
<?php
	}
	}
?>
        </select></td>
    </tr>
<?php
	if($not2[i_libera] == "n"){
		$i_libera = "Não";
	}elseif($not2[i_libera] == "s"){
		$i_libera = "Sim";
	}
	
	/*
	$busca2 = mysql_query("SELECT u_cod FROM usuarios WHERE u_nome LIKE 'Claudir%' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	while($linha2 = mysql_fetch_array($busca2)){
	    $codigo = $linha2['u_cod'];
	}
	*/
	
	//if($_SESSION['u_cod'] == $codigo){
    if (verificaFuncao("USER_LIBERAR_ACESSO")) { // verifica se pode acessar as areas 
?>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Liberar Atendimento:</b></td>
      <td width="70%" class="style1"> <select name="i_libera" class="campo">
   <option value="s" <? if($not2[i_libera]=='s'){ print "SELECTED"; } ?>>Sim</option>
    <option value="n" <? if($not2[i_libera]=='n'){ print "SELECTED"; } ?>>Não</option>
        </select></td>
    </tr>
<?php
	}
	else
	{
?>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Liberado:</b></td>
      <td width="70%" class="style1"> <?php print("$i_libera"); ?></td>
    </tr>
<?php
	}
?>
    <tr>
      <td width="100%" class="style1" colspan="2">
      <input type="hidden" value="1" name="editar">
      <input type="submit" value="Atualizar Atendimento" name="B1" class=campo3>
	  <input type="button" value="Apagar Atendimento" name="B1" class=campo3 onClick="javascript:confirmaExclusao(<? echo($i_cod); ?>,<? echo($codi); ?>)"></td>
    </tr>
    <tr>
      <td width="100%" colspan="2" class="style1">
      <a href="p_insert_clientes.php?c_nome=<?php print("$not2[i_nome]"); ?>&c_tel=<?php print("$not2[i_tel]"); ?>&c_email=<?php print("$not2[i_email]"); ?>" class="style1">
<? if($codi==$_SESSION['cod_imobiliaria']){ ?>
	  <b class="style1">Clique aqui</b></a> para cadastrar este interessado como um novo cliente.</td>
<? } ?>	  
    </tr>
  </table>
  </center></div>
  </form>
<?php
	}
	}
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
<table width="50%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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