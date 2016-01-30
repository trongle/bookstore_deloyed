<?php

namespace Block;

use Zend\View\Helper\AbstractHelper;

class BlockLoginRegistered extends AbstractHelper{
	public function __invoke($formElement,$authError = null){		
		require_once "block_html/loginregistered.phtml";
  	}

}

?>