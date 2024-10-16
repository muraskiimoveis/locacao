<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<table width="900" border="0" cellspacing="0" cellpadding="0">
<? if($_SESSION['valid_user']){ ?>  
  <tr>
    <td width="7" background="images/fundo_esq_logo_topo.jpg">&nbsp;</td>
<?
   $logo_imob = $_SESSION['logo_imob'];
   $caminho_logo = "../logos/";
?>   	
    <td width="255" align="center" bgcolor="#FFFFFF"><a href="index.php" class="style1">
<?
		## se tem foto, mostra!
		if (file_exists($caminho_logo.$logo_imob))
		{
?>
          <img src="<?php print($caminho_logo.$logo_imob); ?>" border="0" title="Página Principal" />
<?
		}
?>	
	</a></td>
	
    <td width="7" background="images/fundo_dir_logo_topo.jpg">&nbsp;</td>
    <td align="right">
<? } ?>
<?
	if($_SESSION['valid_user']){
?>
	<span class="stylec"><b>Usu&aacute;rio Logado: </b><? print($_SESSION['u_nome']." - ".$_SESSION['valid_user']); ?> | </span><a href="logout.php" class="stylec">Sair</a>
<?
}
?>
<?php
if($_SESSION['valid_user']){
?>
	<table border="0" cellpadding="0" cellspacing="4">	
<?
	$query1 = "select * from atendimento, usuarios where a_corretor=u_cod and a_vendas='1' and atendimento.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by a_data_venda";
	$result1 = mysql_query($query1);
	if(mysql_num_rows($result1) > 0){
?>
        
      <tr>
        <td align="right"><table border="0" cellpadding="2" cellspacing="1" bgcolor="#DCE0E4">
          <tr>
            <td colspan="2" align="center" bgcolor="#ffffff" class="style1">Vendas</td>
            </tr>
  <?php
	while($not = mysql_fetch_array($result1))
	{
?>
          <tr>
            <td align="left" bgcolor="#ffffff" class="style1"><?php print("$not[u_nome]"); ?></td>
            <td align="center" bgcolor="#ffffff"><a href="p_insert_int.php?lista=1&a_corretor=<?php print("$not[a_corretor]"); ?>&B2=Atendeu" class="style1"><img src="images/icone_lapis.jpg" width="16" height="14" border="0" /></a></td>
          </tr>
  <?php
	}
  }
}
?>		
        </table></td>
        <td align="right"><table border="0" cellpadding="2" cellspacing="1" bgcolor="#DCE0E4">
<?php
if($_SESSION['valid_user']){
	$query1 = "select * from atendimento, usuarios where a_corretor=u_cod and a_locacao='1' and atendimento.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by a_data_locacao";
	$result1 = mysql_query($query1);
	if(mysql_num_rows($result1) > 0){
?>		
        
          <tr>
            <td colspan="2" align="center" bgcolor="#ffffff" class="style1">Loca&ccedil;&otilde;es</td>
            </tr>
  <?php
	while($not = mysql_fetch_array($result1))
	{
?>			
          <tr>
            <td align="left" bgcolor="#ffffff" class="style1"><?php print("$not[u_nome]"); ?></td>
            <td align="center" bgcolor="#ffffff"><a href="p_insert_int.php?lista=1&a_corretor=<?php print("$not[a_corretor]"); ?>&B2=Atendeu" class="style1"><img src="images/icone_lapis.jpg" width="16" height="14" border="0" /></a></td>
          </tr>
  <?php
	}
  }
}
?>        
        </table></td>
        <td align="right"><table border="0" cellpadding="2" cellspacing="1" bgcolor="#DCE0E4">
<?php
if($_SESSION['valid_user']){
if($_GET['acao']=='1'){	
	$query = "update atendimento set a_data_telefone=current_timestamp where a_corretor='$a_corretor' and atendimento.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
}

	$query10 = "select * from atendimento, usuarios where a_corretor=u_cod and a_telefone='1' and atendimento.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by a_data_telefone ASC";
	$result10 = mysql_query($query10);
	if(mysql_num_rows($result10) > 0){
?>		
        
          <tr>
            <td colspan="2" align="center" bgcolor="#ffffff" class="style1">Telefones</td>
            </tr>
  <?php
	while($not = mysql_fetch_array($result10))
	{
?>			
          <tr>
            <td align="left" bgcolor="#ffffff" class="style1"><?php print("$not[u_nome]"); ?></td>
            <td align="center" bgcolor="#ffffff">
<?
            if(verificaFuncao("USER_RELOGIO_FONE")){
?>
              <a href="index.php?a_corretor=<?php print("$not[a_corretor]"); ?>&acao=1" class="style1">
                <img src="images/icone_lapis.jpg" width="16" height="14" border="0" />
              </a>
            </td>
<?}else{
?>
              <a class="style1">
                <img src="images/icone_lapis.jpg" width="16" height="14" border="0" />
              </a>
            </td>
<? } ?>
          </tr>
<?php
	}
  }
}
?>        
        </table></td>
        <td align="right"><table border="0" cellpadding="2" cellspacing="1" bgcolor="#DCE0E4">
<?php
if($_SESSION['valid_user']){
if($_GET['acao2']=='1'){
	$query = "update atendimento set a_data_email=current_timestamp where a_corretor='$a_corretor' and atendimento.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result = mysql_query($query) or die("Não foi possível atualizar suas informações.");
}

	$query10 = "select * from atendimento, usuarios where a_corretor=u_cod and a_email='1' and atendimento.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by a_data_email ASC";
	$result10 = mysql_query($query10);
	if(mysql_num_rows($result10) > 0){
?>

          <tr>
            <td colspan="2" align="center" bgcolor="#ffffff" class="style1">E-Mail</td>
            </tr>
  <?php
	while($not = mysql_fetch_array($result10))
	{
?>
          <tr>
            <td align="left" bgcolor="#ffffff" class="style1"><?php print("$not[u_nome]"); ?></td>
            <td align="center" bgcolor="#ffffff">

<?
            if(verificaFuncao("USER_RELOGIO_EMAIL")){
?>
              <a href="index.php?a_corretor=<?php print("$not[a_corretor]"); ?>&acao2=1" class="style1">
                <img src="images/icone_lapis.jpg" width="16" height="14" border="0" />
              </a>
            </td>
<?}else{
?>
              <a class="style1">
                <img src="images/icone_lapis.jpg" width="16" height="14" border="0" />
              </a>
            </td>
<? } ?>
          </tr>
  <?php
	}
  }
}
?>
        </table></td>
      </tr>
    </table></td>
	
  </tr>
</table>
