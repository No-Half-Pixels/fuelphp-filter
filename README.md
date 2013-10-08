Filter
======

WordPress like filter system for FuelPHP utilizing the core Event class.

Installation
------------

### Using oil
1. cd to your fuel project's root
2. Run `php oil package install filter`
3. Optionally edit fuel/packages/filter/config/filter.php (this file allows you to add filters from the config file, but use the package where and when you want)
4. Add 'filter' to the 'always_load/packages' array in app/config/config.php (or call `Fuel::add_package('filter')` whenever you want to use it).
5. Enjoy :)

### Manual (may be more up-to-date)
1. Clone (`git clone git://github.com/leemason/fuelphp-filter`) / [download](https://github.com/leemason/fuelphp-filter/zipball/master)
2. Stick in fuel/packages/ (or any custom package location you have setup)
3. Optionally edit fuel/packages/filter/config/filter.php (this file allows you to add filters from the config file, but use the package where and when you want)
4. Add 'filter' to the 'always_load/packages' array in app/config/config.php (or call `Fuel::add_package('filter')` whenever you want to use it).
5. Enjoy :)

If you don't want to change the config file in `fuel/packages/filter/config/filter.php`, you can create your own config file in `fuel/app/config/filter.php`.
You can either copy the entirely of the original config file, or just override the keys as you like.
The magic of Fuel's `Config` class takes care of the rest.

Introduction
------------

Filter is a WordPress like filter system for managing vars. It boasts the following features:

- Custom instances can be created.
- Passed values can be anything sensible.
- Filters can be added/removed.
- Filters are used in the order they are added (the opposite of the core Event class, but of course can be overwritten when triggering).

Basic usage
-----------

Filter works just like the core Event class, with 2 subtle differences:

1. Filters are run in the order they are added*
2. ```phpFilter::trigger()``` will return the result from the hooked functions (or closures).

* This can be "reversed" just like the core Event class to run the filters in reverse order.

**IMPORTANT** All methods sent the filter event should return its data.

For full reference please see the Event class docs here: http://fuelphp.com/docs/classes/event.html

Registering filter methods is easy, they can be closures, or callbacks just like the core Event class:

```php
Filter::register('filtername', function($data){
    //do something here
    $data['filter1'] = 'somedata';
    return $data;
});

Filter::register('filtername', function($data){
    //do something else here
    //maybe unset a result set above?
    unset($data['filter1']);
    return $data;
});
```

Triggering is again the same as the core Event, you can pass any data:

```php
$result = Filter::trigger($filtername, $data, $reverse);

//result is an array
$result = Filter::trigger('filtername', array('some' => 'data'));

//result is a string
$result = Filter::trigger('filtername', 'this is a string being passed and reversed too!', true);
```


Thanks
------

The following people have helped Casset become what it is, so thank you!

 - [FuelPHP](https://fuelphp.com)

Contributing
------------

If you've got any issues/complaints/suggestions, please tell me and I'll do my best!

Pull requests are also gladly accepted.
