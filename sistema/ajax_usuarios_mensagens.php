<?php
/*
 * Aqruivo responsável por recuperar os usuários de acordo com a imobiliária enviada
 *  
 */

// Inicia sessão
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

// Arquivos inclusos
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");

// Verifica acesso e área
verificaAcesso();
verificaArea("MENSAGENS_GERAL");

// Recupera o parâmetro passado pela url e retira os caracteres indesejados
$numero = $_POST['numero'];
$numero = preg_replace('([^0-9])','',$numero);

// Variável para armazenar o xml montado pela consulta
$retornoXml = "";

// Realiza a busca pelos usuários da imobiliária enviada
$consulta = mysql_query("select u_cod, u_nome, u_email from usuarios where cod_imobiliaria = '$numero'  ORDER BY u_nome ASC");
while($linha = mysql_fetch_assoc($consulta))
{
	$retornoXml .= "\t<imobiliaria>\r\n\t\t<codigo>$linha[u_cod]</codigo>\r\n\t\t<usuario>$linha[u_nome] ($linha[u_email])</usuario>\r\n\t</imobiliaria>\r\n";
}

// Realiza a montagem do xml
$xml = "<?xml version='1.0' encoding='ISO-8859-1'?>\r\n";
$xml .= "<imobiliarias>\r\n";
$xml .= $retornoXml;
$xml .= "</imobiliarias>";

// Header da página xml
Header("Content-type: application/xml; charset=iso-8859-1"); 

// Imprime o xml na tela
echo $xml;
?>