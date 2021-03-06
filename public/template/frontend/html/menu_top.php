<?php 
if(!$this->identity()){
	$linkHome     = $this->url("homeShop");
	$arrContent = array(
		array("link" => $linkHome,    "name" => "Home" ,    "icon" => "fa-home" ,"action" => "index"),
		array("link" => $this->linkLogin(),   "name" => "Login" ,   "icon" => "fa-lock" ,"action" => "login"),
		array("link" => $this->linkRegister(),"name" => "Register" ,"icon" => "fa-user" ,"action" => "register"),
	);
}else{

	$linkHome      = $this->url("homeShop");
	$linkMyAccount = $this->url("shopRoute/default",array("controller"=>"user","action"=>"index"));
	$arrContent = array(
		array("link" => $linkHome       ,"name" => "Home"      ,"icon" => "fa-home" ,"action" => "index"),
		array("link" => $linkMyAccount  ,"name" => "MyAccount" ,"icon" => "fa-lock" ,"action" => "login"),
		array("link" => $this->linkHistory()    ,"name" => "MyHistory" ,"icon" => "fa-user" ,"action" => "register"),
	);
	//them shortcut cpanel
	$infoObj   = new \ZendVN\System\Info();
	$group_acp = $infoObj->getGroupInfo('group_acp');
	if($group_acp == 1){
		$linkAdmin    = $this->url("shopRoute/default",array("controller"=>"user","action"=>"admin"));
		$arrContent[] = array("link" => $linkAdmin     ,"name" => "ControlPanel"    ,"icon" => "fa-user" ,"action" => "");
	} 
	$arrContent[] = array("link" => $this->linkLogout()     ,"name" => "Logout"    ,"icon" => "fa-user" ,"action" => "register");
}
	$xhtml = "";
	foreach($arrContent as $content){
		$class = "";
		if($this->params['action'] == $content['action']) $class = "class='active'";
		$xhtml .= sprintf('<li><a %s href="%s"><i class="fa %s"></i>%s</a></li>'
							,$class,$content['link'],$content['icon'],$content['name']
						);
	}
?>
<div class="toprow">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="socials">
					<a href="//www.facebook.com/"><i class="fa fa-facebook"></i></a> 
					<a href="//www.twitter.com/"><i class="fa fa-twitter"></i></a>
				</div>
				<ul class="links">
					<?php echo $xhtml;?>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>