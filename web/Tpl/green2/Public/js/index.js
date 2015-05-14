$(function() {

	$(".city-list-plugs").city_list_plugs();
	try {
		$("#start_date").datepicker("option", "minDate", new Date());
		$("#start_date")
				.datepicker(
						"option",
						"onSelect",
						function(dateText, ins) {
							var date_info = dateText
									.match(/(\d{4})\-(\d{2})\-(\d{2})/);
							var end_date = new Date(date_info[1],
									parseInt(date_info[2]) - 1,
									parseInt(date_info[3]) + 1);
							$("#end_date").datepicker("option", "minDate",
									end_date);
						});
		$("#end_date").datepicker(
				"option",
				"minDate",
				new Date(new Date().getFullYear(), new Date().getMonth(),
						new Date().getDate() + 1));
		$("#end_date")
				.datepicker(
						"option",
						"onSelect",
						function(dateText, ins) {
							var date_info = dateText
									.match(/(\d{4})\-(\d{2})\-(\d{2})/);
							var start_date = new Date(date_info[1],
									parseInt(date_info[2]) - 1,
									parseInt(date_info[3]) - 1);
							$("#start_date").datepicker("option", "maxDate",
									start_date);
						})
	} catch (e) {
	}
	$(".cityList").bind({
		focusin : function() {
			$(".citychange").removeClass("cityoff");
			$(this).show();
		},
		blur : function() {
			$(".citychange").addClass("cityoff");
			$(this).hide();
		},
		mouseover : function() {
			$(this).trigger("focus");
		},
		mouseout : function() {
			$(this).trigger("blur");
		}
	});
	$(".citychange").bind("mouseover", function() {
		$(".cityList").trigger("focus");
	});
});

// 加入收藏
function addFavorite(url, title) {
	url = encodeURI(url);
	try {
		// ie浏览器收藏方式
		window.external.addFavorite(url, title);
	} catch (e) {
		try {
			// 火狐浏览器收藏方式
			window.sidebar.addPanel(title, url, "Tripec 专注旅游应用开发");
		} catch (e) {
			alert("加入收藏失败，请使用Ctrl+D进行添加，或手动在浏览器里进行设置。");
		}
	}
}
