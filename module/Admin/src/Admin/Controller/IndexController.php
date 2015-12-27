<?php 
namespace Admin\Controller;

use ZendVN\Validator\StringLength;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController{
	public function indexAction(){
		echo "<h3 style='color:red;font-weight:bold'>".__METHOD__."</h3>";
	}

	public function infoAction(){
		echo "<h3 style='color:red;font-weight:bold'>".__METHOD__."</h3>";
		$validate = new StringLength(array("min" => "3","max"=> "10"));

		if(!$validate->isValid("as")){
			echo "<pre style='font-weight:bold'>";
			print_r($validate->getMessages());
			echo "</pre>";
			
		}
		return false;
	}
}
?>