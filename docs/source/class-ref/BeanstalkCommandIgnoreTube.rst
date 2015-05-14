Beanstalk\\Command\\IgnoreTube Class Ref
========================================

.. php:namespace:: Beanstalk\Command

.. php:class:: IgnoreTube

    :Extends: :php:class:`Beanstalk\\Command`
    :Description: Ignore command
    :Author: Joshua Dechant <jdechant@shapeup.com>


    The "ignore" command is for consumers. It removes the named tube from the
    watch list for the current connection.

.. topic:: Class Methods

    * :php:meth:`IgnoreTube::__construct` -- Constructor
    * :php:meth:`IgnoreTube::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`IgnoreTube::parseResponse` -- Parse the response for success or failure.

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
    :param Beanstalk\Connection $conn: BeanstalkConnection use to send the command
    :returns: *integer* The number of tubes being watched
    :throws: *\Beanstalk\Exception* When the requested tube cannot be ignored
    :throws: *\Beanstalk\Exception* When any error occurs


