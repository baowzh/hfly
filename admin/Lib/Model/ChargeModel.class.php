<?php
class ChargeModel extends Model{
	public function CheckVerify($verify) {
		if (md5($verify) != Session::get('verify')) return false;
		return true;
	}

	public function Charge($post){
		$User = M("User");
		$Charge = M("Charge");

		$data['types'] = $post["types"];
		$data['amount'] = $post["amount"];
		$data['addtime'] = date('Y-m-d H:i:s');
		$data['reason'] = $post["reason"];
		$objUser = $User->where('login_name="'.$post['login_name'].'" AND status=1')->find();
		$data['user_id'] = $objUser['id'];
		$data['admin_id'] = $_SESSION [C ( 'USER_AUTH_KEY' )];

		if(isset($objUser))
		{
			if($data['types']=="CHARGE")//充值
			{
				$Charge->add($data);
				$User->setInc('e_amount','id='.$objUser['id'],$data['amount']);
				return "操作成功";
			}
			else if($data['types']=="RECHARGE")
			{
				if($objUser['e_amount']<$data['amount'])
				{
					return "操作失败,金额不足";
				}
				else{
					$Charge->add($data);
					$User->setDec('e_amount','id='.$objUser['id'],$data['amount']);
					return "操作成功";
				}
			}
		}
		else
		{
			return "您输入的用户名不存在";
		}
	}
}
?>
