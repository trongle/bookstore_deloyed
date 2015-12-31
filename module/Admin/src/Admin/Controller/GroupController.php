<?php 

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GroupController extends AbstractActionController{
	protected $_table ;
	protected $_configPaginator = [
		"pageRange"   => 3,
		"itemPerPage" => 3
	];
	public function getTable(){
		if($this->_table == ""){
			$this->_table = $this->getServiceLocator()->get("GroupTable");
		};
		return $this->_table;		
	}
	public function indexAction(){
		$this->_configPaginator['curentPage'] = $this->params()->fromRoute("page",1);
		$totalItem = $this->getTable()->countItem();
		

		$items = $this->getTable()->listItem($this->_configPaginator,array("task"=>"list-item"));
		return new ViewModel(array(
			"items" => $items,
			"paginator" => \ZendVN\Paginator\Paginator::createPagination($totalItem,$this->_configPaginator)
		));
	}

	public function addAction(){
		return false;
	}

	
}
?>