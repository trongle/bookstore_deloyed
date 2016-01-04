<?php 

namespace Admin\Controller;
use ZendVN\Controller\MyAbstractController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class GroupController extends MyAbstractController{
	protected $_configPaginator = [
		"pageRange"   => 3,
		"itemPerPage" => 5
	];
	protected $_orderList = [
		"order"    => "DESC",
		"order_by" => "id"
	];
	protected $_options = [
		"tableName" => "GroupTable",
		"formName"  => "formAdminGroup"
	];

	protected $_search = [
		"search_key"   => null,
		"search_value" => null
	];

	protected $_filter_status;

	public function init(){
		$ssOrder = new Container(__NAMESPACE__);
		//SET FILTER 
		$this->_orderList['order']     = !empty($ssOrder->order)? $ssOrder->order : $this->_orderList['order'] ;
		$this->_orderList['order_by']  = !empty($ssOrder->order_by)? $ssOrder->order_by : $this->_orderList['order_by'];
		$this->_filter_status          = $ssOrder->filter_status;
		$this->_search['search_key']   = $ssOrder->search_key;
		$this->_search['search_value'] = $ssOrder->search_value;

		//SET PAGINATOR
		$this->_configPaginator['curentPage'] = $this->params()->fromRoute("page",1);
		$this->_mainParam =array_merge($this->_mainParam,array(
														"paginator"     => $this->_configPaginator,
														"order"         => $this->_orderList,
														"filter_status" => $this->_filter_status,
														"search"        => $this->_search
													));
	}

	public function indexAction(){
		$items = $this->getTable()->listItem($this->_mainParam,array("task"=>"list-item"));
		$totalItem = $this->getTable()->countItem($this->_mainParam);
		return new ViewModel(array(
				"items"     => $items,
				"paginator" => \ZendVN\Paginator\Paginator::createPagination($totalItem,$this->_configPaginator),
				"paramSetting" => $this->_mainParam
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
		$form = $this->getForm();
		if($this->request->isPost()){
			$data = $this->request->getPost();
			$form->setData($data);
			if($form->isValid()){
				$this->getTable()->saveItem($form->getData(),array("task"=>"add-item"));
				$this->flashMessenger()->addMessage("Một Group đã được thêm thành công");
				return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"group","action"=>"index"));
			}
		}
		return new ViewModel(array(
			"myForm" => $form
		));
	}

	public function editAction(){
		$form = $this->getForm();
		$id   = $this->params("id");
		$info = $this->getTable()->getItem(array("id"=>$id));
		$form->bind($info);
		if($this->request->isPost()){
			$form->setData($this->request->getPost());
			if($form->isValid()){				
				$data = $form->getData(\Zend\Form\FormInterface::VALUES_AS_ARRAY);
				$this->getTable()->saveItem($data,array("task"=>"edit-item"));
				$this->flashMessenger()->addMessage("Một Group đã được chỉnh sữa thành công");
				return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"group","action"=>"index"));
			}
		}
		return new ViewModel(array(
			"myForm" => $form
		));
	}

	
}
?>