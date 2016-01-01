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
			});
		}
		return $result;
	}

	public function getItem($arrParam = null,$options = null){
		if($options['task'] = "get-item"){
			if(!empty($arrParam)){
				$row =  $this->_tableGateway->select(array("id"=>$arrParam['id']))->current();
				if(empty($row)) return false;
			}
		}

		if($options == null){
			if(!empty($arrParam)){
				$row =  $this->_tableGateway->select(function(Select $select) use($arrParam){
					$select->columns(array("id","name","avatar","fullname","email"))
					       ->where->equalTo("id",$arrParam['id']);
				})->current();
				if(empty($row)) return false;
			}
		}
		return $row;	
	}

	public function deleteItem($arrParam = null,$options = null){
		if($options['task'] = "delete-item"){
			if(!empty($arrParam)){
				$this->_tableGateway->delete(array("id"=>$arrParam['id']));
			}	
		}	
	}

	public function saveItem($arrParam = null,$options = null){
	
			if(!empty($arrParam)){
				if($this->getItem($arrParam,array("task"=>"get-item")) == false 
				   || empty($arrParam['id'])){

					$this->_tableGateway->insert($arrParam);
				}else{
					$this->_tableGateway->update($arrParam,array("id"=>$arrParam['id']));
				}
			}	
		
		
	}
}
?>