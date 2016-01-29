<?php

namespace Block;

use Zend\View\Helper\AbstractHelper;

class BlockCategory extends AbstractHelper{
	protected $_data;
	public function __invoke(){		
		require_once "block_html/category.phtml";
  	}

  	public function setData($table){
  		return $this->_data = $table->listItem(null,array("task"=>"shop-category"));
  	}
}

?>