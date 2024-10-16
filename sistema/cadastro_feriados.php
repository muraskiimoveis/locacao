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
verificaArea("GERAL_FERIAD");
include("style.php");
?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(id,cod)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='cadastro_feriados.php?id_excluir=' + id
}



function VerificaCampo()
{

var msg = '';

	   if(document.form1.data_feriado.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data do feriado.\n";
       }
       if(document.form1.nome.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome do feriado.\n";
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

	   if(document.form1.data_feriado.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data do feriado.\n";
       }
       if(document.form1.nome.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome do feriado.\n";
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
</script>
</head>

<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/

if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		
   		list($dia, $mes) = explode("/", $_POST['data_feriado']);
   		$nome = $_POST['nome'];
   		
   		$SQL = "SELECT dia, mes FROM feriados WHERE dia='".$dia."' AND mes='".$mes."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe essa data de feriado cadastrada!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"cadastro_feriados.php\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO feriados (cod_imobiliaria, dia, mes, nome) VALUES ('".$_SESSION['cod_imobiliaria']."','".$dia."','".$mes."','".$nome."')";   		
   			if(mysql_query($inserir))
			{
				echo('<script language="javascript">alert("Cadastro efetuado com sucesso!");document.location.href="cadastro_feriados.php";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="cadastro_feriados.php";</script>');
   			}
   		}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT id_feriado, dia, mes, nome FROM feriados WHERE id_feriado='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_feriado = $linha['id_feriado'];
       $data_feriado = $linha['dia']."/".$linha['mes'];
       $nome = $linha['nome'];
    }
}

if($_POST['altera']=='1')
{
   			list($dia, $mes) = explode("/", $_POST['data_feriado']);
   			$id_feriado = $_POST['id_feriado'];
   			$nome = $_POST['nome'];
     
			$atualizacao = "UPDATE feriados SET dia='".$dia."', mes='".$mes."', nome='".$nome."' WHERE id_feriado='".$id_feriado."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Cadastro alterado com sucesso!");document.location.href="cadastro_feriados.php";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="cadastro_feriados.php";</script>');
   			}
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
   		$exclusao = "DELETE FROM feriados WHERE id_feriado='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Cadastro excluído com sucesso!");document.location.href="cadastro_feriados.php";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="cadastro_feriados.php";</script>');
   		}
}
	  
?>
<form id="form1" name="form1" method="post" action="cadastro_feriados.php">
<input type="hidden" name="id_feriado" id="id_feriado" value="<? echo($id_feriado); ?>">
  <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><p align="center"><b>Inserir Feriados</b></p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Data do feriado:</b></td>
      <td width="80%" class="style1">
        <input type="text" name="data_feriado" id="data_feriado" size="5" maxlength="5" class="campo" value="<? if(!empty($data_feriado)){ echo($data_feriado); } ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_feriado', '##/##', event);">
        DD/MM
      </td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Nome do feriado:</b></td>
      <td class="style1">
        <input type="text" name="nome" id="nome" size="40" class="campo" value="<? if(!empty($nome)){ echo($nome); } ?>">
      </td>
    </tr>	
    <tr>
      <td colspan="2"><? 
	  	if(empty($id_feriado))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='cadastro_feriados.php'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='cadastro_feriados.php'\">
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
          <td width="12%" class="style1"><b>Dia / M&ecirc;s</b></td>
          <td width="36%" class="style1"><b>Nome do feriado </b></td>
          <td width="26%" class="style1"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
          <td width="26%" class="style1"><div align="center"><b>Exclus&atilde;o</b></div></td>
        </tr>
        <?
            $busca2 = mysql_query("SELECT id_feriado, dia, mes, nome FROM feriados WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY mes ASC");
     		if(mysql_num_rows($busca2) > 0){
     		  	$i = 0;
	 			while($linha2 = mysql_fetch_array($busca2)){
	 			  
	 			  if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		  		  $i++;	 

      				echo('
	        			<tr class="'.$fundo.'">
            				<td class="style1">'.$linha2['dia'].'/'.$linha2['mes'].'</td>
            				<td class="style1">'.$linha2['nome'].'</td>
            				<td class="style1"><div align="center"><a href="cadastro_feriados.php?id='.$linha2['id_feriado'].'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['id_feriado'].')" class="style1">Excluir</a></div></td>
            			</tr>
	   				');
    			}
  			}
  			else
    		{
	       		echo('
	        		<tr>
            			<td colspan="6" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            		</tr>
	   			');
			}
       ?>
      </table></td>
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