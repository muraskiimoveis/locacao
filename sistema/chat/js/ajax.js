function XMLHTTP(){
	var request = null;
	try{
		request = new XMLHttpRequest()
	}catch(e){
		try{
			request = new ActiveXObject("Msxml2.XMLHTTP"); 
		}catch(e){
			try{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(e){
				request = null;
				alert('N�o foi poss�vel criar o objeto XMLHttpRequest, algnus recursos podem estar indidpon�veis.');
			} 
		}
	}
	return request;
}