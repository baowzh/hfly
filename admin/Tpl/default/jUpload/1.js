//改变出发城市或改变线路类型时重新获取目的地
function getTarget(changeid) {
    var city_id = $("#city_id").val();
    var target_type = $("#target_type").val();
    var reurl = "{:U('Line/ajax_target')}";
    reurl += "/city_id/" + city_id + "/target_type/" + target_type + "/changeid/" + changeid;
    $.ajax({
        type: "GET",
        url: reurl,
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert(errorThrown);
            // 通常 textStatus 和 errorThrown 之中
            // 只有一个会包含信息
            //this; // 调用本次AJAX请求时传递的options参数
        },
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == 1) {
                $("#Line_target").html(obj.data);
            } else {
                $("#Line_target").html("无目的地记录");
            }
        },
        dataType: "JSON"
    });
}


//改变天数时行程安排的天数也跟着改变
function changeday(obj) {
    var val = obj.value;
    var dayreg = /^[1-9]\d*$/;
    var opstr = "";
    var oldday = $("#qh_day").children("option").length;

    if (dayreg.test(val)) {
        d = parseInt(val) + 1;
        if (oldday > val) {
            var ismin = confirm("您输入的天数比原来的天数小，这将会删除第" + d + "天以后的数据，你确定修改吗");
            if (!ismin) {
                obj.value = oldday;
                return;
            }
            else {
                var countday = 0;
                for (di = d; di <= oldday; di++) {
                    countday = $("#day_" + di).length;
                    if (countday)$("#day_" + di).remove();
                }
            }
        }
        $("#qh_day").empty();
        for (i = 1; i <= val; i++) {
            opstr += "<option value='" + i + "'>第" + i + "天</option>";
        }
        $("#qh_day").append(opstr);
    }
    else {
    }
}
function addtool(obj) {
    var i = $(obj).siblings("li").length;
    var addem = '<li onclick="tabsTravel(this);">第<b>' + i + '</b>段</li>';
    $(obj).parent("ul").append($(addem));
    var day = $("#qh_day").val();
    $.ajax({
        type: "GET",
        url: "{:U('line/ajax_add_section')}/day/" + day + "/section/" + i,
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == 1) {
                var em = $(obj.data);
                //alert(obj.data)
                $("#TravelText_" + day + ">table:last").after(em);
                loadXH("activity_text_" + day + "_" + i);
            } else
                alert(obj.info);
        }
    });

}
function changedaytag(val) {
    var isload = $("#day_" + val).length;
    if (isload) {
        $(".line_day").hide();
        $("#day_" + val).show();
    }
    else {
        $.ajax({
            type: "GET",
            url: "{:U('line/ajax_add_day')}/day/" + val,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.status == 1) {
                    var em = $(obj.data);
                    //alert(obj.data)
                    $(".line_day:last").after(em);
                    loadXH("activity_text_" + val + "_1");
                    $(".line_day").hide();
                    $("#day_" + val).show();
                } else
                    alert(obj.info);
            },
        });
    }
}
function deltool(obj) {
    var i = $(obj).siblings("li").length;
    if (i > 2) {
        var day = $("#qh_day").val();
        var index = $(obj).siblings("li:last").children("b").text();
        var isdel = confirm("您将删除第" + index + "段，一旦删除，会使该段原先编辑的数据也跟着删除，确定删除吗");
        if (isdel) {
            $(obj).siblings("li:last").remove();
            var display = $("#container_" + day + "_" + index).css("display");
            $("#container_" + day + "_" + index).remove();
            if (display != "none")
                $("#container_" + day + "_1").show();
        }
    }
    else {
        alert("至少保留一段");
    }
}
function tabsTravel(obj) {
    var day = $("#qh_day").val();
    var index = $(obj).children("b").text();
    $(obj).addClass("yes").siblings().removeClass("yes");
    $("#TravelText_" + day + ">table").hide();
    $("#container_" + day + "_" + index).show();
}

$(function () {

    $('#SEO').click(function () {//seo开关
        chekcseo();
    });
    chekcseo();
    $("#trip_days").linePlan();
});
