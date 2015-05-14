<?php

import('@.ORG.Http');

class CommonAction extends Action {

	protected $authentic = 1;
	protected $session_name = "WEB_PHPSESSID";

	public function _initialize() {
		$this->set_style();
		if (strtolower(MODULE_NAME) == "common")
		$this->authentic = 0;

		if (!isset($_SESSION)) {
			session_name($this->session_name);
			session_start();
		}
		if ($this->authentic) {
			$this->is_authentic();
		} else {
			$this->is_setCookie();
		}
		$this->getPageSize();

		//帮助文章
		$helps = M("article_section")->where("id<7 and model=0")->select();
		if ($helps) {
			foreach ($helps as $key=>$val){
				$article = M("article")->where("cid='".$val[id]."' and status=1")->order("id asc")->limit(5)->select();
				$helps[$key]["list"] = $article;
			}
		}
		$this->assign('helps', $helps);
		//帮助文章
		$about = M("article")->where("cid='1' and status=1")->order("id asc")->limit(10)->select();
		$this->assign('aboutlist', $about);
		
		$selemenu=
		$nav = M("Viewpoint");
		$navlist = $nav->order('sort,id desc')->limit(4)->select();
		$this->assign('navlist', $navlist);

	}

	protected function is_authentic() {
		$this->is_setCookie();
		if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] < 1) {
			$url = U("login/index", array("referer" => base64_encode($_SERVER["REQUEST_URI"])));
			header("location:$url");
			exit;
		}
		$ADMINSTRATOR = in_array($_SESSION['user_id'], explode(",", C('ADMINSTRATOR'))) ? true : false;
		if ($ADMINSTRATOR) {
			return true;
		}
		return true;
	}


	protected function is_setCookie() {
		if (!isset($_SESSION["user_id"]) && isset($_COOKIE["user_id"])) {
			$_user_id = $_COOKIE["user_id"];
			$_user_login_time = $_COOKIE["user_login_time"];
			$_user_login_token = $_COOKIE["user_login_token"];
			$checktoken = md5($_user_id . $_user_login_time . C("DB_PWD"));
			if ($checktoken == $_user_login_token && $this->valid_time($_user_login_time)) {
				$userinfo = M("user")->where("id=" . $_user_id)->find();
				$_SESSION["user_id"] = $userinfo["id"];
				$_SESSION["user_name"] = $userinfo['username'];
				$_SESSION["login_time"] = $userinfo['login_time'];
				$_SESSION["login_ip"] = $userinfo['login_ip'];
				$update = array(
                    'login_time' => time(),
                    'login_ip' => get_client_ip(),
                    'hits' => $userinfo['hits'] + 1,
				);
				M("user")->where("id=" . $userinfo['id'])->save($update);
			} else {
				$time = time();
				if (isset($_COOKIE["user_id"]))
				setcookie("user_id", "", $time - 3600, "/");
				if (isset($_COOKIE["user_login_time"]))
				setcookie("user_login_time", "", $time - 3600, "/");
				if (isset($_COOKIE["user_login_token"]))
				setcookie("user_login_token", "", $time - 3600, "/");
			}
		}
	}

	protected function set_style() {
		$CityBelong = D('CityBelong');

		$cityList = $CityBelong->getCityList();
		$this->assign("cityList", $cityList);
		$this->assign("currentCity", $CityBelong->getCurrentCity($cityList));
		$this->assign("tour_type", D("LineType")->getTypeList());		
		$this->assign("selmenu", $_GET["areaid"]);	
		//echo $_GET["areaid"];
		$this->assign("current", strtolower($this->getActionName()));
		$this->assign("css_list", explode(",", MODULE_NAME));
		$this->assign("js_list", explode(",", "jquery-1.8.3.min,common,SuperSlide-v2.0"));
	}

	protected function valid_time($time) {
		if (!is_numeric($time)) {
			return false;
		}
		$now_time = time();
		$min_time = $now_time - 864000;
		if ($time < $min_time || $time > $now_time) {
			return false;
		}
		return true;
	}

	public function handoff() {
		$current_city = isset($_GET["city"]) ? strtolower(trim($_GET["city"])) : $this->get_city_en();
		setcookie("current_city", $current_city, time() + 86400, "/");
		$url = preg_replace("/current_city\/[a-zA-Z]*/", "current_city/$current_city", $_SERVER["HTTP_REFERER"]);
		header("Location:$url");
	}

	public function get_city_en() {
		$current_city = M("area")->where(array("id" => $_GET['cid']))->getField("names_en");
		return strtolower($current_city);
	}

	public function getPageSize() {
		$pagesize = isset($_COOKIE["pagesize"]) ? intval($_COOKIE["pagesize"]) : 15;
		define("PAGESIZE", $pagesize);
		$sizecount = array(5, 10, 12, 15, 20, 30, 50, 100);

		$pagestr = " 每页显示<select onchange=\"location.href='" . U('Common/setPageSize') . "/pagesize/'+this.value\">";
		foreach ($sizecount as $v) {
			if ($v == $pagesize) {
				$pagestr.="<option value=\"$v\" selected=\"selected\">$v</option>";
			} else {
				$pagestr.="<option value=\"$v\">$v</option>";
			}
		}
		$pagestr.="</select> 条";
		define("PAGESIZE_SELECT", $pagestr);
	}

	public function setPageSize() {
		$url = $_SERVER["HTTP_REFERER"];
		$pagesize = isset($_GET["pagesize"]) ? intval($_GET["pagesize"]) : 15;
		$sizecount = array(5, 10, 12, 15, 20, 30, 50, 100);
		$pagesize = in_array($pagesize, $sizecount) ? $pagesize : 15;
		setcookie("pagesize", $pagesize, time() + 86400 * 365, "/");
		header("Location: $url");
	}

	public function pagebar($count, $pagesize, &$limit = '') {
		$reccent_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		class_exists("Page") or import("ORG.Util.Page");
		$Page = new Page($count, $pagesize);
		$show = $Page->show();

		if ($count > 0) {
			$this->assign("page", $show);
		} else {
			$this->assign("page", $show);
		}
		$limit = $Page->firstRow . "," . $Page->listRows;

		return $reccent_page . "," . PAGESIZE;
	}

	public function verify() {
		class_exists("Image") or import("ORG.Util.Image");
		Image :: buildImageVerify();
	}

	public function success($message, $jumpUrl = '', $ajax = false) {
		C("LAYOUT_NAME", "layout");
		parent::success($message, $jumpUrl, $ajax);
	}

	public function error($message, $jumpUrl = '', $ajax = false) {
		C("LAYOUT_NAME", "layout");
		parent::error($message, $jumpUrl, $ajax);
	}

}

?>
