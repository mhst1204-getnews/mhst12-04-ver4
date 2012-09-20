<!-- BEGIN: main -->
<!-- BEGIN:getinfomation -->
<form action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=getxml" method="post">
    {LANG.linksite}
    <input size="60" type="text" id="site" value="{linksite}" name="site"/>
    <input  type="submit" value="{LANG.save1}" id="select" name="select"/>
</form>
<!-- END: getinfomation -->
<div>
<!-- BEGIN: receive -->
<div id="receive_inf" style="margin-top: 10px; width: 100%; float: left;">
    {source}
</div>
<!-- END: receive -->

<!--BEGIN: Action -->
<div>
<form id="active" action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=savenews&site={linksite}" method="post">
    <!--BEGIN: ListCat -->
    <div style="margin-top:10px; float:left; width:100%;">
    <div style="height:10px"></div>
    {choncm}
    {listcats}
    <!--END: ListCat -->
    {action}
</form>
</div>
</div>
<!--END: Action -->
<!--END: main -->

<style>
#receive_inf
{
    height:500px;
    overflow:scroll;
}
.clearfix:after, .container:after {
    clear: both;
    content: "?020";
    display: block;
    height: 0;
    overflow: hidden;
    visibility: hidden;
}
.box, .box-border, .box-border-shadow, .content-box, .block-signed a, .clearfix, .container, .sideon {
    display: block;
    width:500px;
    float: left;
    margin:5px 5px;
    border:1px solid white;
    padding-top: 5px;
}
.folder-bottom {
    background: url(../../themes/admin_default/images/getnews/bg_vne.gif) repeat-x scroll 0 -73px #F5F5F6;
}
img.s-border {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #D8D8D8;
    padding: 4px;
}
.fl {
    float: left;
}
.left {
    margin-right: 0.875em !important;
}
a
{
    text-decoration: none;
}
.check
{
    border:1px solid black;
}
p
{
    padding-top:5px;
    text-align: justify;
    padding-right:5px;
}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        var count='{count}';
        var arrLink=new Array();
        for(var i=0;i<count;i++)
        {
            $("#content"+i).click(function(){
                $(this).toggleClass('check');
            })
        }
        
        $("#getNews").click(function(){
            for(var i=0;i<count;i++)
            {
                var check=$("#content"+i).hasClass('check');
                if(check)
                {
                    var link=$("#link"+i).val();
                    arrLink.push(link);
                }
            }
            if(arrLink!=null|| arrLink!="")
            {
                $("#getLink").val(arrLink);
                $("#active").submit();
            }
        })
    })
</script>