<?php
namespace ZendVN\View\Helper;

use ZendVN\Filter\CreateLinkFriendly;
use Zend\View\Helper\AbstractHelper;

class CreateBreadcrumb extends AbstractHelper{
	function __invoke($listBreadcumb){
		$linkHome = $this->view->url('homeShop');
		$xhtml = '<a href="'.$linkHome.'">Home</a>&nbsp&nbsp&raquo&nbsp&nbsp';
		$total = count($listBreadcumb);
		$i     = 1;
		$filter = new CreateLinkFriendly();
	   	if(!empty($listBreadcumb)){
	   		foreach($listBreadcumb as $breadcrumb){
	   			$linkCategory = $this->view->url("categoryShop",array(
					"name" => $filter->filter($breadcrumb->name),
					"id"   => $breadcrumb->id
	   			));
	   			if( $i == $total ){
	   				$xhtml .= sprintf('<a href="#" class="last">%s</a>',$breadcrumb->name); 
	   			}else{
	   				$xhtml .= sprintf('<a href="%s">%s</a>&nbsp&nbsp&raquo&nbsp&nbsp',$linkCategory,$breadcrumb->name); 
	   			}	
	   			$i++;
	   		}
	   }
	   return $xhtml;
  	}
}
?>