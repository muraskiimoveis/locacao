<?php
   require_once('conect.php'); 

  $busca_bairros = mysql_query("SELECT * FROM rebri_bairros WHERE b_cidade='".$_GET['cidade']."' ORDER BY b_nome");
			while($linha = mysql_fetch_array($busca_bairros)){
?>			  
  <input type="checkbox" name="bairro[]" id="bairro" value="<?php echo($linha['b_cod']); ?>" <?php verifica_check("".$linha['b_cod']."", $bairro) ?>> <?= $linha['b_nome']; ?>
  <?
}
?>