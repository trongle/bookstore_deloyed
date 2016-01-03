<?php 
namespace ZendVN\Form\View\Helper;

use Zend\Form\Element\Text;
use Zend\Form\View\Helper\FormText as ZendFormText;

class FormText extends ZendFormText{
	public function __invoke($name,$value,array $attributes = null){
		$attributes = $this->setDefaultAttributes($attributes);
		
		$element = new Text($name);
		$element->setValue($value)
		        ->setAttributes($attributes);
		return $this->render($element);
	}

	public function setDefaultAttributes($attributes){
		$attributes['class'] =  (isset($attributes['class'])? $attributes['class'] : "col-xs-2");
		return $attributes;
	}
}
?>