<?php
/**
* ccBill® Return URL handler ( inner processing routines ).
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* This WordPress® plugin ( s2Member Pro ) is comprised of two parts:
*
* o (1) Its PHP code is licensed under the GPL license, as is WordPress®.
* 	You should have received a copy of the GNU General Public License,
* 	along with this software. In the main directory, see: /licensing/
* 	If not, see: {@link http://www.gnu.org/licenses/}.
*
* o (2) All other parts of ( s2Member Pro ); including, but not limited to:
* 	the CSS code, some JavaScript code, images, and design;
* 	are licensed according to the license purchased.
* 	See: {@link http://www.s2member.com/prices/}
*
* Unless you have our prior written consent, you must NOT directly or indirectly license,
* sub-license, sell, resell, or provide for free; part (2) of the s2Member Pro Module;
* or make an offer to do any of these things. All of these things are strictly
* prohibited with part (2) of the s2Member Pro Module.
*
* Your purchase of s2Member Pro includes free lifetime upgrades via s2Member.com
* ( i.e. new features, bug fixes, updates, improvements ); along with full access
* to our video tutorial library: {@link http://www.s2member.com/videos/}
*
* @package s2Member\ccBill
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_pro_ccbill_return_in"))
	{
		/**
		* ccBill® Return URL handler ( inner processing routines ).
		*
		* @package s2Member\ccBill
		* @since 1.5
		*/
		class c_ws_plugin__s2member_pro_ccbill_return_in
			{
				/**
				* Handles ccBill® Return URL processing.
				*
				* @package s2Member\ccBill
				* @since 1.5
				*
				* @attaches-to ``add_action("init");``
				*
				* @return null Or exits script execution after redirection.
				*/
				public static function ccbill_return ()
					{
						global $current_site, $current_blog; /* For Multisite support. */
						/**/
						if (!empty ($_GET["s2member_pro_ccbill_return"]) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_client_id"])
							{
								$ccbill["s2member_log"][] = "Return URL processed on: " . date ("D M j, Y g:i:s a T");
								$ccbill["s2member_log"][] = "Piping through s2Member's core/standard PayPal® processor with `proxy_use` ( `ty-email` ).";
								$ccbill["s2member_log"][] = "Please check PayPal® RTN logs for further processing details.";
								/**/
								$rtn_q = "&s2member_paypal_proxy=ccbill&s2member_paypal_proxy_use=standard-emails,ty-email";
								$rtn_q .= "&s2member_paypal_proxy_verification=" . urlencode (c_ws_plugin__s2member_paypal_utilities::paypal_proxy_key_gen ());
								/**/
								if (!empty ($_GET["s2member_pro_ccbill_return_success"]))
									$rtn_q .= "&s2member_paypal_return_success=" . rawurlencode (trim (stripslashes ($_GET["s2member_pro_ccbill_return_success"])));
								/**/
								$ccbill["s2member_log"][] = site_url ("/?s2member_pro_ccbill_return&s2member_paypal_return=1" . $rtn_q);
								/**/
								wp_redirect (site_url ("/?s2member_pro_ccbill_return&s2member_paypal_return=1" . $rtn_q));
								/*
								If debugging/logging is enabled; we need to append $ccbill to the log file.
									Logging now supports Multisite Networking as well.
								*/
								$logv = c_ws_plugin__s2member_utilities::ver_details ();
								$logm = c_ws_plugin__s2member_utilities::mem_details ();
								$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
								$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
								$log2 = (is_multisite () && !is_main_site ()) ? "ccbill-rtn-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "ccbill-rtn.log";
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
									if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
										if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
											file_put_contents ($logs_dir . "/" . $log2, $logv . "\n" . $logm . "\n" . $log4 . "\n" . var_export ($ccbill, true) . "\n\n", FILE_APPEND);
								/**/
								exit (); /* Exit now. */
							}
					}
			}
	}
?>