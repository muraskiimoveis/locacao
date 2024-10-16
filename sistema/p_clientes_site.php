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
verificaArea("USER_GERAL");

function data_mostra ($j_nascimento) {
   $tmp_dt = explode("-",$j_nascimento);
   $dt_nasc = $tmp_dt[2]."/".$tmp_dt[1]."/".$tmp_dt[0];
	return $dt_nasc;
}

if ($_SERVER['REMOTE_ADDR'] == "201.22.15.53") {
   $imob = "83";
} elseif ($_SERVER['REMOTE_ADDR'] == "192.168.0.5") {
   $imob = "3";
} else {
   $imob = $_SESSION['cod_imobiliaria'];
}

?>
<html>
<head>
</head>
<?php
//	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and ($u_tipo == "admin")){
?>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td align="center" background="images/fundo_topo.jpg"><?
   include("topo.php");
  ?></td>
 </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td align="center"><?
   include("menu.php");
 ?></td></tr>
</table>
<?
/*======================================================*/
/* PARTE INICIAL DO ARQUIVO NÃO ALTERAR DAQUI PARA CIMA */
/* ***** EXCETO O PADRÃO DE ACESSO...  "GERAL..." ***** */
/*======================================================*/

# Se for uma alteração.
if (($B1 <> "") && ($B1 <> "Pesquisar")) {

   $msg = "";
   $cl_cod = $_POST['cl_cod'];
   $cl_imobiliaria = $_POST['cl_imobiliaria'];
   $cl_nome = $_POST['cl_nome'];
   $cl_email = $_POST['cl_email'];
   $cl_senha = $_POST['cl_senha'];
   $cl_senha2 = $_POST['cl_senha2'];
   $cl_informativo = $_POST['cl_informativo'];
   $enviar = $_POST['enviar'];
   $B1 = $_POST['B1'];

   if ($enviar == 1) {
	   if ($cl_senha <> "") {
         if ($cl_senha <> $cl_senha2) { $msg .= "A confirmação de senha não coincide"; $enviar = 0; }
	   }
      if ($cl_cod == "") { if ($msg <> "") { $msg .= "<BR>\n"; } $msg .= "Faltou selecionar o código"; $enviar = 0; }
      if ($cl_imobiliaria == "") { if ($msg <> "") { $msg .= "<BR>\n"; } $msg .= "Faltou selecionar o código da imobiliária"; $enviar = 0; }
      if ($cl_nome == "") { if ($msg <> "") { $msg .= "<BR>\n"; } $msg .= "Faltou preencher o nome"; $enviar = 0; }
      if ($cl_email == "") { if ($msg <> "") { $msg .= "<BR>\n"; } $msg .= "Faltou preencher o e-mail"; $enviar = 0; }
   }

   if ($enviar == 1) {
	   if ($B1 == "Alterar Cadastro") {
         if ($cl_senha == "") {
            $sql = "UPDATE m_clientes SET cl_nome = '$cl_nome', cl_email = '$cl_email', cl_informativo = '$cl_informativo' WHERE cl_cod = '$cl_cod'";
         } else {
            $senha = md5($cl_senha);
            $sql = "UPDATE m_clientes SET cl_nome = '$cl_nome', cl_senha='$senha', cl_email = '$cl_email', cl_informativo = '$cl_informativo' WHERE cl_cod = '$cl_cod'";
         }
         if (mysql_query($sql)) {
            $msg = "Cliente Atualizado com sucesso";
         } else {
			   $msg = "Erro ao atualizar cliente";
         }

	   }
	   if ($B1 == "Excluir Cadastro") {
         $sql = "DELETE FROM m_clientes WHERE cl_cod = '$cl_cod'";
         if (mysql_query($sql)) {
            $msg = "Cliente excluído com sucesso";
         } else {
			   $msg = "Erro ao excluir cliente";
         }
	   }
   }

}

# Opção default, mostra a pesquisa.
if ($lista == "") {
   if ($screen == "") {
	   $screen = 1;
   }
   $from = ($screen - 1) * 30;

	if($chave == ""){
      $query1 = "SELECT cl_cod, cl_imobiliaria, cl_nome, cl_email, cl_informativo
         FROM m_clientes WHERE cl_nome <> '' and cl_imobiliaria =
         '".$imob."' ORDER BY cl_nome LIMIT $from, 30";
	} else {
      $query1 = "SELECT cl_cod, cl_imobiliaria, cl_nome, cl_email, cl_informativo
         FROM m_clientes WHERE cl_email <> '' AND $campo LIKE '%$chave%' AND
         cl_imobiliaria = '".$imob."' ORDER BY cl_nome
         LIMIT $from, 30";
	}
	$result1 = mysql_query($query1) or die ("Erro 54 - ".mysql_error());
?>

<table border="0" cellspacing="1" width="75%" align="center">
 <tr height="50">
  <td colspan="5" align="center" class="style1"><b>Relação de clientes</b><br /><span class="style4">Para editar ou apagar, clique no nome correspondente.</span></td>
 </tr>
 <tr class="fundoTabela">
  <td colspan="5" align="center" class="style1"><form method="post" action="<?=$PHP_SELF?>" name="form1">
   <table width="100%" border="0">
    <tr class="fundoTabela">
     <td colspan="3" style="padding-top: 10px;" >
     <span class="style1">Palavra chave:</span>
     <input size="30" name="chave" class="campo" type="text"> 
     <select name="campo" class="campo">
      <option value="cl_nome" selected="selected">Nome</option>
      <option value="cl_email">E-Mail</option>
     </select>
     <input value="Pesquisar" name="B1" class="campo3" type="submit">
     </td>
    </tr>
   </table>
  </form></td>
 </tr>


<? if ($msg <> "") { ?>
 <tr><td colspan="5" height="10"></td></tr><tr><td colspan="5" align="center" class="style7"><strong><?=$msg?></strong></td></tr>
<? } ?>
 <tr>
  <td colspan="5" height="10"></td>
 </tr>
 <tr class="fundoTabelaTitulo">
  <td align="center" class="style1" width="35%"><b>Nome</b></td>
  <td align="center" class="style1" width="35%"><b>E-mail</b></td>
  <td align="center" class="style1" width="30%"><b>Listas</b></td>
 </tr>
<?php
 $i = 0;
 while($not = mysql_fetch_assoc($result1)) {
   $from = $from + 1;
   if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
   $i++;
   $cl_cod = $not[cl_cod];
   $lsql = "SELECT * FROM imoveis_temp WHERE cod_imobiliaria = '".$imob."' AND interessado = '$cl_cod' GROUP BY sid";
   $lrs = mysql_query($lsql) or die ("Erro 155 - ".mysql_error());
   $lcont = mysql_num_rows($lrs);
?>
 <tr class="<?php echo $fundo; ?>">
  <td align="left"><a href="<?=$PHP_SELF?>?lista=1&cl_cod=<?=$not['cl_cod']?>" class=style1><?=$not['cl_nome']?></a>    </td>
  <td align="left"><a href="<?=$PHP_SELF?>?lista=1&cl_cod=<?=$not['cl_cod']?>" class=style1><?=$not['cl_email']?></a></td>
  <td align="center">
<?
   if ($lcont > 0) {
?>
    <a href="p_listas.php?cli=<?=$not['cl_cod']?>" class=style1>Visualizar (<?=$lcont?>)</a>
<?
   } else {
    print "---";
   }
?>
  </td>
 </tr>
<?php
 }



/*===========================================================================
                               VERSAO ATUAL
===========================================================================*/ ?>
<?


 if ($chave == "") {
  $query3 = "SELECT count(cl_cod) AS contador FROM m_clientes WHERE cl_imobiliaria = '$imob'";
 } else {
  $query3 = "SELECT count(cl_cod) AS contador FROM m_clientes WHERE $campo LIKE '%$chave%' AND cl_imobiliaria = $imob";
 }
 $result3 = mysql_query($query3) or die ("Erro 102 - ".mysql_error());
 while ($not3 = mysql_fetch_array($result3)) {
  $contador = $not3[contador];
  $pages = ceil($not3[contador] / 30);
 }

    $paginas = $pages;
    $pagina = $screen;
    $url = $PHP_SELF."?campo=".$campo."&chave=".$chave."&pesq=".$pesq."&screen=";
?>
      <tr class="fundoTabelaTitulo">
		 <td colspan="4" class="style1" align="center"><b>Foram encontrados <?=$contador?> cadastros</b></td>
		</tr>
      <tr>
		 <td colspan="4" class="style1" align="center">
		  </table><table width="100%" cellpadding="0" cellspacing="0">
         <tr>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
          <td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
          <td class="style1" align="center">
<?
            $i = 0;
   			$completa = "";
   			if ($paginas > 9) {
               if ($pagina < 5) {
                  $inicio = 1;
                  $final = 9;
               } elseif ($pagina > $paginas - 5) {
                  $inicio = $paginas - 9;
                  $final = $paginas;
               } else {
                  $inicio = $pagina - 4;
                  $final = $pagina + 4;
               }
            } else {
               $inicio = 1;
               $final = $paginas;
            }
            for ($j = $inicio; $j < ($final+1); $j++) {

      		   if(($paginas > 9) && (strlen($j)==1)){
                  $j = "0".$j;
               }
               $url2 = $url . $j;

               if ($j == $pagina) {
                  print "<a href=\"$url2\" class='style1'>| <b>$j</b> |</a>";
               } else {
                  print "<a href=\"$url2\" class='style1'>| $j |</a>";
               }
            }
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas && $paginas > 1) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="<?=$PHP_SELF?>?campo=<?=$campo?>&chave=<?=$chave?>&pesq=<?=$pesq?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas && $paginas > 1) { ?>| Última |<?}?></a></td>
               				</tr>
<? /* ==========================================================================
 FIM VERSÃO ATUAL
========================================================================== */ ?>

</table>

<?
#Segunda opção, mostra a tela de cadastro.
} else {
 if ($cl_cod > 0) {
  if ($enviar <> 1) {
   $sql = "SELECT * FROM m_clientes WHERE cl_cod = '".$cl_cod."'";
   $rs = mysql_query($sql) or die ("Erro 162 - ". mysql_error());
   while ($not = mysql_fetch_assoc($rs)) {
    $cl_nome = $not[cl_nome];
    $cl_email = $not[cl_email];
    $cl_imobiliaria = $not[cl_imobiliaria];
    $cl_informativo = $not[cl_informativo];
    $cadastro = $not[cl_cadastro];
    $cl_cadastro = substr($cadastro,8,2)."/".substr($cadastro,5,2)."/".substr($cadastro,0,4);
   }
  }

?>
<script>
function valida() {
   d = document.form1;
   if (d.cs_nome.value == "") {
      alert("Por favor, digite o Nome");
      d.cs_nome.focus();
      return (false);
   }
   if (d.cs_cpf.value == "") {
      alert("Por favor, digite o CPF");
      d.cs_cpf.focus();
      return (false);
   }
   if (d.day.value == "") {
      alert("Por favor, digite o dia de nascimento");
      d.day.focus();
      return (false);
   }
   if (d.month.value == "") {
      alert("Por favor, digite o mês de nascimento");
      form1.month.focus();
      return (false);
   }

   if (d.year.value == "") {
      alert("Por favor, digite o ano de nascimento");
      d.year.focus();
      return (false);
   }

   if (d.cs_tel.value == "") {
      alert("Por favor, digite o Fone/Fax");
      d.cs_tel.focus();
      return (false);
   }

   if (d.cs_email.value == "") {
      alert("Por favor, digite o e-mail");
      d.cs_email.focus();
      return (false);
   }

   if (d.cs_email.value != '') {
      var emailok = 0;
      var checkStr = d.cs_email.value;
      var priaroba = checkStr.indexOf('@');
      var ultponto = checkStr.lastIndexOf('.');

      if (checkStr.indexOf('@') > 0 ) {
         if (checkStr.lastIndexOf('@') == checkStr.indexOf('@')) {
            if (checkStr.lastIndexOf('.') > 0 ) {
               if ( checkStr.lastIndexOf('.')  !=  checkStr.length - 1) {
	 				   if ( ultponto > priaroba ) {
                     var emailok = 1;
 	 				   }
               }
            }
         }
      }

      if (emailok != 1) {
    	   alert('E-mail Inválido.');
		   d.cs_email.focus();
         return (false);
      }
   }

   if (d.cep.value == "") {
      alert("Por favor, digite o CEP");
      d.cep.focus();
      return (false);
   }

   if (d.rua.value == "") {
      alert("Por favor, digite o nome da Rua");
      d.rua.focus();
      return (false);
   }

   if (d.num.value == "") {
      alert("Por favor, digite o Número");
      d.num.focus();
      return (false);
   }

   if (d.cs_bairro.value == "") {
      alert("Por favor, digite o Bairro");
      d.cs_bairro.focus();
      return (false);
   }

   if (d.cs_cidade.value == "") {
      alert("Por favor, digite a Cidade");
      d.cs_cidade.focus();
      return (false);
   }

   if (d.cs_estado.value == "") {
      alert("Por favor, selecione o Estado");
      d.cs_estado.focus();
      return (false);
   }

   if (d.cs_pais.value == "") {
      alert("Por favor, digite o País");
      d.cs_pais.focus();
      return (false);
   }
//	d.submit();
   return true;
}

function TudoIgual(field) {
  var str = field.value, primeiro='';
  for(i = 0; i < str.length; i++)
    if (str.charAt(i)>='0' && str.charAt(i)<='9')
      if (primeiro=='') primeiro = str.charAt(i);
      else if (str.charAt(i) != primeiro) return 0;
  return 1;
}
function Trim(s)
{
 if (s.length == 0)
  return s;

 if (s.length == 1 && s.value == ' ')
  return '';

 var i=0;

 while ( i < s.length && s.substring(i,i+1) == ' ') i++;

 var f = s.length - 1;

 while ( f >= 0 && s.substr(f,f+1) == ' ') f--;

 s = s.substr(i,f+1);

 return s;
}

function Guardar_CPF_CGC(field) {

  document.form1.cs_cpf.value = Trim(field.value);

}

function Verifica_CPF_CGC(field) {

  var cpf='', cgc='', digito='', digitoc='', temp='', k=0; i=0, j=0, soma=0, mt=0, dg='';

  field.value = Trim(field.value);

  // Limpa os espacos da variavel
  if (field.value == ' ' || field.value == '  ' || field.value == ''){
	return false;
  }
  else {
       cpf = field.value;
  }
  if (cpf.length == 19) {
     cpf = cpf.substring(1, cpf.length)
  }

  for (i = 0;i < cpf.length; i++) {
	k = i + 1;
	if (isNaN(cpf.substring(i,k))== false){
          temp = temp + cpf.substring(i,k);
	}
  }

 if (((cpf.length > 13) && (cpf.length < 19)) && (isNaN(cpf.substring(3,4))==false)){
  cgc = temp.substring(0,12);
  digito = temp.substring(12,14);
  mult = '543298765432';
  for (j = 1; j <= 2; j++) {
    soma = 0;
    for (i = 0; i <= 11; i++) {
      k = i + 1;
      soma += parseInt((cgc.substring(i,k)) * (mult.substring(i,k)));
    }
    if (j == 2){
	soma = soma + (2 * digitoc);
    }
    digitoc = ((soma * 10) % 11);
    if (digitoc == 10){
	digitoc = 0;
    }
    dg +=digitoc;
    mult = '654329876543';
  }
  if (dg != digito || TudoIgual(field)) {
    alert('O CNPJ informado não é válido!');
    field.value = '';
    field.focus();
    return false;
  }
  else {
    field.value=temp.substring(0,2)+'.'+temp.substring(2,5)+'.'+temp.substring(5,8)+'/'+temp.substring(8,12)+'-'+temp.substring(12,14);
    return true;
  }
 }
 else {
  if (cpf.length < 11) {
	alert( 'Informação inválida.');
	field.value = '';
	field.focus();
	return false;
  }
  if (cpf.length >= 11) {

      cpf = temp.substring(0,9);
	digito = temp.substring(9,11);
	for (j = 1; j <= 2; j++) {
	  soma = 0;
	  mt = 2;
	  for (i = 8 + j; i >= 1; i--) {
	    soma += parseInt(cpf.charAt(i-1),10) * mt;
	    mt++;
	  }
	  dg = 11 - (soma % 11);
	  if (dg > 9) {dg = 0};
	  cpf += dg;
	}

	if (digito != cpf.substring(9,11) || TudoIgual(field)) {
	  alert('O CPF informado não é válido!');
	  field.value = '';
	  field.focus();
	  return false;
	  }
	else {
	  field.value=cpf.substring(0,3)+'.'+cpf.substring(3,6)+'.'+cpf.substring(6,9)+'-'+cpf.substring(9,11);
	  return true;
	}
    }
  } // fim if (cpf.length < 15)

}
</script>

<table width="75%" align="center" cellspacing="1" cellpadding="0">
<? if ($msg <> "") { ?>
 <tr>
  <td class="style2" align="center"><?=$msg?></td>
 </tr>
 <tr>
  <td class="style1" align="center" height="10"></td>
 </tr>
<? } ?>
 <tr height="50">
  <td class="style1" align="center"><b>Alteração de dados do Cliente</b></td>
 </tr>
 <tr>
  <td>
   <form method="post" action="<?=$PHP_SELF?>" name="form1" id="form1" target="_top" onSubmit="return valida();" >
    <table width="100%" border="0">
     <tr class="fundoTabela"><td colspan="2" height="20px" class="style1"><b>Dados Pessoais</b></td></tr>
     <tr class="fundoTabela">
      <td width="20%" class="style1">*Nome:</td>
       <td width="80%">
        <input type="hidden" name="cl_cod" value="<?=$cl_cod?>" />
        <input type="hidden" name="cl_imobiliaria" value="<?=$cl_imobiliaria?>" />
        <input size="45" name="cl_nome" class="campo" value="<?=$cl_nome?>" type="text"></td>
     </tr>
     <tr class="fundoTabela">
      <td width="20%" class="style1">*E-mail:</td>
      <td width="80%" class="style1"><input size="20" name="cl_email" class="campo" value="<?=$cl_email?>" maxlenght="20" type="text"></td></tr>
     <tr class="fundoTabela">
      <td width="20%" class="style1">Nova Senha:</td>
      <td width="80%"><input type="password" maxlength="6" class="campo" name="cl_senha" size="10" /></td></tr>
     <tr class="fundoTabela">
      <td width="20%" class="style1">Confirmar Nova Senha:</td>
      <td width="80%"><input type="password" maxlength="6" class="campo" name="cl_senha2" size="10" /></td></tr>
     <tr class="fundoTabela">
      <td width="20%" class="style1">Data de Cadastro:</td>
      <td width="80%"><?=$cl_cadastro?></td></tr>
     <tr class="fundoTabela">
      <td width="20%" class="style1">*Informativos:</td>
      <td width="80%"><select name="cl_informativo" class="campo">
       <option value="S" <? if ($cl_informativo == "S") { print "selected='selected'"; } ?> >Sim</option>
       <option value="N" <? if ($cl_informativo <> "S") { print "selected='selected'"; } ?> >Não</option>
      </select></td></tr>
     <tr class="fundoTabela">
      <td colspan="2" width="100%" height=20 class="style7"><i>* Campos de preenchimento obrigatório</i></td></tr>
     <tr>
      <td colspan="2">
       <input name="enviar" value="1" type="hidden">
       <input value="Alterar Cadastro" id="B1" name="B1" class="campo3" type="submit" >
       <input value="Excluir Cadastro" id="B1" name="B1" class="campo3" type="submit" ></td></tr>
    </table>
   </form>
  </td>
 </tr>
</table>
<? } else { ?>
<table cellpadding="0" cellspacing="0" width="100%">
 <tr height="50">
 	<td align="center" class="style1"><b>Relação de listas</b></td>
 </tr> 
 <tr>
  <td align="center" class="style1">
   <p>Não foram encontrados registros.</p>
   <p><a href="javascript:history.back();" class="style1"><b>Clique aqui para retornar à pesquisa</b></a></p>
  </td>
 </tr>
</table>	
<?
   }
}
/*======================================================
 PARTE FINAL DO ARQUIVO, NÃO ALTERAR DAQUI PARA BAIXO
====================================================/**/
?>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr><td bgcolor="#e0e0e0" height="1"></td></tr>
</table>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr><td>&nbsp;</td></tr>
 <tr><td align="center"><? include("voltar.php"); ?></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td align="center"><? include("endereco.php"); ?></td></tr>
 <tr><td height="20"></td></tr>
 <tr><td align="center" class="style1"><? include("bruc.php"); ?></td></tr>
</table>
<? } ?>
</body>
</html>
