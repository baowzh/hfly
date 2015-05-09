// JavaScript Document

function getBox(y,m,d) {
	var pri=$("#P_SpecialPrice").val();
	if(!pri)pri="{}";	
	var price=jQuery.parseJSON(pri);	
    var objDate = new Date();
    var thisDate = new Date(y, m, 0);
    var days = thisDate.getDate();
    var prewDate = null;
	var str_m,str_day,pri_index;
    var days_prew = null;
    if(m==1){
        prewDate = new Date(y-1, 12, 0);
    }else{
        prewDate = new Date(y, m-1, 0);
    }
    days_prew = prewDate.getDate();
    objDate.setFullYear(y, m-1, 1);
    var week_in_month = objDate.getDay();
    var td_list = "<tr>";
    var first_prew = days_prew-week_in_month+1;
    
    //第一行
    for (var i = 0; i < week_in_month; i++) {
        td_list = td_list + getNotDayHtml(first_prew);
        first_prew++;
    }
    for (i = 1; i <= 7-week_in_month; i++) {		
        str_m=(m<10)?"0"+m.toString():m.toString();
		str_day="0"+i.toString();					
		pri_index =y.toString()+'-'+str_m+'-'+str_day;
		
		if(price[pri_index]){					
		  td_list += getPriceDayHtml(y, m, i, price,pri_index);
		}
		else{
		  td_list += getNoPriceDayHtml(y,m,i,pri_index);
		}
    }
    td_list += "</tr>";
        
    var day = 7-week_in_month;
    var day_not = 1;
    //第二至五行
    for (var i = 1; i <= 4; i++) {
        td_list += "<tr>";
        for(var j=i;j<i+7;j++){
            day++;
            if(day<=days){                
				str_m=(m<10)?"0"+m.toString():m.toString();
				str_day=(day<10)?"0"+day.toString():day.toString();
							
				pri_index =y.toString()+'-'+str_m+'-'+str_day;
				if(price[pri_index]){					
				  td_list += getPriceDayHtml(y, m, day, price,pri_index);
				}
				else{
				  td_list += getNoPriceDayHtml(y,m,day,pri_index);
				}
				
            }else{
                td_list += getNotDayHtml(day_not);
                day_not++;
            }
        }
        td_list += "</tr>";
    }
	
    var html = td_list;
    return html;
}

function getNotDayHtml(d) {
    var not_day = "<td><span class=\"\"></td>";
    return not_day;
}
    
function getNotDayHtml(d) {
	var not_day = "<td>";
		not_day += "<span class=\"not_day\">";
		not_day += "<label></label>";
		not_day += "</span>";
		not_day += "</td>";
	return not_day;
}

function getNoPriceDayHtml(y,m,d,price_index) {	
    var not_day = "<td id=\""+price_index+"\" class=\"day\" onclick=\"showpriceform(this,event)\" price=\"0,0,0\"><span>"+d+"</span></td>";
    return not_day;
}

function getPriceDayHtml(y, m, d, price,price_index) {	
	var price_day = "";
		price_day+="<td id=\""+price_index+"\" class=\"day\" onclick=\"showpriceform(this,event)\" price=\""+price[price_index][0]+","+price[price_index][1]+","+price[price_index][2]+"\")\">";
		price_day+="<a href=\"javascript:removep('"+price_index+"');\"><img alt=\"关闭\" src=\""+Public+"/images/toolsDells.png\"></a>";
		price_day+="<span class=\"td_group_stage\">" + d + "";
		price_day+="<label class=\"td_price\">￥" + price[price_index][1] + "</label>";
		price_day+="<label class=\"td_space\"></label>";
		price_day+="</span>";		
		price_day+="</td>";
		
	return price_day;
}

function getPrice(travelline_id,y, m,d){
    var _url = "/index.php/travel/ajaxGetPrice";
    $.ajax( {
        type : "POST",
        url : _url,
        timeout : 6000,
        dataType : 'json',
        data: 'travelline_id='+travelline_id+'&y='+y+'&m='+m+'&d='+d,
        success : function(data) {
           if(data=='0'){
               $('#temp_html').val(getNoPriceDayHtml(y,m,d)) ;
           }else{
               $('#temp_html').val(getPriceDayHtml(y,m,d)) ;
           }
        },
        error : function() {
            alert('Calendar load error!');
        }
    });
}