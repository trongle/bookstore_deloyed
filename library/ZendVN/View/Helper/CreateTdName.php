<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CreateTdName extends AbstractHelper{
	function __invoke($username,$fullname,$linkEdit,$img=null,$options = null){  
		if(empty($img)){
			$avatar = URL_FILES."users/thumb/no-avatar.jpg";
		}else{
			$avatar = URL_FILES."users/thumb/".$img;
		}
	    return sprintf('<td style="text-align:left">
                          <div class=" user-panel">
                              <div class="image pull-left">
                                 <img src="%s" class="img-circle" alt="User Image">
                              </div>
                              <div class="pull-left info">
                                  <p><a href="%s">%s</a></p>
                                  <span style="color:black">%s</span>
                              </div>
                          </div>
                      </td>',$avatar,$linkEdit,$username,$fullname);
  	}
}
?>