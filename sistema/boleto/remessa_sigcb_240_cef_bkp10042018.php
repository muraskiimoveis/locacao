<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

/*
Dados do Boleto
===============

"agencia"] = "3512"; // Num da agencia, sem digito
"conta"] = "757";  // Num da conta, sem digito
"conta_dv"] = "5";     // Digito do Num da conta
"conta_cedente"] = "625786"; // Código Cedente do Cliente, com 6 digitos (Somente Números)
"carteira"] = "14";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)
'nome_fantasia' => 'Muraski Imoveis',
'razao_social'  => 'Muraski Imoveis Ltda',
'cnpj'          => '05243414000165',
'banco'         => $codigo_banco, //código do banco
'logradouro'    => 'Av 29 de Abril, 548',
'numero'        => '548',
'bairro'        => 'Centro',
'cidade'        => 'Guaratuba',
'uf'            => 'PR',
'cep'           => '83280000',
'agencia'       => '3512',
'agencia_dv' => '0',
'conta'         => '757',
'operacao'      => '003',
'codigo_cedente' => '625786',
//    'codigo_cedente_dac' => '7',
'numero_sequencial_arquivo' => '3',
'codigo_convenio' => '625786',

*/

$data_geracao = date("dmY");
$hora_geracao = date("His");
$banco = "104";
$agencia = "03512";
$dv_agencia = "2";
$cod_convenio = "625786";
$n_inscricao_empresa = "05243414000165";
$empresa = "MURASKI IMOVEIS LTDA";
//$data_hj = new Date();
$dias_de_prazo_para_pagamento = 0;

$mensagem_3 = "Sr Caixa, Não Receber Após Vencimento!!";
$mensagem_4 = "";
$mensagem_5 = "";
$mensagem_6 = "";
$mensagem_7 = "";
$mensagem_8 = "";

$data_emissao = date("dmY");
$valor_em_zero = "0.00";

$juros = explode('.',$valor_em_zero);
$juros_mora = str_pad('0',13,"0",STR_PAD_LEFT);
$juros_decimal = str_pad('0',2,"0");

$desconto = explode('.',$valor_em_zero);
$desconto_mora = str_pad('0',13,"0",STR_PAD_LEFT);
$desconto_decimal = str_pad('0',2,"0");

$iof = explode('.',$valor_em_zero);
$iof_mora = str_pad('0',13,"0",STR_PAD_LEFT);
$iof_decimal = str_pad('0',2,"0");

$abatimento = explode('.',$valor_em_zero);
$abatimento_mora = str_pad('0',13,"0",STR_PAD_LEFT);
$abatimento_decimal = str_pad('0',2,"0");

$cod_protesto = "3";
$n_dias_protesto = "00";
$cod_baixa_devolucao = "1";
$n_dias_baixa_devolucao = "005";
$cod_moeda = "09";
$dias_tolerancia_multa = 1;
$valor_multa = "0";
$valor_multa = explode('.',str_replace(',','.',$valor_multa));

// para montar nome do arquivo
//$monta_nome_arquivo = 'cef_boleto_'.$_GET[nrdoc];
$monta_nome_arquivo = 'cef_boleto_'.$_SESSION['nrdoc_r'];

$arquivo = '/tmp/'.$monta_nome_arquivo.'.rem';
// se arquivo existe
if(file_exists($arquivo)){
// Apaga arquivo no Server 160
@opendir('/tmp/');
@unlink($arquivo);
@closedir('/tmp/');
}

// Cria e Abre para gravar $arquivo
$abrir = fopen($arquivo, "w+");

//$header_arquivo = str_pad($banco,3,'0',STR_PAD_LEFT).str_pad('',4,'0',STR_PAD_LEFT)."0".str_pad(' ',9)."2".str_pad($n_inscricao_empresa,14,"0",STR_PAD_LEFT).str_pad('0',20,'0',STR_PAD_LEFT).str_pad($agencia,5,"0",STR_PAD_LEFT).$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',8,'0',STR_PAD_LEFT).str_pad($empresa, 30)."CAIXA ECONOMICA FEDERAL       ".str_pad(' ',10)."1".$data_geracao.$hora_geracao."000095"."050".str_pad('0',5,'0',STR_PAD_LEFT).str_pad(' ',20)."REMESSA-PRODUCAO    "."V215".str_pad('',25);
$header_arquivo = str_pad($banco,3,'0',STR_PAD_LEFT).str_pad('',4,'0',STR_PAD_LEFT)."0".str_pad(' ',9)."2".str_pad($n_inscricao_empresa,14,"0",STR_PAD_LEFT).str_pad('0',20,'0',STR_PAD_LEFT).str_pad($agencia,5,"0",STR_PAD_LEFT).$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',8,'0',STR_PAD_LEFT).str_pad($empresa, 30)."CAIXA ECONOMICA FEDERAL       ".str_pad(' ',10)."1".$data_geracao.$hora_geracao."000095"."050".str_pad('0',5,'0',STR_PAD_LEFT).str_pad(' ',20)."REMESSA-PRODUCAO        ".str_pad('',25);

//$header_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."1"."R"."01"."00"."030"." "."2".str_pad($n_inscricao_empresa,15,"0",STR_PAD_LEFT).str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',14,'0',STR_PAD_LEFT).$agencia.$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',7,'0',STR_PAD_LEFT)."0".str_pad($empresa, 30).str_pad('',40).str_pad('',40)."00000095".$data_geracao.$data_geracao.str_pad(' ',33);
$header_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."1"."R"."01"."00"."030"." "."2".str_pad($n_inscricao_empresa,15,"0",STR_PAD_LEFT).str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',14,'0',STR_PAD_LEFT).$agencia.$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',7,'0',STR_PAD_LEFT)."0".str_pad($empresa, 30).str_pad('',40).str_pad('',40)."00000095".$data_geracao.str_pad('0',8,'0',STR_PAD_LEFT).str_pad(' ',25);


$escreve_arq = fwrite($abrir, $header_arquivo."\r\n" );//Arquivo de Header
$escreve_lote = fwrite($abrir, $header_lote."\r\n" );//Arquivo de Lote


$rs_data = date("dmY",strtotime($_SESSION['data_venc_r']));
$dia=substr($_SESSION['data_venc_r'],9,2);
$mes=substr($_SESSION['data_venc_r'],6,2);
$ano=substr($_SESSION['data_venc_r'],0,4);
$vencimento = $rs_data;
$nosso_numero = $_SESSION['nrdoc_r'];
$documento = preg_replace('@[./-]@','',$_SESSION['cpf_r']);
$cliente = str_pad($_SESSION['sacado_r'],40);

// Verifica Pessoa Fisica / Juridica
if(strlen($documento)<=11){
    $tipo_de_inscricao = 1;
}elseif(strlen($documento)>11){
    $tipo_de_inscricao = 2;
}
//
$endereco = str_pad((strtoupper($_SESSION['end_r'])),40);
$bairro = str_pad(strtoupper($_SESSION['bairro_r']),15);
$cep = preg_replace('@[-]@','',$_SESSION['cep_r']);
$cidade = str_pad(strtoupper($_SESSION['cidade_r']),15);
$estado = str_pad(strtoupper($_SESSION['uf_r']),2);
$email = str_pad(strtoupper(''),50);
//
$valor = explode('.',number_format($_SESSION['valor_boleto_r'],2,".",""));
$valor_nominal = str_pad($valor[0],13,"0",STR_PAD_LEFT);
$valor_decimal = str_pad($valor[1],2,"0");
$valor_titulo = number_format($_SESSION['valor_boleto_r'],2,".","");

$linha_p = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."3"."00001"."P"." "."01".$agencia.$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT)."00000000000"."14".str_pad($nosso_numero,15,"0",STR_PAD_LEFT)."1"."1"."2"."2"."0"."B".str_pad($nosso_numero,10,"0",STR_PAD_LEFT)."    ".$vencimento.$valor_nominal.$valor_decimal."00000"."0"."02"."N".$data_emissao."3"."00000000".$juros_mora.$juros_decimal."0"."00000000".$desconto_mora.$desconto_decimal.$iof_mora.$iof_decimal.$abatimento_mora.$abatimento_decimal."BOLETO NUMERO".str_pad($nosso_numero,9)."XXX".$cod_protesto.$n_dias_protesto.$cod_baixa_devolucao.$n_dias_baixa_devolucao.$cod_moeda.str_pad('',10,'0',STR_PAD_LEFT)." ";

$linha_q = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."3"."00002"."Q"." "."01".$tipo_de_inscricao.str_pad($documento,15,"0",STR_PAD_LEFT).strtoupper($cliente).$endereco.$bairro.$cep.$cidade.$estado."0"."000000000000000".str_pad(' ',40)."000".str_pad(' ',20).str_pad(' ',8);

//$linha_r = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."3"."00003"."R"." "."01".str_pad('0',1).str_pad('0',8).str_pad('0',13).str_pad('0',1).str_pad('0',8).str_pad('0',13).str_pad('0',1).str_pad('0',8).str_pad('0',13).str_pad(' ',10).str_pad(' ',40).str_pad(' ',40).str_pad(' ',50).str_pad(' ',11);

//$linha_s = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."3"."00004"."S"." "."01"."3".str_pad($mensagem_3,40).str_pad($mensagem_6,40).str_pad($mensagem_7,40).str_pad($mensagem_8,40).str_pad(' ',40).str_pad(' ',22);

$escreve_p = fwrite($abrir, $linha_p."\r\n" );//Arquivo de Lote
$escreve_q = fwrite($abrir, $linha_q."\r\n" );//Arquivo de Lote

$soma_valores = explode('.', $valor_titulo);

////$trailer_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."5".str_pad('',9).str_pad((($num_remessa_financeiro * 4) + 2),6,"0",STR_PAD_LEFT).str_pad($num_remessa_financeiro,6,"0",STR_PAD_LEFT).str_pad($soma_valores[0],15,'0',STR_PAD_LEFT).str_pad($soma_valores[1],2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad(' ',31).str_pad(' ',117);
//$trailer_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."5".str_pad(' ',9).str_pad((($nosso_numero * 4) + 2),6,"0",STR_PAD_LEFT).str_pad($nosso_numero,6,"0",STR_PAD_LEFT).str_pad($soma_valores[0],15,'0',STR_PAD_LEFT).str_pad($soma_valores[1],2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad(' ',31).str_pad(' ',117);

$trailer_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."5".str_pad(' ',9)."000004"."000001".str_pad($soma_valores[0],15,'0',STR_PAD_LEFT).str_pad($soma_valores[1],2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad(' ',31).str_pad(' ',117);

$trailer_arquivo = str_pad($banco,3,'0',STR_PAD_LEFT)."9999"."9".str_pad(' ',9)."000001"."000001".str_pad(' ',6).str_pad(' ',205);

$escreve_tlote = fwrite($abrir, $trailer_lote."\r\n" );//Arquivo de Trailer
$escreve_tarq = fwrite($abrir, $trailer_arquivo);//Arquivo de Trailer

// Salva Arquivo
$fecha_arquivo = fclose($abrir);

// para montar nome do arquivo
// $monta_nome_arquivo = 'cnab'.$_GET[nrdoc];
// $arquivo = '/tmp/'.$monta_nome_arquivo.'.REM';

$ftp_server = '192.168.10.170';
$ftp_user_name = 'muraski';
$ftp_user_pass = 'mura2004';
$nome_file = $monta_nome_arquivo.'.rem';
$remote_file = 'cnab/remessa/'.$nome_file;
// set up basic connection
$conn_id = ftp_connect($ftp_server);
// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
// upload a file

if(ftp_put($conn_id, $remote_file, $arquivo, FTP_ASCII)){
    if(file_exists($arquivo)){
//// Apaga arquivo no Server Local
        @opendir('/tmp/');
        @unlink($arquivo);
        @closedir('/tmp/');
    }
}

?>