<?php
include('dbconnect.php');
include('settings.php');
include('security.php');
include('login.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>X-chat Lite</title>
<link href="css/login.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="bordalogin">
	<div class="colunadir">
		<div class="titulo">X-chat Lite - Entrar</div>
		<div class="erro"><?=$error;?></div>
		<form id="form1" name="form1" method="post" action="index.php">
		<label for="username">Nick:</label><br />
		<input type="text" name="username" id="username" maxlength="25" /><br /><br />
		<input name="Login" type="submit" value="Entrar" class="botao" />
		</form>
	</div>
	<div class="colunaesq">
		<div class="titulo">Usuários conectados</div>
		<?php
		$query = mysql_query("SELECT * FROM bp_users WHERE lifetime > $time");
		if(mysql_num_rows($query) > 0){
			while($line = mysql_fetch_array($query)){	
				print '<div>'.$line['name'].'</div>';
			}
		}else{
			echo 'Nenhum usuário conectado';
		}
		?>
	</div>
</div>
</body>
</html>

