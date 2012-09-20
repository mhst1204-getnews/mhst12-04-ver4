<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="quote" style="width:780px;">
    <blockquote class="error"><span>{ERROR}</span></blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->

<div style="width:100%; height:400px; overflow: auto;" id="div_contents">
    {noidung}
</div>
<input  type="hidden" value="{xpath}" id="xpath" name="xpath"/>
<!-- BEGIN: receive -->
<form id="form1" action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=getcontent" method="post">
    <table summary="" class="tab1">
		<caption>{LANG.config_receive_article}</caption>
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.title}: </strong></td>
				<td><input style="width: 650px" name="title" type="text" value="" id="tpath" maxlength="255" /></td>
			</tr>
            <tr>
                <td align="right"><strong>{LANG.head}</strong></td>
                <td>
                    <input style="width: 650px" name="title" type="text" value="" id="hpath" maxlength="255" />
                </td>
            </tr>
            <tr>
                <td align="right" style="width:60px;"><strong>{LANG.content}</strong></td>
                <td>
                    
                    <input style="width: 650px" name="title" type="text" value="" id="contentpath" maxlength="255" />
                </td>
            </tr>
		</tbody>
	</table>
    <br>
    <div align="center">
        
        <input  type="hidden" value="{site}" name="site" id="site"/>
        <input name="saveConfig" id="saveConfig" type="button" value="{LANG.saveconfig}" />
        <input name="exit" type="button" value="{LANG.exitconfig}" onclick="javascript:history.go(-1)" />
    </div>
</form>
<!-- END: receive -->

<script type="text/javascript">
$(document).ready(function(){
    var arr=new Array("tiêu đề","mô tả","nội dung");
    var arrID=new Array("tpath","hpath","contentpath");
    var arrColor=new Array("red","blue","green");
    var arrSelect=new Array("start","end");
    var i=0;var oldcolor="";var g=0;
    $("#div_contents").bind('mouseout mouseover',function(event){
      var $tgt = $(event.target);
      var $z=event.target.nodeName;
      if ($tgt.closest($z).length) {
          $tgt.toggleClass('outline-element');
      }
    }).click(function(event){
            oldcolor=$(this).css("color");
            if(i<2)
            {
                $("#mark"+arrID[i]).removeAttr("id").removeAttr("check").css("color",oldcolor);
                if($(event.target).attr("check")==null)
                {
                    $(event.target).attr("id","mark"+arrID[i]).attr("check","true").css("color",arrColor[i]);
                }
            }
            else
            {
                if($(event.target).attr("check")==null)
                {
                    $(event.target).attr("id","mark"+arrSelect[g]).attr("check","true").css("color",arrColor[i]);
                    g=g+1;
                }
            }
            
            
    }).dblclick(function(event){
            var arrresul=new Array();
            var kq=confirm("Chọn làm "+arr[i]+" :");
            if(kq)
            {
                var xpath="{xpath}";
                if(i<2)
                {
                    var path=getXPath(document.getElementById("mark"+arrID[i]));
                    var kq="";
                    for(var r=1;r<path.length;r++)
                    {
                        if(path[r]!=null)
                        {
                            kq=kq+path[r]+","; 
                        }
                           
                    }alert(kq);
                    kq=kq.substring(0,kq.length-1);
                    xpath=xpath+kq;
                    $("#"+arrID[i]).val(xpath);
                    i=i+1;
                } 
                else
                {
                    for(var j=0;j<2;j++)
                    {
                        if(j==0)
                        {
                            var path=getXPath(document.getElementById("mark"+arrSelect[j]));
                            var kq="";
                            for(var r=1;r<path.length;r++)
                            {
                                if(path[r]!=null)
                                {
                                    kq=kq+path[r]+","; 
                                }
                                   
                            }
                            kq=kq.substring(0,kq.length-1);
                            xpath=xpath+kq;
                        }
                        else
                        {
                            var path=getXPath(document.getElementById("mark"+arrSelect[j]));
                            var child=document.getElementById("mark"+arrSelect[j]).nextSibling;
                            var count=0;
                            while(child)
                            {
                                count=count+1;
                                child=child.nextSibling;
                            }                   
                            xpath=xpath+",0,@"+count+",";
                        }
                    }
                    $("#"+arrID[i]).val(xpath);
                    i=i+1;
                }
            }
            else
            {
                $(event.target).removeAttr("id").removeAttr("check").css("color",oldcolor);
                g=g-1;
            }
        });
        
        $("#saveConfig").click(function(){
            var titlepath=$("#tpath").val();
            var headpath=$("#hpath").val();
            var contentpath=$("#contentpath").val();
            var site=$("#site").val();
            $.ajax(
                {
                    type : 'POST',
                    url : nv_siteroot+"admin/index.php?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=saveconfig",
                    data : 'tpath='+titlepath+'&hpath='+headpath+'&cpath='+contentpath.substring(0,contentpath.length -1)+'&site='+site,
                    success : function(data)
                    {
                        var getData = $.parseJSON(data);
                        alert(getData);
                    }
                });
        })
})
function getXPath(node, path) {
      path = path || [];
      if (node.parentNode && node.getAttribute("id")!="div_contents") {
          path = getXPath(node.parentNode, path);
      }
      if (node.previousSibling) {
          var count = 0;
          var sibling = node.previousSibling
          do {
              if (sibling.nodeType == 1) { count++; }
              sibling = sibling.previousSibling;
          }while (sibling);
      }
      if (node.nodeType == 1) {
          path.push(count);
      }
      return path;
  }

</script>
 <!--END: main -->