<?php

namespace Block;

use Zend\View\Helper\AbstractHelper;

class BlockLoginNotRegister extends AbstractHelper{
	public function __invoke(){		
		require_once "block_html/loginnotregister.phtml";
  	}
}

?>