<?php
/**
 * Checkout Login Form
 */
if (is_user_logged_in()) return;
if (get_option('woocommerce_enable_signup_and_login_from_checkout')=="no") return;

$info_message = apply_filters('woocommerce_checkout_login_message', __('Already registered?', 'woothemes'));
?>

<p class="info"><?php echo $info_message; ?> <a href="#" class="showlogin"><?php _e('Click here to login', 'woothemes'); ?></a></p>

<?php woocommerce_login_form( __('If you have shopped with us before, please enter your username and password in the boxes below. If you are a new customer please proceed to the Billing &amp; Shipping section.', 'woothemes') ); ?>