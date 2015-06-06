(function($) {
	$.fn
			.extend({
				xl_calendar : function(option) {
					var now_date = new Date();
					var defaults = {
						container : "",
						price_type : "#price_type",
						price_rackrate : ".price_rackrate",
						price_adult : ".price_adult",
						price_children : ".price_children",
						data : "",
						index : '',
						select_callback : function() {
						},
						serverurl : "",
						date_section : 7
					}
					var options = $.extend(defaults, option);
					var month = now_date.getMonth() + 1;
					var year = now_date.getFullYear();
					var max_year = now_date.getFullYear();
					var max_month = month + parseInt(options.date_section);
					if (max_month > 12) {
						max_month = max_month - 12;
						max_year++;
					}
					month = month < 10 ? "0" + month.toString() : month;
					options.min_date = year.toString() + month.toString();
					max_month = max_month < 10 ? "0" + max_month.toString()
							: max_month;
					options.max_date = max_year.toString()
							+ max_month.toString();
					// options.container=options.container+options.data.index;
					var header = '<table>'
							+ '<tr class="the_calendar_on"><td class="the_calendar_icon"><b style="width:152px;height: 34px;"></b></td>'
							+ '<td class="the_calendar_month"><span class="the_calendar_font"> <i class="year"></i> 年 <i class="month"></i> 月</span></td>'
							+ '<td  class="the_calendar_icon2"><b></b></td></tr>'
							+ '</table>'
					// header += '<div class="the_calendar_center"><span
					// class="the_calendar_weekend">周日</span><span
					// class="the_calendar_day"
					// style="border-left:0px;">周一</span><span
					// class="the_calendar_day">周二</span><span
					// class="the_calendar_day">周三</span><span
					// class="the_calendar_day" >周四</span><span
					// class="the_calendar_day" >周五</span><span
					// class="the_calendar_weekend"
					// style="width:90px;">周六</span></div><div
					// class="the_calendar_down"><table width="550" border="1"
					// class="calendar_list"></table></div>';
					header += '<div class="the_calendar_down"><table width="550" border="1" class="calendar_list"></table></div>';
					/**
					 * 加载数据
					 */
					var write_data = function(data) {
						var table = $("" + options.container
								+ " table.calendar_list");
						var data_detail = {}
						if (data[4]) {
							data_detail = {
								"data-type" : 4,
								"rackrate" : data[4]["RACKRATE"],
								"price_adult" : data[4]["price_adult"],
								"price_children" : data[4]["price_children"]
							}
							table.find("td.day span.price").html(
									"￥" + parseFloat(data[4]["price_adult"]))
									.addClass("date_price4").attr(data_detail);
						}
						if (data[3]) {
							for (i = 1; i <= 7; i++) {
								if (data[3][i]) {
									data_detail = {
										"data-type" : 3,
										"rackrate" : data[3][i]["RACKRATE"],
										"price_adult" : data[3][i]["price_adult"],
										"price_children" : data[3][i]["price_children"]
									}
									table
											.find(
													"td.day[data-week='" + i
															+ "'] span.price")
											.html(
													"￥"
															+ parseFloat(data[3][i]["price_adult"]))
											.removeClass("date_price4")
											.addClass("date_price3").attr(
													data_detail);
								}
							}
						}
						if (data[2]) {
							var matchs = {};
							var data_month = parseInt(table.attr("data-month"));
							var min_day = -1, max_day = -1;
							var now_day = "";
							var month_day = new Date(year, month, 0).getDate();
							for (i in data[2]) {
								matchs = i
										.match(/(\d{6})(\d{2})\_(\d{6})(\d{2})/);
								if (parseInt(matchs[1]) > data_month
										|| parseInt(matchs[3]) < data_month) {
									continue;
								}
								min_day = (parseInt(matchs[1]) == data_month) ? parseInt(matchs[2])
										: 1;
								max_day = (parseInt(matchs[3]) == data_month) ? parseInt(matchs[4])
										: month_day;

								for (min_day; min_day <= max_day; min_day++) {
									now_day = min_day < 10 ? "0"
											+ min_day.toString() : min_day
											.toString();
									now_day = data_month.toString() + now_day;
									data_detail = {
										"data-type" : 2,
										"rackrate" : data[2][i]["RACKRATE"],
										"price_adult" : data[2][i]["price_adult"],
										"price_children" : data[2][i]["price_children"]
									}
									table
											.find(
													"td.day[data-day='"
															+ now_day
															+ "'] span.price")
											.html(
													"￥"
															+ parseFloat(data[2][i]["price_adult"]))
											.removeClass(
													"date_price4 date_price3")
											.addClass("date_price2").attr(
													data_detail);
								}
							}
						}
						if (data[1]) {
							if (data[1][options.index]) {
								var data_month = parseInt(table
										.attr("data-month"));
								var matchs = {};
								for (i_1 in data[1][options.index]) {
									matchs = i_1.match(/(\d{6})(\d{2})/);
									// if (parseInt(matchs[1]) > data_month ||
									// parseInt(matchs[3]) < data_month) {
									// continue;
									// }
									data_detail = {
										"data-type" : 1,
										"rackrate" : data[1][options.index][i_1]["RACKRATE"],
										"price_adult" : data[1][options.index][i_1]["price_adult"],
										"price_children" : data[1][options.index][i_1]["price_children"]
									}
									table
											.find(
													"td.day[data-day='" + i_1
															+ "'] span.price")
											.html(
													"<br><a href=\"javascript:void(0);\">￥"
															+ parseFloat(data[1][options.index][i_1]["price_adult"])
															+ "</a>")
											.removeClass(
													"date_price4 date_price3 date_price2")
											.addClass("date_price1").attr(
													data_detail);
									table
											.find(
													"td.day[data-day='" + i_1
															+ "']").mouseover(
													function() {
														$(this).css(
																"background",
																"#ffebee");
													});
									table
											.find(
													"td.day[data-day='" + i_1
															+ "']").mouseout(
													function() {
														$(this).css(
																"background",
																"#fff");
													});
									table.find(
											"td.day[data-day='" + i_1
													+ "'] span.price")
											.mouseover(
													function() {
														$(this).css(
																"background",
																"#ffebee");
													});
									
									table.find(
											"td.day[data-day='" + i_1
													+ "'] span.price")
											.mouseout(
													function() {
														$(this).css(
																"background",
																"#fff");
													});
												
									table
											.find(
													"td.day[data-day='" + i_1
															+ "']")
											.removeClass('noprice');

								}
							}

						}
						table.find("td.day.disable span.price").empty();

					}
					/**
					 * 创建日历表
					 */
					var create_month = function(year, month) {
						var data_month = year.toString() + month.toString();
						if (parseInt(data_month) > parseInt(options.max_date)
								|| parseInt(data_month) < parseInt(options.min_date)) {
							return false;
						}

						$(options.container).find("i.year").html(year);
						$(options.container).find("i.month").html(
								parseInt(month));
						var max_day = new Date(year, month, 0).getDate();
						var one_day = new Date(year, month - 1, 1).getDay();
						var first_day = 0;
						var table_str = '<tbody data-month="'
								+ data_month
								+ '"><tr><td style="background: #cef0f1;text-align:center;color:#f00;">周日</td><td style="background: #cef0f1;text-align:center;">星期一</td><td style="background: #cef0f1;text-align:center;">星期二</td><td style="background: #cef0f1;text-align:center;">星期三</td><td style="background: #cef0f1;text-align:center;">星期四</td><td style="background: #cef0f1;text-align:center;">星期五</td><td style="background: #cef0f1;text-align:center;color:#f00;">星期六</td></tr><tr>';

						var key = "";
						while (first_day < one_day) {
							table_str += '<td   class="not_day noprice"><span></span></td>';
							first_day++;
						}
						var day = 0, week = 0, disable = '';
						for (i = 1; i <= max_day; i++) {
							first_day = (first_day == 7) ? 0 : first_day;
							if (first_day == 0) {
								table_str += '</tr><tr>';
							}
							day = i < 10 ? "0" + i.toString() : i.toString()
							key = data_month + day;
							week = first_day == 0 ? 7 : first_day;
							disable = parseInt(options.now_day) > parseInt(key) ? " disable"
									: "";
							table_str += '<td    class="day noprice' + disable
									+ '" data-day="' + key + '" data-week="'
									+ week + '"><span style="float:left;">' + i
									+ '</span><span class="price"></span></td>';
							first_day++;
						}
						while (first_day <= 6) {
							table_str += '<td   class="not_day noprice"><span class="not_day"></span></td>';
							first_day++;
						}
						table_str += "<tr></tbody>";
						var return_obj = $(table_str)
						return return_obj;
					}
					/**
					 * 上一个月
					 */
					var prew_month = function() {

						var y = $(options.container).find("i.year").html();
						var m = $(options.container).find("i.month").html();
						m--;
						y = (m == 0) ? parseInt(y) - 1 : y;
						m = (m == 0) ? 12 : m;
						m = (m < 10) ? "0" + m.toString() : m.toString();
						var pr_month = y.toString() + m;
						var mon_obj = create_month(y, m);
						if (mon_obj !== false) {
							$(
									"#the_calendar" + options.index
											+ " table.calendar_list").html(
									mon_obj).attr("data-month", pr_month);
							write_data(options.data);
						}
						$(
								"" + options.container
										+ " table.calendar_list td.day").bind(
								"click", td_click);
					}
					/**
					 * 下一个月
					 */
					var next_month = function() {
						var y = $(options.container).find("i.year").html();
						var m = $(options.container).find("i.month").html();
						m++;
						y = (m == 13) ? parseInt(y) + 1 : y;
						m = (m == 13) ? 1 : m;
						m = (m < 10) ? "0" + m.toString() : m.toString();
						var next_month = y.toString() + m;
						var mon_obj = create_month(y, m);
						if (mon_obj !== false) {
							$(
									"#the_calendar" + options.index
											+ " table.calendar_list").html(
									mon_obj).attr("data-month", next_month);
							write_data(options.data);
						}
						$(
								"" + options.container
										+ " table.calendar_list td.day").bind(
								"click", td_click);
					}
					/**
					 * td鼠标点击事件
					 */
					var td_click = function() {
						var day = $(this).attr("data-day").match(
								/(\d{4})(\d{2})(\d{2})/);
						if ($(this).hasClass("disable")) {
							alert("今天以前的日期不可预订！");
							return false;
						}
						var data_type = {
							"1" : "指定日期价",
							"2" : "阶段价",
							"3" : "星期价",
							"4" : "普通价"
						}
						var now_detail = $(this).find("span.price");
						var price_type = data_type[now_detail.attr("data-type")], price_adult = parseFloat(now_detail
								.attr("price_adult")), price_rackrate = parseFloat(now_detail
								.attr("rackrate")), price_children = parseFloat(now_detail
								.attr("price_children"));
						if (!price_adult || !price_type || !price_children) {
							// atr_alert("对不起，此日期不是团期！");
							return false;
						}
						$($this).val(day[1] + "-" + day[2] + "-" + day[3]);
						submitorder(day[1], day[2], day[3], options.index);
						$(options.price_type).html(price_type);
						$(options.price_adult).html(price_adult);
						$(options.price_rackrate).html(price_rackrate);
						$(options.price_children).html(price_children);
						options.select_callback(price_type, price_rackrate,
								price_adult, price_children);
						$(options.container).trigger("blur");
					}

					/**
					 * 初始化表格
					 */
					var init = function() {
						var init_val = $(this).val().match(
								/^(\d{4})\-(\d{2})\-(\d{2})$/);
						$(options.container).prepend(header);
						if (typeof (options.data) == "string"
								&& $.trim(options.data) != "") {
							options.data = $.ajax({
								type : "GET",
								url : options.data,
								async : false
							}).responseText;
							try {
								options.data = jQuery.parseJSON(options.data);
							} catch (ex) {
								options.data = {};
							}
						}
						var dd = new Date();
						var y = dd.getFullYear();
						var m = dd.getMonth() + 1;
						var day = dd.getDate();
						m = (m < 10) ? "0" + m.toString() : m.toString();
						day = (day < 10) ? "0" + day.toString() : day
								.toString();
						var now_month = y.toString() + m;
						options.now_day = now_month + day.toString();
						var create_months, now_day;
						if (init_val
								&& (create_months = create_month(init_val[1],
										init_val[2]))) {
							now_month = init_val[1].toString()
									+ init_val[2].toString();
							now_day = now_month + init_val[3].toString();
						} else {
							create_months = create_month(y, m);
							now_day = options.now_day;
							$(this).val(y.toString() + "-" + m + "-" + day);
						}
						$("" + options.container + " table.calendar_list")
								.html(create_months).attr("data-month",
										now_month);
						write_data(options.data);
						$("" + options.container + " .the_calendar_icon b")
								.bind("click", prew_month);
						$("" + options.container + " .the_calendar_icon2 b")
								.bind("click", next_month);
						$(
								"" + options.container
										+ " table.calendar_list td.day").bind(
								"click", td_click);
					}

					var $this = this;
					init.call(this);
					$(this).bind("click", function() {
						$(options.container).trigger("focus");
					});
				}
			});

})(jQuery);