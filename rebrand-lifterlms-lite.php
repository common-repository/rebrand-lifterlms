<?php
/**
 * Plugin Name: 	Rebrand LifterLMS 
 * Plugin URI: 	    https://rebrandpress.com/rebrand-lifterlms/
 * Description: 	LifterLMS is a Learning Management Plugin that helps you create and sell courses online without coding. With Rebrand LifterLMS, you can white label the plugin to change the name and description, while linking it to your own website instead of the developer’s. It also allows you to choose your own primary color for buttons and links, and add your own logo.
 * Version:     	1.0
 * Author:      	RebrandPress
 * Author URI:  	https://rebrandpress.com/
 * License:     	GPL2 etc
 * Network:         Active
*/

if (!defined('ABSPATH')) { exit; }

if ( !class_exists('Rebrand_LifterLMS_Pro') ) {
	
	class Rebrand_LifterLMS_Pro {
		
		public function bzlms_load()
		{
			global $bzlms_load;
			load_plugin_textdomain( 'bzlms', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

			if ( !isset($bzlms_load) )
			{
			  require_once(__DIR__ . '/lms-settings.php');
			  $PluginLMS = new BZ_LMS\BZRebrandLifterLMSSettings;
			  $PluginLMS->init();
			}
			return $bzlms_load;
		}
		
	}
}
$PluginRebrandLifterLMS = new Rebrand_LifterLMS_Pro;
$PluginRebrandLifterLMS->bzlms_load();
