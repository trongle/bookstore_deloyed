<?php 
namespace Admin\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class GroupTable extends AbstractTableGateway{
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
						$select->where->like($arrParam['search']['search_key'],
											 "%".$arrParam['search']['search_value']."%");
					}else{
						$select->where->NEST
						              ->like("name","%".$arrParam['search']['search_value']."%")
									  ->or->equalTo("id",$arrParam['search']['search_value'])
									  ->UNNEST;
					}		
			}
		});
		return $result->count();
	}

	public function listItem($arrParam = null,$options = null){
		if($options['task'] == "list-item"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id","name","ordering","created","created_by","status"))
				       ->order(array(sprintf("%s %s",$arrParam['order']['order_by'] , $arrParam['order']['order'])))
				       ->offset(($arrParam['paginator']['curentPage']-1) * $arrParam['paginator']['itemPerPage'])
				       ->limit($arrParam['paginator']['itemPerPage']);

				if(!empty($arrParam['filter_status'])){
					$status = ($arrParam['filter_status']=="active")? 1:0;
					$select->where->equalTo("status",$status);
				} 

				if(!empty($arrParam['search']['search_value']) && !empty($arrParam['search']['search_key'])){
					if($arrParam['search']['search_key'] != "all"){
						$select->where->like($arrParam['search']['search_key'],
											 "%".$arrParam['search']['search_value']."%");
					}else{
						$select->where->NEST
						              ->like("name","%".$arrParam['search']['search_value']."%")
									  ->or->equalTo("id",$arrParam['search']['search_value'])
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
		}
		if($options['task'] == "change-multi-status"){
			echo "<pre>";
			print_r($arrParam);
			echo "</pre>";
			$data = array(
				"status" => $arrParam['status']
			);
			 $where = "id IN (".implode(",",$arrParam['id']).")";
			$this->_tableGateway->update($data,$where);
		}
	}

	public function deleteItem($arrParam,$options = null){
		if($options['task'] == "delete-multi"){
			foreach ($arrParam as  $value) {
				$this->_tableGateway->delete(array("id"=>$value));
			}			
		}
	}
}
?>