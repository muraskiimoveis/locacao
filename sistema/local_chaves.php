<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<?php

if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}

	$sql = mysql_query("SELECT chaves, controle_chave FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	while($linha = mysql_fetch_array($sql)){
		$chaves = $linha['chaves'];
		$controle_chaves = $linha['controle_chave'];
	}
?>
<body>
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
  <table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr bgcolor="#edeeee">
      <td width="20%" class="style1"><b>Local Chaves:</b></td>
      <td width="80%" class="style7"><? if($controle_chaves<>'0'){ echo($controle_chaves); } ?> <?=$chaves; ?></td>
    </tr>
</table>
</body>
</html>