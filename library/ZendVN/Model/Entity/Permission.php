<?php

namespace ZendVN\Model\Entity;

class Permission
{
	public $id;
 	public $name;
 	public $module;
 	public $controller;
 	public $action;

	public function exchangeArray($data){
	
		$this->id         = (!empty($data['id']))         	? $data['id']             	  :"";
		$this->name       = (!empty($data['name']))         ? $data['name']               :"";
		$this->module     = (!empty($data['module']))       ? $data['module']             :"";
		$this->controller = (!empty($data['controller']))   ? $data['controller']         :"";
		$this->action     = (!empty($data['action']))       ? $data['action']             :"";

	}

}
?>