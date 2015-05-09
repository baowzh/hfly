/*导航菜单效果*/
$(function(){
    $("ul[class=tr_li_ul]>li:last").css("border-bottom","none")
    $("ul[class=tr_li_ul]>li").hover(function(){
        $(this).find("div[class=tr_li_expand]").show();
        $(this).find("span[class=li_sp]").addClass("li_hover_sp");
    },function(){
        $(this).find("div[class=tr_li_expand]").hide();
        $(this).find("span").removeClass("li_hover_sp");
    });
    /*国内旅游线路推荐表格鼠标浮动事件以及去除表格最后行的底线*/
    $(".gntj_p_ta>tbody>tr").hover(function(){
        $(this).css("background","#FAFCF0")
    },function(){
        $(this).css("background","none")
    });
    uzaiIndexBannerSlide();//调用主页图片展示效果方法

    table_w_h();//调用获取表格宽度和高度
    cg_tab();//调用首页出境，国内游Tab效果方法
    clear_S_box();//调用清楚文本框值方法
    closediv();//调用关闭div块
})


//主页图片展示效果
var c = 0;
var s = 0;
var clock;
function uzaiIndexBannerSlide() {
    c = $("#divbanner li").size();

    bannermouseover();
    bannerlist();
}

function bannerAutoShow() {
    if (s >= c) {
        s = 0;
    }
    $("#divbanner li a").removeClass();
    $("#divimagebanner a").filter(":visible").hide();
    $("#divbanner li a").eq(s).addClass('on');
    $("#divimagebanner a").eq(s).show();
    s++;
}
function bannerlist() {
    clock = window.setInterval("bannerAutoShow()", 3000);
}
function bannermouseover() {
    $("#divbanner li").each(function (index) {
        $(this).bind("mouseover", function () {
            $("#divbanner li a").removeClass();
            $("#divimagebanner a").filter(":visible").hide();
            $("#divbanner li a").eq(index).addClass('on');
            $("#divimagebanner a").eq(index).show();
            window.clearInterval(clock);
        });
        $(this).bind("mouseout", function () {
            clock = window.setInterval("bannerAutoShow()", 3000);
        });
    });
}

//线路页面Tab选项卡
function nTabs(thisObj, Num) {
    if (thisObj.className == "active") return;
    var tabObj = thisObj.parentNode.id;
    var tabList = document.getElementById(tabObj).getElementsByTagName("li");
    for (i = 0; i < tabList.length; i++) {
        if (i == Num) {
            thisObj.className = "active";
            document.getElementById(tabObj + "_Content" + i).style.display = "block";
        } else {
            tabList[i].className = "normal";
            document.getElementById(tabObj + "_Content" + i).style.display = "none";
        }
    }
}
//设置表格的高宽度
function table_w_h(){
    $(".tab1_chi_ta1>tbody>tr>td").width(62);
    $(".tab1_chi_ta1>tbody>tr>td").height(48);
    $(".tab1_chi_ta1>tbody>tr>td").hover(function(){
        $(this).css("background","#88C22C");
    },function(){
        $(this).css("background","#FFFFFF");
    })
}
/*出境游，国内游TAB效果*/
function cg_tab(){
    $(".tab_tit>li[id=cj_ly]").click(function(){
        $("#gn_ly").removeClass("cg_active");
        $(this).addClass("cg_active");
        $(".guonei_cont").hide();
        $(".chuj_cont").show();
    })
    $(".tab_tit>li[id=gn_ly]").click(function(){

        $("#cj_ly").removeClass("cg_active");
        $(this).addClass("cg_active")
        $(".chuj_cont").hide();
        $(".guonei_cont").show();
    })
}
/*清楚文本框的值*/
function clear_S_box()
{
    $(".csb_txt").focus(function(){
        var $txt=$(this).val();
        if($txt==this.defaultValue)
        {
            $(this).val(" ")
        }
    })
    $(".csb_txt").blur(function(){
        var $txt=$(this).val();
        if($txt==" ")
        {
            $(this).val(this.defaultValue);
        }
    })
}
$(function(){
    $(".chi_lvyou>li").last().css("border-bottom","none")//去处底部边框线条
    $(".gntj_p_ta>tbody>tr:last").find("td").css("border-bottom","none");
    $(".gn_ly>dd:last").css("border-bottom","none");
    $(".chi_abs>li:last").css("border-bottom","none");
})
function closediv(){
    $(".close").click(function(){
        $(".wx_ts").hide();
    })
}


	
