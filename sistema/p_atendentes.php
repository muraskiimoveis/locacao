<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_ATENDENTES");
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
<script language="javascript">
function formulario(){

   	document.form1.acao.value = 1;
}
</script>
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
<?php

if($_POST['acao']=='1')
{
         
   		$i = $_POST['i'];
  		$c = 0;

		for($j = 0; $j <= $i; $j++)
		{	     
		
     		$locacoes = "locacao_".$j;
     		$locacao = $_POST[$locacoes];
     		$vendas = "venda_".$j;
     		$venda = $_POST[$vendas];
     		$telefones = "telefone_".$j;
     		$telefone = $_POST[$telefones];
     		$emails = "email_".$j;
     		$email = $_POST[$emails];
     		$codigos = "corretor_".$j;
     		$corretor = $_POST[$codigos];
     		$botoes = "alterar_".$j;
     		$botao = $_POST[$botoes];

	    	if($botao)
	    	{
    			$c++;
    			$query2 = "select * from atendimento where a_corretor='$corretor' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
				$result2 = mysql_query($query2);
				$numrows2 = mysql_num_rows($result2);
				if($numrows2 == 0){
					$query = "insert into atendimento (cod_imobiliaria, a_corretor, a_data_venda, a_vendas, a_locacao, a_data_locacao, a_telefone, a_data_telefone,a_email,a_data_email) values('".$_SESSION['cod_imobiliaria']."','$corretor', current_timestamp, '$venda', '$locacao', current_timestamp, '$telefone', current_timestamp, '$email', current_timestamp)";
					$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
    			}else{
    				$query4= "update atendimento set a_data_venda=current_timestamp, a_locacao='$locacao', a_vendas='$venda', a_data_locacao=current_timestamp, a_telefone='$telefone', a_data_telefone=current_timestamp, a_email='$email', a_data_email=current_timestamp where a_corretor='$corretor' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
					$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");			
				}
    		} 	
		} 

}

if($B1 == "Inserir Atendente")
	{
	
	$query2 = "select * from atendimento where a_corretor='$a_corretor' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 == 0){
	
	$query = "insert into atendimento (cod_imobiliaria, a_corretor, a_data) 
	values('".$_SESSION['cod_imobiliaria']."','$a_corretor', current_timestamp)";
	$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
?>
Você inseriu um novo atendente: <i><?php print("$a_corretor"); ?>.
<?php
	}
	else
	{
?>
Este atendente já está ativo: <i><?php print("$a_corretor"); ?>.
<?php
	}
	}
if($B1 == "Apagar Atendente")
	{

	$query = "delete from atendimento where a_corretor = '$a_corretor' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
?>
Você apagou um atendente <i><?php print("$a_corretor"); ?></i>.
<?php
	}
if($B1 == "Atualizar Atendente")
	{

	$query = "update atendimento set a_data=current_timestamp where a_cod='$a_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
?>
Você atualizou a data do atendente <i><?php print("$a_corretor"); ?></i>.
<?php
	}
	
	$query1 = "select * from usuarios where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and u_status='Ativo' order by u_nome";
	$result1 = mysql_query($query1);
?>

<form name="form1" id="form1" action="<?php print("$PHP_SELF"); ?>" method="POST">
<input type="hidden" id="acao" name="acao" value="0">
<div align="center">
  <center>
<table width="76%" border="0" cellpadding="0" cellspacing="1">
<tr height="50">
  <td colspan=5 align="center" class="style1">
  	<p align="center"><b>Atendentes</b><br>Para acrescentar/retirar um corretor no atendimento rotativo selecione ou deselecione as opções venda ou locação e clique em alterar.</b></p>
  </td>
</tr>
<tr class="fundoTabelaTitulo" height="20px;">
	<td width="27%" class="style1" align="center"><b>Nome do usuário</b></td>
	<td width="25%" class="style1" align="center"><b>E-mail</b></td>
	<td width="40%" class="style1" align="center"><b>Acrescentar/ Retirar</b></td>
	<td width="8%" class="style1" align="center"><b>Status</b></td>
</tr>
<?php
    $i = 0;
	$x = 0;
	while($not = mysql_fetch_array($result1))
	{
	
	if (($x % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$x++;
?>
<tr class="<?php print("$fundo"); ?>">
<td align="left" class="style1"><b>
<?php print("$not[u_nome]"); ?></td>
<td align="left" class="style1">
<?php print("$not[u_email]"); ?></td>
<?php
$query10 = "select * from atendimento where a_corretor='".$not['u_cod']."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
$result10 = mysql_query($query10);
$numrows10 = mysql_num_rows($result10);
while($linha = mysql_fetch_array($result10)){
    	$cvendas = $linha['a_vendas'];
    	$clocacao = $linha['a_locacao'];
    	$ctelefone = $linha['a_telefone'];
    	$cemail = $linha['a_email'];
}
?>
<td align="center" class="style1">
<input type="checkbox" name="venda_<?php echo($i);?>" id="venda_<?php echo($i);?>" value="1" <?php if($numrows10 > 0){ if($cvendas=='1'){ echo("CHECKED"); }} ?>>Venda
<input type="checkbox" name="locacao_<?php echo($i);?>" id="locacao_<?php echo($i);?>" value="1" <?php if($numrows10 > 0){ if($clocacao=='1'){ echo("CHECKED"); }} ?>>Locação
<input type="checkbox" name="telefone_<?php echo($i);?>" id="telefone_<?php echo($i);?>" value="1" <?php if($numrows10 > 0){ if($ctelefone=='1'){ echo("CHECKED"); }} ?>>Telefone
<input type="checkbox" name="email_<?php echo($i);?>" id="email_<?php echo($i);?>" value="1" <?php if($numrows10 > 0){ if($cemail=='1'){ echo("CHECKED"); }} ?>>Email
<input type="hidden" id="corretor_<?php echo($i);?>" name="corretor_<?php echo($i);?>" value="<?php echo($not[u_cod]); ?>">
<input type="submit" id="alterar_<?php echo($i);?>" name="alterar_<?php echo($i);?>" value="Alterar" class="campo3" onClick="formulario()">
<!--a href="p_atendentes.php?lista=1&a_corretor=<?php print("$not[u_cod]"); ?>&B1=Inserir Atendente" class="style2">
Acrescentar</a></td>
<td align="center">
<a href="p_atendentes.php?lista=1&a_corretor=<?php print("$not[u_cod]"); ?>&B1=Apagar Atendente" class="style2">
Retirar</a--></td>
<td align="center" class="style1">
<?php
	$query2 = "select * from atendimento where a_corretor='$not[u_cod]' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
		if($not2['a_locacao']=='1' || $not2['a_vendas']=='1' || $not2['a_telefone']=='1' || $not2['a_email']=='1'){
?>
<span class="style7">
Ativo
</span>
<?php
    	}
	}
?></td>
<?php
    $i++;
	}
?>
<input type="hidden" id="i" name="i" value="<?php echo($i); ?>">
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
</form>
<?  if(session_is_registered("valid_user")){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-top: 20px;">
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
