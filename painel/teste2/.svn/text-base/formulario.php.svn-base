<?php
/*
 Utilize este script livremente e compartilhe seus conhecimentos com os demais,
 pois assim todos se beneficiam.
 --------------------------------------------------------------------------------
 | Riqueza é para o sábio o que ele faz pelos outros.                           |
 | Quanto mais ele doa aos outros mais rico ele se torna.                       |
 | Assim como de Tao brota a vida, assim age o sábio sem ferir ninguém          |
 |                                                                              |
 | Lao Tsé                                                                      |
 --------------------------------------------------------------------------------
 http://curso.divinaciencia.com
*/

// Recupera o código randomico e termina a sessão
session_start();
if(IsSet($_SESSION["codigo"]))
   {
    $random = $_SESSION["codigo"];
    $_SESSION = array();
    session_destroy();
   }

// obtém o código digitado
$codigo = $_POST["codigo"];
$envio = $_POST["envio"];

// verifica se o formulário contém dados
 if (isset($envio) and $codigo == $random)
 {
   $mensagem = "Parabéns.\\n O código foi digitado corretamente.";
 }
     elseif(isset($envio) and $codigo != $random)
     {
       $mensagem = "Erro!\\n Por favor tente novamente.";
     }

if ($mensagem)
   {
   $onload_msg = "<body onLoad=\"javascript: alert('$mensagem')\"> ";
   }

echo $onload_msg;
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Formulário anti-robots</title>
</head>

<body>
   <table width="100%" style="border:1px solid #2561DE" cellspacing="0" bgcolor="#F5FBFB" cellpadding="0" align="center">
   <tbody>
      <tr>
         <td><br>
              <table border="0" width="40%" align="center">
              <form name="form1" action="formulario.php" method="post">
               <tbody>
              <tr>
              <td align="center" height = "50"><u><h2>Formulário anti-robots</h2></u></td>
              </tr>

               <tr>
               <td align="center" height = "50">
               Digite o código abaixo:
               <input type=text name="codigo" size = "12">
               </td></tr>

               <!-- gera imagem com número aleatório -->
               <tr><td align="center">
               <img src="imagem.php">
               </td></tr>
               
               <tr>
               <td align="center">
               <input type="submit" name="Submit" value="Enviar">
               <input type="reset" name="Submit" value="Limpar">
               <input type="hidden" name="envio" value="true">
               </td>
               </tr>

               <tr>
               <td align="center" height = "50">
               <a href="http://curso.divinaciencia.com" title="Curso online e gratuito">
               http://curso.divinaciencia.com</a></td>
               </tr>
               </tbody>
               </table>
          </tbody>
          </table>
          </form>
          <script language="JavaScript">
          document.form1.codigo.focus();
          </script>
</body>
</html>
