var tripecnav={
	buildnav:function($, setting){		 
		var $navobj=$("#"+setting.navid+">ul")
		$navobj.parent().get(0).className=setting.classname || "nav"
		var $parentobj=$navobj.find("ul").parent()
		$parentobj.hover(
			function(e){ $(this).children('a:eq(0)').addClass('on') },
			function(e){ $(this).children('a:eq(0)').removeClass('on') }
		)
		$parentobj.each(function(i){
			var $obj=$(this).css({zIndex: 999-i})
			var $subul=$(this).children('ul:eq(0)')
			this.datas={w:this.offsetWidth, h:this.offsetHeight,ulw:$subul.width(), ulh:$subul.height()}
			this.istop =$obj.parents("ul").length==1? true : false
			$subul.css({top:this.istop && setting.orientation!='v'? this.datas.h+"px" : 0})
			$obj.hover(function(e){
				var $playobj=$(this).children("ul:eq(0)")
				this._offsets={left:$(this).offset().left, top:$(this).offset().top}
				var mleft=this.istop && setting.orientation!='v'? 0 : this.datas.ulw
				mleft=(this._offsets.left+mleft+this.datas.ulw>$(window).width())? (this.istop && setting.orientation!='v'? -this.datas.ulw+this.datas.w : -this.datas.w) : mleft 
				$playobj.css({left:mleft+"px", width:this.datas.ulw+'px',display:'block'})

			},function(e){
				$(this).children("ul:eq(0)").css({display:'none'})			 
			})
		});
		$navobj.find("ul").css({display:'none', visibility:'visible'})
	},

	init:function(setting){	
		jQuery(document).ready(function($){
			tripecnav.buildnav($, setting)
		})
	}
}