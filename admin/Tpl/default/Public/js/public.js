function del(url)
{
    if(confirm("确认要删除该信息"))
    {
        location.href=url;
    }
}
function confirms(url,info)
{
    if(confirm(info))
    {
        location.href=url;
    }
}
function clears(obj)
{
    $(obj).val("");
}
function setstr(obj,obj1,str0)
{
    //alert($(str0).val());
    if($(str0).val()=="0")
    {
        $(obj).css("display","");
        $(obj).val($(str0).text());
    }
    else if($(str0).val()=="1")
    {
        $(obj).css("display","none");
        $(obj1).css("display","none");
    }
    else if($(str0).val()=="2")
    {
        $(obj).css("display","none");
        $(obj1).css("display","block");
    }
}

//显示提示信息并自动隐藏 
function showTips( tips, height, time ){
    var windowWidth  = document.documentElement.clientWidth;
    var tipsDiv = '<div class="tipsClass">' + tips + '</div>';

    $('body').append( tipsDiv );
    $( 'div.tipsClass' ).css({
        'top'       : height + 'px',
        'left'      : ( windowWidth / 2 ) - ( tips.length * 13 / 2 ) + 'px',
        'position'  : 'absolute',
        'padding'   : '3px 5px',
        'background': '#8FBC8F',
        'font-size' : 12 + 'px',
        'margin'    : '0 auto',
        'text-align': 'center',
        'width'     : 'auto',
        'color'     : '#fff',
        'opacity'   : '0.8'
    }).show();
    setTimeout( dofadeout, ( time * 1000 ));
    function dofadeout(){
        $('div.tipsClass').fadeOut();
    }
}