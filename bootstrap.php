<?php

/**
 * Filter: WordPress like filter system for FuelPHP utilizing the core Event class.
 *
 * @package    Filter
 * @version    v1.0.0
 * @author     Lee Mason
 * @license    MIT License
 * @copyright  2013 Lee Mason
 * @link       http://github.com/leemason/fuelphp-filter
 */


Autoloader::add_core_namespace('Filter');

Autoloader::add_classes(array(
	'Filter\\Filter'                => __DIR__.'/classes/filter.php',
	'Filter\\Filter_Instance'          => __DIR__.'/classes/filter/instance.php',
));

/* End of file bootstrap.php */