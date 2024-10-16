<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', '1');
ini_set('display_startup_errors', TRUE);

include("sistema/conect.php");
//include("funcoes/funcoes.php");

//chdir( '../imobiliarias/murask/venda/' );
//$arquivos = glob("{*.jpg,*.jpeg}", GLOB_BRACE);
//foreach($arquivos as $img) echo $img;

//Usando as funções padrão para diretórios do PHP:

$types = array('jpg', 'jpeg');
$vetor = array();
if ( $handle = opendir('imobiliarias/murask/venda/') ) {
    while ( $entry = readdir( $handle ) ) {
        $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
        if( in_array( $ext, $types ) ) $vetor[] = $entry;
    }
    closedir($handle);
}

// Ordena o vetor
sort($vetor);

// Vetor do não enontrado
$semfoto = array();

// Exibe os arquivos
foreach ($vetor as $arquivos) {

	$nome_foto = str_replace(".jpg","",$arquivos);
	$foto = substr($nome_foto,0,strpos($nome_foto,"_"));
	$sequencia = substr($nome_foto,strpos($nome_foto,"_")+1,strlen($nome_foto));
	//echo $foto."<br>".$sequencia;
	//die();

	$query_consulta = "select * from fotos where ref = '".$foto."' and sequencia = '".$sequencia."'";
	$result = mysql_query($query_consulta) or die(mysql_error());
	$row = mysql_num_rows($result);
	if($row <= 0 ){
		echo "Ref.=> ".$foto."_".$sequencia."";
		$semfoto[] = $foto."_".$sequencia;
	}

}
sort($semfoto);
echo print_r($semfoto,true); //json_encode($semfoto); 

?>
