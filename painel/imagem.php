<?php
/*
 Utilize este script livremente e compartilhe seus conhecimentos com os demais,
 pois assim todos se beneficiam.
 --------------------------------------------------------------------------------
 | Riqueza � para o s�bio o que ele faz pelos outros.                           |
 | Quanto mais ele doa aos outros mais rico ele se torna.                       |
 | Assim como de Tao brota a vida, assim age o s�bio sem ferir ningu�m          |
 |                                                                              |
 | Lao Ts�                                                                      |
 --------------------------------------------------------------------------------
 http://curso.divinaciencia.com
*/
//Configura��es
  //Imagem
   $x = 125;
   $y = 40;
   $tam = 22;

  //N�mero rand�mico
  $chars = "abcdefghijklmnopqrstuvwxyz0123456789"; //caracteres que formar�o o c�digo
  $length = 4; //n�mero m�ximo de caracteres do c�digo
  
//Gera c�digo rand�mico e grava na sess�o
$codigo = "";
  for ($i=0;$i<$length;$i++){
     $codigo.= substr($chars, rand(1, strlen($chars) ), 1);
  }
  
$entre_char = $x /(strlen($codigo)+1);

 ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
 $_SESSION['codigo'] = $codigo;

//Defines as cores e gera imagem truecolor
$img = imagecreatetruecolor($x, $y);
$fundo = imagecolorallocate($img,255,255,255);
$borda = imagecolorallocate($img,0,0,128);
$cores[] = imagecolorallocate($img,128,64,192);
$cores[] = imagecolorallocate($img,192,64,128);
$cores[] = imagecolorallocate($img,0,37,178);

imagefilledrectangle($img,1,1,$x-2,$y-2,$fundo);
imagerectangle($img,0,0,$x-1,$y-1,$borda);

//Gera posi��o e tamanho aleat�rios dos caracteres
for($i=0; $i < strlen($codigo); $i++)
{
  $cor = $cores[$i % count($cores)];
  imagettftext(
        $img,
        $tam + rand(0,10),
        3 + rand(0,20),
        ($i + 0.3) * $entre_char,
        30 + rand(0,10),
        $cor,
        'arial.ttf',
        $codigo{$i}
  );
}

//Gera as linhas aleat�rias de fundo da imagem
for($i=0; $i<150; $i++)
{
  $x1 = rand(5, $x - 5);
  $y1 = rand(5, $y - 5);
  $x2 = $x1 - 4 + rand(0,10);
  $y2 = $y1 - 4 + rand(0,10);
  imageline($img, $x1, $y1, $x2, $y2, $cores[rand(0,count($cores) - 1)]);
}

//Sa�da da imagem no navegador
header('Content-type: image/png');
imagepng($img);
 ?>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
