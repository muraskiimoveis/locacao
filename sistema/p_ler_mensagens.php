<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("MENSAGENS_GERAL");
?>
<html>
<head>
<?php
include("style.php");
?>
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<link href="style.css" rel="stylesheet" type="text/css" />
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
</head>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and
	($u_tipo == "admin") or ($u_tipo == "func"))){
*/
?>
<body onUnload="window.opener.location.reload()">
<table width="100%" border="0">
  <tr>
    <td align="center">
<?php

if($_POST['cadastra'] == 1){

  	$assunto = $_POST['assunto'];
	$mensagem = "RE: ".$assunto;
	$data = date("Y-m-d");
	$hora = date("H:i:s");

	$insere = mysql_query("INSERT INTO mensagens (cod_imobiliaria, me_cod_user_envia, me_cod_user_recebe, me_assunto, me_texto, me_data, me_hora, me_status) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$user_recebe."','".$mensagem."','".$textos."','".$data."','".$hora."','0')");
	echo('<script language="javascript">alert("Mensagem enviada com sucesso!");window.close();</script>');
}

$id_msg = $_GET['id_msg'];

if(!empty($id_msg) && $_POST['cadastra'] <> 1 && $_GET['env']==''){

	$datar = date("d/m/Y");
	$datare = date("Y-m-d");
	$horar = date("H:i:s");

	$busca2 = mysql_query("SELECT t1.me_data, t1.me_hora, t1.me_cod_user_envia, t1.me_assunto, t1.me_texto, t2.u_nome FROM mensagens t1, usuarios t2 WHERE t1.me_id = '".$id_msg."' and t1.me_cod_user_recebe = t2.u_cod");
	while($linha = mysql_fetch_array($busca2)){
      	$datae = formataDataDoBd($linha['me_data']);
		$horae = $linha['me_hora'];
		$nomee = $linha['u_nome'];
		$user_envia = $linha['me_cod_user_envia'];
		$msge = $linha['me_texto'];
		$assuntoe = $linha['me_assunto'];
	}

	$texto = "<br>Esta é uma confirmação de recebimento da mensagem que você enviou para <b>".$nomee."</b> em <b>".$datae."</b> <b>".$horae."</b> referente ao assunto: <b>".$assuntoe."</b> e o texto enviado: <b>".$msge."</b><br><br>"; //Esta confirmação verifica se a mensagem foi exibida no computador do destinatário em ".$datar." ".$horar."

	if(!strpos("--".$assuntoe, 'Confirmação de Leitura')){


	  	$busca3 = mysql_query("SELECT * FROM mensagens WHERE me_id='".$id_msg."' and me_status='1'");
		 $num_rows = mysql_num_rows($busca3);
 	    if($num_rows == 0){
		  mysql_query("INSERT INTO mensagens (cod_imobiliaria, me_cod_user_envia, me_cod_user_recebe, me_assunto, me_texto, me_data, me_hora, me_status) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$user_envia."','Confirmação de Leitura - Referente ao assunto: ".$assuntoe."','".$texto."','".$datare."','".$horar."','0')");
		}
	}

	mysql_query("UPDATE mensagens SET me_status = 1 WHERE me_id = '".$id_msg."'");
}


?>
<script language="javascript">
function VerificaCampo()
{

var msg = '';

	   if(document.form1.textos.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Resposta.\n";
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.cadastra.value='1';
			document.form1.submit();
	   }

}

<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode;
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}

//Funcao para validar o formato da foto

  // width to resize large images to
var maxWidth=100;
  // height to resize large images to
var maxHeight=100;
  // valid file types
var fileTypes=["jpg","jpeg"];
  // the id of the preview image tag
var outImage="previewField";
  // what to display when the image is not valid
var defaultPic="spacer.gif";

/***** DO NOT EDIT BELOW *****/

function preview(what){
  var source=what.value;
  var ext=source.substring(source.lastIndexOf(".")+1,source.length).toLowerCase();
  for (var i=0; i<fileTypes.length; i++) if (fileTypes[i]==ext) break;
  globalPic=new Image();
  if (i<fileTypes.length) globalPic.src=source;
  else {
    globalPic.src=defaultPic;
    alert("Apenas arquivos JPG s&atilde;o aceitos\nPor favor selecione uma nova imagem com uma das extens&otilde;es abaixo:\n\n"+fileTypes.join(", "));
  }
  setTimeout("applyChanges()",200);
}
var globalPic;
function applyChanges(){
  var field=document.getElementById(outImage);
  var x=parseInt(globalPic.width);
  var y=parseInt(globalPic.height);
  if (x>maxWidth) {
    y*=maxWidth/x;
    x=maxWidth;
  }
  if (y>maxHeight) {
    x*=maxHeight/y;
    y=maxHeight;
  }
  field.style.display=(x<1 || y<1)?"none":"";
  field.src=globalPic.src;
  field.width=x;
  field.height=y;
}

//  End -->
      </script>
      <div align="center">
      <center>
  <?
 		$busca = mysql_query("SELECT t1.me_id, t1.me_data, t1.me_hora, t1.me_assunto, t1.me_texto, t1.me_cod_user_envia, t1.me_status, t2.u_nome as enviado, t3.u_nome as para FROM mensagens t1 INNER JOIN usuarios t2 ON (t1.me_cod_user_envia = t2.u_cod) INNER JOIN usuarios t3 ON (t1.me_cod_user_recebe = t3.u_cod) WHERE t1.me_id = '".$id_msg."'");
		 while($linha = mysql_fetch_array($busca)){
		  $id_msg = $linha['me_id'];
		  $data = formataDataDoBd($linha['me_data']);
		  $hora = $linha['me_hora'];
		  $enviado = $linha['enviado'];
		  $para = $linha['para'];
		  $assunto = $linha['me_assunto'];
		  $texto = $linha['me_texto'];
		  $user_recebe = $linha['me_cod_user_envia'];

			$busca2 = mysql_query("SELECT u_status FROM usuarios WHERE u_cod = '".$user_recebe."'");
 			while($linha2 = mysql_fetch_array($busca2)){
 		    	$status_user = $linha2['u_status'];
 			}
 		}

?>
<form method="post" action="" name="form1" id="form1">
<input type="hidden" name="assunto" id="assunto" value="<?=$assunto ?>">
<input type="hidden" name="user_recebe" id="user_recebe" value="<?=$user_recebe ?>">
  <table width="95%" border="0" cellspacing="1" cellpadding="1">
    <tr>
    	<td height="20px">&nbsp;</td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Data/ Hora</b></td>
      <td width="80%" class="style1"><?=$data ?> - <?=$hora ?></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Enviado por </b></td>
      <td class="style1"><?=$enviado ?></td>
    </tr>
     <tr class="fundoTabela">
      <td class="style1"><b>Para </b></td>
      <td class="style1"><?=$para ?></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Assunto</b></td>
      <td class="style1"><?=$assunto ?></td>
    </tr>
	<tr>
      <td class="style1">&nbsp;</td>
      <td class="style1"><img src="images/titulo_rebri_branco2.jpg" /></td>
    </tr>
    <? if(!strpos("--".$assunto, 'Confirmação de Leitura') && $status_user=='Ativo'){ ?>
	<tr class="fundoTabela">
      <td class="style1"><b>Pergunta</b></td>
      <td><table border="0" cellspacing="2" cellpadding="0" bgcolor="#f3f3f3" width="300"><tr><td class="style1"><b><?=$texto ?></b></td></tr></table></td>
    </tr>
    <? if($_GET['env']==''){ ?>
    <tr class="fundoTabela">
      <td class="style1"><b>Resposta</b></td>
      <td class="style1"><textarea type="textarea" name="textos" id="textos" cols="40" rows="3" class="campo"></textarea><br><span class="style7">Digite a "mensagem" se desejar responder e depois clique em "Enviar Resposta"</span></td>
    </tr>
    <? } ?>
    <? }else{ ?>
    <tr class="fundoTabela">
      <td class="style1"><b>Texto</b></td>
      <td class="style1"><?=$texto ?></td>
    </tr>
    <? } ?>
	<tr class="fundoTabela">
      <td class="style1">&nbsp;</td>
      <td class="style1">Fale Conosco / Assunto Gerais<br>
        Suporte do Sistema </td>
    </tr>
    <tr>
      <td colspan="2"><input type="hidden" name="cadastra" id="cadastra" value="0">
<? if(!strpos("--".$assunto, 'Confirmação de Leitura') && $status_user=='Ativo' && $_GET['env']==''){ ?>
	       <input type="button" value="Enviar Resposta" name="responder" id="responder" class=campo3 Onclick="VerificaCampo();">
 <? } ?>
      <input type="button" value="Fechar" name="fechar" id="fechar" class=campo3 Onclick="window.close();"></td>
    </tr>
  </table>
  <br>
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
</body>
</html>
