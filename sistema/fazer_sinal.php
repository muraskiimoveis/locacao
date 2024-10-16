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
function confirmaExclusao(id,cod,codi)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='fazer_sinal.php?id_excluir=' + id + '&cod=' + cod + '&codi=' + codi;
}



function VerificaCampo()
{

var msg = '';

	   if(document.formulario.co_cliente.value.length==0)
	   {
	          msg += "Por favor, selecione o campo Comprador.\n";
	   }
	   if(document.formulario.texto_sinal.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Texto.\n";
       }
	   if(document.formulario.data_sinal.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data do Sinal.\n";
       }
       if(document.formulario.valor_venda.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Valor da venda.\n";
       }
       /*if(document.formulario.vendedor.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Vendedor.\n";
	   }
	   */
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
	          msg += "Por favor, selecione o campo Comprador.\n";
	   }
	   if(document.formulario.texto_sinal.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Texto.\n";
       }
	   if(document.formulario.data_sinal.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data do Sinal.\n";
       }
       if(document.formulario.valor_venda.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Valor da venda.\n";
       }
       /*if(document.formulario.vendedor.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Vendedor.\n";
	   }
	   */
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
   		$texto_sinal = $_POST['texto_sinal'];
   		$data_sinal = formataDataParaBd($_POST['data_sinal']);
   		
   		$valor_venda = str_replace(".", "", $_POST['valor_venda']);  
  		$valor_venda = str_replace(",", ".", $valor_venda);  
   		//$vendedor = $_POST['vendedor'];
   		$status_sinal = $_POST['status_sinal'];
  
   		$SQL = "SELECT id_sinal FROM sinal_venda WHERE cod_imovel='".$cod."' AND cod_cliente='".$co_cliente."' AND data_sinal='".$data_sinal."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND s_status='A'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe um sinal feito com essa data para esse cliente e esse imóvel";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"fazer_sinal.php?cod=".$cod."&codi=".$codi."\";</script>"; 
		}
		else
		{
			$inserir = "INSERT INTO sinal_venda (cod_imobiliaria, cod_imovel, cod_cliente, texto_sinal, data_sinal, valor_venda, vendedor, status_sinal) VALUES ('".$_SESSION['cod_imobiliaria']."','".$cod."','".$co_cliente."','".$texto_sinal."','".$data_sinal."','".$valor_venda."','".$_SESSION['u_cod']."','".$status_sinal."')";   		
   			if(mysql_query($inserir))
			{
			    $id = mysql_insert_id();
				echo('<script language="javascript">alert("Sinal efetuado com sucesso!");document.location.href="impressao_sinal.php?id='.$id.'&cod='.$cod.'&imp=7&compr='.$co_cliente.'&codim='.$codi.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao inserir!");document.location.href="fazer_sinal.php?cod='.$cod.'";</script>');
   			}
   		}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT s.id_sinal, s.cod_cliente, s.data_sinal, s.texto_sinal, s.status_sinal, s.valor_venda, s.vendedor, c.c_nome FROM sinal_venda s INNER JOIN clientes c ON (s.cod_cliente=c.c_cod) WHERE s.id_sinal='".$id."' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_sinal = $linha['id_sinal'];
       $co_cliente = $linha['cod_cliente'];
       $nome_cliente = $linha['c_nome'];
   	   $data_sinal = formataDataDoBd($linha['data_sinal']);
   	   $valor_venda = number_format($linha['valor_venda'], 2, ',', '.');
   	   //$u_cod = $linha['vendedor'];
   	   $texto_sinal = $linha['texto_sinal'];
   	   $status_sinal = $linha['status_sinal'];
    }
}

if($_POST['altera']=='1')
{
   		$cod = $_POST['cod'];
   		$co_cliente = $_POST['co_cliente'];
   		$texto_sinal = $_POST['texto_sinal'];
   		$data_sinal = formataDataParaBd($_POST['data_sinal']);
   		$valor_venda = str_replace(".", "", $_POST['valor_venda']);  
  		$valor_venda = str_replace(",", ".", $valor_venda); 
   		//$vendedor = $_POST['vendedor'];
   		$status_sinal = $_POST['status_sinal'];
     
			$atualizacao = "UPDATE sinal_venda SET cod_cliente='".$co_cliente."', texto_sinal='".$texto_sinal."', data_sinal='".$data_sinal."', valor_venda='".$valor_venda."', vendedor='".$_SESSION['u_cod']."', status_sinal='".$status_sinal."' WHERE id_sinal='".$id_sinal."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
			if(mysql_query($atualizacao))
   			{
   		    	echo('<script language="javascript">alert("Sinal alterado com sucesso!");document.location.href="fazer_sinal.php?cod='.$cod.'&codi='.$codi.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="fazer_sinal.php?cod='.$cod.'&codi='.$codi.'";</script>');
   			}
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
   		$exclusao = "DELETE FROM sinal_venda WHERE id_sinal='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Sinal excluído com sucesso!");document.location.href="fazer_sinal.php?cod='.$cod.'&codi='.$codi.'";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="fazer_sinal.php?cod='.$cod.'&codi='.$codi.'";</script>');
   		}
}
	  
?>
<form id="formulario" name="formulario" method="post" action="fazer_sinal.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="codi" id="codi" value="<?=$codi ?>">
<input type="hidden" name="id_sinal" id="id_sinal" value="<? echo($id_sinal); ?>">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Fazer sinal</b><br />
      </div></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Im&oacute;vel:</b></td>
      <td width="80%" class="style1"><?=$nimovel?></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Comprador:</b></td>
      <td class="style1"><input type="text" name="co_cliente" size="5" class="campo2" value="<?php print($co_cliente); ?>" readonly>
        <input type="text" name="nome_cliente" size="70" class="campo" value='<?php print($nome_cliente); ?>' readonly>
        <input type="button" id="selecionar" name="selecionar" value="Selecionar" class="campo3" onClick="NewWindow('p_list_clientes_n.php?f_nome=formulario&t_cod=1&c_campo=co_cliente&n_campo=nome_cliente', 'janela2', 750, 500, 'yes');"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Texto:</b></td>
      <td class="style1">
        <textarea name="texto_sinal" id="texto_sinal" cols="40" rows="3" class="campo"><? echo($texto_sinal); ?></textarea></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Data do sinal:</b></td>
      <td class="style1"><input type="text" name="data_sinal" id="data_sinal" size="12" maxlength="10" class="campo" value="<? echo($data_sinal);  ?>" onKeyPress="return txtBoxFormat(document.formulario, 'data_sinal', '##/##/####', event);" onChange="ValidaData(this.value)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Valor da venda:</b></td>
      <td class="style1"><input type="text" name="valor_venda" id="valor_venda" size="15" class="campo" value="<? echo($valor_venda); ?>" onKeydown="Formata(this,20,event,2)">      </td>
    </tr>
    <!--tr class="fundoTabela">
      <td class="style1"><b>Vendedor:</b></td>
      <td class="style1"><select name="vendedor" id="vendedor" class=campo>
          <option value="0">Selecione</option>
        <?
            $vendedores = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY u_email ASC");
 			while($linha = mysql_fetch_array($vendedores)){
				if($linha[u_cod]==$u_cod){
					echo('<option value="'.$linha[u_cod].'" SELECTED>'.$linha[u_email].'</option>');
				}else{ 			   
					echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
				}
 			}
		?>
      </select></td>
    </tr-->
    <tr class="fundoTabela">
      <td class="style1"><b>Status:</b></td>
      <td class="style1"><select name="status_sinal" id="status_sinal" class="campo">
          <option value="novo" <? if($status_sinal=='novo'){ echo "SELECTED"; } ?>>Novo</option>
          <option value="confirmado" <? if($status_sinal=='confirmado'){ echo "SELECTED"; } ?>>Confirmado</option>
          <option value="cancelado" <? if($status_sinal=='cancelado'){ echo "SELECTED"; } ?>>Cancelado</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">
    <? 
	  	if(empty($id_sinal))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo3\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='fazer_sinal.php?cod=".$cod."&codi=".$codi."'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='fazer_sinal.php?cod=".$cod."&codi=".$codi."'\">
		  ");		
        } 
	  ?>	  </td>
	</tr>	
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr> 
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?
          $busca3 = mysql_query("SELECT s.id_sinal, s.data_sinal, s.texto_sinal, s.valor_venda, s.status_sinal, s.cod_cliente, c.c_nome, u.u_nome FROM sinal_venda s INNER JOIN clientes c ON (s.cod_cliente=c.c_cod) INNER JOIN usuarios u ON (s.vendedor=u.u_cod) WHERE s.cod_imovel='".$cod."' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY s.data_sinal DESC");
     	  while($linha2 = mysql_fetch_array($busca3)){
     	    
     	    if($linha2['status_sinal']=='confirmado'){
			     $vendat = '<td width="7%" class="style1"><div align="center"><b>Venda</b></div></td>';
			}else{
			     $vendat = '<td width="7%" class="style1"><div align="center"><b>Venda</b></div></td>';
			}
				  
		  }
        ?>
		<tr class="fundoTabelaTitulo">
          <td width="19%" class="style1"><b>Comprador</b></td>
          <td width="8%" class="style1"><b>Data Sinal</b></td>
          <td width="11%" class="style1"><b>Valor Venda</b></td>
          <td width="16%" class="style1"><b>Vendedor</b></td>
          <td width="11%" class="style1"><b>Status</b></td>
          <td width="9%" class="style1"><div align="center"><b>Proposta</b></div></td>
          <?=$vendat; ?>
          <td width="9%" class="style1"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
          <td width="8%" class="style1"><div align="center"><b>Exclus&atilde;o</b></div></td>
        </tr>
        <?
        	$i = 0;
            $busca2 = mysql_query("SELECT s.id_sinal, s.data_sinal, s.texto_sinal, s.valor_venda, s.status_sinal, s.cod_cliente, c.c_nome, u.u_nome, i.im_cod, i.im_cidade, i.im_estado FROM sinal_venda s INNER JOIN clientes c ON (s.cod_cliente=c.c_cod) INNER JOIN usuarios u ON (s.vendedor=u.u_cod) INNER JOIN rebri_imobiliarias i ON (s.cod_imobiliaria=i.im_cod) WHERE s.cod_imovel='".$cod."' AND s.s_status='A' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY s.data_sinal DESC");
     		if(mysql_num_rows($busca2) > 0){
	 			while($linha2 = mysql_fetch_array($busca2)){
	 			  if ($i++ % 2 == 0) { $fundo = 'fundoTabelaCor1'; } else { $fundo = 'fundoTabelaCor2'; }
	 			  
	 			  if($linha2['status_sinal']=='confirmado'){
				     $venda = '<td class="style1"><div align="center"><a href="venda.php?cod='.$cod.'&compr='.$linha2['cod_cliente'].'" class="style1">Vender</a></div></td>';
				  }else{
				     $venda = '<td class="style1"></td>';
				  }
	 			  
					echo "<tr class=\"$fundo\">";
      				echo('
            				<td class="style1">'.$linha2['c_nome'].'</td>
							<td class="style1">'.formataDataDoBd($linha2['data_sinal']).'</td>
            				<td class="style1">'.number_format($linha2['valor_venda'], 2, ',', '.').'</td>
        				    <td class="style1">'.$linha2['u_nome'].'</td>
            				<td class="style1">'.$linha2['status_sinal'].'</td>
            				<td class="style1"><div align="center"><a href="impressao_sinal.php?id='.$linha2['id_sinal'].'&cod='.$cod.'&imp=7&compr='.$linha2['cod_cliente'].'&codim='.$linha2['im_cod'].'&ufim='.$linha2['im_estado'].'&cidadeim='.$linha2['im_cidade'].'" class="style1">Visualizar</a></div></td>
            				'.$venda.'
            				<td class="style1"><div align="center"><a href="fazer_sinal.php?id='.$linha2['id_sinal'].'&cod='.$cod.'&codi='.$codi.'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['id_sinal'].', '.$cod.','.$codi.')" class="style1">Excluir</a></div></td>
            			</tr>
	   				');
    			}
  			}
  			else
    		{
	       		echo('
	        		<tr>
            			<td colspan="8" class="style1"><div align="center"><b>Nenhum registro encontrado!</b></div></td>
            		</tr>
	   			');
			}
       ?>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="button" name="impressao" id="impressao" class="campo3" value="Visualizar Impressão" Onclick="formulario.action='historico_sinal.php?cod=<?=$cod ?>&codi=<?=$codi ?>';formulario.submit();">
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