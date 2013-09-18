<?php
/*
 * Plugin Name: MU Plugins Tool
 * Plugin URI: http://akted.com/plugin/mu-plugins-tool
 * Description: Activate or deactivate any MU (must-use) plugins that are installed - on an individual basis or all at once.
 * Version: 0.2.0
 * Author: Ted Rader
 * Author URI: http://akted.com
 * License: GPLv2 or later (see license.txt)
 *
 */

require('defines.php');
require('functions.php');

// function to execute when plugin is deactivated (RESERVED FOR FUTURE INCLUSION)
//register_deactivation_hook(__FILE__, 'mpt_deactivate');

// function to execute when plugin is uninstalled (RESERVED FOR FUTURE INCLUSION)
//register_uninstall_hook(__FILE__, 'mpt_uninstall');

// function to execute when plugin is activated
register_activation_hook(__FILE__, 'mpt_activate');
		
// function to run whenever in admin area
add_action('admin_init', 'mpt_init');

// create a link in Admin|Plugins, e.g., "Manage" or "Options"
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'mpt_plugin_action_link');

// create the menu item
add_action('admin_menu', 'mpt_create_menu');



// draw the options page
function mpt_render_options() {

	$plugins = mpt_get_plugins();
	
	include('page.php');
	
} // function mpt_render_options()


