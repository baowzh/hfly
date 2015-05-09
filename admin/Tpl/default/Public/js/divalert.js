function MessageBox() 
{ 
    this.titleheight = "21"; // 提示窗口标题高度 
    this.bordercolor = "#666699"; // 提示窗口的边框颜色 
    this.titlecolor = "#1259a4"; // 提示窗口的标题颜色 
    this.titlebgcolor = "#e4f1fb"; // 提示窗口的标题背景色 
    this.bgcolor = "#FFFFFF"; // 提示内容的背景色 
    this.MsgAlign="left"; 
    var bgObj = document.createElement("div"); 
    bgObj.setAttribute("id", "div_bgObj");
    var msgObj=document.createElement("div"); 
    msgObj.setAttribute("id", "div_msgObj");
    this.Hiden=function()
    {
		//alert("aaaa");
		
        $('#div_bgObj').remove();
        $('#div_msgObj').remove();
    }
    this.Show=function(title, msg, framesrc, w, h) 
    { 
        var iWidth = document.documentElement.clientWidth; 
        var iHeight = document.documentElement.clientHeight+document.documentElement.scrollTop*2; 
        
        bgObj.style.cssText = "position:absolute;left:0px;top:0px;width:"+iWidth+"px;height:"+Math.max(document.body.clientHeight, iHeight)+"px;filter:Alpha(Opacity=30);opacity:0.3;background-color:#000000;z-index:101;"; 
        document.body.appendChild(bgObj); 
        
        msgObj.style.cssText = "position:absolute;font:11px '宋体';top:"+(iHeight-h)/2+"px;left:"+(iWidth-w)/2+"px;width:"+w+"px;height:"+h+"px;text-align:center;border:1px solid "+this.bordercolor+";background-color:"+this.bgcolor+";padding:1px;line-height:22px;z-index:102;"; 
        document.body.appendChild(msgObj); 
        var table = document.createElement("table"); 
        msgObj.appendChild(table); 
        table.style.cssText = "margin:0px;border:0px;padding:0px;"; 
        table.cellSpacing = 0; 
        var tr = table.insertRow(-1); 
        var titleBar = tr.insertCell(-1); 
        titleBar.style.cssText = ";width:"+(w-84)+"px;height:"+this.titleheight+"px;text-align:left;padding:3px;margin:0px;font:bold 13px '宋体';color:"+this.titlecolor+";cursor:move;background-color:" + this.titlebgcolor; 
        titleBar.style.paddingLeft = "10px"; 
        titleBar.innerHTML = title; 
        var moveX = 0; 
        var moveY = 0; 
        var moveTop = 0; 
        var moveLeft = 0; 
        var moveable = false; 
        var docMouseMoveEvent = document.onmousemove; 
        var docMouseUpEvent = document.onmouseup; 
        titleBar.onmousedown = function(){ 
            var evt = getEvent(); 
            moveable = true; 
            moveX = evt.clientX; 
            moveY = evt.clientY; 
            moveTop = parseInt(msgObj.style.top); 
            moveLeft = parseInt(msgObj.style.left); 
            document.onmousemove = function(){ 
                if (moveable) 
                { 
                    var evt = getEvent(); 
                    var x = moveLeft + evt.clientX - moveX; 
                    var y = moveTop + evt.clientY - moveY; 
                    if ( x > 0 &&( x + w < iWidth) && y > 0 && (y + h < iHeight) ) 
                    { 
                        msgObj.style.left = x + "px"; 
                        msgObj.style.top = y + "px"; 
                    } 
                } 
            }; 
            document.onmouseup = function (){ 
                if (moveable) 
                { 
                    document.onmousemove = docMouseMoveEvent; 
                    document.onmouseup = docMouseUpEvent; 
                    moveable = false; 
                    moveX = 0; 
                    moveY = 0; 
                    moveTop = 0; 
                    moveLeft = 0; 
                } 
            }; 
        } 
        var closeBtn = tr.insertCell(-1); 
        closeBtn.style.cssText = "cursor:pointer; padding:2px;background-color:" + this.titlebgcolor; 
        closeBtn.innerHTML = "<span style=\"font-size:10pt;color:"+this.titlecolor+";\" style=\"font-size:10pt;color:"+this.titlecolor+";\" id='closeBtn'>×关闭窗口"; 
        closeBtn.onclick = function(){
            returnfunction();
            document.body.removeChild(bgObj); 
            document.body.removeChild(msgObj); 

        } 
        var msgBox = table.insertRow(-1).insertCell(-1); 
        msgBox.style.cssText = "font:10pt '宋体';"; 
        msgBox.colSpan = 2; 
        if(framesrc != "") 
        { 
            msg = "<iframe name='frmAlertWin' id='frmAlertWin' src=\"about:blank\" src=\"about:blank\" frameborder=0 marginwidth=0 marginheight=0 style='height:"+(h-this.titleheight-10)+"px;width:100%;'></iframe>"; 
        } 
        msgBox.innerHTML = "<div style=\" text-align:"+this.MsgAlign+";\">"+msg+"</div>"; 
        if(document.getElementById("frmAlertWin") != null) 
        { 
            document.getElementById("frmAlertWin").src = framesrc; 
        } 

        function getEvent(){ 
            return window.event || arguments.callee.caller.arguments[0]; 
        } 
    } 
}
