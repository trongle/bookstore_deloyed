<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ChangeMoveNode extends AbstractHelper{
	function __invoke($id,$type = "up",$varChild,$varParent,$options = null){		
		if($options["order"] == "ASC" && $options["order_by"] == "left"){
			$icon = "";
		    if($type == "up"){
		    	$icon = "fa-arrow-up";
		    }else{
		    	$type = "down";
		    	$icon = "fa-arrow-down";
		    }
		    if($varChild == $varParent) return "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
		    return sprintf('<span><a href="#" onclick="moveNode(\'%s\',\'%s\')" class="label label-info"><i class="fa fa-fw %s"></i></a></span>',
		    				$id,$type,$icon);
		}else{
			return null;
		}
	   
  	}
}
?>