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
  
<div class="main_cont">
    <h1><?php echo ($viewpoint["names"]); ?></h1>
    <p><?php echo ($viewpoint["view_info"]); ?></p> 
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