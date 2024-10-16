<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
verificaAcesso();
verificaArea("IMOV_PESQ");

#$_SESSION[im_site_padrao] => S;

?>
<html>
<head>
<?php
include("style.php");
?>
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
<?php
/*
	if((session_is_registered("valid_user")) and (session_is_registered("u_tipo")) and
	(($_SESSION['u_tipo'] == "admin") or ($_SESSION['u_tipo'] == "func"))){
*/
?>
<div align="center">
  <center>
  <form method="get" name="form1" action="p_lista_edit.php">
  <table border="0" cellspacing="1" width="75%">
    <tr>
      <td height="50" width="100%" colspan=2 class="style1"><p align="center"><b>Imóveis</b><br>
 Preencha a Palavra chave e selecione o campo de pesquisa.</p></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Campo de pesquisa:</b></td>
      <td width="70%" class="style1"><select name="campo" class="campo" onChange="form1.action='p_pesq_imoveis.php';form1.submit();">
	  <option value="ref" <? if($campo=='ref'){ echo "SELECTED"; } ?>>Referência</option>
	  <option value="controle_chave" <? if($campo=='controle_chave'){ echo "SELECTED"; } ?>>Controle da Chave</option>
      <option value="data_fim" <? if($campo=='data_fim'){ echo "SELECTED"; } ?>>Data Término do Contrato</option>
	  <option value="dataf_renova" <? if($campo=='dataf_renova'){ echo "SELECTED"; } ?>>Data Término da Renovação</option>
      <option value="titulo" <? if($campo=='titulo'){ echo "SELECTED"; } ?>>Título</option>
      <option value="descricao" <? if($campo=='descricao'){ echo "SELECTED"; } ?>>Descrição</option>
      <option value="end" <? if($campo=='end'){ echo "SELECTED"; } ?>>Endereço do Imóvel</option>
      <option value="metragem" <? if($campo=='metragem'){ echo "SELECTED"; } ?>>Metragem</option>
      <option value="n_quartos" <? if($campo=='n_quartos'){ echo "SELECTED"; } ?>>N° de quartos</option>
      <option value="valor" <? if($campo=='valor'){ echo "SELECTED"; } ?>>Valor/Diária</option>
      <option value="limpeza" <? if($campo=='limpeza'){ echo "SELECTED"; } ?>>Taxa Administrativa</option>
      <option value="permuta_txt" <? if($campo=='permuta_txt'){ echo "SELECTED"; } ?>>Texto da Permuta</option>
      <option value="matricula" <? if($campo=='matricula'){ echo "SELECTED"; } ?>>Matrícula</option>
      <option value="averbacao" <? if($campo=='averbacao'){ echo "SELECTED"; } ?>>Averbação</option>
<?php
      if (verificaFuncao("USER_ACESSA_PROPRIETARIO") == false) {
?>
      <option value="angariador" <? if($campo=='angariador'){ echo "SELECTED"; } ?>>Angariador</option>
<? } ?>
      <option value="zelador" <? if($campo=='zelador'){ echo "SELECTED"; } ?>>Zelador</option>
      </select></td>
    </tr>
   <tr class="fundoTabela">
      <td width="30%" class="style1"><b><? if($_GET['campo']=='end'){ echo("Endereço:"); }else{ echo("Palavra Chave:"); } ?></b></td>
      <td width="70%" class="style1">
      <? if($_GET['campo']=='end'){ ?>
	  	<select name="tipo_logradouro" id="tipo_logradouro" class="campo">
        <option value="">Selecione</option>
        <option value="Alameda" <? if($tipo_logradouro=='Alameda'){ echo "SELECTED"; } ?>>Alameda</option>
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
    <tr class="fundoTabela">
      <td class=style1><b>Tipo de im&oacute;vel:</b></td>
      <td class=style1><select name="tipo1" class="campo">
          <option selected value="%" <? if($tipo1=='%'){ echo "SELECTED"; }?>>Todos</option>
          <?
    		$btipo = mysql_query("SELECT t_cod, t_nome FROM rebri_tipo ORDER BY t_nome ASC");
 			while($linha = mysql_fetch_array($btipo)){
				if($linha[t_cod]==$tipo1){
 		     		echo('<option value="'.$linha[t_cod].'" SELECTED>'.$linha['t_nome'].'</option>');
		   		}else{
		     		echo('<option value="'.$linha[t_cod].'">'.$linha['t_nome'].'</option>');
		   		}
			}
		?>
      </select></td>
    </tr>
    <tr class="fundoTabela">
      <td width="30%" class="style1"><b>Finalidade:</b></font></td>
      <td width="70%" class="style1"><select name="finalidade" class="campo">
        <option value="%">Todos</option>
          <?php
        $bfinalidade = mysql_query("SELECT f_cod, f_nome FROM finalidade WHERE f_cod!='1' AND f_cod!='8' AND f_cod!='7' AND f_cod!='14' AND f_cod!='17' ORDER BY f_cod ASC");
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
      <td width="30%" class="style1"><b>Angariador:</b></td>
      <td width="70%" class="style1">

<!-- INICIO -->
<?php
      if (verificaFuncao("USER_ACESSA_PROPRIETARIO")) {
?>
      <select name="angariador" class=campo>
<!--      <option selected value="%">..</option> -->
<?php
      $qry0 = mysql_query("SELECT u_cod, u_email FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and  u_cod ='".$_SESSION['u_cod']."'");
      while($lin = mysql_fetch_array($qry0)){
			echo('<option value="'.$lin[u_cod].'">'.$lin[u_email].'</option>');
 	  }

     } else { ?>
<!-- FIM -->
      <select name="angariador" class=campo>
      <option selected value="%">Todos</option>
<?php
	$query0 = mysql_query("SELECT u.u_cod, u.u_email FROM usuarios u INNER JOIN muraski m ON (m.angariador=u.u_cod) WHERE u.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' GROUP BY m.angariador ORDER BY u.u_email ASC");
 	while($linha = mysql_fetch_array($query0)){
			echo('<option value="'.$linha[u_cod].'">'.$linha[u_email].'</option>');
 	}
  }
?>
      </select>
      <select name="tipo_anga" class="campo">
      <option selected value="%">Todos</option>
    <?
    $comissoesa = mysql_query("SELECT comissao_angariador FROM rebri_imobiliarias WHERE im_cod='".$_SESSION['cod_imobiliaria']."'");
 	while($linha = mysql_fetch_array($comissoesa)){
			echo('<option value="'.$linha[comissao_angariador].'">'.$linha[comissao_angariador].' %</option>');
 	}
    ?>
        </select></td>
    </tr>
    <tr>
      <td width="100%" colspan=2>
      <input type="hidden" value="1" name="list">
      <input type="hidden" value="" name="lista">
      <input type="submit" value="Pesquisar Imóvel" name="B1" class=campo3></td>
    </tr>
    <tr>
      <td width="100%" colspan=2 class="style1">
      Lembre-se de seguir os seguintes padrões nas pesquisas:<br>
      <b>- Data Término do Contrato e Data Término da Renovação:</b><br>
      Exemplo: 10/10/2002<br>
      <b>- Valor, Metragem, Averbação:</b><br>
      Exemplo: 100.00 ou 1000<br>
      <b>- Outros campos é só digitar um texto qualquer.</b></td>
    </tr>
  </table>
  </form>
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
