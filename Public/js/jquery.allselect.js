(function($) {
	$.fn.extend( {
		allselect : function(options) {
			// 设置默认值并用逗号隔开
		var defaults = {
                allselectclass: "allselect",//class
                cselectname: "c_select[]"//class or name
            }
		var options = $.extend(defaults, options);
		//var cselect_name=$("input."+options.cselectname).length!=0?$("input."+options.cselectname):$("input[name='"+options.cselectname+"']");
		var cselect_name=$("input."+options.cselectname)
			$("input."+options.allselectclass).click(function() {
				if ($(this).attr("checked") == "checked") {
					cselect_name.attr("checked", "checked");
					$("input."+options.allselectclass).attr("checked", "checked");
				} else {
					cselect_name.removeAttr("checked");
					$("input."+options.allselectclass).removeAttr("checked");
				}
			});
			
			cselect_name.click(function(){
				var i_num = 0 ;
				cselect_name.each(function(e){
					if(cselect_name.eq(e).attr("checked") == 'checked'){
						i_num++;
					}
				});
				
				if(cselect_name.length == i_num){
					$("input."+options.allselectclass).attr("checked","checked");
				}else{
					$("input."+options.allselectclass).removeAttr("checked");
				}
			});
		}
	});
})(jQuery);