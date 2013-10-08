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

namespace Filter;

class Filter_Instance
{

	/**
	 * @var	array	An array of listeners
	 */
	protected $_events = array();

	// --------------------------------------------------------------------

	/**
	 * Constructor, sets all initial events.
	 *
	 * @param  array  $events  events array
	 */
	public function __construct(array $events = array())
	{
		foreach($events as $event => $callback)
		{
			$this->register($event, $callback);
		}
	}


	// --------------------------------------------------------------------

	/**
	 * Register
	 *
	 * Registers a Callback for a given event
	 *
	 * @access	public
	 * @param	string	The name of the event
	 * @param	mixed	callback information
	 * @return	void
	 */
	public function register()
	{
		// get any arguments passed
		$callback = func_get_args();

		// if the arguments are valid, register the event
		if (isset($callback[0]) and is_string($callback[0]) and isset($callback[1]) and is_callable($callback[1]))
		{
			// make sure we have an array for this event
			isset($this->_events[$callback[0]]) or $this->_events[$callback[0]] = array();

			if (empty($callback[2]))
			{
				array_unshift($this->_events[$callback[0]], $callback);
			}
			else
			{
				$this->_events[$callback[0]][] = $callback;
			}

			// and report success
			return true;
		}
		else
		{
			// can't register the event
			return false;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unregister/remove one or all callbacks from event
	 *
	 * @param   string   $event     event to remove from
	 * @param   mixed    $callback  callback to remove [optional, null for all]
	 * @return  boolean  wether one or all callbacks have been removed
	 */
 	public function unregister($event, $callback = null)
	{
		if (isset($this->_events[$event]))
		{
			if ($callback === null)
			{
				unset($this->_events[$event]);
				return true;
			}

			foreach ($this->_events[$event] as $i => $arguments)
			{
				if($callback === $arguments[1])
				{
					unset($this->_events[$event][$i]);
					return true;
				}
			}
		}

		return false;
	}

	// --------------------------------------------------------------------

	/**
	 * Trigger
	 *
	 * Triggers an event and returns the results.  The results can be returned
	 * in the following formats:
	 *
	 * 'array'
	 * 'json'
	 * 'serialized'
	 * 'string'
	 *
	 * @access	public
	 * @param	string	 The name of the event
	 * @param	mixed	 Any data that is to be passed to the listener
	 * @param	string	 The return type
	 * @param   boolean  Wether to fire events ordered LIFO instead of FIFO
	 * @return	mixed	 The return of the listeners, in the return type
	 */
	public function trigger($event, $data = '', $reversed = false)
	{
		$calls = array();

		// check if we have events registered
		if ($this->has_events($event))
		{
			$events = !$reversed ? array_reverse($this->_events[$event], true) : $this->_events[$event];

			// process them
			foreach ($events as $arguments)
			{
				// get rid of the event name
				array_shift($arguments);

				// get the callback method
				$callback = array_shift($arguments);

				// call the callback event
				if (is_callable($callback))
				{
					$data = call_user_func($callback, $data, $arguments);
				}
			}
		}
        return $data;
	}

	// --------------------------------------------------------------------

	/**
	 * Has Listeners
	 *
	 * Checks if the event has listeners
	 *
	 * @access	public
	 * @param	string	The name of the event
	 * @return	bool	Whether the event has listeners
	 */
	public function has_events($event)
	{
		if (isset($this->_events[$event]) and count($this->_events[$event]) > 0)
		{
			return true;
		}
		return false;
	}

}