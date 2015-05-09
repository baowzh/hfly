<?php
class advertAreaModel extends Model{
	protected  $_validate=array(
	 array("names_en", "", "英文标识已存在", 0, "unique",3),
	);

}