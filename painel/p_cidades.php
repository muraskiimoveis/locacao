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

if($B1 == "Inserir Cidade")
	{

	$ci_nome = AddSlashes($ci_nome);
	$ci_estado = explode("|", $ci_estado);
	
	$query4 = "select * from rebri_cidades where ci_nome='$ci_nome' and ci_estado='$ci_estado[0]'";
	$result4 = mysql_query($query4,$con) or die("erro 34");
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 == 0){

	$query0 = "insert into rebri_cidades (ci_estado, ci_uf, ci_nome, ci_litoranea) values('$ci_estado[0]', '$ci_estado[1]', '$ci_nome', '$ci_litoranea')";
	$result0 = mysql_query($query0,$con) or die("Não foi possível inserir suas informações.");
    mysql_query($query0, $con_site);
    mysql_query($query0, $con_sistema);

?>
<span class="style7">
Você inseriu uma nova Cidade.</span>
<?php
	}
	else
	{
?>
<span class="style7">
Esta cidade já está cadastrada neste estado.</span>
<?php
	}
	}
?>
<?php
if($B1 == "Apagar Cidade")
	{
	$query4 = "select * from muraski where local='$ci_cod' or cidade_mat='$ci_cod'";
	$result4 = mysql_query($query4,$con) or die("erro 62");
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
		echo "<a class=style7><b>Esta cidade não pode ser apagada pois existem imóveis ligados a ela.</b></a>";
	}else{
			
	$query = "delete from rebri_cidades where ci_cod = '$ci_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível apagar suas informações.");
    mysql_query($query, $con_site);
    mysql_query($query, $con_sistema);

?>
<span class="style7">
Você apagou a Cidade <i><?php print("$ci_nome"); ?></i>.</span>
<?php
	}
	}
if($B1 == "Atualizar Cidade")
	{
	$ci_estado = explode("|", $ci_estado);
	
	/*
	$query4 = "select * from rebri_cidades where ci_nome='$ci_nome' and ci_estado='$ci_estado[0]'";
	$result4 = mysql_query($query4,$con) or die ("erro 86");
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 == 0){
	*/ 

	$query = "update rebri_cidades set ci_estado='$ci_estado[0]', ci_uf='$ci_estado[1]', ci_nome='$ci_nome', ci_litoranea='$ci_litoranea' where ci_cod='$ci_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível atualizar suas informações.");
    mysql_query($query, $con_site);
    mysql_query($query, $con_sistema);

?>
<span class="style7">
Você atualizou a Cidade <i><?php print("$ci_nome"); ?></i>.</span>
<?php
	}
//		else
//	{
?>
<!--span class="style7">
Esta cidade já está cadastrada neste estado.</span-->
<?php
//	}
//	}
	
if($lista == "")
	{
	
	if(!$from){
	$from = intval($screen * 30);
	}
	
	if($pesq == ""){
	$query3 = "select * from rebri_cidades inner join rebri_estados on ci_estado=e_cod order by ci_nome limit $from,40";
	}
	else
	{
	$query3 = "select * from rebri_cidades inner join rebri_estados on ci_estado=e_cod where ci_nome like '%$chave%' order by ci_nome limit $from,40";
	}

	$result3 = mysql_query($query3,$con) or die ("erro 126");
	$numrows3 = mysql_num_rows($result3);
	if($numrows3 > 0){
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor3"); ?>" border="0" cellspacing="1" width=600>
<tr>
<td bgcolor="#<?php print("$barra_lat"); ?>" colspan="3" class="style2" align="center"><b>Relação de Cidades</b></td>
</tr>
<tr><td bgcolor="#<?php print("$barra_lat"); ?>" colspan="3">
<p align="center">
<a href="p_insert_cidade.php" class=style2>Cadastrar nova cidade</a></td></tr>
<tr><td bgcolor="#ffffff" align="center" class=style7 colspan="3">
Para alterar ou excluir uma cidade, clique sobre o nome correspondente a seguir.</b>
</td></tr>
    <form method="post">
  <tr>
      <td colspan=3 bgcolor="#<?php print("$cor3"); ?>" class="style2">Pesquisar cidade:</td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" class="style2" align="right"><b>Palavra chave:</b></td>
      <td colspan="2" bgcolor="#ffffff"> <input type="text" name="chave" size="15" class=campo> <input type="submit" value="Pesquisar" name="B1" class=campo></td>
    </tr>
      <input type="hidden" value="1" name="pesq">
      <input type="hidden" value="0" name="screen">
    </form>
<tr>
<td width=290 bgcolor="#ffffff" align="center" class="style2"><b>Cidade</td>
<td width=197 bgcolor="#ffffff" align="center" class="style2"><b>Estado</td>
<td width=103 bgcolor="#ffffff" align="center" class="style2"><b>Litor&acirc;nea?</b></td>
</tr>
<?php
	$i = 1;
	
	while($not3 = mysql_fetch_array($result3))
	{
	$from = $from + 1;
	
		if (($i % 2) == 1){ $fundo="$cor6"; }else{ $fundo="ffffff"; }
		$i++;
		
	if($not3[ci_litoranea]=='1'){
	  $litoranea = "SIM";
	}else{
	  $litoranea = "NÃO";
	}	
		
?>
<tr>
<td bgcolor="<?php print("$fundo"); ?>" align="left">
<a href="p_cidades.php?lista=1&ci_cod=<?php print("$not3[ci_cod]"); ?>" class="style2">
<?php print("$not3[ci_nome]"); ?></a></td>
<td align="left" bgcolor="<?php print("$fundo"); ?>">
<a href="p_cidades.php?lista=1&ci_cod=<?php print("$not3[ci_cod]"); ?>" class="style2">
<?php print("$not3[e_nome]"); ?></a></td>
<td align="left" bgcolor="<?php print("$fundo"); ?>">
<a href="p_cidades.php?lista=1&ci_cod=<?php print("$not3[ci_cod]"); ?>" class="style2">
<?php print($litoranea); ?></a></td>
</tr>
<?php
	}
	if($pesq == ""){
	$query3 = "select count(ci_cod) as contador 
	from rebri_cidades";
	}
	else
	{
	$query3 = "select count(ci_cod) as contador from rebri_cidades where ci_nome like '%$chave%'";
	}
	$result3 = mysql_query($query3,$con) or die("erro 196");
	
	while($not3 = mysql_fetch_array($result3))
	{
	$pages = ceil($not3[contador] / 30);
?>
                  <tr><td colspan=6 bgcolor="#<?php print("$cor3"); ?>" class="style2">
                  <p align="center">
                  <i>Foram encontradas <?php print("$not3[contador]"); ?> cidades</i></td></tr>
                  <tr><td colspan=6 bgcolor="#ffffff" class=style2>
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
  	$url2 = $PHP_SELF . "?screen=" . $j . "&chave=" . $chave . "&pesq=" . $pesq;
  	//echo "   | <a href=\"$url2\">$j</a> |   ";
  	if(((($screen - 5) < $j) and (($screen + 5) > $j)) or ($j == 0) or ($j == ($pages -1))){
  	if($j == $screen){
  	echo "   | <a href=\"$url2\" class=style7><b>$j</b></a> |   ";
		}elseif($j == 0){
  	echo "   | <a href=\"$url2\" class=style2><b>Primeira</b></a> |   ";
		}elseif($j == ($pages - 1)){
  	echo "   | <a href=\"$url2\" class=style2><b>Última</b></a> |   ";
		}
  	else
  	{
  	echo "   | <a href=\"$url2\" class=style2>$j</a> |   ";	
  	}
  	}
	}

	if ($from >= $not3[contador]) {
?>
		  <br>Última página da pesquisa
<?php
	}
	else
	{
	$url3 = $PHP_SELF . "?screen=" . ($screen + 1) . "&chave=" . $chave . "&pesq=" . $pesq;
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
	}
	else
	{
	$query2 = "select * from rebri_cidades	where ci_cod = '$ci_cod'";
	$result2 = mysql_query($query2,$con) or die("erro 264");
	while($not2 = mysql_fetch_array($result2))
	{

if(!IsSet($editar))
	{
?>
<p align="center"><b>Rebri -- Editar ou Apagar Cidades</b></p>
 <div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <input class=campo type="hidden" name="ci_cod" value="<?php print("$not2[ci_cod]"); ?>">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td align="left" width="20%"><b>Cidade:</b></td>
      <td align="left" width="80%"> <input class=campo type="text" name="ci_nome" size="40" value="<?php print("$not2[ci_nome]") ?>"></td>
    </tr>
    <tr>
      <td align="left" width="20%"><b>Estado:</b></td>
      <td align="left" width=80%> <select name="ci_estado" class=campo>
<option value="0">Selecione o Estado</option>
<?
//require_once("conecta.php");
$sql = "SELECT e_cod, e_uf, e_nome FROM rebri_estados ORDER BY e_nome";
$sql = mysql_query($sql,$con) or die ("erro 288");
$row = mysql_num_rows($sql); 

	while($not4 = mysql_fetch_array($sql))
	{
?>
<?php
	if($not4[e_cod] == $not2[ci_estado]){
		$estado_atual = $not4[e_nome];
?>
		       <option selected value="<? echo $not4[e_cod]."|".$not4[e_uf]; ?>">
			   <? echo $not4[e_nome]; ?></option>
<?php
	}
	else
	{
?>
		       <option value="<? echo $not4[e_cod]."|".$not4[e_uf]; ?>">
			   <? echo $not4[e_nome]; ?></option>
<?php
	}
?>
		    <? } ?>
	     </select></td>
    </tr>
    <tr>
      <td align="left" width="20%"><b>Cidade litorânea?</b></td>
      <td align="left" width="80%"><input name="ci_litoranea" type="checkbox" id="ci_litoranea" value="1" <? if($not2[ci_litoranea]=='1'){ print "CHECKED"; } ?>> Sim</td>
    </tr>    
    <tr>
      <td colspan="2"> <input class=campo type="hidden" value="1" name="editar"><input class=campo type="submit" value="Atualizar Cidade" name="B1"> <input class=campo type="submit" value="Apagar Cidade" name="B1">      </td>
      </tr>
  </table>
  </center></div>
  </form>
<?php
if($bairro == 1){
	
    if($B1 == "Cadastrar Bairro")
	{
	
	$query4 = "select * from rebri_bairros where b_nome='$b_nome' and b_cidade='$ci_cod'";
	$result4 = mysql_query($query4,$con) or die ("erro 330");
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 == 0){
	
	$b_nome = ucwords(strtolower($b_nome));
	
	$query0 = "insert into rebri_bairros (b_nome, b_cidade, b_loja) values('$b_nome', '$ci_cod','".$_POST['loja']."')";
	$result0 = mysql_query($query0,$con) or die("Não foi possível inserir suas informações.");
    mysql_query($query0, $con_site);
    mysql_query($query0, $con_sistema);

?>
<span class="style7">
Você inseriu um novo Bairro.</span>
<?php
	}
	else
	{
?>
<span class="style7">
Este bairro já está cadastrado nesta cidade.</span>
<?
	}
	}
?>
<?php
    if($B1 == "Apagar Bairro")
	{
	$query4 = "select * from muraski where bairro like '-$b_cod-'";
	$result4 = mysql_query($query4,$con) or die ("erro 360");
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
		echo "<a class=style7><b>Este bairro não pode ser apagado pois existem imóveis ligados a ele.</b></a>";
	}else{
			
	$query = "delete from rebri_bairros where b_cod = '$b_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível apagar suas informações.");
    mysql_query($query, $con_site);
    mysql_query($query, $con_sistema);

?>
<span class="style7">
Você apagou o Bairro <i><?php print("$b_nome"); ?></i>.</span>
<?php
	}
	}
    if($B1 == "Atualizar Bairro")
    {
	  $query4 = "select * from rebri_bairros where b_nome='$b_nome' and b_cidade='$ci_cod'";
	  $result4 = mysql_query($query4,$con) or die ("erro 381");
	  $numrows4 = mysql_num_rows($result4);
	  if($numrows4 == 0)
      {
	  
	    $b_nome = ucwords(strtolower($b_nome));

	    $query = "update rebri_bairros set b_nome='$b_nome' where b_cod='$b_cod'";
        $result = mysql_query($query,$con) or die("Não foi possível atualizar suas informações.");
        mysql_query($query, $con_site);
        mysql_query($query, $con_sistema);

?>
<span class="style7">
Você atualizou o Bairro <i><?php print("$b_nome"); ?></i>.</span>
<?php
	  }
	  else
	  {
        $alterou_loja = 0;
        while($not_loja = mysql_fetch_array($result4))
        {
            if($not_loja['b_cod'] == $b_cod){
            	$queryloja = "update rebri_bairros set b_loja = '".$_POST['loja2']."' where b_cod='$b_cod'";
                $resultloja = mysql_query($queryloja,$con) or die("Não foi possível atualizar suas informações.");
                $alterou_loja = 1;
            }
        }
        if($alterou_loja > 0){
?>
<span class="style7">
Você atualizou o Bairro <i><?php print("$b_nome"); ?></i>.</span>
<?php
        }else{
?>
<span class="style7">
Este bairro já está cadastrado nesta cidade.</span>
<?
        }
	  }
	}

    }//if bairro==1
	
	if($bairro_lista == ""){
	$query3 = "select * from rebri_bairros where b_cidade like '$ci_cod' order by b_nome";
	$result3 = mysql_query($query3,$con) or die ("erro 411");
	$numrows3 = mysql_num_rows($result3);
?>
<div align="center">
  <center>
<table bgcolor="#<?php print("$cor3"); ?>" border="0" cellspacing="0" width=600 align="left">
<?
	if($numrows3 > 0){
?>
<tr>
<td bgcolor="#<?php print("$barra_lat"); ?>" colspan="2" class="style2" align="center"><b>Relação de Bairros</b></td>
</tr>
<tr><td bgcolor="#ffffff" align="center" class=style7 colspan="2">
Para alterar ou excluir um bairro, clique sobre o nome correspondente a seguir.</b>
</td></tr>
<tr>
<td bgcolor="#ffffff" align="center" class="style2" colspan="2"><b>Bairro</td>
</tr>
<?php
	$i = 1;
	
	while($not3 = mysql_fetch_array($result3))
	{
	$from = $from + 1;
	
		if (($i % 2) == 1){ $fundo="$cor6"; }else{ $fundo="ffffff"; }
		$i++;
?>
<tr>
<td bgcolor="<?php print("$fundo"); ?>" align="left" style="border-right:0px;">
<a href="p_cidades.php?lista=1&bairro_lista=1&ci_cod=<?php print("$ci_cod"); ?>&b_cod=<?php print("$not3[b_cod]"); ?>" class="style2" style="width:300px; display:block;">
<?php print("$not3[b_nome]"); ?> </a>

<td bgcolor="<?php print("$fundo"); ?>" align="left" style="border-left:0px;"> <div class="style2"  style="width:300px;"> <?php echo ($not3[b_loja]=='') ? "Matriz" : "Filial" ?> </div></td>

</td>
</tr>
<?php
	}
	$query3 = "select count(b_cod) as contador from rebri_bairros where b_cidade='$ci_cod'";
	$result3 = mysql_query($query3,$con) or die ("erro 448");
	
	while($not3 = mysql_fetch_array($result3))
	{
	$pages = ceil($not3[contador] / 30);
?>
                  <tr><td colspan=2 bgcolor="#<?php print("$cor3"); ?>" class="style2">
                  <p align="center">
                  <i>Foram encontrados <?php print("$not3[contador]"); ?> bairros</i></td></tr>
<?php
	}
?>
<?php
	}
?>
    </table>
    <br>
    <table bgcolor="#<?php print("$cor3"); ?>" border="0" cellspacing="0" width=600 align="left">
    <form method="post">
    <input class=campo type="hidden" name="ci_cod" value="<?php print("$ci_cod"); ?>">
    <tr>
      <td colspan=2 bgcolor="#<?php print("$cor3"); ?>" class="style2"><b>Cadastrar bairro:</b></td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" class="style2" align="left"  width="100%"><b>Nome:</b>
      <input type="text" name="b_nome" size="15" class="campo">
      <b>Localizado na </b>
      <select name="loja" class=campo>
      <option value="0" selected="selected" >Selecione a Loja</option>
      <option value="">Matriz</option>
      <option value="F">Filial</option>
      </select>
      </td>
    </tr>
      <tr>
        <td style="align:right; width:400;">
          <input type="submit" value="Cadastrar Bairro" name="B1" class=campo>
        </td>
      </tr>
      <input type="hidden" value="1" name="bairro">
      <input type="hidden" value="1" name="lista">
    </form>
</table>
<?php
	}//bairro_lista
	else
	{

	$query2 = "select * from rebri_bairros where b_cod = '$b_cod'";
	$result2 = mysql_query($query2,$con) or die ("erro 482");
	while($not2 = mysql_fetch_array($result2))
	{
?>
<p align="center"><b>Editar ou Apagar Bairros</b></p>
 <div align="center">
  <center>
  <form method="post" action="<?php print("$PHP_SELF"); ?>">
  <input class=campo type="hidden" name="ci_cod" value="<?php print("$ci_cod"); ?>">
  <input class=campo type="hidden" name="b_cod" value="<?php print("$not2[b_cod]"); ?>">
  <input type="hidden" value="1" name="bairro">
  <input type="hidden" value="1" name="lista">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td align="left" width="10%"><b>Bairro:</b></td>
      <td align="left" width="90%"> <input class=campo type="text" name="b_nome" size="40" value="<?php print("$not2[b_nome]") ?>"></td>
    </tr>
    <tr>
      <td align="left" width="10%"><b>Localizado na </b></td>
      <td align="left" width=80%>
      <select name="loja2" class=campo>
      <option <?php echo ($not2['b_loja']=="") ? 'selected="selected"' : ''; ?> value="">Matriz</option>
      <option <?php echo ($not2['b_loja']=="F") ? 'selected="selected"' : ''; ?> value="F">Filial</option>
      </select></td>
    </tr>
    <tr>
      <td width="10%"> <input class=campo type="submit" value="Atualizar Bairro" name="B1"></td>
      <td width="50%"> <input class=campo type="submit" value="Apagar Bairro" name="B1">
      </td>
    </tr>
  </table>
  </center></div>
  </form>
<?
	}
	}
?>
<?php
	}
	}
	}
?>
<?php
include("carimbo.php");
mysql_close($con);
mysql_close($con_site);
mysql_close($con_sistema);
?>
</td></tr></table>
</body>
</html>
