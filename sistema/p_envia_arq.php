<html>

<head>
<?php
include("style.php");
?>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" background="images/fundo_topo.jpg">	
<? include("topo.php"); ?>
</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php
include("menu.php");
?></td>
  </tr>
</table>
<p align="center"><font color="#000080" size="2" face="Arial"><b>Enviar Arquivos do Sistema</b>
<br><br>
<?php 
/* how many upload slots? */ 
define("UPLOAD_SLOTS", 5); 

/* where to move the uploaded file(s) to? */ 
define("INCOMING", "/rede/www/html/muraski/");

if($REQUEST_METHOD!="POST") 
{ 
    /* generate form */ 
    echo "<form enctype=\"multipart/form-data\" method=post>\n"; 
    for($i=1; $i<=UPLOAD_SLOTS; $i++) 
    { 
        echo "<input type=file name=infile$i><br>\n"; 
    } 
    echo "<input type=submit value=Enviar Arquivo></form>\n"; 
} 
else 
{ 
    /* handle uploads */ 
    $noinput = true; 
    for($i=1; $noinput && ($i<=UPLOAD_SLOTS); $i++) 
    { 
        if(${"infile".$i}!="none") $noinput=false; 
    } 
    if($noinput) 
    { 
        echo "error uploading. create 150MB coredump instead?"; 
        exit(); 
    } 


    for($i=1; $i<= UPLOAD_SLOTS; $i++) 
    { 
        if(${"infile".$i}){ 

	         $file = strtolower(${"infile".$i."_name"});
	         copy(${"infile".$i}, INCOMING.${file});
            echo "O arquivo <b><i>". ${"infile".$i."_name"}." </i></b>foi enviado com sucesso.<br><br>"; 
        }
    }




    echo '<br><br><font color="#000000" face="Arial" size="2"><a href="javascript:history.back()"><< Voltar <<</a>';
} /* else */ 
?> 

</body>

</html>