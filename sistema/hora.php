<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Hello!</title>
</head>

<body>
<?
include "conect.php";
?>

Teste de hora do Sistema.<br /><br />

Hora do Servidor p/ Frank: <?echo date('mdHiY.s',mktime()); ?><br /><br />

Hora do computador: <?= date("H:i:s"); ?><br /><br />

<?
$sql = "select CURRENT_TIME() as hora";
$rs = mysql_query($sql) or die ("Erro 18 - " . mysql_error());
$not = mysql_fetch_assoc($rs);

echo "Hora do mysql - " . $not['hora'];
/**/
?>
</body>
</html>
