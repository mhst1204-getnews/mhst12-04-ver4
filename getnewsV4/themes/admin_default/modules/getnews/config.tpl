<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="quote" style="width:780px;">
    <blockquote class="error"><span>{ERROR}</span></blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->

<!-- BEGIN: sendLink -->
<form enctype="multipart/form-data" action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=article" method="post">
	<table summary="" class="tab1">
		<caption>{LANG.autoarticle}</caption>
		<tbody>
			<tr>
				<td align="right" width="200"><strong>{LANG.linksite}: </strong></td>
				<td><input style="width: 850px" name="linktrangtin" id="linktrangtin" type="text" value="" maxlength="255" /></td>
                
			</tr>
            <tr>
                <td align="right"><strong>{LANG.noidungtd}</strong></td>
                <td><input style="width: 850px" name="noidungtd" type="text" value="" maxlength="255"/></td>
            </tr>
            <tr>
                <td align="right"><strong>{LANG.noidungmt}</strong></td>
                <td><input style="width: 850px" name="noidungmt" type="text" value="" maxlength="255"/></td>
            </tr>
            <tr>
                <td align="center" colspan="3">
                    <input name="timnd" type="submit" id="timnd" value="{LANG.action}" />  
                </td>
            </tr>
		</tbody>
	</table>
    
</form>
<form enctype="multipart/form-data" action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=getcontent" method="post">
	<table summary="" class="tab1">
		<caption>{LANG.config_auto_article}</caption>
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.link_article}: </strong></td>
				<td><input style="width: 550px" name="link_article" id="link_article" type="text" value="" maxlength="255" /></td>
                <td>
                    <input name="lay" type="submit" id="getLink" value="{LANG.autoconfig}" />
                    <input  name="config" type="button" id="config" value="{LANG.choseconfig}"/>    
                </td>
			</tr>
		</tbody>
	</table>
    
</form>

<!-- END: sendLink -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#config").click(function(){
            var link=$("#link_article").val();
            window.location.href= nv_siteroot+"admin/index.php?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=getarea&link="+link;
        })
        $("#form1 input").click(function(){
            
        })
        
    })
    function thongbao(a)
    {
        alert(a);
        window.location.href=window.location;
    }
</script>
 <!--END: main -->
