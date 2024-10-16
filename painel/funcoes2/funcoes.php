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
	
	// Retorna a data no formato dia da semana, dia de mês
	function DataExtensoSimples($data)
	{
		$Agenda = new Agenda();
		$data_q = explode("-", $data);
		$dia_semana = $Agenda->DiaSemana($data);
		$data_extenso = NomeDiaSemana($dia_semana) . ", " . $data_q[2] . " de " . NomeMes($data_q[1]);
		return $data_extenso;
	}
	
	// Retorna a data no formato dia da semana, dia de mês ano
	function DataExtenso($data)
	{
		$Agenda = new Agenda();
		$data_q = explode("-", $data);
		$dia_semana = $Agenda->DiaSemana($data);
		$data_extenso = NomeDiaSemana($dia_semana) . ", " . $data_q[2] . " de " . NomeMes($data_q[1]) . " " . $data_q[0];
		return $data_extenso;
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
	
	function HoraCorrida($hora)
	{
		$hora_q = explode(":", $hora);
		$hora_corrida = $hora_q[0] . "h" . $hora_q[1] . "min";
		return $hora_corrida;
	}
?>