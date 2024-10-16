<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
unset($_SESSION["user_email"]);
unset($_SESSION["user_tipo"]);
unset($_SESSION["user_usuario"]);
unset($_SESSION["user_nome"]);
unset($_SESSION["user_cod"]);
unset($_SESSION["cod_condominio"]);
unset($_SESSION["s_u"]);
unset($_SESSION["u_variavel"]);
unset($_SESSION["sistema"]);
unset($_SESSION["dominio"]);
unset($_SESSION["painel"]);
unset($_SESSION["valid_user"]);
$exp = mktime('23','59','59',date('m'),date('d'),date('Y'));
setcookie("rebri", $user_cookie, $exp);
//session_destroy();
Header("Location: index.php");

?>
