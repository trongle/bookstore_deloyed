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