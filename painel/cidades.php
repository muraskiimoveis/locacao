<?
include("conect.php");        
?>
  <select name="im_cidade" id="im_cidade" class="campo"> 
   <option value="0">Selecione</option>
    <?
    $bcidades = "SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado = '".$_GET['estado']."' ORDER BY ci_nome ASC";
    $sql = mysql_query($bcidades,$con) or die ("erro 8");
 	while($linha = mysql_fetch_array($sql)){
			if($linha[ci_cod]==$_POST['im_cidade']){
			   echo('<option value="'.$linha[ci_cod].'" SELECTED>'.$linha['ci_nome'].'</option>'); 
			}else{ 			   
				echo('<option value="'.$linha[ci_cod].'">'.$linha['ci_nome'].'</option>');
			}
	}
	?>
   </select>

