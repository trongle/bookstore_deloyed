<?php

namespace ZendVN\Filter;

use Zend\Filter\FilterInterface;

class AddLink implements FilterInterface
{
	protected $options = array(
		"patern"      => '',
		"replacement" => null
	);
	public function __construct($options = null){
		$this->options['patern']      = $options['patern'];
		$this->options['replacement'] = $options['replacement']; 
	}
	public function filter($value){
		$patern = "#".$this->options['patern']."#imsU";
		$replacement = "<a href='".$this->options['replacement']."'>".$this->options['patern']."</a>";
		return preg_replace($patern,$replacement,$value);
	}
}
?>