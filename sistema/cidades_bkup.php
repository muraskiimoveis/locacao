<?
include("conect.php");
$pEstado = $_POST["estado"];
$sql = "SELECT ci_cod, ci_nome FROM rebri_cidades WHERE ci_estado = '$pEstado' ORDER BY ci_nome";
//echo $sql;
$sql = mysql_query($sql);
$row = mysql_num_rows($sql);    
if($row) { $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   $xml .= "<cidades>\n";               
   for($i=0; $i<$row; $i++) {  
    $codigo    = mysql_result($sql, $i, "ci_cod");
	  $descricao = mysql_result($sql, $i, "ci_nome");
      $xml .= "<cidade>\n";     
      $xml .= "<codigo>".$codigo."</codigo>\n";                  
      $xml .= "<descricao>".$descricao."</descricao>\n";         
      $xml .= "</cidade>\n";    }
      $xml.= "</cidades>\n";
      Header("Content-type: application/xml; charset=iso-8859-1"); }
echo $xml;            
?>
