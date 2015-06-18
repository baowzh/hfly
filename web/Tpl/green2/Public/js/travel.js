var tebList = new Array();
$(function() {
	try {
		$.fn.cityLink({
			linkId : {
				province : "province",
				city : "city",
				county : "area"
			},
			defaults : {
				province : "{$province}",
				city : "{$city}",
				county : "{$area}"
			}
		});
		var aa = $("input[name=location_x]").val();
		var bb = $("input[name=location_y]").val();
		if (aa != '') {
			baidu_map({
				lat : bb,
				lng : aa,
				adr : ""
			});
		} else {
			baidu_map();
		}
	} catch (e) {
	}
	$(window).scroll(
			function() {
				var span_scroll = $("span.scroll_REF").offset();
				var scrollTop = $(window).scrollTop();
				if (span_scroll.top - scrollTop <= 0) {
					$("div.scroll_nav").addClass("scroll_nav_fixed");
				} else {
					$("div.scroll_nav").removeClass("scroll_nav_fixed");
				}
				$("h1.hot_route:gt(0)").each(
						function(i) {
							var scroll_top = $(this).offset().top
									- $(window).scrollTop();
							if (i > 0 && scroll_top >= 50) {
								return false;
							}
							$("div.scroll_nav ul li").eq(i).addClass("on")
									.siblings().removeClass("on");
						});
			}).trigger("scroll");
	$("div.scroll_nav ul li").bind(
			"click",
			function() {
				var index = $("div.scroll_nav ul li").index(this);
				index++;
				var scroll_height = $("h1.hot_route:eq(" + index + ")")
						.offset().top - 45;
				$(window).scrollTop(scroll_height);
			});

	$("input.verify").bind("focus", function() {
		var $img = $(this).next("img");
		var $this = this;
		var form = $($this.form);
		var imgpath = $(this).attr("imgpath");
		if ($img.length == 0) {
			$img = $("<img class='txt'>");
			$(this).after($img);
			$img.bind("click", function() {
				$img.attr("src", imgpath + "/r/" + Math.random());
				$this.validform_valid = false;
				form[0].p_validform.check(false, $this);
			}).trigger("click");
		}

	});
	$("#consult").bind("postAfter", function(event, data) {
		if (data.status != "y") {
			alert(data.info);
			return;
		}
		var lists_que = $("#lists_que");
		lists_que.find("span.down:first").html("&nbsp;").after(data.info);
		alert("您的咨询信息已经提交，请耐心等待回复");
	});

	$('#ei-slider').eislideshow({
		easing : 'easeOutExpo',
		titleeasing : 'easeOutExpo',
		titlespeed : 1200
	});
	for (var i = 0; i < 6; i++) {
		$("#go_time" + i).xl_calendar({
			data : jQuery.parseJSON($("#travel_price_list" + i).val()),
			serverurl : '',
			container : '#the_calendar' + i,
			index : i,
			select_callback : function() {
				$("#reserve").removeAttr("disabled");
			}
		});
		tebList.push(i);
	}

	$("#reserve")
			.bind(
					"click",
					function() {
						var start_date = $("#go_time").val();
						var start_test = /^\d{4}\-\d{2}\-\d{2}$/
								.test(start_date);
						if (!start_test) {
							$(".schedule_box").addClass("c_box");
							$("#go_time").trigger("focus");
							$(this).attr("disabled", "disabled");
							return;
						}
						var price_rackrate = $(".price_rackrate").html();
						var price_adult = $(".price_adult").html();
						var price_children = $(".price_children").html();
						if (price_rackrate == "--" || price_adult == "--"
								|| price_children == "--") {
							$(".schedule_box").addClass("c_box");
							$("#go_time").trigger("focus");
							$(this).attr("disabled", "disabled");
							return;
						}
						var adult_num = $("input[name='adult_num']").val();
						var children_num = $("input[name='children_num']")
								.val();
						if (!/^[1-9]\d?/.test(adult_num)
								&& !/^[1-9]\d?/.test(children_num)) {
							$(".schedule_box").addClass("c_box");
							$("input[name='adult_num']").trigger("focus");
							$(this).attr("disabled", "disabled");
							return;
						} else if (adult_num != 0
								&& !/^[1-9]\d?/.test(adult_num)) {
							$(".schedule_box").addClass("c_box");
							$("input[name='adult_num']").trigger("focus");
							$(this).attr("disabled", "disabled");
							return;
						} else if (children_num != 0
								&& !/^[1-9]\d?/.test(children_num)) {
							$(".schedule_box").addClass("c_box");
							$("input[name='children_num']").trigger("focus");
							$(this).attr("disabled", "disabled");
							return;
						}
						$(this.form).trigger("submit");
					});
	$("input[name='adult_num'],input[name='children_num']").bind("blur",
			function() {
				var adult_num = $("input[name='adult_num']").val();
				var this_num = $(this).val();
				console.log(this_num);
				if (!/^[1-9]\d?/.test(this_num) && this_num != 0) {
					$(this).val(0);
					return;
				}
				$("#reserve").removeAttr("disabled");
			}).trigger("blur");
	$(".minus").bind({
		"click" : function() {
			var num = parseInt($(this).siblings("input").val());
			if (num > 99 || num < 1) {
				num = 0;
			} else {
				num--;
			}
			$(this).siblings("input").val(num);
		},
		"mousedown" : function() {
			var $this = this;
			this._setInterval = setInterval(function() {
				$($this).trigger("click");
			}, 100)
		},
		"mouseup" : function() {
			clearInterval(this._setInterval);
		}
	});
	$(".plus").bind({
		"click" : function() {
			var num = parseInt($(this).siblings("input").val());
			if (num > 98 || num < 0) {
				num = 0;
			} else {
				num++;
			}
			$(this).siblings("input").val(num);
		},
		"mousedown" : function() {
			var $this = this;
			this._setTimeout = setTimeout(function() {
				$this._setInterval = setInterval(function() {
					$($this).trigger("click");
				}, 100)
			}, 800)

		},
		"mouseup" : function() {
			clearTimeout(this._setTimeout);
			clearInterval(this._setInterval);
		}
	});

});

function tabit(btn, n) {
	var idname = new String(btn.id);
	var s = idname.indexOf("_");
	var e = idname.lastIndexOf("_") + 1;
	var tabName = idname.substr(0, s);
	var id = parseInt(idname.substr(e));
	for (i = 0; i < n; i++) {
		document.getElementById(tabName + "_div_" + i).style.display = "none";
		document.getElementById(tabName + "_div_" + i).style.display = "none";
		document.getElementById("the_calendar" + i).style.display = "none";
		// document.getElementById("bbc_btn" + i).className = "none";
		$("#bbc_btn_" + i).removeClass('postion');
	}
	document.getElementById(tabName + "_div_" + id).style.display = "block";
	document.getElementById("the_calendar" + id).style.display = "block";
	btn.className = "postion";
	var exists = false;
	for (j = 0; j < tebList.length; j++) {
		if (tebList[j] == id) {
			exists = true;
		}
	}
	if (!exists) {
		$("#go_time" + id).xl_calendar({
			data : jQuery.parseJSON($("#travel_price_list" + id).val()),
			serverurl : '',
			container : '#the_calendar' + id,
			index : id,
			select_callback : function() {
				$("#reserve").removeAttr("disabled");
			}
		});
		tebList.push(id);
	}

};

function showTipsWindown(tit, url) {
	showclose();
	$.ajax({
		type : "POST",
		url : url,
		dataType : "html",
		success : function(html) {
			$("#bodys").html(html);
			$("#link_tit").html(tit);
		}
	});
}

function showclose() {
	$("#bodys").html("");
	$('#windownbg').hide();
}

function ajaxPost(t, url) {
	$.ajax({
		url : url,
		type : "POST",
		data : $(t).serialize(),
		dataType : "json",
		success : function(data) {
			if (data.status == "n") {
				alert(data.info);
				return;
			}
			if (data.status == "u") {
				showTipsWindown(data.info, data.data);
				$('#windownbg').show();
				return;
			}
		}
	});
	return false;
};

var setMoney = function() {
	var ends = $('#ends').val();
	var pnumber = $('#pnumber').val();
	var cnumber = $('#cnumber').val();
	var numrange = 1;
	var roomnum = $('#roomnum').val();
	if (pnumber == 1) {// 使用标准价钱
		numrange = 0;// 价格标准
	} else if (pnumber >= 2 && pnumber <= 3) {
		numrange = 1;
	} else if (pnumber >= 4 && pnumber <= 6) {
		numrange = 2;
	} else if (pnumber >= 7 && pnumber <= 9) {
		numrange = 3;
	} else if (pnumber >= 10 && pnumber <= 12) {
		numrange = 4;
	} else if (pnumber >= 13) {
		numrange = 5;
	}
	var datePriceList = jQuery.parseJSON($("#travel_price_list0").val());
	if (datePriceList[1]) {
		if (datePriceList[1][numrange] == null) {
			var alertmes = '';
			if (numrange == 0) {
				alertmes = '1人报价';
			} else if (numrange == 1) {
				alertmes = '2-3人报价';
			} else if (numrange == 2) {
				alertmes = '4-6人报价';
			} else if (numrange == 3) {
				alertmes = '7-9人报价';
			} else if (numrange == 4) {
				alertmes = '10-12人报价';
			} else {
				alertmes = '13人以上报价';
			}
			alert('系统中没有' + alertmes + '请拨打热线电话咨询');
			return;
		}
		var priceday = ends.substring(0, 4) + '' + ends.substring(5, 7) + ''
				+ ends.substring(8, 10);
		var existprice = false;
		for (i in datePriceList[1][numrange]) {
			if (priceday == i) {
				datePriceList[1][numrange][i];
				$('#crdj').html(datePriceList[1][numrange][i].price_adult);
				if (cnumber - 0 > 0) {
					$('#etdj').html(
							datePriceList[1][numrange][i].price_children);
				} else {
					$('#etdj').html('0');
				}

				$('#cryf').html(datePriceList[1][numrange][i].price_adultpre);
				if (cnumber - 0 > 0) {
					$('#etyf').html(
							datePriceList[1][numrange][i].price_childrenpre);
				} else {
					$('#etyf').html('0');
				}
				$('#creczf').html(datePriceList[1][numrange][i].price_adultec);
				if (cnumber - 0 > 0) {
					$('#eteczf').html(
							datePriceList[1][numrange][i].price_childrenec);
				} else {
					$('#eteczf').html('0');
				}

				$('#cryk').html(datePriceList[1][numrange][i].price_adultyk);
				// $('#etyk').html(datePriceList[1][numrange][i].price_childrenyk);

				$('#eczfz').html(
						(datePriceList[1][numrange][i].price_adultec * pnumber

						+ datePriceList[1][numrange][i].price_childrenec
								* cnumber));
				$('#ykz').html(
						(datePriceList[1][numrange][i].price_adultyk * pnumber

						+ datePriceList[1][numrange][i].price_childrenyk
								* cnumber));
				$('#ddhzf')
						.html(
								(datePriceList[1][numrange][i].price_adult
										* pnumber + datePriceList[1][numrange][i].price_children
										* cnumber)
										- (

										datePriceList[1][numrange][i].price_adultpre
												* pnumber + datePriceList[1][numrange][i].price_childrenpre
												* cnumber)

						);
				// 计算单房差
				var dfcz = 0;
				if (roomnum != null && roomnum != ''&&pnumber!=0) {
					var totalnum = pnumber * 1;
					var ytfjs = totalnum ;

					//if (totalnum % 2 > 0) {
					//	ytfjs = ytfjs - 0.5;
					//}
					var sjfjs = roomnum * 1;
					if (sjfjs*2 - ytfjs > 0) {
						dfcz = datePriceList[1][numrange][i].dfc
								* (sjfjs*2 - ytfjs);
					} else {
						var dfcz = 0;
					}
					if (dfcz != 0) {
						var dfcstr = datePriceList[1][numrange][i].dfc + 'x'
								+ ((sjfjs*2 - ytfjs) * 1) + '=' + dfcz
						$('#dfcz').html(dfcstr);
					} else {
						$('#dfcz').html(0);
					}

				}
				$('#ydzfz').html(
						(datePriceList[1][numrange][i].price_adultpre * pnumber

						+ datePriceList[1][numrange][i].price_childrenpre
								* cnumber)
								+ dfcz);

				$('#zfy')
						.html(
								(datePriceList[1][numrange][i].price_adult
										* pnumber + datePriceList[1][numrange][i].price_children
										* cnumber)
										+ dfcz);
				$('#qjsm').html('儿童标准（1.2米以下为儿童，儿童价格只含当地旅游车费和行程中所包含的餐费，超过1.2米的建议按成人报名）；单房差（酒店住宿都是按2人标准间核算的，如出现单人住一间房需补齐1间房费用，如不补单房差费用便默认和其他客人拼住一间房）。');
				existprice = true;
			}
		}
		if (existprice == false) {
			alert('' + ends + '不可预订,请拨打热线电话咨询 ！');
		}
	}
}