<?php 
namespace Admin\Model;

use PHPImageWorkshop\ImageWorkshop;
use ZendVN\File\Image;
use ZendVN\File\Upload;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Json\Json;

class SliderTable extends AbstractTableGateway{
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
					$select->where->like("slider.".$arrParam['search']['search_key'],
										 "%".$arrParam['search']['search_value']."%");
				}else{
					$select->where->NEST
					              ->like("slider."."name","%".$arrParam['search']['search_value']."%")
								  ->or->equalTo("slider."."id",$arrParam['search']['search_value'])
								  ->UNNEST;
				}			
			}
		});
		return $result->count();
	}

	public function listItem($arrParam = null,$options = null){
		if($options['task'] == "list-item"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id","name","picture","ordering","modified","modified_by","created","created_by","status","price"))
				       ->join(array("b"=>"book"),
				       		"b.id = slider.book_id",
				       		array("book_name"=>"name"),
				       		"left"
				       	)
				       ->order(array(sprintf("%s %s",$arrParam['order']['order_by'] , $arrParam['order']['order'])))
				       ->offset(($arrParam['paginator']['curentPage']-1) * $arrParam['paginator']['itemPerPage'])
				       ->limit($arrParam['paginator']['itemPerPage']);

				if(!empty($arrParam['filter_status'])){
					$status = ($arrParam['filter_status']=="active")? 1:0;
					$select->where->equalTo("slider.status",$status);
				}		

				if(!empty($arrParam['search']['search_value']) && !empty($arrParam['search']['search_key'])){
					if($arrParam['search']['search_key'] != "all"){
						$select->where->like("slider.".$arrParam['search']['search_key'],
											 "%".$arrParam['search']['search_value']."%");
					}else{
						$select->where->NEST
						              ->like("slider."."name","%".$arrParam['search']['search_value']."%")
									  ->or->equalTo("slider."."id",$arrParam['search']['search_value'])
									  ->UNNEST;
					}	
					
				}
			  // echo $select->getSqlString();exit();
			});
		}

		if($options['task'] == "list-id"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id"));
			  // echo $select->getSqlString();exit();
			});
		}
		return $result;
	}

	public function changeStatus($arrParam = null,$options = null){
		if($options['task'] == "change-status"){
			$data = array(
				"status" => ($arrParam['status'] == 1)? 0 : 1
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
					$avatar     = new Image();
					$avatarName = $this->getItem(array("id"=>$value));	
					$avatar->removeAvatar($avatarName->picture,array("task"=>"slider"));
					$this->_tableGateway->delete(array("id"=>$value));
				}	
				return true;
			}				
		}

		if($options['task'] == "delete-book"){
			if(!empty($arrParam)){
				$items = $this->getItem($arrParam,array("task" => "delete-book"));
				foreach ($items as  $item) {
					$avatar     = new Image();	
					$avatar->removeAvatar($item->picture,array("task"=>"slider"));
					$this->_tableGateway->delete(array("id"=>$item->id));
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
			if(!empty($arrParam['image']['tmp_name'])){
				$avatar = new Image();
				$arrParam['picture'] = $avatar->upload("image","slide_",array("task"=>"slider"));
			}
			
			unset($arrParam["image"]);
			unset($arrParam['book_name']);
			$this->_tableGateway->insert($arrParam);
			return $this->_tableGateway->getLastInsertValue();
		}
		if($options['task'] == "edit-item"){

			$arrParam['status'] = ($arrParam['status'] == "active") ? 1:0;
			$arrParam['modified'] = date("Y-m-d H:i:s");
			echo "<pre>";
			print_r($arrParam);
			echo "</pre>";
			if(!empty($arrParam['image']['tmp_name'])){
				$avatar = new Image();
				//xóa avatar cũ
				$avatar->removeAvatar($arrParam['picture'],array("task"=>"slider"));

				$arrParam['picture'] = $avatar->upload("image","slider_",array("task"=>"slider"));
			}
			unset($arrParam["image"]);
			unset($arrParam["book_name"]);
			$this->_tableGateway->update($arrParam,array("id"=>$arrParam['id'])); 
			return $arrParam['id'];
		}
	}

	public function getItem($arrParam,$options = null){
		if($options == null){
			return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","description","ordering","status","picture","book_id","price"))
					   ->join(array("b"=>"book"),
					   		"b.id = slider.book_id",
					   		array("book_name"=>"name"),
					   		"left"
					   	)
					   ->where(array("slider.id"=>$arrParam["id"]));
			})->current();
		}

		if($options['task'] == "delete-book"){
			return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","picture"))
					   ->where(array("book_id"=>$arrParam));
			});
		}
		
	}


}
?>