<html>
<head>
    <title>
        Upload - www.yeebaplay.com.br
    </title>
</head>
<body>
    <form action="PostagemPublicar.php" method="post" id="upload">
    <table width="550" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="2">
                <center>
                    <textarea name="postagem" id="postagem" placeholder=" Acesse www.yeebaplay.com.br e www.yeeba.me" rows="4" cols="100" maxlength="1000" required mensagem=mensagem></textarea>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <input style="float: left;" type="submit" value="Publicar"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select id="categoria" name="categoria" >
                     <option value="" disabled selected style='display:none;'>Selecione a categoria</option>
                     <option value="Categoria1">Categoria 1</option>
                     <option value="Categoria2">Categoria 2</option>
                     <option value="Categoria3">Categoria 3</option>
                </select>
            </td>
            <td>
                <div style="cursor: pointer; margin-left: 5px; margin-top: 4px;" >
                    <input type="file" name="file" id="file" accept="image/*" />
                </div>
            </td>
        </tr>
    </table>
</form>
<div id="preview"></div>
<script>
        //Joga em uma variavel o formulario e o preview onde jogaremos nossas respostas
        var $formUpload = document.getElementById('upload'),
            $preview = document.getElementById('preview'),
            i = 0;
        $formUpload.addEventListener('submit', function(event){
          event.preventDefault();
          var xhr = new XMLHttpRequest();
          xhr.open("POST", $formUpload.getAttribute('action'));
          var formData = new FormData($formUpload);
          formData.append("i", i++);
          xhr.send(formData);
          xhr.addEventListener('readystatechange', function() {
            if (xhr.readyState === 4 && xhr.status == 200) {
              var json = JSON.parse(xhr.responseText);
              alert(json.status);
              if (!json.error && json.status === 'ok') {
                //retorno de tudo que veio do arquivo PostagemPublicar
                alert("Categoria retornada "+json.categoria);
                alert("Postagem retornada "+json.postagem);
                alert("Link da foto retornada "+json.foto);
                //Limpa o campo de postagem
                document.getElementById("postagem").value = "";
              } else {
                $preview.innerHTML = 'Arquivo não enviado';
              }
            } else {
              $preview.innerHTML = xhr.statusText;
            }
          });
          xhr.upload.addEventListener("progress", function(e) {
            if (e.lengthComputable) {
              var percentage = Math.round((e.loaded * 100) / e.total);
              $preview.innerHTML = String(percentage) + '%';
            }
          }, false);
          xhr.upload.addEventListener("load", function(e){
            $preview.innerHTML = String(100) + '%';
          }, false);
        }, false);
    </script>

</body>
</html>