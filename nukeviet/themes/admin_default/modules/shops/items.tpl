<!-- BEGIN: main -->
<form action="{NV_BASE_ADMINURL}index.php" method="get">
	<input type="hidden" name ="{NV_NAME_VARIABLE}"value="{MODULE_NAME}" />
	<input type="hidden" name ="{NV_OP_VARIABLE}"value="{OP}" />
	<label>{LANG.search_cat}: </label>
	<select name="catid">
		<option value="0">{LANG.search_cat_all}</option>
		<!-- BEGIN: catid -->
		<option value="{CATID.catid}"{CATID.selected}>{CATID.name}</option>
		<!-- END: catid -->
	</select>
	<label>{LANG.search_type}: </label>
	<select name="stype">
		<!-- BEGIN: stype -->
		<option value="{STYPE.key}"{STYPE.selected}>{STYPE.title}</option>
		<!-- END: stype -->
	</select>
	<label>{LANG.search_per_page}: </label>
	<select name="per_page">
		<!-- BEGIN: per_page -->
		<option value="{PER_PAGE.key}"{PER_PAGE.selected}>{PER_PAGE.title}</option>
		<!-- END: per_page -->
	</select>
	<br />
	{LANG.search_key}: <input type="text" value="{Q}" maxlength="{NV_MAX_SEARCH_LENGTH}" name="q" style="width: 265px">
	<input type="submit" value="{LANG.search}"><br>
	<input type="hidden" name ="checkss" value="{CHECKSESS}" />
	<label><em>{SEARCH_NOTE}</em></label>
</form>
<form name="block_list">
	<table class="tab1">
		<thead>
			<tr>
				<td  align="center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></td>
				<td><a href="{BASE_URL_NAME}">{LANG.name}</a></td>
				<td  align="center"><a href="{BASE_URL_PUBLTIME}">{LANG.content_publ_date}</a></td>
				<td  align="center">{LANG.status}</td>
				<td  align="center">{LANG.content_admin}</td>
				<td align="center">{LANG.content_product_number1}</td>
				<td></td>
			</tr>
		</thead>
		<!-- BEGIN: loop -->
		<tbody{ROW.class}>
			<tr>
				<td align="center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]"></td>
				<td><a target="_blank" href="{ROW.link}">{ROW.title}</a></td>
				<td align="center">{ROW.publtime}</td>
				<td align="center">{ROW.status}</td>
				<td>{ROW.admin_id}</td>
				<td align="center">{ROW.product_number}</td>
				<td>
					{ROW.link_edit}&nbsp;-&nbsp;{ROW.link_delete}
				</td>
			</tr>
		</tbody>
		<!-- END: loop -->
		<tfoot>
			<tr align="left">
				<td colspan="7">
					<select name="action" id="action">
						<!-- BEGIN: action -->
						<option value="{ACTION.key}">{ACTION.title}</option>
						<!-- END: action -->
					</select>
					<input type="button" onclick="nv_main_action(this.form, '{ACTION_CHECKSESS}','{LANG.msgnocheck}')" value="{LANG.action}">
				</td>
			</tr>
		</tfoot>
	</table>
</form>
<!-- BEGIN: generate_page -->
<br /><p align="center">{GENERATE_PAGE}</p>
<!-- END: generate_page -->
<!-- END: main -->

