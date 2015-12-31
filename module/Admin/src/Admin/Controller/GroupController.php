<?php 

namespace Admin\Controller;

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

		$paramSetting = [
			"paginator" => $this->_configPaginator,
			"order"     => $this->_orderList,
		];

		$items = $this->getTable()->listItem($paramSetting,array("task"=>"list-item"));
		$totalItem = $this->getTable()->countItem();
		return new ViewModel(array(
				"items"     => $items,
				"paginator" => \ZendVN\Paginator\Paginator::createPagination($totalItem,$this->_configPaginator),
				"ssOrder"   => $this->_orderList
			
		));
	}

	public function filterAction(){
		if($this->request->isPost()){
			$ssOrder  = new Container(__NAMESPACE__);
			$order    = $this->params()->fromPost("order");
			$order_by = $this->params()->fromPost("order_by");
			$ssOrder->offsetSet("order",$order); 		 
			$ssOrder->offsetSet("order_by",$order_by);		
		}
		return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"group","action"=>"index"));
	}

	public function addAction(){
		return false;
	}

	
}
?>