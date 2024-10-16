<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("USER_GERAL");

?>

<html>
<head>
</head>
<?php
include("style.php");
	//if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and ($u_tipo == "admin")){
?>
<script language="javascript">
function confirmaExclusao(id, nome, email, tipo)
{
       if(confirm("Tem certeza que deseja excluir?"))
          document.location.href='p_usuarios.php?id_excluir=' + id + '&nome=' + nome + '&email=' + email + '&tipo=' + tipo;
}
</script>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td align="center" background="images/fundo_topo.jpg">
<?
include("topo.php");
?>
   </td>
  </tr>
 </table>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td align="center">
<?
include("menu.php");
?>
   </td>
  </tr>
 </table>
<?
if ($B1 == "Inserir Usuário") {
   $u_nome1 = AddSlashes($u_nome1);
	$u_email1 = AddSlashes($u_email1);
	$u_senha1 = md5($u_senha1);
	$u_tipo1 = AddSlashes($u_tipo1);
	$u_status1 = AddSlashes($u_status1);
	$u_cookie = md5($u_email1.$u_senha1);
	$foto = $_POST['foto'];

	$pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$u_email1."' AND u_senha='".$u_senha1."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$pw_result = mysql_query($pw_query) or die("Não foi possivel inserir suas informações");
	$pw_rows = mysql_num_rows($pw_result);
	if ($pw_rows == 0) {
	   $data = date("Y-m-d");
		$hora = date("H-i-s");
		$foto = $data."-".$hora;
		$query = "insert into usuarios (cod_imobiliaria, u_nome, u_email, u_senha, u_tipo, u_status, u_cookie)
		   values('".$_SESSION['cod_imobiliaria']."', '".$u_nome1."', '".$u_email1."', '".$u_senha1."', '".$u_tipo1."', '".$u_status1."','".$u_cookie."')";
		$result = mysql_query($query) or die("Não foi possível inserir suas informações.");

				if (verificaFuncao("USER_AREA")) { // verifica se pode acessar as areas
			if (sizeof($areas) > 0) {
				$tmp_id = mysql_insert_id();
				foreach($_POST["areas"] as $area_id) {
					$a_query = "INSERT INTO rel_area_usuario (area_id,u_cod, cod_imobiliaria) VALUES('".$area_id."','".$tmp_id."','".$_SESSION['cod_imobiliaria']."')";
					$a_result = mysql_query($a_query) or die("Não foi possível inserir suas informações.");
				}
			}
		} // fim valida acesso
		
		//controle
   		mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$B1."',current_date,current_time)") or die ("Erro 71 - ".mysql_error());
?>
  <br /><br /><span class="style7"><div align="center">Você inseriu um novo usuário: <?php print("$u_nome1"); ?> - <?php print("$u_email1"); ?>.</div></span>
<?php
   } else {
      print ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");";</script>');
#	     print ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");document.location.href="p_usuarios.php";</script>');
	}
}

################################################################################
if ($_GET['id_excluir']) {
	$id_excluir = $_GET['id_excluir'];
	$nome = $_GET['nome'];
	$email = $_GET['email'];
	$tipo = $_GET['tipo'];

	$query4 = "SELECT * FROM mensagens WHERE (me_cod_user_envia='".$id_excluir."' or me_cod_user_recebe='".$id_excluir."') and cod_imobiliaria='".$cod_imobiliaria."'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);

   $sqlv1 = "SELECT * FROM contas WHERE cod_imobiliaria = '" . $_SESSION[cod_imobiliaria] . "'
      AND co_cliente = '" . $id_excluir . "' AND (co_tipo_user = 'A' OR co_tipo_user = 'V')";
   $rsv1 = mysql_query($sqlv1) or die ("Erro 100 - " . mysql_error());
   $conta1 = mysql_num_rows($rsv1);

   $sqlv2 = "SELECT * FROM atendimento WHERE (a_vendas = '1' OR a_locacao = '1' OR a_telefone = 1)
      AND cod_imobiliaria = '".$_SESSION[cod_imobiliaria]."' AND a_corretor = '" . $id_excluir . "'";
   $rsv2 = mysql_query($sqlv2) or die ("Erro 104 - " . mysql_error());
   $conta2 = mysql_num_rows($rsv2);

   $hoje = date("Y-m-d");
   $sqlv3 = "SELECT * FROM muraski WHERE data_inicio <> '0000-00-00' AND data_fim <> '0000-00-00'
      and data_fim > '$hoje' AND angariador = '" . $id_excluir . "' AND cod_imobiliaria = '".$_SESSION[cod_imobiliaria]."'";
   $rsv3 = mysql_query($sqlv3) or die ("Erro 110 - " . mysql_error());
   $conta3 = mysql_num_rows($rsv3);

   $confirm_exc = "s";
   $msg = "";
	if($numrows4 > 0){
		$msg .= "- Existem mensagens ligadas a ele! Tanto mensagens que ele enviou para um usuário quanto as que recebeu, <BR> exclua todas as mensagens ligados a ele antes de excluir o usuário ou inative ele!<BR>\n";
      $confirm_exc = "n";
   }
   if ($conta1 > 0) {
      $confirm_alt = "n";
      $msg .= "- Existem contas cadastradas para o usuário. <BR>\n ";
   }
   if ($conta2 > 0) {
      $confirm_alt = "n";
      $msg .= "- O Usuário está cadastrado como atendente. <BR>\n ";
   }
   if ($conta3 > 0) {
      $confirm_alt = "n";
      $msg .= "- O Usuário está cadastrado como angariador. <BR>\n ";
   }

   if ($confirm_exc == "n") {
?>
  <br /><br /><span class="style7"><div align="center"><strong>Exclusão não realizada</strong> <BR> <?=$msg?></div></span>
<?
	} else {


?>
  <br /><br /><span class="style7"><div align="center">Você apagou o usuário <?php print("$nome"); ?> - <?php print("$email"); ?>.</div></span>
<?
			$query = "delete from usuarios where u_cod = '$id_excluir'";
			$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
			$query10 = "delete from rel_area_usuario where u_cod = '$id_excluir'";
			$result10 = mysql_query($query10) or die("Não foi possível apagar suas informações.");
			
   			//controle
			mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','Excluir Usuário',current_date,current_time)") or die ("Erro 153 - ".mysql_error());
	}
}
if ($B1 == "Atualizar Usuário") {
	$u_nome1 = AddSlashes($u_nome1);
	$u_email1 = AddSlashes($u_email1);
	$senha = $u_senha1;
	if ($u_senha1 != "") {
		$u_senha1 = AddSlashes($u_senha1);
		$u_senha1 = md5($u_senha1);
	} else {
		$u_senha1 = $old_u_senha1;
	}
	$u_cookie = md5($u_email1.$u_senha1);

  $confirm_alt = "s";

  if ($old_u_status == "Ativo" && $u_status1 == "Inativo") {
      #Verifica se o usuário possui contas pendentes.
      $sqlv1 = "SELECT * FROM contas WHERE cod_imobiliaria = '".$_SESSION[cod_imobiliaria]."'
         AND co_cliente = '".$edit_cod."' AND co_status = 'pendente' AND (co_tipo_user = 'A' OR co_tipo_user = 'V')";
      $rsv1 = mysql_query($sqlv1) or die ("Erro 127 - " . mysql_error());
      $conta1 = mysql_num_rows($rsv1);

      $sqlv2 = "SELECT * FROM atendimento WHERE (a_vendas = '1' OR a_locacao = '1' OR a_telefone = 1)
         AND cod_imobiliaria = '".$_SESSION[cod_imobiliaria]."' AND a_corretor = '".$edit_cod."'";
      $rsv2 = mysql_query($sqlv2) or die ("Erro 131 - " . mysql_error());
      $conta2 = mysql_num_rows($rsv2);

      $msg = "";
      if ($conta1 > 0) {
         $confirm_alt = "n";
         $msg .= "Este usuário não pode ser desativado, existem contas pendentes para o usuário. <BR>\n ";
      }
      if ($conta2 > 0) {
         $confirm_alt = "n";
         $msg .= "Este usuário não pode ser desativado, ele está cadastrado como atendente. <BR>\n ";
      }
  }

  #confirmação da alteração.
  if ($confirm_alt == "s") {
	if (($senha != "") and ($u_email1 != $old_u_email1)) {

      	$pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$u_email1."' AND u_senha='".$u_senha1."' AND cod_imobiliaria='".$cod_imobiliaria."'";
      	$pw_result = mysql_query($pw_query) or die("Não foi possivel inserir suas informações");
      	$pw_rows = mysql_num_rows($pw_result);

      	if ($pw_rows == 0) {

            $query = "update usuarios set u_nome='$u_nome1', u_tipo='$u_tipo1', u_email='$u_email1'
            	, u_senha='".$u_senha1."', u_status='".$u_status1."', u_cookie='".$u_cookie."' where u_cod='$edit_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
      		$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
         	// AREAS ATUALIZAÇÃO
         	$tmp_id = $edit_cod;
      		$a_query0 = "DELETE FROM rel_area_usuario WHERE u_cod='$tmp_id'";
      		$a_result0 = mysql_query($a_query0) or die("Não foi possível inserir suas informações.");
      		if (sizeof($areas) > 0) {
      			foreach($_POST["areas"] as $area_id) {
      				$a_query = "INSERT INTO rel_area_usuario (area_id,u_cod, cod_imobiliaria) VALUES('".$area_id."','".$tmp_id."','".$_SESSION['cod_imobiliaria']."')";
      				$a_result = mysql_query($a_query) or die("Não foi possível inserir suas informações.");
      			}
         	}
            // fim valida acesso
            
        //controle
   		mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$B1."',current_date,current_time)") or die ("Erro 219 - ".mysql_error());
            
?>
 <br /><br /><span class="style7"><div align="center">Você atualizou o usuário <?php print("$u_nome1"); ?> - <?php print("$u_email1"); ?>.</div></span>
<?php
	      } else {
            echo ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");document.location.href="p_usuarios.php";</script>');
	      }
   } else {
      $query = "update usuarios set u_nome='$u_nome1', u_tipo='$u_tipo1', u_email='$u_email1'
         , u_senha='".$u_senha1."', u_status='".$u_status1."', u_cookie='".$u_cookie."' where u_cod='$edit_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
   	// AREAS ATUALIZAÇÃO
		$tmp_id = $edit_cod;
		$a_query0 = "DELETE FROM rel_area_usuario WHERE u_cod='$tmp_id'";
		$a_result0 = mysql_query($a_query0) or die("Não foi possível inserir suas informações.");
		if (sizeof($areas) > 0) {
		   foreach($_POST["areas"] as $area_id) {
				$a_query = "INSERT INTO rel_area_usuario (area_id,u_cod, cod_imobiliaria) VALUES('".$area_id."','".$tmp_id."','".$_SESSION['cod_imobiliaria']."')";
				$a_result = mysql_query($a_query) or die("Não foi possível inserir suas informações.");
			}
		}
      // fim valida acesso
      
      	//controle
   		mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$B1."',current_date,current_time)") or die ("Erro 244 - ".mysql_error());
?>
  <br /><br /><span class="style7"><div align="center">Você atualizou o usuário <?php print("$u_nome1"); ?> - <?php print("$u_email1"); ?>.</div></span>
<?
   }
  } else {
?>
 <span class="style7"><div align="center"><strong>Alteração não realizada</strong> <BR> <?=$msg?></div></span>
<?
  }
}
if ($lista == "") {

   if ($_GET['status']=='Inativo') {

	   $status = "Inativo";

   } else {

	   $status = "Ativo";

   }
	$query1 = "select * from usuarios where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_status='".$status."' order by u_nome";
	$result1 = mysql_query($query1);

?>
 <table width="75%" border="0" cellspacing="1" align="center">
  <tr height="50">
   <td colspan=5 class="style1">
    <p align="center"><b><a href="p_insert_usuario.php" class="style1">Cadastrar novo usuário</a></b><br />Para alterar ou excluir um usuário, clique sobre o nome correspondente a seguir.</p>
   </td>
  </tr>
  <tr class="fundoTabelaTitulo">
   <td width="55%" class="style1"><p align="left"><b>Nome do usuário</b></p></td>
   <td width="25%" class="style1"><p align="left"><b>E-mail</b></p></td>
   <td width="10%" class="style1"><p align="center"><b>Senha</b></p></td>
   <td width="10%" class="style1"><p align="center"><b>Status</b></p></td>
  </tr>
<?
	$i = 1;
	while ($not = mysql_fetch_array($result1)) {
      if ($not[u_tipo] == "admin") {
         $u_tipo1 = "Administrador Geral";
      } elseif($not[u_tipo] == "func") {
         $u_tipo1 = "Corretor";
	   } else {
      	$u_tipo1 = "Cliente";
   	}
	
	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
	
?>
  <tr class="<?php echo $fundo; ?>">
   <td class="style1"><p align="left">
<? //if($not[u_email] != "paulo@bruc.com.br"){ ?>
    <a href="p_usuarios.php?lista=1&edit_cod=<?=$not[u_cod]?>" class="style1">
<? //} ?>
    <?=$not[u_nome]?></a></p></td>
   <td class="style1">
    <p align="left">
<?	//if($not[u_email] != "paulo@bruc.com.br"){ ?>
     <a href="p_usuarios.php?lista=1&edit_cod=<?=$not[u_cod]?>" class="style1">
<? //} ?>
    <?=$not[u_email]?></a></p></td>
<? /** ?>

<td bgcolor="#ffffff" class="style1">
<p align="center">
<?php
	//if($not[u_email] != "paulo@bruc.com.br"){
?>
<a href="p_usuarios.php?lista=1&edit_cod=<?php print("$not[u_cod]"); ?>" class="sytle1">
<?php
	//}
?>
<?php print("$u_tipo1"); ?></a></td>
<? /**/ ?>

   <td class="style1">
    <p align="center">
<? //if($not[u_email] != "paulo@bruc.com.br"){ ?>
     <a href="p_usuarios.php?lista=1&edit_cod=<?php print("$not[u_cod]"); ?>" class="style1">
<? //} ?>
<?
      if ($u_tipo=="admin") {
?>
******
<?
	   } else {
?>
******
<?
      }
?>
     </a></p></td>
     <td class="style1">
      <p align="center">
<? //if($not[u_email] != "paulo@bruc.com.br"){ ?>
       <a href="p_usuarios.php?lista=1&edit_cod=<?php print("$not[u_cod]"); ?>" class="style1">
<?	//} ?>
<?=$not[u_status]?></a></p></td>
    </tr>
<?
   }
	if ($status<>'Inativo') {
?>
	 <tr class="fundoTabelaTitulo">
	  <td colspan="4" class="style1" align="center"><a href="p_usuarios.php?status=Inativo" class="style1"><b>Visualizar usuários inativos</b></a></td>
    </tr>
<?
   } else {
?>
	 <tr class="fundoTabelaTitulo">
	  <td colspan="4" class="style1" align="center"><a href="p_usuarios.php?status=Ativo" class="style1"><b>Visualizar usuários ativos</b></a></td>
    </tr>
<?
   }

} else {

   $query2 = "select * from usuarios
      where u_cod = '$edit_cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while ($not2 = mysql_fetch_array($result2)) {

/*	
      if ($not2[u_tipo] == "admin") {
         $u_tipo1 = "Administrador Geral";
   	} elseif($not2[u_tipo] == "func") {
      	$u_tipo1 = "Corretor";
   	} else {
	      $u_tipo1 = "Cliente";
   	}
*/
      if ($not2[u_tipo] == "web") {
         $u_tipo1 = "Com Acesso Externo";
   	  } else {
	      $u_tipo1 = "Sem Acesso Externo";
   	  }


      if (!IsSet($editar)) {
?>

	<div align="center">
	<form method="post" name="formulario" action="<?php print("$PHP_SELF"); ?>">
	 <input type="hidden" value="<?php print("$not2[u_cod]"); ?>" name="edit_cod">
     <input type="hidden" value="<?php print("$not2[u_email]"); ?>" name="old_u_email1">
	<table border="0" cellspacing="1" width="75%" align="center">
      	<tr height="50">
      		<td colspan="2" width="100%"><p align="center" class="style1"><b>Editar ou Apagar Usuários</b></p></td>
        </tr>
       <tr class="fundoTabela">
        <td width="20%" class="style1"><b>Nome do usuário:</b></td>
        <td width="80%" class="style1"> <input type="text" class="campo" name="u_nome1" size="40" value="<?php print("$not2[u_nome]"); ?>"></td>
       </tr>
       <tr class="fundoTabela">
        <td width="20%" class="style1"><b>E-mail do usuário:</b></td>
        <td width="80%" class="style1"><input type="text" class="campo" name="u_email1" size="40" value="<?php print("$not2[u_email]"); ?>"></td>
       </tr>
       <tr class="fundoTabela">
        <td width="20%" class="style1"><b>Senha do usuário:</b></td><? //////////////// VERIFICAR QUESTAO DA SENHA //////////////// ?>
        <td width="80%" class="style1">
         <input type="hidden" name="old_u_senha1" value="<?php print("$not2[u_senha]"); ?>">
	      <input type="password" class="campo" name="u_senha1" size="6" maxlength="6" onKeyUp="return autoTab(this, 6, event);"> OBS.: 6 dígitos</td>
       </tr>
    <!--tr class="fundoTabela">
      <td width="20%" class="style1"><b>Tipo de usuário:</b></td>
      <td width="80%" class="sytle1"><select name="u_tipo1" class="campo">
      <option value="<?php print("$not2[u_tipo]"); ?>"><?php print("$u_tipo1"); ?></option>
      <option value="admin">Administrador Geral</option>
      <option value="func">Corretor</option>
      <option value="cliente">Cliente</option>
	  </select></td>
    </tr-->
	
		<tr class="fundoTabela">
		  <td width="20%" class="style1"><b>Tipo de Acesso:</b></td>
		  <td width="80%" class="sytle1"><select name="u_tipo1" class="campo">
		  <option value="<?php print("$not2[u_tipo]"); ?>"><?php print("$u_tipo1"); ?></option>
		  <option value="web">Com Acesso Externo</option>
		  <option value="">Sem Acesso Externo</option>
		  </select></td>
		</tr>	
	
       <tr class="fundoTabela">
        <td class="style1"><b>Status:</b></td>
        <input type="hidden" name="old_u_status" value="<?=$not2[u_status]?>" />
        <td class="sytle1"><select name="u_status1" class="campo">
          <option value="<?php print("$not2[u_status]"); ?>"><?php print("$not2[u_status]"); ?></option>
          <option value="Ativo">Ativo</option>
          <option value="Inativo">Inativo</option>
         </select></td>
       </tr>
<?
         if (verificaFuncao("USER_AREA")) { // verifica se pode acessar as areas ?>
<script language="javascript">
<!--
cont = 0;
function CheckAll() {
   for (var i=0;i<document.formulario.elements.length;i++) {
     var x = document.formulario.elements[i];
     if (x.name == 'areas[]') {
x.checked = document.formulario.selall.checked;
}
}
if (cont == 0){
var elem = document.getElementById("checar");
elem.innerHTML = "Desmarcar todos";
cont = 1;
} else {
var elem = document.getElementById("checar");
elem.innerHTML = "Marcar todos";
cont = 0;
}

}
//-->
</script>
	    <tr>
        <td class="style1" colspan="2">
			<table width="100%" border="0" cellpadding="1" cellspacing="1">
          <tr class="fundoTabela">
			  <td class="style1" align="center" colspan="2"><strong>Áreas com acesso permitido:</strong></td>
			 </tr>
			 <tr class="fundoTabela">
			  <td class="style1" align="center" colspan="2">&nbsp;</td>
			 </tr>
			 <tr class="fundoTabela">
			  <td class="style1" align="center" colspan="2">
			   <input type="checkbox" name="selall" onClick="CheckAll()"><span id="checar">Marcar todos</span></td>
			 </tr>
			 <tr class="fundoTabela">
			  <td class="style1" align="center" colspan="2">&nbsp;</td>
			 </tr>
		    <tr class="fundoTabela">
<?
            $temp_array[] = "";
   			$busca1 = mysql_query("SELECT area_id FROM rel_area_usuario WHERE u_cod='$not2[u_cod]'");
   			if (mysql_num_rows($busca1) > 0)
               while ($linha1 = mysql_fetch_array($busca1))
   				   $temp_array[] = $linha1['area_id'];
   					$busca2 = mysql_query("SELECT area_id, area_nome, area_parametro, area_descricao FROM area ORDER BY area_nome ASC");
   					if (mysql_num_rows($busca2) > 0) {
   					   $cont = 0;
   						while ($linha2 = mysql_fetch_array($busca2)) {
   							if (array_search($linha2['area_id'], $temp_array)) {
   								$temp_check = "checked";
   							} else {
   								$temp_check = "";
   							}
   							
   							if($linha2['area_parametro'] == "GERAL_ESTATISTICAS" || $linha2['area_parametro'] == "GERAL_BANNER"){
								if($_SESSION['im_site_padrao'] == "S"){
?>
								<td width="50%" class="style1"><input type="checkbox" name="areas[]" value="<?=$linha2['area_id']?>" <?=$temp_check?> <?=$temp_desab?>><span title="<?=$linha2['area_descricao']?>"><?=$linha2['area_nome']?></span></td>
<?
								}
                            }elseif($linha2['area_parametro'] == "GERAL_MAILLING"){
                               if($_SERVER['SERVER_NAME'] <> "www.redebrasileiradeimoveis.com.br" AND $_SERVER['SERVER_NAME'] <> "redebrasileiradeimoveis.com.br"){
?>
                                <td width="50%" class="style1"><input type="checkbox" name="areas[]" value="<?=$linha2['area_id']?>" <?=$temp_check?> <?=$temp_desab?>><span title="<?=$linha2['area_descricao']?>"><?=$linha2['area_nome']?></span></td>
<?

                               }
							}else{
   							

?>
			  <td width="50%" class="style1"><input type="checkbox" name="areas[]" value="<?=$linha2['area_id']?>" <?=$temp_check?> <?=$temp_desab?>><span title="<?=$linha2['area_descricao']?>"><?=$linha2['area_nome']?></span></td>
<?
							 }
   						   $cont ++;
      						if ($cont == 2) {
   							   $cont = 0;
   							   print "</tr><tr class=\"fundoTabela\">";
      						}
   						}
   					}
?>
			 </tr>
			</table></td>
        </tr>
<?
         }
?>
        <tr>
         <td colspan="2">
          <input type="hidden" value="1" name="editar">
          <input type="submit" value="Atualizar Usuário" name="B1" class="campo3">
         <input type="button" value="Apagar Usuário" name="B1" class="campo3" onClick="javascript:confirmaExclusao(<?=$edit_cod?>, '<?=$not2[u_nome]?>', '<?=$not2[u_email]?>', '<?=$u_tipo1?>')"></td>
        </tr>
       </form>
      </table></div>
<?
      }
   }
}

if(session_is_registered("valid_user")){
?>
      <table style="padding-top: 20px;" width="100%" border="0" cellpadding="0" cellspacing="0">
       <tr>
        <td bgcolor="#e0e0e0" height="1"></td></tr>
      </table>
      <table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
       <tr>
        <td>&nbsp;</td>
       </tr>
       <tr>
        <td align="center">
<?
include("voltar.php");
?>
        </td>
       </tr>
       <tr>
        <td>&nbsp;</td>
       </tr>
       <tr>
        <td align="center">
<?
include("endereco.php");
?>
        </td>
       </tr>
       <tr>
        <td height="20"></td>
       </tr>
       <tr>
        <td align="center" class="style1">
<?
include("bruc.php");
?>
        </td>
       </tr>
      </table>
<?
}
?>
     </body>
    </html>