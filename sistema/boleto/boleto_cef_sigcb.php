<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto CEF SIGCB: Davi Nunes Camargo				  |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE \\
//
//$dias_de_prazo_para_pagamento = 5;
//$taxa_boleto = 2.95;
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
//$valor_cobrado = "2950,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
//$valor_cobrado = str_replace(",", ".",$valor_cobrado);
//$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
//
$dias_de_prazo_para_pagamento = $_GET[d_prazo];
$taxa_boleto = number_format($_GET[taxa], 2, ',', '');
$data_venc = date($_GET[dt_vcto], time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $_GET[valor]; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
//
//
// Composição Nosso Numero - CEF SIGCB
//
//$dadosboleto["nosso_numero1"] = "000"; // tamanho 3
//$dadosboleto["nosso_numero_const1"] = "2"; //constanto 1 , 1=registrada , 2=sem registro
//$dadosboleto["nosso_numero2"] = "000"; // tamanho 3
//$dadosboleto["nosso_numero_const2"] = "4"; //constanto 2 , 4=emitido pelo proprio cliente
//$dadosboleto["nosso_numero3"] = "000000019"; // tamanho 9
//
//$dadosboleto["numero_documento"] = "27.030195.10";	// Num do pedido ou do documento
//
$dadosboleto["nosso_numero1"] = "000"; // tamanho 3
$dadosboleto["nosso_numero_const1"] = "1"; //constanto 1 , 1=registrada , 2=sem registro
$dadosboleto["nosso_numero2"] = "000"; // tamanho 3
$dadosboleto["nosso_numero_const2"] = "4"; //constanto 2 , 4=emitido pelo proprio cliente
$dadosboleto["nosso_numero3"] = $_GET[nrdoc];  // Nosso numero sem o DV - REGRA: Máximo de 9 caracteres!
//
$dadosboleto["numero_documento"] = $_GET[nrdoc];	// Num do pedido ou do documento = Nosso numero
//
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $_GET[sacado];
$dadosboleto["endereco1"] = $_GET[end1];
$dadosboleto["endereco2"] = $_GET[end2];

// INFORMACOES PARA O CLIENTE
//
//$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Nonononono";
//$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
//$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
//
$dadosboleto["demonstrativo1"] = $_GET[demo1];
//$demoA = substr($_GET[demo2],0,(strlen($_GET[demo2])-(strpos($_GET[demo2],'1')+6)));
//$demoB = date("m",$_GET[dt_vcto]).'/'.date("Y",$_GET[dt_vcto]);
//$demoB = substr($data_venc,3,2).'/'.substr($data_venc,6,4);
//$demoC = substr($_GET[demo2],strpos($_GET[demo2],'1')+1,(strlen($_GET[demo2])-(strpos($_GET[demo2],'1')+3)));
//$dadosboleto["demonstrativo2"] = $demoA.$demoB.$demoC." ".$taxa_boleto;
$dadosboleto["demonstrativo2"] = $_GET[demo2];
$dadosboleto["demonstrativo3"] = $_GET[demo3];

// INSTRUÇÕES PARA O CAIXA
//
//$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
//$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
//$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br";
//$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";
//
$dadosboleto["instrucoes1"] = $_GET[inst1];
$dadosboleto["instrucoes2"] = $_GET[inst2];
$dadosboleto["instrucoes3"] = $_GET[inst3];
$dadosboleto["instrucoes4"] = $_GET[inst4];

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
//
//$dadosboleto["quantidade"] = "";
//$dadosboleto["valor_unitario"] = "";
//$dadosboleto["aceite"] = "";
//$dadosboleto["especie"] = "R$";
//$dadosboleto["especie_doc"] = "";
//
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - CEF
//
//$dadosboleto["agencia"] = "1234"; // Num da agencia, sem digito
//$dadosboleto["conta"] = "123"; 	// Num da conta, sem digito
//$dadosboleto["conta_dv"] = "0"; 	// Digito do Num da conta

$dadosboleto["agencia"] = "3512"; // Num da agencia, sem digito
$dadosboleto["conta"] = "757"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "5"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
//
//$dadosboleto["conta_cedente"] = "123456"; // Código Cedente do Cliente, com 6 digitos (Somente Números)
//$dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

$dadosboleto["conta_cedente"] = "625786"; // Código Cedente do Cliente, com 6 digitos (Somente Números)
$dadosboleto["carteira"] = "14";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

// SEUS DADOS
$dadosboleto["identificacao"] = $_GET[razao];
$dadosboleto["cpf_cnpj"] = $_GET[razao_cnpj];
$dadosboleto["endereco"] = $_GET[razao_end];
$dadosboleto["cidade_uf"] = $_GET[razao_local];
$dadosboleto["cedente"] = "Muraski Imóveis Ltda";

// NÃO ALTERAR!
include("include/funcoes_cef_sigcb.php");
include("include/layout_cef.php");
?>
