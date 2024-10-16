<?php
echo "xxxxx xxxxxxxxxxx xxxxxxxxxxxxxx xxxxxxxxxxxxxx xxxxxxxxxxxx xxxxxxxxx
   xxxxxxxx xxxxxxxxxxx xxxxxxxxxxxxxx xxxxxxxxxxxxxx xxxxxxxxxxxx xxxxxxxxx
   xxxxxxxx xxxxxxx ";


require "conect.php";

$sql = "select cod, cod_imobiliaria, ref, disponibilizar, disp_rede, destaque, destaque_padrao, lancamento FROM muraski WHERE destaque_padrao = '1'";

echo $sql;
$rs = mysql_query($sql) or die ("Erro 8 - " . mysql_error());
while ($not = mysql_fetch_assoc($rs)) {



   $cod = $not['cod'];
   $cod_imobiliaria = $not['cod_imobiliaria'];
   $ref = $not['ref'];
   $disponibilizar = $not['disponibilizar'];
   $disp_rede = $not['disp_rede'];
   $destaque = $not['destaque'];
   $destaque_padrao = $not['destaque_padrao'];
   $lancamento = $not['lancamento'];
   $data = date('Y-m-d');
   $hora = date('H:i:s');

   $sqlhistorico "INSERT INTO atualizacoes SET cod_imobiliaria = '$cod_imobiliaria'
      , a_cod_user = '35', a_imovel = '$cod', a_ref='$ref', a_acao='Atualizar Imóvel'
      , a_data = '$data', a_hora = '$hora'";
   echo $sqlhistorico . "<BR><BR>";
#   mysql_query($sqlhistorico) or die ("Erro 24 - " . mysql_error())

   $sqlupdate = "UPDATE muraski SET disponibilizar = '$disponibilizar',
   disp_rede = '$disp_rede', destaque = '$destaque', destaque_padrao =
   '$destaque_padrao', lancamento = '$lancamento' WHERE ref = '$ref'";
#   mysql_query($sqlupdate) or die ("Erro 28 - " . mysql_error())
   echo $sqlupdate . "<BR><BR>";
}

?>
