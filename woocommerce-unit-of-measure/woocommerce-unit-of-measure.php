<?php
/**
 * Plugin Name:          Unit Of Measure (UOM) for WooCommerce
 * Description:          Unit Of Measure (UOM) for WooCommerce allows the user to add a unit of measure (or any text) after the price on WooCommerce products.
 * Version:              3.3.1
 * Requires at least:    6.5
 * Requires PHP:         7.4
 * Author:               Bradley Davis
 * Author URI:           https://bradley-davis.com
 * License:              GPLv3 or later
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:          woocommerce-unit-of-measure
 * Domain Path:          /languages
 * Requires Plugins:     woocommerce
 * WC requires at least: 6.0.0
 * WC tested up to:      11.1.2
 *
 * Unit Of Measure (UOM) for WooCommerce. A Plugin that works with the WooCommerce plugin for WordPress.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see https://www.gnu.org/licenses/gpl-3.0.html.
 *
 * @package WooCommerce_UOM
 * @author  Bradley Davis
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'plugins_loaded', 'wc_uom_init' );

/**
 * Initialize plugin after all plugins are loaded.
 *
 * Only loads the plugin classes when WooCommerce is active.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wc_uom_init() {
	if ( class_exists( 'WooCommerce' ) ) {
		wc_uom_class_loader();
	}
}

/**
 * Declare compatibility with High Performance Order Storage (HPOS).
 *
 * @since 3.1.0
 *
 * @return void
 */
add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
);

/**
 * Load the classes that make the magic.
 *
 * @since 3.0.0
 *
 * @return void
 */
function wc_uom_class_loader() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-uom.php';
}
