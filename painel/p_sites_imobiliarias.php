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
<?
if ($edit == "editar") {
?>

<? /** <script type="text/javascript" src="tiny_mce/file_browser.js"></script> /**/ ?>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript">
function FileBrowser (field_name, url, type, win) {

      tinyMCE.activeEditor.windowManager.open({
        file : 'p_img_editor.php?pasta=<?=$pasta?>',
        title : 'My File Browser',
        width : 750,
        height : 400,
        resizable : "no",
        inline : "yes",
        close_previous : "no"
    }, {
        window : win,
        input : field_name
    });
    return false;
  }

	tinyMCE.init({
		height : "400",
		mode : "exact",
		language : "pt",
		elements : "im_site_institucional",
		theme : "advanced",
		plugins : "safari,pagebreak,layer,table,style,advhr,advimage,advlink,emotions,inlinepopups,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras   ,template,wordcount,youtube",
		theme_advanced_buttons1 : "cut,|,copy,paste,pastetext,pasteword,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleprops,|,formatselect,fontselect,fontsizeselect,|,preview,|,code,|,help",
		theme_advanced_buttons2 : "search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,|,insertdate,inserttime,|,forecolor,backcolor,|,charmap,emotions,media,advhr,|,ltr,rtl,|,sub,sup,|,youtube",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,insertlayer,moveforward,movebackward,absolute,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		forced_root_block : false,
	   force_br_newlines : true,
      force_p_newlines : false,
		relative_urls : false,
		convert_urls : true,
		remove_script_host : false,
	   file_browser_callback : 'FileBrowser'
	});
</script>
<?
}
?>

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
   d = document.formulario;
   if (d.im_site_fundo.value == "") {
      alert ("A cor do fundo deve ser preenchida");
      return false;
   }
   if (d.im_site_titulo_lateral.value == "") {
      alert ("A cor do título lateral deve ser preenchida");
      return false;
   }
   if (d.im_site_titulo_interno.value == "") {
      alert ("A cor do título interno deve ser preenchida");
      return false;
   }
   if (d.im_site_referencia_interna.value == "") {
      alert ("A cor da referência deve ser preenchida");
      return false;
   }
   if (d.im_site_resumo.value == "") {
      alert ("A cor dos resumos deve ser preenchida");
      return false;
   }
   d.submit();
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
   $pw_result = mysql_query($pw_query,$con) or die("Não foi possivel inserir suas informações");
   $pw_rows = mysql_num_rows($pw_result);
   if ($pw_rows == 0) {

      $query0 = "select im_nome from rebri_imobiliarias where im_nome='$im_nome'";
      $result0 = mysql_query($query0,$con) or die("Não foi possível pesquisar suas informações. $query0");
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
            , im_bairro, im_cep, im_email, im_senha, im_site, im_site_padrao
            , im_disponibilizar, im_desativar, im_img, im_desc, im_desde
            , nome_pasta, contrato_venda, contrato_locacao, im_site_institucional
            , im_site_fundo
            , im_site_titulo_lateral, im_site_rodape, im_site_titulo_interno
            , im_site_referencia_interna, im_site_resumo, im_img_topo_site
            , im_img_fundo_topo) values('$nome_imob'
            , '$im_contato', '$im_resp', '$im_creci_resp', '$im_nacionalidade'
            , '$im_est_civil', '$im_n_conselho', '$im_cnpj', '$im_banco'
            , '$im_agencia', '$im_conta', '$im_tel', '$im_fax', '$im_cel'
            , '$im_cidade', '$im_estado', '$im_end', '$im_end2', '$end_igual'
            , '$im_end_mapa', '$end_igual2', '$im_end_mapa2', '$im_bairro2'
            , '$im_cep2', '$im_tel2', '$im_email2', '$im_bairro', '$im_cep'
            , '$im_email', '$im_senha', '$im_site', '$_POST[im_site_padrao]'
            , '$im_disponibilizar', '$im_desativar', '$im_img', '$im_desc'
            , current_date, '$nome_pasta', '$contrato_venda', '$contrato_locacao'
            , '$im_site_institucional', '$im_site_fundo', '$im_site_titulo_lateral'
            , '$im_site_rodape', '$im_site_titulo_interno', '$im_site_referencia_interna'
            , '$im_site_resumo', '$im_img_topo_site', '$im_img_fundo_topo')";
         $result = mysql_query($query,$con) or die("Não foi possível inserir suas informações.($query)");
         $cod_imob = mysql_insert_id();
         $senha = md5($im_senha);

         //insere documentos
         $query22 = "select * from docs_padrao";
         $result22 = mysql_query($query22,$con) or die("Não foi possível pesquisar suas informações.($query22)");
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
            mysql_query($query99,$con) or die("Não foi possível pesquisar suas informações.($query99)");

         }

		 $u_cookie = md5($im_email.$senha);
         //insere na tabelas de usuarios
         $query01 = "INSERT INTO usuarios (cod_imobiliaria,u_nome,u_email,u_senha,u_tipo, u_status, u_cookie) VALUES('".$cod_imob."','".$nome_imob."','".$im_email."','".$senha."','admin','Ativo','$u_cookie')";
         mysql_query($query01,$con) or die("Não foi possível pesquisar suas informações.");
         $tmp_cod = mysql_insert_id();

         //insere na tabela com todas as permissoes nas areas cadastradas
         $query02 = "select * from area";
         $result02 = mysql_query($query02,$con) or die("Não foi possível pesquisar suas informações.");
         $numrows = mysql_num_rows($result02);
         while($not0 = mysql_fetch_array($result02)) {
            $area_id = $not0['area_id'];
            $query10 = "INSERT INTO rel_area_usuario (area_id,u_cod, cod_imobiliaria)
               VALUES ('".$area_id."','".$tmp_cod."','".$cod_imob."')";
            mysql_query($query10,$con) or die("Não foi possível pesquisar suas informações.");
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
      $statement = mysql_query($SQL,$con) or die ("erro 549");
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
      $statement = mysql_query($SQL,$con) or die ("erro 575");
   } while (mysql_num_rows($statement) == 1);
   return $_codigo;
}

$inserir = "INSERT INTO computador (cod_imobiliaria, computador_nome, computador_codigo,
   computador_cookie, computador_ativo) VALUES ('" . $cod_imob . "','" . $nome_imob
   . "', '" . geraCodigoComputador() . "', '" . geraCookie() . "', '1')";
mysql_query($inserir,$con) or die("Não foi possível pesquisar suas informações.");

		//controle
        $inserir_controle = "INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$cod_imob."','".$u_cod."','Cadastrar Imobiliária',current_date,current_time)";
   		mysql_query($inserir_controle,$con) or die ("Erro 604 - ".mysql_error());

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
	$result4 = mysql_query($query4,$con) or die ("erro 662");
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
	$result = mysql_query($query,$con) or die("Não foi possível apagar suas informações. $query");

	$query = "delete from rebri_imagens where img_imob = '$im_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível apagar suas informações. $query");

	//busca o nome da pasta
	$busca = "SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$im_cod."'";
    $sql = mysql_query($busca,$con) or die ("erro 700");
    while($linha = mysql_fetch_array($sql)){
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
	//$result33 = mysql_query($query33,$con) or die("Não foi possível apagar suas informações. $query33");

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
 	     && mysql_tablename($resultado_tabelas, $i) <> 'rebri_tipo_comercio') {
      $tables = mysql_tablename($resultado_tabelas, $i);
      $queryA = "delete from $tables where cod_imobiliaria = '$im_cod'";  
      $resultA = mysql_query($queryA,$con) or die("Não foi possível apagar suas informações. $queryA");
	  $queryA2 = "delete from atualizacao_historico where ah_imobiliaria = '$im_cod'";  
      $resultA2 = mysql_query($queryA2,$con) or die("Não foi possível apagar suas informações. $queryA2");
	  $queryA3 = "delete from atualiza_imoveis where a_imobiliaria = '$im_cod'";
      $resultA3 = mysql_query($queryA3,$con) or die("Não foi possível apagar suas informações. $queryA3");
      $queryA4 = "delete from m_clientes where cl_imobiliaria = '$im_cod'";
      $resultA4 = mysql_query($queryA4,$con) or die("Não foi possível apagar suas informações. $queryA4");
      $queryA5 = "delete from rebri_imagens where img_imob = '$im_cod'";
      $resultA5 = mysql_query($queryA5,$con) or die("Não foi possível apagar suas informações. $queryA5");
      $queryA6 = "delete from rebri_rebri_imagens where img_imob = '$im_cod'";  
      $resultA6 = mysql_query($queryA6,$con) or die("Não foi possível apagar suas informações. $queryA6");
      $queryA7 = "delete from stats where s_imobiliaria  = '$im_cod'";
      $resultA7 = mysql_query($queryA7,$con) or die("Não foi possível apagar suas informações. $queryA7");
      

	}
	}
	$query = "delete from rebri_imobiliarias where im_cod = '$im_cod'";
	$result = mysql_query($query,$con) or die("Não foi possível apagar suas informações. $query");

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
	$pw_result = mysql_query($pw_query,$con) or die("Não foi possivel inserir suas informações");
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
	$busca = "SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$im_cod."'";
    $sql = mysql_query($busca,$con) or die ("erro 1039");
    while($linha = mysql_fetch_array($sql)){
         $pasta = $linha['nome_pasta'];
    }

	// cria nova pasta
	$dirp = "../imobiliarias/".$nome_pasta;
	rename("../imobiliarias/".$pasta, $dirp);
	}

    if(substr($_POST['im_site'] ,0, 7) <> 'http://'){
  	    	        $im_site = 'http://'.$_POST['im_site'];
  	            }else{
		   	        $im_site = $_POST['im_site'];
	            }


   $at_sql = "SELECT ft_foto FROM rebri_fotos_temp WHERE ft_user = '".$_SESSION['usu_cod']."' AND ft_foto <> '' ORDER BY ft_foto";
   $at_rs = mysql_query($at_sql,$con) or die ("Erro 1059");
   $imagens = "";
   while ($at_not = mysql_fetch_assoc($at_rs)) {
      $imagens .= "|".$at_not[ft_foto]."|";
   }

	if ($nome_imob <> $_POST['im_nome']) {

		$query = "UPDATE rebri_imobiliarias set im_site_institucional='$im_site_institucional'
         , im_site_fundo = '$im_site_fundo', im_site_titulo_lateral='$im_site_titulo_lateral'
         , im_site_rodape='$im_site_rodape', im_site_titulo_interno='$im_site_titulo_interno'
         , im_site_referencia_interna='$im_site_referencia_interna', im_site_resumo='$im_site_resumo'
         , im_img_topo_site='$im_img_topo_site', im_img_fundo_topo='$im_img_fundo_topo', im_imagens_institucional='$imagens'
         where im_cod='$im_cod'";
		$result = mysql_query($query,$con) or die("Não foi possível atualizar suas informações. $query");

	} else {

      $query = "UPDATE rebri_imobiliarias set im_site_fundo = '$im_site_fundo'
         , im_site_titulo_lateral='$im_site_titulo_lateral', im_site_rodape='$im_site_rodape'
         , im_site_institucional='$im_site_institucional', im_site_titulo_interno='$im_site_titulo_interno'
         , im_site_referencia_interna='$im_site_referencia_interna', im_site_resumo='$im_site_resumo'
         , im_img_topo_site='$im_img_topo_site', im_img_fundo_topo='$im_img_fundo_topo', im_imagens_institucional='$imagens'
         where im_cod='$im_cod'";
		$result = mysql_query($query,$con) or die("Não foi possível atualizar suas informações. $query");

	}

	//controle
    $inserir_controle = "INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_acao, a_data, a_hora) VALUES ('".$im_cod."','".$u_cod."','Atualizar Imobiliária',current_date,current_time)";
   	mysql_query($inserir_controle,$con) or die ("Erro 604 - ".mysql_error());

?>
<table height="300" width="100%"><tr><td>

<p align="center">
Você atualizou o site padrão.</p>

<p align="center">
<a href="p_imobiliarias.php?im_cod=<?=$im_cod?>&edit=editar&lista=1" class="style1"><strong>Voltar</strong></a></p>

</td></tr></table>
<?php

	}else{
	  echo ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");document.location.href="p_imobiliarias.php";</script>');
	}

}
if ($lista == "1") {

################################################################################

	if($edit == "editar"){
	$query2 = "select *, (select ci_nome from rebri_cidades where ci_cod=im_cidade) as cidade_nome from rebri_imobiliarias where im_cod = '$im_cod'";
	$result2 = mysql_query($query2,$con) or die ("erro 1112");
	while($not2 = mysql_fetch_array($result2))
	{
	$ano1 = substr ($not2[im_nasc], 0, 4);
	$mes1 = substr($not2[im_nasc], 5, 2 );
	$dia1 = substr ($not2[im_nasc], 8, 2 );

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
  <form method="post" name="formulario" action="<?=$PHP_SELF?>">
    	<table>
	<tr>
		<td>

  <input type="hidden" name="editar" value="1">
  <input type="hidden" name="atualiza" id="atualiza" value="1">
  <input type="hidden" value="<?php print($not2[im_cod]); ?>" name="im_cod">

  <table border="0" cellspacing="1" width="850">
    <tr>
      <td width="20%" class=style2>Imobiliária:</td>
      <td width="80%" class=style2><?=$not2[im_cod]?> - <?=$not2[im_nome]?></td>
    </tr>
    <tr>
      <td colspan="2" class=style2 valign="top" height=10></td>
    </tr>
<script type="text/javascript" src="jscolor/jscolor.js"></script>
    <tr>
      <td colspan="2" class=style2 valign="top"><strong>Dados do Site Padrão:</strong> </td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Institucional: </td>
      <td width="60%" class=style2>
         <textarea name="im_site_institucional" class="campo"><?=$not2[im_site_institucional]?></textarea>
      </td>
    </tr>
<?
      include_once "conect.php";
      $queryde = "delete from rebri_fotos_temp where ft_user = '".$_SESSION['usu_cod']."'";
      $resultde = mysql_query($queryde,$con) or die ("Erro 1204");
      $img_temp = explode("||",$not2[im_imagens_institucional]);
      $img_temp = str_replace("|","",$img_temp);
      foreach ($img_temp as $temp) {
         if ($temp <> "") {
         	$inserir = "INSERT INTO rebri_fotos_temp SET ft_user = '".$_SESSION['usu_cod']."', ft_foto = '$temp', ft_data = CURRENT_DATE, ft_hora = CURRENT_TIME";
            mysql_query($inserir,$con) or die ("Erro 1202");
         }
      }
?>
    <tr>
      <td width="20%" class="style2" align="left" valign="top">Imagens Institucional:</td>
      <td width="80%" class="style2" align="left">
<?
/**      	<input type="button" value="Selecionar Fotos" class="campo" onclick="window.open('p_img_not.php?origem=foto', 'janela', 'height=500,width=800,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br> /**/
?>
      <IFRAME name=fotos_temp marginWidth=0 marginHeight=0 src="fotos_temp.php?pasta=<?=$pasta?>" frameBorder=0 width=725 scrolling=yes height=270 topmargin="0" leftmargin="0"></IFRAME>
      <!--Obs.: Clique e selecione a imagem desejada.--></td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Fundo do Topo: </td>
      <td width="60%" class=style2><input class="color {required:false}" <? if ($not2[im_site_fundo] <> "") { echo 'style="background-color: #'.$not2[im_site_fundo] .'"'; } ?> type="text" size="6" maxlength="6" name="im_site_fundo" value="<?=$not2[im_site_fundo]?>" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Titulo Lateral: </td>
      <td width="60%" class=style2><input class="color {required:false}" <? if ($not2[im_site_titulo_lateral] <> "") { echo 'style="background-color: #'.$not2[im_site_titulo_lateral] .'"'; } ?> type="text" size="6" maxlength="6" name="im_site_titulo_lateral" value="<?=$not2[im_site_titulo_lateral]?>" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Título Interno: </td>
      <td width="60%" class=style2><input class="color {required:false}" type="text" size="6" maxlength="6" name="im_site_titulo_interno" value="<?=$not2[im_site_titulo_interno]?>" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
<? /*
    <tr>
      <td width="40%" class=style2 valign="top">Referência Interna: </td>
      <td width="60%" class=style2><input class="color {required:false}" type="text" size="6" maxlength="6" name="im_site_referencia_interna" value="<?=$not2[im_site_referencia_interna]?>" /> Ex: "FFFFFF"</td>
    </tr>
<?/**/ ?>
    <tr>
      <td width="40%" class=style2 valign="top">Referência Interna: </td>
      <td width="60%" class=style2><input class="color {required:false}" type="text" size="6" maxlength="6" name="im_site_referencia_interna" value="<?=$not2[im_site_referencia_interna]?>" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Resumo: </td>
      <td width="60%" class=style2><input class="color {required:false}" type="text" size="6" maxlength="6" name="im_site_resumo" value="<?=$not2[im_site_resumo]?>" class="campo" /> Ex: "FFFFFF"</td>
    </tr>
    <tr>
      <td width="40%" class=style2 valign="top">Rodapé: </td>
      <td width="60%" class=style2>
         <select name="im_site_rodape" class="campo">
            <option value="FFFFFF" <? if ($not2[im_site_rodape] == "FFFFFF") { print "SELECTED='SELECTED'"; } ?>>Letras Brancas</option>
            <option value="000000" <? if ($not2[im_site_rodape] <> "FFFFFF") { print "SELECTED='SELECTED'"; } ?>>Letras Pretas</option>
         </select>
      </td>
    </tr>

<?
$caminho_institucional = "../imobiliarias/".$pasta."/institucional";
if (!file_exists($caminho_institucional)) {
   mkdir($caminho_institucional, 0777);
   chmod($caminho_institucional, 0777);
}
$caminho_logo = $caminho_institucional."/logo/";
if (!file_exists($caminho_logo)) {
   mkdir($caminho_logo, 0777);
   chmod($caminho_logo, 0777);
}
?>

    <tr>
      <td width="20%" class=style2 valign="top">Logo do site:</td>
      <td width="80%" class=style2> <input type="text" name="im_img_topo_site" id="im_img_topo_site" size="20" class="campo" value="<?php if($_POST['im_img_topo_site']) { print($_POST['im_img_topo_site']); }else{ print($im_img_topo_site); } ?>">
      	<input type="button" value="Selecionar" class="campo" onClick="window.open('p_img_logo.php?status=t&pasta=<?=$pasta?>', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"> Tamanho / Formato obrigatórios (218 x 117) / PNG  <br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.<br><span class="style7"><b>Observação:</b> Se nenhuma imagem for enviada, será exibida a logo padrão da imobiliária.</span></td>
    </tr>
<?php
	if (file_exists($caminho_logo.$im_img_topo_site) and $im_img_topo_site!='')
	{
?>
    <tr>
      <td width="20%" class=style2 valign="top"></td>
      <td width="80%" class=style2> <img src="<? echo($caminho_logo.$im_img_topo_site); ?>"></td>
    </tr>
<?php
	}

$caminho_fundo = $caminho_institucional."/fundo/";
if (!file_exists($caminho_fundo)) {
   mkdir($caminho_fundo, 0777);
   chmod($caminho_fundo, 0777);
}

?>
    <tr>
      <td width="20%" class=style2 valign="top">Fundo degradê:</td>
      <td width="80%" class=style2> <input type="text" name="im_img_fundo_topo" id="im_img_fundo_topo" size="20" class="campo" value="<?php if($_POST['im_img_fundo_topo']) { print($_POST['im_img_fundo_topo']); }else{ print($im_img_fundo_topo); } ?>">
      	<input type="button" value="Selecionar" class="campo" onClick="window.open('p_img_logo.php?status=f&pasta=<?=$pasta?>', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"> Altura padrão: 116 <br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.<br><span class="style7"><b>Observação:</b> Se nenhuma imagem for enviada, será exibido o fundo na cor padrão escolhida.</span></td>
    </tr>
<?php
	if (file_exists($caminho_fundo . $im_img_fundo_topo) and $im_img_fundo_topo!='')
	{
?>
    <tr>
      <td width="20%" class=style2 valign="top"></td>
      <td width="80%" class=style2><img src="<? echo($caminho_fundo . $im_img_fundo_topo); ?>" height="116" width="250"></td>
    </tr>
<?php
	}
?>
	  <tr>
      <td colspan="5">
      <input class=campo type="button" value="Atualizar" name="B1" Onclick="VerificaCampo();">
</td>
    </tr>
    <tr>
      <td colspan="2">
      <p align="center"><a href="p_imobiliarias.php?im_cod=<?=$im_cod?>&edit=editar&lista=1" class=style2><< Voltar <<</a></p></td>
    </tr>
  </table>
  </td>
</tr>
</table>

  </form>
  </center>
  </div>
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