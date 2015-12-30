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

	public function countItem(){
		return $this->_tableGateway->select()->count();
	}

	public function listItem($arrParam = null,$options = null){
		if($options == null){
			$result =  $this->_tableGateway->select();
			$result->buffer();

		}

		if($options['task'] == "list-item"){
			$result =   $this->_tableGateway->select(function(Select $select) use ($arrParam){
				$select->columns(array("id","name","email"))
				       ->join(array("p"=>"products"),"user.id = p.created_by",array("product"=>"name"),$select::JOIN_LEFT)
					   ->where->equalTo("user.id",$arrParam['id']);
			});
		}

		if($options['task'] == "get-user-by-email"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id","name"))
				       ->where->equalTo("email",$arrParam['my-email']);
			});
		}

		if($options['task'] == "list-item-for-paginator"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id","name","email","avatar","fullname","created"))
				       ->order(array("id DESC"))
					   ->limit($arrParam['ItemCountPerPage'])
					   ->offset(($arrParam['currentPage'] - 1) * $arrParam['ItemCountPerPage']);
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