<?php
namespace ZendVN\View\Url;

use Zend\View\Helper\AbstractHelper;

class Logout extends AbstractHelper{
	function __invoke($options = null){
	   	return $this->view->url("logoutShop");
  	}
}
?>