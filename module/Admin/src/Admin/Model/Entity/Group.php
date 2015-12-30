<?php 
namespace Admin\Model\Entity;

class Group
{
	public $id;
	public $name;
	public $ordering;
	public $status;
	public $created;
	public $created_by;
	public $modified_by;
	public $modified;

	public function exchangeArray($data){
	
		$this->id          = (!empty($data['id']))         ? $data['id']          :"";
		$this->name        = (!empty($data['name']))       ? $data['name']        :"";
		$this->ordering    = (!empty($data['ordering']))   ? $data['ordering']    :"";
		$this->status      = (!empty($data['status']))     ? $data['status']      :"";
		$this->created     = (!empty($data['created']))    ? $data['created']     :"";
		$this->created_by  = (!empty($data['created_by'])) ? $data['created_by']  :"";
		$this->modified_by = (!empty($data['modified_by']))? $data['modified_by'] :"";
		$this->modified    = (!empty($data['modified']))   ? $data['modified']    :"";
	}

	public function getArrayCopy(){
		return get_object_vars($this);
	}
}
?>