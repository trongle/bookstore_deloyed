<?php

namespace Block;

use Zend\View\Helper\AbstractHelper;

class BlockSpecial extends AbstractHelper{
	protected $_data;
	public function __invoke(){		
		require_once "block_html/special.phtml";
  	}

  	public function setData($table){
  		return $this->_data = $table->getItem(null,array("task"=>"book-special"));
  	}
}

?>