<HTML>
<HEAD>
 <TITLE>Documento PHP</TITLE>
</HEAD>
<BODY>
<?
include("conect.php");

function verificaTolera(){
		$qry_hora = "select now() as hora";
		$res_hora = mysql_query($qry_hora);
		$nrows_hora = mysql_num_rows($res_hora);
		$not_hora = mysql_fetch_array($res_hora);
        $hora_atual = $not_hora['hora'];
        return strtotime($hora_atual);
}

function calcular_tempo_trasnc($hora1,$hora2){
    $separar[1]=explode(':',$hora1);
    $separar[2]=explode(':',$hora2);

    $total_minutos_trasncorridos[1] = ($separar[1][0]*60)+$separar[1][1];
    $total_minutos_trasncorridos[2] = ($separar[2][0]*60)+$separar[2][1];
    $total_minutos_trasncorridos = ($total_minutos_trasncorridos[1]-$total_minutos_trasncorridos[2])*-1;
    return $total_minutos_trasncorridos;
    
}

$im_tolera = 15;
$hora_padrao = date('H:i',strtotime("08:00 +".$im_tolera." minutes"));
//$hora_banco = date('H:i',ver_hora_server());
$hora_banco = date('H:i',strtotime("08:15"));
echo "Hora de Tolerancia ==> ".$hora_padrao."<BR>";
echo "Hora Chegada ==> ".$hora_banco."<BR>";
$tempo = calcula_minutos($hora_padrao,$hora_banco);
echo "Tempo Calculado ==> ".$tempo."<BR>";

if ($tempo > 0){
  echo $tempo." Minutos atrasados ";
}else{ echo "Dentro do Horario..!";}
?>

</BODY>
</HTML>
