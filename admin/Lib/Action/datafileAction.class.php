<?php

class datafileAction extends CommonAction {

    public function lists() {
        $ids = array();
        $paths = array();
        $advert_ids = M("advert")->getField("id,pic,s_pic");
        foreach ($advert_ids as $v) {
            if ($v['pic']) {
                $ids = array_merge($ids, array($v['pic']));
            }
            if ($v['s_pic']) {
                $ids = array_merge($ids, array($v['s_pic']));
            }
        }
        $file_manager_paths = M("file_manager")->getField("id,path");
        $paths = array_merge($paths, array_filter((array) $file_manager_paths));
        $article_paths = M("article")->getField("id,pic");
        $paths = array_merge($paths, array_filter((array) $article_paths));

        $hotel_pic_paths = M("hotel_pic")->getField("id,picpath");
        $paths = array_merge($paths, array_filter((array) $hotel_pic_paths));

        $hotel_logopath_paths = M("hotel_room_type")->getField("id,logopath");
        $paths = array_merge($paths, array_filter((array) $hotel_logopath_paths));

        $hotel_type_paths = M("hotel_type")->getField("id,picpath");
        $paths = array_merge($paths, array_filter((array) $hotel_type_paths));

        $line_pic_paths = M("line_pic")->getField("id,pic_path");
        $paths = array_merge($paths, array_filter((array) $line_pic_paths));

        $payment_bank_paths = M("payment_bank")->getField("id,pic");
        $paths = array_merge($paths, array_filter((array) $payment_bank_paths));

        $recommend_paths = M("recommend")->getField("id,pic");
        $paths = array_merge($paths, array_filter((array) $recommend_paths));

        $recommend_paths = M("recommend")->getField("id,pic");
        $paths = array_merge($paths, array_filter((array) $recommend_paths));

        $viewpoint_paths = M("viewpoint_pic")->getField("id,picpath");
        $paths = array_merge($paths, array_filter((array) $viewpoint_paths));

        $dir = "/Upload/images";
        $handle = opendir(ROOT_PATH . "./" . $dir);

        if (!$handle) {
            $this->display();
            closedir($handle);
            exit;
        }
        $nouse = array();
        while (false !== ($lists = readdir($handle))) {
            if ($lists == '.' || $lists == '..') {
                continue;
            }
            $file_dir = $dir . "/" . $lists;
            if (is_file(ROOT_PATH . "./" . $file_dir)) {
                $dirname=dirname($file_dir);
                $basename= preg_replace("/^(s_|m_|b_)/","",basename($file_dir));
                if (!in_array($dirname. "/" . $basename, $paths)) {
                    $nouse[] = array(
                        "img_path" => __ROOT__ . $file_dir,
                        "path" => $file_dir,
                        "filemtime" => filemtime(ROOT_PATH . "./" . $file_dir),
                        "url" => urlencode($file_dir),
                    );
                }
                continue;
            }
            $this->loop_dir($nouse, $file_dir, $paths);
        }

        closedir($handle);
        $count = count($nouse);
        $this->pagebar($count, PAGESIZE, $limit);
        $page = explode(",", $limit);
        $this->assign("lists", array_slice($nouse, $page[0], $page[1]));
        $this->display();
    }

    public function delfile() {
        if ($_POST) {
            foreach ($_POST['deleteall'] as $filename) {
                if (is_file(ROOT_PATH . "./" . $filename)) {
                    @unlink(ROOT_PATH . "./" . $filename);
                }
            }
        } elseif (is_file(ROOT_PATH . "./" . $_GET['filename'])) {

            @unlink(ROOT_PATH . "./" . $_GET['filename']);
        }
        $this->success("删除成功", U("lists"));
    }

    public function download() {
        class_exists("Http") or import("ORG.Util.Http");
        $filepath = $_GET['filename'];
        Http::download(ROOT_PATH . "./" . $filepath);
    }

    public function loop_dir(&$nouse, $dir, $paths) {
        $handle = opendir(ROOT_PATH . "./" . $dir);
        if (!$handle) {
            closedir($handle);
            return;
        }
        while (false !== ($lists = readdir($handle))) {
            if ($lists == '.' || $lists == '..') {
                continue;
            }
            $file_dir = $dir . "/" . $lists;
            if (is_file(ROOT_PATH . "./" . $file_dir)) {
                $dirname=dirname($file_dir);
                $basename= preg_replace("/^(s_|m_|b_)/","",basename($file_dir));
                if (!in_array($dirname. "/" . $basename, $paths)) {
                    $nouse[] = array(
                        "img_path" => __ROOT__ . $file_dir,
                        "path" => $file_dir,
                        "filemtime" => filemtime(ROOT_PATH . "./" . $file_dir),
                        "url" => urlencode($file_dir),
                    );
                }

                continue;
            }
            $this->loop_dir($nouse, $file_dir, $paths);
        }
        closedir($handle);
    }

}
