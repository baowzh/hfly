<?php

class AgentModel extends Model
{

  function Agent($post)
    {
    	$User = M("User");
		$Agent = M("Agent");

		$objUser = $User->where("login_name='".$post['login_name']."'")->find();
		$data = $Agent->create();
		$data['user_id'] = $objUser['id'];
		$data['addtime'] = date('Y-m-d H:i:s');
		$data['admin_id'] = $_SESSION ['user_id'];
		if(!empty($objUser))
		{
			if($objUser['user_type']=="0")//判断是否管理员
			{
				return "管理员不能申请报单中心";
			}
			else
			{
				$objAgent = $Agent->where('user_id = '.$objUser['id'].'')->find();
				if(!empty($objAgent))
				{
					if($objAgent['status']==1)
					{
						return "该用户已是报单中心";
					}
					else
					{
						return "该用户已提交申请报单中心，无需重复申请。";
					}
				}
				else
				{
					$Agent->add($data);
					return "操作成功";
				}
			}
		}
		else
		{
			return "您输入的用户名不存在";
		}
    }
    
   function Agent_audit($get) 
    {
    	$User = M("User");
		$Agent = M("Agent");

		$objAgent = $Agent->where('user_id="'.$get[0].'"')->find();
		if(isset($objAgent))
		{
			if($objAgent['status']==0)
			{
				$Agent->where('user_id='.$get[0].'')->setField('status',1);
				$User->where('id='.$get[0].'')->setField('user_type',2);
				return "操作成功";
			}
			else
			{
				return "该会员已审核，勿重复操作";
			}
		}
		else
		{
			return "不存在该会员";
		}
    }
}
?>