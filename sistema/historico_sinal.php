<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("style.php");
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("GERAL_VEND");
?>
<html>
<head>
<script type="text/javascript" src="funcoes/js.js"></script>
	<style media="print">
		.noprint { display: none }
	</style>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and 
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/

if($_GET['cod']){
 $cod = $_GET['cod'];
}else{
 $cod = $_POST['cod'];
}

if($_GET['codi']){
 $codi = $_GET['codi'];
}else{
 $codi = $_POST['codi'];
}
 
if($codi==$_SESSION['cod_imobiliaria']){ 
 
	$busca = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
    while($linha = mysql_fetch_array($busca)){
       $nimovel = $linha['ref']." - ".strip_tags($linha['titulo']);
	} 

}else{
   
    $busca = mysql_query("SELECT ref, titulo FROM muraski WHERE cod='".$cod."' AND cod_imobiliaria='".$codi."'");
    while($linha = mysql_fetch_array($busca)){
       $nimovel = $linha['ref']." - ".strip_tags($linha['titulo']);
	}
  
}
?>
<form id="formulario" name="formulario" method="post" action="fazer_sinal.php">
<input type="hidden" name="cod" id="cod" value="<?=$cod ?>">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td class="style1"><div align="center"><b>Sinal</b></div></td>
    </tr>
    <tr>
      <td class="style1"><b>Im&oacute;vel:</b> <?=$nimovel?></td>
    </tr> 
    <tr>
      <td><table width="100%" border="0" cellpadding="1" cellspacing="1">
		<tr class="fundoTabelaTitulo">
<? if($codi==$_SESSION['cod_imobiliaria']){ ?>
          <td width="20%" class="style1"><b>Comprador</b></td>
<? }else{ ?>
		  <td width="20%" class="style1"><b>Vendedor</b></td>
<? } ?>
          <td width="27%" class="style1"><b>Texto</b></td>
          <td width="14%" class="style1"><b>Data Sinal</b></td>
          <td width="12%" class="style1"><b>Valor Venda</b></td>
<? if($codi==$_SESSION['cod_imobiliaria']){ ?>          
          <td width="16%" class="style1"><b>Vendedor</b></td>
<? } ?>
          <td width="11%" class="style1"><b>Status</b></td>
<? if($codi<>$_SESSION['cod_imobiliaria']){ ?>   
		  <td width="11%" class="style1"><b>Proposta</b></td>
<? } ?>
          </tr>
        <?
if($codi==$_SESSION['cod_imobiliaria']){ 
  
  			$j = 0;
            $busca2 = mysql_query("SELECT s.id_sinal, s.data_sinal, s.texto_sinal, s.valor_venda, s.status_sinal, s.cod_cliente, c.c_nome, u.u_nome FROM sinal_venda s INNER JOIN clientes c ON (s.cod_cliente=c.c_cod) INNER JOIN usuarios u ON (s.vendedor=u.u_cod) WHERE s.cod_imovel='".$cod."' AND s.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY s.data_sinal DESC");
	 		while($linha2 = mysql_fetch_array($busca2)){
	 			  if (($j % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
				  $j++;
      			
      				echo('
	        			<tr class="'.$fundo.'">
            				<td class="style1">'.$linha2['c_nome'].'</td>
            				<td class="style1">'.$linha2['texto_sinal'].'</td>
							<td class="style1">'.formataDataDoBd($linha2['data_sinal']).'</td>
            				<td class="style1">'.number_format($linha2['valor_venda'], 2, ',', '.').'</td>
        				    <td class="style1">'.$linha2['u_nome'].'</td>
            				<td class="style1">'.$linha2['status_sinal'].'</td>
            			</tr>
	   				');
    			}
}else{
  			$k = 0;
  			$busca2 = mysql_query("SELECT s.id_sinal, s.data_sinal, s.texto_sinal, s.valor_venda, s.status_sinal, s.cod_cliente, s.cod_imovel, u.u_nome, i.im_nome, i.im_cod, i.im_cidade, i.im_estado FROM sinal_venda s INNER JOIN usuarios u ON (s.vendedor=u.u_cod) INNER JOIN rebri_imobiliarias i ON (s.cod_imobiliaria=i.im_cod) WHERE s.cod_imovel='".$cod."' AND s.cod_imobiliaria='".$codi."' ORDER BY s.data_sinal DESC");
			while($linha2 = mysql_fetch_array($busca2)){
	 			  if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
				  $k++;
				  
      				echo('
	        			<tr class="'.$fundo.'">
            				<td class="style1">'.$linha2['u_nome'].' - '.$linha2['im_nome'].'</td>
            				<td class="style1">'.$linha2['texto_sinal'].'</td>
							<td class="style1">'.formataDataDoBd($linha2['data_sinal']).'</td>
            				<td class="style1">'.number_format($linha2['valor_venda'], 2, ',', '.').'</td>
            				<td class="style1">'.$linha2['status_sinal'].'</td>
							<td class="style1"><a href="impressao_sinal.php?cod='.$linha2['cod_imovel'].'&imp=7&compr='.$linha2['cod_cliente'].'&codim='.$linha2['im_cod'].'&ufim='.$linha2['im_estado'].'&cidadeim='.$linha2['im_cidade'].'" class="style1">Visualizar</a></td>
            			</tr>
	   				');
    			}
  
}
       ?>
      </table></td>
    </tr>
<div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style1">
	    <br><br><input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="self.print()"> 
		<input id=idPrint type="button" name="fechar"  class="campo3 noprint" value="Fechar Janela" Onclick="window.close();">
<? 
		if($codi==$_SESSION['cod_imobiliaria']){  
		  if($_GET['m']<>'1'){
?>	
        			
		<input id=idPrint type="button" name="voltar"  class="campo3 noprint" value="Voltar" Onclick="formulario.action='fazer_sinal.php?cod=<?=$cod; ?>&codi=<?=$codi; ?>';formulario.submit();">
<?
		  }
 		} 
?>		
	  </span></div></td>
    </tr>
</div>
	</table>
<?
mysql_close($con);
/*
	}else{
		include("login2.php");
	}
*/	
?>
</form>
</body>
</html>