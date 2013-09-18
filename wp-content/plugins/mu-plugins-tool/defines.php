<?php
/*
Valid choices for MPT_MENU_PARENT (case NOT sensitive):
 - admin      // display in the main admin side-menu
 - settings   // display as a submenu of
 - dashboard  // display as a submenu of
 - posts      // display as a submenu of
 - media      // display as a submenu of
 - pages      // display as a submenu of
 - comments   // display as a submenu of
 - appearance // display as a submenu of
 - plugins    // display as a submenu of
 - users      // display as a submenu of
 - tools      // display as a submenu of
 - none       // not shown in any menu
 
Anything else will be treated the same as 'none'
*/

define('MPT_MENU_PARENT', 'plugins');
define('MPT_MENU_NAME', 'MU Plugins Tool'); // name to show in menu
define('MPT_TITLE', 'MU Plugins Tool'); // name to show in browser tab
define('MPT_LINK_NAME', 'Manage'); // options link name to show in Admin|Plugins
define('MPT_MY_URL', plugins_url('/', __FILE__)); // url (minus filename) of this plugin
define('MPT_MENU_SLUG', basename(MPT_MY_URL)); // menu needs a unique identifier, this plugin's folder name will do just fine

define('MPT_STYLE_HANDLE', 'mpt_style'); // style to inject; needs unique identifier
define('MPT_STYLE_URL', MPT_MY_URL . 'style.css'); // full url of stylesheet to inject
define('MPT_JS_HANDLE', 'mpt_js'); // javascript to inject; needs unique identifier
define('MPT_JS_URL', MPT_MY_URL . 'script.js'); // full url of javascript to inject

define('MPT_MUP_DIR', WPMU_PLUGIN_DIR . '/');
define('MPT_STARTER_PLUGIN', 'admin_footer_quote.php');