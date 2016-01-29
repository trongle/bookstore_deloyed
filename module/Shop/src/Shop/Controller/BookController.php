<?php 
namespace Shop\Controller;

use ZendVN\Controller\MyAbstractController;
use Zend\View\Model\ViewModel;

class BookController extends MyAbstractController{

	public function init(){
		$this->_options['tableName'] = "shopBookTable";
		$this->_options['formName']  = "";

		//nhân các tham so trả về từ request của các Action
		
		$this->_mainParam["data"]       = array_merge(
			$this->request->getPost()->toArray(),
			$this->request->getFiles()->toArray()
		);
		$this->_mainParam["data"]['id'] = $this->params("id","");
	}

	public function indexAction(){	
		if(empty($this->_mainParam['data']['id'])){
			$this->redirect()->toRoute("shopRoute/default",array("controller"=>"notice","action"=>"no-data"));
		}else{
			$bookInfo = $this->getTable()->getItem($this->_mainParam['data'],array("task"=>"book-info"));
		}

		return new ViewModel(array(
			"bookInfo" => $bookInfo
		));
	}

	public function relatedAction(){	
		$data = null;
		$isXmlHttpRequest = false;
		if($this->request->isXmlHttpRequest()){	 
			$categoryTable = $this->getServiceLocator()->get("Shop\Model\Category");
			$categoryInfo  = $categoryTable->getItem($this->_mainParam['data']);
			$catIDs        = $categoryTable->listItem($categoryInfo,array("task" => "list-id-category"));
			$this->_mainParam['data']['catIDs'] = $catIDs;
			$bookRelated      = $this->getTable()->getItem($this->_mainParam['data'],array("task" => "book-related"));
			$isXmlHttpRequest = true;
		}

		$viewModel = new ViewModel(array(
			"bookRelated"      => $bookRelated,
			"isXmlHttpRequest" => $isXmlHttpRequest
		));
		$viewModel->setTerminal(true);
		return $viewModel;
	}

	public function popupAction(){
		$data = null;
		$isXmlHttpRequest = false;
		if($this->request->isXmlHttpRequest()){
		
			$data = $this->getTable()->getItem($this->_mainParam['data'],array("task" => "book-popup"));
			$isXmlHttpRequest = true;
		}
		
		$viewModel = new ViewModel(array(
			"data"             => $data,
			"isXmlHttpRequest" => $isXmlHttpRequest
		));
		$viewModel->setTerminal(true);
		return $viewModel;
	}
}
?>