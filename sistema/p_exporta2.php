#!/dados/htdocs/cgi-bin/php
<?php

$hostname = "localhost";
$username = "root";
$password = "pyc89w";
$db = "test";

	$con = mysql_connect("$hostname", "$username", "$password") or die("Não consegui comunicar com o Banco de Dados");
	$con;
	mysql_select_db("$db");
?>
<?php
$fp = fopen ("/rede/www/html/img_not/dados2.php","w");

	$query1 = "select * from muraski order by cod";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	
	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{
	$titulo = str_replace("\n", "<n>", $not1[titulo]);
	$titulo = str_replace("\r", "<r>", $titulo);
	$descricao = str_replace("\n", "<n>", $not1[descricao]);
	$descricao = str_replace("\r", "<r>", $descricao);
	
	$titulo = AddSlashes($titulo);
	$desc = AddSlashes($descricao);
	$permuta_txt = AddSlashes($not1[permuta_txt]);
	
	$conteudo = "imo|" . $not1[cod] . "|" . $not1[ref] . "|" . $not1[tipo] 
	. "|" . $not1[metragem] . "|" . $not1[n_quartos] . "|" . $not1[valor] . "|" 
	. $not1[especificacao] . "|" . $not1[suites] . "|" . $not1[piscina] . "|" . $titulo 
	. "|" . $descricao . "|" . $not1[local] . "|" . $not1[permuta] . "|" . $not1[finalidade] 
	. "|" . $permuta_txt . "|" . $not1[ftxt_1] . "|" . $not1[ftxt_2] 
	. "|" . $not1[ftxt_3] . "|" . $not1[ftxt_4] . "|" . $not1[ftxt_5] . "|" . $not1[ftxt_6] 
	. "|" . $not1[ftxt_7] . "|" . $not1[ftxt_8] . "|" . $not1[ftxt_9] . "|" . $not1[ftxt_10] 
	. "|" . $not1[ftxt_11] . "|" . $not1[ftxt_12] . "|" . $not1[ftxt_13] 
	. "|" . $not1[ftxt_14] . "|" . $not1[ftxt_15] . "|" . $not1[ftxt_16] 
	. "|" . $not1[ftxt_17] . "|" . $not1[ftxt_18] . "|" . $not1[ftxt_19] 
	. "|" . $not1[ftxt_20] . "|" . $not1[cliente] . "|" . $not1[matricula] 
	. "|" . $not1[cidade_mat] . "|" . $not1[end] . "|" . $not1[averbacao] 
	. "|" . $not1[acomod] . "|" . $not1[dist_mar] . "|" . $not1[dist_tipo] 
	. "|" . $not1[limpeza] . "|" . $not1[diaria1] . "|" . $not1[diaria2] 
	. "|" . $not1[data_inicio] . "|" . $not1[data_fim] . "|" . $not1[comissao] . "|" . "\n";
	
fwrite($fp,$conteudo);

	}
	}
	$query2 = "select * from clientes order by c_cod";
	$result2 = mysql_query($query2);
	$numrows2 = mysql_num_rows($result2);
	
	if($numrows2 > 0){
	while($not2 = mysql_fetch_array($result2))
	{
		
	$c_obs = str_replace("\n", "<n>", $not2[c_obs]);
	$c_obs = str_replace("\r", "<r>", $c_obs);
	$c_conta = str_replace("\n", "<n>", $not2[c_conta]);
	$c_conta = str_replace("\r", "<r>", $c_conta);
	$c_nome = AddSlashes($not2[c_nome]);
	$c_origem = AddSlashes($not2[c_origem]);
	$c_end = AddSlashes($not2[c_end]);
	$c_bairro = AddSlashes($not2[c_bairro]);
	$c_cidade = AddSlashes($not2[c_cidade]);
	$c_email = AddSlashes($not2[c_email]);
	$c_obs = AddSlashes($c_obs);
	$c_conta = AddSlashes($c_conta);
	$c_prof = AddSlashes($not2[c_prof]);
	
	$conteudo2 = "cli|" . $not2[c_cod] . "|" . $c_nome . "|". $not2[c_cpf] 
	. "|" . $not2[c_rg] . "|" . $not2[c_civil] . "|" . $c_origem . "|" . $c_end 
	. "|" . $c_bairro . "|" . $not2[c_cep] . "|" . $c_cidade . "|" . $not2[c_estado] 
	. "|" . $not2[c_tel] . "|" . $not2[c_cel] . "|" . $not2[c_fax] . "|" . $c_email 
	. "|" . $not2[c_nasc] . "|" . $not2[c_desde] . "|" . $not2[c_tipo] 
	. "|" . $c_obs . "|" . $c_conta . "|" . $not2[c_prof] . "|" . "\n";
	
fwrite($fp,$conteudo2);

	}
	}

	$query3 = "select * from interessados order by i_cod";
	$result3 = mysql_query($query3);
	$numrows3 = mysql_num_rows($result3);
	
	if($numrows3 > 0){
	while($not3 = mysql_fetch_array($result3))
	{
		
	$i_obs = str_replace("\n", "<n>", $not3[i_obs]);
	$i_obs = str_replace("\r", "<r>", $i_obs);
	
	$i_nome = AddSlashes($not3[i_nome]);
	$i_tel = AddSlashes($not3[i_tel]);
	$i_email = AddSlashes($not3[i_email]);
	$i_obs = AddSlashes($i_obs);
	
	$conteudo3 = "int|" . $not3[i_cod] . "|" . $i_nome . "|" . $i_tel . "|" 
	. $i_email . "|" . $not3[i_obs] . "|" . $not3[i_ref] . "|" 
	. $not3[i_tipo] . "|" . $not3[i_data] . "|" . $not3[i_status] . "|" 
	. $not3[i_data_status] . "|" . "\n";
	
fwrite($fp,$conteudo3);

	}
	}

	$query4 = "select * from locacao order by l_cod";
	$result4 = mysql_query($query4);
	$numrows4 = mysql_num_rows($result4);
	
	if($numrows4 > 0){
	while($not4 = mysql_fetch_array($result4))
	{
	$conteudo4 = "loc|" . $not4[l_cliente] . "|" . $not4[l_imovel] . "|" 
	. $not4[l_data_ent] . "|" . $not4[l_data_sai] . "|" . $not4[l_total] . "|" 
	. $not4[l_pagto] . "|" . $not4[l_limpeza] . "|" . $not4[l_cod] . "|" 
	. $not4[l_historico] . "|" . $not4[l_comissao] . "|" . $not4[l_desp] . "|" 
	. $not4[l_saldo] . "|" . $not4[l_data] . "|" . "\n";
	
fwrite($fp,$conteudo4);

	}
	}

	$query5 = "select * from usuarios order by u_cod";
	$result5 = mysql_query($query5);
	$numrows5 = mysql_num_rows($result5);
	
	if($numrows5 > 0){
	while($not5 = mysql_fetch_array($result5))
	{
	$conteudo5 = "usu|" . $not5[u_cod] . "|" . $not5[u_nome] . "|" 
	. $not5[u_email] . "|" . $not5[u_senha] . "|" . $not5[u_tipo] . "|" . "\n";
	
fwrite($fp,$conteudo5);

	}
	}

	$query6 = "select * from carrinho order by ca_usu";
	$result6 = mysql_query($query6);
	$numrows6 = mysql_num_rows($result6);
	
	if($numrows6 > 0){
	while($not6 = mysql_fetch_array($result6))
	{
	$conteudo6 = "car|" . $not6[ca_usu] . "|" . $not6[ca_imovel] . "|" 
	. $not6[ca_data] . "|" . "\n";
	
fwrite($fp,$conteudo6);

	}
	}
?>
<?php
fclose ($fp);
mysql_free_result($result1);
mysql_free_result($result2);
mysql_free_result($result3);
mysql_free_result($result4);
mysql_free_result($result5);
mysql_free_result($result6);
mysql_close($con);
?>
<h3>Dados Exportados com sucesso!</h3>