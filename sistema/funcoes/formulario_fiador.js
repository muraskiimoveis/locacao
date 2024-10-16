var TRATA_DADOS_OPCAO;

function setTrataDados(valor) { TRATA_DADOS_OPCAO = valor; }
function getTrataDados() { return TRATA_DADOS_OPCAO; }

function AdicionarFiador(local)
{
	 var cont = document.getElementById('cont');
	 var destino = document.getElementById(local);
	 var campos	= destino.getElementsByTagName('input');	
	 var div1 = document.createElement('div');
	 div1.setAttribute('align','left');
	 div1.setAttribute('style','padding: 2px');
	 div1.setAttribute('id', 'fiadore_' + cont.value);
	 var input1 = document.createElement('input');
	 input1.setAttribute('name','fiador_' + cont.value);
	 input1.setAttribute('id','fiador_' + cont.value);
	 input1.setAttribute('size','4');
	 input1.setAttribute('title', 'Código Fiador');
	 input1.setAttribute('class','campo2');
	 input1.setAttribute('value','');
	 input1.setAttribute('readonly','readonly');
	 var nome = document.createElement('nome');
	 nome.appendChild(document.createTextNode(' '));
	 var div3 = document.createElement('div');
	 var input2 = document.createElement('input');
	 input2.setAttribute('type','text');
	 input2.setAttribute('name','nome_fiador_' + cont.value);
	 input2.setAttribute('id','nome_fiador_' + cont.value);
	 input2.setAttribute('title','Nome Fiador');
	 input2.setAttribute('size','40');
	 input2.setAttribute('class','campo');
	 input2.setAttribute('value','');
	 input2.setAttribute('readonly','readonly');
	 var botao = document.createElement('botao');
	 botao.appendChild(document.createTextNode(' '));
	 var input3 = document.createElement('input');
	 input3.setAttribute('type','button');
	 input3.setAttribute('name','selecionar_' + cont.value);
	 input3.setAttribute('id','selecionar_' + cont.value);
	 input3.setAttribute('value','Selecionar');
	 input3.setAttribute('class','campo3');
	 input3.setAttribute('onclick','window.open(\'p_list_fiador.php?id=' + cont.value + '\', \'janela\', \'height=500,width=730,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no\');'); 	 
	 var a = document.createElement('a');
	 a.setAttribute('href','#');
	 a.setAttribute('class','style1');
	 a.setAttribute('onClick','RemoveFiador("fiadore_' + cont.value + '")');
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

function RemoveFiador(tabela) 
{
	var cont = document.getElementById('cont');
	var obj = document.getElementById(tabela);
	obj.parentNode.removeChild(obj);
    cont.value = parseInt(cont.value) - 1;

}