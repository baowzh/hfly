// JavaScript Document

$(function() {

	 //使用的奖金额度：
	 var pay_award = 0;
	 //订单应付款：
	 var must_pay = 0;
	 //订单总付款：
	 var all_money = 0;

    //增加门票类型
    $(".add-ticket #add_ticket").change(function() {
        var index = $(this).val();
        var ticket_height = $(".ticket[value='" + index + "']").height();
        var price_height = $(".price_list[value='" + index + "']").height();
        $(".ticket[value='" + index + "'], .price_list[value='" + index + "']").height(0).css("opacity", 0);
        $(".ticket[value='" + index + "']").show();
        $(".price_list[value='" + index + "']").show();
        $("#view_award").val("").trigger("change");

        $(this).find("option[value='" + index + "']").remove();
        count_money();

        $(".ticket[value='" + index + "']").animate(
                {height: ticket_height, opacity: 1},
        500,
                "easeOutQuad"
                );
        $(".price_list[value='" + index + "']").animate(
                {height: price_height, opacity: 1},
        500,
                "easeOutQuad"
                );
    });

    //减少门票类型
    $(".add-ticket .minus").click(function() {
        var index = $(this).attr("value");
        var ticket_height = $(".ticket[value='" + index + "']").height();
        var price_height = $(".price_list[value='" + index + "']").height();

        $(".ticket_num[ind='" + index + "']").val("");
        $(".ticket_price_" + index).html($(".price_list[value='" + index + "'] #kit_list tr .price1 span").html());
        $(".add-ticket #add_ticket").append("<option value=" + index + ">" + $(this).attr("names") + "</option>");
        $("#view_award").val("").trigger("change");
        count_money();

        $(".ticket[value='" + index + "'], .price_list[value='" + index + "']").animate(
            {height: 0, opacity: 0},
        		500,
				"easeOutQuad",
				function() {
					 $(".ticket[value='" + index + "']").height(parseFloat(ticket_height)).hide();
					 $(".price_list[value='" + index + "']").height(parseFloat(price_height)).hide();
				}
        );
    });

    //门票张数-价格变换
    $(".ticket_num").keyup(function() {
        var index = $(this).attr("ind");
        var p = parseFloat($(this).val());
        if (p > 2 && p <= 10) {
            $(".ticket_price_" + index).html($(".price_list[value='" + index + "'] #kit_list tr .price2 span").html());
        }
        else if (p > 10) {
            $(".ticket_price_" + index).html($(".price_list[value='" + index + "'] #kit_list tr .price3 span").html());
        }
        else {
            $(".ticket_price_" + index).html($(".price_list[value='" + index + "'] #kit_list tr .price1 span").html());
        }
        $("#view_award").val("").trigger("change");
        count_money();
    });

    //计算使用的奖金部分
    $("#view_award").change(function() {
        var _max = parseFloat($("#all_use_award").html());
        if (parseFloat($(this).val()) <= _max && parseFloat($(this).val()) >= 0) {
            $(".jsu #serial_count").html(Math.min(parseFloat($(".jsu #id_view_award").html()), parseFloat($(this).val())));
        } else if (parseFloat($(this).val()) < 0 || $(this).val() == "") {
            $(".jsu #serial_count").html(0);
        } else {
            $(".jsu #serial_count").html(Math.min(parseFloat($(".jsu #id_view_award").html()), _max));
        }
		  pay_award = parseFloat($(".jsu #serial_count").html());
        $(this).attr("max", $("#all_use_award").html());
        count_money();
    });

    //使用代金券
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
                        $(".jsu .cash_award").html(e);
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

    //计算总钱数
    function count_money() {
        var count = 0;
        var user_award = 0;
		  must_pay = 0;
		  all_money = 0;
        $(".ticket_num").each(function() {
            var count_tmp = ($(this).val() != "" && $(this).val() != null) ? parseFloat($(this).val()) : 0;
            var award_tmp = $(".price_list[value='" + $(this).attr("ind") + "'] #kit_list tr .price4 span").html();

            $("#view_award").attr("max", $("#all_use_award").html());
            award_tmp = (award_tmp != "" && award_tmp != null) ? award_tmp : 0;

            user_award += award_tmp * $(this).val();
            count += count_tmp;
            all_money += count_tmp * parseFloat($(".ticket_price_" + $(this).attr("ind")).html());
        });
        must_pay = parseFloat($(".jsu #countmoney").html()) - parseFloat($(".jsu #serial_count").html()) - parseFloat($(".jsu .cash_award").html());

        $(".jsu #rcount").html(count);
        $(".jsu #countmoney").html(all_money);
        $(".jsu #total").html(must_pay);
        $("#all_use_award").html(user_award);
    }
	 
	 //订单提交
	 $("#sendout").click(function(){
		 $("#myform").submit();
	 });
	 $("#myform").submit(function(){
		 $("#view_award").val(pay_award);
		 $("#myform").append("<input type='hidden' name='must_pay' value='"+ must_pay +"' />");
		 $("#myform").append("<input type='hidden' name='all_money' value='"+ all_money +"' />");
		 return true;
	 });

});