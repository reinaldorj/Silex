<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Language {
	/**
	 * Language ID according to ISO 639-1 and ISO 3166
	 * @var string
	 */
	protected $id = '';

	// Title and description in the language pack's language
	protected $name = '';
	protected $description = '';

	// Title and description in English
	protected $nameEn = '';
	protected $descriptionEn = '';

	/**
	 * The array holding all language data
	 * @var array
	 */
	protected $languageDump = [];

	/**
	 * @param string $languageID Language ID
	 * @param string $customPath Custom path to search for lang files in
	 * @throws LanguageNotFoundException
	 */
	public function __construct($languageID, $customPath = '') {
		if(empty($customPath))
			$customPath = DIR_LANGUAGE;

		// Wrong naming
		if(!preg_match('/^[a-z]{2}-[A-Z]{2}$/', $languageID)) {
			throw new LanguageNotFoundException();
		}

		// Try to open the info file
		if(file_exists($customPath.$languageID) && file_exists($customPath.$languageID.'/'.$languageID.'.info.xml') && file_exists($customPath.$languageID.'/'.$languageID.'.lang.xml')) {
			/* Read info */
			$infoArray = (array)simplexml_load_file($customPath.$languageID.'/'.$languageID.'.info.xml');

			$this->id =            $infoArray['id'];
			$this->name =          $infoArray['name'];
			$this->description =   $infoArray['description'];
			$this->nameEn =        $infoArray['name-en'];
			$this->descriptionEn = $infoArray['description-en'];

			/* Read language */ // TODO: Only read on demand, e.g. only when somebody really gets lang vars
			$this->languageDump = (new XML($customPath.$languageID.'/'.$languageID.'.lang.xml'))->asArray();

		} else {
			throw new LanguageNotFoundException();
		}
	}

	/**
	 * @param string $var Language variable
	 * @return string|null
	 */
	public function getVar($var) {
		// Explode
		$var_arr = explode('.', $var);

		// temporary array
		$tmp = $this->languageDump;

		// Try to get the string, recurse deeper and deeper ...
		foreach($var_arr as $cur) {
			if(isset($tmp[$cur])) {
				$tmp = $tmp[$cur];
			}
			else {
				$tmp = null;
				break;
			}
		}

		return $tmp;
	}

}