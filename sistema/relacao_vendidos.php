<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("IMOV_GERAL");

?>
<html>
<head>
</head>
<script language="javascript">
function confirmaAtivar(cod)
{
       if(confirm("Tem certeza que deseja ativar esse imóvel para venda?"))
          document.location.href='relacao_vendidos.php?cod=' + cod;
}


function VerificaCampo()
{

var msg = '';
      
  	   if(document.form1.ref.value.length==0)
  	   {
    		 msg += "Por favor, preencha o campo Referência.\n";
  	   }
  	   else
  	   {
    		var er = new RegExp("^[0-9a-z]+$");
    		if(er.test(document.form1.ref.value) == false)
			{
  	    		msg += "Não pode haver espaço nem caractere especial no campo Referência.\n";	    
    		}
  	   }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
            document.form1.buscar.value='1';
			document.form1.submit();
	   }

}
</script>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>

<form id="form1" name="form1" method="post" action="">
<?

if($_GET['cod'])
{
 
    $cod = $_GET['cod'];
  
	$query4 = "update muraski set finalidade='2', status='1' where cod='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
	$result4 = mysql_query($query4) or die("Não foi possível atualizar suas informações. $query4");	
	$query40 = "update vendas set v_status='I' where v_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
	$result40 = mysql_query($query40) or die("Não foi possível atualizar suas informações. $query40");	
	$query50 = "update sinal_venda set s_status='I' where cod_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
	$result50 = mysql_query($query50) or die("Não foi possível atualizar suas informações. $query50");	
	$query60 = "update propostas set p_status='I' where cod_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";        	
	$result60 = mysql_query($query60) or die("Não foi possível atualizar suas informações. $query60");	
	echo('<script language="javascript">alert("Imóvel ativado com sucesso!");document.location.href="relacao_vendidos.php";</script>');		
}

?>
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td colspan="2" class="style1"><div align="center"><b>Imóveis Vendidos </b><br />Preencha o período e demais campos que você deseja visualizar o relatório e clique em pesquisar</div></td>
    </tr>
    <tr>
      <td colspan="2" class="style1"><b>Refer&ecirc;ncia:</b>
         <input type="text" name="ref" id="ref" size="10" maxlength="10" class="campo" value="<?=$ref; ?>"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="hidden" name="buscar" id="buscar" value="0">
        <input type="button" value="Pesquisar" name="pesquisar" id="pesquisar" class="campo3" onClick="VerificaCampo();">
      </div></td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
				<tr>
					<td width="18%" class="TdSubTitulo"><b>Im&oacute;vel</b></td>
          			<td width="8%" class="TdSubTitulo"><b>Ativação</b></td>
        		</tr>
<?

   if($_POST['ref']<>''){
				
		$busca = mysql_query("SELECT cod, ref, titulo FROM muraski WHERE ref='".$_POST['ref']."' AND finalidade='6' AND  cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
		while($linha = mysql_fetch_array($busca)){	           				
					echo ("
						<tr>
          					<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          					<td class=\"style1\"><input type=\"button\" value=\"Ativar para Venda\" class=\"campo3\" name=\"B1\" onClick=\"javascript:confirmaAtivar(".$linha[cod].")\"></td>
						</tr>	

					");	
		}
	
	}else{
	  
	  	if(!$from){
			$from = intval($screen * 30);
		}
	  
	  	$busca = mysql_query("SELECT cod, ref, titulo FROM muraski WHERE finalidade='6' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY ref LIMIT $from,30");
		$i = 1;
		while($linha = mysql_fetch_array($busca)){
        	$from = $from + 1; 				           				
					echo ("
						<tr>
          					<td class=\"style1\">".$linha['ref']." - ".strip_tags($linha['titulo'])."</td>
          					<td class=\"style1\"><input type=\"button\" value=\"Ativar para Venda\" class=\"campo3\" name=\"B1\" onClick=\"javascript:confirmaAtivar(".$linha[cod].")\"></td>
						</tr>	

					");	
		$i++;
		}
	
		$query2 = "SELECT COUNT(cod) AS contador FROM muraski WHERE finalidade='6' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$result2 = mysql_query($query2);
		while($not2 = mysql_fetch_array($result2))
		{
?>
<?php
			$pages = ceil($not2[contador] / 30);
?>
  		<tr>
  			<td bgcolor="#<?php print("$cor1"); ?>" class="style1" align="center">Foram encontrados <?php print("$not2[contador]"); ?> atendimentos</td>
  		</tr>
  		<tr>
    		<td bgcolor="#<?php print("$cor1"); ?>" class="style1" align="center">
<?php
			if ($from > 30) {
?>
                  <a href="javascript:history.back()" class="style1"><< Página anterior <<</a>
<?php
			}
			else
			{
?>
                  <a href="javascript:history.back()" class="style1">
                  << Página anterior <<</a>
<?php
			}

		for ($i = 0; $i < $pages; $i++) {	  
  			$url2 = "relacao_vendidos.php?screen=" . $i;
  			if(((($screen - 9) < $i) and (($screen + 9) > $i)) or ($i == 0) or ($i == ($pages -1))){
  				if($i == $screen){
  					echo "   | <a href=\"$url2\" class=style7><b>$i</b></a> |   ";
				}elseif($i == 0){
  					echo "   | <a href=\"$url2\" class=style1><b>Primeira</b></a> |   ";
				}elseif($i == ($pages - 1)){
  					echo "   | <a href=\"$url2\" class=style1><b>Última</b></a> |   ";
				}else{
  					echo "   | <a href=\"$url2\" class=style1>$i</a> |   ";	
  				}
  			}
		}

		if ($from >= $not2[contador]) {
?>
		  Última página da pesquisa
<?php
		}
		else
		{
			$url3 = "relacao_vendidos.php?screen=" . ($screen + 1);
?>
                  <a href="<?php print("$url3"); ?>" class="style1">>> Próxima Página >></a>
<?php
		}
?>
                  </td></tr>
<?php
		}
	}
?>
		</table></td>
    </tr>
<?
mysql_close($con);
?>
</form>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="900" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("voltar.php"); ?>
    </td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td align="center">
    <? include("endereco.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td align="center" class="style1">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
</body>
</html>
