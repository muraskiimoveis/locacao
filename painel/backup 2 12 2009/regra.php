<?php
//	if((session_is_registered("usu_email")) and (session_is_registered("usu_tipo")) and	(
	if (($_SESSION['usu_tipo'] == "admin" || $_SESSION['usu_tipo'] == "func") &&
     $_SESSION['rebricbr'] == "1" && $_SESSION[painel] == "painel" &&
     $_SESSION[dominio] == $_SERVER['SERVER_NAME']) {

		$perm_func = array('/painel/index.php');
		$url = explode("?", $REQUEST_URI);
		if($usu_tipo == "func"){
         if (in_array($url[0], $perm_func)) {
     		} else {

   			$msg = "�rea restrita. <b>" . $REQUEST_URI . "</b> Apenas administradores do Sistema podem acess�-la.";
   			header( "location: index.php?msg=$msg\r\n" );

   		}
		}

	} else {

		$msg = "Voc� precisa estar logado no sistema!";
		header( "location: index.php?msg=$msg\r\n" );

	}
?>