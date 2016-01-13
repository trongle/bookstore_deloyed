
<!-- BREADCRUMB -->
<div class="breadcrumb">
	<a href="#">Home</a> &raquo;<a href="#" class="last">Shopping cart</a>
</div>

<!-- CATEGORY NAME -->
<h1>SHOPPING CART</h1>

<!-- CATEGORY INFO -->
<form id="form-cart" action="#" method="post"
	enctype="multipart/form-data">
	<div class="cart-info">
		<div class="shop-cart">
			<table class="table table-bordered ">
				<thead>
					<tr>
						<td class="image">Image</td>
						<td class="name">Product Name</td>
						<td class="model">Model</td>
						<td class="quantity">Quantity</td>
						<td class="price-td">Unit Price</td>
						<td class="total-td" style="border-right: none;">Total</td>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td class="image"><a href="#"><img
								src="<?php echo URL_IMG_SHOP ?>data/product-40-47x47.png"
								alt="ISpsum" title="ISpsum"></a></td>
						<td class="name"><a href="">ISpsumdolor sit amet</a><br /> <small>Reward
								Points: 700</small></td>
						<td class="model">Product 17</td>
						<td class="quantity"><input type="text" name="quantity[44::]"
							value="1" size="1">
							<div class="wrapper mt5">
								<a class="input-update"
									onclick="document.getElementById('form-cart').submit()"> <i
									class=" fa fa-refresh"></i>
								</a> &nbsp; <a href="#" class="input-update"
									onclick="document.getElementById('form-cart').submit()"> <i
									class="fa fa-trash-o"></i>
								</a>
							</div></td>
						<td class="price">$1,177.00</td>
						<td class="total">$1,177.00</td>
					</tr>
					<tr>
						<td class="image"><a href="#"><img
								src="<?php echo URL_IMG_SHOP ?>data/product-40-47x47.png"
								alt="ISpsum" title="ISpsum"></a></td>
						<td class="name"><a href="">ISpsumdolor sit amet</a><br /> <small>Reward
								Points: 700</small></td>
						<td class="model">Product 17</td>
						<td class="quantity"><input type="text" name="quantity[44::]"
							value="1" size="1">
							<div class="wrapper mt5">
								<a class="input-update"
									onclick="document.getElementById('form-cart').submit()"> <i
									class=" fa fa-refresh"></i>
								</a> &nbsp; <a href="#" class="input-update"
									onclick="document.getElementById('form-cart').submit()"> <i
									class="fa fa-trash-o"></i>
								</a>
							</div></td>
						<td class="price">$1,177.00</td>
						<td class="total">$1,177.00</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</form>

<div class="cart-bottom">
	<div class="cart-total">
		<table id="total" class="table table-bordered">
			<tbody>
				<tr class="row-table-1">
					<td class="right cart-total-name "><b>Sub-Total:</b></td>
					<td class="right cart-total1 ">$1,288.00</td>
				</tr>
				<tr class="row-table-2">
					<td class="right cart-total-name "><b>Eco Tax (-2.00):</b></td>
					<td class="right cart-total1 ">$8.00</td>
				</tr>
				<tr class="row-table-3">
					<td class="right cart-total-name "><b>VAT (17.5%):</b></td>
					<td class="right cart-total1 ">$225.40</td>
				</tr>
				<tr class="row-table-4">
					<td class="right cart-total-name last"><b>Total:</b></td>
					<td class="right cart-total1 last">$1,521.40</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="buttons">
		<div class="right">
			<a
				href="http://livedemo00.template-help.com/opencart_49309/index.php?route=checkout/checkout"
				class="button-cont-right">Checkout<i class="fa fa-check"></i></a>
		</div>
		<div class="center">
			<a
				href="http://livedemo00.template-help.com/opencart_49309/index.php?route=common/home"
				class="button-cont-right">Continue Shopping<i
				class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
</div>
