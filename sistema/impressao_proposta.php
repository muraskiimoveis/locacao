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
<script language="javascript">
function confirmaExclusao(id,cod,codi)
{
       if(confirm("Tem certeza que deseja ativar esta proposta?"))
          document.location.href='impressao_proposta.php?id_excluir=' + id + '&cod=' + cod + '&codi=' + codi;
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
</head>

<body onUnload="window.opener.location.reload()">
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


if($_GET['id_excluir'])
{ 
        $id_excluir = $_GET['id_excluir'];
        
   		$exclusao = "UPDATE propostas SET aceitacao='0' WHERE id_proposta='".$id_excluir."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   		if(mysql_query($exclusao))
   		{
   		    echo('<script language="javascript">alert("Proposta ativada com sucesso!");document.location.href="impressao_proposta.php?cod='.$cod.'&codi='.$codi.'";</script>');
   		}
   		else
   		{
      		echo('<script language="javascript">alert("Erro ao ativar!");document.location.href="impressao_proposta.php?cod='.$cod.'&codi='.$codi.'";</script>');
   		}
}	
	
?>
<form id="formulario" name="formulario" method="post" action="fazer_proposta.php">
  <table width="95%" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr height="50">
      <td colspan="2" class="style1"><div align="center"><b>Proposta </b><br />
      </div></td>
    </tr>
    <tr>
      <td class="style1"><b>Im&oacute;vel:</b> <?=$nimovel?></td>
    </tr> 	
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr class="fundoTabelaTitulo">
<? if($codi==$_SESSION['cod_imobiliaria']){ ?>
          <td width="30%" height="14" class="style1"><b>Cliente</b></td>
<? }else{ ?>
		 <td width="30%" height="14" class="style1"><b>Vendedor</b></td>	
<? } ?>
          <td width="13%" class="style1"><b>Data</b></td>
          <td width="30%" class="style1"><b>Texto</b></td>
          <td width="9%" class="style1"><b>Tipo</b></td>
<? if($codi==$_SESSION['cod_imobiliaria']){ ?>        
          <td width="24%" class="style1"><b>Vendedor</b></td>
<? } ?>
<? if($codi==$_SESSION['cod_imobiliaria']){  ?>  
          <div class=noprint><td width="12%" class="style1 noprint"><div align="center" class="noprint"><b>Ativa&ccedil;&atilde;o</b></div></td></div>
<? } ?>          
		<td width="11%" class="style1"><b>Status</b></td>
        </tr>
        <?
        
if($codi==$_SESSION['cod_imobiliaria']){ 
  			$i = 0;
            $busca2 = mysql_query("SELECT p.id_proposta, p.data_proposta, p.texto_proposta, p.status_proposta, p.aceitacao, c.c_nome, u.u_nome FROM propostas p INNER JOIN clientes c ON (p.cod_cliente=c.c_cod) INNER JOIN usuarios u ON (p.p_user=u.u_cod) WHERE p.cod_imovel='".$cod."' AND p.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY p.data_proposta DESC");
	 		while($linha2 = mysql_fetch_array($busca2)){
			if ($i++ % 2 == 0) { $fundo = 'fundoTabelaCor1'; } else { $fundo = 'fundoTabelaCor2'; }
			
			if($linha2['aceitacao']=='0'){
				   $status = "Ativada";
				   $link = '';
				}else{
				   $status = "Desativada";
				   $link = '<div class=noprint><td class="style1"><div align="center" class=noprint><a href="javascript:confirmaExclusao('.$linha2['id_proposta'].', '.$cod.','.$codi.')" class="style1 noprint">Ativar</a></div></td></div>';
				}
					echo "<tr class=\"$fundo\">";
      				echo('
            				<td class="style1">'.$linha2['c_nome'].'</td>
            				<td class="style1">'.formataDataDoBd($linha2['data_proposta']).'</td>
            				<td class="style1">'.$linha2['texto_proposta'].'</td>
            				<td class="style1">'.$linha2['status_proposta'].'</td>   
            				<td class="style1">'.$linha2['u_nome'].'</td>   
							<td class="style1" colspan="2">'.$status.'</td>
							'.$link.'        				
            			</tr>
	   				');
    			}
}else{
  			$i = 0;
  			$busca2 = mysql_query("SELECT p.id_proposta, p.data_proposta, p.texto_proposta, p.status_proposta, p.aceitacao, u.u_nome, i.im_nome FROM propostas p INNER JOIN usuarios u ON (p.p_user=u.u_cod) INNER JOIN rebri_imobiliarias i ON (p.cod_imobiliaria=i.im_cod) WHERE p.cod_imovel='".$cod."' AND p.cod_imobiliaria='".$codi."' ORDER BY p.data_proposta DESC");
			 while($linha2 = mysql_fetch_array($busca2)){
			 if ($i++ % 2 == 0) { $fundo = 'fundoTabelaCor1'; } else { $fundo = 'fundoTabelaCor2'; }
			 
			 if($linha2['aceitacao']=='0'){
				   $status = "Ativada";
				}else{
				   $status = "Desativada";
				}
					echo "<tr class=\"$fundo\">";
      				echo('
            				<td class="style1">'.$linha2['u_nome'].' - '.$linha2['im_nome'].'</td>
            				<td class="style1">'.formataDataDoBd($linha2['data_proposta']).'</td>
            				<td class="style1">'.$linha2['texto_proposta'].'</td>
            				<td class="style1">'.$linha2['status_proposta'].'</td>   
							<td class="style1">'.$status.'</td>
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
	    <br><br><input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()"> 
		<input id=idPrint type="button" name="fechar"  class="campo3 noprint" value="Fechar Janela" Onclick="window.close();">
<? if($codi==$_SESSION['cod_imobiliaria']){  ?>		
		<input id=idPrint type="button" name="voltar"  class="campo3 noprint" value="Voltar" Onclick="formulario.action='fazer_proposta.php?cod=<?=$cod; ?>&codi=<?=$codi; ?>';formulario.submit();">
<? } ?>		
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