<?php
// File: rest-api.php

// Function to register our new routes from the controller.
function rankmath_register_sales_data_routes() {
  // Register the /sales-data route within the /rankmath/v1 namespace.
  register_rest_route('rankmath/v1', '/sales-data', array(
    // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
    'methods'  => WP_REST_Server::READABLE,
    // Here we register our callback. The callback is fired when this route is matched by the WP_REST_Server class.
    'callback' => 'rankmath_get_sales_data',
  ));
}

add_action('rest_api_init', 'rankmath_register_sales_data_routes');

// Callback function for the /sales-data route.
function rankmath_get_sales_data($request) {
  // Check if a timeframe is set in the request and sanitize it.
  $timeframe = isset($request['timeframe']) ? sanitize_text_field($request['timeframe']) : '7';

  // Generate dummy data for the last 30 days.
  $dummy_data = array();
  for ($i = 0; $i < 30; $i++) {
    $dummy_data[] = array(
      'date' => date('Y-m-d', strtotime('-'. $i .' days')),
      'sales' => rand(100, 500), // Random sales data between 100 and 500
    );
  }

  // If a timeframe is specified, filter the data accordingly.
  if ($timeframe !== '') {
    $filtered_data = array_slice($dummy_data, 0, intval($timeframe));
  } else {
    $filtered_data = $dummy_data;
  }

  // Return the filtered data as a REST response.
  return new WP_REST_Response($filtered_data, 200);
}
