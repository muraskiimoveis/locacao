<?
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("CLIENT_GERAL");

$busca = mysql_query("select * from clientes where c_nome like 'anto%' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
while($linha = mysql_fetch_array($busca)){
	echo $linha['c_nome']."<br>";
	echo $linha['c_foto'];
}

?>