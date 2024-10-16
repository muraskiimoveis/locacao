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
<body>
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
	($u_tipo == "admin")){
*/	  
?>
<p>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="600" bgcolor="#DCE0E4">
  <tr bgcolor="#ffffff"><td colspan=2>
 <p align="center"><font color="Blue" size="2" face="Arial"><b>Inserir Texto de Documentos</b></font><br>
 <font color="#34498F" size="2" face="Arial"><a href="p_doc.php">
 Clique para visualizar a relação de Documentos cadastrados</a></font></p></td></tr>
 <div align="center">
  <center>
<script language="javascript">
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
  <form method="post" name="form1" onSubmit="return valida();" action="p_doc.php">
    <tr bgcolor="#EDEEEE">
      <td width="20%"><font color="#000080" size="2" face="Arial"><b>Nome:</b></font></td>
      <td width="80%"><font color="#000080" size="2" face="Arial"> <input type="text" name="d_nome" size="40" class="campo"></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="100%" colspan=2 valign="top"><font color="#000080" size="2" face="Arial"><b>Texto do documento:</b></font></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td width="100%" colspan=2><font color="#000080" size="2" face="Arial"><textarea rows="15" name="d_txt" cols="80" class="campo"></textarea></font></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td width="20%"><font color="#035E01" size="2" face="Arial">
      <input type="submit" value="Inserir Documento" name="B1" class="campo3"></font></td>
      <td width="80%"></td>
    </tr>
  </form>
</table>
</div></center>
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