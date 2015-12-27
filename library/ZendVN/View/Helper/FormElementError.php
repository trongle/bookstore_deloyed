<?php 
namespace ZendVN\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElementErrors;

class FormElementError extends FormElementErrors{
	public function __invoke(ElementInterface $element = null, array $attributes = array())
    {
       if(!empty($element->getMessages())){
       		$messages = $element->getMessages();
       		return sprintf("<p class='show-error'>%s</p>",current($messages));
       }
    }
}
?>