<?php 
namespace Shop\Controller;

use ZendVN\Controller\MyAbstractController;
use Zend\Form\FormInterface;
use Zend\View\Model\ViewModel;

class UserController extends MyAbstractController{

	public function init(){
		$this->_options['tableName'] = "shopUserTable";
		$this->_options['formName']  = "formRegisterShop";

		//nhân các tham so trả về từ request của các Action
		$this->_mainParam["data"] = array_merge($this->request->getPost()->toArray(),
												$this->params()->fromRoute(),
			                                    $this->request->getFiles()->toArray());
	}

	public function activeAction(){
		//check active_code
		$check = $this->getTable()->getItem($this->_mainParam['data'],array('task' => 'active-code'));
		if($check == 0){
			return $this->redirect()->toRoute('shopRoute/default',array('controller' => 'notice','action' => 'actived'));
		}

		$lastId = $this->getTable()->saveItem($this->_mainParam['data'],array('task' => 'active-user'));
		return $this->redirect()->toRoute('shopRoute/default',array('controller' => 'notice','action' => 'active-success'));
	}

	public function adminAction(){
		return $this->redirect()->toRoute('adminRoute/default');
	}
}
?>