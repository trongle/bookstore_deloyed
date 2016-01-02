<?php 
namespace ZendVN\Form\View\Helper;

use Zend\Form\Element\Select;
use Zend\Form\View\Helper\FormSelect;


class FormSelectBox extends FormSelect
{
	function __invoke($name,$emptyOption,$value,$selected,array $options = null){
		$options = $this->setDefaultOptions($options); 
		
	    $elementSelect = new Select($name);
		$elementSelect->setAttributes($options)
		              ->setEmptyOption($emptyOption)
		              ->setValueOptions($value)
		              ->setValue($selected);
		return $this->render($elementSelect);
  	}

  	protected function setDefaultOptions($options){
		$options['size']  = (isset($options['size']))? $options['size']:1;
		$options['class'] = (isset($options['class']))? $options['class']:'input-sm';
		return $options;
  	}
}
?>