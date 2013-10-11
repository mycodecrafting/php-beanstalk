Beanstalk Class Ref
===================

.. php:class:: Beanstalk

    :Description: Implements the Beanstalk Protocol
    :Author: Joshua Dechant <jdechant@shapeup.com>


    .. sourcecode:: php

        $bean = Beanstalk::init(); // returns BeanstalkPool instance
        $bean->addServer('localhost', 11300);
        $bean->use('my-tube');
        $bean->put('Hello World!');

.. topic:: Class Methods

    * :php:meth:`Beanstalk::autoload` -- Autoload beanstalk classes
    * :php:meth:`Beanstalk::init` -- Init the beanstalkd pool

.. php:staticmethod:: autoload( $className )

    :Description: Autoload beanstalk classes
    :param mixed $className:

.. php:staticmethod:: init(  )

    :Description: Init the beanstalkd pool
    :returns: *BeanstalkPool*


