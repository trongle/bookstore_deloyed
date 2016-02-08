<?php
namespace ZendVN\View\Url;

use ZendVN\Filter\CreateLinkFriendly;
use Zend\View\Helper\AbstractHelper;

class Book extends AbstractHelper{
	function __invoke($categoryName,$bookName,$bookId,$options = null){
		$filter = new CreateLinkFriendly();
		$categoryName = $filter->filter($categoryName);
		$bookName = $filter->filter($bookName);
	   	return $this->view->url("bookShop",array(
				"category" => $categoryName,
				"name"     => $bookName,
				"id"       => $bookId
	   	));
  	}
}
?>