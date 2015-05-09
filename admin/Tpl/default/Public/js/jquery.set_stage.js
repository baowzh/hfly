(function ($) {
    $.fn.extend({
        set_stage: function (options) {
            var defaults = {
                data: "",
                data_html: ""
            }
            var obj = this;
            var options = $.extend(defaults, options);
            var index = 0;

            var add_stage = function () {
                var html = options.data_html.replace(/\{\=id\=\}/g, "tmp_" + index);
                html = html.replace(/\{\=\w+\=\}/g, "");
                var stage_obj = obj.find("#body_" + index);
                if (stage_obj.length == 0) {
                    stage_obj = $(html);
                    obj.append(stage_obj);
                    obj.find("input.calender").create_calender();
                }
                index++;
            }

            /*
             * "",
             function () {
             $("input:checkbox:checked").parents("tbody").empty();
             },
             function(){}*/
            var del_stage = function () {
                if ($("input:checkbox:checked").length == 0) {
                    art.dialog.alert('请选择您要删除的阶段价格！');
                    return false;
                }
                art.dialog.through({
                    content: "确认删除已选中的阶段（注，一旦删除，将无法恢复）？",
                    ok: function () {
                        $("input:checkbox:checked").parents("tbody").empty();
                    },
                    cancel: function () {
                    },
                    close: function () {
                    }
                });

                return false;
            }

            var format_date = function (date) {
                var dd = new Date(parseInt(date) * 1000);
                var m = dd.getMonth();
                m = m < 10 ? "0" + m : m;
                var d = dd.getDate();
                d = d < 10 ? "0" + d : d;
                return dd.getFullYear() + "-" + m + "-" + d;
            }

            var init = function () {
                if (!options.data)return;
                try {
                    var init_data = typeof(options.data) == "object" ? options.data : $.parseJSON(options.data);
                } catch (e) {
                    return;
                }
                var html = "";
                var stage_obj;
                for (k in init_data) {
                    html = options.data_html.replace(/\{\=id\=\}/g, init_data[k]["id"]);
                    html = html.replace(/\{\=price_date_start\=\}/g, format_date(init_data[k]["price_date"]));
                    html = html.replace(/\{\=price_date_end\=\}/g, format_date(init_data[k]["price_date_end"]));
                    html = html.replace(/\{\=RACKRATE\=\}/g, init_data[k]["RACKRATE"]);
                    html = html.replace(/\{\=price_adult\=\}/g, init_data[k]["price_adult"]);
                    html = html.replace(/\{\=price_children\=\}/g, init_data[k]["price_children"]);
                    stage_obj = obj.find("#body_" + init_data[k]["id"]);
                    if (stage_obj.length == 0) {
                        stage_obj = $(html);
                        obj.append(stage_obj);
                        obj.find("input.calender").create_calender();
                    }
                }

            }
            $(".add_stage", this).bind("click", add_stage);
            $(".del_stage", this).bind("click", del_stage);
            init();
        }
    })
})(jQuery)


