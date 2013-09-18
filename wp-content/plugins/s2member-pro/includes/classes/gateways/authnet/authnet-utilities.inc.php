<?php
/**
* Authorize.Net® utilities.
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
* @package s2Member\AuthNet
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_pro_authnet_utilities"))
	{
		/**
		* Authorize.Net® utilities.
		*
		* @package s2Member\AuthNet
		* @since 1.5
		*/
		class c_ws_plugin__s2member_pro_authnet_utilities
			{
				/**
				* Calls upon Authorize.Net® AIM, and returns the response.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param array $post_vars An array of variables to send through the Authorize.Net® API call.
				* @return array An array of variables returned from the API call.
				*
				* @todo Continue optimizing this routine with ``empty()`` and ``isset()``.
				*/
				public static function authnet_aim_response ($post_vars = FALSE)
					{
						global $current_site, $current_blog; /* For Multisite support. */
						/**/
						$url = "https://" . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_authnet_sandbox"]) ? "test.authorize.net" : "secure.authorize.net") . "/gateway/transact.dll";
						/**/
						$post_vars = (is_array ($post_vars)) ? $post_vars : array (); /* Must be in array format. */
						/**/
						$post_vars["x_version"] = "3.1"; /* Configure the Authorize.Net® transaction version. */
						$post_vars["x_login"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_authnet_api_login_id"];
						$post_vars["x_tran_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_authnet_api_trans_key"];
						/**/
						$post_vars["x_delim_data"] = "true"; /* Yes, return a delimited string. */
						$post_vars["x_delim_char"] = ","; /* Fields delimitation character. */
						$post_vars["x_encap_char"] = '"'; /* Field encapsulation character. */
						/**/
						$post_vars["x_invoice_num"] = (!empty ($post_vars["x_invoice_num"])) ? substr ($post_vars["x_invoice_num"], 0, 20) : "";
						$post_vars["x_description"] = (!empty ($post_vars["x_description"])) ? substr ($post_vars["x_description"], 0, 255) : "";
						$post_vars["x_description"] = c_ws_plugin__s2member_utils_strings::keyboard_chars_only ($post_vars["x_description"]);
						/**/
						$input_time = date ("D M j, Y g:i:s a T"); /* Record input time for logging. */
						/**/
						$csv = trim (c_ws_plugin__s2member_utils_urls::remote ($url, $post_vars, array ("timeout" => 20)));
						/**/
						$output_time = date ("D M j, Y g:i:s a T"); /* Now record after output time. */
						/**/
						$response = ($csv) ? c_ws_plugin__s2member_utils_strings::trim_dq_deep (preg_split ("/\",\"/", $csv)) : array ();
						$response = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($response));
						/**/
						foreach (array ("response_code", "response_subcode", "response_reason_code", "response_reason_text", "authorization_code", "avs_response", "transaction_id", "invoice_number", "description", "amount", "method", "transaction_type", "customer_id", "first_name", "last_name", "company", "address", "city", "state", "zipcode", "country", "phone", "fax", "email", "ship_to_first_name", "ship_to_last_name", "ship_to_company", "ship_to_address", "ship_to_city", "ship_to_state", "ship_to_zipcode", "ship_to_country", "tax", "duty", "freight", "tax_exempt", "po_number", "md5_hash", "card_code_response", "cavv_response", "card_number", "card_type", "split_tender_id", "requested_amount", "balance_on_card") as $order => $field_name)
							$response[$field_name] = (isset ($response[$order])) ? $response[$order] : null;
						/**/
						if (empty ($response["response_code"]) || $response["response_code"] !== "1") /* A value of 1 indicates success. */
							{
								if (strlen ($response["response_reason_code"]) || $response["response_reason_text"]) /* Did we at least get an error msg? */
									$response["__error"] = "Error# " . $response["response_reason_code"] . ". " . rtrim ($response["response_reason_text"], ".") . ".";
								/**/
								else /* Else, generate an error messsage - so something is reported back to the Customer. */
									$response["__error"] = "Error. Please contact Support for assistance.";
							}
						/*
						If debugging is enabled; we need to maintain a comprehensive log file.
							Logging now supports Multisite Networking as well.
						*/
						$logv = c_ws_plugin__s2member_utilities::ver_details ();
						$logm = c_ws_plugin__s2member_utilities::mem_details ();
						$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
						$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
						$log2 = (is_multisite () && !is_main_site ()) ? "authnet-api-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "authnet-api.log";
						/**/
						if (strlen ($post_vars["x_card_num"]) > 4) /* Only log last 4 digits for security. */
							$post_vars["x_card_num"] = str_repeat ("*", strlen ($post_vars["x_card_num"]) - 4)/**/
							. substr ($post_vars["x_card_num"], -4); /* Then display last 4 digits. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
							if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
								if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
									if (($log = "-------- Input vars: ( " . $input_time . " ) --------\n" . var_export ($post_vars, true) . "\n"))
										if (($log .= "-------- Output string/vars: ( " . $output_time . " ) --------\n" . $csv . "\n" . var_export ($response, true)))
											file_put_contents ($logs_dir . "/" . $log2, $logv . "\n" . $logm . "\n" . $log4 . "\n" . $log . "\n\n", FILE_APPEND);
						/**/
						return apply_filters ("ws_plugin__s2member_pro_authnet_aim_response", c_ws_plugin__s2member_pro_authnet_utilities::_authnet_aim_response_filters ($response), get_defined_vars ());
					}
				/**
				* A sort of callback function that Filters Authorize.Net® AIM responses.
				*
				* Provides alternative explanations in some cases that require special attention.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param array $response An array of response variables.
				* @return array An array of response variables; possibly modified by this routine.
				*/
				public static function _authnet_aim_response_filters ($response = FALSE)
					{
						return $response; /* Nothing here yet. */
					}
				/**
				* Calls upon Authorize.Net® ARB, and returns the response.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param array $post_vars An array of variables to send through the Authorize.Net® API call.
				* @return array An array of variables returned from the API call.
				*
				* @todo Continue optimizing this routine with ``empty()`` and ``isset()``.
				*/
				public static function authnet_arb_response ($post_vars = FALSE)
					{
						global $current_site, $current_blog; /* For Multisite support. */
						/**/
						$url = "https://" . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_authnet_sandbox"]) ? "apitest.authorize.net" : "api.authorize.net") . "/xml/v1/request.api";
						/**/
						$post_vars = (is_array ($post_vars)) ? $post_vars : array (); /* Must be in array format. */
						/**/
						$post_vars["x_login"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_authnet_api_login_id"];
						$post_vars["x_tran_key"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_authnet_api_trans_key"];
						/**/
						$post_vars["x_invoice_num"] = (!empty ($post_vars["x_invoice_num"])) ? substr ($post_vars["x_invoice_num"], 0, 20) : "";
						$post_vars["x_description"] = (!empty ($post_vars["x_description"])) ? substr ($post_vars["x_description"], 0, 255) : "";
						$post_vars["x_description"] = c_ws_plugin__s2member_utils_strings::keyboard_chars_only ($post_vars["x_description"]);
						/**/
						$trial = (!empty ($post_vars["x_trial_occurrences"])) ? true : false; /* Indicates existence of trial. */
						/**/
						if (!empty ($post_vars["x_method"]) && $post_vars["x_method"] === "create")
							{
								$xml = '<?xml version="1.0" encoding="utf-8"?>';
								/**/
								$xml .= '<ARBCreateSubscriptionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">';
								/**/
								$xml .= '<merchantAuthentication>';
								$xml .= '<name>' . esc_html ($post_vars["x_login"]) . '</name>';
								$xml .= '<transactionKey>' . esc_html ($post_vars["x_tran_key"]) . '</transactionKey>';
								$xml .= '</merchantAuthentication>';
								/**/
								$xml .= '<refId>' . esc_html ($post_vars["x_invoice_num"]) . '</refId>';
								/**/
								$xml .= '<subscription>';
								/**/
								$xml .= '<name>' . esc_html ($_SERVER["HTTP_HOST"]) . '</name>';
								/**/
								$xml .= '<paymentSchedule>';
								$xml .= '<interval>';
								$xml .= '<length>' . esc_html ($post_vars["x_length"]) . '</length>';
								$xml .= '<unit>' . esc_html ($post_vars["x_unit"]) . '</unit>';
								$xml .= '</interval>';
								$xml .= '<startDate>' . esc_html ($post_vars["x_start_date"]) . '</startDate>';
								$xml .= '<totalOccurrences>' . esc_html ($post_vars["x_total_occurrences"]) . '</totalOccurrences>';
								$xml .= ($trial) ? '<trialOccurrences>' . esc_html ($post_vars["x_trial_occurrences"]) . '</trialOccurrences>' : '';
								$xml .= '</paymentSchedule>';
								/**/
								$xml .= '<amount>' . esc_html ($post_vars["x_amount"]) . '</amount>';
								$xml .= ($trial) ? '<trialAmount>' . esc_html ($post_vars["x_trial_amount"]) . '</trialAmount>' : '';
								/**/
								$xml .= '<payment>';
								$xml .= '<creditCard>';
								$xml .= '<cardNumber>' . esc_html ($post_vars["x_card_num"]) . '</cardNumber>';
								$xml .= '<expirationDate>' . esc_html ($post_vars["x_exp_date"]) . '</expirationDate>';
								$xml .= '<cardCode>' . esc_html ($post_vars["x_card_code"]) . '</cardCode>';
								$xml .= '</creditCard>';
								$xml .= '</payment>';
								/**/
								$xml .= '<order>';
								$xml .= '<invoiceNumber>' . esc_html ($post_vars["x_invoice_num"]) . '</invoiceNumber>';
								$xml .= '<description>' . esc_html ($post_vars["x_description"]) . '</description>';
								$xml .= '</order>';
								/**/
								$xml .= '<customer>';
								$xml .= '<email>' . esc_html ($post_vars["x_email"]) . '</email>';
								$xml .= '</customer>';
								/**/
								$xml .= '<billTo>';
								$xml .= '<firstName>' . esc_html ($post_vars["x_first_name"]) . '</firstName>';
								$xml .= '<lastName>' . esc_html ($post_vars["x_last_name"]) . '</lastName>';
								$xml .= '<address>' . esc_html ($post_vars["x_address"]) . '</address>';
								$xml .= '<city>' . esc_html ($post_vars["x_city"]) . '</city>';
								$xml .= '<state>' . esc_html ($post_vars["x_state"]) . '</state>';
								$xml .= '<zip>' . esc_html ($post_vars["x_zip"]) . '</zip>';
								$xml .= '<country>' . esc_html ($post_vars["x_country"]) . '</country>';
								$xml .= '</billTo>';
								/**/
								$xml .= '</subscription>';
								/**/
								$xml .= '</ARBCreateSubscriptionRequest>';
							}
						/**/
						else if (!empty ($post_vars["x_method"]) && $post_vars["x_method"] === "update")
							{
								$xml = '<?xml version="1.0" encoding="utf-8"?>';
								/**/
								$xml .= '<ARBUpdateSubscriptionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">';
								/**/
								$xml .= '<merchantAuthentication>';
								$xml .= '<name>' . esc_html ($post_vars["x_login"]) . '</name>';
								$xml .= '<transactionKey>' . esc_html ($post_vars["x_tran_key"]) . '</transactionKey>';
								$xml .= '</merchantAuthentication>';
								/**/
								$xml .= '<subscriptionId>' . esc_html ($post_vars["x_subscription_id"]) . '</subscriptionId>';
								/**/
								$xml .= '<subscription>';
								/**/
								$xml .= '<payment>';
								$xml .= '<creditCard>';
								$xml .= '<cardNumber>' . esc_html ($post_vars["x_card_num"]) . '</cardNumber>';
								$xml .= '<expirationDate>' . esc_html ($post_vars["x_exp_date"]) . '</expirationDate>';
								$xml .= '<cardCode>' . esc_html ($post_vars["x_card_code"]) . '</cardCode>';
								$xml .= '</creditCard>';
								$xml .= '</payment>';
								/**/
								$xml .= '<customer>';
								$xml .= '<email>' . esc_html ($post_vars["x_email"]) . '</email>';
								$xml .= '</customer>';
								/**/
								$xml .= '<billTo>';
								$xml .= '<firstName>' . esc_html ($post_vars["x_first_name"]) . '</firstName>';
								$xml .= '<lastName>' . esc_html ($post_vars["x_last_name"]) . '</lastName>';
								$xml .= '<address>' . esc_html ($post_vars["x_address"]) . '</address>';
								$xml .= '<city>' . esc_html ($post_vars["x_city"]) . '</city>';
								$xml .= '<state>' . esc_html ($post_vars["x_state"]) . '</state>';
								$xml .= '<zip>' . esc_html ($post_vars["x_zip"]) . '</zip>';
								$xml .= '<country>' . esc_html ($post_vars["x_country"]) . '</country>';
								$xml .= '</billTo>';
								/**/
								$xml .= '</subscription>';
								/**/
								$xml .= '</ARBUpdateSubscriptionRequest>';
							}
						/**/
						else if (!empty ($post_vars["x_method"]) && $post_vars["x_method"] === "status")
							{
								$xml = '<?xml version="1.0" encoding="utf-8"?>';
								/**/
								$xml .= '<ARBGetSubscriptionStatusRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">';
								/**/
								$xml .= '<merchantAuthentication>';
								$xml .= '<name>' . esc_html ($post_vars["x_login"]) . '</name>';
								$xml .= '<transactionKey>' . esc_html ($post_vars["x_tran_key"]) . '</transactionKey>';
								$xml .= '</merchantAuthentication>';
								/**/
								$xml .= '<subscriptionId>' . esc_html ($post_vars["x_subscription_id"]) . '</subscriptionId>';
								/**/
								$xml .= '</ARBGetSubscriptionStatusRequest>';
							}
						/**/
						else if (!empty ($post_vars["x_method"]) && $post_vars["x_method"] === "cancel")
							{
								$xml = '<?xml version="1.0" encoding="utf-8"?>';
								/**/
								$xml .= '<ARBCancelSubscriptionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">';
								/**/
								$xml .= '<merchantAuthentication>';
								$xml .= '<name>' . esc_html ($post_vars["x_login"]) . '</name>';
								$xml .= '<transactionKey>' . esc_html ($post_vars["x_tran_key"]) . '</transactionKey>';
								$xml .= '</merchantAuthentication>';
								/**/
								$xml .= '<subscriptionId>' . esc_html ($post_vars["x_subscription_id"]) . '</subscriptionId>';
								/**/
								$xml .= '</ARBCancelSubscriptionRequest>';
							}
						/**/
						$req["headers"]["Accept"] = "application/xml; charset=UTF-8";
						$req["headers"]["Content-Type"] = "application/xml; charset=UTF-8";
						/**/
						$input_time = date ("D M j, Y g:i:s a T"); /* Record input time for logging. */
						/**/
						$xml = trim (c_ws_plugin__s2member_utils_urls::remote ($url, $xml, array_merge ($req, array ("timeout" => 20))));
						/**/
						$output_time = date ("D M j, Y g:i:s a T"); /* Now record after output time. */
						/**/
						$response = c_ws_plugin__s2member_pro_authnet_utilities::_authnet_parse_arb_response ($xml);
						/**/
						if (empty ($response["response_code"]) || $response["response_code"] !== "I00001") /* A value of I00001 indicates success. */
							{
								if (strlen ($response["response_reason_code"]) || $response["response_reason_text"]) /* Did we at least get an error msg? */
									$response["__error"] = "Error# " . $response["response_reason_code"] . ". " . rtrim ($response["response_reason_text"], ".") . ".";
								/**/
								else /* Else, generate an error messsage - so something is reported back to the Customer. */
									$response["__error"] = "Error. Please contact Support for assistance.";
							}
						/*
						If debugging is enabled; we need to maintain a comprehensive log file.
							Logging now supports Multisite Networking as well.
						*/
						$logv = c_ws_plugin__s2member_utilities::ver_details ();
						$logm = c_ws_plugin__s2member_utilities::mem_details ();
						$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
						$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
						$log2 = (is_multisite () && !is_main_site ()) ? "authnet-api-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "authnet-api.log";
						/**/
						if (strlen ($post_vars["x_card_num"]) > 4) /* Only log last 4 digits for security. */
							$post_vars["x_card_num"] = str_repeat ("*", strlen ($post_vars["x_card_num"]) - 4)/**/
							. substr ($post_vars["x_card_num"], -4); /* Then display last 4 digits. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
							if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
								if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
									if (($log = "-------- Input vars: ( " . $input_time . " ) --------\n" . var_export ($post_vars, true) . "\n"))
										if (($log .= "-------- Output string/vars: ( " . $output_time . " ) --------\n" . $xml . "\n" . var_export ($response, true)))
											file_put_contents ($logs_dir . "/" . $log2, $logv . "\n" . $logm . "\n" . $log4 . "\n" . $log . "\n\n", FILE_APPEND);
						/**/
						return apply_filters ("ws_plugin__s2member_pro_authnet_arb_response", c_ws_plugin__s2member_pro_authnet_utilities::_authnet_arb_response_filters ($response), get_defined_vars ());
					}
				/**
				* A sort of callback function that parses Authorize.Net® ARB responses.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param str $xml XML markup returned by the ARB call.
				* @return array An array of response variables, parsed by s2Member.
				*/
				public static function _authnet_parse_arb_response ($xml = FALSE)
					{
						if ($xml && preg_match ("/\<(ErrorResponse).*?\>.*?\<code\>(.+?)\<\/code\>.*?\<\/\\1\>/is", $xml, $m))
							{
								$response["response_code"] = $response["response_reason_code"] = $m[2];
								/**/
								if (preg_match ("/\<(ErrorResponse).*?\>.*?\<text\>(.+?)\<\/text\>.*?\<\/\\1\>/is", $xml, $m))
									$response["response_text"] = $response["response_reason_text"] = $m[2];
							}
						else if ($xml && preg_match ("/\<(ARBCreateSubscriptionResponse|ARBUpdateSubscriptionResponse|ARBGetSubscriptionStatusResponse|ARBCancelSubscriptionResponse).*?\>.*?\<code\>(.+?)\<\/code\>.*?\<\/\\1\>/is", $xml, $m))
							{
								$response["response_code"] = $response["response_reason_code"] = $m[2];
								/**/
								if (preg_match ("/\<(ARBCreateSubscriptionResponse|ARBUpdateSubscriptionResponse|ARBGetSubscriptionStatusResponse|ARBCancelSubscriptionResponse).*?\>.*?\<text\>(.+?)\<\/text\>.*?\<\/\\1\>/is", $xml, $m))
									$response["response_text"] = $response["response_reason_text"] = $m[2];
								/**/
								if (preg_match ("/\<(subscriptionId)\>(.+?)\<\/\\1\>/is", $xml, $m))
									$response["subscription_id"] = $m[2]; /* Subscription ID. */
								/**/
								if (preg_match ("/\<(status)\>(.+?)\<\/\\1\>/is", $xml, $m))
									$response["subscription_status"] = $m[2]; /* Status. */
							}
						/**/
						$response = (!empty ($response) && is_array ($response)) ? $response : array ();
						return c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($response));
					}
				/**
				* A sort of callback function that Filters Authorize.Net® ARB responses.
				*
				* Provides alternative explanations in some cases that require special attention.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param array $response An array of response variables.
				* @return array An array of response variables; possibly modified by this routine.
				*/
				public static function _authnet_arb_response_filters ($response = FALSE)
					{
						return $response; /* Nothing here yet. */
					}
				/**
				* Get ``$_POST`` or ``$_REQUEST`` vars from Authorize.Net®.
				*
				* Authorize.Net® returns `x_MD5_Hash` in uppercase format for some reason.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @return array|bool An array of verified ``$_POST`` or ``$_REQUEST`` variables, else false.
				*
				* @todo Continue optimizing this routine with ``empty()`` and ``isset()``.
				* @todo Candidate for the use of ``ifsetor()``?
				* @todo Update to use ``strcasecmp()``.
				*/
				public static function authnet_postvars ()
					{
						if (!empty ($_REQUEST["s2member_pro_authnet_notify"]) && !empty ($_REQUEST["x_MD5_Hash"]))
							{
								$postvars = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_REQUEST));
								/**/
								foreach ($postvars as $var => $value)
									if (preg_match ("/^s2member_/", $var))
										unset ($postvars[$var]);
								/**/
								$aim_digest_vars = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_authnet_api_login_id"] . $postvars["x_trans_id"] . $postvars["x_amount"];
								$arb_digest_vars = $postvars["x_trans_id"] . $postvars["x_amount"];
								/**/
								if (strtolower ($postvars["x_MD5_Hash"]) === md5 ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_authnet_api_salt_key"] . $aim_digest_vars))
									return $postvars;
								/**/
								else if (strtolower ($postvars["x_MD5_Hash"]) === md5 ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_authnet_api_salt_key"] . $arb_digest_vars))
									return $postvars;
								/**/
								else /* Nope. */
									return false;
							}
						else /* Nope. */
							return false;
					}
				/**
				* Adds the `s2p-v` variable onto the end of a custom URL for success.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param str $url A full URL to append the `s2p-v` variable onto.
				* @return str A full URL with the `s2p-v` query string argument as well.
				*/
				public static function authnet_s2p_v_generate ($url = FALSE)
					{
						$query = @parse_url ($url, PHP_URL_QUERY); /* Parse to get the query string. */
						/**/
						$timestamp = strtotime ("now"); /* For time-limited verifications; good for 10 seconds. */
						/**/
						$url = add_query_arg ("s2p-v", urlencode ($timestamp . "-" . md5 (wp_salt () . $timestamp . $query)), $url);
						/**/
						return $url; /* With the `s2p-v` variable. */
					}
				/**
				* Verifies `s2p-v` in a given query string argument; from a custom URL for success.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param str $qs Optional. Defaults to ``$_SERVER["QUERY_STRING"]``.
				* @return bool True if the query string is OK/verified, else false.
				*/
				public static function authnet_s2p_v_query_ok ($qs = FALSE, $ignore_timestamp = FALSE)
					{
						$qs = (!$qs && !empty ($_SERVER["QUERY_STRING"])) ? $_SERVER["QUERY_STRING"] : $qs;
						/**/
						if (preg_match ("/(^|[\?&])s2p-v\=([0-9]+)(-)(.+)$/", $qs, $m))
							{
								$query = preg_replace ("/(^|[\?&])s2p-v\=(.+)$/", "", $qs);
								/**/
								$timestamp = $m[2]; /* The timestamp portion only. */
								$valid_s2p_v = $timestamp . "-" . md5 (wp_salt () . $timestamp . $query);
								$given_s2p_v = $m[2] . $m[3] . $m[4];
								/**/
								if ($ignore_timestamp) /* Ignoring? */
									return ($given_s2p_v === $valid_s2p_v);
								/**/
								else /* Otherwise, it must NOT be older than 10 seconds ago. */
									return ($given_s2p_v === $valid_s2p_v && $timestamp >= strtotime ("-10 seconds"));
							}
						else
							return false;
					}
				/**
				* Calculates start date for a Recurring Payment Profile.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param str $period1 Optional. A "Period Term" combination. Defaults to `0 D`.
				* @param str $period3 Optional. A "Period Term" combination. Defaults to `0 D`.
				* @return int The start time, a Unix timestamp.
				*/
				public static function authnet_start_time ($period1 = FALSE, $period3 = FALSE)
					{
						if (!($p1_time = 0) && ($period1 = trim (strtoupper ($period1))))
							{
								list ($num, $span) = preg_split ("/ /", $period1, 2);
								/**/
								$days = 0; /* Days start at 0. */
								/**/
								if (is_numeric ($num) && !is_numeric ($span))
									{
										$days = ($span === "D") ? 1 : $days;
										$days = ($span === "W") ? 7 : $days;
										$days = ($span === "M") ? 30 : $days;
										$days = ($span === "Y") ? 365 : $days;
									}
								/**/
								$p1_days = (int)$num * (int)$days;
								$p1_time = $p1_days * 86400;
							}
						/**/
						if (!($p3_time = 0) && ($period3 = trim (strtoupper ($period3))))
							{
								list ($num, $span) = preg_split ("/ /", $period3, 2);
								/**/
								$days = 0; /* Days start at 0. */
								/**/
								if (is_numeric ($num) && !is_numeric ($span))
									{
										$days = ($span === "D") ? 1 : $days;
										$days = ($span === "W") ? 7 : $days;
										$days = ($span === "M") ? 30 : $days;
										$days = ($span === "Y") ? 365 : $days;
									}
								/**/
								$p3_days = (int)$num * (int)$days;
								$p3_time = $p3_days * 86400;
							}
						/**/
						$start_time = strtotime ("now") + $p1_time + $p3_time;
						/**/
						$start_time = ($start_time <= 0) ? strtotime ("now") : $start_time;
						/**/
						$start_time = $start_time + 43200; /* + 12 hours. */
						/* This prevents date clashes with Authorize.Net®. */
						/**/
						return $start_time;
					}
				/**
				* Calculates period in days for Authorize.Net® ARB integration.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param int|str $period Optional. A numeric Period that coincides with ``$term``.
				* @param str $term Optional. A Term that coincides with ``$period``.
				* @return int A "Period Term", in days. Defaults to `0`.
				*/
				public static function authnet_per_term_2_days ($period = FALSE, $term = FALSE)
					{
						if (is_numeric ($period) && !is_numeric ($term) && ($term = strtoupper ($term)))
							{
								$days = ($term === "D") ? 1 : $days;
								$days = ($term === "W") ? 7 : $days;
								$days = ($term === "M") ? 30 : $days;
								$days = ($term === "Y") ? 365 : $days;
								/**/
								return (int)$period * (int)$days;
							}
						else
							return 0;
					}
				/**
				* Re-formats credit card expiration dates for Authorize.Net®.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param str $exp Expects a credit card expiration date in `mm/yyyy` format.
				* @return str A credit card expiration date in `yyyy-mm` format for Authorize.Net®.
				*/
				public static function authnet_exp_date ($exp = FALSE)
					{
						list ($mm, $yyyy) = preg_split ("/\//", $exp, 2);
						/**/
						return trim ($yyyy . "-" . $mm, "- \t\n\r\0\x0B");
					}
				/**
				* Parses an Authorize.Net® Silent Post.
				*
				* Parses `s2_reference`, `s2_domain`, `s2_invoice`, `s2_start_time`, `s2_p1`, `s2_p3`, `s2_custom`
				* from an Authorize.Net® Silent Post *( aka: IPN )* response.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param array $array Expects an array of details returned by an Authorize.Net® Silent Post.
				* @return array|bool The same ``$array``, but with additional details filled by this routine; else false.
				*
				* @todo Continue optimizing this routine with ``empty()`` and ``isset()``.
				* @todo Candidate for the use of ``ifsetor()``?
				*/
				public static function authnet_parse_arb_desc ($array = FALSE)
					{
						if (is_array ($array) && !empty ($array["x_description"]) && preg_match ("/\(\((.+?)\)\)/i", $array["x_description"], $m))
							{
								list ($array["s2_reference"], $array["s2_domain"], $array["s2_invoice"]) = preg_split ("/~/", $m[1], 3);
								list ($array["s2_start_time"], $array["s2_p1"], $array["s2_p3"]) = preg_split ("/\:/", $array["s2_reference"], 3);
								/**/
								$array["x_description"] = preg_replace ("/\(\((.+?)\)\)/i", "", $array["x_description"]);
								/**/
								$array["s2_custom"] = (!empty ($array["x_subscription_id"])) ? c_ws_plugin__s2member_utils_users::get_user_custom_with ($array["x_subscription_id"]) : "";
								$array["s2_custom"] = ($array["s2_custom"]) ? $array["s2_custom"] : $array["s2_domain"];
								/**/
								return c_ws_plugin__s2member_utils_strings::trim_deep ($array);
							}
						else /* False. */
							return false;
					}
				/**
				* Determines whether or not Tax may apply.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @return bool True if Tax may apply, else false.
				*/
				public static function authnet_tax_may_apply ()
					{
						if ((float)$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_default_tax"] > 0)
							return true;
						/**/
						else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_tax_rates"])
							return true;
						/**/
						return false;
					}
				/**
				* Handles the return of Tax for Pro Forms, via AJAX; through a JSON object.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @return null Or exits script execution after returning data for AJAX caller.
				*
				* @todo Check the use of ``strip_tags()`` in this routine?
				* @todo Continue optimizing this routine with ``empty()`` and ``isset()``.
				* @todo Candidate for the use of ``ifsetor()``?
				*/
				public static function authnet_ajax_tax ()
					{
						if (!empty ($_POST["ws_plugin__s2member_pro_authnet_ajax_tax"]) && ($nonce = $_POST["ws_plugin__s2member_pro_authnet_ajax_tax"]) && (wp_verify_nonce ($nonce, "ws-plugin--s2member-pro-authnet-ajax-tax") || c_ws_plugin__s2member_utils_encryption::decrypt ($nonce) === "ws-plugin--s2member-pro-authnet-ajax-tax"))
							/* A wp_verify_nonce() won't always work here, because s2member-pro-min.js must be cacheable. The output from wp_create_nonce() would go stale.
									So instead, s2member-pro-min.js should use ``c_ws_plugin__s2member_utils_encryption::encrypt()`` as an alternate form of nonce. */
							{
								if (!empty ($_POST["ws_plugin__s2member_pro_authnet_ajax_tax_vars"]) && is_array ($_p_tax_vars = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST["ws_plugin__s2member_pro_authnet_ajax_tax_vars"]))))
									{
										if (is_array ($attr = (!empty ($_p_tax_vars["attr"])) ? unserialize (c_ws_plugin__s2member_utils_encryption::decrypt ($_p_tax_vars["attr"])) : false))
											{
												$attr = (!empty ($attr["coupon"])) ? c_ws_plugin__s2member_pro_authnet_utilities::authnet_apply_coupon ($attr, $attr["coupon"]) : $attr;
												/**/
												$trial = ($attr["rr"] !== "BN" && $attr["tp"]) ? true : false; /* Is there a trial? */
												$sub_total_today = ($trial) ? $attr["ta"] : $attr["ra"]; /* What is the sub-total today? */
												/**/
												$state = strip_tags ($_p_tax_vars["state"]);
												$country = strip_tags ($_p_tax_vars["country"]);
												$zip = strip_tags ($_p_tax_vars["zip"]);
												$currency = $attr["cc"]; /* Currency. */
												$desc = $attr["desc"]; /* Description. */
												/**/
												header ("Content-Type: text/plain; charset=utf-8");
												/* Trial is `null` in this function call. We only need to return what it costs today.
												However, we do tag on a "trial" element in the array so the ajax routine will know about this. */
												$a = c_ws_plugin__s2member_pro_authnet_utilities::authnet_cost (null, $sub_total_today, $state, $country, $zip, $currency, $desc);
												echo json_encode (array ("trial" => $trial, "sub_total" => $a["sub_total"], "tax" => $a["tax"], "tax_per" => $a["tax_per"], "total" => $a["total"], "cur" => $a["cur"], "cur_symbol" => $a["cur_symbol"], "desc" => $a["desc"]));
											}
									}
								/**/
								exit (); /* Clean exit. */
							}
					}
				/**
				* Handles all cost calculations for Authorize.Net®.
				*
				* Returns an associative array with a possible Percentage Rate, along with the calculated Tax Amount.
				* Tax calculations are based on State/Province, Country, and/or Zip Code.
				* Updated to support multiple data fields in it's return value.
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param int|str $trial_sub_total Optional. A numeric Amount/cost of a possible Initial/Trial being offered.
				* @param int|str $sub_total Optional. A numeric Amount/cost of the purchase and/or Regular Period.
				* @param str $state Optional. The State/Province where the Customer is billed.
				* @param str $country Optional. The Country where the Customer is billed.
				* @param int|str $zip Optional. The Postal/Zip Code where the Customer is billed.
				* @param str $currency Optional. Expects a 3 character Currency Code.
				* @param str $desc Optional. Description of the sale.
				* @return array Array of calculations.
				*
				* @todo Add support for `Zip + 4` syntax?
				*/
				public static function authnet_cost ($trial_sub_total = FALSE, $sub_total = FALSE, $state = FALSE, $country = FALSE, $zip = FALSE, $currency = FALSE, $desc = FALSE)
					{
						$state = strtoupper (c_ws_plugin__s2member_pro_utilities::full_state ($state, ($country = strtoupper ($country))));
						$rates = strtoupper ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_tax_rates"]);
						$default = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_default_tax"];
						/**/
						foreach (array ("trial_sub_total" => $trial_sub_total, "sub_total" => $sub_total) as $this_key => $this_sub_total)
							{
								unset ($_default, $this_tax, $this_tax_per, $this_total, $configured_rates, $configured_rate, $location, $rate, $m);
								/**/
								if (is_numeric ($this_sub_total) && $this_sub_total > 0) /* Must have a valid Sub-Total. */
									{
										if (preg_match ("/%$/", $default)) /* Percentage-based. */
											{
												if (($_default = (float)$default) > 0)
													{
														$this_tax = round (($this_sub_total / 100) * $_default, 2);
														$this_tax_per = $_default . "%";
													}
												else /* Else the Tax is 0.00. */
													{
														$this_tax = 0.00;
														$this_tax_per = $_default . "%";
													}
											}
										else if (($_default = (float)$default) > 0)
											{
												$this_tax = round ($_default, 2);
												$this_tax_per = ""; /* Flat. */
											}
										else /* Else the Tax is 0.00. */
											{
												$this_tax = 0.00; /* No Tax. */
												$this_tax_per = ""; /* Flat rate. */
											}
										/**/
										if (strlen ($country) === 2) /* Must have a valid country. */
											{
												foreach (preg_split ("/[\r\n\t]+/", $rates) as $rate)
													{
														if ($rate = trim ($rate)) /* Do NOT process empty lines. */
															{
																list ($location, $rate) = preg_split ("/\=/", $rate, 2);
																$location = trim ($location);
																$rate = trim ($rate);
																/**/
																if ($location === $country)
																	$configured_rates[1] = $rate;
																/**/
																else if ($state && $location === $state . "/" . $country)
																	$configured_rates[2] = $rate;
																/**/
																else if ($state && preg_match ("/^([A-Z]{2})\/(" . preg_quote ($country, "/") . ")$/", $location, $m) && strtoupper (c_ws_plugin__s2member_pro_utilities::full_state ($m[1], $m[2])) . "/" . $m[2] === $state . "/" . $country)
																	$configured_rates[2] = $rate;
																/**/
																else if ($zip && preg_match ("/^([0-9]+)-([0-9]+)\/(" . preg_quote ($country, "/") . ")$/", $location, $m) && $zip >= $m[1] && $zip <= $m[2] && $country === $m[3])
																	$configured_rates[3] = $rate;
																/**/
																else if ($zip && $location === $zip . "/" . $country)
																	$configured_rates[4] = $rate;
															}
													}
												/**/
												if (is_array ($configured_rates) && !empty ($configured_rates))
													{
														krsort ($configured_rates);
														$configured_rate = array_shift ($configured_rates);
														/**/
														if (preg_match ("/%$/", $configured_rate)) /* Percentage. */
															{
																if (($configured_rate = (float)$configured_rate) > 0)
																	{
																		$this_tax = round (($this_sub_total / 100) * $configured_rate, 2);
																		$this_tax_per = $configured_rate . "%";
																	}
																else /* Else the Tax is 0.00. */
																	{
																		$this_tax = 0.00; /* No Tax. */
																		$this_tax_per = $configured_rate . "%";
																	}
															}
														else if (($configured_rate = (float)$configured_rate) > 0)
															{
																$this_tax = round ($configured_rate, 2);
																$this_tax_per = ""; /* Flat rate. */
															}
														else /* Else the Tax is 0.00. */
															{
																$this_tax = 0.00; /* No Tax. */
																$this_tax_per = ""; /* Flat rate. */
															}
													}
											}
										/**/
										$this_total = $this_sub_total + $this_tax;
									}
								else /* Else the Tax is 0.00. */
									{
										$this_tax = 0.00; /* No Tax. */
										$this_tax_per = ""; /* Flat rate. */
										$this_sub_total = 0.00; /* 0.00. */
										$this_total = 0.00; /* 0.00. */
									}
								/**/
								if ($this_key === "trial_sub_total")
									{
										$trial_tax = $this_tax;
										$trial_tax_per = $this_tax_per;
										$trial_sub_total = $this_sub_total;
										$trial_total = $this_total;
									}
								else if ($this_key === "sub_total")
									{
										$tax = $this_tax;
										$tax_per = $this_tax_per;
										$sub_total = $this_sub_total;
										$total = $this_total;
									}
							}
						/**/
						return array ("trial_sub_total" => number_format ($trial_sub_total, 2, ".", ""), "sub_total" => number_format ($sub_total, 2, ".", ""), "trial_tax" => number_format ($trial_tax, 2, ".", ""), "tax" => number_format ($tax, 2, ".", ""), "trial_tax_per" => $trial_tax_per, "tax_per" => $tax_per, "trial_total" => number_format ($trial_total, 2, ".", ""), "total" => number_format ($total, 2, ".", ""), "cur" => $currency, "cur_symbol" => c_ws_plugin__s2member_utils_cur::symbol ($currency), "desc" => $desc);
					}
				/**
				* Checks to see if a Coupon Code was supplied, and if so; what does it provide?
				*
				* @package s2Member\AuthNet
				* @since 1.5
				*
				* @param array $attr An array of Pro Form Attributes.
				* @param str $coupon_code Optional. A possible Coupon Code supplied by the Customer.
				* @param str $return_reponse_or_attr Optional. One of `response|attr`. Defaults to `attr`.
				* @return array|str Original array, with prices and description modified when/if a Coupon Code is accepted.
				* 	Or, if ``$return_response_or_attr === "response"``, return a string response, indicating status.
				*
				* @todo See if it's possible to simplify this routine.
				* @todo Add support for tracking Coupon Code usage.
				* @todo Add support for a fixed number of uses.
				*/
				public static function authnet_apply_coupon ($attr = FALSE, $coupon_code = FALSE, $return_response_or_attr = "attr")
					{
						if (($coupon_code = trim (strtolower ($coupon_code))) || ($coupon_code = trim (strtolower ($attr["coupon"]))))
							if ($attr["accept_coupons"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_coupon_codes"])
								{
									$cs = c_ws_plugin__s2member_utils_cur::symbol ($attr["cc"]);
									$tx = (c_ws_plugin__s2member_pro_authnet_utilities::authnet_tax_may_apply ()) ? ' + tax' : '';
									/**/
									foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_coupon_codes"]) as $line)
										{
											if (($line = trim ($line, " \r\n\t\0\x0B|")) && is_array ($_coupon = preg_split ("/\|/", $line)))
												{
													$coupon["code"] = trim (strtolower ($_coupon[0]));
													$coupon["percentage"] = (preg_match ("/%/", $_coupon[1])) ? (float)$_coupon[1] : 0;
													$coupon["flat-rate"] = (!preg_match ("/%/", $_coupon[1])) ? (float)$_coupon[1] : 0;
													$coupon["expired"] = ($_coupon[2] && strtotime ($_coupon[2]) < time ()) ? $_coupon[2] : false;
													/**/
													$_coupon[3] = ($_coupon[3]) ? preg_replace ("/_/", "-", $_coupon[3]) : "all";
													$coupon["directive"] = (preg_match ("/^(ta-only|ra-only|all)$/", $_coupon[3])) ? $_coupon[3] : "all";
													/**/
													if ($coupon_code === $coupon["code"] && !$coupon["expired"])
														{
															if ($coupon["flat-rate"]) /* If it's a flat-rate Coupon. */
																{
																	if (($coupon["directive"] === "ra-only" || $coupon["directive"] === "all") && $attr["sp"])
																		{
																			$ta = number_format ($attr["ta"], 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$ra = number_format ($attr["ra"] - $coupon["flat-rate"], 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off. ( Now: ' . $cs . $ra . $tx . ' )';
																			$response = '<div>Coupon: <strong>' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off</strong>. ( Now: <strong>' . $cs . $ra . $tx . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "ta-only" && $attr["tp"] && !$attr["sp"])
																		{
																			$ta = number_format ($attr["ta"] - $coupon["flat-rate"], 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$ra = number_format ($attr["ra"], 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . ' )';
																			$response = '<div>Coupon: <strong>' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "ra-only" && $attr["tp"] && !$attr["sp"])
																		{
																			$ta = number_format ($attr["ta"], 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$ra = number_format ($attr["ra"] - $coupon["flat-rate"], 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . ' )';
																			$response = '<div>Coupon: <strong>' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "all" && $attr["tp"] && !$attr["sp"])
																		{
																			$ta = number_format ($attr["ta"] - $coupon["flat-rate"], 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$ra = number_format ($attr["ra"] - $coupon["flat-rate"], 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . ' )';
																			$response = '<div>Coupon: <strong>' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "ra-only" && !$attr["tp"] && !$attr["sp"])
																		{
																			$ta = number_format ($attr["ta"], 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$ra = number_format ($attr["ra"] - $coupon["flat-rate"], 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . $tx . ' )';
																			$response = '<div>Coupon: <strong>' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . $tx . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "all" && !$attr["tp"] && !$attr["sp"])
																		{
																			$ta = number_format ($attr["ta"] - $coupon["flat-rate"], 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$ra = number_format ($attr["ra"] - $coupon["flat-rate"], 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . $tx . ' )';
																			$response = '<div>Coupon: <strong>' . $cs . number_format ($coupon["flat-rate"], 2, ".", "") . ' off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . $tx . '</strong> )</div>';
																		}
																	/**/
																	else /* Otherwise, we need a default response to display. */
																		$response = '<div>Sorry, your Coupon is not applicable.</div>';
																}
															/**/
															else if ($coupon["percentage"]) /* Else if it's a percentage. */
																{
																	if (($coupon["directive"] === "ra-only" || $coupon["directive"] === "all") && $attr["sp"])
																		{
																			$p = ($attr["ta"] / 100) * $coupon["percentage"];
																			$ta = number_format ($attr["ta"], 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$p = ($attr["ra"] / 100) * $coupon["percentage"];
																			$ra = number_format ($attr["ra"] - $p, 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . number_format ($coupon["percentage"], 0) . '% off. ( Now: ' . $cs . $ra . $tx . ' )';
																			$response = '<div>Coupon: <strong>' . number_format ($coupon["percentage"], 0) . '% off</strong>. ( Now: <strong>' . $cs . $ra . $tx . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "ta-only" && $attr["tp"] && !$attr["sp"])
																		{
																			$p = ($attr["ta"] / 100) * $coupon["percentage"];
																			$ta = number_format ($attr["ta"] - $p, 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$p = ($attr["ra"] / 100) * $coupon["percentage"];
																			$ra = number_format ($attr["ra"], 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . number_format ($coupon["percentage"], 0) . '% off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . ' )';
																			$response = '<div>Coupon: <strong>' . number_format ($coupon["percentage"], 0) . '% off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "ra-only" && $attr["tp"] && !$attr["sp"])
																		{
																			$p = ($attr["ta"] / 100) * $coupon["percentage"];
																			$ta = number_format ($attr["ta"], 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$p = ($attr["ra"] / 100) * $coupon["percentage"];
																			$ra = number_format ($attr["ra"] - $p, 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . number_format ($coupon["percentage"], 0) . '% off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . ' )';
																			$response = '<div>Coupon: <strong>' . number_format ($coupon["percentage"], 0) . '% off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "all" && $attr["tp"] && !$attr["sp"])
																		{
																			$p = ($attr["ta"] / 100) * $coupon["percentage"];
																			$ta = number_format ($attr["ta"] - $p, 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$p = ($attr["ra"] / 100) * $coupon["percentage"];
																			$ra = number_format ($attr["ra"] - $p, 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . number_format ($coupon["percentage"], 0) . '% off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . ' )';
																			$response = '<div>Coupon: <strong>' . number_format ($coupon["percentage"], 0) . '% off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ta, $attr["tp"] . " " . $attr["tt"]) . $tx . ', then ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "ra-only" && !$attr["tp"] && !$attr["sp"])
																		{
																			$p = ($attr["ta"] / 100) * $coupon["percentage"];
																			$ta = number_format ($attr["ta"], 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$p = ($attr["ra"] / 100) * $coupon["percentage"];
																			$ra = number_format ($attr["ra"] - $p, 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . number_format ($coupon["percentage"], 0) . '% off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . $tx . ' )';
																			$response = '<div>Coupon: <strong>' . number_format ($coupon["percentage"], 0) . '% off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . $tx . '</strong> )</div>';
																		}
																	else if ($coupon["directive"] === "all" && !$attr["tp"] && !$attr["sp"])
																		{
																			$p = ($attr["ta"] / 100) * $coupon["percentage"];
																			$ta = number_format ($attr["ta"] - $p, 2, ".", "");
																			$ta = ($ta >= 0.00) ? $ta : "0.00";
																			/**/
																			$p = ($attr["ra"] / 100) * $coupon["percentage"];
																			$ra = number_format ($attr["ra"] - $p, 2, ".", "");
																			$ra = ($ra >= 0.01) ? $ra : "0.01";
																			/**/
																			$desc = 'COUPON ' . number_format ($coupon["percentage"], 0) . '% off. ( Now: ' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . $tx . ' )';
																			$response = '<div>Coupon: <strong>' . number_format ($coupon["percentage"], 0) . '% off</strong>. ( Now: <strong>' . $cs . c_ws_plugin__s2member_utils_time::amount_period_term ($ra, $attr["rp"] . " " . $attr["rt"], $attr["rr"]) . $tx . '</strong> )</div>';
																		}
																	/**/
																	else /* Otherwise, we need a default response to display. */
																		$response = '<div>Sorry, your Coupon is not applicable.</div>';
																}
															/**/
															else /* Else there was no discount applied at all. */
																$response = '<div>Coupon: <strong>' . $cs . '0.00 off</strong>.</div>';
														}
													/**/
													else if ($coupon_code === $coupon["code"] && $coupon["expired"])
														$response = '<div>Sorry, your Coupon <strong>expired</strong>: <em>' . $coupon["expired"] . '</em>.</div>';
												}
										}
									/**/
									$attr["ta"] = (isset ($ta)) ? $ta : $attr["ta"]; /* Is there a new Trial Amount? */
									$attr["ra"] = (isset ($ra)) ? $ra : $attr["ra"]; /* How about a Regular Amount? */
									$attr["desc"] = (isset ($desc)) ? $desc . ' ~ ORIGINALLY: ' . $attr["desc"] : $attr["desc"];
									/**/
									if (!$response) /* Otherwise, we need a default response to display. */
										$response = '<div>Sorry, your Coupon is N/A, invalid or expired.</div>';
								}
							/**/
							else /* Otherwise, we need a default response to display. */
								$response = '<div>Sorry, your Coupon is N/A, invalid or expired.</div>';
						/**/
						return ($return_response_or_attr === "response") ? $response : $attr;
					}
			}
	}
?>