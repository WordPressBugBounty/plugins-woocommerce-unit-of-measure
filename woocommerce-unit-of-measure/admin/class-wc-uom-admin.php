<?php
/**
 * The admin specific functionality for Unit Of Measure (UOM) for WooCommerce.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_UOM
 * @subpackage WooCommerce_UOM/admin
 * @since      3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin class that adds and saves the UOM product field.
 *
 * @since 3.0.0
 */
class WC_UOM_Admin {

	/**
	 * The Constructor.
	 *
	 * @since 3.0.0
	 */
	public function __construct() {
		$this->wc_uom_admin_activate();
	}

	/**
	 * Register the admin hooks.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public function wc_uom_admin_activate() {
		add_action( 'woocommerce_product_options_inventory_product_data', array( $this, 'wc_uom_product_fields' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'wc_uom_save_field_input' ) );
	}

	/**
	 * Add the UOM field to the product Inventory tab.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public function wc_uom_product_fields() {
		// Security: make sure the form request comes from the right place.
		wp_nonce_field( basename( __FILE__ ), 'wc_uom_product_fields_nonce' );

		echo '<div class="wc_uom_input">';
		woocommerce_wp_text_input(
			array(
				'id'          => '_woo_uom_input',
				'label'       => __( 'Unit of Measure', 'woocommerce-unit-of-measure' ),
				'placeholder' => '',
				'desc_tip'    => true,
				'description' => __( 'Enter your unit of measure for this product here.', 'woocommerce-unit-of-measure' ),
			)
		);
		echo '</div>';
	}

	/**
	 * Save the UOM input to the product meta.
	 *
	 * An empty value is saved as well so the UOM can be cleared.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id The ID of the product being saved.
	 * @return void
	 */
	public function wc_uom_save_field_input( $post_id ) {
		if ( ! isset( $_POST['_woo_uom_input'], $_POST['wc_uom_product_fields_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['wc_uom_product_fields_nonce'] ) ), basename( __FILE__ ) ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$woo_uom_input = sanitize_text_field( wp_unslash( $_POST['_woo_uom_input'] ) );
		update_post_meta( $post_id, '_woo_uom_input', $woo_uom_input );
	}
}

/**
 * Instantiate the class.
 *
 * @since 3.0.0
 */
$wc_uom_admin = new WC_UOM_Admin();
