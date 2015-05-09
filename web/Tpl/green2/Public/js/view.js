$(function() {
       
        var url =  $("input[name=consult]").val(); 
        $("input[name=consult_submit]").bind("click", function() {
            $.ajax({url: url,
                data: {},
                async: false
            });
        });
        url = $("input[name=coll]").val();
        $("#add_coll").bind("click", function() {   
            $.ajax({url: url,
                async: false,
                success:function(data){
                        if(data.status == '1'){
                            alert(data.info);
                        }else{
                            alert(data.info);
                        }
                }
            });
        });
    });


$(function(){
	$("#publish").click(function(){
		location.href = $(this).attr("url");
	});       

        try{
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
           var aa = $("input[name=location_x]").val();
            var bb = $("input[name=location_y]").val();
            if(aa != ''){
                baidu_map({ lat: bb,lng: aa,adr: ""});
            }else{baidu_map();}
        }catch(e){}
    $(window).scroll(function () {
        var span_scroll = $("span.scroll_REF").offset();
        var scrollTop = $(window).scrollTop();
        if (span_scroll.top - scrollTop <= 0) {
            $("div.scroll_nav").addClass("scroll_nav_fixed");
        } else {
            $("div.scroll_nav").removeClass("scroll_nav_fixed");
        }
        $("h1.hot_route:gt(0)").each(function (i) {
            var scroll_top = $(this).offset().top - $(window).scrollTop();
            if (i > 0 && scroll_top >= 50) {
                return false;
            }
            $("div.scroll_nav ul li").eq(i).addClass("on").siblings().removeClass("on");
        });
    }).trigger("scroll");
    $("div.scroll_nav ul li").bind("click", function () {
        var index = $("div.scroll_nav ul li").index(this);
        index++;
        var scroll_height = $("h1.hot_route:eq(" + index + ")").offset().top - 45;
        $(window).scrollTop(scroll_height);
    });


    $("input.verify").bind("focus", function () {
        var $img = $(this).next("img");
        var $this = this;
        var form = $($this.form);
        var imgpath = $(this).attr("imgpath");
        if ($img.length == 0) {
            $img = $("<img class='txt'>");
            $(this).after($img);
            $img.bind("click",function () {
                $img.attr("src", imgpath + "/r/" + Math.random());
                $this.validform_valid = false;
                form[0].p_validform.check(false, $this);
            }).trigger("click");
        }

    });    
    $("#consult").bind("postAfter",function(event,data){		
			if (data.status != "y") {
				alert(data.info);
				return;
			}
			var lists_que = $("#lists_que");
			lists_que.find("span.down:first").html("&nbsp;").after(data.info);
			alert("您的咨询信息已经提交，请耐心等待回复");		
    });

    $('#ei-slider').eislideshow({
        easing: 'easeOutExpo',
        titleeasing: 'easeOutExpo',
        titlespeed: 1200
    });

    $("#go_time").xl_calendar({
        data: jQuery.parseJSON($("#travel_price_list").val()),
        select_callback: function () {
            $("#reserve").removeAttr("disabled");
        }
    });
    $("#reserve").bind("click", function () {
        var start_date = $("#go_time").val();
        var start_test = /^\d{4}\-\d{2}\-\d{2}$/.test(start_date);
        if (!start_test) {
            $(".schedule_box").addClass("c_box");
            $("#go_time").trigger("focus");
            $(this).attr("disabled", "disabled");
            return;
        }
        var price_rackrate = $(".price_rackrate").html();
        var price_adult = $(".price_adult").html();
        var price_children = $(".price_children").html();
        if (price_rackrate == "--" || price_adult == "--" || price_children == "--") {
            $(".schedule_box").addClass("c_box");
            $("#go_time").trigger("focus");
            $(this).attr("disabled", "disabled");
            return;
        }
        var adult_num = $("input[name='adult_num']").val();
        var children_num = $("input[name='children_num']").val();
        if (!/^[1-9]\d?/.test(adult_num) && !/^[1-9]\d?/.test(children_num)) {
            $(".schedule_box").addClass("c_box");
            $("input[name='adult_num']").trigger("focus");
            $(this).attr("disabled", "disabled");
            return;
        } else if (adult_num != 0 && !/^[1-9]\d?/.test(adult_num)) {
            $(".schedule_box").addClass("c_box");
            $("input[name='adult_num']").trigger("focus");
            $(this).attr("disabled", "disabled");
            return;
        } else if (children_num != 0 && !/^[1-9]\d?/.test(children_num)) {
            $(".schedule_box").addClass("c_box");
            $("input[name='children_num']").trigger("focus");
            $(this).attr("disabled", "disabled");
            return;
        }
        $(this.form).trigger("submit");
    });
    $("input[name='adult_num'],input[name='children_num']").bind("blur",function () {
        var adult_num = $("input[name='adult_num']").val();
        var this_num = $(this).val();
        console.log(this_num);
        if (!/^[1-9]\d?/.test(this_num) && this_num != 0) {
            $(this).val(0);
            return;
        }
        $("#reserve").removeAttr("disabled");
    }).trigger("blur");
    $(".minus").bind({"click": function () {
        var num = parseInt($(this).siblings("input").val());
        if (num > 99 || num < 1) {
            num = 0;
        } else {
            num--;
        }
        $(this).siblings("input").val(num);},
        "mousedown": function () {
            var $this=this;
            this._setInterval=setInterval(function(){
                $($this).trigger("click");
            },100)
        },
        "mouseup":function(){
            clearInterval(this._setInterval);
        }
    });
    $(".plus").bind({"click": function () {
        var num = parseInt($(this).siblings("input").val());
        if (num > 98 || num < 0) {
            num = 0;
        } else {
            num++;
        }
        $(this).siblings("input").val(num);
    },
        "mousedown": function () {
            var $this=this;
            this._setTimeout=setTimeout(function(){
                    $this._setInterval=setInterval(function(){
                        $($this).trigger("click");
                    },100)
                },800
            )

        },
        "mouseup":function(){
            clearTimeout(this._setTimeout);
            clearInterval(this._setInterval);
        }
    });
});