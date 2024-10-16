<?

$pasta1 = "../imobiliarias/murask/venda_peq";

$strDiretorio1 = $pasta1; // pasta das imagens
$strDiretorioAbrir = opendir($strDiretorio1);

	$i = 0;
	$m = 0;
	$arquivos = array();

while(false !== ($strArquivos = readdir($strDiretorioAbrir))) {
	 if($strArquivos != "." && $strArquivos != "..")
	 {	
		  $arq[$i] = substr($strArquivos,0,$tm);
	 	  $arq2[$i] = $strArquivos;
		  $arqF[$i] = "venda";
	 	  $i++;
	 }
}

for($i = 0 ; $i <= count($arq2) ; $i++)
{
	if(!empty($arq2[$i]))
	{
		if((strpos($str[$i],'@') == true) OR (strtolower($arq[$i]) == strtolower($chave)))
		{
		 	 $arquivos[$i] = $arq2[$i];
			 $fold_arquivos[$i] = $arqF[$i];
		 	 $m++;
		}
    }
    
   	$foto_peq = str_replace(".jpg","_peq.jpg","$arquivos[$i]");
	rename($pasta1."/".$arquivos[$i], $pasta1."/".$foto_peq);
}

echo "Todas as fotos renomeadas";

?>