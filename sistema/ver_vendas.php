<?
include "conect.php";
$sql = "SELECT cod, cod_imobiliaria, ref FROM muraski WHERE finalidade = '6'";
$rs = mysql_query($sql) or die ("Erro 3 - " . mysql_error());
echo mysql_num_rows($rs) . " Resultados encontrados <BR><BR> ";
while ($n = mysql_fetch_assoc($rs)) {
   $a_c_i = $n['cod_imobiliaria'];
   $a_usu = "81";
   $a_cod = $n['cod'];
   $a_ref = $n['ref'];
   $a_acao = "Atualizar Imóvel";
   $a_data = date("Y-m-d");
   $a_hora = date("H:i:s");

   $sql2 = "INSERT INTO atualizacoes (cod_imobiliaria, a_cod_user, a_imovel,
      a_ref, a_acao, a_data, a_hora) VALUES
      ('$a_c_i','$a_usu','$a_cod','$a_ref','$a_acao', '$a_data','$a_hora')";
   mysql_query($sql2) or die ("18 - Ops - ". mysql_error());
}
?>