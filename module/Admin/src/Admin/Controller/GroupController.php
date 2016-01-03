<?php 

namespace Admin\Controller;
session_start();
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class GroupController extends AbstractActionController{
	protected $_table ;
	protected $_configPaginator = [
		"pageRange"   => 3,
		"itemPerPage" => 5
	];
	protected $_orderList = [
		"order"    => "ASC",
		"order_by" => "id"
	];

	protected $_search = [
		"search_key"   => null,
		"search_value" => null
	];

	public function getTable(){
		if($this->_table == ""){
			$this->_table = $this->getServiceLocator()->get("GroupTable");
		};
		return $this->_table;		
	}
	public function indexAction(){
		
		$this->_configPaginator['curentPage'] = $this->params()->fromRoute("page",1);

		$ssOrder = new Container(__NAMESPACE__);
		if($ssOrder->offsetExists('order') && $ssOrder->offsetExists('order_by') ){
			$this->_orderList['order']    = $ssOrder->offsetGet("order");
			$this->_orderList['order_by'] = $ssOrder->offsetGet("order_by");
		}

		$filter_status = "";
		if($ssOrder->offsetExists('filter_status')){
			$filter_status = $ssOrder->offsetGet("filter_status");
		}

		if($ssOrder->offsetExists('search_key') && $ssOrder->offsetExists('search_value') ){
			$this->_search['search_key']   = $ssOrder->offsetGet("search_key");
			$this->_search['search_value'] = $ssOrder->offsetGet("search_value");
		}

		$paramSetting = [
			"paginator"     => $this->_configPaginator,
			"order"         => $this->_orderList,
			"filter_status" => $filter_status,
			"search"        => $this->_search
		];

		$items = $this->getTable()->listItem($paramSetting,array("task"=>"list-item"));
		$totalItem = $this->getTable()->countItem($paramSetting);
		return new ViewModel(array(
				"items"     => $items,
				"paginator" => \ZendVN\Paginator\Paginator::createPagination($totalItem,$this->_configPaginator),
				"paramSetting" => $paramSetting
		));
	}

	public function filterAction(){
		if($this->request->isPost()){
			$ssOrder      = new Container(__NAMESPACE__);
			$order        = $this->params()->fromPost("order");
			$order_by     = $this->params()->fromPost("order_by");
			$filter       = $this->params()->fromPost("filter_status");
			$search_key   = $this->params()->fromPost("search_key");
			$search_value = $this->params()->fromPost("search_value");
			$ssOrder->offsetSet("order",$order); 		 
			$ssOrder->offsetSet("order_by",$order_by);		
			$ssOrder->offsetSet("filter_status",$filter);		
			$ssOrder->offsetSet("search_value",$search_value);		
			$ssOrder->offsetSet("search_key",$search_key);	

			$btnClear = $this->params()->fromPost("btn_clear");
			if($btnClear == "clear"){
				$ssOrder->offsetUnset("search_value");
				$ssOrder->offsetUnset("search_key");
			}	
		}
		// return false;
		return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"group","action"=>"index"));
	}

	public function statusAction(){
		$task = "";
		$message = "Vui lòng chọn phần tử muốn thay đổi trạng thái";
		if($this->request->isPost()){
			if(!empty($this->params()->fromPost("id"))){
				if(is_array($this->params()->fromPost("id"))){
					$task = "change-multi-status";
				}else{
					$task = "change-status";
				}
			
				$status = array(
					"status" => $this->params()->fromPost("status"),
					"id"    =>  $this->params()->fromPost("id")
				);
				
				$this->getTable()->changeStatus($status,array("task"=>$task));
				$message = "Trạng thái đã được cập nhật";			
			}
		}
		$this->flashMessenger()->addMessage($message);
		return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"group","action"=>"index"));
	}

	public function deleteAction(){
		$message = "Vui lòng chọn phần tử muốn xóa";
		if($this->request->isPost()){
			if(!empty($this->request->getPost("id"))){
				$this->getTable()->deleteItem($this->request->getPost("id"),array("task"=>"delete-multi"));
				$message = "Các phần tử đã được xóa";
			}
		}
		$this->flashMessenger()->addMessage($message);
		return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"group","action"=>"index"));
	}

	public function orderingAction(){
		$message = "Vui lòng chọn phần tử muốn thay đổi Ordering";
		if($this->request->isPost()){
			if(!empty($this->request->getPost("id"))){
				$this->getTable()->ordering(array(
					"id"       => $this->request->getPost("id"),
					"ordering" => $this->request->getPost("ordering")
				));
				$message = "Các phần tử đã được thay đổi trạng thái";
			}		
		}
		$this->flashMessenger()->addMessage($message);
		return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"group","action"=>"index"));
	}

	public function addAction(){
		$form = $this->getServiceLocator()->get("FormElementManager")->get("formAdminGroup");
		if($this->)
		return new ViewModel(array(
			"form"=>$form
		));
	}

	
}
?>