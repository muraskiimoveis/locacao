<?

$nomeArquivo = '001.jpg';
$estouProcurando = '001';
$expReg = "/^$estouProcurando\.(jpg|jpeg|gif|png)$/";

if (preg_match($expReg, $nomeArquivo)) {
    //o nome do arquivo � exatamente o que estava procurando :)
}

?>