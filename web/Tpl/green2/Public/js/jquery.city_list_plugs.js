(function ($) {
    $.fn.extend({
        city_list_plugs: function (option) {
            var defaults = {
                for_name: "cid"
            }
            var options = $.extend(defaults, option);
            var get_data = function () {
                var html = $.ajax({
                    url: options.url,
                    async: false    //同步加载
                }).responseText;
                try {
                    html = $.parseJSON(html);
                } catch (e) {
                    html = {}
                }
                options.data = html;
                return html;
            }
            var focus_fn = function () {
                var data = options.data || get_data();
                var forid = $(this).attr("id");
                var for_id = $(this).attr("for-val");
                var tooltip = $("ul.city-tooltip[for='" + forid + "']");
                var for_val = $("input#" + for_id);
                var this_val = $(this).val();
                if (tooltip.length == 0) {
                    tooltip = $("<ul class='city-tooltip' for='" + forid + "'></ul>");
                    var html = '';
                    var spell = ''
                    for (var i in data) {
                        spell = data[i]['names_en'].replace(/[a-z]/g, "").toLowerCase()
                        html += "<li data-val='" + i + "' data-spell='" + spell + "' data-whole='" + data[i]['names_en'].toLowerCase() + "'>" + data[i]['names'] + "</li>"
                    }
                    tooltip.html(html);
                    $(this).after(tooltip);
                    var offset = $(this).offset();
                    var width = $(this).outerWidth();
                    var height = $(this).outerHeight();
                    tooltip.offset({left: offset.left, top: offset.top + height});
                    tooltip.width(width);
                    tooltip.find("li").bind({
                        mouseover: function () {
                            $(this).addClass("selected").siblings("li").removeClass("selected")
                        },
                        click: function () {
                            var for_id = $(this).parent("ul").attr("for");
                            $("#" + for_id).trigger("keyup");
                        }
                    })
                }
                if (for_val.length == 0) {
                    for_val = $("<input type='hidden' name='" + options.for_name + "' id='" + for_id + "'>");
                    $(this).after(for_val);
                }
                if (this_val.match(/^[a-zA-Z]+$/)) {
                    var tooltip_lists = tooltip.find("li[data-spell*='" + this_val.toLowerCase() + "'],li[data-whole*='" + this_val.toLowerCase() + "']");
                } else if (this_val.match(/^.+$/)) {
                    var tooltip_lists = tooltip.find("li:contains('" + this_val + "')");
                } else {
                    var tooltip_lists = tooltip.find("li");
                }
                tooltip.find("li").hide();
                tooltip_lists.show();
            }
            var click_fn = function () {
                $(this).trigger("focus");
            }
            var blur_fn = function () {
                $(this).trigger("keyup");
            }
            var keydown_fn = function (e) {
                var key = (e.keyCode) || (e.which) || (e.charCode);
                if (key == 13) {
                    return false;
                }
            }
            var keyup_fn = function (e) {
                e.keyCode = e.isTrigger ? 13 : e.keyCode;
                var key = (e.keyCode) || (e.which) || (e.charCode);//兼容IE(e.keyCode)和Firefox(e.which)
                var forid = $(this).attr("id");
                var tooltip = $("ul.city-tooltip[for='" + forid + "']");
                var for_id = $(this).attr("for-val");
                var for_val = $("input#" + for_id);
                switch (key) {
                    case 13:
                        var select_dom = tooltip.find("li.selected")
                        if (select_dom.length == 0) {
                            var this_val = $(this).val();
                            if (this_val.match(/^[a-zA-Z]+$/)) {
                                var tooltip_lists = tooltip.find("li[data-spell*='" + this_val.toLowerCase() + "'],li[data-whole*='" + this_val.toLowerCase() + "']");
                                tooltip_lists.each(function () {
                                    if(this_val==$(this).attr("data-spell")){
                                        select_dom=$(this);
                                        return false;
                                    }
                                });
                            } else if (this_val.match(/^.+$/)) {
                                var tooltip_lists = tooltip.find("li:contains('" + this_val + "')");
                                tooltip_lists.each(function () {
                                    if(this_val==$(this).text()){
                                        select_dom=$(this);
                                        return false;
                                    }
                                });
                            } else {
                                var tooltip_lists = tooltip.find("li");
                            }
                            select_dom = tooltip.find("li:visible").first();
                        }
                        if(select_dom.length == 0){
                            select_dom=tooltip_lists.first();
                        }
                        if (select_dom.length == 0) {
                            select_dom = tooltip.find("li").first()
                        }
                        $(this).val(select_dom.text());
                        for_val.val(select_dom.attr("data-val"));
                        tooltip.hide();
                        tooltip.find('li:hidden').removeClass("selected");
                        return false;
                    case 38:
                        tooltip.find('li:hidden').removeClass("selected");
                        var visible_lists = tooltip.find('li:visible');
                        if (visible_lists.length == 0) {
                            return false;
                        }
                        var select_dom = tooltip.find("li.selected")
                        if(select_dom.length > 0){
                            var index = visible_lists.index(select_dom);
                            index = index - 1 < 0 ? 0 : index - 1;
                            visible_lists.removeClass("selected").eq(index).addClass("selected");
                        }else{
                            visible_lists.removeClass("selected").last().addClass("selected");
                        }
                        break;
                    case 40:
                        tooltip.find('li:hidden').removeClass("selected");
                        var visible_lists = tooltip.find('li:visible');
                        if (visible_lists.length == 0) {
                            return false;
                        }
                        var select_dom = tooltip.find("li.selected")
                        if(select_dom.length > 0){
                            var index = visible_lists.index(select_dom);
                            index = index + 1 >= visible_lists.length ? visible_lists.length - 1 : index + 1;
                            visible_lists.removeClass("selected").eq(index).addClass("selected");
                        }else{
                            visible_lists.removeClass("selected").first().addClass("selected");
                        }
                        break;
                    default:
                        var this_val = $(this).val();
                        if (this_val.match(/^[a-zA-Z]+$/)) {
                            var tooltip_lists = tooltip.find("li[data-spell*='" + this_val.toLowerCase() + "'],li[data-whole*='" + this_val.toLowerCase() + "']");
                        } else if (this_val.match(/^.+$/)) {
                            var tooltip_lists = tooltip.find("li:contains('" + this_val + "')");
                        } else {
                            var tooltip_lists = tooltip.find("li");
                        }
                        tooltip.show().find("li").hide();
                        tooltip.find('li:hidden').removeClass("selected");
                        tooltip_lists.show();
                }

            }
            return this.each(function () {
                options.url = options.url || $(this).attr("url");
                $(this).attr("autocomplete","off");
                if (!$(this).attr("id")) {
                    $(this).attr("id", "tooltip" + new Date().getTime());
                }
                if (!$(this).attr("for-val")) {
                    $(this).attr("for-val", "for" + new Date().getTime());
                }
                $(this).bind({focus: focus_fn, blur: blur_fn, keydown: keydown_fn, keyup: keyup_fn, click: click_fn});
            });
        }
    });
})(jQuery)