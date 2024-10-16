<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {color: #FF0000}
-->
</style>
<?
include("conect.php");
$busca_mensagem = mysql_query("SELECT * FROM mensagens me 
LEFT JOIN usuarios u ON (me.me_cod_user_recebe=u.u_cod) 
LEFT JOIN usuarios ue ON (me.me_cod_user_envia=ue.u_cod) 
WHERE u.u_status='Ativo' and ue.u_status='Ativo' and me.me_status='0' and me.me_cod_user_recebe = '".$_SESSION['u_cod']."'") or die ("Erro em buscar".mysql_error());
$contador = mysql_num_rows($busca_mensagem);
if($contador > 0){
  $msgi = '<img src="images/icone_mensagens_novas.gif" width="32" height="32" border="0" />';
  $msg = '<span class="style4"><strong>Mensagens</strong></span></a><span class="style4"> ('.$contador.')</span>';
}else{
  $msgi = '<img src="images/icone_mensagens.jpg" width="32" height="32" border="0" />';
  $msg = '<strong>Mensagens</strong></a> ('.$contador.')';
}

?>
<table width="750" height="435" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" background="images/logo_rebri_home.jpg"><table width="55%" height="400" border="0" cellpadding="0" cellspacing="10">
      <tr>
        <td align="right"><table width="350" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="34" align="left"><a href="p_mensagens.php" class="style1"><?=$msgi; ?></a></td>
            <td align="left" class="style1"><a href="p_mensagens.php" class="style1"><?=$msg; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right"><table width="315" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="34" align="left"><a href="p_pesq_ven.php" class="style1"><img src="images/icones/pesquisar_imovel_venda.jpg" width="34" height="34" border="0" /></a></td>
            <td align="left" class="style1"><a href="p_pesq_ven.php" class="style1"><strong>Pesquisar Im&oacute;veis para Venda</strong></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right"><table width="295" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="34" align="left"><a href="p_pesq_loc.php" class="style1"><img src="images/icones/pesquisar_imovel_loc_dia.jpg" width="34" height="34" border="0" /></a></td>
            <td align="left" class="style1"><a href="p_pesq_loc.php" class="style1"><strong>Pesquisar Im&oacute;veis <!--para-->p/ Loca&ccedil;&atilde;o <!--Di&aacute;ria-->Temporada</strong></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right"><table width="275" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="34" align="left"><a href="p_pesq_loc_mes.php" class="style1"><img src="images/icones/locacao_mensal.jpg" width="34" height="34" border="0" /></a></td>
            <td align="left" class="style1"><a href="p_pesq_loc_mes.php" class="style1"><strong>Pesquisar Im&oacute;veis para Loca&ccedil;&atilde;o <!--Mensal-->Anual </strong></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right"><table width="275" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="34" align="left"><a href="p_pesq_clientes.php" class="style1"><img src="images/icones/pesquisar_clientes.jpg" width="34" height="34" border="0" /></a></td>
            <td align="left" class="style1"><a href="p_pesq_clientes.php" class="style1"><strong>Pesquisar Cadastros ou Atendimentos</strong></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right"><table width="295" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="34" align="left"><a href="p_insert_int.php" class="style1"><img src="images/icones/atendimento.jpg" width="34" height="34" border="0" /></a></td>
            <td align="left" class="style1"><a href="p_insert_int.php" class="style1"><strong>Inserir Atendimento</strong></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right"><table width="315" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="34" align="left"><a href="p_insert_clientes.php" class="style1"><img src="images/icones/adicionar_clientes.jpg" width="34" height="34" border="0" /></a></td>
            <td align="left" class="style1"><a href="p_insert_clientes.php" class="style1"><strong>Inserir Cadastro</strong></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right"><table width="350" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="34" align="left"><a href="p_insert_imoveis.php" class="style1"><img src="images/icones/adiconar_imovel.jpg" width="34" height="34" border="0" /></a></td>
            <td align="left" class="style1"><a href="p_insert_imoveis.php" class="style1"><strong>Inserir Im&oacute;veis</strong></a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
      <tr>
        <td align="right"><table width="700" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td align="center" class="style1"><br />
	           <a href="p_modelo_logo.php" class="style1"><strong>Coloque a logo da REBRI em seu site clicando aqui.</strong></a></td>
            <td align="left" class="style1"><br />
             <a href="javascript:void(window.open('simu.html','Simuladores','scrollbars=no,top=240,left=240,height=180,width=600'))" target="_self" class="style1"><strong>Simuladores de Financiamento.</strong></a></td>
          </tr>
        </table></td>
      </tr>
</table>
