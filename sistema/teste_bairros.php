<form name="form1" method="post" action="">
<?php

$link = mysql_connect("localhost", "root", "vertrigo")
        or die("N�o pude conectar: " . mysql_error());

mysql_select_db("test") or die("N�o pude selecionar o banco de dados");

if($B1 == "Inserir Im�vel")
	{
		foreach($_POST['bairro'] AS $key => $value)
			echo $value;
	}

$busca_bairros = mysql_query("SELECT * FROM bairros ORDER BY b_bairro");
while($linha = mysql_fetch_array($busca_bairros)){
?>
	<div class="DivBairros"><input type="checkbox" value="bairro[<?= $linha['b_id'] ?>]"> <?= $linha['b_bairro']; ?></div>
<?
}
?>
<input type="submit" name="botao" value="ok" onClick="form1.acao.value='1'">
</form>