<?php
   require_once('conect.php'); 
?>
  <select name="im_cidade" id="im_cidade" class="campo"> 
   <option value="0">Selecione</option>
    <?
    $bcidades = mysql_query("SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado = '".$_GET['estado']."' ORDER BY ci_nome ASC");
 	while($linha = mysql_fetch_array($bcidades)){
			if($linha[ci_cod]==$_POST['im_cidade']){
			   echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
			}else{ 			   
				echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
			}
	}
	?>
   </select>

