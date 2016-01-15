<?php

namespace Block;

use Zend\View\Helper\AbstractHelper;

class BlockFacebook extends AbstractHelper{
	protected $_data;
	public function __invoke(){		
		require_once "block_html/facebook.phtml";
  	}

}

?>