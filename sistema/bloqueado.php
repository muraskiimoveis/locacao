<?
include("conect.php");
include("l_funcoes.php");
$er = isset($_GET['er']) ? $_GET['er'] : '';
$acesso_web = isset($_POST['acesso_web']) ? $_POST['acesso_web'] : '';
$MSG = isset($_GET['MSG']) ? $_GET['MSG'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : '';

if (empty($er) && empty($acesso_web)) verificaAcesso();
	if ($er == "aces") {
		echo "<script>alert('Você não possui permissões para acessar esta pagina.');</script>";
		$er = "";
		redirect("index.php");
	}
?>