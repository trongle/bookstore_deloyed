<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CreateLinkDetail extends AbstractHelper{
	function __invoke($bookId,$options = null){
	   	return $this->view->url("shopRoute/default",array(
			"controller" =>"book",
			"action"     =>"index",
			"id"         =>$bookId)
	   	);
  	}
}
?>