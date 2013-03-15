BeanstalkException Class Ref
============================

.. php:class:: BeanstalkException

    Beanstalk Exceptions

    :extends: :php:class:`Exception`

.. topic:: Class Methods

    * :php:meth:`BeanstalkException::__construct`
    * :php:meth:`BeanstalkException::__toString`
    * :php:meth:`BeanstalkException::getCode`
    * :php:meth:`BeanstalkException::getCodeAsString` -- Get a string representation of a given code
    * :php:meth:`BeanstalkException::getFile`
    * :php:meth:`BeanstalkException::getLine`
    * :php:meth:`BeanstalkException::getMessage`
    * :php:meth:`BeanstalkException::getPrevious`
    * :php:meth:`BeanstalkException::getTrace`
    * :php:meth:`BeanstalkException::getTraceAsString`

.. php:method:: __construct( $message [ , $code = 0 , $previous = null ] )

    :param mixed $message:
    :param mixed $code:
    :param Exception $previous:

.. php:method:: __toString(  )

.. php:method:: getCode(  )

.. php:method:: getCodeAsString(  )

    Get a string representation of a given code

    :returns: *string*

.. php:method:: getFile(  )

.. php:method:: getLine(  )

.. php:method:: getMessage(  )

.. php:method:: getPrevious(  )

.. php:method:: getTrace(  )

.. php:method:: getTraceAsString(  )
