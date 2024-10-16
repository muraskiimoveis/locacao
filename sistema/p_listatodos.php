<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("REL_IMOV");
?>
<html>
<head>
<?php
include("style.php");
?>
	<style media="print">
		.noprint { display: none }
	</style>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<div class=noprint>
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
</div>
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and
	(($u_tipo == "admin") or ($u_tipo == "func"))){
*/
?>
<?php
    if($finalidade=='7'){
	  $query_finalidade = " AND (m.finalidade='1' OR m.finalidade='2' OR m.finalidade='3' OR m.finalidade='4' OR m.finalidade='5' OR m.finalidade='6' OR m.finalidade='7')";
	}elseif($finalidade=='14' || $finalidade=='17'){
	  $query_finalidade = " AND (m.finalidade='8' OR m.finalidade='9' OR m.finalidade='10' OR m.finalidade='11' OR m.finalidade='12' OR m.finalidade='13' OR m.finalidade='14' OR m.finalidade='15' OR m.finalidade='16' OR m.finalidade='17')";
	}elseif($finalidade<>'%'){
	  $query_finalidade = "AND m.finalidade='".$finalidade."'";
	}else{
	  $query_finalidade = "AND m.finalidade like '%'";
	}

	if($lista == ""){
?>
<?php
	$dia = date(d);
	$mes = date(m);
	$ano = date(Y);
?>
<div align="center">
  <center>
  <form method="get" action="<?php print("$PHP_SELF"); ?>" name="form1">
  <table border="0" cellspacing="1" width="75%">
    <tr height="50">
      <td width="100%" colspan=2 class="style1"><p align="center"><b>Relatório de de imóveis p/ impressão</b></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Finalidade:</b></td>
      <td width="70%" class="style1"><select name="finalidade" class="campo">
          <option value="%">Todos</option>
          <?php
        $bfinalidade = mysql_query("select f_cod, f_nome FROM finalidade WHERE (f_cod!='1' AND f_cod!='8') ORDER BY f_cod ASC");
 		while($linha = mysql_fetch_array($bfinalidade)){
			if($linha[f_cod]==$_GET['finalidade']){
			   if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>');
			   }else{
			     echo('<option value="'.$linha[f_cod].'" SELECTED>'.$linha['f_nome'].'</option>');
			   }
			}else{
			  if($linha['f_cod']=='2' || $linha['f_cod']=='9' || $linha['f_cod']=='15'){
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'_'.$_SESSION['nome_imobiliaria'].'</option>');
			  }else{
			    echo('<option value="'.$linha[f_cod].'">'.$linha['f_nome'].'</option>');
			  }
			}
        }
 	    ?>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Campo de pesquisa:</b></font></td>
      <td width="70%" class="style1"><select name="campo" class="campo" onChange="form1.lista.value='';form1.submit();">
      <option value="m.ref" <? if($campo=='m.ref'){ echo "SELECTED"; } ?>>Referência</option>
      <option value="m.titulo" <? if($campo=='m.titulo'){ echo "SELECTED"; } ?>>Título</option>
      <option value="m.descricao" <? if($campo=='m.descricao'){ echo "SELECTED"; } ?>>Descrição</option>
      <option value="m.end" <? if($campo=='m.end'){ echo "SELECTED"; } ?>>Endereço do Imóvel</option>
      <option value="m.metragem" <? if($campo=='m.metragem'){ echo "SELECTED"; } ?>>Metragem</option>
      <option value="m.n_quartos" <? if($campo=='m.n_quartos'){ echo "SELECTED"; } ?>>N° de quartos</option>
      <option value="m.valor" <? if($campo=='m.valor'){ echo "SELECTED"; } ?>>Valor/Diária</option>
      <option value="m.limpeza" <? if($campo=='m.limpeza'){ echo "SELECTED"; } ?>>Taxa Administrativa</option>
      <option value="m.permuta_txt" <? if($campo=='m.permuta_txt'){ echo "SELECTED"; } ?>>Texto da Permuta</option>
      <option value="m.matricula" <? if($campo=='m.matricula'){ echo "SELECTED"; } ?>>Matrícula</option>
      <option value="m.averbacao" <? if($campo=='m.averbacao'){ echo "SELECTED"; } ?>>Averbação</option>
      <option value="m.angariador" <? if($campo=='m.angariador'){ echo "SELECTED"; } ?>>Angariador</option>
      <option value="m.zelador" <? if($campo=='m.zelador'){ echo "SELECTED"; } ?>>Zelador</option>
      </select></font></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b><? if($_GET['campo']=='m.end'){ echo("Endereço:"); }else{ echo("Palavra Chave:"); } ?></b></td>
      <td width="70%" class="style1">
      <? if($_GET['campo']=='m.end'){ ?>
	  	<select name="tipo_logradouro" id="tipo_logradouro" class="campo">
        <option value="">Selecione</option>
        <option value="Alameda" <? if($not2['tipo_logradouro']=='Alameda'){ echo "SELECTED"; } ?>>Alameda</option>
        <option value="Área" <? if($tipo_logradouro=='Área'){ echo "SELECTED"; } ?>>Área</option>
        <option value="Avenida" <? if($tipo_logradouro=='Avenida'){ echo "SELECTED"; } ?>>Avenida</option>
        <option value="Campo" <? if($tipo_logradouro=='Campo'){ echo "SELECTED"; } ?>>Campo</option>
        <option value="Chácara" <? if($tipo_logradouro=='Chácara'){ echo "SELECTED"; } ?>>Chácara</option>
        <option value="Colônia" <? if($tipo_logradouro=='Colônia'){ echo "SELECTED"; } ?>>Colônia</option>
        <option value="Condomínio" <? if($tipo_logradouro=='Condomínio'){ echo "SELECTED"; } ?>>Condomínio</option>
        <option value="Conjunto" <? if($tipo_logradouro=='Conjunto'){ echo "SELECTED"; } ?>>Conjunto</option>
        <option value="Distrito" <? if($tipo_logradouro=='Distrito'){ echo "SELECTED"; } ?>>Distrito</option>
        <option value="Esplanada" <? if($tipo_logradouro=='Esplanada'){ echo "SELECTED"; } ?>>Esplanada</option>
        <option value="Estação" <? if($tipo_logradouro=='Estação'){ echo "SELECTED"; } ?>>Estação</option>
        <option value="Estrada" <? if($tipo_logradouro=='Estrada'){ echo "SELECTED"; } ?>>Estrada</option>
        <option value="Favela" <? if($tipo_logradouro=='Favela'){ echo "SELECTED"; } ?>>Favela</option>
        <option value="Fazenda" <? if($tipo_logradouro=='Fazenda'){ echo "SELECTED"; } ?>>Fazenda</option>
        <option value="Feira" <? if($tipo_logradouro=='Feira'){ echo "SELECTED"; } ?>>Feira</option>
        <option value="Jardim" <? if($tipo_logradouro=='Jardim'){ echo "SELECTED"; } ?>>Jardim</option>
        <option value="Ladeira" <? if($tipo_logradouro=='Ladeira'){ echo "SELECTED"; } ?>>Ladeira</option>
        <option value="Lago" <? if($tipo_logradouro=='Lago'){ echo "SELECTED"; } ?>>Lago</option>
        <option value="Lagoa" <? if($tipo_logradouro=='Lagoa'){ echo "SELECTED"; } ?>>Lagoa</option>
        <option value="Largo" <? if($tipo_logradouro=='Largo'){ echo "SELECTED"; } ?>>Largo</option>
        <option value="Loteamento" <? if($tipo_logradouro=='Loteamento'){ echo "SELECTED"; } ?>>Loteamento</option>
        <option value="Morro" <? if($tipo_logradouro=='Morro'){ echo "SELECTED"; } ?>>Morro</option>
        <option value="Núcleo" <? if($tipo_logradouro=='Núcleo'){ echo "SELECTED"; } ?>>Núcleo</option>
        <option value="Parque" <? if($tipo_logradouro=='Parque'){ echo "SELECTED"; } ?>>Parque</option>
        <option value="Passarela" <? if($tipo_logradouro=='Passarela'){ echo "SELECTED"; } ?>>Passarela</option>
        <option value="Pátio" <? if($tipo_logradouro=='Pátio'){ echo "SELECTED"; } ?>>Pátio</option>
        <option value="Praça" <? if($tipo_logradouro=='Praça'){ echo "SELECTED"; } ?>>Praça</option>
        <option value="Quadra" <? if($tipo_logradouro=='Quadra'){ echo "SELECTED"; } ?>>Quadra</option>
        <option value="Recanto" <? if($tipo_logradouro=='Recanto'){ echo "SELECTED"; } ?>>Recanto</option>
        <option value="Residencial" <? if($tipo_logradouro=='Residencial'){ echo "SELECTED"; } ?>>Residencial</option>
        <option value="Rodovia" <? if($tipo_logradouro=='Rodovia'){ echo "SELECTED"; } ?>>Rodovia</option>
        <option value="Rua" <? if($tipo_logradouro=='Rua'){ echo "SELECTED"; } ?>>Rua</option>
        <option value="Setor" <? if($tipo_logradouro=='Setor'){ echo "SELECTED"; } ?>>Setor</option>
        <option value="Sítio" <? if($tipo_logradouro=='Sítio'){ echo "SELECTED"; } ?>>Sítio</option>
        <option value="Travessa" <? if($tipo_logradouro=='Travessa'){ echo "SELECTED"; } ?>>Travessa</option>
        <option value="Trecho" <? if($tipo_logradouro=='Trecho'){ echo "SELECTED"; } ?>>Trecho</option>
        <option value="Trevo" <? if($tipo_logradouro=='Trevo'){ echo "SELECTED"; } ?>>Trevo</option>
        <option value="Vale" <? if($tipo_logradouro=='Vale'){ echo "SELECTED"; } ?>>Vale</option>
        <option value="Vereda" <? if($tipo_logradouro=='Vereda'){ echo "SELECTED"; } ?>>Vereda</option>
        <option value="Via" <? if($tipo_logradouro=='Via'){ echo "SELECTED"; } ?>>Via</option>
        <option value="Viaduto" <? if($tipo_logradouro=='Viaduto'){ echo "SELECTED"; } ?>>Viaduto</option>
        <option value="Viela" <? if($tipo_logradouro=='Viela'){ echo "SELECTED"; } ?>>Viela</option>
        <option value="Vila" <? if($tipo_logradouro=='Vila'){ echo "SELECTED"; } ?>>Vila</option>
      </select> <input type="text" class="campo" name="chave" size="30"> N&deg;:
      <input type="text" name="numero_end" id="numero_end" size="5" class="campo" value="<?=$numero_end; ?>">
	  <? }else{ ?>
		<input type="text" class="campo" name="chave" size="30">
      <? } ?>
	  </td>
    </tr>
    <tr>
      <td width="100%" colspan="2">
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="1" name="lista">
      <input type="submit" value="Pesquisar" name="B1" class="campo3"></td>
    </tr>
  </table>
  </form>
<?php
	}
	else
	{

	if($chave == ""){
	$query1 = "select m.ref, t.t_nome, m.valor, m.tipo_logradouro, m.end, m.numero, m.finalidade from muraski m inner join rebri_tipo t on (m.tipo=t.t_cod) where m.ref not like 'x' $query_finalidade AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by m.finalidade, m.ref";
	}
	else
	{

	if($campo=='m.end'){
	   $busca = "m.tipo_logradouro like '%$tipo_logradouro%' AND m.end like '%$end%' AND m.numero LIKE '%$numero_end%'";
	}else{
	   $busca = "$campo like '%$chave%'";
	}


	$query1 = "select m.ref, t.t_nome, m.valor, m.tipo_logradouro, m.end, m.numero, m.finalidade from muraski m inner join rebri_tipo t on (m.tipo=t.t_cod) where
	$busca and m.ref not like 'x' $query_finalidade AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by m.finalidade, m.ref";
	}
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
?>
<div align="center">
  <center>
                  <table width="75%">
                  <tr height="50"><td colspan="5" class="style1">
                  <p align="center"><b>Estes são todos os imóveis cadastrados até o momento</b></p></td></tr>
<tr class="fundoTabelaTitulo">
<td valign=top class="style1">
<b>Ref.</b></td>
<td valign=top class="style1">
<b>Finalidade</td>
<td valign=top class="style1">
<b>Tipo</td>
<td valign=top class="style1">
<b>Endereço</td>
<td valign=top width=90 class="style1">
<b>Valor</td>
</tr>
<?php
	$i = 0;

	while($not = mysql_fetch_array($result1))
	{

	$not[valor] = number_format($not[valor], 2, ',', '.');

	if (($i % 2) == 1){ $fundo='fundoTabelaCor1'; }else{ $fundo='fundoTabelaCor2'; }
	$i++;
?>
<?
if($not[finalidade]=='1'){
  $fin = "Venda_Rebri";
}elseif($not[finalidade]=='2'){
  $fin = "Venda_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='3'){
  $fin = "Venda_Parceria";
}elseif($not[finalidade]=='4'){
  $fin = "Venda_Terceiros";
}elseif($not[finalidade]=='5'){
  $fin = "Venda_Off";
}elseif($not[finalidade]=='6'){
  $fin = "Venda_Vendido";
}elseif($not[finalidade]=='7'){
  $fin = "Venda_Todos";
}elseif($not[finalidade]=='8'){
  $fin = "Locação_Anual_Rebri";
}elseif($not[finalidade]=='9'){
  $fin = "Locação_Anual_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='10'){
  $fin = "Locação_Anual_Parceria";
}elseif($not[finalidade]=='11'){
  $fin = "Locação_Anual_Terceiros";
}elseif($not[finalidade]=='12'){
  $fin = "Locação_Anual_Off";
}elseif($not[finalidade]=='13'){
  $fin = "Locação_Anual_Locado";
}elseif($not[finalidade]=='14'){
  $fin = "Locação_Anual_Todos";
}elseif($not[finalidade]=='15'){
  $fin = "Locação_Temporada_".$_SESSION['nome_imobiliaria'];
}elseif($not[finalidade]=='16'){
  $fin = "Locação_Temporada_Off";
}elseif($not[finalidade]=='17'){
  $fin = "Locação_Temporada_Todos";
}
?>
<tr class="<?php print("$fundo"); ?>">
<td valign=top class="style1">
<b><?php print("$not[ref]"); ?></b></td>
<td valign=top class="style1">
<?php print($fin); ?></td>
<td valign=top class="style1">
<?php print("$not[t_nome]"); ?></td>
<td valign=top class="style1">
<?php print("$not[tipo_logradouro]"); ?> <?php print("$not[end]"); ?>, <?php print("$not[numero]"); ?></td>
<td valign=top class="style1">
R$
<?php print("$not[valor]"); ?></td>
</tr>
<?php
	}

	if($chave == ""){
	$query3 = "select count(m.cod) as q_cod
	from muraski m inner join rebri_tipo t on (m.tipo=t.t_cod) where m.ref not like 'x' $query_finalidade AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}
	else
	{

	if($campo=='m.end'){
	   $busca = "m.tipo_logradouro like '%$tipo_logradouro%' AND m.end like '%$end%' AND m.numero LIKE '%$numero_end%'";
	}else{
	   $busca = "$campo like '%$chave%'";
	}

	$query3 = "select count(m.cod) as q_cod
	from muraski m inner join rebri_tipo t on (m.tipo=t.t_cod) where $busca and
	m.ref not like 'x' $query_finalidade AND m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	}
	$result3 = mysql_query($query3);

	while($not3 = mysql_fetch_array($result3))
	{
?>
                  <tr><td colspan="5" class="fundoTabelaTitulo style1">
                  <p align="center">
                  Total de <b><?php print("$not3[q_cod]"); ?></b> imóveis.</td></tr>
	</table>
	</center>
	</div>
<?php
	}
	}
//mysql_free_result($result1);
//mysql_free_result($result2);
//mysql_free_result($result3);
mysql_close($con);
?>
	<div class=noprint>
	<tr>
	  <td colspan="2"><div align="center"><span class="style1">
	    <br><br><input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()"><br><br>
		</form>
	  </span></div></td>
    </tr>
</div>
<?
	}
?>

<?php
/*
	}
	else
	{
*/
?>
<?php
//include("login2.php");
?>
<?php
//	}
?>
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