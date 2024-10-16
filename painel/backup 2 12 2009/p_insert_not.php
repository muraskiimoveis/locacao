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
 <p align="center"><b>Inserir Textos</b><br>
 <a href="p_not.php" class=linkm>
 Clique para visualizar a relação de Textos</a></p>
 <div align="center">
  <center>
  <form method="post" action="p_not.php">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="20%"><b>Tipo:</b></td>
      <td width="80%"><select name=n_tipo class=campo>
      <option value="Texto">Texto</option>
      <option value="Notícia">Notícia</option>
       </select></td>
    </tr>
    <tr>
      <td width="20%"><b>Grupo:</b></td>
      <td width="80%"> <input class=campo type="text" name="n_grupo" size="40"></td>
    </tr>
    <tr>
      <td width="20%"><b>Título:</b></td>
      <td width="80%"> <input class=campo type="text" name="n_nome" size="40"></td>
    </tr>
    <tr>
      <td width="20%"><b>Data:</b></td>
      <td width="80%" class=style2> <input class=campo type="text" name="n_data" size="10"> Ex.: 10/10/1910</td>
    </tr>
    <tr>
      <td width="20%" valign=top><b>Texto:</b></td>
      <td width="80%" class=style2>
      <textarea name="n_txt" rows="20" cols="55" class=campo></textarea></td>
    </tr>
    <tr>
      <td width="20%"><b>Autor:</b></td>
      <td width="80%"> <input class=campo type="text" name="n_autor" size="40" value="Rede Brasileira de Imóveis"></td>
    </tr>
    <tr>
      <td width="20%"><b>Código HTML:</b></td>
      <td width="80%"><select name=n_html class=campo>
      <option>Sim
      <option>Nao
       </select></td>
    </tr>
    <tr>
      <td width="20%">
      <input class=campo type="submit" value="Inserir Texto" name="B1"></td>
      <td width="80%"></td>
    </tr>
  </table>
  </form>
<?php
include("carimbo.php");
mysql_close($con);
?>
</td></tr></table>
</body>
</html>