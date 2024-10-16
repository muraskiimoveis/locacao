<?php

/* ********************************** */
/* *  Copie a vontade, mas deixe    * */
/* *     isso aqui pelo menos       * */
/* * fitinge - fitinge@terra.com.br * */
/* ********************************** */

function func_data($data_in, $data_out)
{
    #pega a data de saida em UNIX_TIMESTAMP e diminui da data de entrada UNIX_TIMESTAMP
    $data_entre = $data_out - $data_in;
    #divide a diferenca das datas pelo numero de segundos de um dia e arredonda, para saber o numero de dias inteiro que tem
    $dias = floor($data_entre/86400);
    $dias2 = $dias;
    $day = 0;
    $nao_util = 0;
    #pega dia, mes e ano da data de entrada
    $d = date('d', $data_in);
    $m = date('m', $data_in);
    $y = date('Y', $data_in);
    #pega mes e ano da data de saida
    $m2 = date('m', $data_out);
    $y2 = date('Y', $data_out);
    #conta o numero de dias do mes de entrada
    $days_month = date("t", $data_in);
    
    #se o dia da entrada + total de dias for menor que total de dias do mes, ou seja, se não passar do mesmo mês.
    if($dias+$d <= $days_month)
    {
        for ($i = 0; $i <= $dias; $i++)
        {
            $day++;
            #checa o dia da semana para cada dia do mês, se for igual a 0 (domingo) ou 6 (sabado) ele adiciona 1 no dia não útil
            if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 || (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 6))
            {
                    $nao_util++;
              }
            else
            {
                #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
                $res = mysql_query("SELECT * FROM feriados WHERE mes = $m AND dia = $d+$i");
                if($row = mysql_fetch_assoc($res))
                {
                    $nao_util++;
                }
            }
        }
    }
    #se o dia da entrada + total de dias for maior que total de dias do mes, ou seja, se passar do mesmo mês.
    else
    {
        #enquanto o mês de entrada for diferente do mês de saida ou ano de entrada for diferente do ano de saida.
        while($m != $m2 || $y != $y2)
        {
            #pega total de dias do mes de entrada
            $days_month = date("t", mktime (0,0,0,$m,$d,$y));
            for ($i = 0; $i <= $dias2; $i++)
            {
                $day++;
                #checa o dia da semana para cada dia do mês, se for igual a 0 (domingo) ou 6 (sabado) ele adiciona 1 no dia não útil
                if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 || (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 6))
                {
                    $nao_util++;
                  }
                else
                {
                    #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
                    $res = mysql_query("SELECT * FROM feriados WHERE mes = $m AND dia = $d+$i");
                    if($row = mysql_fetch_assoc($res))
                    {
                        $nao_util++;
                    }
                }
            }
            #se o mes for igual a 12 (dezembro), mes recebe 1 (janeiro) e ano recebe +1 (próximo ano)
            if($m == 12)
            {
                $m = 1;
                $y++;
            }
            else
            #mês recebe mais 1 para fazer o mesmo processo do próximo mês
            {
                $m++;
            }
            $d = 1;
            $dias2 = $dias2 - $day;
        }
    }

    $dias = $day-$nao_util; //. " dias uteis<br>";
    echo $dias;
    /*
    echo $day . " dias corridos<br>";
    echo $nao_util . " dias nao uteis<br>";
    $para_hora = $data_entre - (86400 * $dias);
    $horas = floor($para_hora/3600);
    echo $horas . " horas<br>";
    $para_minuto = $para_hora - (3600 * $horas);
    $minutos = floor($para_minuto/60);
    echo $minutos . " minutos<br>";
    $para_segundo = $para_minuto - (60 * $minutos);
    echo $para_segundo . " segudos<br>";
    */

}

#Aqui é oque vai ser utilizado! Para funcionar, chame a funcão jogando os valores da data de entrada e data de saida em UNIX_TIMESTAMP

#Aqui para teste pega a data do momento como entrada
//$data_entrada = date(mktime());
#Aqui para teste pega a data do momento e adiciona 8542841 como saida
//$data_saida = date(mktime()+8542841);
#chama a função func_data passando a data de entrada e data de saida (lembrando que é em UNIX_TIMESTAMP
//func_data($data_entrada, $data_saida);

?> 