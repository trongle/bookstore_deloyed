<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ChangeSortLink extends AbstractHelper{
	function __invoke(array $order,$column,$name,$otherClass = null,$size = null){
	    $ordering = ($order['order'] =="ASC")? "DESC":"ASC";
	    if($order['order_by'] != $column){
	    	$class = $otherClass." sorting";
	    }else{
	    	$class = $otherClass." sorting_".strtolower($order['order']);
	    } 
	    return sprintf('<th class="%s" size = "%s">
	    					<a href="#" onclick="sortList(\'%s\',\'%s\')">%s</a>
	    				</th>',$class,$size,$column,$ordering,$name);
  	}
}
?>