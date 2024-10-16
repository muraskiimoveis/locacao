<?
include("conect.php");
if ($op == "RESET PASSWORDS") {
	$query0 = "select * from usuarios";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	if($numrows > 0){
		while($not0 = mysql_fetch_array($result0)) {
			$u_cod = $not0['u_cod'];
			$u_senha = $not0['u_senha'];
			if (strlen($u_senha) < 10) {
				$query1 = "update usuarios set u_senha='".md5($u_senha)."' where u_cod='".$u_cod."'";
				mysql_query($query1) or die("Não foi possível pesquisar suas informações.");
				//echo $query1."<BR>";
			}
		}
	}
	echo "Passwords Reset Complete!";
}
if ($op == "CREATE USER ROOT") {
	$query0 = "INSERT INTO usuarios(u_nome,u_senha,u_tipo) VALUES('Root','".md5("root")."','admin')";
	mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$tmp_cod = mysql_insert_id();
	
	$query0 = "select * from area";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	while($not0 = mysql_fetch_array($result0)) {
		$area_id = $not0['area_id'];
		$query1 = "INSERT INTO rel_area_usuario(area_id,u_cod) VALUES('".$area_id."','".$tmp_cod."')";
		mysql_query($query1) or die("Não foi possível pesquisar suas informações.");
	}
	echo "User: Root"."<BR>"."Pass: root"."<BR>";
}
if ($op == "CREATE COMP ROOT") {

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
	
	$computador_codigo = geraCodigoComputador();
	$computador_cookie = geraCookie();
	$query0 = "INSERT INTO computador (computador_nome, computador_codigo, computador_cookie, computador_ativo) 
								VALUES 
									('Root', 
									'".$computador_codigo."', 
									'".$computador_cookie."', 
									'1')";
	mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	echo "Root Computer Info:"."<BR>"."Name: Root"."<BR>"."Activation Code: ".$computador_codigo."<BR>";
}
?>
<form method="post" action="#">
	<input type="submit" name="op" value="RESET PASSWORDS" />
	<input type="submit" name="op" value="CREATE COMP ROOT" />
	<input type="submit" name="op" value="CREATE USER ROOT" />
</form>