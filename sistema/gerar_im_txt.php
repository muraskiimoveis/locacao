<?
/*
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
*/
set_time_limit(0);
session_start();
include("conect.php");
include("funcoes/funcoes.php");

function limpeza($conteudo) {

   $conteudo = str_replace("\n","", $conteudo);
   $conteudo = str_replace("\r","", $conteudo);
   return $conteudo;

}

if (file_exists("murask.txt")) {

   unlink("murask.txt");

}
   $filename = "muraski.csv";

   header("Content-type: text/plain");
   header("Content-Length: $size");
   header("Content-Disposition: attachment; filename=$filename");
   header("Pragma: no-cache");
   header("Expires: 0");

//   header("Content-Disposition: attachment; filename=$filename");

   $cod_imob = "3";
   $nome_pasta = "murask";

	$qry	= "SELECT cod, cod_imobiliaria, finalidade, tipo, ref, valor, end, numero, local,
   uf, bairro, titulo, descricao, permuta, permuta_txt, metragem, n_quartos, suites,
   dist_mar, disp_rede, comissao_parceria, destaque, coordenadas FROM muraski WHERE
   cod_imobiliaria = '".$cod_imob."' and ref <> 'x'";

	$resultado	= mysql_query($qry) or die ("Erro 15 - ".mysql_error());

//   $saida = fopen("murask.txt","a+");

   echo "cod;cod_imobiliaria;finalidade;tipo;ref;valor;end;numero;local;uf;bairro;titulo;descricao;permuta;permuta_txt;metragem;n_quartos;suites;dist_mar;disp_rede;comissao_parceria;comissao_parceria;destaque;coordenadas;imagens\n";

	while ($linha=mysql_fetch_array($resultado)) {
		$conteudo = "\"".limpeza($linha['cod'])."\";"; //campo 1
		$conteudo .= "\"".limpeza($linha['cod_imobiliaria'])."\";"; //campo 2
		$conteudo .= "\"".limpeza($linha['finalidade'])."\";"; //campo 3
		$conteudo .= "\"".limpeza($linha['tipo'])."\";"; //campo 4
		$conteudo .= "\"".limpeza($linha['ref'])."\";"; //campo 5
		$conteudo .= "\"".limpeza($linha['valor'])."\";"; //campo 6
		$conteudo .= "\"".limpeza($linha['end'])."\";"; //campo 7
		$conteudo .= "\"".limpeza($linha['numero'])."\";"; //campo 8
		$conteudo .= "\"".limpeza($linha['local'])."\";"; //campo 9
		$conteudo .= "\"".limpeza($linha['uf'])."\";"; //campo 10
		$conteudo .= "\"".limpeza($linha['bairro'])."\";"; //campo 11
		$conteudo .= "\"".limpeza($linha['titulo'])."\";"; //campo 12
		$conteudo .= "\"".limpeza($linha['descricao'])."\";"; //campo 13
  		$conteudo .= "\"".limpeza($linha['permuta'])."\";"; //campo 14
		$conteudo .= "\"".limpeza($linha['permuta_txt'])."\";"; //campo 15
		$conteudo .= "\"".limpeza($linha['metragem'])."\";"; //campo 16
		$conteudo .= "\"".limpeza($linha['n_quartos'])."\";"; //campo 17
		$conteudo .= "\"".limpeza($linha['suites'])."\";"; //campo 18
		$conteudo .= "\"".limpeza($linha['dist_mar'])."\";"; //campo 19
		$conteudo .= "\"".limpeza($linha['disp_rede'])."\";"; //campo 20
		$conteudo .= "\"".limpeza($linha['comissao_parceria'])."\";"; //campo 21
		$conteudo .= "\"".limpeza($linha['destaque'])."\";"; //campo 22
		$conteudo .= "\"".limpeza($linha['coordenadas'])."\";"; //campo 23

      //Imagens
      $venda = "../imobiliarias/".$nome_pasta."/venda/";
      $loca = "../imobiliarias/".$nome_pasta."/locacao/";
      if ($not[finalidade] <= 7) {
         $pasta = $venda;
      } else {
   	   $pasta = $loca;
      }

      $abre = opendir($pasta);
      $imgs = "-";
      while ($imagem = readdir($abre)) {
         if (strpos("--".$imagem, "-".$linha[ref]."_")) {
            $imgs .= $imagem."-";
         }
      }
		$conteudo .= "\"".$imgs."\";"; //campo 24
      // Fim das Imagens

		if(strlen($linha)>1){
			$conteudo .= "\n";
		}

//      echo $conteudo."<BR> ---------------- \n\r<BR>";
echo $conteudo;
//		$result = fputs($saida,$conteudo);
	}
//	fclose($saida);
//	echo "<a href='murask.txt'>TXT Gerado com sucesso!</a>";

?>