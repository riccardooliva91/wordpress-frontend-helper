<?php
/**
 * Plugin Name: WP Frontend Helper
 * Description: A set of handful tools to ease your life as a frontend WP developer.
 * Author: Riccardo Oliva
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
defined( 'WPFH_VERSION' ) || define( 'WPFH_VERSION', 1.1 );

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Validates config and instantiates objects
 *
 * @param string $option_name
 * @param string $option_value
 * @param string $expected_namespace
 * @param array $constructor_args
 *
 * @return mixed
 * @throws \Wpfh\Exceptions\InvalidConfiguration
 */
function _wpfh_instantiate_object( string $option_name, string $option_value, string $expected_namespace, array $constructor_args ) {
	if ( empty( $option_value ) ) {
		throw new \Wpfh\Exceptions\InvalidConfiguration( sprintf( 'The %s option should be a class name/namespace, got empty string.', $option_name ) );
	}

	try {
		$object = $option_value::init( ...$constructor_args );
	} catch ( \Exception $e ) {
		throw new \Wpfh\Exceptions\InvalidConfiguration( sprintf( 'Could not instantiate class %s.', $option_value ) );
	}

	if ( ! $object instanceof $expected_namespace ) {
		throw new \Wpfh\Exceptions\InvalidConfiguration( sprintf( '%s should be an extension of %s.', get_class( $object ), $expected_namespace ) );
	}

	return $object;
}

/**
 * Inits the plugin options
 */
add_action( 'plugins_loaded', function () {
	\Wpfh\WpfhConfig::init();
	$options = \Wpfh\WpfhOptions::init();

	// Update media options if needed
	$media_options = $options->get( 'media' );
	if ( $media_options['enable_version'] && ( empty( $media_options['tag'] ) || $media_options['auto_bust_threshold'] < time() + $media_options['auto_bust_interval'] ) ) {
		$media_options['tag']                 = uniqid();
		$media_options['auto_bust_threshold'] = time();
		$options->set( 'media', $media_options, true );
	}
} );

/**
 * Inits the plugin classes
 */
add_action( \Wpfh\WpfhConfig::init()->get( 'wpfh_init_hook' ), function () {
	$config = \Wpfh\WpfhConfig::init();

	$assets_observer = $config->get( 'wpfh_assets_observer_class' );
	$assets_manager  = $config->get( 'wpfh_assets_manager_class' );
	$media_tag       = $config->get( 'wpfh_media_tag_class' );
	$media_printer   = $config->get( 'wpfh_media_printer_class' );
	$helper          = $config->get( 'wpfh_helper_class' );

	$assets_observer_object = _wpfh_instantiate_object( 'wpfh_assets_observer_class', $assets_observer, \Wpfh\Assets\AssetObserver::class, [] );
	$assets_manager_object  = _wpfh_instantiate_object( 'wpfh_assets_manager_class', $assets_manager, \Wpfh\Assets\AssetsManager::class, [ $assets_observer_object ] );
	$media_tag_object       = _wpfh_instantiate_object( 'wpfh_media_tag_class', $media_tag, \Wpfh\Media\MediaTag::class, [] );
	$media_printer_object   = _wpfh_instantiate_object( 'wpfh_media_printer_class', $media_printer, \Wpfh\Media\MediaPrinter::class, [ $media_tag_object ] );

	$helper_object = _wpfh_instantiate_object( 'wpfh_helper_class', $helper, \Wpfh\Wpfh::class, [] );
	$helper_object->set_assets_manager( $assets_manager_object );
	$helper_object->set_media_printer( $media_printer_object );
} );