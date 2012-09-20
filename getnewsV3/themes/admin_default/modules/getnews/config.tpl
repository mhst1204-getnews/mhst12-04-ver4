<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="quote" style="width:780px;">
    <blockquote class="error"><span>{ERROR}</span></blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->

<!-- BEGIN: sendLink -->
<form enctype="multipart/form-data" action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=getcontent" method="post">
	<table summary="" class="tab1">
		<caption>{LANG.config_auto_article}</caption>
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.link_article}: </strong></td>
				<td><input style="width: 550px" name="link_article" id="link_article" type="text" value="" maxlength="255" /></td>
                <td>
                    <input name="submit" type="submit" id="getLink" value="{LANG.autoconfig}" />
                    <input  name="config" type="button" id="config" value="{LANG.choseconfig}"/>    
                </td>
			</tr>
		</tbody>
	</table>
    
</form>
<form action="" id="form1" name="form1" enctype="multipart/form-data" method="post">
    <table summary="" class="tab1">
		<caption>{LANG.taonhomlaytin}</caption>
		<tbody>
            <tr>
                <td align="right"><strong>{LANG.taochuyenmuc}: </strong></td>
				<td>
                    <input style="width: 200px" name="tencm" id="tencm" type="text" value="{LANG.chuyenmuc}" onclick="if(this.value=='{LANG.chuyenmuc}'){this.value='';}" maxlength="100" />
                    <input  style="width:500px;" name="linkcm" id="linkcm" type="text" value="{LANG.linkchuyenmuc}" onclick="if(this.value=='{LANG.linkchuyenmuc}'){this.value='';}"/>
                </td>
                <td><input name="tao" type="button" id="taocm" value="{LANG.themcm}" /></td>
            </tr>
            <tr>
                <td align="center"><strong>{LANG.xoachuyenmuc}</strong></td>
                <td>
                    {xoachuyenmuc}
                </td>
                <td><input name="xoa" type="button" id="xoacm" value="{LANG.xoachuyenmuc}"/></td>
            </tr>
        </tbody>
    </table>
</form>
<form enctype="multipart/form-data" action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=saveconfigauto" method="post">
    <table summary="" class="tab1">
		<caption>{LANG.gomnhomtintudong}</caption>
		<tbody>
            <tr>
                <td align="right"><strong>{LANG.laytintheo}</strong></td>
                <td>
                    <select name="laytintheo">
                        <option value="1">{LANG.trangweb}</option>
                        <option value="0">{LANG.chuyenmuc}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right" width="200px"><strong>{LANG.tudieuchinhtg}</strong>
                <td>
                    <select name="tudctg">
                        <option value="1">{LANG.co}</option>
                        <option value="0">{LANG.khong}</option>
                    </select>
                </td>
            </tr>
            <tr >
                <td align="center" colspan='2'>
                     <input  type="submit" value="{LANG.saveconfig}"/> 
                </td>
            </tr>
		</tbody>
	</table>
<!-- END: sendLink -->
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#config").click(function(){
            var link=$("#link_article").val();
            window.location.href= nv_siteroot+"admin/index.php?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=getarea&link="+link;
        })
        $("#form1 input").click(function(){
            
        })
        $("#taocm").click(function(){
            var tencm=$("#tencm").val();
            var linkcm=$("#linkcm").val();
            nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=saveconfigcm&tencm="+tencm+"&linkcm="+linkcm+"&tao=ok","","thongbao");
        });
        $("#xoacm").click(function(){
            var xoacm=$("#delcm").val();
            var ten=$("#delcm option:selected").text();
            nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=saveconfigcm&xoacm="+xoacm+"&ten="+ten+"&xoa=ok","","thongbao");
        });
    })
    function thongbao(a)
    {
        alert(a);
        window.location.href=window.location;
    }
</script>
 <!--END: main -->
