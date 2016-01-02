<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ChangeStatusLink extends AbstractHelper{
	//<td><a href="#" class="label label-%s"><i class="fa fa-check"></i></a></td>
	function __invoke($id,$status,$options = null){
	    $class = ($status == 1)? "success" : "default";
	    return sprintf('<td><a href="#" onclick=changeStatus(\'%s\',\'%s\') class="label label-%s">
	    				<i class="fa fa-check"></i></a></td>',
	    				$id,(int)$status,$class);
  	}
}
?>