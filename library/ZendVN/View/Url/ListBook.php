<?php
namespace ZendVN\View\Url;

use ZendVN\Filter\CreateLinkFriendly;
use Zend\View\Helper\AbstractHelper;

class ListBook extends AbstractHelper{
	function __invoke($name,$id,$options = null){
		$filter = new CreateLinkFriendly();
		$name = $filter->filter($name);
	   	return $this->view->url("categoryShop/filter",array(
			"name"    => $name,
			"id"      => $id,
			'page'    => $options['page'],
			'limit'   => $options['limit'],
			'order'   => $options['order'],
			'dir'     => $options['dir'],
			'display' => $options['display']
	   	));
  	}
}
?>