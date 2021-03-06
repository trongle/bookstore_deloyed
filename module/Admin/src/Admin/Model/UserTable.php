<?php 
namespace Admin\Model;

use PHPImageWorkshop\ImageWorkshop;
use ZendVN\File\Image;
use ZendVN\File\Upload;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class UserTable extends AbstractTableGateway{
	protected $_tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->_tableGateway = $tableGateway;
		return $this;
	}

	public function countItem($arrParam = null,$options = null){
		$result = $this->_tableGateway->select(function(Select $select) use($arrParam){
			if(!empty($arrParam['filter_status'])){
				$status = ($arrParam['filter_status']=="active")? 1:0;
				$select->where->equalTo("status",(int)$status);
			}

			if(!empty($arrParam['filter_group'])){
				$select->where->equalTo("group_id",$arrParam['filter_group']);
			} 

			if(!empty($arrParam['search']['search_value']) && !empty($arrParam['search']['search_key'])){
				if($arrParam['search']['search_key'] != "all"){
					$select->where->like("user.".$arrParam['search']['search_key'],
										 "%".$arrParam['search']['search_value']."%");
				}else{
					$select->where->NEST
					              ->like("user."."username","%".$arrParam['search']['search_value']."%")
								  ->or->equalTo("user."."id",$arrParam['search']['search_value'])
								  ->or->like("email","%".$arrParam['search']['search_value']."%")
								  ->UNNEST;
				}			
			}
		});
		return $result->count();
	}

	public function listItem($arrParam = null,$options = null){
		if($options['task'] == "list-item"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id","username","avatar","ordering","modified","modified_by","created","created_by","status","fullname","email"))
				       ->join(array("g"=>"groups"),
				       		  "g.id = user.group_id",
				       		  array("name"),
				       		  $select::JOIN_LEFT
				       	)
				       ->order(array(sprintf("%s %s",$arrParam['order']['order_by'] , $arrParam['order']['order'])))
				       ->offset(($arrParam['paginator']['curentPage']-1) * $arrParam['paginator']['itemPerPage'])
				       ->limit($arrParam['paginator']['itemPerPage']);

				if(!empty($arrParam['filter_status'])){
					$status = ($arrParam['filter_status']=="active")? 1:0;
					$select->where->equalTo("user.status",$status);
				}

				if(!empty($arrParam['filter_group'])){
					$select->where->equalTo("group_id",$arrParam['filter_group']);
				} 

				if(!empty($arrParam['search']['search_value']) && !empty($arrParam['search']['search_key'])){
					if($arrParam['search']['search_key'] != "all"){
						$select->where->like("user.".$arrParam['search']['search_key'],
											 "%".$arrParam['search']['search_value']."%");
					}else{
						$select->where->NEST
						              ->like("user."."username","%".$arrParam['search']['search_value']."%")
									  ->or->equalTo("user."."id",$arrParam['search']['search_value'])
									  ->or->like("email","%".$arrParam['search']['search_value']."%")
									  ->UNNEST;
					}	
					
				}
			  // echo $select->getSqlString();exit();
			});
		}
		return $result;
	}

	public function changeStatus($arrParam = null,$options = null){
		if($options['task'] == "change-status"){
			$data = array(
				"status" => ($arrParam['status'] == 1)? (int)0 : 1
			);
			$where = array("id" => $arrParam['id']);
			$this->_tableGateway->update($data,$where);
			return true;
		}
		if($options['task'] == "change-multi-status"){
			$data = array(
				"status" => $arrParam['status']
			);
			 $where = "id IN (".implode(",",$arrParam['id']).")";
			$this->_tableGateway->update($data,$where);
			return true;
		}
		return false;
	}

	public function deleteItem($arrParam,$options = null){
		if($options['task'] == "delete-multi"){
			if(!empty($arrParam)){
				foreach ($arrParam as  $value) {
					$avatar = new Image();
					$avatarName = $this->getItem(array("id"=>$value));
					$avatar->removeAvatar($avatarName->avatar);
					$this->_tableGateway->delete(array("id"=>$value));
				}	
				return true;
			}				
		}
		return false;
	}

	public function ordering($arrParam,$options = null){
		if(!empty($arrParam['id'])){
			foreach ($arrParam["id"] as  $id) {
				$data = array(
					"ordering" => $arrParam["ordering"][$id]
				);
				$where = array(
					"id" => $id
				);
				$this->_tableGateway->update($data,$where);
			}	
			return true;
		}
		return false;						
	}

	public function saveItem($arrParam,$options = null){
		if(!empty($arrParam['sign'])){
			$input  = $arrParam['sign'];
			$config = array(
				"HTML.AllowedAttributes" =>array("style"),
				"HTML.AllowedElements" =>array("p","b","em","span","strong"),
			);
		
			$filter = new \ZendVN\Filter\Purifier($config);
			$arrParam['sign'] = $filter->filter($input);
		}
		//Quenr@i3
		if($options['task'] == "add-item"){
			$arrParam['status']   = ($arrParam['status']=="active")? 1:0;
			$arrParam['created']  = date("Y-m-d H:i:s");
			$arrParam['password'] = md5($arrParam['password']);		
			$arrParam['group_id'] = $arrParam["group"];
			if(!empty($arrParam['image']['tmp_name'])){
				$avatar = new Image();
				$arrParam['avatar'] = $avatar->upload("image");
			}
			
			unset($arrParam["group"]); 
			unset($arrParam["image"]);
			
			$this->_tableGateway->insert($arrParam);
			return $this->_tableGateway->getLastInsertValue();
		}
		if($options['task'] == "edit-item"){

			$arrParam['status'] = ($arrParam['status'] == "active") ? 1:0;
			$arrParam['modified'] = date("Y-m-d H:i:s");
			$arrParam['group_id'] = $arrParam["group"];
			if(!empty($arrParam['image']['tmp_name'])){
				$avatar = new Image();
				//xóa avatar cũ
				$avatar->removeAvatar($arrParam['avatar']);

				$arrParam['avatar'] = $avatar->upload("image");
			}
			unset($arrParam["group"]);
			unset($arrParam["image"]);
			//kiem tra neu co nhap password
			if(empty($arrParam["password"])){
				unset($arrParam["password"]);
			}else{
				$arrParam["password"] = md5($arrParam["password"]);
			}
			$this->_tableGateway->update($arrParam,array("id"=>$arrParam['id'])); 
			return $arrParam['id'];
		}
	}

	public function getItem($arrParam,$options = null){
		return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","username","email","group_id","avatar","sign","fullname","ordering","status"))
					   ->where(array("id"=>$arrParam["id"]));
			})->current();
	}
}
?>