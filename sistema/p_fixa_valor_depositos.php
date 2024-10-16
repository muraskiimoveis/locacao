<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("RELAT_DEPOSITOS");
?>
<html>

<head>
<?php
include("style.php");
?>
</head>
<link href="style.css" rel="stylesheet" type="text/css" />
<body topmargin=0 leftmargin=0 rightmargin=0>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin"))){
*/	  

	if($acao == "altera"){
		if($co_fixar == "ok"){
			$fixar = "no";
		}elseif(($co_fixar == "no") or ($co_fixar == "")){
			$fixar = "ok";
		}
			
	$query4= "update contas set co_fixar='$fixar' where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	
		}

?>
<a class=style1>
<?php
		$query7 = "select * from contas where co_cod='$co_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		//echo $query7 . "<br>";
		$result7 = mysql_query($query7);
		while($not7 = mysql_fetch_array($result7))
		{
?>
<a class=style1 href="<?php print("$PHP_SELF"); ?>?co_cod=<?php print("$not7[co_cod]"); ?>&co_fixar=<?php print("$not7[co_fixar]"); ?>&acao=altera"><?php if($not7[co_fixar] == "ok"){ echo "<b>fixo ok</b>"; }else{ echo "Alterar"; } ?></a>
<?php	
		}
?>
</a>
<?php
mysql_close($con);
?>
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