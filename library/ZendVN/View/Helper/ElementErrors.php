<?php 
namespace ZendVN\View\Helper;

use Zend\Form\View\Helper\FormElementErrors;

class ElementErrors extends FormElementErrors{
	public function __invoke(array $elements = null)
    {
		$xhtml  = "";
		$string = "";
        if(!empty($elements)){ 	
	       	foreach ($elements as $key => $element){
	       		$message = $element->getMessages();
	       		if(empty($message)) continue;
	       		$string .= sprintf("<p><b>%s: </b>%s</p>",ucfirst($key),current($message));
	       	}
	     	if(!empty($string)) $xhtml = sprintf('<div class="alert alert-danger" role="alert">%s</div>',$string);
        }
       return $xhtml ;
    }
}
?>