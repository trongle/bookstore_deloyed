<?php

namespace ZendVN\Filter;
use Zend\Filter as ZFilter;
use Zend\Filter\FilterInterface;

class CreateLinkFriendly implements FilterInterface{
	public function filter($value){
		$filterChain = new ZFilter\FilterChain();
		$filterChain->attach(new \Zend\I18n\Filter\Alnum(true))
					->attach(new ZFilter\StringTrim())
					->attach(new ZFilter\PregReplace(array("pattern"=>"#\s+#","replacement"=>" ")) )
					->attach(new ZFilter\StringToLower("UTF-8"))
					->attach(new ZFilter\Word\SeparatorToDash())
					->attach(new \ZendVN\Filter\RemoveCircumPlex());
		return $output =$filterChain->filter($value);
	}
}