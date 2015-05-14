(function($) {
	$.fn
			.extend({
				linePlan : function(options) {
					var opt = $.extend({
						srcId : "day_1",// 源html的id
						conId : "day_",// 内容html的id前缀
						conClass : "line_day",// 内容html的id前缀
						dayId : "qh_day",
						lineRowSub : "lineRowSub",
						lineRowText : "lineRowText",
						maxText : 10,// 最多可添加段数
						data : ""
					}, options);
					opt.srcObj = $("#" + opt.srcId).clone();
					opt.kind = {};
					var thisObj = this;

					// 改变天数时行程安排的天数也跟着改变
					/*
					$(thisObj).bind("change", function() {
						var day = $(this).val();
						tripplan(day);
					});*/
					
					$(thisObj).blur(function() {
						var day = $(this).val();
						tripplan(day);
					});
					// 当形成天数发生变化时候

					var tripplan = function(day) {
						// alert(day);
						var dayreg = /^[1-9]\d*$/;
						var oldday = $("#" + opt.dayId ).val();
						if (dayreg.test(day)) {
							var d = parseInt(day) + 1;
							if (oldday > day) {
								var ismin = confirm("您输入的天数比原来的天数小，这将会删除第" + d
										+ "天以后的数据，你确定修改吗");
								if (!ismin) {
									$(this).val(oldday);
									return false;
								} else {
									var countday = 0;
									for (var di = d; di <= oldday; di++) {
										countday = $("#" + opt.conId + di).length;
										if (countday)
											$("#" + opt.conId + di).remove();
									}
								}
							}
							//$("#" + opt.dayId).empty();
							var opstr = '';
							for (var i = 1; i <= day; i++) {
								// opstr += "<option value='" + i + "'>第" + i +
								// "天</option>";
								var get_day = opt.get_day(i);
								get_day.show();
							}
							$('#'+ opt.dayId).val(day);
							// $("#" + opt.dayId).append(opstr);
						} else {
							$(this).val(day.replace(/[^\d]/g, ""));
						}

					};

					// 获取指定天数的对象
					opt.get_day = function(day) {
						var now_day = $("#" + opt.conId + day);
						if (now_day.length == 1) {
							return now_day;
						}
						var $Obj = opt.srcObj.clone();
						var html = $Obj.html();
						html = html.replace(/第\d*天/g, "第" + day + "天");
						html = html.replace(/title_\d*/g, "title_" + day);
						html = html.replace(/title_\d*/g, "title_" + day);
						html = html.replace(/dining_\d*/g, "dining_" + day);
						html = html.replace(/stay_\d*/g, "stay_" + day);
						html = html.replace(/ActivityTitle_\d*/g,
								"ActivityTitle_" + day);
						html = html.replace(/ActivityTitle_\d*/g,
								"ActivityTitle_" + day);
						html = html.replace(/TravelText_\d*/g, "TravelText_"
								+ day);
						html = html.replace(/container_\d*/g, "container_"
								+ day);
						html = html.replace(/activity_title_\d*/g,
								"activity_title_" + day);
						html = html.replace(/activity_text_\d*/g,
								"activity_text_" + day);
						$Obj.attr("id", opt.conId + day);
						$Obj.html(html);
						$("#Classical").append($Obj);
						opt.showkind();
						return $Obj;
					}
					// 获取段数
					opt.get_con = function(con_obj, n) {
						var pid = con_obj.attr("id");
						var day = pid.split("_");
						var lists = con_obj.find("li:gt(1)");
						if (n == -1 || n == 0) {
							n = lists.length;
						}
						var li = lists[n - 1];
						if (li) {
							var tables = $("#TravelText_" + day[1] + ">table");
							var table_selected = $("#" + "container_" + day[1]
									+ "_" + n);
							return {
								lists : lists,
								li : li,
								tables : tables,
								table_selected : table_selected
							}
						} else {
							var create_li = $("<li class='yes'>第<b>" + n
									+ "</b>段</li>");
							con_obj.append(create_li);
							var consrc = opt.srcObj.find(
									".lineRowText table:first").clone();
							var html = consrc.html();
							html = html.replace(/activity_title_\d*_\d*/g,
									"activity_title_" + day[1] + "_" + n);
							html = html.replace(/activity_text_\d*_\d*/g,
									"activity_text_" + day[1] + "_" + n);
							html = html.replace(/第\d*天第\d*段/g, "第" + day[1]
									+ "天第" + n + "段");
							consrc.attr("id", "container_" + day[1] + "_" + n);
							consrc.html(html);
							$("#TravelText_" + day[1]).append(consrc);
							opt.showkind();
							return {
								lists : con_obj.find("li:gt(1)"),
								li : create_li,
								tables : $("#TravelText_" + day[1] + ">table"),
								table_selected : consrc
							}
						}
					}
					// 选择天数时改变内容
					$("#" + opt.dayId).bind("change", function() {
						var day = $(this).val();
						// $("." + opt.conClass + ":visible").hide();
						// var get_day = opt.get_day(day);
						// get_day.show();
					});
					// 添加段数
					$(".add-con").live("click", function(event) {
						var pObj = $(this).parents("ul");
						var pid = pObj.attr("id");
						var day = pid.split("_");
						var n = $(this).parents("ul").find("li:last b").text();
						n++;
						if (n > opt.maxText) {
							alert("最多可以添加的段数为" + opt.maxText);
							return false;
						}
						var con = opt.get_con(pObj, n);
						con.lists.removeClass("yes");
						con.li.addClass("yes");
						con.tables.hide();
						con.table_selected.show();
						event.stopPropagation();
					});

					// 删除段数
					$(".del-con")
							.live(
									"click",
									function(event) {
										var pObj = $(this).parents("ul");
										var pid = pObj.attr("id");
										var day = pid.split("_");
										var n = $(this).parents("ul").find(
												"li:last b").text();
										if (n <= 1) {
											alert("至少保留一段");
											return false;
										}
										var isdel = confirm("您将删除第"
												+ n
												+ "段，一旦删除，会使该段原先编辑的数据也跟着删除，确定删除吗");
										if (!isdel) {
											return false;
										}
										$(this).parents("ul").find("li:last")
												.remove();
										$("#container_" + day[1] + "_" + n)
												.remove();
										delete opt.kind["kind_activity_text_"
												+ day[1] + "_" + n];
										var cur = $(this).parents("ul").find(
												"li.yes").length;
										if (cur == 0) {
											$(this).parents("ul").find(
													"li:last").addClass("yes");
											$(
													"#" + "container_" + day[1]
															+ "_" + (n - 1))
													.show();
										}
										event.stopPropagation();
									});
					$("." + opt.lineRowSub + " li:gt(1)").live(
							"click",
							function() {
								var n = $(this).find("b").text();
								$(this).parent().find("li.yes").removeClass(
										"yes");
								$(this).addClass("yes");
								var pObj = $(this).parents("ul");
								var pid = pObj.attr("id");
								var day = pid.split("_");
								$("#TravelText_" + day[1] + " table:visible")
										.hide();
								$("#container_" + day[1] + "_" + n).show();
							});

					opt.showkind = function() {
						$(".linePlan-text").each(
								function() {
									var id = "kind_" + $(this).attr("id");
									if (!(id in opt.kind)) {
										opt.kind[id] = KindEditor.create(this,
												$.extend(KindEditor.options, {
													editorid : id,
													width : 700,
													height : 350
												}));
									}
								});
					}

					opt.getAjax = function() {
						var html='';
						var reult = $.ajax({
							url : opt.data,
							async : false,
			               // dataType: 'json',
			               // type: 'post',
			               // data: { question: 1 },
			                success: function(result) {
			                   // alert(result);
			                	html=result;
			                   
			                }
			            });
						return html;
						/*
						var html = $.ajax({
							url : opt.data,
							async : false
						}).responseText;
					
					  alert(html);
						try {
							return jQuery.parseJSON(html);
						} catch (e) {
							return {};
						}
						*/
						
					}
					// 初始化
					var init = function() {
						if (opt.data == "") {
							opt.showkind();
							return;
						}
						//$("#" + opt.dayId).empty();
						var opstr = '';
						var init_day = $(thisObj).val();
						for (var i = 1; i <= init_day; i++) {
							opstr += "<option value='" + i + "'>第" + i
									+ "天</option>";
						}
						//$("#" + opt.dayId).append(opstr);
						var cons;
						var data = opt.getAjax();
						
						for ( var day in data) {
							opt.get_day(day);
							cons = data[day];
							$("#title_" + day).val(cons["title"]);
							$("#stay_" + day).val(cons["stay"]);
							for ( var d in cons["dining"]) {
								$("#dining_" + day + "_" + cons["dining"][d])
										.attr("checked", "checked");

							}
							for ( var n in cons["con"]) {
								opt.get_con($("#ActivityTitle_" + day), n);
								$("#activity_title_" + day + "_" + n).val(
										cons["con"][n]["title"]);
								$("#activity_text_" + day + "_" + n).val(
										cons["con"][n]["content"]);
							}
						}
						//$("." + opt.conClass).hide();
						$("." + opt.conClass + ":first").show();
						//$(".lineRowText>table").hide();
						var text = $(".lineRowText");
						text.each(function() {
							$(this).children("table:first").show();
						});
						var lineRowSub = $(".lineRowSub");
						lineRowSub.each(function() {
							$(this).children("li").removeClass("yes");
							$(this).children("li:eq(2)").addClass("yes");
						});
						opt.showkind();
					}
					init();
				}
			});
})(jQuery)
