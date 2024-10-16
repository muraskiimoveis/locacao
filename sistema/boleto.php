<?php
ini_set('session.cache_expire', 1440); // 1440 minutos = 1 dia
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 0); // O indica que morre quando o browser fecha
ini_set('session.gc_maxlifetime', 86400); // 86400 segundos = 1 dia
session_start();
include("conect.php");
include("funcoes/funcoes.php");
include("l_funcoes.php");
include("style.php");
verificaAcesso();
verificaArea("GERAL_LOCA");	
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="css/estilos_sistema.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center">
<table width="95%" border="0" cellpadding="0" cellspacing="0">
	<tr height="50">
		<td class="style1" align="center"><b>Boleto</b></td>
	</tr>
	<tr class="fundoTabela" height="25px">
		<td class="style1"><b>Valor Total do Boleto :</b> <?php echo(number_format($valor_total, 2, ',', '.')); ?></td>
	</tr>
	<tr height="50">
		<td colspan=6 align=center class=style1><input type="button" onclick="window.close();" value="Fechar Janela" class="campo3" id="fechar" name="fechar"/></td>
	</tr>
</table>
</div>
</body>
</html>