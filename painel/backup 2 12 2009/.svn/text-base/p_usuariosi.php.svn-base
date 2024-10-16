<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

if($_GET['cod_imob'] != ""){
 $cod_imob = $_GET['cod_imob'];
}else{
 $cod_imob = $_POST['cod_imob'];
}
//echo $cod_imobiliaria;
include("regra.php");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<input type="hidden" name="cod_imob" id="cod_imob" value="<? echo($cod_imob); ?>">
<table width=100% height=100%>
<tr><td bgcolor="<?php print("$barra_lat"); ?>" valign=top width=150>
<?php
include("menu_painel.php");
?></td>
<td width=620 valign=top>
<br>
<?php
include("conect.php");
?>
 <p align="center" class=style2>
   <?php
//	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
//	(($u_tipo == "admin") or ($u_tipo == "func"))){
?>
</p>
<?php

if($B1 == "Inserir Usuário")
	{
	$u_nome1 = AddSlashes($u_nome1);
	$u_email1 = AddSlashes($u_email1);
	$u_senha1 = md5($u_senha1);
	$u_status1 = AddSlashes($u_status1);
	$foto = $_POST['foto'];
    $u_cookie = md5($u_email1.$u_senha1);

	$pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$u_email1."' AND u_senha='".$u_senha1."' AND cod_imobiliaria='".$cod_imob."'";
	$pw_result = mysql_query($pw_query) or die("Não foi possivel inserir suas informações");
	$pw_rows = mysql_num_rows($pw_result);
	if ($pw_rows == 0) {
		$data = date("Y-m-d");
		$hora = date("H-i-s");
		$foto = $data."-".$hora;
		$query = "insert into usuarios (cod_imobiliaria, u_nome, u_email, u_senha, u_tipo, u_status, u_cookie)
		values('".$cod_imob."', '$u_nome1', '$u_email1', '".$u_senha1."', '$u_tipo1', '".$u_status1."','".$u_cookie."')";
		$result = mysql_query($query) or die("Não foi possível inserir suas informações.");
		//if (verificaFuncao("USER_AREAS")) { // verifica se pode acessar as areas
			if (sizeof($areas) > 0) {
				$tmp_id = mysql_insert_id();
				foreach($_POST["areas"] as $area_id) {
					$a_query = "INSERT INTO rel_area_usuario (area_id,u_cod, cod_imobiliaria) VALUES('".$area_id."','".$tmp_id."','".$cod_imob."')";
					$a_result = mysql_query($a_query) or die("Não foi possível inserir suas informações.");
				}
			}
		//} // fim valida acesso
		
				//controle
   		mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$cod_imob."','".$u_cod."','".$B1."',current_date,current_time)") or die ("Erro 72 - ".mysql_error());
?>
Você inseriu um novo usuário: <?php print("$u_nome1"); ?> - <?php print("$u_email1"); ?>.
<?
	}else{
	     echo ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");document.location.href="p_insert_usuarioi.php?cod_imob='.$cod_imob.'";</script>'); 
		 	}
	
?>
<?php
	}
if($B1 == "Apagar Usuário")
	{

	$query = "delete from usuarios where u_cod = '$edit_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações.");
	$query10 = "delete from rel_area_usuario where u_cod = '$edit_cod'";
	$result10 = mysql_query($query10) or die("Não foi possível apagar suas informações.");
	
			//controle
   		mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$cod_imob."','".$u_cod."','Excluir Usuário',current_date,current_time)") or die ("Erro 92 - ".mysql_error());
?>
Você apagou o usuário <?php print("$u_nome1"); ?> - <?php print("$u_email1"); ?>.
<?php
	}
if($B1 == "Atualizar Usuário")
	{
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

	if ($senha != "" and ($u_email1 != $old_u_email1)) {
	$pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$u_email1."' AND u_senha='".$u_senha1."' AND cod_imobiliaria='".$cod_imob."'";
	$pw_result = mysql_query($pw_query) or die("Não foi possivel inserir suas informações");
	$pw_rows = mysql_num_rows($pw_result);
	if ($pw_rows == 0) {

	$query = "update usuarios set u_nome='$u_nome1', u_tipo='$u_tipo1', u_email='$u_email1'
	, u_senha='".$u_senha1."', u_status='".$u_status1."', u_cookie='".$u_cookie."' where u_cod='$edit_cod' and cod_imobiliaria='".$cod_imob."'";
		$result = mysql_query($query) or die("Não foi possível atualizar suas informações.$query");
	// AREAS ATUALIZAÇÃO
		$tmp_id = $edit_cod;
		$a_query0 = "DELETE FROM rel_area_usuario WHERE u_cod='$tmp_id'";
		$a_result0 = mysql_query($a_query0) or die("Não foi possível inserir suas informações.$a_query0");
		if (sizeof($areas) > 0) {
			foreach($_POST["areas"] as $area_id) {
				$a_query = "INSERT INTO rel_area_usuario (area_id,u_cod, cod_imobiliaria) VALUES('".$area_id."','".$tmp_id."','".$cod_imob."')";
				$a_result = mysql_query($a_query) or die("Não foi possível inserir suas informações.$a_query");
			}
		}
	 // fim valida acesso
	 
	 		//controle
   		mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$cod_imob."','".$u_cod."','".$B1."',current_date,current_time)") or die ("Erro 132 - ".mysql_error());

?>
Você atualizou o usuário <?php print("$u_nome1"); ?> - <?php print("$u_email1"); ?>.
<?php
	}else{
	  echo ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");document.location.href="p_insert_usuarioi.php?cod_imob='.$cod_imob.'";</script>'); 
	}
	}else{
	  $query = "update usuarios set u_nome='$u_nome1', u_tipo='$u_tipo1', u_email='$u_email1'
	, u_senha='".$u_senha1."', u_status='".$u_status1."', u_cookie='".$u_cookie."' where u_cod='$edit_cod' and cod_imobiliaria='".$cod_imob."'";
		$result = mysql_query($query) or die("Não foi possível atualizar suas informações.$query");
	// AREAS ATUALIZAÇÃO
		$tmp_id = $edit_cod;
		$a_query0 = "DELETE FROM rel_area_usuario WHERE u_cod='$tmp_id'";
		$a_result0 = mysql_query($a_query0) or die("Não foi possível inserir suas informações.$a_query0");
		if (sizeof($areas) > 0) {
			foreach($_POST["areas"] as $area_id) {
				$a_query = "INSERT INTO rel_area_usuario (area_id,u_cod, cod_imobiliaria) VALUES ('".$area_id."','".$tmp_id."','".$cod_imob."')";
				$a_result = mysql_query($a_query) or die("Não foi possível inserir suas informações.$a_query");
			}
		}
	 // fim valida acesso
	 
	 		//controle
   		mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$cod_imob."','".$u_cod."','".$B1."',current_date,current_time)") or die ("Erro 157 - ".mysql_error());

?>
Você atualizou o usuário <?php print("$u_nome1"); ?> - <?php print("$u_email1"); ?>.
<?
	}	
}
if($lista == "")
	{
	  
	if($_GET['status']=='Inativo'){
	  $status = "Inativo";
	}else{
	  $status = "Ativo";
	}  
	
	$query1 = "select * from usuarios where cod_imobiliaria='".$cod_imob."' AND u_status='".$status."' order by u_cod asc limit 1";
	$result1 = mysql_query($query1);
?>
<div align="center">
  <center>
<table bgcolor="#EDEEEE" border="0" cellspacing="1">
<!--tr><td bgcolor="#ffffff" colspan=5 class="style1">
<p align="center">
<b><a href="p_insert_usuarioi.php?cod_imob=<?php print("$cod_imob"); ?>" class="style1">Cadastrar novo usuário</a></b>
</td></tr-->
<tr><td bgcolor="#ffffff" colspan=5 class="style1">
<p align="center">
Para alterar ou excluir um usuário, clique sobre o nome correspondente a seguir.</b>
</td></tr>
<tr bgcolor="#EDEEEE">
<td width=200 class="style1">
<p align="center"><b>Nome do usuário</b></td>
<td width=200 class="style1">
<p align="center"><b>E-mail</b></td>
<!--td width=200 class="style1">
<p align="center"><b>Função</b></td-->
<td width=100 class="style1">
<p align="center"><b>Senha</b></td>
<td width=100 class="style1">
<p align="center"><b>Status</b></td>
</tr>
<?php
	while($not = mysql_fetch_array($result1))
	{
	
	if($not[u_tipo] == "admin"){
	$u_tipo1 = "Administrador Geral";
	}
	elseif($not[u_tipo] == "func"){
	$u_tipo1 = "Funcionário";
	}
	else
	{
	$u_tipo1 = "Cliente";
	}
?>
<tr>
<td bgcolor="#ffffff" class="style1"><p align="center">
<?php
	 	if(session_is_registered("usu_cod")){
			//if($usu_cod == 1 or $usu_cod == 7 or $usu_cod == 9){
?>
<a href="p_usuariosi.php?lista=1&edit_cod=<?php print("$not[u_cod]"); ?>&cod_imob=<?php print("$cod_imob"); ?>" class="style1">
<?php
			//}
		}
?>
<?php print("$not[u_nome]"); ?></a></td>
<td bgcolor="#ffffff" class="style1">
<p align="center">
<?php
	 	if(session_is_registered("usu_cod")){
			//if($usu_cod == 1 or $usu_cod == 7 or $usu_cod == 9){
?>
<a href="p_usuariosi.php?lista=1&edit_cod=<?php print("$not[u_cod]"); ?>&cod_imob=<?php print("$cod_imob"); ?>" class="style1">
<?php
			//}
		}
?>
<?php print("$not[u_email]"); ?></a></td>
<!--td bgcolor="#ffffff" class="style1">
<p align="center">
<?php
	 	if(session_is_registered("usu_cod")){
			//if($usu_cod == 1 or $usu_cod == 7 or $usu_cod == 9){
?>
<a href="p_usuariosi.php?lista=1&edit_cod=<?php print("$not[u_cod]"); ?>&cod_imob=<?php print("$cod_imob"); ?>" class="sytle1">
<?php
			//}
		}
?>
<?php print("$u_tipo1"); ?></a></td-->
<td bgcolor="#ffffff" class="style1">
<p align="center">
<?php
	 	if(session_is_registered("usu_cod")){
			//if($usu_cod == 1 or $usu_cod == 7 or $usu_cod == 9){
?>
<a href="p_usuariosi.php?lista=1&edit_cod=<?php print("$not[u_cod]"); ?>&cod_imob=<?php print("$cod_imob"); ?>" class="style1">
<?php
			//}
		}
?>

<?php
	if($u_tipo=="admin"){
?>
******
<?php
	}
	else
	{
?>
******
<?php
	}
?>
</a></td>
<td bgcolor="#ffffff" class="style1">
<p align="center">
<?php
	if(session_is_registered("usu_cod")){
			//if($usu_cod == 1 or $usu_cod == 7 or $usu_cod == 9){
?>
<a href="p_usuariosi.php?lista=1&edit_cod=<?php print("$not[u_cod]"); ?>&cod_imob=<?php print("$cod_imob"); ?>" class="style1">
<?php
			//}
	}	
?>
<?php print("$not[u_status]"); ?></a></td>
<?php
	}
	
	//if($status<>'Inativo'){	
?>
	<!--tr bgcolor="#ffffff">
	  <td colspan="5" class="style1" align="center"><a href="p_usuariosi.php?status=Inativo&cod_imob=<?php print("$cod_imob"); ?>" class="style1"><b>Visualizar usuários inativos</b></a></td>
    </tr>
<?
    //}else{
?>	
	<tr bgcolor="#ffffff">
	  <td colspan="5" class="style1" align="center"><a href="p_usuariosi.php?status=Ativo&cod_imob=<?php print("$cod_imob"); ?>" class="style1"><b>Visualizar usuários ativos</b></a></td>
    </tr-->
<?
	//}
?>
	<tr bgcolor="#FFFFFF">
      <td colspan="5">
      <p align="center"><a href="javascript:history.back()" class=style2><< Voltar <<</a></p></td>
    </tr>
<?	
	}
	else
	{
	$query2 = "select * from usuarios 
	where u_cod = '$edit_cod' and cod_imobiliaria='".$cod_imob."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{

	if($not2[u_tipo] == "admin"){
	$u_tipo1 = "Administrador Geral";
	}
	elseif($not2[u_tipo] == "func"){
	$u_tipo1 = "Funcionário";
	}
	else
	{
	$u_tipo1 = "Cliente";
	}

if(!isset($editar))
	{
?>
<p align="center" class="style1"><b>Editar ou Apagar Usuários</b></p>
 <div align="center">
  <center>
  <form method="post" name="formulario" action="<?php print("$PHP_SELF"); ?>">
  <input type="hidden" value="<?php print("$not2[u_cod]"); ?>" name="edit_cod">
  <input type="hidden" name="cod_imob" id="cod_imob" value="<? echo($cod_imob); ?>">
  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="20%" class="style1"><b>Nome do usuário:</b></td>
      <td width="80%" class="style1"> <input type="text" class="campo" name="u_nome1" size="40" value="<?php print("$not2[u_nome]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class="style1"><b>E-mail do usuário:</b></td>
      <td width="80%" class="style1"><input type="text" class="campo" name="u_email1" size="40" value="<?php print("$not2[u_email]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class="style1"><b>Senha do usuário:</b></td><? //////////////// VERIFICAR QUESTAO DA SENHA //////////////// ?>
      <td width="80%" class="style1">
	  <input type="hidden" name="old_u_senha1" value="<?php print("$not2[u_senha]"); ?>">
	  <input type="password" class="campo" name="u_senha1" size="6" maxlength="6" onKeyUp="return autoTab(this, 6, event);">OBS.: 6 dígitos</td>
    </tr>
    <!--tr>
      <td width="20%" class="style1"><b>Tipo de usuário:</b></td>
      <td width="80%" class="sytle1"><select name="u_tipo1" class="campo">
      <option value="<?php print("$not2[u_tipo]"); ?>"><?php print("$u_tipo1"); ?></option>
      <option value="admin">Administrador Geral</option>
      <option value="func">Funcionário</option>
      <option value="cliente">Cliente</option>
	  </select></td>
    </tr-->
	<tr>
      <td width="20%" class="style1"><b>Status:</b></td>
      <td width="80%" class="sytle1"><select name="u_status1" class="campo">
        <option value="<?php print("$not2[u_status]"); ?>"><?php print("$not2[u_status]"); ?></option>
        <option value="Ativo">Ativo</option>
        <option value="Inativo">Inativo</option>
      </select></td>
    </tr>
<script language=javascript>
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
			<table width="500" border="0" cellpadding="0" cellspacing="0">
				<tr>
				  <td class="style1" align="center" colspan="2"><br><strong>Áreas com acesso permitido:</strong></td>
				</tr>
				<tr>
				  <td class="style1" align="center" colspan="2">&nbsp;</td>
			  </tr>
				<tr>
				  <td class="style1" align="center" colspan="2">
				    <input type="checkbox" name="selall" onClick="CheckAll()"><span id="checar">Marcar todos</span></td>
			  </tr>
				<tr>
				  <td class="style1" align="center" colspan="2">&nbsp;</td>
			  </tr>
				<tr>
				<?
					$temp_array[] = "";
					$busca1 = mysql_query("SELECT area_id FROM rel_area_usuario WHERE u_cod='$not2[u_cod]'");
					if(mysql_num_rows($busca1) > 0)
						while($linha1 = mysql_fetch_array($busca1))
							$temp_array[] = $linha1['area_id'];
					$busca2 = mysql_query("SELECT area_id, area_nome, area_parametro, area_descricao FROM area ORDER BY area_nome ASC");
					if(mysql_num_rows($busca2) > 0){
						$cont = 0;
						while($linha2 = mysql_fetch_array($busca2)){
							if (array_search($linha2['area_id'], $temp_array)) {
								$temp_check = "checked";
							} else {
								$temp_check = "";
							}
				?>
						  <td width="50%" class="style1"><input type="checkbox" name="areas[]" value="<?=$linha2['area_id']?>" <?=$temp_check?> <?=$temp_desab?>><span title="<?=$linha2['area_descricao']?>"><?=$linha2['area_nome']?></span></td>
				<?
						$cont ++;
						if ($cont == 2) {
							$cont = 0;
							echo "</tr><tr>";
						}
						}
					}
				?>
				</tr>
			</table>
		</td>
      </tr>	
    <tr>
      <td width="20%">
      <input type="hidden" value="1" name="editar">
      <input type="submit" value="Atualizar Usuário" name="B1" class="campo"></td>
      <td width="80%"><input type="submit" value="Apagar Usuário" name="B1" class="campo"></td>
    </tr>
	 <tr>
      <td colspan="2">
      <p align="center"><a href="javascript:history.back()" class=style2><< Voltar <<</a></p></td>
    </tr>
  </table>
  </center></div>
  </form>
<?php
	}
	}
	}
?>
<?php
/*	}
	else
	{
?>
<?php
include("login2.php");
?>
<?php
	}*/
?>

</td></tr></table>
</body>
</html>