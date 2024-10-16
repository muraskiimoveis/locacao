<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<html>

<head>
<?php
include("style.php");
?>
</head>
<?php
include("conect.php");

	$con = mysql_connect("$hostname", "$username", "$password") or die("Não consegui comunicar com o Banco de Dados");
	$con;
	mysql_select_db("$db");
?>
<body topmargin=0 leftmargin=0 rightmargin=0>
<p align=center><img src="images/logo3d_peq.gif"><br><br>
<font size="4" face="Arial" color="#000000"><b>Acesso à Intranet</b></font></p>
<?php
	$senha = addslashes($senha);

	$query0 = "select * from usuarios where u_senha='$senha'";
	$result0 = mysql_query($query0) or die("Não foi possível pesquisar suas informações.");
	$numrows = mysql_num_rows($result0);
	if($numrows > 0){
	
	while($not0 = mysql_fetch_array($result0))
	{
	$query1 = "insert into login (email, data_hora, senha) 
	values('$not0[u_email]', current_timestamp, '$senha')";
	$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.");
	
	$valid_user = $not0[u_email];
	$u_tipo = $not0[u_tipo];
	$u_nome = $not0[u_nome];
	session_register("valid_user");
	session_register("u_tipo");
	session_register("u_nome");
		
	if($u_tipo == "admin"){
?>
<script language="JavaScript"> 
function confirmar()
{
var agree=confirm("Você quer exportar todos os dados para o Site? Isso pode levar alguns minutos.\nEspere a página terminar de carregar para não causar problemas no sistema.\nClique OK para confirmar ou Cancel para voltar.");
if (agree)
top.location.href("p_exporta.php");
else
history.go(0);
}
</script>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="700" bgcolor="#ffffff">
  <tr><td colspan=2 align=center>
  <font size="1" face="Arial" color="#000080">
  Usuário Logado: 
<?php
print("$u_nome - $valid_user");
?>  
  </td></tr>
  <tr><td valign=top colspan=2>
  <table border="0" cellspacing="1" width="700" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center" colspan=2>
        <b><font size="2" face="Arial" color="#000080">Vender ou Alugar</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#96B5C9" align="center" width=350>
        <b><a href="p_pesq_loc.php"><font size="2" face="Arial" color="#000000">Pesquisar Imóveis p/ Locação</font></a></b><br>
        <font size="2" face="Arial" color="#000000">Clique para pesquisar os imóveis cadastrados.</td>
      <td bgcolor="#96B5C9" align="center" width=350>
        <b><a href="p_pesq_ven.php"><font size="2" face="Arial" color="#000000">Pesquisar Imóveis p/ Venda</font></a></b><br>
        <font size="2" face="Arial" color="#000000">Clique para pesquisar os imóveis cadastrados.</td>
    </tr>
  </table>
  </td></tr>
  <tr><td valign=top>
<div valign="center">
  <center>
  <table border="0" cellspacing="1" width="350" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center">
        <b><font size="2" face="Arial" color="#000080">Administrar Clientes, Proprietários e Interessados</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_insert_int.php"><font size="2" face="Arial" color="#000080">Inserir Interessados</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para cadastrar um novo interessado.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_insert_clientes.php"><font size="2" face="Arial" color="#000080">Inserir Clientes</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para cadastrar um novo cliente.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_pesq_clientes.php"><font size="2" face="Arial" color="#000080">Pesquisar Clientes e/ou Interessados</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para pesquisar os clientes e/ou interessados.</td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_rel_contratos.php"><font size="2" face="Arial" color="#000080">Relatórios de Contratos</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para pesquisar os contratos que estão para terminar.</td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_rel_aniversarios.php"><font size="2" face="Arial" color="#000080">Relatórios de Aniversariantes</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para pesquisar os aniversariantes.</td>
    </tr>
  </table>
  </center>
</div>
	</td><td valign=top>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="350" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center">
        <b><font size="2" face="Arial" color="#000080">Administrar Imóveis</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_insert_imoveis.php"><font size="2" face="Arial" color="#000080">Inserir Imóveis</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para cadastrar um novo imóvel.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_pesq_imoveis.php"><font size="2" face="Arial" color="#000080">Pesquisar Imóveis</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para pesquisar os imóveis cadastrados.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_imoveis.php"><font size="2" face="Arial" color="#000080">Relação de Imóveis</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para visualizar a relação de imóveis cadastrados.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_pesq_rel.php"><font size="2" face="Arial" color="#000080">Relatórios de Locações</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para visualizar os relatórios de locações.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_rel_entradas.php"><font size="2" face="Arial" color="#000080">Relatórios de Entradas</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para visualizar os relatórios de entradas de locações.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_rel_saidas.php"><font size="2" face="Arial" color="#000080">Relatórios de Saídas</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para visualizar os relatórios de saídas de locações.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_ref.php"><font size="2" face="Arial" color="#000080">Relação de Referências</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para visualizar todas as referências cadastradas.</td>
    </tr>
  </table>
  </center>
</div>	
	</td></tr>
  <tr><td valign=top>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="350" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center">
        <b><font size="2" face="Arial" color="#000080">Administrar Usuários da Intranet</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_usuarios.php"><font size="2" face="Arial" color="#000080">Visualizar usuários</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para visualizar todos os usuários.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_insert_usuario.php"><font size="2" face="Arial" color="#000080">Inserir Usuários</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para cadastrar um novo usuário.</td>
    </tr>
  </table>
  </center>
</div>
	</td><td valign=top>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="350" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center">
        <b><font size="2" face="Arial" color="#000080">Administrar Documentos</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_doc.php"><font size="2" face="Arial" color="#000080">Visualizar documentos</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para visualizar e editar os documentos do Sistema.</td>
    </tr></table>  </center>
</div></td></tr>
    <tr><td valign=top>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="350" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center">
        <b><font size="2" face="Arial" color="#000080">Administrar Imagens</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_envia_img.php"><font size="2" face="Arial" color="#000080">Enviar Imagens</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para enviar as imagens dos imóveis.</td>
    </tr>
  </table>
  </center>
</div>
    </td><td valign=top>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="350" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center">
        <b><font size="2" face="Arial" color="#000080">Exportar Dados</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="javascript:confirmar();"><font size="2" face="Arial" color="#000080">Exportar p/ Internet</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para gerar o arquivo de dados para o Site.</td>
    </tr>
  </table>
  </center>
</div>
    </td></tr>
  </table>
  </center>
</div>
	</td></tr>
	</table></center></div>
<?php
	}
	elseif($not0[u_tipo] == "func"){
?>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="700" bgcolor="#ffffff">
  <tr><td valign=top colspan=2>
  <table border="0" cellspacing="1" width="700" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center" colspan=2>
        <b><font size="2" face="Arial" color="#000080">Vender ou Alugar</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#96B5C9" align="center" width=350>
        <b><a href="p_pesq_loc.php"><font size="2" face="Arial" color="#000000">Pesquisar Imóveis p/ Locação</font></a></b><br>
        <font size="2" face="Arial" color="#000000">Clique para pesquisar os imóveis cadastrados.</td>
      <td bgcolor="#96B5C9" align="center" width=350>
        <b><a href="p_pesq_ven.php"><font size="2" face="Arial" color="#000000">Pesquisar Imóveis p/ Venda</font></a></b><br>
        <font size="2" face="Arial" color="#000000">Clique para pesquisar os imóveis cadastrados.</td>
    </tr>
  </table>
  </td></tr>
  <tr><td valign=top>
<div valign="center">
  <center>
  <table border="0" cellspacing="1" width="350" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center">
        <b><font size="2" face="Arial" color="#000080">Administrar Clientes, Proprietários e Interessados</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_insert_int.php"><font size="2" face="Arial" color="#000080">Inserir Interessados</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para cadastrar um novo interessado.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_insert_clientes.php"><font size="2" face="Arial" color="#000080">Inserir Clientes</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para cadastrar um novo cliente.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_pesq_clientes.php"><font size="2" face="Arial" color="#000080">Pesquisar Clientes e/ou Interessados</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para pesquisar os clientes e/ou interessados.</td>
    </tr>
  </table>
  </center>
</div>
	</td><td valign=top>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="350" bgcolor="#000080">
        <tr>
      <td bgcolor="#DCE0E4" align="center">
        <b><font size="2" face="Arial" color="#000080">Administrar Imóveis</font></b></td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_insert_imoveis.php"><font size="2" face="Arial" color="#000080">Inserir Imóveis</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para cadastrar um novo imóvel.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_pesq_imoveis.php"><font size="2" face="Arial" color="#000080">Pesquisar Imóveis</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para pesquisar os imóveis cadastrados.</td>
    </tr>
        <tr>
      <td bgcolor="#ffffff" align="center">
        <b><a href="p_imoveis.php"><font size="2" face="Arial" color="#000080">Relação de Imóveis</font></a></b><br>
        <font size="2" face="Arial" color="#ff0000">Clique para visualizar a relação de imóveis cadastrados.</td>
    </tr>
  </table>
  </center>
</div>	
	</td></tr>
	</table></center></div>
<?php
	}
	elseif($not0[u_tipo] == "cliente"){
?>
Sistema ainda está em desenvolvimento
<?php
	}
	else
	{
?>
<p align="center">
<font size="1" face="Arial" color="#000000">Cadastro inválido!</p>
<?php
	}
?>
<p align="center">
<font size="1" face="Arial" color="#000000">Desenvolvido por:</font><br>
<a href="http://bruc.com.br"><img src="images/carimbo_bruc.gif" border=0></a></p>
<?php
	}
	}
	else
	{
?>
<script>
function valida()
{
  if (form1.senha.value == "")
  {
    alert("Por favor, digite a Senha");
    form1.senha.focus();
    return (false);
  }
	return(true);
}
<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode; 
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}
//  End -->
</script>
<p><br><br>
  <div align="center">
    <center>
  <table border="0" cellspacing="1" width="400" bgcolor="#DCE0E4">
  <tr><td colspan=2 bgcolor="#ffffff" align=center>
    <font size="2" face="Arial" color="#0000ff">Digite seu e-mail e sua senha para acessar a<br>Intranet da Muraski Imóveis.</font>
    </td></tr>
  <form method="post" action="login_painel.php" name="form1" onsubmit="return valida();">
    <tr>
      <td width="100" bgcolor="#EDEEEE"><b><font size="2" face="Arial">Senha:</font></b></td>
      <td width="300" bgcolor="#EDEEEE"><font face="Arial" size="1">
        <input type="password" name="senha" size="6" class="campo" maxlenght="6" onKeyUp="return autoTab(this, 6, event);">(6 dígitos)</font></td>
    </tr>
    <tr>
      <td width="100" bgcolor="#FFFFFF">
      <p align="center">
    <input type="submit" value="Entrar" name="bot"></td>
          <td width="300" bgcolor="#FFFFFF">
    </td>
    </tr>
  </table>
  </form>
  </center>
</div>
<p align="center">
    &nbsp;
<?php
	}
?>
</table>
</td></tr></table>
<?php
mysql_close($con);
?>
</body>
</html>