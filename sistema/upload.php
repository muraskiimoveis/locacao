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
<br>
<p align="center"><font color="#000080" size="2" face="Arial"><b>Enviar Arquivos do Sistema</b>
<br><br>
  <form action="processa.sphp" ENCtype="multipart/form-data" method="post"
name="form">
  <table border="0">
    <tr>
      <td width="33%">
        <p align="right"><font face="Verdana"
size="2"><b>Arquivo:</b></font></p>
      </td>
      <center>
      <td width="33%"><input type="file" name="func_file" size="20"></td>
      <td width="34%"><input type="submit" value="Processar"
name="btn_processar"></td>
    </tr>
  </table>

</body>

</html>