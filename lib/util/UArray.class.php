<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class UArray {
	/**
	 * Searches the array for a given value and returns the corresponding key(s) if successful
	 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
	 * @param  mixed $needle
	 * @param  array $haystack
	 * @param  bool  $strict = false
	 * @return mixed
	 */
	public static function searchAll($needle, array $haystack, $strict = false) {
		$founds = [];
		foreach($haystack as $key => $value) {
			if(!$strict && $value == $needle)
				$founds[] = $key;
			else if($strict && $value === $needle)
				$founds[] = $key;
		}
		return empty($founds) ? false : $founds;
	}

	public static function toArray($arrObjData, $arrSkipIndices = []) {
		$arrData = [];

		// if input is object, convert into array
		if(is_object($arrObjData)) {
			$arrObjData = get_object_vars($arrObjData);
		}

		if(is_array($arrObjData)) {
			foreach ($arrObjData as $index => $value) {
				if(is_object($value) || is_array($value)) {
					$value = self::toArray($value, $arrSkipIndices); // recursive call
				}
				if(in_array($index, $arrSkipIndices)) {
					continue;
				}
				$arrData[$index] = $value;
			}
		}
		return $arrData;
	}
}
