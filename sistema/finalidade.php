<?php
	$query1 = "select * from finalidade order by f_nome";
	$result1 = mysql_query($query1);
	$numrows1 = mysql_num_rows($result1);
	if($numrows1 > 0){
	while($not1 = mysql_fetch_array($result1))
	{
?>
    <option <?php if($not1[f_nome] == "Venda"){ echo "selected"; } ?> value="<?php print("$not1[f_cod]"); ?>"><?php print("$not1[f_nome]"); ?></option>
<?php
}
}
?>