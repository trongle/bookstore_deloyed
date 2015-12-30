<?php 
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GroupController extends AbstractActionController{
	protected $_table ;
	public function getTable(){
		if($this->_table == ""){
			$this->_table = $this->getServiceLocator()->get("GroupTable");
		};
		return $this->_table;		
	}
	public function indexAction(){
		$groupTable = $this->getTable();
		$items = $groupTable->listItem(null,array("task"=>"list-item"));
		return new ViewModel(array(
			"items" => $items
		));
	}

	public function addAction(){
		return false;
	}

	
}
?>