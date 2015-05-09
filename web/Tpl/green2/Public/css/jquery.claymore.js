(function($) {
	$.fn.extend( {
		claymore : function(options) {
			// 设置默认值并用逗号隔开
		var defaults = {
                claymorelist: "claymore",//class
            }
		var options = $.extend(defaults, options);
		
			$("."+options.claymorelist).click(function() {
				alert(9);
			});
		}
	});
})(jQuery);