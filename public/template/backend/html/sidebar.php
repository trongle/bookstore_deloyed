 <?php 
 //<small class="pull-right  badge bg-red" >3</small>
  $xhtmlSidebar   = "";
  $contentSidebarParent = array(
    array("class" => "index",   "link" => $this->basePath("admin/index/index"),    "icon" => "dashboard","text" => "Control Panel" , "child" => false),
    array("class" => "group",   "link" => $this->basePath("admin/group/index"),    "icon" => "users",    "text" => "Group",          "child" => false ),
    array("class" => "user",    "link" => $this->basePath("admin/user/index"),     "icon" => "user",     "text" => "User" ,          "child" => false),
    array("class" => "category","link" => $this->basePath("admin/category/index"), "icon" => "suitcase", "text" => "Category" ,      "child" => false),
    array("class" => "book",    "link" => $this->basePath("admin/book/index"),     "icon" => "book",     "text" => "Book" ,          "child" => false),
    array("class" => "order",   "link" => $this->basePath("admin/order/index"),    "icon" => "cart-plus","text" => "Order" ,         "child" => false),
    array("class" => "slider",  "link" => $this->basePath("admin/slider/index"),    "icon" => "cart-plus","text" => "Slider" ,         "child" => false),
    array("class" => "config",  "link" => $this->basePath("#"),                    "icon" => "cog",      "text" => "Config" ,        "child" => true),
  );
  $contentSidebarChild = array(
    "config" => array(
      array("class" => "config-email" ,"link" => $this->basePath("admin/config/email"),"icon" => "circle-o","text" => "Email"),
      array("class" => "config-image" ,"link" => $this->basePath("admin/config/image"),"icon" => "circle-o","text" => "Image"),
  ));

  foreach($contentSidebarParent as $content){
      if($content["child"] == true){
        $xhtmlSidebar .= sprintf('<li class="treeview admin-%s">
                                    <a href="%s">
                                     <i class="fa fa-%s"></i>
                                      <span>%s</span>
                                      <i class="fa fa-angle-down pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">',$content['class'],$content['link'],$content['icon'],$content['text']);
        foreach($contentSidebarChild[$content['class']] as $contentChild){
             $xhtmlSidebar .= sprintf('
                                      <li class="%s"><a href="%s"><i class="fa fa-%s"></i>%s</a></li>',
                                      $contentChild['class'],$contentChild['link'],$contentChild['icon'],$contentChild['text']);
        } 
        $xhtmlSidebar .= "</ul></li>";
      }else{
        $xhtmlSidebar .= sprintf('<li class="admin-%s"> 
                                  <a href="%s"><i class="fa fa-%s"></i><span>%s</span></a>
                                </li>',$content['class'],$content['link'],$content['icon'],$content['text']);
      }

  $infoObj = new \ZendVN\System\Info();
  $userInfo = $infoObj->getUserInfo();
  }
 ?>


 <section class="sidebar" style="height: auto;">         
  <div class="user-panel">
    <div class="pull-left image">
      <img src="<?php echo URL_PUBLIC.'files/users/'.$userInfo->avatar ?>" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p><?php echo $userInfo->fullname ?></p>
      <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
    </div>
  </div>
  <ul class="sidebar-menu">
   <?php 
      echo $xhtmlSidebar ;
   ?>
  </ul>
</section>
<script type="text/javascript">
  $(document).ready(function(){
      var classParent = "<?php echo $this->params['module'].'-'.$this->params['controller'] ?>";
      $("ul.sidebar-menu > li."+classParent).addClass("active");

      if($("ul.sidebar-menu > li."+classParent).children("ul")){
        var classChild = "<?php echo $this->params['controller'].'-'.$this->params['action'] ?>"
        $("ul.treeview-menu > li."+classChild).addClass("active");
      }
  })

</script>