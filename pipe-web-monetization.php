<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress or ClassicPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://plugin.pipewebmonetization.com/
 * @since             1.0.0
 * @package           Pipe_Web_Monetization
 *
 * @wordpress-plugin
 * Plugin Name:       Pipe Web Monetization
 * Plugin URI:        http://plugin.pipewebmonetization.com/
 * Description:       Pipe allows you to control who gets paid for your content and connect your payments to an admin dashboard.
 * Version:           1.0.6
 * Author:            Pipe
 * Requires at least: 4.9
 * Tested up to:      6.0.1
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pipe-web-monetization
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PIPE_WEB_MONETIZATION_VERSION', '1.0.3' );

/**
 * Define the Plugin basename
 */
define( 'PIPE_WEB_MONETIZATION_BASE_NAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 *
 * This action is documented in includes/class-pipe-web-monetization-activator.php
 * Full security checks are performed inside the class.
 */
function pipe_web_monetization_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pipe-web-monetization-activator.php';
	(new Pipe_Web_Monetization_Activator)->activate();
	(new Pipe_Web_Monetization_Activator)->create_payment_pointers_table();

	$cat_name = 'Only Web Monetized Users';
	$cat_slug = 'pipe-category';

	$premium_name = 'Premium Consumer';
	$premium_slug = 'premium-consumer-category';

	if(!term_exists($cat_name, 'category')){
		$cat_id = wp_create_category($cat_name, 0);
		wp_update_term($cat_id, 'category', array(
			'slug' => $cat_slug
		));
	}

	if(!term_exists($premium_name, 'category')){
		$premium_id = wp_create_category($premium_name, 0);
		wp_update_term($premium_id, 'category', array(
			'slug' => $premium_slug
		));
	}
}

/**
 * The code that runs during plugin deactivation.
 *
 * This action is documented in includes/class-pipe-web-monetization-deactivator.php
 * Full security checks are performed inside the class.
 */
function pipe_web_monetization_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pipe-web-monetization-deactivator.php';
	(new Pipe_Web_Monetization_Deactivator)->deactivate();
}

/**
 * The code that runs during plugin uninstall.
 *
 * This action is documented in includes/class-pipe-web-monetization-uninstall.php
 * Full security checks are performed inside the class.
 */
function pipe_web_monetization_uninstall() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pipe-web-monetization-uninstall.php';
	(new Pipe_Web_Monetization_Uninstall)->drop_payment_pointers_table();
	(new Pipe_Web_Monetization_Uninstall)->uninstall();
}

register_activation_hook( __FILE__, 'pipe_web_monetization_activate' );
register_deactivation_hook( __FILE__, 'pipe_web_monetization_deactivate' );
register_uninstall_hook( __FILE__, 'pipe_web_monetization_uninstall' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pipe-web-monetization.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Generally you will want to hook this function, instead of callign it globally.
 * However since the purpose of your plugin is not known until you write it, we include the function globally.
 *
 * @since    1.0.0
 */
function pipe_web_monetization_run() {

	$plugin = new Pipe_Web_Monetization();
	$plugin->run();

}
pipe_web_monetization_run();
