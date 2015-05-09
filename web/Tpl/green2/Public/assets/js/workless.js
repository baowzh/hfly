function currentScriptPath() {
    var scripts = document.getElementsByTagName("script");
    var script = scripts[ scripts.length - 1 ];
    var attrs = {
        src: script.getAttribute("src"),
        preload: script.getAttribute("preload")
    }

    return attrs;
}
var attrs = currentScriptPath();
var base_js_path = attrs.src.match(/[^?#]*\//)[0];
(function ($) {
   /* $.ajax({
        url: base_js_path + "jquery.cookie.js",
        cache: true,
        async: false,
        dataType: "script"
    });
    $.ajax({
        url: base_js_path + "jquery.md5.js",
        async: false,
        cache: true,
        dataType: "script"
    });*/

    $.extend({
        plugs_load: {},
        top_data: false,
        ifr_submit: false,
        lang_load: {},
        getCSS: function ($link) {
            var base_url = typeof arguments[1] != "string" ? base_js_path : arguments[1];
            var callback = typeof arguments[1] == "function" ? arguments[1] : arguments[2];
            if (typeof callback != "function") callback = function () {
            }
            var head = $("head")[0];
            var styleTag = document.createElement("link");
            styleTag.setAttribute('type', 'text/css');
            styleTag.setAttribute('rel', 'stylesheet');
            styleTag.setAttribute('href', base_url + $link);
            head.appendChild(styleTag);
            styleTag.onload = styleTag.onreadystatechange = function () {
                if (!styleTag.readyState || styleTag.readyState === "loaded" || styleTag.readyState === "complete") {
                    try {
                        callback.call(styleTag);
                    } catch (ex) {
                    }
                    styleTag.onload = styleTag.onreadystatechange = null;
                }
            };
        },
        preload: function () {
            var preload = attrs.preload;
            if (typeof preload != "string" || preload.length == 0) {
                return;
            }
            var preloads = preload.split(",");
            if ($.inArray("*", preloads) != -1) {
                $.top_p_load("bxslider", ["bxslider.js"], ["bxslider.css"]);
                $.top_p_load("eislideshow", ["easing.js", "eislideshow.js"], ["eislideshow.css"]);
                $.top_p_load("fancybox", ["fancybox.js"], ["fancybox.css"]);
                $.top_p_load("kindeditor", ["kindeditor-min.js", "lang/zh_CN.js"], ["themes/default/default.css"]);
                $.top_p_load("uploadify", ["uploadify.js"], ["uploadify.css"]);
                $.top_p_load("validform", ["validform.js", "datatype.extends.js"], ["validform.css"]);
                $.top_ui_load("custom", ["custom"], ["custom"]);
                $.top_lang_load("datepicker", "datepicker.zh-CN");
                return;
            }

        },
        init_uploadify: function (i) {
            var parent = $("<div id=\"file-upload-" + i + "\" class=\"file-upload\"></div>");
            $(this).before(parent);
            var clone_input = $(this).clone();
            clone_input.attr("id", "uploadify_" + clone_input.attr("id"));
            clone_input.attr("name", "uploadify_" + clone_input.attr("name"));
            clone_input.attr("type", "hidden");
            clone_input.removeClass("file-upload");
            parent.append(clone_input);
            var show_upload = $("<div class='show-upload'></div>");
            parent.append(show_upload);
            parent.append(this);
            var show_type = clone_input.attr("show-type") == "img" ? "img" : "text";
            $(this).p("uploadify", {
                uploader: $(this).attr("url") || "",
                formData: {data: $(this).attr("data") || ""},
                fileTypeExts: $(this).attr("exts") || "",
                removeTimeout: 1,
                onUploadSuccess: function (file, data, response) {
                    clone_input.val(data);
                    try {
                        data = $.parseJSON(data)
                    } catch (e) {
                    }
                    if (show_type == "img" && typeof data == "object" && $.inArray(data['ext'], ["jpg", "bmp", "png", "gif", "jpeg"]) != -1) {
                        var img = $("<a rel='fancybox_uploadify' id='img_" + file["id"] + "' href='" + data["file_path"] + "' title='" + data["names"] + "'><img  src='" + data["file_path"] + "'></a><div style='visibility:hidden'>" + data["file_path"] + "</div>");
                        show_upload.html(img);
                        $("#img_" + file["id"]).p("fancybox");
                        show_upload.addClass("show-img");
                    } else {
                        var path = data["file_path"] || data["names"] || "";
                        show_upload.removeClass("show-img");
                        show_upload.html("<div style='visibility:hidden'>" + path + "</div>");
                    }
                    show_upload._setTimeout = setTimeout(function () {
                        show_upload.children("div").css("visibility", "visible");
                    }, 1100);
                },
                onUploadStart: function () {
                    clearTimeout(show_upload._setTimeout);
                    show_upload.children("div").css("visibility", "hidden");
                },
                onInit: function () {
                    var init_val = clone_input.val() || "";
                    try {
                        init_val = $.parseJSON(init_val)
                    } catch (e) {
                    }
                    if (!init_val || typeof init_val != "object") {
                        return;
                    }
                    var path = init_val["file_path"] || init_val["names"] || "";
                    var ext = path.match(/[a-z]{3,4}$/i)[0];
                    if (show_type == "img" && $.inArray(ext, ["jpg", "bmp", "png", "gif", "jpeg"]) != -1) {
                        var img_id = init_val["id"] || 0;
                        var img = $("<a rel='fancybox_uploadify' id='img_" + img_id + "' href='" + path + "' title='" + init_val["names"] + "'><img  src='" + path + "'></a><div style='visibility:visible'>" + path + "</div>");
                        show_upload.html(img);
                        $("#img_" + img_id).p("fancybox");
                        show_upload.addClass("show-img");
                    } else {
                        show_upload.removeClass("show-img");
                        show_upload.html("<div style='visibility:visible'>" + path + "</div>");
                    }
                }

            });
        },
        init_validform: function (i) {
            var obj = this;
            $(this).find("[datatype]").bind({focusin: function () {
                this['_action'] = "focus";
                var validform_lastval = $(this)[0].validform_lastval;
                if ($(this).val() == validform_lastval)
                    $(this)[0].validform_lastval = validform_lastval + "!";
                $(this.form)[0].p_validform.check(false, this);
            }, focusout: function () {
                this['_action'] = "blur";
                var validform_lastval = $(this)[0].validform_lastval;
                if ($(this).val() == validform_lastval)
                    $(this)[0].validform_lastval = validform_lastval + "!";
                $(this.form)[0].p_validform.check(false, this);
            }});
            $(obj).p("validform", {
                label: $(obj).attr("data-label") || "em",
                ajaxPost: $(obj).attr("ajax") || false,
                tiptype: function (msg, o, cssctl) {
                    if (o.obj.is("form")) {
                        return;
                    }
                    var divbox;
                    var tipbox = o.obj.attr("tipbox");
                    if (tipbox) {
                        divbox = $(".Validform_tipbox[for='" + tipbox + "']");
                        if (divbox.length == 0) {
                            divbox = $("<div class='Validform_tipbox' for='" + tipbox + "'></div> ");
                            o.obj.after(divbox);
                        }
                    } else if (o.obj.parents("fieldset").length == 1) {
                        tipbox = o.obj.parents("fieldset").attr("tipbox");
                        if (tipbox) {
                            divbox = $(".Validform_tipbox[for='" + tipbox + "']");
                        } else {
                            tipbox = "tipbox_" + $.tipbox_num;
                            o.obj.parents("fieldset").attr(tipbox);
                            $.tipbox_num++;
                            divbox = o.obj.parents("fieldset").next(".Validform_tipbox[for='" + tipbox + "']");
                        }
                        if (divbox.length == 0) {
                            divbox = $("<div class='Validform_tipbox' for='" + tipbox + "'></div> ");
                            o.obj.parents("fieldset").after(divbox);
                        }
                    } else if (tipbox = o.obj.attr("id")) {
                        tipbox = o.obj.attr("id")
                        divbox = $(".Validform_tipbox[for='" + tipbox + "']");
                        if (divbox.length == 0) {
                            divbox = $("<div class='Validform_tipbox' for='" + tipbox + "'></div> ");
                            o.obj.after(divbox);
                        }
                    } else if (tipbox = o.obj.attr("name")) {
                        tipbox = tipbox.replace(/\[[^\[\]]*\]/, "");
                        divbox = $(".Validform_tipbox[for='" + tipbox + "']");
                        if (divbox.length == 0) {
                            divbox = $("<div class='Validform_tipbox' for='" + tipbox + "'></div> ");
                            o.obj.after(divbox);
                        }
                    } else {
                        o.obj.addClass("error");
                        o.obj.attr("disabled", true).val("请设置提示框的位置");
                        return;
                    }
                    var square = '<s class="s1">&#9670;<s class="s2">&#9670;</s></s>';
                    var msgbox = "<span>" + msg + "</span>";
                    divbox.removeClass("info success loading error").html("").append(square).append(msgbox);
                    o.obj.removeClass("info success error");
                    switch (o.type) {
                        case 1:
                            divbox.addClass("loading");
                            break;
                        case 2:
                            divbox.addClass("success");
                            o.obj.addClass("success");
                            break;
                        case 3:
                            if (o.obj[0]['_action'] == "focus") {
                                divbox.addClass("info");
                                o.obj.addClass("info");
                            } else {
                                divbox.addClass("error");
                                o.obj.addClass("error");
                            }
                            break;
                        case 4:
                            divbox.addClass("ignore");
                            break;
                    }
                },
                beforeCheck: function (curform) {
                    $("textarea.k-text", curform).each(function () {
                        $(this)[0].p_kindeditor.sync();
                    });
                },
                callback: function (data) {
                    $(obj).trigger("postAfter", [data]);
                }
            });
        },
        cache_url: function (key, value, options) {
            var location = self.location;
            var url = location.protocol + "//" + location.host + location
            var urlkey = $.md5(url);
            $.cookie(urlkey + "[" + key + "]", value, options);
        },
        load_url: function () {
            $.cache_url("aaaa", "bbbbb");
            var location = self.location;
            var url = location.protocol + "//" + location.host + location
            var urlkey = $.md5(url);
        },
        top_ui_load: function (ui_name, js_lists, css_lists) {
            if ($.plugs_load[ui_name] || typeof $.plugs_load['custom'] != "undefined") {
                return;
            }
            var js, css;
            for (js in js_lists) {
                $.ajax({
                    cache: true,
                    url: base_js_path + "plugs/ui/jquery.ui." + js_lists[js] + ".min.js",
                    async: false,
                    dataType: "script"
                });
            }
            for (css in css_lists) {
                $.getCSS("plugs/ui/jquery.ui." + css_lists[css] + ".min.css")
            }
            $.plugs_load[ui_name] = true;
            return;
        },
        top_p_load: function (plugName, js_lists, css_lists) {
            if ($.plugs_load[plugName]) {
                return;
            }
            var js, css;
            for (js in js_lists) {
                $.ajax({
                    url: base_js_path + "plugs/" + plugName + "/" + js_lists[js],
                    async: false,
                    cache: true,
                    dataType: "script"
                });
            }
            for (css in css_lists) {
                $.getCSS("plugs/" + plugName + "/" + css_lists[css])
            }
            $.plugs_load[plugName] = true;
            return;
        },
        top_lang_load: function (lang_name, js_name) {
            if ($.lang_load[lang_name]) {
                return;
            }
            $.ajax({
                url: base_js_path + "plugs/ui/lang/" + js_name + ".js",
                async: false,
                cache: true,
                dataType: "script"
            });
            $.lang_load[lang_name] = true;
        }
    });
    $.fn.extend({
        p: function (plugName, option) {
            var plugs = ["bxslider", "eislideshow", "fancybox", "kindeditor", "uploadify", "validform",
                "ui_accordion", "ui_autocomplete", "ui_button", "ui_datepicker",
                "ui_dialog", "ui_draggable", "ui_droppable", "ui_effect",
                "ui_effect_blind", "ui_effect_bounce", "ui_effect_clip", "ui_effect_drop",
                "ui_effect_explode", "ui_effect_fade", "ui_effect_fold", "ui_effect_highlight",
                "ui_effect_pulsate", "ui_effect_scale", "ui_effect_shake", "ui_effect_slide",
                "ui_effect_transfer", "ui_menu", "ui_mouse", "ui_position", "ui_progressbar",
                "ui_resizable", "ui_selectable", "ui_slider", "ui_sortable", "ui_spinner",
                "ui_tabs", "ui_tooltip", "ui_widget", "ui_alert", "ui_confirm", "ui_open", "ui_con_win", "ui_ajax_win"
            ];
            if ($.inArray(plugName, plugs) == -1) {
                return false;
            }
            var fn = {};
            fn["bxslider"] = function (option) {
                $.top_p_load("bxslider", ["bxslider.js"], ["bxslider.css"]);
                var defaults = {auto: true, autoStart: true};
                var options = $.extend(defaults, option);
                this.p_bxslider = $(this).bxSlider(options);
            };
            fn["eislideshow"] = function (option) {
                $.top_p_load("eislideshow", ["easing.js", "eislideshow.js"], ["eislideshow.css"]);
                var defaults = {easing: "easeOutExpo", titleeasing: "easeOutExpo", titlespeed: 1200};
                var options = $.extend(defaults, option);
                this.p_eislideshow = $(this).eislideshow(options);
            }
            fn["fancybox"] = function (option) {
                $.top_p_load("fancybox", ["fancybox.js"], ["fancybox.css"]);
                var defaults = {'transitionIn': 'none',
                    'transitionOut': 'none',
                    'titlePosition': 'over'
                };
                var options = $.extend(defaults, option);
                this.p_fancybox = $(this).fancybox(options);
            }
            fn["kindeditor"] = function (option) {
                $.top_p_load("kindeditor", ["kindeditor-min.js", "lang/zh_CN.js"], ["themes/default/default.css"]);
                var kind_options = $.kind_options || {};
                var defaults = {
                    basePath: base_js_path + "plugs/kindeditor/",
                    afterFocus: function () {
                        $(this.srcElement).trigger("focus");
                    },
                    afterBlur: function () {
                        this.sync();
                        $(this.srcElement).trigger("blur");
                    }
                }
                defaults = $.extend(defaults, kind_options);
                var options = $.extend(defaults, option);
                this.p_kindeditor = KindEditor.create(this, options);
            }
            fn["uploadify"] = function (option) {
                $.top_p_load("uploadify", ["uploadify.js"], ["uploadify.css"]);
                var defaults = {
                    'formData': {},
                    'auto': true,
                    'multi': false,
                    'buttonText': '浏览文件',
                    'width': '80',
                    'height': '28',
                    'swf': base_js_path + "plugs/uploadify/uploadify.swf",
                    'uploader': "",
                    'cancelImg': base_js_path + "plugs/uploadify/cancel.png",
                    'queueSizeLimit': 1
                };
                var options = $.extend(defaults, option);
                this.p_uploadify = $(this).uploadify(options);
            }
            fn["validform"] = function (option) {
                $.top_p_load("validform", ["validform.js", "datatype.extends.js"], ["validform.css"]);
                var defaults = {tiptype: 2};
                var options = $.extend(defaults, option);
                this.p_validform = $(this).Validform(options);
            }
            fn["ui_accordion"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_accordion", ["accordion"]);
                var defaults = {};
                var options = $.extend(defaults, option);
                this.ui_accordion = $(this).accordion(options);
            }
            fn["ui_autocomplete"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_position", ["position"], []);
                $.top_ui_load("ui_menu", ["menu"], []);
                $.top_ui_load("ui_autocomplete", ["autocomplete"]);
                var defaults = {};
                var options = $.extend(defaults, option);
                this.ui_autocomplete = $(this).autocomplete(options);
            }
            fn["ui_datepicker"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_datepicker", ["datepicker"]);
                $.top_lang_load("datepicker", "datepicker.zh-CN");
                var defaults = {
                    changeMonth: true,
                    changeYear: true
                };
                var options = $.extend(defaults, option);
                this.ui_autocomplete = $(this).datepicker(options);
            }
            fn["ui_dialog"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_mouse", ["mouse"], []);
                $.top_ui_load("ui_draggable", ["draggable"], []);
                $.top_ui_load("ui_position", ["position"], []);
                $.top_ui_load("ui_resizable", ["resizable"], []);
                $.top_ui_load("ui_button", ["button"], []);
                $.top_ui_load("ui_dialog", ["dialog"]);
                var defaults = {autoOpen: false};
                var options = $.extend(defaults, option);
                this.ui_dialog = $(this).dialog(options);
            }
            fn["ui_draggable"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_mouse", ["mouse"], []);
                $.top_ui_load("ui_draggable", ["draggable"], []);
                var defaults = {};
                var options = $.extend(defaults, option);
                this.ui_draggable = $(this).draggable(options);
            }
            fn["ui_droppable"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_mouse", ["mouse"], []);
                $.top_ui_load("ui_draggable", ["draggable"], []);
                $.top_ui_load("ui_droppable", ["droppable"], []);
                var defaults = {
                    drop: function (event, ui) {
                        $(this).addClass("ui-state-highlight").find("p").html("Dropped!");
                    }
                };
                var options = $.extend(defaults, option);
                this.ui_droppable = $(this).droppable(options);
            }
            fn["ui_menu"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_position", ["position"], []);
                $.top_ui_load("ui_menu", ["menu"], []);
                var defaults = {};
                var options = $.extend(defaults, option);
                this.ui_menu = $(this).menu(options);
            }
            fn["ui_progressbar"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_progressbar", ["progressbar"], []);
                var defaults = {};
                var options = $.extend(defaults, option);
                this.ui_progressbar = $(this).progressbar(options);
            }
            fn["ui_sortable"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_mouse", ["mouse"], []);
                $.top_ui_load("ui_sortable", ["sortable"], []);
                var defaults = {};
                var options = $.extend(defaults, option);
                this.ui_sortable = $(this).sortable(options);
            }
            fn["ui_slider"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_mouse", ["mouse"], []);
                $.top_ui_load("ui_slider", ["slider"], []);
                var defaults = {};
                var options = $.extend(defaults, option);
                this.ui_slider = $(this).slider(options);
            }
            fn["ui_tabs"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_mouse", ["mouse"], []);
                $.top_ui_load("ui_tabs", ["tabs"], []);
                var defaults = {};
                var options = $.extend(defaults, option);
                this.ui_tabs = $(this).tabs(options);
            }
            fn["ui_tooltip"] = function (option) {
                $.top_ui_load("ui_core", ["core"], ["custom"]);
                $.top_ui_load("ui_widget", ["widget"], []);
                $.top_ui_load("ui_mouse", ["mouse"], []);
                $.top_ui_load("ui_position", ["position"], []);
                $.top_ui_load("ui_tooltip", ["tooltip"], []);
                var defaults = {};
                var options = $.extend(defaults, option);
                this.ui_tooltip = $(this).tooltip(options);
            }
            fn["ui_alert"] = function (option) {
                var defaults = {
                    title: option["title"] || $(this).attr("title") || "alert title",
                    autoOpen: true,
                    modal: true,
                    buttons: [
                        {text: option["ok"] || "确定", click: function () {
                            if (typeof option["okFn"] === "function") {
                                option["okFn"].call(this);
                            }
                            window.top.$(this).dialog("close");
                        }}
                    ]
                }
                if (window.top.$(".ui-alert-dialog").length == 0) {
                    window.top.$("body").append($("<div class='ui-alert-dialog' style='display:none'></div>"))
                }
                window.top.$(".ui-alert-dialog").html(option["content"] || $(this).attr("content") || "是否确认");
                window.top.$(".ui-alert-dialog").p("ui_dialog", defaults);
                return false;
            }
            fn["ui_confirm"] = function (option) {
                var defaults = {
                    title: option["title"] || $(this).attr("title") || "confirm title",
                    autoOpen: true,
                    modal: true,
                    buttons: [
                        {text: option["ok"] || "确定", click: function () {
                            if (typeof option["okFn"] === "function") {
                                option["okFn"].call();
                            }
                            window.top.$(this).dialog("close");
                        }},
                        {text: option["cancel"] || "取消", click: function () {
                            if (typeof option["cancelFn"] === "function") {
                                option["cancelFn"].call();
                            }
                            window.top.$(this).dialog("close");
                        }}
                    ]
                }
                if (window.top.$(".ui-confirm-dialog").length == 0) {
                    window.top.$("body").append($("<div class='ui-confirm-dialog' style='display: none;' ></div>"))
                }
                window.top.$(".ui-confirm-dialog").html(option["content"] || $(this).attr("content") || "是否确认");
                window.top.$(".ui-confirm-dialog").p("ui_dialog", defaults);
                return false;
            }
            fn["ui_open"] = function (option) {
                if (window.top.$(".ui-open-dialog").length == 0) {
                    window.top.$("body").append($("<div class='ui-open-dialog' style='display: none;'><iframe name='ui-open-dialog'></iframe></div>"))
                }
                window.top.$("iframe[name='ui-open-dialog']").attr("src", option["url"] || $(this).attr("url") || $(this).attr("href")).load(function () {
                    $(this).height(0).width(0);
                    var iframe_height = $(this).contents().height();
                    var iframe_width = $(this).contents().width();
                    var width = iframe_width < 500 ? 500 : iframe_width;
                    var height = iframe_height < 300 ? 300 : iframe_height;
                    $(this).width(width + 10).height(height + 10);
                    var defaults = {
                        title: option["title"] || $(this).attr("title") || "dialog open title",
                        autoOpen: true,
                        modal: true,
                        width: "auto",
                        height: "auto",
                        buttons: [
                            {text: option["ok"] || "确定", click: function () {
                                if (typeof option["okFn"] === "function") {
                                    option["okFn"].call();
                                }
                                if (option["autosubmit"]) {
                                    var form = window.top.$("iframe[name='ui-open-dialog']").contents().find("form");
                                    if (form.length > 0) {
                                        form.eq(0).trigger("submit");
                                        if (!window.top.$.ifr_submit) {
                                            return false;
                                        }
                                    }
                                }
                                window.top.$(this).dialog("close");
                            }},
                            {text: option["cancel"] || "取消", click: function () {
                                if (typeof option["cancelFn"] === "function") {
                                    option["cancelFn"].call();
                                }
                                window.top.$(this).dialog("close");
                            }}
                        ]
                    }
                    window.top.$.ifr_submit = false;
                    window.top.$(".ui-open-dialog").p("ui_dialog", defaults);
                });
                return false;
            }
            fn["ui_con_win"] = function (option) {
                if (window.top.$(".ui-con-dialog").length == 0) {
                    window.top.$("body").append($("<div class='ui-con-dialog' style='display: none;'></div>"));
                }
                var defaults = {
                    title: option["title"] || $(this).attr("title") || "dialog open title",
                    autoOpen: true,
                    modal: true,
                    width: "auto",
                    height: "auto",
                    buttons: [
                        {text: option["ok"] || "确定", click: function () {
                            if (typeof option["okFn"] === "function") {
                                option["okFn"].call();
                            }
                            if (option["autosubmit"]) {
                                var form = window.top.$(".ui-con-dialog form");
                                if (form.length > 0) {
                                    form.eq(0).trigger("submit");
                                    if (!window.top.$.ifr_submit) {
                                        return false;
                                    }
                                }
                            }
                            window.top.$(this).dialog("close");
                        }},
                        {text: option["cancel"] || "取消", click: function () {
                            if (typeof option["cancelFn"] === "function") {
                                option["cancelFn"].call();
                            }
                            window.top.$(this).dialog("close");
                        }}
                    ]
                }
                window.top.$.ifr_submit = false;
                window.top.$(".ui-con-dialog").html(option["content"]).p("ui_dialog", defaults);
            }
            fn["ui_ajax_win"] = function () {
                if (window.top.$(".ui-ajax-dialog").length == 0) {
                    window.top.$("body").append($("<div class='ui-ajax-dialog' style='display: none;'></div>"));
                }
                var defaults = {
                    title: option["title"] || $(this).attr("title") || "dialog open title",
                    autoOpen: true,
                    modal: true,
                    width: "auto",
                    height: "auto",
                    buttons: [
                        {text: option["ok"] || "确定", click: function () {
                            if (typeof option["okFn"] === "function") {
                                option["okFn"].call();
                            }
                            if (option["autosubmit"]) {
                                var form = window.top.$(".ui-ajax-dialog form");
                                if (form.length > 0) {
                                    form.eq(0).trigger("submit");
                                    if (!window.top.$.ifr_submit) {
                                        return false;
                                    }
                                }
                            }
                            window.top.$(this).dialog("close");
                        }},
                        {text: option["cancel"] || "取消", click: function () {
                            if (typeof option["cancelFn"] === "function") {
                                option["cancelFn"].call();
                            }
                            window.top.$(this).dialog("close");
                        }}
                    ]
                }
                window.top.$.ifr_submit = false;
                var content = $.ajax({url: option["url"], type: option["type"], data: option["data"], async: false}).responseText;
                window.top.$(".ui-ajax-dialog").html(content).p("ui_dialog", defaults);
            }
            return this.each(function () {
                var o = option;
                fn[plugName].call(this, o);
            });
        }
    })
    $.preload();
})(jQuery);
$(function () {
    $(".ui-menu").p("ui_menu");
    $("#sortable").p("ui_sortable");
    $("#slider").p("ui_slider");
    $(".eislideshow").p("eislideshow");
    $(".ui-tabs").each(function () {
        var current = $(this).attr("data-current") || 0;
        $(this).p("ui_tabs", { active: current});
    });
    $(".ui-date").p("ui_datepicker");
    $(".ui-alert").click(function () {
        var href = $(this).attr("href");
        var self_win = window;
        $(this).p("ui_alert", {okFn: function () {
            self_win.location = href;
        }});
        return false;
    });
    $(".ui-confirm").click(function () {
        var href = $(this).attr("href");
        var self_win = window;
        $(this).p("ui_confirm", {okFn: function () {
            self_win.location = href;
        }});
        return false;
    });
    $(".ui-open").click(function () {
        var href = $(this).attr("href");
        var self_win = window;
        $(this).p("ui_open", {autosubmit: true, url: href});
        return false;
    });
    $(".ui-con-win").click(function () {
        var href = $(this).attr("href");
        var content = $(href).html();
        var self_win = window;
        $(this).p("ui_con_win", {autosubmit: true, content: content});
        return false;
    })
    $(".ui-ajax-win").click(function () {
        var href = $(this).attr("href");
        var type = $(this).attr("type") || "get";
        var data = $(this).attr("data") || "";
        $(this).p("ui_ajax_win", {autosubmit: true, url: href, type: type, data: data});
        return false;
    });
    $("a[rel]").p("fancybox");
    $("textarea.k-text").p("kindeditor");
    $("input.file-upload").each(function (i) {
        $.init_uploadify.call(this, i);
    });
    $("form.check-form").each(function (i) {
        $.init_validform.call(this, i);
    });
    $(".bxslider").p("bxslider", {pager: false});
})