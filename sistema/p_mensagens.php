<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include_once("conect.php");
include_once("funcoes/funcoes.php");
include_once("l_funcoes.php");
verificaAcesso();
verificaArea("MENSAGENS_GERAL");
?>
<html>
<head>
<?php
include_once("style.php");
?>
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="funcoes/js.js"></script>
<script language="javascript">
function confirmaExclusao(id,env)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='p_mensagens.php?id_excluir=' + id + "&env=" + env;
}

function ValidacaoApagar(env, enviados, assuntos, buscar, screem){

	todos = document.getElementsByTagName('input');
    for(x = 0; x < todos.length; x++)
    {
        if (todos[x].checked)
        {
			document.form1.action='p_mensagens.php?env=' + env + '&enviados=' + enviados + '&assuntos=' + assuntos + '&buscar=' + buscar + '&screen=' + screem;
			document.form1.acao_apagar.value='1';
			document.form1.submit();
			return true;
        }
    }
    alert("Selecione pelo menos uma (1) Mensagem!");
    return false;

}

</script>
<script language="JavaScript">

   function Dados(valor) {
      //verifica se o browser tem suporte a ajax
	  try {
         ajax = new ActiveXObject("Microsoft.XMLHTTP");
      } 
      catch(e) {
         try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.forms[0].enviados.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes");
		 
	     ajax.open("POST", "ajax_usuarios_mensagens.php", true);
		 ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax.readyState == 4 ) {	
			   if(ajax.responseXML) {
			      processXML(ajax.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "Primeiro selecione a imobiliária";
			   }
            }
         }
		 //passa o código do estado escolhido
	     var params = "numero="+valor;
         ajax.send(params);
      }
   }
   
   function processXML(obj){
      //pega a tag imobiliaria
      var dataArray   = obj.getElementsByTagName("imobiliaria");
      
	  //total de elementos contidos na tag cidade
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var usuario =  item.getElementsByTagName("usuario")[0].firstChild.nodeValue;
			
	        idOpcao.innerHTML = "Selecione um usuário";
			
			//cria um novo option dinamicamente  
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "opcoes");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = usuario;
				//finalmente adiciona o novo elemento
				document.forms[0].enviados.options.add(novo);
		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
		idOpcao.innerHTML = "--Primeiro selecione a imobiliária--";
	  }	  
   }

</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? include_once("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
<?php
include_once("menu.php");
?>
	</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td align="center">
<?php
if($_POST['acao_apagar']=='1')
{

		$y = $_POST['contador'];
		$c = 0;

		for($p = 0; $p <= $y; $p++)
		{

     		$idmensagens = "id_mensagem_".$p;
     		$id_mensagem = $_POST[$idmensagens];
     		$botoes = "apagar_mensagem_".$p;
     		$botao = $_POST[$botoes];

	    	if($botao=='1')
	    	{
    			$c++;
				$exclusao = "DELETE FROM mensagens WHERE me_id = '".$id_mensagem."'";
   				mysql_query($exclusao);

			}
			
			echo('<script language="javascript">alert("Mensagens selecionadas excluídas com sucesso!");document.location.href="p_mensagens.php?env='.$env.'";</script>');
			
		}
}



if($_GET['assuntos']){
  $assuntos = $_GET['assuntos'];
}else{
  $assuntos = $_POST['assuntos'];
}

if($_GET['enviados']){
  $enviados = $_GET['enviados'];
}else{
  $enviados = $_POST['enviados'];
}

if($_GET['buscar']){
  $buscar = $_GET['buscar'];
}else{
  $buscar = $_POST['buscar'];
}

if($_GET['env']){
  $env = $_GET['env'];
}else{
  $env = $_POST['env'];
}

/*
if($id_alterar != ''){
	$atualiza_status = mysql_query("UPDATE mensagens SET me_status = 1 WHERE me_id = '".$id_alterar."' ");
}
*/
if($_GET['id_excluir']){
  
  	$id_excluir = $_GET['id_excluir'];
  	$env = $_GET['env'];
  
	$exclusao = "DELETE FROM mensagens WHERE me_id = '".$id_excluir."'";
   	if(mysql_query($exclusao))
   	{
   		    echo('<script language="javascript">alert("Mensagem excluída com sucesso!");document.location.href="p_mensagens.php?env='.$env.'";</script>');
   	}
}

?>
<form method="post" action="" name="form1">
       <table border="0" cellspacing="1" width="75%">
		  <tr height="50">
		  	<td colspan="6" align="center" class="style1"><b>Mensagens <? if($env=='S'){ ?>enviadas<? }else{ ?>recebidas<? } ?></b><br /><a href="p_pesq_mensagens.php" class="style1">Enviar Mensagem</a>
			 <? if($env=='S'){ ?>
				 - <a href="p_mensagens.php" class="style1">Visualizar mensagens recebidas</a>
       		<? }else{ ?>
         		 - <a href="p_mensagens.php?env=S" class="style1">Visualizar mensagens enviadas</a>
       		<? } ?>
			  </td>
		  </tr> 
          <tr class="fundoTabela">
          	<td colspan="2" class="style1"><b>Assunto:</b></td>
          	<td colspan="4" class="style1"><input type="text" name="assuntos" id="assuntos" size="40" class="campo"></td>
		  </tr>
		  <tr class="fundoTabela">
          	<td colspan="2" class="style1"><b>Imobiliária:</b></td>
	        <td colspan="4" class="style1">
			<select name="imobiliaria" onchange="Dados(this.value);" class="campo">
			<option selected="selected" value="">Selecione uma imobiliária</option>
			<?php
			$consulta = mysql_query("SELECT im_cod,im_nome FROM rebri_imobiliarias ORDER BY im_nome ASC");
			while( $row = mysql_fetch_assoc($consulta) )
			{
				echo "<option value=\"{$row['im_cod']}\">{$row['im_nome']}</option>\n";
			}
			?>  
			</select>
			</td>
		  </tr> 
		  <tr class="fundoTabela">
          	<td colspan="2" class="style1"><b>Enviado <? if($env=='S'){ echo "para:"; }else{ echo "por:";  } ?></b></td>
          	<td colspan="4" class="style1">
          		<select name="enviados" id="enviados" class="campo">
              		<option id="opcoes" value="0" selected="selected" value="">Selecione primeiro uma imobiliária</option>
              </select>
              </td>
		  </tr>
		  <tr class="fundoTabela">
          	<td colspan="2" class="style1"><b>Nome do Usuário:</b></td>
          	<td colspan="4" class="style1">
          		<input type="text" name="enviados2" id="enviados2" size="40" class="campo"> 
            	<input type="hidden" name="env" id="env" value="<?=$_GET['env'] ?>">
            </td>
		  </tr>
    	  <tr>
      		<td colspan="6">
        		<input type="hidden" name="buscar" id="buscar" value="0">
        		<input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="form1.action='p_mensagens.php?env=<?=$env ?>';form1.buscar.value='1';form1.submit();">
      		<br /><br /></td>
    	  </tr>
		  <tr class="fundoTabelaTitulo">
            <td width="9%" class="style1"><b>Data</b></td>
            <td width="9%" class="style1"><b>Hora</b></td>
            <td width="46%" class="style1"><b>Assunto</b></td>
            <td width="22%" class="style1"><b>Enviado <? if($env=='S'){ echo "para"; }else{ echo "por";  } ?></b></td>
            <td width="7%" class="style1"><b>Status</b></td>
            <td width="7%" class="style1"><b>Ação</b></td>
          </tr>
		  <?php
		  	if ($screen == "") {
   				$screen = 1;
			}

			$from = ($screen - 1) * 30;
			
			if($assuntos!='')
		    {
		    	$buscaAssuntos = "and t1.me_assunto LIKE '%".$assuntos."%'";
		    }
		    	
		    if($enviados!='' && $enviados!= 0)
		    {
		    	$buscaEnviados = "and t2.u_cod='".$enviados."'";
		    }
				
			if($enviados2!='')
		    {
		    	$buscaEnviados2 = "and lower(t2.u_nome) LIKE '%".strtolower($enviados2)."%'";
		    }	
				
			if($imobiliaria!='')
		    {
		    	$buscaImobiliaria = "and t2.cod_imobiliaria = '$imobiliaria'";
		    }
				
		  if($env=='S') // Mensagens enviadas
		  { 
		    if($buscar=='1')
		    {
				$query = "SELECT t1.me_id, t1.me_data, t1.me_hora, t1.me_assunto, t1.me_status, t2.u_nome, t2.u_status FROM mensagens t1, usuarios t2 WHERE (t1.me_status='1' OR t1.me_status='0' AND t2.u_status='Ativo') and t1.me_cod_user_envia = '".$_SESSION['u_cod']."' and t1.me_cod_user_recebe = t2.u_cod $buscaAssuntos $buscaEnviados $buscaEnviados2 $buscaImobiliaria ORDER BY t1.me_id DESC LIMIT $from,30";
		    }
		    else
		    {
		      $query = "SELECT t1.me_id, t1.me_data, t1.me_hora, t1.me_assunto, t1.me_status, t2.u_nome, t2.u_status FROM mensagens t1, usuarios t2 WHERE (t1.me_status='1' OR t1.me_status='0' AND t2.u_status='Ativo') and t1.me_cod_user_envia = '".$_SESSION['u_cod']."' and t1.me_cod_user_recebe = t2.u_cod ORDER BY t1.me_id DESC LIMIT $from,30";
		  	}
		  }
		  else // Mensagens recebidas
		  { 
		    if($buscar=='1')
		    {
		    	$query = "SELECT t1.me_id, t1.me_data, t1.me_hora, t1.me_assunto, t1.me_status, t2.u_nome, t2.u_status FROM mensagens t1, usuarios t2 WHERE (t1.me_status='1' OR t1.me_status='0' AND t2.u_status='Ativo') and t1.me_cod_user_recebe = '".$_SESSION['u_cod']."' and t1.me_cod_user_envia = t2.u_cod $buscaAssuntos $buscaEnviados $buscaEnviados2 $buscaImobiliaria ORDER BY t1.me_id DESC LIMIT $from,30";
		    }
		    else
		    {
		      $query = "SELECT t1.me_id, t1.me_data, t1.me_hora, t1.me_assunto, t1.me_status, t2.u_nome, t2.u_status FROM mensagens t1, usuarios t2 WHERE (t1.me_status='1' OR t1.me_status='0' AND t2.u_status='Ativo') and t1.me_cod_user_recebe = '".$_SESSION['u_cod']."' and t1.me_cod_user_envia = t2.u_cod ORDER BY t1.me_id DESC LIMIT $from,30";  
		  	}
		  }   
		  $result = mysql_query($query);
		  $i = 0;
		  while($linha = mysql_fetch_array($result)){

			
			if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
		  $i++;	 
			
		  ?>
        	<tr class="<?php echo $fundo; ?>">
         		<td><input type="checkbox" name="apagar_mensagem_<?=$i ?>" id="apagar_mensagem_<?=$i ?>" value="1"><input type="hidden" name="id_mensagem_<?=$i ?>" id="id_mensagem_<?=$i ?>" value="<?=$linha['me_id'] ?>">
				 <a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='p_ler_mensagens.php?id_msg=<?=$linha['me_id'] ?>&env=<?=$_GET['env'] ?>';form1.submit();" class="style1"><? echo formataDataDoBd($linha['me_data']) ?></a></td>
         		<td><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='p_ler_mensagens.php?id_msg=<?=$linha['me_id'] ?>&env=<?=$_GET['env'] ?>';form1.submit();" class="style1"><? echo $linha['me_hora'] ?></a></td>
         		<td><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='p_ler_mensagens.php?id_msg=<?=$linha['me_id'] ?>&env=<?=$_GET['env'] ?>';form1.submit();" class="style1"><? echo $linha['me_assunto'] ?></a></td>
         		<td><a href="#" onClick="NewWindow('','uprelatorio','750','500','yes');form1.target='uprelatorio';form1.action='p_ler_mensagens.php?id_msg=<?=$linha['me_id'] ?>&env=<?=$_GET['env'] ?>';form1.submit();" class="style1"><? echo $linha['u_nome'] ?></a></td>
         		<td><? if($linha['me_status'] == '0'){ echo "<span class=\"NaoLida\">Não lida</span>"; } else { echo "<span class=\"Lida\">Lida</span>"; } ?></td>
         		<td><input type="button" name="exlcuir" id="excluir" class="campo3" value="Apagar" Onclick="confirmaExclusao('<? echo $linha['me_id'] ?>', '<?=$_GET['env'] ?>');"></td>
       		</tr>
		  <?

		}
?>
			<input type="hidden" name="contador" id="contador" value="<?=$i ?>">
			<tr class="fundoTabela">
              	<td colspan="6" class="style1" align="left">
               	<input type="hidden" name="acao_apagar" id="acao_apagar" value="0">
				<input type="button" value="Apagar mensagens selecionadas" name="bt_apagar" id="bt_apagar" class="campo3" Onclick="ValidacaoApagar('<?=$env ?>', '<?=$enviados ?>', '<?=$assuntos ?>', '<?=$buscar ?>', '<?=$screen ?>');"><br><br></td>
            </tr>
<?		
		
		
	    if($env=='S') // Mensagens enviadas
	    {
		   	if($buscar=='1')
		   	{
				$query2 = "SELECT COUNT(t1.me_id) as contador FROM mensagens t1, usuarios t2 WHERE (t1.me_status='1' OR t1.me_status='0' AND t2.u_status='Ativo') and t1.me_cod_user_envia = '".$_SESSION['u_cod']."' and t1.me_cod_user_recebe = t2.u_cod $buscaAssuntos $buscaEnviados $buscaEnviados2 $buscaImobiliaria";
		    }
			else
			{
				$query2 = "SELECT COUNT(t1.me_id) as contador FROM mensagens t1, usuarios t2 WHERE (t1.me_status='1' OR t1.me_status='0' AND t2.u_status='Ativo') and t1.me_cod_user_envia = '".$_SESSION['u_cod']."' and t1.me_cod_user_recebe = t2.u_cod";
			}	
		}
		else // Mensagens recebidas
		{
		    if($buscar=='1')
		    {
		    	$query2 = "SELECT COUNT(t1.me_id) as contador FROM mensagens t1, usuarios t2 WHERE (t1.me_status='1' OR t1.me_status='0' AND t2.u_status='Ativo') and t1.me_cod_user_recebe = '".$_SESSION['u_cod']."' and t1.me_cod_user_envia = t2.u_cod $buscaAssuntos $buscaEnviados $buscaEnviados2 $buscaImobiliaria";
		    }
		    else
		    {
		    	$query2 = "SELECT COUNT(t1.me_id) as contador FROM mensagens t1, usuarios t2 WHERE (t1.me_status='1' OR t1.me_status='0' AND t2.u_status='Ativo') and t1.me_cod_user_recebe = '".$_SESSION['u_cod']."' and t1.me_cod_user_envia = t2.u_cod";
		  	}
		  }
		$result2 = mysql_query($query2);
		//$contador = mysql_num_rows($result);
		//$contador = mysql_num_rows($result2);
		//echo "SQL => ".$contador;
		while($not2 = mysql_fetch_array($result2))
		{
			//$paginas = $pages = ceil($contador / 30);

			$paginas = $pages = ceil($not2['contador'] / 30);
    		$pagina = $screen;
    		$url = "p_mensagens.php?env=".$env."&enviados=".$enviados."&assuntos=".$assuntos."&buscar=".$buscar."&screen=";
?>
  		<tr class="fundoTabelaTitulo">
  			<td colspan="6" class="style1" align="center"><b>Foram encontradas <?php print($not2['contador']); ?> mensagens</b></td>
  		</tr>
  		<tr>
    		<td class="style1" colspan="6" align="center">
					<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_mensagens.php?env=<?=$env ?>&enviados=<?=$enviados ?>&assuntos=<?=$assuntos ?>&buscar=<?=$buscar ?>&screen=1" class="style7"><? if ($screen > 1) { ?>| Primeira |<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_mensagens.php?env=<?=$env ?>&enviados=<?=$enviados ?>&assuntos=<?=$assuntos ?>&buscar=<?=$buscar ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>| Anterior |<? } ?></a></td>
                  				<td class="style1" align="center">
								<?
   									$i = 0;
   									$completa = "";
   									if ($paginas > 9){
      									if ($pagina < 5){
   	   										$inicio = 1;
         									$final = 9;
      									}elseif($pagina > $paginas - 5){
   	   										$inicio = $paginas - 9;
         									$final = $paginas;
      									}else{
   	   										$inicio = $pagina - 4;
         									$final = $pagina + 4;
      									}
   									}else{
	   										$inicio = 1;
      										$final = $paginas;
   									}

   									for ($j = $inicio; $j < ($final+1); $j++){
      									if(($paginas > 9) && (strlen($j)==1)){
		   									$j = "0".$j;
      									}

      									$url2 = $url . $j;

      									if($j == $pagina){
            								print "<a href=\"$url2\" class='style1'>| <b>$j</b> |</a>";
 	   									}else{
     	      								print "<a href=\"$url2\" class='style1'>| $j |</a>";
  	   									}
   									}
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="p_mensagens.php?env=<?=$env ?>&enviados=<?=$enviados ?>&assuntos=<?=$assuntos ?>&buscar=<?=$buscar ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>| Próxima |<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_mensagens.php?env=<?=$env ?>&enviados=<?=$enviados ?>&assuntos=<?=$assuntos ?>&buscar=<?=$buscar ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>| Última |<?}?></a></td>
               				</tr>
   						</table>

<?php
	}
?>
	    </table>
      </form></td>
  </tr>
</table>
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
    <? include_once("voltar.php"); ?>
    </td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include_once("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td align="center" class="style1">
    <? include_once("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
</body>
</html>