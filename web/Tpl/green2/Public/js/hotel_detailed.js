// JavaScript Document
$(function() {
    try {
        $.fn.cityLink({
            linkId: {
                province: "province",
                city: "city",
                county: "area"
            },
            defaults: {
                province: "{$province}",
                city: "{$city}",
                county: "{$area}"
            }});

        var aa = $("input[name=position_x]").val();
        var bb = $("input[name=position_y]").val();
        if (aa != '') {
            baidu_map({lat: bb, lng: aa, adr: ""});
        } else {
            baidu_map();
        }
    } catch (e) {
    }
});

$(function() {
    $(".__index").hide();
    $(".__index").first().show();
    $(".__listhead").first().attr("class", "col-2 on title __listhead");

    $(".__listhead").click(function() {
        $(".__listhead").attr("class", "col-2 title __listhead");
        $(this).attr("class", "col-2 on title __listhead");
        $(".__index").hide();
        $("#l" + $(this).attr("ind")).show();
    });
});



$(function() {
    $("#verify").siblings("span").hide();
    $("#verify").focus(function() {
        $(this).siblings("span").show();
        $(this).siblings("span").find("img").attr("src", $(this).siblings("span").find("img").attr("url") + "?img=" + Math.random());
    }).blur(function() {
        $(this).siblings("span").hide();
    });
});


$(function() {
    $("#publish").click(function() {
        location.href = $(this).attr("url");
    });


});




// 添加酒店收藏按钮
$(function() {

    $("._collect").click(function() {
        $.post(
                $("h1 #collect-cmd").attr("url"),
                {hotel: $("h1 #collect-cmd").attr("hotel"), status: $(this).attr("value")}
        );
        if ($(this).attr("value") == "0") {
            $(this).attr("value", 1).attr("title", "添加至酒店收藏").html("<span class='collect_off'>&nbsp;</span>");
        } else {
            $(this).attr("value", 0).attr("title", "取消酒店收藏").html("<span class='collect_on'>[已收藏]</span>");
        }
    });

});

//滚动型标签页
$(function() {

    $(window).scroll(function() {
        var span_scroll = $("span.scroll_nav").offset();
        var scrollTop = $(window).scrollTop();
        if (span_scroll.top - scrollTop <= 0) {
            $("div.scroll_nav").addClass("scroll_nav_fixed");
        } else {
            $("div.scroll_nav").removeClass("scroll_nav_fixed");
        }
        $("h1.hot_route:gt(0)").each(function(i) {
            var scroll_top = $(this).offset().top - $(window).scrollTop();
            if (i > 0 && scroll_top >= 50) {
                return false;
            }
            $("div.scroll_nav ul li").eq(i).addClass("on").siblings().removeClass("on");
        });
    }).trigger("scroll");
    $("div.scroll_nav ul li").bind("click", function() {
        var index = $("div.scroll_nav ul li").index(this);
        index++;
        var scroll_height = $("h1.hot_route:eq(" + index + ")").offset().top - 45;
        $(window).scrollTop(scroll_height);
    });

});

