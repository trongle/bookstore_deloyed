<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CreateBreadcrumb extends AbstractHelper{
	function __invoke($listBreadcumb){
		$linkHome = $this->view->url('homeShop');
		$xhtml = '<a href="'.$linkHome.'">Home</a>&nbsp&nbsp&raquo&nbsp&nbsp';
		$total = count($listBreadcumb);
		$i     = 1;
	   	if(!empty($listBreadcumb)){
	   		foreach($listBreadcumb as $breadcrumb){
	   			$linkCategory = $this->view->url("shopRoute/default",array(
					"controller" => "category",
					"action"     => "index",
					"id"         => $breadcrumb->id)
	   			);
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