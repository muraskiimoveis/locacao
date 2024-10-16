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
verificaArea("GERAL_VEND");
?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function confirmaExclusao(id,cod,codi) {
       if(confirm("Tem certeza que deseja desativar esta proposta?"))
          document.location.href='fazer_proposta.php?id_excluir=' + id + '&cod=' + cod + '&codi=' + codi;
}

function VerificaCampo()
{

var msg = '';

	   if(document.formulario.co_cliente.value.length==0)
	   {
	          msg += "Por favor, selecione o campo Cliente.\n";
	   }
	   if(document.formulario.data_proposta.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data Proposta.\n";
       }
	   if(document.formulario.texto_proposta.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Texto.\n";
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.formulario.cadastra.value='1';
			document.formulario.submit();
	   }

}

function VerificaCampo2()
{

var msg = '';

	   if(document.formulario.co_cliente.value.length==0)
	   {
	          msg += "Por favor, selecione o campo Cliente.\n";
	   }
	   if(document.formulario.data_proposta.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data Proposta.\n";
       }
	   if(document.formulario.texto_proposta.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Texto.\n";
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.formulario.altera.value='1';
			document.formulario.submit();
	   }

}
</script>
</head>

<body onUnload="window.opener.location.reload()">
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
 
	$busca = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $nimovel = $linha['ref']." - ".strip_tags($linha['titulo']);
	} 

if($_POST['cadastra']=='1')
{
   		$msgErro = "";

		$cod = $_POST['cod'];
   		$co_cliente = $_POST['co_cliente'];
   		$data_proposta = formataDataParaBd($_POST['data_proposta']);
   		$texto_proposta = $_POST['texto_proposta'];
   		$status_proposta = $_POST['status_proposta'];

   		$SQL = "SELECT id_proposta FROM propostas WHERE cod_imovel='".$cod."' AND cod_cliente='".$co_cliente."' AND data_proposta='".$data_proposta."' AND texto_proposta='".$texto_proposta."' AND status_proposta='".$status_proposta."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe uma proposta feita com essa data, texto e tipo para esse cliente e esse imóvel";
		}

		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"fazer_proposta.php?cod=".$cod."&codi=".$codi."\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO propostas (cod_imobiliaria, cod_imovel, cod_cliente, data_proposta, texto_proposta, status_proposta, p_user) VALUES ('".$_SESSION['cod_imobiliaria']."','".$cod."','".$co_cliente."','".$data_proposta."','".$texto_proposta."', '".$status_proposta."','".$_SESSION['u_cod']."')";   		
   			if(mysql_query($inserir))
			{
				echo('<script language="javascript">alert("Proposta efetuada com sucesso!");document.location.href="fazer_proposta.php?cod='.$cod.'&codi='.$codi.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao inserir!");document.location.href="fazer_proposta.php?cod='.$cod.'&codi='.$codi.'";</script>');
   			}
   		}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT p.id_proposta, p.cod_cliente, p.data_proposta, p.texto_proposta, p.status_proposta, c.c_nome FROM propostas p INNER JOIN clientes c ON (p.cod_cliente=c.c_cod) WHERE p.id_proposta='".$id."' AND p.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_proposta = $linha['id_proposta'];
       $co_cliente = $linha['cod_cliente'];
   	   $nome_cliente = $linha['c_nome'];
   	   $data_proposta = formataDataDoBd($linha['data_proposta']);
   	   $texto_proposta = $linha['texto_proposta'];
   	   $status_proposta = $linha['status_proposta'];
    }
}

if($_POST['altera']=='1')
{
   		$cod = $_POST['cod'];
		$co_cliente = $_POST['co_cliente'];
   		$data_proposta = formataDataParaBd($_POST['data_proposta']);
   		$texto_prosposta = $_POST['texto_proposta'];
   		$status_proposta = $_POST['status_proposta'];
     
			$atualizacao = "UPDATE propostas SET cod_cliente='".$co_cliente."', data_proposta='".$data_proposta."', texto_proposta='".$texto_proposta."', status_proposta='".$status_proposta."', p_user='".$_SESSION['u_cod']."' WHERE id_proposta='".$id_proposta."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Proposta alterada com sucesso!");document.location.href="fazer_proposta.php?cod='.$cod.'&codi='.$codi.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="fazer_proposta.php?cod='.$cod.'&codi='.$codi.'";</script>');
   			}
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];

        
   		$exclusao = "UPDATE propostas SET aceitacao='1' WHERE id_proposta='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Proposta desativada com sucesso!");document.location.href="fazer_proposta.php?cod='.$cod.'&codi='.$codi.'";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao desativar!");document.location.href="fazer_proposta.php?cod='.$cod.'&codi='.$codi.'";</script>');
   		}
}
	  
?>
<form id="formulario" name="formulario" method="post" action="fazer_proposta.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="codi" id="codi" value="<?=$codi ?>">
<input type="hidden" name="id_proposta" id="id_proposta" value="<? echo($id_proposta); ?>">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Fazer proposta </b><br />
      </div></td>
    </tr>
    <tr class="fundoTabela">
      <td width="141" class="style1"><b>Im&oacute;vel:</b></td>
      <td width="602" class="style1"><?=$nimovel?></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Cliente:</b></td>
      <td class="style1"><input type="text" name="co_cliente" size="5" class="campo2" value="<?php print($co_cliente); ?>" readonly>
        <input type="text" name="nome_cliente" size="70" class="campo" value='<?php print($nome_cliente); ?>' readonly>
        <input type="button" id="selecionar" name="selecionar" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=formulario&t_cod=1&c_campo=co_cliente&n_campo=nome_cliente', 'janelaC', 750, 500, 'yes');"></td>


    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Data:</b></td>
      <td class="style1">
        <input type="text" name="data_proposta" id="data_proposta" size="12" maxlength="10" class="campo" value="<? if($data_proposta){ echo($data_proposta); }else{ echo date("d/m/Y");  } ?>" onKeyPress="return txtBoxFormat(document.formulario, 'data_proposta', '##/##/####', event);" onChange="ValidaData(this.value)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Texto:</b></td>
      <td class="style1">
        <textarea name="texto_proposta" id="texto_proposta" cols="40" rows="3" class="campo"><? echo($texto_proposta); ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Tipo</b>:</td>
      <td class="style1"><select name="status_proposta" id="status_proposta" class="campo">
        <option value="nova" <? if($status_proposta=='nova'){ echo "SELECTED"; } ?>>Nova</option>
        <option value="contra-proposta" <? if($status_proposta=='contra-proposta'){ echo "SELECTED"; } ?>>Contra-proposta</option>
        <option value="finalizar" <? if($status_proposta=='finalizar'){ echo "SELECTED"; } ?>>Finalizar</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">
    <? 
	  	if(empty($id_proposta))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='fazer_proposta.php?cod=".$cod."&codi=".$codi."'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='fazer_proposta.php?cod=".$cod."&codi=".$codi."'\">
		  ");		
        } 
	  ?>	  </td>
	</tr>	
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr class="fundoTabelaTitulo">
          <td width="22%" class="style1"><b>Cliente</b></td>
          <td width="13%" class="style1"><b>Data</b></td>
          <td width="21%" class="style1"><b>Texto</b></td>
          <td width="9%" class="style1"><b>Tipo</b></td>
          <td width="10%" class="style1"><b>Vendedor</b></td>
          <td width="11%" class="style1"><b>Status</b></td>
          <td width="13%" class="style1"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
          <td width="12%" class="style1"><div align="center"><b>Desativa&ccedil;&atilde;o</b></div></td>
        </tr>
        <?
        	$i = 0;
            $busca2 = mysql_query("SELECT p.id_proposta, p.data_proposta, p.texto_proposta, p.status_proposta, p.aceitacao, c.c_nome, u.u_nome FROM propostas p INNER JOIN clientes c ON (p.cod_cliente=c.c_cod) INNER JOIN usuarios u ON (p.p_user=u.u_cod) WHERE p.cod_imovel='".$cod."' AND p.p_status='A' AND p.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY p.data_proposta DESC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){
				if ($i++ % 2 == 0) { $fundo = 'fundoTabelaCor1'; } else { $fundo = 'fundoTabelaCor2'; }
				if($linha2['aceitacao']=='0'){
				   $status = "Ativada";
				   $link2 = '<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['id_proposta'].', '.$cod.', '.$codi.')" class="style1">Desativar</a></div></td>';
				}else{
				   $status = "Desativada";
				   $link2 = '';
				}
					echo "<tr class=\"$fundo\">";
      				echo('
            				<td class="style1">'.$linha2['c_nome'].'</td>
            				<td class="style1">'.formataDataDoBd($linha2['data_proposta']).'</td>
            				<td class="style1">'.$linha2['texto_proposta'].'</td>
            				<td class="style1">'.$linha2['status_proposta'].'</td>
            				<td class="style1">'.$linha2['u_nome'].'</td>
							<td class="style1">'.$status.'</td>
							<td class="style1"><div align="center"><a href="fazer_proposta.php?id='.$linha2['id_proposta'].'&cod='.$cod.'&codi='.$codi.'" class="style1">Alterar</a></div></td>
            				'.$link2.'
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
         <input type="button" name="historico" id="historico" class="campo3" value="Histórico" Onclick="formulario.action='impressao_proposta.php?cod=<?=$cod ?>&codi=<?=$codi ?>';formulario.submit();">
		 <input type="button" name="fechar" id="fechar" class="campo3" value="Fechar Janela" Onclick="window.close();">
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