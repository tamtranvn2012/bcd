<?php

define('MPT_PARENT_SLUG', mpt_get_parent_slug());

function mpt_activate() {
/* CALLBACK for register_activation_hook(__FILE__, 'mpt_activate')
 *
 * create mu-plugins folder if needed and copy a starter mu-plugin there
 *
 */
	mpt_add_starter();

} // function mpt_activate()



function mpt_deactivate() { // not currently used
/* CALLBACK for register_deactivation_hook(__FILE__, 'mpt_deactivate')
 *
 * reserved for future use
 *
 */
} // function mpt_deactivate()



function mpt_uninstall() { // nct currently used
/* CALLBACK for register_uninstall_hook(__FILE__, 'mpt_uninstall')
 *
 * reserved for future use
 *
 */
} // function mpt_uninstall()



function mpt_init() { // stuff to do before the page renders
/* CALLBACK for add_action('admin_init', 'mpt_init')
 *
 * activate/deactivate plugins as necessary IF my form submitted;
 * register stylesheet/javascript for injection on options page
 * register the form for sanitization
 *
 */
	// stuff to run only if my form submitted
	if (isset($_POST['option_page']) && $_POST['option_page'] == 'mpt_options') {
		mpt_update_plugins(mpt_get_plugins());
	}

	global $mpt_menu_page;
	
	// register stylesheet and javascript with WP
	wp_register_style(MPT_STYLE_HANDLE, MPT_STYLE_URL);
	wp_register_script(MPT_JS_HANDLE, MPT_JS_URL);

	// register the form with WP - used with settings_fields in form
	register_setting( 'mpt_options', 'mpt_options', 'mpt_sanitize' );

	// this injects stylesheet & js into <head> when my options page opens
	add_action('admin_print_styles-' . $mpt_menu_page, 'mpt_inject_styles');
	add_action('admin_print_scripts-' . $mpt_menu_page, 'mpt_inject_scripts');
    
} // function mpt_init()



function mpt_sanitize($input) { // not sanitizing yet!
/* CALLBACK for register_setting( 'mpt_options', 'mpt_options', 'mpt_sanitize' );
 *
 * this is where I need to put the form submission sanitizing code
 *
 */
	return $input;
	
} // function mpt_sanitize($input)



function mpt_create_menu () {
/* CALLBACK for add_action('admin_menu', 'mpt_create_menu')
 *
 * creates the menu (or submenu) item and creates hooks for injecting
 * style and javascript code into the <head> whenver my options page loads
 *
 */
	global $mpt_menu_page;
	
    if (strtolower(MPT_MENU_PARENT) == 'admin') {
        $mpt_menu_page = add_menu_page(
            MPT_TITLE,
            MPT_MENU_NAME,
            'administrator',
            MPT_MENU_SLUG,
            'mpt_render_options'
        );
    } else {
        $mpt_menu_page = add_submenu_page(
            MPT_PARENT_SLUG,
            MPT_TITLE,
            MPT_MENU_NAME,
            'administrator',
            MPT_MENU_SLUG,
            'mpt_render_options'
        );
    }

} // function mpt_create_menu



function mpt_inject_styles() {
// inject stylesheet into <head> if displaying my 'options' page)
    wp_enqueue_style(MPT_STYLE_HANDLE);	
}



function mpt_inject_scripts() {
// inject javascript into <head> if displaying my 'options' page)
    wp_enqueue_script(MPT_JS_HANDLE);
}



function mpt_add_starter() {
// Create mu-plugins directory and starter mu plugin, if necessary

	if ( ! is_dir(MPT_MUP_DIR)) mkdir(MPT_MUP_DIR);
	
 	$copy_from = __DIR__ . '/' . MPT_STARTER_PLUGIN . '.OFF';
	$copy_to = MPT_MUP_DIR . MPT_STARTER_PLUGIN;
	if ( ! file_exists($copy_to) && ! file_exists($copy_to . '.OFF')) {
		copy($copy_from, $copy_to . '.OFF');
	}
	
} // function mpt_add_starter()



function mpt_get_parent_slug() {
    
    $parent = strtolower(MPT_MENU_PARENT);
    switch ($parent) {
        case 'settings':
            $parent_slug = 'options-general.php';
            break;
        case 'admin':
            $parent_slug = 'admin.php';
            break;
        case 'dashboard':
            $parent_slug = 'index.php';
            break;
        case 'posts':
            $parent_slug = 'edit.php';
            break;
        case 'media':
            $parent_slug = 'upload.php';
            break;
        case 'pages':
            $parent_slug = 'edit.php?post_type=page';
            break;
        case 'comments':
            $parent_slug = 'edit-comments.php';
            break;
        case 'appearance':
            $parent_slug = 'themes.php';
            break;
        case 'plugins':
            $parent_slug = 'plugins.php';
            break;
        case 'users':
            $parent_slug = 'users.php';
            break;
        case 'tools':
            $parent_slug = 'tools.php';
            break;
		case 'none':
        default:
            $parent_slug = NULL;
    } // switch (MPT_MENU_PARENT)
	
    return $parent_slug;
    
} // function mpt_get_parent_slug()



function mpt_plugin_action_link($links) {
/*CALLBACK for add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'mpt_plugin_action_link')
 *
 * adds MPT_LINK_NAME link, e.g., Manage or Options, to the Plugins main page (plugins.php);
 *
 */
    $my_link = '<a href="' . get_admin_url() . MPT_PARENT_SLUG . '?page=' . MPT_MENU_SLUG . '">' . __(MPT_LINK_NAME) . '</a>';
	
    // make my link appear first
    array_unshift($links, $my_link);

    return $links;
    
} // function mpt_plugin_action_link($links)



function mpt_activate_mup($plugin) {
// removes .OFF from a plugin's filename, returns false
// if plugin is already active or does not exist
	
	$file = MPT_MUP_DIR . $plugin . '.php';
	$exists = file_exists($file . '.OFF');
	if ($exists) {
		rename($file . '.OFF', $file);
		return true;
	} else {
		return false;
	}
	
} // function mpt_activate_mup($plugin)



function mpt_deactivate_mup($plugin) {
// appends .OFF to a plugin's filename, returns false
// if plugin is already off or does not exist
	
	$file = MPT_MUP_DIR . $plugin . '.php';
	$exists = file_exists($file);
	if ($exists) {
		rename($file, $file . '.OFF');
		return true;
	} else {
		return false;
	}
	
} // function mpt_deactivate_mup($plugin)



function mpt_is_active($plugin) {
// returns true if plugin is active, returns false if inactive or doesn't exist;
	return file_exists(MPT_MUP_DIR . $plugin . '.php');
}



function mpt_trim($file) {
/* returns the plugin name and whether or not it's currently active, or
 * returns false if the file does not end in .php or .php.off;
 * trims .php (and .off if necessary) from the END of a filename, leaving just
 * the plugin name, e.g., 'my-plugin.php.off' or 'my-plugin.php' becomes 'my-plugin';
 * 'my.php-plugin.php' would become 'my.php-plugin'
 * 'my-plugin.txt' or 'my-plugin.txt.off' is ignored
 * NOTE: this does not make any changes to the actual file
 *
 */	
	$ext = substr($file, -4);
	if (strtolower($ext) == '.off') {
		$is_active = false;
		$file = substr($file, 0, -4);
		$ext = substr($file, -4);
	} else {
		$is_active = true;
	}
	if (strtolower($ext) == '.php') {
		$file = substr($file, 0, -4);
		$output['name'] = $file;
		$output['active_state'] = $is_active;
		return $output;
	} else {
		return false;
	}
	
} // function mpt_trim($plugin)



function mpt_get_plugins() {
// reads all files in the mu-plugins dir, then extracts the plugin name - filename
// minus .php or .php.OFF

	$all_on = true;
	
	$files = scandir(MPT_MUP_DIR);
	$plugins = array();
	foreach ($files as $file) {
		if ($file != '.' && $file != '..') { // skip dirs '.' & '..'
			$trimmed = mpt_trim($file);
			if ($trimmed) { // only push to $plugins if it's a .php file
				$plugins[$trimmed['name']] = $trimmed['active_state'];
				if ( ! $trimmed['active_state']) $all_on = false;
			}
		}
	}
	
	// define for the "Check All" checkbox
	if ( ! defined('MPT_ALL_PLUGINS_ACTIVE')) define('MPT_ALL_PLUGINS_ACTIVE', $all_on);
	return $plugins;

} // function mpt_get_plugins()



function mpt_update_plugins($plugins) {
// activate or deactivate plugins as necessary
	$changed = false;
	foreach ($plugins as $plugin => $is_active) {
		$option_active = isset($_POST['mpt_options'][$plugin]);
		if (($option_active && ! $is_active) || ( ! $option_active && $is_active)) {
			$changed = true;
			$is_active ? mpt_deactivate_mup($plugin) : mpt_activate_mup($plugin);
		}
	}
	if ($changed) { // refresh page to show updated plugin states
		header('Location: ' . MPT_PARENT_SLUG . '?page=' . MPT_MENU_SLUG);
	}

} // function mpt_update_plugins()



