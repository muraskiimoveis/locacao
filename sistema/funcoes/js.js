var TRATA_DADOS_OPCAO;

function setTrataDados(valor) { TRATA_DADOS_OPCAO = valor; }
function getTrataDados() { return TRATA_DADOS_OPCAO; }

function trataDados()
{
	var respostaAjax = ajax.responseText;
	switch(getTrataDados())
	{
		case 0:
			retornoMontaImoveis(respostaAjax);
			break;
	}
}

function MontaImoveis(obj)
{
	   setTrataDados(0);
	   var qtd = obj.value;
	   var url = 'montaimoveis.ajax.php?qtd=' + qtd;
	   requisicaoHTTP('GET', url, true);
}

function retornoMontaImoveis(respostaAjax)
{
	   var imoveis = document.getElementById('imoveis');
	   imoveis.innerHTML = respostaAjax;
}

function formatCurrency(num) {
num = num.toString().replace(/\$|\,/g,'');
if(isNaN(num))
num = "0";
sign = (num == (num = Math.abs(num)));
num = Math.floor(num*100+0.50000000001);
cents = num%100;
num = Math.floor(num/100).toString();
if(cents<10)
cents = "0" + cents;
for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
num = num.substring(0,num.length-(4*i+3))+'.'+
num.substring(num.length-(4*i+3));
return (((sign)?'':'-') + num + ',' + cents);
}

function txtBoxFormat(objForm, strField, sMask, evtKeyPress) {
      var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;

      if(document.all) { // Internet Explorer
        nTecla = evtKeyPress.keyCode; }
      else if(document.layers) { // Nestcape
        nTecla = evtKeyPress.which;
      }

      sValue = objForm[strField].value;

      // Limpa todos os caracteres de formatação que
      // já estiverem no campo.
      sValue = sValue.toString().replace( "-", "" );
      sValue = sValue.toString().replace( "-", "" );
      sValue = sValue.toString().replace( ".", "" );
      sValue = sValue.toString().replace( ".", "" );
      sValue = sValue.toString().replace( "/", "" );
      sValue = sValue.toString().replace( "/", "" );
      sValue = sValue.toString().replace( "(", "" );
      sValue = sValue.toString().replace( "(", "" );
      sValue = sValue.toString().replace( ")", "" );
      sValue = sValue.toString().replace( ")", "" );
      sValue = sValue.toString().replace( " ", "" );
      sValue = sValue.toString().replace( " ", "" );
      fldLen = sValue.length;
      mskLen = sMask.length;

      i = 0;
      nCount = 0;
      sCod = "";
      mskLen = fldLen;

      while (i <= mskLen) {
        bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/"))
        bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))

        if (bolMask) {
          sCod += sMask.charAt(i);
          mskLen++; }
        else {
          sCod += sValue.charAt(nCount);
          nCount++;
        }

        i++;
      }

      objForm[strField].value = sCod;

      if (nTecla != 8) { // backspace
        if (sMask.charAt(i-1) == "9") { // apenas números...
          return ((nTecla > 47) && (nTecla < 58)); } // números de 0 a 9
        else { // qualquer caracter...
          return true;
        } }
      else {
        return true;
      }
    }



//codigo para colocar mascara nos campos
function Mascara(objeto, evt, mask) 
{
var LetrasU = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var LetrasL = 'abcdefghijklmnopqrstuvwxyz';
var Letras  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
var Numeros = '0123456789';
var Fixos  = '().-:/ ';
var Charset = " !\"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_/`abcdefghijklmnopqrstuvwxyz{|}~";

evt = (evt) ? evt : (window.event) ? window.event : "";
var value = objeto.value;
if (evt) {
 var ntecla = (evt.which) ? evt.which : evt.keyCode;
 tecla = Charset.substr(ntecla - 32, 1);
 if (ntecla < 32) return true;

 var tamanho = value.length;
 if (tamanho >= mask.length) return false;

 var pos = mask.substr(tamanho,1);
 while (Fixos.indexOf(pos) != -1) {
  value += pos;
  tamanho = value.length;
  if (tamanho >= mask.length) return false;
  pos = mask.substr(tamanho,1);
 }

 switch (pos) {
   case '#' : if (Numeros.indexOf(tecla) == -1) return false; break;
   case 'A' : if (LetrasU.indexOf(tecla) == -1) return false; break;
   case 'a' : if (LetrasL.indexOf(tecla) == -1) return false; break;
   case 'Z' : if (Letras.indexOf(tecla) == -1) return false; break;
   case '*' : objeto.value = value; return true; break;
   default : return false; break;
 }
}
objeto.value = value;
return true;
}

//codigo para validar campo numerico
function validarCampoNumerico(evnt)
{ 
	var Digit = eval(((navigator.appName != "Microsoft Internet Explorer")?"evnt.which":"event.keyCode"))	
	var isDigit 
	isDigit = ((Digit >= 48 && Digit <= 57) || (Digit == 0 || Digit == 8));
	return isDigit; 
}

//codigo para remover a mascara do cpf
function RemoveMascaraCPF(cpf)
{
 
  var primeira_parte_cpf = cpf.split(".");
  var segunda_parte_cpf = primeira_parte_cpf[primeira_parte_cpf.length - 1].split("-");
  
  var novo_cpf = "";
  for(var i = 0; i < (primeira_parte_cpf.length-1); i++)
  {
     novo_cpf = novo_cpf + primeira_parte_cpf[i];
  }
  for(var i = 0; i < segunda_parte_cpf.length; i++)
  {
     novo_cpf = novo_cpf + segunda_parte_cpf[i];
  }
  return novo_cpf;
  
}

//codigo para validar o cpf
function isCPF(cpf)
{

   var numeros, digitos, soma, i, resultado, digitos_iguais;
   digitos_iguais = 1;
   if (cpf.length < 11)
       return false;
   for (i = 0; i < cpf.length - 1; i++)
        if (cpf.charAt(i) != cpf.charAt(i + 1))
        {
          digitos_iguais = 0;
          break;
        }
  if (!digitos_iguais)
  {
      numeros = cpf.substring(0,9);
      digitos = cpf.substring(9);
      soma = 0;
      for (i = 10; i > 1; i--)
        soma += numeros.charAt(10 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
           return false;
           numeros = cpf.substring(0,10);
           soma = 0;
           for (i = 11; i > 1; i--)
               soma += numeros.charAt(11 - i) * i;
           resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
           if (resultado != digitos.charAt(1))
               return false;
           return true;
   }
   else
       return false;
}

//codigo para remover a mascara do cnpj
function RemoveMascaraCNPJ(cnpj){

  var primeira_parte_cnpj = cnpj.split(".");
  var segunda_parte_cnpj = primeira_parte_cnpj[2].split("/");
  var terceita_parte_cnpj = segunda_parte_cnpj[1].split("-");
  
  var novo_cnpj = "";
  novo_cnpj = primeira_parte_cnpj[0] + primeira_parte_cnpj[1] + segunda_parte_cnpj[0] + terceita_parte_cnpj[0] + terceita_parte_cnpj[1];
  return novo_cnpj;
}

//codigo para validar o cnpj
function isCNPJ(cnpj){
  
  var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
  digitos_iguais = 1;
  if (cnpj.length < 14 && cnpj.length < 15)
      return false;
  for (i = 0; i < cnpj.length - 1; i++)
     if (cnpj.charAt(i) != cnpj.charAt(i + 1))
     {
        digitos_iguais = 0;
        break;
     }
  if (!digitos_iguais)
  {
     tamanho = cnpj.length - 2
     numeros = cnpj.substring(0,tamanho);
     digitos = cnpj.substring(tamanho);
     soma = 0;
     pos = tamanho - 7;
     for (i = tamanho; i >= 1; i--)
     {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
          pos = 9;
     }
     resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
     if (resultado != digitos.charAt(0))
         return false;
         tamanho = tamanho + 1;
         numeros = cnpj.substring(0,tamanho);
         soma = 0;
         pos = tamanho - 7;
         for (i = tamanho; i >= 1; i--)
         {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
         }
         resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
         if (resultado != digitos.charAt(1))
              return false;
         return true;
  }
  else
     return false;
}

//codigo para validar campo data
function ValidaData(data)
{
	var DATA   = new Array();
	var expReg = new RegExp("[/-]");
	var chr    = null;
	var posChr = null;
	var dia    = null;
	var mes    = null;
	var ano    = null;

	if(data.length != 10){
		alert("Data inválida!\nDigite a data no formato dd(dia) mm(mês) aaaa(ano).");
		return false;
	}

	chr    = expReg.exec(data);
	posChr = data.search(expReg);
	DATA   = data.split(chr);

	switch(posChr){
		case 2:
			dia = DATA[0];
			mes = DATA[1];
			ano = DATA[2];
			break;
		case 4:
			dia = DATA[2];
			mes = DATA[1];
			ano = DATA[0];
			break;
	}
   
	if(!(dia > 0 && dia < 32)){
		alert("Dia inválido!");
		return false;

	}else if(!(mes > 0 && mes < 13)){
		alert("Mês inválido!");
		return false;

	}else if(!(ano > 0 && ano.length == 4)){
		alert("Ano inválido!");
		return false;
	
	}else if((mes == 2 && dia > 0 && dia > 29)){
		alert("Dia inválido!");
		return false;
	}

	return true;
}

//verificar email
function isMail(mailField){
	strMail = mailField;
	var re = new RegExp("^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$");
	var arr = re.exec(strMail);
	if (arr == null){
    	return false;
	}else{
    	return true;
	}
}


//valida hora
function validaHora(hora)
{
var msg="";
var erro="";
var h = (hora.substring(0,hora.indexOf(':')));
var m = (hora.substring(hora.indexOf(':')+1,hora.length));
if (hora.substring(2,3) != ":" || hora.length < 5)
{
alert("Informe hora no formato hh:mm");
//document.Horas.Hora.focus();
//document.Horas.Hora.select();
return false;}
if (h < 0 || h > 23 || isNaN(h)) {msg+="Hora incorreta!\n"; erro=true;}
if (m < 0 || m > 59 || isNaN(m)) {msg+="Minuto incorreto!"; erro=true;}
if (erro==true)
{
alert(msg); erro="";
//document.Horas.Hora.focus();
//document.Horas.Hora.select();
return false;
}
else {return true;}
}

//masca no campo hora
function Formatar(campo,e)
{
var cod="";
if(document.all) {cod=event.keyCode;} else {cod=e.which;}
if(cod == 08 || cod == 13 || cod == 46) return;
if (cod < 48 || cod > 57)
{
if (cod < 45 || cod > 57) alert("Digite somente Caracteres Numéricos!");
cod=0;
campo.focus(); return false;
}
tam=campo.value.length;
if(tam > 4) return false;
var caract = String.fromCharCode(cod);
if(tam == 2) {campo.value+=":"+caract; return false;}
campo.value+=caract; return false;
}
document.onKeyPress=Formatar;

function CalcIMC(){
   var altura = gE('consulta_retorno_altura').value;
   var peso = gE('consulta_retorno_peso').value;

   if(altura > 0 && peso > 0){
      var imc = (peso / (altura*altura));
      imc = imc.toPrecision(4);
      gE('consulta_retorno_imc').value = imc;
   }else{
      gE('consulta_retorno_imc').value = 0;       
   }

}


//codigo para abrir nova tela
function NewWindow(mypage, myname, w, h, scroll)
{
var winl = (screen.width - w) / 2;
var wint = (screen.height - h) / 2;
winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
win = window.open(mypage, myname, winprops)
if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}


// retira caracteres invalidos da string
function Limpar(valor, validos) {
var result = "";
var aux;
for (var i=0; i < valor.length; i++) {
aux = validos.indexOf(valor.substring(i, i+1));
if (aux>=0) {
result += aux;
}
}
return result;
}

//codigo para colocar mascara no campo valor
function Formata(campo,tammax,teclapres,decimal) 
{
var tecla = teclapres.keyCode;
vr = Limpar(campo.value,"0123456789");
tam = vr.length;
dec=decimal

if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }

if (tecla == 8 )
{ tam = tam - 1 ; }

if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
{

if ( tam <= dec )
{ campo.value = vr ; }

if ( (tam > dec) && (tam <= 5) ){
campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; }
if ( (tam >= 6) && (tam <= 8) ){
campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ;
}
if ( (tam >= 9) && (tam <= 11) ){
campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
if ( (tam >= 12) && (tam <= 14) ){
campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
if ( (tam >= 15) && (tam <= 17) ){
campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;}
}

}
