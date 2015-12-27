<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class JoinKeyValue extends AbstractHelper{
	public function __invoke(array $inputArr){
		$arr = array_map(function($val1,$val2){
					return sprintf("%s='%s' ",$val1,$val2);
				},array_keys($inputArr),$inputArr);
		return implode(" ",$arr);
	}
}
?>