<?php

namespace ZendVN\Model\Entity;

class Nested
{
	public $id;
	public $name;	
	public $parent;
	public $status;
	public $left;
	public $right;	
	public $level;

	public function exchangeArray($data){
		$this->id     = (!empty($data['id']))         ? $data['id']     :"";
		$this->name   = (!empty($data['name']))       ? $data['name']   :"";
		$this->level  = (!empty($data['level']))      ? $data['level']  :"";
		$this->parent = (!empty($data['parent']))     ? $data['parent'] :"";
		$this->left   = (!empty($data['left']))       ? $data['left']   :"";
		$this->right  = (!empty($data['right']))      ? $data['right']  :"";
		$this->status = (!empty($data['status']))     ? $data['status'] :"";

	}

	public function getArrayCopy(){
		$arr = get_object_vars($this);
		$arr['status'] = ($arr['status']==1)? "active":"inactive";
		return $arr;
	}

}