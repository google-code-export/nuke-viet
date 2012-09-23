<!-- BEGIN: main -->
<div id="module_show_list">
	{BLOCK_CAT_LIST}
</div>
<br />
<a id="edit"></a>
<!-- BEGIN: error -->
<div class="quote" style="width:98%">
	<blockquote class="error"><span>{ERROR}</span></blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->
<form action="{NV_BASE_ADMINURL}index.php" method="post">
	<input type="hidden" name ="{NV_NAME_VARIABLE}"value="{MODULE_NAME}" />
	<input type="hidden" name ="{NV_OP_VARIABLE}"value="{OP}" />
	<input type="hidden" name ="bid" value="{DATA.bid}" />
	<input name="savecat" type="hidden" value="1" />
	<table summary="" class="tab1">
		<caption>{LANG.add_block_cat}</caption>
		<col width="150"/>
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.block_name}: </strong></td>
				<td><input style="width: 650px" name="title" type="text" value="{DATA.title}" maxlength="255" /></td>
			</tr>
		</tbody>
		<!-- BEGIN: alias -->
		<tbody>
			<tr>
				<td align="right"  width="100px"><strong>{LANG.alias}: </strong></td>
				<td><input style="width: 650px" name="alias" type="text" value="{DATA.alias}" maxlength="255" /></td>
			</tr>
		</tbody>
		<!-- END: alias -->
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.keywords}: </strong></td>
				<td><input style="width: 650px" name="keywords" type="text" value="{DATA.keywords}" maxlength="255" /></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td valign="top" align="right" width="100px"><br><strong>{LANG.description}</strong></td>
				<td>
					<textarea style="width: 650px" name="description" cols="100" rows="5">{DATA.description}</textarea>
				</td>
			</tr>
		</tbody>
	</table>
	<br />
	<center><input name="submit1" type="submit" value="{LANG.save}" /></center>
</form>
<!-- END: main -->