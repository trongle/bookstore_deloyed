<?php 
namespace Shop\Controller;

use ZendVN\Controller\MyAbstractController;
use Zend\View\Model\ViewModel;

class CategoryController extends MyAbstractController{

	public function init(){
		$this->_options['tableName'] = "Shop\Model\Category";
		$this->_options['formName'] = "";

		//nhân các tham so trả về từ request của các Action
		$this->_mainParam["data"] = array_merge($this->request->getPost()->toArray(),
			 									$this->request->getFiles()->toArray());
	}

	public function indexAction(){	
		$this->_mainParam["data"]["id"] = $this->params("id");
		$categoryItem = $this->getTable()->getItem($this->_mainParam["data"]);
		if(empty($categoryItem)) $this->redirect()->toRoute("shopRoute/default",array("controller" => "notice","action" => "no-data"));
		return new ViewModel(array(
			"categoryItem" => $categoryItem,
		));
	}
}
?>