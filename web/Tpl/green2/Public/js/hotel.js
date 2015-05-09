// JavaScript Document

$(function() {

    $("#start_date, #end_date").change(function() {
        var datetype = $(this).attr("name");
        if (datetype == "come_date") {
            if ($(this).attr("val") <= $("#end_date").attr("val")) {
                getRooms($(this).attr("val"), $("#end_date").attr("val"), $(this).attr("hotel_id"), $(this).attr("room_id"), $(this).attr("url"));
            }
        }
        else if (datetype == "leave_date") {
            if ($(this).attr("val") >= $("#start_date").attr("val")) {
                getRooms($("#start_date").attr("val"), $(this).attr("val"), $(this).attr("hotel_id"), $(this).attr("room_id"), $(this).attr("url"));
            }
        }
        function getRooms(begin, end, hotel_id, room_id, url) {
            $.ajax({
                url: url,
                data: {date_limit_begin: begin, date_limit_end: end, hotel: hotel_id, room: room_id},
                type: "get",
                dataType: "json",
                async: false,
                success: function(e) {
                    $("#roomcount").html(e.ROOM);
                    $("#roomcount").trigger("change");
                    var rooms = e.emptyRooms;
                    $("#room_date ul").empty();
                    for (var room in rooms) {
                        $("#room_date ul").append('<li class="room_date_one" price="' + rooms[room]["price"] + '"><div class="room_date_on"><span class="font_brown">' + rooms[room]["date"] + '</span></div><div class="room_date_down"><span class="font_orange">' + rooms[room]["price"] + '元</span></div><div class="room_date_down"><span class="font_orange">余' + rooms[room]["room_count"] + '间</span></div></li>');
                    }
                    count_money();
                }
            });
        }
    }).triggerHandler("change");


    $("#roomcount").change(function() {
        $people = $(this).val();
        $("#visitors").empty();
        for (var i = 1; i <= $people; i++) {
            $("#visitors").append('<table class="ide_main2 table_form"><tr><td style="width:70px;">房间' + i + '：</td><td style="width:70px;" class="form_td"><span class="font_red">*</span>姓名：</td><td width="60"><input name="names[]" type="text" class="txt" datatype="*" size="10" tip="请输入姓名" sucmsg=" " nullmsg=" " id="room_' + i + '" /></td><td><div class="Validform_tipbox" for="room_' + i + '" style="min-width:30px;"></div></td><td style="width:100px;" class="form_td"><span class="font_red">*</span>证件号码：</th><td style="width:98px;"><select name="credentials[]" id="select" class="select"><option value="0" selected="selected">身份证</option><option value="1">护照</option><option value="2">军官证</option><option value="3">回乡证</option><option value="4">台胞证</option><option value="5">国际海员证</option></select></td><td style="width:210px;"><input name="content[]" sucmsg=" " id="content_' + i + '" type="text" class="txt_id" datatype="*" size="40" tip="请输入证件信息" nullmsg=" " /></td><td><div class="Validform_tipbox" for="content_' + i + '" style="min-width:30px;"></div></td></tr></table>');
        }
        $("#rcount").html($people);
        count_money();
    }).trigger("change");


    $("#bonus_money").change(function() {
        if ($(this).val() == "" || isNaN($(this).val()))
            $("#award").html(0);
        else
            $("#award").html(parseFloat($(this).val()));
        count_money();
    }).trigger("change");


    var must_pay;
    var all_money;

    function count_money() {
        var rooms = parseFloat($("#roomcount").val());
        var sumprice = 0;
        $("#room_date ul li").each(function() {
            sumprice += parseFloat($(this).attr("price"));
        });
        $("#countmoney").html((rooms * sumprice));

        var total = parseFloat($("#countmoney").html()) - parseFloat($("#serial_count").html()) - parseFloat($("#award").html());
        must_pay = parseFloat($("#countmoney").html());
        all_money = total;
        $("#total").html(total);
    }

    $("#sendout").click(function() {
        $("#order_form").submit();
    });
    $("#order_form").submit(function() {
        $("#must_pay").val(must_pay);
        $("#all_money").val(all_money);
    });

    $("#use_serial").click(function() {
        $.ajax({
            url: $(this).attr("url"),
            data: {serial_num: $("#serial_num").val()},
            type: "post",
            dataType: "json",
            async: false,
            success: function(e) {
                if (e == "0") {
                    art.dialog.alert("代金券编号不正确！");
                    $("#serial_num").focus();
                }
                else {
                    art.dialog.confirm("此代金券可支付" + e + "元，使用后代金券将作废，是否确定使用？", function() {
                        $("#result").html("已使用，面值" + e + "元");
                        $("#serial").html(e);
                        $("#serial_count").html(e);
                        $("#serial_n").val($("#serial_num").val());
                        $("#serial_num").attr("disabled", "disabled");
                        $("#use_serial").attr("disabled", "disabled");
                        count_money();
                    });
                }
            }
        });
    });
    $("#lookcash").click(function() {
        var url = $(this).attr("url");
        var mun = $("#serial_num").val().replace(/(^\s*)|(\s*$)/g, "");
        if (mun != "" && mun != null) {
            art.dialog.open(url + "?num=" + $("#serial_num").val(), {
                title: '查看我的代金券', //窗口标题
                width: 720,
                height: 500,
                window: 'top', //在顶层打开
                lock: 'true'	  //打开时锁定屏幕
            });
        } else {
            art.dialog.alert("代金券编号不正确！");
            $("#serial_num").focus();
        }
    });
//-----------------------------------------------------------------------------

    $(".ui-tabs").each(function() {
        var active = $(this).attr("active") || 0;
        $(this).tabs({active: active});
    });
    $(".search_box :checkbox").click(function() {
        var args = {};
        var url = "";
        var g = "";
        $(".search_box").each(function(i) {
            var values = []
            $(this).find("input:checked").each(function(i) {
                values[i] = $(this).val();
            });
            if (values.length > 0) {
                args[$(this).attr("data-name")] = values.join(",");
            }
        });
        for (i in args) {
            url += g + i + "=" + args[i];
            g = "&";
        }
        window.location = $("url").text() + "&" + url;
    });
    $(".search_title a").click(function() {
        var args = {};
        var url = "";
        var g = "";
        var key = $(this).attr("data-name")
        $(".search_box").each(function(i) {
            if ($(this).attr("data-name") == key) {
                return;
            }
            var values = []
            $(this).find("input:checked").each(function(i) {
                values[i] = $(this).val();
            });
            if (values.length > 0) {
                args[$(this).attr("data-name")] = values.join(",");
            }
        });
        for (i in args) {
            url += g + i + "=" + args[i];
            g = "&";
        }
        window.location = $("url").text() + "&" + url;
    });
    $(".city-list-plugs").city_list_plugs()



});

$(function() {
    $(".__index").hide();
    $("._index").hide();
    $(".__index").first().show();
    $("._index").first().show();
    $(".__listhead").first().attr("class", "col-2 on title __listhead");

    $(".__listhead").click(function() {
        $(".__listhead").attr("class", "col-2 title __listhead");
        $(this).attr("class", "col-2 on title __listhead");
        $(".__index").hide();
        $("._index").hide();
        $("#" + $(this).attr("ind")).show();
        $("#t" + $(this).attr("ind")).show();
    });
});

$(function() {
    $(document).ready(function() {
        $(".hotels").each(function() {
            $(this).height(($(this).width() * 3 / 4));
        });
    });
});

$(function() {
    try {
        $("#start_date ,#end_date").datepicker("option", "minDate", new Date($("#start_date").attr("min")));
        $("#start_date ,#end_date").datepicker("option", "maxDate", new Date($("#end_date").attr("max")));

        $("#start_date").datepicker("option", "onSelect", function(dateText, ins) {
            var date_info = dateText.match(/(\d{4})\-(\d{2})\-(\d{2})/);
            var end_date = new Date(date_info[1], parseInt(date_info[2]) - 1, parseInt(date_info[3]) + 1);
            $("#end_date").datepicker("option", "minDate", end_date);
            $("#start_date").val(dateText).attr("val", (Date.UTC(date_info[1], date_info[2], date_info[3])) / 1000);
            $("#start_date").trigger("change");
        });

        $("#end_date").datepicker("option", "onSelect", function(dateText, ins) {
            var date_info = dateText.match(/(\d{4})\-(\d{2})\-(\d{2})/);
            var start_date = new Date(date_info[1], parseInt(date_info[2]) - 1, parseInt(date_info[3]) - 1);
            $("#start_date").datepicker("option", "maxDate", start_date);
            $("#end_date").val(dateText).attr("val", (Date.UTC(date_info[1], date_info[2], date_info[3])) / 1000);
            $("#end_date").trigger("change");
        })
    }
    catch (e) {
    }
    $(".ui-tabs-pos .ui-tabs-item a").click(function() {
        var parent = $(this).parent();
        var id = $(this).attr("href");
        var target = $(id);
        parent.addClass("active").siblings().removeClass("active");
        if (target.length > 0) {
            target.show().siblings().hide();
        }
        return false;
    });
    var pos_active = $(".ui-tabs-pos").attr("active") || 1;
    $(".ui-tabs-pos a[href='#pos-" + pos_active + "']").trigger("click");
});