<?php
namespace ZendVN\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\Exception;
use Zend\Form\View\Helper\AbstractHelper;

class FormVideo extends AbstractHelper
{
   
    protected $validTagAttributes = array(
        'width'  => 800,
        'height' => 600,
        'src'    => true,
        'type'   => "video/mp4",
    );

    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    public function render(ElementInterface $element)
    {
        $attributes = $element->getAttributes();
       // echo $this->createAttributesString($attributes);
        return sprintf('<video width="%s" height="%s" controls>
          <source src="%s" type="%s">
         </video>',$attributes['width']
                  ,$attributes['height']
                  ,$attributes['src']
                  ,$attributes['type']);
    }
}
