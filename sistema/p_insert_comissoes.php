<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<html>
<head>
<?php
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
?>
<script type="text/javascript" src="funcoes/js.js"></script>
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<script language="javascript">
function confirmaExclusao(id)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='p_insert_comissoes.php?id_excluir=' + id;
}
    
function VerificaCampo()
{

var msg = '';

	   if(document.form1.indicador.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Indicador.\n";
       }
	   if(document.form1.vendedor.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Vendedor.\n";
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

	   if(document.form1.indicador.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Indicador.\n";
       }
	   if(document.form1.vendedor.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Vendedor.\n";
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
  if(!empty($_POST['indicador']) && !empty($_POST['vendedor']))
  {
   		$msgErro = "";
		   
		$indicador = $_POST['indicador'];
   		$vendedor = $_POST['vendedor'];
   		$data_comissao = date("Y-m-d");
   		$hora_comissao = date("H:i:s");
   		
   		$SQL = "SELECT indicador, vendedor FROM comissoes WHERE indicador='".$indicador."' AND vendedor='".$vendedor."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Essa comissão para vendedor e indicador já está cadastrada!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"p_insert_comissoes.php\";</script>"; 
		}
		else
		{
 			$inserir = "INSERT INTO comissoes (cod_imobiliaria, indicador, vendedor, data_comissao, hora_comissao) VALUES ('".$_SESSION['cod_imobiliaria']."','".$indicador."','".$vendedor."','".$data_comissao."','".$hora_comissao."')";   			
			 if(mysql_query($inserir, $con))
   			{
   		    	echo('<script language="javascript">alert("Comissão cadastrada com sucesso!");document.location.href="p_insert_comissoes.php";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="p_insert_comissoes.php";</script>');
   			}
   		}
  }
  else
  {
        echo('<script language="javascript">alert("Por favor, não deixe nenhum campo vazio!");document.location.href="p_insert_comissoes.php";</script>');
  }
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT id_comissao, indicador, vendedor FROM comissoes WHERE id_comissao='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_comissao = $linha['id_comissao'];
       $indicador = $linha['indicador'];
       $vendedor = $linha['vendedor'];
    }
}

if($_POST['altera']=='1')
{
  if(!empty($_POST['indicador']) && !empty($_POST['vendedor']))
  {
   		$indicador = $_POST['indicador'];
   		$vendedor = $_POST['vendedor'];
   		$id_comissao = $_POST['id_comissao'];
   		$data_comissao = date("Y-m-d");
   		$hora_comissao = date("H:i:s");

   		$atualizacao = "UPDATE comissoes SET indicador='".$indicador."', vendedor='".$vendedor."',data_comissao='".$data_comissao."',hora_comissao='".$hora_comissao."' WHERE id_comissao='".$id_comissao."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		if(mysql_query($atualizacao, $con))
   		{
   		    echo('<script language="javascript">alert("Comissão alterada com sucesso!");document.location.href="p_insert_comissoes.php";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="p_insert_comissoes.php";</script>');
   		}
  }
  else
  {
        echo('<script language="javascript">alert("Por favor, não deixe nenhum campo vazio!");document.location.href="cadastro_facilidades.php";</script>');
  }
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
   		$exclusao = "DELETE FROM comissoes WHERE id_comissao='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao, $con))
   		{
   		    echo('<script language="javascript">alert("Comissão excluída com sucesso!");document.location.href="p_insert_comissoes.php";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="p_insert_comissoes.php";</script>');
   		}
}

?>
<p align="center"><font color="Blue" size="2" face="Arial"><b>Inserir Comiss&atilde;o </b></p>
<form method="post" name="form1" id="form1" action="<?php print("$PHP_SELF"); ?>">
<input type="hidden" name="id_comissao" id="id_comissao" value="<? echo($id_comissao); ?>">
  <table width="600" border="0" align="center" cellspacing="1">
    <tr>
      <td width="14%" class=style2><b>Indicador:</b></td>
      <td width="86%" class=style2><input type="text" name="indicador" id="indicador" size="5" value="<? if(!empty($indicador)) echo($indicador); ?>" onKeyPress="return validarCampoNumerico(event);" class="campo"></td>
    </tr>
    <tr>
      <td width="14%" class=style2><b>Vendedor:</b></td>
      <td width="86%" class=style2> <input type="text" name="vendedor" id="vendedor" size="5" value="<? if(!empty($vendedor)) echo($vendedor); ?>" onKeyPress="return validarCampoNumerico(event);" class="campo"></td>
    </tr>   
    <tr>
      <td colspan="2">
      <? 
	  	if(empty($id_comissao))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"reset\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='p_insert_comissoes.php'\">
		  ");		
        } 
	  ?>
	  </td>
    </tr>
  </table>
  <tr bgcolor="#<?php print("$cor1"); ?>">
      <td colspan="2"><table width="600" border="0" align="center" cellpadding="1" cellspacing="1">
        <tr>
          <td colspan="5" class="TdTitulo">Comiss&otilde;es</td>
        </tr>
        <tr>
          <td width="19%" class="TdSubTitulo">Indicador</td>
          <td width="25%" class="TdSubTitulo">Vendedor</td>
		  <td width="30%" class="TdSubTitulo">Data</td>
		  <td width="14%" class="TdSubTitulo">Alteração</td>
		  <td width="12%" class="TdSubTitulo">Exclusão</td>
        </tr>
		<?
	    $busca = mysql_query("SELECT id_comissao, indicador, vendedor, data_comissao, hora_comissao FROM comissoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY data_comissao ASC");
     		if(mysql_num_rows($busca) > 0){
	 			while($linha = mysql_fetch_array($busca)){
       				echo('
	        			<tr>
            				<td class="style2">'.$linha['indicador'].'</td>
            				<td class="style2">'.$linha['vendedor'].'</div></td>
            				<td class="style2">'.formataDataDoBd($linha['data_comissao']).' - '.$linha['hora_comissao'].'</div></td>
            				<td class="style2"><div align="center"><a href="p_insert_comissoes.php?id='.$linha['id_comissao'].'">Alterar</a></div></td>
            				<td class="style2"><div align="center"><a href="javascript:confirmaExclusao('.$linha['id_comissao'].')">Excluir</a></div></td>
            			</tr>
	   				');
     			}
     		}
     		else
     		{
	       			echo('
	        			<tr>
            				<td colspan="5"><div align="center" class="style2"><b>Nenhum registro encontrado!</b></div></td>
            			</tr>');
            }	
		?>
		<tr><td colspan="5">&nbsp;</td></tr>
      </table></td>
    </tr>
</form>
<?php
mysql_close($con);
/*
	}
	else
	{
*/	  
?>
<!--Área protegida!-->
<?php
//	}
?>
</body>
</html>