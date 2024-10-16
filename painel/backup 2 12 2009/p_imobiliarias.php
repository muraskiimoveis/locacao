<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("regra.php");

?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<?php
include("style.php");
?>
<script language="JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
function VerificaCampo() {

   var msg = '';

	if (document.formulario.im_nome.value.length==0) {
      msg += "Por favor, selecione o campo Nome.\n";
   }

   if (document.formulario.im_n_conselho.value=="") {
      msg += "Por favor, preencha o campo N° do Creci.\n";
   }

   if (document.formulario.im_cnpj.value=="") {
      msg += "Por favor, preencha o campo CPF ou CPNJ.\n";
   }

   if (document.formulario.im_banco.value=="") {
      msg += "Por favor, preencha o campo Banco.\n";
   }

   if (document.formulario.im_agencia.value=="") {
      msg += "Por favor, preencha o campo Agência.\n";
   }

   if (document.formulario.im_conta.value=="") {
      msg += "Por favor, preencha o campo Conta.\n";
   }

   if (document.formulario.im_contato.value=="") {
      msg += "Por favor, preencha o campo Contato.\n";
   }

   if (document.formulario.im_resp.value=="") {
      msg += "Por favor, preencha o campo Nome do Responsável.\n";
   }

   if (document.formulario.im_creci_resp.value=="") {
      msg += "Por favor, preencha o campo N° do Creci Responsável.\n";
   }

   if(document.formulario.im_nacionalidade.value=="") {
      msg += "Por favor, preencha o campo Nacionalidade.\n";
   }

   if (document.formulario.im_est_civil.selectedIndex == 0) {
      msg += "Por favor, selecione o campo Estado Civil.\n";
   }

   if (document.formulario.im_email.value.length==0) {
      msg += "Por favor, preencha o campo E-mail.\n";
   } else if(!isMail(document.formulario.im_email.value)) {
      msg += "O E-mail digitado é inválido!\n";
   }

   if (document.formulario.im_tel.value.length==0) {
      msg += "Por favor, preencha o campo Telefone.\n";
   }

   if (document.formulario.im_estado.selectedIndex == 0) {
      msg += "Por favor, selecione o campo Estado.\n";
   }

   if (document.formulario.im_cidade.selectedIndex == 0) {
      msg += "Por favor, selecione o campo Cidade.\n";
   }

   if (document.formulario.im_end.value.length==0) {
      msg += "Por favor, preencha o campo Endereço.\n";
   }

   if (document.formulario.contrato_venda.selectedIndex == 0) {
      msg += "Por favor, selecione o campo Contrato para Venda.\n";
   }

   if (document.formulario.contrato_locacao.selectedIndex == 0) {
      msg += "Por favor, selecione o campo Contrato para Locação.\n";
   }

   if (msg != '') {
      alert(msg);
   } else {
      document.formulario.atualiza.value='1';
      document.formulario.submit();
   }

}

function TravaCampo(){

  if(document.getElementById('end_igual').checked)
  {
    document.formulario.im_end_mapa.disabled = true;
    document.formulario.im_end_mapa.style.background = '#D6D6D6';
  }
  else
  {
    document.formulario.im_end_mapa.disabled = false;
    document.formulario.im_end_mapa.style.background = '#FFFFFF';
  }
}

function TravaCampo2(){

  if(document.getElementById('end_igual2').checked)
  {
    document.formulario.im_end_mapa2.disabled = true;
    document.formulario.im_end_mapa2.style.background = '#D6D6D6';
  }
  else
  {
    document.formulario.im_end_mapa2.disabled = false;
    document.formulario.im_end_mapa2.style.background = '#FFFFFF';
  }
}

function TudoIgual(field) {
   var str = field.value, primeiro='';
   for(i = 0; i < str.length; i++)
      if (str.charAt(i)>='0' && str.charAt(i)<='9')
         if (primeiro=='') primeiro = str.charAt(i);
         else if (str.charAt(i) != primeiro) return 0;
   return 1;
}

function Trim(s) {
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
  document.form1.c_cpf.value = Trim(field.value);
}

function Verifica_CPF_CGC(field) {
   var cpf='', cgc='', digito='', digitoc='', temp='', k=0; i=0, j=0, soma=0, mt=0, dg='';
   field.value = Trim(field.value);

  // Compara o CNPJ_CPF antigo com o CNPJ_CPF novo

//  if(Trim(document.frmPedido.FormFederalTaxID.value) != field.value) {
//
//		document.frmPedido.FormNICHandle.value = "true";
//		document.frmPedido.FormNICPassword.value = "";
//		document.frmPedido.PasswordRequired.value = "0";
//
//		document.frmPedido.NICHandleRequested.value = "0";
//		document.frmPedido.FormNICHandle.disabled = false;
//		document.frmPedido.FormNICPassword.disabled = false;
//		document.frmPedido.FormRegistrant.checked = true;
//
// }

//  if (field.value.substring(0,2) == '00') {
//        field.value = field.value.substring(1, field.value.length)
//  }

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
    alert('O CPF/CNPJ informado não é válido!');
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
	  alert('O CPF/CNPJ informado não é válido!');
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
//  End -->

</script>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<table width=100% height=100%>
<tr><td bgcolor="<?php print("$barra_lat"); ?>" valign=top width=150>
<?php
include("menu_painel.php");
?></td>
<td width=620 valign=top>
<br>
<?php
include("conect.php");

function trocaini($wStr,$w1,$w2) {
   $wde = 0;
   $para=0;
   while ($para<1) {
      $wpos = strpos($wStr, $w1, $wde);
      if ($wpos > 0) {
         $wStr = str_replace($w1, $w2, $wStr);
         $wde = $wpos+1;
      } else {
         $para=2;
      }
   }
   $trocou = $wStr;
   return $trocou;
}

function altaebaixa($umtexto) {
   $troca = strtolower($umtexto);
   $troca = ucwords($troca);
   $troca = trocaini($troca, " E ", " e ");
   $troca = trocaini($troca, " De ", " de ");
   $troca = trocaini($troca, " Da ", " da ");
   $troca = trocaini($troca, " Do ", " do ");
   $troca = trocaini($troca, " Das ", " das ");
   $troca = trocaini($troca, " Dos ", " dos ");
   $troca = trocaini($troca, "Ã", "ã");
   $troca = trocaini($troca, "Á", "á");
   $troca = trocaini($troca, "À", "à");
   $troca = trocaini($troca, "Â", "â");
   $troca = trocaini($troca, "Ç", "ç");
   $troca = trocaini($troca, "Ó", "ó");
   $troca = trocaini($troca, "Õ", "õ");
   $troca = trocaini($troca, "É", "é");
   $troca = trocaini($troca, "Ê", "ê");
   $troca = trocaini($troca, "Í", "í");

   $altabaixa = $troca;
   return $altabaixa;
}
//echo $B1 . $im_email . $im_senha;

//Cadastra a fornecedor
if ($B1 == "Cadastrar") {

   $pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$im_email."' AND u_senha='".md5($im_senha)."'";
   $pw_result = mysql_query($pw_query) or die("Não foi possivel inserir suas informações");
   $pw_rows = mysql_num_rows($pw_result);
   if ($pw_rows == 0) {

      $query0 = "select im_nome from rebri_imobiliarias where im_nome='$im_nome'";
      $result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações. $query0");
      $numrows = mysql_num_rows($result0);

      if($numrows == 0){

         //$im_nome = altaebaixa($im_nome);
         $im_senha = $im_senha;

         $nome_imob = $im_nome;

         // tira os acentos e espaço
         $im_nome = ereg_replace("[ÁÀÂÃ]","A",$im_nome);
         $im_nome = ereg_replace("[áàâãª]","a",$im_nome);
         $im_nome = ereg_replace("[ÉÈÊ]","E",$im_nome);
         $im_nome = ereg_replace("[éèê]","e",$im_nome);
         $im_nome = ereg_replace("[ÓÒÔÕ]","O",$im_nome);
         $im_nome = ereg_replace("[óòôõº]","o",$im_nome);
         $im_nome = ereg_replace("[ÚÙÛ]","U",$im_nome);
         $im_nome = ereg_replace("[úùû]","u",$im_nome);
         $im_nome = ereg_replace("[íìî]","i",$im_nome);
         $im_nome = ereg_replace("[ÍÌÎ]","I",$im_nome);
         $im_nome = str_replace("Ç","C",$im_nome);
         $im_nome = str_replace("ç","c",$im_nome);
         $im_nome = str_replace(" ","",$im_nome);

         // pega o nome da imobiliária, deixa em minúsculas e pega os 6 primeiros caracteres se caso for menor que 6 complementa com 0
         if(strlen($im_nome) < 6){
            if (strlen($im_nome) == 5) {
               $nome_pasta = strtolower($im_nome."0");
            } elseif(strlen($im_nome) == 4) {
               $nome_pasta = strtolower($im_nome."00");
            } elseif(strlen($im_nome) == 3) {
               $nome_pasta = strtolower($im_nome."000");
            } elseif(strlen($im_nome) == 2) {
               $nome_pasta = strtolower($im_nome."0000");
            } elseif(strlen($im_nome) == 1) {
               $nome_pasta = strtolower($im_nome."00000");
            }
         }elseif(strlen($im_nome) >= 6){
            $nome_pasta = strtolower(substr($im_nome,0,6));
         }

         // verifica se a pasta já existe
         if (file_exists("../imobiliarias/" . $nome_pasta)) {
            $cont = 1; // contador de pastas

            // verifica qual a ultima pasta criada e incrementa 1
            while (file_exists("../imobiliarias/" . $nome_pasta . $cont)) {
               $cont++;
            }

            $nome_pasta .= $cont;
         }

         // cria nova pasta
         $dirp = "../imobiliarias/".$nome_pasta;
         mkdir($dirp);
         chmod($dirp, 0777);

         $dirl = "../imobiliarias/".$nome_pasta."/locacao/";
         mkdir($dirl);
         chmod($dirl, 0777);

         $dirlp = "../imobiliarias/".$nome_pasta."/locacao_peq/";
         mkdir($dirlp);
         chmod($dirlp, 0777);

         $dirv = "../imobiliarias/".$nome_pasta."/venda/";
         mkdir($dirv);
         chmod($dirv, 0777);

         $dirvp = "../imobiliarias/".$nome_pasta."/venda_peq/";
         mkdir($dirvp);
         chmod($dirvp, 0777);

         $dirvv = "../imobiliarias/".$nome_pasta."/venda_vistoria/";
         mkdir($dirvv);
         chmod($dirvv, 0777);

         $dirvpv = "../imobiliarias/".$nome_pasta."/venda_vistoria_peq/";
         mkdir($dirvpv);
         chmod($dirvpv, 0777);

         $dirlv = "../imobiliarias/".$nome_pasta."/locacao_vistoria/";
         mkdir($dirlv);
         chmod($dirlv, 0777);

         $dirlpv = "../imobiliarias/".$nome_pasta."/locacao_vistoria_peq/";
         mkdir($dirlpv);
         chmod($dirlpv, 0777);
         
         $dirba = "../imobiliarias/".$nome_pasta."/banner_site/";
         mkdir($dirba);
         chmod($dirba, 0777);


	if($end_igual=='1'){
		$im_end_mapa = '';
	}

	if($end_igual2=='1'){
		$im_end_mapa2 = '';

	}

                if(substr($_POST['im_site'] ,0, 7) <> 'http://'){
  	    	        $im_site = 'http://'.$_POST['im_site'];
  	            }else{
		   	        $im_site = $_POST['im_site'];
	            }

         //insere dados da imobiliária
         $query = "insert into rebri_imobiliarias (im_nome, im_contato, im_resp
            , im_creci_resp, im_nacionalidade, im_est_civil, im_n_conselho
            , im_cnpj, im_banco, im_agencia, im_conta, im_tel, im_fax, im_cel
            , im_cidade, im_estado, im_end, im_end2, iend_igual, im_end_mapa
            , end_igual2, im_end_mapa2, im_bairro2, im_cep2, im_tel2, im_email2
            , im_bairro, im_cep, im_email, im_senha, im_site, im_site2, im_site_padrao
            , im_disponibilizar, im_desativar, im_img, im_desc, im_desde
            , nome_pasta, contrato_venda, contrato_locacao) values('$nome_imob'
            , '$im_contato', '$im_resp', '$im_creci_resp', '$im_nacionalidade'
            , '$im_est_civil', '$im_n_conselho', '$im_cnpj', '$im_banco'
            , '$im_agencia', '$im_conta', '$im_tel', '$im_fax', '$im_cel'
            , '$im_cidade', '$im_estado', '$im_end', '$im_end2', '$end_igual'
            , '$im_end_mapa', '$end_igual2', '$im_end_mapa2', '$im_bairro2'
            , '$im_cep2', '$im_tel2', '$im_email2', '$im_bairro', '$im_cep'
            , '$im_email', '$im_senha', '$im_site', '$im_site2', '$_POST[im_site_padrao]'
            , '$im_disponibilizar', '$im_desativar', '$im_img', '$im_desc'
            , current_date, '$nome_pasta', '$contrato_venda', '$contrato_locacao')";
         $result = mysql_query($query) or die("Não foi possível inserir suas informações.($query)");
         $cod_imob = mysql_insert_id();
         $senha = md5($im_senha);

         //insere documentos
         $query22 = "select * from docs_padrao";
         $result22 = mysql_query($query22) or die("Não foi possível pesquisar suas informações.($query22)");
         $numrows = mysql_num_rows($result22);
         while($linha = mysql_fetch_array($result22)) {
            if ($linha['dp_cod']=='5') {
               if($contrato_venda=='5'){
                  $d_tipo_contrato = 'V';
               }
            } elseif($linha['dp_cod']=='7') {
               if($contrato_venda=='7'){
                  $d_tipo_contrato = 'V';
               }
            } elseif($linha['dp_cod']=='9') {
               if($contrato_locacao=='9'){
                  $d_tipo_contrato = 'L';
               }
            } else {
               $d_tipo_contrato = '';
            }

            $query99 = "INSERT INTO doc (cod_imobiliaria, d_txt, d_nome, d_data, d_tipo_contrato, d_cod) VALUES ('".$cod_imob."','".$linha['dp_txt']."','".$linha['dp_nome']."', current_date, '".$d_tipo_contrato."', '".$linha['dp_cod']."')";
            mysql_query($query99) or die("Não foi possível pesquisar suas informações.($query99)");

         }
		
		 $u_cookie = md5($im_email.$senha);
         //insere na tabelas de usuarios
         $query01 = "INSERT INTO usuarios (cod_imobiliaria,u_nome,u_email,u_senha,u_tipo, u_status, u_cookie) VALUES('".$cod_imob."','".$nome_imob."','".$im_email."','".$senha."','admin','Ativo','$u_cookie')";
         mysql_query($query01) or die("Não foi possível pesquisar suas informações.");
         $tmp_cod = mysql_insert_id();

         //insere na tabela com todas as permissoes nas areas cadastradas
         $query02 = "select * from area";
         $result02 = mysql_query($query02) or die("Não foi possível pesquisar suas informações.");
         $numrows = mysql_num_rows($result02);
         while($not0 = mysql_fetch_array($result02)) {
            $area_id = $not0['area_id'];
            $query10 = "INSERT INTO rel_area_usuario (area_id,u_cod, cod_imobiliaria)
               VALUES ('".$area_id."','".$tmp_cod."','".$cod_imob."')";
            mysql_query($query10) or die("Não foi possível pesquisar suas informações.");
         }

function geraCodigoComputador() {
   $_letras	=	"ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $_numeros	=	"0123456789";
   do {
      $_codigo = substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_numeros, rand(0, 9), 1) . substr($_numeros, rand(0, 9), 1)
         . substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1);
      $SQL = "SELECT * FROM computador WHERE computador_codigo = '".$_codigo."'";
      $statement = mysql_query($SQL);
   } while (mysql_num_rows($statement) == 1);
   return $_codigo;
}

function geraCookie() {
   $_letras	=	"ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $_numeros	=	"0123456789";
   do {
      $_codigo = substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_numeros, rand(0, 9), 1) . substr($_numeros, rand(0, 9), 1)
         . substr($_numeros, rand(0, 9), 1) . substr($_numeros, rand(0, 9), 1)
         . substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_numeros, rand(0, 9), 1) . substr($_numeros, rand(0, 9), 1)
         . substr($_numeros, rand(0, 9), 1) . substr($_numeros, rand(0, 9), 1)
         . substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_numeros, rand(0, 9), 1) . substr($_numeros, rand(0, 9), 1)
         . substr($_numeros, rand(0, 9), 1) . substr($_numeros, rand(0, 9), 1)
         . substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_letras, rand(0, 25), 1) . substr($_letras, rand(0, 25), 1)
         . substr($_numeros, rand(0, 9), 1) . substr($_numeros, rand(0, 9), 1)
         . substr($_numeros, rand(0, 9), 1) . substr($_numeros, rand(0, 9), 1);
      $SQL = "SELECT * FROM computador WHERE computador_cookie = '".$_codigo."'";
      $statement = mysql_query($SQL);
   } while (mysql_num_rows($statement) == 1);
   return $_codigo;
}

$inserir = "INSERT INTO computador (cod_imobiliaria, computador_nome, computador_codigo,
   computador_cookie, computador_ativo) VALUES ('" . $cod_imob . "','" . $nome_imob
   . "', '" . geraCodigoComputador() . "', '" . geraCookie() . "', '1')";
mysql_query($inserir) or die("Não foi possível pesquisar suas informações.");

		//controle
   		mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$cod_imob."','".$u_cod."','Cadastrar Imobiliária',current_date,current_time)") or die ("Erro 604 - ".mysql_error());

?>
         <p align="center"><b>Você cadastrou a imobiliária <?php print("$im_nome"); ?>.
<?php

      } else {

?>
      <p align="center"><b>A imobiliária <?php print("$im_nome"); ?> já está cadastrada.</b>
<?php
      }

   }else{
      echo ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");document.location.href="p_imobiliarias.php";</script>');
   }
}
//Apaga Imobiliária
if ($B1 == "Apagar") {
   $lista = 1;
   if (!isset($envio)) {
		//O formulário abaixo repete também na linha 199. Sempre que alterar um precisa alterar o outro pra deixar igual
?>
              <table border="0" width="80%" align="center">
              <form name="form1" action="p_imobiliarias.php" method="post">
               <tr>
               <td align="center" height = "50" class=style2>
               Para apagar a imobiliária <b><?php print("$im_nome"); ?></b> e todos os seus imóveis e usuários digite o código abaixo:
               </td></tr>
               <!-- gera imagem com número aleatório -->
               <tr><td align="center">
               <img src="imagem.php">
               </td></tr>
               <tr>
               <td align="center" height = "50" class=style2>
               <input type=text name="codigo" size = "12" class=campo>
               </td></tr>
               <tr>
               <td align="center">
               <input type="submit" name="Submit" value="Enviar" class=campo>
               <input type="reset" name="Submit" value="Limpar" class=campo>
               <input type="hidden" name="envio" value="true">
               <input type="hidden" name="B1" value="Apagar">
               <input type="hidden" name="im_nome" value="<?php print("$im_nome"); ?>">
               <input type="hidden" name="im_cod" value="<?php print("$im_cod"); ?>">
               </td>
               </tr>
              </form>
               </table>
<?php
	}
// Recupera o código randomico e termina a sessão
//ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
//if(IsSet($_SESSION["codigo"]))
if(session_is_registered("codigo"))
   {
    $random = $_SESSION["codigo"];
    //$_SESSION = array();
    session_unregister("codigo");
   }

// obtém o código digitado
$codigo = $_POST["codigo"];
$envio = $_POST["envio"];

// verifica se o formulário contém dados
 if (isset($envio) and $codigo == $random) {
   $mensagem = "Parabéns. O código foi digitado corretamente.";
   print $mensagem . "<br>";

	$query4 = "select * from rebri_imagens where img_imob='$im_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{

	$foto = explode(".", $not5[img_arq]);
	$foto_peq = $foto[0] .  "_peq.jpg";
	
	$foto2 = explode(".", $not5[img_arq]);
	$foto_med = $foto2[0] .  "_med.jpg";

	if (file_exists($caminho_logo.$not4[img_arq]))
	{
	unlink($caminho_logo.$not4[img_arq]);
	}
	}

	if (file_exists($caminho_logop.$foto_peq))
	{
	unlink($caminho_logop.$foto_peq);
	}
	
	if (file_exists($caminho_logom.$foto_med))
	{
	unlink($caminho_logom.$foto_med);
	}
	
	}

	$query = "delete from rebri_imoveis where i_imob = '$im_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");

	$query = "delete from rebri_imagens where img_imob = '$im_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");

	//busca o nome da pasta
	$busca = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$im_cod."'");
    while($linha = mysql_fetch_array($busca)){
         $pasta = $linha['nome_pasta'];
    }

	// apaga pasta locacao e imagens dentro
	$dirl = "../imobiliarias/".$pasta."/locacao/";

	$strDiretoriol = $dirl;
	$strDiretorioAbrirl = opendir($strDiretoriol);

	$il = 0;
	$arquivosl = array();

	while($strArquivosl = readdir($strDiretorioAbrirl)) {
		if($strArquivosl != "." && $strArquivosl != "..") {
			$arquivosl[$il] = $strArquivosl;
            unlink($dirl.$arquivosl[$il]);
			$il++;
		}
	}
	rmdir($dirl);

	//apaga pasta locacao peq e imagens dentro
	$dirlp = "../imobiliarias/".$pasta."/locacao_peq/";

	$strDiretoriolp = $dirlp;
	$strDiretorioAbrirlp = opendir($strDiretoriolp);

	$ilp = 0;
	$arquivoslp = array();

	while($strArquivoslp = readdir($strDiretorioAbrirlp)) {
		if($strArquivoslp != "." && $strArquivoslp != "..") {
			$arquivoslp[$ilp] = $strArquivoslp;
            unlink($dirlp.$arquivoslp[$ilp]);
			$ilp++;
		}
	}
	rmdir($dirlp);

	//apaga pasta venda  e imagens dentro
	$dirv = "../imobiliarias/".$pasta."/venda/";

	$strDiretoriov = $dirv;
	$strDiretorioAbrirv = opendir($strDiretoriov);

	$iv = 0;
	$arquivosv = array();

	while($strArquivosv = readdir($strDiretorioAbrirv)) {
		if($strArquivosv != "." && $strArquivosv != "..") {
			$arquivosv[$iv] = $strArquivosv;
            unlink($dirv.$arquivosv[$iv]);
			$iv++;
		}
	}

	rmdir($dirv);

   //apaga pasta venda peq e imagens dentro
	$dirvp = "../imobiliarias/".$pasta."/venda_peq/";

	$strDiretoriovp = $dirvp;
	$strDiretorioAbrirvp = opendir($strDiretoriovp);

	$ivp = 0;
	$arquivosvp = array();

	while($strArquivosvp = readdir($strDiretorioAbrirvp)) {
		if($strArquivosvp != "." && $strArquivosvp != "..") {
			$arquivosvp[$ivp] = $strArquivosvp;
            unlink($dirvp.$arquivosvp[$ivp]);
			$ivp++;
		}
	}

	rmdir($dirvp);


	//apaga pasta venda vistoria e imagens dentro
	$dirvv = "../imobiliarias/".$pasta."/venda_vistoria/";

	$strDiretoriovv = $dirvv;
	$strDiretorioAbrirvv = opendir($strDiretoriovv);

	$ivv = 0;
	$arquivosvv = array();

	while($strArquivosvv = readdir($strDiretorioAbrirvv)) {
		if($strArquivosvv != "." && $strArquivosvv != "..") {
			$arquivosvv[$ivv] = $strArquivosvv;
            unlink($dirvv.$arquivosv[$ivv]);
			$ivv++;
		}
	}

	rmdir($dirvv);

	//apaga pasta venda peq vistoria e imagens dentro
	$dirvpv = "../imobiliarias/".$pasta."/venda_vistoria_peq/";

	$strDiretoriovpv = $dirvpv;
	$strDiretorioAbrirvpv = opendir($strDiretoriovpv);

	$ivpv = 0;
	$arquivosvpv = array();

	while($strArquivosvpv = readdir($strDiretorioAbrirvpv)) {
		if($strArquivosvpv != "." && $strArquivosvpv != "..") {
			$arquivosvpv[$ivpv] = $strArquivosvpv;
            unlink($dirvpv.$arquivosvp[$ivpv]);
			$ivpv++;
		}
	}

	rmdir($dirvpv);

	// apaga pasta locacao vistoria e imagens dentro
	$dirlv = "../imobiliarias/".$pasta."/locacao_vistoria/";

	$strDiretoriolv = $dirlv;
	$strDiretorioAbrirlv = opendir($strDiretoriolv);

	$ilv = 0;
	$arquivoslv = array();

	while($strArquivoslv = readdir($strDiretorioAbrirlv)) {
		if($strArquivoslv != "." && $strArquivoslv != "..") {
			$arquivoslv[$ilv] = $strArquivoslv;
            unlink($dirlv.$arquivosl[$ilv]);
			$ilv++;
		}
	}
	rmdir($dirlv);

	//apaga pasta locacao peq vistoria e imagens dentro
	$dirlpv = "../imobiliarias/".$pasta."/locacao_vistoria_peq/";

	$strDiretoriolpv = $dirlpv;
	$strDiretorioAbrirlpv = opendir($strDiretoriolpv);

	$ilpv = 0;
	$arquivoslpv = array();

	while($strArquivoslpv = readdir($strDiretorioAbrirlpv)) {
		if($strArquivoslpv != "." && $strArquivoslpv != "..") {
			$arquivoslpv[$ilpv] = $strArquivoslpv;
            unlink($dirlpv.$arquivoslp[$ilpv]);
			$ilpv++;
		}
	}
	rmdir($dirlpv);
	
	// apaga pasta banner_site e imagens dentro
	$dirba = "../imobiliarias/".$pasta."/banner_site/";

	$strDiretorioba = $dirba;
	$strDiretorioAbrirba = opendir($strDiretorioba);

	$iba = 0;
	$arquivosba = array();

	while($strArquivosba = readdir($strDiretorioAbrirba)) {
		if($strArquivosba != "." && $strArquivosba != "..") {
			$arquivosba[$iba] = $strArquivosba;
            unlink($dirba.$arquivosba[$iba]);
			$iba++;
		}
	}
	rmdir($dirba);


	//apaga pasta da imobiliaria
	$dirp = "../imobiliarias/".$pasta;
	rmdir($dirp);


	//$query33 = "delete from doc where cod_imobiliaria = '$im_cod'";
	//$result33 = mysql_query($query33) or die("Não foi possível apagar suas informações. $query33");

	$resultado_tabelas = mysql_list_tables($username);
   $qntd_tabelas = @mysql_numrows($resultado_tabelas);
   for ($i = 0; $i < $qntd_tabelas; $i++) {
      if (mysql_tablename($resultado_tabelas, $i) <> 'area'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_bairros'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_cidades'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_imagens'
         && mysql_tablename($resultado_tabelas, $i) <> 'docs_padrao'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_banners'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_clientes_site'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_imobiliarias'
         && mysql_tablename($resultado_tabelas, $i) <> 'finalidade'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_caracteristicas'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_destaques'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_imoveis'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_listas'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_noticias'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_estados'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_imoveis_temp'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_rebri_cidades'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_rebri_imagens'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_rebri_imoveis_temp'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_rebri_stats'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_stats'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_tipo'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_usuarios'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_buscas'
         && mysql_tablename($resultado_tabelas, $i) <> 'bp_users'
         && mysql_tablename($resultado_tabelas, $i) <> 'bp_messages'
		 && mysql_tablename($resultado_tabelas, $i) <> 'atualiza_imoveis'
		 && mysql_tablename($resultado_tabelas, $i) <> 'atualizacao_historico'
		 && mysql_tablename($resultado_tabelas, $i) <> 'm_clientes'
		 && mysql_tablename($resultado_tabelas, $i) <> 'mapa'
		 && mysql_tablename($resultado_tabelas, $i) <> 'mapa_tipo'
		 && mysql_tablename($resultado_tabelas, $i) <> 'senha_web'
		 && mysql_tablename($resultado_tabelas, $i) <> 'servicos'
		 && mysql_tablename($resultado_tabelas, $i) <> 'stats'
         && mysql_tablename($resultado_tabelas, $i) <> 'tipos_clientes'
         && mysql_tablename($resultado_tabelas, $i) <> 'tipos_prestadores'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_tipo_anuncios'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_comercios'
         && mysql_tablename($resultado_tabelas, $i) <> 'rebri_fotos_temp'
 	     && mysql_tablename($resultado_tabelas, $i) <> 'rebri_tipo_comercio') {
      $tables = mysql_tablename($resultado_tabelas, $i);
      $queryA = "delete from $tables where cod_imobiliaria = '$im_cod'";
      $resultA = mysql_query($queryA) or die("Não foi possível apagar suas informações. $queryA");
	  $queryA2 = "delete from atualizacao_historico where ah_imobiliaria = '$im_cod'";
      $resultA2 = mysql_query($queryA2) or die("Não foi possível apagar suas informações. $queryA2");
	  $queryA3 = "delete from atualiza_imoveis where a_imobiliaria = '$im_cod'";
      $resultA3 = mysql_query($queryA3) or die("Não foi possível apagar suas informações. $queryA3");
      $queryA4 = "delete from m_clientes where cl_imobiliaria = '$im_cod'";
      $resultA4 = mysql_query($queryA4) or die("Não foi possível apagar suas informações. $queryA4");
      $queryA5 = "delete from rebri_imagens where img_imob = '$im_cod'";
      $resultA5 = mysql_query($queryA5) or die("Não foi possível apagar suas informações. $queryA5");
      $queryA6 = "delete from rebri_rebri_imagens where img_imob = '$im_cod'";
      $resultA6 = mysql_query($queryA6) or die("Não foi possível apagar suas informações. $queryA6");
      $queryA7 = "delete from stats where s_imobiliaria  = '$im_cod'";
      $resultA7 = mysql_query($queryA7) or die("Não foi possível apagar suas informações. $queryA7");
      $queryA8 = "delete from rebri_comercios where c_imobiliaria  = '$im_cod'";
      $resultA8 = mysql_query($queryA8) or die("Não foi possível apagar suas informações. $queryA8");
      

	}
	}
	$query = "delete from rebri_imobiliarias where im_cod = '$im_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");

echo ('<script language="javascript">alert("Você apagou a imobiliária '.$im_nome.' e todos os imóveis, usuários e fotos relacionados a ela!");document.location.href="p_imobiliarias.php";</script>');
?>
<?php
 }elseif(isset($envio) and $codigo != $random)
 {
   $mensagem = "Erro! Por favor tente novamente.";
   echo $mensagem . "<br>";
   //O formulário abaixo repete também na linha 109. Sempre que alterar um precisa alterar o outro pra deixar igual
?>
              <table border="0" width="80%" align="center">
              <form name="form1" action="p_imobiliarias.php" method="post">
               <tr>
               <td align="center" height = "50" class=style2>
               Para apagar a imobiliária <b><?php print("$im_nome"); ?></b> e todos os seus imóveis e usuários digite o código abaixo:
               </td></tr>
               <!-- gera imagem com número aleatório -->
               <tr><td align="center">
               <img src="imagem.php">
               </td></tr>
               <tr>
               <td align="center" height = "50" class=style2>
               <input type=text name="codigo" size = "12" class=campo>
               </td></tr>
               <tr>
               <td align="center">
               <input type="submit" name="Submit" value="Enviar" class=campo>
               <input type="reset" name="Submit" value="Limpar" class=campo>
               <input type="hidden" name="envio" value="true">
               <input type="hidden" name="B1" value="Apagar">
               <input type="hidden" name="im_nome" value="<?php print("$im_nome"); ?>">
               <input type="hidden" name="im_cod" value="<?php print("$im_cod"); ?>">
               </td>
               </tr>
              </form>
               </table>
<?php
 }
}

//Atualizar Imobiliária
if($atualiza == "1")
{
#   $im_site_institucional = addslashes($im_site_institucional);

	$pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$im_email."' AND u_senha='".md5($im_senha)."' AND cod_imobiliaria='".$im_cod."'";
	$pw_result = mysql_query($pw_query) or die("Não foi possivel inserir suas informações");
	$pw_rows = mysql_num_rows($pw_result);
	if ($pw_rows == 0) {

	$nome_imob = $im_nome;

	// tira os acentos e espaço
	$im_nome = ereg_replace("[ÁÀÂÃ]","A",$im_nome);
	$im_nome = ereg_replace("[áàâãª]","a",$im_nome);
	$im_nome = ereg_replace("[ÉÈÊ]","E",$im_nome);
	$im_nome = ereg_replace("[éèê]","e",$im_nome);
	$im_nome = ereg_replace("[ÓÒÔÕ]","O",$im_nome);
	$im_nome = ereg_replace("[óòôõº]","o",$im_nome);
	$im_nome = ereg_replace("[ÚÙÛ]","U",$im_nome);
	$im_nome = ereg_replace("[úùû]","u",$im_nome);
	$im_nome = ereg_replace("[íìî]","i",$im_nome);
	$im_nome = ereg_replace("[ÍÌÎ]","I",$im_nome);
	$im_nome = str_replace("Ç","C",$im_nome);
	$im_nome = str_replace("ç","c",$im_nome);
	$im_nome = str_replace(" ","",$im_nome);

	if($nome_imob <> $_POST['im_nome']){
	// pega o nome da imobiliária, deixa em minúsculas e pega os 6 primeiros caracteres se caso for menor que 6 complementa com 0
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

	// verifica se a pasta já existe
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
	}

    //if(substr($_POST['im_site'] ,0, 7) <> 'http://'){
  	//    	        $im_site = 'http://'.$_POST['im_site'];
  	//            }else{
		   	        $im_site = $_POST['im_site'];
	//            }


	if ($nome_imob <> $_POST['im_nome']) {

		$query = "UPDATE rebri_imobiliarias set im_nome='$nome_imob', im_contato='$im_contato'
         , im_resp='$im_resp', im_creci_resp='$im_creci_resp', im_nacionalidade='$im_nacionalidade'
         , im_est_civil='$im_est_civil', im_n_conselho='$im_n_conselho', im_cnpj='$im_cnpj'
         , im_banco='$im_banco', im_agencia='$im_agencia', im_conta='$im_conta', im_tel='$im_tel'
         , im_fax='$im_fax', im_cel='$im_cel', im_email='$im_email', im_cidade='$im_cidade'
         , im_estado='$im_estado', im_end='$im_end', im_end2='$im_end2', iend_igual='$end_igual'
         , im_end_mapa='$im_end_mapa', end_igual2='$end_igual2', im_end_mapa2='$im_end_mapa2'
         , im_bairro2='$im_bairro2', im_cep2='$im_cep2', im_tel2='$im_tel2', im_email2='$im_email2'
         , im_bairro='$im_bairro', im_cep='$im_cep', im_site='$im_site', im_site2='$im_site2'
         , im_site_institucional='$im_site_institucional'
         , im_disponibilizar='$im_disponibilizar', im_desativar='$im_desativar', im_img='$im_img'
         , im_desc='$im_desc', nome_pasta='$nome_pasta', contrato_venda='$contrato_venda'
         , contrato_locacao='$contrato_locacao'
         where im_cod='$im_cod'";
		$result = mysql_query($query) or die("Não foi possível atualizar suas informações. $query");

	} else {

      $query = "update rebri_imobiliarias set im_nome='$nome_imob', im_contato='$im_contato'
         , im_resp='$im_resp', im_creci_resp='$im_creci_resp', im_nacionalidade='$im_nacionalidade'
         , im_est_civil='$im_est_civil', im_n_conselho='$im_n_conselho', im_cnpj='$im_cnpj'
         , im_banco='$im_banco', im_agencia='$im_agencia', im_conta='$im_conta', im_tel='$im_tel'
         , im_fax='$im_fax', im_cel='$im_cel', im_email='$im_email', im_cidade='$im_cidade'
         , im_estado='$im_estado', im_end='$im_end', im_end2='$im_end2', iend_igual='$end_igual'
         , im_end_mapa='$im_end_mapa', end_igual2='$end_igual2', im_end_mapa2='$im_end_mapa2'
         , im_bairro2='$im_bairro2', im_cep2='$im_cep2', im_tel2='$im_tel2', im_email2='$im_email2'
         , im_bairro='$im_bairro', im_cep='$im_cep', im_site='$im_site', im_site2='$im_site2'
         , im_disponibilizar='$im_disponibilizar', im_desativar='$im_desativar', im_img='$im_img'
         , im_desc='$im_desc', contrato_venda='$contrato_venda', contrato_locacao='$contrato_locacao'
         , im_site_padrao = '$_POST[im_site_padrao]'
         where im_cod='$im_cod'";
		$result = mysql_query($query) or die("Não foi possível atualizar suas informações. $query");
	}

	//controle
   	mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$im_cod."','".$u_cod."','Atualizar Imobiliária',current_date,current_time)") or die ("Erro 604 - ".mysql_error());

?>
<p align="center">
Você atualizou a imobiliária <i><?php print("$im_nome"); ?></i>.</p>
<?php

	}else{
	  echo ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");document.location.href="p_imobiliarias.php";</script>');
	}

}
if ($lista == "") {

	if(!$screen){
	$screen = 1;
	}

	if(!$from){
	$from = intval(($screen - 1) * 30);
	}

	$query1 = "select * from rebri_imobiliarias i inner join rebri_estados e on (i.im_estado=e.e_cod) inner join rebri_cidades c on (i.im_cidade=c.ci_cod)
	order by i.im_nome
	limit $from, 30";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<div align="center">
  <center>
                  <table width="600" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
                  <tr><td colspan="6" bgcolor="#<?php print("$cor5"); ?>">
                  <p align="center"><b>
                  <i><?php print("$ca_nome"); ?></i></b></p></td></tr>
                  <tr><td>
                  <b>Nome</b></td><td>
                  <b>Contato</b></td><td>
                  <b>E-mail</b></td><td>
                  <b>Cidade</b></td><td>
                  <b>Estado</b></td><td>
				  <b>Status</b></td></tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;

	if (($i % 2) == 1){ $fundo="DCE0E4"; }else{ $fundo="EDEEEE"; }
	$i++;

	if($not[im_desativar]=='0'){
	  $desativar = "Ativo";
	}else{
	  $desativar = "Inativo";
	}

?>
<tr bgcolor="<?php print("$fundo"); ?>"><td width="25%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[im_nome]"); ?></a></td><td width="20%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[im_contato]"); ?></a></td><td width="20%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[im_email]"); ?></a></td><td width="20%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[ci_nome]"); ?></a></td><td width="15%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[e_nome]"); ?></a></td><td width="15%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$desativar"); ?></a></td>
</tr>
<?php
	}

	$query2 = "select count(im_cod) as contador
	from rebri_imobiliarias";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$pages = ceil($not2[contador] / 30);
?>
                  <tr><td colspan="6" bgcolor="#<?php print("$cor5"); ?>">

                  <p align="center">
                  <i>Foram encontradas <?php print("$not2[contador]"); ?> imobiliárias</i></td></tr>
                  <tr><td colspan=6 align=center class=style2>
<?php
	if ($from > 30) {
	$url1 = $PHP_SELF . "?screen=" . ($screen - 1);
?>
                  <a href="javascript:history.back()" class=style2>
                  << Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class=style2>
                  << Página anterior <<</a>
<?php
	}

	for ($i = 1; $i <= $pages; $i++) {
		if($pesq == ""){
  	$url2 = $PHP_SELF . "?screen=" . $i;
		}
		else
		{
  	$url2 = $PHP_SELF . "?screen=" . $i;
		}
  	if($i == $screen){
  	echo "   | <a href=\"$url2\"><b><font color=#ff0000>$i</b></a> |   ";
	}
  	else
  	{
  	echo "   | <a href=\"$url2\" class=style2>$i</a> |   ";	
  	}
	}

	if ($from >= $not2[contador]) {
?>
		  
		  Última página da pesquisa
<?php
	}
	else
	{
		if($pesq == ""){
  	$url3 = $PHP_SELF . "?screen=" . ($screen + 1);
		}
		else
		{
  	$url3 = $PHP_SELF . "?screen=" . ($screen + 1);
		}
?>
                  <a href="<?php print("$url3"); ?>" class=style2>
                  >> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
?>
	</table>
	</center>
	</div>
<?php
	}
//mysql_close($con);

	} else {

################################################################################

	if($edit == "editar"){
	$query2 = "select *, (select ci_nome from rebri_cidades where ci_cod=im_cidade) as cidade_nome from rebri_imobiliarias where im_cod = '$im_cod'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$ano1 = substr ($not2[im_nasc], 0, 4);
	$mes1 = substr($not2[im_nasc], 5, 2 );
	$dia1 = substr ($not2[im_nasc], 8, 2 );
   $pasta_imobiliaria = $not2[nome_pasta];

	$not2[im_senha] = $not2[im_senha];
	$img = $not2['im_img'];
	$im_img_topo_site = $not2['im_img_topo_site'];
	$im_img_fundo_topo = $not2['im_img_fundo_topo'];
	$end_igual = $not2['iend_igual'];
	$end_igual2 = $not2['end_igual2'];

if(!IsSet($editar))
	{
?>
<script language="JavaScript">
/*
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
               alert("Esse browser não tem recursos para uso do Ajax");
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
	        idOpcao.innerHTML = "Selecione uma opção";
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
*/
var req;

function loadXMLDoc(url,valor)
{
    req = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processReqChange;
        req.open("GET", url+'?estado='+valor, true);
        req.send(null);
    // Procura por uma versao ActiveX (IE)
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processReqChange;
            req.open("GET", url+'?estado='+valor, true);
            req.send();
        }
    }
}

function processReqChange()
{
    // apenas quando o estado for "completado"
    if (req.readyState == 4) {
        // apenas se o servidor retornar "OK"
        if (req.status == 200) {
            // procura pela div id="atualiza" e insere o conteudo
            // retornado nela, como texto HTML
            document.getElementById('cidades').innerHTML = req.responseText;
        } else {
            alert("Houve um problema ao obter os dados:\n" + req.statusText);
        }
    }
}

function Atualiza(valor)
{
    loadXMLDoc("cidades.php",valor);
}
</script>
 <div align="center">
  <center>
  	<table>
	<tr>
		<td>
  <form method="post" name="formulario" action="p_imobiliarias.php">
  <input type="hidden" name="editar" value="1">
  <input type="hidden" name="atualiza" id="atualiza" value="0">
  <input type="hidden" value="<?php print($not2[im_cod]); ?>" name="im_cod">

  <table border="0" cellspacing="1" width="850">
    <tr>
      <td width="20%" class=style2>Código:</td>
      <td width="80%" class=style2><?php print($not2[im_cod]); ?> </td>
    </tr>
    <tr>
      <td width="20%" class=style2>Nome:</td>
      <td width="80%" class=style2> <input type="text" name="im_nome" id="im_nome" size="40" class="campo" value="<?php if($_POST['im_nome']){ print($_POST['im_nome']); }else{ print($not2[im_nome]); } ?>"></td>
    </tr>
	<tr>
      <td width="20%" class=style2>N° do Creci:</td>
      <td width="80%" class=style2> <input type="text" name="im_n_conselho" size="10" class="campo" value="<?php if($_POST['im_n_conselho']){ print($_POST['im_n_conselho']); }else{ print($not2[im_n_conselho]); } ?>"></td>
    </tr>
	 <tr>
      <td width="20%" class=style2>CPF ou CNPJ:</td>
      <td width="80%" class=style2> <input type="text" name="im_cnpj" size="20" maxlength="20" class="campo" value="<?php if($_POST['im_cnpj']){ print($_POST['im_cnpj']); }else{ print($not2[im_cnpj]); } ?>" onBlur="javascript:Verifica_CPF_CGC(this);"  onKeyUp="return autoTab(this, 20, event);"></td>
    </tr>
    <tr>
      <td width="27%" class=style2>Banco:</td>
      <td width="73%" class=style2> <input type="text" name="im_banco" size="40" class="campo" value="<?php if($_POST['im_banco']){ print($_POST['im_banco']); }else{ print($not2[im_banco]); } ?>"></td>
    </tr>
     <tr>
      <td width="27%" class=style2>Agência:</td>
      <td width="73%" class=style2> <input type="text" name="im_agencia" size="15" class="campo" value="<?php if($_POST['im_agencia']){ print($_POST['im_agencia']); }else{ print($not2[im_agencia]); } ?>"></td>
    </tr>
     <tr>
      <td width="27%" class=style2>Conta:</td>
      <td width="73%" class=style2> <input type="text" name="im_conta" size="15" class="campo" value="<?php if($_POST['im_conta']){ print($_POST['im_conta']); }else{ print($not2[im_conta]); } ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Contato:</td>
      <td width="80%" class=style2> <input type="text" name="im_contato" id="im_contato" size="40" class="campo" value="<?php if($_POST['im_contato']){ print($_POST['im_contato']); }else{ print($not2[im_contato]); } ?>"></td>
    </tr>
	 <tr>
       <td width="20%" class=style2>Nome do Respons&aacute;vel: </td>
       <td width="80%" class=style2><input type="text" name="im_resp" id="im_resp" size="40" class="campo" value="<?php if($_POST['im_resp']){ print($_POST['im_resp']); }else{ print($not2[im_resp]); } ?>"></td>
     </tr>
     <tr>
       <td width="20%" class=style2>N&deg; do Creci do Respons&aacute;vel: </td>
       <td width="80%" class=style2><input type="text" name="im_creci_resp" size="10" class="campo" value="<?php if($_POST['im_creci_resp']){ print($_POST['im_creci_resp']); }else{ print($not2[im_creci_resp]); } ?>"></td>
     </tr>
	 <tr>
      <td width="20%" class=style2>Nacionalidade:</td>
      <td width="80%" class=style2> <input type="text" name="im_nacionalidade" size="40" class="campo" value="<?php if($_POST['im_nacionalidade']){ print($_POST['im_nacionalidade']); }else{ print($not2[im_nacionalidade]); } ?>"></td>
    </tr>
	 <tr>
      <td width="20%" class=style2>Estado Civil:</td>
      <td width="80%" class=style2><select name="im_est_civil" class="campo">
	        <option value="0">Selecione</option>
			<option value="Casado(a)" <? if($_POST['im_est_civil']=='Casado(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Casado(a)'){ print "SELECTED"; } ?>>Casado(a)</option>
			<option value="Divorciado(a)" <? if($_POST['im_est_civil']=='Divorciado(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Divorciado(a)'){ print "SELECTED"; } ?>>Divorciado(a)</option>
			<option value="Separado(a)" <? if($_POST['im_est_civil']=='Separado(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Separado(a)'){ print "SELECTED"; } ?>>Separado(a)</option>
			<option value="Solteiro(a)" <? if($_POST['im_est_civil']=='Solteiro(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Solteiro(a)'){ print "SELECTED"; } ?>>Solteiro(a)</option>
			<option value="Viúvo(a)" <? if($_POST['im_est_civil']=='Viúvo(a)'){ print "SELECTED"; }elseif($not2[im_est_civil]=='Viúvo(a)'){ print "SELECTED"; } ?>>Viúvo(a)</option>
	     </select></td>
    </tr>
    <tr>
      <td width="20%" class=style2>E-mail:</td>
      <td width="80%" class=style2> <input type="text" name="im_email" id="im_email" size="40" class="campo" value="<?php if($_POST['im_email']){ print($_POST['im_email']); }else{ print("$not2[im_email]"); } ?>"></td>
    </tr>
    <!--tr>
      <td width="20%" class=style2>Senha:</td>
      <td width="80%" class=style7> <input type="password" name="im_senha" id="im_senha" size="6" class="campo" maxlength="6" onKeyUp="return autoTab(this, 6, event);" value="<?php //if($_POST['im_senha']){ print($_POST['im_senha']); }else{ print("$not2[im_senha]"); } ?>"> Obs.: 6 dígitos</td>
    </tr-->
    <tr>
      <td width="20%" class=style2>Telefone:</td>
      <td width="80%" class=style2> <input type="text" name="im_tel" id="im_tel" size="20" class="campo" value="<?php if($_POST['im_tel']){ print($_POST['im_tel']); }else{ print($not2[im_tel]); } ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Celular:</td>
      <td width="80%" class=style2> <input type="text" name="im_cel" id="im_cel" size="20" class="campo" value="<?php if($_POST['im_cel']){ print($_POST['im_cel']); }else{ print($not2[im_cel]); } ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Fax:</td>
      <td width="80%" class=style2> <input type="text" name="im_fax" id="im_fax" size="20" class="campo" value="<?php if($_POST['im_fax']){ print($_POST['im_fax']); }else{ print($not2[im_fax]); } ?>"></td>
    </tr>
  	<tr>
  	<td width="20%">
        <p align="left" class="style2">Estado:</td>
        <td width="80%" class="style2"><!--select name="im_estado" id="im_estado" onChange="Dados(this.value);" class=campo>
	        <option value="0">Selecione o Estado</option>
<?
/*
//require_once("conecta.php");
$sql = "SELECT e_cod, e_uf, e_nome FROM rebri_estados ORDER BY e_nome";
$sql = mysql_query($sql);
$row = mysql_num_rows($sql); 

	while($not4 = mysql_fetch_array($sql))
	{
*/
?>
		    <? //for($i=0; $i<$row; $i++) { ?>
<?php
/*
	if($not4[e_cod] == $not2[im_estado]){
		$estado_atual = $not4[e_nome];
*/
?>
		       <option selected value="<? //echo $not4[e_cod]; ?>">
			   <? //echo $not4[e_nome]; ?></option>
<?php
/*
	}
	else
	{
*/	  
?>
		       <option value="<? //echo $not4[e_cod]; ?>">
			   <? //echo $not4[e_nome]; ?></option>
<?php
/*
	}
  }
*/  
?>
	     </select-->
        <select name="im_estado" id="im_estado" class="campo" onChange="javascript:Atualiza(this.value);">
        <option value="0">Selecione</option>
		<?
    	if($_POST['im_estado']){
		  	$bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$_POST['im_estado']){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>');
				}else{ 			   
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
			} 		  
		}else{
		 	$bestados = mysql_query("SELECT e_cod, e_uf FROM rebri_estados ORDER BY e_uf ASC");
 			while($linha = mysql_fetch_array($bestados)){
				if($linha[e_cod]==$not2['im_estado']){
			   		echo('<option value="'.$linha[e_cod].'" SELECTED>'.$linha['e_uf'].'</option>');
				}else{ 			   
					echo('<option value="'.$linha[e_cod].'">'.$linha['e_uf'].'</option>');
				}
			} 
		}
		?>
   	</select>		 	 
		 </td>
      </tr>
    <tr>
      <td width="20%" class="style2">Cidade:</td>
      <td width="80%" class="style2"><div id="cidades"><? if($not2['im_cidade']){  ?>
        	<select name="im_cidade" id="im_cidade" class="campo">
   			<option value="0">Selecione</option> 
	  <?
   		if($_POST['im_cidade']){
	    	$bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades ORDER BY ci_nome ASC");
 	    	while($linha = mysql_fetch_array($bcidades)){
				if($linha[ci_cod]==$_POST['im_cidade']){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{ 			   
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
		}else{
		  	$bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades ORDER BY ci_nome ASC");
 	    	while($linha = mysql_fetch_array($bcidades)){
				if($linha[ci_cod]==$not2['im_cidade']){
			   		echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
				}else{
					echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
				}
			}
		}
	  ?>
	  </select>
	 <? } ?></div><!--select name="im_cidade" id="im_cidade" class="campo">
			<option id="opcoes" value="<? //echo $not2[im_cidade]; ?>"><? //echo $not2[cidade_nome]; ?></option>
	     </select--></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Endereço:</td>
      <td width="80%" class=style2> <input type="text" name="im_end" id="im_end" size="40" class="campo" value="<?php if($_POST['im_end']){ print($_POST['im_end']); }else{ print($not2[im_end]); } ?>"></td>
    </tr>
    <tr>
      <td width="40%" class=style2>Endere&ccedil;os Id&ecirc;nticos?</td>
      <td width="60%" class="style2"><input name="end_igual" type="checkbox" id="end_igual" value="1" <? if($end_igual=='1'){ print "CHECKED"; } ?> OnClick="TravaCampo();">
        Sim</td>
    </tr>
    <tr>
      <td width="40%" class=style2>Endereço Mapa:</td>
      <td width="60%" class=style2> <input type="text" name="im_end_mapa" size="40" class="campo" value="<?php if($_POST['im_end_mapa']){ print($_POST['im_end_mapa']); }else{ print($not2[im_end_mapa]); } ?>" <? if($end_igual=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Bairro:</td>
      <td width="80%" class=style2> <input type="text" name="im_bairro" id="im_bairro" size="40" class="campo" value="<?php if($_POST['im_bairro']){ print($_POST['im_bairro']); }else{ print($not2[im_bairro]); } ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>CEP:</td>
      <td width="80%" class=style2> <input type="text" name="im_cep" id="im_cep" size="8" class="campo" maxlength="8" onKeyUp="return autoTab(this, 8, event);" value="<?php if($_POST['im_cep']){ print($_POST['im_cep']); }else{ print($not2[im_cep]); } ?>"></td>
    </tr>
	<tr>
      <td width="20%" class=style2>Endereço 2:</td>
      <td width="80%" class=style2> <input type="text" name="im_end2" id="im_end2" size="40" class="campo" value="<?php if($_POST['im_end2']){ print($_POST['im_end2']); }else{ print($not2[im_end2]); } ?>"></td>
    </tr>
     <tr>
      <td width="40%" class=style2>Endere&ccedil;os Id&ecirc;nticos 2?</td>
      <td width="60%" class="style2"><input name="end_igual2" type="checkbox" id="end_igual2" value="1" <? if($end_igual2=='1'){ print "CHECKED"; } ?> OnClick="TravaCampo2();">
        Sim</td>
    </tr>
    <tr>
      <td width="40%" class=style2>Endereço Mapa:</td>
      <td width="60%" class=style2> <input type="text" name="im_end_mapa2" size="40" class="campo" value="<?php if($_POST['im_end_mapa2']){ print($_POST['im_end_mapa2']); }else{ print($not2[im_end_mapa2]); } ?>" <? if($end_igual2=='1'){ ?> disabled="disabled" style="background:#D6D6D6;" <? }?>></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Bairro do Endereço 2:</td>
      <td width="80%" class=style2> <input type="text" name="im_bairro2" id="im_bairro2" size="40" class="campo" value="<?php if($_POST['im_bairro2']){ print($_POST['im_bairro2']); }else{ print($not2[im_bairro2]); } ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>CEP do Endereço 2:</td>
      <td width="80%" class=style2> <input type="text" name="im_cep2" id="im_cep2" size="8" class="campo" maxlength="8" onKeyUp="return autoTab(this, 8, event);" value="<?php if($_POST['im_cep2']){ print($_POST['im_cep2']); }else{ print($not2[im_cep2]); } ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Telefone do Endereço 2:</td>
      <td width="80%" class=style2> <input type="text" name="im_tel2" id="im_tel2" size="20" class="campo" value="<?php if($_POST['im_tel2']){ print($_POST['im_tel2']); }else{ print($not2[im_tel2]); } ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>E-mail do Endereço 2:</td>
      <td width="80%" class=style2> <input type="text" name="im_email2" id="im_email2" size="40" class="campo" value="<?php if($_POST['im_email2']){ print($_POST['im_email2']); }else{ print("$not2[im_email2]"); } ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Site:</td>
      <td width="80%" class=style2> http:// <input type="text" name="im_site" id="im_site" size="40" class="campo" value="<?php if($_POST['im_site']){ print($_POST['im_site']); }else{ print($not2[im_site]); } ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Site 2:</td>
      <td width="80%" class=style2> http:// <input type="text" name="im_site2" id="im_site2" size="40" class="campo" value="<?php if($_POST['im_site2']){ print($_POST['im_site2']); }else{ print($not2[im_site2]); } ?>"> Obs.: só aparece no portal.</td>
    </tr>
	<tr>
      <td width="40%" class=style2>Disponibilizar no site:</td>
      <td width="60%" class=style2><input name="im_disponibilizar" id="im_disponibilizar2" type="radio" value="1"  <? if($not2[im_disponibilizar]=='1'){ print "CHECKED"; }elseif($_POST['im_disponibilizar']=='1'){ print "CHECKED"; } ?>>
        Sim
        <input name="im_disponibilizar" type="radio" id="im_disponibilizar1" value="0" <? if($not2[im_disponibilizar]=='0'){ print "CHECKED"; }elseif($_POST['im_disponibilizar']=='0'){ print "CHECKED"; } ?>>
        N&atilde;o</td>
   </tr>
	<tr>
      <td width="40%" class=style2>Site padrão:</td>
      <td width="60%" class=style2>
			<input name="im_site_padrao" id="im_site_padrao" type="radio" value="S"  <? if($not2[im_site_padrao]=='S'){ print "CHECKED"; }elseif($_POST['im_site_padrao']=='S'){ print "CHECKED"; }  ?>> Sim
         <input name="im_site_padrao" type="radio" id="im_site_padrao" value="N" <? if($not2[im_site_padrao]=='N'){ print "CHECKED"; }elseif($_POST['im_site_padrao']=='N'){ print "CHECKED"; } ?>> N&atilde;o</td>
   </tr>
	<tr>
      <td width="40%" class=style2>Desativar Imobiliária:</td>
      <td width="60%" class=style2><input name="im_desativar" type="radio" id="im_desativar2" value="1" <? if($not2[im_desativar]=='1'){ print "CHECKED"; } ?>>
        Sim
        <input name="im_desativar" id="im_desativar1" type="radio" value="0"  <? if($not2[im_desativar]=='0'){ print "CHECKED"; } ?>>
        N&atilde;o</td>
    </tr>
    <tr>
      <td width="20%" class=style2 valign="top">*Imagem Grande no Sistema:</td>
      <td width="80%" class=style2> <input type="text" name="im_img" id="im_img" size="20" class="campo" value="<?php if($_POST['im_img']){ print($_POST['im_img']); }else{ print($not2[im_img]); } ?>" readonly>
      	<input type="button" value="Selecionar" class="campo" onClick="window.open('p_img_logo.php?status=g', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.</td>
    </tr>
<?php
     $caminho_logo_gr = "../logos/";

	if (file_exists($caminho_logo_gr.$not2[im_img]) and $not2[im_img]!='')
	{

?>
    <tr>
      <td width="20%" class=style2 valign="top"></td>
      <td width="80%" class=style2> <img src="<? echo($caminho_logo_gr.$not2[im_img]); ?>"></td>
    </tr>
<?php
	}

	$fotos2 = explode(".",$not2[im_img]);
	$extensao2 = $fotos2[1];
	$nome_foto2 = $fotos2[0]."_med";

	$caminho_logo_med = "../logos_med/";

  	if (file_exists($caminho_logo_med.$nome_foto2.".jpg")){
	    $foto_med_logo = $nome_foto2.".jpg";
	}elseif (file_exists($caminho_logo_med.$nome_foto2.".png")){
  		$foto_med_logo = $nome_foto2.".png";
  	}elseif (file_exists($caminho_logo_med.$nome_foto2.".gif")){
  	  	$foto_med_logo = $nome_foto2.".gif";
  	}

?>
    <tr>
      <td width="20%" class=style2 valign="top">*Imagem Grande no Site:</td>
      <td width="80%" class=style2> <input type="text" name="im_img_med" id="im_img_med" size="20" class="campo" value="<?php if($_POST['im_img_med']){ print($_POST['im_img_med']); }else{ print($foto_med_logo); } ?>" readonly>
      	<input type="button" value="Selecionar" class="campo" onClick="window.open('p_img_logo.php?status=l', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.<br><span class="style7"><b>ATENÇÃO:</b> A logo deve estar com o mesmo nome da logo "grande" "NO MOMENTO DE ENVIAR" a(s) logo(s) para que não ocorra problema na exibição da logo na lista de imobiliárias no site.</span></td>
    </tr>
<?php


	if (file_exists($caminho_logo_med.$foto_med_logo) and $foto_med_logo!='')
	{

?>
    <tr>
      <td width="20%" class=style2 valign="top"></td>
      <td width="80%" class=style2> <img src="<? echo($caminho_logo_med.$foto_med_logo); ?>"></td>
    </tr>
<?php
	}

 	$fotos = explode(".",$not2[im_img]);
	$extensao = $fotos[1];
	$nome_foto = $fotos[0]."_peq";

	$caminho_logo_pq = "../logos_peq/";

  	if (file_exists($caminho_logo_pq.$nome_foto.".jpg")){
	    $foto_peq_logo = $nome_foto.".jpg";
	}elseif (file_exists($caminho_logo_pq.$nome_foto.".png")){
  		$foto_peq_logo = $nome_foto.".png";
  	}elseif (file_exists($caminho_logo_pq.$nome_foto.".gif")){
  	  $foto_peq_logo = $nome_foto.".gif";
  	}

?>
    <tr>
      <td width="20%" class=style2 valign="top">*Imagem Pequena no Site/Sistema:</td>
      <td width="80%" class=style2> <input type="text" name="im_img_peq" id="im_img_peq" size="20" class="campo" value="<?php if($_POST['im_img_peq']){ print($_POST['im_img_peq']); }else{ print($foto_peq_logo); } ?>" readonly>
      	<input type="button" value="Selecionar" class="campo" onClick="window.open('p_img_logo.php?status=p', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.<br><span class="style7"><b>ATENÇÃO:</b> A logo deve estar com o mesmo nome da logo "grande" "NO MOMENTO DE ENVIAR" a(s) logo(s) para que não ocorra problema na exibição da logo pequena.</span></td>
    </tr>
<?php
     

	if (file_exists($caminho_logo_pq.$foto_peq_logo) and $foto_peq_logo!='')
	{

?>
    <tr>
      <td width="20%" class=style2 valign="top"></td>
      <td width="80%" class=style2> <img src="<? echo($caminho_logo_pq.$foto_peq_logo); ?>"></td>
    </tr>
<?php
	}
?>
    <tr>
      <td width="20%" class=style2 valign="top">Descrição:</td>
      <td width="80%" class=style2> <textarea name="im_desc" id="im_desc" cols="30" rows="5" class="campo"><?php if($_POST['im_desc']){ print($_POST['im_desc']); }else{ print($not2[im_desc]); } ?></textarea></td>
    </tr>
    <tr>
      <td width="20%" class=style2 valign="top">Nome da pasta:</td>
      <td width="80%" class=style2><?php print($not2[nome_pasta]); ?></td>
    </tr>
	 <tr>
      <td width="20%" class=style2 valign="top">Contrato para Venda: </td>
      <td width="80%" class=style2><select name="contrato_venda" id="contrato_venda" class="campo">
        <option value="">Selecione um contrato</option>
        <?php
		 if($_POST['contrato_venda']){ 
        	$documentosv = mysql_query("select d_id, d_cod, d_nome FROM doc WHERE d_tipo_contrato='V' AND cod_imobiliaria='".$im_cod."' ORDER BY d_nome ASC");
 			while($linhav = mysql_fetch_array($documentosv)){
 		  	$d_nomev = substr ($linhav[d_nome], 0, 50);
			$id_venda = $linhav['d_id'];
				if($linhav[d_cod]==$_POST['contrato_venda']){
					echo('<option value="'.$linhav[d_cod].'" title="'.$linhav[d_nome].'" SELECTED>'.$d_nomev.'...</option>');
				}else{
					echo('<option value="'.$linhav[d_cod].'" title="'.$linhav[d_nome].'">'.$d_nomev.'...</option>');
				}
 			}
		}else{
			$documentosv = mysql_query("select d_id, d_cod, d_nome FROM doc WHERE d_tipo_contrato='V' AND cod_imobiliaria='".$im_cod."' ORDER BY d_nome ASC");
 			while($linhav = mysql_fetch_array($documentosv)){
 		  	$d_nomev = substr ($linhav[d_nome], 0, 50);
			$id_venda = $linhav['d_id'];
				if($linhav[d_cod]==$not2['contrato_venda']){
					echo('<option value="'.$linhav[d_cod].'" title="'.$linhav[d_nome].'" SELECTED>'.$d_nomev.'...</option>');
				}else{ 			   
					echo('<option value="'.$linhav[d_cod].'" title="'.$linhav[d_nome].'">'.$d_nomev.'...</option>');
				}
 			}
		}
 	?>
      </select></td>
    </tr>
    <tr>
      <td width="20%" class=style2 valign="top">Contrato para Loca&ccedil;&atilde;o: </td>
      <td width="80%" class=style2><select name="contrato_locacao" id="contrato_locacao" class="campo">
        <option value="">Selecione um contrato</option>
        <?php
		 if($_POST['contrato_locacao']){
        	$documentosl = mysql_query("select d_id, d_cod, d_nome FROM doc WHERE d_tipo_contrato='L' AND cod_imobiliaria='".$im_cod."' ORDER BY d_nome ASC");
 			while($linhal = mysql_fetch_array($documentosl)){
 		  	$d_nomel = substr ($linhal[d_nome], 0, 50);
			$id_locacao = $linhal['d_id'];
				if($linhal[d_cod]==$_POST['contrato_locacao']){
					echo('<option value="'.$linhal[d_cod].'" title="'.$linhal[d_nome].'" SELECTED>'.$d_nomel.'...</option>');
				}else{
					echo('<option value="'.$linhal[d_cod].'" title="'.$linhal[d_nome].'">'.$d_nomel.'...</option>');
				}
 			}
		}else{
        	$documentosl = mysql_query("select d_id, d_cod, d_nome FROM doc WHERE d_tipo_contrato='L' AND cod_imobiliaria='".$im_cod."' ORDER BY d_nome ASC");
 			while($linhal = mysql_fetch_array($documentosl)){
 		  	$d_nomel = substr ($linhal[d_nome], 0, 50);
			$id_locacao = $linhal['d_id'];
				if($linhal[d_cod]==$not2['contrato_locacao']){
					echo('<option value="'.$linhal[d_cod].'" title="'.$linhal[d_nome].'" SELECTED>'.$d_nomel.'...</option>');
				}else{
					echo('<option value="'.$linhal[d_cod].'" title="'.$linhal[d_nome].'">'.$d_nomel.'...</option>');
				}
 			}
		}
 	?>
      </select>
</td>
    </tr>
	  <tr>
      <td colspan="5">
      <input class=campo type="button" value="Atualizar" name="B1" Onclick="VerificaCampo();">
<?
	if(session_is_registered("usu_cod")){
		if($usu_cod == 1 or $usu_cod == 7 or $usu_cod == 9 or $usu_cod == 31 or $usu_cod == 13){
?>
	  <input class=campo type="submit" value="Apagar" name="B1">
<?
		}
	}
?>
<?
/*
	if(session_is_registered("usu_cod")){
		if($usu_cod == 1 or $usu_cod == 7 or $usu_cod == 9){
?>
	  <input class=campo type="submit" value="Desativar" name="B1">
<?
		}
	}
*/

	/*  <input class=campo type="submit" value="Computadores" name="inserir" onClick="formulario.action='cadastro_computadores.php?cod_imob=<?=$im_cod; ?>'"> */
?>
	  <input class=campo type="submit" value="Documentos" name="documentos" onClick="formulario.action='cadastro_docs.php?cod_imob=<?=$im_cod; ?>'">
	  <input class=campo type="submit" value="Usuário Imobiliária" name="inserir" onClick="formulario.action='p_usuariosi.php?cod_imob=<?=$im_cod; ?>'">
	  <input class=campo type="button" value="Editar Site Padrão" onClick="location.href='p_sites_imobiliarias.php?im_cod=<?=$im_cod?>&edit=editar&lista=1&pasta=<?=$pasta_imobiliaria?>'"></td>
    </tr>
    <tr>
      <td colspan="2">
      <p align="center"><a href="javascript:history.back()" class=style2><< Voltar <<</a></p></td>
    </tr>
  </table>
  </td>
  <td width="30%" valign="top"><table border="0" cellspacing="1" width="100%" bgcolor="#<?php print("$cor3"); ?>">
  		<tr bgcolor="#<?php print("$cor3"); ?>">
  			<td align="center"><b>Informações</b></td>
  		</tr>
  		<tr bgcolor="#<?php print("$cor1"); ?>">
  			<td class=style2><b>Cliques: <?php print("$not2[im_clicks]"); ?></b><br>
  				<span class=style9>Número de vezes que foi clicado no link para o site da imobiliária.</span></td>
  		</tr>
  	</table>
  </td>
</tr>
</table>

  </form>
<?php
	}
	}
	}
mysql_close($con);
?>
<?php
	}
?>
<?php
include("carimbo.php");
//mysql_close($con);
?>
</td></tr></table>
</body>
</html>