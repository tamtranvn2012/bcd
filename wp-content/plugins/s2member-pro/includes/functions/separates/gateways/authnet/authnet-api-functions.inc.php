<?php
/**
* Authorize.Net® API Functions *( for site owners )*.
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
* @package s2Member\API_Functions
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**
* Verifies `s2p-v` in a given query string argument; from a custom URL for success.
*
* This can be used for verifying the integrity of variables in a success query string.
* Example usage: ``if(s2member_pro_authnet_s2p_v_query_ok($_SERVER["QUERY_STRING"])){ }``
*
* @package s2Member\API_Functions
* @since 1.5
*
* @param str $qs Optional. Defaults to ``$_SERVER["QUERY_STRING"]``.
* @param book $ignore_timestamp Optional. If true, timestamp is ignored. Defaults to false.
* @return bool True if the query string is OK/verified, else false.
*/
if (!function_exists ("s2member_pro_authnet_s2p_v_query_ok"))
	{
		function s2member_pro_authnet_s2p_v_query_ok ($qs = FALSE, $ignore_timestamp = FALSE)
			{
				return c_ws_plugin__s2member_pro_authnet_utilities::authnet_s2p_v_query_ok ($qs, $ignore_timestamp);
			}
	}
?>