BeanstalkConnectionStream Interface Ref
=======================================

.. php:interface:: BeanstalkConnectionStream

.. topic:: Class Methods

    * :php:meth:`BeanstalkConnectionStream::close` -- Close the stream connection
    * :php:meth:`BeanstalkConnectionStream::isTimedOut` -- Has the connection timed out or otherwise gone away?
    * :php:meth:`BeanstalkConnectionStream::open` -- Open the stream
    * :php:meth:`BeanstalkConnectionStream::read` -- Read the next $bytes bytes from the stream
    * :php:meth:`BeanstalkConnectionStream::readLine` -- Read the next line from the stream
    * :php:meth:`BeanstalkConnectionStream::write` -- Write data to the stream

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


