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
verificaArea("GERAL_COMISSAO");

?>
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
<br>
<html>
<?php
include("style.php");
?>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="JavaScript">
function VerificaCampo()
{

var msg = '';

	   if(document.formulario.im_nome.value.length==0)
	   {
		       msg += "Por favor, selecione o campo Nome.\n";
       }
       if(document.formulario.im_n_conselho.value=="")
	   {
		       msg += "Por favor, preencha o campo N° do Creci.\n";
	   }
	   if(document.formulario.im_cnpj.value=="")
	   {
		       msg += "Por favor, preencha o campo CPNJ.\n";
	   }
	   else if(!isCNPJ(RemoveMascaraCNPJ(document.formulario.im_cnpj.value)))
       {
	           msg += "CNPJ digitado é inválido!\n";
	   }
	   if(document.formulario.im_contato.value=="")
	   {
		       msg += "Por favor, preencha o campo Contato.\n";
	   }
	   if(document.formulario.im_nacionalidade.value=="")
	   {
		       msg += "Por favor, preencha o campo Nacionalidade.\n";
	   }
	   if (document.formulario.im_est_civil.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Estado Civil.\n";
	   }
       /*
       if(document.formulario.im_email.value.length==0)
	   {
		       msg += "Por favor, preencha o campo E-mail.\n";
       }
       if(document.formulario.im_senha.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Senha.\n";
       }
       */
       if(document.formulario.im_tel.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Telefone.\n";
       }
       if (document.formulario.im_estado.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Estado.\n";
	   }
	   /*
	   if (document.formulario.im_cidade.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Cidade.\n";
	   }
	   */
	   if(document.formulario.im_end.value.length==0)
	   {
		     msg += "Por favor, preencha o campo Endereço.\n";
       }
       if(document.formulario.com_angariador.value.length==0)
	   {
		     msg += "Por favor, preencha o campo Comissão Angariador.\n";
       }
       if(document.formulario.com_vendedor.value.length==0)
	   {
		     msg += "Por favor, preencha o campo Comissão Vendedor.\n";
       }
       if(document.formulario.com_indicador.value.length==0)
	   {
		     msg += "Por favor, preencha o campo Comissão Indicador.\n";
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
	        document.formulario.atualiza.value='1';
			document.formulario.submit();
	   }

}


</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/

	echo $atualiza;
//Atualizar Imobili&aacute;ria
if($atualiza == "1")
{
	
/*
	$pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$im_email."' AND u_senha='".md5($im_senha)."' AND cod_imobiliaria='".$im_cod."'";
	$pw_result = mysql_query($pw_query) or die("N&atilde;o foi possivel inserir suas informa&ccedil;&otilde;es");
	$pw_rows = mysql_num_rows($pw_result);
	if ($pw_rows == 0) {  
*/	  

	$im_senha = base64_encode($im_senha);
	echo $im_senha;
	
	$nome_imobiliaria = $im_nome;
	$im_estado = $_POST['im_estado'];
	$im_cidade = $_POST['im_cidade'];
	
	// tira os acentos e espa&ccedil;o
	/*
	$im_nome = ereg_replace("[&Aacute;&Agrave;&Acirc;&Atilde;]","A",$im_nome);
	$im_nome = ereg_replace("[&aacute;&agrave;&acirc;&atilde;&ordf;]","a",$im_nome);
	$im_nome = ereg_replace("[&Eacute;&Egrave;&Ecirc;]","E",$im_nome);
	$im_nome = ereg_replace("[&eacute;&egrave;&ecirc;]","e",$im_nome);
	$im_nome = ereg_replace("[&Oacute;&Ograve;&Ocirc;&Otilde;]","O",$im_nome);
	$im_nome = ereg_replace("[&oacute;&ograve;&ocirc;&otilde;&ordm;]","o",$im_nome);
	$im_nome = ereg_replace("[&Uacute;&Ugrave;&Ucirc;]","U",$im_nome);
	$im_nome = ereg_replace("[&uacute;&ugrave;&ucirc;]","u",$im_nome);
	$im_nome = ereg_replace("[&iacute;&igrave;&icirc;]","i",$im_nome);
	$im_nome = ereg_replace("[&Iacute;&Igrave;&Icirc;]","I",$im_nome);
	$im_nome = str_replace("&Ccedil;","C",$im_nome);
	$im_nome = str_replace("&ccedil;","c",$im_nome);
	$im_nome = str_replace(" ","",$im_nome);
	*/
	
	// pega o nome da imobili&aacute;ria, deixa em min&uacute;sculas e pega os 6 primeiros caracteres se caso for menor que 6 complementa com 0
	if(strlen($im_nome) < 6){
	    if(strlen($im_nome) == 5){
     		$nome_pasta = strtolower($im_nome."0");  
     	}elseif(strlen($im_nome) == 4){
		   $nome_pasta = strtolower($im_nome."00");  
		}elseif(strlen($im_nome) == 3){
		  $nome_pasta = strtolower($im_nome."000");  
		}elseif(strlen($im_nome) == 2){
		  $nome_pasta = strtolower($im_nome."0000");  
		}elseif(strlen($im_nome) == 1){  
		  $nome_pasta = strtolower($im_nome."00000");  
		}
	}elseif(strlen($im_nome) >= 6){
		$nome_pasta = strtolower(substr($im_nome,0,6));
	}

	// verifica se a pasta j&aacute; existe 
	if (file_exists("../imobiliarias/" . $nome_pasta)) {
   		$cont = 1; // contador de pastas
   
   	// verifica qual a ultima pasta criada e incrementa 1 
   	while (file_exists("../imobiliarias/" . $nome_pasta . $cont)) {
       	$cont++;
   	}
   
   	$nome_pasta .= $cont;
	}
	
	//busca o nome da pasta
	$busca = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$im_cod."'");
    while($linha = mysql_fetch_array($busca)){
         $pasta = $linha['nome_pasta'];
    }
	
	// cria nova pasta 
	$dirp = "../imobiliarias/".$nome_pasta;
	rename("../imobiliarias/".$pasta, $dirp);
	
	$query = "update rebri_imobiliarias set im_nome='$nome_imobiliaria', im_contato='$im_contato', im_nacionalidade='$im_nacionalidade', im_est_civil='$im_est_civil', im_n_conselho='$im_n_conselho', im_cnpj='$im_cnpj', im_tel='$im_tel'
	, im_fax='$im_fax', im_cel='$im_cel', 
	 im_cidade='$im_cidade', im_estado='$im_estado', im_end='$im_end', im_bairro='$im_bairro'
	, im_cep='$im_cep', im_site='$im_site', im_desc='$im_desc', nome_pasta='$nome_pasta', comissao_angariador='$com_angariador', comissao_vendedor='$com_vendedor', comissao_indicador='$com_indicador' where im_cod='$im_cod'";
	$result = mysql_query($query) or die("N&atilde;o foi poss&iacute;vel atualizar suas informa&ccedil;&otilde;es. $query");
	
?>
<p align="center"> Voc&ecirc; atualizou a imobili&aacute;ria <i><?php print("$im_nome"); ?></i>.</p>
<?php
/*
	}else{
	  echo ('<script language="javascript">alert("E-mail e/ou senha j&aacute; cadastrados!");document.location.href="p_imobiliarias.php";</script>');   
	}
*/	
}

	$query2 = "select *, (select ci_nome from rebri_cidades where ci_cod=im_cidade) as cidade_nome from rebri_imobiliarias where im_cod = '".$_SESSION['cod_imobiliaria']."'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$ano1 = substr ($not2[im_nasc], 0, 4);
	$mes1 = substr($not2[im_nasc], 5, 2 );
	$dia1 = substr ($not2[im_nasc], 8, 2 );
	
	$not2[im_senha] = base64_decode($not2[im_senha]);
	$img = $not2['im_img'];

?>
<script language="JavaScript">
function Dados(valor) {
	  try {
         ajax = new ActiveXObject("Microsoft.XMLHTTP");
      } 
      catch(e) {
         try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser n&atilde;o tem recursos para uso do Ajax");
               ajax = null;
            }
         }
      }
	  if(ajax) {
		 document.forms[0].im_cidade.options.length = 1;
		 idOpcao  = document.getElementById("opcoes");
	     ajax.open("POST", "cidades.php", true);
		 ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 ajax.onreadystatechange = function() {
			if(ajax.readyState == 1) {
			   idOpcao.innerHTML = "Aguarde...!";
	        }
            if(ajax.readyState == 4 ) {
			   if(ajax.responseXML) {
			      processXML(ajax.responseXML);
			   }
			   else {
				   idOpcao.innerHTML = "Selecione o Estado";
			   }
            }
         }
	     var params = "estado="+valor;
         ajax.send(params);
      }
   }
   function processXML(obj){
      var dataArray   = obj.getElementsByTagName("cidade");
	  if(dataArray.length > 0) {
         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
	        idOpcao.innerHTML = "Selecione uma op&ccedil;&atilde;o";
			var novo = document.createElement("option");
			    novo.setAttribute("ci_cod", "opcoes");
			    novo.value = codigo;
			    novo.text  = descricao;
				document.forms[0].im_cidade.options.add(novo);
		 }
	  }
	  else {
		idOpcao.innerHTML = "Selecione o Estado";
	  }	  
 }

</script>
  <form method="post" name="formulario" action="p_imobiliarias.php">
  <input type="hidden" name="editar" value="1">
  <input type="hidden" name="atualiza" id="atualiza" value="0">
  <input type="hidden" value="<?php print("$not2[im_cod]"); ?>" name="im_cod">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="20%" class=style1>Nome:</td>
      <td width="80%" class=style1><input type="text" name="im_nome" id="im_nome" size="40" class="campo" value="<?php print("$not2[im_nome]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>N° do Creci:</td>
      <td width="80%" class=style2> <input type="text" name="im_n_conselho" size="10" class="campo" value="<?php print("$not2[im_n_conselho]"); ?>"></td>
    </tr>
	 <tr>
      <td width="20%" class=style2>CNPJ:</td>
      <td width="80%" class=style2> <input type="text" name="im_cnpj" size="20" class="campo" value="<?php print("$not2[im_cnpj]"); ?>" onKeyPress="return (Mascara(this,event,'###.###.###/####-##'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr>
      <td width="20%" class=style1>Contato:</td>
      <td width="80%" class=style1><input type="text" name="im_contato" id="im_contato" size="40" class="campo" value="<?php print("$not2[im_contato]"); ?>"></td>
    </tr>
     <tr>
      <td width="20%" class=style2>Nacionalidade:</td>
      <td width="80%" class=style2> <input type="text" name="im_nacionalidade" size="40" class="campo" value="<?php print("$not2[im_nacionalidade]"); ?>"></td>
    </tr>
	 <tr>
      <td width="20%" class=style2>Estado Civil:</td>
      <td width="80%" class=style2><select name="im_est_civil" class="campo">
	        <option value="0">Selecione</option>
			<option value="Casado(a)" <? if($not2[im_est_civil]=='Casado(a)'){ print "SELECTED"; } ?>>Casado(a)</option>
			<option value="Divorciado(a)" <? if($not2[im_est_civil]=='Divorciado(a)'){ print "SELECTED"; } ?>>Divorciado(a)</option>
			<option value="Separado(a)" <? if($not2[im_est_civil]=='Sperado(a)'){ print "SELECTED"; } ?>>Separado(a)</option>
			<option value="Solteiro(a)" <? if($not2[im_est_civil]=='Solteiro(a)'){ print "SELECTED"; } ?>>Solteiro(a)</option>
			<option value="Viúvo(a)" <? if($not2[im_est_civil]=='Viúvo(a)'){ print "SELECTED"; } ?>>Viúvo(a)</option>
	     </select></td>
    </tr>
    <!--tr>
      <td width="20%" class=style1>E-mail:</td>
      <td width="80%" class=style1><input type="text" name="im_email" id="im_email" size="40" class="campo" value="<?php //print("$not2[im_email]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style1>Senha:</td>
      <td width="80%" class=style7><input type="text" name="im_senha" id="im_senha" size="6" class="campo" maxlength="6" onKeyUp="return autoTab(this, 6, event);" value="<?php// print("$not2[im_senha]"); ?>">
        Obs.: 6 d&iacute;gitos</td>
    </tr-->
    <tr>
      <td width="20%" class=style1>Telefone:</td>
      <td width="80%" class=style1><input type="text" name="im_tel" id="im_tel" size="20" class="campo" value="<?php print("$not2[im_tel]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style1>Celular:</td>
      <td width="80%" class=style1><input type="text" name="im_cel" id="im_cel" size="20" class="campo" value="<?php print("$not2[im_cel]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style1>Fax:</td>
      <td width="80%" class=style1><input type="text" name="im_fax" id="im_fax" size="20" class="campo" value="<?php print("$not2[im_fax]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class="style1"><p align="left">Estado:</td>
      <td width="80%" class="style1"><select name="im_estado" id="im_estado" onChange="Dados(this.value);" class=campo>
        <option value="0">Selecione o Estado</option>
        <?
$sql = "SELECT e_cod, e_uf, e_nome FROM rebri_estados ORDER BY e_nome";
$sql = mysql_query($sql);
$row = mysql_num_rows($sql); 

	while($not4 = mysql_fetch_array($sql))
	{
?>
        <? //for($i=0; $i<$row; $i++) { ?>
        <?php
	if($not4[e_cod] == $not2[im_estado]){
		$estado_atual = $not4[e_nome];
?>
        <option selected value="<? echo $not4[e_cod]; ?>"> <? echo $not4[e_nome]; ?></option>
        <?php
	}
	else
	{
?>
        <option value="<? echo $not4[e_cod]; ?>"> <? echo $not4[e_nome]; ?></option>
        <?php
	}
 } 
 
?>
     
      </select></td>
    </tr>
    <tr>
      <td width="20%" class="style1">Cidade:</td>
      <td width="80%" class="style1"><select name="im_cidade" id="im_cidade" class="campo">
		<option id="opcoes" value="<? echo $not2[im_cidade]; ?>"><? echo $not2[cidade_nome]; ?></option>
      </select></td>
    </tr>
    <tr>
      <td width="20%" class=style1>Endere&ccedil;o:</td>
      <td width="80%" class=style1><input type="text" name="im_end" id="im_end" size="40" class="campo" value="<?php print("$not2[im_end]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style1>Bairro:</td>
      <td width="80%" class=style1><input type="text" name="im_bairro" id="im_bairro" size="40" class="campo" value="<?php print("$not2[im_bairro]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style1>CEP:</td>
      <td width="80%" class=style1><input type="text" name="im_cep" id="im_cep" size="8" class="campo" maxlength="8" onKeyUp="return autoTab(this, 8, event);" value="<?php print("$not2[im_cep]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style1>Site:</td>
      <td width="80%" class=style1><input type="text" name="im_site" id="im_site" size="40" class="campo" value="<?php print("$not2[im_site]"); ?>"></td>
    </tr>
    <!--tr>
      <td width="20%" class=style1 valign="top">*Imagem:</td>
      <td width="80%" class=style1><input type="text" name="im_img" id="im_img" size="20" class="campo" value="<?php print("$not2[im_img]"); ?>" readonly>
          <input name="button" type="button" class="campo" onClick="window.open('p_img_logo.php', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');" value="Selecionar">
        <br>
        Obs.: Clique em "Selecionar" e escolha a imagem desejada.</td>
    </tr-->
    <?php
/*
	if (file_exists($caminhob.$img))
	{
*/		
?>
    <tr>
      <td width="20%" class=style1 valign="top"></td>
      <td width="80%" class=style1><img src="<? echo($caminho_logos.$not2[im_img]); ?>"></td>
    </tr>
    <?php
/*
	}
*/	
?>
    <tr>
      <td width="20%" class=style1 valign="top">Descri&ccedil;&atilde;o:</td>
      <td width="80%" class=style1><textarea name="im_desc" id="im_desc" cols="30" rows="5" class="campo"><?php print("$not2[im_desc]"); ?></textarea></td>
    </tr>
    <tr>
      <td width="20%" class=style1 valign="top">Nome da pasta:</td>
      <td width="80%" class=style1><?php print("$not2[nome_pasta]"); ?></td>
    </tr>
    <tr>
      <td width="20%" class=style1 valign="top">Comissão Angariador:</td>
      <td width="80%" class=style1><input type="text" name="com_angariador" id="com_angariador" size="2" class="campo" value="<?php print("$not2[comissao_angariador]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style1 valign="top">Comissão Vendedor:</td>
      <td width="80%" class=style1><input type="text" name="com_vendedor" id="com_vendedor" size="2" class="campo" value="<?php print("$not2[comissao_vendedor]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style1 valign="top">Comissão Indicador:</td>
      <td width="80%" class=style1><input type="text" name="com_indicador" id="com_indicador" size="2" class="campo" value="<?php print("$not2[comissao_indicador]"); ?>"></td>
    </tr>
    <tr>
      <td colspan="5"><input class=campo type="button" value="Atualizar" name="B1" Onclick="VerificaCampo();">
    </tr>
  </table>
</table>
  </form>
<?php
	}
mysql_close($con);
?>
</body>
</html>