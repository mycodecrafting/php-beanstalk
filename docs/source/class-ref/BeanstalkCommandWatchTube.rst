Beanstalk\\Command\\WatchTube Class Ref
=======================================

.. php:namespace:: Beanstalk\Command

.. php:class:: WatchTube

    :Extends: :php:class:`Beanstalk\\Command`
    :Description: Watch command
    :Author: Joshua Dechant <jdechant@shapeup.com>


    The "watch" command adds the named tube to the watch list for the current
    connection. A reserve command will take a job from any of the tubes in the
    watch list. For each new connection, the watch list initially consists of one
    tube, named "default".

.. topic:: Class Methods

    * :php:meth:`WatchTube::__construct` -- Constructor
    * :php:meth:`WatchTube::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`WatchTube::parseResponse` -- Parse the response for success or failure.

.. php:method:: __construct( $tube )

    :Description: Constructor
    :param string $tube: Tube to add to the watch list. If the tube doesn't exist, it will be created
    :throws: *BeanstalkException* When $tube exceeds 200 bytes

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param Beanstalk\Connection $conn: BeanstalkConnection use to send the command
    :returns: *integer* The number of tubes being watched
    :throws: *BeanstalkException* When any error occurs


