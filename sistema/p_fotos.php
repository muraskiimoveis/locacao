<?php
//set_time_limit(0);


function VerificaFotoDaPasta($nome_foto,$seq_foto){

	if(($nome_foto<>"") and ($seq_foto<>"")){
		//
		$busca_imovel = "select cod, ref from muraski where ref='".$nome_foto."'  and cod_imobiliaria='3'";
		$rsimovel = mysql_query($busca_imovel) or die ("Erro 225 - " . mysql_error());
		if (mysql_num_rows($rsimovel) > 0) {

			while ($nv1 = mysql_fetch_assoc($rsimovel)) {
				$cod_imovel = $nv1['cod'];
				$ref = $nv1['ref'];
				//
				$sql_pesq = "  cod =".$cod_imovel." and ref = '".$ref."' and sequencia ='".$seq_foto."'";
				$sql_busca ="select idfoto from fotos where ".$sql_pesq; 
				$rsbusca = mysql_query($sql_busca) or die ("Erro 225 - " . mysql_error());
				if (mysql_num_rows($rsbusca) > 0) {
					return true;
				} else { return false;}

			}

		} else { return false;}
		
	} else { return false;}
	
}


function VerificaFotoNoSite($nome_foto,$seq_foto,$cod_imovel){

	$sql_pesq2 = "  cod =".$cod_imovel." and ref = '".$nome_foto."' and sequencia ='".$seq_foto."'";
	$sql_busca2 ="select site from fotos where ".$sql_pesq2; 
	$rsbusca2 = mysql_query($sql_busca2) or die ("Erro 225 - " . mysql_error());
	if (mysql_num_rows($rsbusca2) > 0) {
		while ($nv2 = mysql_fetch_assoc($rsbusca2)) {
			if($nv2['site']=="S"){return true;}else{return false;}
		}
	} else { return  false;}
	
}

function VerificaFotoNoSite2($nome_foto,$seq_foto,$cod_imovel){

	$sql_pesq2 = "  cod =".$cod_imovel." and ref = '".$nome_foto."' and sequencia ='".$seq_foto."'";
	$sql_busca2 ="select site from fotos where ".$sql_pesq2; 
	$rsbusca2 = mysql_query($sql_busca2) or die ("Erro 225 - " . mysql_error());
	if (mysql_num_rows($rsbusca2) > 0) {
		return true;
	} else { return  false;}
	
}


function AtualizaFotoNoSite($tipo_envio,$nome_foto,$seq_foto,$cod_imovel){

		if($tipo_envio == "Enviar"){
			$sql_enviar = "UPDATE fotos SET site='S' where  cod = ".$cod_imovel. "  and  ref = '".$nome_foto."' and sequencia = '".$seq_foto."'";
			$rs_enviar = mysql_query($sql_enviar) or die ("Erro 370 - ".mysql_error());
		}elseif($tipo_envio == "Retirar"){
			$sql_enviar = "UPDATE fotos SET site='N' where  cod = ".$cod_imovel. " and  ref = '".$nome_foto."' and sequencia = '".$seq_foto."'";
			$rs_enviar = mysql_query($sql_enviar) or die ("Erro 370 - ".mysql_error());
		}

}

function ApagaFotoNoSite($nome_foto2,$seq_foto2,$cod_imovel2){

	if (VerificaFotoNoSite2($nome_foto2,$seq_foto2,$cod_imovel2)){
		$sql_apagar = "DELETE FROM fotos WHERE  cod = ".$cod_imovel2. "  and  ref = '".$nome_foto2."' and sequencia = '".$seq_foto2."'";
		$rs_apagar = mysql_query($sql_apagar) or die ("Erro 370 - ".mysql_error());
		return $rs_apagar;
	}else{return false;}
}

function InsereFotoNoSite($nome_pasta,$nome_foto2,$seq_foto2,$cod_imovel2){
       $site ="S";
	if (!VerificaFotoNoSite($nome_foto2,$seq_foto2,$cod_imovel2)){
		$sql_insere = "INSERT INTO fotos  (cod,ref,sequencia,site,pasta) VALUES (".$cod_imovel2.",'".$nome_foto2."','".$seq_foto2."','".$site."','".$nome_pasta."')";
		//echo "Mostra ==> ".$sql_insere;
		$rs_insere = mysql_query($sql_insere) or die ("Erro 370 - ".mysql_error());
		return $rs_insere;
	}
}

?>
