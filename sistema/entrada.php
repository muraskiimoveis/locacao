
<script language="javascript">
function VerificaCampo()
{

	   if(document.form1.senha.value.length==0)
	   {
		       alert("Por favor, preencha o campo Senha");
    		   document.form1.senha.focus();
    		   return (false);
       }
       if(document.form1.senha_web.value.length==0)
	   {
		       alert("Por favor, preencha o campo Senha Web");
    		   document.form1.senha_web.focus();
    		   return (false);
       }

return(true);

}

<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
var keyCode = (isNN) ? e.which : e.keyCode; 
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}
//  End -->
</script>
<body onLoad="document.form1.senha.focus()">
<form method="post" name="form1" id="form1" action="index.php">
<link href="style.css" rel="stylesheet" type="text/css" />
<table width="100%" height="435" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table width="100%" height="400" border="0" align="center" cellpadding="0" cellspacing="10">
      <tr>
        <td align="right"><table width="400" border="0" align="center" cellspacing="1" bgcolor="#E0E0E0">
        <tr>
		   <td colspan="2" align="center" class="style1">Digite seu e-mail e sua senha para acessar a<br>Intranet da Muraski Imóveis.</td>
		</tr>
        <tr>
         <td width="89" bgcolor="#EDEEEE" class="style1">Senha:</td>
         <td width="304" bgcolor="#EDEEEE" class="style1" align="left"><input type="password" name="senha" id="senha" size="6" class="campo" maxlenght="6" value="<?=$senha ?>" onKeyUp="return autoTab(this, 6, event);"> (6 dígitos)</td>
        </tr>
<?php
	$ip_servidor = $_SERVER['REMOTE_ADDR'];
	//echo $ip_servidor;
	$ip = explode(".", $ip_servidor);
	//echo $ip[0] . "." . $ip[1] . "." . $ip[2] . ".";
	if(($ip[0] != "192") or ($ip[1] != "168") or ($ip[2] != "10")){
	//if(($ip[0] != "201") or ($ip[1] != "21") or ($ip[2] != "149")){
?>
    <tr>
      <td width="89" bgcolor="#EDEEEE" class="style1">Senha Web:</b></td>
      <td width="304" bgcolor="#EDEEEE" class="style1" align="left"><input type="password" name="senha_web" id="senha_web" size="6" class="campo" maxlenght="6" value="<?=$senha_web ?>"> (6 dígitos)</td>
    </tr>
    <input type="hidden" name="acesso_web" class="campo" value="1">
<?php
	}
?>
    <tr>
       <td width="89"></td>
       <td width="304" align="left"><input type="submit" value="Entrar" name="bot" class="campo3" Onclick="VerificaCampo();"></td>
    </tr>
  </table>
</table></td>
</tr>
</table>
</form>
</body>
<?php
mysql_close($con);
?>

