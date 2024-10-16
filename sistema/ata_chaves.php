<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaArea("GERAL_VEND");
verificaArea("GERAL_LOCA");
?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(id,cod,codi)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='ata_chaves.php?id_excluir=' + id + '&cod=' + cod + '&codi=' + codi;

}
function VerificaCampo()
{

var msg = '';

	   if(document.form1.data_ata.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data da devolução prevista.\n";
       }
       if(document.form1.hora_ata.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Hora da devolução prevista.\n";
       }
       if(document.form1.nome_ata.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome.\n";
       }
       if(document.form1.telefone_ata.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Telefone.\n";
       }
       if (document.form1.status_ata.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Status.\n";
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

function VerificaCampo2()
{

var msg = '';

	   if(document.form1.data_ata.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data da devolução prevista.\n";
       }
       if(document.form1.hora_ata.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Hora da devolução prevista.\n";
       }
       if(document.form1.nome_ata.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome.\n";
       }
       if(document.form1.telefone_ata.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Telefone.\n";
       }
       if (document.form1.status_ata.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Status.\n";
	   }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.altera.value='1';
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
//  End -->
</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/

if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}

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

		$busca = mysql_query("SELECT cod, ref, tipo_logradouro, end, numero FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$codi."'");
    	while($linha = mysql_fetch_array($busca)){
       	   $nimovel = $linha['ref']." - ".$linha['tipo_logradouro']." ".$linha['end'].", ".$linha['numero'];
		} 

if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		
		$cod = $_POST['cod'];
		$codi = $_POST['codi'];
		$data_ata = formataDataParaBd($_POST['data_ata']);
		$hora_ata = $_POST['hora_ata'];
		$nome_ata = $_POST['nome_ata'];
		$telefone_ata = $_POST['telefone_ata'];
   		$status_ata = $_POST['status_ata'];
   		   		
   		$SQL = "SELECT id_ata FROM ata_chaves WHERE cod_imovel='".$cod."' AND data_ata='".$data_ata."' AND hora_ata='".$hora_ata.":00' AND nome_ata='".$nome_ata."' AND telefone_ata='".$telefone_ata."' AND status_ata='".$status_ata."' AND cod_imobiliaria='".$codi."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe uma ata cadastrada com esses dados para esse imóvel!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"ata_chaves.php?cod=".$cod."&codi=".$codi."\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO ata_chaves (cod_imobiliaria, cod_imovel, data_ata, hora_ata, nome_ata, telefone_ata, data_status_ata, hora_status_ata, status_ata) VALUES ('".$codi."','".$cod."','".$data_ata."','".$hora_ata."', '".$nome_ata."', '".$telefone_ata."', current_date, current_time, '".$status_ata."')";   		
   			if(mysql_query($inserir))
			{
				echo('<script language="javascript">alert("Ata efetuada com sucesso!");document.location.href="ata_chaves.php?cod='.$cod.'&codi='.$codi.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="ata_chaves.php?cod='.$cod.'&codi='.$codi.'";</script>');
   			}
   		}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT id_ata, data_ata, hora_ata, nome_ata, telefone_ata, status_ata FROM ata_chaves WHERE id_ata='".$id."' AND cod_imobiliaria='".$codi."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_ata = $linha['id_ata'];
       $data_ata = formataDataDoBd($linha['data_ata']);
       $aux = explode (":", $linha['hora_ata']);
       $hora_ata = $aux[0] . ":" . $aux[1];
       $nome_ata = $linha['nome_ata'];
       $telefone_ata = $linha['telefone_ata'];
       $status_ata = $linha['status_ata'];
    }
}

if($_POST['altera']=='1')
{
   			$id_ata = $_POST['id_ata'];
			$cod = $_POST['cod'];
			$codi = $_POST['codi'];
			$data_ata = formataDataParaBd($_POST['data_ata']);
			$hora_ata = $_POST['hora_ata'];
			$nome_ata = $_POST['nome_ata'];
			$telefone_ata = $_POST['telefone_ata'];
   			$status_ata = $_POST['status_ata'];
     
			$atualizacao = "UPDATE ata_chaves SET data_ata='".$data_ata."', hora_ata='".$hora_ata."', nome_ata='".$nome_ata."', telefone_ata='".$telefone_ata."', data_status_ata=current_date, hora_status_ata=current_time, status_ata='".$status_ata."' WHERE id_ata='".$id_ata."' AND cod_imobiliaria='".$codi."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Ata alterada com sucesso!");document.location.href="ata_chaves.php?cod='.$cod.'&codi='.$codi.'";</script>');   			
			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="ata_chaves.php?cod='.$cod.'&codi='.$codi.'";</script>');
   			}
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        $codi = $_GET['codi'];
        
   		$exclusao = "DELETE FROM ata_chaves WHERE id_ata='".$id_excluir."' AND cod_imobiliaria='".$codi."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Ata excluída com sucesso!");document.location.href="ata_chaves.php?cod='.$cod.'&codi='.$codi.'";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="ata_chaves.php?cod='.$cod.'&codi='.$codi.'";</script>');
   		}
}
	  
if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}
$sql = mysql_query("SELECT chaves, controle_chave FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
while($linha = mysql_fetch_array($sql)){
	$chaves = $linha['chaves'];
	$controle_chaves = $linha['controle_chave'];
}
?>
<form id="form1" name="form1" method="post" action="ata_chaves.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="codi" id="codi" value="<?=$codi ?>">
<input type="hidden" name="id_ata" id="id_ata" value="<? echo($id_ata); ?>">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Ata Chaves </b><br />
      </div></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Local Chaves:</b></td>
      <td width="80%" class="style7"><? if($controle_chaves<>'0'){ echo($controle_chaves); } ?> <?=$chaves; ?></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Im&oacute;vel:</b></td>
      <td class="style1"><?=$nimovel?></td>
    </tr>
	<tr class="fundoTabela">
      <td class="style1"><b>Devolução prevista:</b></td>
      <td class="style1"><input type="text" name="data_ata" id="data_ata" size="12" maxlength="10" class="campo" value="<?=$data_ata; ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_ata', '##/##/####', event);" onChange="ValidaData(this.value);return validarCampoNumerico(event);" onKeyUp="return autoTab(this, 10, event);">
        <input type="text" name="hora_ata" id="hora_ata" size="5" maxlength="5" class="campo" value="<?=$hora_ata; ?>" OnKeyPress="javascript:return(Formatar(this,event));" onBlur="validaHora(this.value)"> Ex.: 10/10/2010 10:00</td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Nome:</b></td>
      <td class="style1"><input type="text" name="nome_ata" id="nome_ata" size="40" class="campo" value="<?=$nome_ata; ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Telefone:</b></td>
      <td class="style1"><input type="text" name="telefone_ata" id="telefone_ata" size="13" maxlength="13" class="campo" value="<?=$telefone_ata; ?>" onKeyPress="return txtBoxFormat(document.form1, 'telefone_ata', '(##)####-####', event);return validarCampoNumerico(event);"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Status:</b></td>
      <td class="style1"><select name="status_ata" id="status_ata" class="campo">
        <option value="">Selecione</option>
		<option value="retirado" <? if($status_ata=='retirado'){ echo "SELECTED"; } ?>>Retirado</option>
        <option value="devolvido" <? if($status_ata=='devolvido'){ echo "SELECTED"; } ?>>Devolvido</option>
      </select></td>
    </tr>	
    <tr>
      <td colspan="2"><? 
	  	if(empty($id_ata))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='ata_chaves.php?cod=".$cod."&codi=".$codi."'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='ata_chaves.php?cod=".$cod."&codi=".$codi."'\">
		  ");		
        } 
	  ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr class="fundoTabelaTitulo">
          <td width="20%" class="style1"><b>Devolução prevista</b></td>
          <td width="19%" class="style1"><b>Nome</b></td>
          <td width="10%" class="style1"><b>Telefone</b></td>
          <td width="19%" class="style1"><b>Data/Hora Status </b></td>
          <td width="9%" class="style1"><b>Status</b></td>
          <td width="12%" class="style1"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
          <td width="11%" class="style1"><div align="center"><b>Exclus&atilde;o</b></div></td>
        </tr>
        <?
        	$i = 0;
            $busca2 = mysql_query("SELECT id_ata, data_ata, hora_ata, nome_ata, telefone_ata, data_status_ata, hora_status_ata, status_ata FROM ata_chaves WHERE cod_imovel='".$cod."' AND cod_imobiliaria='".$codi."' ORDER BY data_ata, hora_ata ASC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){
	 			  if ($i++ % 2 == 0) { $fundo = 'fundoTabelaCor1'; } else { $fundo = 'fundoTabelaCor2'; }
	 			  
	 				$aux1 = explode (":", $linha2['hora_ata']);
            		$hora_atab = $aux1[0] . ":" . $aux1[1];

					echo "<tr class=\"$fundo\">";
      				echo('
            				<td class="style1">'.formataDataDoBd($linha2['data_ata']).' '.$hora_atab.'</td>
            				<td class="style1">'.$linha2['nome_ata'].'</td>
            				<td class="style1">'.$linha2['telefone_ata'].'</td>
            				<td class="style1">'.formataDataDoBd($linha2['data_status_ata']).' '.$linha2['hora_status_ata'].'</td>
            				<td class="style1">'.$linha2['status_ata'].'</td>
            				<td class="style1"><div align="center"><a href="ata_chaves.php?id='.$linha2['id_ata'].'&cod='.$cod.'&codi='.$codi.'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['id_ata'].', '.$cod.', '.$codi.')" class="style1">Excluir</a></div></td>
            			</tr>
	   				');
    			}
  			}
  			else
    		{
	       		echo('
	        		<tr>
            			<td colspan="7" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            		</tr>
	   			');
			}
       ?>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
          <br><br><input type="button" name="fechar" id="fechar" class="campo3" value="Fechar Janela" Onclick="window.close();">
      </div></td>
    </tr>
  </table>
<?
mysql_close($con);
/*
	}else{
		include("login2.php");
	}
*/
?>
</form>
</body>
</html>