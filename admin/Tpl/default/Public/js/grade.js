$(document).ready(function(){ 
    //checkConfirm(); 
}); 
function checkConfirm(changeUrl){  
  $.getJSON(changeUrl, function(json){
		if(json.status==1){
			alert("对不起该用户已经存在了");
			$("#login_name").focus().val('');
		}else{
			alert('恭喜您用户名可以使用!');
		}
});
} 
