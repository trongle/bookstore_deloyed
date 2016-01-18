<?php 
namespace Shop\Controller;

use ZendVN\Controller\MyAbstractController;
use Zend\Form\FormInterface;
use Zend\View\Model\ViewModel;

class IndexController extends MyAbstractController{

	public function init(){
		$this->_options['tableName'] = "shopUserTable";
		$this->_options['formName']  = "formRegisterShop";

		//nhân các tham so trả về từ request của các Action
		$this->_mainParam["data"] = array_merge($this->request->getPost()->toArray(),
			 									$this->request->getFiles()->toArray());
	}

	public function indexAction(){

	}

	public function loginAction(){
		
	}

	public function registerAction(){
		$formRegister = $this->getForm();

		if($this->request->isPost()){
			$formRegister->setData($this->_mainParam['data']);
			if($formRegister->isValid()){
				$data = $formRegister->getData(FormInterface::VALUES_AS_ARRAY);
				$id = $this->getTable()->saveItem($data,array("task" => "add-item"));

				$this->redirect()->toRoute("shopRoute/default",array("controller"=>"notice","action"=>"register-success"));

			}
		}
		
		return new ViewModel(array(
			"formRegister" => $formRegister
		));
	}
}
?>