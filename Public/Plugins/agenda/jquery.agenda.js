(function($) {
	$.fn
			.extend({
				agenda : function(options) {
					var now_date = new Date();
					var defaults = {
						data : "",
						close_btn : "/Public/Plugins/agenda/images/toolsDells.png",
						display : [ 0 ],
						min_date : (now_date.getFullYear() - 1) + "01",
						max_date : (now_date.getFullYear() + 1) + "12"
					}
					var options = $.extend(defaults, options);
					var obj = $(".agenda_box", this);
					if (obj.length == 0) {
						obj = $("<div class='agenda_box' style=\"float:left;\"></div>");
						$(this).append(obj);
					}
					var alert_box = '<div date="" class="linePopPrice" style="z-index: 99999">'
							+ '<div class="linePopPriceTit"><b></b> <span> '
							+ '<img width="17" height="17" class="alert_box_close" src="'
							+ options.close_btn
							+ '" alt="关闭"></span></div>'
							+ '<div class="linePopPriceText">门市价：'
							+ '<input type="text" size="9" maxlength="9" onkeyup="this.value=this.value.replace(/\D/g,\'\');" class="formTitle" id="Price0"><br>'
							+ '成人价：<input type="text" size="9" maxlength="9" onkeyup="this.value=this.value.replace(/\D/g,\'\');" class="formTitle" id="Price1"><br>'
							+ '儿童价：<input type="text" size="9" maxlength="9" onkeyup="this.value=this.value.replace(/\D/g,\'\');" class="formTitle" id="Price2">'
							+ ' <div class="linePopPriceEnd">'
							+ '<input type="button" value="确定" class="formInput01"></div></div>';
					alert_box = $(alert_box);
					alert_box.hide()
					$("body").prepend(alert_box);
					$(".alert_box_close", alert_box).click(function() {
						alert_box.hide();
					});
					obj.empty();
					var obj_title = '<div class="agenda_title"><label class="title_left"></label>'
							+ '<span><label class="agenda_y"></label>年<label class="agenda_m"></label>月'
							+ ' <label class="agenda_d"></label>日</span><label class="title_right">'
							+ '</label></div>';
					var obj_table = '<table class="table_date" cellspacing="0" cellpadding="0" border="0">'
							+ '<thead><tr class="week"><td class="td_holiday"><div class="box" style="width: 72px;height: 45px; position: relative;"><span class="week" style="position: absolute;top: 15px;left: 17px;">周日</span><span data-idx="0" class="js_checkbox_checkrows select_box js_checkbox hide" style="display: inline;position: absolute;right: 6px;top: 16px;"><input type="checkbox" id="0"></span></div></td><td><div class="box" style="width: 72px;height: 45px; position: relative;"><span class="week" style="position: absolute;top: 15px;left: 17px;">周一</span><span data-idx="1" class="js_checkbox_checkrows select_box js_checkbox hide" style="display: inline;position: absolute;right: 6px;top: 16px;"><input type="checkbox" id="1"></span></div></td><td><div class="box" style="width: 72px;height: 45px; position: relative;"><span class="week" style="position: absolute;top: 15px;left: 17px;">周二</span><span data-idx="2" class="js_checkbox_checkrows select_box js_checkbox hide" style="display: inline;position: absolute;right: 6px;top: 16px;"><input type="checkbox" id="2"></span></div></td>'
							+ '<td><div class="box" style="width: 72px;height: 45px; position: relative;"><span class="week" style="position: absolute;top: 15px;left: 17px;">周三</span><span data-idx="3" class="js_checkbox_checkrows select_box js_checkbox hide" style="display: inline;position: absolute;right: 6px;top: 16px;"><input type="checkbox" id="3"></span></div></td><td><div class="box" style="width: 72px;height: 45px; position: relative;"><span class="week" style="position: absolute;top: 15px;left: 17px;">周四</span><span data-idx="4" class="js_checkbox_checkrows select_box js_checkbox hide" style="display: inline;position: absolute;right: 6px;top: 16px;"><input type="checkbox" id="4"></span></div></td><td><div class="box" style="width: 72px;height: 45px; position: relative;"><span class="week" style="position: absolute;top: 15px;left: 17px;">周五</span><span data-idx="5" class="js_checkbox_checkrows select_box js_checkbox hide" style="display: inline;position: absolute;right: 6px;top: 16px;"><input type="checkbox" id="5"></span></div></td><td class="td_holiday"><div class="box" style="width: 72px;height: 45px; position: relative;"><span class="week" style="position: absolute;top: 15px;left: 17px;">周六</span><span data-idx="6" class="js_checkbox_checkrows select_box js_checkbox hide" style="display: inline;position: absolute;right: 6px;top: 16px;"><input type="checkbox" id="6"></span></div></td></tr></thead>'
							+ '</table>';
					obj.append(obj_title).append(obj_table);

					var td_click = function() {
						var pos = $(this).position();
						var name = $(this).find("input").attr("name");
						var value = $(this).find("input").val();
						var date = name.match(/\[(\d{4})(\d{2})(\d{2})\]/);
						alert_box.attr("date", date[1] + date[2] + date[3]);
						alert_box.find(".linePopPriceTit b").text(
								date[1] + "-" + date[2] + "-" + date[3]);
						var values = value.split(",");
						$("#Price0").val(values[0] ? values[0] : 0);
						$("#Price1").val(values[1] ? values[1] : 0);
						$("#Price2").val(values[2] ? values[2] : 0);
						alert_box.css({
							top : pos.top + 30,
							left : pos.left
						});
						// alert_box.show();
					}

					// 创建日历
					var create_month = function(year, month) {
						$('#year').val(year);
						$('#month').val(month);
						var data_month = year.toString() + month.toString();
						if (parseInt(data_month) > options.max_date
								|| parseInt(data_month) < options.min_date) {
							return false;
						}
						var max_day = new Date(year, month, 0).getDate();
						var one_day = new Date(year, month - 1, 1).getDay();
						var first_day = 0;
						// var table_str = '<tbody data-month="' + data_month
						// + '"><tr>';
						var table_str = '<tbody><tr>';
						var key = "";
						while (first_day < one_day) {
							table_str += '<td class="not_day"><span></span></td>';
							first_day++;
						}
						var day = 0;
						// 从后台获取这个月的价钱列表;
						var pricelist = '';
						var tempnumrange = $('#sel_numrange').val();
						var reult = $.ajax({
							url : options.data.url,
							async : false,
							data : {
								numrange1 : tempnumrange,
								year : year,
								month : month,
								line_id : $('#line_id').val()
							},
							success : function(result) {
								pricelist = result;

							},
							error : function(errorobj) {
								pricelist = null;
							}
						});
						//
						for (i = 1; i <= max_day; i++) {
							first_day = (first_day == 7) ? 0 : first_day;
							if (first_day == 0) {
								table_str += '</tr><tr>';
							}
							day = i < 10 ? "0" + i.toString() : i.toString()
							key = data_month + day;
							var pricehtml = '';
							if (pricelist != null) {
								for ( var dataprice in pricelist) {
									if (pricelist[dataprice].day == i) { // 如果有价钱则吸入表格中
										// 生成一个价格信息div
										var uldiv = $('<div></div>');
										var ulbox = $('<ul>');
										ulbox
												.append($('<li>')
														.text(
																'¥'
																		+ pricelist[dataprice].price_adult));
										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_price_adult')
														.val(
																pricelist[dataprice].price_adult));

										//
										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_price_adultpre')
														.val(
																pricelist[dataprice].price_adultpre));
										//

										//
										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_price_adultec')
														.val(
																pricelist[dataprice].price_adultec));
										//
										//
										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_price_adultyk')
														.val(
																pricelist[dataprice].price_adultyk));
										//

										ulbox
												.append($('<li>')
														.text(
																'¥'
																		+ pricelist[dataprice].price_children));
										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_price_children')
														.val(
																pricelist[dataprice].price_children));
										//
										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_price_childrenpre')
														.val(
																pricelist[dataprice].price_childrenpre));
										//

										//
										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_price_childrenec')
														.val(
																pricelist[dataprice].price_childrenec));
										//

										//
										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_price_childrenyk')
														.val(
																pricelist[dataprice].price_childrenyk));
										//

										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_room_type')
														.val(
																pricelist[dataprice].room_type));

										ulbox.append($('<input>').attr('type',
												'hidden').attr('id',
												'day' + key + '_dfc').val(
												pricelist[dataprice].dfc));

										ulbox.append($('<input>').attr('type',
												'hidden').attr('id',
												'day' + key + '_numrange').val(
												pricelist[dataprice].numrange));
										//
										ulbox
												.append($('<input>')
														.attr('type', 'hidden')
														.attr(
																'id',
																'day'
																		+ key
																		+ '_desc')
														.val(
																pricelist[dataprice].price_desc));

										var persontext = '';
										if (pricelist[dataprice].numrange == 6) {
											persontext = '1人';
										} else if (pricelist[dataprice].numrange == 1) {
											persontext = '2-3人';
										} else if (pricelist[dataprice].numrange == 2) {
											persontext = '4-6人';
										} else if (pricelist[dataprice].numrange == 3) {
											persontext = '7-9人';
										} else if (pricelist[dataprice].numrange == 4) {
											persontext = '10-12人';
										} else if (pricelist[dataprice].numrange == 5) {
											persontext = '13人';
										} else if (pricelist[dataprice].numrange == 0) {
											persontext = '不区分人数';
										} else {
											persontext = '13人';
										}
										ulbox
												.append($('<li>').text(
														persontext));
										ulbox.append($('<input>').attr('type',
												'hidden').attr('id',
												'day' + key + '_numrage').val(
												pricelist[dataprice].numrange));
										uldiv.append(ulbox);
										pricehtml = uldiv.html();
										break;
									}
								}
							}
							table_str += '<td  class="day"><input type="hidden" name="day_val['
									+ key
									+ ']"><span>'
									+ i
									+ '</span><span class="js_checkbox_checkrows_'
									+ first_day
									+ ' js_checkbox select_box hide"  style="display: inline;"><input type="checkbox" data-id="'
									+ key + '"></span>' + pricehtml + '</td>';
							first_day++;
						}
						while (first_day <= 6) {
							table_str += '<td  class="not_day"><span class="not_day"></span></td>';
							first_day++;
						}
						table_str += "<tr></tbody>";

						var return_obj = $(table_str)
						// obj.find("table.table_date").empty();
						obj.find("table.table_date ").append(return_obj);
						seldayes = new Array();
						return return_obj;
					}

					$(".formInput01", alert_box)
							.click(
									function() {
										var p1 = $("#Price0").val();
										var p2 = $("#Price1").val();
										var p3 = $("#Price2").val();
										var date = alert_box.attr("date");
										var dates = date
												.match(/(\d{4})(\d{2})(\d{2})/);
										write_data(dates[1], dates[2],
												dates[3], [ p1, p2, p3 ]);
										alert_box.hide();
									});
					// 上个月
					var prew_month = function() {
						var y = parseInt(obj.find(".agenda_y").text());
						var m = parseInt(obj.find(".agenda_m").text());
						m--;
						y = (m == 0) ? y - 1 : y;
						m = (m == 0) ? 12 : m;
						m = (m < 10) ? "0" + m.toString() : m.toString();
						var pr_month = y.toString() + m;
						var pr_month_obj = obj.find("tbody[data-month='"
								+ pr_month + "']");
						if (pr_month_obj.length == 0)
							pr_month_obj = create_month(y, m);
						if (pr_month_obj !== false) {
							// create_month(y, m);
							alert_box.hide();
							pr_month_obj.show().siblings("tbody").empty();
							obj.find(".agenda_y").text(y);
							obj.find(".agenda_m").text(parseInt(m));
						}
						initevent();
					}
					var next_month = function() {
						var y = parseInt(obj.find(".agenda_y").text());
						var m = parseInt(obj.find(".agenda_m").text());
						m++;
						y = (m == 13) ? y + 1 : y;
						m = (m == 13) ? 1 : m;
						m = (m < 10) ? "0" + m.toString() : m.toString();
						var next_month = y.toString() + m;
						var mext_month_obj = obj.find("tbody[data-month='"
								+ next_month + "']");
						if (mext_month_obj.length == 0)
							mext_month_obj = create_month(y, m);
						if (mext_month_obj !== false) {
							// create_month(y, m);
							// alert_box.hide();
							mext_month_obj.show().siblings("tbody").empty();
							obj.find(".agenda_y").text(y);
							obj.find(".agenda_m").text(parseInt(m));
						}
						initevent();
					}

					// 获取数据值
					var get_vallist = function(data) {
						var str = ""
						for (i in options.display) {
							str += "<label class='td_price'>￥"
									+ data[options.display[i]] + "</label>";
						}
						return str;
					}

					// 把数据写到对应的日期中
					var write_data = function(year, month, day, data) {
						var data_month = year.toString() + month.toString();
						var month_obj = obj.find("tbody[data-month='"
								+ data_month + "']");
						if (month_obj.length == 0) {
							month_obj = create_month(year, month);
						}
						if (month_obj === false) {
							return;
						}
						var key = data_month + day.toString();
						var input = $("input[name='day_val[" + key + "]']");
						input.val(data.join(","));
						var td = input.parent();
						/*
						 * var close_btn = td.find(".vallist_del"); if
						 * (close_btn.length == 0) { close_btn = $('<img
						 * class="vallist_del" src="' + options.close_btn + '"
						 * alt="关闭">'); td.prepend(close_btn); }
						 */
						var dataval = td.find(".dataval");
						if (dataval.length == 0) {
							dataval = $('<div class="dataval"></div>');
							td.append(dataval);
						}
						var vallist = get_vallist(data);
						dataval.html(vallist);
					}
					// 初始化
					var init = function() {
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
						var m = "";
						for (d in options.data) {
							m = d
									.match(/^((?:19|20)\d\d)(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])$/);
							if (m) {
								write_data(m[1], m[2], m[3], options.data[d]);
							}
						}
						var dd = new Date();
						var y = dd.getFullYear();
						var m = dd.getMonth() + 1;
						var day = dd.getDate();
						this.find(".agenda_y").text(y);
						this.find(".agenda_m").text(m);
						this.find(".agenda_d").text(day);
						m = (m < 10) ? "0" + m.toString() : m.toString();
						var now_month = y.toString() + m;

						var now_month_obj = this.find("tbody[data-month='"
								+ now_month + "']");
						if (now_month_obj.length == 0)
							now_month_obj = create_month(y, m);
						now_month_obj.show().siblings("tbody").empty();
					}
					init.call(obj);
					obj.find(".title_left").bind("click", prew_month);
					obj.find(".title_right").bind("click", next_month);
					$("td.day", obj[0]).live("click", td_click);
					$(".vallist_del", obj[0]).live("click", function(e) {
						$(this).siblings("input").val("");
						$(this).siblings("div").hide();
						$(this).hide();
						e.stopPropagation();
					})
					var initevent = function() {
						$(".table_date").find("td").unbind("click").bind(
								"click",
								function() {
									var i = $(this).find(".js_checkbox");
									if (i.length > 0) {
										var sele = i.find(":checkbox").prop(
												"checked");
										if (sele == undefined) {
											return;
										}
										i.find(":checkbox").prop("checked",
												!sele);
										i.find(":checkbox").trigger("change");
										if (!sele) {
											$(this).addClass("yellow")
										} else {
											$(this).removeClass("yellow")
										}
									}

								});
						//
						// 给复选框添加选择事件
						for (indexi = 0; indexi <= 6; indexi++) {
							// $(".table_date")
							$(".js_checkbox_checkrows_" + indexi)
									.find(":checkbox")
									.change(
											function() {
												var issel = $(this).prop(
														"checked");
												var t = $(this).data("id");
												var inputname = 'day_val[' + t
														+ ']';
												if (issel) {// 被选中则给hidden字段添加值
													$(
															'input[name=\''
																	+ inputname
																	+ '\']')
															.val(t);
													var exists = false;
													for (selday in seldayes) {
														if (seldayes[selday] == t) {
															exists = true;
														}
													}
													if (!exists) {
														seldayes.push(t);
													}
													// 如果有相应的设置值
													var _price_adult = $(
															'#day'
																	+ t
																	+ '_price_adult')
															.val();

													var _price_adultpre = $(
															'#day'
																	+ t
																	+ '_price_adultpre')
															.val();
													var _price_adultec = $(
															'#day'
																	+ t
																	+ '_price_adultec')
															.val();
													var _price_adultyk = $(
															'#day'
																	+ t
																	+ '_price_adultyk')
															.val();

													var _price_children = $(
															'#day'
																	+ t
																	+ '_price_children')
															.val();

													var _price_childrenpre = $(
															'#day'
																	+ t
																	+ '_price_childrenpre')
															.val();
													var _price_childrenec = $(
															'#day'
																	+ t
																	+ '_price_childrenec')
															.val();
													var _price_childrenyk = $(
															'#day'
																	+ t
																	+ '_price_childrenyk')
															.val();

													var _numrange = $(
															'#day'
																	+ t
																	+ '_numrange')
															.val();
													//
													var _dfc = $(
															'#day' + t + '_dfc')
															.val();
													//
													var _room_type = $(
															'#day'
																	+ t
																	+ '_room_type')
															.val();
													//
													var _price_desc = $(
															'#day' + t
																	+ '_desc')
															.val();
													//

													if (_price_adult != null) {
														$('#price_adult').val(
																_price_adult);
													}
													if (_price_adultpre != null) {
														$('#price_adultpre')
																.val(
																		_price_adultpre);
													}
													if (_price_adultec != null) {
														$('#price_adultec')
																.val(
																		_price_adultec);
													}
													if (_price_adultyk != null) {
														$('#price_adultyk')
																.val(
																		_price_adultyk);
													}

													if (_price_children != null) {
														$('#price_children')
																.val(
																		_price_children);
													}
													if (_price_childrenpre != null) {
														$('#price_childrenpre')
																.val(
																		_price_childrenpre);
													}
													if (_price_childrenec != null) {
														$('#price_childrenec')
																.val(
																		_price_childrenec);
													}
													if (_price_childrenyk != null) {
														$('#price_childrenyk')
																.val(
																		_price_childrenyk);
													}

													if (_numrange != null) {
														$('#numrange').val(
																_numrange);
													}
													//
													if (_dfc != null) {
														$('#dfc').val(_dfc);
													}
													//
													if (_room_type != null) {
														$('#room_type').val(
																_room_type);
													}
													//
													if (_price_desc != null) {
														$('#price_desc').val(
																_price_desc);
													}

												} else { // 去掉hidden字段的值
													$(
															'input[name=\''
																	+ inputname
																	+ '\']')
															.val('');
													var exists = false;
													var dayindex = 0;
													for (selday in seldayes) {
														if (seldayes[selday] == t) {
															exists = true;
															break;
															dayindex++;
														}
													}
													if (exists) {
														seldayes.splice(selday,
																1);
													}

													$('#price_adult').val('');
													$('#price_adultpre')
															.val('');
													$('#price_adultec').val('');
													$('#price_adultyk').val('');
													$('#price_children')
															.val('');
													$('#price_childrenpre')
															.val('');
													$('#price_childrenec').val(
															'');
													$('#price_childrenyk').val(
															'');
													$('#numrange').val('');
													$('#dfc').val('');
													$('#room_type').val('');
													$('#price_desc').val('');

												}
											});
						}

						// 给复选框添加选择事件

						$(".js_change_set").unbind().bind("click", function() {
							var t = $(this);
							var n = t.data("change");
							var r = t.text();
							t.data("change", r);
							t.text(n);
							t.attr("title", n);
							var i = $(".table_date").find(".js_checkbox");
							// i.find(":checkbox").attr("checked", false);
							i.find(":checkbox").trigger("change");
							/*
							 * if (!e.opts.isMulti) { i.show(); e.opts.isMulti =
							 * true } else { i.hide(); e.opts.isMulti = false }
							 * $(e).trigger("q-show-detail"); e._check()
							 */
						});

						$(".js_checkbox_checkrows")
								.each(
										function() {
											var t = $(this).data("idx");
											$(this)
													.find(":checkbox")
													.change(
															function() {
																var n = $(this)
																		.prop(
																				"checked");
																var nwei = $(
																		this)
																		.prop(
																				"id");
																var selector = ".js_checkbox_checkrows_"
																		+ nwei;

																$(selector)
																		.find(
																				":checkbox")
																		.prop(
																				"checked",
																				n);
																$(selector)
																		.find(
																				":checkbox")
																		.trigger(
																				"change");
																if (n) {
																	$(".day")
																			.find(
																					".js_checkbox_checkrows_"
																							+ nwei)
																			.parents(
																					"td")
																			.addClass(
																					"yellow")
																} else {
																	$(".day")
																			.find(
																					".js_checkbox_checkrows_"
																							+ nwei)
																			.parents(
																					"td")
																			.removeClass(
																					"yellow")
																}

																// $(e).trigger("q-show-detail")
															})
										});

					}
					initevent();

					// 初始化事件

				}
			});
})(jQuery);

var seldates = function() {
	seldayes = new Array();
	$('.yellow').find(":checkbox").each(function(obj1, obj2) {
		var n = $(obj2).prop("checked");
		if (n) {
			// alert($(obj2).css('display'));
			if ($(obj2).data("id") != undefined) {
				seldayes.push($(obj2).data("id"));
			}
			// alert($(obj2).data("id"));
		}
	});
	return seldayes;
};
