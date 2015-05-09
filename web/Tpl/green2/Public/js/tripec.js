window.kinds = {};
KindEditor.ready(function (K) {
    KindEditor.options.upImgUrl = "{:U('upload/kind')}";
    KindEditor.options.uploadJson = "{:U('upload/kind')}";
    KindEditor.options.upFlashUrl = "{:U('upload/kind')}";
    KindEditor.options.upMediaUrl = "{:U('upload/kind')}";
    KindEditor.options.minWidth = 250;
    KindEditor.options.minHeight = 50;
    KindEditor.options.items = ["source", "|", "undo", "redo", "|", "cut", "copy", "paste", "plainpaste", "wordpaste", "|", "justifyleft", "justifycenter", "justifyright", "justifyfull", "insertorderedlist", "insertunorderedlist", "indent", "outdent", "subscript", "superscript", "clearhtml", "quickformat", "selectall", "|", "fullscreen", "formatblock", "fontname", "fontsize", "|", "forecolor", "hilitecolor", "bold", "italic", "underline", "strikethrough", "lineheight", "removeformat", "|", "image", "flash", "media", "insertfile", "table", "hr", "emoticons", "pagebreak", "anchor", "link", "unlink", "|", "about"];
    $(".kind-text").each(function (i, n) {
        var kind_id = $(n).attr("id") || "kind_" + i;
        $(n).attr("id", kind_id);
        var width = $(n).css("width");
        var height = $(n).css("height");
        window.kinds[kind_id] = K.create(this, $.extend(KindEditor.options,
            {
                editorid: kind_id,
                width: width,
                height: height,
                afterBlur: function () {
                    window.kinds[kind_id].sync();
                    $("#" + kind_id).trigger("blur");
                },
                afterFocus: function () {
                    window.kinds[kind_id].sync();
                    $("#" + kind_id).trigger("focus");
                },
                afterChange: function () {
                    window.kinds[kind_id].sync();
                    $("#" + kind_id).trigger("change");
                }
            }));
    });
});
$(function () {
    $.fn.extend({
        create_calender: function () {
            var formats = $(this).attr("format") || "yy-mm-dd";
            var yearRange = $(this).attr("year") || "c-60:c+20";
            try {
                $(this).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: yearRange,
                    dateFormat: formats,
                    onSelect: function () {
                        if (window.Validform[this.form.id]) {
                            window.Validform[this.form.id].check(false, this);
                        }
                    }
                });
            } catch (ex) {
            }
        }})
    $("input.calender,#birthday_picker").create_calender();
    $("#cityChange").hover(function () {
            $(this).find(".cityList").show();
        },
        function () {
            $(this).find(".cityList").hide();
        }
    )
    $('#slider').slider({
        range: true,
        values: [$("input[name='min_price']").val(), $("input[name='max_price']").val()],
        max: 3000,
        min:0,
        step:100,
        stop:function (event, ui) {
            $("input[name='min_price']").val(ui["values"][0]);
            $("input[name='max_price']").val(ui["values"][1]);
        }
    });
})

function getRandom(n) {
    return Math.floor(Math.random() * n + 1)
}