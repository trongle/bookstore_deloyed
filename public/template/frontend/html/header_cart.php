<?php 

use Zend\Session\Container;
	$ssOrder      = new Container(BOOKONLINE_KEY."_order");
	$total        = empty($ssOrder->qty)? 0:array_sum($ssOrder->qty); 
	$linkViewCart = $this->linkViewCart();
?>
<div class="cart-position">
	<div class="cart-inner">
		<a href="<?php echo $linkViewCart ?>"><div id="cart" class="">
			<div class="heading">
				<span class="link_a"> 
					<i class="fa fa-shopping-cart"></i> <b>Cart:</b>
					<span class="sc-button"></span> <span id="cart-total2"><?php echo $total ?></span> 
					<i class="fa fa-angle-down"></i> <span class="clear"></span>
				</span>
			</div>
		</a>
		</div>
	</div>
</div>