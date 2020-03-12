<?php
/*
Plugin Name: Showroom Pickups Maya
Plugin URI: 
Description: Showroom Pickups Maya
Version: 2.0
Author: TharinduH
Text Domain: maya
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    function showroom_pickup_shipping_method() {
        if ( ! class_exists( 'Showroom_Pickup_Shipping_Method' ) ) {
            class Showroom_Pickup_Shipping_Method extends WC_Shipping_Method {
                /**
                 * Constructor for your shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct() {
                    $this->id                 = 'showroom_pickup'; 
                    $this->method_title       = __( 'Showroom Pickup Shipping', 'showroom_pickup' );  
                    $this->method_description = __( 'Custom Shipping Method for Showroom Pickup', 'showroom_pickup' ); 
 
                    $this->init();
 
                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'Showroom Pickup Shipping', 'showroom_pickup' );
                }
 
                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                function init() {
                    // Load the settings API
                    $this->init_form_fields(); 
                    $this->init_settings(); 
 
                    // Save settings in admin if you have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }
 
                /**
                 * Define settings field for this shipping
                 * @return void 
                 */
                function init_form_fields() { 
 
                    $this->form_fields = array(
                        'enabled' => array(
                            'title' => __( 'Enable', 'showroom_pickup' ),
                            'type' => 'checkbox',
                            'description' => __( 'Enable this shipping.', 'showroom_pickup' ),
                            'default' => 'yes'
                        ),
                        'title' => array(
                            'title' => __( 'Title', 'showroom_pickup' ),
                            'type' => 'text',
                            'description' => __( 'Title to be display on site', 'showroom_pickup' ),
                            'default' => __( 'Showroom Pickup Shipping', 'showroom_pickup' )
                        ),
                    );
 
                }
            }
        }
    }
 
    add_action( 'woocommerce_shipping_init', 'showroom_pickup_shipping_method' );
 
    function add_showroom_pickup_shipping_method( $methods ) {
        $methods[] = 'Showroom_Pickup_Shipping_Method';
        return $methods;
    } 
    add_filter( 'woocommerce_shipping_methods', 'add_showroom_pickup_shipping_method' );
}