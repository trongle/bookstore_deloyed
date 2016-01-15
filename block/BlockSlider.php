<?php

namespace Block;

use Zend\View\Helper\AbstractHelper;

class BlockSlider extends AbstractHelper{
	protected $_data;
	public function __invoke(){		
		require_once "block_html/slider.phtml";
  	}

  	public function setData($table){
  		return $this->_data = $table->listItem(null,array("task"=>"list-item"));
  	}
}

?>