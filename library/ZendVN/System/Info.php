<?php 
namespace ZendVN\System;

use Zend\Session\Container;

class Info {
	public function __construct(){
		$ssInfo = new Container(BOOKONLINE_KEY."_user");
	}

	public function storeInfo($data){
		
		$ssInfo        = new  Container(BOOKONLINE_KEY."_user");
		$ssInfo->user       = $data['user'];
		$ssInfo->group      = $data['group'];
		$ssInfo->permission = $data['permission'];
	}

	public function getUserInfo($element = null){
		$ssInfo   = new  Container(BOOKONLINE_KEY."_user");
		$userInfo = $ssInfo->user;
		if(!empty($element)) return $userInfo->$element;
		return $userInfo;
	}

	public function getGroupInfo($element = null){
		$ssInfo    = new  Container(BOOKONLINE_KEY."_user");
		$groupInfo = $ssInfo->group;

		if(!empty($element)) return $groupInfo->$element;
		return $groupInfo;
	}

	public function getPermissionInfo($element = null){
		$ssInfo          = new  Container(BOOKONLINE_KEY."_user");
	
		$permmissionInfo = $ssInfo->permission;
		// echo "<pre>";
		// print_r($permmissionInfo);
		// echo "</pre>";exit();

		if(!empty($element)) return $permmissionInfo[$element];
		return $permmissionInfo;
	}

	public function destroyInfo(){
		$ssInfo    = new  Container(BOOKONLINE_KEY."_user");
		$ssInfo->getManager()->getStorage()->clear();
	}


}
?>