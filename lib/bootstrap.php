<?php
/**
 * Bootstrap Silex
 *
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex;


// require_once 'corefunctions.php';

// Register silex autoloader
require_once 'Autoloader.php';
Autoloader::register();

// User configuration
if (!is_file('lib/config.json'))
	trigger_error('Your config file is missing.', E_USER_ERROR);
$config = json_decode(file_get_contents('lib/config.json'));

// Error and exception handler
set_error_handler(['silex\\Silex', 'errorHandler'], E_ALL);
set_exception_handler(['silex\\Silex', 'exceptionHandler']);

// Initiate database
database\Factory::init($config);

// Initiate configuration
Config::init();

// Load modules
Modules::load(new ModuleLoader('lib/modules/'));

Silex::init();
