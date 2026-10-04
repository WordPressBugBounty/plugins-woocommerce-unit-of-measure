<?php
/**
 * The public facing functionality for Unit Of Measure (UOM) for WooCommerce.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_UOM
 * @subpackage WooCommerce_UOM/public
 * @since      3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Public class that appends the UOM after product and cart prices.
 *
 * @since 3.0.0
 */
class WC_UOM_Public {

	/**
	 * The Constructor.
	 *
	 * @since 3.0.0
	 */
	public function __construct() {
		$this->wc_uom_public_activate();
	}

	/**
	 * Register the public filters.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public function wc_uom_public_activate() {
		add_filter( 'woocommerce_get_price_html', array( $this, 'wc_uom_render_output' ), 999, 2 );
		add_filter( 'woocommerce_cart_item_price', array( $this, 'wc_uom_add_uom_to_cart_item_price' ), 10, 2 );
	}

	/**
	 * Append the UOM to the product price HTML.
	 *
	 * @since 1.0.1
	 *
	 * @param string          $price   The product price HTML.
	 * @param WC_Product|null $product The product the price belongs to.
	 * @return string The price HTML, with the UOM appended when one is set.
	 */
	public function wc_uom_render_output( $price, $product = null ) {
		if ( ! $price || ! $product instanceof WC_Product ) {
			return $price;
		}

		// The UOM is saved per parent product, so variations use the parent ID.
		$product_id = $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id();
		$uom        = $this->woo_uom_output_getter( $product_id );

		if ( '' === $uom ) {
			return $price;
		}

		return $price . ' <span class="uom">' . esc_html( $uom ) . '</span>';
	}

	/**
	 * Append the UOM to the cart item price.
	 *
	 * @since 3.2.0
	 *
	 * @param string $price     The cart item price HTML.
	 * @param array  $cart_item The cart item data.
	 * @return string The price HTML, with the UOM appended when one is set.
	 */
	public function wc_uom_add_uom_to_cart_item_price( $price, $cart_item ) {
		if ( ! is_array( $cart_item ) || ! isset( $cart_item['product_id'] ) ) {
			return $price;
		}

		$uom = $this->woo_uom_output_getter( absint( $cart_item['product_id'] ) );

		if ( '' !== $uom ) {
			$price .= ' <span class="uom">' . esc_html( $uom ) . '</span>';
		}

		return $price;
	}

	/**
	 * Get the UOM from post meta for a product.
	 *
	 * @since 3.0.3
	 *
	 * @param int $uom_item_id The product ID.
	 * @return string The UOM, or an empty string when none is set.
	 */
	private function woo_uom_output_getter( $uom_item_id ) {
		if ( ! $uom_item_id ) {
			return '';
		}

		return (string) get_post_meta( $uom_item_id, '_woo_uom_input', true );
	}
}

/**
 * Instantiate the class.
 *
 * @since 3.0.0
 */
$wc_uom_public = new WC_UOM_Public();
