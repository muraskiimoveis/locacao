<?php
include("conect.php");
include("l_funcoes.php");
$er = isset($_GET['er']) ? $_GET['er'] : '';
$acesso_web = isset($_POST['acesso_web']) ? $_POST['acesso_web'] : '';
$MSG = isset($_GET['MSG']) ? $_GET['MSG'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : '';

if (empty($er) && empty($acesso_web)) verificaAcesso();

	//VALIDAÇÃO DO COMPUTADOR
	if ($_REQUEST['acao'] == "Validar") {
		if (logaComputador($_REQUEST['computador_codigo'])) {
			header("LOCATION: index.php");
		} else {
			header("LOCATION: index.php?er=comp&MSG=O código não foi confirmado!");
		}
	}
	$senha = addslashes($senha);
	//$senha_web = addslashes($senha_web);
	/*if($acesso_web == "1") {
		$lib_web = logaWeb($senha_web);
	}*/
	//if(($lib_web) and ($acesso_web == "1")){
	if($acesso_web == "1") {
		if (logaUser($email,$senha)) {
			header("LOCATION: index.php");
		} else {
			echo ('<script language="javascript">alert("E-mail e/ou Senha Inválidos ou Usuário com status Inativo ou Imobiliária Inativa");document.location.href="index.php";</script>');
		}
	}	
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include("style.php");
//include("data.php");
//echo $_SERVER['HTTP_REFERER'];
	if (($er == "aces") and ($_SERVER['HTTP_REFERER'] == "bloqueado.php")) {
		echo "<script>alert('Você não possui permissões para acessar esta pagina.');</script>";
		$er = "";
	}
	else if ($er == "aces") {
		echo "<script>alert('Você não possui permissões para acessar esta pagina.');</script>";
		$er = "";
	}
?>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">
	<?php
		include("topo.php");
	?>
</td>
  </tr>
</table>
	<?
	//	if(verificaLogin() and verificaCookie($_COOKIE["computador_cookie"])){	
		if(empty($er)) { // se não houver erros
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" align="center">
	</td>
  </tr>
  <tr>
    <td align="center" valign="top"><?php
include("meio.php");
?></td>
  </tr>
</table>
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<?php
		} else {
					switch($er) { // verifica o erro e insere o formulario necessario
						case "comp":
							include("l_computador.php");
							break;
						case "user":
							include("l_usuario.php");
							break;
					}

		}
	?>
    </td>
  </tr>
</table>
<? if(!empty($_SESSION['valid_user'])){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
    <? include("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>

  <tr>
    <td align="center" class="style1">
    <? include("bruc.php"); ?>
    </td>
  </tr>

</table>
<? } 
echo $_SESSION['im_site_padrao'];
?>
</body>
</html>
