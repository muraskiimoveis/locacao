<script>
function valida()
{
if (form1.email.value == "")
  {
    alert("Por favor, digite o e-mail");
    form1.email.focus();
    return (false);
  }

  if (form1.email.value != '') {
    var emailok = 0;
    var checkStr = form1.email.value;
    var priaroba = checkStr.indexOf('@');
    var ultponto = checkStr.lastIndexOf('.');

    if (checkStr.indexOf('@') > 0 ) {
       if (checkStr.lastIndexOf('@') == checkStr.indexOf('@')) {
          if (checkStr.lastIndexOf('.') > 0 ) {

             if ( checkStr.lastIndexOf('.')  !=  checkStr.length - 1) {
	 					if ( ultponto > priaroba ) {
                  	 var emailok = 1;
 	 					}
             }
          }
       }
    }

    if (emailok != 1) {
    		alert('E-mail Inválido.');
		   form1.email.focus();
         return (false);
    }
  }
  if (form1.senha.value == "")
  {
    alert("Por favor, digite a Senha");
    form1.senha.focus();
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
<p><br><br>
  <div align="center">
    <center>
  <table border="0" cellspacing="1" width="400" bgcolor="#<?php print("$cor5"); ?>">
  <tr><td colspan=2 bgcolor="#<?php print("$cor1"); ?>" align=center>
    Digite seu e-mail e sua senha para acessar o<br>Painel de Controle da Bruc Internet.
    </td></tr>
  <form method="post" action="login.php?url=<?php print("$REQUEST_URI"); ?>" name="form1" onsubmit="return valida();">
    <tr>
      <td width="100" bgcolor="#<?php print("$cor6"); ?>"><b>E-mail:</b></td>
      <td width="300" bgcolor="#<?php print("$cor6"); ?>" class=style2>
        <input type="text" name="email" size="50" class="campo"></td>
    </tr>
    <tr>
      <td width="100" bgcolor="#<?php print("$cor6"); ?>"><b>Senha:</b></td>
      <td width="300" bgcolor="#<?php print("$cor6"); ?>" class=style2>
        <input type="password" name="senha" size="6" class="campo" maxlenght="6" onKeyUp="return autoTab(this, 6, event);">(6 dígitos)</td>
    </tr>
    <tr>
      <td width="100" bgcolor="#<?php print("$cor1"); ?>">
      <p align="center">
    <input type="submit" value="Entrar" name="bot" class=campo></td>
          <td width="300" bgcolor="#<?php print("$cor1"); ?>">
    </td>
    </tr>
      </form>
  </table>
  </center>
</div>