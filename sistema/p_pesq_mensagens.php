<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("MENSAGENS_GERAL");
?>
<html>
<head>
<?php
include("style.php");
?>
<script language="javascript">
function VerificaCampo()
{

       if(document.form1.chave.value.length==0)
	   {
		       alert("Por favor, preencha o campo Palavra Chave");
    		   document.form1.chave.focus();
    		   return false;
       }
       if (document.form1.campop.selectedIndex == 0)
	   {
		       alert("Por favor, selecione o campo Campo de pesquisa");
    		   document.form1.campop.focus();
    		   return false;
       }

document.form1.submit();
return true;

}
</script>
</head>
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
?></td>
  </tr>
</table>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/		
?>
<div align="center">
  <center>
  <form method="POST" name="form1" id="form1" action="p_envia_mensagem.php">
  <table border="0" cellspacing="1" width="75%">
    <tr height="50">
      <td colspan=2 class="style1"><p align="center"><b>Mensagens</b><br>Preencha a Palavra chave e selecione o campo de pesquisa.</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Palavra Chave:</b></td>
      <td width="80%" class="style1"><input type="text" class="campo" name="chave" size="40"></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Campo de pesquisa:</b></td>
      <td width="80%" class="style1"><select name="campop" class="campo">
      <option value="">Selecione</option>
	  <option value="1">Nome da Imobiliária </option>
      <option value="2">Nome do Usuário</option>
      <option value="3">Sigla do Estado (Ex: PR)</option>
      <option value="4">Nome da Cidade</option>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td colspan="2" class="style1"><div align="center"><a href="p_envia_mensagem.php?todos=1" class="style1"><b>Enviar para todos da rede</b></a></div></td>
    </tr>
    <tr>
      <td colspan=2>
      <input type="button" value="Pesquisar" name="B1" class="campo3" Onclick="VerificaCampo();"></td>
    </tr>
  </table>
  </form>
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