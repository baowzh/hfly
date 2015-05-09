function atr_alert(content){
	art.dialog.alert(content);
    return false;
}
function atr_img(src){
	var title=arguments[1]?arguments[1]:"图片";
	art.dialog.through({
		title: title,
	    content: "<img src='"+src+"' />",
	    lock: true
	});
}
function atr_open(url){
	var title=arguments[1]?arguments[1]:"窗口";
	art.dialog.open(url,{
		title: title,  //窗口标题
		window: 'top',    //在顶层打开
		width:"70%",
		height:"80%",		
		lock: true
	});
    return false;
}
function atr_con(content){
	var title=arguments[1]?arguments[1]:"内容";
	art.dialog.through({
		title: title,
	    content: content,
	    lock: true
	});
}
function atr_confirm(url){
	var title=arguments[1]?arguments[1]:"确认要删除信息吗?";	
	art.dialog.confirm(title, function(){location.href = url;});	
	return false;
}
function confirm_deleteall(){
    var form=arguments[0]?arguments[0]:$("form")[0];
    var title=arguments[1]?arguments[1]:"确认要删除选中的信息吗?";
    art.dialog.confirm(title, function(){$(form).trigger("submit")});
    return false;
}
