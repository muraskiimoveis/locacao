var zindex = 1;
var posx = 0;
var posy = 0; 
var difx = 0
var dify = 0;
var idmove = false;

function moveMouse(e){
    if(document.all){
          posx = event.clientX;
          posy  = event.clientY;
    } else {
          posx = e.clientX;
          posy = e.clientY;
    }
	som = false;
}

function Janela(){
	this.ido = 0;
	this.top = 0;
	this.left = 0;
	this.titulo = 'Janela';

	this.GeraJanela = function(){
		if(!document.getElementById('j' +this.ido)){
			
			var criar = document.createElement('div');
			criar.setAttribute('id','j' +this.ido);
			document.body.appendChild(criar);
			
			var div = document.getElementById('j' +this.ido);
			
			div.className = 'janela';
			
			div.onmousedown = function(){
				FocoJanela(this);
			}
			
			var insere = null;
			insere  =  '<div class="topo"><a href="javascript:void(0)" onclick="FechaJanela(this.parentNode.parentNode)" title="Fechar janela">&nbsp;</a><span title="Mover janela" id="tituloj' +this.ido+ '" onmousedown="CapturaJanela(this)">' +this.titulo+ '</span></div>';
			insere  +=  '<div class="conversa" title="Mensagens enviadas e recebidas" id="bp' +this.ido+ '"></div>';
			insere  +=  '<div class="opcoes">Mensagem:</div>';
			insere  +=  '<div class="envio">';
			insere  +=  '<input type="text" maxlength="255" id="msg' +this.ido+ '" title="Digite sua mensagem aqui" onkeypress="AnalizeKey(' +this.ido+ ')" />';
			insere  +=  '<img src="css/send.jpg" border="0" title="Enviar mensagem" alt="Enviar mensagem" onmouseover="SendOver(this)" onclick="PrepareSend(' +this.ido+ ')" />';
			insere  +=  '</div>';
			
			div.innerHTML = insere;
			
			if(this.top == 0){ this.top = Math.round(Math.random()*150); }
			if(this.left == 0){ this.left = Math.round(Math.random()*350); }
			if(this.top < 30){this.top = this.top + 30; }
			if(this.left < 30){this.left = this.left + 30; }
			
			div.style.top = this.top +'px';
			div.style.left = this.left +'px';
			
			return div;
		}else{
			return document.getElementById('j' +this.ido);
		}
	}
}

function FechaJanela(obj){
	document.body.removeChild(obj);	
}

function FocoJanela(obj){
	var id = obj.getAttribute('id');
	zindex++;
	obj.style.zIndex = zindex;
	document.title = document.getElementById('titulo' +id).innerHTML +' - X-chat Lite';
	obj.className = 'janela';
	id = id.replace('j','');
	if(id != '0'){
		document.getElementById('msg' +id).focus();
	}
}

function FocoJanelaRecebida(obj){
	obj.className = 'janelaover';
}

function CapturaJanela(obj){
	var div = obj.parentNode.parentNode.style;

	dify = posy - parseInt(div.top);	
	difx = posx - parseInt(div.left);	
		
	document.onmousemove =  MoveJanela;
	
	idmove = obj.parentNode.parentNode;
}
function SoltaJanela(){
	idmove = false;	
}

function MoveJanela(e){
	moveMouse(e);
	if(idmove != false){
		var div = idmove.style;
		div.top = (posy) - dify +'px';
		div.left = (posx) - difx +'px';
	}
}

function GeraConversa(id,nome){
	var jan = new Janela();
	jan.ido = id;
	jan.titulo = nome;
	var resul = jan.GeraJanela();	
	FocoJanela(resul);
}

function GeraConversaRecebida(id,nome){
	var jan = new Janela();
	jan.ido = id;
	jan.titulo = nome;
	var resul = jan.GeraJanela();	
	FocoJanelaRecebida(resul);
}

document.onmousemove =  MoveJanela;
document.onmouseup = SoltaJanela;