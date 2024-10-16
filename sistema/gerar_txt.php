<?
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");

	$qry		= mysql_query("SELECT m.cod, t.t_nome, m.tipo, m.ref, f.f_nome, m.valor, m.area_terreno, ci.ci_nome, m.bairro, m.end, m.n_quartos, m.caracteristica, m.observacoes, m.finalidade FROM muraski m INNER JOIN finalidade f ON (m.finalidade=f.f_cod) INNER JOIN rebri_tipo t ON (m.tipo=t.t_cod) INNER JOIN rebri_cidades ci ON (m.local=ci.ci_cod) WHERE m.cod_imobiliaria='".$_SESSION['cod_imobiliaria']."'");
	$resultado	= mysql_query($qry,$con);

    $saida = fopen("imoveis.txt","a+");
	while($linha=mysql_fetch_array($resultado))
	{
		$conteudo = "DIVULG.0.1;"; //campo 1
		if($linha['finalidade']=='5' || $linha['finalidade']=='12' || $linha['finalidade']=='16' || $linha['ref']=='x'){
		  	$conteudo .= "X;"; //campo 2
		}else{
		  	$conteudo .= "A;"; //campo 2
		}
		$conteudo .= ''.";"; //campo 3
		$conteudo .= $linha['cod'].";"; //campo 4
		$conteudo .= $linha['t_nome'].";"; //campo 5
		$conteudo .= $linha['ref'].";"; //campo 6
		if($linha['finalidade']=='1' || $linha['finalidade']=='2' || $linha['finalidade']=='3' || $linha['finalidade']=='4' || $linha['finalidade']=='5' || $linha['finalidade']=='6' || $linha['finalidade']=='7'){
			$conteudo .= "V;"; //campo 7
		}else{
		  	$conteudo .= "A;"; //campo 7
		}	
		$conteudo .= number_format($linha['valor'], 2, ',', '.').";"; //campo 8
		$conteudo .= number_format($linha['area_terreno'], 2, ',', '.').";"; //campo 9
		$conteudo .= $linha['ci_nome'].";"; //campo 10
		
		$bairro1 = explode("--", $linha['bairro']);
		$bairro2 = str_replace("-","",$bairro1);
		
		foreach ($bairro2 as $k => $bairro) {
        	$bairro2[$k] = "'" . $bairro . "'";
    	}
		
		$b_bairro = mysql_query("SELECT b_nome FROM rebri_bairros WHERE b_cod in (" . implode(',',$bairro2) . ") ORDER BY b_cod LIMIT 1");
		while($linha2=mysql_fetch_array($b_bairro)){
		   $conteudo .= $linha2['b_nome'].";"; //campo 11
		}
		
		$conteudo .= ''.";"; //campo 12
		$conteudo .= $linha['end'].";"; //campo 13
		$conteudo .= ''.";"; //campo 14
		$conteudo .= ''.";"; //campo 15
		$conteudo .= ''.";"; //formataCEPParaBd($linha['cep']); //campo 16
		$conteudo .= $linha['n_quartos'].";"; //campo 17
		$conteudo .= ''.";"; //campo 18
		$conteudo .= ''.";"; //campo 19
		$conteudo .= "n;"; //campo 20
		if($linha['finalidade']=='5'){
			$conteudo .= "s;"; //campo 21
		}else{
		  	$conteudo .= "n;"; //canpo 21
		}
		$conteudo .= "n;"; //campo 22
		$conteudo .= $linha['observacoes'].";"; //campo 23
		$conteudo .= str_pad("*", 1).";"; //campo 24
	
		if(strlen($linha)>1){
			$conteudo .= "\r\n";
		}
		
		$result = fputs($saida,$conteudo); 		
	}
	fclose($saida);
	echo "TXT Gerado com sucesso!";

?>