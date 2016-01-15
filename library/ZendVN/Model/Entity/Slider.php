<?php 

namespace ZendVN\Model\Entity;
use Zend\Json\Json;

class Slider
{
	public $id;
	public $name;
	public $description;
	public $price;
	public $picture;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	public $status;
	public $ordering;
	public $book_id;


	public function exchangeArray($data){
	
		$this->id          = (!empty($data['id']))         	    ? $data['id']             :"";
		$this->name        = (!empty($data['name']))   	        ? $data['name']           :"";
		$this->description = (!empty($data['description']))   	? $data['description']    :"";
		$this->price       = (!empty($data['price']))    	    ? $data['price']          :"";
		$this->picture     = (!empty($data['picture']))			? $data['picture']     	  :"";
		$this->created     = (!empty($data['created']))   		? $data['created']        :"";
		$this->created_by  = (!empty($data['created_by']))   	? $data['created_by']     :"";
		$this->modified    = (!empty($data['modified']))  		? $data['modified']       :"";
		$this->modified_by = (!empty($data['modified_by']))   	? $data['modified_by']    :"";
		$this->status      = (!empty($data['status']))   		? $data['status']         :"";
		$this->ordering    = (!empty($data['ordering']))   		? $data['ordering']       :"";
		$this->category_id = (!empty($data['category_id']))   	? $data['category_id']    :"";
	}	
	public function getArrayCopy(){
		$arr = get_object_vars($this);
		$arr['status'] = ($arr['status']==1)? "active":"inactive";
		return $arr;
	}

}
?>