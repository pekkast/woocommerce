<?php
/**
 * Cart Page
 */
 
global $woocommerce;
?>

<?php $woocommerce->show_messages(); ?>

<form action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post">
<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-remove"></th>
			<th class="product-thumbnail"></th>
			<th class="product-name"><span class="nobr"><?php _e('Product Name', 'woothemes'); ?></span></th>
			<th class="product-price"><span class="nobr"><?php _e('Unit Price', 'woothemes'); ?></span></th>
			<th class="product-quantity"><?php _e('Quantity', 'woothemes'); ?></th>
			<th class="product-subtotal"><?php _e('Price', 'woothemes'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (sizeof($woocommerce->cart->get_cart())>0) : 
			foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) :
				$_product = $values['data'];
				if ($_product->exists() && $values['quantity']>0) :
				
					?>
					<tr>
						<td class="product-remove"><a href="<?php echo esc_url( $woocommerce->cart->get_remove_url($cart_item_key) ); ?>" class="remove" title="<?php _e('Remove this item', 'woothemes'); ?>">&times;</a></td>
						<td class="product-thumbnail">
							<a href="<?php echo esc_url( get_permalink($values['product_id']) ); ?>">
							<?php 
								echo $_product->get_image();
							?>
							</a>
						</td>
						<td class="product-name">
							<a href="<?php echo esc_url( get_permalink($values['product_id']) ); ?>"><?php echo $_product->get_title(); ?></a>
							<?php
								// Meta data
								echo $woocommerce->cart->get_item_data( $values );
                   				
                   				// Backorder notification
                   				if ($_product->backorders_require_notification() && $_product->get_total_stock()<1) echo '<p class="backorder_notification">'.__('Available on backorder.', 'woothemes').'</p>';
							?>
						</td>
						<td class="product-price"><?php 
						
							if (get_option('woocommerce_display_cart_prices_excluding_tax')=='yes') :
								echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $_product->get_price_excluding_tax() ), $values, $cart_item_key ); 
							else :
								echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $_product->get_price() ), $values, $cart_item_key ); 
							endif;
							
						?></td>
						<td class="product-quantity"><div class="quantity"><input name="cart[<?php echo $cart_item_key; ?>][qty]" value="<?php echo esc_attr( $values['quantity'] ); ?>" size="4" title="Qty" class="input-text qty text" maxlength="12" /></div></td>
						<td class="product-subtotal"><?php 

							echo $woocommerce->cart->get_product_subtotal( $_product, $values['quantity'] )	;
													
						?></td>
					</tr>
					<?php
				endif;
			endforeach; 
		endif;
		
		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">
				<div class="coupon">
					<label for="coupon_code"><?php _e('Coupon', 'woothemes'); ?>:</label> <input name="coupon_code" class="input-text" id="coupon_code" value="" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e('Apply Coupon', 'woothemes'); ?>" />
				</div>
				<?php $woocommerce->nonce_field('cart') ?>
				<input type="submit" class="button" name="update_cart" value="<?php _e('Update Cart', 'woothemes'); ?>" /> <a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="checkout-button button alt"><?php _e('Proceed to Checkout &rarr;', 'woothemes'); ?></a>
				<?php do_action('woocommerce_proceed_to_checkout'); ?>
			</td>
		</tr>
	</tbody>
</table>
</form>
<div class="cart-collaterals">
	
	<?php do_action('woocommerce_cart_collaterals'); ?>
	
	<?php woocommerce_cart_totals(); ?>
	
	<?php woocommerce_shipping_calculator(); ?>
	
</div>