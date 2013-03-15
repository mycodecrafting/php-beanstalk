Beanstalk Class Ref
===================

.. php:class:: Beanstalk

    Implements the Beanstalk Protocol

    .. sourcecode:: php

        <?php
        $bean = Beanstalk::init(); // returns BeanstalkPool instance
        $bean->addServer('localhost', 11300);
        $bean->use('my-tube');
        $bean->put('Hello World!');

.. topic:: Class Methods

    * :php:meth:`Beanstalk::autoload` -- Autoload beanstalk classes
    * :php:meth:`Beanstalk::init` -- Init the beanstalkd pool

.. php:staticmethod:: autoload( $className )

    Autoload beanstalk classes

    :param mixed $className:

.. php:staticmethod:: init( )

    Init the beanstalkd pool

    :returns: :php:class:`BeanstalkPool`
