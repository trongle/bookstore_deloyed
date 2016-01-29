<?php 
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CreateTd extends AbstractHelper
{
	public function __invoke($name1,$name2,$icon){
		return sprintf('<td>
                          <p>%s</p>
                          <span><i class="fa %s"></i>%s</span>
                       </td>',$name1,$icon,$name2);	
	}
}
?>