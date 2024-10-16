var ajax;
var dadosUsuario;

// ------ cria o objeto e faz a requisicao ------
function requisicaoHTTP(tipo, url, assinc)
{
	if(window.XMLHttpRequest) // Mozilla, Safari, ...
	{
		ajax = new XMLHttpRequest();
	}
	else if(window.ActiveXObject) // Internet Explorer
	{
		ajax = new ActiveXObject("Msxml2.XMLHTTP");
		if(!ajax)
		{
			ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	
	if(ajax) // iniciou com sucesso
		iniciaRequisicao(tipo, url, assinc);
	else
		alert("Seu navegador não possui suporte a essa aplicação.");
}

// ------ inicializa o objeto criado e envia os dados (se existirem) ------
function iniciaRequisicao(tipo, url, bool)
{
	ajax.onreadystatechange = trataResposta;
	ajax.open(tipo, url, bool);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
	//ajax.overrideMimeType("text/XML"); /* usado somente no Mozilla */
	ajax.send(dadosUsuario);
}

// ------ inicia requisição com envio de dados ------
function enviaDados(url)
{
	criaQueryString();
	requisicaoHTTP("POST", url, true);
}

// ------ cria a string a ser enviada, formato campo1=valor1&campo2=valor2... ------
function criaQueryString()
{
	dadosUsuario = "";
	var frm = document.forms[0];
	var numElementos = frm.elements.length;
	for(var i = 0; i < numElementos; i++)
	{
		if(i < numElementos - 1)
		{
			dadosUsuario += frm.elements[i].name + "=" + encodeURIComponent(frm.elements[i].value) + "&";
		}
		else
		{
			dadosUsuario += frm.elements[i].name + "=" + encodeURIComponent(frm.elements[i].value);
		}
	}
}

// ------ trata a resposta do servidor ------
function trataResposta()
{
	if(ajax.readyState == 4)
	{
		if(ajax.status == 200)
		{
			trataDados(); // criar essa função no seu programa
		}
		else
		{
			alert("Problema na comunicação com o objeto XMLHttpRequest.");
		}
	}
}