(function () {
    if ($.Datatype) {
        $.extend($.Tipmsg, {
            w: {
                "*": "不能为空！",
                "*6-16": "请填写6到16位任意字符！",
                "n": "请填写数字！",
                "n6-16": "请填写6到16位数字！",
                "s": "不能输入特殊字符！",
                "s6-18": "请填写6到18位字符，不能输入特殊字符！",
                "p": "请填写邮政编码！",
                "m": "请填写手机号码！",
                "e": "邮箱地址格式不对！",
                "url": "请填写网址！",
                "date": "请填写日期！",
                "zh": "请填写中文！",
                "dword": "请填写双字节字符！",
                "money": "请填写货币值！",
                "ipv4": "请填写ip地址！",
                "ipv6": "请填写IPv6地址！",
                "num": "请填写数值！",
                "qq": "请填写QQ号码！",
                "unequal": "值不能相等！",
                "notvalued": "不能含有特定值！",
                "idcard": "身份证号码不对！",
                "en": "只允许英文，数字，下划线"
            },
            def: "输入错误！",
            r: "输入正确！",
            reck: "两次输入的内容不一致！",
            c: "正在验证…",
            s: "请{输入|选择}{0|！}"
        });

        $.extend($.Datatype, {
            /*
             reference http://blog.csdn.net/lxcnn/article/details/4362500;

             日期格式可以是：20120102 / 2012.01.02 / 2012/01/02 / 2012-01-02
             时间格式可以是：10:01:10 / 02:10
             如 2012-01-02 02:10
             2012-01-02
             */
            "date": /^(?:(?:1[6-9]|[2-9][0-9])[0-9]{2}([-/.]?)(?:(?:0?[1-9]|1[0-2])\1(?:0?[1-9]|1[0-9]|2[0-8])|(?:0?[13-9]|1[0-2])\1(?:29|30)|(?:0?[13578]|1[02])\1(?:31))|(?:(?:1[6-9]|[2-9][0-9])(?:0[48]|[2468][048]|[13579][26])|(?:16|[2468][048]|[3579][26])00)([-/.]?)0?2\2(?:29))(\s+([01][0-9]:|2[0-3]:)?[0-5][0-9]:[0-5][0-9])?$/,

            //匹配中文字符;
            "zh": /^[\u4e00-\u9fa5]+$/,

            //匹配双字节字符;
            "dword": /^[^\x00-\xff]+$/,

            //货币类型;
            "money": /^([\u0024\u00A2\u00A3\u00A4\u20AC\u00A5\u20B1\20B9\uFFE5]\s*)(\d+,?)+\.?\d*\s*$/,

            //匹配ipv4地址;
            "ipv4": /^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$/,

            /*
             匹配ipv6地址;
             reference http://forums.intermapper.com/viewtopic.php?t=452;
             */
            "ipv6": /^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/,


            //数值型;
            "num": /^(\d+[\s,]*)+\.?\d*$/,


            //QQ号码;
            "qq": /^[1-9][0-9]{4,}$/,
            "en": /^[A-Za-z0-9_]{1,}$/,


            /*
             参数gets是获取到的表单元素值，
             obj为当前表单元素，
             curform为当前验证的表单，
             datatype为内置的一些正则表达式的引用。
             */
            "unequal": function (gets, obj, curform, datatype) {
                /*
                 当前值不能与指定表单元素的值一样，如新密码不能与旧密码一样，密码不能设置为用户名等
                 注意需要通过绑定with属性来指定要比较的表单元素，可以是clas，id或者是name属性值

                 eg.  <input type="text" name="name" id="name" class="name" />
                 eg1. <input type="text" name="test" datatype="unequal" with="name" />
                 eg2. <input type="text" name="test" datatype="unequal" with=".name" />
                 eg3. <input type="text" name="test" datatype="unequal" with="#name" />

                 也可以用来验证不能与with指定的值相等
                 当上面根据class，id和name都查找不到对象时，会直接跟with的值比较
                 eg4. <input type="text" name="test" datatype="num unequal" with="100" />
                 该文本框的值不能等于100
                 */
                var withele = $.trim(obj.attr("with"));
                var val = curform.find(withele + ",[name='" + withele + "']").val() || withele;

                if (gets == $.trim(val)) {
                    return false;
                }
            },


            "notvalued": function (gets, obj, curform, datatype) {
                /*
                 当前文本框的值不能含有指定文本框的值，如注册时设置的密码里不能包含用户名
                 注意需要给表单元素绑定with属性来指定要比较的表单元素，可以是clas，id或者是name属性值
                 <input type="text" name="username" id="name" class="name" />
                 eg. <input type="password" name="test" datatype="notvalued" with=".name" />

                 也可以用来验证不能包含with指定的值
                 当上面根据class，id和name都查找不到对象时，会直接跟with的值比较
                 eg2. <input type="password" name="test" datatype="notvalued" with="validform" />
                 要求不能含有"validform"字符
                 */
                var withele = $.trim(obj.attr("with"));
                var val = curform.find(withele + ",[name='" + withele + "']").val() || withele;

                if (gets.indexOf($.trim(val)) != -1) {
                    return false;
                }
            },


            "min": function (gets, obj, curform, datatype) {
                /*
                 checkbox最少选择n项
                 注意需要给表单元素绑定min属性来指定是至少需要选择几项，没有绑定的话使用默认值
                 eg. <input type="checkbox" name="test" datatype="min" min="3" />
                 */
                var names = obj.attr("name").replace(/([\[\]])/g, "\\$1");

                var minim = ~~obj.attr("min") || 2,
                    numselected = curform.find("input[name='" + names + "']:checked").length;
                return  numselected >= minim ? true : "请至少选择" + minim + "项！";
            },


            "max": function (gets, obj, curform, datatype) {
                /*
                 checkbox最多选择n项
                 注意需要给表单元素绑定max属性来指定是最多需要选择几项，没有绑定的话使用默认值
                 eg. <input type="checkbox" name="test" datatype="max" max="3" />
                 */
                var names = obj.attr("name").replace(/([\[\]])/g, "\\$1");
                var atmax = ~~obj.attr("max") || 2,
                    numselected = curform.find("input[name='" + names + "']:checked").length;

                if (numselected == 0) {
                    return false;
                } else if (numselected > atmax) {
                    return "最多只能选择" + atmax + "项！";
                }
                return  true;
            },

            "agree": function (gets, obj, curform, datatype) {
                return obj.attr("checked") ? true : false;
            },


            "byterange": function (gets, obj, curform, datatype) {
                /*
                 判断字符长度，中文算两个字符
                 注意需要给表单元素绑定max,min属性来指定最大或最小允许的字符长度，没有绑定的话使用默认值
                 */
                var dregx = /[^\x00-\xff]/g;
                var maxim = ~~obj.attr("max") || 100000000,
                    minim = ~~obj.attr("min") || 0;

                getslen = gets.replace(dregx, "00").length;

                if (getslen > maxim) {
                    return "输入字符不能多于" + maxim + "个，中文算两个字符！";
                }

                if (getslen < minim) {
                    return "输入字符不能少于" + minim + "个，中文算两个字符！";
                }

                return true;
            },
            "lt": function (gets, obj, curform, datatype) {

                var min_val = gets;
                var max_id = $(obj).attr("lt");
                var max_val = $(max_id).val();
                if (!max_val) {
                    return true;
                }
                if (/\d{4}[\/\-\.,]\d{2}[\/\-\.,]\d{2}/.test(gets)) {
                    min_val = Date.parse(min_val);
                    max_val = Date.parse(max_val);
                }

                if (min_val < max_val) {
                    //  $(max_id).trigger("blur");
                    $(max_id).hasClass("Validform_error") && $(max_id).removeClass("Validform_error");
                    return true;
                }
                $(max_id).hasClass("Validform_error") || $(max_id).addClass("Validform_error");
                return false;

            },
            "gt": function (gets, obj, curform, datatype) {
                var max_val = gets;
                var min_id = $(obj).attr("gt");
                var min_val = $(min_id).val();
                if (!min_val) {
                    return true;
                }
                if (/\d{4}[\/\-\.,]\d{2}[\/\-\.,]\d{2}/.test(gets)) {
                    min_val = Date.parse(min_val);
                    max_val = Date.parse(max_val);
                }
                if (min_val < max_val) {
                    // $(min_id).trigger("blur");
                    $(min_id).hasClass("Validform_error") && $(min_id).removeClass("Validform_error");
                    return true;
                }
                $(min_id).hasClass("Validform_error") || $(min_id).addClass("Validform_error");
                return false;

            },
            "elt": function (gets, obj, curform, datatype) {

                var min_val = gets;
                var max_id = $(obj).attr("elt");
                var max_val = $(max_id).val();
                if (!max_val) {
                    return true;
                }
                if (/\d{4}[\/\-\.,]\d{2}[\/\-\.,]\d{2}/.test(gets)) {
                    min_val = Date.parse(min_val);
                    max_val = Date.parse(max_val);
                }

                if (min_val <= max_val) {
                    //  $(max_id).trigger("blur");
                    $(max_id).hasClass("Validform_error") && $(max_id).removeClass("Validform_error");
                    return true;
                }
                $(max_id).hasClass("Validform_error") || $(max_id).addClass("Validform_error");
                return false;

            },
            "egt": function (gets, obj, curform, datatype) {
                var max_val = gets;
                var min_id = $(obj).attr("egt");
                var min_val = $(min_id).val();
                if (!min_val) {
                    return true;
                }
                if (/\d{4}[\/\-\.,]\d{2}[\/\-\.,]\d{2}/.test(gets)) {
                    min_val = Date.parse(min_val);
                    max_val = Date.parse(max_val);
                }
                if (min_val <= max_val) {
                    // $(min_id).trigger("blur");
                    $(min_id).hasClass("Validform_error") && $(min_id).removeClass("Validform_error");
                    return true;
                }
                $(min_id).hasClass("Validform_error") || $(min_id).addClass("Validform_error");
                return false;

            },


            "numrange": function (gets, obj, curform, datatype) {
                /*
                 判断数值范围
                 注意需要给表单元素绑定max,min属性来指定最大或最小可输入的值，没有绑定的话使用默认值
                 */

                var maxim = ~~obj.attr("max") || 100000000,
                    minim = ~~obj.attr("min") || 0;

                gets = gets.replace(/\s*/g, "").replace(/,/g, "");
                if (!/^\d+\.?\d*$/.test(gets)) {
                    return "只能输入数字！";
                }

                if (gets < minim) {
                    return "值不能小于" + minim + "！";
                } else if (gets > maxim) {
                    return "值不能大于" + maxim + "！";
                }
                return  true;
            },
            "daterange": function (gets, obj, curform, datatype) {
                /*
                 判断日期范围
                 注意需要给表单元素绑定max或min属性，或两个同时绑定来指定最大或最小可输入的日期
                 日期格式：2012/12/29 或 2012-12-29 或 2012.12.29 或 2012,12,29
                 */
                var maxim = new Date(obj.attr("max").replace(/[-\.,]/g, "/")),
                    minim = new Date(obj.attr("min").replace(/[-\.,]/g, "/")),
                    gets = new Date(gets.replace(/[-\.,]/g, "/"));

                if (!gets.getDate()) {
                    return "日期格式不对！";
                }

                if (gets > maxim) {
                    return "日期不能大于" + obj.attr("max");
                }

                if (gets < minim) {
                    return "日期不能小于" + obj.attr("min");
                }

                return true;
            },

            "value_check": function (gets, obj, curform, datatype) {
                var multiple = obj.attr("times");
                var minval = obj.attr("minval");
                if (multiple)
                    if (obj.val() % multiple != 0)
                        return false;
                    else if (minval)
                        if (obj.val() < minval)
                            return false;
                        else if (multiple && minval)
                            if (obj.val() < minval || obj.val() % multiple != 0)
                                return false;
            },
            "idcard": function (gets, obj, curform, datatype) {
                /*
                 该方法由网友提供;
                 对身份证进行严格验证;
                 */

                var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];// 加权因子;
                var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];// 身份证验证位值，10代表X;

                if (gets.length == 15) {
                    return isValidityBrithBy15IdCard(gets);
                } else if (gets.length == 18) {
                    var a_idCard = gets.split("");// 得到身份证数组
                    if (isValidityBrithBy18IdCard(gets) && isTrueValidateCodeBy18IdCard(a_idCard)) {
                        return true;
                    }
                    return false;
                }
                return false;

                function isTrueValidateCodeBy18IdCard(a_idCard) {
                    var sum = 0; // 声明加权求和变量
                    if (a_idCard[17].toLowerCase() == 'x') {
                        a_idCard[17] = 10;// 将最后位为x的验证码替换为10方便后续操作
                    }
                    for (var i = 0; i < 17; i++) {
                        sum += Wi[i] * a_idCard[i];// 加权求和
                    }
                    valCodePosition = sum % 11;// 得到验证码所位置
                    if (a_idCard[17] == ValideCode[valCodePosition]) {
                        return true;
                    }
                    return false;
                }

                function isValidityBrithBy18IdCard(idCard18) {
                    var year = idCard18.substring(6, 10);
                    var month = idCard18.substring(10, 12);
                    var day = idCard18.substring(12, 14);
                    var temp_date = new Date(year, parseFloat(month) - 1, parseFloat(day));
                    // 这里用getFullYear()获取年份，避免千年虫问题
                    if (temp_date.getFullYear() != parseFloat(year) || temp_date.getMonth() != parseFloat(month) - 1 || temp_date.getDate() != parseFloat(day)) {
                        return false;
                    }
                    return true;
                }

                function isValidityBrithBy15IdCard(idCard15) {
                    var year = idCard15.substring(6, 8);
                    var month = idCard15.substring(8, 10);
                    var day = idCard15.substring(10, 12);
                    var temp_date = new Date(year, parseFloat(month) - 1, parseFloat(day));
                    // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法
                    if (temp_date.getYear() != parseFloat(year) || temp_date.getMonth() != parseFloat(month) - 1 || temp_date.getDate() != parseFloat(day)) {
                        return false;
                    }
                    return true;
                }

            }
        });
    } else {
        setTimeout(arguments.callee, 10);
    }
})();
$(function () {
    var msg_wrap = function () {
        if ($(this).parents("td,th").length > 0) {
            return  $(this).parents("td").next("td").length == 0 ? $(this).parents("td") : $(this).parents("td").next("td");
        } else if ($(this).parents(".msg_wrap").length > 0) {
            return  $(this).parents(".msg_wrap").next(".msg_wrap,div").length == 0 ? $(this).parents(".msg_wrap") : $(this).parents(".msg_wrap").next(".msg_wrap,div");
        } else {
            return  $(this).parent("div").next("div").length == 0 ? $(this).parent("div") : $(this).parent("div").next("div");
        }
    }
    var tit_wrap = function () {
        if ($(this).parents("td,th").length > 0) {
            return  $(this).parents("td").prev("td,th").length == 0 ? $(this).parents("td,th") : $(this).parents("td").prev("td,th");
        } else if ($(this).parents(".tit_wrap").length > 0) {
            return  $(this).parents(".tit_wrap").prev(".tit_wrap,div").length == 0 ? $(this).parents(".tit_wrap") : $(this).parents(".tit_wrap").prev(".tit_wrap,div");
        } else {
            return  $(this).parent("div").prev("div,span").length == 0 ? $(this).parent("div") : $(this).parent("div").prev("div,span");
        }
    }
    var get_focus_msg = function () {
        var msg = $(this).attr("focusmsg");
        if (msg) {
            return msg;
        }
        msg = $(this).attr("nullmsg");
        $(this).attr("focusmsg", msg);
        return msg;
    }
    $("[datatype]").bind({
        focusin: function () {
            if (this.timeout) {
                clearTimeout(this.timeout);
            }
            var tagname = this.tagName;
            var inputtype = $(this).attr("type");

            if (tagname == "SELECT" || inputtype == "radio" || inputtype == "checkbox") {
                return true;
            }

            if ($(this).attr("type") != "checkbox" && $(this).attr("type") != "radio") {
                var id = $(this).attr("fortip") || $(this).attr("id") || $(this).attr("name");
            } else {
                var id = $(this).attr("fortip") || $(this).attr("name").replace(/\[[^\[\]]*\]/, "");
            }
            var formid = $(this).parents("form").attr("id");
            var is_check = window.Validform[formid].check(true, this);
            var parentObj = msg_wrap.call(this);
            if (is_check) {
                return true;
            } else {
                var tmp_val = $(this).val();
                $(this).val("");
                window.Validform[formid].check(true, this);
                $(this).val(tmp_val);
            }
            var msg = get_focus_msg.call(this);
            var focustip = parentObj.find("div.focustip[for='" + id + "']");
            if (focustip.length == 0) {
                focustip = $("<div class='focustip' for='" + id + "'></div>");
                parentObj.append(focustip);
            }
            var html = '<span class="dec"><s class="dec1">&#9670;</s><s class="dec2">&#9670;</s></span>';
            focustip.html(msg + html);
            focustip.show().siblings(".Validform_checktip[for='" + id + "']").hide();
        },
        focusout: function () {
            var parentObj = msg_wrap.call(this);
            if ($(this).attr("type") != "checkbox" && $(this).attr("type") != "radio") {
                var id = $(this).attr("fortip") || $(this).attr("id") || $(this).attr("name");
            } else {
                var id = $(this).attr("fortip") || $(this).attr("name").replace(/\[[^\[\]]*\]/, "");
            }
            this.timeout = setTimeout(function () {
                var focustip = parentObj.find("div.focustip[for='" + id + "']");
                if (focustip.length == 0) {
                    return;
                }
                focustip.hide().siblings(".Validform_checktip[for='" + id + "']").show();
            }, 0);
        }

    });
    window.Validform = {};

    $("form").each(function (i, n) {
        var id = $(n).attr("id") || "form_" + i;
        $(n).attr("id", id);
        if (window.Validform[id]) {
            return true;
        }
        var valid_len = $(n).find("[datatype]").length;
        if (valid_len == 0) {
            return true;
        }
        var data_label = $(n).attr("data-label") || "em";
        $(n).attr("data-label", data_label);
        var isajax = $(n).attr("ajax") || false;
        window.Validform[id] = $(n).Validform({
            label: data_label,
            ajaxPost: isajax,
            tiptype: function (msg, o, cssctl) {
                //msg：提示信息;
                //o:{obj:*,type:*,curform:*},
                //obj指向的是当前验证的表单元素（或表单对象，验证全部验证通过，提交表单时o.obj为该表单对象），
                //type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态,
                //curform为当前form对象;
                //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
                if (o.obj.is("form")) {//验证表单元素时o.obj为该表单元素，全部验证通过提交表单时o.obj为该表单对象;
                    return;
                }
                var parentObj = msg_wrap.call(o.obj[0]);
                if (o.obj.attr("type") != "checkbox" && o.obj.attr("type") != "radio") {
                    var input_name = o.obj.attr("fortip") || o.obj.attr("id") || o.obj.attr("name");
                } else {
                    var input_name = o.obj.attr("fortip") || o.obj.attr("name").replace(/\[[^\[\]]*\]/, "");
                }
                if (parentObj.find(".Validform_checktip[for='" + input_name + "']").length == 1) {
                    var objtip = parentObj.find(".Validform_checktip[for='" + input_name + "']");
                } else if (parentObj.find(".Validform_checktip[for='" + input_name + "']").length == 0) {
                    var objtip = $("<div class='Validform_checktip' for='" + input_name + "'></div>");
                    parentObj.append(objtip);
                }
                cssctl(objtip, o.type);
                objtip.text(msg);
                if (objtip.parent().is(":hidden") && o.type != 2) {
                    try {
                        atr_alert(msg);
                    } catch (ex) {
                        alert(msg);
                    }
                }
            },
            beforeCheck: function (curform) {
                if (window.kinds) {
                    for (edit in window.kinds) {
                        window.kinds[edit].sync();
                    }
                }
            },
            callback: function (data) {
                try {
                    window.Validform[id].callback(data);
                } catch (ex) {
                }
            }
        });

    });
})