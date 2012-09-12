<!-- BEGIN: main -->
<form name="block_list" action="">
	<table summary="" class="tab1">
		<thead>
			<tr>
				<td align="center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></td>
				<td><a href="{base_url_name}">{LANG.chuyenmuc}</a></td>
				<td align="center"><a href="{base_url_publtime}">{LANG.tgbd}</a></td>
                <td align="center">{LANG.tgtt}</td>
				<td align="center">{LANG.tglap}</td>
                <td align="center">{LANG.sotinmoi}</td>
                <td align="center">{LANG.trangthai}</td>
				<td></td>
			</tr>
		</thead>
		<!-- BEGIN: loop -->
		<tbody {ROW.class}>
			<tr align="center">
				<td align="center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{rowcontent.idcm}" name="idcheck[]" /></td>
				<td align="left"><a target="_blank" href="">{rowcontent.tencm}</a></td>
				<td>{rowcontent.tgbd}</td>
				<td>{rowcontent.tgtt}</td>
				<td>{rowcontent.tglap}</td>
                <td>{rowcontent.sotinmoi}</td>
                <td>{rowcontent.auto}</td>
				<td>
					{rowcontent.chucnang}
				</td>
			</tr>
		</tbody>
		<!-- END: loop -->
		<tbody>
			<tr align="left" class="tfoot_box">
				<td colspan="7">
					<select name="action" id="action">
						<!-- BEGIN: action -->
						<option value="{ACTION.value}">{ACTION.title}</option>
						<!-- END: action -->
					</select>
					<input type="button" onclick="nv_main_action(this.form, '{SITEKEY}', '{LANG.msgnocheck}')" value="{LANG.action}" />
				</td>
			</tr>
		</tbody>
	</table>
</form>
 <!--END: main -->