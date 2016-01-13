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

	public function changeMoveNode($arrParam = null,$options = null){
		if($options == null){
			if($arrParam["status"] == "up") $this->moveUp($arrParam["id"]);
			if($arrParam["status"] == "down") $this->moveDown($arrParam["id"]);
			return true;
		}
		return false;
	}

	public function deleteItem($arrParam,$options = null){
		if($options['task'] == "delete-multi"){
			if(!empty($arrParam)){
				foreach ($arrParam as  $id) {
					$this->removeNode($id,array("action" => "one"));
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
		if(!empty($arrParam['description'])){
			$input  = $arrParam['description'];
			$config = array(
				"HTML.AllowedAttributes" =>array("style"),
				"HTML.AllowedElements" =>array("p","b","em","span","strong"),
			);
			$filter = new \ZendVN\Filter\Purifier($config);
			$arrParam['description'] = $filter->filter($input);
		}
		//Quenr@i3
		if($options['task'] == "add-item"){
			$arrParam['status']   = ($arrParam['status']=="active")? 1:0;
			$arrParam['created']  = date("Y-m-d H:i:s");			
			$this->insertNode($arrParam,$arrParam['parent'],array("position" => "right"));
			return $this->_tableGateway->getLastInsertValue();
		}
		if($options['task'] == "edit-item"){
			$arrParam['status'] = ($arrParam['status'] == "active") ? 1:0;
			$arrParam['modified'] = date("Y-m-d H:i:s");
			$nodeParentID = ($arrParam['parent'] == $arrParam["id"]) ? null:$arrParam['parent'];
			unset($arrParam['parent']);
			$this->updateNode($arrParam,$arrParam['id'],$nodeParentID);
			return $arrParam['id'];
		}
	}

	public function getItem($arrParam,$options = null){
		return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","parent","level","description"))
					   ->where(array("id"=>$arrParam["id"]));
			})->current();
	}

	public function itemInSelectBox($arrParam = null,$options = null){
		if($options == null){
			$result = $this->_tableGateway->select(function(select $select) use($arrParam){
					$select->columns(array("id","level"))
					       ->order(array("level DESC"));
			})->current();
			$item = array();
			if(!empty($result)){
				for($i = 1;$i <= $result->level;$i++){
					$item[$i] = "level ".$i; 
				}
			}
		}

		if($options['task'] == "list-form"){
			$result = $this->_tableGateway->select(function(select $select) use($arrParam){
					$select->columns(array("id","level","name"))
					       ->order(array("left ASC"));
			});
			$item = array();
			if(!empty($result)){
				foreach($result as $row){
					$item[$row->id] = str_repeat("-------|",$row->level)." ".$row->name;
				}
			}
		}

		if($options['task'] == "list-book"){
			$result = $this->_tableGateway->select(function(select $select) use($arrParam){
					$select->columns(array("id","level","name"))
					       ->order(array("left ASC"))
					       ->where->notEqualTo("id",1);
			});
			$item = array();
			if(!empty($result)){
				foreach($result as $row){
					$item[$row->id] = str_repeat("-------|",$row->level)." ".$row->name;
				}
			}
		}

		return $item;
	}
}
?>