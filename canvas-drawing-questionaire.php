<?php

/**
 * Plugin Name:       Canvas Drawing Questionaire
 * Description:       Canvas Drawing Questionaire Widget is created by Zain Hassan.
 * Version:           1.0.7
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Zain Hassan
 * Author URI:        https://hassanzain.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       hz-widgets
*/

if(!defined('ABSPATH')){
    exit;
}

if ( ! defined( 'CDQ_PLUGIN_ASSETS_FILE' ) ) {
	define( 'CDQ_PLUGIN_ASSETS_FILE', plugins_url( 'inc/assets/', __FILE__ ) );
}

/**
 * Register Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_cdq_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/cdq-canvas.php' );

	$widgets_manager->register( new \Elementor_CdQ_Widget() );

}
add_action( 'elementor/widgets/register', 'register_cdq_widget' );



function cdq_register_dependencies_scripts() {

	/* Scripts */
	wp_register_script( 'cdq-canvas', plugins_url( 'inc/assets/js/cdq-canvas.js', __FILE__ ));
}
add_action( 'wp_enqueue_scripts', 'cdq_register_dependencies_scripts' );


function add_custom_js_to_footer() {
    ?>
    <script type="text/javascript">
        // Initialize the initializationFunctions array
        window.initializationFunctions = [];
    </script>
    <?php
}
add_action('wp_head', 'add_custom_js_to_footer');

