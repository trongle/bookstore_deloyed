<?php 
namespace Shop\Model\Entity;

class Category
{
	public $id;
	public $name;	
	public $parent;
	public $status;
	public $left;
	public $right;	
	public $level;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	public $description;

	public function exchangeArray($data){
		$this->id          = (!empty($data['id']))         ? $data['id']     :"";
		$this->name        = (!empty($data['name']))       ? $data['name']   :"";
		$this->level       = (!empty($data['level']))      ? $data['level']  :"";
		$this->parent      = (!empty($data['parent']))     ? $data['parent'] :"";
		$this->left        = (!empty($data['left']))       ? $data['left']   :"";
		$this->right       = (!empty($data['right']))      ? $data['right']  :"";
		$this->created     = (!empty($data['created']))     ? $data['created'] :"";
		$this->created_by  = (!empty($data['created_by']))     ? $data['created_by'] :"";
		$this->modified    = (!empty($data['modified']))     ? $data['modified'] :"";
		$this->modified_by = (!empty($data['modified_by']))     ? $data['modified_by'] :"";
		$this->description = (!empty($data['description']))     ? $data['description'] :"";
		$this->status      = (!empty($data['status']))     	? $data['status'] :"";

	}

	public function getArrayCopy(){
		$arr = get_object_vars($this);
		$arr['status'] = ($arr['status']==1)? "active":"inactive";
		return $arr;
	}

}