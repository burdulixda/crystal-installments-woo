<?php

/**
 * Plugin Name: Crystal Installments for WooCoommerce
 * Plugin URI: https://crystalone.ge
 * Author: George Burduli
 * Author URI: https://github.com/burdulixda
 * Description: A custom WooCommerce payment gateway for processing installments in Credo bank.
 * Version: 1.0.2
 * License: 1.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: uci-woo
 * 
 * Class WC_Gateway_Crystal file.
 *
 * @package WooCommerce\Crystal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;

add_action( 'plugins_loaded', 'crystal_payment_init', 11 );
add_filter( 'woocommerce_currencies', 'uci_add_gel_currencies' );
add_filter( 'woocommerce_currency_symbol', 'uci_add_gel_currencies_symbol', 10, 2 );
add_filter( 'woocommerce_payment_gateways', 'add_to_woo_crystal_installment_gateway' );

function crystal_payment_init() {
	if ( class_exists( 'WC_Payment_Gateway' ) ) {
		require_once plugin_dir_path( __FILE__ ) . '/includes/class-wc-payment-gateway-uci.php';
		// require_once plugin_dir_path( __FILE__ ) . '/includes/crystal-order-statuses.php';
	}
}

function add_to_woo_crystal_installment_gateway( $gateways ) {
	$gateways[] = 'WC_Gateway_Crystal';
	return $gateways;
}

function uci_add_gel_currencies( $currencies ) {
	$currencies['GEL'] = __( 'Georgian lari', 'uci-woo' );

	return $currencies;
}

function uci_add_gel_currencies_symbol( $currency_symbol, $currency ) {
	switch ( $currency ) {
		case 'GEL':
			$currency_symbol = '₾';
		break;
	}
	return $currency_symbol;
}