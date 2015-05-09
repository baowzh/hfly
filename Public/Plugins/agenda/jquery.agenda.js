(function ($) {
    $.fn.extend({
        agenda: function (options) {
            var now_date = new Date();
            var defaults = {
                data: "",
                close_btn: "/Public/Plugins/agenda/images/toolsDells.png",
                display: [0],
                min_date: (now_date.getFullYear() - 1) + "01",
                max_date: (now_date.getFullYear() + 1) + "12"
            }
            var options = $.extend(defaults, options);
            var obj = $(".agenda_box", this);
            if (obj.length == 0) {
                obj = $("<div class='agenda_box'></div>");
                $(this).append(obj);
            }
            var alert_box = '<div date="" class="linePopPrice" style="z-index: 99999">' +
                '<div class="linePopPriceTit"><b></b> <span> ' +
                '<img width="17" height="17" class="alert_box_close" src="' + options.close_btn + '" alt="关闭"></span></div>' +
                '<div class="linePopPriceText">门市价：' +
                '<input type="text" size="9" maxlength="9" onkeyup="this.value=this.value.replace(/\D/g,\'\');" class="formTitle" id="Price0"><br>' +
                '成人价：<input type="text" size="9" maxlength="9" onkeyup="this.value=this.value.replace(/\D/g,\'\');" class="formTitle" id="Price1"><br>' +
                '儿童价：<input type="text" size="9" maxlength="9" onkeyup="this.value=this.value.replace(/\D/g,\'\');" class="formTitle" id="Price2">' +
                ' <div class="linePopPriceEnd">' +
                '<input type="button" value="确定" class="formInput01"></div></div>';
            alert_box = $(alert_box);
            alert_box.hide()
            $("body").prepend(alert_box);
            $(".alert_box_close", alert_box).click(function () {
                alert_box.hide();
            });
            obj.empty();
            var obj_title = '<div class="agenda_title"><label class="title_left"></label>' +
                '<span><label class="agenda_y"></label>年<label class="agenda_m"></label>月' +
                ' <label class="agenda_d"></label>日</span><label class="title_right">' +
                '</label></div>';
            var obj_table = '<table class="table_date" cellspacing="0" cellpadding="0" border="0">' +
                '<thead><tr class="week"><td class="td_holiday">星期天</td><td>星期一</td><td>星期二</td>' +
                '<td>星期三</td><td>星期四</td><td>星期五</td><td class="td_holiday">星期六</td></tr></thead>' +
                '</table>';
            obj.append(obj_title).append(obj_table);

            var td_click = function () {
                var pos = $(this).position();
                var name = $(this).find("input").attr("name");
                var value = $(this).find("input").val();
                var date = name.match(/\[(\d{4})(\d{2})(\d{2})\]/);
                alert_box.attr("date", date[1] + date[2] + date[3]);
                alert_box.find(".linePopPriceTit b").text(date[1] + "-" + date[2] + "-" + date[3]);
                var values = value.split(",");
                $("#Price0").val(values[0] ? values[0] : 0);
                $("#Price1").val(values[1] ? values[1] : 0);
                $("#Price2").val(values[2] ? values[2] : 0);
                alert_box.css({top: pos.top + 30, left: pos.left});
                alert_box.show();
            }

            //创建日历
            var create_month = function (year, month) {
                var data_month = year.toString() + month.toString();
                if (parseInt(data_month) > options.max_date || parseInt(data_month) < options.min_date) {
                    return false;
                }
                var max_day = new Date(year, month, 0).getDate();
                var one_day = new Date(year, month - 1, 1).getDay();
                var first_day = 0;
                var table_str = '<tbody data-month="' + data_month + '"><tr>';
                var key = "";
                while (first_day < one_day) {
                    table_str += '<td class="not_day"><span></span></td>';
                    first_day++;
                }
                var day = 0;
                for (i = 1; i <= max_day; i++) {
                    first_day = (first_day == 7) ? 0 : first_day;
                    if (first_day == 0) {
                        table_str += '</tr><tr>';
                    }
                    day = i < 10 ? "0" + i.toString() : i.toString()
                    key = data_month + day;
                    table_str += '<td  class="day"><input type="hidden" name="day_val[' + key + ']"><span>' + i + '</span></td>';
                    first_day++;
                }
                while (first_day <= 6) {
                    table_str += '<td  class="not_day"><span class="not_day"></span></td>';
                    first_day++;
                }
                table_str += "<tr></tbody>";

                var return_obj = $(table_str)
                obj.find("table.table_date").append(return_obj);
                return return_obj;
            }

            $(".formInput01", alert_box).click(function () {
                var p1 = $("#Price0").val();
                var p2 = $("#Price1").val();
                var p3 = $("#Price2").val();
                var date = alert_box.attr("date");
                var dates = date.match(/(\d{4})(\d{2})(\d{2})/);
                write_data(dates[1], dates[2], dates[3], [p1, p2, p3]);
                alert_box.hide();
            });
            //上个月
            var prew_month = function () {
                var y = parseInt(obj.find(".agenda_y").text());
                var m = parseInt(obj.find(".agenda_m").text());
                m--;
                y = (m == 0) ? y - 1 : y;
                m = (m == 0) ? 12 : m;
                m = (m < 10) ? "0" + m.toString() : m.toString();
                var pr_month = y.toString() + m;
                var pr_month_obj = obj.find("tbody[data-month='" + pr_month + "']");
                if (pr_month_obj.length == 0)pr_month_obj = create_month(y, m);
                if (pr_month_obj !== false) {
                    alert_box.hide();
                    pr_month_obj.show().siblings("tbody").hide();
                    obj.find(".agenda_y").text(y);
                    obj.find(".agenda_m").text(parseInt(m));
                }
            }
            var next_month = function () {
                var y = parseInt(obj.find(".agenda_y").text());
                var m = parseInt(obj.find(".agenda_m").text());
                m++;
                y = (m == 13) ? y + 1 : y;
                m = (m == 13) ? 1 : m;
                m = (m < 10) ? "0" + m.toString() : m.toString();
                var next_month = y.toString() + m;
                var mext_month_obj = obj.find("tbody[data-month='" + next_month + "']");
                if (mext_month_obj.length == 0)mext_month_obj = create_month(y, m);
                if (mext_month_obj !== false) {
                    alert_box.hide();
                    mext_month_obj.show().siblings("tbody").hide();
                    obj.find(".agenda_y").text(y);
                    obj.find(".agenda_m").text(parseInt(m));
                }
            }

            //获取数据值
            var get_vallist = function (data) {
                var str = ""
                for (i in options.display) {
                    str += "<label class='td_price'>￥" + data[options.display[i]] + "</label>";
                }
                return str;
            }

            //把数据写到对应的日期中
            var write_data = function (year, month, day, data) {
                var data_month = year.toString() + month.toString();
                var month_obj = obj.find("tbody[data-month='" + data_month + "']");
                if (month_obj.length == 0) {
                    month_obj = create_month(year, month);
                }
                if (month_obj === false) {
                    return;
                }
                var key = data_month + day.toString();
                var input = $("input[name='day_val[" + key + "]']");
                input.val(data.join(","));
                var td = input.parent();
                var close_btn = td.find(".vallist_del");
                if (close_btn.length == 0) {
                    close_btn = $('<img class="vallist_del" src="' + options.close_btn + '" alt="关闭">');
                    td.prepend(close_btn);
                }
                var dataval = td.find(".dataval");
                if (dataval.length == 0) {
                    dataval = $('<div class="dataval"></div>');
                    td.append(dataval);
                }
                var vallist = get_vallist(data);
                dataval.html(vallist);
            }
            //初始化
            var init = function () {
                if (typeof(options.data) == "string" && $.trim(options.data) != "") {
                    options.data = $.ajax({type: "GET", url: options.data, async: false}).responseText;
                    try {
                        options.data = jQuery.parseJSON(options.data);
                    } catch (ex) {
                        options.data = {};
                    }
                }
                var m = "";
                for (d in options.data) {
                    m = d.match(/^((?:19|20)\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])$/);
                    if (m) {
                        write_data(m[1], m[2], m[3], options.data[d]);
                    }
                }
                var dd = new Date();
                var y = dd.getFullYear();
                var m = dd.getMonth() + 1;
                var day = dd.getDate();
                this.find(".agenda_y").text(y);
                this.find(".agenda_m").text(m);
                this.find(".agenda_d").text(day);
                m = (m < 10) ? "0" + m.toString() : m.toString();
                var now_month = y.toString() + m;

                var now_month_obj = this.find("tbody[data-month='" + now_month + "']");
                if (now_month_obj.length == 0)now_month_obj = create_month(y, m);
                now_month_obj.show().siblings("tbody").hide();
            }
            init.call(obj);
            obj.find(".title_left").bind("click", prew_month);
            obj.find(".title_right").bind("click", next_month);
            $("td.day", obj[0]).live("click", td_click);
            $(".vallist_del", obj[0]).live("click", function (e) {
                $(this).siblings("input").val("");
                $(this).siblings("div").hide();
                $(this).hide();
                e.stopPropagation();
            })
        }
    });
})(jQuery)
