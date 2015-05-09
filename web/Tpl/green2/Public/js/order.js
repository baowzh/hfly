// JavaScript Document

//获得银行列表
$(function() {
    var api_url = $("#banks").attr("url");
    $(".banklist #deposit_card ul, .banklist #credit_card ul").append("<font size='4'><strong>&nbsp;&nbsp;银行列表正在加载，请稍等...</strong></font>");
    $(".cards").each(function() {
        var _name = $(this).attr("value");
        $.post(
				api_url,
				{api_name: _name},
        function(msg) {
            var ul1 = $(".banklist[value='" + _name + "'] #deposit_card ul");
            var ul2 = $(".banklist[value='" + _name + "'] #credit_card ul");
            if (msg.status == 'y') {
                ul1.empty();
                ul2.empty();
                //储蓄卡
                for (var key in msg.data[1]) {
                    ul1.append("<li><label for='" + _name + "_" + msg.data[1][key].code + "_1'><input id='" + _name + "_" + msg.data[1][key].code + "_1' name='" + _name + "' type='radio' value='" + msg.data[1][key].code + "'><img src='" + msg.data[1][key].icon + "' title='使用" + msg.data[1][key].name + "支付' value='" + msg.data[1][key].name + "' index='" + msg.data[1][key].code + "' height='52'></label></li>");
                }
                //信用卡
                for (var key in msg.data[2]) {
                    ul2.append("<li><label for='" + _name + "_" + msg.data[2][key].code + "_2'><input id='" + _name + "_" + msg.data[2][key].code + "_2' name='" + _name + "' type='radio' value='" + msg.data[2][key].code + "'><img src='" + msg.data[2][key].icon + "' title='使用" + msg.data[2][key].name + "支付' value='" + msg.data[2][key].name + "' index='" + msg.data[2][key].code + "' height='52'></label></li>");
                }
                ul1.find("li input[type='radio']").first().attr("checked", "checked");
            } else {
                art.dialog.alert(msg.info);
            }
        },
		  "json"
		 );
    }).click(function() {
        $("#payType").val($(this).attr("code"));
        $("#typeName").val($(this).attr("value"));
    });
    $(".cards").first().trigger("click");
});

//展示或隐藏“输入支付密码”密码框
$(function() {
    $("#use_amount").click(function() {
        if ($(this).attr("checked")) {
            $("#use_amount_form").show();
        } else {
            $("#use_amount_form").hide();
        }
    }).triggerHandler("click");
});

//验证支付密码并对验证结果作出处理
$(function() {
    $("#amount_bill").click(function() {
        if ($("#use_amount").attr("checked")) {
            if ($("#pay_password").val() == "") {
                art.dialog.alert("请输入支付密码！");
                $("#pay_password").focus();
                return;
            }
        }
        //验证支付密码：
        var _this = $(this);
        $.post(
                $(this).attr("url"),
                {pass: $("#pay_password").val()},
        function(msg) {
            if (msg.result == true) {
                _this.parent("td").append("<input type='hidden' name='pass' value='" + msg.check + "' />");
                _this.attr("disabled", true);
                $("#pay_password").attr("disabled", true);
                $("#use_amount").attr("pass", 1);
                art.dialog.alert("支付密码已确认，将优先使用账户余额支付，若余额不足，则以其他支付方式支付剩余部分。<br/>若不愿使用余额支付，将“使用账户余额支付”的钩去掉即可。<br/>请选择一种其他支付方式。");
            } else {
                art.dialog.alert("支付密码错误，请重新输入。");
            }
        },
                "json"
                );
    });
});

//管理表单提交和数据传输
$(function() {
    $("#pay_password").keydown(function(event) {
        if (event.keyCode == 10 || event.keyCode == 13) {
            return false;
        }
    });
});

//自动下一步的倒计时
$(function() {
    var timeout = 10000;
    var int = setInterval(function() {
        $("#next_step2 span").html((timeout / 1000));
        if (timeout <= 0) {
            clearInterval(int);
            dosubmit();
        }
        timeout -= 1000;
    }, 1000);

    $("#next_step2").click(function() {
        clearInterval(int);
        dosubmit();
    });
	 
	 function dosubmit(){
		 $("#billForm").submit()
	 }
});

$(function(){
	
	var payfront = new Array($("#payfront_1").attr("v"), $("#payfront_2").attr("v"));
	$(".payfront").click(function(){
		$("#may_pay").html(payfront[$(this).attr("value")]);
	});
	
	$("#next_step").click(function() {
        var inf = "";
        var paytype = $(".cards[code=" + $("#payType").val() + "]").html();
        if ($("#use_amount").attr("pass") == "1" && $("#use_amount").attr("checked")) {
            inf = "优先使用账户余额支付，若余额不足，则自动以其他方式补充支付。";
        } else {
            inf = "不使用账户余额支付，全额以其他方式支付。";
        }
        art.dialog.confirm("进行下一步前的确认：<p>本次付款" + inf + "<br/>选用的其他支付方式是" + paytype,
                function() {
						 $("#payform").append("<input type='hidden' name='pay_status' value='"+ $(".payfront:checked").val() +"'>");
						 $(".payfront:checked").val(payfront[$(".payfront:checked").val()]);
                   $("#payform").submit();
						 setTimeout(function(){
							 $("#wait").submit();
						 }, 1);
                });
    });

});