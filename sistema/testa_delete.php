<?

         $xml_apaga = "http://201.15.46.77:8160/intranet/sistema/xml_apagar.php";
         $ap = curl_init($xml_apaga);
         curl_setopt($ap, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ap, CURLOPT_HEADER, 0);
         $apagar = curl_exec($ap);
         curl_close($ap);
         $apaga_refs = simplexml_load_string($apagar);
         if ($apaga_refs <> "") {
            foreach ($apaga_refs -> ref as $referencias) {
               $dsql = "DELETE FROM muraski WHERE cod_imobiliaria = '3' AND ref = '$referencias'";
               mysql_query($dsql);
            }
         }

?>