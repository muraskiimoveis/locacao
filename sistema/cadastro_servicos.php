<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
include("style.php");
verificaAcesso();
verificaArea("GERAL_LOCA");

?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1"> 
<script language="javascript">
function confirmaExclusao(id,cod,l_cod)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='cadastro_servicos.php?id_excluir=' + id + '&cod=' + cod + '&l_cod=' + l_cod;
}



function VerificaCampo()
{

var msg = '';

	   if(document.form1.nome_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome do Serviço.\n";
       }
	   if(document.form1.data_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data do Serviço.\n";
       }
       if(document.form1.valor_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Valor do Serviço.\n";
       }
       if(document.form1.situacao.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Situação.\n";
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

	   if(document.form1.nome_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Nome do Serviço.\n";
       }
	   if(document.form1.data_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Data do Serviço.\n";
       }
       if(document.form1.valor_servico.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Valor do Serviço.\n";
       }
       if(document.form1.situacao.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Situação.\n";
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


if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}

if($_GET['l_cod']){
 $l_cod = $_GET['l_cod'];
}else{
 $l_cod = $_POST['l_cod'];
}

	$busca = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $nimovel = $linha['ref']." - ".strip_tags($linha['titulo']);
	} 

if($_POST['cadastra']=='1')
{
   	$msgErro = "";
   		
		$cod = $_POST['cod'];
   		$nome_servico = $_POST['nome_servico'];
   		$data_servico = formataDataParaBd($_POST['data_servico']);
   		$valor_servico = str_replace(".", "", $_POST['valor_servico']);
   		$situacao = $_POST['situacao'];
  
   	$SQL = "SELECT id_servico FROM servicos WHERE cod_imovel='".$cod."' AND nome_servico='".$nome_servico."' AND data_servico='".$data_servico."' AND valor_servico='".$valor_servico."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe um serviço feito com esse nome, essa data e valor para esse imóvel";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"cadastro_servicos.php?cod=".$cod."&l_cod=".$l_cod."\";</script>"; 
		}
		else
		{
		  	/*
			$blocacao = mysql_query("SELECT l_cod FROM locacao WHERE l_cod='".$l_cod."' AND l_imovel='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
     		if(mysql_num_rows($blocacao) > 0){
	 			while($linha3 = mysql_fetch_array($blocacao)){ 
				    $locacao = $linha3['l_cod'];
				} 
          */
            
            $inserir = "INSERT INTO servicos (cod_imobiliaria, cod_imovel, nome_servico, data_servico, valor_servico, situacao, locacao) VALUES ('".$_SESSION['cod_imobiliaria']."','".$cod."','".$nome_servico."','".$data_servico."','".$valor_servico."','".$situacao."','".$l_cod."')";   		
   			mysql_query($inserir);
            
            
            $b_clientes = mysql_query("SELECT cliente, contador FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
     			while($linhac = mysql_fetch_array($b_clientes)){ 
               $contador = $linhac['contador'];  
               $cliente1 = explode("--", $linhac['cliente']);
               $cliente2 = str_replace("-","",$cliente1);
   
            }
            for($i3 = 1; $i3 <= $contador; $i3++){
                  $queryC = "select c_cod from clientes where c_cod='".$cliente2[$i3-1]."' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
                  $resultC = mysql_query($queryC);
                  while($notC = mysql_fetch_array($resultC)){
                      
                      $query7 = "INSERT INTO contas (cod_imobiliaria, co_cliente, co_cat, co_imovel, co_desc, co_tipo, co_data, co_status, co_valor, co_locacao, co_usuario, co_forma, co_data_status, co_usuario_status) VALUES ('".$_SESSION['cod_imobiliaria']."','".$notC['c_cod']."', 'Pagar', '$cod', '$nome_servico', 'Despesas', '$data_servico', 'pendente', '$valor_servico', '$l_cod', '$u_cod', 'Depósito', current_date, '$u_cod')";
                      mysql_query($query7);
                      
                  }
            }
            
            /*
   			}else{
   				$inserir = "INSERT INTO servicos (cod_imobiliaria, cod_imovel, nome_servico, data_servico, valor_servico, situacao) VALUES ('".$_SESSION['cod_imobiliaria']."','".$cod."','".$nome_servico."','".$data_servico."','".$valor_servico."','".$situacao."')";   		
   				mysql_query($inserir);  
   			}
            */
            
				echo('<script language="javascript">alert("Serviço cadastrado com sucesso!");document.location.href="cadastro_servicos.php?cod='.$cod.'&l_cod='.$l_cod.'";</script>');
   			
   			
   	}
}

$id = $_GET['id'];

if($id){
	$alteracao = mysql_query("SELECT * FROM servicos WHERE id_servico='".$id."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($alteracao)){
       $id_servico = $linha['id_servico'];
       $nome_servico = $linha['nome_servico'];
   	   $data_servico = formataDataDoBd($linha['data_servico']);
   	   $valor_servico = number_format($linha['valor_servico'], 2, ',', '.');
   	   $situacao = $linha['situacao'];
    }
}

if($_POST['altera']=='1')
{
   		$cod = $_POST['cod'];
   		$nome_servico = $_POST['nome_servico'];
   		$data_servico = formataDataParaBd($_POST['data_servico']);
   		$valor_servico = str_replace(".", "", $_POST['valor_servico']);
   		$situacao = $_POST['situacao'];
     
		$atualizacao = "UPDATE servicos SET nome_servico='".$nome_servico."', data_servico='".$data_servico."', valor_servico='".$valor_servico."', situacao='".$situacao."' WHERE id_servico='".$id_servico."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		mysql_query($atualizacao);
         
		  $b_clientes2 = mysql_query("SELECT * FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_locacao='".$l_cod."' AND co.co_cat='Pagar' AND co.co_tipo='Despesas' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY co.co_cliente");
   		  while($linhac2 = mysql_fetch_array($b_clientes2)){ 
            $clientes = $linhac2['co_cliente'];  
            
			$query70 = "UPDATE contas SET co_desc='$nome_servico',co_data='$data_servico', co_valor='$valor_servico' WHERE co_cliente='$clientes' AND co_cat='Pagar' AND co_tipo='Despesas' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
            mysql_query($query70);
          }
    
   	
         echo('<script language="javascript">alert("Serviço alterado com sucesso!");document.location.href="cadastro_servicos.php?cod='.$cod.'&l_cod='.$l_cod.'";</script>');
 
}

if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
   		$exclusao = "DELETE FROM servicos WHERE id_servico='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		mysql_query($exclusao);
         
         
         $b_clientes3 = mysql_query("SELECT * FROM contas co INNER JOIN clientes c ON (co.co_cliente=c.c_cod) WHERE co.co_locacao='".$l_cod."' AND co.co_cat='Pagar' AND co.co_tipo='Despesas' AND co.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY co.co_cliente");
   		  while($linhac3 = mysql_fetch_array($b_clientes3)){ 
            $clientes = $linhac3['co_cliente'];  
            
			$query70 = "DELETE FROM contas WHERE co_cliente='$clientes' AND co_cat='Pagar' AND co_tipo='Despesas' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
            mysql_query($query70);
          }
         
   		echo('<script language="javascript">alert("Serviço excluído com sucesso!");document.location.href="cadastro_servicos.php?cod='.$cod.'&l_cod='.$l_cod.'";</script>');
}
	  
?>
<form id="form1" name="form1" method="post" action="cadastro_servicos.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
<input type="hidden" name="l_cod" id="l_cod" value="<?=$l_cod ?>">
<input type="hidden" name="id_servico" id="id_servico" value="<? echo($id_servico); ?>">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><p align="center"><b>Servi&ccedil;os</b></p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="20%" class="style1"><b>Im&oacute;vel:</b></td>
      <td width="80%" class="style1"><?=$nimovel?></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Nome do Servi&ccedil;o:</b></td>
      <td class="style1"><input type="text" name="nome_servico" size="40" class="campo" value="<?php print($nome_servico); ?>"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Data do Servi&ccedil;o:</b></td>
      <td class="style1"><input type="text" name="data_servico" id="data_servico" size="12" maxlength="10" class="campo" value="<? echo($data_servico);  ?>" onKeyPress="return txtBoxFormat(document.form1, 'data_servico', '##/##/####', event);" onChange="ValidaData(this.value)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Valor do Servi&ccedil;o:</b></td>
      <td class="style1"><input type="text" name="valor_servico" id="valor_servico" size="10" class="campo" value="<? echo($valor_servico); ?>" onKeydown="Formata(this,20,event,2)"></td>
    </tr>
    <tr class="fundoTabela">
      <td class="style1"><b>Stua&ccedil;&atilde;o:</b></td>
      <td class="style1"><select name="situacao" id="situacao" class="campo">
          <option value="">Selecione</option>
		  <option value="Novo" <? if($situacao=='Novo'){ echo "SELECTED"; } ?>>Novo</option>
          <option value="Em Dia" <? if($situacao=='Em Dia'){ echo "SELECTED"; } ?>>Em Dia</option>
          <option value="Atrasado" <? if($situacao=='Atrasado'){ echo "SELECTED"; } ?>>Atrasado</option>
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
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo3\" value=\"Limpar\" Onclick=\"window.location.href='cadastro_servicos.php?cod=".$cod."&l_cod=".$l_cod."'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo3\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo3\" value=\"Cancelar\" Onclick=\"window.location.href='cadastro_servicos.php?cod=".$cod."&l_cod=".$l_cod."'\">
		  ");		
        } 
	  ?>	  
     </td>
	</tr>	
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr> 
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
		<tr class="fundoTabelaTitulo" height="25px">
          <td width="31%" class="style1"><b>Nome</b></td>
          <td width="15%" class="style1"><b>Data</b></td>
          <td width="14%" class="style1"><b>Valor</b></td>
          <td width="13%" class="style1"><b>Situação</b></td>
          <td width="14%" class="style1"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
          <td width="13%" class="style1"><div align="center"><b>Exclus&atilde;o</b></div></td>
        </tr>
        <?
            $busca2 = mysql_query("SELECT id_servico, nome_servico, data_servico, valor_servico, situacao FROM servicos WHERE cod_imovel='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY data_servico ASC");
     		if(mysql_num_rows($busca2) > 0){
			    $i = 0;
			    $j = 0; 
	 			while($linha2 = mysql_fetch_array($busca2)){
      				if (($j % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
					$j++;
					
					echo "<tr class=\"$fundo\">";
      				echo('
	        				<input type="hidden" name="cod_servico_'.$i.'" id="cod_servico_'.$i.'" value="'.$linha2['id_servico'].'"> 
            				<td class="style1"><input type="checkbox" name="impressao_'.$i.'" id="impressao_'.$i.'" value="1">'.$linha2['nome_servico'].'</td>
							<td class="style1">'.formataDataDoBd($linha2['data_servico']).'</td>
            				<td class="style1">'.number_format($linha2['valor_servico'], 2, ',', '.').'</td>
        				    <td class="style1">'.$linha2['situacao'].'</td>
            				<td class="style1"><div align="center"><a href="cadastro_servicos.php?id='.$linha2['id_servico'].'&cod='.$cod.'&l_cod='.$l_cod.'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['id_servico'].', '.$cod.', '.$l_cod.')" class="style1">Excluir</a></div></td>
            			</tr>
	   				');
				$i++;	
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
	   <input name="i" id="i" type="hidden" class="campo" value="<?= $i ?>">
      </table></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr> 
    <tr>
      <td colspan="2"><div align="center">
        <input type="button" name="impressao" id="impressao" class="campo3" value="Recibo" Onclick="form1.action='impressao_servicos.php?cod=<?=$cod ?>&l_cod=<?=$l_cod ?>';form1.submit();">
        <input type="button" name="fechar" id="fechar" class="campo3" value="Fechar Janela" Onclick="window.close();">
</form><br /><br />   
		<form name="form3" id="form3" method="post" action="recibo_imobiliaria.php"><input type="submit" value="Recibo Imobiliária" name="recibo" id="reibo" class="campo3" onClick="form3.action='recibo_imobiliaria.php?locacao=<?=$l_cod ?>';"></form>     
      </div></td>
    </tr>
	</table>
<?
mysql_close($con);
?>

</body>
</html>