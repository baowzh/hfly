<?php

require_once 'Freemail.php';

/**
  +----------------------------------------------------------
 * 初始化request参数
  +----------------------------------------------------------
 */
function init_request($char = '-') {
	header('Content-type: text/html; charset=' . CHARSET);
	$querystring = $_SERVER['QUERY_STRING'];
	$get = explode($char, $querystring);
	$get = haddslashes($get, 1);
	return $get;
}

function haddslashes($string, $force = 0) {
	if (!MAGIC_QUOTES_GPC || $force) {
		if (is_array($string)) {
			foreach ($string as $key => $val) {
				$string[$key] = haddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}

function toDate($time, $format = 'Y年m月d日 H:i:s') {
	if (empty($time)) {
		return '';
	}
	$format = str_replace('#', ':', $format);
	return date($format, $time);
}

function showTags($tags) {
	$tags = explode(' ', $tags);
	$str = '';
	foreach ($tags as $key => $val) {
		$tag = trim($val);
		$str .= ' <a href="' . __URL__ . '/tag/name/' . urlencode($tag) . '">' . $tag . '</a>  ';
	}
	return $str;
}
function get_special_info1($lineid = "0") {
	static $line_info = null;
	if ($line_info === null)
		$line_info = M("line_info");
	$content = $line_info->where("lid=$lineid")->getField("special_info");
	return preg_replace("/\<.*?\>/", "", $content);
}
/**
 * 根据id获取后台用户的指定字段的值
 * @staticvar null $user_list
 * @param type $id
 * @param type $field
 * @return type
 */
function get_user($id, $field = "username", $default = "--") {
	static $user_list = null;
	if ($user_list === null) {
		$user_list = M("user")->getField("id,username,phone,email,login_time,login_ip,hits,status");
	}
	return $user_list[$id][$field] ? $user_list[$id][$field] : $default;
}

/**
 * 根据时间戳返回 Y-m-d  格式的时间
 * @param type $time
 * @param type $default
 * @return type
 */
function f_date($time, $default = "time") {
	if (strtotime($time) > 0 || intval($time)) {
		return date('Y-m-d', $time);
	}
	if ($default == "time") {
		return date('Y-m-d', time());
	}
	if (intval($default) > 0) {
		return date('Y-m-d', intval($default));
	}
	return $default;
}

/**
 * 根据时间戳返回 Y-m-d H:i:s 格式的时间
 * @param type $time
 * @param type $default
 * @return type
 */
function f_time($time, $default = "time") {
	if (strtotime($time) > 0 || intval($time)) {
		return date('Y-m-d H:i:s', $time);
	}
	if ($default == "time") {
		return date('Y-m-d H:i:s', time());
	}
	if (intval($default) > 0) {
		return date('Y-m-d H:i:s', intval($default));
	}
	return $default;
}

/**
 * 格式化money
 * @param type $money
 * @return type
 */
function f_money($money) {
	return number_format($money, 2);
}

function firendlyTime($time) {
	if (empty($time)) {
		return '';
	}
	import('@.ORG.Date');  //日期时间操作类目录与1.5不一样
	$date = new Date(intval($time));
	return $date->timeDiff(time(), 2);
}

function autourl($message) {
	$message = preg_replace(array(
		 "/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp|gopher|news|telnet|mms|rtsp):\/\/|www\.)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+)/i",
		 "/(?<=[^\]a-z0-9\/\-_.~?=:.])([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))/i"
			 ), array(
		 "[url]\\1\\3[/url]",
		 "[email]\\0[/email]"
			 ), ' ' . $message);
	return $message;
}

function getCategoryName($id) {
	if (isset($_SESSION['categoryList'])) {
		$list = $_SESSION['categoryList'];
		return $list[$id];
	}
	$dao = D("Category");
	$cateList = $dao->getField("id,title");
	$_SESSION['categoryList'] = $cateList;
	return $cateList[$id];
}

function getAbstract($content, $id) {
	if (false !== $pos = strpos($content, '[separator]')) {
		$content = substr($content, 0, $pos) . '  <P> <a href="' . __URL__ . '/' . $id . '"><B>阅读文章全部内容… </B></a> ';
	}
	return $content;
}

function getTitleSize($count) {
	$size = (ceil($count / 10) + 11) . 'px';
	return $size;
}

function getBlogTitle($id) {
	$dao = D("Blog");
	$blog = $dao->getById($id);
	if ($blog) {
		return $blog['title'];
	} else {
		return '';
	}
}

function getUserName($id) {
	return '游客';
}

function getTopicTitle($id) {
	$dao = D("Topic");
	$topic = $dao->getById($id);
	if ($topic) {
		return $topic->title;
	} else {
		return '';
	}
}

function getCategoryBlogCount($categoryId) {
	$dao = D("Blog");
	//$count  =  $dao->count("categoryId='{$categoryId}'");
	$count = $dao->where("categoryId='{$categoryId}'")->count();
	return $count;
}

function rcolor() {
	$rand = rand(0, 255);
	return sprintf("%02X", "$rand");
}

function rand_color() {
	return '#' . rcolor() . rcolor() . rcolor();
}

function color_txt($str) {
	if (function_exists('iconv_strlen')) {
		$len = iconv_strlen($str);
	} else if (function_exists('mb_strlen')) {
		$len = mb_strlen($str);
	}
	$colorTxt = '';
	for ($i = 0; $i < $len; $i++) {
		$colorTxt .= '<span style="color:' . rand_color() . '">' . msubstr($str, $i, 1, 'utf-8', '') . '</span>';
	}

	return $colorTxt;
}

function showExt($ext, $pic = true) {
	static $_extPic = array(
		 'dir' => "folder.gif",
		 'doc' => 'msoffice.gif',
		 'rar' => 'rar.gif',
		 'zip' => 'zip.gif',
		 'txt' => 'text.gif',
		 'pdf' => 'pdf.gif',
		 'html' => 'html.gif',
		 'png' => 'image.gif',
		 'gif' => 'image.gif',
		 'jpg' => 'image.gif',
		 'php' => 'text.gif',
	);
	static $_extTxt = array(
		 'dir' => '文件夹',
		 'jpg' => 'JPEG图象',
	);
	if ($pic) {
		if (array_key_exists(strtolower($ext), $_extPic)) {
			$show = "<IMG SRC='" . WEB_PUBLIC_PATH . "/Images/extension/" . $_extPic[strtolower($ext)] . "' BORDER='0' alt='' align='absmiddle'>";
		} else {
			$show = "<IMG SRC='" . WEB_PUBLIC_PATH . "/Images/extension/common.gif' WIDTH='16' HEIGHT='16' BORDER='0' alt='文件' align='absmiddle'>";
		}
	} else {
		if (array_key_exists(strtolower($ext), $_extTxt)) {
			$show = $_extTxt[strtolower($ext)];
		} else {
			$show = $ext ? $ext : '文件夹';
		}
	}

	return $show;
}

function emot($emot) {
	//将WEB_PUBLIC_URL替换为WEB_PUBLIC_PATH解决编辑器小图片不解析的问题
	return '<img src="' . WEB_PUBLIC_PATH . '/Images/emot/' . $emot . '.gif" align="absmiddle" style="border:none;margin:0px 1px">';
}

function getShortTitle($title, $length = 12) {
	if (empty($title)) {
		return '...';
	}
	//  将OUTPUT_CHARSET 改为 DEFAULT_CHARSET
	return msubstr($title, 0, $length, C('DEFAULT_CHARSET'));
}

function Pinyin($_String, $_Code = 'UTF8') { //GBK页面可改为gb2312，其他随意填写为UTF8
	$_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha" . "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|" . "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er" . "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui" . "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang" . "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang" . "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue" . "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne" . "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen" . "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang" . "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|" . "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|" . "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu" . "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you" . "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|" . "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
	$_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990" . "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725" . "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263" . "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003" . "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697" . "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211" . "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922" . "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468" . "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664" . "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407" . "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959" . "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652" . "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369" . "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128" . "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914" . "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645" . "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149" . "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087" . "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658" . "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340" . "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888" . "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585" . "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847" . "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055" . "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780" . "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274" . "|-10270|-10262|-10260|-10256|-10254";
	$_TDataKey = explode('|', $_DataKey);
	$_TDataValue = explode('|', $_DataValue);
	$_Data = array_combine($_TDataKey, $_TDataValue);
	arsort($_Data);
	reset($_Data);
	if ($_Code != 'gb2312')
		$_String = _U2_Utf8_Gb($_String);
	$_Res = '';
	for ($i = 0; $i < strlen($_String); $i++) {
		$_P = ord(substr($_String, $i, 1));
		if ($_P > 160) {
			$_Q = ord(substr($_String, ++$i, 1));
			$_P = $_P * 256 + $_Q - 65536;
		}
		$_Res .= _Pinyin($_P, $_Data);
	}
	return preg_replace("/[^A-Za-z0-9]*/", '', $_Res);
}

function _Pinyin($_Num, $_Data) {
	if ($_Num > 0 && $_Num < 160) {
		return chr($_Num);
	} elseif ($_Num < -20319 || $_Num > -10247) {
		return '';
	} else {
		foreach ($_Data as $k => $v) {
			if ($v <= $_Num)
				break;
		}
		return ucfirst($k);
	}
}

function _U2_Utf8_Gb($_C) {
	$_String = '';
	if ($_C < 0x80) {
		$_String .= $_C;
	} elseif ($_C < 0x800) {
		$_String .= chr(0xC0 | $_C >> 6);
		$_String .= chr(0x80 | $_C & 0x3F);
	} elseif ($_C < 0x10000) {
		$_String .= chr(0xE0 | $_C >> 12);
		$_String .= chr(0x80 | $_C >> 6 & 0x3F);
		$_String .= chr(0x80 | $_C & 0x3F);
	} elseif ($_C < 0x200000) {
		$_String .= chr(0xF0 | $_C >> 18);
		$_String .= chr(0x80 | $_C >> 12 & 0x3F);
		$_String .= chr(0x80 | $_C >> 6 & 0x3F);
		$_String .= chr(0x80 | $_C & 0x3F);
	}
	return iconv('UTF-8', 'GB2312', $_String);
}

//通过ID获取城市信息
function _get_city($cityid, $field = 'asname') {
	$cityname= M('line_area')->where("code='$cityid'")->getField($field);
	return $cityname;
}

//获取线路预付金额
function _get_front_money($line_id, $money) {
	return M('line')->where("id='$line_id'")->getfield('front_money') * $money / 100;
}

function get_line_img($line_id, $type = 's') {
	$path = M('line_pic')->where("line_id='$line_id'")->order("istitlepage desc")->getField('pic_path');
	if (!in_array($type, array('s', 'm', 'b', "p")))
		unset($path);
	$pre = array("s" => "s_", "m" => "m_", "b" => "b_", "p" => "");
	// return $path ? __ROOT__ . dirname($path) . "/{$pre[$type]}" . basename($path) : "--";
	return $path ? __ROOT__ . dirname($path) . "/" . basename($path) : "--";
}

function get_hotel_img($hotel_id, $type = 's') {
	$path = M('hotel_pic')->where("hotel_id='$hotel_id'")->order("istitlepage desc")->getField('picpath');
	if (!in_array($type, array('s', 'm', 'b', "p")))
		unset($path);
	$pre = array("s" => "s_", "m" => "m_", "b" => "b_", "p" => "");
	return $path ? __ROOT__ . dirname($path) . "/{$pre[$type]}" . basename($path) : "--";
}

function get_view_img($view_id, $type = 'p') {
	$path = M('viewpoint_pic')->where("viewpoint_id='$view_id'")->order("istitlepage desc")->getField('picpath');
	if (!in_array($type, array('s', 'm', 'b', "p")))
		unset($path);
	$pre = array("s" => "s_", "m" => "m_", "b" => "b_", "p" => "");
	return $path ? __ROOT__ . dirname($path) . "/{$pre[$type]}" . basename($path) : "--";
}

function get_viewpoint_img($viewpoint_id, $type = 's') {
	$path = M('viewpoint_pic')->where("viewpoint_id='$viewpoint_id'")->order("istitlepage desc")->getField('picpath');
	if (!in_array($type, array('s', 'm', 'b', "p")))
		unset($path);
	$pre = array("s" => "s_", "m" => "m_", "b" => "b_", "p" => "");
	return $path ? __ROOT__ . dirname($path) . "/{$pre[$type]}" . basename($path) : "--";
}

function get_line_min_price($id) {
	
	$unix_time = $time;
	$week_date = date("w", $unix_time);
	$mindaterow=M("line_price")->field(" IFNULL(min(price_date),UNIX_TIMESTAMP()) as mindate  ")->where("line_id=".$id." and price_date>=UNIX_TIMESTAMP()")->find();
	$mindate=$mindaterow['mindate'];
	$where['id'] = $id;
	$price_sql = "(price_type=2 and from_unixtime(price_date,'%Y%m%d')= from_unixtime('".$mindate."','%Y%m%d'))  or (price_type=1 and from_unixtime(price_date,'%Y%m%d')= from_unixtime('".$mindate."','%Y%m%d'))";
	$line = M("Line")->getTableName() . " line";
	$line_price = M("line_price")->getTableName() . " price";
	/*
	$table = M()->table($line)
			 ->join($line_price . " on line.id=price.line_id")
			 ->field("line.*,line_id,price_type,price_date,	price_date_end,price_adult,price_children")
			 ->order("price_type")
			 ->select(false);
	$lists = M()->table($table . " as tmp_table1")->where($where)->where($price_sql)->group("line_id")->find();
	*/
	$lists=M("line_price")->field(" min(price_adult) as  price_adult  ")->where("line_id=".$id." and ( (price_type=2 and from_unixtime(price_date,'%Y%m%d')= from_unixtime('".$mindate."','%Y%m%d')) or  (price_type=1  and from_unixtime(price_date,'%Y%m%d')= from_unixtime('".$mindate."','%Y%m%d')) ) ")->find();
	return $lists['price_adult'];
	
	//return 100;
}

function get_min_price($id) {
	$rooms = M("HotelRoomType")
			 ->cache("HotelRoomType_$id", 3600)
			 ->where("hotel_id=$id")
			 ->field("price_retail, price_prefer, price_5, price_6, price_7")
			 ->select();
	$prices = array();
	foreach ($rooms as $room) {
		if ($room["price_5"] <= 0)
			unset($room["price_5"]);
		if ($room["price_6"] <= 0)
			unset($room["price_6"]);
		if ($room["price_7"] <= 0)
			unset($room["price_7"]);
		sort($room);
		$prices = array_merge($prices, $room);
	}
	return min($prices);
}

/**
 * 从 base_config 表中设置或获得某一配置的值<br/>
 * @param string $config_string 配置名称<br/>
 * @param string $value 设置的新值（为空表示获得相应配置的值）<br/>
 * @return mix 返回配置值或返回设置的结果（true 或 false）<br/><br/>
 */
function conf($config_string, $value = null) {
	$setting = M("BaseConfig");
	if (empty($value)) {
		$val = $setting->cache("BaseConfig_{$config_string}")->where("config_key='$config_string'")->getField("config_value");
		return (!empty($val)) ? $val : null;
	} else {
		$val = $setting->where("config_key='$config_string'")->save(array("config_value" => $value));
		S("BaseConfig_{$config_string}", $value);
		return $val;
	}
	return false;
}

/**
 * 根据ID获取原图路径
 * @staticvar null $file_model
 * @param type $id
 * @param type $file_name
 * @return type
 */
function get_file($id, $file_name = "path") {
	static $file_model = null;
	if ($file_model === null) {
		$file_model = M("file_manager");
	}
	$v = $file_model->cache("file_manager_{$id}_{$file_name}", 0)->where("id=$id")->getField($file_name);
	return $v ? __ROOT__.'/'.ltrim($v,"/") : "";
}

function get_adurl($name, $default = "") {
	$ad_db = M("advert")->getTableName() . " ad";
	$area_db = M("advert_area")->getTableName() . " area on ad.area_id=area.id";
	$file_pic = M("advert")->cache("advert_{$name}", 3600)->table($ad_db)->join($area_db)->where("area.status=1 and area.names_en='$name'")->order("ad.sort")->getField("ad.pic");
	return __ROOT__ . get_file($file_pic);
}

/**
 * 根据ID获取缩略图路径
 * Enter description here ...
 * @param $id
 * @param $pre
 */
function get_file_s($id, $pre = "s_") {
	$path = get_file($id);
	if ($path == "")
		return "";
	return dirname($path) . "/" . $pre . basename($path);
}

/**
 * 根据ID获取大图路径
 * Enter description here ...
 * @param $id
 * @param $pre
 */
function get_file_m($id, $pre = "m_") {
	$path = get_file($id);
	if ($path == "")
		return "";
	return dirname($path) . "/" . $pre . basename($path);
}

function f_html($content) {
	return preg_replace(array("/\<[^\>]*\>/", "/\s*/", "/&nbsp;/"), "", $content);
}

/**
 * EditBy：YiZeng<br/>&nbsp;&nbsp;通过CURL的方式从远端获得数据（要求远端必须以json格式返回数据）<br/>
 * @param string $url 请求的URL<br/>
 * @param string|array $param [可选]通过POST传递到远端的数据（例如: a=1&b=2&c=3...）<br/>
 * @param boolean $isJson [可选]是否以json格式返回数据（默认为否，即 false）<br/>
 * @return mix 返回数据<br/><br/>
 */
function curl_post($url, $param = null, $isJson = false) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	if ($param != null && $param != "") {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	}
	if ($isJson == false)
		$data = json_decode(curl_exec($ch), true);
	else
		$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

/**
 * 	返回满意度的方法
 *
 */
function impr_point($arr) {
	foreach ($arr as $v) {
		$s += $v;
	}
	return $s * 5;
}

//获取景点最低价

function get_vp_min_price($id) {
	$viewpoint = M("viewpoint")->getTableName() . " viewpoint";
	$ticket = M("viewpoint_ticket")->getTableName() . " ticket";
	$table = M()->table($ticket)
			 ->where("viewpoint_id='$id'")
			 ->order("inner_price,upon_price,special_money")
			 ->group("viewpoint_id")
			 ->find();
		$list[0] = $table['inner_price'];
		$list[1] = $table['upon_price'];
		$list[2] = $table['special_money'];
		sort($list);
	if($list[0] > '0'){
		return $list[0];
	}elseif($list[1] > '0'){
		return $list[1];
	}elseif($list[2] > '0'){
		return $list[2];
	}else{
		return false;
	}
}

/**
 * 动态生成密码，供修改密码处使用
 */
function randpw($len = 8, $format = 'ALL') {
	$is_abc = $is_numer = 0;
	$password = $tmp = '';
	switch ($format) {
		case 'ALL':
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			break;
		case 'CHAR':
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
			break;
		case 'NUMBER':
			$chars = '0123456789';
			break;
		default :
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			break;
	}
	mt_srand((double) microtime() * 1000000 * getmypid());

	//组合字符串
	while (strlen($password) < $len) {
		//随机字符或数字
		$tmp = substr($chars, (mt_rand() % strlen($chars)), 1);
		//判断是否出现数字了
		if (($is_numer <> 1 && is_numeric($tmp) && $tmp > 0 ) || $format == 'CHAR') {
			$is_numer = 1;
		}
		//判断是否出现字符了
		if (($is_abc <> 1 && preg_match('/[a-zA-Z]/', $tmp)) || $format == 'NUMBER') {
			$is_abc = 1;
		}
		//连接
		$password.= $tmp;
	}
	//判断条件是否符合，或者重新生成
	if ($is_numer <> 1 || $is_abc <> 1 || empty($password)) {
		$password = randpw($len, $format);
	}

	return $password;
}
