<?php
require_once('conect.php');

/*
Estoril por Brejatuba
918 = 913
Jurimar por Cohapar
912 = 917
Praia Central por Centro
914 = 911
Praia do Cristo por Brejatuba
926 = 913
Villa Real por Centro
915 = 911
*/

$retira_bairros = "918 912 914 926 915";

$sql_bairros = "SELECT b_cod FROM rebri_bairros WHERE b_cidade = 6029 order by b_cidade,b_cod";
$sql_bairros_result = mysql_query($sql_bairros);
while($item = mysql_fetch_array($sql_bairros_result))
{
$codigo_bairro_montado = '-'.$item['b_cod'].'-';
$sql_busca_bairros = "SELECT cod,ref, bairro FROM muraski WHERE (TRIM(bairro) <> '') and (bairro like '%".$codigo_bairro_montado."%') order by ref";
$busca_bairros = mysql_query($sql_busca_bairros);
while($linha = mysql_fetch_array($busca_bairros))
{
          $cod_bairro = str_replace('--','|', $linha['bairro']);
          $cod_bairro = str_replace('-','|',$cod_bairro);
          $cod_bairro = explode('|',$cod_bairro);
          $qta=count($cod_bairro);
          $codigo = $linha['cod'];
          $refe = $linha['ref'];
          $bairro = $linha['bairro'];
          //echo "Imovel ==> ".$codigo." Referência ==> ".$refe." =Bairros= ".$bairro."<BR>";
          for($i=0;$i<$qta;$i++){
                if(($cod_bairro[$i]!='|') and is_numeric($cod_bairro[$i]))
                {
                    $cod_ele = substr($cod_bairro[$i],0,3);
                    //echo "Bairro[".$i."] ==> ".$cod_ele."<BR>";
                    if(strpos($retira_bairros,$cod_ele))
                    {
                        if($cod_ele == '918'){$novo_bairro = '-913-';}
                        if($cod_ele == '912'){$novo_bairro = '-917-';}
                        if($cod_ele == '914'){$novo_bairro = '-911-';}
                        if($cod_ele == '926'){$novo_bairro = '-913-';}
                        if($cod_ele == '915'){$novo_bairro = '-911-';}
                        $sql_update_bairros = "update muraski set bairro = '".$novo_bairro;
                        $sql_update_bairros .= "' where cod = ".$codigo." and ref = '".$refe."'";
                        mysql_query($sql_update_bairros) or die(mysql_error());
                        echo "Acertando nome de Bairros ==> ".$sql_update_bairros."<BR>";
                    }
                }
          }
}
}
$sql_acerta_bairros = "SELECT cod,ref, bairro FROM muraski WHERE TRIM(bairro) <> '' order by ref";
$acerta_bairros = mysql_query($sql_acerta_bairros);
while($sql_resultado = mysql_fetch_array($acerta_bairros))
{
          $cod_bairro2 = str_replace('--','|', $sql_resultado['bairro']);
          $cod_bairro2 = str_replace('-','|',$cod_bairro2);
          $cod_bairro2 = explode('|',$cod_bairro2);
          $qta2=count($cod_bairro2);
          $codigo2 = $sql_resultado['cod'];
          $refe2 = $sql_resultado['ref'];
          $bairro2 = $sql_resultado['bairro'];
          //echo "Imovel ==> ".$codigo2." Referência ==> ".$refe2." =Bairros= ".$bairro2."<BR>";
          for($j=0;$j<$qta2;$j++){
                  //echo "Atualizando ==> ".$cod_bairro2[$j]." ==> ".$j."<BR>";
                  if((strlen($cod_bairro2[$j]) == 3) and is_numeric($cod_bairro2[$j]) and ($j==1))
                  {
                    $cod_ele2 = $cod_bairro2[$j];
                    //echo "Bairro[".$i."] ==> ".$cod_ele2."<BR>";
                    
                    if($cod_ele2 == '918'){
                       $novo_bairro = '-913-';
                    }elseif($cod_ele2 == '912'){
                            $novo_bairro = '-917-';
                    }elseif($cod_ele2 == '914'){
                            $novo_bairro = '-911-';
                    }elseif($cod_ele2 == '926'){
                            $novo_bairro = '-913-';
                    }elseif($cod_ele2 == '915'){
                            $novo_bairro = '-911-';
                    }else{
                            $novo_bairro = '-'.$cod_ele2.'-';
                    }
                    
                    $sql_update_bairros2 = "update muraski set bairro = '".$novo_bairro;
                    $sql_update_bairros2 .= "' where cod = ".$codigo2." and ref = '".$refe2."'";
                    mysql_query($sql_update_bairros2) or die(mysql_error());
                    echo "Atualizando Somente UM bairro por imovel==> ".$sql_update_bairros2."<BR>";
                    
                  }
          }
}




?>