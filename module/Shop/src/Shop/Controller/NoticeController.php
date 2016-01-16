<?php 
namespace Shop\Controller;

use ZendVN\Controller\MyAbstractController;
use Zend\View\Model\ViewModel;

class NoticeController extends MyAbstractController{

	public function init(){
		$this->_options['tableName'] = "Shop\Model\Category";
		$this->_options['formName'] = "";

		//nhân các tham so trả về từ request của các Action
		$this->_mainParam["data"] = array_merge($this->request->getPost()->toArray(),
			 									$this->request->getFiles()->toArray());
	}

	public function noDataAction(){	
	
	}
}
?>