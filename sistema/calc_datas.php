<?php

// Dados iniciais
$data_inicial = '2009-01-01';
$data_final = '2009-12-01';
$data_nova = $data_inicial;
$data_lista = array();
$dia_vencimento = '10';

// Separa os dados para usar na função mktime
list($ano_ini, $mes_ini, $dia_ini) = explode('-', $data_inicial);
list($ano_fim, $mes_fim, $dia_fim) = explode('-', $data_final);

// Se o dia do vencimento for maior que o dia da data final no intervalo diminui um
// mês na data final para que a última data não ultrapasse o dia do vencimento
if ($dia_vencimento > $dia_fim) {
    $mes_fim = $mes_fim - 1;
    $data_final = date('Y-m-d', mktime(0, 0, 0, $mes_fim, $dia_fim, $ano_fim));
}

// Enquanto a data nova for menor que a data final
while ($data_nova <= $data_final) {
    // Adiciona a data nova na lista de datas
    array_push($data_lista, $data_nova);
    
    // Calcula a nova data
    ++$mes_ini;
    $data_nova = date('Y-m-d', mktime(0, 0, 0, $mes_ini, $dia_ini, $ano_ini));
}

// Agora $data_lista possui todas as datas no intervalo
// passado não ultrapassando o dia do vencimento
var_dump($data_lista);

?>