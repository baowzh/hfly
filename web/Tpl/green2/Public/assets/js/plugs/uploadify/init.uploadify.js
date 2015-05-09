(function ($) {
    $.fn.extend({
        jUpload: function (options) {
            var defaults = {
                'formData': {
                },
                trigger_id: "t_"+$(this).attr("id"),
                'auto': false,
                'multi': false,
                'buttonText': '浏览文件',
                //"queueID": "upload-queue",
                'width': '80',
                //浏览按钮的高度
                'height': '28',
                'swf': _root_ + '/Public/Plugins/uploadify/uploadify.swf',
                'uploader': _index_ + "uploadify/images",
                'cancelImg': _root_ + '/Public/Plugins/uploadify/uploadify-cancel.png',
                'queueSizeLimit': 1
            }
            var options = $.extend(defaults, options);
            options.obj = $(this);
            options.alert_info = function (msg) {
                try {
                    atr_alert(msg);
                } catch (e) {
                    alert(msg)
                }
            }
            options.onUploadSuccess = function (file, data, response) { //每次成功上传后执行的回调函数，从服务端返回数据到前端
                if (data.substr(0, 1) != "{") {
                    options.alert_info("服务器响应出错！");
                    return;
                }
                var serverData = eval('(' + data + ')');
                if (serverData.status == 1) {
                    options.success(serverData.data, serverData.info);
                } else {
                    options.alert_info(serverData.info)
                }
            }
            options.onSelectError = function (file, errorCode, errorMsg) {
                switch (errorCode) {
                    case -100:
                        options.alert_info("上传的文件数量已经超出系统限制的");
                        break;
                    case -110:
                        options.alert_info("文件 [" + file.name + "] 大小超出系统限制的");
                        break;
                    case -120:
                        options.alert_info("文件 [" + file.name + "] 大小异常！");
                        break;
                    case -130:
                        options.alert_info("文件 [" + file.name + "] 类型不正确！");
                        break;
                }
                return false;
            }
            options.onFallback = function () {
                alert_info("文件 [" + file.name + "] 类型不正确！");
            }
            options.success = options.success ? options.success : function (data, info) {
                options.alert_info(data);
            }
            options.obj.uploadify(options);
            $("#" + options.trigger_id).bind("click", function () {
                options.obj.uploadify('upload', '*');
            });
        }
    })
})(jQuery);

