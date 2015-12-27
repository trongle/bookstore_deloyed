<?php 
namespace Admin\Controller;

use ZendVN\Validator\StringLength;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController{
	public function indexAction(){
		echo "<h3 style='color:red;font-weight:bold'>".__METHOD__."</h3>";
		$this->headTitle("Bookonline")->setSeparator(" - ")->append("zf 2");
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

	public function purifierAction(){
		$config =  \HTMLPurifier_Config::createDefault();
		
		// cho phép tất cả các class
		// $config->set("Attr.AllowedClasses",null);
		//  cho phép xài class abc
		$config->set("Attr.AllowedClasses",array("abc"));

		$purifier = new \HTMLPurifier_HTMLPurifier($config);
		$input = "<h3 class='abc content'>Helo</h3>";
		$output = $purifier->purify($input);

		echo "<h3 style='color:red;font-weight:bold'>input : </h3>".$input."<br>";
		echo "<h3 style='color:red;font-weight:bold'>output : </h3>".$output;
		return false;
	}
}
?>