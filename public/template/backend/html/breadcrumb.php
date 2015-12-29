<?php 
	// admin/index/index  =>   <h1>Dashboard<small>Control panel</small></h1>
	// admin/group/index  =>   <h1>Group<small>list</small></h1>
	// admin/group/add    =>   <h1>Group<small>add</small></h1>
	$listControllerTitle = [
		"index" => "Dashboard",
		"group" => "Group"
	];

	$listActionTitle = [
		"index"  => "List",
		"add"    => "Add",
		"edit"   => "Edit",
		"delete" => "Delete",
	];

	$xhtmlHeader = sprintf("<h1>%s<small>%s</small></h1>",
							$listControllerTitle[$this->params["controller"]],
							$listActionTitle[$this->params["action"]]);
?>
<!-- HEADER -->
<section class="content-header">

     <?php echo $xhtmlHeader ?>

<!-- BREADCRUM -->
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active">Dashboard</li>
	  </ol>
</section>