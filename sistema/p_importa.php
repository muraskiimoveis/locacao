<?php
include("conect.php");

	$query0 = "delete from muraski";
	$result0 = mysql_query($query0) or die("Não foi possível apagar suas informações.(Imóveis)");
	
	$query2 = "delete from clientes";
	$result2 = mysql_query($query2) or die("Não foi possível apagar suas informações.(Clientes)");

	$query4 = "delete from interessados";
	$result4 = mysql_query($query4) or die("Não foi possível apagar suas informações.(Interessados)");

	$query6 = "delete from locacao";
	$result6 = mysql_query($query6) or die("Não foi possível apagar suas informações.(Locação)");
	
	$query8 = "delete from usuarios";
	$result8 = mysql_query($query8) or die("Não foi possível apagar suas informações.(Usuários)");
	
	$query10 = "delete from carrinho";
	$result10 = mysql_query($query10) or die("Não foi possível apagar suas informações.(Carrinho)");

$row = 1;
$fp = fopen ("/rede/www/html/img_not/dados.php","r");
while ($data = fgetcsv ($fp, 1000, "|")) {
    $num = count ($data);
    //print "<p> $num fields in line $row: <br>";
    $row++;

	if($data[0] == "imo"){

	$titulo = str_replace("<n>", "\n", $data[10]);
	$titulo = str_replace("<r>", "\r", $titulo);
	$descricao = str_replace("<n>", "\n", $data[11]);
	$descricao = str_replace("<r>", "\r", $descricao);
	
	$query1 = "insert into muraski (cod, ref, tipo, metragem, 
	n_quartos, valor, especificacao, suites, piscina, titulo, 
	descricao, local, permuta, finalidade, permuta_txt, 
	ftxt_1, ftxt_2, ftxt_3, ftxt_4, ftxt_5, ftxt_6, ftxt_7, ftxt_8, 
	ftxt_9, ftxt_10, ftxt_11, ftxt_12, ftxt_13, ftxt_14, ftxt_15
	, ftxt_16, ftxt_17, ftxt_18, ftxt_19, ftxt_20, cliente, matricula, cidade_mat
	, end, averbacao, acomod, dist_mar, dist_tipo, limpeza, diaria1, diaria2
	, data_inicio, data_fim, comissao) 
	values('$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]'
	, '$data[7]', '$data[8]', '$data[9]', '$titulo', '$descricao', '$data[12]'
	, '$data[13]', '$data[14]', '$data[15]', '$data[16]', '$data[17]', '$data[18]'
	, '$data[19]', '$data[20]', '$data[21]', '$data[22]', '$data[23]', '$data[24]', '$data[25]'
	, '$data[26]', '$data[27]', '$data[28]', '$data[29]', '$data[30]', '$data[31]', '$data[32]'
	, '$data[33]', '$data[34]', '$data[35]', '$data[36]', '$data[37]', '$data[38]', '$data[39]'
	, '$data[40]', '$data[41]', '$data[42]', '$data[43]', '$data[44]', '$data[45]', '$data[46]'
	, '$data[47]', '$data[48]', '$data[49]')";
	$result1 = mysql_query($query1) or die("Não foi possível inserir suas informações.(Imóveis)");
	
	}elseif($data[0] == "cli"){
	
	$c_obs = str_replace("<n>", "\n", $data[19]);
	$c_obs = str_replace("<r>", "\r", $c_obs);
	$c_conta = str_replace("<n>", "\n", $data[20]);
	$c_conta = str_replace("<r>", "\r", $c_conta);
	
	$query3 = "insert into clientes (c_cod, c_nome, c_cpf, c_rg, 
	c_civil, c_origem, c_end, c_bairro, c_cep, c_cidade, 
	c_estado, c_tel, c_cel, c_fax, c_email, c_nasc, c_desde
	, c_tipo, c_obs, c_conta, c_prof) 
	values('$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]'
	, '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]'
	, '$data[13]', '$data[14]', '$data[15]', '$data[16]', '$data[17]', '$data[18]'
	, '$c_obs', '$c_conta', '$data[21]')";
	$result3 = mysql_query($query3) or die("Não foi possível inserir suas informações.(Clientes)");
	
	}elseif($data[0] == "int"){
	
	$i_obs = str_replace("<n>", "\n", $data[5]);
	$i_obs = str_replace("<r>", "\r", $i_obs);

	$query5 = "insert into interessados (i_cod, i_nome, i_tel, i_email, i_obs, i_ref, i_tipo, i_data
	, i_status, i_data_status) 
	values('$data[1]', '$data[2]', '$data[3]', '$data[4]', '$i_obs', '$data[6]'
	, '$data[7]', '$data[8]', '$data[9]', '$data[10]')";
	$result5 = mysql_query($query5) or die("Não foi possível inserir suas informações.(Interessados)");
	
	}elseif($data[0] == "loc"){
	
	$query7= "insert into locacao (l_cliente, l_imovel, l_data_ent, l_data_sai
	, l_total, l_pagto, l_limpeza, l_cod, l_historico, l_comissao, l_desp, l_saldo, l_data) 
	values('$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]'
	, '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]', '$data[13]')";
	$result7 = mysql_query($query7) or die("Não foi possível inserir suas informações.(Locação)");
	
	}elseif($data[0] == "usu"){
	
	$query9 = "insert into usuarios (u_nome, u_email, u_senha, u_tipo) 
	values('$data[2]', '$data[3]', '$data[4]', '$data[5]')";
	$result9 = mysql_query($query9) or die("Não foi possível inserir suas informações.(Usuários)");
	
	}elseif($data[0] == "car"){
	
	$query11= "insert into carrinho (ca_usu, ca_imovel, ca_data) 
	values('$data[1]', '$data[2]', '$data[3]')";
	$result11 = mysql_query($query11) or die("Não foi possível inserir suas informações.(Carrinho)");
	
	}
	}
?>
<?php
fclose ($fp);
mysql_close($con);
?>
<h3>Dados Atualizados com sucesso!</h3>