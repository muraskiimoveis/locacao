<?php
/*
Arquivo de Retorno da CEF Padrão CNAB 240:
@author FRANK NATAL SIPOLI
@desc Recebe o upload do arquivo de retorno do Banco do Brasil com os boletos pagos
e faz a baixa dos mesmos

Deve-se seguir a seguinte sequência:

REGISTRO DE HEADER DE ARQUIVO

LOTE: LIQUIDACAO DE TITULOS EM CARTEIRA DE COBRANCA
(item: 3.1.3 Pagamento de Títulos de Cobrança - subcpadr5-layout padrao V.08.02.doc, pág. 29)
- Registro Header de lote
- Registro Detalhe - Segmento J *Obrigatorio
- Registro Trailer de lote

REGISTRO TRAILER DE ARQUIVO

Com base no arquivo:
Padrão Febraban - 240 posições V.08.2 - Julho 2006 padr-v08.2.zip 400 Kb 06/09/2005 19458 downloads

*/

/*
* @name funcao retornaTrecho
* @desc retorna determinado trecho de uma variável
* @param variável geral
* @param int - iniciando em
* @param int - retorna X registros a partir do inicio
*/
function retornaTrecho($var, $inicio, $nDigitos){
//retorna a parte solicitada da string $var (a contagem inicia-se em zero)
return substr($var, $inicio-1, $nDigitos);
}

/*
* @name funcao addDecimal
* @desc coloca um ponto (.) a antes de uma quantidade de casas decimais
* @param variável para se adicionar um ponto
* @param int - casas decimais depois do ponto
*/
function addDecimal($var, $casasDecimais){
//retorna a string formatada
return substr_replace($var, ".", -$casasDecimais, 0);
}

//define o caminho absoluto até a pasta do arquivo
$strCaminhoAbsoluto = 'cnab/retorno/';

//nome do arquivo a ser aberto
// para montar nome do arquivo
$strNomeDoArquivo = $_SESSION['arquivo_retorno'];
//echo "Mostra Nome ==> ".$strCaminhoAbsoluto.$strNomeDoArquivo;

//tenta abrir o arquivo de retorno do banco
//if(!$arrArquivo = file($strCaminhoAbsoluto.$strNomeDoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))
if(file_exists($strCaminhoAbsoluto.$strNomeDoArquivo)){
    //$arrArquivo = fopen($strCaminhoAbsoluto.$strNomeDoArquivo, "r");
    //$arrArquivo = file($strCaminhoAbsoluto.$strNomeDoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    //$arrArquivo = file($strCaminhoAbsoluto.$strNomeDoArquivo);
    $arrArquivo = file($strCaminhoAbsoluto.$strNomeDoArquivo);
}else{exit('Não foi possível abrir o arquivo de retorno do banco!');}

//linha atual
$i = 0;

//retira de um vez as quebras de linhas, retorno de carros e linhas vazias
foreach($arrArquivo as $linhas){

//retira \r
$linhas = str_replace(chr(13), "", $linhas);

//retira \n
$linhas = str_replace(chr(10), "", $linhas);

//apaga as linhas vazias
if(empty($linhas)){unset($arrArquivo[$i]);}

//echo($linhas);

//proxima linha
$i++;
}

//HEADER DE ARQUIVO:
$HA = $arrArquivo[0];

//separa o header do arquivo em seus pedaços
$arrArquivoRetorno['HA']['ContrBanco'] = retornaTrecho($HA, 1, 3);
$arrArquivoRetorno['HA']['ContrLote'] = retornaTrecho($HA, 4, 4);
$arrArquivoRetorno['HA']['ContrRegistro'] = retornaTrecho($HA, 8, 1);
$arrArquivoRetorno['HA']['CNAB1'] = retornaTrecho($HA, 9, 9);
$arrArquivoRetorno['HA']['EmpInscTipo'] = retornaTrecho($HA, 18, 1);
$arrArquivoRetorno['HA']['EmpInscNum'] = retornaTrecho($HA, 19, 14);
$arrArquivoRetorno['HA']['EmpConvenio'] = retornaTrecho($HA, 33, 20);
$arrArquivoRetorno['HA']['EmpContCorAgenCod'] = retornaTrecho($HA, 53, 5);
$arrArquivoRetorno['HA']['EmpContCorAgenDV'] = retornaTrecho($HA, 58, 1);
$arrArquivoRetorno['HA']['EmpContCorContNum'] = retornaTrecho($HA, 59, 12);
$arrArquivoRetorno['HA']['EmpContCorContDV'] = retornaTrecho($HA, 71, 1);
$arrArquivoRetorno['HA']['EmpContCorDV'] = retornaTrecho($HA, 72, 1);
$arrArquivoRetorno['HA']['EmpNome'] = retornaTrecho($HA, 73, 30);
$arrArquivoRetorno['HA']['NomeBanco'] = retornaTrecho($HA, 103, 30);
$arrArquivoRetorno['HA']['CNAB2'] = retornaTrecho($HA, 133, 10);
$arrArquivoRetorno['HA']['ArqCodigo'] = retornaTrecho($HA, 143, 1);
$arrArquivoRetorno['HA']['ArqDataGeracao'] = retornaTrecho($HA, 144, 8);
$arrArquivoRetorno['HA']['ArqHoraGeracao'] = retornaTrecho($HA, 152, 6);
$arrArquivoRetorno['HA']['ArqSequencia'] = retornaTrecho($HA, 158, 6);
$arrArquivoRetorno['HA']['ArqLayout'] = retornaTrecho($HA, 164, 3);
$arrArquivoRetorno['HA']['ArqDensidade'] = retornaTrecho($HA, 167, 5);
$arrArquivoRetorno['HA']['ReservadoBanco'] = retornaTrecho($HA, 172, 20);
$arrArquivoRetorno['HA']['ReservadoEmpresa'] = retornaTrecho($HA, 192, 20);
$arrArquivoRetorno['HA']['CNAB3'] = retornaTrecho($HA, 212, 29);

//número total de linhas do arquivo
$nTotalLinhas = count($arrArquivo);

//TRAILER DE ARQUIVO:
$TA = $arrArquivo[$nTotalLinhas-1];

//separa o trailer do arquivo em seus pedaços
$arrArquivoRetorno['TA']['ContrBanco'] = retornaTrecho($TA, 1, 3);
$arrArquivoRetorno['TA']['ContrLote'] = retornaTrecho($TA, 4, 4);
$arrArquivoRetorno['TA']['ContrRegistro'] = retornaTrecho($TA, 8, 1);
$arrArquivoRetorno['TA']['CNAB1'] = retornaTrecho($TA, 9, 9);
$arrArquivoRetorno['TA']['TotaisQtdeLotes'] = retornaTrecho($TA, 18, 6);
$arrArquivoRetorno['TA']['TotaisQtdeRegistros'] = retornaTrecho($TA, 24, 6);
$arrArquivoRetorno['TA']['TotaisQtdeConcil'] = retornaTrecho($TA, 30, 6);
$arrArquivoRetorno['TA']['CNAB2'] = retornaTrecho($TA, 36, 205);

//retira o header e trailer de arquivo para ficar apenas os lotes
unset($arrArquivo[0]);
unset($arrArquivo[$nTotalLinhas-1]);

//ordena o array $arrArquivo
sort($arrArquivo);

//HEADER DO LOTE:
$HL = $arrArquivo[0];

//separa o header do lote em seus pedaços
$arrArquivoRetorno['HL']['ContrBanco'] = retornaTrecho($HL, 1, 3);
$arrArquivoRetorno['HL']['ContrLote'] = retornaTrecho($HL, 4, 4);
$arrArquivoRetorno['HL']['ContrRegistro'] = retornaTrecho($HL, 8, 1);
$arrArquivoRetorno['HL']['ServOperacao'] = retornaTrecho($HL, 9, 1);
$arrArquivoRetorno['HL']['ServServico'] = retornaTrecho($HL, 10, 2);
$arrArquivoRetorno['HL']['ServFormLanca'] = retornaTrecho($HL, 12, 2);
$arrArquivoRetorno['HL']['ServLayout'] = retornaTrecho($HL, 14, 3);
$arrArquivoRetorno['HL']['CNAB1'] = retornaTrecho($HL, 17, 1);
$arrArquivoRetorno['HL']['EmpInscTipo'] = retornaTrecho($HL, 18, 1);
//$arrArquivoRetorno['HL']['EmpInscNum'] = retornaTrecho($HL, 19, 14);
$arrArquivoRetorno['HL']['EmpInscNum'] = retornaTrecho($HL, 20, 14);
//$arrArquivoRetorno['HL']['EmpConvenio'] = retornaTrecho($HL, 33, 20);
$arrArquivoRetorno['HL']['EmpConvenio'] = retornaTrecho($HL, 34, 20);
//$arrArquivoRetorno['HL']['EmpContCorAgenCod'] = retornaTrecho($HL, 53, 5);
$arrArquivoRetorno['HL']['EmpContCorAgenCod'] = retornaTrecho($HL, 54, 5);
//$arrArquivoRetorno['HL']['EmpContCorDV'] = retornaTrecho($HL, 58, 1);
$arrArquivoRetorno['HL']['EmpContCorDV'] = retornaTrecho($HL, 59, 1);
//$arrArquivoRetorno['HL']['EmpContCorContNum'] = retornaTrecho($HL, 59, 12);
$arrArquivoRetorno['HL']['EmpContCorContNum'] = retornaTrecho($HL, 60, 12);
//$arrArquivoRetorno['HL']['EmpContCorContDV'] = retornaTrecho($HL, 71, 1);
$arrArquivoRetorno['HL']['EmpContCorContDV'] = retornaTrecho($HL, 72, 1);
//$arrArquivoRetorno['HL']['EmpContCorDV'] = retornaTrecho($HL, 72, 1);
$arrArquivoRetorno['HL']['EmpContCorDV'] = retornaTrecho($HL, 73, 1);
//$arrArquivoRetorno['HL']['EmpNome'] = retornaTrecho($HL, 73, 30);
$arrArquivoRetorno['HL']['EmpNome'] = retornaTrecho($HL, 74, 30);
//$arrArquivoRetorno['HL']['Informacao1'] = retornaTrecho($HL, 103, 40);
//$arrArquivoRetorno['HL']['EmpEndLogra'] = retornaTrecho($HL, 143, 30);
//$arrArquivoRetorno['HL']['EmpEndNum'] = retornaTrecho($HL, 173, 5);
//$arrArquivoRetorno['HL']['EmpEndComple'] = retornaTrecho($HL, 178, 15);
//$arrArquivoRetorno['HL']['EmpEndCidade'] = retornaTrecho($HL, 193, 20);
//$arrArquivoRetorno['HL']['EmpEndCEP'] = retornaTrecho($HL, 213, 5);
//$arrArquivoRetorno['HL']['EmpEndCompleCEP'] = retornaTrecho($HL, 218, 3);
//$arrArquivoRetorno['HL']['EmpEndEstado'] = retornaTrecho($HL, 221, 2);
$arrArquivoRetorno['HL']['Informacao1'] = retornaTrecho($HL, 104, 30);
$arrArquivoRetorno['HL']['Informacao2'] = retornaTrecho($HL, 144, 40);
$arrArquivoRetorno['HL']['NumeroRetorno'] = retornaTrecho($HL, 184, 8);
$arrArquivoRetorno['HL']['DtaGravRetorno'] = retornaTrecho($HL, 192, 8);
$arrArquivoRetorno['HL']['DtaCredito'] = retornaTrecho($HL, 200, 8);
$arrArquivoRetorno['HL']['CNAB2'] = retornaTrecho($HL, 208, 8);


//número total de linhas do arquivo
$nTotalLinhas = count($arrArquivo);

//TRAILER DO LOTE:
$TL = $arrArquivo[$nTotalLinhas-1];

//separa o trailer do lote em seus pedaços
$arrArquivoRetorno['TL']['ContrBanco'] = retornaTrecho($TL, 1, 3);
$arrArquivoRetorno['TL']['ContrLote'] = retornaTrecho($TL, 4, 4);
$arrArquivoRetorno['TL']['ContrRegistro'] = retornaTrecho($TL, 8, 1);
$arrArquivoRetorno['TL']['CNAB1'] = retornaTrecho($TL, 9, 9);
$arrArquivoRetorno['TL']['TotaisQtdeRegistros'] = retornaTrecho($TL, 18, 6);
$arrArquivoRetorno['TL']['TotaisValor'] = addDecimal(retornaTrecho($TL, 24, 18), 2);
$arrArquivoRetorno['TL']['TotaisQtdeMoeda'] = retornaTrecho($TL, 42, 18);
$arrArquivoRetorno['TL']['NumAvisoDebito'] = retornaTrecho($TL, 60, 6);
$arrArquivoRetorno['TL']['CNAB2'] = retornaTrecho($TL, 66, 165);
$arrArquivoRetorno['TL']['Ocorrencias'] = retornaTrecho($TL, 231, 10);

//retira o header e trailer do lote para ficar apenas os registros
unset($arrArquivo[0]);
unset($arrArquivo[$nTotalLinhas-1]);

//ordena o array $arrArquivo
sort($arrArquivo);

//conta quantos registros o arquivo tem
$nRegistros = count($arrArquivo);

//navega entre os registros e os formata em arrays (SEGMENTO J)
for($i=0; $i<$nRegistros; $i++){

//obtém o registro atual
$registroAtual = $arrArquivo[$i];

//cadastra cada registro separadamente com seus detalhes
// Registro Tipo T e U
$arrArquivoRetorno['REGISTRO'.$i]['NrBanco'] = retornaTrecho($registroAtual, 1, 3);
$arrArquivoRetorno['REGISTRO'.$i]['NrLote'] = retornaTrecho($registroAtual, 4, 4);
$arrArquivoRetorno['REGISTRO'.$i]['TpRegistro'] = retornaTrecho($registroAtual, 8, 1);
$arrArquivoRetorno['REGISTRO'.$i]['NrRegNoLote'] = retornaTrecho($registroAtual, 9, 5);
$arrArquivoRetorno['REGISTRO'.$i]['CodSegNoReg'] = retornaTrecho($registroAtual, 14, 1);
$arrArquivoRetorno['REGISTRO'.$i]['CNAB1'] = retornaTrecho($registroAtual, 15, 1);
$arrArquivoRetorno['REGISTRO'.$i]['TpMovRetorno'] = retornaTrecho($registroAtual, 16, 2);

if(retornaTrecho($registroAtual, 16, 2)=='06'){

//echo "Mostra  TpMovRetorno ==> ".retornaTrecho($registroAtual, 16, 2)."<br>";

	if(retornaTrecho($registroAtual, 14, 1)=='T'){

		//echo "Mostra  TpRegistro ==> ".retornaTrecho($registroAtual, 14, 1)."<br>";

		$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa1'] = retornaTrecho($registroAtual, 18, 5);
		$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa2'] = retornaTrecho($registroAtual, 23, 1);
		$arrArquivoRetorno['REGISTRO'.$i]['CodConvNoBco'] = retornaTrecho($registroAtual, 24, 6);
		$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa3'] = retornaTrecho($registroAtual, 30, 3);
		$arrArquivoRetorno['REGISTRO'.$i]['NrBcoSacado'] = retornaTrecho($registroAtual, 33, 3);
		$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa4'] = retornaTrecho($registroAtual, 36, 4);
		$arrArquivoRetorno['REGISTRO'.$i]['ModNNumero'] = retornaTrecho($registroAtual, 40, 2);
		$arrArquivoRetorno['REGISTRO'.$i]['IdTitNoBco'] = retornaTrecho($registroAtual, 42, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['Boleto'] = retornaTrecho($registroAtual, 46, 11);
		$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa5'] = retornaTrecho($registroAtual, 57, 1);
		$arrArquivoRetorno['REGISTRO'.$i]['CodCarteira'] = retornaTrecho($registroAtual, 58, 1);
		$arrArquivoRetorno['REGISTRO'.$i]['NrDocDeCobranca'] = retornaTrecho($registroAtual, 59, 11);
		$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa6'] = retornaTrecho($registroAtual, 70, 4);
		$arrArquivoRetorno['REGISTRO'.$i]['PagDtVctoTit'] = retornaTrecho($registroAtual, 74, 8);
		$arrArquivoRetorno['REGISTRO'.$i]['PagVlrTit'] = retornaTrecho($registroAtual, 82, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['PagCodBco'] = retornaTrecho($registroAtual, 97, 3);
		$arrArquivoRetorno['REGISTRO'.$i]['PagCodAgencia'] = retornaTrecho($registroAtual, 100, 5);
		$arrArquivoRetorno['REGISTRO'.$i]['PagDigitoAg'] = retornaTrecho($registroAtual, 105, 1);
		$arrArquivoRetorno['REGISTRO'.$i]['PagIdTitEmpresa'] = retornaTrecho($registroAtual, 106, 25);
		$arrArquivoRetorno['REGISTRO'.$i]['PagCodMoeda'] = retornaTrecho($registroAtual, 131, 2);
		$arrArquivoRetorno['REGISTRO'.$i]['TpInscSacado'] = retornaTrecho($registroAtual, 133, 1);
		$arrArquivoRetorno['REGISTRO'.$i]['NrInscSacado'] = retornaTrecho($registroAtual, 134, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['NomeSacado'] = retornaTrecho($registroAtual, 149, 40);
		$arrArquivoRetorno['REGISTRO'.$i]['CNAB2'] = retornaTrecho($registroAtual, 189, 10);
		$arrArquivoRetorno['REGISTRO'.$i]['VlTarifa'] = retornaTrecho($registroAtual, 199, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['MotOcorrencia'] = retornaTrecho($registroAtual, 214, 10);
		$arrArquivoRetorno['REGISTRO'.$i]['CNAB3'] = retornaTrecho($registroAtual, 224, 17);
	}elseif(retornaTrecho($registroAtual, 14, 1)=='U'){

		//echo "Mostra  TpRegistro ==> ".retornaTrecho($registroAtual, 14, 1)."<br>";

		$arrArquivoRetorno['REGISTRO'.$i]['VlrAcrescimos'] = retornaTrecho($registroAtual, 18, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['VlrDoDesc'] = retornaTrecho($registroAtual, 33, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['VlrAbatimento'] = retornaTrecho($registroAtual, 48, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['VlrIOF'] = retornaTrecho($registroAtual, 63, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['PagVlrTitulo'] = retornaTrecho($registroAtual, 78, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['PagVlrCredito'] = retornaTrecho($registroAtual, 93, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['PagAcrescimo'] = retornaTrecho($registroAtual, 108, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['PagCreditos'] = retornaTrecho($registroAtual, 123, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['DtOcorrencia'] = retornaTrecho($registroAtual, 138, 8);
		$arrArquivoRetorno['REGISTRO'.$i]['DtaCredito'] = retornaTrecho($registroAtual, 146, 8);
		$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa1'] = retornaTrecho($registroAtual, 154, 4);
		$arrArquivoRetorno['REGISTRO'.$i]['DtaDebitoTar'] = retornaTrecho($registroAtual, 158, 8);
		$arrArquivoRetorno['REGISTRO'.$i]['CodSacadoBco'] = retornaTrecho($registroAtual, 166, 15);
		$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa2'] = retornaTrecho($registroAtual, 181, 30);
		$arrArquivoRetorno['REGISTRO'.$i]['CodBcoCompensado'] = retornaTrecho($registroAtual, 211, 3);
		$arrArquivoRetorno['REGISTRO'.$i]['NrNossoNumeroBcoComp'] = retornaTrecho($registroAtual, 214, 20);
		$arrArquivoRetorno['REGISTRO'.$i]['CNAB2'] = retornaTrecho($registroAtual, 234, 7);
	}

	if((retornaTrecho($registroAtual, 14, 1)=='U') || (retornaTrecho($registroAtual, 14, 1)=='T')){
		if(retornaTrecho($registroAtual, 14, 1)=='T'){
			$boleto = retornaTrecho($registroAtual, 46, 11);
			$VlrTitulo = retornaTrecho($registroAtual, 82, 15);
			//echo "Mostra  NrBoleto ==> ".$boleto."<br>";
			//echo "Mostra  VlrTitulo ==> ".$VlrTitulo."<br>";
		}elseif(retornaTrecho($registroAtual, 14, 1)=='U'){
			//echo "Mostra  VlrTitulo ==> ".$VlrTitulo."<br>";
			//echo "Mostra  VlrTitulo ==> ".retornaTrecho($registroAtual, 93, 15)."<br>";

			if($VlrTitulo == retornaTrecho($registroAtual, 93, 15)){
				//echo "Mostra  Dta_Pgto ==> ".retornaTrecho($registroAtual, 146, 8)."<br>";
				$dta_pgto = substr(retornaTrecho($registroAtual, 146, 8),4,4)."-";
				$dta_pgto .= substr(retornaTrecho($registroAtual, 146, 8),2,2)."-";
				$dta_pgto .= substr(retornaTrecho($registroAtual, 146, 8),0,2);
				$situacao = "LIQUIDA";
				//echo "Mostra  DtaRegistro ==> ".retornaTrecho($registroAtual, 138, 8)."<br>";
				$dtaregistro = substr(retornaTrecho($registroAtual, 138, 8),4,4)."-";
				$dtaregistro .= substr(retornaTrecho($registroAtual, 138, 8),2,2)."-";
				$dtaregistro .= substr(retornaTrecho($registroAtual, 138, 8),0,2);
				//
				$baixa_nrdoc = "update remessa set rem_baixada = 'S', ";
				$baixa_nrdoc .= "dt_baixa ='".$dtaregistro."', dt_pgto ='".$dta_pgto;
				$baixa_nrdoc .= "', status = '".$situacao."' where nrdoc ='".$boleto;
				$baixa_nrdoc .= "' and status = 'ENV_CEF' and loc_deletada = 'N' and rem_baixada ='N' ";
				//echo "Mostra  SQL Remessa ==> ".$baixa_nrdoc."<br>";
				$rs_baixa_nrdoc = mysql_query($baixa_nrdoc) or die("Não foi possível baixar Boleto! Suas informações ==> ".mysql_error()." $baixa_nrdoc");
				//
				$insere_nrdoc = "update contas set co_status = 'ok', co_data_status = '".$dta_pgto."' where co_boleto = '".$boleto;
				$insere_nrdoc .= "' and co_status = 'pendente' and co_conciliado = 'S' and co_forma = 'Boleto'";
				//echo "Mostra  SQL Remessa ==> ".$insere_nrdoc."<br>";
				$rs_insere_nrdoc = mysql_query($insere_nrdoc) or die("Não foi possível atualizar suas informações. ==> ".mysql_error()." $insere_nrdoc");
				//
				$boleto = '';
				$VlrTitulo = '';
			}
		}
	}
}

/*
//cadastra cada registro separadamente com seus detalhes
$arrArquivoRetorno['REGISTRO'.$i]['ContrBanco'] = retornaTrecho($registroAtual, 1, 3);
$arrArquivoRetorno['REGISTRO'.$i]['ContrLote'] = retornaTrecho($registroAtual, 4, 4);
$arrArquivoRetorno['REGISTRO'.$i]['ContrRegistro'] = retornaTrecho($registroAtual, 8, 1);
$arrArquivoRetorno['REGISTRO'.$i]['ServNumRegistro'] = retornaTrecho($registroAtual, 9, 5);
$arrArquivoRetorno['REGISTRO'.$i]['ServSegmento'] = retornaTrecho($registroAtual, 14, 1);
$arrArquivoRetorno['REGISTRO'.$i]['ServMovimTipo'] = retornaTrecho($registroAtual, 15, 1);
$arrArquivoRetorno['REGISTRO'.$i]['ServMovimCod'] = retornaTrecho($registroAtual, 16, 2);
$arrArquivoRetorno['REGISTRO'.$i]['PagCodBarras'] = retornaTrecho($registroAtual, 18, 44);
$arrArquivoRetorno['REGISTRO'.$i]['PagNomCedente'] = retornaTrecho($registroAtual, 62, 30);
$arrArquivoRetorno['REGISTRO'.$i]['PagDataVenc'] = retornaTrecho($registroAtual, 92, 8);
$arrArquivoRetorno['REGISTRO'.$i]['PagValorTitulo'] = retornaTrecho($registroAtual, 100, 15);
$arrArquivoRetorno['REGISTRO'.$i]['PagDesconto'] = retornaTrecho($registroAtual, 115, 15);
$arrArquivoRetorno['REGISTRO'.$i]['PagAcrescimo'] = retornaTrecho($registroAtual, 130, 15);
$arrArquivoRetorno['REGISTRO'.$i]['PagDataPagamen'] = retornaTrecho($registroAtual, 145, 8);
$arrArquivoRetorno['REGISTRO'.$i]['PagValorPagamen'] = retornaTrecho($registroAtual, 153, 15);
$arrArquivoRetorno['REGISTRO'.$i]['PagQtdeMoeda'] = retornaTrecho($registroAtual, 168, 15);
$arrArquivoRetorno['REGISTRO'.$i]['PagRefSacado'] = retornaTrecho($registroAtual, 183, 20);
$arrArquivoRetorno['REGISTRO'.$i]['NossoNum'] = retornaTrecho($registroAtual, 203, 20);
$arrArquivoRetorno['REGISTRO'.$i]['CodDeMoeda'] = retornaTrecho($registroAtual, 223, 2);
$arrArquivoRetorno['REGISTRO'.$i]['CNAB'] = retornaTrecho($registroAtual, 225, 6);
$arrArquivoRetorno['REGISTRO'.$i]['Ocorrencias'] = retornaTrecho($registroAtual, 231, 10);
*/

}

//echo '<pre>';
//print_r($arrArquivoRetorno);
//echo '</pre>';

// se arquivo existe
if(file_exists($strCaminhoAbsoluto.$strNomeDoArquivo)){
@opendir($strCaminhoAbsoluto);
@unlink($strCaminhoAbsoluto.$strNomeDoArquivo);
@closedir($strCaminhoAbsoluto);
}

echo "<script>alert('Baixas do Arquivo ".$strNomeDoArquivo."  de Cobrancas Liquidadas CEF,  efetuada com Sucesso!!');</script>";

?>