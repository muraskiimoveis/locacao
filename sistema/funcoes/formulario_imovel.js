var TRATA_DADOS_OPCAO;

function setTrataDados(valor) { TRATA_DADOS_OPCAO = valor; }
function getTrataDados() { return TRATA_DADOS_OPCAO; }

function AdicionarImovel(local)
{
	 var cont = document.getElementById('cont');
	 var destino = document.getElementById(local);
	 var campos	= destino.getElementsByTagName('input');	
	 var div1 = document.createElement('div');
	 div1.setAttribute('align','center');
	 div1.setAttribute('style','padding: 2px');
	 div1.setAttribute('id', 'imovel_' + cont.value);
	 div1.appendChild(document.createTextNode('Imóvel: '));
	 var input1 = document.createElement('input');
	 input1.setAttribute('name','co_imovel_' + cont.value);
	 input1.setAttribute('id','co_imovel_' + cont.value);
	 input1.setAttribute('size','5');
	 input1.setAttribute('title', 'Código Imóvel');
	 input1.setAttribute('class','campo2');
	 input1.setAttribute('value','');
	 var nome = document.createElement('nome');
	 nome.appendChild(document.createTextNode(' '));
	 var div3 = document.createElement('div');
	 var input2 = document.createElement('input');
	 input2.setAttribute('type','text');
	 input2.setAttribute('name','nome_imovel_' + cont.value);
	 input2.setAttribute('id','nome_imovel_' + cont.value);
	 input2.setAttribute('title','Nome Imóvel');
	 input2.setAttribute('size','80');
	 input2.setAttribute('class','campo');
	 input2.setAttribute('value','');
	 var botao = document.createElement('botao');
	 botao.appendChild(document.createTextNode(' '));
	 var input3 = document.createElement('input');
	 input3.setAttribute('type','button');
	 input3.setAttribute('name','selecionar_' + cont.value);
	 input3.setAttribute('id','selecionar_' + cont.value);
	 input3.setAttribute('value','Selecionar');
	 input3.setAttribute('class','campo3');
	 input3.setAttribute('onclick','window.open(\'list_imoveis_novo.php?id=' + cont.value + '\', \'janela\', \'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no\');');
	 var a = document.createElement('a');
	 a.setAttribute('href','#');
	 a.setAttribute('class','style1');
	 a.setAttribute('onClick','RemoveImoveis("imovel_' + cont.value + '")');
	 a.appendChild(document.createTextNode(' [ - ] Remover'));
	 
	 
	 div1.appendChild(input1);
	 nome.appendChild(input2);
	 botao.appendChild(input3);
	 botao.appendChild(a);
	 div1.appendChild(nome);
	 div1.appendChild(botao);
	 destino.appendChild(div1);
	 
	 cont.value = parseInt(cont.value) + 1;
}

function RemoveImoveis(tabela) 
{
	var cont = document.getElementById('cont');
	var obj = document.getElementById(tabela);
	obj.parentNode.removeChild(obj);
    cont.value = parseInt(cont.value) - 1;

}