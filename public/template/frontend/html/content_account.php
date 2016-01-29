
<!-- BREADCRUMB -->
<div class="breadcrumb">
	<a href="#">Home</a> &raquo;<a href="#" class="last">Entertainment</a>
</div>

<!-- CATEGORY NAME -->
<h1>My Account Information</h1>

<div class="box-container">
	<h2>My Account</h2>
	<div class="content">
		<ul>
			<li><a href="#">Edit your account information</a></li>
			<li><a href="#">Change your password</a></li>
			<li><a href="#">Recurring payments</a></li>
		</ul>
	</div>
	<h2>My Orders</h2>
	<div class="content">
		<ul>
			<li><a href="#">View your order history</a></li>
			<li><a href="#">Downloads</a></li>
			<li><a href="#">Your Reward Points</a></li>
			<li><a href="#">View your return requests</a></li>
			<li><a href="#">Your Transactions</a></li>
		</ul>
	</div>
	<h2>Newsletter</h2>
	<div class="content">
		<ul>
			<li><a href="#">Subscribe unsubscribe to newsletter</a></li>
		</ul>
	</div>
</div>

<div class="box-container">
	<form class="form-horizontal content-border" action="#" method="post" enctype="multipart/form-data" id="edit">
		<h2>Your Personal Details</h2>
		<div class="content">
			<div class="form ">
				<div class="form-group">
					<label class="control-label col-sm-5"><span class="required">*</span>
						First Name:</label>
					<div class="controls col-sm-7">
						<input type="text" name="firstname" value="Abc"> <span
							class="error help-inline"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-5"><span class="required">*</span>
						Last Name:</label>
					<div class="controls col-sm-7">
						<input type="text" name="lastname" value="def">
					</div>
				</div>
			</div>
		</div>
		<div class="buttons">
			<div class="left">
				<a href="#" class="button-back-left"><i class="fa fa-reply"></i>Back</a>
			</div>
			<div class="right">
				<a onclick="$('#edit').submit();" class="button-cont-right">Continue<i
					class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</form>
</div>
