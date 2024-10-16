<?
/*
ini_set('max_execution_time','90');
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
*/
   set_time_limit(0);
   session_start();

   require "conect.php";
   //include("funcoes/funcoes.php");

   header ("content-type: text/xml");
   print "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n";
   print "<apagar>\n\r";

   $sql = "SELECT a_ref, a_data, a_hora FROM atualizacoes WHERE a_acao LIKE '%Apagar Imóvel%' ORDER BY a_data, a_hora";
   $rs = mysql_query($sql);
   while ($not = mysql_fetch_assoc($rs)) {
      $vsql = "SELECT * FROM atualizacoes WHERE a_ref = '".$not[a_ref]."' AND a_acao = 'Inserir Imóvel' AND (a_data > '".$not[a_data]."' OR (a_data = '".$not[a_data]."' AND a_hora > '".$not[a_hora]."'))";
      $vrs = mysql_query($vsql);
      if (mysql_num_rows($vrs) == 0) {
         print "<ref>".$not[a_ref]."</ref>\n\r";
      }
   }
   print "</apagar>\r";
?>
