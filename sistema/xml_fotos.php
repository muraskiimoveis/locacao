<?php
set_time_limit(0);
session_start();

include_once "conect.php";

$ip_muraski = "200.195.158.202";
$cod_imobiliaria = "3";
$pasta_imobiliaria = "murask";

# Diretórios onde serão extraídas as imagens.
print "<BR>Inicio em: ".date("d/m/Y - H:i:s")."<BR>";
$loca = "../imobiliarias/murask/locacao/";
$venda = "../imobiliarias/murask/venda/";
$contador = 0;
$busca_imovel = "select cod, ref, finalidade from muraski where ref<>'x' and ref<>'' and cod_imobiliaria='3' order by cod";
$rbusca = mysql_query($busca_imovel) or die ("Erro 225 - " . mysql_error());
if (mysql_num_rows($rbusca) > 0) {
       while ($nv = mysql_fetch_assoc($rbusca)) {
              $contador = $contador+1;
              print "Contando.. ".$contador."<br>";
              $cod_imovel = $nv['cod'];
              $ref = $nv['ref'];
		$posicao = array("1","2","3","4","5","6","7");
		$final = $nv['finalidade'];
              //print " Finalidade ==> ".$ref."  --  ".$final."<br>";
		if (in_array($final,$posicao)) { 
			if($abre = opendir($venda)) {
				print "Pasta         ==> ".$venda."<br>";
				while (false !== ($arquivo = readdir($abre))) {
					if (strpos("--".$arquivo, "-".$ref."_")){
						print "Arquivo         => ".$arquivo."<br>";
						$sequencia = str_replace("_","",str_replace(".","",trim(substr($arquivo,strpos($arquivo,"_")+1,2))));
						print "Sequencia ==> ".$sequencia."<br>";
						$sql_pesq = "  cod =".$cod_imovel." and ref = '".$ref."' and sequencia ='".$sequencia."'";
						$sql_busca ="select idfoto from fotos where ".$sql_pesq; 
						$rsbusca = mysql_query($sql_busca) or die ("Erro 225 - " . mysql_error());
						if (mysql_num_rows($rsbusca) <= 0) {
							$sql_into = "INSERT INTO fotos SET cod=".$cod_imovel.", ref='".$ref."', pasta ='".$venda."', sequencia='".$sequencia."', site='S'";
							mysql_query($sql_into) or die ("Erro 258 - " . mysql_error());	   
						}
					}
				}
				closedir($abre);   
			}
		}
		else 
		{ 
			if($abre = opendir($loca)) {
				print "Pasta         ==> ".$loca."<br>";
				while (false !== ($arquivo = readdir($abre))) {
					if (strpos("--".$arquivo, "-".$ref."_")){
						print "Arquivo         => ".$arquivo."<br>";
						$sequencia = str_replace("_","",str_replace(".","",trim(substr($arquivo,strpos($arquivo,"_")+1,2))));
						print "Sequencia ==> ".$sequencia."<br>";
						$sql_pesq = "  cod =".$cod_imovel." and ref = '".$ref."' and sequencia ='".$sequencia."'";
						$sql_busca ="select idfoto from fotos where ".$sql_pesq; 
						$rsbusca = mysql_query($sql_busca) or die ("Erro 225 - " . mysql_error());
						if (mysql_num_rows($rsbusca) <= 0) {
							$sql_into = "INSERT INTO fotos SET cod=".$cod_imovel.", ref='".$ref."', pasta ='".$loca."', sequencia='".$sequencia."', site='S'";
							mysql_query($sql_into) or die ("Erro 258 - " . mysql_error());	   
						}
					}
				}
				closedir($abre);
			}
		}			
       }
}
print "<BR>Finalizado em: ".date("d/m/Y - H:i:s")."<BR>";

?>
