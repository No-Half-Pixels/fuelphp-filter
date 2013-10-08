<?php

/**
 * Filter: WordPress like filters library for FuelPHP.
 *
 * @package    Filter
 * @version    v1.0.0
 * @author     Lee Mason
 * @license    MIT License
 * @copyright  2013 Lee Mason
 * @link       http://github.com/leemason/fuelphp-filter
 */

Autoloader::add_classes(array(
	'Filter'                => __DIR__.'/classes/extensions/filter.php',
	'Filter_Instance'       => __DIR__.'/classes/extensions/filter/instance.php',
));

/* End of file bootstrap.php */
