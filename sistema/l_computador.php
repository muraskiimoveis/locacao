<table width="100%" height="400" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
				<?php $MSG = $MSG ? $MSG : "Este computador não está autorizado<br>a acessar o sistema!"; ?>
				<table width="300" align="center" cellpadding="0" cellspacing="1" bgcolor="#DDDDDD" border="0">
					<tr>
						<td width="10" bgcolor="#DDDDDD"></td>
						<td bgcolor="#DDDDDD" class="titulo">
						<div align="center" class="style1">VALIDAÇÃO DE COMPUTADOR</div>
						</td>
						<td width="10" bgcolor="#DDDDDD"></td>
					</tr>
					<tr>
						<td colspan="3" bgcolor="#FFFFFF">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="10"></td>
									<td valign="top">
										<form name="formulario" method="post" enctype="multipart/form-data" action="" onsubmit="return validaFormulario()">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr>
													<td class="style1" height="18" align="center" colspan="2">
														<div name="MSG" id="MSG">
														<?php if (isset($MSG)) echo $MSG; ?>
														</div>
													</td>
												</tr>
												<tr>
													<td class="style1">Código do computador</td>
													<td><input type="password" name="computador_codigo" value="" size="20" maxlength="8" class="campo"></td>
												</tr>
												<tr>
													<td height="5" colspan="2"></td>
												<tr>
													<td></td>
													<td><input type="submit" name="acao" value="Validar" class="campo3"></td>
												</tr>
												<tr>
													<td height="5" colspan="2"></td>
												</tr>
											</table>
										</form>
									</td>
									<td width="10"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
    </td>
  </tr>
</table>