<?
$nao_executar = "";
#Bloqueia o script permitindo que ele seja executado apenas a partir do arquivo de atualização.
#if (strstr($_SERVER[PHP_SELF], 'verifica_referencias.php')) { $nao_executar = 1; }

if ($nao_executar == "") {
   include_once "conect.php";

   $sql = "SELECT count(ref) as quantas, ref FROM muraski WHERE ref <> 'x' and cod_imobiliaria = '3' GROUP BY ref";
   $rs = mysql_query($sql) or die ("Erro 5 - " . mysql_error());
#   echo "Referências múltiplas excluídas: <BR><BR>\n";
   while ($n = mysql_fetch_assoc($rs)) {
      #echo $n[quantas]. "<BR>";
      if ($n[quantas ] > 1) {
#         echo $n[ref] . "<BR/>\n";
         $sql1 = "SELECT cod FROM muraski WHERE ref = '".$n[ref]."' and cod_imobiliaria = '3' LIMIT 1, " . $n[quantas];
         $rs1 = mysql_query($sql1) or die ("Erro 11 - " . mysql_error());
         while ($n1 = mysql_fetch_assoc($rs1)) {
            $sql2 = "DELETE FROM muraski WHERE cod = '".$n1[cod]."' AND cod_imobiliaria = '3'";
            mysql_query($sql2) or die ("Erro 14 - " . mysql_error());
         }
      }
   }
} else {
   print "Este script não pode ser executado diretamente";
}


?>