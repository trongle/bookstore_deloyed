<?php 

namespace Admin\Controller;
use ZendVN\Controller\MyAbstractController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class CategoryController extends MyAbstractController{
	protected $_orderList = [
		"order"    => "ASC",
		"order_by" => "left"
	];

	protected $_search = [
		"search_key"   => null,
		"search_value" => null
	];

	protected $_filter_status;
	protected $_filter_level;

	public function init(){
		$ssOrder = new Container(__CLASS__);
		//SET FILTER 
		$this->_orderList['order']     = !empty($ssOrder->order)? $ssOrder->order : $this->_orderList['order'] ;
		$this->_orderList['order_by']  = !empty($ssOrder->order_by)? $ssOrder->order_by : $this->_orderList['order_by'];
		$this->_filter_status          = $ssOrder->filter_status;
		$this->_filter_level           = $ssOrder->filter_level;
		$this->_search['search_key']   = $ssOrder->search_key;
		$this->_search['search_value'] = $ssOrder->search_value;

		//SET PAGINATOR
		$this->_configPaginator['pageRange']   = 3;
		$this->_configPaginator['itemPerPage'] = 20;
		$this->_configPaginator['curentPage']  = $this->params()->fromRoute("page",1);
		//SET OPTIONS 
		$this->_options["tableName"] = "CategoryTable";
		$this->_options["formName"]  = "formAdminCategory";
		$this->_mainParam =array_merge($this->_mainParam,array(
														"paginator"     => $this->_configPaginator,
														"order"         => $this->_orderList,
														"filter_status" => $this->_filter_status,
														"filter_level"  => $this->_filter_level,
														"search"        => $this->_search
													));


		//nhân các tham so trả về từ request của các Action
		$this->_mainParam["data"] = array_merge($this->request->getPost()->toArray(),
			 									$this->request->getFiles()->toArray());
	}

	public function indexAction(){
		$items       = $this->getTable()->listItem($this->_mainParam,array("task"=>"list-item"));
		$totalItem   = $this->getTable()->countItem($this->_mainParam);
		$selectLevel = $this->getTable()->itemInSelectBox();

		return new ViewModel(array(
				"items"        => $items,
				"paginator"    => \ZendVN\Paginator\Paginator::createPagination($totalItem,$this->_configPaginator),
				"paramSetting" => $this->_mainParam, 
				"selectLevel"  => $selectLevel
  		));
	}

	public function filterAction(){
		if($this->request->isPost()){
			$ssOrder      = new Container(__CLASS__);
			//$ssOrder->offsetSet("order",$order); 	default way 
			$ssOrder->order         = $this->_mainParam['data']['order'];	//new Way	 
			$ssOrder->order_by      = $this->_mainParam['data']['order_by'];		
			$ssOrder->filter_status = $this->_mainParam['data']['filter_status'];			
			$ssOrder->search_value  = $this->_mainParam['data']['search_value'];		
			$ssOrder->search_key    = $this->_mainParam['data']['search_key'];	
			$ssOrder->filter_level  = $this->_mainParam['data']['filter_level'];	

			if(isset($this->_mainParam['data']['btn_clear'])){
				$ssOrder->offsetUnset("search_value");
				$ssOrder->offsetUnset("search_key");
			}	
		}
		// return false;
		return $this->toAction();
	}

	public function statusAction(){
		$task = "";
		$message = "Vui lòng chọn phần tử muốn thay đổi trạng thái";
		if($this->request->isPost()){
			if(isset($this->_mainParam["data"]["id"])){
				$id = $this->_mainParam["data"]["id"];
				$task = (is_array($id))? "change-multi-status" : "change-status";
				
				if($this->getTable()->changeStatus($this->_mainParam["data"],array("task"=>$task))){
					$message = "Trạng thái đã được cập nhật";	
				}				
			}
		}
		$this->flashMessenger()->addMessage($message);
		return $this->toAction();
	}

	public function deleteAction(){
		$message = "Vui lòng chọn phần tử muốn xóa";
		if($this->request->isPost()){
			if($this->getTable()->deleteItem($this->_mainParam["data"]["id"],array("task"=>"delete-multi"))){
				$message = "Các phần tử đã được xóa";
			}
		}
		$this->flashMessenger()->addMessage($message);
		return $this->toAction();
	}

	public function orderingAction(){
		$message = "Vui lòng chọn phần tử muốn thay đổi Ordering";
		if($this->request->isPost()){
			if($this->getTable()->ordering($this->_mainParam["data"])){
				$message = "Các phần tử đã được thay đổi trạng thái";
			}
					
		}
		$this->flashMessenger()->addMessage($message);
		return $this->toAction();
	}

	public function saveAction(){
		$form = $this->getForm();
		$this->_mainParam["data"]['id']   = $this->params("id");
		$info = $this->getTable()->getItem(array("id"=>$this->_mainParam["data"]['id']));

		$task    = "add-item";
		$title   = " - User - Add";
		$message = "Một User đã được thêm thành công";
		if(!empty($info)){
			$form->bind($info);
			$form->setInputFilter(new \Admin\Form\FormUserFilter(array("id"=>$this->_mainParam["data"]['id'])));
			$task    = "edit-item";
			$message = "Một User đã được chỉnh sữa thành công";
			$title   = " - User - Edit";
		}
		$this->headTitle($title);
		
		if($this->request->isPost()){
			$form->setData($this->_mainParam["data"]);
			$action = $this->_mainParam["data"]["action"];
			if($form->isValid()){				
				$data = $form->getData(\Zend\Form\FormInterface::VALUES_AS_ARRAY);
				//loại bỏ action do lấy getData bằng hydrating
				unset($data["action"]);
				$id   = $this->getTable()->saveItem($data,array("task"=> $task));
				$this->flashMessenger()->addMessage($message);
				if($action == "save-new") $this->toAction(array("action" => "save"));
				if($action == "save-close") $this->toAction();
				if($action == "save") $this->toAction(array(
															"action" => "save",
															"id"     => $id
														));
			}
		}
		return new ViewModel(array(
			"myForm" => $form
		));
	}



}
?>