<?php
/*
Plugin Name: Disable Price Range for Woocommerce
Plugin URI: https://github.com/closemarketing/woocommerce-dpr
Description: Disable price range and replaces for a text From:
Author: closemarketing, davidperez
Author URI: https://www.closemarketing.es
Version: 0.1
Text Domain: wdpr
Domain Path: /languages
License: GNU General Public License version 3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * @snippet       Disable Variable Product Price Range
 * @how-to        Watch tutorial @ http://businessbloomer.com/?p=19055
 * @sourcecode    http://businessbloomer.com/disable-variable-product-price-range-woocommerce/
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 2.4.7
 */

add_filter( 'woocommerce_variable_sale_price_html', 'wdpr_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wdpr_variation_price_format', 10, 2 );

function wdpr_variation_price_format( $price, $product ) {
    // Main Price
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $price = $prices[0] !== $prices[1] ? sprintf( __( '<span class="desde">desde</span> %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    // Sale Price
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $saleprice = $prices[0] !== $prices[1] ? sprintf( __( '<span class="from">From:</span> %1$s', 'wdpr' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    if ( $price !== $saleprice ) {
    $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
    }
    return $price;
}
