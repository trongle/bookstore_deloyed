<?php 
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ConfigController extends AbstractActionController{

	public function indexAction(){
		return $this->redirect()->toRoute("adminRoute/default",array("controller"=>"config","action"=>"email"));
	}

	public function emailAction(){
		return false;
	}

	public function imageAction(){
		return false;
	}
}
?>