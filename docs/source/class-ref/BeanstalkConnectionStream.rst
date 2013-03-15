BeanstalkConnectionStream Class Ref
===================================

.. php:interface:: BeanstalkConnectionStream

.. topic:: Interface Methods

    * :php:meth:`BeanstalkConnectionStream::close` -- Close the stream connection
    * :php:meth:`BeanstalkConnectionStream::isTimedOut` -- Has the connection timed out?
    * :php:meth:`BeanstalkConnectionStream::open` -- Open the stream
    * :php:meth:`BeanstalkConnectionStream::read` -- Read the next $bytes bytes from the stream
    * :php:meth:`BeanstalkConnectionStream::readLine` -- Read the next line from the stream
    * :php:meth:`BeanstalkConnectionStream::write` -- Write data to the stream

.. php:method:: close(  )

    Close the stream connection

    :returns: *void*

.. php:method:: isTimedOut(  )

    Has the connection timed out?

    :returns: *boolean*

.. php:method:: open( $host , $port )

    Open the stream

    :param string $host: Host or IP address to connect to
    :param integer $port: Port to connect on
    :returns: *boolean*

.. php:method:: read( $bytes )

    Read the next $bytes bytes from the stream

    :param integer $bytes: Number of bytes to read
    :returns: *string*

.. php:method:: readLine(  )

    Read the next line from the stream

    :returns: *string*

.. php:method:: write( $data )

    Write data to the stream

    :param string $data: 
    :returns: *integer*  Number of bytes written
