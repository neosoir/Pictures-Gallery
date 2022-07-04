<?php
/**
 *
 * @link                https://neoslab.online
 * @since               1.0.0
 * @package             gallery-pictures
 *
 * @wordpress-plugin
 * Plugin Name:         Pictures gallery 
 * Plugin URI:          https://neoslab.online
 * Description:         Create a portafolio type gallery and also takes values of publications to display in frontend using shorcodes.
 * Version:             1.0.0
 * Requires at least:   6.0
 * Requires PHP:        7.4
 * Author:              Neos Lab
 * Author URI:          https://neoslab.online
 * License:             GPL2
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         bcpg-textdomain
 * Domain Path:         /languages
 */


if ( ! defined( 'WPINC' ) ) {
	die;
}

global $wpdb;
define( 'BCPG_REALPATH_BASENAME_PLUGIN', dirname( plugin_basename( __FILE__ ) ) . '/' );
define( 'BCPG_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'BCPG_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'BCPG_TABLE', "{$wpdb->prefix}bcpg_data" );

/**
 * Código que se ejecuta en la activación del plugin
 */
function activate_beziercode_portfolio_galeria() {
    require_once BCPG_PLUGIN_DIR_PATH . 'includes/class-bcpg-activator.php';
	BCPG_Activator::activate();
}

/**
 * Código que se ejecuta en la desactivación del plugin
 */
function deactivate_beziercode_portfolio_galeria() {
    require_once BCPG_PLUGIN_DIR_PATH . 'includes/class-bcpg-deactivator.php';
	BCPG_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_beziercode_portfolio_galeria' );
register_deactivation_hook( __FILE__, 'deactivate_beziercode_portfolio_galeria' );

require_once BCPG_PLUGIN_DIR_PATH . 'includes/class-bcpg-master.php';

function run_bcpg_master() {
    $bcpg_master = new BCPG_Master;
    $bcpg_master->run();
}

run_bcpg_master();
























