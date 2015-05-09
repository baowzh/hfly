<?php

/**
 * Description of usercommonAction
 *
 * @author Gemini
 */
class usercommonAction extends CommonAction {
    
    public $user_info;
    public function _initialize() {
        parent::_initialize();
        C("layout_name", "user_layout");
        if (isset($_SESSION["user_id"])){
            //用户信息
            $this->user_info=M("UserInfo")->where("user_id=".$_SESSION["user_id"])->find();
            //用户头像
            $avatar_path=$this->user_info? $this->user_info['avatar_path']:APP_TMPL_PATH."Public/img/members/user.jpg";
			$this->assign("avatar_path", $avatar_path);
        }else
            $this->redirect('login/index');
    }

}

?>
