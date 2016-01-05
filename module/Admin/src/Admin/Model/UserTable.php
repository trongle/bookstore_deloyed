<?php 
namespace Admin\Model;

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
				$select->columns(array("id","username","ordering","created","created_by","status","fullname","email"))
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
		if($options['task'] == "add-item"){
			$arrParam['status'] = ($arrParam['status']=="active")? 1:0;
			$arrParam['created'] = date("Y-m-d H:i:s");
			$this->_tableGateway->insert($arrParam);
			return $this->_tableGateway->getLastInsertValue();
		}
		if($options['task'] == "edit-item"){
			$arrParam['status'] = ($arrParam['status'] == "active") ? 1:0;
			$arrParam['modified'] = date("Y-m-d H:i:s");
			$this->_tableGateway->update($arrParam,array("id"=>$arrParam['id'])); 
			return $arrParam['id'];
		}
	}

	public function getItem($arrParam,$options = null){
		return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","ordering","status"))
					   ->where(array("id"=>$arrParam["id"]));
			})->current();
	}
}
?>