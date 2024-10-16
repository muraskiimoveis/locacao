<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("l_funcoes.php");
include("funcoes/funcoes.php");
verificaAcesso();
verificaArea("DOCS");

if($_POST['pdf']=='1'){
  

$imp = $_GET['imp'];
$cod = $_GET['cod'];
$l_cod = $_GET['l_cod'];
$impressao2 = $_POST['impressao2'];

if($imp=='2'){
  $nomec = "contrato_intermediacao_locacao_temporada";
}elseif($imp=='4'){
  $nomec = "carta_renovacao";
}elseif($imp=='5'){
  $nomec = "venda_imoveis";
}elseif($imp=='6'){
  $nomec = "laudo_avaliacao";
}elseif($imp=='7'){
  $nomec = "proposta_compra_imovel";
}elseif($imp=='9'){
  $nomec = "contrato_locacao";
}elseif($imp=='10'){
  $nomec = "contrato_locacao_mensal";
}elseif($imp=='8'){
  $nomec = "recibo_sinal_negocio";
}

$data_hora10 = date("d_m_Y_H_i_s");
$arquivo10 = $nomec."_".$data_hora10.".doc";

header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: application/msword; name=$arquivo10");
header ( "Content-Disposition: attachment; filename=$arquivo10"); 
header ( "Content-Description: MID Gera Doc" );


	if($imp == "2"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	$cod_cliente2 = " (";
	for($i3 = 1; $i3 <= $contador; $i3++){
	    if($i3==1){  
			$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
		}else{
		  	$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
		}
	} 
	$cod_cliente2 .= ")"; 
	
	$query2 = "select * from muraski, clientes, rebri_cidades where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and muraski.local=rebri_cidades.ci_cod and $cod_cliente2";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-rg-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-tel-", "<b>$not2[c_tel]</b>", $d_txt);
	$d_txt = str_replace("-cid_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);

	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );

	$d_txt = str_replace("-data_inicio-", "<b>$dia/$mes/$ano</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$dia1/$mes1/$ano1</b>", $d_txt);
	
	$diaria1 = number_format($not2[diaria1], 2, ',', '.');
	$diaria2 = number_format($not2[diaria2], 2, ',', '.');
	$comissao = number_format($not2[comissao], 2, ',', '.');
	
	$d_txt = str_replace("-diaria1-", "<b>$diaria1</b>", $d_txt);
	$d_txt = str_replace("-diaria2-", "<b>$diaria2</b>", $d_txt);
	$d_txt = str_replace("-comissao-", "<b>$not2[comissao]</b>", $d_txt);
	$d_txt = str_replace("-conta-", "<b>$not2[c_conta]</b>", $d_txt);

	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
   $num_rows = mysql_num_rows($busca);
   if ($num_rows > 0) {
	   while ($linha = mysql_fetch_array($busca)) {
      $d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
      $d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);
      $d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);
      $d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);
      $d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);
      $d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);
      $d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);
      $d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);
      $d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);
      $d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);
      $d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);

     	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
     	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
     	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	   }
   }

$dia2 = date("d");
$mes2 = date("m");
$ano2 = date("Y");

$html10 .='<table border="0" cellspacing="1" width="100%" bgcolor="#EDEEEE">
  			<tr bgcolor="#EDEEEE">
			  <td colspan="2" class="style1" align="center"><b>'.$not3[d_nome].'</b></td>
			</tr>';
			
		$d_txt = str_replace("\n","<br>","$d_txt");

  $html10 .='<tr bgcolor="#ffffff">
  			<td colspan="2" class="style1" align="justify">'.$d_txt.'</td>
		   </tr>';
	

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="left"><b>'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].' , '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>PROPRIETÁRIO(A): _________________________</b></td>
    		<td width="50%" class="style1"><b>CORRETOR(A): _________________________</b></td>
    	</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    	</tr>
  	</table>';

	}
	}
	}
	}//Termina imp = 2
	elseif($imp == "5"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	  
	$query20 = "select * from muraski m, clientes c, rebri_cidades ci, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cidade_mat=ci.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	}
	
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=c.c_cod and m.cidade_mat=ci.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente10 = explode("--", $not2[cliente]);
	  $cliente20 = str_replace("-","",$cliente10);  
	
	$d_txt = str_replace("-mat-", "<b>$not2[matricula]</b>", $not3[d_txt]);
	$d_txt = str_replace("-ref-", "$not2[ref]", $d_txt);
	$d_txt = str_replace("-dias_uteis-", "$not2[dias]", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>".strip_tags($not2[descricao])."</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "<b>".strip_tags($not2[titulo])."</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-uf_imovel-", "<b>$not2[e_nome]</b>", $d_txt);
	
	$valor = number_format($not2[valor], 2, ',', '.');
	
	$d_txt = str_replace("-valor-", "<b>$valor</b>", $d_txt);
	
	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );

	$d_txt = str_replace("-data_inicio-", "<b>$dia/$mes/$ano</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$dia1/$mes1/$ano1</b>", $d_txt);
	
	$comissao = number_format($not2[comissao], 2, ',', '.');
	
	$d_txt = str_replace("-com_venda-", "<b>$not2[comissao]</b>", $d_txt);

	$qstr = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
    $qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $proprietarios = array();
    $origens = array();
    $es_civis = array();
    $rg_ie = array();
    $cpf_cnpj = array();
    $enderecos = array();
    $cidades = array();
    $ufs = array();
    $telefones = array();
    $representantes = array();
    $representantes2 = array();
    foreach ($res as $row) {
        array_push($proprietarios, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origens, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($es_civis, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_ie, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_cnpj, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        array_push($enderecos, $row['c_end']);
        array_push($cidades, $row['c_cidade']);
        array_push($ufs, $row['c_estado']);
        array_push($telefones, $row['c_tel']);
        if (!empty($row['c_repre'])) {
            array_push($representantes, 'Representante 1:<b> ' . $row['c_repre'] . '</b>');
        }
        if (!empty($row['c_repre2'])) {
            array_push($representantes2, 'Representante 2:<b> ' . $row['c_repre2'] . '</b>');
        }
    }
    $proprietarios = implode(' e ', $proprietarios);
    $origens = implode(' e ', $origens);
    $es_civis = implode(' e ', $es_civis);
    $rg_ie = implode(' e ', $rg_ie);
    $cpf_cnpj = implode(' e ', $cpf_cnpj);
    $enderecos = implode(' e ', $enderecos);
    $cidades = implode(' e ', $cidades);
    $ufs = implode(' e ', $ufs);
    $telefones = implode(' e ', $telefones);
    $representantes = implode(' e ', $representantes);
    $representantes2 = implode(' e ', $representantes2);
   
    $d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $d_txt);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-tel_prop-", "<b>$telefones</b>", $d_txt);
   	$d_txt = str_replace("-repre_prop-", "$representantes $representantes2", $d_txt);	
   	
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
	$d_txt = str_replace("-bairro_im-", "<b>$linha[im_bairro]</b>", $d_txt);  
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);

  	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	}
    }

$dia2 = date("d");
$mes2 = date("m");
$ano2 = date("Y");

$html10 .='<table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  			<tr bgcolor="#EDEEEE">
			  <td colspan="2" class="style1" align="center"><b>'.$not3[d_nome].'</b></td>
			</tr>';

$d_txt = str_replace("\n","<br>","$d_txt");

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="justify">'.$d_txt.'</td>
		</tr>';
	

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="left"><b> '.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>PROPRIETÁRIO: _________________________</b></td>
    		<td width="50%" class="style1"><b>CORRETOR(A): _________________________</b></td>
    	</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    	</tr>
  </table>';

	}
	}
	}
	}//Termina imp = 5
	elseif($imp == "4"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	  
	$query20 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	$cod_cliente2 = " (";
	for($i3 = 1; $i3 <= $contador; $i3++){
	    if($i3==1){  
			$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
		}else{
		  	$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
		}
	} 
	$cod_cliente2 .= ")";   
	  
	
	$query2 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and $cod_cliente2";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	
	$ano = date(Y);
	$mes = date(m);
	$dia = date(d);

	$d_txt = str_replace("-data_hoje-", "<b>$dia/$mes/$ano</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);

  	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	}
	}
	
$dia2 = date("d");
$mes2 = date("m");
$ano2 = date("Y");

$html10 .='<table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  			<tr bgcolor="#EDEEEE">
			  <td colspan="2" class="style1" align="center"><b>'.$not3[d_nome].'</b></td>
			</tr>';

$d_txt = str_replace("\n","<br>","$d_txt");

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="justify">'.$d_txt.'</td>
		 </tr>
		 ';	

$html10 .='</table>';

	}
	}
	}
	}//Termina imp = 4
	elseif($imp == "7"){
		if($comprador == ""){
			//echo $comprador;
			//echo $cod;

$html10 .='<form method="get" action="'.$PHP_SELF.'">
    <input type="hidden" name="imp" value="7">
    <input type="hidden" name="cod" value="'.$cod.'">
    <input type="hidden" name="comprador" value="1">
    	<b>Fazer proposta de compra:</b><br>
    		<select name="compr" class="campo">
   			 <option value="0">Selecione um comprador</option>';

	$query1 = "select c_cod, c_nome, c_tipo from clientes where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	order by c_tipo, c_nome, c_cod";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	while($not1 = mysql_fetch_array($result1))
	{
	 $c_nome = substr ($not1[c_nome], 0, 30);

	$html10 .='<option value='.$not1[c_cod].' title="'.$not1['c_nome'].' - '.$not1['c_tipo'].'">'.$c_nome.'... - '.$not1['c_tipo'].'></option>';

	}

$html10 .='</select><br>
			<textarea rows="5" class="campo" name="proposta" cols="36">Escreva aqui a proposta</textarea><br>
			<input type="submit" name="B1" value="Proposta" class="campo3">
		</form>';

	}
		
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci where m.cod = '$cod' and c.c_cod='$compr' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cidade_mat=ci.ci_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-profissao-", "<b>$not2[c_prof]</b>", $d_txt);
	$d_txt = str_replace("-rg-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-bairro-", "<b>$not2[c_bairro]</b>", $d_txt);
	$d_txt = str_replace("-cidade-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-cep-", "<b>$not2[c_cep]</b>", $d_txt);
	$d_txt = str_replace("-tel-", "<b>$not2[c_tel]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-local-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-matricula-", "<b>$not2[matricula]</b>", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$not2[ci_nome]</b>", $d_txt);
	
	
	$nome_cliente3 = '';

for ($i3 = 0; $i3 < $not2[contador]; $i3++) {

	$query4 = "select * from clientes where c_cod='" . $cliente2[$i3] . "' and cod_imobiliaria='" . $cod_im . "'";

	$result4 = mysql_query($query4);
	$res_clientes = array();
	
	while ($not4 = mysql_fetch_array($result4)) {
	    array_push($res_clientes, $not4[c_nome]);
	}
	
	$res_clientes = implode(" e ", $res_clientes);
	$nome_cliente3 .= empty($nome_cliente3) ? $res_clientes : " e " . $res_clientes;

}

	$d_txt = str_replace("-nome_prop-", "<b>$nome_cliente3</b>", $d_txt);
	
	
	$ano = date("Y");
	$mes = date("m");
	$dia = date("d");
	
	$d_txt = str_replace("-data_hoje-", "<b>$dia/$mes/$ano</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);

  	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	}
	}
	
$dia2 = date("d");
$mes2 = date("m");
$ano2 = date("Y");

$html10 .='<table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  			<tr bgcolor="#EDEEEE">
			  <td colspan="2" class="style1" align="center"><b>'.$not3[d_nome].'</b></td>
			</tr>';

$d_txt = str_replace("\n","<br>","$d_txt");

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="justify">'.$d_txt.'</td>
		</tr>';
	

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="left"><b>'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		 </tr>
  		 <tr bgcolor="#EDEEEE">
    		<td colspan="2" class="style1"><b>PROPONENTE COMPRADOR(A): _________________________</b></td>
    	</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>PROPRIETÁRIO(A): _________________________</b></td>
    		<td width="50%" class="style1"><b>CORRETOR(A): _________________________</b></td>
    	</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    	</tr>
  	</table>';

	}
	}
	}
	}//Termina imp = 7
	elseif($imp == "9"){ //Contrato de Locação
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select * from muraski, clientes, rebri_tipo where muraski.cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.tipo=rebri_tipo.t_cod";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	}
	
	$query2 = "select * from muraski, clientes, rebri_tipo, rebri_cidades where muraski.cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=clientes.c_cod and muraski.tipo=rebri_tipo.t_cod and muraski.local=rebri_cidades.ci_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente10 = explode("--", $not2[cliente]);
	  $cliente20 = str_replace("-","",$cliente10);
	  
	  
	$qstr = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
    $qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $proprietarios = array();
    $origens = array();
    $es_civis = array();
    $rg_ie = array();
    $cpf_cnpj = array();
    $nacionalidades = array();
    $profissoes = array();
    $enderecos = array();
    $cidades = array();
    $ufs = array();
    $telefones = array();
    $celulares = array();
    $emails = array();
    $ceps = array();
    $representantes = array();
    $representantes2 = array();
    foreach ($res as $row) {
        array_push($proprietarios, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origens, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($es_civis, '<b>' . $row['c_civil'] . '</b>');
        }
        
        array_push($rg_ie, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_cnpj, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        if (!empty($row['c_nacionalidade'])) {
            array_push($nacionalidades, '<b>' . $row['c_nacionalidade'] . '</b>');
        }
        if (!empty($row['c_profissao'])) {
            array_push($profissoes, '<b>' . $row['c_profissao'] . '</b>');
        }
        array_push($enderecos, $row['c_end']);
        array_push($cidades, $row['c_cidade']);
        array_push($ufs, $row['c_estado']);
        array_push($telefones, $row['c_tel']);
        if (!empty($row['c_celular'])) {
            array_push($celulares, '<b>' . $row['c_celular'] . '</b>');
        }
        if (!empty($row['c_email'])) {
            array_push($emails, '<b>' . $row['c_email'] . '</b>');
        }
        if (!empty($row['c_cep'])) {
            array_push($ceps, '<b>' . $row['c_cep'] . '</b>');
        }
        if (!empty($row['c_repre'])) {
            array_push($representantes, 'Representante 1:<b> ' . $row['c_repre'] . '</b>');
        }
        if (!empty($row['c_repre2'])) {
            array_push($representantes2, 'Representante 2:<b> ' . $row['c_repre2'] . '</b>');
        }
    }
    $proprietarios = implode(' e ', $proprietarios);
    $origens = implode(' e ', $origens);
    $es_civis = implode(' e ', $es_civis);
    $rg_ie = implode(' e ', $rg_ie);
    $cpf_cnpj = implode(' e ', $cpf_cnpj);
    $nacionalidades = implode(' e ', $nacionalidades);
    $profissoes = implode(' e ', $profissoes);
    $enderecos = implode(' e ', $enderecos);
    $cidades = implode(' e ', $cidades);
    $ufs = implode(' e ', $ufs);
    $telefones = implode(' e ', $telefones);
    $celulares = implode(' e ', $celulares);
    $emails = implode(' e ', $emails);
    $ceps = implode(' e ', $ceps);
    $representantes = implode(' e ', $representantes);  
    $representantes2 = implode(' e ', $representantes2);  
	  
	$d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-naci_prop-", "$nacionalidades", $d_txt);
	$d_txt = str_replace("-prof_prop-", "$profissoes", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-tel_prop-", "<b>$telefones</b>", $d_txt);
	$d_txt = str_replace("-cel_prop-", "$celulares", $d_txt);
	$d_txt = str_replace("-email_prop-", "$emails", $d_txt);
	$d_txt = str_replace("-cep_prop-", "$ceps", $d_txt);
   	$d_txt = str_replace("-repre_prop-", "$representantes $representantes2", $d_txt);
	
	
	$d_txt = str_replace("-cid_imov-", "$not2[ci_nome]", $d_txt);
	$d_txt = str_replace("-end_imov-", "$not2[end]", $d_txt);
	$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "<b>".strip_tags($not2[titulo])."</b>", $d_txt);
	$d_txt = str_replace("-acomod-", "$not2[acomod]", $d_txt);
	

	$diaria2 = number_format($not2[diaria2], 2, ',', '.');
	
	$query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod 
	and l_cod='$l_cod'";
	//echo $query4;
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);

	while($not4 = mysql_fetch_array($result4))
	{
	$total = $not4[l_total] + $not4[l_limpeza];
	$total_extenso = extenso($total);
	//$total = $not4[l_total];
	$total_final = number_format($total, 2, ',', '.');
	$total_final_extenso = extenso($total_final);
	$total = number_format($not4[l_total], 2, ',', '.');
	$limpeza = number_format($not4[l_limpeza], 2, ',', '.');
	$tv = number_format($not4[l_tv], 2, ',', '.');
	
	$total_manu_extenso = extenso($tv);
	
	$ano = substr ($not4[l_data_ent], 0, 4);
	$mes = substr($not4[l_data_ent], 5, 2 );
	$dia = substr ($not4[l_data_ent], 8, 2 );
	$ano1 = substr ($not4[l_data_sai], 0, 4);
	$mes1 = substr($not4[l_data_sai], 5, 2 );
	$dia1 = substr ($not4[l_data_sai], 8, 2 );
	
	$data_ent = "$dia/$mes/$ano";
	$data_sai = "$dia1/$mes1/$ano1";

	$data = mktime(0,0,0, $mes, $dia, $ano);
	$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);
	
	$total_dias = round((($data1 - $data)/(24*60*60)));
	$total_dias = $total_dias + 1;
	
	$d_txt = str_replace("-total_dias-", "<b>$total_dias</b>", $d_txt);
	$d_txt = str_replace("-data_ent-", "<b>$data_ent</b>", $d_txt);
	$d_txt = str_replace("-data_sai-", "<b>$data_sai</b>", $d_txt);
	$d_txt = str_replace("-total_final-", "<b>$total_final</b>", $d_txt);
	$d_txt = str_replace("-total_final_extenso-", "<b>$total_final_extenso</b>", $d_txt);
	$d_txt = str_replace("-total_manu-", "<b>$total_manu</b>", $d_txt);
	$d_txt = str_replace("-total_manu_extenso-", "<b>$total_manu_extenso</b>", $d_txt);
	$d_txt = str_replace("-total-", "<b>$total</b>", $d_txt);
	$d_txt = str_replace("-total_extenso-", "<b>$total_extenso</b>", $d_txt);
	$d_txt = str_replace("-limpeza-", "<b>$limpeza</b>", $d_txt);
	$d_txt = str_replace("-limpeza-", "", $d_txt);
	$d_txt = str_replace("-tv-", "<b>$tv</b>", $d_txt);
	$d_txt = str_replace("-l_pagto-", "<b>$not4[l_pagto]</b>", $d_txt);
	$d_txt = str_replace("-nome_loc-", "<b>$not4[c_nome]</b>", $d_txt);
	$d_txt = str_replace("-origem_loc-", "<b>$not4[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil_loc-", "<b>$not4[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-rg_loc-", "<b>$not4[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf_loc-", "<b>$not4[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end_loc-", "<b>$not4[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cep_loc-", "<b>$not4[c_cep]</b>", $d_txt);
	$d_txt = str_replace("-cidade_loc-", "<b>$not4[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-tel_loc-", "<b>$not4[c_tel], $not4[c_cel]</b>", $d_txt);
	//$d_txt = str_replace("-usuario-", "$not4[l_usuario]", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);
	$d_txt = str_replace("-bairro_im-", "<b>$linha[im_bairro]</b>", $d_txt);

  	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	}
	}

$dia2 = date("d");
$mes2 = date("m");
$ano2 = date("Y");

$html10 .='<table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  			<tr bgcolor="#EDEEEE">
			  <td colspan="2" class="style1" align="center"><b>'.$not3[d_nome].'</b></td>
			</tr>';

$d_txt = str_replace("\n","<br>","$d_txt");

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="justify">'.$d_txt.'</td>
		 </tr>';
	

$html10 .='<tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="left"><b>'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
  		<tr bgcolor="#EDEEEE">
			<td width="50%" class="style1"><b>LOCATÁRIO: _________________________</b></td>
    		<td width="50%" class="style1"><b>LOCADOR: _________________________</b></td>
    	</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    		<td width="50%" class="style1"><b>TESTEMUNHA: _________________________</b></td>
    	</tr>
	  	<tr bgcolor="#EDEEEE">
   			<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Usuário (uso interno): '; 

	$busca_usuario = mysql_query("SELECT u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_cod='".$not4['l_usuario']."'");
	while($linha = mysql_fetch_array($busca_usuario))
	{
        $html10 .= $linha['u_nome'];	   
	}

$html10 .= '</td>
    	</tr>
  	</table>';


	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4
	elseif($imp == "10"){ //Contrato de Locação Mensal
	
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select * from muraski, clientes, rebri_tipo where muraski.cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.tipo=rebri_tipo.t_cod";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	}
	
	$query2 = "select * from muraski, clientes, rebri_tipo, rebri_cidades, rebri_estados where muraski.cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=clientes.c_cod and muraski.tipo=rebri_tipo.t_cod and muraski.local=rebri_cidades.ci_cod and muraski.uf=rebri_estados.e_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente10 = explode("--", $not2[cliente]);
	  $cliente20 = str_replace("-","",$cliente10);
	  
	  $bairro10 = explode("--", $not2[bairro]);
	  $bairro20 = str_replace("-","",$bairro10);
	  
	$qstr = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $proprietarios = array();
    $origens = array();
    $es_civis = array();
    $rg_ie = array();
    $cpf_cnpj = array();
    $profissoes = array();
    $enderecos = array();
    $cidades = array();
    $ufs = array();
    $endereco_com = array();
    $cidade_com = array();
    $estado_com = array();
    foreach ($res as $row) {
        array_push($proprietarios, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origens, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($es_civis, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_ie, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_cnpj, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        if (!empty($row['c_prof'])) {
            array_push($profissoes, '<b>' . $row['c_prof'] . '</b>');
        }
        array_push($enderecos, $row['c_end']);
        array_push($cidades, $row['c_cidade']);
        array_push($ufs, $row['c_estado']);
        if (!empty($row['c_end_com'])) {
            array_push($endereco_com, '<b> ' . $row['c_end_com'] . '</b>');
        }
        if (!empty($row['c_cidade_com'])) {
            array_push($cidade_com, '<b> ' . $row['c_cidade_com'] . '</b>');
        }
        if (!empty($row['c_estado_com'])) {
            array_push($estado_com, '<b> ' . $row['c_estado_com'] . '</b>');
        }
    }
    $proprietarios = implode(' e ', $proprietarios);
    $origens = implode(' e ', $origens);
    $es_civis = implode(' e ', $es_civis);
    $rg_ie = implode(' e ', $rg_ie);
    $cpf_cnpj = implode(' e ', $cpf_cnpj);
    $profissoes = implode(' e ', $profissoes);
    $enderecos = implode(' e ', $enderecos);
    $cidades = implode(' e ', $cidades);
    $ufs = implode(' e ', $ufs);
    $endereco_com = implode(' e ', $endereco_com);  
    $cidade_com = implode(' e ', $cidade_com);  
    $estado_com = implode(' e ', $estado_com);  
        
	if($not2[bairro]<>''){
	$qstr2 = "select * from rebri_bairros where b_cod in (" . implode(',',$bairro20) . ")";
    $qres2 = mysql_query($qstr2);

    $res2 = array();
    while ($rw2 = mysql_fetch_assoc($qres2)) {
        array_push($res2, $rw2);
    }
    
    $bairros = array();
    foreach ($res2 as $row2) {
        if (!empty($row2['b_nome'])) {
            array_push($bairros, '<b>' . $row2['b_nome'] . '</b>');
        }
    }
    $bairros = implode(' e ', $bairros);
    }
	
	$d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-prof_prop-", "$profissoes", $d_txt);
	$d_txt = str_replace("-rg_prop-", "$rg_ie", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "$cpf_cnpj", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
   	$d_txt = str_replace("-end_comercial-", "$endereco_com", $d_txt);
   	$d_txt = str_replace("-cidade_comercial-", "$cidade_com", $d_txt);
   	$d_txt = str_replace("-estado_comercial-", "$estado_com", $d_txt);
	
	$query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod and l_cod='$l_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
	  
	$ano = substr ($not4[l_data_ent], 0, 4);
	$mes = substr($not4[l_data_ent], 5, 2 );
	$dia = substr ($not4[l_data_ent], 8, 2 );
	$ano1 = substr ($not4[l_data_sai], 0, 4);
	$mes1 = substr($not4[l_data_sai], 5, 2 );
	$dia1 = substr ($not4[l_data_sai], 8, 2 );
	
	$data_ini = "$dia/$mes/$ano"; 
	$data_fim = "$dia1/$mes1/$ano1";
	
	$qtd_contas = retornaDifMeses($data_ini, $data_fim);
	
	$valor_total = ($not4[l_total] * $qtd_contas);
	$valor_total_extenso = extenso($valor_total);
	
	$dia_venc = $not4[l_venc_aluguel];
	$atraso = $not4[l_tolerancia];
	$atraso_extenso = numero_extenso($atraso);
	$bonificacao = ($not4[l_bonificacao] / 100);
	$valor_bonificacao = ($valor_total * $bonificacao);
	$valor_bonificacao_extenso = extenso($valor_bonificacao);
	$valor_total_desconto = ($valor_total - $valor_bonificacao);
	$valor_total_desconto_extenso = extenso($valor_total_desconto);
	$pagamentos = ($valor_total_desconto / 4);
	$pagamentos_extenso = extenso($pagamentos);
	
	$d_txt = str_replace("-data_ini-", "<b>$data_ini</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$data_fim</b>", $d_txt);
	$d_txt = str_replace("-valor_contrato-", "<b>$valor_total ($valor_total_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_bonificacao-", "<b>$valor_bonificacao ($valor_bonificacao_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_total_desconto-", "<b>$valor_total_desconto ($valor_total_desconto_extenso)</b>", $d_txt);
	$d_txt = str_replace("-pagamentos-", "<b>$pagamentos ($pagamentos_extenso)</b>", $d_txt);
	$d_txt = str_replace("-atraso-", "<b>$atraso ($atraso_extenso)</b>", $d_txt);
	
	$query47 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_fiador=c_cod and l_cod='$l_cod'";
	$result47 = mysql_query($query47);
	$numrows47 = mysql_num_rows($result47);
	while($not47 = mysql_fetch_array($result47))
	{
	   $nome_fiador = $not47[c_nome];
	   $rg_fiador = $not47[c_rg];
	   $cpf_fiador = $not47[c_cpf];    
	   $origem_fiador = $not47[c_origem];
	   $prof_fiador = $not47[c_prof];
	   $civil_fiador = $not47[c_civil];
	   $endereco_fiador = $not47[c_end];
	   $bairro_fiador = $not47[c_bairro];
	   $cidade_fiador = $not47[c_cidade];
	   $estado_fiador = $not47[c_estado];
	   $cep_fiador = $not47[c_cep];
	   
	   $d_txt = str_replace("-nome_fiador-", "<b>$nome_fiador</b>", $d_txt);
	   $d_txt = str_replace("-rg_fiador-", "<b>$rg_fiador</b>", $d_txt);
	   $d_txt = str_replace("-cpf_fiador-", "<b>$cpf_fiador</b>", $d_txt);
	   $d_txt = str_replace("-origem_fiador-", "<b>$origem_fiador</b>", $d_txt);
	   $d_txt = str_replace("-prof_fiador-", "<b>$prof_fiador</b>", $d_txt);
	   $d_txt = str_replace("-civil_fiador-", "<b>$civil_fiador</b>", $d_txt);
	   $d_txt = str_replace("-endereco_fiador-", "<b>$endereco_fiador</b>", $d_txt);
	   $d_txt = str_replace("-bairro_fiador-", "<b>$bairro_fiador</b>", $d_txt);
	   $d_txt = str_replace("-cidade_fiador-", "<b>$cidade_fiador</b>", $d_txt);
	   $d_txt = str_replace("-estado_fiador-", "<b>$estado_fiador</b>", $d_txt); 
	   $d_txt = str_replace("-cep_fiador-", "<b>$cep_fiador</b>", $d_txt); 
	   
	}  
	
	$query46 = "select * from locacao, contas where co_locacao='$l_cod' and co_imovel='$cod' and contas.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and contas.co_locacao=locacao.l_cod and contas.co_tipo='Locação' AND contas.co_cat='Receber' ORDER BY contas.co_data ASC LIMIT 0,1";
	$result46 = mysql_query($query46);
	$numrows46 = mysql_num_rows($result46);
	while($not46 = mysql_fetch_array($result46))
	{
	    $valor_aluguel = $not46[co_valor];
		$valor_aluguel_extenso = extenso($valor_aluguel);
		
		$ano_venc = substr($not46[co_data], 0, 4);
		$mes_venc = substr($not46[co_data], 5, 2 );
		$dia_venc = substr($not46[co_data], 8, 2 );
		
		$data_venc = "$dia_venc/$mes_venc/$ano_venc"; 
		
		$d_txt = str_replace("-valor_aluguel-", "<b>$valor_aluguel ($valor_aluguel_extenso)</b>", $d_txt);
		$d_txt = str_replace("-dia_venc-", "<b>$dia_venc</b>", $d_txt);
		$d_txt = str_replace("-data_venc-", "<b>$data_venc</b>", $d_txt);
	}
	
    $texto1 = "Representada pelos seus sócios abaixo qualificados";
    $texto2 = ", neste ato representado pelos sócios";
		
	$d_txt = str_replace("-nome_loc-", "<b>$not4[c_nome]</b>", $d_txt);
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-rg_loc-", " RG: <b>$not4[c_rg]</b>", $d_txt);  
		$d_txt = str_replace("-rg2_loc-", " RG: <b>$not4[c_rg]</b>", $d_txt);
	}else{
	    $d_txt = str_replace("-rg_loc-", " Inscrição Estadual: <b>$not4[c_rg]</b>. $texto1", $d_txt);   
	    $d_txt = str_replace("-rg2_loc-", " Inscrição Estadual: <b>$not4[c_rg]</b> $texto2", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-cpf_loc-", "portador do CPF: <b>$not4[c_cpf]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-cpf_loc-", "inscrito no CNPJ: <b>$not4[c_cpf]</b>", $d_txt);
	}
	

	if($not4[c_tipo_pessoa]=='J'){
	  if($not4[c_repre2]<>''){
	     $var = "e";
	  }  
		$d_txt = str_replace("-repre1_prop-", "<b>$not4[c_repre]</b> $var", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "<b>$not4[c_repre2]</b>", $d_txt);
   	}else{
	 	$d_txt = str_replace("-repre1_prop-", "", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "", $d_txt);    
	}
	
	$d_txt = str_replace("-cidade_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-estado_imov-", "<b>$not2[e_uf]</b>", $d_txt);
	$d_txt = str_replace("-bairro_imov-", "<b>$bairros</b>", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-matricula_imov-", "<b>$not2[ref]</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-cidade_imo-", "$linha[ci_nome]", $d_txt);  

	}
	}

$dia2 = date("d");
$mes2 = date("m");
$ano2 = date("Y");

$html10 .='<table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  			<tr bgcolor="#EDEEEE">
			  <td colspan="2" class="style1" align="center"><b>'.$not3[d_nome].'</b></td>
			</tr>
		   ';

$d_txt = str_replace("\n","<br>","$d_txt");

$html10 .='
             <tr bgcolor="#ffffff">
			  <td colspan="2" class="style1" align="justify">'.$d_txt.'</td>
		     </tr>
		   ';

$html10 .='
         <tr bgcolor="#ffffff">
			<td colspan="2" class="style1" align="left"><b>'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>LOCATÁRIO: _________________________</b></td>
    		<td width="50%" class="style1"><b>LOCADOR: _________________________</b></td>
    	</tr>
  		<tr bgcolor="#EDEEEE">
    		<td width="50%" class="style1"><b>TESTEMUNHA 1: _________________________</b></td>
    		<td width="50%" class="style1"><b>TESTEMUNHA 2: _________________________</b></td>
    	</tr>
    	<tr bgcolor="#EDEEEE">
    		<td width="50%" colspan="2" class="style1"><b>FIADOR: _________________________</b></td>
    	</tr>
	  	<tr bgcolor="#EDEEEE">
   			<td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;">Usuário (uso interno): '; 

	$busca_usuario = mysql_query("SELECT u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_cod='".$not4['l_usuario']."'");
	while($linha = mysql_fetch_array($busca_usuario))
	{
        $html10 .= $linha['u_nome'];	   
	}

$html10 .= '</td>
    	</tr>
  	</table>';  
  	  
  	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4 

echo $html10;


/*
require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html10);
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();
$dompdf->stream($arquivo10);  
*/

}



?>

<? if($_POST['pdf']<>'1'){ ?>

<html>
<head>
<?php
include("style.php");
?>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<p>
<?php

	if($imp == "2"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	}
	
	$query2 = "select * from muraski, clientes, rebri_cidades where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and muraski.local=rebri_cidades.ci_cod and '".$cod_cliente2."'=clientes.c_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	  $cliente10 = explode("--", $not2[cliente]);
	  $cliente20 = str_replace("-","",$cliente10);  
	
	$qstr = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
    $qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $proprietarios = array();
    $origens = array();
    $es_civis = array();
    $rg_ie = array();
    $cpf_cnpj = array();
    $enderecos = array();
    $cidades = array();
    $ufs = array();
    $telefones = array();
    $representantes = array();
    $representantes2 = array();
    foreach ($res as $row) {
        array_push($proprietarios, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origens, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($es_civis, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_ie, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_cnpj, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        array_push($enderecos, $row['c_end']);
        array_push($cidades, $row['c_cidade']);
        array_push($ufs, $row['c_estado']);
        array_push($telefones, $row['c_tel']);
        if (!empty($row['c_repre'])) {
            array_push($representantes, 'Representante 1:<b> ' . $row['c_repre'] . '</b>');
        }
        if (!empty($row['c_repre2'])) {
            array_push($representantes2, 'Representante 2:<b> ' . $row['c_repre2'] . '</b>');
        }
    }
    $proprietarios = implode(' e ', $proprietarios);
    $origens = implode(' e ', $origens);
    $es_civis = implode(' e ', $es_civis);
    $rg_ie = implode(' e ', $rg_ie);
    $cpf_cnpj = implode(' e ', $cpf_cnpj);
    $enderecos = implode(' e ', $enderecos);
    $cidades = implode(' e ', $cidades);
    $ufs = implode(' e ', $ufs);
    $telefones = implode(' e ', $telefones);
    $representantes = implode(' e ', $representantes);
    $representantes2 = implode(' e ', $representantes2);
	
	
	$d_txt = str_replace("-nome-", "<b>$proprietarios</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem-", "$origens", $d_txt);
	$d_txt = str_replace("-civil-", "$es_civis", $d_txt);
	$d_txt = str_replace("-rg-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-end-", "<b>$enderecos</b>", $d_txt);
	$d_txt = str_replace("-cidade-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-tel-", "<b>$telefones</b>", $d_txt);
   	//$d_txt = str_replace("-repre_prop-", "$representantes $representantes2", $d_txt);	
	
	/*
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-rg-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-tel-", "<b>$not2[c_tel]</b>", $d_txt);
	*/
	
	$d_txt = str_replace("-cid_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);

	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );

	$d_txt = str_replace("-data_inicio-", "<b>$dia/$mes/$ano</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$dia1/$mes1/$ano1</b>", $d_txt);
	
	$diaria1 = number_format($not2[diaria1], 2, ',', '.');
	$diaria2 = number_format($not2[diaria2], 2, ',', '.');
	$comissao = number_format($not2[comissao], 2, ',', '.');
	
	$d_txt = str_replace("-diaria1-", "<b>$diaria1</b>", $d_txt);
	$d_txt = str_replace("-diaria2-", "<b>$diaria2</b>", $d_txt);
	$d_txt = str_replace("-comissao-", "<b>$not2[comissao]</b>", $d_txt);
	$d_txt = str_replace("-conta-", "<b>$not2[c_conta]</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);

  	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	}
    }

$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" action="<?php print("$url"); ?>">
<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="impressao" value="1">
<input type="hidden" name="imp" value="2">
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea></td></tr>
  <tr bgcolor="#ffffff"><td colspan=2>
<input type="submit" value="Finalizar Texto" class=campo3 name="B1"></td></tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="justify"><br><?php print("$txt"); ?></p><p></td></tr>
<?php
	}
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?></p></td></tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>PROPRIETÁRIO(A): <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>CORRETOR(A): <br>
      _________________________</b></p>
    <p></td>
    </tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>TESTEMUNHA: <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>TESTEMUNHA: <br>
      _________________________</b></p>
    <p></td>
    </tr>
</table>
<?php
	}
	}
	}
	}//Termina imp = 2
	elseif($imp == "5"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	  
	$query20 = "select * from muraski m, clientes c, rebri_cidades ci, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cidade_mat=ci.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	}
	
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=c.c_cod and m.cidade_mat=ci.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente10 = explode("--", $not2[cliente]);
	  $cliente20 = str_replace("-","",$cliente10);  
	
	$d_txt = str_replace("-mat-", "<b>$not2[matricula]</b>", $not3[d_txt]);
	$d_txt = str_replace("-ref-", "$not2[ref]", $d_txt);
	$d_txt = str_replace("-dias_uteis-", "$not2[dias]", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>".strip_tags($not2[descricao])."</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "<b>".strip_tags($not2[titulo])."</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-uf_imovel-", "<b>$not2[e_nome]</b>", $d_txt);
	
	$valor = number_format($not2[valor], 2, ',', '.');
	
	$d_txt = str_replace("-valor-", "<b>$valor</b>", $d_txt);
	
	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );

	$d_txt = str_replace("-data_inicio-", "<b>$dia/$mes/$ano</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$dia1/$mes1/$ano1</b>", $d_txt);
	
	$comissao = number_format($not2[comissao], 2, ',', '.');
	
	$d_txt = str_replace("-com_venda-", "<b>$not2[comissao]</b>", $d_txt);

	$qstr = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
    $qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $proprietarios = array();
    $origens = array();
    $es_civis = array();
    $rg_ie = array();
    $cpf_cnpj = array();
    $enderecos = array();
    $cidades = array();
    $ufs = array();
    $telefones = array();
    $representantes = array();
    $representantes2 = array();
    foreach ($res as $row) {
        array_push($proprietarios, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origens, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($es_civis, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_ie, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_cnpj, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        array_push($enderecos, $row['c_end']);
        array_push($cidades, $row['c_cidade']);
        array_push($ufs, $row['c_estado']);
        array_push($telefones, $row['c_tel']);
        if (!empty($row['c_repre'])) {
            array_push($representantes, 'Representante 1:<b> ' . $row['c_repre'] . '</b>');
        }
        if (!empty($row['c_repre2'])) {
            array_push($representantes2, 'Representante 2:<b> ' . $row['c_repre2'] . '</b>');
        }
    }
    $proprietarios = implode(' e ', $proprietarios);
    $origens = implode(' e ', $origens);
    $es_civis = implode(' e ', $es_civis);
    $rg_ie = implode(' e ', $rg_ie);
    $cpf_cnpj = implode(' e ', $cpf_cnpj);
    $enderecos = implode(' e ', $enderecos);
    $cidades = implode(' e ', $cidades);
    $ufs = implode(' e ', $ufs);
    $telefones = implode(' e ', $telefones);
    $representantes = implode(' e ', $representantes);
    $representantes2 = implode(' e ', $representantes2);
   
    $d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $d_txt);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-tel_prop-", "<b>$telefones</b>", $d_txt);
   	$d_txt = str_replace("-repre_prop-", "$representantes $representantes2", $d_txt);	
   	
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
	$d_txt = str_replace("-bairro_im-", "<b>$linha[im_bairro]</b>", $d_txt);  
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);

  	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	}
    }

$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" action="<?php print("$url"); ?>">
<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="impressao" value="1">
<input type="hidden" name="imp" value="5">
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea></td></tr>
  <tr bgcolor="#ffffff"><td colspan=2>
<input type="submit" value="Finalizar Texto" class=campo3 name="B1"></td></tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="justify"><br><?php print("$txt"); ?></p><p></td></tr>
<?php
	}
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?></p></td></tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>PROPRIETÁRIO(A): <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>CORRETOR(A): <br>
      _________________________</b></p>
    <p></td>
    </tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>TESTEMUNHA: <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>TESTEMUNHA: <br>
      _________________________</b></p>
    <p></td>
    </tr>
  </table>
<?php
	}
	}
	}
	}//Termina imp = 5
	elseif($imp == "4"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	  
	$query20 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	$cod_cliente2 = " (";
	for($i3 = 1; $i3 <= $contador; $i3++){
	    if($i3==1){  
			$cod_cliente2 .= "c_cod='".$cliente2[$i3-1]."'";
		}else{
		  	$cod_cliente2 .= " or c_cod='".$cliente2[$i3-1]."'";
		}
	} 
	$cod_cliente2 .= ")";   
	  
	
	$query2 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and $cod_cliente2";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	
	$ano = date(Y);
	$mes = date(m);
	$dia = date(d);

	$d_txt = str_replace("-data_hoje-", "<b>$dia/$mes/$ano</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);

  	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	}
	}
	
$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" action="<?php print("$url"); ?>">
<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="impressao" value="1">
<input type="hidden" name="imp" value="4">
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea></td></tr>
  <tr bgcolor="#ffffff"><td colspan=2>
<input type="submit" value="Finalizar Texto" class=campo3 name="B1"></td></tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="justify"><br><?php print("$txt"); ?></p><p></td></tr>
<?php
	}
?>
  </table>
<?php
	}
	}
	}
	}//Termina imp = 4
	elseif($imp == "7"){
		if($comprador == ""){
			//echo $comprador;
			//echo $cod;
?>
<p></p>
    <form method="get" action="<?php print("$PHP_SELF"); ?>">
    <input type="hidden" name="imp" value="7">
    <input type="hidden" name="cod" value="<?php print("$cod"); ?>">
    <input type="hidden" name="comprador" value="1">
    <b>Fazer proposta de compra:</b><br><br>
    <select name=compr class=campo>
    <option selected>Selecione um comprador
<?php
	$query1 = "select c_cod, c_nome, c_tipo from clientes where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' 
	order by c_tipo, c_nome, c_cod";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	while($not1 = mysql_fetch_array($result1))
	{
	 $c_nome = substr ($not1[c_nome], 0, 30);
?>
	<option value=<?php print("$not1[c_cod]"); ?> title="<?php print($not1['c_nome'].' - '.$not1['c_tipo']); ?>"><?php print($c_nome.'... - '.$not1['c_tipo']); ?></option>
<?php
	}
?>
	</select><br><br>
	<textarea rows="5" class="campo" name="proposta" cols="36">Escreva aqui a proposta</textarea><br><br>
	<input type=submit name=B1 value=Proposta class=campo3></form>
<?php
	}
	//echo $comprador;
	//echo $cod;
		
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query2 = "select * from muraski m, clientes c, rebri_cidades ci where m.cod = '$cod' and c.c_cod='$compr' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cidade_mat=ci.ci_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem-", "<b>$not2[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil-", "<b>$not2[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-profissao-", "<b>$not2[c_prof]</b>", $d_txt);
	$d_txt = str_replace("-rg-", "<b>$not2[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf-", "<b>$not2[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end-", "<b>$not2[c_end]</b>", $d_txt);
	$d_txt = str_replace("-bairro-", "<b>$not2[c_bairro]</b>", $d_txt);
	$d_txt = str_replace("-cidade-", "<b>$not2[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado-", "<b>$not2[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-cep-", "<b>$not2[c_cep]</b>", $d_txt);
	$d_txt = str_replace("-tel-", "<b>$not2[c_tel]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-local-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-matricula-", "<b>$not2[matricula]</b>", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$not2[ci_nome]</b>", $d_txt);
	
	
	$nome_cliente3 = '';

for ($i3 = 0; $i3 < $not2[contador]; $i3++) {

	$query4 = "select * from clientes where c_cod='" . $cliente2[$i3] . "' and cod_imobiliaria='" . $cod_im . "'";

	$result4 = mysql_query($query4);
	$res_clientes = array();
	
	while ($not4 = mysql_fetch_array($result4)) {
	    array_push($res_clientes, $not4[c_nome]);
	}
	
	$res_clientes = implode(" e ", $res_clientes);
	$nome_cliente3 .= empty($nome_cliente3) ? $res_clientes : " e " . $res_clientes;

}

	$d_txt = str_replace("-nome_prop-", "<b>$nome_cliente3</b>", $d_txt);
	
	
	$ano = date(Y);
	$mes = date(m);
	$dia = date(d);

	$d_txt = str_replace("-proposta-", "<b>$proposta</b>", $d_txt);
	$d_txt = str_replace("-data_hoje-", "<b>$dia/$mes/$ano</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);  
	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);  
	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);  
	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);  
	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);  
	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);  
	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  
	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);  
	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);

  	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
  	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	}
	}
	
$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" action="<?php print("$url"); ?>">
<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="compr" value="<?php print("$compr"); ?>">
<input type="hidden" name="impressao" value="1">
<input type="hidden" name="comprador" value="1">
<input type="hidden" name="imp" value="7">
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea></td></tr>
  <tr bgcolor="#ffffff"><td colspan=2>
<input type="submit" value="Finalizar Texto" class=campo3 name="B1"></td></tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="justify"><br><?php print("$txt"); ?></p><p></td></tr>
<?php
	}
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?></p></td></tr>
  <tr bgcolor="#EDEEEE">
    <td colspan=2 class="style1"><p><b>PROPONENTE COMPRADOR(A): <br>
      _________________________</b></p>
    <p></td>
    </tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>PROPRIETÁRIO(A): <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>CORRETOR(A): <br>
      _________________________</b></p>
    <p></td>
    </tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>TESTEMUNHA: <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>TESTEMUNHA: <br>
      _________________________</b></p>
    <p></td>
    </tr>
  </table>
<?php
	}
	}
	}
	}//Termina imp = 7
	elseif($imp == "9"){ //Contrato de Locação
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select * from muraski, clientes, rebri_tipo where muraski.cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.tipo=rebri_tipo.t_cod";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	}
	
	$query2 = "select * from muraski, clientes, rebri_tipo, rebri_cidades where muraski.cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=clientes.c_cod and muraski.tipo=rebri_tipo.t_cod and muraski.local=rebri_cidades.ci_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente10 = explode("--", $not2[cliente]);
	  $cliente20 = str_replace("-","",$cliente10);
	  
	  
	$qstr = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
    $qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $proprietarios = array();
    $origens = array();
    $es_civis = array();
    $rg_ie = array();
    $cpf_cnpj = array();
    $nacionalidades = array();
    $profissoes = array();
    $enderecos = array();
    $cidades = array();
    $ufs = array();
    $telefones = array();
    $celulares = array();
    $emails = array();
    $ceps = array();
    $representantes = array();
    $representantes2 = array();
    foreach ($res as $row) {
        array_push($proprietarios, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origens, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($es_civis, '<b>' . $row['c_civil'] . '</b>');
        }
        
        array_push($rg_ie, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_cnpj, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        if (!empty($row['c_nacionalidade'])) {
            array_push($nacionalidades, '<b>' . $row['c_nacionalidade'] . '</b>');
        }
        if (!empty($row['c_profissao'])) {
            array_push($profissoes, '<b>' . $row['c_profissao'] . '</b>');
        }
        array_push($enderecos, $row['c_end']);
        array_push($cidades, $row['c_cidade']);
        array_push($ufs, $row['c_estado']);
        array_push($telefones, $row['c_tel']);
        if (!empty($row['c_celular'])) {
            array_push($celulares, '<b>' . $row['c_celular'] . '</b>');
        }
        if (!empty($row['c_email'])) {
            array_push($emails, '<b>' . $row['c_email'] . '</b>');
        }
        if (!empty($row['c_cep'])) {
            array_push($ceps, '<b>' . $row['c_cep'] . '</b>');
        }
        if (!empty($row['c_repre'])) {
            array_push($representantes, 'Representante 1:<b> ' . $row['c_repre'] . '</b>');
        }
        if (!empty($row['c_repre2'])) {
            array_push($representantes2, 'Representante 2:<b> ' . $row['c_repre2'] . '</b>');
        }
    }
    $proprietarios = implode(' e ', $proprietarios);
    $origens = implode(' e ', $origens);
    $es_civis = implode(' e ', $es_civis);
    $rg_ie = implode(' e ', $rg_ie);
    $cpf_cnpj = implode(' e ', $cpf_cnpj);
    $nacionalidades = implode(' e ', $nacionalidades);
    $profissoes = implode(' e ', $profissoes);
    $enderecos = implode(' e ', $enderecos);
    $cidades = implode(' e ', $cidades);
    $ufs = implode(' e ', $ufs);
    $telefones = implode(' e ', $telefones);
    $celulares = implode(' e ', $celulares);
    $emails = implode(' e ', $emails);
    $ceps = implode(' e ', $ceps);
    $representantes = implode(' e ', $representantes);  
    $representantes2 = implode(' e ', $representantes2);  
	  
	$d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-naci_prop-", "$nacionalidades", $d_txt);
	$d_txt = str_replace("-prof_prop-", "$profissoes", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-tel_prop-", "<b>$telefones</b>", $d_txt);
	$d_txt = str_replace("-cel_prop-", "$celulares", $d_txt);
	$d_txt = str_replace("-email_prop-", "$emails", $d_txt);
	$d_txt = str_replace("-cep_prop-", "$ceps", $d_txt);
   	$d_txt = str_replace("-repre_prop-", "$representantes $representantes2", $d_txt);
	
	
	$d_txt = str_replace("-cid_imov-", "$not2[ci_nome]", $d_txt);
	$d_txt = str_replace("-end_imov-", "$not2[end]", $d_txt);
	$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "<b>".strip_tags($not2[titulo])."</b>", $d_txt);
	$d_txt = str_replace("-acomod-", "$not2[acomod]", $d_txt);
	

	$diaria2 = number_format($not2[diaria2], 2, ',', '.');
	
	$query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod 
	and l_cod='$l_cod'";
	//echo $query4;
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);

	while($not4 = mysql_fetch_array($result4))
	{
	$total = $not4[l_total] + $not4[l_limpeza];
	$total_extenso = extenso($total);
	//$total = $not4[l_total];
	$total_final = number_format($total, 2, ',', '.');
	$total_final_extenso = extenso($total_final);
	$total = number_format($not4[l_total], 2, ',', '.');
	$limpeza = number_format($not4[l_limpeza], 2, ',', '.');
	$tv = number_format($not4[l_tv], 2, ',', '.');
	
	$total_manu_extenso = extenso($tv);
	
	$ano = substr ($not4[l_data_ent], 0, 4);
	$mes = substr($not4[l_data_ent], 5, 2 );
	$dia = substr ($not4[l_data_ent], 8, 2 );
	$ano1 = substr ($not4[l_data_sai], 0, 4);
	$mes1 = substr($not4[l_data_sai], 5, 2 );
	$dia1 = substr ($not4[l_data_sai], 8, 2 );
	
	$data_ent = "$dia/$mes/$ano";
	$data_sai = "$dia1/$mes1/$ano1";

	$data = mktime(0,0,0, $mes, $dia, $ano);
	$data1 = mktime(0,0,0, $mes1, $dia1, $ano1);
	
	$total_dias = round((($data1 - $data)/(24*60*60)));
	$total_dias = $total_dias + 1;
	
	$d_txt = str_replace("-total_dias-", "<b>$total_dias</b>", $d_txt);
	$d_txt = str_replace("-data_ent-", "<b>$data_ent</b>", $d_txt);
	$d_txt = str_replace("-data_sai-", "<b>$data_sai</b>", $d_txt);
	$d_txt = str_replace("-total_final-", "<b>$total_final</b>", $d_txt);
	$d_txt = str_replace("-total_final_extenso-", "<b>$total_final_extenso</b>", $d_txt);
	$d_txt = str_replace("-total_manu-", "<b>$total_manu</b>", $d_txt);
	$d_txt = str_replace("-total_manu_extenso-", "<b>$total_manu_extenso</b>", $d_txt);
	$d_txt = str_replace("-total-", "<b>$total</b>", $d_txt);
	$d_txt = str_replace("-total_extenso-", "<b>$total_extenso</b>", $d_txt);
	$d_txt = str_replace("-limpeza-", "<b>$limpeza</b>", $d_txt);
	$d_txt = str_replace("-limpeza-", "", $d_txt);
	$d_txt = str_replace("-tv-", "<b>$tv</b>", $d_txt);
	$d_txt = str_replace("-l_pagto-", "<b>$not4[l_pagto]</b>", $d_txt);
	$d_txt = str_replace("-nome_loc-", "<b>$not4[c_nome]</b>", $d_txt);
	$d_txt = str_replace("-origem_loc-", "<b>$not4[c_origem]</b>", $d_txt);
	$d_txt = str_replace("-civil_loc-", "<b>$not4[c_civil]</b>", $d_txt);
	$d_txt = str_replace("-rg_loc-", "<b>$not4[c_rg]</b>", $d_txt);
	$d_txt = str_replace("-cpf_loc-", "<b>$not4[c_cpf]</b>", $d_txt);
	$d_txt = str_replace("-end_loc-", "<b>$not4[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cep_loc-", "<b>$not4[c_cep]</b>", $d_txt);
	$d_txt = str_replace("-cidade_loc-", "<b>$not4[c_cidade]</b>", $d_txt);
	$d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	$d_txt = str_replace("-tel_loc-", "<b>$not4[c_tel], $not4[c_cel]</b>", $d_txt);
	//$d_txt = str_replace("-usuario-", "$not4[l_usuario]", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
   $num_rows = mysql_num_rows($busca);
   if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{

   	$d_txt = str_replace("-prop_im-", "<b>$linha[im_contato]</b>", $d_txt);
   	$d_txt = str_replace("-nacionalidade_im-", "<b>$linha[im_nacionalidade]</b>", $d_txt);
   	$d_txt = str_replace("-est_civil_im-", "<b>$linha[im_est_civil]</b>", $d_txt);
   	$d_txt = str_replace("-n_conselho_im-", "<b>$linha[im_n_conselho]</b>", $d_txt);
   	$d_txt = str_replace("-end_im-", "<b>$linha[im_end]</b>", $d_txt);
   	$d_txt = str_replace("-cidade_im-", "<b>$linha[ci_nome]</b>", $d_txt);
   	$d_txt = str_replace("-uf_im-", "<b>$linha[e_uf]</b>", $d_txt);
   	$d_txt = str_replace("-site_im-", "<b>$linha[im_site]</b>", $d_txt);
   	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);
   	$d_txt = str_replace("-cep_im-", "<b>$linha[im_cep]</b>", $d_txt);
   	$d_txt = str_replace("-cnpj_im-", "<b>$linha[im_cnpj]</b>", $d_txt);
   	$d_txt = str_replace("-bairro_im-", "<b>$linha[im_bairro]</b>", $d_txt);

     	$d_txt = str_replace("-im_resp-", "<b>$linha[im_resp]</b>", $d_txt);
     	$d_txt = str_replace("-im_creci_resp-", "<b>$linha[im_creci_resp]</b>", $d_txt);
     	$d_txt = str_replace("-im_razao-", "<b>$linha[im_razao]</b>", $d_txt);

	}
	}

$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
	<style media="print">
		.noprint { display: none }
	</style>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" action="<?php print("$url"); ?>">
<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$l_cod"); ?>">
<input type="hidden" name="impressao" value="1">
<input type="hidden" name="imp" value="9">
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea></td></tr>
  <tr bgcolor="#ffffff"><td colspan=2>
<input type="submit" value="Finalizar Texto" class=campo3 name="B1"></td></tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="justify"><br><?php print("$txt"); ?></p><p></td></tr>
<?php
	}
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?></p></td></tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>LOCATÁRIO(A): <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>LOCADOR(A): <br>
      _________________________</b></p>
      <p></td>
    </tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>TESTEMUNHA: <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>TESTEMUNHA: <br>
      _________________________</b></p>
    <p></td>
    </tr>
	  <tr bgcolor="#EDEEEE">
    <td colspan="2" class="style1">Usuário (uso interno): 
<?
	$busca_usuario = mysql_query("SELECT u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_cod='".$not4['l_usuario']."'");
	while($linha = mysql_fetch_array($busca_usuario))
	{
        echo $linha['u_nome'];	   
	}
?> 	
	</td>
    </tr>
  </table>
    <div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style1">
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
		<input type="submit" value="Exportar para DOC" name="exportar" id="exportar" class="campo3 noprint">
		</form>
<? } ?>
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()">
	  </span></div></td>
    </tr>
</div>
<?php

	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4
	elseif($imp == "10"){ //Contrato de Locação Mensal
	
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select * from muraski, clientes, rebri_tipo where muraski.cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.tipo=rebri_tipo.t_cod";
	$result20 = mysql_query($query20);
	$numrows20 = mysql_num_rows($result20);
	while($not2 = mysql_fetch_array($result20))
	{
	  $contador = $not2[contador];  
	  $cod_cliente = $not2[cliente];  
	  $cliente1 = explode("--", $not2[cliente]);
	  $cliente2 = str_replace("-","",$cliente1);
	}
	
	for($i3 = 1; $i3 <= $contador; $i3++){
		$cod_cliente2 = $cliente2[$i3-1];
	}
	
	$query2 = "select * from muraski, clientes, rebri_tipo, rebri_cidades, rebri_estados where muraski.cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=clientes.c_cod and muraski.tipo=rebri_tipo.t_cod and muraski.local=rebri_cidades.ci_cod and muraski.uf=rebri_estados.e_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	  
	  $cliente10 = explode("--", $not2[cliente]);
	  $cliente20 = str_replace("-","",$cliente10);
	  
	  $bairro10 = explode("--", $not2[bairro]);
	  $bairro20 = str_replace("-","",$bairro10);
	  
	$qstr = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $proprietarios = array();
    $origens = array();
    $es_civis = array();
    $rg_ie = array();
    $cpf_cnpj = array();
    $profissoes = array();
    $enderecos = array();
    $cidades = array();
    $ufs = array();
    $endereco_com = array();
    $cidade_com = array();
    $estado_com = array();
    foreach ($res as $row) {
        array_push($proprietarios, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origens, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($es_civis, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_ie, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_cnpj, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        if (!empty($row['c_prof'])) {
            array_push($profissoes, '<b>' . $row['c_prof'] . '</b>');
        }
        array_push($enderecos, $row['c_end']);
        array_push($cidades, $row['c_cidade']);
        array_push($ufs, $row['c_estado']);
        if (!empty($row['c_end_com'])) {
            array_push($endereco_com, '<b> ' . $row['c_end_com'] . '</b>');
        }
        if (!empty($row['c_cidade_com'])) {
            array_push($cidade_com, '<b> ' . $row['c_cidade_com'] . '</b>');
        }
        if (!empty($row['c_estado_com'])) {
            array_push($estado_com, '<b> ' . $row['c_estado_com'] . '</b>');
        }
    }
    $proprietarios = implode(' e ', $proprietarios);
    $origens = implode(' e ', $origens);
    $es_civis = implode(' e ', $es_civis);
    $rg_ie = implode(' e ', $rg_ie);
    $cpf_cnpj = implode(' e ', $cpf_cnpj);
    $profissoes = implode(' e ', $profissoes);
    $enderecos = implode(' e ', $enderecos);
    $cidades = implode(' e ', $cidades);
    $ufs = implode(' e ', $ufs);
    $endereco_com = implode(' e ', $endereco_com);  
    $cidade_com = implode(' e ', $cidade_com);  
    $estado_com = implode(' e ', $estado_com);  
        
	if($not2[bairro]<>''){
	$qstr2 = "select * from rebri_bairros where b_cod in (" . implode(',',$bairro20) . ")";
    $qres2 = mysql_query($qstr2);

    $res2 = array();
    while ($rw2 = mysql_fetch_assoc($qres2)) {
        array_push($res2, $rw2);
    }
    
    $bairros = array();
    foreach ($res2 as $row2) {
        if (!empty($row2['b_nome'])) {
            array_push($bairros, '<b>' . $row2['b_nome'] . '</b>');
        }
    }
    $bairros = implode(' e ', $bairros);
    }
	
	$d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-prof_prop-", "$profissoes", $d_txt);
	$d_txt = str_replace("-rg_prop-", "$rg_ie", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "$cpf_cnpj", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
   	$d_txt = str_replace("-end_comercial-", "$endereco_com", $d_txt);
   	$d_txt = str_replace("-cidade_comercial-", "$cidade_com", $d_txt);
   	$d_txt = str_replace("-estado_comercial-", "$estado_com", $d_txt);
	
	$query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod and l_cod='$l_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
	  
	$ano = substr ($not4[l_data_ent], 0, 4);
	$mes = substr($not4[l_data_ent], 5, 2 );
	$dia = substr ($not4[l_data_ent], 8, 2 );
	$ano1 = substr ($not4[l_data_sai], 0, 4);
	$mes1 = substr($not4[l_data_sai], 5, 2 );
	$dia1 = substr ($not4[l_data_sai], 8, 2 );
	
	$data_ini = "$dia/$mes/$ano"; 
	$data_fim = "$dia1/$mes1/$ano1";
	
	$qtd_contas = retornaDifMeses($data_ini, $data_fim);
	
	$valor_total = ($not4[l_total] * $qtd_contas);
	$valor_total_extenso = extenso($valor_total);
	
	$dia_venc = $not4[l_venc_aluguel];
	$atraso = $not4[l_tolerancia];
	$atraso_extenso = numero_extenso($atraso);
	$bonificacao = ($not4[l_bonificacao] / 100);
	$valor_bonificacao = ($valor_total * $bonificacao);
	$valor_bonificacao_extenso = extenso($valor_bonificacao);
	$valor_total_desconto = ($valor_total - $valor_bonificacao);
	$valor_total_desconto_extenso = extenso($valor_total_desconto);
	$pagamentos = ($valor_total_desconto / 4);
	$pagamentos_extenso = extenso($pagamentos);
	
	$d_txt = str_replace("-data_ini-", "<b>$data_ini</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$data_fim</b>", $d_txt);
	$d_txt = str_replace("-valor_contrato-", "<b>$valor_total ($valor_total_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_bonificacao-", "<b>$valor_bonificacao ($valor_bonificacao_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_total_desconto-", "<b>$valor_total_desconto ($valor_total_desconto_extenso)</b>", $d_txt);
	$d_txt = str_replace("-pagamentos-", "<b>$pagamentos ($pagamentos_extenso)</b>", $d_txt);
	$d_txt = str_replace("-atraso-", "<b>$atraso ($atraso_extenso)</b>", $d_txt);
	
	$query47 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_fiador=c_cod and l_cod='$l_cod'";
	$result47 = mysql_query($query47);
	$numrows47 = mysql_num_rows($result47);
	while($not47 = mysql_fetch_array($result47))
	{
	   $nome_fiador = $not47[c_nome];
	   $rg_fiador = $not47[c_rg];
	   $cpf_fiador = $not47[c_cpf];    
	   $origem_fiador = $not47[c_origem];
	   $prof_fiador = $not47[c_prof];
	   $civil_fiador = $not47[c_civil];
	   $endereco_fiador = $not47[c_end];
	   $bairro_fiador = $not47[c_bairro];
	   $cidade_fiador = $not47[c_cidade];
	   $estado_fiador = $not47[c_estado];
	   $cep_fiador = $not47[c_cep];
	   
	   $d_txt = str_replace("-nome_fiador-", "<b>$nome_fiador</b>", $d_txt);
	   $d_txt = str_replace("-rg_fiador-", "<b>$rg_fiador</b>", $d_txt);
	   $d_txt = str_replace("-cpf_fiador-", "<b>$cpf_fiador</b>", $d_txt);
	   $d_txt = str_replace("-origem_fiador-", "<b>$origem_fiador</b>", $d_txt);
	   $d_txt = str_replace("-prof_fiador-", "<b>$prof_fiador</b>", $d_txt);
	   $d_txt = str_replace("-civil_fiador-", "<b>$civil_fiador</b>", $d_txt);
	   $d_txt = str_replace("-endereco_fiador-", "<b>$endereco_fiador</b>", $d_txt);
	   $d_txt = str_replace("-bairro_fiador-", "<b>$bairro_fiador</b>", $d_txt);
	   $d_txt = str_replace("-cidade_fiador-", "<b>$cidade_fiador</b>", $d_txt);
	   $d_txt = str_replace("-estado_fiador-", "<b>$estado_fiador</b>", $d_txt); 
	   $d_txt = str_replace("-cep_fiador-", "<b>$cep_fiador</b>", $d_txt); 
	   
	}  
	
	$query46 = "select * from locacao, contas where co_locacao='$l_cod' and co_imovel='$cod' and contas.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and contas.co_locacao=locacao.l_cod and contas.co_tipo='Locação' AND contas.co_cat='Receber' ORDER BY contas.co_data ASC LIMIT 0,1";
	$result46 = mysql_query($query46);
	$numrows46 = mysql_num_rows($result46);
	while($not46 = mysql_fetch_array($result46))
	{
	    $valor_aluguel = $not46[co_valor];
		$valor_aluguel_extenso = extenso($valor_aluguel);
		
		$ano_venc = substr($not46[co_data], 0, 4);
		$mes_venc = substr($not46[co_data], 5, 2 );
		$dia_venc = substr($not46[co_data], 8, 2 );
		
		$data_venc = "$dia_venc/$mes_venc/$ano_venc"; 
		
		$d_txt = str_replace("-valor_aluguel-", "<b>$valor_aluguel ($valor_aluguel_extenso)</b>", $d_txt);
		$d_txt = str_replace("-dia_venc-", "<b>$dia_venc</b>", $d_txt);
		$d_txt = str_replace("-data_venc-", "<b>$data_venc</b>", $d_txt);
	}
	
    $texto1 = "Representada pelos seus sócios abaixo qualificados";
    $texto2 = ", neste ato representado pelos sócios";
		
	$d_txt = str_replace("-nome_loc-", "<b>$not4[c_nome]</b>", $d_txt);
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-rg_loc-", " RG: <b>$not4[c_rg]</b>", $d_txt);  
		$d_txt = str_replace("-rg2_loc-", " RG: <b>$not4[c_rg]</b>", $d_txt);
	}else{
	    $d_txt = str_replace("-rg_loc-", " Inscrição Estadual: <b>$not4[c_rg]</b>. $texto1", $d_txt);   
	    $d_txt = str_replace("-rg2_loc-", " Inscrição Estadual: <b>$not4[c_rg]</b> $texto2", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-cpf_loc-", "portador do CPF: <b>$not4[c_cpf]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-cpf_loc-", "inscrito no CNPJ: <b>$not4[c_cpf]</b>", $d_txt);
	}
	

	if($not4[c_tipo_pessoa]=='J'){
	  if($not4[c_repre2]<>''){
	     $var = "e";
	  }  
		$d_txt = str_replace("-repre1_prop-", "<b>$not4[c_repre]</b> $var", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "<b>$not4[c_repre2]</b>", $d_txt);
   	}else{
	 	$d_txt = str_replace("-repre1_prop-", "", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "", $d_txt);    
	}
	
	$d_txt = str_replace("-cidade_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-estado_imov-", "<b>$not2[e_uf]</b>", $d_txt);
	$d_txt = str_replace("-bairro_imov-", "<b>$bairros</b>", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[end]</b>", $d_txt);
	$d_txt = str_replace("-matricula_imov-", "<b>$not2[ref]</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-cidade_imo-", "$linha[ci_nome]", $d_txt);  

	}
	}

$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
	<style media="print">
		.noprint { display: none }
	</style>
<div align="center">
  <center>
  <table border="0" cellspacing="1" width="650" bgcolor="#EDEEEE">
  <tr bgcolor="#EDEEEE"><td colspan=2 class="style1">
<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p></td></tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" action="<?php print("$url"); ?>">
<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
<input type="hidden" name="l_cod" value="<?php print("$l_cod"); ?>">
<input type="hidden" name="impressao" value="1">
<input type="hidden" name="imp" value=10>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea></td></tr>
  <tr bgcolor="#ffffff"><td colspan=2>
<input type="submit" value="Finalizar Texto" class=campo3 name="B1"></td></tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="justify"><br><?php print("$txt"); ?></p><p></td></tr>
<?php
	}
?>
  <tr bgcolor="#ffffff"><td colspan=2 class="style1">
<p align="left"><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?></p></td></tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>LOCATÁRIO(A): <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>LOCADOR(A): <br>
      _________________________</b></p>
      <p></td>
    </tr>
  <tr bgcolor="#EDEEEE">
    <td width="50%" class="style1"><p><b>TESTEMUNHA 1: <br>
      _________________________</b></p>
    <p></td>
    <td width="50%" class="style1"><p><b>TESTEMUNHA 2: <br>
      _________________________</b></p>
    <p></td>
    </tr>
    <tr bgcolor="#EDEEEE">
    <td width="50%" colspan="2" class="style1"><p><b>FIADOR: <br>
      _________________________</b></p>
    <p></td>
    </tr>
	  <tr bgcolor="#EDEEEE">
    <td colspan="2" class="style1">Usuário (uso interno): 
<?
	$busca_usuario = mysql_query("SELECT u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_cod='".$not4['l_usuario']."'");
	while($linha = mysql_fetch_array($busca_usuario))
	{
        echo $linha['u_nome'];	   
	}
?>     
	</td>
    </tr>
  </table>
    <div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style1">
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
		<input type="submit" value="Exportar para DOC" name="exportar" id="exportar" class="campo3 noprint">
		</form>
<? } ?>
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()">
	  </span></div></td>
    </tr>
</div>
<?php

	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4

//mysql_free_result($result2);
//mysql_free_result($result3);
mysql_close($con);
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
</body>
</html>

<? } ?>