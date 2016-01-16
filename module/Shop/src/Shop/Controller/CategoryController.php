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
		$this->_mainParam["data"]["id"]      = $this->params("id");
		$this->_mainParam["data"]["display"] = $this->params("display","grid");
		$viewModel =  new ViewModel(); //view chính
		$bookView  =  new ViewModel(); //view -hiện danh sách book
		$bookView->setTemplate('shop/category/child_list_book');
		//CATEGORY INFO
		$categoryItem  = $this->getTable()->getItem($this->_mainParam["data"]);
		if(empty($categoryItem)) $this->redirect()->toRoute("shopRoute/default",array("controller" => "notice","action" => "no-data"));
		
		//BREADCRUMB
		$listBreadcumb = $this->getTable()->listItem($categoryItem,array("task" => "list-breadcrumb"));

		//LISTBOOK BY CATEGORY
		$catIDs    = $this->getTable()->listItem($categoryItem,array("task" => "list-id-category"));
		$bookTable = $this->getServiceLocator()->get("shopBookTable");
		$listBook  = $bookTable->listItem($catIDs,array("task" => "list-book-by-category"));
		

		$viewModel->addChild($bookView,"list_book_category");
		$bookView->setVariables(array(
			"listBook"		=> $listBook
		));
		$viewModel->setVariables(array(
			"categoryItem"  => $categoryItem,
			"listBreadcumb" => $listBreadcumb,	
		));
		return $viewModel;
	}
}
?>