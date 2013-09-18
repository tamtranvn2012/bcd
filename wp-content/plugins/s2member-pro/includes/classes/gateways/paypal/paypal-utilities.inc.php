<?php
/**
* PayPal® utilities.
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
* @package s2Member\PayPal
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_pro_paypal_utilities"))
	{
		/**
		* PayPal® utilities.
		*
		* @package s2Member\PayPal
		* @since 1.5
		*/
		class c_ws_plugin__s2member_pro_paypal_utilities
			{
				/**
				* Adds the `s2p-v` variable onto the end of a custom URL for success.
				*
				* @package s2Member\PayPal
				* @since 1.5
				*
				* @param str $url A full URL to append the `s2p-v` variable onto.
				* @return str A full URL with the `s2p-v` query string argument as well.
				*/
				public static function paypal_s2p_v_generate ($url = FALSE)
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
				* @package s2Member\PayPal
				* @since 1.5
				*
				* @param str $qs Optional. Defaults to ``$_SERVER["QUERY_STRING"]``.
				* @return bool True if the query string is OK/verified, else false.
				*/
				public static function paypal_s2p_v_query_ok ($qs = FALSE, $ignore_timestamp = FALSE)
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
				* @package s2Member\PayPal
				* @since 1.5
				*
				* @param str $period1 Optional. A "Period Term" combination. Defaults to `0 D`.
				* @param str $period3 Optional. A "Period Term" combination. Defaults to `0 D`.
				* @return int The start time, a Unix timestamp.
				*/
				public static function paypal_start_time ($period1 = FALSE, $period3 = FALSE)
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
						/* This prevents date clashes with PayPal's API server. */
						/**/
						return $start_time;
					}
				/**
				* Determines whether or not Tax may apply.
				*
				* @package s2Member\PayPal
				* @since 1.5
				*
				* @return bool True if Tax may apply, else false.
				*/
				public static function paypal_tax_may_apply ()
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
				* Handles currency conversions for Maestro/Solo cards.
				*
				* PayPal® requires Maestro/Solo to be charged in GBP. So if a site owner is using
				* another currency *( i.e. something NOT in GBP )*, we have to convert all of the charge amounts dynamically.
				*
				* Coupon Codes should always be applied before this conversion takes place.
				* That way a site owner's configuration remains adequate.
				*
				* Tax rates should be applied after this conversion takes place.
				*
				* @package s2Member\PayPal
				* @since 110531
				*
				* @param array $attr An array of PayPal® Pro Form Attributes.
				* @param str $card_type The Card Type *( i.e. Billing Method )* selected.
				* @return array The same array of Pro Form Attributes, with possible currency conversions.
				*/
				public static function paypal_maestro_solo_2gbp ($attr = FALSE, $card_type = FALSE)
					{
						if (is_array ($attr) && is_string ($card_type) && in_array ($card_type, array ("Maestro", "Solo")))
							if (!empty ($attr["cc"]) && strcasecmp ($attr["cc"], "GBP") !== 0 && is_numeric ($attr["ta"]) && is_numeric ($attr["ra"]))
								if (($attr["ta"] <= 0 && is_numeric ($c_ta = "0")) || is_numeric ($c_ta = c_ws_plugin__s2member_utils_cur::convert ($attr["ta"], $attr["cc"], "GBP")))
									if (($attr["ra"] <= 0 && is_numeric ($c_ra = "0")) || is_numeric ($c_ra = c_ws_plugin__s2member_utils_cur::convert ($attr["ra"], $attr["cc"], "GBP")))
										$attr = array_merge ($attr, array ("cc" => "GBP", "ta" => $c_ta, "ra" => $c_ra));
						/**/
						return $attr; /* Return array of Attributes. */
					}
				/**
				* Handles the return of Tax for Pro Forms, via AJAX; through a JSON object.
				*
				* @package s2Member\PayPal
				* @since 1.5
				*
				* @return null Or exits script execution after returning data for AJAX caller.
				*
				* @todo Check the use of ``strip_tags()`` in this routine?
				* @todo Continue optimizing this routine with ``empty()`` and ``isset()``.
				* @todo Candidate for the use of ``ifsetor()``?
				*/
				public static function paypal_ajax_tax ()
					{
						if (!empty ($_POST["ws_plugin__s2member_pro_paypal_ajax_tax"]) && ($nonce = $_POST["ws_plugin__s2member_pro_paypal_ajax_tax"]) && (wp_verify_nonce ($nonce, "ws-plugin--s2member-pro-paypal-ajax-tax") || c_ws_plugin__s2member_utils_encryption::decrypt ($nonce) === "ws-plugin--s2member-pro-paypal-ajax-tax"))
							/* A wp_verify_nonce() won't always work here, because s2member-pro-min.js must be cacheable. The output from wp_create_nonce() would go stale.
									So instead, s2member-pro-min.js should use c_ws_plugin__s2member_utils_encryption::encrypt() as an alternate form of nonce. */
							{
								if (!empty ($_POST["ws_plugin__s2member_pro_paypal_ajax_tax_vars"]) && is_array ($_p_tax_vars = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST["ws_plugin__s2member_pro_paypal_ajax_tax_vars"]))))
									{
										if (is_array ($attr = (!empty ($_p_tax_vars["attr"])) ? unserialize (c_ws_plugin__s2member_utils_encryption::decrypt ($_p_tax_vars["attr"])) : false))
											{
												$attr = (!empty ($attr["coupon"])) ? c_ws_plugin__s2member_pro_paypal_utilities::paypal_apply_coupon ($attr, $attr["coupon"]) : $attr;
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
												$a = c_ws_plugin__s2member_pro_paypal_utilities::paypal_cost (null, $sub_total_today, $state, $country, $zip, $currency, $desc);
												echo json_encode (array ("trial" => $trial, "sub_total" => $a["sub_total"], "tax" => $a["tax"], "tax_per" => $a["tax_per"], "total" => $a["total"], "cur" => $a["cur"], "cur_symbol" => $a["cur_symbol"], "desc" => $a["desc"]));
											}
									}
								/**/
								exit (); /* Clean exit. */
							}
					}
				/**
				* Handles all cost calculations for PayPal®.
				*
				* Returns an associative array with a possible Percentage Rate, along with the calculated Tax Amount.
				* Tax calculations are based on State/Province, Country, and/or Zip Code.
				* Updated to support multiple data fields in it's return value.
				*
				* @package s2Member\PayPal
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
				public static function paypal_cost ($trial_sub_total = FALSE, $sub_total = FALSE, $state = FALSE, $country = FALSE, $zip = FALSE, $currency = FALSE, $desc = FALSE)
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
				* @package s2Member\PayPal
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
				public static function paypal_apply_coupon ($attr = FALSE, $coupon_code = FALSE, $return_response_or_attr = "attr")
					{
						if (($coupon_code = trim (strtolower ($coupon_code))) || ($coupon_code = trim (strtolower ($attr["coupon"]))))
							if ($attr["accept_coupons"] && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_coupon_codes"])
								{
									$cs = c_ws_plugin__s2member_utils_cur::symbol ($attr["cc"]);
									$tx = (c_ws_plugin__s2member_pro_paypal_utilities::paypal_tax_may_apply ()) ? ' + tax' : '';
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