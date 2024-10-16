<?php
function retira_acentos( $name ) 
{ 
  $array1 = array(   "б", "а", "в", "г", "д", "й", "и", "к", "л", "н", "м", "о", "п", "у", "т", "ф", "х", "ц", "ъ", "щ", "ы", "ь", "з" 
                     , "Б", "А", "В", "Г", "Д", "Й", "И", "К", "Л", "Н", "М", "О", "П", "У", "Т", "Ф", "Х", "Ц", "Ъ", "Щ", "Ы", "Ь", "З"," ","'","ґ","`","/","\\","~","^","Ё" ); 
  $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c" 
                     , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C","_","_","_","_","_","_","_","_","_" ); 
  return str_replace( $array1, $array2, $name ); 
}

//Funзгo alterada nos cбlculos de altura e largura
function criar_thumbnail($origem='',$destino='',$largura='',$pre='tn_',$formato='JPEG') { 

    switch($formato) 
    { 
        case 'JPEG': 
            $tn_formato = 'jpg'; 
            break; 
        case 'PNG': 
            $tn_formato = 'png'; 
            break; 
    } 
    $ext = split("[/\\.]",strtolower($origem)); 
    $n = count($ext)-1; 
    $ext = $ext[$n]; 

    $arr = split("[/\\]",$origem); 
    $n = count($arr)-1; 
    $arra = explode('.',$arr[$n]); 
    $n2 = count($arra)-1; 
    $tn_name = str_replace('.'.$arra[$n2],'',$arr[$n]); 
    //$destino = $destino.$pre.$tn_name.'.'.$tn_formato;
    $destino = $destino;

    if ($ext == 'jpg' || $ext == 'jpeg'){ 
        $im = imagecreatefromjpeg($origem); 
    }elseif($ext == 'png'){ 
        $im = imagecreatefrompng($origem); 
    }elseif($ext == 'gif'){ 
        return false; 
    } 
    $w = imagesx($im); 
    $h = imagesy($im); 
    $nw = $largura;
    $nh = ($h * $largura)/$w;
    if(function_exists('imagecopyresampled')) 
    { 
        if(function_exists('imageCreateTrueColor')) 
        { 
            $ni = imageCreateTrueColor($nw,$nh); 
        }else{ 
            $ni    = imagecreate($nw,$nh); 
        } 
        if(!@imagecopyresampled($ni,$im,0,0,0,0,$nw,$nh,$w,$h)) 
        { 
            imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h); 
        } 
    }else{ 
        $ni    = imagecreate($nw,$nh); 
        imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h); 
    } 
    if($tn_formato=='jpg'){ 
        imagejpeg($ni,$destino,100); 
    }elseif($tn_formato=='png'){ 
        imagepng($ni,$destino); 
    } 
}
?>