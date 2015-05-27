<?php

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

function init_request($char = '-') {
	header('Content-type: text/html; charset=' . CHARSET);
	$querystring = $_SERVER['QUERY_STRING'];
	$get = explode($char, $querystring);
	$get = haddslashes($get, 1);
	return $get;
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

/**
 * 根据省市县id返回名称
 * @param type $province
 * @param type $city
 * @param type $county
 */
function getcity($province, $city, $county) {
	static $city_list = array();
	if (!$city_list) {
		$base_city = M("base_city");
		$city_list = $base_city->getField("id,names");
	}
	$citystr = "";
	if (isset($city_list[$province]))
		$citystr .= $city_list[$province];
	if (isset($city_list[$city]))
		$citystr .= "-" . $city_list[$city];
	if (isset($city_list[$county]))
		$citystr .= "-" . $city_list[$county];
	return $citystr ? trim($citystr, "-") : "--";
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
	$v = $file_model->where("id=$id")->getField($file_name);
	return $v ? $v : "";
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
 * 根据id获取后台用户的指定字段的值
 * @staticvar null $user_list
 * @param type $id
 * @param type $field
 * @return type
 */
function get_admin_user($id, $field = "user_name") {
	static $user_list = null;
	if ($user_list === null) {
		$user_list = M("admin_user")->getField("id,role_id,user_name,true_name,last_login_ip,last_login_time,phone,email,create_time,status");
	}
	return $user_list[$id][$field] ? $user_list[$id][$field] : "--";
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
		$user_list = M("user")->getField("id,username,phone,email,create_time,login_time,login_ip,hits,status");
	}
	return $user_list[$id][$field] ? $user_list[$id][$field] : $default;
}

function get_user_group($id, $field = "names", $default = "--") {
	static $user_group = null;
	if ($user_group === null) {
		$group_list = M("user_group")->getField("level,names,min_point,max_point,pic,finance,pay,take,r_monty,one_take,max_take,sms,finance_auto,finance_report");
	}
	return $group_list[$id][$field] ? $group_list[$id][$field] : $default;
}

function str2file($str, $filePath) {
	$fp = fopen($filePath, 'w+');
	fwrite($fp, $str);
	fclose($fp);
}

/**
  +----------------------------------------------------------
 * 从文件中读取字符
  +----------------------------------------------------------
 * @param string $filePath 要读取的文件的路径
  +----------------------------------------------------------
 * @return string
  +----------------------------------------------------------
 */
function file2str($filePath) {
	$fp = fopen($filePath, "r");
	$content_ = fread($fp, filesize($filePath));
	fclose($fp);
	return $content_;
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

//两个时间之差,时间戳参数
function timediff($begin_time, $end_time) {
	if ($begin_time < $end_time) {
		$starttime = $begin_time;
		$endtime = $end_time;

		$timediff = $endtime - $starttime;
		$days = intval($timediff / 86400);
		$remain = $timediff % 86400;
		$hours = intval($remain / 3600);
		$remain = $remain % 3600;
		$mins = intval($remain / 60);
		$secs = $remain % 60;
		$res = array("day" => $days, "hour" => $hours, "min" => $mins, "sec" => $secs);
	} else {
		$res = array("day" => 0, "hour" => 0, "min" => 0, "sec" => 0);
	}
	return $res;
}

function get_starts($num) {
	for ($i = 0; $i < 5; $i++) {
		if ($num > 0) {
			$str .= "<img src='" . __ROOT__ . "/Public/images/start_on.png'>";
		} else {
			$str .= "<img src='" . __ROOT__ . "/Public/images/start_off.png'>";
		}
		$num--;
	}
	return $str;
}

function get_line_img($line_id, $type = 's') {
	$path = M('line_pic')->where("line_id='$line_id'")->order("istitlepage='1' desc")->getfield('pic_path');
	//if (!in_array($type, array('s', 'm', 'b')))
	//	unset($path);
	//return $path ? __ROOT__ . dirname($path) . "/s_" . basename($path) : "--";
	return $path;
	// ? __ROOT__ . dirname($path) . basename($path) : "--";
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
		$val = $setting->where("config_key='$config_string'")->getField("config_value");
		return (!empty($val)) ? $val : null;
	} else {
		$val = $setting->where("config_key='$config_string'")->save(array("config_value" => $value));
		return $val;
	}
	return false;
}

//通过ID获取城市信息
function _get_city($cityid, $field = 'asname') {
	return M('line_area')->where("code='$cityid'")->getField($field);
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

function get_area_type($area_num) {
	switch ($area_num) {
		case 1:return "商圈";
		case 2:return "行政区";
		case 3:return "地铁线路";
		case 4:return "车站、机场";
		case 5:return "观光景点";
		case 6:return "大学";
	}
}
