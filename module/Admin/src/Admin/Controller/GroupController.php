<?php 
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class GroupController extends AbstractActionController{
	public function indexAction(){
		$GroupTable = $this->getServiceLocator()->get("GroupTable");
		echo "<pre>";
		print_r($GroupTable);
		echo "<pre>";
		return false;
	}

	public function addAction(){
		return false;
	}

	
}
?>