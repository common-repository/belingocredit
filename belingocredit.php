<?php
/**
* Plugin Name: BelingoCredit
* Description: The plugin adds the [belingoCredit] shortcode, which can be used on any page of the site
* Version: 1.0.3
* Author: Belingo llc
* Author URI: https://belingo.ru
* Text Domain: belingocredit
* Domain Path: /languages
*
*/

function belingoCredit_styles() {	
	wp_enqueue_style( 'belingo-credit', plugin_dir_url(__FILE__).'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'belingoCredit_styles' );

add_shortcode("belingoCredit", "belingoCredit");
function belingoCredit() {

	include('classes/BelingoCredit_CalcClass.php');

	if(isset($_POST['credit_summ'])) {
		$credit_summ = sanitize_text_field($_POST['credit_summ']);
	}else{
		$credit_summ = 500000;
	}

	if(isset($_POST['credit_period'])) {
		$credit_period = sanitize_text_field($_POST['credit_period']);
	}else{
		$credit_period = 36;
	}

	if(isset($_POST['credit_procent'])) {
		$credit_procent = sanitize_text_field($_POST['credit_procent']);
	}else{
		$credit_procent = 16;
	}

	if(isset($_POST['credit_adv_payment'])) {
		$credit_adv_payment = sanitize_text_field($_POST['credit_adv_payment']);
	}else{
		$credit_adv_payment = '';
	}

	if(isset($_POST['credit_adv_month_payment'])) {
		$credit_adv_month_payment = sanitize_text_field($_POST['credit_adv_month_payment']);
	}else{
		$credit_adv_month_payment = '';
	}

	if(isset($_POST['credit_type'])) {
		$credit_type = sanitize_text_field($_POST['credit_type']);
	}else{
		$credit_type = 'annu';
	}

	if(isset($_POST['currency'])) {
		$currency = sanitize_text_field($_POST['currency']);
	}else{
		$currency = 'RUB';
	}

	$calc = new BelingoCredit_CalcClass();

	if(isset($_POST['process_calc'])) {
		$calc->set('summ', $credit_summ);
		$calc->set('period', $credit_period);
		$calc->set('procent', $credit_procent);
		$calc->set('credit_adv_payment', $credit_adv_payment);
		$calc->set('credit_adv_month_payment', $credit_adv_month_payment);
		$calc->set('credit_type', $credit_type);
		$calc->set('currency', $currency);
		$calc->process();
	}

	ob_start();
	if(file_exists(get_template_directory() . '/belingocredit/belingoCreditTemplate.php')) {
		include_once( get_template_directory() . '/belingocredit/belingoCreditTemplate.php' );
	}else{
		include_once( WP_PLUGIN_DIR . '/belingocredit/templates/belingoCreditTemplate.php' );
	}

	$result = ob_get_contents();
	ob_end_clean();
		
	return $result;

}

add_action( 'init', 'belingoCredit_load_plugin_textdomain' );
 
function belingoCredit_load_plugin_textdomain() {
	load_plugin_textdomain( 'belingocredit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

?>