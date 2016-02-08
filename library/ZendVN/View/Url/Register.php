<?php
namespace ZendVN\View\Url;

use Zend\View\Helper\AbstractHelper;

class Register extends AbstractHelper{
	function __invoke($options = null){
	   	return $this->view->url("registerShop");
  	}
}
?>