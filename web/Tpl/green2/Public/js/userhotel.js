// JavaScript Document

$(function(){
	
	$("#imprs li").each(function(){
		$(this).click(function(){
			var ck_box = $("#impr_type_" + $(this).attr("checkid"));
			if(ck_box.attr("checked")=="checked"){
				$(this).css("border", "2px #FFF solid");
				ck_box.attr("checked", false);
			}else{
				$(this).css("border", "2px #063 solid");
				ck_box.attr("checked", true);
			}
		});
	});
	
});

/* 处理酒店收藏操作 */
$(function(){
	
	$("._collect").click(function(){
		var hotelid = $(this).attr("hotel");
		$.post(
			  $("#collect-cmd").attr("url"),
			  {hotel:hotelid, status:$(this).attr("value")}
		);
		$("tr[hotel="+ hotelid +"]").remove();
	});
		
});

//申请退款
$(function(){
	$(".change-status").click(function(){
		var url = $(this).attr("url");
		art.dialog.confirm("注意：此操作可能会影响您的财物，请慎重操作。是否继续？",
		function(){
			location.href = url;
		});
	});
});