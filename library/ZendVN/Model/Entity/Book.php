<?php 

namespace ZendVN\Model\Entity;
use Zend\Json\Json;

class Book
{
	public $id;
	public $name;
	public $description;
	public $price;
	public $special;
	public $sale_off;
	public $picture;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	public $status;
	public $ordering;
	public $category_id;


	public function exchangeArray($data){
	
		$this->id          = (!empty($data['id']))         	    ? $data['id']             :"";
		$this->name        = (!empty($data['name']))   	        ? $data['name']           :"";
		$this->description = (!empty($data['description']))   	? $data['description']    :"";
		$this->price       = (!empty($data['price']))    	    ? $data['price']          :"";
		$this->special     = (!empty($data['special']))    	  	? $data['special']        :"";
		$this->sale_off    = (!empty($data['sale_off'])) 		? $data['sale_off']       :"";
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
		$arr['special'] = ($arr['status']==1)? "special":"normal";
		$sale_off = Json::decode($arr["sale_off"]);
		$arr['sale_off_type']  = $sale_off->type;
		$arr['sale_off_value'] = $sale_off->value;
		return $arr;
	}

}
?>