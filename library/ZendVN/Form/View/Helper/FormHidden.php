<?php 
namespace ZendVN\Form\View\Helper;

use Zend\Form\Element\Hidden;
use Zend\Form\View\Helper\FormHidden as ZendFormHidden;


class FormHidden extends ZendFormHidden
{
	public function __invoke($name,$value,$options = null){
		$element = new Hidden($name);
		$element->setValue($value);
		return $this->render($element);
	}
}
?>