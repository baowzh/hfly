(function($) {
$.extend({
	metadata : {
		defaults : {
			type: 'class',
			name: 'metadata',
			cre: /({.*})/,
			single: 'metadata'
		},
		setType: function( type, name ){
			this.defaults.type = type;
			this.defaults.name = name;
		},
		get: function( elem, opts ){
			var settings = $.extend({},this.defaults,opts);
			// check for empty string in single property
			if ( !settings.single.length ) settings.single = 'metadata';

			var data = $.data(elem, settings.single);
			// returned cached data if it already exists
			if ( data ) return data;

			data = "{}";

			if ( settings.type == "class" ) {
				var m = settings.cre.exec( elem.className );
				if ( m )
					data = m[1];
			} else if ( settings.type == "elem" ) {
				if( !elem.getElementsByTagName )
					return undefined;
				var e = elem.getElementsByTagName(settings.name);
				if ( e.length )
					data = $.trim(e[0].innerHTML);
			} else if ( elem.getAttribute != undefined ) {
				var attr = elem.getAttribute( settings.name );
				if ( attr )
					data = attr;
			}

			if ( data.indexOf( '{' ) <0 )
			data = "{" + data + "}";

			data = eval("(" + data + ")");

			$.data( elem, settings.single, data );
			return data;
		}
	}
});


$.fn.metadata = function( opts ){
	return $.metadata.get( this[0], opts );
};

})(jQuery);
$.metadata.setType("attr", "validate");

jQuery.extend(jQuery.validator.messages,{
    required:"必填字段",
    remote:"请修正该字段",
    email:"请输入正确格式的电子邮件",
    url:"请输入合法的网址",
    date:"请输入合法的日期",
    dateISO:"请输入合法的日期 (ISO).",
    number:"请输入合法的数字",
    digits:"只能输入整数",
    creditcard:"请输入合法的信用卡号",
    equalTo:"请再次输入相同的值",
    accept:"请输入拥有合法后缀名的字符串",
    maxlength:jQuery.validator.format("最多 {0} 个字"),
    minlength:jQuery.validator.format("最少 {0} 个字"),
    rangelength:jQuery.validator.format("内容长度请保持在 {0} 到 {1} 个字之间"),
    range:jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
    max:jQuery.validator.format("最大为 {0} "),
    min:jQuery.validator.format("最小为 {0} ")
    });
jQuery.validator.addMethod("Isw",function(value,element){
    return this.optional(element)||/^\w+$/.test(value);
},'只能包含英文字母、数字和下划线！');
jQuery.validator.addMethod("bankcode",function(value,element){
    return this.optional(element)||/^\d{19}$/.test(value);
},'请输入正确的银行卡号');
jQuery.validator.addMethod("username",function(value,element){
	if(value==element.defaultValue||value=="")return false;
	else return true;
    //return this.optional(element)||/^\w+$/.test(value);
},'用户名必填');
jQuery.validator.addMethod("CheckUserName",function(value,element){
    return this.optional(element)||(/^[\u4e00-\u9fa5\w]+$/.test(value)&&/[\u4e00-\u9fa5a-zA-Z_]+/.test(value));
},'只能包含中文、数字和下划线(不允许全数字)！');
jQuery.validator.addMethod("IsRealName",function(value,element){
    return this.optional(element)||(/^(([\u4e00-\u9fa5]+)|([a-zA-Z· ]+))$/.test(value));
},'请填写真实姓名！');
jQuery.validator.addMethod("CheckQQ",function(value,element){
    return this.optional(element)||/^[1-9][0-9]{4,}$/i.test(value);
},"请正确填写您的QQ号码！");
jQuery.validator.addMethod("byteRangeLength",function(value,element,param){
    value=$.trim(value);
    var length=value.length;
    $(element).val(value);
    for(var i=0;i<value.length;i++){
        if(value.charCodeAt(i)>127){
            length++;
        }
    }
return this.optional(element)||(length>=param[0]&&length<=param[1]);
    },$.validator.format("请确保输入的值在{0}-{1}个字节之间(一个中文字算2个字节)！"));
jQuery.validator.addMethod("isMobile",function(value,element){
    return this.optional(element)||/^1((([358])\d{9})|(47\d{8}))$/.test(value);
},"请正确填写您的手机号码！");
jQuery.validator.addMethod("isIDCard",function(value,element){
    return this.optional(element)||/^\d{18}$/.test(value);
},"请正确填写身份证号！");
jQuery.validator.addMethod("isTel",function(value,element){
    var tel=/^\d{3,4}-?\d{7,9}$/;
    return this.optional(element)||(tel.test(value));
},"请正确填写您的电话号码！");
jQuery.validator.addMethod("isPhone",function(value,element){
    var mobile=/^1((([358])\d{9})|(47\d{8}))$/;
    var tel=/^\d{3,4}-?\d{7,9}$/;
    return this.optional(element)||(tel.test(value)||mobile.test(value));
},"请正确填写您的联系电话(手机/电话皆可)！");
jQuery.validator.addMethod("isdian",function(value,element){
    return this.optional(element)||(/^[0-9]{7,9}$/.test(value));
},"请输入正确的电话号码！");
jQuery.validator.addMethod("isZipCode",function(value,element){
    return this.optional(element)||(/^[0-9]{6}$/.test(value));
},"请正确填写您的邮政编码！");
jQuery.validator.addMethod("isFile",function(value,element){
	if(value) return true;
	else return false;    
},"请选择文件！");

jQuery.validator.addMethod("isAgree",function(value,element){
	var eltype=element.type;
	if(eltype=="radio" || eltype=="checkbox"){
		var elname=element.name;	
		var len=$("input[name='"+elname+"']:checked").length;	
		if(len>0) return true;
		else return false; 
	}
	else{
		return (value!=-1);
	}
},"必须同意才能继续！");
jQuery.validator.addMethod("date",function (value, element) { //验证日期，兼容ie	
  return this.optional(element) || (/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(value));
},"请输入合法的日期");
jQuery.validator.addMethod("regEmail",function(value,element,params){
	//alert(params)
	 var changeUrl=	params+value;
     //var changeUrl = GURL+'/isexitemail?email='+value; 
	  var html = $.ajax({
 					url:changeUrl,
  					async: false
 				 }).responseText;
	if(html=="1")	return true;
	else		 
	return false;      
},"该邮箱已经注册！");
jQuery.validator.addMethod("v_code",function(value,element,params){	
    // return false;
	 var m=parseInt(params);	 
	 var regex=new RegExp('^\\d{'+m+'}$');	
	 return regex.test(value) ;  
},jQuery.validator.format("请输入{0}位数字验证码"));

jQuery(document).ready(function($){
	
	var validateObj=$(".validate");
	$.each(validateObj,function(){
		if(typeof($(this).attr("validateinfo"))=="undefined"){
			var validateinfo="parent:td,errorElement:em,errorClass:error,successClass:success";
		}else{
			var validateinfo=$(this).attr("validateinfo");
		}
		if(validateinfo){
			var info=validateinfo.split(",")
		}
		var pars=new Array()		
		for (i in info)	{
			var par=info[i].split(":");					
			pars[par[0]]=par[1]
		}
		pars["parent"]= pars["parent"]? pars["parent"]:"td";
		pars["errorElement"]= pars["errorElement"]? pars["errorElement"]:"em";
		pars["errorClass"]= pars["errorClass"]? pars["errorClass"]:"error";
		pars["successClass"]= pars["successClass"]? pars["successClass"]:"success";		
				
		$(this).validate({
			event:"change",
			errorElement:pars["errorElement"],
			errorClass:pars["errorClass"],
			errorPlacement: function(error, element) {
				var ID=error.attr("for");			
				var em=element.parent(pars["parent"]).children(pars["errorElement"]+"[for='"+ID+"']");
				if(em.length>0)em.remove();					
				element.parent(pars["parent"]).append(error);
			},
			success: function(label) {
				label.removeClass().addClass(pars["successClass"]);
			}
		});				
	});
});