<?
require "conect.php";

$sql = "SELECT data_inicio, data_fim, dist_tipo, disponibilizar, ref FROM muraski
   WHERE cod_imobiliaria = '3' and disponibilizar = '1'
   and ref <> 'x' and caracteristica <> ''";
//echo "<pre>".$sql."</pre><BR><BR>";
$rs = mysql_query($sql) or die ("ops 3 - " . mysql_error());
echo mysql_num_rows($rs) . " Resultados: <BR><BR>";
$total = mysql_num_rows($rs);
$i = 0;
$quebra = 100;
echo "Resultados de " . $i+1 . " à ".($i+$quebra-1)."<BR> <textarea rows=15 cols=81>";

while ($not = mysql_fetch_assoc($rs)) {
//echo "oi";

   if ($not[data_inicio] <> "") {
      $i++;
      if ($i % $quebra == 0 && $i > 1) {
         echo "</textarea><BR><BR>\n";
         if ($i + $quebra > $total) {
            echo "Resultados de " . $i . " à ".($total)."<BR>\n";
         } else {
            echo "Resultados de " . $i . " à ".($i+$quebra-1)."<BR>\n";
         }
         echo "<textarea rows=15 cols=81>\n";
      }

      $update = "UPDATE muraski SET data_inicio = '".$not[data_inicio]."', data_fim = '".$not[data_fim]."',
         dist_tipo = '".$not[dist_tipo]."', disponibilizar = '".$not[disponibilizar]."' WHERE
         cod_imobiliaria = '3' and ref = '".$not[ref]."';";
      echo $update."\n";
   }
}
//echo "</textarea>";

?>