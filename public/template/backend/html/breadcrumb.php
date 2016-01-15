<?php 
	// admin/index/index  =>   <h1>Dashboard<small>Control panel</small></h1>
	// admin/group/index  =>   <h1>Group<small>list</small></h1>
	// admin/group/add    =>   <h1>Group<small>add</small></h1>
	$listControllerTitle = [
		"index"    => "Dashboard",
		"group"    => "Manage Group",
		"user"     => "Manage User",
		"book"     => "Manage Book",
		"category" => "Manage Category",
		"cart"     => "Manage Cart",
		"config"   => "Config",
		"order"    => "Order",
		"slider"   => "Slider",
	];
	$prettyNameParent = $listControllerTitle[$this->params["controller"]];
	$prettyNameChild  = ($this->params["action"]=="index")? "List" : ucfirst($this->params['action']);

	$xhtmlHeader = sprintf("<h1>%s<small>%s</small></h1>",$prettyNameParent,$prettyNameChild);

	//breadcrumd
	//admin/index/index home
	//admin/group/index home > group > list
	//admin/group/add   home > group > add
	$xhtmlBreadcrumb = "";
	if($this->params["controller"] != "index"){
		if($this->params['action']  == "index"){
		$xhtmlBreadcrumb = sprintf('<li class="active">%s</li>
			    					<li class="active">%s</li>',$prettyNameParent,$prettyNameChild);
		}else{
		$xhtmlBreadcrumb = sprintf('<li class="active"><a href="%s">%s</a></li>
			    					<li class="active">%s</li>',
			    					$this->url("adminRoute/default",array("controller"=>$this->params['controller'],"action"=>"index")),
			    					$prettyNameParent,
			    					$prettyNameChild
			    					);
	}
	}
	
?>
<!-- HEADER -->
<section class="content-header">

     <?php echo $xhtmlHeader ?>

<!-- BREADCRUM -->
	  <ol class="breadcrumb">
	  	<li><a href="<?php echo $this->url('adminRoute') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
	    <?php echo $xhtmlBreadcrumb ?>
	  </ol>
</section>