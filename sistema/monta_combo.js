var TRATA_DADOS;

function setTrataDados(trata_dados) { TRATA_DADOS = trata_dados; }
function getTrataDados() { return TRATA_DADOS; }

function trataDados()
{
	var respostaAjax = ajax.responseText;
	switch(getTrataDados())
	{
		case 0:
			retornoMontaAcompanhantes(respostaAjax);
			break;
	}
}

function MontaAcompanhantes(obj)
{
	   setTrataDados(0);
	   var qtd = obj.value;
	   var url = 'montaacompanhantes.ajax.php?qtd=' + qtd;
	   requisicaoHTTP('GET', url, true);
}

function retornoMontaAcompanhantes(respostaAjax)
{
	   var acompanhantes = document.getElementById('acompanhantes');
	   acompanhantes.innerHTML = respostaAjax;
}