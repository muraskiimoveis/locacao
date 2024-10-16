<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("regra.php");
?>
<html>
<head>
<?php
include("style.php");
?>
<?php
if($lista != "")
	{
?>
<script type="text/javascript" src="/painel/FCKeditor/fckeditor.js"></script>
<script type="text/javascript">
      window.onload = function()
      {
        var oFCKeditor = new FCKeditor( 'n_txt' ) ;
        oFCKeditor.Height = "400"
        oFCKeditor.BasePath = "/painel/FCKeditor/" ;
        oFCKeditor.ReplaceTextarea() ;
      }
    </script>
<?php
	}
?>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<table width=100% height=100%>
<tr><td bgcolor="<?php print("$barra_lat"); ?>" valign=top width=150>
<?php
include("menu_painel.php");
?></td>
<td width=620 valign=top>
<br>
<?php
include("conect.php");

if($B1 == "Inserir Texto")
	{

	$n_nome = AddSlashes($n_nome);
	$n_grupo = AddSlashes($n_grupo);
	$n_txt = AddSlashes($n_txt);
	$ano = substr ($n_data, 6, 4);
	$mes = substr ($n_data, 3, 2 );
	$dia = substr ($n_data, 0, 2 );
	
	$n_data = "$ano-$mes-$dia";
	
	$query0 = "insert into rebri_noticias (n_tipo, n_grupo, n_nome, n_txt, n_data, n_autor
	, n_html) values('$n_tipo', '$n_grupo', '$n_nome', '$n_txt', '$n_data', '$n_autor'
	, '$n_html')";
	//print "$query0";
	$result0 = mysql_query($query0) or die("Não foi possível inserir suas informações.");
?>
<font color="#ff0000" size="2" face="Verdana">
Você inseriu um novo Texto.
<?php
	}
?>
<?php
if($B1 == "Apagar Texto")
	{
	/*	
	$query4 = "select * from noticias where n_cod='$n_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{
	}
	}*/
	$query = "delete from rebri_noticias where n_cod = '$n_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
<font color="#ff0000" size="2" face="Verdana">
Você apagou o Texto <i><?php print("$n_nome"); ?></i>.
<?php
	}
if($B1 == "Atualizar Texto")
	{
	
	$n_nome = AddSlashes($n_nome);
	$n_grupo = AddSlashes($n_grupo);
	$n_txt = AddSlashes($n_txt);
	$ano = substr ($n_data, 6, 4);
	$mes = substr ($n_data, 3, 2 );
	$dia = substr ($n_data, 0, 2 );
	
	$n_data = "$ano-$mes-$dia";

	$query = "update rebri_noticias set n_tipo='$n_tipo', n_grupo='$n_grupo', n_nome='$n_nome', 
	n_txt='$n_txt', n_data='$n_data', n_autor='$n_autor', n_html='$n_html' 
	where n_cod='$n_cod'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
<font color="#ff0000" size="2" face="Verdana">
Você atualizou o texto <i><?php print("$n_nome"); ?></i>.
<?php
	}
	
if($lista == "")
	{
		
	if(!$from){
	$from = intval($screen * 30);
	}
	//Início da pesquisa
	if($pesq == ""){
	$query1 = "select n_cod, left(n_nome, '150') as n_nome, n_data, n_tipo, n_grupo, n_html 
	from rebri_noticias order by n_data desc, n_nome limit $from,30";
	}
	else
	{
	$query1 = "select n_cod, left(n_nome, '150') as n_nome, n_data, n_tipo, n_grupo, n_html 
	from rebri_noticias where $campo like '%$chave%' 
	order by n_data desc, n_nome limit $from, 30";
	}
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor3"); ?>" border="0" cellspacing="1" width=610>
<tr><td bgcolor="#<?php print("$barra_lat"); ?>" colspan=4>
<p align="center"><b>
<a href="p_insert_not.php" class=style2>Cadastrar novo texto</a>
-- <a href="p_pesq_not.php" class=style2>Pesquisar Texto</a></b>
</td></tr>
<tr><td bgcolor="#ffffff" colspan=4 align="center" class=style7>
Para alterar ou excluir um texto, clique sobre o nome correspondente a seguir.</b>
</td></tr>
<tr>
<td width=350 bgcolor="#ffffff" align="center" class="style2"><b>Título
</td>
<td width=80 bgcolor="#ffffff" align="center" class="style2"><b>Tipo
</td>
<td width=120 bgcolor="#ffffff" align="center" class="style2"><b>Grupo
</td>
<td width=60 bgcolor="#ffffff" align="center" class="style2"><b>Data
</td>
</tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;
		
	$ano = substr ($not[n_data], 0, 4);
	$mes = substr ($not[n_data], 5, 2 );
	$dia = substr ($not[n_data], 8, 2 );
	
	$data = "$dia/$mes/$ano";
	
	if (($i % 2) == 1){ $fundo="$cor6"; }else{ $fundo="ffffff"; }
	$i++;
?>
<tr>
<td bgcolor="<?php print("$fundo"); ?>" align="left">
<a href="p_not.php?lista=1&n_cod=<?php print("$not[n_cod]"); ?>" class="style2">
<?php print("$not[n_nome]"); ?></a></td>
<td bgcolor="<?php print("$fundo"); ?>" align="left">
<a href="p_not.php?lista=1&n_cod=<?php print("$not[n_cod]"); ?>" class="style2">
<?php print("$not[n_tipo]"); ?></a></td>
<td bgcolor="<?php print("$fundo"); ?>" align="left">
<a href="p_not.php?lista=1&n_cod=<?php print("$not[n_cod]"); ?>" class="style2">
<?php print("$not[n_grupo]"); ?></a></td>
<td bgcolor="<?php print("$fundo"); ?>" align="left">
<a href="p_not.php?lista=1&n_cod=<?php print("$not[n_cod]"); ?>" class="style2">
<?php print("$data"); ?></a></td>
</tr>
<?php
	}
	if($pesq == ""){
	$query3 = "select count(n_cod) as contador 
	from rebri_noticias";
	}
	else
	{
	$query3 = "select count(n_cod) as contador from rebri_noticias where $campo like '%$chave%'";
	}
	$result3 = mysql_query($query3);
	
	while($not3 = mysql_fetch_array($result3))
	{
	$pages = ceil($not3[contador] / 30);
?>
                  <tr><td colspan=5 bgcolor="#<?php print("$cor3"); ?>" class="style2">
                  <p align="center">
                  <i>Foram encontrados <?php print("$not3[contador]"); ?> textos</i></td></tr>
                  <tr><td colspan=5 bgcolor="#ffffff" class=style2>
                  <p align="center">
<?php
	if ($from > 30) {
	$url1 = $PHP_SELF . "?screen=" . ($screen - 1);
?>
                  <a href="javascript:history.back()" class="style2"><< Página anterior <<</a><br>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class="style2">
                  << Página anterior <<</a><br>
<?php
	}

	for ($j = 0; $j < $pages; $j++) {
  	$url2 = $PHP_SELF . "?screen=" . $j . "&campo=" . $campo . "&chave=" . $chave . "&pesq=" . $pesq;
  	//echo "   | <a href=\"$url2\">$j</a> |   ";
  	if($j == $screen){
  	echo "   | <a href=\"$url2\" class=style2><b><font color=#ff0000>$j</b></a> |   ";
		}
  	else
  	{
  	echo "   | <a href=\"$url2\" class=style2>$j</a> |   ";	
  	}
	}

	if ($from >= $not3[contador]) {
?>
		  <br>Última página da pesquisa
<?php
	}
	else
	{
	$url3 = $PHP_SELF . "?screen=" . ($screen + 1) . "&campo=" . $campo . "&chave=" . $chave . "&pesq=" . $pesq;
?>
                  <br><a href="<?php print("$url3"); ?>" class="style2">>> Próxima Página >></a>
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
	$query2 = "select * from rebri_noticias 
	where n_cod = '$n_cod'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
		$not2[n_txt] = stripslashes($not2[n_txt]);
	
	$ano = substr ($not2[n_data], 0, 4);
	$mes = substr ($not2[n_data], 5, 2 );
	$dia = substr ($not2[n_data], 8, 2 );
	
	$data = "$dia/$mes/$ano";

if(!IsSet($editar))
	{
?>
<p align="center"><b>Rebri -- Editar ou Apagar Textos</b></p>
 <div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <input class=campo type="hidden" name="n_cod" value="<?php print("$not2[n_cod]"); ?>">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="20%"><b>Tipo:</b></td>
      <td width="80%"><select name=n_tipo class=campo>
      <option selected><?php print("$not2[n_tipo]") ?>
      <option value="Texto">Texto</option>
      <option value="Notícia">Notícia</option>
       </select></td>
    </tr>
    <tr>
      <td width="20%"><b>Grupo:</b></td>
      <td width="80%"> <input class=campo type="text" name="n_grupo" size="40" value="<?php print("$not2[n_grupo]") ?>"></td>
    </tr>
    <tr>
      <td width="20%"><b>Título:</b></td>
      <td width="80%"> <input class=campo type="text" name="n_nome" size="40" value="<?php print("$not2[n_nome]") ?>"></td>
    </tr>
    <tr>
      <td width="20%"><b>Data:</b></td>
      <td width="80%"> <input class=campo type="text" name="n_data" size="10" value="<?php print("$data") ?>"></td>
    </tr>
    <tr>
      <td width="20%"><b>Texto:</b></td>
      <td width="80%"> <textarea name="n_txt" rows="40" cols="70"><?php print("$not2[n_txt]") ?></textarea></td>
    </tr>
    <tr>
      <td width="20%"><b>Autor:</b></td>
      <td width="80%"> <input class=campo type="text" name="n_autor" size="40" value="<?php print("$not2[n_autor]") ?>"></td>
    </tr>
    <tr>
      <td width="20%"><b>Código HTML:</b></td>
      <td width="80%"><select name=n_html class=campo>
      <option selected><?php print("$not2[n_html]") ?>
      <option>Nao
      <option>Sim
       </select></td>
    </tr>
    <tr>
      <td width="20%"><b>Enviar mailing:</b></td>
      <td width="80%"><a href="p_mailing.php?n_cod=<?php print("$not2[n_cod]"); ?>" class="style2">Clique aqui para enviar este texto para os clientes cadastrados</a></td>
    </tr>
    <tr>
      <td width="20%">
      <input class=campo type="hidden" value="1" name="editar">
      <input class=campo type="submit" value="Atualizar Texto" name="B1"></td>
      <td width="80%">
      <input class=campo type="submit" value="Apagar Texto" name="B1">
      </td>
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
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>