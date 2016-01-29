<?php 
	$linkHome     = $this->url("shopRoute/default");
	$linkLogin    = $this->url("shopRoute/default",array("controller"=>"index","action"=>"login"));
	$linkRegister = $this->url("shopRoute/default",array("controller"=>"index","action"=>"register"));
	$arrContent = array(
		array("link" => $linkHome,    "name" => "Home" ,    "icon" => "fa-home" ,"action" => "index"),
		array("link" => $linkLogin,   "name" => "Login" ,   "icon" => "fa-lock" ,"action" => "login"),
		array("link" => $linkRegister,"name" => "Register" ,"icon" => "fa-user" ,"action" => "register"),
	);
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