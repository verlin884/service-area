<?php

/**
 * Service Area
 *
 * Plugin Name: Service Area
 * Description : This plugin only for assessment
 * Version:     1.6.2
 * Author:      Lino Verlin
 * Author URI:  https://github.com/verlin884
 */

if (!defined('ABSPATH')) {
	die('Invalid request.');
}

if (!class_exists('ServiceArea')) {
	class ServiceArea
	{
		public function __construct()
		{
			define("PLUGIN_PATH", plugin_dir_path(__FILE__));
			define("PLUGIN_URL_ASSETS", plugin_dir_url(__FILE__) . 'includes/assets/');
			require_once(PLUGIN_PATH . '/vendor/autoload.php');
		}

		public function initialize()
		{
			include_once PLUGIN_PATH . "includes/utilities.php";
			include_once PLUGIN_PATH . "includes/option-page.php";
			include_once PLUGIN_PATH . "includes/service-page.php";
		}
	}

	$contactPlugin = new ServiceArea;
	$contactPlugin->initialize();
}
