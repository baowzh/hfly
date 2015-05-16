<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-7-9
 * Time: 上午10:35
 * To change this template use File | Settings | File Templates.
 */
class uploadifyAction extends CommonAction {

    public function _initialize() {
        if (!isset($_COOKIE[$this->session_name])) {
            session_id($_REQUEST[$this->session_name]);
            session_start();
        }
        parent::_initialize();
    }

    public function upload($allowExts = "jpg,gif,png,jpeg", $savePath = "Upload", $other_param = array()) {
        class_exists("UploadFile") or import("ORG.Net.UploadFile");
        $upload = new UploadFile(); //  实例化上传类
        $upload->allowExts = explode(",", $allowExts); //  设置附件上传类型

        $savePath = ($savePath == "/" ) ? "Upload" : trim($savePath, "/");
        $upload->savePath = ROOT_PATH . "/" . $savePath . "/"; //  设置附件上传目录
        if (!is_dir($upload->savePath)) {
            mk_dir($upload->savePath);
        }
        $other_key = array(
            "maxSize" => 6291456,
            "saveRule" => "uniqid",
            "hashType" => null,
            "autoCheck" => null,
            "uploadReplace" => null,
            "allowTypes" => null,
            "thumb" => null,
            "thumbMaxWidth" => 1200,
            "thumbMaxHeight" => 700,
            "thumbPrefix" => null,
            "thumbSuffix" => null,
            "thumbPath" => null,
            "thumbFile" => null,
            "thumbRemoveOrigin" => null,
            "autoSub" => true,
            "subType" => "date",
            "dateFormat" => "Ym",
            "hashLevel" => 1
        );
        foreach ($other_key as $key => $val) {
            if (isset($other_param[$key]))
                $upload->$key = $other_param[$key];
            elseif ($val !== null)
                $upload->$key = $val;
        }

        if (!$upload->upload()) { //  上传错误 提示错误信息
            $result = array(
                "status" => false,
                "Msg" => $upload->getErrorMsg(),
                "info" => null
            );
        } else { //  上传成功 获取上传文件信息
            $result = array(
                "status" => true,
                "Msg" => "上传成功",
                "info" => $upload->getUploadFileInfo()
            );
        }
        return $result;
    }

    public function kind() {
        $allowExts = isset($_POST["allowExts"]) ? $_POST["allowExts"] : "jpg,gif,png,jpeg";
        $savePath = isset($_POST["savePath"]) ? $_POST["savePath"] : "/Upload/kind/images/";
        $file_info = $this->upload($allowExts, $savePath, $_POST);
        if ($file_info["status"] == false) {
            $data = array("error" => $file_info["Msg"], 'stat' => 1, "data" => 1);
        } else {
            $file = $file_info["info"][0];
            $path = $savePath . $file["savename"];
            $data = array(
                "url" => __ROOT__ . $path,
                "error" => 0
            );
        }
        header('Content-Type:text/html; charset=utf-8');
        echo json_encode($data);
    }

    public function head_img() {
        $allowExts = isset($_POST["allowExts"]) ? $_POST["allowExts"] : "jpg,gif,png,jpeg";
        $savePath = isset($_POST["savePath"]) ? $_POST["savePath"] : "/Upload/images/";

        if (isset($_POST["saveRule"]) && substr($_POST["saveRule"], 0, 1) == ":") {
            $filename = create_function("", substr($_POST["saveRule"], 1));
            $_POST["saveRule"] = $filename;
        }
        $file_info = $this->upload($allowExts, $savePath, $_POST);
        if ($file_info["status"] == false) {
            $this->ajaxReturn("", $file_info["Msg"], 0);
            exit;
        }
        $file_manager = M("file_manager");
        foreach ($file_info["info"] as $k => $file) {
          $path = $savePath . $file["savename"];
        	//$path = $savePath . $file["names"];
            $img_size = GetImageSize(ROOT_PATH . "." . $path);
            $data = array(
                "names" => $file["name"],
                "suffix" => $file["extension"],
                "mime" => $file["type"],
                "path" => $path,
                "size" => $file["size"],
                "width" => $img_size[0],
                "height" => $img_size[1]
            );
            $file_info["info"][$k] = $data;
            $file_info["info"][$k]["id"] = $file_manager->add($data);
        }
        $this->ajaxReturn($file_info["info"], $file_info["Msg"], 1);
        
    }

}
