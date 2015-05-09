// JavaScript Document


$(function () {	
	$.fn.allselect({
			allselectclass:"allselect1",//class
			cselectname: "allselectchild1"//name
	}); 
	
	$.fn.allselect({
			allselectclass:"allselect2",//class
			cselectname: "allselectchild2"//name
	}); 
	
	$.fn.allselect({
			allselectclass:"allselect3",//class
			cselectname: "allselectchild3"//name
	});
	
	$.fn.allselect({
			allselectclass:"allselect4",//class
			cselectname: "allselectchild4"//name
	});
	
	$.fn.allselect({
			allselectclass:"allselect5",//class
			cselectname: "allselectchild5"//name
	});
	
	$.fn.allselect({
			allselectclass:"allselect6",//class
			cselectname: "allselectchild6"//name
                        
	});
        
try{
	$.fn.cityLink({
		linkId: {
			 province: "province",
			 city: "city",
			 county: "area"
		},
		defaults: {
			 province: "{$province}",
			 city: "{$city}",
			 county: "{$area}"
		}});

		var aa = $("input[name=location_x]").val();
		var bb = $("input[name=location_y]").val();
		if(aa != ''){
			 baidu_map({ lat: bb,lng: aa,adr: ""});
		}else{baidu_map();}
}catch(e){}

$("#sel_city_belong").bind("change",function(){
	Reset();
	var cid = $(this).val();
	var gurl = $(this).attr("postPath");
	$.ajax({
		url: gurl,
		type: "POST",
		dataType:"json",
		data: {'id': cid},
		async: false,
		complete: function () {
		},
		error: function () {
			alert('Ajax request error');
		},
		success: function (result) {
			var obj = null;
			var sel = null;
			for(var i=0;i<result.length;i++){
				if(result[i]){
					switch(i){
						case 0:obj = $("#business_circle");break;
						case 1:obj = $("#canton");break;
						case 2:obj = $("#subway_lines");break;
						case 3:obj = $("#station");break;
						case 4:obj = $("#sightseeing_spots");break;
						case 5:obj = $("#college");break;
					}
					$("#a" + i).show();
					for(var j in result[i]){
						if(obj.attr("selectid")==j){ sel = "selected='selected'";}else{ sel = "";}
						obj.append('<option value="'+ result[i][j]["id"] +'" '+ sel +'>'+ result[i][j]["area_name"] +'</option>');
					}
				}
				else
					continue;
			}
			return;
		}});		
	}).trigger("change");



	function Reset(){
            
		$("#business_circle").html('<option value="0" selected="selected">请选择 商圈</option>');
		$("#canton").html('<option value="0" selected="selected">请选择 行政区</option>');
		$("#subway_lines").html('<option value="0" selected="selected">请选择 地铁线路</option>');
		$("#station").html('<option value="0" selected="selected">请选择 车站/机场</option>');
		$("#sightseeing_spots").html('<option value="0" selected="selected">请选择 观光景点</option>');
		$("#college").html('<option value="0" selected="selected">请选择 大学</option>');
		$("#a0").hide();
		$("#a1").hide();
		$("#a2").hide();
		$("#a3").hide();
		$("#a4").hide();
		$("#a5").hide();
	}
});

$(function(){
	
	function trim(str){
		return str.replace(/(^\s*)|(\s*$)/g, "");
　 }
	
	$("#update_all_money").click(function(){
		if(trim($("#all_money").val())=="" || isNaN($("#all_money").val())){
			$("#all_money").css("background-color","#FFC4C5");
		}else{
			$("#all_money").css("background-color","white");
			art.dialog({
				content: "确定将订单应付金额修改为 "+ trim($("#all_money").val()) +" 元？",
				icon: "question",
				ok:function(){
					$.post(
					  $("#_submit").attr("url"),
					  {order_id: $("#_submit").val(), all_money: trim($("#all_money").val())},
					  function(msg){
						  $("#all_money").val(msg);
						  art.dialog.alert("修改成功");
					  },
					  "json"
					);
				},
				cancel:function(){}
			});
		}
	});
	
	$("#all_money").blur(function(){
		if(trim($("#all_money").val())=="" || isNaN($("#all_money").val())){
			$("#all_money").css("background-color","#FFC4C5");
		}else{
			$("#all_money").css("background-color","white");
		}
	});

});