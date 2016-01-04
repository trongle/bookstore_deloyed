<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class LinkToGo extends AbstractHelper{
	function __invoke($nameRoute,$options = null){
		$url = $this->getView()->plugin("url");//cal  helper default
		$options["controller"] = (isset($options["controller"]))? $options["controller"] : "index";
		$options["action"]     = (isset($options["action"]))? $options["action"] : "index";
		$options["id"]         = (isset($options["id"]))? $options["id"] : "";
	    return  $url($nameRoute,$options);
  	}
}
?>