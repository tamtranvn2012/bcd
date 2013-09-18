/**
* Core JavaScript routines for PayPal®.
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
/*
Scripting routines handled on document ready state.
*/
jQuery(document).ready (function($)
	{
		var $clForm, $upForm, $rgForm, $spForm, $coForm, jumpToResponses, preloadAjaxLoader, ariaTrue = {'aria-required': 'true'}, ariaFalse = {'aria-required': 'false'}, disabled = {'disabled': 'disabled'}, ariaFalseDis = {'aria-required': 'false', 'disabled': 'disabled'};
		/**/
		preloadAjaxLoader = new Image (), preloadAjaxLoader.src = '<?php echo $vars["i"]; ?>/ajax-loader.gif';
		/**/
		if (($clForm = $('form#s2member-pro-paypal-cancellation-form')).length === 1)
			{
				var captchaSection = 'div#s2member-pro-paypal-cancellation-form-captcha-section', submissionSection = 'div#s2member-pro-paypal-cancellation-form-submission-section', $submissionButton = $(submissionSection + ' input#s2member-pro-paypal-cancellation-submit');
				/**/
				ws_plugin__s2member_animateProcessing($submissionButton, 'reset'), $submissionButton.removeAttr ('disabled');
				/**/
				$clForm.submit (function() /* Form validation. */
					{
						var context = this, label = '', error = '', errors = '';
						/**/
						var $recaptchaResponse = $(captchaSection + ' input#recaptcha_response_field');
						/**/
						$(':input', context).each (function() /* Go through them all together. */
							{
								var id = $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, ''); /* Remove numeric suffixes. */
								/**/
								if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().children ('span').first ().text ().replace (/[\r\n\t]+/g, ' '))))
									{
										if (error = ws_plugin__s2member_validationErrors(label, this, context))
											errors += error + '\n\n'; /* Collect errors. */
									}
							});
						/**/
						if (errors = $.trim (errors))
							{
								alert('— Oops, you missed something: —\n\n' + errors);
								/**/
								return false;
							}
						/**/
						else if ($recaptchaResponse.length && !$recaptchaResponse.val ())
							{
								alert('— Oops, you missed something: —\n\nSecurity Code missing. Please try again.');
								/**/
								return false;
							}
						/**/
						$submissionButton.attr (disabled), ws_plugin__s2member_animateProcessing($submissionButton);
						/**/
						return true;
					});
			}
		/**/
		else if (($upForm = $('form#s2member-pro-paypal-update-form')).length === 1)
			{
				var handleBillingMethod, billingMethodSection = 'div#s2member-pro-paypal-update-form-billing-method-section', billingAddressSection = 'div#s2member-pro-paypal-update-form-billing-address-section', cardType = billingMethodSection + ' input[name="s2member_pro_paypal_update\[card_type\]"]', captchaSection = 'div#s2member-pro-paypal-update-form-captcha-section', submissionSection = 'div#s2member-pro-paypal-update-form-submission-section', $submissionButton = $(submissionSection + ' input#s2member-pro-paypal-update-submit');
				/**/
				ws_plugin__s2member_animateProcessing($submissionButton, 'reset'), $submissionButton.removeAttr ('disabled');
				/**/
				(handleBillingMethod = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						var billingMethod = $(cardType + ':checked').val (); /* Billing Method. */
						/**/
						if ($.inArray (billingMethod, ['Visa', 'MasterCard', 'Amex', 'Discover']) !== -1)
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-update-form-div').show ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-update-form-div :input').attr (ariaTrue);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-update-form-card-start-date-issue-number-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-update-form-card-start-date-issue-number-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-update-form-div').show ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-update-form-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection).show (), (eventTrigger) ? $(billingMethodSection + ' input#s2member-pro-paypal-update-card-number').focus () : null;
							}
						else if ($.inArray (billingMethod, ['Maestro', 'Solo']) !== -1)
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-update-form-div').show ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-update-form-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-update-form-div').show ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-update-form-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection).show (), (eventTrigger) ? $(billingMethodSection + ' input#s2member-pro-paypal-update-card-number').focus () : null;
							}
						else if (!billingMethod) /* Else there was no Billing Method supplied. */
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-update-form-div').hide ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-update-form-div :input').attr (ariaFalse);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-update-form-card-type-div').show ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-update-form-card-type-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-update-form-div').hide ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-update-form-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection).hide (), (eventTrigger) ? $(submissionSection + ' input#s2member-pro-paypal-update-submit').focus () : null;
							}
					}) ();
				/**/
				$(cardType).click (handleBillingMethod).change (handleBillingMethod);
				/**/
				$upForm.submit (function() /* Form validation. */
					{
						var context = this, label = '', error = '', errors = '';
						/**/
						var $recaptchaResponse = $(captchaSection + ' input#recaptcha_response_field');
						/**/
						if (!$(cardType + ':checked').val ())
							{
								alert('Please choose a Billing Method.');
								/**/
								return false;
							}
						/**/
						$(':input', context).each (function() /* Go through them all together. */
							{
								var id = $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, ''); /* Remove numeric suffixes. */
								/**/
								if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().children ('span').first ().text ().replace (/[\r\n\t]+/g, ' '))))
									{
										if (error = ws_plugin__s2member_validationErrors(label, this, context))
											errors += error + '\n\n'; /* Collect errors. */
									}
							});
						/**/
						if (errors = $.trim (errors))
							{
								alert('— Oops, you missed something: —\n\n' + errors);
								/**/
								return false;
							}
						/**/
						else if ($recaptchaResponse.length && !$recaptchaResponse.val ())
							{
								alert('— Oops, you missed something: —\n\nSecurity Code missing. Please try again.');
								/**/
								return false;
							}
						/**/
						$submissionButton.attr (disabled), ws_plugin__s2member_animateProcessing($submissionButton);
						/**/
						return true;
					});
			}
		/**/
		else if (($rgForm = $('form#s2member-pro-paypal-registration-form')).length === 1)
			{
				var handleNameIssues, handlePasswordIssues, registrationSection = 'div#s2member-pro-paypal-registration-form-registration-section', captchaSection = 'div#s2member-pro-paypal-registration-form-captcha-section', submissionSection = 'div#s2member-pro-paypal-registration-form-submission-section', $submissionButton = $(submissionSection + ' input#s2member-pro-paypal-registration-submit');
				/**/
				ws_plugin__s2member_animateProcessing($submissionButton, 'reset'), $submissionButton.removeAttr ('disabled');
				/**/
				(handleNameIssues = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if ($(submissionSection + ' input#s2member-pro-paypal-registration-names-not-required-or-not-possible').length)
							{
								$(registrationSection + ' > div#s2member-pro-paypal-registration-form-first-name-div').hide ();
								$(registrationSection + ' > div#s2member-pro-paypal-registration-form-first-name-div :input').attr (ariaFalseDis);
								/**/
								$(registrationSection + ' > div#s2member-pro-paypal-registration-form-last-name-div').hide ();
								$(registrationSection + ' > div#s2member-pro-paypal-registration-form-last-name-div :input').attr (ariaFalseDis);
							}
					}) ();
				/**/
				(handlePasswordIssues = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if ($(submissionSection + ' input#s2member-pro-paypal-registration-password-not-required-or-not-possible').length)
							{
								$(registrationSection + ' > div#s2member-pro-paypal-registration-form-password-div').hide ();
								$(registrationSection + ' > div#s2member-pro-paypal-registration-form-password-div :input').attr (ariaFalseDis);
							}
					}) ();
				/**/
				$(registrationSection + ' > div#s2member-pro-paypal-registration-form-password-div :input').keyup (function()
					{
						ws_plugin__s2member_passwordStrength($(registrationSection + ' input#s2member-pro-paypal-registration-username'), $(registrationSection + ' input#s2member-pro-paypal-registration-password1'), $(registrationSection + ' input#s2member-pro-paypal-registration-password2'), $(registrationSection + ' div#s2member-pro-paypal-registration-form-password-strength'));
					});
				/**/
				$rgForm.submit (function() /* Form validation. */
					{
						var context = this, label = '', error = '', errors = '';
						/**/
						var $recaptchaResponse = $(captchaSection + ' input#recaptcha_response_field');
						/**/
						var $password1 = $(registrationSection + ' input#s2member-pro-paypal-registration-password1[aria-required="true"]');
						var $password2 = $(registrationSection + ' input#s2member-pro-paypal-registration-password2');
						/**/
						$(':input', context).each (function() /* Go through them all together. */
							{
								var id = $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, ''); /* Remove numeric suffixes. */
								/**/
								if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().children ('span').first ().text ().replace (/[\r\n\t]+/g, ' '))))
									{
										if (error = ws_plugin__s2member_validationErrors(label, this, context))
											errors += error + '\n\n'; /* Collect errors. */
									}
							});
						/**/
						if (errors = $.trim (errors))
							{
								alert('— Oops, you missed something: —\n\n' + errors);
								/**/
								return false;
							}
						/**/
						else if ($password1.length && $.trim ($password1.val ()) !== $.trim ($password2.val ()))
							{
								alert('— Oops, you missed something: —\n\nPasswords do not match up. Please try again.');
								/**/
								return false;
							}
						/**/
						else if ($recaptchaResponse.length && !$recaptchaResponse.val ())
							{
								alert('— Oops, you missed something: —\n\nSecurity Code missing. Please try again.');
								/**/
								return false;
							}
						/**/
						$submissionButton.attr (disabled), ws_plugin__s2member_animateProcessing($submissionButton);
						/**/
						return true;
					});
			}
		/**/
		else if (($spForm = $('form#s2member-pro-paypal-sp-checkout-form')).length === 1)
			{
				var handleCouponIssues, handleTaxIssues, taxMayApply = true, calculateTax, cTaxDelay, cTaxTimeout, cTaxReq, cTaxLocation, handleExistingUsers, handleBillingMethod, couponSection = 'div#s2member-pro-paypal-sp-checkout-form-coupon-section', couponApplyButton = couponSection + ' input#s2member-pro-paypal-sp-checkout-coupon-apply', registrationSection = 'div#s2member-pro-paypal-sp-checkout-form-registration-section', billingMethodSection = 'div#s2member-pro-paypal-sp-checkout-form-billing-method-section', cardType = billingMethodSection + ' input[name="s2member_pro_paypal_sp_checkout\[card_type\]"]', billingAddressSection = 'div#s2member-pro-paypal-sp-checkout-form-billing-address-section', $ajaxTaxDiv = $(billingAddressSection + ' > div#s2member-pro-paypal-sp-checkout-form-ajax-tax-div'), captchaSection = 'div#s2member-pro-paypal-sp-checkout-form-captcha-section', submissionSection = 'div#s2member-pro-paypal-sp-checkout-form-submission-section', submissionNonceVerification = submissionSection + ' input#s2member-pro-paypal-sp-checkout-nonce', submissionButton = submissionSection + ' input#s2member-pro-paypal-sp-checkout-submit';
				/**/
				var submitButton = '<input type="submit" id="s2member-pro-paypal-sp-checkout-submit" class="s2member-pro-paypal-sp-checkout-submit" value="Submit Form" tabindex="310" />';
				var submitExpressCheckoutButton = '<input type="image" src="<?php echo $i; ?>/paypal-xco.gif" id="s2member-pro-paypal-sp-checkout-submit" class="s2member-pro-paypal-sp-checkout-submit" value="Submit Form" tabindex="310" />';
				/**/
				ws_plugin__s2member_animateProcessing($(submissionButton), 'reset'), $(submissionButton).removeAttr ('disabled'), $(couponApplyButton).removeAttr ('disabled');
				/**/
				(handleCouponIssues = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if ($(submissionSection + ' input#s2member-pro-paypal-sp-checkout-coupons-not-required-or-not-possible').length)
							{
								$(couponSection).hide (); /* Not accepting Coupons on this particular form. */
							}
						else /* This is turned off by default for smoother loading. ( via: display:none ). */
							$(couponSection).show (); /* OK. So we need to display this now. */
					}) ();
				/**/
				(handleTaxIssues = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if ($(submissionSection + ' input#s2member-pro-paypal-sp-checkout-tax-not-required-or-not-possible').length)
							{
								$ajaxTaxDiv.hide (), taxMayApply = false; /* Tax does NOT even apply. */
							}
					}) ();
				/**/
				(calculateTax = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if (taxMayApply && !(eventTrigger && eventTrigger.interval && document.activeElement.id === 's2member-pro-paypal-sp-checkout-country'))
							{
								var attr = $(submissionSection + ' input#s2member-pro-paypal-sp-checkout-attr').val ();
								var state = $.trim ($(billingAddressSection + ' input#s2member-pro-paypal-sp-checkout-state').val ());
								var country = $(billingAddressSection + ' select#s2member-pro-paypal-sp-checkout-country').val ();
								var zip = $.trim ($(billingAddressSection + ' input#s2member-pro-paypal-sp-checkout-zip').val ());
								var thisTaxLocation = state + '|' + country + '|' + zip; /* Three part location. */
								/**/
								if (state && country && zip && thisTaxLocation && (!cTaxLocation || cTaxLocation !== thisTaxLocation) && (cTaxLocation = thisTaxLocation))
									{
										(cTaxReq) ? cTaxReq.abort () : null, clearTimeout(cTaxTimeout), cTaxTimeout = null; /* Abort / clear. */
										/**/
										$ajaxTaxDiv.html ('<div><img src="<?php echo $vars["i"]; ?>/ajax-loader.gif" alt="Calculating Sales Tax..." /> calculating sales tax...</div>');
										/**/
										cTaxTimeout = setTimeout(function() /* Create a new cTaxTimeout with a one second delay. */
											{
												cTaxReq = $.post ('<?php echo c_ws_plugin__s2member_utils_strings::esc_sq(admin_url("/admin-ajax.php")); ?>', {'action': 'ws_plugin__s2member_pro_paypal_ajax_tax', 'ws_plugin__s2member_pro_paypal_ajax_tax': '<?php echo c_ws_plugin__s2member_utils_strings::esc_sq (c_ws_plugin__s2member_utils_encryption::encrypt ("ws-plugin--s2member-pro-paypal-ajax-tax")); ?>', 'ws_plugin__s2member_pro_paypal_ajax_tax_vars[attr]': attr, 'ws_plugin__s2member_pro_paypal_ajax_tax_vars[state]': state, 'ws_plugin__s2member_pro_paypal_ajax_tax_vars[country]': country, 'ws_plugin__s2member_pro_paypal_ajax_tax_vars[zip]': zip}, function(response)
													{
														clearTimeout(cTaxTimeout), cTaxTimeout = null; /* Clear cTaxTimeout. */
														/**/
														try /* Try/catch here. jQuery will sometimes return a successful response in IE, whenever the connection is aborted with a null response. */
															{
																$ajaxTaxDiv.html ('<div><strong>Sales Tax' + ((response.trial) ? ' Today' : '') + ':</strong> ' + ((response.tax_per) ? '<em>' + response.tax_per + '</em> ( ' + response.cur_symbol + '' + response.tax + ' )' : response.cur_symbol + '' + response.tax) + '<br /><strong>— Total' + ((response.trial) ? ' Today' : '') + ':</strong> ' + response.cur_symbol + '' + response.total + '</div>');
															}
														catch (e) {}
													/**/
													}, 'json');
											/**/
											}, ((eventTrigger && eventTrigger.keyCode) ? 1000 : 100));
									}
								/**/
								else if (!state || !country || !zip || !thisTaxLocation)
									$ajaxTaxDiv.html (''), cTaxLocation = null;
							}
					}) ();
				/**/
				cTaxDelay = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						setTimeout(function() /* Trigger event handler with a brief delay. */
							{
								calculateTax(eventTrigger);
							}, 10); /* Brief delay. */
					}
				/**/
				$(billingAddressSection + ' input#s2member-pro-paypal-sp-checkout-state').bind ('keyup blur', calculateTax).bind ('cut paste', cTaxDelay);
				$(billingAddressSection + ' input#s2member-pro-paypal-sp-checkout-zip').bind ('keyup blur', calculateTax).bind ('cut paste', cTaxDelay);
				$(billingAddressSection + ' select#s2member-pro-paypal-sp-checkout-country').bind ('change', calculateTax);
				/**/
				setInterval(function() /* Helps with things like Google's Autofill feature. */
					{
						calculateTax({interval: true}); /* Identify as interval trigger. */
					}, 1000);
				/**/
				(handleExistingUsers = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if (S2MEMBER_CURRENT_USER_IS_LOGGED_IN) /* If User/Member is already logged in. */
							{
								$(registrationSection + ' input#s2member-pro-paypal-sp-checkout-first-name').each (function()
									{
										var $this = $(this), val = $this.val ();
										(!val) ? $this.val (S2MEMBER_CURRENT_USER_FIRST_NAME) : null;
									});
								/**/
								$(registrationSection + ' input#s2member-pro-paypal-sp-checkout-last-name').each (function()
									{
										var $this = $(this), val = $this.val ();
										(!val) ? $this.val (S2MEMBER_CURRENT_USER_LAST_NAME) : null;
									});
								/**/
								$(registrationSection + ' input#s2member-pro-paypal-sp-checkout-email').each (function()
									{
										var $this = $(this), val = $this.val ();
										(!val) ? $this.val (S2MEMBER_CURRENT_USER_EMAIL) : null;
									});
							}
					}) ();
				/**/
				(handleBillingMethod = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						var billingMethod = $(cardType + ':checked').val (); /* Billing Method. */
						/**/
						if ($.inArray (billingMethod, ['Visa', 'MasterCard', 'Amex', 'Discover']) !== -1)
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-sp-checkout-form-div').show ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-sp-checkout-form-div :input').attr (ariaTrue);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-start-date-issue-number-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-start-date-issue-number-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-sp-checkout-form-div').show ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-sp-checkout-form-div :input').attr (ariaTrue);
								/**/
								(!taxMayApply) ? $ajaxTaxDiv.hide () : null; /* Tax does NOT even apply. */
								/**/
								$(billingAddressSection).show (), $(submissionSection + ' input#s2member-pro-paypal-sp-checkout-submit').replaceWith (submitButton);
								/**/
								(eventTrigger) ? $(billingMethodSection + ' input#s2member-pro-paypal-sp-checkout-card-number').focus () : null;
							}
						else if ($.inArray (billingMethod, ['Maestro', 'Solo']) !== -1)
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-sp-checkout-form-div').show ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-sp-checkout-form-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-sp-checkout-form-div').show ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-sp-checkout-form-div :input').attr (ariaTrue);
								/**/
								(!taxMayApply) ? $ajaxTaxDiv.hide () : null; /* Tax does NOT even apply. */
								/**/
								$(billingAddressSection).show (), $(submissionSection + ' input#s2member-pro-paypal-sp-checkout-submit').replaceWith (submitButton);
								/**/
								(eventTrigger) ? $(billingMethodSection + ' input#s2member-pro-paypal-sp-checkout-card-number').focus () : null;
							}
						else if ((!billingMethod || billingMethod === 'PayPal') && taxMayApply)
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-sp-checkout-form-div').show ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-sp-checkout-form-div :input').attr (ariaTrue);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-number-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-number-div :input').attr (ariaFalse);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-expiration-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-expiration-div :input').attr (ariaFalse);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-verification-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-verification-div :input').attr (ariaFalse);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-start-date-issue-number-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-start-date-issue-number-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-sp-checkout-form-div').show ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-sp-checkout-form-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection + ' > div#s2member-pro-paypal-sp-checkout-form-street-div').hide ();
								$(billingAddressSection + ' > div#s2member-pro-paypal-sp-checkout-form-street-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection + ' > div#s2member-pro-paypal-sp-checkout-form-city-div').hide ();
								$(billingAddressSection + ' > div#s2member-pro-paypal-sp-checkout-form-city-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection).show (), $(submissionSection + ' input#s2member-pro-paypal-sp-checkout-submit').replaceWith (submitExpressCheckoutButton);
								/**/
								(eventTrigger) ? $(billingAddressSection + ' input#s2member-pro-paypal-sp-checkout-state').focus () : null;
							}
						else if (!billingMethod || billingMethod === 'PayPal')
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-sp-checkout-form-div').hide ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-sp-checkout-form-div :input').attr (ariaFalse);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-type-div').show ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-sp-checkout-form-card-type-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-sp-checkout-form-div').hide ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-sp-checkout-form-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection).hide (), $(submissionSection + ' input#s2member-pro-paypal-sp-checkout-submit').replaceWith (submitExpressCheckoutButton);
								/**/
								(eventTrigger) ? $(submissionSection + ' input#s2member-pro-paypal-sp-checkout-submit').focus () : null;
							}
						/**/
						handleTaxIssues (); /* Tax issues. */
					}) ();
				/**/
				$(cardType).click (handleBillingMethod).change (handleBillingMethod);
				/**/
				$(couponApplyButton).click (function() /* Only applying coupon. */
					{
						$(submissionNonceVerification).val ('apply-coupon'), $spForm.submit ();
					});
				/**/
				$spForm.submit (function() /* Form validation. */
					{
						if ($(submissionNonceVerification).val () !== 'apply-coupon')
							{
								var context = this, label = '', error = '', errors = '';
								/**/
								var $recaptchaResponse = $(captchaSection + ' input#recaptcha_response_field');
								/**/
								if (!$(cardType + ':checked').val ())
									{
										$(cardType).val (['PayPal']);
									}
								/**/
								$(':input', context).each (function() /* Go through them all together. */
									{
										var id = $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, ''); /* Remove numeric suffixes. */
										/**/
										if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().children ('span').first ().text ().replace (/[\r\n\t]+/g, ' '))))
											{
												if (error = ws_plugin__s2member_validationErrors(label, this, context))
													errors += error + '\n\n'; /* Collect errors. */
											}
									});
								/**/
								if (errors = $.trim (errors))
									{
										alert('— Oops, you missed something: —\n\n' + errors);
										/**/
										return false;
									}
								/**/
								else if ($recaptchaResponse.length && !$recaptchaResponse.val ())
									{
										alert('— Oops, you missed something: —\n\nSecurity Code missing. Please try again.');
										/**/
										return false;
									}
							}
						/**/
						$(submissionButton).attr (disabled), ws_plugin__s2member_animateProcessing($(submissionButton)), $(couponApplyButton).attr (disabled);
						/**/
						return true;
					});
			}
		/**/
		else if (($coForm = $('form#s2member-pro-paypal-checkout-form')).length === 1)
			{
				var handleCouponIssues, handleTaxIssues, taxMayApply = true, calculateTax, cTaxDelay, cTaxTimeout, cTaxReq, cTaxLocation, handlePasswordIssues, handleBillingMethod, handleExistingUsers, couponSection = 'div#s2member-pro-paypal-checkout-form-coupon-section', couponApplyButton = couponSection + ' input#s2member-pro-paypal-checkout-coupon-apply', registrationSection = 'div#s2member-pro-paypal-checkout-form-registration-section', customFieldsSection = 'div#s2member-pro-paypal-checkout-form-custom-fields-section', billingMethodSection = 'div#s2member-pro-paypal-checkout-form-billing-method-section', cardType = billingMethodSection + ' input[name="s2member_pro_paypal_checkout\[card_type\]"]', billingAddressSection = 'div#s2member-pro-paypal-checkout-form-billing-address-section', $ajaxTaxDiv = $(billingAddressSection + ' > div#s2member-pro-paypal-checkout-form-ajax-tax-div'), captchaSection = 'div#s2member-pro-paypal-checkout-form-captcha-section', submissionSection = 'div#s2member-pro-paypal-checkout-form-submission-section', submissionNonceVerification = submissionSection + ' input#s2member-pro-paypal-checkout-nonce', submissionButton = submissionSection + ' input#s2member-pro-paypal-checkout-submit';
				/**/
				var submitButton = '<input type="submit" id="s2member-pro-paypal-checkout-submit" class="s2member-pro-paypal-checkout-submit" value="Submit Form" tabindex="410" />';
				var submitExpressCheckoutButton = '<input type="image" src="<?php echo $i; ?>/paypal-xco.gif" id="s2member-pro-paypal-checkout-submit" class="s2member-pro-paypal-checkout-submit" value="Submit Form" tabindex="410" />';
				/**/
				ws_plugin__s2member_animateProcessing($(submissionButton), 'reset'), $(submissionButton).removeAttr ('disabled'), $(couponApplyButton).removeAttr ('disabled');
				/**/
				(handleCouponIssues = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if ($(submissionSection + ' input#s2member-pro-paypal-checkout-coupons-not-required-or-not-possible').length)
							{
								$(couponSection).hide (); /* Not accepting Coupons on this particular form. */
							}
						else /* This is turned off by default for smoother loading. ( via: display:none ). */
							$(couponSection).show (); /* OK. So we need to display this now. */
					}) ();
				/**/
				(handleTaxIssues = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if ($(submissionSection + ' input#s2member-pro-paypal-checkout-tax-not-required-or-not-possible').length)
							{
								$ajaxTaxDiv.hide (), taxMayApply = false; /* Tax does NOT even apply. */
							}
					}) ();
				/**/
				(calculateTax = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if (taxMayApply && !(eventTrigger && eventTrigger.interval && document.activeElement.id === 's2member-pro-paypal-checkout-country'))
							{
								var attr = $(submissionSection + ' input#s2member-pro-paypal-checkout-attr').val ();
								var state = $.trim ($(billingAddressSection + ' input#s2member-pro-paypal-checkout-state').val ());
								var country = $(billingAddressSection + ' select#s2member-pro-paypal-checkout-country').val ();
								var zip = $.trim ($(billingAddressSection + ' input#s2member-pro-paypal-checkout-zip').val ());
								var thisTaxLocation = state + '|' + country + '|' + zip; /* Three part location. */
								/**/
								if (state && country && zip && thisTaxLocation && (!cTaxLocation || cTaxLocation !== thisTaxLocation) && (cTaxLocation = thisTaxLocation))
									{
										(cTaxReq) ? cTaxReq.abort () : null, clearTimeout(cTaxTimeout), cTaxTimeout = null; /* Abort / clear. */
										/**/
										$ajaxTaxDiv.html ('<div><img src="<?php echo $vars["i"]; ?>/ajax-loader.gif" alt="Calculating Sales Tax..." /> calculating sales tax...</div>');
										/**/
										cTaxTimeout = setTimeout(function() /* Create a new cTaxTimeout with a one second delay. */
											{
												cTaxReq = $.post ('<?php echo c_ws_plugin__s2member_utils_strings::esc_sq(admin_url("/admin-ajax.php")); ?>', {'action': 'ws_plugin__s2member_pro_paypal_ajax_tax', 'ws_plugin__s2member_pro_paypal_ajax_tax': '<?php echo c_ws_plugin__s2member_utils_strings::esc_sq (c_ws_plugin__s2member_utils_encryption::encrypt ("ws-plugin--s2member-pro-paypal-ajax-tax")); ?>', 'ws_plugin__s2member_pro_paypal_ajax_tax_vars[attr]': attr, 'ws_plugin__s2member_pro_paypal_ajax_tax_vars[state]': state, 'ws_plugin__s2member_pro_paypal_ajax_tax_vars[country]': country, 'ws_plugin__s2member_pro_paypal_ajax_tax_vars[zip]': zip}, function(response, textStatus)
													{
														clearTimeout(cTaxTimeout), cTaxTimeout = null; /* Clear cTaxTimeout. */
														/**/
														try /* Try/catch here. jQuery will sometimes return a successful response in IE, whenever the connection is aborted with a null response. */
															{
																$ajaxTaxDiv.html ('<div><strong>Sales Tax' + ((response.trial) ? ' Today' : '') + ':</strong> ' + ((response.tax_per) ? '<em>' + response.tax_per + '</em> ( ' + response.cur_symbol + '' + response.tax + ' )' : response.cur_symbol + '' + response.tax) + '<br /><strong>— Total' + ((response.trial) ? ' Today' : '') + ':</strong> ' + response.cur_symbol + '' + response.total + '</div>');
															}
														catch (e) {}
													/**/
													}, 'json');
											/**/
											}, ((eventTrigger && eventTrigger.keyCode) ? 1000 : 100));
									}
								/**/
								else if (!state || !country || !zip || !thisTaxLocation)
									$ajaxTaxDiv.html (''), cTaxLocation = null;
							}
					}) ();
				/**/
				cTaxDelay = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						setTimeout(function() /* Trigger event handler with a brief delay. */
							{
								calculateTax(eventTrigger);
							}, 10); /* Brief delay. */
					}
				/**/
				$(billingAddressSection + ' input#s2member-pro-paypal-checkout-state').bind ('keyup blur', calculateTax).bind ('cut paste', cTaxDelay);
				$(billingAddressSection + ' input#s2member-pro-paypal-checkout-zip').bind ('keyup blur', calculateTax).bind ('cut paste', cTaxDelay);
				$(billingAddressSection + ' select#s2member-pro-paypal-checkout-country').bind ('change', calculateTax);
				/**/
				setInterval(function() /* Helps with things like Google's Autofill feature. */
					{
						calculateTax({interval: true}); /* Identify as interval trigger. */
					}, 1000);
				/**/
				(handlePasswordIssues = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if ($(submissionSection + ' input#s2member-pro-paypal-checkout-password-not-required-or-not-possible').length)
							{
								$(registrationSection + ' > div#s2member-pro-paypal-checkout-form-password-div').hide ();
								$(registrationSection + ' > div#s2member-pro-paypal-checkout-form-password-div :input').attr (ariaFalseDis);
							}
					}) ();
				/**/
				(handleExistingUsers = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						if (S2MEMBER_CURRENT_USER_IS_LOGGED_IN) /* If User/Member is already logged in. */
							{
								$(registrationSection + ' input#s2member-pro-paypal-checkout-first-name').each (function()
									{
										var $this = $(this), val = $this.val ();
										(!val) ? $this.val (S2MEMBER_CURRENT_USER_FIRST_NAME) : null;
									});
								/**/
								$(registrationSection + ' input#s2member-pro-paypal-checkout-last-name').each (function()
									{
										var $this = $(this), val = $this.val ();
										(!val) ? $this.val (S2MEMBER_CURRENT_USER_LAST_NAME) : null;
									});
								/**/
								$(registrationSection + ' input#s2member-pro-paypal-checkout-email').val (S2MEMBER_CURRENT_USER_EMAIL).attr (ariaFalseDis);
								$(registrationSection + ' input#s2member-pro-paypal-checkout-username').val (S2MEMBER_CURRENT_USER_LOGIN).attr (ariaFalseDis);
								/**/
								$(registrationSection + ' > div#s2member-pro-paypal-checkout-form-password-div').hide ();
								$(registrationSection + ' > div#s2member-pro-paypal-checkout-form-password-div :input').attr (ariaFalseDis);
								/**/
								if ($.trim ($(registrationSection + ' > div#s2member-pro-paypal-checkout-form-registration-section-title').html ()) === 'Create Profile')
									$(registrationSection + ' > div#s2member-pro-paypal-checkout-form-registration-section-title').html ('Your Profile');
								/**/
								$(customFieldsSection).hide (), $(customFieldsSection + ' :input').attr (ariaFalseDis);
							}
					}) ();
				/**/
				(handleBillingMethod = function(eventTrigger) /* eventTrigger is passed by jQuery for DOM events. */
					{
						var billingMethod = $(cardType + ':checked').val (); /* Billing Method. */
						/**/
						if ($.inArray (billingMethod, ['Visa', 'MasterCard', 'Amex', 'Discover']) !== -1)
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-checkout-form-div').show ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-checkout-form-div :input').attr (ariaTrue);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-start-date-issue-number-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-start-date-issue-number-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-checkout-form-div').show ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-checkout-form-div :input').attr (ariaTrue);
								/**/
								(!taxMayApply) ? $ajaxTaxDiv.hide () : null; /* Tax does NOT even apply. */
								/**/
								$(billingAddressSection).show (), $(submissionSection + ' input#s2member-pro-paypal-checkout-submit').replaceWith (submitButton);
								/**/
								(eventTrigger) ? $(billingMethodSection + ' input#s2member-pro-paypal-checkout-card-number').focus () : null;
							}
						else if ($.inArray (billingMethod, ['Maestro', 'Solo']) !== -1)
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-checkout-form-div').show ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-checkout-form-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-checkout-form-div').show ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-checkout-form-div :input').attr (ariaTrue);
								/**/
								(!taxMayApply) ? $ajaxTaxDiv.hide () : null; /* Tax does NOT even apply. */
								/**/
								$(billingAddressSection).show (), $(submissionSection + ' input#s2member-pro-paypal-checkout-submit').replaceWith (submitButton);
								/**/
								(eventTrigger) ? $(billingMethodSection + ' input#s2member-pro-paypal-checkout-card-number').focus () : null;
							}
						else if ((!billingMethod || billingMethod === 'PayPal') && taxMayApply)
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-checkout-form-div').show ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-checkout-form-div :input').attr (ariaTrue);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-number-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-number-div :input').attr (ariaFalse);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-expiration-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-expiration-div :input').attr (ariaFalse);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-verification-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-verification-div :input').attr (ariaFalse);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-start-date-issue-number-div').hide ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-start-date-issue-number-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-checkout-form-div').show ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-checkout-form-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection + ' > div#s2member-pro-paypal-checkout-form-street-div').hide ();
								$(billingAddressSection + ' > div#s2member-pro-paypal-checkout-form-street-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection + ' > div#s2member-pro-paypal-checkout-form-city-div').hide ();
								$(billingAddressSection + ' > div#s2member-pro-paypal-checkout-form-city-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection).show (), $(submissionSection + ' input#s2member-pro-paypal-checkout-submit').replaceWith (submitExpressCheckoutButton);
								/**/
								(eventTrigger) ? $(billingAddressSection + ' input#s2member-pro-paypal-checkout-state').focus () : null;
							}
						else if (!billingMethod || billingMethod === 'PayPal')
							{
								$(billingMethodSection + ' > div.s2member-pro-paypal-checkout-form-div').hide ();
								$(billingMethodSection + ' > div.s2member-pro-paypal-checkout-form-div :input').attr (ariaFalse);
								/**/
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-type-div').show ();
								$(billingMethodSection + ' > div#s2member-pro-paypal-checkout-form-card-type-div :input').attr (ariaTrue);
								/**/
								$(billingAddressSection + ' > div.s2member-pro-paypal-checkout-form-div').hide ();
								$(billingAddressSection + ' > div.s2member-pro-paypal-checkout-form-div :input').attr (ariaFalse);
								/**/
								$(billingAddressSection).hide (), $(submissionSection + ' input#s2member-pro-paypal-checkout-submit').replaceWith (submitExpressCheckoutButton);
								/**/
								(eventTrigger) ? $(submissionSection + ' input#s2member-pro-paypal-checkout-submit').focus () : null;
							}
					}) ();
				/**/
				$(cardType).click (handleBillingMethod).change (handleBillingMethod);
				/**/
				$(couponApplyButton).click (function() /* Only applying coupon. */
					{
						$(submissionNonceVerification).val ('apply-coupon'), $coForm.submit ();
					});
				/**/
				$(registrationSection + ' > div#s2member-pro-paypal-checkout-form-password-div :input').keyup (function()
					{
						ws_plugin__s2member_passwordStrength($(registrationSection + ' input#s2member-pro-paypal-checkout-username'), $(registrationSection + ' input#s2member-pro-paypal-checkout-password1'), $(registrationSection + ' input#s2member-pro-paypal-checkout-password2'), $(registrationSection + ' div#s2member-pro-paypal-checkout-form-password-strength'));
					});
				/**/
				$coForm.submit (function() /* Form validation. */
					{
						if ($(submissionNonceVerification).val () !== 'apply-coupon')
							{
								var context = this, label = '', error = '', errors = '';
								/**/
								var $recaptchaResponse = $(captchaSection + ' input#recaptcha_response_field');
								/**/
								var $password1 = $(registrationSection + ' input#s2member-pro-paypal-checkout-password1[aria-required="true"]');
								var $password2 = $(registrationSection + ' input#s2member-pro-paypal-checkout-password2');
								/**/
								if (!$(cardType + ':checked').val ())
									{
										$(cardType).val (['PayPal']);
									}
								/**/
								$(':input', context).each (function() /* Go through them all together. */
									{
										var id = $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, ''); /* Remove numeric suffixes. */
										/**/
										if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().children ('span').first ().text ().replace (/[\r\n\t]+/g, ' '))))
											{
												if (error = ws_plugin__s2member_validationErrors(label, this, context))
													errors += error + '\n\n'; /* Collect errors. */
											}
									});
								/**/
								if (errors = $.trim (errors))
									{
										alert('— Oops, you missed something: —\n\n' + errors);
										/**/
										return false;
									}
								/**/
								else if ($password1.length && $.trim ($password1.val ()) !== $.trim ($password2.val ()))
									{
										alert('— Oops, you missed something: —\n\nPasswords do not match up. Please try again.');
										/**/
										return false;
									}
								/**/
								else if ($recaptchaResponse.length && !$recaptchaResponse.val ())
									{
										alert('— Oops, you missed something: —\n\nSecurity Code missing. Please try again.');
										/**/
										return false;
									}
							}
						/**/
						$(submissionButton).attr (disabled), ws_plugin__s2member_animateProcessing($(submissionButton)), $(couponApplyButton).attr (disabled);
						/**/
						return true;
					});
			}
		/**/
		(jumpToResponses = function() /* Jump to form responses. */
			{
				$('div#s2member-pro-paypal-form-response').each (function()
					{
						var offset = $(this).offset ();
						window.scrollTo (0, offset.top - 100);
					});
			}) ();
	});