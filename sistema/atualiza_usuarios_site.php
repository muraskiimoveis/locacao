<?php
$cmd1="sudo ./exporta.sh";
$cmd2="sudo ./importa.sh";
passthru($cmd1,$retorna1);
if($retorna1 == 0){ 
	//echo "Tabelas Exportadas com Sucesso!"."<BR>";
    passthru($cmd2,$retorna2);	
    if($retorna2 == 0){ 
		//echo "Tabelas Atualizadas com Sucesso!"."<BR>";
	}else{ 
		//echo "Tabelas não Atualizadas!!"."<BR>";
	}	
}else{ 
	 //echo "Tabelas não Exportadas!!"."<BR>";
}
?>
