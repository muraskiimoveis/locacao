<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();

function verificaCookie($cookie) { // verifica o computador
   $SQL = "SELECT * FROM computador WHERE computador_cookie='".$cookie."' AND computador_ativo IS NOT NULL AND computador_confirmado IS NOT NULL";
   $statement = mysql_query($SQL); if ($debug) echo erro();
   if (mysql_num_rows($statement) > 0) {
      $row = mysql_fetch_assoc($statement);
      $_SESSION['computador_nome'] = $row['computador_nome'];
      return true;
   } else {
      return false;
   }
}


function verificaLogin() { // verifica o login
	if($_COOKIE['rebri'] != ""){      

		$query0 = "select * from usuarios u
		inner join rebri_imobiliarias i on (u.cod_imobiliaria=i.im_cod)
		INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)
		INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod)
		where u.u_cookie='".$_COOKIE['rebri']."' and u.u_status='Ativo' and i.im_desativar='0'";
		$result0 = mysql_query($query0);
		$numrows0 = mysql_num_rows($result0);
		$not0 = mysql_fetch_array($result0);
		if ($numrows0 > 0) {
			$valid_user = $not0['u_email'];
         	$u_tipo = $not0['u_tipo'];
         	$u_nome = $not0['u_nome'];
         	$u_cod = $not0['u_cod'];
         	$nome_pasta = $not0['nome_pasta'];
         	$nome_imobiliaria = $not0['im_nome'];
         	$cnpj_imobiliaria = $not0['im_cnpj'];
         	$logo_imob = $not0['im_img'];
        	$im_endereco = $not0['im_end'];
         	$im_fone = $not0['im_tel'];
         	$cidadei = $not0['ci_nome'];
         	$estadoi = $not0['e_uf'];
         	$cod_cidadei = $not0['ci_cod'];
         	$cod_estadoi = $not0['e_cod'];
         	$email_imo = $not0['im_email'];
         	$banco_imo = $not0['im_banco'];
         	$agencia_imo = $not0['im_agencia'];
         	$conta_imo = $not0['im_conta'];
         	$im_site_padrao = $not0['im_site_padrao'];
         	$u_variavel = base64_encode("rebri".date('d-m-Y'));
			$_SESSION['cod_imobiliaria'] = $not0['cod_imobiliaria'];
         	$_SESSION["im_endereco"] = $im_endereco;
         	$_SESSION["im_fone"] = $im_fone;
         	$_SESSION["cidadei"] = $cidadei;
         	$_SESSION["estadoi"] = $estadoi;
         	$_SESSION["cod_estadoi"] = $cod_estadoi;
         	$_SESSION["cod_cidadei"] = $cod_cidadei;
         	$_SESSION["email_imo"] = $email_imo;
         	$_SESSION["banco_imo"] = $banco_imo;
         	$_SESSION["agencia_imo"] = $agencia_imo;
         	$_SESSION["conta_imo"] = $conta_imo;
         	$_SESSION["valid_user"] = $valid_user;
         	$_SESSION["u_tipo"] = $u_tipo;
         	$_SESSION["u_nome"] = $u_nome;
         	$_SESSION["u_cod"] = $u_cod;
         	$_SESSION["nome_pasta"] = $nome_pasta;
         	$_SESSION["nome_imobiliaria"] = $nome_imobiliaria;
         	$_SESSION["cnpj_imobiliaria"] = $cnpj_imobiliaria;
         	$_SESSION["logo_imob"] = $logo_imob;
         	$_SESSION["cod_imobiliaria"] = $_SESSION['cod_imobiliaria'];
         	$_SESSION["u_variavel"] = $u_variavel;
         	$_SESSION['rebricbr'] = '1';
         	$_SESSION['sistema'] = "sistema";
         	$_SESSION['im_site_padrao'] = $im_site_padrao;
         	$_SESSION['dominio'] = $_SERVER['SERVER_NAME'];
			return true;
		} else {
			return false;
		}
	
	}
}
/* antigo
function verificaLogin() { // verifica o login

   if ($_SESSION['rebricbr'] == "1" && $_SESSION['sistema'] == "sistema" && $_SESSION['dominio'] == $_SERVER['SERVER_NAME'] &&
      $_SESSION['valid_user'] <> "" && (isset($_SESSION['u_tipo']))) {

      $query0 = "select * from usuarios where u_senha='".$_SESSION['s_u']."' AND u_email='".$_SESSION['valid_user']."'";
      $result0 = mysql_query($query0);
      $numrows = mysql_num_rows($result0);

      if ($numrows > 0) {
         return true;
      } else {
         return false;
      }

   } else {

         return false;

   }

}
*/

/*
function verificaAcesso() { // função de verificação principal =============
	if (!verificaCookie($_COOKIE['computador_cookie'])) {
		header("LOCATION: index.php?er=comp");
	} elseif (!verificaLogin()) {
		header("LOCATION: index.php?er=user");
	}
}
*/

function verificaAcesso() { // função de verificação principal =============

   /*if (!verificaCookie($_COOKIE['computador_cookie'])) {
      header("LOCATION: index.php?er=comp");
   */

   if (!verificaLogin()) {
      header("LOCATION: index.php?er=user");
   }

}

function logaComputador($computador_codigo) { // função que valida computador e LOGA

   $SQL = "SELECT * FROM computador WHERE computador_codigo='".$computador_codigo."' AND computador_confirmado IS NULL AND computador_ativo IS NOT NULL";
   $statement = mysql_query($SQL); if ($debug) echo erro();
   if (mysql_num_rows($statement)) {
      $row = mysql_fetch_assoc($statement);
      setcookie("computador_cookie", $row['computador_cookie'], 0);
      $SQL = "UPDATE computador SET computador_confirmado='1' WHERE computador_codigo='".$computador_codigo."'";
      mysql_query($SQL);
      return true;
   } else {
      return false;
   }

}

function logaWeb($senha_web) { // função que valida senha web e<strong></strong> LOGA

	$query0 = "select * from senha_web where s_senha='".$senha_web."'";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	if($numrows > 0){
		while($not0 = mysql_fetch_array($result0)) {
			return true;
		}
	}
	return false;

}

function logaUser($email,$senha) { // função que valida senha normal para login e LOGA

	$query0 = "select * from usuarios u
	inner join rebri_imobiliarias i on (u.cod_imobiliaria=i.im_cod)
	INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)
	INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod)
	where u.u_email='".$email."' AND u.u_senha='".md5($senha)."' and u.u_status='Ativo' and i.im_desativar='0'";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	if($numrows > 0){
      while($not0 = mysql_fetch_array($result0)) {
         $valid_user = $not0['u_email'];
         $u_tipo = $not0['u_tipo'];
         $u_nome = $not0['u_nome'];
         $u_cod = $not0['u_cod'];
         $nome_pasta = $not0['nome_pasta'];
         $nome_imobiliaria = $not0['im_nome'];
         $cnpj_imobiliaria = $not0['im_cnpj'];
         $logo_imob = $not0['im_img'];
         $im_endereco = $not0['im_end'];
         $im_fone = $not0['im_tel'];
         $cidadei = $not0['ci_nome'];
         $estadoi = $not0['e_uf'];
         $cod_cidadei = $not0['ci_cod'];
         $cod_estadoi = $not0['e_cod'];
         $email_imo = $not0['im_email'];
         $banco_imo = $not0['im_banco'];
         $agencia_imo = $not0['im_agencia'];
         $conta_imo = $not0['im_conta'];
         $user_cookie = $not0['u_cookie'];
       	 $u_variavel = base64_encode("rebri".date('d-m-Y')); 
		 $exp = mktime('23','59','59',date('m'),date('d'),date('Y'));
         setcookie("rebri", $user_cookie, $exp);
         $_SESSION['cod_imobiliaria'] = $not0['cod_imobiliaria'];
         $s_u = md5($senha);
         $_SESSION["im_endereco"] = $im_endereco;
         $_SESSION["im_fone"] = $im_fone;
         $_SESSION["cidadei"] = $cidadei;
         $_SESSION["estadoi"] = $estadoi;
         $_SESSION["cod_estadoi"] = $cod_estadoi;
         $_SESSION["cod_cidadei"] = $cod_cidadei;
         $_SESSION["email_imo"] = $email_imo;
         $_SESSION["banco_imo"] = $banco_imo;
         $_SESSION["agencia_imo"] = $agencia_imo;
         $_SESSION["conta_imo"] = $conta_imo;
         $_SESSION["valid_user"] = $valid_user;
         $_SESSION["u_tipo"] = $u_tipo;
         $_SESSION["u_nome"] = $u_nome;
         $_SESSION["u_cod"] = $u_cod;
         $_SESSION["nome_pasta"] = $nome_pasta;
         $_SESSION["nome_imobiliaria"] = $nome_imobiliaria;
         $_SESSION["cnpj_imobiliaria"] = $cnpj_imobiliaria;
         $_SESSION["logo_imob"] = $logo_imob;
         $_SESSION["cod_imobiliaria"] = $_SESSION['cod_imobiliaria'];
         $_SESSION["s_u"] = $s_u;
         $_SESSION['rebricbr'] = '1';
         $_SESSION['sistema'] = "sistema";
         $_SESSION['dominio'] = $_SERVER['SERVER_NAME'];
         $querya = "UPDATE interessados SET i_libera='n' WHERE i_data_status <= '".date("Y-m-d")."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		 $resulta = mysql_query($querya) or die("Não foi possível atualizar suas informações. $querya");
         return true;
      }
   }
   return false;

}

function verificaArea($area) { // função que valida permissão de usuario para area acessada

   $query0 = "select area_id from area where area_parametro='".$area."'";
   $result0 = mysql_query($query0);
   $row0 = mysql_fetch_array($result0);
   $area_id = $row0['area_id'];

   $query1 = "select * from rel_area_usuario where area_id='".$area_id."' AND u_cod='".$_SESSION['u_cod']."'";
   $result1 = mysql_query($query1);
   $numrows = mysql_num_rows($result1);
   if ($numrows == 0) {

      header("LOCATION: index.php?er=aces");

   }

}

function verificaFuncao($area) { //função que valida permissão para funcao de alguma area

   $query0 = "select area_id from area where area_parametro='".$area."'";
   $result0 = mysql_query($query0);
   $row0 = mysql_fetch_array($result0);
   $area_id = $row0['area_id'];

   $query1 = "select * from rel_area_usuario where area_id='".$area_id."' AND u_cod='".$_SESSION['u_cod']."'";
   $result1 = mysql_query($query1);
   $numrows = mysql_num_rows($result1);
   //echo $query0;

   if ($numrows == 0) {

      return false;

   } else {

      return true;

   }

}
?>