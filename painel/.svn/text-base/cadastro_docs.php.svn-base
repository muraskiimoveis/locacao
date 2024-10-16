<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("regra.php");
?>
<html>
<head>
<?php
include("style.php");
?>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<table width=100% height=100%>
<tr><td bgcolor="<?php print("$barra_lat"); ?>" valign=top width=150>
<?php
include("menu_painel.php");
?></td>
<td width=620 valign=top>
<br>
<?php
include("conect.php");
include("funcoes/funcoes.php");
?>
<script type="text/javascript" src="../funcoes/js.js"></script>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript">
	tinyMCE.init({
		height : "400",
		width : "600",
		mode : "exact",
		language : "pt",
		elements : "texto",
		theme : "advanced",
        plugins : "safari,pagebreak,layer,table,style,advhr,advimage,advlink,emotions,inlinepopups,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras   ,template,wordcount,youtube",
		theme_advanced_buttons1 : "cut,|,copy,paste,pastetext,pasteword,|,bold,|,code,|,search,replace,|,undo,redo,|,cleanup,removeformat,|,help",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
      theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		forced_root_block : false,
	   force_br_newlines : true,
      force_p_newlines : false,
		relative_urls : false,
		convert_urls : true,
		remove_script_host : false
	});
</script>

<script language="javascript">
function confirmaExclusao(id,cod, d_cod)
{
       if(confirm("Tem certeza que deseja excluir este item?"))
          document.location.href='cadastro_docs.php?id_excluir=' + id + '&cod_imob=' + cod + '&d_cod=' + d_cod;
}

</script>

<script language="JavaScript">
function VerificaCampo()
{

var msg = '';

//alert (document.getElementById('texto').value);
//alert (document.getElementById('texto').innerText);
//alert (document.getElementsByName('texto').value);
//alert (document.form1.texto.value);
//alert (document.getElementsByTagName('texto').value);
//alert (document.tinyMCE.get('texto').getContent);
//alert(tinyMCE.activeEditor.getContent('field_name'));

       if(document.form1.titulo.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Título.\n";
       }
       if (document.form1.contrato_de.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Contrato de.\n";
	   }
       if (document.form1.tipo_contrato.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Tipo Contrato.\n";
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

       if(document.form1.titulo.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Título.\n";
       }
       if (document.form1.contrato_de.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Contrato de.\n";
	   }
       if (document.form1.tipo_contrato.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Tipo Contrato.\n";
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
 <p align="center" class=style2>
   <?php

if($_GET['cod_imob']){
 $cod_imob = $_GET['cod_imob'];
}else{
 $cod_imob = $_POST['cod_imob'];
}


if($_POST['cadastra']=='1')
{
      if ($texto == "") {
	 		echo "<script language=\"javascript\">alert('Erro: O texto não pode estar vazio');document.location.href=\"cadastro_docs.php?cod_imob=".$cod_imob."\";</script>";

      } else {
   		$msgErro = "";
   		
		$titulo = $_POST['titulo'];
   		$texto = $_POST['texto'];
   		$contrato_de = $_POST['contrato_de'];
   		$tipo_contrato = $_POST['tipo_contrato'];
   		
   		$SQL = "SELECT d_id FROM doc WHERE d_nome='".$titulo."' AND d_txt='".$texto."' AND d_tipo_contrato='".$contrato_de."' AND d_contrato='".$tipo_contrato."' AND cod_imobiliaria='".$cod_imob."'";
		$busca = mysql_query($SQL,$con) or die ("erro 155");
        $num_rows = mysql_num_rows($busca);
    	if($num_rows > 0)
		{
			$msgErro .= "Já existe um documentos cadastrado com estes dados!";
		}
		
		if($msgErro != "")
		{
	 		echo "<script language=\"javascript\">alert('" . $msgErro . "');document.location.href=\"cadastro_docs.php?cod_imob=".$cod_imob."\";</script>";
		}
		else
		{
		 	$n_texto = str_replace("<STRONG>","<b>",$texto);
		 	$n_texto = str_replace("<strong>","<b>",$n_texto);
		 	$n_texto = str_replace("</STRONG>","</b>",$n_texto);
		 	$n_texto = str_replace("</strong>","</b>",$n_texto);		
         	$n_texto = str_replace("<BR>","\n",$n_texto);
         	$n_texto = str_replace("<BR />","\n",$n_texto);
         	$n_texto = str_replace("<br>","\n",$n_texto);
         	$n_texto = str_replace("<br />","\n",$n_texto);
			
			$inserir = "INSERT INTO doc (cod_imobiliaria, d_nome, d_txt, d_data, d_tipo_contrato, d_contrato) VALUES ('".$cod_imob."','".$titulo."', '".$n_texto."', current_date, '".$contrato_de."','".$tipo_contrato."')";
   			if(mysql_query($inserir,$con))
			{
				echo('<script language="javascript">alert("Contrato cadastrado com sucesso!");document.location.href="cadastro_docs.php?cod_imob='.$cod_imob.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao cadastrar!");document.location.href="cadastro_docs.php?cod_imob='.$cod_imob.'";</script>');
   			}
   		}
   }
}

$id = $_GET['id'];

if($id){
	$alteracao = "SELECT * FROM doc WHERE d_id='".$id."' AND cod_imobiliaria='".$cod_imob."'";
    $sql = mysql_query($alteracao,$con) or die ("erro 194");
    while($linha = mysql_fetch_array($sql)){
       $d_id = $linha['d_id'];
       $titulo = $linha['d_nome'];
	   $texto = $linha['d_txt'];
	   $contrato_de = $linha['d_tipo_contrato'];
	   $tipo_contrato = $linha['d_contrato'];
    }
}

if($_POST['altera']=='1') {
   if ($texto == "") {
      			echo('<script language="javascript">alert("Erro: O texto não pode estar vazio");document.location.href="cadastro_docs.php?cod_imob='.$cod_imob.'&id='.$d_id.'";</script>');
   } else {

			$d_id = $_POST['d_id'];
			$titulo = $_POST['titulo'];
  			$texto = $_POST['texto'];
  			$contrato_de = $_POST['contrato_de'];
  			$tipo_contrato = $_POST['tipo_contrato'];
  		 	$n_texto = str_replace("<STRONG>","<b>",$texto);
		 	$n_texto = str_replace("<strong>","<b>",$n_texto);
		 	$n_texto = str_replace("</STRONG>","</b>",$n_texto);
		 	$n_texto = str_replace("</strong>","</b>",$n_texto);
         	$n_texto = str_replace("<BR>","\n",$n_texto);
         	$n_texto = str_replace("<BR />","\n",$n_texto);
         	$n_texto = str_replace("<br>","\n",$n_texto);
         	$n_texto = str_replace("<br />","\n",$n_texto);

			$atualizacao = "UPDATE doc SET d_nome='".$titulo."', d_txt='".$n_texto."', d_tipo_contrato='".$contrato_de."', d_contrato='".$tipo_contrato."', d_data=current_date WHERE d_id='".$d_id."' AND cod_imobiliaria='".$cod_imob."'";
			if(mysql_query($atualizacao,$con))
   			{
   		    	echo('<script language="javascript">alert("Contrato alterado com sucesso!");document.location.href="cadastro_docs.php?cod_imob='.$cod_imob.'";</script>');
   			}
   			else
   			{
      			echo('<script language="javascript">alert("Erro ao alterar!");document.location.href="cadastro_docs.php?cod_imob='.$cod_imob.'";</script>');
   			}
   }
}

if($_GET['id_excluir']) { 
        
		$id_excluir = $_GET['id_excluir'];
		$d_cod = $_GET['d_cod'];
        
        $query4 = "SELECT * FROM muraski WHERE contrato='".$d_cod."' and cod_imobiliaria='".$cod_imob."'";
		$result4 = mysql_query($query4,$con) or die ("erro 241");
		$numrows4 = mysql_num_rows($result4);
		if($numrows4 > 0){
			echo('<script language="javascript">alert("Este contrato não pode ser apagado pois existem imóveis ligados a ele!");document.location.href="cadastro_docs.php?cod_imob='.$cod_imob.'";</script>');		  
		}else{
        
   			$exclusao = "DELETE FROM doc WHERE d_id='".$id_excluir."' AND cod_imobiliaria='".$cod_imob."'";
   			if(mysql_query($exclusao,$con))
   			{
   		    	echo('<script language="javascript">alert("Contrato excluído com sucesso!");document.location.href="cadastro_docs.php?cod_imob='.$cod_imob.'";</script>');
   			} else {
      			echo('<script language="javascript">alert("Erro ao excluir!");document.location.href="cadastro_docs.php?cod_imob='.$cod_imob.'";</script>');
   			}
   		}
}
	  
?>
</p>
 <form id="form1" name="form1" method="post" action="cadastro_docs.php">
   <input type="hidden" name="d_id" id="d_id" value="<? echo($d_id); ?>">
    <input type="hidden" name="cod_imob" id="cod_imob" value="<? echo($cod_imob); ?>">
   <table width="800" border="0" align="center" cellpadding="1" cellspacing="1">
     <tr>
       <td colspan="2" class="style1"><div align="center"><b>Documentos</b><br />
       </div></td>
     </tr>
     <tr>
       <td class="style1"><b>Título:</b></td>
       <td class="style1"><input type="text" name="titulo" id="titulo" size="60" class="campo" value="<?=$titulo ?>"></td>
     </tr>
      <tr>
       <td class="style1" valign="top"><b>Texto:</b></td>
<?
$n_texto = str_replace("\n","<BR>",$texto);
?>

       <td class="style1"><textarea name="texto" id="texto" cols="60" rows="10" class="campo"><?=$n_texto?></textarea></td>
     </tr>
      <tr>
        <td><b>Contrato de:</b></td>
        <td><select name="contrato_de" id="contrato_de" class="campo">
          <option value="0">Selecione</option>
          <option value="V" <? if($contrato_de=='V'){ echo "SELECTED"; } ?>>Venda</option>
          <option value="L" <? if($contrato_de=='L'){ echo "SELECTED"; } ?>>Loca&ccedil;&atilde;o</option>
        </select></td>
      </tr>
       <tr>
        <td><b>Tipo Contrato:</b></td>
        <td><select name="tipo_contrato" id="tipo_contrato" class="campo">
          <option value="0">Selecione</option>
          <option value="Residencial" <? if($tipo_contrato=='Residencial'){ print "SELECTED"; } ?>>Residencial</option>
          <option value="Comercial" <? if($tipo_contrato=='Comercial'){ print "SELECTED"; } ?>>Comercial</option>
          <option value="Não Residencial" <? if($tipo_contrato=='Não Residencial'){ print "SELECTED"; } ?>>Não Residencial</option>
        </select></td>
      </tr>
      <tr>
       <td>&nbsp;</td>
       <td><? 
	  	if(empty($d_id))
	  	{
		   echo(" 
          		<input type=\"hidden\" name=\"cadastra\" id=\"cadastra\" value=\"0\">
          		<input type=\"button\" name=\"incluir\" id=\"incluir\" class=\"campo\" value=\"Incluir\" Onclick=\"VerificaCampo();\">
          		<input type=\"button\" name=\"limpar\" id=\"limpar\" class=\"campo\" value=\"Limpar\" Onclick=\"window.location.href='cadastro_docs.php?cod_imob=".$cod_imob."'\">
           ");
		}
		else
		{
		  echo("         
          		<input type=\"hidden\" name=\"altera\" id=\"altera\" value=\"0\">
		  		<input type=\"button\" name=\"alterar\" id=\"alterar\" class=\"campo\" value=\"Alterar\" Onclick=\"VerificaCampo2();\">			
		  		<input type=\"button\" name=\"cancelar\" id=\"cancelar\" class=\"campo\" value=\"Cancelar\" Onclick=\"window.location.href='cadastro_docs.php?cod_imob=".$cod_imob."'\">
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
             <td width="35%" class="TdSubTitulo"><b>T&iacute;tulo</b></td>
             <td width="15%" class="TdSubTitulo"><b>Data</b></td>
             <td width="21%" class="TdSubTitulo"><b>Contrato de</b></td>
             <td width="15%" class="TdSubTitulo"><div align="center"><b>Altera&ccedil;&atilde;o</b></div></td>
             <td width="14%" class="TdSubTitulo"><div align="center"><b>Exclus&atilde;o</b></div></td>
           </tr>
           <?
            $busca2 = "SELECT d_id, d_nome, d_data, d_tipo_contrato, d_cod FROM doc WHERE cod_imobiliaria='".$cod_imob."' ORDER BY d_nome ASC";
            $sql = mysql_query($busca2,$con) or die ("erro 331");
     		if(mysql_num_rows($sql) > 0){
	 			while($linha2 = mysql_fetch_array($sql)){
				   if($linha2['d_tipo_contrato']=='V'){
				      $contr = "Venda";
				   }elseif($linha2['d_tipo_contrato']=='L'){
				      $contr = "Locação";
				   }else{
				      $contr = "";
					}			  
      				echo('
	        			<tr>
            				<td class="style1">'.$linha2['d_nome'].'</td>
            				<td class="style1">'.formataDataDoBd($linha2['d_data']).'</td>
							<td class="style1">'.$contr.'</td>
            				<td class="style1"><div align="center"><a href="cadastro_docs.php?id='.$linha2['d_id'].'&cod_imob='.$cod_imob.'" class="style1">Alterar</a></div></td>
            				<td class="style1"><div align="center"><a href="javascript:confirmaExclusao('.$linha2['d_id'].','.$cod_imob.','.$linha2['d_cod'].')" class="style1">Excluir</a></div></td>
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
	  <tr>
      <td colspan="2">
      <p align="center"><a href="javascript:history.back()" class=style2><< Voltar <<</a></p></td>
    </tr>
   </table>
 </form>
 <?php
include("carimbo.php");
mysql_close($con);
?>
</td></tr>
</table>
</body>
</html>