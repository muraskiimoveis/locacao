<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
//
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//
session_start();
include("conect.php");
include("l_funcoes.php");
include("p_fotos.php");
verificaAcesso();
verificaArea("ENV_IMAGEM");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<html>

<head>
<META Http-Equiv="Cache-Control" Content="no-cache">
<META Http-Equiv="Pragma" Content="no-cache">
<META Http-Equiv="Expires" Content="0">

<?php
include("style.php");
?>
<script language="javascript">
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
  	    		msg += "Não pode haver espaço nem caractere especial no campo Referência.\n" ;
    		}
  	   }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
			document.form1.bfotos.value='1';
			document.form1.submit();
	   }

}

function VerificaCampo2()
{

var msg = '';

	   if(document.form2.chave.value.length==0)
	   {
		       msg += "Por favor, preencha o campo Referência.\n";
       }
       if(document.form2.finalidade2.selectedIndex == 0)
	   {
	          msg += "Por favor, selecione o campo Finalidade.\n";
	   }
       if(msg != '')
	   {
	        alert(msg);
	   }
	   else
	   {
			document.form2.submit();
	   }

}

function formOrdem(chave, finalidade2, pesq, ordem, screem){

	if(confirm("Deseja realmente renomear as fotos?")){

   	   document.form3.action='p_envia_img.php?chave=' + chave + '&finalidade2=' + finalidade2 + '&pesq=' + pesq + '&ordem=' + ordem + '&screen=' + screem;
	   document.form3.acao.value='1';
   	   document.form3.submit();
	}
}


function Validacao(chave, finalidade2, pesq, ordem, screem){

	todos = document.getElementsByTagName('input');
    for(x = 0; x < todos.length; x++)
    {
        if (todos[x].checked)
        {
			document.form3.action='p_envia_img.php?chave=' + chave + '&finalidade2=' + finalidade2 + '&pesq=' + pesq + '&ordem=' + ordem + '&screen=' + screem;
			document.form3.acao_apagar.value='1';
			document.form3.submit();
			return true;
        }
    }
    alert("Selecione pelo menos uma (1) Foto!");
    return false;

}

function ValidaEnvioSite(chave, finalidade2, pesq, ordem, screem){

	todos = document.getElementsByTagName('input');
    for(x = 0; x < todos.length; x++)
    {
        if (todos[x].checked)
        {
			document.form3.action='p_envia_img.php?chave=' + chave + '&finalidade2=' + finalidade2 + '&pesq=' + pesq + '&ordem=' + ordem + '&screen=' + screem;
			document.form3.acao_site.value='1';
			document.form3.submit();
			return true;
        }
    }
    alert("Selecione pelo menos uma (1) Foto!");
    return false;

}




</script>
</head>
<body>
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
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
<?
		/* how many upload slots? */
		define("UPLOAD_SLOTS", 10);

?>
<form action="p_envia_img.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
<table width="75%" border="0" cellpadding="1" cellspacing="1" align="center">
	<tr>
	  <td colspan="2" height="50"><p align="center" class="style1"><b>Enviar Imagens</b></p></td>
	</tr>
	<tr class="fundoTabela">
	  <td colspan="2" height="30" align="center" class="style1">
<?php

if($B1 == "Apagar Imagem") {
	if ($foto != ""){
	  	$data = date("Y-m-d");
   		$hora = date("H:i:s");
   		$refe = $_GET['chave'];
              $codigo = $_GET['cod_imovel'];
			  
		$t_nome = explode("_", $foto);
		$refe = $t_nome[0];

		if ($_SERVER[REMOTE_ADDR] == "201.86.21.248") {
			echo "Referencia: $refe <br />";
			echo "Foto: $foto <br /><br />";
		}


			//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
   			$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$refe."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 90 - ".mysql_error());
   			$cont = mysql_num_rows($busca_reg);
   			if($cont > 10) {
      			mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 93 - ".mysql_error());
   			}


		$tmp_cod = $_SESSION['cod_imobiliaria'];
		$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod."'");
		$row = mysql_fetch_array($result);
		$tmp_pasta = $row['nome_pasta'];
		$pasta = "../imobiliarias/".$tmp_pasta."/".$tmp_fold."/";
		$pastap = "../imobiliarias/".$tmp_pasta."/".$tmp_fold."_peq/";

		$foto_peq = str_replace(".jpg","_peq.jpg","$foto");
		if (file_exists($pasta . $foto)) {
			unlink($pasta . $foto);
		}
		if (file_exists($pastap . $foto_peq)) {
			unlink($pastap . $foto_peq);
		}
		
		// Retira foto do Site
		$nseq = str_replace(".","",str_replace("_","",(substr($foto,strpos($foto,"_"),3))));
		//echo "Mostra ==>".$refe." == ".$nseq." == ".$cod_imovel."<BR>";;
		//if(ApagaFotoNoSite($refe,$nseq,$cod_imovel)){
			//echo "APAGOU";
		//}
		ApagaFotoNoSite($refe,$nseq,$cod_imovel);
	
		//Insere o usuário que esta fazendo a inserção da imagem
             $nref = explode("_",$foto);

             $sqlinsere = "INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref,";
             $sqlinsere .= "a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$nref[0]."',";
             $sqlinsere .= "'".$nref[0]."','".$B1."','".$data."','".$hora."')";
   		$insere = mysql_query($sqlinsere) or die ("Erro 370 - ".mysql_error());

		?>
		<p align="center" class=style7>
		<b>Você apagou a foto: <i><?php print("$foto"); ?></i>.</b></p>
		<?php
	} else {
		?>
		<p align="center" class=style7>
		<b>A foto <i><?php print("$foto"); ?></i> não existe.</b></p>
		<?php
	}
}


if($_POST['acao_apagar']=='1')
{

		$y = $_POST['contador'];
		$c = 0;

		for($p = 0; $p <= $y; $p++)
		{

     		$fotos = "foto_".$p;
     		$foto = $_POST[$fotos];
     		$tmpfolds = "tmp_fold_".$p;
     		$tmp_fold = $_POST[$tmpfolds];
     		$botoes = "apagar_foto_".$p;
     		$botao = $_POST[$botoes];

	    	if($botao=='1')
	    	{
    			$c++;
				$tmp_cod = $_SESSION['cod_imobiliaria'];
				$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod."'");
				$row = mysql_fetch_array($result);
				$tmp_pasta = $row['nome_pasta'];
				$pasta = "../imobiliarias/".$tmp_pasta."/".$tmp_fold."/";
				$pastap = "../imobiliarias/".$tmp_pasta."/".$tmp_fold."_peq/";
				##29/09/2009
				$tref = explode("_",$foto);
				$refer = $tref[0];
				
				$busca_codigo = "select cod from muraski where ref='".$refer."'  and cod_imobiliaria='3'";
				$rs_codigo = mysql_query($busca_codigo) or die ("Erro 225 - " . mysql_error());
				if (mysql_num_rows($rs_codigo) > 0) {
					while ($rs_found = mysql_fetch_assoc($rs_codigo)) {
						$cod_imovel0 = $rs_found['cod'];
					}
				}
								
				$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$cod_imovel0."','".$refer."','Apagar Imagem','".date("Y-m-d")."','".date("H:i:s")."')") or die ("Erro 370 - ".mysql_error());

				$foto_peq = str_replace(".jpg","_peq.jpg","$foto");
				if (file_exists($pasta . $foto)) {
					unlink($pasta . $foto);
				}
				if (file_exists($pastap . $foto_peq)) {
					unlink($pastap . $foto_peq);
				}
				
				// Retira foto do Site
				$nseq = str_replace(".","",str_replace("_","",(substr($foto,strpos($foto,"_"),3))));
				
				if(VerificaFotoDaPasta($refer,$nseq)){
					$busca_imovel = "select cod from muraski where ref='".$refer."'  and cod_imobiliaria='3'";
					$rsimovel = mysql_query($busca_imovel) or die ("Erro 225 - " . mysql_error());
					if (mysql_num_rows($rsimovel) > 0) {
						while ($nv = mysql_fetch_assoc($rsimovel)) {
							$cod_imovel = $nv['cod'];
						}
					}
					ApagaFotoNoSite($refer,$nseq,$cod_imovel);
				}

?>
				<p align="center" class=style7>
				<b>Você apagou a foto: <i><?php print("$foto"); ?></i>.</b></p>
<?
			}
		}
}


if($B1 == "Atualiza Imagem") {

	if ($foto != ""){
	
	  	$data = date("Y-m-d");
   		$hora = date("H:i:s");
   		$refe = $_GET['chave'];
		$codigo = $_GET['cod_imovel'];
		$tipo_envio = $_GET['tipo_envio'];
		
		$t_nome = explode("_", $foto);
		$refe = $t_nome[0];
		
		$nseq = str_replace(".","",str_replace("_","",(substr($foto,strpos($foto,"_"),3))));
		
		//$mostra = "Codigo Imovel ...".$codigo." Nome da Foto.... ".$refe."   Sequencia...  ".$nseq;

		if($tipo_envio == "Enviar"){
			$tipo_atualiza = "Insere Imagem";
			$sql_enviar = "UPDATE fotos SET site='S' where  cod = ".$codigo. "  and  ref = '".$refe."' and sequencia = '".$nseq."'";
			$rs_enviar = mysql_query($sql_enviar) or die ("Erro 370 - ".mysql_error());
		}elseif($tipo_envio == "Retirar"){
			$tipo_atualiza = "Apagar Imagem";
			$sql_enviar = "UPDATE fotos SET site='N' where  cod = ".$codigo. " and  ref = '".$refe."' and sequencia = '".$nseq."'";
			$rs_enviar = mysql_query($sql_enviar) or die ("Erro 370 - ".mysql_error());
		}
		
		//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
   		$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$refe."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 90 - ".mysql_error());
   		$cont = mysql_num_rows($busca_reg);
   		if($cont > 10) {
			mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 93 - ".mysql_error());
   		}
	
		//Insere o usuário que esta fazendo a inserção da imagem
		$nref = explode("_",$foto);
		
		$sqlinsere = "INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ";
		$sqlinsere .=  " ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$codigo."', '".$refe."','".$tipo_atualiza."','".$data."','".$hora."')";
   		$insere = mysql_query($sqlinsere) or die ("Erro 370 - ".mysql_error());

		?>
		<p align="center" class=style7>
		<b>Você  <?php print("$tipo_envio");?> a foto: <i><?php print("$foto"); ?></i> do Site.</b></p>
		<?php
	} else {
		?>
		<p align="center" class=style7>
		<b>A foto <i><?php print("$foto"); ?></i> não existe.</b></p>
		<?php
	}
}


if($_POST['acao_site']=='1')
{

		$y = $_POST['contador'];
		$c = 0;

		for($p = 0; $p <= $y; $p++)
		{

			$cod_refer ="cod_refer_".$p;
			$cod_imovel = $_POST[$cod_refer];
			$fotos = "nome_foto_".$p;
			$foto = $_POST[$fotos];
			$sequencias = "seq_foto_".$p;
			$sequencia = $_POST[$sequencias];
			$tpenvios = "tipo_envio_".$p;
			$tipoenvio =  $_POST[$tpenvios];
			//
			$botoes = "enviarsite_foto_".$p;
			$botao = $_POST[$botoes];

			if($botao=='1')
			{
				$c++;

				if($tipoenvio == "Enviar"){
					$tipo_atualiza = "Insere Imagem";
					$sql_enviar = "UPDATE fotos SET site='S' where  cod = ".$cod_imovel. "  and  ref = '".$foto."' and sequencia = '".$sequencia."'";
					$rs_enviar = mysql_query($sql_enviar) or die ("Erro 370 - ".mysql_error());
				}elseif($tipoenvio == "Retirar"){
				      $tipo_atualiza = "Apagar Imagem";
					$sql_enviar = "UPDATE fotos SET site='N' where  cod = ".$cod_imovel. " and  ref = '".$foto."' and sequencia = '".$sequencia."'";
					$rs_enviar = mysql_query($sql_enviar) or die ("Erro 370 - ".mysql_error());
				}

				##29/09/2009
				$tref = explode("_",$foto);
				$refer = $tref[0];
				$sqlinsere = "INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ";
				$sqlinsere .= " ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$cod_imovel."','".$refer."','".$tipo_atualiza."','".date("Y-m-d")."','".date("H:i:s")."')";
				$insere = mysql_query($sqlinsere) or die ("Erro 370 - ".mysql_error());
				
			}
		}
}

if($_POST['acao']=='1')
{

  		$i = $_POST['cont'];
 		$chave = $_GET['chave'];
		$finalidade2 = $_GET['finalidade2'];
		$pesq = $_GET['pesq'];
		$ordem = $_GET['ordem'];
		$screen = $_GET['screen'];
		
  		$c = 0;

		//Pega a referência do imóvel.
		$ref2 = explode("_",$foto_antiga_grande_0);
		$ref = $ref2[0];

		for($j = 0; $j <= $i; $j++)
		{

				$ordens = "ordem_".$j;
				$ordem = $_POST[$ordens];
				$ordensa = "ordem_antiga_".$j;
				$ordema = $_POST[$ordensa];
				$pequenas = "foto_antiga_pequena_".$j;
				$pequena = $_POST[$pequenas];
				$grandes = "foto_antiga_grande_".$j;
				$grande = $_POST[$grandes];
				$pgrandes = "pasta_grande_".$j;
				$pgrande = $_POST[$pgrandes];
				$ppequenas = "pasta_pequena_".$j;
				$ppequena = $_POST[$ppequenas];

				if($ordem)
				{
					$c++;
					$parte1 = explode(".", $grande);
					$parte2 = $parte1[0];
					$parte3 = explode("_", $parte2);
					$nova_foto_grande[$j] = $parte3[0]."_".$ordem.".".$parte1[1]."temp";
					$nova_foto_grande_atualizada[$j] = $parte3[0]."_".$ordem.".".$parte1[1];

					$parte10 = explode(".", $pequena);
					$parte20 = $parte10[0];
					$parte30 = explode("_", $parte20);
					$nova_foto_pequena[$j] = $parte30[0]."_".$ordem."_peq.".$parte10[1]."temp";
					$nova_foto_pequena_atualizada[$j] = $parte30[0]."_".$ordem."_peq.".$parte10[1];


					if($ordema<>$ordem){
						rename($ppequena."/".$pequena, $ppequena."/".$nova_foto_pequena[$j]);
						rename($pgrande."/".$grande, $pgrande."/".$nova_foto_grande[$j]);
					}elseif($ordema==$ordem){
						rename($ppequena."/".$pequena, $ppequena."/".$pequena."temp");
						rename($pgrande."/".$grande, $pgrande."/".$grande."temp");
					}

				}
		}


		$i2 = $_POST['cont'];
		$c2 = 0;

		for($j2 = 0; $j2 <= $i2; $j2++)
		{
			$pgrandes2 = "pasta_grande_".$j2;
			$pgrande2 = $_POST[$pgrandes2];
			$ppequenas2 = "pasta_pequena_".$j2;
			$ppequena2 = $_POST[$ppequenas2];

			$c2++;

			//$foto_pequena_nova = str_replace("temp", "", $nova_foto_pequena);
			//$foto_grande_nova = str_replace("temp", "", $nova_foto_grande);

			@rename($ppequena2."/".$nova_foto_pequena[$j2], $ppequena2."/".$nova_foto_pequena_atualizada[$j2]);
			@rename($pgrande2."/".$nova_foto_grande[$j2], $pgrande2."/".$nova_foto_grande_atualizada[$j2]);

			$busca_imovel = "select cod from muraski where ref='".$ref."'  and cod_imobiliaria='3'";
			$rsimovel = mysql_query($busca_imovel) or die ("Erro 225 - " . mysql_error());
			if (mysql_num_rows($rsimovel) > 0) {
				while ($nv = mysql_fetch_assoc($rsimovel)) {
					$cod_imovel = $nv['cod'];
				}
			}

			
			// Nao necessita de Atualizar ordem foto do Site
/*			
			$nseq = str_replace(".","",str_replace("_","",(substr($nova_foto_grande_atualizada[$j2],strpos($nova_foto_grande_atualizada[$j2],"_"),3))));
			$refer = substr($nova_foto_grande_atualizada[$j2],0,strpos($nova_foto_grande_atualizada[$j2],"_"));

			if(VerificaFotoDaPasta($refer,$nseq)){
				$busca_imovel = "select cod from muraski where ref='".$refer."'  and cod_imobiliaria='3'";
				$rsimovel = mysql_query($busca_imovel) or die ("Erro 225 - " . mysql_error());
				if (mysql_num_rows($rsimovel) > 0) {
					while ($nv = mysql_fetch_assoc($rsimovel)) {
						$cod_imovel = $nv['cod'];
					}
				}
				AtualizaFotoNoSite("Enviar",$refer,$nseq,$cod_imovel);
			}
*/
			
		}
		
		### Cadastro da alteração
		$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$cod_imovel."','".$ref."','Reordenar Imagem','".date("Y-m-d")."','".date("H:i:s")."')") or die ("Erro 370 - ".mysql_error());

		// Colocar aqui a atualização 
		
		echo('<script language="javascript">alert("Ordens atualizadas com sucesso!");document.location.href="p_envia_img.php?chave='.$chave.'&finalidade2='.$finalidade2.'&pesq='.$pesq.'&ordem='.$ordem.'&screen='.$screen.'";</script>');
}
?>
</td>
	</tr>
<?	if($REQUEST_METHOD!="POST") { ?>
	<!--tr>
	  <td colspan="2" class="style1" align="center"><span class="style7">Favor selecionar a finalidade antes de inserir a imagem se for &quot;Vendas&quot; selecionar a finalidade &quot;Venda&quot;, se for &quot;Loca&ccedil;&atilde;o Anual&quot; ou &quot;Loca&ccedil;&atilde;o Temporada selecionar a finalidade &quot;Loca&ccedil;&atilde;o&quot;.<br><br>Se quiser para imóveis de "Vendas para vistoria" escolha a finalidade "Vistoria Vendas", se for para imóveis de "Locação Temporada ou Anual para vistoria" escolha a finalidade "Vistoria Locação".</span></td>
    </tr-->
	<tr class="fundoTabela">
	  <td colspan="2" class="style1" align="center">Selecione a finalidade do imóvel:&nbsp;&nbsp;&nbsp;<select name="finalidade" class=campo>
		 <?
            /*$tmp_query = mysql_query("SELECT * FROM muraski WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
 			while($linha = mysql_fetch_array($tmp_query)){
				if($linha['cod']==$u_cod){
					echo('<option value="'.$linha['u_cod'].'" SELECTED>'.$linha['ref'].'</option>');
				}else{
					echo('<option value="'.$linha['cod'].'">'.$linha['ref'].'</option>');
				}
 			}*/
		?>
			
			<option value="Venda">Venda</option>
			<option value="Locacao">Locação</option>
			<option value="Venda_Vistoria">Vistoria Venda</option>
			<option value="Locacao_Vistoria">Vistoria Locação</option>
        </select></td>
	</tr>
	<tr class="fundoTabela">
	  <td colspan="2" class="style1" align="left">
		<b>Observações:</b><br>
		<?  if($_SERVER['SERVER_NAME'] == "www.redebrasileiradeimoveis.com.br" OR $_SERVER['SERVER_NAME'] == "redebrasileiradeimoveis.com.br" OR strstr($_SESSION['valid_user'], '@bruc.com.br')) { ?>
		- O tamanho maximo das fotos grandes é de 400x300 pixels. Imagens maiores serão redimensionadas.<br>
		<? }else{ ?>
		- O tamanho maximo das fotos grandes é de 1475x828 pixels. Imagens maiores serão redimensionadas.<br>
		<? } ?>
		- Para enviar as imagens informe a referência do imóvel para qual deseja inserir as imagens e em seguida selecione as imagens desejadas. (Ex: Referência 3030)<br>
		- A ordem das fotos exibidas é a mesma ordem que as fotos foram enviadas no momento da inserção.<br> 
		<span class="style7"><b>- Somente são ACEITAS imagens com as seguintes extensões: JPG ou JPEG.</b></span><br> 
		<span class="style7"><b>- Para evitar problemas no upload das fotos evite colocar espaços em branco, pontos ou caracteres especiais nos nomes dos arquivos.</b></span><br>
		<span class="style7"><b>- Tamanho m&aacute;ximo das fotos para upload &eacute; de 1MB maior que isso dar&aacute; problemas de redimensionamento nas fotos pequenas </b></span></td>
	</tr>
	<tr class="fundoTabela">
	  <td>&nbsp;</td>
    </tr>
	<tr class="fundoTabela">
	  <td colspan="2" class="style1" align="center">Refer&ecirc;ncia:      
      <input type="text" name="ref" id="ref" size="10" maxlength="10" class="campo" value="<?=$ref; ?>"></td>
    </tr>
    <tr class="fundoTabela">
	  <td>&nbsp;</td>
    </tr>
	<tr class="fundoTabela">
	  <td colspan="2" align="center">
		<?php 
			/* generate form */ 
			for($i=1; $i<=UPLOAD_SLOTS; $i++) { 
				echo "<input type=file class=campo name=infile$i><br>\n"; 
			} 
		?>	  </td>
	</tr>
	<tr>
	  <td align="left" colspan="2"><input type="hidden" id="bfotos" name="bfotos" value="0">
	  <input type="button" value="Enviar Arquivo" class="campo3" Onclick="VerificaCampo();"></td>
	</tr>
<? 		} else {
?>
	<tr class="fundoTabela">
	  <td>
<?
			function retira_acentos( $name ) { 
			  $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç" 
								 , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"," ","'","´","`","/","\\","~","^","¨" ); 
			  $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c" 
								 , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C","_","_","_","_","_","_","_","_","_" ); 
			  return str_replace( $array1, $array2, $name ); 
			}
			
			//Função alterada nos cálculos de altura e largura
			function criar_thumbnail($origem='',$destino='',$largura='',$pre='tn_',$formato='JPEG') { 
			
				switch($formato) 
				{ 
					case 'JPEG': 
						$tn_formato = 'jpg'; 
						break; 
					case 'PNG': 
						$tn_formato = 'png'; 
						break; 
				} 
				$ext = split("[/\\.]",strtolower($origem)); 
				$n = count($ext)-1; 
				$ext = $ext[$n]; 
			
				$arr = split("[/\\]",$origem); 
				$n = count($arr)-1; 
				$arra = explode('.',$arr[$n]); 
				$n2 = count($arra)-1; 
				$tn_name = str_replace('.'.$arra[$n2],'',$arr[$n]); 
				//$destino = $destino.$pre.$tn_name.'.'.$tn_formato;
				$destino = $destino;
			
				if ($ext == 'jpg' || $ext == 'jpeg'){ 
					$im = imagecreatefromjpeg($origem); 
				}elseif($ext == 'png'){ 
					$im = imagecreatefrompng($origem); 
				}elseif($ext == 'gif'){ 
					return false; 
				} 
				$w = imagesx($im); 
				$h = imagesy($im); 
				$nw = $largura;
				$nh = ($h * $largura)/$w;
				if(function_exists('imagecopyresampled')) 
				{ 
					if(function_exists('imageCreateTrueColor')) 
					{ 
						$ni = imageCreateTrueColor($nw,$nh); 
					}else{ 
						$ni    = imagecreate($nw,$nh); 
					} 
					if(!@imagecopyresampled($ni,$im,0,0,0,0,$nw,$nh,$w,$h)) 
					{ 
						imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h); 
					} 
				}else{ 
					$ni    = imagecreate($nw,$nh); 
					imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h); 
				} 
				if($tn_formato=='jpg'){ 
					imagejpeg($ni,$destino,90); 
				}elseif($tn_formato=='png'){ 
					imagepng($ni,$destino); 
				} 
			}
			
			$finalidade = $_POST['finalidade'];
			$ref = $_POST['ref'];
			
		if($ref<>''){
		  
			if($finalidade=='Venda' || $finalidade=='Venda_Vistoria'){
			  $finalidadev = " (finalidade='1' OR finalidade='2' OR finalidade='3' OR finalidade='4' OR finalidade='5' OR finalidade='6' OR finalidade='7')";
			}elseif($finalidade=='Locacao' || $finalidade=='Locacao_Vistoria')  {
			  $finalidadev = " (finalidade='8' OR finalidade='9' OR finalidade='10' OR finalidade='11' OR finalidade='12' OR finalidade='13' OR finalidade='14' OR finalidade='15' OR finalidade='16' OR finalidade='17')";
			}
		  
		  
		$SQL = "SELECT ref,cod FROM muraski WHERE ref='".$ref."' and $finalidadev AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
		$busca = mysql_query($SQL);
		$num_rows = mysql_num_rows($busca);
		$linhas_busca = mysql_fetch_array($busca);
    	if($num_rows == 0)
		{
			echo('<script language="javascript">alert("Essa referência não está cadastrada no sistema você só pode mandar fotos de referências que existem");document.location.href="p_envia_img.php";</script>');
		}
		else
		{
			
			$cod_imovel2 = $linhas_busca['cod'];
			$tmp_cod = $_SESSION['cod_imobiliaria'];
			$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod."'");
			$row = mysql_fetch_array($result);
			$pasta = $row['nome_pasta'];
			
			if ($finalidade == "Venda") {
				/* where to move the uploaded file(s) to? */ 
				define("INCOMING", "../imobiliarias/".$pasta."/venda/");
				define("INCOMING2", "../imobiliarias/".$pasta."/venda_peq/");
			} elseif ($finalidade == "Locacao") {
				define("INCOMING", "../imobiliarias/".$pasta."/locacao/");
				define("INCOMING2", "../imobiliarias/".$pasta."/locacao_peq/");
			} elseif ($finalidade == "Venda_Vistoria") {
				define("INCOMING", "../imobiliarias/".$pasta."/venda_vistoria/");
				define("INCOMING2", "../imobiliarias/".$pasta."/venda_vistoria_peq/");
			} elseif ($finalidade == "Locacao_Vistoria") {
			  	define("INCOMING", "../imobiliarias/".$pasta."/locacao_vistoria/");
				define("INCOMING2", "../imobiliarias/".$pasta."/locacao_vistoria_peq/");
			}
			
			//Tamanho máximo da imagem grande
			if($_SERVER['SERVER_NAME'] == "www.redebrasileiradeimoveis.com.br" OR $_SERVER['SERVER_NAME'] == "redebrasileiradeimoveis.com.br" OR strstr($_SESSION['valid_user'], '@bruc.com.br')) {
				$larg_max = 400;
				$alt_max = 300; 
			}else{
				//$larg_max = 900;
				//$alt_max = 674; 
				$larg_max = 1475;
				$alt_max = 828; 
				
				
			}
			
			//Tamanho máximo da imagem pequena
			$largp_max = 150;
			$altp_max = 112;
			
			/* handle uploads */ 
			$noinput = true; 
			for($i=1; $noinput && ($i<=UPLOAD_SLOTS); $i++) { 
				if(${"infile".$i}!="none") $noinput=false; 
			} 
			if($noinput) { 
				echo "error uploading. create 150MB coredump instead?"; 
				exit(); 
			} 
			
			$result2 = mysql_query("SELECT d_qtd FROM rebri_destaques WHERE d_tipo='Fotos'");
			$row2 = mysql_fetch_array($result2);
			$quantidade = $row2['d_qtd'];
		
			for($i=1; $i<= UPLOAD_SLOTS; $i++) { 
				if(${"infile".$i}) { 
		
					$file = strtolower(${"infile".$i."_name"});
					$tamanho_foto = ${"infile".$i."_size"};
					
					$foto = ${file};
					$fotos = explode(".",$foto);
					$f = count($fotos);					
					
					if($fotos[$f-1]=='jpeg' || $fotos[$f-1]=='JPEG'){
					 $extensao = "jpg"; 
					}else{
					 $extensao = $fotos[$f-1];
					}
					
					$tmp_cod2 = $_SESSION['cod_imobiliaria'];
					$result33 = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod2."'");
					$row33 = mysql_fetch_array($result33);
						$tmp_pasta33 = $row33['nome_pasta'];
						$pasta1 = "../imobiliarias/".$tmp_pasta33."/venda/";
						$pastap1 = "../imobiliarias/".$tmp_pasta33;
						$pasta20 = "../imobiliarias/".$tmp_pasta33."/locacao/";
						$pastap20 = "../imobiliarias/".$tmp_pasta33;
						$pasta30 = "../imobiliarias/".$tmp_pasta33."/locacao_vistoria/";
						$pastap30 = "../imobiliarias/".$tmp_pasta33;
						$pasta40 = "../imobiliarias/".$tmp_pasta33."/venda_vistoria/";
						$pastap40 = "../imobiliarias/".$tmp_pasta33;

					$strDiretorio1 = $pasta1; // pasta das imagens
					$strDiretorio20 = $pasta20; // pasta das imagens
					$strDiretorio30 = $pasta30; // pasta das imagens
					$strDiretorio40 = $pasta40; // pasta das imagens
					$strDiretorioAbrir1 = opendir($strDiretorio1);
					$strDiretorioAbrir20 = opendir($strDiretorio20);
					$strDiretorioAbrir30 = opendir($strDiretorio30);
					$strDiretorioAbrir40 = opendir($strDiretorio40);

					$i2 = 1;
					$m2 = 1;
					$arquivos1 = array();

					$referencia = trim($ref);
					$finalidade = trim($finalidade);
					$tm1 = strlen($referencia);

					if($finalidade=='Venda'){
						$pasta_foto_site=$pasta1;
						while(false !== ($strArquivos1 = readdir($strDiretorioAbrir1))) {
			 				if($strArquivos1 != "." && $strArquivos1 != "..") {	

							$fotosv = explode("_",$strArquivos1);
			 	  			$arq1[$i2] = $fotosv[0]."_";
			 	  			//$arq1[$i2] = substr($strArquivos1,0,$tm1);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos1);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "venda";
			 	 			$i2++;
			 				}
						}
					}elseif($finalidade=='Locacao'){
					$pasta_foto_site=$pasta20;
					while(false !== ($strArquivos1 = readdir($strDiretorioAbrir20))) {
			 			if($strArquivos1 != "." && $strArquivos1 != "..")
			 			{		
			 	  			$fotosl = explode("_",$strArquivos1);
			 	  			$arq1[$i2] = $fotosl[0]."_";
							//$arq1[$i2] = substr($strArquivos1,0,$tm1);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos1);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "locacao";
			 	 			$i2++;
			 			}
					}
					}elseif($finalidade=='Locacao_Vistoria'){
					$pasta_foto_site=$pasta30;
					while(false !== ($strArquivos1 = readdir($strDiretorioAbrir30))) {
			 			if($strArquivos1 != "." && $strArquivos1 != "..")
			 			{		
			 	  			$fotoslv = explode("_",$strArquivos1);
			 	  			$arq1[$i2] = $fotoslv[0]."_";
							//$arq1[$i2] = substr($strArquivos1,0,$tm1);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos1);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "locacao_vistoria";
			 	 			$i2++;
			 			}
					}
					}elseif($finalidade=='Venda_Vistoria'){
					$pasta_foto_site=$pasta40;
					while(false !== ($strArquivos1 = readdir($strDiretorioAbrir40))) {
			 			if($strArquivos1 != "." && $strArquivos1 != "..")
			 			{		
			 	  			$fotosvv = explode("_",$strArquivos1);
			 	  			$arq1[$i2] = $fotosvv[0]."_";
							//$arq1[$i2] = substr($strArquivos1,0,$tm1);
			 	  			$str1[$i2] = str_replace($referencia,'@',$strArquivos1);
			 	  			$arq20[$i2] = $strArquivos1;
				  			$arqF1[$i2] = "venda_vistoria";
			 	 			$i2++;
			 			}
					}
					}

// pega o contador.
					for($i2 = 1 ; $i2 <= count($arq20) ; $i2++)
					{
						if(!empty($arq20[$i2]))
						{
//							if((strpos($str1[$i2],'@') == true) OR ((strtolower($arq1[$i2]) == strtolower($referencia)."_") and (strlen($arq1[$i2]) == strlen($referencia."_"))))
							if((strtolower($arq1[$i2]) == strtolower($referencia)."_") and (strlen($arq1[$i2]) == strlen($referencia."_")))
							{
								$arquivos1[$i2] = $arq20[$i2];
							 	$fold_arquivos1[$i2] = $arqF1[$i2];
						 	 	$m2++;
							}
						}
					}

					$garantia = 0;
					$saida = 0;
					while ($garantia == 0) {
						if (file_exists(INCOMING.$referencia."_".$m2.".".$extensao)) {
						  	$garantia = 0;
							$m2++;						
						} else {
							$garantia = 1;
						}
						$saida++;
						if ($saida > $i2) {
							$garantia = 1;
						}
					}

					$monta_foto = $referencia."_".$m2.".".$extensao;
					
				
				preg_match("/\.(jpg|jpeg){1}$/i", $file, $ext);
				

				if($tamanho_foto > '1638400'){
				  	echo "<center><span class=\"style7\">A foto <b>". $file." </b>não pode ser enviada pois ultrapassou o tamanho de 1MB permitido</b>.</span></center><br><br>"; 
				}elseif($ext[1]==''){ 
					echo "<center><span class=\"style7\">A foto <b>". $file." </b>não pode ser enviada pois o formato não é do tipo JPG ou JPEG</b>.</span></center><br><br>"; 								
				}else{
					
					if($m2 <= $quantidade){
					copy(${"infile".$i}, INCOMING.$monta_foto);
					
					
					$nome_foto = $monta_foto;
					$rest = substr($nome_foto, -4);
					$nome_foto2 = str_replace(".jpg","_peq.jpg","$nome_foto");
					 
					//Pega tamanho da imagem
					$ImageSize = GetImageSize (INCOMING.$monta_foto);
					$Img_w = $ImageSize[0];
					$Img_h = $ImageSize[1];
					 
					//FOTO PEQUENA
					$dest = INCOMING2 . $nome_foto2;
						
					if($Img_w > $Img_h){
					  if($Img_w < $largp_max){
						$largura = $Img_w;
					  }else{
						if(($Img_w/$Img_h) > round($largp_max/$altp_max, 2)){
						  $largura = $largp_max;
						}else{
						  $novoh = $altp_max;
						  $largura = round(($Img_w * $novoh)/$Img_h);
						}
					  }
					}
					if($Img_w < $Img_h){
					  if($Img_h < $altp_max){
						$largura = $Img_w;
					  }else{
						$novoh = $altp_max;
						$largura = round(($Img_w * $novoh)/$Img_h);
					  }
					}
					if($Img_w == $Img_h){
					  if($Img_w < $altp_max){
						$largura = $Img_w;
					  }else{
						$largura = $altp_max;
					  }
					}
					
						criar_thumbnail(INCOMING.$monta_foto,$dest,$largura,'','JPEG');		
					
					//FOTO GRANDE
					if($Img_w > $Img_h){
					  if($Img_w < $larg_max){
						$largura = $Img_w;
					  }else{
						if(($Img_w/$Img_h) > round($larg_max/$alt_max, 2)){
						  $largura = $larg_max;
						}else{
						  $novoh1 = $alt_max;
						  $largura = round(($Img_w * $novoh1)/$Img_h);
						}
					  }
					}
					if($Img_w < $Img_h){
					  if($Img_h < $alt_max){
						$largura = $Img_w;
					  }else{
						$novoh1 = $alt_max;
						$largura = round(($Img_w * $novoh1)/$Img_h);
					  }
					}
					if($Img_w == $Img_h){
					  if($Img_w < $alt_max){
						$largura = $Img_w;
					  }else{
						$largura = $alt_max;
					  }
					}
					//echo $largura;
					
					criar_thumbnail(INCOMING.$monta_foto,INCOMING.$monta_foto,$largura,'','JPEG');
						
					// Prepara a Foto para ir Para o Site.
					InsereFotoNoSite($pasta_foto_site,$referencia,$m2,$cod_imovel2);
					
					echo "<center><span class=\"style1\">O arquivo <b>". $monta_foto." </b>foi enviado com sucesso a foto que foi enviada foi <b>".$file."</b>.</span></center><br><br>"; 
					
					}else{
										  
						echo "<center><span class=\"style7\">O arquivo <b>". $monta_foto." </b>não pode ser enviado pois já atingiu o limite máximo ($quantidade) de fotos por imóvel.</span></center><br><br>";   
					}
				}
					
				}
			}

			if($_POST['bfotos']=='1'){

				$data = date("Y-m-d");
   				$hora = date("H:i:s");
   				$B1 = "Inserir Imagem";	

				//Insere o usuário que esta fazendo a inserção da imagem
   				$insere = mysql_query("INSERT atualizacoes (cod_imobiliaria, a_cod_user, a_imovel, a_ref, a_acao, a_data, a_hora) VALUES ('".$_SESSION['cod_imobiliaria']."','".$u_cod."','".$ref."','".$ref."','".$B1."','".$data."','".$hora."')") or die ("Erro 370 - ".mysql_error());

				//Deleta o registro mais antigo da tabela, só deixa apenas as 10 ultimas atualizações
   				$busca_reg = mysql_query("SELECT a_id FROM atualizacoes WHERE a_imovel = '".$ref."' AND cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'") or die ("Erro 90 - ".mysql_error());
   				$cont = mysql_num_rows($busca_reg);
   				if($cont > 10) {
      				mysql_query("DELETE FROM atualizacoes WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' ORDER BY a_id ASC LIMIT 1") or die ("Erro 93 - ".mysql_error());
   				}
   			}

		}
	}			
			
			echo '<center><br><br><input type="button" name="voltar" id="voltar" class="campo3" value="Voltar" Onclick="window.location.href=\'p_envia_img.php\'"></center>';
?>	  </td>
	</tr>
<?
		} 
?>
</table>
</form><br>
				<form method="post" action="p_envia_img.php" name="form2">
				<table border="0" align="center" valign="top" cellspacing="3" width="75%">
				<tr class="fundoTabela">
				<td colspan="2" class="style1">Pesquisar Imagem:</b></td>
				</tr>
				<tr class="fundoTabela">
				<td width="30%" class="style1">Referência:</td>
				<td width="70%">
				<input type="text" size="30" name="chave" class="campo"></td>
				</tr>
				<tr class="fundoTabela">
				  <td class="style1">Finalidade:</td>
				  <td><span class="style1">
				    <select name="finalidade2" class=campo>
		              <option value="">Selecione</option>
                      <option value="Venda">Venda</option>
                      <option value="Locacao">Loca&ccedil;&atilde;o</option>
                      <option value="Venda_Vistoria">Vistoria Venda</option>
                      <option value="Locacao_Vistoria">Vistoria Loca&ccedil;&atilde;o</option>
                    </select>
				  </span></td>
				  </tr>
				<tr>
				<td colspan="2" align="left">
				<input type="button" value="Pesquisar Imagem" name="button1" class=campo3 Onclick="VerificaCampo2();"><br /><br /></td>
				</tr>
				</table>
				</form>

<form method="post" action="" name="form3">
                 <table width="75%" align="center" cellpadding="1" cellspacing="1">
				 	<tr bgcolor="#<?php print("$cor3"); ?>" height="15">
  						<td width="20%" align="center" class="style1"><b>Foto</b></td>
  						<td width="40%" class="style1" align="center"><b>Descri&ccedil;&atilde;o</b></td>
  						<td width="20%" class="style1" align="center"><b>Marcar para Enviar ou Retirar do Site</b></td>
  						<td width="20%" colspan="2" align="center" class="style1"><b>Exclus&atilde;o</b></td>
  					</tr>
  				</table>
<table width=75% align="center">
<?php
$tmp_cod = $_SESSION['cod_imobiliaria'];
$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$tmp_cod."'");
$row = mysql_fetch_array($result);
$tmp_pasta = $row['nome_pasta'];
$pasta = "../imobiliarias/".$tmp_pasta."/venda/";
$pastap = "../imobiliarias/".$tmp_pasta;
$pasta2 = "../imobiliarias/".$tmp_pasta."/locacao/";
$pastap2 = "../imobiliarias/".$tmp_pasta;
$pasta3 = "../imobiliarias/".$tmp_pasta."/venda_vistoria/";
$pastap3 = "../imobiliarias/".$tmp_pasta;
$pasta4 = "../imobiliarias/".$tmp_pasta."/locacao_vistoria/";
$pastap4 = "../imobiliarias/".$tmp_pasta;

$strDiretorio = $pasta; // pasta das imagens
$strDiretorio2 = $pasta2; // pasta das imagens
$strDiretorio3 = $pasta3; // pasta das imagens
$strDiretorio4 = $pasta4; // pasta das imagens
$strDiretorioAbrir = opendir($strDiretorio);
$strDiretorioAbrir2 = opendir($strDiretorio2);
$strDiretorioAbrir3 = opendir($strDiretorio3);
$strDiretorioAbrir4 = opendir($strDiretorio4);


//echo "<div align=\"center\"><font color=\"#990000\" face=\"tahoma\" size=\"2\"><strong>Listando Imagens JPG e GIF de um diretorio<br><br>Diretório Escolhido: </strong>".$strDiretorio."</font></div><br><br>";

	$i = 0;
	$m = 0;
	$arquivos = array();

if($chave && $finalidade2)
{
		$chave = trim($chave);
		$tm = strlen($chave);

		if($finalidade2=='Venda'){
		while(false !== ($strArquivos = readdir($strDiretorioAbrir))) {
			 if($strArquivos != "." && $strArquivos != "..")
			 {	
				  $fotosv2 = explode("_",$strArquivos);
			 	  $arq20[$i] = $fotosv2[0];
			 	  //$arq[$i] = substr($strArquivos,0,$tm);
			 	  $str[$i] = str_replace($chave,'@',$strArquivos);
			 	  $arq2[$i] = $strArquivos;
				  $arqF[$i] = "venda";
			 	  $i++;
			 }
		}
		}elseif($finalidade2=='Locacao'){
		while(false !== ($strArquivos = readdir($strDiretorioAbrir2))) {
			 if($strArquivos != "." && $strArquivos != "..")
			 {	
			 	  $fotosl2 = explode("_",$strArquivos);
			 	  $arq20[$i] = $fotosl2[0];
				  //$arq[$i] = substr($strArquivos,0,$tm);
			 	  $str[$i] = str_replace($chave,'@',$strArquivos);
			 	  $arq2[$i] = $strArquivos;
				  $arqF[$i] = "locacao";
			 	  $i++;
			 }
		}
		}elseif($finalidade2=='Venda_Vistoria'){
		while(false !== ($strArquivos = readdir($strDiretorioAbrir3))) {
			 if($strArquivos != "." && $strArquivos != "..")
			 {	
			 	  $fotosvl2 = explode("_",$strArquivos);
			 	  $arq20[$i] = $fotosvl2[0];
				  //$arq[$i] = substr($strArquivos,0,$tm);
			 	  $str[$i] = str_replace($chave,'@',$strArquivos);
			 	  $arq2[$i] = $strArquivos;
				  $arqF[$i] = "venda_vistoria";
			 	  $i++;
			 }
		}
		}elseif($finalidade2=='Locacao_Vistoria'){
		while(false !== ($strArquivos = readdir($strDiretorioAbrir4))) {
			 if($strArquivos != "." && $strArquivos != "..")
			 {	
			 	  $fotoslv2 = explode("_",$strArquivos);
			 	  $arq20[$i] = $fotoslv2[0];
				  //$arq[$i] = substr($strArquivos,0,$tm);
			 	  $str[$i] = str_replace($chave,'@',$strArquivos);
			 	  $arq2[$i] = $strArquivos;
				  $arqF[$i] = "locacao_vistoria";
			 	  $i++;
			 }
		}
		}
		
		for($i = 0 ; $i <= count($arq2) ; $i++)
		{
				if(!empty($arq2[$i]))
				{
				        
						//if((strpos($str[$i],'@') == true) OR (strtolower($arq[$i]) == strtolower($chave)))
						if((strtolower($arq20[$i]) == strtolower($chave)) and (strlen($arq20[$i]) == strlen($chave)))
						{
						 	 $arquivos[$i] = $arq2[$i];
							 $fold_arquivos[$i] = $arqF[$i];
						 	 $m++;
						}
				}
		}
?>

		<tr>
			<td colspan="4" class=style1>Resultado da Pesquisa por "<b><? echo $chave; ?></b>" e finalidade "<b><? echo $finalidade2; ?></b>".</td>
		</tr>
		<? if($_POST['editar']=='1'){ ?>
			<tr>
			  <td colspan="4" class=style7>Atenção: Na hora de mudar a ordem das fotos favor NÃO DEIXAR ORDENS REPETIDAS pois senão pode causar problemas nas fotos com ordens iguais.</td>
			</tr>
		
		<? } ?>
<?			
} else {
		while($strArquivos = readdir($strDiretorioAbrir)) {
			if($strArquivos != "." && $strArquivos != "..") {
				$arquivos[$i] = $strArquivos;
				$fold_arquivos[$i] = "venda";
				$i++;
			}
		}
		while($strArquivos = readdir($strDiretorioAbrir2)) {
			if($strArquivos != "." && $strArquivos != "..") {
				$arquivos[$i] = $strArquivos;
				$fold_arquivos[$i] = "locacao";
				$i++;
			}
		}
		while($strArquivos = readdir($strDiretorioAbrir3)) {
			if($strArquivos != "." && $strArquivos != "..") {
				$arquivos[$i] = $strArquivos;
				$fold_arquivos[$i] = "venda_vistoria";
				$i++;
			}
		}
		while($strArquivos = readdir($strDiretorioAbrir4)) {
			if($strArquivos != "." && $strArquivos != "..") {
				$arquivos[$i] = $strArquivos;
				$fold_arquivos[$i] = "locacao_vistoria";
				$i++;
			}
		}
}
	@array_multisort($arquivos, $fold_arquivos);
	
	if($chave <> ''){		
	  $quant_pag = 100;
	  $x = 0;
	}else{
	  $quant_pag = 10;
	}
 		
	if(!$screen){
	$screen = 1;
	}

	if(!$from){
		$from = intval(($screen - 1) * $quant_pag);
	}
	
	//if($from == 0){
	//	$from = 1;
	//}
		
	$from15 = $from + $quant_pag;
 	
 	$k= 1;	
	
	for ($j = $from; $from < $from15; $j++) {
		$from = $from + 1;
		
	if (($k % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$k++;
		
	if (in_array($arquivos[$j], $arquivos)) {
		
	if($i > 0){

 	$foto_peq = str_replace(".jpg","_peq.jpg","$arquivos[$j]");
	$extensao = explode(".", $arquivos[$j]);
	$parte2 = $extensao[0];
    $ordem_foto = explode("_", $parte2);
	
?>
<?php
	if(($extensao[1] == "jpg") or ($extensao[1] == "gif") or ($extensao[1] == "png") or ($extensao[1] == "jpeg"))
	{

	 $data = date("dmY");
	 $hora = date("His");
?>
    <tr class="<?php echo $fundo; ?>">
	<td align="center" width="20%" class="style1">
	<img border=0 src="<?php print("$pastap/$fold_arquivos[$j]_peq/$foto_peq?data=$data&hora=$hora"); ?>">	</td>
<?php
	}
?>
<? if($_POST['editar']=='1'){ ?>
	<td class="style1" align="left">
		<input type="hidden" name="pasta_grande_<?=$j ?>" id="pasta_grande_<?=$j ?>" value="<?=$pastap."/".$fold_arquivos[$j] ?>">
		<input type="hidden" name="pasta_pequena_<?=$j ?>" id="pasta_pequena_<?=$j ?>" value="<?=$pastap."/".$fold_arquivos[$j]."_peq" ?>">
	    <input type="hidden" name="foto_antiga_grande_<?=$j ?>" id="foto_antiga_grande_<?=$j ?>" value="<?=$arquivos[$j] ?>">
	    <input type="hidden" name="foto_antiga_pequena_<?=$j ?>" id="foto_antiga_pequena_<?=$j ?>" value="<?=$foto_peq ?>">
	    <input type="hidden" name="foto_antiga_pequena_<?=$j ?>" id="foto_antiga_pequena_<?=$j ?>" value="<?=$foto_peq ?>">
	    <input type="hidden" name="ordem_antiga_<?=$j ?>" id="ordem_antiga_<?=$j ?>" value="<?=$ordem_foto[1] ?>">
	<?php print($ordem_foto[0]); ?>_<input type="text" name="ordem_<?=$j ?>" id="ordem_<?=$j ?>" class="campo" size="2" maxlength="2" value="<?php print($ordem_foto[1]); ?>">.<?php print($extensao[1]); ?></td>
<? }else{ ?>
	<td width="40%" class="style1" align="left" style="text-indent: 5px;"><?php print($arquivos[$j]); ?></td>
<? }

	$pasta_foto = $fold_arquivos[$j];
	$nome_foto = substr($foto_peq,0,strpos(str_replace("_peq","",$foto_peq),"_"));
	$sequencia = str_replace(".","",str_replace("_","",substr(str_replace("_peq","",$foto_peq),strpos(str_replace("_peq","",$foto_peq),"_"),3)));
	//echo "Mostra ==> ".$pasta_foto." <==> ".$nome_foto." <==> ".$sequencia." <br>";
	$tipo_envio_site ="";
	if(VerificaFotoDaPasta($nome_foto,$sequencia)){
		$busca_imovel = "select cod from muraski where ref='".$nome_foto."'  and cod_imobiliaria='3'";
		$rsimovel = mysql_query($busca_imovel) or die ("Erro 225 - " . mysql_error());
		if (mysql_num_rows($rsimovel) > 0) {
			while ($nv = mysql_fetch_assoc($rsimovel)) {
				$cod_imovel = $nv['cod'];
			}
		}
		if(VerificaFotoNoSite($nome_foto,$sequencia,$cod_imovel)){
		   $tipo_envio_site = "Retirar";
		}else{$tipo_envio_site = "Enviar";}
	}else{$tipo_envio_site = "";}

	$url3 = $PHP_SELF . "?screen=" . $k . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem. "&finalidade2=" . $finalidade2 . "&B1=Apagar Imagem" . "&foto=" . $arquivos[$j]. "&tmp_fold=" . $fold_arquivos[$j]."&cod_imovel=".$cod_imovel;
	
	$url_site = $PHP_SELF . "?screen=" . $k . "&chave=" . $chave . "&pesq=" . $pesq . "&ordem=" . $ordem ;
	$url_site .= "&B1=Atualiza Imagem" . "&foto=" . $arquivos[$j] ."&cod_imovel=".$cod_imovel."&tipo_envio=".$tipo_envio_site;
	
	if($tipo_envio_site == ""){
	
?>
	<td width="20%" colspan="2" align="center">
<?	}else{?>
	<td width="20%" colspan="2" align="center">
	 <input type="hidden" name="cod_refer_<?=$j ?>" id="cod_refer_<?=$j ?>" value="<?=$cod_imovel ?>">
	<input type="hidden" name="nome_foto_<?=$j ?>" id="nome_foto_<?=$j ?>" value="<?=$nome_foto ?>">
	 <input type="hidden" name="seq_foto_<?=$j ?>" id="seq_foto_<?=$j ?>" value="<?=$sequencia ?>">
	 <input type="hidden" name="tipo_envio_<?=$j ?>" id="tipo_envio_<?=$j ?>" value="<?=$tipo_envio_site ?>">
	 <input type="hidden" name="foto_<?=$j ?>" id="foto_<?=$j ?>" value="<?=$arquivos[$j] ?>">
	<input type="checkbox" <?if(!verificaFuncao("SEL_IMAGEM")){echo "HIDDEN";}?> name="enviarsite_foto_<?=$j ?>" id="enviarsite_foto_<?=$j ?>" value="1"><a href="#" <?if(!verificaFuncao("SEL_IMAGEM")){echo "HIDDEN";}?> onClick="if (confirm('Deseja Realmente Atualizar a Foto \'<?php print("$arquivos[$j] no Site" ); ?>\'?')) { window.location='<?=$url_site ?>'; }" class="style1"><? echo $tipo_envio_site; ?></a></td>
<?	}?>
	<td width="20%" colspan="2" align="center">
	 <input type="hidden" name="foto_<?=$j ?>" id="foto_<?=$j ?>" value="<?=$arquivos[$j] ?>">
	 <input type="hidden" name="tmp_fold_<?=$j ?>" id="tmp_fold_<?=$j ?>" value="<?=$fold_arquivos[$j] ?>">
	<input type="checkbox" name="apagar_foto_<?=$j ?>" id="apagar_foto_<?=$j ?>" value="1"><a href="#" onClick="if (confirm('Deseja Realmente excluir o arquivo \'<?php print("$arquivos[$j]"); ?>\'?')) { window.location='<?=$url3 ?>'; }" class="style1">Apagar</a></td>
</tr>
<?php

}
$x++;
}
}
?>
	    <input type="hidden" name="cont" id="cont" value="<?=$x ?>">
	    <input type="hidden" name="contador" id="contador" value="<?=$j ?>">
<?
	if($chave != ""){

	$total_img = $m;
	$paginas = $pages = ceil($m / $quant_pag);

	}
	else
	{

	$total_img = $i;
	$paginas = $pages = ceil($i / $quant_pag);
	}
	$pagina = $screen;
    $url = "p_envia_img.php?chave=".$chave."&pesq=".$pesq."&ordem=".$ordem."&finalidade2=".$finalidade2."&screen=";
?>
                  <? if($chave != "" && $finalidade2 != ""){ ?>
				  <tr>
                  	<td colspan="4" bgcolor="<?php print("$cor1"); ?>" class=style1 align=left>
                  	<? if($_POST['editar']=='1'){  ?>
                  	  <input type="hidden" name="acao" id="acao" value="0">
					  <input type="button" value="Atualizar ordem" name="atualizar" id="atualizar" class="campo3" onClick="formOrdem('<?=$chave ?>', '<?=$finalidade2 ?>', '<?=$pesq ?>', '<?=$ordem ?>', '<?=$screen ?>')">
					<?
					}else{
					   if (verificaFuncao("GERAL_EDIT_IMAGEM")) {
					?>
					  <input type="hidden" name="editar" id="editar" value="0">
					  <input type="submit" value="Editar ordem da(s) imagem(ns)" name="bt_editar" id="bt_editar" class="campo3" onClick="form3.action='p_envia_img.php?chave=<?=$chave ?>&finalidade2=<?=$finalidade2 ?>&pesq=<?=$pesq ?>&ordem=<?=$ordem ?>&screen=<?=$screen ?>';form3.editar.value='1'">
					<?
					  }
					}
					?>					  </td>
                  </tr>
                  <? } ?>
                  <tr>
                  	<td colspan="4" class=style1 align=left>
				<input type="hidden" name="acao_apagar" id="acao_apagar" value="0">
				<input type="button" value="Apagar fotos selecionadas" name="bt_apagar" id="bt_apagar" class="campo3" Onclick="Validacao('<?=$chave ?>', '<?=$finalidade2 ?>', '<?=$pesq ?>', '<?=$ordem ?>', '<?=$screen ?>');">
				<br>
			</td>
			</tr>
			<tr>
                  	<td colspan="4" class=style1 align=left>
				<input type="hidden" name="acao_site" id="acao_site" value="0">
				<input type="button" <?if(!verificaFuncao("SEL_IMAGEM")){echo "DISABLED";}?> value="Confirmar o Envio/Retirada do Site das fotos Selecionadas" name="bt_enviarsite" id="bt_enviarsite" class="campo3" Onclick="ValidaEnvioSite('<?=$chave ?>', '<?=$finalidade2 ?>', '<?=$pesq ?>', '<?=$ordem ?>', '<?=$screen ?>');">
			</td>
			
                  </tr>
				  <tr>
                  	<td colspan="4" bgcolor="<?php print("$cor3"); ?>" class=style1 align=center>
                  	<b>Foram encontradas <?php print("$total_img"); ?> foto(s)</b></td>
                  </tr>
                  <tr>
                    <td colspan="4" align=left class=style1>
						<table width="100%" cellpadding="0" cellspacing="0">
               				<tr>
                  				<td width="10%" class="style1" align="center"><a href="p_envia_img.php?chave=<?=$chave ?>&pesq=<?=$pesq ?>&ordem=<?=$ordem ?>&finalidade2=<?=$finalidade2 ?>&screen=1" class="style7"><? if ($screen > 1) { ?>|Primeira|<? } ?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_envia_img.php?chave=<?=$chave ?>&pesq=<?=$pesq ?>&ordem=<?=$ordem ?>&finalidade2=<?=$finalidade2 ?>&screen=<?=$screen-1?>" class="style6"><? if ($screen > 1) { ?>|Anterior|<? } ?></a></td>
                  				<td class="style1" align="center">
								<?
   									$i = 0;
   									$completa = "";
   									if ($paginas > 9){
      									if ($pagina < 5){
   	   										$inicio = 1;
         									$final = 9;
      									}elseif($pagina > $paginas - 5){
   	   										$inicio = $paginas - 9;
         									$final = $paginas;
      									}else{
   	   										$inicio = $pagina - 4;
         									$final = $pagina + 4;
      									}
   									}else{
	   										$inicio = 1;
      										$final = $paginas;
   									}

   									for ($j = $inicio; $j < ($final+1); $j++){
      									if(($paginas > 9) && (strlen($j)==1)){
		   									$j = "0".$j;
      									}

      									$url2 = $url . $j;

      									if($j == $pagina){
            								print "<a href=\"$url2\" class='style1'>|<b>$j</b>|</a>";
 	   									}else{
     	      								print "<a href=\"$url2\" class='style1'>|$j|</a>";
  	   									}
   									}
								?>
                  				</td>
                  				<td width="10%" class="style1" align="center"><a href="p_envia_img.php?chave=<?=$chave ?>&pesq=<?=$pesq ?>&ordem=<?=$ordem ?>&finalidade2=<?=$finalidade2 ?>&screen=<?=$screen+1?>" class="style6"><? if ($screen < $paginas) { ?>|Próxima|<?}?></a></td>
                  				<td width="10%" class="style1" align="center"><a href="p_envia_img.php?chave=<?=$chave ?>&pesq=<?=$pesq ?>&ordem=<?=$ordem ?>&finalidade2=<?=$finalidade2 ?>&screen=<?=$paginas?>" class="style7"><? if ($screen < $paginas) { ?>|Última|<?}?></a></td>
               				</tr>
   						</table>
					</td>
                  </tr>
</table>
</form>
<?  if(session_is_registered("valid_user")){ ?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e0e0e0" height="1"></td>
  </tr>
</table>
<table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
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