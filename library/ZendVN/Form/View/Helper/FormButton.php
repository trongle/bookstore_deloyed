<?php 
namespace ZendVN\Form\View\Helper;

use Zend\Form\Element\Button;
use Zend\Form\View\Helper\FormButton as ZendFormButton;


class FormButton extends ZendFormButton
{
	function __invoke($name,$value,$label,array $attributes = null){
		$attributes = $this->setDefaultAttributes($attributes); 
		
	    $element = new Button($name);
	    $element->setValue($value)
	            ->setAttributes($attributes)
	            ->setLabel($label);
		return $this->render($element);
  	}

  	protected function setDefaultAttributes($attributes){
		$attributes['type']  = (isset($attributes['type']))? $attributes['type']: "button";
		$attributes['class'] = "btn btn-flat " . (isset($attributes['class'])? $attributes['class']:'btn-default');
		return $attributes;
  	}
}
?>