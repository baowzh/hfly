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
    <link rel="stylesheet" href="style/css/common.css">
    <link rel="stylesheet" href="style/css/index.css">
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
        <?php if(is_array($navlist)): $i = 0; $__LIST__ = $navlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 3 );++$i;?><li><a href="<?php echo U('viewpoint/detail',array('id'=>$vs['id']));?>"><?php echo ($vs["names"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
  </div>
  
<div class="main_lines">
   <div class="travel">
      <div class="line_left"><img src="/style/images/hot.jpg" alt="" width="402" height="57" ></div>
      <div class="line_center">
        <li <?php if(($day) == "0"): ?>class="curtent"<?php endif; ?>><a href="<?php echo U('travel/index',array('id'=>$id,'day'=>0));?>" >全部</a></li>
        <li <?php if(($day) == "1"): ?>class="curtent"<?php endif; ?>><a href="<?php echo U('travel/index',array('id'=>$id,'day'=>1));?>" >一日游</a></li>
        <li <?php if(($day) == "2"): ?>class="curtent"<?php endif; ?>><a href="<?php echo U('travel/index',array('id'=>$id,'day'=>2));?>" >二日游</a></li>
        <li <?php if(($day) == "3"): ?>class="curtent"<?php endif; ?>><a href="<?php echo U('travel/index',array('id'=>$id,'day'=>3));?>" >三日游</a></li>
        <li <?php if(($day) == "4"): ?>class="curtent"<?php endif; ?>><a href="<?php echo U('travel/index',array('id'=>$id,'day'=>4));?>" >四日游</a></li>
        <li <?php if(($day) == "5"): ?>class="curtent"<?php endif; ?>><a href="<?php echo U('travel/index',array('id'=>$id,'day'=>5));?>" >五日游</a></li>
        <li <?php if(($day) == "6"): ?>class="curtent"<?php endif; ?>><a href="<?php echo U('travel/index',array('id'=>$id,'day'=>6));?>" >六日游</a></li>
      </div>
      <div class="line_right">
         <a href="" >更多推存</a>
      </div>
   </div>
   
   <div class="mianconent">
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 3 );++$i;?><li <?php if($mod == 2 ): ?>class="lasts"<?php endif; ?>>
          <a href="<?php echo U('travel/detail',array('id'=>$vo['id']));?>" target="_blank">
          <img alt="<?php echo ($vo["names"]); ?>" width="376" height="247" src="<?php echo (get_line_img($vo["id"])); ?>"  >
          <div class="desc">
              <span class="price">￥<?php echo (get_line_min_price($vo["id"])); ?>起</span> <span class="adds"><?php echo (_get_city($vo["city_id"])); ?></span>
              <p><?php echo ($vo["names"]); ?>  <?php echo ($vo["trip_days"]); ?>日</p>
          </div>
          </a>
          <div class="tui">&nbsp;</div>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
       <div style="clear:both"> </div>
       <div class="page"><?php echo ($page); ?></div>
      <div style="clear:both"> </div>
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