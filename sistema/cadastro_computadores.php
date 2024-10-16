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
verificaAcesso();
verificaArea("GERAL_COMP");

?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(id)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='cadastro_computadores.php?id_excluir=' + id
}



function VerificaCampo()
{

var msg = '';

       if(document.form1.nome.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome do computador.\n";
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

       if(document.form1.nome.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome do computador.\n";
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

function geraCodigoComputador() {
	$_letras	=	"ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$_numeros	=	"0123456789";
	do {
		$_codigo 	=	substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1);
		$SQL = "SELECT * FROM computador WHERE computador_codigo = '".$_codigo."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$statement = mysql_query($SQL);
	} while (mysql_num_rows($statement) == 1);
	return $_codigo;
}
function geraCookie() {
	$_letras	=	"ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$_numeros	=	"0123456789";
	do {
		$_codigo 	=	substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).
						substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).
						substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).
						substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1);
		$SQL = "SELECT * FROM computador WHERE computador_cookie = '".$_codigo."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$statement = mysql_query($SQL);
	} while (mysql_num_rows($statement) == 1);
	return $_codigo;
}

if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		$nome = $_POST['nome'];
   		
   		$SQL = "SELECT computador_nome FROM computador WHERE computador_nome='".$nome."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe um computador com o nome cadastrado!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"cadastro_computadores.php\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO computador (cod_imobiliaria, computador_nome, computador_codigo, computador_cookie, computador_ativo) 
								VALUES 
									('".$_SESSION['cod_imobiliaria']."',
									'".$nome."', 
									'".geraCodigoComputador()."', 
									'".geraCookie()."', 
									'1')";
   			if(mysql_query($inserir))
			{
				echo('<script language="javascript">alert("Cadastro efetuado com sucesso!");document.location.href="cadastro_computadores.php";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="cadastro_computadores.php";</script>');
   			}
   		}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT computador_id, computador_nome, computador_codigo, computador_ativo, computador_confirmado FROM computador WHERE computador_id='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $computador_id = $linha['computador_id'];
       $nome = $linha['computador_nome'];
	   $computador_codigo = $linha['computador_codigo'];
	   $computador_ativo = $linha['computador_ativo'];
	   $computador_confirmado = $linha['computador_confirmado'];
	   $MSG1 = "O computador esta Ativo";
	   if (empty($computador_ativo)) $MSG1 = "O computador não esta ativo.";
	   $MSG2 = "Computador iniciado";
	   if (empty($computador_confirmado)) $MSG2 = "O computador ainda não foi iniciado";
    }
}

if($_POST['altera']=='1') {
   			$computador_id = $_POST['computador_id'];
   			$computador_nome = $_POST['computador_nome'];
     
			$atualizacao = "UPDATE computador SET computador_nome='".$nome."' WHERE computador_id='".$computador_id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Cadastro alterado com sucesso!");document.location.href="cadastro_computadores.php";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="cadastro_computadores.php";</script>');
   			}
}

if($_GET['id_excluir']) { 
        $id_excluir = $_GET['id_excluir'];
   		$exclusao = "DELETE FROM computador WHERE computador_id='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Cadastro excluído com sucesso!");document.location.href="cadastro_computadores.php";</script>');
   		} else {
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="cadastro_computadores.php";</script>');
   		}
}
if ($_GET['id_reiniciar']) {
		$_computador_id = $_REQUEST['id_reiniciar'];
		$reinicio = "UPDATE computador SET computador_confirmado=NULL WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND computador_id=".$_computador_id;
   		if(mysql_query($reinicio))
   		{
   		    echo('<script language="javascript">alert("Senha reiniciada com sucesso!");document.location.href="cadastro_computadores.php?id='.$_computador_id.'";</script>');
   		} else {
      		echo('<script language="javascript">alert("Erro ao reiniciar!");document.location.href="cadastro_computadores.php";</script>');
   		}
}
if ($_GET['id_ativar']) {
		$_computador_id = $_REQUEST['id_ativar'];
		$ativar = "UPDATE computador SET computador_ativo=1 WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND computador_id=".$_computador_id;
   		if(mysql_query($ativar))
   		{
   		    echo('<script language="javascript">alert("Computador ativado com sucesso!");document.location.href="cadastro_computadores.php?id='.$_computador_id.'";</script>');
   		} else {
      		echo('<script language="javascript">alert("Erro ao ativar!");document.location.href="cadastro_computadores.php";</script>');
   		}
}
if ($_GET['id_inativar']) {
		$_computador_id = $_REQUEST['id_inativar'];
		$inativar = "UPDATE computador SET computador_ativo=NULL WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND computador_id=".$_computador_id;
   		if(mysql_query($inativar))
   		{
   		    echo('<script language="javascript">alert("Computador inativado com sucesso!");document.location.href="cadastro_computadores.php?id='.$_computador_id.'";</script>');
   		} else {
      		echo('<script language="javascript">alert("Erro ao inativar!");document.location.href="cadastro_computadores.php";</script>');
   		}
}

	  
?>
<form id="form1" name="form1" method="post" action="cadastro_computadores.php">
<input type="hidden" name="computador_id" id="computador_id" value="<? echo($computador_id); ?>">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1"><div align="center"><b>Computadores</b><br />
      </div></td>
    </tr>
    <tr>
      <td class="style1" width="141"></td>
      <td class="style1" width="602"><?=$MSG1?></td>
    </tr>
<? if(!empty($computador_id)){ ?>		
    <tr>
      <td class="style1"><b>Nome do computador:</b></td>
      <td class="style1">
        <input type="text" name="nome" id="nome" size="40" class="campo" value="<? if(!empty($nome)){ echo($nome); } ?>">
      </td>
    </tr>
	<? if (!empty($id)) { ?>
    <tr>
      <td class="style1"><b>Código:</b></td>
      <td class="style1"><?=$computador_codigo?>&nbsp;&nbsp;&nbsp;<?=$MSG2?></td>
    </tr>
	<? } ?>
<? } ?>
    <tr>
      <td>&nbsp;</td>
      <td><? 
      /*
	  	if(empty($computador_id))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
           ");
           if (verificaFuncao("USER_COMP")) { // verifica se pode acessar as areas
          	   //echo("<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">");
           }          		
          	echo("
			  	<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='cadastro_computadores.php'\">
           ");

		}
*/		
		if(!empty($computador_id))
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
           ");
			if (!empty($computador_ativo)) {
		  echo("<input type=\"button\" name=\"Inativar\" id=\"Inativar\" class=\"campo3\" value=\"Inativar\" Onclick=\"window.location.href='cadastro_computadores.php?id_inativar=".$computador_id."'\">");
			} else {
		  echo("<input type=\"button\" name=\"Ativar\" id=\"Ativar\" class=\"campo3\" value=\"Ativar\" Onclick=\"window.location.href='cadastro_computadores.php?id_ativar=".$computador_id."'\">");
			}
		  echo("
				<input type=\"button\" name=\"Reiniciar Senha\" id=\"Reiniciar Senha\" class=\"campo3\" value=\"Reiniciar Senha\" Onclick=\"window.location.href='cadastro_computadores.php?id_reiniciar=".$computador_id."'\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='cadastro_computadores.php'\">
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
             <td width="12%" class="TdSubTitulo"><b>Iniciado?</b></td>
             <td width="38%" class="TdSubTitulo"><b>Nome  Computador </b></td>
             <td width="21%" class="TdSubTitulo"><b>C&oacute;digo</b></td>
             <td width="15%" class="TdSubTitulo"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
             <td width="14%" class="TdSubTitulo"><div align="center"><b>Exclus&atilde;o</b></div></td>
           </tr>
           <?
            $busca2 = mysql_query("SELECT computador_id, computador_confirmado, computador_nome, computador_codigo FROM computador WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY computador_nome ASC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){
					$confirmado_texto = "Sim";
					if ($linha2['computador_confirmado'] == 0) $confirmado_texto = "N&atilde;o";
      				echo('
	        			<tr>
            				<td class="style1">'.$confirmado_texto.'</td>
            				<td class="style1">'.$linha2['computador_nome'].'</td>
							<td class="style1">'.$linha2['computador_codigo'].'</td>
            				<td class="style1"><div align="center"><a href="cadastro_computadores.php?id='.$linha2['computador_id'].'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['computador_id'].')" class="style1">Excluir</a></div></td>
            			</tr>
	   				');
    			}
  			}
  			else
    		{
	       		echo('
	        		<tr>
            			<td colspan="5" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
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
