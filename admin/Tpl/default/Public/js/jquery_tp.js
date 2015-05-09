$(document).ready(function () {
    (function () {
        //base information click tabs
        var $bi_tab_menu = $("ul.bi_tab_menu li");
        $bi_tab_menu.click(function (event) {
            $(this).addClass("on").siblings().removeClass("on");
            var index = $bi_tab_menu.index(this);
            $("div.bi_tab_con > div").eq(index).fadeIn().siblings().fadeOut("fast");
            event.preventDefault();
        }).eq(0).click();
    })();


    
    //popup     弹出层
    var popup = {
        showPopup:function ($obj) {
            $obj.fadeIn("fast");
        },
        hidePopup:function ($obj) {
            $obj.fadeOut("fast");
        }
    };
})(jQuery);

