<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Utility methods for strings
 */
class StringUtil {
	/**
	 * We use SHA1
	 * @param  string $string
	 * @return string Hash
	 */
	public static function getHash($string) {
		return sha1($string);
	}

	/**
	 * Convert special HTML chars
	 * @param  string $string
	 * @return string
	 */
	public static function encodeHTML($string) {
		return @htmlspecialchars($string, ENT_COMPAT | ENT_HTML5, 'UTF-8');
	}

	/**
	 * urlencode without touching the slashes
	 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
	 * @param string $string
	 * @return string
	 */
	public static function urlEncodeSlashes($string) {
		if(preg_match('/^(?<scheme>[a-z][a-z0-9+\-.]*:\/\/)/ix', $url, $m)) {
			$newURL = $m['scheme'];
			$url = explode('/', substr($url, strlen($newURL)));
			for($i = 0; $i < sizeof($url); $i++)
				$newURL .= urlencode($url[$i]).(($i < sizeof($url) - 1) ? '/' : '');
			return $newURL;
		}
		return urlencode($url);
	}

	/**
	 * rawurlencode without touching the slashes
	 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
	 * @param  string $url
	 * @return string
	 */
	public static function rawurlencode_slashes($url) {
		if(preg_match('/^(?<scheme>[a-z][a-z0-9+\-.]*:\/\/)/ix', $url, $m)) {
			$newURL = $m['scheme'];
			$url = explode('/', substr($url, strlen($newURL)));
			for($i = 0; $i < sizeof($url); $i++)
				$newURL .= rawurlencode($url[$i]).(($i < sizeof($url) - 1) ? '/' : '');
			return $newURL;
		}
		return rawurlencode($url);
	}

	/**
	 * Can we find the needle in the haystack?
	 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
	 * @param string $haystack
	 * @param string $needle
	 * @return bool
	 */
	public static function strfind($haystack, $needle) {
		return strpos($haystack, $needle) !== false;
	}
}
