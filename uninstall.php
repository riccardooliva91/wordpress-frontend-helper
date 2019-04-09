<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

$options = \Wpfh\WpfhOptions::init()->get_group_name();

delete_option( $options );