<?php
import("@.Jeesell.Award");
class UserModel extends Model {

	//自动验证
	protected $_validate = array ();

	//自动填充设置
	protected $_auto = array ();

	public function CheckVerify($verify) {
		if (md5($verify) != Session :: get('verify'))
		return false;
		return true;
	}

	public function register() {
		echo "$data";
		//$this->add($data);

	}

	public function listAllUser() {
		$list = $this->select();
		return $list;
	}

	//验证用户是否存在
	public function IsExit($id, $status = 1) {
		$User = M("User");
		$count = $User->where("id=$id AND status=$status")->count();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}

	//验证用户是否存在
	public function IsExitByName($login_name, $status = 1) {
		$User = M("User");
		$count = $User->where("login_name='$login_name' AND status=$status")->count();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	//验证报单中心是否存在
	public function IsExitByBizIdName($login_name, $status = 1) {
		if ($login_name == "admin") {
			return true;
		} else {
			$User = M("User");
			$id = $User->where("login_name='$login_name' AND status=$status")->getField('id');

			$agent = M("Agent");
			$count = $agent->where("user_id=$id")->count();
			if ($count > 0) {
				return true;
			} else {
				return false;
			}
		}

	}

	//验证用户位置是否存在
	public function IsExitByArea($id) {
		$User = M("User");
		$count = $User->where("id=$id  AND status=1")->count();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}

	//激活用户
	public function Activation($id) {
		$User = M("User");
		$BaseConfig = M("BaseConfig");
		$objUser = $User->where('id=' . $id)->find();
		$unit_count = $objUser['unit_count'];
		//累计左右区用户数
		self :: DoUserSubcount($id, 1, $unit_count);
		$Award = new Award();
		//推荐奖
		$Award->AwardRec($id);
		//组织业绩
		//$Award->AwardOrg($id);
		//对碰奖
		$Award->AwardCom($id);
		//见点奖
		$Award->AwardDot($id);
		//层碰奖
		$Award->AwardLayerCom();
		//把激活对象写到激活表中
		$unitusers = $User->where("id=$id")->find();
		//dump($unitusers);
		$Active_line = M("ActiceLine");
		$data['user_id'] = $id;
		$data['active_time'] = date('Y-m-d H:i:s');
		$data['status'] = 0;
		$data['pid'] = $Active_line->order('id DESC')->getField('id');
		$data['unit_count']=$unitusers['unit_count'];
		$Active_line->add($data);
		//排网奖
		$Award->AwardNet($id);
		$Award->AwardLayerCom();
		//更新用户状态
		$datas['status'] = 1;
		$User->where("id=$id")->data($datas)->save();
		return true;
	}

	public function DoUserSubcount($id, $layer, $unit_count) {
		$User = M("User");
		$objUser = $User->where('id=' . $id)->find();
		$pid = $objUser['pid'];
		$area = $objUser['area'];
		if ($pid != "0") {
			//更新user_subcount
			$result = self :: UpdateUserSubCount($pid, $area, $unit_count);
			//更新layer_list
			$result2 = self :: UpdateLayerList($pid, $area, $layer, $unit_count);
			if ($result && $result2) {
				$layer = $layer +1;
				self :: DoUserSubcount($pid, $layer, $unit_count);
			}
		}
	}

	//更新用户数user_subcount
	public function UpdateUserSubCount($id, $area, $unit_count, $unit_count) {
		if ($area == "1") {
			$UserSubcount = M("UserSubcount");
			$UserSubcount->setInc('count_left_total', "id=$id", $unit_count);
			$UserSubcount->setInc('count_left_remain', "id=$id", $unit_count);
			return true;
		}
		if ($area == "2") {
			$UserSubcount = M("UserSubcount");
			$UserSubcount->setInc('count_right_total', "id=$id", $unit_count);
			$UserSubcount->setInc('count_right_remain', "id=$id", $unit_count);
			return true;
		}
	}

	//更新用户数layer_list
	public function UpdateLayerList($id, $area, $layer, $unit_count) {
		//判断该位置是否已经有用户
		$LayerList = M("LayerList");
		$objLayerList = $LayerList->where("user_id=$id AND layer=$layer AND area=$area")->find();
		if (empty ($objLayerList)) //不存在
		{
			$data['user_id'] = $id;
			$data['layer'] = $layer;
			$data['area'] = $area;
			$data['unit_count'] = $unit_count;
			$data['status'] = 0;
			$LayerList->add($data);
		} else
		if ($objLayerList['unit_count'] < $unit_count) //已经存在
		{
			$data['unit_count'] = $unit_count;
			$data['status'] = 0;
			$LayerList->where("id=" . $objLayerList['id'])->save($data);
		}
		return true;
	}

}
?>