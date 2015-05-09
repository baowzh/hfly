<?php

/**
 * Description of CityBelongModel
 *
 * @author Gemini
 */
class CityBelongModel extends Model {

    private $cookies = array();
    private $last_header;
    private $http_status;

    //出发城市列表
    public function getCityList() {
        $city_table = $this->getTableName() . " city";
        $area_table = M('area')->getTableName() . " area";
        return $this->cache("CityBelongModel/getCityList/CityList", 0)->table($city_table)
                        ->join($area_table . " on city.cid=area.id")
                        ->order("city.sort")
                        ->group("city.cid")
                        ->select();
    }

    //选中的城市
    public function getCurrentCity($cityList) {
        $List = array();
        $isdefault = "";
        if ($cityList) {
            foreach ($cityList as $city) {
                $List[$city["cid"]] = !empty($city["names_en"]) ? strtolower($city["names_en"]) : Pinyin($city["names"]);
                $List_zh[strtolower($city["names_en"])] = $city["names"];
                $isdefault = $city["isdefault"] ? $city["names_en"] : $isdefault;
            }
        }
        $currentcity = isset($_GET["current_city"]) ? strtolower(trim($_GET["current_city"])) : "";
        $currentcity = $currentcity == "" && isset($_COOKIE["current_city"]) ? strtolower(trim($_COOKIE["current_city"])) : $currentcity;
        if (empty($currentcity) || !in_array($currentcity, $List)) {
            $ip = get_client_ip();
            // $ip = "220.173.19.15";
            $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $ip;
            $json = $this->getHttp($url);
            $address = json_decode($json, true);
            $ipcity = empty($address["city"]) ? "nanning" : strtolower(Pinyin($address["city"]));
            $isdefault = in_array($ipcity, $List) ? $ipcity : $isdefault;
            $isdefault || $isdefault = reset($List);
            $currentcity = $isdefault;
        }
        if (!isset($_COOKIE["current_city"]) || $currentcity != $_COOKIE["current_city"]) {
            setcookie("current_city", $currentcity, time() + 864000, "/");
        }
        return array("en" => $currentcity, "zh" => $List_zh[$currentcity], "id" => current(array_keys($List, $currentcity)));
    }

    private function getHttp($url = '', $post = array(), $cookie = array()) {
        /*$conn = curl_init($url);
        curl_setopt($conn, CURLOPT_TIMEOUT, $this->configs['timeout']);
        curl_setopt($conn, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($conn, CURLOPT_MAXREDIRS, 7); //HTTp定向级别
        curl_setopt($conn, CURLOPT_HEADER, 1);
        $this->cookies = array_merge($this->cookies, $cookie);
        if ($this->cookies) {
            curl_setopt($conn, CURLOPT_COOKIE, join(';', $this->cookies));
        }
        if ($post) {
            curl_setopt($conn, CURLOPT_POST, 1);
            curl_setopt($conn, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($conn);
        list($header, $body) = explode("\r\n\r\n", $content);
        preg_match_all("/set\-cookie:([^\r\n]*)/i", $header, $matches);
        $cookies = $cookies_tmp = array();
        if ($matches) {
            foreach ($matches[1] as $match) {
                $cookies_tmp = array_merge($cookies_tmp, explode(";", $match));
            }
        }
        foreach ($cookies_tmp as $item) {
            $item = trim($item);
            if (!in_array($item, $cookies))
                $cookies[] = $item;
        }
        $this->cookies = $cookies;
        $this->last_header = $header;
        preg_match("/^HTTP(?:S)?\/\d\.\d\s(\d*)\s/", $header, $http_status);
        $this->http_status = $http_status[1];
        return $body;*/
    }

}

?>
