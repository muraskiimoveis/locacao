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
verificaArea("IMOV_GERAL");
?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="css/estilos_sistema.css" />
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(id,cod)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='solicitacao_servicos.php?id_excluir=' + id + '&cod=' + cod;
}



function VerificaCampo()
{

var msg = '';

	   if(document.form1.tipo_prestador.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Tipo Prestador.\n";
	   }
	   if(document.form1.prestador.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Prestador.\n";
	   }
	   if(document.form1.data_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data Serviço.\n";
       }
	   if(document.form1.valor_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Valor.\n";
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

	   if(document.form1.tipo_prestador.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Tipo Prestador.\n";
	   }
	   if(document.form1.prestador.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Prestador.\n";
	   }
	   if(document.form1.data_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data Serviço.\n";
       }
	   if(document.form1.valor_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Valor.\n";
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/

if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}
 
	$busca = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $nimovel = $linha['ref']." - ".strip_tags($linha['titulo']);
	} 

if($_POST['cadastra']=='1')
{
   		$msgErro = "";
   		
		$cod = $_POST['cod'];
   		$tipo_prestador = $_POST['tipo_prestador'];
   		$prestador = $_POST['prestador'];
   		$data_servico = formataDataParaBd($_POST['data_servico']);
   		$valor_servico = str_replace(".", "", $_POST['valor_servico']);
   		$comentario = $_POST['comentario'];
   		$status = $_POST['status'];
  
   		$SQL = "SELECT data_servico FROM solicitacao_servicos WHERE cod_imovel='".$cod."' AND tipo_prestador='".$tipo_prestador."' AND data_servico='".$data_servico."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe um prestador do tipo ".$tipo_prestador." agendado com essa data";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"solicitacao_servicos.php?cod=".$cod."\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO solicitacao_servicos (cod_imobiliaria, cod_imovel, tipo_prestador, cod_prestador, data_servico, valor_servico, comentario, status, data_pagamento) VALUES ('".$_SESSION['cod_imobiliaria']."','".$cod."','".$tipo_prestador."','".$prestador."','".$data_servico."','".$valor_servico."','".$comentario."', '".$status."', current_date)";   		
   			if(mysql_query($inserir))
			{
				echo('<script language="javascript">alert("Cadastro efetuado com sucesso!");document.location.href="solicitacao_servicos.php?cod='.$cod.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="solicitacao_servicos.php?cod='.$cod.'";</script>');
   			}
   		}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT id_servico, tipo_prestador, cod_prestador, data_servico, valor_servico, comentario, status FROM solicitacao_servicos WHERE id_servico='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_servico = $linha['id_servico'];
       $tipo_prestador = $linha['tipo_prestador'];
   	   $prestador = $linha['cod_prestador'];
   	   $data_servico = formataDataDoBd($linha['data_servico']);
   	   $valor_servico = number_format($linha['valor_servico'], 2, ',', '.');
   	   $comentario = $linha['comentario'];
   	   $status = $linha['status'];
    }
}

if($_POST['altera']=='1')
{
   		$cod = $_POST['cod'];
		$tipo_prestador = $_POST['tipo_prestador'];
   		$prestador = $_POST['prestador'];
   		$data_servico = formataDataParaBd($_POST['data_servico']);
   		$valor_servico = str_replace(".", "", $_POST['valor_servico']);
   		$comentario = $_POST['comentario'];
   		$status = $_POST['status'];
     
			$atualizacao = "UPDATE solicitacao_servicos SET tipo_prestador='".$tipo_prestador."', cod_prestador='".$prestador."', data_servico='".$data_servico."', valor_servico='".$valor_servico."', comentario='".$comentario."', status='".$status."',data_pagamento=current_date WHERE id_servico='".$id_servico."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Cadastro alterado com sucesso!");document.location.href="solicitacao_servicos.php?cod='.$cod.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="solicitacao_servicos.php?cod='.$cod.'";</script>');
   			}
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
   		$exclusao = "DELETE FROM solicitacao_servicos WHERE id_servico='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Cadastro excluído com sucesso!");document.location.href="solicitacao_servicos.php?cod='.$cod.'";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="solicitacao_servicos.php?cod='.$cod.'";</script>');
   		}
}
	  
?>
<form id="form1" name="form1" method="post" action="solicitacao_servicos.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="id_servico" id="id_servico" value="<? echo($id_servico); ?>">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Solicita&ccedil;&atilde;o de Servi&ccedil;os</b><br />
      </div></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Im&oacute;vel:</b></td>
      <td width="80%" class="style1"><?=$nimovel?></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Tipo Prestador:</b></td>
      <td class="style1"><select name="tipo_prestador" id="tipo_prestador" class="campo" onChange="form1.submit();">
      <option value="">Selecione</option>
      <option value="eletricista" <? if($tipo_prestador=='eletricista'){ echo "SELECTED"; } ?>>Eletricista</option>
      <option value="encanador" <? if($tipo_pestador=='encanador'){ echo "SELECTED"; } ?>>Encanador</option>
      <option value="diarista" <? if($tipo_prestador=='diarista'){ echo "SELECTED"; } ?>>Diarista</option>
      <option value="jardineiro" <? if($tipo_prestador=='jardineiro'){ echo "SELECTED"; } ?>>Jardineiro</option>
      <option value="piscineiro" <? if($tipo_prestador=='piscineiro'){ echo "SELECTED"; } ?>>Piscineiro</option>
    </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Prestador:</b></td>
      <td class="style1"><select name="prestador" id="prestador" class="campo">
      <option value="">Selecione</option>
       <?
         if($tipo_prestador){
            $prestadores = mysql_query("SELECT c_cod, c_nome FROM clientes WHERE c_prestador='".$tipo_prestador."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY c_nome ASC");
 			while($linha = mysql_fetch_array($prestadores)){
				if($linha[c_cod]==$prestador){
					echo('<option value="'.$linha[c_cod].'" SELECTED>'.$linha[c_nome].'</option>');
				}else{ 			   
					echo('<option value="'.$linha[c_cod].'">'.$linha[c_nome].'</option>');
				}
 			}
 		}elseif($_GET['tipo_prestador']){
		    $prestadores = mysql_query("SELECT c_cod, c_nome FROM clientes WHERE c_prestador='".$tipo_prestador."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY c_nome ASC");
 			while($linha = mysql_fetch_array($prestadores)){
				if($linha[c_cod]==$prestador){
					echo('<option value="'.$linha[c_cod].'" SELECTED>'.$linha[c_nome].'</option>');
				}else{ 			   
					echo('<option value="'.$linha[c_cod].'">'.$linha[c_nome].'</option>');
				}
 			}
		}
       ?>
    </select></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Data Servi&ccedil;o:</b></td>
      <td class="style1">
        <input type="text" name="data_servico" id="data_servico" size="12" maxlength="10" class="campo" value="<? if(!empty($data_servico)){ echo($data_servico); } ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_servico', '##/##/####', event);" onChange="ValidaData(this.value)">
      </td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Valor:</b></td>
      <td class="style1">
        <input type="text" name="valor_servico" id="valor_servico" size="15" class="campo" value="<? if(!empty($valor_servico)){ echo($valor_servico); } ?>" onKeydown="Formata(this,20,event,2)">
      </td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Coment&aacute;rio:</b></td>
      <td class="style1">
        <textarea name="comentario" id="comentario" cols="40" rows="3" class="campo"><? echo($comentario); ?></textarea>
      </td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Status do Servi&ccedil;o</b>:</td>
      <td class="style1"><select name="status" id="status" class="campo">
        <option value="pendente" <? if($status=='pendente'){ echo "SELECTED"; } ?>>Pendente</option>
        <option value="ok" <? if($status=='ok'){ echo "SELECTED"; } ?>>OK</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">
    <? 
	  	if(empty($id_servico))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='solicitacao_servicos.php?cod=".$cod."'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='solicitacao_servicos.php?cod=".$cod."'\">
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
          <td width="19%" class="style1"><b>Tipo Prestador </b></td>
          <td width="24%" class="style1"><b>Prestador</b></td>
          <td width="15%" class="style1"><b>Data Servi&ccedil;o </b></td>
          <td width="10%" class="style1"><b>Valor</b></td>
          <td width="10%" class="style1"><b>Status</b></td>
          <td width="11%" class="style1"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
          <td width="11%" class="style1"><div align="center"><b>Exclus&atilde;o</b></div></td>
        </tr>
        <?
        	$i = 0;
            $busca2 = mysql_query("SELECT s.id_servico, s.tipo_prestador, s.data_servico, s.valor_servico, s.status, c.c_nome FROM solicitacao_servicos s INNER JOIN clientes c ON (s.cod_prestador=c.c_cod) WHERE s.cod_imovel='".$cod."' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY s.data_servico ASC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){
					if ($i++ % 2 == 0) { $fundo = 'fundoTabelaCor1'; } else { $fundo = 'fundoTabelaCor2'; }
					
					echo "<tr class=\"$fundo\">";
      				echo('
            				<td class="style1">'.$linha2['tipo_prestador'].'</td>
            				<td class="style1">'.$linha2['c_nome'].'</td>
            				<td class="style1">'.formataDataDoBd($linha2['data_servico']).'</td>
            				<td class="style1">'.number_format($linha2['valor_servico'], 2, ',', '.').'</td>
            				<td class="style1">'.$linha2['status'].'</td>
            				<td class="style1"><div align="center"><a href="solicitacao_servicos.php?id='.$linha2['id_servico'].'&cod='.$cod.'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['id_servico'].', '.$cod.')" class="style1">Excluir</a></div></td>
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
