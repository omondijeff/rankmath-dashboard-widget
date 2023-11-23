<?php
/*
Plugin Name: RankMath Widget
Description: Custom dashboard widget for Rankmath to display sales data.
Version: 1.0.0
Author: Jeff
Author URI: https://jeff.tajilabs.io/
*/

// Include the REST API file from the 'includes' directory
require_once plugin_dir_path(__FILE__) . 'includes/rest-api.php';

// Enqueue the React app script only on the Dashboard
function rankmath_enqueue_dashboard_script() {
    // Get the current screen to restrict the script to the dashboard
    $screen = get_current_screen();
    if ( $screen->base == 'dashboard' ) {
        wp_enqueue_script(
            'rankmath-dashboard-app', 
            plugins_url('/app/dist/app.bundle.js', __FILE__), 
            array('wp-element'), // Dependency on WordPress's version of React
            '1.0.0', 
            true
        );
    }
}
add_action('admin_enqueue_scripts', 'rankmath_enqueue_dashboard_script');

// Register the dashboard widget
function rankmath_add_dashboard_widget() {
    wp_add_dashboard_widget(
        'rankmath_dashboard_widget', // Widget slug
        'rankmath Sales Data', // Title of the widget
        'rankmath_dashboard_widget_render' // Function to display the widget content
    );
}
add_action('wp_dashboard_setup', 'rankmath_add_dashboard_widget');

// Render the dashboard widget
function rankmath_dashboard_widget_render() {
    // This is where our React app will attach
    echo '<div id="rankmath-dashboard-app"></div>';
}

?>
