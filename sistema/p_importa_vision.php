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
verificaArea("GERAL_SINCRONIZAR");

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
ini_set('default_charset', 'UTF-8');
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
		       msg += "Por favor, preencha o campo CPF ou CPNJ.\n";
	   }
	   if(document.formulario.im_banco.value=="")
	   {
		       msg += "Por favor, preencha o campo Banco.\n";
	   }
	   if(document.formulario.im_agencia.value=="")
	   {
		       msg += "Por favor, preencha o campo Agência.\n";
	   }
	   if(document.formulario.im_conta.value=="")
	   {
		       msg += "Por favor, preencha o campo Conta.\n";
	   }
	   /*
	   else if(!isCNPJ(RemoveMascaraCNPJ(document.formulario.im_cnpj.value)))
       {
	           msg += "CNPJ digitado é inválido!\n";
	   }
	   */
	   if(document.formulario.im_contato.value=="")
	   {
		       msg += "Por favor, preencha o campo Contato.\n";
	   }
	   if(document.formulario.im_resp.value=="")
	   {
		       msg += "Por favor, preencha o campo Nome do Responsável.\n";
	   }
	   if(document.formulario.im_creci_resp.value=="")
	   {
		       msg += "Por favor, preencha o campo N° do Creci Responsável.\n";
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
	   if (document.formulario.im_cidade.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Cidade.\n";
	   }
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
       if (document.formulario.contrato_venda.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Contrato para Venda.\n";
	   }
	   if (document.formulario.contrato_locacao.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Contrato para Locação.\n";
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

<?
$cod_imobiliaria = $_SESSION[cod_imobiliaria];
$nome_pasta = $_SESSION[nome_pasta];
?>

<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <p align="center">
         <iframe name="xml" marginwidth="0" marginheight="0" src=" https://www.muraski.com:8080/integracao/ler_xml_vision.php?token=JGF5ErSwbMH9bZXMypMhKtnYckcUVgwLY7ZGpuvvJQX8XsYc7Ef5b9uVqb79mPze" topmargin="0" leftmargin="0" scrolling="yes" width="900" frameborder="0" height="400"></iframe>
      </p>
    </td>
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
</body>
</html>