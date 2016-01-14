<?php 
namespace Shop\Controller;

use ZendVN\Controller\MyAbstractController;
use Zend\View\Model\ViewModel;

class BookController extends MyAbstractController{

	public function init(){
		$this->_options['tableName'] = "shopBookTable";
		$this->_options['formName'] = "";

		//nhân các tham so trả về từ request của các Action
		$this->_mainParam["data"] = array_merge($this->request->getPost()->toArray(),
			 									$this->request->getFiles()->toArray());
	}

	public function indexAction(){	
		return false;
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