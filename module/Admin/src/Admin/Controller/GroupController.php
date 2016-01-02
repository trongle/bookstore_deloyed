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
		"itemPerPage" => 3
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

		return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"group","action"=>"index"));
	}

	public function statusAction(){
		if($this->request->isPost()){
			if($this->params()->fromPost("id")){
				$status = array(
					"status" => $this->params()->fromPost("status"),
					"id"     => $this->params()->fromPost("id")
				);
				$this->getTable()->changeStatus($status,array("task"=>"change-status"));
				$this->flashMessenger()->addMessage("Trạng thái đã được cập nhật");
			}
		}

		return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"group","action"=>"index"));
	}

	
}
?>