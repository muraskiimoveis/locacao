<?php
ini_set('max_execution_time','120');
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
include("funcoes/funcoes.php");
include("smtp.class.php");
verificaAcesso();
verificaArea("GERAL_MAILLING");

if($_GET['rel']){
 $rel = $_GET['rel'];
}else{
 $rel = $_POST['rel'];
}


?>
<html>
<head>
<?php
include("style.php");
?>
<?php
	if($enviado == ""){
?>
<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script language="javascript">
      window.onload = function()
      {
        var oFCKeditor = new FCKeditor( 'texto' ) ;
        oFCKeditor.Height = "400"
        oFCKeditor.BasePath = "FCKeditor/" ;
        oFCKeditor.ReplaceTextarea() ;
      }
    </script>
<?php
	}
?>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<?
if($rel<>'S'){ 
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
<?
}
?>
  <?php
	if($enviado == "1"){

		if($texto == ""){
?>
<div align="center" class="style7"><b>Voc&ecirc; esqueceu de preencher algum campo obrigat&oacute;rio!</b><br>
<input type="button" name="voltar" id="voltar" class="campo3 noprint" value="Voltar" OnClick="javascript:history.back();"></div>
<br>
<?php
		}else{
			session_register("enviado");
		
			// N&uacute;mero de Mensagens enviadas por Blocos,
			$msg_num = 3;

			// Tempo, em segundos, entre os Blocos de E-mail
			$sec = 5;

			$ok = 0;
	
			if(!$_SESSION['inicio']){
				$inicio = 0;
			}else{
				$inicio = $_SESSION['inicio'];
			}

			$fim = $inicio + $msg_num;

			$sql = "SELECT c_cod, c_email, c_nome FROM clientes WHERE c_email!='' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND c_email LIKE '%@%' AND c_email NOT LIKE '% %' AND c_email NOT LIKE '%,%' ORDER BY c_email LIMIT $inicio,$msg_num";
			$query = mysql_query($sql) or die ("erro 84:". mysql_error());
			$registros = mysql_num_rows($query);

			if($registros==0){
        		echo "<div align=\"center\" class=\"style7\"><b>As mensagens foram enviadas com sucesso.</b></div>";
        		$ok = 1;
        		session_unregister("inicio");
        		session_unregister("enviado");
        		session_unregister("t_prod");
        		session_unregister("assunto");
        		session_unregister("texto");
        		session_unregister("email_de");
        		session_unregister("nome_de");
        		session_unregister("total_msg");
    		}else{
    			echo "<div align=\"center\" class=\"style7\"><b>ATEN&Ccedil;&Atilde;O! Aguarde a mensagem de que as mensagens foram enviadas</b></div><br>";
    		}

			while($result = mysql_fetch_array($query))
			{
				$id = $result['c_cod'];
				$para = $result['c_email'];
				$nome_para = $result['c_nome'];
				$total_msg++;

				$texto = stripslashes($texto);
				$body = "<html><body bgcolor=#FFFFFF leftmargin=0 topmargin=0 marginwidth=0 marginheight=0>$texto</body></html>";
				session_register("c_cod");
				session_register("assunto");
				session_register("texto");
				session_register("email_de");
				session_register("nome_de");
				session_register("total_msg");
		
				if($_SERVER['SERVER_NAME'] <> "www.redebrasileiradeimoveis.com.br" AND $_SERVER['SERVER_NAME'] <> "redebrasileiradeimoveis.com.br"){
					// Configuração da classe.smtp.php  
					$host = "smtp.muraski.com"; //host do servidor SMTP 
					$smtp = new Smtp($host);
					$smtp->user = "sistema@muraski.com"; //usuario do servidor SMTP  
					$smtp->pass = "15sist56"; // senha dousuario do servidor SMTP*/ 
					$smtp->debug =true; // ativar a autenticação SMTP*/

					// envia uma mensagem  
					$from = $nome_de . "<" . $email_de . ">"; // seu e-mail 
					$to = $nome_para . " <" . $para . ">"; // o e-mail cadastrado*/ 
					$subject = $assunto; // assunto da mensagem 
					$msg = $body;
					$smtp->Send($to, $from, $subject, $msg);// faz o envio da mensagem 
				}else{
				  	$from = "From: $nome_de <$email_de>\n" . "Return-path: $email_de\n" . "Reply-To: <$email_de>\r\n" . "Mime-Version: 1.0\nContent-Type: text/html; charset=\"iso-8859-1\"\n";
					$to = $nome_para . " <" . $para . ">"; // o e-mail cadastrado*/ 
					$subject = $assunto; // assunto da mensagem 
					$msg = $body;
					mail($to, $subject, $msg, $from);
				}
				
				echo "<div align=\"center\" class=\"style1\">[<b>$total_msg</b>] mensagem para <b>$para</b> enviada com sucesso!</div><br>";

				if(!$ok){
					$inicio = $inicio + $msg_num;
					session_register("inicio");
					echo("<meta http-equiv=\"refresh\" content=\"" . $sec . "\">");
				}
?>
			<table>
<?php
			}
		}
?>
</table>
<?php
	}else{
?>
<script language="javascript">
function valida()
{
  	if(document.form1.nome_de.value=="")
	{
		alert( "Preencha o campo Nome do Remetente!" );
		document.form1.nome_de.focus();
		document.form1.nome_de.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
		document.form1.nome_de.style.backgroundColor = '#FFFFFF';
	}
	
	if(document.form1.email_de.value=="")
	{
		alert( "Preencha o campo E-mail do Remetente!" );
		document.form1.email_de.focus();
		document.form1.email_de.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
		document.form1.email_de.style.backgroundColor = '#FFFFFF';
	}
	
	if(document.form1.assunto.value=="")
	{
		alert( "Preencha o campo Assunto da Mensagem!" );
		document.form1.assunto.focus();
		document.form1.assunto.style.backgroundColor = '#FF727B';
		return false;
	}
	else
	{
		document.form1.assunto.style.backgroundColor = '#FFFFFF';
	}

	return true;
}
</script>

<form method="post" name="form1" action="<?php print("$PHP_SELF"); ?>" onSubmit="return valida();">
<input type="hidden" name="enviado" value="1">
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
  	<tr height="50">
  		<td colspan="2"><p align="center" class="style1"><b>Enviar Mailling</b></p></td>
  	</tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Nome do remetente:</b></td>
      <td width="80%" class="style1"><input type="text" name="nome_de" size="40" value="<? echo $_SESSION['nome_imobiliaria']; ?>" class="campo" readonly></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>E-mail do remetente:</b></td>
      <td width="80%" class="style1"><input type="text" name="email_de" size="40" value="<? echo $_SESSION['email_imo']; ?>" class="campo" readonly></td>
    </tr>
<?
if($_GET['anuncio']<>''){
  	$link_class = "font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: '#000000';";
  	
  	if($_SERVER['SERVER_NAME'] == "www.redebrasileiradeimoveis.com.br" OR $_SERVER['SERVER_NAME'] == "redebrasileiradeimoveis.com.br") { 
		$caminho = "http://www.rebri.com.br/";
	}else{
	  	$caminho = "http://192.168.0.1/web/rebri/";
	}
	$datafo = date("dmY");
	$horafo = date("His");
	  
	$busca_dados = mysql_query("SELECT m.ref, m.titulo, m.finalidade, m.descricao, m.metragem, m.n_quartos, m.suites, m.valor, m.dist_mar, m.dist_tipo, t.t_nome, a.data_anuncio, a.veiculo_anuncio FROM imoveis_anuncio ia INNER JOIN muraski m ON (ia.cod_imovel=m.cod) INNER JOIN anuncios a ON (ia.id_anuncio=a.id_anuncio) INNER JOIN rebri_tipo t ON (t.t_cod=m.tipo) WHERE a.id_anuncio='".$_GET['anuncio']."' AND a.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	
	$texto .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<tr>
    		<td>';
				$logo_imob = $_SESSION['logo_imob'];
    				$caminho_logo = "../logos/";
    				$caminho_logo2 = "logos/";
					if (file_exists($caminho_logo.$logo_imob))
					{
						$texto .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$caminho.$caminho_logo2.$logo_imob.'" border="0">';
					}
	$texto .= '</td>
  		</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">';

	while($linha = mysql_fetch_array($busca_dados)){
		$assunto = "Anúncio de ".formataDataDoBd($linha['data_anuncio']); 
		
         $texto .= '<tr>
     <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="17" height="17" align="left" valign="top"></td>
        <td height="17"></td>
        <td width="17" height="17" align="right" valign="top"></td>
       </tr>';

         $texto .= '<tr>
        <td></td>
        <td align="left" valign="top">
         <table width="100%" border="0" cellpadding="3" cellspacing="0">
          <tr bgcolor="#FFFFFF">
           <td width="350" align="left" valign="top">     
            <table border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
             <tr>';

			if($linha['finalidade']=='8' || $linha['finalidade']=='9' || $linha['finalidade']=='10' || $linha['finalidade']=='11' || $linha['finalidade']=='12' || $linha['finalidade']=='13' || $linha['finalidade']=='14' || $linha['finalidade']=='15' || $linha['finalidade']=='16' || $linha['finalidade']=='17'){ 
				$pasta_finalidade = "locacao";
			}
			else
			{
				$pasta_finalidade = "venda";
			}
			$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
			$pasta2 = "imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";
			
			$nome_foto = $linha[ref] . "_1" . ".jpg";
			
			$controla_tamanho = "";
     		$tam_img = @GetImageSize($pasta.$nome_foto);
     		$rel_larg = $tam_img[0] / 400;
     		$rel_alt = $tam_img[1] / 300;

     		if ($rel_alt > 1 || $rel_larg > 1) {
         		if ($rel_alt > $rel_larg) {
	         		$controla_tamanho = " height='300' ";
         		} else {
	         		$controla_tamanho = " width='400' ";
         		}

     		}
			

if (file_exists($pasta.$nome_foto)){
   $texto .= "<td>";
   
   						if($_SERVER['SERVER_NAME'] == "www.redebrasileiradeimoveis.com.br" OR $_SERVER['SERVER_NAME'] == "redebrasileiradeimoveis.com.br") { 

						 $texto .= '<img border="0" src="'.$caminho.$pasta2.$nome_foto.'?datafo='.$datafo.'&horafo='.$horafo.'" alt="Foto do imóvel ref.: "'.$linha[ref].'" />';					
						

						}else{

						 $texto .= '<img border="0" src="'.$caminho.$pasta2.$nome_foto.'?datafo='.$datafo.'&horafo='.$horafo.'" alt="Foto do imóvel ref.: "'.$linha[ref].'" '.$controla_tamanho.' />'; 		

						}
    
   
   $texto .= "</td>";
} else {
   $texto .= "<td><img src='".$caminho."sistema/images/sem_foto_gr.jpg' border='0' alt='Sem Foto' /></td>";
}

$linha[titulo] = str_replace("\\","",$linha[titulo]);
$linha[titulo] = strip_tags($linha[titulo],"<p><br>");

$linha[descricao] = str_replace("\\","",$linha[descricao]);
$linha[descricao] = strip_tags($linha[descricao]);


$texto .= '</tr>
            </table>
           </td>
           <td align="left" valign="top">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
             <tr>
              <td align="left"><font size="2" color="#cc0000" face="Verdana, Arial, Helvetica, sans-serif">  Ref.: '.$linha[ref].' - '.$linha[t_nome].'</font></td>
             </tr>
             <tr>
              <td align="center"><img src="'.$caminho.'sistema/images/linha_degrade.jpg" width="350" height="11" border=0 alt="." /></td>
             </tr>
             <tr>
              <td align="left"><font size="2" color="#666666" face="Verdana, Arial, Helvetica, sans-serif">  '.$linha[titulo].'</font></td>
             </tr>
             <tr>
              <td align="center"><img src="'.$caminho.'sistema/images/linha_degrade.jpg" width="350" height="11" alt="." /></td>
             </tr>
             <tr>
              <td align="left" valign="top"><font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">  
               Metragem: <strong>'.number_format($linha[metragem],2,",",".").' m²</strong> <br />
               N&deg; de quartos: <strong>'.$linha[n_quartos].'</strong><br />
               Su&iacute;tes: <strong>'.$linha[suites].'</strong><br />
               Valor: <strong>R$ '.number_format($linha[valor],2,",",".").'</strong><br /><br />
               Dist&acirc;ncia do mar: <strong>'.$linha[dist_mar].' '.$linha[dist_tipo].'</strong></font>
              </td>
             </tr>
             <tr>
              <td align="center"><img src="'.$caminho.'sistema/images/linha_degrade.jpg" width="350" height="11" alt="." /></td>
             </tr>
             <tr>
              <td align="left"><font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">  
               '.$linha[descricao].'
              </font></td>
             </tr>
            </table>
           </td>
          </tr>
         </table>
        </td>
        <td></td>
       </tr>
       <tr>
        <td height="17" align="left" valign="bottom"></td>
        <td height="17"></td>
        <td height="17" align="right" valign="bottom"></td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td height="1"><img src="'.$caminho.'sistema/images/linha_degrade.jpg" width="600" height="11" alt="."></td>
    </tr>';
  	}
  	
  	$buscai = mysql_query("SELECT i.im_nome, i.im_end, i.im_bairro, i.im_cep, i.im_tel, i.im_cidade, i.im_estado, i.im_email, i.im_site, ci.ci_nome, e.e_uf FROM rebri_imobiliarias i LEFT JOIN rebri_cidades ci ON (i.im_cidade=ci.ci_cod) LEFT JOIN rebri_estados e ON (i.im_estado=e.e_cod) WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'");
	while($linha = mysql_fetch_array($buscai)){
	  $nomei = $linha['im_nome'];
	  $enderecoi = $linha['im_end'];
	  $telefonei = $linha['im_tel'];
	  $bairroi = $linha['im_bairro'];
	  $cepi = $linha['im_cep'];  
	  $bairroi = $linha['im_bairro'];
	  $cidadei = $linha['ci_nome'];
	  $estadoi = $linha['e_uf'];
	  $sitei = $linha['im_site'];
	  $emaili = $linha['im_email'];
	  
	}
  	
	$texto .=  "</table>
	  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
  		<tr>
    		<td align=\"left\" style=\"".$link_class."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$nomei."</b></td>
  		</tr>
  		<tr>
    		<td align=\"left\" style=\"".$link_class."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Endereço:</b> ".$enderecoi."</td>
  		</tr>";
  		if($telefone <> ''){
$texto .= "<tr>
    		<td align=\"left\" style=\"".$link_class."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Telefone:</b> ".$telefonei."</font></td>
  		</tr>";
  		}
$texto .= "<tr>
    		<td align=\"left\" style=\"".$link_class."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Cidade/UF:</b> ".$cidadei." - ".$estadoi."</td>
  		</tr>";
  		if($bairroi <> '' || $cepi <> ''){
$texto .= "<tr>
    		<td align=\"left\" style=\"".$link_class."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Bairro:</b> ".$bairroi." -  <b>CEP:</b> ".$cepi."</td>
  		</tr>"; 
  		}
$texto .= "<tr>
    		<td align=\"left\" style=\"".$link_class."\" style=\"".$link_class."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Site:</b> <a href=\"".$sitei."\" style=\"".$link_class."\" target=\"_blank\">".$sitei."</a></td>
  		</tr>
  		<tr>
    		<td align=\"left\" style=\"".$link_class."\" style=\"".$link_class."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>E-mail:</b> <a href=\"mailto: ".$emaili."\" style=\"".$link_class."\">".$emaili."</a></td>
  		</tr>
	</table>";
  	
}

?>        
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Assunto:</b></td>
      <td width="80%" class="style1"><input type="text" name="assunto" size="40" class="campo" value="<?=$assunto ?>"></td>
    </tr>
    <tr class="fundoTabela">
    	<td width="20%" valign="top" class="style1"><b>Texto:</b></td>
      	<td width="80%" class="style1"><textarea rows="15" name="texto" cols="70" class="campo"><?=$texto ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" valign="top">&nbsp;</td>
      <td width="80%" class="style7">ATEN&Ccedil;&Atilde;O! Ap&oacute;s clicar para enviar o mailing ser&aacute; necess&aacute;rio esperar o processo terminar para que todos os clientes recebam o e-mail.</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td class="style7"><input type="submit" value="Enviar Mailing" name="B1" class="campo3"></td>
    </tr>
  </table>
</form>
<?php
	}
 	if(session_is_registered("valid_user")){ 
?>
<br>
<?
if($rel<>'S'){ 
?>
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
<?
	}
	 } 
?>
</body>
</html>