<?php
namespace ZendVN\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CreateTdName extends AbstractHelper{
	function __invoke($username,$fullname,$linkEdit,$img=null,$options = null){   
	    return sprintf('<td style="text-align:left">
                          <div class=" user-panel">
                              <div class="image pull-left">
                                 <img src="/public/template/backend/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                              </div>
                              <div class="pull-left info">
                                  <p><a href="%s">%s</a></p>
                                  <span style="color:black">%s</span>
                              </div>
                          </div>
                      </td>',$linkEdit,$username,$fullname);
  	}
}
?>