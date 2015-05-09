<?php if (!defined('THINK_PATH')) exit();?>  
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <script src="../Public/assets/js/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="../Public/assets/js/workless.js" preload="*" type="text/javascript"></script>
    <script src="../Public/js/jquery.city_list_plugs.js" type="text/javascript"></script>
    <script src="../Public/js/index.js" type="text/javascript"></script>
    <script src="__ROOT__/Public/Plugins/jquery.artDialog/jquery.artDialog.js?skin=default" type="text/javascript"></script>
    <script type="text/javascript" src="__ROOT__/Public/Plugins/jquery.artDialog/iframeTools.js"></script>
    <link rel="stylesheet" href="http://127.0.0.1/myweb/style/css/common.css">
    <link rel="stylesheet" href="http://127.0.0.1/myweb/style/css/index.css">
    <link rel="stylesheet" href="../Public/assets/css/workless.css">
    <link rel="stylesheet" href="../Public/css/style_index.css">
    <title>旅游系统</title>
</head>
<body>

  <div class="header">
    <div class="head">
       <div class="head_left">
           欢迎来到内蒙古汇丰旅行社有限公司
       </div>
       <div class="head_right">
           <li class="weixin"><a href="" >微信</a></li>
           <li class="weibo"><a href="" >微博</a></li>
           <li class="help"><a href="<?php echo U('article/detail');?>?detail=2" >帮助中心</a></li>
       </div>
    </div>
    <div class="search">
       <div class="logo"><img src="../Public/images/logo.jpg"></div>
       <div class="dectails">
         <li class="hotline">400-000-0000</li>
         <li><input type="text" class="shuru"><input type="button" value="搜索" class="buts"></li>
       </div>
    </div>
  </div>
  <div class="navs">
    <div class="nav">
        <li <?php if(($current) == "index"): ?>class="curt"<?php endif; ?>><a href="/" >首页</a></li>
        <?php if(is_array($navlist)): $i = 0; $__LIST__ = $navlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 3 );++$i;?><li>
<!--          <a href="<?php echo U('/index.php',array('id'=>$vs['id']));?>"><?php echo ($vs["names"]); ?></a> -->
           <a href=" __ROOT__/index.php?id=<?php echo ($vs['id']); ?>"><?php echo ($vs["names"]); ?></a>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
  </div>
  

<div class="tanchu1">
	<div class="tanbox">
		<div class="tan_left">
			<li class="lasts" style="position: relative;"><a href=""> <img
					alt="" src="style/images/lvxing.jpg">
			</a>
				<div
					style="width: 170px; height: 22px; position: absolute; bottom: 0px; background-color: #eee; text-align: right; opacity: 0.6; color: #00acac;">
					<div style="width: 70px; height: 22px; float: right;">呼和浩特&nbsp;</div>
					<div class="icon">
						<img src="style/images/ding.png"
							style="width: 21px; height: 24px; float: right">
					</div>
				</div></li>
			<li class="lasts" style="position: relative;"><a href=""> <img
					alt="" src="style/images/hs2.jpg">
			</a>
				<div
					style="width: 170px; height: 22px; position: absolute; bottom: 0px; background-color: #eee; text-align: right; opacity: 0.6; color: #00acac;">
					<div style="width: 70px; height: 22px; float: right;">呼伦贝尔</div>
					<div class="icon">
						<img src="style/images/ding.png"
							style="width: 21px; height: 24px; float: right">
					</div>
				</div></li>
			<li class="lasts" style="position: relative;"><a href=""> <img
					alt="" src="style/images/hs3.jpg">
			</a>
				<div
					style="width: 170px; height: 22px; position: absolute; bottom: 0px; background-color: #eee; text-align: right; opacity: 0.6; color: #00acac;">


					<div style="width: 70px; height: 22px; float: right;">锡林郭勒盟</div>
					<div class="icon">
						<img src="style/images/ding.png"
							style="width: 21px; height: 24px; float: right">
					</div>
				</div></li>
			<li class="lasts" style="position: relative;"><a href=""> <img
					alt="" src="style/images/hs4.jpg">
			</a>
				<div
					style="width: 170px; height: 22px; position: absolute; bottom: 0px; background-color: #eee; text-align: right; opacity: 0.6; color: #00acac;">
					<div style="width: 70px; height: 22px; float: right;">阿拉善盟</div>
					<div class="icon">
						<img src="style/images/ding.png"
							style="width: 21px; height: 24px; float: right">
					</div>
				</div></li>

		</div>
		<div class="tan_right">
			<img src="style/images/comname.png" style="width: 150px;">
			<div class="smalls">
				<li><a href="">内蒙最好的旅行社</a></li>
				<li><a href="">我们给您最优质的服务</a></li>
				<li><a href="">我们给您最放心的旅行</a></li>
			</div>
			<div class="tels">
				<img alt="" width="80" height="32" src="style/images/hotlines.jpg">
				<p>400-000-0000</p>
			</div>
			<div class="zixun">
				<input type="button" value="马上咨询"> <input type="button"
					value="稍后咨询" onclick="$('.tanchu1').hide();">
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="style/css/popwindow.css">
<link rel="stylesheet" type="text/css" href="style/css/nav.css" />
<link rel="stylesheet" type="text/css" href="style/css/css.css" />
<script type="text/javascript" src="style/js/lrtk.js"></script>

<div class="banner">
	<div class="banner_left">
		<script type="text/javascript">
			$(document).ready(function() {
				$(".sort-list>ul>li").hover(function() {
					$(this).addClass("hover")
				}, function() {
					$(this).removeClass("hover")
				});
			});
		</script>
		<div class="sort">
			<div class="sort-list">
				<ul>

					<li class="bgs_1"><a
						href="<?php echo U('travel/index',array('id'=>1));?>" class="sort-list-1"><span>包团自由行
								<em>后付费行程</em>
						</span> </a>
						<ul>
							<li><a href="<?php echo U('travel/index',array('id'=>1,'day'=>1));?>">一日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>1,'day'=>2));?>">二日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>1,'day'=>3));?>">三日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>1,'day'=>4));?>">四日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>1,'day'=>5));?>">五日游</a></li>
						</ul></li>
					<li class="bgs_2"><a
						href="<?php echo U('travel/index',array('id'=>2));?>" class="sort-list-2"><span>纯玩团
								<em>后付费行程</em>
						</span></a>
						<ul>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>1));?>">一日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>2));?>">二日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>3));?>">三日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>4));?>">四日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>5));?>">五日游</a></li>
						</ul></li>

					<li class="bgs_2"><a
						href="<?php echo U('travel/index',array('id'=>2));?>" class="sort-list-2"><span>常规团

						</span></a>
						<ul>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>1));?>">一日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>2));?>">二日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>3));?>">三日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>4));?>">四日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>2,'day'=>5));?>">五日游</a></li>
						</ul></li>

					<li class="bgs_3"><a
						href="<?php echo U('travel/index',array('id'=>3));?>" class="sort-list-3"><span>会议策划</span></a>
						<ul>
							<li><a href="<?php echo U('travel/index',array('id'=>3,'day'=>1));?>">一日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>3,'day'=>2));?>">二日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>3,'day'=>3));?>">三日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>3,'day'=>4));?>">四日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>3,'day'=>5));?>">五日游</a></li>
						</ul></li>
					<li class="bgs_4"><a
						href="<?php echo U('travel/index',array('id'=>4));?>" class="sort-list-4"><span>团体策划</span></a>
						<ul>
							<li><a href="<?php echo U('travel/index',array('id'=>4,'day'=>1));?>">一日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>4,'day'=>2));?>">二日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>4,'day'=>3));?>">三日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>4,'day'=>4));?>">四日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>4,'day'=>5));?>">五日游</a></li>
						</ul></li>
					<li class="bgs_5"><a
						href="<?php echo U('travel/index',array('id'=>5));?>" class="sort-list-5"><span>自驾游</span></a>
						<ul>
							<li><a href="<?php echo U('travel/index',array('id'=>5,'day'=>1));?>">一日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>5,'day'=>2));?>">二日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>5,'day'=>3));?>">三日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>5,'day'=>4));?>">四日游</a></li>
							<li><a href="<?php echo U('travel/index',array('id'=>5,'day'=>5));?>">五日游</a></li>
						</ul></li>
					<li class="bgs_6"><a href="<?php echo U('viewpoint/index');?>"
						class="sort-list-6"><span>旅游点</span></a></li>
					<li class="bgs_7"><a
						href="<?php echo U('article/detail',array('detail'=>7));?>"
						class="sort-list-7"><span>旅游攻略</span></a></li>

				</ul>
			</div>
		</div>
	</div>
	<div class="banner_center">
		<div id="playBox">
			<div class="pre"></div>
			<div class="next"></div>
			<ul class="oUlplay">
				<?php $_result=M("advert")->table("jee_advert ad") ->join("jee_advert_area area on ad.area_id=area.id") ->where("area.status=1 and area.names_en='index_banner' and ad.start_time<=1431183057 and (ad.end_time=0 or ad.end_time>=1431183057)") ->order("ad.sort") ->limit("3") ->field("ad.*,area.names") ->select(); if ($_result):$adcount=count($_result);$i=0; foreach($_result as $ad):++$i;?><li><a target="_blank" href="<?php echo ($ad["url"]); ?>"><img
							src="<?php echo (get_file($ad["pic"])); ?>" alt="<?php echo (get_file($ad["pic"],'names')); ?>" /></a></li><?php endforeach; endif;?>
			</ul>
			<div class="smalltitle">
				<ul>
					<?php for($i=0;$i<$adcount;$i++): if(($i) == "0"): ?><li class="thistitle"></li>
						<?php else: ?>
						<li></li><?php endif; endfor;?>
				</ul>
			</div>
		</div>
	</div>
	<div class="banner_right">
		<h3>实时预定咨询</h3>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
		<li><a href="">童** 2大1小 线路0061[2015年2月22日]</a></li>
	</div>
</div>

<div class="blocks">
	<div class="boxs one">
		<h4>浪漫物语</h4>
		<p>风情额济纳胡杨林</p>
	</div>
	<div class="boxs">
		<a href=""><img alt="" width="200" height="145"
			src="style/images/jing.jpg" /></a>
	</div>
	<div class="boxs three">
		<h4>畅游内蒙</h4>
		<p>内蒙旅行第一站</p>
	</div>
	<div class="boxs">
		<a href=""><img alt="" width="200" height="145"
			src="style/images/thr.jpg" /></a>
	</div>
	<div class="boxs five">
		<h4>身未动，心已远</h4>

	</div>
	<div class="boxs">
		<a href=""><img alt="" width="200" height="145"
			src="style/images/fives.jpg" /></a>
	</div>
	<div class="boxs">
		<a href=""><img alt="" width="200" height="145"
			src="style/images/jing2.jpg" /></a>
	</div>
	<div class="boxs sen">
		<h4>民族风情</h4>

	</div>
	<div class="boxs">
		<a href=""><img alt="" width="200" height="145"
			src="style/images/six.jpg" /></a>
	</div>
	<div class="boxs eigt">
		<h4>成陵</h4>
		<p>穿越古今 梦回蒙古</p>
	</div>
	<div class="boxs">
		<a href=""><img alt="" width="200" height="145"
			src="style/images/six.jpg" /></a>
	</div>
	<div class="boxs nine">
		<h4>完美旅行</h4>
		<p>享受不一样的沙漠</p>
	</div>

</div>

<div class="baotuan">
	<div class="travel">
		<div class="line_left">
			<div class="travelpointname">包团自由行</div>
			<div style="float: left; margin-left: 10px;" class="travelpoint">
				<div class="recommendedch">路线推荐</div>
				<div class="recommendeden">RECOMMEDDED ROUTES</div>
			</div>
		</div>
		<div class="line_center">
			<li class="curtent"><a href="">一日游</a></li>
			<li><a href="">二日游</a></li>
			<li><a href="">三日游</a></li>
			<li><a href="">四日游</a></li>
			<li><a href="">五日游</a></li>
		</div>
		<div class="line_right">
			<a href="">更多推存</a>
		</div>
	</div>

	<div class="bao_detail">
		<div class="bao_left">

			<li><a href="#" target="_blank"> <img alt="" width="421"
					height="315" src="style/images/hhht1.jpg">
					<div class="desc">
						<span class="price">￥1000</span> <span class="adds">呼和浩特</span>
						<p>XXXXXX草原行 3天</p>
					</div>
			</a>
				<div class="tui">&nbsp;</div></li>
			<li><a href="#" target="_blank"> <img alt="" width="421"
					height="315" src="style/images/hhht2.jpg">
					<div class="desc">
						<span class="price">￥1000</span> <span class="adds">呼和浩特</span>
						<p>XXXXXX草原行 3天</p>
					</div>
			</a>
				<div class="tui">&nbsp;</div></li>
		</div>

		<div class="bao_right">

			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
		</div>
	</div>
</div>
<div class="baotuan">
	<div class="travel">
		<div class="line_left">
			<div class="travelpointname">纯团玩</div>
			<div style="float: left; margin-left: 10px;" class="travelpoint">
				<div class="recommendedch">路线推荐</div>
				<div class="recommendeden">RECOMMEDDED ROUTES</div>
			</div>
		</div>
		<div class="line_center">
			<li class="curtent"><a href="">一日游</a></li>
			<li><a href="">二日游</a></li>
			<li><a href="">三日游</a></li>
			<li><a href="">四日游</a></li>
			<li><a href="">五日游</a></li>
		</div>
		<div class="line_right">
			<a href="">更多推存</a>
		</div>
	</div>

	<div class="bao_detail">
		<div class="bao_left">

			<li><a href="#" target="_blank"> <img alt="" width="421"
					height="315" src="style/images/hhht1.jpg">
					<div class="desc">
						<span class="price">￥1000</span> <span class="adds">呼和浩特</span>
						<p>XXXXXX草原行 3天</p>
					</div>
			</a>
				<div class="tui">&nbsp;</div></li>
			<li><a href="#" target="_blank"> <img alt="" width="421"
					height="315" src="style/images/hhht2.jpg">
					<div class="desc">
						<span class="price">￥1000</span> <span class="adds">呼和浩特</span>
						<p>XXXXXX草原行 3天</p>
					</div>
			</a>
				<div class="tui">&nbsp;</div></li>
		</div>

		<div class="bao_right">

			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
		</div>
	</div>
</div>
<div class="baotuan">
	<div class="travel">
		<div class="line_left">
			<div class="travelpointname">常规团</div>
			<div style="float: left; margin-left: 10px;" class="travelpoint">
				<div class="recommendedch">路线推荐</div>
				<div class="recommendeden">RECOMMEDDED ROUTES</div>
			</div>
		</div>
		<div class="line_center">
			<li class="curtent"><a href="">一日游</a></li>
			<li><a href="">二日游</a></li>
			<li><a href="">三日游</a></li>
			<li><a href="">四日游</a></li>
			<li><a href="">五日游</a></li>
		</div>
		<div class="line_right">
			<a href="">更多推存</a>
		</div>
	</div>

	<div class="bao_detail">
		<div class="bao_left">

			<li><a href="#" target="_blank"> <img alt="" width="421"
					height="315" src="style/images/hhht1.jpg">
					<div class="desc">
						<span class="price">￥1000</span> <span class="adds">呼和浩特</span>
						<p>XXXXXX草原行 3天</p>
					</div>
			</a>
				<div class="tui">&nbsp;</div></li>
			<li><a href="#" target="_blank"> <img alt="" width="421"
					height="315" src="style/images/hhht2.jpg">
					<div class="desc">
						<span class="price">￥1000</span> <span class="adds">呼和浩特</span>
						<p>XXXXXX草原行 3天</p>
					</div>
			</a>
				<div class="tui">&nbsp;</div></li>
		</div>

		<div class="bao_right">

			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
		</div>
	</div>
</div>
<div class="baotuan">
	<div class="travel">
		<div class="line_left">
			<div class="travelpointname">团体策划</div>
			<div style="float: left; margin-left: 10px;" class="travelpoint">
				<div class="recommendedch">路线推荐</div>
				<div class="recommendeden">RECOMMEDDED ROUTES</div>
			</div>
		</div>
		<div class="line_center">
			<li class="curtent"><a href="">一日游</a></li>
			<li><a href="">二日游</a></li>
			<li><a href="">三日游</a></li>
			<li><a href="">四日游</a></li>
			<li><a href="">五日游</a></li>
		</div>
		<div class="line_right">
			<a href="">更多推存</a>
		</div>
	</div>

	<div class="bao_detail">
		<div class="bao_left">

			<li><a href="#" target="_blank"> <img alt="" width="421"
					height="315" src="style/images/hhht1.jpg">
					<div class="desc">
						<span class="price">￥1000</span> <span class="adds">呼和浩特</span>
						<p>XXXXXX草原行 3天</p>
					</div>
			</a>
				<div class="tui">&nbsp;</div></li>
			<li><a href="#" target="_blank"> <img alt="" width="421"
					height="315" src="style/images/hhht2.jpg">
					<div class="desc">
						<span class="price">￥1000</span> <span class="adds">呼和浩特</span>
						<p>XXXXXX草原行 3天</p>
					</div>
			</a>
				<div class="tui">&nbsp;</div></li>
		</div>

		<div class="bao_right">

			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
			<div class="details_q">
				<div style="width: 244px; height: 22px;">
					<div class="travellinecommsel">一日游</div>
					<div class="travellinecomm">内蒙古</div>
					<div class="travellinecomm">响沙湾</div>
					<div class="travellinecomm">一日游</div>
				</div>
				<br>
				<p>独家开辟，市内四区，车接车送，让你真正的放松身心。也可单独订票欢迎喜讯。</p>
				<br>
			</div>
		</div>
	</div>
</div>
<div class="jingdian">
	<div class="travel">
		<div class="line_left" style="width: 400px">
			<img src="style/images/jingdian.jpg" alt="" width="344" height="51">
		</div>
		<div class="line_center">
			<li class="curtent"><a href="">响沙湾</a></li>
			<li><a href="">希腊牧人草原</a></li>
			<li><a href="">成陵</a></li>
			<li><a href="">大昭寺</a></li>
			<li><a href="">五当召</a></li>
		</div>
		<div class="line_right">
			<a href="<?php echo U('viewpoint/index');?>">更多推存</a>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".jing_left li").hover(function() {
				$(".shaw").hide();
				$(this).children("#showa").show(0);
			}, function() {
				$(this).children("#showa").hide(0);
			});

		});
	</script>
	<div class="jing_dec">
		<div class="jing_left">
			<?php if(is_array($pointlist)): $k = 0; $__LIST__ = $pointlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li<?php if($mod == 1 ): ?>style="margin-right:0px"<?php endif; ?>><a
				href="<?php echo U('viewpoint/detail',array('id'=>$vo['id']));?>"
				target="_blank"><img alt="<?php echo ($vo["names"]); ?>" width="413" height="275"
					src="<?php echo ($vo["pic"]); ?>" /></a>
				<div class="tui">&nbsp;</div>
				<div id="showa" class="shaw" style="display: none">
					<a href="<?php echo U('viewpoint/detail',array('id'=>$vo['id']));?>"><?php echo ($vo["names"]); ?></a>
				</div></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="jing_right">
			<h5>
				<a href="">旅游咨询</a>
			</h5>
			<div class="details_q">
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
				<li><a href="">诚意拼团 已有两人 住草原沙漠 3日包团 欢迎您的加入</a></li>
			</div>
		</div>
	</div>
</div>
<div class="knowledge">
	<div class="travel" style="border-bottom: none">
		<div class="line_left">
			<img src="style/images/konw.jpg" alt="" width="382" height="58">
		</div>
	</div>
	<div class="know_list">
		<div class="know_left">
			<?php if(is_array($Articlelist)): $i = 0; $__LIST__ = $Articlelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('article/detail',array('id'=>$vo['id']));?>"><?php echo ($vo["title"]); ?></a></li>
			<?php if($mod == 1 ): ?></div>
		<div class="know_left"><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</div>

<div id="bodys"></div>

  <div class="footer">
     <div class="foottop">&nbsp;</div>
     <div class="footcont">
        <?php if(is_array($helps)): $i = 0; $__LIST__ = $helps;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$help): $mod = ($i % 2 );++$i;?><div class="footbox">
               <h3><?php echo ($help["names"]); ?></h3>
               <?php if(is_array($help["list"])): $i = 0; $__LIST__ = $help["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$act): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('article/detail',array('id'=>$act['id']));?>" ><?php echo ($act["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
     </div>
     <div class="footbottom">
        <ul>
        
        <?php if(is_array($aboutlist)): $i = 0; $__LIST__ = $aboutlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$about): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('article/detail',array('id'=>$about['id']));?>" ><?php echo ($about["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
       </ul>
       <div class="clear"></div>
       <div class="hotlines">内蒙古汇丰旅行社有限公司国内统一服务热线：400-000-0000</div>
         <p>公司地址：名都中央广场 南路332号1-2层</p>
         <p>内ICP备88888888号  Copyright 2000-2015 内蒙旅行社 ALL Rights Resevised</p>
     </div>
  </div>
</body>
</html>