<?php
/**
* Plugin Name: Change Empty Trash Time
* Plugin URI: https://carlosmr.com/plugin/ajustar-borrado-de-papelera/
* Description: This plugin creates a new setting at the end of Settings > General that allows to select the time that WordPress take to empty trash.
* Version: 1.0.4
* Author: Carlos Mart&iacute;nez Romero
* Author URI: https://carlosmr.com
* License: GPL+2
* Text Domain: change-wp-empty-trash-time
* Domain Path: /languages
*/
// Load translations
add_action( 'plugins_loaded', 'cmr_cwett_load_textdomain' );
function cmr_cwett_load_textdomain(){
  load_plugin_textdomain( 'change-wp-empty-trash-time', false, dirname( plugin_basename(__FILE__)).'/languages' );
}
// Starts the plugin
add_action( 'admin_init', 'cmr_cwett_init' );
add_action( 'plugins_loaded', 'cmr_cwett_execute' );
function cmr_cwett_init(){
  // Section record
  register_setting( 'general', 'cmr_cwett_settings', 'cmr_cwett_sanitize_validate_settings' );
  // Adding the fields
  $settings = get_option('cmr_cwett_settings');
  add_settings_field( 'cmr_cwett_field_one', esc_html__('Time to empty trash (in days)', 'change-wp-empty-trash-time'), 'cmr_cwett_fields_callback', 'general', 'default', array(
    'name' => 'cmr_cwett_settings[one]',
    'value' => $settings['one']
  ) );
}
// Checking and validating the fields
function cmr_cwett_sanitize_validate_settings( $input ){
  $output = get_option( 'cmr_cwett_settings' );
  // Sanitizing the number
  $output['one'] = absint( $input['one'] );
  return $output;
}
// Field load
function cmr_cwett_fields_callback( $args ){
  echo '<input type="text" name="'.esc_attr( $args['name'] ).'" value="'.esc_attr( $args['value'] ).'">';
  echo '</br>';
  echo '<p class="description">' . __('You can use the value 0 in order to remove elements directly. Keep in mind that this plugin wont work if the time is already defined elsewhere.', 'change-wp-empty-trash-time' ) . '</p>';
}
function cmr_cwett_execute(){
  // Getting the value
  $settings = get_option( 'cmr_cwett_settings' );
  // Getting first value of the array
  if (isset($settings['one'])){
    if ( !defined( 'EMPTY_TRASH_DAYS' ) ){
      $cmrtrashtime = $settings['one'];
      // Definition of value
      define( 'EMPTY_TRASH_DAYS', $cmrtrashtime );
    }
    else{
    }
  }
}