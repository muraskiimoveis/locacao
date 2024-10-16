<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
//verificaAcesso();
//verificaArea("GERAL_BANNER");
include("style.php");

function retira_acentos( $name )
{
  $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
                     , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"
                     ,"'","´","`","/","\\","~","^","¨"," ");
  $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C"
                     ,"","","","","_","_","_","_","");
  return urlencode(strtolower(str_replace( $array1, $array2, $name )));
}

?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>

<script language="javascript">


function VerificaCampo(){

  var nome_arquivo, primeira_letra;

	if(document.form1.b_tipo_arquivo.selectedIndex== 0)
	{
		alert( "Selecione o campo Tipo de Arquivo!" );
		document.form1.b_tipo_arquivo.focus();
		document.form1.b_tipo_arquivo.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
		document.form1.b_tipo_arquivo.style.backgroundColor = '#FFFFFF';
	}

	if(document.form1.b_img_n.value=="")
	{
		alert( "Selecione o campo Arquivo!" );
		document.form1.b_img_n.focus();
		document.form1.b_img_n.style.backgroundColor = '#FF727B';
		return false;
	}
	else if(document.form1.b_img_n.value!="")
	{

		arquivo = (document.form1.b_img_n.value);
		tipo = arquivo.substring(arquivo.length-4,arquivo.length);
		tipo = tipo.toLowerCase();

		if ((tipo != ".ret") && (tipo != ".txt"))
		{
		  	alert("Formato não permitido!");
	   		document.form1.b_img_n.focus();
	   		document.form1.b_img_n.style.backgroundColor = '#FF727B';
			return false;
		}
    else if((document.form1.b_tipo_arquivo.value=="RET")&&(tipo == ".ret"))
		{
                    if(tipo == ".ret")
                   {
                        //nome_arquivo = arquivo.substring(0,1);
                        nome_arquivo = document.getElementById("b_img_n").files[0].name;
                        primeira_letra = nome_arquivo.substring(0,1);
                        //alert( document.getElementById("b_img_n").files[0].name);
                        //alert(nome_arquivo);
                        if(primeira_letra != "R")
                        {
                            alert( "Selecione o campo Arquivo com o arquivo de nome Rnnnnnnn.RET pois você selecionou o Arquivo Errado!" );
                            document.form1.b_img_n.focus();
                            document.form1.b_img_n.style.backgroundColor = '#FF727B';
                            return false;
                        }
                        else
                        {
                            document.form1.b_img_n.style.backgroundColor = '#FFFFFF';
                        }
                   }
		else
		{
                        alert( "Selecione o campo Arquivo com o arquivo de Retorno CEF!" );
                        document.form1.b_img_n.focus();
                        document.form1.b_img_n.style.backgroundColor = '#FF727B';
                        return false;
		}
		}
    else if((document.form1.b_tipo_arquivo.value=="TXT")&&(tipo == ".txt"))
    {
        if(tipo == ".txt")
        {
           
              //nome_arquivo = arquivo.substring(0,arquivo.length-4);
              
              //nome_arquivo = (document.form1.b_img_n.value);
              nome_arquivo = document.getElementById("b_img_n").files[0].name;
              primeira_letra = nome_arquivo.substring(0,nome_arquivo.length-4);
              primeira_letra = primeira_letra.replace(/^\s+|\s+$/g,"");
              //alert(primeira_letra);
              if(primeira_letra != "extrato")
              {
                      alert( "Selecione o campo Arquivo com o arquivo de nome [extrato.txt] em letras minúsculas, pois você selecionou o Arquivo Errado!" );
                      document.form1.b_img_n.focus();
                      document.form1.b_img_n.style.backgroundColor = '#FF727B';
                      return false;
              }
              else
              {
                document.form1.b_img_n.style.backgroundColor = '#FFFFFF';
              }
        }
        else
        {
               alert( "Selecione o campo Arquivo com o arquivo de LIQUIDACAO de COBRANCA da CEF!" );
               document.form1.b_img_n.focus();
               document.form1.b_img_n.style.backgroundColor = '#FF727B';
               return false;
        }
    }
		else
		{
               alert( "Selecione o Arquivo Correto!!" );
               document.form1.b_img_n.focus();
               document.form1.b_img_n.style.backgroundColor = '#FF727B';
               return false;
		}
	}

document.form1.cadastra.value='1';
document.form1.submit();
return true;
}
</script>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<script src="AC_RunActiveContent.js" type="text/javascript"></script>
<script src="AC_ActiveX.js" type="text/javascript"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php include("menu.php"); ?></td>
  </tr>
</table>
<?php
if($_POST['cadastra']=='1')
{

      //echo " Nome do Arquivo ==> ".$_FILES['b_img_n']['name'];
      //die();
      // Guardando na Session

      $_SESSION['arquivo_retorno'] = $_FILES['b_img_n']['name'];

      // Pasta onde o arquivo vai ser salvo
      $_UP['pasta'] = 'cnab/retorno/';

      // Tamanho máximo do arquivo (em Bytes)
      $_UP['tamanho'] = 524288; // 512kb

      // Array com as extensões permitidas
      $_UP['extensoes'] = array('ret','txt');

      // Renomeia o arquivo? (Se true, o arquivo será salvo como um nome único)
      $_UP['renomeia'] = false;

      // Array com os tipos de erros de upload do PHP
      $_UP['erros'][0] = 'Não houve erro';
      $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
      $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
      $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
      $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

      // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
      if ($_FILES['b_img_n']['error'] != 0) {
      die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['b_img_n']['error']]);
      exit; // Para a execução do script
      }

      // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

      // Faz a verificação da extensão do arquivo
      $extensao = strtolower(end(explode('.', $_FILES['b_img_n']['name'])));
      if (array_search($extensao, $_UP['extensoes']) === false) {
      echo "Por favor, envie somente arquivo com extensao: ret ou txt";
      }
       // Faz a verificação do tamanho do arquivo
      else if ($_UP['tamanho'] < $_FILES['b_img_n']['size']) {
      echo "O arquivo enviado eh muito grande, envie arquivos de ateh 512Kb. ==> ".$_FILES['b_img_n']['size'];
      }
      // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
      else {
      // Primeiro verifica se deve trocar o nome do arquivo
      if ($_UP['renomeia'] == true) {
      // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .ret
      $nome_final = time().'.ret';
      } else {
      // Mantém o nome original do arquivo
      $nome_final = $_FILES['b_img_n']['name'];
      }

      // Depois verifica se é possível mover o arquivo para a pasta escolhida
      if (move_uploaded_file($_FILES['b_img_n']['tmp_name'], $_UP['pasta'] . $nome_final)) {
      // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
      //echo "Upload efetuado com sucesso! ==> ".$extensao;
      //die();
      //echo '<br /><a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';

          if($extensao == 'ret'){
            include('boleto/retorno_cnab240_cef.php');
          }elseif($extensao == 'txt'){
            include('boleto/concilia_cobranca_cef.php');
          }

      } else {
      // Não foi possível fazer o upload, provavelmente a pasta está incorreta
      echo "Não foi possível enviar o arquivo, tente novamente";
      }

      }

}

?>
<form method="post" enctype="multipart/form-data" action="p_concilia_retornocef.php" name="form1">
<input type="hidden" name="b_cod" id="b_cod" value="<? echo($b_cod); ?>">
<input type="hidden" name="b_img" id="b_img" value="<? echo($b_img); ?>">
<table width="75%" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr height="50">
    <td class="style1" colspan="2" align="center"><b>Concilia Arquivos de Cobranca CEF</b></td>
  </tr>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1"><b>Tipo de Arquivo:</b></td>
    <td width="80%" align="left" class="style1"><select name="b_tipo_arquivo" class="campo" id="b_tipo_arquivo" >
      	<option value="">Selecione</option>
    	<option value="RET" <? if($b_tipo_arquivo=='RET'){ print "SELECTED"; } ?>>RET</option>
      <option value="TXT" <? if($b_tipo_arquivo=='TXT'){ print "SELECTED"; } ?>>TXT</option>
    </select></td>
  </tr>
  <tr class="fundoTabela">
    <td width="20%" align="left" class="style1" valign="top"><b>Retorno:</b></td>
    <td width="80%" align="left" class="style1"><input type="file" name="b_img_n" id="b_img_n" class="campo" size="40">
        <strong>Obs.:</strong>Formato Permitido: (RET) do Sistema de Cobranca e (TXT) do Gerenciador Web CEF</td>
  </tr>
  <tr>
    <td colspan="4" align="left">
   	<input type="hidden" name="cadastra" id="cadastra" value="0">
   	<input type="button" name="concilia" id="concilia" class="campo3" value="Concilia" Onclick="VerificaCampo();">
   <!--	<input type="button" name="limpar" id="limpar" class="campo3" value="Limpar" Onclick="window.location.href='p_insert_banner.php'"> -->
   </td>
  </tr>
  </table>
<?
mysql_close($con);
?>
</form>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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