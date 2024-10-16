<script language="javascript">
function nextmes(mes,ano)
{
	document.form1.nextmesano.value = mes + "/" + ano;
	document.form1.submit();
}
function prevmes(mes,ano)
{
	document.form1.nextmesano.value = mes + "/" + ano;
	document.form1.submit();
}
</script>
<?
function calendario ($datas, $mesano, $dtpermitida, $shownextprev)
{
	## inicia calendario com o mes, ano de entrada
	list ($mini,$yini) = split('[/.-]',$mesano);
	$mes = $mini;
	$ano = $yini;

	if (empty($mes)) {
		$mes = date("m");
	}

	$dia2 = date("d");
	$mesext = extensomes($mes);

	$next = mktime(0,0,0,$mes + 1,1,$ano);
	$nextano = date("Y",$next);
	$nextmes = date("m",$next);

	$prev = mktime(0,0,0,$mes - 1,1,$ano);
	$prevano = date("Y",$prev);
	$prevmes = date("m",$prev);

	$d = mktime(0,0,0,$mes,1,$ano);
	$diaSem = date('w',$d);
?>

<table bgcolor="#DCE0E4" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr> 
    <td width="20">
    </td>
    <td colspan="5" bgcolor="#EDEEEE"><div align="center"><font size="1" face="Arial"><?= $mesext." / ". $ano?></font></div></td>
    <td width="20">
    </td>
  </tr>
  <tr> 
    <td width="20">
    </td>
<?
	if ($shownextprev) {
?>
    <td colspan="5" bgcolor="#EDEEEE"><div align="center"><font size="1" face="Arial"><a href="javascript:prevmes(<?=$prevmes?>,<?=$prevano?>);"><< Anterior</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:nextmes(<?=$nextmes?>,<?=$nextano?>);">Próximo >></a></font></div></td>
    <td width="20">
    </td>
<?
	}
?>
  </tr>
  <tr bgcolor="#ffffff"> 
    <td width="20">
      <div align="center" class="style1">D</div>
    </td>
    <td width="20" class="style1"><div align="center">S</div></td>
    <td width="20" class="style1"><div align="center">T</div></td>
    <td width="20" class="style1"><div align="center">Q</div></td>
    <td width="20" class="style1"><div align="center">Q</div></td>
    <td width="20" class="style1"><div align="center">S</div></td>
    <td width="20" class="style1"><div align="center">S</div></td>
  </tr>
  <?  
	//Enquanto hover dias 
	echo "<tr>";
// Coloca os dias em Branco
for($i = 0; $i < $diaSem; $i++)
{
	echo "<td width=20>&nbsp;</td>";
}	
	

$diastomark = array();
$inicia = array();
### faz loop do periodo da locacao
#print "conta = " . ((count($datas)/2)+1);
for ($j = 0; $j <= count($datas); $j++) {
        list ($ed,$em,$ey) = split("/",$datas[$j]);
	
	##print "data entrada = $datas[$j]<br>";
	    settype($em, "integer");
	    settype($ed, "integer");
	    settype($ey, "integer");
        $Edata = mktime(0,0,0,$em,$ed,$ey);
        array_push ($inicia, "$Edata");
        //print_r($inicia);
        $j++;

        list ($sd,$sm,$sy) = split("/",$datas[$j]);
	$dtsaida = "$sd/$sm/$sy";
	#print "data saida = $datas[$j]<br>";
	    settype($sm, "integer"); 
	    settype($sd, "integer"); 
	    settype($sy, "integer"); 
        $Sdata = mktime(0,0,0,$sm,$sd,$sy);

	$dif = (($Sdata - $Edata)/86400);
	$dif++;
	$dmark = $ed;
	$mmark = $em;
	$ymark = $ey;
	for ($dj = 0; $dj <= $dif; $dj++) {

		if (strlen($dmark) == 1) {
			$dmark = "0$dmark";
		}
		if (strlen($mmark) == 1) {
                        $mmark = "0$mmark";
                }

		$dtmark = "$dmark/$mmark/$ymark";
		##print "$dtmark<br>";
		array_push ($diastomark, "$dtmark");
			
		$dmark++;
		if ($dmark > lastdaymonth($mmark,$ymark)) {
			$dmark = 1;
			$mmark++;
		}
		if ($mmark > 12) {
			$mmark = 1;
			$ymark++;
		}
		if ($dtmark == $dtsaida) {
			break;
		}
	}
}

$diastoperm = array();
for ($jp = 0; $jp <= count($dtpermitida); $jp++) {
	list ($pid, $pim, $piy) = split("/",$dtpermitida[$jp]);
	settype($pim, "integer"); 
	settype($pid, "integer"); 
	settype($piy, "integer"); 
	$dtpini = mktime(0,0,0,$pim,$pid,$piy);
	$jp++;
	list ($psd, $psm, $psy) = split("/",$dtpermitida[$jp]);
	$pdtsaida = "$psd/$psm/$psy";
        settype($psm, "integer"); 
        settype($psd, "integer"); 
        settype($psy, "integer"); 
		$dtpfim = mktime(0,0,0,$psm,$psd,$psy);


	$pdif = (($dtpfim - $dtpini)/86400);
	$pdif++;
	$pdmark = $pid;
	$pmmark = $pim;
	$pymark = $piy;
	for ($pdj = 0; $pdj <= $pdif; $pdj++) {

		if (strlen($pdmark) == 1) {
			$pdmark = "0$pdmark";
		}
		if (strlen($pmmark) == 1) {
                        $pmmark = "0$pmmark";
                }

		$pdtmark = "$pdmark/$pmmark/$pymark";
		array_push ($diastoperm, "$pdtmark");
		
		$pdmark++;
		if ($pdmark > lastdaymonth($pmmark,$pymark)) {
			$pdmark = 1;
			$pmmark++;
		}
		if ($pmmark > 12) {
			$pmmark = 1;
			$pymark++;
		}
		if ($pdtmark == $pdtsaida) {
			break;
		}
	}

}
### loop dos dias do mes
for($i = 2; $i < 33; $i++)
{
	$dia = date('d',$d);
        $dt = date('d/m/Y',$d);
        list ($entd,$entm,$enty) = split("/",$dt);
        settype($entm, "integer");
        settype($entd, "integer"); 
        settype($enty, "integer"); 
        $entrada1 = mktime(0,0,0,$entm,$entd,$enty);
        //print "$Edata - $entrada - $entrada1";
        //$inicia2 = array($entrada);
        //print_r($inicia2);
        
        $entrada = array_search("$entrada1", $inicia);
        //$entrada2 = array_search("$Edata", $inicia);
	
	$existe = array_search("$dt", $diastomark);
	#print "existe = $dt - $existe<br>";
	$existeperm = array_search("$dt", $diastoperm);
	
        list ($entd1,$entm1,$enty1) = split("/",$diastomark[0]);
        settype($entm1, "integer"); 
        settype($entd1, "integer"); 
        settype($enty1, "integer"); 
		$entrada2 = mktime(0,0,0,$entm1,$entd1,$enty1);

	### se dia está locado
        if ("$existe" != "")  {
        	if($entrada == ""){
        	if($entrada1 != $entrada2){
        	echo "<td bgcolor=#999999><div align=center class=style1>".$dia."</div></td>";
	        }else{
		echo "<td bgcolor=#EDEEEE><div align=center class=style1>".$dia."</div></td>";
		}
		}else{
	        //if($entrada1 != ""){
        	//echo "<td bgcolor=#96B5C9><div align=center><font size=1 face=Arial>".$dia."</font></div></td>";
	        //}else{
		echo "<td bgcolor=#EDEEEE><div align=center class=style1>".$dia."</div></td>";
		//}
		}
                $temdata = 1;

	### se dia não está locado, mas pode ser locado
	} elseif ("$existeperm" != "") {
		echo "<td bgcolor=#CCCCCC><div align=center class=style1>".$dia."</div></td>";
	
        } else {
               	echo "<td><div align=center class=style1>".$dia."</div></td>";
        }

        // Se Sábado desce uma linha

        if (date('w',$d) == 6){ echo "</tr>"; }

        $d = mktime(0,0,0,$mes ,$i, $ano);
        if(date('d',$d) == "01") { break; }

}



#$diaini = 2;
#$temdata = 0;
### faz loop do periodo da locacao
#for ($j = 0; $j <= (count($datas)/2); $j++) {
#	print "datas = $datas[$j]";
#	list ($ed,$em,$ey) = split("/",$datas[$j]);
#	$Edata = mktime(0,0,0,$em,$ed,$ey);
#	$j++;
#
#	print "\ndatas2 = $datas[$j]";
#	list ($sd,$sm,$sy) = split("/",$datas[$j]);
#        $Sdata = mktime(0,0,0,$sm,$sd,$sy);
#
#	if ($em == $mini or $sm == $mini) {
#	   ## loop dos dias do mes	
#		print "-- $diaini";
#	   for($i = $diaini; $i < 33; $i++)
#	   {
#		$dia = date('d',$d);
#		print "#dia = $i#";
#		#$Adata = date('d/m/Y',$d);
#		$dt = date('d/m/Y',$d);
#		$Adata = $d;
#		if ($Adata >= $Edata and $Adata <= $Sdata) {
#			echo "<td bgcolor=#EDEEEE><div align=center><font size=1 face=Arial>".$dia."</font></div></td>";
#			$temdata = 1;
#		} else {
#			echo "<td><div align=center><font size=1 face=Arial>".$dia."</font></div></td>";
#		}
#	
#		// Se Sábado desce uma linha
#	
#		if (date('w',$d) == 6){	echo "</tr>"; }
#	
#		$d = mktime(0,0,0,$mes ,$i, $ano);
#		if(date('d',$d) == "01") { break; }
#	
#		if ($Adata == $Sdata) {
#			list ($diaini,$m,$y) = split("/",$dt);
#			$diaini++;
#			$diaini++;
#			print "### $diaini";
#			break;		
#		}
#	  } 
#	}
#}

### se não existem datas marcadas para o mês
### monta calendario simples
#if (!$temdata) {
#
#for($i = 2; $i < 33; $i++)
#{
#	$dia = date('d',$d);
#	echo "<td><div align=center><font size=1 face=Arial>".$dia."</font></div></td>";
#	// Se Sábado desce uma linha
#	
#	if (date('w',$d) == 6){	echo "</tr>"; }
#
#	$d = mktime(0,0,0,$mes ,$i, $ano);
#	if(date('d',$d) == "01") { break; }
#}
#
#}
?>
</table>
<?
} ## fim funcao

function extensomes($mes) {

	switch($mes)
	{
		case "01" : $mesext = "Janeiro";	 break;
		case "02" : $mesext = "Fevereiro";	 break;
		case "03" : $mesext = "Março";		 break;
		case "04" : $mesext = "Abril";		 break;
		case "05" : $mesext = "Maio";		 break;
		case "06" : $mesext = "Junho";		 break;
		case "07" : $mesext = "Julho";		 break;
		case "08" : $mesext = "Agosto";		 break;
		case "09" : $mesext = "Setembro";	 break;
		case "10" : $mesext = "Outubro";	 break;
		case "11" : $mesext = "Novembro";	 break;
		case "12" : $mesext = "Dezembro";	 break;
	}

	return $mesext;
}
function lastdaymonth($mes,$year) {

	$bi = "28";
	$resto = ($year % 4);
	if ($resto == 0) {
		$bi = "29";	
	}

	switch($mes)
	{
		case "01" : $lastday = "31"; break;
		case "02" : $lastday = $bi; break;
		case "03" : $lastday = "31"; break;
		case "04" : $lastday = "30"; break;
		case "05" : $lastday = "31"; break;
		case "06" : $lastday = "30"; break;
		case "07" : $lastday = "31"; break;
		case "08" : $lastday = "31"; break;
		case "09" : $lastday = "30"; break;
		case "10" : $lastday = "31"; break;
		case "11" : $lastday = "30"; break;
		case "12" : $lastday = "31"; break;
	}
	return $lastday;
}
?>
