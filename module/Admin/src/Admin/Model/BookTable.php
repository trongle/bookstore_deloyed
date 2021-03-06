<?php 
namespace Admin\Model;

use Admin\Model\SliderTable;
use PHPImageWorkshop\ImageWorkshop;
use ZendVN\File\Image;
use ZendVN\File\Upload;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Json\Json;

class BookTable extends AbstractTableGateway{
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


			if(!empty($arrParam['filter_category'])){
				$select->where->equalTo("book.category_id",$arrParam['filter_category']);
			}

			if(!empty($arrParam['filter_special'])){
				$special = ($arrParam['filter_special']=="special")? 1:0;
				$select->where->equalTo("book.special",$special);
			}

			if(!empty($arrParam['search']['search_value']) && !empty($arrParam['search']['search_key'])){
				if($arrParam['search']['search_key'] != "all"){
					$select->where->like("book.".$arrParam['search']['search_key'],
										 "%".$arrParam['search']['search_value']."%");
				}else{
					$select->where->NEST
					              ->like("book."."name","%".$arrParam['search']['search_value']."%")
								  ->or->equalTo("book."."id",$arrParam['search']['search_value'])
								  ->UNNEST;
				}			
			}
		});
		return $result->count();
	}

	public function listItem($arrParam = null,$options = null){
		if($options['task'] == "list-item"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id","name","picture","ordering","modified","modified_by","created","created_by","status","special","price","sale_off"))
				       ->join(array("c"=>"category"),
				       		  "c.id = book.category_id",
				       		  array("ca_name"=>"name"),
				       		  $select::JOIN_LEFT
				       	)
				       ->order(array(sprintf("%s %s",$arrParam['order']['order_by'] , $arrParam['order']['order'])))
				       ->offset(($arrParam['paginator']['curentPage']-1) * $arrParam['paginator']['itemPerPage'])
				       ->limit($arrParam['paginator']['itemPerPage']);

				if(!empty($arrParam['filter_status'])){
					$status = ($arrParam['filter_status']=="active")? 1:0;
					$select->where->equalTo("book.status",$status);
				}

				if(!empty($arrParam['filter_special'])){
					$special = ($arrParam['filter_special']=="special")? 1:0;
					$select->where->equalTo("book.special",$special);
				}


				if(!empty($arrParam['filter_category'])){
					$select->where->equalTo("book.category_id",$arrParam['filter_category']);
				}

		

				if(!empty($arrParam['search']['search_value']) && !empty($arrParam['search']['search_key'])){
					if($arrParam['search']['search_key'] != "all"){
						$select->where->like("book.".$arrParam['search']['search_key'],
											 "%".$arrParam['search']['search_value']."%");
					}else{
						$select->where->NEST
						              ->like("book."."name","%".$arrParam['search']['search_value']."%")
									  ->or->equalTo("book."."id",$arrParam['search']['search_value'])
									  ->UNNEST;
					}	
					
				}
			  // echo $select->getSqlString();exit();
			});
		}
		return $result;
	}

	public function changeStatus($arrParam = null,SliderTable $sliderTable,$options = null){
		if($options['task'] == "change-status"){
			$data = array(
				"status" => ($arrParam['status'] == 1)? 0 : 1
			);
			if($data['status'] == 0){
				$sliderTable->deleteItem($arrParam['id'],array("task" => "delete-book"));

			}
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

	public function changeSpecial($arrParam = null,$options = null){
		if($options == null){
			$data = array(
				"special" => ($arrParam['status'] == 1)? 0 : 1
			);
			$where = array("id" => $arrParam['id']);
			$this->_tableGateway->update($data,$where);
			return true;
		}
	}

	public function deleteItem($arrParam,$options = null){
		if($options['task'] == "delete-multi"){
			if(!empty($arrParam)){
				foreach ($arrParam as  $value) {
					$avatar = new Image();
					$avatarName = $this->getItem(array("id"=>$value));
					$avatar->removeAvatar($avatarName->picture,array("task"=>"book"));
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
				$arrParam['picture'] = $avatar->upload("image","book_",array("task"=>"book"));
			}
			
			unset($arrParam["image"]);
			//edit sale-off
			if(!empty($arrParam["sale_off_type"]) && !empty($arrParam["sale_off_value"]) ){
				$arrParam["sale_off"] = Json::encode(array("type"=>$arrParam["sale_off_type"],"value"=>$arrParam["sale_off_value"]));
				
			}
			unset($arrParam["sale_off_value"]);
			unset($arrParam["sale_off_type"]);
			$this->_tableGateway->insert($arrParam);
			return $this->_tableGateway->getLastInsertValue();
		}
		if($options['task'] == "edit-item"){

			$arrParam['status'] = ($arrParam['status'] == "active") ? 1:0;
			$arrParam['modified'] = date("Y-m-d H:i:s");
			if(!empty($arrParam['image']['tmp_name'])){
				$avatar = new Image();
				//xóa avatar cũ
				$avatar->removeAvatar($arrParam['picture'],array("task"=>"book"));

				$arrParam['picture'] = $avatar->upload("image","book_",array("task"=>"book"));
			}
			unset($arrParam["image"]);
			//edit sale-off
			if(!empty($arrParam["sale_off_type"]) && !empty($arrParam["sale_off_value"]) ){
				$arrParam["sale_off"] = Json::encode(array("type"=>$arrParam["sale_off_type"],"value"=>$arrParam["sale_off_value"]));
				
			}else{
				$arrParam["sale_off"] = null;
			}
			unset($arrParam["sale_off_value"]);
			unset($arrParam["sale_off_type"]);
	
			$this->_tableGateway->update($arrParam,array("id"=>$arrParam['id'])); 
			return $arrParam['id'];
		}
	}

	public function getItem($arrParam,$options = null){
		if($options == null){
			return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","description","ordering","status","picture","category_id","price","sale_off"))
					   ->where(array("id"=>$arrParam["id"]));
			})->current();
		}
	}

	public function itemInSelectBox($arrParam = null,$ids_slider,$options = null){
		if($options['task'] == "list-slider"){
			//lấy các id của  slider
			$arr_ids = array();
			foreach ($ids_slider as $ids) {
				$arr_ids[] = $ids->id;
			}

			$result = $this->_tableGateway->select(function(select $select) use($arr_ids){
					$select->columns(array("id","name"))
					       ->order(array("name ASC"))
					       ->where->equalTo("status",1)
					              ->notIn("id",$arr_ids);
			});
			$item = array();
			if(!empty($result)){
				foreach($result as $row){
					$item[$row->id] = $row->name;
				}
			}
		}
		return $item;
	}


}
?>