<!-- BREADCRUMB -->
<div class="breadcrumb">
	<a href="#">Home</a> &raquo;<a href="#" class="last">Sit amet conse
		ctetur</a>
</div>


<div class="product-info">
	<div class="row">
		<div class="col-sm-4">
			<h1 class="view">Sit amet conse ctetur adipisicing elit sed do eiusmod tempor</h1>

			<div id="default_gallery" class="left spacing">
				<div class="image">
					<div style="height: 268px; width: 268px;" class="zoomWrapper">
						<img id="zoom_01" data-zoom-image="http://livedemo00.template-help.com/opencart_49309/image/cache/data/product-19-600x600.png"
							src="<?php echo URL_IMG_SHOP ?>data/product-19-600x600.png"
							title="Sit amet conse ctetur adipisicing elit sed do eiusmod tempor"
							alt="Sit amet conse ctetur adipisicing elit sed do eiusmod tempor"
							style="position: absolute;">
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-8">
			<h1>Sit amet conse ctetur adipisicing elit sed do eiusmod tempor</h1>
			<div class="description">
				<div class="product-section">
					<span>Product Code:</span> Product 6<br> <span>Availability:</span>
					<div class="prod-stock">In Stock</div>
				</div>
				<div class="price">
					<span class="text-price">Price:</span> <span class="price-new">$237.00</span>
					<span class="price-tax">Ex Tax: $200.00</span>
				</div>
				<div class="cart">
					<div class="prod-row">
						<div class="cart-top">
							<div class="cart-top-padd form-inline">
								<label>Qty: 
									<input class="q-mini" type="text" name="quantity" value="1"> 
									<input class="q-mini" type="hidden" name="product_id" value="33">
								</label> 
								<a id="button-cart" class="button-prod"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
							</div>
							<div class="extra-button">
								<div class="wishlist">
									<a onclick="addToWishList('33');" title="Add to Wish List"><i class="fa fa-star"></i><span>Add to Wish List</span></a>
								</div>
								<div class="compare">
									<a onclick="addToCompare('33');" title="Add to Compare"><i class="fa fa-bar-chart-o"></i><span>Add to Compare</span></a>
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="review">
					<div>
						<img src="<?php echo URL_IMG_SHOP ?>stars-0.png" alt="0 reviews">&nbsp;&nbsp;
						<div class="btn-rew">
							<a onclick="document.getElementById('tab-review').scrollIntoView();">0 reviews</a> 
							<a onclick="document.getElementById('tab-review').scrollIntoView();"><i class="fa fa-pencil"></i>Write a review</a>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	
	<div class="tabs">
		<div class="tab-heading">Description</div>
		<div class="tab-content">
			<p>
				<strong>Well, reading books </strong>as a hobby was always a noble,
				pleasant and very useful kind of activity. It gives knowledge,
			</p>

			<p>
				<strong>But those times</strong> are long gone and we live in 21st
				century, and the most revolutionary thing that had happened is that
			</p>
		</div>
	</div>
	
	<div class="tabs" id="tab-review">
		<div class="tab-heading">Reviews (0)</div>
		<div class="tab-content">
			<div id="review">
				<div class="content">There are no reviews for this product.</div>
			</div>
			<h2 id="review-title">Write a review</h2>
			<label>Your Name:</label> <input type="text" name="name" value=""> <br><br> 
			<label>Your Review:</label><textarea name="text" cols="40" rows="8" style="width: 93%;"></textarea>
			<div class="clear"></div>
			
			<span style="font-size: 11px;">
				<span style="color: #FF0000;">Note:</span>
				HTML is not translated!
			</span><br> <br> 
			<label class="inline">Rating:</label>
			<div class="form-inline border">
				<span class="radio">Bad</span>&nbsp; 
				<input type="radio" name="rating" value="1"> &nbsp; 
				<input type="radio" name="rating" value="2"> &nbsp; 
				<input type="radio" name="rating" value="3"> &nbsp; 
				<input type="radio" name="rating" value="4"> &nbsp; 
				<input type="radio" name="rating" value="5"> &nbsp; 
				<span class="radio">Good</span><br>
			</div>

			<label>Enter the code in the box below:</label> 
			<input type="text" name="captcha" value=""> 
			<img src="" alt="" id="captcha"> <br>
			<div class="buttons">
				<div>
					<a id="button-review" class="button-cont-right">Continue<i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
	</div>

</div>