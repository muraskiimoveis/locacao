  <table border="0" cellspacing="0" width="145" bgcolor="#<?php print("$cor1"); ?>">
    <tr>
      <td bgcolor="#<?php print("$cor1"); ?>" align="center">
        <b><a href="index.php"><img src="../images/logo_painel.gif" border="0"></a></td>
    </tr>
<? 

$hora = date("H"); 

if ($hora >= 0 && $hora < 6) { 

$saudacao = "Boa noite";

} elseif  ($hora >= 6 && $hora <12){ 

$saudacao = "Bom dia"; 

} elseif ($hora >=12 && $hora <18) { 

$saudacao = "Boa tarde"; 

}else { 

$saudacao = "Boa noite"; 

} 

	if((session_is_registered("usu_email")) and (session_is_registered("usu_tipo")) and (session_is_registered("usu_cod")) and 
	(($usu_tipo == "admin") or ($usu_tipo == "func"))){
?>
		<tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2 align=center>
		<br><br><?php print("$saudacao"); ?><br>
		<b><?php print("$usu_nome"); ?></b>!<br>
		<!--a href=login.php?logoff=sair&url=<?php print("$REQUEST_URI"); ?> target=_top class=style7><i>Logout</i></a><br><br></td-->
		<a href="logout.php" class=style7><i>Logout</i></a><br><br></td>
		</tr>
<?php
	}
?>
<?php
	$url = explode("?", $REQUEST_URI);
	if(($url[0] == "/painel/p_fotos.sphp") or ($url[0] == "/painel/p_envia_img.sphp")){
		$usu_tipo = "admin";
	}
?>
<?php
	if($usu_tipo == "admin"){
?>
    	<tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Imobiliárias</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
        - <a href="p_insert_imobiliaria.php" class=linkm>Cadastrar imobiliárias</a><br>
        - <a href="p_imobiliarias.php" class=linkm>Relação de Imobiliárias</a><br>
        <? if($usu_cod=='1' || $usu_cod=='2' || $usu_cod=='9' || $usu_cod=='10'){ ?>
		- <a href="cadastro_area.php" class=linkm>Cadastro Áreas</a><br>
		<? } ?>
     	</tr>
		<tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Tipos</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
				- <a href="p_insert_tipo.php" class=linkm>Cadastrar Tipo</a><br>
				- <a href="p_tipos.php" class=linkm>Relação de Tipos</a><br>
     	</tr>
		<tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Tipos de Comércio</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
				- <a href="p_insert_tipo_comercio.php" class=linkm>Cadastrar Tipo</a><br>
				- <a href="p_tipos_comercio.php" class=linkm>Relação de Tipos</a><br>
     	</tr>
		<tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Cidades e Bairros</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
				- <a href="p_insert_cidade.php" class=linkm>Cadastrar Cidade</a><br>
				- <a href="p_cidades.php" class=linkm>Relação de Cidades</a><br>
     	</tr>
		   	<tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Textos</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
        - <a href="p_insert_not.php" class=linkm>Cadastrar Texto</a><br>
				- <a href="p_not.php" class=linkm>Relação de Textos</a><br>
				- <a href="p_pesq_not.php" class=linkm>Pesquisar Textos</a><br>
     	</tr>
     	<tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Caracter&iacute;sticas</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
        - <a href="p_insert_caracteristica.php" class=linkm>Caracter&iacute;sticas</a><br>
     	- <a href="p_caracteristicas.php" class="linkm">Rela&ccedil;&atilde;o Caracter&iacute;sticas </a>
      </tr>
     	<tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Banners</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
        - <a href="p_insert_banner.php" class=linkm>Cadastrar Banner</a><br>
				- <a href="p_banners.php" class=linkm>Relação de Banners</a><br>
     	</tr>
     	<tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Limites</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
        - <a href="p_limite_dest.php" class=linkm>Destaques</a><br>
        - <a href="p_limite_foto.php" class=linkm>Fotos</a><br>
     	</tr>
      <tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Estatísticas</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
        - <a href="http://panelstats.redebrasileiradeimoveis.com.br/cgi-stats/awstats.pl?config=redeb9br" target="_blank" class=linkm>Site</a><br>
        </td>
    	</tr>
    	<tr>
        <td height="25" valign="bottom" bgcolor="#<?php print("$cor1"); ?>" class=style2>
      <b>Sistema</b></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor6"); ?>" height=1></td>
      </tr>
      <tr>
        <td bgcolor="#<?php print("$cor1"); ?>" class=style2>
        - <a href="p_insert_usuario.php" class=linkm>Cadastrar Usuários</a><br>
        - <a href="p_usuarios.php" class=linkm>Relação de Usuários</a></td>
      </tr>
<?php
	}
?>
  </table>