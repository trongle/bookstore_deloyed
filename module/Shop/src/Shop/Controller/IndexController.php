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
		if($this->identity()) $this->redirect()->toRoute('homeShop');
		$errorAuth                  = null;
		$this->_options['formName'] = 'formLoginShop';
		$authenticate               = $this->getServiceLocator()->get('MyAuth');
		$form                       = $this->getForm();
		if($this->request->isPost()){
			$form->setdata($this->_mainParam['data']);
			if($form->isValid()){
				$data  = $form->getData();
				//kiem tra login
				$check = $authenticate->login($data);
				if($check){
					$this->redirect()->toRoute('homeShop');
				}else{
					$errorAuth = $authenticate->getMessages();
				}
			}
		}
		return array(
			'formLogin' => $form,
			'authError' => $errorAuth
		);
	}

	public function registerAction(){
		if($this->identity()) $this->redirect()->toRoute('homeShop');
		$formRegister = $this->getForm();

		if($this->request->isPost()){
			$formRegister->setData($this->_mainParam['data']);
			if($formRegister->isValid()){
				$data = $formRegister->getData(FormInterface::VALUES_AS_ARRAY);
				$id   = $this->getTable()->saveItem($data,array("task" => "add-item"));
				//gui mail kich hoat cho user
				$userInfo   = $this->getTable()->getItem(array("id"=>$id));
				$linkActive = $this->url()->fromRoute("shopRoute/active",array("id"=>$id,"code"=>$userInfo->active_code),array("force_canonical"=>true));
				$mailObj    = new \ZendVN\Mail\Mail();
				$mailObj->sendMail($userInfo->email,$userInfo->fullname,$linkActive);
				
				$this->redirect()->toRoute("shopRoute/default",array("controller"=>"notice","action"=>"register-success"));

			}
		}
		
		return array(
			"formRegister" => $formRegister
		);
	}

	public function logoutAction(){
		$authenticate = $this->getServiceLocator()->get('MyAuth');
		$authenticate->logout();
		$this->redirect()->toRoute('homeShop');
	}
}
?>