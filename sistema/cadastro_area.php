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
//verificaAcesso();
//verificaArea("GER_AREA");

?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(id,cod)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='cadastro_area.php?id_excluir=' + id
}



function VerificaCampo()
{

var msg = '';

	   if(document.form1.area_parametro.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Parâmetro.\n";
       }
       if(document.form1.area_nome.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome da área.\n";
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

	   if(document.form1.area_parametro.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Parametro.\n";
       }
       if(document.form1.area_nome.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome da área.\n";
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
<?php
//	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
//	(($u_tipo == "admin") or ($u_tipo == "func"))){

if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		
   		$nome = $_POST['nome'];
   		
   		$SQL = "SELECT area_parametro FROM area WHERE area_parametro='".$area_parametro."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0) {
			$msgErro .= "Já existe essa área cadastrada!";
		}
		
		if($msgErro != "") {
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"cadastro_area.php\";</script>"; 
		} else {
			$inserir = "INSERT INTO area (area_nome, area_descricao, area_parametro) VALUES ('".$area_nome."','".$area_descricao."','".$area_parametro."')";
   			if(mysql_query($inserir)) {
				echo('<script language="javascript">alert("Cadastro efetuado com sucesso!");document.location.href="cadastro_area.php";</script>');
   			} else {
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="cadastro_area.php";</script>');
   			}
   		}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT * FROM area WHERE area_id='".$id."'");
    while($linha = mysql_fetch_array($alteracao)){
       $area_id = $linha['area_id'];
       $area_nome = $linha['area_nome'];
       $area_descricao = $linha['area_descricao'];
       $area_parametro = $linha['area_parametro'];
    }
}

if($_POST['altera']=='1')
{
   			$area_id = $_POST['area_id'];
   			$area_nome = $_POST['area_nome'];
   			$area_descricao = $_POST['area_descricao'];
   			$area_parametro = $_POST['area_parametro'];
     
			$atualizacao = "UPDATE area SET area_nome='".$area_nome."', area_descricao='".$area_descricao."', area_parametro='".$area_parametro."' WHERE area_id='".$area_id."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Cadastro alterado com sucesso!");document.location.href="cadastro_area.php";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="cadastro_area.php";</script>');
   			}
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
   		$exclusao = "DELETE FROM area WHERE area_id='".$id_excluir."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Cadastro excluído com sucesso!");document.location.href="cadastro_area.php";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="cadastro_area.php";</script>');
   		}
}
	  
?>
<form id="form1" name="form1" method="post" action="cadastro_area.php">
<input type="hidden" name="area_id" id="area_id" value="<? echo($area_id); ?>">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1"><div align="center"><b>Inserir &Aacute;rea </b><br />
      </div></td>
    </tr>
    <tr>
      <td class="style1"><b>Nome da área:</b></td>
      <td class="style1">
        <input type="text" name="area_nome" id="area_nome" size="40" class="campo" value="<? if(!empty($area_nome)){ echo($area_nome); } ?>">
      </td>
    </tr>
    <tr>
      <td class="style1"><b>Descrição:</b></td>
      <td class="style1">
	  	<textarea name="area_descricao" id="area_descricao" rows="5" class="campo"><? if(!empty($area_descricao)){ echo($area_descricao); } ?></textarea>
      </td>
    </tr>
    <tr>
      <td class="style1"><b>Parâmetro:</b></td>
      <td class="style1">
        <input type="text" name="area_parametro" id="area_parametro" size="40" class="campo" value="<? if(!empty($area_parametro)){ echo($area_parametro); } ?>">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><? 
	  	if(empty($area_id))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='cadastro_area.php'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='cadastro_area.php'\">
		  ");		
        } 
	  ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td width="12%" class="TdSubTitulo"><b>Parâmetro</b></td>
          <td width="36%" class="TdSubTitulo"><b>Nome da Área </b></td>
          <td width="26%" class="TdSubTitulo"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
          <td width="26%" class="TdSubTitulo"><div align="center"><b>Exclus&atilde;o</b></div></td>
        </tr>
        <?
            $busca2 = mysql_query("SELECT area_id, area_nome, area_parametro FROM area ORDER BY area_nome ASC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){

      				echo('
	        			<tr>
            				<td class="style1">'.$linha2['area_parametro'].'</td>
            				<td class="style1">'.$linha2['area_nome'].'</td>
            				<td class="style1"><div align="center"><a href="cadastro_area.php?id='.$linha2['area_id'].'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['area_id'].')" class="style1">Excluir</a></div></td>
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
//	}else{
//		include("login2.php");
//	}
?>
</form>
</body>
</html>
