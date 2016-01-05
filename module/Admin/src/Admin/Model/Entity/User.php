<?php 
namespace Admin\Model\Entity;

class User
{




	public $id;
	public $username;
	public $ordering;
	public $status;
	public $created;
	public $created_by;
	public $modified_by;
	public $modified;
	public $email;
	public $fullname;
	public $password;
	public $active_code;
	public $active_time;
	public $register_ip;
	public $register_time;
	public $group_id;

	public function exchangeArray($data){
	
		$this->id            = (!empty($data['id']))         	? $data['id']          :"";
		$this->username      = (!empty($data['username']))   	? $data['username']    :"";
		$this->ordering      = (!empty($data['ordering']))   	? $data['ordering']    :"";
		$this->status        = (!empty($data['status']))    	? $data['status']      :"";
		$this->created       = (!empty($data['created']))    	? $data['created']     :"";
		$this->created_by    = (!empty($data['created_by'])) 	? $data['created_by']  :"";
		$this->modified_by   = (!empty($data['modified_by']))	? $data['modified_by'] :"";
		$this->modified      = (!empty($data['modified']))   	? $data['modified']    :"";
		$this->email         = (!empty($data['email']))   	 	? $data['email']       :"";
		$this->fullname      = (!empty($data['fullname']))  	? $data['fullname']    :"";
		$this->password      = (!empty($data['password']))   	? $data['password']    :"";
		$this->active_code   = (!empty($data['active_code']))   ? $data['active_code']    :"";
		$this->active_time   = (!empty($data['active_time']))   ? $data['active_time']    :"";
		$this->register_ip   = (!empty($data['register_ip']))   ? $data['register_ip']    :"";
		$this->register_time = (!empty($data['register_time'])) ? $data['register_time']    :"";
		$this->group_id      = (!empty($data['group_id']))   	? $data['group_id']    :"";
	}

	public function getArrayCopy(){
		
		$arr = get_object_vars($this);
		$arr['status'] = ($arr['status']==1)? "active":"inactive";
		return $arr;
	}

}
?>