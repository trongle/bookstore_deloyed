<?php 
namespace Admin\Controller;

use ZendVN\Validator\StringLength;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController{
	public function indexAction(){
		$this->headTitle("Bookonline")->setSeparator(" - ")->append("zf 2");
	}
}
?>