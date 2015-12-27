<?php

namespace ZendVN\Filter;

use Zend\Filter\FilterInterface;

class Purifier implements FilterInterface
{
	protected $instance;
	public function __construct(array $options){
		$config =  \HTMLPurifier_Config::createDefault();
		if(!empty($options)){
			foreach($options as $key => $value){
				$config->set($key,$value);
			}
			// echo "<pre style='font-weight:bold'>";
			// print_r($options);
			// echo "</pre>";
		}
		$this->instance = new \HTMLPurifier_HTMLPurifier($config);
	}

	public function filter($value){	
		return $this->instance->purify($value);
	}
	
}
?>