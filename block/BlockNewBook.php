<?php

namespace Block;

use Zend\View\Helper\AbstractHelper;

class BlockNewBook extends AbstractHelper{
	protected $_data;
	public function __invoke(){		
		require_once "block_html/new_book.phtml";
  	}

  	public function setData($table){
  		return $this->_data = $table->listItem(null,array("task"=>"book-new"));
  	}
}

?>