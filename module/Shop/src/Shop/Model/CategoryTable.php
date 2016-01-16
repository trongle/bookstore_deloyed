<?php 
namespace Shop\Model;

use Admin\Model\NestedTable;
use PHPImageWorkshop\ImageWorkshop;
use ZendVN\File\Image;
use ZendVN\File\Upload;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class CategoryTable extends NestedTable{
	protected $_tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->_tableGateway = $tableGateway;
		return $this;
	}

	public function countItem($arrParam = null,$options = null){
		$result = $this->_tableGateway->select(function(Select $select) use($arrParam){
			$select->where->notEqualTo("parent",0);
			if(!empty($arrParam['filter_status'])){
				$status = ($arrParam['filter_status']=="active")? 1:0;
				$select->where->equalTo("status",(int)$status);
			}

			if(!empty($arrParam['filter_level'])){
				$select->where->equalTo("category.level",$arrParam['filter_level']);
			}

			if(!empty($arrParam['search']['search_value']) && !empty($arrParam['search']['search_key'])){
				if($arrParam['search']['search_key'] != "all"){
					$select->where->like("category.".$arrParam['search']['search_key'],
										 "%".$arrParam['search']['search_value']."%");
				}else{
					$select->where->NEST
					              ->like("category."."name","%".$arrParam['search']['search_value']."%")
								  ->or->equalTo("category."."id",$arrParam['search']['search_value'])
								  ->UNNEST;
				}			
			}
		});
		return $result->count();
	}


	public function listItem($arrParam = null,$options = null){
		if($options['task'] == "shop-category"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id","name","left","right","parent","level"))
				       ->order(array("left ASC"))
				       ->where->notEqualTo("parent",0)			
				       ->where->lessThanOrEqualTo("level",3);			
			});
		}

		return $result;
	}

	public function getItem($arrParam,$options = null){
		return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","parent","level","description"))
					   ->where(array("id"=>$arrParam['id']));
			})->current();
	}

	
}
?>