<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_VEND");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
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
</head>
<?php
if($_GET['codi']){
 $codi = $_GET['codi'];
}else{
 $codi = $_POST['codi'];
}

if($codi == $_SESSION['cod_imobiliaria']){
  $codi = $_SESSION['cod_imobiliaria'];
}else{
  $codi = $codi;
}
	$sql = mysql_query("SELECT angariador FROM muraski WHERE cod='".$_GET['cod']."' AND cod_imobiliaria='".$codi."'");
	while($linha = mysql_fetch_array($sql)){
		$cod_angariador = $linha['angariador'];
	}
	
	$queryA = mysql_query("SELECT u_nome FROM usuarios WHERE u_cod='".$cod_angariador."' AND cod_imobiliaria='".$codi."'");
	while($notA = mysql_fetch_array($queryA)){
	   $nome_angariador = $notA['u_nome'];
	}

if($_POST['acao'] == 1){
  
    $me_usuario = $_POST['me_usuario'];
	$me_assunto = $_POST['me_assunto'];
    $me_texto = $_POST['me_texto'];
    $data = date("Y-m-d");
    $hora = date("H:i:s");
         
	$insere = "INSERT INTO mensagens (cod_imobiliaria, me_cod_user_envia, me_cod_user_recebe, me_assunto, me_texto, me_data, me_hora, me_status) VALUES ('".$codi."','".$u_cod."','".$me_usuario."','".$me_assunto."','".$me_texto."','".$data."','".$hora."','0')";
	$result = mysql_query($insere) or die("Não foi possível atualizar suas informações. $insere");			
	echo "<br><div align=\"center\"><span class=\"style4\">Mensagem enviada com sucesso!</span><br><br>";
	echo '<input type="button" value="Fechar Janela" name="B1" class="campo3" onClick="javascript:window.close();"></div>';
	exit;

}
?>
<body>
<form method="post" action="" name="form1" id="form1">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
    	<td colspan="6">
      		<p align="center" class="style48"><b>Angariador</b></p>
    	</td>
	</tr>
    <tr bgcolor="#EDEEEE">
      <td width="20%" class="style1"><b>Angariador:</b></td>
      <td width="80%" class="style1"><input name="me_usuario" type="text" class="campo" id="me_usuario" size="5" value="<?=$cod_angariador; ?>" readonly> <input name="me_usuario1" type="text" class="campo" id="me_usuario1" size="40" value="<?=$nome_angariador; ?>" readonly></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class="style1"><b>Assunto:</b></td>
      <td class="style1"><input name="me_assunto" type="text" class="campo" id="me_assunto" size="40"></td>
    </tr>
    <tr bgcolor="#EDEEEE">
      <td class="style1"><b>Texto:</b></td>
      <td class="style1"><textarea name="me_texto" id="me_texto" cols="40" rows="5" class="campo"></textarea></td>
    </tr>
    <tr>
      <td><input type="hidden" name="acao" id="acao" value="0">
          <input type="button" value="Enviar mensagem" name="B1" class="campo3" onClick="VerificaCampo();">
          </font></td>
      <td></td>
    </tr>
	</table>
</form>
<?
mysql_close($con);
?>
</body>
</html>