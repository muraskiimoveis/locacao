<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

include("regra.php");
?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
<?php
include("style.php");
?>
<script language="JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
function VerificaCampo()
{

var msg = '';

	   if(document.formulario.im_nome.value.length==0)
	   {
		       msg += "Por favor, selecione o campo Nome.\n";
       }
       if(document.formulario.im_n_conselho.value=="")
	   {
		       msg += "Por favor, preencha o campo N° do Creci.\n";
	   }
	   if(document.formulario.im_cnpj.value=="")
	   {
		       msg += "Por favor, preencha o campo CPNJ.\n";
	   }
	   else if(!isCNPJ(RemoveMascaraCNPJ(document.formulario.im_cnpj.value)))
       {
	           msg += "CNPJ digitado é inválido!\n";
	   }
	   if(document.formulario.im_contato.value=="")
	   {
		       msg += "Por favor, preencha o campo Contato.\n";
	   }
	   if(document.formulario.im_nacionalidade.value=="")
	   {
		       msg += "Por favor, preencha o campo Nacionalidade.\n";
	   }
	   if (document.formulario.im_est_civil.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Estado Civil.\n";
	   }
       if(document.formulario.im_email.value.length==0)
	   {
		       msg += "Por favor, preencha o campo E-mail.\n";
       }
	   else if(!isMail(document.formulario.im_email.value))
	   {
	           msg += "O E-mail digitado é inválido!\n";
	   }
       if(document.formulario.im_senha.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Senha.\n";
       }
       if(document.formulario.im_tel.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Telefone.\n";
       }
       if (document.formulario.im_estado.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Estado.\n";
	   }
	   /*
	   if (document.formulario.im_cidade.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Cidade.\n";
	   }
	   */
	   if(document.formulario.im_end.value.length==0)
	   {
		     msg += "Por favor, preencha o campo Endereço.\n";
       }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
	        document.formulario.atualiza.value='1';
			document.formulario.submit();
	   }

}


</script>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0>
<table width=100% height=100%>
<tr><td bgcolor="<?php print("$barra_lat"); ?>" valign=top width=150>
<?php
include("menu_painel.php");
?></td>
<td width=620 valign=top>
<br>
<?php
include("conect.php");
?>
<?php
    function trocaini($wStr,$w1,$w2) {
        $wde = 0;
        $para=0;
    while($para<1) {
        $wpos = strpos($wStr, $w1, $wde);
        if ($wpos > 0) {
            $wStr = str_replace($w1, $w2, $wStr);
            $wde = $wpos+1;
        } else {
            $para=2;
        }
    }
    $trocou = $wStr;
    return $trocou;
    }

    function altaebaixa($umtexto) {
        $troca = strtolower($umtexto);
        $troca = ucwords($troca);
        $troca = trocaini($troca, " E ", " e ");
        $troca = trocaini($troca, " De ", " de ");
        $troca = trocaini($troca, " Da ", " da ");
        $troca = trocaini($troca, " Do ", " do ");
        $troca = trocaini($troca, " Das ", " das ");
        $troca = trocaini($troca, " Dos ", " dos ");
        $troca = trocaini($troca, "Ã", "ã");
        $troca = trocaini($troca, "Á", "á");
        $troca = trocaini($troca, "À", "à");
        $troca = trocaini($troca, "Â", "â");
        $troca = trocaini($troca, "Ç", "ç");
        $troca = trocaini($troca, "Ó", "ó");
        $troca = trocaini($troca, "Õ", "õ");
        $troca = trocaini($troca, "É", "é");
        $troca = trocaini($troca, "Ê", "ê");
        $troca = trocaini($troca, "Í", "í");

        $altabaixa = $troca;
        return $altabaixa;

    }

//Cadastra a fornecedor
if($B1 == "Cadastrar"){

	$pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$im_email."' AND u_senha='".md5($im_senha)."'";
	$pw_result = mysql_query($pw_query) or die("Não foi possivel inserir suas informações");
	$pw_rows = mysql_num_rows($pw_result);
	if ($pw_rows == 0) {

	$query0 = "select im_nome from rebri_imobiliarias where im_nome='$im_nome'";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações. $query0");
	$numrows = mysql_num_rows($result0);
	if($numrows == 0){

	//$im_nome = altaebaixa($im_nome);
	$im_senha = $im_senha;

	$nome_imobiliaria = $im_nome;

	// tira os acentos e espaço
	$im_nome = ereg_replace("[ÁÀÂÃ]","A",$im_nome);
	$im_nome = ereg_replace("[áàâãª]","a",$im_nome);
	$im_nome = ereg_replace("[ÉÈÊ]","E",$im_nome);
	$im_nome = ereg_replace("[éèê]","e",$im_nome);
	$im_nome = ereg_replace("[ÓÒÔÕ]","O",$im_nome);
	$im_nome = ereg_replace("[óòôõº]","o",$im_nome);
	$im_nome = ereg_replace("[ÚÙÛ]","U",$im_nome);
	$im_nome = ereg_replace("[úùû]","u",$im_nome);
	$im_nome = ereg_replace("[íìî]","i",$im_nome);
	$im_nome = ereg_replace("[ÍÌÎ]","I",$im_nome);
	$im_nome = str_replace("Ç","C",$im_nome);
	$im_nome = str_replace("ç","c",$im_nome);
	$im_nome = str_replace(" ","",$im_nome);

	// pega o nome da imobiliária, deixa em minúsculas e pega os 6 primeiros caracteres se caso for menor que 6 complementa com 0
	if(strlen($im_nome) < 6){
	    if(strlen($im_nome) == 5){
     		$nome_pasta = strtolower($im_nome."0");
     	}elseif(strlen($im_nome) == 4){
		   $nome_pasta = strtolower($im_nome."00");
		}elseif(strlen($im_nome) == 3){
		  $nome_pasta = strtolower($im_nome."000");
		}elseif(strlen($im_nome) == 2){
		  $nome_pasta = strtolower($im_nome."0000");
		}elseif(strlen($im_nome) == 1){
		  $nome_pasta = strtolower($im_nome."00000");
		}
	}elseif(strlen($im_nome) >= 6){
		$nome_pasta = strtolower(substr($im_nome,0,6));
	}

	// verifica se a pasta já existe
	if (file_exists("../imobiliarias/" . $nome_pasta)) {
   		$cont = 1; // contador de pastas

   	// verifica qual a ultima pasta criada e incrementa 1
   	while (file_exists("../imobiliarias/" . $nome_pasta . $cont)) {
       	$cont++;
   	}

   	$nome_pasta .= $cont;
	}

	// cria nova pasta
	$dirp = "../imobiliarias/".$nome_pasta;
	mkdir($dirp);
	chmod($dirp, 0777);

	$dirl = "../imobiliarias/".$nome_pasta."/locacao/";
	mkdir($dirl);
	chmod($dirl, 0777);

	$dirlp = "../imobiliarias/".$nome_pasta."/locacao_peq/";
	mkdir($dirlp);
	chmod($dirlp, 0777);

	$dirv = "../imobiliarias/".$nome_pasta."/venda/";
	mkdir($dirv);
	chmod($dirv, 0777);

	$dirvp = "../imobiliarias/".$nome_pasta."/venda_peq/";
	mkdir($dirvp);
	chmod($dirvp, 0777);

		//insere dados da imobiliária
	$query = "insert into rebri_imobiliarias (im_nome, im_contato, im_nacionalidade, im_est_civil, im_n_conselho, im_cnpj, im_tel, im_fax, im_cel, im_cidade, im_estado, im_end
	, im_bairro, im_cep, im_email, im_senha, im_site, im_img, im_desc, im_desde, nome_pasta)
	values('$nome_imobiliaria', '$im_contato', '$im_tel', '$im_fax', '$im_cel', '$im_cidade', '$im_estado', '$im_end'
	, '$im_bairro', '$im_cep', '$im_email', '$im_senha', '$im_site', '$im_img', '$im_desc', current_date, '$nome_pasta')";
	$result = mysql_query($query) or die("Não foi possível inserir suas informações.($query)");

	$cod_imobiliaria = mysql_insert_id();
	$senha = md5($im_senha);

	//insere documentos
	$queryd1 = "INSERT INTO doc (cod_imobiliaria, d_txt, d_nome, d_data, d_cod) VALUES('$cod_imobiliaria', 'Pelo presente instrumento particular, -nome-, -origem-, -civil-, portador da carteira de identidade RG. n° -rg-, e do CPF. -cpf-, residente e domiciliado na -end-, cidade de -cidade-/-estado-, fone: -tel-, de agora em diante chamado simplesmente de PROPRIETÁRIO; e, -prop_im-, -nacionalidade_im-, -est_civil_im-, inscrito no Conselho Regional de Corretores de Imóveis sob n° -n_conselho_im-, com sede nesta cidade à -end_im-, em -cidade_im-/-uf_im-, de agora em diante denominado simplesmente de ADMINISTRADOR; resolvem acertar a presente autorização para locação, conforme as condições a seguir:\r\n<b>CLÁSULA 1°</b> - O PROPRIETÁRIO autoriza o Administrador, em caráter de exclusividade, a alugar o imóvel de sua propriedade, situado na cidade de -cid_imov-, à -end_imov-, contendo: -desc_imov-.\r\n<b>CLÁSULA 2°</b> - A locação de que trata a cláusula Primeira será realizada no período de, -data_inicio- à -data_fim-.\r\n<b>CLÁSULA 3°</b> - O aluguel diário deverá ser cobrado entre -diaria1- e -diaria2-, cujos valores poderão variar para mais ou para menos de conformidade com o comportamento do mercado na época, ou ainda mediante confirmação do proprietário.\r\n<b>CLÁSULA 4°</b> - O administrador deverá locar o imóvel com a característica contratual de Locação Para Temporada e, assim, seguir as normas legais pertinentes a ela.\r\n<b>CLÁSULA 5°</b> - Pelo serviço ora contratado o PROPRIETÁRIO se compromete a pagar ao ADMINISTRADOR,  a título de honorários, -comissao-%, sobre o valor da locação.\r\n<b>CLÁSULA 6°</b> - O valor do Aluguel recebido, já deduzido o percentual previsto na cláusula anterior, deverá o ADMINISTRADOR depositar até o 5°(quinto) dia últil subseqüente ao recebimento, na -conta-.\r\n<b>CLÁSULA 7°</b> - Os pagamentos de água, luz, telefone, condomínio, Iptu., gás, primeira limpeza e eventuais consertos são de responsabilidade do proprietário, porem se algum pagamento previsto nesta cláusula, for realizado pelo administrador, ditas importâncias serão deduzidas do aluguel, por ocasião do depósito ou ressarcido mediante a apresentação de notas fiscais ou recibos dos serviços executados.\r\n<b>CLÁSULA 8°</b> - O ADMINISTRADOR fica isento de qualquer responsabilidade, no caso de invasões, roubos, depredações, incêndios e outros atos ocasionados por terceiros ou por fenômenos da natureza. Ficando o Administrador responsável pela limpeza e conferências dos móveis e objetos que compoem o imóvel, objeto da presente, na saída dos inquilinos. Responsabilidade que cessará por ocasião do vencimento deste contrato.\r\nE por estarem, assim, justos e contratados, as partes assinam o presente contrato em 02(duas) vias de igual teor e forma.', 'Contrato de Intermediação Imobiliário para fins de Locação para Temporada', current_date, 2)";
	$resultd1 = mysql_query($queryd1) or die("Não foi possível inserir suas informações.($queryd1)");
	$queryd2 = "INSERT INTO doc (cod_imobiliaria, d_txt, d_nome, d_data, d_cod) VALUES('$cod_imobiliaria', '-cidade_im-, -data_hoje-.\r\n\r\n\r\nPrezado(a) Sr(a). -nome-,\r\n\r\nReferente a opção de venda do imóvel situado à -end_imovel-, em  -cidade_im-/-uf_im-, de sua propriedade.\r\n\r\nGostaríamos de manter sua opção atualizada, para que possamos continuar a divulgação em nossa sede e também através de parcerias com diversas imobiliárias da capital, interior e litoral, sempre buscando alcançar a melhor negociação para o seu imóvel. \r\n\r\nPara que isto ocorra, tomamos as seguintes medidas:\r\n- Atendimento com qualidade em nossa sede todos os dias, inclusive sábados, domingos e feriados;\r\n- Veiculação em nosso site na internet - -site_im- - utilizando fotos, mapa de localização e descrição detalhada;\r\n- Promoção no local do imóvel através de placas, faixas e sinalização na região;\r\n- Publicação em nosso informativo imobiliário com distribuição de milhares de exemplares em diferentes regiões;\r\n- Publicidade através de painéis em estradas de acesso ao litoral para que seu imóvel seja encontrado em nossa imobiliária;\r\n- Contato constante com potenciais interessados através de busca em nosso cadastro informatizado;\r\n- Assessoria completa na formalização de proposta, elaboração de contratos e acompanhamento até fechamento do negócio.\r\n\r\n\r\nEm anexo seguem duas vias de opção, preenchidas de acordo com a anterior, que após assinadas, pedimos à gentileza de enviar uma via para nosso endereço: -nome_im-, -end_im- CEP.-cep_im- -cidade_im-/-uf_im-.\r\n\r\nOBS: Segue envelope já endereçado para -nome_im-, sendo necessário apenas selar e nos enviar. \r\n\r\n\r\nAtenciosamente.\r\n\r\n\r\n-prop_im-', 'Carta Renovação Opção Venda', current_date, 4)";
	$resultd2 = mysql_query($queryd2) or die("Não foi possível inserir suas informações.($queryd2)");
	$queryd3 = "INSERT INTO doc (cod_imobiliaria, d_txt, d_nome, d_data, d_cod) VALUES('$cod_imobiliaria', 'Ref.: -ref-\r\n                                      \r\nO(a)s abaixo(s) assinado(s), contrata(m) com -nome_im- CNPJ. -cnpj_im-, pessoa jurídica inscrita no crecí n° -n_conselho_im-, estabelecido na -end_im-, em -cidade_im-/-uf_im-, a prestação de seus serviços profissionais para com exclusividade promover a venda e fechar negócio do imóvel abaixo descrito, conforme matricula n° -mat- do registro de imóveis da cidade de -cidade_mat- .\r\nImóvel sito à -end_imovel-, nesta cidade. Pelo preço de R$ -valor-. À vista ou nas seguintes condições: (à combinar com o proprietário).\r\n\r\nOBRIGANDO-SE:\r\n1° - A não tratar da venda diretamente ou por intermédio de outrem durante <b>-dias_uteis-</b> dias úteis a contar desta data, prorrogando-se esse prazo por igual periodo, caso o vendedor não venha se opor por escrito.\r\n2°- A pagar  pela mediação, no ato da assinatura da escritura, seja definitiva, seja  de promessa de compra e venda, em remuneração de seus serviços de mediação, o percentual de (-com_venda-%) seis por cento sobre o preço da aqui autorizada; que será descontado pela autorizada no ato do recebimento do sinal de negócio ou entrada.\r\n3 °- A pagar os honorários acima, mesmo fora do prazo de validade deste contrato, se a venda do imóvel for efetuada a comprador apresentado pelo referido corretor ou empresa, ou alguém com quem haja iniciado negociações, bem como sócios ou parentes destes;\r\n4° - A referendar qualquer venda feita dentro das condições mínimas acima especificadas, bem como dar por firme e valioso qualquer sinal de negócio recebido, que o corretor ou empresa acima fica desde já expressamente autorizado a receber e do mesmo passar recibo, responsabilizando-se por sí, seus herdeiros e sucessores;\r\n_Parafrafo 1º - Em caso de desistência por parte do promitente vendedor (outorgante) com relação ao sinal de negócio recebido, responsabiliza-se o mesmo pelos prejuízos e danos causados (Código Civil Brasileiro - Arts.417 à 420, além do pagamento dos honorários havido por direito; (-com_venda-%) seis por cento.\r\n5° - A empresa -nome-im-, poderá  colocar placa ou faixa no imóvel, bem como divulgar com fotos na internet.\r\n6° - Vencido o presente contrato, salvaguardados os casos previstos na cláusula 3, não tendo sido vendido o imóvel objeto deste, fica o outorgante desobrigado de qualquer  pagamento ao corretor ou empresa.\r\n7º - A contratada deverá promover a venda do imóvel com o máximo de zelo e profissionalismo. Acompanhar os pretendentes para visitas no imóvel. Levar ao conhecimento do contratante todas as propostas e ofertas dos interessados.\r\n_Parafrafo 2º - A contratada fica isenta de qualquer responsabilidade, no caso de invasões, roubos, depredações, incêndios e outros atos ocasionados por terceiros ou por fenômenos da natureza. A GUARDA DO IMÓVEL É DE RESPONSABILIDADE DO CONTRATANTE. \r\nE por estarem assim justos e contratados, as partes elegem o foro de -cidade_im-/-uf_im- para dirimência de dúvidas, oriundas do presente contrato que vai assinado em duas vias de igual teor e forma.\r\n\r\nPROPRIETÁRIO(A): -nome_prop-, -origem_prop-, -civil_prop-, RG.: -rg_prop-, CPF: -cpf_prop-, com residência à -end_prop-, -cidade_prop-, -estado_prop-, Tel.: -tel_prop-.\r\n\r\n', 'Contrato de Prestação de Serviços para Venda de Imóveis', current_date, 5)";
	$resultd3 = mysql_query($queryd) or die("Não foi possível inserir suas informações.($queryd3)");
	$queryd4 = "INSERT INTO doc (cod_imobiliaria, d_txt, d_nome, d_data, d_cod) VALUES('$cod_imobiliaria', 'A quem interessar possa, avaliamos o seguinte imóvel: -imov_aval- todos da -end_aval- nesta cidade.\r\n\r\nCom as medidas constante da matrícula do registro de imóveis.\r\n\r\n<b>VALOR DO IMÓVEL:</b>\r\n\r\nConsiderando a região onde esta localizado o imóvel, atribuímos para efeito de avaliação o valor de R$ -valor_aval- (-ext_aval-).\r\n\r\nE, para que produza os efeitos desejados, firmamos o presente.\r\n\r\n-cidade_im-, -data_hoje-.\r\n                                                      \r\n-prop_im-\r\nCreci -n_conselho_im-', 'Laudo de Avaliação', current_date, 6)";
	$resultd4 = mysql_query($queryd4) or die("Não foi possível inserir suas informações.($queryd4)");
	$queryd5 = "INSERT INTO doc (cod_imobiliaria, d_txt, d_nome, d_data, d_cod) VALUES('$cod_imobiliaria', '<b>MEDIADOR:</b> -nome_im-, pessoa física de direito privado, incrito no creci -uf_im- Nº -n_conselho_im-, com escritório na -end_im-, em -cidade_im/-uf_im-.\r\n\r\n<b>Proponente Comprador:</b> -nome-, portador da Rg -rg-, Cpf: -cpf-, Est. Civil: -civil-, Profissão: -profissao-, Nascionalidade: -origem-,  End: -end-, -bairro-, -cidade-/-estado-, CEP: -cep-, tel.: -tel-\r\n\r\nPropõe à -prop_im-, a compra do imóvel com as seguintes características: -desc_imovel-, Matrícula: -matricula-(-cidade_mat-). Endereço: -end_imovel-, -local-. De propriedade de: -nome_prop-. Pelo preço e condições abaixo propostas: -proposta- . Em sendo aceito pelo proprietário(a) e com a assinatura do MEDIADOR o preço e as condições de pagamentos acima discriminados, a presente proposta passa a representar recibo de sinal de negócio e princípio de pagamento que será tutelado de acordo com as normas e condições gerais abaixo:\r\n1)O recebimento do sinal de negócio e princípio de pagamento, após aceita a proposta pelo(s) vendedor(es), é realizado de acordo com contido nos artigos 417 à 420 do Código Civil Brasileiro - Arras Penitencial -sendo o arrependimento por parte do(s) vendedor(es), implicará na devolução em dobro da importância recebida a título de sinal de negócio e princípio de pagamento; caso o arrependimento se dê pelo(a)comprador(a), este(a) perderá o sinal dado em favor do(s)vendedor(es).\r\n2)Sobre o valor da transação incidirá a comissão de (06) % seis por cento a ser paga pelo(s) Proprietário(s) vendedor(es).\r\n3)Todas as despesas necessárias à formalização do presente compromisso, tais como escrituras, cartório de registro de imóveis, pagamento de ITBI-Imposto de Transmissão de Bens Imóveis, Laudêmio, certidões do imóvel, certidões dos vendedores, etc. correrão por conta do(a) comprador(a).\r\n4)A Escritura Pública de Compra e venda será outorgada no tabelionato de -cidade_im-/-uf_im-. Condicionado à apresentação das certidões pelos vendedores .\r\n5)Todos os tributos, impostos ou taxas que incidam sobre o imóvel objeto da presente transação serão por conta do(s) vendedor(es), até o dia (-data_hoje-). \r\n6)É de responsabilidade do(s)proprietário(s); vendedor(es) a guarda e segurança do imóvel quanto a roubos e depredações até a data da entrega das chaves ou assinatura de compromisso de compra ou escritura definitiva; aquela que for primeira efetuada.\r\n7)O presente instrumento obriga os contratantes e seus herdeiros e sucessores no seu integral cumprimento.\r\n8)Fica eleito o foro de -cidade_im-/-uf_im-, para dirimir quaisquer dúvidas.\r\n\r\nConcordo(amos) com o preço e condições acima estipulados.\r\n', 'Proposta para Compra de Imóvel', current_date, 7)";
	$resultd5 = mysql_query($queryd5) or die("Não foi possível inserir suas informações.($queryd5)");
	$queryd6 = "INSERT INTO doc (cod_imobiliaria, d_txt, d_nome, d_data, d_cod) VALUES('$cod_imobiliaria', 'Pelo presente instrumento de um lado -prop_im-, corretor de imóveis \r\ncreci -n_conselho_im-, pessoa física de direito privado, e de outro lado -nome- portador da RG. -rg-  e CPF. -cpf-, declara ter recebido do segundo contratante, a importância supra de R$ -valor- pago -forma_pagto-, como sinal de negócio e princípio de pagamento da quantia total de R$ -valor_total- comprometendo-me a vender ao mesmo livre e desembaraçado de ônus, ou gravames de qualquer natureza, o imóvel de propriedade do(a) Sr.(a) -nome_prop- e na qualidade de promotor de venda devidamente autorizado, conforme contrato de prestação de serviços para venda de imóveis firmado com (a) proprietário (a), declaro que o imóvel objeto do presente recibo é constituído de -desc_imovel- (da cidade de -cidade_im-, -uf_im-). Outrossim, dou plena quitação da importância ora recebida com 'Arras' e princípio de pagamento, devendo o saldo restante de R$ -valor_saldo-. Ser pago da seguinte maneira: no ato da escritura, que deverá ser realizada no dia -data_esc-. Todas as despesas restantes decorrentes da escritura, compromisso de compra e venda, sessões de direitos, ITBI., Laudêmios, Registros de Imóveis, transferências, serão exclusiva responsabilidade do comprador, inclusive com operação de financiamento tais como, taxas de abertura de crédito emolumentos, buscas, certidões e que mais for exigido para o perfeito cumprimento da legislação que regula a matéria, bem como os impostos e taxas que venham a recair sobre o imóvel a partir da assinatura do instrumento em cartório entre as partes, correndo por conta do vendedor  os impostos e taxas até a data do fechamento do negócio e a comissão da corretagem. Respondendo pela evicção legal do imóvel, proprietário(s) seus herdeiros e sucessores. A presente  transação é realizado pelo artigo 1095 do Código Civil Brasileiro, obrigando solidariamente, seus herdeiros e sucessores ao integral cumprimento do presente, sem prejuízo do pagamento da comissão devida a firma ou corretor. O vendedor obriga-se a assinar a escritura de Compra e Venda ou documento equivalente, no prazo de (30) (trinta) dias a contar desta data. E por estarem justos e de comum acordo em todas as cláusulas e condições do presente instrumento, assinam o mesmo em duas vias, na presença de duas testemunhas, ficando eleito o foro de -cidade_im-, do Estado do(a) -uf_im- para dirimir quaisquer pendências com fundamento na presente transação.\r\n', 'Recibo de Sinal de Negócio e Princípio de Pagamento', current_date, 8)";
	$resultd6 = mysql_query($queryd6) or die("Não foi possível inserir suas informações.($queryd6)");
	$queryd7 = "INSERT INTO doc (cod_imobiliaria, d_txt, d_nome, d_data, d_cod) VALUES('$cod_imobiliaria', '<b>Imóvel:</b> -desc_imov-, sito à -end_imov-.\r\n<b>Locador:</b> -nome_prop-, -origem_prop-, -civil_prop-, portadora da carteira de identidade RG n° -rg_prop- e CPF: -cpf_prop-, residente na -end_prop-, -cidade_prop-, -estado_prop-.\r\n<b>Locatário:</b> -nome_loc-, -origem_loc-, -civil_loc-, portadora da carteira de identidade RG n° -rg_loc- e CPF: -cpf_loc-, residente na -end_loc-, CEP: -cep_loc-, -cidade_loc-, -estado_loc-, Tel.: -tel_loc-.\r\nAs partes, acima qualificadas, ajustam a locação por temporada do imóvel do objeto do presente contrato mediante as cláusulas e condições seguintes:\r\n<b>CLÁUSULA 1°-</b> O prazo de locação de temporada será de -total_dias- dias a partir do dia -data_ent- terminando dia <b>-data_sai-</b> com saída até às <b>10:00h</b> do dia seguinte ao último dia do contrato, data em que o locatário se obriga a restituir o móvel locado, completamente desocupado.\r\n<b>CLÁUSULA 2°-</b> O aluguel da temporada corresponde ao total de R$-total_final-, referente ao total das diárias (-total-) mais a taxa administrativa(-limpeza-), que será pago integralmente e antecipadamente mediante a assinatura do contrato; neste ato pago da seguinte maneira: -l_pagto-.\r\n<b>CLÁUSULA 3°-</b> A diária estabelecida é para o número máximo de <b>-acomod- pessoas</b>, não podendo esse limite ser ultrapassado sem consentimento por escrito do locador. O descumprimento de qualquer das cláusulas do presente contrato, ensejará a sua recisão, perdendo o locatário todas as diárias pagas.\r\n<b>CLÁUSULA 4°-</b> São obrigações do Locatário, além das outras previstas em lei:\r\na)-não ceder ou franquear o imóvel para terceiro, sem o prévio e expresso consentimento, por escrito, do locador;\r\nb)-restituir o imóvel nas mesmas condições que o recebeu, limpo, sem estragos, avarias ou danos, inclusive os móveis e utensílios, guarnições e outros pertences.\r\nc)- Zelar pela guarda do imóvel: Ao sairem do imóvel, certificar-se que todas as portas, portões e janelas estejam trancada. Ficando o locador ou seu administrador isento de qualquer responsabilidade, no caso de invasões, roubos, depredações, incendios e outros atos ocasionados por terceiros ou por fenômenos da natureza. A GUARDA DO IMÓVEL É DE RESPONSABILIDADE DO LOCATÁRIO.\r\n<b>CLÁUSULA 5°-</b> O locatário, desde já, faculta ao locador examinar o imóvel locado, quando este achar necessário, não necessitando o mesmo de avisar previamente o locatário.\r\n<b>CLÁUSULA 6°-</b> Em caso de desistência da presente locação de temporada pelo locatário, perderá este todas as diárias pagas, devendo ainda quitar débitos existentes oriundos da locação.\r\n<b>CLÁUSULA 7°-</b> No último dia da temporada, o locador fará a vistoria dos móveis e utensílios existentes no imóvel, juntamente com o locatário, quando deverão ser devolvidas as chaves.\r\n<b>CLÁUSULA 8°-</b> O locatário será responsável por qualquer multa a que der causa por desrespeito às leis federais, estaduais, municipais, normas das autarquias ou do regulamento interno do prédio, se houver.\r\n<b>CLÁUSULA 9°-</b> Fica expressamente e definitivamente proibido ao locatário, sob pena de rescisão contratual e consequente despejo, manter no imóvel locado qualquer tipo de animal, mesmo doméstico.\r\n<b>CLÁUSULA 10°-</b> O locatário responderá pelo incêndio do imóvel, se não provar caso fortuito, força maior ou propagação de fogo originado em outro imóvel, de conformidade com o artigo 1.208 e seu paragráfo único do Código Civil. No caso de incêndio do imóvel locado, ficará o presente contrato rescindido pelo pleno direito, independente de notificação.\r\n<b>CLÁUSULA 11°-</b> Caso o locatário não desocupe o imóvel no dia estipulado no contrato, estará obrigado a pagar as diárias que excederem ao dia fixado à sua saída.\r\nE por estarem justos e contratados, assinam o presente em duas vias de igual teor e forma.\r\n', 'Contrato de Locação de Temporada', current_date, 9)";
	$resultd7 = mysql_query($queryd7) or die("Não foi possível inserir suas informações.($queryd7)");


	//insere na tabelas de usuarios
	$query01 = "INSERT INTO usuarios (cod_imobiliaria,u_nome,u_email,u_senha,u_tipo) VALUES('".$cod_imobiliaria."','".$im_nome."','".$im_email."','".$senha."','admin')";
	mysql_query($query01) or die("Não foi possível pesquisar suas informações.");
	$tmp_cod = mysql_insert_id();

	//insere na tabela com todas as permissoes nas areas cadastradas
	$query02 = "select * from area";
	$result02 = mysql_query($query02) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result02);
	while($not0 = mysql_fetch_array($result02)) {
		$area_id = $not0['area_id'];
		$query10 = "INSERT INTO rel_area_usuario (area_id,u_cod) VALUES('".$area_id."','".$tmp_cod."')";
		mysql_query($query10) or die("Não foi possível pesquisar suas informações.");
	}

	function geraCodigoComputador() {
	$_letras	=	"ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$_numeros	=	"0123456789";
	do {
		$_codigo 	=	substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1);
		$SQL = "SELECT * FROM computador WHERE computador_codigo = '".$_codigo."'";
		$statement = mysql_query($SQL);
	} while (mysql_num_rows($statement) == 1);
	return $_codigo;
	}

	function geraCookie() {
	$_letras	=	"ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$_numeros	=	"0123456789";
	do {
		$_codigo 	=	substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).
						substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).
						substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).
						substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).substr($_letras, rand(0, 25), 1).
						substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1).substr($_numeros, rand(0, 9), 1);
		$SQL = "SELECT * FROM computador WHERE computador_cookie = '".$_codigo."'";
		$statement = mysql_query($SQL);
	} while (mysql_num_rows($statement) == 1);
	return $_codigo;
	}

	$inserir = "INSERT INTO computador (cod_imobiliaria, computador_nome, computador_codigo, computador_cookie, computador_ativo) VALUES ('".$cod_imobiliaria."','".$nome_imobiliaria."', '".geraCodigoComputador()."', '".geraCookie()."', '1')";
	mysql_query($inserir) or die("Não foi possível pesquisar suas informações.");

?>
      <p align="center"><b>Você cadastrou a imobiliária <?php print("$im_nome"); ?>.
<?php
	}
	else
	{
?>
      <p align="center"><b>A imobiliária <?php print("$im_nome"); ?> já está cadastrada.</b>
<?php
	}
?>
<?php
    }else{
	  echo ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");document.location.href="p_imobiliarias.php";</script>');
	}
}
//Apaga Imobiliária
if($B1 == "Apagar")
	{
		$lista = 1;
	if (!isset($envio)){
		//O formulário abaixo repete também na linha 199. Sempre que alterar um precisa alterar o outro pra deixar igual
?>
              <table border="0" width="80%" align="center">
              <form name="form1" action="p_imobiliarias.php" method="post">
               <tr>
               <td align="center" height = "50" class=style2>
               Para apagar a imobiliária <b><?php print("$im_nome"); ?></b> e todos os seus imóveis digite o código abaixo:
               </td></tr>
               <!-- gera imagem com número aleatório -->
               <tr><td align="center">
               <img src="imagem.php">
               </td></tr>
               <tr>
               <td align="center" height = "50" class=style2>
               <input type=text name="codigo" size = "12" class=campo>
               </td></tr>
               <tr>
               <td align="center">
               <input type="submit" name="Submit" value="Enviar" class=campo>
               <input type="reset" name="Submit" value="Limpar" class=campo>
               <input type="hidden" name="envio" value="true">
               <input type="hidden" name="B1" value="Apagar">
               <input type="hidden" name="im_nome" value="<?php print("$im_nome"); ?>">
               <input type="hidden" name="im_cod" value="<?php print("$im_cod"); ?>">
               </td>
               </tr>
              </form>
               </table>
<?php
	}
// Recupera o código randomico e termina a sessão
//ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
//if(IsSet($_SESSION["codigo"]))
if(session_is_registered("codigo"))
   {
    $random = $_SESSION["codigo"];
    //$_SESSION = array();
    session_unregister("codigo");
   }

// obtém o código digitado
$codigo = $_POST["codigo"];
$envio = $_POST["envio"];

// verifica se o formulário contém dados
 if (isset($envio) and $codigo == $random)
 {
   $mensagem = "Parabéns. O código foi digitado corretamente.";
   echo $mensagem . "<br>";
?>

<?php
	$query4 = "select * from rebri_imagens where img_imob='$im_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{

	$foto = explode(".", $not5[img_arq]);
	$foto_peq = $foto[0] .  "_peq.jpg";

	if (file_exists($caminhob.$not4[img_arq]))
	{
	unlink($caminhob.$not4[img_arq]);
	}
	}

	if (file_exists(caminhop.$foto_peq))
	{
	unlink($caminhop.$foto_peq);
	}

	}

	$query = "delete from rebri_imoveis where i_imob = '$im_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");

	$query = "delete from rebri_imagens where img_imob = '$im_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");

	//busca o nome da pasta
	$busca = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$im_cod."'");
    while($linha = mysql_fetch_array($busca)){
         $pasta = $linha['nome_pasta'];
    }

	// apaga pasta
	$dirl = "../imobiliarias/".$pasta."/locacao/";
	rmdir($dirl);

	$dirlp = "../imobiliarias/".$pasta."/locacao_peq/";
	rmdir($dirlp);

	$dirv = "../imobiliarias/".$pasta."/venda/";
	rmdir($dirv);

	$dirvp = "../imobiliarias/".$pasta."/venda_peq/";
	rmdir($dirvp);

	$dirp = "../imobiliarias/".$pasta;
	rmdir($dirp);

	$query = "delete from rebri_imobiliarias where im_cod = '$im_cod'";
	$result = mysql_query($query) or die("Não foi possível apagar suas informações. $query");

?>
<p align="center">
Você apagou a imobiliária <i><?php print("$im_nome"); ?></i> e todos os imóveis e fotos relacionados a ela.</p>
<?php
 }elseif(isset($envio) and $codigo != $random)
 {
   $mensagem = "Erro! Por favor tente novamente.";
   echo $mensagem . "<br>";
   //O formulário abaixo repete também na linha 109. Sempre que alterar um precisa alterar o outro pra deixar igual
?>
              <table border="0" width="80%" align="center">
              <form name="form1" action="p_imobiliarias.php" method="post">
               <tr>
               <td align="center" height = "50" class=style2>
               Para apagar a imobiliária <b><?php print("$im_nome"); ?></b> e todos os seus imóveis digite o código abaixo:
               </td></tr>
               <!-- gera imagem com número aleatório -->
               <tr><td align="center">
               <img src="imagem.php">
               </td></tr>
               <tr>
               <td align="center" height = "50" class=style2>
               <input type=text name="codigo" size = "12" class=campo>
               </td></tr>
               <tr>
               <td align="center">
               <input type="submit" name="Submit" value="Enviar" class=campo>
               <input type="reset" name="Submit" value="Limpar" class=campo>
               <input type="hidden" name="envio" value="true">
               <input type="hidden" name="B1" value="Apagar">
               <input type="hidden" name="im_nome" value="<?php print("$im_nome"); ?>">
               <input type="hidden" name="im_cod" value="<?php print("$im_cod"); ?>">
               </td>
               </tr>
              </form>
               </table>
<?php
 }
}

//Atualizar Imobiliária
if($atualiza == "1")
{


	$pw_query = "SELECT u_cod FROM usuarios WHERE u_email ='".$im_email."' AND u_senha='".md5($im_senha)."' AND cod_imobiliaria='".$im_cod."'";
	$pw_result = mysql_query($pw_query) or die("Não foi possivel inserir suas informações");
	$pw_rows = mysql_num_rows($pw_result);
	if ($pw_rows == 0) {



	$im_senha = base64_encode($im_senha);

	$nome_imobiliaria = $im_nome;

	// tira os acentos e espaço
	$im_nome = ereg_replace("[ÁÀÂÃ]","A",$im_nome);
	$im_nome = ereg_replace("[áàâãª]","a",$im_nome);
	$im_nome = ereg_replace("[ÉÈÊ]","E",$im_nome);
	$im_nome = ereg_replace("[éèê]","e",$im_nome);
	$im_nome = ereg_replace("[ÓÒÔÕ]","O",$im_nome);
	$im_nome = ereg_replace("[óòôõº]","o",$im_nome);
	$im_nome = ereg_replace("[ÚÙÛ]","U",$im_nome);
	$im_nome = ereg_replace("[úùû]","u",$im_nome);
	$im_nome = ereg_replace("[íìî]","i",$im_nome);
	$im_nome = ereg_replace("[ÍÌÎ]","I",$im_nome);
	$im_nome = str_replace("Ç","C",$im_nome);
	$im_nome = str_replace("ç","c",$im_nome);
	$im_nome = str_replace(" ","",$im_nome);

	// pega o nome da imobiliária, deixa em minúsculas e pega os 6 primeiros caracteres se caso for menor que 6 complementa com 0
	if(strlen($im_nome) < 6){
	    if(strlen($im_nome) == 5){
     		$nome_pasta = strtolower($im_nome."0");
     	}elseif(strlen($im_nome) == 4){
		   $nome_pasta = strtolower($im_nome."00");
		}elseif(strlen($im_nome) == 3){
		  $nome_pasta = strtolower($im_nome."000");
		}elseif(strlen($im_nome) == 2){
		  $nome_pasta = strtolower($im_nome."0000");
		}elseif(strlen($im_nome) == 1){
		  $nome_pasta = strtolower($im_nome."00000");
		}
	}elseif(strlen($im_nome) >= 6){
		$nome_pasta = strtolower(substr($im_nome,0,6));
	}

	// verifica se a pasta já existe
	if (file_exists("../imobiliarias/" . $nome_pasta)) {
   		$cont = 1; // contador de pastas

   	// verifica qual a ultima pasta criada e incrementa 1
   	while (file_exists("../imobiliarias/" . $nome_pasta . $cont)) {
       	$cont++;
   	}

   	$nome_pasta .= $cont;
	}

	//busca o nome da pasta
	$busca = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$im_cod."'");
    while($linha = mysql_fetch_array($busca)){
         $pasta = $linha['nome_pasta'];
    }

	// cria nova pasta
	$dirp = "../imobiliarias/".$nome_pasta;
	rename("../imobiliarias/".$pasta, $dirp);

	$query = "update rebri_imobiliarias set im_nome='$nome_imobiliaria', im_contato='$im_contato', im_nacionalidade='$im_nacionalidade', im_est_civil='$im_est_civil', im_n_conselho='$im_n_conselho', im_cnpj='$im_cnpj', im_tel='$im_tel'
	, im_fax='$im_fax', im_cel='$im_cel', im_email='$im_email', im_senha='$im_senha'
	, im_cidade='$im_cidade', im_estado='$im_estado', im_end='$im_end', im_bairro='$im_bairro'
	, im_cep='$im_cep', im_site='$im_site', im_img='$im_img', im_desc='$im_desc', nome_pasta='$nome_pasta' where im_cod='$im_cod'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações. $query");

?>
<p align="center">
Você atualizou a imobiliária <i><?php print("$im_nome"); ?></i>.</p>
<?php

	}else{
	  echo ('<script language="javascript">alert("E-mail e/ou senha já cadastrados!");document.location.href="p_imobiliarias.php";</script>');
	}

}
if($lista == "")
	{

	if(!$screen){
	$screen = 1;
	}

	if(!$from){
	$from = intval(($screen - 1) * 30);
	}

	$query1 = "select * from rebri_imobiliarias i inner join rebri_estados e on (i.im_estado=e.e_cod) inner join rebri_cidades c on (i.im_cidade=c.ci_cod)
	order by i.im_nome
	limit $from, 30";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<div align="center">
  <center>
                  <table width="600" cellpadding="1" cellspacing="1" bgcolor="#<?php print("$cor1"); ?>">
                  <tr><td colspan="5" bgcolor="#<?php print("$cor5"); ?>">
                  <p align="center"><b>
                  <i><?php print("$ca_nome"); ?></i></b></p></td></tr>
                  <tr><td>
                  <b>Nome</b></td><td>
                  <b>Contato</b></td><td>
                  <b>E-mail</b></td><td>
                  <b>Cidade</b></td><td>
                  <b>Estado</b></td></tr>
<?php
	$i = 1;

	while($not = mysql_fetch_array($result1))
	{
	$from = $from + 1;

	if (($i % 2) == 1){ $fundo="DCE0E4"; }else{ $fundo="EDEEEE"; }
	$i++;
?>
<tr bgcolor="<?php print("$fundo"); ?>"><td width="25%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[im_nome]"); ?></a></td><td width="20%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[im_contato]"); ?></a></td><td width="20%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[im_email]"); ?></a></td><td width="20%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[ci_nome]"); ?></a></td><td width="15%" class=style2>
<a href="p_imobiliarias.php?im_cod=<?php print("$not[im_cod]"); ?>&edit=editar&lista=1" class=style2><?php print("$not[e_nome]"); ?></a></td>
</tr>
<?php
	}

	$query2 = "select count(im_cod) as contador
	from rebri_imobiliarias";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$pages = ceil($not2[contador] / 30);
?>
                  <tr><td colspan="5" bgcolor="#<?php print("$cor5"); ?>">

                  <p align="center">
                  <i>Foram encontradas <?php print("$not2[contador]"); ?> imobiliárias</i></td></tr>
                  <tr><td colspan=4 align=center class=style2>
<?php
	if ($from > 30) {
	$url1 = $PHP_SELF . "?screen=" . ($screen - 1);
?>
                  <a href="javascript:history.back()" class=style2>
                  << Página anterior <<</a>
<?php
	}
	else
	{
?>
                  <a href="javascript:history.back()" class=style2>
                  << Página anterior <<</a>
<?php
	}

	for ($i = 1; $i <= $pages; $i++) {
		if($pesq == ""){
  	$url2 = $PHP_SELF . "?screen=" . $i;
		}
		else
		{
  	$url2 = $PHP_SELF . "?screen=" . $i;
		}
  	if($i == $screen){
  	echo "   | <a href=\"$url2\"><b><font color=#ff0000>$i</b></a> |   ";
	}
  	else
  	{
  	echo "   | <a href=\"$url2\" class=style2>$i</a> |   ";
  	}
	}

	if ($from >= $not2[contador]) {
?>

		  Última página da pesquisa
<?php
	}
	else
	{
		if($pesq == ""){
  	$url3 = $PHP_SELF . "?screen=" . ($screen + 1);
		}
		else
		{
  	$url3 = $PHP_SELF . "?screen=" . ($screen + 1);
		}
?>
                  <a href="<?php print("$url3"); ?>" class=style2>
                  >> Próxima Página >></a>
<?php
	}
?>
                  </td></tr>
<?php
	}
?>
	</table>
	</center>
	</div>
<?php
	}
//mysql_close($con);
?>
<?php
	}
	else
	{
?>
<?php
	if($edit == "editar"){
	$query2 = "select *, (select ci_nome from rebri_cidades where ci_cod=im_cidade) as cidade_nome from rebri_imobiliarias where im_cod = '$im_cod'";
	$result2 = mysql_query($query2);
	while($not2 = mysql_fetch_array($result2))
	{
	$ano1 = substr ($not2[im_nasc], 0, 4);
	$mes1 = substr($not2[im_nasc], 5, 2 );
	$dia1 = substr ($not2[im_nasc], 8, 2 );

	$not2[im_senha] = base64_decode($not2[im_senha]);
	$img = $not2['im_img'];

if(!IsSet($editar))
	{
?>
<script language="JavaScript">
function Dados(valor) {
	  try {
         ajax = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e) {
         try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax = null;
            }
         }
      }
	  if(ajax) {
		 document.forms[0].im_cidade.options.length = 1;
		 idOpcao  = document.getElementById("opcoes");
	     ajax.open("POST", "cidades.php", true);
		 ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 ajax.onreadystatechange = function() {
			if(ajax.readyState == 1) {
			   idOpcao.innerHTML = "Aguarde...!";
	        }
            if(ajax.readyState == 4 ) {
			   if(ajax.responseXML) {
			      processXML(ajax.responseXML);
			   }
			   else {
				   idOpcao.innerHTML = "Selecione o Estado";
			   }
            }
         }
	     var params = "estado="+valor;
         ajax.send(params);
      }
   }
   function processXML(obj){
      var dataArray   = obj.getElementsByTagName("cidade");
	  if(dataArray.length > 0) {
         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
	        idOpcao.innerHTML = "Selecione uma opção";
			var novo = document.createElement("option");
			    novo.setAttribute("ci_cod", "opcoes");
			    novo.value = codigo;
			    novo.text  = descricao;
				document.forms[0].im_cidade.options.add(novo);
		 }
	  }
	  else {
		idOpcao.innerHTML = "Selecione o Estado";
	  }
 }

</script>
 <div align="center">
  <center>
  	<table>
	<tr>
		<td>
  <form method="post" name="formulario" action="p_imobiliarias.php">
  <input type="hidden" name="editar" value="1">
  <input type="hidden" name="atualiza" id="atualiza" value="0">
  <input type="hidden" value="<?php print("$not2[im_cod]"); ?>" name="im_cod">

  <table border="0" cellspacing="1" width="100%">
    <tr>
      <td width="20%" class=style2>Nome:</td>
      <td width="80%" class=style2> <input type="text" name="im_nome" id="im_nome" size="40" class="campo" value="<?php print("$not2[im_nome]"); ?>"></td>
    </tr>
	<tr>
      <td width="20%" class=style2>N° do Creci:</td>
      <td width="80%" class=style2> <input type="text" name="im_n_conselho" size="10" class="campo" value="<?php print("$not2[im_n_conselho]"); ?>"></td>
    </tr>
	 <tr>
      <td width="20%" class=style2>CNPJ:</td>
      <td width="80%" class=style2> <input type="text" name="im_cnpj" size="20" class="campo" value="<?php print("$not2[im_cnpj]"); ?>" onKeyPress="return (Mascara(this,event,'###.###.###/####-##'));return validarCampoNumerico(event);"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Contato:</td>
      <td width="80%" class=style2> <input type="text" name="im_contato" id="im_contato" size="40" class="campo" value="<?php print("$not2[im_contato]"); ?>"></td>
    </tr>
	 <tr>
      <td width="20%" class=style2>Nacionalidade:</td>
      <td width="80%" class=style2> <input type="text" name="im_nacionalidade" size="40" class="campo" value="<?php print("$not2[im_nacionalidade]"); ?>"></td>
    </tr>
	 <tr>
      <td width="20%" class=style2>Estado Civil:</td>
      <td width="80%" class=style2><select name="im_est_civil" class="campo">
	        <option value="0">Selecione</option>
			<option value="Casado(a)" <? if($not2[im_est_civil]=='Casado(a)'){ print "SELECTED"; } ?>>Casado(a)</option>
			<option value="Divorciado(a)" <? if($not2[im_est_civil]=='Divorciado(a)'){ print "SELECTED"; } ?>>Divorciado(a)</option>
			<option value="Separado(a)" <? if($not2[im_est_civil]=='Sperado(a)'){ print "SELECTED"; } ?>>Separado(a)</option>
			<option value="Solteiro(a)" <? if($not2[im_est_civil]=='Solteiro(a)'){ print "SELECTED"; } ?>>Solteiro(a)</option>
			<option value="Viúvo(a)" <? if($not2[im_est_civil]=='Viúvo(a)'){ print "SELECTED"; } ?>>Viúvo(a)</option>
	     </select></td>
    </tr>
    <tr>
      <td width="20%" class=style2>E-mail:</td>
      <td width="80%" class=style2> <input type="text" name="im_email" id="im_email" size="40" class="campo" value="<?php print("$not2[im_email]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Senha:</td>
      <td width="80%" class=style7> <input type="text" name="im_senha" id="im_senha" size="6" class="campo" maxlength="6" onKeyUp="return autoTab(this, 6, event);" value="<?php print("$not2[im_senha]"); ?>"> Obs.: 6 dígitos</td>
    </tr>
    <tr>
      <td width="20%" class=style2>Telefone:</td>
      <td width="80%" class=style2> <input type="text" name="im_tel" id="im_tel" size="20" class="campo" value="<?php print("$not2[im_tel]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Celular:</td>
      <td width="80%" class=style2> <input type="text" name="im_cel" id="im_cel" size="20" class="campo" value="<?php print("$not2[im_cel]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Fax:</td>
      <td width="80%" class=style2> <input type="text" name="im_fax" id="im_fax" size="20" class="campo" value="<?php print("$not2[im_fax]"); ?>"></td>
    </tr>
  	<tr>
  	<td width="20%">
        <p align="left">Estado:</td>
        <td width="80%" class="style2"><select name="im_estado" id="im_estado" onChange="Dados(this.value);" class=campo>
	        <option value="0">Selecione o Estado</option>
<?
//require_once("conecta.php");
$sql = "SELECT e_cod, e_uf, e_nome FROM rebri_estados ORDER BY e_nome";
$sql = mysql_query($sql);
$row = mysql_num_rows($sql);

	while($not4 = mysql_fetch_array($sql))
	{
?>
		    <? //for($i=0; $i<$row; $i++) { ?>
<?php
	if($not4[e_cod] == $not2[im_estado]){
		$estado_atual = $not4[e_nome];
?>
		       <option selected value="<? echo $not4[e_cod]; ?>">
			   <? echo $not4[e_nome]; ?></option>
<?php
	}
	else
	{
?>
		       <option value="<? echo $not4[e_cod]; ?>">
			   <? echo $not4[e_nome]; ?></option>
<?php
	}
  }
?>
	     </select></td>
      </tr>
    <tr>
      <td width="20%">Cidade:</td>
      <td width="80%" class="style2"><select name="im_cidade" id="im_cidade" class="campo">
			<option id="opcoes" value="<? echo $not2[im_cidade]; ?>"s><? echo $not2[cidade_nome]; ?></option>
	     </select></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Endereço:</td>
      <td width="80%" class=style2> <input type="text" name="im_end" id="im_end" size="40" class="campo" value="<?php print("$not2[im_end]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Bairro:</td>
      <td width="80%" class=style2> <input type="text" name="im_bairro" id="im_bairro" size="40" class="campo" value="<?php print("$not2[im_bairro]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>CEP:</td>
      <td width="80%" class=style2> <input type="text" name="im_cep" id="im_cep" size="8" class="campo" maxlength="8" onKeyUp="return autoTab(this, 8, event);" value="<?php print("$not2[im_cep]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2>Site:</td>
      <td width="80%" class=style2> <input type="text" name="im_site" id="im_site" size="40" class="campo" value="<?php print("$not2[im_site]"); ?>"></td>
    </tr>
    <tr>
      <td width="20%" class=style2 valign="top">*Imagem:</td>
      <td width="80%" class=style2> <input type="text" name="im_img" id="im_img" size="20" class="campo" value="<?php print("$not2[im_img]"); ?>" readonly>
      	<input type="button" value="Selecionar" class="campo" onClick="window.open('p_img_logo.php', 'janela', 'height=500,width=600,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no');"><br>
      Obs.: Clique em "Selecionar" e escolha a imagem desejada.</td>
    </tr>
<?php
/*
	if (file_exists($caminhob.$img))
	{
*/
?>
    <tr>
      <td width="20%" class=style2 valign="top"></td>
      <td width="80%" class=style2> <img src="<? echo($caminho.$not2[im_img]); ?>"></td>
    </tr>
<?php
/*
	}
*/
?>
    <tr>
      <td width="20%" class=style2 valign="top">Descrição:</td>
      <td width="80%" class=style2> <textarea name="im_desc" id="im_desc" cols="30" rows="5" class="campo"><?php print("$not2[im_desc]"); ?></textarea></td>
    </tr>
    <tr>
      <td width="20%" class=style2 valign="top">Nome da pasta:</td>
      <td width="80%" class=style2><?php print("$not2[nome_pasta]"); ?></td>
    </tr>
	  <tr>
      <td colspan="5">
      <input class=campo type="button" value="Atualizar" name="B1" Onclick="VerificaCampo();">
	  <input class=campo type="submit" value="Apagar" name="B1">
	  <input class=campo type="submit" value="Computadores" name="inserir" onClick="formulario.action='cadastro_computadores.php?cod_imobiliaria=<?=$im_cod; ?>'">
	  <input class=campo type="submit" value="Usuários Imobiliária" name="inserir" onClick="formulario.action='p_usuariosi.php?cod_imobiliaria=<?=$im_cod; ?>'"></td>
    </tr>
    <tr>
      <td colspan="2">
      <p align="center"><a href="javascript:history.back()" class=style2><< Voltar <<</a></p></td>
    </tr>
  </table>
  </td>
  <td width="30%" valign="top"><table border="0" cellspacing="1" width="100%" bgcolor="#<?php print("$cor3"); ?>">
  		<tr bgcolor="#<?php print("$cor3"); ?>">
  			<td align="center"><b>Informações</b></td>
  		</tr>
  		<tr bgcolor="#<?php print("$cor1"); ?>">
  			<td class=style2><b>Cliques: <?php print("$not2[im_clicks]"); ?></b><br>
  				<span class=style9>Número de vezes que foi clicado no link para o site da imobiliária.</span></td>
  		</tr>
  	</table>
  </td>
</tr>
</table>

  </form>
<?php
	}
	}
	}
mysql_close($con);
?>
<?php
	}
?>
<?php
include("carimbo.php");
//mysql_close($con);
?>
</td></tr></table>
</body>
</html>