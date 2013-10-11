BeanstalkCommandIgnore Class Ref
================================

.. php:class:: BeanstalkCommandIgnore

    :Extends: :php:class:`BeanstalkCommand`
    :Description: Ignore command
    :Author: Joshua Dechant <jdechant@shapeup.com>


    The "ignore" command is for consumers. It removes the named tube from the
    watch list for the current connection.

.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandIgnore::__construct` -- Constructor
    * :php:meth:`BeanstalkCommandIgnore::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandIgnore::parseResponse` -- Parse the response for success or failure.

.. php:method:: __construct( $tube )

    :Description: Constructor
    :param string $tube: Tube to remove from the watch list

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data received with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *integer* The number of tubes being watched
    :throws: *BeanstalkException* When the requested tube cannot be ignored
    :throws: *BeanstalkException* When any error occurs


