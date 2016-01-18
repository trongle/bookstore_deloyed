<?php 
namespace ZendVN\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElementErrors;

class ElementErrors extends FormElementErrors{
	public function __invoke(ElementInterface $elements = null)
    {
        if(empty($elements)) return "" ;

        $message = $elements->getMessages();
      	return sprintf('<span class="error help-inline">
      						%s
      					</span>',current($message));
    }
}
?>