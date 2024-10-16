<?
   $im_endereco = $_SESSION['im_endereco'];
   $im_fone = $_SESSION['im_fone']; 
   $cidadei = $_SESSION['cidadei']; 
   $estadoi = $_SESSION['estadoi']; 
   $emailim = $_SESSION['email_imo'];
?>
<span class="style1"><?=$im_endereco; ?> - <?=$cidadei; ?> - <?=$estadoi; ?><br />
Tel: <?=$im_fone; ?> / E-mail: <?=$emailim; ?></span>