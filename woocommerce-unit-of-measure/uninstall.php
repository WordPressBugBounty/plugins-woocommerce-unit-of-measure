<?php
/**
 * Delete Unit Of Measure (UOM) for WooCommerce data when the plugin is deleted.
 *
 * @author     Bradley Davis
 * @package    WooCommerce_UOM
 * @since      1.0.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_post_meta_by_key( '_woo_uom_input' );
