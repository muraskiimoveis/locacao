<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include("style.php");
include("conect.php");
include("calendario2.php");
include("l_funcoes.php");
include("funcoes/funcoes.php");
verificaAcesso();
verificaArea("GERAL_VEND");
verificaArea("GERAL_LOCA");

  $datafo = date("dmY");
  $horafo = date("His");

if($_GET['mostra']){
  $mostra = $_GET['mostra'];
}else{
  $mostra = $_POST['mostra'];
}

if($_SESSION['cod_imobiliaria']=='3'){
    $origem_mapa = "muraski";
}else{
    $origem_mapa = "rebri";
}


?>
<html>

<head>
<META Http-Equiv="Cache-Control" Content="no-cache">
<META Http-Equiv="Pragma" Content="no-cache">
<META Http-Equiv="Expires" Content="0">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1"> 
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
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
<div align="center">
<table width="75%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr height="50">
    <td colspan="6">
      <p align="center" class="style48"><b>Detalhes do Imóvel</b> - <a href="detalhes_impressao.php?cod=<?=$cod ?>&codi=<?=$codi ?>&pastai=<?=$pastai ?>&nomei=<?=$nomei ?>" class="style48" target="_blank">Clique para Imprimir</a></p>
    </td>
  </tr>
        <?php

	$query1 = "SELECT * FROM muraski m inner join rebri_tipo t on (m.tipo=t.t_cod) inner join rebri_cidades c on (m.local=c.ci_cod) inner join rebri_estados e on (m.uf=e.e_cod) WHERE m.cod='$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result1 = mysql_query($query1);
	while($not1 = mysql_fetch_array($result1))
	{

   if ($not1[caracteristica] <> "") {
    $caracteristica = $not1[caracteristica];
    $t_caracteristica = explode("--",$caracteristica);
    $t_caracteristica = str_replace("-","",$t_caracteristica);
    foreach ($t_caracteristica as $conteudo) {
     $sql_caracteristica = "SELECT c_nome FROM rebri_caracteristicas WHERE c_cod = $conteudo";
     $rs_caract = mysql_query($sql_caracteristica) or die ("Erro 470 - " . mysql_error());
     $notx = mysql_fetch_assoc($rs_caract);
     $caract_imovel[] = $notx[c_nome];
    }
   }

	$descricao = str_replace("\n","<br>","$not1[descricao]");
	$permuta_txt = str_replace("\n","<br>","$not1[permuta_txt]");
    $carnaval = number_format($not1[carnaval], 2, ',', '.');
    $anonovo = number_format($not1[anonovo], 2, ',', '.');
	  
	  if($_SESSION['cod_imobiliaria'] == '3'){ 
          
          		if (mb_detect_encoding($not1[titulo], "ASCII, UTF-8, ISO-8859-1") == "UTF-8") {
      				$not1[titulo] = utf8_decode($not1[titulo]);
   				}
   				
   				if (mb_detect_encoding($not1[tipo_logradouro], "ASCII, UTF-8, ISO-8859-1") == "UTF-8") {
      				$not1[tipo_logradouro] = utf8_decode($not1[tipo_logradouro]);
   				}
   				
   				if (mb_detect_encoding($not1[end], "ASCII, UTF-8, ISO-8859-1") == "UTF-8") {
      				$not1[end] = utf8_decode($not1[end]);
   				}
   				
   				if (mb_detect_encoding($descricao, "ASCII, UTF-8, ISO-8859-1") == "UTF-8") {
      				$descricao = utf8_decode($descricao);
   				}
   				
   				if (mb_detect_encoding($permuta_txt, "ASCII, UTF-8, ISO-8859-1") == "UTF-8") {
      				$permuta_txt = utf8_decode($permuta_txt);
   				}

         }else{
        
		   		$not1[titulo] = $not1[titulo];
            	$not1[tipo_logradouro] = $not1['tipo_logradouro'];
		  		$not1[end] = $not1['end'];
		  		$descricao = $descricao;
		  		$permuta_txt = $permuta_txt;
		}
	  
	
	if (empty($mes)) {
		$mes = date("m");
		$ano = date("Y");
	}

		### inicializa&ccedil;&atilde;o de variaveis
                $mes01 = array();
                $mes02 = array();
                $mes03 = array();
                $mes04 = array();
                $mes05 = array();
                $mes06 = array();
                $mes07 = array();
                $mes08 = array();
                $mes09 = array();
                $mes10 = array();
                $mes11 = array();
                $mes12 = array();
                $datapermitida = array();
                $todasdatas = array();

		$pano = substr ($not1[data_inicio], 0, 4);
                $pmes = substr($not1[data_inicio], 5, 2 );
                $pdia = substr ($not1[data_inicio], 8, 2 );
                $pano1 = substr ($not1[data_fim], 0, 4);
                $pmes1 = substr($not1[data_fim], 5, 2 );
                $pdia1 = substr ($not1[data_fim], 8, 2 );
                $pdata_inicio = "$pdia/$pmes/$pano";
                $pdata_fim = "$pdia1/$pmes1/$pano1";

                if (!$nextmesano){
                	$nextmes = $mes;
                        $nextano = $ano;
			$nextmesano = "$mes/$ano";
                }


                ### monta array com periodo permitido para locacao
                #print "data permitida = $pdata_inicio, $pdata_fim<br>";
                array_push ($datapermitida, $pdata_inicio, $pdata_fim);


	$valor = number_format($not1[valor], 2, ',', '.');
	$metragem = str_replace(".",",","$not1[metragem]");
	$finalidade = $not1[finalidade];
	$video = $not1['video'];
	$origem_video = $not1['origem_video'];
	$img_1 = $not1[img_1];
	$img_2 = $not1[img_2];
	$img_3 = $not1[img_3];
	$img_4 = $not1[img_4];
	$img_5 = $not1[img_5];
	$img_6 = $not1[img_6];
	$img_7 = $not1[img_7];
	$img_8 = $not1[img_8];
	$img_9 = $not1[img_9];
	$img_10 = $not1[img_10];
	
	if($not1['end_igual']=='1'){
	   $endereco_mapa = $not1['tipo_logradouro']." ".$not1['end'].", ".$not1['numero']." - ".$not1['ci_nome'].", ".$not1['e_uf'].", ".formataCEPDoBd($not1['cep']);
	   $endereco_balao = $not1['tipo_logradouro']." ".$not1['end'].", ".$not1['numero']." - ".$not1['ci_nome'].", ".$not1['e_uf'].", ".formataCEPDoBd($not1['cep']);
	}else{
	  $endereco_mapa = $not1['tipo_logradouro_mapa']." ".$not1['end_mapa'].", ".$not1['numero_mapa']." - ".$not1['ci_nome'].", ".$not1['e_uf'].", ".formataCEPDoBd($not1['cep_mapa']);
	  $endereco_balao = $not1['tipo_logradouro']." ".$not1['end'].", ".$not1['numero']." - ".$not1['ci_nome'].", ".$not1['e_uf'].", ".formataCEPDoBd($not1['cep']);
	}
	
	if(($not1[local] == "Caiob&aacute;") or ($not1[local] == "Matinhos")){
		$arquivo = "emissor.swf?mapa=matinhos&posx=" . $not1[posx] . "&posy=" . $not1[posy];
	}
	else
	{
		$arquivo = "emissor.swf?mapa=guaratuba&posx=" . $not1[posx] . "&posy=" . $not1[posy];
	}
?>
        <?
if($not1[finalidade]=='1'){
  $fin = "Venda_Rebri";
}elseif($not1[finalidade]=='2'){
  $fin = "Venda_".$_SESSION['nome_imobiliaria'];
}elseif($not1[finalidade]=='3'){
  $fin = "Venda_Parceria";
}elseif($not1[finalidade]=='4'){
  $fin = "Venda_Terceiros";
}elseif($not1[finalidade]=='5'){
  $fin = "Venda_Off";
}elseif($not1[finalidade]=='6'){
  $fin = "Venda_Vendido";
}elseif($not1[finalidade]=='7'){
  $fin = "Venda_Todos";
}elseif($not1[finalidade]=='8'){
  $fin = "Locação_Anual_Rebri";
}elseif($not1[finalidade]=='9'){
  $fin = "Locação_Anual_".$_SESSION['nome_imobiliaria'];
}elseif($not1[finalidade]=='10'){
  $fin = "Locação_Anual_Parceria";
}elseif($not1[finalidade]=='11'){
  $fin = "Locação_Anual_Terceiros";
}elseif($not1[finalidade]=='12'){
  $fin = "Locação_Anual_Off";
}elseif($not1[finalidade]=='13'){
  $fin = "Locação_Anual_Locado";
}elseif($not1[finalidade]=='14'){
  $fin = "Locação_Anual_Todos";
}elseif($not1[finalidade]=='15'){
  $fin = "Locação_Temporada_".$_SESSION['nome_imobiliaria'];
}elseif($not1[finalidade]=='16'){
  $fin = "Locação_Temporada_Off";
}elseif($not1[finalidade]=='17'){
  $fin = "Locação_Temporada_Todos";
}
?>
        <tr class="fundoTabela">
          <td colspan="6"><p align="left" class="style1"><b><?php print("$not1[t_nome]"); ?></b> - <?php print($fin); ?></p></td>
        </tr>
        <tr class="fundoTabela">
          <td colspan="6"><p align="left" class="style1"><b>Ref.: <?php print("$not1[ref]"); ?></b> - <?php print $not1[titulo]; ?></p></td>
        </tr>
<? if ($not1[observacoes2] != "") { ?>
<tr><td colspan=6 class="style7"><strong><?=$not1[observacoes2]?></strong></td></tr>
<? } ?>
        <?php
	if(!$foto){
	$foto = 1;
	$vazio = 2;
	}
	
	/*
	$result = mysql_query("SELECT nome_pasta FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
	$row = mysql_fetch_array($result);
	$tmp_pasta = $row['nome_pasta'];
	*/
	/*
			$pasta_fin = strtolower(substr($not1[finalidade], 0, 4));
				if($pasta_fin == "loca"){
			*/
				if($finalidade=='8' || $finalidade=='9' || $finalidade=='10' || $finalidade=='11' || $finalidade=='12' || $finalidade=='13' || $finalidade=='14' || $finalidade=='15' || $finalidade=='16' || $finalidade=='17'){
					$pasta_finalidade = "locacao";
				}
				else
				{
					$pasta_finalidade = "venda";
				}
			$pasta = "../imobiliarias/".$_SESSION['nome_pasta']."/".$pasta_finalidade."/";

	$nome_foto = $not1[ref] . "_" . ($foto). ".jpg";
	$nome_fotop = $not1[ref] . "_" . ($foto). ".jpg";
	$texto_foto = "ftxt_" . ($foto);
	//$nome_foto2 = $not1[ref] . "_" . ($foto + 1) . ".jpg";
	
	$ImageSize = @GetImageSize ($pasta . $nome_foto);
	$Img_w = $ImageSize[0];
	$Img_h = $ImageSize[1];
	if($impressao == ""){
	$largura = $Img_w;
	}
	else
	{
	$largura = "350";
	}
	
	$texto_foto = "ftxt_" . ($foto);
	//$nome_foto2 = $not1[ref] . "_" . ($foto + 1) . ".jpg";
	
	if (file_exists($pasta.$nome_foto))
	{
?>
        <?php
	
	if(!$foto){
	$foto = 1;
	$vazio = 2;
	}

	$nome_foto1 = $not1[ref] . "_1" . ".jpg";
	
	
	if (file_exists($pasta.$nome_foto1))
	{
	
?>
<tr>
	<td colspan="2" class="style48"><b>Fotos:</b></td>
</tr>
</table>
            <script language="javascript"><!--start
var x = 0;

function rotate(num){
x=num%document.slideForm.slide.length;
if(x<0){x=document.slideForm.slide.length-1};
document.images.show.src=document.slideForm.slide.options[x].value;
document.slideForm.slide.selectedIndex=x;
}

function apRotate() {
if(document.slideForm.slidebutton.value == "Parar"){
rotate(++x);window.setTimeout("apRotate()", 5000);}
}
//end --></script>    </td></tr>
<tr><td colspan="4"><table width="50%" align="center" >
<tr>
  <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name="slideForm">  
    <tr>
      <td width="17%">&nbsp;</td>
      <td width="56%"><input type=button onClick="rotate(0);" value="|&lt;&lt;" title="Primeira Foto" class=campo3>
  <input type=button onClick="rotate(x-1);" value="<<" title="Foto Anterior" class=campo3>
  <input type=button name="slidebutton" onClick="this.value=((this.value=='Parar')?'Iniciar':'Parar');apRotate();" value="Iniciar" title="Mudar Automaticamente" class=campo3>
  <input type=button onClick="rotate(x+1);" value=">>" title="Próxima Foto" class=campo3>
  <input type=button onClick="rotate(this.form.slide.length-1);" value="&gt;&gt;|" title="Última Foto" class=campo3></td>
      <td width="15%"><select name="slide" onChange="rotate(this.selectedIndex);" class=campo>
<?php
	if(!$foto){
		$foto = 1;
		$vazio = 2;
	}
	
	for ($foto = 1; $foto <= $vazio; $foto++) {
		
		$nome_foto = $not1[ref] . "_" . ($foto). ".jpg";

		if (is_file($pasta.$nome_foto) && file_exists($pasta.$nome_foto)) {

			if ($pasta . $nome_foto) {
				$texto_foto = "ftxt_" . ($foto);
				if($not1[$texto_foto] == "")
				{
					$texto = "Foto" . $foto;
				}
				else
				{
					$texto = $not1[$texto_foto];
				}	
			}
			$nome_foto2 = $not1[ref] . "_" . ($foto + 1) . ".jpg";
			$vazio++;
		
			if (file_exists($pasta . $nome_foto))
			{
?>
				<option value="<?php echo $pasta.$nome_foto."?datafo=$datafo&horafo=$horafo"; ?>"><?php echo $texto; ?></option>
<?php
			}
			elseif (file_exists($pasta . $nome_foto2))
			{
?>
				<option value="<?php echo $pasta.$nome_foto."?datafo=$datafo&horafo=$horafo"; ?>"><?php echo $texto; ?></option>
<?php
			}
			else
			{
				$vazio = $foto;
			}
		}
	}
?>
      </select></td>
      <td width="12%">&nbsp;</td>
    </tr>
</form>	
  </table></td>
</tr>
<?php
	}
?>
<tr><td colspan="6"><p align="center">
<?php

	if (file_exists($pasta . $nome_fotop))
	{	
?>
<img border="0" src="<?php print($pasta.$nome_fotop."?datafo=$datafo&horafo=$horafo"); ?>" name="show">
<? 
    }
?>    
    </td></tr>
<?php
	}
?>
<tr>
<td  colspan="6">
<tr><td width="20%" class="style1">
<b>Metragem:</b></td><td width="80%" class="style1" colspan="5"><?php print("$metragem"); ?> m<sup>2</sup></td></tr>
<?php
	if($not1[n_quartos] > 0){
?>
<tr><td width="20%" class="style1">
<b>N° de quartos:</b></td><td width="80%" colspan="5" class="style1"><?php print("$not1[n_quartos]"); ?></td></tr>
<?php
	}
?>
<?php
	if($not1[suites] > 0){
?>
<tr>
<td width="20%" class="style1">
<b>Suítes:</b></td><td width="80%" colspan="5" class="style1"><?php print("$not1[suites]"); ?></td></tr>
<?php
	}
?><tr>
<td width="20%" class="style1">
<?php
	//if($not1[finalidade] == Venda){
	if($not1[finalidade]=='1' || $not1[finalidade]=='2' || $not1[finalidade]=='3' || $not1[finalidade]=='4' || $not1[finalidade]=='5' || $not1[finalidade]=='6' || $not1[finalidade]=='7' || $not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){
?>
<b>Valor:</b>
<?php
	}
	else
	{
?>
<b>Diária:</b>
<?php
	}
?></td>
<td width="80%" colspan="5" class="style1">R$ <?php print("$valor"); ?>
<?php
	if($not1[carnaval] > 0){
?>
<br>
<b>Carnaval:</b> R$ <?php print("$carnaval"); ?>
<?php
	}
?>
<?php
	if($not1[anonovo] > 0){
?>
<br>
<b>Ano Novo:</b> R$ <?php print("$anonovo"); ?>
<?php
	}
?>
</td></tr>
<tr>
	<td colspan="2" align="left" class="style1">
<?
		if($not1[finalidade]=='1' || $not1[finalidade]=='2' || $not1[finalidade]=='3' || $not1[finalidade]=='4' || $not1[finalidade]=='5' || $not1[finalidade]=='6' || $not1[finalidade]=='7' || $not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){
		  	$mostra = " O valor ";
		}else{
		  	$mostra = "A diária ";
		}
?>
		*<?=$mostra ?>pode ser alterado sem aviso pr&eacute;vio.
	</td>
</tr>
<tr><td width="20%" class="style1">
<b>Localização:</b></td><td width="80%" colspan="5" class="style1"><?php print("$not1[local]"); ?></td></tr>
<?php
	if($not1[piscina] > 0){
?><tr><td width="20%" class="style1">
<b>Piscina:</b></td><td width="80%" colspan="5" class="style1"><b><?php print("$not1[piscina]"); ?></td></tr>
<?php
	}
?>
<?
					## se tem acomod, mostra!
					if($not1[acomod] > 0){
?>
					<tr><td width="20%" class="style1">
					<b>Acomodações:</b></td><td class="style1" colspan="5">
					<?php print("$not1[acomod]"); ?> pessoas </td></tr>
<?
					}
?>
<?
			  ## se tem end, mostra!
			  if($not1[end] <> ''){
			    if($not1[exibir_endereco]<>'1'){
?>
			  <tr><td width="20%" class="style1">
					<b>Endereço:</b></td><td class="style1" colspan="5">
					<?php print("$not1[tipo_logradouro]"); ?> <?php print("$not1[end]"); ?>, <?php print("$not1[numero]"); ?></td></tr>
<?
			  	}elseif($not1[exibir_endereco]=='1' && $codi == $_SESSION['cod_imobiliaria']){
?>
			  <tr><td width="20%" class="style1">
					<b>Endereço:</b></td><td class="style1" colspan="5">
					<?php print("$not1[tipo_logradouro]"); ?> <?php print("$not1[end]"); ?>, <?php print("$not1[numero]"); ?></td></tr>

<?			  	  			    
				}
			}
?>


	
<?
					## se tem cep, mostra!
					if($not1[cep] != ""){
?>
					<tr><td width="20%" class="style1">
					<b>CEP:</b></td><td class="style1" colspan="5"><?php print(formataCEPDoBd($not1[cep])); ?></td></tr>
<?
					}					
?>
<tr>
      <td class="style1" colspan="6">
	  <?
			$funcoes = explode("-", $not1[bairro]);
			$funcoes_cnt   = count($funcoes);
 
			for ($i = 0; $i < $funcoes_cnt; $i++) 
 			{
				if($i < 1){
					$query_bairro = " where b_cod='" . $funcoes[$i] . "'";
   				}
   				else
   				{
					$query_bairro .= " or b_cod='" . $funcoes[$i] . "'";   				
   				}
 			}
	  ?>
	   <fieldset><legend><b>Bairros</b></legend>
		<?
		$busca_bairros = mysql_query("SELECT * FROM rebri_bairros $query_bairro ORDER BY b_nome");
		while($linha = mysql_fetch_array($busca_bairros)){
		?>
			<div class="DivBairros"><?= $linha['b_nome']; ?></div>

		<?
		}
		?>
	  </fieldset>	  </td>
  </tr>
<?
					## se tem dist_mar, mostra!
					if($not1[dist_mar] > 0){
?>
					<tr><td width="20%" class="style1">
					Distância do mar:</td><td class="style1">
					<b><?php print("$not1[dist_mar] $not1[dist_tipo]"); ?></b></td></tr>
<?
					}
?>
<?php
//	if($not1[tipo] != "Terreno"){
?>
<!--tr>
<td width="20%" class="style1">
Especificação:</td><td width="80%" colspan="5" class="style1"><b><?php //print("$not1[especificacao]"); ?></td></tr>
<?php
//	}
?><tr-->
<?
if($not1[finalidade]=='1'){
  $fin = "Venda_Rebri";
}elseif($not1[finalidade]=='2'){
  $fin = "Venda_".$_SESSION['nome_imobiliaria'];
}elseif($not1[finalidade]=='3'){
  $fin = "Venda_Parceria";
}elseif($not1[finalidade]=='4'){
  $fin = "Venda_Terceiros";
}elseif($not1[finalidade]=='5'){
  $fin = "Venda_Off";
}elseif($not1[finalidade]=='6'){
  $fin = "Venda_Vendido";
}elseif($not1[finalidade]=='7'){
  $fin = "Venda_Todos";
}elseif($not1[finalidade]=='8'){
  $fin = "Locação_Anual_Rebri";
}elseif($not1[finalidade]=='9'){
  $fin = "Locação_Anual_".$_SESSION['nome_imobiliaria'];
}elseif($not1[finalidade]=='10'){
  $fin = "Locação_Anual_Parceria";
}elseif($not1[finalidade]=='11'){
  $fin = "Locação_Anual_Terceiros";
}elseif($not1[finalidade]=='12'){
  $fin = "Locação_Anual_Off";
}elseif($not1[finalidade]=='13'){
  $fin = "Locação_Anual_Locado";
}elseif($not1[finalidade]=='14'){
  $fin = "Locação_Anual_Todos";
}elseif($not1[finalidade]=='15'){
  $fin = "Locação_Temporada_".$_SESSION['nome_imobiliaria'];
}elseif($not1[finalidade]=='16'){
  $fin = "Locação_Temporada_Off";
}elseif($not1[finalidade]=='17'){
  $fin = "Locação_Temporada_Todos";
}
?>
<tr>
<td width="20%" class="style1">
<b>Finalidade:</b></td><td width="80%" class="style1" colspan="5"><?php print($fin); ?></td></tr>
<tr><td colspan="4" align="left" class="style1">
<b>Descrição do Imóvel:</b><p><?php print $descricao; ?></p>
            <table width=100% align=center border=0 cellspacing="1" cellpadding="0">
             <tr>

<?               if (($caract_imovel <> "") && (count($caract_imovel) > 1 && $caract_imovel[0]!="")) { ?>
<?
                     $j=0;
                     foreach ($caract_imovel as $campo => $fcaracteristica) {
                        if (mb_detect_encoding($fcaracteristica, "ASCII, UTF-8, ISO-8859-1") == "UTF-8") {
                           $fcaracteristica = utf8_decode($fcaracteristica);
                        }
                        if ($j % 3 == 0 && $j >0) {
                           print "</tr><tr>";
                        }

                        print "<td align='center' width=33% bgcolor='#FFFFFF' class='style1'>
                        <table width=100%>
                         <tr>
                          <td align=right><img src='images/check.gif' /></td>
                          <td align=left class='style1'>".$fcaracteristica."</td>
                         </tr>
                        </table>";
                        $j++;
                     }
                  unset($caract_imovel);
                  ?>
<?               } ?>
             </tr>
            </table>


<br><br><?php if($not1['permuta']=='Sim'){ echo "<b>Texto da Permuta:</b><br /><br />".$permuta_txt.""; }  ?></td></tr>
<?
if($video != ""){
?>
			  <tr>
               	<td colspan="2" class="style48"><b>Vídeo:</b></td>
              </tr> 
              <tr>
                <td colspan="4" valign="top" class="style11" align="center">
                  <table border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <td align="center"><table border="0" cellspacing="5" cellpadding="0">
                        <tr>
                          <td align="center">
<?php
	if($origem_video == "Globo"){
?>
<object width="480" height="392">
<param value="http://video.globo.com/Portal/videos/cda/player/player.swf" name="movie" />
<param value="high" name="quality" />
<param value="wmode" name="transparent" />
<param value="midiaId=<?=$video; ?>&autoStart=false&width=480&height=392" name="FlashVars" />
<embed width="480" height="392" flashvars="midiaId=<?=$video; ?>&autoStart=false&width=480&height=392" type="application/x-shockwave-flash" quality="high" wmode="transparent" src="http://video.globo.com/Portal/videos/cda/player/player.swf"></embed>
</object>
<?
} elseif ($origem_video == "Blip") { 
?>
         <embed src="http://blip.tv/play/<?=$video; ?>" type="application/x-shockwave-flash" width="480" height="392" allowscriptaccess="always" allowfullscreen="true"></embed>
<?php
}else{
?>
<script type="text/javascript">
AC_FL_RunContent( 'classid','clsid:D27CDB6E-AE6D-11cf-96B8-444553540000','codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','480','height','392','src','http://www.youtube.com/v/<?=$video; ?>&hl=pt-br&color1=0x004024&color2=0xd1dcd7&rel=0','quality','high','wmode','transparent','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','http://www.youtube.com/v/<?=$video; ?>&hl=pt-br&color1=0x004024&color2=0xd1dcd7&rel=0' );
</script>
<?php
}
?>						  
						  </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>				</td>
              </tr>
<?
}
?>
<?php
	//	if(($not1[posx] != "") or ($not1[posy] != "")){
  	if($not1[coordenadas] != ""){?>
  		<tr>
  	  		<td colspan="4" align="left" class="style48"><b>Mapa:</b></td>
  	  	</tr>
		<?$busca_coor = mysql_query("SELECT c.ci_nome, m.coordenadas FROM muraski m INNER JOIN rebri_cidades c ON (m.local=c.ci_cod) WHERE m.coordenadas not like '<iframe%' AND m.coordenadas not like 'http://maps%' AND m.cod='".$cod."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
		$numrowscoo = mysql_num_rows($busca_coor);
        if($numrowscoo > 0){
 	  		while($linha = mysql_fetch_array($busca_coor)){
 	  		    $cidade_mapa = strtolower(deixar_minusculo($linha['ci_nome']));
 	  		    $coord = explode("/", $linha['coordenadas']);
 	  		    $parte1 = $coord[0];
 	  		    $parte2 = $coord[1];
 	  		}
?>
			<tr><td colspan="4" align="center" class="style1">
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,42,0" id="efeito_top" width="550" height="400" style="z-index:1">
  			<param name="movie" value="emissor.swf?mapa=<?=$cidade_mapa ?>&posx=<?=$parte1 ?>&posy=<?=$parte2 ?>">
  				<param name="quality" value="high">
    			<embed name="efeito_top" src="emissor.swf?mapa=<?=$cidade_mapa ?>&posx=<?=$parte1 ?>&posy=<?=$parte2 ?>"
     				quality="high" swLiveConnect="true"
     				width="550" height="400"
     				type="application/x-shockwave-flash"
     				pluginspage="http://www.macromedia.com/go/getflashplayer"></embed></object>
			</td></tr>
<?php
      }else{
        $busca_coor2 = mysql_query("SELECT c.ci_nome, m.coordenadas FROM muraski m INNER JOIN rebri_cidades c ON (m.local=c.ci_cod) WHERE m.coordenadas like 'http://maps%' AND m.cod='".$cod."' AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
		$numrowscoo2 = mysql_num_rows($busca_coor2);
        if($numrowscoo2 > 0){
?>           
			<tr><td colspan="4" align="center" class="style7">Coordenadas incorretas!<br>Verifique se seguiu as observações descritas abaixo na parte de editar imóveis no campo "Coordenadas".<br><span class="style1">* Entre no site <a href="http://maps.google.com.br" target="_blank">Google Maps</a> e digite o endere&ccedil;o completo, cidade, estado (Ex: rua teste, 10, curitiba, pr) e depois clicar em &quot;Link&quot; e copiar e colar o codigo HTML nesse campo.Veja <a href="images/exemplo.jpg" target="_blank">aqui</a> o exemplo. </span></td></tr>	
<?			
  	        
        }else{		       
?>
			<tr><td colspan="4" align="center" class="style1"><?php print("$not1[coordenadas]"); ?></td></tr>		
<?	    
		}	
	  }
	}else{
?>	  	  
<tr>
  	<td colspan="4" align="left" class="style48"><b>Mapa:</b></td>
</tr>
<tr><td colspan="4" align="center" class="style1">
<table><tr><td height="672"><div id="mapa">
<? //if($_SERVER['SERVER_NAME'] == "www.redebrasileiradeimoveis.com.br" OR $_SERVER['SERVER_NAME'] == "redebrasileiradeimoveis.com.br"){ ?>
  <iframe src="http://www.redebrasileiradeimoveis.com.br/sistema/mapa.php?ori=<?=$origem_mapa ?>&end=<?php echo ucwords(strtolower($endereco_mapa))."|".$not1[ref]."|".tirar_acentos($not1[t_nome])."|".$not1['bairro']."|".ucwords(strtolower($endereco_balao))."|".$not1['end_aproximado']."|".$not1['exibir_endereco']."|".$codi."|".$_SESSION['cod_imobiliaria']."|sistema";  ?>" allowtransparency="true" width="762" height="672" scrolling="no" frameborder="0" marginheight="0" marginwidth="0"></iframe>
  <? //}else{ ?>
<!--iframe src="http://201.15.46.77/intranet/sistema/mapa.php?end=<?php echo ucwords(strtolower($not1['tipo_logradouro']." ".$not1['end'].", ".$not1['numero']." - ".$not1['ci_nome'])).", ".$not1['e_uf']."|".$not1[ref]."|".$not1[t_nome];  ?>" allowtransparency="true" width="425" height="350" scrolling="no" frameborder="0" marginheight="0" marginwidth="0"></iframe-->  
  <? //} ?>
</div></td></tr></table>
</td></tr>	  
<?	  	  
	}
?>
<script language="javascript">
function valida()
{
  if (document.form1.dia.value == "")
  {
    alert("Por favor, digite o Dia de Entrada");
    document.form1.dia.focus();
    return (false);
  }
  if (document.form1.mes.value == "")
  {
    alert("Por favor, digite o Mês de Entrada");
    document.form1.mes.focus();
    return (false);
  }
  if (document.form1.ano.value == "")
  {
    alert("Por favor, digite o Ano de Entrada");
    document.form1.ano.focus();
    return (false);
  }
  if (document.form1.dia1.value == "")
  {
    alert("Por favor, digite o Dia de Saída");
    document.form1.dia1.focus();
    return (false);
  }
  if (document.form1.mes1.value == "")
  {
    alert("Por favor, digite o Mês de Saída");
    document.form1.mes1.focus();
    return (false);
  }
  if (document.form1.ano1.value == "")
  {
    alert("Por favor, digite o Ano de Saída");
    document.form1.ano1.focus();
    return (false);
  }
  
  var data1 = document.form1.ano.value + document.form1.mes.value + document.form1.dia.value;
  var data2 = document.form1.ano1.value + document.form1.mes1.value + document.form1.dia1.value;	
  if (data2 < data1) {
	alert("Data inicial deve ser menor que data final.");
	document.form1.dia.focus();
	return(false);
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
<?php
	$ano = date("Y");
?>
<!--tr><td colspan="4" align="center" class="style1">
<a href="javascript:history.back()" class="style1"><< Voltar <<</a>
</td></tr-->
<tr><td colspan=4 class="style1">
<a href="carrinho.php?cod=<?php print("$not1[cod]"); ?>&qtd=1" class="style1"><b>Separar Chaves</b></a><br>
</td></tr>
<?php

	//if($not1[finalidade] == "Locação"){
	if($not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14' || $not1[finalidade]=='15' || $not1[finalidade]=='16' || $not1[finalidade]=='17'){  
	  
		if($not1[finalidade]=='15' || $not1[finalidade]=='16' || $not1[finalidade]=='17'){
?>
			<form method="get" action="reserva.php" name="form1" onSubmit="return valida();">
<?		  		  
		}elseif($not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){
?>		  
			<form method="get" action="reserva_mes.php" name="form1" onSubmit="return valida();">
<?		  
		}  
?>
<tr><td colspan=4 class="style1">
<input type=hidden name=cod value=<?php print("$not1[cod]"); ?>>
<b>Reservar Imóvel</b></a><br>
</td></tr>
    <tr>
      <td class="style1"><b>Período:</b></td>
      <td colspan="3" class="style1">
      <? if($not1[finalidade]=='15' || $not1[finalidade]=='16' || $not1[finalidade]=='17'){ ?>
      	<input type="text" name="dia" id="dia" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes" id="mes" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano" id="ano" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"> <b>à</b> <input type="text" name="dia1" id="dia1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mes1" id="mes1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="ano1" id="ano1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>">
      <? }elseif($not1[finalidade]=='8' || $not1[finalidade]=='9' || $not1[finalidade]=='10' || $not1[finalidade]=='11' || $not1[finalidade]=='12' || $not1[finalidade]=='13' || $not1[finalidade]=='14'){ ?>
      	<input type="text" name="dial" id="dial" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mesl" id="mesl" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="anol" id="anol" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>"> <b>à</b> <input type="text" name="dial1" id="dial1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="mesl1" id="mesl1" size="2" class="campo" maxlenght="2" onKeyUp="return autoTab(this, 2, event);">/<input type="text" name="anol1" id="anol1" size="4" class="campo" maxlenght="4" onKeyUp="return autoTab(this, 4, event);" value="<?php print("$ano"); ?>">
      <? } ?>
   <input type="submit" class=campo3 value="Reservar" name="B1"></td>
    </tr>
</form>
<tr><td colspan=4 class="style1">
<?php
	$query3 = "select * from locacao where l_imovel='$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by l_data_ent";

	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	if($numrows3 > 0){
?>
<b>Ocupado nos seguintes períodos:</b><br>
<?php
	while($not3 = mysql_fetch_array($result3))
	{
	
	$ano = substr ($not3[l_data_ent], 0, 4);
	$mes = substr($not3[l_data_ent], 5, 2 );
	$dia = substr ($not3[l_data_ent], 8, 2 );
	$ano1 = substr ($not3[l_data_sai], 0, 4);
	$mes1 = substr($not3[l_data_sai], 5, 2 );	
	$dia1 = substr ($not3[l_data_sai], 8, 2 );
	$data_ent = "$dia/$mes/$ano";
	$data_sai = "$dia1/$mes1/$ano1";
	$data1 = mktime(0,0,0, $mes, $dia, $ano);
	$data2 = mktime(0,0,0, $mes1, $dia1, $ano1);
	$total_dias = floor(($data2 - $data1)/(24*60*60));


	## monta array com as datas da locacao
	#print "${"mes$mes"},$data_ent,$data_sai<br>";
        array_push (${"todasdatas"},$data_ent,$data_sai);


//<font size="2" face="Arial" color="#ff0000">
// print("$data_ent"); à print("$data_sai"); : print("$total_dias"); dias<br>

}
}
?>
<div align=center>
<table border="0">
<tr><td valign="top">
<?
	$col = 1;
	## mostra calendarios de 12 meses 
	for ($df = 1; $df <= 12; $df++) {
		if (strlen($nextmes) == 1) {
                	$nextmes = "0$nextmes";
		}
		if ($col > 3) {
			print "</td></tr><tr><td valign='top'>";
			$col = 1;
		} elseif ($col != 1) {
			print "</td><td valign='top'>";
		}
		### monta o calendario
		calendario(${"todasdatas"},"$nextmes/$nextano",$datapermitida,0);
		print "<br>";
		$nextmes++;
		if ($nextmes > 12) {
			$nextmes = 1;
			$nextano++;
		}
		$col++;
	}

?>
</td></tr>
</table>
</div></center>
</td></tr>
<?php
//mysql_free_result($result3);
	}
?>
<?php
	}
?>
<?php
//mysql_free_result($result1);
mysql_close($con);
?>
</table>
</div>
<? if($mostra<>'S'){ ?>
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
<? } ?>
</body>
</html>