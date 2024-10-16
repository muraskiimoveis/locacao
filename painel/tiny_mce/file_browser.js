function FileBrowser (field_name, url, type, win) {

      tinyMCE.activeEditor.windowManager.open({
        file : 'p_img_editor.php',
        title : 'My File Browser',
        width : 750, 
        height : 400,
        resizable : "no",
        inline : "yes",
        close_previous : "no"
    }, {
        window : win,
        input : field_name
    });
    return false;
  }
