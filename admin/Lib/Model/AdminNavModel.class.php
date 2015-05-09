<?php
class AdminNavModel extends Model {

	public function CheckVerify($verify) {
		if (md5($verify) != $_SESSION["verify"]) return false;
		return true;
	}

	//自动验证
	protected $_validate = array(
	);

	//自动填充设置
	protected $_auto = array(
	);

	public function InitNav($get){
		$item = "<div class=mdiv>";		
		$list =$this->where('pid = 0')->order('sort,id')->select();
		$count = count($list);
		for($i=0;$i<$count;$i++)
		{
			$row = $list[$i];
			$page = substr($row["url"],0,strpos($row["url"],'-'));
			$class = $get[0]==$page ? 'hd_tc' : 'hd_ta';
			$item .= "
					<div class=hd_b>
					<div class='".$class."' onMouseOver=this.className='hd_tc' 
					onmouseout=this.className='".$class."'
					onclick=window.location.href='index.php?".$row["url"]."'>".$row["names"]."</div></div>
					";
		}
		$item .= "</div>";
		return $item;
	}

	function InitLeftNav($pid){		
		$list = $this->where('pid="'.$pid.'"')->order('sort')->select();
		$count = count($list);
		for($i=0;$i<$count;$i++)
		{
			$row = $list[$i];
			$item .= "<li>";
			if($row["url"]=="#")
			{
				$item .= "<a onclick=DoMenu('ChildMenu".$i."') hidefocus='true' class='sub' href='#'>".$row["names"]."</a>";
			}
			else
			{
				$item .= "<a onclick=DoMenu('ChildMenu".$i."') target='fbody1' hidefocus='true' class='sub' href='__ENTER_PAGE__/".str_replace('-', '/', $row["url"])."'>".$row["names"]."</a>";
			}
			$list2 = $this->where('pid="'.$row["id"].'"')->order('sort')->select();
			$count2 = count($list2);
			if($count2>0)
			{
				$item .= "<ul id='ChildMenu".$i."' class='collapsed'>";
				for($j=0;$j<$count2;$j++)
				{
					$row2 = $list2[$j];
					$item .= "<li><a href=__ENTER_PAGE__/".str_replace('-', '/', $row2["url"])." target='fbody1' hidefocus='true' class='sub'>".$row2["names"]."</a></li>";
				}
				$item .= "</ul>";
			}
			$item .= "</li>";
		}
		return $item;
	}
        public function getNav() {        
        $Nav_list = $this->where("pid=0")->order("sort")->select();
        if ($Nav_list) {
            foreach ($Nav_list as $list_k => $list_v) {               
                $Nav_menu.="<tr>
                    <td align='center'>
                    <input name='sort[" . $list_v["id"] . "]' type='text' size='3' value='" . $list_v["sort"] . "' class='input-text-c'></td>
                    <td align='center'>" . $list_v["id"] . "</td>
                    <td class='left'>" . $list_v["names"] . " &nbsp;</td>
                    <td align='center'><a href='" . U("Adminnav/add", array('pid' => $list_v["id"])) . "'>添加子菜单</a> | 
                    <a href='" . U("Adminnav/edit", array('catid' => $list_v["id"])) . "'>修改</a> | 
                    <a href=\"javascript:confirm_delete('" . U("Adminnav/del", array('catid' => $list_v["id"])) . "')\">删除</a></td>
                   </tr>";
                $Nav_menu.=$this->nav_sub($list_v["id"], "");
            }
        }
        return $Nav_menu;
    }

    public function nav_sub($parentid, $loop) {        
        $count = $this->where("pid=" . $parentid)->count();
        if ($count == 0) {
            return "";
        }
        $loop.="&nbsp;&nbsp;&nbsp;";
        $i = 1;
        $Nav_list = $this->where("pid=" . $parentid)->order("sort")->select();
        if ($Nav_list) {
            foreach ($Nav_list as $list_k => $list_v) {
                $tree = $i == $count ? $loop . "└─ " : $loop . "├─ ";                
                $Nav_menu.="<tr>
                    <td align='center'>
                    <input name='sort[" . $list_v["id"] . "]' type='text' size='3' value='" . $list_v["sort"] . "' class='input-text-c'></td>
                    <td align='center'>" . $list_v["id"] . "</td>
                    <td class='left'>" . $tree . $list_v["names"] . " &nbsp;</td>                    
                    <td align='center'><a href='" . U("Adminnav/add", array('pid' => $list_v["id"])) . "'>添加子菜单</a> | 
                    <a href='" . U("Adminnav/edit", array('catid' => $list_v["id"])) . "'>修改</a> | 
                    <a href=\"javascript:confirm_delete('" . U("Adminnav/del", array('catid' => $list_v["id"])) . "')\">删除</a></td>
                   </tr>";
                $Nav_menu.=$this->nav_sub($list_v["id"], $loop);
                $i++;
            }
        }
        return $Nav_menu;
    }

    public function getOption($parid) {       
        $parid = $parid ? intval($parid) : 0;
        $Option_list = $this->where("pid=0")->order("sort")->select();
        if ($Option_list) {
            foreach ($Option_list as $list_k => $list_v) {
                $selseted = $list_v["id"] == $parid ? "\" selected=\"selected" : "";
                $Option_str.="<option value=\"" . $list_v["id"] . $selseted . "\".>" . $list_v["names"] . "</option>";
                $Option_str.=$this->option_sub($parid, $list_v["id"], "");
            }
        }
        return $Option_str;
    }

    private function option_sub($parid, $parentid, $loop) {        
        $count = $this->where("pid=" . $parentid)->count();
        if ($count == 0) {
            return "";
        }
        $loop.="&nbsp;";
        $i = 1;
        $Option_list = $this->where("pid=" . $parentid)->order("sort")->select();
        if ($Option_list) {
            foreach ($Option_list as $list_k => $list_v) {
                $tree = $i == $count ? $loop . "└ " : $loop . "├ ";
                $selseted = $list_v["id"] == $parid ? "\" selected=\"selected" : "";
                $Option_str.="<option value=\"" . $list_v["id"] . $selseted . "\".>" . $tree . $list_v["names"] . "</option>";
                $Option_str.=$this->option_sub($parid,$list_v["id"], $loop);
                $i++;
            }
        }
        return $Option_str;
    }
}
?>