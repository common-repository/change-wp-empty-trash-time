<?php 
// Check we are using uninstall.php
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ):
  exit();
endif;
// Remove options and settings
delete_option( 'cmr_cwett_settings' );