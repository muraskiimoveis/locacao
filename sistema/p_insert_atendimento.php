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
if($_SESSION['u_cod'] == "")
{
	echo('<script language="javascript">alert("O campo corretor não veio carregado com seu usuário favor se deslogue e logue novamente no sistema para dar continuidade na inserção do atendimento");</script>');
	die();
} 
?>
<br />
 <div align="center">
  <center>
  <table border="0" cellpadding="1" cellspacing="1" width="75%">
    <tr height=50>
      <td colspan="2" align="center" class="style1"><b>Inserir Atendimento</b><br>
      Antes de fazer qualquer pesquisa é obrigatório cadastrar um atendimento</td>
    </tr>
<?php
	if(!IsSet($inserir1))
	{
?>
<script language="javascript">
function valida()
{
  if (document.form1.i_tipo.value == "")
  {
    alert("Por favor, selecione o Tipo");
    document.form1.i_tipo.focus();
    return (false);
  }
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
  if (document.form1.i_corretor.value == "")
  {
    alert("Por favor, selecione o Corretor");
    document.form1.i_corretor.focus();
    return (false);
  }
	return(true);
}
</script>
  <form method="post" name="form1" onsubmit="return valida();" action="<?php print("$PHP_SELF"); ?>">
  <input type="hidden" name="controle" id="controle" value="<?=$_GET['controle'] ?>">
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Tipo:</b></td>
      <td width="80%" class="style1"> <select name="i_tipo" class="campo">
    <option value="">Selecione uma opção</option>
    <? if($controle=='V'){ ?>
    <option value="comprar">Comprar</option>
    <option value="vender">Vender</option>
    <? }elseif($controle=='L'){ ?>
    <option value="alugar">Alugar</option>
    <? }else{ ?>
    <option value="comprar">Comprar</option>
    <option value="alugar">Alugar</option>
    <option value="vender">Vender</option>
    <? } ?>
        </select></td>
    </tr>
    <input type="hidden" name="i_tipo1" value=1>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Nome:</b></td>
      <td width="80%" class="style1"> <input type="text" name="i_nome" size="40" class="campo" value="<?php print("$i_nome"); ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Telefone:</b></td>
      <td width="80%" class="style1"><input type="text" name="i_tel" size="20" class="campo" value="<?php print("$i_tel"); ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>E-mail:</b></td>
      <td width="80%" class="style1"><input type="text" name="i_email" size="40" class="campo"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" valign="top" class="style1"><b>Observação:</b></td>
      <td width="80%" class="style1"><textarea rows="3" name="i_obs" cols="40" class="campo"></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Corretor:</b></td>
      <td width="80%" class="style1"> <select size="1" name="i_corretor" class=campo>
			<option value="">Selecione o corretor</option>
<?
			$corretores = mysql_query("SELECT u_cod, u_nome, u_email FROM usuarios WHERE u_cod='".$_SESSION['u_cod']."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_nome, u_email ASC");
 			while($linha = mysql_fetch_array($corretores)){
				if($linha['u_cod']==$_SESSION['u_cod']){
                    $corretor = $linha['u_email'];
	                $cadastrado = 1;
					echo('<option value="'.$linha['u_cod'].'" SELECTED>'.$linha['u_nome'].' - '.$linha['u_email'].'</option>');
				//}else{ 			   
					//echo('<option value="'.$linha['u_cod'].'">'.$linha['u_nome'].' - '.$linha['u_email'].'</option>');
				}
 			}

?>			
			

<?php
/*
	$query0 = "select * from usuarios where u_cod='".$_SESSION['u_cod']."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by u_email";
	$result0 = mysql_query($query0);
	$numrows0 = mysql_num_rows($result0);
	if($numrows0 > 0){
	while($not0 = mysql_fetch_array($result0))
	{
	if($valid_user == $not0[u_email]){
	$corretor = $not0['u_email'];

	$cadastrado = 1;
?>
<option selected value="<?php print($not0['u_cod']); ?>"><?php print($not0['u_nome']); ?> - <?php print($not0['u_email']); ?></option>
<?php
	}
?>
<?php
	//if(($valid_user == $not0[u_email]) or ($valid_user == "muraski@muraski.com") or ($valid_user == "paulo@bruc.com.br")){
?>
<!--option value="<?php print($not0['u_cod']); ?>"><?php print($not0['u_nome']); ?> - <?php print($not0['u_email']); ?></option-->
<?php
	//}
?>
<?php

	}
	}
*/	
?>
        </select></td>
    </tr>
    <tr>
      <td width="20%">
      <input type="hidden" value="1" name="inserir2">
      <input type="hidden" value="<?php print($url); ?>" name="url">
      <input type="hidden" value="<?php print($cod); ?>" name="cod">
      <input type="hidden" value="1" name="qtd">
      <input type="submit" value="Inserir Atendimento" name="B1" class=campo3></td>
      <td width="80%"></td>
    </tr>
  </form>
</table></div></center>
<?php
	}
?>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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