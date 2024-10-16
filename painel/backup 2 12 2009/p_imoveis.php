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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
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
?>
<?php
   $imob = $_SESSION['i_imob'];
    function trocaini($wStr,$w1,$w2) { 
        $wde = 0; 
        $para=0; 
    while($para<1) { 
        $wpos = strpos($wStr, $w1, $wde); 
        if ($wpos > 0) { 
            $wStr = str_replace($w1, $w2, $wStr); 
            $wde = $wpos+1; 
        } else { 
            $para=2; 
        } 
    } 
    $trocou = $wStr; 
    return $trocou; 
    }
    
    function altaebaixa($umtexto) { 
        $troca = strtolower($umtexto); 
        $troca = ucwords($troca); 
        $troca = trocaini($troca, " E ", " e "); 
        $troca = trocaini($troca, " De ", " de "); 
        $troca = trocaini($troca, " Da ", " da "); 
        $troca = trocaini($troca, " Do ", " do "); 
        $troca = trocaini($troca, " Das ", " das "); 
        $troca = trocaini($troca, " Dos ", " dos "); 
        $troca = trocaini($troca, "Ã", "ã");
        $troca = trocaini($troca, "Á", "á");
        $troca = trocaini($troca, "À", "à");
        $troca = trocaini($troca, "Â", "â");
        $troca = trocaini($troca, "Ç", "ç");
        $troca = trocaini($troca, "Ó", "ó");
        $troca = trocaini($troca, "Õ", "õ");
        $troca = trocaini($troca, "É", "é");
        $troca = trocaini($troca, "Ê", "ê");
        $troca = trocaini($troca, "Í", "í");
         
        $altabaixa = $troca; 
        return $altabaixa; 
     
    }
    
/*if($B1 == "Inserir Imóvel"){
	
	$query0 = "select i_ref from imoveis where i_ref='$i_ref'";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	if($numrows == 0){
		
	if(($i_tipo == "") and ($novo_tipo != "")){
		
	$query0 = "select t_nome from tipo where t_nome='$novo_tipo'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 == 0){
		
	$query1 = "insert into tipo (t_nome) values('$novo_tipo')";
	$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.(Local)");
	
	}
	
	$i_tipo = $novo_tipo;
	
	}

	if(($local == "") and ($novo_local != "")){
		
	$query0 = "select l_nome from localizacao where l_nome='$novo_local'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 == 0){
		
	$query1 = "insert into localizacao (l_nome) values('$novo_local')";
	$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.(Local)");
	
	}
	
	$local = $novo_local;
	
	}
	
	//$c_nome = altaebaixa($c_nome);
	$query = "insert into imoveis (i_ref, i_tipo, i_metragem, i_n_quartos, i_valor
	, i_suites, i_titulo, i_descricao, i_conteudo, i_acomod, i_finalidade, i_imob) 
	values('$i_ref', '$i_tipo', '$i_metragem', '$i_n_quartos', '$i_valor', '$i_suites'
	, '$i_titulo', '$i_descricao', '$i_conteudo', '$i_acomod', '$i_finalidade', '$imob')";
	//echo $query;
	$result = mysql_query($query) or die("Não foi possível inserir suas informações.(Imóvel)");
?>
      <p align="center"><b>Você cadastrou o imóvel ref.: <?php print("$i_ref"); ?>.
<?php
	}
	else
	{
?>
      <p align="center"><b>A ref.: <?php print("$i_ref"); ?> já está cadastrada.</b>
<?php
	}
?>
<?php
	}*/
if($B1 == "Apagar Imóvel")
	{
	
	$query4 = "select * from rebri_imoveis where i_cod='$i_cod' and i_imob='$imob'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{
		
	for ($i = 0; $i < 41; $i++) {
	$foto = $not4[i_ref] . "_" . ($i) . ".jpg";
	$foto2 = $not4[i_ref] . "_1_des.jpg";
	if (file_exists("/home/httpd/htdocs/rebricbr/img_not/$foto"))
	{
	unlink("/home/httpd/htdocs/rebricbr/img_not/$foto");
	}
	}

	if (file_exists("/home/httpd/htdocs/rebricbr/img_dest/$foto2"))
	{
	unlink("/home/httpd/htdocs/rebricbr/img_dest/$foto2");
	}
	
	}
	}
	$query = "delete from rebri_imoveis where i_cod = '$i_cod' and i_imob='$imob'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
<p align="center">
Você apagou o imóvel Ref.: <i><?php print("$i_ref"); ?></i>.</p>
<?php
	}
if($B1 == "Atualizar Imóvel")
	{
		
	if(($i_tipo == "") and ($novo_tipo != "")){
		
	$query0 = "select t_nome from rebri_tipo where t_nome='$novo_tipo'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 == 0){
		
	$query1 = "insert into rebri_tipo (t_nome) values('$novo_tipo')";
	$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.(Local)");
	
	}
	
	$i_tipo = $novo_tipo;
	
	}
		
	/*if(($local == "") and ($novo_local != "")){
		
	$query0 = "select l_nome from localizacao where l_nome='$novo_local'";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 == 0){
		
	$query1 = "insert into localizacao (l_nome) values('$novo_local')";
	$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.");
	
	}
	
	$local = $novo_local;
	
	}*/
	
	$query = "update rebri_imoveis set i_ref='$i_ref', i_tipo='$i_tipo', i_metragem='$i_metragem'
	, i_n_quartos='$i_n_quartos', i_valor='$i_valor', i_suites='$i_suites', i_titulo='$i_titulo'
	, i_descricao='$i_descricao', i_destaque='$i_destaque', i_conteudo='$i_conteudo'
	, i_acomod='$i_acomod', i_finalidade='$i_finalidade' where i_cod='$i_cod' and i_imob='$imob'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
<p align="center">
Você atualizou o imóvel Ref.: <i><?php print("$i_ref"); ?></i>.</p>
<?php
	}

if($lista == "")
	{
		
	$query1 = "select distinct i_cod, i_tipo, i_ref , i_finalidade	from rebri_imoveis where i_imob='$imob' order by i_tipo";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<div align="center">
  <center>
                  <table width="500">
                  <tr><td colspan="4" bgcolor="#<?php print("$cor5"); ?>">
                  <p align="center">
                  Estes são os imóveis cadastrados até o momento</td></tr>
                  <tr><td>
                  <b>Tipo</b></td><td>
                  <b>Referencia</b></td><td>
                  <b>Finalidade</b></td></tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{

	if (($i % 2) == 1){ $fundo="DCE0E4"; }else{ $fundo="EDEEEE"; }
	$i++;
?>
<tr bgcolor="<?php print("$fundo"); ?>"><td>
<a href="p_imoveis.php?i_cod=<?php print("$not[i_cod]"); ?>&edit=editar&lista=1" class=linkm>
<?php print("$not[i_tipo]"); ?></a></td><td class=style2>
<a href="p_imoveis.php?i_cod=<?php print("$not[i_cod]"); ?>&edit=editar&lista=1" class=linkm><?php print("$not[i_ref]"); ?></a></td><td class=style2>
<a href="p_imoveis.php?i_cod=<?php print("$not[i_cod]"); ?>&edit=editar&lista=1" class=linkm><?php print("$not[i_finalidade]"); ?></a></td></tr>
<?php
	}

	$query3 = "select count(i_cod) as q_cod from rebri_imoveis";
	$result3 = mysql_query($query3);
	
	while($not3 = mysql_fetch_array($result3))
	{
?>
                  <tr><td colspan="4" bgcolor="#<?php print("$cor5"); ?>">
                  <p align="center">
                  Total de <b><?php print("$not3[q_cod]"); ?></b> imóveis.</td></tr>
	</table>
	</center>
	</div>
<?php
	}
	}
mysql_close($con);
?>
<?php
	}
	else
	{
?>
<?php
	if($edit == "editar"){
	$query2 = "select * from rebri_imoveis where i_cod = '$i_cod' and i_imob='$imob'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{

if(!IsSet($editar))
	{
?>
 <div align="center">
  <center>
<script>
function valida()
{
  if (form1.i_tipo.value == "")
  {
    if (form1.novo_tipo.value == "")
  	{
	alert("Por favor, digite o Tipo");
    form1.i_tipo.focus();
    return (false);
	}
  }
  if (form1.i_ref.value == "")
  {
    alert("Por favor, digite a Referência");
    form1.i_ref.focus();
    return (false);
  }
  if (form1.i_metragem.value == "")
  {
    alert("Por favor, digite a Metragem");
    form1.i_metragem.focus();
    return (false);
  }
  if (form1.i_valor.value == "")
  {
    alert("Por favor, digite o Valor");
    form1.i_valor.focus();
    return (false);
  }
  if (form1.i_titulo.value == "")
  {
    alert("Por favor, digite o Título");
    form1.i_titulo.focus();
    return (false);
  }
  if (form1.i_descricao.value == "")
  {
    alert("Por favor, digite a Descrição");
    form1.i_descricao.focus();
    return (false);
  }
  if (form1.i_finalidade.value == "")
  {
    alert("Por favor, digite a Finalidade");
    form1.i_finalidade.focus();
    return (false);
  }
	return(true);
}
</script>
  <form method="post" name="form1" onSubmit="return valida();" action="p_imoveis.php">
  <input type="hidden" value="1" name="editar">
  <input type="hidden" value="<?php print("$not2[i_cod]"); ?>" name="i_cod">
  <table border="0" cellspacing="1" width="100%">
  	<tr>
  	  <td width="70%"><table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="20%">Tipo:</td>
      <td width="80%" colspan=3><select size="1" name="i_tipo" class="campo">
      <option selected value="<?php print("$not2[i_tipo]"); ?>"><?php print("$not2[i_tipo]"); ?></option>
    <option value="">Novo tipo</option>
<?php
	$query3 = "select * from rebri_tipo order by t_nome";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	if($numrows3 > 0){
	while($not3 = mysql_fetch_array($result3))
	{
?>
    <option value="<?php print("$not3[t_nome]"); ?>"><?php print("$not3[t_nome]"); ?></option>
<?php
	}
	}
?>
  </select> <input type="text" name="novo_tipo" size="20" class="campo"> <a href="javascript:;" onClick="MM_openBrWindow('p_exc_tipo.php','','scrollbars=yes,resizable=no,width=400,height=200')" class=style2>Excluir Tipo</a>  <?php print("$falt_tipo"); ?></td>
    </tr>
    <tr>
      <td width="20%">Ref.:&nbsp;</td>
      <td width="80%"> <input type="text" name="i_ref" size="6" class="campo" value="<?php print("$not2[i_ref]"); ?>"> Exemplo:
        101-a  <?php print("$falt_ref"); ?></td>
    </tr>
    <tr>
      <td width="20%">Metragem:</td>
      <td width="80%"> <input type="text" name="i_metragem" size="10" class="campo" value="<?php print("$not2[i_metragem]"); ?>"> Exemplo: 100.00 ou 100  <?php print("$falt_metragem"); ?></td>
    </tr>
    <tr>
      <td width="20%">N° de
        quartos:</td>
      <td width="80%"><input type="text" name="i_n_quartos" size="10" class="campo" value="<?php print("$not2[i_n_quartos]"); ?>"> Exemplo: 1</td>
    </tr>
    <tr>
      <td width="20%">Valor:</td>
      <td width="80%"><input type="text" name="i_valor" size="10" class="campo" value="<?php print("$not2[i_valor]"); ?>"> Exemplo:
        50000.00 ou 50000  <?php print("$falt_valor"); ?></td>
    </tr>   
    <tr>
      <td width="20%">Suítes:</td>
      <td width="80%"><input type="text" name="i_suites" size="10" class="campo" value="<?php print("$not2[i_suites]"); ?>"> Exemplo:
        1</td>
    </tr>
    <tr>
      <td width="20%">Título: </td>
      <td width="80%"> <textarea rows="2" name="i_titulo" cols="36" class="campo"><?php print("$not2[i_titulo]"); ?></textarea>  <?php print("$falt_titulo"); ?></td>
    </tr>
    <tr>
      <td width="20%">Descrição:</td>
      <td width="80%"> <textarea rows="5" name="i_descricao" cols="36" class="campo"><?php print("$not2[i_descricao]"); ?></textarea>  <?php print("$falt_descricao"); ?></td>
    </tr>
    <tr>
      <td width="20%">Conteúdo do imóvel:</td>
      <td width="80%"> <textarea rows="5" name="i_conteudo" cols="36" class="campo"><?php print("$not2[i_conteudo]"); ?></textarea></td>
    </tr>
	<tr>
      <td width="20%">Acomodações:</td>
      <td width="80%"> <textarea rows="5" name="i_acomod" cols="36" class="campo"><?php print("$not2[i_acomod]"); ?></textarea></td>
    </tr>
    <tr>
      <td width="20%">Finalidade:</td>
      <td width="80%"><select size="1" name="i_finalidade" class="campo">
    <option value="<?php print("$not2[i_finalidade]"); ?>"><?php print("$not2[i_finalidade]"); ?></option>
    <option value="">Selecione uma opção</option>
	<option value="Venda">Venda</option>
    <option value="Locação">Locação</option>
        </select> <?php print("$falt_finalidade"); ?>
      </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
	  <tr>
      <td>
      <input class=campo type="submit" value="Atualizar Imóvel" name="B1"></td>
      <td>
      <input class=campo type="submit" value="Apagar Imóvel" name="B1"></td>
    </tr>
    <tr>
      <td colspan="2">
      <p align="center"><a href="javascript:history.back()" class=linkm><< Voltar <<</a></p></td>
    </tr>
  </table>
  </td>
  <td width="30%" valign="top"><table border="0" cellspacing="1" width="100%" bgcolor="#<?php print("$cor3"); ?>">
  		<tr bgcolor="#<?php print("$cor3"); ?>">
  			<td align="center"><b>Informações</b></td>
  		</tr>
  		<tr bgcolor="#<?php print("$cor1"); ?>">
<?php
	$j=0;
	for ($i = 0; $i < 31; $i++) {
	$foto = $not2[i_ref] . "_" . ($i) . ".jpg";
	
	if (file_exists("/home/httpd/htdocs/rebricbr/img_not/$foto"))
	{
	$j++;
  }
  }
?>
  			<td class=style2><br>Existem <b><?php print("$j");?> fotos</b> cadastradas para este imóvel.<br><br><a href="p_fotos.sphp?i_cod=<?php print("$i_cod");?>" class=linkm><b>Clique aqui</b></a> para gerenciar as foto.</td>
  		</tr>
  		<tr bgcolor="#<?php print("$cor1"); ?>">
<?php
  $ano2 = date(Y);
  $mes2 = date(m);
  $quant = 0;

	$query4 = "select * from rebri_stats where s_imovel='$i_cod' and
	month(s_data)='$mes2' and s_tipo='detalhes' and year(s_data)='$ano2'";
	$result4 = mysql_query($query4);
	//echo $query3;
	while($not4 = mysql_fetch_array($result4))
	{
		$quant = $quant + $not4[s_qtd];
	}
?>
  			<td class=style2><br>Este imóvel teve <b><?php print("$quant"); ?> acessos neste mês</b>.<br><br>
  				<a href="p_stats_imoveis.php?cod=<?php print("$not2[i_cod]"); ?>" class=linkm><b>Clique aqui</b></a> para visualizar as estátiscicas.</td>
  		</tr>
  	</table>
  </td>
</tr>
</table>

  </form>
<?php
	}
	}
	}
mysql_close($con);
?>
<?php
	}
?>
<?php
include("carimbo.php");
//mysql_close($con);
?>
</td></tr></table>
</body>
</html>