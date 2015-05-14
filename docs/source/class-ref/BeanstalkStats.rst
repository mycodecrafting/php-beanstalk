Beanstalk\\Stats Class Ref
==========================

.. php:namespace:: Beanstalk

.. php:class:: Stats

.. topic:: Class Methods

    * :php:meth:`Stats::__construct` -- Constructor
    * :php:meth:`Stats::getStat` -- Get the value of a given stat
    * :php:meth:`Stats::getStats` -- Get all the stats as an array
    * :php:meth:`Stats::setStat` -- Set a stat to a given value

.. php:method:: __construct( [ $data = null ] )

    :Description: Constructor
    :param string $data: Set stats from input data in the form "stat-1: value\nstat-2: value"

.. php:method:: getStat( $stat )

    :Description: Get the value of a given stat
    :param string $stat: Stat name to get the value of
    :returns: *string* Stat's value
    :returns: *boolean* false when value not set

.. php:method:: getStats(  )

    :Description: Get all the stats as an array
    :returns: *array* ( 'stat1-name' => 'value' , 'stat2-name' => 'value' , ... )

.. php:method:: setStat( $stat , $value )

    :Description: Set a stat to a given value
    :param string $stat: 
    :param string $value: 
    :returns: *null*


