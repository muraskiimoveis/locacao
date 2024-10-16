<?php
    //Calcular idade
    function calc_idade($data_nasc) {
		$data_nasc=explode("/",$data_nasc);
		$data=date("d/m/Y");
		$data=explode("/",$data);
		$anos=$data[2]-$data_nasc[2];
		if ($data_nasc[1] > $data[1]) {
			return $anos-1;
		} 
		if ($data_nasc[1] == $data[1]) {
			if ($data_nasc[0] <= $data[0]) {
				return $anos;
				break;
			} else {
				return $anos-1;
				break;
			}
		} 
		if ($data_nasc[1] < $data[1]) {
			return $anos;
		}
	}
    
    // Formata data do banco para exibição, pega AAAA-MM-DD e transforma em DD/MM/AAAA.
    function retornaDataBD($data)
	{
		$explode = explode("-",$data);
		$monta_data = $explode[2]."/".$explode[1]."/".$explode[0];
		return $monta_data;
    }
    
    // Calcula diferença de meses
    function retornaDifMeses($datai, $dataf)
	{
		$data1 = $datai;
      $arr = explode('/',$data1);

      $data2 = $dataf;
      $arr2 = explode('/',$data2);

      $dia1 = $arr[0];
      $mes1 = $arr[1];
      $ano1 = $arr[2];

      $dia2 = $arr2[0];
      $mes2 = $arr2[1];
      $ano2 = $arr2[2];

      $a1 = ($ano2 - $ano1)*12;
      $m1 = (($mes2 - 1) - $mes1)+1;
      //$m1 = ($mes2 - $mes1)+1;
      $m3 = ($m1 + $a1);
      return $m3;
   } 

	// Formata data do banco para exibição, pega AAAA-MM-DD e transforma em DD/MM/AAAA.
    function formataDataDoBd($data)
    {
		$data_exp = explode("-", $data);
		$nova_data = $data_exp[2] . "/" . $data_exp[1] . "/" . $data_exp[0];
		return $nova_data;
	}
	
	// Formata data para gravação no banco, pega DD/MM/AAAA e transforma em AAAA-MM-DD.
	function formataDataParaBd($data)
	{
		$data_exp = explode("/", $data);
		$nova_data = $data_exp[2] . "-" . $data_exp[1] . "-" . $data_exp[0];
		return $nova_data;  
	}
	
	// Recebe um cep no formato XXXXX-XXX e retorna XXXXXXXX
	function formataCEPParaBd($cep)
	{
		$cep_q = explode("-", $cep);
		$cep_n = $cep_q[0] . $cep_q[1];
		return $cep_n;
	}

	// Recebe um cep no formato XXXXXXXX e retorna XXXXXX-XXX	
	function formataCEPDoBd($cep)
	{
		$cep_n = substr($cep, 0, 5) . "-" . substr($cep, -3);
		return $cep_n;
	}
	
	// Recebe um cpf no formato XXX.XXX.XXX-XX e retorna XXXXXXXXXXX
	function formataCPFParaBd($cpf)
	{
		$cpf_q1 = explode(".", $cpf);
		$cpf_q2 = explode("-", $cpf_q1[2]);
		$cpf_n = $cpf_q1[0] . $cpf_q1[1] . $cpf_q2[0] . $cpf_q2[1];
		return $cpf_n;
	}
	
	// Recebe um cpf no formato XXXXXXXXXXX e retorna XXX.XXX.XXX-XX
	function formataCPFDoBd($cpf)
	{
		$cpf_n = substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, -2);
		return $cpf_n;
	}
	
	// Recebe um telefone no formato (XX)XXXX-XXXX e retorna XXXXXXXXXX
	function formataTelefoneParaBd($telefone)
	{
		$telefone_n = substr($telefone, 1, 2) . substr($telefone, 4, 4) . substr($telefone, -4);
		return $telefone_n; 
	}
	
	// Recebe um telefone no formato XXXXXXXXXX e retorna (XX)XXXX-XXXX
	function formataTelefoneDoBd($telefone)
	{
		$telefone_n = "(" . substr($telefone, 0, 2) . ")" . substr($telefone, 2, 4) . "-" . substr($telefone, 6, 4);
		return $telefone_n;
	}
	
	// Recebe um telefone no formato XXXX-XXXX e retorna XXXXXXXX
	function formataTelefoneSemDddParaBd($telefone)
	{
		$telefone_n = substr($telefone, 0, 4) . substr($telefone, 5, 8);
		return $telefone_n; 
	}
	
	// Recebe um telefone no formato XXXXXXXX e retorna XXXX-XXXX
	function formataTelefoneSemDddDoBd($telefone)
	{
		$telefone_n = substr($telefone, 0, 4) . "-" . substr($telefone, 4, 8);
		return $telefone_n;
	}
	
	
	// Calcula a idade a partir da data de nascimento.
	function calculaIdade($data_nascimento)
	{
		$data_q = explode("-", $data_nascimento);
		$dia_nasc = $data_q[2];
		$mes_nasc = $data_q[1];
		$ano_nasc = $data_q[0];
		
		$dia_atual = date("d");
		$mes_atual = date("m");
		$ano_atual = date("Y");
		
		if($mes_nasc < $mes_atual)
			$idade = $ano_atual - $ano_nasc;
		else if($mes_nasc > $mes_atual)
			$idade = ($ano_atual - $ano_nasc) - 1;
		else if($mes_nasc == $mes_atual)
		{
			if($dia_nasc < $dia_atual)
				$idade = $ano_atual - $ano_nasc;
			else if($dia_nasc > $dia_atual)
				$idade = ($ano_atual - $ano_nasc) - 1;
			else if($dia_nasc == $dia_atual)
				$idade = $ano_atual - $ano_nasc;
		}
		return $idade;
	}
	
	// Retorna a hora no formato HH:MM
	function HoraSimples($hora)
	{
		$hora_q = explode(":", $hora);
		$hora_simples = $hora_q[0] . ":" . $hora_q[1];
		return $hora_simples;
	}
	
	// Retorna somente a hora no formato HH
	function SomenteHora($hora)
	{
		$hora_q = explode(":", $hora);
		return $hora_q[0];
	}
	
	// Retorna o nome do dia da semana
	function NomeDiaSemana($dia_semana)
	{
		switch($dia_semana)
		{
			case 1:
				$nome = "segunda";
				break;
			case 2:
				$nome = "terça";
				break;
			case 3:
				$nome = "quarta";
				break;
			case 4:
				$nome = "quinta";
				break;
			case 5:
				$nome = "sexta";
				break;
			case 6:
				$nome = "sábado";
				break;
			case 7:
				$nome = "domingo";
				break;
		}
		return $nome;
	}
	
	// Retorna o nome do mês
	function NomeMes($mes)
	{
		switch($mes)
		{
			case 1:
				$nome = "janeiro";
				break;
			case 2:
				$nome = "fevereiro";
				break;
			case 3:
				$nome = "março";
				break;
			case 4:
				$nome = "abril";
				break;
			case 5:
				$nome = "maio";
				break;
			case 6:
				$nome = "junho";
				break;
			case 7:
				$nome = "julho";
				break;
			case 8:
				$nome = "agosto";
				break;
			case 9:
				$nome = "setembro";
				break;
			case 10:
				$nome = "outubro";
				break;
			case 11:
				$nome = "novembro";
				break;
			case 12:
				$nome = "dezembro";
				break;
		}
		return $nome;
	}
	
	function deixar_maiusculo ($name) {
  		$array1 = array ("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î",
  		"ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç");
  		$array2 = array ("Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", 
		"Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
  		return str_replace( $array1, $array2, $name );
	}
	
	function deixar_minusculo ($name) {
  		$array1 = array ("Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", 
		"Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
		$array2 = array ("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î",
  		"ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç");
  		return str_replace( $array1, $array2, $name );
	}
	
	function tirar_acentos ($name) {
  		$array1 = array ("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î",
  		"ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç",
		"Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", 
		"Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
		$array2 = array ("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i",
  		"i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c",
		"A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", 
		"I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
  		return str_replace( $array1, $array2, $name );
	}

	//valor extenso
	function extenso($valor = 0, $maiusculas = false) {

		$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");

		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");

		$z = 0;
		$rt = "";

		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];

		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
		$t = count($inteiro)-1-$i;
		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
				if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}

		if(!$maiusculas){
			return($rt ? $rt : "zero");
		} else {

			if ($rt) $rt=ereg_replace(" E "," e ",ucwords($rt));
				return (($rt) ? ($rt) : "Zero");
		}

	}
	
		//numero extenso
		function numero_extenso($valor = 0, $maiusculas = false) {

		//$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		//$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");

		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");

		$z = 0;
		$rt = "";

		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];

		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
		$t = count($inteiro)-1-$i;
		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
				if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}

		if(!$maiusculas){
			return($rt ? $rt : "zero");
		} else {

			if ($rt) $rt=ereg_replace(" E "," e ",ucwords($rt));
				return (($rt) ? ($rt) : "Zero");
		}

	}
	
?>