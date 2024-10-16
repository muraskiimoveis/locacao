
//ler mensgens ------------------------------------------------------------------------------------------------------------

ajaxRead = new XMLHTTP();
var responsetime = null;
var clear = 0;
var readcont = 0;

function readMessage(){
	var userid =  document.getElementById('userid').value;
	
	ajaxRead.open('POST','readMessage.php',true);
	ajaxRead.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	ajaxRead.onreadystatechange = function(){
			if(ajaxRead.readyState == 4){
				//try{
					if(ajaxRead.status == 200){
						var reponse = ajaxRead.responseText;
						var json = eval('(' +reponse+ ')');	
						
						if(json.result.length == 3){
							
							//mensagens
							var totalmessage =  json.result[0].messages.length;
							for(var i = 0; i < totalmessage; i++){
								GeraConversaRecebida(json.result[0].messages[i].idsend,json.result[0].messages[i].name);
								AddMessage(json.result[0].messages[i].idsend,json.result[0].messages[i].name,json.result[0].messages[i].message,'msgreceive');	
							}
							if(totalmessage > 0){
								som = true;
								setTimeout('PlaySound()',1000);	
							}
							
							//usuários
							var userlist = '';
							var totaluser =  json.result[1].users.length;
							for(var i = 0; i < totaluser; i++){
								if(json.result[1].users[i].id != userid){
									userlist += '<a href="javascript:void(0)" onclick="GeraConversa(' +json.result[1].users[i].id +',\''+  json.result[1].users[i].name +'\')">'+  json.result[1].users[i].name +'</a>';
								}
							}
							if(userlist == ''){ userlist = 'Nenhum usuário conectado'; }
							document.getElementById('userlist').innerHTML = userlist;
							
							//status
							if(json.result[2].status == 'unregistered'){
								document.getElementById('status').innerHTML = 'Sua sessão foi desativada, reinicie o sistema';	
								document.getElementById('userlist').innerHTML = 'Sua sessão foi desativada, você não enviará ou recebá mensagens. Reinicie o sistema';	
							}
							
						}
						
						clearTimeout(responsetime);
						setTimeout('readMessage()',5000);
						document.getElementById('status').innerHTML = 'Conectado';
		
					}else{
						document.getElementById('status').innerHTML = 'Erro ao receber dados, reiniciando em 25 segundos';
					}
			//	}catch(e){
					//alert(e);
			//	}
			}
	} 		
	readcont++;
	if(readcont == 10){
		clear = 1;
		readcont = 0;
	}
	ajaxRead.send('iduser=' +userid+ '&clearuser=' +clear);
	responsetime = setTimeout('AbortMessage()',25000);
	clear = 0;
}

function AbortMessage(){
	document.getElementById('status').innerHTML = 'Reiniciando...';
	ajaxRead.abort();
	readMessage();
}

//enviar mensgens ------------------------------------------------------------------------------------------------------------

ajaxSend = new XMLHTTP();
var flood = false;
var key = 0;

function PrepareSend(id){
	if(flood == 0){
		var input = document.getElementById('msg' +id);
		if(input.value != ''){
			Send(id);	
			
			input.value = '';
			input.focus();
			
			flood = 1;
			setTimeout('FreeFlood()',1200);
		}
	}else{
		AddMessage(id,'Aviso','Sistema anti-flood ativado','msgalert');	
	}
}

function Send(id){
		var username = document.getElementById('username').value;
		var userid = document.getElementById('userid').value;
		var msg = document.getElementById('msg' +id).value;	
		
		AddMessage(id,username,msg,'msgsend');	
		
		msg = encodeURIComponent(msg);

		ajaxSend.open('POST','sendMessage.php',true);
		ajaxSend.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		ajaxSend.send('idsend=' +userid+ '&idreceive=' +id+ '&message=' +msg+ '&name=' +username);
}

function AddMessage(id,title,msg,style){
	var cria = document.createElement('p');	
	cria.innerHTML = '<span class="' +style+ '">' +title+ '</span>: ' +msg;
	
	var div = document.getElementById('bp' +id);
	div.appendChild(cria);
	div.scrollTop = div.scrollHeight;
}

function FreeFlood(){
	flood = 0;	
}

function AnalizeKey(id){
	switch(key){
		case 13: PrepareSend(id); break;	
		case 27: 
			var div = document.getElementById('j' +id);
			FechaJanela(div);
		break;
	}	
}

function getKey(e){
	if(document.all){
		key = window.event.keyCode;	
	}else{
		key = e.keyCode;	
	}
	som = false;
}

function Start(){
	getDisplaySize();
	document.getElementById('j0').style.left = tamx - 250 +'px';
	readMessage();	
}

window.onload = Start;
document.onkeydown = getKey;