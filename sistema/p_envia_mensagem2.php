<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("MENSAGENS_GERAL");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	($u_tipo == "admin") or ($u_tipo == "func"))){
*/	  
?>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td align="center"><?php

$data = date("Y-m-d");
$hora = date("H:i:s");


//*********************************************
//Envia a mensagem para os usuarios
if($_POST['acao'] == 1 && $_GET['todos']<>'1'){
  
 	$i = $_POST['i'];
	$c = 0;

	for($j = 0; $j <= $i; $j++)
	{	     
		$cod_imos = "cod_imo_".$j;
     	$codimobiliaria = $_POST[$cod_imos];
     	$me_usuarios = "me_usuario_".$j;
     	$users = $_POST[$me_usuarios];

  	 if($users){
    	$c++;
    	$insere = "INSERT INTO mensagens (cod_imobiliaria, me_cod_user_envia, me_cod_user_recebe, me_assunto, me_texto, me_data, me_hora, me_status) VALUES ('".$codimobiliaria."','".$u_cod."','".$users."','".$me_assunto."','".$me_texto."','".$data."','".$hora."','0')";
		$result = mysql_query($insere) or die("Não foi possível atualizar suas informações. $insere");			
     } 
  	} 
    
	//$insere = mysql_query("INSERT INTO mensagens (cod_imobiliaria, me_cod_user_envia, me_cod_user_recebe, me_assunto, me_texto, me_data, me_hora, me_status) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$me_usuario."','".$me_assunto."','".$me_texto."','".$data."','".$hora."','0')");
	//echo "<br><span class=\"style4\">Mensagem enviada com sucesso</span>";
	echo('<script language="javascript">alert("Mensagem enviada com sucesso!");document.location.href="p_pesq_mensagens.php";</script>');

}elseif($_POST['acao'] == 1 && $_GET['todos']=='1'){
    
     
     $query = mysql_query("SELECT u.u_cod, i.im_cod FROM usuarios u INNER JOIN rebri_imobiliarias i ON (u.cod_imobiliaria=i.im_cod) WHERE u.u_status='Ativo' and u.u_cod!='".$u_cod."'");
	 while($linha = mysql_fetch_array($query)){ 
    	$insere = "INSERT INTO mensagens (cod_imobiliaria, me_cod_user_envia, me_cod_user_recebe, me_assunto, me_texto, me_data, me_hora, me_status) VALUES ('".$linha['im_cod']."','".$u_cod."','".$linha['u_cod']."','".$me_assunto."','".$me_texto."','".$data."','".$hora."','0')";
		$result = mysql_query($insere) or die("Não foi possível atualizar suas informações. $insere");			
     } 
    
	//$insere = mysql_query("INSERT INTO mensagens (cod_imobiliaria, me_cod_user_envia, me_cod_user_recebe, me_assunto, me_texto, me_data, me_hora, me_status) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$me_usuario."','".$me_assunto."','".$me_texto."','".$data."','".$hora."','0')");
	//echo "<br><span class=\"style4\">Mensagem enviada com sucesso</span>";
	echo('<script language="javascript">alert("Mensagem enviada com sucesso!");document.location.href="p_pesq_mensagens.php";</script>');  
}

/*
//Envia Mensagem para todos os usuários da lista
if($_POST['acao'] == 1 && $_POST['me_usuario'] == 'todos'){
	 $busca_usuario = mysql_query("SELECT u_cod, u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_nome");
	 while($linha = mysql_fetch_array($busca_usuario)){
			$insere = mysql_query("INSERT INTO mensagens (cod_imobiliaria, me_cod_user_envia, me_cod_user_recebe, me_assunto, me_texto, me_data, me_hora, me_status) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$linha['u_cod']."','".$me_assunto."','".$me_texto."','".$data."','".$hora."','0')");
	 }
	echo "<br><span class=\"style4\">Mensagem enviada com sucesso para os usuários</span>";
}
*/
//*********************************************

?>
      <p align="center" class="style1"><b>Enviar mensagens </b></p>
      <a href="p_mensagens.php" class="style1">Ver mesagens</a><br><br>
      <div align="center">
      <center>
      <form method="post" action="" name="form1" id="form1">
      <table border="0" cellspacing="1" width="760">
          <tr bgcolor="#EDEEEE">
            <td width="20%" valign="top" class="style1"><b>Usu&aacute;rio(s):</b></td>
            <td width="80%" class="style1">
<? if($_GET['todos']<>'1'){ ?>
<script language="javascript">
function selecionar_todas(retorno){
if(retorno==true){
for(i=0;i<form1.length;i++){
if(form1.elements[i].type=="checkbox" && form1.elements[i].name!="todas"){
  if(form1.elements[i].checked==false){
   form1.elements[i].checked=true;
   var elem = document.getElementById("checar");
   elem.innerHTML = "Desmarcar todos";
   }
}
}
} else {
for(i=0;i<form1.length;i++){
if(form1.elements[i].type=="checkbox" && form1.elements[i].name!="todas"){
  if(form1.elements[i].checked==true){
   form1.elements[i].checked=false;
   var elem = document.getElementById("checar");
   elem.innerHTML = "Marcar todos";
  }
}
}
}
}

function VerificaCampo(){

/*
var ok = false;
    for (i = 1; i < document.form1.me_usuario.length; i++) {
      if (document.form1.me_usuario[i].checked) { ok = true; }
  }
  if (!ok) {
      alert ("Por favor selecione pelo menos um Usuário.");
      return false;
  }
*/
  
    todos = document.getElementsByTagName('input'); 
    for(x = 0; x < todos.length; x++) 
    { 
        if (todos[x].checked) 
        { 
            if(document.form1.me_assunto.value.length==0)
  			{
     			alert("Por favor, preencha o campo Assunto");
     			return false;
  			}
  			if(document.form1.me_texto.value.length==0)
  			{
	 			alert("Por favor, preencha o campo Texto");
     			return false;
  			}
  			
  			document.form1.acao.value='1';
			document.form1.submit();
			return true;
        } 
    } 
    alert("Por favor selecione pelo menos um Usuário"); 
    return false; 
  	
}
   

</script>
    <input name="todas" type="checkbox" id="todas" value="checkbox" onClick="selecionar_todas(this.checked)"><span id="checar">Marcar todos</span>
			<table width="100%" border="0">
              <tr ><td valign="top" class="style1">
<? } ?>	            
<?

if($_GET['todos']<>'1'){
  
   
    $campop = $_POST['campop'];
    if($chave==''){
    	$chave = '';
    }else{
	  	$chave = $_POST['chave'];
	}
    
    if($campop=='1'){  
	  $query = mysql_query("SELECT i.im_cod, i.im_nome, u.u_cod, u.u_nome, c.ci_nome, e.e_uf FROM usuarios u INNER JOIN rebri_imobiliarias i ON (u.cod_imobiliaria=i.im_cod) INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod) WHERE u.u_status='Ativo' and u.u_cod!='".$u_cod."' AND i.im_nome LIKE '%".$chave."%'");
	  $i = 0;
	  $col = 1;
	  while($linha = mysql_fetch_array($query)){
		 echo('
		 	 <input type="hidden" name="cod_imo_'.$i.'" id="cod_imo_'.$i.'" value="'.$linha['im_cod'].'">
			 <input type="checkbox" name="me_usuario_'.$i.'" id="me_usuario"  value="'.$linha['u_cod'].'"> '.$linha['u_nome'].' ('.$linha['im_nome'].' - '.$linha['ci_nome'].'/'.$linha['e_uf'].')
		 ');
		if ($col > 2) {
			print "</td></tr><tr><td valign='top' class='style1'>";
			$col = 1;
		} elseif ($col != 1) {
			print "</td><td valign='top' class='style1'>";
		}
		print "<br>";
	  $i++;
	  $col++;
	  }  
	}elseif($campop=='2'){
	  $query = mysql_query("SELECT i.im_cod, i.im_nome, u.u_cod, u.u_nome, c.ci_nome, e.e_uf FROM usuarios u INNER JOIN rebri_imobiliarias i ON (u.cod_imobiliaria=i.im_cod) INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod) WHERE u.u_status='Ativo' and u.u_cod!='".$u_cod."' AND u.u_nome LIKE '%".$chave."%'");
  	  $i = 0;
	  $col = 1;
	  while($linha = mysql_fetch_array($query)){
		 echo('
		 	 <input type="hidden" name="cod_imo_'.$i.'" id="cod_imo_'.$i.'" value="'.$linha['im_cod'].'">
			 <input type="checkbox" name="me_usuario_'.$i.'" id="me_usuario"  value="'.$linha['u_cod'].'"> '.$linha['u_nome'].' ('.$linha['im_nome'].' - '.$linha['ci_nome'].'/'.$linha['e_uf'].')
		 ');
		if ($col > 2) {
			print "</td></tr><tr><td valign='top' class='style1'>";
			$col = 1;
		} elseif ($col != 1) {
			print "</td><td valign='top' class='style1'>";
		}
		print "<br>";
	  $i++;
	  $col++;
	  }  
	}elseif($campop=='3'){
	  $query = mysql_query("SELECT i.im_cod, i.im_nome, u.u_cod, u.u_nome, c.ci_nome, e.e_uf FROM usuarios u INNER JOIN rebri_imobiliarias i ON (u.cod_imobiliaria=i.im_cod) INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod) WHERE u.u_status='Ativo' and u.u_cod!='".$u_cod."' AND e.e_uf LIKE '%".$chave."%'");
	  $i = 0;
	  $col = 1;
	  while($linha = mysql_fetch_array($query)){
		 echo('
		 	 <input type="hidden" name="cod_imo_'.$i.'" id="cod_imo_'.$i.'" value="'.$linha['im_cod'].'">
			 <input type="checkbox" name="me_usuario_'.$i.'" id="me_usuario"  value="'.$linha['u_cod'].'"> '.$linha['u_nome'].' ('.$linha['im_nome'].' - '.$linha['ci_nome'].'/'.$linha['e_uf'].')
		 ');
		if ($col > 2) {
			print "</td></tr><tr><td valign='top' class='style1'>";
			$col = 1;
		} elseif ($col != 1) {
			print "</td><td valign='top' class='style1'>";
		}
		print "<br>";
	  $i++;
	  $col++;
	  }  
	}elseif($campop=='4'){
	  $query = mysql_query("SELECT i.im_cod, i.im_nome, u.u_cod, u.u_nome, c.ci_nome, e.e_uf FROM usuarios u INNER JOIN rebri_imobiliarias i ON (u.cod_imobiliaria=i.im_cod) INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod) WHERE u.u_status='Ativo' and u.u_cod!='".$u_cod."' AND c.ci_nome LIKE '%".$chave."%'");
  	  $i = 0;
	  $col = 1;
	  while($linha = mysql_fetch_array($query)){
		 echo('
		 	 <input type="hidden" name="cod_imo_'.$i.'" id="cod_imo_'.$i.'" value="'.$linha['im_cod'].'">
			 <input type="checkbox" name="me_usuario_'.$i.'" id="me_usuario"  value="'.$linha['u_cod'].'"> '.$linha['u_nome'].' ('.$linha['im_nome'].' - '.$linha['ci_nome'].'/'.$linha['e_uf'].')
		 ');
		if ($col > 2) {
			print "</td></tr><tr><td valign='top' class='style1'>";
			$col = 1;
		} elseif ($col != 1) {
			print "</td><td valign='top' class='style1'>";
		}
		print "<br>";
	  $i++;
	  $col++;
	  }  
	}
?>
</td></tr>
</table>
<input type="hidden" name="i" id="i" value="<?=$i; ?>">
<?
}elseif($_GET['todos']=='1'){
?>
<script language="javascript">
function selecionar_todas(retorno){
if(retorno==true){
for(i=0;i<form1.length;i++){
if(form1.elements[i].type=="checkbox" && form1.elements[i].name!="todas"){
  if(form1.elements[i].checked==false){
   form1.elements[i].checked=true;
   var elem = document.getElementById("checar");
   elem.innerHTML = "Desmarcar todos";
   }
}
}
} else {
for(i=0;i<form1.length;i++){
if(form1.elements[i].type=="checkbox" && form1.elements[i].name!="todas"){
  if(form1.elements[i].checked==true){
   form1.elements[i].checked=false;
   var elem = document.getElementById("checar");
   elem.innerHTML = "Marcar todos";
  }
}
}
}
}

function VerificaCampo(){

  if(document.form1.me_assunto.value.length==0)
  {
     alert("Por favor, preencha o campo Assunto");
     return false;
  }
  if(document.form1.me_texto.value.length==0)
  {
	 alert("Por favor, preencha o campo Texto");
     return false;
  }

document.form1.acao.value='1';
document.form1.submit();
return true;	
}
   

</script>
<?
     echo "Todos usuários da Rede Rebri";
}
?>         
             
            </td>
          </tr>
          	    <!--select name="me_usuario" id="me_usuario" class="campo">
                <option value="">Selecione</option>
				<option value="todos">Todos os usuários</option>
                <?
                /*
	  			$busca_usuario = mysql_query("SELECT u_cod, u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_nome");
	 			while($linha = mysql_fetch_array($busca_usuario)){
	  				echo "<option value=\"".$linha['u_cod']."\">".$linha[u_nome]."</option>";
	  			}
	  			*/
	  			?>
              </select-->
          <tr bgcolor="#EDEEEE">
            <td width="20%" class="style1"><b>Assunto:</b></td>
            <td width="80%" class="style1"><input name="me_assunto" type="text" class="campo" id="me_assunto" size="40"></td>
          </tr>
          <tr bgcolor="#EDEEEE">
            <td class="style1"><b>Texto:</b></td>
            <td class="style1">
            <textarea name="me_texto" id="me_texto" cols="40" rows="5" class="campo"></textarea></td>
          </tr>
          <tr>
            <td colspan="2" bgcolor="#EDEEEE">
				<input type="hidden" name="acao" id="acao" value="0">
              <input type="button" value="Enviar mensagem" name="B1" class="campo3" onClick="VerificaCampo();">
            </font></td>
          </tr>
        </table>
      </form>
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
?></td>
  </tr>
</table>
<?  if(session_is_registered("valid_user")){ ?>
<br>
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
    <? include("voltar.php"); ?>
    </td>
  </tr>	
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
<? } ?>
</body>
</html>