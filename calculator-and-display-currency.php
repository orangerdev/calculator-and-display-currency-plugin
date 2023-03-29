<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ridwan-arifandi.com
 * @since             1.0.0
 * @package           Calculator_And_Display_Currency
 *
 * @wordpress-plugin
 * Plugin Name:       Calculator and Display Currency, Shortcode: [riwayat_harga_logam_mulia] , [kalkulator_harga_logam_mulia]
 * Plugin URI:        https://ridwan-arifandi.com
 * Description:       Calculator and Display Currency
 * Version:           1.0.0
 * Author:            Orangerdev Team
 * Author URI:        https://ridwan-arifandi.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       calculator-and-display-currency
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CALCULATOR_AND_DISPLAY_CURRENCY_VERSION', '1.0.0' );

define( 'CALCULATOR_AND_DISPLAY_CURRENCY_PATH', plugin_dir_path( __FILE__ ) );
define( 'CALCULATOR_AND_DISPLAY_CURRENCY_URI', plugin_dir_url( __FILE__ ) );

require_once( 'vendor/autoload.php' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-calculator-and-display-currency-activator.php
 */
function activate_calculator_and_display_currency() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-calculator-and-display-currency-activator.php';
	Calculator_And_Display_Currency_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-calculator-and-display-currency-deactivator.php
 */
function deactivate_calculator_and_display_currency() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-calculator-and-display-currency-deactivator.php';
	Calculator_And_Display_Currency_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_calculator_and_display_currency' );
register_deactivation_hook( __FILE__, 'deactivate_calculator_and_display_currency' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-calculator-and-display-currency.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_calculator_and_display_currency() {

	$plugin = new Calculator_And_Display_Currency();
	$plugin->run();

}
run_calculator_and_display_currency();
