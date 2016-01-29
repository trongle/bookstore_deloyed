<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ButtonTool extends AbstractHelper{
	function __invoke($name,$icon,$dataType,$dataShow = "yes",$link = "#"){
	   	return sprintf('<a class="btn btn-app" href="%s" data-show="%s" data-type="%s">
	   					 <i class="fa %s"></i>%s</a>',$link,$dataShow,$dataType,$icon,$name);
  	}
}
?>