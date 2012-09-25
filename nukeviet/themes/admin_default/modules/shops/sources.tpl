<!-- BEGIN: main -->
<div id="module_show_list">
	{SOURCES_LIST}
</div>
<br />
<!-- BEGIN: error -->
<div class="quote" style="width:98%">
	<blockquote class="error"><span>{ERROR}</span></blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->
<form enctype="multipart/form-data" action="{NV_BASE_ADMINURL}index.php" method="post" id="edit">
	<input type="hidden" name ="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
	<input type="hidden" name ="{NV_OP_VARIABLE}" value="{OP}" />
	<input type="hidden" name ="sourceid" value="{DATA.sourceid}" />
	<input name="savecat" type="hidden" value="1" />
	<table class="tab1">
		<col width="150"/>
		<caption>{LANG.add_sources}</caption>
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.source_title}: </strong></td>
				<td><input class="txt-full" name="title" type="text" value="{DATA.title}" maxlength="255" /></td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td align="right"><strong>{LANG.link}: </strong></td>
				<td><input class="txt-full" name="link" type="text" value="{DATA.link}" maxlength="255" /></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.source_logo}: </strong></td>
				<td>
					<input style="width:500px" type="text" name="logo" id="logo" value="{DATA.logo}"/>
					<input style="width:100px" type="button" value="{GLANG.browse_image}" name="selectimg"/>
					<!-- BEGIN: logo -->
					<br /><img src="{DATA.logo}" style="max-width:200px"/>
					<!-- END: logo -->
				</td>
			</tr>
		<tbody>
	</table>
	<br />
	<center><input name="submit1" type="submit" value="{LANG.save}" /></center>
</form>
<script type="text/javascript">
$("input[name=selectimg]").click(function(){
	var area = "logo";
	var path= "{NV_UPLOADS_DIR}/" + nv_module_name + "/source";						
	var type= "image";
	nv_open_browse_file("{NV_BASE_ADMINURL}index.php?" + nv_name_variable + "=upload&popup=1&area=" + area+ "&path="+path+"&type="+type, "NVImg", "850", "500","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
</script>
<!-- END: main -->