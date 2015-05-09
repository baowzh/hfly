/**
 * User: ldp
 * Date: 12-10-16
 */

// 函数节流
var throttleV2 = function (fn, delay, mustRunDelay) {
    var timer = null,
        t_start;
    return function () {
        var context = this, args = arguments, t_curr = +new Date();
        clearTimeout(timer);
        if (!t_start) {
            t_start = t_curr;
        }
        if (t_curr - t_start >= mustRunDelay) {
            fn.apply(context, args);
            t_start = t_curr;
        }
        else {
            timer = setTimeout(function () {
                fn.apply(context, args);
            }, delay);
        }
    };
};

function getText(ele) {
    return ele.textContent ? ele.textContent : ele.innerText;
}

//tabs 选项卡
function tabs(type, tabmenu, tabcontent) {
    var tabmenuli = $(tabmenu),
        tabcontentli = $(tabcontent);
    tabcontentli.hide();
    function tabsover() {
        $(this).addClass("on")
            .siblings().removeClass("on");
        var index = tabmenuli.index(this);
        tabcontentli
            .eq(index).stop().show()
            .siblings().stop().hide();
    }

    tabmenuli.on(type, throttleV2(tabsover, 90, 120))
        .eq(0).trigger("mouseenter");
}

// 幻灯片插件
// by ldp
;
(function ($) {

    // 方法集合对象
    var slider = {
        // 初始化函数
        init: function (options) {
            return this.each(function () {
                var $this = $(this),
                    settings = $this.data('fadeSlider'),
                    defaults;

                if (!settings) {
                    // 未定义配置，则启用默认设置
                    defaults = {
                        controlBtn: '.slider_control', // 控制按钮容器
                        controlType: 'click', // 控制按钮触发事件
                        autoAnim: true, // 自动播放
                        intervalTime: 1000, // 播放间隔
                        fadeInSpeed: 'slow', // 淡入时间
                        fadeOutSpeed: 'normal', // 淡出时间	
                        LRBtns: false, // 是否启用左右按钮控制
                        callback: null                   // 回调函数
                    };

                    settings = $.extend({}, defaults, options);

                    $this.data('fadeSlider', settings);
                } else {
                    // 否则，覆盖并继承默认参数
                    settings = $.extend({}, defaults, options);
                }

                var $slder_con = $this.find('li'),
                    $slder_btn = $(settings.controlBtn).find('li'),
                    ctrlBtn = $(settings.controlBtn);

                function checkCtrlBtn() {
                    if (!ctrlBtn.length) {
                        $this.after('<ul class="slider_control"></ul>');
                        ctrlBtn = $('.slider_control');
                        checkCtrlBtn();
                    } else {
                        if (!$slder_btn.length) {
                            ctrlBtn.append('<li class="on">1</li>');
                        }
                        // 检查图像个数是否和按钮相等
                        if ($slder_con.length > $slder_btn.length) {

                            for (var i = 0, len = ($slder_con.length - $slder_btn.length); i < len; i++) {
                                $slder_btn
                                    .parent().append('<li>' + ($slder_btn.length + i) + '</li>');
                                $slder_btn = ctrlBtn.find('li');
                            }
                        } else if ($slder_con.length < $slder_btn.length) {

                            for (var j = 0, len2 = ($slder_btn.length - $slder_con.length); j < len2; j++) {
                                $slder_btn
                                    .last().remove();
                                $slder_btn = ctrlBtn.find('li');
                            }
                        } else {
                            return;
                        }
                    }
                }

                checkCtrlBtn();

                // 构造器
                var SliderConstructor = function (container, controller) {
                    this.controller = controller;
                    this.container = container;
                    this.timeId = null;
                    this.num = 0;
                    this.slider_len = controller.length;

                    this.initEvents();
                };

                // 公用方法
                SliderConstructor.prototype = {
                    /**
                     * 初始化事件
                     */
                    initEvents: function () {
                        var _this = this;

                        this.container.hide();
                        this.controller.removeClass('on');

                        if (settings.LRBtns) {
                            this.createLRBtn();
                        }
                        var leftBtn = $('#leftBtn');
                        var rightBtn = $('#rightBtn');

                        $this.on('mouseover',function () {
                            //停止
                            _this.stop();
                        }).on('mouseout',function () {
                                _this.autoAnim();
                            }).mouseleave();

                        this.controller.on(settings.controlType,function () {
                            _this.stop();
                            var num = _this.controller.index(this);    //获取当前控制按钮序号
                            //其它图片淡出后，该序号相同的图片淡入
                            if (!_this.container.is(':animated') && !$(this).hasClass('on')) {
                                _this.fadeAnim(num);
                            }
                            if (settings.autoAnim) {
                                _this.autoAnim();
                            }
                        }).eq(0).trigger(settings.controlType);

                        if (typeof settings.callback === 'function') {
                            settings.callback.apply($this, this.num);
                        }
                    },
                    /**
                     * 淡入淡出动画
                     * @param {Number} i
                     */
                    fadeAnim: function (i) {
                        var _this = this;
                        _this.num = i;      // 记录到num里面，相当于全局变量
                        // 按钮状态变更
                        this.controller
                            .eq(_this.num).addClass("on")
                            .siblings().removeClass("on");
                        // 幻灯片淡入淡出
                        this.container.removeClass('currentImg').fadeOut(settings.fadeOutSpeed)
                            .eq(_this.num).addClass('currentImg').fadeIn(settings.fadeInSpeed);
                    },
                    /**
                     * 自动播放
                     */
                    autoAnim: function () {
                        var _this = this;   // 避免setInterval中的this指向window
                        _this.timeId = setInterval(function () {
                            // 循环
                            _this.num = (_this.num === _this.slider_len - 1) ? 0 : (++_this.num);
                            _this.fadeAnim(_this.num);
                        }, settings.intervalTime);
                    },
                    /**
                     * 停止播放
                     */
                    stop: function () {
                        var _this = this;
                        clearInterval(_this.timeId);
                    },
                    /**
                     * 创建左右控制按钮
                     */
                    createLRBtn: function () {
                        var _this = this,
                            LRBtnStr = '<a id="leftBtn" class="slide_ctrlBtn" href="javascript:">&lt;</a><a id="rightBtn" class="slide_ctrlBtn" href="javascript:">&gt;</a>';

                        this.container
                            .parent()
                            .parent().append($(LRBtnStr));

                        var left = $('#leftBtn'),
                            right = $('#rightBtn');
                        left.on('click', function () {
                            _this.stop();
                            if (!_this.container.is(':animated')) {
                                _this.num = (_this.num === 0) ? _this.slider_len - 1 : (--_this.num);
                                _this.fadeAnim(_this.num);
                            }
                            _this.autoAnim();
                        });
                        right.on('click', function () {
                            _this.stop();
                            if (!_this.container.is(':animated')) {
                                _this.num = (_this.num === _this.slider_len - 1) ? 0 : (++_this.num);
                                _this.fadeAnim(_this.num);
                            }
                            _this.autoAnim();
                        });

                        var width = left.width();
                        // 鼠标移动到容器的动画
                        this.container
                            .parent()
                            .parent().on({
                                'mouseenter': function (e) {
                                    left.stop(false, true).animate({
                                        'left': 0
                                    }, 400);
                                    right.stop(false, true).animate({
                                        'right': 0
                                    }, 400);
                                },
                                'mouseleave': function (e) {
                                    left.stop(false, true).animate({
                                        'left': -width + 'px'
                                    }, 400);
                                    right.stop(false, true).animate({
                                        'right': -width + 'px'
                                    }, 400);
                                }
                            });

                    }
                };

                new SliderConstructor($slder_con, $slder_btn);
            });
        },
        /**
         * 摧毁对象
         * @param options
         * @return {*|jQuery}
         */
        destroy: function (options) {
            return $(this).each(function () {
                var $this = $(this);
                $this.removeData('fadeSlider');
            });
        }
    };
    $.fn.fadeSlider = function () {
        // 第一个参数为slider对象的属性方法
        var method = arguments[0],
            args;

        if (slider[method]) {
            // 存在属性，取出第一个后面的其他参数
            method = slider[method];
            args = Array.prototype.slice.call(arguments, 1);
        } else if (typeof method === 'object' || !method) {
            // 如果未定义method，则默认为init
            method = slider.init;
        } else {
            // 否则抛出错误
            $.error('Method ' + method + 'does not exist on jQuery.pluginName');
            return this;
        }
        // 调用第一个参数函数，并把后面的参数传入
        return method.apply(this, args);
    };
})(jQuery);

// demo
$(function () {
    // 网站首页
    $('ul.slider_container').fadeSlider('init', {
        controlBtn: 'ul.b_slider_control',
        controlType: 'click',
        intervalTime: 6000,
        fadeInSpeed: 650,
        fadeOutSpeed: 1000
    });
    $('ul.inBan_container').fadeSlider('init', {
        controlBtn: 'ol.inBan_ctrls',
        controlType: 'click',
        intervalTime: 5000,
        fadeInSpeed: 450,
        fadeOutSpeed: 600,
        LRBtns: true
    });

    // 新闻首页
    $('.newsSlider_wrap').fadeSlider('init', {
        controlBtn: '.mewsS-control',
        controlType: 'mouseover'
    });
});

/**
 * 向上滚动插件
 * by ldp
 */
;
(function ($) {
    $.fn.scrollSlider = function (options) {
        var defaults = {
            autoScroll: true,
            speed: 1000,
            fadeSpeed: 400,
            intervalTime: 5000,
            callback: null
        };
        var settings = $.extend({}, defaults, options);
        return this.each(function () {
            var _this = $(this),
                liHeight = _this.find('li:first').height(),
                Obj = {
                    init: function (el, height) {
                        this.el = el;
                        this.height = height;

                        var that = this;

                        this.setCss();
                        this.el.on({
                            'mouseover': function () {
                                that.stop();
                            },
                            'mouseout': function () {
                                that.start();
                            }
                        }).trigger('mouseout');
                    },
                    setCss: function () {
                        this.el
                            .parent().css({
                                'height': liHeight + 'px',
                                'overflow': 'hidden'
                            });
                    },
                    start: function () {
                        var _this = this.el;
                        var liHeight = this.height;

                        if (_this.find('li').length > 1) {
                            this.timer = setInterval(function () {
                                _this
                                    .find('li:first').stop().animate({
                                        'opacity': 0
                                    }, settings.fadeSpeed, function () {
                                        _this.stop().animate({
                                            'margin-top': -liHeight + 'px'
                                        }, settings.speed, function () {
                                            _this.css({
                                                'margin-top': 0
                                            })
                                                .find('li').css('opacity', 1)
                                                .eq(0).appendTo(_this);
                                            if (typeof settings.callback === 'function') {
                                                settings.callback().apply(_this);
                                            }
                                        });

                                    });

                            }, settings.intervalTime);
                        } else {
                            this.stop();
                        }
                    },
                    stop: function () {
                        clearInterval(this.timer);
                    }
                };
            Obj.init(_this, liHeight);
        });
    };
})(jQuery);

$(function () {
    $('#anIn-container').scrollSlider();
});

;
(function ($) {
    //复选框全选
    // by ldp
    $.fn.checkAll = function (options) {
        var defaults = {
                className: "checkName", //复选框className属性
                callBack: null           //回调函数
            },
            $obj = $(this), //引用对象
            $items = $("input[type=checkbox]." + options.className);
        options = $.extend(defaults, options);

        function toggleStatus($obj, status, text) {
            $obj.prop("checked", status);
            if ($obj.next("label").length) {
                $obj.next("label").text(text);
            }
        }

        return this.each(function () {
            $items.each(function () {
                $(this).on('click', function () {
                    //如果选中总数等于总数
                    //全选打勾,label文字变成“全不选”
                    //否则，不打勾
                    if ($items.length === $items.filter(":checked").length) {
                        toggleStatus($obj, true, '全不选');
                    } else {
                        toggleStatus($obj, false, '全  选');

                    }

                    //执行回调函数
                    if (typeof options.callBack === "function") {
                        options.callBack.call(this, $obj, $items);
                    }
                });
            });
            $obj.on('click', function () {
                //判断该框的状态
                //等于就取消所有选中,label文字变成“全选”
                //否则，选中所有
                if (this.checked) {
                    $items.prop("checked", true);
                    toggleStatus($obj, true, '全不选');
                } else {
                    $items.prop("checked", false);
                    toggleStatus($obj, false, '全  选');
                }
                if (typeof options.callBack === "function") {
                    options.callBack.call(this, $obj, $items);
                }
            });
        });
    };
})(jQuery);

$(document).ready(function () {
    // 把无title的链接的title属性设置为内容
    function linksAddTitle() {
        var links = document.getElementsByTagName('a'),
            text, title;
        for (var i = 0, len = links.length; i < len; i++) {
            title = links[i].getAttribute('title');
            if (title === '' || !title && (links[i].className.indexOf('tooltip') > -1)) {
                text = (function (i) {
                    return getText(links[i]);
                })(i);
                links[i].setAttribute('title', text);
            }
        }
    }

    linksAddTitle();

    //返回顶部
    $.backToTop = function (options) {
        //默认配置
        var defaults = {
            showHeight: 150, //到达某个高度后显示返回顶部
            speed: 500          //滚动速度
        };
        options = $.extend(defaults, options);    //覆盖默认配置
        if (!$('#toTop').length) {
            $("body").append("<a id='toTop' title='返回顶部' href='javascript:'>返回顶部</a>");      //添加html
        }
        var $toTopObj = $(window),
            $toTopa = $("#toTop");
        $toTopa.hide();
        $toTopObj.on('scroll', function () {
            var scrollTop = $(this).scrollTop();
            if (scrollTop >= options.showHeight) {
                $toTopa.show();
            } else {
                $toTopa.hide();
            }
        });
        $toTopa.on('click', function () {
            $("html,body").animate({
                scrollTop: 0
            }, options.speed, function () {
                $toTopa.fadeOut("fast");
            });
        });
    };
    $.backToTop({
        showHeight: 300, //到达某个高度后显示返回顶部
        speed: 250          //滚动速度
    });

    // 底部固定登录界面
    var FixedLogBar = (function () {

        var container = $('#fixedLoginBar');

        function fixAnim(obj, time) {
            if (!container.is(':animated')) {
                container.animate(obj, time);
            }
        }

        return {
            loadAnim: function (delay, upAnimTime, expandTime) {
                setTimeout(function () {
                    container.animate({
                        'bottom': 0
                    }, upAnimTime, function () {
                        fixAnim({
                            'width': '100%',
                            'height': '125px',
                            'padding-top': '10px',
                            'padding-bottom': '10px'
                        }, expandTime);
                    });
                }, delay);
            },
            close: function (openTime, closeTime) {
                $('a.fixLog_close').on('click', function () {
                    if ($(this).hasClass('logAnimated')) {
                        fixAnim({
                            'width': '100%',
                            'height': '125px',
                            'padding-top': '10px',
                            'padding-bottom': '10px'
                        }, openTime);
                        $(this).removeClass('logAnimated');
                    } else {
                        fixAnim({
                            'width': '44px',
                            'height': '48px',
                            'padding-top': 0,
                            'padding-bottom': 0
                        }, closeTime);
                        $(this).addClass('logAnimated').text('打开').attr('title', '打开');
                    }
                });
            },
            init: function () {
                this.loadAnim(2000, 1000, 2000);
                this.close(2000, 1000);
            }
        };
    })();

    FixedLogBar.init();


    //top_menu listdown头部下拉
    $("ul.top_menu li:has(ul)").hover(function () {
        $(this).addClass("on")
            .find("ul").stop(true, false).show();
    }, function () {
        $(this).removeClass("on")
            .find("ul").stop(true, false).hide();
    });

    tabs("hover", "ul.tabmenu li", "ul.tabcontent > li");

    /**************            为所有Table表格隔行添加class，用于css隔行变色，以及添加鼠标移上变色               ******************/
    $("table").each(function () {
        $("tbody", this).find("tr:odd").addClass("odd").end().find("tr:even").addClass("even");
        $("tbody", this)
            .find("tr").hover(function () {
                $(this).addClass("hover");
            }, function () {
                $(this).removeClass("hover");
            });
    });

    //index page newest loan table hover表格变色
    $("ul.n_loan_lists li").hover(function () {
        $(this).addClass("hover");
    }, function () {
        $(this).removeClass("hover");
    });


    //base information click tabs
    var $bi_tab_menu = $("ul.bi_tab_menu li").not('.off');
    $bi_tab_menu.each(function () {
        $(this).on('click', function (event) {
            $(this).addClass("on")
                .siblings().removeClass("on");
            var index = $bi_tab_menu.index(this);
            $("div.bi_tab_con > div")
                .eq(index).show()
                .siblings().hide();
            event.preventDefault();
        });
    });
	$("ul.bi_tab_menu li.on").trigger("click");

    //登录加密
    //登录
    $("#login_form").submit(function () {
        var login_name = $("input[name='login_name']").val();
        var password = $("input[name='pwd']").val();
        if (login_name == "邮箱/用户名/绑定手机" || login_name == "") {
            $("input[name='login_name']").trigger("focus");
            return false;
        }
        if (password == "") {
            $("input[name='pwd']").trigger("focus");
            return false;
        }
        $("input[name='pwd']").val($.md5($("input[name='pwd']").val()));
    });
    /*    //注册页
     $("#wjr_reg_form").submit(function () {
     $("input[name='wjr_mypass']").val($.md5($("input[name='wjr_mypass']").val()));
     $("input[name='wjr_mypass_aga']").val($.md5($("input[name='wjr_mypass_aga']").val()));
     });*/
    //二次密码
    $("#ac_na_passform").submit(function () {
        $("#na2_idCrad").val($.md5($("#na2_idCrad").val()));
    });
    /* //修改登录密码
     $("#sc_findPass_form").submit(function () {
     $("#sc_defaultPass").val($.md5($("#sc_defaultPass").val()));
     $("#sc_newPass").val($.md5($("#sc_newPass").val()));
     $("#sc_newPass_again").val($.md5($("#sc_newPass_again").val()));

     });
     //修改交易密码
     $("#sc_findzhifuPass_form").submit(function () {
     $("#sc_defaultPass").val($.md5($("#sc_defaultPass").val()));
     $("#sc_zhifuPass").val($.md5($("#sc_zhifuPass").val()));
     $("#sc_newzhifuPass").val($.md5($("#sc_newzhifuPass").val()));
     $("#sc_newPass_again").val($.md5($("#sc_newPass_again").val()));

     });
     //邮箱\手机找回密码
     $("#fp_resetPass_form").submit(function () {
     $("#your_newPass").val($.md5($("#your_newPass").val()));
     $("#newPass_again").val($.md5($("#newPass_again").val()));
     // alert($("#your_newPass").val());
     });
     */

    //datepicker  日历控件
    try {
        $("#birthday_picker").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "c-40:c+40",
            minDate: '-80y',
            dateFormat: "yy-mm-dd"
        });
        $("input.calender").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "c-40:c+40",
            dateFormat: "yy-mm-dd"
        });

        // 验证开始时间和结束时间
        function checkTime(ele1, ele2) {
            if (ele1 && ele2 && ele1.value && ele2.value) {
                var startTime = (new Date(ele1.value)).getTime(),
                    endTime = (new Date(ele2.value)).getTime();
                if ((endTime - startTime) < 0) {
                    alert('结束时间应该比开始时间大，请重新填写');
                    ele2.value = '';
                    ele2.focus();
                    return false;
                } else {
                    return true;
                }
            }
        }

        $('form[id*="ml_manage_form"]').on('submit', function (event) {
            var btime = $(this).find('input.nd_time_begin');
            var etime = btime.siblings('input.nd_time_end');
            if (!checkTime(btime[0], etime[0])) {
                event.preventDefault();
            }
        });
    } catch (ex) {

    }

    //personal center base information head select
    $("ul.bi_h_list a").click(function (event) {
        $("ul.bi_h_list a").removeClass("on");
        event.preventDefault();
    });
    $(".pch_choice a").click(function (event) {
        $(".pch_choice a").removeClass("on");
        $(this).addClass("on");
        event.preventDefault();
    });

    //popup     弹出层

    /**
     * 获取视窗的高度和宽度
     * @return {{width: (Number|Element|Number|Number), height: (Number|Element|Number|Number)}}
     */
    function getWinSize() {
        var a = document.documentElement;
        return {
            width: (window.innerWidth || (a && a.clientWidth) || document.body.clientWidth),
            height: (window.innerHeight || (a && a.clientHeight) || document.body.clientHeight)
        };
    }

    /**
     * 获取对象的偏移量信息
     * @param {Element} elem
     * @return {{left: Number, top: Number, width: Number, height: Number}}
     */
    function getDimension(elem) {
        return {
            left: elem.offsetLeft,
            top: elem.offsetTop,
            width: elem.offsetWidth,
            height: elem.offsetHeight
        };
    }

    /**
     * 获取当前鼠标相对文档的x，y轴偏移量
     * @param {Event} e
     * @return {{x: (*|number), y: (*|number)}}
     */
    function getPointer(e) {
        return {
            x: e.pageX || (e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft)),
            y: e.pageY || (e.clientY + (document.documentElement.scrollTop || document.body.scrollTop))
        };
    }

    /**
     * 弹出层对象
     * @type {{showPopup: Function, hidePopup: Function, scrollPos: Function, drag: Function}}
     */
    var popup = {
        /**
         * 显示弹出层
         * @param {Element} $obj jquery对象
         */
        showPopup: function ($obj) {
            var bodyScrollTop = document.body.scrollTop || document.documentElement.scrollTop,
                pop = $obj.find('.h_upload_pop_box');

            if (!$obj.is(':visible')) {
                $obj.fadeIn("fast", function () {
                    var ofsLeft = (getWinSize().width - pop.width()) / 2,
                        hight = (getWinSize().height - pop.height()) / 2 + bodyScrollTop;
                    $("body").css("overflow","hidden");
                    pop.animate({
                        'left': ofsLeft + 'px',
                        'top': hight + 'px',
                        'margin-top': 0,
                        'margin-left': 0
                    });
                });
            }
        },
        /**
         * 隐藏弹出层
         * @param {Element} $obj jquery对象
         */
        hidePopup: function ($obj) {
            $("body").css("overflow","auto");
            $obj.fadeOut("fast");
        },
        /**
         * 鼠标滚动时触发位置移入当前可视区域中
         * @param {Element} $obj jquery对象
         */
        /*
        scrollPos: function ($obj) {
            $(window).on('scroll', function () {
                var top = (getWinSize().height - $obj[0].offsetHeight) / 2;
                if ($obj.parent().is(':visible')) {
                    var ofsHeight = top + (document.documentElement.scrollTop || document.body.scrollTop);
                    $obj.stop(false, true).animate({
                        'top': ofsHeight + 'px',
                        'margin-top': 0
                    }, 500);
                }
            });
        },*/
        /**
         * 拖拽行为方法
         * @param {Element} ofsObj 第一指定要拖拽的整体对象
         * @param {Element} obj 当设置此参数时，表示通过拖动此参数对象来移动ofsObj对象
         */
        drag: function (ofsObj, obj) {
            // 标识是否具有第二个参数
            var flag;
            obj ? (flag = true) : (flag = false);
            if (flag) {
                obj = ofsObj.find(obj);
            } else {
                obj = ofsObj;
            }
            /**
             * 拖拽中
             * @param {Event} e
             */
            var dragging = function (e) {
                var left = (popup.dragStartLeft + getPointer(e).x - popup.dragStartPos.x),
                    top = (popup.dragStartTop + getPointer(e).y - popup.dragStartPos.y);

                // 设定拖拽范围限制
                var maxLeft, maxTop, minTop;
                var bodyScrollTop = document.body.scrollTop || document.documentElement.scrollTop;
                maxLeft = getWinSize().width - getDimension(popup.draggingObj[0]).width;
                maxTop = getWinSize().height - getDimension(popup.draggingObj[0]).height + bodyScrollTop;
                minTop = bodyScrollTop;

                if (left < 0) {
                    left = 0;
                } else if (left > maxLeft) {
                    left = maxLeft;
                }
                if (top < minTop) {
                    top = minTop;
                } else if (top > maxTop) {
                    top = maxTop;
                }
                popup.draggingObj.css({
                    'left': left + 'px',
                    'top': top + 'px',
                    'margin': 0
                });
                e.stopPropagation();
                e.preventDefault();
            };
            /**
             * 拖拽结束
             * @param {Event} e
             */
            var dragEnd = function (e) {
                // 移除绑定的事件
                $(document).off('mousemove').off('moueup');
                popup.draggingObj && popup.draggingObj.hasClass('dragging') && popup.draggingObj.removeClass('dragging').css({
                    'z-index': 100
                });
                popup.dragStartLeft = null;
                popup.dragStartPos = null;
                popup.dragStartTop = null;
                popup.dragStartPos = null;
                popup.draggingObj = null;

                e.stopPropagation();
                e.preventDefault();
            };

            var dragStart = function (event) {
                if ($(this).is(':visible')) {
                    // 记录最原始信息，以便计算出拖动的偏移量
                    if (flag) {
                        ofsObj = $(this).parent();
                    } else {
                        ofsObj = $(this);
                    }
                    popup.dragStartLeft = getDimension(ofsObj[0]).left;
                    popup.dragStartTop = getDimension(ofsObj[0]).top;
                    popup.draggingObj = ofsObj;

                    popup.draggingObj.css({
                        'z-index': 999
                    }).addClass('dragging');
                    popup.dragStartPos = getPointer(event);

                    // 启动其它事件
                    $(document).on({
                        'mousemove': dragging,
                        'mouseup': dragEnd
                    });
                }

                event.stopPropagation();
                event.preventDefault();
            };

            // 鼠标按下后启动拖拽
            obj.on('mousedown', dragStart);
        }
    };

    window.popup = popup;

    var popupBox = $('.h_upload_pop_box');
    if (popupBox.length > 0) {
       // popup.scrollPos(popupBox);
        popup.drag(popupBox, 'h3');
    }

    $("#popup_close, .popup_close, #popup_close1, .ml_recharge").on('mousedown', function (e) {
        var popopWrapper = $(this).parents('.popup_wrapper');
        e.stopPropagation();
        popup.hidePopup(popopWrapper);
    });
    $("div.popup_black_wrapper").on('click', function () {
        $(".popup_close").trigger("click");
    });

    // 星级评价

    var StarRating = {
        score: 0,
        message: ['1分|很不满意', '2分|不满意', '3分|一般', '4分|满意', '5分|很满意'],
        obj: '.star_rating_wrapper',
        init: function (callback) {
            var that = this;
            var $ele = $(this.obj);
            var $star = $ele.find('span');
            $star.on({
                'click': function () {
                    that.score = $(this).index();
                    $(this).addClass('selected')
                        .siblings().removeClass('selected');
                    that.showMsg(that.score);
                    if (callback) {
                        callback.call(this, that.score);
                    }
                },
                'mouseenter': function () {
                    $(this).addClass('on')
                        .siblings().removeClass('on')
                        .end()
                        .prevAll().addClass('on');
                },
                'mouseleave': function () {
                    var score = that.score + 1;
                    $(this)
                        .parent()
                        .children().removeClass('on');
                    $(this)
                        .parent()
                        .find('span:lt(' + score + ')').addClass('on');
                }
            });
        },
        uninit: function () {
            var $ele = $(this.obj),
                $star = $ele.find('span');
            $star.off('click').off('mouseenter').off('mouseleave');
        },
        showTip: function (msg) {
            // TODO
        },
        showMsg: function (i) {
            var msg = this.message[i];
            $('#starMsg').remove();
            $('<span id="starMsg">' + msg + '</span>').insertAfter($(StarRating.obj));
        }
    };

    StarRating.init(function (i) {
        // console.log(i);
    });

    if ($('.star_rating_wrapper').parent().hasClass('ci_yourEva_con')) {
        StarRating.uninit();
    }

    //rechar_num_subBtn trigger form submit
    $("#rechar_num_subBtn").click(function (event) {
        $("#recharge_num_form").trigger("submit");
        if ($(".Validform_wrong").length > 0) {
            event.preventDefault();
        }
    });

    //more bank list    更多银行选择
	/*
    $("ul#bank_lists li:gt(14)").hide();
    $("a.more_bank").click(function () {
        //第15个显示
        $("ul#bank_lists li:gt(14)").fadeIn("fast");
        $(this).hide();
    });*/

    $("#on_pay_btn").click(function (event) {
        //检查有无选择银行
        if ($("ul#bank_lists input:checked").length < 1) {
            alert("请选择银行");
            event.preventDefault();
        } else {
            //$(".popup_wrapper").fadeIn("fast");
            popup.showPopup($(".popup_wrapper"));
            event.preventDefault();
        }
    });

    //loan manage toggle menu 借款管理折叠菜单
    function foldMenu(obj) {
        var foldObj = obj.siblings("ul");
        if (foldObj.is(":visible")) {
            foldObj.stop(false, true).slideUp(600, "easeOutBack", function () {
                obj.removeClass("expandUp expandDown").addClass("expandDown");
            });
        } else {
            foldObj.stop(false, true).slideDown(600, "easeOutBack", function () {
                obj.removeClass("expandUp expandDown").addClass("expandUp");
            });
        }
    }

    $("#ml_sup_nav").click(function (event) {
        foldMenu($(this));
        event.preventDefault();
    });

    var $ml_br_popup = $("div.ml_br_popup");
    $("a.mlm_o_backReason").click(function (event) {
        //$ml_br_popup.fadeIn("fast");
        popup.showPopup($ml_br_popup);
        event.preventDefault();
    });

    //借款管理 自动设置按钮
    $("#ml_co_auto").click(function (event) {
        if ($(this).text() === "设置自动") {
            $(this).text("关闭自动");
        } else if ($(this).text() === "关闭自动") {
            $(this).text("设置自动");
        }
        event.preventDefault();
    });

    //借款管理-还款弹出窗口
    var $repayPop = $("#ml_br_popup");
    $repayPop.hide();
    $("#ml_co_repay").click(function (event) {
        //$repayPop.fadeIn("fast");
        popup.showPopup($repayPop);
        event.preventDefault();
    });

    //借款管理-设置自动-弹出窗口
    var $autoSettingPop = $("#ml_as_popup");
    $autoSettingPop.hide();
    $("#ml_co_auto").click(function () {
        //$autoSettingPop.fadeIn("fast");
        popup.showPopup($autoSettingPop);
    });

    //提醒对方弹出窗口
    var $remindPop = $(".mv_rm_popup");
    $(".mvm_o_remind").click(function (event) {
        popup.showPopup($remindPop);
        event.preventDefault();
    });
    $(".mv_remind_confirm").click(function (event) {
        popup.hidePopup($remindPop);
        event.preventDefault();
    });


    //个人中心-信息中心-收件箱-状态改变
    $(".mc_letterSta_icon").click(function () {
        $(this)
            .parent()
            .parent().removeClass("mc_ur");
    });

    //信息中心-收件箱-删除所选
    $("#pmc_delSelected").click(function () {
        $("input:checked[name='pletter_readS_c']")
            .parent()
            .parent().remove();
    });
    $("#mc_delSelected").click(function () {
        $("input:checked[name='letter_readS_c']")
            .parent()
            .parent().remove();
    });

    //发件箱，收件箱，全选/全不选
    $("#pcheckAll").checkAll({
        className: "pletter_readS_c"
    });
    $("#checkAll").checkAll({
        className: "letter_readS_c"
    });
    $('#pcheckAll2').checkAll({
        className: 'pletter2_readS_c'
    });

    //我的评价鼠标悬浮交互
    $(".mel_content").hover(function () {
        $(this).addClass("mel_contentH");
    }, function () {
        $(this).removeClass("mel_contentH");
    });

    //第三方登录页面验证与交互
    (function () {
        var $oLog_bindForm = $("#oLog_bind_formList");
        $oLog_bindForm.hide();
        $("#oLog_bind_btn").click(function () {
            $("#oLog_unbind").fadeOut("fast", function () {
                $oLog_bindForm.fadeIn("fast");
            });
        });
    })();


    /*
     // 避免表单多次提交
     function avoidMulSubmit(){
     $('form').each(function(){
     $(this).on('submit',function(){
     $('input[type=submit]', this).prop('disabled', true);
     });
     });
     }
     avoidMulSubmit();
     */

    // 设置ie7以下表单焦点
    function formFocus() {
        var a = navigator.userAgent;
        try {
            if (parseInt(a.match(/MSIE ([^;]+)/)[1], 10) <= 8) {
                if (document.getElementsByTagName('form')) {
                    var labels = document.getElementsByTagName('label');
                    for (var i = 0, len = labels.length; i < len; i++) {
                        $(labels[i]).on('click', function () {
                            var id = this.getAttributeNode('for').value,
                                el = document.getElementById(id);
                            switch (el.type) {
                                case 'checkbox':
                                case 'radio':
                                    el.checked = true;
                                    break;
                                case 'text':
                                case 'textarea':
                                    el.focus();
                                    break;
                            }
                        });
                    }
                }
            }
        } catch (e) {
        }
    }

    if ($('#bank_lists').length) {
        formFocus();
    }

    // 登录通行证
    if ($('.forget_ps').length) {
        $('.forget_ps').next('.error').css({
            'left': '130px',
            'right': 'auto',
            'top': 'auto',
            'bottom': 0,
            'margin-left': 0,
            'padding': '0 0 0 19px'
        });
    }

    // 帮助中心固定导航
    var ScrollFixed = function (obj, time) {
        this.obj = obj;
        this.time = time || 400;
        if (obj.length && parseInt(navigator.userAgent.split('MSIE')[1], 10) !== 6) {
            this.left = obj.offset().left;
            this.top = obj.offset().top;

            var that = this;
            $(window).on('scroll', function () {
                that.init();
            });
        }
    };
    ScrollFixed.prototype = {
        init: function () {
            if ($(window).scrollTop() >= this.top) {
                this.obj.css({
                    'position': 'fixed',
                    'width': this.obj.width()
                }).animate({
                        'top': 0
                    }, this.time);
            } else {
                this.obj.css({
                    'position': 'static'
                });
            }
        }
    };

    var scrollFixedInstance = new ScrollFixed($('.hc_sidebar'));

    // 改变select外观样式规则
    var UI_select = {
        select: $('select.ui_selectList'),
        init: function () {
            if (this.select.length) {
                this.addElem();
            }
        },
        addElem: function () {
            if (!$('span.fakeSelectWrapper').length) {
                var fakeSelectWrapper = $('<span class="fakeSelectWrapper"></span>');
                var fakeSelectText = $('<span class="fakeSelectText"></span>');
                var fakeSelectIcon = $('<span class="fakeSelectIcon"></span>');
                fakeSelectWrapper.append(fakeSelectText).append(fakeSelectIcon).insertBefore(this.select);
            }

            $('span.fakeSelectText').each(function () {
                var select = $(this)
                    .parent()
                    .next('select')[0];
                $(this).text(select.options[select.selectedIndex].text);
            });

            $('span.fakeSelectWrapper').parent().on({
                'mouseover': function () {
                    //$(this).addClass('fS_hover');
                },
                'mouseout': function () {
                    //$(this).removeClass('fS_hover');
                },
                'click': function (e) {
                    $(this).addClass('fS_hover');
                    e.stopPropagation();

                    var that = $(this);
                    $(document).on('click', function (e) {
                        that.removeClass('fS_hover');
                    });
                }
            });

            this.selectChange();
        },
        selectChange: function (callback) {
            var that = this;
            this.select.on('change', function () {
                $(document).trigger('click');
                var selectedText = that.changeselectText($(this));
                $(this)
                    .prev('.fakeSelectWrapper')
                    .find('.fakeSelectText').text(selectedText);
                if (callback && (callback.constructor === Function)) {
                    callback.call($(this), selectedText, $(this)[0].selectedIndex);
                }
            });
        },
        changeselectText: function (ele) {
            return ele[0].options[ele[0].selectedIndex].text;
        }
    };
    UI_select.init();

    // 我要投资首页过滤菜单下拉
    var investFilterDownList = {
        initEvent: function () {
            var li = $('li.ivf_downList');

            li.on({
                'mouseenter': throttleV2(function () {
                    $(this).addClass('ivf_downList_hover').find('ul:first').show();
                }, 100, 120),
                'mouseleave': throttleV2(function () {
                    $(this).removeClass('ivf_downList_hover').find('ul:first').hide();
                }, 100, 120)
            });

            // 替换选中的文字
            li.find('ul:first a').on('click', function (e) {
                var text = $(this).text();
                var selectEle = $(this).parents('.ivf_downList:first').find('.ivf_SelectWrapper > a');
                selectEle.text(text);
                $(this).parents('ul:first').hide();
            });
        }
    };
    investFilterDownList.initEvent();


    (function () {
        /* form validate 所有表单验证信息 */
        try {
            $("#fp_email_form, #fp_tel_form, #fp_resetPass_form, #wjr_form, #tCash_pass_form, #ac_ta1_form, #ac_ct_form, #sc_findPass_form, #sc_findzhifuPass_form, #oLog_zhifu_form, #oLog_bind_form,#wjr_reg_form").Validform({
                tiptype: function (msg, o, cssctl) {
                    //msg：提示信息;
                    //o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
                    //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
                    if (!o.obj.is("form")) {//验证表单元素时o.obj为该表单元素，全部验证通过提交表单时o.obj为该表单对象;
                        var objtip = o.obj.siblings(".Validform_checktip");
                        cssctl(objtip, o.type);
                        objtip.text(msg);
                    }

                },
                beforeSubmit: function () {
                    try {
                        $("#sc_defaultPass").val($.md5($("#sc_defaultPass").val()));
                    } catch (e) {
                    }
                    try {
                        $("#sc_newPass").val($.md5($("#sc_newPass").val()));
                    } catch (e) {
                    }
                    try {
                        $("#sc_newPass_again").val($.md5($("#sc_newPass_again").val()));
                    } catch (e) {
                    }
                    try {
                        $("#sc_zhifuPass").val($.md5($("#sc_zhifuPass").val()));
                    } catch (e) {
                    }
                    try {
                        $("#sc_newzhifuPass").val($.md5($("#sc_newzhifuPass").val()));
                    } catch (e) {
                    }
                    try {
                        $("#your_newPass").val($.md5($("#your_newPass").val()));
                    } catch (e) {
                    }
                    try {
                        $("#newPass_again").val($.md5($("#newPass_again").val()));
                    } catch (e) {
                    }
                    try {
                        $("#wjr_mypass").val($.md5($("#wjr_mypass").val()));
                    } catch (e) {
                    }
                    try {
                        $("#wjr_mypass_aga").val($.md5($("#wjr_mypass_aga").val()));
                    } catch (e) {
                    }
                }
            });


            $("#wjr_reg_form").Validform({
                tiptype: function (msg, o, cssctl) {
                    if (!o.obj.is("form")) {
                        var objtip = o.obj.siblings(".Validform_checktip");
                        cssctl(objtip, o.type);
                        objtip.text(msg);
                    }
                },
                usePlugin: {
                    passwordstrength: {
                        minLen: 6,
                        maxLen: 1000
                    }
                },
                datatype: {
                    userName: function (gets, obj, curform, regxp) {
                        function isChinese(str) {
                            return /[\u4E00-\u9FA5\uf900-\ufa2d]/.test(str);
                        }

                        function getStrLen(str) {
                            var strLen = 0;
                            for (var i = 0, len = str.length; i < len; i++) {
                                if (isChinese(str.charAt(i))) {
                                    strLen += 2;
                                } else {
                                    strLen += 1;
                                }
                            }
                            return strLen;
                        }

                        var strLen = getStrLen(gets);
                        if (strLen < 4 || strLen > 16) {
                            obj.attr('errormsg', '请输入4-16个字符， 一个中文为2个字符。');
                            return false;
                        } else if (!/^[\u4E00-\u9FA5\uf900-\ufa2d a-zA-z_0-9]+$/.test(gets)) {
                            obj.attr('errormsg', '请输入由英文、中文、数字和下划线组成的字符。');
                            return false;
                        } else if (/^\d+$/.test(gets)) {
                            obj.attr('errormsg', '不能使用纯数字。');
                            return false;
                        }
                        return true;
                    },
                    password: function (gets, obj, curform, regxp) {
                        if (!/^[^'"]{6,}$/.test(gets)) {
                            obj.attr('errormsg', '最少6个字符，只能由英文（区分大小写）、数字和半角符号组成(不包含单双引号)。');
                            return false;
                        }
                        return true;
                    },
                    strictPassword: function (gets, obj, curform, regxp) {
                        if(/['"]+/.test(gets)){
                            obj.attr('errormsg', '不包含单双引号,只能由英文（区分大小写）、数字和半角符号组成');
                            return false
                        }else if(!/^[^'"]{6,}$/.test(gets)){
                            obj.attr('errormsg', '最少6个字符');
                            return false
                            //~!@#$%^&*()_+|{}:<>?
                        }else if (/^(([a-zA-Z]+)|(\d+)|([-`=\\\[\];,.~!@#$%^_+*&:|{}]+))$/.test(gets)) {
                            obj.attr('errormsg', '为了您的账户安全，请至少使用其中两种以上的组合。');
                            return false;
                        }
                        return true;
                    }
                }
            });

            //personal center base information form check
            $("#bi_contact_form").Validform({
                tiptype: function (msg, o, cssctl) {
                    if (!o.obj.is("form")) {
                        var objtip = o.obj.siblings(".Validform_checktip");
                        cssctl(objtip, o.type);
                        objtip.text(msg);
                    }
                }
            });

            //填写提现金额表单
            $("#tCash_num_form, #ac_ba3_form, #recharge_num_form").Validform({
                tiptype: function (msg, o, cssctl) {
                    if (!o.obj.is("form")) {
                        var objtip = o.obj.siblings(".Validform_checktip");
                        cssctl(objtip, o.type);
                        objtip.text(msg);
                    }
                },
                datatype: {
                    //自定义范围函数验证
                    range: function (gets, obj, curform, regxp) {
                        /*参数gets是获取到的表单元素值，
                         obj为当前表单元素，
                         curform为当前验证的表单，
                         regxp为内置的一些正则表达式的引用。*/
                        var minNum = parseFloat(obj.attr("minnum")) || 'NaN',
                            maxNum = parseFloat(obj.attr("maxnum")) || 'NaN';
                        if (!/^\d+(\.\d{1,2})?$/.test(gets)) {
                            obj.attr('errormsg', '金额必须为整数或小数，小数点后不超过2位');
                            return false;
                        } else if (!isNaN(minNum) && gets < minNum) {
                            obj.attr("errormsg", "请输入大于" + minNum + "的数字");
                            return false;
                        } else if (!isNaN(maxNum) && gets > maxNum) {
                            obj.attr("errormsg", "请输入小于" + maxNum + "的数字");
                            return false;
                        }
                        return true;
                    },
                    intRange: function (gets, obj, curform, regxp) {
                        var minNum = parseInt(obj.attr("minnum"), 10) || 'NaN',
                            maxNum = parseInt(obj.attr("maxnum"), 10) || 'NaN';
                        if (!/^\d+$/.test(gets)) {
                            obj.attr('errormsg', '金额必须为整数');
                            return false;
                        } else if (!isNaN(minNum) && gets < minNum) {
                            obj.attr("errormsg", "请输入大于" + minNum + "的数字");
                            return false;
                        } else if (!isNaN(maxNum) && gets > maxNum) {
                            obj.attr("errormsg", "请输入小于" + maxNum + "的数字");
                            return false;
                        }
                        return true;
                    }
                }
            });

            //个人中心-认证中心-实名认证-2 表单 ac_na2_form  身份证验证
            $("#ac_na2_form").Validform({
                tiptype: function (msg, o, cssctl) {
                    if (!o.obj.is("form")) {
                        var objtip = o.obj.siblings(".Validform_checktip");
                        cssctl(objtip, o.type);
                        objtip.text(msg);
                    }
                },
                datatype: {
                    /**
                     * 自定义身份证验证
                     * @param gets 获取到的表单元素值
                     * @param obj 当前表单元素
                     * @param curform 当前验证的表单
                     * @param datatype 验证规则
                     * @return {Boolean}
                     * @constructor
                     */
                    "idcard": function (gets, obj, curform, datatype) {
                        var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];// 加权因子;
                        var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];// 身份证验证位值，10代表X;
                        if (gets.length === 15) {
                            return isValidityBrithBy15IdCard(gets);
                        } else if (gets.length === 18) {
                            var a_idCard = gets.split("");// 得到身份证数组
                            if (isValidityBrithBy18IdCard(gets) && isTrueValidateCodeBy18IdCard(a_idCard)) {
                                return true;
                            }
                            return false;
                        }
                        return false;

                        function isTrueValidateCodeBy18IdCard(a_idCard) {
                            var sum = 0; // 声明加权求和变量
                            if (a_idCard[17].toLowerCase() === 'x') {
                                a_idCard[17] = 10;// 将最后位为x的验证码替换为10方便后续操作
                            }
                            for (var i = 0; i < 17; i++) {
                                sum += Wi[i] * a_idCard[i];// 加权求和
                            }
                            valCodePosition = sum % 11;// 得到验证码所位置
                            if (a_idCard[17] === ValideCode[valCodePosition]) {
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
                            if (temp_date.getFullYear() !== parseFloat(year) || temp_date.getMonth() !== parseFloat(month) - 1 || temp_date.getDate() !== parseFloat(day)) {
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
                            if (temp_date.getYear() !== parseFloat(year) || temp_date.getMonth() !== parseFloat(month) - 1 || temp_date.getDate() !== parseFloat(day)) {
                                return false;
                            }
                            return true;
                        }

                    },
                    //自定义下拉控件验证
                    "selectedCheck": function (gets, obj, curform, datatype) {
                        return !!gets;
                    }

                }
            });

            //个人中心-信息中心-写短信表单
            $("#mc_send_letter").Validform({
                tiptype: function (msg, o, cssctl) {
                    if (!o.obj.is("form")) {
                        var objtip = o.obj.siblings(".Validform_checktip");
                        cssctl(objtip, o.type);
                        objtip.text(msg);
                    }
                }
            });

            //自定义立即投标表单验证
            $("#immeTen_form").Validform({
                tiptype: function (msg, o, cssctl) {
                    if (!o.obj.is("form")) {
                        var objtip = o.obj.siblings(".Validform_checktip");
                        cssctl(objtip, o.type);
                        objtip.text(msg);
                    }
                },
                datatype: {
                    /**
                     * 自定义立即投标表单验证
                     * @param gets 获取到的表单元素值
                     * @param obj 当前表单元素
                     * @param curform 当前验证的表单
                     * @param datatype 验证规则
                     * @return {Boolean}
                     * @constructor
                     */
                    "tendNum": function (gets, obj, curform, datatype) {
                        // var num = parseInt(gets);
                        var num = gets;
                        var min = parseFloat(obj.attr("minnum")) || 50,
                            max = parseFloat(obj.attr("maxnum")) || 100000000;

                        if (!/^\d+|0$/.test(num)) {
                            //检查是否数值
                            obj.attr("errormsg", "请输入正确格式");
                            return false;
                        } else if (num < min) {
                            //检测最小值
                            obj.attr("errormsg", "请输入大于等于"+min+"的金额");
                            return false;
                        } else if (num > max) {
                            //检测最大值
                            obj.attr("errormsg", "最高投标金额为" + max);
                            return false;
                        } else if ((num % 50) !== 0) {
                            //检测是否50的倍数
                            obj.attr("errormsg", "请输入50的倍数的金额");
                            return false;
                        } else {
                            return true;
                        }
                    },
                    strLength: function (gets, obj, curform, datatype) {
                        var min = parseInt(obj.attr('min'), 10) || 'Nan',
                            max = parseInt(obj.attr('max'), 10) || 'Nan';
                        if (gets.length < min || gets.length > max) {
                            obj.attr("errormsg", '请输入' + min + '到' + max + '之间的字数');
                            return false;
                        }
                        return true;
                    }
                }
            });

            //发布借款 表单验证
            $("#loanP_form").Validform({
                datatype: {
                    "required": function (gets, obj, curform, datatype) {
                        return !!gets.length;
                    }
                }
            });

            // 身份认证材料
            $('#idCardVer_form').on('submit', function (e) {
                var idExpire_year = document.getElementById('idExpire_year'),
                    idExpire_month = document.getElementById('idExpire_month'),
                    idExpire_day = document.getElementById('idExpire_day');

                var test1 = /\d{4}/.test(idExpire_year.value) && (parseInt(idExpire_year.value, 10) > 1900 && parseInt(idExpire_year.value, 10) <= (new Date()).getFullYear()),
                    test2 = /\d{1,2}/.test(idExpire_month.value) && (parseInt(idExpire_month.value, 10) >= 1 && parseInt(idExpire_month.value, 10) <= 12),
                    test3 = /\d{1,2}/.test(idExpire_day.value) && (parseInt(idExpire_day.value, 10) >= 1 && (parseInt(idExpire_day.value, 10) <= 31));

                if (!test1) {
                    alert('请输入正确的年份');
                    idExpire_year.value = '';
                    idExpire_year.focus();
                    e.preventDefault();
                } else if (!test2) {
                    alert('请输入正确的月份');
                    idExpire_month.value = '';
                    idExpire_month.focus();
                    e.preventDefault();
                } else if (!test3) {
                    alert('请输入正确的天数');
                    idExpire_day.value = '';
                    idExpire_day.focus();
                    e.preventDefault();
                }
            });

        } catch (ex) {
        }

        // 密码框禁用粘贴
        $('input[type=password]').each(function () {
            $(this).on('paste', function (e) {
                e.preventDefault();
            });
        });

    })();


    $("#username, #log_wj_username, #log_wj_passwd, #code_verify, input.placeholder").focus(function () {
        if (this.value === this.defaultValue) {
            this.value = "";
        }
    }).blur(function () {
            if (this.value === "") {
                this.value = this.defaultValue;
            }
        });


    // 我要借款失败提示框
    var LoanTip = {
        createPopup: function (elem, str) {
            var failTip_wrapper = $('<span class="failTip_wrapper"></span>'),
                failTip_close = $('<span class="failTip_close" title="关闭">x</span>'),
                failTip_con = $('<span class="failTip_con">' + str + '</span>'),
                failTip_corner = $('<span class="failTip_corner"></span>');
            failTip_wrapper.append(failTip_close).append(failTip_con).append(failTip_corner).appendTo(elem);
            this.popupAnim(failTip_wrapper);
        },
        popupAnim: function (wrapper) {
            wrapper.css({
                'bottom': 0
            }).animate({
                    'bottom': '40px',
                    'opacity': 'show'
                }, 400, function () {
                    wrapper
                        .find('.failTip_close').on('click', function (event) {
                            wrapper.animate({
                                'bottom': 0,
                                'opacity': 'hide'
                            }, 400);
                            $(this).off('click');
                            event.stopPropagation();
                        });
                });
        },
        initEvent: function (elem) {
            var that = this;
            elem.each(function () {
                $(this).on('click', function (event) {
                    var title = this.getAttribute('data-error'),
                        wrapper = $(this).find('.failTip_wrapper');
                    if (!wrapper.length) {
                        if (!title) {
                            return;
                        }
                        that.createPopup($(this), title);
                    }
                    if (wrapper.is(':visible')) {
                        return;
                    }
                    that.popupAnim(wrapper);
                });
            });
        }
    };

    LoanTip.initEvent($('.loanFailure_tip'));


    // 我要借款-可选认证展开显示
    var reverse_btn = $('#reverse_btn');
    if (reverse_btn.length) {
        var approve_table = $('table.toggleTable');
        approve_table.hide();
        reverse_btn.addClass('collapse').on('click', function (e) {
            var table = $(this)
                .parents('header:first')
                .siblings('table.toggleTable');
            if ($(this).hasClass('collapse')) {
                $(this).removeClass('collapse').addClass('expand').text('收起');
                table.show();
            } else if ($(this).hasClass('expand')) {
                $(this).removeClass('expand').addClass('collapse').text('查看更多');
                table.hide();
            }
            e.preventDefault();
        });
    }

    // 我要借款
    /*
     $('.loanT-list > li > a').each(function () {
     $(this).on('click', function (e) {
     var curClass = this.className;
     if (curClass.indexOf('_on') > -1) {
     return false;
     } else {
     $('.loanT-list > li > a').each(function () {
     if (this.className.indexOf('_on') > -1) {
     this.className = this.className.split('_on')[0];
     }
     });
     curClass = curClass + '_on';
     }

     this.className = curClass;
     e.preventDefault();
     });
     });
     */

    $('table.approve_table tr td:last-child a').on('click', function () {
        var title = $(this).parents('tr')
            .find('td:nth-child(2)').text();
        if (title.indexOf('身份证') === -1) {
            $('#otherApprove h3 strong').text(title);
        }
    });

    // cookie
    var Cookie = {
        get: function (name) {
            var cookieName = encodeURIComponent(name) + '=',
                cookieStart = document.cookie.indexOf(cookieName),
                cookieValue = null;
            if (cookieStart > -1) {
                var cookieEnd = document.cookie.indexOf(';', cookieStart);
                if (cookieEnd === -1) {
                    cookieEnd = document.cookie.length;
                }
                cookieValue = decodeURIComponent(document.cookie.substring(cookieStart + cookieName.length, cookieEnd));
            }

            return cookieValue;
        },
        set: function (name, value, expire, path, domain, secure) {
            var cookieText = encodeURIComponent(name) + '=' + encodeURIComponent(value);
            if (expire instanceof Date) {
                cookieText += '; expire=' + expire.toGMTString();
            }
            if (path) {
                cookieText += '; path=' + path;
            }
            if (domain) {
                cookieText += '; domain=' + domain;
            }
            if (secure) {
                cookieText += '; secure';
            }
            document.cookie = cookieText;
        },
        unset: function (name, path, domain, secure) {
            this.set(name, '', new Date(0), path, domain, secure);
        }
    };

    window.Cookie = Cookie;

    // 记住密码
    var RememberMe = function (username, checkbox) {
        this.userId = username;
        this.checkId = checkbox;
        this.remember_ps = document.getElementById(checkbox);
        this.username = document.getElementById(username);

        if (!(this.remember_ps)) {
            return;
        }
        if ($('#' + username).parents('form').attr('id') !== 'login_form') {
            return;
        }

        this.init();
    };
    RememberMe.prototype = {
        init: function () {
            var self = this;
            if (Cookie.get(this.checkId)) {
                this.readRemember();
            }

            this.remember_ps.onchange = function () {
                if (this.checked) {
                    if (!Cookie.get(self.userId)) {
                        self.rememberMe();
                    }
                } else {
                    self.clearRemember();
                }
            };
        },
        rememberMe: function () {
            var date = (new Date()).getFullYear() + ',' + (new Date()).getMonth() + ',' + ((new Date()).getDay() + 30);
            Cookie.set(this.userId, this.username.value, new Date(date));
            Cookie.set(this.checkId, 'true');
        },
        readRemember: function () {
            this.remember_ps.checked = Cookie.get(this.checkId);
            this.username.value = Cookie.get(this.userId);
        },
        clearRemember: function () {
            Cookie.unset(this.userId);
            Cookie.unset(this.checkId);
        }
    };
    new RememberMe('username', 'remember_ps');
    new RememberMe('log_wj_username', 'remember_ps');

});
