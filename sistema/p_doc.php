<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("DOCS");
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
	($u_tipo == "admin")){
*/	  
?>
<body>
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
<br>
<?php


if(!$from){
	$from = 0;
}
if($B1 == "Inserir Documento")
	{
	
	$d_nome = AddSlashes($d_nome);
	$d_txt = AddSlashes($d_txt);

	$query = "insert into doc (cod_imobiliaria, d_txt, d_nome, d_data) 
	values('".$_SESSION['cod_imobiliaria']."','$d_txt', '$d_nome', current_date)";
	$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
?>
<tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="center">
Você inseriu o documento <?php print("$d_nome"); ?>.</p></td></tr>
<?php
	}
?>
<?php
if($B1 == "Apagar Documento")
	{

	$query = "delete from doc where d_cod = '$d_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>

Você apagou o documento <?php print("$d_nome"); ?>.
<?php
	}
if($B1 == "Atualizar Documento")
	{
	$d_nome = AddSlashes($d_nome);
	$d_txt = AddSlashes($d_txt);

	$query = "update doc set d_nome='$d_nome', d_txt='$d_txt'
	, d_data=current_date where d_cod='$d_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
Você atualizou o documento <?php print("$d_nome"); ?>.
<?php
	}
	
if($lista == "")
	{

	$query1 = "select * from doc where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by d_nome limit $from, 30";
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table border="0" cellpadding="1" cellspacing="1" bgcolor="#ffffff">
<!--tr>
  <td bgcolor="#ffffff" colspan=4><div align="center"><b><a href="p_insert_doc.php" class=style2>Cadastrar novo documento </a></b></div></td>
</tr-->
<tr><td bgcolor="#ffffff" colspan=4 class="style1">
<p align="center">
Para alterar ou excluir um documento, clique sobre o nome correspondente a seguir.</td></tr>
<tr bgcolor="#EDEEEE">
<td width=200 class="style1">
<p align="left"><b>Nome</b></td>
<td width=450 class="style1">
<p align="left"><b>Início do Texto</b></td>
</tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;
	
	if (($i % 2) == 1){ $fundo="f2f2f2"; }else{ $fundo="EDEEEE"; }
	$i++;
	
	$d_nome = substr ($not[d_nome], 0, 30);
?>
<tr>
<td bgcolor="#<?php print("$fundo"); ?>" class="style1"><p align="left">
<a href="p_doc.php?lista=1&d_cod=<?php print("$not[d_cod]"); ?>" title="<?php print($not[d_nome]); ?>" class="style1">
<?php print("$d_nome"); ?>...</a></td>
<td bgcolor="#<?php print("$fundo"); ?>" class="style1">
<p align="left">
<a href="p_doc.php?lista=1&d_cod=<?php print("$not[d_cod]"); ?>" class="style1">
<?php
	$d_txt = substr ($not[d_txt], 0, 100);
	
	//$d_txt = str_replace("-nome-", "<b>$not[d_nome]</b>", $d_txt);
	
	print("$d_txt");

?>...</a></td>
<?php
	}
	
	$query2 = "select count(d_cod) as contador from doc where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
?>
<?php
	$pages = ceil($not2[contador] / 30);
?>
  <tr><td colspan="4" bgcolor="#ffffff" class="style1">
                  <p align="center">
                  Foram encontrados <?php print("$not2[contador]"); ?> documentos</td></tr>
                  <tr><td colspan="4" bgcolor="#ffffff">
                  <p align="center" class="style1">
<?php
	if ($from > 30) {
	$url1 = "vendas2.php?screen=" . ($screen - 1) . "&tipo=" . $tipo . "&finalidade=" . $finalidade;
?>
                  <a href="javascript:history.back()" class="style1"><< Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class="style1">
                  << Página anterior <<</a>
<?php
	}

	for ($i = 0; $i < $pages; $i++) {
  	$url2 = "p_doc.php?screen=" . $i . "&lista=" . $lista;
  	echo "   | <a href=\"$url2\" class=style1>$i</a> |   ";
	}

	if ($from >= $not2[contador]) {
?>
		  Última página da pesquisa
<?php
	}
	else
	{
	$url3 = "p_doc.php?screen=" . ($screen + 1) . "&lista=" . $lista;
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
?>
</table>
<?php
	}
	else
	{
	$query2 = "select * from doc 
	where d_cod = '$d_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{

if(!IsSet($editar))
	{
?>
<script>
function valida()
{
  if (form1.d_nome.value == "")
  {
    alert("Por favor, digite o Nome");
    form1.d_nome.focus();
    return (false);
  }
  if (form1.d_txt.value == "")
  {
    alert("Por favor, digite o Texto");
    form1.d_txt.focus();
    return (false);
  }
	return(true);
}
</script>
<p align="center" class="style1"><b>Editar ou Apagar Documentos</b></p>
 <div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <input type="hidden" value="<?php print("$not2[d_cod]"); ?>" name="d_cod">
  <table width="600" border="0" cellpadding="1" cellspacing="1" bgcolor="#EDEEEE">
    <tr bgcolor="#ffffff">
      <td width="100%" colspan=2 align=center class="style7"><b>Atenção!</b><br>As palavras escritas no formato <i>-palavra-</i> não podem ser alteradas, pois afetará a funcionalidade do documento.</td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%" class="style1"><b>Nome:</b></td>
      <td width="80%" class="style1"><input type="text" name="d_nome" size="70" class="campo" value="<?php print("$not2[d_nome]"); ?>"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="100%" colspan=2 valign="top" class="style1"><b>Texto do documento:</b></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="100%" colspan=2 class="style1"><textarea rows="15" name="d_txt" cols="80" class="campo"><?php print("$not2[d_txt]"); ?></textarea></td>
    </tr>
    <tr>
      <td width="20%">
      <input type="hidden" value="1" name="editar">
      <input type="submit" value="Atualizar Documento" class="campo3" name="B1"></td>
      <td width="80%"><input type="submit" value="Apagar Documento" class="campo3" name="B1"></td>
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
</body>
</html>