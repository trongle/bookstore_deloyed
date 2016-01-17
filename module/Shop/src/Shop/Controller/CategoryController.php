<?php 
namespace Shop\Controller;

use ZendVN\Controller\MyAbstractController;
use Zend\View\Model\ViewModel;

class CategoryController extends MyAbstractController{

	public function init(){
		$this->_options['tableName'] = "Shop\Model\Category";
		$this->_options['formName']  = "";

		//SET PAGINATOR
		$this->_configPaginator['pageRange']   = 3;
		$this->_configPaginator['itemPerPage'] = $this->params()->fromRoute("limit",3);
		$this->_configPaginator['curentPage']  = $this->params()->fromRoute("page",1);
		$this->_mainParam['filter']['order']   = $this->params()->fromRoute("order","id");
		$this->_mainParam['filter']['dir']     = $this->params()->fromRoute("dir","desc");

		//nhân các tham so trả về từ request của các Action
		$this->_mainParam["pagination"] = $this->_configPaginator; 
		$this->_mainParam["data"]       = array_merge($this->request->getPost()->toArray(),
													  $this->request->getFiles()->toArray());
	}

	public function indexAction(){	
		$this->_mainParam["data"]["id"] = $this->params("id");
		$display                        = $this->params("display","list");
		$viewModel =  new ViewModel(); //view chính
		$bookView  =  new ViewModel(); //view -hiện danh sách book
		$bookView->setTemplate('shop/category/'.$display);
		//CATEGORY INFO
		$categoryItem  = $this->getTable()->getItem($this->_mainParam["data"]);
		if(empty($categoryItem)) $this->redirect()->toRoute("shopRoute/default",array("controller" => "notice","action" => "no-data"));
		
		//BREADCRUMB
		$listBreadcumb = $this->getTable()->listItem($categoryItem,array("task" => "list-breadcrumb"));

		//LISTBOOK BY CATEGORY
		$catIDs                     = $this->getTable()->listItem($categoryItem,array("task" => "list-id-category"));
		$this->_mainParam["catIDs"] = $catIDs; 
		$bookTable = $this->getServiceLocator()->get("shopBookTable");
		$listBook  = $bookTable->listItem($this->_mainParam,array("task" => "list-book-by-category"));
		$totalItem = $bookTable->countItem($catIDs,array("task"=>"count-book"));

		$viewModel->addChild($bookView,"list_book_category");
		$bookView->setVariables(array(
			"listBook"		=> $listBook
		));
		$viewModel->setVariables(array(
			"categoryItem"  => $categoryItem,
			"listBreadcumb" => $listBreadcumb,	
			"paginator"     => \ZendVN\Paginator\Paginator::createPagination($totalItem,$this->_configPaginator),
			"displayType"   => $display, 
			"paramSetting"  => $this->_mainParam
 		));
		return $viewModel;
	}
}
?>