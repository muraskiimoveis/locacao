<?php
session_start();
include("conect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?
include("style.php");
$n_cod = $_GET['n_cod'];
$n_img = $_GET['n_img'];
?>
</head>

<body>
<input type="button" value="Selecionar Fotos" class="campo" onclick="window.open('p_img_temp.php?origem=sites&pasta=<?=$pasta?>', 'janela', 'height=500,width=800,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');">
<table bgcolor="#<?=$cor1; ?>" width="100%" height="230">
	<tr><td align="left">
<table align="center">
	<tr>
		<td colspan="5" align="center"><a href="javascript: window.location.reload();" class="style2">Recarregar fotos</a></td>
	</tr>
	     <tr>
	       <td>
<?
$caminho = "../imobiliarias/".$pasta."/institucional/peq/";
//$caminho = "../imobiliarias/".$pasta."/institucional/peq/";
$sql = "SELECT * FROM rebri_fotos_temp WHERE ft_user = '".$_SESSION['usu_cod']."' ORDER BY ft_foto";
$rs = mysql_query($sql) or die ("Erro 26");
?>
<table>
<tr>
<?
$i=0;
while ($not = mysql_fetch_assoc($rs)) {
   $foto_p = str_replace(".jpg","_peq.jpg",$not[ft_foto]);
   if ($i % 4 == 0 && $i > 0) {
      print "</tr><tr>\n";
   }
   if (file_exists($caminho.$foto_p)) {
      print "<td><img src='".$caminho.$foto_p."'></td>\n";
      $i++;
   }
}
?>
</tr>
</table>
		   </td>
		 </tr>
	  </table></td>
		 </tr>
	  </table>
	  </body>
	  </html>