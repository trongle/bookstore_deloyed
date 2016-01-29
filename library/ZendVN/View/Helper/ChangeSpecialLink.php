<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ChangeSpecialLink extends AbstractHelper{
	//<td><a href="#" class="label label-%s"><i class="fa fa-check"></i></a></td>
	function __invoke($id,$special,$options = null){
	    $class = ($special == 1)? "primary" : "default";
	    return sprintf('<td><a href="#" onclick=changeSpecial(\'%s\',\'%s\') class="label label-%s">
	    				<i class="fa fa-star"></i></a></td>',
	    				$id,(int)$special,$class);
  	}
}
?>