<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="anylink.css" />
<script type="text/javascript" src="anylink.js"></script>
<script language="JavaScript">
function confirmar()
{
var agree=confirm("Voc� quer exportar todos os dados para o Site? Isso pode levar alguns minutos.\nEspere a p�gina terminar de carregar para n�o causar problemas no sistema.\nClique OK para confirmar ou Cancel para voltar.");
if (agree)
top.location.href("p_exporta.php");
else
history.go(0);
}
</script>

<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="3">
  <tr align="center" valign="middle">
    <td width="180" class="fundoBotao"><table width="100%" border="0" cellpadding="3" cellspacing="1">
        <tr>
          <td align="center" class="botaoMenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, 'anylinkmenu1')"><span class="style1"><a href="#" class="style1"><strong>CADASTROS</strong></a></span></td>
        </tr>
		 <div id="anylinkmenu1" class="anylinkcss1">
<? //if($_SESSION['u_tipo'] == "admin" || $_SESSION['u_tipo'] == "func"){ ?>
            <div align="left"><a href="p_insert_clientes.php" class="style1">Inserir Cadastro</a></div>
   			<div align="left"><a href="p_insert_int.php" class="style1">Inserir Atendimento</a></div>
			<div align="left"><a href="p_pesq_clientes.php" class="style1">Pesquisar Cadastros ou Atendimentos</a></div>
			<div align="left"><a href="p_clientes.php" class="style1">Rela��o de Cadastros</a></div>
			<div align="left"><a href="p_int.php" class="style1">Rela��o de Atendimentos</a></div>
			<?
             if($_SERVER['SERVER_NAME'] <> "www.redebrasileiradeimoveis.com.br" AND $_SERVER['SERVER_NAME'] <> "redebrasileiradeimoveis.com.br"){
                if (($_SESSION['cod_imobiliaria'] == 3) and (verificaFuncao("GERAL_MAILLING"))) {
            ?>
			<div align="left"><a href="p_mailing.php" class="style1">Enviar Mailling</a></div>
			<?
                }
              }
             ?>
<? //} ?>
		</div>
    </table></td>
    <td width="180" class="fundoBotao"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td align="center" class="botaoMenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, 'anylinkmenu2')"><span class="style1"><a href="#" class="style1"><strong>IM&Oacute;VEIS</strong></a></span></td>
      </tr>
	  	<div id="anylinkmenu2" class="anylinkcss2">
<? //if($_SESSION['u_tipo'] == "admin" || $_SESSION['u_tipo'] == "func"){ ?>
			<div align="left"><a href="p_insert_imoveis.php" class="style1">Inserir Im�veis</a></div>
			<div align="left"><a href="p_envia_img.php" class="style1">Enviar Imagens</a></div>
			<div align="left"><a href="p_pesq_imoveis.php" class="style1">Pesquisar Im�veis</a></div>
			<div align="left"><a href="carrinho_imoveis.php" class="style1">Lista de Im�veis</a></div>
			<div align="left"><a href="p_rel_avaliacao.php?menu=avaliacao" class="style1">Amostragem para Avalia��o</a></div>
<? //} ?>
<?// if($_SESSION['u_tipo'] == "admin"){ ?>
			<!--div align="left"><a href="p_bairros.php" class="style1">Rela��o de Bairros</a><div>
			<div align="left"><a href="p_caracteristicas.php" class="style1">Rela��o de Caracter�sticas</a><div-->
<?// } ?>
<? //if($_SESSION['u_tipo'] == "admin" || $_SESSION['u_tipo'] == "func"){ ?>
			<!--div align="left"><a href="p_imoveis.php" class="style1">Rela��o de Im�veis</a><div-->
			<div align="left"><a href="p_listatodos.php" class="style1">Rela��o de Im�veis p/ Imprimir</a></div>
			<div align="left"><a href="p_ref.php" class="style1">Rela��o de Refer�ncias</a></div>
<? //} ?>
		</div>
    </table></td>
    <td width="180" class="fundoBotao"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td align="center" class="botaoMenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, 'anylinkmenu6')"><span class="style1"><a href="#" class="style1"><strong>VENDAS</strong></a></span></td>
      </tr>
        <div id="anylinkmenu6" class="anylinkcss6">
<? //if($_SESSION['u_tipo'] == "admin" || $_SESSION['u_tipo'] == "func"){ ?>
			<div align="left"><a href="p_pesq_ven.php" class="style1">Pesquisar Im�veis</a></div>
			<div align="left"><a href="p_rel_vendas.php" class="style1">Relat�rio de Vendas</a></div>
			<!--div align="left"><a href="relacao_vendidos.php" class="style1">Im�veis Vendidos</a><div-->
<? //} ?>
		</div>
    </table></td>
    <td width="300" class="fundoBotao"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td align="center" class="botaoMenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, 'anylinkmenu7')"><span class="style1"><a href="#" class="style1"><strong><!--LOCA&Ccedil;&Otilde;ES DI�RIAS-->LOCA��O TEMPORADA</strong></a></span></td>
      </tr>
      	  <div id="anylinkmenu7" class="anylinkcss7">
<? //if($_SESSION['u_tipo'] == "admin" || $_SESSION['u_tipo'] == "func"){ ?>
			<div align="left"><a href="p_pesq_loc.php" class="style1">Pesquisar Im�veis</a></div>
<? //			<div align="left"><a href="p_insert_clientes.php?c_tipo=prestador" class="style1">Inserir Prestadores</a><div> ?>
			<div align="left"><a href="p_pesq_rel.php" class="style1">Relat�rio de Loca��es</a></div>
			<div align="left"><a href="p_rel_entradas.php" class="style1">Relat�rio de Entradas</a></div>
			<div align="left"><a href="p_rel_saidas.php" class="style1">Relat�rio de Sa�das</a></div>
<? //} ?>
<? //if($_SESSION['u_tipo'] == "admin"){ ?>
			<div align="left"><a href="p_rel_depositos.php" class="style1">Rela��o de Dep�sitos</a></div>
			<div align="left"><a href="p_rel_boletos_conciliados.php" class="style1">Boletos Conciliados CEF</a></div>
                                       <div align="left"><a href="p_rel_boletos_provisionados.php" class="style1">Boletos Provisao CEF</a></div>

<? //} ?>
            <div align="left"><a href="p_concilia_retornocef.php" class="style1">Concilia Cobran�a CEF</a></div>
		</div>
    </table></td>
    <td width="280" class="fundoBotao"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td align="center" class="botaoMenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, 'anylinkmenu8')"><span class="style1"><a href="#" class="style1"><strong><!--LOCA&Ccedil;&Otilde;ES MENSAIS-->LOCA��O ANUAL</strong></a></span></td>
      </tr>
      	  <div id="anylinkmenu8" class="anylinkcss8">
<? //if($_SESSION['u_tipo'] == "admin" || $_SESSION['u_tipo'] == "func"){ ?>
			<div align="left"><a href="p_pesq_loc_mes.php" class="style1">Pesquisar Im�veis</a></div>
			<div align="left"><a href="relatorio_cobrancas.php" class="style1">Relat�rio de Cobran�as</a></div>
			<div align="left"><a href="p_pesq_rel_mes.php" class="style1">Relat�rio de Loca��es Anuais<!--Mensais--></a></div>
<? //} ?>
		</div>
    </table></td>
    <td width="180" class="fundoBotao"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td align="center" class="botaoMenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, 'anylinkmenu3')"><span class="style1"><a href="#" class="style1"><strong>RELAT&Oacute;RIOS</strong></a></span></td>
      </tr>
	  <div id="anylinkmenu3" class="anylinkcss3">
<? //if($_SESSION['u_tipo'] == "admin"){ ?>
			<div align="left"><a href="p_rel_aniversarios.php" class="style1">Relat�rio de Aniversariantes</a></div>
			<div align="left"><a href="p_rel_anuncios.php" class="style1">Relat�rio de An�ncios</a></div>
			<div align="left"><a href="p_rel_contratos.php" class="style1">Relat�rio de Op��es</a></div>
			<div align="left"><a href="p_rel_prestadores.php" class="style1">Relat�rio de Prestadores</a></div>
			<div align="left"><a href="p_rel_contas_pagar.php" class="style1">Relat�rio de Contas a Pagar</a></div>
			<div align="left"><a href="p_rel_contas_receber.php" class="style1">Relat�rio de Contas a Receber</a></div>
			<div align="left"><a href="p_rel_bens_data.php" class="style1">Relat�rio de Bens por Periodo</a></div>
			<div align="left"><a href="p_rel_servicos.php" class="style1">Relat�rio de Servi�os</a></div>
<? //} ?>
		</div>
    </table></td>
    <td width="180" class="fundoBotao"><table width="100%" border="0" cellpadding="3" cellspacing="1">
        <tr>
          <td align="center" class="botaoMenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, 'anylinkmenu4')"><span class="style1"><a href="#" class="style1"><strong>ADMINISTRA&Ccedil;&Atilde;O</strong></a></span></td>
        </tr>
		<div id="anylinkmenu4" class="anylinkcss4">
<? //if($_SESSION['u_tipo'] == "admin"){ ?>
			<div align="left"><a href="cadastro_feriados.php" class="style1">Inserir Feriados</a></div>
			<div align="left"><a href="p_imobiliarias.php" class="style1">Dados Imobili�ria</a></div>
			<div align="left"><a href="cadastro_comercio.php" class="style1">Cadastro Com�rcio</a></div>
			<div align="left"><a href="cadastro_anuncios2.php" class="style1">Exporta��es</a></div>
<? if ((($_SESSION['im_site_padrao'] == 'S') and (verificaFuncao("GERAL_BANNER"))) || ($_SERVER['REMOTE_ADDR'] == "201.22.15.53" || $_SERVER['REMOTE_ADDR'] == "192.168.0.5")) { ?>
			<div align="left"><a href="p_insert_banner.php" class="style1">Banner no Site</a></div>
<? } ?>
<? if (($_SESSION['cod_imobiliaria'] == 3) and (verificaFuncao("GERAL_SINCRONIZAR"))) { ?>
<!--			<div align="left"><a href="p_importacao.php?imob=muraski" class="style1">Atualizar Site Muraski</a></div> -->
			<div align="left"><a href="p_importacao.php" class="style1">Atualizar Sites WebDivulgador</a></div> 
			
			<div align="left"><a href="p_importa_vision.php" class="style1">Atualizar Site Muraski em WEBLINK</a></div> 
<!--
			<div align="left"><a href="index.php" class="style1">Atualizar Sites WebDivulgador</a></div> 
			<div align="left"><a href="index.php" class="style1">Atualizar Site Muraski em WEBLINK</a></div> 
-->
<? } ?>
			<!--div align="left"><a href="p_doc.php" class="style1">Visualizar documentos</a><div-->
			<!--div align="left"><a href="javascript:confirmar();" class="style1">Exportar p/ Internet</a><div-->
<? //} ?>
		</div>
    </table></td>
    <td width="180" class="fundoBotao"><table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td align="center" class="botaoMenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, 'anylinkmenu5')"><span class="style1"><a href="#" class="style1"><strong>USU&Aacute;RIOS</strong></a></span></td>
      </tr>
	  	  <div id="anylinkmenu5" class="anylinkcss5">
<? //if($_SESSION['u_tipo'] == "admin"){ ?>
	  	    <div align="left"><a href="p_insert_usuario.php" class="style1">Inserir Usu�rios</a></div>
	  	    <!--div align="left"><a href="cadastro_computadores.php" class="style1">Computadores</a><div-->
			<div align="left"><a href="p_usuarios.php" class="style1">Visualizar usu�rios</a></div>
			<div align="left"><a href="p_atendentes.php" class="style1">Atendentes</a></div>
<? //} ?>
<? //if($_SESSION['u_tipo'] == "admin" || $_SESSION['u_tipo'] == "func"){ ?>
			<div align="left"><a href="p_pesq_mensagens.php" class="style1">Enviar mensagem</a></div>
			<div align="left"><a href="p_mensagens.php" class="style1">Ver mensagens</a></div>
			<div align="left"><a href="http://192.168.10.145/intranet/calendario.php" target="_blank" class="style1">Ver Calendario</a></div>
<? //} ?>
		</div>
    </table></td>
  </tr>
</table>
