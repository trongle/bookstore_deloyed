<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ChangeStatusLink extends AbstractHelper{
	//<td><a href="#" class="label label-%s"><i class="fa fa-check"></i></a></td>
	function __invoke($id,$status,$options = null){
	    $class = ($status == 1)? "success" : "default";
	    $icon  = ($options == null)? "fa-check":"fa-star";
	    $func  = ($options == null)? "changeStatus":"changeGroupAcp";
	    return sprintf('<td><a href="#" onclick=%s(\'%s\',\'%s\') class="label label-%s">
	    				<i class="fa %s"></i></a></td>',
	    				$func,$id,(int)$status,$class,$icon);
  	}
}
?>