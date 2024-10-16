<?php

function somar_dias_uteis($str_data, $qtd_dias_somar) {
    //Ignora hora se vier no formato datetime
    $str_data = substr($str_data, 0, 10);

    //Se estiver no formato brasileiro converte para o americano
    if (preg_match("@/@",$str_data) == 1 ) {
        $str_data = implode("-", array_reverse( explode("/", $str_data) ));
    }

    //Separa dia, mes e ano
    list($ano, $mes, $dia) = explode('-', $str_data);

    //Contador de dias
    $count_dias = 0;
    $qtd_dias_uteis = 0;

    while ($qtd_dias_uteis < $qtd_dias_somar) {
        $count_dias++;
        
        //Verifica se e feriado
        $sql = "SELECT * FROM feriados WHERE mes = '" . $mes . "' AND dia = '" . ($dia + $count_dias) . "'";
        $res = mysql_query($sql);
        if ($row = mysql_fetch_assoc($res)) {
            //Pula para o proximo loop
            continue;
        }
        //Fim - Verifica se e feriado
        
        //Verifica se e sabado ou domingo
        $dia_da_semana = gmdate('w', strtotime('+' . $count_dias . ' day', mktime(0, 0, 0, $mes, $dia, $ano)));
        if ($dia_da_semana == '0' || $dia_da_semana == '6') {
            //Pula para o proximo loop
            continue;
        }
        //Fim - Verifica se e sabado ou domingo
        
        //Se nao e sabado nem domingo nem feriado entao soma um dia util
        $qtd_dias_uteis++;
    }

    $data_final = gmdate('d/m/Y', strtotime('+' . $count_dias . ' day', strtotime($str_data)));
    return $data_final;
}

?> 
