<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");

$arquivo = 'relacao_emails.txt';

//$busca_email = mysql_query("SELECT c_cod, c_nome, c_email FROM clientes WHERE c_email REGEXP '^[a-zA-Z0-9]{1}([\._a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+){1,3}$' order by c_nome") or die (mysql_error());
//
if(isset($_GET['filtro']) and ($_GET['filtro'] >= 0 and $_GET['filtro'] <= 3)){

	header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
	header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
	header ( "Pragma: no-cache" );
	header ( "Content-type: text/plain; name=$arquivo");
	header ( "Content-Disposition: attachment; filename=$arquivo"); 
	header ( "Content-Description: MID Gera TXT" );


	if($_GET['filtro'] == '0'){
		$busca_email = mysql_query("SELECT c_email, c_nome, c_cod FROM clientes WHERE c_email REGEXP '^[a-zA-Z0-9]{1}([\._a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+){1,3}$' and c_desde > '2000-01-01'  and (c_tipo ='proprietario' or c_tipo ='locatario' or c_tipo2 like '%4%' or c_tipo2 like '%3%') ");
	}elseif($_GET['filtro'] == '1'){
		$busca_email = mysql_query("SELECT c_email, c_nome, c_cod FROM clientes WHERE c_email REGEXP '^[a-zA-Z0-9]{1}([\._a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+){1,3}$' and c_desde > '2015-07-01' and c_cod in (select distinct l_cliente from locacao where l_data_ent > '2015-08-01' order by l_cliente)");
	}elseif($_GET['filtro'] == '2'){
		$busca_email = mysql_query("SELECT c_email, c_nome, c_cod FROM clientes WHERE c_email REGEXP '^[a-zA-Z0-9]{1}([\._a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+){1,3}$' and (c_desde > '2014-01-01' and c_desde < '2014-12-31') and c_cod in (select distinct l_cliente from locacao where (l_data_ent > '2014-08-01' and l_data_ent < '2015-04-01'))");
	}elseif($_GET['filtro'] == '3'){
		$busca_email = mysql_query("SELECT c_email, c_nome, c_cod FROM clientes WHERE c_email REGEXP '^[a-zA-Z0-9]{1}([\._a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+){1,3}$' and (c_desde > '2014-01-01' and c_desde < '2014-12-31') and c_cod not in (select distinct l_cliente from locacao where l_data_ent > '2015-08-01')");
	}

	$conteudo = '';
	while($linha=mysql_fetch_array($busca_email)){
		$conteudo .= $linha['c_email'];
		$conteudo .= "\n";
	}
	
	echo $conteudo;

}else{ 

	echo "<script>alert('Coloque o Filtro e que seja Valido!!');</script>";
}

?>
