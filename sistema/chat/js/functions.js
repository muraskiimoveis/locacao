var tamx = 0;
var tamy = 0;
var som = true;

function SendOver(obj){
	obj.src = 'css/sendover.jpg';
	obj.onmouseout = function(){
		obj.src = 'css/send.jpg';	
	}
}

function getDisplaySize(){
		tamy = document.documentElement.clientHeight;
		tamx = document.documentElement.clientWidth;
		
		if (window.opera){ 
			tamy = document.body.clientHeight;
			tamx = document.body.clientWidth;
		}
}

function PlaySound(){
	if((som == true) && (document.getElementById('somativo').checked == true)){
		var movie = document.getElementById('som');
        movie.SetVariable('_root.functionName', 'Tocar');
        movie.SetVariable('_root.flag', true);
	}
}

var image = Array();
image[0] = new Image();
image[0].src = 'css/send.jpg';

image[1] = new Image();
image[1].src = 'css/sendover.jpg';

image[2] = new Image();
image[2].src = 'css/close.jpg';

image[3] = new Image();
image[3].src = 'css/closeover.jpg';