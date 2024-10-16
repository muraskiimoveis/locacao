<?php
/*
Script principal do chat
Criado em 05/07/2008
Por Hédi Carlos Minin - hediminin@hotmail.com
*/

include('dbconnect.php');
include('settings.php');
include('security.php');

StartSession();
if(!CheckUser()){
	header('Location:index.php');
	exit();
}

$user = GetUser();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>X-chat</title>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/window.js"></script>
<script type="text/javascript" src="js/engine.js"></script>
<link href="css/window.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="nomeusuario">
	<?=$user['name'];?> <a href="logout.php" title="Sair">(Sair)</a>
	<div class="som"><input name="somativo" id="somativo" type="checkbox" value="1" checked="checked" /> Tocar som ao receber novas mensagens</div>
	<input type="hidden" id="userid" value="<?=$user['id'];?>" />
	<input type="hidden" id="username" value="<?=$user['name'];?>" />
</div>

<div class="janela" id="j0" onmousedown="FocoJanela(this)" style="top: 50px; left: 20px; width: 220px; height: 380px;">
	<div class="topo"><span title="Mover janela" id="tituloj0" onmousedown="CapturaJanela(this)">Usuários conectados</span></div>
	<div class="listausuarios" id="userlist">
		Conectando...
	</div>
</div>

<div id="status" title="Status de sua conexão com o servidor">Conectando...</div>

<object width="1" id="som" height="1" type="application/x-shockwave-flash" data="som.swf">
<param name="movie" value="som.swf" />
<param name="quality" value="high" />
<param name="wmode" value="transparent" />
</object>

<div class="direitos">2008 Hédi Carlos Minin</div>

</body>
</html>