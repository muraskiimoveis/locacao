var FileBrowserDialogue = {
    init : function () {
    },
    insert : function (tipo, pasta, imagem, legenda)
	{
		var enderecoInserir = pasta + '/' + imagem;
		var win = tinyMCEPopup.getWindowArg("window");
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = enderecoInserir;
		
		if(tipo === 'imagem')
		{
			win.document.getElementById('title').value = legenda;
			win.document.getElementById('alt').value = legenda;
						
			if (typeof(win.ImageDialog) != "undefined")
			{
            	if (win.ImageDialog.getImageData)
				{
					win.ImageDialog.getImageData();
				}
            	if (win.ImageDialog.showPreviewImage)
				{
					win.ImageDialog.showPreviewImage(enderecoInserir);
				}                	
        	}
		}

        tinyMCEPopup.close();
    }
}

tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);