<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * One class to rule them all
 */
class Silex {
	/**
	 * @var Database
	 */
	protected static $db = null;
	protected static $config = null;
	protected static $event = null;
	protected static $modules = null;

	/**
	 * Start Silex up!
	 */
	public final function __construct() {
		if(self::isDebug())
			header('Content-Type: text/plain; charset=utf-8');

		// Read config file
		if(!is_file(DIR_LIB.'config.inc.php'))
			throw new CoreException('Y U NO HAVE A CONFIG FILE?!', 0, 'Your config file can\'t be found.');
		$config = require_once DIR_LIB.'config.inc.php';

		self::$db = DatabaseFactory::initDatabase(
			$config['database.wrapper'],
			$config['database.host'],
			$config['database.user'],
			$config['database.password'],
			$config['database.name'],
			$config['database.port']);
		self::$config = new Config($config);

		self::$event = new Event();
		self::$modules = new Modules(DIR_LIB.'modules/');
	}

	/**
	 * Access to database instance
	 * @return Database
	 */
	public static final function getDB() {
		return self::$db;
	}

	/**
	 * Get the config instance
	 * @return Config
	 */
	public static final function getConfig() {
		//return self::$config->get($node);
		return self::$config;
	}

	/**
	 * Access the event instance
	 * @return Event
	 */
	public static final function getEvent() {
		return self::$event;
	}

	/**
	 * @return bool
	 */
	public static final function isDebug() {
		return DEBUG;
	}

	/**
	 * Handle our Exceptions
	 * @param Exception $e
	 */
	public static final function handleException(Exception $e) {
		if($e instanceof IPrintableException) {
			$e->show();
			exit;
		}

		// Repack Exception
		self::handleException(new CoreException($e->getMessage(), $e->getCode(), '', $e));
	}

	/**
	 * Catches php errors and throws instead a system exceptions
	 * @param integer $errorNo
	 * @param string  $message
	 * @param string  $filename
	 * @param integer $lineNo
	 * @throws CoreException
	 */
	public static final function handleError($errorNo, $message, $filename, $lineNo) {
		if(error_reporting() != 0) {
			$type = 'errors';
			switch($errorNo) {
				case 2:
					$type = 'warning';
					break;
				case 8:
					$type = 'notice';
					break;
			}
			throw new CoreException('PHP '.$type.' in file '.$filename.' ('.$lineNo.'): '.$message, 0);
		}
	}
}