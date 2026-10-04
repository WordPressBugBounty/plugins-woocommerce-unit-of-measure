<?php
/**
 * Core loader class for Unit Of Measure (UOM) for WooCommerce.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_UOM
 * @subpackage WooCommerce_UOM/includes
 * @since      3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Parent class that pulls the admin and public functionality together.
 *
 * @since 3.0.0
 */
class Wc_Uom {

	/**
	 * The Constructor.
	 *
	 * @since 3.0.0
	 */
	public function __construct() {
		$this->wc_uom_requires();
	}

	/**
	 * Include the admin and public class files.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public function wc_uom_requires() {
		$plugin_dir = trailingslashit( dirname( __DIR__ ) );

		require_once $plugin_dir . 'admin/class-wc-uom-admin.php';
		require_once $plugin_dir . 'public/class-wc-uom-public.php';
	}
}

/**
 * Instantiate the class.
 *
 * @since 2.0.0
 */
$wc_uom = new Wc_Uom();
