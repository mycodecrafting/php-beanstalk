BeanstalkConnectionStreamSocket Class Ref
=========================================

.. php:class:: BeanstalkConnectionStreamSocket

    :Implements: :php:interface:`BeanstalkConnectionStream`
    :Description: Connection stream using PHP native sockets
    :Author: Joshua Dechant <jdechant@shapeup.com>


.. topic:: Class Methods

    * :php:meth:`BeanstalkConnectionStreamSocket::close` -- Close the stream connection
    * :php:meth:`BeanstalkConnectionStreamSocket::isTimedOut` -- Has the connection timed out or otherwise gone away?
    * :php:meth:`BeanstalkConnectionStreamSocket::open` -- Open the stream
    * :php:meth:`BeanstalkConnectionStreamSocket::read` -- Read the next $bytes bytes from the stream
    * :php:meth:`BeanstalkConnectionStreamSocket::readLine` -- Read the next line from the stream
    * :php:meth:`BeanstalkConnectionStreamSocket::write` -- Write data to the stream

.. php:method:: close(  )

    :Description: Close the stream connection
    :returns: *null*

.. php:method:: isTimedOut(  )

    :Description: Has the connection timed out or otherwise gone away?
    :returns: *boolean*

.. php:method:: open( $host , $port , $timeout )

    :Description: Open the stream
    :param string $host: Host or IP address to connect to
    :param integer $port: Port to connect on
    :param float $timeout: Connection timeout in milliseconds
    :returns: *boolean*

.. php:method:: read( $bytes )

    :Description: Read the next $bytes bytes from the stream
    :param integer $bytes: Number of bytes to read
    :returns: *string*

.. php:method:: readLine(  )

    :Description: Read the next line from the stream
    :returns: *string*

.. php:method:: write( $data )

    :Description: Write data to the stream
    :param string $data: 
    :returns: *integer* Number of bytes written


