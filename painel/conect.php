<?php

//Banco Ar
#$hostname = "mysql.redebrasileiradeimoveis.com.br";
#$username = "redeb9br";
#$password = "12rede47";
#$db = "redeb9br";

//Site Muraski
#$hostname_site = "mysql.muraski.com";
#$username_site = "muras3br";
#$password_site = "56mura41";
#$db_site = "muras3br";

//Sistema Interno Muraski
$hostname_sistema = "localhost";
$username_sistema = "root";
$password_sistema = "cl@#d1rm#r@sk1";
$db_sistema = "Sistema";

    //Conexao
#    $con = mysql_connect("$hostname", "$username", "$password") or die("Não consegui comunicar com o Banco de Dados 32");
#    mysql_select_db("$db",$con);

    //Conexao Site Muraski
#    $con_site = mysql_connect("$hostname_site", "$username_site", "$password_site") or die("Não consegui comunicar com o Banco de Dados 36");
#    mysql_select_db("$db_site",$con_site);

    //Conexao Sistema Interno Muraski
    $con = mysql_connect("$hostname_sistema", "$username_sistema", "$password_sistema") or die("Não consegui comunicar com o Banco de Dados 40");
    mysql_select_db("$db_sistema",$con);
?>
