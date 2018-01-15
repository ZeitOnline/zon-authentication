<?php
/**
 * @package ZON_Authors_Widget
 *
 * Plugin Name:       ZEIT ONLINE Authentication for SSO
 * Plugin URI:        https://github.com/ZeitOnline/zon-authentication
 * Description:       Adds the ability to decode the signed SSO-Cookie
 * Version:           1.2.0
 * Author:            ZEIT ONLINE
 * Author URI:        http://www.zeit.de
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * GitHub Plugin URI: https://github.com/ZeitOnline/zon-authentication
*/

require_once 'BeforeValidException.php';
require_once 'ExpiredException.php';
require_once 'JWT.php';
require_once 'SignatureInvalidException.php';


$z_auth_key = <<<END
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuEvxV4M3Asb6jnyXOn5y
8Tv4SsYKpEESK3tLC9zsOhRdUjYfHWkq5Z/o0zHJBxw4u4CuHMFlAFqr1CoCiT9J
33R01gM3p1en4/rNWBKrUn5RzimSLcX/kzR+a0t9tO5zrFVYYwG6+kF9iIJ4xprV
RlILrwJ8FonUxLKQytqmtRtTBp7B+W3vxHyJsuVRcOwwT4vQA0yNrOmCeToAxOKO
DOmpuUnhV+1BSSjtL+x8aRZc68FWKVGC/GW1/jH849ga//JDjGfyKxlhukwpF3o6
SELF30tJ8GwY+KDkFefJc73uj7LvvHl08XVVlznSUVaGqc6bWG8DzDO9FGAdFT+H
GQIDAQAB
-----END PUBLIC KEY-----
END;

$z_auth_service_url = "https://meine.zeit.de/api/1/users";


/**
 * Tries to decode the given session.
 *
 * @return object
 *   An object with decoded session data
 */
function z_auth_decode_master_cookie() {
	static $userData = null;

	if ( isset( $_COOKIE[ 'zeit_sso_201501' ] ) && !isset( $userData ) ) {
		try {
			$userData = JWT::decode($_COOKIE[ 'zeit_sso_201501' ], $GLOBALS['z_auth_key']);
		}
		catch (Exception $e) {
		}
	}

	return $userData;
}
