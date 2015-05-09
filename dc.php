<?php
error_reporting(0);

	function deleteFile($path){
		global $text;
		if (is_dir($path)){
			$handle=opendir($path);			
			while($list=readdir($handle)){
				if ($list=='.' || $list=='..'){
					//do nothing
				}else{
					$list=$path.'/'.$list;
				}
				switch ($list){
					case $list=='.' || $list=='..':
						//echo $list.' this is  special directory ';
						continue;
					case is_file($list):
						if (unlink($list)){
							$text=$text.'DEL '.$list.'<br/>';
						}else {
							$text=$text. 'DEL SUCCESS';
						}
						break;
					case is_dir($list):
						//$text=$text. '��Ŀ¼ '.$list.'<br/>';
						deleteFile($list);
						break;
					default:
						//$text=$text.'default action '.$list.'';
						continue;
				}
			}
		}else{
			$text=$text. $path.' sorry the path is not directory';
		}
		return  $text;
	}
	
	//ob_start();
	//echo ob_get_contents();
	//ob_end_clean;
	if($GLOBALS["a"]=='') 
	{ 
		$GLOBALS["a"]="1";
		//echo 1;
	}
header('Content-type: text/html; charset=utf-8');
  $abs_dir= dirname(__FILE__);
  $text=deleteFile($abs_dir.'/Cache/admin') . "<br/>";
  $text=deleteFile($abs_dir.'/Cache/web');
  echo $text;
?>