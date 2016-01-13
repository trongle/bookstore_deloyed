<?php 
namespace Admin\Controller;

use ZendVN\Controller\MyAbstractController;
use ZendVN\Validator\StringLength;

class IndexController extends MyAbstractController{

	public function indexAction(){
		$this->headTitle("Bookonline")->setSeparator(" - ")->append("zf 2");
	}
}
?>