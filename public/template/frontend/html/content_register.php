
<!-- BREADCRUMB -->
<div class="breadcrumb">
	<a href="#">Home</a> &raquo;<a href="#" class="last">Register</a>
</div>

<!-- NAME -->
<h1 class="style-1">Register</h1>

<div class="box-container">
	<p>
		If you already have an account with us, please login at the <a href="#">login page</a>.
	</p>
	
	<form class="form-horizontal" action="#" method="post" enctype="multipart/form-data" id="register">
		<div class="warning">Warning: You must agree to the Privacy Policy!</div>
		
		<h2>Your Personal Details</h2>
		<div class="content">
			<table class="form">
				<tbody>
					<tr>
						<td>
							<div class="form-group">
								<label class="control-label col-sm-5"><span class="required">*</span>First Name:</label>
								<div class="controls col-sm-7">
									<input class="q1" type="text" name="firstname" value="">
									<span class="error help-inline">First Name must be between 1 and 32 characters!</span>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td>
							<div class="form-group">
								<label class="control-label col-sm-5">Fax:</label>
								<div class="controls col-sm-7">
									<input class="q1" type="text" name="fax" value="">
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<h2>Your Address</h2>
		<div class="content">
			<table class="form">
				<tbody>
					<tr>
						<td>
							<div class="form-group">
								<label class="control-label col-sm-5"><span id="postcode-required" class="required">*</span> Post Code:</label>
								<div class="controls col-sm-7">
									<input class="q1" type="text" name="postcode" value="">
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td>
							<div class="form-group">
								<label class="control-label col-sm-5"><span class="required">*</span>Region / State:</label>
								<div class="controls col-sm-7">
									<select name="zone_id"><option value="">--- Please Select ---</option>
										<option value="3513">Aberdeen</option>
										<option value="3514">Aberdeenshire</option>
										<option value="3612">Wrexham</option>
									</select>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="buttons">
			<div class="right">
				<a onclick="$('#register').submit();" class="button"><span>Continue</span></a>
			</div>
		</div>
	</form>
</div>
