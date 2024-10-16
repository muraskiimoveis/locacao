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
session_start();
include("conect.php");
//include("funcoes/funcoes.php");
//include("l_funcoes.php");
/*
* @name funcao retornaTrecho
* @desc retorna determinado trecho de uma variável
* @param variável geral
* @param int - iniciando em
* @param int - retorna X registros a partir do inicio
*/
function retornaTrecho($var, $inicio, $nDigitos){
//retorna a parte solicitada da string $var (a contagem inicia-se em zero)
return substr($var, $inicio-2, $nDigitos);
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
$arrArquivoRetorno = array();
$arrArquivo = array();

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
$numerolinhas = count($arrArquivo);
unset($arrArquivo[$numerolinhas]);
unset($arrArquivo[$numerolinhas-1]);
unset($arrArquivo[0]);
unset($arrArquivo[1]);
unset($arrArquivo[2]);
unset($arrArquivo[3]);
unset($arrArquivo[4]);
sort($arrArquivo);
$numerolinhas2 = count($arrArquivo);
//echo "<br>Numero de Linhas ==> ".$numerolinhas2."<br>";

//retira de um vez as quebras de linhas, retorno de carros e linhas vazias
foreach($arrArquivo as $linhas){

//retira \r
$linhas = str_replace(chr(13), "", $linhas);

//retira \n
$linhas = str_replace(chr(10), "", $linhas);

//apaga as linhas vazias
if(empty($linhas)){unset($arrArquivo[$i]);}

//echo($linhas."<br>");
//echo($linhas);

//proxima linha
$i++;
}
// Vao ao inicio do Arquivo
reset($arrArquivo);
//Conta a linhas
$numerolinhas3=count($arrArquivo);
//echo "Numero de Linhas2 ==> ".$numerolinhas3."<br>";
// Retira as linhas sem informações
for($x=0; $x<$numerolinhas3; $x++){
	if(trim(substr($arrArquivo[$x],1,4))===""){unset($arrArquivo[$x]);}
}

// Vao ao inicio do Arquivo
sort($arrArquivo);
//conta quantos registros o arquivo tem
$nRegistros = count($arrArquivo);
//navega entre os registros e os formata em arrays (Detalhes do Boleto)
for($j=0; $j<$nRegistros; $j++){

//obtém o registro atual
//$registroAtual[$j] = $arrArquivo[$j];

//$arrArquivoRetorno['REGISTRO'.$j]['Boleto'] = retornaTrecho($arrArquivo[$j], 8, 11);
//$arrArquivoRetorno['REGISTRO'.$j]['VlrBoleto'] = retornaTrecho($arrArquivo[$j], 90, 12);
//$arrArquivoRetorno['REGISTRO'.$j]['VctoBoleto'] = retornaTrecho($arrArquivo[$j], 105, 11);
//$arrArquivoRetorno['REGISTRO'.$j]['Situacao'] = retornaTrecho($arrArquivo[$j], 120, 10);
//$arrArquivoRetorno['REGISTRO'.$j]['DtaRegistro'] = retornaTrecho($arrArquivo[$j], 160, 11);
//$arrArquivoRetorno['REGISTRO'.$j]['DtaEntrada'] = retornaTrecho($arrArquivo[$j], 178, 11);
//
$boleto = retornaTrecho($arrArquivo[$j], 8, 11);
$vlrboleto = retornaTrecho($arrArquivo[$j], 90, 12);
$dta_pgto = substr(retornaTrecho($arrArquivo[$j], 105, 11),7,4)."-";
$dta_pgto .= substr(retornaTrecho($arrArquivo[$j], 105, 11),4,2)."-";
$dta_pgto .= substr(retornaTrecho($arrArquivo[$j], 105, 11),1,2);
$situacao = retornaTrecho($arrArquivo[$j], 120, 10);
$dtaregistro = substr(retornaTrecho($arrArquivo[$j], 160, 11),7,4)."-";
$dtaregistro .= substr(retornaTrecho($arrArquivo[$j], 160, 11),4,2)."-";
$dtaregistro .= substr(retornaTrecho($arrArquivo[$j], 160, 11),1,2);
//
$baixa_nrdoc = "update boleto set bol_baixado = 'S', ";
$baixa_nrdoc .= "dt_baixa ='".$dtaregistro."', dt_pgto ='".$dta_pgto;
$baixa_nrdoc .= "', status = '".$situacao."' where nrdoc ='".$boleto;
$baixa_nrdoc .= "' and status = 'ENV_CEF' and loc_deletada = 'N' and bol_baixado ='N' ";
//echo "MOstra ==> ".$baixa_nrdoc."<br>";
$rs_baixa_nrdoc = mysql_query($baixa_nrdoc) or die("Não foi possível baixar Boleto! Suas informações. $baixa_nrdoc");
//
$insere_nrdoc = "update contas set co_conciliado = 'S' where co_boleto = '".$boleto;
$insere_nrdoc .= "' and co_status = 'pendente' and co_conciliado = 'N' and co_forma = 'Boleto'";
$rs_insere_nrdoc = mysql_query($insere_nrdoc) or die("Não foi possível atualizar suas informações. $insere_nrdoc");
//
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

?>
 <script language="javascript">alert("Conciliacao Efetuada com Sucesso!!");</script>
<?


?>