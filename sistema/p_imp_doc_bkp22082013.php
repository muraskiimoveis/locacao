<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
ob_start();
include("conect.php");
include("l_funcoes.php");
include("funcoes/funcoes.php");
verificaAcesso();
verificaArea("DOCS");

if($_GET['mostra']){
  $mostra = $_GET['mostra'];
}else{
  $mostra = $_POST['mostra'];
}

if($_GET['verificacao']){
  $verificacao = $_GET['verificacao'];
}else{
  $verificacao = $_POST['verificacao'];
}

if($_GET['gera_contrato']){
  $gera_contrato = $_GET['gera_contrato'];
}else{
  $gera_contrato = $_POST['gera_contrato'];
}

if($_POST['pdf']=='1'){


$imp = $_GET['imp'];
$cod = $_GET['cod'];
$l_cod = $_GET['l_cod'];
$impressao2 = $_POST['impressao2'];


	if($imp == "2"){ // Locação
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3) or die ("Erro 31");
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20) or die ("Erro 36");
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
	$result2 = mysql_query($query2) or die ("Erro 51");
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	  $cliente10 = explode("--", $not2[cliente]);
	  $cliente20 = str_replace("-","",$cliente10);
	
	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450) or die ("Erro 61");
	$cont20 = 0;
	$dados_prop = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
    	$tel_prop = "<b>".$not450[c_tel]."</b>";
		if($not450[c_tipo_pessoa]=='J'){
			if($not450[c_repre]<>''){
				$representantes = " Representante 1: <b>".$not450[c_repre]."</b>";
			}else{
		  		$representantes = "";
			}
			if($not450[c_repre2]<>''){
    			$representantes2 = " Representante 2: <b>".$not450[c_repre2]."</b>";
    		}else{
		  		$representantes2 = "";
			}
		}
		$repre_prop = "$representantes $representantes2";
		
		if($cont20>0){
			$var20 = " e ";
		}
	
 		$dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", residente e domiciliado na ".$endereco_prop.", cidade de ".$cidade_prop."/".$estado_prop.", fone: ".$tel_prop;	  		
			
 	$cont20++;
	}
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $not3[d_txt]);
	
	/*
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
	*/
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
	
	$d_txt = str_replace("-titulo_imov-", "<b>$not2[titulo]</b>", $d_txt);
	$d_txt = str_replace("-cid_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	//$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);

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
	
	$diaria1_extenso = extenso($not2[diaria1]);
	$diaria2_extenso = extenso($not2[diaria2]);
		
	$comissao = number_format($not2[comissao], 2, ',', '.');
	$comissao_extenso = numero_extenso($not2[comissao]);
	
	$d_txt = str_replace("-diaria1-", "<b>$diaria1</b>", $d_txt);
	$d_txt = str_replace("-diaria2-", "<b>$diaria2</b>", $d_txt);
	
	$d_txt = str_replace("-diaria1_extenso-", "$diaria1_extenso", $d_txt);
	$d_txt = str_replace("-diaria2_extenso-", "$diaria2_extenso", $d_txt);
		
	$d_txt = str_replace("-comissao-", "<b>$not2[comissao] %</b>", $d_txt);
	$d_txt = str_replace("-comissao_extenso-", "$comissao_extenso", $d_txt);
	
	$d_txt = str_replace("-conta-", "<b>$not2[c_banco] $not2[c_conta]</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL) or die ("Erro 234");
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

$html10 .='<page><table border="0" cellspacing="1" width="800">
  			<tr>
    			<td colspan="2" style="text-align:left;" width="50">';
	
					$logo_imob = $_SESSION['logo_imob'];
    				$caminho_logo = "../logos/";
					if (file_exists($caminho_logo.$logo_imob))
					{
						$html10 .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
					}
	
	$html10 .='</td>
  			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:center;"><b>'.$not3[d_nome].'</b></td>
			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>';
			
$estilo = 'style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:justify;"';

$d_txt = str_replace("\n","<br />","$d_txt");

$html10 .='<tr>
			<td colspan="2" '.$estilo.'>'.$d_txt.'</td>
		 </tr>';

$html10 .='<tr>
			<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:left;"><b>'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].' , '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>PROPRIETÁRIO(A): <br>
      			_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>CORRETOR(A):<br> 
      			_________________________</b></td>
    	</tr>
  		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA:<br> 
      			_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA: <br>
      			_________________________</b></td>
    	</tr>
    	<tr>
	  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />
         www.redebrasileiradeimoveis.com.br
	  </td>
    </tr>
  	</table></page>';

	}
	}
	}
	}//Termina imp = 2
	elseif($imp == "5"){ // Venda
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3) or die ("Erro 318");
	while($not3 = mysql_fetch_array($result3))
	{

	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result20 = mysql_query($query20) or die ("Erro 323");
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
	
	$query2 = "select *, ci2.ci_nome as localizacao from muraski m, clientes c, rebri_cidades ci, rebri_cidades ci2, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=c.c_cod and m.cidade_mat=ci.ci_cod and m.local=ci2.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
	$result2 = mysql_query($query2) or die ("Erro 338");
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
	//$d_txt = str_replace("-desc_imovel-", "<b>".strip_tags($not2[descricao])."</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	
	//$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "<b>".strip_tags($not2[titulo])."</b>", $d_txt);
	
	if($not2[local]<>$_SESSION['cod_cidadei']){
	  $variavel = ", na cidade de ".$not2[localizacao].".";
	}else{
	  $variavel = ", nesta cidade.";
	}
	
	
	$d_txt = str_replace("-end_imovel-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b> $variavel", $d_txt);
	$d_txt = str_replace("-uf_imovel-", "<b>$not2[e_nome]</b>", $d_txt);
	
	$valor = number_format($not2[valor], 2, ',', '.');
	$valor_extenso = extenso($not2[valor]);
	
	$d_txt = str_replace("-valor-", "<b>$valor ($valor_extenso)</b>", $d_txt);
	
	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );

	$d_txt = str_replace("-data_inicio-", "<b>$dia/$mes/$ano</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$dia1/$mes1/$ano1</b>", $d_txt);
	
	$comissao = number_format($not2[comissao], 2, ',', '.');
	$comissao_extenso = numero_extenso($not2[comissao]);
	
	$d_txt = str_replace("-com_venda-", "<b>$not2[comissao] %</b>", $d_txt);
	$d_txt = str_replace("-com_venda_extenso-", "$comissao_extenso", $d_txt);

	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450) or die ("Erro 390");
	$cont20 = 0;
	$dados_prop = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
            if(Trim($not450[c_conjuge])!=''){
         		$c_conjuge = " <b>".$not450[c_conjuge]."</b>";
		     	$rg_conjuge = " <b>RG: ".$not450[c_rg_conjuge]."</b>";
			    $cpf_conjuge = " <b>CPF: ".$not450[c_cpf_conjuge]."</b>";			
            }
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
    	$tel_prop = "<b>".$not450[c_tel]."</b>";
		if($not450[c_tipo_pessoa]=='J'){
			if($not450[c_repre]<>''){
				$representantes = " Representante 1: <b>".$not450[c_repre]."</b>";
			}else{
		  		$representantes = "";
			}
			if($not450[c_repre2]<>''){
    			$representantes2 = " Representante 2: <b>".$not450[c_repre2]."</b>";
    		}else{
		  		$representantes2 = "";
			}
		}
		$repre_prop = "$representantes $representantes2";
		
		if($cont20>0){
			$var20 = " e ";
		}
        
		if(Trim($not450[c_conjuge])==''){	
 		  $dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", com residência na ".$endereco_prop.", ".$cidade_prop.", ".$estado_prop.", Tel.: ".$tel_prop.$repre_prop;
	    }else{
          $dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop." e conjuge,  ".$c_conjuge.",  ".$rg_conjuge." e ".$cpf_conjuge.", ambos com residência na ".$endereco_prop.", ".$cidade_prop.", ".$estado_prop.", Tel.: ".$tel_prop.$repre_prop;			   	
	    }

			
 	$cont20++;
	}
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $d_txt);
	
	/*
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
	*/	
   	
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL) or die ("Erro 514");
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

$html10 .='<page><table border="0" cellspacing="1" width="800">
			<tr>
    			<td colspan="2" style="text-align:left;" width="50">';
	
					$logo_imob = $_SESSION['logo_imob'];
    				$caminho_logo = "../logos/";
					if (file_exists($caminho_logo.$logo_imob))
					{
						$html10 .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
					}
	
	$html10 .='</td>
  			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>
  			<tr>
			  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:center;"><b>'.$not3[d_nome].'</b></td>
			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>';

$estilo = 'style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:justify;"';

$d_txt = str_replace("\n","<br />","$d_txt");

$html10 .='<tr>
			<td colspan="2" '.$estilo.'>'.$d_txt.'</td>
		 </tr>';

$html10 .='<tr>
			<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:left;"><b> '.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>PROPRIETÁRIO(A): <br>
      			_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>CORRETOR(A):<br> 
      			_________________________</b></td>
    	</tr>
<?php
  if(isset($c_conjuge)){
?>
		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>CONJUGE PROPRIETÁRIO(A): <br>
      			_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b><br></b></td>
    	</tr>
<?php
}
?>
  		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA:<br> 
      			_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA: <br>
      			_________________________</b></td>
    	</tr>
    		<tr>
	  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />
         www.redebrasileiradeimoveis.com.br
	  </td>
    </tr>
  </table></page>';

	}
	}
	}
	}//Termina imp = 5
	elseif($imp == "4"){
	
	if ($gera_contrato=='S') {
	  	  
   $t_cod = explode("--", $c_cod);
   $t_cod = str_replace("-","",$t_cod);
   if (count($t_cod) > 1) {
?>
		<table width="100%">
 			<tr>
  				<td align="center" class="style7"><table cellpadding="0" cellspacing="1" width="75%">
    				<tr>
       					<td align="center" colspan="4" height="50" class="style1" ><strong>Imprimir Renovação</strong><br />
          			Selecione o cliente que deseja imprimir o contrato de renovação</td></tr>
<?      
   $i = 0;
   foreach ($t_cod as $cli) {
      if ($i==0) {
		   $p_cod = "AND (c_cod = '$cli' ";
      } else {
		   $p_cod .= " OR c_cod = '$cli' ";
      }
      $i++;
   }
   $p_cod .= ")";
	$query3 = "select * from clientes where 1=1 $p_cod and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   $rs3 = mysql_query($query3) or die ("Erro 1587");
?>

<tr>
<td width=230 class="fundoTabelaTitulo style1"><b>
<p align="center">Nome / Razão Social</p></td>
<td width=200 class="fundoTabelaTitulo style1"><b>
<p align="center">CPF / CNPJ</p></td>
<td width=200 class="fundoTabelaTitulo style1"><b>
<p align="center">Telefone</p></td>
<td width=100 class="fundoTabelaTitulo style1"><b>
<p align="center">Tipo</p></td>
</tr>

<?
   $i = 0;
   while ($not3 = mysql_fetch_assoc($rs3)) {
      if ($i % 2 == 0) { $cor = "fundoTabelaCor1"; } else {$cor = "fundoTabelaCor2"; }
?>
      <tr class="<?=$cor?>">
       <td align="left" class="style1"><a class="style1" href="p_imp_doc.php?cod=<?=$cod ?>&c_cod=<?=$not3[c_cod]?>&imp=4"><?=$not3[c_nome]?></a></td>
       <td align="center" class="style1"><a class="style1" href="p_imp_doc.php?cod=<?=$cod ?>&c_cod=<?=$not3[c_cod]?>&imp=4"><?=$not3[c_cpf]?></a></td>
       <td align="center" class="style1"><a class="style1" href="p_imp_doc.php?cod=<?=$cod ?>&c_cod=<?=$not3[c_cod]?>&imp=4"><?=$not3[c_tel]?></a></td>
       <td align="center" class="style1"><a class="style1" href="p_imp_doc.php?cod=<?=$cod ?>&c_cod=<?=$not3[c_cod]?>&imp=4"><?=$not3[c_tipo]?>
       <?
       if ($not3[c_tipo2] <> "") {
         $t_tipo = explode("--", $not3[c_tipo2]);
         $t_tipo = str_replace("-", "", $t_tipo);
         if (count($t_tipo) > 0) {
            foreach ($t_tipo as $tipo) {
               $tsql = "SELECT tc_tipo FROM tipos_clientes WHERE tc_cod = '$tipo'";
               $trs = mysql_query($tsql) or die ("Erro 1617");
               $tnot = mysql_fetch_assoc($trs);
               echo " " . $tnot[tc_tipo];
            }
         }
       }
       ?>
       </a></td></tr>
<?
      $i++;
   }
?>



   </table>
  </td>
 </tr>
</table>
<?
   } else {
      $c_cod = $t_cod[0];
   }
}  
	  

	$query30 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result30 = mysql_query($query30);
	while($not3 = mysql_fetch_array($result30))
	{
	  
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	  
	
	//$query2 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '".$cod_cliente."' and $cod_cliente2";
	$query2 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and clientes.c_cod='".$c_cod."'";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
		
	$not2[titulo] = strip_tags($not2[titulo],'<b>');
		
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	//$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	
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

$html10 .='<page><table border="0" cellspacing="1" width="800">
			<tr>
    			<td style="text-align:left;" width="50">';
	
					$logo_imob = $_SESSION['logo_imob'];
    				$caminho_logo = "../logos/";
					if (file_exists($caminho_logo.$logo_imob))
					{
						$html10 .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
					}
	
	$html10 .='</td>
  			</tr>
			<tr>
			  <td>&nbsp;</td>
			</tr>
  			<tr>
			  <td style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:center;"><b>'.$not3[d_nome].'</b></td>
			</tr>
			<tr>
			  <td>';

$d_txt = str_replace("\n","<br/ >","$d_txt");

$html10 .='</td>
			</tr>';
$html10 .='<tr>
			<td '.$estilo.'>'.$d_txt.'</td>
		 </tr>';

$html10 .='	<tr>
			  <td>&nbsp;</td>
			</tr>
		<tr>
	  <td  style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:center;">Rede Brasileira de Imóveis<BR />
         www.redebrasileiradeimoveis.com.br
	  </td>
    </tr>


</table></page>';

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
	$query1 = "select c_cod, c_nome from clientes where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'
   	order by c_tipo, c_nome, c_cod";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	while($not1 = mysql_fetch_array($result1))
	{
	 $c_nome = substr ($not1[c_nome], 0, 30);

	$html10 .='<option value='.$not1[c_cod].' title="'.$not1['c_nome'].'">'.$c_nome.'</option>';

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
	
	$bcidademat = mysql_query("SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$not2['cidade_mat']."'");
	while($linha = mysql_fetch_array($bcidademat)){
	    $cidade_mat = $linha['ci_nome'];
	}
	
	$blocal = mysql_query("SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$not2['local']."'");
	while($linha = mysql_fetch_array($blocal)){
	    $local = $linha['ci_nome'];
	}
	
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
	//$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	$d_txt = str_replace("-local-", "<b>$local</b>", $d_txt);
	$d_txt = str_replace("-matricula-", "<b>$not2[matricula]</b>", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$cidade_mat</b>", $d_txt);
	
	
	$nome_cliente3 = '';

for ($i3 = 0; $i3 < $not2[contador]; $i3++) {

	$query4 = "select * from clientes where c_cod='" . $cliente2[$i3] . "' and cod_imobiliaria='" . $_SESSION['cod_imobiliaria'] . "'";

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

$html10 .='<page><table border="0" cellspacing="1" width="800">
			<tr>
    			<td colspan="2" style="text-align:left;" width="50">';
	
					$logo_imob = $_SESSION['logo_imob'];
    				$caminho_logo = "../logos/";
					if (file_exists($caminho_logo.$logo_imob))
					{
						$html10 .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
					}
	
	$html10 .='</td>
  			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>
  			<tr>
			  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:center;"><b>'.$not3[d_nome].'</b></td>
			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>';

$estilo = 'style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:justify;"';

$d_txt = str_replace("\n","</td></tr><tr><td colspan=\"2\" ".$estilo.">","$d_txt");

$html10 .='<tr>
			<td colspan="2" '.$estilo.'>'.$d_txt.'</td>
		 </tr>';


$html10 .='<tr>
			<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:left;"><b>'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		 </tr>
		 <tr>
    		<td width="50" colspan="2" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br>PROPONENTE COMPRADOR(A):<br> 
      		_________________________</b></td>
    	</tr>
  		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>PROPRIETÁRIO(A): <br>
      		_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>CORRETOR(A):<br> 
      		_________________________</b></td>
    	</tr>
  		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA:<br> 
      		_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA:<br> 
      		_________________________</b></td>
    	</tr>
    		<tr>
	  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />
         www.redebrasileiradeimoveis.com.br
	  </td>
    </tr>
  	</table></page>';

	}
	}
	}
	}//Termina imp = 7
	elseif($imp == "9"){ //Contrato de Locação
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	  
	  
	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450);
	$cont20 = 0;
	$dados_prop = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
		if($not450[c_tipo_pessoa]=='J'){
			if($not450[c_repre]<>''){
				$representantes = " Representante 1: <b>".$not450[c_repre]."</b>";
			}else{
		  		$representantes = "";
			}
			if($not450[c_repre2]<>''){
    			$representantes2 = " Representante 2: <b>".$not450[c_repre2]."</b>";
    		}else{
		  		$representantes2 = "";
			}
		}
		$repre_prop = "$representantes $representantes2";
		
		if($cont20>0){
			$var20 = " e ";
		}
	
 		$dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", residente na ".$endereco_prop.", ".$cidade_prop.", ".$estado_prop.$repre_prop;	  		
			
 	$cont20++;
	}
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $not3[d_txt]);
	
	/*
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
	*/
	
	$d_txt = str_replace("-cid_imov-", "$not2[ci_nome]", $d_txt);
	$d_txt = str_replace("-end_imov-", "$not2[tipo_logradouro] $not2[end], $not2[numero]", $d_txt);
	//$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
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
	$total_extenso = extenso($not4[l_total]);
	//$total = $not4[l_total];
	$total_final = number_format($total, 2, ',', '.');
	$total_final_extenso = extenso($total);
	$total = number_format($not4[l_total], 2, ',', '.');
	$limpeza = number_format($not4[l_limpeza], 2, ',', '.');
	$tv = number_format($not4[l_tv], 2, ',', '.');
	$extenso_limpeza = extenso($not4[l_limpeza]);
	
	$total_manu_extenso = extenso($not4[l_tv]);
	
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
	
	$pagto = str_replace("$total_final","$total_final ($total_final_extenso)", $not4[l_pagto]);
	
	$d_txt = str_replace("-total_dias-", "<b>$total_dias</b>", $d_txt);
	$d_txt = str_replace("-data_ent-", "<b>$data_ent</b>", $d_txt);
	$d_txt = str_replace("-data_sai-", "<b>$data_sai</b>", $d_txt);
	$d_txt = str_replace("-total_final-", "<b>$total_final</b> ($total_final_extenso)", $d_txt);
	$d_txt = str_replace("-total_final_extenso-", "<b>$total_final_extenso</b>", $d_txt);
	$d_txt = str_replace("-total_manu-", "<b>$total_manu</b>", $d_txt);
	$d_txt = str_replace("-total_manu_extenso-", "<b>$total_manu_extenso</b>", $d_txt);
	$d_txt = str_replace("-total-", "R$ <b>$total</b> - $total_extenso", $d_txt);
	$d_txt = str_replace("-total_extenso-", "<b>$total_extenso</b>", $d_txt);
	$d_txt = str_replace("-limpeza-", "R$ <b>$limpeza</b> - $extenso_limpeza", $d_txt);
	$d_txt = str_replace("-limpeza-", "", $d_txt);
	$d_txt = str_replace("-tv-", "<b>$tv</b>", $d_txt);
	$d_txt = str_replace("-l_pagto-", "$pagto", $d_txt);
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

$html10 .='<page><table border="0" cellspacing="1" width="800">
			<tr>
    			<td colspan="2" style="text-align:left;" width="50">';
	
					$logo_imob = $_SESSION['logo_imob'];
    				$caminho_logo = "../logos/";
					if (file_exists($caminho_logo.$logo_imob))
					{
						$html10 .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
					}
	
	$html10 .='</td>
  			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>
  			<tr>
			  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:center;"><b>'.$not3[d_nome].'</b></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			</tr>';

$estilo = 'style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:justify;"';

$d_txt = str_replace("\n","<br />","$d_txt");

$html10 .='<tr>
			<td colspan="2" '.$estilo.'>'.$d_txt.'</td>
		 </tr>';


$html10 .='<tr>
			<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:left;"><b>'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>LOCATÁRIO: <br>
      			_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>LOCADOR:<br> 
      			_________________________</b></td>
    	</tr>
  		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA:<br> 
      			_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA: <br>
      			_________________________</b></td>
    	</tr>
	  	<tr>
    		<td width="50" colspan="2" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br>Usuário (uso interno): '; 

	$busca_usuario = mysql_query("SELECT u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_cod='".$not4['l_usuario']."'");
	while($linha = mysql_fetch_array($busca_usuario))
	{
        $html10 .= $linha['u_nome'];	   
	}

$html10 .= '</td>
    	</tr>
    		<tr>
	  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />
         www.redebrasileiradeimoveis.com.br
	  </td>
    </tr>
  	</table></page>';

	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4
	elseif($imp == "10"){ //Contrato de Locação Anual
	
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	  
	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450);
	$cont20 = 0;
	$dados_prop = '';
	$dados_comercial = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
    	if($not450[c_end_com]<>''){
			$endereco_com = "<b>".$not450[c_end_com]."</b>";
		}else{
		  	$endereco_com = "";
		}
		if($not450[c_cidade_com]<>''){
    		$cidade_com = "<b>".$not450[c_cidade_com]."</b>";
    	}else{
		  	$cidade_com = "";
		}
		if($not450[c_estado_com]<>''){
    		$estado_com = "<b>".$not450[c_estado_com]."</b>";
    	}else{
		  	$estado_com = "";
		}
		if($not450[c_origem_com]<>''){
			$origem_com = "<b>".$not450[c_origem_com]."</b>";
		}else{
		  	$origem_com = "";
		}
		if($not450[c_cep_com]<>''){
			$cep_com = "<b>".$not450[c_cep_com]."</b>";
		}else{
		  	$cep_com = "";
		}
		if($not450[c_bairro_com]<>''){
			$bairro_com = "<b>".$not450[c_bairro_com]."</b>";
		}else{
		  	$bairro_com = "";
		}
		
		if($cont20>0){
			$var20 = " e ";
		}
	
 		$dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", residente à ".$endereco_prop.", nesta cidade de ".$cidade_prop."/".$estado_prop;	  		
		$dados_comercial .= $var20." origem: ".$origem_com." ".$endereco_com." bairro: ".$bairro_com. " em ".$cidade_com."/".$estado_com." CEP: ".$cep_com;	  	
			
 	$cont20++;
	}
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $not3[d_txt]);
	$d_txt = str_replace("-dados_comercial-", "$dados_comercial", $d_txt);
	
	/*
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
        
	
	$d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-prof_prop-", "$profissoes", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
   	$d_txt = str_replace("-end_comercial-", "$endereco_com", $d_txt);
   	$d_txt = str_replace("-cidade_comercial-", "$cidade_com", $d_txt);
   	$d_txt = str_replace("-estado_comercial-", "$estado_com", $d_txt);
   	*/
	
	$query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod and l_cod='$l_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
	  
	$contadorf = $not4[contadorf];
	$fiador10 = explode("--", $not4[l_fiador]);
	$fiador20 = str_replace("-","",$fiador10); 
	
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
	$valor_total_desconto = number_format($valor_total_desconto, 2, ',','.');
	$valor_bonificacao = number_format($valor_bonificacao, 2, ',','.');
	$pagamentos = number_format($pagamentos, 2, ',','.');
	$valor_total = number_format($valor_total, 2, ',','.');		
	$vigencia = $not4[l_vigencia];
	$vigencia_extenso = numero_extenso($vigencia);
	if($not4[l_tipo_contrato]=='Residencial'){
	  	$fins = "RESIDENCIAIS";
	}elseif($not4[l_tipo_contrato]=='Comercial'){
		$fins = "COMERCIAIS";
	}elseif($not4[l_tipo_contrato]=='Não Residencial'){
	  	$fins = "NÃO RESIDENCIAIS";
	}
	
	$d_txt = str_replace("-vigencia-", "<b>$vigencia ($vigencia_extenso)</b>", $d_txt);
	$d_txt = str_replace("-data_ini-", "<b>$data_ini</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$data_fim</b>", $d_txt);
	$d_txt = str_replace("-valor_contrato-", "<b>$valor_total ($valor_total_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_bonificacao-", "<b>$valor_bonificacao ($valor_bonificacao_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_total_desconto-", "<b>$valor_total_desconto ($valor_total_desconto_extenso)</b>", $d_txt);
	$d_txt = str_replace("-pagamentos-", "<b>$pagamentos ($pagamentos_extenso)</b>", $d_txt);
	$d_txt = str_replace("-atraso-", "<b>$atraso ($atraso_extenso)</b>", $d_txt);
	$d_txt = str_replace("-fins-", "<b>$fins</b>", $d_txt);
	
	/*
	$qstr = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
	$qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }

    $nome_fiador = array();
    $origem_fiador = array();
    $civil_fiador = array();
    $rg_fiador = array();
    $cpf_fiador = array();
    $prof_fiador = array();
    $endereco_fiador = array();
    $cidade_fiador = array();
    $estado_fiador = array();
    $bairro_fiador = array();
    $cep_fiador = array();
    foreach ($res as $row) {
        array_push($nome_fiador, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origem_fiador, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($civil_fiador, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_fiador, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_fiador, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        if (!empty($row['c_prof'])) {
            array_push($prof_fiador, '<b>' . $row['c_prof'] . '</b>');
        }
        array_push($endereco_fiador, $row['c_end']);
        array_push($cidade_fiador, $row['c_cidade']);
        array_push($estado_fiador, $row['c_estado']);
        if (!empty($row['c_bairro'])) {
            array_push($bairro_fiador, '<b> ' . $row['c_bairro'] . '</b>');
        }
        if (!empty($row['c_cep'])) {
            array_push($cep_fiador, '<b> ' . $row['c_cep'] . '</b>');
        }
    }
    $nome_fiador = implode(' e ', $nome_fiador);
    $origem_fiador = implode(' e ', $origem_fiador);
    $civil_fiador = implode(' e ', $civil_fiador);
    $rg_fiador = implode(' e ', $rg_fiador);
    $cpf_fiador = implode(' e ', $cpf_fiador);
    $prof_fiador = implode(' e ', $prof_fiador);
    $endereco_fiador = implode(' e ', $endereco_fiador);
    $cidade_fiador = implode(' e ', $cidade_fiador);
    $estado_fiador = implode(' e ', $estado_fiador);
    $bairro_fiador = implode(' e ', $bairro_fiador);  
    $cep_fiador = implode(' e ', $cep_fiador);  
    
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
	*/
	
	$query40 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
	$result40 = mysql_query($query40);
	$cont = 0;
	$dados_fiador = '';
	while($not40 = mysql_fetch_array($result40))
	{
	   	$nome_fiador = "<b>".$not40[c_nome]."</b>";
    	$origem_fiador = "<b>".$not40[c_origem]."</b>";
    	$civil_fiador = "<b>".$not40[c_civil]."</b>";
    	if($not40[c_tipo_pessoa]=='J'){
    		$rg_fiador = "<b>Inscrição Estadual: ".$not40[c_rg]."</b>";
    	}else{
		  	$rg_fiador = "<b>RG: ".$not40[c_rg]."</b>";
		}
		if($not40[c_tipo_pessoa]=='J'){
    		$cpf_fiador = "<b>CNPJ: ".$not40[c_cpf]."</b>";
    	}else{
		  	$cpf_fiador = "<b>CPF: ".$not40[c_cpf]."</b>";
		}
    	$prof_fiador = "<b>".$not40[c_prof]."</b>";
    	$endereco_fiador = "<b>".$not40[c_end]."</b>";
    	$cidade_fiador = "<b>".$not40[c_cidade]."</b>";
    	$estado_fiador = "<b>".$not40[c_estado]."</b>";
    	$bairro_fiador = "<b>".$not40[c_bairro]."</b>";
    	$cep_fiador = "<b> CEP: ".$not40[c_cep]."</b>";
    	if($not40[c_civil]=='Casado(a)'){
		  $nome_conjuge = "<b> Nome do Cônjuge: ".$not40[c_conjuge]."</b>";
		  $rg_conjuge = "<b> RG Cônjuge: ".$not40[c_rg_conjuge]."</b>";
		  $cpf_conjuge = "<b> CPF Cônjuge: ".$not40[c_cpf_conjuge]."</b>";
		  $dados_conjuge = " / ".$nome_conjuge." ".$rg_conjuge." ".$cpf_conjuge;
		}
		
		if($cont>0){
			$var = " e ";
		}
	
 		$dados_fiador .= $var.$nome_fiador." portador do ".$rg_fiador." e ".$cpf_fiador.", ".$origem_fiador.", ".$prof_fiador.", ".$civil_fiador.", residente e domiciliado na ".$endereco_fiador." – ".$bairro_fiador." – ".$cidade_fiador."/".$estado_fiador.$cep_fiador.$dados_conjuge;	
 	$cont++;
	}
		$d_txt = str_replace("-dados_fiador-", "$dados_fiador", $d_txt);
	
	/*
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
	*/ 
	
	$query46 = "select * from locacao, contas where co_locacao='$l_cod' and co_imovel='$cod' and contas.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and contas.co_locacao=locacao.l_cod and contas.co_tipo='Locação' AND contas.co_cat='Receber' ORDER BY contas.co_data ASC LIMIT 0,1";
	$result46 = mysql_query($query46);
	$numrows46 = mysql_num_rows($result46);
	while($not46 = mysql_fetch_array($result46))
	{
	    $valor_aluguel = $not46[co_valor];
		$valor_aluguel_extenso = extenso($not46[co_valor]);
		
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
	  	$d_txt = str_replace("-origem_loc-", ", <b>$not4[c_origem]</b>", $d_txt);
	  	$d_txt = str_replace("-civil_loc-", ", <b>$not4[c_civil]</b>", $d_txt);
	  	$d_txt = str_replace("-prof_loc-", ", <b>$not4[c_prof]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-origem_loc-", "", $d_txt);
	  	$d_txt = str_replace("-civil_loc-", "", $d_txt);
	  	$d_txt = str_replace("-prof_loc-", "", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-rg_loc-", "<b> RG: $not4[c_rg]</b>", $d_txt);  
		$d_txt = str_replace("-rg2_loc-", "<b> RG: $not4[c_rg]</b>", $d_txt);
	}else{
	    $d_txt = str_replace("-rg_loc-", "<b> Inscrição Estadual: $not4[c_rg]</b>", $d_txt);   
	    $d_txt = str_replace("-rg2_loc-", "<b> Inscrição Estadual: $not4[c_rg]</b>", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-cpf_loc-", "portador do <b>CPF: $not4[c_cpf]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-cpf_loc-", "inscrito no <b>CNPJ: $not4[c_cpf]</b>", $d_txt);
	}
	$d_txt = str_replace("-end_loc-", "<b>$not4[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade_loc-", "<b>$not4[c_cidade]</b>", $d_txt);
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>", $d_txt);
		$d_txt = str_replace("-estado2_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>. $texto1", $d_txt);
	  	$d_txt = str_replace("-estado2_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	}

	if($not4[c_tipo_pessoa]=='J'){
	  if($not4[c_repre2]<>''){
	     $var = "e";
	  }  
		$d_txt = str_replace("-repre1_prop-", "$texto2 <b>$not4[c_repre]</b> $var", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "<b>$not4[c_repre2]</b>", $d_txt);
   	}else{
	 	$d_txt = str_replace("-repre1_prop-", "", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "", $d_txt);    
	}
	
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
	
	$d_txt = str_replace("-cidade_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-estado_imov-", "<b>$not2[e_uf]</b>", $d_txt);
	$d_txt = str_replace("-bairro_imov-", "$bairros", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	$d_txt = str_replace("-matricula_imov-", "<b>$not2[ref]</b>", $d_txt);
	//$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-cidade_imo-", "$linha[ci_nome]", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  

	}
	
	}

$dia2 = date("d");
$mes2 = date("m");
$ano2 = date("Y");



$html10 .='<page><table border="0" cellspacing="1" width="800">
			<tr>
    			<td colspan="2" style="text-align:left;" width="50">';
	
					$logo_imob = $_SESSION['logo_imob'];
    				$caminho_logo = "../logos/";
					if (file_exists($caminho_logo.$logo_imob))
					{
						$html10 .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
					}
	
	$html10 .='</td>
  			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>
  			<tr>
			  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:center;"><b>'.$not3[d_nome].'</b></td>
			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>';

$estilo = 'style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:justify;"';

$d_txt = str_replace("\n","</td></tr><tr><td colspan=\"2\" ".$estilo.">","$d_txt");

$html10 .='<tr>
			<td colspan="2" '.$estilo.'>'.$d_txt.'</td>
		 </tr>';


$html10 .='<tr>
			<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:left;"><b>'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>LOCATÁRIO(A):<br>
      		_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>LOCADOR(A): <br>
      		_________________________</b></td>
    	</tr>
  		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA 1: <br>
      		_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA 2: <br>
      		_________________________</b></td>
    	</tr>';

    	for($i4 = 1; $i4 <= $contadorf; $i4++){
    
	$html10 .='
		<tr>
    		<td width="50" colspan="2" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br>';
			
			$html10 .='<br><b>FIADOR '.$i4.': <br><br> _________________________</b>';	
		}
		
		$html10 .= '</td></tr>
		<tr>
    		<td width="50" colspan="2" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br>';
		
		$queryf = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
		$resultf = mysql_query($queryf);
		$cont = 1;
		while($notf = mysql_fetch_array($resultf))
		{
			if($notf[c_civil]=='Casado(a)'){
					$html10 .='<br><b>FIADOR Cônjuge '.$cont.': <br><br> _________________________</b>';	
			}
		$cont++;
		}
					
    	$html10 .='</td></tr>
	  	<tr>
    		<td width="50" colspan="2" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br>Usuário (uso interno): ';

	$busca_usuario = mysql_query("SELECT u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_cod='".$not4['l_usuario']."'");
	while($linha = mysql_fetch_array($busca_usuario))
	{
        $html10 .= $linha['u_nome'];	   
	}
				
		$html10 .= '</td>
    	</tr>
    		<tr>
	  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />
         www.redebrasileiradeimoveis.com.br
	  </td>
    </tr>
  	</table></page>';

  	  
  	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4
	elseif($imp == "11"){ //Contrato de Locação Anual Comercial
	
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	  
	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450);
	$cont20 = 0;
	$dados_prop = '';
	$dados_comercial = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
    	if($not450[c_end_com]<>''){
			$endereco_com = "<b>".$not450[c_end_com]."</b>";
		}else{
		  	$endereco_com = "";
		}
		if($not450[c_cidade_com]<>''){
    		$cidade_com = "<b>".$not450[c_cidade_com]."</b>";
    	}else{
		  	$cidade_com = "";
		}
		if($not450[c_estado_com]<>''){
    		$estado_com = "<b>".$not450[c_estado_com]."</b>";
    	}else{
		  	$estado_com = "";
		}
		if($not450[c_origem_com]<>''){
			$origem_com = "<b>".$not450[c_origem_com]."</b>";
		}else{
		  	$origem_com = "";
		}
		if($not450[c_cep_com]<>''){
			$cep_com = "<b>".$not450[c_cep_com]."</b>";
		}else{
		  	$cep_com = "";
		}
		if($not450[c_bairro_com]<>''){
			$bairro_com = "<b>".$not450[c_bairro_com]."</b>";
		}else{
		  	$bairro_com = "";
		}
		
		if($cont20>0){
			$var20 = " e ";
		}
	
 		$dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", residente à ".$endereco_prop.", nesta cidade de ".$cidade_prop."/".$estado_prop;	  		
		$dados_comercial .= $var20." origem: ".$origem_com." ".$endereco_com." bairro: ".$bairro_com. " em ".$cidade_com."/".$estado_com." CEP: ".$cep_com;	  	
			
 	$cont20++;
	}
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $not3[d_txt]);
	$d_txt = str_replace("-dados_comercial-", "$dados_comercial", $d_txt);
	
	/*
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
        
	
	$d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-prof_prop-", "$profissoes", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
   	$d_txt = str_replace("-end_comercial-", "$endereco_com", $d_txt);
   	$d_txt = str_replace("-cidade_comercial-", "$cidade_com", $d_txt);
   	$d_txt = str_replace("-estado_comercial-", "$estado_com", $d_txt);
   	*/
	
	$query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod and l_cod='$l_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
	  
	$contadorf = $not4[contadorf];
	$fiador10 = explode("--", $not4[l_fiador]);
	$fiador20 = str_replace("-","",$fiador10); 
	
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
	$pagamentos = number_format($pagamentos, 2, ',','.');
	$vigencia = $not4[l_vigencia];
	$vigencia_extenso = numero_extenso($vigencia);
	if($not4[l_tipo_contrato]=='Residencial'){
	  	$fins = "RESIDENCIAIS";
	}elseif($not4[l_tipo_contrato]=='Comercial'){
		$fins = "COMERCIAIS";
	}elseif($not4[l_tipo_contrato]=='Não Residencial'){
	  	$fins = "NÃO RESIDENCIAIS";
	}
	
	$d_txt = str_replace("-vigencia-", "<b>$vigencia ($vigencia_extenso)</b>", $d_txt);
	$d_txt = str_replace("-data_ini-", "<b>$data_ini</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$data_fim</b>", $d_txt);
	$d_txt = str_replace("-valor_contrato-", "<b>$valor_total ($valor_total_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_bonificacao-", "<b>$valor_bonificacao ($valor_bonificacao_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_total_desconto-", "<b>$valor_total_desconto ($valor_total_desconto_extenso)</b>", $d_txt);
	$d_txt = str_replace("-pagamentos-", "<b>$pagamentos ($pagamentos_extenso)</b>", $d_txt);
	$d_txt = str_replace("-atraso-", "<b>$atraso ($atraso_extenso)</b>", $d_txt);
	$d_txt = str_replace("-fins-", "<b>$fins</b>", $d_txt);
	
	/*
	$qstr = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
	$qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $nome_fiador = array();
    $origem_fiador = array();
    $civil_fiador = array();
    $rg_fiador = array();
    $cpf_fiador = array();
    $prof_fiador = array();
    $endereco_fiador = array();
    $cidade_fiador = array();
    $estado_fiador = array();
    $bairro_fiador = array();
    $cep_fiador = array();
    foreach ($res as $row) {
        array_push($nome_fiador, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origem_fiador, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($civil_fiador, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_fiador, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_fiador, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        if (!empty($row['c_prof'])) {
            array_push($prof_fiador, '<b>' . $row['c_prof'] . '</b>');
        }
        array_push($endereco_fiador, $row['c_end']);
        array_push($cidade_fiador, $row['c_cidade']);
        array_push($estado_fiador, $row['c_estado']);
        if (!empty($row['c_bairro'])) {
            array_push($bairro_fiador, '<b> ' . $row['c_bairro'] . '</b>');
        }
        if (!empty($row['c_cep'])) {
            array_push($cep_fiador, '<b> ' . $row['c_cep'] . '</b>');
        }
    }
    $nome_fiador = implode(' e ', $nome_fiador);
    $origem_fiador = implode(' e ', $origem_fiador);
    $civil_fiador = implode(' e ', $civil_fiador);
    $rg_fiador = implode(' e ', $rg_fiador);
    $cpf_fiador = implode(' e ', $cpf_fiador);
    $prof_fiador = implode(' e ', $prof_fiador);
    $endereco_fiador = implode(' e ', $endereco_fiador);
    $cidade_fiador = implode(' e ', $cidade_fiador);
    $estado_fiador = implode(' e ', $estado_fiador);
    $bairro_fiador = implode(' e ', $bairro_fiador);  
    $cep_fiador = implode(' e ', $cep_fiador);  
    
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
	*/
	
	$query40 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
	$result40 = mysql_query($query40);
	$cont = 0;
	$dados_fiador = '';
	while($not40 = mysql_fetch_array($result40))
	{
	   	$nome_fiador = "<b>".$not40[c_nome]."</b>";
    	$origem_fiador = "<b>".$not40[c_origem]."</b>";
    	$civil_fiador = "<b>".$not40[c_civil]."</b>";
    	if($not40[c_tipo_pessoa]=='J'){
    		$rg_fiador = "<b>Inscrição Estadual: ".$not40[c_rg]."</b>";
    	}else{
		  	$rg_fiador = "<b>RG: ".$not40[c_rg]."</b>";
		}
		if($not40[c_tipo_pessoa]=='J'){
    		$cpf_fiador = "<b>CNPJ: ".$not40[c_cpf]."</b>";
    	}else{
		  	$cpf_fiador = "<b>CPF: ".$not40[c_cpf]."</b>";
		}
    	$prof_fiador = "<b>".$not40[c_prof]."</b>";
    	$endereco_fiador = "<b>".$not40[c_end]."</b>";
    	$cidade_fiador = "<b>".$not40[c_cidade]."</b>";
    	$estado_fiador = "<b>".$not40[c_estado]."</b>";
    	$bairro_fiador = "<b>".$not40[c_bairro]."</b>";
    	$cep_fiador = "<b> CEP: ".$not40[c_cep]."</b>";
    	if($not40[c_civil]=='Casado(a)'){
		  $nome_conjuge = "<b> Nome do Cônjuge: ".$not40[c_conjuge]."</b>";
		  $rg_conjuge = "<b> RG Cônjuge: ".$not40[c_rg_conjuge]."</b>";
		  $cpf_conjuge = "<b> CPF Cônjuge: ".$not40[c_cpf_conjuge]."</b>";
		  $dados_conjuge = " / ".$nome_conjuge." ".$rg_conjuge." ".$cpf_conjuge;
		}
		
		if($cont>0){
			$var = " e ";
		}
	
 		$dados_fiador .= $var.$nome_fiador." portador do ".$rg_fiador." e ".$cpf_fiador.", ".$origem_fiador.", ".$prof_fiador.", ".$civil_fiador.", residente e domiciliado na ".$endereco_fiador." – ".$bairro_fiador." – ".$cidade_fiador."/".$estado_fiador.$cep_fiador.$dados_conjuge;	
 	$cont++;
	}
		$d_txt = str_replace("-dados_fiador-", "$dados_fiador", $d_txt);
	
	/*
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
	*/ 
	
	$query46 = "select * from locacao, contas where co_locacao='$l_cod' and co_imovel='$cod' and contas.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and contas.co_locacao=locacao.l_cod and contas.co_tipo='Locação' AND contas.co_cat='Receber' ORDER BY contas.co_data ASC LIMIT 0,1";
	$result46 = mysql_query($query46);
	$numrows46 = mysql_num_rows($result46);
	while($not46 = mysql_fetch_array($result46))
	{
	    $valor_aluguel = $not46[co_valor];
		$valor_aluguel_extenso = extenso($not46[co_valor]);
		
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
	  	$d_txt = str_replace("-origem_loc-", ", <b>$not4[c_origem]</b>", $d_txt);
	  	$d_txt = str_replace("-civil_loc-", ", <b>$not4[c_civil]</b>", $d_txt);
	  	$d_txt = str_replace("-prof_loc-", ", <b>$not4[c_prof]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-origem_loc-", "", $d_txt);
	  	$d_txt = str_replace("-civil_loc-", "", $d_txt);
	  	$d_txt = str_replace("-prof_loc-", "", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-rg_loc-", "<b> RG: $not4[c_rg]</b>", $d_txt);  
		$d_txt = str_replace("-rg2_loc-", "<b> RG: $not4[c_rg]</b>", $d_txt);
	}else{
	    $d_txt = str_replace("-rg_loc-", "<b> Inscrição Estadual: $not4[c_rg]</b>", $d_txt);   
	    $d_txt = str_replace("-rg2_loc-", "<b> Inscrição Estadual: $not4[c_rg]</b>", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-cpf_loc-", "portador do <b>CPF: $not4[c_cpf]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-cpf_loc-", "inscrito no <b>CNPJ: $not4[c_cpf]</b>", $d_txt);
	}
	$d_txt = str_replace("-end_loc-", "<b>$not4[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade_loc-", "<b>$not4[c_cidade]</b>", $d_txt);
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>", $d_txt);
		$d_txt = str_replace("-estado2_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>. $texto1", $d_txt);
	  	$d_txt = str_replace("-estado2_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	}

	if($not4[c_tipo_pessoa]=='J'){
	  if($not4[c_repre2]<>''){
	     $var = "e";
	  }  
		$d_txt = str_replace("-repre1_prop-", "$texto2 <b>$not4[c_repre]</b> $var", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "<b>$not4[c_repre2]</b>", $d_txt);
   	}else{
	 	$d_txt = str_replace("-repre1_prop-", "", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "", $d_txt);    
	}
	
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
	
	$d_txt = str_replace("-cidade_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-estado_imov-", "<b>$not2[e_uf]</b>", $d_txt);
	$d_txt = str_replace("-bairro_imov-", "$bairros", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	$d_txt = str_replace("-matricula_imov-", "<b>$not2[ref]</b>", $d_txt);
	//$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-cidade_imo-", "$linha[ci_nome]", $d_txt); 
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);   

	}
	}

$dia2 = date("d");
$mes2 = date("m");
$ano2 = date("Y");



$html10 .='<page><table border="0" cellspacing="1" width="800">
			<tr>
    			<td colspan="2" style="text-align:left;" width="50">';
	
					$logo_imob = $_SESSION['logo_imob'];
    				$caminho_logo = "../logos/";
					if (file_exists($caminho_logo.$logo_imob))
					{
						$html10 .='<img src="'.$caminho_logo.$logo_imob.'" border="0" width="100">';
					}
	
	$html10 .='</td>
  			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>
  			<tr>
			  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:center;"><b>'.$not3[d_nome].'</b></td>
			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>';

$estilo = 'style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:justify;"';

$d_txt = str_replace("\n","</td></tr><tr><td colspan=\"2\" ".$estilo.">","$d_txt");

$html10 .='<tr>
			<td colspan="2" '.$estilo.'>'.$d_txt.'</td>
		 </tr>';


$html10 .='<tr>
			<td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-align:left;"><b>'.$_SESSION['cidadei'].' - '.$_SESSION['estadoi'].', '.$dia2.'/'.$mes2.'/'.$ano2.'</b></td>
		</tr>
		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>LOCATÁRIO(A):<br>
      		_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>LOCADOR(A): <br>
      		_________________________</b></td>
    	</tr>
  		<tr>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA 1: <br>
      		_________________________</b></td>
    		<td width="50" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br><b>TESTEMUNHA 2: <br>
      		_________________________</b></td>
    	</tr>';
    	
    	for($i4 = 1; $i4 <= $contadorf; $i4++){
    
	$html10 .='
		<tr>
    		<td width="50" colspan="2" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br>';
			
			$html10 .='<br><b>FIADOR '.$i4.': <br><br> _________________________</b>';	
		}
		
		$html10 .= '</td></tr>
		<tr>
    		<td width="50" colspan="2" style="background:#EDEEEE;font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br>';
		
		$queryf = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
		$resultf = mysql_query($queryf);
		$cont = 1;
		while($notf = mysql_fetch_array($resultf))
		{ 
			if($notf[c_civil]=='Casado(a)'){
					$html10 .='<br><b>FIADOR Cônjuge '.$cont.': <br><br> _________________________</b>';	
			}
		$cont++;
		}
		
    	$html10 .='</td></tr>
	  	<tr>
    		<td width="50" colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;"><br><br>Usuário (uso interno): ';

	$busca_usuario = mysql_query("SELECT u_nome FROM usuarios WHERE cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' AND u_cod='".$not4['l_usuario']."'");
	while($linha = mysql_fetch_array($busca_usuario))
	{
        $html10 .= $linha['u_nome'];	   
	}
		
		$html10 .= '</td>
    	</tr>
    		<tr>
	  <td colspan="2" style="font-family: Verdana,Arial, Helvetica, sans-serif;font-size: 10px;color: #666666;text-align:center;">Rede Brasileira de Imóveis<BR />
         www.redebrasileiradeimoveis.com.br
	  </td>
    </tr>
  	</table></page>';

  	  
  	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4 


	echo $html10;
	

	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	$pdf = new HTML2PDF('P','A4','fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();

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
	<style media="print">
		.noprint { display: none }
	</style>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
<?php

	if($imp == "2"){
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	
	
	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450);
	$cont20 = 0;
	$dados_prop = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
    	$tel_prop = "<b>".$not450[c_tel]."</b>";
		if($not450[c_tipo_pessoa]=='J'){
			if($not450[c_repre]<>''){
				$representantes = " Representante 1: <b>".$not450[c_repre]."</b>";
			}else{
		  		$representantes = "";
			}
			if($not450[c_repre2]<>''){
    			$representantes2 = " Representante 2: <b>".$not450[c_repre2]."</b>";
    		}else{
		  		$representantes2 = "";
			}
		}
		$repre_prop = "$representantes $representantes2";
		
		if($cont20>0){
			$var20 = " e ";
		}
	
 		$dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", residente e domiciliado na ".$endereco_prop.", cidade de ".$cidade_prop."/".$estado_prop.", fone: ".$tel_prop;	  		
			
 	$cont20++;
	}
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $not3[d_txt]);
	
	/*
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
	*/
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
	
	$d_txt = str_replace("-titulo_imov-", "<b>$not2[titulo]</b>", $d_txt);
	$d_txt = str_replace("-cid_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	//$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);

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
	
	$diaria1_extenso = extenso($not2[diaria1]);
	$diaria2_extenso = extenso($not2[diaria2]);
		
	$comissao = number_format($not2[comissao], 2, ',', '.');
	$comissao_extenso = numero_extenso($not2[comissao]);
	
	$d_txt = str_replace("-diaria1-", "<b>$diaria1</b>", $d_txt);
	$d_txt = str_replace("-diaria2-", "<b>$diaria2</b>", $d_txt);
	
	$d_txt = str_replace("-diaria1_extenso-", "$diaria1_extenso", $d_txt);
	$d_txt = str_replace("-diaria2_extenso-", "$diaria2_extenso", $d_txt);
		
	$d_txt = str_replace("-comissao-", "<b>$not2[comissao] %</b>", $d_txt);
	$d_txt = str_replace("-comissao_extenso-", "$comissao_extenso", $d_txt);
	
	$d_txt = str_replace("-conta-", "<b>$not2[c_banco] $not2[c_conta]</b>", $d_txt);
	
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
  <table border="0" cellspacing="1" width="95%">
	<tr height="50">
		<td colspan=2 class="style1">
			<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p>
		</td>
	</tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" action="<?php print("$url"); ?>">
	<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
	<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
	<input type="hidden" name="impressao" value="1">	
	<input type="hidden" name="imp" value="2">
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea>
		</td>
	</tr>
  	<tr>
  		<td colspan=2>
			<input type="submit" value="Finalizar Texto" class=campo3 name="B1">
		</td>
	</tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
	<tr>
		<td colspan=2 class="style">
			<p align="justify"><?php print("$txt"); ?></p>
		</td>
	</tr>
<?php
	}
?>
	<input type="hidden" name="mostra" value="<?=$mostra?>">
	<tr bgcolor="#ffffff">
		<td colspan=2 class="style">
			<p align="left"><br><br><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?><br/><br/></p>
		</td>
	</tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>PROPRIETÁRIO(A):<br><br>_________________________</b></p>
		</td>
    	<td width="50%" class="style">
    		<p><br><br><b>CORRETOR(A):<br><br>_________________________</b></p>
    	</td>
    </tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA:<br><br>_________________________</b></p>
    	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA:<br><br>_________________________</b></p>
    	</td>
    </tr>
</table>
<div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style"><br><br>
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
	    <br />
		<input type="submit" class="campo3 noprint" id="exportar" name="exportar" value="Exportar para PDF"/>
		</form>
		<input id=idPrint type="button" name="voltar" class="campo3 noprint" value="Voltar" OnClick="javascript:history.back();">
<? } ?>
		
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()"><br><br><br>
	  </span></div></td>
    </tr>
</div>
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
	  
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	
	$query2 = "select *, ci2.ci_nome as localizacao from muraski m, clientes c, rebri_cidades ci, rebri_cidades ci2, rebri_tipo t, rebri_estados e where m.cod = '$cod' and m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and m.cliente like '".$cod_cliente."' and '".$cod_cliente2."'=c.c_cod and m.cidade_mat=ci.ci_cod and m.local=ci2.ci_cod and m.tipo=t.t_cod and m.uf=e.e_cod";
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
	//$d_txt = str_replace("-desc_imovel-", "<b>".strip_tags($not2[descricao])."</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	//$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
	$d_txt = str_replace("-titulo-", "<b>".strip_tags($not2[titulo])."</b>", $d_txt);
	
	if($not2[local]<>$_SESSION['cod_cidadei']){
	  $variavel = ", na cidade de ".$not2[localizacao].".";
	}else{
	  $variavel = ", nesta cidade.";
	}
	
	$d_txt = str_replace("-end_imovel-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b> $variavel", $d_txt);
	$d_txt = str_replace("-uf_imovel-", "<b>$not2[e_nome]</b>", $d_txt);
	
	$valor = number_format($not2[valor], 2, ',', '.');
	$valor_extenso = extenso($not2[valor]);
	
	$d_txt = str_replace("-valor-", "<b>$valor ($valor_extenso)</b>", $d_txt);
	
	$ano = substr ($not2[data_inicio], 0, 4);
	$mes = substr($not2[data_inicio], 5, 2 );
	$dia = substr ($not2[data_inicio], 8, 2 );
	
	$ano1 = substr ($not2[data_fim], 0, 4);
	$mes1 = substr($not2[data_fim], 5, 2 );
	$dia1 = substr ($not2[data_fim], 8, 2 );

	$d_txt = str_replace("-data_inicio-", "<b>$dia/$mes/$ano</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$dia1/$mes1/$ano1</b>", $d_txt);
	
	$comissao = number_format($not2[comissao], 2, ',', '.');
	$comissao_extenso = numero_extenso($not2[comissao]);
	
	$d_txt = str_replace("-com_venda-", "<b>$not2[comissao] %</b>", $d_txt);
	$d_txt = str_replace("-com_venda_extenso-", "$comissao_extenso", $d_txt);


	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450);
	$cont20 = 0;
	$dados_prop = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
            if(Trim($not450[c_conjuge])!=''){
	     		$c_conjuge = " <b>".$not450[c_conjuge]."</b>";
	        	$rg_conjuge = " <b>RG: ".$not450[c_rg_conjuge]."</b>";
			    $cpf_conjuge = " <b>CPF: ".$not450[c_cpf_conjuge]."</b>";
            }
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
    	$tel_prop = "<b>".$not450[c_tel]."</b>";
		if($not450[c_tipo_pessoa]=='J'){
			if($not450[c_repre]<>''){
				$representantes = " Representante 1: <b>".$not450[c_repre]."</b>";
			}else{
		  		$representantes = "";
			}
			if($not450[c_repre2]<>''){
    			$representantes2 = " Representante 2: <b>".$not450[c_repre2]."</b>";
    		}else{
		  		$representantes2 = "";
			}
		}
		$repre_prop = "$representantes $representantes2";
		
		if($cont20>0){
			$var20 = " e ";
		}
	
        if(Trim($not450[c_conjuge])==''){
		  $dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", com residência na ".$endereco_prop.", ".$cidade_prop.", ".$estado_prop.", Tel.: ".$tel_prop.$repre_prop;	  		
        }else{
		  $dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop." e conjuge,  ".$c_conjuge.",  ".$rg_conjuge." e ".$cpf_conjuge.", ambos com residência na ".$endereco_prop.", ".$cidade_prop.", ".$estado_prop.", Tel.: ".$tel_prop.$repre_prop;		
		}	
 	$cont20++;
	}
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $d_txt);
	
	/*
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
   	*/
	
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
	<table border="0" cellspacing="1" width="95%">
  		<tr height="50">
  			<td colspan=2 class="style1">
				<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p>
			</td>
		</tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" action="<?php print("$url"); ?>">
	<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
	<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
	<input type="hidden" name="impressao" value="1">
	<input type="hidden" name="imp" value="5">
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea>
		</td>
	</tr>
  	<tr>
  		<td colspan=2>
			<input type="submit" value="Finalizar Texto" class=campo3 name="B1">
		</td>
	</tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
	<tr>
		<td colspan=2 class="style">
			<p align="justify"><?php print("$txt"); ?></p>
		</td>
	</tr>
<?php
	}
?>
	<input type="hidden" name="mostra" value="<?=$mostra?>">
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><br><br><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?><br /><br /></p>
		</td>
	</tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>PROPRIETÁRIO(A):<br><br>_________________________</b></p>
		</td>
    	<td width="50%" class="style">
    		<p><br><br><b>CORRETOR(A):<br><br>_________________________</b></p>
		</td>
    </tr>
<?php
  if(isset($c_conjuge)) {
?>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>CONJUGE PROPRIETÁRIO(A):<br><br>_________________________</b></p>
		</td>
    	<td width="50%" class="style">
    		<p><br><br><b><br><br></b></p>
		</td>
    </tr>
<?php
}
?>
  	<tr class="fundoTabela">
		<td width="50%" class="style">
			<p><br><br><b>TESTEMUNHA:<br><br>_________________________</b></p>
    	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA:<br><br>_________________________</b></p>
    	</td>
    </tr>
  </table>
<div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style"><br /><br />
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
	    <br />
		<input type="submit" class="campo3 noprint" id="exportar" name="exportar" value="Exportar para PDF"/>
		</form>
		<input id=idPrint type="button" name="voltar" class="campo3 noprint" value="Voltar" OnClick="javascript:history.back();">
<? } ?>
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()"><br /><br /><br />
	  </span></div></td>
    </tr>
</div>
<?php
	}
	}
	}
	}//Termina imp = 5
	elseif($imp == "4"){
	  
	if ($gera_contrato=='S') {
	  	  
   $t_cod = explode("--", $c_cod);
   $t_cod = str_replace("-","",$t_cod);
   if (count($t_cod) > 1) {
?>
		<table width="100%">
 			<tr>
  				<td align="center" class="style7"><table cellpadding="0" cellspacing="1" width="75%">
    				<tr>
       					<td align="center" colspan="4" height="50" class="style1" ><strong>Imprimir Renovação</strong><br />
          			Selecione o cliente que deseja imprimir o contrato de renovação</td></tr>
<?         
     
   $i = 0;
   foreach ($t_cod as $cli) {
      if ($i==0) {
		   $p_cod = "AND (c_cod = '$cli' ";
      } else {
		   $p_cod .= " OR c_cod = '$cli' ";
      }
      $i++;
   }
   $p_cod .= ")";
	$query3 = "select * from clientes where 1=1 $p_cod and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
   $rs3 = mysql_query($query3) or die ("Erro 1587");
?>

<tr>
<td width=230 class="fundoTabelaTitulo style1"><b>
<p align="center">Nome / Razão Social</p></td>
<td width=200 class="fundoTabelaTitulo style1"><b>
<p align="center">CPF / CNPJ</p></td>
<td width=200 class="fundoTabelaTitulo style1"><b>
<p align="center">Telefone</p></td>
<td width=100 class="fundoTabelaTitulo style1"><b>
<p align="center">Tipo</p></td>
</tr>

<?
   $i = 0;
   while ($not3 = mysql_fetch_assoc($rs3)) {
      if ($i % 2 == 0) { $cor = "fundoTabelaCor1"; } else {$cor = "fundoTabelaCor2"; }
?>
      <tr class="<?=$cor?>">
       <td align="left" class="style1"><a class="style1" href="p_imp_doc.php?cod=<?=$cod ?>&c_cod=<?=$not3[c_cod]?>&imp=4&verificacao=S"><?=$not3[c_nome]?></a></td>
       <td align="center" class="style1"><a class="style1" href="p_imp_doc.php?cod=<?=$cod ?>&c_cod=<?=$not3[c_cod]?>&imp=4&verificacao=S"><?=$not3[c_cpf]?></a></td>
       <td align="center" class="style1"><a class="style1" href="p_imp_doc.php?cod=<?=$cod ?>&c_cod=<?=$not3[c_cod]?>&imp=4&verificacao=S"><?=$not3[c_tel]?></a></td>
       <td align="center" class="style1"><a class="style1" href="p_imp_doc.php?cod=<?=$cod ?>&c_cod=<?=$not3[c_cod]?>&imp=4&verificacao=S"><?=$not3[c_tipo]?>
       <?
       if ($not3[c_tipo2] <> "") {
         $t_tipo = explode("--", $not3[c_tipo2]);
         $t_tipo = str_replace("-", "", $t_tipo);
         if (count($t_tipo) > 0) {
            foreach ($t_tipo as $tipo) {
               $tsql = "SELECT tc_tipo FROM tipos_clientes WHERE tc_cod = '$tipo'";
               $trs = mysql_query($tsql) or die ("Erro 1617");
               $tnot = mysql_fetch_assoc($trs);
               echo " " . $tnot[tc_tipo];
            }
         }
       }
       ?>
       </a></td></tr>
<?
      $i++;
   }
?>
	<tr>
	  <td colspan="4"><div align="center"><span class="style"><br /><br />
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()">
	  </span></div></td>
    </tr>
   </table>
  </td>
 </tr>
</table>
<?
   } else {
      $c_cod = $t_cod[0];
   }
} 	  

	  
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	  
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	  
	
	//$query2 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and muraski.cliente like '%".$c_cod."%' and $cod_cliente2";
	$query2 = "select * from muraski, clientes where cod = '$cod' and muraski.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and clientes.c_cod='".$c_cod."'";	
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	$x = 1;
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
	
	$d_txt = str_replace("-nome-", "<b>$not2[c_nome]</b>", $not3[d_txt]);
	//$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	
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
	<table border="0" cellspacing="1" width="95%">
  		<tr height="50">
  			<td colspan=2 class="style1">
				<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p>
			</td>
		</tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" name="form<?php echo $x; ?>" action="<?php print("$url"); ?>">
	<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
	<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
	<input type="hidden" name="impressao" value="1">
	<input type="hidden" name="imp" value="4">
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea>
		</td>
	</tr>
  	<tr>
  		<td colspan=2>
			<input type="submit" value="Finalizar Texto" class=campo3 name="B1"><br /><br />
		</td>
	</tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
	<tr>
		<td colspan=2 class="style">
			<p align="justify"><?php print("$txt"); ?></p>
		</td>
	</tr>
<?php
	}
?>
  </table>
<input type="hidden" name="mostra" value="<?=$mostra?>">
<div class=noprint>
	<tr>
	  <td colspan="2"><div align="center"><span class="style"><br /><br />
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
	    <br />
		<input type="submit" class="campo3 noprint" id="exportar" name="exportar" value="Exportar para PDF"/>
		</form>
		<input id=idPrint type="button" name="voltar" class="campo3 noprint" value="Voltar" OnClick="javascript:history.back();">
<? 
	} 
	if($verificacao=='S' && $impressao==''){
?>	
		<input id=idPrint type="button" name="voltar" class="campo3 noprint" value="Voltar" OnClick="javascript:history.back();">
<?		
	}
?>
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()"><br /><br /><br />
	  </span></div></td>
    </tr>
</div>
<?php
	$x++;
	}
	}
	}
	}//Termina imp = 4
	elseif($imp == "7"){
		if($comprador == ""){
			//echo $comprador;
			//echo $cod;
?>
<br />
    <form method="get" action="<?php print("$PHP_SELF"); ?>">
    <input type="hidden" name="imp" value="7">
    <input type="hidden" name="cod" value="<?php print("$cod"); ?>">
    <input type="hidden" name="comprador" value="1">
    <b>Fazer proposta de compra:</b><br><br>
    <select name=compr class=campo>
    <option selected>Selecione um comprador
<?php
	$query1 = "select c_cod, c_nome, tc_tipo from clientes where cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' order by cli.c_nome";
	$result1 = mysql_query($query1) or die ("Erro 3243");
	$numrows1 = mysql_num_rows($result1);
	while($not1 = mysql_fetch_array($result1))
	{
	 $c_nome = substr ($not1[c_nome], 0, 30);
?>
	<option value=<?php print("$not1[c_cod]"); ?> title="<?php print($not1['c_nome'].' - '.$not1['tc_tipo']); ?>"><?php print($c_nome.'... - '.$not1['tc_tipo']); ?></option>
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

	$bcidademat = mysql_query("SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$not2['cidade_mat']."'");
	while($linha = mysql_fetch_array($bcidademat)){
	    $cidade_mat = $linha['ci_nome'];
	}
	
	$blocal = mysql_query("SELECT ci_nome FROM rebri_cidades WHERE ci_cod='".$not2['local']."'");
	while($linha = mysql_fetch_array($blocal)){
	    $local = $linha['ci_nome'];
	}
	
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
	//$d_txt = str_replace("-desc_imovel-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imovel-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	$d_txt = str_replace("-end_imovel-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	$d_txt = str_replace("-local-", "<b>$local</b>", $d_txt);
	$d_txt = str_replace("-matricula-", "<b>$not2[matricula]</b>", $d_txt);
	$d_txt = str_replace("-cidade_mat-", "<b>$cidade_mat</b>", $d_txt);
	
	
	$nome_cliente3 = '';

for ($i3 = 0; $i3 < $not2[contador]; $i3++) {

	$query4 = "select * from clientes where c_cod='" . $cliente2[$i3] . "' and cod_imobiliaria='" . $_SESSION['cod_imobiliaria'] . "'";

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
	<table border="0" cellspacing="1" width="95%">
  		<tr height="50">
  			<td colspan=2 class="style1">
				<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p>
			</td>
		</tr>
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
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea>
		</td>
	</tr>
  	<tr>
  		<td colspan=2>
			<input type="submit" value="Finalizar Texto" class=campo3 name="B1">
		</td>
	</tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
	<tr>
		<td colspan=2 class="style">
			<p align="justify"><?php print("$txt"); ?></p>
		</td>
	</tr>
<?php
	}
?>
	<input type="hidden" name="mostra" value="<?=$mostra?>">
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><br><br><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?><br /><br /></p>
		</td>
	</tr>
  	<tr class="fundoTabela">
		<td colspan=2 class="style">
			<p><br><br><b>PROPONENTE COMPRADOR(A):<br><br>_________________________</b></p>
    	</td>
    </tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>PROPRIETÁRIO(A):<br><br>_________________________</b></p>
    	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>CORRETOR(A):<br><br>_________________________</b></p>
    	</td>
    </tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA:<br><br>_________________________</b></p>
    	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA:<br><br>_________________________</b></p>
    	</td>
    </tr>
  </table>
<div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style"><br /><br />
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
	    <br />
		<input type="submit" class="campo3 noprint" id="exportar" name="exportar" value="Exportar para PDF"/>
		</form>
		<input id=idPrint type="button" name="voltar" class="campo3 noprint" value="Voltar" OnClick="javascript:history.back();">
<? } ?>
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()"><br /><br /><br />
	  </span></div></td>
    </tr>
</div>
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
	
	$query20 = "select cliente, contador from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	  
	
	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450);
	$cont20 = 0;
	$dados_prop = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
		if($not450[c_tipo_pessoa]=='J'){
			if($not450[c_repre]<>''){
				$representantes = " Representante 1: <b>".$not450[c_repre]."</b>";
			}else{
		  		$representantes = "";
			}
			if($not450[c_repre2]<>''){
    			$representantes2 = " Representante 2: <b>".$not450[c_repre2]."</b>";
    		}else{
		  		$representantes2 = "";
			}
		}
		$repre_prop = "$representantes $representantes2";
		
		if($cont20>0){
			$var20 = " e ";
		}
	
 		$dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", residente na ".$endereco_prop.", ".$cidade_prop.", ".$estado_prop.$repre_prop;	  		
			
 	$cont20++;
	}
	
	$d_txt = $not3[d_txt];
		
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $d_txt);
	
	
	/*  
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
	*/
	
   $d_txt = str_replace("-cid_imov-", "$not2[ci_nome]", $d_txt);
   $d_txt = str_replace("-end_imov-", "$not2[tipo_logradouro] $not2[end], $not2[numero]", $d_txt);
   //$d_txt = str_replace("-desc_imov-", "$not2[t_nome] - Ref.: $not2[ref]", $d_txt);
   $d_txt = str_replace("-desc_imov-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
   $d_txt = str_replace("-titulo-", "<b>".strip_tags($not2[titulo])."</b>", $d_txt);
   $d_txt = str_replace("-acomod-", "$not2[acomod]", $d_txt);


   $diaria2 = number_format($not2[diaria2], 2, ',', '.');

   $query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod
      and l_cod='$l_cod'";
	//echo $query4;
   $result4 = mysql_query($query4);
   $numrows4 = mysql_num_rows($result4);

	while ($not4 = mysql_fetch_array($result4)) {
	$total = $not4[l_total] + $not4[l_limpeza];
	$total_extenso = extenso($not4[l_total]);
	//$total = $not4[l_total];
	$total_final = number_format($total, 2, ',', '.');
	$total_final_extenso = extenso($total);
	$total = number_format($not4[l_total], 2, ',', '.');
	$limpeza = number_format($not4[l_limpeza], 2, ',', '.');
	$tv = number_format($not4[l_tv], 2, ',', '.');
	$extenso_limpeza = extenso($not4[l_limpeza]);

	$total_manu_extenso = extenso($not4[l_tv]);
	
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
	
	$pagto = str_replace("$total_final","$total_final ($total_final_extenso)", $not4[l_pagto]);
	
	$d_txt = str_replace("-total_dias-", "<b>$total_dias</b>", $d_txt);
	$d_txt = str_replace("-data_ent-", "<b>$data_ent</b>", $d_txt);
	$d_txt = str_replace("-data_sai-", "<b>$data_sai</b>", $d_txt);
	$d_txt = str_replace("-total_final-", "<b>$total_final</b> ($total_final_extenso)", $d_txt);
	$d_txt = str_replace("-total_final_extenso-", "<b>$total_final_extenso</b>", $d_txt);
	$d_txt = str_replace("-total_manu-", "<b>$total_manu</b>", $d_txt);
	$d_txt = str_replace("-total_manu_extenso-", "<b>$total_manu_extenso</b>", $d_txt);
	$d_txt = str_replace("-total-", "R$ <b>$total</b> - $total_extenso", $d_txt);
	$d_txt = str_replace("-total_extenso-", "<b>$total_extenso</b>", $d_txt);
	$d_txt = str_replace("-limpeza-", "R$ <b>$limpeza</b> - $extenso_limpeza", $d_txt);
	$d_txt = str_replace("-limpeza-", "", $d_txt);
	$d_txt = str_replace("-tv-", "<b>$tv</b>", $d_txt);
	$d_txt = str_replace("-l_pagto-", "$pagto", $d_txt);
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
<div align="center">
	<table border="0" cellspacing="1" width="95%">
  		<tr height="50">
  			<td colspan=2 class="style1">
				<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p>
			</td>
		</tr>
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
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea>
		</td>
	</tr>
  	<tr>
  		<td colspan=2>
			<input type="submit" value="Finalizar Texto" class=campo3 name="B1">
		</td>
	</tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
  	<tr>
  		<td colspan=2 class="style">
			<p align="justify"><?php print("$txt"); ?></p>
		</td>
	</tr>
<?php
	}
?>
	<input type="hidden" name="mostra" value="<?=$mostra?>">
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><br><br><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?><br /><br /></p>
		</td>
	</tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>LOCATÁRIO(A):<br><br>_________________________</b></p>
      	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>LOCADOR(A):<br><br>_________________________</b></p>
    	</td>
    </tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA:<br><br>_________________________</b></p>
    	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA:<br><br>_________________________</b></p>
    	</td>
    </tr>
	<tr class="fundoTabela">
    	<td colspan="2" class="style"><br><br><br>Usuário (uso interno): 
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
	  <td colspan="2"><div align="center"><span class="style"><br /><br />
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
		<br><input type="submit" value="Exportar para PDF" name="exportar" id="exportar" class="campo3 noprint">
		</form>
		<input id=idPrint type="button" name="voltar" class="campo3 noprint" value="Voltar" OnClick="javascript:history.back();">
<? } ?>
		
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()"><br /><br />
	  </span></div></td>
    </tr>
</div>
<?php

	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4
	elseif($imp == "10"){ //Contrato de Locação Anual
	
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	
	
	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450);
	$cont20 = 0;
	$dados_prop = '';
	$dados_comercial = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
    	if($not450[c_end_com]<>''){
			$endereco_com = "<b>".$not450[c_end_com]."</b>";
		}else{
		  	$endereco_com = "";
		}
		if($not450[c_cidade_com]<>''){
    		$cidade_com = "<b>".$not450[c_cidade_com]."</b>";
    	}else{
		  	$cidade_com = "";
		}
		if($not450[c_estado_com]<>''){
    		$estado_com = "<b>".$not450[c_estado_com]."</b>";
    	}else{
		  	$estado_com = "";
		}
		if($not450[c_origem_com]<>''){
			$origem_com = "<b>".$not450[c_origem_com]."</b>";
		}else{
		  	$origem_com = "";
		}
		if($not450[c_cep_com]<>''){
			$cep_com = "<b>".$not450[c_cep_com]."</b>";
		}else{
		  	$cep_com = "";
		}
		if($not450[c_bairro_com]<>''){
			$bairro_com = "<b>".$not450[c_bairro_com]."</b>";
		}else{
		  	$bairro_com = "";
		}
		
		if($cont20>0){
			$var20 = " e ";
		}
	
 		$dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", residente à ".$endereco_prop.", nesta cidade de ".$cidade_prop."/".$estado_prop;	  		
		$dados_comercial .= $var20." origem: ".$origem_com." ".$endereco_com." bairro: ".$bairro_com. " em ".$cidade_com."/".$estado_com." CEP: ".$cep_com;	  	
			
 	$cont20++;
	}
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $not3[d_txt]);
	$d_txt = str_replace("-dados_comercial-", "$dados_comercial", $d_txt);
	  
	/*
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
        
	  	
   	$d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-prof_prop-", "$profissoes", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
   	$d_txt = str_replace("-end_comercial-", "$endereco_com", $d_txt);
   	$d_txt = str_replace("-cidade_comercial-", "$cidade_com", $d_txt);
   	$d_txt = str_replace("-estado_comercial-", "$estado_com", $d_txt);
   	*/
	
	$query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod and l_cod='$l_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
	 	 
	$contadorf = $not4[contadorf];
	$fiador10 = explode("--", $not4[l_fiador]);
	$fiador20 = str_replace("-","",$fiador10); 
	  
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
	$valor_total_desconto = number_format($valor_total_desconto, 2, ',','.');
	$valor_bonificacao = number_format($valor_bonificacao, 2, ',','.');
	$valor_total = number_format($valor_total, 2, ',','.');		
	$pagamentos_extenso = extenso($pagamentos);
	$pagamentos = number_format($pagamentos, 2, ',','.');
	$vigencia = $not4[l_vigencia];
	$vigencia_extenso = numero_extenso($vigencia);
	if($not4[l_tipo_contrato]=='Residencial'){
	  	$fins = "RESIDENCIAIS";
	}elseif($not4[l_tipo_contrato]=='Comercial'){
		$fins = "COMERCIAIS";
	}elseif($not4[l_tipo_contrato]=='Não Residencial'){
	  	$fins = "NÃO RESIDENCIAIS";
	}
	
	$d_txt = str_replace("-vigencia-", "<b>$vigencia ($vigencia_extenso)</b>", $d_txt);
	$d_txt = str_replace("-data_ini-", "<b>$data_ini</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$data_fim</b>", $d_txt);
	$d_txt = str_replace("-valor_contrato-", "<b>$valor_total ($valor_total_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_bonificacao-", "<b>$valor_bonificacao ($valor_bonificacao_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_total_desconto-", "<b>$valor_total_desconto ($valor_total_desconto_extenso)</b>", $d_txt);
	$d_txt = str_replace("-pagamentos-", "<b>$pagamentos ($pagamentos_extenso)</b>", $d_txt);
	$d_txt = str_replace("-atraso-", "<b>$atraso ($atraso_extenso)</b>", $d_txt);
	$d_txt = str_replace("-fins-", "<b>$fins</b>", $d_txt);
	
	/*
	$qstr = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
	$qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $nome_fiador = array();
    $origem_fiador = array();
    $civil_fiador = array();
    $rg_fiador = array();
    $cpf_fiador = array();
    $prof_fiador = array();
    $endereco_fiador = array();
    $cidade_fiador = array();
    $estado_fiador = array();
    $bairro_fiador = array();
    $cep_fiador = array();
    foreach ($res as $row) {
        array_push($nome_fiador, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origem_fiador, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($civil_fiador, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_fiador, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_fiador, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        if (!empty($row['c_prof'])) {
            array_push($prof_fiador, '<b>' . $row['c_prof'] . '</b>');
        }
        array_push($endereco_fiador, $row['c_end']);
        array_push($cidade_fiador, $row['c_cidade']);
        array_push($estado_fiador, $row['c_estado']);
        if (!empty($row['c_bairro'])) {
            array_push($bairro_fiador, '<b> ' . $row['c_bairro'] . '</b>');
        }
        if (!empty($row['c_cep'])) {
            array_push($cep_fiador, '<b> ' . $row['c_cep'] . '</b>');
        }
    }
    $nome_fiador = implode(' e ', $nome_fiador);
    $origem_fiador = implode(' e ', $origem_fiador);
    $civil_fiador = implode(' e ', $civil_fiador);
    $rg_fiador = implode(' e ', $rg_fiador);
    $cpf_fiador = implode(' e ', $cpf_fiador);
    $prof_fiador = implode(' e ', $prof_fiador);
    $endereco_fiador = implode(' e ', $endereco_fiador);
    $cidade_fiador = implode(' e ', $cidade_fiador);
    $estado_fiador = implode(' e ', $estado_fiador);
    $bairro_fiador = implode(' e ', $bairro_fiador);  
    $cep_fiador = implode(' e ', $cep_fiador);  
    
       $d_txt = str_replace("-nome_fiador-", "<b>$nome_fiador</b>", $d_txt);
	   $d_txt = str_replace("-rg_fiador-", "<b>$rg_fiador</b>", $d_txt);
	   $d_txt = str_replace("-cpf_fiador-", "<b>$cpf_fiador</b>", $d_txt);
	   $d_txt = str_replace("-origem_fiador-", "$origem_fiador", $d_txt);
	   $d_txt = str_replace("-prof_fiador-", "$prof_fiador", $d_txt);
	   $d_txt = str_replace("-civil_fiador-", "$civil_fiador", $d_txt);
	   $d_txt = str_replace("-endereco_fiador-", "<b>$endereco_fiador</b>", $d_txt);
	   $d_txt = str_replace("-bairro_fiador-", "$bairro_fiador", $d_txt);
	   $d_txt = str_replace("-cidade_fiador-", "<b>$cidade_fiador</b>", $d_txt);
	   $d_txt = str_replace("-estado_fiador-", "<b>$estado_fiador</b>", $d_txt); 
	   $d_txt = str_replace("-cep_fiador-", "$cep_fiador", $d_txt); 
	*/
	
	$query40 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
	$result40 = mysql_query($query40);
	$cont = 0;
	$dados_fiador = '';
	while($not40 = mysql_fetch_array($result40))
	{
	   	$nome_fiador = "<b>".$not40[c_nome]."</b>";
    	$origem_fiador = "<b>".$not40[c_origem]."</b>";
    	$civil_fiador = "<b>".$not40[c_civil]."</b>";
    	if($not40[c_tipo_pessoa]=='J'){
    		$rg_fiador = "<b>Inscrição Estadual: ".$not40[c_rg]."</b>";
    	}else{
		  	$rg_fiador = "<b>RG: ".$not40[c_rg]."</b>";
		}
		if($not40[c_tipo_pessoa]=='J'){
    		$cpf_fiador = "<b>CNPJ: ".$not40[c_cpf]."</b>";
    	}else{
		  	$cpf_fiador = "<b>CPF: ".$not40[c_cpf]."</b>";
		}
    	$prof_fiador = "<b>".$not40[c_prof]."</b>";
    	$endereco_fiador = "<b>".$not40[c_end]."</b>";
    	$cidade_fiador = "<b>".$not40[c_cidade]."</b>";
    	$estado_fiador = "<b>".$not40[c_estado]."</b>";
    	$bairro_fiador = "<b>".$not40[c_bairro]."</b>";
    	$cep_fiador = "<b> CEP: ".$not40[c_cep]."</b>";
    	if($not40[c_civil]=='Casado(a)'){
		  $nome_conjuge = "<b> Nome do Cônjuge: ".$not40[c_conjuge]."</b>";
		  $rg_conjuge = "<b> RG Cônjuge: ".$not40[c_rg_conjuge]."</b>";
		  $cpf_conjuge = "<b> CPF Cônjuge: ".$not40[c_cpf_conjuge]."</b>";
		  $dados_conjuge = " / ".$nome_conjuge." ".$rg_conjuge." ".$cpf_conjuge;
		}
		
		if($cont>0){
			$var = " e ";
		}
	
 		$dados_fiador .= $var.$nome_fiador." portador do ".$rg_fiador." e ".$cpf_fiador.", ".$origem_fiador.", ".$prof_fiador.", ".$civil_fiador.", residente e domiciliado na ".$endereco_fiador." – ".$bairro_fiador." – ".$cidade_fiador."/".$estado_fiador.$cep_fiador.$dados_conjuge;	
 	$cont++;
	}

	   $d_txt = str_replace("-dados_fiador-", "$dados_fiador", $d_txt);
    
	/*
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
	*/
	
	$query46 = "select * from locacao, contas where co_locacao='$l_cod' and co_imovel='$cod' and contas.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and contas.co_locacao=locacao.l_cod and contas.co_tipo='Locação' AND contas.co_cat='Receber' ORDER BY contas.co_data ASC LIMIT 0,1";
	$result46 = mysql_query($query46);
	$numrows46 = mysql_num_rows($result46);
	while($not46 = mysql_fetch_array($result46))
	{
	    $valor_aluguel = $not46[co_valor];
		$valor_aluguel_extenso = extenso($not46[co_valor]);
		
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
	  	$d_txt = str_replace("-origem_loc-", ", <b>$not4[c_origem]</b>", $d_txt);
	  	$d_txt = str_replace("-civil_loc-", ", <b>$not4[c_civil]</b>", $d_txt);
	  	$d_txt = str_replace("-prof_loc-", ", <b>$not4[c_prof]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-origem_loc-", "", $d_txt);
	  	$d_txt = str_replace("-civil_loc-", "", $d_txt);
	  	$d_txt = str_replace("-prof_loc-", "", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-rg_loc-", "<b> RG: $not4[c_rg]</b>", $d_txt);  
		$d_txt = str_replace("-rg2_loc-", "<b> RG: $not4[c_rg]</b>", $d_txt);
	}else{
	    $d_txt = str_replace("-rg_loc-", "<b> Inscrição Estadual: $not4[c_rg]</b>", $d_txt);   
	    $d_txt = str_replace("-rg2_loc-", "<b> Inscrição Estadual: $not4[c_rg]</b>", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-cpf_loc-", "portador do <b>CPF: $not4[c_cpf]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-cpf_loc-", "inscrito no <b>CNPJ: $not4[c_cpf]</b>", $d_txt);
	}
	$d_txt = str_replace("-end_loc-", "<b>$not4[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade_loc-", "<b>$not4[c_cidade]</b>", $d_txt);
	if($not4[c_tipo_pessoa]=='F'){
		 $d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>", $d_txt);
		 $d_txt = str_replace("-estado2_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>. $texto1", $d_txt);
	  	$d_txt = str_replace("-estado2_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	}

	if($not4[c_tipo_pessoa]=='J'){
	  if($not4[c_repre2]<>''){
	     $var = "e";
	  }  
		$d_txt = str_replace("-repre1_prop-", "$texto2 <b>$not4[c_repre]</b> $var", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "<b>$not4[c_repre2]</b>", $d_txt);
   	}else{
	 	$d_txt = str_replace("-repre1_prop-", "", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "", $d_txt);    
	}
	
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
	
	
	$d_txt = str_replace("-cidade_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-estado_imov-", "<b>$not2[e_uf]</b>", $d_txt);
	$d_txt = str_replace("-bairro_imov-", "$bairros", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	$d_txt = str_replace("-matricula_imov-", "<b>$not2[ref]</b>", $d_txt);
	//$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-cidade_imo-", "$linha[ci_nome]", $d_txt);  
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);  

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
	<table border="0" cellspacing="1" width="95%">
  		<tr height="50">
  			<td colspan=2 class="style1">
				<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p>
			</td>
		</tr>
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
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea>
		</td>
	</tr>
  	<tr>
  		<td colspan=2>
			<input type="submit" value="Finalizar Texto" class=campo3 name="B1">
		</td>
	</tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
	<tr>
		<td colspan=2 class="style">
			<p align="justify"><?php print("$txt"); ?></p>
		</td>
	</tr>
<?php
	}
?>
	<input type="hidden" name="mostra" value="<?=$mostra?>">
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><br><br><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?><br /><br /></p>
		</td>
	</tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>LOCATÁRIO(A):<br><br>_________________________</b></p>
      	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>LOCADOR(A):<br><br>_________________________</b></p>
    	</td>
    </tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA 1:<br><br>_________________________</b></p>
    	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA 2:<br><br>_________________________</b></p>
    	</td>
    </tr>
    <? for($i4 = 1; $i4 <= $contadorf; $i4++){ ?>
    <tr class="fundoTabela">
    	<td width="50%" colspan="2" class="style">
    		<p><br><br><b>FIADOR <?=$i4 ?>:<br><br>_________________________</b></p>
    	</td>
    </tr>   
<?
 	}
$queryf = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
$resultf = mysql_query($queryf);
$cont = 1;
while($notf = mysql_fetch_array($resultf))
{ 
	if($notf[c_civil]=='Casado(a)'){
?>    
	<tr class="fundoTabela">
    	<td width="50%" colspan="2" class="style">
    		<p><br><br><b>FIADOR Cônjuge <?=$cont ?>:<br><br>_________________________</b></p>
    	</td>
    </tr>    
<?
	}
$cont++;
}
?>  
	<tr class="fundoTabela">
    	<td colspan="2" class="style"><br><br><br>Usuário (uso interno): 
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
	  <td colspan="2"><div align="center"><span class="style"><br /><br />
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <br><input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
		<input type="submit" value="Exportar para PDF" name="exportar" id="exportar" class="campo3 noprint">
		</form>
		<input id=idPrint type="button" name="voltar" class="campo3 noprint" value="Voltar" OnClick="javascript:history.back();">
<? } ?>
		
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()"><br /><br /><br />
	  </span></div></td>
    </tr>
</div>
<?php

	}//Termina if3
	}//Termina while3
	}//Termina while2
	}//Termina numrows2
	}//Termina while4
	elseif($imp == "11"){ //Contrato de Locação Anual Comercial
	
	$query3 = "select * from doc where d_cod = '$imp' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
	$result3 = mysql_query($query3);
	while($not3 = mysql_fetch_array($result3))
	{
	
	$query20 = "select contador, cliente from muraski where cod = '$cod' and cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'";
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
	
	
	$query450 = "select * from clientes where c_cod in (" . implode(',',$cliente20) . ") and cod_imobiliaria='" .$_SESSION['cod_imobiliaria']. "'";
	$result450 = mysql_query($query450);
	$cont20 = 0;
	$dados_prop = '';
	$dados_comercial = '';
	while($not450 = mysql_fetch_array($result450))
	{
	   	$nome_prop = "<b>".$not450[c_nome]."</b>";
    	if($not450[c_tipo_pessoa]=='F'){
			$origem_prop = ", <b>".$not450[c_origem]."</b>";
    		$civil_prop = ", <b>".$not450[c_civil]."</b>";
    	}else{
		  	$origem_prop = "";
    		$civil_prop = "";
		}
    	if($not450[c_tipo_pessoa]=='J'){
    		$rg_prop = "<b>Inscrição Estadual: ".$not450[c_rg]."</b>";
    	}else{
		  	$rg_prop = " portador do <b>RG: ".$not450[c_rg]."</b>";
		}
		if($not450[c_tipo_pessoa]=='J'){
    		$cpf_prop = "<b>CNPJ: ".$not450[c_cpf]."</b>";
    	}else{
		  	$cpf_prop = "<b>CPF: ".$not450[c_cpf]."</b>";
		}
		if($not450[c_tipo_pessoa]=='F'){
    		$prof_prop = ", <b>".$not450[c_prof]."</b>";
    	}else{
		  	$prof_prop = "";
		}
    	$endereco_prop = "<b>".$not450[c_end]."</b>";
    	$cidade_prop = "<b>".$not450[c_cidade]."</b>";
    	$estado_prop = "<b>".$not450[c_estado]."</b>";
    	if($not450[c_end_com]<>''){
			$endereco_com = "<b>".$not450[c_end_com]."</b>";
		}else{
		  	$endereco_com = "";
		}
		if($not450[c_cidade_com]<>''){
    		$cidade_com = "<b>".$not450[c_cidade_com]."</b>";
    	}else{
		  	$cidade_com = "";
		}
		if($not450[c_estado_com]<>''){
    		$estado_com = "<b>".$not450[c_estado_com]."</b>";
    	}else{
		  	$estado_com = "";
		}
		if($not450[c_origem_com]<>''){
			$origem_com = "<b>".$not450[c_origem_com]."</b>";
		}else{
		  	$origem_com = "";
		}
		if($not450[c_cep_com]<>''){
			$cep_com = "<b>".$not450[c_cep_com]."</b>";
		}else{
		  	$cep_com = "";
		}
		if($not450[c_bairro_com]<>''){
			$bairro_com = "<b>".$not450[c_bairro_com]."</b>";
		}else{
		  	$bairro_com = "";
		}
		
		if($cont20>0){
			$var20 = " e ";
		}
	
 		$dados_prop .= $var20.$nome_prop.$origem_prop.$prof_prop.$civil_prop.$rg_prop." e ".$cpf_prop.", residente à ".$endereco_prop.", nesta cidade de ".$cidade_prop."/".$estado_prop;	  		
		$dados_comercial .= $var20." origem: ".$origem_com." ".$endereco_com." bairro: ".$bairro_com. " em ".$cidade_com."/".$estado_com." CEP: ".$cep_com;	  	
			
 	$cont20++;
	}
	
	$d_txt = str_replace("-dados_prop-", "$dados_prop", $not3[d_txt]);
	$d_txt = str_replace("-dados_comercial-", "$dados_comercial", $d_txt);
	  
	/*
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
        
	  	
   	$d_txt = str_replace("-nome_prop-", "<b>$proprietarios</b>", $not3[d_txt]);
	$d_txt = str_replace("-origem_prop-", "$origens", $d_txt);
	$d_txt = str_replace("-civil_prop-", "$es_civis", $d_txt);
	$d_txt = str_replace("-prof_prop-", "$profissoes", $d_txt);
	$d_txt = str_replace("-rg_prop-", "<b>$rg_ie</b>", $d_txt);
	$d_txt = str_replace("-cpf_prop-", "<b>$cpf_cnpj</b>", $d_txt);
	$d_txt = str_replace("-cidade_prop-", "<b>$cidades</b>", $d_txt);
	$d_txt = str_replace("-estado_prop-", "<b>$ufs</b>", $d_txt);
	$d_txt = str_replace("-end_prop-", "<b>$enderecos</b>", $d_txt);
   	$d_txt = str_replace("-end_comercial-", "$endereco_com", $d_txt);
   	$d_txt = str_replace("-cidade_comercial-", "$cidade_com", $d_txt);
   	$d_txt = str_replace("-estado_comercial-", "$estado_com", $d_txt);
   	*/
	
	$query4 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and l_cliente=c_cod and l_cod='$l_cod'";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	while($not4 = mysql_fetch_array($result4))
	{
	 	 
	$contadorf = $not4[contadorf];
	$fiador10 = explode("--", $not4[l_fiador]);
	$fiador20 = str_replace("-","",$fiador10); 
	  
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
	$pagamentos = number_format($pagamentos, 2, ',', '.');	
	$vigencia = $not4[l_vigencia];
	$vigencia_extenso = numero_extenso($vigencia);
	if($not4[l_tipo_contrato]=='Residencial'){
	  	$fins = "RESIDENCIAIS";
	}elseif($not4[l_tipo_contrato]=='Comercial'){
		$fins = "COMERCIAIS";
	}elseif($not4[l_tipo_contrato]=='Não Residencial'){
	  	$fins = "NÃO RESIDENCIAIS";
	}
	
	$d_txt = str_replace("-vigencia-", "<b>$vigencia ($vigencia_extenso)</b>", $d_txt);
	$d_txt = str_replace("-data_ini-", "<b>$data_ini</b>", $d_txt);
	$d_txt = str_replace("-data_fim-", "<b>$data_fim</b>", $d_txt);
	$d_txt = str_replace("-valor_contrato-", "<b>$valor_total ($valor_total_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_bonificacao-", "<b>$valor_bonificacao ($valor_bonificacao_extenso)</b>", $d_txt);
	$d_txt = str_replace("-valor_total_desconto-", "<b>$valor_total_desconto ($valor_total_desconto_extenso)</b>", $d_txt);
	$d_txt = str_replace("-pagamentos-", "<b>$pagamentos ($pagamentos_extenso)</b>", $d_txt);
	$d_txt = str_replace("-fins-", "<b>$fins</b>", $d_txt);
	
	/*
	$qstr = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
	$qres = mysql_query($qstr);

    $res = array();
    while ($rw = mysql_fetch_assoc($qres)) {
        array_push($res, $rw);
    }
    
    $nome_fiador = array();
    $origem_fiador = array();
    $civil_fiador = array();
    $rg_fiador = array();
    $cpf_fiador = array();
    $prof_fiador = array();
    $endereco_fiador = array();
    $cidade_fiador = array();
    $estado_fiador = array();
    $bairro_fiador = array();
    $cep_fiador = array();
    foreach ($res as $row) {
        array_push($nome_fiador, $row['c_nome']);
        if (!empty($row['c_origem'])) {
            array_push($origem_fiador, '<b>' . $row['c_origem'] . '</b>');
        }
        if (!empty($row['c_civil'])) {
            array_push($civil_fiador, '<b>' . $row['c_civil'] . '</b>');
        }
        array_push($rg_fiador, ($row['c_tipo_pessoa'] == 'J' ? 'Inscrição Estadual: ' : 'RG: ') . $row['c_rg']);
        array_push($cpf_fiador, ($row['c_tipo_pessoa'] == 'J' ? 'CNPJ: ' : 'CPF: ') . $row['c_cpf']);
        if (!empty($row['c_prof'])) {
            array_push($prof_fiador, '<b>' . $row['c_prof'] . '</b>');
        }
        array_push($endereco_fiador, $row['c_end']);
        array_push($cidade_fiador, $row['c_cidade']);
        array_push($estado_fiador, $row['c_estado']);
        if (!empty($row['c_bairro'])) {
            array_push($bairro_fiador, '<b> ' . $row['c_bairro'] . '</b>');
        }
        if (!empty($row['c_cep'])) {
            array_push($cep_fiador, '<b> ' . $row['c_cep'] . '</b>');
        }
    }
    $nome_fiador = implode(' e ', $nome_fiador);
    $origem_fiador = implode(' e ', $origem_fiador);
    $civil_fiador = implode(' e ', $civil_fiador);
    $rg_fiador = implode(' e ', $rg_fiador);
    $cpf_fiador = implode(' e ', $cpf_fiador);
    $prof_fiador = implode(' e ', $prof_fiador);
    $endereco_fiador = implode(' e ', $endereco_fiador);
    $cidade_fiador = implode(' e ', $cidade_fiador);
    $estado_fiador = implode(' e ', $estado_fiador);
    $bairro_fiador = implode(' e ', $bairro_fiador);  
    $cep_fiador = implode(' e ', $cep_fiador);  
    
       $d_txt = str_replace("-nome_fiador-", "<b>$nome_fiador</b>", $d_txt);
	   $d_txt = str_replace("-rg_fiador-", "<b>$rg_fiador</b>", $d_txt);
	   $d_txt = str_replace("-cpf_fiador-", "<b>$cpf_fiador</b>", $d_txt);
	   $d_txt = str_replace("-origem_fiador-", "$origem_fiador", $d_txt);
	   $d_txt = str_replace("-prof_fiador-", "$prof_fiador", $d_txt);
	   $d_txt = str_replace("-civil_fiador-", "$civil_fiador", $d_txt);
	   $d_txt = str_replace("-endereco_fiador-", "<b>$endereco_fiador</b>", $d_txt);
	   $d_txt = str_replace("-bairro_fiador-", "$bairro_fiador", $d_txt);
	   $d_txt = str_replace("-cidade_fiador-", "<b>$cidade_fiador</b>", $d_txt);
	   $d_txt = str_replace("-estado_fiador-", "<b>$estado_fiador</b>", $d_txt); 
	   $d_txt = str_replace("-cep_fiador-", "$cep_fiador", $d_txt); 
	*/
	
	$query40 = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
	$result40 = mysql_query($query40);
	$cont = 0;
	$dados_fiador = '';
	while($not40 = mysql_fetch_array($result40))
	{
	   	$nome_fiador = "<b>".$not40[c_nome]."</b>";
    	$origem_fiador = "<b>".$not40[c_origem]."</b>";
    	$civil_fiador = "<b>".$not40[c_civil]."</b>";
    	if($not40[c_tipo_pessoa]=='J'){
    		$rg_fiador = "<b>Inscrição Estadual: ".$not40[c_rg]."</b>";
    	}else{
		  	$rg_fiador = "<b>RG: ".$not40[c_rg]."</b>";
		}
		if($not40[c_tipo_pessoa]=='J'){
    		$cpf_fiador = "<b>CNPJ: ".$not40[c_cpf]."</b>";
    	}else{
		  	$cpf_fiador = "<b>CPF: ".$not40[c_cpf]."</b>";
		}
    	$prof_fiador = "<b>".$not40[c_prof]."</b>";
    	$endereco_fiador = "<b>".$not40[c_end]."</b>";
    	$cidade_fiador = "<b>".$not40[c_cidade]."</b>";
    	$estado_fiador = "<b>".$not40[c_estado]."</b>";
    	$bairro_fiador = "<b>".$not40[c_bairro]."</b>";
    	$cep_fiador = "<b> CEP: ".$not40[c_cep]."</b>";
    	if($not40[c_civil]=='Casado(a)'){
		  $nome_conjuge = "<b> Nome do Cônjuge: ".$not40[c_conjuge]."</b>";
		  $rg_conjuge = "<b> RG Cônjuge: ".$not40[c_rg_conjuge]."</b>";
		  $cpf_conjuge = "<b> CPF Cônjuge: ".$not40[c_cpf_conjuge]."</b>";
		  $dados_conjuge = " / ".$nome_conjuge." ".$rg_conjuge." ".$cpf_conjuge;
		}
		
		if($cont>0){
			$var = " e ";
		}
	
 		$dados_fiador .= $var.$nome_fiador." portador do ".$rg_fiador." e ".$cpf_fiador.", ".$origem_fiador.", ".$prof_fiador.", ".$civil_fiador.", residente e domiciliado na ".$endereco_fiador." – ".$bairro_fiador." – ".$cidade_fiador."/".$estado_fiador.$cep_fiador.$dados_conjuge;	
 	$cont++;
	}

	   $d_txt = str_replace("-dados_fiador-", "$dados_fiador", $d_txt);
    
	/*
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
	*/
	
	$query46 = "select * from locacao, contas where co_locacao='$l_cod' and co_imovel='$cod' and contas.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and contas.co_locacao=locacao.l_cod and contas.co_tipo='Locação' AND contas.co_cat='Receber' ORDER BY contas.co_data ASC LIMIT 0,1";
	$result46 = mysql_query($query46);
	$numrows46 = mysql_num_rows($result46);
	while($not46 = mysql_fetch_array($result46))
	{
	    $valor_aluguel = $not46[co_valor];
		$valor_aluguel_extenso = extenso($not46[co_valor]);
		
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
	  	$d_txt = str_replace("-origem_loc-", ", <b>$not4[c_origem]</b>", $d_txt);
	  	$d_txt = str_replace("-civil_loc-", ", <b>$not4[c_civil]</b>", $d_txt);
	  	$d_txt = str_replace("-prof_loc-", ", <b>$not4[c_prof]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-origem_loc-", "", $d_txt);
	  	$d_txt = str_replace("-civil_loc-", "", $d_txt);
	  	$d_txt = str_replace("-prof_loc-", "", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-rg_loc-", "<b> RG: $not4[c_rg]</b>", $d_txt);  
		$d_txt = str_replace("-rg2_loc-", "<b> RG: $not4[c_rg]</b>", $d_txt);
	}else{
	    $d_txt = str_replace("-rg_loc-", "<b> Inscrição Estadual: $not4[c_rg]</b>", $d_txt);   
	    $d_txt = str_replace("-rg2_loc-", "<b> Inscrição Estadual: $not4[c_rg]</b>", $d_txt);
	}
	if($not4[c_tipo_pessoa]=='F'){
		$d_txt = str_replace("-cpf_loc-", "portador do <b>CPF: $not4[c_cpf]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-cpf_loc-", "inscrito no <b>CNPJ: $not4[c_cpf]</b>", $d_txt);
	}
	$d_txt = str_replace("-end_loc-", "<b>$not4[c_end]</b>", $d_txt);
	$d_txt = str_replace("-cidade_loc-", "<b>$not4[c_cidade]</b>", $d_txt);
	if($not4[c_tipo_pessoa]=='F'){
		 $d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>", $d_txt);
		 $d_txt = str_replace("-estado2_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	}else{
	  	$d_txt = str_replace("-estado_loc-", "<b>$not4[c_estado]</b>. $texto1", $d_txt);
	  	$d_txt = str_replace("-estado2_loc-", "<b>$not4[c_estado]</b>", $d_txt);
	}

	if($not4[c_tipo_pessoa]=='J'){
	  if($not4[c_repre2]<>''){
	     $var = "e";
	  }  
		$d_txt = str_replace("-repre1_prop-", "$texto2 <b>$not4[c_repre]</b> $var", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "<b>$not4[c_repre2]</b>", $d_txt);
   	}else{
	 	$d_txt = str_replace("-repre1_prop-", "", $d_txt);
   		$d_txt = str_replace("-repre2_prop-", "", $d_txt);    
	}
	
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
	
	
	$d_txt = str_replace("-cidade_imov-", "<b>$not2[ci_nome]</b>", $d_txt);
	$d_txt = str_replace("-estado_imov-", "<b>$not2[e_uf]</b>", $d_txt);
	$d_txt = str_replace("-bairro_imov-", "$bairros", $d_txt);
	$d_txt = str_replace("-end_imov-", "<b>$not2[tipo_logradouro] $not2[end], $not2[numero]</b>", $d_txt);
	$d_txt = str_replace("-matricula_imov-", "<b>$not2[ref]</b>", $d_txt);
	//$d_txt = str_replace("-desc_imov-", "<b>$not2[descricao]</b>", $d_txt);
	$d_txt = str_replace("-desc_imov-", "<b>Ref.: ".$not2[ref]." - ".strip_tags($not2[endereco_contrato])."</b>", $d_txt);
	
	$SQL = "SELECT * FROM rebri_imobiliarias i INNER JOIN rebri_estados e ON (i.im_estado=e.e_cod) INNER JOIN rebri_cidades c ON (i.im_cidade=c.ci_cod)  WHERE i.im_cod='".$_SESSION['cod_imobiliaria']."'";
	$busca = mysql_query($SQL);
    $num_rows = mysql_num_rows($busca);
    if($num_rows > 0){
	while($linha = mysql_fetch_array($busca))
	{
	  
	$d_txt = str_replace("-cidade_imo-", "$linha[ci_nome]", $d_txt); 
	$d_txt = str_replace("-nome_im-", "<b>$linha[im_nome]</b>", $d_txt);   

	}
	}

$dia2 = date(d);
$mes2 = date(m);
$ano2 = date(Y);
?>
<div align="center">
	<table border="0" cellspacing="1" width="95%">
  		<tr height="50">
  			<td colspan=2 class="style1">
				<p align="center"><b><?php print("$not3[d_nome]"); ?></b></p>
			</td>
		</tr>
<?php
	$url = $REQUEST_URI;

	if($impressao == ""){
?>
<form method="post" action="<?php print("$url"); ?>">
	<input type="hidden" name="d_nome" value="<?php print("$not3[d_nome]"); ?>">
	<input type="hidden" name="cod" value="<?php print("$cod"); ?>">
	<input type="hidden" name="l_cod" value="<?php print("$l_cod"); ?>">
	<input type="hidden" name="impressao" value="1">
	<input type="hidden" name="imp" value=11>
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><textarea rows="15" name="txt" cols="100" class="campo"><?php print("$d_txt"); ?></textarea>
		</td>
	</tr>
  	<tr>
  		<td colspan=2>
			<input type="submit" value="Finalizar Texto" class=campo3 name="B1">
		</td>
	</tr>
</form>
<?php
	}
	else
	{
	$txt = str_replace("\n","<br>","$txt");
?>
  	<tr>
  		<td colspan=2 class="style">
			<p align="justify"><?php print("$txt"); ?></p>
		</td>
	</tr>
<?php
	}
?>
	<input type="hidden" name="mostra" value="<?=$mostra?>">
  	<tr>
  		<td colspan=2 class="style">
			<p align="left"><br><br><b><?php echo($_SESSION['cidadei']); ?>-<?php echo($_SESSION['estadoi']); ?>, <?php print("$dia2/$mes2/$ano2"); ?><br><br></p>
		</td>
	</tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>LOCATÁRIO(A):<br><br>_________________________</b></p>
      	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>LOCADOR(A):<br><br>_________________________</b></p>
      	</td>
    </tr>
  	<tr class="fundoTabela">
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA 1:<br><br>_________________________</b></p>
    	</td>
    	<td width="50%" class="style">
    		<p><br><br><b>TESTEMUNHA 2:<br><br>_________________________</b></p>
    	</td>
    </tr>
    <? for($i4 = 1; $i4 <= $contadorf; $i4++){ ?>
    <tr class="fundoTabela">
    	<td width="50%" colspan="2" class="style">
    		<p><br><br><b>FIADOR <?=$i4 ?>:<br><br>_________________________</b></p>
    	</td>
    </tr>
<?
 	}
$queryf = "select * from locacao, clientes where l_imovel='$cod' and locacao.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."' and c_cod in (" . implode(',',$fiador20) . ") and l_cod='$l_cod'";
$resultf = mysql_query($queryf);
$cont = 1;
while($notf = mysql_fetch_array($resultf))
{ 
	if($notf[c_civil]=='Casado(a)'){
?>    
	<tr class="fundoTabela">
    	<td width="50%" colspan="2" class="style">
    		<p><br><br><b>FIADOR Cônjuge <?=$cont ?>:<br><br>_________________________</b></p>
    	</td>
    </tr>    
<?
	}
$cont++;
}
?>
	<tr class="fundoTabela">
    	<td colspan="2" class="style"><br><br><br>Usuário (uso interno): 
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
	<style media="print">
		.noprint { display: none }
	</style>
    <div class=noprint>	
	<tr>
	  <td colspan="2"><div align="center"><span class="style"><br><br>
<? if($impressao <> ""){ ?>
	    <input id=idPrint type="button" value="Imprimir" class="campo3 noprint" onClick="javascript:self.print()">
	    <form name="form3" id="form3" method="post" action="<?php print("$url"); ?>">
	    <br><input type="hidden" name="pdf" id="pdf" value="1">
	    <input type="hidden" name="impressao2" id="impressao2" value="1">
		<input type="submit" value="Exportar para PDF" name="exportar" id="exportar" class="campo3 noprint">
		</form>
		<input id=idPrint type="button" name="voltar" class="campo3 noprint" value="Voltar" OnClick="javascript:history.back();">
<? } ?>
		
	    <input id=idPrint type="button" value="Fechar" class="campo3 noprint" onClick="javascript:window.close()"><br /><br /><br />
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
<? if($mostra=='S'){ ?>
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
    <td align="center" class="style">
    <? include("bruc.php"); ?>
    </td>
  </tr>
</table>
<? } ?>
<? } ?>
</body>
</html>
<? } ?>