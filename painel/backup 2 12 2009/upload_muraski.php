<?php
set_time_limit(0);
//ini_set('max_execution_time','5000');

if ($ok == "") {
?>
<center>
Pressione OK para começar!!!<BR /><BR />
<form action="<?=$PHP_SELF?>" method="POST">
<input type="submit" name="ok" value="1" />
</form>
</center>

<?
} else {
//Teste para atualização da tabela "muraski"

$h = "localhost";
$u = "root";
$p = "pyc89w";

//muraski
$db1 = "test";
//rebri
$db2 = "Sistema";

$muraski = mysql_connect($h,$u,$p) or die ("Erro 27 - ".mysql_error());
mysql_select_db($db1,$muraski) or die ("Ops 28 - ".mysql_error());

$rebri = mysql_connect($h,$u,$p) or die("Erro 30 - ".mysql_error());
mysql_select_db($db2,$rebri);

/*
$sql3 = "DROP TABLE IF EXISTS `muraski`;
CREATE TABLE `muraski` (
  `cod` int(11) NOT NULL auto_increment,
  `ref` varchar(6) NOT NULL default '',
  `tipo` varchar(50) NOT NULL default '',
  `metragem` double(10,2) unsigned default NULL,
  `n_quartos` tinyint(3) unsigned default NULL,
  `valor` double(10,2) unsigned default NULL,
  `especificacao` varchar(10) default NULL,
  `suites` tinyint(3) unsigned default NULL,
  `piscina` varchar(7) default NULL,
  `titulo` text NOT NULL,
  `descricao` text NOT NULL,
  `img_peq` varchar(23) default NULL,
  `img_1` varchar(20) default NULL,
  `img_2` varchar(20) default NULL,
  `img_3` varchar(20) default NULL,
  `img_4` varchar(20) default NULL,
  `img_5` varchar(20) default NULL,
  `img_6` varchar(20) default NULL,
  `img_7` varchar(20) default NULL,
  `img_8` varchar(20) default NULL,
  `img_9` varchar(20) default NULL,
  `img_10` varchar(20) default NULL,
  `local` varchar(40) default NULL,
  `permuta` varchar(7) default NULL,
  `finalidade` varchar(50) NOT NULL default '',
  `permuta_txt` text,
  `ftxt_1` varchar(50) default NULL,
  `ftxt_2` varchar(50) default NULL,
  `ftxt_3` varchar(50) default NULL,
  `ftxt_4` varchar(50) default NULL,
  `ftxt_5` varchar(50) default NULL,
  `ftxt_6` varchar(50) default NULL,
  `ftxt_7` varchar(50) default NULL,
  `ftxt_8` varchar(50) default NULL,
  `ftxt_9` varchar(50) default NULL,
  `ftxt_10` varchar(50) default NULL,
  `ftxt_11` varchar(50) default NULL,
  `ftxt_12` varchar(50) default NULL,
  `ftxt_13` varchar(50) default NULL,
  `ftxt_14` varchar(50) default NULL,
  `ftxt_15` varchar(50) default NULL,
  `ftxt_16` varchar(50) default NULL,
  `ftxt_17` varchar(50) default NULL,
  `ftxt_18` varchar(50) default NULL,
  `ftxt_19` varchar(50) default NULL,
  `ftxt_20` varchar(50) default NULL,
  `cliente` int(5) default NULL,
  `matricula` varchar(10) default NULL,
  `cidade_mat` varchar(40) default NULL,
  `end` varchar(200) default NULL,
  `averbacao` double(10,2) default NULL,
  `acomod` tinyint(2) NOT NULL default '0',
  `dist_mar` int(4) NOT NULL default '0',
  `dist_tipo` varchar(40) default NULL,
  `limpeza` double(5,2) default NULL,
  `diaria1` double(10,2) default NULL,
  `diaria2` double(10,2) default NULL,
  `data_inicio` date default NULL,
  `data_fim` date default NULL,
  `comissao` int(11) NOT NULL default '0',
  `dias` int(5) default NULL,
  `carnaval` double(10,2) default NULL,
  `anonovo` double(10,2) default NULL,
  `posx` int(6) unsigned default NULL,
  `posy` int(6) unsigned default NULL,
  `tv` double(10,2) default NULL,
  `angariador` varchar(50) NOT NULL default '',
  `zelador` varchar(200) default NULL,
  `tipo_anga` varchar(50) NOT NULL default '',
  `chaves` text,
  `tipo_div` varchar(200) default NULL,
  `valor_oferta` double(20,2) default NULL,
  `relacao_bens` text NOT NULL,
  PRIMARY KEY  (`cod`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3830";

//Apaga e recria o Muraski
$result3 = mysql_query($sql3, $rebri) or die ("Ops 96 ".mysql_error());
*/

$sql1 = "SELECT * FROM muraski LIMIT 10";
$result1 = mysql_query($sql1, $muraski) or die ("ops 21 - ".mysql_error());
//$campos = mysql_num_fields($result1);
//$monta = "";
echo $sql1."<BR>";
echo mysql_num_rows($result1);
$total = 0;

while ($not1 = mysql_fetch_array($result1)) {
   print_r ($not1);
   print "<BR>";
   $sql2 = "INSERT INTO muraski VALUES ('$not1[0]', '$not1[1]', '$not1[2]', '$not1[3]', '$not1[4]', '$not1[5]', '$not1[6]', '$not1[7]', '$not1[8]', '$not1[9]', '$not1[10]', '$not1[11]', '$not1[12]', '$not1[13]', '$not1[14]', '$not1[15]', '$not1[16]', '$not1[17]', '$not1[18]', '$not1[19]', '$not1[20]', '$not1[21]', '$not1[22]', '$not1[23]', '$not1[24]', '$not1[25]', '$not1[26]', '$not1[27]', '$not1[28]', '$not1[29]', '$not1[30]', '$not1[31]', '$not1[32]', '$not1[33]', '$not1[34]', '$not1[35]', '$not1[36]', '$not1[37]', '$not1[38]', '$not1[39]', '$not1[40]', '$not1[41]', '$not1[42]', '$not1[43]', '$not1[44]', '$not1[45]', '$not1[46]', '$not1[47]', '$not1[48]', '$not1[49]', '$not1[50]', '$not1[51]', '$not1[52]', '$not1[53]', '$not1[54]', '$not1[55]', '$not1[56]', '$not1[57]', '$not1[58]', '$not1[59]', '$not1[60]', '$not1[61]', '$not1[62]', '$not1[63]', '$not1[64]', '$not1[65]', '$not1[66]', '$not1[67]', '$not1[68]', '$not1[69]', '$not1[70]', '$not1[71]', '$not1[72]', '$not1[73]', '$not1[74]', '$not1[75]', '$not1[76]', '$not1[77]', '$not1[78]', '$not1[79]', '$not1[80]', '$not1[81]', '$not1[82]', '$not1[83]', '$not1[84]', '$not1[85]', '$not1[86]', '$not1[87]', '$not1[88]', '$not1[89]', '$not1[90]', '$not1[91]', '$not1[92]', '$not1[93]', '$not1[94]', '$not1[95]', '$not1[96]', '$not1[97]', '$not1[98]', '$not1[99]', '$not1[100]', '$not1[101]', '$not1[102]', '$not1[103]', '$not1[104]', '$not1[105]', '$not1[106]', '$not1[107]', '$not1[108]', '$not1[109]', '$not1[110]', '$not1[111]', '$not1[112]', '$not1[0]', '$not1[1]', '$not1[2]', '$not1[3]', '$not1[4]', '$not1[5]', '$not1[6]', '$not1[7]', '$not1[8]', '$not1[9]', '$not1[10]', '$not1[11]', '$not1[12]', '$not1[13]', '$not1[14]', '$not1[15]', '$not1[16]', '$not1[17]', '$not1[18]', '$not1[19]', '$not1[20]', '$not1[21]', '$not1[22]', '$not1[23]', '$not1[24]', '$not1[25]', '$not1[26]', '$not1[27]', '$not1[28]', '$not1[29]', '$not1[30]', '$not1[31]', '$not1[32]', '$not1[33]', '$not1[34]', '$not1[35]', '$not1[36]', '$not1[37]', '$not1[38]', '$not1[39]', '$not1[40]', '$not1[41]', '$not1[42]', '$not1[43]', '$not1[44]', '$not1[45]', '$not1[46]', '$not1[47]', '$not1[48]', '$not1[49]', '$not1[50]', '$not1[51]', '$not1[52]', '$not1[53]', '$not1[54]', '$not1[55]', '$not1[56]', '$not1[57]', '$not1[58]', '$not1[59]', '$not1[60]', '$not1[61]', '$not1[62]', '$not1[63]', '$not1[64]', '$not1[65]', '$not1[66]', '$not1[67]', '$not1[68]', '$not1[69]', '$not1[70]', '$not1[71]', '$not1[72]')";

   echo $sql2."<BR>";


/*   if (mysql_query($sql2,$rebri)) {
      echo "ok<BR>";
      if ($i%2==0) {
		   echo $total." OK!!! <BR> ";
      }
      $total++;
   } else {
      echo "erro<BR>";
	   $arr_err[] = $not1[0];
   }
*/

}
   print $total." inseridos com sucesso <BR><BR>";
   print "<pre>";
   print_r ($arr_err);
   print "</pre>";

}

?>
