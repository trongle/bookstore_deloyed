<?php 
  $infoObj = new \ZendVN\System\Info();
  $userInfo = $infoObj->getUserInfo();
  $linkLogout = $this->url('shopRoute/default',array('controller'=>'index','action'=>'logout'));
?>
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">   
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="<?php echo URL_PUBLIC.'files/users/'.$userInfo->avatar ?>" class="user-image" alt="User Image">
          <span class="hidden-xs"><?php echo $userInfo->username ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="<?php echo URL_PUBLIC."files/users/".$userInfo->avatar ?>" class="img-circle" alt="User Image">
            <p>
              <?php echo $userInfo->fullname ?> - Web Developer
              <small>Member since <?php echo date('F.Y',strtotime($userInfo->created))?></small>
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="#" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
              <a href="<?php echo $linkLogout ?>" class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
      <li>
        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
      </li>
    </ul>
  </div>
</nav>