var TRATA_DADOS_OPCAO;

function setTrataDados(valor) { TRATA_DADOS_OPCAO = valor; }
function getTrataDados() { return TRATA_DADOS_OPCAO; }

function AdicionarAcompanhante(local)
{
	 var cont = document.getElementById('cont');
	 var destino = document.getElementById(local);
	 var campos	= destino.getElementsByTagName('input');	
	 var div1 = document.createElement('div');
	 div1.setAttribute('align','center');
	 div1.setAttribute('style','padding: 2px');
	 div1.setAttribute('id', 'acompanhante_' + cont.value);
	 div1.appendChild(document.createTextNode('Nome: '));
	 var input1 = document.createElement('input');
	 input1.setAttribute('name','nome_acompanhante_' + cont.value + '_texto');
	 input1.setAttribute('id','nome_acompanhante_' + cont.value + '_texto');
	 input1.setAttribute('size','40');
	 input1.setAttribute('title', 'Nome Acompanhante');
	 input1.setAttribute('class','campo');
	 var div3 = document.createElement('div');
	 var idade = document.createElement('idade');
	 idade.appendChild(document.createTextNode(' Idade: '));
	 var input2 = document.createElement('input');
	 input2.setAttribute('type','text');
	 input2.setAttribute('name','idade_acompanhante_' + cont.value + '_texto');
	 input2.setAttribute('id','idade_acompanhante_' + cont.value + '_texto');
	 input2.setAttribute('title','Idade Acompanhante');
	 input2.setAttribute('size','3');
	 input2.setAttribute('maxlength','3');
	 input2.setAttribute('class','campo3');
	 var a = document.createElement('a');
	 a.setAttribute('href','#');
	 a.setAttribute('class','style1');
	 a.setAttribute('onClick','RemoveAcompanhantes("acompanhante_' + cont.value + '")');
	 a.appendChild(document.createTextNode(' [ - ] Remover'));
	 
	 
	 div1.appendChild(input1);
	 idade.appendChild(input2);
	 idade.appendChild(a);
	 div1.appendChild(idade);
	 destino.appendChild(div1);
	 
	 cont.value = parseInt(cont.value) + 1;
}

function RemoveAcompanhantes(tabela) 
{
	var cont = document.getElementById('cont');
	var obj = document.getElementById(tabela);
	obj.parentNode.removeChild(obj);
    cont.value = parseInt(cont.value) - 1;

}